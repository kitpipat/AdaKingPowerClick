<?php
require APPPATH."libraries\koolreport\autoload.php";

class rRptCardNoActive extends \koolreport\KoolReport {
    
    // use \koolreport\clients\jQuery;
    // use \koolreport\clients\Bootstrap;
    
    public function settings()
    {

        $aDataReport = $this->params["aDataReturn"];

        if (isset($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $aDataKoolReport = $aDataReport['raItems'];
        } else {
            $aDataKoolReport = array();
        }

        return array(
            "assets" => array(
                "path" => "../../../assets/koolreport",
                "url" => base_url() . "application/modules/report/assets/koolreport",
            ),
            "dataSources" => array(
                "DataReport" => array(
                    "class" => "\koolreport\datasources\ArrayDataSource",
                    "data" => $aDataKoolReport,
                    "dataFormat" => "associate",
                ),
            ),
        );
    }

    protected function setup(){
        $this->src('DataReport')->pipe($this->dataStore('RptCardNoActivesCard'));
    }

}
