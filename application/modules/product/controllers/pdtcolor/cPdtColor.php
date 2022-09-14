<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtColor extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtcolor/mPdtColor');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nClrBrowseType,$tClrBrowseOption){
        $nMsgResp   = array('title'=>"Product Color");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }

        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdtcolor/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtColor	    = FCNaHCheckAlwFunc('pdtcolor/0/0');
        $this->load->view('product/pdtcolor/wPdtColor', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nClrBrowseType'    => $nClrBrowseType,
            'tClrBrowseOption'  => $tClrBrowseOption,
            'aAlwEventPdtColor' => $aAlwEventPdtColor
        ));
    }

    //Functionality : Function Call Product Promotion Color Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCLRListPage(){ 
        $aAlwEventPdtColor	    = FCNaHCheckAlwFunc('pdtcolor/0/0');
        $this->load->view('product/pdtcolor/wPdtColorList', array(
            'aAlwEventPdtColor' => $aAlwEventPdtColor
        ));
    }

    
    //Functionality : Function Call DataTables Product Color
    //Parameters : Ajax Call View DataTable
    //Creator : 24/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCLRDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtColor_L');
            // if($aLangHave != ""){
            //     $nLangHave      = FCNnHSizeOf($aLangHave);
            //     if($nLangHave > 1){
            //         $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            //     }else{
            //         $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            //     }
            // }
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );

            $aClrDataList           = $this->mPdtColor->FSaMCLRList($aData); 
            $aAlwEventPdtColor	    = FCNaHCheckAlwFunc('pdtcolor/0/0');
            $aGenTable  = array(
                'aClrDataList'      => $aClrDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventPdtColor' => $aAlwEventPdtColor
            );
            $this->load->view('product/pdtcolor/wPdtColorDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Color Add
    //Parameters : Ajax Call View Add
    //Creator : 24/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCLRAddPage(){
        try{
            $aDataPdtColor = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('product/pdtcolor/wPdtColorAdd',$aDataPdtColor);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Color Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCCLREditPage(){
        try{
            $tClrCode       = $this->input->post('tClrCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtColor_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave != ""){
            //     if($nLangHave > 1){
            //         $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            //     }else{
            //         $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            //     }
            // }
            $aData  = array(
                'FTClrCode' => $tClrCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aClrData       = $this->mPdtColor->FSaMCLRGetDataByID($aData);
            $aDataPdtColor   = array(
                'nStaAddOrEdit' => 1,
                'aClrData'      => $aClrData
            );
            $this->load->view('product/pdtcolor/wPdtColorAdd',$aDataPdtColor);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Product Color
    //Parameters : Ajax Event
    //Creator : 24/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCCLRAddEvent(){ 
        try{
            $aDataPdtColor   = array(
                'tIsAutoGenCode' => $this->input->post('ocbClrAutoGenCode'),
                'FTClrCode'     => $this->input->post('oetClrCode'),  
                'FTClrRefValue' => $this->input->post('oetClrIdCode'), 
                'FTClrName'     => $this->input->post('oetClrName'),
                'FTClrRmk'      => $this->input->post('otaClrRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetClrAgnCode')
            );
            if($aDataPdtColor["tIsAutoGenCode"] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode   = FCNaHGenCodeV5('TCNMPdtColor');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtColor["FTClrCode"]    =   $aGenCode['rtClrCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtColor',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtColor["FTClrCode"]  = $aAutogen[0]["FTXxhDocNo"];
            }
            
            $this->db->trans_begin();
            $aStaClrMaster  = $this->mPdtColor->FSaMCLRAddUpdateMaster($aDataPdtColor);
            $aStaClrLang    = $this->mPdtColor->FSaMCLRAddUpdateLang($aDataPdtColor);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Product Color"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtColor['FTClrCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Product Color'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit Product Color
    //Parameters : Ajax Event
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCCLREditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataPdtColor  = array(
                'FTClrCode' => $this->input->post('oetClrCode'),
                'FTClrRefValue' => $this->input->post('oetClrIdCode'), 
                'FTClrName' => $this->input->post('oetClrName'),
                'FTClrRmk'  => $this->input->post('otaClrRmk'),
                'FDLastUpdOn'  => date('Y-m-d H:i:s'),
                'FDCreateOn'   => date('Y-m-d H:i:s'),
                'FTCreateBy'   => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'  => $this->session->userdata('tSesUsername'),
                'FNLngID'      => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetClrAgnCode')
            );
            $aStaClrMaster  = $this->mPdtColor->FSaMCLRAddUpdateMaster($aDataPdtColor);
            $aStaClrLang    = $this->mPdtColor->FSaMCLRAddUpdateLang($aDataPdtColor);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Color"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtColor['FTClrCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Color'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Product Color
    //Parameters : Ajax jReason()
    //Creator : 24/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCCLRDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTClrCode' => $tIDCode
        );
        $aResDel    = $this->mPdtColor->FSaMCLRDelAll($aDataMaster);
        $nNumRowPdtClr = $this->mPdtColor->FSnMPGPGetAllNumRow();
        if($nNumRowPdtClr!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtClr' => $nNumRowPdtClr
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}