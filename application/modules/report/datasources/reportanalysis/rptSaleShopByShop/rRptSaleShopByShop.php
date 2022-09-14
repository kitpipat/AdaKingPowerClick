<?php
require APPPATH."libraries\koolreport\autoload.php";

// use \koolreport\processes\CalculatedColumn;
// use \koolreport\clients\jQuery;
// use \koolreport\clients\Bootstrap;

class rRptSaleShopByShop extends \koolreport\KoolReport {
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
        /*->pipe(new CalculatedColumn(array(
            "rcTotalSale"   =>  function($aRow){
                return $aRow["rcTxnSaleVal"] - $aRow["rcTxnCancelSaleVal"];
            }
        )))*/->pipe($this->dataStore('RptSaleShopByShop'));
    }

}
