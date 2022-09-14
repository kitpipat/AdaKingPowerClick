<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCouriertype extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('courier/couriertype/mCouriertype');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nCtyBrowseType,$tCtyBrowseOption){
        $nMsgResp   = array('title'=>"CourierType");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('courierType/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCourierType	= FCNaHCheckAlwFunc('courierType/0/0');
        $this->load->view('courier/couriertype/wCouriertype', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nCtyBrowseType'    => $nCtyBrowseType,
            'tCtyBrowseOption'  => $tCtyBrowseOption,
            'aAlwEventCourierType'  => $aAlwEventCourierType
        ));
    }

    //Functionality : Function Call CourierType Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCTYListPage(){ 
        $aAlwEventCourierType	    = FCNaHCheckAlwFunc('courierType/0/0'); 
        $this->load->view('courier/couriertype/wCouriertypeList', array(
            'aAlwEventCourierType'  => $aAlwEventCourierType
        ));
    }


    //Functionality : Function Call DataTables CourierType
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCTYDataList(){
        try{
            $tSearchAll     =  $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent'); 
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMCourierType_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }
            $aData   = array(
                'nPage'     => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll
            );

            $aCtyDataList           = $this->mCouriertype->FSaMCTYList($aData); 
            $aAlwEventCourierType	= FCNaHCheckAlwFunc('courierType/0/0');
            $aGenTable   = array(
                'aCtyDataList'      => $aCtyDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventCourierType'  => $aAlwEventCourierType
            );
            $this->load->view('courier/couriertype/wCouriertypeDataTable', $aGenTable);

        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage CourierType Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    function FSvCCTYAddPage(){
        try{
            $aDataCourierType   = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('courier/couriertype/wCouriertypeAdd', $aDataCourierType);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage CourierType Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    function FSvCCTYEditPage(){
        try{
            $tCtyCode       = $this->input->post('tCtyCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMCourierType_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;  
            // }
            
            $aData= array(
                'FTCtyCode' => $tCtyCode,
                'FNLngID'   => $nLangEdit
            );

            $aCtyData   = $this->mCouriertype->FSaMCTYGetDataByID($aData);
            $aDataCourierType   = array(
                'nStaAddOrEdit' => 1,
                'aCtyData'      => $aCtyData
            );
            $this->load->view('courier/couriertype/wCouriertypeAdd', $aDataCourierType);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add CourierType
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCTYAddEvent(){
        try{
            $aDataCourierType = array(
                'tIsAutoGenCode'    => $this->input->post('ocbCtyAutoGenCode'),
                'FTCtyCode'         => $this->input->post('oetCtyCode'),
                'FTCtyName'         => $this->input->post('oetCtyName'),
                'FTCtyRmk'          => $this->input->post('otaCtyRmk'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit")
            );

            if($aDataCourierType["tIsAutoGenCode"] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMCourierType',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataCourierType["FTCtyCode"]   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode   = FCNaHGenCodeV5('TCNMCourierType');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataCourierType["FTCtyCode"]    =   $aGenCode['rtCtyCode'];
                // }
            }
            $oCountDup      = $this->mCouriertype->FSnMCTYCheckDuplicate($aDataCourierType['FTCtyCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaCtyMaster  = $this->mCouriertype->FSaMCTYAddUpdateMaster($aDataCourierType);
                $aStaCtyLang    = $this->mCouriertype->FSaMCTYAddUpdateLang($aDataCourierType);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add CourierType"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataCourierType['FTCtyCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add CourierType'
                    );
                }
            }else{
                $aReturn = array(
                    'nStaEvent'    => '801',
                    'tStaMessg'    => "Data Code Duplicate"
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit CourierType
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function  FSoCCTYEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataCourierType   = array(
                'FTCtyCode'     => $this->input->post('oetCtyCode'),
                'FTCtyName'     => $this->input->post('oetCtyName'),
                'FTCtyRmk'      => $this->input->post('otaCtyRmk'),
                'FDCreateOn'    => date('Y-m-d'),
                'FDLastUpdOn'   => date('Y-m-d'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit")
            );
            $aStaCtyMaster  = $this->mCouriertype->FSaMCTYAddUpdateMaster($aDataCourierType);
            $aStaCtyLang    = $this->mCouriertype->FSaMCTYAddUpdateLang($aDataCourierType);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add CourierType"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataCourierType['FTCtyCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add CourierType'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete CourierType
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCTYDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCtyCode' => $tIDCode
        );
        $aResDel    = $this->mCouriertype->FSaMCTYDelAll($aDataMaster);
        $nNumRowCpg = $this->mCouriertype->FSnMCTYGetAllNumRow();
        if($nNumRowCpg!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowCpg' => $nNumRowCpg
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }


    

}