<?php
    date_default_timezone_set("Asia/Bangkok");

    $aDataReport = $aDataViewRpt['aDataReport'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
?>

<style>
.xCNFooterRpt {
    border-bottom: 7px double #ddd;
}

.table>thead:first-child>tr:nth-child(2)>td,
.table>thead:first-child>tr:nth-child(2)>th,
.table>thead:first-child>tr:first-child>td,
.table>thead:first-child>tr:first-child>th {
    border-top: 1px solid black !important;
    border-bottom: 1px solid black !important;
    background-color: #CFE2F3 !important;
}

.table>thead:first-child>tr:first-child>th, .table>thead:first-child>tr:nth-child(2)>th {
    border-left: 0px transparent !important;
    border-right: 0px transparent !important;
}

.table>thead:first-child>tr:first-child>th:first-child, .table>thead:first-child>tr:nth-child(2)>th:first-child {
    border-left: 0px solid black !important;
}

.table>thead:first-child>tr:first-child>th:last-child, .table>thead:first-child>tr:nth-child(2)>th:last-child {
    border-right: 0px solid black !important;
}

.table tbody tr, .table>tbody>tr>td {
    border: 0px transparent !important;
    padding-left: 10px !important;
}

.table>thead:first-child>tr:first-child>th:nth-child(1), 
.table>thead:first-child>tr:first-child>th:nth-child(2), 
.table>thead:first-child>tr:first-child>th:nth-child(3),
.table>thead:first-child>tr:first-child>th:nth-child(4),
.table>thead:first-child>tr:first-child>th:nth-child(5) {
    border-bottom: 0px transparent !important;
}

.table>thead:first-child>tr:nth-child(2)>th:nth-child(1), 
.table>thead:first-child>tr:nth-child(2)>th:nth-child(2),
.table>thead:first-child>tr:nth-child(2)>th:nth-child(3),
.table>thead:first-child>tr:nth-child(2)>th:nth-child(4),
.table>thead:first-child>tr:nth-child(2)>th:nth-child(5) {
    border-top: 0px transparent !important;
}
</style>
<div id="odvRptSaleByPaymentDetailHtml">
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
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel']?> <?=$aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax']?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName']?></label>
                        </div>
                    
                    <?php } ?>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                    <?php if((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'].' '.$aDataFilter['tShopNameFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'].' '.$aDataFilter['tShopNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                        
                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
            </div>
            
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tRptTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
            
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <?php 
                    $bShowFooter = false;
                    if(($aDataReport['aPagination']['nTotalPage'] == $aDataReport['aPagination']['nDisplayPage'])) {
                        $bShowFooter = true;
                    }
                ?>
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBBarchCode']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBBarchName']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBShopCode']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBShopName']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPA2TBDocDate']; ?></th>
                            <th nowrap class="text-center" colspan="3"><?php echo $aDataTextRef['tRPA2TBAmount']; ?></th>
                        </tr>
                        <tr>
                            <th nowrap class="text-left" style="width:10%"></th>
                            <th nowrap class="text-left" style="width:10%"></th>
                            <th nowrap class="text-left" style="width:10%"></th>  
                            <th nowrap class="text-left" style="width:10%"></th>
                            <th nowrap class="text-left" style="width:10%"></th>                                      
                            <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPA2TBSale']; ?></th>
                            <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPA2TBCancelSale']; ?></th>
                            <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPA2TBTotalSale']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร Sum - SubFooter
                                $nSumSubXsdQty = 0;
                                $cSumSubXsdAmtB4DisChg = 0;
                                $cSumSubXsdDis = 0;
                                $cSumSubXsdVat = 0;
                                $cSumSubXsdNetAfHD = 0;
                                // Set ตัวแปร SumFooter
                                $nSumFootXsdQty = 0;
                                $cSumFootXsdAmtB4DisChg = 0;
                                $cSumFootXsdDis = 0;
                                $cSumFootXsdVat = 0;
                                $cSumFootXsdNetAfHD = 0;
                            ?> 
                            <?php foreach($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tBchCode = $aValue["FTBchCode"];
                                    $tBchName = $aValue["FTBchName"];
                                    $tShpCode = $aValue["FTShpCode"];
                                    $tShpName = $aValue['FTShpName'];
                                    $nGroupMember = $aValue["FNRptGroupMember"]; 
                                    $nRowPartID = $aValue["FNRowPartID"]; 
                                ?>
                                <?php
                                    // Step 2 Groupping data
                                    $aGrouppingData = array($tBchCode, $tBchName, $tShpCode, $tShpName, "N", "N", "N", "N");
                                    // Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                    FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                ?>
                                <!-- Step 2 แสดงข้อมูลใน TD -->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td><?php echo date("Y-m-d", strtotime($aValue["FDTxnDocDate"])); ?></td>
                                    <td class="text-right"><?php echo number_format($aValue["FCTxnSaleVal"], 2);?></td>
                                    <td class="text-right"><?php echo number_format($aValue["FCTxnCancelSaleVal"], 2);?></td>
                                    <td class="text-right"><?php echo number_format($aValue["FCTxnSaleNet"], 2);?></td>                                                
                                </tr>

                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    $TxnSaleVal_SubTotal = number_format($aValue["FCTxnSaleVal_SubTotal"], 2);
                                    $TxnCancelSaleVal_SubTotal = number_format($aValue["FCTxnCancelSaleVal_SubTotal"], 2);
                                    $SaleNet_SubTotal = number_format($aValue["FCSaleNet_SubTotal"], 2);

                                    $aSumFooter = array($aDataTextRef["tRPA5TBCrdTotal"],"N", "N", "N", "N", $TxnSaleVal_SubTotal,$TxnCancelSaleVal_SubTotal,$SaleNet_SubTotal);

                                    // Step 4 : สั่ง Summary SubFooter
                                    // Parameter 
                                    // $nGroupMember = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    // $nRowPartID = ลำดับข้อมูลในกลุ่ม
                                    // $aSumFooter = ข้อมูล Summary SubFooter
                                    FCNtHRPTSumSubFooter($nGroupMember,$nRowPartID,$aSumFooter);

                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nSumTxnSaleVal_Footer = number_format($aValue["FCTxnSaleVal_Footer"], 2);
                                    $cSumTxnCancelSaleVal_Footer = number_format($aValue["FCTxnCancelSaleVal_Footer"], 2);
                                    $cSumNetSale_Footer = number_format($aValue["FCNetSale_Footer"], 2);
                                    $paFooterSumData = array($aDataTextRef["tRPA2TBTotalAllSale"],"N", "N", "N", "N",$nSumTxnSaleVal_Footer,$cSumTxnCancelSaleVal_Footer,$cSumNetSale_Footer);
                                ?>
                            <?php } ?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                if($bShowFooter) {
                                    FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                                }
                            ?>
                        <?php else: ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptNoData']; ?></td>
                            </tr>
                        <?php endif; ?>
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