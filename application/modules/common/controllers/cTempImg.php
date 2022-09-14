<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cTempImg extends MX_Controller {

    public $tKeyAPI          = 'X-API-KEY'; //Key ของ API บน 94
    public $tValueAPI        = '12345678-1111-1111-1111-123456789410'; //Value ของ API บน 94

    public function __construct(){
        parent::__construct ();
    }

    public function FSaCallMasterImage(){
        $this->load->view ('common/wImgBrowseMaster', array (
            'tMasterName'   => $this->input->post('ptMasterName'),
            'nBrowseType'   => $this->input->post('pnBrowseType')
        ));
    }
    
    //Functionality : Function EventCallTempImg
    //Parameters : Ajax
    //Creator : 12/04/2018 wasin(โยชิ)
    //Last Modified : -
    //Return : Array Data Modal TempImg
    //Return Type : Array
    public function FSaCallTempImage(){
        $nPageCurrent   = $this->input->post('nPageCurrent');
   
        if($nPageCurrent == '' || $nPageCurrent == null){
            $nPageCurrent = '1';
        }
    
        $tChkImgExpire  = $this->FSxImageChackExpire();
        $tDataTable     = '';
        $allowed_types  = array('jpg','jpeg','gif','png'); // สกุลไฟล์
        
        //อันนี้เดียวใช้ path server อีกที่
        $tDir           = 'application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername;
        $aFiles         = array_slice(scandir($tDir),2);
        $tTempPatch     = base_url().'application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername;

        $nCount         = FCNnHSizeOf($aFiles);
        $nImagePerPage  = 9;
        $nNum_naviPage  = ceil($nCount/$nImagePerPage);
        $nBrowseType    = $this->input->post('nBrowseType');

        //ประเภทการ Browse
        if(isset($nBrowseType)):
            $nBrowseType = $nBrowseType; //Multi
        else: 
            $nBrowseType = 1; //Single
        endif;
        
        $s_key	=	($nPageCurrent*$nImagePerPage)-$nImagePerPage;
        $e_key	=	$nImagePerPage*$nPageCurrent;
        $e_key	=	($e_key>$nCount)? $nCount: $e_key;
        for($i=$s_key; $i<$e_key; $i++){
            $tDataTable .= "<div class='wf-box'>
                                <div class='thumbnail'>
                                    <div class='form-group text-center'>
                                        <img class='xCNIMGTemp' src='".$tTempPatch.'/'.$aFiles[$i]."'>
                                        <label class='xCNLabelFrm'>".$aFiles[$i]."</label>
                                    </div>
                                    <div class='row text-center'>
                                        <div class='col-xs-12 col-md-6'>
                                            <button onclick=JSxChooseImage('$tTempPatch','$aFiles[$i]','$nBrowseType') class='btn xCNBTNPrimery' style='width:100%'>เลือก</button>
                                        </div>
                                        <div class='col-xs-12 col-md-6'>
                                            <button onclick=JSxImageDelete('$aFiles[$i]') class='btn xCNBTNDefult' style='width:100%'>ลบ</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";
        }
        
        $tPaging = "<nav aria-label='Page navigation' style='float:right;'>
					<ul class='pagination'>";
        
                    if($nPageCurrent == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';}
        $tPaging .= "<li class='page-item $tDisabled'><a class='page-link' href='#' onClick=JSvClickPageTemp(1)>Previous</a></li>";
                    for($i=1; $i<=$nNum_naviPage; $i++){
                        if($nPageCurrent == $i){ $tActive = 'active'; }else{ $tActive = '-'; }
        $tPaging .=		 	"<li class='page-item $tActive'><a class='page-link' href='#' onClick=JSvImageCallTemp('$i','$nBrowseType')>$i</a></li> ";
                    }
                    if($nPageCurrent >= $nNum_naviPage){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; }
        $tPaging .=			"<li class='page-item $tDisabled'><a class='page-link' href='#' onClick=JSvClickPageTemp(2)>Next</a></li>
                        </ul>
					</nav>";
        
        $tTotalPage = "<p class='text-left'>พบข้อมูลทั้งหมด ".$nCount." รายการ ".
            " แสดงหน้า ".$nPageCurrent." / ".$nNum_naviPage."</p>" ;
        
        $aHTML = array(
            'rtImgData' 	=> $tDataTable,
            'rtPaging'		=> $tPaging,
            'rtTotalPage'	=> $tTotalPage
        );
        echo json_encode($aHTML);
    }
    
    //Functionality : Function Chack Image Expire
    //Parameters : Function Paramiter(FSaCallTempImage)
    //Creator : 12/04/2018 wasin(โยชิ)
    //Last Modified : -
    //Return : -
    //Return Type : -
    public function FSxImageChackExpire(){
        //เช็ค ไฟล์ Folder Image 
        if(!is_dir('./application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername)){
            mkdir('./application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername);
        }
        $tDir	= 'application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername;  // Create folder จาก User นั้นๆ
        $aFiles	= array_slice(scandir($tDir), 2);
        foreach($aFiles AS $tFilename){
            $tPatchFile     = './'.$tDir.'/'.$tFilename;	// ไฟล์ Patch รูป
            $dDateImg		= date("Y/m/d",filemtime($tPatchFile)); // ดึงค่า TimeStramp ของวันที่ อัพรูป
            $dDateToday		= date("Y/m/d");	// Time Stramp วันที่อัพรูป
            $nDateImg       = strtotime($dDateImg);		// หาจำนวนวินาทีของวันที่อัพไฟล์
            $nDateToday     = strtotime($dDateToday);	// หาจำนวนวินาทีของวันปัจจุบัน
            
            $nTimeDiff      = abs($nDateToday - $nDateImg); // หาจำนวนวืนาทีจากวันที่อัพไฟล์ถึงวันที่ปัจจุบัน
            $nDivideDays    = $nTimeDiff/86400;	// หาจำนวนวันที่งหมด 86400 จำนวนวินาทีทั้งหมดในแต่ละวัน
            $nTotalDays     = (intval($nDivideDays) == 0)? 1:intval($nDivideDays);	// แปลงค่าที่ได้เป็น Int
            if($nTotalDays >= 90){				// ถ้ารูปที่อัพใน Temp มีอายุนานกว่า 90 วัน จะลบรูปนั้นทิ้ง
                //unlink($tPatchFile);
            }
        }
    }
    
    //Functionality : Function Uplode Image Temp
    //Parameters :  Ajax Data
    //Creator :     12/04/2018 wasin(โยชิ)
    //Last Modified : - 
    //Return : Json Data
    //Return Type : Json
    public function FSaImageUplode(){
        if( $_FILES['file']['name'] != '' ){

            // if(!is_dir('./application/modules/common/assets/system/systemimage')){
            //     mkdir('./application/modules/common/assets/system/systemimage');
            // }

            // if(!is_dir('./application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername)){
            //     mkdir('./application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername);
            // }

            // $tCaracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ';//0123456789 เอาตัวเลขออกเพื่อป้องกันการเรียง Seq เพี้ยน Napat(Jame) 09/09/2019
            // $tQuantidadeCaracteres = strlen($tCaracteres);
            // $tHash=NULL;
            // for($x=1;$x<=8;$x++){ //ลดจำนวนตัวอักษรที่สร้างจาก 10 เป็น 8 ทดแทนจากการเพิ่ม date His Napat(Jame) 09/09/2019
            //     $tPosicao = rand(0,$tQuantidadeCaracteres);
            //     $tHash .= substr($tCaracteres,$tPosicao,1);
            // }
            // $tFilename = 'Img'.date('ymdHis').$tHash;
            // $aConfig = array(
            //     'file_name'     => $tFilename,
            //     'allowed_types' => '*',
            //     'upload_path'   => './application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername,
            //     'max_size'      => '0',
            //     'max_width'     => '0',
            //     'max_height'    => '0',
            // );
            
            // $this->load->library('upload');
            // $this->upload->initialize($aConfig);
            // if(!$this->upload->do_upload('file')){
            //     $aData = array('error' => $this->upload->display_errors());
            // }else{
            //     $aData = array('upload_data' => $this->upload->data());
            //     if(!empty($aData['upload_data']['file_name'])){
                    // $aImageData = $aData['upload_data'];
                    // $tStaResize = $this->FStImageResize($aImageData);
                    // if($tStaResize=="done"){
                        $tPath     = $_FILES['file']['tmp_name'];
                        $tType     = pathinfo($tPath,PATHINFO_EXTENSION);
                        $tDataimg  = file_get_contents($tPath);
                        $tbase64 = 'data:image/' . $tType . ';base64,' . base64_encode($tDataimg);
                        $raImageData = array(
                            'tImgBase64'   => $tbase64,
                            'tImgName'     => $_FILES['file']['name'],
                            'tImgType'     => $_FILES['file']['type']
                            // 'tImgFullPath' => $_FILES['file']['tmp_name']
                            // 'tImgName'     => $aImageData['file_name'],
                            // 'tImgType'     => $aImageData['image_type'],
                            // 'tImgFullPath' => $aImageData['full_path']
                        );
                    // }
                // }
                echo json_encode($raImageData);
            // }
        }
    }
    
    //Functionality : Function Resize Image Temp
    //Parameters :  Function Paramiter (FSaImageUplode)
    //Creator :     12/04/2018 wasin(โยชิ)
    //Last Modified : -
    //Return : Strin Status Resize
    //Return Type : String
    public function FStImageResize($paImgUL){
        if(isset($paImgUL) && !empty($paImgUL)){
            $this->load->library('image_lib');
            $config['image_library'] = 'gd2';
            $config['source_image'] = $paImgUL['full_path'];
            $config['create_thumb'] = FALSE;
            $config['maintain_ratio'] = TRUE;
            $config['width'] = 800;
            $config['height'] = 600;
            $this->image_lib->initialize($config);
            if (!$this->image_lib->resize()){
                return $this->image_lib->display_errors();
            }else{
                return "done";
            }
        }
    }
    
    //Functionality : Function Covert Crop Size
    //Parameters :  Ajax Function 
    //Creator : 12/04/2018 wasin(โยชิ)
    //Last Modified : - 
    //Return : Object Data Image
    //Return Type : Object
    public function FSoConvertSizeCrop(){
        $tImgBase64                     = $this->input->post('tBase64');
        $tImgName                       = $this->input->post('tImgName');
        $tImgType                       = $this->input->post('tImgtype');
        // $tImgPath                       = $this->input->post('tImgPath');
        // list($tImgType, $tImgBase64)    = explode(';', $tImgBase64);
        // list(, $tImgBase64)             = explode(',', $tImgBase64);
        // $oData                          = base64_decode($tImgBase64);

        // $tUrlApi    = 'http://202.44.55.96/AdaFileServer/API2CNFile/Upload/Image';
        // $aAPIKey    = array(
        //     'tKey'      => $this->tKeyAPI,
        //     'tValue'    => $this->tValueAPI
        // );
        // $aParam     = array(
        //     'ptImgBase64'   => $tImgBase64,
        //     'ptRef1'        => 'Images',
        //     'ptRef2'        => 'Folder1'
        // );
        // $oReuslt            = FCNaHCallAPIBasic($tUrlApi,'POST',$aParam,$aAPIKey);

        // if( $oReuslt['rtCode'] == '001' ){
        //     $tReturn = array(
        //         'tReturnCode'   => '1',
        //         'tReturnDesc'   => $oReuslt['rtDesc'],
        //         'tImgPatch'	    => $oReuslt['rtData']
        //     );
        // }else{
        //     $tReturn = array(
        //         'tReturnCode'   => '99',
        //         'tReturnDesc'   => $oReuslt['error'],
        //         'tImgPatch'	    => ''
        //     );
        // }

        // if(!file_put_contents($tImgPath,$oData)){
        //     $tReturnData = array(
        //         'tReturnCode'   => '99',
        //         'tReturnDesc'   => 'Error',
        //         'tImgPath'      => '',
        //         'tImgName'      => ''
        //     );
        // }else{
            $tReturnData = array(
                'tReturnCode'   => '1',
                'tReturnDesc'   => 'Success',
                'oImgBase64'    => $tImgBase64,
                // 'tImgPath'      => base_url().'application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername.'/'.$tImgName,
                'tImgName'      => $tImgName
            );
        // }
        echo json_encode($tReturnData);
    }
    
    //Functionality : Function Delete Image Files
    //Parameters : Ajax Function 
    //Creator : 18/04/2014
    //Last Modified : -
    //Return : Object Image Data
    //Return Type : Object
    public function FSoImageDelete(){
        $tImageName = $this->input->post('tImageName');
        if(!empty($tImageName)&&isset($tImageName)){
            $tPatch     = './application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername.'/'.$tImageName;
            $nStaDelete = unlink($tPatch);
            if($nStaDelete=='1'){
                $jTempData = $this->FSaCallTempImage();
                echo $jTempData;
            }
        }
    }
 
    //Function EventCallTempImg - แก้ไขว่าลบรูปภาพในคลัง เเล้ว error Supawat(wat) 15-09-2020
    public function FSaCallTempImageNEW($tMasterNameFromContoller = '' , $pnBrowseType = ''){

        $nPageCurrent   = $this->input->post('nPageCurrent');
        $tMasterName    = $this->input->post('ptMasterName');
        $tRetion        = $this->input->post('ptRetion');
        
        if($nPageCurrent == '' || $nPageCurrent == null || $nPageCurrent == '0'){
            $nPageCurrent = '1';
        }

        if($tMasterName == '' || $tMasterName == null){
            $tMasterName = $tMasterNameFromContoller;
        }
        
        $tChkImgExpire  = $this->FSxImageChackExpire();
        $tDataTable     = '';
        $allowed_types  = array('jpg','jpeg','gif','png'); // สกุลไฟล์
        
        //อันนี้เดียวใช้ path server อีกที่
        $tDir           = 'application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername;
        $aFiles         = array_slice(scandir($tDir),2);
        rsort($aFiles); //เพิ่ม natcasesort เพื่อจัดเรียงลำดับ น้อย->มาก Edit by Napat(Jame) 09/09/2019
        $tTempPatch     = base_url().'application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername;
        
        $nCount         =  FCNnHSizeOf($aFiles);
        $nImagePerPage  = 9;
        $nNum_naviPage  = ceil($nCount/$nImagePerPage);
        $nBrowseType    = $this->input->post('nBrowseType');

        //ประเภทการ Browse
        if($nBrowseType != ''):
            $nBrowseType = $nBrowseType; //Multi
        else: 
            if($pnBrowseType != ''){
                $nBrowseType = $pnBrowseType;
            }else{
                $nBrowseType = 1; //Single
                 $tDataTable .= "<div class='wf-box1'>
                                        <div class='thumbnail'>
                                            <div class='form-group text-center'>
                                                <img class='xCNIMGTemp' src='".base_url('application/modules/common/assets/images/NoPic.png')."'>
                                                <label class='xCNLabelFrm'>No Image</label>
                                            </div>
                                            <div class='row text-center'>
                                                <div class='col-xs-12 col-md-12' align='center'>
                                                    <button id='xCNIMGChooseImg' onclick=JSxChooseImageNEW('".base_url('application/modules/common/assets/images/')."','NoPic.png','1','$tMasterName') class='btn xCNBTNPrimery' style='width:100%'>".language('common/main/main','tGallerySelect')."</button>
                                                </div>
                                    
                                            </div>
                                        </div>
                                    </div>";
            }
        endif;
        
        $s_key	=	($nPageCurrent*$nImagePerPage)-$nImagePerPage;
        $e_key	=	$nImagePerPage*$nPageCurrent;
        $e_key	=	($e_key>$nCount)? $nCount: $e_key;


        for($i=$s_key; $i<$e_key; $i++){
            $tDataTable .= "<div class='wf-box1'>
                                <div class='thumbnail'>
                                    <div class='form-group text-center'>
                                        <img class='xCNIMGTemp' src='".$tTempPatch.'/'.$aFiles[$i]."'>
                                        <label class='xCNLabelFrm'>".$aFiles[$i]."</label>
                                    </div>
                                    <div class='row text-center'>
                                        <div class='col-xs-12 col-md-6'>
                                            <button id='xCNIMGChooseImg' onclick=JSxChooseImageNEW('$tTempPatch','$aFiles[$i]','$nBrowseType','$tMasterName') class='btn xCNBTNPrimery' style='width:100%'>".language('common/main/main','tGallerySelect')."</button>
                                        </div>
                                        <div class='col-xs-12 col-md-6'>
                                            <button onclick=JSxImageDeleteNEW('$aFiles[$i]','$tMasterName','$nBrowseType') class='btn xCNBTNDefult' style='width:100%'>".language('common/main/main','tGalleryDelete')."</button>
                                        </div>
                                    </div>
                                </div>
                            </div>";

        }
        $tPaging = "<nav aria-label='Page navigation' style='float:right;'>
					<ul class='pagination'>";
        
                    if($nPageCurrent == 1){ $tDisabled = 'disabled'; $tStyle = 'pointer-events: none;'; }else{ $tDisabled = '-'; $tStyle = '';}
        $tPaging .= "<li class='page-item $tMasterName $tDisabled' style='$tStyle'><a class='page-item btn xCNBTNNumPagenation' href='#' onClick=JSvClickPageTempNEW('1','$tMasterName')> ".language('common/main/main','tPrevious')." </a></li>";
                    for($i=1; $i<=$nNum_naviPage; $i++){
                        if($nPageCurrent == $i){ $tActive = 'active'; }else{ $tActive = '-'; }
        $tPaging .=		 	"<li class='page-item $tMasterName $tActive'><a class='page-link' href='#' onClick=JSvImageCallTempNEWStep2('$i','$nBrowseType','$tMasterName','$tRetion')>$i</a></li> ";
                    }
                    if($nPageCurrent >= $nNum_naviPage){ $tDisabled = 'disabled'; $tStyle = 'pointer-events: none;';}else{ $tDisabled = '-'; $tStyle = '';}
        $tPaging .=			"<li class='page-item $tMasterName $tDisabled' style='$tStyle'><a class='btn btn-white btn-sm' href='#' onClick=JSvClickPageTempNEW('2','$tMasterName')> ".language('common/main/main','tNext')." </a></li>
                    </ul>
					</nav>";
        $tTotalPage = "<p class='text-left'>".language('common/main/main','tResultTotalRecord')."  ".$nCount." ".language('common/main/main','tRecord')." ".
            " ".language('common/main/main','tCurrentPage')." ".$nPageCurrent." / ".$nNum_naviPage."</p>" ;

        $aHTML = array(
            'rtImgData' 	=> $tDataTable,
            'rtPaging'		=> $tPaging,
            'rtTotalPage'	=> $tTotalPage
        );

        echo json_encode($aHTML);
    }


    //Functionality : Function Delete Image Files
    //Parameters : Ajax Function 
    //Creator : 18/04/2014
    //Last Modified : -
    //Return : Object Image Data
    //Return Type : Object
    public function FSoImageDeleteNEW(){
        $tImageName     = $this->input->post('tImageName');
        $tMasterName    = $this->input->post('tMasterName');
        $nBrowseType    = $this->input->post('nBrowseType'); 
        if(!empty($tImageName)&&isset($tImageName)){
            $tPatch     = './application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername.'/'.$tImageName;
            $nStaDelete = unlink($tPatch);
            if($nStaDelete=='1'){
                $jTempData = $this->FSaCallTempImageNEW($tMasterName,$nBrowseType);
                echo $jTempData;
            }
        }
    }


    //Functionality : Function Uplode Image Temp
    //Parameters :  Ajax Data
    //Creator :     12/04/2018 wasin(โยชิ)
    //Last Modified : - 
    //Return : Json Data
    //Return Type : Json
    public function FSaImageUplodeNEW(){
        if( $_FILES['file']['name'] != '' ){
            if(!is_dir('./application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername)){
                mkdir('./application/assets/system/systemimage/'.$this->session->tSesUsername);
            }
            $tCaracteres = 'ABCDEFGHIJKLMOPQRSTUVXWYZ0123456789';
            $tQuantidadeCaracteres = strlen($tCaracteres);
            $tHash=NULL;
            for($x=1;$x<=10;$x++){
                $tPosicao = rand(0,$tQuantidadeCaracteres);
                $tHash .= substr($tCaracteres,$tPosicao,1);
            }
            $tFilename = 'Img'.$tHash.date('Ymd');
            $aConfig = array(
                'file_name'     => $tFilename,
                'allowed_types' => '*',
                'upload_path'   => './application/modules/common/assets/system/systemimage/'.$this->session->tSesUsername,
                'max_size'      => '0',
                'max_width'     => '0',
                'max_height'    => '0',
            );
            
            $this->load->library('upload');
            $this->upload->initialize($aConfig);
            if(!$this->upload->do_upload('file')){
                $aData = array('error' => $this->upload->display_errors());
            }else{
                $aData = array('upload_data' => $this->upload->data());
                if(!empty($aData['upload_data']['file_name'])){
                    $aImageData = $aData['upload_data'];
                    $tStaResize = $this->FStImageResize($aImageData);
                    if( $tStaResize == "done" ){
                        $tPath          = $aImageData['full_path'];
                        $tType          = pathinfo($tPath,PATHINFO_EXTENSION);
                        $tDataimg       = file_get_contents($tPath);
                        $tbase64        = 'data:image/' . $tType . ';base64,' . base64_encode($tDataimg);
                        $raImageData    = array(
                            'tImgBase64'   => $tbase64,
                            'tImgName'     => $aImageData['file_name'],
                            'tImgType'     => $aImageData['image_type'],
                            'tImgFullPath' => $aImageData['full_path']
                        );
                    }
                }
                echo json_encode($raImageData);
            }
        }
    }
}

