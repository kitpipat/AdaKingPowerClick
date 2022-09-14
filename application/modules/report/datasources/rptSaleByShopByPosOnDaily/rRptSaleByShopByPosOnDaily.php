<?php
require APPPATH."libraries\koolreport\autoload.php";

use \koolreport\processes\CalculatedColumn;
use \koolreport\processes\ColumnMeta;
use \koolreport\processes\DateTimeFormat;
use \koolreport\processes\CopyColumn;
use \koolreport\processes\Group;

class rRptSaleByShopByPosOnDaily extends \koolreport\KoolReport {
    use \koolreport\export\Exportable;

    public function settings(){
        return array(
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
            "rcTotalChgAndDisBalance"  => "{rtRptXshChg}-{rtRptXshDis}",
            "rcTotalSalsAfterDis" => "{rcTotalChgAndDisBalance}+{rtXshGrand}"
        )))
        ->pipe(new ColumnMeta(array(
            "rtXshDocDate"=>array(
                "type"=>"date",
                "format"=>"Y-m-d"
            ),
            "rtXshGrand"=>array(
                "type"=>'number'
            )
        )))        
        ->pipe(new CopyColumn(array(
            "year"=>"rtXshDocDate",
            "month"=>"rtXshDocDate",
        )))
        ->pipe(new DateTimeFormat(array(
            //"year"=>array('from' => 'Y', 'to' => 'Y'),
            //"month"=>"F, Y"
        )))
        ->pipe(new Group(array(
            "by"=>"rtPosCode",
            "sum"=>["rcTotalSalsAfterDis", "rcTotalChgAndDisBalance", "rtXshGrand"]
        )))     
        ->pipe($this->dataStore('RptSaleByShopByPosOnDaily'));
    }
    
    /*protected function setup(){
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
        )))->pipe($this->dataStore('RptSaleByShopByPosOnDaily'));
    }*/
    
}










































