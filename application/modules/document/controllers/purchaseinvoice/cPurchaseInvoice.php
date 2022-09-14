<?php

use Symfony\Component\PropertyAccess\Exception\ExceptionInterface;

defined('BASEPATH') or exit('No direct script access allowed');

class cPurchaseInvoice extends MX_Controller {

    public function __construct() {
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/purchaseinvoice/mPurchaseInvoice');
        $this->load->model('document/purchaseinvoice/mPurchaseInvoiceDisChgModal');
        parent::__construct();
    }

    public function index($nPIBrowseType, $tPIBrowseOption) {
        $aDataConfigView = array(
            'nPIBrowseType'     => $nPIBrowseType,
            'tPIBrowseOption'   => $tPIBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmPI/0/0'), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmPI/0/0'), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/purchaseinvoice/wPurchaseInvoice', $aDataConfigView);
    }

    // Functionality    : Function Call Page From Search List
    // Parameters       : Ajax and Function Parameter
    // Creator          : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : String View
    // Return Type      : View
    public function FSvCPIFormSearchList() {
        $this->load->view('document/purchaseinvoice/wPurchaseInvoiceFormSearchList');
    }

    // Functionality    : Function Call Page Data Table
    // Parameters       : Ajax and Function Parameter
    // Creator          : 19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object View Data Table
    // Return Type      : object
    public function FSoCPIDataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage          = $this->input->post('nPageCurrent');
            $aAlwEvent      = FCNaHCheckAlwFunc('dcmPI/0/0');

            // Get Option Show Decimal
            $nOptDecimalShow = FCNxHGetOptionDecimalShow();

            // Page Current
            if ($nPage == '' || $nPage == null) {
                $nPage      = 1;
            } else {
                $nPage      = $this->input->post('nPageCurrent');
            }

            // Lang ภาษา
            $nLangEdit      = $this->session->userdata("tLangEdit");

