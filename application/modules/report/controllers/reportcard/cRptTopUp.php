<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

date_default_timezone_set("Asia/Bangkok");

class cRptTopUp extends MX_Controller {
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
     * Sys Bch Code
     * @var string 
     */
    public $tSysBchCode;

    public function __construct() {
        $this->load->model('report/report/mReport');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/reportcard/mRptTopUp');

        // Init Report
        $this->init();
        parent::__construct();
    }
   
    private function init() {
        $this->aText = [
            
            'tTitleReport'                  => language('report/report/report', 'tRPCTitleRptTopUp'),
            'tRptTaxNo'                     => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'                 => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'                => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'                 => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'                 => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch'                    => language('report/report/report', 'tRptAddrBranch'),
            'tRptFaxNo'                     => language('report/report/report', 'tRptAddrFax'),
            'tRptTel'                       => language('report/report/report', 'tRptAddrTel'),

            // Filter Heard Report
            'tRptCardCodeFrom'              => language('report/report/report', 'tRptCardCodeFrom'),
            'tRptCardCodeTo'                => language('report/report/report', 'tRptCardCodeTo'),
            'tRPCEmpCodeFrom'               => language('report/report/report', 'tRPCEmpCodeFrom'),
            'tRPCEmpCodeTo'                 => language('report/report/report', 'tRPCEmpCodeTo'),
            'tRPCStaCrdFrom'                => language('report/report/report', 'tRPCStaCrdFrom'),
            'tRPCStaCrdTo'                  => language('report/report/report', 'tRPCStaCrdTo'),
            'tRptDateFrom'                  => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'                    => language('report/report/report', 'tRptDateTo'),
            'tRptConditionInReport'         => language('report/report/report', 'tRptConditionInReport'),
            'tRptAll'                       => language('report/report/report', 'tRptAll'),
    

            /** Table Report */
            'tRPC14TBCardCode'              => language('report/report/report','tRPC14TBCardCode'),
            'tRPC14TBCardTypeName'          => language('report/report/report','tRPC14TBCardTypeName'),
            'tRPC14TBCardHolderID'          => language('report/report/report','tRPC14TBCardHolderID'),
            'tRPC14TBCardName'              => language('report/report/report','tRPC14TBCardName'),
            'tRPC14TBDptName'               => language('report/report/report','tRPC14TBDptName'),
            'tRPC14TBCardTxnDocNoRef'       => language('report/report/report','tRPC14TBCardTxnDocNoRef'),
            'tRPC14TBCardUsrName'           => language('report/report/report','tRPC14TBCardUsrName'),
            'tRPC14TBCardTxnDocDate'        => language('report/report/report','tRPC14TBCardTxnDocDate'),
            'tRPC14TBCardStaActive'         => language('report/report/report','tRPC14TBCardStaActive'),

            'tRPC14TBCardTxnCrdValue'       => language('report/report/report','tRPC14TBCardTxnCrdValue'),
            'tRPC14TBCardTxnValue'          => language('report/report/report','tRPC14TBCardTxnValue'),
            'tRPC14TBCardTxnValAftTrans'    => language('report/report/report','tRPC14TBCardTxnValAftTrans'),

            'tRPC14CardDetailStaActive'     => language('report/report/report','tRPC14CardDetailStaActive'),
            'tRPC14CardDetailStaActive1'    => language('report/report/report','tRPC14CardDetailStaActive1'),
            'tRPC14CardDetailStaActive2'    => language('report/report/report','tRPC14CardDetailStaActive2'),
            'tRPC14CardDetailStaActive3'    => language('report/report/report','tRPC14CardDetailStaActive3'),
            'tRPCTBFooterSumAll'            => language('report/report/report','tRPCTBFooterSumAll')
        ];

        $this->tSysBchCode     = SYS_BCH_CODE;
        $this->tBchCodeLogin   = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage        = 100;
        $this->nOptDecimalShow = FCNxHGetOptionDecimalShow();
        
        $tIP                  = $this->input->ip_address();
        $tFullHost            = gethostbyaddr($tIP);
        $this->tCompName      = $tFullHost;
        
        $this->nLngID         = FCNaHGetLangEdit();
        $this->tRptCode       = $this->input->post('ohdRptCode');
        $this->tRptGroup      = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID = $this->session->userdata('tSesSessionID');
        $this->tRptRoute      = $this->input->post('ohdRptRoute');
        $this->tRptExportType = $this->input->post('ohdRptTypeExport');
        $this->nPage          = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode = $this->session->userdata('tSesUsername');

        // Report Filter
        $this->aRptFilter = [
            'tUserSession'        => $this->tUserSessionID,
            'tCompName'           => $this->tCompName,
            'tRptCode'            => $this->tRptCode,
            'nLangID'             => $this->nLngID,
            
            // หมายเลขบัตร
            'tRptCardCode'        => !empty($this->input->post('oetRptCardCodeFrom')) ? $this->input->post('oetRptCardCodeFrom') : '',
            'tRptCardName'        => !empty($this->input->post('oetRptCardNameFrom')) ? $this->input->post('oetRptCardNameFrom') : '',
            'tRptCardCodeTo'      => !empty($this->input->post('oetRptCardCodeTo')) ? $this->input->post('oetRptCardCodeTo') : '',
            'tRptCardNameTo'      => !empty($this->input->post('oetRptCardNameTo')) ? $this->input->post('oetRptCardNameTo') : '',
            
            // รหัสพนักงาน
            'tRptEmpCode'         => !empty($this->input->post('oetRptEmpCodeFrom')) ? $this->input->post('oetRptEmpCodeFrom') : "",
            'tRptEmpName'         => !empty($this->input->post('oetRptEmpNameTo')) ? $this->input->post('oetRptEmpNameTo') : "",
            'tRptEmpCodeTo'       => !empty($this->input->post('oetRptEmpCodeTo')) ? $this->input->post('oetRptEmpCodeTo') : "",
            'tRptEmpNameTo'       => !empty($this->input->post('oetRptEmpNameTo')) ? $this->input->post('oetRptEmpNameTo') : "",
            
            // สถานะบัตร
            'ocmRptStaCardFrom'   => !empty($this->input->post('ocmRptStaCardFrom')) ? $this->input->post('ocmRptStaCardFrom') : "",
            'tRptStaCardFrom'     => !empty($this->input->post('ohdRptStaCardNameFrom')) ? $this->input->post('ohdRptStaCardNameFrom') : "",
            'ocmRptStaCardTo'     => !empty($this->input->post('ocmRptStaCardTo')) ? $this->input->post('ocmRptStaCardTo') : "",
            'tRptStaCardTo'       => !empty($this->input->post('ohdRptStaCardNameTo')) ? $this->input->post('ohdRptStaCardNameTo') : "",
      
 
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
            $this->mRptTopUp->FSnMExecStoreReport($this->aRptFilter);

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
    
    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 29/10/2019 Saharat(GolF)
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {
        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode'    => $this->tUserLoginCode,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => 1, // เริ่มทำงานหน้าแรก
            'nRow'         => $this->nPerPage,
        );
   
        // Get Data Report
        $aDataReport = $this->mRptTopUp->FSaMGetDataReport($aDataWhere, $this->aRptFilter);
        
        // Call View Report
        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $this->aRptFilter);
        
        $aDataView = array(
            'aCompanyInfo'    => $this->aCompanyInfo,
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter'     => $this->aRptFilter,
            'aDataReport'     => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /*===== Begin Init Variable ====================================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /*===== End Init Variable ======================================================*/
        
        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode'    => $this->tUserLoginCode,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => $this->nPage,
            'nRow'         => $this->nPerPage,

        );
        $aDataReport = $this->mRptTopUp->FSaMGetDataReport($aDataWhere, $aDataFilter);

        if (!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataFilter);
        } else {
            $tViewRenderKool = "";
        }

