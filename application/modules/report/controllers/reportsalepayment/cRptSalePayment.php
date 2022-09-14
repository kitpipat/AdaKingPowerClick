<?php defined('BASEPATH') or exit('No direct script access allowed');

date_default_timezone_set("Asia/Bangkok");

class cRptSalePayment extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('company/company/mCompany');
        $this->load->model('report/reportsalepayment/mRptSalePayment');
    }


    public function index(){
        $tRptRoute  = $this->input->post('ohdRptRoute');
        $tRptCode   = $this->input->Post('ohdRptCode');
        $tRptTypeExport =  $this->input->post('ohdRptTypeExport');

        if(!empty($tRptTypeExport) && !empty($tRptCode)){
            $aDataFilter    = array(
                'tUserCode'     => $this->session->userdata('tSesSessionID'),
                'tCompName'     => gethostname(),
                'tCode'      => $this->input->post('ohdRptCode'),
                'tBchCodeFrom'  => !empty($this->input->post('oetRptBchCodeFrom'))  ? $this->input->post('oetRptBchCodeFrom]')  : "",
                'tBchCodeTo'    => !empty($this->input->post('oetRptBchCodeTo'))    ? $this->input->post('oetRptBchCodeTo]')    : "",
                'tShpCodeFrom'  => !empty($this->input->post('oetRptShpCodeFrom'))  ? $this->input->post('oetRptShpCodeFrom')   : "",
                'tShpCodeTo'    => !empty($this->input->post('oetRptShpCodeTo'))    ? $this->input->post('oetRptShpCodeTo')     : "",
                'tPosCodeFrom'  => !empty($this->input->post('oetRptPosCodeFrom'))  ? $this->input->post('oetRptPosCodeFrom')   : "",
                'tPosCodeTo'    => !empty($this->input->post('oetRptPosCodeTo'))    ? $this->input->post('oetRptPosCodeTo')     : "",
                'tDateFrom'     => !empty($this->input->post('oetRptDocDateFrom'))  ? $this->input->post('oetRptDocDateFrom')   : "",
                'tDateTo'       => !empty($this->input->post('oetRptDocDateTo'))    ? $this->input->post('oetRptDocDateTo')     : "",
                'tRcvCodeFrom'  => !empty($this->input->post('oetRptRcvCodeFrom'))  ? $this->input->post('oetRptRcvCodeFrom')   : "",
                'tRcvCodeTo'    => !empty($this->input->post('oetRptRcvCodeTo'))    ? $this->input->post('oetRptRcvCodeTo')     : "",
                'nLangID'       => FCNaHGetLangEdit(),
            );

            // Execute Stored Procedure
            $result = $this->mRptSalePaymentSummary->FSnMExecStoreCReport($aDataFilter);


            switch($tRptTypeExport){
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($tRptRoute,$tRptCode,$tRptTypeExport,$aDataFilter);
                break;
                case 'excel':
                    print_r('Excel');
                break;
                case 'pdf':
                    print_r('Pdf');
                break;
            }
        }
    }

    // Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 04/04/2019 Wasin(Yoshi)
    // LastUpdate: 11/07/2019 Witsarut(Bell)
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrint($ptRptRoute,$ptRptCode,$ptRptTypeExport,$paDataFilter){

        $tRptRoute      = $ptRptRoute;
        $tRptCode       = $ptRptCode;
        $tRptTypeExport = $ptRptTypeExport;
        $aDataFilter    = $paDataFilter;
        $nPage          = 1;

        $aDataWhere     =   array(
            // 'tSessionID'    => $this->session->userdata('tSesSessionID'),
            // 'tCompName'     => gethostname(),
            'tSessionID'    => '00920190708100059',  //Dummy Data ไว้
            'tCompName'     => 'ADA090-Arm', //Dummy Data ไว้
            'tUserCode'     => $this->session->userdata('tSesUsername'),
            'tRptCode'      => $tRptCode,
            'nPage'         => $nPage,
            'nRow'          => 100,
        );

        // Get Data Report
        $aDataReport    = $this->mRptSalePaymentSummary->FSaMGetDataReport($aDataWhere,$aDataFilter); //Get Data

        if(!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1){
            $tViewRenderKool        = $this->FCNvCRenderKoolReportHtml($aDataReport,$aDataFilter);// Draw Table
        }else{
            $tViewRenderKool = "";
        }

        $aDataView      = array(
            'tTitleReport'      => language('report/report/report','tRptTitleRptSalePaymentSummary'),
            'tRptTypeExport'    => $tRptTypeExport,
            'tRptCode'          => $tRptCode,
            'tRptRoute'         => $tRptRoute,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => $aDataReport
        );

        $this->load->view('report/report/wReportViewer',$aDataView);
    }

    // Functionality: Click Page Report (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 19/04/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FCNvCRenderKoolReportHtml($paDataReport,$paDataFilter){

        $aDataWhere     = array('FNLngID' => $paDataFilter['nLangID']);
        $tAPIReq        = "";
        $tMethodReq     = "GET";
        $aCompData	    = $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);

        $tAddRef    =  $aCompData['raItems']['rtCmpBchCode'];
        $nLangID    = $this->session->userdata("tLangID");

        $aDataRef   = array(
            'tAddRef'   => $tAddRef,
            'nLangID'   => $nLangID
        );

        $aDataAddress    = $this->mRptSalePaymentSummary->FSaMCMPAddress($aDataRef);//Get Data ที่อยู่

        if($aCompData['rtCode'] == '1'){
            $tCompName      = $aCompData['raItems']['rtCmpName'];
            $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
            $tBchName       = $aCompData['raItems']['rtCmpBchName'];
            $tTel           = $aCompData['raItems']['rtCmpTel'];
            $tFax           = $aCompData['raItems']['rtCmpFax'];
            $tHomeNO        = $aDataAddress['raItems']['rtAddV1No'];
            $tSoi           = $aDataAddress['raItems']['rtAddV1Soi'];
            $tSubName       = $aDataAddress['raItems']['rtAddV1SudName'];
            $tDstName       = $aDataAddress['raItems']['rtAddV1DstName'];
            $tPrvName       = $aDataAddress['raItems']['rtAddV1PvnName'];
            $tPostCode      = $aDataAddress['raItems']['rtAddV1PostCode'];
            $tRoad          = $aDataAddress['raItems']['rtAddV1Road'];
        }else{
            $tCompName      = "-";
            $tBchCode       = "-";
            $tBchName       = "-";
            $tTel           = "-";
            $tFax           = "-";
            $tHomeNO        = "-";
            $tSoi           = "-";
            $tSubName       = "-";
            $tDstName       = "-";
            $tPrvName       = "-";
            $tPostCode      = "-";
            $tRoad          = "-";
        }

        // array ข้อมูลภาษาที่เกี่ยวข้องกับรายงาน
        $aDataTextRef   = array(
            'tTitleReport'          => language('report/report/report','tRptTitleRptSalePaymentSummary'),
            'tRptTaxNo'             => language('report/report/report','tRptTaxNo'),
            'tRptDatePrint'         => language('report/report/report','tRptDatePrint'),
            'tRptDateExport'        => language('report/report/report','tRptDateExport'),
            'tRptTimePrint'         => language('report/report/report','tRptTimePrint'),
            'tRptPrintHtml'         => language('report/report/report','tRptPrintHtml'),
            'tRptBranch'            => language('report/report/report','tRptBranch'),
            'tRptFaxNo'             => language('report/report/report','tRptFaxNo'),
            'tRptTel'               => language('report/report/report','tRptTel'),

            // Filter Heard Report
            'tRptBchFrom'           => language('report/report/report','tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report','tRptBchTo'),
            'tRptShopFrom'          => language('report/report/report','tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report','tRptShopTo'),
            'tRptDateFrom'          => language('report/report/report','tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report','tRptDateTo'),
            // Table Report
            'tRptLocCode'           => language('report/report/report','tRptLocCode'),
            'tRptDateOpen'          => language('report/report/report','tRptDateOpen'),
            'tRptChannelGrp'        => language('report/report/report','tRptChannelGrp'),
            'tRptNoChannel'         => language('report/report/report', 'tRptNoChannel'),
            'tRptReason'            => language('report/report/report','tRptReason'),
            'tRptUsrOpen'           => language('report/report/report','tRptUsrOpen'),
       );

           // Ref File Kool Report
           require_once APPPATH.'modules\report\datasources\rptSalePaymentSummary\rRptSalePaymentSummary.php';

    }

}
