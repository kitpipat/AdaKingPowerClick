<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtBrand extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtbrand/mPdtBrand');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPbnBrowseType,$tPbnBrowseOption){
        $nMsgResp   = array('title'=>"Product Brand");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }

        $vBtnSave = FCNaHBtnSaveActiveHTML('pdtbrand/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtBrand	    = FCNaHCheckAlwFunc('pdtbrand/0/0');
        $this->load->view('product/pdtbrand/wPdtBrand', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPbnBrowseType'    => $nPbnBrowseType,
            'tPbnBrowseOption'  => $tPbnBrowseOption,
            'aAlwEventPdtBrand' => $aAlwEventPdtBrand
        ));
    }

    //Functionality : Function Call Product Promotion Brand Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNListPage(){
        $aAlwEventPdtBrand	    = FCNaHCheckAlwFunc('pdtbrand/0/0');
        $this->load->view('product/pdtbrand/wPdtBrandList', array(
            'aAlwEventPdtBrand' => $aAlwEventPdtBrand
        ));
    }

    
    //Functionality : Function Call DataTables Product Brand
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtBrand_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave != ""){
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
                'tSearchAll'    => trim($tSearchAll),
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );

            $aPbnDataList           = $this->mPdtBrand->FSaMBNList($aData); 
            $aAlwEventPdtBrand	    = FCNaHCheckAlwFunc('pdtbrand/0/0');
            $aGenTable  = array(
                'aPbnDataList'      => $aPbnDataList,
                'nPage'             => $nPage,
                'tSearchAll'        => $tSearchAll,
                'aAlwEventPdtBrand' => $aAlwEventPdtBrand
            );
            $this->load->view('product/pdtbrand/wPdtBrandDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product  Brand Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNAddPage(){
        try{
            $aDataPdtBrand = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName")
            );
            $this->load->view('product/pdtbrand/wPdtBrandAdd',$aDataPdtBrand);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Brand Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCBNEditPage(){
        try{
            $tPbnCode       = $this->input->post('tPbnCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            // $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtBrand_L');
            // $nLangHave      = FCNnHSizeOf($aLangHave);
            // if($nLangHave != ""){
            //     if($nLangHave > 1){
            //         $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            //     }else{
            //         $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            //     }
            // }
            $aData  = array(
                'FTPbnCode' => $tPbnCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aPbnData       = $this->mPdtBrand->FSaMBNGetDataByID($aData);
            $aDataPdtBrand   = array(
                'nStaAddOrEdit' => 1,
                'aPbnData'      => $aPbnData
            );
            $this->load->view('product/pdtbrand/wPdtBrandAdd',$aDataPdtBrand);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Product Brand
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCBNAddEvent(){ 
        try{
            $aDataPdtBrand   = array(
                'tIsAutoGenCode' => $this->input->post('ocbPbnAutoGenCode'),
                'FTPbnCode' => $this->input->post('oetPbnCode'),
                'FTPbnName' => $this->input->post('oetPbnName'),
                'FTPbnRmk'  => $this->input->post('otaPbnRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetPbnAgnCode')
            );

            
            
            if($aDataPdtBrand["tIsAutoGenCode"] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode   = FCNaHGenCodeV5('TCNMPdtBrand','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtBrand["FTPbnCode"]    =   $aGenCode['rtPbnCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtBrand',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtBrand["FTPbnCode"]  = $aAutogen[0]["FTXxhDocNo"];
            }

  
            $this->db->trans_begin();
            $aStaPbnMaster  = $this->mPdtBrand->FSaMBNAddUpdateMaster($aDataPdtBrand);
            $aStaPbnLang    = $this->mPdtBrand->FSaMBNAddUpdateLang($aDataPdtBrand);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Add Product Promotion Group"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtBrand['FTPbnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Product Promotion Group'
                );
            }
            
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit Product Brand
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCBNEditEvent(){ 
        try{
            $this->db->trans_begin();
            $aDataPdtBrand   = array(
                'FTPbnCode'   => $this->input->post('oetPbnCode'),
                'FTPbnName'   => $this->input->post('oetPbnName'),
                'FTPbnRmk'    => $this->input->post('otaPbnRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'  => $this->input->post('oetPbnAgnCode')
            );
            $aStaPbnMaster  = $this->mPdtBrand->FSaMBNAddUpdateMaster($aDataPdtBrand);
            $aStaPbnLang    = $this->mPdtBrand->FSaMBNAddUpdateLang($aDataPdtBrand);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Brand"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtBrand['FTPbnCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Brand'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Product Brand
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCBNDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPbnCode' => $tIDCode
        );
        $aResDel    = $this->mPdtBrand->FSaMBNDelAll($aDataMaster);
        $nNumRowPbn = $this->mPdtBrand->FSnMPGPGetAllNumRow();
        if($nNumRowPbn!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPbn' => $nNumRowPbn
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}