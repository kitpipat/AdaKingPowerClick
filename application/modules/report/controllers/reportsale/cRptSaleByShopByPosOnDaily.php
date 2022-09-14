<?php defined('BASEPATH') or exit('No direct script access allowed');

include APPPATH.'third_party/PHPExcel/Classes/PHPExcel.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/IOFactory.php';
include APPPATH.'third_party/PHPExcel/Classes/PHPExcel/Writer/Excel2007.php';

/** Ref File Kool Report */
require_once APPPATH.'modules\report\datasources\rptSaleByShopByPosOnDaily\rRptSaleByShopByPosOnDaily.php';

class cRptSaleByShopByPosOnDaily extends MX_Controller {

    public function __construct(){
        parent::__construct ();
        $this->load->model('report/report/mReport');
        $this->load->model('report/reportsale/mRptSaleByShopByPosOnDaily');
        $this->load->model('company/company/mCompany');
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
                'tShopCodeFrom' => !empty($this->input->post('oetRptShpCodeFrom'))  ? $this->input->post('oetRptShpCodeFrom')   : NULL,
                'tShopNameFrom' => !empty($this->input->post('oetRptShpNameFrom'))  ? $this->input->post('oetRptShpNameFrom')   : NULL,
                'tShopCodeTo'   => !empty($this->input->post('oetRptShpCodeTo'))    ? $this->input->post('oetRptShpCodeTo')     : NULL,
                'tShopNameTo'   => !empty($this->input->post('oetRptShpNameTo'))    ? $this->input->post('oetRptShpNameTo')     : NULL,
                'tDocDateFrom'  => !empty($this->input->post('oetRptDocDateFrom'))  ? $this->input->post('oetRptDocDateFrom')   : NULL,
                'tDocDateTo'    => !empty($this->input->post('oetRptDocDateTo'))    ? $this->input->post('oetRptDocDateTo')     : NULL,
                'nLangID'       => FCNaHGetLangEdit(),
            );
            // Execute Stored Procedure
            $this->mRptSaleByShopByPosOnDaily->FSnMExecStoreReport($aDataFilter);

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
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 9/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSvCCallRptViewBeforePrint($ptRptRoute, $ptRptCode, $ptRptTypeExport, $paDataFilter){
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
        $aDataReport = $this->mRptSaleByShopByPosOnDaily->FSaMGetDataReport($aDataWhere);
        if(!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1){
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport,$aDataFilter);
        }else{
            $tViewRenderKool = "";
        }

        $aDataView      = array(
            'tTitleReport'      => language('report/report/report','tRptTitleSaleByShopByPosOnDaily'),
            'tRptTypeExport'    => $tRptTypeExport,
            'tRptCode'          => $tRptCode,
            'tRptRoute'         => $tRptRoute,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => $aDataReport
        );
    
        $this->load->view('report/report/wReportViewer',$aDataView);
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 3/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
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
            'nRow'      => 1000,
        );
        // Get Data Report  
        $aDataReport    = $this->mRptSaleByShopByPosOnDaily->FSaMGetDataReport($aDataWhere);
        if(!empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1){
            $tViewRenderKool = $this->FCNvCRenderKoolReportHtml($aDataReport,$aDataFilter);
        }else{
            $tViewRenderKool = "";
        }
        $aDataView      = array(
            'tTitleReport'      => language('report/report/report','tRptTitleSaleByShopByPosOnDaily'),
            'tRptTypeExport'    => $tRptTypeExport,
            'tRptCode'          => $tRptCode,
            'tRptRoute'         => $tRptRoute,
            'tViewRenderKool'   => $tViewRenderKool,
            'aDataFilter'       => $aDataFilter,
            'aDataReport'       => $aDataReport
        );
        $this->load->view('report/report/wReportViewer',$aDataView);
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 3/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FCNvCRenderKoolReportHtml($paDataReport,$paDataFilter){
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
            'tTitleReport'          => language('report/report/report','tRptTitleSaleByShopByPosOnDaily'),
            'tRptTaxNo'             => language('report/report/report','tRptTaxNo'),
            'tRptDatePrint'         => language('report/report/report','tRptDatePrint'),
            'tRptDateExport'        => language('report/report/report','tRptDateExport'),
            'tRptTimePrint'         => language('report/report/report','tRptTimePrint'),
            'tRptPrintHtml'         => language('report/report/report','tRptPrintHtml'),
            // Filter Heard Report
            'tRptBchFrom'           => language('report/report/report','tRptBchFrom'),
            'tRptBchTo'             => language('report/report/report','tRptBchTo'),
            'tRptShopFrom'          => language('report/report/report','tRptShopFrom'),
            'tRptShopTo'            => language('report/report/report','tRptShopTo'),
            'tRptDateFrom'          => language('report/report/report','tRptDateFrom'),
            'tRptDateTo'            => language('report/report/report','tRptDateTo'),
            // Table Report
            'tRptBarchCode'         => language('report/report/report','tRptBarchCode'),
            'tRptBarchName'         => language('report/report/report','tRptBarchName'),
            'tRptDocDate'           => language('report/report/report','tRptDocDate'),
            'tRptDate'              => language('report/report/report','tRptDate'),
            'tRptDocSale'           => language('report/report/report','tRptDocSale'),
            'tRptDocReturn'         => language('report/report/report','tRptDocReturn'),
            'tRptSales'             => language('report/report/report','tRptSales'),
            'tRptDiscount'          => language('report/report/report','tRptDiscount'),
            'tRptGrandSale'         => language('report/report/report','tRptGrandSale'),
            'tRptShopCode'          => language('report/report/report','tRptShopCode'),
            'tRptShopName'          => language('report/report/report','tRptShopName'),
            'tRptAmount'            => language('report/report/report','tRptAmount'),
            'tRptSale'              => language('report/report/report','tRptSale'),
            'tRptCancelSale'        => language('report/report/report','tRptCancelSale'),
            'tRptTotalSale'         => language('report/report/report','tRptTotalSale'),
            'tRptTotalAllSale'      => language('report/report/report','tRptTotalAllSale'),
        );

        // Ref File Kool Report
        require_once APPPATH.'modules\report\datasources\rptSaleByShopByPosOnDaily\rRptSaleByShopByPosOnDaily.php';
        
        // Set Parameter To Report
        $oRptSaleShopByDateHtml = new rRptSaleByShopByPosOnDaily(array(
            'nCurrentPage'      => $paDataReport['rnCurrentPage'],
            'nAllPage'          => $paDataReport['rnAllPage'],
            'tCompName'         => $tCompName,
            'tBchName'          => $tBchName,
            'tBchTaxNo'         => '-',
            'tAddressLine1'     => '-',
            'tAddressLine2'     => '-',
            'aDataTest'         => $this->mRptSaleByShopByPosOnDaily->getData(),
            'aFilterReport'     => $paDataFilter,
            'aDataTextRef'      => $aDataTextRef,
            'aDataReturn'       => $paDataReport['raItems']
        ));
        $oRptSaleShopByDateHtml->run();
        $tHtmlViewReport    = $oRptSaleShopByDateHtml->render('wRptSaleByShopByPosOnDailyHtml',true);
        return $tHtmlViewReport;
    }
    
    /**
     * Functionality : 
     * Parameters : 
     * Creator : 3/04/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    public function FSoCRptExportExcel($paRptFilter){
        try{
            
        }catch(Exception $Err){
            $aExportData =  array(
                'nStaExport'    => '800',
                'tMessage'      => "Eror cRptSaleByShopByPosOnDaily Function(FSoCRptExportExcel) => ".$Err,
            );
        }
        
    }
}




















