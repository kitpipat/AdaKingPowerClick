<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptTaxSaleLocker extends MX_Controller {

    /**
     * ภาษา
     * @var array
     */
    public $aText = [];

    /**
     * จำนวนต่อหน้าในรายงาน
     * @var int 
     */
    public $nPerPage = 100;

    /**
     * Page number
     * @var int
     */
    public $nPage = 1;

    /**
     * จำนวนทศนิยม
     * @var int
     */
    public $nOptDecimalShow = 2;

    /**
     * จำนวนข้อมูลใน Temp
     * @var int
     */
    public $nRows = 0;

    /**
     * Computer Name
     * @var string
     */
    public $tCompName;

    /**
     * User Login on Bch
     * @var string
     */
    public $tBchCodeLogin;

    /**
     * Report Code
     * @var string
     */
    public $tRptCode;

    /**
     * Report Group
     * @var string
     */
    public $tRptGroup;

    /**
     * System Language
     * @var int
     */
    public $nLngID;

    /**
     * User Session ID
     * @var string
     */
    public $tUserSessionID;

    /**
     * Report route
     * @var string
     */
    public $tRptRoute;

    /**
     * Report Export Type
     * @var string
     */
    public $tRptExportType;

    /**
     * Filter for Report
     * @var array 
     */
    public $aRptFilter = [];

    /**
     * Company Info
     * @var array
     */
    public $aCompanyInfo = [];

    /**
     * User Login Session
     * @var string 
     */
    public $tUserLoginCode;

    public function __construct() {
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportlocker/mRptTaxSaleLocker');

        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init() {
        
        $this->aText = [
            'tTitleReport' => language('report/report/report', 'tRptTaxSaleLockerTitle'),
            'tDatePrint' => language('report/report/report', 'tRptTaxSaleLockerDatePrint'),
            'tTimePrint' => language('report/report/report', 'tRptTaxSaleLockerTimePrint'),
            // Address Lang
            'tRptAddrBuilding' => language('report/report/report', 'tRptAddrBuilding'),
            'tRptAddrRoad' => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi' => language('report/report/report', 'tRptAddrSoi'),
            'tRptAddrSubDistrict' => language('report/report/report', 'tRptAddrSubDistrict'),
            'tRptAddrDistrict' => language('report/report/report', 'tRptAddrDistrict'),
            'tRptAddrProvince' => language('report/report/report', 'tRptAddrProvince'),
            'tRptAddrTel' => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax' => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrBranch' => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddV2Desc1' => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2' => language('report/report/report', 'tRptAddV2Desc2'),
            'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),
            // Table Label
            'tRptTaxSaleLockerRowNo' => language('report/report/report', 'tRptTaxSaleLockerRowNo'),
            'tRptTaxSaleLockerDocDate' => language('report/report/report', 'tRptTaxSaleLockerDocDate'),
            'tRptTaxSaleLockerDocNo' => language('report/report/report', 'tRptTaxSaleLockerDocNo'),
            'tRptTaxSaleLockerDocRef' => language('report/report/report', 'tRptTaxSaleLockerDocRef'),
            'tRptTaxSaleLockerCustomer' => language('report/report/report', 'tRptTaxSaleLockerCustomer'),
            'tRptTaxSaleLockerCtmTaxNo' => language('report/report/report', 'tRptTaxSaleLockerCtmTaxNo'),
            'tRptTaxSaleLockerMerChant' => language('report/report/report', 'tRptTaxSaleLockerMerChant'),
            'tRptTaxSaleLockerAmt' => language('report/report/report', 'tRptTaxSaleLockerAmt'),
            'tRptTaxSaleLockerAmtV' => language('report/report/report', 'tRptTaxSaleLockerAmtV'),
            'tRptTaxSaleLockerAmtNV' => language('report/report/report', 'tRptTaxSaleLockerAmtNV'),
            'tRptTaxSaleLockerGrandTotal' => language('report/report/report', 'tRptTaxSaleLockerGrandTotal'),
            'tRptTaxSaleLockerPosGrouping' => language('report/report/report', 'tRptTaxSaleLockerPosGrouping'),
            // No Data Report
            'tRptTaxSaleLockerNoData' => language('common/main/main', 'tCMNNotFoundData'),
            'tRptTaxSaleLockerTotalSub' => language('report/report/report', 'tRptTaxSaleLockerTotalSub'),
            'tRptTaxSaleLockerTotalFooter' => language('report/report/report', 'tRptTaxSaleLockerTotalFooter'),
            // Filter Text Label
            'tRptTaxSaleLockerFilterMerChant' => language('report/report/report', 'tRptTaxSaleLockerFilterMerChant'),
            'tRptTaxSaleLockerFilterShopFrom' => language('report/report/report', 'tRptTaxSaleLockerFilterShopFrom'),
            'tRptTaxSaleLockerFilterShopTo' => language('report/report/report', 'tRptTaxSaleLockerFilterShopTo'),
            'tRptTaxSaleLockerFilterDocDateFrom' => language('report/report/report', 'tRptTaxSaleLockerFilterDocDateFrom'),
            'tRptTaxSaleLockerFilterDocDateTo' => language('report/report/report', 'tRptTaxSaleLockerFilterDocDateTo'),
            // Report Text Condtion Other Report
            'tRptConditionInReport'     => language('report/report/report', 'tRptConditionInReport'),
        ];

        $this->tBchCodeLogin = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage = 100;
        $this->nOptDecimalShow = FCNxHGetOptionDecimalShow();
        
        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;
        
        $this->nLngID = FCNaHGetLangEdit();
        $this->tRptCode = $this->input->post('ohdRptCode');
        $this->tRptGroup = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID = $this->session->userdata('tSesSessionID');
        $this->tRptRoute = $this->input->post('ohdRptRoute');
        $this->tRptExportType = $this->input->post('ohdRptTypeExport');
        $this->nPage = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode = $this->session->userdata('tSesUsername');

        // Report Filter
        $this->aRptFilter = [
            'tUserSession' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'nLangID' => $this->nLngID,
            // กลุ่มธุรกิจ
            'tMerchantCode' => ($this->input->post('oetRptMerchantCode') != '') ? $this->input->post('oetRptMerchantCode') : '',
            'tMerchantName' => ($this->input->post('oetRptMerchantName') != '') ? $this->input->post('oetRptMerchantName') : '',
            // ร้านค้า
            'tShpCodeFrom' => ($this->input->post('oetRptShpCodeFrom') != '') ? $this->input->post('oetRptShpCodeFrom') : '',
            'tShpNameFrom' => ($this->input->post('oetRptShpNameFrom') != '') ? $this->input->post('oetRptShpNameFrom') : '',
            'tShpCodeTo' => ($this->input->post('oetRptShpCodeTo') != '') ? $this->input->post('oetRptShpCodeTo') : '',
            'tShpNameTo' => ($this->input->post('oetRptShpNameTo') != '') ? $this->input->post('oetRptShpNameTo') : '',
            // วันที่เอกสาร(DocNo)
            'tDocDateFrom' => ($this->input->post('oetRptDocDateFrom') != '') ? $this->input->post('oetRptDocDateFrom') : '',
            'tDocDateTo' => ($this->input->post('oetRptDocDateTo') != '') ? $this->input->post('oetRptDocDateTo') : ''
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {
            
            // Execute Stored Procedure
            $this->mRptTaxSaleLocker->FSnMExecStoreCReport($this->aRptFilter);

            $aDataMain = array(
                'ptRptRoute' => $this->tRptRoute,
                'ptRptCode' => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter' => $this->aRptFilter
            );

            switch ($this->tRptExportType) {
                case 'html': 
                    $this->FSvCCallRptViewBeforePrint($aDataMain);
                    break;
                case 'excel': 
                    $this->FSoCChkDataReportInTableTemp($aDataMain);
                    break;
                case 'pdf': 
                    $this->FSoCChkDataReportInTableTemp($aDataMain);
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Wasin(Yoshi)
     * LastUpdate: 03/10/2019 Piya
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataMain) {
        try {

            /*===== Begin Get Data =====================================================*/
            // ดึงข้อมูลจากฐานข้อมูล Temp
            $aDataReportParams = [
                'nPerPage' => $this->nPerPage,
                'nPage' => $this->nPage,
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
            ];
            $aDataReport = $this->mRptTaxSaleLocker->FSaMGetDataReport($aDataReportParams);
            /*===== End Get Data =======================================================*/
            
            /*===== Begin Render View ==================================================*/
            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo' => $this->aCompanyInfo,
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aDataReport' => $aDataReport,
                'aDataTextRef' => $this->aText,
                'aDataFilter' => $this->aRptFilter
            ];

            // Load View Advance Table
            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rpttaxsalelocker', 'wRptTaxSaleLockerHtml', $aDataViewRptParams);

            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport' => $this->aText['tTitleReport'],
                'tRptTypeExport' => $this->tRptExportType,
                'tRptCode' => $this->tRptCode,
                'tRptRoute' => $this->tRptRoute,
                'tViewRenderKool' => $tRptView,
                'aDataFilter' => $this->aRptFilter,
                'aDataReport' => [
                    'raItems' => $aDataReport['aRptData'],
                    'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                ]
            ];

            $this->load->view('report/report/wReportViewer', $aDataViewerParams);
            /*===== End Render View ====================================================*/
            
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Wasin(Yoshi)
     * LastUpdate: 03/10/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /*===== Begin Init Variable ====================================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /*===== End Init Variable ======================================================*/
        
        /*===== Begin Get Data =========================================================*/
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'nPerPage' => $this->nPerPage,
            'nPage' => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        ];

        $aDataReport = $this->mRptTaxSaleLocker->FSaMGetDataReport($aDataReportParams);
        /*===== End Get Data ===========================================================*/
        
        /*===== Begin Render View ======================================================*/
        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataFilter' => $aDataFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rpttaxsalelocker', 'wRptTaxSaleLockerHtml', $aDataViewRptParams);

        // Data Viewer Center Report
        $aDataViewerParams = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tRptView,
            'aDataFilter' => $aDataFilter,
            'aDataReport' => array(
                'raItems' => $aDataReport['aRptData'],
                'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success'
            )
        );

        $this->load->view('report/report/wReportViewer', $aDataViewerParams);
        /*===== End Render View ========================================================*/
    }

    // Functionality: Function Count Data Report And Calcurate
    // Parameters:  Function Parameter
    // Creator: 22/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptRenderExcel($paDataMain) {
        try {
            $aDataFilter = $paDataMain['paDataFilter'];
            $nPage = 1;
            $nLangEdit = $this->session->userdata("tLangEdit");
            $tSesUsername = $this->session->userdata('tSesUsername');
            $tUsrSessionID = $this->session->userdata('tSesSessionID');

            // Check Filter Merchant And 
            $aDataAddress = array();
            if (isset($aDataFilter['tMerchantCode']) && !empty($aDataFilter['tMerchantCode'])) {
                // Get Data MerChant (ดึงข้อมูลอ้างอิงที่อยู่กลุ่มธุรกิจ)
                $aDataWhereMerChant = array(
                    'tMerChantCode' => $aDataFilter['tMerchantCode'],
                    'nLngID' => $nLangEdit
                );
                $aDataMerChant = $this->mRptTaxSaleLocker->FSaMGetDataMerChant($aDataWhereMerChant);
                $aDataAddress = $aDataMerChant;
            } else {
                $tAPIReq = "";
                $tMethodReq = "GET";
                $aDataWhereComp = array('FNLngID' => $nLangEdit);
                $aCompData = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);
                if ($aCompData['rtCode'] == '1') {
                    $tCompName = $aCompData['raItems']['rtCmpName'];
                    $tBchCode = $aCompData['raItems']['rtCmpBchCode'];
                    $aDataAddress = $this->mReport->FSaMRptGetDataAddressByBranchComp($tBchCode, $nLangEdit);
                } else {
                    $tCompName = "-";
                    $tBchCode = "-";
                    $aDataAddress = array();
                }
            }

            // array ข้อมูลภาษาที่เกี่ยวข้องกับรายงาน
            $aDataTextRef = array(
                'tTitleReport' => language('report/report/report', 'tRptTaxSaleLockerTitle'),
                'tDatePrint' => language('report/report/report', 'tRptTaxSaleLockerDatePrint'),
                'tTimePrint' => language('report/report/report', 'tRptTaxSaleLockerTimePrint'),
                // Address Lang
                'tRptAddrBuilding' => language('report/report/report', 'tRptAddrBuilding'),
                'tRptAddrRoad' => language('report/report/report', 'tRptAddrRoad'),
                'tRptAddrSoi' => language('report/report/report', 'tRptAddrSoi'),
                'tRptAddrSubDistrict' => language('report/report/report', 'tRptAddrSubDistrict'),
                'tRptAddrDistrict' => language('report/report/report', 'tRptAddrDistrict'),
                'tRptAddrProvince' => language('report/report/report', 'tRptAddrProvince'),
                'tRptAddrTel' => language('report/report/report', 'tRptAddrTel'),
                'tRptAddrFax' => language('report/report/report', 'tRptAddrFax'),
                'tRptAddrBranch' => language('report/report/report', 'tRptAddrBranch'),
                'tRptAddV2Desc1' => language('report/report/report', 'tRptAddV2Desc1'),
                'tRptAddV2Desc2' => language('report/report/report', 'tRptAddV2Desc2'),
                // Table Label
                'tRptTaxSaleLockerRowNo' => language('report/report/report', 'tRptTaxSaleLockerRowNo'),
                'tRptTaxSaleLockerDocDate' => language('report/report/report', 'tRptTaxSaleLockerDocDate'),
                'tRptTaxSaleLockerDocNo' => language('report/report/report', 'tRptTaxSaleLockerDocNo'),
                'tRptTaxSaleLockerDocRef' => language('report/report/report', 'tRptTaxSaleLockerDocRef'),
                'tRptTaxSaleLockerCustomer' => language('report/report/report', 'tRptTaxSaleLockerCustomer'),
                'tRptTaxSaleLockerCtmTaxNo' => language('report/report/report', 'tRptTaxSaleLockerCtmTaxNo'),
                'tRptTaxSaleLockerMerChant' => language('report/report/report', 'tRptTaxSaleLockerMerChant'),
                'tRptTaxSaleLockerAmt' => language('report/report/report', 'tRptTaxSaleLockerAmt'),
                'tRptTaxSaleLockerAmtV' => language('report/report/report', 'tRptTaxSaleLockerAmtV'),
                'tRptTaxSaleLockerAmtNV' => language('report/report/report', 'tRptTaxSaleLockerAmtNV'),
                'tRptTaxSaleLockerGrandTotal' => language('report/report/report', 'tRptTaxSaleLockerGrandTotal'),
                'tRptTaxSaleLockerPosGrouping' => language('report/report/report', 'tRptTaxSaleLockerPosGrouping'),
                // No Data Report
                'tRptTaxSaleLockerNoData' => language('common/main/main', 'tCMNNotFoundData'),
                'tRptTaxSaleLockerTotalSub' => language('report/report/report', 'tRptTaxSaleLockerTotalSub'),
                'tRptTaxSaleLockerTotalFooter' => language('report/report/report', 'tRptTaxSaleLockerTotalFooter'),
                // Filter Text Label
                'tRptTaxSaleLockerFilterMerChant' => language('report/report/report', 'tRptTaxSaleLockerFilterMerChant'),
                'tRptTaxSaleLockerFilterShopFrom' => language('report/report/report', 'tRptTaxSaleLockerFilterShopFrom'),
                'tRptTaxSaleLockerFilterShopTo' => language('report/report/report', 'tRptTaxSaleLockerFilterShopTo'),
                'tRptTaxSaleLockerFilterDocDateFrom' => language('report/report/report', 'tRptTaxSaleLockerFilterDocDateFrom'),
                'tRptTaxSaleLockerFilterDocDateTo' => language('report/report/report', 'tRptTaxSaleLockerFilterDocDateTo'),
            );

            /** ================================== Begin Init Variable Excel ================================== */
            $tReportName = $aDataTextRef['tTitleReport'];
            $dDateExport = date('Y-m-d');
            $tTime = date('H:i:s');
            /** ===================================== End Init Variable ======================================= */
            /** ======================================= Begin Get Data ======================================== */
            $aCompInfoParams = ['nLngID' => FCNaHGetLangEdit()];
            $aCompData = FCNaGetCompanyInfo($aCompInfoParams);
            // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
            $aDataWhereRpt = array(
                'nPerPage' => 100,
                'nPage' => $nPage,
                'tCompName' => $this->tCompName,
                'tRptCode' => $tRptCode,
                'tUsrSessionID' => $tUsrSessionID
            );
            $aDataReport = $this->mRptTaxSaleLocker->FSaMGetDataReport($aDataWhereRpt);
            /** =============================================================================================== */
            // ตั้งค่า Font Style
            $aStyleRptFont = array('font' => array('name' => 'TH Sarabun New'));
            $aStyleRptSizeTitleName = array('font' => array('size' => 14));
            $aStyleRptSizeCompName = array('font' => array('size' => 12));
            $aStyleRptSizeAddressFont = array('font' => array('size' => 12));
            $aStyleRptHeadderTable = array('font' => array('size' => 12, 'color' => array('rgb' => '000000')));
            $aStyleRptDataTable = array('font' => array('size' => 10, 'color' => array('rgb' => '000000')));

            // Initiate PHPExcel cache
            $oCacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
            $aCacheSettings = array(' memoryCacheSize ' => '8000MB', 'cacheTime' => 3600 * 120);
            PHPExcel_Settings::setCacheStorageMethod($oCacheMethod, $aCacheSettings);

            // เริ่ม phpExcel
            $objPHPExcel = new PHPExcel();

            // A4 ตั้งค่าหน้ากระดาษ
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

            // Set Font Style
            $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($aStyleRptFont);

            // จัดความกว้างของคอลัมน์
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(45);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

            // ชื่อหัวรายงาน
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tReportName);
            $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptSizeTitleName);

            // Check Address Data
            if (isset($aDataAddress) && !empty($aDataAddress)) {
                // Company Name
                $tRptCompName = (empty($aDataAddress['FTCompName'])) ? '-' : $aDataAddress['FTCompName'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $tRptCompName)->getStyle('A2')->applyFromArray($aStyleRptSizeCompName);

                // Check Vertion Address
                if ($aDataAddress['FTAddVersion'] == 1) {
                    // Check Address Line 1
                    $tRptAddV1No = (empty($aDataAddress['FTAddV1No'])) ? '-' : $aDataAddress['FTAddV1No'];
                    $tRptAddV1Road = (empty($aDataAddress['FTAddV1Road'])) ? '-' : $aDataAddress['FTAddV1Road'];
                    $tRptAddV1Soi = (empty($aDataAddress['FTAddV1Soi'])) ? '-' : $aDataAddress['FTAddV1Soi'];
                    $tRptAddressLine1 = $tRptAddV1No . ' ' . $aDataTextRef['tRptAddrRoad'] . ' ' . $tRptAddV1Road . ' ' . $aDataTextRef['tRptAddrSoi'] . ' ' . $tRptAddV1Soi;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddressLine1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    // Check Address Line 2
                    $tRptAddV1SubDistName = (empty($aDataAddress['FTSudName'])) ? '-' : $aDataAddress['FTSudName'];
                    $tRptAddV1DstName = (empty($aDataAddress['FTDstName'])) ? '-' : $aDataAddress['FTDstName'];
                    $tRptAddV1PvnName = (empty($aDataAddress['FTPvnName'])) ? '-' : $aDataAddress['FTPvnName'];
                    $tRptAddV1PostCode = (empty($aDataAddress['FTAddV1PostCode'])) ? '-' : $aDataAddress['FTAddV1PostCode'];
                    $tRptAddressLine2 = $tRptAddV1SubDistName . ' ' . $tRptAddV1DstName . ' ' . $tRptAddV1PvnName . ' ' . $tRptAddV1PostCode;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddressLine2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                } else {
                    $tRptAddV2Desc1 = (empty($aDataAddress['FTAddV2Desc1'])) ? '-' : $aDataAddress['FTAddV2Desc1'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddV2Desc1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    $tRptAddV2Desc2 = (empty($aDataAddress['FTAddV2Desc2'])) ? '-' : $aDataAddress['FTAddV2Desc2'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddV2Desc2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                }

                // Check Data Telephone Number
                if (isset($aDataAddress['FTCompTel']) && !empty($aDataAddress['FTCompTel'])) {
                    $tRptCompTel = $aDataAddress['FTCompTel'];
                } else {
                    $tRptCompTel = '-';
                }
                $tRptCompTelText = $aDataTextRef['tRptAddrTel'] . ' ' . $tRptCompTel;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tRptCompTelText)->getStyle('A5')->applyFromArray($aStyleRptSizeAddressFont);

                // Check Data Fax Number
                if (isset($aDataAddress['FTCompFax']) && !empty($aDataAddress['FTCompFax'])) {
                    $tRptCompFax = $aDataAddress['FTCompFax'];
                } else {
                    $tRptCompFax = '-';
                }
                $tRptCompFaxText = $aDataTextRef['tRptAddrFax'] . ' ' . $tRptCompFax;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tRptCompFaxText)->getStyle('A6')->applyFromArray($aStyleRptSizeAddressFont);
            }
            
            // Row เริ่มต้นของ Filter
            $nStartRowFillter = 2;
            $tFillterColumLEFT = "D";
            $tFillterColumRIGHT = "H";

            // Fillter MerChant (กลุ่มธุรกิจ)
            if (!empty($aDataFilter['tMerchantCode'])) {
                $tRptDateTimeExportText = $aDataTextRef['tRptTaxSaleLockerFilterMerChant'] . ': ' . $aDataFilter['tMerchantName'];
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptDateTimeExportText);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Shop (ร้านค้า)
            if (!empty($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeTo'])) {
                $tRptFilterShopCodeFrom = $aDataTextRef['tRptTaxSaleLockerFilterShopFrom'] . ' ' . $aDataFilter['tShpNameFrom'];
                $tRptFilterShopCodeTo = $aDataTextRef['tRptTaxSaleLockerFilterShopTo'] . ' ' . $aDataFilter['tShpNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterShopCodeFrom . ' ' . $tRptFilterShopCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter DocDate (วันที่สร้างเอกสาร)
            if (!empty($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateTo'])) {
                $tRptFilterDocDateFrom = $aDataTextRef['tRptTaxSaleLockerFilterDocDateFrom'] . ' ' . $aDataFilter['tDocDateFrom'];
                $tRptFilterDocDateTo = $aDataTextRef['tRptTaxSaleLockerFilterDocDateTo'] . ' ' . $aDataFilter['tDocDateTo'];
                $tRptTextLeftRightFilter = $tRptFilterDocDateFrom . ' ' . $tRptFilterDocDateTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }


            // ====================================================================================================================================================================
            // ========================================================================== Date Time Print ========================================================================= 
            $tRptDateTimeExportText = $aDataTextRef['tDatePrint'] . ' ' . $dDateExport . ' ' . $aDataTextRef['tTimePrint'] . ' ' . $tTime;
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:K7');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', $tRptDateTimeExportText);
            $objPHPExcel->getActiveSheet()->getStyle("A7")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($aStyleRptSizeAddressFont);
            // ====================================================================================================================================================================
            // ==================================================================== หัวตารางรายงาน ==================================================================================
            // กำหนดจุดเริ่มต้นของแถวหัวตาราง
            $nStartRowHeadder = 8;

            // กำหนด Style Font ของหัวตาราง
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->applyFromArray(array(
                'borders' => array(
                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                )
            ));

            // กำหนดข้อมูลลงหัวตาราง
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('A' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerRowNo'])
                    ->setCellValue('B' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerDocDate'])
                    ->setCellValue('C' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerDocNo'])
                    ->setCellValue('D' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerDocRef'])
                    ->setCellValue('E' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerCustomer'])
                    ->setCellValue('F' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerCtmTaxNo'])
                    ->setCellValue('G' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerMerChant'])
                    ->setCellValue('H' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerAmt'])
                    ->setCellValue('I' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerAmtV'])
                    ->setCellValue('J' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerAmtNV'])
                    ->setCellValue('K' . $nStartRowHeadder, $aDataTextRef['tRptTaxSaleLockerGrandTotal']);

            // Alignment ของหัวตาราง
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':G' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('H' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            // ====================================================================================================================================================================
            // ==================================================================== ข้อมูลรายละเอียดรายงาน ===========================================================================
            // Set Variable Data
            $nStartRowData = $nStartRowHeadder + 1;
            if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {

                // ******* Step 1 ประกาศตัวแปรใช้ในการเช็คเงื่อนไข
                $tGrouppingData = "";
                $nGroupMember = "";
                $nRowPartID = "";

                $nSubSumXshAmt = 0;
                $nSubSumXshAmtV = 0;
                $nSubSumXshAmtNV = 0;
                $nSubSumGrandTotal = 0;

                $nSumFooterXshAmt = 0;
                $nSumFooterXshAmtV = 0;
                $nSumFooterXshAmtNV = 0;
                $nSumFooterGrandTotal = 0;
                foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                    // ******* Step 3 Set ค่า Value FNRptGroupMember And FNRowPartID
                    $nGroupMember = $aValue["FNRptGroupMember"];
                    $nRowPartID = $aValue["FNRowPartID"];

                    // ******* Step 4 : Check Groupping Create Row Groupping 
                    if ($tGrouppingData != $aValue['FTPosCode']) {
                        $tTextLabelGroupping = $aDataTextRef['tRptTaxSaleLockerPosGrouping'] . ' ' . $aValue['FTPosCode'];
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':K' . $nStartRowData);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $tTextLabelGroupping);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
                        $nStartRowData++;
                    }

                    // ******* Step 5 : Loop Set Data Value 
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $nStartRowData, $aValue['FNRowPartID'])
                            ->setCellValue('B' . $nStartRowData, date("Y/m/d", strtotime($aValue['FDXshDocDate'])))
                            ->setCellValue('C' . $nStartRowData, $aValue['FTXshDocNo'])
                            ->setCellValue('D' . $nStartRowData, $aValue['FTXshDocRef'])
                            ->setCellValue('E' . $nStartRowData, !empty($aValue['FTCstName']) ? $aValue['FTCstName'] : '-')
                            ->setCellValue('F' . $nStartRowData, !empty($aValue['FTXshTaxID']) ? $aValue['FTXshTaxID'] : '-')
                            ->setCellValue('G' . $nStartRowData, !empty($aValue['FTCmpName']) ? $aValue['FTCmpName'] : '-')
                            ->setCellValue('H' . $nStartRowData, number_format($aValue["FCXshAmt"], 2))
                            ->setCellValue('I' . $nStartRowData, number_format($aValue["FCXshAmtV"], 2))
                            ->setCellValue('J' . $nStartRowData, number_format($aValue["FCXshAmtNV"], 2))
                            ->setCellValue('K' . $nStartRowData, number_format($aValue["FCXshGrandTotal"], 2));

                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':G' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                    $objPHPExcel->getActiveSheet()->getStyle('H' . $nStartRowData . ':K' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    // ******* Step 6 : เตรียม Parameter สำหรับ Summary Sub Footer
                    if ($nRowPartID == $nGroupMember) {
                        $nStartRowData++;
                        $nSubSumXshAmt = $aValue["FCXshAmt_SubTotal"];
                        $nSubSumXshAmtV = $aValue["FCXshAmtV_SubTotal"];
                        $nSubSumXshAmtNV = $aValue["FCXshAmtNV_SubTotal"];
                        $nSubSumGrandTotal = $aValue["FCXshGrandTotal_SubTotal"];

                        // Set Color Row Sub Footer
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':K' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':K' . $nStartRowData)->applyFromArray(array(
                            'borders' => array(
                                // 'top'       => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                            )
                        ));

                        // LEFT 
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':G' . $nStartRowData);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptTaxSaleLockerTotalSub']);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                        // RIGHT
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('H' . $nStartRowData, number_format($nSubSumXshAmt, 2))
                                ->setCellValue('I' . $nStartRowData, number_format($nSubSumXshAmtV, 2))
                                ->setCellValue('J' . $nStartRowData, number_format($nSubSumXshAmtNV, 2))
                                ->setCellValue('K' . $nStartRowData, number_format($nSubSumGrandTotal, 2));
                        $nStartRowData++;
                    }

                    $nSumFooterXshAmt = number_format($aValue["FCXshAmt_Footer"], 2);
                    $nSumFooterXshAmtV = number_format($aValue["FCXshAmtV_Footer"], 2);
                    $nSumFooterXshAmtNV = number_format($aValue["FCXshAmtNV_Footer"], 2);
                    $nSumFooterGrandTotal = number_format($aValue["FCXshGrandTotal_Footer"], 2);

                    // ******* Step 2 Set ค่า Value ให้กับตัวแปร
                    $tGrouppingData = $aValue["FTPosCode"];
                    $nStartRowData++;
                }

                // Step 7 : Set Footer Text
                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                if ($nPageNo == $nTotalPage) {
                    $nStartRowData--;
                    // Set Color Row Sub Footer
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':K' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':K' . $nStartRowData)->applyFromArray(array(
                        'borders' => array(
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => '000000'))
                        )
                    ));

                    // LEFT 
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':G' . $nStartRowData);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptTaxSaleLockerTotalFooter']);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                    // RIGHT
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('H' . $nStartRowData, number_format($nSumFooterXshAmt, 2))
                            ->setCellValue('I' . $nStartRowData, number_format($nSumFooterXshAmtV, 2))
                            ->setCellValue('J' . $nStartRowData, number_format($nSumFooterXshAmtNV, 2))
                            ->setCellValue('K' . $nStartRowData, number_format($nSumFooterGrandTotal, 2));
                }
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':K' . $nStartRowData);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptTaxSaleLockerNoData']);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
            }
            // ====================================================================================================================================================================
            // Export File Excel
            $tFilename = 'Report-' . $tRptCode . date("dmYhis") . '.xlsx';

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");
            ;
            header("Content-Disposition: attachment;filename=$tFilename");
            header("Content-Transfer-Encoding: binary");

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/')) {
                mkdir(APPPATH . 'modules/report/assets/exportexcel/');
            }

            if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode)) {
                mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode);
            }

            if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername)) {
                mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername);
            }

            $tPathExport = APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername . '/';

            $oFiles = glob($tPathExport . '*');
            foreach ($oFiles as $tFile) {
                if (is_file($tFile))
                    unlink($tFile);
            }

            // Check Status Save File Excel
            $objWriter->save($tPathExport . $tFilename);
            $aResponse = array(
                'nStaExport' => 1,
                'tFileName' => $tFilename,
                'tPathFolder' => 'application/modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername . '/',
                'tMessage' => "Export File Successfully."
            );
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaExport' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }
     
    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Witsarut(Bell)
     * LastUpdate: 03/10/2019 Piya
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataMain) {

        try {
            $aDataCountData = [
                'tCompName' => $paDataMain['paDataFilter']['tCompName'],
                'tRptCode' => $paDataMain['paDataFilter']['tRptCode'],
                'tUserSession' => $paDataMain['paDataFilter']['tUserSession'],
            ];

            $nDataCountPage = $this->mRptTaxSaleLocker->FSnMCountRowInTemp($aDataCountData);

            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent' => 1,
                'tMessage' => 'Success Count Data All'
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }
    
    /**
     * Functionality: Send Rabbit MQ Report
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Witsarut(Bell)
     * LastUpdate: 03/10/2019 Piya
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $tDateSendMQ = date('Y-m-d');
            $tTimeSendMQ = date('H:i:s');
            $tDateSubscribe = date('Ymd');
            $tTimeSubscribe = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode' => $this->tRptCode,
                    'pnPerFile' => 20000,
                    'ptUserCode' => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pnLngID' => $this->nLngID,
                    'ptFilter' => $this->aRptFilter,
                    'ptRptExpType' => $this->tRptExportType,
                    'ptComName' => $this->tCompName,
                    'ptDate' => $tDateSendMQ,
                    'ptTime' => $tTimeSendMQ,
                    'ptBchCode' => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
                ]
            ];

            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptComName' => $this->tCompName,
                    'ptRptCode' => $this->tRptCode,
                    'ptUserCode' => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pdDateSubscribe' => $tDateSubscribe,
                    'pdTimeSubscribe' => $tTimeSubscribe,
                )
            );
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

}







































