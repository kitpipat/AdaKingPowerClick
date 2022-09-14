<?php
require APPPATH."libraries\koolreport\autoload.php";

use \koolreport\processes\CalculatedColumn;

class rRptSaleVatInvoiceByBill extends \koolreport\KoolReport {
    use \koolreport\clients\jQuery;
    use \koolreport\clients\Bootstrap;

    public function settings(){
        return array(
            "assets"=>array(
                "path"  => "../../assets/koolreport",
                "url"   => base_url()."application/modules/report/assets/koolreport"
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
        $this->src('DataReport')
        ->pipe(new CalculatedColumn(array(
            'FCXshValue' => "{FCXshGrand}+{FCXshTotalAfDisChgNV}-{FCXshVat}",
        )))
        ->pipe($this->dataStore('RptSaleVatInvoiceByBill'));

    }

}