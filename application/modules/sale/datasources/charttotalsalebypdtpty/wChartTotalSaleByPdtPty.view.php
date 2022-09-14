<?php

use \koolreport\chartjs\ColumnChart;

$aTextData  = $this->params["aTextLang"];
?>
<!-- load Script Plugin -->
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-annotation/chartjs-plugin-annotation.min.js'); ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js'); ?>"></script>
<div style="width:100%">
    <?php
    ColumnChart::create(array(
        "dataSource"        => $this->dataStore("ChartTotalSaleByPdtPtyData"),
        "colorScheme"       => array("#FFCF09"),
        "backgroundOpacity" => 0,
        "columns"       => array(
            "FTPtyName" => array("type" => "string"),
            "FCXsdNet"  => array(
                "type"  => "number",
                "label" =>  $aTextData['tDSHSALXsdNet'],
                "formatValue"   => function ($cValue) {
                    return number_format($cValue, 2) . " บาท";
                },
            ),
        ),
        "plugins"           => array("annotation", "datalabels"),
        "options"           => array(
            "legend"        => array("position" => "none"),
            "isStacked"     => true,
            "orientation"   => "horizontal",
            "plugins"       => array(
                "annotation"    => array(
                    "drawTime"      => "afterDatasetsDraw",
                    "dblClickSpeed" => 350,
                ),
                "datalabels"    => array(
                    "color"     => "#FFCF09",
                    "align"     => "center",
                    "anchor"    => "end",
                    "align"     => "top",
                    "offset"    => 5,
                    "font"      => array("size" => 12),
                )
            )
        ),
    ));
    ?>
</div>