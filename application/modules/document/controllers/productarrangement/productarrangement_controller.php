<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class productarrangement_controller extends MX_Controller {

    public $tRouteMenu  = 'docPAM/0/0';
    public $aAlwEvent   = [];

    public function __construct()
    {
        $this->FSxCPAMInitParams();
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('document/productarrangement/productarrangement_model');
        parent::__construct();
    }

    private function FSxCPAMInitParams(){
        $this->aAlwEvent = FCNaHCheckAlwFunc($this->tRouteMenu);
    }

    // nPAMBrowseType = 0 : ใบจัดสินค้า 3 : จัดการใบจัดสินค้า(Monitors)
    public function index($nPAMBrowseType, $tPAMBrowseOption)
    {
        $aParams = array(
            'tDocNo' => $this->input->post('tDocNo')
        );
        
        $aDataConfigView = array(
            'nPAMBrowseType'     => $nPAMBrowseType,
            'tPAMBrowseOption'   => $tPAMBrowseOption,
            'aAlwEvent'          => $this->aAlwEvent, // Controle Event
            'vBtnSave'           => FCNaHBtnSaveActiveHTML($this->tRouteMenu), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'    => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'    => FCNxHGetOptionDecimalSave(),
            'aParams'            => $aParams,
        );
        
        $this->load->view('document/productarrangement/wProductArrangement', $aDataConfigView);
    }

    // แสดง Form Search ข้อมูลในตารางหน้า List
    public function FSvCPAMFormSearchList() {
        $aDataConfigView = array(
            'aAlwEvent'          => $this->aAlwEvent,
        );
        $this->load->view('document/productarrangement/wProductArrangementFormSearchList', $aDataConfigView);
    }

    // แสดงตารางในหน้า List
    public function FSoCPAMDataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage          = $this->input->post('nPageCurrent');
            $nStaBrowse     = $this->input->post('nStaBrowse');

            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            // Page Current 
            if ($nPage == '' || $nPage == null) {
                $nPage = 1;
            } else {
                $nPage = $this->input->post('nPageCurrent');
            }
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID' => $nLangEdit,
                'nPage' => $nPage,
                'nRow' => 20,
                'aDatSessionUserLogIn' => $this->session->userdata("tSesUsrInfo"),
                'aAdvanceSearch' => $aAdvanceSearch
            );
            $aDataList = $this->productarrangement_model->FSaMPAMGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $this->aAlwEvent,
                'aDataList'         => $aDataList,
                'nStaBrowse'        => $nStaBrowse
            );
            $tPAMViewDataTableList = $this->load->view('document/productarrangement/wProductArrangementDataTable', $aConfigView, true);
            $aReturnData = array(
                'tPAMViewDataTableList' => $tPAMViewDataTableList,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // เลขที่เอกสารอ้างอิงมาแสดงในตาราง browse
    public function FSoCPAMCallRefIntDoc(){
        $tBCHCode   = $this->input->post('tBCHCode');
        $tBCHName   = $this->input->post('tBCHName');

        $aDataParam = array(
            'tBCHCode' => $tBCHCode,
            'tBCHName' => $tBCHName
        );
        
        $this->load->view('document/productarrangement/refintdocument/wProductArrangementRefDoc', $aDataParam);
    }

    // เลขที่เอกสารอ้างอิงมาแสดงในตาราง browse & Search
    public function FSoCPAMCallRefIntDocDataTable(){
        $nPage                  = $this->input->post('nPAMRefIntPageCurrent');
        $tPAMRefIntBchCode       = $this->input->post('tPAMRefIntBchCode');
        $tPAMRefIntDocNo         = $this->input->post('tPAMRefIntDocNo');
        $tPAMRefIntDocDateFrm    = $this->input->post('tPAMRefIntDocDateFrm');
        $tPAMRefIntDocDateTo     = $this->input->post('tPAMRefIntDocDateTo');
        $tPAMRefIntStaDoc        = $this->input->post('tPAMRefIntStaDoc');
        // Page Current 
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nPAMRefIntPageCurrent');
        }
        // Lang ภาษา
        $nLangEdit = $this->session->userdata("tLangEdit");
        $aDataParamFilter = array(
            'tPAMRefIntBchCode'      => $tPAMRefIntBchCode,
            'tPAMRefIntDocNo'        => $tPAMRefIntDocNo,
            'tPAMRefIntDocDateFrm'   => $tPAMRefIntDocDateFrm,
            'tPAMRefIntDocDateTo'    => $tPAMRefIntDocDateTo,
            'tPAMRefIntStaDoc'       => $tPAMRefIntStaDoc,
        );
        // Data Conditon Get Data Document
        $aDataCondition = array(
            'FNLngID'   => $nLangEdit,
            'nPage'     => $nPage,
            'nRow'      => 10,
            'aAdvanceSearch' => $aDataParamFilter
        );
        $aDataParam = $this->productarrangement_model->FSoMPAMCallRefIntDocDataTable($aDataCondition);
        $aConfigView = array(
            'nPage' => $nPage,
            'aDataList' => $aDataParam,
        );
        $this->load->view('document/productarrangement/refintdocument/wProductArrangementRefDocDataTable', $aConfigView);
    }

    // เอารายการจากเอกสารอ้างอิงมาแสดงในตาราง browse
    public function FSoCPAMCallRefIntDocDetailDataTable(){
        $nLangEdit          = $this->session->userdata("tLangEdit");
        $tBchCode           = $this->input->post('ptBchCode');
        $tDocNo             = $this->input->post('ptDocNo');
        $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
        $aDataCondition     = array(
            'FNLngID'   => $nLangEdit,
            'tBchCode'  => $tBchCode,
            'tDocNo'    => $tDocNo
        );
        $aDataParam = $this->productarrangement_model->FSoMPAMCallRefIntDocDTDataTable($aDataCondition);
        $aConfigView = array(
            'aDataList'         => $aDataParam,
            'nOptDecimalShow'   => $nOptDecimalShow
        );
        $this->load->view('document/productarrangement/refintdocument/wProductArrangementRefDocDetailDataTable', $aConfigView);
    }

    // เอารายการที่เลือกจากเอกสารอ้างอิงภายในลงตาราง temp dt
    public function FSoCPAMCallRefIntDocInsertDTToTemp(){
        $tPAMDocNo       =  $this->input->post('tPAMDocNo');
        $tPAMFrmBchCode  =  $this->input->post('tPAMFrmBchCode');
        $tRefIntDocNo   =  $this->input->post('tRefIntDocNo');
        $tRefIntBchCode =  $this->input->post('tRefIntBchCode');
        $aSeqNo         =  $this->input->post('aSeqNo');
       
        $aDataParam = array(
            'tPAMDocNo'       => $tPAMDocNo,
            'tPAMFrmBchCode'  => $tPAMFrmBchCode,
            'tRefIntDocNo'   => $tRefIntDocNo,
            'tRefIntBchCode' => $tRefIntBchCode,
            'aSeqNo'         => $aSeqNo,
        );
        
       $aDataResult = $this->productarrangement_model->FSoMPAMCallRefIntDocInsertDTToTemp($aDataParam);
       return  $aDataResult;
    }

    // เรียกหน้าเพิ่มข้อมูล
    public function FSoCPAMPageAdd() {
        try {
            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => '',
                'FTXthDocKey' => 'TAPTDoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];

            $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->productarrangement_model->FSaMPAMGetDetailUserBranch($tUserBchCode);
                $tPAMPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tPAMPplCode = '';
            }
     

            $this->productarrangement_model->FSaMCENDeletePDTInTmp($aWhereClearTemp);
            $this->productarrangement_model->FSxMPAMClearDataInDocTemp($aWhereClearTemp);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            $aWhereHelperCalcDTTemp = array(
                'tDataDocEvnCall' => "",
                'tDataVatInOrEx' => 1,
                'tDataDocNo' => '',
                'tDataDocKey' => 'TCNTPdtPickDT',
                'tDataSeqNo' => ''
            );
            FCNbHCallCalcDocDTTemp($aWhereHelperCalcDTTemp);

            $aDataComp = FCNaGetCompanyForDocument();

            $tBchCode = $aDataComp['tBchCode'];
            $tCmpRteCode = $aDataComp['tCmpRteCode'];
            $tVatCode = $aDataComp['tVatCode'];
            $cVatRate = $aDataComp['cVatRate'];
            $cXthRteFac = $aDataComp['cXthRteFac'];
            $tCmpRetInOrEx = $aDataComp['tCmpRetInOrEx'];
            

            // Get Department Code
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $aDataShp = array(
                'FNLngID' => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );
            $aDataUserGroup = $this->productarrangement_model->FSaMPAMGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tBchCode = "";
                $tBchName = "";
                $tMerCode = "";
                $tMerName = "";
                $tShopType = "";
                $tShopCode = "";
                $tShopName = "";
                $tWahCode = "";
                $tWahName = "";
            } else {
                $tBchCode = $aDataUserGroup["FTBchCode"];
                $tBchName = $aDataUserGroup["FTBchName"];
                $tMerCode = $aDataUserGroup["FTMerCode"];
                $tMerName = $aDataUserGroup["FTMerName"];
                $tShopType = $aDataUserGroup["FTShpType"];
                $tShopCode = $aDataUserGroup["FTShpCode"];
                $tShopName = $aDataUserGroup["FTShpName"];
                $tWahCode = $aDataUserGroup["FTWahCode"];
                $tWahName = $aDataUserGroup["FTWahName"];
            }

            // ดึงข้อมูลที่อยู่คลัง Defult ในตาราง TSysConfig
            $aConfigSys = [
                'FTSysCode' => 'tPS_Warehouse',
                'FTSysSeq' => 3,
                'FNLngID' => $nLangEdit
            ];
            $aConfigSysWareHouse = $this->productarrangement_model->FSaMPAMGetDefOptionConfigWah($aConfigSys);

            
            $aDataConfigViewAdd = array(
                'nOptDecimalShow' => $nOptDecimalShow,
                'nOptDocSave' => $nOptDocSave,
                'nOptScanSku' => $nOptScanSku,
                'tCmpRteCode' => $tCmpRteCode,
                'tVatCode' => $tVatCode,
                'cVatRate' => $cVatRate,
                'cXthRteFac' => $cXthRteFac,
                'tDptCode' => $tDptCode,
                'tBchCode' => $tBchCode,
                'tBchName' => $tBchName,
                'tMerCode' => $tMerCode,
                'tMerName' => $tMerName,
                'tShopType' => $tShopType,
                'tShopCode' => $tShopCode,
                'tShopName' => $tShopName,
                'tWahCode' => $tWahCode,
                'tWahName' => $tWahName,
                'tBchCompCode' => FCNtGetBchInComp(),
                'tBchCompName' => FCNtGetBchNameInComp(),
                'aConfigSysWareHouse' => $aConfigSysWareHouse,
                'aDataDocHD' => array('rtCode' => '800'),
                'aDataDocHDSpl' => array('rtCode' => '800'),
                'tCmpRetInOrEx' => $tCmpRetInOrEx,
                'tPAMPplCode'  => $tPAMPplCode
            );
            
            $tPAMViewPageAdd = $this->load->view('document/productarrangement/wProductArrangementPageAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tPAMViewPageAdd' => $tPAMViewPageAdd,
                'nStaEvent' => '1',
                'tStaMessg' => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // แสดงผลลัพธ์การค้นหาขั้นสูง
    public function FSoCPAMPdtAdvTblLoadData() {
        try {
            $bStaSession    =   $this->session->userdata('bSesLogIn');
            if(isset($bStaSession) && $bStaSession === TRUE){
                //ยังมี Session อยู่
            }else{
                $aReturnData = array(
                    'checksession' => 'expire'
                );
                echo json_encode($aReturnData);
            }

            $tPAMDocNo           = $this->input->post('ptPAMDocNo');
            $tPAMStaApv          = $this->input->post('ptPAMStaApv');
            $tPAMStaDoc          = $this->input->post('ptPAMStaDoc');
            $tPAMVATInOrEx       = $this->input->post('ptPAMVATInOrEx');
            $nPAMPageCurrent     = $this->input->post('pnPAMPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            $tPAMPdtCode         = $this->input->post('ptPAMPdtCode');
            $tPAMPunCode         = $this->input->post('ptPAMPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            // $tTableGetColumeShow    = 'TCNTPdtPickDT';
            // $aColumnShow            = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tPAMDocNo,
                'FTXthDocKey'           => 'TCNTPdtPickDT',
                'nPage'                 => $nPAMPageCurrent,
                'nRow'                  => 90000,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
                'FNXthDocType'          => $this->input->post('ptPAMDocType')
            );
            // FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->productarrangement_model->FSaMPAMGetDocDTTempListPage($aDataWhere);
            $aAlwEnterSN        = $this->productarrangement_model->FSaMPAMChkAlwEnterSN($aDataWhere);

            $aDataView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tPAMStaApv'         => $tPAMStaApv,
                'tPAMStaDoc'         => $tPAMStaDoc,
                'tPAMPdtCode'        => $tPAMPdtCode,
                'tPAMPunCode'        => $tPAMPunCode,
                'nPage'             => $nPAMPageCurrent,
                'aColumnShow'       => array(),
                'aDataDocDTTemp'    => $aDataDocDTTemp,
                'aAlwEnterSN'       => $aAlwEnterSN
            );
            
            $tPAMPdtAdvTableHtml = $this->load->view('document/productarrangement/wProductArrangementPdtAdvTableData', $aDataView, true);

            $aReturnData = array(
                'tPAMPdtAdvTableHtml' => $tPAMPdtAdvTableHtml,
                'nStaEvent' => '1',
                'tStaMessg' => "Fucntion Success Return View."
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Add สินค้า ลง Document DT Temp
    public function FSoCPAMAddPdtIntoDocDTTemp() {
        try {
            $tPAMUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tPAMDocNo           = $this->input->post('tPAMDocNo');
            $tPAMVATInOrEx       = $this->input->post('tPAMVATInOrEx');
            $tPAMBchCode         = $this->input->post('tSelectBCH');
            $tPAMOptionAddPdt    = $this->input->post('tPAMOptionAddPdt');
            $tPAMPdtData         = $this->input->post('tPAMPdtData');
            $aPAMPdtData         = json_decode($tPAMPdtData);
            $nVatRate           = $this->input->post('nVatRate');
            $nVatCode           = $this->input->post('nVatCode');

            $aDataWhere = array(
                'FTBchCode' => $tPAMBchCode,
                'FTXthDocNo' => $tPAMDocNo,
                'FTXthDocKey' => 'TCNTPdtPickDT',
            );

            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aPAMPdtData); $nI++) {
                $tPAMPdtCode = $aPAMPdtData[$nI]->pnPdtCode;
                $tPAMBarCode = $aPAMPdtData[$nI]->ptBarCode;
                $tPAMPunCode = $aPAMPdtData[$nI]->ptPunCode;
  
     
                $cPAMPrice       = $aPAMPdtData[$nI]->packData->Price;
                $aDataPdtParams = array(
                    'tDocNo'            => $tPAMDocNo,
                    'tBchCode'          => $tPAMBchCode,
                    'tPdtCode'          => $tPAMPdtCode,
                    'tBarCode'          => $tPAMBarCode,
                    'tPunCode'          => $tPAMPunCode,
                    'cPrice'            => str_replace(",","",$cPAMPrice),
                    'nMaxSeqNo'         => $this->input->post('tSeqNo'),
                    'nLngID'            => $this->input->post("ohdPAMLangEdit"),
                    // 'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tSessionID'        => $this->input->post('ohdSesSessionID'),
                    'tDocKey'           => 'TCNTPdtPickDT',
                    'tPAMOptionAddPdt'   => $tPAMOptionAddPdt,
                    'tPAMUsrCode'        => $this->input->post('ohdPAMUsrCode'),
                    'nVatRate'          => $nVatRate,
                    'nVatCode'          => $nVatCode
                );
                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->productarrangement_model->FSaMPAMGetDataPdt($aDataPdtParams);
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp = $this->productarrangement_model->FSaMPAMInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Product Error Please Contact Admin.'
                );
            } else {
                $this->db->trans_commit();
                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Add Product Into Document DT Temp.'
                    );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Remove Product In Documeny Temp
    public function FSvCPAMRemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                'tPAMDocNo' => $this->input->post('tDocNo'),
                'tBchCode' => $this->input->post('tBchCode'),
                'tPdtCode' => $this->input->post('tPdtCode'),
                'nSeqNo'   => $this->input->post('nSeqNo'),
                'tDocKey'  => 'TCNTPdtPickDT',
                'tSessionID' => $this->session->userdata('tSesSessionID'),
            );

            $aStaDelPdtDocTemp = $this->productarrangement_model->FSnMPAMDelPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Delete Product'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //Remove Product In Documeny Temp Multiple
    public function FSvCPAMRemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tPAMDocNo' => $this->input->post('tDocNo'),
                'tBchCode' => $this->input->post('tBchCode'),
                'tPdtCode' => $this->input->post('tPdtCode'),
                'nSeqNo'   => $this->input->post('nSeqNo'),
                'tDocKey'  => 'TCNTPdtPickDT',
                'tSessionID' => $this->session->userdata('tSesSessionID'),
            );

            $aStaDelPdtDocTemp = $this->productarrangement_model->FSnMPAMDelMultiPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success Delete Product'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Edit Inline สินค้า ลง Document DT Temp
    public function FSoCPAMEditPdtIntoDocDTTemp() {
        try {

            $tPAMBchCode         = $this->input->post('tPAMBchCode');
            $tPAMDocNo           = $this->input->post('tPAMDocNo');
            $nPAMSeqNo           = $this->input->post('nPAMSeqNo');

            $tPAMType            = $this->input->post('tPAMType');
            $tPAMValue           = $this->input->post('tPAMValue');
            $cPAMFactor          = $this->input->post('cPAMFactor');

            $tPAMSessionID       = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tPAMBchCode'    => $tPAMBchCode,
                'tPAMDocNo'      => $tPAMDocNo,
                'nPAMSeqNo'      => $nPAMSeqNo,
                'tPAMSessionID'  => $tPAMSessionID,
                'tDocKey'       => 'TCNTPdtPickDT',
            );
            if( $tPAMType == 'Qty' ){
                $aDataUpdateDT = array(
                    'FCXtdQty'          => floatval($tPAMValue),
                    'FCXtdQtyAll'       => floatval($tPAMValue) * floatval($cPAMFactor)
                );
            }else{
                $aDataUpdateDT = array(
                    'FTXtdRmk'          => strval($tPAMValue)
                );
            }   

            $this->db->trans_begin();
            $this->productarrangement_model->FSaMPAMUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

            if($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Error Update Inline Into Document DT Temp."
                );
            }else{
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => "Update Inline Into Document DT Temp."
                );
            }
            
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Check Product Have In Temp For Document DT
    public function FSoCPAMChkHavePdtForDocDTTemp() {
        try {
            $tPAMDocNo = $this->input->post("ptPAMDocNo");
            $tPAMSessionID = $this->input->post('tPAMSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo' => $tPAMDocNo,
                'FTXthDocKey' => 'TCNTPdtPickDT',
                'FTSessionID' => $tPAMSessionID
            );
            $nCountPdtInDocDTTemp = $this->productarrangement_model->FSnMPAMChkPdtInDocDTTemp($aDataWhere);
            
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn' => '800',
                    'tStaMessg' => language('document/productarrangement/productarrangement', 'tPAMPleaseSeletedPDTIntoTable')
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Add Document 
    public function FSoCPAMAddEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tPAMAutoGenCode = (isset($aDataDocument['ocbPAMStaAutoGenCode'])) ? 1 : 0;
            $tPAMDocNo = (isset($aDataDocument['oetPAMDocNo'])) ? $aDataDocument['oetPAMDocNo'] : '';
            $tPAMDocDate = $aDataDocument['oetPAMDocDate'] . " " . $aDataDocument['oetPAMDocTime'];
            $tPAMStaDocAct = (isset($aDataDocument['ocbPAMFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tPAMVATInOrEx = $aDataDocument['ocmPAMFrmSplInfoVatInOrEx'];
            $tPAMSessionID = $this->input->post('ohdSesSessionID');
            $nPAMSubmitWithImp = $aDataDocument['ohdPAMSubmitWithImp'];

            // Get Data Comp.
            $nLangEdit = $this->input->post("ohdPAMLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tAPAMReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tAPAMReq, $tMethodReq, $aDataWhereComp);
            $aClearDTParams = [
                'FTXthDocNo'     => $tPAMDocNo,
                'FTXthDocKey'    => 'TCNTPdtPickDT',
                'FTSessionID'    => $this->input->post('ohdSesSessionID'),
            ];

            if($nPAMSubmitWithImp==1){
                $this->productarrangement_model->FSxMPAMClearDataInDocTempForImp($aClearDTParams);
            }

            // Check Auto GenCode Document
            if ($tPAMAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtPickHD',                           
                    "tDocType"    => '11',                                          
                    "tBchCode"    => $aDataDocument['oetPAMBchCode'],                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $tPAMDocNo   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $tPAMDocNo = $tPAMDocNo;
            }


            //-----------------------------------------------------------------------------
            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TAPTDoHD',
                'tTableHDSpl' => 'TAPTDoHDSpl',
                'tTableDT' => 'TCNTPdtPickDT',
                'tTableStaGen' => 11,
                'tTableRefPAM' => 'TAPTDoHDDocRef',
                'tTableRefPO' => 'TAPTPoHDDocRef'
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetPAMBchCode'],
                'FTXphDocNo' => $tPAMDocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->input->post('ohdPAMUsrCode'),
                'FTLastUpdBy' => $this->input->post('ohdPAMUsrCode'),
                'FTSessionID' => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx' => $tPAMVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                //'FTBchCode' =>  $aDataDocument['oetPAMBchCode'],
                'FNXphDocType' => 11,
                'FDXphDocDate' => (!empty($tPAMDocDate)) ? $tPAMDocDate : NULL,
                'FTXphCshOrCrd' => $aDataDocument['ocmPAMTypePayment'],
                'FTXphVATInOrEx' => $tPAMVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdPAMDptCode'],
                'FTWahCode' => $aDataDocument['oetPAMFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdPAMUsrCode'],
                'FTSplCode' => $aDataDocument['oetPAMFrmSplCode'],
                'FTXphRefExt' => $aDataDocument['oetPAMSplRefDocExt'],
                'FDXphRefExtDate' => (!empty($aDataDocument['oetPAMRefDocExtDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPAMRefDocExtDate'])) : NULL,
                'FTXphRefInt' => $aDataDocument['oetPAMRefDocIntName'],
                'FDXphRefIntDate' => (!empty($aDataDocument['oetPAMRefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPAMRefIntDocDate'])) : NULL,
                'FNXphDocPrint' => $aDataDocument['ocmPAMFrmInfoOthDocPrint'],
                'FTXphRmk' => $aDataDocument['otaPAMFrmInfoOthRmk'],
                'FTXphStaDoc' => $aDataDocument['ohdPAMStaDoc'],
                'FTXphStaApv' => !empty($aDataDocument['ohdPAMStaApv']) ? $aDataDocument['ohdPAMStaApv'] : NULL,
                'FTXphStaDelMQ' => $aDataDocument['ohdPAMStaDelMQ'],
                'FTXphStaPrcStk' => $aDataDocument['ohdPAMStaPrcStk'],
                'FNXphStaDocAct' => $tPAMStaDocAct,
                'FNXphStaRef' => $aDataDocument['ocmPAMFrmInfoOthRef']
            );

            // Array Data HD Supplier date('Y-m-d H:i:s', $old_date_timestamp);
            $aDataSpl = array(
                'FNXphCrTerm' => intval($aDataDocument['oetPAMFrmSplInfoCrTerm']),
                'FTXphCtrName' => $aDataDocument['oetPAMFrmSplInfoCtrName'],
                'FDXphTnfDate' => (!empty($aDataDocument['oetPAMFrmSplInfoTnfDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPAMFrmSplInfoTnfDate'])) : NULL,
                'FTXphRefTnfID' => $aDataDocument['oetPAMFrmSplInfoRefTnfID'],
                'FTXphRefVehID' => $aDataDocument['oetPAMFrmSplInfoRefVehID'],
            );

            // if ($aDataDocument['oetPAMRefDocIntName'] != '') {
            //     $aDataWhereDocRefPAM = array(
            //         'FTAgnCode'         => $this->input->post('oetPAMAgnCode'),
            //         'FTBchCode'         => $aDataDocument['oetPAMBchCode'],
            //         'FTXshDocNo'        => $tPAMDocNo,
            //         'FTXshRefType'      => 1,
            //         'FTXshRefDocNo'     => $aDataDocument['oetPAMRefDocIntName'],
            //         'FTXshRefKey'       => 'PO',
            //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetPAMRefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPAMRefIntDocDate'])) : NULL
            //     );
    
            //     $aDataWhereDocRefPO = array(
            //         'FTAgnCode'         => $this->input->post('oetPAMAgnCode'),
            //         'FTBchCode'         => $aDataDocument['oetPAMBchCode'],
            //         'FTXshDocNo'        => $aDataDocument['oetPAMRefDocIntName'],
            //         'FTXshRefType'      => 2,
            //         'FTXshRefDocNo'     => $tPAMDocNo,
            //         'FTXshRefKey'       => 'PAM',
            //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetPAMRefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPAMRefIntDocDate'])) : NULL
            //     );
            // }else{
            //     $aDataWhereDocRefPAM = '';
            //     $aDataWhereDocRefPO = '';
            // }

            // if ($aDataDocument['oetPAMSplRefDocExt'] != '') {
            //     $aDataWhereDocRefPAMExt = array(
            //         'FTAgnCode'         => $this->input->post('oetPAMAgnCode'),
            //         'FTBchCode'         => $aDataDocument['oetPAMBchCode'],
            //         'FTXshDocNo'        => $tPAMDocNo,
            //         'FTXshRefType'      => 3,
            //         'FTXshRefDocNo'     => $aDataDocument['oetPAMSplRefDocExt'],
            //         'FTXshRefKey'       => 'PAM',
            //         'FDXshRefDocDate'   => (!empty($aDataDocument['oetPAMRefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPAMRefIntDocDate'])) : NULL
            //     );
            // }else{
            //     $aDataWhereDocRefPAMExt = '';
            // }

            $this->db->trans_begin();

            // Add Update Document HD
            $this->productarrangement_model->FSxMPAMAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update Document HD Spl
            // $this->productarrangement_model->FSxMPAMAddUpdateHDSpl($aDataSpl, $aDataWhere, $aTableAddUpdate);

            // [Update] DocNo -> Temp
            $this->productarrangement_model->FSxMPAMAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->productarrangement_model->FSaMPAMMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            //insert Doc ref
            // $this->productarrangement_model->FSaMPAMQaAddUpdateRefDocHD($aDataWhere, $aTableAddUpdate, $aDataWhereDocRefPAM, $aDataWhereDocRefPO, $aDataWhereDocRefPAMExt);
            
            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Add Document."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaCallBack' => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn' => $aDataWhere['FTXphDocNo'],
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Success Add Document.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function: Add Document 
    public function FSoCPAMEditEventDoc() {
        try {
            $aDataDocument      = $this->input->post();
            $tPAMAutoGenCode    = (isset($aDataDocument['ocbPAMStaAutoGenCode'])) ? 1 : 0;
            $tPAMDocNo          = (isset($aDataDocument['oetPAMDocNo'])) ? $aDataDocument['oetPAMDocNo'] : '';
            $tPAMDocDate        = $aDataDocument['oetPAMDocDate'] . " " . $aDataDocument['oetPAMDocTime'];
            $tPAMStaDocAct      = (isset($aDataDocument['ocbPAMFrmInfoOthStaDocAct'])) ? 1 : 0;
            // $tPAMVATInOrEx = $aDataDocument['ocmPAMFrmSplInfoVatInOrEx'];
            $tPAMSessionID      = $this->input->post('ohdSesSessionID');
            $nPAMSubmitWithImp  = $aDataDocument['ohdPAMSubmitWithImp'];
            
            // Get Data Comp.
            $nLangEdit = $this->input->post("ohdPAMLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tAPAMReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tAPAMReq, $tMethodReq, $aDataWhereComp);
            $aClearDTParams = [
                'FTXthDocNo'     => $tPAMDocNo,
                'FTXthDocKey'    => 'TCNTPdtPickDT',
                'FTSessionID'    => $this->input->post('ohdSesSessionID'),
            ];
            if($nPAMSubmitWithImp==1){
                $this->productarrangement_model->FSxMPAMClearDataInDocTempForImp($aClearDTParams);
            }

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD'      => 'TCNTPdtPickHD',
                'tTableDTSN'    => 'TCNTPdtPickDTSN',
                'tTableDT'      => 'TCNTPdtPickDT'
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode'     => $aDataDocument['oetPAMBchCode'],
                'FTXthDocNo'    => $tPAMDocNo,
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FDCreateOn'    => date('Y-m-d H:i:s'),
                'FTCreateBy'    => $this->input->post('ohdPAMUsrCode'),
                'FTLastUpdBy'   => $this->input->post('ohdPAMUsrCode'),
                'FTSessionID'   => $this->input->post('ohdSesSessionID')
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTXthRmk'       => $aDataDocument['otaPAMFrmInfoOthRmk'],
                'FNXthStaDocAct' => $tPAMStaDocAct
            );

            $this->db->trans_begin();

            // Add Update Document HD
            $this->productarrangement_model->FSxMPAMAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // [Update] DocNo -> Temp
            $this->productarrangement_model->FSxMPAMAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->productarrangement_model->FSaMPAMMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move DTSNTemp To DTSN
            $this->productarrangement_model->FSxMPAMMoveDTSNTmpToDTSN($aDataWhere, $aTableAddUpdate);

            //insert Doc ref
            // $this->productarrangement_model->FSaMPAMQaAddUpdateRefDocHD($aDataWhere, $aTableAddUpdate, $aDataWhereDocRefPAM, $aDataWhereDocRefPO, $aDataWhereDocRefPAMExt);
            
            // Check Status Transection DB
            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '900',
                    'tStaMessg' => "Error Unsucess Edit Document."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaCallBack'  => $this->session->userdata('tBtnSaveStaActive'),
                    'tCodeReturn'   => $aDataWhere['FTXthDocNo'],
                    'nStaReturn'    => '1',
                    'tStaMessg'     => 'Success Edit Document.'
                );
            }

        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //หน้าจอแก้ไข
    public function FSvCPAMEditPage(){
        try {
            $ptDocumentNumber = $this->input->post('ptPAMDocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->productarrangement_model->FSnMPAMDelALLTmp($aWhereClearTemp);

            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Array Data Where Get
            $aDataWhere = array(
                'FTXthDocNo'    => $ptDocumentNumber,
                'FTXthDocKey'   => 'TCNTPdtPickDT',
                'FNLngID'       => $nLangEdit,
                'nRow'          => 90000,
                'nPage'         => 1,
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );

            // Get Autentication Route
            // $aAlwEvent         = FCNaHCheckAlwFunc($this->tRouteMenu); // Controle Event
            $vBtnSave          = FCNaHBtnSaveActiveHTML($this->tRouteMenu); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            $nOptDecimalShow   = FCNxHGetOptionDecimalShow();
            $nOptDecimalSave   = FCNxHGetOptionDecimalSave();
            $nOptDocSave       = FCNnHGetOptionDocSave();

            // $aAlwEvent = array(
            //     'tAutStaFull' => 1,
            //     'tAutStaRead' => 1,
            //     'tAutStaAdd' => 1,
            //     'tAutStaEdit' => 1,
            //     'tAutStaDelete' => 1,
            //     'tAutStaCancel' => 1,
            //     'tAutStaAppv' => 1,
            //     'tAutStaPrint' => 1,
            //     'tAutStaPrintMore' => 1,
            //     'tAutStaFavorite' => 1
            // );

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->productarrangement_model->FSaMPAMGetDataDocHD($aDataWhere);
            
            // Move Data DT TO DTTemp
            $this->productarrangement_model->FSxMPAMMoveDTToDTTemp($aDataWhere);

            // Move Data DTSN TO DTSNTemp
            $this->productarrangement_model->FSxMPAMMoveDTSNToDTSNTemp($aDataWhere);

            // Move Data HDDocRef TO HDRefTemp
            $this->productarrangement_model->FSxMPAMMoveHDRefToHDRefTemp($aDataWhere);

            // อัพเดทสถานะ ใบจ่ายโอน-สาขา FTXthStaPrcDoc = '3'(กำลังจัดสินค้า)
            $this->productarrangement_model->FSxMPAMUpdStaPackingTBO($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
                
            } else {
                $this->db->trans_commit();

                $aWhere = array(
                    'FTUfrGrpRef'   => '068',
                    'FTUfrRef'      => 'KB038' //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
                );
                $bAlwQtyPickNotEqQtyOrd = FCNbGetUsrFuncRpt($aWhere);

                $aDataConfigViewEdit = array(
                    'aAlwEvent'                 => $this->aAlwEvent,
                    'vBtnSave'                  => $vBtnSave,
                    'nOptDecimalShow'           => $nOptDecimalShow,
                    'nOptDecimalSave'           => $nOptDecimalSave,
                    'nOptDocSave'               => $nOptDocSave,
                    'aRateDefault'              => '',
                    'aDataDocHD'                => $aDataDocHD,
                    'bAlwQtyPickNotEqQtyOrd'    => $bAlwQtyPickNotEqQtyOrd
                );
                
                $tViewPageEdit           = $this->load->view('document/productarrangement/wProductArrangementPageAdd',$aDataConfigViewEdit,true);
                $aReturnData = array(
                    'tViewPageEdit'      => $tViewPageEdit,
                    'nStaEvent'         => '1',
                    'tStaMessg'         => 'Success'
                );
            }
            
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function Delete Document
    public function FSoCPAMDeleteEventDoc() {
        try {
            $tDataDocNo = $this->input->post('tDataDocNo');
            $tBchCode   = $this->input->post('tBchCode');
            // $tRefInDocNo = $this->input->post('tPAMRefInCode');

            // if (!empty($tRefInDocNo)) {
            //     $nStaRef = '0';
            //     $this->productarrangement_model->FSaMPAMUpdatePOStaRef($tRefInDocNo, $nStaRef);
            // }
            
            $aDataMaster = array(
                'tDataDocNo'    => $tDataDocNo,
                'tBchCode'      => $tBchCode
            );
            $aResDelDoc = $this->productarrangement_model->FSnMPAMDelDocument($aDataMaster);
            if ($aResDelDoc['rtCode'] == '1') {
                $aDataStaReturn = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
                );
            } else {
                $aDataStaReturn = array(
                    'nStaEvent' => $aResDelDoc['rtCode'],
                    'tStaMessg' => $aResDelDoc['rtDesc']
                );
            }
        } catch (Exception $Error) {
            $aDataStaReturn = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aDataStaReturn);
    }

    // Function: Cancel Status Document
    public function FSvCPAMCancelDocument() {
        try {
            // $tPAMDocNo = $this->input->post('ptPAMDocNo');
            // $tRefInDocNo = $this->input->post('ptRefInDocNo');

            // if (!empty($tRefInDocNo)) {
            //     $nStaRef = '0';
            //     $this->productarrangement_model->FSaMPAMUpdatePOStaRef($tRefInDocNo, $nStaRef);
            // }

            $aDataUpdate = array(
                'tDocNo'        => $this->input->post('ptPAMDocNo'),
                'tDocType'      => $this->input->post('ptPAMDocType'),
                'FDLastUpdOn'   => date('Y-m-d H:i:s'),
                'FTLastUpdBy'   => $this->session->userdata('tSesUsername')
            );
            $aAlwCancel = $this->productarrangement_model->FSbMPAMChkDocRefAlwCancel($aDataUpdate);
            if( $aAlwCancel['bAlwCancel'] === true ){
                $this->db->trans_begin();
                
                if( $aDataUpdate['tDocType'] == '1' ){
                    // ปรับสถานะ ใบจ่ายโอน-สาขา FTXthStaPrcDoc = '1'(รอสร้างใบจัด)
                    $this->productarrangement_model->FSxMPAMUpdTboOnCancelOrDelete($aDataUpdate);
                }else{
                    // ปรับสถานะ ใบขาย FTXthStaPrcDoc = '1'(รอสร้างใบจัด)
                    $this->productarrangement_model->FSxMPAMUpdSaleOnCancelOrDelete($aDataUpdate);
                }
                
                // ปรับสถานะใบจัดสินค้า = ยกเลิก
                // เคลียร์ HDDocRef ของใบจัดสินค้า และใบจ่ายโอน-สาขา
                $this->productarrangement_model->FSxMPAMCancelDocument($aDataUpdate);

                if($this->db->trans_status() === FALSE){
                    $this->db->trans_rollback();
                    $aReturnData = array(
                        'nStaEvent' => '900',
                        'tStaMessg' => $this->db->error()['message']
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => "Update Status Document Cancel Success."
                    );
                }
            }else{
                $aReturnData = array(
                    'nStaEvent' => '800',
                    'tStaMessg' => $aAlwCancel['tDesc']
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    //อนุมัติเอกสาร
    public function FSoCPAMApproveEvent(){
        try{
            $aDataUpdate = array(
                'FTBchCode'         => $this->input->post('tBchCode'),
                'FTXthDocNo'        => $this->input->post('tDocNo'),
                'FNXthDocType'      => $this->input->post('tDocType'),
                'FTXthStaApv'       => 1,
                'FTXthUsrApv'       => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s')
            );

            $tAlwQtyPickNotEqQtyOrd = $this->input->post('tAlwQtyPickNotEqQtyOrd');
            if( $tAlwQtyPickNotEqQtyOrd == 'false' ){ //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
                $bChkPdtSN = $this->productarrangement_model->FSbMPAMChkQtyPdt($aDataUpdate);
                if( $bChkPdtSN === true ){
                    $aReturnData = array(
                        'nStaEvent' => '800',
                        'tStaMessg' => "พบสินค้าบางรายการ จำนวนจัดไม่เท่ากับจำนวน"
                    );
                    echo json_encode($aReturnData);
                    return;
                }
            }
            
            $this->db->trans_begin();
            $this->productarrangement_model->FSxMPAMApproveDocument($aDataUpdate);
            $this->productarrangement_model->FSxMPAMCheckDocRef($aDataUpdate);
            
            if( $this->db->trans_status() === FALSE ){
                $this->db->trans_rollback();
                $aReturnData     = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => $this->db->error()['message'],
                );
            }else{
                $this->db->trans_commit();
                $aReturnData     = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'Approve Success.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    //อนุมัติเอกสาร
    public function FSoCPAMPageHDDocRefList(){
        try{
            $tDocNo = ( !empty($this->input->post('ptDocNo')) ? $this->input->post('ptDocNo') : '');

            $aDataWhere = [
                'tTableHDDocRef'    => 'TCNTPdtPickHDDocRef',
                'tTableTmpHDRef'    => 'TCNTDocHDRefTmp',
                'FTXthDocNo'        => $tDocNo,
                'FTXthDocKey'       => 'TCNTPdtPickHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];

            $aDataDocHDRef = $this->productarrangement_model->FSaMPAMGetDataHDRefTmp($aDataWhere);
            $aDataConfig = array(
                'aDataDocHDRef' => $aDataDocHDRef,
                'tStaApv'       => $this->input->post('ptStaApv')
            );
            $tViewPageHDRef = $this->load->view('document/productarrangement/refintdocument/wProductArrangementRefDocList', $aDataConfig, true);
            $aReturnData = array(
                'tViewPageHDRef'    => $tViewPageHDRef,
                'nStaEvent'         => '1',
                'tStaMessg'         => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By: Napat(Jame) 23/12/2021
    public function FSvCPAMPagePdtSN(){
        $aDataSearch = array(
            'tDocNo'    => $this->input->post('ptDocNo'),
            'nSeqNo'    => $this->input->post('pnSeqNo')
        );
        $aResList = $this->productarrangement_model->FSaMPAMGetDataSNByPdt($aDataSearch);
        $this->load->view('document/productarrangement/wProductArrangementViewPdtSN', $aResList);
    }

    // Create By: Napat(Jame) 23/12/2021
    public function FSoCPAMEventAddPdtSN(){
        try{
            $aPackData = $this->input->post('paPackData');
            $aInsertData = array(
                'FTAgnCode'             => '', 
                'FTBchCode'             => $aPackData['tBchCode'], 
                'FTXthDocNo'            => $aPackData['tDocNo'], 
                'FNXtdSeqNo'            => $aPackData['nSeqNo'], 
                'FTPdtSerial'           => $aPackData['tPdtSerial'], 
                'FTXtdStaRet'           => '1', 
                'FTPdtBatchID'          => '', 
                'FDLastUpdOn'           => date('Y-m-d H:i:s'), 
                'FDCreateOn'            => date('Y-m-d H:i:s'), 
                'FTLastUpdBy'           => $this->session->userdata('tSesUsername'), 
                'FTCreateBy'            => $this->session->userdata('tSesUsername'), 
                'FTXthDocKey'           => 'TCNTPdtPickDT', 
                'FTSessionID'           => $this->session->userdata('tSesSessionID')
            );
            $bChkPdtSNDup = $this->productarrangement_model->FSbMPAMEventChkPdtSNDup($aInsertData);
            if( $bChkPdtSNDup === false ){
                $this->db->trans_begin();

                $this->productarrangement_model->FSxMPAMEventAddPdtSN($aInsertData);
                $this->productarrangement_model->FSxMPAMEventUpdDTQtyFromDTSN($aInsertData);

                if( $this->db->trans_status() === FALSE ){
                    $this->db->trans_rollback();
                    $aReturnData     = array(
                        'nStaEvent'    => '905',
                        'tStaMessg'    => $this->db->error()['message'],
                    );
                }else{
                    $this->db->trans_commit();
                    $aReturnData     = array(
                        'nStaEvent'    => '1',
                        'tStaMessg'    => 'Add Pdt S/N Success.',
                    );
                }
            }else{
                $aReturnData = array(
                    'nStaEvent' => '400',
                    'tStaMessg' => 'หมายเลขซีเรียลซ้ำ'
                );
            }
            
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By: Napat(Jame) 24/12/2021
    public function FSoCPAMEventDeletePdtSN(){
        try{
            $aPackData = $this->input->post('paPackData');
            $aInsertData = array(
                'FTAgnCode'             => '', 
                'FTBchCode'             => $aPackData['tBchCode'], 
                'FTXthDocNo'            => $aPackData['tDocNo'], 
                'FNXtdSeqNo'            => $aPackData['nSeqNo'], 
                'FTPdtSerial'           => $aPackData['tPdtSerial'], 
                'FTXthDocKey'           => 'TCNTPdtPickDT', 
                'FTSessionID'           => $this->session->userdata('tSesSessionID')
            );

            $this->db->trans_begin();

            $this->productarrangement_model->FSxMPAMEventDeletePdtSN($aInsertData);
            $this->productarrangement_model->FSxMPAMEventUpdDTQtyFromDTSN($aInsertData);

            if( $this->db->trans_status() === FALSE ){
                $this->db->trans_rollback();
                $aReturnData     = array(
                    'nStaEvent'    => '905',
                    'tStaMessg'    => $this->db->error()['message'],
                );
            }else{
                $this->db->trans_commit();
                $aReturnData     = array(
                    'nStaEvent'    => '1',
                    'tStaMessg'    => 'Delete Pdt S/N Success.',
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Create By: Napat(Jame) 05/01/2021
    // ปรับปรุงข้อมูล : ปรับสถานะเอกสารเป็นรออนุมัติ เพื่อให้ user แก้ไขจำนวนจัดที่ผิดพลาดได้อีกครั้ง
    public function FSoCPAMEventUpdateDoc(){
        try{
            $aDataWhere = array(
                'FTBchCode'         => $this->input->post('ptBchCode'),
                'FTXthDocNo'        => $this->input->post('ptDocNo'),
                'FTUsrCode'         => $this->session->userdata('tSesUsername'),
                'FDLastUpdOn'       => date('Y-m-d H:i:s')
            );
            $aUpdateDoc = $this->productarrangement_model->FSaMPAMEventUpdateDoc($aDataWhere);
            $aReturnData = array(
                'nStaEvent' => $aUpdateDoc['tCode'],
                'tStaMessg' => $aUpdateDoc['tDesc']
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


}
