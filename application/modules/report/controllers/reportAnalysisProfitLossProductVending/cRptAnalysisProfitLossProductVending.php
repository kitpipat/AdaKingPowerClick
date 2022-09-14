<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptAnalysisProfitLossProductVending extends MX_Controller {

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
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportAnalysisProfitLossProductVending/mRptAnalysisProfitLossProductVending');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = [
            'tTitleReport'      => language('report/report/report', 'tRptAnalysisProfitLossProductVending'),
            'tRptTaxNo'         => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'     => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'    => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'     => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'     => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch'        => language('report/report/report', 'tRptBranch'),
            'tRptFaxNo'         => language('report/report/report', 'tRptFaxNo'),
            'tRptTel'           => language('report/report/report', 'tRptTel'),
            // Filter Heard Report
            // สาขา
            'tRptBchFrom'       => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'         => language('report/report/report', 'tRptBchTo'),
            //กลุ่มธุรกิจ
            'tRptMerFrom'       => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'         => language('report/report/report', 'tRptMerTo'),
            //ร้านค้า
            'tRptShopFrom'      => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'        => language('report/report/report', 'tRptShopTo'),
            // เครื่องจุดขาย
            'tRptPosFrom'       => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'         => language('report/report/report', 'tRptPosTo'),
            //สินค้า
            'tRptPdtCodeFrom'   => language('report/report/report', 'tPdtCodeFrom'),
            'tRptPdtCodeTo'     => language('report/report/report', 'tPdtCodeTo'),
            // กลุ่มสินค้า
            'tRptPdtGrpFrom'    => language('report/report/report', 'tPdtGrpFrom'),
            'tRptPdtGrpTo'      => language('report/report/report', 'tPdtGrpTo'),
            // ประเภทสินค้า
            'tRptPdtTypeFrom'   => language('report/report/report', 'tPdtTypeFrom'),
            'tRptPdtTypeTo'     => language('report/report/report', 'tPdtTypeTo'),
            //วันที่
            'tRptDateFrom'      => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'        => language('report/report/report', 'tRptDateTo'),
            // Table Report
            'tRptPdtCode'       => language('report/report/report', 'tRptPdtCode'),
            'tRptPdtName'       => language('report/report/report', 'tRptPdtName'),
            'tRptPdtGrp'        => language('report/report/report', 'tRptPdtGrp'),
            'tRptQtySale'       => language('report/report/report', 'tRptQtySale'),
            'tRptCabinetCost'   => language('report/report/report', 'tRptCabinetCost'),
            'tRptGrandSale'     => language('report/report/report', 'tRptGrandSale'),
            'tRptProfitloss'    => language('report/report/report', 'tRptProfitloss'),
            'tRptCost'          => language('report/report/report', 'tRptCost'),
            'tRptSalesVending'  => language('report/report/report', 'tRptSalesVending'),
            'tRptOverall'       => language('report/report/report', 'tRptOverall'),
            'tRptAddrRoad'      => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi'       => language('report/report/report', 'tRptAddrSoi'),
            'tRptNoData'        => language('report/report/report', 'tRptNoData'),
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
            'tUserSession'  => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'nLangID'       => $this->nLngID,
            // สาขา(Branch)
            'tBchCodeFrom'  => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'  => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'    => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'    => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            //กลุ่มธุรกิจ(MerChant)
            'tMerCodeFrom'  => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom'  => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo'    => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo'    => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            // ร้านค้า(Shop)
            'tShpCodeFrom'  => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'  => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'    => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'    => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            //เครื่องจุดขาย
            'tPosCodeFrom'  => !empty($this->input->post('oetRptPosCodeFrom')) ? $this->input->post('oetRptPosCodeFrom') : "",
            'tPosNameFrom'  => !empty($this->input->post('oetRptPosNameFrom')) ? $this->input->post('oetRptPosNameFrom') : "",
            'tPosCodeTo'    => !empty($this->input->post('oetRptPosCodeTo')) ? $this->input->post('oetRptPosCodeTo') : "",
            'tPosNameTo'    => !empty($this->input->post('oetRptPosNameTo')) ? $this->input->post('oetRptPosNameTo') : "",
            //สินค้า
            'tPdtCodeFrom'  => !empty($this->input->post('oetRptPdtCodeFrom')) ? $this->input->post('oetRptPdtCodeFrom') : "",
            'tPdtNameFrom'  => !empty($this->input->post('oetRptPdtNameFrom')) ? $this->input->post('oetRptPdtNameFrom') : "",
            'tPdtCodeTo'    => !empty($this->input->post('oetRptPdtCodeTo')) ? $this->input->post('oetRptPdtCodeTo') : "",
            'tPdtNameTo'    => !empty($this->input->post('oetRptPdtNameTo')) ? $this->input->post('oetRptPdtNameTo') : "",
            //กลุ่มสินค้า
            'tPdtGrpCodeFrom'   => !empty($this->input->post('oetRptPdtGrpCodeFrom')) ? $this->input->post('oetRptPdtGrpCodeFrom') : "",
            'tPdtGrpNameFrom'   => !empty($this->input->post('oetRptPdtGrpNameFrom')) ? $this->input->post('oetRptPdtGrpNameFrom') : "",
            'tPdtGrpCodeTo'     => !empty($this->input->post('oetRptPdtGrpCodeTo')) ? $this->input->post('oetRptPdtGrpCodeTo') : "",
            'tPdtGrpNameTo'     => !empty($this->input->post('oetRptPdtGrpNameTo')) ? $this->input->post('oetRptPdtGrpNameTo') : "",
            //ประเภทสินค้า
            'tPdtTypeCodeFrom'  => !empty($this->input->post('oetRptPdtTypeCodeFrom')) ? $this->input->post('oetRptPdtTypeCodeFrom') : "",
            'tPdtTypeNameFrom'  => !empty($this->input->post('oetRptPdtTypeNameFrom')) ? $this->input->post('oetRptPdtTypeNameFrom') : "",
            'tPdtTypeCodeTo'    => !empty($this->input->post('oetRptPdtTypeCodeTo')) ? $this->input->post('oetRptPdtTypeCodeTo') : "",
            'tPdtTypeNameTo'    => !empty($this->input->post('oetRptPdtTypeNameTo')) ? $this->input->post('oetRptPdtTypeNameTo') : "",
            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'      => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'        => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
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
            $this->mRptAnalysisProfitLossProductVending->FSnMExecStoreCReport($this->aRptFilter);

            $aDataSwitchCase = array(
                'ptRptRoute' => $this->tRptRoute,
                'ptRptCode' => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter' => $this->aRptFilter
            );


            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp($aDataSwitchCase);
                    break;
                case 'pdf' :
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 01/10/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {
        $aDataWhere = array(
            'tUserSession'  => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => 1, // เริ่มทำงานหน้าแรก
            'nRow' => $this->nPerPage,
        );


        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->mRptAnalysisProfitLossProductVending->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        // GetDataSumFootReport
        $aDataSumFoot = $this->mRptAnalysisProfitLossProductVending->FSaMGetDataSumFootReport($aDataWhere, $this->aRptFilter);

        // Call View Report
        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataSumFoot, $this->aRptFilter);

        $aDataView = array(
            'aCompanyInfo' => $this->aCompanyInfo,
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => $aDataReport,
            'aDataSumFoot' => $aDataSumFoot
        );

        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 02/10/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataSumFoot, $paDataFilter) {
        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\rptRptAnalysisProfitLossProductVending\rptRptAnalysisProfitLossProductVending.php';

        // Set Parameter To Report
        $oRptAnalysisProfitLossProductVending = new rptRptAnalysisProfitLossProductVending(array(
            'nCurrentPage' => $paDataReport['rnCurrentPage'],
            'nAllPage' => $paDataReport['rnAllPage'],
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aFilterReport' => $paDataFilter,
            'aDataTextRef' => $this->aText,
            'aDataReturn' => $paDataReport,
            'aDataSumFoot' => $paDataSumFoot
        ));

        $oRptAnalysisProfitLossProductVending->run();
        $tHtmlViewReport = $oRptAnalysisProfitLossProductVending->render('wRptAnalysisProfitLossProductVendingHtml', true);
        return $tHtmlViewReport;
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 02/10/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => $this->nPage,
            'nRow' => $this->nPerPage,
        );

        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->mRptAnalysisProfitLossProductVending->FSaMGetDataReport($aDataWhere, $aDataFilter);

        // GetDataSumFootReport
        $aDataSumFoot = $this->mRptAnalysisProfitLossProductVending->FSaMGetDataSumFootReport($aDataWhere, $aDataFilter);

        if (!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataSumFoot, $aDataFilter);
        } else {
            $tViewRenderKool = "";
        }

        $aDataView = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $aDataFilter,
            'aDataReport' => $aDataReport,
            'aDataSumFoot' => $aDataSumFoot
        );

        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 02/10/2019 "Witsarut"(Bell)
     * LastUpdate: -
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase) {
        try {
            $aDataCountData = [
                'tCompName' => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode' => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tUserSession' => $paDataSwitchCase['paDataFilter']['tUserSession'],
            ];

            $nDataCountPage = $this->mRptAnalysisProfitLossProductVending->FSnMCountDataReportAll($aDataCountData);

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
     * LastUpdate: -
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
                    'ptBchCode' => $this->tBchCodeLogin
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

    // Functionality: Function Count Data Report And Calcurate
    // Parameters:  Function Parameter
    // Creator: 11/10/2019 Witsarut
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptRenderExcel($paDataSwitchCase){
        try{
            $tRptRoute      = $this->tRptRoute;
            $tRptCode       = $this->tRptCode;
            $tRptTypeExport = $this->tRptExportType;
            $aDataFilter    = $this->aRptFilter;
            $nPage          = 1;
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tUsrSessionID  = $this->session->userdata('tSesSessionID');

            // Get data Company
            $aDataAddress       = array();
            $tAPIReq            = "";
            $tMethodReq         = "GET";
            $aDataWhereComp     = array('FNLngID' => $nLangEdit);
            $aCompData          = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);

            if($aCompData['rtCode'] == '1') {
                $tCompName      = $aCompData['raItems']['rtCmpName'];
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $aDataAddress   = $this->mReport->FSaMRptGetDataAddressByBranchComp($tBchCode, $nLangEdit);
            }else{
                $tCompName      = "-";
                $tBchCode       = "-";
                $aDataAddress   = array();
            }

            /** ================================== Begin Init Variable Excel ================================== */
            $tReportName    = $this->aText['tTitleReport'];
            $dDateExport    = date('Y-m-d');
            $tTime          = date('H:i:s');
            /** ===================================== End Init Variable ======================================= */
            /** ======================================= Begin Get Data ======================================== */
            // $aCompInfoParams    = ['nLngID' => FCNaHGetLangEdit()];
            // $aCompData          = FCNaGetCompanyInfo($aCompInfoParams);

            // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
            $aDataWhere = [
                'tRptCode'      => $this->tRptCode,
                'nPerPage'      => $this->nPerPage,
                'nPage'         => $this->nPage,
                'nRow'          => 100000,
                'tUserSession'  => $this->tUserSessionID,
                'tUserCode'     => $this->tUserLoginCode,
                'tCompName'     => $this->tCompName,
            ];

            //Get Data Report
            $aDataReport = $this->mRptAnalysisProfitLossProductVending->FSaMGetDataReport($aDataWhere, $this->aRptFilter);
            
            // GetDataSumFootReport
            $aDataSumFoot = $this->mRptAnalysisProfitLossProductVending->FSaMGetDataSumFootReport($aDataWhere, $this->aRptFilter);

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
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
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
            if (isset($this->aCompanyInfo) && !empty($this->aCompanyInfo )) {
                $tRptCompName = (empty($this->aCompanyInfo['FTCmpName'])) ? '-' : $this->aCompanyInfo['FTCmpName'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $tRptCompName)->getStyle('A2')->applyFromArray($aStyleRptSizeCompName);

                //Check Vertion Address
                if($this->aCompanyInfo['FTAddVersion'] == 1){
                     // Check Address Line 1
                     $tRptAddV1No = (empty($this->aCompanyInfo['FTAddV1No'])) ? '-' : $this->aCompanyInfo['FTAddV1No'];
                     $tRptAddV1Road = (empty($this->aCompanyInfo['FTAddV1Road'])) ? '-' : $this->aCompanyInfo['FTAddV1Road'];
                     $tRptAddV1Soi = (empty($this->aCompanyInfo['FTAddV1Soi'])) ? '-' : $this->aCompanyInfo['FTAddV1Soi'];
                     $tRptAddAdasoft = (empty($this->aCompanyInfo['FTAddV1Village'])) ? '-' : $this->aCompanyInfo['FTAddV1Village'];
                     $tRptAddressLine1 = $tRptAddV1No . ' '.$tRptAddAdasoft. ' ' . $this->aText['tRptAddrRoad'] . ' ' . $tRptAddV1Road . ' ' . $this->aText['tRptAddrSoi'] . ' ' . $tRptAddV1Soi;
                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddressLine1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    // Check Address Line 2
                    $tRptAddV1SubDistName = (empty($this->aCompanyInfo['FTSudName'])) ? '-' : $this->aCompanyInfo['FTSudName'];
                    $tRptAddV1DstName = (empty($this->aCompanyInfo['FTDstName'])) ? '-' : $this->aCompanyInfo['FTDstName'];
                    $tRptAddV1PvnName = (empty($this->aCompanyInfo['FTPvnName'])) ? '-' : $this->aCompanyInfo['FTPvnName'];
                    $tRptAddV1PostCode = (empty($this->aCompanyInfo['FTAddV1PostCode'])) ? '-' : $this->aCompanyInfo['FTAddV1PostCode'];
                    $tRptAddressLine2 = $tRptAddV1SubDistName . ' ' . $tRptAddV1DstName . ' ' . $tRptAddV1PvnName . ' ' . $tRptAddV1PostCode;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddressLine2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                }else{
                    $tRptAddV2Desc1 = (empty($this->aCompanyInfo['FTAddV2Desc1'])) ? '-' : $this->aCompanyInfo['FTAddV2Desc1'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddV2Desc1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    $tRptAddV2Desc2 = (empty($this->aCompanyInfo['FTAddV2Desc2'])) ? '-' : $this->aCompanyInfo['FTAddV2Desc2'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddV2Desc2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                }

                // Check Data Telephone Number
                if (isset($this->aCompanyInfo['FTCmpTel']) && !empty($this->aCompanyInfo['FTCmpTel'])) {
                    $tRptCompTel = $this->aCompanyInfo['FTCmpTel'];
                } else {
                    $tRptCompTel = '-';
                }

                if(isset($this->aCompanyInfo['FTCmpFax']) && !empty($this->aCompanyInfo['FTCmpFax'])) {
                    $tRptCmpFax = $this->aCompanyInfo['FTCmpFax'];
                }else{
                    $tRptCmpFax = '-';
                }
                $tRptCompTelText = $this->aText['tRptTel'] . ' ' . $tRptCompTel. ' ' .$this->aText['tRptFaxNo']. ' ' .$tRptCmpFax;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tRptCompTelText)->getStyle('A5')->applyFromArray($aStyleRptSizeAddressFont);

                //Check Data Branch
                if(isset($this->aCompanyInfo['FTBchName']) && !empty($this->aCompanyInfo['FTBchName'])){
                    $tRptBchName = $this->aCompanyInfo['FTBchName'];
                }else{
                    $tRptBchName = '-';
                }    
                $tRptBchName = $this->aText['tRptBranch'] . ' ' . $tRptBchName;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tRptBchName)->getStyle('A6')->applyFromArray($aStyleRptSizeAddressFont);            
            }

            // ======================================================================== Filter Data Report ========================================================================
            // // Row เริ่มต้นของ Filter
            $nStartRowFillter = 2;
            $tFillterColumLEFT = "D";
            $tFillterColumRIGHT = "F";


            // Fillter ฺBranch (สาขา)
            if (!empty($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeTo'])) {
                $tRptFilterBranchCodeFrom = $this->aText['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom'];
                $tRptFilterBranchCodeTo = $this->aText['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterBranchCodeFrom . ' ' . $tRptFilterBranchCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter MerChant (กลุ่มธุระกิจ)
            if (!empty($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeTo'])) {
                $tRptFilterMerCodeFrom = $this->aText['tRptMerFrom'] . ' ' . $aDataFilter['tMerNameFrom'];
                $tRptFilterMerCodeTo = $this->aText['tRptMerTo'] . ' ' . $aDataFilter['tMerNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterMerCodeFrom . ' ' . $tRptFilterMerCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }
            
            // Fillter Shop (ร้านค้า)
            if (!empty($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeTo'])) {
                $tRptFilterShopCodeFrom = $this->aText['tRptShopFrom'] . ' ' . $aDataFilter['tShpNameFrom'];
                $tRptFilterShopCodeTo = $this->aText['tRptShopTo'] . ' ' . $aDataFilter['tShpNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterShopCodeFrom . ' ' . $tRptFilterShopCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Pos (เครื่องจุดขาย)
            if (!empty($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeTo'])) {
                $tRptFilterPosCodeFrom = $this->aText['tRptPosFrom'] . ' ' . $aDataFilter['tPosNameFrom'];
                $tRptFilterPosCodeTo = $this->aText['tRptPosTo'] . ' ' . $aDataFilter['tPosNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterPosCodeFrom . ' ' . $tRptFilterPosCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Product (สินค้า)
            if (!empty($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeTo'])) {
                $tRptFilterProductCodeFrom = $this->aText['tRptPdtCodeFrom'] . ' ' . $aDataFilter['tPdtNameFrom'];
                $tRptFilterProductCodeTo = $this->aText['tRptPdtCodeTo'] . ' ' . $aDataFilter['tPdtNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterProductCodeFrom . ' ' . $tRptFilterProductCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter ProductGroup (กลุ่มสินค้า)
            if (!empty($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeTo'])) {
                $tRptFilterProductGrpCodeFrom = $this->aText['tRptPdtGrpFrom'] . ' ' . $aDataFilter['tPdtGrpNameFrom'];
                $tRptFilterProductGrpCodeTo = $this->aText['tRptPdtGrpTo'] . ' ' . $aDataFilter['tPdtGrpNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterProductGrpCodeFrom . ' ' . $tRptFilterProductGrpCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter ProductType (ประเภทสินค้า)
            if (!empty($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeTo'])) {
                $tRptFilterProductTypeCodeFrom = $this->aText['tRptPdtTypeFrom'] . ' ' . $aDataFilter['tPdtTypeNameFrom'];
                $tRptFilterProductTypeCodeTo = $this->aText['tRptPdtTypeTo'] . ' ' . $aDataFilter['tPdtTypeNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterProductTypeCodeFrom . ' ' . $tRptFilterProductTypeCodeTo;
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

            // ====================================================================================================================================================================

            // ========================================================================== Date Time Print =========================================================================
            $nStartRowFillter = 10;
            $tRptDateTimeExportText = $this->aText['tRptDatePrint'] . ' ' . $dDateExport . ' ' . $this->aText['tRptTimePrint'] . ' ' . $tTime;
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowFillter . ':I' . $nStartRowFillter);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowFillter, $tRptDateTimeExportText);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
            // ====================================================================================================================================================================

            // ==================================================================== หัวตารางรายงาน ==================================================================================
            // กำหนดจุดเริ่มต้นของแถวหัวตาราง 
            $nStartRowHeadder = 11;

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
                ->setCellValue('A' . $nStartRowHeadder, $this->aText['tRptPdtCode'])
                ->setCellValue('B' . $nStartRowHeadder, $this->aText['tRptPdtName'])
                ->setCellValue('C' . $nStartRowHeadder, $this->aText['tRptPdtGrp'])
                ->setCellValue('D' . $nStartRowHeadder, $this->aText['tRptQtySale'])
                ->setCellValue('E' . $nStartRowHeadder, $this->aText['tRptCabinetCost'])
                ->setCellValue('F' . $nStartRowHeadder, $this->aText['tRptGrandSale'])
                ->setCellValue('G' . $nStartRowHeadder, $this->aText['tRptProfitloss'])
                ->setCellValue('H' . $nStartRowHeadder, $this->aText['tRptCost'])
                ->setCellValue('I' . $nStartRowHeadder, $this->aText['tRptSalesVending']);

            // Alignment ของหัวตาราง
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            // ==================================================================== ข้อมูลรายละเอียดรายงาน ===========================================================================
            // Set Variable Data
            $nStartRowData = $nStartRowHeadder + 1;

            if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) {
                foreach ($aDataReport['raItems'] as $nKey => $aValue) {

                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('A' . $nStartRowData, $aValue['rtPdtCode'])
                        ->setCellValue('B' . $nStartRowData, $aValue['rtPdtName'])
                        ->setCellValue('C' . $nStartRowData, $aValue['rtChainName'])
                        ->setCellValue('D' . $nStartRowData, $aValue['rtSaleQty'])
                        ->setCellValue('E' . $nStartRowData, $aValue['rtPdtCost'])
                        ->setCellValue('F' . $nStartRowData, $aValue['rtGrand'])
                        ->setCellValue('G' . $nStartRowData, $aValue['rtProfit'])
                        ->setCellValue('H' . $nStartRowData, $aValue['rtProfitPercent'])
                        ->setCellValue('I' . $nStartRowData, $aValue['rtSalePercent']);

                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':C' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
                    $nStartRowData++;
                }
            }else{
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':I' . $nStartRowData);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptNoData']);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
            }

            // Step 7 : Set Footer Text
            $nPageNo    = $aDataReport['rnCurrentPage'];
            $nTotalPage = $aDataReport['rnAllPage'];

            if ($nPageNo == $nTotalPage) {
                if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) {
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
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptOverall']);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                    // RIGHT
                    $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValue('D' . $nStartRowData, number_format($aDataSumFoot['FCXsdSaleQty_SumFooter'], 2))
                    ->setCellValue('E' . $nStartRowData, number_format($aDataSumFoot['FCPdtCost_SumFooter'], 2))
                    ->setCellValue('F' . $nStartRowData, number_format($aDataSumFoot['FCXshGrand_SumFooter'], 2))
                    ->setCellValue('G' . $nStartRowData, number_format($aDataSumFoot['FCXsdProfit_SumFooter'], 2))
                    ->setCellValue('H' . $nStartRowData, number_format($aDataSumFoot['FCXsdProfitPercent_SumFooter'], 2))
                    ->setCellValue('I' . $nStartRowData, number_format($aDataSumFoot['FCXsdSalePercent_SumFooter'], 2));
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':E' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                }  
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
             // ===================================================================================================================================================

        }catch(Exception $Error){
            $aResponse = array(
                'nStaExport' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

}

