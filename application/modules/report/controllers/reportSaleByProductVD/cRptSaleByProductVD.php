<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptSaleByProductVD extends MX_Controller {

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
    public $aDataAddress = [];

    /**
     * User Login Session
     * @var string 
     */
    public $tUserLoginCode;

    public function __construct() {
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/rptsalebyproductVD/mRptSaleByProductVD');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = array(
            'tTitleReport' => language('report/report/report', 'tRptTitsaleVD'),
            'tDatePrint'   => language('report/report/report', 'tRptAdjStkVDDatePrint'),
            'tTimePrint'   => language('report/report/report', 'tRptAdjStkVDTimePrint'),
            // Filter Heard Report
            'tRptBchFrom'   => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'     => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'  => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'    => language('report/report/report', 'tRptShopTo'),
            'tPdtCodeFrom'  => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo'    => language('report/report/report', 'tPdtCodeTo'),
            'tPdtGrpFrom'   => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'     => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom'  => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'    => language('report/report/report', 'tPdtTypeTo'),
            'tRptDateFrom'  => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'    => language('report/report/report', 'tRptDateTo'),
            // Address Language
            'tRptAddrBuilding'      => language('report/report/report', 'tRptAddrBuilding'),
            'tRptAddrRoad'          => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi'           => language('report/report/report', 'tRptAddrSoi'),
            'tRptAddrSubDistrict'   => language('report/report/report', 'tRptAddrSubDistrict'),
            'tRptAddrDistrict' => language('report/report/report', 'tRptAddrDistrict'),
            'tRptAddrProvince' => language('report/report/report', 'tRptAddrProvince'),
            'tRptAddrTel' => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax' => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrBranch' => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddV2Desc1' => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2' => language('report/report/report', 'tRptAddV2Desc2'),
            // Table Label
            'tRptBillNo'        => language('report/report/report', 'tRptBillNo'),
            'tRptDate'          => language('report/report/report', 'tRptDate'),
            'tRptProduct'       => language('report/report/report', 'tRptProduct'),
            'tRptCabinetnumber' => language('report/report/report', 'tRptCabinetnumber'),
            'tRptPrice'         => language('report/report/report', 'tRptPrice'),
            'tRptPriceVD'       => language('report/report/report', 'tRptPriceVD'),
            'tRptSales'         => language('report/report/report', 'tSales'),
            'tRptDiscount'      => language('report/report/report', 'tDiscount'),
            'tRptTax'           => language('report/report/report', 'tRptTax'),
            'tRptGrand'         => language('report/report/report', 'tRptGrand'),
            'tRptTotalSub'      => language('report/report/report', 'tRptTotalSub'),
            'tRptTotalFooter'   => language('report/report/report', 'tRptTotalFooter'),
            'tRptBarchName'     => language('report/report/report', 'tRptBarchName'),
            'tRptPdtCode'       => language('report/report/report', 'tRptPdtCode'),
            'tRptPdtName'       => language('report/report/report', 'tRptPdtName'),
            'tRptUnit'          => language('report/report/report', 'tRptUnit'),
            'tRptAveragePrice'  => language('report/report/report', 'tRptAveragePrice'),
            'tTotalsales'       => language('report/report/report', 'tTotalsales'),
            'tRptTaxSalePosTel' => language('report/report/report', 'tRptTaxSalePosTel'),
            'tRptTaxSalePosFax' => language('report/report/report', 'tRptTaxSalePosFax'),
            'tRptTaxSalePosBch' => language('report/report/report', 'tRptTaxSalePosBch'),
            'tRptRentAmtFolCourSumText'     => language('report/report/report', 'tRptRentAmtFolCourSumText'),
            'tRptByBillTotal'               => language('report/report/report', 'tRptByBillTotal'),
            'tRptDataReportNotFound'        => language('report/report/report', 'tRptDataReportNotFound'),
            'tRptTaxSalePosFilterBchFrom'   => language('report/report/report', 'tRptTaxSalePosFilterBchFrom'),
            'tRptTaxSalePosFilterBchTo'     => language('report/report/report', 'tRptTaxSalePosFilterBchTo'),
            'tRptMerFrom'   => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'     => language('report/report/report', 'tRptMerTo'),
            'tRptPosFrom'   => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'     => language('report/report/report', 'tRptPosTo'),
            'tRptTaxSalePosFilterDocDateFrom' => language('report/report/report', 'tRptTaxSalePosFilterDocDateFrom'),
            'tRptTaxSalePosFilterDocDateTo'   => language('report/report/report', 'tRptTaxSalePosFilterDocDateTo'),
            'tPdtGrpFrom'   => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'     => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom'  => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'    => language('report/report/report', 'tPdtTypeTo'),
            // No Data Report
            'tRptNoData' => language('common/main/main', 'tCMNNotFoundData')
        );

        $this->tBchCodeLogin = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        // $this->nPerPage = 100;
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
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nLangID'      => $this->nLngID,
                //สาขา(Branch)
                'tBchCodeFrom'    => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
                'tBchNameFrom'    => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
                'tBchCodeTo'      => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
                'tBchNameTo'      => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
                //กลุ่มธุรกิจ
                'tRptMerCodeFrom' => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
                'tRptMerNameFrom' => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
                'tRptMerCodeTo'   => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
                'tRptMerNameTo'   => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
                //ร้านค้า
                'tRptShpCodeFrom' => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
                'tRptShpNameFrom' => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
                'tRptShpCodeTo'   => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
                'tRptShpNameTo'   => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
                //เครื่องจุดขาย
                'tRptPosCodeFrom' => !empty($this->input->post('oetRptPosCodeFrom')) ? $this->input->post('oetRptPosCodeFrom') : "",
                'tRptPosNameFrom' => !empty($this->input->post('oetRptPosNameFrom')) ? $this->input->post('oetRptPosNameFrom') : "",
                'tRptPosCodeTo'   => !empty($this->input->post('oetRptPosCodeTo')) ? $this->input->post('oetRptPosCodeTo') : "",
                'tRptPosNameTo'   => !empty($this->input->post('oetRptPosNameTo')) ? $this->input->post('oetRptPosNameTo') : "",
                //สินค้า
                'tRptPdtCodeFrom' => !empty($this->input->post('oetRptPdtCodeFrom')) ? $this->input->post('oetRptPdtCodeFrom') : "",
                'tRptPdtNameFrom' => !empty($this->input->post('oetRptPdtNameFrom')) ? $this->input->post('oetRptPdtNameFrom') : "",
                'tRptPdtCodeTo'   => !empty($this->input->post('oetRptPdtCodeTo')) ? $this->input->post('oetRptPdtCodeTo') : "",
                'tRptPdtNameTo'   => !empty($this->input->post('oetRptPdtNameTo')) ? $this->input->post('oetRptPdtNameTo') : "",
                //กลุ่มสินค้า
                'tRptPdtGrpCodeFrom' => !empty($this->input->post('oetRptPdtGrpCodeFrom')) ? $this->input->post('oetRptPdtGrpCodeFrom') : "",
                'tRptPdtGrpNameFrom' => !empty($this->input->post('oetRptPdtGrpNameFrom')) ? $this->input->post('oetRptPdtGrpNameFrom') : "",
                'tRptPdtGrpCodeTo'   => !empty($this->input->post('oetRptPdtGrpCodeTo')) ? $this->input->post('oetRptPdtGrpCodeTo') : "",
                'tRptPdtGrpNameTo'   => !empty($this->input->post('oetRptPdtGrpNameTo')) ? $this->input->post('oetRptPdtGrpNameTo') : "",
                //ประเภทสินค้า
                'tRptPdtTypeCodeFrom' => !empty($this->input->post('oetRptPdtTypeCodeFrom')) ? $this->input->post('oetRptPdtTypeCodeFrom') : "",
                'tRptPdtTypeNameFrom' => !empty($this->input->post('oetRptPdtTypeNameFrom')) ? $this->input->post('oetRptPdtTypeNameFrom') : "",
                'tRptPdtTypeCodeTo'   => !empty($this->input->post('oetRptPdtTypeCodeTo')) ? $this->input->post('oetRptPdtTypeCodeTo') : "",
                'tRptPdtTypeNameTo'   => !empty($this->input->post('oetRptPdtTypeNameTo')) ? $this->input->post('oetRptPdtTypeNameTo') : "",
                // วันที่เอกสาร(DocNo)
                'tDocDateFrom'        => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
                'tDocDateTo'          => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $aRetrun = $this->mRptSaleByProductVD->FSnMExecStoreReport($this->aRptFilter);
            // print_r($aRetrun );
            // exit;
            $aDataSwitchCase = array(
                'ptRptRoute'      => $this->tRptRoute,
                'ptRptCode'       => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter'    => $this->aRptFilter
            );
    
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp($aDataSwitchCase);
                    break;
                case 'pdf':
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    break;
            }
        }
    }

    // Functionality: Click Page Report (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 16/08/2019 Wasin(Yoshi)
    // LastUpdate: 21/08/2019 Saharat(Golf)
    // Return: object Status Count Data Report
    // ReturnType: Object
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase){
        try{
            $aDataCountData = [
                'tCompName'     => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode'      => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tSessionID'    => $this->tUserSessionID,
            ];

            $nDataCountPage = $this->mRptSaleByProductVD->FSnMCountRowInTemp($aDataCountData);

            $aResponse      =  array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent'     => 1,
                'tMessage'      => 'Success Count Data All'
            );
        }catch(ErrorException $Error){
            $aResponse =  array(
                'nStaEvent' => 500,
                'tMessage'  => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

    /**
     * Functionality: Send Rabbit MQ Report
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: 17/10/2019 Napat(Jame)
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $tRptGrpCode        = $this->tRptGroup;
            $tRptCode           = $this->tRptCode;
            $tUserCode          = $this->tUserLoginCode;
            $tSessionID         = $this->tUserSessionID;
            $nLangID            = FCNaHGetLangEdit();
            $tRptExportType     = $this->tRptExportType;
            $tCompName          = $this->tCompName;
            $dDateSendMQ        = date('Y-m-d');
            $dTimeSendMQ        = date('H:i:s');
            $dDateSubscribe     = date('Ymd');
            $dTimeSubscribe     = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' . $tRptGrpCode . '_' . $tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode'         => $tRptCode,
                    'pnPerFile'         => 20000,
                    'ptUserCode'        => $tUserCode,
                    'ptUserSessionID'   => $tSessionID,
                    'pnLngID'           => $nLangID,
                    'ptFilter'          => $this->aRptFilter,
                    'ptRptExpType'      => $tRptExportType,
                    'ptComName'         => $tCompName,
                    'ptDate'            => $dDateSendMQ,
                    'ptTime'            => $dTimeSendMQ,
                    'ptBchCode'         => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
                ]
            ];

            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptComName' => $tCompName,
                    'ptRptCode' => $tRptCode,
                    'ptUserCode' => $tUserCode,
                    'ptUserSessionID' => $tSessionID,
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

    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {
        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'      => $this->nPerPage,
            'nPage'         => '1', // เริ่มทำงานหน้าแรก
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        );
        // print_r($aDataWhereRpt);
        // exit;
        $aDataReport = $this->mRptSaleByProductVD->FSaMGetDataReport($aDataWhereRpt);
        
        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $this->aRptFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rptSaleByProductVD', 'wRptSaleByProductVDHtml', $aDataViewRpt);
        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tRptView,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => array(
                'raItems' => $aDataReport['aRptData'],
                'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success',
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }


    
    // Functionality: Function Count Data Report And Calcurate
    // Parameters:  Function Parameter
    // Creator: 10/10/2019 Saharat(Golf)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptRenderExcel($paDataSwitchCase) {
        try{
            $tRptRoute      = $paDataSwitchCase['ptRptRoute'];
            $tRptCode       = $paDataSwitchCase['ptRptCode'];
            $tRptTypeExport = $paDataSwitchCase['ptRptTypeExport'];
            $aDataFilter    = $paDataSwitchCase['paDataFilter'];
            $nPage = 1;
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tUsrSessionID  = $this->session->userdata('tSesSessionID');
            $aDataAddress   = $this->aCompanyInfo;

            // Get data Company
            // $aDataAddress = array();
            // $tAPIReq = "";
            // $tMethodReq = "GET";
            // $aDataWhereComp = array('FNLngID' => $nLangEdit);
            // $aCompData = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);

            // if ($aCompData['rtCode'] == '1') {
            //     $tCompName = $aCompData['raItems']['rtCmpName'];
            //     $tBchCode = $aCompData['raItems']['rtCmpBchCode'];
            //     $aDataAddress = $this->mReport->FSaMRptGetDataAddressByBranchComp($tBchCode, $nLangEdit);
            // } else {
            //     $tCompName = "-";
            //     $tBchCode = "-";
            //     $aDataAddress = array();
            // }


            

            $tReportName    =  $this->aText['tTitleReport'];
            $dDateExport    = date('Y-m-d');
            $tTime          = date('H:i:s');

            $aCompInfoParams    = ['nLngID' => FCNaHGetLangEdit()];
            // $aCompData = FCNaGetCompanyInfo($aCompInfoParams);

           $aDataReportParams = [
                'nPerPage' => $this->nPerPage,
                'nPage' => $this->nPage,
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
            ];
       
            $aDataReport = $this->mRptSaleByProductVD->FSaMGetDataReport($aDataReportParams);
        
             /** =============================================================================================== */
            // ตั้งค่า Font Style
            $aStyleRptFont              = array('font' => array('name' => 'TH Sarabun New'));
            $aStyleRptSizeTitleName     = array('font' => array('size' => 14));
            $aStyleRptSizeCompName      = array('font' => array('size' => 12));
            $aStyleRptSizeAddressFont   = array('font' => array('size' => 12));
            $aStyleRptHeadderTable      = array('font' => array('size' => 12, 'color' => array('rgb' => '000000')));
            $aStyleRptDataTable         = array('font' => array('size' => 10, 'color' => array('rgb' => '000000')));

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
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20); 
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20); 

            // ชื่อหัวรายงาน
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tReportName);
            $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptSizeTitleName);

            // Check Address Data
            if (isset($aDataAddress) && !empty($aDataAddress)) {
                // Company Name
                $tRptCompName = (empty($aDataAddress['FTCmpName'])) ? '-' : $aDataAddress['FTCmpName'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $tRptCompName)->getStyle('A2')->applyFromArray($aStyleRptSizeCompName);

                // Check Vertion Address
                if ($aDataAddress['FTAddVersion'] == 1) {
                    // Check Address Line 1
                    $tRptAddV1No = (empty($aDataAddress['FTAddV1No'])) ? '-' : $aDataAddress['FTAddV1No'];
                    $tRptAddV1Village = (empty($aDataAddress['FTAddV1Village'])) ? '-' : $aDataAddress['FTAddV1Village'];
                    $tRptAddV1Road = (empty($aDataAddress['FTAddV1Road'])) ? '-' : $aDataAddress['FTAddV1Road'];
                    $tRptAddV1Soi = (empty($aDataAddress['FTAddV1Soi'])) ? '-' : $aDataAddress['FTAddV1Soi'];
                    $tRptAddressLine1 = $tRptAddV1No . ' ' . $tRptAddV1Village . ' ' . $this->aText['tRptAddrRoad'] . ' ' . $tRptAddV1Road . ' ' . $tRptAddV1Soi;
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
                if (isset($aDataAddress['FTCmpTel']) && !empty($aDataAddress['FTCmpTel'])) {
                    $tRptCompTel = $aDataAddress['FTCmpTel'];
                } else {
                    $tRptCompTel = '-';
                }
                $tRptCompTelText = $this->aText['tRptAddrTel'] . ' ' . $tRptCompTel;

                // Check Data Fax Number
                if (isset($aDataAddress['FTCmpFax']) && !empty($aDataAddress['FTCmpFax'])) {
                    $tRptCompFax = $aDataAddress['FTCmpFax'];
                } else {
                    $tRptCompFax = '-';
                }
                $tRptCompFaxText = $this->aText['tRptAddrFax'] . ' ' . $tRptCompFax;
                
                $tRptAddressLine4 = $tRptCompTelText . ' ' . $tRptCompFaxText;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tRptAddressLine4)->getStyle('A5')->applyFromArray($aStyleRptSizeAddressFont);

                
                // Check Branch
                if(isset($aDataAddress['FTBchName']) && !empty($aDataAddress['FTBchName'])) {
                    $tRptCompBch = $aDataAddress['FTBchName'];
                }else{
                    $tRptCompBch = '-';
                }
                $tRptAddressLine5 = $this->aText['tRptAddrBranch'] . ' ' . $tRptCompBch;
                
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tRptAddressLine5)->getStyle('A6')->applyFromArray($aStyleRptSizeAddressFont);
            }

            // Row เริ่มต้นของ Filter
            $nStartRowFillter = 2;
            $tFillterColumLEFT = "C";
            $tFillterColumRIGHT = "F";

            // Fillter Banch (สาขา)
            if (!empty($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeTo'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tRptTaxSalePosFilterBchFrom'] . ' ' . $aDataFilter['tBchNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tRptTaxSalePosFilterBchTo'] . ' ' . $aDataFilter['tBchNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter MerChant (กลุ่มธุรกิจ)
            if (!empty($aDataFilter['tRptMerCodeFrom']) && !empty($aDataFilter['tRptMerCodeFrom'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tRptMerFrom'] . ' ' . $aDataFilter['tRptMerNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tRptMerTo'] . ' ' . $aDataFilter['tRptMerNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Shop (ร้านค้า)
            if (!empty($aDataFilter['tRptShpCodeFrom']) && !empty($aDataFilter['tRptShpCodeTo'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tRptShopFrom'] . ' ' . $aDataFilter['tRptShpNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tRptShopTo'] . ' ' . $aDataFilter['tRptShpNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter POS (เครื่องจุดขาย)
            if (!empty($aDataFilter['RptPosCodeFrom']) && !empty($aDataFilter['tRptPosCodeTo'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tRptPosFrom'] . ' ' . $aDataFilter['tRptPosNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tRptPosTo'] . ' ' . $aDataFilter['tRptPosNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Product (สินค้า)
            if (!empty($aDataFilter['tRptPdtCodeFrom']) && !empty($aDataFilter['tRptPdtCodeTo'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tPdtCodeFrom'] . ' ' . $aDataFilter['tRptPdtNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tPdtCodeTo'] . ' ' . $aDataFilter['tRptPdtNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }
            
            // Fillter ProductGroup (กลุ่มสินค้า)
            if (!empty($aDataFilter['tRptPdtGrpCodeFrom']) && !empty($aDataFilter['tRptPdtGrpCodeTo'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tPdtGrpFrom'] . ' ' . $aDataFilter['tRptPdtGrpNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tPdtGrpTo'] . ' ' . $aDataFilter['tRptPdtGrpNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }
            
            // Fillter ProductType (ประเภทสินค้า)
            if (!empty($aDataFilter['tRptPdtTypeCodeFrom']) && !empty($aDataFilter['tRptPdtTypeCodeTo'])) {
                $tRptFilterRcvCodeFrom = $this->aText['tPdtTypeFrom'] . ' ' . $aDataFilter['tRptPdtTypeNameFrom'];
                $tRptFilterRcvCodeTo = $this->aText['tPdtTypeTo'] . ' ' . $aDataFilter['tRptPdtTypeNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }
            // Fillter DocDate (วันที่สร้างเอกสาร)
            if (!empty($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateTo'])) {
                $tRptFilterDocDateFrom = $this->aText['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom'];
                $tRptFilterDocDateTo = $this->aText['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo'];
                $tRptTextLeftRightFilter = $tRptFilterDocDateFrom . ' ' . $tRptFilterDocDateTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }
            

                // ========================================================================== Date Time Print =========================================================================
                $tRptDateTimeExportText = $this->aText['tDatePrint'] . ' ' . $dDateExport . ' ' . $this->aText['tTimePrint'] . ' ' . $tTime;
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:I7');
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', $tRptDateTimeExportText);
                $objPHPExcel->getActiveSheet()->getStyle("A7")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($aStyleRptSizeAddressFont);
                // ====================================================================================================================================================================


                // ==================================================================== หัวตารางรายงาน ==================================================================================
                // กำหนดจุดเริ่มต้นของแถวหัวตาราง 
                $nStartRowHeadder = 8;

                // กำหนด Style Font ของหัวตาราง
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->applyFromArray(array(
                    'borders' => array(
                        'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                        'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                    )
                ));

                // กำหนดข้อมูลลงหัวตาราง
                $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $nStartRowHeadder, $this->aText['tRptBillNo'])
                ->setCellValue('B' . $nStartRowHeadder, $this->aText['tRptDate'])
                ->setCellValue('C' . $nStartRowHeadder, $this->aText['tRptProduct'])
                ->setCellValue('D' . $nStartRowHeadder, $this->aText['tRptCabinetnumber'])
                ->setCellValue('E' . $nStartRowHeadder, $this->aText['tRptPriceVD'])
                ->setCellValue('F' . $nStartRowHeadder, $this->aText['tRptSales'])
                ->setCellValue('G' . $nStartRowHeadder, $this->aText['tRptDiscount'])
                ->setCellValue('H' . $nStartRowHeadder, $this->aText['tRptTax'])
                ->setCellValue('I' . $nStartRowHeadder, $this->aText['tRptGrand']);

                // Alignment ของหัวตาราง
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

                 // Set Variable Data
            $nStartRowData = $nStartRowHeadder + 1;
            if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
 
                // ******* Step 1 ประกาศตัวแปรใช้ในการเช็คเงื่อนไข
                $tGrouppingData = "";
                $nGroupMember = "";
                $nRowPartID = "";

                $nXsdQty         = 0;
                $nXsdAmtB4DisChg = 0;
                $nXsdDi        = 0;
                $nXsdNetAfHD   = 0;

                $nXsdQtyFooter          = 0;
                $nXsdAmtB4DisChgFooter  = 0;
                $nXsdDisFooter          = 0;
                $nXsdNetAfHDFooter      = 0;

    
                foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                   
                    // ******* Step 3 Set ค่า Value FNRptGroupMember And FNRowPartID
                    $nGroupMember = $aValue["FNRptGroupMember"];
                    $nRowPartID = $aValue["FNRowPartID"];

                    // ******* Step 4 : Check Groupping Create Row Groupping 
                    if ($tGrouppingData != $aValue['FTXshDocNo']) {
                        // $tTextLabelGroupping = $this->aText['tRptBarchName'].' : ' . $aValue['FTXshDocNo'].' '.$aValue['FDXshDocDate'];
                        $tTextLabelGroupping     = $aValue['FTXshDocNo'];
                        $tTextLabelGrouppingDate = $aValue['FDXshDocDate'];
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $tTextLabelGroupping);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $nStartRowData, $tTextLabelGrouppingDate);
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('C' . $nStartRowData . ':I' . $nStartRowData);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
                        $nStartRowData++;
                    }

                    // ******* Step 5 : Loop Set Data Value 
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('A' . $nStartRowData, '')
                            ->setCellValue('B' . $nStartRowData, '')
                            ->setCellValue('C' . $nStartRowData, $aValue['FTXsdPdtName'])
                            ->setCellValue('D' . $nStartRowData, number_format($aValue["FCXsdQty"],2))
                            ->setCellValue('E' . $nStartRowData, number_format($aValue["FCXsdSetPrice"],2))
                            ->setCellValue('F' . $nStartRowData, number_format($aValue["FCXsdAmtB4DisChg"],2))
                            ->setCellValue('G' . $nStartRowData, number_format($aValue["FCXsdDis"],2))
                            ->setCellValue('H' . $nStartRowData, number_format($aValue["FCXsdVat"],2))
                            ->setCellValue('I' . $nStartRowData, number_format($aValue["FCXsdNetAfHD"],2));


                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':C' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    // ******* Step 6 : เตรียม Parameter สำหรับ Summary Sub Footer
                    if ($nRowPartID == $nGroupMember) {
                        $nStartRowData++;
                        $nXsdQty         = number_format($aValue["FCXsdQty_SUM"],2);
                        $nXsdAmtB4DisChg = number_format($aValue["FCXsdAmtB4DisChg_SUM"],2);
                        $nXsdDi          = number_format($aValue["FCXsdDis_SUM"],2);
                        $nXsdNetAfHD     = number_format($aValue["FCXsdNetAfHD_SUM"],2);
                        $nXsdVat         = number_format($aValue["FCXsdVat_SUM"],2);
                   

                        // Set Color Row Sub Footer
                        $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->applyFromArray(array(
                            'borders' => array(
                                // 'top'       => array('style' => PHPExcel_Style_Border::BORDER_THIN,'color' => array('rgb' => '000000')),
                                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                            )
                        ));

                        // LEFT 
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':C' . $nStartRowData);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptRentAmtFolCourSumText']);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                        // RIGHT
                        $objPHPExcel->setActiveSheetIndex(0)
                                ->setCellValue('D' . $nStartRowData, $nXsdQty)
                                ->setCellValue('F' . $nStartRowData, $nXsdAmtB4DisChg)
                                ->setCellValue('G' . $nStartRowData, $nXsdDi)
                                ->setCellValue('H' . $nStartRowData, $nXsdVat)
                                ->setCellValue('I' . $nStartRowData, $nXsdNetAfHD);
                                $objPHPExcel->getActiveSheet()->getStyle('I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                        $nStartRowData++;
                    }

                    $nXsdQtyFooter           = number_format($aValue["FCXsdQty_Footer"], 2);
                    $nXsdAmtB4DisChgFooter   = number_format($aValue["FCXsdAmtB4DisChg_Footer"], 2);
                    $nXsdDisFooter           = number_format($aValue["FCXsdDis_Footer"], 2);
                    $nXsdNetAfHDFooter       = number_format($aValue["FCXsdNetAfHD_Footer"], 2);
                    $nXsdVatFooter           =  number_format($aValue["FCXsdVat_Footer"],2);
                    
                    // ******* Step 2 Set ค่า Value ให้กับตัวแปร
                    $tGrouppingData = $aValue["FTXshDocNo"];
                    $nStartRowData++;
                }

                // Step 7 : Set Footer Text
                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                if ($nPageNo == $nTotalPage) {
                    $nStartRowData--;
                    // Set Color Row Sub Footer
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->applyFromArray(array(
                        'borders' => array(
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => '000000'))
                        )
                    ));

                    // LEFT 
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':C' . $nStartRowData);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptByBillTotal']);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                    // RIGHT
                    $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('D' . $nStartRowData, $nXsdQtyFooter)
                            ->setCellValue('F' . $nStartRowData, $nXsdAmtB4DisChgFooter)
                            ->setCellValue('G' . $nStartRowData, $nXsdDisFooter)
                            ->setCellValue('H' . $nStartRowData, $nXsdVatFooter)
                            ->setCellValue('I' . $nStartRowData, $nXsdNetAfHDFooter);
                            $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                            $objPHPExcel->getActiveSheet()->getStyle('I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                }
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':I' . $nStartRowData);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptByBillTotal']);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
            }






            //  ======================================================= Set Content Type Export File Excel =======================================================
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
           

        }catch(Exception $Error){
           $aResponse   = array(
               'nStaExport' => 500,
               'tMessage'   => $Error->getMessage()
           );
        }
        echo json_encode($aResponse);
    }

     

}


