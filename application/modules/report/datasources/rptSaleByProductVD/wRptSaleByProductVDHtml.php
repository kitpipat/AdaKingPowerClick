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

                    <?php if( (isset($aDataFilter['tRptPdtCodeFrom']) && !empty($aDataFilter['tRptPdtCodeFrom'])) && (isset($aDataFilter['tRptPdtCodeTo']) && !empty($aDataFilter['tRptPdtCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPdtCodeFrom'].' : '.$aDataFilter['tRptPdtNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPdtCodeTo'].' : '.$aDataFilter['tRptPdtNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>    

                    <?php if( (isset($aDataFilter['tRptPdtGrpCodeFrom']) && !empty($aDataFilter['tRptPdtGrpCodeFrom'])) && (isset($aDataFilter['tRptPdtGrpCodeTo']) && !empty($aDataFilter['tRptPdtGrpCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPdtGrpFrom'].' : '.$aDataFilter['tRptPdtGrpNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPdtGrpTo'].' : '.$aDataFilter['tRptPdtGrpNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>   
                    
                    
                    <?php if( (isset($aDataFilter['tRptPdtTypeCodeFrom']) && !empty($aDataFilter['tRptPdtTypeCodeFrom'])) && (isset($aDataFilter['tRptPdtTypeCodeTo']) && !empty($aDataFilter['tRptPdtTypeCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPdtTypeFrom'].' : '.$aDataFilter['tRptPdtTypeNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPdtTypeTo'].' : '.$aDataFilter['tRptPdtTypeNameTo'];?></label>
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
                            <th nowrap class="text-center" style="width:20%"><?php   echo $aDataTextRef['tRptBillNo']; ?></th>
                            <th nowrap class="text-center" style="width:20%"><?php   echo $aDataTextRef['tRptDate']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptProduct']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptCabinetnumber']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptPriceVD']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptSales']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptDiscount']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptTax']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php   echo $aDataTextRef['tRptGrand']; ?></th>
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
                                    // SUMFOOER
                                    $nXsdQty                = 0;
                                    $nAmtB4DisChg           = 0;
                                    $nXsdDis                = 0;
                                    $nXsdNetAfHD            = 0;
                                    $nXsdVat                = 0;

                                    // Footer 
                                    $nXsdQty_Footer              =  0;
                                    $nXsdAmtB4DisChg_Footer      =  0;
                                    $nXsdDis_Footer              =  0;
                                    $nFCXsdNetAfHD_Footer        =  0;
                                    $nXsdVat_Footer              =  0;


                                    $tXshDocNo    = $aValue["FTXshDocNo"];
                                    $tXshDocDate  = $aValue["FDXshDocDate"];
                                    $nRowPartID   = $aValue["FNRowPartID"]; 
                                    $nGroupMember = $aValue["FNRptGroupMember"]; 
                                ?>
                                 <?php
                                    // // Step 2 Groupping data
                                    $aGrouppingData = array($tXshDocNo,$tXshDocDate, 'N', 'N', 'N', 'N', 'N', 'N');
                                   
                                    // /*Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping*/
                                    FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
 
                                 ?>
                                
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="text-left"></td>
                                    <td nowrap class="text-left"></td>
                                    <td nowrap class="text-left"><?php echo $aValue["FTXsdPdtName"]; ?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXsdQty"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXsdSetPrice"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXsdAmtB4DisChg"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXsdDis"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXsdVat"],2)?></td>
                                    <td nowrap class="text-right"><?php echo number_format($aValue["FCXsdNetAfHD"],2)?></td>
                                </tr>
                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    $nXsdQty                = number_format($aValue["FCXsdQty_SUM"],2);
                                    $nAmtB4DisChg           = number_format($aValue["FCXsdAmtB4DisChg_SUM"],2);
                                    $nXsdDis                = number_format($aValue["FCXsdDis_SUM"],2);
                                    $nXsdNetAfHD            = number_format($aValue["FCXsdNetAfHD_SUM"],2);
                                    $nXsdVat                = number_format($aValue["FCXsdVat_SUM"],2);
                   
                              
                                    
                                    $aSumFooter             = array($aDataTextRef['tRptRentAmtFolCourSumText'],'N','N',$nXsdQty,'N',$nAmtB4DisChg ,$nXsdDis ,$nXsdVat ,$nXsdNetAfHD );
                                
                                    // Step 4 : สั่ง Summary Sub Footer
                                    /*Parameter 
                                    $nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    $nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    $aSumFooter       =  ข้อมูล Summary SubFooter*/
                                    FCNtHRPTSumSubFooter($nGroupMember, $nRowPartID, $aSumFooter);
                                    $nXsdQty_Footer              =  number_format($aValue["FCXsdQty_Footer"],2);
                                    $nXsdAmtB4DisChg_Footer      =  number_format($aValue["FCXsdAmtB4DisChg_Footer"],2);
                                    $nXsdDis_Footer              =  number_format($aValue["FCXsdDis_Footer"],2);
                                    $nFCXsdNetAfHD_Footer        =  number_format($aValue["FCXsdNetAfHD_Footer"],2);
                                    $nXsdVat_Footer              =  number_format($aValue["FCXsdVat_Footer"],2);
                                    
                                    // Step 5 เตรียม Parameter สำหรับ SumFooter 
                                    $paFooterSumData = array($aDataTextRef['tRptByBillTotal'], 'N', 'N', $nXsdQty_Footer , 'N', $nXsdAmtB4DisChg_Footer , $nXsdDis_Footer  , $nXsdVat_Footer , $nFCXsdNetAfHD_Footer  );
                                ?>
                            <?php } ?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter2($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php }else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptDataReportNotFound'];?></td></tr>
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








































