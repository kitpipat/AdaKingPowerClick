<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtModel extends MX_Controller {
    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtmodel/mPdtModel');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nPmoBrowseType,$tPmoBrowseOption){
        $nMsgResp   = array('title'=>"Product Model");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }

        $vBtnSave               = FCNaHBtnSaveActiveHTML('pdtmodel/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtModel	    = FCNaHCheckAlwFunc('pdtmodel/0/0');
        $this->load->view('product/pdtmodel/wPdtModel', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nPmoBrowseType'    => $nPmoBrowseType,
            'tPmoBrowseOption'  => $tPmoBrowseOption,
            'aAlwEventPdtModel' => $aAlwEventPdtModel
        ));
    }

    //Functionality : Function Call Product Promotion Model Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMOListPage(){
        $aAlwEventPdtModel	    = FCNaHCheckAlwFunc('pdtmodel/0/0');
        $this->load->view('product/pdtmodel/wPdtModelList', array(
            'aAlwEventPdtModel' => $aAlwEventPdtModel
        ));
    }

    
    //Functionality : Function Call DataTables Product Model
    //Parameters : Ajax Call View DataTable
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMODataList(){ 
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtModel_L');
            if($aLangHave != ""){
                $nLangHave      = FCNnHSizeOf($aLangHave);
                if($nLangHave > 1){
                    $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
                }else{
                    $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
                }
            }

            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
            );

            $aPmoDataList           = $this->mPdtModel->FSaMPMOList($aData);
            $aAlwEventPdtModel	    = FCNaHCheckAlwFunc('pdtmodel/0/0');
            $aGenTable  = array(
                'aPmoDataList'          => $aPmoDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPdtModel'     => $aAlwEventPdtModel
            );
            $this->load->view('product/pdtmodel/wPdtModelDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Model Add
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMOAddPage(){
        try{
            $aDataPdtModel = array(
                'nStaAddOrEdit'   => 99,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'   => $this->session->userdata("tSesUsrAgnName"),
            );
            $this->load->view('product/pdtmodel/wPdtModelAdd',$aDataPdtModel);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Model Edits
    //Parameters : Ajax Call View Add
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMOEditPage(){  
        try{
            $tPmoCode       = $this->input->post('tPmoCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtModel_L');
            if($aLangHave != ""){
                $nLangHave      = FCNnHSizeOf($aLangHave);
                if($nLangHave > 1){
                    $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
                }else{
                    $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
                }
            }
            $aData  = array(
                'FTPmoCode' => $tPmoCode,
                'FNLngID'   => $nLangEdit
            );
                                                
            $aPmoData       = $this->mPdtModel->FSaMPMOGetDataByID($aData);
            $aDataPdtModel   = array(
                'nStaAddOrEdit' => 1,
                'aPmoData'      => $aPmoData
            );
            $this->load->view('product/pdtmodel/wPdtModelAdd',$aDataPdtModel);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Product Model
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut (Bell)
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPMOAddEvent(){  
        try{
            $aDataPdtModel   = array(
                'tIsAutoGenCode' => $this->input->post('ocbPmoAutoGenCode'),
                'FTPmoCode' => $this->input->post('oetPmoCode'),
                'FTPmoName' => $this->input->post('oetPmoName'),
                'FTPmoRmk'  => $this->input->post('otaPmoRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'   => $this->input->post('oetPmoAgnCode'),
            );
            if($aDataPdtModel["tIsAutoGenCode"] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode   = FCNaHGenCodeV5('TCNMPdtBrand');
                
                // $aGenCode   = FCNaHGenCodeV5('TCNMPdtModel','0');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtModel["FTPmoCode"]    =   $aGenCode['rtPmoCode'];
                // }

                // Update new gencode
                // 15/05/2020 Napat(Jame)
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtModel',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtModel["FTPmoCode"]  = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->mPdtModel->FSnMPMOCheckDuplicate($aDataPdtModel['FTPmoCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaPmoMaster  = $this->mPdtModel->FSaMPMOAddUpdateMaster($aDataPdtModel);
                $aStaPmoLang    = $this->mPdtModel->FSaMPMOAddUpdateLang($aDataPdtModel);
                if($this->db->trans_status() === false){
                    $this->db->trans_rollback();
                    $aReturn = array(
                        'nStaEvent'    => '900',
                        'tStaMessg'    => "Unsucess Add Product Model"
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturn = array(
                        'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                        'tCodeReturn'	=> $aDataPdtModel['FTPmoCode'],
                        'nStaEvent'	    => '1',
                        'tStaMessg'		=> 'Success Add Product Model'
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


    //Functionality : Event Edit Product Model
    //Parameters : Ajax Event
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPMOEditEvent(){  
        try{
            $this->db->trans_begin();
            $aDataPdtModel   = array(
                'FTPmoCode' => $this->input->post('oetPmoCode'),
                'FTPmoName' => $this->input->post('oetPmoName'),
                'FTPmoRmk'  => $this->input->post('otaPmoRmk'),
                'FDCreateOn'  => date('Y-m-d H:i:s'),
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'     => $this->session->userdata("tLangEdit"),
                'FTAgnCode'   => $this->input->post('oetPmoAgnCode'),
            );
            $aStaPmoMaster  = $this->mPdtModel->FSaMPMOAddUpdateMaster($aDataPdtModel);
            $aStaPmoLang    = $this->mPdtModel->FSaMPMOAddUpdateLang($aDataPdtModel);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Model"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtModel['FTPmoCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Model'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Delete Product Model
    //Parameters : Ajax jReason()
    //Creator : 21/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPMODeleteEvent(){ 
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPmoCode' => $tIDCode
        );
        $aResDel    = $this->mPdtModel->FSaMPMODelAll($aDataMaster);
        $nNumRowPmo = $this->mPdtModel->FSnMPmoGetAllNumRow();
        if($nNumRowPmo!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPmo' => $nNumRowPmo
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}