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

class cRptCardDetail extends MX_Controller {

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
        $this->load->model('report/report/mReport');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/reportcard/mRptCardDetail');

        // Init Report
        $this->init();

        parent::__construct();
    }

    private function init() {
        $this->aText = [

            'tTitleReport'              => language('report/report/report','tRPCTitleRptCardDetail'),
            'tRptTaxNo'                 => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'             => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'            => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'             => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'             => language('report/report/report', 'tRptPrintHtml'),
            'tRptBranch'                => language('report/report/report', 'tRptAddrBranch'),
            'tRptFaxNo'                 => language('report/report/report', 'tRptAddrFax'),
            'tRptTel'                   => language('report/report/report', 'tRptAddrTel'),
            'tRPCTaxNo' => language('report/report/report', 'tRPCTaxNo'),
            // Filter Heard Report
            'tRptCardCodeFrom'          => language('report/report/report', 'tRptCardCodeFrom'),
            'tRptCardCodeTo'            => language('report/report/report', 'tRptCardCodeTo'),
            'tRPCEmpCodeFrom'           => language('report/report/report', 'tRPCEmpCodeFrom'),
            'tRPCEmpCodeTo'             => language('report/report/report', 'tRPCEmpCodeTo'),
            'tRPCStaCrdFrom'            => language('report/report/report', 'tRPCStaCrdFrom'),
            'tRPCStaCrdTo'              => language('report/report/report', 'tRPCStaCrdTo'),
            'tRptDateFrom'              => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'                => language('report/report/report', 'tRptDateTo'),
            'tRPCCrdTypeFrom'           => language('report/report/report', 'tRPCCrdTypeFrom'),
            'tRPCCrdTypeTo'             => language('report/report/report', 'tRPCCrdTypeTo'),
            'tRptDateStarFrom'          => language('report/report/report', 'tRptDateStarFrom'),
            'tRptDateStarTo'            => language('report/report/report', 'tRptDateStarTo'),
            'tRptDateExpireFrom'        => language('report/report/report', 'tRptDateExpireFrom'),
            'tRptDateExpireTo'          => language('report/report/report', 'tRptDateExpireTo'),

            /** Table Report */
            'tRPC11TBCardCode'          => language('report/report/report','tRPC11TBCardCode'),
            'tRPC11TBCardName'          => language('report/report/report','tRPC11TBCardName'),
            'tRPC11TBCardFormat'        => language('report/report/report','tRPC11TBCardFormat'),
            'tRPC11TBCardType'          => language('report/report/report','tRPC11TBCardType'),
            'tRPC11TBCardDateStart'     => language('report/report/report','tRPC11TBCardDateStart'),
            'tRPC11TBCardDateExpire'    => language('report/report/report','tRPC11TBCardDateExpire'),
            'tRPC11TBCardStatus'        => language('report/report/report','tRPC11TBCardStatus'),
            'tRPC11TBCardStatusExpire'  => language('report/report/report','tRPC11TBCardStatusExpire'),
            'tRPC11TBCardBalance'       => language('report/report/report','tRPC11TBCardBalance'),

            /** Status Teble Ref */
            'tRPCCardDetailStaType1'    => language('report/report/report','tRPCCardDetailStaType1'),
            'tRPCCardDetailStaType2'    => language('report/report/report','tRPCCardDetailStaType2'),
            'tRPCCardDetailStaActive1'  => language('report/report/report','tRPCCardDetailStaActive1'),
            'tRPCCardDetailStaActive2'  => language('report/report/report','tRPCCardDetailStaActive2'),
            'tRPCCardDetailStaActive3'  => language('report/report/report','tRPCCardDetailStaActive3'),
            'tRPCCardDetailStaExpr1'    => language('report/report/report','tRPCCardDetailStaExpr1'),
            'tRPCCardDetailStaExpr2'    => language('report/report/report','tRPCCardDetailStaExpr2'),
            'tRptConditionInReport'     => language('report/report/report', 'tRptConditionInReport'),
            'tRPCTBFooterSumAll'        => language('report/report/report','tRPCTBFooterSumAll'),

            'tRptBchFrom'    => language('report/report/report','tRptBchFrom'),
            'tRptBchTo'      => language('report/report/report','tRptBchTo'),
            'tRptAll'        => language('report/report/report','tRptAll'),
            'tRptMerFrom'    => language('report/report/report','tRptMerFrom'),
            'tRptMerTo'      => language('report/report/report','tRptMerTo'),
            'tRptShopFrom'   => language('report/report/report','tRptShopFrom'),
            'tRptShopTo'     => language('report/report/report','tRptShopTo'),
            'tRptPosFrom'   => language('report/report/report','tRptPosFrom'),
            'tRptPosTo'     => language('report/report/report','tRptPosTo'),
        ];



        $this->tSysBchCode     = SYS_BCH_CODE;
        $this->tBchCodeLogin   = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage        = 100;
        $this->nOptDecimalShow = FCNxHGetOptionDecimalShow();

        $tIP             = $this->input->ip_address();
        $tFullHost       = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;

        $this->nLngID         = FCNaHGetLangEdit();
        $this->tRptCode       = $this->input->post('ohdRptCode');
        $this->tRptGroup      = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID = $this->session->userdata('tSesSessionID');
        $this->tRptRoute      = $this->input->post('ohdRptRoute');
        $this->tRptExportType = $this->input->post('ohdRptTypeExport');
        $this->nPage          = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode = $this->session->userdata('tSesUsername');

         // Report Filter
         $this->aRptFilter = [
            'tUserSession' => $this->tUserSessionID,
            'tCompName'    => $this->tCompName,
            'tRptCode'     => $this->tRptCode,
            'nLangID'      => $this->nLngID,

            'tTypeSelect'   => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // ประเภทบัตร
            'tRptCardTypeCodeFrom'     => !empty($this->input->post('oetRptCardTypeCodeFrom')) ? $this->input->post('oetRptCardTypeCodeFrom') : '',
            'tRptCardTypeNameFrom'     => !empty($this->input->post('oetRptCardTypeNameFrom')) ? $this->input->post('oetRptCardTypeNameFrom') : '',
            'tRptCardTypeCodeTo'       => !empty($this->input->post('oetRptCardTypeCodeTo')) ? $this->input->post('oetRptCardTypeCodeTo') : '',
            'tRptCardTypeNameTo'       => !empty($this->input->post('oetRptCardTypeNameTo')) ? $this->input->post('oetRptCardTypeNameTo') : '',

            // หมายเลขบัตร
            'tRptCardCode'             => !empty($this->input->post('oetRptCardCodeFrom')) ? $this->input->post('oetRptCardCodeFrom') : '',
            'tRptCardName'             => !empty($this->input->post('oetRptCardNameFrom')) ? $this->input->post('oetRptCardNameFrom') : '',
            'tRptCardCodeTo'           => !empty($this->input->post('oetRptCardCodeTo')) ? $this->input->post('oetRptCardCodeTo') : '',
            'tRptCardNameTo'           => !empty($this->input->post('oetRptCardNameTo')) ? $this->input->post('oetRptCardNameTo') : '',

            // สถานะบัตร
            'ocmRptStaCardFrom'        => !empty($this->input->post('ocmRptStaCardFrom')) ? $this->input->post('ocmRptStaCardFrom') : "",
            'tRptStaCardFrom'          => !empty($this->input->post('ohdRptStaCardNameFrom')) ? $this->input->post('ohdRptStaCardNameFrom') : "",
            'ocmRptStaCardTo'          => !empty($this->input->post('ocmRptStaCardTo')) ? $this->input->post('ocmRptStaCardTo') : "",
            'tRptStaCardTo'            => !empty($this->input->post('ohdRptStaCardNameTo')) ? $this->input->post('ohdRptStaCardNameTo') : "",

            // จากวันที่เริ่มต้นใช้งาน
            'tRptDateStartFrom'        => !empty($this->input->post('oetRptDateStartFrom')) ? $this->input->post('oetRptDateStartFrom') : "",
            'tRptDateStartTo'          => !empty($this->input->post('oetRptDateStartTo')) ? $this->input->post('oetRptDateStartTo') : "",

            // จากวันที่หมดอายุ
            'tRptDateExpireFrom'       => !empty($this->input->post('oetRptDateExpireFrom')) ? $this->input->post('oetRptDateExpireFrom') : "",
            'tRptDateExpireTo'         => !empty($this->input->post('oetRptDateExpireTo')) ? $this->input->post('oetRptDateExpireTo') : "",

            // สาขา(Branch)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ตัวแทนขาย (Agency)
            'tRptAgnCode'       => !empty($this->input->post('oetSpcAgncyCode')) ? $this->input->post('oetSpcAgncyCode') : "",

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
            $this->mRptCardDetail->FSnMExecStoreReport($this->aRptFilter);

            $aDataSwitchCase = array(
                'ptRptRoute'      => $this->tRptRoute,
                'ptRptCode'       => $this->tRptCode,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter'    => $this->aRptFilter
            );

            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                    break;
                case 'excel':
                    $this->FSvCCallRptRenderExcel();
                    break;
                // case 'pdf':
                //     $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                //     break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 29/10/2019 Saharat(GolF)
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase) {
        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName'    => $this->tCompName,
            'tUserCode'    => $this->tUserLoginCode,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => 1, // เริ่มทำงานหน้าแรก
            'nRow'         => $this->nPerPage,
        );

        // Get Data Report
        $aDataReport = $this->mRptCardDetail->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        // Call View Report
        $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $this->aRptFilter);


        $aDataView = array(
            'aCompanyInfo'    => $this->aCompanyInfo,
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter'     => $this->aRptFilter,
            'aDataReport'     => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

     /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 10/10/2019 Piya
     * LastUpdate: 1/11/2019 Saharat(GolF)
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /*===== Begin Init Variable ====================================================*/
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /*===== End Init Variable ======================================================*/

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName'    => $this->tCompName,
            'tUserCode'    => $this->tUserLoginCode,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => $this->nPage,
            'nRow'         => $this->nPerPage,
        );
        $aDataReport = $this->mRptCardDetail->FSaMGetDataReport($aDataWhere, $aDataFilter);

        if (!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport, $aDataFilter);
        } else {
            $tViewRenderKool = "";
        }

        $aDataView = array(
            'tTitleReport'    => $this->aText['tTitleReport'],
            'tRptTypeExport'  => $this->tRptExportType,
            'tRptCode'        => $this->tRptCode,
            'tRptRoute'       => $this->tRptRoute,
            'tViewRenderKool' => $tViewRenderKool,
            'aDataFilter'     => $aDataFilter,
            'aDataReport'     => $aDataReport
        );
        $this->load->view('report/report/wReportViewer', $aDataView);
    }

    /**
     * Functionality: Call Rpt Table Kool Report
     * Parameters:  Function Parameter
     * Creator: 29/10/2019 saharat(GolF)
     * LastUpdate: -
     * Return: View Kool Report
     * ReturnType: View
     */
    public function FCNvCRenderKoolReportHtml($paDataReport, $paDataFilter) {

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName'    => $this->tCompName,
            'tUserCode'    => $this->tUserLoginCode,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => $this->nPage,
            'nRow'         => $this->nPerPage,
        );
        $aDataReport = $this->mRptCardDetail->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        if($aDataReport['rnCurrentPage'] == @$aDataReport['rnAllPage']){
            // เรียก Summary เฉพาะหน้าสุดท้าย
            $aSumDataReport = $this->mRptCardDetail->FSaMRPTCRDGetDataRptCardDetailSum($this->aRptFilter);
        }

        // Ref File Kool Report
        require_once APPPATH . 'modules\report\datasources\reportcard\rptCardDetail\rRptCardDetail.php';

        // Set Parameter To Report
        $oRptCardDetail = new       rRptCardDetail(array(
                'nCurrentPage'      => $paDataReport['rnCurrentPage'],
                'nAllPage'          => $paDataReport['rnAllPage'],
                'aCompanyInfo'      => $this->aCompanyInfo,
                'aFilterReport'     => $paDataFilter,
                'aDataTextRef'      => $this->aText,
                'aDataReturn'       => $paDataReport,
                'nOptDecimalShow'   => $this->nOptDecimalShow,
                'aSumDataReport'    => isset($aSumDataReport) ? $aSumDataReport : []
        ));

        $oRptCardDetail->run();
        $tHtmlViewReport = $oRptCardDetail->render('wRptCardDetailHtml', true);
        return $tHtmlViewReport;
    }

      /**
     * Functionality: Render Excel Report
     * Parameters:  Function Parameter
     * Creator: 22/12/2020 Sooksanti
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

        $oStyleColums = (new StyleBuilder())
        ->setFontBold()
        ->setBorder($oBorder)
        ->build();

        $aCells = [
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardCode']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardName']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardFormat']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardType']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardDateStart']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardDateExpire']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardStatus']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardStatusExpire']),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell($this->aText['tRPC11TBCardBalance']),
            WriterEntityFactory::createCell(null),
        ];

        /** add a row at a time */
        $singleRow = WriterEntityFactory::createRow($aCells,$oStyleColums);
        $oWriter->addRow($singleRow);

        $aDataWhere = array(
            'tUserSession' => $this->tUserSessionID,
            'tCompName'    => $this->tCompName,
            'tUserCode'    => $this->tUserLoginCode,
            'tRptCode'     => $this->tRptCode,
            'nPage'        => 1, // เริ่มทำงานหน้าแรก
            'nRow'         => 999999999,
        );

        // Get Data Report
        $aDataReport = $this->mRptCardDetail->FSaMGetDataReport($aDataWhere, $this->aRptFilter);

        /** Create a style with the StyleBuilder */
        $oStyle = (new StyleBuilder())
        ->setCellAlignment(CellAlignment::RIGHT)
        ->build();

        if(isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) {
            foreach ($aDataReport['raItems'] as $nKey => $aValue) {
                $tCrdStaActive = '';
                $tCrdStaExpr = '';
                switch ($aValue['FTCrdStaActive']) {
                    case '1':
                        $tCrdStaActive = $this->aText['tRPCCardDetailStaActive1'];
                        break;
                    case '2':
                        $tCrdStaActive = $this->aText['tRPCCardDetailStaActive2'];
                        break;
                    case '3':
                        $tCrdStaActive = $this->aText['tRPCCardDetailStaActive3'];
                        break;
                }

                switch ($aValue['FNCrdStaExpr']) {
                    case '1':
                        $tCrdStaExpr = $this->aText['tRPCCardDetailStaExpr1'];
                        break;
                    case '2':
                        $tCrdStaExpr = $this->aText['tRPCCardDetailStaExpr2'];
                        break;
                }

                switch($aValue['FTCrdStaType']){
                    case '1':
                        $tCrdStaType = $this->aText['tRPCCardDetailStaType1'];
                        break;
                    case '2':
                        $tCrdStaType = $this->aText['tRPCCardDetailStaType2'];
                        break;
                    default:
                        $tCrdStaType = '';
                }

                $values= [
                    WriterEntityFactory::createCell($aValue['FTCrdCode']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTCrdName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tCrdStaType),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($aValue['FTCtyName']),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(date_format(date_create($aValue['FDCrdStartDate']),'d/m/Y')),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(date_format(date_create($aValue['FDCrdExpireDate']),'d/m/Y')),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tCrdStaActive),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell($tCrdStaExpr),
                    WriterEntityFactory::createCell(null),
                    WriterEntityFactory::createCell(FCNnGetNumeric($aValue['FCCrdValue'])),
                    WriterEntityFactory::createCell(null),
                ];

                $aRow = WriterEntityFactory::createRow($values);

                $oWriter->addRow($aRow);
                if(($nKey+1)==FCNnHSizeOf($aDataReport['raItems'])){ //SumFooter

                    $aSumDataReport = $this->mRptCardDetail->FSaMRPTCRDGetDataRptCardDetailSum($this->aRptFilter);
                    $values= [
                        WriterEntityFactory::createCell($this->aText['tRPCTBFooterSumAll']),
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
                        WriterEntityFactory::createCell(FCNnGetNumeric($aSumDataReport[0]['FCCrdValue'])),
                        WriterEntityFactory::createCell(null),
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
     * Creator: 22/12/2020 Sooksanti
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
            WriterEntityFactory::createCell($this->aText['tRptBranch'] .' '. $tFTBchName),
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
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell(NULL),
                WriterEntityFactory::createCell($this->aText['tRPCDateFrom'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateFrom'])).' '.$this->aText['tRPCDateTo'].' '.date('d/m/Y',strtotime($this->aRptFilter['tDocDateTo']))),
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
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(null),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell($this->aText['tRptDatePrint'].' '.date('d/m/Y').' '.$this->aText['tRptTimePrint'].' '.date('H:i:s')),
            WriterEntityFactory::createCell(NULL),
            WriterEntityFactory::createCell(NULL),
        ];

        $aMulltiRow[] = WriterEntityFactory::createRow($aCells);

        return $aMulltiRow;

    }


        /**
     * Functionality: Render Excel Report Footer
     * Parameters:  Function Parameter
     * Creator: 22/12/2020 Sooksanti
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

        // Fillterฺ Pos (เครื่องจุดขาย)) แบบช่วง
        if (!empty($this->aRptFilter['tPosCodeFrom']) && !empty($this->aRptFilter['tPosCodeTo'])) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptPosFrom'] . ' : ' . $this->aRptFilter['tPosNameFrom'] . '     ' . $this->aText['tRptPosTo'] . ' : ' . $this->aRptFilter['tPosNameTo']),
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

        if ((isset($this->aRptFilter['tRptCardCode']) && !empty($this->aRptFilter['tRptCardCode'])) && (isset($this->aRptFilter['tRptCardNameTo']) && !empty($this->aRptFilter['tRptCardNameTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptCardCodeFrom'] . ' : ' .$this->aRptFilter['tRptCardName']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRptCardCodeTo'] . ' : ' .$this->aRptFilter['tRptCardNameTo']),
                WriterEntityFactory::createCell(null),

            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }

        if ((isset($this->aRptFilter['tRptCardTypeCodeFrom']) && !empty($this->aRptFilter['tRptCardTypeCodeFrom'])) && (isset($this->aRptFilter['tRptCardTypeCodeTo']) && !empty($this->aRptFilter['tRptCardTypeCodeTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRPCCrdTypeFrom'] . ' : ' .$this->aRptFilter['tRptCardTypeNameFrom']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRPCCrdTypeTo'] . ' : ' .$this->aRptFilter['tRptCardTypeNameTo']),
                WriterEntityFactory::createCell(null),

            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }


        if ((isset($this->aRptFilter['ocmRptStaCardFrom']) && !empty($this->aRptFilter['ocmRptStaCardFrom'])) && (isset($this->aRptFilter['ocmRptStaCardTo']) && !empty($this->aRptFilter['ocmRptStaCardTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRPCStaCrdFrom'] . ' : ' .$this->aRptFilter['tRptStaCardFrom']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRPCStaCrdTo'] . ' : ' .$this->aRptFilter['tRptStaCardTo']),
                WriterEntityFactory::createCell(null),

            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }


        if ((isset($this->aRptFilter['tRptDateStartFrom']) && !empty($this->aRptFilter['tRptDateStartFrom'])) && (isset($this->aRptFilter['tRptDateStartTo']) && !empty($this->aRptFilter['tRptDateStartTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptDateStarFrom'] . ' : ' .$this->aRptFilter['tRptDateStartFrom']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRptDateStarTo'] . ' : ' .$this->aRptFilter['tRptDateStartTo']),
                WriterEntityFactory::createCell(null),

            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }

        if ((isset($this->aRptFilter['tRptDateExpireFrom']) && !empty($this->aRptFilter['tRptDateExpireFrom'])) && (isset($this->aRptFilter['tRptDateExpireTo']) && !empty($this->aRptFilter['tRptDateExpireTo']))) {
            $aCells = [
                WriterEntityFactory::createCell($this->aText['tRptDateExpireFrom'] . ' : ' .$this->aRptFilter['tRptDateExpireFrom']),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell(null),
                WriterEntityFactory::createCell($this->aText['tRptDateExpireTo'] . ' : ' .$this->aRptFilter['tRptDateExpireTo']),
                WriterEntityFactory::createCell(null),

            ];
            $aMulltiRow[] = WriterEntityFactory::createRow($aCells);
        }

        return $aMulltiRow;

    }


}
