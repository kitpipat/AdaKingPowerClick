<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';


include APPPATH .'libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';
use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;

date_default_timezone_set("Asia/Bangkok");

class cRptTaxByProduct extends MX_Controller {
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

    public function __construct(){
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsale/mRptTaxByProduct');
        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText = [
            'tTitleReport'          => language('report/report/report', 'tRptTitleRptTaxByProduct'),
            'tRptTaxNo'             => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'         => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'        => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'         => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'         => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch'            => language('report/report/report', 'tRptAddrBranch'),
            'tRptFaxNo'             => language('report/report/report', 'tRptAddrFax'),
            'tRptTel'               => language('report/report/report', 'tRptAddrTel'),
            'tRptDate'              => language('report/report/report','tRptDate'),
            // Filter Heard Report
            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
            'tRptCstFrom'           => language('report/report/report', 'tRptCstFrom'),
            'tRptCstTo'             => language('report/report/report', 'tRptCstTo'),
            'tRptPosTypeName'       => language('report/report/report', 'tRptPosTypeName'),
            'tRptPosType'           => language('report/report/report', 'tRptPosType'),
            'tRptPosType1'          => language('report/report/report', 'tRptPosType1'),
            'tRptPosType2'          => language('report/report/report', 'tRptPosType2'),
            'tRptVat'               => language('report/report/report', 'tRptVat'),
            'tRptSeparateTax'       => language('report/report/report', 'tRptSeparateTax'),
            'tRptPdtCode'           => language('report/report/report','tRptPdtCode'),
            'tRptDataType'          => language('report/report/report','tRptDataType'),

            'tRptTaxSaleMemberDocDateTo'   => language('report/report/report', 'tRptTaxSalePosFilterDocDateTo'),

            // Table Report
            'tRptDocBill'           => language('report/report/report', 'tRptDocBill'),
            'tRptDisChg'            => language('report/report/report', 'tRptDisChg'),
            'tRptTax'               => language('report/report/report', 'tRptTax'),
            'tRptGrand'             => language('report/report/report', 'tRptGrand'),
            'tRptOverall'           => language('report/report/report', 'tRptOverall'),
            'tRptBillNo'            => language('report/report/report', 'tRptBillNo'),
            'tRptTaxSaleMemberDocDateFrom' => language('report/report/report', 'tRptTaxSalePosFilterDocDateFrom'),

            'tRptTaxSalePosDocRef'  => language('report/report/report', 'tRptTaxSalePosDocRef'),
            'tRptCst'               => language('report/report/report', 'tRptCst'),
            'tRptDate'              => language('report/report/report', 'tRptDate'),
            'tSeqPdtCode'           => language('report/report/report', 'tSeqPdtCode'),
            'tRptPdtName'           => language('report/report/report', 'tRptPdtName'),
            'tRptQty'               => language('report/report/report', 'tRptQty'),
            'tRptPricePerUnit'      => language('report/report/report', 'tRptPricePerUnit'),
            'tRptSales'             => language('report/report/report', 'tRptSales'),
            'tRptDiscount'          => language('report/report/report', 'tRptDiscount'),
            'tRptGrandSale'         => language('report/report/report', 'tRptGrandSale'),
            'tRptTotalAllSale'      => language('report/report/report', 'tRptTotalAllSale'),
            'tRptPdtHaveTaxPerTax'  => language('report/report/report', 'tRptPdtHaveTaxPerTax'),
            'tRptRndVal'            => language('report/report/report', 'tRptRndVal'),
            'tRptCstNormal'         => language('report/report/report', 'tRptCstNormal'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptAll'               => language('report/report/report', 'tRptAll'),
            'tRptNoData'            => language('report/report/report', 'tRptNoData'),
            'tRptTaxSalePosTaxId'   => language('report/report/report', 'tRptTaxSalePosTaxId'),
            'tRptVat1'              => language('report/report/report', 'tRptVat1'),
            'tRptVatable1'          => language('report/report/report','tRptVatable1'),
            'tRptVat2'              => language('report/report/report','tRptVat2'),
            'tRptVatable2'          => language('report/report/report','tRptVatable2'),
            'tRptDiff'              => language('report/report/report','tRptDiff'),
            'tRptDocSale'           => language('report/report/report','tRptDocSale'),
            'tRptDocReturn'         => language('report/report/report','tRptDocReturn'),
            'tRptDocType'           => language('report/report/report','tRptDocType'),    
            'tRptUnit'              => language('report/report/report','tRptUnit'),
       
            

            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptAdjMerChantFrom'   => language('report/report/report','tRptAdjMerChantFrom'),
            'tRptAdjMerChantTo'     => language('report/report/report','tRptAdjMerChantTo'),
            'tRptAdjShopFrom'       => language('report/report/report','tRptAdjShopFrom'),
            'tRptAdjShopTo'         => language('report/report/report','tRptAdjShopTo'),
            'tRptAdjPosFrom'        => language('report/report/report','tRptAdjPosFrom'),
            'tRptAdjPosTo'          => language('report/report/report','tRptAdjPosTo'),
            'tRptBranch'            => language('report/report/report', 'tRptBranch'),
            'tRptTotal'             => language('report/report/report', 'tRptTotal'),
            'tRPCTaxNo'             => language('report/report/report', 'tRPCTaxNo'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom'           => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'             => language('report/report/report', 'tRptPosTo'),
            'tPdtCodeTo'            => language('report/report/report', 'tPdtCodeTo'),
            'tPdtCodeFrom'          => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtGrpFrom'           => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'             => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom'          => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'            => language('report/report/report', 'tPdtTypeTo'),
            'tRptAdjWahFrom'        => language('report/report/report', 'tRptAdjWahFrom'),
            'tRptAdjWahTo'          => language('report/report/report', 'tRptAdjWahTo'),
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
            'tUserSessionID'    => $this->tUserSessionID,
            'tCompName'         => $tFullHost,
            'tRptCode'          => $this->tRptCode,
            'nLangID'           => $this->nLngID,

            'tTypeSelect'          => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // ประเภทเครื่องจุดขาย
            'tPosType'          => !empty($this->input->post('ocmPosType')) ? $this->input->post('ocmPosType') : "",

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

            // ลูกค้า
            'tCstCodeFrom'      => !empty($this->input->post('oetRptCstCodeFrom')) ? $this->input->post('oetRptCstCodeFrom') : "",
            'tCstNameFrom'      => !empty($this->input->post('oetRptCstNameFrom')) ? $this->input->post('oetRptCstNameFrom') : "",
            'tCstCodeTo'        => !empty($this->input->post('oetRptCstCodeTo')) ? $this->input->post('oetRptCstCodeTo') : "",
            'tCstNameTo'        => !empty($this->input->post('oetRptCstNameTo')) ? $this->input->post('oetRptCstNameTo') : "",

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

    public function index(){

        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->mRptTaxByProduct->FSnMExecStoreCReport($this->aRptFilter);

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
                break;
            }
        }
    }


    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase){

        $aDataWhere = array(
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => 1, // เริ่มทำงานหน้าแรก
            'nPerPage' => $this->nPerPage,
            'tPosType' => $this->aRptFilter['tPosType']
        );

        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->mRptTaxByProduct->FSaMGetDataReport($aDataWhere, $this->aRptFilter);
   
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
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataFilter){

        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\rptTaxByProduct\rRptTaxByProduct.php';

        // Set Parameter To Report
        $oTaxByProduct = new rRptTaxByProduct(array(
            'aCompanyInfo'    => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aFilterReport'   => $paDataFilter,
            'aDataTextRef'    => $this->aText,
            'aDataReturn'     => $paDataReport,
            'tCompName'       => $this->tCompName,
            'tRptCode'        => $this->tRptCode,
            'tUserSessionID'  => $this->tUserSessionID,
            'oMTaxByProduct'  => $this->mRptTaxByProduct
        ));

        $oTaxByProduct->run();
        $tHtmlViewReport = $oTaxByProduct->render('wRptTaxByProductHtml', true);
        return $tHtmlViewReport;
    }


    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 19/04/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage(){

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        $aDataWhere = array(
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName'      => $this->tCompName,
            'tUserCode'      => $this->tUserLoginCode,
            'tRptCode'       => $this->tRptCode,
            'nPage'          => $this->nPage,
            'nPerPage'       => $this->nPerPage,
            'tPosType'       => $aDataFilter['tPosType']
        );

        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->mRptTaxByProduct->FSaMGetDataReport($aDataWhere, $aDataFilter);

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
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase){
        try {
            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUserSessionID' => $this->tUserSessionID,
                'tPosType' => $this->aRptFilter['tPosType']
            ];

            $nDataCountPage = $this->mRptTaxByProduct->FSnMCountDataReportAll($aDataCountData);

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
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile(){
        try {
            $dDateSendMQ = date('Y-m-d');
            $dTimeSendMQ = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

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
                    'ptSysBchCode'  => $this->tSysBchCode,
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








 
    /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 30/07/2020 Nattakit
     * LastUpdate: 
     * Return: file
     * ReturnType: file
     */
    public function  FSvCCallRptRenderExcel(){
        $tFileName = $this->aText['tTitleReport'].'_'.date('YmdHis').'.xlsx';
        $oWriter = WriterEntityFactory::createXLSXWriter();

         $oWriter->openToBrowser($tFileName); // stream data directly to the browser
          
         $aMulltiRow = $this->FSoCCallRptRenderHedaerExcel();  //เรียกฟังชั่นสร้างส่วนหัวรายงาน
         $oWriter->addRows($aMulltiRow);

            $oBorder = (new BorderBuilder())
                ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
                ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
                ->build();

            $oStyleColums = (new StyleBuilder())
                ->setBorder($oBorder)
                ->build();

            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptDate']),
                WriterEntityFactory::createCell($this->aText['tRptDocBill']),
                WriterEntityFactory::createCell($this->aText['tRptTaxSalePosDocRef']),
                WriterEntityFactory::createCell($this->aText['tRptDocType']),
                WriterEntityFactory::createCell($this->aText['tRptDataType']),
                WriterEntityFactory::createCell($this->aText['tRptPosTypeName']),
                WriterEntityFactory::createCell($this->aText['tRptCst']),
                WriterEntityFactory::createCell($this->aText['tRptPdtCode']),
                WriterEntityFactory::createCell($this->aText['tRptPdtName']),
                WriterEntityFactory::createCell($this->aText['tRptQty']),
                WriterEntityFactory::createCell($this->aText['tRptUnit']),
                WriterEntityFactory::createCell($this->aText['tRptPricePerUnit']),
                WriterEntityFactory::createCell($this->aText['tRptSales']),
                WriterEntityFactory::createCell($this->aText['tRptDiscount']),
                WriterEntityFactory::createCell($this->aText['tRptVat1']),
                WriterEntityFactory::createCell($this->aText['tRptVatable1']),
                WriterEntityFactory::createCell($this->aText['tRptVat2']),
                WriterEntityFactory::createCell($this->aText['tRptVatable2']),
                WriterEntityFactory::createCell($this->aText['tRptDiff']),
                WriterEntityFactory::createCell($this->aText['tRptGrandSale']),

                ];

            /** add a row at a time */
            $singleRow = WriterEntityFactory::createRow($aCells,$oStyleColums);
            $oWriter->addRow($singleRow);
 
        $aDataWhere = array(
            'nPerPage'  => 999999999999,
            'nPage'     => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUserCode' => $this->tUserLoginCode,
            'tPosType' => $this->aRptFilter['tPosType'],
            'tUserSessionID' => $this->tUserSessionID
        );

      //Get Data
      $aDataReport = $this->mRptTaxByProduct->FSaMGetDataReport($aDataWhere, $this->aRptFilter);
        
         /** Create a style with the StyleBuilder */
            $oStyle = (new StyleBuilder())
                    ->setCellAlignment(CellAlignment::RIGHT)
                    ->build();
   
         if(isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) {
             foreach ($aDataReport['raItems'] as $nKey => $aValue) { 

                    $tPosType = $aValue['FNAppType'];
                    $tPosTypeText = $this->aText['tRptPosType'.$tPosType];

                    $tDocType = $aValue['FNXshDocType'];
                    $tDocTypeText = '';
                    if($tDocType == '1'){
                        $tDocTypeText = $this->aText['tRptDocSale'];
                    }
                    if($tDocType == '9'){
                        $tDocTypeText = $this->aText['tRptDocReturn'];
                    }

                    $tDataType = $aValue['FNType'];
                    $tDataTypeText = '';
                    if($tDataType == '1'){
                        $tDataTypeText = 'Header';
                    }
                    if($tDataType == '2'){
                        $tDataTypeText = 'Detail';
                    }
                    if($tDataType == '3'){
                        $tDataTypeText = 'Recieve';
                    }	

                    $tFDXshDocDate = empty($aValue['FDXshDocDate']) ? '' : date('d/m/Y', strtotime($aValue['FDXshDocDate']));
                    $nFCXsdQty = empty($aValue['FCXsdQty']) ? 0 : $aValue['FCXsdQty'];
                    $cFCXsdSetPrice = empty($aValue['FCXsdSetPrice']) ? 0 : $aValue['FCXsdSetPrice'];
                    $cFCXsdAmt = empty($aValue['FCXsdAmt']) ? 0 : $aValue['FCXsdAmt']; 
                    $cFCXsdDis = empty($aValue['FCXsdDis']) ? 0 : $aValue['FCXsdDis'];

                    if($tDataType == 2){
                        $cFCXshVatable = empty($aValue['FCXshVatable']) ? 0 : $aValue['FCXshVatable'];
                        $cFCXshVat = empty($aValue['FCXshVat']) ? 0 : $aValue['FCXshVat'];
                    }else{
                        $cFCXshVatable = 0;
                        $cFCXshVat = 0;
                    }
        
                    $cFCXshDis = empty($aValue['FCXshDis']) ? 0 : $aValue['FCXshDis'];
                    $cFCXshTotalAfDis = empty($aValue['FCXshTotalAfDis']) ? 0 : $aValue['FCXshTotalAfDis'];
                    $cFCXshRnd = empty($aValue['FCXshRnd']) ? 0 : $aValue['FCXshRnd'];
                    $cFCXsdNet = empty($aValue['FCXsdNet']) ? 0 : $aValue['FCXsdNet'];
                    $cFCXshGrand = empty($aValue['FCXshGrand']) ? 0 : $aValue['FCXshGrand'];
                    $cFCXrcNet = empty($aValue['FCXrcNet']) ? 0 : $aValue['FCXrcNet'];


                    // คำนวน มูลค่า(คำนวนใหม่)
                    $nAmtB4DisChg  = $aValue['FCXsdAmtB4DisChg']; //มูลค่ารวมก่อนลด
                    $nNetAFDis     = $aValue['FCXsdNetAFDis'];
                    $nVatType      = $aValue['FTXsdVatType'];   // ประเภทภาษี 1:มีภาษี, 2:ไม่มีภาษี
                    $nVatRate      = $aValue['FCXsdVatRate'];   //อัตราภาษี ณ. ซื้อ
                    $nVATInOrEx    = $aValue['FTXshVATInOrEx']; //ภาษีมูลค่าเพิ่ม 1:รวมใน, 2:แยกนอก

                     //หาภาษี มูลค่า(คำนวนใหม่)
                     if($nVatType == 1){
                        if($nVATInOrEx == 1){
                            $nResultVat = $nNetAFDis-(($nNetAFDis*100)/(100+$nVatRate));   //รวมใน

                        }else if($nVATInOrEx == 2){
                            $nResultVat   = (($nNetAFDis*(100+$nVatRate))/100)-$nNetAFDis; //แยกนอก
                        }
                    }else{
                        $nResultVat = 0.00;
                    }

                    //ยอดแยกภาษี มูลค่า(คำนวนใหม่)
                    $nResultSplitAmount = $nNetAFDis - $nResultVat;

                    // ภาษี (จากระบบ) - ภาษี (คำนวนใหม่)
                    $nDiffVat = str_replace(',','',number_format($aValue['FCXshVat'],2, '.', '')) - str_replace(',','',number_format($nResultVat,2, '.', ''));


                    $values= [
                            WriterEntityFactory::createCell($tFDXshDocDate),
                            WriterEntityFactory::createCell($aValue['FTXshDocNo']),
                            WriterEntityFactory::createCell($aValue['FTXshRefInt']),
                            WriterEntityFactory::createCell($tDocTypeText),
                            WriterEntityFactory::createCell($tDataTypeText),
                            WriterEntityFactory::createCell($tPosTypeText),
                            WriterEntityFactory::createCell($aValue['FTCstName']),
                            WriterEntityFactory::createCell($aValue['FTPdtCode']),
                            WriterEntityFactory::createCell($aValue['FTPdtName']),
                            WriterEntityFactory::createCell(number_format($nFCXsdQty,2),$oStyle),
                            WriterEntityFactory::createCell($aValue['FTPunName']),
                            WriterEntityFactory::createCell(number_format($cFCXsdSetPrice,2),$oStyle),
                            WriterEntityFactory::createCell(number_format($cFCXsdAmt,2),$oStyle),
                            WriterEntityFactory::createCell(number_format($cFCXsdDis,2),$oStyle),
                            WriterEntityFactory::createCell(number_format($aValue['FCXshVat'],2),$oStyle),
                            WriterEntityFactory::createCell(number_format($aValue['FCXshVatable'],2),$oStyle),
                            WriterEntityFactory::createCell(number_format($nResultVat,2),$oStyle),
                            WriterEntityFactory::createCell(number_format($nResultSplitAmount,2),$oStyle),
                            WriterEntityFactory::createCell(number_format($nDiffVat,2),$oStyle),
                            WriterEntityFactory::createCell(number_format($aValue['FCXsdNet'],2),$oStyle),
                    ];
                    $aRow = WriterEntityFactory::createRow($values);
                    $oWriter->addRow($aRow);
                 
                    if(($nKey+1)==FCNnHSizeOf($aDataReport['raItems'])){ //SumFooter
                        $values= [
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(NULL),

                    ];
                    $aRow = WriterEntityFactory::createRow($values,$oStyleColums);
                    $oWriter->addRow($aRow);

                    }
             }
            }

            $aMulltiRow = $this->FSoCCallRptRenderFooterExcel();//เรียกฟังชั่นสร้างส่วนท้ายรายงาน
            $oWriter->addRows($aMulltiRow);

        $oWriter->close();
    } 

    /**
     * Functionality: Render Excel Report Header
     * Parameters:  Function Parameter
     * Creator: 30/07/2020 Nattakit
     * LastUpdate: 
     * Return: oject
     * ReturnType: oject
     */
    public function FSoCCallRptRenderHedaerExcel(){
        $oStyle = (new StyleBuilder())
        ->setFontBold()
        ->setFontSize(12)
        ->build();
  
        $aCells = [
        WriterEntityFactory::createCell($this->aCompanyInfo['FTCmpName']),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell($this->aText['tTitleReport']),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells,$oStyle);

        $tAddress = '';
        if(isset($this->aCompanyInfo) && !empty($this->aCompanyInfo)) {
        if ($this->aCompanyInfo['FTAddVersion'] == '1') { 
               $tAddress = $this->aCompanyInfo['FTAddV1No'].' '.$this->aCompanyInfo['FTAddV1Road'].' '.$this->aCompanyInfo['FTAddV1Soi'].' '.$this->aCompanyInfo['FTSudName'].' '.$this->aCompanyInfo['FTDstName'].' '.$this->aCompanyInfo['FTPvnName'].' '.$this->aCompanyInfo['FTAddV1PostCode'];
        }
        if ($this->aCompanyInfo['FTAddVersion'] == '2') { 
               $tAddress =  $this->aCompanyInfo['FTAddV2Desc1'].' '.$this->aCompanyInfo['FTAddV2Desc2'];
        }
    }

    $aCells = [
        WriterEntityFactory::createCell($tAddress),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);


        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptTel'].' '.$this->aCompanyInfo['FTCmpTel']),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            ];
    
        $aMulltiRow[]  = WriterEntityFactory::createRow($aCells);



        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptBranch'] .' '. $this->aCompanyInfo['FTBchName']),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            ];
    
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);


        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptTaxSalePosTaxId'] .' '. $this->aCompanyInfo['FTAddTaxNo']),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            ];
    
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);


        $aCells = [
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            ];
    
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);


        if((isset($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateFrom'])) && (isset($this->aRptFilter['tDocDateTo']) && !empty($this->aRptFilter['tDocDateTo']))){
            $aCells = [
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell($this->aText['tRptTaxSaleMemberDocDateFrom'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateFrom'])).' '.$this->aText['tRptTaxSaleMemberDocDateTo'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateTo']))),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }

        $aCells = [
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell($this->aText['tRptDatePrint'].' '.date('d/m/Y').' '.$this->aText['tRptTimePrint'].' '.date('H:i:s')),

            ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        return $aMulltiRow;

    }

    /**
     * Functionality: Render Excel Report Footer
     * Parameters:  Function Parameter
     * Creator: 30/07/2020 Nattakit
     * LastUpdate: 
     * Return: oject
     * ReturnType: oject
     */
    public function FSoCCallRptRenderFooterExcel(){

        $oStyleFilter = (new StyleBuilder())
        ->setFontBold()
        ->build();
    $aCells = [
        WriterEntityFactory::createCell($this->aText['tRptConditionInReport']),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        WriterEntityFactory::createCell(NULL),
        ];
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells,$oStyleFilter);
    

        if (isset($this->aRptFilter['tBchCodeSelect']) && !empty($this->aRptFilter['tBchCodeSelect'])) {
          $tBchSelect =  ($this->aRptFilter['bBchStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tBchNameSelect'];
        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptBchFrom'].' : '.$tBchSelect),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
            

        if (isset($this->aRptFilter['tMerCodeSelect']) && !empty($this->aRptFilter['tMerCodeSelect'])) {
            $tMerSelect =  ($this->aRptFilter['bMerStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tMerNameSelect'];
          $aCells = [
              WriterEntityFactory::createCell($this->aText['tRptMerFrom'].' : '.$tMerSelect),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              WriterEntityFactory::createCell(NULL),
              ];
              $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
          }

          if (isset($this->aRptFilter['tShpCodeSelect']) && !empty($this->aRptFilter['tShpCodeSelect'])) {   
            $tShpSelect =  ($this->aRptFilter['bShpStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tShpNameSelect'];
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptAdjShopFrom'].' : '.$tShpSelect),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    WriterEntityFactory::createCell(NULL),
                    ];
                    $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
          }

          if (isset($this->aRptFilter['tPosCodeSelect']) && !empty($this->aRptFilter['tPosCodeSelect'])) {
            $tPosSelect =  ($this->aRptFilter['bPosStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tPosCodeSelect'];
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptPosFrom'].' : '.$tPosSelect),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
          }


          if ((isset($this->aRptFilter['tCstCodeFrom']) && !empty($this->aRptFilter['tCstCodeFrom'])) && (isset($this->aRptFilter['tCstCodeTo']) && !empty($this->aRptFilter['tCstCodeTo']))) {   
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptCstFrom'].' : '.$this->aRptFilter['tCstCodeFrom'].' '.$this->aText['tRptCstTo'].' : '.$this->aRptFilter['tCstCodeTo']),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                ];
                $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
          }

          return $aMulltiRow;

    }



   


   
}
