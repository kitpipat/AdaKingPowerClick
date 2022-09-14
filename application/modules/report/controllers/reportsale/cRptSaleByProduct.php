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

class cRptSaleByProduct extends MX_Controller
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
        $this->load->model('report/reportsale/mRptSaleByProduct');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init()
    {
        $this->aText = [

            // TitleReport
            'tTitleReport' => language('report/report/report', 'tRptTitsale'),
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
            'tRptFaxNo' => language('report/report/report', 'tRptAddrFax'),
            'tRptTel' => language('report/report/report', 'tRptAddrTel'),
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
            'tRptShopFrom' => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo' => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom' => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo' => language('report/report/report', 'tRptPosTo'),
            'tPdtCodeTo' => language('report/report/report', 'tPdtCodeTo'),
            'tPdtCodeFrom' => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtGrpFrom' => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo' => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom' => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo' => language('report/report/report', 'tPdtTypeTo'),
            'tRptAdjWahFrom' => language('report/report/report', 'tRptAdjWahFrom'),
            'tRptAdjWahTo' => language('report/report/report', 'tRptAdjWahTo'),
            'tRptAll' => language('report/report/report', 'tRptAll'),

            'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),
            'tRptDatePrint' => language('report/report/report', 'tRptDatePrint'),
            'tRptTimePrint' => language('report/report/report', 'tRptTimePrint'),
            'tRptTotalAllSale' => language('report/report/report', 'tRptTotalAllSale'),
            'tRptTaxPointByCstDocDateFrom' => language('report/report/report', 'tRptTaxPointByCstDocDateFrom'),
            'tRptTaxPointByCstDocDateTo' => language('report/report/report', 'tRptTaxPointByCstDocDateTo'),
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

            'tTypeSelect' => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // สาขา(Branch)
            'tBchCodeFrom' => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom' => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo' => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo' => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect' => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect' => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll' => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom' => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom' => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo' => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo' => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect' => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect' => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll' => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeFrom' => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
            'tMerNameFrom' => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
            'tMerCodeTo' => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
            'tMerNameTo' => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
            'tMerCodeSelect' => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect' => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll' => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeFrom' => (empty($this->input->post('oetRptPosCodeFrom'))) ? '' : $this->input->post('oetRptPosCodeFrom'),
            'tPosNameFrom' => (empty($this->input->post('oetRptPosNameFrom'))) ? '' : $this->input->post('oetRptPosNameFrom'),
            'tPosCodeTo' => (empty($this->input->post('oetRptPosCodeTo'))) ? '' : $this->input->post('oetRptPosCodeTo'),
            'tPosNameTo' => (empty($this->input->post('oetRptPosNameTo'))) ? '' : $this->input->post('oetRptPosNameTo'),
            'tPosCodeSelect' => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect' => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll' => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // สินค้า
            'tPdtCodeFrom' => !empty($this->input->post('oetRptPdtCodeFrom')) ? $this->input->post('oetRptPdtCodeFrom') : "",
            'tPdtNameFrom' => !empty($this->input->post('oetRptPdtNameFrom')) ? $this->input->post('oetRptPdtNameFrom') : "",
            'tPdtCodeTo' => !empty($this->input->post('oetRptPdtCodeTo')) ? $this->input->post('oetRptPdtCodeTo') : "",
            'tPdtNameTo' => !empty($this->input->post('oetRptPdtNameTo')) ? $this->input->post('oetRptPdtNameTo') : "",

            // กลุ่มสินค้า
            'tPdtGrpCodeFrom' => !empty($this->input->post('oetRptPdtGrpCodeFrom')) ? $this->input->post('oetRptPdtGrpCodeFrom') : "",
            'tPdtGrpNameFrom' => !empty($this->input->post('oetRptPdtGrpNameFrom')) ? $this->input->post('oetRptPdtGrpNameFrom') : "",
            'tPdtGrpCodeTo' => !empty($this->input->post('oetRptPdtGrpCodeTo')) ? $this->input->post('oetRptPdtGrpCodeTo') : "",
            'tPdtGrpNameTo' => !empty($this->input->post('oetRptPdtGrpNameTo')) ? $this->input->post('oetRptPdtGrpNameTo') : "",

            // ประเภทสินค้า
            'tPdtTypeCodeFrom' => !empty($this->input->post('oetRptPdtTypeCodeFrom')) ? $this->input->post('oetRptPdtTypeCodeFrom') : "",
            'tPdtTypeNameFrom' => !empty($this->input->post('oetRptPdtTypeNameFrom')) ? $this->input->post('oetRptPdtTypeNameFrom') : "",
            'tPdtTypeCodeTo' => !empty($this->input->post('oetRptPdtTypeCodeTo')) ? $this->input->post('oetRptPdtTypeCodeTo') : "",
            'tPdtTypeNameTo' => !empty($this->input->post('oetRptPdtTypeNameTo')) ? $this->input->post('oetRptPdtTypeNameTo') : "",

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom' => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo' => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",

            //ประเภทเครื่องจุดขาย
            'tPosType' => !empty($this->input->post('ocmPosType')) ? $this->input->post('ocmPosType') : "",
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
            $this->mRptSaleByProduct->FSnMExecStoreReport($this->aRptFilter);
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    $this->FSvCCallRptRenderExcel();
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/07/2019 Saharat(Golf)
     * LastUpdate: 23/09/2019 Piya
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
        $aDataReport = $this->mRptSaleByProduct->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $this->aRptFilter,
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rptsalebyproduct', 'wRptSaleByProductHtml', $aDataViewRpt);
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
     * Creator: 19/07/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
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
        $aDataReport = $this->mRptSaleByProduct->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $aDataFilter,
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rptsalebyproduct', 'wRptSaleByProductHtml', $aDataViewRpt);
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

    // Functionality: Function Render Report Excel
    // Parameters:  Function Parameter
    // Creator: 07/08/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: Export Report Excel
    // ReturnType: View
    // public function FSvCCallRptRenderExcel($paDataSwitchCase)
    // {
    //     try {
    //         // เตรียมข้อมูลออกรายงาน =================================================================================================================================================
    //         $tRptRoute = $paDataSwitchCase['ptRptRoute'];
    //         $tRptCode = $paDataSwitchCase['ptRptCode'];
    //         $tRptTypeExport = $paDataSwitchCase['ptRptTypeExport'];
    //         $aDataFilter = $paDataSwitchCase['paDataFilter'];
    //         $nPage = 1;
    //         $nLangEdit = $this->session->userdata("tLangEdit");
    //         $tSesUsername = $this->session->userdata('tSesUsername');
    //         $tUsrSessionID = $this->session->userdata('tSesSessionID');
    //         $dDatePrint = date('Y-m-d');
    //         $dTimePrint = date('H:i:s');

    //         // Get Data Address Reprot By Branch Company
    //         $tAPIReq = "";
    //         $tMethodReq = "GET";
    //         $aDataWhereComp = array('FNLngID' => $nLangEdit);
    //         $aCompData = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);
    //         if ($aCompData['rtCode'] == '1') {
    //             $tCompName = $aCompData['raItems']['rtCmpName'];
    //             $tBchCode = $aCompData['raItems']['rtCmpBchCode'];
    //             $aDataAddress = $this->mReport->FSaMRptGetDataAddressByBranchComp($tBchCode, $nLangEdit);
    //         } else {
    //             $tCompName = "-";
    //             $tBchCode = "-";
    //             $aDataAddress = array();
    //         }

    //         // array ข้อมูลภาษาที่เกี่ยวข้องกับรายงาน
    //         $aDataTextRef = array(
    //             'tTitleReport' => language('report/report/report', 'tRptTitleSaleRecive'),
    //             'tDatePrint' => language('report/report/report', 'tRptAdjStkVDDatePrint'),
    //             'tTimePrint' => language('report/report/report', 'tRptAdjStkVDTimePrint'),
    //             // Filter Data Report
    //             'tRptFilterBchFrom' => language('report/report/report', 'tRptBchFrom'),
    //             'tRptFilterBchTo' => language('report/report/report', 'tRptBchTo'),
    //             'tRptFilterShopFrom' => language('report/report/report', 'tRptShopFrom'),
    //             'tRptFilterShopTo' => language('report/report/report', 'tRptShopTo'),
    //             'tRptFilterPdtFrom' => language('report/report/report', 'tPdtCodeFrom'),
    //             'tRptFilterPdtTo' => language('report/report/report', 'tPdtCodeTo'),
    //             'tRptFilterPdtGrpFrom' => language('report/report/report', 'tPdtGrpFrom'),
    //             'tRptFilterPdtGrpTo' => language('report/report/report', 'tPdtGrpTo'),
    //             'tRptFilterPdtTypeFrom' => language('report/report/report', 'tPdtTypeFrom'),
    //             'tRptFilterPdtTypeTo' => language('report/report/report', 'tPdtTypeTo'),
    //             'tRptFilterDateFrom' => language('report/report/report', 'tRptDateFrom'),
    //             'tRptFilterDateTo' => language('report/report/report', 'tRptDateTo'),
    //             // Address Language
    //             'tRptAddrBuilding' => language('report/report/report', 'tRptAddrBuilding'),
    //             'tRptAddrRoad' => language('report/report/report', 'tRptAddrRoad'),
    //             'tRptAddrSoi' => language('report/report/report', 'tRptAddrSoi'),
    //             'tRptAddrSubDistrict' => language('report/report/report', 'tRptAddrSubDistrict'),
    //             'tRptAddrDistrict' => language('report/report/report', 'tRptAddrDistrict'),
    //             'tRptAddrProvince' => language('report/report/report', 'tRptAddrProvince'),
    //             'tRptAddrTel' => language('report/report/report', 'tRptAddrTel'),
    //             'tRptAddrFax' => language('report/report/report', 'tRptAddrFax'),
    //             'tRptAddrBranch' => language('report/report/report', 'tRptAddrBranch'),
    //             'tRptAddV2Desc1' => language('report/report/report', 'tRptAddV2Desc1'),
    //             'tRptAddV2Desc2' => language('report/report/report', 'tRptAddV2Desc2'),
    //             // Table Label
    //             'tRptBillNo' => language('report/report/report', 'tRptBillNo'),
    //             'tRptDate' => language('report/report/report', 'tRptDate'),
    //             'tRptProduct' => language('report/report/report', 'tRptProduct'),
    //             'tRptCabinetnumber' => language('report/report/report', 'tRptCabinetnumber'),
    //             'tRptPrice' => language('report/report/report', 'tRptPrice'),
    //             'tRptSales' => language('report/report/report', 'tSales'),
    //             'tRptDiscount' => language('report/report/report', 'tDiscount'),
    //             'tRptTax' => language('report/report/report', 'tRptTax'),
    //             'tRptGrand' => language('report/report/report', 'tRptGrand'),
    //             'tRptTotalSub' => language('report/report/report', 'tRptTotalSub'),
    //             'tRptTotalFooter' => language('report/report/report', 'tRptTotalFooter'),
    //             // No Data Report
    //             'tRptNoData' => language('common/main/main', 'tCMNNotFoundData'),
    //         );

    //         // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
    //         $aDataWhereRpt = array(
    //             'nPerPage' => 500000,
    //             'nPage' => $nPage,
    //             'tCompName' => $this->tCompName,
    //             'tRptCode' => $tRptCode,
    //             'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
    //             'aDataFilter' => $this->aRptFilter,
    //         );
    //         $aDataReport = $this->mRptSaleByProduct->FSaMGetDataReport($aDataWhereRpt);

    //         // ====================================================================================================================================================================
    //         // ตั้งค่ารายงาน =========================================================================================================================================================
    //         // ตั้งค่า Font Style
    //         $aReportFontStyle = array('font' => array('name' => 'TH Sarabun New'));
    //         $aStyleRptSizeTitleName = array('font' => array('size' => 14));
    //         $aStyleRptSizeCompName = array('font' => array('size' => 12));
    //         $aStyleRptSizeAddressFont = array('font' => array('size' => 12));
    //         $aStyleRptHeadderTable = array('font' => array('size' => 12, 'color' => array('rgb' => '000000')));
    //         $aStyleRptDataTable = array('font' => array('size' => 10, 'color' => array('rgb' => '000000')));

    //         // Initiate PHPExcel cache
    //         $oCacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
    //         $aCacheSettings = array(' memoryCacheSize ' => '8000MB', 'cacheTime' => 3600 * 120);
    //         PHPExcel_Settings::setCacheStorageMethod($oCacheMethod, $aCacheSettings);

    //         // เริ่ม phpExcel
    //         $objPHPExcel = new PHPExcel();

    //         // A4 ตั้งค่าหน้ากระดาษ
    //         $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    //         // Set Font Style Text All In Report
    //         $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($aReportFontStyle);

    //         // จัดความกว้างของคอลัมน์
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(100);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(25);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(25);

    //         // ชื่อหัวรายงาน
    //         $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $aDataTextRef['tTitleReport']);
    //         $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //         $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptSizeTitleName);

    //         // ====================================================================================================================================================================
    //         // เช็คที่อยู่รายงาน =======================================================================================================================================================
    //         if (isset($aDataAddress) && !empty($aDataAddress)) {
    //             // Company Name
    //             $tRptCompName = (empty($aDataAddress['FTCompName'])) ? '-' : $aDataAddress['FTCompName'];
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $tRptCompName)->getStyle('A2')->applyFromArray($aStyleRptSizeCompName);

    //             // Check Vertion Address
    //             if ($aDataAddress['FTAddVersion'] == 1) {
    //                 // Check Address Line 1
    //                 $tRptAddV1No = (empty($aDataAddress['FTAddV1No'])) ? '-' : $aDataAddress['FTAddV1No'];
    //                 $tRptAddV1Road = (empty($aDataAddress['FTAddV1Road'])) ? '-' : $aDataAddress['FTAddV1Road'];
    //                 $tRptAddV1Soi = (empty($aDataAddress['FTAddV1Soi'])) ? '-' : $aDataAddress['FTAddV1Soi'];
    //                 $tRptAddressLine1 = $tRptAddV1No . ' ' . $aDataTextRef['tRptAddrRoad'] . ' ' . $tRptAddV1Road . ' ' . $aDataTextRef['tRptAddrSoi'] . ' ' . $tRptAddV1Soi;
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddressLine1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

    //                 // Check Address Line 2
    //                 $tRptAddV1SubDistName = (empty($aDataAddress['FTSudName'])) ? '-' : $aDataAddress['FTSudName'];
    //                 $tRptAddV1DstName = (empty($aDataAddress['FTDstName'])) ? '-' : $aDataAddress['FTDstName'];
    //                 $tRptAddV1PvnName = (empty($aDataAddress['FTPvnName'])) ? '-' : $aDataAddress['FTPvnName'];
    //                 $tRptAddV1PostCode = (empty($aDataAddress['FTAddV1PostCode'])) ? '-' : $aDataAddress['FTAddV1PostCode'];
    //                 $tRptAddressLine2 = $tRptAddV1SubDistName . ' ' . $tRptAddV1DstName . ' ' . $tRptAddV1PvnName . ' ' . $tRptAddV1PostCode;
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddressLine2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
    //             } else {
    //                 $tRptAddV2Desc1 = (empty($aDataAddress['FTAddV2Desc1'])) ? '-' : $aDataAddress['FTAddV2Desc1'];
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddV2Desc1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

    //                 $tRptAddV2Desc2 = (empty($aDataAddress['FTAddV2Desc2'])) ? '-' : $aDataAddress['FTAddV2Desc2'];
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddV2Desc2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
    //             }

    //             // Check Data Telephone Number
    //             if (isset($aDataAddress['FTCompTel']) && !empty($aDataAddress['FTCompTel'])) {
    //                 $tRptCompTel = $aDataAddress['FTCompTel'];
    //             } else {
    //                 $tRptCompTel = '-';
    //             }
    //             $tRptCompTelText = $aDataTextRef['tRptAddrTel'] . ' ' . $tRptCompTel;
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tRptCompTelText)->getStyle('A5')->applyFromArray($aStyleRptSizeAddressFont);

    //             // Check Data Fax Number
    //             if (isset($aDataAddress['FTCompFax']) && !empty($aDataAddress['FTCompFax'])) {
    //                 $tRptCompFax = $aDataAddress['FTCompFax'];
    //             } else {
    //                 $tRptCompFax = '-';
    //             }
    //             $tRptCompFaxText = $aDataTextRef['tRptAddrFax'] . ' ' . $tRptCompFax;
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tRptCompFaxText)->getStyle('A6')->applyFromArray($aStyleRptSizeAddressFont);
    //         }
    //         // ====================================================================================================================================================================
    //         // ฟิวเตอร์ข้อมูลรายงาน ===================================================================================================================================================
    //         // Row เริ่มต้นของ Filter
    //         $nStartRowHeadder = 8;
    //         $nStartRowFillter = 2;
    //         $tFillterColumLEFT = "B";
    //         $tFillterColumRIGHT = "F";

    //         // Fillter Branch (สาขา)
    //         if (!empty($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeTo'])) {
    //             $tRptFilterBchCodeFrom = $aDataTextRef['tRptFilterBchFrom'] . ' ' . $aDataFilter['tBchNameFrom'];
    //             $tRptFilterBchCodeTo = $aDataTextRef['tRptFilterBchTo'] . ' ' . $aDataFilter['tBchNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterBchCodeFrom . ' ' . $tRptFilterBchCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);

    //             $nStartRowFillter += 1;
    //             if ($nStartRowFillter > 7) {
    //                 $nStartRowHeadder += 1;
    //             }
    //         }

    //         // Fillter Shop (ร้านค้า)
    //         if (!empty($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeTo'])) {
    //             $tRptFilterShpCodeFrom = $aDataTextRef['tRptFilterShopFrom'] . ' ' . $aDataFilter['tShpNameFrom'];
    //             $tRptFilterShpCodeTo = $aDataTextRef['tRptFilterShopTo'] . ' ' . $aDataFilter['tShpNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterShpCodeFrom . ' ' . $tRptFilterShpCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);

    //             $nStartRowFillter += 1;
    //             if ($nStartRowFillter > 7) {
    //                 $nStartRowHeadder += 1;
    //             }
    //         }

    //         // Fillter Prodict (สินค้า)
    //         if (!empty($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeTo'])) {
    //             $tRptFilterPdtCodeFrom = $aDataTextRef['tRptFilterPdtFrom'] . ' ' . $aDataFilter['tPdtNameFrom'];
    //             $tRptFilterPdtCodeTo = $aDataTextRef['tRptFilterPdtTo'] . ' ' . $aDataFilter['tPdtNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterPdtCodeFrom . ' ' . $tRptFilterPdtCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);

    //             $nStartRowFillter += 1;
    //             if ($nStartRowFillter > 7) {
    //                 $nStartRowHeadder += 1;
    //             }
    //         }

    //         // Fillter Product Group (กลุ่มสินค้า)
    //         if (!empty($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeTo'])) {
    //             $tRptFilterPdtGrpFrom = $aDataTextRef['tRptFilterPdtGrpFrom'] . ' ' . $aDataFilter['tPdtGrpNameFrom'];
    //             $tRptFilterPdtGrpTo = $aDataTextRef['tRptFilterPdtGrpTo'] . ' ' . $aDataFilter['tPdtGrpNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterPdtGrpFrom . ' ' . $tRptFilterPdtGrpTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);

    //             $nStartRowFillter += 1;
    //             if ($nStartRowFillter > 7) {
    //                 $nStartRowHeadder += 1;
    //             }
    //         }

    //         // Fillter Product Type (ประเภทสินค้า)
    //         if (!empty($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeTo'])) {
    //             $tRptFilterPdtTypeFrom = $aDataTextRef['tRptFilterPdtTypeFrom'] . ' ' . $aDataFilter['tPdtTypeNameFrom'];
    //             $tRptFilterPdtTypeTo = $aDataTextRef['tRptFilterPdtTypeTo'] . ' ' . $aDataFilter['tPdtTypeNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterPdtTypeFrom . ' ' . $tRptFilterPdtTypeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);

    //             $nStartRowFillter += 1;
    //             if ($nStartRowFillter > 7) {
    //                 $nStartRowHeadder += 1;
    //             }
    //         }

    //         // Fillter Document Date (วันที่)
    //         if (!empty($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateTo'])) {
    //             $tRptFilterDocDateFrom = $aDataTextRef['tRptFilterDateFrom'] . ' ' . $aDataFilter['tDocDateFrom'];
    //             $tRptFilterDocDateTo = $aDataTextRef['tRptFilterDateTo'] . ' ' . $aDataFilter['tDocDateTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterDocDateFrom . ' ' . $tRptFilterDocDateTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);

    //             $nStartRowFillter += 1;
    //             if ($nStartRowFillter > 7) {
    //                 $nStartRowHeadder += 1;
    //             }
    //         }

    //         // ====================================================================================================================================================================
    //         // ตั้งค่าวันที่เวลาออกรายงาน ===============================================================================================================================================
    //         $nRowNumberDatePrint = $nStartRowHeadder - 1;
    //         $tRptDateTimeExportText = $aDataTextRef['tDatePrint'] . ' ' . $dDatePrint . ' ' . $aDataTextRef['tTimePrint'] . ' ' . $dTimePrint;

    //         $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nRowNumberDatePrint . ':I' . $nRowNumberDatePrint);
    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nRowNumberDatePrint, $tRptDateTimeExportText);
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nRowNumberDatePrint . ':I' . $nRowNumberDatePrint)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nRowNumberDatePrint . ':I' . $nRowNumberDatePrint)->applyFromArray($aStyleRptSizeAddressFont);
    //         // ====================================================================================================================================================================
    //         // หัวตารางรายงาน =======================================================================================================================================================
    //         // กำหนด Style Font ของหัวตาราง
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->applyFromArray(array(
    //             'borders' => array(
    //                 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //             ),
    //         ));

    //         // กำหนดข้อมูลลงหัวตาราง
    //         $objPHPExcel->setActiveSheetIndex(0)
    //             ->setCellValue('A' . $nStartRowHeadder, $aDataTextRef['tRptBillNo'])
    //             ->setCellValue('B' . $nStartRowHeadder, $aDataTextRef['tRptDate'])
    //             ->setCellValue('C' . $nStartRowHeadder, $aDataTextRef['tRptProduct'])
    //             ->setCellValue('D' . $nStartRowHeadder, $aDataTextRef['tRptCabinetnumber'])
    //             ->setCellValue('E' . $nStartRowHeadder, $aDataTextRef['tRptPrice'])
    //             ->setCellValue('F' . $nStartRowHeadder, $aDataTextRef['tRptSales'])
    //             ->setCellValue('G' . $nStartRowHeadder, $aDataTextRef['tRptDiscount'])
    //             ->setCellValue('H' . $nStartRowHeadder, $aDataTextRef['tRptTax'])
    //             ->setCellValue('I' . $nStartRowHeadder, $aDataTextRef['tRptGrand']);

    //         // Alignment ของหัวตาราง
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //         // ====================================================================================================================================================================
    //         // วนลูปข้อมูลตารางข้อมูล =================================================================================================================================================
    //         // Set Variable Data
    //         $nStartRowData = $nStartRowHeadder + 1;

    //         if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
    //             // ******* Step 1 ประกาศตัวแปรใช้ในการเช็คเงื่อนไข
    //             $tGrouppingData = "";
    //             $nGroupMember = "";
    //             $nRowPartID = "";

    //             $nSumFootXsdQty = 0;
    //             $cSumFootXsdAmtB4DisChg = 0;
    //             $cSumFootXsdDis = 0;
    //             $cSumFootXsdVat = 0;
    //             $cSumFootXsdNetAfHD = 0;
    //             foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
    //                 // ******* Step 3 Set ค่า Value FNRptGroupMember And FNRowPartID
    //                 $nRowPartID = $aValue["FNRowPartID"];
    //                 $nGroupMember = $aValue["FNRptGroupMember"];

    //                 // ******* Step 4 : Check Groupping Create Row Groupping
    //                 if ($tGrouppingData != $aValue['FTXshDocNo']) {
    //                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aValue['FTXshDocNo']);
    //                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $nStartRowData, $aValue['FDCreateOn']);
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':C' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
    //                     $nStartRowData++;
    //                 }

    //                 // ******* Step 5 : Loop Set Data Value
    //                 $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':B' . $nStartRowData);
    //                 $objPHPExcel->getActiveSheet()->getStyle('E' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    //                 $objPHPExcel->setActiveSheetIndex(0)
    //                     ->setCellValue('C' . $nStartRowData, $aValue['FTXsdPdtName'])
    //                     ->setCellValue('D' . $nStartRowData, number_format($aValue['FCXsdQty'], 0))
    //                     ->setCellValue('E' . $nStartRowData, number_format($aValue['FCXsdSetPrice'], 2))
    //                     ->setCellValue('F' . $nStartRowData, number_format($aValue['FCXsdAmtB4DisChg'], 2))
    //                     ->setCellValue('G' . $nStartRowData, number_format($aValue['FCXsdDis'], 2))
    //                     ->setCellValue('H' . $nStartRowData, number_format($aValue['FCXsdVat'], 2))
    //                     ->setCellValue('I' . $nStartRowData, number_format($aValue['FCXsdNetAfHD'], 2));
    //                 $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    //                 // ******* Step 6 : เตรียม Parameter สำหรับ Summary Sub Footer
    //                 if ($nRowPartID == $nGroupMember) {
    //                     $nStartRowData++;
    //                     $nSubSumXsdQty = $aValue["FCXsdQty_SubTotal"];
    //                     $cSubSumXsdAmtB4DisChg = $aValue["FCXsdAmtB4DisChg_SubTotal"];
    //                     $cSubSumXsdDis = $aValue["FCXsdDis_SubTotal"];
    //                     $cSubSumXsdVat = $aValue["FCXsdVat_SubTotal"];
    //                     $cSubSumXsdNetAfHD = $aValue["FCXsdNetAfHD_SubTotal"];

    //                     // Set Color Row Sub Footer
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->applyFromArray(array(
    //                         'borders' => array(
    //                             'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                         ),
    //                     ));

    //                     // Text Sum Sub
    //                     $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':C' . $nStartRowData);
    //                     $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptTotalSub']);
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

    //                     $objPHPExcel->getActiveSheet()->getStyle('F' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    //                     // Value Sum Sub
    //                     $objPHPExcel->setActiveSheetIndex(0)
    //                         ->setCellValue('D' . $nStartRowData, number_format($nSubSumXsdQty, 0))
    //                         ->setCellValue('F' . $nStartRowData, number_format($cSubSumXsdAmtB4DisChg, 2))
    //                         ->setCellValue('G' . $nStartRowData, number_format($cSubSumXsdDis, 2))
    //                         ->setCellValue('H' . $nStartRowData, number_format($cSubSumXsdVat, 2))
    //                         ->setCellValue('I' . $nStartRowData, number_format($cSubSumXsdNetAfHD, 2));
    //                     $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    //                 }

    //                 $nSumFootXsdQty = number_format($aValue["FCXsdQty_Footer"], 0);
    //                 $cSumFootXsdAmtB4DisChg = number_format($aValue["FCXsdAmtB4DisChg_Footer"], 2);
    //                 $cSumFootXsdDis = number_format($aValue["FCXsdDis_Footer"], 2);
    //                 $cSumFootXsdVat = number_format($aValue["FCXsdVat_Footer"], 2);
    //                 $cSumFootXsdNetAfHD = number_format($aValue["FCXsdNetAfHD_Footer"], 2);

    //                 // ******* Step 2 Set ค่า Value ให้กับตัวแปร
    //                 $tGrouppingData = $aValue["FTXshDocNo"];
    //                 $nStartRowData++;
    //             }

    //             // Step 7 : Set Footer Text
    //             $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
    //             $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
    //             if ($nPageNo == $nTotalPage) {
    //                 // Set Color Row Sub Footer
    //                 $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //                 $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->applyFromArray(array(
    //                     'borders' => array(
    //                         'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                         'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => '000000')),
    //                     ),
    //                 ));

    //                 // Text Sum Footer
    //                 $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':C' . $nStartRowData);
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptTotalFooter']);
    //                 $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //                 $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

    //                 // Set Row Style Type => Number
    //                 $objPHPExcel->getActiveSheet()->getStyle('F' . $nStartRowData . ':I' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);

    //                 // Value Sum Footer
    //                 $objPHPExcel->setActiveSheetIndex(0)
    //                     ->setCellValue('D' . $nStartRowData, number_format($nSumFootXsdQty, 0))
    //                     ->setCellValue('F' . $nStartRowData, number_format($cSumFootXsdAmtB4DisChg, 2))
    //                     ->setCellValue('G' . $nStartRowData, number_format($cSumFootXsdDis, 2))
    //                     ->setCellValue('H' . $nStartRowData, number_format($cSumFootXsdVat, 2))
    //                     ->setCellValue('I' . $nStartRowData, number_format($cSumFootXsdNetAfHD, 2));

    //                 $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    //             }
    //         } else {
    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':I' . $nStartRowData);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptNoData']);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
    //         }

    //         // ====================================================================================================================================================================
    //         // Set Content Type Export File Excel =================================================================================================================================
    //         $tFilename = 'Report-' . $tRptCode . date("dmYhis") . '.xlsx';

    //         header("Pragma: public");
    //         header("Expires: 0");
    //         header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //         header("Content-Type: application/force-download");
    //         header("Content-Type: application/octet-stream");
    //         header("Content-Type: application/download");

    //         header("Content-Disposition: attachment;filename=$tFilename");
    //         header("Content-Transfer-Encoding: binary");

    //         $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

    //         if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/')) {
    //             mkdir(APPPATH . 'modules/report/assets/exportexcel/');
    //         }

    //         if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode)) {
    //             mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode);
    //         }

    //         if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername)) {
    //             mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername);
    //         }

    //         $tPathExport = APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername . '/';
    //         $oFiles = glob($tPathExport . '*');
    //         foreach ($oFiles as $tFile) {
    //             if (is_file($tFile)) {
    //                 unlink($tFile);
    //             }

    //         }

    //         // Check Status Save File Excel
    //         $objWriter->save($tPathExport . $tFilename);
    //         $aResponse = array(
    //             'nStaExport' => 1,
    //             'tFileName' => $tFilename,
    //             'tPathFolder' => 'application/modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername . '/',
    //             'tMessage' => "Export File Successfully.",
    //         );
    //         // ====================================================================================================================================================================
    //     } catch (Exception $Error) {
    //         $aResponse = array(
    //             'nStaExport' => 500,
    //             'tMessage' => $Error->getMessage(),
    //         );
    //     }
    //     echo json_encode($aResponse);
    // }

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
            $nDataCountPage = $this->mRptSaleByProduct->FSnMCountRowInTemp($aDataCountData);
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

    /**
     * Functionality: Send Rabbit MQ Report
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 23/069/2019 Piya
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        $dDateSendMQ    = date('Y-m-d');
        $dTimeSendMQ    = date('H:i:s');
        $dDateSubscribe = date('Ymd');
        $dTimeSubscribe = date('His');
        // Set Parameter Send MQ
        $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

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

    /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 25/09/2020 Sooksanti
     * LastUpdate:
     * Return: file
     * ReturnType: file
     */
    public function FSvCCallRptRenderExcel()
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

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPosTypeName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBarchCode')),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBarchName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtGrp')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptQty')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptUnit')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptSales')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptDiscount')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptAverage')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptGrandSale')),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataWhereRpt = array(
            'nPerPage' => 999999999999,
            'nPage' => '1', // เริ่มทำงานหน้าแรก
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter' => $this->aRptFilter,
        );
        $aDataReport = $this->mRptSaleByProduct->FSaMGetDataReport($aDataWhereRpt);

        // /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                switch ($aValue['FNAppType']) {
                    case 1:
                        $tAppType = "Pos";
                        break;
                    case 2:
                        $tAppType = "Vending";
                        break;
                    default:
                        $tAppType = "-";
                        break;
                }
                $values = [
                    WriterEntityFactory::createCell($tAppType),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTBchCode']),
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPdtCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(($aValue['FTXsdPdtName'] == "" ? "-" : $aValue['FTXsdPdtName'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(($aValue['FTPgpChainName'] == "" ? "-" : $aValue['FTPgpChainName'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdQty'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPunName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdAmtB4DisChg'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdDis'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdSetPrice'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdNetAfHD'])),
                ];
                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);

                if (($nKey + 1) == FCNnHSizeOf($aDataReport['aRptData'])) { //SumFooter
                    $values = [
                        WriterEntityFactory::createCell($this->aText['tRptTotalAllSale']),
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
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCXsdQty_Footer"])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCXsdAmtB4DisChg_Footer"])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdDis_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        // WriterEntityFactory::createCell(null),
                        // WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdSetPrice_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdNetAfHD_Footer'])),
                    ];
                    $aRow = WriterEntityFactory::createRow($values, $oStyleColums);
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
     * Creator: 25/09/2020 Sooksanti
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
            WriterEntityFactory::createCell($this->aText['tRptTaxSalePosTaxId'] . ' : ' . $tFTAddTaxNo),
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
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRptTaxPointByCstDocDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptTaxPointByCstDocDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
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
    public function FSoCCallRptRenderFooterExcel()
    {

        $oStyleFilter = (new StyleBuilder())
            ->setFontBold()
            ->build();
        $aCells = [
            WriterEntityFactory::createCell(null),
        ];
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells, $oStyleFilter);

        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptConditionInReport']),
        ];
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells, $oStyleFilter);

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

        // เครื่องจุดขาย แบบเลือก
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

        // Fillter Prodict (สินค้า) แบบช่วง
        if (!empty($this->aRptFilter['tPdtCodeFrom']) && !empty($this->aRptFilter['tPdtCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPdtCodeFrom'] . ' : ' . $this->aRptFilter['tPdtNameFrom'] . '     ' . $this->aText['tPdtCodeTo'] . ' : ' . $this->aRptFilter['tPdtNameTo']),
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

        // Fillter Product Group (กลุ่มสินค้า)  แบบช่วง
        if (!empty($this->aRptFilter['tPdtGrpCodeFrom']) && !empty($this->aRptFilter['tPdtGrpCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPdtGrpFrom'] . ' : ' . $this->aRptFilter['tPdtGrpNameFrom'] . '     ' . $this->aText['tPdtGrpTo'] . ' : ' . $this->aRptFilter['tPdtGrpNameTo']),
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

        // Fillter Product Type (ประเภทสินค้า)  แบบช่วง
        if (!empty($this->aRptFilter['tPdtTypeCodeFrom']) && !empty($this->aRptFilter['tPdtTypeCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPdtTypeFrom'].' : '.$this->aRptFilter['tPdtTypeNameFrom'] . '     ' . $this->aText['tPdtTypeTo'].' : '.$this->aRptFilter['tPdtTypeNameTo']),
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

        if(isset($this->aRptFilter['tPosType'])){
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptPosTypeName'].' : '.$this->aText['tRptPosType'.$this->aRptFilter['tPosType']]),
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
