<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");

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

class cRptBankDepositCanCelBch extends MX_Controller {

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
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportlocker/mRptBankDepositCanCelBch');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = [
            
            // TitleReport
            'tTitleReport'      => language('report/report/report', 'tRptBankDplCanCelTitle'),
            'tDatePrint'        => language('report/report/report', 'tRptAdjStkVDDatePrint'),
            'tTimePrint'        => language('report/report/report', 'tRptAdjStkVDTimePrint'),

            // Filter Heard Report
            'tRptBchFrom'       => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'         => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'      => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'        => language('report/report/report', 'tRptShopTo'),
            'tPdtCodeFrom'      => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo'        => language('report/report/report', 'tPdtCodeTo'),
            'tPdtGrpFrom'       => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'         => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom'      => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'        => language('report/report/report', 'tPdtTypeTo'),
            'tRptDateFrom'      => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'        => language('report/report/report', 'tRptDateTo'),
            'tRptSaleTaxByMonthlyTotal'        => language('report/report/report', 'tRptSaleTaxByMonthlyTotal'),
            
            // Address Language
            'tRptAddrBuilding'  => language('report/report/report', 'tRptAddrBuilding'),
            'tRptAddrRoad'      => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi'       => language('report/report/report', 'tRptAddrSoi'),
            'tRptAddrSubDistrict' => language('report/report/report', 'tRptAddrSubDistrict'),
            'tRptAddrDistrict'  => language('report/report/report', 'tRptAddrDistrict'),
            'tRptAddrProvince'  => language('report/report/report', 'tRptAddrProvince'),
            'tRptAddrTel'       => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax'       => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrBranch'    => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddV2Desc1'    => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2'    => language('report/report/report', 'tRptAddV2Desc2'),
            'tRptAdjStkVDTotalSub'    => language('report/report/report', 'tRptAdjStkVDTotalSub'),
            'tRptAdjStkVDTotalFooter'    => language('report/report/report', 'tRptAdjStkVDTotalFooter'),
            
            
            // Table Label
            'tRptBillNo'        => language('report/report/report', 'tRptBillNo'),
            'tRptDate'          => language('report/report/report', 'tRptDate'),
            'tRptProduct'       => language('report/report/report', 'tRptProduct'),
            'tRptCabinetnumber' => language('report/report/report', 'tRptCabinetnumber'),
            'tRptPrice'         => language('report/report/report', 'tRptPrice'),
            'tRptSales'         => language('report/report/report', 'tSales'),
            'tRptDiscount'      => language('report/report/report', 'tDiscount'),
            'tRptTax'           => language('report/report/report', 'tRptTax'),
            'tRptGrand'         => language('report/report/report', 'tRptGrand'),
            'tRptTotalSub'      => language('report/report/report', 'tRptTotalSub'),
            'tRptTotalFooter'   => language('report/report/report', 'tRptTotalFooter'),
            // 'tRptTotalFooter'   => language('report/report/report', 'tRptTotalFooter'),
            // No Data Report
            'tRptNoData'        => language('common/main/main', 'tCMNNotFoundData'),

            //อัพเดทใหม่ 18/11/2019 Napat
            'tRptPosTypeName'   => language('report/report/report', 'tRptPosTypeName'),
            'tRptPosType'       => language('report/report/report', 'tRptPosType'),
            'tRptPosType1'      => language('report/report/report', 'tRptPosType1'),
            'tRptPosType2'      => language('report/report/report', 'tRptPosType2'),

            'tRptPdtCode'       => language('report/report/report', 'tRptPdtCode'),
            'tRptPdtName'       => language('report/report/report', 'tRptPdtName'),
            'tRptPdtGrp'        => language('report/report/report', 'tRptPdtGrp'),
            'tRptQty'           => language('report/report/report', 'tRptQty'),
            'tRptUnit'          => language('report/report/report', 'tRptUnit'),
            'tRptAveragePrice'  => language('report/report/report', 'tRptAveragePrice'),
            
            'tRptAdjMerChantFrom'   => language('report/report/report','tRptAdjMerChantFrom'),
            'tRptAdjMerChantTo'     => language('report/report/report','tRptAdjMerChantTo'),
            'tRptAdjShopFrom'       => language('report/report/report','tRptAdjShopFrom'),
            'tRptAdjShopTo'         => language('report/report/report','tRptAdjShopTo'),
            'tRptAdjPosFrom'        => language('report/report/report','tRptAdjPosFrom'),
            'tRptAdjPosTo'          => language('report/report/report','tRptAdjPosTo'),
            'tRptBranch'            => language('report/report/report', 'tRptBranch'),
            'tRptTotal'             => language('report/report/report', 'tRptTotal'),
            'tRPCTaxNo'             => language('report/report/report', 'tRPCTaxNo'),
            'tRptConditionInReport'  => language('report/report/report', 'tRptConditionInReport'),
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
            'tRptAll'               => language('report/report/report', 'tRptAll'),
            'tRptAddrTaxNo'               => language('report/report/report', 'tRptAddrTaxNo'),
            
