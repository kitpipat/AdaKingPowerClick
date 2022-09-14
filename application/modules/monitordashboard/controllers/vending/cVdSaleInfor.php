<?php
defined ( 'BASEPATH' ) or exit ( 'No direct script access allowed' );

class cVdSaleInfor extends MX_Controller {

    public function __construct() {
        parent::__construct ();
        $this->load->model('monitordashboard/vending/mVdSaleInfor');
        if (!is_dir(APPPATH."modules\monitordashboard\assets\koolreport")) {
            mkdir(APPPATH."modules\monitordashboard\assets\koolreport");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending");
        }
        if (!is_dir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad")) {
            mkdir(APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad");
        }
    }
    // เซ็ตไฟล์ เริ่มต้นเมื่อเข้าสู่ dash broad
    public function index(){
        $tBranchCom = FCNtGetBchInComp();
        if($tBranchCom){
            $aBranch = $this->mVdSaleInfor->FSxMGetBranchInfor();
            $aMerChant = $this->mVdSaleInfor->FSxMGetMerChantInfor($tBranchCom);
            if($aMerChant){
                $aShop = $this->mVdSaleInfor->FSxMGetShopInfor($tBranchCom,$aMerChant[0]["FTMerCode"]);
            }else{
                $aShop = false;
            }
        }else{
            $aBranch = false;
            $aMerChant = false;
            $aShop = false;
        }
        //TVDTSalHD TVDTSalDT
        $aDataInfor = array(
            "aBranch"=>$aBranch,
            "aMerChant"=>$aMerChant,
            "aShop"=>$aShop,
            "aBrancCom"=>$tBranchCom,
            "tRoute"=>3
        );
        $this->load->view("monitordashboard/vending/possaleinfor/wPosSaleInfor",$aDataInfor);
    }
    public function FSxCGetMerChantInfor(){
        $aMerChant = $this->mVdSaleInfor->FSxMGetMerChantInfor($this->input->post("tBranch"));
        echo json_encode($aMerChant);
    }
    public function FSxCGetShopInfor(){
        $aShop = $this->mVdSaleInfor->FSxMGetShopInfor($this->input->post("tBranch"),$this->input->post("tMerChant"));
        echo json_encode($aShop);
    }
    public function FSxCGetInforDashBoard(){
        $tBCH = $this->input->post("tBCH");
        $tMCH = $this->input->post("tMCH");
        $tSPH = $this->input->post("tSPH");
        $dDateFilter = $this->input->post("dDateFilter");
        $aSendToFillter = array(
            "tBCH" => $tBCH,
            "tMCH" => $tMCH,
            "tSPH" => $tSPH,
            "dDateFilter" => $dDateFilter
        );
        $aInforDB = $this->mVdSaleInfor->FSxMGetALLGrossSale($aSendToFillter);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_graph.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aInforDB));
        fclose($oHandle);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_filter.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aSendToFillter));
        fclose($oHandle);
        $aNumSaleBill = $this->mVdSaleInfor->FSxMGetNumBillSale($aSendToFillter);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_gross_sale.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aNumSaleBill));
        fclose($oHandle);
        $aNumReturnBill = $this->mVdSaleInfor->FSxMGetNumBillReturn($aSendToFillter);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_gross_return.txt";
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

    public function FSxCDisplaySaleChartInfor(){
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_graph.txt";
        $oHandle = fopen($tFileName, 'r');
        $aInforDB = json_decode(fread($oHandle,filesize($tFileName)), true);
        fclose($oHandle);
        $aInfor = array(
            "aInforDB" => $aInforDB
        );
        $aInforDBForBar = $aInforDB;
        $aInforDBForPie = $aInforDB;
        require_once APPPATH.'modules\monitordashboard\datasources\graphVDSaleInfor\graphVDSaleInfor.php';

        $tDasNoitem         = language('dashboard/dashboard', 'tDasNoitem');
        /* bar chart */
        if($aInforDBForBar==false){
            $aInforDBForBar = array(array("FTType"=>"","FCValue"=>"0"));
        }
        $oGraphBarChart  = new graphPosSaleInfor(array(
            'aDataReturn'  => $aInforDBForBar
        ));
        $oGraphBarChart->run();
        $tHtmlViewBarChart   = $oGraphBarChart->render('wGraphVDSaleInforBar',true); 
        /* end bar chart */
        /* pie chart */
        // ถ้าไม่มีข้อมูลไฟล์เลย ให้เซ็ตค่าให้ ชาท วงกลม เป็น 1 เพื่อให้แสดงวงกลม แต่ detail คือ ไม่มีรายการ
        if($aInforDBForPie){
            $bCheckNoErrorValueZeroForPieChart = false;
            for($nI=0;$nI<FCNnHSizeOf($aInforDBForPie);$nI++){
                if($aInforDBForPie[$nI]["FCValue"]!=0){
                    $bCheckNoErrorValueZeroForPieChart = true;
                    break;
                }
            }
            if($bCheckNoErrorValueZeroForPieChart==false){
                $aInforDBForPie = array(array("FTType"=>$tDasNoitem,"FCValue"=>"1"));
            }
        }else{
            $aInforDBForPie = array(array("FTType"=>$tDasNoitem,"FCValue"=>"1"));
        }
        $oGraphCircleChart  = new graphPosSaleInfor(array(
            'aDataReturn'  => $aInforDBForPie
        ));
        $oGraphCircleChart->run();
        $tHtmlViewCircleChart   = $oGraphCircleChart->render('wGraphVDSaleInforCircle',true); 
        /* end pie chart */
        $aData = array(
            'tHtmlViewBarChart'=>$tHtmlViewBarChart,
            'tHtmlViewCircleChart'=>$tHtmlViewCircleChart
        );
        $this->load->view("monitordashboard/vending/possaleinfor/chart/wChartSaleinfor",$aData);
    }
    public function FSxCLoadPdtBestSale(){
        $aFillter = array(
            "dDateFilter" => $this->input->post("dDateFilter"),
            "tBCH" => $this->input->post("tBCH"),
            "tMCH" => $this->input->post("tMCH"),
            "tSPH" => $this->input->post("tSPH")
        );
        $aListBestSalePdt = $this->mVdSaleInfor->FSxMGetListBestSalePdt($aFillter);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_best_sale_product.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aListBestSalePdt));
        fclose($oHandle);
        echo json_encode($aListBestSalePdt);
    }
    public function FSxCLoadHistoryPosSale(){
        $aFillter = array(
            "dDateFilter" => $this->input->post("dDateFilter"),
            "tBCH" => $this->input->post("tBCH"),
            "tMCH" => $this->input->post("tMCH"),
            "tSPH" => $this->input->post("tSPH")
        );
        $aListBestSalePdt = $this->mVdSaleInfor->FSxMLoadHistoryPosSale($aFillter);
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_history_pos_sale.txt";
        $oHandle = fopen($tFileName, 'w');
        rewind($oHandle);
        fwrite($oHandle, json_encode($aListBestSalePdt));
        fclose($oHandle);
        //echo json_encode($aListBestSalePdt);
    }

    public function FSxCVDDetail(){

        $aData = array(
            
        );
        $this->load->view("monitordashboard/vending/possaleinfor/wVDDetail",$aData);
    }
    // จบ เซ็ตไฟล์ เริ่มต้นเมื่อเข้าสู่ dash broad
    // ดึงข้อมูลจากไฟล์ด้วยการแบ่งหน้า ของรายการ POS VD
    public function FSxCGetHistoryPosSale(){
        $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\\vending\saledashbroad\db_tmp_history_pos_sale.txt";
        $oHandle = fopen($tFileName, 'r');
        $aInforDB = json_decode(fread($oHandle,filesize($tFileName)), true);
        fclose($oHandle);
        $aInforOutPut = array();
        if($aInforDB){
            $tPage = $this->input->post("tPage");
            $nPerPage = 8;
            $nPageAll = ceil(FCNnHSizeOf($aInforDB)/$nPerPage);
            $nRecordStart = ($tPage-1)*$nPerPage;
            if($tPage==$nPageAll){
                $nRecordEnd = FCNnHSizeOf($aInforDB);
            }else{
                $nRecordEnd = $tPage*$nPerPage;
            }
            
            for($nI=$nRecordStart;$nI<$nRecordEnd;$nI++){
                array_push($aInforOutPut,$aInforDB[$nI]);
            }
        }else{
            $tPage = false;
            $nPerPage =false;
            $nPageAll = false;
            $aInforOutPut = false;
        }
        $aInforSend = array(
            "aInfor" => $aInforOutPut,
            "tPage" => $tPage,
            "nPerPage" =>$nPerPage,
            "nPageAll" => $nPageAll
        );
        echo json_encode($aInforSend);
    }

    public function FSxCAddInforByMQ(){
        
        

        
    }
}
