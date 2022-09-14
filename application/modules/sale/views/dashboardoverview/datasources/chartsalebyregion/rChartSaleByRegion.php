<?php
require APPPATH."libraries\koolreport\autoload.php";

class rChartSaleByRegion extends \koolreport\KoolReport {
    // use \koolreport\clients\jQuery;
    // use \koolreport\clients\Bootstrap;

    public function settings(){
        return array(
            "assets"=>array(
                "path"  => "../../../../assets/koolreport",
                "url"   => base_url()."application/modules/sale/assets/koolreport"
            ),
            "dataSources"   =>array(
                "DataReport"    =>array(
                    "class"         =>  "\koolreport\datasources\ArrayDataSource",
                    "data"          =>  $this->params["aDataReturn"],
                    "dataFormat"    =>  "associate"
                )
            )
        );
    }

    protected function setup(){
        $this->src('DataReport')->pipe($this->dataStore('ChartSaleByRegionData'));
        $this->nChartWidth  = $this->params["nChartWidth"];
        $this->nChartHeight = $this->params["nChartHeight"];
        $this->aChartColor  = $this->params["aChartColor"];
    }
}