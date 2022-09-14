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

class cRptTaxSalePosByDateFull extends MX_Controller
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
        $this->load->model('report/reportsale/mRptTaxSalePosByDateFull');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init()
    {
        $this->aText = [
            'tTitleReport' => language('report/report/report', 'tRptTaxSalePosByDateFullTitle'),
            'tDatePrint' => language('report/report/report', 'tRptTaxSalePosByDateFullDatePrint'),
            'tTimePrint' => language('report/report/report', 'tRptTaxSalePosByDateFullTimePrint'),

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
            'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
            'tRptTel' => language('report/report/report', 'tRptTel'),
            // Table Label
            'tRptTaxSalePosByDateDocNo' => language('report/report/report', 'tRptTaxSalePosByDateDocNo'),
            'tRptTaxSalePosByDateDocDate' => language('report/report/report', 'tRptTaxSalePosByDateDocDate'),
            'tRptTaxSalePosByDateDateAndLocker' => language('report/report/report', 'tRptTaxSalePosByDateDateAndLocker'),
            'tRptTaxSalePosByDatePayTypeAndDocRef' => language('report/report/report', 'tRptTaxSalePosByDatePayTypeAndDocRef'),
            'tRptTaxSalePosByDateDocRef' => language('report/report/report', 'tRptTaxSalePosByDateDocRef'),
            'tRptTaxSalePosByDatePayment' => language('report/report/report', 'tRptTaxSalePosByDatePayment'),
            'tRptTaxSalePosByDatePaymentTotal' => language('report/report/report', 'tRptTaxSalePosByDatePaymentTotal'),
            'tRptTaxSalePosByDatePosGrouping' => language('report/report/report', 'tRptTaxSalePosByDatePosGrouping'),
            'tRptTaxSalePosByDatePos' => language('report/report/report', 'tRptTaxSalePosByDatePos'),

            // No Data Report
            'tRptTaxSalePosByDateNoData' => language('common/main/main', 'tCMNNotFoundData'),
            'tRptTaxSalePosByDateTotalSub' => language('report/report/report', 'tRptTaxSalePosByDateTotalSub'),
            'tRptTaxSalePosByDateTotalFooter' => language('report/report/report', 'tRptTaxSalePosByDateTotalFooter'),

            // Filter Text Label
            'tRptTaxSalePosByDateFilterBchFrom' => language('report/report/report', 'tRptTaxSalePosByDateFilterBchFrom'),
            'tRptTaxSalePosByDateFilterBchTo' => language('report/report/report', 'tRptTaxSalePosByDateFilterBchTo'),
            'tRptTaxSalePosByDateFilterShopFrom' => language('report/report/report', 'tRptTaxSalePosByDateFilterShopFrom'),
            'tRptTaxSalePosByDateFilterShopTo' => language('report/report/report', 'tRptTaxSalePosByDateFilterShopTo'),
            'tRptTaxSalePosByDateFilterPosFrom' => language('report/report/report', 'tRptTaxSalePosByDateFilterPosFrom'),
            'tRptTaxSalePosByDateFilterPosTo' => language('report/report/report', 'tRptTaxSalePosByDateFilterPosTo'),
            'tRptTaxSalePosByDateFilterPayTypeFrom' => language('report/report/report', 'tRptTaxSalePosByDateFilterPayTypeFrom'),
            'tRptTaxSalePosByDateFilterPayTypeTo' => language('report/report/report', 'tRptTaxSalePosByDateFilterPayTypeTo'),
            'tRptTaxSalePosByDateFilterDocDateFrom' => language('report/report/report', 'tRptTaxSalePosByDateFilterDocDateFrom'),
            'tRptTaxSalePosByDateFilterDocDateTo' => language('report/report/report', 'tRptTaxSalePosByDateFilterDocDateTo'),

            // Text Label
            'tRptTaxSalePosByDateTel' => language('report/report/report', 'tRptTaxSalePosByDateTel'),
            'tRptTaxSalePosByDateFax' => language('report/report/report', 'tRptTaxSalePosByDateFax'),
            'tRptTaxSalePosByDateDatePrint' => language('report/report/report', 'tRptTaxSalePosByDateDatePrint'),
            'tRptTaxSalePosByDateTimePrint' => language('report/report/report', 'tRptTaxSalePosByDateTimePrint'),
            'tRptTaxSalePosByDateBch' => language('report/report/report', 'tRptTaxSalePosByDateBch'),
            'tRptDataReportNotFound' => language('report/report/report', 'tRptDataReportNotFound'),
            'tRptTaxSalePosByDateSeq' => language('report/report/report', 'tRptTaxSalePosByDateSeq'),
            'tRptTaxSalePosByDateCst' => language('report/report/report', 'tRptTaxSalePosByDateCst'),
            'tRptTaxSalePosByDateTaxID' => language('report/report/report', 'tRptTaxSalePosByDateTaxID'),
            'tRptTaxSalePosByDateComp' => language('report/report/report', 'tRptTaxSalePosByDateComp'),
            'tRptTaxSalePosByDateAmt' => language('report/report/report', 'tRptTaxSalePosByDateAmt'),
            'tRptTaxSalePosByDateAmtV' => language('report/report/report', 'tRptTaxSalePosByDateAmtV'),
            'tRptTaxSalePosByDateAmtNV' => language('report/report/report', 'tRptTaxSalePosByDateAmtNV'),
            'tRptTaxSalePosByDateTotal' => language('report/report/report', 'tRptTaxSalePosByDateTotal'),

            'tRptDocSale' => language('report/report/report', 'tRptDocSale'),
            'tRptDocReturn' => language('report/report/report', 'tRptDocReturn'),
            'tRptTaxSalePosSale' => language('report/report/report', 'tRptTaxSalePosSale'),
            'tRowNumber' => language('report/report/report', 'tRowNumber'),
            'tRptTaxSalePosTotalSub' => language('report/report/report', 'tRptTaxSalePosTotalSub'),
            'tRptTaxSalePosDistrict' => language('report/report/report', 'tRptTaxSalePosDistrict'),
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),

            //วันที่
            'tRptTaxSalePosDocDate' => language('report/report/report', 'tRptTaxSalePosDocDate'),
            'tRptTaxSalePosTaxMonth' => language('report/report/report', 'tRptTaxSalePosTaxMonth'),
            'tRptTaxSalePosYear' => language('report/report/report', 'tRptTaxSalePosYear'),
            'tRptTaxSaleFromTo' => language('report/report/report', 'tRptTaxSaleFromTo'),
            'tRptPosFrom' => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo' => language('report/report/report', 'tRptPosTo'),

            //อัพเดท 20/11/2019
            'tRptPosTypeName' => language('report/report/report', 'tRptPosTypeName'),
            'tRptPosType' => language('report/report/report', 'tRptPosType'),
            'tRptPosType1' => language('report/report/report', 'tRptPosType1'),
            'tRptPosType2' => language('report/report/report', 'tRptPosType2'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),

            'tRptBchFrom' => language('report/report/report', 'tRptBchFrom'),
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

            'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo' => language('report/report/report', 'tRptDateTo'),
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

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom' => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo' => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",

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

        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {

            // Execute Stored Procedure
            $this->mRptTaxSalePosByDateFull->FSnMExecStoreReport($this->aRptFilter);

            // Count Rows
            $aCountRowParams = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aRptFilter' => $this->aRptFilter,
            ];
            $this->nRows = $this->mRptTaxSalePosByDateFull->FSnMCountRowInTemp($aCountRowParams);

            // Report Type
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    $this->FSvCCallRptRenderExcel();
                    /* $aExportExcelRes = $this->FSvCCallRptRenderExcel();
                    echo json_encode($aExportExcelRes); */
                    break;
                case 'pdf':

                    break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
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
                'aRptFilter' => $this->aRptFilter,
            ];
            $aDataReport = $this->mRptTaxSalePosByDateFull->FSaMGetDataReport($aDataReportParams);
            /** =========== End Get Data ===================================== */
            /** =========== Begin Render View ================================ */
            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo' => $this->aCompanyInfo,
                'aDataReport' => $aDataReport,
                'aDataTextRef' => $this->aText,
                'aDataFilter' => $this->aRptFilter,
            ];
            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptTaxSalePosByDateFull', 'wRptTaxSalePosByDateFullHtml', $aDataViewRptParams);

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
                    'rtDesc' => 'success',
                ],
            ];
            $this->load->view('report/report/wReportViewer', $aDataViewerParams);
            /** =========== End Render View ================================== */
        } catch (Exception $Error) {
            echo $Error;
        }
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage()
    {

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        /** =========== Begin Get Data ======================================= */
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'nPerPage' => $this->nPerPage,
            'nPage' => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aRptFilter' => $this->aRptFilter,
        ];
        $aDataReport = $this->mRptTaxSalePosByDateFull->FSaMGetDataReport($aDataReportParams);
        /** =========== End Get Data ========================================= */
        /** =========== Begin Render View ==================================== */
        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo' => $this->aCompanyInfo,
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataFilter' => $aDataFilter,
        );
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsale/rptTaxSalePosByDateFull', 'wRptTaxSalePosByDateFullHtml', $aDataViewRptParams);

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
        /** =========== End Render View ====================================== */
    }

    /**
     * Functionality: Excel Report
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    // public function FSvCCallRptRenderExcel()
    // {

    //     /** =========== Begin Init Variable ================================== */
    //     $tReportName = $this->aText['tTitleReport'];
    //     $dDateExport = date('Y-m-d');
    //     $tTime = date('H:i:s');
    //     $tTextDetail = $this->aText['tRptTaxSalePosByDateDatePrint'] . ' : ' . $dDateExport . '  ' . $this->aText['tRptTaxSalePosByDateTimePrint'] . ' : ' . $tTime;
    //     /** =========== End Init Variable ==================================== */
    //     /** =========== Begin Get Data ======================================= */
    //     // ดึงข้อมูลจากฐานข้อมูล Temp
    //     $aGetDataReportParams = array(
    //         'nPerPage' => 100000,
    //         'nPage' => 1,
    //         'tCompName' => $this->tCompName,
    //         'tRptCode' => $this->tRptCode,
    //         'tUsrSessionID' => $this->tUserSessionID,
    //         'aRptFilter' => $this->aRptFilter,
    //     );
    //     $aDataReport = $this->mRptTaxSalePosByDateFull->FSaMGetDataReport($aGetDataReportParams);
    //     /** =========== End Get Data ========================================= */
    //     try {
    //         if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
    //             // ตั้งค่า Font Style
    //             $aStyleRptName = array('font' => array('size' => 14, 'bold' => true));
    //             $aStyleHeadder = array('font' => array('size' => 12, 'bold' => true, 'color' => array('rgb' => 'FFFFFF')));
    //             $aStyleRptHeadderTable = array('font' => array('size' => 12, 'color' => array('rgb' => '000000')));
    //             $StyleCompFont = array('font' => array('size' => 12, 'bold' => true));
    //             $StyleAddressFont = array('font' => array('size' => 11, 'bold' => true));
    //             $aStyleBold = ['font' => ['size' => 11, 'bold' => true]];
    //             $StyleFont = array('font' => array('name' => 'TH Sarabun New'));

    //             // Initiate PHPExcel cache
    //             $oCacheMethod = PHPExcel_CachedObjectStorageFactory::cache_in_memory_gzip;
    //             $aCacheSettings = array(' memoryCacheSize ' => '8000MB', 'cacheTime' => 3600 * 120);
    //             PHPExcel_Settings::setCacheStorageMethod($oCacheMethod, $aCacheSettings);

    //             // เริ่ม phpExcel
    //             $objPHPExcel = new PHPExcel();

    //             // A4 ตั้งค่าหน้ากระดาษ
    //             $objPHPExcel->getActiveSheet()->getPageSetup()->setPaperSize(PHPExcel_Worksheet_PageSetup::PAPERSIZE_A4);

    //             // Set Font
    //             $objPHPExcel->getActiveSheet()->getStyle('A1:Z1000')->applyFromArray($StyleFont);

    //             // จัดความกว้างของคอลัมน์
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth(15);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth(30);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth(50);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth(20);
    //             $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth(20);

    //             // ชื่อ Conpany
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A2', $this->aCompanyInfo['FTCmpName'])->getStyle('A2')->applyFromArray($StyleCompFont);

    //             // ที่อยู่
    //             $tLabelAddressLine1 = $this->aCompanyInfo['FTAddV1No'] . ' ' . $this->aCompanyInfo['FTAddV1Village'] . ' ' . $this->aCompanyInfo['FTAddV1Road'] . ' ' . $this->aCompanyInfo['FTAddV1Soi'];
    //             $tLabelAddressLine2 = $this->aCompanyInfo['FTSudName'] . ' ' . $this->aCompanyInfo['FTDstName'] . ' ' . $this->aCompanyInfo['FTPvnName'] . ' ' . $this->aCompanyInfo['FTAddV1PostCode'];
    //             // ที่อยู่ บรรทัดที่ 1
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A3', $tLabelAddressLine1)->getStyle('A3')->applyFromArray($StyleAddressFont);
    //             // ที่อยู่ บรรทัดที่ 2
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A4', $tLabelAddressLine2)->getStyle('A4')->applyFromArray($StyleAddressFont);

    //             // เบอร์โทร, แฟกซ์
    //             $tLabelTelFax = $this->aText['tRptTaxSalePosByDateTel'] . $this->aCompanyInfo['FTCmpTel'] . ' ' . $this->aText['tRptTaxSalePosByDateFax'] . $this->aCompanyInfo['FTCmpFax'];
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A5', $tLabelTelFax)->getStyle('A5')->applyFromArray($StyleAddressFont);

    //             // สาขา
    //             $tLabelBch = $this->aText['tRptTaxSalePosByDateBch'] . $this->aCompanyInfo['FTBchName'];
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A6', $tLabelBch)->getStyle('A6')->applyFromArray($StyleAddressFont);

    //             // ชื่อหัวรายงาน
    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A1:K1');
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A1', $tReportName);
    //             $objPHPExcel->getActiveSheet()->getStyle("A1")
    //                 ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    //             $objPHPExcel->getActiveSheet()->getStyle('A1')->applyFromArray($aStyleRptName);

    //             // กำหนกหัวตาราง
    //             $nStartRowHeadder = 8;
    //             $nStartRowFillter = 2;

    //             $tFillterColumLEFT = "E";
    //             $tFillterColumRIGHT = "F";

    //             /* ===== Begin Fillter =========================================================================== */
    //             // สาขา
    //             if (!empty($this->aRptFilter['tBchCodeFrom']) && !empty($this->aRptFilter['tBchCodeTo'])) {
    //                 // จากสาขา
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptTaxSalePosByDateFilterBchFrom'] . $this->aRptFilter['tBchNameFrom']);
    //                 $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
    //                     ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //                 // ถึงสาขา
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptTaxSalePosByDateFilterBchTo'] . $this->aRptFilter['tBchNameTo']);
    //                 $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
    //                     ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //                 $nStartRowFillter += 1;

    //                 if ($nStartRowFillter > 7) {
    //                     $nStartRowHeadder += 1;
    //                 }
    //             }

    //             // วันที่สร้างเอกสาร
    //             if (!empty($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateTo'])) {
    //                 // จากวันที่สร้างเอกสาร
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumLEFT . $nStartRowFillter, $this->aText['tRptTaxSalePosByDateFilterDocDateFrom'] . $this->aRptFilter['tDocDateFrom']);
    //                 $objPHPExcel->getActiveSheet()->getStyle($tFillterColumLEFT . $nStartRowFillter)
    //                     ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //                 // ถึงวันที่สร้างเอกสาร
    //                 $objPHPExcel->setActiveSheetIndex(0)->setCellValue($tFillterColumRIGHT . $nStartRowFillter, $this->aText['tRptTaxSalePosByDateFilterDocDateTo'] . $this->aRptFilter['tDocDateTo']);
    //                 $objPHPExcel->getActiveSheet()->getStyle($tFillterColumRIGHT . $nStartRowFillter)
    //                     ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_LEFT);

    //                 $nStartRowFillter += 1;

    //                 if ($nStartRowFillter > 7) {
    //                     $nStartRowHeadder += 1;
    //                 }
    //             }
    //             /* ===== End Fillter =========================================================================== */

    //             // รายละเอียดการออกรายงาน
    //             $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . ($nStartRowHeadder - 1) . ':K' . ($nStartRowHeadder - 1));
    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue('A' . ($nStartRowHeadder - 1), $tTextDetail);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . ($nStartRowHeadder - 1))
    //                 ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    //             // กำหนด Style Font ของหัวตาราง
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->applyFromArray($aStyleRptHeadderTable);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowHeadder . ':K' . $nStartRowHeadder)->applyFromArray(array(
    //                 'borders' => array(
    //                     'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                 ),
    //             ));

    //             // Main header
    //             $objPHPExcel->setActiveSheetIndex(0)
    //                 ->setCellValue('A' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateSeq'])
    //                 ->setCellValue('B' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateDocDate'])
    //                 ->setCellValue('C' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateDocNo'])
    //                 ->setCellValue('D' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateDocRef'])
    //                 ->setCellValue('E' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateCst'])
    //                 ->setCellValue('F' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateTaxID'])
    //                 ->setCellValue('G' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateComp'])
    //                 ->setCellValue('H' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateAmt'])
    //                 ->setCellValue('I' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateAmtV'])
    //                 ->setCellValue('J' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateAmtNV'])
    //                 ->setCellValue('K' . $nStartRowHeadder, $this->aText['tRptTaxSalePosByDateTotal']);

    //             // ตัวอักษร Head Center
    //             $objPHPExcel->getActiveSheet()->getStyle("A" . $nStartRowHeadder . ":K" . $nStartRowHeadder)
    //                 ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //             // Loop Data Query DataBase
    //             $nStartRowData = $nStartRowHeadder + 1;
    //             $nSeq = 0;
    //             $nLastRowNuber = 0;

    //             foreach ($aDataReport['aRptData'] as $nKey => $aValue) {

    //                 if ($aValue['FNRowPartID'] == 1) {
    //                     $objPHPExcel->setActiveSheetIndex(0)
    //                         ->setCellValue('A' . $nStartRowData, '  ' . $this->aText['tRptTaxSalePosByDatePosGrouping'] . $aValue['FTPosCode']);

    //                     $objPHPExcel->setActiveSheetIndex(0)->mergeCells('A' . ($nStartRowData) . ':K' . ($nStartRowData));
    //                     // รูปแบบตัวอักษร
    //                     $objPHPExcel->getActiveSheet()->getStyle('A' . $nStartRowData . ':K' . $nStartRowData)->applyFromArray($aStyleBold);

    //                     $nStartRowData += 1;
    //                     $nSeq = 1;
    //                 }
    //                 $objPHPExcel->setActiveSheetIndex(0)
    //                     ->setCellValue('A' . $nStartRowData, '  ' . $nSeq++)
    //                     ->setCellValue('B' . $nStartRowData, '  ' . date("d/m/Y", strtotime($aValue['FDXshDocDate'])))
    //                     ->setCellValue('C' . $nStartRowData, '  ' . $aValue["FTXshDocNo"])
    //                     ->setCellValue('D' . $nStartRowData, '  ' . $aValue["FTXshDocRef"])
    //                     ->setCellValue('E' . $nStartRowData, '  ' . $aValue["FTCstName"])
    //                     ->setCellValue('F' . $nStartRowData, '  ' . $aValue["FTXshTaxID"])
    //                     ->setCellValue('G' . $nStartRowData, '  ' . $aValue["FTCmpName"])
    //                     ->setCellValue('H' . $nStartRowData, '  ' . number_format($aValue["FCXshAmt"], $this->nOptDecimalShow))
    //                     ->setCellValue('I' . $nStartRowData, '  ' . number_format($aValue["FCXshAmtV"], $this->nOptDecimalShow))
    //                     ->setCellValue('J' . $nStartRowData, '  ' . number_format($aValue["FCXshAmtNV"], $this->nOptDecimalShow))
    //                     ->setCellValue('K' . $nStartRowData, '  ' . number_format($aValue["FCXshGrandTotal"], $this->nOptDecimalShow));

    //                 // ตัวอักษรชิดขวา
    //                 $objPHPExcel->getActiveSheet()->getStyle("H" . $nStartRowData . ":K" . $nStartRowData)
    //                     ->getAlignment()
    //                     ->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    //                 // ตัวอักษร Head Center
    //                 $objPHPExcel->getActiveSheet()->getStyle("A" . $nStartRowData . ":A" . $nStartRowData)
    //                     ->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    //                 $nLastRowNuber = $nStartRowData;
    //                 $nStartRowData++;
    //             }

    //             // Set Footer Summary
    //             $nEndRow = $nStartRowData;
    //             $nSummaryRow = $nEndRow;

    //             $objPHPExcel->setActiveSheetIndex(0)->setCellValue("A" . $nSummaryRow, '  ' . $this->aText['tRptTaxSalePosByDateTotalFooter'])
    //                 ->setCellValue("H" . $nSummaryRow, '  ' . number_format($aValue['FCXshAmt_Footer'], $this->nOptDecimalShow))
    //                 ->setCellValue("I" . $nSummaryRow, '  ' . number_format($aValue['FCXshAmtV_Footer'], $this->nOptDecimalShow))
    //                 ->setCellValue("J" . $nSummaryRow, '  ' . number_format($aValue['FCXshAmtNV_Footer'], $this->nOptDecimalShow))
    //                 ->setCellValue("K" . $nSummaryRow, '  ' . number_format($aValue['FCXshGrandTotal_Footer'], $this->nOptDecimalShow));

    //             // กำหนด Style Font Summary
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nSummaryRow . ':K' . $nSummaryRow)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID)->getStartColor()->setRGB('CFE2F3');
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nSummaryRow . ':K' . $nSummaryRow)->applyFromArray($aStyleRptHeadderTable);
    //             $objPHPExcel->getActiveSheet()->getStyle('A' . $nSummaryRow . ':K' . $nSummaryRow)->applyFromArray(array(
    //                 'borders' => array(
    //                     'top' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                     'bottom' => array('style' => PHPExcel_Style_Border::BORDER_THIN, 'color' => array('rgb' => '000000')),
    //                 ),
    //             ));
    //             // จัดตัวอักษรชิดขวา
    //             $objPHPExcel->getActiveSheet()->getStyle("A" . $nSummaryRow . ':K' . $nSummaryRow)->getAlignment()->setHorizontal(\PHPExcel_Style_Alignment::HORIZONTAL_RIGHT);

    //             // Export File Excel
    //             $tFilename = 'ReportCard8-' . date("dmYhis") . '.xlsx';

    //             header("Pragma: public");
    //             header("Expires: 0");
    //             header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    //             header("Content-Type: application/force-download");
    //             header("Content-Type: application/octet-stream");
    //             header("Content-Type: application/download");

    //             header("Content-Disposition: attachment;filename=$tFilename");
    //             header("Content-Transfer-Encoding: binary");

    //             $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);

    //             if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/')) {
    //                 mkdir(APPPATH . 'modules/report/assets/exportexcel/');
    //             }

    //             if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode)) {
    //                 mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode);
    //             }

    //             if (!is_dir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode)) {
    //                 mkdir(APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode);
    //             }

    //             $tPathExport = APPPATH . 'modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode . '/';

    //             $oFiles = glob($tPathExport . '*');
    //             foreach ($oFiles as $tFile) {
    //                 if (is_file($tFile)) {
    //                     unlink($tFile);
    //                 }

    //             }

    //             // Check Status Save File Excel
    //             $objWriter->save($tPathExport . $tFilename);
    //             $aResponse = array(
    //                 'nStaExport' => 1,
    //                 'tFileName' => $tFilename,
    //                 'tPathFolder' => 'application/modules/report/assets/exportexcel/' . $this->tRptCode . '/' . $this->tUserLoginCode . '/',
    //                 'tMessage' => "Export File Successfully.",
    //             );
    //         } else {
    //             $aResponse = array(
    //                 'nStaExport' => '800',
    //                 'tMessage' => $this->aText['tRptDataReportNotFound'],
    //             );
    //         }
    //     } catch (Exception $Error) {
    //         $aResponse = array(
    //             'nStaExport' => '500',
    //             'tMessage' => $Error->getMessage(),
    //         );
    //     }
    //     return $aResponse;
    // }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: Object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp()
    {
        try {
            $aCountRowInTempParams = [
                'tCompName' => $this->tCompName,
                'tRptCode' => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aRptFilter' => $this->aRptFilter,
            ];

            $nDataCountPage = $this->mRptTaxSalePosByDateFull->FSnMCountRowInTemp($aCountRowInTempParams);

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
     * Creator: 22/07/2019 Piya
     * LastUpdate: -
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile() {
        try {
            $tRptGrpCode = $this->tRptGroup;
            $tRptCode = $this->tRptCode;
            $tUserCode = $this->tUserLoginCode;
            $tSessionID = $this->tUserSessionID;
            $nLangID = FCNaHGetLangEdit();
            $tRptExportType = $this->tRptExportType;
            $tCompName = $this->tCompName;
            $dDateSendMQ = date('Y-m-d');
            $dTimeSendMQ = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aReportCallRabbitMQParams = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode' => $tRptCode,
                    'pnPerFile' => 20000,
                    'ptUserCode' => $tUserCode,
                    'ptUserSessionID' => $tSessionID,
                    'pnLngID' => $nLangID,
                    'ptFilter' => $this->aRptFilter,
                    'ptRptExpType' => $tRptExportType,
                    'ptComName' => $tCompName,
                    'ptDate' => $dDateSendMQ,
                    'ptTime' => $dTimeSendMQ,
                    'ptBchCode' => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
                ]
            ];

            FCNxReportCallRabbitMQ($aReportCallRabbitMQParams);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode'  => $this->tSysBchCode,
                    'ptComName' => $tCompName,
                    'ptRptCode' => $tRptCode,
                    'ptUserCode' => $tUserCode,
                    'ptUserSessionID' => $tSessionID,
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
     * Creator: 28/09/2020 Sooksanti
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

        $oBorder = (new BorderBuilder())
            ->setBorderTop(Color::BLACK, Border::WIDTH_THIN)
            ->setBorderBottom(Color::BLACK, Border::WIDTH_THIN)
            ->build();

        $oStyleColums = (new StyleBuilder())
            ->setBorder($oBorder)
            ->setFontBold()
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBarchCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBarchName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptDocSale')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptDocReturn')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTaxSalePosByDateAmt')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTaxSalePosByDateAmtNV')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptTaxSalePosByDateTotal')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptVat')),
            WriterEntityFactory::createCell(null),
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
        $aDataReport = $this->mRptTaxSalePosByDateFull->FSaMGetDataReport($aDataReportParams);
        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                $tDocDate = date("d/m/Y", strtotime($aValue['FDXshDocDate']));

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
                    WriterEntityFactory::createCell($aValue['FTBchCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(($aValue['FTXshDocNoSale'] == "" ? "-" : $aValue['FTXshDocNoSale'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(($aValue['FTXshDocNoRefun'] == "" ? "-" : $aValue['FTXshDocNoRefun'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tDocDate),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshAmt'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshAmtNV'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshGrandTotal'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshVat'])),
                    WriterEntityFactory::createCell(null),

                ];
                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);

                if (($nKey + 1) == FCNnHSizeOf($aDataReport['aRptData'])) { //SumFooter
                    $values = [
                        WriterEntityFactory::createCell($this->aText['tRptTaxSalePosTotalSub']),
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
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshAmt_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshAmtNV_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshGrandTotal_Footer'])),
                        WriterEntityFactory::createCell(null),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCXshVat_Footer'])),
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
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $this->aText['tTimePrint'] . ' ' . date('H:i:s')),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        return $aMulltiRow;

    }

    /**
     * Functionality: Render Excel Report Footer
     * Parameters:  Function Parameter
     * Creator: 30/09/2020 Sooksanti
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

        // // เครื่องจุดขาย (Pos) แบบเลือก
        // if (!empty($this->aRptFilter['tPosCodeSelect'])) {
        //     $tPosSelectText = ($this->aRptFilter['bPosStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tPosNameSelect'];
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptPosFrom'] . ' : ' . $tPosSelectText),
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

        // // Fillterฺ Pos (เครื่องจุดขาย)) แบบช่วง
        // if (!empty($this->aRptFilter['tPosCodeFrom']) && !empty($this->aRptFilter['tPosCodeTo'])) {
        //     $aCells = [
        //         WriterEntityFactory::createCell($this->aText['tRptPosFrom'] . ' : ' . $this->aRptFilter['tPosNameFrom'] . '     ' . $this->aText['tRptPosTo'] . ' : ' . $this->aRptFilter['tPosNameTo']),
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

        if (isset($this->aRptFilter['tPosType'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptPosTypeName'] . ' : ' . $this->aText['tRptPosType' . $this->aRptFilter['tPosType']]),
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
