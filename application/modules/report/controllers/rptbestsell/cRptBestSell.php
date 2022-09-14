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

class cRptBestSell extends MX_Controller
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
        $this->load->model('report/reportbestsell/mRptBestSell');

        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init()
    {
        $this->aText = [
            'tTitleReport' => language('report/report/report', 'tTitleRptBestSell'),
            'tRptTaxNo' => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint' => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport' => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint' => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml' => language('report/report/report', 'tRptPrintHtml'),
            // Filter Heard Report
            'tRptBchFrom' => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo' => language('report/report/report', 'tRptBchTo'),
            'tPdtCodeFrom' => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo' => language('report/report/report', 'tPdtCodeTo'),
            'tPdtGrpFrom' => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo' => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom' => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo' => language('report/report/report', 'tPdtTypeTo'),
            'tRptShopFrom' => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo' => language('report/report/report', 'tRptShopTo'),
            'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo' => language('report/report/report', 'tRptDateTo'),
            'tPriority' => language('report/report/report', 'tPriority'),
            // Table Report
            'tPdtCode' => language('report/report/report', 'tRptAdjStkVDPdtCode'),
            'tPdtName' => language('report/report/report', 'tRptAdjStkVDPdtName'),
            'tPdtGrp' => language('report/report/report', 'tRptAdjStkVDPdtGrp'),
            'tQty' => language('report/report/report', 'tQty'),
            'tSales' => language('report/report/report', 'tSales'),
            'tDiscount' => language('report/report/report', 'tDiscount'),
            'tTotalsales' => language('report/report/report', 'tTotalsales'),
            'tRowNumber' => language('report/report/report', 'tRowNumber'),
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
            'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),
            'tRptUnit' => language('report/report/report', 'tRptUnit'),
            'tRptAverage' => language('report/report/report', 'tRptAverage'),
            'tRptPosType' => language('report/report/report', 'tRptPosType'),
            'tRptRetail' => language('report/report/report', 'tRptRetail'),
            'tRptVending' => language('report/report/report', 'tRptVending'),
            'tRptAll' => language('report/report/report', 'tRptAll'),
            'tRptPosType' => language('report/report/report', 'tRptPosType'),
            'tRptPosType1' => language('report/report/report', 'tRptPosType1'),
            'tRptPosType2' => language('report/report/report', 'tRptPosType2'),
            'tRptPosTypeName' => language('report/report/report', 'tRptPosTypeName'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),

            // No Data Report
            'tRptNoData' => language('common/main/main', 'tCMNNotFoundData'),
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

            'tRptTaxPointByCstDocDateFrom' => language('report/report/report', 'tRptTaxPointByCstDocDateFrom'),
            'tRptTaxPointByCstDocDateTo' => language('report/report/report', 'tRptTaxPointByCstDocDateTo'),
            'tRptFillterPdtTypeFrom' => language('report/report/report', 'tPdtTypeFrom'),
            'tRptFillterPdtTypeTo' => language('report/report/report', 'tPdtTypeTo'),
            'tRptFillterShopFrom' => language('report/report/report', 'tRptShopFrom'),
            'tRptFillterGrpFrom' => language('report/report/report', 'tRptPaymentGrpFrom'),
            'tRptFillterGrpTo' => language('report/report/report', 'tRptPaymentGrpTo'),
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

            // Top
            'tTopPdt' => !empty($this->input->post('ocmBchPriority')) ? $this->input->post('ocmBchPriority') : "",

            // PosType
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
            $this->mRptBestSell->FSnMExecStoreReport($this->aRptFilter);

            $aDataSwitchCase = array(
                'tRptRoute' => $this->tRptRoute,
                'tRptCode' => $this->tRptCode,
                'tRptTypeExport' => $this->tRptExportType,
                'aDataFilter' => $this->aRptFilter,
            );
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    break;
                // case 'pdf':
                //     $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                //     break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 04/04/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($aData)
    {

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode' => $this->tUserLoginCode,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'nPage' => 1, // เริ่มรายงานหน้าแรก
            'nRow' => $this->nPerPage,
            'aDataFilter' => $this->aRptFilter,
        );

        // Get Data Report
        $aDataReport = $this->mRptBestSell->FSaMGetDataReport($aDataWhere); //Get Data

        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataWhere); // Draw Table

        $aDataView = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => $aDataReport,
            'aCompanyInfo' => $this->aCompanyInfo,
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 19/04/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage()
    {

        /** =========== Begin Init Variable ==================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ====================================*/

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'nPage' => $this->nPage,
            'nRow' => $this->nPerPage,
            'aDataFilter' => $this->aRptFilter,
        );
        // print_r($aDataWhere); exit();
        // Get Data Report
        $aDataReport = $this->mRptBestSell->FSaMGetDataReport($aDataWhere);
        // print_r('=='.$aDataReport['rtCode']);

        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataWhere);

        $aDataView = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => $aDataReport,
            'aCompanyInfo' => $this->aCompanyInfo,
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
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataFilter)
    {

        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\rptBestSell\rRptBestSell.php';

        if (@$aDataReport['rnCurrentPage'] == @$aDataReport['rnAllPage']) {
            // เรียก Summary เฉพาะหน้าสุดท้าย
            @$aSumDataReport = $this->mRptBestSell->FSaMGetDataSumFootReport($paDataFilter);
        }

        // Set Parameter To Report
        $oRptBestSellHtml = new rRptBestSell(array(
            'nCurrentPage' => $paDataReport['rnCurrentPage'],
            'nAllPage' => $paDataReport['rnAllPage'],
            'aDataFilter' => $paDataFilter,
            'aDataTextRef' => $this->aText,
            'aDataReturn' => $paDataReport,
            'aCompanyInfo' => $this->aCompanyInfo,
            'aSumDataReport' => $aSumDataReport,
        ));

        $oRptBestSellHtml->run();
        $tHtmlViewReport = $oRptBestSellHtml->render('wRptBestSellHtml', true);
        return $tHtmlViewReport;
    }

    // Functionality: Function Count Data Report And Calcurate
    // Parameters:  Function Parameter
    // Creator: 12/08/2019 Sarun
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    // public function FSvCCallRptRenderExcel($paDataSwitchCase)
    // {
    //     try {
    //         $tRptRoute = $paDataSwitchCase['tRptRoute'];
    //         $tRptCode = $paDataSwitchCase['tRptCode'];
    //         $tRptTypeExport = $paDataSwitchCase['tRptTypeExport'];
    //         $aDataFilter = $paDataSwitchCase['aDataFilter'];
    //         $nPage = 1;
    //         $nLangEdit = $this->session->userdata("tLangEdit");
    //         $tSesUsername = $this->session->userdata('tSesUsername');
    //         $tUsrSessionID = $this->session->userdata('tSesSessionID');

    //         // Get data Company
    //         $aDataAddress = array();
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
    //             'tTitleReport' => language('report/report/report', 'tTitleRptBestSell'),
    //             'tRptTaxNo' => language('report/report/report', 'tRptTaxNo'),
    //             'tRptDatePrint' => language('report/report/report', 'tRptDatePrint'),
    //             'tRptTimePrint' => language('report/report/report', 'tRptTimePrint'),
    //             'tRptDateExport' => language('report/report/report', 'tRptDateExport'),
    //             'tRptPrintHtml' => language('report/report/report', 'tRptPrintHtml'),
    //             'tRptBranch' => language('report/report/report', 'tRptBranch'),
    //             'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
    //             'tRptTel' => language('report/report/report', 'tRptTel'),

    //             // Filter Heard Report
    //             'tRptFillterBchFrom' => language('report/report/report', 'tRptBchFrom'),
    //             'tRptFillterBchTo' => language('report/report/report', 'tRptBchTo'),
    //             'tRptFillterShopFrom' => language('report/report/report', 'tRptShopFrom'),
    //             'tRptFillterShopTo' => language('report/report/report', 'tRptShopTo'),
    //             'tRptFillterDateFrom' => language('report/report/report', 'tRptDateFrom'),
    //             'tRptFillterDateTo' => language('report/report/report', 'tRptDateTo'),
    //             'tRptFillterGrpFrom' => language('report/report/report', 'tRptPaymentGrpFrom'),
    //             'tRptFillterGrpTo' => language('report/report/report', 'tRptPaymentGrpTo'),
    //             'tRptFillterPdtTypeFrom' => language('report/report/report', 'tPdtTypeFrom'),
    //             'tRptFillterPdtTypeTo' => language('report/report/report', 'tPdtTypeTo'),
    //             'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),
    //             // Table Report
    //             'tRptNo' => language('report/report/report', 'tRowNumber'),
    //             'tRptPdtCode' => language('report/report/report', 'tRptPdtCode'),
    //             'tRptPdtName' => language('report/report/report', 'tRptPdtName'),
    //             'tRptPdtGroup' => language('report/report/report', 'tRptPdtGrp'),
    //             'tRptPdtQty' => language('report/report/report', 'tPdtQty'),
    //             'tRptPdtSale' => language('report/report/report', 'tSales'),
    //             'tRptDisChg' => language('report/report/report', 'tRptDisChg'),
    //             'tRptPdtTotalSal' => language('report/report/report', 'tTotalsales'),
    //             'tRptTotal' => language('report/report/report', 'tRptTotalSub'),
    //             'tRptDataReportNotFound' => language('report/report/report', 'tRptDataReportNotFound'),
    //             'tRptUnit' => language('report/report/report', 'tRptUnit'),
    //             'tRptAverage' => language('report/report/report', 'tRptAverage'),

    //             'tRptRetail' => language('report/report/report', 'tRptRetail'),
    //             'tRptVending' => language('report/report/report', 'tRptVending'),
    //             'tRptAll' => language('report/report/report', 'tRptAll'),
    //             'tRptPosType' => language('report/report/report', 'tRptPosType'),
    //             'tRptPosType1' => language('report/report/report', 'tRptPosType1'),
    //             'tRptPosType2' => language('report/report/report', 'tRptPosType2'),
    //             'tRptPosTypeName' => language('report/report/report', 'tRptPosTypeName'),

    //             // Address Lang
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
    //             'tRptPosType' => language('report/report/report', 'tRptPosType'),
    //         );

    //         /** ================================== Begin Init Variable Excel ================================== */
    //         $tReportName = $aDataTextRef['tTitleReport'];
    //         $dDateExport = date('Y-m-d');
    //         $tTime = date('H:i:s');
    //         /** ===================================== End Init Variable ======================================= */
    //         /** ======================================= Begin Get Data ======================================== */
    //         $aCompInfoParams = ['nLngID' => FCNaHGetLangEdit()];
    //         $aCompData = FCNaGetCompanyInfo($aCompInfoParams);

    //         // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
    //         $aDataWhere = array(
    //             'tRptCode' => $tRptCode,
    //             'nPage' => $nPage,
    //             'nRow' => 100000,
    //             'tUserSession' => $this->session->userdata('tSesSessionID'),
    //             'tUserCode' => $this->session->userdata('tSesUsername'),
    //             'tCompName' => $this->tCompName,
    //             'aDataFilter' => $this->aRptFilter,
    //         );

    //         // Get Data ReportFSaMGetDataReport
    //         $aDataReport = $this->mRptBestSell->FSaMGetDataReport($aDataWhere, $aDataFilter);

    //         //  GetDataSumFootReport
    //         $aDataSumFoot = $this->mRptBestSell->FSaMGetDataSumFootReport($aDataWhere, $aDataFilter);

    //         /** =============================================================================================== */
    //         // ตั้งค่า Font Style
    //         $aStyleRptFont = array('font' => array('name' => 'TH Sarabun New'));
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

    //         // Set Font Style
    //         $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($aStyleRptFont);

    //         // จัดความกว้างของคอลัมน์
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(20);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(30);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(20);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //         $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);

    //         // ชื่อหัวรายงาน
    //         $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:H1');
    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tReportName);
    //         $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //         $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptSizeTitleName);

    //         // Check Address Data
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

    //         // ======================================================================== Filter Data Report ========================================================================
    //         // Row เริ่มต้นของ Filter
    //         $nStartRowFillter = 2;
    //         $tFillterColumLEFT = "D";
    //         $tFillterColumRIGHT = "F";

    //         // Fillter ฺBranch (สาขา)
    //         if (!empty($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeTo'])) {
    //             $tRptFilterBranchCodeFrom = $aDataTextRef['tRptFillterBchFrom'] . ' ' . $aDataFilter['tBchNameFrom'];
    //             $tRptFilterBranchCodeTo = $aDataTextRef['tRptFillterBchTo'] . ' ' . $aDataFilter['tBchNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterBranchCodeFrom . ' ' . $tRptFilterBranchCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
    //             $nStartRowFillter += 1;
    //         }

    //         // Fillter Shop (ร้านค้า)
    //         if (!empty($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeTo'])) {
    //             $tRptFilterShopCodeFrom = $aDataTextRef['tRptFillterShopFrom'] . ' ' . $aDataFilter['tShpNameFrom'];
    //             $tRptFilterShopCodeTo = $aDataTextRef['tRptFillterShopTo'] . ' ' . $aDataFilter['tShpNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterShopCodeFrom . ' ' . $tRptFilterShopCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
    //             $nStartRowFillter += 1;
    //         }

    //         // Fillter ฺPdt Grp (กลุ่มสินค้า)
    //         if (!empty($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeTo'])) {
    //             $tRptFilterRcvCodeFrom = $aDataTextRef['tRptFillterGrpFrom'] . ' ' . $aDataFilter['tPdtGrpNameFrom'];
    //             $tRptFilterRcvCodeTo = $aDataTextRef['tRptFillterGrpTo'] . ' ' . $aDataFilter['tPdtGrpNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
    //             $nStartRowFillter += 1;
    //         }

    //         // Fillter ฺPdt Type (ประเภทสินค้า)
    //         if (!empty($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeTo'])) {
    //             $tRptFilterRcvCodeFrom = $aDataTextRef['tRptFillterPdtTypeFrom'] . ' ' . $aDataFilter['tPdtTypeNameFrom'];
    //             $tRptFilterRcvCodeTo = $aDataTextRef['tRptFillterPdtTypeTo'] . ' ' . $aDataFilter['tPdtTypeNameTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterRcvCodeFrom . ' ' . $tRptFilterRcvCodeTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
    //             $nStartRowFillter += 1;
    //         }
    //         // Fillter DocDate (วันที่สร้างเอกสาร)
    //         if (!empty($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateTo'])) {
    //             $tRptFilterDocDateFrom = $aDataTextRef['tRptFillterDateFrom'] . ' ' . $aDataFilter['tDocDateFrom'];
    //             $tRptFilterDocDateTo = $aDataTextRef['tRptFillterDateTo'] . ' ' . $aDataFilter['tDocDateTo'];
    //             $tRptTextLeftRightFilter = $tRptFilterDocDateFrom . ' ' . $tRptFilterDocDateTo;
    //             $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
    //             $nStartRowFillter += 1;
    //         }

    //         // ====================================================================================================================================================================
    //         // ========================================================================== Date Time Print =========================================================================
    //         $tRptDateTimeExportText = $aDataTextRef['tRptDatePrint'] . ' ' . $dDateExport . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . $tTime;
    //         $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A7:H7');
    //         $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A7', $tRptDateTimeExportText);
    //         $objPHPExcel->getActiveSheet()->getStyle("A7")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    //         $objPHPExcel->getActiveSheet()->getStyle('A7')->applyFromArray($aStyleRptSizeAddressFont);
    //         // ====================================================================================================================================================================
    //         // ==================================================================== หัวตารางรายงาน ==================================================================================
    //         // กำหนดจุดเริ่มต้นของแถวหัวตาราง
    //         $nStartRowHeadder = 8;

    //         // กำหนด Style Font ของหัวตาราง
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':H' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':H' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':H' . $nStartRowHeadder)->applyFromArray(array(
    //             'borders' => array(
    //                 'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                 'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //             ),
    //         ));

    //         // กำหนดข้อมูลลงหัวตาราง
    //         $objPHPExcel->setActiveSheetIndex(0)
    //             ->setCellValue('A' . $nStartRowHeadder, $aDataTextRef['tRptNo'])
    //             ->setCellValue('B' . $nStartRowHeadder, $aDataTextRef['tRptPdtCode'])
    //             ->setCellValue('C' . $nStartRowHeadder, $aDataTextRef['tRptPdtName'])
    //             ->setCellValue('D' . $nStartRowHeadder, $aDataTextRef['tRptPdtGroup'])
    //             ->setCellValue('E' . $nStartRowHeadder, $aDataTextRef['tRptPdtQty'])
    //             ->setCellValue('F' . $nStartRowHeadder, $aDataTextRef['tRptPdtSale'])
    //             ->setCellValue('G' . $nStartRowHeadder, $aDataTextRef['tRptDisChg'])
    //             ->setCellValue('H' . $nStartRowHeadder, $aDataTextRef['tRptPdtTotalSal']);

    //         // Alignment ของหัวตาราง
    //         $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':H' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //         // ====================================================================================================================================================================
    //         // ==================================================================== ข้อมูลรายละเอียดรายงาน ===========================================================================
    //         // Set Variable Data
    //         $nStartRowData = $nStartRowHeadder + 1;
    //         // echo '<pre>';
    //         // print_r($aDataReport);exit();
    //         if ($aDataReport['rtCode'] == 1) {
    //             foreach ($aDataReport['raItems'] as $nKey => $aValue) {

    //                 $objPHPExcel->setActiveSheetIndex(0)
    //                     ->setCellValue('A' . $nStartRowData, $aValue['rtRowID'])
    //                     ->setCellValue('B' . $nStartRowData, $aValue['FTPdtCode'])
    //                     ->setCellValue('C' . $nStartRowData, $aValue['FTXsdPdtName'])
    //                     ->setCellValue('D' . $nStartRowData, $aValue['FTPgpChainName'])
    //                     ->setCellValue('E' . $nStartRowData, number_format(floatval($aValue['FCXsdQty']), 2))
    //                     ->setCellValue('F' . $nStartRowData, number_format(floatval($aValue['FCXsdDigChg']), 2))
    //                     ->setCellValue('G' . $nStartRowData, number_format(floatval($aValue['FCXsdDis']), 2))
    //                     ->setCellValue('H' . $nStartRowData, number_format(floatval($aValue['FCXsdNetAfHD']), 2));

    //                 $objPHPExcel->getActiveSheet()->getStyle('E' . $nStartRowData . ':H' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    //                 $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':D' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //                 $objPHPExcel->getActiveSheet()->getStyle('E' . $nStartRowData . ':H' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    //                 $nStartRowData++;
    //             }
    //         } else {
    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':H' . $nStartRowData);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptDataReportNotFound']);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
    //         }

    //         // // Step 7 : Set Footer Text
    //         $nPageNo = $aDataReport['rnCurrentPage'];
    //         $nTotalPage = $aDataReport['rnAllPage'];

    //         if ($nPageNo == $nTotalPage) {
    //             // Set Color Row Sub Footer
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':H' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':H' . $nStartRowData)->applyFromArray(array(
    //                 'borders' => array(
    //                     'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => '000000')),
    //                 ),
    //             ));

    //             // LEFT
    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':D' . $nStartRowData);
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aDataTextRef['tRptTotal']);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

    //             // RIGHT
    //             $objPHPExcel->setActiveSheetIndex(0)
    //                 ->setCellValue('E' . $nStartRowData, number_format($aDataSumFoot['FCXsdSumQty'], 2))
    //                 ->setCellValue('F' . $nStartRowData, number_format($aDataSumFoot['FCXsdSumDigChg'], 2))
    //                 ->setCellValue('G' . $nStartRowData, number_format($aDataSumFoot['FCXsdSumDis'], 2))
    //                 ->setCellValue('H' . $nStartRowData, number_format($aDataSumFoot['FCSumFooter'], 2));
    //             $objPHPExcel->getActiveSheet()->getStyle('E' . $nStartRowData . ':H' . $nStartRowData)->getNumberFormat()->setFormatCode(PHPExcel_Style_NumberFormat::FORMAT_NUMBER_COMMA_SEPARATED1);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':G' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
    //             $objPHPExcel->getActiveSheet()->getStyle('E' . $nStartRowData . ':H' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
    //         }
    //         // ====================================================================================================================================================================
    //         //  ======================================================= Set Content Type Export File Excel =======================================================
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
    //         // ===================================================================================================================================================
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
     * LastUpdate: 21/08/2019 Saharat(Golf)
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase)
    {

        try {
            $aDataCountData = [
                'tCompName' => $paDataSwitchCase['aDataFilter']['tCompName'],
                'tRptCode' => $paDataSwitchCase['aDataFilter']['tRptCode'],
                'tUserSession' => $paDataSwitchCase['aDataFilter']['tUserSession'],
            ];

            $nDataCountPage = $this->mRptBestSell->FSnMCountDataReportAll($aDataCountData);

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
     * LastUpdate: 21/08/2019 Saharat(Golf)
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
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
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtGrp')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRPC8TBQty')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptUnit')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tSales')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptDisChg')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptAverage')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tTotalsales')),
            WriterEntityFactory::createCell(null),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aGetDataReportParams = array(
            'tUserSession' => $this->tUserSessionID,
            'tUserCode' => $this->tUserLoginCode,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'nPage' => 1, // เริ่มรายงานหน้าแรก
            'nRow' => 99999999,
            'aDataFilter' => $this->aRptFilter,
        );

        // Get Data Report
        $aDataReport = $this->mRptBestSell->FSaMGetDataReport($aGetDataReportParams); //Get Data

        // /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) {
            foreach ($aDataReport['raItems'] as $nKey => $aValue) {
                $values = [
                    WriterEntityFactory::createCell($aValue['FTPdtCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTXsdPdtName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPgpChainName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdQty'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPunName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdDigChg'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdDis'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdSetPrice'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXsdNetAfHD'])),
                    WriterEntityFactory::createCell(null),
                ];
                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);

                if (($nKey + 1) == FCNnHSizeOf($aDataReport['raItems'])) { //SumFooter
                    $aDataSumFoot = $this->mRptBestSell->FSaMGetDataSumFootReport($aGetDataReportParams, $this->aRptFilter);
                    $values = [
                        WriterEntityFactory::createCell($this->aText['tRptTotalFooter']),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aDataSumFoot['FCXsdSumQty'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aDataSumFoot['FCXsdSumDigChg'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aDataSumFoot['FCXsdSumDis'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aDataSumFoot['FCSumFooter'])),
                        WriterEntityFactory::createCell(null),
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

        // อันดับรายการ
        if (!empty($this->aRptFilter['tTopPdt']) && !empty($this->aRptFilter['tTopPdt'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPriority'] . ' : ' . $this->aRptFilter['tTopPdt']),
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
        if (isset($this->aRptFilter['tBchCodeSelect']) && !empty($this->aRptFilter['tBchCodeSelect'])) {
            $tBchSelect = ($this->aRptFilter['bBchStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tBchNameSelect'];
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptBchFrom'] . ' : ' . $tBchSelect),
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
                WriterEntityFactory::createCell($this->aText['tRptFillterShopFrom'] . ' : ' . $tShpSelectText),
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
            $tMerSelect = ($this->aRptFilter['bMerStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tMerNameSelect'];
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptMerFrom'] . ' : ' . $tMerSelect),
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

        // ประเภทสินค้า
        if (!empty($this->aRptFilter['tPdtTypeCodeFrom']) && !empty($this->aRptFilter['tPdtTypeCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptFillterPdtTypeFrom'] . ' : ' . $this->aRptFilter['tPdtTypeNameFrom'] . '     ' . $this->aText['tRptFillterPdtTypeTo'] . ' : ' . $this->aRptFilter['tPdtTypeNameTo']),
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

        // กลุ่มสินค้า
        if (!empty($this->aRptFilter['tPdtGrpCodeFrom']) && !empty($this->aRptFilter['tPdtGrpCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptFillterGrpFrom'] . ' : ' . $this->aRptFilter['tPdtGrpNameFrom'] . '     ' . $this->aText['tRptFillterGrpTo'] . ' : ' . $this->aRptFilter['tPdtGrpNameTo']),
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

        // สินค้า
        if (!empty($this->aRptFilter['tPdtCodeFrom']) && !empty($this->aRptFilter['tPdtCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPdtCodeFrom'].' : '.$this->aRptFilter['tPdtNameFrom'] . '     ' . $this->aText['tPdtCodeTo'].' : '.$this->aRptFilter['tPdtNameTo']),
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

        if (isset($this->aRptFilter['tPosType'])) {
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
