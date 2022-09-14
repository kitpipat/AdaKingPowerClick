<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cDashBoardSaleTable extends MX_Controller
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
        $this->load->model('sale/dashboardsale/mDashBoardSaleTable');
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
            'tDSHSALTitleMenu'              => language('sale/dashboardsale/dashboardsale', 'tDSHSALTitleMenuTable'),
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

        ];
        $this->aAlwEvent        = FCNaHCheckAlwFunc('dashboardsaleTable/0/0');
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
            'aStaAppType'       => (!empty($this->input->post('ocbDSHSALAppType'))) ? $this->input->post('ocbDSHSALAppType') : explode(",", '1,2,3')
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

        $this->load->view('sale/dashboardsaleTable/wDashBoardSale', $aDataConfigView);
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

       
        $aDataConfigView    =  [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'nOptDecimalSave'   => $this->nOptDecimalSave,
            'aAlwEvent'         => $this->aAlwEvent,
            'aTextLang'         => $this->aTextLang,
        ];



        $this->load->view('sale/dashboardsaleTable/wDashBoardSaleMain', $aDataConfigView);
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
        $this->load->view('sale/dashboardsaleTable/viewmodal/wDashBoardModalFilter', $aDataConfigView);
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
        }
        $aDataReturn    = [
            'rtDSHSALTypeKey'   => $tDSHSALTypeKey,
            'rtCode'            => '1',
            'rtDesc'            => 'success',
        ];
        echo json_encode($aDataReturn);
    }

   

    // Functionality : ฟังก์ชั่น  Call View Data Total By Bracnh
    // Parameters : Function Parameter
    // Creator : 10/06/2020 Worakorn
    // Return : None
    // Return Type : None
    public function  FSvCDSHSALViewTotalByBranch()
    {
        $nPage          = ($this->input->post('nPageCurrent') == '' || null) ? 1 : $this->input->post('nPageCurrent');   // Check Number Page

        $aData  = array(
            'nPage'         => $nPage,
            'nRow'          => 10,
        );


        $aTextLangTotalByBranch   = array(
            'tDSHSALModalBranch'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalBranch'),
            'tDSHSALModalPos'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALModalPos'),
            'tDSHSALType'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALType'),
            'tDSHSALFromBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALFromBill'),
            'tDSHSALToBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALToBill'),
            'tDSHSALQtyBill'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALQtyBill'),
            'tDSHSALValue'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALValue'),
            'tDSHSALCheckOut'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALCheckOut'),
            'tDSHSALSale'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALSale'),
            'tDSHSALReturn'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALReturn'),
            'tDSHSALDiff'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALDiff'),
            'tDSHSALDateTBB'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALDateTBB'),
            'tDSHSALSalesCycle'   => language('sale/dashboardsale/dashboardsale', 'tDSHSALSalesCycle'),


        );

        $aListData = array(
            'aTotalSaleByBranchData' => $this->mDashBoardSaleTable->FSaMDSHSALTotalSaleByBranch($aData),
            'aTextLangTotalByBranchShow' => $aTextLangTotalByBranch,
            'nPage'         => $nPage,
            'tSort' => $this->input->post('oetDSHSALSort'),
            'tfild' => $this->input->post('oetDSHSALFild'),
        );

        $aDataConfigView = array(
            'aListViewTotalByBranch' => $this->load->view('sale/dashboardsaleTable/viewchart/wDashBoardTotalByBranch', $aListData),
        );

        $tHtmlViewChart     = $this->load->view('sale/dashboardsaleTable/wDashBoardChartCenter', $aDataConfigView);

        $aDataConfigView    = [
            'tHtmlViewChart'    => $tHtmlViewChart
        ];

        $this->load->view('sale/dashboardsaleTable/wDashBoardChartCenter', $aDataConfigView);
    }


    
}
