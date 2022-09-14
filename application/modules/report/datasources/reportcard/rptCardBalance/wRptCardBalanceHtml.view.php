<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];

$bIsLastPage = ($nAllPage == $nCurrentPage);
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

    @media print{@page {size: landscape}}
</style>

<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) {?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
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
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') {?>
                    <?php
                        $bShowFooter = false;
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                            $bShowFooter = true;
                        }
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptCardBalance"),
                            "showFooter" => $bShowFooter,
                            "cssClass" => array(
                                "table" => "",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf" => "xCNRptSumFooter"
                            ),
                            "headers" => array(
                                array(
                                    "$aDataTextRef[tRPC8TBCardStatus]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center;vertical-align: middle;",
                                        "rowSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardBalance]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardInputOutputUpdate]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardSale]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardReturn]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardSpending]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                    "$aDataTextRef[tRPC8TBCardExpValue]" => array(
                                        "class" => "xCNRptColumnHeader",
                                        "style" => "text-align:center",
                                        "colSpan" => 2
                                    ),
                                )
                            ),
                            "columns" => array(
                                'FTCrdStaActiveText' => array(
                                    "label" => $aDataTextRef['tRPC8TBCardStatus'],
                                    /*"formatValue"   => function($tValue, $aData) use ($aDataTextRef){
                                        if($tValue == 1 || $tValue == 2 || $tValue == 3){
                                            return $aDataTextRef['tRPC8TBCardCheckStaActive'.$tValue];
                                        }else{
                                            return $aDataTextRef['tReportInvalidSta'];
                                        }
                                    },*/
                                    "footerText" => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '',
                                    "cssStyle" => array(
                                        "th" => "display:none",
                                    )
                                ),
                                'FNCrdBalanceQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FCCrdBalanceValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdInOutAdjQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FCCrdInOutAdjValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdSaleQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FCCrdSaleValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdRetQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdRetValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),'FNCrdSpendQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FCCrdSpendValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FNCrdExpireQty' => array(
                                    "label" => $aDataTextRef['tRPC8TBQty'],
                                    "type" => "number",
                                    "decimals" => 0,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FCCrdExpireValue' => array(
                                    "label" => $aDataTextRef['tRPC8TBValue'],
                                    "type" => "number",
                                    "decimals" => 2,
                                    "footer" => $bShowFooter ? 'sum' : '',
                                    "footerText" => $bShowFooter ? '@value' : '',
                                    "cssStyle"  => array(
                                        "tf"    => "text-align:right",
                                        "th"    => "text-align:right;border-bottom: 1px solid black !important;",
                                        "td"    => "text-align:right"
                                    ),
                                )
                            )
                        ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                    <thead>
						<tr>
                            <th class="text-center xCNRptColumnHeader" rowspan="2"><?php echo $aDataTextRef['tRPC8TBCardStatus']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardBalance']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardInputOutputUpdate']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardSale']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardReturn']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardSpending']; ?></th>
                            <th class="text-center xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRPC8TBCardExpValue']; ?></th>
                        </tr>
						<tr>
                            <th style="display:none" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBQty']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC8TBValue']; ?></th>
                        </tr>
		            </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>

                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>


                    <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                    <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="xCNRptFilter">
                                <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                                <br>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                    <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="xCNRptFilter">
                                <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                            </div>
                        </div>
                    <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
                <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if ((isset($aDataFilter['tStaCardFrom']) && !empty($aDataFilter['tStaCardFrom'])) && (isset($aDataFilter['tStaCardTo']) && !empty($aDataFilter['tStaCardTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล สถานะบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataFilter['tCrdStaNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataFilter['tCrdStaNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

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
        var tFoot = $('tfoot').html();
        $('tfoot').remove();
        $('tbody').append(tFoot);
    });
</script>
