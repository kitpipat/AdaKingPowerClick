<?php
    $aDataFilterReport  = $aDataViewRpt['aDataFilter'];
    $aDataTextRef       = $aDataViewRpt['aDataTextRef'];
    $aDataReport        = $aDataViewRpt['aDataReport'];
    $nOptDecimalShow = $aDataViewRpt['nOptDecimalShow'];
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
    border-bottom: 1px solid black !important;

    /* background-color: #CFE2F3 !important; */
}

.table>tbody>tr.xCNTrSubFooter {
    border-top: 1px solid black !important;
    border-bottom: 1px solid black !important;
    /* background-color: #CFE2F3 !important; */
}

.table>tbody>tr.xCNTrFooter {
    /* background-color: #CFE2F3 !important; */
    /* border-bottom : 6px double black !important; */
    /* border-top: dashed 1px #333 !important; */
    border-top: 1px solid black !important;
    border-bottom: 1px solid black !important;
}

.table tbody tr.xCNHeaderGroup,
.table>tbody>tr.xCNHeaderGroup>td {
    /* color: #232C3D !important; */
    font-size: 18px !important;
    font-weight: 600;
}

.table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
.table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
    text-align: right;
}

/*แนวนอน*/
@media print {
    @page {
        size: A4 landscape;
        margin: 5mm 5mm 5mm 5mm;
    }
}

/*แนวตั้ง*/
/* @media print{@page {size: portrait}} */
</style>

