<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCourierMan extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('courier/courierman/mCourierMan');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nCpgBrowseType,$tCpgBrowseOption){
        $nMsgResp   = array('title'=>"CourierGrp");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('courierMan/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCourierGrp	    = FCNaHCheckAlwFunc('courierMan/0/0');
        $this->load->view('courier/courierman/wCourierMan', array (
            'nMsgResp'              => $nMsgResp,
            'vBtnSave'              => $vBtnSave,
            'nCpgBrowseType'        => $nCpgBrowseType,
            'tCpgBrowseOption'      => $tCpgBrowseOption,
            'aAlwEventCourierGrp'   => $aAlwEventCourierGrp
        ));
    }

    // Functionality : Function Call CourierGrp Page List
    // Parameters : Ajax and Function Parameter
    // Creator : 21/09/2018 Witsarut(Bell)
    // Return : String View
    // Return Type : View
    public function FSvCCurmanListPage(){ 
        $aAlwEventCourierGrp	    = FCNaHCheckAlwFunc('courierMan/0/0'); 
        $this->load->view('courier/courierman/wCourierManList', array(
            'aAlwEventCourierGrp'  => $aAlwEventCourierGrp
        ));
    }

    // Functionality : Function Call DataTables CourierGrp
    // Parameters : Ajax Call View DataTable
    // Creator : 21/09/2018 Witsarut (Bell)
    // Return : String View
    // Return Type : View
    public function FSvCCurmanDataList(){ 
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMCourieMan_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aCpgDataList           = $this->mCourierMan->FSaMCurmanList($aData); 
            $aAlwEventCourierGrp	    = FCNaHCheckAlwFunc('courierMan/0/0');
            $aGenTable  = array(
                'aCpgDataList'      => $aCpgDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventCourierGrp'  => $aAlwEventCourierGrp
            );
            $this->load->view('courier/courierman/wCourierManDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Function CallPage CourierGrp Add
    // Parameters : Ajax Call View Add
    // Creator : 21/09/2018 Witsarut (Bell)
    // update  : 10/08/2019 Saharat (Golf)
    // Return : String View
    // Return Type : View
    public function FSvCCurAddPage(){
        try{
            $aDataCourierGrp = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('courier/courierman/wCourierManAdd',$aDataCourierGrp);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Function CallPage CourierGrp Edits
    // Parameters : Ajax Call View Add
    // Creator : 21/09/2018 Witsarut(Bell)
    // Return : String View
    // Return Type : View
    public function FSvCCurEditPage(){  
        try{
            $tCryCode   = $this->input->post('tCrycode');
            $tID        = $this->input->post('tID');
            $nLangEdit  = $this->session->userdata("tLangEdit");
            $aData      = [
                'FTCryCode'     => $tCryCode,
                'FNLngID'       => $nLangEdit,
                'FTManCardID'   => $tID
            ];
            $aDataTable     = $this->mCourierMan->FSaMCurGetDataByID($aData);
            // if(isset($aDataTable['raItems']['rtImgObj']) && !empty($aDataTable['raItems']['rtImgObj'])){
            //     $tImgObj        = $aDataTable['raItems']['rtImgObj'];
            //     $aImgObj        = explode("application/modules/",$tImgObj);
			// 	$aImgObjName	= explode("/",$tImgObj);
            //     $tImgObjAll     = $aImgObj[1];
			// 	$tImgName		= end($aImgObjName);
            // }else{
            //     $tImgObjAll     = "";
			// 	$tImgName       = "";
            // }

            $aDataCourierMan   = array(
                'nStaAddOrEdit' => 1,
                'aCrmData'      => $aDataTable,
                'tImgObjAll'    => $aDataTable['raItems']['rtImgObj'],
            );
            $this->load->view('courier/courierman/wCourierManAdd',$aDataCourierMan);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Check tel duplicate
    // Parameters : Ajax Event
    // Creator : 30/09/2018 Pap
    // Return : Status Add Event
    // Return Type : String
    public function FSoCCheckDuplicateTel(){
        try{
            //Check Dupicate Add FTManTel
            $oCountDup      = $this->mCourierMan->FSnMCpgCheckDuplicate($this->input->post('FTCryCode'),$this->input->post('FTManCardID'),$this->input->post('FTManTel'));
            $nStaDup        = $oCountDup['counts'];
            if($nStaDup >= 1){
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Dupicate"
                );
            }else{
                $aReturn = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => "No Dupicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Event Add CourierGrp
    // Parameters : Ajax Event
    // Creator : 21/09/2018 Witsarut (Bell)
    // Return : Status Add Event
    // Return Type : String
    public function FSoCCurAddEvent(){
        try{
            // ***** Image Input Data *****
            $tImgInputCourierMan    = $this->input->post('oetImgInputCourierMan');
            $tImgInputCourierManOld = $this->input->post('oetImgInputCourierManOld');
            // ***** Image Input Data *****
            $aDataCourierMan    = [
                'FTCryCode'       => $this->input->post('oetCourierCode'),
                'FTManCardID'     => $this->input->post('oetID'),
                'FTManTel'        => $this->input->post('oetManTel'),
                'FTManCardEmp'    => $this->input->post('oetManCode'),
                'FTManSex'        => $this->input->post('orbSex'),
                'FDManDob'        => $this->input->post('oetManDob'),
                'FTManStaActive'  => $this->input->post('ocbManSta'),
                'FTCryRmk'        => $this->input->post('otaManRmk'),
                'FTManName'       => $this->input->post('oetManName'),
                'FNLngID'         => $this->session->userdata("tLangEdit"),
            ];
            
            $tStaMaster = $this->mCourierMan->FSaMCrmAddUpdateMaster($aDataCourierMan);
            $tSta_L     = $this->mCourierMan->FSaMCrmAddUpdateLang($aDataCourierMan);
            if($tImgInputCourierMan != $tImgInputCourierManOld){
                $aImageData = [
                    'tModuleName'       => 'courier',
                    'tImgFolder'        => 'courierman',
                    'tImgRefID'         => $aDataCourierMan['FTCryCode'].$aDataCourierMan['FTManCardID'],
                    'tImgObj'           => $tImgInputCourierMan,
                    'tImgTable'         => 'TCNMCourieMan',
                    'tTableInsert'      => 'TCNMImgPerson',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                ];
                $aImgReturn = FCNnHAddImgObj($aImageData);
            }
            $aReturn = array(
                'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                'nStaEvent'    => '1',
                'tStaMessg'    => "Add Success",
                'tCrycode'     => $aDataCourierMan['FTCryCode'],
                'tID'          => $aDataCourierMan['FTManCardID'],
                'tManCode'     => $aDataCourierMan['FTManCardID']
            );
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Event Edit CourierMan
    // Parameters : Ajax Event
    // Creator : 11/07/2019 Witsarut(Bell)
    // update  : 10/08/2019 Saharat(Golf)
    // Return : Status Edit Event
    // Return Type : String
    public function FSoCCurEditEvent(){  
        try{
            // ***** Image Input Data *****
            $tImgInputCourierMan    = $this->input->post('oetImgInputCourierMan');
            $tImgInputCourierManOld = $this->input->post('oetImgInputCourierManOld');
            // ***** Image Input Data *****
            $aDataCourierMan    = [
                'FTCryCode'       => $this->input->post('oetCourierCode'),
                'FTManCardID'     => $this->input->post('oetID'),
                'FTManTel'        => $this->input->post('oetManTel'),
                'FTManCardEmp'    => $this->input->post('oetManCode'),
                'FTManSex'        => $this->input->post('orbSex'),
                'FDManDob'        => $this->input->post('oetManDob'),
                'FTManStaActive'  => $this->input->post('ocbManSta'),
                'FTCryRmk'        => $this->input->post('otaManRmk'),
                'FTManName'       => $this->input->post('oetManName'),
                'FNLngID'         => $this->session->userdata("tLangEdit"),
                'FTImgObj'        => $this->input->post('oetImgInputrate'),
            ];
            $tStaMaster = $this->mCourierMan->FSaMCrmAddUpdateMaster($aDataCourierMan);
            $tSta_L     = $this->mCourierMan->FSaMCrmAddUpdateLang($aDataCourierMan);
            if($tImgInputCourierMan != $tImgInputCourierManOld){
                $aImageData = [
                    'tModuleName'       => 'courier',
                    'tImgFolder'        => 'courierman',
                    'tImgRefID'         => $aDataCourierMan['FTCryCode'].$aDataCourierMan['FTManCardID'],
                    'tImgObj'           => $tImgInputCourierMan,
                    'tImgTable'         => 'TCNMCourieMan',
                    'tTableInsert'      => 'TCNMImgPerson',
                    'tImgKey'           => 'main',
                    'dDateTimeOn'       => date('Y-m-d H:i:s'),
                    'tWhoBy'            => $this->session->userdata('tSesUsername'),
                    'nStaDelBeforeEdit' => 1
                ];
                $aImgReturn = FCNnHAddImgObj($aImageData);
            }
            $aReturn    = [
                'aImgReturn'    => ( isset($aImgReturn) && !empty($aImgReturn) ? $aImgReturn : array("nStaEvent" => '1') ),
                'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                'nStaEvent'     => '1',
                'tStaMessg'     => "Add Success",
                'tCrycode'      => $aDataCourierMan['FTCryCode'],
                'tID'           => $aDataCourierMan['FTManCardID'],
                'tManCode'      => $aDataCourierMan['FTManCardID']
            ];
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality : Event Delete CourierGrp
    // Parameters : Ajax jReason()
    // Creator : 21/09/2018 Witsarut(Bell)
    // Return : Status Delete Event
    // Return Type : String
    public function FSoCCurDeleteEvent(){ 
        $tID = $this->input->post('tID');
        $tCryCode = $this->input->post('tCryCode');
        $aDataMaster = array(
            'FTCryCode' => $tCryCode,
            'FTManCardID' => $tID
        );
        $aResDel        = $this->mCourierMan->FSaMCpgDelAll($aDataMaster);
        $aResDelIMG     = $this->mCourierMan->FSaMCpgDelIMG($aDataMaster);
        $nNumRowCpg = $this->mCourierMan->FSnMPGPGetAllNumRow();
        if($nNumRowCpg!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDelIMG['rtCode'],
                'tStaMessg' => $aResDelIMG['rtDesc'],
                'nNumRowCpg' => $nNumRowCpg
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}