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

    .xWRptProductFillData>td:first-child {
        text-indent: 40px;
    }

      .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }


    /*แนวนอน*/
    /*@media print{@page {size: landscape}}*/
    /*แนวตั้ง*/
    @media print{@page {size: portrait}}
</style>


<div id="odvRptSaleVatInvoiceByBillHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>


                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
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
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tRptTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>

            <div class="xCNContentReport">
                <div id="odvRptTableAdvance" class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th nowrap class="text-left xCNRptColumnHeader" style="width:40%;"><?php echo $aDataTextRef['tRptSaleByDate']; ?></th>
                                <th nowrap class="text-left xCNRptColumnHeader" style="width:60%;"><?php echo $aDataTextRef['tRptSaleByDateTypePayment'];?></th>
                                <th nowrap class="text-left xCNRptColumnHeader" style="width:60%;"><?php echo $aDataTextRef['tRptSaleByDateAmtQty'];?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>

                                <?php
                                    $nFCXrcNet_Footer      = 0;
                                    $nFCXrcNet_Sup         = 0;
                                    $tRcvCodeGroup         = '';
                                    $nCountDataDate        = 0;

                                    $tRptGtpDataDate     = "";
                                ?>

                                <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                    <?php
                                        $tRcvCode       = $aValue['FTRcvCode'];
                                        $tRcvName       = $aValue['FTRcvName'];
                                        $nFNRowPartID   = $aValue['FNRowPartID'];
                                        $nFNRptGroupMember  = $aValue['FNRptGroupMember'];
                                        $nFDXrcRefDate  = $aValue['FDXrcRefDate'];

                                        $nFCXrcNet_Footer      = number_format($aValue['FCXrcNet_Footer'],$nOptDecimalShow);
                                        $nFCXrcNet_Sup  = number_format($aValue['FCXrcNet_Sup'],$nOptDecimalShow);


                                        //Groupping  Date
                                        if($aValue['FNRowPartID'] == 1){
                                            if(isset($nFDXrcRefDate) && !empty($nFDXrcRefDate)){
                                                $nXrcRefDate  = date('d/m/Y',strtotime($aValue["FDXrcRefDate"]));
                                            }

                                            //เส้น Group
                                            if ($nFNRowPartID == $nFNRptGroupMember) {
                                                echo "<tr><td class='xCNRptGrouPing' colspan='8' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                            }

                                            $aGrouppingDate  = array($nXrcRefDate);
                                            echo "<tr>";
                                                for ($i = 0; $i < FCNnHSizeOf($aGrouppingDate); $i++) {
                                                    if (strval($aGrouppingDate[$i]) != "N") {
                                                        echo "<td class='xCNRptGrouPing text-left' style='padding: 5px;' colspan='8'>" . $aGrouppingDate[$i] . "</td>";
                                                    } else {
                                                        echo "<td></td>";
                                                    }
                                                }
                                            echo "<tr>";
                                            $tRptGtpDataDate = $nFDXrcRefDate;
                                            $nCountDataDate + 1;
                                        }
                                    ?>


                                    <tr class="xWRptProductFillData">
                                        <td class="text-left xCNRptDetail"></td>
                                        <td class="text-left xCNRptDetail"><?php echo $aValue['FTRcvName']; ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXrcNet'],$nOptDecimalShow); ?></td>
                                    </tr>


                                    <?php
                                        $nXrcNet_Sup   = number_format($aValue["FCXrcNet_Sup"],2);
                                        $aSumFooter    = array('N',$aDataTextRef['tRptSaleByDateGrandTotal']);


                                        // Step 4 : สั่ง Summary Sub Footer
                                        // Parameter
                                        // $nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                        // $nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                        if($nFNRowPartID == $nFNRptGroupMember){

                                            echo "<tr>";
                                                echo "
                                                    <tr class='xWRptProductFillData'>
                                                        <td class='text-left xCNRptSumFooter'style='border-bottom: dashed 1px #333 !important;'></td>
                                                        <td class='text-left xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'>".$aDataTextRef['tRptSaleByDateGrandTotal']."</td>
                                                        <td class='text-right xCNRptSumFooter' style='border-bottom: dashed 1px #333 !important;'>" . number_format($aValue["FCXrcNet_Sup"], 2) . "</td>
                                                    </tr>";
                                            echo "<tr>";
                                        }
                                    ?>


                                <?php } ?>
                                    <?php

                                      // Step 5 เตรียม Parameter สำหรับ SumFooter
                                        $nFCXrcNet_Footer = number_format($aValue["FCXrcNet_Footer"], $nOptDecimalShow);
                                        $aFooterSumData = array($aDataTextRef['tRPCTBFooterSumAll'],'N', $nFCXrcNet_Footer);

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
                            <?php }else { ?>
                                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData'];?></td></tr>
                            <?php } ?>
                        </tbody>
                    </table>
                </div>
                <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                        || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect']))
                        || (isset($aDataFilter['tPosCodeSelect']))
                        ){ ?>
                <div class="xCNRptFilterTitle">
                    <div class="text-left">
                        <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                    </div>
                </div>
                <?php } ;?>

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

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
            <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvFrom'].' : </span>'.$aDataFilter['tRcvNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvTo'].' : </span>'.$aDataFilter['tRcvNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
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
<script type="text/javascript">
    var oFilterLabel    = $('.report-filter .text-left label:first-child');
    var nMaxWidth       = 0;
    oFilterLabel.each(function(index){
        var nLabelWidth = $(this).outerWidth();
        if(nLabelWidth > nMaxWidth){
            nMaxWidth = nLabelWidth;
        }
    });
    $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
</script>
