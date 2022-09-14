<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptSaleByPaymentDetail extends MX_Controller {

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
        $this->load->model('report/reportlocker/mRptSaleByPaymentDetail');

        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init() {
        $this->aText = [
            'tTitleReport'          => language('report/report/report', 'tRptSaleByPaymentDetailTitle'),
            'tDatePrint'            => language('report/report/report', 'tRptSaleByPaymentDetailDatePrint'),
            'tTimePrint'            => language('report/report/report', 'tRptSaleByPaymentDetailTimePrint'),
            // Address Lang
            'tRptAddrBuilding'      => language('report/report/report', 'tRptAddrBuilding'),
            'tRptAddrRoad'          => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi'           => language('report/report/report', 'tRptAddrSoi'),
            'tRptAddrSubDistrict'   => language('report/report/report', 'tRptAddrSubDistrict'),
            'tRptAddrDistrict'      => language('report/report/report', 'tRptAddrDistrict'),
            'tRptAddrProvince'      => language('report/report/report', 'tRptAddrProvince'),
            'tRptAddrTel'           => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax'           => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrBranch'        => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddrTaxNo'         => language('report/report/report', 'tRptAddrTaxNo'),
            'tRptAddV2Desc1'        => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2'        => language('report/report/report', 'tRptAddV2Desc2'),
            // Filter Text Label
            'tRptSaleByPaymentDetailFilterBchFrom'      => language('report/report/report', 'tRptSaleByPaymentDetailFilterBchFrom'),
            'tRptSaleByPaymentDetailFilterBchTo'        => language('report/report/report', 'tRptSaleByPaymentDetailFilterBchTo'),
            'tRptSaleByPaymentDetailFilterShopFrom'     => language('report/report/report', 'tRptSaleByPaymentDetailFilterShopFrom'),
            'tRptSaleByPaymentDetailFilterShopTo'       => language('report/report/report', 'tRptSaleByPaymentDetailFilterShopTo'),
            'tRptSaleByPaymentDetailFilterPosFrom'      => language('report/report/report', 'tRptSaleByPaymentDetailFilterPosFrom'),
            'tRptSaleByPaymentDetailFilterPosTo'        => language('report/report/report', 'tRptSaleByPaymentDetailFilterPosTo'),
            'tRptSaleByPaymentDetailFilterPayTypeFrom'  => language('report/report/report', 'tRptSaleByPaymentDetailFilterPayTypeFrom'),
            'tRptSaleByPaymentDetailFilterPayTypeTo'    => language('report/report/report', 'tRptSaleByPaymentDetailFilterPayTypeTo'),
            'tRptSaleByPaymentDetailFilterDocDateFrom'  => language('report/report/report', 'tRptSaleByPaymentDetailFilterDocDateFrom'),
            'tRptSaleByPaymentDetailFilterDocDateTo'    => language('report/report/report', 'tRptSaleByPaymentDetailFilterDocDateTo'),
            // Table Label
            'tRptSaleByPaymentDetailDocDate'        => language('report/report/report', 'tRptSaleByPaymentDetailDocDate'),
            'tRptSaleByPaymentDetailPayType'        => language('report/report/report', 'tRptSaleByPaymentDetailPayType'),
            'tRptSaleByPaymentDetailDocNo'          => language('report/report/report', 'tRptSaleByPaymentDetailDocNo'),
            'tRptSaleByPaymentDetailRack'           => language('report/report/report', 'tRptSaleByPaymentDetailRack'),
            'tRptSaleByPaymentDetailDocRef'         => language('report/report/report', 'tRptSaleByPaymentDetailDocRef'),
            'tRptSaleByPaymentDetailPayment'        => language('report/report/report', 'tRptSaleByPaymentDetailPayment'),
            'tRptSaleByPaymentDetailPaymentTotal'   => language('report/report/report', 'tRptSaleByPaymentDetailPaymentTotal'),
            'tRptSaleByPaymentDetailPosGrouping'    => language('report/report/report', 'tRptSaleByPaymentDetailPosGrouping'),
            // Other Text
            'tRptSaleByPaymentDetailTotalSub'       => language('report/report/report', 'tRptSaleByPaymentDetailTotalSub'),
            'tRptSaleByPaymentDetailTotalFooter'    => language('report/report/report', 'tRptSaleByPaymentDetailTotalFooter'),
            'tRptRcvNameEmpty'                      => language('report/report/report', 'tRptRcvNameEmpty'),
            // Report Text Condtion Other Report
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            // No Data Report
            'tRptNotFoundData'      => language('common/main/main', 'tCMNNotFoundData'),
        ];
        
        $this->tBchCodeLogin    = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage         = 100;
        $this->nOptDecimalShow  = FCNxHGetOptionDecimalShow();
        
        $tIP                = $this->input->ip_address();
        $tFullHost          = gethostbyaddr($tIP);
        $this->tCompName    = $tFullHost;
        
        $this->nLngID           = FCNaHGetLangEdit();
        $this->tRptCode         = $this->input->post('ohdRptCode');
        $this->tRptGroup        = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID   = $this->session->userdata('tSesSessionID');
        $this->tRptRoute        = $this->input->post('ohdRptRoute');
        $this->tRptExportType   = $this->input->post('ohdRptTypeExport');
        $this->nPage            = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode   = $this->session->userdata('tSesUsername');

        // Report Filter
        $this->aRptFilter = [
            'tUsrSessionID' => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tCode'         => $this->tRptCode,
            'nLangID'       => $this->nLngID,
            // สาขา(Branch)
            'tBchCodeFrom'  => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'  => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'    => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'    => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            // ร้านค้า(Shop)
            'tShpCodeFrom'  => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'  => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'    => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'    => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            // เครื่องจุดขาย(POS)
            'tPosCodeFrom'  => !empty($this->input->post('oetRptPosCodeFrom')) ? $this->input->post('oetRptPosCodeFrom') : "",
            'tPosNameFrom'  => !empty($this->input->post('oetRptPosNameFrom')) ? $this->input->post('oetRptPosNameFrom') : "",
            'tPosCodeTo'    => !empty($this->input->post('oetRptPosCodeTo')) ? $this->input->post('oetRptPosCodeTo') : "",
            'tPosNameTo'    => !empty($this->input->post('oetRptPosNameTo')) ? $this->input->post('oetRptPosNameTo') : "",
            // ประเภทชำระเงิน(Payment)
            'tRcvCodeFrom'  => !empty($this->input->post('oetRptRcvCodeFrom')) ? $this->input->post('oetRptRcvCodeFrom') : "",
            'tRcvNameFrom'  => !empty($this->input->post('oetRptRcvNameFrom')) ? $this->input->post('oetRptRcvNameFrom') : "",
            'tRcvCodeTo'    => !empty($this->input->post('oetRptRcvCodeTo')) ? $this->input->post('oetRptRcvCodeTo') : "",
            'tRcvNameTo'    => !empty($this->input->post('oetRptRcvNameTo')) ? $this->input->post('oetRptRcvNameTo') : "",
            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'  => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'    => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {
            // Execute Stored Procedure
            $this->mRptSaleByPaymentDetail->FSnMExecStoreReport($this->aRptFilter);
            // Count Rows
            $aCountRowParams = [
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID
            ];
            $this->nRows = $this->mRptSaleByPaymentDetail->FSnMCountRowInTemp($aCountRowParams);

            // Report Type
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp();
                    /* $aExportExcelRes = $this->FSvCCallRptRenderExcel();
                      echo json_encode($aExportExcelRes); */
                    break;
                case 'pdf':
                    $aExportExcelRes = $this->FSvCCallRptRenderExcel();
                    echo json_encode($aExportExcelRes);
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint() {
        try {
            /*===== Begin Get Data =====================================================*/
            // ดึงข้อมูลจากฐานข้อมูล Temp
            $aDataReportParams = [
                'nPerPage'      => $this->nPerPage,
                'nPage'         => $this->nPage,
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
            ];
            $aDataReport = $this->mRptSaleByPaymentDetail->FSaMGetDataReport($aDataReportParams);
            /*===== End Get Data =======================================================*/

            /*===== Begin Render View ==================================================*/
            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow'   => $this->nOptDecimalShow,
                'aCompanyInfo'      => $this->aCompanyInfo,
                'aDataReport'       => $aDataReport,
                'aDataTextRef'      => $this->aText,
                'aDataFilter'       => $this->aRptFilter
            ];
            $tRptView   = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/rptSaleByPaymentDetail', 'wRptSaleByPaymentDetailHtml', $aDataViewRptParams);

            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport'      => $this->aText['tTitleReport'],
                'tRptTypeExport'    => $this->tRptExportType,
                'tRptCode'          => $this->tRptCode,
                'tRptRoute'         => $this->tRptRoute,
                'tViewRenderKool'   => $tRptView,
                'aDataFilter'       => $this->aRptFilter,
                'aDataReport'       => [
                    'raItems'       => $aDataReport['aRptData'],
                    'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
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
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
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
        $aDataReport = $this->mRptSaleByPaymentDetail->FSaMGetDataReport($aDataReportParams);
        /*===== End Get Data ===========================================================*/

        /*===== Begin Render View ======================================================*/
        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo' => $this->aCompanyInfo,
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataFilter' => $aDataFilter
        );
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/rptSaleByPaymentDetail', 'wRptSaleByPaymentDetailHtml', $aDataViewRptParams);

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

    /**
     * Functionality: Excel Report
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptRenderExcel() {

        /** =========== Begin Init Variable ================================== */
        $tReportName = $this->aText['tTitleReport'];
        $dDateExport = date('Y-m-d');
        $tTime = date('H:i:s');
        $tTextDetail = $this->aText['tRptSaleByPaymentDetailDatePrint'] . ' : ' . $dDateExport . '  ' . $this->aText['tRptSaleByPaymentDetailTimePrint'] . ' : ' . $tTime;
        /** =========== End Init Variable ==================================== */
        /** =========== Begin Get Data ======================================= */
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aGetDataReportParams = array(
            'nPerPage' => 100000,
            'nPage' => 1,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        );
        $aDataReport = $this->mRptSaleByPaymentDetail->FSaMGetDataReport($aGetDataReportParams);
        /** =========== End Get Data ========================================= */
        try {
            if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
                // ตั้งค่า Font Style
                $aStyleRptName = array('font' => array('size' => 14, 'bold' => true,));
                $aStyleHeadder = array('font' => array('size' => 12, 'bold' => true, 'color' => array('rgb' => 'FFFFFF')));
                $aStyleRptHeadderTable = array('font' => array('size' => 12, 'color' => array('rgb' => '000000')));
                $StyleCompFont = array('font' => array('size' => 12, 'bold' => true,));
                $StyleAddressFont = array('font' => array('size' => 11, 'bold' => true,));
                $aStyleBold = ['font' => ['size' => 11, 'bold' => true,]];
                $StyleFont = array('font' => array('name' => 'TH Sarabun New'));

                // Initiate PHPExcel cache
                $oCacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
                $aCacheSettings = array(' memoryCacheSize ' => '8000MB', 'cacheTime' => 3600 * 120);
                PHPExcel_Settings::setCacheStorageMethod($oCacheMethod, $aCacheSettings);

                // เริ่ม phpExcel
                $objPHPExcel = new PHPExcel();

                // A4 ตั้งค่าหน้ากระดาษ
                $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

                // Set Font
                $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($StyleFont);

                // จัดความกว้างของคอลัมน์
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(40);
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);

                // ชื่อ Conpany
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $this->aCompanyInfo['FTCmpName'])->getStyle('A2')->applyFromArray($StyleCompFont);

                // ที่อยู่
                $tLabelAddressLine1 = $this->aCompanyInfo['FTAddV1No'] . ' ' . $this->aCompanyInfo['FTAddV1Village'] . ' ' . $this->aCompanyInfo['FTAddV1Road'] . ' ' . $this->aCompanyInfo['FTAddV1Soi'];
                $tLabelAddressLine2 = $this->aCompanyInfo['FTSudName'] . ' ' . $this->aCompanyInfo['FTDstName'] . ' ' . $this->aCompanyInfo['FTPvnName'] . ' ' . $this->aCompanyInfo['FTAddV1PostCode'];
                // ที่อยู่ บรรทัดที่ 1
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tLabelAddressLine1)->getStyle('A3')->applyFromArray($StyleAddressFont);
                // ที่อยู่ บรรทัดที่ 2
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tLabelAddressLine2)->getStyle('A4')->applyFromArray($StyleAddressFont);

                // เบอร์โทร, แฟกซ์
                $tLabelTelFax = $this->aText['tRptSaleByPaymentDetailTel'] . $this->aCompanyInfo['FTCmpTel'] . ' ' . $this->aText['tRptSaleByPaymentDetailFax'] . $this->aCompanyInfo['FTCmpFax'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tLabelTelFax)->getStyle('A5')->applyFromArray($StyleAddressFont);

                // สาขา
                $tLabelBch = $this->aText['tRptSaleByPaymentDetailBch'] . $this->aCompanyInfo['FTBchName'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tLabelBch)->getStyle('A6')->applyFromArray($StyleAddressFont);

                // ชื่อหัวรายงาน
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:E1');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tReportName);
                $objPHPExcel->getActiveSheet()->getStyle("A1")
                        ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptName);

                // กำหนกหัวตาราง
                $nStartRowHeadder = 8;
                $nStartRowFillter = 2;

                $tFillterColumLEFT = "C";
                $tFillterColumRIGHT = "D";

                /* ===== Begin Fillter =========================================================================== */
                // สาขา
                if (!empty($this->aRptFilter['tBchCodeFrom']) && !empty($this->aRptFilter['tBchCodeTo'])) {
                    // จากสาขา
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterBchFrom'] . $this->aRptFilter['tBchNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    // ถึงสาขา
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterBchTo'] . $this->aRptFilter['tBchNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $nStartRowFillter += 1;

                    if ($nStartRowFillter > 7) {
                        $nStartRowHeadder += 1;
                    }
                }

                // ร้านค้า
                if (!empty($this->aRptFilter['tShpCodeFrom']) && !empty($this->aRptFilter['tShpCodeTo'])) {
                    // จากร้านค้า
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterShopFrom'] . $this->aRptFilter['tShpNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    // ถึงร้านค้า
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterShopTo'] . $this->aRptFilter['tShpNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $nStartRowFillter += 1;

                    if ($nStartRowFillter > 7) {
                        $nStartRowHeadder += 1;
                    }
                }

                // เครื่องจุดขาย
                if (!empty($this->aRptFilter['tPosCodeFrom']) && !empty($this->aRptFilter['tPosCodeTo'])) {
                    // จากเครื่องจุดขาย
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterPosFrom'] . $this->aRptFilter['tPosNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    // ถึงเครื่องจุดขาย
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterPosTo'] . $this->aRptFilter['tPosNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $nStartRowFillter += 1;

                    if ($nStartRowFillter > 7) {
                        $nStartRowHeadder += 1;
                    }
                }

                // ประเภทการชำระ
                if (!empty($this->aRptFilter['tRcvCodeFrom']) && !empty($this->aRptFilter['tRcvCodeTo'])) {
                    // จากประเภทการชำระ
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterPayTypeFrom'] . $this->aRptFilter['tRcvNameFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    // ถึงประเภทการชำระ
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterPayTypeTo'] . $this->aRptFilter['tRcvNameTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $nStartRowFillter += 1;

                    if ($nStartRowFillter > 7) {
                        $nStartRowHeadder += 1;
                    }
                }

                // วันที่สร้างเอกสาร
                if (!empty($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateTo'])) {
                    // จากวันที่สร้างเอกสาร
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterDocDateFrom'] . $this->aRptFilter['tDocDateFrom']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    // ถึงวันที่สร้างเอกสาร
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptSaleByPaymentDetailFilterDocDateTo'] . $this->aRptFilter['tDocDateTo']);
                    $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
                            ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

                    $nStartRowFillter += 1;

                    if ($nStartRowFillter > 7) {
                        $nStartRowHeadder += 1;
                    }
                }
                /* ===== End Fillter =========================================================================== */

                // รายละเอียดการออกรายงาน
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . ($nStartRowHeadder - 1) . ':E' . ($nStartRowHeadder - 1));
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . ($nStartRowHeadder - 1), $tTextDetail);
                $objPHPExcel->getActiveSheet()->getStyle('A' . ($nStartRowHeadder - 1))
                        ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // กำหนด Style Font ของหัวตาราง
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':E' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':E' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':E' . $nStartRowHeadder)->applyFromArray(array(
                    'borders' => array(
                        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                    )
                ));

                // Main header
                $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $nStartRowHeadder, $this->aText['tRptSaleByPaymentDetailDocNo'])
                        ->setCellValue('B' . $nStartRowHeadder, str_replace("<br>", "\n", $this->aText['tRptSaleByPaymentDetailDateAndLocker']))
                        ->setCellValue('C' . $nStartRowHeadder, str_replace("<br>", "\n", $this->aText['tRptSaleByPaymentDetailPayTypeAndDocRef']))
                        ->setCellValue('D' . $nStartRowHeadder, $this->aText['tRptSaleByPaymentDetailPayment'])
                        ->setCellValue('E' . $nStartRowHeadder, $this->aText['tRptSaleByPaymentDetailPaymentTotal']);

                // ตัวอักษร Head Center
                $objPHPExcel->getActiveSheet()->getStyle("A" . $nStartRowHeadder . ":E" . $nStartRowHeadder)
                        ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);



                // Loop Data Query DataBase
                $nStartRowData = $nStartRowHeadder + 1;
                $nNum = 0;
                $nLastRowNuber = 0;

                foreach ($aDataReport['aRptData'] AS $nKey => $aValue) {

                    $nNum++;
                    if ($aValue['FNRowPartID'] == 1) {
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('A' . $nStartRowData, '  ' . $aValue['FTXshDocNo'])
                                ->setCellValue('B' . $nStartRowData, '  ' . date("d/m/Y", strtotime($aValue['FDXrcRefDate'])))
                                ->setCellValue('C' . $nStartRowData, '  ' . $aValue["FTRcvName"])
                                ->setCellValue('D' . $nStartRowData, '  ' . $aValue["FTXrcAmt"])
                                ->setCellValue('E' . $nStartRowData, '  ' . number_format($aValue["FCXrcNet"], $this->nOptDecimalShow));

                        // รูปแบบตัวอักษร
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':E' . $nStartRowData)->applyFromArray($aStyleBold);
                        // จัดตัวอักษรชิดขวา
                        $objPHPExcel->getActiveSheet()->getStyle("D" . $nStartRowData . ":E" . $nStartRowData)
                                ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                        $nStartRowData += 1;
                    }
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $nStartRowData, '  ')
                            ->setCellValue('B' . $nStartRowData, '  ' . $aValue['FTPosCode'])
                            ->setCellValue('C' . $nStartRowData, '  ' . $aValue['FTXrcRefNo1'])
                            ->setCellValue('D' . $nStartRowData, '  ' . '')
                            ->setCellValue('E' . $nStartRowData, '  ' . '');

                    // ตัวอักษรชิดขวา
                    $objPHPExcel->getActiveSheet()->getStyle("B" . $nStartRowData . ":B" . $nStartRowData)
                            ->getAlignment()
                            ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    $nLastRowNuber = $nStartRowData;
                    $nStartRowData++;
                }

                // Set Footer Summary
                $nEndRow = $nStartRowData;
                $nSummaryRow = $nEndRow;

                $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A" . $nSummaryRow, '  ' . $this->aText['tRptSaleByPaymentDetailTotalFooter'])
                        ->setCellValue("E" . $nSummaryRow, '  ' . number_format($aValue['rcSumFootTotal'], 2));

                // กำหนด Style Font Summary
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nSummaryRow . ':E' . $nSummaryRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nSummaryRow . ':E' . $nSummaryRow)->applyFromArray($aStyleRptHeadderTable);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nSummaryRow . ':E' . $nSummaryRow)->applyFromArray(array(
                    'borders' => array(
                        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                    )
                ));
                // จัดตัวอักษรชิดขวา
                $objPHPExcel->getActiveSheet()->getStyle("B" . $nSummaryRow . ':E' . $nSummaryRow)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                // Export File Excel
                $tFilename = 'ReportCard8-' . date("dmYhis") . '.xlsx';

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

                if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode)) {
                    mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode);
                }

                if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode)) {
                    mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode);
                }

                $tPathExport = APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode . '/';

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
                    'tPathFolder' => 'application/modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode . '/',
                    'tMessage' => "Export File Successfully."
                );
            } else {
                $aResponse = array(
                    'nStaExport' => '800',
                    'tMessage' => $this->aText['tRptDataReportNotFound']
                );
            }
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaExport' => '500',
                'tMessage' => $Error->getMessage()
            );
        }
        return $aResponse;
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: Object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp() {
        try {
            $aCountRowInTempParams = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
            ];

            $nDataCountPage = $this->mRptSaleByPaymentDetail->FSnMCountRowInTemp($aCountRowInTempParams);

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
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $dDateSendMQ = date('Y-m-d');
            $dTimeSendMQ = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');

            // Set QueueName 
            $tRptQueueName = 'RPT_' . $this->tRptGroup . '_' . $this->tRptCode;
            // Data Params Report
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
                    'ptDate' => $dDateSendMQ,
                    'ptTime' => $dTimeSendMQ,
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
                    'pdDateSubscribe' => $dDateSubscribe,
                    'pdTimeSubscribe' => $dTimeSubscribe,
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

