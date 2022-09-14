<?php

defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptDailySalesPosSv extends MX_Controller {
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
    

    public function __construct() {
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsalespecial/mRptDailySalesPosSv');

        // Init Report
        $this->init();

        parent::__construct();
    }


    private function init() {
        $this->aText = [

            'tTitleReport'          => language('report/report/report', 'tRptTitleRptDailySalePosSv'),
            'tDatePrint'            => language('report/report/report','tRptDailySalePosSvPrint'),
            'tTimePrint'            => language('report/report/report','tRptDailySalePosSvTime'),

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

            //Header Columns
            'tRptDailySalePosSvDate'        => language('report/report/report','tRptDailySalePosSvDate'),
            'tRptDailySalePosSvbill'        => language('report/report/report','tRptDailySalePosSvbill'),
            'tRptDailySalePosSvPricetotal'  => language('report/report/report','tRptDailySalePosSvPricetotal'),
            'tRptDailySalePosSvPriceDiscount'       => language('report/report/report','tRptDailySalePosSvPriceDiscount'),
            'tRptDailySalePosSvPriceAfterDiscount'  => language('report/report/report','tRptDailySalePosSvPriceAfterDiscount'),
            'tRptDailySalePosSvVatTable'            => language('report/report/report','tRptDailySalePosSvVatTable'),
            'tRptDailySalePosSvVat'     => language('report/report/report','tRptDailySalePosSvVat'),
            'tRptDailySalePosSvAll'     => language('report/report/report','tRptDailySalePosSvAll'),
            'tRptDailySalePosSvEL'      => language('report/report/report','tRptDailySalePosSvEL'),
            'tRptDailySalePosSvDA'      => language('report/report/report','tRptDailySalePosSvDA'),
            'tRptDailySalePosSvTD'      => language('report/report/report','tRptDailySalePosSvTD'),
            'tRptDailySalePosAddrTaxNo' => language('report/report/report','tRptDailySalePosAddrTaxNo'),

            //Fillter Report
            'tRptBchFrom'       => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'         => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'      => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'        => language('report/report/report', 'tRptShopTo'),
            'tRptMerFrom'       => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'         => language('report/report/report', 'tRptMerTo'),
            'tRptPosFrom'       => language('report/report/report','tRptPosFrom'),
            'tRptPosTo'         => language('report/report/report','tRptPosTo'),
            'tRptDateFrom'      => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'        => language('report/report/report', 'tRptDateTo'),
            'tRptDailySalePosType'  => language('report/report/report','tRptDailySalePosType'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptAll'      => language('report/report/report', 'tRptAll'),
            'tRptDailySalePosFooter' => language('report/report/report','tRptDailySalePosFooter'),
            'tRptNoData' => language('report/report/report','tRptNoData'),
            
            // No Data Report
            'tRptTaxSalePosNoData' => language('common/main/main', 'tCMNNotFoundData'),
        ];

        $this->tSysBchCode          = SYS_BCH_CODE;
        $this->tBchCodeLogin        = (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'));
        $this->nPerPage             = 100;
        $this->nOptDecimalShow      = FCNxHGetOptionDecimalShow();

        $tIP                        = $this->input->ip_address();
        $tFullHost                  = gethostbyaddr($tIP);
        $this->tCompName            = $tFullHost;

        $this->nLngID               = FCNaHGetLangEdit();
        $this->tRptCode             = $this->input->post('ohdRptCode');
        $this->tRptGroup            = $this->input->post('ohdRptGrpCode');
        $this->tUserSessionID       = $this->session->userdata('tSesSessionID');
        $this->tRptRoute            = $this->input->post('ohdRptRoute');
        $this->tRptExportType       = $this->input->post('ohdRptTypeExport');
        $this->nPage                = empty($this->input->post('ohdRptCurrentPage')) ? 1 : $this->input->post('ohdRptCurrentPage');
        $this->tUserLoginCode       = $this->session->userdata('tSesUsername');
        $this->nFilterType          = $this->input->post('ohdTypeDataCondition');

        // Report Filter
        $this->aRptFilter = [

            'tUserSession'      => $this->tUserSessionID,
            'tCompName'         => $tFullHost,
            'tRptCode'          => $this->tRptCode,
            'nLangID'           => $this->nLngID,
            'nFilterType'       => $this->nFilterType,

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

            // กลุ่มธุรกิจ
            'tMerCodeFrom'      => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom'      => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo'        => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo'        => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // เครื่องจุดขาย
            'tPosCodeFrom'      => !empty($this->input->post('oetRptPosCodeFrom')) ? $this->input->post('oetRptPosCodeFrom') : "",
            'tPosNameFrom'      => !empty($this->input->post('oetRptPosNameFrom')) ? $this->input->post('oetRptPosNameFrom') : "",
            'tPosCodeTo'        => !empty($this->input->post('oetRptPosCodeTo')) ? $this->input->post('oetRptPosCodeTo') : "",
            'tPosNameTo'        => !empty($this->input->post('oetRptPosNameTo')) ? $this->input->post('oetRptPosNameTo') : "",
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom' => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo' => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",

        ];
        
        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    
    public function index() {
        if (!empty($this->tRptCode) && !empty($this->tRptExportType)) {

            // Call Stored Procedure
            $this->mRptDailySalesPosSv->FSnMExecStoreReport($this->aRptFilter);

             // Count Rows
             $aCountRowParams = [
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUserSession'  => $this->tUserSessionID,
                'aDataFilter'   => $this->aRptFilter
            ];

            // Report Type
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                    break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp();
                    break;
                case 'pdf':
                    // $this->FSvCCallRptRenderExcel($this->aRptFilter);
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
        try{

            $aDataReportParams = [
                'nPerPage'  => $this->nPerPage,
                'nPage'     => $this->nPage,
                'tCompName' => $this->tCompName,
                'tRptCode'  => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aDataFilter'   => $this->aRptFilter
            ];

            //Get Data
            $aDataReport = $this->mRptDailySalesPosSv->FSaMGetDataReport($aDataReportParams);

            //Get Data Sum
            $aDataSumFoot = $this->mRptDailySalesPosSv->FSaMGetDataSumFootReport($aDataReportParams);


            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo' => $this->aCompanyInfo,
                'aDataReport' => $aDataReport,
                'aDataSumFoot' => $aDataSumFoot,
                'aDataTextRef' => $this->aText,
                'aDataFilter' => $this->aRptFilter
            ];

            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptsealdailypossv', 'wRptDailySalesPosSvHtml', $aDataViewRptParams);

             // Data Viewer Center Report
             $aDataViewerParams = [
                'tTitleReport' => $this->aText['tTitleReport'],
                'tRptTypeExport' => $this->tRptExportType,
                'tRptCode' => $this->tRptCode,
                'tRptRoute' => $this->tRptRoute,
                'aDataSumFoot' => $aDataSumFoot,
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
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/10/2562 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage(){

        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);

        $aDataWhere = array(
            'tUserSession'      => $this->tUserSessionID,
            'tCompName'         => $this->tCompName,
            'tUserCode'         => $this->tUserLoginCode,
            'tRptCode'          => $this->tRptCode,
            'nPage'             => $this->nPage,
            'nRow'              => $this->nPerPage,
            'nPerPage'          => $this->nPerPage,
            'tUsrSessionID'     => $this->tUserSessionID,
            'aDataFilter'       => $this->aRptFilter
        );

        //Get Data
        $aDataReport = $this->mRptDailySalesPosSv->FSaMGetDataReport($aDataWhere, $aDataFilter);

        //Get Data Sum
        $aDataSumFoot = $this->mRptDailySalesPosSv->FSaMGetDataSumFootReport($aDataWhere, $aDataFilter);

        $aDataViewRptParams = [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataReport'       => $aDataReport,
            'aDataSumFoot'      => $aDataSumFoot,
            'aDataTextRef'      => $this->aText,
            'aDataFilter'       => $this->aRptFilter
        ];

        $tViewRenderKool = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptsealdailypossv', 'wRptDailySalesPosSvHtml', $aDataViewRptParams);

        // Data Viewer Center Report
        $aDataView = [
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'aDataSumFoot'      => $aDataSumFoot,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $this->aRptFilter,
            'aDataReport'       => [
                    'raItems'           => $aDataReport['aRptData'],
                    'rnAllRow'          => $aDataReport['aPagination']['nTotalRecord'],
                    'rnCurrentPage'     => $aDataReport['aPagination']['nDisplayPage'],
                    'rnAllPage'         => $aDataReport['aPagination']['nTotalPage'],
                    'rtCode'            => '1',
                    'rtDesc'            => 'success',
            ]
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
        try{

            $aDataCountData = [
                'tCompName' => $this->tCompName,
                'tRptCode'  => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
                'aDataFilter' => $this->aRptFilter,
            ];

            $nDataCountPage = $this->mRptDailySalesPosSv->FSnMCountRowInTemp($aDataCountData);

            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent' => 1,
                'tMessage' => 'Success Count Data All'
            );

        }catch(ErrorException $Error){
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
     * Creator: 24/12/2019 Witsarut (BEll)
     * LastUpdate: 02/10/2019 Saharat(Golf)
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile(){
        try{

            $tRptGrpCode        = $this->tRptGroup;
            $tRptCode           = $this->tRptCode;
            $tUserCode          = $this->tUserLoginCode;
            $tSessionID         = $this->tUserSessionID;
            $nLangID            = FCNaHGetLangEdit();
            $tRptExportType     = $this->tRptExportType;
            $tCompName          = $this->tCompName;
            $dDateSendMQ        = date('Y-m-d');
            $dTimeSendMQ        = date('H:i:s');
            $dDateSubscribe     = date('Ymd');
            $dTimeSubscribe     = date('His');

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode'         => $tRptCode,
                    'pnPerFile'         => 20000,
                    'ptUserCode'        => $tUserCode,
                    'ptUserSessionID'   => $tSessionID,
                    'pnLngID'           => $nLangID,
                    'ptFilter'          => $this->aRptFilter,
                    'ptRptExpType'      => $tRptExportType,
                    'ptComName'         => $tCompName,
                    'ptDate'            => $dDateSendMQ,
                    'ptTime'            => $dTimeSendMQ,
                    'ptBchCode'         => (!empty($this->session->userdata('tSesUsrBchCom')) ? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
                ]
            ];

            FCNxReportCallRabbitMQ($aDataSendMQ);

            $aResponse = array(
                'nStaEvent' => 1,
                'tMessage' => 'Success Send Rabbit MQ.',
                'aDataSubscribe' => array(
                    'ptSysBchCode' => $this->tSysBchCode,
                    'ptComName' => $tCompName,
                    'ptRptCode' => $tRptCode,
                    'ptUserCode' => $tUserCode,
                    'ptUserSessionID' => $tSessionID,
                    'pdDateSubscribe' => $dDateSubscribe,
                    'pdTimeSubscribe' => $dTimeSubscribe,
                )
            );

        }catch(Exception $Error){
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }

        echo json_encode($aResponse);
    }

}