             //cr Rrport
             
             'tRptLockerDetailDepositAmountDocNo' => language('report/report/report', 'tRptLockerDetailDepositAmountDocNo'),
             'tRptBnkdplDate' => language('report/report/report', 'tRptBnkdplDate'),
             'tRptBnkdplDocno' => language('report/report/report', 'tRptBnkdplDocno'),
             'tRptBnkdplBnkAccno' => language('report/report/report', 'tRptBnkdplBnkAccno'),
             'tRptBnkdplBnkAccType' => language('report/report/report', 'tRptBnkdplBnkAccType'),
             'tRptBnkdplBnkBddType' => language('report/report/report', 'tRptBnkdplBnkBddType'),
             'tRptBnkdplBnkExtDate' => language('report/report/report', 'tRptBnkdplBnkExtDate'),
             'tRptBnkdplRefAmt' => language('report/report/report', 'tRptBnkdplRefAmt'),
             'tRptBnkdplBnkAccToTolsum' => language('report/report/report', 'tRptBnkdplBnkAccToTolsum'),
             
             'tRptTotalFooter'   => language('report/report/report', 'tRptTotalFooter'),
             'tRptRPDCancel'   => language('report/report/report', 'tRptRPDCancel'),
             'tRptRPDRmkCancel'   => language('report/report/report', 'tRptRPDRmkCancel'),
             
             'tRptTaxSalePosTaxId'   => language('report/report/report', 'tRptTaxSalePosTaxId'),
                         // No Data Report
            'tRptTaxSalePosNoData'  => language('common/main/main', 'tCMNNotFoundData'),

            'tRptTaxPointByCstDocDateFrom' => language('report/report/report', 'tRptTaxPointByCstDocDateFrom'),
            'tRptTaxPointByCstDocDateTo'   => language('report/report/report', 'tRptTaxPointByCstDocDateTo'),
            'tRptTaxPointByCstBchFrom'     => language('report/report/report', 'tRptTaxPointByCstBchFrom'),
            'tRptTaxPointByCstBchTo'       => language('report/report/report', 'tRptTaxPointByCstBchTo'),

            'tRptBnkdplBnkAccFrom' => language('report/report/report', 'tRptBnkdplBnkAccFrom'),
            'tRptBnkdplBnkAccTo' => language('report/report/report', 'tRptBnkdplBnkAccTo'),
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
            'tUserSession'      => $this->tUserSessionID,
            'tCompName'         => $tFullHost,
            'tRptCode'          => $this->tRptCode,
            'nLangID'           => $this->nLngID,
            // 'nFilterType'       => $this->nFilterType,

            'nFilterType'       => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",
            // สาขา(Branch)
            'tBchCodeFrom'         => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'         => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'           => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'           => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'       => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'       => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'     => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,
    
            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeFrom'      => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
            'tMerNameFrom'      => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
            'tMerCodeTo'        => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
            'tMerNameTo'        => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom'         => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'         => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'           => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'           => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'       => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'       => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'     => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // เลขที่บัญชี(BnkAccNo)
            
            'tAccNoFrom'      => !empty($this->input->post('oetRptBbkAccNoFrom')) ? $this->input->post('oetRptBbkAccNoFrom') : "",
            'tAccNameFrom'      => !empty($this->input->post('oetRptBbkAccNameFrom')) ? $this->input->post('oetRptBbkAccNameFrom') : "",
            'tAccNoTo'        => !empty($this->input->post('oetRptBbkAccNoTo')) ? $this->input->post('oetRptBbkAccNoTo') : "",
            'tAccNameTo'        => !empty($this->input->post('oetRptBbkAccNameTo')) ? $this->input->post('oetRptBbkAccNameTo') : "",

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'         => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'           => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
            

            
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {

            // Execute Stored Procedure
            $this->mRptBankDepositCanCelBch->FSnMExecStoreReport($this->aRptFilter);
          
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                break;
                case 'excel':
                    $this->FSvCCallRptRenderExcel($this->aRptFilter);
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
    public function FSvCCallRptViewBeforePrint() {
        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'      => $this->nPerPage,
            'nPage'         => '1', // เริ่มทำงานหน้าแรก
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter'   => $this->aRptFilter
        );
        $aDataReport = $this->mRptBankDepositCanCelBch->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aDataFilter'       => $this->aRptFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/reportBankDepositCanCelBch', 'wRptBankDepositCanCelBchHtml', $aDataViewRpt);
        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tRptView,
            'aDataFilter'       => $this->aRptFilter,
            'aDataReport'       => array(
                'raItems'       => $aDataReport['aRptData'],
                'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            )
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
    public function FSvCCallRptViewBeforePrintClickPage() {

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
            'aDataFilter'   => $this->aRptFilter
        );
        $aDataReport = $this->mRptBankDepositCanCelBch->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $aDataFilter
        );

