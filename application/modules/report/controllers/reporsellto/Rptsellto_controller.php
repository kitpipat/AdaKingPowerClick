<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

date_default_timezone_set("Asia/Bangkok");

include APPPATH . 'libraries/spout-3.1.0/src/Spout/Autoloader/autoload.php';

use Box\Spout\Writer\Common\Creator\WriterEntityFactory;
use Box\Spout\Common\Entity\Row;
use Box\Spout\Common\Entity\Style\Border;
use Box\Spout\Writer\Common\Creator\Style\BorderBuilder;
use Box\Spout\Common\Entity\Style\Color;
use Box\Spout\Writer\Common\Creator\Style\StyleBuilder;
use Box\Spout\Common\Entity\Style\CellAlignment;


class Rptsellto_controller extends MX_Controller
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
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reporsellto/Rptsellto_model');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init()
    {
        $this->aText = [
            // Title
              'tTitleReport' => language('report/report/report', 'tTitleReportsellto'),
              'tDatePrint' => language('report/report/report', 'tRptTaxSalePosDatePrint'),
              'tTimePrint' => language('report/report/report', 'tRptTaxSalePosTimePrint'),
              'tRptDate' => language('report/report/report', 'tRptDate'),
              
              'tRptTaxSalePosNoData' =>"ไม่มีข้อมูล",
              'tPdtnu'=> language('report/report/report', 'tPdtnu'),
              'tPdtCode'=> language('report/report/report', 'tPdtCode'),
              'tPdtName'=> language('report/report/report', 'tPdtName'),
              'tPgpChainName'=> language('report/report/report', 'tPgpChainName'),
              'tPtyName'=>language('report/report/report', 'tPtyName'),
              'tPdtSaleType'=> language('report/report/report', 'tPdtSaleType'),
              'tBarCode'=> language('report/report/report', 'tBarCode'),
              'tPunCode'=> language('report/report/report', 'tPunCode'),
              'tPunName'=> language('report/report/report', 'tPunName'),
              'tPdtUnitFact'=> language('report/report/report', 'tPdtUnitFact'),
              'tPdtPriceRET'=> language('report/report/report', 'tPdtPriceRET'),
              'tPdtCostInPerUnit'=> language('report/report/report', 'tPdtCostInPerUnit'),
              'tPdtCostInTotal'=> language('report/report/report', 'tPdtCostInTotal'),
              'tPgdPriceRetTotal'=> language('report/report/report', 'tPgdPriceRetTotal'),
              // Filter Heard Report
              'tRptBchFrom' => language('report/report/report', 'tRptBchFrom'),
              'tRptBchTo' => language('report/report/report', 'tRptBchTo'),
              'tRptShopFrom' => language('report/report/report', 'tRptShopFrom'),
              'tRptShopTo' => language('report/report/report', 'tRptShopTo'),
              'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
              'tRptDateTo' => language('report/report/report', 'tRptDateTo'),

            // Address Lang
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
            'tRptTel' => language('report/report/report', 'tRptAddrTel'),
            'tRptFaxNo' => language('report/report/report', 'tRptAddrFax'),
            // Table Label

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
            'tRptPdtType1' => language('report/report/report', 'tRptPdtType1'),
            'tRptPdtType2' => language('report/report/report', 'tRptPdtType2'),
            'tRptPdtType3' => language('report/report/report', 'tRptPdtType3'),
            'tRptPdtType4' => language('report/report/report', 'tRptPdtType4'),
            'tRptPdtType6' => language('report/report/report', 'tRptPdtType6'),
            'tRptBrandFrom'      => language('report/report/report', 'tRptBrandFrom'),
            'tRptBrandTo'        => language('report/report/report', 'tRptBrandTo'),
            'tRptModelFrom'      => language('report/report/report', 'tRptModelFrom'),
            'tRptModelTo'        => language('report/report/report', 'tRptModelTo'),

            'tRptPdtMoving1'        => language('report/report/report', 'tRptPdtMoving1'),
            'tRptPdtMoving2'        => language('report/report/report', 'tRptPdtMoving2'),
            'tRptTitlePdtMoving'        => language('report/report/report', 'tRptTitlePdtMoving'),
            'tRptStaVat'        => language('report/report/report', 'tRptStaVat'),
            'tRptStaVa1'        => language('report/report/report', 'tRptStaVa1'),
            'tRptStaVa2'        => language('report/report/report', 'tRptStaVa2'),
            'tFTFhnRefCode' => language('report/report/report','tFTFhnRefCode'),
            'tFTPdtCode' => language('report/report/report','tFTPdtCode'),
            'tFTBarCode' => language('report/report/report','tFTBarCode'),
            'tFTPdtName' => language('report/report/report','tFTPdtName'),
            'tFTClrName' => language('report/report/report','tFTClrName'),
            'tFTPbnName' => language('report/report/report','tFTPbnName'),
            'tFTDepName' => language('report/report/report','tFTDepName'),
            'tFTClsName' => language('report/report/report','tFTClsName'),
            'tFTSclName' => language('report/report/report','tFTSclName'),
            'tFTPgpName' => language('report/report/report','tFTPgpName'),
            'tFTCmlName' => language('report/report/report','tFTCmlName'),
            'tFCPgdPriceRet' => language('report/report/report','tFCPgdPriceRet'),
            'tFDFhnStart' => language('report/report/report','tFDFhnStart'),
            'tFTFhnModNo' => language('report/report/report','tFTFhnModNo'),
            'tFTFabName' => language('report/report/report','tFTFabName'),
            'tFTFhnGender' => language('report/report/report','tFTFhnGender'),
            'tFTPmoName' => language('report/report/report','tFTPmoName'),
            'tFTSeaName' => language('report/report/report','tFTSeaName'),
            'tFTPunName' => language('report/report/report','tFTPunName'),
            'tFTPszName' => language('report/report/report','tFTPszName'),
            'tFTClrRmk' => language('report/report/report','tFTClrRmk'),
            'tFCFhnCostStd' => language('report/report/report','tFCFhnCostStd'),
            'tFCFhnCostOth' => language('report/report/report','tFCFhnCostOth'),
            'tFCStfQtyEnd' => language('report/report/report','tFCStfQtyEnd'),
            'tFCStfQtyIN' => language('report/report/report','tFCStfQtyIN'),
            'tFCStfInRet' => language('report/report/report','tFCStfInRet'),
            'tFCStfQtyEndIn' => language('report/report/report','tFCStfQtyEndIn'),
            'tFCStfEndInRet' => language('report/report/report','tFCStfEndInRet'),
            'tFCStfQtySale' => language('report/report/report','tFCStfQtySale'),
            'tFCStfGrossSales' => language('report/report/report','tFCStfGrossSales'),
            'tFCStfNetSale' => language('report/report/report','tFCStfNetSale'),
            'tFCStfOnHandQty' => language('report/report/report','tFCStfOnHandQty'),
            'tFCStfOnHandRetValue' => language('report/report/report','tFCStfOnHandRetValue'),
            'tFCStfPfmPeriod' => language('report/report/report','tFCStfPfmPeriod'),
            'tFCStfPfmOverAll' => language('report/report/report','tFCStfPfmOverAll'),
            'tPdtRefFrom' => language('report/report/report', 'tPdtRefFrom'),
            'tPdtRefTo' => language('report/report/report', 'tPdtRefTo'),
            'tReportSellToImp' => language('report/report/report', 'tReportSellToImp'),
            'tReportSellToExp' => language('report/report/report', 'tReportSellToExp'),
            'tReportSellToA' => language('report/report/report', 'tReportSellToA'),
            'tReportSellToB' => language('report/report/report', 'tReportSellToB'),
            'tReportSellTol' => language('report/report/report', 'tReportSellTol'),
            'tReportSellToC' => language('report/report/report', 'tReportSellToC'),
            'tReportSellToD' => language('report/report/report', 'tReportSellToD'),
            'tReportSellToE' => language('report/report/report', 'tReportSellToE'),
            'tReportSellToF' => language('report/report/report', 'tReportSellToF'),
            'tReportSellToG' => language('report/report/report', 'tReportSellToG'),
            'tReportSellToH' => language('report/report/report', 'tReportSellToH'),
            'tReportSellToI' => language('report/report/report', 'tReportSellToI'),
            'tReportSellToJ' => language('report/report/report', 'tReportSellToJ'),
            'tReportSellToK' => language('report/report/report', 'tReportSellToK'),
            'tReportSellTol' => language('report/report/report', 'tReportSellTol'),
            'tReportSellToO' => language('report/report/report', 'tReportSellToO'),
            

            'tReportSellTolSex1' => language('report/report/report', 'tReportSellTolSex1'),
            'tReportSellTolSex2' => language('report/report/report', 'tReportSellTolSex2'),
            'tReportSellTolSex3' => language('report/report/report', 'tReportSellTolSex3'),

            'tSeaCodeFrom' => language('report/report/report', 'tSeaCodeFrom'),
            'tSeaCodeTo' => language('report/report/report', 'tSeaCodeTo'),
            'tFabCodeFrom' => language('report/report/report', 'tFabCodeFrom'),
            'tFabCodeTo' => language('report/report/report', 'tFabCodeTo'),
            'tClrCodeFrom' => language('report/report/report', 'tClrCodeFrom'),
            'tClrCodeTo' => language('report/report/report', 'tClrCodeTo'),
            'tPszCodeFrom' => language('report/report/report', 'tPszCodeFrom'),
            'tPszCodeTo' => language('report/report/report', 'tPszCodeTo'),

            
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
            'tAgnCode'          => !empty($this->input->post('oetSpcAgncyCode')) ? $this->input->post('oetSpcAgncyCode') : '',
            // สาขา
            'tBchCodeFrom' => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom' => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo' => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo' => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect' => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect' => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll' => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // Filter Shop (ร้านค้า)
            'tShpCodeFrom'      => (empty($this->input->post('oetRptShpCodeFrom'))) ? '' : $this->input->post('oetRptShpCodeFrom'),
            'tShpNameFrom'      => (empty($this->input->post('oetRptShpNameFrom'))) ? '' : $this->input->post('oetRptShpNameFrom'),
            'tShpCodeTo'        => (empty($this->input->post('oetRptShpCodeTo'))) ? '' : $this->input->post('oetRptShpCodeTo'),
            'tShpNameTo'        => (empty($this->input->post('oetRptShpNameTo'))) ? '' : $this->input->post('oetRptShpNameTo'),
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // กลุ่มธุรกิจ
            'tRptMerCodeFrom' => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tRptMerNameFrom' => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tRptMerCodeTo' => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tRptMerNameTo' => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            'tMerCodeSelect' => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect' => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll' => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Merchant Filter
            'bFilterMerStaAll'  => (!empty($this->input->post('oetDSHSALFilterMerStaAll')) && ($this->input->post('oetDSHSALFilterMerStaAll') == 1)) ? true : false,
            'tFilterMerCode'    => (!empty($this->input->post('oetDSHSALFilterMerCode'))) ? $this->input->post('oetDSHSALFilterMerCode') : "",
            'tFilterMerName'    => (!empty($this->input->post('oetDSHSALFilterMerName'))) ? $this->input->post('oetDSHSALFilterMerName') : "",

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

            'tPdtStaActive' => !empty($this->input->post('ocmRptPdtStaActive')) ? $this->input->post('ocmRptPdtStaActive') : "",

            //ภาษีขาย
            'tPdtRptPdtType' => !empty($this->input->post('ocmRptPdtType')) ? $this->input->post('ocmRptPdtType') : "",
            'tPdtRptStaVat' => !empty($this->input->post('ocmRptStaVat')) ? $this->input->post('ocmRptStaVat') : "",
            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'      => !empty($this->input->post('oetRptOneDateFrom')) ? $this->input->post('oetRptOneDateFrom') : "",
     
            // ฤดูกาล
            'tSeaCodeFrom'      => !empty($this->input->post('oetRptPdtSeaCodeFrom')) ? $this->input->post('oetRptPdtSeaCodeFrom') : "",
            'tSeaNameFrom'      => !empty($this->input->post('oetRptPdtSeaNameFrom')) ? $this->input->post('oetRptPdtSeaNameFrom') : "",
            'tSeaCodeTo'        => !empty($this->input->post('oetRptPdtSeaCodeTo')) ? $this->input->post('oetRptPdtSeaCodeTo') : "",
            'tSeaNameTo'        => !empty($this->input->post('oetRptPdtSeaNameTo')) ? $this->input->post('oetRptPdtSeaNameTo') : "",

            // เนื้อผ้า
            'tFabCodeFrom'      => !empty($this->input->post('oetRptPdtFabCodeFrom')) ? $this->input->post('oetRptPdtFabCodeFrom') : "",
            'tFabNameFrom'      => !empty($this->input->post('oetRptPdtFabNameFrom')) ? $this->input->post('oetRptPdtFabNameFrom') : "",
            'tFabCodeTo'        => !empty($this->input->post('oetRptPdtFabCodeTo')) ? $this->input->post('oetRptPdtFabCodeTo') : "",
            'tFabNameTo'        => !empty($this->input->post('oetRptPdtFabNameTo')) ? $this->input->post('oetRptPdtFabNameTo') : "",

            // สี
            'tClrCodeFrom'      => !empty($this->input->post('oetRptPdtClrCodeFrom')) ? $this->input->post('oetRptPdtClrCodeFrom') : "",
            'tClrNameFrom'      => !empty($this->input->post('oetRptPdtClrNameFrom')) ? $this->input->post('oetRptPdtClrNameFrom') : "",
            'tClrCodeTo'        => !empty($this->input->post('oetRptPdtClrCodeTo')) ? $this->input->post('oetRptPdtClrCodeTo') : "",
            'tClrNameTo'        => !empty($this->input->post('oetRptPdtClrNameTo')) ? $this->input->post('oetRptPdtClrNameTo') : "",

            // ไซต์
            'tPszCodeFrom'      => !empty($this->input->post('oetRptPdtPszCodeFrom')) ? $this->input->post('oetRptPdtPszCodeFrom') : "",
            'tPszNameFrom'      => !empty($this->input->post('oetRptPdtPszNameFrom')) ? $this->input->post('oetRptPdtPszNameFrom') : "",
            'tPszCodeTo'        => !empty($this->input->post('oetRptPdtPszCodeTo')) ? $this->input->post('oetRptPdtPszCodeTo') : "",
            'tPszNameTo'        => !empty($this->input->post('oetRptPdtPszNameTo')) ? $this->input->post('oetRptPdtPszNameTo') : "",     

            'tRefCodeFrom'      => !empty($this->input->post('oetRptPdtRefCodeFrom')) ? $this->input->post('oetRptPdtRefCodeFrom') : "",
            'tRefCodeTo'        => !empty($this->input->post('oetRptPdtRefCodeTo')) ? $this->input->post('oetRptPdtRefCodeTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index()
    {

        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {

            // Execute Stored Procedure
            $this->Rptsellto_model->FSnMExecStoreReport($this->aRptFilter);
            // Count Rows
            $aCountRowParams = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tSessionID' => $this->tUserSessionID,
                'aDataFilter' => $this->aRptFilter
            ];
            $this->nRows = $this->Rptsellto_model->FSnMCountRowInTemp($aCountRowParams);

            // Report Type
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    // $this->FSoCChkDataReportInTableTemp();
                    // break;
                    $this->FSvCCallRptRenderExcel($this->aRptFilter);
                    break;
                case 'pdf':
                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * LastUpdate: -
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint()
    {
        try {
            /** =========== Begin Get Data =================================== */
            // ดึงข้อมูลจากฐานข้อมูล Temp
            $aDataReportParams = [
                'nPerPage' => $this->nPerPage,
                'nPage' => $this->nPage,
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aDataFilter' => $this->aRptFilter
            ];
            $aDataReport = $this->Rptsellto_model->FSaMGetDataReport($aDataReportParams);
            /** =========== End Get Data ===================================== */
            /** =========== Begin Render View ================================ */
            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo' => $this->aCompanyInfo,
                'aDataReport' => $aDataReport,
                'aDataTextRef' => $this->aText,
                'aDataFilter' => $this->aRptFilter
            ];
            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsellto/reportsellto/', 'wRptSellToHtml', $aDataViewRptParams);

            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport' => $this->aText['tTitleReport'],
                'tRptTypeExport' => $this->tRptExportType,
                'tRptCode' => $this->tRptCode,
                'tRptRoute' => $this->tRptRoute,
                'tViewRenderKool' => $tRptView,
                'aDataFilter' => $this->aRptFilter,
                'aDataReport' => [
                    'raItems' => $aDataReport['aRptData'],
                    'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode' => '1',
                    'rtDesc' => 'success'
                ]
            ];

            $this->load->view('report/report/wReportViewer', $aDataViewerParams);
            /** =========== End Render View ================================== */
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
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
            'tUserSession' => $this->tUserSessionID,
            'tCompName' => $this->tCompName,
            'tUserCode' => $this->tUserLoginCode,
            'tRptCode' => $this->tRptCode,
            'nPage' => $this->nPage,
            'nRow' => $this->nPerPage,
            'nPerPage' => $this->nPerPage,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter' => $aDataFilter
        );

        // Get Data ReportFSaMGetDataReport
        $aDataReport = $this->Rptsellto_model->FSaMGetDataReport($aDataWhere, $aDataFilter);
        // print_r($aDataReport);
        // exit;

        // GetDataSumFootReport
        // $aDataSumFoot = $this->Rptsellto_model->FSaMGetDataSumFootReport($aDataWhere, $aDataFilter);


        // Load View Advance Table
        $aDataViewRptParams = [
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo' => $this->aCompanyInfo,
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataFilter' => $aDataFilter
        ];
        $tViewRenderKool = JCNoHLoadViewAdvanceTable('report/datasources/reportsellto/reportsellto/', 'wRptSellToHtml', $aDataViewRptParams);


        // Data Viewer Center Report
        $aDataView = [
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter' => $aDataFilter,
            'aDataReport' => [
                'raItems' => $aDataReport['aRptData'],
                'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success',
            ]
        ];

        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/09/2020 Piya
     * LastUpdate: -
     * Return: Object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp()
    {
        try {
            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tSessionID' => $this->tUserSessionID,
                'aDataFilter' => $this->aRptFilter,
            ];

            $nDataCountPage = $this->Rptsellto_model->FSnMCountRowInTemp($aDataCountData);

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
     * Creator: 15/09/2020 Piya
     * LastUpdate: -
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile()
    {

    }

       /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 30/07/2020 Nattakit
     * LastUpdate:
     * Return: file
     * ReturnType: file
     */
    public function  FSvCCallRptRenderExcel()
    {
        $tFileName = $this->aText['tTitleReport'] . '_' . date('YmdHis') . '.xlsx';
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
            ->setFontBold()
            ->build();

        $oStyle = (new StyleBuilder())
        ->setCellAlignment(CellAlignment::RIGHT)
        ->build();
        $aCells = [
          WriterEntityFactory::createCell($this->aText['tFTFhnRefCode']),
          WriterEntityFactory::createCell($this->aText['tFTPdtCode']),
          WriterEntityFactory::createCell($this->aText['tFTBarCode']),
          WriterEntityFactory::createCell($this->aText['tFTPdtName']),
          WriterEntityFactory::createCell($this->aText['tFTClrName']),
          WriterEntityFactory::createCell($this->aText['tFTPbnName']),
          WriterEntityFactory::createCell($this->aText['tFTDepName']),
          WriterEntityFactory::createCell($this->aText['tFTClsName']),
          WriterEntityFactory::createCell($this->aText['tFTSclName']),
          WriterEntityFactory::createCell($this->aText['tFTPgpName']),
          WriterEntityFactory::createCell($this->aText['tFTCmlName']),
          WriterEntityFactory::createCell($this->aText['tFCPgdPriceRet'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFDFhnStart']),
          WriterEntityFactory::createCell($this->aText['tFTFhnModNo']),
          WriterEntityFactory::createCell($this->aText['tFTFabName']),
          WriterEntityFactory::createCell($this->aText['tFTFhnGender']),
          WriterEntityFactory::createCell($this->aText['tFTPmoName']),
          WriterEntityFactory::createCell($this->aText['tFTSeaName']),
          WriterEntityFactory::createCell($this->aText['tFTPunName']),
          WriterEntityFactory::createCell($this->aText['tFTPszName']),
          WriterEntityFactory::createCell($this->aText['tFTClrRmk']),
          WriterEntityFactory::createCell($this->aText['tFCFhnCostStd'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCFhnCostOth'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfQtyEnd'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfQtyIN'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfInRet'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfQtyEndIn'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfEndInRet'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfQtySale'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfGrossSales'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfNetSale'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfOnHandQty'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfOnHandRetValue'],$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfPfmPeriod'].' (%)',$oStyle),
          WriterEntityFactory::createCell($this->aText['tFCStfPfmOverAll'].' (%)',$oStyle),
        ];


        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        //  ===========================================================================================



        $aDataReportParams = [
            'nPerPage'      => 999999999999,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter'   => $this->aRptFilter
        ];

        //Get Data
        $aDataReport = $this->Rptsellto_model->FSaMGetDataReport($aDataReportParams);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        $nOptDecimalShow = FCNxHGetOptionDecimalShow();
        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                $tFTFhnRefCode = $aValue["FTFhnRefCode"];
                $tFTPdtCode = $aValue["FTPdtCode"];
                $tFTBarCode = $aValue["FTBarCode"];
                $tFTPdtName = $aValue["FTPdtName"];
                $tFTClrName = $aValue["FTClrName"];
                $tFTPbnName = $aValue["FTPbnName"];
                $tFTDepName = $aValue["FTDepName"];
                $tFTClsName = $aValue["FTClsName"];
                $tFTSclName = $aValue["FTSclName"];
                $tFTPgpName = $aValue["FTPgpName"];
                $tFTCmlName = $aValue["FTCmlName"];
                $tFCPgdPriceRet = number_format($aValue["FCPgdPriceRet"],$nOptDecimalShow);
                $aFDFhnStart = explode(" ",$aValue["FDFhnStart"]);
                $tFDFhnStart = $aFDFhnStart[0];
                $tFTFhnModNo = $aValue["FTFhnModNo"];
                $tFTFabName = $aValue["FTFabName"];
                $tFTFhnGender = $aValue["FTFhnGender"];
                $tFTFhnGender =  $this->aText['tReportSellTolSex'.$aValue["FTFhnGender"]];
                $tFTPmoName = $aValue["FTPmoName"];
                $tFTSeaName = $aValue["FTSeaName"];
                $tFTPunName = $aValue["FTPunName"];
                $tFTPszName = $aValue["FTPszName"];
                $tFTClrRmk = $aValue["FTClrRmk"];
                $tFCFhnCostStd = number_format($aValue["FCFhnCostStd"],$nOptDecimalShow);
                $tFCFhnCostOth = number_format($aValue["FCFhnCostOth"],$nOptDecimalShow);
                $tFCStfQtyEnd = number_format($aValue["FCStfQtyEnd"],$nOptDecimalShow);
                $tFCStfQtyIN = number_format($aValue["FCStfQtyIN"],$nOptDecimalShow);
                $tFCStfInRet = number_format($aValue["FCStfInRet"],$nOptDecimalShow);
                $tFCStfQtyEndIn = number_format($aValue["FCStfQtyEndIn"],$nOptDecimalShow);
                $tFCStfEndInRet = number_format($aValue["FCStfEndInRet"],$nOptDecimalShow);
                $tFCStfQtySale = number_format($aValue["FCStfQtySale"],$nOptDecimalShow);
                $tFCStfGrossSales = number_format($aValue["FCStfGrossSales"],$nOptDecimalShow);
                $tFCStfNetSale = number_format($aValue["FCStfNetSale"],$nOptDecimalShow);
                $tFCStfOnHandQty = number_format($aValue["FCStfOnHandQty"],$nOptDecimalShow);
                $tFCStfOnHandRetValue = number_format($aValue["FCStfOnHandRetValue"],$nOptDecimalShow);
                $tFCStfPfmPeriod = number_format($aValue["FCStfPfmPeriod"],$nOptDecimalShow);
                $tFCStfPfmOverAll = number_format($aValue["FCStfPfmOverAll"],$nOptDecimalShow);

                $values = [
                  WriterEntityFactory::createCell($tFTFhnRefCode),
                  WriterEntityFactory::createCell($tFTPdtCode),
                  WriterEntityFactory::createCell($tFTBarCode),
                  WriterEntityFactory::createCell($tFTPdtName),
                  WriterEntityFactory::createCell($tFTClrName),
                  WriterEntityFactory::createCell($tFTPbnName),
                  WriterEntityFactory::createCell($tFTDepName),
                  WriterEntityFactory::createCell($tFTClsName),
                  WriterEntityFactory::createCell($tFTSclName),
                  WriterEntityFactory::createCell($tFTPgpName),
                  WriterEntityFactory::createCell($tFTCmlName),
                  WriterEntityFactory::createCell($tFCPgdPriceRet,$oStyle),
                  WriterEntityFactory::createCell($tFDFhnStart),
                  WriterEntityFactory::createCell($tFTFhnModNo),
                  WriterEntityFactory::createCell($tFTFabName),
                  WriterEntityFactory::createCell($tFTFhnGender),
                  WriterEntityFactory::createCell($tFTPmoName),
                  WriterEntityFactory::createCell($tFTSeaName),
                  WriterEntityFactory::createCell($tFTPunName),
                  WriterEntityFactory::createCell($tFTPszName),
                  WriterEntityFactory::createCell($tFTClrRmk),
                  WriterEntityFactory::createCell($tFCFhnCostStd,$oStyle),
                  WriterEntityFactory::createCell($tFCFhnCostOth,$oStyle),
                  WriterEntityFactory::createCell($tFCStfQtyEnd,$oStyle),
                  WriterEntityFactory::createCell($tFCStfQtyIN,$oStyle),
                  WriterEntityFactory::createCell($tFCStfInRet,$oStyle),
                  WriterEntityFactory::createCell($tFCStfQtyEndIn,$oStyle),
                  WriterEntityFactory::createCell($tFCStfEndInRet,$oStyle),
                  WriterEntityFactory::createCell($tFCStfQtySale,$oStyle),
                  WriterEntityFactory::createCell($tFCStfGrossSales,$oStyle),
                  WriterEntityFactory::createCell($tFCStfNetSale,$oStyle),
                  WriterEntityFactory::createCell($tFCStfOnHandQty,$oStyle),
                  WriterEntityFactory::createCell($tFCStfOnHandRetValue,$oStyle),
                  WriterEntityFactory::createCell($tFCStfPfmPeriod,$oStyle),
                  WriterEntityFactory::createCell($tFCStfPfmOverAll,$oStyle)
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
     * Creator: 30/07/2020 Nattakit
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
            WriterEntityFactory::createCell($this->aText['tTitleReport']),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
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
            WriterEntityFactory::createCell($this->aText['tRptTel'] . ' ' . $tFTCmpTel . ' '.$this->aText['tRptFaxNo'] . ' ' . $tRptFaxNo),
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
            WriterEntityFactory::createCell($this->aText['tRptAddrBranch'] . ' ' . $tFTBchName),
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
            WriterEntityFactory::createCell($this->aText['tRPCTaxNo'] . ' : ' . $tFTAddTaxNo),
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


        if ((isset($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateFrom']))) {
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
                WriterEntityFactory::createCell($this->aText['tRptDate'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom']))),
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
            WriterEntityFactory::createCell($this->aText['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $this->aText['tTimePrint'] . ' ' . date('H:i:s')),
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
    public function FSoCCallRptRenderFooterExcel()
    {

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
        $aMulltiRow[] = WriterEntityFactory::createRow($aCells, $oStyleFilter);


        if (isset($this->aRptFilter['tBchCodeSelect']) && !empty($this->aRptFilter['tBchCodeSelect'])) {
            $tBchSelect =  ($this->aRptFilter['bBchStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tBchNameSelect'];
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptBchFrom'] . ' : ' . $tBchSelect),
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
                WriterEntityFactory::createCell($this->aText['tRptCstFrom'] . ' : ' . $this->aRptFilter['tCstCodeFrom'] . ' ' . $this->aText['tRptCstTo'] . ' : ' . $this->aRptFilter['tCstCodeTo']),
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
        // ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
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
        // ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
        if ((isset($this->aRptFilter['tRefCodeFrom']) && !empty($this->aRptFilter['tRefCodeFrom'])) && (isset($this->aRptFilter['tRefCodeTo']) && !empty($this->aRptFilter['tRefCodeTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPdtRefFrom'] . ' : ' . $this->aRptFilter['tRefCodeFrom'] . ' ' . $this->aText['tPdtRefTo'] . ' : ' . $this->aRptFilter['tRefCodeTo']),
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
        // ฟิวเตอร์ข้อมูล ฤดูกาล =========================================== -->
        if ((isset($this->aRptFilter['tSeaCodeFrom']) && !empty($this->aRptFilter['tSeaCodeFrom'])) && (isset($this->aRptFilter['tSeaCodeTo']) && !empty($this->aRptFilter['tSeaCodeTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tSeaCodeFrom'] . ' : ' . $this->aRptFilter['tSeaNameFrom'] . ' ' . $this->aText['tSeaCodeTo'] . ' : ' . $this->aRptFilter['tSeaNameTo']),
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
        // ฟิวเตอร์ข้อมูล เนื้อผ้า =========================================== -->
        if ((isset($this->aRptFilter['tFabCodeFrom']) && !empty($this->aRptFilter['tFabCodeFrom'])) && (isset($this->aRptFilter['tFabCodeTo']) && !empty($this->aRptFilter['tFabCodeTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tFabCodeFrom'] . ' : ' . $this->aRptFilter['tFabNameFrom'] . ' ' . $this->aText['tFabCodeTo'] . ' : ' . $this->aRptFilter['tFabNameTo']),
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
        // ฟิวเตอร์ข้อมูล สี =========================================== -->
        if ((isset($this->aRptFilter['tClrCodeFrom']) && !empty($this->aRptFilter['tClrCodeFrom'])) && (isset($this->aRptFilter['tClrCodeTo']) && !empty($this->aRptFilter['tClrCodeTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tClrCodeFrom'] . ' : ' . $this->aRptFilter['tClrNameFrom'] . ' ' . $this->aText['tClrCodeTo'] . ' : ' . $this->aRptFilter['tClrNameTo']),
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
        // ฟิวเตอร์ข้อมูล ไซต์ =========================================== -->
        if ((isset($this->aRptFilter['tPszCodeFrom']) && !empty($this->aRptFilter['tPszCodeFrom'])) && (isset($this->aRptFilter['tPszCodeTo']) && !empty($this->aRptFilter['tPszCodeTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tPszCodeFrom'] . ' : ' . $this->aRptFilter['tPszNameFrom'] . ' ' . $this->aText['tPszCodeTo'] . ' : ' . $this->aRptFilter['tPszNameTo']),
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
        // ฟิวเตอร์ข้อมูล กลุ่มสินค้า =========================================== -->
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

        // ฟิวเตอร์ข้อมูล ประเภทสินค้า =========================================== -->
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

        // ฟิวเตอร์ข้อมูล ยี่ห้อ =========================================== -->
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

        // ฟิวเตอร์ข้อมูล รุ่น =========================================== -->
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

        // ฟิวเตอร์ข้อมูล สถานะเคลื่อนไหว =========================================== -->
        // if ((isset($this->aRptFilter['tPdtStaActive']) && !empty($this->aRptFilter['tPdtStaActive'])) && (isset($this->aRptFilter['tPdtStaActive']) && !empty($this->aRptFilter['tPdtStaActive']))) {
        //   $aPdtStaActive = array(
        //     '1' => $aDataTextRef['tRptPdtMoving1'],
        //     '2' => $aDataTextRef['tRptPdtMoving2']
        //   );
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptTitlePdtMoving'] . ' : ' . $aPdtStaActive[$this->aRptFilter['tPdtStaActive']] ),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }
        //
        //
        // // ฟิวเตอร์ข้อมูล ใช้ราคาขาย =========================================== -->
        // if ((isset($this->aRptFilter['tPdtRptPdtType']) && !empty($this->aRptFilter['tPdtRptPdtType'])) && (isset($this->aRptFilter['tPdtRptPdtType']) && !empty($this->aRptFilter['tPdtRptPdtType']))) {
        //   $aPdtRptPdtType = array(
        //     '1' => $aDataTextRef['tRptPdtType1'],
        //     '2' => $aDataTextRef['tRptPdtType2'],
        //     '3' => $aDataTextRef['tRptPdtType3'],
        //     '4' => $aDataTextRef['tRptPdtType4'],
        //     '6' => $aDataTextRef['tRptPdtType6']
        //   );
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tPdtSaleType'] . ' : ' . $aPdtRptPdtType[$this->aRptFilter['tPdtRptPdtType']] ),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }
        //
        // // ฟิวเตอร์ข้อมูล ภาษี =========================================== -->
        // if ((isset($this->aRptFilter['tPdtRptStaVat']) && !empty($this->aRptFilter['tPdtRptStaVat'])) && (isset($this->aRptFilter['tPdtRptStaVat']) && !empty($this->aRptFilter['tPdtRptStaVat']))) {
        //   $aPdtRptStaVat = array(
        //    '1' => $aDataTextRef['tRptStaVa1'],
        //    '2' => $aDataTextRef['tRptStaVa2']
        //  );
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptStaVat'] . ' : ' . $aPdtRptStaVat[$this->aRptFilter['tPdtRptStaVat']] ),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //         WriterEntityFactory::createCell(NULL),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }
        return $aMulltiRow;
    }
}
