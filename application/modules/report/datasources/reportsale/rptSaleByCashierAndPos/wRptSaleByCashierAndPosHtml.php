<?php
    $aDataReport = $aDataViewRpt['aDataReport'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
?>

<style>
    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:nth-child(1)>td, .table>thead:first-child>tr:nth-child(1)>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;

        /* background-color: #CFE2F3 !important; */
    }

    .table>thead:first-child>tr:nth-child(2)>td, .table>thead:first-child>tr:nth-child(2)>th {
        border-bottom : 1px solid black !important;

        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrFooter{
        /* background-color: #CFE2F3 !important; */
        /* border-bottom : 6px double black !important; */
        /* border-top: dashed 1px #333 !important; */
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
    .table>tbody>tr>td.xCNRptDetail:nth-child(8), .table>tbody>tr>td.xCNRptDetail:nth-child(8) {
        border-right: 1px dashed #ccc !important;
    }
    .table>tbody>tr>td.xCNRptGrouPing:nth-child(7), .table>tbody>tr>td.xCNRptGrouPing:nth-child(7) {
        border-right: 1px dashed #ccc !important;
    }
    .table>tbody>tr.xCNTrFooter>td:nth-child(8), .table>tbody>tr.xCNTrFooter>td:nth-child(8) {
        border-right: 1px dashed #ccc !important;
    }
    /*แนวนอน*/
    @media print{@page {
        size: A4 landscape;
        /* margin: 5mm 5mm 5mm 5mm; */
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
        }
    }
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>

<div id="odvRptSaleByCashierAndPosHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                    </div>
                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label ><?php echo $aDataTextRef['tRptSaleByCashierAndPosFilterDocDateFrom'].' '.date("d/m/Y", strtotime($aDataFilter['tDocDateFrom']));?></label>
                                    <label ><?php echo $aDataTextRef['tRptSaleByCashierAndPosFilterDocDateTo'].' '.date("d/m/Y", strtotime($aDataFilter['tDocDateTo']));?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByCashierAndPosFilterBchFrom'].' </span>'.$aDataFilter['tBchNameFrom'];?></label>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByCashierAndPosFilterBchTo'].' </span>'.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader"     rowspan="2" width="10%" style="vertical-align: middle;"><?=language('report/report/report','tRptTaxSalePosByDatePos')?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"     rowspan="2" width="15%" style="vertical-align: middle;"><?php echo $aDataTextRef['tRptSaleByCashierAndPosCashier']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"    rowspan="2" width="2%" style="vertical-align: middle;"><?php echo $aDataTextRef['tRptSaleByCashierAndPosQtyBill']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"   colspan="5" width="40%" style="border-right: 1px dashed #ccc !important; border-bottom: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptSaleByCashierAndPosSale']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"   colspan="8" width="45%" style="border-bottom: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptSaleByCashierAndPosPayType']; ?></th>
                        </tr>
                        <tr>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosGrandSale']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosReturn']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosRound']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosDisCoupon']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%" style="border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptSaleByCashierAndPosNetSale']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosCash']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosCreditCard']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosCheque']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosCashCoupon']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosVouchers']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosCashCard']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosOther']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" width="5%"><?php echo $aDataTextRef['tRptSaleByCashierAndPosPaymentTotal']; ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php $tBchCode     = ''; ?>
                            <?php $tBchCodeNew  = ''; ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>

                                <!--โชว์สาขา-->
                                <?php
                                    $tBchCode     = $aValue["FTBchCode"];
                                    if($tBchCode != $tBchCodeNew){ ?>
                                        <tr>
                                            <td class="text-left xCNRptDetail xCNRptGrouPing" colspan="16" style='border-bottom: dashed 1px #333 !important;'> <?=language('report/report/report', 'tRptAddrBranch');?>  (<?=$aValue["FTBchCode"]; ?>) <?=$aValue["FTBchName"]; ?></td>
                                        </tr>
                                <?php  
                                    $tBchCodeNew = $tBchCode;
                                    $tPosCodeNew = '';
                                } ?>

                                <!--  Step 1 แสดงข้อมูลใน Temp -->
                                <tr>
                                    <td class="text-left xCNRptDetail">&nbsp;&nbsp;<?php echo $aValue["FTPosCode"]; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue["FTUsrName"]; ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FNXshBillQty"], 0); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshNet"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshReturn"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshRnd"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshDis"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcCash"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcCredit"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcCheque"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcCashCpn"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcVoucher"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcCashCrd"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcOther"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcTotal"], $nOptDecimalShow); ?></td>
                                </tr>

                                <?php if($aValue["FNRowPartID"] == $aValue["FNPosCounts"]) { ?>
                                    <!--  Step 2 แสดงข้อมูลผลรวมตาม POS  -->
                                    <tr style="border-bottom: dashed 1px #333 !important;">
                                        <td class="text-left xCNRptGrouPing" colspan="2"><?php echo $aDataTextRef['tRptSaleByCashierAndPosTotalSub'].$aValue["FTPosCode"]; ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FNXshBillQty_SumPos"], 0); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXshNet_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXshReturn_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXshRnd_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXshDis_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXshGrand_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcCash_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcCredit_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcCheque_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcCashCpn_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcVoucher_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcCashCrd_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcOther_SumPos"], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptGrouPing"><?php echo number_format($aValue["FCXrcTotal_SumPos"], $nOptDecimalShow); ?></td>
                                    </tr>
                                <?php } ?>

                                <?php
                                    $paFooterSumData = array($aDataTextRef['tRptSaleByCashierAndPosTotalFooter'], 'N',
                                        number_format($aValue['FNXshBillQty_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXshNet_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXshReturn_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXshRnd_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXshDis_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXshGrand_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcCash_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcCredit_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcCheque_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcCashCpn_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcVoucher_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcCashCrd_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcOther_Footer'], $nOptDecimalShow),
                                        number_format($aValue['FCXrcTotal_Footer'], $nOptDecimalShow)
                                    );
                                ?>
                            <?php } ?>
                            <?php
                                // Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php }else { ?>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptSaleByCashierAndPosNoData'];?></td></tr>
                        <?php } ;?>
                    </tbody>
                </table>
            </div>

            <!--เเสดงหน้า-->
            <div class="xCNRptFilterTitle">
                <div class="text-right">
                    <label><?=language('report/report/report','tRptPage')?> <?=$aDataReport["aPagination"]["nDisplayPage"]?> <?=language('report/report/report','tRptTo')?> <?=$aDataReport["aPagination"]["nTotalPage"]?> </label>
                </div>
            </div>

            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
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
             <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
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
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierFrom'].' : </span>'.$aDataFilter['tCashierNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierTo'].' : </span>'.$aDataFilter['tCashierNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))): ?>

                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tPdtNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['tPdtNameTo'];?></label>
                    </div>
                </div> -->

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtGrpNameFrom']) && !empty($aDataFilter['tPdtGrpNameFrom'])) && (isset($aDataFilter['tPdtGrpNameTo']) && !empty($aDataFilter['tPdtGrpNameTo']))): ?>

                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'].' : </span>'.$aDataFilter['tPdtGrpNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'].' : </span>'.$aDataFilter['tPdtGrpNameTo'];?></label>
                    </div>
                </div> -->

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtTypeNameFrom']) && !empty($aDataFilter['tPdtTypeNameFrom'])) && (isset($aDataFilter['tPdtTypeNameTo']) && !empty($aDataFilter['tPdtTypeNameTo']))): ?>

                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeFrom'].' : </span>'.$aDataFilter['tPdtTypeNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeTo'].' : </span>'.$aDataFilter['tPdtTypeNameTo'];?></label>
                    </div>
                </div> -->

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทจุดขาย ============================ -->
            <?php if(isset($aDataFilter['tPosType'])){ ?>

                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']];?></label>
                    </div>
                </div> -->

            <?php } ?>
        </div>

        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["aPagination"]["nTotalPage"] > 0):?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"].' / '.$aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif;?>
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
