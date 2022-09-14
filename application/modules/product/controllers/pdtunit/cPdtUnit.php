<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtUnit extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtunit/mPdtUnit');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPunBrowseType,$tPunBrowseOption){
        $nMsgResp   = array('title'=>"Product Unit");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdtunit/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtUnit	    = FCNaHCheckAlwFunc('pdtunit/0/0');

        $this->load->view('product/pdtunit/wPdtUnit', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPunBrowseType'    => $nPunBrowseType,
            'tPunBrowseOption'  => $tPunBrowseOption,
            'aAlwEventPdtUnit'  => $aAlwEventPdtUnit
        ));
    }

    //Functionality : Function Call Product Unit Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPUNListPage(){
        $aAlwEventPdtUnit	    = FCNaHCheckAlwFunc('pdtunit/0/0');
        $this->load->view('product/pdtunit/wPdtUnitList',array(
            'aAlwEventPdtUnit'  =>  $aAlwEventPdtUnit
        ));
    }

    //Functionality : Function Call DataTables Product Unit
    //Parameters : Ajax Call View DataTable
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPUNDataList(){
        try{
            $tSearchAll = $this->input->post('tSearchAll');
            $nPage      = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMDistrict_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );
            $aPunDataList           = $this->mPdtUnit->FSaMPUNList($aData);
            $aAlwEventPdtUnit	    = FCNaHCheckAlwFunc('pdtunit/0/0');
            $aGenTable  = array(
                'aPunDataList'          => $aPunDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPdtUnit'      => $aAlwEventPdtUnit
            );
            $this->load->view('product/pdtunit/wPdtUnitDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Unit Add
    //Parameters : Ajax Call View Add
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPUNAddPage(){
        try{
            $aDataPdtUnit = array(
                'nStaAddOrEdit'  => 99,
                'tSesAgnCode'    => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'    => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('product/pdtunit/wPdtUnitAdd',$aDataPdtUnit);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Unit Edit
    //Parameters : Ajax Call View Edit
    //Creator : 13/09/2018 wasin
    //Last Modified : -
    //Return : String View
    //Return Type : View
    public function FSvCPUNEditPage(){
        try{
            $tPunCode       = $this->input->post('tPunCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMDistrict_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTPunCode' => $tPunCode,
                'FNLngID'   => $nLangEdit
            );

            $aPunData       = $this->mPdtUnit->FSaMPUNGetDataByID($aData);
            $aDataPdtUnit      = array(
                'nStaAddOrEdit' => 1,
                'aPunData'      => $aPunData
            );
            $this->load->view('product/pdtunit/wPdtUnitAdd',$aDataPdtUnit);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product Unit
    //Parameters : Ajax Event
    //Creator : 13/09/2018 wasin
    //Update : 23/08/2019 Saharat(Golf)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPUNAddEvent(){
        try{
            $aDataPdtUnit   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbPunAutoGenCode'),
                'FTPunCode'     => $this->input->post('oetPunCode'),
                'FTPunName'     => $this->input->post('oetPunName'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetPunAgnCode'),
            );
            // Setup Reason Code
            if($aDataPdtUnit['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode = FCNaHGenCodeV5('TCNMPdtUnit');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtUnit['FTPunCode'] = $aGenCode['rtPunCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtUnit',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtUnit['FTPunCode']   = $aAutogen[0]["FTXxhDocNo"];
            }

            $oCountDup      = $this->mPdtUnit->FSnMPUNCheckDuplicate($aDataPdtUnit['FTPunCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaDptMaster  = $this->mPdtUnit->FSaMPUNAddUpdateMaster($aDataPdtUnit);
                $aStaDptLang    = $this->mPdtUnit->FSaMPUNAddUpdateLang($aDataPdtUnit);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Product Unit"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataPdtUnit['FTPunCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product Unit'
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

    //Functionality : Event Edit Product Unit
    //Parameters : Ajax Event
    //Creator : 13/09/2018 wasin
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPUNEditEvent(){
        try{
            $aDataPdtUnit   = array(
                'FTPunCode' => $this->input->post('oetPunCode'),
                'FTPunName' => $this->input->post('oetPunName'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetPunAgnCode'),
            );
            $this->db->trans_begin();
            $aStaPunMaster  = $this->mPdtUnit->FSaMPUNAddUpdateMaster($aDataPdtUnit);
            $aStaPunLang    = $this->mPdtUnit->FSaMPUNAddUpdateLang($aDataPdtUnit);
            if($this->db->trans_status() === FALSE){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Unit"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtUnit['FTPunCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Unit'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product Unit
    //Parameters : Ajax jReason()
    //Creator : 13/09/2018 wasin
    //Update : 1/4/2019 Pap
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPUNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPunCode' => $tIDCode
        );
        $aResDel        = $this->mPdtUnit->FSaMPUNDelAll($aDataMaster);
        $nNumRowPdtPUN = $this->mPdtUnit->FSnMPUNGetAllNumRow();
        if($nNumRowPdtPUN!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtPUN' => $nNumRowPdtPUN
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }


    





































































}  