<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set("Asia/Bangkok");

class cRptSaleVatInvoiceByBill extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('company/company/mCompany');
        $this->load->model('report/reportsale/mRptSaleVatInvoiceByBill');
    }

    public function index(){
        $tRptRoute      = $this->input->post('ohdRptRoute');
        $tRptCode       = $this->input->post('ohdRptCode');
        $tRptTypeExport = $this->input->post('ohdRptTypeExport');
        if(!empty($tRptTypeExport) && !empty($tRptCode)){
            $aDataFilter    = array(
                'tUserCode'     => $this->session->userdata('tSesUsername'),
                'tCompName'     => gethostname(),
                'tCode'      => $this->input->post('ohdRptCode'),
                'tBchCodeFrom'  => !empty($this->input->post('oetRptBchCodeFrom'))  ? $this->input->post('oetRptBchCodeFrom')   : NULL,
                'tBchNameFrom'  => !empty($this->input->post('oetRptBchNameFrom'))  ? $this->input->post('oetRptBchNameFrom')   : NULL,
                'tBchCodeTo'    => !empty($this->input->post('oetRptBchCodeTo'))    ? $this->input->post('oetRptBchCodeTo')     : NULL,
                'tBchNameTo'    => !empty($this->input->post('oetRptBchNameTo'))    ? $this->input->post('oetRptBchNameTo')     : NULL,
                'tDocDateFrom'  => !empty($this->input->post('oetRptDocDateFrom'))  ? $this->input->post('oetRptDocDateFrom')   : NULL,
                'tDocDateTo'    => !empty($this->input->post('oetRptDocDateTo'))    ? $this->input->post('oetRptDocDateTo')     : NULL,
                'nLangID'       => FCNaHGetLangEdit(),
            );

            // Execute Stored Procedure
            $tRunExcStr =   $this->mRptSaleVatInvoiceByBill->FSnMExecStoreReport($aDataFilter);
            switch($tRptTypeExport){
                case 'html':
                    $this->FSvCCallRptViewBeforePrint($tRptRoute,$tRptCode,$tRptTypeExport,$aDataFilter);
                break;
                case 'excel':

                break;
                case 'pdf':
                
                break;
            }
        }
    }

    // Functionality: ฟังก์ชั่นดูตัวอย่างก่อนพิมพ์ (Report Viewer)
    // Parameters:  Function Parameter
    // Creator: 23/04/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrint($ptRptRoute,$ptRptCode,$ptRptTypeExport,$paDataFilter){
        $tRptRoute      = $ptRptRoute;
        $tRptCode       = $ptRptCode;
        $tRptTypeExport = $ptRptTypeExport;
        $aDataFilter    = $paDataFilter;
        $nPage          = 1;

        $aDataWhere = array(
            'tUserCode' => $this->session->userdata('tSesUsername'),
            'tCompName' => gethostname(),
            'tRptCode'  => $tRptCode,
            'nPage'     => $nPage,
            'nRow'      => 100,
        );

        // Get Data Report
        $aDataReport    = $this->mRptSaleVatInvoiceByBill->FSaMGetDataReport($aDataWhere);
        
        if(!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1){
            if($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage']){
                $aDataSumReport = $this->mRptSaleVatInvoiceByBill->FSaMSumDataReportAll($aDataWhere);
            }else{
                $aDataSumReport = "";
            }

            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport,$aDataSumReport,$aDataFilter);
        }else{
            $tViewRenderKool = "";
        }

        $aDataView      = array(
            'tTitleReport'      => language('report/report/report','tRptSaleVatInvoiceByBill'),
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
    // Creator: 24/04/2019 Wasin(Yoshi)
    // LastUpdate: -
    // Return: View Report Viewer
    // ReturnType: View
    public function FSvCCallRptViewBeforePrintClickPage(){
        $tRptRoute      = $this->input->post('ohdRptRoute');
        $tRptCode       = $this->input->post('ohdRptCode');
        $tRptTypeExport = $this->input->post('ohdRptTypeExport');
        $aDataFilter    = json_decode($this->input->post('ohdRptDataFilter'),true);
        $nPage          = $this->input->post('ohdRptCurrentPage');

        $aDataWhere = array(
            'tUserCode' => $this->session->userdata('tSesUsername'),
            'tCompName' => gethostname(),
            'tRptCode'  => $tRptCode,
            'nPage'     => $nPage,
            'nRow'      => 100,
        );

        // Get Data Report
        $aDataReport    = $this->mRptSaleVatInvoiceByBill->FSaMGetDataReport($aDataWhere);

        if(!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1){
            if($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage']){
                $aDataSumReport = $this->mRptSaleVatInvoiceByBill->FSaMSumDataReportAll($aDataWhere);
            }else{
                $aDataSumReport = "";
            }
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport,$aDataSumReport,$aDataFilter);
        }else{
            $tViewRenderKool = "";
        }

        $aDataView      = array(
            'tTitleReport'      => language('report/report/report','tRptSaleVatInvoiceByBill'),
            'tRptTypeExport'    => $tRptTypeExport,
            'tRptCode'          => $tRptCode,
            'tRptRoute'         => $tRptRoute,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => $aDataReport
        );

        $this->load->view('report/report/wReportViewer',$aDataView);

    }


    // Functionality: Call Rpt Table Kool Report
    // Parameters:  Function Parameter
    // Creator: 23/04/2019 Wasin(Yoshi)
    // LastUpdate:
    // Return: View Kool Report
    // ReturnType: View
    public function FCNvCRenderKoolReportHtml($paDataReport,$paDataSumReport,$paDataFilter){
        $aDataWhere = array('FNLngID' => $paDataFilter['nLangID']);
        $tAPIReq    = "";
        $tMethodReq = "GET";
        $aCompData	= $this->mCompany->FSaMCMPList($tAPIReq,$tMethodReq,$aDataWhere);
        if($aCompData['rtCode'] == '1'){
            $tCompName      = $aCompData['raItems']['rtCmpName'];
            $tBchCode       = $aCompData['raItems']['rtCmpBchCode'];
            $tBchName       = $aCompData['raItems']['rtCmpBchName'];
        }else{
            $tCompName      = "-";
            $tBchCode       = "-";
            $tBchName       = "-";
        }
        
        // array ข้อมูลภาษาที่เกี่ยวข้องกับรายงาน
        $aDataTextRef = array(
            // Heard Report
            'tTitleReport'      => language('report/report/report','tRptSaleVatInvoiceByBill'),
            'tRptTaxNo'         => language('report/report/report','tRptTaxNo'),
            'tRptDatePrint'     => language('report/report/report','tRptDatePrint'),
            'tRptDateExport'    => language('report/report/report','tRptDateExport'),
            'tRptTimePrint'     => language('report/report/report','tRptTimePrint'),
            'tRptPrintHtml'     => language('report/report/report','tRptPrintHtml'),
            // Filter Heard Report
            'tRptBchFrom'       => language('report/report/report','tRptBchFrom'),
            'tRptBchTo'         => language('report/report/report','tRptBchTo'),
            'tRptDateFrom'      => language('report/report/report','tRptDateFrom'),
            'tRptDateTo'        => language('report/report/report','tRptDateTo'),
            // Table Report
            'tRptBarchCode'     => language('report/report/report','tRptBarchCode'),
            'tRptBarchName'     => language('report/report/report','tRptBarchName'),
            'tRptPosCode'       => language('report/report/report','tRptPosCode'),
            'tRptDate'          => language('report/report/report','tRptDate'),
            'tRptBillNo'        => language('report/report/report','tRptBillNo'),
            'tRptXshDocNo'      => language('report/report/report','tRptXshDocNo'),
            'tRptCst'           => language('report/report/report','tRptCst'),
            'tRptCstTaxNo'      => language('report/report/report','tRptCstTaxNo'),
            'tRptCstBussiness'  => language('report/report/report','tRptCstBussiness'),
            'tRptValue'         => language('report/report/report','tRptValue'),
            'tRptVat'           => language('report/report/report','tRptVat'),
            'tRptDisChgNotVat'  => language('report/report/report','tRptDisChgNotVat'),
            'tRptGrandSale'     => language('report/report/report','tRptGrandSale'),
            'tRptCstGeneral'    => language('report/report/report','tRptCstGeneral')
        );

        // Ref File Kool Report
        require_once APPPATH.'modules\report\datasources\rptSaleVatInvoiceByBill\rRptSaleVatInvoiceByBill.php';

        // Set Parameter To Report
        $oRptSaleVatInvoiceByBillHtml   = new rRptSaleVatInvoiceByBill(array(
            'nCurrentPage'      => $paDataReport['rnCurrentPage'],
            'nAllPage'          => $paDataReport['rnAllPage'],
            'tCompName'         => $tCompName,
            'tBchName'          => $tBchName,
            'tBchTaxNo'         => '-',
            'tAddressLine1'     => '-',
            'tAddressLine2'     => '-',
            'aFilterReport'     => $paDataFilter,
            'aDataTextRef'      => $aDataTextRef,
            'aDataSumReport'    => $paDataSumReport,
            'aDataReturn'       => $paDataReport['raItems']
        ));

        $oRptSaleVatInvoiceByBillHtml->run();
        $tHtmlViewReport    = $oRptSaleVatInvoiceByBillHtml->render('wRptSaleVatInvoiceByBillHtml',true);
        return $tHtmlViewReport;
    }





}