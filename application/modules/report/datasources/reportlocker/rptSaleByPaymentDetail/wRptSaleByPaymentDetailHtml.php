<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
?>
<style>
    /** Set Media Print */
    @media print{@page {size: landscape}}

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
<div id="odvRptSaleByPaymentDetailHtml">
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
                    <?php endif;?>
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
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterDocDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterDocDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo @$aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.@$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailDocDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailPayType'];?></th>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-center xCNRptColumnHeader"   style="width:20%;"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailDocNo'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"   style="width:10%;"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailRack'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"   style="width:20%;"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailDocRef'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"    style="width:25%;"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailPayment'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"    style="width:25%;"><?php echo @$aDataTextRef['tRptSaleByPaymentDetailPaymentTotal'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])): ?>
                            <?php 
                                $paFooterSumData1 = 0;
                                $paFooterSumData2 = 0;
                                $paFooterSumData3 = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tXrcNet        = 0;
                                    $tDocNo         = $aValue["FTXshDocNo"];
                                    $tRefDate       = empty($aValue['FDXshDocDate']) ? "" : date("d/m/Y", strtotime($aValue['FDXshDocDate']));
                                    $tRcvName       = empty($aValue["FTRcvName"]) ? $aDataTextRef['tRptRcvNameEmpty'] : $aValue["FTRcvName"];
                                    $tXrcAmt        = $aValue["FTXrcAmt"];
                                    $tXrcNet        += floatval($aValue["FCXrcNet"]);
                                    $nRowPartID     = $aValue["FNRowPartID"]; 
                                    $nGroupMember   = $aValue["FNRptGroupMember"]; 
                                ?>
                                <?php
                                    // Step 2 Groupping data
                                    $aGrouppingData = array($tDocNo, $tRefDate, $tRcvName, $tXrcAmt, number_format($tXrcNet, $nOptDecimalShow));
                                    /*Parameter
                                    $nRowPartID      = ลำดับตามกลุ่ม
                                    $aGrouppingData  = ข้อมูลสำหรับ Groupping*/
                                    FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td></td>
                                    <td class="text-left"><?php echo $aValue['FTPosCode']; ?></td>
                                    <td><?php echo $aValue['FTXrcRefNo1']; ?></td>
                                    <td><?php // echo $aValue["FTXrcAmt"]; ?></td>
                                    <td class="text-right number"><?php // echo number_format($aValue["FCXrcNet"], 2);?></td>
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
                                    $paFooterSumData = array($aDataTextRef['tRptSaleByPaymentDetailTotalFooter'],'N','N', 'N', number_format(@$aValue['rcSumFootTotal'], $nOptDecimalShow));
                                ?>
                            <?php endforeach;?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter2($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php else: ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptNotFoundData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <?php
                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
            ?>
            <?php if($nPageNo == $nTotalPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo @$aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterShopFrom']; ?> : </span> <?php echo $aDataFilter['tShpNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterShopTo']; ?> : </span> <?php echo $aDataFilter['tShpNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterPosFrom']; ?> : </span> <?php echo $aDataFilter['tPosCodeFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterPosTo']; ?> : </span> <?php echo $aDataFilter['tPosCodeTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterPayTypeFrom']; ?> : </span> <?php echo $aDataFilter['tRcvNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSaleByPaymentDetailFilterPayTypeTo']; ?> : </span> <?php echo $aDataFilter['tRcvNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif;?>
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
