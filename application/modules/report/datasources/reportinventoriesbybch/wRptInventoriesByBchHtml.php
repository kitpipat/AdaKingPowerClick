<?php
$aDataReport    = $aDataViewRpt['aDataReport'];
$aDataTextRef   = $aDataViewRpt['aDataTextRef'];
$aDataFilter    = $aDataViewRpt['aDataFilter'];
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

        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrFooter {
        /* background-color: #CFE2F3 !important; */
        /* border-bottom : 6px double black !important; */
        /* border-top: dashed 1px #333 !important; */
        border-top: 1px solid black !important;
        border-: 1px solid black !important;
    }

    .table tbody tr.xCNHeaderGroup,
    .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }

    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }

    /*แนวนอน*/
    @media print {
        @page {
            size: A4 landscape;
            /* margin: 5mm 5mm 5mm 5mm; */
            /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
        }
    }

    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>
<div id="odvRptPdtPointWahHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> </span> <?php echo date("d/m/Y", strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> </span> <?php echo date("d/m/Y", strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) { ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahFrom']; ?> </span> <?php echo $aDataFilter['tWahNameFrom']; ?></label>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahTo']; ?> </span> <?php echo $aDataFilter['tWahNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 "></div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div class="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <!-- <th nowrap class="text-left xCNRptColumnHeader" style="width:20%"><?php echo $aDataTextRef['tRptWahName']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:30%"><?php echo $aDataTextRef['tRptProduct']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptQtyWah']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptPointPurchase']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptShouldOrder']; ?></th>   -->

                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptPdtCode']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:20%"><?php echo $aDataTextRef['tRptPdtName']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptOpenSysAdminBchCode']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:20%"><?php echo $aDataTextRef['tRptOpenSysAdminBchName']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptAdjStkVDWahB4Adj']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptInventoriesByBchPrice']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptInventoriesByBchPriceTotal']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                // Step 1 เตรียม Parameter สำหรับการ Groupping

                                $tGrouppingPdt  = "";
                                $nCountPdt      = 0;
                                $nSubBillQTYBch = 0;
                                $nSubAmountBch  = 0;
                                $nSubBillQTYShp = 0;
                                $nSubAmountShp  = 0;
                                $nSubAmountShp  = 0;
                                $nBillQTY       = 0;
                                $nAmount        = 0;
                                $nBillQTY_Footer   = 0;
                                $nGrand_Footer     = 0;


                                $tShpCode   = '';
                                $tCrdCode   = '';
                                $tBchCode   = '';
                                $tPdtCode   = '';
                                $tPdtName   = '';

                                $nRowPartID     = $aValue["FNRowPartID"];

                                $nFCStkQty = 0;
                                $nFCStkAmount = 0;

                                $nFCStkQty_SubTotal      = number_format($aValue['FCStkQty_SubTotal'], $nOptDecimalShow);
                                $nFCStkAmount_SubTotal   = number_format($aValue['FCStkAmount_SubTotal'], $nOptDecimalShow);


                                ?>


                                <?php
                                $aGrouppingDataPdt  = array($aValue['FTPdtCode'], $aValue['FTPdtName'], '', '', $nFCStkQty_SubTotal, '', $nFCStkAmount_SubTotal);
                                if ($aValue['PartIDPdt'] == 1) {
                                    echo "<tr class='xCNRptGrouPing' colspan='7' style='border-top: dashed 1px #333 !important;'>";
                                    for ($i = 0; $i < FCNnHSizeOf($aGrouppingDataPdt); $i++) {

                                        $tTextStyle = 'text-left';
                                        $tTextInden = '';
                                        $tWidth = '';

                                        if ($i == 4) {
                                            $tTextStyle = 'text-right';
                                            // $tWidth = 'width:25%';
                                        }

                                        if ($i == 6) {
                                            // $tTextInden = 'text-indent: 115px;';
                                            $tTextStyle = 'text-right';
                                        }

                                        if (strval($aGrouppingDataPdt[$i]) != "N") {
                                            echo "<td class='xCNRptGrouPing " . $tTextStyle . "' style='padding: 5px; " . $tTextInden . " " . $tWidth . " '>" . $aGrouppingDataPdt[$i] . "</td>";
                                        } else {
                                            echo "<td></td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                                ?>


                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <!-- <td class="text-center xCNRptDetail"><?php echo $aValue['FTPdtCode']; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue['FTPdtName']; ?></td> -->
                                    <td class="text-left xCNRptDetail"></td>
                                    <td class="text-left xCNRptDetail"></td>
                                    <td class="text-center xCNRptDetail"><?php echo $aValue['FTBchCode']; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue['FTBchName']; ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo  number_format($aValue["FCStkQty"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo  number_format($aValue["FCStkSetPrice"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo  number_format($aValue["FCStkAmount"], $nOptDecimalShow); ?></td>
                                </tr>

                                <?php
                                // Step 5 เตรียม Parameter สำหรับ SumFooter
                                $paFooterSumData = array($aDataTextRef['tRptCBNTotalAmount'], 'N', 'N', 'N', number_format(@$aValue['FCStkQty_Footer'], $nOptDecimalShow), 'N',  number_format(@$aValue['FCStkAmount_Footer'], $nOptDecimalShow));
                                ?>

                            <?php } ?>

                            <?php
                            // Step 6 : สั่ง Summary Footer
                            $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                            FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php } else { ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSaleNoData']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>

            <!--เเสดงหน้า-->
            <div class="xCNRptFilterTitle">
                <div class="text-right">
                    <label><?= language('report/report/report', 'tRptPage') ?> <?= $aDataReport["aPagination"]["nDisplayPage"] ?> <?= language('report/report/report', 'tRptTo') ?> <?= $aDataReport["aPagination"]["nTotalPage"] ?> </label>
                </div>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tRptMerCodeFrom']) && !empty($aDataFilter['tRptMerCodeFrom'])) && (isset($aDataFilter['tRptMerCodeTo']) && !empty($aDataFilter['tRptMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'] . ' : </span>' . $aDataFilter['tRptMerNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'] . ' : </span>' . $aDataFilter['tRptMerNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
            <?php if ((isset($aDataFilter['tRptShpCodeFrom']) && !empty($aDataFilter['tRptShpCodeFrom'])) && (isset($aDataFilter['tRptShpCodeTo']) && !empty($aDataFilter['tRptShpCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'] . ' : </span>' . $aDataFilter['tRptShpNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'] . ' : </span>' . $aDataFilter['tRptShpNameTo']; ?></label>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
            <?php if ((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'] . ' : </span>' . $aDataFilter['tPdtNameFrom']; ?></label>
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'] . ' : </span>' . $aDataFilter['tPdtNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['tRptPdtGrpCodeFrom']) && !empty($aDataFilter['tRptPdtGrpCodeFrom'])) && (isset($aDataFilter['tRptPdtGrpCodeTo']) && !empty($aDataFilter['tRptPdtGrpCodeTo']))) { ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'] . ' : </span>' . $aDataFilter['tRptPdtGrpNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'] . ' : </span>' . $aDataFilter['tRptPdtGrpNameTo']; ?></label>
                    </div>
                </div>
            <?php }; ?>


            <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahFrom'] . ' : </span>' . $aDataFilter['tWahNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahTo'] . ' : </span>' . $aDataFilter['tWahNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tWahCodeSelect']) && !empty($aDataFilter['tWahCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahFrom']; ?> : </span> <?php echo ($aDataFilter['bWahStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tWahNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
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
