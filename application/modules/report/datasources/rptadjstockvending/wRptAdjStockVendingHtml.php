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
        border-bottom: dashed 1px #333 !important;
    }

    /** แนวตั้ง */
    @media print{@page {size: landscape}}
</style>
<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </label>   <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </label>     <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjDateFrom']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjDateTo']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
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
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptAdjStkVDDocNo'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptAdjStkVDDocDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptAdjStkVDUserAdj'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptAdjStkVDPdtCode'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:30%;"><?php echo $aDataTextRef['tRptAdjStkVDPdtName'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:20%;"><?php echo $aDataTextRef['tRptAdjStkVDLayRow'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptAdjStkVDLayCol'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptAdjStkVDWahB4Adj'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptAdjStkVDUnitQty'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptAjdQtyAllDiff'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nSubSumAjdWahB4Adj         = 0;
                                $nSubSumAjdUnitQty          = 0;
                                $nSubSumAjdQtyAllDiff       = 0;

                                $nSumFooterAjdWahB4Adj      = 0;
                                $nSumFooterAjdUnitQty       = 0;
                                $nSumFooterAjdQtyAllDiff    = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tDocNo         = $aValue["FTAjhDocNo"];
                                    $tDocDate       = date('d/m/Y H:i:s',strtotime($aValue["FDAjhDocDate"]));
                                    $tApvName       = $aValue["FTAjdApvName"];
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                ?>
                                <?php
                                    //Step 2 Groupping data
                                    $aGrouppingData = array($tDocNo,$tDocDate,$tApvName,"N","N","N","N");
                                    if($nRowPartID == 1) {
                                        echo "<tr>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingData); $i++) {
                                            if(strval($aGrouppingData[$i]) != "N") {
                                                echo "<td class='xCNRptGrouPing  text-left' style='padding: 5px;'>" . $aGrouppingData[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td class="text-left xCNRptDetail">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @$aValue["FTPdtCode"]; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTPdtName'];?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FNAjdLayRow"],0);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FNAjdLayCol"],0);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCAjdWahB4Adj"],0);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCAjdUnitQty"],0);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCAjdQtyAllDiff"],0);?></td>
                                </tr>

                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    $nSubSumAjdWahB4Adj     = intval($aValue["FCAjdWahB4Adj_SubTotal"]);
                                    $nSubSumAjdUnitQty      = intval($aValue["FCAjdUnitQty_SubTotal"]);
                                    $nSubSumAjdQtyAllDiff   = intval($aValue["FCAjdQtyAllDiff_SubTotal"]);

                                    // Step 4 : สั่ง Summary SubFooter
                                    // Parameter
                                    // $nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    // $nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    // $aSumFooter       =  ข้อมูล Summary SubFooter
                                    $aSumFooter             = array($aDataTextRef['tRptAdjStkVDTotalSub'],'N','N','N',$nSubSumAjdWahB4Adj,$nSubSumAjdUnitQty,$nSubSumAjdQtyAllDiff);
                                    if($nRowPartID == $nGroupMember){
                                        echo '<tr>';
                                        for($i = 0;$i<FCNnHSizeOf($aSumFooter);$i++){
                                            if(strval($aSumFooter[$i]) != "N"){
                                                $tFooterVal = $aSumFooter[$i];
                                            }else{
                                                $tFooterVal = '';
                                            }

                                            if(is_int($tFooterVal)){
                                                $tClassCss = "text-right";
                                            }else{
                                                $tClassCss = "text-left";
                                            }
                                            echo "<td class='xCNRptGrouPing $tClassCss'  style='border-top: dashed 1px #333 !important;'>".$tFooterVal."</td>";
                                        }
                                        echo "</tr>";

                                        $nCountDataAll = FCNnHSizeOf($aDataReport['aRptData']);
                                        if($nCountDataAll - 1 != $nKey){
                                            echo "<tr><td class='xCNRptGrouPing' colspan='7' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                        }
                                    }

                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nSumFooterAjdWahB4Adj      = intval($aValue["FCAjdWahB4Adj_Footer"]);
                                    $nSumFooterAjdUnitQty       = intval($aValue["FCAjdUnitQty_Footer"]);
                                    $nSumFooterAjdQtyAllDiff    = intval($aValue["FCAjdQtyAllDiff_Footer"]);
                                    $aFooterSumData             = array($aDataTextRef['tRptAdjStkVDTotalFooter'],'N','N','N',$nSumFooterAjdWahB4Adj,$nSumFooterAjdUnitQty,$nSumFooterAjdQtyAllDiff);
                                ?>
                            <?php endforeach;?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                if($nPageNo == $nTotalPage){
                                    echo "<tr class='xCNTrFooter'>";
                                    for($i = 0; $i < FCNnHSizeOf($aFooterSumData); $i++){
                                        if($i == 0){
                                            $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;/*background-color: #CFE2F3;*/';
                                        }else{
                                            $tStyle = 'text-align:right;border-top:1px solid #333;border-bottom:1px solid #333;/*background-color: #CFE2F3;*/';
                                        }

                                        if(strval($aFooterSumData[$i]) != "N"){
                                            $tFooterVal = $aFooterSumData[$i];
                                        }else{
                                            $tFooterVal = '';
                                        }
                                        if($i == 0) {
                                            echo "<td class='xCNRptSumFooter text-left' colspan='1'>" . $tFooterVal . "</td>";
                                        } else {
                                            echo "<td class='xCNRptSumFooter text-right'>" . $tFooterVal . "</td>";
                                        }
                                    }
                                    echo "<tr>";
                                }
                            ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>

            <?php if( (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))
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

            <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom'].' : </span>'.$aDataFilter['tWahNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahTo'].' : </span>'.$aDataFilter['tWahNameTo'];?></label>
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