        // Load View Advance Tablew
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/reportBankDepositCanCelBch', 'wRptBankDepositCanCelBchHtml', $aDataViewRpt);
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
            )
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
    public function FSoCChkDataReportInTableTemp() {
        try {
            $aDataCountData = [
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUserSession'  => $this->tUserSessionID,
                'aDataFilter'   => $this->aRptFilter
            ]; 
            $nDataCountPage = $this->mRptBankDepositCanCelBch->FSnMCountRowInTemp($aDataCountData);
            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent'     => 1,
                'tMessage'      => 'Success Count Data All'
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
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

        // $oStyleColums = (new StyleBuilder())
        //     ->setBorder($oBorder)
        //     ->build();

        // $aCells = [
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell($this->aText['tRptPointByCstMember']),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell($this->aText['tRptPointByCrdCstMember']),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell($this->aText['tRptPointMarking']),
        //     WriterEntityFactory::createCell(NULL),
        //     WriterEntityFactory::createCell(NULL),
        // ];

        // /** add a row at a time */
        // $singleRow = WriterEntityFactory::createRow($aCells,$oStyleColums);
        // $oWriter->addRow($singleRow);

    //  ===========================================================================================

        $oBorder = (new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
            ->build();

        $oStyleColums = (new StyleBuilder())
            ->setBorder($oBorder)
            ->setFontBold()
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelBch')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelDocno')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelDocDate')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelType')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelRsnName')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelUser')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelNo')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelRefDate')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(language('report/report/report','tRptBankDplCanCelAmount')),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells,$oStyleColums);
        $oWriter->addRow($singleRow);
 
    $aDataReportParams = [
        'nPerPage'      => 999999999999,
        'nPage'         => $this->nPage,
        'tCompName'     => $this->tCompName,
        'tRptCode'      => $this->tRptCode,
        'tUsrSessionID' => $this->tUserSessionID,
        'aDataFilter'   => $this->aRptFilter
    ];

  //Get Data
  $aDataReport = $this->mRptBankDepositCanCelBch->FSaMGetDataReport($aDataReportParams);
    
     /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
                ->setCellAlignment(CellAlignment::RIGHT)
                ->build();

     if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
         foreach ($aDataReport['aRptData'] as $nKey => $aValue) { 
                   $values= [
                            WriterEntityFactory::createCell($aValue['FTBchName']),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell($aValue['FTBdhDocNo']),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(date('d/m/Y',strtotime($aValue['FDBdhDate']))),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell($aValue['FTBddType']),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell($aValue['FTRsnName']),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell($aValue['FTUsrName']),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell($aValue['FNBddSeq']),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(date('d/m/Y',strtotime($aValue['FDBdhRefExtDate']))),
                            WriterEntityFactory::createCell(NULL),
                            WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCBddRefAmt"])),
                    ];
                    $aRow = WriterEntityFactory::createRow($values);
                    $oWriter->addRow($aRow);
             
                if(($nKey+1)==FCNnHSizeOf($aDataReport['aRptData'])){ //SumFooter
                    $values= [
                        WriterEntityFactory::createCell($this->aText['tRptTotalFooter']),
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
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCXrcNet_Footer"])),
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
    WriterEntityFactory::createCell($this->aText['tTitleReport']),
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
        WriterEntityFactory::createCell($this->aText['tRptAddrTel'].' '.$this->aCompanyInfo['FTCmpTel']),
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
        WriterEntityFactory::createCell($this->aText['tRptAddrBranch'] .' '. $this->aCompanyInfo['FTBchName']),
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
            WriterEntityFactory::createCell($this->aText['tRptTaxPointByCstDocDateFrom'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateFrom'])).' '.$this->aText['tRptTaxPointByCstDocDateTo'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateTo']))),
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
        WriterEntityFactory::createCell($this->aText['tDatePrint'].' '.date('d/m/Y').' '.$this->aText['tTimePrint'].' '.date('H:i:s')),
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


    //   if ((isset($this->aRptFilter['tCstCodeFrom']) && !empty($this->aRptFilter['tCstCodeFrom'])) && (isset($this->aRptFilter['tCstCodeTo']) && !empty($this->aRptFilter['tCstCodeTo']))) {   
    //     $aCells = [
    //         WriterEntityFactory::createCell($this->aText['tRptCstFrom'].' : '.$this->aRptFilter['tCstCodeFrom'].' '.$this->aText['tRptCstTo'].' : '.$this->aRptFilter['tCstCodeTo']),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         WriterEntityFactory::createCell(NULL),
    //         ];
    //         $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
    //   }

      if ((isset($this->aRptFilter['tAccNoFrom']) && !empty($this->aRptFilter['tAccNoFrom'])) && (isset($this->aRptFilter['tAccNoTo']) && !empty($this->aRptFilter['tAccNoTo']))) {   
        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRptBnkdplBnkAccFrom'].' : '.$this->aRptFilter['tAccNoFrom'].' '.$this->aText['tRptBnkdplBnkAccTo'].' : '.$this->aRptFilter['tAccNoTo']),
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

