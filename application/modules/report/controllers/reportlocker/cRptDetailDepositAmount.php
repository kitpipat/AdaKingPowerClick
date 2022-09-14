<?php

defined('BASEPATH') or exit('No direct script access allowed');

class cRptDetailDepositAmount extends MX_Controller {

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

    public function __construct(){
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportlocker/mRptDetailDepositAmount');
        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText = [
            'tTitleReport' => language('report/report/report', 'tRptLockerDetailDepositAmountTitle'),
            'tRptTaxNo' => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint' => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport' => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint' => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml' => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch' => language('report/report/report', 'tRptAddrBranch'),
            'tRptFaxNo' => language('report/report/report', 'tRptAddrFax'),
            'tRptTel' => language('report/report/report', 'tRptAddrTel'),
            // Filter Heard Report
            'tRptBchFrom' => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo' => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom' => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo' => language('report/report/report', 'tRptShopTo'),
            'tRptPosLockerFrom' => language('report/report/report', 'tRptPosLockerFrom'),
            'tRptPosLockerTo' => language('report/report/report', 'tRptPosLockerTo'),
            'tRptchannelForm' => language('report/report/report', 'tRptchannelForm'),
            'tRptchannelTo' => language('report/report/report', 'tRptchannelTo'),
            'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo' => language('report/report/report', 'tRptDateTo'),

            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),

            // Table Report
            'tRptBarchName' => language('report/report/report', 'tRptBarchName'),
            'tRptshop' => language('report/report/report', 'tRptshop'),
            'tRptLockerDetailDepositAmountLockerID' => language('report/report/report', 'tRptLockerDetailDepositAmountLockerID'),
            'tRptLockerDetailDepositAmountDepositDate' => language('report/report/report', 'tRptLockerDetailDepositAmountDepositDate'),
            'tRptLockerDetailDepositAmountTime' => language('report/report/report', 'tRptLockerDetailDepositAmountTime'),
            'tRptLockerDetailDepositAmountChannel' => language('report/report/report', 'tRptLockerDetailDepositAmountChannel'),
            'tRptSize' => language('report/report/report', 'tRptSize'),
            'tRptLockerDetailDepositAmountRecipient' => language('report/report/report', 'tRptLockerDetailDepositAmountRecipient'),
            'tRptLockerDetailDepositAmountPickDate' => language('report/report/report', 'tRptLockerDetailDepositAmountPickDate'),
            'tRptLockerDetailDepositAmountPickTime' => language('report/report/report', 'tRptLockerDetailDepositAmountPickTime'),
            'tRptLockerDetailDepositAmountSpendTime' => language('report/report/report', 'tRptLockerDetailDepositAmountSpendTime'),
            'tRptLockerDetailDepositAmountGrand' => language('report/report/report', 'tRptLockerDetailDepositAmountGrand'),
            'tRptLockerDetailDepositAmountDepositor' => language('report/report/report', 'tRptLockerDetailDepositAmountDepositor'),
            'tRptLockerDetailDepositAmountDocNo' => language('report/report/report', 'tRptLockerDetailDepositAmountDocNo'),
            'tRptTotalFooter' => language('report/report/report', 'tRptTotalFooter'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptNoData' => language('report/report/report', 'tRptNoData'),
            'tRptAll'               => language('report/report/report', 'tRptAll')
        ];

        $this->tSysBchCode      = SYS_BCH_CODE;
        $this->tBchCodeLogin    = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage         = 100;
        $this->nOptDecimalShow  = FCNxHGetOptionDecimalShow();
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
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $tFullHost,
            'tRptCode' => $this->tRptCode,
            'nLangID' => $this->nLngID,

            'tTypeSelect'       => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // สาขา(Branch)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom'))  ? $this->input->post('oetRptBchCodeFrom')   : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom'))  ? $this->input->post('oetRptBchNameFrom')   : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo'))    ? $this->input->post('oetRptBchCodeTo')     : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo'))    ? $this->input->post('oetRptBchNameTo')     : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom'      => !empty($this->input->post('oetRptShpCodeFrom'))  ? $this->input->post('oetRptShpCodeFrom')   : "",
            'tShpNameFrom'      => !empty($this->input->post('oetRptShpNameFrom'))  ? $this->input->post('oetRptShpNameFrom')   : "",
            'tShpCodeTo'        => !empty($this->input->post('oetRptShpCodeTo'))    ? $this->input->post('oetRptShpCodeTo')     : "",
            'tShpNameTo'        => !empty($this->input->post('oetRptShpNameTo'))    ? $this->input->post('oetRptShpNameTo')     : "",
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // เครื่องจุดขาย
            // 'tPosCodeFrom'      => !empty($this->input->post('oetRptPosCodeFrom'))  ? $this->input->post('oetRptPosCodeFrom')   : "",
            // 'tPosNameFrom'      => !empty($this->input->post('oetRptPosNameFrom'))  ? $this->input->post('oetRptPosNameFrom')   : "",
            // 'tPosCodeTo'        => !empty($this->input->post('oetRptPosCodeTo'))    ? $this->input->post('oetRptPosCodeTo')     : "",
            // 'tPosNameTo'        => !empty($this->input->post('oetRptPosNameTo'))    ? $this->input->post('oetRptPosNameTo')     : "",
            // 'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            // 'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            // 'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // กลุ่มธุรกิจ
            'tMerCodeFrom'   => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom'   => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo'     => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo'     => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // ตู้(POS)
            'tLockerCodeFrom'    => !empty($this->input->post('oetRptLockerCodeFrom')) ? $this->input->post('oetRptLockerCodeFrom') : "",
            'tLockerNameFrom'    => !empty($this->input->post('oetRptLockerNameFrom')) ? $this->input->post('oetRptLockerNameFrom') : "",
            'tLockerCodeTo'      => !empty($this->input->post('oetRptLockerCodeTo')) ? $this->input->post('oetRptLockerCodeTo') : "",
            'tLockerNameTo'      => !empty($this->input->post('oetRptLockerNameTo')) ? $this->input->post('oetRptLockerNameTo') : "",
            'tLockerCodeSelect'  => !empty($this->input->post('oetRptLockerCodeSelect')) ? $this->input->post('oetRptLockerCodeSelect') : "",
            'tLockerNameSelect'  => !empty($this->input->post('oetRptLockerNameSelect')) ? $this->input->post('oetRptLockerNameSelect') : "",
            'bLockerStaSelectAll' => !empty($this->input->post('oetRptLockerStaSelectAll')) && ($this->input->post('oetRptLockerStaSelectAll') == 1) ? true : false,

            // ช่อง(Locker Channel)
            'tLockerChanelFrom' => !empty($this->input->post('oetRptLockerChanelFrom')) ? $this->input->post('oetRptLockerChanelFrom') : "",
            'tLockerChanelTo'   => !empty($this->input->post('oetRptLockerChanelTo')) ? $this->input->post('oetRptLockerChanelTo') : "",

            // วันที่เอกสาร
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

    public function index()
    {

        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->mRptDetailDepositAmount->FSnMExecStoreCReport($this->aRptFilter);

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
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase)
    {

        $aDataWhere = array(
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => 1, // เริ่มทำงานหน้าแรก
            'nPerPage' => $this->nPerPage
        );

        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->mRptDetailDepositAmount->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        // Call View Report
        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $this->aRptFilter);

        $aDataView = array(
            'aCompanyInfo' => $this->aCompanyInfo,
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => $aDataReport
        );

        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Piya
     * LastUpdate: -
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataFilter)
    {

        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\reportlocker\rptDetailDepositAmount\rRptDetailDepositAmount.php';

        // Set Parameter To Report
        $oRptDetailDepositAmount = new rRptDetailDepositAmount(array(
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aFilterReport' => $paDataFilter,
            'aDataTextRef' => $this->aText,
            'aDataReturn' => $paDataReport,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUserSessionID' => $this->tUserSessionID
        ));


        $oRptDetailDepositAmount->run();
        $tHtmlViewReport = $oRptDetailDepositAmount->render('wRptDetailDepositAmountHtml', true);
        return $tHtmlViewReport;
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage()
    {

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        $aDataWhere = array(
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => $this->nPage,
            'nPerPage' => $this->nPerPage
        );

        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->mRptDetailDepositAmount->FSaMGetDataReport($aDataWhere, $aDataFilter);

        if (!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataFilter);
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
            'aDataReport' => $aDataReport
        );

        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 02/12/2019 Piya
     * LastUpdate: -
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase)
    {
        try {
            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUserSessionID' => $this->tUserSessionID
            ];

            $nDataCountPage = $this->mRptDetailDepositAmount->FSnMCountDataReportAll($aDataCountData);

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
     * Creator: 02/12/2019 Piya
     * LastUpdate: -
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile()
    {
        try {
            $dDateSendMQ    = date('Y-m-d');
            $dTimeSendMQ    = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');
            // Set Parameter Send MQ
            $tRptQueueName  = 'RPT_'.$this->tSysBchCode.'_'.$this->tRptGroup.'_'.$this->tRptCode;
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
                    'ptBchCode' => $this->tBchCodeLogin
                ]
            ];
            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent'         => 1,
                'tMessage'          => 'Success Send Rabbit MQ.',
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
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }
}