        $aDataView = array(
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter'     => $aDataFilter,
            'aDataReport'     => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

     /**
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 saharat(GolF)
     * LastUpdate: -
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataFilter) {

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode'    => $this->tUserLoginCode,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => $this->nPage,
            'nRow'         => $this->nPerPage,
        );

        //GetDataReport
        $aDataReport = $this->mRptTopUp->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        if($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage']){ 
            // เรียก Summary เฉพาะหน้าสุดท้าย
            $aSumDataReport = $this->mRptTopUp->FSaMRPTCRDGetDataRptTopUpSum($aDataWhere);
        }

        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\reportcard\rptTopUp\rRptTopUp.php';

        // Set Parameter To Report
            $oRptTopUp = new rRptTopUp(array(
            'nCurrentPage'      => $paDataReport['rnCurrentPage'],
            'nAllPage'          => $paDataReport['rnAllPage'],
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aFilterReport'     => $paDataFilter,
            'aDataTextRef'      => $this->aText,
            'aDataReturn'       => $paDataReport,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aSumDataReport'    => isset($aSumDataReport) ? $aSumDataReport : []

        ));

        $oRptTopUp->run();
        $tHtmlViewReport = $oRptTopUp->render('wRptTopUpHtml', true);
        return $tHtmlViewReport;
    }
 

    /**
     * Functionality: Get Count Data in Temp
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 30/10/2019 Saharat(GolF)
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase) {

        try {
            $aDataCountData = [
                'tCompName'    => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode'     => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tUserSession' => $paDataSwitchCase['paDataFilter']['tUserSession'],

            ];

            $nDataCountPage = $this->mRptTopUp->FSaMCountDataReportAll($aDataCountData);

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
     * Creator: 10/10/2019 Piya
     * LastUpdate: 30/10/2019 Saharat(GolF)
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
            $tRptQueueName = 'RPT_'.$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams'    => [
                    'ptRptCode'       => $this->tRptCode,
                    'pnPerFile'       => 20000,
                    'ptUserCode'      => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pnLngID'         => $this->nLngID,
                    'ptFilter'        => $this->aRptFilter,
                    'ptRptExpType'    => $this->tRptExportType,
                    'ptComName'       => $this->tCompName,
                    'ptDate'          => $tDateSendMQ,
                    'ptTime'          => $tTimeSendMQ,
                    'ptBchCode'       => $this->tBchCodeLogin
                ]
            ];

            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode'    => $this->tSysBchCode, 
                    'ptComName'       => $this->tCompName,
                    'ptRptCode'       => $this->tRptCode,
                    'ptUserCode'      => $this->tUserLoginCode,
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


