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

class rptrcvinfotrialpdtvd_controller extends MX_Controller {

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
        parent::__construct();
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportvending/rptrcvinfotrialpdtvd_model');

        // Init Report
        $this->init();
        parent::__construct();
    }


    private function init(){
        $this->aText = [
            'tTitleReport'          => language('report/report/report', 'tRpt002001007'),
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

            // Fillter AdjStock
            'tRptAdjMerChantFrom'       => language('report/report/report','tRptAdjMerChantFrom'),
            'tRptAdjMerChantTo'         => language('report/report/report','tRptAdjMerChantTo'),
            'tRptAdjShopFrom'           => language('report/report/report','tRptAdjShopFrom'),
            'tRptAdjShopTo'             => language('report/report/report','tRptAdjShopTo'),
            'tRptAdjPosFrom'            => language('report/report/report','tRptAdjPosFrom'),
            'tRptAdjPosTo'              => language('report/report/report','tRptAdjPosTo'),
            'tRptAdjWahFrom'            => language('report/report/report','tRptAdjWahFrom'),
            'tRptAdjWahTo'              => language('report/report/report','tRptAdjWahTo'),
            'tRptAdjDateFrom'           => language('report/report/report','tRptAdjDateFrom'),
            'tRptAdjDateTo'             => language('report/report/report','tRptAdjDateTo'),
            'tRptBchFrom'               => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'                 => language('report/report/report', 'tRptBchTo'),

            // No Data Report
            'tRptAdjStkNoData'          => language('common/main/main', 'tCMNNotFoundData'),

            // Update Text Wasin(18/11/2019)
            'tRptAjdQtyAllDiff'         => language('report/report/report','tRptAjdQtyAllDiff'),
            'tRptAdjStkVDTaxNo'         => language('report/report/report','tRptAdjStkVDTaxNo'),
            'tRptConditionInReport'     => language('report/report/report', 'tRptConditionInReport'),

            'tRptMonth' => language('report/report/report', 'tRptMonth'),

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

            'tRptBranch'        => language('report/report/report', 'tRptBranch'),
            'tRptSalDocNo'      => language('report/report/report', 'tRptSalDocNo'),
            'tRptDate'          => language('report/report/report', 'tRptDate'),
            'tRptType'          => language('report/report/report', 'tRptType'),
            'tRptPdtCode'       => language('report/report/report', 'tRptPdtCode'),
            'tRptPdtName'       => language('report/report/report', 'tRptPdtName'),
            'tRptPos'           => language('report/report/report', 'tRptPos'),
            'tRptCodeRef'       => language('report/report/report', 'tRptCodeRef'),
            'tRptStatus'        => language('report/report/report', 'tRptStatus'),
            'tRptStartDate'     => language('report/report/report', 'tRptStartDate'),
            'tRptExpiredDate'   => language('report/report/report', 'tRptExpiredDate'),
            'tRptBkdQty'        => language('report/report/report', 'tRptBkdQty'),
            'tRptBkdQtyRcv'     => language('report/report/report', 'tRptBkdQtyRcv'),
            'tRptVending'       => language('report/report/report', 'tRptVending'),
            'tRptBarchName'     => language('report/report/report', 'tRptBarchName'),

            'tRptCoponType1'       => language('report/report/report', 'tRptCoponType1'),
            'tRptCoponType2'       => language('report/report/report', 'tRptCoponType2'),
            'tRptCoponStatus1'     => language('report/report/report', 'tRptCoponStatus1'),
            'tRptCoponStatus2'     => language('report/report/report', 'tRptCoponStatus2'),
            'tRptCoponStatus3'     => language('report/report/report', 'tRptCoponStatus3'),
            'tRptCoponStatus4'     => language('report/report/report', 'tRptCoponStatus4'),
            'tRptCoponStatus5'     => language('report/report/report', 'tRptCoponStatus5'),

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
            'tSessionID'    => $this->tUserSessionID,
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

            // Filter สถานะ (คูปอง / บัตรกำนัล)
            'tCouponStatus'     => (empty($this->input->post('ocmRptCouponStatus'))) ? '' : $this->input->post('ocmRptCouponStatus'),

            // Filter ประเภท (คูปอง / บัตรกำนัล)
            'tCouponType'       => (empty($this->input->post('ocmRptCouponType'))) ? '' : $this->input->post('ocmRptCouponType'),

            // Filter Document Date (วันที่สร้างเอกสาร)
            'tDocDateFrom'  => (empty($this->input->post('oetRptDocDateFrom'))) ? '' : $this->input->post('oetRptDocDateFrom'),
            'tDocDateTo'    => (empty($this->input->post('oetRptDocDateTo'))) ? '' : $this->input->post('oetRptDocDateTo')
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
            $this->rptrcvinfotrialpdtvd_model->FSnMExecStoreReport($this->aRptFilter);

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
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                    break;
                // case 'pdf':
                //     $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                //     break;
            }
        }
    }

    // Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 15/07/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View Report Viewersd
    // ReturnType: View
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {
        try{
            $aDataWhere  = array(
                'tUsrSessionID' => $this->tUserSessionID,
                'tCompName'     => $this->tCompName,
                'tUserCode'     => $this->tUserLoginCode,
                'tRptCode'      => $this->tRptCode,
                'nPage'         => 1, // เริ่มทำงานหน้าแรก
                'nPerPage'      => $this->nPerPage,
                // 'nRow'       => $this->nPerPage,
            );

            $aDataReport = $this->rptrcvinfotrialpdtvd_model->FSaMGetDataReport($aDataWhere);

            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow'   => $this->nOptDecimalShow,
                'aCompanyInfo'      => $this->aCompanyInfo,
                'aDataReport'       => $aDataReport,
                'aDataTextRef'      => $this->aText,
                'aDataFilter'       => $this->aRptFilter
            ];

            // Load View Advance Table
            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportvending', 'wRptRcvInfoTrialPdtVDHtml', $aDataViewRptParams);

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
        }catch(Exception $Error){
            echo $Error;
        }
    }

    // Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 19/07/2019 Wasin(Yoshi)
    // LastUpdate: 15/10/2019 Witsarut (bell)
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrintClickPage() {

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

        $aDataReport = $this->rptrcvinfotrialpdtvd_model->FSaMGetDataReport($aDataWhereRpt);


        // Load View Advance Table
        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aDataFilter'     => $aDataFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportvending', 'wRptRcvInfoTrialPdtVDHtml', $aDataViewRptParams);

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
    // Creator: 06/08/2019 Wasin(Yoshi)
    // LastUpdate: 15/10/2019 Witsarut (Bell)
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptRenderExcel($aDataSwitchCase)
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

        $oStyleColums = (new StyleBuilder())
            ->setBorder($oBorder)
            ->setFontBold()
            ->build();

        $aCells = [
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBarchName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptSalDocNo')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptType')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtCode')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPdtName')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptPos')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptCodeRef')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBkdQty')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptBkdQtyRcv')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptStatus')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptStartDate')),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(language('report/report/report', 'tRptExpiredDate')),
            WriterEntityFactory::createCell(null),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells, $oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataWhere  = array(
            'tUsrSessionID' => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tUserCode'     => $this->tUserLoginCode,
            'tRptCode'      => $this->tRptCode,
            'nPage'         => 1, // เริ่มทำงานหน้าแรก
            'nPerPage'      => $this->nPerPage,
            // 'nRow'       => $this->nPerPage,
        );
        $aDataReport = $this->rptrcvinfotrialpdtvd_model->FSaMGetDataReport($aDataWhere);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
            ->setCellAlignment(CellAlignment::RIGHT)
            ->build();

        if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                // $nStkQtySale = $aValue["FCStkQtySaleDN"];
                // $nStkQtyCN = $aValue["FCStkQtyCN"];
                // $nStkQtySale = $nStkQtySale - $nStkQtyCN;

                switch($aValue['FTBkpType']){
                    case "2":
                        $tCouponName = language('document/managecoupon/managecoupon','tMCPType1'); 
                        break;
                    case "1":
                        $tCouponName = language('document/managecoupon/managecoupon','tMCPType2'); 
                        break;
                    default:
                        $tCouponName = "-";
                }

                switch($aValue['FTBkpStatusReal']){
                    case '1':
                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus1'); // จอง
                        break;
                    case '2':
                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus2'); // รับบางส่วน
                        break;
                    case '3':
                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus3'); // รับทั้งหมด
                        break;
                    case '4':
                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus4'); // ยกเลิก
                        break;
                    case '5':
                        $tStaName   = language('document/managecoupon/managecoupon','tMCPStatusExpire'); // หมดอายุ
                        break;
                    default:
                        $tStaName = "-";
                        break;
                }

                $tStrTime = strtotime($aValue['FDBkpDate']);
                $aDate    = getDate($tStrTime);
                if( $aDate['seconds'] == 0 && $aDate['minutes'] == 0 && $aDate['hours'] == 0 ){
                    $dBkpDate    = date_format(date_create($aValue['FDBkpDate']), 'Y-m-d');
                    $dBkpDateExp = date_format(date_create($aValue['FDBkpDateExpire']), 'Y-m-d');
                }else{
                    $dBkpDate    = date_format(date_create($aValue['FDBkpDate']), 'Y-m-d H:i:s');
                    $dBkpDateExp = date_format(date_create($aValue['FDBkpDateExpire']), 'Y-m-d H:i:s');
                }

                $values = [
                    WriterEntityFactory::createCell($aValue['FTBchName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTBkpRef1']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(date("d/m/Y", strtotime($aValue['FDXshDocDate']))),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tCouponName),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPdtCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPdtName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTPosName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTBkpRef2']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCBkdQty'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCBkdQtyRcv'])),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tStaName),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($dBkpDate),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($dBkpDateExp),
                    WriterEntityFactory::createCell(null),
                ];
                $aRow = WriterEntityFactory::createRow($values);
                $oWriter->addRow($aRow);
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
                WriterEntityFactory::createCell($this->aText['tRptAdjDateFrom'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateFrom'])) . ' ' . $this->aText['tRptAdjDateTo'] . ' ' . date('d/m/Y', strtotime($this->aRptFilter['tDocDateTo']))),
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

        // ============================ ฟิวเตอร์ข้อมูล สาขา ============================
        if (isset($this->aRptFilter['tBchCodeSelect']) && !empty($this->aRptFilter['tBchCodeSelect'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptBranch']),
                WriterEntityFactory::createCell(($this->aRptFilter['bBchStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tBchNameSelect']),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        // ============================ ฟิวเตอร์ข้อมูล กลุ่มร้านค้า ============================
        if (isset($this->aRptFilter['tMerCodeSelect']) && !empty($this->aRptFilter['tMerCodeSelect'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptMerFrom']." : "),
                WriterEntityFactory::createCell(($this->aRptFilter['bMerStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tMerNameSelect']),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        // ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================
        if (isset($this->aRptFilter['tShpCodeSelect']) && !empty($this->aRptFilter['tShpCodeSelect'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptShopFrom']." : "),
                WriterEntityFactory::createCell(($this->aRptFilter['bShpStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tShpNameSelect']),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        // ============================ ฟิวเตอร์ข้อมูล ตู้ขายสินค้า ============================
        if (isset($this->aRptFilter['tPosCodeSelect']) && !empty($this->aRptFilter['tPosCodeSelect'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptVending']." : "),
                WriterEntityFactory::createCell(($this->aRptFilter['bPosStaSelectAll']) ? $this->aText['tRptAll'] : $this->aRptFilter['tPosNameSelect']),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        // ============================ ฟิวเตอร์ข้อมูล ประเภท ============================
        if ( isset($this->aRptFilter['tCouponType']) ) { 
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptType']." : "),
                WriterEntityFactory::createCell((empty($this->aRptFilter['tCouponType']) ? $this->aText['tRptAll'] : $this->aText['tRptCoponType'.$this->aRptFilter['tCouponType']])),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        // ============================ ฟิวเตอร์ข้อมูล สถานะ ============================
        if ( isset($this->aRptFilter['tCouponStatus']) ) { 
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptStatus']." : "),
                WriterEntityFactory::createCell((empty($this->aRptFilter['tCouponStatus']) ? $this->aText['tRptAll'] : $this->aText['tRptCoponStatus'.$this->aRptFilter['tCouponStatus']])),
            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }
        return $aMulltiRow;
    }

    // Functionality: Click Page Report (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 16/08/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: object Status Count Data Report
    // ReturnType: Object
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase) {
        try {
            $aDataCountData = [
                'tCompName' => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode' => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tSessionID' => $paDataSwitchCase['paDataFilter']['tSessionID'],
            ];

            $nDataCountPage = $this->rptrcvinfotrialpdtvd_model->FSnMCountDataReportAll($aDataCountData);

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
    public function FSvCCallRptExportFile() {
        try {
            $dDateSendMQ = date('Y-m-d');
            $dTimeSendMQ = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode'       => $this->tRptCode,
                    'pnPerFile'       => 20000,
                    'ptUserCode'      => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
                    'pnLngID'         => $this->nLngID,
                    'ptFilter'        => $this->aRptFilter,
                    'ptRptExpType'    => $this->tRptExportType,
                    'ptComName'       => $this->tCompName,
                    'ptDate'          => $dDateSendMQ,
                    'ptTime'          => $dTimeSendMQ,
                    'ptBchCode'       => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
                ]
            ];

            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode'  => $this->tSysBchCode,
                    'ptComName' => $this->tCompName,
                    'ptRptCode' => $this->tRptCode,
                    'ptUserCode' => $this->tUserLoginCode,
                    'ptUserSessionID' => $this->tUserSessionID,
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

}
