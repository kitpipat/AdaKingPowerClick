<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
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
        border-
         : 1px solid black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
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
<div id="odvRptTaxSalePosByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <!-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                    </div>
                </div>
            </div> -->
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
                                <!-- <div class="text-center xCNRptFilter">
                                    <label ><?php echo $aDataTextRef['tRptTaxSalePosByDateFilterDocDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>
                                    <label ><?php echo $aDataTextRef['tRptTaxSalePosByDateFilterDocDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div> -->
                                <?php
                                  //จัดฟอร์แมต DateFrom
                                  $tDocDateFrom = explode("-",$aDataFilter['tDocDateFrom']);
                                  //เซตปี คศ +543
                                  $tYearFrom    = $tDocDateFrom[0]+543;
                                  $tMonthFrom   = $tDocDateFrom[1];
                                  $tDayFrom     = $tDocDateFrom[2];
                                  //ตรวจสอบ เดือนที่เลือก
                                  $tMonth  = language('report/report/report', 'tRptMonth'.$tMonthFrom);
                                  //จัดฟอแมต วัน/เดือน/ปี
                                  $tFormatDateFrom =($aDataTextRef['tRptTaxSalePosDocDate'].' '.$tDayFrom.' '.$aDataTextRef['tRptTaxSalePosTaxMonth'].' '.$tMonth.' '.$aDataTextRef['tRptTaxSalePosYear'].' '.$tYearFrom);
                                 ?>
                                <?php
                                  ////จัดฟอร์แมต DateTo
                                  $tDocDateFrom = explode("-",$aDataFilter['tDocDateTo']);
                                  //เซตปี คศ +543
                                  $tYearFromTo    = $tDocDateFrom[0]+543;
                                  $tMonthFromTo   = $tDocDateFrom[1];
                                  $tDayFromTo     = $tDocDateFrom[2];
                                  //ตรวจสอบ เดือนที่เลือก
                                  $tMonthFormTo  = language('report/report/report', 'tRptMonth'.$tMonthFromTo);
                                  //จัดฟอแมต วัน/เดือน/ปี
                                  $tFormatDateFromTo =($aDataTextRef['tRptTaxSalePosDocDate'].' '.$tDayFromTo.' '.$aDataTextRef['tRptTaxSalePosTaxMonth'].' '.$tMonthFormTo.' '.$aDataTextRef['tRptTaxSalePosYear'].' '.$tYearFromTo);
                                 ?>
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $tFormatDateFrom;?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptTaxSaleFromTo'].''.$tFormatDateFromTo;?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalePosByDateFilterBchFrom'].' </span>'.$aDataFilter['tBchNameFrom'];?></label>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalePosByDateFilterBchTo'].' </span>'.$aDataFilter['tBchNameTo'];?></label>
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
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:4%"><?php echo $aDataTextRef['tRowNumber'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:8%"><?php echo $aDataTextRef['tRptTaxSalePosByDateDocDate'];?></th>

                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptDocSale'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptDocReturn'];?></th>

                            <th nowrap class="text-right xCNRptColumnHeader" style="width:7%"><?php echo $aDataTextRef['tRptTaxSalePosByDateAmt'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:7%"><?php echo $aDataTextRef['tRptTaxSalePosByDateAmtV'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:7%"><?php echo $aDataTextRef['tRptTaxSalePosByDateAmtNV'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:7%"><?php echo $aDataTextRef['tRptTaxSalePosByDateTotal'];?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                            $paFooterSumData1 = 0;
                            $paFooterSumData2 = 0;
                            $paFooterSumData3 = 0;
                            $nSeq = 1;
                            $tBchCodeNew = "";
                            $tPosCodeNew = "";
                            $tNextPos = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tXrcNet = 0;
                                    // $tDocNo = $aValue["FTXshDocNo"];
                                    $tBchCode = $aValue["FTBchCode"];
                                    $tPosCode = $aValue["FTPosCode"];
                                    $tDocDate = date("d/m/Y",strtotime($aValue['FDXshDocDate']));
                                    $nRowPartID = $aValue["FNRowPartID"];
                                    $nRowPartIDPos = $aValue["RowIDPos"];
                                    $nPosCount = $aValue["FNPosCounts"];

                                    // สาขา
                                    $aGrouppingData = array($aDataTextRef['tRptAddrBranch'].' ('.$tBchCode.')'.' '.$aValue["FTBchName"], '', number_format($aValue["FCXshAmt_SumBch"], $nOptDecimalShow), number_format($aValue["FCXshVat_SumBch"], $nOptDecimalShow), number_format($aValue["FCXshAmtNV_SumBch"], $nOptDecimalShow), number_format($aValue["FCXshGrandTotal_SumBch"], $nOptDecimalShow));
                                    FCNtHRPTHeadGrouppingRptLevel1($nRowPartID, $aGrouppingData);
                                    $tBchCodeNew = $tBchCode;

                                    // เครื่องจุดขาย
                                    $aGrouppingData = array('&nbsp;&nbsp;&nbsp;'.$aDataTextRef['tRptTaxSalePosSale'].' '.$tPosCode, '', number_format($aValue["FCXshAmt_SumPos"], $nOptDecimalShow), number_format($aValue["FCXshVat_SumPos"], $nOptDecimalShow), number_format($aValue["FCXshAmtNV_SumPos"], $nOptDecimalShow), number_format($aValue["FCXshGrandTotal_SumPos"], $nOptDecimalShow));
                                    FCNtHRPTHeadGrouppingRptLevel2($nRowPartIDPos, $aGrouppingData);

                                    if($aValue["FNRowPartID"] == 1){
                                        $nSeq = 1;
                                    }
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td class="text-center xCNRptDetail"><?php echo $aValue['RowIDPos']; ?></td>
                                    <td class="text-center xCNRptDetail"><?php echo $tDocDate; ?></td>

                                    <td class="text-left xCNRptDetail"><?php echo ($aValue['FTXshDocNoSale'] != NULL ? $aValue['FTXshDocNoSale'] : "-"); ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo ($aValue['FTXshDocNoRefun'] != NULL ? $aValue['FTXshDocNoRefun'] : "-"); ?></td>

                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshAmt"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshVat"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshAmtNV"], $nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrandTotal"], $nOptDecimalShow); ?></td>
                                </tr>

                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    /*$aSumFooter1         = array('N','N', 'เงินสด', number_format($aValue["rcCash"], 2));
                                    $aSumFooter2         = array('N','N', 'บัตรเครดิต', number_format($aValue["rcCredit"], 2));
                                    $aSumFooter3         = array('N','N', 'ชำระรวม', number_format($aValue["rcCash"] + $aValue["rcCredit"], 2));
                                    // Step 4 : สั่ง Summary Sub Footer
                                    /*Parameter
                                    $nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    $nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    $aSumFooter       =  ข้อมูล Summary SubFooter*/
                                    /*if($aValue["rcCash"] != 0){
                                        FCNtHRPTSumSubFooter2($nGroupMember, $nRowPartID, $aSumFooter1);
                                    }
                                    if($aValue["rcCredit"] != 0){
                                        FCNtHRPTSumSubFooter2($nGroupMember, $nRowPartID, $aSumFooter2);
                                    }
                                    FCNtHRPTSumSubFooter2($nGroupMember, $nRowPartID, $aSumFooter3);*/

                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $paFooterSumData = array($aDataTextRef['tRptTaxSalePosByDateTotalSub'], 'N', 'N', 'N', number_format(@$aValue['FCXshAmt_Footer'], $nOptDecimalShow), number_format(@$aValue['FCXshVat_Footer'], $nOptDecimalShow), number_format(@$aValue['FCXshAmtNV_Footer'], $nOptDecimalShow), number_format(@$aValue['FCXshGrandTotal_Footer'], $nOptDecimalShow));
                                ?>
                            <?php } ?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php }else { ?>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptTaxSalePosByDateNoData'];?></td></tr>
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

                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']];?></label>
                    </div>
                </div>

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
