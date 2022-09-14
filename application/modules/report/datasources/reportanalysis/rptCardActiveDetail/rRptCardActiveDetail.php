<?php
require APPPATH."libraries\koolreport\autoload.php";

class rRptCardActiveDetail extends \koolreport\KoolReport {
    use \koolreport\clients\jQuery;
    use \koolreport\clients\Bootstrap;

    public function settings(){
        return array(
            "assets"=>array(
                "path"  => "../../assets/koolreport",
                "url"   => base_url()."application/assets/koolreport"
            ),
            "dataSources"   =>array(
                "DataReport"    =>array(
                    "class"         =>  "\koolreport\datasources\ArrayDataSource",
                    "data"          =>  $this->params["aDataReport"]['raItems'],
                    "dataFormat"    =>  "associate"
                )
            )
        );
    }

    protected function setup(){
        $this->src('DataReport')->pipe($this->dataStore('RptCardActiveDetail'));
    }
    
}

