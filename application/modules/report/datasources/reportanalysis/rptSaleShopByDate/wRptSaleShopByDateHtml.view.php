<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
$aSumDataReport = $this->params['aDataReturn']['aDataSumFooterReport'];
?>

<style>
    .xCNFooterRpt {
        border-bottom: 7px double #ddd;
    }

    .table thead th,
    .table>thead>tr>th,
    .table tbody tr,
    .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td,
    .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody:last-child>tr:last-child>td.xCNRptSumFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table tbody tr.xCNHeaderGroup,
    .table>tbody>tr.xCNHeaderGroup>td {
        font-size: 18px !important;
        font-weight: 600;
    }

    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }

    /*แนวนอน*/
    @media print{@page {size: landscape}} 
</style>

<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
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
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShopNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShopNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้าง report ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
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
                        $bShowFooter = false;
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                            $bShowFooter = true;
                        } 
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptSaleShopByDate"),
                            "cssClass" => array(
                                "table" => "",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf" => "xCNRptSumFooter"
                            ),
                            "showFooter" => $bShowFooter,
                            "headers" => array(
                                array(
                                    "$aDataTextRef[tRPA1TBBarchCode]" => array(
                                        "class"         => "xCNRptColumnHeader",
                                        "style"         => "text-align:left",
                                        "rowSpan"       => 2,
                                    ),
                                    "$aDataTextRef[tRPA1TBBarchName]" => array(
                                        "class"         => "xCNRptColumnHeader",
                                        "style"         => "text-align:left",
                                        "rowSpan"       => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBDocDate]" => array(
                                        "class"         => "xCNRptColumnHeader",
                                        "style"         => "text-align:center",
                                        "rowSpan"       => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBShopCode]" => array(
                                        "class"         => "xCNRptColumnHeader",
                                        "style"         => "text-align:left",
                                        "rowSpan"       => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBShopName]" => array(
                                        "class"         => "xCNRptColumnHeader",
                                        "style"         => "text-align:left",
                                        "rowSpan"       => 2
                                    ),
                                    "$aDataTextRef[tRPA1TBAmount]" => array(
                                        "class"         => "xCNRptColumnHeader",
                                        "style"         => "text-align:center",
                                        "colSpan"        => 3
                                    ),
                                )
                            ),
                            "columns" => array(
                                'rtBchCode' => array(
                                    "footerText" => $bShowFooter ? $aDataTextRef['tRPA1TBTotalAllSale'] : '',
                                    "cssStyle"=>array(
                                        "th" => "display:none",
                                        "tf" => "text-align:left"
                                    ),
                                ),
                                'rtBchName' => array(
                                    "cssStyle" => array(
                                        "th" => "display:none",
                                    ),
                                ),
                                'rtTxnDocDate' => array(
                                    "cssStyle"=>array(
                                        "th"    => "display:none",
                                        "td"    => "text-align:center"
                                    ),
                                    "formatValue" => function($tValue,$aRow){
                                        return empty($tValue) ? '' : date("d/m/Y", strtotime($tValue));
                                    },
                                ),
                                'rtShpCode' => array(
                                    "cssStyle"=>array(
                                        "th" => "display:none",
                                    ),
                                ),
                                'rtShpName' => array(
                                    "cssStyle" => array(
                                        "th" => "display:none"
                                    ),
                                ),
                                'rcFCTxnSale' => array(
                                    "label"         => $aDataTextRef['tRPA1TBSale'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format($aSumDataReport[0]['rcFCTxnSale'], 2) : '',
                                    "cssStyle"      => array("th" => "text-align:right;border-bottom: 1px solid black !important;", "td" => "text-align:right" , "tf" => "text-align:right"),
                                ),
                                'rcFCTxnRefund' => array(
                                    "label"         => $aDataTextRef['tRPA1TBCancelSale'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format($aSumDataReport[0]['rcFCTxnRefund'], 2) : '',
                                    "cssStyle"      => array("th" => "text-align:right;border-bottom: 1px solid black !important;", "td" => "text-align:right" , "tf" => "text-align:right"),
                                ),
                                'rcFCTxnValue' => array(
                                    "label"         => $aDataTextRef['tRPA1TBTotalSale'],
                                    "type"          => "number",
                                    "decimals"      => 2,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format($aSumDataReport[0]['rcFCTxnValue'], 2) : '',
                                    "cssStyle"      => array("th" => "text-align:right;border-bottom: 1px solid black !important;", "td" => "text-align:right" , "tf" => "text-align:right"),
                                )
                            ),
                            "removeDuplicate" => array("rtBchCode","rtBchName","rtTxnDocDate")
                        ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th style="text-align:center" class="xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPA1TBBarchCode']; ?></th>
                                <th style="text-align:center" class="xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPA1TBBarchName']; ?></th>
                                <th style="text-align:center" class="xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPA1TBDocDate']; ?></th>
                                <th style="text-align:center" class="xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPA1TBShopCode']; ?></th>
                                <th style="text-align:center" class="xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPA1TBShopName']; ?></th>
                                <th style="text-align:center" class="xCNRptColumnHeader" colspan="3"><?php echo $aDataTextRef['tRPA1TBAmount']; ?></th>
                            </tr>
                            <tr>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="display:none" class="xCNReportTBHeard"></th>
                                <th style="text-align:right" class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPA1TBSale']; ?></th>
                                <th style="text-align:right" class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPA1TBCancelSale']; ?></th>
                                <th style="text-align:right" class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPA1TBTotalSale']; ?></th>			
                            </tr>
		                </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>

             <!-- ============================ ฟิวเตอร์ข้อมูล ============================ -->
             <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo $aDataFilter['tBchName']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
            <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo $aDataFilter['tShpNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

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
    $(document).ready(function() {
        var oFilterLabel = $('.report-filter .text-left label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function(index) {
            var nLabelWidth = $(this).outerWidth();
            if (nLabelWidth > nMaxWidth) {
                nMaxWidth = nLabelWidth;
            }
        });
        $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
    });
</script>

<script>
    $(document).ready(function(){
        var tFoot = $('tfoot').html();
        $('tfoot').remove();
        $('tbody').append(tFoot);
    });
</script>