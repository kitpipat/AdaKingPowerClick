<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");

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
class cRptMnyShotOverMonthly extends MX_Controller
{

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

    public function __construct()
    {
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsale/mRptMnyShotOverMonthly');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init()
    {
        $this->aText = [

            // TitleReport
            'tTitleReport' => language('report/report/report', 'tRptMnyShowOverMonthlyTitle'),
            'tDatePrint' => language('report/report/report', 'tRptAdjStkVDDatePrint'),
            'tTimePrint' => language('report/report/report', 'tRptAdjStkVDTimePrint'),

            // Filter Heard Report
            'tRptBchFrom' => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo' => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom' => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo' => language('report/report/report', 'tRptShopTo'),
            'tPdtCodeFrom' => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo' => language('report/report/report', 'tPdtCodeTo'),
            'tPdtGrpFrom' => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo' => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom' => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo' => language('report/report/report', 'tPdtTypeTo'),
            'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo' => language('report/report/report', 'tRptDateTo'),
            'tRptSaleTaxByMonthlyTotal' => language('report/report/report', 'tRptSaleTaxByMonthlyTotal'),

            // Address Language
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
            'tRptAdjStkVDTotalSub' => language('report/report/report', 'tRptAdjStkVDTotalSub'),
            'tRptAdjStkVDTotalFooter' => language('report/report/report', 'tRptAdjStkVDTotalFooter'),
            'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
            'tRptTel' => language('report/report/report', 'tRptTel'),
            // Table Label
            'tRptBillNo' => language('report/report/report', 'tRptBillNo'),
            'tRptDate' => language('report/report/report', 'tRptDate'),
            'tRptProduct' => language('report/report/report', 'tRptProduct'),
            'tRptCabinetnumber' => language('report/report/report', 'tRptCabinetnumber'),
            'tRptPrice' => language('report/report/report', 'tRptPrice'),
            'tRptSales' => language('report/report/report', 'tSales'),
            'tRptDiscount' => language('report/report/report', 'tDiscount'),
            'tRptTax' => language('report/report/report', 'tRptTax'),
            'tRptGrand' => language('report/report/report', 'tRptGrand'),
            'tRptTotalSub' => language('report/report/report', 'tRptTotalSub'),
            'tRptTotalFooter' => language('report/report/report', 'tRptTotalFooter'),
            // 'tRptTotalFooter'   => language('report/report/report', 'tRptTotalFooter'),
            // No Data Report
            'tRptNoData' => language('common/main/main', 'tCMNNotFoundData'),

            //อัพเดทใหม่ 18/11/2019 Napat
            'tRptPosTypeName' => language('report/report/report', 'tRptPosTypeName'),
            'tRptPosType' => language('report/report/report', 'tRptPosType'),
            'tRptPosType1' => language('report/report/report', 'tRptPosType1'),
            'tRptPosType2' => language('report/report/report', 'tRptPosType2'),

            'tRptPdtCode' => language('report/report/report', 'tRptPdtCode'),
            'tRptPdtName' => language('report/report/report', 'tRptPdtName'),
            'tRptPdtGrp' => language('report/report/report', 'tRptPdtGrp'),
            'tRptQty' => language('report/report/report', 'tRptQty'),
            'tRptUnit' => language('report/report/report', 'tRptUnit'),
            'tRptAveragePrice' => language('report/report/report', 'tRptAveragePrice'),

            'tRptAdjMerChantFrom' => language('report/report/report', 'tRptAdjMerChantFrom'),
            'tRptAdjMerChantTo' => language('report/report/report', 'tRptAdjMerChantTo'),
            'tRptAdjShopFrom' => language('report/report/report', 'tRptAdjShopFrom'),
            'tRptAdjShopTo' => language('report/report/report', 'tRptAdjShopTo'),
            'tRptAdjPosFrom' => language('report/report/report', 'tRptAdjPosFrom'),
            'tRptAdjPosTo' => language('report/report/report', 'tRptAdjPosTo'),
            'tRptBranch' => language('report/report/report', 'tRptBranch'),
            'tRptTotal' => language('report/report/report', 'tRptTotal'),
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptMerFrom' => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo' => language('report/report/report', 'tRptMerTo'),

            'tRptPosFrom' => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo' => language('report/report/report', 'tRptPosTo'),

            'tRptAdjWahFrom' => language('report/report/report', 'tRptAdjWahFrom'),
            'tRptAdjWahTo' => language('report/report/report', 'tRptAdjWahTo'),
            'tRptAll' => language('report/report/report', 'tRptAll'),
            'tRptAddrTaxNo' => language('report/report/report', 'tRptAddrTaxNo'),
            'tRptCstFrom' => language('report/report/report', 'tRptCstFrom'),
            'tRptCstTo' => language('report/report/report', 'tRptCstTo'),
            'tRptMnyShowOverRowID' => language('report/report/report', 'tRptMnyShowOverRowID'),
            'tRptYear' => language('report/report/report', 'tRptYear'),
            'tRptMonth' => language('report/report/report', 'tRptMonth'),

            // Lang เดือน
            'tRptMonth01' => language('report/report/report', 'tRptMonth01'),
            'tRptMonth02' => language('report/report/report', 'tRptMonth02'),
            'tRptMonth03' => language('report/report/report', 'tRptMonth03'),
            'tRptMonth04' => language('report/report/report', 'tRptMonth04'),
            'tRptMonth05' => language('report/report/report', 'tRptMonth05'),
            'tRptMonth06' => language('report/report/report', 'tRptMonth06'),
            'tRptMonth07' => language('report/report/report', 'tRptMonth07'),
            'tRptMonth08' => language('report/report/report', 'tRptMonth08'),
            'tRptMonth09' => language('report/report/report', 'tRptMonth09'),
            'tRptMonth10' => language('report/report/report', 'tRptMonth10'),
            'tRptMonth11' => language('report/report/report', 'tRptMonth11'),
            'tRptMonth12' => language('report/report/report', 'tRptMonth12'),
            //cr Rrport
            //cr Rrport
            'tRptMnyShowOverMonthlyD1' => language('report/report/report', 'tRptMnyShowOverMonthlyD1'),
            'tRptMnyShowOverMonthlyD2' => language('report/report/report', 'tRptMnyShowOverMonthlyD2'),
            'tRptMnyShowOverMonthlyD3' => language('report/report/report', 'tRptMnyShowOverMonthlyD3'),
            'tRptMnyShowOverMonthlyD4' => language('report/report/report', 'tRptMnyShowOverMonthlyD4'),
            'tRptMnyShowOverMonthlyD5' => language('report/report/report', 'tRptMnyShowOverMonthlyD5'),
            'tRptMnyShowOverMonthlyD6' => language('report/report/report', 'tRptMnyShowOverMonthlyD6'),
            'tRptMnyShowOverMonthlyD7' => language('report/report/report', 'tRptMnyShowOverMonthlyD7'),
            'tRptMnyShowOverMonthlyD8' => language('report/report/report', 'tRptMnyShowOverMonthlyD8'),
            'tRptMnyShowOverMonthlyD9' => language('report/report/report', 'tRptMnyShowOverMonthlyD9'),
            'tRptMnyShowOverMonthlyD10' => language('report/report/report', 'tRptMnyShowOverMonthlyD10'),
            'tRptMnyShowOverMonthlyD11' => language('report/report/report', 'tRptMnyShowOverMonthlyD11'),
            'tRptMnyShowOverMonthlyD12' => language('report/report/report', 'tRptMnyShowOverMonthlyD12'),
            'tRptMnyShowOverMonthlyD13' => language('report/report/report', 'tRptMnyShowOverMonthlyD13'),
            'tRptMnyShowOverMonthlyD14' => language('report/report/report', 'tRptMnyShowOverMonthlyD14'),
            'tRptMnyShowOverMonthlyD15' => language('report/report/report', 'tRptMnyShowOverMonthlyD15'),
            'tRptMnyShowOverMonthlyD16' => language('report/report/report', 'tRptMnyShowOverMonthlyD16'),
            'tRptMnyShowOverMonthlyD17' => language('report/report/report', 'tRptMnyShowOverMonthlyD17'),
            'tRptMnyShowOverMonthlyD18' => language('report/report/report', 'tRptMnyShowOverMonthlyD18'),
            'tRptMnyShowOverMonthlyD19' => language('report/report/report', 'tRptMnyShowOverMonthlyD19'),
            'tRptMnyShowOverMonthlyD20' => language('report/report/report', 'tRptMnyShowOverMonthlyD20'),
            'tRptMnyShowOverMonthlyD21' => language('report/report/report', 'tRptMnyShowOverMonthlyD21'),
            'tRptMnyShowOverMonthlyD22' => language('report/report/report', 'tRptMnyShowOverMonthlyD22'),
            'tRptMnyShowOverMonthlyD23' => language('report/report/report', 'tRptMnyShowOverMonthlyD23'),
            'tRptMnyShowOverMonthlyD24' => language('report/report/report', 'tRptMnyShowOverMonthlyD24'),
            'tRptMnyShowOverMonthlyD25' => language('report/report/report', 'tRptMnyShowOverMonthlyD25'),
            'tRptMnyShowOverMonthlyD26' => language('report/report/report', 'tRptMnyShowOverMonthlyD26'),
            'tRptMnyShowOverMonthlyD27' => language('report/report/report', 'tRptMnyShowOverMonthlyD27'),
            'tRptMnyShowOverMonthlyD28' => language('report/report/report', 'tRptMnyShowOverMonthlyD28'),
            'tRptMnyShowOverMonthlyD29' => language('report/report/report', 'tRptMnyShowOverMonthlyD29'),
            'tRptMnyShowOverMonthlyD30' => language('report/report/report', 'tRptMnyShowOverMonthlyD30'),
            'tRptMnyShowOverMonthlyD31' => language('report/report/report', 'tRptMnyShowOverMonthlyD31'),
            'tRptMnyShowOverMonthlyTitle' => language('report/report/report', 'tRptMnyShowOverMonthlyTitle'),
            'tRptMnyShowOverMonthlyUsrId' => language('report/report/report', 'tRptMnyShowOverMonthlyUsrId'),
            'tRptMnyShowOverMonthlyDate' => language('report/report/report', 'tRptMnyShowOverMonthlyDate'),
            'tRptMnyShowOverMonthlyTotalMO' => language('report/report/report', 'tRptMnyShowOverMonthlyTotalMO'),
            'tRptMnyShowOverMonthlyAmt' => language('report/report/report', 'tRptMnyShowOverMonthlyAmt'),
            'tRptMnyShowOverMonthlyMM' => language('report/report/report', 'tRptMnyShowOverMonthlyMM'),
            'tRptMnyShowOverMonthlyOM' => language('report/report/report', 'tRptMnyShowOverMonthlyOM'),
            'tRptMnyShowOverMonthlySign' => language('report/report/report', 'tRptMnyShowOverMonthlySign'),
            'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),
            'tRptMnyCashIn' => language('report/report/report', 'tRptMnyCashIn'),
            'tRptMnyCashOut' => language('report/report/report', 'tRptMnyCashOut'),
            'tRptTotalFooter' => language('report/report/report', 'tRptTotalFooter'),

            'tRptTaxSaleTaxNo' => language('report/report/report', 'tRptTaxSaleTaxNo'),

        ];

        $this->tSysBchCode = SYS_BCH_CODE;
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
            'tUserSession' => $this->tUserSessionID,
            'tCompName' => $tFullHost,
            'tRptCode' => $this->tRptCode,
            'nLangID' => $this->nLngID,
            'paDataFilter' => $this->aRptFilter,

            'nFilterType' => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",
            // สาขา(Branch)
            'tBchCodeFrom' => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom' => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo' => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo' => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect' => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect' => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll' => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // เครื่องจุดขาย
            'tRptPosCodeFrom' => !empty($this->input->post('oetRptPosCodeFrom')) ? $this->input->post('oetRptPosCodeFrom') : "",
            'tRptPosNameFrom' => !empty($this->input->post('oetRptPosNameFrom')) ? $this->input->post('oetRptPosNameFrom') : "",
            'tRptPosCodeTo' => !empty($this->input->post('oetRptPosCodeTo')) ? $this->input->post('oetRptPosCodeTo') : "",
            'tRptPosNameTo' => !empty($this->input->post('oetRptPosNameTo')) ? $this->input->post('oetRptPosNameTo') : "",
            'tPosCodeSelect' => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect' => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll' => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // แคชเชียร์
            'tCashierCodeFrom' => !empty($this->input->post('oetRptCashierCodeFrom')) ? $this->input->post('oetRptCashierCodeFrom') : "",
            'tCashierNameFrom' => !empty($this->input->post('oetRptCashierNameFrom')) ? $this->input->post('oetRptCashierNameFrom') : "",
            'tCashierCodeTo' => !empty($this->input->post('oetRptCashierCodeTo')) ? $this->input->post('oetRptCashierCodeTo') : "",
            'tCashierNameTo' => !empty($this->input->post('oetRptCashierNameTo')) ? $this->input->post('oetRptCashierNameTo') : "",
            'tCashierCodeSelect' => !empty($this->input->post('oetRptCashierCodeSelect')) ? $this->input->post('oetRptCashierCodeSelect') : "",
            'tCashierNameSelect' => !empty($this->input->post('oetRptCashierNameSelect')) ? $this->input->post('oetRptCashierNameSelect') : "",
            'bCashierStaSelectAll' => !empty($this->input->post('oetRptCashierStaSelectAll')) && ($this->input->post('oetRptCashierStaSelectAll') == 1) ? true : false,

            //เดือน
            'tMonth' => !empty($this->input->post('ocmRptMonth')) ? $this->input->post('ocmRptMonth') : "",
            //ปี
            'tYear' => !empty($this->input->post('oetRptYear')) ? $this->input->post('oetRptYear') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin,
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index()
    {
        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->mRptMnyShotOverMonthly->FSnMExecStoreReport($this->aRptFilter);

            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    $this->FSvCCallRptExportFile();
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 25/2/2020 Nonpawich
     * LastUpdate:
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint()
    {
        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage' => $this->nPerPage,
            'nPage' => '1', // เริ่มทำงานหน้าแรก
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter' => $this->aRptFilter,
        );
        $aDataReport = $this->mRptMnyShotOverMonthly->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $this->aRptFilter,
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptMnyShotOverMonthly', 'wRptMnyShotOverMonthlyHtml', $aDataViewRpt);
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
            ),
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 20/12/2019 Nonpaiwch(petch)
     * LastUpdate:
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage()
    {

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage' => $this->nPerPage,
            'nPage' => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter' => $this->aRptFilter,
        );
        $aDataReport = $this->mRptMnyShotOverMonthly->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $aDataFilter,
        );

        // Load View Advance Tablew
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptMnyShotOverMonthly', 'wRptMnyShotOverMonthlyHtml', $aDataViewRpt);
        // Data Viewer Center Report
        $aDataViewer = array(
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
                'rtDesc' => 'success',
            ),
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp()
    {
        try {
            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUserSession' => $this->tUserSessionID,
                'aDataFilter' => $this->aRptFilter,
            ];
            $nDataCountPage = $this->mRptMnyShotOverMonthly->FSnMCountRowInTemp($aDataCountData);
            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent' => 1,
                'tMessage' => 'Success Count Data All',
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage(),
            );
        }
        echo json_encode($aResponse);
    }

    // /**
    //  * Functionality: Send Rabbit MQ Report
    //  * Parameters:  Function Parameter
    //  * Creator: 16/08/2019 Wasin(Yoshi)
    //  * LastUpdate: 23/069/2019 Piya
    //  * Return: object Send Rabbit MQ Report
    //  * ReturnType: Object
    //  */
    // public function FSvCCallRptExportFile() {
    //     $dDateSendMQ    = date('Y-m-d');
    //     $dTimeSendMQ    = date('H:i:s');
    //     $dDateSubscribe = date('Ymd');
    //     $dTimeSubscribe = date('His');
    //     // Set Parameter Send MQ
    //     $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

    //     $aDataSendMQ    = [
    //         'tQueueName' => $tRptQueueName,
    //         'aParams' => [
    //             'ptRptCode'         => $this->tRptCode,
    //             'pnPerFile'         => 20000,
    //             'ptUserCode'        => $this->tUserLoginCode,
    //             'ptUserSessionID'   => $this->tUserSessionID,
    //             'pnLngID'           => $this->nLngID,
    //             'ptFilter'          => $this->aRptFilter,
    //             'ptRptExpType'      => $this->tRptExportType,
    //             'ptComName'         => $this->tCompName,
    //             'ptDate'            => $dDateSendMQ,
    //             'ptTime'            => $dTimeSendMQ,
    //             'ptBchCode'         => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
    //         ]
    //     ];
    //     FCNxReportCallRabbitMQ($aDataSendMQ);
    //     $aResponse  = array(
    //         'nStaEvent' => 1,
    //         'tMessage'  => 'Success Send Rabbit MQ.',
    //         'aDataSubscribe'    => array(
    //             'ptSysBchCode'      => $this->tSysBchCode,
    //             'ptComName'         => $this->tCompName,
    //             'ptRptCode'         => $this->tRptCode,
    //             'ptUserCode'        => $this->tUserLoginCode,
    //             'ptUserSessionID'   => $this->tUserSessionID,
    //             'pdDateSubscribe'   => $dDateSubscribe,
    //             'pdTimeSubscribe'   => $dTimeSubscribe,
    //         )
    //     );
    //     echo json_encode($aResponse);
    // }

    /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 29/09/2020 Sooksanti
     * LastUpdate:
     * Return: file
     * ReturnType: file
     */
    public function FSvCCallRptExportFile()
    {
        $tFileName = $this->aText['tTitleReport'] . '_' . date('YmdHis') . '.xlsx';

        $oWriter = WriterEntityFactory::createXLSXWriter();

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

        $oBorderleft = (new BorderBuilder())
            ->setBorderLeft(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
            ->build();

        $oStyleColumsLeft = (new StyleBuilder())
            ->setBorder($oBorderleft)
            ->build();

        $oBorderright = (new BorderBuilder())
            ->setBorderRight(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
            ->build();

        $oStyleColumsRight = (new StyleBuilder())
            ->setBorder($oBorderright)
            ->setFontBold()
            ->build();

        $oStyleColums = (new StyleBuilder())
            ->setBorder($oBorder)
            ->build();

        $oStyleBold = (new StyleBuilder())
            ->setBorder($oBorder)
            ->setFontBold()
            ->build();
        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverRowID')),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyUsrId')),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(null, $oStyleColumsLeft),
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
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyDate')),
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
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyTotalMO2')),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyAmt')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlySign2')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aCells = [
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD1'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD2'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD3'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD4'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD5'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD6'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD7'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD8'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD9'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD10'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD11'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD12'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD13'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD14'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD15'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD16'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD17'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD18'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD19'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD20'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD21'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD22'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD23'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD24'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD25'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD26'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD27'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD28'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD29'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD30'), $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyD31'), $oStyleColumsRight),

            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyMM')),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyShowOverMonthlyOM')),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyCashIn')),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptMnyCashOut')),
            WriterEntityFactory::createCell(null, $oStyleColumsRight),

            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataReportParams = array(
            'nPerPage' => 999999999999,
            'nPage' => 1,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter' => $this->aRptFilter,
        );
        $aDataReport = $this->mRptMnyShotOverMonthly->FSaMGetDataReport($aDataReportParams);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                $values = [

                    WriterEntityFactory::createCell($aValue['RowID']),
                    WriterEntityFactory::createCell($aValue['FTUsrCode']),
                    WriterEntityFactory::createCell(null),

                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD1"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD2"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD3"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD4"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD5"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD6"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD7"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD8"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD9"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD10"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD11"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD12"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD13"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD14"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD15"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD16"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD17"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD18"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD19"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD20"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD21"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD22"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD23"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD24"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD25"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD26"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD27"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD28"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD29"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD30"])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD31"])),

                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCShotOver"])),
                    WriterEntityFactory::createCell(null),

                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCMnyShot"] * (-01))),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCMnyOver"])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCSvnCashIn"])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCSvnCashOut"])),
                    WriterEntityFactory::createCell(null),

                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                ];
                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);

                if (($nKey + 1) == FCNnHSizeOf($aDataReport['aRptData'])) { //SumFooter
                    $values = [

                        WriterEntityFactory::createCell($this->aText['tRptTotalFooter'], $oStyleBold),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),

                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD1_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD2_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD3_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD4_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD5_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD6_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD7_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD8_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD9_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD10_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD11_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD12_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD13_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD14_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD15_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD16_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD17_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD18_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD19_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD20_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD21_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD22_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD23_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD24_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD25_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD26_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD27_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD28_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD29_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD30_Footer"])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FTDayD31_Footer"])),

                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCShotOver_Footer"])),
                        WriterEntityFactory::createCell(null),

                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCMnyShot_Footer"] * (-01))),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCMnyOver_Footer"])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCSvnCashIn_Footer"])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCSvnCashOut_Footer"])),
                        WriterEntityFactory::createCell(null),

                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                    ];
                    $aRow = WriterEntityFactory::createRow($values, $oStyleBold);
                    $oWriter->addRow($aRow);
                }
            }
        }

        $aMulltiRow = $this->FSoCCallRptRenderFooterExcel(); //เรียกฟังชั่นสร้างส่วนท้ายรายงาน
        $oWriter->addRows($aMulltiRow);

        $oWriter->close();
    }

    /**
     * Functionality: Render Excel Report Header
     * Parameters:  Function Parameter
     * Creator: 29/09/2020 Sooksanti
     * LastUpdate:
     * Return: oject
     * ReturnType: oject
     */
    public function FSoCCallRptRenderHedaerExcel()
    {
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
            WriterEntityFactory::createCell($this->aText['tRptAddrBranch'] . ' ' . $tFTBchName),
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

        // Fillter DocDate (วันที่สร้างเอกสาร)
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
                WriterEntityFactory::createCell($this->aText['tRptDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }

        // Fillter ฺBranch (สาขา)
        if (!empty($this->aRptFilter['tBchCodeFrom']) && !empty($this->aRptFilter['tBchCodeTo'])) {
            $tRptFilterBranchCodeFrom = $this->aText['tRptBchFrom'] . ' ' . $this->aRptFilter['tBchNameFrom'];
            $tRptFilterBranchCodeTo = $this->aText['tRptBchTo'] . ' ' . $this->aRptFilter['tBchNameTo'];
            $tRptTextLeftRightFilter = $tRptFilterBranchCodeFrom . '     ' . $tRptFilterBranchCodeTo;

            $aCells = [
                WriterEntityFactory::createCell($tRptTextLeftRightFilter),
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
            WriterEntityFactory::createCell($this->aText['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $this->aText['tTimePrint'] . ' ' . date('H:i:s')),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        return $aMulltiRow;

    }

/**
 * Functionality: Render Excel Report Footer
 * Parameters:  Function Parameter
 * Creator: 29/09/2020 Sooksanti
 * LastUpdate:
 * Return: oject
 * ReturnType: oject
 */
    public function FSoCCallRptRenderFooterExcel()
    {

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

        // Fillter DocDate (วันที่สร้างเอกสาร)
        if (!empty($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateTo'])) {
            $tRptFilterFrom = $this->aText['tRptDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom']));
            $tRptFilterTo = $this->aText['tRptDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']));
            $tRptTextLeftRightFilter = $tRptFilterFrom . ' ' . $tRptFilterTo;
            $aCells = [
                WriterEntityFactory::createCell($tRptTextLeftRightFilter),
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

        // ปี เดือน
        if ((!empty($this->aRptFilter['tYear']) && !empty($this->aRptFilter['tYear'])) && (!empty($this->aRptFilter['tMonth']) && !empty($this->aRptFilter['tMonth']))) {
            $tRptFilterFrom = $this->aText['tRptYear'] . ' ' . $this->aRptFilter['tYear'];
            $tRptFilterTo = $this->aText['tRptMonth'] . ' ' . language('report/report/report', 'tRptMonth' . $this->aRptFilter['tMonth']);
            $tRptTextLeftRightFilter = $tRptFilterFrom . '     ' . $tRptFilterTo;
            $aCells = [
                WriterEntityFactory::createCell($tRptTextLeftRightFilter),
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

        // Fillter Date
        if (!empty($this->aRptFilter['tDocDateFrom'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptDateFrom'] . ' : ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom']))),
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

        // ลูกค้า แบบช่วง
        if (!empty($this->aRptFilter['tCstCodeFrom']) && !empty($this->aRptFilter['tCstCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptCstFrom'] . ' : ' . $this->aRptFilter['tCstNameFrom'] . '     ' . $this->aText['tRptCstTo'] . ' : ' . $this->aRptFilter['tCstNameTo']),
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

        // Fillter Shop (ร้านค้า)  แบบช่วง
        if (!empty($this->aRptFilter['tShpCodeFrom']) && !empty($this->aRptFilter['tShpCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptShopFrom'] . ' : ' . $this->aRptFilter['tShpNameFrom'] . '     ' . $this->aText['tRptShopTo'] . ' : ' . $this->aRptFilter['tShpNameTo']),
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

        // Fillterฺ Mar (กลุ่มธุรกิจ) แบบช่วง
        if (!empty($this->aRptFilter['tMerCodeFrom']) && !empty($this->aRptFilter['tMerCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptMerFrom'] . ' : ' . $this->aRptFilter['tMerNameFrom'] . '     ' . $this->aText['tRptMerTo'] . ' : ' . $this->aRptFilter['tMerNameTo']),
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

        // Fillterฺ Pos (เครื่องจุดขาย)) แบบช่วง
        if (!empty($this->aRptFilter['tPosCodeFrom']) && !empty($this->aRptFilter['tPosCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptPosFrom'] . ' : ' . $this->aRptFilter['tPosNameFrom'] . '     ' . $this->aText['tRptPosTo'] . ' : ' . $this->aRptFilter['tPosNameTo']),
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
