<?php
    use \koolreport\widgets\koolphp\Table;
    $nCurrentPage   = $this->params['nCurrentPage'];
    $nAllPage       = $this->params['nAllPage'];
    $aDataTextRef   = $this->params['aDataTextRef'];
    $tLabelTax      = $aDataTextRef['tRptTaxNo'].' : '.$this->params['tBchTaxNo'];
    $tLabeDataPrint = $aDataTextRef['tRptDatePrint'].' : '.date('Y-m-d');
    $tLabeTimePrint = $aDataTextRef['tRptTimePrint'].' : '.date('H:i:s');
    $tBtnPrint      = $aDataTextRef['tRptPrintHtml'];
    $tCompAndBranch = $this->params['tCompName'].' ( '.$this->params['tBchName'].' )';
    $tAddressLine   = "-";
    $aDataSumReport = $this->params['aDataSumReport'];
    $aFilterReport  = $this->params['aFilterReport'];
?>
<style>
    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }
</style>
<div id="odvRptSaleVatInvoiceByBillHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-left">
                        <label class="xCNRptLabel"><?php echo $tCompAndBranch; ?></label>
                    </div>
                    <div class="text-left">
                        <label class="xCNRptLabel"><?php echo $tAddressLine; ?></label>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                    </div> 
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8">
                    <!-- Filter Branch Code -->
                    <?php if(!empty($aFilterReport['tBchCodeFrom']) && !empty($aFilterReport['tBchCodeTo'])):?>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo $aDataTextRef['tRptBchFrom'].' : '.$aFilterReport['tBchNameFrom'].' '.$aDataTextRef['tRptBchTo'].' : '.$aFilterReport['tBchNameTo'];?>
                            </label>
                        </div>
                    <?php endif;?>
                    <!-- Filter Doc Date -->
                    <?php if(!empty($aFilterReport['tDocDateFrom']) && !empty($aFilterReport['tDocDateTo'])):?>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo $aDataTextRef['tRptDateFrom'].' : '.$aFilterReport['tDocDateFrom'].' '.$aDataTextRef['tRptDateTo'].' : '.$aFilterReport['tDocDateTo'];?>
                            </label>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $tLabelTax.' '.$tLabeDataPrint.' '.$tLabeTimePrint ?></label>
                    </div>
                </div>
            </div> 
        </div>
        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php
                    // Check Page Footer Show Total Sum
                    if($nCurrentPage == $nAllPage){
                        $oOptionKoolRpt = array(
                            "dataSource"        => $this->dataStore("RptSaleVatInvoiceByBill"),
                            "cssClass"          => array(
                                "table"         => "table",
                                "tf"            => "xCNFooterRpt"
                            ),
                            "showFooter"        => true,
                            "columns"           => array(
                                "FTBchCode"             => array(
                                    "label"     => $aDataTextRef['tRptBarchCode'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTBchName"             => array(
                                    "label"     => $aDataTextRef['tRptBarchName'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FDXshDocDate"          => array(
                                    "label"         => $aDataTextRef['tRptDate'],
                                    "formatValue"   => function($tValue, $aData) {
                                        $aExplodeDocDate    = explode(";",$tValue);
                                        return $aExplodeDocDate[1];
                                    },
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTXshDocVatFull"       => array(
                                    "label"         => $aDataTextRef['tRptBillNo'],
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTXshDocNo"            => array(
                                    "label"         => $aDataTextRef['tRptXshDocNo'],
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTCstName"             => array(
                                    "label"         => $aDataTextRef['tRptCst'],
                                    "formatValue"   => function($tValue, $aData) use($aDataTextRef){
                                        if(isset($tValue) && !empty($tValue)){
                                            return $tValue;
                                        }else{
                                            return $aDataTextRef['tRptCstGeneral'];
                                        }
                                    },  
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:center"
                                    )
                                ),
                                "FTCstTaxNo"            => array(
                                    "label"         => $aDataTextRef['tRptCstTaxNo'],
                                    "formatValue"   => function($tValue, $aData) use($aDataTextRef){
                                        if(isset($tValue) && !empty($tValue)){
                                            return $tValue;
                                        }else{
                                            return "-";
                                        }
                                    },
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:center"
                                    )
                                ),
                                "FTCstBusiness"         => array(
                                    "label"         => $aDataTextRef['tRptCstBussiness'],
                                    "formatValue"   => function($tValue, $aData) use($aDataTextRef){
                                        if(isset($tValue) && !empty($tValue)){
                                            return $tValue;
                                        }else{
                                            return "-";
                                        }
                                    },
                                    "cssStyle"      => array(
                                        "th"        => "text-align:center;white-space:nowrap",
                                        "td"        => "text-align:center"
                                    )
                                ),
                                "FCXshValue"            => array(
                                    "label"         => $aDataTextRef['tRptValue'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footerText"    => number_format($aDataSumReport['FCXshSumValue'],2),
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                ),
                                "FCXshVat"              => array(
                                    "label"         => $aDataTextRef['tRptVat'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footerText"    => number_format($aDataSumReport['FCXshSumVat'],2),
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                ),
                                "FCXshTotalAfDisChgNV"  => array(
                                    "label"         => $aDataTextRef['tRptDisChgNotVat'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footerText"    => number_format($aDataSumReport['FCXshSumTotalAfDisChgNV'],2),
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                ),
                                "FCXshGrand"            => array(
                                    "label"         => $aDataTextRef['tRptGrandSale'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footerText"    => number_format($aDataSumReport['FCXshSumGrand'],2),
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                )
                            ),
                            "removeDuplicate"   => array("FTBchCode","FTBchName","FTPosCode")
                        );
                    }else{
                        $oOptionKoolRpt = array(
                            "dataSource"        => $this->dataStore("RptSaleVatInvoiceByBill"),
                            "cssClass"          => array(
                                "table"         => "table table-bordered",
                            ),
                            "columns"           => array(
                                "FTBchCode"             => array(
                                    "label"     => $aDataTextRef['tRptBarchCode'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTBchName"             => array(
                                    "label"     => $aDataTextRef['tRptBarchName'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FDXshDocDate"          => array(
                                    "label"         => $aDataTextRef['tRptDate'],
                                    "formatValue"   => function($tValue, $aData) {
                                        $aExplodeDocDate    = explode(";",$tValue);
                                        return $aExplodeDocDate[1];
                                    },
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTXshDocVatFull"       => array(
                                    "label"         => $aDataTextRef['tRptBillNo'],
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTXshDocNo"            => array(
                                    "label"         => $aDataTextRef['tRptXshDocNo'],
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:left"
                                    )
                                ),
                                "FTCstName"             => array(
                                    "label"         => $aDataTextRef['tRptCst'],
                                    "formatValue"   => function($tValue, $aData) use($aDataTextRef){
                                        if(isset($tValue) && !empty($tValue)){
                                            return $tValue;
                                        }else{
                                            return $aDataTextRef['tRptCstGeneral'];
                                        }
                                    },  
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:center"
                                    )
                                ),
                                "FTCstTaxNo"            => array(
                                    "label"         => $aDataTextRef['tRptCstTaxNo'],
                                    "formatValue"   => function($tValue, $aData) use($aDataTextRef){
                                        if(isset($tValue) && !empty($tValue)){
                                            return $tValue;
                                        }else{
                                            return "-";
                                        }
                                    },
                                    "cssStyle"      => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:center"
                                    )
                                ),
                                "FTCstBusiness"         => array(
                                    "label"         => $aDataTextRef['tRptCstBussiness'],
                                    "formatValue"   => function($tValue, $aData) use($aDataTextRef){
                                        if(isset($tValue) && !empty($tValue)){
                                            return $tValue;
                                        }else{
                                            return "-";
                                        }
                                    },
                                    "cssStyle"      => array(
                                        "th"        => "text-align:center;white-space:nowrap",
                                        "td"        => "text-align:center"
                                    )
                                ),
                                "FCXshValue"            => array(
                                    "label"     => $aDataTextRef['tRptValue'],
                                    "type"      => "number",
                                    "decimals"  => 2,
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right"
                                    )
                                ),
                                "FCXshVat"              => array(
                                    "label"     => $aDataTextRef['tRptVat'],
                                    "type"      => "number",
                                    "decimals"  => 2,
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                ),
                                "FCXshTotalAfDisChgNV"  => array(
                                    "label"     => $aDataTextRef['tRptDisChgNotVat'],
                                    "type"      => "number",
                                    "decimals"  => 2,
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                ),
                                "FCXshGrand"            => array(
                                    "label"     => $aDataTextRef['tRptGrandSale'],
                                    "type"      => "number",
                                    "decimals"  => 2,
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center;white-space:nowrap",
                                        "td"    => "text-align:right",
                                        "tf"    => "text-align:right"
                                    )
                                )
                            ),
                            "removeDuplicate"   => array("FTBchCode","FTBchName","FTPosCode")
                        );
                    }
                    
                    // Create Table Kool Report
                    Table::create($oOptionKoolRpt);
                ?>
            </div>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                    <label class="xCNRptLabel"><?php echo $nCurrentPage.' / '.$nAllPage; ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>