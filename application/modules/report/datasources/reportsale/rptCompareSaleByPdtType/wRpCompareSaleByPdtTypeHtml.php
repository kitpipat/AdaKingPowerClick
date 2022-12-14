<?php
$aDataReport = $aDataViewRpt['aDataReport'];
$aDataTextRef = $aDataViewRpt['aDataTextRef'];
$aDataFilter = $aDataViewRpt['aDataFilter'];



?>

<style>
    .xCNFooterRpt {
        border-bottom: 7px double #ddd;
    }

    .xRptCompareSaleByPdtType thead th,
    .xRptCompareSaleByPdtType>thead>tr>th,
    .xRptCompareSaleByPdtType tbody tr,
    .xRptCompareSaleByPdtType>tbody>tr>td {
        border: 0px transparent !important;
    }

    .xRptCompareSaleByPdtType>thead:first-child>tr:nth-child(1)>td,
    .xRptCompareSaleByPdtType>thead:first-child>tr:nth-child(1)>th {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .xRptCompareSaleByPdtType>thead:first-child>tr:nth-child(2)>td,
    .xRptCompareSaleByPdtType>thead:first-child>tr:nth-child(2)>th {
        border-bottom: 1px solid black !important;
    }

    .xRptCompareSaleByPdtType>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .xRptCompareSaleByPdtType>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .xRptCompareSaleByPdtType tbody tr.xCNHeaderGroup,
    .xRptCompareSaleByPdtType>tbody>tr.xCNHeaderGroup>td {
        font-size: 18px !important;
        font-weight: 600;
    }

    .xRptCompareSaleByPdtType>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .xRptCompareSaleByPdtType>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }

    .xRptCompareSaleByPdtType>tbody>tr>td.xCNRptDetail:nth-child(22),
    .xRptCompareSaleByPdtType>tbody>tr>td.xCNRptDetail:nth-child(22) {
        border-right: 1px dashed #ccc !important;
    }

    .xRptCompareSaleByPdtType>tbody>tr>td.xCNRptGrouPing:nth-child(7),
    .xRptCompareSaleByPdtType>tbody>tr>td.xCNRptGrouPing:nth-child(7) {
        border-right: 1px dashed #ccc !important;
    }

    .xRptCompareSaleByPdtType>tbody>tr.xCNTrFooter>td:nth-child(22),
    .xRptCompareSaleByPdtType>tbody>tr.xCNTrFooter>td:nth-child(22) {
        border-right: 1px dashed #ccc !important;
    }

    /*??????????????????*/
    @media print {
        @page {
            size: A4 landscape;
        }
    }




    .xWDSHSALHeadPanel {
        border-bottom: 1px solid #cfcbcb8a !important;
        padding-bottom: 0px !important;
    }

    .xWDSHSALTextNumber {
        font-size: 25px !important;
        font-weight: bold;
    }

    .xWDSHSALPanelMainRight {
        padding-bottom: 0px;
        min-height: 300px;
        overflow-x: auto;
    }

    .xWDSHSALFilter {
        cursor: pointer;
    }

    .xWOverlayLodingChart {
        position: absolute;
        min-width: 100%;
        min-height: 100%;
        width: 100%;
        background: #FFFFFF;
        z-index: 2500;
        display: none;
        top: 0%;
        margin-left: 0px;
        left: 0%;
    }

    .xCNTextDetailDB {
        font-size: 20px !important;
        font-weight: bold;
        color: black;
    }
</style>


