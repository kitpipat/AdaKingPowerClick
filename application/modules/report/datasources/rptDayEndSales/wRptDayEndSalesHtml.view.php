<?php

    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];

?>

<style>

    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px solid #FFF !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }

    .table>tfoot>tr>td{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }

    @media print{@page {size: portrait}}

</style>

<div id="odvRptEndDaySalesHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">

                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tRptEndDaySaleTitle']; ?></label>
                    </div>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label class="xCNRptLabel">
                                    <?php
                                        $tDocDateFrom   = $aDataFilter['tDocDateFrom'];
                                        $tDateFrom      = new DateTime($tDocDateFrom);
                                        $tDocDateFromTo = $aDataFilter['tDocDateTo'];
                                        $tDateFromTo    = new DateTime($tDocDateFromTo);
                                    ?>
                                    </label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'] . ' : </span>' .  $tDateFrom->format('d/m/Y'); ?> </label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'] . ' : </span>' .  $tDateFromTo->format('d/m/Y'); ?> </label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] . ' : </span>' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] . ' : </span>' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 "></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptDateExport'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>


        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:50%;"><?php echo $aDataTextRef['tRptEndDaySaleDetail'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:50%;"><?php echo $aDataTextRef['tRptEndDaySaleSum'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) {
                        $cSalRound = 0;
                        ?>

                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <tr>
                                    <!-- Type 1 คือยอดขาย -->
                                    <?php if($aValue["FTXihValType"] == '1'){ ?>
                                        <td class="text-left xCNRptDetail"><b>
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                   echo $aDataTextRef['tRptEndDaySale'];
                                                }
                                            ?></b>
                                        </td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>

                                    <!-- Type 2 คือส่วนลด -->
                                    <?php if($aValue["FTXihValType"] == '2'){ ?>
                                        <td class="text-left xCNRptDetail"><b>
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                    echo $aDataTextRef['tRptEndDayDiscount'];
                                                }
                                            ?></b>
                                        </td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>

                                    <!-- Type 2 คือปัดเศษ -->
                                    <?php if($aValue["FTXihValType"] == '3'){
                                        $cSalRound = $aValue["FCXshGrand"];
                                         ?>
                                        <td class="text-left xCNRptDetail"><b>
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                    echo $aDataTextRef['tRptEndDayRound'];
                                                }
                                            ?></b>
                                        </td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>

                                    <!-- Type 2 ยอดขายรวม -->
                                    <?php if($aValue["FTXihValType"] == '4'){ ?>
                                        <td class="text-left xCNRptDetail"><b>
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                   echo $aDataTextRef['tRptEndDayTotalSale'];
                                                }
                                            ?></b>
                                        </td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>


                                    <!-- Type 5 คือประเภทเงิน -->
                                    <?php if($aValue["FTXihValType"] == '5'){ ?>
                                        <td class="text-left xCNRptDetail" >
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                    echo $aValue["FTRcvName"];
                                                }
                                            ?>
                                        </td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>

                                    <!-- Type 6 ยอดขายไม่รวมภาษี -->
                                    <?php if($aValue["FTXihValType"] == '6'){ ?>
                                        <td class="text-left xCNRptDetail"><b>
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                    echo $aDataTextRef['tRptSalesdonotIncludetax'];
                                                }
                                            ?></b>
                                        </td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>


                                    <!-- Type 6 ยอดขายไม่รวมภาษี -->
                                    <?php if($aValue["FTXihValType"] == '7'){ ?>
                                        <td class="text-left xCNRptDetail" style='border-bottom: dashed 1px #333 !important;'><b>
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                    echo $aDataTextRef['tRptEndDaySaleTax'];
                                                }
                                            ?></b>
                                        </td>
                                        <td class="text-right xCNRptDetail" style='border-bottom: dashed 1px #333 !important;'><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>


                                     <!-- กรณีที่ไม่มี ValType -->
                                     <?php if($aValue["FTXihValType"] == 'NULL' || $aValue["FTXihValType"] == ''){ ?>
                                        <td class="text-left xCNRptDetail">
                                            <?php
                                                if($aValue['FTXihValType'] !=''){
                                                    echo $aDataTextRef['tRptEndDayOrther'];
                                                }else{
                                                    echo $aDataTextRef['tRptEndDayOrther'];
                                                }
                                            ?>
                                        </td>
                                        <td class="text-right xCNRptDetail" style='border-bottom: dashed 1px #333 !important;><?php echo number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                                    <?php } ?>

                                </tr>

                                <?php
                                    if($aValue['FTXihValType'] == '4'){
                                        // Step 5 เตรียม Parameter สำหรับ SumFooter
                                        $tGrand_Footer      = number_format($aValue["FCXshGrand"]-$cSalRound, $nOptDecimalShow);
                                        $aFooterSumData     = array($aDataTextRef['tRptEndDaySaleSumTotal'], $tGrand_Footer);
                                    }
                                ?>
                            <?php } ?>
                                <?php
                                    // Step 6 : สั่ง Summary Footer
                                    $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                    $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                    if ($nPageNo == $nTotalPage) {
                                        echo "<tr'>";

                                        for ($i = 0; $i < FCNnHSizeOf($aFooterSumData); $i++) {

                                            if ($aFooterSumData[$i] != 'N') {
                                                $tFooterVal = $aFooterSumData[$i];
                                            } else {
                                                $tFooterVal = '';
                                            }
                                            if ($i == 0) {
                                                echo "<td class='xCNRptSumFooter text-left' style='border-top: 0px solid black !important;border-bottom: 1px solid black !important;'>" . $tFooterVal . "</td>";
                                            } else {
                                                echo "<td class='xCNRptSumFooter text-right' style='border-top: 0px solid black !important;border-bottom: 1px solid black !important;'>" . $tFooterVal . "</td>";
                                            }
                                        }
                                        echo "<tr>";
                                    }
                                ?>
                            <?php }else { ?>
                                <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptNoData'];?></td></tr>
                            <?php } ;?>
                    </tbody>
                </table>
                <?php if ($nPageNo == $nTotalPage) { ?>
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
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySaleMerFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySaleMerTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="xCNRptFilter">
                                <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySaleMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                    <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="text-left xCNRptFilter">
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySaleShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySaleShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
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
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySalePosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptEndDaySalePosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
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

                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทจุดขาย ============================ -->
                    <?php if(isset($aDataFilter['tPosType'])){ ?>

                        <div class="xCNRptFilterBox">
                            <div class="text-left xCNRptFilter">
                                <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']];?></label>
                            </div>
                        </div>

                    <?php } ?>

                <?php } ?>

            </div>
        </div>














    </div>
</div>
