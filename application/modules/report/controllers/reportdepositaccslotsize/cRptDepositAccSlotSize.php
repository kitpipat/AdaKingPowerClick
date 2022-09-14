<?php

defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH . 'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

date_default_timezone_set("Asia/Bangkok");

class cRptDepositAccSlotSize extends MX_Controller {
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
     * Systems Branch Code
     * @var string 
    */
    public $tSysBchCode;

    public function __construct(){
        $this->load->helper('report');
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportdepositaccslotsize/mRptDepositAccSlotSize');
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText = [
            'tTitleReport'      => language('report/report/report', 'tRptTitleDpsSize'),
            'tRptTaxNo'         => language('report/report/report', 'tRptTaxNo'),
            'tRptDatePrint'     => language('report/report/report', 'tRptDatePrint'),
            'tRptDateExport'    => language('report/report/report', 'tRptDateExport'),
            'tRptTimePrint'     => language('report/report/report', 'tRptTimePrint'),
            'tRptPrintHtml'     => language('report/report/report', 'tRptPrintHtml'),
            // Address
            'tRptAddrBuilding'      => language('report/report/report', 'tRptAddrBuilding'),
            'tRptAddrRoad'          => language('report/report/report', 'tRptAddrRoad'),
            'tRptAddrSoi'           => language('report/report/report', 'tRptAddrSoi'),
            'tRptAddrSubDistrict'   => language('report/report/report', 'tRptAddrSubDistrict'),
            'tRptAddrDistrict'      => language('report/report/report', 'tRptAddrDistrict'),
            'tRptAddrProvince'      => language('report/report/report', 'tRptAddrProvince'),
            'tRptAddrTel'           => language('report/report/report', 'tRptAddrTel'),
            'tRptAddrFax'           => language('report/report/report', 'tRptAddrFax'),
            'tRptAddrBranch'        => language('report/report/report', 'tRptAddrBranch'),
            'tRptAddrTaxNo'         => language('report/report/report', 'tRptAddrTaxNo'),
            'tRptAddV2Desc1'        => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2'        => language('report/report/report', 'tRptAddV2Desc2'),
            //Label Text
            'tRptBchFrom'      => language('report/report/report','tRptBchFrom'),
            'tRptBchTo'        => language('report/report/report','tRptBchTo'),
            'tRptPosFrom'      => language('report/report/report','tRptPosFrom'),
            'tRptPosTo'        => language('report/report/report','tRptPosTo'),
            'tRptShopFrom'     => language('report/report/report','tRptShopFrom'),
            'tRptShopTo'       => language('report/report/report','tRptShopTo'),
            'tRptDateFrom'     => language('report/report/report','tRptDateFrom'),
            'tRptDateTo'       => language('report/report/report','tRptDateTo'),
            'tRptMerFrom'      => language('report/report/report','tRptMerFrom'),
            'tRptMerTo'        => language('report/report/report','tRptMerTo'),
            'tRptShopSizeForm' => language('report/report/report','tRptShopSizeForm'),
            'tRptShopSizeTo'   => language('report/report/report','tRptShopSizeTo'),
            'tRptPosIDFrom'    => language('report/report/report','tRptPosIDFrom'),
            'tRptPosIDTo'      => language('report/report/report','tRptPosIDTo'),
            'tRptAll'          => language('report/report/report','tRptAll'),
            
            // Table Report
            'tRptDpsSizeBranch'     => language('report/report/report', 'tRptDpsSizeBranch'),
            'tRptDpsSizeShop'       => language('report/report/report', 'tRptDpsSizeShop'),
            'tRptDpsSizeSize'       => language('report/report/report', 'tRptDpsSizeSize'),
            'tRptDpsSizeRack'       => language('report/report/report', 'tRptDpsSizeRack'),
            'tRptDpsSizeBillAmount' => language('report/report/report', 'tRptDpsSizeBillAmount'),
            'tRptDpsSizeAmount'     => language('report/report/report', 'tRptDpsSizeAmount'),
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptDpsSizeNotFoundData' => language('common/main/main', 'tCMNNotFoundData'),
            'tRptDepositSize'       => language('report/report/report','tRptDepositSize'),
            'tRptDepositPosID'      => language('report/report/report', 'tRptDepositPosID'),
            'tRptDepositBillAmount' => language('report/report/report','tRptDepositBillAmount'),
            'tRptDepositTimeAvg'    => language('report/report/report', 'tRptDepositTimeAvg'),
            'tRptDepositTimeNoData' => language('report/report/report','tRptDepositTimeNoData'),
            'tRptDepositTimeAll'    => language('report/report/report','tRptDepositTimeAll'),
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

      
        // Report Filter Data
        $this->aRptFilter = [
            'tUserSession'      => $this->tUserSessionID,
            'tCompName'         => $this->tCompName,
            'tRptCode'          => $this->tRptCode,
            'nLangID'           => $this->nLngID,

            'tTypeSelect'          => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // Filter Branch (สาขา)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom')) ?  $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom')) ?  $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo')) ?  $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo')) ?  $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // Filter MerChant (กลุ่มธุรกิจ)
            'tMerCodeFrom'      => !empty($this->input->post('oetRptMerCodeFrom')) ?  $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom'      => !empty($this->input->post('oetRptMerNameFrom')) ?  $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo'        => !empty($this->input->post('oetRptMerCodeTo')) ?  $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo'        => !empty($this->input->post('oetRptMerNameTo')) ?  $this->input->post('oetRptMerNameTo') : "",
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // Filter Shop (ร้านค้า)
            'tShopCodeFrom'     => !empty($this->input->post('oetRptShpCodeFrom')) ?  $this->input->post('oetRptShpCodeFrom') : "",
            'tShopNameFrom'     => !empty($this->input->post('oetRptShpNameFrom')) ?  $this->input->post('oetRptShpNameFrom') : "",
            'tShopCodeTo'       => !empty($this->input->post('oetRptShpCodeTo')) ?  $this->input->post('oetRptShpCodeTo') : "",
            'tShopNameTo'       => !empty($this->input->post('oetRptShpNameTo')) ?  $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Pos (จุดขาย)
            'tPosCodeFrom'     => !empty($this->input->post('oetRptLockerCodeFrom')) ? $this->input->post('oetRptLockerCodeFrom') : "",
            'tPosNameFrom'     => !empty($this->input->post('oetRptLockerNameFrom')) ? $this->input->post('oetRptLockerNameFrom') : "",
            'tPosCodeTo'       => !empty($this->input->post('oetRptLockerCodeTo')) ? $this->input->post('oetRptLockerCodeTo') : "",
            'tPosNameTo'       => !empty($this->input->post('oetRptLockerNameTo')) ? $this->input->post('oetRptLockerNameTo') : "",
            'tPosCodeSelect'   => !empty($this->input->post('oetRptLockerCodeSelect')) ? $this->input->post('oetRptLockerCodeSelect') : "",
            'tPosNameSelect'   => !empty($this->input->post('oetRptLockerNameSelect')) ? $this->input->post('oetRptLockerNameSelect') : "",
            'bPosStaSelectAll' => !empty($this->input->post('oetRptLockerStaSelectAll')) && ($this->input->post('oetRptLockerStaSelectAll') == 1) ? true : false,


            // Filter Size (ขนาด)
            'tPzeCodeFrom'      => !empty($this->input->post('oetRptPzeCodeFrom')) ?  $this->input->post('oetRptPzeCodeFrom') : "",
            'tPzeNameFrom'      => !empty($this->input->post('oetRptPzeNameFrom')) ?  $this->input->post('oetRptPzeNameFrom') : "",
            'tPzeCodeTo'        => !empty($this->input->post('oetRptPzeCodeTo')) ?  $this->input->post('oetRptPzeCodeTo') : "",
            'tPzeNameTo'        => !empty($this->input->post('oetRptPzeNameTo')) ?  $this->input->post('oetRptPzeNameTo') : "",
            'tPzeCodeSelect'    => !empty($this->input->post('oetRptPzeCodeSelect')) ? $this->input->post('oetRptPzeCodeSelect') : "",
            'tPzeNameSelect'    => !empty($this->input->post('oetRptPzeNameSelect')) ? $this->input->post('oetRptPzeNameSelect') : "",
            'bPzeStaSelectAll'  => !empty($this->input->post('oetRptPzeStaSelectAll')) && ($this->input->post('oetRptPzeStaSelectAll') == 1) ? true : false,

            // Filter Date (วันที่ออกเอกสาร)
            'tDocDateFrom'      => !empty($this->input->post('oetRptDocDateFrom')) ?  $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'        => !empty($this->input->post('oetRptDocDateTo')) ?  $this->input->post('oetRptDocDateTo') : "",
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
            $this->mRptDepositAccSlotSize->FSnMExecStoreReport($this->aRptFilter);

            $aDataMain  = [
                'tCompName'       => $this->tCompName,
                'tRptCode'        => $this->tRptCode,
                'tSessionID'      => $this->tUserSessionID,
                'ptRptTypeExport' => $this->tRptExportType,
                'paDataFilter'    => $this->aRptFilter
            ];

            // Switch Case Report Type
            switch ($this->tRptExportType) {
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataMain);
                break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp($aDataMain);
                break;
                case 'pdf':
                break;
            }
        }
    }

