<?php
require APPPATH."libraries\koolreport\autoload.php";

class rRptCheckPrepaid extends \koolreport\KoolReport {


    public function settings(){

        $aDataReport = $this->params["aDataReturn"];

        if (isset($aDataReport['rtCode']) && $aDataReport['rtCode'] == 1) {
            $aDataKoolReport = $aDataReport['raItems'];
        } else {
            $aDataKoolReport = array();
        }

        return array(
            "assets"=>array(
                "path"  => "../../../assets/koolreport",
                "url"   => base_url()."application/assets/koolreport"
            ),
            "dataSources"   =>array(
                "DataReport"    =>array(
                    "class"         =>  "\koolreport\datasources\ArrayDataSource",
                    "data"          =>  $aDataKoolReport ,
                    "dataFormat"    =>  "associate"
                )
            )
        );
    }

    protected function setup(){
        $this->src('DataReport')->pipe($this->dataStore('RptCheckPrepaid'));
    }

}