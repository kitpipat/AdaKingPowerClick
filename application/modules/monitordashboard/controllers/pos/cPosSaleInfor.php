<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cPosSaleInfor extends MX_Controller {

    /**
     * ภาษา
     * @var array
    */
    public $aText   = [];

    public function __construct() {
        parent::__construct ();
        $this->load->model('monitordashboard/pos/mPosSaleInfor');
        if (!is_dir(APPPATH."modules\monitordashboard\assets\koolreport")) {
            mkdir(APPPATH."modules\monitordashboard\assets\koolreport");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad");
        }
        $this->init();

    }


    private function init(){
        $this->aText    = [
          
            'tDasTitleMenu'          => language('dashboard/dashboard','tDasTitleMenu'),
            'tDasComFrom'            => language('dashboard/dashboard','tDasComFrom'),
            'tDasGrapgvalues'            => language('dashboard/dashboard','tDasGrapgvalues'),
            // Address Lang
            'tDasDataCon'      => language('dashboard/dashboard', 'tDasDataCon'),
            'tDasPdtGroup'          => language('dashboard/dashboard', 'tDasPdtGroup'),
            'tDasTypeGroup'           => language('dashboard/dashboard', 'tDasTypeGroup'),
            'tDasBch'   => language('dashboard/dashboard', 'tDasBch'),
            'tDasShop'      => language('dashboard/dashboard', 'tDasShop'),
            'tDasSale'      => language('dashboard/dashboard', 'tDasSale'),
            'tDasBill'           => language('dashboard/dashboard', 'tDasBill'),
            'tDasDate'           => language('dashboard/dashboard', 'tDasDate'),
            'tDasWeek'        => language('dashboard/dashboard', 'tDasWeek'),
            'tDasMonth'         => language('dashboard/dashboard', 'tDasMonth'),
            'tDasYear'        => language('dashboard/dashboard', 'tDasYear'),
            'tDasDateData'        => language('dashboard/dashboard', 'tDasDateData'),
            // Filter Text Label Between
            'tDasSaleData'           => language('dashboard/dashboard', 'tDasSaleData'),
            'tDasInventory'             => language('dashboard/dashboard', 'tDasInventory'),
            'tDasVending'           => language('dashboard/dashboard', 'tDasVending'),
            'tDasVendingInventory'             => language('dashboard/dashboard', 'tDasVendingInventory'),
            'tDasLocker'          => language('dashboard/dashboard', 'tDasLocker'),
            'tDasTotalSaleBill'            => language('dashboard/dashboard', 'tDasTotalSaleBill'),
            'tDasTotalBillAmount'           => language('dashboard/dashboard', 'tDasTotalBillAmount'),
            'tDasSaleByProductGroup'             => language('dashboard/dashboard', 'tDasSaleByProductGroup'),
            'tDasNoProduct'   => language('dashboard/dashboard', 'tDasNoProduct'),
            'tDasDailyBestsell'       => language('dashboard/dashboard', 'tDasDailyBestsell'),
            'tDasDatanotfound'      => language('dashboard/dashboard', 'tDasDatanotfound'),
            'tDasTotalreturns'      => language('dashboard/dashboard', 'tDasTotalreturns'),
            
        ];

    }


    // เซ็ตไฟล์ เริ่มต้นเมื่อเข้าสู่ dash broad
    public function index(){
        // เซ็ต tag select บนขวาสุด ว่าอยู่หน้าไหน 


        $aData = array(
            "tRoute"=>1 ,
            'aDataTextRef'      => $this->aText
        );
        $this->load->view("monitordashboard/pos/possaleinfor/wPosSaleInfor",$aData);
    }

    // เป็นฟังก์ชั่น ดึงข้อมูลจากฐานข้อมูล เมื่อแรกเข้าสู่หน้า
    public function FSxCGetInforDashBoard(){
        $tConditionWritGraph = $this->input->post("tConditionWritGraph");
        $tTypeWriteGraph = $this->input->post("tTypeWriteGraph");
        $tWriteGraphCompare = $this->input->post("tWriteGraphCompare");
        $dDateFilter = $this->input->post("dDateFilter");
        $tTypeCalDisplayGraph = $this->input->post("tTypeCalDisplayGraph");
        $aSendToFillter = array(
            "tConditionWritGraph" => $tConditionWritGraph,
            "tTypeWriteGraph" => $tTypeWriteGraph,
            "tWriteGraphCompare" => $tWriteGraphCompare,
            "dDateFilter" => $dDateFilter,
            "tTypeCalDisplayGraph"=>$tTypeCalDisplayGraph
        );
        $aInforDB = $this->mPosSaleInfor->FSxMGetALLBillSale($aSendToFillter);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_graph.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aInforDB));
        fclose($oHandle);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_filter.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aSendToFillter));
        fclose($oHandle);
        $aNumSaleBill = $this->mPosSaleInfor->FSxMGetNumBillSale($aSendToFillter);
        // ส่วนยอดขาย
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_gross_sale.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aNumSaleBill));
        fclose($oHandle);
        $aNumReturnBill = $this->mPosSaleInfor->FSxMGetNumBillReturn($aSendToFillter);
        // ส่วนของการคืน
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_gross_return.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aNumReturnBill));
        fclose($oHandle);
        $aNumBill = array(
            "aNumSaleBill"=>$aNumSaleBill,
            "aNumReturnBill"=>$aNumReturnBill
        );
        echo json_encode($aNumBill);
    }

    // iframe graph เรียกใช้
    public function FSxCDisplaySaleChartInfor(){
        $tDasNoProduct        = language('dashboard/dashboard', 'tDasNoProduct');
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_graph.txt";
        $oHandle = fopen($tFileName, 'r');
        $aInforDB = json_decode(fread($oHandle,filesize($tFileName)), true);
        fclose($oHandle);
        $aInforDBForBar = $aInforDB;
        $aInforDBForPie = $aInforDB;
        require_once APPPATH.'modules\monitordashboard\datasources\graphPosSaleInfor\graphPosSaleInfor.php';
        
        /* bar chart */
        if($aInforDBForBar==false){
            $aInforDBForBar = array(array("FTType"=>"","FCValue"=>"0"));
        }
        $oGraphBarChart  = new graphPosSaleInfor(array(
            'aDataReturn'  => $aInforDBForBar
        ));
        $oGraphBarChart->run();
        $tHtmlViewBarChart   = $oGraphBarChart->render('wGraphPosSaleInforBar',true); 
        /* end bar chart */

        /* pie chart */
        if($aInforDBForPie){
            $bCheckNoErrorValueZeroForPieChart = false;
            for($nI=0;$nI<FCNnHSizeOf($aInforDBForPie);$nI++){
                if($aInforDBForPie[$nI]["FCValue"]!=0){
                    $bCheckNoErrorValueZeroForPieChart = true;
                    break;
                }
            }
            if($bCheckNoErrorValueZeroForPieChart==false){
                $aInforDBForPie = array(array("FTType"=>$tDasNoProduct,"FCValue"=>"1"));
            }
        }else{
            $aInforDBForPie = array(array("FTType"=>$tDasNoProduct,"FCValue"=>"1"));
        }
        $oGraphCircleChart  = new graphPosSaleInfor(array(
            'aDataReturn'  => $aInforDBForPie
        ));
        $oGraphCircleChart->run();
        $tHtmlViewCircleChart   = $oGraphCircleChart->render('wGraphPosSaleInforCircle',true); 
        /* end pie chart */
        
        $aData = array(
            'tHtmlViewBarChart'=>$tHtmlViewBarChart,
            'tHtmlViewCircleChart'=>$tHtmlViewCircleChart
        );
        $this->load->view("monitordashboard/pos/possaleinfor/chart/wChartSaleinfor",$aData);
    }

    // รายการสินค้าขายดีสุด
    public function FSxCLoadPdtBestSale(){
        $aListBestSalePdt = $this->mPosSaleInfor->FSxMGetListBestSalePdt($this->input->post("dDateFilter"));
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_best_sale_product.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aListBestSalePdt));
        fclose($oHandle);
        echo json_encode($aListBestSalePdt);
    }

    // จบ เซ็ตไฟล์ เริ่มต้นเมื่อเข้าสู่ dash broad
    // เขียนไฟล์ และดึงค่าจาก MQ การขาย
    public function FSxCAddInforByMQ(){
        

        
    }

}
