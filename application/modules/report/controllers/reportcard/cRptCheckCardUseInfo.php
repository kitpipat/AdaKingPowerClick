<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

include APPPATH . 'libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Common\Entity\Style\CellAlignment;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;

date_default_timezone_set("Asia/Bangkok");

class cRptCheckCardUseInfo extends MX_Controller {

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
        $this->load->model('report/reportcard/mRptCheckCardUseInfo');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = [

            'tTitleReport'                    => language('report/report/report','tRPCTitleRptCheckCardUseInfo'),
            'tRptTaxNo'                       => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'                   => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'                  => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'                   => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'                   => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch'                      => language('report/report/report', 'tRptAddrBranch'),
            'tRptFaxNo'                       => language('report/report/report', 'tRptAddrFax'),
            'tRptTel'                         => language('report/report/report', 'tRptAddrTel'),
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),
            /** Filter */
            'tRptCardCodeFrom'                => language('report/report/report', 'tRptCardCodeFrom'),
            'tRptCardCodeTo'                  => language('report/report/report', 'tRptCardCodeTo'),
            'tRPCEmpCodeFrom'                 => language('report/report/report', 'tRPCEmpCodeFrom'),
            'tRPCEmpCodeTo'                   => language('report/report/report', 'tRPCEmpCodeTo'),
            'tRPCStaCrdFrom'                  => language('report/report/report', 'tRPCStaCrdFrom'),
            'tRPCStaCrdTo'                    => language('report/report/report', 'tRPCStaCrdTo'),
            'tRptDateFrom'                    => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'                      => language('report/report/report', 'tRptDateTo'),
            'tRptConditionInReport'           => language('report/report/report', 'tRptConditionInReport'),
            'tRptAll'                         => language('report/report/report', 'tRptAll'),

            /** Table Report */
            'tRPC13TBCardCode'                => language('report/report/report','tRPC13TBCardCode'),
            'tRPC13TBCardTypeName'            => language('report/report/report','tRPC13TBCardTypeName'),
            'tRPC13TBCardHolderID'            => language('report/report/report','tRPC13TBCardHolderID'),
            'tRPC13TBCardName'                => language('report/report/report','tRPC13TBCardName'),
            'tRPC13TBCardStaActive'           => language('report/report/report','tRPC13TBCardStaActive'),
            'tRPC13TBDptName'                 => language('report/report/report','tRPC13TBDptName'),
            'tRPC13TBCardPosCode'             => language('report/report/report','tRPC13TBCardPosCode'),
            'tRPC13TBCardTxnDocNoRef'         => language('report/report/report','tRPC13TBCardTxnDocNoRef'),
            'tRPC13TBCardTxnDocTypeName'      => language('report/report/report','tRPC13TBCardTxnDocTypeName'),
            'tRPC13TBCardTxnDocDate'          => language('report/report/report','tRPC13TBCardTxnDocDate'),
            'tRPC13TBCardTxnValue'            => language('report/report/report','tRPC13TBCardTxnValue'),
            'tRPC13TBCardBalance'             => language('report/report/report','tRPC13TBCardBalance'),
            'tRPC13TBCardTxnCrdAftTrans'      => language('report/report/report','tRPC13TBCardTxnCrdAftTrans'),

