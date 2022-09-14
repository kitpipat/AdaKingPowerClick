<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPdtPmgGrp extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtpromotiongroup/mPdtPmgGrp');
    }

    public function index($nPmgBrowseType,$tPmgBrowseOption){
        $aDataConfigView = [
            'nPmgBrowseType'    => $nPmgBrowseType,
            'tPmgBrowseOption'  => $tPmgBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('pdtpmggroup/0/0'),
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('pdtpmggroup/0/0'), 
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        ];
        $this->load->view('product/pdtpromotiongroup/wPdtPromotion',$aDataConfigView);
    }

    //Functionality : Function Call Product Promotion Group Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMGListPage(){
        $aAlwEventPdtPromotion	    = FCNaHCheckAlwFunc('pdtpmggroup/0/0');
        $this->load->view('product/pdtpromotiongroup/wPdtPromotionList', array(
            'aAlwEventPdtPromotion' => $aAlwEventPdtPromotion
        ));
    }

    
    //Functionality : Function Call DataTables Product Promotion Group
    //Parameters : Ajax Call View DataTable
    //Creator : 18/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMGDataList(){
        try{
            $tSearchAll     = $this->input->post('tSearchAll');
            $nPage          = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtPmtGrp_L');
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
                'tSearchAll'    => $tSearchAll
            );

            $aPmgDataList               = $this->mPdtPmgGrp->FSaMPMGList($aData);
            $aAlwEventPdtPromotion	    = FCNaHCheckAlwFunc('pdtpmggroup/0/0');
            $aGenTable  = array(
                'aPmgDataList'          => $aPmgDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPdtPromotion' => $aAlwEventPdtPromotion
            );
            $this->load->view('product/pdtpromotiongroup/wPdtPromotionDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Promotion Group Add
    //Parameters : Ajax Call View Add
    //Creator : 18/09/2018 Witsarut (Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMGAddPage(){
        try{
            $aDataPdtPmgGrp = array(
                'nStaAddOrEdit'   => 99
            );
            $this->load->view('product/pdtpromotiongroup/wPdtPromotionAdd',$aDataPdtPmgGrp);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Function CallPage Product Promotion Group Edits
    //Parameters : Ajax Call View Add
    //Creator : 18/09/2018 Witsarut(Bell)
    //Return : String View
    //Return Type : View
    public function FSvCPMGEditPage(){
        try{
            $tPmgCode       = $this->input->post('tPmgCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aLangHave      = FCNaHGetAllLangByTable('TCNMPdtPmtGrp_L');
            $nLangHave      = FCNnHSizeOf($aLangHave);
            if($nLangHave > 1){
                $nLangEdit  = ($nLangEdit != '')? $nLangEdit : $nLangResort;
            }else{
                $nLangEdit  = (@$aLangHave[0]->nLangList == '')? '1' : $aLangHave[0]->nLangList;
            }

            $aData  = array(
                'FTPmgCode' => $tPmgCode,
                'FNLngID'   => $nLangEdit
            );

            $aPmgData       = $this->mPdtPmgGrp->FSaMPMGGetDataByID($aData);
            $aDataPdtPmgGrp   = array(
                'nStaAddOrEdit' => 1,
                'aPmgData'      => $aPmgData
            );
            $this->load->view('product/pdtpromotiongroup/wPdtPromotionAdd',$aDataPdtPmgGrp);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Add Product Promotion Group
    //Parameters : Ajax Event
    //Creator : 19/09/2018 Witsarut (Bell)
    //Update : 28/03/2019 pap
    //Return : Status Add Event
    //Return Type : String
    public function FSoCPMGAddEvent(){
        try{
            $aDataPdtPmgGrp   = array(
                'tIsAutoGenCode' => $this->input->post('ocbPmtAutoGenCode'),
                'FTPmgCode' => $this->input->post('oetPmtCode'),
                'FTPmgName' => $this->input->post('oetPmtName'),
                'FTPmgRmk'  => $this->input->post('otaPmgRmk'),
                'FDCreateOn' => date('Y-m-d'),
                'FDLastUpdOn' => date('Y-m-d'),
                'FTCreateBy'  => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy'  => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit")
            );
            // Setup Reason Code
            if($aDataPdtPmgGrp['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtPmtGrp',                           
                    "tDocType"    => 0,                                          
                    "tBchCode"    => "",                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d")       
                );
                $aAutogen   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtPmgGrp['FTPmgCode']   = $aAutogen[0]["FTXxhDocNo"];

                // $aGenCode = FCNaHGenCodeV5('TCNMPdtPmtGrp');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtPmgGrp['FTPmgCode'] = $aGenCode['rtPmgCode'];
                // }
            }
            $this->db->trans_begin();
            $aStaPmgMaster  = $this->mPdtPmgGrp->FSaMPMGAddUpdateMaster($aDataPdtPmgGrp);
            $aStaPmgLang    = $this->mPdtPmgGrp->FSaMPMGAddUpdateLang($aDataPdtPmgGrp);
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
                    'tCodeReturn'	=> $aDataPdtPmgGrp['FTPmgCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Add Product Promotion Group'
                );
            }
            
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


    //Functionality : Event Edit Product Promotion Group
    //Parameters : Ajax Event
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Status Edit Event
    //Return Type : String
    public function FSoCPMGEditEvent(){
        try{
            $this->db->trans_begin();
            $aDataPdtPmgGrp   = array(
                'FTPmgCode' => $this->input->post('oetPmtCode'),
                'FTPmgName' => $this->input->post('oetPmtName'),
                'FTPmgRmk'  => $this->input->post('otaPmgRmk'),
                'FDCreateOn' => date('Y-m-d'),
                'FDLastUpdOn'=> date('Y-m-d'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FNLngID'   => $this->session->userdata("tLangEdit")
            );
            $aStaPmgMaster  = $this->mPdtPmgGrp->FSaMPMGAddUpdateMaster($aDataPdtPmgGrp);
            $aStaPmgLang    = $this->mPdtPmgGrp->FSaMPMGAddUpdateLang($aDataPdtPmgGrp);
            if($this->db->trans_status() === false){
                $this->db->trans_rollback();
                $aReturn = array(
                    'nStaEvent'    => '900',
                    'tStaMessg'    => "Unsucess Edit Product Promotion Group"
                );
            }else{
                $this->db->trans_commit();
                $aReturn = array(
                    'nStaCallBack'	=> $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'	=> $aDataPdtPmgGrp['FTPmgCode'],
                    'nStaEvent'	    => '1',
                    'tStaMessg'		=> 'Success Edit Product Promotion Group'
                );
            }
            echo json_encode($aReturn);
        }catch(Exception $Error){
            echo $Error;
        }
    }


     //Functionality : Event Delete Product Promotion Group
    //Parameters : Ajax jReason()
    //Creator : 19/09/2018 Witsarut(Bell)
    //Return : Status Delete Event
    //Return Type : String
    public function FSoCPMGDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTPmgCode' => $tIDCode
        );
        $aResDel    = $this->mPdtPmgGrp->FSaMPMGDelAll($aDataMaster);
        $nNumRowPdtPmg = $this->mPdtPmgGrp->FSnMPMGGetAllNumRow();
        if($nNumRowPdtPmg!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtPmg' => $nNumRowPdtPmg
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }

}