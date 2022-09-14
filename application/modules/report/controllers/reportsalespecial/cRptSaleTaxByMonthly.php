<?php
defined('BASEPATH') or exit('No direct script access allowed');

set_time_limit(0);
ini_set('memory_limit', '8000M'); // -1 unlimit memory
ini_set('max_execution_time', 0); // 3600 seconds =  minutes
ini_set('sqlsrv.ClientBufferMaxKBSize', '524288'); // Setting to 512M
ini_set('pdo_sqlsrv.client_buffer_max_kb_size', '524288'); // Setting to 512M - for pdo_sqlsrv
ini_set("pcre.backtrack_limit", "1000000000000");

class cRptSaleTaxByMonthly extends MX_Controller {
    
    /**
     * ภาษา
     * @var array
    */
    public $aText   = [];

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
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsalespecial/mRptSaleTaxByMonthly');
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText    = [
            'tTitleReport'          => language('report/report/report','tRptSaleTaxByMonthly'),
            'tDatePrint'            => language('report/report/report','tRptDatePrint'),
            'tTimePrint'            => language('report/report/report','tRptTimePrint'),
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
            // Filter Text Label Between And Multi Browse
            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom'           => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'             => language('report/report/report', 'tRptPosTo'),
            'tRptRcvFrom'           => language('report/report/report', 'tRptRcvFrom'),
            'tRptRcvTo'             => language('report/report/report', 'tRptRcvTo'),
            'tRptYear'              => language('report/report/report','tRptYear'),
            'tRptMonth'             => language('report/report/report','tRptMonth'),
            'tRptAll'               => language('report/report/report', 'tRptAll'),
            // Lang เดือน
            'tRptMonth01'           => language('report/report/report','tRptMonth01'),
            'tRptMonth02'           => language('report/report/report','tRptMonth02'),
            'tRptMonth03'           => language('report/report/report','tRptMonth03'),
            'tRptMonth04'           => language('report/report/report','tRptMonth04'),
            'tRptMonth05'           => language('report/report/report','tRptMonth05'),
            'tRptMonth06'           => language('report/report/report','tRptMonth06'),
            'tRptMonth07'           => language('report/report/report','tRptMonth07'),
            'tRptMonth08'           => language('report/report/report','tRptMonth08'),
            'tRptMonth09'           => language('report/report/report','tRptMonth09'),
            'tRptMonth10'           => language('report/report/report','tRptMonth10'),
            'tRptMonth11'           => language('report/report/report','tRptMonth11'),
            'tRptMonth12'           => language('report/report/report','tRptMonth12'),
            // Table Heard Label  
            'tRptSaleTaxByMonthlyPos'       => language('report/report/report', 'tRptSaleTaxByMonthlyPos'),
            'tRptSaleTaxByMonthlyPayment'   => language('report/report/report', 'tRptSaleTaxByMonthlyPayment'),
            'tRptSaleTaxByMonthlyDate'      => language('report/report/report', 'tRptSaleTaxByMonthlyDate'),
            'tRptSaleTaxByMonthlyEjNo'      => language('report/report/report', 'tRptSaleTaxByMonthlyEjNo'),
            'tRptSaleTaxByMonthlyProduct'   => language('report/report/report', 'tRptSaleTaxByMonthlyProduct'),
            'tRptSaleTaxByMonthlyFirstName' => language('report/report/report', 'tRptSaleTaxByMonthlyFirstName'),
            'tRptSaleTaxByMonthlyLastName'  => language('report/report/report', 'tRptSaleTaxByMonthlyLastName'),
            'tRptSaleTaxByMonthlyIDCardNo'  => language('report/report/report', 'tRptSaleTaxByMonthlyIDCardNo'),
            'tRptSaleTaxByMonthlyVatTable'  => language('report/report/report', 'tRptSaleTaxByMonthlyVatTable'),
            'tRptSaleTaxByMonthlyVatAmount' => language('report/report/report', 'tRptSaleTaxByMonthlyVatAmount'),
            'tRptSaleTaxByMonthlyTotal'     => language('report/report/report', 'tRptSaleTaxByMonthlyTotal'),
            'tRptSaleTaxByMonthlyTotalAll'  => language('report/report/report', 'tRptSaleTaxByMonthlyTotalAll'),
            'tRptConditionInReport'         => language('report/report/report', 'tRptConditionInReport'),
            'tRptNotFoundData'              => language('common/main/main', 'tCMNNotFoundData'),
            'tRptDateFrom'                  => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'                    => language('report/report/report', 'tRptDateTo'),
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
        $this->aRptFilter       = [
            'tUsrSessionID'         => $this->tUserSessionID,
            'tCompName'             => $this->tCompName,
            'tCode'                 => $this->tRptCode,
            'nLangID'               => $this->nLngID,
            // Type Filter Center
            'nTypeDataCondition'    => !empty($this->input->post('ohdTypeDataCondition'))   ? $this->input->post('ohdTypeDataCondition')    : 1,
            // Filter Center Branch
            'tBchCodeFrom'          => !empty($this->input->post('oetRptBchCodeFrom'))      ? $this->input->post('oetRptBchCodeFrom')       : "",
            'tBchNameFrom'          => !empty($this->input->post('oetRptBchNameFrom'))      ? $this->input->post('oetRptBchNameFrom')       : "",
            'tBchCodeTo'            => !empty($this->input->post('oetRptBchCodeTo'))        ? $this->input->post('oetRptBchCodeTo')         : "",
            'tBchNameTo'            => !empty($this->input->post('oetRptBchNameTo'))        ? $this->input->post('oetRptBchNameTo')         : "",
            'tBchCodeSelect'        => !empty($this->input->post('oetRptBchCodeSelect'))    ? $this->input->post('oetRptBchCodeSelect')     : "",
            'tBchNameSelect'        => !empty($this->input->post('oetRptBchNameSelect'))    ? $this->input->post('oetRptBchNameSelect')     : "",
            'bBchStaSelectAll'      => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // Filter Center Merchant 
            'tMerCodeFrom'          => !empty($this->input->post('oetRptMerCodeFrom'))      ? $this->input->post('oetRptMerCodeFrom')       : "",
            'tMerNameFrom'          => !empty($this->input->post('oetRptMerNameFrom'))      ? $this->input->post('oetRptMerNameFrom')       : "",
            'tMerCodeTo'            => !empty($this->input->post('oetRptMerCodeTo'))        ? $this->input->post('oetRptMerCodeTo')         : "",
            'tMerNameTo'            => !empty($this->input->post('oetRptMerNameTo'))        ? $this->input->post('oetRptMerNameTo')         : "",
            'tMerCodeSelect'        => !empty($this->input->post('oetRptMerCodeSelect'))    ? $this->input->post('oetRptMerCodeSelect')     : "",
            'tMerNameSelect'        => !empty($this->input->post('oetRptMerNameSelect'))    ? $this->input->post('oetRptMerNameSelect')     : "",
            'bMerStaSelectAll'      => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Filter Center Shop
            'tShpCodeFrom'          => !empty($this->input->post('oetRptShpCodeFrom'))      ? $this->input->post('oetRptShpCodeFrom')       : "",
            'tShpNameFrom'          => !empty($this->input->post('oetRptShpNameFrom'))      ? $this->input->post('oetRptShpNameFrom')       : "",
            'tShpCodeTo'            => !empty($this->input->post('oetRptShpCodeTo'))        ? $this->input->post('oetRptShpCodeTo')         : "",
            'tShpNameTo'            => !empty($this->input->post('oetRptShpNameTo'))        ? $this->input->post('oetRptShpNameTo')         : "",
            'tShpCodeSelect'        => !empty($this->input->post('oetRptShpCodeSelect'))    ? $this->input->post('oetRptShpCodeSelect')     : "",
            'tShpNameSelect'        => !empty($this->input->post('oetRptShpNameSelect'))    ? $this->input->post('oetRptShpNameSelect')     : "",
            'bShpStaSelectAll'      => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Center Pos
            'tPosCodeFrom'          => !empty($this->input->post('oetRptPosCodeFrom'))      ? $this->input->post('oetRptPosCodeFrom')       : "",
            'tPosNameFrom'          => !empty($this->input->post('oetRptPosNameFrom'))      ? $this->input->post('oetRptPosNameFrom')       : "",
            'tPosCodeTo'            => !empty($this->input->post('oetRptPosCodeTo'))        ? $this->input->post('oetRptPosCodeTo')         : "",
            'tPosNameTo'            => !empty($this->input->post('oetRptPosNameTo'))        ? $this->input->post('oetRptPosNameTo')         : "",
            'tPosCodeSelect'        => !empty($this->input->post('oetRptPosCodeSelect'))    ? $this->input->post('oetRptPosCodeSelect')     : "",
            'tPosNameSelect'        => !empty($this->input->post('oetRptPosNameSelect'))    ? $this->input->post('oetRptPosNameSelect')     : "",
            'bPosStaSelectAll'      => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // Filter Other Payment Type
            'tRcvCodeFrom'          => !empty($this->input->post('oetRptRcvCodeFrom'))      ? $this->input->post('oetRptRcvCodeFrom')       : "",
            'tRcvNameFrom'          => !empty($this->input->post('oetRptRcvNameFrom'))      ? $this->input->post('oetRptRcvNameFrom')       : "",
            'tRcvCodeTo'            => !empty($this->input->post('oetRptRcvCodeTo'))        ? $this->input->post('oetRptRcvCodeTo')         : "",
            'tRcvNameTo'            => !empty($this->input->post('oetRptRcvNameTo'))        ? $this->input->post('oetRptRcvNameTo')         : "",

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'          => !empty($this->input->post('oetRptDocDateFrom'))      ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'            => !empty($this->input->post('oetRptDocDateTo'))        ? $this->input->post('oetRptDocDateTo') : "",

            // Filter Other Year
            //'tYear'                 => !empty($this->input->post('oetRptYear'))             ? $this->input->post('oetRptYear')              : "",

            // Filter Other Month
            //'tMonth'                => !empty($this->input->post('ocmRptMonth'))            ? $this->input->post('ocmRptMonth')             : "",
        ];
        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if(!empty($this->tRptCode) && !empty($this->tRptExportType)){
            $this->mRptSaleTaxByMonthly->FSnMExecStoreReport($this->aRptFilter);
            switch($this->tRptExportType){
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp();
                break;
            }
        }
    }

    // Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrint(){
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'tUsrSessionID' => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tRptCode'      => $this->tRptCode
        ];
        $aDataReport    = $this->mRptSaleTaxByMonthly->FSaMGetDataReport($aDataReportParams);

        // Load View Show Report
        $aDataViewRptParams = [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aDataFilter'       => $this->aRptFilter
        ];
        $tRptView   = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptSaleTaxByMonthly','wRptSaleTaxByMonthlyHtml',$aDataViewRptParams);

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
        $this->load->view('report/report/wReportViewer',$aDataViewerParams);
    }

    // Functionality: Click Pagination ดูตัวอย่างก่อนพิมพ์
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrintClickPage(){
        /** =========== Begin Init Variable ================================== */
        $aDataFilter    = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataReportParams  = array(
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        );

        $aDataReport    = $this->mRptSaleTaxByMonthly->FSaMGetDataReport($aDataReportParams);

        // ข้อมูล Render Report
        $aDataViewRptParams = array(
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aDataFilter'       => $aDataFilter
        );

        $tRptView   = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptSaleTaxByMonthly','wRptSaleTaxByMonthlyHtml',$aDataViewRptParams);

        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tRptView,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => array(
                'raItems'       => $aDataReport['aRptData'],
                'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                'rtCode'        => '1',
                'rtDesc'    => 'success',
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    // Functionality: Check Data Report Temp
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return: object Status Count Data Report
    // ReturnType: Object
    public function FSoCChkDataReportInTableTemp(){
        $aDataCountData = [
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUserSession'  => $this->tUserSessionID,
        ];
        $nDataCountPage = $this->mRptSaleTaxByMonthly->FSnMCountDataReportAll($aDataCountData);
        $aResponse = array(
            'nCountPageAll' => $nDataCountPage,
            'nStaEvent'     => 1,
            'tMessage'      => 'Success Count Data All'
        );
        echo json_encode($aResponse);
    }

    // Functionality: Send Rabbit MQ Report
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return: object Send Rabbit MQ Report
    // ReturnType: Object
    public function FSvCCallRptExportFile(){
        $dDateSendMQ    = date('Y-m-d');
        $dTimeSendMQ    = date('H:i:s');
        $dDateSubscribe = date('Ymd');
        $dTimeSubscribe = date('His');
        // Set Parameter Send MQ
        $tRptQueueName  = 'RPT_'.$this->tSysBchCode.'_'.$this->tRptGroup.'_'.$this->tRptCode;
        $aDataSendMQ    = [
            'tQueueName' => $tRptQueueName,
            'aParams' => [
                'ptRptCode'         => $this->tRptCode,
                'pnPerFile'         => 20000,
                'ptUserCode'        => $this->tUserLoginCode,
                'ptUserSessionID'   => $this->tUserSessionID,
                'pnLngID'           => $this->nLngID,
                'ptFilter'          => $this->aRptFilter,
                'ptRptExpType'      => $this->tRptExportType,
                'ptComName'         => $this->tCompName,
                'ptDate'            => $dDateSendMQ,
                'ptTime'            => $dTimeSendMQ,
                'ptBchCode'         => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
            ]
        ];
        FCNxReportCallRabbitMQ($aDataSendMQ);
        $aResponse  = array(
            'nStaEvent' => 1,
            'tMessage'  => 'Success Send Rabbit MQ.',
            'aDataSubscribe'    => array(
                'ptSysBchCode'      => $this->tSysBchCode,
                'ptComName'         => $this->tCompName,
                'ptRptCode'         => $this->tRptCode,
                'ptUserCode'        => $this->tUserLoginCode,
                'ptUserSessionID'   => $this->tUserSessionID,
                'pdDateSubscribe'   => $dDateSubscribe,
                'pdTimeSubscribe'   => $dTimeSubscribe,
            )
        );
        echo json_encode($aResponse);
    }

}