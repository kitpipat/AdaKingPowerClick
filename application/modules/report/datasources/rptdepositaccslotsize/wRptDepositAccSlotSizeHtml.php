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
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: dashed 1px #333 !important; 
    }
</style>

<div id="odvRptTimeDeposit">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)):?>
                        <div class="text-left">
                            <label class="xCNRptCompany"><?php echo $aCompanyInfo['FTCmpName'];?></label>
                        </div>
                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label ><?php echo @$aCompanyInfo['FTAddV1No'] . ' ' . @$aCompanyInfo['FTAddV1Road'] . ' ' . @$aCompanyInfo['FTAddV1Soi']?>
                                <?php echo @$aCompanyInfo['FTSudName'] . ' ' . @$aCompanyInfo['FTDstName'] . ' ' . @$aCompanyInfo['FTPvnName'] . ' ' . @$aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>
                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>
                        <div class="text-left xCNRptAddress">
                            <label><?php echo @$aDataTextRef['tRptAddrTel'] . @$aCompanyInfo['FTCmpTel']?> <?php echo @$aDataTextRef['tRptAddrFax'] . @$aCompanyInfo['FTCmpFax']?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?php echo @$aDataTextRef['tRptAddrBranch'] . @$aCompanyInfo['FTBchName'];?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?php echo @$aDataTextRef['tRptAddrTaxNo'] . @$aCompanyInfo['FTAddTaxNo']?></label>
                        </div> 
                    <?php endif; ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <?php 
                            $dDateFilterFrom = date_create($aDataFilter['tDocDateFrom']); 
                            $dDateFilterTo   = date_create($aDataFilter['tDocDateTo']); 
                        ?> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptDateFrom'].' '.date_format($dDateFilterFrom,"d/m/Y");?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptDateTo'].' '.date_format($dDateFilterTo,"d/m/Y");?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tRptTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div class="table-responsive" id="odvRptTableAdvance">
                 <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:10%;vertical-align:middle;"><?php echo $aDataTextRef['tRptDpsSizeBranch'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:30%;vertical-align:middle;"><?php echo $aDataTextRef['tRptDpsSizeShop'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:10%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:10%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptDepositPosID'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"  style="width:10%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptDepositBillAmount'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"  style="width:10%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptDepositTimeAvg'];?></th>           
                            <th nowrap class="text-right xCNRptColumnHeader"  style="width:10%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptDpsSizeAmount'];?></th>           
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th></th>
                            <th nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tRptDepositSize'];?></th>
                        </tr>
                    </thead>
                    <tbody> 
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])): ?>
                            <?php
                                $tGrouppingBch      = "";
                                $nCountBch          = 0;   
                                $nSubBillQTYBch     = 0;
                                $nSubAmountBch      = 0;
                                $nSubBillQTYShp     = 0;
                                $nSubAmountShp      = 0;
                                $nSubAmountShp      = 0;
                                $nBillQTY           = 0;
                                $nAmount            = 0;
                                $nBillQTY_Footer    = 0;
                                $nGrand_Footer      = 0;
                            ?>

                            <?php foreach($aDataReport['aRptData'] as $nKey=>$aValue) : ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tBchCode         = $aValue['FTBchCode'];
                                    $tBchName         = $aValue['FTBchName'];
                                    $tShpCode         = $aValue['FTShpCode'];
                                    $tShpName         = $aValue['FTShpName'];
                                    $tPosCode         = $aValue['FTPosCode'];
                                    $tPzeCode         = $aValue['FTSizCode'];
                                    $tPzeName         = $aValue['FTSizName'];
                                    $nRowPartID       = $aValue["FNRowPartID"]; 
                                    $tBillQty         = number_format($aValue['FNXshQTYBill'],$nOptDecimalShow);
                                    $tTimeAvg         = number_format($aValue['FTXshDepositTime'],$nOptDecimalShow);
                                    $tGrand           = number_format($aValue['FCXshGrand'],$nOptDecimalShow);
                                    $nBillQTY_SumBch  = number_format($aValue['FNXshQTYBill_SUMBCH'],$nOptDecimalShow);
                                    $nGrand_SumBch    = number_format($aValue['FCXshGrand_SUMBCH'],$nOptDecimalShow);
                                    $nTimeAvg_SumAvg  = number_format($aValue['FTXshDepositTime_SUMBCH'],$nOptDecimalShow);
                                    $nBillQTY_SumSHP  = number_format($aValue['FNXshQTYBill_SUMSHP'],$nOptDecimalShow);
                                    $nGrand_SumSHP    = number_format($aValue['FCXshGrand_SUMSHP'],$nOptDecimalShow);
                                    $nBillQTY_Footer  = number_format($aValue['FNXshQTYBill_Footer'],$nOptDecimalShow);
                                    $nGrand_Footer    = number_format($aValue['FCXshGrand_Footer'],$nOptDecimalShow);
                                    $cGrand_Footer    = empty($aValue['FCXshGrand_Footer']) ? 0 : $aValue['FCXshGrand_Footer'];
                                ?>

                                <?php
                                    // Step 2 Groupping data
                                    $aGrouppingDataBch  = array('('.$tBchCode. ') '.$tBchName,'',$nBillQTY_SumBch,$nTimeAvg_SumAvg,$nGrand_SumBch);
                                    $aGrouppingDataShp  = array($tShpName,'PID : '.$tPosCode,$nBillQTY_SumSHP,$nTimeAvg_SumAvg,$nGrand_SumSHP);

                                    // จัด Groupping สาขา 
                                    if($tGrouppingBch != $tBchCode &&  $nCountBch > 0){
                                    $tSumFooter         = array('N','N','N','N','N','N','N');
                                    if($nRowPartID == 1){
                                        echo '<tr>';
                                        for($i = 0;$i<FCNnHSizeOf($tSumFooter);$i++){
                                            if($tSumFooter[$i] !='N'){
                                                $tFooter =   $tSumFooter[$i];           
                                            }else{
                                                $tFooter =   '';
                                            }
                                                echo "<td class='xCNRptGrouPing'  style='border-bottom: dashed 1px #333 !important;' >".$tFooter."</td>";
                                            }
                                            echo '</tr>';
                                        }
                                    }

                                    // ขีดเส้นใต้ เมื่อจบสาขานั้น
                                    if($tGrouppingBch != $tBchCode){
                                        if($nRowPartID == 1){
                                            echo "<tr>";
                                            for($i = 0;$i<FCNnHSizeOf($aGrouppingDataBch);$i++){
                                                if($aGrouppingDataBch [$i] == $aGrouppingDataBch[0] ){
                                                    echo "<td class='xCNRptGrouPing  text-left'  style='padding: 5px;' colspan='3'>". $aGrouppingDataBch[$i]."</td>";
                                                }else{
                                                    echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>". $aGrouppingDataBch[$i]."</td>";
                                                }
                                            }
                                            echo "</tr>";
                                        }
                                        $tGrouppingBch = $tBchCode;
                                        $nCountBch++;
                                    }

                                    // จัด Groupping ร้านค้า
                                    if($aValue["FNRowPartID"] == 1){
                                        echo "<tr>";
                                        for($i = 0;$i<FCNnHSizeOf($aGrouppingDataShp);$i++){
                                            if($aGrouppingDataShp[$i] == $aGrouppingDataShp[0]){
                                                echo "<td class='xCNRptGrouPing' style='padding: 5px;text-indent:15%;' colspan='3'>".$aGrouppingDataShp[$i]."</td>";
                                            }else if($aGrouppingDataShp[$i] == $aGrouppingDataShp[1]){
                                                echo "<td class='xCNRptGrouPing' style='padding: 5px;'>".$aGrouppingDataShp[$i]."</td>";
                                            }else{
                                                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$aGrouppingDataShp[$i]."</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>

                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="xCNRptDetail"></td>
                                    <td nowrap class="xCNRptDetail"><?php echo $tPzeName;?></td>
                                    <td nowrap class="xCNRptDetail"></td>
                                    <td nowrap class="xCNRptDetail"></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $tBillQty;?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $tTimeAvg;?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $tGrand;?></td>
                                </tr>
                                <?php  $aFooterSumData = array($aDataTextRef['tRptDepositTimeAll'], $nBillQTY_Footer,'',$nGrand_Footer);?> 
                            <?php endforeach; ?>

                            <?php 
                                $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];

                                if ($nPageNo == $nTotalPage) {
                                    echo "<tr'>";
                            
                                    for ($i = 0; $i < FCNnHSizeOf($aFooterSumData); $i++) {
    
                                        if ($aFooterSumData[$i] != 'N') {
                                            $tFooterVal = $aFooterSumData[$i];
                                        } else {
                                            $tFooterVal = '';
                                        }
                            
                                        if ($i == 0) {
                                            echo "<td class='xCNRptSumFooter text-left' colspan='4' style='border-top: 1px solid black !important;border-bottom: 1px solid black !important'>" . $tFooterVal . "</td>";
                                        } else {
                                            echo "<td class='xCNRptSumFooter text-right' style='border-top: 1px solid black !important;border-bottom: 1px solid black !important'>" . $tFooterVal . "</td>";
                                        }
                                    }
                                    echo "</tr>";
                                }
                            ?>
                        <?php else: ?>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptDepositTimeNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                 </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
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
                <?php if((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo $aDataFilter['tMerNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerTo']; ?> : </span> <?php echo $aDataFilter['tMerNameTo']; ?></label>
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
                <?php if((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo $aDataFilter['tShopNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopTo']; ?> : </span> <?php echo $aDataFilter['tShopNameTo']; ?></label>
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

                <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                <?php if((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDFrom']; ?> : </span> <?php echo $aDataFilter['tPosNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDTo']; ?> : </span> <?php echo $aDataFilter['tPosNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ขนาด ============================ -->
                <?php if((isset($aDataFilter['tPzeCodeFrom']) && !empty($aDataFilter['tPzeCodeFrom'])) && (isset($aDataFilter['tPzeCodeTo']) && !empty($aDataFilter['tPzeCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopSizeForm']; ?> : </span> <?php echo $aDataFilter['tPzeNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopSizeTo']; ?> : </span> <?php echo $aDataFilter['tPzeNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
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