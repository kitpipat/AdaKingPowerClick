<?php
    $aDataReport = $aDataViewRpt['aDataReport'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
?>
<style>
    /** Set Media Print */
    @media print{@page {size: A4 landscape;}}

    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }


</style>
<div id="odvRptRentAmountDetailHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">        
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)):?>
                        <div class="text-left">
                            <label class="xCNRptCompany"><?php echo @$aCompanyInfo['FTCmpName']?></label>
                        </div>
                        <?php if(isset($aCompanyInfo['FTAddVersion']) && $aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label ><?php echo @$aCompanyInfo['FTAddV1No'] . ' ' . @$aCompanyInfo['FTAddV1Road'] . ' ' . @$aCompanyInfo['FTAddV1Soi']?>
                                <?php echo @$aCompanyInfo['FTSudName'] . ' ' . @$aCompanyInfo['FTDstName'] . ' ' . @$aCompanyInfo['FTPvnName'] . ' ' . @$aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>
                        <?php if(isset($aCompanyInfo['FTAddVersion']) && $aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
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
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มช่อง ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailSerailPos']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailUser']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailDocno']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailDocDate']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailRack']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailSubRack']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailSize']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailDateGet']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailLoginTo']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailStaPayment']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRentAmtForDetailAmtPayment']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                            $aData          = $aDataReport["aRptData"];
                            $aPagination    = $aDataReport["aPagination"];
                        ?>
                        <?php if ($aData) { ?>
                            <?php
                            $aDataReport = $aData["aData"];
                            $aSumData = $aData["aSumData"];
                            $nPerPage = $aPagination["nPerPage"];
                            $nNumRowDisplay = 0;
                            $nLastRecodeOfPos = 0;
                            $nFCXshSumAllPrePaid = 0;
                            ?>
                            <?php for ($nI = 0; $nI < FCNnHSizeOf($aSumData); $nI++) { ?>
                                <?php
                                $nFCXshSumAllPrePaid = $aSumData[$nI]["FCXshSumAllPrePaid"];
                                $nSeq = 0;
                                ?>    
                                <?php for ($nJ = 0; $nJ < FCNnHSizeOf($aDataReport); $nJ++) { ?>
                                    <?php if ($aSumData[$nI]["FTPosCode"] == $aDataReport[$nJ]["FTPosCode"]) { ?>

                                        <tr>
                                            <?php if ($nSeq == 0) { ?>
                                                <?php
                                                $nPosCodeRowSpan = 0;
                                                if ($aSumData[$nI]["FNXshNumDoc"] <= $nPerPage) {
                                                    $nDif = $nPerPage - $nNumRowDisplay;
                                                    if ($aSumData[$nI]["FNXshNumDoc"] < $nDif) {
                                                        if ($aSumData[$nI]["FNXshNumDoc"] < FCNnHSizeOf($aDataReport)) {
                                                            $nPosCodeRowSpan = $aSumData[$nI]["FNXshNumDoc"];
                                                        } else {
                                                            $nPosCodeRowSpan = FCNnHSizeOf($aDataReport);
                                                        }
                                                    } else {
                                                        if ($nDif < FCNnHSizeOf($aDataReport)) {
                                                            $nPosCodeRowSpan = $nDif;
                                                        } else {
                                                            $nPosCodeRowSpan = FCNnHSizeOf($aDataReport);
                                                        }
                                                    }
                                                }
                                                ?>
                                                <td nowrap class="text-left" style="width:10%" rowspan="<?php echo $nPosCodeRowSpan; ?>">
                                                    <?php echo $aSumData[$nI]["FTPosCode"]; ?>
                                                </td>
                                            <?php } ?>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FTXshFrmLogin"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FTXshDocNo"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo date("Y/m/d", strtotime($aDataReport[$nJ]["FDXshDocDate"])); ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FTRakName"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FNLayNo"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FTPzeName"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo date("Y/m/d", strtotime($aDataReport[$nJ]["FDXshDatePick"])); ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FTXshToLogin"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php
                                                if ($aDataReport[$nJ]["FTXshStaPaid"] == 1) {
                                                    echo $aDataTextRef['tRptRentAmtForDetailStaPaymentNoPay'];
                                                } else if ($aDataReport[$nJ]["FTXshStaPaid"] == 2) {
                                                    echo $aDataTextRef['tRptRentAmtForDetailStaPaymentSome'];
                                                }if ($aDataReport[$nJ]["FTXshStaPaid"] == 3) {
                                                    echo $aDataTextRef['tRptRentAmtForDetailStaPaymentAlready'];
                                                }
                                                ?>
                                            </td>
                                            <td nowrap class="text-right" style="width:10%">
                                                <?php
                                                if ($aDataReport[$nJ]["FCXshPrePaid"] == "") {
                                                    echo number_format("0", 2);
                                                } else {
                                                    echo number_format($aDataReport[$nJ]["FCXshPrePaid"], 2);
                                                }
                                                ?>
                                            </td>
                                        </tr>
                                        <?php
                                        $nSeq++;
                                        $nNumRowDisplay++;
                                        $nLastRecodeOfPos = $aDataReport[$nJ]["FTRptSeqOfGroupPos"];
                                        ?>
                                    <?php } ?>
                                <?php } ?>
                                <?php if ($aSumData[$nI]["FNXshNumDoc"] == $nLastRecodeOfPos) { ?>
                                    <tr>
                                        <td nowrap colspan="10" class="text-left" style="border-top:1px solid #333 !important;border-bottom:1px solid #333 !important;background-color: #CFE2F3; ;padding: 4px;">
                                            <?php echo @$aDataTextRef['tRptRentAmtForDetailSumText']; ?>
                                        </td>
                                        <td nowrap class="text-right" style="border-top:1px solid #333 !important;border-bottom:1px solid #333 !important;background-color: #CFE2F3; ;padding: 4px;">
                                            <?php echo number_format($aSumData[$nI]["FCXshSumPrePaid"], 2); ?>
                                        </td>
                                    </tr>
                                <?php } ?>


                            <?php } ?>
                            <?php if ($aPagination["nTotalPage"] == $aPagination["nDisplayPage"]) { ?>
                                <tr class="xCNTrFooter">
                                    <td nowrap colspan="10" class="text-left" style="border-top:1px solid #333 !important;border-bottom:1px solid #333 !important;background-color: #CFE2F3; ;padding: 4px;">
                                        <?php echo @$aDataTextRef['tRptRentAmtForDetailSumTextLast']; ?>
                                    </td>
                                    <td nowrap class="text-right" style="border-top:1px solid #333 !important;border-bottom:1px solid #333 !important;background-color: #CFE2F3; ;padding: 4px;">
                                        <?php echo number_format($nFCXshSumAllPrePaid, 2); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptAdjStkNoData']; ?></td></tr>
                        <?php } ?>
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

                <?php if((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo $aDataFilter['tShopNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopTo']; ?> : </span> <?php echo $aDataFilter['tShopNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo $aDataFilter['tPosCodeFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTo']; ?> : </span> <?php echo $aDataFilter['tPosCodeTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <?php if( (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มช่อง ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRackFrom']; ?> : </span> <?php echo $aDataFilter['tRackNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRackTo']; ?> : </span> <?php echo $aDataFilter['tRackNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>