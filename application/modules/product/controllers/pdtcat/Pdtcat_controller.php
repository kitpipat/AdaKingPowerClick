<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class Pdtcat_controller extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('product/pdtcat/Pdtcat_model');
        date_default_timezone_set("Asia/Bangkok");
    }

    public function index($nCatBrowseType,$tCatBrowseOption,$tCatCat){
        $nMsgResp   = array('title'=>"Product Unit");
        $isXHR      = isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtoupper($_SERVER['HTTP_X_REQUESTED_WITH']) === 'XMLHTTPREQUEST';
        if(!$isXHR){
            $this->load->view ( 'common/wHeader', $nMsgResp);
            $this->load->view ( 'common/wTopBar', array ('nMsgResp'=>$nMsgResp));
            $this->load->view ( 'common/wMenu', array ('nMsgResp'=>$nMsgResp));
        }
        $vBtnSave               = FCNaHBtnSaveActiveHTML('masPdtcat/0/0'); //Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
        $aAlwEventPdtCat	    = FCNaHCheckAlwFunc('masPdtcat/0/0');
        $this->load->view('product/pdtcat/wPdtCat', array (
            'nMsgResp'          => $nMsgResp,
            'vBtnSave'          => $vBtnSave,
            'nCatBrowseType'    => $nCatBrowseType,
            'tCatBrowseOption'  => $tCatBrowseOption,
            'aAlwEventPdtCat'  => $aAlwEventPdtCat,
            'tCatCat'  => $tCatCat,

        ));
    }
    //Functionality : Function Call Product Unit Page List
    //Parameters : Ajax and Function Parameter
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCATListPage(){
        $aAlwEventPdtCat	    = FCNaHCheckAlwFunc('masPdtcat/0/0');
        $this->load->view('product/pdtcat/wPdtCatList',array(
            'aAlwEventPdtCat'  =>  $aAlwEventPdtCat
        ));
    }

    //Functionality : Function Call DataTables Product Unit
    //Parameters : Ajax Call View DataTable
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCATDataList(){
        try{
            $tSearchAll = $this->input->post('tSearchAll');
            $nPage      = ($this->input->post('nPageCurrent') == '' || null)? 1 : $this->input->post('nPageCurrent');   // Check Number Page
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'nPage'         => $nPage,
                'nRow'          => 10,
                'FNLngID'       => $nLangEdit,
                'tSearchAll'    => $tSearchAll,
                'tSesAgnCode'   => $this->session->userdata("tSesUsrAgnCode"),
                'tCatCat'       => $this->input->post('tCatCat')
            );
            $aCatDataList           = $this->Pdtcat_model->FSaMCATList($aData);
            $aAlwEventPdtCat	    = FCNaHCheckAlwFunc('masPdtcat/0/0');
            $aGenTable  = array(
                'aCatDataList'          => $aCatDataList,
                'nPage'                 => $nPage,
                'tSearchAll'            => $tSearchAll,
                'aAlwEventPdtCat'      => $aAlwEventPdtCat
            );
            //print_r($aCatDataList);
            $this->load->view('product/pdtcat/wPdtCatDataTable',$aGenTable);
        }catch(Exception $Error){
            echo $Error;
        }
    }

    //Functionality : Function CallPage Product Unit Add
    //Parameters : Ajax Call View Add
    //Creator : 13/09/2018 wasin
    //Return : String View
    //Return Type : View
    public function FSvCCATAddPage(){
        try{
            $aDataPdtCat = array(
                'nStaAddOrEdit'  => 99,
                'tSesAgnCode'    => $this->session->userdata("tSesUsrAgnCode"),
                'tSesAgnName'    => $this->session->userdata("tSesUsrAgnName"),
                'tCatCat'    => $this->input->post('tCatCat')
            );
            $this->load->view('product/pdtcat/wPdtCatAdd',$aDataPdtCat);
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
    public function FSvCCATEditPage(){
        try{
            $tCatCode       = $this->input->post('tCatCode');
            $nLangResort    = $this->session->userdata("tLangID");
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $aData  = array(
                'FTCatCode' => $tCatCode,
                'FNLngID'   => $nLangEdit
            );
            $aCatData       = $this->Pdtcat_model->FSaMCATGetDataByID($aData);
            $aData  = array(
                'FTCatCode' => $aCatData['raItems']['rtCatParent'],
                'FNLngID'   => $nLangEdit
            );
            $aCatDataPar       = $this->Pdtcat_model->FSaMCATGetDataParByID($aData);
            $aDataPdtCat      = array(
                'nStaAddOrEdit' => 1,
                'aCatData'      => $aCatData,
                'aCatDataPar'      => $aCatDataPar,
                'tCatCode' => $tCatCode
            );
            $this->load->view('product/pdtcat/wPdtCatAdd',$aDataPdtCat);
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
    public function FSoCCATAddEvent(){
        if ($this->input->post('oetCatParentCode')=='0') {
          $tCatLevel = '1';
          $tParentCode = '';
        }else {
          $tCatLevel = $this->input->post('oetCatCatHide') + 1;
          $tParentCode = $this->input->post('oetCatParentCode');
        }
        if ($this->input->post('ocbCatStaUse') =='1' ) {
          $tStaUse = 1;
        }else {
          $tStaUse = 2;
        }
        try{
            $aDataPdtCat   = array(
                'tIsAutoGenCode'    => $this->input->post('ocbCatAutoGenCode'),
                'FTCatCode'     => $this->input->post('oetCatCode'),
                'FTCatName'     => $this->input->post('oetCatName'),
                'FTCatStaUse'   => $tStaUse,
                'FNCatLevel'    => $tCatLevel,
                'FTCatParent'   => $tParentCode,
                'FTCatRmk'      => $this->input->post('otaCatRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetCatAgnCode'),
            );

            // Setup Reason Code
            if($aDataPdtCat['tIsAutoGenCode'] == '1'){ // Check Auto Gen Reason Code?
                // Auto Gen Reason Code
                // $aGenCode = FCNaHGenCodeV5('TCNMPdtCat');
                // if($aGenCode['rtCode'] == '1'){
                //     $aDataPdtCat['FTCatCode'] = $aGenCode['rtCatCode'];
                // }

                $aStoreParam = array(
                    "tTblName"    => 'TCNMPdtCatInfo',
                    "tDocType"    => 0,
                    "tBchCode"    => "",
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen                    = FCNaHAUTGenDocNo($aStoreParam);
                $aDataPdtCat['FTCatCode']   = $aAutogen[0]["FTXxhDocNo"];
            }
            $oCountDup      = $this->Pdtcat_model->FSnMCATCheckDuplicate($aDataPdtCat['FTCatCode']);
            $nStaDup        = $oCountDup['counts'];
            if($oCountDup !== FALSE && $nStaDup == 0){
                $this->db->trans_begin();
                $aStaDptMaster  = $this->Pdtcat_model->FSaMCATAddUpdateMaster($aDataPdtCat);
                $aStaDptLang    = $this->Pdtcat_model->FSaMCATAddUpdateLang($aDataPdtCat);
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
                        'tCodeReturn'	=> $aDataPdtCat['FTCatCode'],
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
    public function FSoCCATEditEvent(){
        try{
            if ($this->input->post('oetCatParentCode')=='0') {
              $tParentCode = '';
            }else {
              $tParentCode = $this->input->post('oetCatParentCode');
            }

            if ($this->input->post('ocbCatStaUse') =='1' ) {
              $tStaUse = 1;
            }else {
              $tStaUse = 2;
            }
            $aDataPdtCat   = array(
                'FTCatCode' => $this->input->post('oetCatCode'),
                'FTCatName' => $this->input->post('oetCatName'),
                'FTCatParent'   => $tParentCode,
                'FTCatStaUse'   => $tStaUse,
                'FTCatRmk'      => $this->input->post('otaCatRmk'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername'),
                'FTCreateBy'    => $this->session->userdata('tSesUsername'),
                'FNLngID'       => $this->session->userdata("tLangEdit"),
                'FTAgnCode'     => $this->input->post('oetCatAgnCode'),
            );
            // print_r($aDataPdtCat);
            // exit();
            $this->db->trans_begin();
            $aStaCatMaster  = $this->Pdtcat_model->FSaMCATAddUpdateMaster($aDataPdtCat);
            $aStaCatLang    = $this->Pdtcat_model->FSaMCATAddUpdateLang($aDataPdtCat);
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
                    'tCodeReturn'	=> $aDataPdtCat['FTCatCode'],
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
    public function FSoCCATDeleteEvent(){
        $tIDCode = $this->input->post('tIDCode');
        $aDataMaster = array(
            'FTCatCode' => $tIDCode
        );
        $aResDel        = $this->Pdtcat_model->FSaMCATDelAll($aDataMaster);
        $nNumRowPdtCAT = $this->Pdtcat_model->FSnMCATGetAllNumRow();
        if($nNumRowPdtCAT!==false){
            $aReturn    = array(
                'nStaEvent' => $aResDel['rtCode'],
                'tStaMessg' => $aResDel['rtDesc'],
                'nNumRowPdtCAT' => $nNumRowPdtCAT
            );
            echo json_encode($aReturn);
        }else{
            echo "database error!";
        }
    }








































































}
