<?php

$nCurrentPage = $this->params['aDataReturn']['rnCurrentPage'];
$nAllPage = $this->params['aDataReturn']['rnAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
$tCompName = $this->params['tCompName'];
$tRptCode = $this->params['tRptCode'];
$tUserSessionID = $this->params['tUserSessionID'];

$bIsLastPage = ($nAllPage == $nCurrentPage);
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
        /*border-bottom: 0px transparent !important;
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;*/
    }

    .table>thead:first-child>tr:first-child>td:nth-child(1),
    .table>thead:first-child>tr:first-child>th:nth-child(1),
    .table>thead:first-child>tr:first-child>td:nth-child(2),
    .table>thead:first-child>tr:first-child>th:nth-child(2),
    .table>thead:first-child>tr:first-child>td:nth-child(3),
    .table>thead:first-child>tr:first-child>th:nth-child(3) {
        /*border-bottom: 1px dashed #ccc !important;*/
        border-bottom: 1px solid black !important;
    }

    .table>thead:first-child>tr:last-child>td,
    .table>thead:first-child>tr:last-child>th {
        /*border-top: 1px solid black !important;*/
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }

    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(3),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(4),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(5),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(6),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(7) {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptLastDetailBottomTr,
    .table>tbody>tr.xCNRptLastDetailBottomTr>td {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptLastGroupTr,
    .table>tbody>tr.xCNRptLastGroupTr>td {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptSumFooterTr,
    .table>tbody>tr.xCNRptSumFooterTr>td {
        border: 0px solid black !important;
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tfoot>tr {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }

    .table>thead>tr>th.xCNAlignMiddle {
        vertical-align: middle;
    }

    .table>thead>tr>th.xCNTextIndentA,.table>tbody>tr>td.xCNTextIndentA{
        text-indent: 10px;
    }

    .table>thead>tr>th.xCNTextIndentB,.table>tbody>tr>td.xCNTextIndentB{
        text-indent: 50px;
    }

    /*แนวนอน*/
    /*@media print{@page {size: landscape}}*/
    /*แนวตั้ง*/
    @media print {
        @page {
            size: portrait
        }
    }
</style>

<div id="odvRptPaymentByBillHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">

            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label> <!-- . ' ' . $aCompanyInfo['FTAddV1Village'] -->
                                    <?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?>
                                    <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxNo'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>

                        <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo $aDataFilter['tBchNameFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']; ?> : </span> <?php echo $aDataFilter['tBchNameTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left xCNRptColumnHeader" width="20%"><?php echo $aDataTextRef['tRptXshDocNo']; ?></th>
                                <th class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptDocRef']; ?></th>
                                <th class="text-left xCNRptColumnHeader" width="25%"><?php echo $aDataTextRef['tRptDateDocument']; ?></th>
                                <th class="text-right xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptAmount']; ?></th>
                                <th class="text-right xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptPaymentToTal']; ?></th>
                                <th class="text-right xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptOutstandingBalance']; ?></th>
                            </tr>
                            <tr>
                                <th class="text-left xCNRptColumnHeader xCNTextIndentA"><?php echo $aDataTextRef['tRptPaymentDocNo']; ?></th>
                                <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPaymentDate']; ?></th>
                                <th class="text-left xCNRptColumnHeader xCNTextIndentB"><?php echo $aDataTextRef['tRptCst']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptValue']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptDiscount']; ?></th>
                                <th class="text-right xCNRptColumnHeader"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) { ?>
                                <?php foreach ($aDataReport['raItems'] as $nKey => $aValue) { ?>
                                    <?php
                                        // Init Variable
                                        $tDocDateHD = empty($aValue['FDXshDocDate']) ? "" : date("d/m/Y", strtotime($aValue['FDXshDocDate'])); // วันที่เอกสาร
                                        $tDocDateDT = empty($aValue['FDXrcDocDate']) ? "" : date("d/m/Y", strtotime($aValue['FDXrcDocDate'])); // วันที่เอกสาร
                                        $nRowPartID = $aValue["FNRowPartID"]; 
                                        $nGroupMember = $aValue["FNRptGroupMember"];
                                        $tDocType = $aValue['FTXshDocType']; 
                                        
                                        $tCstCode = $aValue['FTCstCode'];
                                        $tCstName = $aValue['FTCstName'];
                                        $tCstFull = empty($tCstCode) ? $aDataTextRef['tRptCstNormal'] : '('.$tCstCode.') '.$tCstName;

                                        $cPayHD = empty($aValue['FCXdtPay']) ? 0 : $aValue['FCXdtPay']; // จำนวนเงิน
                                        $cGrandHD = empty($aValue['FCXshGrand']) ? 0 : $aValue['FCXshGrand']; // ยอดชำระรวม HD
                                        $cLeftHD = empty($aValue['FCXshLeft']) ? 0 : $aValue['FCXshLeft']; // ยอดค้างชำระ

                                        $cNetDT = empty($aValue['FCXrcNet']) ? 0 : $aValue['FCXrcNet']; // มูลค่า
                                        $cDisDT = empty($aValue['FCXrcDis']) ? 0 : $aValue['FCXrcDis']; // ส่วนลด
                                        $cLeftDT = empty($aValue['FCXrcLeft']) ? 0 : $aValue['FCXrcLeft']; // ยอดค้างชำระ DT

                                        $cPay_Footer = empty($aValue['FCXdtPay_Footer']) ? 0 : $aValue['FCXdtPay_Footer'];
                                        $cGrand_Footer = empty($aValue['FCXshGrand_Footer']) ? 0 : $aValue['FCXshGrand_Footer'];
                                        $cLeft_Footer = empty($aValue['FCXshLeft_Footer']) ? 0 : $aValue['FCXshLeft_Footer'];
                                    ?>

                                    <?php if ($tDocType == 1 && $nRowPartID = 1) { // Display Group Header?>
                                        <tr>
                                            <td class="xCNRptGrouPing"><?php echo $aValue['FTXshDocNo']; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $aValue['FTXshRefInt']; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tDocDateHD; ?></td>
                                            <td class="text-right xCNRptGrouPing"><?php echo number_format($cPayHD, $nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptGrouPing"><?php echo number_format($cGrandHD, $nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptGrouPing"><?php echo number_format($cLeftHD, $nOptDecimalShow); ?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($tDocType == 2 && $nRowPartID > 1) { // Display Data ?>    
                                        <tr class="<?php echo ($nRowPartID == $nGroupMember) ? 'xCNRptLastDetailBottomTr' : ''; ?>">
                                            <td class="xCNRptDetail xCNTextIndentA"><?php echo $aValue['FTXrcDocNo']; ?></td>
                                            <td class="xCNRptDetail"><?php echo $tDocDateDT; ?></td>
                                            <td class="xCNRptDetail xCNTextIndentB"><?php echo $tCstFull; ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($cNetDT, $nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($cDisDT, $nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($cLeftDT, $nOptDecimalShow); ?></td>
                                        </tr>
                                    <?php } ?>
                                <?php } ?>

                                <?php if ($bIsLastPage) { // Display Summary Footer ?>
                                    <tr class="xCNRptSumFooterTr">
                                        <td class="xCNRptSumFooter" colspan="3"><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cPay_Footer, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cGrand_Footer, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cLeft_Footer, $nOptDecimalShow); ?></td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptNoData']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left xCNRptColumnHeader" width="20%"><?php echo $aDataTextRef['tRptXshDocNo']; ?></th>
                                <th class="text-left xCNRptColumnHeader" width="20%"><?php echo $aDataTextRef['tRptDocRef']; ?></th>
                                <th class="text-left xCNRptColumnHeader" width="30%"><?php echo $aDataTextRef['tRptDateDocument']; ?></th>
                                <th class="text-right xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptAmount']; ?></th>
                                <th class="text-right xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptPaymentToTal']; ?></th>
                                <th class="text-right xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptOutstandingBalance']; ?></th>
                            </tr>
                            <tr>
                                <th class="text-left xCNRptColumnHeader xCNTextIndentA"><?php echo $aDataTextRef['tRptPaymentDocNo']; ?></th>
                                <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPaymentDate']; ?></th>
                                <th class="text-left xCNRptColumnHeader xCNTextIndentB"><?php echo $aDataTextRef['tRptCst']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptValue']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptDiscount']; ?></th>
                                <th class="text-right xCNRptColumnHeader"></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }; ?>
            </div>

            <?php if ($bIsLastPage) { // Display Last Page ?>        
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>

                <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุระกิจ ============================ -->
                <?php if((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo $aDataFilter['tMerNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerTo']; ?> : </span> <?php echo $aDataFilter['tMerNameTo']; ?></label>
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
                <?php if((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo $aDataFilter['tShpNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopTo']; ?> : </span> <?php echo $aDataFilter['tShpNameTo']; ?></label>
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

                <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                <?php if((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo $aDataFilter['tPosCodeFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTo']; ?> : </span> <?php echo $aDataFilter['tPosCodeTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
                <?php if ((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo $aDataFilter['tCstNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo']; ?> : </span> <?php echo $aDataFilter['tCstNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tCstCodeSelect']) && !empty($aDataFilter['tCstCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCstStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCstNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php } ?>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $nCurrentPage . ' / ' . $nAllPage; ?></label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>