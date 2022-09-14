<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");

include APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

class cRptProductTransfer extends MX_Controller {

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

    public function __construct(){
        $this->load->model('company/company/mCompany');
        $this->load->model('report/reportproducttransfer/mRptProductTransfer');
        $this->load->model('report/report/mReport');

        // Init Report
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText = [
            'tTitleReport' => language('report/report/report','tRptTitleProductTransfer'),
            'tDatePrint' => language('report/report/report','tRptAdjStkVDDatePrint'),
            'tTimePrint' => language('report/report/report','tRptAdjStkVDTimePrint'),
            // Address Lang
            'tRptAddrBuilding' => language('report/report/report','tRptAddrBuilding'),
            'tRptAddrRoad' => language('report/report/report','tRptAddrRoad'),
            'tRptAddrSoi' => language('report/report/report','tRptAddrSoi'),
            'tRptAddrSubDistrict' => language('report/report/report','tRptAddrSubDistrict'),
            'tRptAddrDistrict' => language('report/report/report','tRptAddrDistrict'),
            'tRptAddrProvince' => language('report/report/report','tRptAddrProvince'),
            'tRptAddrTel' => language('report/report/report','tRptAddrTel'),
            'tRptAddrFax' => language('report/report/report','tRptAddrFax'),
            'tRptAddrBranch' => language('report/report/report','tRptAddrBranch'),
            'tRptAddV2Desc1' => language('report/report/report','tRptAddV2Desc1'),
            'tRptAddV2Desc2' => language('report/report/report','tRptAddV2Desc2'),
            'tRptTaxNo' => language('report/report/report','tRptTaxNo'),
            // Filter
            'tRptShpTFrom' => language('report/report/report', 'tRptShpTFrom'),
            'tRptShpTTo' => language('report/report/report', 'tRptShpTTo'),
            'tRptShpRFrom' => language('report/report/report', 'tRptShpRFrom'),
            'tRptShpRTo' => language('report/report/report', 'tRptShpRTo'),
            'tRptPosTFrom' => language('report/report/report', 'tRptPosTFrom'),
            'tRptPosTTo' => language('report/report/report', 'tRptPosTTo'),
            'tRptPosRFrom' => language('report/report/report', 'tRptPosRFrom'),
            'tRptPosRTo' => language('report/report/report', 'tRptPosRTo'),
            'TRptWahTFrom' => language('report/report/report', 'TRptWahTFrom'),
            'TRptWahTTo' => language('report/report/report', 'TRptWahTTo'),
            'TRptWahRFrom' => language('report/report/report', 'TRptWahRFrom'),
            'TRptWahRTo' => language('report/report/report', 'TRptWahRTo'),
            'tRptDateFrom' => language('report/report/report', 'tRptDateFrom'),
            'tRptDateTo' => language('report/report/report', 'tRptDateTo'),
            'tRptMerFrom' => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo' => language('report/report/report', 'tRptMerTo'),
            // Table Label
            'tRptDocument' => language('report/report/report','tRptDocument'),
            'tRptDateDocument' => language('report/report/report','tRptDateDocument'),
            'tRptFromWareHouse' => language('report/report/report','tRptFromWareHouse'),  
            'tRptToWareHouse' => language('report/report/report','tRptToWareHouse'),  
            'tRptAdjStkVDPdtCode' => language('report/report/report','tRptAdjStkVDPdtCode'),  
            'tRptAdjStkVDPdtName' => language('report/report/report','tRptAdjStkVDPdtName'),  
            'tRptAdjStkVDLayRow' => language('report/report/report','tRptAdjStkVDLayRow'),  
            'tRptAdjStkVDLayCol' => language('report/report/report','tRptAdjStkVDLayCol'),  
            'tRptAdjStkVDLayCol' => language('report/report/report','tRptAdjStkVDLayCol'),  
            'tRptTransferamount' => language('report/report/report','tRptTransferamount'),  
            'tRptListener' => language('report/report/report','tRptListener'),  
            // No Data Report
            'tRptAdjStkNoData' => language('common/main/main', 'tCMNNotFoundData'),
            'tRptConditionInReport'      => language('report/report/report', 'tRptConditionInReport'),

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
            'tUserSessionID' => $this->tUserSessionID,
            'tCompName' => $tFullHost,
            'tRptCode' => $this->tRptCode,
            'nLangID' => $this->nLngID,

            'tTypeSelect'          => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeFrom'      => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
            'tMerNameFrom'      => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
            'tMerCodeTo'        => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
            'tMerNameTo'        => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // ร้านค้าที่โอน
            'tShpTCodeFrom'  => !empty($this->input->post('oetRptShpTCodeFrom'))  ? $this->input->post('oetRptShpTCodeFrom')   : "",
            'tShpTCodeTo'    => !empty($this->input->post('oetRptShpTCodeTo'))    ? $this->input->post('oetRptShpTCodeTo')     : "",
            'tShpTNameFrom'  => !empty($this->input->post('oetRptShpTNameFrom'))  ? $this->input->post('oetRptShpTNameFrom')   : "",
            'tShpTNameTo'    => !empty($this->input->post('oetRptShpTNameTo'))    ? $this->input->post('oetRptShpTNameTo')     : "",
            // ร้านค้าที่รับโอน
            'tShpRCodeFrom'  => !empty($this->input->post('oetRptShpRCodeFrom'))  ? $this->input->post('oetRptShpRCodeFrom')   : "",
            'tShpRCodeTo'    => !empty($this->input->post('oetRptShpRCodeTo'))    ? $this->input->post('oetRptShpRCodeTo')     : "",
            'tShpRNameFrom'  => !empty($this->input->post('oetRptShpRNameFrom'))  ? $this->input->post('oetRptShpRNameFrom')   : "",
            'tShpRNameTo'    => !empty($this->input->post('oetRptShpRNameTo'))    ? $this->input->post('oetRptShpRNameTo')     : "",
            // ตู้ที่โอน
            'tPosTCodeFrom'  => !empty($this->input->post('oetRptPosTCodeFrom'))  ? $this->input->post('oetRptPosTCodeFrom')   : "",
            'tPosTCodeTo'    => !empty($this->input->post('oetRptPosTCodeTo'))    ? $this->input->post('oetRptPosTCodeTo')     : "",
            'tPosTNameFrom'  => !empty($this->input->post('oetRptPosTNameFrom'))  ? $this->input->post('oetRptPosTNameFrom')   : "",
            'tPosTNameTo'    => !empty($this->input->post('oetRptPosTNameTo'))    ? $this->input->post('oetRptPosTNameTo')     : "",
            // ตู้ที่รับโอน
            'tPosRCodeFrom'  => !empty($this->input->post('oetRptPosRCodeFrom'))  ? $this->input->post('oetRptPosRCodeFrom')   : "",
            'tPosRCodeTo'    => !empty($this->input->post('oetRptPosRCodeTo'))    ? $this->input->post('oetRptPosRCodeTo')     : "",
            'tPosRNameFrom'  => !empty($this->input->post('oetRptPosRNameFrom'))  ? $this->input->post('oetRptPosRNameFrom')   : "",
            'tPosRNameTo'    => !empty($this->input->post('oetRptPosRNameTo'))    ? $this->input->post('oetRptPosRNameTo')     : "",
            // คลังที่โอน
            'tWahTCodeFrom'  => !empty($this->input->post('oetRptWahTCodeFrom'))  ? $this->input->post('oetRptWahTCodeFrom')   : "",
            'tWahTCodeTo'    => !empty($this->input->post('oetRptWahTCodeTo'))    ? $this->input->post('oetRptWahTCodeTo')     : "",
            'tWahTNameFrom'  => !empty($this->input->post('oetRptWahTNameFrom'))  ? $this->input->post('oetRptWahTNameFrom')   : "",
            'tWahTNameTo'    => !empty($this->input->post('oetRptWahTNameTo'))    ? $this->input->post('oetRptWahTNameTo')     : "",
            // คลังที่รับโอน
            'tWahRCodeFrom'  => !empty($this->input->post('oetRptWahRCodeFrom'))  ? $this->input->post('oetRptWahRCodeFrom')   : "",
            'tWahRCodeTo'    => !empty($this->input->post('oetRptWahRCodeTo'))    ? $this->input->post('oetRptWahRCodeTo')     : "",
            'tWahRNameFrom'  => !empty($this->input->post('oetRptWahRNameFrom'))  ? $this->input->post('oetRptWahRNameFrom')   : "",
            'tWahRNameTo'    => !empty($this->input->post('oetRptWahRNameTo'))    ? $this->input->post('oetRptWahRNameTo')     : "",
            // วันที่เอกสาร
            'tDocDateFrom'  => !empty($this->input->post('oetRptDocDateFrom'))  ? $this->input->post('oetRptDocDateFrom')   : "",
            'tDocDateTo'    => !empty($this->input->post('oetRptDocDateTo'))    ? $this->input->post('oetRptDocDateTo')     : "",
        ];

        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID' => $this->nLngID,
            'tBchCode' => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index(){
        $tRptRoute          = $this->input->post('ohdRptRoute');
        $tRptCode           = $this->input->Post('ohdRptCode');
        $tRptTypeExport     = $this->input->post('ohdRptTypeExport');
        $tMerCodeF          = $this->input->post('oetRptMerCodeFrom');
        $tMerCodeT          = $this->input->post('oetRptMerCodeTo');
        if($tMerCodeF != "" && $tMerCodeT != ""){
            $tMerCodeFrom   = $this->input->post('oetRptMerCodeFrom');
            $tMerCodeTo     = $this->input->post('oetRptMerCodeTo');
        }else{
            $tMerCodeFrom   = "";
            $tMerCodeTo     = "";
        }

        $tIP = $this->input->ip_address();
        $tFullHost = gethostbyaddr($tIP);
        $this->tCompName = $tFullHost;

        if(!empty($tRptTypeExport) && !empty($tRptCode)){

            // Execute Stored Procedure
            $this->mRptProductTransfer->FSnMExecStoreCReport($this->aRptFilter);

            $aDataSwitchCase = array(
                'ptRptRoute'        => $tRptRoute,
                'ptRptCode'         => $tRptCode,
                'ptRptTypeExport'   => $tRptTypeExport,
                'paDataFilter'      => $this->aRptFilter
            );
            switch($tRptTypeExport){
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($aDataSwitchCase);
                break;
                case 'excel':
                    $this->FSoCChkDataReportInTableTemp($aDataSwitchCase);
                break;
                case 'pdf':
                    $this->FSvCCallRptRenderExcel($aDataSwitchCase);
                break;
            }
        }
    }

    /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 15/07/2019 Wasin(Yoshi)
     * LastUpdate: 19/11/2019 Piya
     * Return: View Report Viewersd
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrint($paDataSwitchCase = []){
        $tRptRoute = $paDataSwitchCase['ptRptRoute'];
        $tRptCode = $paDataSwitchCase['ptRptCode'];
        $tRptTypeExport = $paDataSwitchCase['ptRptTypeExport'];
        $aDataFilter = $paDataSwitchCase['paDataFilter'];
        $nPage = 1;
        $nLangEdit = $this->session->userdata("tLangEdit");

        // Get Data Company (ดึงข้อมูลอ้างอิงที่อยู่บริษัท)
        $tAPIReq = "";
        $tMethodReq = "GET";
        $aDataWhereComp = array('FNLngID' => $this->nLngID);
        $aCompData	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhereComp);
        if($aCompData['rtCode'] == '1'){
            $tCompName = $aCompData['raItems']['rtCmpName'];
            $tBchCode  = $aCompData['raItems']['rtCmpBchCode'];
            $aDataBranchAddress = $this->mReport->FSaMRptGetDataAddressByBranchComp($tBchCode,$nLangEdit);
        }else{
            $tCompName = "-";
            $tBchCode = "-";
            $aDataBranchAddress = array();
        }

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage' => $this->nPerPage,
            'nPage' => 1, // หน้าเริ่มต้น
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tSessionID' => $this->tUserSessionID,
        );
        $aDataReport = $this->mRptProductTransfer->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewParams = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataCompany' => $this->aCompanyInfo,
            'aDataFilter' => $this->aRptFilter
        );

        // Load View Advance Table
        $tViewRpt = JCNoHLoadViewAdvanceTable('report/datasources/rptProductTransfer','wRptProductTransferHtml',$aDataViewParams);

        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRpt,
            'aDataFilter' => $this->aRptFilter,
            'aDataReport' => array(
                'raItems' => $aDataReport['aRptData'],
                'rnAllRow' => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage' => $aDataReport['aPagination']['nTotalPage'],
                'rtCode' => '1',
                'rtDesc' => 'success',
            )
        );
        $this->load->view('report/report/wReportViewer',$aDataViewer);
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 19/07/2019 Wasin(Yoshi)
     * LastUpdate: 19/11/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage(){
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'),true);

        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPage' => $this->nPage,
            'nPerPage' => $this->nPerPage,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tSessionID' => $this->tUserSessionID,
        );
        $aDataReport = $this->mRptProductTransfer->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewPdt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aDataCompany' => $this->aCompanyInfo,
            'aDataFilter' => $this->aRptFilter
        );

        // Load View Advance Table

        $tViewRpt = JCNoHLoadViewAdvanceTable('report/datasources/rptProductTransfer','wRptProductTransferHtml',$aDataViewPdt);

        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport' => $this->aText['tTitleReport'],
            'tRptTypeExport' => $this->tRptExportType,
            'tRptCode' => $this->tRptCode,
            'tRptRoute' => $this->tRptRoute,
            'tViewRenderKool' => $tViewRpt,
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
        $this->load->view('report/report/wReportViewer',$aDataViewer);
    }

    /**
     * Functionality: Click Page Report (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 19/11/2019 Piya
     * Return: object Status Count Data Report
     * ReturnType: Object
     */
    public function FSoCChkDataReportInTableTemp($paDataSwitchCase){
        try{
            $aDataCountData = [
                'tCompName'         => $paDataSwitchCase['paDataFilter']['tCompName'],
                'tRptCode'          => $paDataSwitchCase['paDataFilter']['tRptCode'],
                'tSessionID'        => $paDataSwitchCase['paDataFilter']['tUserSessionID'],
            ];
            $nDataCountPage = $this->mRptProductTransfer->FSnMCountDataReportAll($aDataCountData);

            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent' => 1,
                'tMessage' => 'Success Count Data All'
            );
        }catch(ErrorException $Error){
            $aResponse =  array(
                'nStaEvent' => 500,
                'tMessage'  => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }
 
    /**
     * Functionality: Send Rabbit MQ Report
     * Parameters:  Function Parameter
     * Creator: 16/08/2019 Wasin(Yoshi)
     * LastUpdate: 19/11/2019 Piya
     * Return: object Send Rabbit MQ Report
     * ReturnType: Object
     */
    public function FSvCCallRptExportFile(){
        try{

            $dDateSendMQ = date('Y-m-d');
            $dTimeSendMQ = date('H:i:s');
            $dDateSubscribe = date('Ymd');
            $dTimeSubscribe = date('His');
            $nLangID = FCNaHGetLangEdit();

            // Set Parameter Send MQ
            $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

            $aDataSendMQ = [
                'tQueueName' => $tRptQueueName,
                'aParams' => [
                    'ptRptCode'         => $this->tRptCode,
                    'pnPerFile'         => 20000,
                    'ptUserCode'        => $this->tUserLoginCode,
                    'ptUserSessionID'   => $this->tUserSessionID,
                    'pnLngID'           => $nLangID,
                    'ptFilter'          => $this->aRptFilter,
                    'ptRptExpType'      => $this->tRptExportType,
                    'ptComName'         => $this->tCompName,
                    'ptDate'            => $dDateSendMQ,
                    'ptTime'            => $dTimeSendMQ,
                    'ptBchCode'         => (!empty($this->session->userdata('tSesUsrBchCom'))? $this->session->userdata('tSesUsrBchCom') : $this->session->userdata('tSesUsrBchCom'))
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

        }catch(Exception $Error){
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

}

