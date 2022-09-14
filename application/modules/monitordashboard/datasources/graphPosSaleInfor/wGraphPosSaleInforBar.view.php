<?php
    use \koolreport\chartjs\ColumnChart;
    $tFileName= APPPATH."modules\monitordashboard\assets\systemtmp\dbtmp\pos\saledashbroad\db_tmp_filter.txt";
    $oHandle = fopen($tFileName, 'r');
    $aInforDB = json_decode(fread($oHandle,filesize($tFileName)), true);
    fclose($oHandle);
    $tTitle = "";
    $tTypeFillter = "";
    $tFormatFillter = "";
    $tDasShop  = language('dashboard/dashboard', 'tDasShop');
    $tDasSale  = language('dashboard/dashboard', 'tDasSale');
    $tDasBch  = language('dashboard/dashboard', 'tDasBch');
    $tDasBill  = language('dashboard/dashboard', 'tDasBill');
    $tDasTypeGroup  = language('dashboard/dashboard', 'tDasTypeGroup');
    $tDasPdtGroup  = language('dashboard/dashboard', 'tDasPdtGroup');
    $tDasAs  = language('dashboard/dashboard', 'tDasAs');
    if($aInforDB["tTypeCalDisplayGraph"]=="gross"){
        $tTypeFillter = $tDasSale;
    }else if($aInforDB["tTypeCalDisplayGraph"]=="bill"){
        $tTypeFillter = $tDasBill;
    }
    if($aInforDB["tTypeWriteGraph"]=="pdtGroup"){
        $tFormatFillter =  $tDasPdtGroup;
    }else if($aInforDB["tTypeWriteGraph"]=="pdtType"){
        $tFormatFillter = $tDasTypeGroup;
    }else if($aInforDB["tTypeWriteGraph"]=="usrBranch"){
        $tFormatFillter =  $tDasBch;
    }else if($aInforDB["tTypeWriteGraph"]=="usrShop"){
        $tFormatFillter =   $tDasShop ;
    }
    $tTitle = $tTypeFillter.$tDasAs.$tFormatFillter;
?>
<div style="width:100%">
    <?php
        ColumnChart::create(array(
            "title"         => $tTitle,
            "dataSource"    => $this->dataStore("graphPosSaleInfor"),
            "columns"       => array(
                "FTType"=>array("label"=>$tFormatFillter,"type"=>"string"),
                "FCValue"=>array("label"=>$tTypeFillter,"type"=>"number"),
            )
        ));
    ?>
</div>