<div id="odvRptSaleByProductHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <!-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if(isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                    <div class="text-left">
                        <label class="xCNRptCompany"><?=$aCompanyInfo['FTCmpName']?></label>
                    </div>

                    <?php if($aCompanyInfo['FTAddVersion'] == '1'){ // ที่อยู่แบบแยก ?>
                    <div class="text-left xCNRptAddress">
                        <label><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']?>
                            <?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']?></label>
                    </div>
                    <?php } ?>


                    <?php if($aCompanyInfo['FTAddVersion'] == '2'){ // ที่อยู่แบบรวม ?>
                    <div class="text-left xCNRptAddress">
                        <label><?=$aCompanyInfo['FTAddV2Desc1']?></label>
                    </div>
                    <div class="text-left xCNRptAddress">
                        <label><?=$aCompanyInfo['FTAddV2Desc2']?></label>
                    </div>
                    <?php } ?>

                    <div class="text-left xCNRptAddress">
                        <label><?=$aDataTextRef['tRptTaxSalePosTel'] . $aCompanyInfo['FTCmpTel']?>
                            <?=$aDataTextRef['tRptTaxSalePosFax'] . $aCompanyInfo['FTCmpFax']?></label>
                    </div>
                    <div class="text-left xCNRptAddress">
                        <label><?=$aDataTextRef['tRptTaxSalePosBch'] . $aCompanyInfo['FTBchName']?></label>
                    </div>

                    <div class="text-left xCNRptAddress">
                        <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo']?></label>
                    </div>

                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center xCNRptFilter">
                                <label class="xCNRptLabel"><span
                                        class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'].' : </span>'.date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>
                                <label class="xCNRptLabel"><span
                                        class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'].' : </span>'.date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
                            </div>
                        </div>
                    </div>
                    <?php endif;?>
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center xCNRptFilter">
                                <label class="xCNRptLabel"><span
                                        class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'].' : </span>'.$aDataFilter['tBchNameFrom'];?></label>
                                <label class="xCNRptLabel"><span
                                        class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'].' : </span>'.$aDataFilter['tBchNameTo'];?></label>
                            </div>
                        </div>
                    </div>
                    <?php } ;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label
                            class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%"><?php  echo language('report/report/report', 'tRptBarchName') ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php  echo language('report/report/report', 'tRptDate') ?></th>
                            <th nowrap class="text-right  xCNRptColumnHeader" ><?php  echo language('report/report/report', 'tRptGrandSale') ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                        <?php
                                // Set ตัวแปร Sum - SubFooter
                                $nSumSubXshGrand        = 0;

                                // Set ตัวแปร SumFooter
                                $nSumFootXshGrand       = 0;
                            ?>
                        <?php foreach($aDataReport['aRptData'] as $nKey=>$aValue):?>
                        <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tBchCodeGroup  = $aValue["FTBchCode"];
                                    // $tRptDocDate    = date('Y-m-d H:i:s', strtotime($aValue["FDCreateOn"]));
                                    $aSumFooter     = array($aValue["FTBchName"],$nSumSubXshGrand);
                                    $nSumSubXshGrand= number_format($aValue["FCXshGrand_SubTotal"], $nOptDecimalShow);
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"]; 
                                ?>
                        <?php
                                    // Step 2 แสดงข้อมูลใน TD
                                    $aGrouppingData = array($tBchCodeGroup);
                                    $date=date_create($aValue["FDXthDocDate"]);
                                    $dXthDocDate = date_format($date,"d/m/Y");

                                    if($nRowPartID == 1){
                                        echo "<tr style='border-top:1px solid black !important'>";
                                        for($i = 0;$i<FCNnHSizeOf($aGrouppingData);$i++){
                                            if($aGrouppingData[$i] == $aGrouppingData[0] ){
                                                echo "<td class='xCNRptGrouPing  text-left' colspan='2' style='padding: 5px;'>".$aValue["FTBchName"]."</td>";
                                                echo "<td class='xCNRptGrouPing  text-right'>".$nSumSubXshGrand."</td>";
                                            }else{
                                                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$aGrouppingData[$i]."</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>
                        <tr>
                            <td></td>
                            <td nowrap class="text-left xCNRptDetail"><?php echo '&nbsp;&nbsp;'.$dXthDocDate;?></td>
                            <td nowrap class="text-left xCNRptDetail text-right"><?php echo '&nbsp;&nbsp;'.number_format($aValue["FCXshGrand"], $nOptDecimalShow);?></td>
                        </tr>
                        <?php
                                    //Step 3 เตรียม Parameter สำหรับ SumFooter
                                    $nSumFootXshGrand           = number_format($aValue["FCXshGrand_Footer"], $nOptDecimalShow);
                                    $paFooterSumData            = array($aDataTextRef['tRptTotalFooter'],'N',$nSumFootXshGrand);
                                ?>
                        <?php endforeach;?>
                        <?php
                                //Step 4 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                            ?>

                        <?php else:?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='100%'>
                                <?php echo $aDataTextRef['tRptTaxSalePosNoData'];;?></td>
                        </tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล ============================ -->
            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
            <div class="xCNRptFilterBox">
                <div class="xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span>
                        <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
            <div class="xCNRptFilterBox">
                <div class="xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span>
                        <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
            <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
            <div class="xCNRptFilterBox">
                <div class="xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span>
                        <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
            <div class="xCNRptFilterBox">
                <div class="xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span>
                        <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom'].' : </span>'.$aDataFilter['tWahNameFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahTo'].' : </span>'.$aDataFilter['tWahNameTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tWahCodeSelect']) && !empty($aDataFilter['tWahCodeSelect'])) : ?>
            <div class="xCNRptFilterBox">
                <div class="xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom']; ?> : </span>
                        <?php echo ($aDataFilter['bWahStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tWahNameSelect']; ?></label>
                </div>
            </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))): ?>

            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tPdtNameFrom'];?></label>
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['tPdtNameTo'];?></label>
                </div>
            </div>

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtGrpNameFrom']) && !empty($aDataFilter['tPdtGrpNameFrom'])) && (isset($aDataFilter['tPdtGrpNameTo']) && !empty($aDataFilter['tPdtGrpNameTo']))): ?>

            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'].' : </span>'.$aDataFilter['tPdtGrpNameFrom'];?></label>
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'].' : </span>'.$aDataFilter['tPdtGrpNameTo'];?></label>
                </div>
            </div>

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtTypeNameFrom']) && !empty($aDataFilter['tPdtTypeNameFrom'])) && (isset($aDataFilter['tPdtTypeNameTo']) && !empty($aDataFilter['tPdtTypeNameTo']))): ?>

            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeFrom'].' : </span>'.$aDataFilter['tPdtTypeNameFrom'];?></label>
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeTo'].' : </span>'.$aDataFilter['tPdtTypeNameTo'];?></label>
                </div>
            </div>

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทจุดขาย ============================ -->
            <?php if(isset($aDataFilter['tPosType'])){ ?>

            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span
                            class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']];?></label>
                </div>
            </div>

            <?php } ?>


        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["aPagination"]["nTotalPage"] > 0):?>
                        <label
                            class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"].' / '.$aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif;?>
                    </div>
                </div>
            </div>
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