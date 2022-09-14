
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

class Rptpssdailybyschn_controller extends MX_Controller
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

    public function __construct(){
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsale/Rptpssdailybyschn_model');

        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText = [

            'tTitleReport' => language('report/report/report', 'tRptPSSDailyBySChnBerTitle'),
            'tDatePrint' => language('report/report/report', 'tRptDailySalePosSvPrint'),
            'tTimePrint' => language('report/report/report', 'tRptDailySalePosSvTime'),
            'tRptTaxSalePosTaxId' => language('report/report/report', 'tRptTaxSalePosTaxId'),

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
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),
            'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
            'tRptTel' => language('report/report/report', 'tRptTel'),

            'tRptTaxSaleLockerFilterDocDateFrom' => language('report/report/report', 'tRptTaxSaleLockerFilterDocDateFrom'),
            'tRptTaxSaleLockerFilterDocDateTo' => language('report/report/report', 'tRptTaxSaleLockerFilterDocDateTo'),
            'tRptTaxSaleLockerFilterShopFrom' => language('report/report/report', 'tRptTaxSaleLockerFilterShopFrom'),
            'tRptTaxSaleLockerFilterShopTo' => language('report/report/report', 'tRptTaxSaleLockerFilterShopTo'),

            //Header Columns
            'tRptSDPSales' => language('report/report/report', 'tRptSDPSales'),
            'tRptPaymentType' => language('report/report/report', 'tRptPaymentType'),
            'tRptSDPRoundingAmount' => language('report/report/report', 'tRptSDPRoundingAmount'),
            'tRptSDPNetSales'       => language('report/report/report', 'tRptSDPNetSales'),
            'tRptSales'             => language('report/report/report', 'tRptSales'),
            'tRptSalePos'           => language('report/report/report', 'tRptSalePos'),
            'tRptXshReturn'         => language('report/report/report', 'tRptXshReturn'),
            'tRptCashier'           => language('report/report/report', 'tRptCashier'),
            'tRptSaleType'          => language('report/report/report', 'tRptSaleType'),
            'tRptRndVal'            => language('report/report/report', 'tRptRndVal'),
            'tRptXshGrand'          => language('report/report/report', 'tRptXshGrand'),
            'tRptTaxSaleLockerNoData' => language('report/report/report', 'tRptTaxSaleLockerNoData'),
            'tRptTaxSalePosSale'    => language('report/report/report', 'tRptTaxSalePosSale'),
            'tRptSaleDailyByPos'    => language('report/report/report', 'tRptSaleDailyByPos'),
            'tRptPayType'           => language('report/report/report', 'tRptPayType'),
            'tRptPayType1'          => language('report/report/report', 'tRptPayType1'),
            'tRptPayType2'          => language('report/report/report', 'tRptPayType2'),
            'tRptPayType3'          => language('report/report/report', 'tRptPayType3'),
            'tRptPayType4'          => language('report/report/report', 'tRptPayType4'),
            'tRptAdjPosFrom'        => language('report/report/report', 'tRptAdjPosFrom'),
            'tRptAdjPosTo'          => language('report/report/report', 'tRptAdjPosTo'),
            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom'           => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'             => language('report/report/report', 'tRptPosTo'),
            'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
            'tRptRcvFrom'           => language('report/report/report', 'tRptRcvFrom'),
            'tRptRcvTo'             => language('report/report/report', 'tRptRcvTo'),
            'tRptAdjShopFrom'       => language('report/report/report', 'tRptAdjShopFrom'),
            'tRptAdjShopTo'         => language('report/report/report', 'tRptAdjShopTo'),
            'tRptYear'              => language('report/report/report', 'tRptYear'),
            'tRptTaxSalePosNoData'  => language('common/main/main', 'tCMNNotFoundData'),
            'tRptAll'               => language('common/main/main', 'tRptAll'),
            'tRptDatePrint'         => language('report/report/report', 'tRptDatePrint'),
            'tRptTimePrint'         => language('report/report/report', 'tRptTimePrint'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
            'tRptCstFrom'           => language('report/report/report', 'tRptCstFrom'),
            'tRptCstTo'             => language('report/report/report', 'tRptCstTo'),
            'tPdtCodeFrom'          => language('report/report/report', 'tPdtCodeFrom'),
            'tPdtCodeTo'            => language('report/report/report', 'tPdtCodeTo'),
            'tPdtTypeFrom'          => language('report/report/report', 'tPdtTypeFrom'),
            'tPdtTypeTo'            => language('report/report/report', 'tPdtTypeTo'),
            'tRptPosTypeName'       => language('report/report/report', 'tRptPosTypeName'),
            'tRptPosType'           => language('report/report/report', 'tRptPosType'),
            'tRptCashierFrom'       => language('report/report/report', 'tRptCashierFrom'),
            'tRptCashierTo'         => language('report/report/report', 'tRptCashierTo'),
            'tRptNameBCH'           => language('report/report/report', 'tRPC15TBBchName'),
            'tRptPSSno'             => language('report/report/report','tRptPSSno'),
            'tRptPSSDate'           => language('report/report/report','tRptPSSDate'),
            'tRptPSSBill'           => language('report/report/report','tRptPSSBill'),
            'tRptPSSRefDoc'         => language('report/report/report','tRptPSSRefDoc'),
            'tRptPSSCus'            => language('report/report/report','tRptPSSCus'),
            'tRptPSSRemark'         => language('report/report/report','tRptPSSRemark'),
            'tRptPSSValues'         => language('report/report/report','tRptPSSValues'),
            'tRptPSSVat'            => language('report/report/report','tRptPSSVat'),
            'tRptPSSUnVat'          => language('report/report/report','tRptPSSUnVat'),
            'tRptPSSRnd'            => language('report/report/report','tRptPSSRnd'),
            'tRptPSSSum'             => language('report/report/report','tRptPSSSum'),
            'tRptNameBCH'           => language('report/report/report', 'tRPC15TBBchName'),
            'tRptChnFrom'           => language('report/report/report', 'tRptChnFrom'),
            'tRptChnTo'             => language('report/report/report', 'tRptChnTo'),
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
        $this->nFilterType      = $this->input->post('ohdTypeDataCondition');

        // Report Filter
        $this->aRptFilter = [

            'tUserSession'      => $this->tUserSessionID,
            'tCompName'         => $tFullHost,
            'tRptCode'          => $this->tRptCode,
            'nLangID'           => $this->nLngID,
            'nFilterType'       => $this->nFilterType,

            'tTypeSelect'   => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // สาขา(Branch)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า
            'tShpCodeFrom'      => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'      => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'        => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'        => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // เครื่องจุดขาย
            'tRptPosCodeFrom'   => !empty($this->input->post('oetRptPosCodeFrom')) ? $this->input->post('oetRptPosCodeFrom') : "",
            'tRptPosNameFrom'   => !empty($this->input->post('oetRptPosNameFrom')) ? $this->input->post('oetRptPosNameFrom') : "",
            'tRptPosCodeTo'     => !empty($this->input->post('oetRptPosCodeTo')) ? $this->input->post('oetRptPosCodeTo') : "",
            'tRptPosNameTo'     => !empty($this->input->post('oetRptPosNameTo')) ? $this->input->post('oetRptPosNameTo') : "",
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // แคชเชียร์
            'tCashierCodeFrom'      => !empty($this->input->post('oetRptCashierCodeFrom')) ? $this->input->post('oetRptCashierCodeFrom') : "",
            'tCashierNameFrom'      => !empty($this->input->post('oetRptCashierNameFrom')) ? $this->input->post('oetRptCashierNameFrom') : "",
            'tCashierCodeTo'        => !empty($this->input->post('oetRptCashierCodeTo')) ? $this->input->post('oetRptCashierCodeTo') : "",
            'tCashierNameTo'        => !empty($this->input->post('oetRptCashierNameTo')) ? $this->input->post('oetRptCashierNameTo') : "",
            'tCashierCodeSelect'    => !empty($this->input->post('oetRptCashierCodeSelect')) ? $this->input->post('oetRptCashierCodeSelect') : "",
            'tCashierNameSelect'    => !empty($this->input->post('oetRptCashierNameSelect')) ? $this->input->post('oetRptCashierNameSelect') : "",
            'bCashierStaSelectAll'  => !empty($this->input->post('oetRptCashierStaSelectAll')) && ($this->input->post('oetRptCashierStaSelectAll') == 1) ? true : false,

            // ลูกค้า
            'tCstCodeFrom' => !empty($this->input->post('oetRptCstCodeFrom')) ? $this->input->post('oetRptCstCodeFrom') : "",
            'tCstNameFrom' => !empty($this->input->post('oetRptCstNameFrom')) ? $this->input->post('oetRptCstNameFrom') : "",
            'tCstCodeTo' => !empty($this->input->post('oetRptCstCodeTo')) ? $this->input->post('oetRptCstCodeTo') : "",
            'tCstNameTo' => !empty($this->input->post('oetRptCstNameTo')) ? $this->input->post('oetRptCstNameTo') : "",
            'tCstCodeSelect' => !empty($this->input->post('oetRptCstCodeSelect')) ? $this->input->post('oetRptCstCodeSelect') : "",
            'tCstNameSelect' => !empty($this->input->post('oetRptCstNameSelect')) ? $this->input->post('oetRptCstNameSelect') : "",
            'bCstStaSelectAll' => !empty($this->input->post('oetRptCstStaSelectAll')) && ($this->input->post('oetRptCstStaSelectAll') == 1) ? true : false,

            // ปี
            'tRptYear'              => !empty($this->input->post('oetRptYear')) ? $this->input->post('oetRptYear') : "",

            // ช่องทางการขาย
            'tChnCodeFrom'  => !empty($this->input->post('oetRptSalesChanelCodeFrom')) ? $this->input->post('oetRptSalesChanelCodeFrom') : "",
            'tChnNameFrom'  => !empty($this->input->post('oetRptSalesChanelNameFrom')) ? $this->input->post('oetRptSalesChanelNameFrom') : "",
            'tChnCodeTo'    => !empty($this->input->post('oetRptSalesChanelCodeTo')) ? $this->input->post('oetRptSalesChanelCodeTo') : "",
            'tChnNameTo'    => !empty($this->input->post('oetRptSalesChanelNameTo')) ? $this->input->post('oetRptSalesChanelNameTo') : "",

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'          => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'            => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin,
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index(){
        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {

            // Call Stored Procedure
            $this->Rptpssdailybyschn_model->FSnMExecStoreReport($this->aRptFilter);

            // Report Type
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
     * Creator: 23/12/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint(){
        try {
            $aDataReportParams = [
                'nPerPage'      => $this->nPerPage,
                'nPage'         => $this->nPage,
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aDataFilter'   => $this->aRptFilter,
            ];

            //Get Data
            $aDataReport = $this->Rptpssdailybyschn_model->FSaMGetDataReport($aDataReportParams);

            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow'   => $this->nOptDecimalShow,
                'aCompanyInfo'      => $this->aCompanyInfo,
                'aDataReport'       => $aDataReport,
                'aDataTextRef'      => $this->aText,
                'aDataFilter'       => $this->aRptFilter,
            ];

            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptPSSDailyBySChn', 'wRptxPSSDailyBySChnHtml', $aDataViewRptParams);

            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport'      => $this->aText['tTitleReport'],
                'tRptTypeExport'    => $this->tRptExportType,
                'tRptCode'          => $this->tRptCode,
                'tRptRoute'         => $this->tRptRoute,
                'tViewRenderKool'   => $tRptView,
                'aDataFilter'       => $this->aRptFilter,
                'aDataReport'       => [
                    'raItems'       => $aDataReport['aRptData'],
                    'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode'        => '1',
                    'rtDesc'        => 'success',
                ],
            ];

            $this->load->view('report/report/wReportViewer', $aDataViewerParams);
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/10/2562 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage(){
        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        $aDataWhere = array(
            'tUserSession'  => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tUserCode'     => $this->tUserLoginCode,
            'tRptCode'      => $this->tRptCode,
            'nPage'         => $this->nPage,
            'nRow'          => $this->nPerPage,
            'nPerPage'      => $this->nPerPage,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter'   => $aDataFilter,
        );

        //Get Data
        $aDataReport = $this->Rptpssdailybyschn_model->FSaMGetDataReport($aDataWhere, $aDataFilter);

        $aDataViewRptParams = [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aDataFilter'       => $aDataFilter,
        ];

        $tViewRenderKool = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptPSSDailyBySChn', 'wRptxPSSDailyBySChnHtml', $aDataViewRptParams);

        // Data Viewer Center Report
        $aDataView = [
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => [
                'raItems'       => $aDataReport['aRptData'],
                'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            ],
        ];

        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 24/12/2562 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSoCChkDataReportInTableTemp(){
        try {

            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aDataFilter' => $this->aRptFilter,
            ];

            $nDataCountPage = $this->Rptpssdailybyschn_model->FSnMCountRowInTemp($aDataCountData);

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
     * Creator: 24/12/2019 Witsarut (BEll)
     * LastUpdate: 02/10/2019 Saharat(Golf)
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile(){

    }

    /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 29/09/2020 Sooksanti
     * LastUpdate:
     * Return: file
     * ReturnType: file
     */
    public function FSvCCallRptRenderExcel(){
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
            ->setFontSize(12)
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
            ->build();

        $oStyleBold = (new StyleBuilder())
            ->setFontBold()
            ->setFontSize(12)
            ->build();
        // $aCells = [
        //     WriterEntityFactory::createCell(language('report/report/report', 'tRPC15TBBchName')),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(language('report/report/report', 'tRptSalePoint')),
        //     WriterEntityFactory::createCell(null),
        //
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null, $oStyleColumsRight),
        //
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(language('report/report/report', 'tRptSaleType')),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null),
        //     WriterEntityFactory::createCell(null, $oStyleColumsRight),
        // ];
        //
        // /** add a row at a time */
        // $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums,$oStyleBold);
        // $oWriter->addRow($singleRow);

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSno')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSBill')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSRefDoc')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSCus')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSRemark')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSValues'),$oStyleColumsRight),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSVat'),$oStyleColumsRight),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSUnVat'),$oStyleColumsRight),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSRnd'),$oStyleColumsRight),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPSSSum'),$oStyleColumsRight),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),









            //WriterEntityFactory::createCell(null, $oStyleColumsRight),

            // WriterEntityFactory::createCell(language('report/report/report', 'tRptSales')),
            // WriterEntityFactory::createCell(null, $oStyleColumsRight),
            // WriterEntityFactory::createCell(language('report/report/report', 'tRptXshReturn')),
            // WriterEntityFactory::createCell(null, $oStyleColumsRight),
            // WriterEntityFactory::createCell(language('report/report/report', 'tRptRndVal')),
            // WriterEntityFactory::createCell(null, $oStyleColumsRight),
            // WriterEntityFactory::createCell(language('report/report/report', 'tRptXshGrand')),
            // WriterEntityFactory::createCell(null, $oStyleColumsRight),
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
            'aDataFilter' => $this->aRptFilter,
        ];

        //Get Data
        $aDataReport = $this->Rptpssdailybyschn_model->FSaMGetDataReport($aDataReportParams);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            $tFTPosCode = '';
            $aNewData = array();
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
              // print_r($aDataReport['aRptData'][$nKey]);
              // echo "<hr />";
               if (isset($aNewData[$aValue['FTPosCode']])) {
                  if (isset($aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']])) {
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                      'FTCstCode' => $aValue['FTCstCode'],
                      'FTXshRmk' => $aValue['FTXshRmk'],
                      'FCXshVatable' => $aValue['FCXshVatable'],
                      'FCXshVat' => $aValue['FCXshVat'],
                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                      'FCXshRnd' => $aValue['FCXshRnd'],
                      'FCXshGrand' => $aValue['FCXshGrand']
                    );
                  }else {
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'] = array();
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                      'FTCstCode' => $aValue['FTCstCode'],
                      'FTXshRmk' => $aValue['FTXshRmk'],
                      'FCXshVatable' => $aValue['FCXshVatable'],
                      'FCXshVat' => $aValue['FCXshVat'],
                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                      'FCXshRnd' => $aValue['FCXshRnd'],
                      'FCXshGrand' => $aValue['FCXshGrand']
                    );
                  }
               }else {
                  $aNewData[$aValue['FTPosCode']] = array();
                  if (isset($aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']])) {
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                      'FTCstCode' => $aValue['FTCstCode'],
                      'FTXshRmk' => $aValue['FTXshRmk'],
                      'FCXshVatable' => $aValue['FCXshVatable'],
                      'FCXshVat' => $aValue['FCXshVat'],
                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                      'FCXshRnd' => $aValue['FCXshRnd'],
                      'FCXshGrand' => $aValue['FCXshGrand']
                    );
                  }else {
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'] = array();
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                      'FTCstCode' => $aValue['FTCstCode'],
                      'FTXshRmk' => $aValue['FTXshRmk'],
                      'FCXshVatable' => $aValue['FCXshVatable'],
                      'FCXshVat' => $aValue['FCXshVat'],
                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                      'FCXshRnd' => $aValue['FCXshRnd'],
                      'FCXshGrand' => $aValue['FCXshGrand']
                    );
                  }
               }

            }

            foreach ($aNewData as $tKey => $aValue) {
              $values = [
                WriterEntityFactory::createCell("เครื่องจุดขาย : ".$tKey),
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
              ];
              $aRow = WriterEntityFactory::createRow($values);
              $oWriter->addRow($aRow);
              foreach ($aNewData[$tKey] as $tTkey => $value) {
                  $values = [
                    WriterEntityFactory::createCell("ช่องทางการขาย : ".$tTkey." ".$aNewData[$tKey][$tTkey]['Name']),
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
                  ];
                  $aRow = WriterEntityFactory::createRow($values);
                  $oWriter->addRow($aRow);
                  $nRow = 1;
                  foreach ($aNewData[$tKey][$tTkey]['aValues'] as $nkeys => $tValues) {
                    $tDocDate  = substr($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FDXshDocDate'],0,10);
                    $values = [
                      WriterEntityFactory::createCell($nRow++),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell($tDocDate),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTXshDocNo']),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTXshRefInt']),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTCstCode']),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTXshRmk']),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),

                      WriterEntityFactory::createCell(FCNnGetNumeric($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshVatable'])),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(FCNnGetNumeric($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshVat'])),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(FCNnGetNumeric($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshAmtNV'])),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(FCNnGetNumeric($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshRnd'])),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(null),
                      WriterEntityFactory::createCell(FCNnGetNumeric($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshGrand'])),
                      WriterEntityFactory::createCell(null),
                    ];
                    $aRow = WriterEntityFactory::createRow($values);
                    $oWriter->addRow($aRow);
                  }
                }
            }


            // foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
            //     $values = [
            //       WriterEntityFactory::createCell(1),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //       WriterEntityFactory::createCell(null),
            //
            //         // WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshNet'])),
            //         // WriterEntityFactory::createCell(null),
            //         // WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshReturn'])),
            //         // WriterEntityFactory::createCell(null),
            //         // WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshRnd'])),
            //         // WriterEntityFactory::createCell(null),
            //         // WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshGrand'])),
            //         // WriterEntityFactory::createCell(null),
            //     ];
            //     $aRow = WriterEntityFactory::createRow($values);
            //     $oWriter->addRow($aRow);
            // }
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
                WriterEntityFactory::createCell($this->aText['tRptDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
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
    public function FSoCCallRptRenderFooterExcel(){
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

        // ช่องทางการขาย แบบช่วง
        if (!empty($this->aRptFilter['tChnCodeFrom']) && !empty($this->aRptFilter['tChnCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptChnFrom'] . ' : ' . $this->aRptFilter['tChnNameFrom'] . '     ' . $this->aText['tRptChnTo'] . ' : ' . $this->aRptFilter['tChnNameTo']),
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
        // if (!empty($this->aRptFilter['tShpCodeFrom']) && !empty($this->aRptFilter['tShpCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptShopFrom'] . ' : ' . $this->aRptFilter['tShpNameFrom'] . '     ' . $this->aText['tRptShopTo'] . ' : ' . $this->aRptFilter['tShpNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // Fillterฺ Mar (กลุ่มธุรกิจ) แบบช่วง
        // if (!empty($this->aRptFilter['tMerCodeFrom']) && !empty($this->aRptFilter['tMerCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptMerFrom'] . ' : ' . $this->aRptFilter['tMerNameFrom'] . '     ' . $this->aText['tRptMerTo'] . ' : ' . $this->aRptFilter['tMerNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // เครื่องจุดขาย แบบช่วง
        // if (!empty($this->aRptFilter['tPosCodeFrom']) && !empty($this->aRptFilter['tPosCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptTaxSalePosFilterPosFrom'] . ' ' . $this->aRptFilter['tPosNameFrom'] . '     ' . $this->aText['tRptTaxSalePosFilterPosTo'] . ' ' . $this->aRptFilter['tPosNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // Fillter Prodict (สินค้า) แบบช่วง
        // if (!empty($this->aRptFilter['tPdtCodeFrom']) && !empty($this->aRptFilter['tPdtCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tPdtCodeFrom'] . ' : ' . $this->aRptFilter['tPdtNameFrom'] . '     ' . $this->aText['tPdtCodeTo'] . ' : ' . $this->aRptFilter['tPdtNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // Fillter Product Group (กลุ่มสินค้า)  แบบช่วง
        // if (!empty($this->aRptFilter['tPdtGrpCodeFrom']) && !empty($this->aRptFilter['tPdtGrpCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tPdtGrpFrom'] . ' : ' . $this->aRptFilter['tPdtGrpNameFrom'] . '     ' . $this->aText['tPdtGrpTo'] . ' : ' . $this->aRptFilter['tPdtGrpNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // Fillter Product Type (ประเภทสินค้า)  แบบช่วง
        // if (!empty($this->aRptFilter['tPdtTypeCodeFrom']) && !empty($this->aRptFilter['tPdtTypeCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tPdtTypeFrom'] . ' : ' . $this->aRptFilter['tPdtTypeNameFrom'] . '     ' . $this->aText['tPdtTypeTo'] . ' : ' . $this->aRptFilter['tPdtTypeNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // ฟิวเตอร์ข้อมูล ประเภทจุดขาย
        // if (isset($this->aRptFilter['tPosType'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptPosTypeName'] . ' : ' . $this->aText['tRptPosType' . $this->aRptFilter['tPosType']]),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }

        // if (!empty($this->aRptFilter['tCashierCodeFrom']) && !empty($this->aRptFilter['tCashierCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptCashierFrom'] . ' : ' . $this->aRptFilter['tCashierNameFrom'] . '     ' . $this->aText['tRptCashierTo'] . ' : ' . $this->aRptFilter['tCashierNameTo']),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //         WriterEntityFactory::createCell(null),
        //     ];
        //     $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        // }
        return $aMulltiRow;

    }
}
