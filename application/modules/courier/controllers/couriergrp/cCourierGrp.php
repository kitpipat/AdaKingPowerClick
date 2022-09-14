<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cCourierGrp extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('courier/couriergrp/mCourierGrp');
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
        $vBtnSave               = FCNaHBtnSaveActiveHTML('courierGrp/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventCourierGrp	    = FCNaHCheckAlwFunc('courierGrp/0/0');
        $this->load->view('courier/couriergrp/wCourierGrp', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nCpgBrowseType'    => $nCpgBrowseType,
            'tCpgBrowseOption'  => $tCpgBrowseOption,
            'aAlwEventCourierGrp'  => $aAlwEventCourierGrp
        ));
    }

    //Functionality : Function Call CourierGrp Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCGPListPage(){ 
        $aAlwEventCourierGrp	    = FCNaHCheckAlwFunc('courierGrp/0/0'); 
        $this->load->view('courier/couriergrp/wCourierGrpList', array(
            'aAlwEventCourierGrp'  => $aAlwEventCourierGrp
        ));
    }

    
    //Functionality : Function Call DataTables CourierGrp
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCGPDataList(){ 
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMCourierGrp_L');
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

            $aCpgDataList           = $this->mCourierGrp->FSaMCpgList($aData); 
            $aAlwEventCourierGrp	    = FCNaHCheckAlwFunc('courierGrp/0/0');
            $aGenTable  = array(
                'aCpgDataList'      => $aCpgDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventCourierGrp'  => $aAlwEventCourierGrp
            );
            $this->load->view('courier/couriergrp/wCourierGrpDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage CourierGrp Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCGPAddPage(){
        try{
            $aDataCourierGrp = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('courier/couriergrp/wCourierGrpAdd',$aDataCourierGrp);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage CourierGrp Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCGPEditPage(){  
        try{
            $tCpgCode       = $this->input->post('tCpgCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMCourierGrp_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTCgpCode' => $tCpgCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aCpgData       = $this->mCourierGrp->FSaMCpgGetDataByID($aData);
            $aDataCourierGrp   = array(
                'nStaAddOrEdit' => 1,
                'aCpgData'      => $aCpgData
            );
            $this->load->view('courier/couriergrp/wCourierGrpAdd',$aDataCourierGrp);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add CourierGrp
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCGPAddEvent(){
        try{
            $aDataCourierGrp   = array(
                'tIsAutoGenCode' => $this->input->post('ocbCpgAutoGenCode'),
                'FTCgpCode'   => $this->input->post('oetCpgCode'),
                'FTCgpName'   => $this->input->post('oetCpgName'),
                'FTCgpRmk'    => $this->input->post('otaCpgRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit")
            );


            if($aDataCourierGrp["tIsAutoGenCode"] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMCourierGrp',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataCourierGrp["FTCgpCode"]   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode   = FCNaHGenCodeV5('TCNMCourierGrp');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataCourierGrp["FTCgpCode"]    =   $aGenCode['rtCgpCode'];
                // }
            }
            $oCountDup      = $this->mCourierGrp->FSnMCpgCheckDuplicate($aDataCourierGrp['FTCgpCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaCpgMaster  = $this->mCourierGrp->FSaMCpgAddUpdateMaster($aDataCourierGrp);
                $aStaCpgLang    = $this->mCourierGrp->FSaMCpgAddUpdateLang($aDataCourierGrp);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add CourierGrp"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataCourierGrp['FTCgpCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add CourierGrp'
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


    //Functionality : Event Edit CourierGrp
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCCGPEditEvent(){  
        try{
            $this->db->trans_begin();
            $aDataCourierGrp   = array(
                'FTCgpCode' => $this->input->post('oetCpgCode'),
                'FTCgpName' => $this->input->post('oetCpgName'),
                'FTCgpRmk'  => $this->input->post('otaCpgRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit")
            );
            $aStaCpgMaster  = $this->mCourierGrp->FSaMCpgAddUpdateMaster($aDataCourierGrp);
            $aStaCpgLang    = $this->mCourierGrp->FSaMCpgAddUpdateLang($aDataCourierGrp);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit CourierGrp"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataCourierGrp['FTCgpCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit CourierGrp'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete CourierGrp
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCGPDeleteEvent(){ 
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCgpCode' => $tIDCode
        );
        $aResDel    = $this->mCourierGrp->FSaMCpgDelAll($aDataMaster);
        $nNumRowCpg = $this->mCourierGrp->FSnMPGPGetAllNumRow();
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