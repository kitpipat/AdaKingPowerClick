<?php

use \koolreport\chartjs\PieChart;

$aTextData  = $this->params["aTextLang"];
?>
<!-- load Script Plugin -->
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-annotation/chartjs-plugin-annotation.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js'); ?>"></script>
<div style="width:80%;">
    <?php
    PieChart::create(array(
        "dataSource"        => $this->dataStore("ChartTotalSaleByReciveData"),
        "colorScheme"       => array("#FF3C85", "#FEDC00", "#F9980C", "#742785", "#C062C0", "#FFC8BF"),
        "backgroundOpacity" => 0,
        "columns"           => array(
            "FTRcvName"     => array("type" => "string"),
            "FCXsdNet"      => array(
                "label"     =>  $aTextData['tDSHSALXsdNet'],
                "type"      => "number",
                "formatValue"   => function ($cValue) {
                    return number_format($cValue, 2) . " บาท";
                },
            ),
        ),
        "plugins"           => array("annotation", "datalabels"),
        "options"           => array(
            "legend"        => array("position" => "right"),
            "responsive"    => true,
            "isStacked"     => true,
            "plugins"       => array(
                "datalabels"    => array(
                    "color"     => "#FFFFFF",
                    "align"     => "center",
                )
            )
        ),
    ));
    ?>
</div>