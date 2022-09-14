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


class cRptPickingHistory extends MX_Controller
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
        parent::__construct();
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reporthistory/mRptPickingHistory');

        // Init Report
        $this->init();
        parent::__construct();
    }


    private function init()
    {
        $this->aText = [
            'tTitleReport'          => language('report/report/report', 'tRptPackingHistoryTitle'),
            'tDatePrint'            => language('report/report/report', 'tRptAdjStkVDDatePrint'),
            'tTimePrint'            => language('report/report/report', 'tRptAdjStkVDTimePrint'),
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
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),
            'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
            'tRptTel' => language('report/report/report', 'tRptTel'),
            // Table Label
            'tRptAdjStkVDDocNo'         => language('report/report/report', 'tRptAdjStkVDDocNo'),
            'tRptAdjStkVDDocDate'       => language('report/report/report', 'tRptAdjStkVDDocDate'),
            'tRptAdjStkVDUserAdj'       => language('report/report/report', 'tRptAdjStkVDUserAdj'),
            'tRptAdjStkVDPdtCode'       => language('report/report/report', 'tRptAdjStkVDPdtCode'),
            'tRptAdjStkVDPdtName'       => language('report/report/report', 'tRptAdjStkVDPdtName'),
            'tRptAdjStkVDLayRow'        => language('report/report/report', 'tRptAdjStkVDLayRow'),
            'tRptAdjStkVDLayCol'        => language('report/report/report', 'tRptAdjStkVDLayCol'),
            'tRptAdjStkVDWahB4Adj'      => language('report/report/report', 'tRptAdjStkVDWahB4Adj'),
            'tRptAdjStkVDUnitQty'       => language('report/report/report', 'tRptAdjStkVDUnitQty'),
            'tRptAdjStkVDTotalSub'      => language('report/report/report', 'tRptAdjStkVDTotalSub'),
            'tRptAdjStkVDTotalFooter'   => language('report/report/report', 'tRptAdjStkVDTotalFooter'),
            'tRptUnit'                  => language('report/report/report', 'tRptUnit'),
            // Fillter AdjStock
            'tRptAdjMerChantFrom'       => language('report/report/report', 'tRptAdjMerChantFrom'),
            'tRptAdjMerChantTo'         => language('report/report/report', 'tRptAdjMerChantTo'),
            'tRptAdjShopFrom'           => language('report/report/report', 'tRptAdjShopFrom'),
            'tRptAdjShopTo'             => language('report/report/report', 'tRptAdjShopTo'),
            'tRptAdjPosFrom'            => language('report/report/report', 'tRptAdjPosFrom'),
            'tRptAdjPosTo'              => language('report/report/report', 'tRptAdjPosTo'),
            'tRptAdjWahFrom'            => language('report/report/report', 'tRptAdjWahFrom'),
            'tRptAdjWahTo'              => language('report/report/report', 'tRptAdjWahTo'),
            'tRptAdjDateFrom'           => language('report/report/report', 'tRptAdjDateFrom'),
            'tRptAdjDateTo'             => language('report/report/report', 'tRptAdjDateTo'),
            'tRptBchFrom'               => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'                 => language('report/report/report', 'tRptBchTo'),

            // No Data Report
            'tRptAdjStkNoData'          => language('common/main/main', 'tCMNNotFoundData'),

            // Update Text Wasin(18/11/2019)
            'tRptAjdQtyAllDiff'         => language('report/report/report', 'tRptAjdQtyAllDiff'),
            'tRptAdjStkVDTaxNo'         => language('report/report/report', 'tRptAdjStkVDTaxNo'),
            'tRptConditionInReport'     => language('report/report/report', 'tRptConditionInReport'),

            'tRptMerFrom'               => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'                 => language('report/report/report', 'tRptMerTo'),
            'tRptShopFrom'              => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'                => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom'               => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'                 => language('report/report/report', 'tRptPosTo'),
            'tPdtCodeTo'                => language('report/report/report', 'tPdtCodeTo'),
            'tPdtCodeFrom'              => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtGrpFrom'               => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'                 => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom'              => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'                => language('report/report/report', 'tPdtTypeTo'),
            'tRptAdjWahFrom'            => language('report/report/report', 'tRptAdjWahFrom'),
            'tRptAdjWahTo'              => language('report/report/report', 'tRptAdjWahTo'),
            'tRptAll'                   => language('report/report/report', 'tRptAll'),


            // Filter Text Label
            'tRptTaxSalePosFilterBchFrom' => language('report/report/report', 'tRptTaxSalePosFilterBchFrom'),
            'tRptTaxSalePosFilterBchTo' => language('report/report/report', 'tRptTaxSalePosFilterBchTo'),
            'tRptTaxSalePosFilterShopFrom' => language('report/report/report', 'tRptTaxSalePosFilterShopFrom'),
            'tRptTaxSalePosFilterShopTo' => language('report/report/report', 'tRptTaxSalePosFilterShopTo'),
            'tRptTaxSalePosFilterPosFrom' => language('report/report/report', 'tRptTaxSalePosFilterPosFrom'),
            'tRptTaxSalePosFilterPosTo' => language('report/report/report', 'tRptTaxSalePosFilterPosTo'),
            'tRptTaxSalePosFilterPayTypeFrom' => language('report/report/report', 'tRptTaxSalePosFilterPayTypeFrom'),
            'tRptTaxSalePosFilterPayTypeTo' => language('report/report/report', 'tRptTaxSalePosFilterPayTypeTo'),
            'tRptTaxSalePosFilterDocDateFrom' => language('report/report/report', 'tRptTaxSalePosFilterDocDateFrom'),
            'tRptTaxSalePosFilterDocDateTo' => language('report/report/report', 'tRptTaxSalePosFilterDocDateTo'),
            'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),

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

        // Report Fillter
        $this->aRptFilter = [
            'tSessionID'  => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'nLangID'       => $this->nLngID,

            'tTypeSelect'          => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            //Filter BCH (สาขา)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeFrom'      => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
            'tMerNameFrom'      => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
            'tMerCodeTo'        => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
            'tMerNameTo'        => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Filter Shop (ร้านค้า)
            'tShpCodeFrom'      => (empty($this->input->post('oetRptShpCodeFrom'))) ? '' : $this->input->post('oetRptShpCodeFrom'),
            'tShpNameFrom'      => (empty($this->input->post('oetRptShpNameFrom'))) ? '' : $this->input->post('oetRptShpNameFrom'),
            'tShpCodeTo'        => (empty($this->input->post('oetRptShpCodeTo'))) ? '' : $this->input->post('oetRptShpCodeTo'),
            'tShpNameTo'        => (empty($this->input->post('oetRptShpNameTo'))) ? '' : $this->input->post('oetRptShpNameTo'),
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeFrom'      => (empty($this->input->post('oetRptPosCodeFrom'))) ? '' : $this->input->post('oetRptPosCodeFrom'),
            'tPosNameFrom'      => (empty($this->input->post('oetRptPosNameFrom'))) ? '' : $this->input->post('oetRptPosNameFrom'),
            'tPosCodeTo'        => (empty($this->input->post('oetRptPosCodeTo'))) ? '' : $this->input->post('oetRptPosCodeTo'),
            'tPosNameTo'        => (empty($this->input->post('oetRptPosNameTo'))) ? '' : $this->input->post('oetRptPosNameTo'),
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // Filter Pos (คลังสินค้า)
            'tWahCodeFrom'      => (empty($this->input->post('oetRptWahCodeFrom'))) ? '' : $this->input->post('oetRptWahCodeFrom'),
            'tWahNameFrom'      => (empty($this->input->post('oetRptWahNameFrom'))) ? '' : $this->input->post('oetRptWahNameFrom'),
            'tWahCodeTo'        => (empty($this->input->post('oetRptWahCodeTo'))) ? '' : $this->input->post('oetRptWahCodeTo'),
            'tWahNameTo'        => (empty($this->input->post('oetRptWahNameTo'))) ? '' : $this->input->post('oetRptWahNameTo'),
            'tWahCodeSelect'    => !empty($this->input->post('oetRptWahCodeSelect')) ? $this->input->post('oetRptWahCodeSelect') : "",
            'tWahNameSelect'    => !empty($this->input->post('oetRptWahNameSelect')) ? $this->input->post('oetRptWahNameSelect') : "",
            'bWahStaSelectAll'  => !empty($this->input->post('oetRptWahStaSelectAll')) && ($this->input->post('oetRptWahStaSelectAll') == 1) ? true : false,

            // Filter Document Date (วันที่สร้างเอกสาร)
            'tDocDateFrom'  => (empty($this->input->post('oetRptDocDateFrom'))) ? '' : $this->input->post('oetRptDocDateFrom'),
            'tDocDateTo'    => (empty($this->input->post('oetRptDocDateTo'))) ? '' : $this->input->post('oetRptDocDateTo'),

            // สินค้า
            'tPdtCodeFrom'      => !empty($this->input->post('oetRptPdtCodeFrom')) ? $this->input->post('oetRptPdtCodeFrom') : "",
            'tPdtNameFrom'      => !empty($this->input->post('oetRptPdtNameFrom')) ? $this->input->post('oetRptPdtNameFrom') : "",
            'tPdtCodeTo'        => !empty($this->input->post('oetRptPdtCodeTo')) ? $this->input->post('oetRptPdtCodeTo') : "",
            'tPdtNameTo'        => !empty($this->input->post('oetRptPdtNameTo')) ? $this->input->post('oetRptPdtNameTo') : ""
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];

        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index()
    {
        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {
            // Execute Stored Procedure
            $this->mRptPickingHistory->FSnMExecStoreReport($this->aRptFilter);

            $aDataSwitchCase = array(
                'ptRptRoute'        => $this->tRptRoute,
                'ptRptCode'         => $this->tRptCode,
                'ptRptTypeExport'   => $this->tRptExportType,
                'paDataFilter'      => $this->aRptFilter
            );

            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSvCCallRptExportFile($aDataSwitchCase);
                    break;
                    // case 'pdf':
                    //     $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    //     break;
            }
        }
    }

    // Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 01/02/2021 Worakorn
    // LastUpdate: -
    // Return: View Report Viewersd
    // ReturnType: View
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase)
    {
        try {
            $aDataWhere  = array(
                'tUsrSessionID' => $this->tUserSessionID,
                'tCompName'     => $this->tCompName,
                'tUserCode'     => $this->tUserLoginCode,
                'tRptCode'      => $this->tRptCode,
                'nPage'         => 1, // เริ่มทำงานหน้าแรก
                'nPerPage'      => $this->nPerPage,
                // 'nRow'       => $this->nPerPage,
            );

            $aDataReport = $this->mRptPickingHistory->FSaMGetDataReport($aDataWhere);

            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow'   => $this->nOptDecimalShow,
                'aCompanyInfo'      => $this->aCompanyInfo,
                'aDataReport'       => $aDataReport,
                'aDataTextRef'      => $this->aText,
                'aDataFilter'       => $this->aRptFilter
            ];

            // Load View Advance Table
            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reporthistory', 'wRptPickingHistoryHtml', $aDataViewRptParams);

            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport'   => $this->aText['tTitleReport'],
                'tRptTypeExport' => $this->tRptExportType,
                'tRptCode'       => $this->tRptCode,
                'tRptRoute'      => $this->tRptRoute,
                'tViewRenderKool' => $tRptView,
                'aDataFilter' => $this->aRptFilter,
                'aDataReport' => [
                    'raItems' => $aDataReport['aRptData'],
                    'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode' => '1',
                    'rtDesc' => 'success',
                ]
            ];

            $this->load->view('report/report/wReportViewer', $aDataViewerParams);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    // Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 01/02/2021 Worakorn
    // LastUpdate:
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrintClickPage()
    {

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */

        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataWhereRpt = [
            'nPerPage'  => $this->nPerPage,
            'nPage'     => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode'  => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        ];

        $aDataReport = $this->mRptPickingHistory->FSaMGetDataReport($aDataWhereRpt);


        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aDataFilter'     => $aDataFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reporthistory', 'wRptPickingHistoryHtml', $aDataViewRptParams);

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
                'rnAllRow' => $aDataReport['aPagination']['nRowIDEnd'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success'
            )
        );

        $this->load->view('report/report/wReportViewer', $aDataViewerParams);
        /** =========== End Render View ====================================== */
    }

    // Functionality: Function Render Report Excel
    // Parameters:  Function Parameter
    // Creator: 01/02/2021 Worakorn
    // LastUpdate:
    // Return: View Report Viewer
    // ReturnType: View
    private function FSvCCallRptRenderExcel($paDataMain)
    {
        try {
            $tRptRoute      = $this->tRptRoute;
            $tRptCode       = $this->tRptCode;
            $tRptTypeExport = $this->tRptExportType;
            $aDataFilter    = $this->aRptFilter;
            $nPage          = 1;
            $nLangEdit      = $this->session->userdata("tLangEdit");
            $tSesUsername   = $this->session->userdata('tSesUsername');
            $tUsrSessionID  = $this->session->userdata('tSesSessionID');

            // Get data Company
            $aDataAddress       = array();
            $tAPIReq            = "";
            $tMethodReq         = "GET";
            $aDataWhereComp     = array('FNLngID' => $nLangEdit);
            $aCompData          = $this->mCompany->FSaMCMPList($tAPIReq, $tMethodReq, $aDataWhereComp);

            if ($aCompData['rtCode'] == '1') {
                $tCompName      = $aCompData['raItems']['rtCmpName'];
                $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
                $aDataAddress   = $this->mReport->FSaMRptGetDataAddressByBranchComp($tBchCode, $nLangEdit);
            } else {
                $tCompName      = "-";
                $tBchCode       = "-";
                $aDataAddress   = array();
            }

            /** ================================== Begin Init Variable Excel ================================== */
            $tReportName    = $this->aText['tTitleReport'];
            $dDateExport    = date('Y-m-d');
            $tTime          = date('H:i:s');
            /** ===================================== End Init Variable ======================================= */

            // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
            $aDataWhere = [
                'tRptCode'      => $this->tRptCode,
                'nPerPage'      => $this->nPerPage,
                'nPage'         => $this->nPage,
                'nRow'          => 100000,
                'tUsrSessionID' => $this->tUserSessionID,
                'tUserCode'     => $this->tUserLoginCode,
                'tCompName'     => $this->tCompName,
            ];


            $aDataReport = $this->mRptPickingHistory->FSaMGetDataReport($aDataWhere);

            /** =============================================================================================== */
            // ตั้งค่า Font Style
            $aStyleRptFont = array('font' => array('name' => 'TH Sarabun New'));
            $aStyleRptSizeTitleName = array('font' => array('size' => 14));
            $aStyleRptSizeCompName = array('font' => array('size' => 12));
            $aStyleRptSizeAddressFont = array('font' => array('size' => 12));
            $aStyleRptHeadderTable = array('font' => array('size' => 12, 'color' => array('rgb' => '000000')));
            $aStyleRptDataTable = array('font' => array('size' => 10, 'color' => array('rgb' => '000000')));

            // Initiate PHPExcel cache
            $oCacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
            $aCacheSettings = array(' memoryCacheSize ' => '8000MB', 'cacheTime' => 3600 * 120);
            PHPExcel_Settings::setCacheStorageMethod($oCacheMethod, $aCacheSettings);

            // เริ่ม phpExcel
            $objPHPExcel = new PHPExcel();

            // A4 ตั้งค่าหน้ากระดาษ
            $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

            // Set Font Style Text All In Report
            $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($aStyleRptFont);

            // จัดความกว้างของคอลัมน์
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(25);
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(40);
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(15);
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);


            // ชื่อหัวรายงาน
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:I1');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tReportName);
            $objPHPExcel->getActiveSheet()->getStyle("A1")->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptSizeTitleName);

            // Check Address Data
            if (isset($this->aCompanyInfo) && !empty($this->aCompanyInfo)) {
                $tRptCompName = (empty($this->aCompanyInfo['FTCmpName'])) ? '-' : $this->aCompanyInfo['FTCmpName'];
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $tRptCompName)->getStyle('A2')->applyFromArray($aStyleRptSizeCompName);

                //Check Vertion Address
                if ($this->aCompanyInfo['FTAddVersion'] == 1) {
                    // Check Address Line 1
                    $tRptAddV1No = (empty($this->aCompanyInfo['FTAddV1No'])) ? '-' : $this->aCompanyInfo['FTAddV1No'];
                    $tRptAddV1Road = (empty($this->aCompanyInfo['FTAddV1Road'])) ? '-' : $this->aCompanyInfo['FTAddV1Road'];
                    $tRptAddV1Soi = (empty($this->aCompanyInfo['FTAddV1Soi'])) ? '-' : $this->aCompanyInfo['FTAddV1Soi'];
                    $tRptAddAdasoft = (empty($this->aCompanyInfo['FTAddV1Village'])) ? '-' : $this->aCompanyInfo['FTAddV1Village'];
                    $tRptAddressLine1 = $tRptAddV1No . ' ' . $tRptAddAdasoft . ' ' . $this->aText['tRptAddrRoad'] . ' ' . $tRptAddV1Road . ' ' . $this->aText['tRptAddrSoi'] . ' ' . $tRptAddV1Soi;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddressLine1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    // Check Address Line 2
                    $tRptAddV1SubDistName = (empty($this->aCompanyInfo['FTSudName'])) ? '-' : $this->aCompanyInfo['FTSudName'];
                    $tRptAddV1DstName = (empty($this->aCompanyInfo['FTDstName'])) ? '-' : $this->aCompanyInfo['FTDstName'];
                    $tRptAddV1PvnName = (empty($this->aCompanyInfo['FTPvnName'])) ? '-' : $this->aCompanyInfo['FTPvnName'];
                    $tRptAddV1PostCode = (empty($this->aCompanyInfo['FTAddV1PostCode'])) ? '-' : $this->aCompanyInfo['FTAddV1PostCode'];
                    $tRptAddressLine2 = $tRptAddV1SubDistName . ' ' . $tRptAddV1DstName . ' ' . $tRptAddV1PvnName . ' ' . $tRptAddV1PostCode;
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddressLine2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                } else {
                    $tRptAddV2Desc1 = (empty($this->aCompanyInfo['FTAddV2Desc1'])) ? '-' : $this->aCompanyInfo['FTAddV2Desc1'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tRptAddV2Desc1)->getStyle('A3')->applyFromArray($aStyleRptSizeAddressFont);

                    $tRptAddV2Desc2 = (empty($this->aCompanyInfo['FTAddV2Desc2'])) ? '-' : $this->aCompanyInfo['FTAddV2Desc2'];
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tRptAddV2Desc2)->getStyle('A4')->applyFromArray($aStyleRptSizeAddressFont);
                }

                // Check Data Telephone Number
                if (isset($this->aCompanyInfo['FTCmpTel']) && !empty($this->aCompanyInfo['FTCmpTel'])) {
                    $tRptCompTel = $this->aCompanyInfo['FTCmpTel'];
                } else {
                    $tRptCompTel = '-';
                }

                if (isset($this->aCompanyInfo['FTCmpFax']) && !empty($this->aCompanyInfo['FTCmpFax'])) {
                    $tRptCmpFax = $this->aCompanyInfo['FTCmpFax'];
                } else {
                    $tRptCmpFax = '-';
                }
                $tRptCompTelText = $this->aText['tRptAddrTel'] . ' ' . $tRptCompTel . ' ' . $this->aText['tRptAddrFax'] . ' ' . $tRptCmpFax;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tRptCompTelText)->getStyle('A5')->applyFromArray($aStyleRptSizeAddressFont);

                //Check Data Branch
                if (isset($this->aCompanyInfo['FTBchName']) && !empty($this->aCompanyInfo['FTBchName'])) {
                    $tRptBchName = $this->aCompanyInfo['FTBchName'];
                } else {
                    $tRptBchName = '-';
                }
                $tRptBchName = $this->aText['tRptAddrBranch'] . ' ' . $tRptBchName;
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tRptBchName)->getStyle('A6')->applyFromArray($aStyleRptSizeAddressFont);
            }

            // ฟิวเตอร์ข้อมูลรายงาน ===================================================================================================================================================
            // Row เริ่มต้นของ Filter
            $nStartRowFillter = 2;
            $tFillterColumLEFT = "D";
            $tFillterColumRIGHT = "F";

            // Fillter MerChant (กลุ่มธุระกิจ)
            if (!empty($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeTo'])) {
                $tRptFilterMerCodeFrom = $this->aText['tRptAdjMerChantFrom'] . ' ' . $aDataFilter['tMerNameFrom'];
                $tRptFilterMerCodeTo = $this->aText['tRptAdjMerChantTo'] . ' ' . $aDataFilter['tMerNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterMerCodeFrom . ' ' . $tRptFilterMerCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Shop (ร้านค้า)
            if (!empty($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeTo'])) {
                $tRptFilterShopCodeFrom = $this->aText['tRptAdjShopFrom'] . ' ' . $aDataFilter['tShpNameFrom'];
                $tRptFilterShopCodeTo = $this->aText['tRptAdjShopTo'] . ' ' . $aDataFilter['tShpNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterShopCodeFrom . ' ' . $tRptFilterShopCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Pos (เครื่องจุดขาย)
            if (!empty($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeTo'])) {
                $tRptFilterPosCodeFrom = $this->aText['tRptAdjPosFrom'] . ' ' . $aDataFilter['tPosNameFrom'];
                $tRptFilterPosCodeTo = $this->aText['tRptAdjPosTo'] . ' ' . $aDataFilter['tPosNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterPosCodeFrom . ' ' . $tRptFilterPosCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter Wharehourse (คลังสินค้า)
            if (!empty($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeTo'])) {
                $tRptFilterWahCodeFrom = $this->aText['tRptAdjWahFrom'] . ' ' . $aDataFilter['tWahNameFrom'];
                $tRptFilterWahCodeTo = $this->aText['tRptAdjWahTo'] . ' ' . $aDataFilter['tWahNameTo'];
                $tRptTextLeftRightFilter = $tRptFilterWahCodeFrom . ' ' . $tRptFilterWahCodeTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // Fillter DocDate (วันที่สร้างเอกสาร)
            if (!empty($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateTo'])) {
                $tRptFilterDocDateFrom = $this->aText['tRptAdjDateFrom'] . ' ' . $aDataFilter['tDocDateFrom'];
                $tRptFilterDocDateTo = $this->aText['tRptAdjDateTo'] . ' ' . $aDataFilter['tDocDateTo'];
                $tRptTextLeftRightFilter = $tRptFilterDocDateFrom . ' ' . $tRptFilterDocDateTo;
                $tColumsMergeFilter = $tFillterColumLEFT . $nStartRowFillter . ':' . $tFillterColumRIGHT . $nStartRowFillter;

                $objPHPExcel->setActiveSheetIndex(0)->mergeCells($tColumsMergeFilter);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $tRptTextLeftRightFilter);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);
                $nStartRowFillter += 1;
            }

            // ========================================================================== Date Time Print =========================================================================
            $nStartRowFillter = 7;
            $tRptDateTimeExportText = $this->aText['tDatePrint'] . ' ' . $dDateExport . ' ' . $this->aText['tTimePrint'] . ' ' . $tTime;
            $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowFillter . ':I' . $nStartRowFillter);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowFillter, $tRptDateTimeExportText);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowFillter)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowFillter)->applyFromArray($aStyleRptSizeAddressFont);


            $nStartRowHeadder = 8;
            // กำหนด Style Font ของหัวตาราง
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->applyFromArray(array(
                'borders' => array(
                    'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                    'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                )
            ));

            // กำหนดข้อมูลลงหัวตาราง
            $objPHPExcel->setActiveSheetIndex(0)
                ->setCellValue('A' . $nStartRowHeadder, $this->aText['tRptAdjStkVDDocNo'])
                ->setCellValue('B' . $nStartRowHeadder, $this->aText['tRptAdjStkVDDocDate'])
                ->setCellValue('C' . $nStartRowHeadder, $this->aText['tRptAdjStkVDUserAdj'])
                ->setCellValue('D' . $nStartRowHeadder, $this->aText['tRptAdjStkVDPdtCode'])
                ->setCellValue('E' . $nStartRowHeadder, $this->aText['tRptAdjStkVDPdtName'])
                ->setCellValue('F' . $nStartRowHeadder, $this->aText['tRptAdjStkVDLayRow'])
                ->setCellValue('G' . $nStartRowHeadder, $this->aText['tRptAdjStkVDLayCol'])
                ->setCellValue('H' . $nStartRowHeadder, $this->aText['tRptAdjStkVDWahB4Adj'])
                ->setCellValue('I' . $nStartRowHeadder, $this->aText['tRptAdjStkVDUnitQty']);
            // Alignment ของหัวตาราง
            $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':I' . $nStartRowHeadder)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
            // ====================================================================================================================================================================

            // วนลูปข้อมูลตารางข้อมูล =================================================================================================================================================
            // Set Variable Data
            $nStartRowData = $nStartRowHeadder + 1;
            if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
                // ******* Step 1 ประกาศตัวแปรใช้ในการเช็คเงื่อนไข
                $tGrouppingData = "";
                $nGroupMember = "";
                $nRowPartID = "";

                $nSumFooterAjdWahB4Adj = 0;
                $nSumFooterAjdUnitQty = 0;
                foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                    // ******* Step 3 Set ค่า Value FNRptGroupMember And FNRowPartID
                    $nRowPartID = $aValue["FNRowPartID"];
                    $nGroupMember = $aValue["FNRptGroupMember"];

                    // ******* Step 4 : Check Groupping Create Row Groupping
                    if ($tGrouppingData != $aValue['FTAjhDocNo']) {
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $aValue['FTAjhDocNo']);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('B' . $nStartRowData, $aValue['FTAjhDocNo']);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('C' . $nStartRowData, $aValue['FTAjdApvName']);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':C' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
                        $nStartRowData++;
                    }

                    // ******* Step 5 : Loop Set Data Value
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':C' . $nStartRowData);
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('D' . $nStartRowData, $aValue['FTPdtCode'])
                        ->setCellValue('E' . $nStartRowData, $aValue['FTPdtName'])
                        ->setCellValue('F' . $nStartRowData, number_format($aValue['FNAjdLayRow'], 0))
                        ->setCellValue('G' . $nStartRowData, number_format($aValue['FNAjdLayCol'], 0))
                        ->setCellValue('H' . $nStartRowData, number_format($aValue['FCAjdWahB4Adj'], 0))
                        ->setCellValue('I' . $nStartRowData, number_format($aValue['FCAjdUnitQty'], 0));
                    $objPHPExcel->getActiveSheet()->getStyle('D' . $nStartRowData . ':E' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('F' . $nStartRowData . ':I' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

                    // ******* Step 6 : เตรียม Parameter สำหรับ Summary Sub Footer
                    if ($nRowPartID == $nGroupMember) {
                        $nStartRowData++;
                        $nSubSumAjdWahB4Adj = $aValue["FCAjdWahB4Adj_SubTotal"];
                        $nSubSumAjdUnitQty = $aValue["FCAjdUnitQty_SubTotal"];
                        // Set Color Row Sub Footer
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->applyFromArray(array(
                            'borders' => array(
                                'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000'))
                            )
                        ));

                        // Text Sum Sub
                        $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':G' . $nStartRowData);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptAdjStkVDTotalSub']);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                        $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                        // Value Sum Sub
                        $objPHPExcel->setActiveSheetIndex(0)
                            ->setCellValue('H' . $nStartRowData, number_format($nSubSumAjdWahB4Adj, 0))
                            ->setCellValue('I' . $nStartRowData, number_format($nSubSumAjdUnitQty, 0));
                    }

                    $nSumFooterAjdWahB4Adj = number_format($aValue["FCAjdWahB4Adj_Footer"], 2);
                    $nSumFooterAjdUnitQty = number_format($aValue["FCAjdUnitQty_Footer"], 2);

                    // ******* Step 2 Set ค่า Value ให้กับตัวแปร
                    $tGrouppingData = $aValue["FTAjhDocNo"];
                    $nStartRowData++;
                }

                // Step 7 : Set Footer Text
                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                if ($nPageNo == $nTotalPage) {
                    // Set Color Row Sub Footer
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':I' . $nStartRowData)->applyFromArray(array(
                        'borders' => array(
                            'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
                            'bottom' => array('style' => PHPExcel_Style_Border::BORDER_DOUBLE, 'color' => array('rgb' => '000000'))
                        )
                    ));

                    // Text Sum Footer
                    $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':G' . $nStartRowData);
                    $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptAdjStkVDTotalFooter']);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
                    $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);

                    // Value Sum Footer
                    $objPHPExcel->setActiveSheetIndex(0)
                        ->setCellValue('H' . $nStartRowData, number_format($nSumFooterAjdWahB4Adj, 2))
                        ->setCellValue('I' . $nStartRowData, number_format($nSumFooterAjdUnitQty, 2));
                }
            } else {
                $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . $nStartRowData . ':I' . $nStartRowData);
                $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . $nStartRowData, $this->aText['tRptAdjStkNoData']);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData)->applyFromArray($aStyleRptDataTable);
            }


            // ====================================================================================================================================================================
            // Set Content Type Export File Excel =================================================================================================================================
            $tFilename = 'Report-' . $tRptCode . date("dmYhis") . '.xlsx';

            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Content-Type: application/force-download");
            header("Content-Type: application/octet-stream");
            header("Content-Type: application/download");;
            header("Content-Disposition: attachment;filename=$tFilename");
            header("Content-Transfer-Encoding: binary");

            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

            if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/')) {
                mkdir(APPPATH . 'modules/report/assets/exportexcel/');
            }

            if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode)) {
                mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode);
            }

            if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername)) {
                mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername);
            }

            $tPathExport = APPPATH . 'modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername . '/';
            $oFiles = glob($tPathExport . '*');
            foreach ($oFiles as $tFile) {
                if (is_file($tFile))
                    unlink($tFile);
            }

            // Check Status Save File Excel
            $objWriter->save($tPathExport . $tFilename);
            $aResponse = array(
                'nStaExport' => 1,
                'tFileName' => $tFilename,
                'tPathFolder' => 'application/modules/report/assets/exportexcel/' . $tRptCode . '/' . $tSesUsername . '/',
                'tMessage' => "Export File Successfully."
            );
            // ====================================================================================================================================================================
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaExport' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

    // Functionality: Click Page Report (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 01/02/2021 Worakorn
    // LastUpdate: -
    // Return: object Status Count Data Report
    // ReturnType: Object
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase)
    {
        try {
            $aDataCountData = [
                'tCompName' => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode' => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tSessionID' => $paDataSwitchCase['paDataFilter']['tSessionID'],
            ];

            $nDataCountPage = $this->mRptPickingHistory->FSnMCountDataReportAll($aDataCountData);

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
     * LastUpdate: 24/09/2019 Piya
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    // public function FSvCCallRptExportFile()
    // {
    //     try {
    //         $dDateSendMQ = date('Y-m-d');
    //         $dTimeSendMQ = date('H:i:s');
    //         $dDateSubscribe = date('Ymd');
    //         $dTimeSubscribe = date('His');

    //         // Set Parameter Send MQ
    //         $tRptQueueName = 'RPT_' . $this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

    //         $aDataSendMQ = [
    //             'tQueueName' => $tRptQueueName,
    //             'aParams' => [
    //                 'ptRptCode'       => $this->tRptCode,
    //                 'pnPerFile'       => 20000,
    //                 'ptUserCode'      => $this->tUserLoginCode,
    //                 'ptUserSessionID' => $this->tUserSessionID,
    //                 'pnLngID'         => $this->nLngID,
    //                 'ptFilter'        => $this->aRptFilter,
    //                 'ptRptExpType'    => $this->tRptExportType,
    //                 'ptComName'       => $this->tCompName,
    //                 'ptDate'          => $dDateSendMQ,
    //                 'ptTime'          => $dTimeSendMQ,
    //                 'ptBchCode'       => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
    //             ]
    //         ];

    //         FCNxReportCallRabbitMQ($aDataSendMQ);

    //         $aResponse = array(
    //             'nStaEvent' => 1,
    //             'tMessage' => 'Success Send Rabbit MQ.',
    //             'aDataSubscribe' => array(
    //                 'ptSysBchCode'  => $this->tSysBchCode,
    //                 'ptComName' => $this->tCompName,
    //                 'ptRptCode' => $this->tRptCode,
    //                 'ptUserCode' => $this->tUserLoginCode,
    //                 'ptUserSessionID' => $this->tUserSessionID,
    //                 'pdDateSubscribe' => $dDateSubscribe,
    //                 'pdTimeSubscribe' => $dTimeSubscribe,
    //             )
    //         );
    //     } catch (Exception $Error) {
    //         $aResponse = array(
    //             'nStaEvent' => 500,
    //             'tMessage' => $Error->getMessage()
    //         );
    //     }
    //     echo json_encode($aResponse);
    // }

    public function FSvCCallRptExportFile()
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
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfPdtCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfPdtName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfFrom')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfTo')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfDocNo')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptRefCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptRefDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTnfQty')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptUnit')),
            WriterEntityFactory::createCell(null),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataReportParams = [
            'nPerPage'      => 999999999999,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter'   => $this->aRptFilter
        ];

        $aDataReport = $this->mRptPickingHistory->FSaMGetDataReport($aDataReportParams);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {

            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                if(!empty($aValue['FDXthRefIntDate'])){
                    $tRefIntDate    = date("d/m/Y", strtotime($aValue['FDXthRefIntDate']));
                }else{
                    $tRefIntDate    = "";
                }

                $values = [
                    WriterEntityFactory::createCell($aValue['FTPdtCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPdtName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTXthToName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTWahNameFrm']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTXthDocNo']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(date("d/m/Y", strtotime($aValue['FDXthDocDate']))),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTXthRefInt']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tRefIntDate),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXidQty'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPunName']),
                    WriterEntityFactory::createCell(null),
                ];

                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);

                if (($nKey + 1) == FCNnHSizeOf($aDataReport['aRptData'])) { //SumFooter
                    $nFCXidQty_SubFooter     = FCNnGetNumeric($aValue["FCXidQty_Footer"]);

                    $values = [
                        WriterEntityFactory::createCell(language('report/report/report', 'tRptAdjStkVDTotalFooter')),
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
                        WriterEntityFactory::createCell($nFCXidQty_SubFooter),
                        WriterEntityFactory::createCell(null),
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
            WriterEntityFactory::createCell($this->aText['tTitleReport']),
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


        if ((isset($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateFrom'])) && (isset($this->aRptFilter['tDocDateTo']) && !empty($this->aRptFilter['tDocDateTo']))) {
            $aCells = [
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell($this->aText['tRptAdjDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptAdjDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
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
            WriterEntityFactory::createCell($this->aText['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $this->aText['tTimePrint'] . ' ' . date('H:i:s')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        return $aMulltiRow;
    }


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

        //กลุ่มธุรกิจ
        if (isset($this->aRptFilter['tMerCodeSelect']) && !empty($this->aRptFilter['tMerCodeSelect'])) {
            $tMerSelect =  ($this->aRptFilter['bMerStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tMerNameSelect'];
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptMerFrom'] . ' : ' . $tMerSelect),
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

        //ร้านค้า (Shop)
        if (isset($this->aRptFilter['tShpCodeSelect']) && !empty($this->aRptFilter['tShpCodeSelect'])) {
            $tShpSelect =  ($this->aRptFilter['bShpStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tShpNameSelect'];
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptShopFrom'] . ' : ' . $tShpSelect),
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

        return $aMulltiRow;
    }






    // Functionality: Send Rabbit MQ Report
    // Parameters:  Function Parameter
    // Creator: 16/08/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: object Send Rabbit MQ Report
    // ReturnType: Object
    // public function FSvCCallRptExportFile() {
    //     try {
    //         $tRptGrpCode = $this->input->post('ohdRptGrpCode');
    //         $tRptCode = $this->input->post('ohdRptCode');
    //         $tUserCode = $this->session->userdata('tSesUsername');
    //         $tSessionID = $this->session->userdata('tSesSessionID');
    //         $nLangID = FCNaHGetLangEdit();
    //         $tRptExportType = $this->input->post('ohdRptTypeExport');

    //         $tIP = $this->input->ip_address();
    //         $tFullHost = gethostbyaddr($tIP);
    //         $this->tCompName = $tFullHost;

    //         $tCompName = $tFullHost;
    //         $dDateSendMQ = date('Y-m-d');
    //         $dTimeSendMQ = date('H:i:s');
    //         $dDateSubscribe = date('Ymd');
    //         $dTimeSubscribe = date('His');

    //         $aDataFilter = array(
    //             // Filter Merchant (กลุ่มธุรกิจ)
    //             'tMerCodeFrom' => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
    //             'tMerNameFrom' => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
    //             'tMerCodeTo' => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
    //             'tMerNameTo' => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
    //             // Filter Shop (ร้านค้า)
    //             'tShpCodeFrom' => (empty($this->input->post('oetRptShpCodeFrom'))) ? '' : $this->input->post('oetRptShpCodeFrom'),
    //             'tShpNameFrom' => (empty($this->input->post('oetRptShpNameFrom'))) ? '' : $this->input->post('oetRptShpNameFrom'),
    //             'tShpCodeTo' => (empty($this->input->post('oetRptShpCodeTo'))) ? '' : $this->input->post('oetRptShpCodeTo'),
    //             'tShpNameTo' => (empty($this->input->post('oetRptShpNameTo'))) ? '' : $this->input->post('oetRptShpNameTo'),
    //             // Filter Pos (เครื่องจุดขาย)
    //             'tPosCodeFrom' => (empty($this->input->post('oetRptPosCodeFrom'))) ? '' : $this->input->post('oetRptPosCodeFrom'),
    //             'tPosNameFrom' => (empty($this->input->post('oetRptPosNameFrom'))) ? '' : $this->input->post('oetRptPosNameFrom'),
    //             'tPosCodeTo' => (empty($this->input->post('oetRptPosCodeTo'))) ? '' : $this->input->post('oetRptPosCodeTo'),
    //             'tPosNameTo' => (empty($this->input->post('oetRptPosNameTo'))) ? '' : $this->input->post('oetRptPosNameTo'),
    //             // Filter Pos (เครื่องจุดขาย)
    //             'tWahCodeFrom' => (empty($this->input->post('oetRptWahCodeFrom'))) ? '' : $this->input->post('oetRptWahCodeFrom'),
    //             'tWahNameFrom' => (empty($this->input->post('oetRptWahNameFrom'))) ? '' : $this->input->post('oetRptWahNameFrom'),
    //             'tWahCodeTo' => (empty($this->input->post('oetRptWahCodeTo'))) ? '' : $this->input->post('oetRptWahCodeTo'),
    //             'tWahNameTo' => (empty($this->input->post('oetRptWahNameTo'))) ? '' : $this->input->post('oetRptWahNameTo'),
    //             // Filter Document Date (วันที่สร้างเอกสาร)
    //             'tDocDateFrom' => (empty($this->input->post('oetRptDocDateFrom'))) ? '' : $this->input->post('oetRptDocDateFrom'),
    //             'tDocDateTo' => (empty($this->input->post('oetRptDocDateTo'))) ? '' : $this->input->post('oetRptDocDateTo')
    //         );

    //         // Set Parameter Send MQ
    //         $tRptQueueName = 'RPT_' .$this->tSysBchCode.'_' . $tRptGrpCode . '_' . $tRptCode;

    //         $aDataSendMQ = [
    //             'tQueueName' => $tRptQueueName,
    //             'aParams' => [
    //                 'ptRptCode' => $tRptCode,
    //                 'pnPerFile' => 20000,
    //                 'ptUserCode' => $tUserCode,
    //                 'ptUserSessionID' => $tSessionID,
    //                 'pnLngID' => $nLangID,
    //                 'ptFilter' => $aDataFilter,
    //                 'ptRptExpType' => $tRptExportType,
    //                 'ptComName' => $tCompName,
    //                 'ptDate' => $dDateSendMQ,
    //                 'ptTime' => $dTimeSendMQ,
    //                 'ptBchCode' => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
    //             ]
    //         ];

    //         FCNxReportCallRabbitMQ($aDataSendMQ);

    //         $aResponse = array(
    //             'nStaEvent' => 1,
    //             'tMessage' => 'Success Send Rabbit MQ.',
    //             'aDataSubscribe' => array(
    //                 'ptSysBchCode'      => $this->tSysBchCode,
    //                 'ptComName'         => $tCompName,
    //                 'ptRptCode'         => $tRptCode,
    //                 'ptUserCode'        => $tUserCode,
    //                 'ptUserSessionID'   => $tSessionID,
    //                 'pdDateSubscribe'   => $dDateSubscribe,
    //                 'pdTimeSubscribe'   => $dTimeSubscribe,
    //             )
    //         );

    //     } catch (Exception $Error) {
    //         $aResponse = array(
    //             'nStaEvent' => 500,
    //             'tMessage' => $Error->getMessage()
    //         );
    //     }
    //     echo json_encode($aResponse);
    // }

}