     /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 03/12/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataMain){
        try{
            $aDataReportParams   = [
                'nPerPage'      => $this->nPerPage,
                'nPage'         => $this->nPage,
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUsrSessionID' => $this->tUserSessionID,
            ];

            //Get data 
            $aDataReport  = $this->mRptDepositAccSlotSize->FSaMGetDataReport($aDataReportParams);

            // Load View Advance Table
            $aDataViewRptParams = [
                'nOptDecimalShow' => $this->nOptDecimalShow,
                'aCompanyInfo'    => $this->aCompanyInfo,
                'aDataReport'     => $aDataReport,
                'aDataTextRef'    => $this->aText,
                'aDataFilter'     => $this->aRptFilter
            ];

            $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/rptdepositaccslotsize', 'wRptDepositAccSlotSizeHtml', $aDataViewRptParams);

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
                ]
            ];

            $this->load->view('report/report/wReportViewer',$aDataViewerParams);

        }catch(Exception $Error){
            echo $Error;
        }
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/07/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage(){
       
        /*===== Begin Init Filter ======================================================*/
        $aDataFilter     = json_decode($this->input->post('ohdRptDataFilter'),true);

        /*===== Begin Get Data =========================================================*/
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams  = [
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        ];

        $aDataReport    = $this->mRptDepositAccSlotSize->FSaMGetDataReport($aDataReportParams);

        $aDataViewRptParams = array(
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aCompanyInfo'    => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataReport'     => $aDataReport,
            'aDataTextRef'    => $this->aText,
            'aDataFilter'     => $aDataFilter
        );
        
        $tViewReportHtml = JCNoHLoadViewAdvanceTable('report/datasources/rptdepositaccslotsize', 'wRptDepositAccSlotSizeHtml', $aDataViewRptParams);

       
        $aDataViewerParams = [
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewReportHtml,
            'aDataFilter' => $aDataFilter,
            'aDataReport' => [
                'raItems' => $aDataReport['aRptData'],
                'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success'
            ]
        ];

        $this->load->view('report/report/wReportViewer', $aDataViewerParams);
        /*===== End Render View ========================================================*/
    }


    /**
     * Functionality: Count Data Report In DB Temp
     * Parameters:  Function Parameter
     * Creator: 04/12/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: Object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataMain){
        try{
            
            $aDataCountData = [
                'tCompName'     => $paDataMain['paDataFilter']['tCompName'],
                'tRptCode'      => $paDataMain['paDataFilter']['tRptCode'],
                'tUserSession'  => $paDataMain['paDataFilter']['tUserSession'],
            ];

            $nDataCountPage =  $this->mRptDepositAccSlotSize->FSnMCountRowInTemp($aDataCountData);

            $aResponse =  array(
                'nCountPageAll'     => $nDataCountPage,
                'nStaEvent'         => 1,
                'tMessage'          => 'Success Count data All'
            );
        }catch(Exception $Error){
            $aResponse      = array(
                'nStaEvent' => 500,
                'tMessage'  => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }


     /**
     * Functionality: Send Rabbit MQ Report Excel
     * Parameters:  Function Parameter
     * Creator: 15/07/2019 Witsarut(Bell)
     * LastUpdate: -
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile(){
        try{
            $dDateSendMQ    = date('Y-m-d');
            $dTimeSendMQ    = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');
            // Set QueueName 
            $tRptQueueName  = 'RPT_'.$this->tSysBchCode.'_'.$this->tRptGroup.'_'.$this->tRptCode;

            // Data Params Report
            $aDataSendMQ = [
                'tQueueName'    => $tRptQueueName,
                'aParams'       => [
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
                'nStaEvent'         => 1,
                'tMessage'          => 'Success Send Rabbit MQ.',
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
        }catch(Exception $Error){
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => 'Error Cannot Send Data Rabbit MQ  Report Sale Shop Group. !!!'
            );
        }
        echo json_encode($aResponse);
    }


}