<div id="odvRptCompareSaleByPdtType">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <?php

                        $nTypeGroupReport  = $aDataFilter['tGroupReport'];
                        if ($nTypeGroupReport == '01') {
                            $tTitle  = $aDataTextRef['tRptGrpBranch'];
                        } elseif ($nTypeGroupReport == '02') {
                            $tTitle = $aDataTextRef['tRptGrpAgency'];
                        } elseif ($nTypeGroupReport == '03') {
                            $tTitle = $aDataTextRef['tRptGrpShop'];
                        } elseif ($nTypeGroupReport == '04') {
                            $tTitle = $aDataTextRef['tRptProduct'];
                        } elseif ($nTypeGroupReport == '05') {
                            $tTitle = $aDataTextRef['tRptGrpPdtType'];
                        } elseif ($nTypeGroupReport == '06') {
                            $tTitle = $aDataTextRef['tRptGrpPdtGroup'];
                        } elseif ($nTypeGroupReport == '07') {
                            $tTitle = $aDataTextRef['tRptGrpPdtBrand'];
                        } elseif ($nTypeGroupReport == '08') {
                            $tTitle = $aDataTextRef['tRptGrpPdtModel'];
                        }
                        ?>

                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ?????????????????????????????????????????? ???????????? ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] . ' </span>' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] . ' </span>' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>


                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptSaleByCashierAndPosFilterDocDateFrom'] . ' ' . date("d/m/Y", strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    <label><?php echo $aDataTextRef['tRptSaleByCashierAndPosFilterDocDateTo'] . ' ' . date("d/m/Y", strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
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
                <table class="table xRptCompareSaleByPdtType">
                    <?php
                    $nTypeGroupReport  = $aDataFilter['tGroupReport'];

                    if ($nTypeGroupReport == '01') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptBranchCode');  //????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptBranchName');   //????????????????????????
                    } else if ($nTypeGroupReport == '02') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptAgnCode');  // ???????????????????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptAgnName');  //???????????????????????????????????????
                    } else if ($nTypeGroupReport == '03') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptShopCode');  //?????????????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptShopName');  //?????????????????????????????????
                    } else if ($nTypeGroupReport == '04') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptProductCode');  //??????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptProductName');  //??????????????????????????????
                    } else if ($nTypeGroupReport == '05') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRPtPdtTypeCode');  // ????????????????????????????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRPtPdtTypeName');  // ????????????????????????????????????????????????
                    } else if ($nTypeGroupReport == '06') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptPdtGrpCode'); //?????????????????????????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptPdtGrpName');  //?????????????????????????????????????????????
                    } else if ($nTypeGroupReport == '07') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptPdtBrandCode'); // ??????????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptPdtBrandName');  //??????????????????????????????
                    } else if ($nTypeGroupReport == '08') {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptPdtModelCode'); // ????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptPdtModelName');  //????????????????????????
                    } else {
                        $tRptTypeGrpCode    = language('report/report/report', 'tRptBranchCode');  //????????????????????????
                        $tRptTypeGrpName    = language('report/report/report', 'tRptBranchName');   //????????????????????????
                    }
                    ?>

                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" rowspan="3" style="vertical-align: middle;"><?php echo $tRptTypeGrpCode; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" rowspan="3" style="vertical-align: middle; border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $tRptTypeGrpName; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" colspan="10" style="border-right: 1px dashed #ccc !important; border-bottom: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptPdtTypeYTD']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" colspan="10" style="border-right: 1px solid #ccc !important; border-bottom: 1px solid #ccc !important;"><?php echo $aDataTextRef['tRptPdtTypeYTDVal']; ?></th>
                        </tr>

                        <tr>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" colspan="4" style="vertical-align: middle; border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptPdtTypeSaleLY']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" colspan="4" style="vertical-align: middle; border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptPdtTypeSaleTY']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" colspan="2" style="border-right: 1px dashed #ccc !important; border-bottom: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptCompareLY']; ?></th>

                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" colspan="4" style="vertical-align: middle; border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptPdtTypeSaleLY']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" colspan="4" style="vertical-align: middle; border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptPdtTypeSaleTY']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" colspan="2" style="border-right: 1px dashed #ccc !important; border-bottom: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptCompareLY']; ?></th>
                        </tr>


                        <tr>
                            <th nowrap class="text-center" style="border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptQty']; ?></th>
                            <th nowrap class="text-center" style="border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptPerCen']; ?></th>


                            <th nowrap class="text-center" style="border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptAmt']; ?></th>
                            <th nowrap class="text-center" style="border-right: 1px dashed #ccc !important; border-bottom: 1px solid #111 !important;"><?php echo $aDataTextRef['tRptPerCen']; ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php $aCoddeWhereBrowe = ''; ?>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>

                                <!--  Step 1 ???????????????????????????????????? Temp -->
                                <tr>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue["FTRptGrpCode"]; ?></td>
                                    <td class="text-left xCNRptDetail" style="border-right: 1px dashed #ccc !important;"><?php echo $aValue["FTRptGrpName"]; ?></td>

                                    <!-- Sale LY -->
                                    <td class="text-right xCNRptDetail" colspan="4" style="border-right: 1px dashed #ccc !important;"><?php echo number_format($aValue["FCRptQtyYTD_LY"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" colspan="4" style="border-right: 1px dashed #ccc !important;"><?php echo number_format($aValue["FCRptQtyYTD"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCRptQtyCmp"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" style="border-right: 1px dashed #ccc !important;"><?php echo number_format($aValue["FCRptQtyPercenCmp"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" colspan="4" style="border-right: 1px dashed #ccc !important;"><?php echo number_format($aValue["FCRptAmtYTD_LY"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" colspan="4" style="border-right: 1px dashed #ccc !important;"><?php echo number_format($aValue["FCRptAmtYTD"], $nOptDecimalShow); ?></td>

                                    <!-- Compare LY -->
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCRptAmtCmp"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail" colspan="2" style="border-right: 1px dashed #ccc !important;"><?php echo number_format($aValue["FCRptAmtPercenCmp"], $nOptDecimalShow); ?></td>
                                </tr>

                                <?php
                                $paFooterSumData = array(
                                    $aDataTextRef['tRptSaleByCashierAndPosTotalFooter'], 'N',
                                    number_format($aValue['FCRptQtyYTD_LY_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptQtyYTD_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptQtyCmp_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptQtyPercenCmp_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptAmtYTD_LY_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptAmtYTD_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptAmtCmp_Footer'], $nOptDecimalShow),
                                    number_format($aValue['FCRptAmtPercenCmp_Footer'], $nOptDecimalShow),
                                );
                                ?>

                                <?php $aCoddeWhereBrowe .= ',' . "'" . $aValue["FTRptGrpCode"] . "'";


                                ?>

                            <?php } ?>



                            <?php
                            // Summary Footer
                            $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];

                            //???????????? Sum Footer
                            if ($nPageNo == $nTotalPage) {
                                echo "<tr class='xCNTrFooter'>";
                                for ($i = 0; $i < FCNnHSizeOf($paFooterSumData); $i++) {
                                    $tColspan = "";

                                    if ($i == 2 || $i == 3 || $i == 6 || $i == 7) {
                                        $tColspan = 'colspan="4"';
                                    }
                                    if ($i == 0) {

                                        $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;font-size: 18px !important; font-weight: bold;';
                                    } else {

                                        $tStyle = 'text-align:right;border-top:1px solid #333;border-bottom:1px solid #333;font-size: 18px !important; font-weight: bold;';
                                    }
                                    if ($paFooterSumData[$i] != 'N') {
                                        $tFooterVal =   $paFooterSumData[$i];
                                    } else {
                                        $tFooterVal =   '';
                                    }

                                    echo "<td " . $tColspan . " style='$tStyle;padding: 4px;' >" . $tFooterVal . "</td>";
                                }
                                echo "<tr>";
                            }
                            ?>

                        <?php } else { ?>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptSaleByCashierAndPosNoData']; ?></td>
                            </tr>
                        <?php }; ?>
                    </tbody>
                </table>
            </div>

            <!--???????????????????????????-->
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

            <!-- ============================ ?????????????????????????????????????????? ???????????? ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ?????????????????????????????????????????? ????????????????????????????????? ============================ -->
            <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>


            <!-- ============================ ?????????????????????????????????????????? ????????????????????? ============================ -->
            <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ?????????????????????????????????????????? ?????????????????? ============================ -->
            <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>


            <!-- ============================ ?????????????????????????????????????????? ?????????????????? ============================ -->
            <?php if ($aDataFilter['tGroupReport']  == '04') : ?>
                <?php if ((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'] . ' : </span>' . $aDataFilter['tPdtNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'] . ' : </span>' . $aDataFilter['tPdtNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- ============================ ?????????????????????????????????????????? ???????????????????????????????????? ============================ -->
            <?php if ($aDataFilter['tGroupReport']  == '05') : ?>
                <?php if ((isset($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeFrom'])) && (isset($aDataFilter['tPdtTypeCodeTo']) && !empty($aDataFilter['tPdtTypeCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeFrom'] . ' : </span>' . $aDataFilter['tPdtTypeNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeTo'] . ' : </span>' . $aDataFilter['tPdtTypeNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- ============================ ?????????????????????????????????????????? ????????????????????????????????? ============================ -->
            <?php if ($aDataFilter['tGroupReport']  == '06') : ?>
                <?php if ((isset($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeFrom'])) && (isset($aDataFilter['tPdtGrpCodeTo']) && !empty($aDataFilter['tPdtGrpCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'] . ' : </span>' . $aDataFilter['tPdtGrpNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'] . ' : </span>' . $aDataFilter['tPdtGrpNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- ============================ ?????????????????????????????????????????? ?????????????????? ============================ -->
            <?php if ($aDataFilter['tGroupReport']  == '07') : ?>
                <?php if ((isset($aDataFilter['tPdtBrandCodeFrom']) && !empty($aDataFilter['tPdtBrandCodeFrom'])) && (isset($aDataFilter['tPdtBrandCodeTo']) && !empty($aDataFilter['tPdtBrandCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBrandFrom'] . ' : </span>' . $aDataFilter['tPdtBrandNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBrandTo'] . ' : </span>' . $aDataFilter['tPdtBrandNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>

            <!-- ============================ ?????????????????????????????????????????? ???????????? ============================ -->
            <?php if ($aDataFilter['tGroupReport']  == '08') : ?>
                <?php if ((isset($aDataFilter['tPdtModelCodeFrom']) && !empty($aDataFilter['tPdtModelCodeFrom'])) && (isset($aDataFilter['tPdtModelCodeTo']) && !empty($aDataFilter['tPdtModelCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptModelFrom'] . ' : </span>' . $aDataFilter['tPdtModelNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptModelTo'] . ' : </span>' . $aDataFilter['tPdtModelNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>


            <?php if ((isset($aDataFilter['tGroupReport']) && !empty($aDataFilter['tGroupReport']))) { ?>
                <!-- ============================ ?????????????????????????????????????????? ????????????????????????????????? ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <?php
                        $nTypeGroupReport  = $aDataFilter['tGroupReport'];
                        if ($nTypeGroupReport == '01') {
                            $tGroupRpt  = $aDataTextRef['tRptGrpBranch'];
                        } elseif ($nTypeGroupReport == '02') {
                            $tGroupRpt = $aDataTextRef['tRptGrpAgency'];
                        } elseif ($nTypeGroupReport == '03') {
                            $tGroupRpt = $aDataTextRef['tRptGrpShop'];
                        } elseif ($nTypeGroupReport == '04') {
                            $tGroupRpt = $aDataTextRef['tRptProduct'];
                        } elseif ($nTypeGroupReport == '05') {
                            $tGroupRpt = $aDataTextRef['tRptGrpPdtType'];
                        } elseif ($nTypeGroupReport == '06') {
                            $tGroupRpt = $aDataTextRef['tRptGrpPdtGroup'];
                        } elseif ($nTypeGroupReport == '07') {
                            $tGroupRpt = $aDataTextRef['tRptGrpPdtBrand'];
                        } elseif ($nTypeGroupReport == '08') {
                            $tGroupRpt = $aDataTextRef['tRptGrpPdtModel'];
                        }
                        ?>
                        <labe class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptGroupRpt']; ?></label> <label><?php echo $tGroupRpt; ?></label>
                    </div>
                </div>
            <?php } ?>

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

            <!-- *********************************************************************************************************************************** -->

            <!-- ???????????????????????????????????????????????????????????????????????? -->
            <!-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php
                        // $nTypeGroupReport  = $aDataFilter['tGroupReport'];
                        // if($nTypeGroupReport == '01'){
                        //     $tGroupRpt  = $aDataTextRef['tRptGrpBranch'];
                        // }elseif($nTypeGroupReport == '02'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpAgency'];
                        // }elseif($nTypeGroupReport == '03'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpShop'];
                        // }elseif($nTypeGroupReport == '04'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpPdtType'];
                        // }elseif($nTypeGroupReport == '05'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpPdtGroup'];
                        // }elseif($nTypeGroupReport == '06'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpPdtBrand'];
                        // }elseif($nTypeGroupReport == '07'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpPdtModel'];
                        // }elseif($nTypeGroupReport == '08'){
                        //     $tGroupRpt = $aDataTextRef['tRptGrpPdtSpl'];
                        // }
                        ?>
                        <label class="xCNTextConsOth"><?php echo $aDataTextRef['tRptPdtTypegraph'] . '' . $tTitle; ?></label>
                    </div>
                </div>
            </div> -->

        </div>
    </div>
</div>




<div class="row">
    <!-- panel ???????????? -->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="odvDSHSALPanelReportComPareSaleByPdtTypeQTY" class="panel panel-default">
                <div class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xWDSHSALPanelMainLeft">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="row xWDSHSALHeadPanel">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                            <label class="xCNTextDetailDB"><?php echo $aDataTextRef['tRptPdtTypegraph'] . '' . $tTitle; ?> Qty</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                            <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="RCSPBT2" data-keygrp="BCH,MER,SHP,POS,PGP,APT,SCT,SRC"></i>
                                        </div>
                                    </div>
                                    <div style="padding-top: 50px;"></div>
                                    <div class="row xWDSHSALDataPanel">
                                    </div>
                                    <div class="xWOverlayLodingChart" data-keyfilter="FPG">
                                        <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- ???????????????????????????????????????????????????????????????????????? ????????????/???????????????????????????/?????????????????????/????????????????????????????????????/?????????????????????????????????/??????????????????/????????????/??????????????????????????????-->
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="odvDSHSALPanelReportComPareSaleByPdtType" class="panel panel-default">
                <div class="panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xWDSHSALPanelMainLeft">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="panel-body" style="padding-bottom:0px;">
                                    <div class="row xWDSHSALHeadPanel">
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-l-0">
                                            <label class="xCNTextDetailDB"><?php echo $aDataTextRef['tRptPdtTypegraph'] . '' . $tTitle; ?> Value</label>
                                        </div>
                                        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 p-r-0 text-right">
                                            <i class="fa fa-filter xWDSHSALFilter" aria-hidden="true" data-keyfilter="RCSPBT" data-keygrp="BCH,MER,SHP,POS,PGP,APT,SCT,SRC"></i>
                                        </div>
                                    </div>
                                    <div style="padding-top: 50px;"></div>
                                    <div class="row xWDSHSALDataPanel">
                                    </div>
                                    <div class="xWOverlayLodingChart" data-keyfilter="FPG">
                                        <img src="<?php echo base_url(); ?>application/modules/common/assets/images/ada.loading.gif" class="xWImgLoading">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>





<!-- ???????????????????????? Where limt 10 ????????? Browe Muti ALL -->
<!-- <input type="hidden" class="form-control" id="ohdDSHSALFilterKey" name="ohdDSHSALFilterKey" value="RCSPBT"> -->

<input type="hidden" id="ohdBaseURL" name="ohdBaseURL" value="<?php echo base_url(); ?>">
<div id="odvDSHSALModalFilterHTML"></div>

<!-- Browe Muti Report -->
<div id="odvModalBrowseMultiContent"></div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseModal.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jBrowseMultiSelect.js"></script>
<!-- ???????????????????????? Where limt 10 ????????? Browe Muti ALL -->
<input type="hidden" id="ohdDSHSALFilterKey" name="ohdDSHSALFilterKey" value="RCSPBT">



<script>
    $(document).ready(function() {
        JSvDSHSALCallViewReportComPareSaleByPdtTypeQTY();
        JSvDSHSALCallViewReportComPareSaleByPdtType();
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



    function JSvDSHSALCallViewReportComPareSaleByPdtType() {
        var tWhereCode = "defult";
        var tNewRoute = $("#ohdBaseURL").val() + "dashboardsaleReportCompareSaleByPdtType/" + tWhereCode;

        $('#odvDSHSALPanelReportComPareSaleByPdtType .xWDSHSALDataPanel').html(
            "<iframe src=\"" + tNewRoute + "\" style=\"width:100%;height:25vw;\"></iframe>"
        );
    }

    function JSvDSHSALCallViewReportComPareSaleByPdtTypeQTY() {
        var tWhereCode = "defult";
        var tNewRoute = $("#ohdBaseURL").val() + "dashboardsaleReportCompareSaleByPdtTypeQTY/" + tWhereCode;
        $('#odvDSHSALPanelReportComPareSaleByPdtTypeQTY .xWDSHSALDataPanel').html(
            "<iframe src=\"" + tNewRoute + "\" style=\"width:100%;height:25vw;\"></iframe>"
        );
    }


    $('.xWDSHSALFilter').unbind().click(function() {
        var nGroupRpt = "<?php echo $aDataFilter['tGroupReport']; ?>";
        var nCoddeWhereBrowe = "<?php echo $aCoddeWhereBrowe; ?>";

        var tWhereCode = nCoddeWhereBrowe.substring(1)

        // alert(tWhereCode);
        // $this->session->set_userdata("tSesUsrAgnCode", $tUsrAgnCodeDefult);
        // 		$this->session->set_userdata("tSesUsrAgnName", $tUsrAgnNameDefult);


        if (nGroupRpt == '01') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var tUsrLevel = "<?php echo $_SESSION["tSesUsrLevel"]; ?>";
            var tBchCodeMulti = "<?php echo $_SESSION["tSesUsrBchCodeMulti"]; ?>";
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = "";
            // var tWhereAgn = "";

            // var tAgnCode = $('#oetDSHSALFilterAgnCode').val();

            // if (tUsrLevel != "HQ") {
            tWhere = " AND TCNMBranch.FTBchCode IN (" + tWhereCode + ") ";
            // } else {
            //     tWhere = "";
            // }


            // if (tAgnCode != '' && tAgnCode != undefined) {
            //     tWhereAgn = " AND TCNMBranch.FTAgnCode IN (" + tAgnCode + ") ";
            // } else {
            //     tWhereAgn = "";
            // }

            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowseBchOption = undefined;
                oDSHSALBrowseBchOption = {
                    Title: ['company/branch/branch', 'tBCHTitle'],
                    Table: {
                        Master: 'TCNMBranch',
                        PK: 'FTBchCode'
                    },
                    Join: {
                        Table: ['TCNMBranch_L'],
                        On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        // Condition: [tWhere + tWhereAgn]
                        Condition: [tWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'company/branch/branch',
                        ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                        DataColumnsFormat: ['', ''],
                        OrderBy: ['TCNMBranch_L.FTBchCode ASC'],
                    },
                    CallBack: {
                        StausAll: ['oetDSHSALFilterBchStaAll'],
                        Value: ['oetDSHSALFilterBchCode', 'TCNMBranch.FTBchCode'],
                        Text: ['oetDSHSALFilterBchName', 'TCNMBranch_L.FTBchName']
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTBchCode']
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseBchOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } else if (nGroupRpt == '02') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var tUsrLevel = "<?php echo $_SESSION['tSesUsrLevel']; ?>";
            var tBchCodeMulti = "<?php echo  $_SESSION['tSesUsrBchCodeMulti']; ?>";
            var tAgnCode = "<?php echo $_SESSION['tSesUsrAgnCode']; ?>";
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = "";

            tWhere = " AND TCNMAgency.FTAgnCode IN (" + tWhereCode + ") ";
            // if (tUsrLevel != "HQ") {
            //     tWhere = " AND TCNMAgency.FTAgnCode  IN (" + tAgnCode + ") ";
            // } else {
            //     tWhere = "";
            // }

            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                let tFilterDataKey = $(this).data('keyfilter');
                // let tFilterDataGrp = $(this).data('keygrp');
                // $('#ohdDSHSALFilterKey').val(tFilterDataKey)

                // alert(tFilterDataGrp);
                window.oDSHSALBrowseAgnOption = undefined;
                oDSHSALBrowseAgnOption = {
                    Title: ['ticket/agency/agency', 'tAggTitle'],
                    Table: {
                        Master: 'TCNMAgency',
                        PK: 'FTAgnCode'
                    },
                    Join: {
                        Table: ['TCNMAgency_L'],
                        On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'ticket/agency/agency',
                        ColumnKeyLang: ['tAggCode', 'tAggName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMAgency.FTAgnCode DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: ['oetDSHSALFilterAgnCode', 'TCNMAgency.FTAgnCode'],
                        Text: ['oetDSHSALFilterAgnName', 'TCNMAgency_L.FTAgnName']
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTAgnCode']
                    }


                };

                // if ($('#ohdDSHSALFilterKey').val() == 'RCSPBT' || $('#ohdDSHSALFilterKey').val() == 'RCSPBT2' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt' || $('#ohdDSHSALFilterKey').val() == 'RPTComSalePdt2') {
                //     JCNxBrowseMultiSelect('oDSHSALBrowseAgnOption');
                // } else {
                JCNxBrowseMultiSelect('oDSHSALBrowseAgnOption');
                // }

            } else {
                JCNxShowMsgSessionExpired();
            }
        } else if (nGroupRpt == '03') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var tUsrLevel = "<?php echo $_SESSION["tSesUsrLevel"]; ?>";
            var tBchCodeMulti = "<?php echo $_SESSION["tSesUsrBchCodeMulti"];  ?>";
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = "";
            tWhere = " AND TCNMShop.FTShpCode IN (" + tWhereCode + ") ";

            // alert(tWhere)
            // if (tUsrLevel != "HQ") {
            //     tWhere = " AND TCNMShop.FTBchCode IN (" + tBchCodeMulti + ") ";
            // } else {
            //     tWhere = "";
            // }
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                let tDataBranch = $('#oetDSHSALFilterBchCode').val();
                let tDataMerchant = $('#oetDSHSALFilterMerCode').val();

                // // ********** Check Data Branch **********
                // let tTextWhereInBranch = '';
                // if (tDataBranch != '') {
                //     tTextWhereInBranch = ' AND (TCNMShop.FTBchCode IN (' + tDataBranch + '))';
                // }

                // // ********** Check Data Merchant **********s
                // let tTextWhereInMerchant = '';
                // if (tDataMerchant != '') {
                //     tTextWhereInMerchant = ' AND (TCNMShop.FTMerCode IN (' + tDataMerchant + '))';
                // }

                window.oDSHSALBrowseShpOption = undefined;
                oDSHSALBrowseShpOption = {
                    Title: ['company/shop/shop', 'tSHPTitle'],
                    Table: {
                        Master: 'TCNMShop',
                        PK: 'FTShpCode'
                    },
                    Join: {
                        Table: ['TCNMShop_L', 'TCNMBranch_L'],
                        On: [
                            'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                            'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = ' + nLangEdits
                        ]
                    },
                    Where: {
                        // Condition: ["AND (TCNMShop.FTShpStaActive = '1')"]
                        // Condition: tWhere
                        Condition: ["AND TCNMShop.FTShpCode IN (" + tWhereCode + ")"]
                    },
                    GrideView: {
                        ColumnPathLang: 'company/shop/shop',
                        ColumnKeyLang: ['tSHPTBBranch', 'tSHPTBCode', 'tSHPTBName'],
                        ColumnsSize: ['15%', '15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat: ['', '', ''],
                        OrderBy: ['TCNMShop.FTBchCode ASC,TCNMShop.FTShpCode ASC'],
                    },
                    CallBack: {
                        StausAll: ['oetDSHSALFilterShpStaAll'],
                        Value: ['oetDSHSALFilterShpCode', "TCNMShop.FTShpCode"],
                        Text: ['oetDSHSALFilterShpName', "TCNMShop_L.FTShpName"]
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTShpCode']
                    },
                    DebugSQL: true
                };
                JCNxBrowseMultiSelect('oDSHSALBrowseShpOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } else if (nGroupRpt == '04') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = '';
            tWhere = " AND TCNMPdt.FTPdtCode IN (" + tWhereCode + ") ";

            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePdtOption = undefined;
                oDSHSALBrowsePdtOption = {
                    Title: ["product/product/product", "tPDTTitle"],
                    Table: {
                        Master: 'TCNMPdt',
                        PK: 'FTPdtCode'
                    },
                    Join: {
                        Table: ['TCNMPdt_L'],
                        On: [
                            'TCNMPdt.FTPdtCode = TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits
                        ]
                    },
                    Where: {
                        // Condition: ["AND (TCNMPdt.FTPdtStaActive = '1')"]
                        Condition: tWhere
                    },
                    GrideView: {
                        ColumnPathLang: 'product/product/product',
                        ColumnKeyLang: ['tPDTCode', 'tPDTName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
                        Perpage: 10,
                        DataColumnsFormat: ['', ''],
                        OrderBy: ['TCNMPdt.FTPdtCode ASC'],
                    },
                    CallBack: {
                        StaSingItem: '1',
                        ReturnType: 'M',
                        StausAll: ['oetDSHSALFilterPdtStaAll'],
                        Value: ['oetDSHSALFilterPdtCode', "TCNMPdt.FTPdtCode"],
                        Text: ['oetDSHSALFilterPdtName', "TCNMPdt_L.FTPdtName"]
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTPdtCode']
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowsePdtOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } else if (nGroupRpt == '05') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = '';
            tWhere = " AND TCNMPdtType.FTPtyCode IN (" + tWhereCode + ") ";

            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePtyOption = undefined;
                oDSHSALBrowsePtyOption = {
                    Title: ["product/pdttype/pdttype", "tPTYTitle"],
                    Table: {
                        Master: 'TCNMPdtType',
                        PK: 'FTPtyCode'
                    },
                    Join: {
                        Table: ['TCNMPdtType_L'],
                        On: ['TCNMPdtType.FTPtyCode = TCNMPdtType_L.FTPtyCode AND TCNMPdtType_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: tWhere
                    },
                    GrideView: {
                        ColumnPathLang: 'product/pdttype/pdttype',
                        ColumnKeyLang: ['tPTYCode', 'tPTYName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPdtType.FTPtyCode', 'TCNMPdtType_L.FTPtyName'],
                        DataColumnsFormat: ['', ''],
                        OrderBy: ['TCNMPdtType.FTPtyCode ASC'],
                    },

                    CallBack: {
                        StausAll: ['oetDSHSALFilterPtyStaAll'],
                        Value: ['oetDSHSALFilterPtyCode', "TCNMPdtType.FTPtyCode"],
                        Text: ['oetDSHSALFilterPtyName', "TCNMPdtType_L.FTPtyName"]
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTPtyCode']
                    }
                }
                JCNxBrowseMultiSelect('oDSHSALBrowsePtyOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } else if (nGroupRpt == '06') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = '';
            tWhere = " AND TCNMPdtGrp.FTPgpChain IN (" + tWhereCode + ") ";

            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePgpOption = undefined;
                oDSHSALBrowsePgpOption = {
                    Title: ["product/pdtgroup/pdtgroup", "tPGPTitle"],
                    Table: {
                        Master: 'TCNMPdtGrp',
                        PK: 'FTPgpChain'
                    },
                    Join: {
                        Table: ['TCNMPdtGrp_L'],
                        On: ['TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: tWhere
                    },
                    GrideView: {
                        ColumnPathLang: 'product/pdtgroup/pdtgroup',
                        ColumnKeyLang: ['tPGPCode', 'tPGPName'],
                        ColumnsSize: ['15%', '75%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName'],
                        DataColumnsFormat: ['', ''],
                        OrderBy: ['TCNMPdtGrp.FTPgpChain ASC'],
                    },
                    CallBack: {
                        StausAll: ['oetDSHSALFilterPgpStaAll'],
                        Value: ['oetDSHSALFilterPgpCode', "TCNMPdtGrp.FTPgpChain"],
                        Text: ['oetDSHSALFilterPgpName', "TCNMPdtGrp_L.FTPgpName"]
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTPgpChain']
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowsePgpOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } else if (nGroupRpt == '07') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";

            var tWhere = '';
            tWhere = " AND TCNMPdtBrand.FTPbnCode IN (" + tWhereCode + ") ";

            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePbnOption = undefined;
                oDSHSALBrowsePbnOption = {
                    Title: ['product/pdtbrand/pdtbrand', 'tPBNTitle'],
                    Table: {
                        Master: 'TCNMPdtBrand',
                        PK: 'FTPbnCode'
                    },
                    Join: {
                        Table: ['TCNMPdtBrand_L'],
                        On: [
                            'TCNMPdtBrand.FTPbnCode = TCNMPdtBrand_L.FTPbnCode AND TCNMPdtBrand_L.FNLngID = ' + nLangEdits
                        ]
                    },
                    Where: {
                        // Condition: [tWhereAngCode]
                        Condition: [tWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'product/pdtbrand/pdtbrand',
                        ColumnKeyLang: ['tPBNFrmPbnCode', 'tPBNFrmPbnName'],
                        ColumnsSize: ['15%', '90%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPdtBrand.FTPbnCode', 'TCNMPdtBrand_L.FTPbnName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMPdtBrand.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: ['oetFTPbnCode', "TCNMPdtBrand.FTPbnCode"],
                        Text: ['oetFTPbnName', "TCNMPdtBrand_L.FTPbnName"]
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTPgpChain']
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowsePbnOption');
            } else {
                JCNxShowMsgSessionExpired();
            }

        } else if (nGroupRpt == '08') {
            let nStaSession = JCNxFuncChkSessionExpired();
            var nLangEdits = "<?php echo $_SESSION["tLangEdit"]; ?>";
            var tWhere = '';
            tWhere = " AND TCNMPdtModel.FTPmoCode IN (" + tWhereCode + ") ";


            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSxCheckPinMenuClose(); // Hidden Pin Menu
                window.oDSHSALBrowsePmoOption = undefined;
                oDSHSALBrowsePmoOption = {
                    Title: ['product/pdtmodel/pdtmodel', 'tPMOTitle'],
                    Table: {
                        Master: 'TCNMPdtModel',
                        PK: 'FTPmoCode'
                    },
                    Join: {
                        Table: ['TCNMPdtModel_L'],
                        On: [
                            'TCNMPdtModel.FTPmoCode = TCNMPdtModel_L.FTPmoCode AND TCNMPdtModel_L.FNLngID = ' + nLangEdits
                        ]
                    },
                    Where: {
                        // Condition: [tWhereAngCode]
                        Condition: [tWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'product/pdtmodel/pdtmodel',
                        ColumnKeyLang: ['tPMOFrmPmoCode', 'tPMOFrmPmoName'],
                        ColumnsSize: ['15%', '90%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMPdtModel.FTPmoCode', 'TCNMPdtModel_L.FTPmoName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMPdtModel.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: ['oetPmoCode', "TCNMPdtModel.FTPmoCode"],
                        Text: ['oetPmoName', "TCNMPdtModel_L.FTPmoName"]
                    },
                    NextFunc: {
                        FuncName: 'JSxNextWhereChart',
                        ArgReturn: ['FTPgpChain']
                    }
                };
                JCNxBrowseMultiSelect('oDSHSALBrowsePmoOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        }

    });

    function JSxNextWhereChart(poDataNextFunc) {
        // alert(poDataNextFunc)
        if (typeof(poDataNextFunc) != 'undefined' && poDataNextFunc != "NULL") {
            var tWhereCode = '';
            for ($i = 0; $i < poDataNextFunc.length; $i++) {
                var aText = JSON.parse(poDataNextFunc[$i]);
                tWhereCode += aText[0] + 'nbsp';
            }

            tWhereCode = tWhereCode.replace("'", "");
            var tNewRoute = $("#ohdBaseURL").val() + "dashboardsaleReportCompareSaleByPdtTypeQTY/" + tWhereCode;
            $('#odvDSHSALPanelReportComPareSaleByPdtTypeQTY .xWDSHSALDataPanel').html(
                "<iframe src=\"" + tNewRoute + "\" style=\"width:100%;height:25vw;\"></iframe>"
            );

            var tNewRoute = $("#ohdBaseURL").val() + "dashboardsaleReportCompareSaleByPdtType/" + tWhereCode;
            $('#odvDSHSALPanelReportComPareSaleByPdtType .xWDSHSALDataPanel').html(
                "<iframe src=\"" + tNewRoute + "\" style=\"width:100%;height:25vw;\"></iframe>"
            );
        }
    }
</script>