            /** Status Report */
            'tRPC13CardDetailStaActive'       => language('report/report/report','tRPC13CardDetailStaActive'),
            'tRPC13CardDetailStaActive1'      => language('report/report/report','tRPC13CardDetailStaActive1'),
            'tRPC13CardDetailStaActive2'      => language('report/report/report','tRPC13CardDetailStaActive2'),
            'tRPC13CardDetailStaActive3'      => language('report/report/report','tRPC13CardDetailStaActive3'),
            'tRPCTBFooterSumAll'              => language('report/report/report','tRPCTBFooterSumAll'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRPCOperator'                    => language('report/report/report','tRPCOperator'),
            'tRptTaxSaleTaxNo' => language('report/report/report', 'tRptTaxSaleTaxNo'),

            /** Filter */
            'tRptBchFrom'               => language('report/report/report','tRPCBchFrom'),
            'tRptBchTo'                 => language('report/report/report','tRPCBchTo'),
            'tRptBchFrom'               => language('report/report/report','tRptBchFrom'),
            'tRptBchTo'                 => language('report/report/report','tRptBchTo'),
            'tRptAll'                   => language('report/report/report','tRptAll'),
            'tRptMerFrom'               => language('report/report/report','tRptMerFrom'),
            'tRptMerTo'                 => language('report/report/report','tRptMerTo'),
            'tRptShopFrom'              => language('report/report/report','tRptShopFrom'),
            'tRptShopTo'                => language('report/report/report','tRptShopTo'),
            'tRptPosFrom'               => language('report/report/report','tRptPosFrom'),
            'tRptPosTo'                 => language('report/report/report','tRptPosTo'),

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

            'tTypeSelect'         => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

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

            // สาขา(Branch)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom'      => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'      => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'        => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'        => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeFrom'      => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
            'tMerNameFrom'      => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
            'tMerCodeTo'        => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
            'tMerNameTo'        => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeFrom'      => (empty($this->input->post('oetRptPosCodeFrom'))) ? '' : $this->input->post('oetRptPosCodeFrom'),
            'tPosNameFrom'      => (empty($this->input->post('oetRptPosNameFrom'))) ? '' : $this->input->post('oetRptPosNameFrom'),
            'tPosCodeTo'        => (empty($this->input->post('oetRptPosCodeTo'))) ? '' : $this->input->post('oetRptPosCodeTo'),
            'tPosNameTo'        => (empty($this->input->post('oetRptPosNameTo'))) ? '' : $this->input->post('oetRptPosNameTo'),
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'   => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {

        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->mRptCheckCardUseInfo->FSnMExecStoreReport($this->aRptFilter);

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
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    // $this->FSoCChkDataReportInTableTemp($aDataSwitchCase);
                    break;
                case 'pdf':
                    // $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 31/10/2019 Saharat(GolF)
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
        $aDataReport       = $this->mRptCheckCardUseInfo->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

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
     * LastUpdate: 31/10*2019 Saharat(GolF)
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

        $aDataReport = $this->mRptCheckCardUseInfo->FSaMGetDataReport($aDataWhere, $aDataFilter);

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
     * Creator: 31/10/2019 saharat(GolF)
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
        $aDataReport = $this->mRptCheckCardUseInfo->FSaMGetDataReport($aDataWhere);

        if($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage']){
            // เรียก Summary เฉพาะหน้าสุดท้าย
            $aSumDataReport = $this->mRptCheckCardUseInfo->FSaMRPTCRDGetDataRptCheckCardUseInfoSum($aDataWhere);
        }


        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\reportcard\rptCheckCardUseInfo\rRptCheckCardUseInfo.php';

        // Set Parameter To Report
            $oRptCheckCardUseInfo = new rRptCheckCardUseInfo(array(
            'nCurrentPage'      => $paDataReport['rnCurrentPage'],
            'nAllPage'          => $paDataReport['rnAllPage'],
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aFilterReport'     => $paDataFilter,
            'aDataTextRef'      => $this->aText,
            'aDataReturn'       => $paDataReport,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aSumDataReport'    => isset($aSumDataReport) ? $aSumDataReport : []

        ));

        $oRptCheckCardUseInfo->run();
        $tHtmlViewReport = $oRptCheckCardUseInfo->render('wRptCheckCardUseInfoHtml', true);
        return $tHtmlViewReport;
    }

