<?php
defined('BASEPATH') or exit('No direct script access allowed');

class cDashboardOverview extends MX_Controller {
    public function __construct(){
        parent::__construct();
        $this->load->driver('cache');
    }

    // Creator: 08/04/2021 Napat(Jame)
    public function index($nDOVBrowseType, $tDOVBrowseOption){

        $oPackDataDashboard = json_decode($this->cache->redis->get('oPackDataDashboard'),true);
        $dDataLastUpdOn     = $this->cache->redis->get('dDataLastUpdOn');

        $aDataConfigView    = [
            'nDOVBrowseType'        => $nDOVBrowseType,
            'tDOVBrowseOption'      => $tDOVBrowseOption,
            'aAlwEvent'             => FCNaHCheckAlwFunc('dashboardsale/0/0'),
            'aTextLang'             => $this->session->userdata("tLangEdit"),
            'nDecimalShow'          => FCNxHGetOptionDecimalShow(),

            'oPackDataDashboard'    => $oPackDataDashboard,
            'aDataMap'              => $oPackDataDashboard['aDataMap'],
            'cTotalSale'            => $oPackDataDashboard['cTotalSale'],
            'aDataPosType'          => $oPackDataDashboard['aDataPosType'],
            'aDataTopPdt'           => $oPackDataDashboard['aDataAgency'], // aDataTopPdt
            'dDataLastUpdOn'        => $dDataLastUpdOn
        ];
        $this->load->view('sale/dashboardoverview/wDashBoardOverview', $aDataConfigView);
    }

    public function FSvCDOVPageChart(){
        require_once APPPATH . 'modules\sale\views\dashboardoverview\datasources\chartsalebyregion\rChartSaleByRegion.php';

        // Get Data
        $oPackDataDashboard = json_decode($this->cache->redis->get('oPackDataDashboard'),true);

        // ChartSaleByRegion
        $oChartSaleByRegion    = new rChartSaleByRegion(array(
            'aDataReturn'   => $oPackDataDashboard['aDataGphRegion'],
            'nChartWidth'   => $this->input->post('pnChartWidth'),
            'nChartHeight'  => $this->input->post('pnChartHeight'),
            'aChartColor'   => array("#29b6f6", "#f06292", "#8bc34a", "#fdd835","#E27D60","#85DCB","#E8A87C","#C38D9E","#41B3A3")
        ));
        $oChartSaleByRegion->run();
        $tHtmlViewChartRegion = $oChartSaleByRegion->render('wChartSaleByRegion', true);

        // $oChartSaleByRegionFrame = fopen(APPPATH."modules/sale/views/dashboardoverview/datasources/chartsalebyregion/wChartSaleByRegionFrame.php", "w") or die("Unable to open file!");
        // fwrite($oChartSaleByRegionFrame, $tHtmlViewChartRegion);
        // fclose($oChartSaleByRegionFrame);

        // ChartSaleByPosType
        $oChartSaleByPosType    = new rChartSaleByRegion(array(
            'aDataReturn'   => $oPackDataDashboard['aDataGphPosType'],
            'nChartWidth'   => $this->input->post('pnChartWidth'),
            'nChartHeight'  => $this->input->post('pnChartHeight'),
            'aChartColor'   => array("#f06292", "#29b6f6", "#8bc34a", "#fdd835","#E27D60","#85DCB","#E8A87C","#C38D9E","#41B3A3")
        ));
        $oChartSaleByPosType->run();
        $tHtmlViewChartPosType = $oChartSaleByPosType->render('wChartSaleByRegion', true);

        // $oChartSaleByPosTypeFrame = fopen(APPPATH."modules/sale/views/dashboardoverview/datasources/chartsalebyregion/wChartSaleByPosTypeFrame.php", "w") or die("Unable to open file!");
        // fwrite($oChartSaleByPosTypeFrame, $tHtmlViewChartPosType);
        // fclose($oChartSaleByPosTypeFrame);

        $aViewChart    = [
            'oChartSaleByRegion'    => $tHtmlViewChartRegion,
            'oChartSaleByPosType'   => $tHtmlViewChartPosType
        ];
        echo json_encode($aViewChart);

    }

    public function FStCDOVEventCheckLastData(){
        echo $this->cache->redis->get('dDataLastUpdOn');
    }

    // public function TestSendMessage(){
    //     // $aDataSave = array(
    //     //     "aDataMap" => array(
    //     //         array(
    //     //             "tPosCode" => "00001",
    //     //             "nPosType" => 1,
    //     //             "tPosTypeName" => "PC",
    //     //             "cLat" => 13.786801,
    //     //             "cLong" => 100.614152
    //     //         ),
    //     //         array(
    //     //             "tPosCode" => "00001",
    //     //             "nPosType" => 2,
    //     //             "tPosTypeName" => "Mobile",
    //     //             "cLat" => 13.78965,
    //     //             "cLong" => 100.613466
    //     //         ),
    //     //         array(
    //     //             "tPosCode" => "00001",
    //     //             "nPosType" => 2,
    //     //             "tPosTypeName" => "Mobile",
    //     //             "cLat" => 18.788334,
    //     //             "cLong" => 98.985291
    //     //         )
    //     //     ),
    //     //     "aDataPosType" => array(
    //     //         array(
    //     //             "tTitle" => "Mobile",
    //     //             "cValue" => 2
    //     //         ),
    //     //         array(
    //     //             "tTitle" => "PC",
    //     //             "cValue" => 1
    //     //         )
    //     //     ),
    //     //     "cTotalSale" => 633,
    //     //     "aDataGphRegion" => array(
    //     //         array(
    //     //             "tTitle" => "ภาคกลาง",
    //     //             "cValue" => 1183
    //     //         ),
    //     //         array(
    //     //             "tTitle" => "ภาคกลาง",
    //     //             "cValue" => 155
    //     //         ),
    //     //         array(
    //     //             "tTitle" => "ภาคกลาง",
    //     //             "cValue" => 32
    //     //         )
    //     //     ),
    //     //     "aDataGphPosType" => array(
    //     //         array(
    //     //             "tTitle" => "Mobile",
    //     //             "cValue" => 1215
    //     //         ),
    //     //         array(
    //     //             "tTitle" => "PC",
    //     //             "cValue" => 155
    //     //         )
    //     //     ),
    //     //     "aDataTopPdt" => array()
    //     // );
    //     $this->cache->redis->save('dDataLastUpdOn', date('Y-m-d H:i:s'),9999999);
    // }
}

?>