<?php
require APPPATH."libraries\koolreport\autoload.php";

use \koolreport\processes\CalculatedColumn;
class rRptUnExchangeBalance extends \koolreport\KoolReport {
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
        $this->src('DataReport')
        ->pipe(new CalculatedColumn(array(
            "rcTotalValue"   =>  function($aRow){
                return $aRow["rcCrdExpiredValue"] - $aRow["rcCrdReturnValue"];
            }
        )))->pipe($this->dataStore('RptUnExchangeBalance'));
    }

}