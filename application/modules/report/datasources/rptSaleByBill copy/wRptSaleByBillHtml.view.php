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
    /*แนวนอน*/
    /* @media print{@page {size: landscape}} */ 
    /*แนวตั้ง*/
    @media print{@page {size: portrait}}
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
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tShpNameFrom']) && !empty($aDataFilter['tShpNameFrom'])) && (isset($aDataFilter['tShpNameTo']) && !empty($aDataFilter['tShpNameTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShpNameFrom']; ?></label>
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShpNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom']; ?></label>
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
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
                        "dataSource" => $this->dataStore("rRptSaleByBill"),
                        "cssClass" => array(
                            "table" => "table",
                            "tf" => "xCNRptLabel"
                        ),
                        "showFooter" => $bIsLastPage ? true : false,
                        "headers" => array(
                            array(
                                $aDataTextRef['tRptDocBill'] => array(
                                    "style" => "text-align:left",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptDate'] => array(
                                    "style" => "text-align:left",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptSales'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptDisChg'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptTax'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                                $aDataTextRef['tRptGrand'] => array(
                                    "style" => "text-align:right",
                                    "rowSpan" => 1
                                ),
                            )
                        ),
                        "columns" => array(
                            'rtDocNo' => array(
                                "footerText" => $bIsLastPage ? $aDataTextRef['tRptOverall'] : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:left",
                                    "tf" => $bIsLastPage ? "text-align:left" : "display:none"
                                ),
                            ),
                            'rtDocDate' => array(
                                "formatValue" => function($value, $row) {
                                    return date("Y-m-d H:i:s", strtotime($value));
                                },
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:left",
                                    "tf" => $bIsLastPage ? "text-align:left" : "display:none"
                                ),
                            ),
                            'rtAmtNV' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXshAmtNV_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtshDis' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXshDis_SumFooter'], $nOptDecimalShow) : "",
                                "cssStyle" => array(
                                    "th" => "display:none",
                                    "td" => "text-align:right",
                                    "tf" => $bIsLastPage ? "text-align:right" : "display:none"
                                ),
                            ),
                            'rtshVat' => array(
                                "type" => "number",
                                "decimals" => $nOptDecimalShow,
                                "footerText" => $bIsLastPage ? number_format($aDataSumFoot['FCXshVat_SumFooter'], $nOptDecimalShow) : "",
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
                            )
                        ),
                    ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptDocBill']; ?></th>    
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptDate']; ?></th>    
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptSales']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptDisChg']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptTax']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptGrand']; ?></th>
                        </thead>
                        <tbody>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td></tr>
                        </tbody>
                    </table>
                <?php }; ?>
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
















































