<?php

defined('BASEPATH') or exit('No direct script access allowed');

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


class cRptRedeemReturnCard extends MX_Controller {
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
        $this->load->model('report/reportcard/mRptRedeemReturnCard');

        $this->init();

        parent::__construct();
    }

    private function init(){
        $this->aText   = [
            'tTitleReport'              => language('report/report/report', 'tRptTitleRedeemReturnCard'),
            'tRptTitle1'                =>language('report/report/report', 'tRptTitleRedeemReturnCard1'),
            'tDatePrint'                => language('report/report/report', 'tRptRedeemReturnCardPrint'),
            'tTimePrint'                => language('report/report/report', 'tRptRedeemReturnCardTimePrint'),

            // Address Lang
            'tRptAddrBuilding'          => language('report/report/report', 'tRptAddrBuilding'),
            'tRptAddrRoad'              => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi'               => language('report/report/report', 'tRptAddrSoi'),
            'tRptAddrSubDistrict'       => language('report/report/report', 'tRptAddrSubDistrict'),
            'tRptAddrDistrict'          => language('report/report/report', 'tRptAddrDistrict'),
            'tRptAddrProvince'          => language('report/report/report', 'tRptAddrProvince'),
            'tRptAddrTel'               => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax'               => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrBranch'            => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddV2Desc1'            => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2'            => language('report/report/report', 'tRptAddV2Desc2'),
            'tRptTaxSalePosTaxId'       => language('report/report/report', 'tRptTaxSalePosTaxId'),
            'tRptTotal'                 => language('report/report/report', 'tRptTotal'),
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),
            'tRptFaxNo' => language('report/report/report', 'tRptFaxNo'),
            'tRptTel' => language('report/report/report', 'tRptTel'),
            //Fillter
            'tRptBchFrom'               => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'                 => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'              => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'                => language('report/report/report', 'tRptShopTo'),
            'tRptDateFrom'              => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'                => language('report/report/report', 'tRptDateTo'),
            'tRptDate'                  => language('report/report/report', 'tRptDate'),
            'tRptFooterSumAll'          => language('report/report/report', 'tRptFooterSumAll'),
            'tRptAdjShopFrom'           => language('report/report/report','tRptAdjShopFrom'),
            'tRptAdjShopTo'             => language('report/report/report','tRptAdjShopTo'),
            'tRptAdjMerChantFrom'       => language('report/report/report','tRptAdjMerChantFrom'),
            'tRptAdjMerChantTo'         => language('report/report/report', 'tRptAdjMerChantTo'),
            'tRptAdjPosFrom'            => language('report/report/report','tRptAdjPosFrom'),
            'tRptAdjPosTo'              => language('report/report/report','tRptAdjPosTo'),
            'tRptAdjWahFrom'            => language('report/report/report','tRptAdjWahFrom'),
            'tRptAdjWahTo'              => language('report/report/report','tRptAdjWahTo'),
            'tRptMerFrom'               => language('report/report/report','tRptMerFrom'),
            'tRptPosFrom'               => language('report/report/report','tRptPosFrom'),
            'tRptAll'                   => language('report/report/report','tRptAll'),
            'tRptNotFoundBranch'        => language('report/report/report','tRptNotFoundBranch'),
            'tRptNotFoundShop'          => language('report/report/report','tRptNotFoundShop'),
            'tRptFrom'                  => language('report/report/report','tRptFrom'),
            'tRptTo'                    => language('report/report/report','tRptTo'),
            'tRptNotFoundWah'           => language('report/report/report','tRptNotFoundWah'),
            'tRptFill'                  => language('report/report/report','tRptFill'),
            'tRptConditionInReport'     => language('report/report/report','tRptConditionInReport'),
            'tRptRedeemReturnCardAmt'   => language('report/report/report','tRptRedeemReturnCardAmt'),
            'tRptRentAmtFolCourSumText' => language('report/report/report', 'tRptRentAmtFolCourSumText'),


            //Table
            'tRptRedeemReturnCardSeq'          => language('report/report/report','tRptRedeemReturnCardSeq'),  //ลำดับ
            'tRptRedeemReturnCardBranch'       => language('report/report/report','tRptRedeemReturnCardBranch'), //สาขา
            'tRptRedeemReturnCardDocNo'        => language('report/report/report','tRptRedeemReturnCardDocNo'), //เลขที่เอกสาร
            'tRptRedeemReturnCardDocDate'      => language('report/report/report','tRptRedeemReturnCardDocDate'), //วันที่เอกสาร
            'tRptRedeemReturnCardShop'         => language('report/report/report','tRptRedeemReturnCardShop'),  //ร้านค้า
            'tRptRedeemReturnCardPos'          => language('report/report/report','tRptRedeemReturnCardPos'), //จุดขาย
            'tRptRedeemReturnCardResidualVal'  => language('report/report/report','tRptRedeemReturnCardResidualVal'),  //มูลค่าคงเหลือ
            'tRptRedeemReturnCardValNotRet'    => language('report/report/report','tRptRedeemReturnCardValNotRet'),  //ยอดห้ามคืน
            'tRptRedeemReturnCardUsrReturn'    => language('report/report/report','tRptRedeemReturnCardUsrReturn'), //ผู้ทำรายการคืน
            'tRptRedeemReturnCardValRet'       => language('report/report/report','tRptRedeemReturnCardValRet'), //ยอดคืนเงิน
            'tRptRedeemReturnCardNoData'       => language('report/report/report', 'tRptRedeemReturnCardNoData'),  //ไม่มีข้อมูล

            'tRptBranch'                 => language('report/report/report', 'tRptBranch'),
            'tRptNotFoundBranch'        => language('report/report/report','tRptNotFoundBranch'),
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

            'tTypeSelect'       => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // Filter Branch (สาขา)
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

            'tDocDateFrom'      => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'        => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",

        ];

          // ดึงข้อมูลบริษัทฯ
            $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
            ];
            $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
        }

        public function index(){

            if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {

                // Execute Stored Procedure
                $this->mRptRedeemReturnCard->FSnMExecStoreCReport($this->aRptFilter);

                // Count Rows
                $aCountRowParams = [
                    'tCompName'  => $this->tCompName,
                    'tRptCode'   => $this->tRptCode,
                    'tSessionID' => $this->tUserSessionID
                ];
                $this->nRows = $this->mRptRedeemReturnCard->FSnMCountDataReportAll($aCountRowParams);

                // Report Type
                switch ($this->tRptExportType) {
                    case 'html':
                        $this->FSvCCallRptViewBeforePrint();
                        break;
                    case 'excel':
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
     * Creator: 10/01/2020 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint(){
        try{
            /** =========== Begin Get Data =================================== */
            // ดึงข้อมูลจากฐานข้อมูล Temp
            $aDataReportParams = [
                'nPerPage'      => $this->nPerPage,
                'nPage'         => $this->nPage,
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aRptFilter'    => $this->aRptFilter
            ];

            $aDataReport = $this->mRptRedeemReturnCard->FSaMGetDataReport($aDataReportParams);

            /** =========== End Get Data ===================================== */

            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo' => $this->aCompanyInfo,
                'aDataReport' => $aDataReport,
                'aDataTextRef' => $this->aText,
                'aDataFilter' => $this->aRptFilter
            ];

            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rptRedeemReturnCard', 'wRptRedeemReturnCardHtml', $aDataViewRptParams);

            // Data Viewer Center Report
            $aDataViewerParams = [
                'tTitleReport'   => $this->aText['tTitleReport'],
                'tRptTypeExport' => $this->tRptExportType,
                'tRptCode'    => $this->tRptCode,
                'tRptRoute'   => $this->tRptRoute,
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

        }catch(Exception $Error){
            echo $Error;
        }
    }


    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/01/2020 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage(){
        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */

        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aRptFilter'    => $aDataFilter
        ];

        $aDataReport = $this->mRptRedeemReturnCard->FSaMGetDataReport($aDataReportParams);


        /** =========== End Get Data ========================================= */
        /** =========== Begin Render View ==================================== */
        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aDataFilter'       => $aDataFilter
        );

        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rptRedeemReturnCard', 'wRptRedeemReturnCardHtml', $aDataViewRptParams);

         // Data Viewer Center Report
         $aDataViewerParams = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tRptView,
            'aDataFilter'       => $aDataFilter,
            'aDataReport' => array(
                'raItems'       => $aDataReport['aRptData'],
                'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                'rtCode'    => '1',
                'rtDesc'    => 'success'
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewerParams);


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
        $tFileName = $this->aText['tRptTitle1'].'_'.date('YmdHis').'.xlsx';
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
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardBranch']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardDocNo']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardDocDate']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardShop']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardPos']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardUsrReturn']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardResidualVal']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardValNotRet']),
            WriterEntityFactory::createCell($this->aText['tRptRedeemReturnCardValRet']),

        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells,$oStyleColums);
        $oWriter->addRow($singleRow);


        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = array(
            'nPerPage'      => 999999999999,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aRptFilter'    => $this->aRptFilter
        );

        $aDataReport = $this->mRptRedeemReturnCard->FSaMGetDataReport($aDataReportParams);



        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
        ->setCellAlignment(CellAlignment::RIGHT)
        ->build();

        if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {

                $tRptFDTxnDocDate   = date('Y-m-d',strtotime($aValue["FDTxnDocDate"]));  //วันที่เอกสาร

                $nCrdValue  = empty($aValue['FCTxnCrdValue']) ? 0 : $aValue['FCTxnCrdValue'];  //มูลค่าคงเหลือ
                $nValNotRet = empty($aValue['FCTxnValNotRet']) ? 0 : $aValue['FCTxnValNotRet']; //ยอดห้ามคืน
                $nValRet    = empty($aValue['FCTxnValRet']) ? 0 : $aValue['FCTxnValRet'];   //ยอดคืนเงิน

                $values= [
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell($aValue['FTTxnDocNoRef']),
                    WriterEntityFactory::createCell($tRptFDTxnDocDate),
                    WriterEntityFactory::createCell($aValue['FTShpName']),
                    WriterEntityFactory::createCell($aValue['FTPosName']),
                    WriterEntityFactory::createCell($aValue['FTUsrName']),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCTxnCrdValue']),$oStyle),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCTxnValNotRet']),$oStyle),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCTxnValRet']),$oStyle),
                ];

                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);

                if(($nKey+1)==FCNnHSizeOf($aDataReport['aRptData'])){ //SumFooter

                    $values= [
                        WriterEntityFactory::createCell($this->aText['tRptRentAmtFolCourSumText']),
                        WriterEntityFactory::createCell(NULL),
                        WriterEntityFactory::createCell(NULL),
                        WriterEntityFactory::createCell(NULL),
                        WriterEntityFactory::createCell(NULL),
                        WriterEntityFactory::createCell(NULL),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCTxnCrdValue_Footer"]),$oStyle),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCTxnValNotRet_Footer"]),$oStyle),
                        WriterEntityFactory::createCell(FCNnGetNumeric($aValue["FCTxnValRet_Footer"]),$oStyle),
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
            WriterEntityFactory::createCell($this->aText['tRptTitle1']),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells,$oStyle);

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
            WriterEntityFactory::createCell($this->aText['tRptAddrBranch'] .' '. $tFTBchName),
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

        if((isset($this->aRptFilter['tDocDateFrom']) && !empty($this->aRptFilter['tDocDateFrom'])) && (isset($this->aRptFilter['tDocDateTo']) && !empty($this->aRptFilter['tDocDateTo']))){
            $aCells = [
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell($this->aText['tRptDateFrom'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateFrom'])).' '.$this->aText['tRptDateTo'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateTo']))),
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
            WriterEntityFactory::createCell($this->aText['tDatePrint'].' '.date('d/m/Y').' '.$this->aText['tTimePrint'].' '.date('H:i:s')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
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
            $tPosSelect =  ($this->aRptFilter['bPosStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tPosNameSelect'];
                $aCells = [
                    WriterEntityFactory::createCell($this->aText['tRptAdjPosFrom'].' : '.$tPosSelect),
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
