<?php
    $aDataReport        = $aDataViewRpt['aDataReport'];
    $aDataTextRef       = $aDataViewRpt['aDataTextRef'];
    $aDataFilter        = $aDataViewRpt['aDataFilter'];
    $nOptDecimalShow    = $aDataViewRpt['nOptDecimalShow'];
    $nPageNo            = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage         = $aDataReport["aPagination"]["nTotalPage"];
?>
<style>
    @media print{@page {size: landscape}}   

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
    }
</style>
<div id="odvRptRentAmountFolloweCourierHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
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
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
            
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourSerailPos']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourUser']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourDocno']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourDocDate']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourDateGet']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourLoginTo']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourStaPayment']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%"><?php echo $aDataTextRef['tRptRentAmtFolCourAmtPayment']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                        $aData          = $aDataReport["aRptData"];
                        $aPagination    = $aDataReport["aPagination"];
                        ?>
                        <?php if ($aData) { ?>
                            <?php
                            $aDataReport            = $aData["aData"];
                            $aSumData               = $aData["aSumData"];
                            $nPerPage               = $aPagination["nPerPage"];
                            $nNumRowDisplay         = 0;
                            $nLastRecodeOfPos       = 0;
                            $nFCXshSumAllPrePaid    = 0;
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
                                                <td nowrap class="text-left <?php echo $aSumData[$nI]["FNXshNumDoc"]; ?>" style="width:10%" >
                                                    <?php echo $aSumData[$nI]["FTPosCode"]; ?>
                                                </td>
                                            <?php } else { ?>
                                                <td></td>
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
                                                <?php echo date("Y/m/d", strtotime($aDataReport[$nJ]["FDXshDatePick"])); ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php echo $aDataReport[$nJ]["FTXshToLogin"]; ?>
                                            </td>
                                            <td nowrap class="text-left" style="width:10%">
                                                <?php
                                                if ($aDataReport[$nJ]["FTXshStaPaid"] == 1) {
                                                    echo $aDataTextRef['tRptRentAmtFolCourStaPaymentNoPay'];
                                                } else if ($aDataReport[$nJ]["FTXshStaPaid"] == 2) {
                                                    echo $aDataTextRef['tRptRentAmtFolCourStaPaymentSome'];
                                                }if ($aDataReport[$nJ]["FTXshStaPaid"] == 3) {
                                                    echo $aDataTextRef['tRptRentAmtFolCourStaPaymentAlready'];
                                                }
                                                ?>
                                            </td>
                                            <td nowrap class="text-right" style="width:10%">
                                                <?php
                                                if ($aDataReport[$nJ]["FCXshPrePaid"] == "") {
                                                    echo number_format("0", $nOptDecimalShow);
                                                } else {
                                                    echo number_format($aDataReport[$nJ]["FCXshPrePaid"], $nOptDecimalShow);
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
                                        <td nowrap colspan="7" class="text-left" style="border-top:1px solid #333 !important; border-bottom:1px solid #333 !important; background-color: #CFE2F3; padding: 4px;">
                                            <?php echo $aDataTextRef['tRptRentAmtFolCourSumText']; ?>
                                        </td>
                                        <td nowrap class="text-right" style="border-top:1px solid #333 !important; border-bottom:1px solid #333 !important; background-color: #CFE2F3; padding: 4px;">
                                            <?php echo number_format($aSumData[$nI]["FCXshSumPrePaid"], $nOptDecimalShow); ?>
                                        </td>
                                    </tr>
                                <?php } ?>
                            <?php } ?>
                            <?php if ($aPagination["nTotalPage"] == $aPagination["nDisplayPage"]) { ?>
                                <tr class="xCNTrFooter">
                                    <td nowrap colspan="7" class="text-left" style="border-top:1px solid #333 !important; border-bottom:1px solid #333 !important; background-color: #CFE2F3; padding: 4px;">
                                        <?php echo $aDataTextRef['tRptRentAmtFolCourSumTextLast']; ?>
                                    </td>
                                    <td nowrap class="text-right" style="border-top:1px solid #333 !important; border-bottom:1px solid #333 !important; background-color: #CFE2F3; ; padding: 4px;">
                                        <?php echo number_format($nFCXshSumAllPrePaid, $nOptDecimalShow); ?>
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tCMNNotFoundData']; ?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo @$aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if((isset($aDataFilter['tCourierCodeFrom']) && !empty($aDataFilter['tCourierCodeFrom'])) && (isset($aDataFilter['tCourierCodeTo']) && !empty($aDataFilter['tCourierCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล บริษัทขนส่ง ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCourierFrom']; ?> : </span> <?php echo $aDataFilter['tCourierNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCourierTo']; ?> : </span> <?php echo $aDataFilter['tCourierNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
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
