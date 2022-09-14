<?php

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

defined('BASEPATH') or exit('No direct script access allowed');

class cPurchaseOrder extends MX_Controller {

    public function __construct() {
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/purchaseorder/mPurchaseOrder');
        $this->load->model('document/purchaseorder/mPurchaseOrderDisChgModal');
        parent::__construct();
    }

    public function index($nPOBrowseType, $tPOBrowseOption) {
        $aDataConfigView = array(
            'nPOBrowseType'     => $nPOBrowseType,
            'tPOBrowseOption'   => $tPOBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('docPO/0/0'), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('docPO/0/0'), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/purchaseorder/wPurchaseOrder', $aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : String View
    // Return Type : View
    public function FSvCPOFormSearchList() {
        $this->load->view('document/purchaseorder/wPurchaseOrderFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCPODataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage = $this->input->post('nPageCurrent');
            $aAlwEvent = FCNaHCheckAlwFunc('docPO/0/0');

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
            $aDataList = $this->mPurchaseOrder->FSaMPOGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage' => $nPage,
                'nOptDecimalShow' => $nOptDecimalShow,
                'aAlwEvent' => $aAlwEvent,
                'aDataList' => $aDataList,
            );
            $tPOViewDataTableList = $this->load->view('document/purchaseorder/wPurchaseOrderDataTable', $aConfigView, true);
            $aReturnData = array(
                'tPOViewDataTableList' => $tPOViewDataTableList,
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

    // Functionality : Function Delete Document Purchase Invoice
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCPODeleteEventDoc() {
        try {
            $tDataDocNo = $this->input->post('tDataDocNo');
            $aDataMaster = array(
                'tDataDocNo' => $tDataDocNo
            );
            $aResDelDoc = $this->mPurchaseOrder->FSnMPODelDocument($aDataMaster);
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

    // Functionality : Function Call Page Add Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCPOAddPage() {
        try {

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => '',
                'FTXthDocKey' => 'TAPTPoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];

            $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->mPurchaseOrder->FSaMPOGetDetailUserBranch($tUserBchCode);
                $tPOPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tPOPplCode = '';
            }
     

            $this->mPurchaseOrder->FSaMCENDeletePDTInTmp($aWhereClearTemp);
            $this->mPurchaseOrder->FSxMPOClearDataInDocTemp($aWhereClearTemp);

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
                'tDataDocKey' => 'TAPTPoHD',
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
            $aDataUserGroup = $this->mPurchaseOrder->FSaMPOGetShpCodeForUsrLogin($aDataShp);
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
            $aConfigSysWareHouse = $this->mPurchaseOrder->FSaMPOGetDefOptionConfigWah($aConfigSys);

            
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
                'tPOPplCode'  => $tPOPplCode
            );
            $tPOViewPageAdd = $this->load->view('document/purchaseorder/wPurchaseOrderAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tPOViewPageAdd' => $tPOViewPageAdd,
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


    // Functionality : Function Call Page Edit Tranfer Out
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Page Add
    // Return Type : object
    public function FSoCPOEditPage() {
        // die();

        try {
            $tPODocNo = $this->input->post('ptPODocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $tPODocNo,
                'FTXthDocKey' => 'TAPTPoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mPurchaseOrder->FSxMPOClearDataInDocTemp($aWhereClearTemp);

            $tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->mPurchaseOrder->FSaMPOGetDetailUserBranch($tUserBchCode);
                $tPOPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tPOPplCode = '';
            }
            // Get Autentication Route
            $aAlwEvent = FCNaHCheckAlwFunc('docPO/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit = $this->session->userdata("tLangEdit");

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $aDataShp = array(
                'FNLngID' => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );

            $aDataUserGroup = $this->mPurchaseOrder->FSaMPOGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tUsrBchCode = "";
                $tUsrBchName = "";
                $tUsrMerCode = "";
                $tUsrMerName = "";
                $tUsrShopType = "";
                $tUsrShopCode = "";
                $tUsrShopName = "";
                $tUsrWahCode = "";
                $tUsrWahName = "";
            } else {
                $tUsrBchCode = $aDataUserGroup["FTBchCode"];
                $tUsrBchName = $aDataUserGroup["FTBchName"];
                $tUsrMerCode = $aDataUserGroup["FTMerCode"];
                $tUsrMerName = $aDataUserGroup["FTMerName"];
                $tUsrShopType = $aDataUserGroup["FTShpType"];
                $tUsrShopCode = $aDataUserGroup["FTShpCode"];
                $tUsrShopName = $aDataUserGroup["FTShpName"];
                $tUsrWahCode = $aDataUserGroup["FTWahCode"];
                $tUsrWahName = $aDataUserGroup["FTWahName"];
            }

            // Data Table Document
            $aTableDocument = array(
                'tTableHD' => 'TAPTPoHD',
                'tTableHDCst' => 'TAPTPoHDCst',
                'tTableHDDis' => 'TAPTPoHDDis',
                'tTableDT' => 'TAPTPoDT',
                'tTableDTDis' => 'TAPTPoDTDis'
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo' => $tPODocNo,
                'FTXthDocKey' => 'TAPTPoHD',
                'FNLngID' => $nLangEdit,
                'nRow' => 10000,
                'nPage' => 1,
            );

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->mPurchaseOrder->FSaMPOGetDataDocHD($aDataWhere);

            // Get Data Document HD Spl
            $aDataDocHDSpl = $this->mPurchaseOrder->FSaMPOGetDataDocHDSpl($aDataWhere);

            // Move Data HD DIS To HD DIS Temp
            $this->mPurchaseOrder->FSxMPOMoveHDDisToTemp($aDataWhere);

            // Move Data DT TO DTTemp
            $this->mPurchaseOrder->FSxMPOMoveDTToDTTemp($aDataWhere);

            // Move Data DTDIS TO DTDISTemp
            $this->mPurchaseOrder->FSxMPOMoveDTDisToDTDisTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                // Prorate HD
                // FCNaHCalculateProrate('TAPTPoHD', $tPODocNo);
                $tPOVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXphVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tPOVATInOrEx,
                    'tDataDocNo' => $tPODocNo,
                    'tDataDocKey' => 'TAPTPoHD',
                    'tDataSeqNo' => ""
                );
              // $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);

            //หาว่าผู้จำหน่ายของเอกสารนี้ใช้ VAT อะไร
              $aDetailSPL = $this->mPurchaseOrder->FSxMPOFindDetailSPL($aDataWhere);

                $aDataComp = FCNaGetCompanyForDocument();

                $tBchCode = $aDataComp['tBchCode'];
                $tCmpRteCode = $aDataComp['tCmpRteCode'];
                $tVatCode = $aDataComp['tVatCode'];
                $cVatRate = $aDataComp['cVatRate'];
                $cXthRteFac = $aDataComp['cXthRteFac'];
                $tCmpRetInOrEx = $aDataComp['tCmpRetInOrEx'];
                
       
                $aDataConfigViewAdd = array(
                    'nOptDecimalShow' => $nOptDecimalShow,
                    'nOptDocSave' => $nOptDocSave,
                    'nOptScanSku' => $nOptScanSku,
                    'tUserBchCode' => $tUsrBchCode,
                    'tUserBchName' => $tUsrBchName,
                    'tUsrMerCode' => $tUsrMerCode,
                    'tUsrMerName' => $tUsrMerName,
                    'tUsrShopType' => $tUsrShopType,
                    'tUsrShopCode' => $tUsrShopCode,
                    'tUsrShopName' => $tUsrShopName,
                    'tBchCompCode' => FCNtGetBchInComp(),
                    'tBchCompName' => FCNtGetBchNameInComp(),
                    'aDataDocHD' => $aDataDocHD,
                    'aDataDocHDSpl' => $aDataDocHDSpl,
                    'aAlwEvent' => $aAlwEvent,
                    'tCmpRetInOrEx' => $tCmpRetInOrEx,
                    'cVatRate' => $cVatRate,
                    'aDetailSPL'    => $aDetailSPL
                );
                $tPOViewPageEdit = $this->load->view('document/purchaseorder/wPurchaseOrderAdd', $aDataConfigViewAdd, true);
                $aReturnData = array(
                    'tPOViewPageEdit' => $tPOViewPageEdit,
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
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



    // Functionality : Call View Table Data Doc DT Temp
    // Parameters : Ajax and Function Parameter
    // Creator : 28/06/2018 wasin(Yoshi AKA: Mr.JW)
    // Return : Object  View Table Data Doc DT Temp
    // Return Type : object
    public function FSoCPOPdtAdvTblLoadData() {
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

            $tPODocNo           = $this->input->post('ptPODocNo');
            $tPOStaApv          = $this->input->post('ptPOStaApv');
            $tPOStaDoc          = $this->input->post('ptPOStaDoc');
            $tPOVATInOrEx       = $this->input->post('ptPOVATInOrEx');
            $nPOPageCurrent     = $this->input->post('pnPOPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            $tPOPdtCode         = $this->input->post('ptPOPdtCode');
            $tPOPunCode         = $this->input->post('ptPOPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow    = 'TAPTPoDT';
            // $aColumnShow            = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tPODocNo,
                'FTXthDocKey'           => 'TAPTPoHD',
                'nPage'                 => $nPOPageCurrent,
                'nRow'                  => 90000,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall' => '1',
                'tDataVatInOrEx' => $tPOVATInOrEx,
                'tDataDocNo' => $tPODocNo,
                'tDataDocKey' => 'TAPTPoHD',
                'tDataSeqNo' => ''
            ];
            // FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->mPurchaseOrder->FSaMPOGetDocDTTempListPage($aDataWhere);
            $aDataDocDTTempSum  = $this->mPurchaseOrder->FSaMPOSumDocDTTemp($aDataWhere);
            $aDataView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tPOStaApv'         => $tPOStaApv,
                'tPOStaDoc'         => $tPOStaDoc,
                'tPOPdtCode'        => $tPOPdtCode,
                'tPOPunCode'        => $tPOPunCode,
                'nPage'             => $nPOPageCurrent,
                'aColumnShow'       => array(),
                'aDataDocDTTemp'    => $aDataDocDTTemp,
                'aDataDocDTTempSum' => $aDataDocDTTempSum,
            );

            $tPOPdtAdvTableHtml = $this->load->view('document/purchaseorder/wPurchaseOrderPdtAdvTableData', $aDataView, true);

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'   => $tPOVATInOrEx,
                'tDocNo'        => $tPODocNo,
                'tDocKey'       => 'TAPTPoHD',
                'nLngID'        => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode'      => $this->input->post('tSelectBCH')
            );

            //คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020       
            $aPOEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aPOEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            // print_r($aPOEndOfBill['aEndOfBillCal']);
            $aPOEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aPOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

            $aPackDataCalCulate = array(
                'tDocNo'        => $tPODocNo,
                'tBchCode'      => $this->input->post('tSelectBCH'),
                'nB4Dis'        => $aPOEndOfBill['aEndOfBillCal']['cSumFCXtdNet'],
                'tSplVatType'   => $tPOVATInOrEx
            );
            // $tCalculateAgain = FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
            // if($tCalculateAgain == 'CHANGE'){
                // $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                // if($aStaCalcDTTemp === TRUE){
                //     FCNaHCalculateProrate('TAPTPoHD',$aPackDataCalCulate['tDocNo']);
                    // FCNbHCallCalcDocDTTemp($aCalcDTParams);
                // }
            //     $aPOEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            //     $aPOEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            //     $aPOEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aPOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            // }

            $aReturnData = array(
                'tPOPdtAdvTableHtml' => $tPOPdtAdvTableHtml,
                'aPOEndOfBill' => $aPOEndOfBill,
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

 

    // Function: Call View Table Manage Advance Table
    // Parameters: Document Type
    // Creator: 01/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object View Advance Table
    // ReturnType: Object
    public function FSoCPOAdvTblShowColList() {
        try {
            $tTableShowColums = 'TAPTPoDT';
            $aAvailableColumn = FCNaDCLAvailableColumn($tTableShowColums);

            // print_r($aAvailableColumn);
            // die();
            $aDataViewAdvTbl = array(
                'aAvailableColumn' => $aAvailableColumn
            );
            $tViewTableShowCollist = $this->load->view('document/purchaseorder/advancetable/wPurchaseOrderTableShowColList', $aDataViewAdvTbl, true);
            $aReturnData = array(
                'tViewTableShowCollist' => $tViewTableShowCollist,
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

    // Function: Save Columns Advance Table
    // Parameters: Data Save Colums Advance Table
    // Creator: 01/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Sta Save Advance Table
    // ReturnType: Object
    public function FSoCPOAdvTalShowColSave() {
        try {
            $this->db->trans_begin();

            $nPOStaSetDef = $this->input->post('pnPOStaSetDef');
            $aPOColShowSet = $this->input->post('paPOColShowSet');
            $aPOColShowAllList = $this->input->post('paPOColShowAllList');
            $aPOColumnLabelName = $this->input->post('paPOColumnLabelName');
            // Table Set Show Colums
            $tTableShowColums = "TAPTPoDT";
            FCNaDCLSetShowCol($tTableShowColums, '', '');
            if ($nPOStaSetDef == '1') {
                FCNaDCLSetDefShowCol($tTableShowColums);
            } else {
                for ($i = 0; $i < FCNnHSizeOf($aPOColShowSet); $i++) {
                    FCNaDCLSetShowCol($tTableShowColums, 1, $aPOColShowSet[$i]);
                }
            }
            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums, '', '', '');
            $q = 1;
            for ($n = 0; $n < FCNnHSizeOf($aPOColShowAllList); $n++) {
                FCNaDCLUpdateSeq($tTableShowColums, $aPOColShowAllList[$n], $q, $aPOColumnLabelName[$n]);
                $q++;
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Eror Not Save Colums'
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaEvent' => '1',
                    'tStaMessg' => 'Success'
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

    // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSoCPOAddPdtIntoDocDTTemp() {
        try {
            $tPOUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tPODocNo           = $this->input->post('tPODocNo');
            $tPOVATInOrEx       = $this->input->post('tPOVATInOrEx');
            $tPOBchCode         = $this->input->post('tSelectBCH');
            $tPOOptionAddPdt    = $this->input->post('tPOOptionAddPdt');
            $tPOPdtData         = $this->input->post('tPOPdtData');
            $aPOPdtData         = json_decode($tPOPdtData);
            $nVatRate           = $this->input->post('nVatRate');
            $nVatCode           = $this->input->post('nVatCode');

            $aDataWhere = array(
                'FTBchCode' => $tPOBchCode,
                'FTXthDocNo' => $tPODocNo,
                'FTXthDocKey' => 'TAPTPoHD',
            );

            $this->db->trans_begin();

            // $nPOMaxSeqNo    = $this->mPurchaseOrder->FSaMPOGetMaxSeqDocDTTemp($aDataWhere);
            // $nPOMaxSeqNo   += 1;

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aPOPdtData); $nI++) {
                $tPOPdtCode = $aPOPdtData[$nI]->pnPdtCode;
                $tPOBarCode = $aPOPdtData[$nI]->ptBarCode;
                $tPOPunCode = $aPOPdtData[$nI]->ptPunCode;
  
     
                $cPOPrice       = $aPOPdtData[$nI]->packData->Price;
                // $nPOMaxSeqNo = $this->mPurchaseOrder->FSaMPOGetMaxSeqDocDTTemp($aDataWhere);
                $aDataPdtParams = array(
                    'tDocNo'            => $tPODocNo,
                    'tBchCode'          => $tPOBchCode,
                    'tPdtCode'          => $tPOPdtCode,
                    'tBarCode'          => $tPOBarCode,
                    'tPunCode'          => $tPOPunCode,
                    'cPrice'            => str_replace(",","",$cPOPrice),
                    'nMaxSeqNo'         => $this->input->post('tSeqNo'),
                    'nLngID'            => $this->input->post("ohdPOLangEdit"),
                    // 'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tSessionID'        => $this->input->post('ohdSesSessionID'),
                    'tDocKey'           => 'TAPTPoHD',
                    'tPOOptionAddPdt'   => $tPOOptionAddPdt,
                    'tPOUsrCode'        => $this->input->post('ohdPOUsrCode'),
                    'nVatRate'          => $nVatRate,
                    'nVatCode'          => $nVatCode
                );
                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->mPurchaseOrder->FSaMPOGetDataPdt($aDataPdtParams);
                // $aDataPdtMaster = array();
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp = $this->mPurchaseOrder->FSaMPOInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
            }

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Insert Product Error Please Contact Admin.'
                );
            } else {
                $this->db->trans_commit();
                // Calcurate Document DT Temp Array Parameter
                $aCalcDTParams = [
                    'tDataDocEvnCall'   => '1',
                    'tDataVatInOrEx'    => $tPOVATInOrEx,
                    'tDataDocNo'        => $tPODocNo,
                    'tDataDocKey'       => 'TAPTPoHD',
                    'tDataSeqNo'        => ''
                ];
                // $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                $tStaCalcuRate = TRUE;
                if ($tStaCalcuRate === TRUE) {
                    // Prorate HD
                    // FCNaHCalculateProrate('TAPTPoHD', $tPODocNo);
                    // FCNbHCallCalcDocDTTemp($aCalcDTParams);

                    //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
                    /*****************************************************************/
                    /**/    $this->FSxCalculateHDDisAgain($tPODocNo,$tPOBchCode);  /**/
                    /*****************************************************************/

                    $aReturnData = array(
                        'nStaEvent' => '1',
                        'tStaMessg' => 'Success Add Product Into Document DT Temp.'
                    );
                } else {
                    $aReturnData = array(
                        'nStaEvent' => '500',
                        'tStaMessg' => 'Error Calcurate Document DT Temp Please Contact Admin.'
                    );
                }
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
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Edit Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSoCPOEditPdtIntoDocDTTemp() {
        try {
            // $bStaSession    =   $this->session->userdata('bSesLogIn');
            // if(isset($bStaSession) && $bStaSession === TRUE){
            //     //ยังมี Session อยู่
            // }else{
            //     echo 'expire';
            //     exit;
            // }

            $tPOBchCode         = $this->input->post('tPOBchCode');
            $tPODocNo           = $this->input->post('tPODocNo');
            // $tPOVATInOrEx = $this->input->post('tPOVATInOrEx');
            $nPOSeqNo           = $this->input->post('nPOSeqNo');
            // $tPOFieldName = $this->input->post('tPOFieldName');
            // $tPOValue = $this->input->post('tPOValue');
            // $nPOIsDelDTDis = $this->input->post('nPOIsDelDTDis');
            $tPOSessionID       = $this->input->post('ohdSesSessionID');

            $nStaDelDis         = $this->input->post('nStaDelDis');

            $aDataWhere = array(
                'tPOBchCode'    => $tPOBchCode,
                'tPODocNo'      => $tPODocNo,
                'nPOSeqNo'      => $nPOSeqNo,
                'tPOSessionID'  => $this->input->post('ohdSesSessionID'),
                'tDocKey'       => 'TAPTPoHD',
            );
            $aDataUpdateDT = array(
                'FCXtdQty'          => $this->input->post('nQty'),
                'FCXtdSetPrice'     => $this->input->post('cPrice'),
                'FCXtdNet'          => $this->input->post('cNet')
            );

            $this->db->trans_begin();
            $this->mPurchaseOrder->FSaMPOUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);
            if($nStaDelDis == 1){
                // ยืนยันการลบ DTDis ส่วนลดรายการนี้
                $this->mPurchaseOrderDisChgModal->FSaMPODeleteDTDisTemp($aDataWhere);
                $this->mPurchaseOrderDisChgModal->FSaMPOClearDisChgTxtDTTemp($aDataWhere);
            }

            //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
            /*****************************************************************/
            /**/    $this->FSxCalculateHDDisAgain($tPODocNo,$tPOBchCode);  /**/
            /*****************************************************************/

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
                // // Prorate HD
                // FCNaHCalculateProrate('TAPTPoHD', $tPODocNo);

                // $aCalcDTTempParams = array(
                //     'tDataDocEvnCall' => '1',
                //     'tDataVatInOrEx' => $tPOVATInOrEx,
                //     'tDataDocNo' => $tPODocNo,
                //     'tDataDocKey' => 'TAPTPoHD',
                //     'tDataSeqNo' => $nPOSeqNo
                // );
                // $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);
                // if ($tStaCalDocDTTemp === TRUE) {
                //     $aReturnData = array(
                //         'nStaEvent' => '1',
                //         'tStaMessg' => "Update And Calcurate Process Document DT Temp Success."
                //     );
                // } else {
                //     $aReturnData = array(
                //         'nStaEvent' => '500',
                //         'tStaMessg' => "Error Cannot Calcurate Document DT Temp."
                //     );
                // }
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
    // Parameters: Document Type
    // Creator: 14/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Edit Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSvCPORemovePdtInDTTmp() {
        try {
            $this->db->trans_begin();

            $aDataWhere = array(
                'tBchCode' => $this->input->post('tBchCode'),
                'tDocNo' => $this->input->post('tDocNo'),
                'tPdtCode' => $this->input->post('tPdtCode'),
                'nSeqNo' => $this->input->post('nSeqNo'),
                'tVatInOrEx' => $this->input->post('tVatInOrEx'),
                'tSessionID' => $this->session->userdata('tSesSessionID'),
            );

            $aStaDelPdtDocTemp = $this->mPurchaseOrder->FSnMPODelPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();

                //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
                /*****************************************************************/
                /**/    $tPODocNo   = $this->input->post('tDocNo');            /**/ 
                /**/    $tPOBchCode = $this->input->post('tBchCode');          /**/ 
                /**/    $this->FSxCalculateHDDisAgain($tPODocNo,$tPOBchCode);  /**/
                /*****************************************************************/

                // Prorate HD
                // FCNaHCalculateProrate('TAPTPoHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TAPTPoHD',
                    'tDataSeqNo' => ''
                ];
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
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

    // Function: Remove Product In Documeny Temp Multiple
    // Parameters: Document Type
    // Creator: 26/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Event Delte
    // ReturnType: Object
    public function FSvCPORemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tBchCode' => $this->input->post('ptPOBchCode'),
                'tDocNo' => $this->input->post('ptPODocNo'),
                'tVatInOrEx' => $this->input->post('ptPOVatInOrEx'),
                'aDataPdtCode' => $this->input->post('paDataPdtCode'),
                // 'aDataPunCode' => $this->input->post('paDataPunCode'),
                'aDataSeqNo' => $this->input->post('paDataSeqNo')
            );

            $aStaDelPdtDocTemp = $this->mPurchaseOrder->FSnMPODelMultiPdtInDTTmp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Cannot Delete Item.',
                );
            } else {
                $this->db->trans_commit();

                //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
                /*****************************************************************/
                /**/    $tPODocNo   = $this->input->post('tDocNo');            /**/ 
                /**/    $tPOBchCode = $this->input->post('tBchCode');          /**/ 
                /**/    $this->FSxCalculateHDDisAgain($tPODocNo,$tPOBchCode);  /**/
                /*****************************************************************/
                
                // Prorate HD
                FCNaHCalculateProrate('TAPTPoHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TAPTPoHD',
                    'tDataSeqNo' => ''
                ];
                FCNbHCallCalcDocDTTemp($aCalcDTParams);
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

    // =================================================================================== Add / Edit Document ===================================================================================
    // Function: Check Product Have In Temp For Document DT
    // Parameters: Ajex Event Before Save DT
    // Creator: 03/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Check Product DT Temp
    // ReturnType: Object
    public function FSoCPOChkHavePdtForDocDTTemp() {
        try {
            $tPODocNo = $this->input->post("ptPODocNo");
            $tPOSessionID = $this->input->post('tPOSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo' => $tPODocNo,
                'FTXthDocKey' => 'TAPTPoHD',
                'FTSessionID' => $tPOSessionID
            );
            $nCountPdtInDocDTTemp = $this->mPurchaseOrder->FSnMPOChkPdtInDocDTTemp($aDataWhere);
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn' => '800',
                    'tStaMessg' => language('document/purchaseorder/saleorder', 'tPOPleaseSeletedPDTIntoTable')
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

    // Function: คำนวณค่าจาก DT Temp ให้ HD
    // Parameters: Ajex Event Add Document
    // Creator: 04/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array Data Calcurate DocDTTemp For HD
    // ReturnType: Array
    private function FSaCPOCalDTTempForHD($paParams) {
        $aCalDTTemp = $this->mPurchaseOrder->FSaMPOCalInDTTemp($paParams);
        if (isset($aCalDTTemp) && !empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            // $pCalRoundParams = [
            //     'FCXphAmtV' => $aCalDTTempItems['FCXphAmtV'],
            //     'FCXphAmtNV' => $aCalDTTempItems['FCXphAmtNV']
            // ];

            // // print_r($pCalRoundParams);
            // // die();
            // $aRound = $this->FSaCPOCalRound($pCalRoundParams);
            // // คำนวณหา ยอดรวม ให้ HD(FCXphGrand)
            // $nRound = $aRound['nRound'];
            // $cGrand = $aRound['cAfRound'];
            $nRound = 0;
            $cGrand = $aCalDTTempItems['FCXphAmtV'] + $aCalDTTempItems['FCXphAmtNV'];
            // จัดรูปแบบข้อความ จากตัวเลขเป็นข้อความ HD(FTXphGndText)
            $tGndText = FCNtNumberToTextBaht(number_format($cGrand, 2));
            $aCalDTTempItems['FCXphRnd'] = $nRound;
            $aCalDTTempItems['FCXphGrand'] = $cGrand;
            $aCalDTTempItems['FTXphGndText'] = $tGndText;
            return $aCalDTTempItems;
        }
    }

    // Function: หาค่าปัดเศษ HD(FCXphRnd)
    // Parameters: Ajex Event Add Document
    // Creator: 04/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array ค่าปักเศษ
    // ReturnType: Array
    private function FSaCPOCalRound($paParams) {
        $tOptionRound = '1';  // ปัดขึ้น
        $cAmtV = $paParams['FCXphAmtV'];
        $cAmtNV = $paParams['FCXphAmtNV'];
        $cBath = $cAmtV + $cAmtNV;
        // ตัดเอาเฉพาะทศนิยม
        $nStang = explode('.', number_format($cBath, 2))[1];
        $nPoint = 0;
        $nRound = 0;
        /* ====================== ปัดขึ้น ================================ */
        if ($tOptionRound == '1') {
            if ($nStang >= 1 and $nStang < 25) {
                $nPoint = 25;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 25 and $nStang < 50) {
                $nPoint = 50;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 50 and $nStang < 75) {
                $nPoint = 75;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 75 and $nStang < 100) {
                $nPoint = 100;
                $nRound = $nPoint - $nStang;
            }
        }
        /* ====================== ปัดขึ้น ================================ */

        /* ====================== ปัดลง ================================ */
        if ($tOptionRound != '1') {
            if ($nStang >= 1 and $nStang < 25) {
                $nPoint = 1;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 25 and $nStang < 50) {
                $nPoint = 25;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 50 and $nStang < 75) {
                $nPoint = 50;
                $nRound = $nPoint - $nStang;
            }
            if ($nStang > 75 and $nStang < 100) {
                $nPoint = 75;
                $nRound = $nPoint - $nStang;
            }
        }
        /* ====================== ปัดลง ================================ */
        $cAfRound = floatval($cBath) + floatval($nRound / 100);
        return [
            'tRoundType' => $tOptionRound,
            'cBath' => $cBath,
            'nPoint' => $nPoint,
            'nStang' => $nStang,
            'nRound' => $nRound,
            'cAfRound' => $cAfRound
        ];
    }

    // Function: Add Document 
    // Parameters: Ajex Event Add Document
    // Creator: 03/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Add Document
    // ReturnType: Object
    public function FSoCPOAddEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tPOAutoGenCode = (isset($aDataDocument['ocbPOStaAutoGenCode'])) ? 1 : 0;
            $tPODocNo = (isset($aDataDocument['oetPODocNo'])) ? $aDataDocument['oetPODocNo'] : '';
            $tPODocDate = $aDataDocument['oetPODocDate'] . " " . $aDataDocument['oetPODocTime'];
            $tPOStaDocAct = (isset($aDataDocument['ocbPOFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tPOVATInOrEx = $aDataDocument['ocmPOFrmSplInfoVatInOrEx'];
            $tPOSessionID = $this->input->post('ohdSesSessionID');
            $nPOSubmitWithImp = $aDataDocument['ohdPOSubmitWithImp'];
            
            // Get Data Comp.
            $nLangEdit = $this->input->post("ohdPOLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tAPOReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tAPOReq, $tMethodReq, $aDataWhereComp);
            $aClearDTParams = [
                'FTXthDocNo'     => $tPODocNo,
                'FTXthDocKey'    => 'TAPTPoHD',
                'FTSessionID'    => $this->input->post('ohdSesSessionID'),
            ];
            if($nPOSubmitWithImp==1){
                $this->mPurchaseOrder->FSxMPOClearDataInDocTempForImp($aClearDTParams);
            }

//--------------------------------------------------------------------
            $aResProrat = FCNaHCalculateProrate('TAPTPoHD',$tPODocNo);
            $aCalcDTParams = [
                'tBchCode'          => $aDataDocument['oetPOFrmBchCode'],
                'tDataDocEvnCall'   => '',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                'tDataDocNo'        => $tPODocNo,
                'tDataDocKey'       => 'TAPTPoHD',
                'tDataSeqNo'        => ''
            ];
            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
//-----------------------------------------------------------------------------

            // Prorate HD
            FCNaHCalculateProrate('TAPTPoHD', $tPODocNo);
                        
            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                'tDataDocNo'        => $tPODocNo,
                'tDataDocKey'       => 'TAPTPoHD',
                'tDataSeqNo'        => ''
            ];
             $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);


            $aCalDTTempParams = [
                'tDocNo' => $tPODocNo,
                'tBchCode' => $aDataDocument['oetPOFrmBchCode'],
                'tSessionID' => $tPOSessionID,
                'tDocKey' => 'TAPTPoHD',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
            ];
            $this->mPurchaseOrder->FSaMPOCalVatLastDT($aCalDTTempParams);

            $aCalDTTempForHD = $this->FSaCPOCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mPurchaseOrder->FSaMPOCalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TAPTPoHD',
                'tTableHDDis' => 'TAPTPoHDDis',
                'tTableHDSpl' => 'TAPTPoHDSpl',
                'tTableDT' => 'TAPTPoDT',
                'tTableDTDis' => 'TAPTPoDTDis',
                'tTableStaGen' => 2,
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetPOFrmBchCode'],
                'FTXphDocNo' => $tPODocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->input->post('ohdPOUsrCode'),
                'FTLastUpdBy' => $this->input->post('ohdPOUsrCode'),
                'FTSessionID' => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx' => $tPOVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTShpCode' => $aDataDocument['oetPOFrmShpCode'],
                'FNXphDocType' => 2,
                'FDXphDocDate' => (!empty($tPODocDate)) ? $tPODocDate : NULL,
                'FTXphCshOrCrd' => $aDataDocument['ocmPOFrmSplInfoPaymentType'],
                'FTXphVATInOrEx' => $tPOVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdPODptCode'],
                'FTWahCode' => $aDataDocument['oetPOFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdPOUsrCode'],
                'FTSplCode' => $aDataDocument['oetPOFrmSplCode'],
                'FTXphRefExt' => $aDataDocument['oetPORefExtDoc'],
                'FDXphRefExtDate' => (!empty($aDataDocument['oetPORefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPORefExtDocDate'])) : NULL,
                'FTXphRefInt' => $aDataDocument['oetPORefIntDoc'],
                'FDXphRefIntDate' => (!empty($aDataDocument['oetPORefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPORefIntDocDate'])) : NULL,
                'FNXphDocPrint' => $aDataDocument['ocmPOFrmInfoOthDocPrint'],
                'FTRteCode' => $aDataDocument['ohdPOCmpRteCode'],
                'FCXphRteFac' => $aDataDocument['ohdPORteFac'],
                'FCXphTotal' => $aCalDTTempForHD['FCXphTotal'],
                'FCXphTotalNV' => $aCalDTTempForHD['FCXphTotalNV'],
                'FCXphTotalNoDis' => $aCalDTTempForHD['FCXphTotalNoDis'],
                'FCXphTotalB4DisChgV' => $aCalDTTempForHD['FCXphTotalB4DisChgV'],
                'FCXphTotalB4DisChgNV' => $aCalDTTempForHD['FCXphTotalB4DisChgNV'],
                'FTXphDisChgTxt' => isset($aCalInHDDisTemp['FTXphDisChgTxt']) ? $aCalInHDDisTemp['FTXphDisChgTxt'] : '',
                'FCXphDis' => isset($aCalInHDDisTemp['FCXphDis']) ? $aCalInHDDisTemp['FCXphDis'] : NULL,
                'FCXphChg' => isset($aCalInHDDisTemp['FCXphChg']) ? $aCalInHDDisTemp['FCXphChg'] : NULL,
                'FCXphTotalAfDisChgV' => $aCalDTTempForHD['FCXphTotalAfDisChgV'],
                'FCXphTotalAfDisChgNV' => $aCalDTTempForHD['FCXphTotalAfDisChgNV'],
                'FCXphAmtV' => $aCalDTTempForHD['FCXphAmtV'],
                'FCXphAmtNV' => $aCalDTTempForHD['FCXphAmtNV'],
                'FCXphVat' => $aCalDTTempForHD['FCXphVat'],
                'FCXphVatable' => $aCalDTTempForHD['FCXphVatable'],
                'FTXphWpCode' => $aCalDTTempForHD['FTXphWpCode'],
                'FCXphWpTax' => $aCalDTTempForHD['FCXphWpTax'],
                'FCXphGrand' => $aCalDTTempForHD['FCXphGrand'],
                'FCXphRnd' => $aCalDTTempForHD['FCXphRnd'],
                'FTXphGndText' => $aCalDTTempForHD['FTXphGndText'],
                'FTXphRmk' => $aDataDocument['otaPOFrmInfoOthRmk'],
                'FTXphStaRefund' => $aDataDocument['ohdPOStaRefund'],
                'FTXphStaDoc' => $aDataDocument['ohdPOStaDoc'],
                'FTXphStaApv' => !empty($aDataDocument['ohdPOStaApv']) ? $aDataDocument['ohdPOStaApv'] : NULL,
                'FTXphStaPaid' => $aDataDocument['ohdPOStaPaid'],
                'FNXphStaDocAct' => $tPOStaDocAct,
                'FNXphStaRef' => $aDataDocument['ocmPOFrmInfoOthRef']
            );

            // Array Data HD Supplier date('Y-m-d H:i:s', $old_date_timestamp);
            $aDataSpl = array(
                'FTXphDstPaid' => $aDataDocument['ocmPOFrmSplInfoDstPaid'],
                'FNXphCrTerm' => intval($aDataDocument['oetPOFrmSplInfoCrTerm']),
                'FDXphDueDate' => (!empty($aDataDocument['oetPOFrmSplInfoDueDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPOFrmSplInfoDueDate'])) : NULL,
                'FDXphBillDue' => (!empty($aDataDocument['oetPOFrmSplInfoBillDue'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPOFrmSplInfoBillDue'])) : NULL,
                'FTXphCtrName' => $aDataDocument['oetPOFrmSplInfoCtrName'],
                'FDXphTnfDate' => (!empty($aDataDocument['oetPOFrmSplInfoTnfDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPOFrmSplInfoTnfDate'])) : NULL,
                'FTXphRefTnfID' => $aDataDocument['oetPOFrmSplInfoRefTnfID'],
                'FTXphRefVehID' => $aDataDocument['oetPOFrmSplInfoRefVehID'],
                'FTXphRefInvNo' => $aDataDocument['oetPOFrmSplInfoRefInvNo'],
                'FTXphQtyAndTypeUnit' => $aDataDocument['oetPOFrmSplInfoQtyAndTypeUnit'],
                'FNXphShipAdd' => intval($aDataDocument['ohdPOFrmShipAdd']),
                'FNXphTaxAdd' => intval($aDataDocument['ohdPOFrmTaxAdd']),
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tPOAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"    => 'TAPTPoHD',                           
                    "tDocType"    => '2',                                          
                    "tBchCode"    => $aDataDocument['oetPOFrmBchCode'],                                 
                    "tShpCode"    => "",                               
                    "tPosCode"    => "",                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXphDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXphDocNo'] = $tPODocNo;
            }
            // Add Update Document HD
            $this->mPurchaseOrder->FSxMPOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update Document HD Spl
            $this->mPurchaseOrder->FSxMPOAddUpdateHDSpl($aDataSpl, $aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->mPurchaseOrder->FSxMPOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc HD Dis Temp To HDDis
            $this->mPurchaseOrder->FSaMPOMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->mPurchaseOrder->FSaMPOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move Doc DTDisTemp To DTTemp
            $this->mPurchaseOrder->FSaMPOMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);

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

    // Function: Edit Document 
    // Parameters: Ajex Event Add Document
    // Creator: 03/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Add Document
    // ReturnType: Object
    public function FSoCPOEditEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tPOAutoGenCode = (isset($aDataDocument['ocbPOStaAutoGenCode'])) ? 1 : 0;
            $tPODocNo = (isset($aDataDocument['oetPODocNo'])) ? $aDataDocument['oetPODocNo'] : '';
            $tPODocDate = $aDataDocument['oetPODocDate'] . " " . $aDataDocument['oetPODocTime'];
            $tPOStaDocAct = (isset($aDataDocument['ocbPOFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tPOVATInOrEx = $aDataDocument['ocmPOFrmSplInfoVatInOrEx'];
            $tPOSessionID = $this->input->post('ohdSesSessionID');
            $nPOSubmitWithImp = $aDataDocument['ohdPOSubmitWithImp'];
            $aClearDTParams = [
                'FTXthDocNo'     => $tPODocNo,
                'FTXthDocKey'    => 'TAPTPoHD',
                'FTSessionID'    => $this->input->post('ohdSesSessionID'),
            ];
            if($nPOSubmitWithImp==1){
                $this->mPurchaseOrder->FSxMPOClearDataInDocTempForImp($aClearDTParams);
            }

            //--------------------------------------------------------------------
            $aResProrat = FCNaHCalculateProrate('TAPTPoHD',$tPODocNo);
            $aCalcDTParams = [
                'tBchCode'          => $aDataDocument['oetPOFrmBchCode'],
                'tDataDocEvnCall'   => '',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                'tDataDocNo'        => $tPODocNo,
                'tDataDocKey'       => 'TAPTPoHD',
                'tDataSeqNo'        => ''
            ];
            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
            //-----------------------------------------------------------------------------
            
            // Prorate HD
            FCNaHCalculateProrate('TAPTPoHD', $tPODocNo);

            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                'tDataDocNo'        => $tPODocNo,
                'tDataDocKey'       => 'TAPTPoHD',
                'tDataSeqNo'        => ''
            ];
             $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aCalDTTempParams = [
                'tDocNo' => $tPODocNo,
                'tBchCode' => $aDataDocument['oetPOFrmBchCode'],
                'tSessionID' => $tPOSessionID,
                'tDocKey' => 'TAPTPoHD',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                
            ];
            $this->mPurchaseOrder->FSaMPOCalVatLastDT($aCalDTTempParams);
            

            $aCalDTTempForHD = $this->FSaCPOCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mPurchaseOrder->FSaMPOCalInHDDisTemp($aCalDTTempParams);

           // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TAPTPoHD',
                'tTableHDDis' => 'TAPTPoHDDis',
                'tTableHDSpl' => 'TAPTPoHDSpl',
                'tTableDT' => 'TAPTPoDT',
                'tTableDTDis' => 'TAPTPoDTDis',
                'tTableStaGen' => 2,
            );


            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetPOFrmBchCode'],
                'FTXphDocNo' => $tPODocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->input->post('ohdPOUsrCode'),
                'FTLastUpdBy' => $this->input->post('ohdPOUsrCode'),
                'FTSessionID' => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx' => $tPOVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTShpCode' => $aDataDocument['oetPOFrmShpCode'],
                'FNXphDocType' => 2,
                'FDXphDocDate' => (!empty($tPODocDate)) ? $tPODocDate : NULL,
                'FTXphCshOrCrd' => $aDataDocument['ocmPOFrmSplInfoPaymentType'],
                'FTXphVATInOrEx' => $tPOVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdPODptCode'],
                'FTWahCode' => $aDataDocument['oetPOFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdPOUsrCode'],
                'FTSplCode' => $aDataDocument['oetPOFrmSplCode'],
                'FTXphRefExt' => $aDataDocument['oetPORefExtDoc'],
                'FDXphRefExtDate' => (!empty($aDataDocument['oetPORefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPORefExtDocDate'])) : NULL,
                'FTXphRefInt' => $aDataDocument['oetPORefIntDoc'],
                'FDXphRefIntDate' => (!empty($aDataDocument['oetPORefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPORefIntDocDate'])) : NULL,
                'FNXphDocPrint' => $aDataDocument['ocmPOFrmInfoOthDocPrint'],
                'FTRteCode' => $aDataDocument['ohdPOCmpRteCode'],
                'FCXphRteFac' => $aDataDocument['ohdPORteFac'],
                'FCXphTotal' => $aCalDTTempForHD['FCXphTotal'],
                'FCXphTotalNV' => $aCalDTTempForHD['FCXphTotalNV'],
                'FCXphTotalNoDis' => $aCalDTTempForHD['FCXphTotalNoDis'],
                'FCXphTotalB4DisChgV' => $aCalDTTempForHD['FCXphTotalB4DisChgV'],
                'FCXphTotalB4DisChgNV' => $aCalDTTempForHD['FCXphTotalB4DisChgNV'],
                'FTXphDisChgTxt' => isset($aCalInHDDisTemp['FTXphDisChgTxt']) ? $aCalInHDDisTemp['FTXphDisChgTxt'] : '',
                'FCXphDis' => isset($aCalInHDDisTemp['FCXphDis']) ? $aCalInHDDisTemp['FCXphDis'] : NULL,
                'FCXphChg' => isset($aCalInHDDisTemp['FCXphChg']) ? $aCalInHDDisTemp['FCXphChg'] : NULL,
                'FCXphTotalAfDisChgV' => $aCalDTTempForHD['FCXphTotalAfDisChgV'],
                'FCXphTotalAfDisChgNV' => $aCalDTTempForHD['FCXphTotalAfDisChgNV'],
                'FCXphAmtV' => $aCalDTTempForHD['FCXphAmtV'],
                'FCXphAmtNV' => $aCalDTTempForHD['FCXphAmtNV'],
                'FCXphVat' => $aCalDTTempForHD['FCXphVat'],
                'FCXphVatable' => $aCalDTTempForHD['FCXphVatable'],
                'FTXphWpCode' => $aCalDTTempForHD['FTXphWpCode'],
                'FCXphWpTax' => $aCalDTTempForHD['FCXphWpTax'],
                'FCXphGrand' => $aCalDTTempForHD['FCXphGrand'],
                'FCXphRnd' => $aCalDTTempForHD['FCXphRnd'],
                'FTXphGndText' => $aCalDTTempForHD['FTXphGndText'],
                'FTXphRmk' => $aDataDocument['otaPOFrmInfoOthRmk'],
                'FTXphStaRefund' => $aDataDocument['ohdPOStaRefund'],
                'FTXphStaDoc' => !empty($aDataDocument['ohdPOStaDoc']) ? $aDataDocument['ohdPOStaDoc'] : NULL,
                'FTXphStaApv' => !empty($aDataDocument['ohdPOStaApv']) ? $aDataDocument['ohdPOStaApv'] : NULL,
                'FTXphStaPaid' => $aDataDocument['ohdPOStaPaid'],
                'FNXphStaDocAct' => $tPOStaDocAct,
                'FNXphStaRef' => $aDataDocument['ocmPOFrmInfoOthRef']
            );

                // Array Data HD Supplier date('Y-m-d H:i:s', $old_date_timestamp);
                $aDataSpl = array(
                'FTXphDstPaid' => $aDataDocument['ocmPOFrmSplInfoDstPaid'],
                'FNXphCrTerm' => intval($aDataDocument['oetPOFrmSplInfoCrTerm']),
                'FDXphDueDate' => (!empty($aDataDocument['oetPOFrmSplInfoDueDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPOFrmSplInfoDueDate'])) : NULL,
                'FDXphBillDue' => (!empty($aDataDocument['oetPOFrmSplInfoBillDue'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPOFrmSplInfoBillDue'])) : NULL,
                'FTXphCtrName' => $aDataDocument['oetPOFrmSplInfoCtrName'],
                'FDXphTnfDate' => (!empty($aDataDocument['oetPOFrmSplInfoTnfDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPOFrmSplInfoTnfDate'])) : NULL,
                'FTXphRefTnfID' => $aDataDocument['oetPOFrmSplInfoRefTnfID'],
                'FTXphRefVehID' => $aDataDocument['oetPOFrmSplInfoRefVehID'],
                'FTXphRefInvNo' => $aDataDocument['oetPOFrmSplInfoRefInvNo'],
                'FTXphQtyAndTypeUnit' => $aDataDocument['oetPOFrmSplInfoQtyAndTypeUnit'],
                'FNXphShipAdd' => intval($aDataDocument['ohdPOFrmShipAdd']),
                'FNXphTaxAdd' => intval($aDataDocument['ohdPOFrmTaxAdd']),
            );
    
            $this->db->trans_begin();

                // Check Auto GenCode Document
                if ($tPOAutoGenCode == '1') {
                    $aStoreParam = array(
                        "tTblName"    => 'TAPTPoHD',                           
                        "tDocType"    => '1',                                          
                        "tBchCode"    => $aDataDocument['oetPOFrmBchCode'],                                 
                        "tShpCode"    => "",                               
                        "tPosCode"    => "",                     
                        "dDocDate"    => date("Y-m-d")       
                    );
                    $aAutogen         = FCNaHAUTGenDocNo($aStoreParam);
                    $aDataWhere['FTXphDocNo']   = $aAutogen[0]["FTXxhDocNo"];
                } else {
                    $aDataWhere['FTXphDocNo'] = $tPODocNo;
                }
      
            // Add Update Document HD
            $this->mPurchaseOrder->FSxMPOAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update Document HD Spl
            $this->mPurchaseOrder->FSxMPOAddUpdateHDSpl($aDataSpl, $aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->mPurchaseOrder->FSxMPOAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc HD Dis Temp To HDDis
            $this->mPurchaseOrder->FSaMPOMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->mPurchaseOrder->FSaMPOMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move Doc DTDisTemp To DTTemp
            $this->mPurchaseOrder->FSaMPOMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);


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
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // =================================================================================== Cancel / Approve / Print  ===================================================================================
    // Function: Cancel Document
    // Parameters: Ajex Event Add Document
    // Creator: 09/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Cancel Document
    // ReturnType: Object
    public function FSvCPOCancelDocument() {
        try {
            $tPODocNo = $this->input->post('ptPODocNo');
            $aDataUpdate = array(
                'tDocNo' => $tPODocNo,
            );

            $aStaApv = $this->mPurchaseOrder->FSaMPOCancelDocument($aDataUpdate);
            $aReturnData = $aStaApv;
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }


    // Function: Approve Document
    // Parameters: Ajex Event Add Document
    // Creator: 09/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Cancel Document
    // ReturnType: Object
    public function FSvCPOApproveDocument() {
        $tPODocNo = $this->input->post('ptPODocNo');
        $tPOBchCode = $this->input->post('ptPOBchCode');
        $tPOStaApv = $this->input->post('ptPOStaApv');
        $tPOSplPaymentType = $this->input->post('ptPOSplPaymentType');
        $tPOInfoOthRmkAprov = $this->input->post('tPOInfoOthRmkAprov');
        $tPOtiemNotApr = json_decode($this->input->post('thdPOtiemNotApr'), true);

        $aDataDelObj = array(
            'tPOtiemNotApr' => $tPOtiemNotApr,
            'tDocNo'      => $tPODocNo
        );

        // die();
    //    $this->db->trans_begin();
        try {



            $aDataUpdate = array(
                'tDocNo'      => $tPODocNo,
                'tApvCode'    => $this->session->userdata('tSesUsername'),
                'tTableDocHD' => 'TAPTPoHD',
                'tBchCode'    => $tPOBchCode
            );


                
                //do some this for normal aprove 
         $aDataUpdate['nStaApv']=1;//success จบเลย
            $aStaApv = $this->mPurchaseOrder->FSaMPOApproveDocument($aDataUpdate);
            $aReturn = array(
                'nStaEvent' => '1',
                'tStaMessg' => 'Success Document Approve.'
            );


            echo json_encode($aReturn);
           
            // $aMQParams = [
            //     "queuesname" => "MQAPROVE".$this->session->userdata('tSesSessionID'),
            //     "exchangname" => "EX_MQApprove",
            //     "params" => [
            //         "ptBchCode" => $tPOBchCode,
            //         "ptDocNo" => $tPODocNo,
            //         "ptDocType" => 1,
            //         "ptUser" => $this->session->userdata('tSesUsername'),
            //         "ptConnStr" => 0
            //     ]
            // ];
            // FCNxSendExchange($aMQParams);
            return;
        } catch (ErrorException $err) {
            // $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }

    // Function: Function Searh And Add Pdt In Tabel Temp
    // Parameters: Ajex Event Add Document
    // Creator: 30/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Searh And Add Pdt In Tabel Temp
    // ReturnType: Object
    public function FSoCPOSearchAndAddPdtIntoTbl() {
        try {
            $tPOBchCode = $this->input->post('ptPOBchCode');
            $tPODocNo = $this->input->post('ptPODocNo');
            $tPODataSearchAndAdd = $this->input->post('ptPODataSearchAndAdd');
            $tPOStaReAddPdt = $this->input->post('ptPOStaReAddPdt');
            $tPOSessionID = $this->session->userdata('tSesSessionID');
            $nLangEdit = $this->session->userdata("tLangID");
            // เช็คข้อมูลในฐานข้อมูล
            $aDataChkINDB = array(
                'FTBchCode' => $tPOBchCode,
                'FTXthDocNo' => $tPODocNo,
                'FTXthDocKey' => 'TAPTPoHD',
                'FTSessionID' => $tPOSessionID,
                'tPODataSearchAndAdd' => trim($tPODataSearchAndAdd),
                'tPOStaReAddPdt' => $tPOStaReAddPdt,
                'nLangEdit' => $nLangEdit
            );

            $aCountDataChkInDTTemp = $this->mPurchaseOrder->FSaCPOCountPdtBarInTablePdtBar($aDataChkINDB);
            $nCountDataChkInDTTemp = isset($aCountDataChkInDTTemp) && !empty($aCountDataChkInDTTemp) ? FCNnHSizeOf($aCountDataChkInDTTemp) : 0;
            if ($nCountDataChkInDTTemp == 1) {
                // สินค้าหรือ BarCode ทีกรอกมี 1 ตัวให้เอาลง หรือ เช็ค สถานะ Appove ได้เลย
            } else if ($nCountDataChkInDTTemp > 1) {
                // มี Bar Code มากกว่า 1 ให้แสดง Modal
            } else {
                // ไม่พบข้อมูลบาร์โค๊ดกับรหัสสินค้าในระบบ 
                $aReturnData = array(
                    'nStaEvent' => 800,
                    'tStaMessg' => language('document/purchaseorder/saleorder', 'tPONotFoundPdtCodeAndBarcode')
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

    // Function: Clear Data In DocTemp
    // Parameters: Ajex Event Add Document
    // Creator: 13/08/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Clear Data In Document Temp
    // ReturnType: Object
    public function FSoCPOClearDataInDocTemp() {
        try {
            $this->db->trans_begin();

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $this->input->post('ptPODocNo'),
                'FTXthDocKey' => 'TAPTPoHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mPurchaseOrder->FSxMPOClearDataInDocTemp($aWhereClearTemp);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaReturn' => 900,
                    'tStaMessg' => "Error Not Delete Document Temp."
                );
            } else {
                $this->db->trans_commit();
                $aReturnData = array(
                    'nStaReturn' => 1,
                    'tStaMessg' => 'Success Delete Document Temp.'
                );
            }
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaReturn' => 500,
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }
    
    /**
     * Function: Print Document
     * Parameters: Ajax Event Add Document
     * Creator: 27/08/2019 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoCPOPrintDoc() {
        
    }

    //คำนวณส่วนลดท้ายบิลใหม่อีกครั้ง กรณีมีการเพิ่มสินค้า , แก้ไขจำนวน , แก้ไขราคา , ลบสินค้า , ลดรายการ , ลดท้ายบิล 
    public function FSxCalculateHDDisAgain($ptDocumentNumber , $ptBCHCode){
        $aPackDataCalCulate = array(
            'tDocNo'        => $ptDocumentNumber,
            'tBchCode'      => $ptBCHCode
        );
        FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
    }


    
    /**
     * Function: Document
     * Parameters: Call Sum Footer
     * Creator: 23/02/2021 Nale
     * LastUpdate: -
     * Return: Object Status  Document
     * ReturnType: Object
     */
    public function FSaPOCallEndOfBillOnChaheVat(){

            $tPOVATInOrEx = $this->input->post('ptPOVATInOrEx');
            $tPODocNo     = $this->input->post('ptPODocNo');

            $tPOFrmBchCode = $this->input->post('tSelectBCH');
            //--------------------------------------------------------------------
            $aResProrat = FCNaHCalculateProrate('TAPTPoHD',$tPODocNo);
            $aCalcDTParams = [
                'tBchCode'          => $tPOFrmBchCode,
                'tDataDocEvnCall'   => '',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                'tDataDocNo'        => $tPODocNo,
                'tDataDocKey'       => 'TAPTPoHD',
                'tDataSeqNo'        => ''
            ];
            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
            //-----------------------------------------------------------------------------
            
            // Prorate HD
            FCNaHCalculateProrate('TAPTPoHD', $tPODocNo);

            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPOVATInOrEx,
                'tDataDocNo'        => $tPODocNo,
                'tDataDocKey'       => 'TAPTPoHD',
                'tDataSeqNo'        => ''
            ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aCalDTTempParams = [
                'tDocNo' => $tPODocNo,
                'tBchCode' => $tPOFrmBchCode,
                'tSessionID' => $this->session->userdata('tSesSessionID'),
                'tDocKey' => 'TAPTPoHD',
                'tDataVatInOrEx' => $tPOVATInOrEx,
            ];
            $this->mPurchaseOrder->FSaMPOCalVatLastDT($aCalDTTempParams);
            

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'   => $tPOVATInOrEx,
                'tDocNo'        => $tPODocNo,
                'tDocKey'       => 'TAPTPoHD',
                'nLngID'        => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode'      => $this->input->post('tSelectBCH')
            );

            //คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020       
            $aPOEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            
            // var_dump($aPOEndOfBill);
            // die();
            $aPOEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            // print_r($aPOEndOfBill['aEndOfBillCal']);
            $aPOEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aPOEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            if(!empty($aPOEndOfBill['aEndOfBillVat'])){

            $aReturnData = array(
                'aPOEndOfBill' => $aPOEndOfBill,
                'nStaEvent' => '1',
                'tStaMessg' => "Fucntion Success Return View."
            );

            }else{
            $aReturnData  = array(
                'nStaEvent' => '99',
                'tStaMessg' => "Fucntion Error Return View."
            );

            }
            echo json_encode($aReturnData);
    }


    //ทุกครั้งที่เปลี่ยน SPL จะส่งผล ให้เกิดการคำนวณ VAT ใหม่
    public function FSoCPOChangeSPLAffectNewVAT(){
        $tPODocNo       = $this->input->post('tPODocNo');
        $tBCHCode       = $this->input->post('tBCHCode');
        $tVatCode       = $this->input->post('tVatCode');
        $tVatRate       = $this->input->post('tVatRate');

        $aItem = [
            'tPODocNo'      => $tPODocNo,
            'tBCHCode'      => $tBCHCode,
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
            'tDocKey'       => 'TAPTPoHD',
            'FTVatCode'     => $tVatCode,
            'FCXtdVatRate'  => $tVatRate
        ];
        $this->mPurchaseOrder->FSaMPOChangeSPLAffectNewVAT($aItem);
    }


}



