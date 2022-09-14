<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class UploadFile_Controller extends MX_Controller {


    public function __construct(){
        parent::__construct ();
        $this->load->model('common/UploadFile_Model');
    }


    // Functionality : Function Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Data Table
    // Return Type : object
    public function FCNvCUPFCallDataTable(){
        
        $tBchCode    =  $this->input->post('tBchCode');
        $tDocNo      =  $this->input->post('tDocNo');
        $tDocKey    =  $this->input->post('tDocKey');
        $tSessionID  =  $this->input->post('tSessionID');
        $nEvent      =  $this->input->post('nEvent');
        $tElementID  = $this->input->post('tElementID');
        $tCallBackFunct  = $this->input->post('tCallBackFunct');
        
        $aDataConfigView = array(
            'tBchCode'   => $tBchCode,
            'tDocNo'     => $tDocNo,
            'tDocKey'    => $tDocKey,
            'tSessionID' => $tSessionID,
            'nEvent'     => $nEvent,
            'tElementID'  => $tElementID,
            'tCallBackFunct' => $tCallBackFunct,
        );

        if($nEvent==1){ //add
            $this->UploadFile_Model->FCNxMUPFCealDataInTmp($aDataConfigView); //เคลียข้อมูลค้างใน Temp
        }else if($nEvent==2){//edit
            $this->UploadFile_Model->FCNxMUPFCealDataInTmp($aDataConfigView); //เคลียข้อมูลค้างใน Temp
            $this->UploadFile_Model->FCNaMUPFIMoveDataToTmp($aDataConfigView); //ดึงข้อมูลจากตารางจริงลง Temp
        }else{
            //แสดงผลหลัง upload
        }

        $aResult = $this->UploadFile_Model->FCNaMUPFICallData($aDataConfigView); //ดึงข้อมูลไฟลจาก Temp
        $aDataConfigView['aItems'] = $aResult;

        $this->load->view('common/wRefFileUpload',$aDataConfigView);
    }

    
    // Functionality : Function Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Data Table
    // Return Type : object
    public function FCNvCUPFCallDataTableForNew(){
        
        $tBchCode    =  $this->input->post('tBchCode');
        $tDocNo      =  $this->input->post('tDocNo');
        $tDocKey    =  $this->input->post('tDocKey');
        $tSessionID  =  $this->input->post('tSessionID');
        $nEvent      =  $this->input->post('nEvent');
        $tElementID  = $this->input->post('tElementID');
        $tCallBackFunct  = $this->input->post('tCallBackFunct');
        
        $aDataConfigView = array(
            'tBchCode'   => $tBchCode,
            'tDocNo'     => $tDocNo,
            'tDocKey'    => $tDocKey,
            'tSessionID' => $tSessionID,
            'nEvent'     => $nEvent,
            'tElementID'  => $tElementID,
            'tCallBackFunct' => $tCallBackFunct,
        );

        if($nEvent==1){ //add
            $this->UploadFile_Model->FCNxMUPFCealDataInTmp($aDataConfigView); //เคลียข้อมูลค้างใน Temp
        }else if($nEvent==2){//edit
            $this->UploadFile_Model->FCNxMUPFCealDataInTmp($aDataConfigView); //เคลียข้อมูลค้างใน Temp
            $this->UploadFile_Model->FCNaMUPFIMoveDataToTmp($aDataConfigView); //ดึงข้อมูลจากตารางจริงลง Temp
        }else{
            //แสดงผลหลัง upload
        }

        $aResult = $this->UploadFile_Model->FCNaMUPFICallData($aDataConfigView); //ดึงข้อมูลไฟลจาก Temp
        $aDataConfigView['aItems'] = $aResult;

        $this->load->view('common/wRefFileUploadForNew',$aDataConfigView);
    }
    // Functionality : Function Add Update File
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Add Update File
    // Return Type : object
    public function FCNaCUPFEventAdd(){

        $aFiles      = $this->FSaCUPFSetFormatFileData(@$_FILES['ofiles']);
        $tBchCode   = $this->input->post('tBchCode');
        $tDocNo     = $this->input->post('tDocNo');
        $tDocKey    = $this->input->post('tDocKey');
        $tSessionID = $this->session->userdata("tSesSessionID");


        $aDataConfigView = array(
            'tBchCode'   => $tBchCode,
            'tDocNo'     => $tDocNo,
            'tDocKey'    => $tDocKey,
            'tSessionID' => $tSessionID,
        );


        $tUrlAddr   = $this->UploadFile_Model->FCNaMUPFGetObjectUrl();
		$tUrlApi    = $tUrlAddr.'/Upload/File';
		$aAPIKey    = array(
			'tKey'      => 'X-Api-Key',
			'tValue'    => '12345678-1111-1111-1111-123456789410'
		);
        $aReturn = array(
            'nStaEvent'    => '001',
            'tStaMessg'    => 'complete'
        );
        if(!empty($aFiles)){

            foreach($aFiles as $aFile){

                 $tPath = $aFile['name'];
                 $tExt = pathinfo($tPath, PATHINFO_EXTENSION);
                 $tFileName = basename($tPath,".".$tExt);
                $aResult = $this->UploadFile_Model->FCaMUPFGetSeqInTmp($aDataConfigView);
                if($aResult['rtCode']=='1'){
                    $nFleSeq = $aResult['FNFleSeq']+1;
                }else{
                    $nFleSeq = 1;
                }

                $aParam     = array(
                    'ptContent'		=> new CURLFILE($aFile['tmp_name'],$aFile['type'],$aFile['name']),
                    'ptRef1'        => 'branch_'.$tBchCode,
                    'ptRef2'        => $tDocNo,
                    'ptRefName'     => $tFileName
                );
           
                $oReuslt = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey,'file');

                if($oReuslt['rtCode'] != "99" ){
                    $aDataInsert = array(
                        'FTFleRefTable' => $tDocKey,
                        'FTFleRefID1'   => $tDocNo,
                        'FTFleRefID2'   => $tBchCode,
                        'FNFleSeq'      => $nFleSeq,
                        'FTFleType'     => $tExt,
                        'FTFleObj'      => $oReuslt['rtData'],
                        'FTFleName'     => $aFile['name'],
                        'FDCreateOn'    => date('Y-m-d H:i:s'),
                        'FTSessionID'   => $tSessionID
                    );
                   $aStatus = $this->UploadFile_Model->FCNaMUPFInsertDataToTmp($aDataInsert);
                   $aReturn = array(
					'nStaEvent'    => $oReuslt['rtCode'],
					'tStaMessg'    => $oReuslt['rtDesc']
				   );
                 }else{
                    $aReturn = array(
                        'nStaEvent'    => $oReuslt['rtCode'],
                        'tStaMessg'    => $oReuslt['rtDesc']
                    );
                 }


            }
     
            

        }
      
        //Clear File ใน File Server
        $aResultDelete = $this->UploadFile_Model->FCNaMUPFGetDataDelete($aDataConfigView);
        if($aResultDelete['rtCode']=='1'){
            foreach($aResultDelete['raItems'] as $aDataFile){
                FCNaMUPFCallAPIToDelete($aDataFile['FTFleObj']);
            }
        }

        $this->UploadFile_Model->FCNaMUPFMoveTmpToFleTable($aDataConfigView);

        echo json_encode($aReturn);

    }

    // Functionality : Function Set File Array
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Set File Array
    // Return Type : object
    private function FSaCUPFSetFormatFileData($pofiles){
        $aFileData = array();
        if(!empty($pofiles)){
            $ofiles = $pofiles;
            foreach($ofiles as $tKey => $aFile){
                    foreach($aFile as $nNumRow => $tValue){
                        $aFileData[$nNumRow][$tKey] = $tValue;
                    }
            }
        }
        return $aFileData;
    }

    // Functionality : Function Edit File
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Edit
    // Return Type : object
    public function FCNvCUPFEventEdit(){

        $tBchCode   = $this->input->post('tBchCode');
        $tDocNo     = $this->input->post('tDocNo');
        $tDocKey    = $this->input->post('tDocKey');
        $nRowIdFrom = $this->input->post('nRowIdFrom');
        $nRowIdTo   = $this->input->post('nRowIdTo');
        $tSessionID = $this->input->post('tSessionID');

        $aDataConfigView = array(
            'tBchCode'   => $tBchCode,
            'tDocNo'     => $tDocNo,
            'tDocKey'    => $tDocKey,
            'nRowIdFrom' => $nRowIdFrom,
            'nRowIdTo'   => $nRowIdTo,
            'tSessionID' => $tSessionID,
        );
        $aReturn = array(
            'rtCode'    => '800',
            'rtDesc'    => 'Update Failed'
        );
    
        $aReturn =  $this->UploadFile_Model->FCNaMUPFUpdateDataToTmp($aDataConfigView);
  
        echo json_encode($aReturn);

    }

    // Functionality : Function Delete File
    // Parameters : Ajax and Function Parameter
    // Creator : 16/06/2021 Nattakit
    // LastUpdate: -
    // Return : Object Delete
    // Return Type : object
    public function FCNvCUPFEventDelete(){

        $tBchCode   = $this->input->post('tBchCode');
        $tDocNo     = $this->input->post('tDocNo');
        $tDocKey    = $this->input->post('tDocKey');
        $nSeq       = $this->input->post('nSeq');
        $tSessionID = $this->input->post('tSessionID');
        $tFullpath = $this->input->post('tFullpath');
        

        // FCNaMUPFCallAPIToDelete($tFullpath);

        $aDataConfigView = array(
            'tBchCode'   => $tBchCode,
            'tDocNo'     => $tDocNo,
            'tDocKey'    => $tDocKey,
            'nSeq'       => $nSeq,
            'tSessionID' => $tSessionID,
        );

        $aReturn =  $this->UploadFile_Model->FCNaMUPFDeleteDataToTmp($aDataConfigView);

        echo json_encode($aReturn);

    }


}