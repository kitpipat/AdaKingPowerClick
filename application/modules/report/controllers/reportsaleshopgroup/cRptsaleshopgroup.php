<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptsaleshopgroup extends MX_Controller {
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

    /**
     * Set Construct Report
     */

    public function __construct() {
        $this->load->helper('report');
        $this->load->library('zip');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsaleshopgroup/mRptsaleshopgroup');

        // Set Init Parameter Report (กำหนดค่าให้กับพารามิเตอร์เริ่มต้น)
        $this->init();
        parent::__construct();
    }

    private function init() {
        // Set Default Text
        $this->aText = [
            'tTitleReport' => language('report/report/report', 'tRptTitleSaleShopGroupVD'),
            'tDatePrint' => language('report/report/report', 'tRptAdjStkVDDatePrint'),
            'tTimePrint' => language('report/report/report', 'tRptAdjStkVDTimePrint'),
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
            // Filter Heard Report
            'tRptMerFrom' => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo' => language('report/report/report', 'tRptMerTo'),
            'tRptShopFrom' => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo' => language('report/report/report', 'tRptShopTo'),
            'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo' => language('report/report/report', 'tRptDateTo'),
            // Table Label Report
            'tRptSaleShopGroupVDNo' => language('report/report/report', 'tRptSaleShopGroupVDNo'),
            'tRptSaleShopGroupVDDocDate' => language('report/report/report', 'tRptSaleShopGroupVDDocDate'),
            'tRptSaleShopGroupVDDocNo' => language('report/report/report', 'tRptSaleShopGroupVDDocNo'),
            'tRptSaleShopGroupVDDocRef' => language('report/report/report', 'tRptSaleShopGroupVDDocRef'),
            'tRptSaleShopGroupVDCst' => language('report/report/report', 'tRptSaleShopGroupVDCst'),
            'tRptSaleShopGroupVDTaxNo' => language('report/report/report', 'tRptSaleShopGroupVDTaxNo'),
            'tRptSaleShopGroupVDEstablishment' => language('report/report/report', 'tRptSaleShopGroupVDEstablishment'),
            'tRptSaleShopGroupVDValue' => language('report/report/report', 'tRptSaleShopGroupVDValue'),
            'tRptSaleShopGroupVDTaxAmtV' => language('report/report/report', 'tRptSaleShopGroupVDTaxAmtV'),
            'tRptSaleShopGroupVDTaxAmtNV' => language('report/report/report', 'tRptSaleShopGroupVDTaxAmtNV'),
            'tRptSaleShopGroupVDNet' => language('report/report/report', 'tRptSaleShopGroupVDNet'),
            'tRptSaleShopGroupVDTotalAll' => language('report/report/report', 'tRptSaleShopGroupVDTotalAll'),
            // Text Other
            'tRptSaleShopGroupVDPosNo' => language('report/report/report', 'tRptSaleShopGroupVDPosNo'),
            'tRptSaleShopGroupVDNoData' => language('common/main/main', 'tCMNNotFoundData'),
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

        // Report Filter Data
        $this->aRptFilter = [
            'tSessionID' => $this->tUserSessionID,
            'tCompName'  => $tFullHost,
            'tRptCode'   => $this->tRptCode,
            'nLangID'    => $this->nLngID,
            // Filter กลุ่มธุรกิจ
            'tMerCodeFrom' => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom' => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo' => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo' => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            // Filter ร้านค้า
            'tShpCodeFrom' => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom' => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo' => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo' => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            // Filter วันที่เอกสาร
            'tDocDateFrom' => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo' => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
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
            $tIP = $this->input->ip_address();
            $tFullHost = gethostbyaddr($tIP);
            // Execute Stored Procedure
            $this->mRptsaleshopgroup->FSnMExecStoreCReport($this->aRptFilter);
            // Count Rows
            $aCountRowParams = [
                'tCompName'  => $tFullHost,
                'tRptCode'   => $this->tRptCode,
                'tSessionID' => $this->tUserSessionID
            ];
            $this->nRows = $this->mRptsaleshopgroup->FSnMCountDataReportAll($aCountRowParams);

            $aDataSwitchCase = array(
                'tRptRoute' => $this->tRptRoute,
                'tRptCode' => $this->tRptCode,
                'tRptTypeExport' => $this->tRptExportType,
                'aDataFilter' => $this->aRptFilter
            );

            // Switch Case Report Type
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp();
                    break;
                case 'pdf':
                    // Create by Witsarut 08/10/2019
                    // Only!! Test Export Excel File
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/07/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Wasin(Yoshi)
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint() {
        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        /** =================================== Begin Get Data =================================== */
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'nPerPage'  => $this->nPerPage,
            'nPage'     => $this->nPage,
            'tCompName' => $tFullHost,
            'tRptCode'  => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        ];
        $aDataReport = $this->mRptsaleshopgroup->FSaMGetDataReport($aDataReportParams);
        /** ====================================================================================== */
        /** ================================== Begin Render View ================================= */
        // Load View Advance Table
        $aDataViewRptParams = [
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo' => $this->aCompanyInfo,
            'aDataTextRef' => $this->aText,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => $aDataReport
        ];
        $tViewReportHtml = JCNoHLoadViewAdvanceTable('report/datasources/rptsaleshopgroup', 'wRptSaleShopGroupHtml', $aDataViewRptParams);
        /** ====================================================================================== */
        // Data Viewer Center Report
        $aDataViewerParams = [
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewReportHtml,
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
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 19/07/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Wasin(Yoshi)
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {
        /** ================================== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** ========================================================================================= */
        /** ================================== Begin Get Data ======================================= */
        // ดึงข้อมูลจากฐานข้อมูล Temp

        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;


        $aDataReportParams = [
            'nPerPage' => $this->nPerPage,
            'nPage' => $this->nPage,
            'tCompName' => $tFullHost,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        ];
        $aDataReport = $this->mRptsaleshopgroup->FSaMGetDataReport($aDataReportParams);
        /** ========================================================================================= */
        /** ================================== Begin Render View ==================================== */
        // Load View Advance Table
        $aDataViewRptParams = [
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo' => $this->aCompanyInfo,
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataFilter' => $aDataFilter
        ];
        $tViewReportHtml = JCNoHLoadViewAdvanceTable('report/datasources/rptsaleshopgroup', 'wRptSaleShopGroupHtml', $aDataViewRptParams);
        /** ========================================================================================= */
        // Data Viewer Center Report
        $aDataViewerParams = [
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewReportHtml,
            'aDataFilter' => $aDataFilter,
            'aDataReport' => [
                'raItems' => $aDataReport['aRptData'],
                'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success'
            ]
        ];
        $this->load->view('report/report/wReportViewer', $aDataViewerParams);
    }

    /**
     * Functionality: Count Data Report In DB Temp
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Wasin(Yoshi)
     * Return: Object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp() {
        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        $aCountRowParams = [
            'tCompName' => $tFullHost,
            'tRptCode' => $this->tRptCode,
            'tSessionID' => $this->tUserSessionID,
        ];
        $nDataCountPage = $this->mRptsaleshopgroup->FSnMCountDataReportAll($aCountRowParams);
        $aResponse = array(
            'nCountPageAll' => $nDataCountPage,
            'nStaEvent' => 1,
            'tMessage' => 'Success Count Data All'
        );
        echo json_encode($aResponse);
    }

    /**
     * Functionality: Send Rabbit MQ Report Excel
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Wasin(Yoshi)
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $tIP = $this->input->ip_address();
            $tFullHost = gethostbyaddr($tIP);
            $tRptGrpCode = $this->tRptGroup;
            $tRptCode = $this->tRptCode;
            $tUserCode = $this->tUserLoginCode;
            $tSessionID = $this->tUserSessionID;
            $nLangID = FCNaHGetLangEdit();
            $tRptExportType = $this->tRptExportType;
            $tCompName = $tFullHost;
            $dDateSendMQ = date('Y-m-d');
            $dTimeSendMQ = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');

            // Set QueueName 
            $tRptQueueName = 'RPT_' . $tRptGrpCode . '_' . $tRptCode;

            // Data Params Report
            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode' => $tRptCode,
                    'pnPerFile' => 20000,
                    'ptUserCode' => $tUserCode,
                    'ptUserSessionID' => $tSessionID,
                    'pnLngID' => $nLangID,
                    'ptFilter' => $this->aRptFilter,
                    'ptRptExpType' => $tRptExportType,
                    'ptComName' => $tCompName,
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
                    'ptComName' => $tFullHost,
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
                'tMessage' => 'Error Cannot Send Data Rabbit MQ  Report Sale Shop Group. !!!'
            );
        }
        echo json_encode($aResponse);
    }




    // Use Button of  PDF Download
    // Only !!! Test Export Excel download
    // Create By Witsarut 08/10/2019
    // ReturnType: View
    public function FSvCCallRptRenderExcel($paDataSwitchCase){
        try{
            $tRptRoute      = $paDataSwitchCase['tRptRoute'];
            $tRptCode       = $paDataSwitchCase['tRptCode'];
            $tRptTypeExport = $paDataSwitchCase['tRptTypeExport'];
            $aDataFilter    = $paDataSwitchCase['aDataFilter'];
            $nPage = 1;
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tUsrSessionID  = $this->session->userdata('tSesSessionID');

            // Get data Company
            $aDataAddress = array();
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


            $aDataTextRef = array(
                'tTitleReport'          => language('report/report/report', 'tRptTitleSaleShopGroupVD'),
                'tDatePrint'            => language('report/report/report', 'tRptAdjStkVDDatePrint'),
                'tTimePrint'            => language('report/report/report', 'tRptAdjStkVDTimePrint'),
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
                'tRptAddV2Desc1'        => language('report/report/report', 'tRptAddV2Desc1'),
                'tRptAddV2Desc2'        => language('report/report/report', 'tRptAddV2Desc2'),
                // Filter Heard Report
                'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
                'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
                'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
                'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
                'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
                'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
                // Table Label Report
                'tRptSaleShopGroupVDNo' => language('report/report/report', 'tRptSaleShopGroupVDNo'),
                'tRptSaleShopGroupVDDocDate'    => language('report/report/report', 'tRptSaleShopGroupVDDocDate'),
                'tRptSaleShopGroupVDDocNo'      => language('report/report/report', 'tRptSaleShopGroupVDDocNo'),
                'tRptSaleShopGroupVDDocRef'     => language('report/report/report', 'tRptSaleShopGroupVDDocRef'),
                'tRptSaleShopGroupVDCst'        => language('report/report/report', 'tRptSaleShopGroupVDCst'),
                'tRptSaleShopGroupVDTaxNo'      => language('report/report/report', 'tRptSaleShopGroupVDTaxNo'),
                'tRptSaleShopGroupVDEstablishment' => language('report/report/report', 'tRptSaleShopGroupVDEstablishment'),
                'tRptSaleShopGroupVDValue'      => language('report/report/report', 'tRptSaleShopGroupVDValue'),
                'tRptSaleShopGroupVDTaxAmtV'    => language('report/report/report', 'tRptSaleShopGroupVDTaxAmtV'),
                'tRptSaleShopGroupVDTaxAmtNV'   => language('report/report/report', 'tRptSaleShopGroupVDTaxAmtNV'),
                'tRptSaleShopGroupVDNet'        => language('report/report/report', 'tRptSaleShopGroupVDNet'),
                'tRptSaleShopGroupVDTotalAll'   => language('report/report/report', 'tRptSaleShopGroupVDTotalAll'),
                // Text Other
                'tRptSaleShopGroupVDPosNo'      => language('report/report/report', 'tRptSaleShopGroupVDPosNo'),
                'tRptSaleShopGroupVDNoData'     => language('common/main/main', 'tCMNNotFoundData'),
            );

            $tReportName    =  $aDataTextRef['tTitleReport'];
            $dDateExport    = date('Y-m-d');
            $tTime          = date('H:i:s');

            $aCompInfoParams    = ['nLngID' => FCNaHGetLangEdit()];
            // $aCompData = FCNaGetCompanyInfo($aCompInfoParams);
           $tIP = $this->input->ip_address();
           $tFullHost = gethostbyaddr($tIP);
           $aDataReportParams = [
                'nPerPage' => $this->nPerPage,
                'nPage' => $this->nPage,
                'tCompName' => $tFullHost,
                'tRptCode'  => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
            ];
            
            $aDataReport = $this->mRptsaleshopgroup->FSaMGetDataReport($aDataReportParams);

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
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(30);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50); 

            // ชื่อหัวรายงาน
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:F1');
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
                    $tRptAddV1No    = (empty($aDataAddress['FTAddV1No'])) ? '-' : $aDataAddress['FTAddV1No'];
                    $tRptAddV1Road  = (empty($aDataAddress['FTAddV1Road'])) ? '-' : $aDataAddress['FTAddV1Road'];
                    $tRptAddV1Soi   = (empty($aDataAddress['FTAddV1Soi'])) ? '-' : $aDataAddress['FTAddV1Soi'];
                    $tRptAddressLine1 = $tRptAddV1No . ' ' . $aDataTextRef['tRptAddrRoad'] . ' ' . $tRptAddV1Road . ' ' . $aDataTextRef['tRptAddrSoi'] . ' ' . $tRptAddV1Soi;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddressLine1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    // Check Address Line 2
                    $tRptAddV1SubDistName   = (empty($aDataAddress['FTSudName'])) ? '-' : $aDataAddress['FTSudName'];
                    $tRptAddV1DstName  = (empty($aDataAddress['FTDstName'])) ? '-' : $aDataAddress['FTDstName'];
                    $tRptAddV1PvnName  = (empty($aDataAddress['FTPvnName'])) ? '-' : $aDataAddress['FTPvnName'];
                    $tRptAddV1PostCode = (empty($aDataAddress['FTAddV1PostCode'])) ? '-' : $aDataAddress['FTAddV1PostCode'];
                    $tRptAddressLine2  = $tRptAddV1SubDistName . ' ' . $tRptAddV1DstName . ' ' . $tRptAddV1PvnName . ' ' . $tRptAddV1PostCode;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddressLine2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                } else {
                    $tRptAddV2Desc1    = (empty($aDataAddress['FTAddV2Desc1'])) ? '-' : $aDataAddress['FTAddV2Desc1'];
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
            $tFillterColumRIGHT = "F";

            // Fillter MerChant (กลุ่มธุรกิจ)
            if (!empty($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeTo'])) {
                $tRptFilterRcvCodeFrom = $aDataTextRef['tRptMerFrom'] . ' ' . $aDataFilter['tMerNameFrom'];
                $tRptFilterRcvCodeTo = $aDataTextRef['tRptMerTo'] . ' ' . $aDataFilter['tMerNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Shop (ร้านค้า)
            if (!empty($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeTo'])) {
                $tRptFilterRcvCodeFrom = $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShpNameFrom'];
                $tRptFilterRcvCodeTo = $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShpNameTo'];
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
                $tRptFilterDocDateFrom = $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom'];
                $tRptFilterDocDateTo = $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo'];
                $tRptTextLeftRightFilter = $tRptFilterDocDateFrom . ' ' . $tRptFilterDocDateTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }
            

                // ========================================================================== Date Time Print =========================================================================
                $tRptDateTimeExportText = $aDataTextRef['tDatePrint'] . ' ' . $dDateExport . ' ' . $aDataTextRef['tTimePrint'] . ' ' . $tTime;
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:F7');
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
                ->setCellValue('A' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDNo'])
                ->setCellValue('B' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDDocDate'])
                ->setCellValue('C' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDDocNo'])
                ->setCellValue('D' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDDocRef'])
                ->setCellValue('E' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDCst'])
                ->setCellValue('F' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDTaxNo'])
                ->setCellValue('G' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDEstablishment'])
                ->setCellValue('H' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDValue'])
                ->setCellValue('I' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDTaxAmtV'])
                ->setCellValue('J' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDTaxAmtNV'])
                ->setCellValue('K' . $nStartRowHeadder, $aDataTextRef['tRptSaleShopGroupVDNet']);

                // Alignment ของหัวตาราง
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':B' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle('C' . $nStartRowHeadder . ':F' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                






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

