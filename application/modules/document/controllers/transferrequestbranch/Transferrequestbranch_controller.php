<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Transferrequestbranch_controller extends MX_Controller {

    public function __construct()
    {
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('document/transferrequestbranch/Transferrequestbranch_model');
        parent::__construct();
    }
    
    public $tRouteMenu  = 'docTRB/0/0';
    //  public $tRouteMenu = 'pdtLot/0/0';
    
    public function index($nTRBBrowseType, $tTRBBrowseOption)
    {
        $aParams=array(
            'tDocNo' => $this->input->post('tDocNo'),
            'tBchCode' => $this->input->post('tBchCode'),
            'tAgnCode' => $this->input->post('tAgnCode'),
        );
        
        $aDataConfigView = array(
            'nTRBBrowseType'     => $nTRBBrowseType,
            'tTRBBrowseOption'   => $tTRBBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc($this->tRouteMenu), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML($this->tRouteMenu), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave(),
            'aParams'            => $aParams ,
        );
        
        $this->load->view('document/transferrequestbranch/wTransferRequestBranch', $aDataConfigView);
    }

    // แสดง Form Search ข้อมูลในตารางหน้า List
    public function FSvCTRBFormSearchList() {
        $this->load->view('document/transferrequestbranch/wTransferRequestBranchFormSearchList');
    }

    // แสดงตารางในหน้า List
    public function FSoCTRBDataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage = $this->input->post('nPageCurrent');
            $aAlwEvent = FCNaHCheckAlwFunc($this->tRouteMenu);

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
                'nRow' => 10,
                'aDatSessionUserLogIn' => $this->session->userdata("tSesUsrInfo"),
                'aAdvanceSearch' => $aAdvanceSearch
            );
            $aDataList = $this->Transferrequestbranch_model->FSaMTRBGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage' => $nPage,
                'nOptDecimalShow' => $nOptDecimalShow,
                'aAlwEvent' => $aAlwEvent,
                'aDataList' => $aDataList,
            );
            $tTRBViewDataTableList = $this->load->view('document/transferrequestbranch/wTransferRequestBranchDataTable', $aConfigView, true);
            $aReturnData = array(
                'tTRBViewDataTableList' => $tTRBViewDataTableList,
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
    public function FSoCTRBCallRefIntDoc(){
        $tBCHCode   = $this->input->post('tBCHCode');
        $tBCHName   = $this->input->post('tBCHName');

        $aDataParam = array(
            'tBCHCode' => $tBCHCode,
            'tBCHName' => $tBCHName
        );
        
        $this->load->view('document/transferrequestbranch/refintdocument/wTransferRequestBranchRefDoc', $aDataParam);
    }

    // เลขที่เอกสารอ้างอิงมาแสดงในตาราง browse & Search
    public function FSoCTRBCallRefIntDocDataTable(){
    
        $nPage = $this->input->post('nTRBRefIntPageCurrent');
        $tTRBRefIntBchCode   = $this->input->post('tTRBRefIntBchCode');
        $tTRBRefIntDocNo   = $this->input->post('tTRBRefIntDocNo');
        $tTRBRefIntDocDateFrm   = $this->input->post('tTRBRefIntDocDateFrm');
        $tTRBRefIntDocDateTo   = $this->input->post('tTRBRefIntDocDateTo');
        $tTRBRefIntStaDoc   = $this->input->post('tTRBRefIntStaDoc');
  
        // Page Current 
        if ($nPage == '' || $nPage == null) {
            $nPage = 1;
        } else {
            $nPage = $this->input->post('nTRBRefIntPageCurrent');
        }
        // Lang ภาษา
        $nLangEdit = $this->session->userdata("tLangEdit");
        

        $aDataParamFilter = array(
            'tTRBRefIntBchCode' => $tTRBRefIntBchCode,
            'tTRBRefIntDocNo' => $tTRBRefIntDocNo,
            'tTRBRefIntDocDateFrm' => $tTRBRefIntDocDateFrm,
            'tTRBRefIntDocDateTo' => $tTRBRefIntDocDateTo,
            'tTRBRefIntStaDoc' => $tTRBRefIntStaDoc,
        );

        // Data Conditon Get Data Document
        $aDataCondition = array(
            'FNLngID' => $nLangEdit,
            'nPage' => $nPage,
            'nRow' => 10,
            'aAdvanceSearch' => $aDataParamFilter
        );

         $aDataParam = $this->Transferrequestbranch_model->FSoMTRBCallRefIntDocDataTable($aDataCondition);

         $aConfigView = array(
            'nPage' => $nPage,
            'aDataList' => $aDataParam,
          );

         $this->load->view('document/transferrequestbranch/refintdocument/wTransferRequestBranchRefDocDataTable', $aConfigView);
    }

    // เอารายการจากเอกสารอ้างอิงมาแสดงในตาราง browse
    public function FSoCTRBCallRefIntDocDetailDataTable(){

        $nLangEdit = $this->session->userdata("tLangEdit");
        $tBchCode = $this->input->post('ptBchCode');
        $tTRBcNo = $this->input->post('ptDocNo');
        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        $aDataCondition = array(
            'FNLngID' => $nLangEdit,
            'tBchCode' => $tBchCode,
            'tDocNo' => $tTRBcNo
        );

        $aDataParam = $this->Transferrequestbranch_model->FSoMTRBCallRefIntDocDTDataTable($aDataCondition);

        $aConfigView = array(
            'aDataList' => $aDataParam,
            'nOptDecimalShow' => $nOptDecimalShow
          );
        $this->load->view('document/transferrequestbranch/refintdocument/wTransferRequestBranchRefDocDetailDataTable', $aConfigView);
    }

    // เอารายการที่เลือกจากเอกสารอ้างอิงภายในลงตาราง temp dt
    public function FSoCTRBCallRefIntDocInsertDTToTemp(){
        $tTRBDocNo       =  $this->input->post('tTRBDocNo');
        $tTRBFrmBchCode  =  $this->input->post('tTRBFrmBchCode');
        $tRefIntDocNo   =  $this->input->post('tRefIntDocNo');
        $tRefIntBchCode =  $this->input->post('tRefIntBchCode');
        $aSeqNo         =  $this->input->post('aSeqNo');
       
        $aDataParam = array(
            'tTRBDocNo'       => $tTRBDocNo,
            'tTRBFrmBchCode'  => $tTRBFrmBchCode,
            'tRefIntDocNo'   => $tRefIntDocNo,
            'tRefIntBchCode' => $tRefIntBchCode,
            'aSeqNo'         => $aSeqNo,
        );
        
       $aDataResult = $this->Transferrequestbranch_model->FSoMTRBCallRefIntDocInsertDTToTemp($aDataParam);
       return  $aDataResult;
    }

    // เรียกหน้าเพิ่มข้อมูล
    public function FSoCTRBPageAdd() {
        try {
            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => '',
                'FTXthDocKey' => 'TCNTPdtReqBchHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];

            $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->Transferrequestbranch_model->FSaMTRBGetDetailUserBranch($tUserBchCode);
                $tTRBPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tTRBPplCode = '';
            }
     

            $this->Transferrequestbranch_model->FSaMCENDeletePDTInTmp($aWhereClearTemp);
            $this->Transferrequestbranch_model->FSxMTRBClearDataInDocTemp($aWhereClearTemp);

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
                'tDataDocKey' => 'TCNTPdtReqBchHD',
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
            $aDataUserGroup = $this->Transferrequestbranch_model->FSaMTRBGetShpCodeForUsrLogin($aDataShp);
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
            $aConfigSysWareHouse = $this->Transferrequestbranch_model->FSaMTRBGetDefOptionConfigWah($aConfigSys);

            
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
                'tTRBPplCode'  => $tTRBPplCode
            );
            
            $tTRBViewPageAdd = $this->load->view('document/transferrequestbranch/wTransferRequestBranchPageAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tTRBViewPageAdd' => $tTRBViewPageAdd,
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
    public function FSoCTRBPdtAdvTblLoadData() {
        try {
            $bStaSession    =   $this->session->userdata('bSesLogIn');
            if(isset($bStaSession) && $bStaSession === TRUE){
                //ยังมี Session อยู่
            }else{
                $aReturnData = array(
                    'checksession' => 'expire'
                );
                echo json_encode($aReturnData);
                exit;
            }

            $tTRBDocNo           = $this->input->post('ptTRBDocNo');
            $tTRBStaApv          = $this->input->post('ptTRBStaApv');
            $tTRBStaDoc          = $this->input->post('ptTRBStaDoc');
            $tTRBVATInOrEx       = $this->input->post('ptTRBVATInOrEx');
            $nTRBPageCurrent     = $this->input->post('pnDOPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            $tTRBPdtCode         = $this->input->post('ptTRBPdtCode');
            $tTRBPunCode         = $this->input->post('ptTRBPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow    = 'TCNTPdtReqBchHD';
            // $aColumnShow            = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tTRBDocNo,
                'FTXthDocKey'           => 'TCNTPdtReqBchHD',
                'nPage'                 => $nTRBPageCurrent,
                'nRow'                  => 90000,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );
            // FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->Transferrequestbranch_model->FSaMTRBGetDocDTTempListPage($aDataWhere);
            $aDataView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tTRBStaApv'         => $tTRBStaApv,
                'tTRBStaDoc'         => $tTRBStaDoc,
                'tTRBPdtCode'        => $tTRBPdtCode,
                'tTRBPunCode'        => $tTRBPunCode,
                'nPage'             => $nTRBPageCurrent,
                'aColumnShow'       => array(),
                'aDataDocDTTemp'    => $aDataDocDTTemp,
            );
            
            $tTRBPdtAdvTableHtml = $this->load->view('document/transferrequestbranch/wTransferRequestBranchPdtAdvTableData', $aDataView, true);

            $aReturnData = array(
                'tTRBPdtAdvTableHtml' => $tTRBPdtAdvTableHtml,
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
    public function FSoCTRBAddPdtIntoDocDTTemp() {
        try {
            $tTRBUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tTRBDocNo           = $this->input->post('tTRBDocNo');
            $tTRBVATInOrEx       = $this->input->post('tTRBVATInOrEx');
            $tTRBBchCode         = $this->input->post('tSelectBCH');
            $tTRBOptionAddPdt    = $this->input->post('tTRBOptionAddPdt');
            $tTRBPdtData         = $this->input->post('tTRBPdtData');
            $aDOPdtData         = json_decode($tTRBPdtData);
            $nVatRate           = $this->input->post('nVatRate');
            $nVatCode           = $this->input->post('nVatCode');

            $aDataWhere = array(
                'FTBchCode' => $tTRBBchCode,
                'FTXthDocNo' => $tTRBDocNo,
                'FTXthDocKey' => 'TCNTPdtReqBchHD',
            );

            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aDOPdtData); $nI++) {
                $tTRBPdtCode = $aDOPdtData[$nI]->pnPdtCode;
                $tTRBBarCode = $aDOPdtData[$nI]->ptBarCode;
                $tTRBPunCode = $aDOPdtData[$nI]->ptPunCode;
  
     
                $cTRBPrice       = $aDOPdtData[$nI]->packData->Price;
                $aDataPdtParams = array(
                    'tDocNo'            => $tTRBDocNo,
                    'tBchCode'          => $tTRBBchCode,
                    'tPdtCode'          => $tTRBPdtCode,
                    'tBarCode'          => $tTRBBarCode,
                    'tPunCode'          => $tTRBPunCode,
                    'cPrice'            => str_replace(",","",$cTRBPrice),
                    'nMaxSeqNo'         => $this->input->post('tSeqNo'),
                    'nLngID'            => $this->input->post("ohdTRBLangEdit"),
                    // 'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tSessionID'        => $this->input->post('ohdSesSessionID'),
                    'tDocKey'           => 'TCNTPdtReqBchHD',
                    'tTRBOptionAddPdt'   => $tTRBOptionAddPdt,
                    'tTRBUsrCode'        => $this->input->post('ohdTRBUsrCode'),
                    'nVatRate'          => $nVatRate,
                    'nVatCode'          => $nVatCode
                );
                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->Transferrequestbranch_model->FSaMTRBGetDataPdt($aDataPdtParams);
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp = $this->Transferrequestbranch_model->FSaMTRBInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
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
    public function FSvCTRBRemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                'tTRBDocNo' => $this->input->post('tDocNo'),
                'tBchCode' => $this->input->post('tBchCode'),
                'tPdtCode' => $this->input->post('tPdtCode'),
                'nSeqNo'   => $this->input->post('nSeqNo'),
                'tDocKey'  => 'TCNTPdtReqBchHD',
                'tSessionID' => $this->session->userdata('tSesSessionID'),
            );

            $aStaDelPdtDocTemp = $this->Transferrequestbranch_model->FSnMTRBDelPdtInDTTmp($aDataWhere);

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
    public function FSvCTRBRemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tTRBDocNo' => $this->input->post('tDocNo'),
                'tBchCode' => $this->input->post('tBchCode'),
                'tPdtCode' => $this->input->post('tPdtCode'),
                'nSeqNo'   => $this->input->post('nSeqNo'),
                'tDocKey'  => 'TCNTPdtReqBchHD',
                'tSessionID' => $this->session->userdata('tSesSessionID'),
            );

            $aStaDelPdtDocTemp = $this->Transferrequestbranch_model->FSnMTRBDelMultiPdtInDTTmp($aDataWhere);

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
    public function FSoCTRBEditPdtIntoDocDTTemp() {
        try {

            $tTRBBchCode         = $this->input->post('tTRBBchCode');
            $tTRBDocNo           = $this->input->post('tTRBDocNo');
            $nTRBSeqNo           = $this->input->post('nTRBSeqNo');
            $tTRBSessionID       = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tTRBBchCode'    => $tTRBBchCode,
                'tTRBDocNo'      => $tTRBDocNo,
                'nTRBSeqNo'      => $nTRBSeqNo,
                'tTRBSessionID'  => $tTRBSessionID,
                'tDocKey'       => 'TCNTPdtReqBchHD',
            );

            $nQty       = $this->input->post('nQty');
            $nFactor    = $this->input->post('pnFactor');

            $aDataUpdateDT = array(
                'FCXtdQty'          => $nQty,
                'FCXtdQtyAll'       => $nFactor * $nQty
            );

            $this->db->trans_begin();
            $this->Transferrequestbranch_model->FSaMTRBUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

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
    public function FSoCTRBChkHavePdtForDocDTTemp() {
        try {
            $tTRBBchCode = $this->input->post("ptBchCode");
            $tTRBAgnCode = $this->input->post("ptAgnCode");
            $tTRBDocNo   = $this->input->post("ptTRBDocNo");
            $tTRBSessionID = $this->input->post('tTRBSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo' => $tTRBDocNo,
                'FTXthDocKey' => 'TCNTPdtReqBchHD',
                'FTSessionID' => $tTRBSessionID
            );
            $nCountPdtInDocDTTemp = $this->Transferrequestbranch_model->FSnMTRBChkPdtInDocDTTemp($aDataWhere);
            
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn' => '800',
                    'tStaMessg' => language('document/transferrequestbranch/transferrequestbranch', 'tTRBPleaseSeletedPDTIntoTable')
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
    public function FSoCTRBAddEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tTRBAutoGenCode = (isset($aDataDocument['ocbTRBStaAutoGenCode'])) ? 1 : 0;
            $tTRBDocNo = (isset($aDataDocument['oetTRBDocNo'])) ? $aDataDocument['oetTRBDocNo'] : '';
            $tTRBDocDate = $aDataDocument['oetTRBDocDate'] . " " . $aDataDocument['oetTRBDocTime'];
            $tTRBStaDocAct = (isset($aDataDocument['ocbTRBFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tTRBVATInOrEx = $aDataDocument['ohdTRBFrmSplInfoVatInOrEx'];
            $tTRBSessionID = $this->input->post('ohdSesSessionID');
            $nTRBSubmitWithImp = $aDataDocument['ohdTRBSubmitWithImp'];

            // Get Data Comp.
            $nLangEdit = $this->input->post("ohdTRBLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tADOReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tADOReq, $tMethodReq, $aDataWhereComp);
            $aClearDTParams = [
                'FTXthDocNo'     => $tTRBDocNo,
                'FTXthDocKey'    => 'TCNTPdtReqBchHD',
                'FTSessionID'    => $this->input->post('ohdSesSessionID'),
            ];
            if($nTRBSubmitWithImp==1){
                $this->Transferrequestbranch_model->FSxMTRBClearDataInDocTempForImp($aClearDTParams);
            }

            if (!empty($aDataDocument['oetTRBRefDocIntName'])) {
                $tRefInDocNo = $aDataDocument['oetTRBRefDocIntName'];
                $nStaRef = '2';
                $this->Transferrequestbranch_model->FSaMTRBUpdatePOStaRef($tRefInDocNo, $nStaRef);
            }


//-----------------------------------------------------------------------------
            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TCNTPdtReqBchHD',
                'tTableDT' => 'TCNTPdtReqBchDT',
                'tTableStaGen' => 11,
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTAgnCode' => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode' => $aDataDocument['oetTRBFrmBchCode'],
                'FTXthDocNo' => $tTRBDocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->input->post('ohdTRBUsrCode'),
                'FTLastUpdBy' => $this->input->post('ohdTRBUsrCode'),
                'FTSessionID' => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx' => $tTRBVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FDXthDocDate' => (!empty($tTRBDocDate)) ? $tTRBDocDate : NULL,
                'FTUsrCode' => $aDataDocument['ohdTRBUsrCode'],
                'FTXthBchFrm' => $aDataDocument['oetTRBFrmBchCodeTo'], 
                'FTXthBchTo' => $aDataDocument['oetTRBFrmBchCodeShip'], 
                'FTXthWhFrm'   => $aDataDocument['oetTRBFrmWahCodeTo'], 
                'FTXthWhTo'   => $aDataDocument['oetTRBFrmWahCodeShip'], 
                'FNXthDocPrint' => $aDataDocument['ocmTRBFrmInfoOthDocPrint'],
                'FTXthRmk' => $aDataDocument['otaTRBFrmInfoOthRmk'],
                'FTXthStaDoc' => $aDataDocument['ohdTRBStaDoc'],
                'FTXthStaApv' => !empty($aDataDocument['ohdTRBStaApv']) ? $aDataDocument['ohdTRBStaApv'] : NULL,
                'FNXthStaDocAct' => $tTRBStaDocAct,
                'FNXthStaRef' => $aDataDocument['ocmTRBFrmInfoOthRef'],
                'FTRsnCode' => $aDataDocument['oetTRBReasonCode'],
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tTRBAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtReqBchHD',                           
                    "tDocType"    => '13',                                          
                    "tBchCode"    => $aDataDocument['oetTRBFrmBchCode'],                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXthDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXthDocNo'] = $tTRBDocNo;
            }
            

            // echo '<pre>';
            //     print_r($aDataWhere);
            //     print_r($aDataMaster);
            // echo '</pre>';
            // Add Update Document HD
            $this->Transferrequestbranch_model->FSxMTRBAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // [Update] DocNo -> Temp
            $this->Transferrequestbranch_model->FSxMTRBAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);
            
            // Move Doc DTTemp To DT
            $this->Transferrequestbranch_model->FSaMTRBMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            if (!empty($aDataDocument['oetTRBRefDocIntName'])) {
                $tRefInDocNo    = $aDataDocument['oetTRBRefDocIntName'];
                $tRefInDocDate  = $aDataDocument['oetTRBRefIntDocDate'];
                $nStaRef = '2';
                // ข้อมูล Insert ลงตาราง DocRef ของ PRB / TRB

                $aDataTRBAddDocRef = array(
                'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                'FTXshDocNo'        => $aDataWhere['FTXthDocNo'],
                'FTXshRefType'      => 1,
                'FTXshRefKey'       => 'PRB',
                'FTXshRefDocNo'     => $tRefInDocNo,
                'FDXshRefDocDate'   => $tRefInDocDate,
                );

                $aDatawherePRBAddDocRef = array(
                'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                'FTXshDocNo'        => $tRefInDocNo,
                );

                $aDataPRBAddDocRef = array(
                    'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                    'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                    'FTXshDocNo'        => $tRefInDocNo,
                    'FTXshRefType'      => 2,
                    'FTXshRefKey'       => 'TRB',
                    'FTXshRefDocNo'     => $aDataWhere['FTXthDocNo'],
                    'FDXshRefDocDate'   => $tTRBDocDate,
                );
                $this->Transferrequestbranch_model->FSaMTRBUpdateRefDocHD($aDataTRBAddDocRef , $aDatawherePRBAddDocRef , $aDataPRBAddDocRef);
            }

            if (!empty($aDataDocument['oetTRBSplRefDocExt'])) {
                $tRefExtDocNo    = $aDataDocument['oetTRBSplRefDocExt'];
                $tRefExtDocDate  = $aDataDocument['oetTRBRefDocExtDate'];

                $aDataPRSAddDocRef = array(
                'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                'FTXshDocNo'        => $aDataWhere['FTXthDocNo'],
                'FTXshRefType'      => 3,
                'FTXshRefKey'       => 'TRB',
                'FTXshRefDocNo'     => $tRefExtDocNo,
                'FDXshRefDocDate'   => $tRefExtDocDate,
                );
                $this->Transferrequestbranch_model->FSaMTRBUpdateRefExtDocHD($aDataPRSAddDocRef);
            }

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
                    'tCodeReturn' => $aDataWhere['FTXthDocNo'],
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
    public function FSoCTRBEditEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tTRBAutoGenCode = (isset($aDataDocument['ocbTRBStaAutoGenCode'])) ? 1 : 0;
            $tTRBDocNo = (isset($aDataDocument['oetTRBDocNo'])) ? $aDataDocument['oetTRBDocNo'] : '';
            $tTRBDocDate = $aDataDocument['oetTRBDocDate'] . " " . $aDataDocument['oetTRBDocTime'];
            $tTRBStaDocAct = (isset($aDataDocument['ocbTRBFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tTRBVATInOrEx = $aDataDocument['ohdTRBFrmSplInfoVatInOrEx'];
            $tTRBSessionID = $this->input->post('ohdSesSessionID');
            $nTRBSubmitWithImp = $aDataDocument['ohdTRBSubmitWithImp'];
            
            // Get Data Comp.
            $nLangEdit = $this->input->post("ohdTRBLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tADOReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tADOReq, $tMethodReq, $aDataWhereComp);
            $aClearDTParams = [
                'FTXthDocNo'     => $tTRBDocNo,
                'FTXthDocKey'    => 'TCNTPdtReqBchHD',
                'FTSessionID'    => $this->input->post('ohdSesSessionID'),
            ];
            if($nTRBSubmitWithImp==1){
                $this->Transferrequestbranch_model->FSxMTRBClearDataInDocTempForImp($aClearDTParams);
            }

            if (!empty($aDataDocument['oetTRBRefDocIntName'])) {
                $tRefInDocNo = $aDataDocument['oetTRBRefDocIntName'];
                $nStaRef = '2';
                $this->Transferrequestbranch_model->FSaMTRBUpdatePOStaRef($tRefInDocNo, $nStaRef);
            }
            
            if($aDataDocument['oetTRBRefDocIntName'] != $aDataDocument['ohdTRBRefIntDoc']){
                $tRefInDocNo = $aDataDocument['ohdTRBRefIntDoc'];
                $nStaRef = '0';
                $this->Transferrequestbranch_model->FSaMTRBUpdatePOStaRef($tRefInDocNo, $nStaRef);
                if(empty($aDataDocument['oetTRBRefDocIntName'])){
                    $this->Transferrequestbranch_model->FSnMTRBDelRef($aDataDocument['ohdTRBRefIntDoc']);
                }
            }
//-----------------------------------------------------------------------------
            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TCNTPdtReqBchHD',
                'tTableDT' => 'TCNTPdtReqBchDT',
                'tTableStaGen' => 11,
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTAgnCode' => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode' => $aDataDocument['oetTRBFrmBchCode'],
                'FTOldBchCode' => $aDataDocument['ohdTRBBchCode'],
                'FTXthDocNo' => $tTRBDocNo,
                'FTOldXthDocNo' => $tTRBDocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->input->post('ohdTRBUsrCode'),
                'FTLastUpdBy' => $this->input->post('ohdTRBUsrCode'),
                'FTSessionID' => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx' => $tTRBVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FDXthDocDate' => (!empty($tTRBDocDate)) ? $tTRBDocDate : NULL,
                'FTUsrCode' => $aDataDocument['ohdTRBUsrCode'],
                'FTXthBchFrm' => $aDataDocument['oetTRBFrmBchCodeTo'], 
                'FTXthBchTo' => $aDataDocument['oetTRBFrmBchCodeShip'], 
                'FTXthWhFrm'   => $aDataDocument['oetTRBFrmWahCodeTo'], 
                'FTXthWhTo'   => $aDataDocument['oetTRBFrmWahCodeShip'], 
                'FNXthDocPrint' => $aDataDocument['ocmTRBFrmInfoOthDocPrint'],
                'FTXthRmk' => $aDataDocument['otaTRBFrmInfoOthRmk'],
                'FTXthStaDoc' => $aDataDocument['ohdTRBStaDoc'],
                'FTXthStaApv' => !empty($aDataDocument['ohdTRBStaApv']) ? $aDataDocument['ohdTRBStaApv'] : NULL,
                'FNXthStaDocAct' => $tTRBStaDocAct,
                'FNXthStaRef' => $aDataDocument['ocmTRBFrmInfoOthRef'],
                'FTRsnCode' => $aDataDocument['oetTRBReasonCode'],
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($aDataDocument['oetTRBFrmBchCode'] != $aDataDocument['ohdTRBBchCode']) {
                $aStoreParam = array(
                    "tTblName"    => 'TCNTPdtReqBchHD',                           
                    "tDocType"    => '11',                                          
                    "tBchCode"    => $aDataDocument['oetTRBFrmBchCode'],                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXthDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXthDocNo'] = $tTRBDocNo;
            }

            // Add Update Document HD
            $this->Transferrequestbranch_model->FSxMTRBAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // [Update] DocNo -> Temp
            $this->Transferrequestbranch_model->FSxMTRBAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->Transferrequestbranch_model->FSaMTRBMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            if (!empty($aDataDocument['oetTRBRefDocIntName'])) {
                $tRefInDocNo    = $aDataDocument['oetTRBRefDocIntName'];
                $tRefInDocDate  = $aDataDocument['oetTRBRefIntDocDate'];
                $nStaRef = '2';
                // ข้อมูล Insert ลงตาราง DocRef ของ PRB / TRB

                $aDataTRBAddDocRef = array(
                'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                'FTXshDocNo'        => $aDataWhere['FTXthDocNo'],
                'FTXshRefType'      => 1,
                'FTXshRefKey'       => 'PRB',
                'FTXshRefDocNo'     => $tRefInDocNo,
                'FDXshRefDocDate'   => $tRefInDocDate,
                );

                $aDatawherePRBAddDocRef = array(
                'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                'FTXshDocNo'        => $tRefInDocNo,
                );

                $aDataPRBAddDocRef = array(
                    'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                    'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                    'FTXshDocNo'        => $tRefInDocNo,
                    'FTXshRefType'      => 2,
                    'FTXshRefKey'       => 'TRB',
                    'FTXshRefDocNo'     => $aDataWhere['FTXthDocNo'],
                    'FDXshRefDocDate'   => $tTRBDocDate,
                );
                $this->Transferrequestbranch_model->FSaMTRBUpdateRefDocHD($aDataTRBAddDocRef , $aDatawherePRBAddDocRef , $aDataPRBAddDocRef);
            }

            if (!empty($aDataDocument['oetTRBSplRefDocExt'])) {
                $tRefExtDocNo    = $aDataDocument['oetTRBSplRefDocExt'];
                $tRefExtDocDate  = $aDataDocument['oetTRBRefDocExtDate'];

                $aDataPRSAddDocRef = array(
                'FTAgnCode'         => $aDataDocument['oetTRBAgnCode'],
                'FTBchCode'         => $aDataDocument['oetTRBFrmBchCode'],
                'FTXshDocNo'        => $aDataWhere['FTXthDocNo'],
                'FTXshRefType'      => 3,
                'FTXshRefKey'       => 'PRB',
                'FTXshRefDocNo'     => $tRefExtDocNo,
                'FDXshRefDocDate'   => $tRefExtDocDate,
                );
                $this->Transferrequestbranch_model->FSaMTRBUpdateRefExtDocHD($aDataPRSAddDocRef);
            }
            
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
                    'tCodeReturn' => $aDataWhere['FTXthDocNo'],
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

    //หน้าจอแก้ไข
    public function FSvCTRBEditPage(){
        try {
            $ptBchCode = $this->input->post('ptBchCode');
            $ptAgnCode = $this->input->post('ptAgnCode');
            $ptDocumentNumber = $this->input->post('ptTRBDocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTSessionID'   => $this->session->userdata('tSesSessionID')
            ];
            $this->Transferrequestbranch_model->FSnMTRBDelALLTmp($aWhereClearTemp);

            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTBchCode'     => $ptBchCode,
                'FTAgnCode'     => $ptAgnCode,
                'FTXthDocNo'    => $ptDocumentNumber,
                'FTXthDocKey'   => 'TCNTPdtReqBchHD',
                'FNLngID'       => $nLangEdit,
                'nRow'          => 90000,
                'nPage'         => 1,
            );

            // Get Autentication Route
                $aAlwEvent         = FCNaHCheckAlwFunc($this->tRouteMenu); // Controle Event
                $vBtnSave          = FCNaHBtnSaveActiveHTML($this->tRouteMenu); // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
                $nOptDecimalShow   = FCNxHGetOptionDecimalShow();
                $nOptDecimalSave   = FCNxHGetOptionDecimalSave();
                $nOptDocSave       = FCNnHGetOptionDocSave();

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD         = $this->Transferrequestbranch_model->FSaMTRBGetDataDocHD($aDataWhere);

            // Move Data DT TO DTTemp
            $this->Transferrequestbranch_model->FSxMTRBMoveDTToDTTemp($aDataWhere);

            // Move Data HDDocRef TO HDRefTemp
            $this->Transferrequestbranch_model->FSxMTRBMoveHDRefToHDRefTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
                
            } else {
                $this->db->trans_commit();

                $aDataConfigViewEdit = array(
                    'aAlwEvent'         => $aAlwEvent,
                    'vBtnSave'          => $vBtnSave,
                    'nOptDecimalShow'   => $nOptDecimalShow,
                    'nOptDecimalSave'   => $nOptDecimalSave,
                    'nOptDocSave'       => $nOptDocSave,
                    'aRateDefault'      => '',
                    'aDataDocHD'        => $aDataDocHD
                );
                
                $tViewPageEdit           = $this->load->view('document/transferrequestbranch/wTransferRequestBranchPageAdd',$aDataConfigViewEdit,true);
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
    public function FSoCTRBDeleteEventDoc() {
        try {
            $tDataDocNo = $this->input->post('tDataDocNo');
            $tBchCode = $this->input->post('tBchCode');
            $tAgnCode = $this->input->post('tAgnCode');
            $tRefInDocNo = $this->input->post('tTRBRefInCode');

            if (!empty($tRefInDocNo)) {
                $nStaRef = '0';
                $this->Transferrequestbranch_model->FSaMTRBUpdatePOStaRef($tRefInDocNo, $nStaRef);
            }
            
            $aDataMaster = array(
                'tDataDocNo' => $tDataDocNo,
                'tBchCode' => $tBchCode,
                'tAgnCode' => $tAgnCode,
            );
            
            $aResDelDoc = $this->Transferrequestbranch_model->FSnMTRBDelDocument($aDataMaster);
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
    public function FSvCTRBCancelDocument() {
        try {
            $tTRBDocNo = $this->input->post('ptTRBDocNo');
            $tRefInDocNo = $this->input->post('ptRefInTRBcNo');

            if (!empty($tRefInDocNo)) {
                $nStaRef = '0';
                $this->Transferrequestbranch_model->FSaMTRBUpdatePOStaRef($tRefInDocNo, $nStaRef);
            }
            
            $aDataUpdate = array(
                'tDocNo' => $tTRBDocNo,
            );

            $aStaApv = $this->Transferrequestbranch_model->FSaMTRBCancelDocument($aDataUpdate);
            $aReturnData = $aStaApv;
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    //อนุมัติเอกสาร
    public function FSoCTRBApproveEvent(){
        try{
            $tTRBDocNo     = $this->input->post('tTRBDocNo');
            $tAgnCode   = $this->input->post('tAgnCode');
            $tBchCode   = $this->input->post('tBchCode');
            $tRefInDocNo   = $this->input->post('tRefInDocNo');

            if (!empty($tRefInDocNo)) {
                $this->Transferrequestbranch_model->FSaMTRBUpdatePOStaPrcTRBc($tRefInDocNo);
            }

            $aMQParams = [
                "queueName" => "AP_QDocApprove",
                "params"    => [
                    "ptBchCode"     => $tBchCode,
                    "ptDocNo"       => $tTRBDocNo,
                    "ptDocType"     => 13,
                    "ptUser"        => $this->session->userdata('tSesUsername'),
                ]
            ];
            
      
            $aDataUpdate = array(
                'FTBchCode'         => $tBchCode,
                'FTAgnCode'         => $tAgnCode,
                'FTXthDocNo'        => $tTRBDocNo,
                'FTXthStaApv'       => 1,
                'FTXthUsrApv'       => $this->session->userdata('tSesUsername')
            );
            $this->Transferrequestbranch_model->FSaMTRBApproveDocument($aDataUpdate);
            
            $aDataGetDataHD     =   $this->Transferrequestbranch_model->FSaMTRBGetDataDocHD(array(
                'FTBchCode'     => $tBchCode,
                'FTAgnCode'     => $tAgnCode,
                'FTXthDocNo'    => $tTRBDocNo,
                'FNLngID'       => $this->session->userdata("tLangEdit")
            ));
            if($aDataGetDataHD['rtCode']=='1'){
                $tNotiID = FCNtHNotiGetNotiIDByDocRef($aDataGetDataHD['raItems']['rtXthDocNo']);
            $aMQParamsNoti = [
                "queueName" => "CN_SendToNoti",
                "tVhostType" => "NOT",
                "params"    => [
                                 "oaTCNTNoti" => array(
                                                 "FNNotID"       => $tNotiID,
                                                 "FTNotCode"     => '00010',
                                                 "FTNotKey"      => 'TCNTPdtReqBchHD',
                                                 "FTNotBchRef"    => $aDataGetDataHD['raItems']['rtBchCode'],
                                                 "FTNotDocRef"   => $aDataGetDataHD['raItems']['rtXthDocNo'],
                                 ),
                                 "oaTCNTNoti_L" => array(
                                                    0 => array(
                                                        "FNNotID"       => $tNotiID,
                                                        "FNLngID"       => 1,
                                                        "FTNotDesc1"    => 'เอกสารใบขอโอน #'.$aDataGetDataHD['raItems']['rtXthDocNo'],
                                                        "FTNotDesc2"    => 'รหัสสาขา '.$aDataGetDataHD['raItems']['rtBchCode'].' ส่งเรื่องขอโอนไปยังสาขา '.$aDataGetDataHD['raItems']['rtBchCodeTo'].' ปลายทางสาขา '.$aDataGetDataHD['raItems']['rtBchCodeShip'],
                                                    ),
                                                    1 => array(
                                                        "FNNotID"       => $tNotiID,
                                                        "FNLngID"       => 2,
                                                        "FTNotDesc1"    => 'Transfer Request #'.$aDataGetDataHD['raItems']['rtXthDocNo'],
                                                        "FTNotDesc2"    => 'Branch Code '.$aDataGetDataHD['raItems']['rtBchCode'].' Send transfer request to branch '.$aDataGetDataHD['raItems']['rtBchCodeTo'].' Branch endpoint '.$aDataGetDataHD['raItems']['rtBchCodeShip'],
                                                    )
                                ),
                                 "oaTCNTNotiAct" => array(
                                                     0 => array(  
                                                            "FNNotID"       => $tNotiID,
                                                            "FDNoaDateInsert" => date('Y-m-d H:i:s'),
                                                            "FTNoaDesc"      => 'รหัสสาขา '.$aDataGetDataHD['raItems']['rtBchCode'].' ส่งเรื่องขอโอนไปยังสาขา '.$aDataGetDataHD['raItems']['rtBchCodeTo'].' ปลายทางสาขา '.$aDataGetDataHD['raItems']['rtBchCodeShip'],
                                                            "FTNoaDocRef"    => $aDataGetDataHD['raItems']['rtXthDocNo'],
                                                            "FNNoaUrlType"   =>  1,
                                                            "FTNoaUrlRef"    => 'docTRB/2/0',
                                                            ),
                                     ), 
                                 "oaTCNTNotiSpc" => array(
                                                    0 => array(
                                                            "FNNotID"       => $tNotiID,
                                                            "FTNotType"    => '1',
                                                            "FTNotStaType" => '1',
                                                            "FTAgnCode"    => '',
                                                            "FTAgnName"    => '',
                                                            "FTBchCode"    => $aDataGetDataHD['raItems']['rtBchCode'],
                                                            "FTBchName"    => $aDataGetDataHD['raItems']['rtBchName'],
                                                    ),
                                                    1 => array(
                                                            "FNNotID"       => $tNotiID,
                                                            "FTNotType"    => '2',
                                                            "FTNotStaType" => '1',
                                                            "FTAgnCode"    => '',
                                                            "FTAgnName"    => '',
                                                            "FTBchCode"    => $aDataGetDataHD['raItems']['rtBchCodeTo'],
                                                            "FTBchName"    => $aDataGetDataHD['raItems']['rtBchNameTo'],
                                                    ),
                                                    2 => array(
                                                            "FNNotID"       => $tNotiID,
                                                            "FTNotType"    => '2',
                                                            "FTNotStaType" => '1',
                                                            "FTAgnCode"    => '',
                                                            "FTAgnName"    => '',
                                                            "FTBchCode"    => $aDataGetDataHD['raItems']['rtBchCodeShip'],
                                                            "FTBchName"    => $aDataGetDataHD['raItems']['rtBchNameShip'],
                                                     ),
                                 ),
                    "ptUser"        => $this->session->userdata('tSesUsername'),
                ]
            ];
            // echo '<pre>';
            // print_r($aMQParamsNoti['params']);
            // echo '</pre>';
            // echo json_encode($aMQParamsNoti['params']);
            // die();
            FCNxCallRabbitMQ($aMQParamsNoti);
        }

            $aReturnData = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => "Success"
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // อ้างอิงเอกสาร - โหลดข้อมูล
    public function FSoCTRBPageHDDocRef(){
        try {
            $tDocNo = ( !empty($this->input->post('ptDocNo')) ? $this->input->post('ptDocNo') : '');

            $aDataWhere = [
                'tTableHDDocRef'    => 'TCNTPdtReqBchHDDocRef',
                'tTableTmpHDRef'    => 'TCNTDocHDRefTmp',
                'FTXthDocNo'        => $tDocNo,
                'FTXthDocKey'       => 'TCNTPdtReqBchHD',
                'FTSessionID'       => $this->session->userdata('tSesSessionID')
            ];
            $aDataDocHDRef = $this->Transferrequestbranch_model->FSaMTRBGetDataHDRefTmp($aDataWhere);
            $aDataConfig = array(
                'aDataDocHDRef' => $aDataDocHDRef,
                'tStaApv'       => $this->input->post('ptStaApv')
            );
            $tViewPageHDRef = $this->load->view('document/transferrequestbranch/refintdocument/wTransferRequestBranchHDDocRef', $aDataConfig, true);
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

}

/* End of file Controllername.php */
