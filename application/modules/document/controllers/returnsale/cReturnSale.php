<?php
defined('BASEPATH') or exit('No direct script access allowed');

require_once(APPPATH . 'libraries/rabbitmq/vendor/autoload.php');
require_once(APPPATH . 'config/rabbitmq.php');
use PhpAmqpLib\Connection\AMQPStreamConnection;
use PhpAmqpLib\Message\AMQPMessage;

class cReturnSale extends MX_Controller {

    public function __construct() {
        $this->load->model('company/company/mCompany');
        $this->load->model('company/branch/mBranch');
        $this->load->model('company/shop/mShop');
        $this->load->model('payment/rate/mRate');
        $this->load->model('company/vatrate/mVatRate');
        $this->load->model('document/returnsale/mReturnSale');
        $this->load->model('document/returnsale/mReturnSaleDisChgModal');
        parent::__construct();
    }

    public function index($nRSBrowseType, $tRSBrowseOption) {
        $aDataConfigView = array(
            'nRSBrowseType'     => $nRSBrowseType,
            'tRSBrowseOption'   => $tRSBrowseOption,
            'aAlwEvent'         => FCNaHCheckAlwFunc('dcmRS/0/0'), // Controle Event
            'vBtnSave'          => FCNaHBtnSaveActiveHTML('dcmRS/0/0'), // Load Html ของปุ่ม Save ที่เก็บ Session ปัจจุบัน
            'nOptDecimalShow'   => FCNxHGetOptionDecimalShow(),
            'nOptDecimalSave'   => FCNxHGetOptionDecimalSave()
        );
        $this->load->view('document/returnsale/wReturnSale', $aDataConfigView);
    }

    // Functionality : Function Call Page From Search List
    // Parameters : Ajax and Function Parameter
    // Creator : 17/06/2019 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : String View
    // Return Type : View
    public function FSvCRSFormSearchList() {
        $this->load->view('document/returnsale/wReturnSaleFormSearchList');
    }

