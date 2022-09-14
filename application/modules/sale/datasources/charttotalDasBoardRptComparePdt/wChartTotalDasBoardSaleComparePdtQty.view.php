<?php

// use \koolreport\chartjs\ColumnChart;
use \koolreport\widgets\google\ColumnChart;

$aTextData  = $this->params["aTextLang"];
$aTextDataReturn  = $this->params["aDataReturn"];

// // print_r($aTextData);


$nTypeGroupReport  = $aTextDataReturn[0]['FTRptGrp'];
$tGroupRpt = '';
if ($nTypeGroupReport == '01') {
    $tGroupRpt  = $aTextData['tRptGrpBranch'];
} elseif ($nTypeGroupReport == '02') {
    $tGroupRpt = $aTextData['tRptGrpAgency'];
} elseif ($nTypeGroupReport == '03') {
    $tGroupRpt = $aTextData['tRptGrpShop'];
} elseif ($nTypeGroupReport == '04') {
    $tGroupRpt = $aTextData['tRptProduct'];
} elseif ($nTypeGroupReport == '05') {
    $tGroupRpt = $aTextData['tRptGrpPdtType'];
} elseif ($nTypeGroupReport == '06') {
    $tGroupRpt = $aTextData['tRptGrpPdtGroup'];
} elseif ($nTypeGroupReport == '07') {
    $tGroupRpt = $aTextData['tRptGrpPdtBrand'];
} elseif ($nTypeGroupReport == '08') {
    $tGroupRpt = $aTextData['tRptGrpPdtModel'];
}

?>


<!-- load Script Plugin -->
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-annotation/chartjs-plugin-annotation.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js'); ?>"></script>
<div style="width:100%">
    <?php
    ColumnChart::create(array(
        // "title" => "กราฟเปรียบเทียบยอดขายตาม MTD (QTY)",
        "width" => "100%",
        "dataSource"        => $this->dataStore("oChartTotalRptDashBoardComparePdtQty"),
        "backgroundOpacity" => 0,
        "columns"       => array(
            "FTRptGrpName" => array("type" => "string"),
            //QTY Last Year 
            "FCRptQtyMTD_LY"  => array(
                "type"  => "number",
                "label" =>  $aTextData['tDSHSALSaleCompareLastYear'],
                "formatValue"   => function ($cValue) {
                    return number_format($cValue, 2) . " ";
                },
                "style" => "color:" #FF3C85",
            ),
            //QTY This Year
            "FCRptQtyMTD"  => array(
                "type"  => "number",
                "label" =>  $aTextData['tDSHSALSaleCompareThisYear'],
                "formatValue"   => function ($cValue) {
                    return number_format($cValue, 2) . " ";
                },

                "style" => "color:" #dc3912";
            ),
        ),
        "plugins"           => array("annotation", "datalabels"),
        "options"           => array(
            "vAxis" => array(
                "title" => $aTextData['tDSHSALSaleCompareAmount']
            ),
            "hAxis" => array(
                "title" => $tGroupRpt,
            ),
            // "legend"        => array("position" => "none"),
            // "isStacked"     => true,
            // "orientation"   => "horizontal",
            "scales" => array(
                "xAxes" => array(
                    array(
                        "ticks" => array(
                            "autoSkip" => false
                        )
                    )
                )
            ),
            "plugins"       => array(
                "datalabels"    => array(
                    "color"     => "#FFFF",
                    "align"     => "center",
                    "anchor"    => "end",
                    "align"     => "top",
                    "offset"    => 5,
                    "font"      => array("size" => 0),
                )
            )
        ),
    ));

    ?>
</div>