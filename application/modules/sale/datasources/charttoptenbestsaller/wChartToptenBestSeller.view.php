<?php

use \koolreport\chartjs\BarChart;

$aTextData  = $this->params["aTextLang"];
?>
<script src="<?php echo base_url('application/modules/common/assets/vendor/chartjs-plugin-annotation/chartjs-plugin-annotation.min.js'); ?>"></script>
<script src="<?php //echo base_url('application/modules/common/assets/vendor/chartjs-plugin-datalabels/chartjs-plugin-datalabels.min.js');
                ?>"></script>
<div style="width:100%">
    <?php
    BarChart::create(array(
        "dataSource"    => $this->dataStore("ChartToptenBestSellerData"),
        "colorScheme"   => array("#0097BC"),
        "backgroundOpacity" => 0,
        "columns"       => array(
            "FTPdtName" => array(
                "type"  => "string",
            ),
            "FCXsdNet"  => array(
                "type"  => "number",
                "label" => $aTextData['tDSHSALXsdNet'],
                "formatValue"   => function ($cValue) {
                    return number_format($cValue, 2) . " ชิ้น";
                },
            ),
        ),
        "plugins"       => array("annotation", "datalabels"),
        "options"       => array(
            "legend"    => array("position" => "none"),
            "isStacked"     => true,
            "orientation"   => "horizontal",
            "plugins"       => array(
                "annotation"    => array(
                    "drawTime"      => "afterDatasetsDraw",
                    "dblClickSpeed" => 350,
                ),
                "datalabels"    => array(
                    "color"     => "#FFFFFF",
                    "align"     => "center",
                    "font"      => array("size" => 12),
                )
            )
        ),
    ));
    ?>
</div>