    // Functionality : Function Call Page Data Table
    // Parameters : Ajax and Function Parameter
    // Creator : 19/06/2018 wasin (Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return : Object View Data Table
    // Return Type : object
    public function FSoCRSDataTable() {
        try {
            $aAdvanceSearch = $this->input->post('oAdvanceSearch');
            $nPage = $this->input->post('nPageCurrent');
            $aAlwEvent = FCNaHCheckAlwFunc('dcmRS/0/0');

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
            $aDataList = $this->mReturnSale->FSaMRSGetDataTableList($aDataCondition);

            $aConfigView = array(
                'nPage' => $nPage,
                'nOptDecimalShow' => $nOptDecimalShow,
                'aAlwEvent' => $aAlwEvent,
                'aDataList' => $aDataList,
            );
            $tRSViewDataTableList = $this->load->view('document/returnsale/wReturnSaleDataTable', $aConfigView, true);
            $aReturnData = array(
                'tRSViewDataTableList' => $tRSViewDataTableList,
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
    public function FSoCRSDeleteEventDoc() {
        try {
            $tDataDocNo = $this->input->post('tDataDocNo');
            $aDataMaster = array(
                'tDataDocNo' => $tDataDocNo
            );
            $aResDelDoc = $this->mReturnSale->FSnMRSDelDocument($aDataMaster);
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
    public function FSoCRSAddPage() {
        try {

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => '',
                'FTXthDocKey' => 'TVDTSalHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];

            $tUserBchCode = $this->session->userdata('tSesUsrBchCom');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->mReturnSale->FSaMRSGetDetailUserBranch($tUserBchCode);
                $tRSPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tRSPplCode = '';
            }
     

            $this->mReturnSale->FSaMCENDeletePDTInTmp($aWhereClearTemp);
            $this->mReturnSale->FSxMRSClearDataInDocTemp($aWhereClearTemp);

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
                'tDataDocKey' => 'TVDTSalHD',
                'tDataSeqNo' => ''
            );
            FCNbHCallCalcDocDTTemp($aWhereHelperCalcDTTemp);

            $aDataWhere = array(
                'FNLngID' => $nLangEdit
            );

            $tARSReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tARSReq, $tMethodReq, $aDataWhere);

            if (isset($aCompData) && $aCompData['rtCode'] == '1') {
                $tBchCode = $aCompData['raItems']['rtCmpBchCode'];
                $tCmpRteCode = $aCompData['raItems']['rtCmpRteCode'];
                $tVatCode = $aCompData['raItems']['rtVatCodeUse'];
                $tCmpRetInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];
                $aVatRate = FCNoHCallVatlist($tVatCode);
                if (isset($aVatRate) && !empty($aVatRate)) {
                    $cVatRate = $aVatRate['FCVatRate'][0];
                } else {
                    $cVatRate = 0;
                }
                $aDataRate = array(
                    'FTRteCode' => $tCmpRteCode,
                    'FNLngID' => $nLangEdit
                );
                $aResultRte = $this->mRate->FSaMRTESearchByID($aDataRate);
                if (isset($aResultRte) && $aResultRte['rtCode']) {
                    $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                } else {
                    $cXthRteFac = 0;
                }
            } else {
                $tBchCode = FCNtGetBchInComp();
                $tCmpRteCode = "";
                $tVatCode = "";
                $cVatRate = 0;
                $cXthRteFac = 0;
                $tCmpRetInOrEx ="1";
            }

            // Get Department Code
            $tUsrLogin = $this->session->userdata('tSesUsername');
            $tDptCode = FCNnDOCGetDepartmentByUser($tUsrLogin);

            // Get ข้อมูลสาขา และ ร้านค้าของ User ที่ login
            $aDataShp = array(
                'FNLngID' => $nLangEdit,
                'tUsrLogin' => $tUsrLogin
            );
            $aDataUserGroup = $this->mReturnSale->FSaMRSGetShpCodeForUsrLogin($aDataShp);
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
                'aDataDocHD' => array('rtCode' => '800'),
                'aDataDocHDSpl' => array('rtCode' => '800'),
                'tCmpRetInOrEx' => $tCmpRetInOrEx,
                'tRSPplCode'  => $tRSPplCode,
            );
            
            $tRSViewPageAdd = $this->load->view('document/returnsale/wReturnSaleAdd', $aDataConfigViewAdd, true);
            $aReturnData = array(
                'tRSViewPageAdd' => $tRSViewPageAdd,
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
    public function FSoCRSEditPage() {
        // die();

        try {
            $tRSDocNo = $this->input->post('ptRSDocNo');

            // Clear Data In Doc DT Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $tRSDocNo,
                'FTXthDocKey' => 'TVDTSalHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mReturnSale->FSxMRSClearDataInDocTemp($aWhereClearTemp);

            $tUserBchCode = $this->session->userdata('tSesUsrBchCom');
            // echo $tUserBchCode;die();
            if(!empty($tUserBchCode)){
                $aDataBch = $this->mReturnSale->FSaMRSGetDetailUserBranch($tUserBchCode);
                $tRSPplCode = $aDataBch['item']['FTPplCode'];
            }else{
                $tRSPplCode = '';
            }
            // Get Autentication Route
            $aAlwEvent = FCNaHCheckAlwFunc('dcmRS/0/0');
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

            $aDataUserGroup = $this->mReturnSale->FSaMRSGetShpCodeForUsrLogin($aDataShp);
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
                'tTableHD' => 'TVDTSalHD',
                'tTableHDCst' => 'TVDTSalHDCst',
                'tTableHDDis' => 'TVDTSalHDDis',
                'tTableDT' => 'TVDTSalDT',
                'tTableDTDis' => 'TVDTSalDTDis'
            );

            // Array Data Where Get (HD,HDSpl,HDDis,DT,DTDis)
            $aDataWhere = array(
                'FTXthDocNo' => $tRSDocNo,
                'FTXthDocKey' => 'TVDTSalHD',
                'FNLngID' => $nLangEdit,
                'nRow' => 10000,
                'nPage' => 1,
            );

            $this->db->trans_begin();

            // Get Data Document HD
            $aDataDocHD = $this->mReturnSale->FSaMRSGetDataDocHD($aDataWhere);

                    // echo '<pre>';
                    // print_r($aDataWhere);
                    // echo '</pre>';
                    // die();
            // Move Data HD DIS To HD DIS Temp
            $this->mReturnSale->FSxMRSMoveHDDisToTemp($aDataWhere);

            // Move Data DT TO DTTemp
            $this->mReturnSale->FSxMRSMoveDTToDTTemp($aDataWhere);

            // Move Data DTDIS TO DTDISTemp
            $this->mReturnSale->FSxMRSMoveDTDisToDTDisTemp($aDataWhere);

            if ($this->db->trans_status() === FALSE) {
                $this->db->trans_rollback();
                $aReturnData = array(
                    'nStaEvent' => '500',
                    'tStaMessg' => 'Error Query Call Edit Page.'
                );
            } else {
                $this->db->trans_commit();
                // Prorate HD
                // FCNaHCalculateProrate('TVDTSalHD', $tRSDocNo);
                $tRSVATInOrEx = ($aDataDocHD['rtCode'] == '1') ? $aDataDocHD['raItems']['FTXshVATInOrEx'] : 1;
                $aCalcDTTempParams = array(
                    'tDataDocEvnCall' => '1',
                    'tDataVatInOrEx' => $tRSVATInOrEx,
                    'tDataDocNo' => $tRSDocNo,
                    'tDataDocKey' => 'TVDTSalHD',
                    'tDataSeqNo' => ""
                );
               $tUserBchCode = $aDataDocHD['raItems']['FTBchCode'];
                if(!empty($tUserBchCode)){
                    $aDataBch = $this->mReturnSale->FSaMRSGetDetailUserBranch($tUserBchCode);
                    $tRSPplCode = $aDataBch['item']['FTPplCode'];
                }else{
                    $tRSPplCode = '';
                }

                $aDataWhere = array(
                    'FNLngID' => $nLangEdit
                );
    
                $tARSReq = "";
                $tMethodReq = "GET";
                $aCompData = $this->mCompany->FSaMCMPList($tARSReq, $tMethodReq, $aDataWhere);

                if (isset($aCompData) && $aCompData['rtCode'] == '1') {
                    $tBchCode = $aCompData['raItems']['rtCmpBchCode'];
                    $tCmpRteCode = $aCompData['raItems']['rtCmpRteCode'];
                    $tVatCode = $aCompData['raItems']['rtVatCodeUse'];
                    $tCmpRetInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];
                    $aVatRate = FCNoHCallVatlist($tVatCode);
                    if (isset($aVatRate) && !empty($aVatRate)) {
                        $cVatRate = $aVatRate['FCVatRate'][0];
                    } else {
                        $cVatRate = "";
                    }
                    $aDataRate = array(
                        'FTRteCode' => $tCmpRteCode,
                        'FNLngID' => $nLangEdit
                    );
                    $aResultRte = $this->mRate->FSaMRTESearchByID($aDataRate);
                    if (isset($aResultRte) && $aResultRte['rtCode']) {
                        $cXthRteFac = $aResultRte['raItems']['rcRteRate'];
                    } else {
                        $cXthRteFac = "";
                    }
                } else {
                    $tBchCode = FCNtGetBchInComp();
                    $tCmpRteCode = "";
                    $tVatCode = "";
                    $cVatRate = "";
                    $cXthRteFac = "";
                    $tCmpRetInOrEx ="1";
                }
 
                // $tStaCalDocDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTTempParams);
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
                    'aAlwEvent' => $aAlwEvent,
                    'tRSPplCode' => $tRSPplCode,
                    'tCmpRetInOrEx' => $tCmpRetInOrEx,
                    'cVatRate' => $cVatRate
                );
                $tRSViewPageEdit = $this->load->view('document/returnsale/wReturnSaleAdd', $aDataConfigViewAdd, true);
                $aReturnData = array(
                    'tRSViewPageEdit' => $tRSViewPageEdit,
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
    public function FSoCRSPdtAdvTblLoadData() {
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

            $tRSDocNo           = $this->input->post('ptRSDocNo');
            $tRSStaApv          = $this->input->post('ptRSStaApv');
            $tRSStaDoc          = $this->input->post('ptRSStaDoc');
            $tRSVATInOrEx       = $this->input->post('ptRSVATInOrEx');
            $nRSPageCurrent     = $this->input->post('pnRSPageCurrent');
            $tSearchPdtAdvTable = $this->input->post('ptSearchPdtAdvTable');
            $tRSPdtCode         = $this->input->post('ptRSPdtCode');
            $tRSPunCode         = $this->input->post('ptRSPunCode');

            //Get Option Show Decimal
            $nOptDecimalShow    = FCNxHGetOptionDecimalShow();

            // Call Advance Table
            $tTableGetColumeShow    = 'TVDTSalDT';
            // $aColumnShow            = FCNaDCLGetColumnShow($tTableGetColumeShow);
            
            $aDataWhere = array(
                'tSearchPdtAdvTable'    => $tSearchPdtAdvTable,
                'FTXthDocNo'            => $tRSDocNo,
                'FTXthDocKey'           => 'TVDTSalHD',
                'nPage'                 => $nRSPageCurrent,
                'nRow'                  => 90000,
                'FTSessionID'           => $this->session->userdata('tSesSessionID'),
            );

            // Calcurate Document DT Temp Array Parameter
            $aCalcDTParams = [
                'tDataDocEvnCall' => '1',
                'tDataVatInOrEx' => $tRSVATInOrEx,
                'tDataDocNo' => $tRSDocNo,
                'tDataDocKey' => 'TVDTSalHD',
                'tDataSeqNo' => ''
            ];
            // FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aDataDocDTTemp     = $this->mReturnSale->FSaMRSGetDocDTTempListPage($aDataWhere);
            $aDataDocDTTempSum  = $this->mReturnSale->FSaMRSSumDocDTTemp($aDataWhere);
            $aDataView = array(
                'nOptDecimalShow'   => $nOptDecimalShow,
                'tRSStaApv'         => $tRSStaApv,
                'tRSStaDoc'         => $tRSStaDoc,
                'tRSPdtCode'        => $tRSPdtCode,
                'tRSPunCode'        => $tRSPunCode,
                'nPage'             => $nRSPageCurrent,
                'aColumnShow'       => array(),
                'aDataDocDTTemp'    => $aDataDocDTTemp,
                'aDataDocDTTempSum' => $aDataDocDTTempSum,
            );

            $tRSPdtAdvTableHtml = $this->load->view('document/returnsale/wReturnSalePdtAdvTableData', $aDataView, true);

            // Call Footer Document
            $aEndOfBillParams = array(
                'tSplVatType'   => $tRSVATInOrEx,
                'tDocNo'        => $tRSDocNo,
                'tDocKey'       => 'TVDTSalHD',
                'nLngID'        => FCNaHGetLangEdit(),
                'tSesSessionID' => $this->session->userdata('tSesSessionID'),
                'tBchCode'      => $this->input->post('tSelectBCH')
            );

            //คำนวณส่วนลดใหม่อีกครั้ง ถ้าหากมีส่วนลดท้ายบิล supawat 03-04-2020       
            $aRSEndOfBill['aEndOfBillVat']  = FCNaDOCEndOfBillCalVat($aEndOfBillParams);
            $aRSEndOfBill['aEndOfBillCal']  = FCNaDOCEndOfBillCal($aEndOfBillParams);
            $aRSEndOfBill['tTextBath']      = FCNtNumberToTextBaht(@$aRSEndOfBill['aEndOfBillCal']['cCalFCXphGrand']);

            $aPackDataCalCulate = array(
                'tDocNo'        => $tRSDocNo,
                'tBchCode'      => $this->input->post('tSelectBCH'),
                'nB4Dis'        => $aRSEndOfBill['aEndOfBillCal']['cSumFCXtdNet'],
                'tSplVatType'   => $tRSVATInOrEx
            );


            $aReturnData = array(
                'tRSPdtAdvTableHtml' => $tRSPdtAdvTableHtml,
                'aRSEndOfBill' => $aRSEndOfBill,
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

  


    // Function: Add สินค้า ลง Document DT Temp
    // Parameters: Document Type
    // Creator: 02/07/2019 wasin(Yoshi AKA: Mr.JW)
    // LastUpdate: -
    // Return: Object Status Add Pdt To Doc DT Temp
    // ReturnType: Object
    public function FSoCRSAddPdtIntoDocDTTemp() {
        try {
            $tRSUserLevel       = $this->session->userdata('tSesUsrLevel');
            $tRSDocNo           = $this->input->post('tRSDocNo');
            $tRSVATInOrEx       = $this->input->post('tRSVATInOrEx');
            $tRSBchCode         = $this->input->post('tSelectBCH');
            $tRSOptionAddPdt    = $this->input->post('tRSOptionAddPdt');
            $tRSPdtData         = $this->input->post('tRSPdtData');
            $aRSPdtData         = json_decode($tRSPdtData);
            $tRSPplCodeBch      = $this->input->post('tRSPplCodeBch');//กลุ่มราคาตามสาขา
            $tRSPplCodeCst      = $this->input->post('tRSPplCodeCst');//กลุ่มราคาตามลูกค้า

            $aDataWhere = array(
                'FTBchCode' => $tRSBchCode,
                'FTXthDocNo' => $tRSDocNo,
                'FTXthDocKey' => 'TVDTSalHD',
            );

            $this->db->trans_begin();

            // $nRSMaxSeqNo    = $this->mReturnSale->FSaMRSGetMaxSeqDocDTTemp($aDataWhere);
            // $nRSMaxSeqNo   += 1;

            // ทำทีรายการ ตามรายการสินค้าที่เพิ่มเข้ามา
            for ($nI = 0; $nI < FCNnHSizeOf($aRSPdtData); $nI++) {
                $tRSPdtCode = $aRSPdtData[$nI]->pnPdtCode;
                $tRSBarCode = $aRSPdtData[$nI]->ptBarCode;
                $tRSPunCode = $aRSPdtData[$nI]->ptPunCode;
                $aDataGetprice = array(
                    'tRSPplCodeCst' => $tRSPplCodeCst,
                    'tRSPplCodeBch' => $tRSPplCodeCst,
                    'tRSPdtCode'    => $tRSPdtCode,
                    'tRSBarCode'    => $tRSBarCode,
                    'tRSPunCode'    => $tRSPunCode
                );
                // $cRSPrice = $this->mReturnSale->FScMRSGetPricePdt4CstOrPdtBYPplCode($aDataGetprice);
                $cRSPrice       = $aRSPdtData[$nI]->packData->PriceRet;
                // $nRSMaxSeqNo = $this->mReturnSale->FSaMRSGetMaxSeqDocDTTemp($aDataWhere);
                $aDataPdtParams = array(
                    'tDocNo'            => $tRSDocNo,
                    'tBchCode'          => $tRSBchCode,
                    'tPdtCode'          => $tRSPdtCode,
                    'tBarCode'          => $tRSBarCode,
                    'tPunCode'          => $tRSPunCode,
                    'cPrice'            => str_replace(",","",$cRSPrice),
                    'nMaxSeqNo'         => $this->input->post('tSeqNo'),
                    'nLngID'            => $this->session->userdata("tLangID"),
                    // 'tSessionID'        => $this->session->userdata('tSesSessionID'),
                    'tSessionID'        => $this->input->post('ohdSesSessionID'),
                    'tDocKey'           => 'TVDTSalHD',
                    'tRSOptionAddPdt'   => $tRSOptionAddPdt,
                    'tRSUsrCode'        => $this->input->post('ohdSOUsrCode'),
                );
                // Data Master Pdt ข้อมูลรายการสินค้าที่เพิ่มเข้ามา
                $aDataPdtMaster = $this->mReturnSale->FSaMRSGetDataPdt($aDataPdtParams);
                // $aDataPdtMaster = array();
                // นำรายการสินค้าเข้า DT Temp
                $nStaInsPdtToTmp = $this->mReturnSale->FSaMRSInsertPDTToTemp($aDataPdtMaster, $aDataPdtParams);
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
                    'tDataVatInOrEx'    => $tRSVATInOrEx,
                    'tDataDocNo'        => $tRSDocNo,
                    'tDataDocKey'       => 'TVDTSalHD',
                    'tDataSeqNo'        => ''
                ];
                // $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);
                $tStaCalcuRate = TRUE;
                if ($tStaCalcuRate === TRUE) {
                    // Prorate HD
                    // FCNaHCalculateProrate('TVDTSalHD', $tRSDocNo);
                    // FCNbHCallCalcDocDTTemp($aCalcDTParams);

                    //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
                    /*****************************************************************/
                    /**/    $this->FSxCalculateHDDisAgain($tRSDocNo,$tRSBchCode);  /**/
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
    public function FSoCRSEditPdtIntoDocDTTemp() {
        try {
            // $bStaSession    =   $this->session->userdata('bSesLogIn');
            // if(isset($bStaSession) && $bStaSession === TRUE){
            //     //ยังมี Session อยู่
            // }else{
            //     echo 'expire';
            //     exit;
            // }

            $tRSBchCode         = $this->input->post('tRSBchCode');
            $tRSDocNo           = $this->input->post('tRSDocNo');
            // $tRSVATInOrEx = $this->input->post('tRSVATInOrEx');
            $nRSSeqNo           = $this->input->post('nRSSeqNo');
            // $tRSFieldName = $this->input->post('tRSFieldName');
            // $tRSValue = $this->input->post('tRSValue');
            // $nRSIsDelDTDis = $this->input->post('nRSIsDelDTDis');
            $tRSSessionID       = $this->input->post('ohdSesSessionID');

            $nStaDelDis         = $this->input->post('nStaDelDis');

            $aDataWhere = array(
                'tRSBchCode'    => $tRSBchCode,
                'tRSDocNo'      => $tRSDocNo,
                'nRSSeqNo'      => $nRSSeqNo,
                'tRSSessionID'  => $this->input->post('ohdSesSessionID'),
                'tDocKey'       => 'TVDTSalHD',
            );
            $aDataUpdateDT = array(
                'FCXtdQty'          => $this->input->post('nQty'),
                'FCXtdSetPrice'     => $this->input->post('cPrice'),
                'FCXtdNet'          => $this->input->post('cNet')
            );

            $this->db->trans_begin();
            $this->mReturnSale->FSaMRSUpdateInlineDTTemp($aDataUpdateDT, $aDataWhere);
            if($nStaDelDis == 1){
                // ยืนยันการลบ DTDis ส่วนลดรายการนี้
                $this->mReturnSaleDisChgModal->FSaMRSDeleteDTDisTemp($aDataWhere);
                $this->mReturnSaleDisChgModal->FSaMRSClearDisChgTxtDTTemp($aDataWhere);
            }

            //ให้มันคำนวณส่วนลดท้ายบิลใหม่อีกครั้ง CR:Supawat
            /*****************************************************************/
            /**/    $this->FSxCalculateHDDisAgain($tRSDocNo,$tRSBchCode);  /**/
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
                // FCNaHCalculateProrate('TVDTSalHD', $tRSDocNo);


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
    public function FSvCRSRemovePdtInDTTmp() {
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

            $aStaDelPdtDocTemp = $this->mReturnSale->FSnMRSDelPdtInDTTmp($aDataWhere);

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
                /**/    $tRSDocNo   = $this->input->post('tDocNo');            /**/ 
                /**/    $tRSBchCode = $this->input->post('tBchCode');          /**/ 
                /**/    $this->FSxCalculateHDDisAgain($tRSDocNo,$tRSBchCode);  /**/
                /*****************************************************************/

                // Prorate HD
                // FCNaHCalculateProrate('TVDTSalHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TVDTSalHD',
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
    public function FSvCRSRemovePdtInDTTmpMulti() {
        try {
            $this->db->trans_begin();
            $aDataWhere = array(
                'tBchCode' => $this->input->post('ptRSBchCode'),
                'tDocNo' => $this->input->post('ptRSDocNo'),
                'tVatInOrEx' => $this->input->post('ptRSVatInOrEx'),
                'aDataPdtCode' => $this->input->post('paDataPdtCode'),
                // 'aDataPunCode' => $this->input->post('paDataPunCode'),
                'aDataSeqNo' => $this->input->post('paDataSeqNo')
            );

            $aStaDelPdtDocTemp = $this->mReturnSale->FSnMRSDelMultiPdtInDTTmp($aDataWhere);

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
                /**/    $tRSDocNo   = $this->input->post('ptRSDocNo');            /**/ 
                /**/    $tRSBchCode = $this->input->post('ptRSBchCode');          /**/ 
                /**/    $this->FSxCalculateHDDisAgain($tRSDocNo,$tRSBchCode);  /**/
                /*****************************************************************/
                
                // Prorate HD
                FCNaHCalculateProrate('TVDTSalHD', $aDataWhere['tDocNo']);
                $aCalcDTParams = [
                    'tDataDocEvnCall' => '',
                    'tDataVatInOrEx' => $aDataWhere['tVatInOrEx'],
                    'tDataDocNo' => $aDataWhere['tDocNo'],
                    'tDataDocKey' => 'TVDTSalHD',
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
    public function FSoCRSChkHavePdtForDocDTTemp() {
        try {
            $tRSDocNo = $this->input->post("ptRSDocNo");
            $tRSSessionID = $this->input->post('tRSSesSessionID');
            $aDataWhere = array(
                'FTXthDocNo' => $tRSDocNo,
                'FTXthDocKey' => 'TVDTSalHD',
                'FTSessionID' => $tRSSessionID
            );
            $nCountPdtInDocDTTemp = $this->mReturnSale->FSnMRSChkPdtInDocDTTemp($aDataWhere);
            if ($nCountPdtInDocDTTemp > 0) {
                $aReturnData = array(
                    'nStaReturn' => '1',
                    'tStaMessg' => 'Found Data In Doc DT.'
                );
            } else {
                $aReturnData = array(
                    'nStaReturn' => '800',
                    'tStaMessg' => language('document/returnsale/returnsale', 'tRSPleaseSeletedPDTIntoTable')
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
    private function FSaCRSCalDTTempForHD($paParams) {
        $aCalDTTemp = $this->mReturnSale->FSaMRSCalInDTTemp($paParams);
        if (isset($aCalDTTemp) && !empty($aCalDTTemp)) {
            $aCalDTTempItems = $aCalDTTemp[0];
            // คำนวณหา ยอดปัดเศษ ให้ HD(FCXphRnd)
            $pCalRoundParams = [
                'FCXshAmtV' => $aCalDTTempItems['FCXshAmtV'],
                'FCXshAmtNV' => $aCalDTTempItems['FCXshAmtNV']
            ];

            // print_r($pCalRoundParams);
            // die();
            $aRound = $this->FSaCRSCalRound($pCalRoundParams);
            // คำนวณหา ยอดรวม ให้ HD(FCXphGrand)
            $nRound = $aRound['nRound'];
            $cGrand = $aRound['cAfRound'];

            // จัดรูปแบบข้อความ จากตัวเลขเป็นข้อความ HD(FTXphGndText)
            $tGndText = FCNtNumberToTextBaht(number_format($cGrand, 2));
            $aCalDTTempItems['FCXshRnd'] = $nRound;
            $aCalDTTempItems['FCXshGrand'] = $cGrand;
            $aCalDTTempItems['FTXshGndText'] = $tGndText;
            return $aCalDTTempItems;
        }
    }

    // Function: หาค่าปัดเศษ HD(FCXphRnd)
    // Parameters: Ajex Event Add Document
    // Creator: 04/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Array ค่าปักเศษ
    // ReturnType: Array
    private function FSaCRSCalRound($paParams) {
        $tOptionRound = '1';  // ปัดขึ้น
        $cAmtV = $paParams['FCXshAmtV'];
        $cAmtNV = $paParams['FCXshAmtNV'];
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
    public function FSoCRSAddEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tRSAutoGenCode = (isset($aDataDocument['ocbRSStaAutoGenCode'])) ? 1 : 0;
            $tRSDocNo = (isset($aDataDocument['oetRSDocNo'])) ? $aDataDocument['oetRSDocNo'] : '';
            $tRSDocDate = $aDataDocument['oetRSDocDate'] . " " . $aDataDocument['oetRSDocTime'];
            $tRSStaDocAct = (isset($aDataDocument['ocbRSFrmInfoOthStaDocAct'])) ? 1 : 0;
            // $tRSVATInOrEx = $aDataDocument['ocmRSFrmSplInfoVatInOrEx'];
            $tRSSessionID = $this->input->post('ohdSesSessionID');

            // Get Data Comp.
            $nLangEdit = $this->session->userdata("tLangID");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tARSReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tARSReq, $tMethodReq, $aDataWhereComp);
      
            // $tRSVATInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];//ภาษีขายปลีก ดูตามบริษัท
            $tRSVATInOrEx = $this->input->post('ocmRSFrmSplInfoVatInOrEx');
//--------------------------------------------------------------------
            $aResProrat = FCNaHCalculateProrate('TVDTSalHD',$tRSDocNo);
            $aCalcDTParams = [
                'tBchCode'          => $aDataDocument['oetRSFrmBchCode'],
                'tDataDocEvnCall'   => '',
                'tDataVatInOrEx'    => $tRSVATInOrEx,
                'tDataDocNo'        => $tRSDocNo,
                'tDataDocKey'       => 'TVDTSalHD',
                'tDataSeqNo'        => ''
            ];
            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
//-----------------------------------------------------------------------------

            // Prorate HD
            FCNaHCalculateProrate('TVDTSalHD', $tRSDocNo);
                        
            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tRSVATInOrEx,
                'tDataDocNo'        => $tRSDocNo,
                'tDataDocKey'       => 'TVDTSalHD',
                'tDataSeqNo'        => ''
            ];
             $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);


            $aCalDTTempParams = [
                'tDocNo' => $tRSDocNo,
                'tBchCode' => $aDataDocument['oetRSFrmBchCode'],
                'tSessionID' => $tRSSessionID,
                'tDocKey' => 'TVDTSalHD',
                'cSumFCXtdVat' => $aDataDocument['ohdSumFCXtdVat']
            ];

            $this->mReturnSale->FSaMRSCalVatLastDT($aCalDTTempParams);

            $aCalDTTempForHD = $this->FSaCRSCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mReturnSale->FSaMRSCalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TVDTSalHD',
                'tTableHDDis' => 'TVDTSalHDDis',
                'tTableHDCst' => 'TVDTSalHDCst',
                'tTableDT' => 'TVDTSalDT',
                'tTableDTDis' => 'TVDTSalDTDis',
                'tTableStaGen' => 1,
                // 'tTableStaGen' => ($aDataDocument['ocmRSFrmSplInfoPaymentType'] == 1) ? 4 : 5,
            );

    
            // Array Data Where Insert
            $aDataWhere = array(
                'FTBchCode' => $aDataDocument['oetRSFrmBchCode'],
                'FTXshDocNo' => $tRSDocNo,
                'FTWahCode' => $aDataDocument['oetRSFrmWahCode'],
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FDCreateOn' => date('Y-m-d H:i:s'),
                'FTCreateBy' => $this->input->post('ohdRSUsrCode'),
                'FTLastUpdBy' => $this->input->post('ohdRSUsrCode'),
                'FTSessionID' => $this->input->post('ohdSesSessionID'),
                'FTXthVATInOrEx' => $tRSVATInOrEx
            );

            // Array Data HD Master
            $aDataMaster = array(
                'FTBchCode' => $aDataDocument['oetRSFrmBchCode'],
                'FTShpCode' => $aDataDocument['oetRSFrmShpCode'],
                'FNXshDocType' => 9 ,
                'FDXshDocDate' =>  (!empty($aDataDocument['oetRSDocDate'])) ? date('Y-m-d', strtotime($aDataDocument['oetRSDocDate'])).' '.$aDataDocument['oetRSDocTime'] : NULL,
                'FTXshCshOrCrd' => '1',
                'FTXshVATInOrEx' => $aDataDocument['ocmRSFrmSplInfoVatInOrEx'],
                'FTDptCode' => '',
                'FTWahCode' => $aDataDocument['oetRSFrmWahCode'],
                'FTPosCode' => $aDataDocument['oetRSFrmPosCode'],
                'FTShfCode' => '',
                'FNSdtSeqNo' => 1,
                'FTUsrCode' => $aDataDocument['ohdRSUsrCode'],
                'FTSpnCode' => $aDataDocument['ohdRSUsrCode'],
                'FTCstCode' => $aDataDocument['oetRSFrmCstCode'],
                'FTXshDocVatFull' => '',
                'FTXshRefExt' => '',
                'FDXshRefExtDate' => (!empty($aDataDocument['oetRSRefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetRSRefExtDocDate'])) : NULL,
                'FTXshRefInt' => $aDataDocument['oetRSRefDocNo'],
                'FDXshRefIntDate' => (!empty($aDataDocument['oetRSRefDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetRSRefDocDate'])) : NULL,
                'FTXshRefAE' => '',
                'FNXshDocPrint' => 1,
                'FTRteCode' => $aDataDocument['ohdRSCmpRteCode'],
                'FCXshRteFac' => $aDataDocument['ohdRSRteFac'],

                'FCXshTotal' => $aCalDTTempForHD['FCXshTotal'],
                'FCXshTotalNV' => $aCalDTTempForHD['FCXshTotalNV'],
                'FCXshTotalNoDis' => $aCalDTTempForHD['FCXshTotalNoDis'],
                'FCXshTotalB4DisChgV' => $aCalDTTempForHD['FCXshTotalB4DisChgV'],
                'FCXshTotalB4DisChgNV' => $aCalDTTempForHD['FCXshTotalB4DisChgNV'],
                'FTXshDisChgTxt' => isset($aCalInHDDisTemp['FTXshDisChgTxt']) ? $aCalInHDDisTemp['FTXshDisChgTxt'] : '',
                'FCXshDis' => isset($aCalInHDDisTemp['FCXshDis']) ? $aCalInHDDisTemp['FCXshDis'] : NULL,
                'FCXshChg' => isset($aCalInHDDisTemp['FCXshChg']) ? $aCalInHDDisTemp['FCXshChg'] : NULL,
                'FCXshTotalAfDisChgV' => $aCalDTTempForHD['FCXshTotalAfDisChgV'],
                'FCXshTotalAfDisChgNV' => $aCalDTTempForHD['FCXshTotalAfDisChgNV'],
                'FCXshAmtV' => $aCalDTTempForHD['FCXshAmtV'],
                'FCXshAmtNV' => $aCalDTTempForHD['FCXshAmtNV'],
                'FCXshVat' => $aCalDTTempForHD['FCXshVat'],
                'FCXshVatable' => $aCalDTTempForHD['FCXshVatable'],
                'FTXshWpCode' => $aCalDTTempForHD['FTXshWpCode'],
                'FCXshWpTax' => $aCalDTTempForHD['FCXshWpTax'],
                'FCXshGrand' => $aCalDTTempForHD['FCXshGrand'],
                'FCXshRnd' => $aCalDTTempForHD['FCXshRnd'],
                'FTXshGndText' => $aCalDTTempForHD['FTXshGndText'],
                'FTXshRmk' => $aDataDocument['otaRSFrmInfoOthRmk'],
                'FTXshStaRefund' => $aDataDocument['ohdRSStaRefund'],
                'FTXshStaDoc' => $aDataDocument['ohdRSStaDoc'],
                'FTXshStaApv' => !empty($aDataDocument['ohdRSStaApv']) ? $aDataDocument['ohdRSStaApv'] : NULL,
                'FCXshPaid' => $aCalDTTempForHD['FCXshGrand'],
                'FCXshLeft' => NULL,
                'FTXshStaRefund' => NULL,
                'FTXshStaDoc' => 1,
                'FTXshStaApv' => '',
                'FTXshStaPrcStk' => '3',
                'FTXshStaPaid' => 3,
                'FNXshStaDocAct' => $tRSStaDocAct,
                'FNXshStaRef' => $aDataDocument['ocmRSFrmInfoOthRef'],
                'FTRsnCode' => $aDataDocument['oetRSRsnCode'],
                'FTXshAppVer' => '5.0',
                'FDLastUpdOn' => date('Y-m-d H:i:s'),
                'FTLastUpdBy' => $aDataDocument['ohdRSUsrCode'],
            );

        
            $aDataGetRefDocHD = array(
                'tXshBchCode' => $aDataDocument['oetRSFrmBchCode'],
                'tXshRefInt' => $aDataDocument['oetRSRefDocNo']
            );
           $aDataRefDocHD = $this->mReturnSale->FSaMRSGetDataRefDocHD($aDataGetRefDocHD);
           if($aDataRefDocHD['tCode']==1){
                $aDataMaster['FTXshVATInOrEx'] = $aDataRefDocHD['aItems']['FTXshVATInOrEx'];
                $aDataMaster['FTPosCode'] = $aDataRefDocHD['aItems']['FTPosCode'];
                $aDataMaster['FTShpCode'] = $aDataRefDocHD['aItems']['FTShpCode'];
                $aDataMaster['FTBchCode'] = $aDataRefDocHD['aItems']['FTBchCode'];
                // $aDataMaster['FTShfCode'] = $aDataRefDocHD['aItems']['FTShfCode'];
                $aDataMaster['FNSdtSeqNo'] = $aDataRefDocHD['aItems']['FNSdtSeqNo'];
                $aDataMaster['FTCstCode'] = $aDataRefDocHD['aItems']['FTCstCode'];
                $aDataMaster['FTXshDocVatFull'] = $aDataRefDocHD['aItems']['FTXshDocVatFull'];
                $aDataMaster['FTXshRefExt'] = $aDataRefDocHD['aItems']['FTXshRefExt'];
                $aDataMaster['FDXshRefExtDate'] = $aDataRefDocHD['aItems']['FDXshRefExtDate'];
                $aDataMaster['FTRteCode'] = $aDataRefDocHD['aItems']['FTRteCode'];
                $aDataMaster['FCXshRteFac'] = $aDataRefDocHD['aItems']['FCXshRteFac'];
           }

          $aDataRefDocHDCst = $this->mReturnSale->FSaMRSGetDataRefDocHDCst($aDataGetRefDocHD);
          if($aDataRefDocHDCst['tCode']==1){
            //array Data Customer 
            $aDataCustomer = array(
                'FTXshCardID' => $aDataRefDocHDCst['aItems']['FTXshCardID'],
                'FTXshCstName' =>  $aDataRefDocHDCst['aItems']['FTXshCstName'],
                'FTXshCstTel' => $aDataRefDocHDCst['aItems']['FTXshCstTel'],
                'FTXshCardNo' =>  $aDataRefDocHDCst['aItems']['FTXshCardNo'],
                'FNXshCrTerm' =>  $aDataRefDocHDCst['aItems']['FNXshCrTerm'],
                'FDXshDueDate' =>  $aDataRefDocHDCst['aItems']['FDXshDueDate'],
                'FDXshBillDue' =>  $aDataRefDocHDCst['aItems']['FDXshBillDue'],
                'FTXshCtrName' =>  $aDataRefDocHDCst['aItems']['FTXshCtrName'],
                'FDXshTnfDate' =>  $aDataRefDocHDCst['aItems']['FDXshTnfDate'],
                'FTXshRefTnfID' =>  $aDataRefDocHDCst['aItems']['FTXshRefTnfID'],
                'FNXshAddrShip' =>  $aDataRefDocHDCst['aItems']['FNXshAddrShip'],
                'FNXshAddrTax' => $aDataRefDocHDCst['aItems']['FNXshAddrTax'],
              );
            }else{
            //array Data Customer 
            $aDataCustomer = array(
                'FTXshCardID' => '',
                'FTXshCstName' => $aDataDocument['oetRSFrmCstName'],
                'FTXshCstTel' => '',
                'FTXshCardNo' => '',
                'FNXshCrTerm' => '',
                'FDXshDueDate' => NULL,
                'FDXshBillDue' => NULL,
                'FTXshCtrName' => '',
                'FDXshTnfDate' => NULL,
                'FTXshRefTnfID' => '',
                'FNXshAddrShip' => NULL,
                'FNXshAddrTax' =>NULL
              );
            }

            $aDataSalRC=array(
                'FNXrcSeqNo' => 1,
                'FTRcvCode' => $aDataDocument['oetRSRcvCode'],
                'FTRcvName' => $aDataDocument['oetRSRcvName'],
                'FDXrcRefDate' => date("Y-m-d H:i:s") ,
                'FTRteCode' => $aDataDocument['ohdRSCmpRteCode'],
                'FCXrcRteFac' => (empty($aDataDocument['ohdRSRteFac']) ? 0 : $aDataDocument['ohdRSRteFac']),
                'FCXrcFrmLeftAmt' => 0,
                'FCXrcUsrPayAmt' => $aCalDTTempForHD['FCXshGrand'],
                'FCXrcDep' => 0 ,
                'FCXrcNet' => $aCalDTTempForHD['FCXshGrand'],
                'FCXrcChg' => 0,
            );

            $this->db->trans_begin();

            // Check Auto GenCode Document
            if ($tRSAutoGenCode == '1') {
                $aStoreParam = array(
                    "tTblName"    => 'TVDTSalHD',                           
                    "tDocType"    => '9',                                          
                    "tBchCode"    => $aDataDocument['oetRSFrmBchCode'],                                 
                    "tShpCode"    => $aDataDocument['oetRSFrmShpCode'],                               
                    "tPosCode"    => $aDataDocument['oetRSFrmPosCode'],                     
                    "dDocDate"    => date("Y-m-d H:i:s")       
                );
                $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                $aDataWhere['FTXshDocNo']   = $aAutogen[0]["FTXxhDocNo"];
            } else {
                $aDataWhere['FTXshDocNo'] = $tRSDocNo;
            }

            // Add Update Document HD
            $this->mReturnSale->FSxMRSAddUpdateHD($aDataMaster, $aDataWhere);

            if(!empty($aDataCustomer['FTXshCstName'])){
            // // Add Update HD Cst
            $this->mReturnSale->FSxMRSAddUpdateHDCst($aDataCustomer,$aDataWhere);
            }

            // // Update Doc No Into Doc Temp
            $this->mReturnSale->FSxMRSAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // // Move Doc HD Dis Temp To HDDis
            $this->mReturnSale->FSaMRSMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // // Move Doc DTTemp To DT
            $this->mReturnSale->FSaMRSMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // // Move Doc DTTemp To DTVD
            $this->mReturnSale->FSaMRSMoveDtTmpToDtVD($aDataWhere, $aTableAddUpdate);

            // // Move Doc DTDisTemp To DTTemp
            $this->mReturnSale->FSaMRSMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);

            // // Add Update RC
            $this->mReturnSale->FSxMRSAddUpdateRC($aDataSalRC,$aDataWhere);

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
                    'tCodeReturn' => $aDataWhere['FTXshDocNo'],
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
    public function FSoCRSEditEventDoc() {
        try {
            $aDataDocument = $this->input->post();
            $tRSAutoGenCode = (isset($aDataDocument['ocbRSStaAutoGenCode'])) ? 1 : 0;
            $tRSDocNo = (isset($aDataDocument['oetRSDocNo'])) ? $aDataDocument['oetRSDocNo'] : '';
            $tRSDocDate = $aDataDocument['oetRSDocDate'] . " " . $aDataDocument['oetRSDocTime'];
            $tRSStaDocAct = (isset($aDataDocument['ocbRSFrmInfoOthStaDocAct'])) ? 1 : 0;
            $tRSVATInOrEx = $aDataDocument['ocmRSFrmSplInfoVatInOrEx'];
            $tRSSessionID = $this->input->post('ohdSesSessionID');

            // Get Data Comp.
            $nLangEdit = $this->session->userdata("tLangID");
            $aDataWhereComp = array('FNLngID' => $nLangEdit);
            $tARSReq = "";
            $tMethodReq = "GET";
            $aCompData = $this->mCompany->FSaMCMPList($tARSReq, $tMethodReq, $aDataWhereComp);
            // $tRSVATInOrEx = $aCompData['raItems']['rtCmpRetInOrEx'];//ภาษีขายปลีก ดูตามบริษัท
            //--------------------------------------------------------------------
            $aResProrat = FCNaHCalculateProrate('TVDTSalHD',$tRSDocNo);
            $aCalcDTParams = [
                'tBchCode'          => $aDataDocument['oetRSFrmBchCode'],
                'tDataDocEvnCall'   => '',
                'tDataVatInOrEx'    => $tRSVATInOrEx,
                'tDataDocNo'        => $tRSDocNo,
                'tDataDocKey'       => 'TVDTSalHD',
                'tDataSeqNo'        => ''
            ];
            $aStaCalcDTTemp = FCNbHCallCalcDocDTTemp($aCalcDTParams);
            //-----------------------------------------------------------------------------
            
            // Prorate HD
            FCNaHCalculateProrate('TVDTSalHD', $tRSDocNo);

            $aCalcDTParams = [
                'tDataDocEvnCall'   => '1',
                'tDataVatInOrEx'    => $tRSVATInOrEx,
                'tDataDocNo'        => $tRSDocNo,
                'tDataDocKey'       => 'TVDTSalHD',
                'tDataSeqNo'        => ''
            ];
             $tStaCalcuRate = FCNbHCallCalcDocDTTemp($aCalcDTParams);

            $aCalDTTempParams = [
                'tDocNo' => $tRSDocNo,
                'tBchCode' => $aDataDocument['oetRSFrmBchCode'],
                'tSessionID' => $tRSSessionID,
                'tDocKey' => 'TVDTSalHD',
                'cSumFCXtdVat' => $aDataDocument['ohdSumFCXtdVat']
            ];
            $this->mReturnSale->FSaMRSCalVatLastDT($aCalDTTempParams);
            

            $aCalDTTempForHD = $this->FSaCRSCalDTTempForHD($aCalDTTempParams);
            $aCalInHDDisTemp = $this->mReturnSale->FSaMRSCalInHDDisTemp($aCalDTTempParams);

            // Array Data Table Document
            $aTableAddUpdate = array(
                'tTableHD' => 'TVDTSalHD',
                'tTableHDDis' => 'TVDTSalHDDis',
                'tTableHDCst' => 'TVDTSalHDCst',
                'tTableDT' => 'TVDTSalDT',
                'tTableDTDis' => 'TVDTSalDTDis',
                'tTableStaGen' => 1,
            );

 
           // Array Data Where Insert
           $aDataWhere = array(
            'FTBchCode' => $aDataDocument['oetRSFrmBchCode'],
            'FTXshDocNo' => $tRSDocNo,
            'FTWahCode' => $aDataDocument['oetRSFrmWahCode'],
            'FDLastUpdOn' => date('Y-m-d H:i:s'),
            'FDCreateOn' => date('Y-m-d H:i:s'),
            'FTCreateBy' => $this->input->post('ohdRSUsrCode'),
            'FTLastUpdBy' => $this->input->post('ohdRSUsrCode'),
            'FTSessionID' => $this->input->post('ohdSesSessionID'),
            'FTXthVATInOrEx' => $tRSVATInOrEx
        );

        // Array Data HD Master
        $aDataMaster = array(
            'FTBchCode' => $aDataDocument['oetRSFrmBchCode'],
            'FTShpCode' => $aDataDocument['oetRSFrmShpCode'],
            'FNXshDocType' => 9 ,
            'FDXshDocDate' =>  (!empty($aDataDocument['oetRSDocDate'])) ? date('Y-m-d', strtotime($aDataDocument['oetRSDocDate'])).' '.$aDataDocument['oetRSDocTime'] : NULL,
            'FTXshCshOrCrd' => '1',
            'FTXshVATInOrEx' => $aDataDocument['ocmRSFrmSplInfoVatInOrEx'],
            'FTDptCode' => '',
            'FTWahCode' => $aDataDocument['oetRSFrmWahCode'],
            'FTPosCode' => $aDataDocument['oetRSFrmPosCode'],
            'FTShfCode' => '',
            'FNSdtSeqNo' => 1,
            'FTUsrCode' => $aDataDocument['ohdRSUsrCode'],
            'FTSpnCode' => $aDataDocument['ohdRSUsrCode'],
            'FTCstCode' => $aDataDocument['oetRSFrmCstCode'],
            'FTXshDocVatFull' => '',
            'FTXshRefExt' => '',
            'FDXshRefExtDate' => (!empty($aDataDocument['oetRSRefExtDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetRSRefExtDocDate'])) : NULL,
            'FTXshRefInt' => $aDataDocument['oetRSRefDocNo'],
            'FDXshRefIntDate' => (!empty($aDataDocument['oetRSRefDocDate'])) ? date('Y-m-d H:i:s', strtotime($aDataDocument['oetRSRefDocDate'])) : NULL,
            'FTXshRefAE' => '',
            'FNXshDocPrint' => 1,
            'FTRteCode' => $aDataDocument['ohdRSCmpRteCode'],
            'FCXshRteFac' => $aDataDocument['ohdRSRteFac'],

            'FCXshTotal' => $aCalDTTempForHD['FCXshTotal'],
            'FCXshTotalNV' => $aCalDTTempForHD['FCXshTotalNV'],
            'FCXshTotalNoDis' => $aCalDTTempForHD['FCXshTotalNoDis'],
            'FCXshTotalB4DisChgV' => $aCalDTTempForHD['FCXshTotalB4DisChgV'],
            'FCXshTotalB4DisChgNV' => $aCalDTTempForHD['FCXshTotalB4DisChgNV'],
            'FTXshDisChgTxt' => isset($aCalInHDDisTemp['FTXshDisChgTxt']) ? $aCalInHDDisTemp['FTXshDisChgTxt'] : '',
            'FCXshDis' => isset($aCalInHDDisTemp['FCXshDis']) ? $aCalInHDDisTemp['FCXshDis'] : NULL,
            'FCXshChg' => isset($aCalInHDDisTemp['FCXshChg']) ? $aCalInHDDisTemp['FCXshChg'] : NULL,
            'FCXshTotalAfDisChgV' => $aCalDTTempForHD['FCXshTotalAfDisChgV'],
            'FCXshTotalAfDisChgNV' => $aCalDTTempForHD['FCXshTotalAfDisChgNV'],
            'FCXshAmtV' => $aCalDTTempForHD['FCXshAmtV'],
            'FCXshAmtNV' => $aCalDTTempForHD['FCXshAmtNV'],
            'FCXshVat' => $aCalDTTempForHD['FCXshVat'],
            'FCXshVatable' => $aCalDTTempForHD['FCXshVatable'],
            'FTXshWpCode' => $aCalDTTempForHD['FTXshWpCode'],
            'FCXshWpTax' => $aCalDTTempForHD['FCXshWpTax'],
            'FCXshGrand' => $aCalDTTempForHD['FCXshGrand'],
            'FCXshRnd' => $aCalDTTempForHD['FCXshRnd'],
            'FTXshGndText' => $aCalDTTempForHD['FTXshGndText'],
            'FTXshRmk' => $aDataDocument['otaRSFrmInfoOthRmk'],
            'FTXshStaRefund' => $aDataDocument['ohdRSStaRefund'],
            'FTXshStaDoc' => $aDataDocument['ohdRSStaDoc'],
            'FTXshStaApv' => !empty($aDataDocument['ohdRSStaApv']) ? $aDataDocument['ohdRSStaApv'] : NULL,
            'FCXshPaid' => $aCalDTTempForHD['FCXshGrand'],
            'FCXshLeft' => NULL,
            'FTXshStaRefund' => NULL,
            'FTXshStaDoc' => 1,
            'FTXshStaApv' => '',
            'FTXshStaPrcStk' => '3',
            'FTXshStaPaid' => 3,
            'FNXshStaDocAct' => $tRSStaDocAct,
            'FNXshStaRef' => $aDataDocument['ocmRSFrmInfoOthRef'],
            'FTRsnCode' => $aDataDocument['oetRSRsnCode'],
            'FTXshAppVer' => '5.0',
            'FDLastUpdOn' => date('Y-m-d H:i:s'),
            'FTLastUpdBy' => $aDataDocument['ohdRSUsrCode'],
        );

    
        $aDataGetRefDocHD = array(
            'tXshBchCode' => $aDataDocument['oetRSFrmBchCode'],
            'tXshRefInt' => $aDataDocument['oetRSRefDocNo']
        );
       $aDataRefDocHD = $this->mReturnSale->FSaMRSGetDataRefDocHD($aDataGetRefDocHD);
       if($aDataRefDocHD['tCode']==1){
            $aDataMaster['FTXshVATInOrEx'] = $aDataRefDocHD['aItems']['FTXshVATInOrEx'];
            $aDataMaster['FTPosCode'] = $aDataRefDocHD['aItems']['FTPosCode'];
            $aDataMaster['FTShpCode'] = $aDataRefDocHD['aItems']['FTShpCode'];
            $aDataMaster['FTBchCode'] = $aDataRefDocHD['aItems']['FTBchCode'];
            // $aDataMaster['FTShfCode'] = $aDataRefDocHD['aItems']['FTShfCode'];
            $aDataMaster['FNSdtSeqNo'] = $aDataRefDocHD['aItems']['FNSdtSeqNo'];
            $aDataMaster['FTCstCode'] = $aDataRefDocHD['aItems']['FTCstCode'];
            $aDataMaster['FTXshDocVatFull'] = $aDataRefDocHD['aItems']['FTXshDocVatFull'];
            $aDataMaster['FTXshRefExt'] = $aDataRefDocHD['aItems']['FTXshRefExt'];
            $aDataMaster['FDXshRefExtDate'] = $aDataRefDocHD['aItems']['FDXshRefExtDate'];
            $aDataMaster['FTRteCode'] = $aDataRefDocHD['aItems']['FTRteCode'];
            $aDataMaster['FCXshRteFac'] = $aDataRefDocHD['aItems']['FCXshRteFac'];
       }

      $aDataRefDocHDCst = $this->mReturnSale->FSaMRSGetDataRefDocHDCst($aDataGetRefDocHD);
      if($aDataRefDocHDCst['tCode']==1){
        //array Data Customer 
        $aDataCustomer = array(
            'FTXshCardID' => $aDataRefDocHDCst['aItems']['FTXshCardID'],
            'FTXshCstName' =>  $aDataRefDocHDCst['aItems']['FTXshCstName'],
            'FTXshCstTel' => $aDataRefDocHDCst['aItems']['FTXshCstTel'],
            'FTXshCardNo' =>  $aDataRefDocHDCst['aItems']['FTXshCardNo'],
            'FNXshCrTerm' =>  $aDataRefDocHDCst['aItems']['FNXshCrTerm'],
            'FDXshDueDate' =>  $aDataRefDocHDCst['aItems']['FDXshDueDate'],
            'FDXshBillDue' =>  $aDataRefDocHDCst['aItems']['FDXshBillDue'],
            'FTXshCtrName' =>  $aDataRefDocHDCst['aItems']['FTXshCtrName'],
            'FDXshTnfDate' =>  $aDataRefDocHDCst['aItems']['FDXshTnfDate'],
            'FTXshRefTnfID' =>  $aDataRefDocHDCst['aItems']['FTXshRefTnfID'],
            'FNXshAddrShip' =>  $aDataRefDocHDCst['aItems']['FNXshAddrShip'],
            'FNXshAddrTax' => $aDataRefDocHDCst['aItems']['FNXshAddrTax'],
          );
        }else{
                        //array Data Customer 
        $aDataCustomer = array(
            'FTXshCardID' => '',
            'FTXshCstName' => $aDataDocument['oetRSFrmCstName'],
            'FTXshCstTel' => '',
            'FTXshCardNo' => '',
            'FNXshCrTerm' => '',
            'FDXshDueDate' => NULL,
            'FDXshBillDue' => NULL,
            'FTXshCtrName' => '',
            'FDXshTnfDate' => NULL,
            'FTXshRefTnfID' => '',
            'FNXshAddrShip' => NULL,
            'FNXshAddrTax' =>NULL
          );
        }


        $aDataSalRC=array(
            'FNXrcSeqNo' => 1,
            'FTRcvCode' => $aDataDocument['oetRSRcvCode'],
            'FTRcvName' => $aDataDocument['oetRSRcvName'],
            'FDXrcRefDate' => date("Y-m-d H:i:s") ,
            'FTRteCode' => $aDataDocument['ohdRSCmpRteCode'],
            'FCXrcRteFac' => (empty($aDataDocument['ohdRSRteFac']) ? 0 : $aDataDocument['ohdRSRteFac']),
            'FCXrcFrmLeftAmt' => 0,
            'FCXrcUsrPayAmt' => $aCalDTTempForHD['FCXshGrand'],
            'FCXrcDep' => 0 ,
            'FCXrcNet' => $aCalDTTempForHD['FCXshGrand'],
            'FCXrcChg' => 0,
        );

      
            $this->db->trans_begin();

                // Check Auto GenCode Document
                if ($tRSAutoGenCode == '1') {
                    $aStoreParam = array(
                        "tTblName"    => 'TVDTSalHD',                           
                        "tDocType"    => '9',                                          
                        "tBchCode"    => $aDataDocument['oetRSFrmBchCode'],                                 
                        "tShpCode"    => $aDataDocument['oetRSFrmShpCode'],                               
                        "tPosCode"    => $aDataDocument['oetRSFrmPosCode'],                     
                        "dDocDate"    => date("Y-m-d H:i:s")       
                    );
                    $aAutogen                   = FCNaHAUTGenDocNo($aStoreParam);
                    $aDataWhere['FTXshDocNo']   = $aAutogen[0]["FTXxhDocNo"];
                } else {
                    $aDataWhere['FTXshDocNo'] = $tRSDocNo;
                }
      
            // Add Update Document HD
            $this->mReturnSale->FSxMRSAddUpdateHD($aDataMaster, $aDataWhere);

            if(!empty($aDataCustomer['FTXshCstName'])){
            // // Add Update HD Cst
            $this->mReturnSale->FSxMRSAddUpdateHDCst($aDataCustomer,$aDataWhere);
            }

            // // Update Doc No Into Doc Temp
            $this->mReturnSale->FSxMRSAddUpdateDocNoToTemp($aDataWhere, $aTableAddUpdate);

            // // Move Doc HD Dis Temp To HDDis
            $this->mReturnSale->FSaMRSMoveHdDisTempToHdDis($aDataWhere, $aTableAddUpdate);

            // // Move Doc DTTemp To DT
            $this->mReturnSale->FSaMRSMoveDtTmpToDt($aDataWhere, $aTableAddUpdate);

            // // Move Doc DTTemp To DTVD
            $this->mReturnSale->FSaMRSMoveDtTmpToDtVD($aDataWhere, $aTableAddUpdate);

            // // Move Doc DTDisTemp To DTTemp
            $this->mReturnSale->FSaMRSMoveDtDisTempToDtDis($aDataWhere, $aTableAddUpdate);

            // // Add Update RC
            $this->mReturnSale->FSxMRSAddUpdateRC($aDataSalRC,$aDataWhere);
         
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
                    'tCodeReturn' => $aDataWhere['FTXshDocNo'],
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
    public function FSvCRSCancelDocument() {
        try {
            $tRSDocNo = $this->input->post('ptRSDocNo');
            $aDataUpdate = array(
                'tDocNo' => $tRSDocNo,
            );

            $aStaApv = $this->mReturnSale->FSaMRSCancelDocument($aDataUpdate);
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
    public function FSvCRSApproveDocument() {
        $tRSDocNo = $this->input->post('ptRSDocNo');
        $tRSBchCode = $this->input->post('ptRSBchCode');
        $tRSStaApv = $this->input->post('ptRSStaApv');
        // die();
       $this->db->trans_begin();
        try {

            $aDataUpdate = array(
                'tDocNo'      => $tRSDocNo,
                'tApvCode'    => $this->session->userdata('tSesUsername'),
                'tTableDocHD' => 'TVDTSalHD',
                'tBchCode'    => $tRSBchCode,
                'nStaApv' => 1
            );

            $aStaApv = $this->mReturnSale->FSaMRSApproveDocument($aDataUpdate);
         $this->db->trans_commit();

            // echo json_encode($aReturn);
            // FTXshStaRefund
            $aDataParamGetDataForMQ = array(
                'FTXshDocNo' => $tRSDocNo,
                'FTBchCode' => $tRSBchCode
             ); 
            $aMQDataSalVD =  $this->mReturnSale->FSaMRSGetDataForMQReturnSale($aDataParamGetDataForMQ);
            // $oMQParamSale['aoTVDTSalHD'] = $aoTVDTSalHD;
            $tBchCode =  $aMQDataSalVD['aoTVDTSalHD'][0]['FTBchCode'];
            $tWahCode =  $aMQDataSalVD['aoTVDTSalHD'][0]['FTWahCode'];

            $aDataGetStaPrcStk = array(
                'tBchCode' => $tBchCode,
                'tWahCode' => $tWahCode,
            );
            $aMQDataWahHouse =  $this->mReturnSale->FSaMRSGetDataWahHouse($aDataGetStaPrcStk);

            $tXshRefInt =  $aMQDataSalVD['aoTVDTSalHD'][0]['FTXshRefInt'];

            if($tXshRefInt!=''){
                $this->mReturnSale->FSxMRSUpdateRefIntToHD($tXshRefInt);
            }
            // FTWahStaPrcStk
            $oMQParamSale = [
                "aoTVDTSalHD" => $aMQDataSalVD['aoTVDTSalHD'],
                "aoTVDTSalHDCst" => $aMQDataSalVD['aoTVDTSalHDCst'],
                "aoTVDTSalHDDis" => $aMQDataSalVD['aoTVDTSalHDDis'],
                "aoTVDTSalDT" => $aMQDataSalVD['aoTVDTSalDT'],
                "aoTVDTSalDTDis" => $aMQDataSalVD['aoTVDTSalDTDis'],
                "aoTVDTSalDTVD" => $aMQDataSalVD['aoTVDTSalDTVD'],
                "aoTVDTSalRC" => $aMQDataSalVD['aoTVDTSalRC'],
                "aoTVDTSalHDPatient" => $aMQDataSalVD['aoTVDTSalHDPatient'],
                "ptWahStaPrcStk" => $aMQDataWahHouse['FTWahStaPrcStk']
            ];

            $aMQParams = [
                "queueName" => "UPLOADSALEVD",
                "exchangname" => "",
                "params" => [
                    "ptData" => json_encode($oMQParamSale),
                ]
            ];

            $this->FSxCRSCallRabbitMQ($aMQParams);

            $aReturn = array(
                'nStaEvent'    => '1',
                'tStaMessg'    => 'ok'
            );
            echo json_encode($aReturn);

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
    // Function: Function Searh And Add Pdt In Tabel Temp
    // Parameters: Ajex Event Add Document
    // Creator: 30/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Searh And Add Pdt In Tabel Temp
    // ReturnType: Object
    
    public function FSxCRSCallRabbitMQ ($paParams){
        $tQueueName = (isset($paParams['queueName']))?$paParams['queueName']:'';
        $aParams = (isset($paParams['params']))?$paParams['params']:[];
        $bStaUseConnStr = (isset($paParams['bStaUseConnStr']) && is_bool($paParams['bStaUseConnStr']))?$paParams['bStaUseConnStr']:true;
        $tVhostType = (isset($paParams['tVhostType']) && in_array($paParams['tVhostType'],['W','D']))?$paParams['tVhostType']:'D';
    
        if ($bStaUseConnStr) {
            $aParams['ptConnStr'] = DB_CONNECT;
        }
        $tExchange = EXCHANGE; // This use default exchange
        
        switch($tVhostType){
            case 'W': {
                $oConnection = new AMQPStreamConnection(MQ_CRD_HOST, MQ_CRD_PORT, MQ_CRD_USER, MQ_CRD_PASS, MQ_CRD_VHOST);
                // $aParams['ptData']['ptConnStr'] = DB_CONNECT;
                // $bDurable = true;
                break;
            }
            default : {
                $oConnection = new AMQPStreamConnection(MQ_Sale_HOST, MQ_Sale_PORT, MQ_Sale_USER, MQ_Sale_PASS, MQ_Sale_VHOST);
                // $bDurable = false;
            }
        }
        
        $oChannel = $oConnection->channel();
        $oChannel->queue_declare($tQueueName, false, true, false, false);
        $oMessage = new AMQPMessage(json_encode($aParams));
        $oChannel->basic_publish($oMessage, "", $tQueueName);
        $oChannel->close();
        $oConnection->close();
        return 1;
    }
    // Function: Function Searh And Add Pdt In Tabel Temp
    // Parameters: Ajex Event Add Document
    // Creator: 30/07/2019 wasin(Yoshi)
    // LastUpdate: -
    // Return: Object Status Searh And Add Pdt In Tabel Temp
    // ReturnType: Object
    public function FSoCRSSearchAndAddPdtIntoTbl() {
        try {
            $tRSBchCode = $this->input->post('ptRSBchCode');
            $tRSDocNo = $this->input->post('ptRSDocNo');
            $tRSDataSearchAndAdd = $this->input->post('ptRSDataSearchAndAdd');
            $tRSStaReAddPdt = $this->input->post('ptRSStaReAddPdt');
            $tRSSessionID = $this->session->userdata('tSesSessionID');
            $nLangEdit = $this->session->userdata("tLangID");
            // เช็คข้อมูลในฐานข้อมูล
            $aDataChkINDB = array(
                'FTBchCode' => $tRSBchCode,
                'FTXthDocNo' => $tRSDocNo,
                'FTXthDocKey' => 'TVDTSalHD',
                'FTSessionID' => $tRSSessionID,
                'tRSDataSearchAndAdd' => trim($tRSDataSearchAndAdd),
                'tRSStaReAddPdt' => $tRSStaReAddPdt,
                'nLangEdit' => $nLangEdit
            );

            $aCountDataChkInDTTemp = $this->mReturnSale->FSaCRSCountPdtBarInTablePdtBar($aDataChkINDB);
            $nCountDataChkInDTTemp = isset($aCountDataChkInDTTemp) && !empty($aCountDataChkInDTTemp) ? FCNnHSizeOf($aCountDataChkInDTTemp) : 0;
            if ($nCountDataChkInDTTemp == 1) {
                // สินค้าหรือ BarCode ทีกรอกมี 1 ตัวให้เอาลง หรือ เช็ค สถานะ Appove ได้เลย
            } else if ($nCountDataChkInDTTemp > 1) {
                // มี Bar Code มากกว่า 1 ให้แสดง Modal
            } else {
                // ไม่พบข้อมูลบาร์โค๊ดกับรหัสสินค้าในระบบ 
                $aReturnData = array(
                    'nStaEvent' => 800,
                    'tStaMessg' => language('document/returnsale/returnsale', 'tRSNotFoundPdtCodeAndBarcode')
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
    public function FSoCRSClearDataInDocTemp() {
        try {
            $this->db->trans_begin();

            // Clear Data Product IN Doc Temp
            $aWhereClearTemp = [
                'FTXthDocNo' => $this->input->post('ptRSDocNo'),
                'FTXthDocKey' => 'TVDTSalHD',
                'FTSessionID' => $this->session->userdata('tSesSessionID')
            ];
            $this->mReturnSale->FSxMRSClearDataInDocTemp($aWhereClearTemp);

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
    public function FSoCRSPrintDoc() {
        
    }
    /**
     * Function: //คำนวณส่วนลดท้ายบิลใหม่อีกครั้ง กรณีมีการเพิ่มสินค้า , แก้ไขจำนวน , แก้ไขราคา , ลบสินค้า , ลดรายการ , ลดท้ายบิล 
     * Parameters: Ajax Event Add Document
     * Creator: 27/08/2019 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSxCalculateHDDisAgain($ptDocumentNumber , $ptBCHCode){
        $aPackDataCalCulate = array(
            'tDocNo'        => $ptDocumentNumber,
            'tBchCode'      => $ptBCHCode
        );
        FSaCCNDocumentUpdateHDDisAgain($aPackDataCalCulate);
    }

    /**
     * Function: ค้นหาเอกสารการขาย
     * Parameters: รหัสสาขา / รหัสร้านค้า / รหัสจุดขาย / วันที่เอกสาร / เลขที่เอกสาร / คำค้นหา
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSvCRSFindBillSaleVDDocNo(){

            $tRSFrmBchCode = $this->input->post('tRSFrmBchCode');
            $tRSFrmShpCode = $this->input->post('tRSFrmShpCode');
            $tRSFrmPosCode = $this->input->post('tRSFrmPosCode');
            $tRSRefDocDate = $this->input->post('tRSRefDocDate');
            $tRSRefDocNo   = $this->input->post('tRSRefDocNo');
            $tRSSearchDocument   = $this->input->post('tRSSearchDocument');
            $nLangEdit = $this->session->userdata("tLangID");

            $aDataParamFilter = array(
                'tRSFrmBchCode' => $tRSFrmBchCode,
                'tRSFrmShpCode' => $tRSFrmShpCode,
                'tRSFrmPosCode' => $tRSFrmPosCode,
                'tRSRefDocDate' => $tRSRefDocDate,
                'tRSRefDocNo'   => $tRSRefDocNo,
                'tRSSearchDocument' => $tRSSearchDocument,
                'nLangEdit'     => $nLangEdit
            );

            $aDataBill = $this->mReturnSale->FSaMRSFindBillSaleVDDocNo($aDataParamFilter);
            // echo '<pre>';

            // print_r($aDataBill);
            // echo '</pre>';
            // die();
            $tRSBillHeaderHtml = $this->load->view('document/returnsale/wReturnSaleBillHeader', $aDataBill, true);

            $aDataBill['tRSBillHeaderHtml'] = $tRSBillHeaderHtml;
             echo json_encode($aDataBill);
          

    }


        /**
     * Function: ค้นหาเอกสารการขาย
     * Parameters: รหัสสาขา / รหัสร้านค้า / รหัสจุดขาย / วันที่เอกสาร / เลขที่เอกสาร / คำค้นหา
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSvCRSFindBillSaleVDDetail(){


        $tRSRefDocNo   = $this->input->post('tRSRefDocNo');
        $nLangEdit = $this->session->userdata("tLangID");

        $aDataParamFilter = array(
            'tRSRefDocNo'   => $tRSRefDocNo,
            'nLangEdit'     => $nLangEdit
        );

        $aDataBill = $this->mReturnSale->FSaMRSFindBillSaleVDDetail($aDataParamFilter);

        $tRSBillHeaderHtml = $this->load->view('document/returnsale/wReturnSaleBillDetail', $aDataBill, true);

        echo $tRSBillHeaderHtml;

    }

    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoCRSInsertBillToTemp(){

           $tRSBchCode = $this->input->post('tRSBchCode');
           $tRSRefDocNo = $this->input->post('tRSRefDocNo'); 
           $aRSSelectPdt = implode("','",$this->input->post('aRSSelectPdt'));
           $nLangEdit = $this->session->userdata("tLangID");
            // Clear Data Product IN Doc Temp
            $aParameter = [
            'FTXthDocNo' => $this->input->post('tRSDocNo'),
            'FTXthDocKey' => 'TVDTSalHD',
            'FTSessionID' => $this->session->userdata('tSesSessionID'),
            'tRSBchCode' => $tRSBchCode,
            'tRSRefDocNo' => $tRSRefDocNo,
            'tRSSelectPdt' => $aRSSelectPdt,
            'nLangEdit' => $nLangEdit
            ];

           $aResult = $this->mReturnSale->FSoMRSInsertDTBillToTemp($aParameter);
                      $this->mReturnSale->FSoMRSInsertDTDisBillToTemp($aParameter);
                      $this->mReturnSale->FSoMRSInsertHDDisBillToTemp($aParameter);


                      
           echo json_encode($aResult);

    }

    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSoCRSFindWahouseDefaultByShop(){

           $tRSBchCode = $this->input->post('tRSBchCode');
           $tRSShpCode = $this->input->post('tRSShpCode');


           $aDataParam = array(
               'tRSBchCode' => $tRSBchCode,
               'tRSShpCode' => $tRSShpCode,
           );

          $aResult = $this->mReturnSale->FSaMRSFindWahouseDefaultByShop($aDataParam);

          echo json_encode($aResult);
    }


    /**
     * Function: นำบิลที่เลือกลงตาราง Temp
     * Parameters: รหัสสาขา / เลขที่เอกสาร / รายการสินค้าที่คืน
     * Creator: 26/11/2020 Piya
     * LastUpdate: -
     * Return: Object Status Print Document
     * ReturnType: Object
     */
    public function FSaCRSQtyLimitRetunItem(){

        $tRSBchCode = $this->input->post('tRSBchCode');
        $tRSRefDocNo = $this->input->post('tRSRefDocNo');
        $nRSSeqNo = $this->input->post('nRSSeqNo');
        $nQty = $this->input->post('nQty');

       $aDataParam = array(
           'tXshBchCode' => $tRSBchCode,
           'tXshRefInt' => $tRSRefDocNo,
           'nXsdSeqNo' => $nRSSeqNo,
       );

        $aResult = $this->mReturnSale->FSaMRSGetDataRefDocDT($aDataParam);

        if($aResult['tCode']=='1'){

            if($nQty>$aResult['aItems']['FCXsdQty']){
                $aDataReturn = array(
                    'tCode' => '1',
                    'nQty' => $aResult['aItems']['FCXsdQty'] ,
                );
            }else{
                $aDataReturn = array(
                    'tCode' => '1',
                    'nQty' => $nQty ,
                );
            }

        }else{
            $aDataReturn = array(
                'tCode' => '1',
                'nQty' => $nQty ,
            );
        }
        echo json_encode($aDataReturn);

    }

}



