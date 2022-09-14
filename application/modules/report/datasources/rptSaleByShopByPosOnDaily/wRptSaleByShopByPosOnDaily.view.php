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
    $aFilterReport  = $this->params['aFilterReport'];
?>
<div id="odvRptSaleShopByDateHtml">
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

                    <!-- Filter Shop Code -->
                    <?php if(!empty($aFilterReport['tShopCodeFrom']) && !empty($aFilterReport['tShopCodeTo'])):?>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo $aDataTextRef['tRptShopFrom'].' : '.$aFilterReport['tShopNameFrom'].' '.$aDataTextRef['tRptShopTo'].' : '.$aFilterReport['tShopNameTo'];?>
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
                    Table::create(array(
                        "dataSource"    => $this->dataStore("RptSaleByShopByPosOnDaily"),
                        "cssClass"      => array(
                            "table" => "table table-bordered",
                        ),
                        "headers"       => array(
                            array(
                                "$aDataTextRef[tRptBarchCode]"  => array(
                                    "style"     => "text-align:center",
                                    "rowSpan"   => 2
                                ),
                                "$aDataTextRef[tRptBarchName]"  =>  array(
                                    "style"     => "text-align:center",
                                    "rowSpan"   => 2
                                ),
                                "$aDataTextRef[tRptDocDate]"    =>  array(
                                    "style"     => "text-align:center",
                                    "rowSpan"   => 2
                                ),
                                "$aDataTextRef[tRptShopCode]"   =>  array(
                                    "style"     => "text-align:center",
                                    "rowSpan"   => 2
                                ),
                                "$aDataTextRef[tRptShopName]"   =>  array(
                                    "style"     => "text-align:center",
                                    "rowSpan"   => 2
                                ),
                                "$aDataTextRef[tRptAmount]"     =>  array(
                                    "style"  => "text-align:center",
                                    "colSpan"   => 3
                                ),
                            )
                        ),
                        "columns"       => array(
                            'rtBchCode'     => array(
                                "cssStyle"  => array(
                                    "th"    =>  "display:none",
                                ),
                            ),
                            'rtBchName'     => array(
                                "cssStyle"  => array(
                                    "th"    =>  "display:none",
                                ),
                            ),
                            'rtXshDocDate'  => array(
                                "cssStyle"  => array(
                                    "th"    =>  "display:none",
                                ),
                            ),
                            'rtShpCode'     => array(
                                "cssStyle"  => array(
                                    "th"    =>  "display:none",
                                ),
                            ),
                            'rtShpName'     => array(
                                "cssStyle"  => array(
                                    "th"    =>  "display:none"
                                ),
                            ),
                            'rcTxnSaleVal'  => array(
                                "label"         => $aDataTextRef['tRptSale'],
                                "type"          => "number",
                                "decimals"      => 2,
                                "footer"        =>"sum",
                                "footerText"    =>"@value",
                                "cssStyle"      => "text-align:right",
                            ),
                            'rcTxnCancelSaleVal'    => array(
                                "label"         => $aDataTextRef['tRptCancelSale'],
                                "type"          => "number",
                                "decimals"      => 2,
                                "footer"        =>"sum",
                                "footerText"    =>"@value",
                                "cssStyle"      => "text-align:right",
                            ),
                            'rcTotalSale'           => array(
                                "label"         => $aDataTextRef['tRptTotalSale'],
                                "type"          => "number",
                                "decimals"      => 2,
                                "footer"        =>"sum",
                                "footerText"    =>"@value",
                                "cssStyle"      => "text-align:right",
                            ),
                        )
                    ));
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


