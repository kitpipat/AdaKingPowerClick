<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cRptProductSalesPosVD extends MX_Controller {
    
    /**
     * ภาษา
     * @var array
    */
    public $aText   = [];

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
        $this->load->model('report/reportsalespecial/mRptProductSalesPosVD');
        $this->init();
        parent::__construct();
    }

    private function init(){
        $this->aText    = [
            'tTitleReport'          => language('report/report/report','tRptTitleProductSalesPosVD'),
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
            // Filter Text Label Between
            'tRptBchFrom'           => language('report/report/report', 'tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report', 'tRptBchTo'),
            'tRptMerFrom'           => language('report/report/report', 'tRptMerFrom'),
            'tRptMerTo'             => language('report/report/report', 'tRptMerTo'),
            'tRptShopFrom'          => language('report/report/report', 'tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report', 'tRptShopTo'),
            'tRptPosFrom'           => language('report/report/report', 'tRptPosFrom'),
            'tRptPosTo'             => language('report/report/report', 'tRptPosTo'),
            'tRptAll'             => language('report/report/report', 'tRptAll'),
            
            //header

         
            'tRptSaleTaxByDailyPos'             => language('report/report/report', 'tRptSaleTaxByDailyPos'),
            'tRptSaleTaxByDailyPayment'             => language('report/report/report', 'tRptSaleTaxByDailyPayment'),
            'tRptSaleTaxByDailyDate'             => language('report/report/report', 'tRptSaleTaxByDailyDate'),
            'tRptSaleTaxByDailyEjNo'             => language('report/report/report', 'tRptSaleTaxByDailyEjNo'),
            'tRptSaleTaxByDailyProduct'             => language('report/report/report', 'tRptSaleTaxByDailyProduct'),
            'tRptSaleTaxByDailyFirstName'             => language('report/report/report', 'tRptSaleTaxByDailyFirstName'),
            'tRptSaleTaxByDailyLastName'             => language('report/report/report', 'tRptSaleTaxByDailyLastName'),
            'tRptSaleTaxByDailyIDCardNo'             => language('report/report/report', 'tRptSaleTaxByDailyIDCardNo'),
            'tRptSaleTaxByDailyVatTable'             => language('report/report/report', 'tRptSaleTaxByDailyVatTable'),
            'tRptSaleTaxByDailyVatAmount'             => language('report/report/report', 'tRptSaleTaxByDailyVatAmount'),
            'tRptTotalFooter'             => language('report/report/report', 'tRptTotalFooter'),
            
             'tRptDateFrom'   => language('report/report/report', 'tRptDateFrom'),
             'tRptDateTo'   => language('report/report/report', 'tRptDateTo'),
             'tRptAdjPosFrom'   => language('report/report/report', 'tRptAdjPosFrom'),
             'tRptAdjPosTo'   => language('report/report/report', 'tRptAdjPosTo'),
            'tRptProductSalesPosVDDate'   => language('report/report/report', 'tRptProductSalesPosVDDate'),
             'tRptProductSalesPosVDPos'   => language('report/report/report', 'tRptProductSalesPosVDPos'),
             'tRptProductSalesPosVDDocNo'   => language('report/report/report', 'tRptProductSalesPosVDDocNo'),   
             'tRptProductSalesPosPayment'   => language('report/report/report', 'tRptProductSalesPosPayment'),   
             'tRptProductSalesPosProduct'   => language('report/report/report', 'tRptProductSalesPosProduct'),   
             'tRptProductSalesPosName'   => language('report/report/report', 'tRptProductSalesPosName'), 
              'tRptProductSalesPosLName'   => language('report/report/report', 'tRptProductSalesPosLName'), 
              'tRptProductSalesPosTel'   => language('report/report/report', 'tRptProductSalesPosTel'), 
              'tRptProductSalesPosRmk'   => language('report/report/report', 'tRptProductSalesPosRmk'),
              'tRptProductSalesPosIDCard'   => language('report/report/report', 'tRptProductSalesPosIDCard'),
              'tRptProductSalesPosSum'   => language('report/report/report', 'tRptProductSalesPosSumTotal'),
              'tRptProductSalesPosSumTotal'   => language('report/report/report', 'tRptCrSaleMonth-GrandTotal2'),
              'tRptPosTypeName'   => language('report/report/report', 'tRptPosTypeName'),
              'tRptPosType'   => language('report/report/report', 'tRptPosType'),
              'tRptPosType1'  => language('report/report/report', 'tRptPosType1'),
              'tRptPosType2' => language('report/report/report', 'tRptPosType2'),
              'tRptAdjMerChantFrom' => language('report/report/report', 'tRptAdjMerChantFrom'),
              'tRptAdjMerChantTo' => language('report/report/report', 'tRptAdjMerChantTo'),
            // Report Text Condtion Other Report
            'tRptConditionInReport' => language('report/report/report', 'tRptConditionInReport'),
            'tRptAdjShopFrom'      => language('common/main/main', 'tRptAdjShopFrom'),
            'tRptAdjShopTo'      => language('common/main/main', 'tRptAdjShopTo'),
            // No Data Report
            'tRptNotFoundData'      => language('common/main/main', 'tCMNNotFoundData'),
            'tRptTotalFooter'      => language('common/main/main', 'tRptTotalFooter'),
            'tRptNoData'      => language('report/report/report', 'tRptNoData'),
            
            
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
            'tUserSession'      => $this->tUserSessionID,
            'tCompName'         => $tFullHost,
            'tRptCode'          => $this->tRptCode,
            'nLangID'           => $this->nLngID,
            // ประเภทเครื่องจุดขาย
            'tTypeSelect'           => !empty($this->input->post('ohdTypeDataCondition')) ? $this->input->post('ohdTypeDataCondition') : "",

            // สาขา(Branch)
            'tBchCodeFrom'         => !empty($this->input->post('oetRptBchCodeFrom')) ? $this->input->post('oetRptBchCodeFrom') : "",
            'tBchNameFrom'         => !empty($this->input->post('oetRptBchNameFrom')) ? $this->input->post('oetRptBchNameFrom') : "",
            'tBchCodeTo'           => !empty($this->input->post('oetRptBchCodeTo')) ? $this->input->post('oetRptBchCodeTo') : "",
            'tBchNameTo'           => !empty($this->input->post('oetRptBchNameTo')) ? $this->input->post('oetRptBchNameTo') : "",
            'tBchCodeSelect'       => !empty($this->input->post('oetRptBchCodeSelect')) ? $this->input->post('oetRptBchCodeSelect') : "",
            'tBchNameSelect'       => !empty($this->input->post('oetRptBchNameSelect')) ? $this->input->post('oetRptBchNameSelect') : "",
            'bBchStaSelectAll'     => !empty($this->input->post('oetRptBchStaSelectAll')) && ($this->input->post('oetRptBchStaSelectAll') == 1) ? true : false,
    
            // Filter Merchant (กลุ่มธุรกิจ)
            'tMerCodeFrom'      => (empty($this->input->post('oetRptMerCodeFrom'))) ? '' : $this->input->post('oetRptMerCodeFrom'),
            'tMerNameFrom'      => (empty($this->input->post('oetRptMerNameFrom'))) ? '' : $this->input->post('oetRptMerNameFrom'),
            'tMerCodeTo'        => (empty($this->input->post('oetRptMerCodeTo'))) ? '' : $this->input->post('oetRptMerCodeTo'),
            'tMerNameTo'        => (empty($this->input->post('oetRptMerNameTo'))) ? '' : $this->input->post('oetRptMerNameTo'),
            'tMerCodeSelect'    => !empty($this->input->post('oetRptMerCodeSelect')) ? $this->input->post('oetRptMerCodeSelect') : "",
            'tMerNameSelect'    => !empty($this->input->post('oetRptMerNameSelect')) ? $this->input->post('oetRptMerNameSelect') : "",
            'bMerStaSelectAll'  => !empty($this->input->post('oetRptMerStaSelectAll')) && ($this->input->post('oetRptMerStaSelectAll') == 1) ? true : false,

            // ร้านค้า(Shop)
            'tShpCodeFrom'         => !empty($this->input->post('oetRptShpCodeFrom')) ? $this->input->post('oetRptShpCodeFrom') : "",
            'tShpNameFrom'         => !empty($this->input->post('oetRptShpNameFrom')) ? $this->input->post('oetRptShpNameFrom') : "",
            'tShpCodeTo'           => !empty($this->input->post('oetRptShpCodeTo')) ? $this->input->post('oetRptShpCodeTo') : "",
            'tShpNameTo'           => !empty($this->input->post('oetRptShpNameTo')) ? $this->input->post('oetRptShpNameTo') : "",
            'tShpCodeSelect'       => !empty($this->input->post('oetRptShpCodeSelect')) ? $this->input->post('oetRptShpCodeSelect') : "",
            'tShpNameSelect'       => !empty($this->input->post('oetRptShpNameSelect')) ? $this->input->post('oetRptShpNameSelect') : "",
            'bShpStaSelectAll'     => !empty($this->input->post('oetRptShpStaSelectAll')) && ($this->input->post('oetRptShpStaSelectAll') == 1) ? true : false,

            // Filter Pos (เครื่องจุดขาย)
            'tPosCodeFrom'      => (empty($this->input->post('oetRptPosCodeFrom'))) ? '' : $this->input->post('oetRptPosCodeFrom'),
            'tPosNameFrom'      => (empty($this->input->post('oetRptPosNameFrom'))) ? '' : $this->input->post('oetRptPosNameFrom'),
            'tPosCodeTo'        => (empty($this->input->post('oetRptPosCodeTo'))) ? '' : $this->input->post('oetRptPosCodeTo'),
            'tPosNameTo'        => (empty($this->input->post('oetRptPosNameTo'))) ? '' : $this->input->post('oetRptPosNameTo'),
            'tPosCodeSelect'    => !empty($this->input->post('oetRptPosCodeSelect')) ? $this->input->post('oetRptPosCodeSelect') : "",
            'tPosNameSelect'    => !empty($this->input->post('oetRptPosNameSelect')) ? $this->input->post('oetRptPosNameSelect') : "",
            'bPosStaSelectAll'  => !empty($this->input->post('oetRptPosStaSelectAll')) && ($this->input->post('oetRptPosStaSelectAll') == 1) ? true : false,

            // วันที่เอกสาร(DocNo)
            'tDocDateFrom'         => !empty($this->input->post('oetRptDocDateFrom')) ? $this->input->post('oetRptDocDateFrom') : "",
            'tDocDateTo'           => !empty($this->input->post('oetRptDocDateTo')) ? $this->input->post('oetRptDocDateTo') : "",
           
            //ประเภทการชำระเงิน
           'tRcvCodeFrom'      => !empty($this->input->post('oetRptRcvCodeFrom')) ? $this->input->post('oetRptRcvCodeFrom') : "",
           'tRcvNameFrom'      => !empty($this->input->post('oetRptRcvNameFrom')) ? $this->input->post('oetRptRcvNameFrom') : "",
           'tRcvCodeTo'        => !empty($this->input->post('oetRptRcvCodeTo')) ? $this->input->post('oetRptRcvCodeTo') : "",
           'tRcvNameTo'        => !empty($this->input->post('oetRptRcvNameTo')) ? $this->input->post('oetRptRcvNameTo') : "",
            
            //ประเภทเครื่องจุดขาย
            'tPosType'             => !empty($this->input->post('ocmPosType')) ? $this->input->post('ocmPosType') : ""
           
        ];
  
        // ดึงข้อมูลบริษัทฯ
        $aCompInfoParams = [
            'nLngID'    => $this->nLngID,
            'tBchCode'  => $this->tBchCodeLogin
        ];
        $this->aCompanyInfo = FCNaGetCompanyInfo($aCompInfoParams)['raItems'];
    }

    public function index() {
        if(!empty($this->tRptCode) && !empty($this->tRptExportType)){
            $this->mRptProductSalesPosVD->FSnMExecStoreReport($this->aRptFilter);
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

   /**
     * Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 18/12/2019 Nonpawich
     * LastUpdate: 
     * Return: View Report Viewer
     * ReturnType: View
    */
    public function FSvCCallRptViewBeforePrint() {
        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage'      => $this->nPerPage,
            'nPage'         => '1', // เริ่มทำงานหน้าแรก
            'tCompName'     => $this->tCompName,
            'tRptCode'      => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter'   => $this->aRptFilter
        );
        $aDataReport = $this->mRptProductSalesPosVD->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport'       => $aDataReport,
            'aDataTextRef'      => $this->aText,
            'aCompanyInfo'      => $this->aCompanyInfo,
            'nOptDecimalShow'   => $this->nOptDecimalShow,
            'aDataFilter'       => $this->aRptFilter
        );

        // Load View Advance Table
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptproductsalesposvd', 'wRptProductSalePosVDHtml', $aDataViewRpt);
        // Data Viewer Center Report
        $aDataViewer = array(
            'tTitleReport'      => $this->aText['tTitleReport'],
            'tRptTypeExport'    => $this->tRptExportType,
            'tRptCode'          => $this->tRptCode,
            'tRptRoute'         => $this->tRptRoute,
            'tViewRenderKool'   => $tRptView,
            'aDataFilter'       => $this->aRptFilter,
            'aDataReport'       => array(
                'raItems'       => $aDataReport['aRptData'],
                'rnAllRow'      => $aDataReport['aPagination']['nTotalRecord'],
                'rnCurrentPage' => $aDataReport['aPagination']['nDisplayPage'],
                'rnAllPage'     => $aDataReport['aPagination']['nTotalPage'],
                'rtCode'        => '1',
                'rtDesc'        => 'success',
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    /**
     * Functionality: Click Page ดูตัวอย่างก่อนพิมพ์ (Report Viewer)
     * Parameters:  Function Parameter
     * Creator: 19/07/2019 Wasin(Yoshi)
     * LastUpdate: 23/09/2019 Piya
     * Return: View Report Viewer
     * ReturnType: View
     */
    public function FSvCCallRptViewBeforePrintClickPage() {

        /** =========== Begin Init Variable ================================== */
        $aDataFilter = json_decode($this->input->post('ohdRptDataFilter'), true);
        /** =========== End Init Variable ==================================== */
        // ข้อมูลสำหรับดึงข้อมูลจากฐานข้อมูล
        $aDataWhereRpt = array(
            'nPerPage' => $this->nPerPage,
            'nPage' => $this->nPage,
            'tCompName' => $this->tCompName,
            'tRptCode' => $this->tRptCode,
            'tUsrSessionID' => $this->tUserSessionID,
            'aDataFilter'   => $this->aRptFilter
        );
        $aDataReport = $this->mRptProductSalesPosVD->FSaMGetDataReport($aDataWhereRpt);

        // ข้อมูล Render Report
        $aDataViewRpt = array(
            'aDataReport' => $aDataReport,
            'aDataTextRef' => $this->aText,
            'aCompanyInfo' => $this->aCompanyInfo,
            'nOptDecimalShow' => $this->nOptDecimalShow,
            'aDataFilter' => $aDataFilter
        );

        // Load View Advance Tablew
        $tRptView = JCNoHLoadViewAdvanceTable('report/datasources/reportsalespecial/rptproductsalesposvd', 'wRptProductSalePosVDHtml', $aDataViewRpt);
        // Data Viewer Center Report
        $aDataViewer = array(
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
            )
        );
        $this->load->view('report/report/wReportViewer', $aDataViewer);
    }

    // Functionality: Check Data Report Temp
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return: object Status Count Data Report
    // ReturnType: Object
    public function FSoCChkDataReportInTableTemp(){
        try {
            $aDataCountData = [
                'tCompName'     => $this->tCompName,
                'tRptCode'      => $this->tRptCode,
                'tUserSession'  => $this->tUserSessionID,
                'aDataFilter'   => $this->aRptFilter,
                'tPosType'      => $this->aRptFilter['tPosType']
            ]; 
            $nDataCountPage = $this->mRptProductSalesPosVD->FSnMCountRowInTemp($aDataCountData);
            $aResponse = array(
                'nCountPageAll' => $nDataCountPage,
                'nStaEvent'     => 1,
                'tMessage'      => 'Success Count Data All'
            );
        } catch (ErrorException $Error) {
            $aResponse = array(
                'nStaEvent' => 500,
                'tMessage' => $Error->getMessage()
            );
        }
        echo json_encode($aResponse);
    }

    // Functionality: Send Rabbit MQ Report
    // Parameters:  Function Parameter
    // Creator: 19/12/2019 Wasin(Mr.JW)
    // Return: object Send Rabbit MQ Report
    // ReturnType: Object
    public function FSvCCallRptExportFile(){
        $dDateSendMQ    = date('Y-m-d');
        $dTimeSendMQ    = date('H:i:s');
        $dDateSubscribe = date('Ymd');
        $dTimeSubscribe = date('His');
        // Set Parameter Send MQ
        $tRptQueueName = 'RPT_' .$this->tSysBchCode . '_' . $this->tRptGroup . '_' . $this->tRptCode;

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