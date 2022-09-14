<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCustomerRegisFace extends MX_Controller {

    public $tTokenAPI;
    public $tURLAPI;

    public function __construct(){
        parent::__construct();
        $this->load->model('customer/customerRegisFace/mCustomerRegisFace');

        //รหัสบริษัท
        $aCompany       = $this->mCustomerRegisFace->FSaMCstGetCompany();
        $tComCode       = $aCompany['raItems'][0]['FTCmpCode'];
        $aURLAPI        = $this->mCustomerRegisFace->FSaMCstGetConfigAPI($tComCode);
        if($aURLAPI['rtCode'] == 800){
            //Defulat URL
            // $this->tURLAPI  = 'http://172.16.30.243:2002/API2RDFaceRegister/V1/';
            echo 'ConfigFail';
            exit;
        }else{
            //URL จาก ตาราง TCNTUrlObject
            $this->tURLAPI  = $aURLAPI['raItems'][0]['FTUrlAddress'];
        }
    }

    //สร้างรหัส Token มาก่อน
    public function FSxCstRGFCallAPIToken(){
        // $login      = 'Admin';
        // $password   = 'Admin';
        // $url        = $this->tURLAPI . 'ADA_GetToken';
        // $ch         = curl_init();
        // curl_setopt($ch, CURLOPT_URL,$url);
        // curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
        // curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "POST");
        // curl_setopt($ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC);
        // curl_setopt($ch, CURLOPT_USERPWD, "$login:$password");
        // $result = curl_exec($ch);
        // curl_close($ch);  
        // $aData = json_decode($result);

        //สร้างรหัส Token บรรทัดแรก คือวันปัจจุบัน / บรรทัดที่สองคือรหัส Token
		$tPath = "application/logs/Token.txt";
		$myfile = fopen($tPath,'w') or die("Die");
		$tTextConfig = date("d")."\n";
		$tTextConfig .= 'eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJwdERhdGVFeHAiOiIyMDMwLTEyLTMxIDIzOjAwOjAwLjAwMDAwMCIsInB0QWduQ29kZSI6IjIwMjAwNzExNjYzMTc2ODAiLCJwdFJhbmRvbUtleSI6IjVFRkRERjQyODg4QUMifQ.oaTjaPZ6DnWalH4w--IxjNgop62ZJzyU71XrDOwBPKY';
        fwrite($myfile,$tTextConfig);
        fclose($myfile);
    }

    //ฟังก์ชั่นหลักในการ Call API
    private function FSaAPICall($ptURLAPI, $ptMethod, $oParamet = ''){
        //เช็คไฟล์
        $tPath = "application/logs/Token.txt";
        if( file_exists($tPath)){
            //มีไฟล์;
            $tFile      = fopen($tPath,"r");
            $aToken     = array();
            while(!feof($tFile)){
                $aToken[] = fgets($tFile);
            }
            fclose($tFile);
            $tToken  = $aToken[1];
        }else{
            //ไม่มีไฟล์;
            $this->FSxCstRGFCallAPIToken();
            $tFile      = fopen($tPath,"r");
            $aToken     = array();
            while(!feof($tFile)){
                $aToken[] = fgets($tFile);
            }
            fclose($tFile);
            $tToken     =  $aToken[1];
        }

        // echo trim($this->tURLAPI).$ptURLAPI;
        //URL API
        if($ptURLAPI == 'ADA_Recog'){
            $aExplode       = explode(":",trim($this->tURLAPI));
            $aChangePort    = explode("/",trim($aExplode[2]));
            
            $tURLAPI =  'http:'.$aExplode[1].':2001/API2RDFace/V1/'.$ptURLAPI;
        }else{
            $tURLAPI = trim($this->tURLAPI).'/'.$ptURLAPI;
        }

        $tCurlEx = curl_init(trim($tURLAPI));
		curl_setopt($tCurlEx, CURLOPT_CUSTOMREQUEST, "$ptMethod");
		curl_setopt($tCurlEx, CURLOPT_POSTFIELDS, $oParamet);
		curl_setopt($tCurlEx, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($tCurlEx, CURLOPT_HTTPHEADER, array(
			'Content-Type:application/json',
			"Authorization:$tToken",
			'Content-Length:' . strlen($oParamet))
		);
		curl_setopt($tCurlEx, CURLOPT_TIMEOUT, 36000);
        curl_setopt($tCurlEx, CURLOPT_CONNECTTIMEOUT, 36000);
        
		//execute post
        $oResult = curl_exec($tCurlEx);
		try{
			if($oResult === false) {
				return 'Curl error: ' . curl_error($tCurlEx);
			}else{
				return json_decode($oResult, true);
			}
		}catch (Exception $e) {
			return 'Service down.';
		}
    }
    
    //ส่งรูปไปเช็ค กับ API
    public function FSxCstRGFCallAPIMain(){

        //รหัสบริษัท
        $aCompany = $this->mCustomerRegisFace->FSaMCstGetCompany();

        //รหัสลูกค้า
        $tCustomerCode = $this->input->post('CustomerCode');

        $tTable = $this->input->post('tTable');
        switch($tTable){
            case "TCNMCrdLogin":
                $tPathIns =  'payment';
            break;
            case "TCNMCst":
                $tPathIns =  'customer';
            break;
        }

        //ลำดับรูปภาพ
        $nSeq = $this->mCustomerRegisFace->FSaMCstGetSeqImage($tCustomerCode);
        if($nSeq['rtCode'] == 800){
            $nSeq = 1;
        }else{
            $nSeq = (int)$nSeq['raItems'][0]['FNImgSeq'] + 1;
        }

        //Image Convert ให้เป็น Jpeg
        $tPathImage = $this->input->post('ImageFullPath');
        $tNameImage = $this->input->post('ImageName');
        $aNewPath = explode('application/modules',$tPathImage);

        $path   = $tPathImage;
        $img    = base_url()."application/modules".$aNewPath[1].'/'.$tNameImage;

        if (($img_info = getimagesize($img)) === FALSE)
          die("Image not found or not an image");
        
        $width = $img_info[0];
        $height = $img_info[1];
        
        switch ($img_info[2]) {
          case IMAGETYPE_GIF  : $src = imagecreatefromgif($img);  break;
          case IMAGETYPE_JPEG : $src = imagecreatefromjpeg($img); break;
          case IMAGETYPE_PNG  : $src = imagecreatefrompng($img);  break;
          default : die("Unknown filetype");
        }

        $tmp = imagecreatetruecolor($width, $height);
        imagecopyresampled($tmp, $src, 0, 0, 0, 0, $width, $height, $width, $height);
        $tNewName = explode('.',$tNameImage);
        imagejpeg($tmp, $tNewName[0].".jpeg");
        $tPath       = $tNewName[0].".jpeg";
        $tBase64 = base64_encode(file_get_contents($tPath));    
        unlink($tNewName[0].".jpeg");

        //เช็ครูปภาพก่อน
        // $aImageFace = array(
		// 	"ptFacImg"      => $tBase64
        // );
        
        // $aPackData = array(
        //     "ptApp"         => 'ADAVending',
        //     "ptBch"         => $this->session->userdata("tSesUsrBchCodeDefault"),
        //     "ptTid"         => 'ADAVending',
        //     "ptCmpCode"     => $aCompany['raItems'][0]['FTCmpCode'],
        //     "ptAgnCode"		=> "",
        //     "ptStaRetImg"   => 1,
        //     "ptDocRef"      => "-",
		// 	"paoFacInfo" 	=> $aImageFace
        // );
        // $aCheckImage = $this->FSaAPICall("ADA_Recog", "POST", json_encode($aPackData));
        // if(trim($aCheckImage['rtDesc']) != 'Success'){
        //     //ถ้าไม่เจอหน้า ไม่ผ่าน
        //     echo 'fail';
        //     return;
        // }

        $aImageFace = array(
			"ptFacRefCode"  => $tCustomerCode,
			"ptFacKey"      => 'M',
			"ptFacRefSeq"   => $nSeq,
			"ptFacImg"      => $tBase64
        );

		$aPackData = array(
			"ptCmpCode" 	=> $aCompany['raItems'][0]['FTCmpCode'],
            "ptAgnCode"		=> "",
			"ptFacTable"	=> $tTable,
			"ptType" 		=> "Image",
			"paoFacInfo" 	=> array($aImageFace)
        );

        $aResult = $this->FSaAPICall("ADA_AddFaces", "POST", json_encode($aPackData));

        // print_r(json_encode($aPackData));
        // print_r($aResult);

        if($aResult['rtCode'] == 4001 || $aResult['rtCode'] == 4002 || $aResult['rtCode'] == 4007 ){
            //รหัสหมดอายุ หรือรหัสไม่มี
            $this->FSxCstRGFCallAPIToken();
            echo 'refresh';
        }else if($aResult['rtCode'] == 1002 || $aResult['rtCode'] == 2001){
            //ไม่พบใบหน้า
            echo 'fail';
        }else{
            //สำเร็จ
            $aImageUplode = array(
                'tModuleName'       => $tPathIns,
                'tImgFolder'        => 'regisface',
                'tImgRefID'         => $tCustomerCode,
                'tImgObj'           => $tNameImage,
                'tImgTable'         => $tTable,
                'tTableInsert'      => 'TCNMImgObj',
                'tImgKey'           => 'Face',
                'dDateTimeOn'       => date('Y-m-d H:i:s'),
                'tWhoBy'            => $this->session->userdata('tSesUsername'),
                'nStaImageMulti'    => 3,
                'nStaNotDelete'     => 1,
                'nSeq'              => $nSeq
            );

            $tReturn = FCNnHAddImgObj($aImageUplode);
            echo 'success';
        }
    }
    
    //เอารูปภาพมาจาก ตาราง TCNMImgObj
    public function FSaCstRGFGetImage(){
        
        //รหัสลูกค้า
        $tCustomerCode  = $this->input->post('CustomerCode');
        $tTable         = $this->input->post('tTable');

        switch($tTable){
            case "TCNMCrdLogin":
                $tPathIns =  'payment';
            break;
            case "TCNMCst":
                $tPathIns =  'customer';
            break;
        }

        $aPackData      = $this->mCustomerRegisFace->FSaMCstGetImage($tCustomerCode, $tTable);
        echo json_encode($aPackData);
    }

    //ลบรูปภาพ
    public function FSaCstRGFDeleteImage(){
        //รหัสบริษัท
        $aCompany = $this->mCustomerRegisFace->FSaMCstGetCompany();

        //รหัสลูกค้า
        $tCustomerCode = $this->input->post('CustomerCode');

        $tTable = $this->input->post('tTable');

        switch($tTable){
            case "TCNMCrdLogin":
                $tPathIns =  'payment';
            break;
            case "TCNMCst":
                $tPathIns =  'customer';
            break;
        }

        //seq ของภาพ
        $nSeqOld = $this->input->post('nSeqOld');

        $aImageFace = array(
			"ptFacRefCode"  => $tCustomerCode,
			"ptFacKey"      => 'M',
			"ptFacRefSeq"   => $nSeqOld,
			"ptFacTable"	=> $tTable
        );
        
		$aPackData = array(
			"ptCmpCode" 	=> $aCompany['raItems'][0]['FTCmpCode'],
			"paoFacInfo" 	=> $aImageFace
        );

        // echo json_encode($aPackData);
        $aResult = $this->FSaAPICall("ADA_DeleteFace", "POST", json_encode($aPackData));
        // print_r( $aResult );
        if($aResult['rtCode'] == 4001 || $aResult['rtCode'] == 4002 || $aResult['rtCode'] == 4007){
            //รหัสหมดอายุ หรือรหัสไม่มี
            $this->FSxCstRGFCallAPIToken();
            echo 'refresh';
        }else if($aResult['rtCode'] == 0000){
            //ลบสมบูรณ์
            $this->mCustomerRegisFace->FSaMCstDeleteImage($tCustomerCode,$nSeqOld, $tTable);
        }else{
            //ลบไม่ผ่าน
        }
    }

    //ลบรูปภาพทั้งหมด By ID
    public function FSaCstRGFDeleteImageByID($pnID){
        //รหัสบริษัท
        $aCompany = $this->mCustomerRegisFace->FSaMCstGetCompany();

        //รหัสลูกค้า
        $tCustomerCode = $pnID;

        $aImageFace = array(
			"ptFacRefCode"  => $tCustomerCode,
			"ptFacTable"	=> "TCNMCst"
        );
        
		$aPackData = array(
			"ptCmpCode" 	=> $aCompany['raItems'][0]['FTCmpCode'],
			"paoFacInfo" 	=> $aImageFace
        );

        // echo json_encode($aPackData);
        $aResult = $this->FSaAPICall("ADA_DeleteFaceAll", "POST", json_encode($aPackData));
        if($aResult['rtCode'] == 4001 || $aResult['rtCode'] == 4002 || $aResult['rtCode'] == 4007){
            //รหัสหมดอายุ หรือรหัสไม่มี
            $this->FSxCstRGFCallAPIToken();
        }else if($aResult['rtCode'] == 0000){
            //ลบสมบูรณ์
        }else{
            //ลบไม่ผ่าน
        }
    }
}
