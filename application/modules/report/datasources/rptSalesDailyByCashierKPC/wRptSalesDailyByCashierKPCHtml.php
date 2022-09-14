<?php
$aCompanyInfo   = $aDataViewRpt['aCompanyInfo'];
$aDataFilter    = $aDataViewRpt['aDataFilter'];
$aDataTextRef   = $aDataViewRpt['aDataTextRef'];
$aDataReport    = $aDataViewRpt['aDataReport'];
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
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr:last-child.xCNTrSubFooter {
        border-bottom: 1px dashed #333 !important;
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px dashed #333 !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 1px solid black !important;
    }

    /*แนวนอน*/
    /*@media print{@page {size: landscape}}*/
    /*แนวตั้ง*/
    @media print {
        @page {
            size: A4 portrait;
            /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */

        }

    }
</style>

<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'] ?> : </label> <label><?= date('d/m/Y', strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'] ?> : </label> <label><?= date('d/m/Y', strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] ?> : </label> <label><?= $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] ?> : </label> <label><?= $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    &nbsp;
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">

                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" colspan="2" style="width:5%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptCashier']; ?></th>
                            <!-- <th style="border-bottom: 0px !important;"></th> -->
                            <th style="border-bottom: 0px !important;" class="text-right xCNRptColumnHeader">จำนวนบิลขาย</th>
                            <th nowrap colspan='5' class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSaleType']; ?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important;">
                            <th></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:30%;"><?php echo $aDataTextRef['tRptPaymentType']; ?></th>
                            <th></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;">จำนวน</th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptSales']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptXshReturn']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptRndVal']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptXshGrand']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($aDataReport['aRptData'])) {
                            foreach ($aDataReport['aRptData'] as $aData) {
                                if ($aData['RowID'] != 1 && $aData['FTTnsType'] == '1') {
                                    $tStyleUnderLine    = "border-top: 1px dashed black !important;";
                                } else {
                                    $tStyleUnderLine    = "";
                                } ?>
                                <tr style="<?= $tStyleUnderLine; ?>">
                                    <?php if ($aData['FTTnsType'] == '1') {
                                        $tBold = 'font-weight: bold !important;';
                                    ?>
                                        <?php $tName = ($aData['FTUsrName'] == '') ? 'ไม่พบชื่อ' : $aData['FTUsrName']; ?>
                                        <td class="text-left xCNRptDetail" style="font-weight: bold !important;" colspan="2"><?php echo "(" . $aData['FTUsrCode'] . ") " . $tName; ?></td>
                                        <td class="text-right xCNRptDetail" style="font-weight: bold !important;"><?php echo number_format($aData['FNRcvUseAmt'], 0); ?></td>
                                    <?php } else {

                                    ?>
                                        <td class="text-left xCNRptDetail"></td>

                                        <?php 
                                            if ($aData['FTRcvRefNo1'] != '') { 
                                                $tBold = ''; 
                                                if( $aData['FTRcvRefType'] == '1' ){
                                                    $tPrefix = '(' . $aData['FTRcvRefNo1'] . ') ';
                                                }else{
                                                    $tPrefix = "Voucher : ";
                                                }
                                        ?>
                                            <td class="text-left xCNRptDetail">
                                                <?php echo '&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;'.$tPrefix.$aData['FTRcvRefNo2']; ?>
                                            </td>
                                        <?php } else { $tBold = 'font-weight: bold !important;'; ?>
                                            <td class="text-left xCNRptDetail" style="font-weight: bold !important;">
                                                <?php echo $aData['FTRcvName']; ?>
                                            </td>
                                        <?php } ?>



                                    <?php } ?>
                                    <?php if ($aData['FTRcvRefNo1'] != '') {
                                        $nQTY = number_format($aData['FNRcvUseAmt'], 0);
                                    } else {
                                        // $nQTY = '';
                                        if ($aData['FTStaShw'] == 1) {
                                            $nQTY = number_format($aData['FNRcvUseAmt'], 0);
                                        } else {
                                            $nQTY = '';
                                        }
                                    } ?>
                                    <td class="text-left xCNRptDetail"></td>
                                    <?php if ($aData['FTTnsType'] != '1') { ?>
                                        <td class="text-right xCNRptDetail" style="<?php echo $tBold; ?>"><?php echo $nQTY; ?></td>
                                    <?php } ?>
                                    <td class="text-right xCNRptDetail" style="<?php echo $tBold; ?>"><?php echo number_format($aData['FCXshNet'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" style="<?php echo $tBold; ?>"> <?php echo number_format($aData['FCXshReturn'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" style="<?php echo $tBold; ?>"><?php echo number_format($aData['FCXshRnd'], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" style="<?php echo $tBold; ?>"><?php echo number_format($aData['FCXshGrand'], $nOptDecimalShow); ?></td>
                                </tr>
                        <?php
                            }
                        } else {
                            echo '<td colspan="99" class="text-center xCNRptColumnFooter">' . $aDataTextRef['tRptNoData'] . '</td>';
                        }
                        ?>
                        <?php
                        $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                        $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                        if ($nPageNo == $nTotalPage) { //หน้าสุดท้ายของกระดาษ
                        ?>
                            <tr>
                                <td colspan="99" class="text-center xCNRptColumnFooter" style="border-top: 1px solid black !important;"></td>
                            </tr>
                        <?php
                        }
                        ?>
                    </tbody>
                </table>

            </div>

            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?= $aDataTextRef['tRptConditionInReport']; ?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
            <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'] . ' : </span>' . $aDataFilter['tShpNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'] . ' : </span>' . $aDataFilter['tShpNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'] . ' : </span>' . $aDataFilter['tPosCodeFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'] . ' : </span>' . $aDataFilter['tPosCodeTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล แคชเชียร์ ============================ -->
            <?php if ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierFrom'] . ' : </span>' . $aDataFilter['tCashierNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierTo'] . ' : </span>' . $aDataFilter['tCashierNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
            <?php
            if (empty($aDataFilter['tPaymentTypeFrom']) || empty($aDataFilter['tPaymentTypeTo'])) { ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTByDayType'] . ' : </span>' . $aDataTextRef['tRptPayType']; ?></label>
                    </div>
                </div>
            <?php } else { ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTByDayTypeFrom'] . ' : </span>' . $aDataTextRef['tRptPayType' . $aDataFilter['tPaymentTypeFrom']]; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTByDayTypeTo'] . ' : </span>' . $aDataTextRef['tRptPayType' . $aDataFilter['tPaymentTypeTo']]; ?></label>
                    </div>
                </div>
            <?php }
            ?>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0) : ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif; ?>
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