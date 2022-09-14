<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtType extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdttype/mPdtType');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPtyBrowseType,$tPtyBrowseOption){
        $nMsgResp   = array('title'=>"Product Type");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdttype/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtType	    = FCNaHCheckAlwFunc('pdttype/0/0');
        $this->load->view('product/pdttype/wPdtType', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPtyBrowseType'    => $nPtyBrowseType,
            'tPtyBrowseOption'  => $tPtyBrowseOption,
            'aAlwEventPdtType'  => $aAlwEventPdtType
        ));
    }

    //Functionality : Function Call Product Type Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 14/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPTYListPage(){
        $aAlwEventPdtType	    = FCNaHCheckAlwFunc('pdttype/0/0');
        $this->load->view('product/pdttype/wPdtTypeList', array(
            'aAlwEventPdtType'  => $aAlwEventPdtType
        ));
    }

    //Functionality : Function Call DataTables Product Type
    //Parameters : Ajax Call View DataTable
    //Creator : 14/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPTYDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtType_L');
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

            $aPtyDataList           = $this->mPdtType->FSaMPTYList($aData);
            $aAlwEventPdtType	    = FCNaHCheckAlwFunc('pdttype/0/0');
            $aGenTable  = array(
                'aPtyDataList'      => $aPtyDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventPdtType'  => $aAlwEventPdtType
            );
            $this->load->view('product/pdttype/wPdtTypeDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Type Add
    //Parameters : Ajax Call View Add
    //Creator : 14/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPTYAddPage(){
        try{
            $aDataPdtType = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'     => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'     => $this->session->userdata("tSesUsrAgnName"),
            );
            $this->load->view('product/pdttype/wPdtTypeAdd',$aDataPdtType);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Type Edits
    //Parameters : Ajax Call View Add
    //Creator : 17/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCPTYEditPage(){
        try{
            $tPtyCode       = $this->input->post('tPtyCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtType_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave > 1){
            //     $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            // }else{
            //     $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            // }

            $aData  = array(
                'FTPtyCode' => $tPtyCode,
                'FNLngID'   => $nLangEdit
            );

            $aPtyData       = $this->mPdtType->FSaMPTYGetDataByID($aData);
            $aDataPdtType   = array(
                'nStaAddOrEdit' => 1,
                'aPtyData'      => $aPtyData
            );
            $this->load->view('product/pdttype/wPdtTypeAdd',$aDataPdtType);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Add Product Type
    //Parameters : Ajax Event
    //Creator : 17/09/2018 wasin
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPTYAddEvent(){
        try{
            $aDataPdtType   = array(
                'tIsAutoGenCode' => $this->input->post('ocbPtyAutoGenCode'),
                'FTPtyCode'     => $this->input->post('oetPtyCode'),
                'FTPtyName'     => $this->input->post('oetPtyName'),
                'FTPtyRmk'      => $this->input->post('otaPtyRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetPTYAgnCode'),
            );
            // Setup Reason Code
            if($aDataPdtType['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode = FCNaHGenCodeV5('TCNMPdtType');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtType['FTPtyCode'] = $aGenCode['rtPtyCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtType',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtType['FTPtyCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $this->db->trans_begin();
            $aStaPtyMaster  = $this->mPdtType->FSaMPTYAddUpdateMaster($aDataPdtType);
            $aStaPtyLang    = $this->mPdtType->FSaMPTYAddUpdateLang($aDataPdtType);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Product Type"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtType['FTPtyCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Product Type'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Edit Product Type
    //Parameters : Ajax Event
    //Creator : 17/09/2018 wasin
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPTYEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataPdtType   = array(
                'FTPtyCode'     => $this->input->post('oetPtyCode'),
                'FTPtyName'     => $this->input->post('oetPtyName'),
                'FTPtyRmk'      => $this->input->post('otaPtyRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetPTYAgnCode'),
            );
            $aStaPtyMaster  = $this->mPdtType->FSaMPTYAddUpdateMaster($aDataPdtType);
            $aStaPtyLang    = $this->mPdtType->FSaMPTYAddUpdateLang($aDataPdtType);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Type"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtType['FTPtyCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Type'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Event Delete Product Type
    //Parameters : Ajax jReason()
    //Creator : 17/09/2018 wasin
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPTYDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPtyCode' => $tIDCode
        );
        $aResDel    = $this->mPdtType->FSaMPTYDelAll($aDataMaster);
        $nNumRowPdtPty = $this->mPdtType->FSnMLOCGetAllNumRow();
        if($nNumRowPdtPty!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtPty' => $nNumRowPdtPty
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }











    




}