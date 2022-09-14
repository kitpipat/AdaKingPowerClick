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
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom : 6px double black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        color: #232C3D !important;
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
</style>
<div id="odvRptTaxSalePosHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if(isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
                    
                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aCompanyInfo['FTCmpName']?></label>
                        </div>

                        <?php if($aCompanyInfo['FTAddVersion'] == '1'){ // ที่อยู่แบบแยก ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>

                        <?php if($aCompanyInfo['FTAddVersion'] == '2'){ // ที่อยู่แบบรวม ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV2Desc1']?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV2Desc2']?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptTaxSalePosTel'] . $aCompanyInfo['FTCmpTel']?> <?=$aDataTextRef['tRptTaxSalePosFax'] . $aCompanyInfo['FTCmpFax']?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptTaxSalePosBch'] . $aCompanyInfo['FTBchName']?></label>
                        </div>
                    
                    <?php } ?>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTaxSalePosFilterBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTaxSalePosFilterBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                    <?php if( (isset($aDataFilter['tRptShpCodeFrom']) && !empty($aDataFilter['tRptShpCodeFrom'])) && (isset($aDataFilter['tRptShpCodeTo']) && !empty($aDataFilter['tRptShpCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'].' : '.$aDataFilter['tRptShpNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'].' : '.$aDataFilter['tRptShpNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>
                        
                    <?php if( (isset($aDataFilter['tRptMerCodeFrom']) && !empty($aDataFilter['tRptMerCodeFrom'])) && (isset($aDataFilter['tRptMerCodeTo']) && !empty($aDataFilter['tRptMerCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptMerFrom'].' : '.$aDataFilter['tRptMerNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptMerTo'].' : '.$aDataFilter['tRptMerNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                    <?php if( (isset($aDataFilter['tRptPosCodeFrom']) && !empty($aDataFilter['tRptPosCodeFrom'])) && (isset($aDataFilter['tRptPosCodeTo']) && !empty($aDataFilter['tRptPosCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosFrom'].' : '.$aDataFilter['tRptPosNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosTo'].' : '.$aDataFilter['tRptPosNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>  

                    <?php if( (isset($aDataFilter['tRptWahCodeFrom']) && !empty($aDataFilter['tRptWahCodeFrom'])) && (isset($aDataFilter['tRptWahCodeTo']) && !empty($aDataFilter['tRptWahCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptAdjWahFrom'].' : '.$aDataFilter['tRptWahNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptAdjWahTo'].' : '.$aDataFilter['tRptWahNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>    

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTaxSalePosFilterDocDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTaxSalePosFilterDocDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTaxSalePos" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-center" style="width:15%;"><?php echo $aDataTextRef['tRptDocBill'];?></th>
                            <th nowrap class="text-center" style="width:15%;"><?php echo $aDataTextRef['tRptDate'];?></th>
                            <th nowrap class="text-center" style="width:5%;"><?php echo $aDataTextRef['tRptSales'];?></th>
                            <th nowrap class="text-center" style="width:5%;"><?php echo $aDataTextRef['tRptDisChg'];?></th>
                            <th nowrap class="text-center" style="width:5%;"><?php echo $aDataTextRef['tRptTax'];?></th>
                            <th nowrap class="text-center" style="width:5%;"><?php echo $aDataTextRef['tRptGrand'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>  
                            <?php 
                            // $paFooterSumData1 = 0;
                            // $paFooterSumData2 = 0;
                            // $paFooterSumData3 = 0;
                            // $nSeq = 1;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping

                                    // SUM_FOOTER
                                    // $nXshAmtNV_SUM            = 0;
                                    // $nFCXshDis_SUM            = 0;
                                    // $nXshVat_SUM              = 0;
                                    // $nXshGrand_SUM            = 0;

                                    // FOOTER
                                    $nXshAmtNV_Footer         = 0;
                                    $nXshDis_Footer           = 0;
                                    $nXshVat_Footer           = 0;
                                    $nXshGrand_Footer         = 0;     
                                    
                                
                                ?>
                                 <?php
                                    // // Step 2 Groupping data
                                    // $aGrouppingData = array($tDocNo, $tDocDate, 'N', 'N', 'N', 'N', 'N', 'N', 'N');
                                    // /*Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping*/
                                    // FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                    // if($aValue["FNRowPartID"] == 1){
                                    //     $nSeq = 1;
                                    // }
                                    // $nSalePercent = $aValue["FTXshDocNo"];
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="text-left"><?php echo $aValue["FTXshDocNo"]; ?></td>
                                    <td nowrap class="text-left"><?php echo $aValue["FDXshDocDate"]; ?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXshAmtNV"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXshDis"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXshVat"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXshGrand"],2)?></td>
                                </tr>
                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    // $aSumFooter             = array($aDataTextRef['tRptRentAmtFolCourSumText'],'N','N' ,$nXsdQty, $nXsdSetPrice, $nXsdAmtB4DisChg ,$nFCXsdDis, $nXsdVat, $nXsdNetAfHD);
                                
                                    // Step 4 : สั่ง Summary Sub Footer
                                    /*Parameter 
                                    $nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    $nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    $aSumFooter       =  ข้อมูล Summary SubFooter*/
                                    // FCNtHRPTSumSubFooter($nGroupMember, $nRowPartID, $aSumFooter);
                                    
                                    $nXshAmtNV_Footer         = number_format($aValue["FCXshAmtNV_Footer"],2);
                                    $nXshDis_Footer           = number_format($aValue["FCXshDis_Footer"],2);
                                    $nXshVat_Footer           = number_format($aValue["FCXshVat_Footer"],2);
                                    $nXshGrand_Footer         = number_format($aValue["FCXshGrand_Footer"],2);  

                                    // Step 5 เตรียม Parameter สำหรับ SumFooter 
                                    $paFooterSumData = array($aDataTextRef['tRptByBillTotal'], 'N', $nXshAmtNV_Footer, $nXshDis_Footer, $nXshVat_Footer, $nXshGrand_Footer);
                                ?>
                            <?php } ?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter2($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php }else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSalePosNoData'];?></td></tr>
                        <?php } ;?>
                    </tbody>
                </table>
            </div>
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








































