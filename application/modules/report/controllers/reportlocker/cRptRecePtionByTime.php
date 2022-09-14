<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

date_default_timezone_set("Asia/Bangkok");

class cRptRecePtionByTime extends MX_Controller {

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
     * Systems Branch Code
     * @var string 
    */
    public $tSysBchCode;

    public function __construct() {
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportlocker/mRptRecePtionByTime');

        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init() {
        $this->aText = [
            // Title Report
            'tTitleReport'          => language('report/report/report', 'tRptRecePtionByTimeTitle'),
            'tRptAddrBranch'        => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddrTaxNo'         => language('report/report/report', 'tRptAddrTaxNo'),
            'tRptAddrTel'           => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax'           => language('report/report/report', 'tRptAddrFax'),
            'tDatePrint'            => language('report/report/report', 'tRptDatePrint'),
            'tTimePrint'            => language('report/report/report', 'tRptTimePrint'),
            // Filter Text Label
            // 'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            // 'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            // 'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            // 'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            // 'tRptPosFrom'           => language('report/report/report', 'tRptPosFrom'),
            // 'tRptPosTo'             => language('report/report/report', 'tRptPosTo'),
            // 'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
            // 'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),

            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
            'tRptPosFrom'           => language('report/report/report', 'tRptLockerPosIDFrom'),
            'tRptPosTo'             => language('report/report/report', 'tRptLockerPosIDTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
        
        
        
        
        
        //modals
            // Table Label
            'tRptBarchName'         => language('report/report/report', 'tRptBarchName'),
            'tRptDuration'          => language('report/report/report', 'tRptRentAmountFollowTimeTime'),
            'tRptshop'              => language('report/report/report', 'tRptshop'),
            'tRptRentAmountPosID'   => language('report/report/report', 'tRptRentAmountPosID'),
            'tRptRentBillAmount'    => language('report/report/report', 'tRptRentBillAmount'),
            'tRptRentAmount'        => language('report/report/report', 'tRptRentAmount'),
            'tRptFooterSumAll'      => language('report/report/report', 'tRptFooterSumAll'),
            // No Data Report
            'tRptTaxSaleLockerNoData' => language('common/main/main', 'tCMNNotFoundData'),
            'tRptAll'               => language('report/report/report', 'tRptAll')
        ];

        $this->tSysBchCode      = SYS_BCH_CODE;
        $this->tBchCodeLogin    = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage         = 100;
        $this->nOptDecimalShow  = FCNxHGetOptionDecimalShow();
        
        $tIP                    = $this->input->ip_address();
        $tFullHost              = gethostbyaddr($tIP);
        $this->tCompName        = $tFullHost;
        
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
            'tUserSession'  => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'nLangID'       => $this->nLngID,

            'tTypeSelect'       => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",
            
            // สาขา(Branch)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,
            
             // กลุ่มธุรกิจ
            'tMerCodeFrom'      => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom'      => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo'        => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo'        => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,
           
            // ร้านค้า(Shop)
            'tShpCodeFrom'      => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'      => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'        => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'        => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // เครื่องจุดขาย(Pos)
            'tPosCodeFrom'     => !empty($this->input->post('oetRptLockerCodeFrom')) ? $this->input->post('oetRptLockerCodeFrom') : "",
            'tPosNameFrom'     => !empty($this->input->post('oetRptLockerNameFrom')) ? $this->input->post('oetRptLockerNameFrom') : "",
            'tPosCodeTo'       => !empty($this->input->post('oetRptLockerCodeTo')) ? $this->input->post('oetRptLockerCodeTo') : "",
            'tPosNameTo'       => !empty($this->input->post('oetRptLockerNameTo')) ? $this->input->post('oetRptLockerNameTo') : "",
            'tPosCodeSelect'   => !empty($this->input->post('oetRptLockerCodeSelect')) ? $this->input->post('oetRptLockerCodeSelect') : "",
            'tPosNameSelect'   => !empty($this->input->post('oetRptLockerNameSelect')) ? $this->input->post('oetRptLockerNameSelect') : "",
            'bPosStaSelectAll' => !empty($this->input->post('oetRptLockerStaSelectAll')) && ($this->input->post('oetRptLockerStaSelectAll') == 1) ? true : false,

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'      => ($this->input->post('oetRptDocDateFrom') != '') ? $this->input->post('oetRptDocDateFrom') : '',
            'tDocDateTo'        => ($this->input->post('oetRptDocDateTo') != '') ? $this->input->post('oetRptDocDateTo') : ''
        ];
        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'   => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {
            // Execute Stored Procedure
            $this->mRptRecePtionByTime->FSnMExecStoreCReport($this->aRptFilter);
            $aDataMain = array(
                'ptRptRoute'      => $this->tRptRoute,
                'ptRptCode'       => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter'    => $this->aRptFilter
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
     * Creator: 02/12/2019 Saharat(Golf)
     * LastUpdate: -
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataMain) {
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

            /*=====  Get Data ==========================================================*/
            $aDataReport        = $this->mRptRecePtionByTime->FSaMGetDataReport($aDataReportParams);
            /*===== End Get Data =======================================================*/
            /*===== Begin Render View ==================================================*/

            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo'    => $this->aCompanyInfo,
                'aDataReport'     => $aDataReport,
                'aDataTextRef'    => $this->aText,
                'aDataFilter'     => $this->aRptFilter
            ];

            // Load View Advance Table
            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/rptRecePtionByTime', 'wRptRecePtionByTimeHtml', $aDataViewRptParams);
            
            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport'    => $this->aText['tTitleReport'],
                'tRptTypeExport'  => $this->tRptExportType,
                'tRptCode'        => $this->tRptCode,
                'tRptRoute'       => $this->tRptRoute,
                'tViewRenderKool' => $tRptView,
                'aDataFilter' => $this->aRptFilter,
                'aDataReport' => [
                    'raItems' => $aDataReport['aRptData'],
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
     * Creator: 02/11/2019 Saharat(Golf)
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
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        ];

        $aDataReport        = $this->mRptRecePtionByTime->FSaMGetDataReport($aDataReportParams);
        /*===== End Get Data ===========================================================*/
        
        /*===== Begin Render View ======================================================*/
        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aDataFilter'     => $aDataFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/rptRecePtionByTime', 'wRptRecePtionByTimeHtml', $aDataViewRptParams);

        // Data Viewer Center Report
        $aDataViewerParams = array(
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
            'tViewRenderKool' => $tRptView,
            'aDataFilter'     => $aDataFilter,
            'aDataReport'     => array(
                'raItems'     => $aDataReport['aRptData'],
                'rnAllRow'    => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success'
            )
        );

        $this->load->view('report/report/wReportViewer', $aDataViewerParams);
        /*===== End Render View ========================================================*/
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Saharat(GolF)
     * LastUpdate: -
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataMain) {

        try {
            $aDataCountData = [
                'tCompName'     => $paDataMain['paDataFilter']['tCompName'],
                'tRptCode'      => $paDataMain['paDataFilter']['tRptCode'],
                'tUserSession'  => $paDataMain['paDataFilter']['tUserSession'],
            ];

            $nDataCountPage = $this->mRptRecePtionByTime->FSnMCountRowInTemp($aDataCountData);

            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent' => 1,
                'tMessage'  => 'Success Count Data All'
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage'  => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }
    
    /**
     * Functionality: Send Rabbit MQ Report
     * Parameters:  Function Parameter
     * Creator: 02/11/2019 Saharat(GolF)
     * LastUpdate: -
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $tDateSendMQ    = date('Y-m-d');
            $tTimeSendMQ    = date('H:i:s');
            $tDateSubscribe = date('Ymd');
            $tTimeSubscribe = date('His');
            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_'.$this->tSysBchCode.'_'.$this->tRptGroup.'_'.$this->tRptCode;
            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode'       => $this->tRptCode,
                    'pnPerFile'       => 20000,
                    'ptUserCode'      => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pnLngID'      => $this->nLngID,
                    'ptFilter'     => $this->aRptFilter,
                    'ptRptExpType' => $this->tRptExportType,
                    'ptComName'    => $this->tCompName,
                    'ptDate'       => $tDateSendMQ,
                    'ptTime'       => $tTimeSendMQ,
                    'ptBchCode'    => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
                ]
            ];
            FCNxReportCallRabbitMQ($aDataSendMQ);
            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage'  => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode'      => $this->tSysBchCode,
                    'ptComName'         => $this->tCompName,
                    'ptRptCode'         => $this->tRptCode,
                    'ptUserCode'        => $this->tUserLoginCode,
                    'ptUserSessionID'   => $this->tUserSessionID,
                    'pdDateSubscribe'   => $tDateSubscribe,
                    'pdTimeSubscribe'   => $tTimeSubscribe,
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







































