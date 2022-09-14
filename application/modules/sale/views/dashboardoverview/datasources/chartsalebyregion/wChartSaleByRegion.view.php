<?php 
    use \koolreport\widgets\google\DonutChart;

    // print_r($this->nChartWidth);
    // print_r($this->nChartHeight);
    // exit;

    DonutChart::create(array(
        "dataSource"        => $this->dataStore("ChartSaleByRegionData"),
        "colorScheme"       => $this->aChartColor,
        "backgroundOpacity" => 0,
        "width"             => $this->nChartWidth."px",
        "height"            => $this->nChartHeight."px", 
        "columns"           => array(
            "tTitle"        => array("type" => "string"),
            "cValue"        => array(
                "type"      => "float",
                "decimal"   => FCNxHGetOptionDecimalShow(),
                // "prefix"    => "$",
            ),
        ),
        "NumberFormat"  => 2,
        "options" => array(
            'chartArea'                 => array('width' => '95%', 'height' => '95%'),
            "legend"                    => array("position" => "right","alignment" => "center"),
            "tooltip"                   => array("trigger" => "selection"),
            "sliceVisibilityThreshold"  => 0.0001,
            // "pieSliceText" => 'value',
            // "pieSliceText" => 'none'
            // "responsive"    => true,
            // "isStacked"     => true,
            // "forceIFrame"   => true
        ),
    ));
?>
