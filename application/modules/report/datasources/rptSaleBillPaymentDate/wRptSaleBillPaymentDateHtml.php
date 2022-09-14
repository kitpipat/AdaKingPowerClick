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
        border-bottom: 0px transparent !important;
    }

    .table>thead:first-child>tr:last-child>td,
    .table>thead:first-child>tr:last-child>th {
        border-bottom: 1px solid black !important;
    }


    /*แนวนอน*/
    /* @media print{@page {size: landscape}} */
    /*แนวตั้ง*/
    @media print {
        @page {
            size: portrait
        }
    }
</style>


<div id="odvRptProductTransferHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>

                    <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo date('d/m/Y', strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo date('d/m/Y', strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center">
                                        <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] ?> : </label> <label><?= $aDataFilter['tBchNameFrom']; ?></label>&nbsp;
                                        <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] ?> : </label> <label><?= $aDataFilter['tBchNameTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                        <div class="text-right">
                            <?php date_default_timezone_set('Asia/Bangkok'); ?>
                            <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSBPDate'] ?></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSBPTypePayment'] ?></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSBPTime'] ?></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSBPBillNo'] ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSBPPrice'] ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) {  ?>

                                <?php
                                $tRptGtpBchCode = "";
                                $tRptGtpShpCode = "";
                                $tRptGtpWahCode = "";
                                $tRptGtpDocNo   = "";

                                $nCountBchCode  = 0;
                                $nCountShpCode  = 0;
                                $nCountWahCode  = 0;
                                $nCountDocNo    = 0;
                                $nSum =0;
                                ?>

                                <?php
                                    $tFDXrcRefDate = "";
                                    $tFTRcvName = "";

                                if ($aValue['PartFDXrcRefDate'] == 1) {
                                    $aGrouppingDataBch  = array($aValue['FDXrcRefDate']);
                                    for ($i = 0; $i < FCNnHSizeOf($aGrouppingDataBch); $i++) {
                                        if (strval($aGrouppingDataBch[$i]) != "N") {
                                            $tFDXrcRefDate = date('d/m/Y',strtotime($aGrouppingDataBch[$i]));
                                        } else {
                                            $tFDXrcRefDate = "";
                                        }
                                    }
                                }


                                if ($aValue['PartFTRcvName'] == 1) {
                                    $aGrouppingDataBch  = array($aValue['FTRcvName']);
                                    for ($i = 0; $i < FCNnHSizeOf($aGrouppingDataBch); $i++) {
                                        // echo $i++ . '   ' . FCNnHSizeOf($aGrouppingDataBch);
                                        if (strval($aGrouppingDataBch[$i]) != "N") {
                                            $tFTRcvName = $aGrouppingDataBch[$i];
                                        } else {
                                            $tFTRcvName = "";
                                        }
                                    }
                                }else {
                                  $tFTRcvName = "";
                                }

                                ?>
                                <tr class="xWRptProductFillData">
                                    <td class="text-left xCNRptGrouPing"><?php echo $tFDXrcRefDate; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $tFTRcvName; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue["FDXrcRefTime"]; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue["FTXshDocNo"]; ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcNet"], $nOptDecimalShow); ?></td>
                                </tr>

                                <?php
                                // $nSum += $aValue["FCXrcNet"];
                                // if ($aValue['PartFTRcvName'] == $aValue['PartFTRcvNameMAX']) {
                                //     echo "<tr>";
                                //     echo "
                                //         <tr class='xWRptProductFillData'>
                                //         <td class='text-left xCNRptDetail'></td>
                                //         <td class='text-left xCNRptDetail'></td>
                                //         <td class='text-left xCNRptDetail'></td>
                                //         <td class='text-left xCNRptDetail'></td>
                                //         <td class='text-right xCNRptDetail' style='border-bottom: dashed 1px #333 !important;'>" . number_format($aValue["FCXrcNet_SubTotal"], 2) . "</td>
                                //         </tr>";
                                //     echo "<tr>";
                                // }

                                ?>

                                <?php
                                if ($aValue['PartFDXrcRefDate'] == $aValue['PartFDXrcRefDateMAX']) {
                                    echo "<tr>";
                                    echo "
                                        <tr class='xWRptProductFillData' style=' border-bottom: dashed 1px #333 !important;'>
                                            <td class='text-left xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'>" .  date('d/m/Y',strtotime($aValue['FDXrcRefDate'])) . "</td>
                                            <td class='text-left xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'></td>
                                            <td class='text-left xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'>" . $aDataTextRef['tRptSBPTotal'] . "</td>
                                            <td class='text-left xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'></td>
                                            <td class='text-right xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'>" . number_format($aValue["FCXrcNet_SubTotalDate"], $nOptDecimalShow) . "</td>
                                        </tr>";
                                    echo "<tr>";
                                    echo "<tr>";
                                    echo "
                                        <tr class='xWRptProductFillData'>
                                        <td class='text-left xCNRptDetail'></td>
                                        <td class='text-left xCNRptDetail'></td>
                                        <td class='text-left xCNRptDetail'></td>
                                        <td class='text-left xCNRptDetail'></td>
                                        <td class='text-center xCNRptDetail'></td>
                                        </tr>";
                                    echo "<tr>";
                                }

                                ?>


                            <?php  } ?>

                            <?php

                            // Step 5 เตรียม Parameter สำหรับ SumFooter
                            $nFCXrcNet_Footer = number_format($aValue["FCXrcNet_Footer"], $nOptDecimalShow);
                            $aFooterSumData = array($aDataTextRef['tRPCTBFooterSumAll'], 'N', 'N', 'N', $nFCXrcNet_Footer);

                            $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];

                            if ($nPageNo == $nTotalPage) {
                                echo "<tr class='xCNTrFooter'>";
                                for ($i = 0; $i < FCNnHSizeOf($aFooterSumData); $i++) {
                                    if ($aFooterSumData[$i] != 'N') {
                                        $tFooterVal = $aFooterSumData[$i];
                                    } else {
                                        $tFooterVal = '';
                                    }
                                    if ($i == 0) {
                                        echo "<td class='xCNRptSumFooter text-left' Style='border-top: 0px solid black !important;border-bottom: 1px solid black !important;'>" . $tFooterVal . "</td>";
                                    } else {
                                        echo "<td class='xCNRptSumFooter text-right' Style='border-top: 0px solid black !important;border-bottom: 1px solid black !important;'>" . $tFooterVal . "</td>";
                                    }
                                }
                                echo "<tr>";
                            }


                            ?>
                        <?php } else { ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if ((isset($aDataFilter['tWahNameFrom']) && !empty($aDataFilter['tWahNameFrom'])) && (isset($aDataFilter['tWahNameTo']) && !empty($aDataFilter['tWahNameTo']))
                || (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))
                || (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                || (isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))
                || (isset($aDataFilter['tBchCodeSelect']))
                || (isset($aDataFilter['tMerCodeSelect']))
                || (isset($aDataFilter['tShpCodeSelect']))
                || (isset($aDataFilter['tPosCodeSelect']))
                || (isset($aDataFilter['tWahCodeSelect']))
            ) { ?>
                <div class="xCNRptFilterTitle">
                    <div class="text-left">
                        <label class="xCNTextConsOth"><?= $aDataTextRef['tRptConditionInReport']; ?></label>
                    </div>
                </div>
            <?php }; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'] . ' : </span>' . $aDataFilter['tMerNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'] . ' : </span>' . $aDataFilter['tMerNameTo']; ?></label>
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

            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom'] . ' : </span>' . $aDataFilter['tWahNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahTo'] . ' : </span>' . $aDataFilter['tWahNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tWahCodeSelect']) && !empty($aDataFilter['tWahCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom']; ?> : </span> <?php echo ($aDataFilter['bWahStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tWahNameSelect']; ?></label>
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
