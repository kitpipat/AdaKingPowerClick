<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cRptBookingLocker extends MX_Controller {

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

    public function __construct() {
        $this->load->model('company/company/mCompany');
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportlocker/mRptBookingLocker');
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText    = [
            'tTitleReport'          => language('report/report/report','tRptBookingLockerTitle'),
            'tDatePrint'            => language('report/report/report','tRptDatePrint'),
            'tTimePrint'            => language('report/report/report','tRptTimePrint'),
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
            'tRptAddrTaxNo'         => language('report/report/report', 'tRptAddrTaxNo'),
            'tRptAddV2Desc1'        => language('report/report/report', 'tRptAddV2Desc1'),
            'tRptAddV2Desc2'        => language('report/report/report', 'tRptAddV2Desc2'),
            // Filter Text Label
            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptPosLockerFrom'     => language('report/report/report', 'tRptPosLockerFrom'),
            'tRptPosLockerTo'       => language('report/report/report', 'tRptPosLockerTo'),
            'tRptPosFrom'           => language('report/report/report', 'tRptPosLockerFrom'),
            'tRptPosTo'             => language('report/report/report', 'tRptPosLockerTo'),
            'tRptShopSizeForm'      => language('report/report/report', 'tRptShopSizeForm'),
            'tRptShopSizeTo'        => language('report/report/report', 'tRptShopSizeTo'),
            'tRptDateFrom'          => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report', 'tRptDateTo'),
            'tRptStaBooking'        => language('report/report/report', 'tRptStaBooking'),
            'tRptStaProducer'       => language('report/report/report', 'tRptStaProducer'),
            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
            // Status Booking
            'tRptStaBookingAll'     => language('report/report/report', 'tRptStaBookingAll'),
            'tRptStaBooking1'       => language('report/report/report', 'tRptStaBooking1'),
            'tRptStaBooking2'       => language('report/report/report', 'tRptStaBooking2'),
            'tRptStaBooking3'       => language('report/report/report', 'tRptStaBooking3'),
            'tRptStaBooking4'       => language('report/report/report', 'tRptStaBooking4'),
            // Status Producer
            'tRptStaProducerAll'    => language('report/report/report', 'tRptStaProducerAll'),
            'tRptStaProducer1'      => language('report/report/report', 'tRptStaProducer1'),
            'tRptStaProducer2'      => language('report/report/report', 'tRptStaProducer2'),
            // Table Heard Label
            'tRptBookingLockerBranch'       => language('report/report/report', 'tRptBookingLockerBranch'),
            'tRptBookingLockerShop'         => language('report/report/report', 'tRptBookingLockerShop'),
            'tRptBookingLockerPosLK'        => language('report/report/report', 'tRptBookingLockerPosLK'),
            'tRptBookingLockerDocNo'        => language('report/report/report', 'tRptBookingLockerDocNo'),
            'tRptBookingLockerDocDate'      => language('report/report/report', 'tRptBookingLockerDocDate'),
            'tRptBookingLockerDocTime'      => language('report/report/report', 'tRptBookingLockerDocTime'),
            'tRptBookingLockerLayNo'        => language('report/report/report', 'tRptBookingLockerLayNo'),
            'tRptBookingLockerSize'         => language('report/report/report', 'tRptBookingLockerSize'),
            'tRptBookingLockerRate'         => language('report/report/report', 'tRptBookingLockerRate'),
            'tRptBookingLockerUser'         => language('report/report/report', 'tRptBookingLockerUser'),
            'tRptBookingLockerRefCst'       => language('report/report/report', 'tRptBookingLockerRefCst'),
            'tRptBookingLockerRefCstDoc'    => language('report/report/report', 'tRptBookingLockerRefCstDoc'),
            'tRptBookingLockerRefCstLogin'  => language('report/report/report', 'tRptBookingLockerRefCstLogin'),
            'tRptBookingLockerProducer'     => language('report/report/report', 'tRptBookingLockerProducer'),
            'tRptBookingLockerStaBook'      => language('report/report/report', 'tRptBookingLockerStaBook'),
            // Report Text Condtion Other Report
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            // No Data Report
            'tRptNotFoundData'      => language('common/main/main', 'tCMNNotFoundData'),
            'tRptAll'               => language('report/report/report', 'tRptAll')
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
        
        $this->aRptFilter       = [
            'tUsrSessionID' => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'tCode'         => $this->tRptCode,
            'nLangID'       => $this->nLngID,

            'tTypeSelect'       => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",
            
            // สาขา(Branch)
            'tBchCodeFrom'      => !empty($this->input->post('oetRptBchCodeFrom'))  ? $this->input->post('oetRptBchCodeFrom')   : "",
            'tBchNameFrom'      => !empty($this->input->post('oetRptBchNameFrom'))  ? $this->input->post('oetRptBchNameFrom')   : "",
            'tBchCodeTo'        => !empty($this->input->post('oetRptBchCodeTo'))    ? $this->input->post('oetRptBchCodeTo')     : "",
            'tBchNameTo'        => !empty($this->input->post('oetRptBchNameTo'))    ? $this->input->post('oetRptBchNameTo')     : "",
            'tBchCodeSelect'    => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'    => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'  => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom'      => !empty($this->input->post('oetRptShpCodeFrom'))  ? $this->input->post('oetRptShpCodeFrom')   : "",
            'tShpNameFrom'      => !empty($this->input->post('oetRptShpNameFrom'))  ? $this->input->post('oetRptShpNameFrom')   : "",
            'tShpCodeTo'        => !empty($this->input->post('oetRptShpCodeTo'))    ? $this->input->post('oetRptShpCodeTo')     : "",
            'tShpNameTo'        => !empty($this->input->post('oetRptShpNameTo'))    ? $this->input->post('oetRptShpNameTo')     : "",
            'tShpCodeSelect'    => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'    => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'  => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // เครื่องจุดขาย
            'tPosCodeFrom'    => !empty($this->input->post('oetRptLockerCodeFrom')) ? $this->input->post('oetRptLockerCodeFrom') : "",
            'tPosNameFrom'    => !empty($this->input->post('oetRptLockerNameFrom')) ? $this->input->post('oetRptLockerNameFrom') : "",
            'tPosCodeTo'      => !empty($this->input->post('oetRptLockerCodeTo')) ? $this->input->post('oetRptLockerCodeTo') : "",
            'tPosNameTo'      => !empty($this->input->post('oetRptLockerNameTo')) ? $this->input->post('oetRptLockerNameTo') : "",
            'tPosCodeSelect'  => !empty($this->input->post('oetRptLockerCodeSelect')) ? $this->input->post('oetRptLockerCodeSelect') : "",
            'tPosNameSelect'  => !empty($this->input->post('oetRptLockerNameSelect')) ? $this->input->post('oetRptLockerNameSelect') : "",
            'bPosStaSelectAll' => !empty($this->input->post('oetRptLockerStaSelectAll')) && ($this->input->post('oetRptLockerStaSelectAll') == 1) ? true : false,
            // 'tPosCodeFrom'      => !empty($this->input->post('oetRptPosCodeFrom'))  ? $this->input->post('oetRptPosCodeFrom')   : "",
            // 'tPosNameFrom'      => !empty($this->input->post('oetRptPosNameFrom'))  ? $this->input->post('oetRptPosNameFrom')   : "",
            // 'tPosCodeTo'        => !empty($this->input->post('oetRptPosCodeTo'))    ? $this->input->post('oetRptPosCodeTo')     : "",
            // 'tPosNameTo'        => !empty($this->input->post('oetRptPosNameTo'))    ? $this->input->post('oetRptPosNameTo')     : "",
            // 'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            // 'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            // 'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // กลุ่มธุรกิจ
            'tMerCodeFrom'   => !empty($this->input->post('oetRptMerCodeFrom')) ? $this->input->post('oetRptMerCodeFrom') : "",
            'tMerNameFrom'   => !empty($this->input->post('oetRptMerNameFrom')) ? $this->input->post('oetRptMerNameFrom') : "",
            'tMerCodeTo'     => !empty($this->input->post('oetRptMerCodeTo')) ? $this->input->post('oetRptMerCodeTo') : "",
            'tMerNameTo'     => !empty($this->input->post('oetRptMerNameTo')) ? $this->input->post('oetRptMerNameTo') : "",
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // ขนาดช่องฝาก
            'tPzeCodeFrom'      => !empty($this->input->post('oetRptPzeCodeFrom'))  ? $this->input->post('oetRptPzeCodeFrom')   : "",
            'tPzeNameFrom'      => !empty($this->input->post('oetRptPzeNameFrom'))  ? $this->input->post('oetRptPzeNameFrom')   : "",
            'tPzeCodeTo'        => !empty($this->input->post('oetRptPzeCodeTo'))    ? $this->input->post('oetRptPzeCodeTo')     : "",
            'tPzeNameTo'        => !empty($this->input->post('oetRptPzeNameTo'))    ? $this->input->post('oetRptPzeNameTo')     : "",
            'tPzeCodeSelect'    => !empty($this->input->post('oetRptPzeCodeSelect')) ? $this->input->post('oetRptPzeCodeSelect') : "",
            'tPzeNameSelect'    => !empty($this->input->post('oetRptPzeNameSelect')) ? $this->input->post('oetRptPzeNameSelect') : "",
            'bPzeStaSelectAll'  => !empty($this->input->post('oetRptPzeStaSelectAll')) && ($this->input->post('oetRptPzeStaSelectAll') == 1) ? true : false,

            // วันที่  
            'tDocDateFrom'  => !empty($this->input->post('oetRptDocDateFrom'))  ? $this->input->post('oetRptDocDateFrom')   : "",
            'tDocDateTo'    => !empty($this->input->post('oetRptDocDateTo'))    ? $this->input->post('oetRptDocDateTo')     : "",

            // สถานะการจอง
            'tStaBooking'   => !empty($this->input->post('ocmRptStaBooking'))   ? $this->input->post('ocmRptStaBooking')    : "",
            
            // ระบบการจอง
            'tStaProducer'  => !empty($this->input->post('ocmRptStaProducer'))  ? $this->input->post('ocmRptStaProducer')   : "",
        ];
        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if(!empty($this->tRptCode) && !empty($this->tRptExportType)) {
            $this->mRptBookingLocker->FSnMExecStoreReport($this->aRptFilter);
            switch($this->tRptExportType){
                case 'html':
                    $this->FSvCCallRptViewBeforePrint();
                break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp();
                break;
            }
        }
    }

    // Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 27/11/2019 Wasin(Mr.JW)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrint() {
        // ดึงข้อมูลจากฐานข้อมูล Temp
        $aDataReportParams = [
            'tUsrSessionID' => $this->tUserSessionID,
            'tCompName'     => $this->tCompName,
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tRptCode'      => $this->tRptCode
        ];
        $aDataReport    = $this->mRptBookingLocker->FSaMGetDataReport($aDataReportParams);
        // Load View Show Report
        $aDataViewRptParams = [
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aDataFilter'       => $this->aRptFilter
        ];
        $tRptView   = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/rptBookingLocker','wRptBookingLockerHtml',$aDataViewRptParams);
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
            ]
        ];
        $this->load->view('report/report/wReportViewer',$aDataViewerParams);
    }

    // Functionality: Click Pagination ดูตัวอย่างก่อนพิมพ์
    // Parameters:  Function Parameter
    // Creator: 29/11/2019 Wasin(Mr.JW)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrintClickPage() {
        /** =========== Begin Init Variable ================================== */
        $aDataFilter    = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'      => $this->nPerPage,
            'nPage'         => $this->nPage,
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
        );
        $aDataReport = $this->mRptBookingLocker->FSaMGetDataReport($aDataWhereRpt);
        // ข้อมูล Render Report
        $aDataViewRptParams = array(
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aDataFilter'       => $aDataFilter
        );
        $tRptView   = JCNoHLoadViewAdvanceTable('report/datasources/reportlocker/rptBookingLocker','wRptBookingLockerHtml',$aDataViewRptParams);
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
                'rtDesc'    => 'success',
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    // Functionality: Check Data Report Temp
    // Parameters:  Function Parameter
    // Creator: 29/11/2019 Wasin(Mr.JW)
    // Return: object Status Count Data Report
    // ReturnType: Object
    public function FSoCChkDataReportInTableTemp(){
        $aDataCountData = [
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUserSession'  => $this->tUserSessionID,
        ];
        $nDataCountPage = $this->mRptBookingLocker->FSnMCountDataReportAll($aDataCountData);
        $aResponse = array(
            'nCountPageAll' => $nDataCountPage,
            'nStaEvent'     => 1,
            'tMessage'      => 'Success Count Data All'
        );
        echo json_encode($aResponse);
    }
    
    // Functionality: Send Rabbit MQ Report
    // Parameters:  Function Parameter
    // Creator: 02/12/2019 Wasin(Yoshi)
    // Return: object Send Rabbit MQ Report
    // ReturnType: Object
    public function FSvCCallRptExportFile(){
        $dDateSendMQ    = date('Y-m-d');
        $dTimeSendMQ    = date('H:i:s');
        $dDateSubscribe = date('Ymd');
        $dTimeSubscribe = date('His');
        // Set Parameter Send MQ
        $tRptQueueName  = 'RPT_'.$this->tSysBchCode.'_'.$this->tRptGroup.'_'.$this->tRptCode;
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

}