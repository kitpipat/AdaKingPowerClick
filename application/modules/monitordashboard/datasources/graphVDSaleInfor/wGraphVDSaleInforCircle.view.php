<?php
    use \koolreport\chartjs\PieChart;
?>
<div style="width:100%">
    <?php

$tVenSalebycon         = language('dashboard/vending', 'tVenSalebycon');
$tDasSale         = language('dashboard/dashboard', 'tDasSale');
$tDasVending         = language('dashboard/dashboard', 'tDasVending');

        PieChart::create(array(
            "title"         => $tVenSalebycon  ,
            "dataSource"=>$this->dataStore("graphVDSaleInfor"),
            "columns"=>array(
                "FTType"=>array("label"=>$tDasVending ,"type"=>"string"),
                "FCValue"=>array("label"=>$tDasSale,"type"=>"number"),
                
            )
        ));
    ?>
</div>