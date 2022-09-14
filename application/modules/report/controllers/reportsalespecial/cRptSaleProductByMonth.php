<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

date_default_timezone_set("Asia/Bangkok");
class cRptSaleProductByMonth extends MX_Controller {

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
        $this->load->model('report/reportsalespecial/mRptSaleProductByMonth');
        $this->load->model('report/report/mReport');
        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init() {
        $this->aText = [
            'tTitleReport'          => language('report/report/report', 'tRptSaleProductByMonth'),
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

            // Table Report
            'tRptCrPos'             => language('report/report/report', 'tRptCrPos'),
            'tRptCrTaxNumber'       => language('report/report/report', 'tRptCrTaxNumber'),
            'tRptCrSaleDate'        => language('report/report/report', 'tRptCrSaleDate'),
            'tRptCrPaymentType'     => language('report/report/report', 'tRptCrPaymentType'),
            'tRptCrProduct'         => language('report/report/report', 'tRptCrProduct'),
            'tRptCrNet'             => language('report/report/report', 'tRptCrNet'),
            'tRptCrPrice'           => language('report/report/report', 'tRptCrPrice'),
            'tRptCrVat'             => language('report/report/report', 'tRptCrVat'),
            'tRptCrTotal'           => language('report/report/report', 'tRptCrTotal'),
            'tRptCrDescription'     => language('report/report/report', 'tRptCrDescription'),
            'tRptCrHnNumber'        => language('report/report/report', 'tRptCrHnNumber'),
            'tRptCrCtzID'           => language('report/report/report', 'tRptCrCtzID'),
            'tRptCrCstName'         => language('report/report/report', 'tRptCrCstName'),
            'tRptCrCstlName'        => language('report/report/report', 'tRptCrCstlName'),
            'tRptCrCstTel'          => language('report/report/report', 'tRptCrCstTel'),
            'tRptCrCstDescription'  => language('report/report/report', 'tRptCrCstDescription'),

            // Filter Heard Report
            'tRptRcvFrom'           => language('report/report/report', 'tRptRcvFrom'),
            'tRptRcvTo'             => language('report/report/report', 'tRptRcvTo'),
            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tPdtCodeFrom'          => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo'            => language('report/report/report', 'tPdtCodeTo'),
            'tPdtGrpFrom'           => language('report/report/report', 'tPdtGrpFrom'),
            'tPdtGrpTo'             => language('report/report/report', 'tPdtGrpTo'),
            'tPdtTypeFrom'          => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'            => language('report/report/report', 'tPdtTypeTo'),
            'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
            'tRptReason'            => language('report/report/report', 'tRptReason'),

            // Table Label
            'tRptBillNo'            => language('report/report/report', 'tRptBillNo'),
            'tRptPriceGrand'        => language('report/report/report', 'tRptPriceGrand'),
            'tRptRentBillAmount'    => language('report/report/report', 'tRptRentBillAmount'),
            'tRptDate'              => language('report/report/report', 'tRptDate'),
            'tRptProduct'           => language('report/report/report', 'tRptProduct'),
            'tRptCabinetnumber'     => language('report/report/report', 'tRptCabinetnumber'),
            'tRptPrice'             => language('report/report/report', 'tRptPrice'),
            'tRptSales'             => language('report/report/report', 'tSales'),
            'tRptDiscount'          => language('report/report/report', 'tDiscount'),
            'tRptTax'               => language('report/report/report', 'tRptTax'),
            'tRptGrand'             => language('report/report/report', 'tRptGrand'),
            'tRptTotalSub'          => language('report/report/report', 'tRptTotalSub2'),
            'tRptTotalFooter'       => language('report/report/report', 'tRptTotalFooter'),
            'tRptSRCCouponCardNumber' =>language('report/report/report','tRptSRCCouponCardNumber'),
            'tRptSRCNumber'         =>language('report/report/report','tRptSRCNumber'),
            'tRptSRCBank'           =>language('report/report/report','tRptSRCBank'),
            'tRptTotal'             =>language('report/report/report','tRptTotal'),

            'tRptSRCCash'           =>language('report/report/report','tRptSRCCash'),
            'tRptSRCCredit'         =>language('report/report/report','tRptSRCCredit'),
            'tRptSRCOther'          =>language('report/report/report','tRptSRCOther'),
            'tRptSRCPromtpay'       =>language('report/report/report','tRptSRCPromtpay'),
            'tRptSRCAlipay'         =>language('report/report/report','tRptSRCAlipay'),
            'tRptTaxSalePosTaxId'   => language('report/report/report', 'tRptTaxSalePosTaxId'),
            "tRptAdjStkNoData"      => language('report/report/report','tRptAdjStkNoData'),
            // No Data Report
            'tRptNoData'            => language('common/main/main', 'tCMNNotFoundData'),
            'tRptPosTypeName'       => language('common/main/main', 'tRptPosTypeName'),
            'tRptPosType'           => language('common/main/main', 'tRptPosType'),
            'tRptPosType1'          => language('common/main/main', 'tRptPosType1'),
            'tRptPosType2'          => language('common/main/main', 'tRptPosType2'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),

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
            'tRptAll'               => language('report/report/report', 'tRptAll'),

            // Lang เดือน
            'tRptMonth01'           => language('report/report/report','tRptMonth01'),
            'tRptMonth02'           => language('report/report/report','tRptMonth02'),
            'tRptMonth03'           => language('report/report/report','tRptMonth03'),
            'tRptMonth04'           => language('report/report/report','tRptMonth04'),
            'tRptMonth05'           => language('report/report/report','tRptMonth05'),
            'tRptMonth06'           => language('report/report/report','tRptMonth06'),
            'tRptMonth07'           => language('report/report/report','tRptMonth07'),
            'tRptMonth08'           => language('report/report/report','tRptMonth08'),
            'tRptMonth09'           => language('report/report/report','tRptMonth09'),
            'tRptMonth10'           => language('report/report/report','tRptMonth10'),
            'tRptMonth11'           => language('report/report/report','tRptMonth11'),
            'tRptMonth12'           => language('report/report/report','tRptMonth12'),

            'tRptSaleSubProductByDay'       => language('report/report/report', 'tRptSaleSubProductByDay'),
            'tRptSalePDTByDayType'          => language('report/report/report', 'tRptSalePDTByDayType'),
            'tRptSalePDTByDayTypeFrom'      => language('report/report/report', 'tRptSalePDTByDayTypeFrom'),
            'tRptSalePDTByDayTypeTo'        => language('report/report/report', 'tRptSalePDTByDayTypeTo'),
            'tRptSaleTypeSalePaymentAll'    => language('report/report/report', 'tRptSaleTypeSalePaymentAll'),
            'tRptSalePDTMonthBetweenFrom'   => language('report/report/report', 'tRptSalePDTMonthBetweenFrom'),
            'tRptSalePDTMonthBetweenTo'     => language('report/report/report', 'tRptSalePDTMonthBetweenTo'),
            'tRptSalePDTMonthTotal'         => language('report/report/report', 'tRptSalePDTMonthTotal'),
            'tRptMonthOnly'                 => language('report/report/report', 'tRptMonthOnly'),
            'tRptSalePDTMonthResult'        => language('report/report/report', 'tRptSalePDTMonthResult')
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
        $this->nPosType         = $this->input->post('ocmPosType');

        // Report Filter
        $this->aRptFilter = [
            'tUserSession'          => $this->tUserSessionID,
            'tCompName'             => $tFullHost,
            'tRptCode'              => $this->tRptCode,
            'nLangID'               => $this->nLngID,
            'tTypeSelect'           => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // สาขา(Branch)
            'tBchCodeFrom'         => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'         => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'           => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'           => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'       => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'       => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'     => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom'         => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'         => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'           => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'           => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'       => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'       => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'     => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

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
            
            // ประเภทการชำระ
            'tPosTypeFrom'      => !empty($this->input->post('ocmPosTypeFrom')) ? $this->input->post('ocmPosTypeFrom') : "",
            'tPosTypeTo'        => !empty($this->input->post('ocmPosTypeTo')) ? $this->input->post('ocmPosTypeTo') : "",

            // ปี
            'tYear'             => !empty($this->input->post('oetRptYear')) ? $this->input->post('oetRptYear') : "",

            //ช่วงเดือน
            'tMonthFrom'        => !empty($this->input->post('ocmRptMonthFrom')) ? $this->input->post('ocmRptMonthFrom') : "",
            'tMonthTo'          => !empty($this->input->post('ocmRptMonthTo')) ? $this->input->post('ocmRptMonthTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if (!empty($this->tRptExportType) && !empty($this->tRptCode)) {
            $aDataSwitchCase = array(
                'ptRptRoute'        => $this->tRptRoute,
                'ptRptCode'         => $this->tRptCode,
                'ptRptTypeExport'   => $this->tRptExportType,
                'paDataFilter'      => $this->aRptFilter
            );

            //Execute Stored Procedure
            $this->mRptSaleProductByMonth->FSnMExecStoreReport($this->aRptFilter);

            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp($aDataSwitchCase);
                    break;
                case 'pdf':
                    break;
            }
        }
    }

    /**
     * Functionality    : ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters       : Function Parameter
     * Creator          : 19/12/2019 supawat
     * LastUpdate       : 
     * Return           : View Report Viewer
     * ReturnType       : View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'          => $this->nPerPage,
            'nPage'             => 1, // เริ่มรายงานหน้าแรก
            'tCompName'         => $this->tCompName,
            'tRptCode'          => $this->tRptCode,
            'tUsrSessionID'     => $this->tUserSessionID,
            'paDataFilter'      => $paDataSwitchCase['paDataFilter']
        );
        $aDataReport = $this->mRptSaleProductByMonth->FSaMGetDataReport($aDataWhereRpt);

        $aReportGroup           = array();
        $aReportGroupBnk        = array();
        $aReportGroupBnklist    = array();
        $aReportGroupBnkSum     = 0;
        $nOther                 = 0;
        $paFooterSumData        = array();
       
        // ข้อมูล Render Report
        $aDataViewPdt = array(
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataFilter'       => $paDataSwitchCase['paDataFilter'],
            'paFooterSumData'   => $paFooterSumData,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptsaleproductbymonth', 'wRptSaleProductByMonthHtml', $aDataViewPdt);

        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tRptView,
            'aDataFilter'       => $paDataSwitchCase['paDataFilter'],
            'aDataReport'       => array(
                    'raItems'       => $aDataReport['aRptData'],
                    'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    /**
     * Functionality    : Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters       : Function Parameter
     * Creator          : 19/12/2019 supawat
     * LastUpdate       : 
     * Return           : View Report Viewer
     * ReturnType       : View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {
        $tRptRoute      = $this->input->post('ohdRptRoute');
        $tRptCode       = $this->input->post('ohdRptCode');
        $tRptTypeExport = $this->input->post('ohdRptTypeExport');
        $aDataFilter    = json_decode($this->input->post('ohdRptDataFilter'), true);
        $nPage          = $this->input->post('ohdRptCurrentPage');
        $nLangEdit      = $this->session->userdata("tLangEdit");

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'          => $this->nPerPage,
            'nPage'             => $this->nPage,
            'tCompName'         => $this->tCompName,
            'tRptCode'          => $this->tRptCode,
            'tUsrSessionID'     => $this->tUserSessionID,
            'paDataFilter'      => $aDataFilter
        );
        $aDataReport = $this->mRptSaleProductByMonth->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewPdt = array(
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataFilter'       => $aDataFilter,
            'nOptDecimalShow'   => $this->nOptDecimalShow
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptsaleproductbymonth', 'wRptSaleProductByMonthHtml', $aDataViewPdt);

        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tRptView,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => array(
                    'raItems'       => $aDataReport['aRptData'],
                    'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode'        => '1',
                    'rtDesc'        => 'success'
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }
 

    /**
     * Functionality    : Click Page Report (Report Viewer)
     * Parameters       : Function Parameter
     * Creator          : 19/12/2019 supawat
     * LastUpdate       : 
     * Return           : object Status Count Data Report
     * ReturnType       : Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase) {
        try {
            $aDataCountData = [
                'tCompName'     => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode'      => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tUserSession'  => $paDataSwitchCase['paDataFilter']['tUserSession'],
            ];
            $nDataCountPage = $this->mRptSaleProductByMonth->FSnMCountDataReportAll($aDataCountData);
            $aResponse = array(
                'nCountPageAll'     => $nDataCountPage,
                'nStaEvent'         => 1,
                'tMessage'          => 'Success Count Data All'
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage'  => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

    /**
     * Functionality    : Send Rabbit MQ Report
     * Parameters       : Function Parameter
     * Creator          : 19/12/2019 supawat
     * LastUpdate       : 
     * Return           : object Send Rabbit MQ Report
     * ReturnType       : Object
     */
    public function FSvCCallRptExportFile() {

        try {
            $dDateSendMQ        = date('Y-m-d');
            $dTimeSendMQ        = date('H:i:s');
            $dDateSubscribe     = date('Ymd');
            $dTimeSubscribe     = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;
            $aDataSendMQ = [
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

            $aResponse = array(
                'nStaEvent'             => 1,
                'tMessage'              => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode'      => $this->tSysBchCode,
                    'ptComName'         => $this->tCompName,
                    'ptRptCode'         => $this->tRptCode,
                    'ptUserCode'        => $this->tUserLoginCode,
                    'ptUserSessionID'   => $this->tUserSessionID,
                    'pdDateSubscribe'   => $dDateSubscribe,
                    'pdTimeSubscribe'   => $dTimeSubscribe,
                )
            );
        } catch (Exception $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage'  => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

}
