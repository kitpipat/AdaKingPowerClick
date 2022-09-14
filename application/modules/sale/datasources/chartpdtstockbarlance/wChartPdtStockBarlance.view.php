<?php

use \koolreport\chartjs\PieChart;

$aTextData  = $this->params["aTextLang"];
?>
<!-- load Script Plugin -->
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-annotation/chartjs-plugin-annotation.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js'); ?>"></script>
<div style="width:100%">
    <?php
    PieChart::create(array(
        "dataSource"        => $this->dataStore("ChartPdtStockBarlanceData"),
        "colorScheme"       => array("#E30022", "#FF8B00", "#FEE72F", "#03C03C", "#1F75FE", "662B7E"),
        "backgroundOpacity" => 0,
        "columns"           => array(
            "FTPdtName"     => array("type" => "string"),
            "FCStkQty"      => array(
                "label"     =>  $aTextData['tDSHSALStkQty'],
                "type"      => "number",
                "formatValue"   => function ($cValue) {
                    return number_format($cValue, 2) . " บาท";
                },
            ),
        ),
        "plugins"           => array("annotation", "datalabels"),
        "options"           => array(
            "legend"        => array("position" => "top"),
            "responsive"    => true,
            "isStacked"     => true,
            "plugins"       => array(
                "datalabels"    => array(
                    "color"     => "#FFFFFF",
                    "align"     => "center",
                )
            )
        )
    ));
    ?>
</div>