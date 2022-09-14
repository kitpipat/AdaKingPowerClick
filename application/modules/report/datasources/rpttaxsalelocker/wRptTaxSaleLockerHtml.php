<?php
$aDataReport        = $aDataViewRpt['aDataReport'];
$aDataTextRef       = $aDataViewRpt['aDataTextRef'];
$aDataFilter        = $aDataViewRpt['aDataFilter'];
$nOptDecimalShow    = $aDataViewRpt['nOptDecimalShow'];
$nPageNo            = $aDataReport["aPagination"]["nDisplayPage"];
$nTotalPage         = $aDataReport["aPagination"]["nTotalPage"];
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
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?> <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="xCNRptAddress">
                            <label ><?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="xCNRptAddress">
                            <label ><?= $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>
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
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerRowNo']; ?></th>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerDocDate']; ?></th>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerDocNo']; ?></th>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerDocRef']; ?></th>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerCustomer']; ?></th>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerCtmTaxNo']; ?></th>
                            <th nowrap class="text-left"><?php echo $aDataTextRef['tRptTaxSaleLockerMerChant']; ?></th>
                            <th nowrap class="text-right"><?php echo $aDataTextRef['tRptTaxSaleLockerAmt']; ?></th>
                            <th nowrap class="text-right"><?php echo $aDataTextRef['tRptTaxSaleLockerAmtV']; ?></th>
                            <th nowrap class="text-right"><?php echo $aDataTextRef['tRptTaxSaleLockerAmtNV']; ?></th>
                            <th nowrap class="text-right"><?php echo $aDataTextRef['tRptTaxSaleLockerGrandTotal']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                            // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                            $nSubSumXshAmt = 0;
                            $nSubSumXshAmtV = 0;
                            $nSubSumXshAmtNV = 0;
                            $nSubSumGrandTotal = 0;

                            $nSumFooterXshAmt = 0;
                            $nSumFooterXshAmtV = 0;
                            $nSumFooterXshAmtNV = 0;
                            $nSumFooterGrandTotal = 0;
                            ?>    
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                // Step 1 เตรียม Parameter สำหรับการ Groupping
                                $tPosCode = $aValue["FTPosCode"];
                                $nGroupMember = $aValue["FNRptGroupMember"];
                                $nRowPartID = $aValue["FNRowPartID"];
                                ?>
                                <?php
                                // Step 2 Groupping data
                                $aGrouppingData = array($aDataTextRef['tRptTaxSaleLockerPosGrouping'] . ' ' . $tPosCode, 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N', 'N');
                                // Parameter
                                // $nRowPartID      = ลำดับตามกลุ่ม
                                // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td class="text-left"><?php echo $aValue['RowID']; ?></td>
                                    <td class="text-left"><?php echo date("Y/m/d", strtotime($aValue['FDXshDocDate'])); ?></td>
                                    <td class="text-left"><?php echo $aValue['FTXshDocNo']; ?></td>
                                    <td class="text-left"><?php echo $aValue['FTXshDocRef']; ?></td>
                                    <td class="text-left"><?php echo !empty($aValue['FTCstName']) ? $aValue['FTCstName'] : '-'; ?></td>
                                    <td class="text-left"><?php echo !empty($aValue['FTXshTaxID']) ? $aValue['FTXshTaxID'] : '-'; ?></td>
                                    <td class="text-left"><?php echo !empty($aValue['FTCmpName']) ? $aValue['FTCmpName'] : '-'; ?></td>
                                    <td class="text-right number"><?php echo number_format($aValue["FCXshAmt"], $nOptDecimalShow); ?></td>
                                    <td class="text-right number"><?php echo number_format($aValue["FCXshAmtV"], $nOptDecimalShow); ?></td>
                                    <td class="text-right number"><?php echo number_format($aValue["FCXshAmtNV"], $nOptDecimalShow); ?></td>
                                    <td class="text-right number"><?php echo number_format($aValue["FCXshGrandTotal"], $nOptDecimalShow); ?></td>
                                </tr>
                                <?php
                                // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                $nSubSumXshAmt = $aValue["FCXshAmt_SubTotal"];
                                $nSubSumXshAmtV = number_format($aValue["FCXshAmtV_SubTotal"], $nOptDecimalShow);
                                $nSubSumXshAmtNV = number_format($aValue["FCXshAmtNV_SubTotal"], $nOptDecimalShow);
                                $nSubSumGrandTotal = number_format($aValue["FCXshGrandTotal_SubTotal"], $nOptDecimalShow);
                                $aSumFooter = array($aDataTextRef['tRptTaxSaleLockerTotalSub'], 'N', 'N', 'N', 'N', 'N', 'N', $nSubSumXshAmt, $nSubSumXshAmtV, $nSubSumXshAmtNV, $nSubSumGrandTotal);
                                // Step 4 : สั่ง Summary Sub Footer
                                //Parameter 
                                //$nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                //$nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                //$aSumFooter       =  ข้อมูล Summary SubFooter
                                FCNtHRPTSumSubFooter($nGroupMember, $nRowPartID, $aSumFooter);

                                // Step 5 เตรียม Parameter สำหรับ SumFooter
                                $nSumFooterXshAmt = number_format($aValue["FCXshAmt_Footer"], $nOptDecimalShow);
                                $nSumFooterXshAmtV = number_format($aValue["FCXshAmtV_Footer"], $nOptDecimalShow);
                                $nSumFooterXshAmtNV = number_format($aValue["FCXshAmtNV_Footer"], $nOptDecimalShow);
                                $nSumFooterGrandTotal = number_format($aValue["FCXshGrandTotal_Footer"], $nOptDecimalShow);
                                $paFooterSumData = array($aDataTextRef['tRptTaxSaleLockerTotalFooter'], 'N', 'N', 'N', 'N', 'N', 'N', $nSumFooterXshAmt, $nSumFooterXshAmtV, $nSumFooterXshAmtNV, $nSumFooterGrandTotal);
                                ?>
                            <?php } ?>
                            <?php
                            // Step 6 : สั่ง Summary Footer
                            $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                            FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
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
                <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSaleLockerFilterShopFrom']; ?> : </span> <?php echo $aDataFilter['tShpNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSaleLockerFilterShopTo']; ?> : </span> <?php echo $aDataFilter['tShpNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tMerchantCode']) && !empty($aDataFilter['tMerchantCode'])): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSaleLockerFilterMerChant']; ?> : </span> <?php echo $aDataFilter['tMerchantName']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif;?>
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





















