<?php
$aDataReport        = $aDataViewRpt['aDataReport'];
$aDataTextRef       = $aDataViewRpt['aDataTextRef'];
$aDataFilter        = $aDataViewRpt['aDataFilter'];
$nOptDecimalShow    = $aDataViewRpt['nOptDecimalShow'];
$nPageNo            = $aDataReport["aPagination"]["nDisplayPage"];
$nTotalPage         = $aDataReport["aPagination"]["nTotalPage"];
?>
<style>

    .table>tbody>tr>td.xCNRptGrouPing {
        font-family: THSarabunNew-Bold;
        color: #232C3D !important;
        font-size: 20px !important;
        font-weight: 900;
    }

    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr:last-child.xCNTrSubFooter{
        border-bottom : 1px dashed #333 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px dashed #333 !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 1px solid black !important;
    }
    .xWConditionOther{
        font-family: 'THSarabunNew-Bold';
        color: #232C3D !important;
        font-size: 20px !important;
        font-weight: 900;
    }
    /*แนวนอน*/
    /*@media print{@page {size: landscape}}*/
    /*แนวตั้ง*/
    @media print{
        @page {
            size: A4 portrait;
            /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
        }
    }
</style>

<div id="odvRptTaxSaleLockerHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?></label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?></label> <label><?=$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptTaxSaleLockerFilterDocDateFrom'] . ' ' . date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    &nbsp;&nbsp;
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptTaxSaleLockerFilterDocDateTo'] . ' ' . date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class=" xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptSalePos']; ?></th>
                            <th style="border-bottom: 0px !important;"></th>
                            <th nowrap colspan='4' class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSaleType']; ?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important;">
                            <th></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:30%;"><?php echo $aDataTextRef['tRptPaymentType']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptSales']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptXshReturn']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptRndVal']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptXshGrand']; ?></th>
                        </tr>

                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                                $tBchCode       = "";
                                $tBchCodeNew    = "";
                                $tPosCodeNew    = "";
                                $tTpyeCodeNew   = "";
                                $tNextPos       = 0;
                                $tType          = 1;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tTypeCode  = $aValue["FTTnsType"];
                                    $tPosCode   = $aValue["FTPosCode"];
                                    $nRowPartID = $aValue["FNRowPartID"];
                                    $tBchCode   = $aValue["FTBchCode"];

                                    //ตรวจสอบเครื่องจุดขาย
                                    if($tBchCode != $tBchCodeNew){
                                        if($tType != 0){
                                            $aSumFooter         = array('N','N','N','N','N','N');
                                            if($tTypeCode == 1){
                                                echo '<tr>';
                                                for($i = 0;$i<FCNnHSizeOf($aSumFooter);$i++){
                                                    if($aSumFooter[$i] !='N'){
                                                        $tFooterVal =   $aSumFooter[$i];
                                                    }else{
                                                        $tFooterVal =   '';
                                                    }
                                                        echo "<td class='xCNRptGrouPing'  style='border-top: dashed 1px #333 !important;'>".$tFooterVal."</td>";
                                                }
                                                echo '</tr>';
                                            }
                                        }
                                    }
                                ?>
                                
                                <!--โชว์สาขา-->
                                <?php
                                    if($tBchCode != $tBchCodeNew){ ?>
                                        <tr>
                                            <td class="text-left xCNRptDetail xCNRptGrouPing" colspan="6" style='border-bottom: dashed 1px #333 !important;'> <?=language('report/report/report', 'tRptAddrBranch');?>  (<?=$aValue["FTBchCode"]; ?>) <?=$aValue["FTBchName"]; ?></td>
                                        </tr>
                                <?php  
                                    $tBchCodeNew = $tBchCode;
                                    $tPosCodeNew = '';
                                } ?>

                                <!--โชว์จุดขาย-->
                                <?php
                                    if($tPosCode != $tPosCodeNew){ ?>
                                        <tr>
                                            <td class="text-left xCNRptDetail" colspan="2">&nbsp;&nbsp;&nbsp;&nbsp;<?=language('report/report/report', 'tRptTaxSalePosPosGrouping');?> (<?=$aValue["FTPosCode"]; ?>) <?=($aValue["FTPosName"] == '') ? 'ไม่พบชื่อจุดขาย' : $aValue["FTPosName"]; ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshNet"],$nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshReturn"],$nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshRnd"],$nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"],$nOptDecimalShow); ?></td>
                                        </tr>
                                <?php  
                                    $tPosCodeNew = $tPosCode;
                                } ?>

                                <!--โชว์รายละเอียดที่เป็น Type 2 รายการของการชำระเงิน -->
                                <?php
                                    if($tTypeCode == 2){ ?>
                                        <tr>
                                            <td></td>
                                            <td class="text-left  xCNRptDetail" ><?php echo $aValue["FTRcvName"]; ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshNet"],$nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshReturn"],$nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshRnd"],$nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshGrand"],$nOptDecimalShow); ?></td>
                                        </tr>
                                <?php } ?>

                            <?php } ?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                            ?>
                        <?php } else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSaleLockerNoData']; ?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo @$aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>

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

                <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
                <?php if ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierFrom'].' : </span>'.$aDataFilter['tCashierNameFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierTo'].' : </span>'.$aDataFilter['tCashierNameTo'];?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tCashierCodeSelect']) && !empty($aDataFilter['tCashierCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierFrom']; ?> : </span> <?php echo ($aDataFilter['bCashierStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCashierNameSelect']; ?></label>
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
            <?php endif; ?>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0): ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif; ?>
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
