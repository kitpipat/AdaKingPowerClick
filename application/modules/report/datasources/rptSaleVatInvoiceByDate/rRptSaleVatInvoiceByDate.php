<?php
require APPPATH."libraries\koolreport\autoload.php";

use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\CopyColumn;

class rRptSaleVatInvoiceByDate extends \koolreport\KoolReport {
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
        ->pipe(new CopyColumn(array(
            "FTXshDocSale"      =>  "FTXshFirstLastDocNo",
            "FTXshDocReturn"    =>  "FTXshFirstLastDocNo"
        )))
        ->pipe($this->dataStore('RptSaleVatInvoiceByDate'));
    }


}