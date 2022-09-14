<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aDataSumFoot = $this->params['aDataSumFoot'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
?>

<style>
    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom : 6px double black !important;
    }

    .table>tfoot>tr{
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom : 6px double black !important;
    }
</style>

<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $aCompanyInfo['FTCmpName']; ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']; ?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']; ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo $aCompanyInfo['FTAddV2Desc1']; ?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo $aCompanyInfo['FTAddV2Desc2']; ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel']; ?> <?php echo $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax']; ?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName']; ?></label>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptMerFrom'] . ' ' . $aDataFilter['tMerNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptMerTo'] . ' ' . $aDataFilter['tMerNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShpNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShpNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosFrom'] . ' ' . $aDataFilter['tPosNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosTo'] . ' ' . $aDataFilter['tPosNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtCodeFrom'] . ' ' . $aDataFilter['tPdtNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtCodeTo'] . ' ' . $aDataFilter['tPdtNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeFrom'])) && (isset($aDataFilter['tPdtGrpCodeTo']) && !empty($aDataFilter['tPdtGrpCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtGrpFrom'] . ' ' . $aDataFilter['tPdtGrpNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtGrpTo'] . ' ' . $aDataFilter['tPdtGrpNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeFrom'])) && (isset($aDataFilter['tPdtTypeCodeTo']) && !empty($aDataFilter['tPdtTypeCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtTypeFrom'] . ' ' . $aDataFilter['tPdtTypeNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtTypeTo'] . ' ' . $aDataFilter['tPdtTypeNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') { ?>
                    <?php
                    $bIsLastPage = $nCurrentPage == $nAllPage;

                    Table::create(array(
                        "dataSource" => $this->dataStore("rptRptAnalysisProfitLossProductVending"),
                        "cssClass" => array(
                            "table" => "table",
                            "tf" => "xCNRptLabel"
                        ),
                        "showFooter" => $bIsLastPage ? true : false,
                        "headers" => array(
                            array(
                                $aDataTextRef['tRptPdtCode'] => array(
                                    "style" => "text-align:left",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptPdtName'] => array(
                                    "style" => "text-align:left",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptPdtGrp'] => array(
                                    "style" => "text-align:left",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptQtySale'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptCabinetCost'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptGrandSale'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptProfitloss'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptCost'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptSalesVending'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                            )
                        ),
                        "columns" => array(
                            'rtPdtCode' => array(
                                "footerText" => $bIsLastPage ? $aDataTextRef['tRptOverall'] : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:left",
                                    "tf" => $bIsLastPage ? "text-align:left" : "display:none"
                                ),
                            ),
                            'rtPdtName' => array(
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:left",
                                    "tf" => $bIsLastPage ? "text-align:left" : "display:none"
                                ),
                            ),
                            'rtChainName' => array(
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:left",
                                    "tf" => $bIsLastPage ? "text-align:left" : "display:none"
                                ),
                            ),
                            'rtSaleQty' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXsdSaleQty_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtPdtCost' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCPdtCost_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtGrand' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXshGrand_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtProfit' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXsdProfit_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtProfitPercent' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXsdProfitPercent_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtSalePercent' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXsdSalePercent_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            )
                        ),
                    ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptPdtCode']; ?></th>    
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptPdtName']; ?></th>    
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptPdtGrp']; ?></th>
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptQtySale']; ?></th>
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptCabinetCost']; ?></th>
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptGrandSale']; ?></th>
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptProfitloss']; ?></th>
                        <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptSalesVending']; ?></th>
                        </thead>
                        <tbody>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td></tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
        </div>

        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $nCurrentPage . ' / ' . $nAllPage; ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    $(document).ready(function(){
        var oFilterLabel = $('.report-filter .text-left label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function(index){
            var nLabelWidth = $(this).outerWidth();
            if(nLabelWidth > nMaxWidth){
                nMaxWidth = nLabelWidth;
            }
        });
        $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
    });
</script>













































