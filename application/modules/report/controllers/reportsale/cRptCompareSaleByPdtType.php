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

class cRptCompareSaleByPdtType extends MX_Controller
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
     * User Login Session
     * @var string
     */
    public $tSysBchCode;


    public function __construct()
    {

        $this->load->helper('report');
        $this->load->library('zip');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsale/mRptCompareSaleByPdtType');

        // Init Report
        $this->init();

        $this->load->model('sale/dashboardsale/mDashBoardSale');
        if (!is_dir('./application/modules/sale/assets/koolreport')) {
            mkdir('./application/modules/sale/assets/koolreport');
        }
        // เช็ค Folder Systemtemp
        if (!is_dir('./application/modules/sale/assets/sysdshtemp')) {
            mkdir('./application/modules/sale/assets/sysdshtemp');
        }

        parent::__construct();
    }

    private function init()
    {
        $this->aText = [

            'tTitleReport'       => language('report/report/report', 'tRptCompareSaleByPdtTitleYTD'),
            'tDatePrint'         => language('report/report/report', 'tRptCompareSaleByPdtDatePrint'),
            'tTimePrint'         => language('report/report/report', 'tRptCompareSaleByPdtTimePrint'),
            'tRptCompareSaleTel' => language('report/report/report', 'tRptSaleByCashierAndPosTel'),
            'tRPCTaxNo'          => language('report/report/report', 'tRPCTaxNo'),

            //Group Report
            'tRptGrpBranch'     => language('report/report/report', 'tRptGrpBranch'),
            'tRptGrpAgency'     => language('report/report/report', 'tRptGrpAgency'),
            'tRptGrpShop'       => language('report/report/report', 'tRptGrpShop'),
            'tRptGrpPdtType'    => language('report/report/report', 'tRptGrpPdtType'),
            'tRptGrpPdtGroup'   => language('report/report/report', 'tRptGrpPdtGroup'),
            'tRptGrpPdtBrand'   => language('report/report/report', 'tRptGrpPdtBrand'),
            'tRptGrpPdtModel'   => language('report/report/report', 'tRptGrpPdtModel'),
            'tRptGrpPdtSpl'     => language('report/report/report', 'tRptGrpPdtSpl'),

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
            'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
            'tRptTel' => language('report/report/report', 'tRptTel'),
            // Table Label
            'tRptBranchCode'        => language('report/report/report', 'tRptBranchCode'),  //รหัสสาขา
            'tRptBranchName'        => language('report/report/report', 'tRptBranchName'),  //ชื่อสาขา
            'tRptAgnCode'           => language('report/report/report', 'tRptAgnCode'),  // รหัสตัวแทนขาย
            'tRptAgnName'           => language('report/report/report', 'tRptAgnName'),  //ชื่อตัวแทนขาย
            'tRptShopCode'          => language('report/report/report', 'tRptShopCode'), //รหัสร้านค้า
            'tRptShopName'          => language('report/report/report', 'tRptShopName'), //ชื่อร้านค้า
            'tRPtPdtTypeCode'       => language('report/report/report', 'tRPtPdtType'),  // รหัสประเภทสินค้า
            'tRPtPdtTypeName'       => language('report/report/report', 'tRPtPdtTypeName'), // ชื่อประเภทสินค้า
            'tRptPdtGrpCode'        => language('report/report/report', 'tRptPdtGrpCode'),  //รหัสกลุ่มสินค้า
            'tRptPdtGrpName'        => language('report/report/report', 'tRptPdtGrpName'),  //ชื่อกลุ่มสินค้า
            'tRptPdtBrandCode'      => language('report/report/report', 'tRptPdtBrandCode'), // รหัสยี่ห้อ
            'tRptPdtBrandName'      => language('report/report/report', 'tRptPdtBrandName'), // ชื่อยี่ห้อ
            'tRptPdtModelCode'      => language('report/report/report', 'tRptPdtModelCode'), //รหัสรุ่น
            'tRptPdtModelName'      => language('report/report/report', 'tRptPdtModelName'), //ชื่อรุ่น
            'tRptPdtSplCode'        => language('report/report/report', 'tRptPdtSplCode'), //รหัสผู้จำหน่าย
            'tRptPdtSplName'        => language('report/report/report', 'tRptPdtSplName'), //ชื่อผู้จำหน่าย


            'tRptCompareLY'         => language('report/report/report', 'tRptCompareLY'), //Compare LY
            'tRptPdtTypeSaleLY'     => language('report/report/report', 'tRptPdtTypeSaleLY'),
            'tRptPdtTypeSaleTY'     => language('report/report/report', 'tRptPdtTypeSaleTY'),
            'tRptPerCen'            => language('report/report/report', 'tRptPerCen'), //%
            'tRptQty'               => language('report/report/report', 'tRptQty'),  //Qty


            // No Data Report
            'tRptSaleByCashierAndPosNoData' => language('common/main/main', 'tCMNNotFoundData'),
            'tRptSaleByCashierAndPosTotalFooter'   => language('report/report/report', 'tRptSaleByCashierAndPosTotalFooter'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptGroupRpt'            => language('report/report/report', 'tRptGroupRpt'),
            'tRptTaxSalePosTotalSub' => language('report/report/report', 'tRptTaxSalePosTotalSub'),

            // Fillter
            'tRptBchFrom'       => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'         => language('report/report/report', 'tRptBchTo'),
            'tRptMerFrom'       => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'         => language('report/report/report', 'tRptMerTo'),
            'tRptShopFrom'      => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'        => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom'       => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'         => language('report/report/report', 'tRptPosTo'),
            'tPdtCodeFrom'      => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo'        => language('report/report/report', 'tPdtCodeTo'),
            'tRptYear'          => language('report/report/report', 'tRptYear'),
            'tRptMonth'         => language('report/report/report', 'tRptMonth'),
            'tRptAll'           => language('report/report/report', 'tRptAll'),
            'tRptDateFrom'      => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'        => language('report/report/report', 'tRptDateTo'),
            'tPdtTypeFrom'      => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'        => language('report/report/report', 'tPdtTypeTo'),
            'tPdtGrpFrom'       => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'         => language('report/report/report', 'tPdtGrpTo'),
            'tRptBrandFrom'      => language('report/report/report', 'tRptBrandFrom'),
            'tRptBrandTo'        => language('report/report/report', 'tRptBrandTo'),
            'tRptModelFrom'      => language('report/report/report', 'tRptModelFrom'),
            'tRptModelTo'        => language('report/report/report', 'tRptModelTo'),

            //กลุ่มรายงาน
            'tRptGroupRpt01'    => language('report/report/report', 'tRptGroupRpt01'),
            'tRptGroupRpt02'    => language('report/report/report', 'tRptGroupRpt02'),
            'tRptGroupRpt03'    => language('report/report/report', 'tRptGroupRpt03'),
            'tRptGroupRpt04'    => language('report/report/report', 'tRptGroupRpt04'),
            'tRptGroupRpt05'    => language('report/report/report', 'tRptGroupRpt05'),
            'tRptGroupRpt06'    => language('report/report/report', 'tRptGroupRpt06'),
            'tRptGroupRpt07'    => language('report/report/report', 'tRptGroupRpt07'),
            'tRptGroupRpt08'    => language('report/report/report', 'tRptGroupRpt08'),

            'tRptSaleByCashierAndPosFilterDocDateFrom' => language('report/report/report', 'tRptSaleByCashierAndPosFilterDocDateFrom'),
            'tRptSaleByCashierAndPosFilterDocDateTo' => language('report/report/report', 'tRptSaleByCashierAndPosFilterDocDateTo'),

            'tRptPdtTypeYTD'    => language('report/report/report', 'tRptPdtTypeYTD'),
            'tRptPdtTypeYTDVal' => language('report/report/report', 'tRptPdtTypeYTDVal'),
            'tRptAmt'           => language('report/report/report', 'tRptAmt'),
            'tRptPdtTypegraph'  => language('report/report/report', 'tRptPdtTypegraph'),
            'tRptProductCode'   => language('report/report/report', 'tRptProductCode'),
            'tRptProductName'   => language('report/report/report', 'tRptProductName'),
            'tRptProduct'       => language('report/report/report', 'tRptProduct'),

        ];

        $this->tSysBchCode = SYS_BCH_CODE;
        $this->tBchCodeLogin = $this->session->userdata('tSesUsrBchCom');
        $this->nPerPage = 100;
        $this->nOptDecimalShow = FCNxHGetOptionDecimalShow();

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost = 'Adasoft Report';
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
            'tUserSession'  => $this->tUserSessionID,
            'tCompName'     => $tFullHost,
            'tRptCode'      => $this->tRptCode,
            'nLangID'       => $this->nLngID,

            'tTypeSelect'   => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // ตัวแทนขาย
            'tAgnCodeSelect'    => !empty($this->input->post('oetSpcAgncyCode')) ? $this->input->post('oetSpcAgncyCode') : "",
            'tAgnNameSelect'    => !empty($this->input->post('oetSpcAgncyName')) ? $this->input->post('oetSpcAgncyName') : "",

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

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeFrom'      => (empty($this->input->post('oetRptPosCodeFrom'))) ? '' : $this->input->post('oetRptPosCodeFrom'),
            'tPosNameFrom'      => (empty($this->input->post('oetRptPosNameFrom'))) ? '' : $this->input->post('oetRptPosNameFrom'),
            'tPosCodeTo'        => (empty($this->input->post('oetRptPosCodeTo'))) ? '' : $this->input->post('oetRptPosCodeTo'),
            'tPosNameTo'        => (empty($this->input->post('oetRptPosNameTo'))) ? '' : $this->input->post('oetRptPosNameTo'),
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'      => !empty($this->input->post('oetRptOneDateFrom')) ? $this->input->post('oetRptOneDateFrom') : "",

            // กลุ่มรายงาน
            'tGroupReport'  => !empty($this->input->post('ocmGroupReport')) ? $this->input->post('ocmGroupReport') : "",

            // กลุ่มสินค้า
            'tPdtGrpCodeFrom'   => !empty($this->input->post('oetRptPdtGrpCodeFrom')) ? $this->input->post('oetRptPdtGrpCodeFrom') : "",
            'tPdtGrpNameFrom'   => !empty($this->input->post('oetRptPdtGrpNameFrom')) ? $this->input->post('oetRptPdtGrpNameFrom') : "",
            'tPdtGrpCodeTo'     => !empty($this->input->post('oetRptPdtGrpCodeTo')) ? $this->input->post('oetRptPdtGrpCodeTo') : "",
            'tPdtGrpNameTo'     => !empty($this->input->post('oetRptPdtGrpNameTo')) ? $this->input->post('oetRptPdtGrpNameTo') : "",

            // ประเภทสินค้า
            'tPdtTypeCodeFrom'  => !empty($this->input->post('oetRptPdtTypeCodeFrom')) ? $this->input->post('oetRptPdtTypeCodeFrom') : "",
            'tPdtTypeNameFrom'  => !empty($this->input->post('oetRptPdtTypeNameFrom')) ? $this->input->post('oetRptPdtTypeNameFrom') : "",
            'tPdtTypeCodeTo'    => !empty($this->input->post('oetRptPdtTypeCodeTo')) ? $this->input->post('oetRptPdtTypeCodeTo') : "",
            'tPdtTypeNameTo'    => !empty($this->input->post('oetRptPdtTypeNameTo')) ? $this->input->post('oetRptPdtTypeNameTo') : "",

            // สินค้า
            'tPdtCodeFrom'      => !empty($this->input->post('oetRptPdtCodeFrom')) ? $this->input->post('oetRptPdtCodeFrom') : "",
            'tPdtNameFrom'      => !empty($this->input->post('oetRptPdtNameFrom')) ? $this->input->post('oetRptPdtNameFrom') : "",
            'tPdtCodeTo'        => !empty($this->input->post('oetRptPdtCodeTo')) ? $this->input->post('oetRptPdtCodeTo') : "",
            'tPdtNameTo'        => !empty($this->input->post('oetRptPdtNameTo')) ? $this->input->post('oetRptPdtNameTo') : "",

            // ยี่ห้อ
            'tPdtBrandCodeFrom'  => !empty($this->input->post('oetRptBrandCodeFrom')) ? $this->input->post('oetRptBrandCodeFrom') : "",
            'tPdtBrandNameFrom'  => !empty($this->input->post('oetRptBrandNameFrom')) ? $this->input->post('oetRptBrandNameFrom') : "",
            'tPdtBrandCodeTo'    => !empty($this->input->post('oetRptBrandCodeTo')) ? $this->input->post('oetRptBrandCodeTo') : "",
            'tPdtBrandNameTo'    => !empty($this->input->post('oetRptBrandNameTo')) ? $this->input->post('oetRptBrandNameTo') : "",

            // รุ่น
            'tPdtModelCodeFrom'  => !empty($this->input->post('oetRptModelCodeFrom')) ? $this->input->post('oetRptModelCodeFrom') : "",
            'tPdtModelNameFrom'  => !empty($this->input->post('oetRptModelNameFrom')) ? $this->input->post('oetRptModelNameFrom') : "",
            'tPdtModelCodeTo'    => !empty($this->input->post('oetRptModelCodeTo')) ? $this->input->post('oetRptModelCodeTo') : "",
            'tPdtModelNameTo'    => !empty($this->input->post('oetRptModelNameTo')) ? $this->input->post('oetRptModelNameTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin,
        ];

        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index()
    {
        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->mRptCompareSaleByPdtType->FSnMExecStoreReport($this->aRptFilter);

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
     * Creator: 3/01/2021 Witsarut (Bell)
     * LastUpdate:
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint()
    {

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'  => $this->nPerPage,
            'nPage'     => '1', // เริ่มทำงานหน้าแรก
            'tCompName' => $this->tCompName,
            'tRptCode'  => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter' => $this->aRptFilter,
        );


        $aDataReport = $this->mRptCompareSaleByPdtType->FSaMGetDataReport($aDataWhereRpt);


        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter'     => $this->aRptFilter,
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptCompareSaleByPdtType', 'wRpCompareSaleByPdtTypeHtml', $aDataViewRpt);


        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
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
     * Creator: 23/01/2020 Witsarut (Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage()
    {

        /** ===== Begin Init Variable ==================================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** ===== End Init Variable ====================================================*/

        /** ===== Begin Get Data =======================================================*/
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'nPerPage'  => $this->nPerPage,
            'nPage'     => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode'  => $this->tRptCode,
            'aRptFilter' => $this->aRptFilter,
            'tUsrSessionID' => $this->tUserSessionID,
        ];

        $aDataReport = $this->mRptCompareSaleByPdtType->FSaMGetDataReport($aDataReportParams);

        /** ===== Begin Render View ====================================================*/
        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aDataFilter'     => $aDataFilter,
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptCompareSaleByPdtType', 'wRpCompareSaleByPdtTypeHtml', $aDataViewRptParams);


        // Data Viewer Center Report
        $aDataViewerParams = array(
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

        $this->load->view('report/report/wReportViewer', $aDataViewerParams);
    }


    /**
     * Functionality: Render Excel Report Header
     * Parameters:  Function Parameter
     * Creator: 30/09/2020 Sooksanti
     * LastUpdate:
     * Return: oject
     * ReturnType: oject
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

        $oBorder = (new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
            ->build();

        $oStyleColums = (new StyleBuilder())
            ->setBorder($oBorder)
            ->setFontBold()
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtTypeYTD')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtTypeYTDVal')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
        ];
        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataFillter = array(
            'aRptFilter' => $this->aRptFilter,
        );

        $nTypeGroupReport  = $aDataFillter['aRptFilter']['tGroupReport'];

        if ($nTypeGroupReport == '01') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptBranchCode');  //รหัสสาขา
            $tRptTypeGrpName    = language('report/report/report', 'tRptBranchName');   //ชื่อสาขา
        } else if ($nTypeGroupReport == '02') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptAgnCode');  // รหัสตัวแทนขาย
            $tRptTypeGrpName    = language('report/report/report', 'tRptAgnName');  //ชื่อตัวแทนขาย
        } else if ($nTypeGroupReport == '03') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptShopCode');  //รหัสร้านค้า
            $tRptTypeGrpName    = language('report/report/report', 'tRptShopName');  //ชื่อร้านค้า
        } else if ($nTypeGroupReport == '04') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptProductCode'); //รหัสสินค้า
            $tRptTypeGrpName    = language('report/report/report', 'tRptProductName');  //ชื่อสินค้า
        } else if ($nTypeGroupReport == '05') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRPtPdtTypeCode');  // รหัสประเภทสินค้า
            $tRptTypeGrpName    = language('report/report/report', 'tRPtPdtTypeName');  // ชื่อประเภทสินค้า
        } else if ($nTypeGroupReport == '06') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptPdtGrpCode'); //รหัสกลุ่มสินค้า
            $tRptTypeGrpName    = language('report/report/report', 'tRptPdtGrpName');  //ชื่อกลุ่มสินค้า
        } else if ($nTypeGroupReport == '07') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptPdtBrandCode'); // รหัสยี่ห้อ
            $tRptTypeGrpName    = language('report/report/report', 'tRptPdtBrandName');  //ชื่อยี่ห้อ
        } else if ($nTypeGroupReport == '08') {
            $tRptTypeGrpCode    = language('report/report/report', 'tRptPdtModelCode'); // รหัสรุ่น
            $tRptTypeGrpName    = language('report/report/report', 'tRptPdtModelName');  //ชื่อรุ่น
        }


        $aCells = [
            WriterEntityFactory::createCell($tRptTypeGrpCode),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($tRptTypeGrpName),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtTypeSaleLY')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtTypeSaleTY')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptCompareLY')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtTypeSaleLY')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtTypeSaleTY')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptCompareLY')),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aCells = [
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptQty')),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPerCen')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptQty')),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPerCen')),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);



        $aDataReportParams = [
            'nPerPage' => 999999999999,
            'nPage' => 1,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aRptFilter' => $this->aRptFilter,
        ];


        $aDataReport = $this->mRptCompareSaleByPdtType->FSaMGetDataReport($aDataReportParams);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                $values = [
                    WriterEntityFactory::createCell($aValue['FTRptGrpCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTRptGrpName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyYTD_LY'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyYTD'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyCmp'])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyPercenCmp'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtYTD_LY'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtYTD'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtCmp'])),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtPercenCmp'])),
                ];

                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);


                if (($nKey + 1) == FCNnHSizeOf($aDataReport['aRptData'])) { //SumFooter

                    $values = [
                        WriterEntityFactory::createCell($this->aText['tRptTaxSalePosTotalSub']),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyYTD_LY_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyYTD_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyCmp_Footer'])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptQtyPercenCmp_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtYTD_LY_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtYTD_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtCmp_Footer'])),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCRptAmtPercenCmp_Footer'])),
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
     * Creator: 30/09/2020 Sooksanti
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

        if (!empty($this->aRptFilter['tGroupReport']) && !empty($this->aRptFilter['tGroupReport'])) {
            $tRptFilterTo = $this->aText['tRptGroupRpt'] . ' ' . language('report/report/report', 'tRptGroupRpt' . $this->aRptFilter['tGroupReport']);
            $tRptTextLeftRightFilter = $tRptFilterTo;

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
            ];
        }
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
                WriterEntityFactory::createCell($this->aText['tRptDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
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
            WriterEntityFactory::createCell($this->aText['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $this->aText['tTimePrint'] . ' ' . date('H:i:s')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
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

        // กลุ่มรายงาน
        if (!empty($this->aRptFilter['tGroupReport']) && !empty($this->aRptFilter['tGroupReport'])) {
            $tRptFilterTo = $this->aText['tRptGroupRpt'] . ' ' . language('report/report/report', 'tRptGroupRpt' . $this->aRptFilter['tGroupReport']);
            $tRptTextLeftRightFilter = $tRptFilterTo;
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

        //Fillter สินค้า
        if ($this->aRptFilter['tGroupReport']  == '04') {
            if ((isset($this->aRptFilter['tPdtCodeFrom']) && !empty($this->aRptFilter['tPdtCodeFrom'])) && (isset($this->aRptFilter['tPdtCodeTo']) && !empty($this->aRptFilter['tPdtCodeTo']))) {
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tPdtCodeFrom'] . ' : ' . $this->aRptFilter['tPdtNameFrom'] . ' ' . $this->aText['tPdtCodeTo'] . ' : ' . $this->aRptFilter['tPdtNameTo']),
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
        }

        //Fillter ประเภทสินค้า
        if ($this->aRptFilter['tGroupReport']  == '05') {
            if ((isset($this->aRptFilter['tPdtTypeCodeFrom']) && !empty($this->aRptFilter['tPdtTypeCodeFrom'])) && (isset($this->aRptFilter['tPdtTypeCodeTo']) && !empty($this->aRptFilter['tPdtTypeCodeTo']))) {
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tPdtTypeFrom'] . ' : ' . $this->aRptFilter['tPdtTypeNameFrom'] . ' ' . $this->aText['tPdtTypeTo'] . ' : ' . $this->aRptFilter['tPdtTypeNameTo']),
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
        }

        //Fillter กลุ่มสินค้า
        if ($this->aRptFilter['tGroupReport']  == '06') {
            if ((isset($this->aRptFilter['tPdtGrpCodeFrom']) && !empty($this->aRptFilter['tPdtGrpCodeFrom'])) && (isset($this->aRptFilter['tPdtGrpCodeTo']) && !empty($this->aRptFilter['tPdtGrpCodeTo']))) {
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tPdtGrpFrom'] . ' : ' . $this->aRptFilter['tPdtGrpNameFrom'] . ' ' . $this->aText['tPdtGrpTo'] . ' : ' . $this->aRptFilter['tPdtGrpNameTo']),
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
        }

        //Fillter ยี่ห้อ
        if ($this->aRptFilter['tGroupReport']  == '07') {
            if ((isset($this->aRptFilter['tPdtBrandCodeFrom']) && !empty($this->aRptFilter['tPdtBrandCodeFrom'])) && (isset($this->aRptFilter['tPdtBrandCodeTo']) && !empty($this->aRptFilter['tPdtBrandCodeTo']))) {
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptBrandFrom'] . ' : ' . $this->aRptFilter['tPdtBrandNameFrom'] . ' ' . $this->aText['tRptBrandTo'] . ' : ' . $this->aRptFilter['tPdtBrandNameTo']),
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
        }

        //Fillter ยี่รุ่น
        if ($this->aRptFilter['tGroupReport']  == '08') {
            if ((isset($this->aRptFilter['tPdtModelCodeFrom']) && !empty($this->aRptFilter['tPdtModelCodeFrom'])) && (isset($this->aRptFilter['tPdtModelCodeTo']) && !empty($this->aRptFilter['tPdtModelCodeTo']))) {
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptModelFrom'] . ' : ' . $this->aRptFilter['tPdtModelNameFrom'] . ' ' . $this->aText['tRptModelTo'] . ' : ' . $this->aRptFilter['tPdtModelNameTo']),
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
        }


        return $aMulltiRow;
    }


    function FSvCDSHSALViewReportCompareSaleByPdtType($ptCode = NULL)
    {
        //เก็บค่า เอาไป WHERE


        if ($ptCode == 'defult') {
            $tWhereSPC = "";
        } else if ($ptCode != '' || $ptCode != null) {
            $tWhereSPC = "IN ('" . str_replace('nbsp', "','", $ptCode);
            $tWhereSPC = substr($tWhereSPC, 0, -2) . ')';
        } else {
            $tWhereSPC = "";
        }

        $aTextLang    = [
            // Lang Title Panel
            'tDSHSALTitleMenu'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTitleMenu'),
            'tDSHSALDateDataFrom'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateDataFrom'),
            'tDSHSALDateDataTo'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateDataTo'),
            'tDSHSALBillQty'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillQty'),
            'tDSHSALBillTotalAll'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillTotalAll'),
            'tDSHSALTotalSaleByPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPayment'),
            'tDSHSALValueOfInventories'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALValueOfInventories'),
            'tDSHSALNewProductTopTen'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALNewProductTopTen'),
            'tDSHSALTotalSaleByPdtGrp'      => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtGrp'),
            'tDSHSALTotalSaleByPdtType'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtType'),
            'tDSHSALBestSaleProductTopTen'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTen'),
            'tDSHSALTotalByBranch'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalByBranch'),
            'tDSHSALBestSaleProductTopTenByValue'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTenByValue'),
            // Lang Data
            'tDSHSALSaleBill'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleBill'),
            'tDSHSALRefundBill'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALRefundBill'),
            'tDSHSALTotalBill'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalBill'),
            'tDSHSALTotalSale'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSale'),
            'tDSHSALTotalRefund'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalRefund'),
            'tDSHSALTotalGrand'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalGrand'),
            // Label Chart
            'tDSHSALXsdNet'                 => language('sale/dashboardsale/dashboardsale', 'tDSHSALXsdNet'),
            'tDSHSALStkQty'                 => language('sale/dashboardsale/dashboardsale', 'tDSHSALStkQty'),
            // Lang Not Found Data
            'tDSHSALNotFoundTopTenNewPdt'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALNotFoundTopTenNewPdt'),
            // Lang Modal Title
            'tDSHSALModalTitleFilter'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalTitleFilter'),
            'tDSHSALModalBtnCancel'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnCancel'),
            'tDSHSALModalBtnSave'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnSave'),
            // Form Input Filter
            'tDSHSALModalAppType'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType'),
            'tDSHSALModalAppType1'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType1'),
            'tDSHSALModalAppType2'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType2'),
            'tDSHSALModalAppType3'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType3'),
            'tDSHSALModalBranch'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBranch'),
            'tDSHSALModalMerchant'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalMerchant'),
            'tDSHSALModalShop'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalShop'),
            'tDSHSALModalPos'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPos'),
            'tDSHSALModalProduct'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalProduct'),
            'tDSHSALModalStatusCst'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst'),
            'tDSHSALModalStatusCst1'        => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst1'),
            'tDSHSALModalStatusCst2'        => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst2'),
            'tDSHSALModalStatusPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment'),
            'tDSHSALModalStatusPayment1'    => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment1'),
            'tDSHSALModalStatusPayment2'    => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment2'),
            'tDSHSALModalStatusAll'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusAll'),
            'tDSHSALModalRecive'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalRecive'),
            'tDSHSALModalPdtGrp'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPdtGrp'),
            'tDSHSALModalPdtPty'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPdtPty'),
            'tDSHSALModalWah'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalWah'),
            'tDSHSALModalTopLimit'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalTopLimit'),

            'tDSHSALDataDiff'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALDataDiff'),
            'tDSHSALOverLapZero'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALOverLapZero'),

            'tRptGrpBranch'     => language('report/report/report', 'tRptGrpBranch'),
            'tRptGrpAgency'     => language('report/report/report', 'tRptGrpAgency'),
            'tRptGrpShop'       => language('report/report/report', 'tRptGrpShop'),
            'tRptProduct'       => language('report/report/report', 'tRptProduct'),
            'tRptGrpPdtType'    => language('report/report/report', 'tRptGrpPdtType'),
            'tRptGrpPdtGroup'   => language('report/report/report', 'tRptGrpPdtGroup'),
            'tRptGrpPdtBrand'   => language('report/report/report', 'tRptGrpPdtBrand'),
            'tRptGrpPdtModel'   => language('report/report/report', 'tRptGrpPdtModel'),
            'tRptGrpPdtSpl'     => language('report/report/report', 'tRptGrpPdtSpl'),


            'tDSHSALSaleCompareLastYear'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareLastYear'),
            'tDSHSALSaleCompareThisYear'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareThisYear'),

            'tDSHSALSaleCompareAmount'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareAmount'),
            'tDSHSALSaleCompareQTY'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareQTY'),

        ];



        $tFileTotalSaleByPdtGrp = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->session->userdata("tSesUserCode")  . "\\db_reportcomparesalebypdttype_tmp.txt";
        // $aDataTotalSaleByPdtGrp = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtGrp($aDataWhere);
        $aDataReportParams = [
            'nPerPage'  => $this->nPerPage,
            'nPage'     => $this->nPage,
            'tCompName' => $this->tCompName,
            // 'tRptCode'  => $this->tRptCode,
            'tRptCode'  => '001001035',
            'aRptFilter' => $this->aRptFilter,
            'tUsrSessionID' => $this->tUserSessionID,
            'tCode' =>  $tWhereSPC
        ];






        $aDataTotalSaleByPdtGrp = $this->mRptCompareSaleByPdtType->FSaMGetDataReport2($aDataReportParams);
        // print_r($aDataTotalSaleByPdtGrp['aRptData']);  die();
        // print_r(json_encode($aDataTotalSaleByPdtGrp['aRptData'])); die();
        $oFileTotalSaleByPdtGrp = fopen($tFileTotalSaleByPdtGrp, 'w');
        rewind($oFileTotalSaleByPdtGrp);
        fwrite($oFileTotalSaleByPdtGrp, json_encode($aDataTotalSaleByPdtGrp['aRptData']));
        fclose($oFileTotalSaleByPdtGrp);


        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->session->userdata("tSesUserCode") . "\\db_reportcomparesalebypdttype_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTRptGrpName" => "N/A", "FCRptAmtYTD_LY" => "0", "FCRptAmtYTD" => "0", "FTRptGrp" => ""));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        // print_r($aInfoDataReder);

        require_once APPPATH . 'modules\sale\datasources\chartreportcomparesalebypdttype\rChartReportCompareSaleByPdtType.php';
        $oChartTotalSaleByPdtGrp    = new rChartReportCompareSaleByPdtType(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $aTextLang
        ));
        $oChartTotalSaleByPdtGrp->run();
        $tHtmlViewChart     = $oChartTotalSaleByPdtGrp->render('wChartReportCompareSaleByPdtType', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    function FSvCDSHSALViewReportCompareSaleByPdtTypeQTY($ptCode = NULL)
    {
        //เก็บค่า เอาไป WHERE
        if ($ptCode == 'defult') {
            $tWhereSPC = "";
        } else if ($ptCode != '' || $ptCode != null) {
            $tWhereSPC = "IN ('" . str_replace('nbsp', "','", $ptCode);
            $tWhereSPC = substr($tWhereSPC, 0, -2) . ')';
        } else {
            $tWhereSPC = "";
        }

        $aTextLang    = [
            // Lang Title Panel
            'tDSHSALTitleMenu'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTitleMenu'),
            'tDSHSALDateDataFrom'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateDataFrom'),
            'tDSHSALDateDataTo'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateDataTo'),
            'tDSHSALBillQty'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillQty'),
            'tDSHSALBillTotalAll'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillTotalAll'),
            'tDSHSALTotalSaleByPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPayment'),
            'tDSHSALValueOfInventories'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALValueOfInventories'),
            'tDSHSALNewProductTopTen'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALNewProductTopTen'),
            'tDSHSALTotalSaleByPdtGrp'      => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtGrp'),
            'tDSHSALTotalSaleByPdtType'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtType'),
            'tDSHSALBestSaleProductTopTen'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTen'),
            'tDSHSALTotalByBranch'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalByBranch'),
            'tDSHSALBestSaleProductTopTenByValue'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTenByValue'),
            // Lang Data
            'tDSHSALSaleBill'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleBill'),
            'tDSHSALRefundBill'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALRefundBill'),
            'tDSHSALTotalBill'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalBill'),
            'tDSHSALTotalSale'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSale'),
            'tDSHSALTotalRefund'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalRefund'),
            'tDSHSALTotalGrand'             => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalGrand'),
            // Label Chart
            'tDSHSALXsdNet'                 => language('sale/dashboardsale/dashboardsale', 'tDSHSALXsdNet'),
            'tDSHSALStkQty'                 => language('sale/dashboardsale/dashboardsale', 'tDSHSALStkQty'),
            // Lang Not Found Data
            'tDSHSALNotFoundTopTenNewPdt'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALNotFoundTopTenNewPdt'),
            // Lang Modal Title
            'tDSHSALModalTitleFilter'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalTitleFilter'),
            'tDSHSALModalBtnCancel'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnCancel'),
            'tDSHSALModalBtnSave'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnSave'),
            // Form Input Filter
            'tDSHSALModalAppType'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType'),
            'tDSHSALModalAppType1'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType1'),
            'tDSHSALModalAppType2'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType2'),
            'tDSHSALModalAppType3'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAppType3'),
            'tDSHSALModalBranch'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBranch'),
            'tDSHSALModalMerchant'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalMerchant'),
            'tDSHSALModalShop'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalShop'),
            'tDSHSALModalPos'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPos'),
            'tDSHSALModalProduct'           => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalProduct'),
            'tDSHSALModalStatusCst'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst'),
            'tDSHSALModalStatusCst1'        => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst1'),
            'tDSHSALModalStatusCst2'        => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusCst2'),
            'tDSHSALModalStatusPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment'),
            'tDSHSALModalStatusPayment1'    => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment1'),
            'tDSHSALModalStatusPayment2'    => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusPayment2'),
            'tDSHSALModalStatusAll'         => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalStatusAll'),
            'tDSHSALModalRecive'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalRecive'),
            'tDSHSALModalPdtGrp'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPdtGrp'),
            'tDSHSALModalPdtPty'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPdtPty'),
            'tDSHSALModalWah'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalWah'),
            'tDSHSALModalTopLimit'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalTopLimit'),

            'tDSHSALDataDiff'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALDataDiff'),
            'tDSHSALOverLapZero'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALOverLapZero'),

            'tRptGrpBranch'     => language('report/report/report', 'tRptGrpBranch'),
            'tRptGrpAgency'     => language('report/report/report', 'tRptGrpAgency'),
            'tRptGrpShop'       => language('report/report/report', 'tRptGrpShop'),
            'tRptProduct'       => language('report/report/report', 'tRptProduct'),
            'tRptGrpPdtType'    => language('report/report/report', 'tRptGrpPdtType'),
            'tRptGrpPdtGroup'   => language('report/report/report', 'tRptGrpPdtGroup'),
            'tRptGrpPdtBrand'   => language('report/report/report', 'tRptGrpPdtBrand'),
            'tRptGrpPdtModel'   => language('report/report/report', 'tRptGrpPdtModel'),
            'tRptGrpPdtSpl'     => language('report/report/report', 'tRptGrpPdtSpl'),

            'tDSHSALSaleCompareLastYear'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareLastYear'),
            'tDSHSALSaleCompareThisYear'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareThisYear'),
            'tDSHSALSaleCompareAmount'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareAmount'),
            'tDSHSALSaleCompareQTY'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareQTY'),
        ];




        $tFileTotalSaleByPdtGrp = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->session->userdata("tSesUserCode")  . "\\db_reportcomparesalebypdttypeqty_tmp.txt";
        // $aDataTotalSaleByPdtGrp = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtGrp($aDataWhere);

        $aDataReportParams = [
            'nPerPage'  => $this->nPerPage,
            'nPage'     => $this->nPage,
            'tCompName' => $this->tCompName,
            // 'tRptCode'  => $this->tRptCode,
            'tRptCode'  => '001001035',
            'aRptFilter' => $this->aRptFilter,
            'tUsrSessionID' => $this->tUserSessionID,
            'tCode' =>  $tWhereSPC
        ];
        // print_r($aDataReportParams);
        // exit;


        $aDataTotalSaleByPdtGrp2 = $this->mRptCompareSaleByPdtType->FSaMGetDataReport2($aDataReportParams);
        $oFileTotalSaleByPdtGrp = fopen($tFileTotalSaleByPdtGrp, 'w');
        rewind($oFileTotalSaleByPdtGrp);
        fwrite($oFileTotalSaleByPdtGrp, json_encode($aDataTotalSaleByPdtGrp2['aRptData']));
        fclose($oFileTotalSaleByPdtGrp);


        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->session->userdata("tSesUserCode") . "\\db_reportcomparesalebypdttypeqty_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (count($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTRptGrpName" => "N/A", "FCRptQtyYTD_LY" => "0", "FCRptQtyYTD" => "0", "FTRptGrp" => ""));
        } else {
            $aInfoDataReder = $aDataFiles;
        }


        require_once APPPATH . 'modules\sale\datasources\chartreportcomparesalebypdttypeqty\rChartReportCompareSaleByPdtTypeQTY.php';
        $oChartTotalSaleByPdtGrp    = new rChartReportCompareSaleByPdtTypeQTY(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $aTextLang
        ));
        $oChartTotalSaleByPdtGrp->run();
        $tHtmlViewChart     = $oChartTotalSaleByPdtGrp->render('wChartReportCompareSaleByPdtTypeQTY', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }
}
