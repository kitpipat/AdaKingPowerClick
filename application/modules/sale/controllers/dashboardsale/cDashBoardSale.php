<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cDashBoardSale extends MX_Controller
{

    /**
     * ภาษาที่เกี่ยวข้อง
     * @var array
     */
    public $aTextLang   = [];

    /**
     * Role User
     * @var array
     */
    public $aAlwEvent   = [];

    /**
     * Option Decimal Show
     * @var int
     */
    public $nOptDecimalShow = 0;

    /**
     * Option Decimal Save
     * @var int
     */
    public $nOptDecimalSave = 0;

    /**
     * Status Select Lang In DB
     * @var int
     */
    public $nLangEdit   = 1;

    /**
     * Text Html Button Save
     * @var string
     */
    public $tSesUserCode    = '';

    /**
     * Text Html Button Save
     * @var string
     */
    public $tSesUserName    = '';

    /**
     * Text Html Button Save
     * @var array
     */
    public $aDataWhere  = [];

    public function __construct()
    {
        $this->FSxCInitParams();
        $this->load->model('sale/dashboardsale/mDashBoardSale');
        $this->load->model('report/reportsale/mRptCompareSaleByPdtType');

        if (!is_dir('./application/modules/sale/assets/koolreport')) {
            mkdir('./application/modules/sale/assets/koolreport');
        }
        // เช็ค Folder Systemtemp
        if (!is_dir('./application/modules/sale/assets/sysdshtemp')) {
            mkdir('./application/modules/sale/assets/sysdshtemp');
        }
        parent::__construct();
    }

    // Functionality: เซทค่าพารามิเตอร์
    // Parameters: Ajax and Function Parameter
    // Creator: 14/01/2020 wasin(Yoshi)
    // Return: None
    // ReturnType: none
    private function FSxCInitParams()
    {
        // Text Lang
        $this->aTextLang    = [
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

            'tDSHSALSalesComparisonChartbyYTD'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesComparisonChartbyYTD'),
            'tDSHSALSalesComparisonChartbyMTD'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesComparisonChartbyMTD'),
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

            'tDSHSALDataDiff'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALDataDiff'),
            'tDSHSALOverLapZero'            => language('sale/dashboardsale/dashboardsale', 'tDSHSALOverLapZero'),

            'tDSHRptCompareSaleByPdt'       => language('sale/dashboardsale/dashboardsale', 'tDSHRptCompareSaleByPdt'),
            'tDSHRptCompareSaleByPdtAmt'    => language('sale/dashboardsale/dashboardsale', 'tDSHRptCompareSaleByPdtAmt'),


            'tDSHSALSaleComparebyAmountY'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleComparebyAmountY'),
            'tDSHSALSaleComparebyQTYY'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleComparebyQTYY'),
            'tDSHSALSaleComparebyAmountM'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleComparebyAmountM'),
            'tDSHSALSaleComparebyQTYM'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleComparebyQTYM'),

            'tDSHSALSaleCompareLastYear'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareLastYear'),
            'tDSHSALSaleCompareThisYear'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareThisYear'),






            'tDSHSALDataDiff'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALDataDiff'),
            'tDSHSALOverLapZero'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALOverLapZero'),
            'tDSHSALModalAgn'               => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalAgn'),


            //Group Report 
            'tRptGrpBranch'     => language('report/report/report', 'tRptGrpBranch'),
            'tRptGrpAgency'     => language('report/report/report', 'tRptGrpAgency'),
            'tRptGrpShop'       => language('report/report/report', 'tRptGrpShop'),
            'tRptGrpPdtType'    => language('report/report/report', 'tRptGrpPdtType'),
            'tRptGrpPdtGroup'   => language('report/report/report', 'tRptGrpPdtGroup'),
            'tRptGrpPdtBrand'   => language('report/report/report', 'tRptGrpPdtBrand'),
            'tRptGrpPdtModel'   => language('report/report/report', 'tRptGrpPdtModel'),
            'tRptGrpPdtSpl'     => language('report/report/report', 'tRptGrpPdtSpl'),
            'tRptPdtTypegraph'      => language('report/report/report', 'tRptPdtTypegraph'),

            'tDSHSALSaleCompareAmount'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareAmount'),
            'tDSHSALSaleCompareQTY'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALSaleCompareQTY'),

        ];
        $this->aAlwEvent        = FCNaHCheckAlwFunc('dashboardsale/0/0');
        $this->nOptDecimalShow  = FCNxHGetOptionDecimalShow();
        $this->nOptDecimalSave  = FCNxHGetOptionDecimalSave();
        $this->nLangEdit        = $this->session->userdata("tLangEdit");
        $this->tSesUserCode     = $this->session->userdata('tSesUserCode');
        $this->tSesUserName     = $this->session->userdata('tSesUsername');

        $this->aDataWhere       = [
            'nLngID'            => $this->nLangEdit,
            'tDateDataForm'     => (!empty($this->input->post('ptDateDataForm'))) ? $this->input->post('ptDateDataForm') : '',
            'tDateDataTo'       => (!empty($this->input->post('ptDateDataTo'))) ? $this->input->post('ptDateDataTo')     : '',
            // Sale Type Key
            'tDSHSALTypeKey'    => (!empty($this->input->post('ohdDSHSALFilterKey'))) ? $this->input->post('ohdDSHSALFilterKey') : '',
            // Branch Filter
            'bFilterBchStaAll'  => (!empty($this->input->post('oetDSHSALFilterBchStaAll')) && ($this->input->post('oetDSHSALFilterBchStaAll') == 1)) ? true : false,
            'tFilterBchCode'    => (!empty($this->input->post('oetDSHSALFilterBchCode'))) ? $this->input->post('oetDSHSALFilterBchCode') : "",
            'tFilterBchName'    => (!empty($this->input->post('oetDSHSALFilterBchName'))) ? $this->input->post('oetDSHSALFilterBchName') : "",
            // Merchant Filter
            'bFilterMerStaAll'  => (!empty($this->input->post('oetDSHSALFilterMerStaAll')) && ($this->input->post('oetDSHSALFilterMerStaAll') == 1)) ? true : false,
            'tFilterMerCode'    => (!empty($this->input->post('oetDSHSALFilterMerCode'))) ? $this->input->post('oetDSHSALFilterMerCode') : "",
            'tFilterMerName'    => (!empty($this->input->post('oetDSHSALFilterMerName'))) ? $this->input->post('oetDSHSALFilterMerName') : "",
            // Shop Filter
            'bFilterShpStaAll'  => (!empty($this->input->post('oetDSHSALFilterShpStaAll')) && ($this->input->post('oetDSHSALFilterShpStaAll') == 1)) ? true : false,
            'tFilterShpCode'    => (!empty($this->input->post('oetDSHSALFilterShpCode'))) ? $this->input->post('oetDSHSALFilterShpCode') : "",
            'tFilterShpName'    => (!empty($this->input->post('oetDSHSALFilterShpName'))) ? $this->input->post('oetDSHSALFilterShpName') : "",
            // Pos Filter
            'bFilterPosStaAll'  => (!empty($this->input->post('oetDSHSALFilterPosStaAll')) && ($this->input->post('oetDSHSALFilterPosStaAll') == 1)) ? true : false,
            'tFilterPosCode'    => (!empty($this->input->post('oetDSHSALFilterPosCode'))) ? $this->input->post('oetDSHSALFilterPosCode') : "",
            'tFilterPosName'    => (!empty($this->input->post('oetDSHSALFilterPosName'))) ? $this->input->post('oetDSHSALFilterPosName') : "",
            // Warehouse Filter
            'bFilterWahStaAll'  => (!empty($this->input->post('oetDSHSALFilterWahStaAll')) && ($this->input->post('oetDSHSALFilterWahStaAll') == 1)) ? true : false,
            'tFilterWahCode'    => (!empty($this->input->post('oetDSHSALFilterWahCode'))) ? $this->input->post('oetDSHSALFilterWahCode') : "",
            'tFilterWahName'    => (!empty($this->input->post('oetDSHSALFilterWahName'))) ? $this->input->post('oetDSHSALFilterWahName') : "",
            // Product Filter
            'bFilterPdtStaAll'  => (!empty($this->input->post('oetDSHSALFilterPdtStaAll')) && ($this->input->post('oetDSHSALFilterPdtStaAll') == 1)) ? true : false,
            'tFilterPdtCode'    => (!empty($this->input->post('oetDSHSALFilterPdtCode'))) ? $this->input->post('oetDSHSALFilterPdtCode') : "",
            'tFilterPdtName'    => (!empty($this->input->post('oetDSHSALFilterPdtName'))) ? $this->input->post('oetDSHSALFilterPdtName') : "",
            // Recive Filter
            'bFilterRcvStaAll'  => (!empty($this->input->post('oetDSHSALFilterRcvStaAll')) && ($this->input->post('oetDSHSALFilterRcvStaAll') == 1)) ? true : false,
            'tFilterRcvCode'    => (!empty($this->input->post('oetDSHSALFilterRcvCode'))) ? $this->input->post('oetDSHSALFilterRcvCode') : "",
            'tFilterRcvName'    => (!empty($this->input->post('oetDSHSALFilterRcvName'))) ? $this->input->post('oetDSHSALFilterRcvName') : "",
            // Product Group Filter
            'bFilterPgpStaAll'  => (!empty($this->input->post('oetDSHSALFilterPgpStaAll')) && ($this->input->post('oetDSHSALFilterPgpStaAll') == 1)) ? true : false,
            'tFilterPgpCode'    => (!empty($this->input->post('oetDSHSALFilterPgpCode'))) ? $this->input->post('oetDSHSALFilterPgpCode') : "",
            'tFilterPgpName'    => (!empty($this->input->post('oetDSHSALFilterPgpName'))) ? $this->input->post('oetDSHSALFilterPgpName') : "",
            // Product Type Filter
            'bFilterPtyStaAll'  => (!empty($this->input->post('oetDSHSALFilterPtyStaAll')) && ($this->input->post('oetDSHSALFilterPtyStaAll') == 1)) ? true : false,
            'tFilterPtyCode'    => (!empty($this->input->post('oetDSHSALFilterPtyCode'))) ? $this->input->post('oetDSHSALFilterPtyCode') : "",
            'tFilterPtyName'    => (!empty($this->input->post('oetDSHSALFilterPtyName'))) ? $this->input->post('oetDSHSALFilterPtyName') : "",
            // Top Limit Select
            'tFilterTopLimit'   => (!empty($this->input->post('ocmDSHSALFilterTopLimit'))) ? $this->input->post('ocmDSHSALFilterTopLimit')   : 5,
            // Status Customer
            'tFilterStaCst'     => (!empty($this->input->post('orbDSHSALStaCst'))) ? $this->input->post('orbDSHSALStaCst')   : '',
            // Status Payment
            'tFilterStaPayment' => (!empty($this->input->post('orbDSHSALStaPayment'))) ? $this->input->post('orbDSHSALStaPayment')   : '',
            // App Type
            // 'aStaAppType'       => (!empty($this->input->post('ocbDSHSALAppType'))) ? $this->input->post('ocbDSHSALAppType') : explode(",", '1,2,3'),
            'aStaAppType'       => explode(",", $this->input->post('ptAlwDashBoard')),
            // Agen Filter
            'bFilterAgnStaAll'  => (!empty($this->input->post('oetDSHSALFilterAgnStaAll')) && ($this->input->post('oetDSHSALFilterAgnStaAll') == 1)) ? true : false,
            'tFilterAgnCode'    => (!empty($this->input->post('oetDSHSALFilterAgnCode'))) ? $this->input->post('oetDSHSALFilterAgnCode') : "",
            'tFilterAgnName'    => (!empty($this->input->post('oetDSHSALFilterAgnName'))) ? $this->input->post('oetDSHSALFilterAgnName') : "",
            // Group Report
            'tFilterGroupReport' => (!empty($this->input->post('ocmGroupReport'))) ? $this->input->post('ocmGroupReport')   : '',
            // Product From To
            'tFilterProductFTFromCode'    => (!empty($this->input->post('oetDSHSALFilterProductFTCodeFrom'))) ? $this->input->post('oetDSHSALFilterProductFTCodeFrom') : "",
            'tFilterProductFTFromName'    => (!empty($this->input->post('oetDSHSALFilterProductFTNameFrom'))) ? $this->input->post('oetDSHSALFilterProductFTNameFrom') : "",
            'tFilterProductFTToCode'    => (!empty($this->input->post('oetDSHSALFilterProductFTCodeTo'))) ? $this->input->post('oetDSHSALFilterProductFTCodeTo') : "",
            'tFilterProductFTToName'    => (!empty($this->input->post('oetDSHSALFilterProductFTNameTo'))) ? $this->input->post('oetDSHSALFilterProductFTNameTo') : "",
            // Type Product From To
            'tFilterTypeProductFTFromCode'    => (!empty($this->input->post('oetDSHSALFilterTypeProductFTCodeFrom'))) ? $this->input->post('oetDSHSALFilterTypeProductFTCodeFrom') : "",
            'tFilterTypeProductFTFromName'    => (!empty($this->input->post('oetDSHSALFilterTypeProductFTNameFrom'))) ? $this->input->post('oetDSHSALFilterTypeProductFTNameFrom') : "",
            'tFilterTypeProductFTToCode'    => (!empty($this->input->post('oetDSHSALFilterTypeProductFTCodeTo'))) ? $this->input->post('oetDSHSALFilterTypeProductFTCodeTo') : "",
            'tFilterTypeProductFTToName'    => (!empty($this->input->post('oetDSHSALFilterTypeProductFTNameTo'))) ? $this->input->post('oetDSHSALFilterTypeProductFTNameTo') : "",
            // Group Product From To
            'tFilterGroupProductFTFromCode'    => (!empty($this->input->post('oetDSHSALFilterGroupProductFTCodeFrom'))) ? $this->input->post('oetDSHSALFilterGroupProductFTCodeFrom') : "",
            'tFilterGroupProductFTFromName'    => (!empty($this->input->post('oetDSHSALFilterGroupProductFTNameFrom'))) ? $this->input->post('oetDSHSALFilterGroupProductFTNameFrom') : "",
            'tFilterGroupProductFTToCode'    => (!empty($this->input->post('oetDSHSALFilterGroupProductFTCodeTo'))) ? $this->input->post('oetDSHSALFilterGroupProductFTCodeTo') : "",
            'tFilterGroupProductFTToName'    => (!empty($this->input->post('oetDSHSALFilterGroupProductFTNameTo'))) ? $this->input->post('oetDSHSALFilterGroupProductFTNameTo') : "",
            // Brand From To
            'tFilterBrandFTFromCode'    => (!empty($this->input->post('oetDSHSALFilterBrandCodeFrom'))) ? $this->input->post('oetDSHSALFilterBrandCodeFrom') : "",
            'tFilterBrandFTFromName'    => (!empty($this->input->post('oetDSHSALFilterBrandNameFrom'))) ? $this->input->post('oetDSHSALFilterBrandNameFrom') : "",
            'tFilterBrandFTToCode'    => (!empty($this->input->post('oetDSHSALFilterBrandCodeTo'))) ? $this->input->post('oetDSHSALFilterBrandCodeTo') : "",
            'tFilterBrandFTToName'    => (!empty($this->input->post('oetDSHSALFilterBrandNameTo'))) ? $this->input->post('oetDSHSALFilterBrandNameTo') : "",
            // Model Product From To
            'tFilterModelFTFromCode'    => (!empty($this->input->post('oetDSHSALFilterModelCodeFrom'))) ? $this->input->post('oetDSHSALFilterModelCodeFrom') : "",
            'tFilterModelFTFromName'    => (!empty($this->input->post('oetDSHSALFilterModelNameFrom'))) ? $this->input->post('oetDSHSALFilterModelNameFrom') : "",
            'tFilterModelFTToCode'    => (!empty($this->input->post('oetDSHSALFilterModelCodeTo'))) ? $this->input->post('oetDSHSALFilterModelCodeTo') : "",
            'tFilterModelFTToName'    => (!empty($this->input->post('oetDSHSALFilterModelNameTo'))) ? $this->input->post('oetDSHSALFilterModelNameTo') : "",
        ];
    }

    // Functionality: Index DashBoard
    // Parameters: Ajax and Function Parameter
    // Creator: 14/01/2020 wasin(Yoshi)
    // Return: None
    // ReturnType: none
    public function index($nDSHSALBrowseType, $tDSHSALBrowseOption)
    {
        $aDataConfigView    = [
            'nDSHSALBrowseType'     => $nDSHSALBrowseType,
            'tDSHSALBrowseOption'   => $tDSHSALBrowseOption,
            'aAlwEvent'             => $this->aAlwEvent,
            'aTextLang'             => $this->aTextLang
        ];


        //Set Cookie กำหนดสิทธิ์ใช้มองเห็นหน้า DashboardSale 
        $aSetCookieRole = [];
        $tValueCookie = $this->input->cookie("Cookie_SKC" . $this->session->userdata("tSesUserCode"), true);
        $aValCheck = json_decode($tValueCookie);
        // print_r($aValCheck); die();
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB01", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);


        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[0] = 0;
        } else {
            if (isset($aValCheck[0]) ? $aValCheck[0] != 0 : 1) {
                $aSetCookieRole[0] = 1;
            } else {
                $aSetCookieRole[0] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB02", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[1] = 0;
        } else {
            if (isset($aValCheck[1]) ? $aValCheck[1] != 0 : 1) {
                $aSetCookieRole[1] = 1;
            } else {
                $aSetCookieRole[1] = 0;
            }
        }
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB03", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[2] = 0;
        } else {
            if (isset($aValCheck[2]) ? $aValCheck[2] != 0 : 1) {
                $aSetCookieRole[2] = 1;
            } else {
                $aSetCookieRole[2] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB04", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[3] = 0;
        } else {
            if (isset($aValCheck[3]) ? $aValCheck[3] != 0 : 1) {
                $aSetCookieRole[3] = 1;
            } else {
                $aSetCookieRole[3] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB05", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[4] = 0;
        } else {
            if (isset($aValCheck[4]) ? $aValCheck[4] != 0 : 1) {
                $aSetCookieRole[4] = 1;
            } else {
                $aSetCookieRole[4] = 0;
            }
        }
        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB06", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[5] = 0;
        } else {
            if (isset($aValCheck[5]) ? $aValCheck[5] != 0 : 1) {
                $aSetCookieRole[5] = 1;
            } else {
                $aSetCookieRole[5] = 0;
            }
        }

        // $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB07", "tGhdApp" => "SB"];
        // $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        // if ($bChkRolePanelLeft1 != 1) {
        //     $aSetCookieRole[6] = 0;
        // } else {
        //     if (isset($aValCheck[6]) ? $aValCheck[6] != 0 : 1) {
        //         $aSetCookieRole[6] = 1;
        //     } else {
        //         $aSetCookieRole[6] = 0;
        //     }
        // }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB08", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[6] = 0;
        } else {
            if (isset($aValCheck[6]) ? $aValCheck[6] != 0 : 1) {
                $aSetCookieRole[6] = 1;
            } else {
                $aSetCookieRole[6] = 0;
            }
        }

        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB09", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[7] = 0;
        } else {
            if (isset($aValCheck[7]) ? $aValCheck[7] != 0 : 1) {
                $aSetCookieRole[7] = 1;
            } else {
                $aSetCookieRole[7] = 0;
            }
        }


        $aIsAlwFuncInRoleParams = ["tUfrGrpRef" => "053", "tUfrRef" => "DSB10", "tGhdApp" => "SB"];
        $bChkRolePanelLeft1 = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
        if ($bChkRolePanelLeft1 != 1) {
            $aSetCookieRole[8] = 0;
        } else {
            if (isset($aValCheck[8]) ? $aValCheck[8] != 0 : 1) {
                $aSetCookieRole[8] = 1;
            } else {
                $aSetCookieRole[8] = 0;
            }
        }

        $aCookie = array(
            'name'   => "Cookie_SKC" . $this->session->userdata("tSesUserCode"),
            'value'  => json_encode($aSetCookieRole),
            'expire' =>  31556926,
        );

        $this->input->set_cookie($aCookie);




        $this->load->view('sale/dashboardsale/wDashBoardSale', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น ดึงข้อมูลจากฐานข้อมูล เมื่อแรกเข้าสู่หน้า
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALMainPage()
    {
        // เช็ค Folder Systemtemp User Code
        if (!is_dir('./application/modules/sale/assets/sysdshtemp/' . $this->tSesUserCode)) {
            mkdir('./application/modules/sale/assets/sysdshtemp/' . $this->tSesUserCode);
        }

        // จำนวนบิลขาย
        $tFilesCountBillAll = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_countbillall_tmp.txt";
        $aDataCountBillAll  = $this->mDashBoardSale->FSaNDSHSALCountBillAll($this->aDataWhere);
        $oFileCountBillAll  = fopen($tFilesCountBillAll, 'w');
        rewind($oFileCountBillAll);
        fwrite($oFileCountBillAll, json_encode($aDataCountBillAll));
        fclose($oFileCountBillAll);

        // ยอดขายรวม
        $tFileTotalSaleAll  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleall_tmp.txt";
        $aDataTotalSaleAll  = $this->mDashBoardSale->FSaNDSHSALCountTotalSaleAll($this->aDataWhere);
        $oFileTotalSaleAll  = fopen($tFileTotalSaleAll, 'w');
        rewind($oFileTotalSaleAll);
        fwrite($oFileTotalSaleAll, json_encode($aDataTotalSaleAll));
        fclose($oFileTotalSaleAll);

        // ยอดขายตามการชำะเงิน
        $tFileTotalSaleByRcv    = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebyrcv_tmp.txt";
        $aDataTotalSaleByRcv    = $this->mDashBoardSale->FSaMDSHSALTotalSaleByRcv($this->aDataWhere);
        $oFileTotalSaleByRcv    = fopen($tFileTotalSaleByRcv, 'w');
        rewind($oFileTotalSaleByRcv);
        fwrite($oFileTotalSaleByRcv, json_encode($aDataTotalSaleByRcv));
        fclose($oFileTotalSaleByRcv);

        // มูลค่าสินค้าคงเหลือ
        $tFilePdtStkBal = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_pdtstkbal_tmp.txt";
        $aDataPdtStkBal = $this->mDashBoardSale->FSaMDSHSALPdtStkBal($this->aDataWhere);
        $oFilePdtStkBal = fopen($tFilePdtStkBal, 'w');
        rewind($oFilePdtStkBal);
        fwrite($oFilePdtStkBal, json_encode($aDataPdtStkBal));
        fclose($oFilePdtStkBal);

        // ยอดขายตามกลุ่มสินค้า
        $tFileTotalSaleByPdtGrp = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebypdtgrp_tmp.txt";
        $aDataTotalSaleByPdtGrp = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtGrp($this->aDataWhere);
        $oFileTotalSaleByPdtGrp = fopen($tFileTotalSaleByPdtGrp, 'w');
        rewind($oFileTotalSaleByPdtGrp);
        fwrite($oFileTotalSaleByPdtGrp, json_encode($aDataTotalSaleByPdtGrp));
        fclose($oFileTotalSaleByPdtGrp);

        // ยอดขายตามประเภทสินค้า
        $tFileTotalSaleByPdtPty = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebypdtpty_tmp.txt";
        $aDataTotalSaleByPdtPty = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtPty($this->aDataWhere);
        $oFileTotalSaelByPdtPty = fopen($tFileTotalSaleByPdtPty, 'w');
        rewind($oFileTotalSaelByPdtPty);
        fwrite($oFileTotalSaelByPdtPty, json_encode($aDataTotalSaleByPdtPty));
        fclose($oFileTotalSaelByPdtPty);

        // 10 รายการสินค้าใหม่
        $tFileTopTenNewPdt  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptennewpdt_tmp.txt";
        $aDataTopTenNewPdt  = $this->mDashBoardSale->FSaMDSHSALTopTenNewProduct($this->aDataWhere);
        $oFileTopTenNewPdt  = fopen($tFileTopTenNewPdt, 'w');
        rewind($oFileTopTenNewPdt);
        fwrite($oFileTopTenNewPdt, json_encode($aDataTopTenNewPdt));
        fclose($oFileTopTenNewPdt);

        // 10 อันดับสินค้าขายดีตามจำนวน
        $tFileTopTenBestSeller  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptenbestseller_tmp.txt";
        $aDataTopTenBestSeller  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSeller($this->aDataWhere);
        $oFileTopTenBestSeller  = fopen($tFileTopTenBestSeller, 'w');
        rewind($oFileTopTenBestSeller);
        fwrite($oFileTopTenBestSeller, json_encode($aDataTopTenBestSeller));
        fclose($oFileTopTenBestSeller);


        // 10 อันดับสินค้าขายดีตามมูลค่า
        $tFileTopTenBestSellerByValue  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptenbestsellerbyvalue_tmp.txt";
        $aDataTopTenBestSellerByValue  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSellerByValue($this->aDataWhere);
        $oFileTopTenBestSellerByValue  = fopen($tFileTopTenBestSellerByValue, 'w');
        rewind($oFileTopTenBestSellerByValue);
        fwrite($oFileTopTenBestSellerByValue, json_encode($aDataTopTenBestSellerByValue));
        fclose($oFileTopTenBestSellerByValue);



        //Report Compare Sale By Product Type 
        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost = 'Adasoft Report';

        $aDataReportParams = [
            'tCompName' => $tFullHost,
            'tRptCode'  => '001001035',
            'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
        ];

        $this->mRptCompareSaleByPdtType->FSnMExecStoreReport2($this->aDataWhere, $aDataReportParams);

        $tFileReportCompareSaleByProductType   = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_reportcomparesalebypdttype_tmp.txt";
        // $aDataReportCompareSaleByProductType  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSellerByValue($this->aDataWhere);

        $aDataReportCompareSaleByProductType = $this->mRptCompareSaleByPdtType->FSaMGetDataReport2($aDataReportParams);


        $oFileReportCompareSaleByProductType  = fopen($tFileReportCompareSaleByProductType, 'w');
        rewind($oFileReportCompareSaleByProductType);
        fwrite($oFileReportCompareSaleByProductType, json_encode($aDataReportCompareSaleByProductType));
        fclose($oFileReportCompareSaleByProductType);



        // **********************************************************************************************************************************
        // รายงานเปรียบเทียบยอดขายตามสินค้า (จำนวน)
        // Create By Witsarut 09/02/2021
        $tFileTotalRptCompareSaleByPdtQty = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtQty_tmp.txt";
        $tFileTotalRptCompareSaleByPdtAmt = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtAmt_tmp.txt";

        // $tIP = $this->input->ip_address();
        // $tFullHost = gethostbyaddr($tIP);
        $tFullHost = 'Adasoft Report';
        $this->tCompName = $tFullHost;
        $this->nLngID = FCNaHGetLangEdit();

        // Call Fillter 
        $this->aRptFilter = [
            'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
            'tCompName'     => $this->tCompName,
            'nLangID'       => $this->nLngID,
            'tRptCode'      => '001001034',

            //ยังไม่ได้มี fillter ใช้งาน
            'tTypeSelect'   => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // ตัวแทนขาย
            'tAgnCodeSelect'    => !empty($this->input->post('oetSpcAgncyCode')) ? $this->input->post('oetSpcAgncyCode') : "",
            'tAgnNameSelect'    => !empty($this->input->post('oetSpcAgncyName')) ? $this->input->post('oetSpcAgncyName') : "",

            // สาขา(Branch)
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'      => !empty($this->input->post('oetRptOneDateFrom')) ? $this->input->post('oetRptOneDateFrom') : "",

            // กลุ่มรายงาน
            'tGroupReport'      => !empty($this->input->post('ocmGroupReport')) ? $this->input->post('ocmGroupReport') : "",

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

        // // Execute Stored Procedure
        $this->mDashBoardSale->FSnMExecStoreReportCompare($this->aDataWhere, $this->aRptFilter);

        $aDataTotalRptCompareSaleByPdtQty = $this->mDashBoardSale->FSaMGetDataReportQty($this->aRptFilter);
        // รายงานเปรียบเทียบยอดขายตามสินค้า (จำนวน)
        $oFileTotalRptCompareSaleByPdtQty = fopen($tFileTotalRptCompareSaleByPdtQty, 'w');
        rewind($oFileTotalRptCompareSaleByPdtQty);
        fwrite($oFileTotalRptCompareSaleByPdtQty, json_encode($aDataTotalRptCompareSaleByPdtQty['aRptData']));
        fclose($oFileTotalRptCompareSaleByPdtQty);


        $aDataTotalRptCompareSaleByPdtAmt = $this->mDashBoardSale->FSaMGetDataReportAmt($this->aRptFilter);
        // รายงานเปรียบเทียบยอดขายตามสินค้า (Amount)
        $oFileTotalRptCompareSaleByPdtAmt = fopen($tFileTotalRptCompareSaleByPdtAmt, 'w');
        rewind($oFileTotalRptCompareSaleByPdtAmt);
        fwrite($oFileTotalRptCompareSaleByPdtAmt, json_encode($aDataTotalRptCompareSaleByPdtAmt['aRptData']));
        fclose($oFileTotalRptCompareSaleByPdtAmt);

        // **********************************************************************************************************************************


        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang,
            'aDataWhere' => $this->aDataWhere
        ];

        // ลบตัวแปรที่ใช้งานแล้ว
        unset($tFilesCountBillAll);
        unset($aDataCountBillAll);
        unset($oFileCountBillAll);

        unset($tFileTotalSaleAll);
        unset($aDataTotalSaleAll);
        unset($oFileTotalSaleAll);

        unset($tFileTotalSaleByRcv);
        unset($aDataTotalSaleByRcv);
        unset($oFileTotalSaleByRcv);

        unset($tFileTotalSaleByPdtGrp);
        unset($aDataTotalSaleByPdtGrp);
        unset($oFileTotalSaleByPdtGrp);

        unset($tFileTotalSaleByPdtPty);
        unset($aDataTotalSaleByPdtPty);
        unset($oFileTotalSaelByPdtPty);

        unset($tFileTopTenNewPdt);
        unset($aDataTopTenNewPdt);
        unset($oFileTopTenNewPdt);

        unset($tFileTopTenBestSeller);
        unset($aDataTopTenBestSeller);
        unset($oFileTopTenBestSeller);

        $this->load->view('sale/dashboardsale/wDashBoardSaleMain', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALCallModalFilter()
    {
        $aDataConfigView    = [
            'tFilterDataKey'    => $this->input->post('ptFilterDataKey'),
            'aFilterDataGrp'    => explode(",", $this->input->post('ptFilterDataGrp')),
            'aTextLang'         => $this->aTextLang
        ];

        $this->load->view('sale/dashboardsale/viewmodal/wDashBoardModalFilter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Call View Modal Filter
    // Parameters : Ajax and Function Parameter
    // Creator : 14/01/2019 wasin
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALConfirmFilter()
    {
        // Switch Case ประเภท Dash Board
        $tDSHSALTypeKey = $this->aDataWhere['tDSHSALTypeKey'];

        switch ($tDSHSALTypeKey) {
            case 'FBA': {
                    // DashBoard Filter จำนวนบิลขาย
                    $tFilesCountBillAll = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_countbillall_tmp.txt";
                    $aDataCountBillAll  = $this->mDashBoardSale->FSaNDSHSALCountBillAll($this->aDataWhere);
                    $oFileCountBillAll  = fopen($tFilesCountBillAll, 'w');
                    rewind($oFileCountBillAll);
                    fwrite($oFileCountBillAll, json_encode($aDataCountBillAll));
                    fclose($oFileCountBillAll);
                    break;
                }
            case 'FTS': {
                    // DashBoard Filter ยอดขายรวม
                    $tFileTotalSaleAll  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleall_tmp.txt";
                    $aDataTotalSaleAll  = $this->mDashBoardSale->FSaNDSHSALCountTotalSaleAll($this->aDataWhere);
                    $oFileTotalSaleAll  = fopen($tFileTotalSaleAll, 'w');
                    rewind($oFileTotalSaleAll);
                    fwrite($oFileTotalSaleAll, json_encode($aDataTotalSaleAll));
                    fclose($oFileTotalSaleAll);
                    break;
                }
            case 'FSR': {
                    // DashBoard Filter ยอดขายตามการชำระเงิน
                    $tFileTotalSaleByRcv    = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebyrcv_tmp.txt";
                    $aDataTotalSaleByRcv    = $this->mDashBoardSale->FSaMDSHSALTotalSaleByRcv($this->aDataWhere);
                    $oFileTotalSaleByRcv    = fopen($tFileTotalSaleByRcv, 'w');
                    rewind($oFileTotalSaleByRcv);
                    fwrite($oFileTotalSaleByRcv, json_encode($aDataTotalSaleByRcv));
                    fclose($oFileTotalSaleByRcv);
                    break;
                }
            case 'FSB': {
                    // DashBoard Filter มูลค่าสินค้าคงเหลือ
                    $tFilePdtStkBal = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_pdtstkbal_tmp.txt";
                    $aDataPdtStkBal = $this->mDashBoardSale->FSaMDSHSALPdtStkBal($this->aDataWhere);
                    $oFilePdtStkBal = fopen($tFilePdtStkBal, 'w');
                    rewind($oFilePdtStkBal);
                    fwrite($oFilePdtStkBal, json_encode($aDataPdtStkBal));
                    fclose($oFilePdtStkBal);
                    break;
                }
            case 'FNP': {
                    // DashBoard Filter 10 รายการสินค้าใหม่
                    $tFileTopTenNewPdt  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptennewpdt_tmp.txt";
                    $aDataTopTenNewPdt  = $this->mDashBoardSale->FSaMDSHSALTopTenNewProduct($this->aDataWhere);
                    $oFileTopTenNewPdt  = fopen($tFileTopTenNewPdt, 'w');
                    rewind($oFileTopTenNewPdt);
                    fwrite($oFileTopTenNewPdt, json_encode($aDataTopTenNewPdt));
                    fclose($oFileTopTenNewPdt);
                    break;
                }
            case 'FPG': {
                    // DashBoard Filter ยอดขายตามกลุ่มสินค้า
                    $tFileTotalSaleByPdtGrp = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebypdtgrp_tmp.txt";
                    $aDataTotalSaleByPdtGrp = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtGrp($this->aDataWhere);
                    $oFileTotalSaleByPdtGrp = fopen($tFileTotalSaleByPdtGrp, 'w');
                    rewind($oFileTotalSaleByPdtGrp);
                    fwrite($oFileTotalSaleByPdtGrp, json_encode($aDataTotalSaleByPdtGrp));
                    fclose($oFileTotalSaleByPdtGrp);
                    break;
                }
            case 'FPT': {
                    // DashBoard Filter ยอดขายตามประเภทสินค้า
                    $tFileTotalSaleByPdtPty = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebypdtpty_tmp.txt";
                    $aDataTotalSaleByPdtPty = $this->mDashBoardSale->FSaMDSHSALTotalSaleByPdtPty($this->aDataWhere);
                    $oFileTotalSaelByPdtPty = fopen($tFileTotalSaleByPdtPty, 'w');
                    rewind($oFileTotalSaelByPdtPty);
                    fwrite($oFileTotalSaelByPdtPty, json_encode($aDataTotalSaleByPdtPty));
                    fclose($oFileTotalSaelByPdtPty);
                    break;
                }
            case 'FTB': {
                    // DashBoard Filter 10 อันดับสินค้าขายดีตามจำนวน
                    $tFileTopTenBestSeller  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptenbestseller_tmp.txt";
                    $aDataTopTenBestSeller  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSeller($this->aDataWhere);
                    $oFileTopTenBestSeller  = fopen($tFileTopTenBestSeller, 'w');
                    rewind($oFileTopTenBestSeller);
                    fwrite($oFileTopTenBestSeller, json_encode($aDataTopTenBestSeller));
                    fclose($oFileTopTenBestSeller);
                    break;
                }
            case 'FTV': {
                    // DashBoard Filter 10 อันดับสินค้าขายดีตามมูลค่า
                    $tFileTopTenBestSellerByValue  = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptenbestsellerbyvalue_tmp.txt";
                    $aDataTopTenBestSellerByValue  = $this->mDashBoardSale->FSaMDSHSALTopTenBestSellerByValue($this->aDataWhere);
                    $oFileTopTenBestSellerByValue  = fopen($tFileTopTenBestSellerByValue, 'w');
                    rewind($oFileTopTenBestSellerByValue);
                    fwrite($oFileTopTenBestSellerByValue, json_encode($aDataTopTenBestSellerByValue));
                    fclose($oFileTopTenBestSellerByValue);
                    break;
                }

            case 'RCSPBT': {
                    // print_r($this->aDataWhere);
                    // die();
                    // DashBoard Filter Report Compare Sale By Product Type 
                    // $tIP = $this->input->ip_address();
                    // $tFullHost = gethostbyaddr($tIP);
                    $tFullHost = 'Adasoft Report';

                    $aDataReportParams = [
                        'tCompName' => $tFullHost,
                        'tRptCode'  => '001001035',
                        'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
                    ];

                    $this->mRptCompareSaleByPdtType->FSnMExecStoreReport2($this->aDataWhere, $aDataReportParams);

                    $tFileReportCompareSaleByProductType   = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_reportcomparesalebypdttype_tmp.txt";
                    $aDataReportCompareSaleByProductType = $this->mRptCompareSaleByPdtType->FSaMGetDataReport2($aDataReportParams);


                    $oFileReportCompareSaleByProductType  = fopen($tFileReportCompareSaleByProductType, 'w');
                    rewind($oFileReportCompareSaleByProductType);
                    fwrite($oFileReportCompareSaleByProductType, json_encode($aDataReportCompareSaleByProductType));
                    fclose($oFileReportCompareSaleByProductType);
                    break;
                }
            case 'RCSPBT2': {
                    // print_r($this->aDataWhere);
                    // die();
                    // DashBoard Filter Report Compare Sale By Product Type 
                    // $tIP = $this->input->ip_address();
                    // $tFullHost = gethostbyaddr($tIP);
                    $tFullHost = 'Adasoft Report';

                    $aDataReportParams = [
                        'tCompName' => $tFullHost,
                        'tRptCode'  => '001001035',
                        'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
                    ];

                    $this->mRptCompareSaleByPdtType->FSnMExecStoreReport2($this->aDataWhere, $aDataReportParams);

                    $tFileReportCompareSaleByProductType   = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_reportcomparesalebypdttype_tmp.txt";
                    $aDataReportCompareSaleByProductType = $this->mRptCompareSaleByPdtType->FSaMGetDataReport2($aDataReportParams);


                    $oFileReportCompareSaleByProductType  = fopen($tFileReportCompareSaleByProductType, 'w');
                    rewind($oFileReportCompareSaleByProductType);
                    fwrite($oFileReportCompareSaleByProductType, json_encode($aDataReportCompareSaleByProductType));
                    fclose($oFileReportCompareSaleByProductType);
                    break;
                }

            case 'RPTComSalePdt': {
                    // $tIP = $this->input->ip_address();
                    // $tFullHost = gethostbyaddr($tIP);

                    $tFullHost = 'Adasoft Report';
                    $this->tCompName = $tFullHost;
                    $this->nLngID = FCNaHGetLangEdit();

                    $this->aRptFilter = [
                        'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
                        'tCompName'     => $this->tCompName,
                        'nLangID'       => $this->nLngID,
                        'tRptCode'      => '001001034',
                    ];

                    // รายงานเปรียบเทียบยอดขายตามสินค้า (จำนวน)
                    $this->mDashBoardSale->FSnMExecStoreReportCompare($this->aDataWhere, $this->aRptFilter);

                    $tFileTotalRptCompareSaleByPdtAmt = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtAmt_tmp.txt";
                    $aDataTotalRptCompareSaleByPdtAmt = $this->mDashBoardSale->FSaMGetDataReportAmt($this->aRptFilter);
                    // รายงานเปรียบเทียบยอดขายตามสินค้า (Amount)
                    $oFileTotalRptCompareSaleByPdtAmt = fopen($tFileTotalRptCompareSaleByPdtAmt, 'w');
                    rewind($oFileTotalRptCompareSaleByPdtAmt);
                    fwrite($oFileTotalRptCompareSaleByPdtAmt, json_encode($aDataTotalRptCompareSaleByPdtAmt['aRptData']));
                    fclose($oFileTotalRptCompareSaleByPdtAmt);


                    // $tFileTotalRptCompareSaleByPdtQty = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtQty_tmp.txt";
                    // $aDataTotalRptCompareSaleByPdtQty = $this->mDashBoardSale->FSaMGetDataReportQty($this->aRptFilter);
                    // // รายงานเปรียบเทียบยอดขายตามสินค้า (จำนวน)
                    // $oFileTotalRptCompareSaleByPdtQty = fopen($tFileTotalRptCompareSaleByPdtQty, 'w');
                    // rewind($oFileTotalRptCompareSaleByPdtQty);
                    // fwrite($oFileTotalRptCompareSaleByPdtQty, json_encode($aDataTotalRptCompareSaleByPdtQty['aRptData']));
                    // fclose($oFileTotalRptCompareSaleByPdtQty);

                    break;
                }
                case 'RPTComSalePdt2': {
                    // $tIP = $this->input->ip_address();
                    // $tFullHost = gethostbyaddr($tIP);

                    $tFullHost = 'Adasoft Report';
                    $this->tCompName = $tFullHost;
                    $this->nLngID = FCNaHGetLangEdit();

                    $this->aRptFilter = [
                        'tUsrSessionID' => $this->session->userdata('tSesSessionID'),
                        'tCompName'     => $this->tCompName,
                        'nLangID'       => $this->nLngID,
                        'tRptCode'      => '001001034',
                    ];

                    // รายงานเปรียบเทียบยอดขายตามสินค้า (จำนวน)
                    $this->mDashBoardSale->FSnMExecStoreReportCompare($this->aDataWhere, $this->aRptFilter);

                    // $tFileTotalRptCompareSaleByPdtAmt = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtAmt_tmp.txt";
                    // $aDataTotalRptCompareSaleByPdtAmt = $this->mDashBoardSale->FSaMGetDataReportAmt($this->aRptFilter);
                    // // รายงานเปรียบเทียบยอดขายตามสินค้า (Amount)
                    // $oFileTotalRptCompareSaleByPdtAmt = fopen($tFileTotalRptCompareSaleByPdtAmt, 'w');
                    // rewind($oFileTotalRptCompareSaleByPdtAmt);
                    // fwrite($oFileTotalRptCompareSaleByPdtAmt, json_encode($aDataTotalRptCompareSaleByPdtAmt['aRptData']));
                    // fclose($oFileTotalRptCompareSaleByPdtAmt);


                    $tFileTotalRptCompareSaleByPdtQty = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtQty_tmp.txt";
                    $aDataTotalRptCompareSaleByPdtQty = $this->mDashBoardSale->FSaMGetDataReportQty($this->aRptFilter);
                    // รายงานเปรียบเทียบยอดขายตามสินค้า (จำนวน)
                    $oFileTotalRptCompareSaleByPdtQty = fopen($tFileTotalRptCompareSaleByPdtQty, 'w');
                    rewind($oFileTotalRptCompareSaleByPdtQty);
                    fwrite($oFileTotalRptCompareSaleByPdtQty, json_encode($aDataTotalRptCompareSaleByPdtQty['aRptData']));
                    fclose($oFileTotalRptCompareSaleByPdtQty);

                    break;
                }
        }
        $aDataReturn    = [
            'rtDSHSALTypeKey'   => $tDSHSALTypeKey,
            'rtCode'            => '1',
            'rtDesc'            => 'success',
        ];
        echo json_encode($aDataReturn);
    }

    // ============================================================= Call View Chart Data DashBoard Sale =============================================================

    // Functionality : ฟังก์ชั่น  Call View Data จำนวนบิลขาย,ยอดขายรวม
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSoCDSHSALViewBillAllAndTotalSale()
    {
        // Open Files Bill All
        $tFileOpenPathBillAll   = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_countbillall_tmp.txt";
        $oFilesOpenBillAll      = fopen($tFileOpenPathBillAll, 'r');
        $aDataFilesBillAll      = json_decode(fread($oFilesOpenBillAll, filesize($tFileOpenPathBillAll)), true);
        fclose($oFilesOpenBillAll);
        // Open File Total Sale
        $tFileOpenPathTotalSale = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleall_tmp.txt";
        $oFilesOpenTotalSale    = fopen($tFileOpenPathTotalSale, 'r');
        $aDataFilesTotalSale    = json_decode(fread($oFilesOpenTotalSale, filesize($tFileOpenPathTotalSale)), true);
        fclose($oFilesOpenTotalSale);
        $aDataReturn    = [
            'nOptDecimalShow'       => $this->nOptDecimalShow,
            'aDataFilesBillAll'     => $aDataFilesBillAll,
            'aDataFilesTotalSale'   => $aDataFilesTotalSale,
        ];
        unset($tFileOpenPathBillAll);
        unset($oFilesOpenBillAll);
        unset($aDataFilesBillAll);
        unset($tFileOpenPathTotalSale);
        unset($oFilesOpenTotalSale);
        unset($aDataFilesTotalSale);
        echo json_encode($aDataReturn);
        unset($aDataReturn);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale By Payment
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTotalSaleByRecive()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebyrcv_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (FCNnHSizeOf($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTRcvName" => "N/A", "FCXsdNet" => "0.01"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttotalsalebyrecive\rChartTotalSaleByRecive.php';
        $oChartTotalSaleByRecive    = new rChartTotalSaleByRecive(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartTotalSaleByRecive->run();
        $tHtmlViewChart     = $oChartTotalSaleByRecive->render('wChartTotalSaleByRecive', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale By Payment
    // Parameters : Function Parameter
    // Creator : 04/02/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewPdtStockBarlance()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_pdtstkbal_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (FCNnHSizeOf($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPdtCode" => "", "FTPdtName" => "", "FCStkQty" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\chartpdtstockbarlance\rChartPdtStockBarlance.php';
        $oChartPdtStockBarlance = new rChartPdtStockBarlance(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartPdtStockBarlance->run();
        $tHtmlViewChart     = $oChartPdtStockBarlance->render('wChartPdtStockBarlance', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }


    // Functionality : ฟังก์ชั่น  Call View Data Top 10 New Product
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTopTenNewPdt()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptennewpdt_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang,
            'aDataFiles'        => $aDataFiles
        ];
        $this->load->view('sale/dashboardsale/viewchart/wDashBoardTopTenNewPdt', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale Product Group
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTotalSaleByPdtGrp()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebypdtgrp_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (FCNnHSizeOf($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPgpChainName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttotalsalebypdtgrp\rChartTotalSaleByPdtGrp.php';
        $oChartTotalSaleByPdtGrp    = new rChartTotalSaleByPdtGrp(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartTotalSaleByPdtGrp->run();
        $tHtmlViewChart     = $oChartTotalSaleByPdtGrp->render('wChartTotalSaleByPdtGrp', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Total Sale Product Type
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTotalSaleByPdtPty()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsalebypdtpty_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (FCNnHSizeOf($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPtyName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttotalsalebypdtpty\rChartTotalSaleByPdtPty.php';
        $oChartTotalSaleByPdtPty    = new rChartTotalSaleByPdtPty(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartTotalSaleByPdtPty->run();
        $tHtmlViewChart     = $oChartTotalSaleByPdtPty->render('wChartTotalSaleByPdtPty', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }


    // Functionality : ฟังก์ชั่น  Call View Data Top 10 Best Seller
    // Parameters : Function Parameter
    // Creator : 23/01/2019 wasin
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTopTenBestSaller()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptenbestseller_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (FCNnHSizeOf($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPdtName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        require_once APPPATH . 'modules\sale\datasources\charttoptenbestsaller\rChartToptenBestSeller.php';
        $oChartToptenBestSeller = new rChartToptenBestSeller(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartToptenBestSeller->run();
        $tHtmlViewChart     = $oChartToptenBestSeller->render('wChartToptenBestSeller', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        unset($tFilesOpenPath);
        unset($oFilesOpen);
        unset($aDataFiles);
        unset($aInfoDataReder);
        unset($oChartToptenBestSeller);
        unset($tHtmlViewChart);
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }


    // Functionality : ฟังก์ชั่น  Call View Data Top 10 Best Seller By Value
    // Parameters : Function Parameter
    // Creator : 17/07/2020 Worakorn
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewTopTenBestSallerByValue()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_toptenbestsellerbyvalue_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);
        // Check ข้อมูลใน Array ว่าค่าหรือไม่
        if (FCNnHSizeOf($aDataFiles) == 0) {
            $aInfoDataReder = array(array("FTPdtName" => "", "FCXsdNet" => "0"));
        } else {
            $aInfoDataReder = $aDataFiles;
        }
        // print_r($aDataFiles);
        require_once APPPATH . 'modules\sale\datasources\charttoptenbestsallerbyvalue\rChartToptenBestSellerByValue.php';
        $oChartToptenBestSellerByValue = new rChartToptenBestSellerByValue(array(
            'aDataReturn'   => $aInfoDataReder,
            'aTextLang'     => $this->aTextLang
        ));
        $oChartToptenBestSellerByValue->run();
        $tHtmlViewChart     = $oChartToptenBestSellerByValue->render('wChartToptenBestSellerByValue', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];
        unset($tFilesOpenPath);
        unset($oFilesOpen);
        unset($aDataFiles);
        unset($aInfoDataReder);
        unset($oChartToptenBestSellerByValue);
        unset($tHtmlViewChart);
        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Call View Modal Config Page
    // Parameters : Ajax and Function Parameter
    // Creator : 11/06/2020 Worakorn
    // Return : String View
    // Return Type : View
    public function FSvCDSHSALCallModalConfigPage()
    {

        $aTextLang   = array(
            'tDSHSALModalBtnCancel'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnCancel'),
            'tDSHSALModalBtnSave'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBtnSave'),
            'tDSHSALBillQty'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillQty'),
            'tDSHSALBillTotalAll'                => language('sale/dashboardsale/dashboardsale', 'tDSHSALBillTotalAll'),
            'tDSHSALTotalSaleByPayment'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPayment'),
            'tDSHSALNewProductTopTen'       => language('sale/dashboardsale/dashboardsale', 'tDSHSALNewProductTopTen'),
            'tDSHSALTotalSaleByPdtGrp'      => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtGrp'),
            'tDSHSALTotalSaleByPdtType'     => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalSaleByPdtType'),
            'tDSHSALBestSaleProductTopTen'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTen'),
            'tDSHSALTotalByBranch'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALTotalByBranch'),
            'tDSHSALConfigPage'          => language('sale/dashboardsale/dashboardsale', 'tDSHSALConfigPage'),
            'tDSHSALBestSaleProductTopTenByValue'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALBestSaleProductTopTenByValue'),
            'tDSHSALSalesComparisonChartbyYTD'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesComparisonChartbyYTD'),
            'tDSHSALSalesComparisonChartbyMTD'  => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesComparisonChartbyMTD'),

        );

        $aDataConfigView    = [
            'aTextLang'    =>  $aTextLang
        ];

        $this->load->view('sale/dashboardsale/viewmodal/wDashBoardConfigPage', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น Set Cookie Config Page
    // Parameters : Ajax and Function Parameter
    // Creator : 11/06/2020 Worakorn
    // Return : -
    // Return Type : -
    public function FSvCDSHSALCallModalConfigPageSaveCookie()
    {
        $aResultString = $this->input->post('aResultString');
        // print_r($aResultString);
        // die();
        $tPrefixCookie = "Cookie_SKC";

        $nCookieName = $tPrefixCookie . $this->session->userdata("tSesUserCode");
        $tCookieValue = json_encode($aResultString);


        $aCookie = array(
            'name'   => $nCookieName,
            'value'  => $tCookieValue,
            'expire' =>  31556926,
        );

        $this->input->set_cookie($aCookie);
    }


    // Functionality : ฟังก์ชั่น  Call View Data Report Compare SaleByPdt
    // Parameters : Function Parameter
    // Creator : 09/02/2021 witsarut 
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewCompareSaleByPdtQty()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtQty_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);


        require_once APPPATH . 'modules\sale\datasources\charttotalDasBoardRptComparePdt\rChartTotalDasBoardRptComparePdtQty.php';
        $oChartTotalRptDashBoardComparePdtQty    = new rChartTotalDasBoardRptComparePdtQty(array(
            'aDataReturn'   => $aDataFiles,
            'aTextLang'     => $this->aTextLang
        ));

        $oChartTotalRptDashBoardComparePdtQty->run();

        $tHtmlViewChart     = $oChartTotalRptDashBoardComparePdtQty->render('wChartTotalDasBoardSaleComparePdtQty', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];

        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }

    // Functionality : ฟังก์ชั่น  Call View Data Report Compare SaleByAmt
    // Parameters : Function Parameter
    // Creator : 09/02/2021 witsarut 
    // Return : None
    // Return Type : None
    public function FSvCDSHSALViewCompareSaleByPdtAmt()
    {
        $tFilesOpenPath = APPPATH . "modules\sale\assets\sysdshtemp\\" . $this->tSesUserCode . "\\db_totalsaleRptComPdtAmt_tmp.txt";
        $oFilesOpen     = fopen($tFilesOpenPath, 'r');
        $aDataFiles     = json_decode(fread($oFilesOpen, filesize($tFilesOpenPath)), true);
        fclose($oFilesOpen);

        require_once APPPATH . 'modules\sale\datasources\charttotalDasBoardRptComparePdt\rChartTotalDasBoardRptComparePdtAmt.php';
        $oChartTotalRptDashBoardComparePdtAmt    = new rChartTotalDasBoardRptComparePdtAmt(array(
            'aDataReturn'   => $aDataFiles,
            'aTextLang'     => $this->aTextLang
        ));

        $oChartTotalRptDashBoardComparePdtAmt->run();

        $tHtmlViewChart     = $oChartTotalRptDashBoardComparePdtAmt->render('wChartTotalDasBoardSaleComparePdtAmt', true);
        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];

        $this->load->view('sale/dashboardsale/wDashBoardChartCenter', $aDataConfigView);
    }
}