    /**
     * Functionality: Get Count Data in Temp
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 31/10/2019 Saharat(GolF)
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase) {

        try {
            $aDataCountData    = [
                'tCompName'    => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode'     => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tUserSession' => $paDataSwitchCase['paDataFilter']['tUserSession'],
            ];

            $nDataCountPage = $this->mRptCheckCardUseInfo->FSaMCountDataReportAll($aDataCountData);

            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent'     => 1,
                'tMessage'      => 'Success Count Data All'
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
     * LastUpdate: 31/10/2019 Saharat(GolF)
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
                'aDataSubscribe'      => array(
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


     /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 25/09/2020 Sooksanti
     * LastUpdate:
     * Return: file
     * ReturnType: file
     */
    function FSvCCallRptRenderExcel(){

        $tFileName  = $this->aText['tTitleReport'] . '_' . date('YmdHis') . '.xlsx';
        $oWriter    = WriterEntityFactory::createXLSXWriter();

        $oWriter->openToBrowser($tFileName); // stream data directly to the browser

        $aMulltiRow = $this->FSoCCallRptRenderHedaerExcel(); //เรียกฟังชั่นสร้างส่วนหัวรายงาน
        $oWriter->addRows($aMulltiRow);


        $oBorder = (new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
            ->build();

        $oStyleColums = (new StyleBuilder())
            ->setBorder($oBorder)
            ->setFontBold()
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardTypeName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardHolderID')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardStaActive')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBDptName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardPosCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardTxnDocNoRef')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardTxnDocTypeName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPCOperator')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardTxnDocDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardTxnValue')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardTxnCrdAftTrans')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC13TBCardBalance')),

        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName'    => $this->tCompName,
            'tUserCode'    => $this->tUserLoginCode,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => 1,
            'nRow'         => 999999999,
        );

        //GetDataReport
        $aDataReport = $this->mRptCheckCardUseInfo->FSaMGetDataReport($aDataWhere);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) {
            foreach ($aDataReport['raItems'] as $nKey => $aValue) {

                $tExplodeCtyName        = explode(";",$aValue['rtCtyName']);
                $tExplodeHolderID       = explode(";",$aValue['rtCrdHolderID']);
                $tExplodeCrdName        = explode(";",$aValue['rtCrdName']);
                $tExplodeStaAct         = explode(";",$aValue['rtCrdStaActive']);
                $tExplodeDptName        = explode(";",$aValue['rtDptName']);
                $tExplodeTxnPosCode     = explode(";",$aValue['rtTxnPosCode']);
                $tExplodeDocNoRef       = explode(";",$aValue['rtTxnDocNoRef']);
                $tExplodeDocTypeName    = explode(";",$aValue['rtTxnDocTypeName']);

                $tExplodeTxnDocCreateBy  = explode(";",$aValue['rtTxnDocCreateBy']);
                $tExplodeCrdAftTrans    = explode(";",$aValue['rtCrdAftTrans']);
                $tExplodeCrdBalance     = explode(";",$aValue['rtCrdBalance']);



                switch($tExplodeStaAct[1]){
                    case '1':
                        $tStaActive  = $this->aText['tRPC13CardDetailStaActive1'];
                    break;
                    case '2':
                        $tStaActive  = $this->aText['tRPC13CardDetailStaActive2'];
                    break;
                    case '3':
                        $tStaActive  = $this->aText['tRPC13CardDetailStaActive3'];
                    break;
                    default:
                        $tStaActive  = $this->aText['tRPC13CardDetailStaActive'];
                }

                $values = [
                    WriterEntityFactory::createCell($aValue['rtCrdCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeCtyName[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeHolderID[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeCrdName[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tStaActive),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeDptName[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeTxnPosCode[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeDocNoRef[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeDocTypeName[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tExplodeTxnDocCreateBy[1]),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['rtTxnDocDate']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['rtTxnValue'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($tExplodeCrdAftTrans[1])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($tExplodeCrdBalance[1])),
                ];
                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);
            }
        }

        $aMulltiRow = $this->FSoCCallRptRenderFooterExcel(); //เรียกฟังชั่นสร้างส่วนท้ายรายงาน
        $oWriter->addRows($aMulltiRow);

        $oWriter->close();

    }


    /**
     * Functionality: Render Excel Report Header
     * Parameters:  Function Parameter
     * Creator: 28/09/2020 Sooksanti
     * LastUpdate:
     * Return: oject
     * ReturnType: oject
     */
    function FSoCCallRptRenderHedaerExcel(){
        if (isset($this->aCompanyInfo) && count($this->aCompanyInfo)>0) {
    $tFTAddV1Village = $this->aCompanyInfo['FTAddV1Village']; 
            $tFTCmpName = $this->aCompanyInfo['FTCmpName'];
            $tFTAddV1No = $this->aCompanyInfo['FTAddV1No'];
            $tFTAddV1Road = $this->aCompanyInfo['FTAddV1Road'];
            $tFTAddV1Soi = $this->aCompanyInfo['FTAddV1Soi'];
            $tFTSudName = $this->aCompanyInfo['FTSudName'];
            $tFTDstName = $this->aCompanyInfo['FTDstName'];
            $tFTPvnName = $this->aCompanyInfo['FTPvnName'];
            $tFTAddV1PostCode = $this->aCompanyInfo['FTAddV1PostCode'];
            $tFTAddV2Desc1 = $this->aCompanyInfo['FTAddV2Desc1'];
            $tFTAddV2Desc2 = $this->aCompanyInfo['FTAddV2Desc2'];
            $tFTAddVersion = $this->aCompanyInfo['FTAddVersion'];
            $tFTBchName = $this->aCompanyInfo['FTBchName'];
            $tFTAddTaxNo = $this->aCompanyInfo['FTAddTaxNo'];
            $tFTCmpTel = $this->aCompanyInfo['FTAddTel'];
            $tRptFaxNo = $this->aCompanyInfo['FTAddFax'];
        }else {
            $tFTCmpTel = "";
            $tFTCmpName = "";
            $tFTAddV1No = "";
            $tFTAddV1Road = "";
            $tFTAddV1Soi = "";
            $tFTSudName = "";
            $tFTDstName = "";
            $tFTPvnName = "";
            $tFTAddV1PostCode = "";
            $tFTAddV2Desc1 = "1"; $tFTAddV1Village = "";
            $tFTAddV2Desc2 = "2";
            $tFTAddVersion = "";
            $tFTBchName = "";
            $tFTAddTaxNo = "";
            $tRptFaxNo = "";
        }
        $oStyle = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(12)
            ->build();

        $aCells = [
            WriterEntityFactory::createCell($tFTCmpName),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tTitleReport']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells, $oStyle);

        $tAddress = '';
        if ($tFTAddVersion == '1') {
            $tAddress = $tFTAddV1No . ' ' .$tFTAddV1Village. ' '.$tFTAddV1Road.' ' . $tFTAddV1Soi . ' ' . $tFTSudName . ' ' . $tFTDstName . ' ' . $tFTPvnName . ' ' . $tFTAddV1PostCode;
        }
        if ($tFTAddVersion == '2') {
            $tAddress = $tFTAddV2Desc1 . ' ' . $tFTAddV2Desc2;
        }

        $aCells = [
            WriterEntityFactory::createCell($tAddress),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);


        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptTel'] . ' ' . $tFTCmpTel . ' '.$this->aText['tRptFaxNo'] . ' ' . $tRptFaxNo),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptBranch'] . ' ' . $tFTBchName),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);


        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRPCTaxNo'] . ' : ' . $tFTAddTaxNo),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        $aCells = [
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $this->aText['tRptTimePrint'] . ' ' . date('H:i:s')),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        if ((isset($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateFrom'])) && (isset($this->aRptFilter['tDocDateTo']) && !empty($this->aRptFilter['tDocDateTo']))) {
            $aCells = [
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRptDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        return $aMulltiRow;
    }


    /**
     * Functionality: Render Excel Report Footer
     * Parameters:  Function Parameter
     * Creator: 25/09/2020 Sooksanti
     * LastUpdate:
     * Return: oject
     * ReturnType: oject
     */
    function FSoCCallRptRenderFooterExcel(){
        $oStyleFilter = (new StyleBuilder())
            ->setFontBold()
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(null),
        ];
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptConditionInReport']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells, $oStyleFilter);


        // Fillterฺ หมายเลขบัตร แบบช่วง
        if (!empty($this->aRptFilter['tRptCardCode']) && !empty($this->aRptFilter['tRptCardCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptCardCodeFrom'] . ' : ' . $this->aRptFilter['tRptCardCode'] . '     ' . $this->aText['tRptCardCodeTo'] . ' : ' . $this->aRptFilter['tRptCardCodeTo']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }

        if (!empty($this->aRptFilter['tRptEmpCode']) && !empty($this->aRptFilter['tRptEmpCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRPCEmpCodeFrom'] . ' : ' . $this->aRptFilter['tRptEmpCode'] . '     ' . $this->aText['tRPCEmpCodeTo'] . ' : ' . $this->aRptFilter['tRptEmpCodeTo']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }


            // สาขา แบบเลือก
            if (!empty($this->aRptFilter['tBchCodeSelect'])) {
                $tBchSelectText = ($this->aRptFilter['bBchStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tBchNameSelect'];
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptBchFrom'] . ' : ' . $tBchSelectText),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
            }

            // กลุ่มธุรกิจ แบบเลือก
            if (!empty($this->aRptFilter['tMerCodeSelect'])) {
                $tMerSelectText = ($this->aRptFilter['bMerStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tMerNameSelect'];
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptMerFrom'] . ' : ' . $tMerSelectText),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
            }

            // ร้านค้า แบบเลือก
            if (!empty($this->aRptFilter['tShpCodeSelect'])) {
                $tShpSelectText = ($this->aRptFilter['bShpStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tShpNameSelect'];
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptShopFrom'] . ' : ' . $tShpSelectText),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
            }

            // เครื่องจุดขาย (Pos) แบบเลือก
            if (!empty($this->aRptFilter['tPosCodeSelect'])) {
                $tPosSelectText = ($this->aRptFilter['bPosStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tPosNameSelect'];
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptPosFrom'] . ' : ' . $tPosSelectText),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
            }

        return $aMulltiRow;
    }



}