            // Data Conditon Get Data Document
            $aDataCondition = array(
                'FNLngID'               => $nLangEdit,
                'nPage'                 => $nPage,
                'nRow'                  => 10,
                'aDatSessionUserLogIn'  => $this->session->userdata("tSesUsrInfo"),
                'aAdvanceSearch'        => $aAdvanceSearch
            );
            $aDataList = $this->mPurchaseInvoice->FSaMPIGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage'             => $nPage,
                'nOptDecimalShow'   => $nOptDecimalShow,
                'aAlwEvent'         => $aAlwEvent,
                'aDataList'         => $aDataList
            );
            $tPIViewDataTableList = $this->load->view('document/purchaseinvoice/wPurchaseInvoiceDataTable', $aConfigView, true);
            $aReturnData = array(
                'tPIViewDataTableList'  => $tPIViewDataTableList,
                'nStaEvent'             => '1',
                'tStaMessg'             => 'Success'
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Functionality    : Function Delete Document Purchase Invoice
    // Parameters       : Ajax and Function Parameter
    // Creator          : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object View Data Table
    // Return Type      : object
    public function FSoCPIDeleteEventDoc() {
        try {
            $tDataDocNo = $this->input->post('tDataDocNo');
            $aDataMaster = array(
                'tDataDocNo' => $tDataDocNo
            );
            $aResDelDoc = $this->mPurchaseInvoice->FSnMPIDelDocument($aDataMaster);
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

    // Functionality    : Function Call Page Add Tranfer Out
    // Parameters       : Ajax and Function Parameter
    // Creator          : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object View Page Add
    // Return Type      : object
    public function FSoCPIAddPage() {
        try {
            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => '',
                'FTXthDocKey' => 'TAPTPiHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];

            $this->mPurchaseInvoice->FSaMCENDeletePDTInTmp($aWhereClearTemp);
            $this->mPurchaseInvoice->FSxMPIClearDataInDocTemp($aWhereClearTemp);

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
                'tDataDocKey' => 'TAPTPiHD',
                'tDataSeqNo' => ''
            );
            FCNbHCallCalcDocDTTemp($aWhereHelperCalcDTTemp);

            $aDataWhere = array(
                'FNLngID' => $nLangEdit
            );

            $tAPIReq        = "";
            $tMethodReq     = "GET";
            $aCompData      = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhere);

            if (isset($aCompData) && $aCompData['rtCode'] == '1') {
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode    = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode       = $aCompData['raItems']['rtVatCodeUse'];
                $tCmpRetInOrEx  = $aCompData['raItems']['rtCmpRetInOrEx'];
                $aVatRate       = FCNoHCallVatlist($tVatCode);
                if (isset($aVatRate) && !empty($aVatRate)) {
                    $cVatRate   = $aVatRate['FCVatRate'][0];
                } else {
                    $cVatRate   = "";
                }
                $aDataRate = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID'   => $nLangEdit
                );
                $aResultRte = $this->mRate->FSaMRTESearchByID($aDataRate);
                if (isset($aResultRte) && $aResultRte['rtCode']) {
                    $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                } else {
                    $cXthRteFac = "";
                }
            } else {
                $tBchCode       = FCNtGetBchInComp();
                $tCmpRteCode    = "";
                $tVatCode       = "";
                $cVatRate       = "";
                $cXthRteFac     = "";
                $tCmpRetInOrEx  = "1";
            }

            // Get Department Code
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $aDataShp = array(
                'FNLngID'       => $nLangEdit,
                'tUsrLogin'     => $tUsrLogin
            );
            $aDataUserGroup = $this->mPurchaseInvoice->FSaPIGetShpCodeForUsrLogin($aDataShp);
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
            $aConfigSysWareHouse = $this->mPurchaseInvoice->FSaMPIGetDefOptionConfigWah($aConfigSys);

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
            );
            $tPIViewPageAdd = $this->load->view('document/purchaseinvoice/wPurchaseInvoiceAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tPIViewPageAdd' => $tPIViewPageAdd,
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

    // Functionality    : Function Call Page Edit Tranfer Out
    // Parameters       : Ajax and Function Parameter
    // Creator          : 19/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object View Page Add
    // Return Type      : object
    public function FSoCPIEditPage() {
        try {
            $tPIDocNo = $this->input->post('ptPIDocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $tPIDocNo,
                'FTXthDocKey' => 'TAPTPiHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mPurchaseInvoice->FSxMPIClearDataInDocTemp($aWhereClearTemp);

            // Get Autentication Route
            $aAlwEvent          = FCNaHCheckAlwFunc('dcmPI/0/0');
            // Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();
            // Get Option Doc Save
            $nOptDocSave        = FCNnHGetOptionDocSave();
            // Get Option Scan SKU
            $nOptScanSku        = FCNnHGetOptionScanSku();
            // Lang ภาษา
            $nLangEdit          = $this->session->userdata("tLangEdit");

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $aDataShp = array(
                'FNLngID'       => $nLangEdit,
                'tUsrLogin'     => $tUsrLogin
            );

            $aDataUserGroup = $this->mPurchaseInvoice->FSaPIGetShpCodeForUsrLogin($aDataShp);
            if (isset($aDataUserGroup) && empty($aDataUserGroup)) {
                $tUsrBchCode    = "";
                $tUsrBchName    = "";
                $tUsrMerCode    = "";
                $tUsrMerName    = "";
                $tUsrShopType   = "";
                $tUsrShopCode   = "";
                $tUsrShopName   = "";
            } else {
                $tUsrBchCode    = $aDataUserGroup["FTBchCode"];
                $tUsrBchName    = $aDataUserGroup["FTBchName"];
                $tUsrMerCode    = $aDataUserGroup["FTMerCode"];
                $tUsrMerName    = $aDataUserGroup["FTMerName"];
                $tUsrShopType   = $aDataUserGroup["FTShpType"];
                $tUsrShopCode   = $aDataUserGroup["FTShpCode"];
                $tUsrShopName   = $aDataUserGroup["FTShpName"];
            }

            // Data Table Document
            $aTableDocument = array(
                'tTableHD'      => 'TAPTPiHD',
                'tTableHDSpl'   => 'TAPTPiHDSpl',
                'tTableHDDis'   => 'TAPTPiHDDis',
                'tTableDT'      => 'TAPTPiDT',
                'tTableDTDis'   => 'TAPTPiDTDis'
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo'    => $tPIDocNo,
                'FTXthDocKey'   => 'TAPTPiHD',
                'FNLngID'       => $nLangEdit,
                'nRow'          => 10000,
                'nPage'         => 1,
                'tTableDTFhn'   => 'TAPTPiDTFhn'
            );

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->mPurchaseInvoice->FSaMPIGetDataDocHD($aDataWhere);

            // Get Data Document HD Spl
            $aDataDocHDSpl = $this->mPurchaseInvoice->FSaMPIGetDataDocHDSpl($aDataWhere);

            // Move Data HD DIS To HD DIS Temp
            $this->mPurchaseInvoice->FSxMPIMoveHDDisToTemp($aDataWhere);

            // Move Data DT TO DTTemp
            $this->mPurchaseInvoice->FSxMPIMoveDTToDTTemp($aDataWhere);

            // Move Data DTDIS TO DTDISTemp
            $this->mPurchaseInvoice->FSxMPIMoveDTDisToDTDisTemp($aDataWhere);

            $this->mPurchaseInvoice->FCNxMPIMoveDTToDTFhnTemp($aDataWhere); // Move DT To DT Temp Fashion

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                // Prorate HD
                FCNaHCalculateProrate('TAPTPiHD', $tPIDocNo);
                $tPIVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXphVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall'   => '1',
                    'tDataVatInOrEx'    => $tPIVATInOrEx,
                    'tDataDocNo'        => $tPIDocNo,
                    'tDataDocKey'       => 'TAPTPiHD',
                    'tDataSeqNo'        => ""
                );
                $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);

                $tAPIReq    = "";
                $tMethodReq = "GET";
                $aCompData  = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhere);

                //หาว่าผู้จำหน่ายของเอกสารนี้ใช้ VAT อะไร
                $aDetailSPL = $this->mPurchaseInvoice->FSxMPIFindDetailSPL($aDataWhere);

                if (isset($aCompData) && $aCompData['rtCode'] == '1') {
                    $tVatCode = $aCompData['raItems']['rtVatCodeUse'];
                    $tCmpRetInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];
                    $aVatRate = FCNoHCallVatlist($tVatCode);
                    if (isset($aVatRate) && !empty($aVatRate)) {
                        $cVatRate = $aVatRate['FCVatRate'][0];
                    } else {
                        $cVatRate = "";
                    }
                } else {
                    $tVatCode       = "";
                    $cVatRate       = "";
                    $tCmpRetInOrEx  = "1";
                }

                $aDataConfigViewAdd = array(
                    'nOptDecimalShow' => $nOptDecimalShow,
                    'nOptDocSave'   => $nOptDocSave,
                    'nOptScanSku'   => $nOptScanSku,
                    'tUserBchCode'  => $tUsrBchCode,
                    'tUserBchName'  => $tUsrBchName,
                    'tUsrMerCode'   => $tUsrMerCode,
                    'tUsrMerName'   => $tUsrMerName,
                    'tUsrShopType'  => $tUsrShopType,
                    'tUsrShopCode'  => $tUsrShopCode,
                    'tUsrShopName'  => $tUsrShopName,
                    'tBchCompCode'  => FCNtGetBchInComp(),
                    'tBchCompName'  => FCNtGetBchNameInComp(),
                    'aDataDocHD'    => $aDataDocHD,
                    'aDataDocHDSpl' => $aDataDocHDSpl,
                    'aAlwEvent'     => $aAlwEvent,
                    'tCmpRetInOrEx' => $tCmpRetInOrEx,
                    'cVatRate'      => $cVatRate,
                    'aDetailSPL'    => $aDetailSPL
                );
                $tPIViewPageEdit = $this->load->view('document/purchaseinvoice/wPurchaseInvoiceAdd', $aDataConfigViewAdd, true);
                $aReturnData = array(
                    'tPIViewPageEdit' => $tPIViewPageEdit,
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

    // Functionality    : Call View Table Data Doc DT Temp
    // Parameters       : Ajax and Function Parameter
    // Creator          : 28/06/2018 wasin(Yoshi AKA: Mr.JW)
    // Return           : Object  View Table Data Doc DT Temp
    // Return Type      : object
    public function FSoCPIPdtAdvTblLoadData() {
        try {
            $tPIDocNo               = $this->input->post('ptPIDocNo');
            $tPIStaApv              = $this->input->post('ptPIStaApv');
            $tPIStaDoc              = $this->input->post('ptPIStaDoc');
            $tPIVATInOrEx           = $this->input->post('ptPIVATInOrEx');
            $nPIPageCurrent         = $this->input->post('pnPIPageCurrent');
            $tSearchPdtAdvTable     = $this->input->post('ptSearchPdtAdvTable');
            // Edit in line
            $tPIPdtCode             = $this->input->post('ptPIPdtCode');
            $tPIPunCode             = $this->input->post('ptPIPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow        = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow    = 'TAPTPiDT';
            $aColumnShow            = FCNaDCLGetColumnShow($tTableGetColumeShow);

            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tPIDocNo,
                'FTXthDocKey'           => 'TAPTPiHD',
                'nPage'                 => $nPIPageCurrent,
                'nRow'                  => 10,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPIVATInOrEx,
                'tDataDocNo'        => $tPIDocNo,
                'tDataDocKey'       => 'TAPTPiHD',
                'tDataSeqNo'        => ''
            ];
            FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->mPurchaseInvoice->FSaMPIGetDocDTTempListPage($aDataWhere);

            $aDataDocDTTempSum  = $this->mPurchaseInvoice->FSaMPISumDocDTTemp($aDataWhere);

            $aDataView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tPIStaApv'         => $tPIStaApv,
                'tPIStaDoc'         => $tPIStaDoc,
                'tPIPdtCode'        => $tPIPdtCode,
                'tPIPunCode'        => $tPIPunCode,
                'nPage'             => $nPIPageCurrent,
                'aColumnShow'       => $aColumnShow,
                'aDataDocDTTemp'    => $aDataDocDTTemp,
                'aDataDocDTTempSum' => $aDataDocDTTempSum,
            );

            $tPIPdtAdvTableHtml = $this->load->view('document/purchaseinvoice/wPurchaseInvoicePdtAdvTableData', $aDataView, true);

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'       => $tPIVATInOrEx,
                'tDocNo'            => $tPIDocNo,
                'tDocKey'           => 'TAPTPiHD',
                'nLngID'            => FCNaHGetLangEdit(),
                'tSesSessionID'     => $this->session->userdata('tSesSessionID'),
                'tBchCode'          => $this->input->post('tBCHCode')
            );

            //คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020
            $aPIEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aPIEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            $aPIEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aPIEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

            $aPackDataCalCulate = array(
                'tDocNo'        => $tPIDocNo,
                'tBchCode'      => '',
                'nB4Dis'        => $aPIEndOfBill['aEndOfBillCal']['cSumFCXtdNet'],
                'tSplVatType'   => $tPIVATInOrEx
            );
            $tCalculateAgain = FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
            if($tCalculateAgain == 'CHANGE'){
                $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);

                if($aStaCalcDTTemp === TRUE){
                    FCNaHCalculateProrate('TAPTPiHD',$aPackDataCalCulate['tDocNo']);
                    FCNbHCallCalcDocDTTemp($aCalcDTParams);
                }

                $aPIEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
                $aPIEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
                $aPIEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aPIEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);
            }

            $aReturnData = array(
                'tPIPdtAdvTableHtml'    => $tPIPdtAdvTableHtml,
                'aPIEndOfBill'          => $aPIEndOfBill,
                'nStaEvent'             => '1',
                'tStaMessg'             => "Fucntion Success Return View.",
                'tCalculateAgain'       => ''
            );
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function         : Call View Table Manage Advance Table
    // Parameters       : Document Type
    // Creator          : 01/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object View Advance Table
    // ReturnType       : Object
    public function FSoCPIAdvTblShowColList() {
        try {
            $tTableShowColums = 'TAPTPiDT';
            $aAvailableColumn = FCNaDCLAvailableColumn($tTableShowColums);
            $aDataViewAdvTbl = array(
                'aAvailableColumn' => $aAvailableColumn
            );
            $tViewTableShowCollist = $this->load->view('document/purchaseinvoice/advancetable/wPurchaseInvoiceTableShowColList', $aDataViewAdvTbl, true);
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

    // Function         : Save Columns Advance Table
    // Parameters       : Data Save Colums Advance Table
    // Creator          : 01/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object Sta Save Advance Table
    // ReturnType       : Object
    public function FSoCPIAdvTalShowColSave() {
        try {
            $this->db->trans_begin();

            $nPIStaSetDef = $this->input->post('pnPIStaSetDef');
            $aPIColShowSet = $this->input->post('paPIColShowSet');
            $aPIColShowAllList = $this->input->post('paPIColShowAllList');
            $aPIColumnLabelName = $this->input->post('paPIColumnLabelName');
            // Table Set Show Colums
            $tTableShowColums = "TAPTPiDT";
            FCNaDCLSetShowCol($tTableShowColums, '', '');
            if ($nPIStaSetDef == '1') {
                FCNaDCLSetDefShowCol($tTableShowColums);
            } else {
                for ($i = 0; $i < FCNnHSizeOf($aPIColShowSet); $i++) {
                    FCNaDCLSetShowCol($tTableShowColums, 1, $aPIColShowSet[$i]);
                }
            }
            // Reset Seq Advannce Table
            FCNaDCLUpdateSeq($tTableShowColums, '', '', '');
            $q = 1;
            for ($n = 0; $n < FCNnHSizeOf($aPIColShowAllList); $n++) {
                FCNaDCLUpdateSeq($tTableShowColums, $aPIColShowAllList[$n], $q, $aPIColumnLabelName[$n]);
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

    // Function         : Add สินค้า ลง Document DT Temp
    // Parameters       : Document Type
    // Creator          : 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object Status Add Pdt To Doc DT Temp
    // ReturnType       : Object
    public function FSoCPIAddPdtIntoDocDTTemp() {
        try {
            $tPIUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tPIDocNo           = $this->input->post('tPIDocNo');
            $tPIVATInOrEx       = $this->input->post('tPIVATInOrEx');
            $tPIBchCode         = $this->input->post('tBCHCode');
            $tPIOptionAddPdt    = $this->input->post('tPIOptionAddPdt');
            $tPIPdtData         = $this->input->post('tPIPdtData');
            $nVatRate           = $this->input->post('nVatRate');
            $nVatCode           = $this->input->post('nVatCode');
            $nPriceWaitScan     = $this->input->post('nPriceWaitScan');
            
            $aPIPdtData         = json_decode($tPIPdtData);

            $aDataWhere = array(
                'FTBchCode'     => $tPIBchCode,
                'FTXthDocNo'    => $tPIDocNo,
                'FTXthDocKey'   => 'TAPTPiHD'
            );

            $this->db->trans_begin();

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aPIPdtData); $nI++) {
                $tPIPdtCode     = $aPIPdtData[$nI]->pnPdtCode;
                $tPIBarCode     = $aPIPdtData[$nI]->ptBarCode;
                $tPIPunCode     = $aPIPdtData[$nI]->ptPunCode;
                if($nPriceWaitScan!=''){
                    $cPIPrice       = $nPriceWaitScan;
                }else{
                    $cPIPrice       = $aPIPdtData[$nI]->packData->Price;
                }

                // $nPIMaxSeqNo = $this->mPurchaseInvoice->FSaMPIGetMaxSeqDocDTTemp($aDataWhere);
                $aDataPdtParams = array(
                    'tDocNo'            => $tPIDocNo,
                    'tBchCode'          => $tPIBchCode,
                    'tPdtCode'          => $tPIPdtCode,
                    'tBarCode'          => $tPIBarCode,
                    'tPunCode'          => $tPIPunCode,
                    'cPrice'            => $cPIPrice,
                    'nMaxSeqNo'         => $this->input->post('tSeqNo'),
                    'nLngID'            => $this->session->userdata("tLangID"),
                    'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tDocKey'           => 'TAPTPiHD',
                    'tPIOptionAddPdt'   => $tPIOptionAddPdt,
                    'nVatRate'          => $nVatRate,
                    'nVatCode'          => $nVatCode
                );

                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->mPurchaseInvoice->FSaMPIGetDataPdt($aDataPdtParams);
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp = $this->mPurchaseInvoice->FSaMPIInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
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
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tPIVATInOrEx,
                    'tDataDocNo' => $tPIDocNo,
                    'tDataDocKey' => 'TAPTPiHD',
                    'tDataSeqNo' => ''
                ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if ($tStaCalcuRate === TRUE) {
                    // Prorate HD
                    // FCNaHCalculateProrate('TAPTPiHD', $tPIDocNo);
                    // FCNbHCallCalcDocDTTemp($aCalcDTParams);

                    $this->FSxCalculateHDDisAgain($tPIDocNo,$tPIBchCode);
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

    // Function         : Edit Inline สินค้า ลง Document DT Temp
    // Parameters       : Document Type
    // Creator          : 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object Status Edit Pdt To Doc DT Temp
    // ReturnType       : Object
    public function FSoCPIEditPdtIntoDocDTTemp() {
        try {
            $tPIBchCode         = $this->input->post('tPIBchCode');
            $tPIDocNo           = $this->input->post('tPIDocNo');
            $tPIVATInOrEx       = $this->input->post('tPIVATInOrEx');
            $nPISeqNo           = $this->input->post('nPISeqNo');
            $nPIIsDelDTDis      = $this->input->post('nStaDelDis');
            $tPISessionID       = $this->session->userdata('tSesSessionID');

            $aDataWhere = array(
                'tPIBchCode'    => $tPIBchCode,
                'tPIDocNo'      => $tPIDocNo,
                'nPISeqNo'      => $nPISeqNo,
                'tPISessionID'  => $this->session->userdata('tSesSessionID'),
                'tDocKey'       => 'TAPTPiHD',
                'nPIStaDis'     =>  $nPIIsDelDTDis 
            );
            $aDataUpdateDT = array(
                // 'tPIFieldName'  => $tPIFieldName,
                // 'tPIValue'      => $tPIValue,
                'FCXtdQty'      => $this->input->post('nQty'),
                'FCXtdSetPrice' => $this->input->post('cPrice'),
                'FCXtdNet'      => $this->input->post('cNet')
            );

            $this->db->trans_begin();

            $this->mPurchaseInvoice->FSaMPIUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);

            if ($nPIIsDelDTDis == '1') {
                // ยืนยันการลบ DTDis ส่วนลดรายการนี้
                $this->mPurchaseInvoiceDisChgModal->FSaMPIDeleteDTDisTemp($aDataWhere);
                $this->mPurchaseInvoiceDisChgModal->FSaMPIClearDisChgTxtDTTemp($aDataWhere);
            }

            //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
            /*****************************************************************/
            /**/    $this->FSxCalculateHDDisAgain($tPIDocNo,$tPIBchCode);  /**/
            /*****************************************************************/

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => "Error Update Inline Into Document DT Temp."
                );
            } else {
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

    // Function         : Remove Product In Documeny Temp
    // Parameters       : Document Type
    // Creator          : 14/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object Status Edit Pdt To Doc DT Temp
    // ReturnType       : Object
    public function FSvCPIRemovePdtInDTTmp() {
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

            $aStaDelPdtDocTemp = $this->mPurchaseInvoice->FSnMPIDelPdtInDTTmp($aDataWhere);

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
                /**/    $tPIDocNo   = $this->input->post('tDocNo');            /**/
                /**/    $tPIBchCode = $this->input->post('tBchCode');          /**/
                /**/    $this->FSxCalculateHDDisAgain($tPIDocNo,$tPIBchCode);  /**/
                /*****************************************************************/

                // ถ้าลบสินค้า ต้องวิ่งไปเช็คด้วยว่า มีท้ายบิล ไหม ถ้าสินค้าที่เหลืออยู่ไม่อนุญาติลด ท้ายบิลก็ต้องลบทิ้งด้วย
                // $aPackDataCalCulate = array(
                //     'tDocNo'        => $this->input->post('tDocNo'),
                //     'tBchCode'      => $this->input->post('tBchCode'),
                //     'nB4Dis'        => '',
                //     'tSplVatType'   => $this->input->post('tVatInOrEx')
                // );
                // FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);

                // Prorate HD
                // FCNaHCalculateProrate('TAPTPiHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TAPTPiHD',
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

    // Function         : Remove Product In Documeny Temp Multiple
    // Parameters       : Document Type
    // Creator          : 26/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate       : -
    // Return           : Object Status Event Delte
    // ReturnType       : Object
    public function FSvCPIRemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tBchCode' => $this->input->post('ptPIBchCode'),
                'tDocNo' => $this->input->post('ptPIDocNo'),
                'tVatInOrEx' => $this->input->post('ptPIVatInOrEx'),
                'aDataPdtCode' => $this->input->post('paDataPdtCode'),
                'aDataPunCode' => $this->input->post('paDataPunCode'),
                'aDataSeqNo' => $this->input->post('paDataSeqNo')
            );

            $aStaDelPdtDocTemp = $this->mPurchaseInvoice->FSnMPIDelMultiPdtInDTTmp($aDataWhere);

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
                /**/    $tPIDocNo   = $this->input->post('ptPIDocNo');         /**/
                /**/    $tPIBchCode = $this->input->post('ptPIBchCode');       /**/
                /**/    $this->FSxCalculateHDDisAgain($tPIDocNo,$tPIBchCode);  /**/
                /*****************************************************************/

                //ถ้าลบสินค้า ต้องวิ่งไปเช็คด้วยว่า มีท้ายบิล ไหม ถ้าสินค้าที่เหลืออยู่ไม่อนุญาติลด ท้ายบิลก็ต้องลบทิ้งด้วย
                // $aPackDataCalCulate = array(
                //     'tDocNo'        => $this->input->post('ptPIDocNo'),
                //     'tBchCode'      => $this->input->post('ptPIBchCode'),
                //     'nB4Dis'        => '',
                //     'tSplVatType'   => $this->input->post('ptPIVatInOrEx')
                // );
                // FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);

                // Prorate HD
                FCNaHCalculateProrate('TAPTPiHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TAPTPiHD',
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

    // Function         : Check Product Have In Temp For Document DT
    // Parameters       : Ajex Event Before Save DT
    // Creator          : 03/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Check Product DT Temp
    // ReturnType       : Object
    public function FSoCPIChkHavePdtForDocDTTemp() {
        try {
            $tPIDocNo = $this->input->post("ptPIDocNo");
            $tPISessionID = $this->session->userdata('tSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo' => $tPIDocNo,
                'FTXthDocKey' => 'TAPTPiHD',
                'FTSessionID' => $tPISessionID
            );
            $nCountPdtInDocDTTemp = $this->mPurchaseInvoice->FSnMPIChkPdtInDocDTTemp($aDataWhere);
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn' => '800',
                    'tStaMessg' => language('document/purchaseinvoice/purchaseinvoice', 'tPIPleaseSeletedPDTIntoTable')
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

    // Function         : คำนวณค่าจาก DT Temp ให้ HD
    // Parameters       : Ajex Event Add Document
    // Creator          : 04/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Array Data Calcurate DocDTTemp For HD
    // ReturnType       : Array
    private function FSaCPICalDTTempForHD($paParams) {
        $aCalDTTemp = $this->mPurchaseInvoice->FSaMPICalInDTTemp($paParams);
        if (isset($aCalDTTemp) && !empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];

            // จะใช้งานได้เมื่อเอกสารขาขาย และชำระเงินแบบเงินสด
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            // $pCalRoundParams = [
            //     'FCXphAmtV' => $aCalDTTempItems['FCXphAmtV'],
            //     'FCXphAmtNV' => $aCalDTTempItems['FCXphAmtNV']
            // ];
            // $aRound = $this->FSaCPICalRound($pCalRoundParams);
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

    // Function         : หาค่าปัดเศษ HD(FCXphRnd)
    // Parameters       : Ajex Event Add Document
    // Creator          : 04/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Array ค่าปักเศษ
    // ReturnType       : Array
    private function FSaCPICalRound($paParams) {
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

    // Function         : Add Document
    // Parameters       : Ajex Event Add Document
    // Creator          : 03/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Add Document
    // ReturnType       : Object
    public function FSoCPIAddEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tPIAutoGenCode = (isset($aDataDocument['ocbPIStaAutoGenCode'])) ? 1 : 0;
            $tPIDocNo = (isset($aDataDocument['oetPIDocNo'])) ? $aDataDocument['oetPIDocNo'] : '';
            $tPIDocDate = $aDataDocument['oetPIDocDate'] . " " . $aDataDocument['oetPIDocTime'];
            $tPIStaDocAct = (isset($aDataDocument['ocbPIFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tPIVATInOrEx = $aDataDocument['ocmPIFrmSplInfoVatInOrEx'];
            $tPISessionID = $this->session->userdata('tSesSessionID');

            // Get Data Comp.
            $nLangEdit = $this->session->userdata("tLangEdit");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tAPIReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);

            $aResProrat = FCNaHCalculateProrate('TAPTPiHD',$tPIDocNo);

            $aCalcDTParams = [
                'tBchCode'          => $aDataDocument['oetPIFrmBchCode'],
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPIVATInOrEx,
                'tDataDocNo'        => $tPIDocNo,
                'tDataDocKey'       => 'TAPTPiHD',
                'tDataSeqNo'        => ''
            ];

            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);

            // Prorate HD
            FCNaHCalculateProrate('TAPTPiHD', $tPIDocNo);

            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPIVATInOrEx,
                'tDataDocNo'        => $tPIDocNo,
                'tDataDocKey'       => 'TAPTPiHD',
                'tDataSeqNo'        => ''
            ];

            $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aCalDTTempParams = [
                'tDocNo'            => $tPIDocNo,
                'tBchCode'          => $aDataDocument['oetPIFrmBchCode'],
                'tSessionID'        => $tPISessionID,
                'tDocKey'           => 'TAPTPiHD',
                'tDataVatInOrEx'    => $tPIVATInOrEx,
            ];

            $this->mPurchaseInvoice->FSaMPICalVatLastDT($aCalDTTempParams);

            $aCalDTTempForHD = $this->FSaCPICalDTTempForHD($aCalDTTempParams);

            $aCalInHDDisTemp = $this->mPurchaseInvoice->FSaMPICalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TAPTPiHD',
                'tTableHDDis' => 'TAPTPiHDDis',
                'tTableHDSpl' => 'TAPTPiHDSpl',
                'tTableDT' => 'TAPTPiDT',
                'tTableDTDis' => 'TAPTPiDTDis',
                'tTableStaGen' => ($aDataDocument['ocmPIFrmSplInfoPaymentType'] == 1) ? 4 : 5,
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetPIFrmBchCode'],
                'FTXphDocNo' => $tPIDocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FTSessionID' => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx' => $tPIVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTShpCode' => $aDataDocument['oetPIFrmShpCode'],
                'FNXphDocType' => intval($aDataDocument['ocmPIFrmSplInfoPaymentType'] == 1 ? 4 : 5),
                'FDXphDocDate' => (!empty($tPIDocDate)) ? $tPIDocDate : NULL,
                'FTXphCshOrCrd' => $aDataDocument['ocmPIFrmSplInfoPaymentType'],
                'FTXphVATInOrEx' => $tPIVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdPIDptCode'],
                'FTWahCode' => $aDataDocument['oetPIFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdPIUsrCode'],
                'FTSplCode' => $aDataDocument['oetPIFrmSplCode'],
                'FTXphRefExt' => $aDataDocument['oetPIRefExtDoc'],
                'FDXphRefExtDate' => (!empty($aDataDocument['oetPIRefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIRefExtDocDate'])) : NULL,
                'FTXphRefInt' => $aDataDocument['oetPIRefIntDoc'],
                'FDXphRefIntDate' => (!empty($aDataDocument['oetPIRefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIRefIntDocDate'])) : NULL,
                'FNXphDocPrint' => $aDataDocument['ocmPIFrmInfoOthDocPrint'],
                'FTRteCode' => $aDataDocument['ohdPICmpRteCode'],
                'FCXphRteFac' => $aDataDocument['ohdPIRteFac'],
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
                'FTXphRmk' => $aDataDocument['otaPIFrmInfoOthRmk'],
                'FTXphStaRefund' => $aDataDocument['ohdPIStaRefund'],
                'FTXphStaDoc' => $aDataDocument['ohdPIStaDoc'],
                'FTXphStaApv' => !empty($aDataDocument['ohdPIStaApv']) ? $aDataDocument['ohdPIStaApv'] : NULL,
                'FTXphStaDelMQ' => !empty($aDataDocument['ohdPIStaDelMQ']) ? $aDataDocument['ohdPIStaDelMQ'] : NULL,
                'FTXphStaPrcStk' => !empty($aDataDocument['ohdPIStaPrcStk']) ? $$aDataDocument['ohdPIStaPrcStk'] : NULL,
                'FTXphStaPaid' => $aDataDocument['ohdPIStaPaid'],
                'FNXphStaDocAct' => $tPIStaDocAct,
                'FNXphStaRef' => $aDataDocument['ocmPIFrmInfoOthRef']
            );

            $aDataSpl = array(
                'FTXphDstPaid' => $aDataDocument['ocmPIFrmSplInfoDstPaid'],
                'FNXphCrTerm' => intval($aDataDocument['oetPIFrmSplInfoCrTerm']),
                'FDXphDueDate' => (!empty($aDataDocument['oetPIFrmSplInfoDueDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIFrmSplInfoDueDate'])) : NULL,
                'FDXphBillDue' => (!empty($aDataDocument['oetPIFrmSplInfoBillDue'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIFrmSplInfoBillDue'])) : NULL,
                'FTXphCtrName' => $aDataDocument['oetPIFrmSplInfoCtrName'],
                'FDXphTnfDate' => (!empty($aDataDocument['oetPIFrmSplInfoTnfDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIFrmSplInfoTnfDate'])) : NULL,
                'FTXphRefTnfID' => $aDataDocument['oetPIFrmSplInfoRefTnfID'],
                'FTXphRefVehID' => $aDataDocument['oetPIFrmSplInfoRefVehID'],
                'FTXphRefInvNo' => $aDataDocument['oetPIFrmSplInfoRefInvNo'],
                'FTXphQtyAndTypeUnit' => $aDataDocument['oetPIFrmSplInfoQtyAndTypeUnit'],
                'FNXphShipAdd' => intval($aDataDocument['ohdPIFrmShipAdd']),
                'FNXphTaxAdd' => intval($aDataDocument['ohdPIFrmTaxAdd']),
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tPIAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"    => $aTableAddUpdate['tTableHD'],
                    "tDocType"    => $aTableAddUpdate['tTableStaGen'],
                    "tBchCode"    => $aDataDocument['oetPIFrmBchCode'],
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXphDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXphDocNo'] = $tPIDocNo;
            }

            // Add Update Document HD
            $this->mPurchaseInvoice->FSxMPIAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update Document HD Spl
            $this->mPurchaseInvoice->FSxMPIAddUpdateHDSpl($aDataSpl, $aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->mPurchaseInvoice->FSxMPIAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc HD Dis Temp To HDDis
            $this->mPurchaseInvoice->FSaMPIMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->mPurchaseInvoice->FSaMPIMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move Doc DTDisTemp To DTTemp
            $this->mPurchaseInvoice->FSaMPIMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);

            $aTableAddUpdate = array(
                'tTableHD'      => 'TAPTPiHD',
                'tTableDT'      => 'TAPTPiDT',
                'tTableDTFhn'   => 'TAPTPiDTFhn',
            );
            $this->mPurchaseInvoice->FCNxMPIMoveDTTmpToDTFhn($aDataWhere, $aTableAddUpdate);

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

    // Function         : Edit Document
    // Parameters       : Ajex Event Add Document
    // Creator          : 03/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Add Document
    // ReturnType       : Object
    public function FSoCPIEditEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tPIAutoGenCode = (isset($aDataDocument['ocbPIStaAutoGenCode'])) ? 1 : 0;
            $tPIDocNo = (isset($aDataDocument['oetPIDocNo'])) ? $aDataDocument['oetPIDocNo'] : '';
            $tPIDocDate = $aDataDocument['oetPIDocDate'] . " " . $aDataDocument['oetPIDocTime'];
            $tPIStaDocAct = (isset($aDataDocument['ocbPIFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tPIVATInOrEx = $aDataDocument['ocmPIFrmSplInfoVatInOrEx'];
            $tPISessionID = $this->session->userdata('tSesSessionID');

            //--------------------------------------------------------------------
            $aResProrat = FCNaHCalculateProrate('TAPTPiHD',$tPIDocNo);
            $aCalcDTParams = [
                'tBchCode'          => $aDataDocument['oetPIFrmBchCode'],
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPIVATInOrEx,
                'tDataDocNo'        => $tPIDocNo,
                'tDataDocKey'       => 'TAPTPiHD',
                'tDataSeqNo'        => ''
            ];

            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
            //--------------------------------------------------------------------

            // Prorate HD
            FCNaHCalculateProrate('TAPTPiHD', $tPIDocNo);

            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tPIVATInOrEx,
                'tDataDocNo'        => $tPIDocNo,
                'tDataDocKey'       => 'TAPTPiHD',
                'tDataSeqNo'        => ''
            ];

            $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aCalDTTempParams = [
                'tDocNo'            => $tPIDocNo,
                'tBchCode'          => $aDataDocument['oetPIFrmBchCode'],
                'tSessionID'        => $tPISessionID,
                'tDocKey'           => 'TAPTPiHD',
                'cSumFCXtdVat'      => $aDataDocument['ohdSumFCXtdVat'],
                'tDataVatInOrEx'    => $tPIVATInOrEx,
            ];

            $this->mPurchaseInvoice->FSaMPICalVatLastDT($aCalDTTempParams);

            $aCalDTTempForHD = $this->FSaCPICalDTTempForHD($aCalDTTempParams);

            $aCalInHDDisTemp = $this->mPurchaseInvoice->FSaMPICalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TAPTPiHD',
                'tTableHDDis' => 'TAPTPiHDDis',
                'tTableHDSpl' => 'TAPTPiHDSpl',
                'tTableDT' => 'TAPTPiDT',
                'tTableDTDis' => 'TAPTPiDTDis',
                'tTableStaGen' => ($aDataDocument['ocmPIFrmSplInfoPaymentType'] == 1) ? 4 : 5,
            );

            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetPIFrmBchCode'],
                'FTXphDocNo' => $tPIDocNo,
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->session->userdata('tSesUsername'),
                'FTLastUpdBy' => $this->session->userdata('tSesUsername'),
                'FTSessionID' => $this->session->userdata('tSesSessionID'),
                'FTXthVATInOrEx' => $tPIVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTShpCode' => $aDataDocument['oetPIFrmShpCode'],
                'FNXphDocType' => intval($aDataDocument['ocmPIFrmSplInfoPaymentType'] == 1 ? 4 : 5),
                'FDXphDocDate' => (!empty($tPIDocDate)) ? $tPIDocDate : NULL,
                'FTXphCshOrCrd' => $aDataDocument['ocmPIFrmSplInfoPaymentType'],
                'FTXphVATInOrEx' => $tPIVATInOrEx,
                'FTDptCode' => $aDataDocument['ohdPIDptCode'],
                'FTWahCode' => $aDataDocument['oetPIFrmWahCode'],
                'FTUsrCode' => $aDataDocument['ohdPIUsrCode'],
                'FTSplCode' => $aDataDocument['oetPIFrmSplCode'],
                'FTXphRefExt' => $aDataDocument['oetPIRefExtDoc'],
                'FDXphRefExtDate' => (!empty($aDataDocument['oetPIRefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIRefExtDocDate'])) : NULL,
                'FTXphRefInt' => $aDataDocument['oetPIRefIntDoc'],
                'FDXphRefIntDate' => (!empty($aDataDocument['oetPIRefIntDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIRefIntDocDate'])) : NULL,
                'FNXphDocPrint' => $aDataDocument['ocmPIFrmInfoOthDocPrint'],
                'FTRteCode' => $aDataDocument['ohdPICmpRteCode'],
                'FCXphRteFac' => $aDataDocument['ohdPIRteFac'],
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
                'FTXphRmk' => $aDataDocument['otaPIFrmInfoOthRmk'],
                'FTXphStaRefund' => $aDataDocument['ohdPIStaRefund'],
                'FTXphStaDoc' => !empty($aDataDocument['ohdPIStaDoc']) ? $aDataDocument['ohdPIStaDoc'] : NULL,
                'FTXphStaApv' => !empty($aDataDocument['ohdPIStaApv']) ? $aDataDocument['ohdPIStaApv'] : NULL,
                'FTXphStaDelMQ' => !empty($aDataDocument['ohdPIStaDelMQ']) ? $aDataDocument['ohdPIStaDelMQ'] : NULL,
                'FTXphStaPrcStk' => !empty($aDataDocument['ohdPIStaPrcStk']) ? $$aDataDocument['ohdPIStaPrcStk'] : NULL,
                'FTXphStaPaid' => $aDataDocument['ohdPIStaPaid'],
                'FNXphStaDocAct' => $tPIStaDocAct,
                'FNXphStaRef' => $aDataDocument['ocmPIFrmInfoOthRef']
            );

            // Array Data HD Supplier date('Y-m-d H:i:s', $old_date_timestamp);
            $aDataSpl = array(
                'FTXphDstPaid' => $aDataDocument['ocmPIFrmSplInfoDstPaid'],
                'FNXphCrTerm' => intval($aDataDocument['oetPIFrmSplInfoCrTerm']),
                'FDXphDueDate' => date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIFrmSplInfoDueDate'])),
                'FDXphBillDue' => date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIFrmSplInfoBillDue'])),
                'FTXphCtrName' => $aDataDocument['oetPIFrmSplInfoCtrName'],
                'FDXphTnfDate' => date('Y-m-d H:i:s', strtotime($aDataDocument['oetPIFrmSplInfoTnfDate'])),
                'FTXphRefTnfID' => $aDataDocument['oetPIFrmSplInfoRefTnfID'],
                'FTXphRefVehID' => $aDataDocument['oetPIFrmSplInfoRefVehID'],
                'FTXphRefInvNo' => $aDataDocument['oetPIFrmSplInfoRefInvNo'],
                'FTXphQtyAndTypeUnit' => $aDataDocument['oetPIFrmSplInfoQtyAndTypeUnit'],
                'FNXphShipAdd' => intval($aDataDocument['ohdPIFrmShipAdd']),
                'FNXphTaxAdd' => intval($aDataDocument['ohdPIFrmTaxAdd']),
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tPIAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"    => $aTableAddUpdate['tTableHD'],
                    "tDocType"    => $aTableAddUpdate['tTableStaGen'],
                    "tBchCode"    => $aDataDocument['oetPIFrmBchCode'],
                    "tShpCode"    => "",
                    "tPosCode"    => "",
                    "dDocDate"    => date("Y-m-d")
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXphDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXphDocNo'] = $tPIDocNo;
            }

            // Add Update Document HD
            $this->mPurchaseInvoice->FSxMPIAddUpdateHD($aDataMaster, $aDataWhere, $aTableAddUpdate);

            // Add Update Document HD Spl
            $this->mPurchaseInvoice->FSxMPIAddUpdateHDSpl($aDataSpl, $aDataWhere, $aTableAddUpdate);

            // Update Doc No Into Doc Temp
            $this->mPurchaseInvoice->FSxMPIAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // Move Doc HD Dis Temp To HDDis
            $this->mPurchaseInvoice->FSaMPIMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // Move Doc DTTemp To DT
            $this->mPurchaseInvoice->FSaMPIMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // Move Doc DTDisTemp To DTTemp
            $this->mPurchaseInvoice->FSaMPIMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);

            $aTableAddUpdate = array(
                'tTableHD'      => 'TAPTPiHD',
                'tTableDT'      => 'TAPTPiDT',
                'tTableDTFhn'   => 'TAPTPiDTFhn',
            );
            $this->mPurchaseInvoice->FCNxMPIMoveDTTmpToDTFhn($aDataWhere, $aTableAddUpdate);

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

    // Function         : Cancel Document
    // Parameters       : Ajex Event Add Document
    // Creator          : 09/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Cancel Document
    // ReturnType       : Object
    public function FSvCPICancelDocument() {
        try {
            $tPIDocNo = $this->input->post('ptPIDocNo');
            $aDataUpdate = array(
                'tDocNo' => $tPIDocNo,
            );

            $aStaApv = $this->mPurchaseInvoice->FSaMPICancelDocument($aDataUpdate);
            $aReturnData = $aStaApv;
        } catch (Exception $Error) {
            $aReturnData = array(
                'nStaEvent' => '500',
                'tStaMessg' => $Error->getMessage()
            );
        }
        echo json_encode($aReturnData);
    }

    // Function         : Approve Document
    // Parameters       : Ajex Event Add Document
    // Creator          : 09/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Cancel Document
    // ReturnType       : Object
    public function FSvCPIApproveDocument() {
        $tPIDocNo = $this->input->post('ptPIDocNo');
        $tPIBchCode = $this->input->post('ptPIBchCode');
        $tPIStaApv = $this->input->post('ptPIStaApv');
        $tPISplPaymentType = $this->input->post('ptPISplPaymentType');

        $aDataUpdate = array(
            'tDocNo' => $tPIDocNo,
            'tApvCode' => $this->session->userdata('tSesUsername')
        );

        $aStaApv = $this->mPurchaseInvoice->FSaMPIApproveDocument($aDataUpdate);

        $tUsrBchCode = FCNtGetBchInComp();
        $tPIDocType = intval($tPISplPaymentType == 1 ? 4 : 5);
        $this->db->trans_begin();
        try {
            $aMQParams = [
                "queueName" => "PURCHASEINV",
                "params" => [
                    "ptBchCode" => $tPIBchCode,
                    "ptDocNo" => $tPIDocNo,
                    "ptDocType" => $tPIDocType,
                    "ptUser" => $this->session->userdata('tSesUsername'),
                ]
            ];
            FCNxCallRabbitMQ($aMQParams);
        } catch (ErrorException $err) {
            $this->db->trans_rollback();
            $aReturn = array(
                'nStaEvent' => '900',
                'tStaMessg' => language('common/main/main', 'tApproveFail')
            );
            echo json_encode($aReturn);
            return;
        }
    }

    // Function         : Function Searh And Add Pdt In Tabel Temp
    // Parameters       : Ajex Event Add Document
    // Creator          : 30/07/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Searh And Add Pdt In Tabel Temp
    // ReturnType       : Object
    public function FSoCPISearchAndAddPdtIntoTbl() {
        try {
            $tPIBchCode = $this->input->post('ptPIBchCode');
            $tPIDocNo = $this->input->post('ptPIDocNo');
            $tPIDataSearchAndAdd = $this->input->post('ptPIDataSearchAndAdd');
            $tPIStaReAddPdt = $this->input->post('ptPIStaReAddPdt');
            $tPISessionID = $this->session->userdata('tSesSessionID');
            $nLangEdit = $this->session->userdata("tLangID");
            // เช็คข้อมูลในฐานข้อมูล
            $aDataChkINDB = array(
                'FTBchCode' => $tPIBchCode,
                'FTXthDocNo' => $tPIDocNo,
                'FTXthDocKey' => 'TAPTPiHD',
                'FTSessionID' => $tPISessionID,
                'tPIDataSearchAndAdd' => trim($tPIDataSearchAndAdd),
                'tPIStaReAddPdt' => $tPIStaReAddPdt,
                'nLangEdit' => $nLangEdit
            );

            $aCountDataChkInDTTemp = $this->mPurchaseInvoice->FSaCPICountPdtBarInTablePdtBar($aDataChkINDB);
            $nCountDataChkInDTTemp = isset($aCountDataChkInDTTemp) && !empty($aCountDataChkInDTTemp) ? FCNnHSizeOf($aCountDataChkInDTTemp) : 0;
            if ($nCountDataChkInDTTemp == 1) {
                // สินค้าหรือ BarCode ทีกรอกมี 1 ตัวให้เอาลง หรือ เช็ค สถานะ Appove ได้เลย
            } else if ($nCountDataChkInDTTemp > 1) {
                // มี Bar Code มากกว่า 1 ให้แสดง Modal
            } else {
                // ไม่พบข้อมูลบาร์โค๊ดกับรหัสสินค้าในระบบ
                $aReturnData = array(
                    'nStaEvent' => 800,
                    'tStaMessg' => language('document/purchaseinvoice/purchaseinvoice', 'tPINotFoundPdtCodeAndBarcode')
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

    // Function         : Clear Data In DocTemp
    // Parameters       : Ajex Event Add Document
    // Creator          : 13/08/2019 wasin(Yoshi)
    // LastUpdate       : -
    // Return           : Object Status Clear Data In Document Temp
    // ReturnType       : Object
    public function FSoCPIClearDataInDocTemp() {
        try {
            $this->db->trans_begin();

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $this->input->post('ptPIDocNo'),
                'FTXthDocKey' => 'TAPTPiHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mPurchaseInvoice->FSxMPIClearDataInDocTemp($aWhereClearTemp);

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

    // Function         : Print Document
    // Parameters       : Ajax Event Add Document
    // Creator          : 27/08/2019 Piya
    // LastUpdate       : -
    // Return           : Object Status Print Document
    // ReturnType       : Object
    public function FSoCPIPrintDoc() {}

    // Function         : คำนวณส่วนลดท้ายบิลใหม่อีกครั้ง กรณีมีการเพิ่มสินค้า , แก้ไขจำนวน , แก้ไขราคา , ลบสินค้า , ลดรายการ , ลดท้ายบิล
    // Parameters       : -
    // Creator          : 24/02/2021 Supawat
    // LastUpdate       : -
    // Return           : -
    // ReturnType       : -
    public function FSxCalculateHDDisAgain($ptDocumentNumber , $ptBCHCode){
        $aPackDataCalCulate = array(
            'tDocNo'        => $ptDocumentNumber,
            'tBchCode'      => $ptBCHCode
        );
        FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
    }

    // Function         : -
    // Parameters       : -
    // Creator          : 24/02/2021 Supawat
    // LastUpdate       : -
    // Return           : -
    // ReturnType       : -
    public function FSaPICallEndOfBillOnChaheVat(){

        $tPIVATInOrEx   = $this->input->post('ptPIVATInOrEx');
        $tPIDocNo       = $this->input->post('ptPIDocNo');
        $tPIFrmBchCode  = $this->input->post('tSelectBCH');


        //--------------------------------------------------------------------
        $aResProrat     = FCNaHCalculateProrate('TAPTPiHD',$tPIDocNo);
        $aCalcDTParams = [
            'tBchCode'          => $tPIFrmBchCode,
            'tDataDocEvnCall'   => '',
            'tDataVatInOrEx'    => $tPIVATInOrEx,
            'tDataDocNo'        => $tPIDocNo,
            'tDataDocKey'       => 'TAPTPiHD',
            'tDataSeqNo'        => ''
        ];
        $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
        //-----------------------------------------------------------------------------

        // Prorate HD
        FCNaHCalculateProrate('TAPTPiHD', $tPIDocNo);

        $aCalcDTParams = [
            'tDataDocEvnCall'   => '1',
            'tDataVatInOrEx'    => $tPIVATInOrEx,
            'tDataDocNo'        => $tPIDocNo,
            'tDataDocKey'       => 'TAPTPiHD',
            'tDataSeqNo'        => ''
        ];
        $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);

        $aCalDTTempParams = [
            'tDocNo' => $tPIDocNo,
            'tBchCode' => $tPIFrmBchCode,
            'tSessionID' => $this->session->userdata('tSesSessionID'),
            'tDocKey' => 'TAPTPiHD',
            'tDataVatInOrEx'    => $tPIVATInOrEx,
        ];
        $this->mPurchaseInvoice->FSaMPICalVatLastDT($aCalDTTempParams);

        // Call Footer Document
        $aEndOfBillParams = array(
            'tSplVatType'   => $tPIVATInOrEx,
            'tDocNo'        => $tPIDocNo,
            'tDocKey'       => 'TAPTPiHD',
            'nLngID'        => FCNaHGetLangEdit(),
            'tSesSessionID' => $this->session->userdata('tSesSessionID'),
            'tBchCode'      => $this->input->post('tSelectBCH')
        );

        //คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020
        $aPIEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
        $aPIEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
        $aPIEndOfBill['tTextBath']      = FCNtNumberToTextBaht($aPIEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

        if(!empty($aPIEndOfBill['aEndOfBillVat'])){
            $aReturnData = array(
                'aPIEndOfBill' => $aPIEndOfBill,
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
    public function FSoCPIChangeSPLAffectNewVAT(){
        $tPIDocNo       = $this->input->post('tPIDocNo');
        $tBCHCode       = $this->input->post('tBCHCode');
        $tVatCode       = $this->input->post('tVatCode');
        $tVatRate       = $this->input->post('tVatRate');

        $aItem = [
            'tPIDocNo'      => $tPIDocNo,
            'tBCHCode'      => $tBCHCode,
            'tSessionID'    => $this->session->userdata('tSesSessionID'),
            'tDocKey'       => 'TAPTPiHD',
            'FTVatCode'     => $tVatCode,
            'FCXtdVatRate'  => $tVatRate
        ];
        $this->mPurchaseInvoice->FSaMPIChangeSPLAffectNewVAT($aItem);
    }

    // Create By : Napat(Jame) 05/04/2021
    // หลังจากเลือก Ref IN PO Move รายการสินค้าจาก PO ไปยัง Tmp PI
    public function FSoCPIMovePODTToDocTmp() {
        try {
            $tPODocNo           = $this->input->post('tPODocNo');
            $tPIUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tPIDocNo           = $this->input->post('tPIDocNo');
            $tPIVATInOrEx       = $this->input->post('tPIVATInOrEx');
            $tPIBchCode         = $this->input->post('tBCHCode');
            $tPIOptionAddPdt    = $this->input->post('tPIOptionAddPdt');
            $nVatRate           = $this->input->post('nVatRate');
            $nVatCode           = $this->input->post('nVatCode');

            $aDataWhere = array(
                'FTBchCode'     => $tPIBchCode,
                'FTXthDocNo'    => $tPIDocNo,
                'FTXthDocKey'   => 'TAPTPiHD'
            );

            $this->db->trans_begin();

            $aDataPdtParams = array(
                'tPODocNo'          => $tPODocNo,
                'tDocNo'            => $tPIDocNo,
                'tBchCode'          => $tPIBchCode,
                'nLngID'            => $this->session->userdata("tLangID"),
                'tSessionID'        => $this->session->userdata('tSesSessionID'),
                'tDocKey'           => 'TAPTPiHD',
                'tPIOptionAddPdt'   => $tPIOptionAddPdt,
                'nVatRate'          => $nVatRate,
                'nVatCode'          => $nVatCode
            );
            
            // นำรายการสินค้า จากใบ PO DT เข้า DT Temp
            $this->mPurchaseInvoice->FSaMPIMovePODTToDocTmp($aDataPdtParams);
            

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
                    'tDataVatInOrEx'    => $tPIVATInOrEx,
                    'tDataDocNo'        => $tPIDocNo,
                    'tDataDocKey'       => 'TAPTPiHD',
                    'tDataSeqNo'        => ''
                ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if ($tStaCalcuRate === TRUE) {
                    $this->FSxCalculateHDDisAgain($tPIDocNo,$tPIBchCode);
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


    //เพิ่มสินค้าลงตาราง Tmp
    public function FSoCPIEventAddPdtIntoDTFhnTemp(){
        try {
            $tTWOUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tPIDocNo            = $this->input->post('tPIDocNo');
            $tPIBchCode         = $this->input->post('tPIWBCH');
            $tPIPdtDataFhn       = $this->input->post('tPIPdtDataFhn');
            $aPIPdtData         = JSON_decode($tPIPdtDataFhn);
            $nPIVATInOrEx       = $this->input->post('nPIVATInOrEx');
            $tTypeInsPDT         = $this->input->post('tPIType');
            $nEvent         = $this->input->post('nEvent');
            
            $aDataWhere = array(
                'tBchCode'  => $tPIBchCode,
                'tDocNo'    => $tPIDocNo,
                'tDocKey'   => 'TAPTPiHD',
            );
            $this->db->trans_begin();
            if($aPIPdtData->tType=='confirm'){
                // $aDataWhere['tPdtCode'] = $aPIPdtData->aResult[0]->tPDTCode;
                // FCNxClearDTFhnTmp($aDataWhere);
                // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
                $nPdtParentQty = 0;
                for ($nI = 0; $nI < FCNnHSizeOf($aPIPdtData->aResult); $nI++) {

                    $aItem          = $aPIPdtData->aResult[$nI];
                    $tPIPdtCode    = $aItem->tPDTCode;
                    $tPItRefCode   = $aItem->tRefCode;
                    $tPItBarCode   = $aItem->tBarCode;
                    $tPItPunCode   = $aItem->tPunCode;

                    $nDTSeq   = $aItem->nDTSeq;

                    $nPInQty       = $aItem->nQty;
                    $nPdtParentQty  = $nPdtParentQty + $nPInQty;
                    
                    $aDataWhere['tPdtCode'] = $tPIPdtCode;
                    $aDataWhere['tBarCode'] = $tPItBarCode;
                    $aDataWhere['tPunCode'] = $tPItPunCode;
                    if($nEvent==1){
                        $nPISeqNo = FCNnGetMaxSeqDTFhnTmp($aDataWhere);
                    }else{
                        $nPISeqNo =  $nDTSeq;
                    }

                    $aDataPdtParams = array(
                        'tDocNo'            => $tPIDocNo,
                        'tBchCode'          => $tPIBchCode,
                        'tPdtCode'          => $tPIPdtCode,
                        'tRefCode'          => $tPItRefCode,
                        'nMaxSeqNo'         => $nPISeqNo,
                        'nQty'              => $nPInQty,
                        'nLngID'            => $this->session->userdata("tLangID"),
                        'tSessionID'        => $this->session->userdata('tSesSessionID'),
                        'tDocKey'           => 'TAPTPiHD',
                    );
                    // นำรายการสินค้าเข้า DT Temp
                    $nStaInsPdtToTmp    = FCNaInsertPDTFhnToTemp($aDataPdtParams);

                }

                $aDataUpdateQtyParent = array(
                    'tDocNo'        => $tPIDocNo,
                    'nXtdSeq'       => $nPISeqNo,
                    'tSessionID'    => $this->session->userdata('tSesSessionID'),
                    'tDocKey'       => 'TAPTPiHD',
                    'tValue'        => $nPdtParentQty
                );
                FCNaUpdateInlineDTTmp($aDataUpdateQtyParent);
            }else{
                $tPIPdtCode = $aPIPdtData->aResult->tPDTCode;
                $aDataPdtParams = array(
                    'tDocNo'            => $tPIDocNo,
                    'tBchCode'          => $tPIBchCode,
                    'tPdtCode'          => $tPIPdtCode,
                    'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tDocKey'           => 'TAPTPiHD',
                );
                $nStaInsPdtToTmp    = FCNxDeletePDTInTmp($aDataPdtParams);
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
                    'tDataVatInOrEx'    => $nPIVATInOrEx,
                    'tDataDocNo'        => $tPIDocNo,
                    'tDataDocKey'       => 'TAPTPiHD',
                    'tDataSeqNo'        => ''
                ];
                $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                if ($tStaCalcuRate === TRUE) {
    
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


}