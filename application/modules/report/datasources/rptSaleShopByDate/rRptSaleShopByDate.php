<?php
require APPPATH."libraries\koolreport\autoload.php";

use \koolreport\processes\CalculatedColumn;

class rRptSaleShopByDate extends \koolreport\KoolReport {
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
            'rcTxnSaleVal' => function($aData){
                if(isset($aData['rtXshDocType']) && !empty($aData['rtXshDocType']) && $aData['rtXshDocType'] == 1){
                    return  $aData['rtXshGrand'];
                }else{
                    return  0;
                }
            },
            'rcTxnCancelSaleVal' => function($aData){
                if(isset($aData['rtXshDocType']) && !empty($aData['rtXshDocType']) && $aData['rtXshDocType'] == 9){
                    return  $aData['rtXshGrand'];
                }else{
                    return  0;
                }
            },
            "rcTotalSale" => "{rcTxnSaleVal} - {rcTxnCancelSaleVal}",
        )))->pipe($this->dataStore('RptSaleShopByDate'));
    }

}