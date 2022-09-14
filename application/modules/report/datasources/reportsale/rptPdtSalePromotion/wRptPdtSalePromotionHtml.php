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

<div id="odvRptPdtSalePromotionHtml">
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
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
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
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPromotion'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPmoModelPro'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:15%; text-indent: -70px;"><?php echo $aDataTextRef['tRpePmoBarCode'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:20%; text-indent: -23px;"><?php echo $aDataTextRef['tRptPmoProduct'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:15%;"><?php echo $aDataTextRef['tRptPmoSup'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPmoScored'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPmoQtyUnit'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%;"><?php echo $aDataTextRef['tRptPmoUnit'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPmoPriceNormal'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPmoDiscount'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:20%;"><?php echo $aDataTextRef['tRptPricePromotion'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nSumFooterFCXsdQty      = 0;
                                $nSumFooterFCXsdNet      = 0;
                                $nSumFooterFCXpdDis      = 0;
                                $nSumFooterFCXsdNetPmt   = 0;

                                $nSumSubFCXsdQty         = 0;
                                $nSumSubFCXsdNet         = 0;
                                $nSumSubFCXpdDis         = 0;
                                $nSumSubFCXsdNetPmt      = 0;

                                $tGetTypePmh  =  '';
                            ?>

                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    $tPmhDocNo      = $aValue['FTPmhDocNo']."&nbsp;&nbsp;".$aValue['FTPmhName'];  // เลขที่โปรโมชัน และชื่อโปรโมชัน
                                    $tGetTypePmh    = $aValue['FTXpdGetType'];  //รูปแบบโปรโมชั่น 1:ลดบาท 2:ลด% 3:ปรับราคา 4:.ใช้กลุ่มราคา 5:แถม(Free) 6:ไม่กำหนด
                                    $nFCXpdPoint    = number_format($aValue['FCXpdPoint'],$nOptDecimalShow); //แต้ม
                                    $tQtyPer        = number_format($aValue['FCXsdQty_SubTotal'],$nOptDecimalShow);  // จำนวน
                                    $nFCXsdNet      = number_format($aValue['FCXsdNet_SubTotal'],$nOptDecimalShow);  // ราคาปกติ
                                    $nFCXpdDis      = number_format($aValue['FCXpdDis_SubTotal'],$nOptDecimalShow);  // ส่วนลด
                                    $nFCXsdNetPmt   = number_format($aValue['FCXsdNetPmt_SubTotal'],$nOptDecimalShow);  // ราคาโปรโมชัน

                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"];

                                    // $nRowPartID1     = $aValue["PartID1"];

                                    switch($tGetTypePmh){
                                        case 1:
                                            $tGetTypePmh  = 'ลดบาท';
                                        break;
                                        case 2:
                                            $tGetTypePmh  = 'ลด%';
                                        break;
                                        case 3:
                                            $tGetTypePmh  = 'ปรับราคา';
                                        break;
                                        case 4:
                                            $tGetTypePmh  = 'ใช้กลุ่มราคา';
                                        break;
                                        case 5:
                                            $tGetTypePmh  = 'แถม(Free)';
                                        break;
                                        case 6:
                                            $tGetTypePmh  = 'แต้ม';
                                        break;
                                    }

                                ?>

                                <?php
                                    $aGrouppingData = array($tPmhDocNo,"N",$tGetTypePmh,"N",$tQtyPer,"N",$nFCXsdNet,$nFCXpdDis,$nFCXsdNetPmt);
                                    if($nRowPartID == 1) {
                                        echo "<tr class='xCNRptGrouPing' colspan='9' style='border-top: dashed 1px #333 !important;'>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingData); $i++) {

                                            $tTextStyle = 'text-right';
                                            $tTextInden = '';
                                            $tWidth = '';

                                            if($i==0){
                                                $tTextStyle = 'text-left';
                                                $tWidth = 'width:25%';
                                            }

                                            if($i==2){
                                                $tTextInden = 'text-indent: 115px;';
                                                $tTextStyle = 'text-left';

                                            }

                                            if(strval($aGrouppingData[$i]) != "N") {
                                                echo "<td class='xCNRptGrouPing ".$tTextStyle."' style='padding: 5px; ".$tTextInden." ".$tWidth." '>" . $aGrouppingData[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>

                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td class="text-left xCNRptDetail" style="text-indent: 92px;"><?php echo $aValue["FTXsdBarCode"]; ?></td>
                                    <td class="text-left xCNRptDetail" style="text-indent: -23px;"><?php echo $aValue["FTPdtName"]; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue["FTSplName"]; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo number_format($aValue["FCXpdPoint"],$nOptDecimalShow); ?></td>
                                    <td class="text-left xCNRptDetail text-right"><?php echo number_format($aValue["FCXsdQty"],$nOptDecimalShow); ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo $aValue["FTPunName"]; ?></td>
                                    <td class="text-left xCNRptDetail text-right"><?php echo number_format($aValue["FCXsdNet"],$nOptDecimalShow); ?></td>
                                    <td class="text-left xCNRptDetail text-right"><?php echo number_format($aValue["FCXpdDis"],$nOptDecimalShow); ?></td>
                                    <td class="text-left xCNRptDetail text-right"><?php echo number_format($aValue["FCXsdNetPmt"],$nOptDecimalShow); ?></td>
                                </tr>


                                <?php
                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nFCXsdQty_Footer    = intval($aValue["FCXsdQty_Footer"]);
                                    $nFCXsdNet_Footer    = intval($aValue["FCXsdNet_Footer"]);
                                    $nFCXpdDis_Footer    = intval($aValue["FCXpdDis_Footer"]);
                                    $nFCXsdNetPmt_Footer = intval($aValue["FCXsdNetPmt_Footer"]);

                                    $aFooterSumData      = array($aDataTextRef['tRptAdjStkVDTotalFooter'],'N','N','N',number_format($nFCXsdQty_Footer,$nOptDecimalShow),"N",number_format($nFCXsdNet_Footer,$nOptDecimalShow),number_format($nFCXpdDis_Footer,$nOptDecimalShow),number_format($nFCXsdNetPmt_Footer,$nOptDecimalShow));

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
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect']))
                        || (isset($aDataFilter['tPosCodeSelect']))
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
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
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
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


            <!-- ============================ ฟิวเตอร์ข้อมูล ผู้จำหน่าย ============================ -->
            <?php if ((isset($aDataFilter['tSupplierCodeFrom']) && !empty($aDataFilter['tSupplierCodeFrom'])) && (isset($aDataFilter['tSupplierCodeTo']) && !empty($aDataFilter['tSupplierCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSplFrom'].' : </span>'.$aDataFilter['tSupplierNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSplTo'].' : </span>'.$aDataFilter['tSupplierNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>



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
