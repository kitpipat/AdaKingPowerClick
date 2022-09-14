<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cDepartment extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('authen/department/mDepartment');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nDptBrowseType,$tDptBrowseOption){
        $nMsgResp   = array('title'=>"Department");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave = FCNaHBtnSaveActiveHTML('department/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน

        $aAlwEventDepartment	= FCNaHCheckAlwFunc('department/0/0');

        $this->load->view('authen/department/wDepartment', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nDptBrowseType'    => $nDptBrowseType,
            'tDptBrowseOption'  => $tDptBrowseOption,
            'aAlwEventDepartment' => $aAlwEventDepartment
        ));
    }

    //Functionality : Function Call Department Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 22/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCDPTListPage(){
        $aAlwEventDepartment	= FCNaHCheckAlwFunc('department/0/0');
        $aNewData  		= array( 'aAlwEventDepartment' => $aAlwEventDepartment);
        $this->load->view('authen/department/wDepartmentList',$aNewData);
    }


    //Functionality : Function Call DataTables Department
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCDPTDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMUsrDepart_L');
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
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );
            $aDptDataList   = $this->mDepartment->FSaMDPTList($aData);
            $aAlwEvent = FCNaHCheckAlwFunc('department/0/0'); //Controle Event
            $aGenTable  = array(
                'aAlwEventDepartment' => $aAlwEvent,
                'aDptDataList'  => $aDptDataList,
                'nPage'         => $nPage,
                'tSearchAll'    => $tSearchAll,
            );
            $this->load->view('authen/department/wDepartmentDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product  Brand Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCDPTAddPage(){
        try{
            $aDataDpt = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('authen/department/wDepartmentAdd',$aDataDpt);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Department Edits
    //Parameters : Ajax Call View Add
    //Creator : 22/11/2018 Witsarut
    //Return : String View
    //Return Type : View
    public function FSvCDPTEditPage(){
        try{
            $tDptCode       = $this->input->post('tDptCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMUsrDepart_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTDptCode' => $tDptCode,
                'FNLngID'   => $nLangEdit
            );

            $aDptData       = $this->mDepartment->FSaMDPTGetDataByID($aData);
            $aDataDpt   = array(
                'nStaAddOrEdit' => 1,
                'aDptData'      => $aDptData
            );
            $this->load->view('authen/department/wDepartmentAdd',$aDataDpt);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Department
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCDPTAddEvent(){

        try{
            $aDataDpt   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbDepartmentAutoGenCode'),
                'FTDptCode'         => $this->input->post('oetDptCode'),
                'FTDptName'         => $this->input->post('oetDptName'),
                'FTDptRmk'          => $this->input->post('otaDptRemark'),
                'FDCreateOn'        => date('Y-m-d H:i:s'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s'),
                'FTCreateBy'        => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'       => $this->session->userdata('tSesUsername'),
                'FNLngID'           => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetDptAgnCode')
            );

          // Check Auto Gen Department Code?  15/05/2020 Sahatat(Golf)
            if($aDataDpt['tIsAutoGenCode'] == '1'){
                // Auto Gen Department Code
                $aStoreParam = array(
                    "tTblName"   => 'TCNMUsrDepart',
                    "tDocType"   => 0,
                    "tBchCode"   => "",
                    "tShpCode"   => "",
                    "tPosCode"   => "",
                    "dDocDate"   => date("Y-m-d")
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataDpt['FTDptCode']  = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup      = $this->mDepartment->FSnMDPTCheckDuplicate($aDataDpt['FTDptCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaDptMaster  = $this->mDepartment->FSaMDPTAddUpdateMaster($aDataDpt);
                $aStaDptLang    = $this->mDepartment->FSaMDPTAddUpdateLang($aDataDpt);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Department"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataDpt['FTDptCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Department'
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


    //Functionality : Event Edit Department
    //Parameters : Ajax Event
    //Creator : 22/11/2018 Witsarut
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCDPTEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataDpt   = array(
                'FTDptCode'     => $this->input->post('oetDptCode'),
                'FTDptName'     => $this->input->post('oetDptName'),
                'FTDptRmk'      => $this->input->post('otaDptRemark'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetDptAgnCode')
            );
            $aStaDptMaster  = $this->mDepartment->FSaMDPTAddUpdateMaster($aDataDpt);
            $aStaDptLang    = $this->mDepartment->FSaMDPTAddUpdateLang($aDataDpt);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Department"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataDpt['FTDptCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Department'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Department
    //Parameters : Ajax jReason()
    //Creator : 22/11/2018 Witsarut
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCDPTDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTDptCode' => $tIDCode
        );
        $aResDel        = $this->mDepartment->FSaMDPTDelAll($aDataMaster);
        $nNumRowDptLoc  = $this->mDepartment->FSnMLOCGetAllNumRow();
        if($nNumRowDptLoc){
            $aReturn    = array(
                'nStaEvent'     => $aResDel['rtCode'],
                'tStaMessg'     => $aResDel['rtDesc'],
                'nNumRowDptLoc' => $nNumRowDptLoc
            );
        }else{
          $aReturn    = array(
              'nStaEvent'     => $aResDel['rtCode'],
              'tStaMessg'     => "error",
              'nNumRowDptLoc' => $nNumRowDptLoc
          );
        }
        echo json_encode($aReturn,true);
    }
}