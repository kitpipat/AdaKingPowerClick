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
$tPosType = $this->params['aFilterReport']['tPosType'];
$tUserSessionID = $this->params['tUserSessionID'];
$oMRptProductSaleOfWeek = $this->params['oMRptProductSaleOfWeek'];

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
        border-bottom: 0px transparent !important;
        border-bottom : 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
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

    /*แนวนอน*/
    @media print{@page {size: landscape}}
    /*แนวตั้ง*/
    /* @media print {
        @page {
            size: portrait
        }
    } */
</style>

<div id="odvRptProductSaleOfWeekHtml">
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
                                <label>
                                    <?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?>
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

                        <!-- ============================ ฟิวเตอร์ข้อมูล ปี เดือน ============================ -->
                        <?php if ((isset($aDataFilter['tYear']) && !empty($aDataFilter['tYear'])) && isset($aDataFilter['tMonth']) && !empty($aDataFilter['tMonth'])) : ?>
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptYear']; ?> </span> <?php echo  $aDataFilter['tYear']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMonth']; ?> </span> <?php echo language('report/report/report', 'tRptMonth'.$aDataFilter['tMonth'])?></label>
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
                                <th width="10%" class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptWeek']; ?></th>
                                <th width="15%" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWBillAll']; ?></th>
                                <th width="15%" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWWeekPriceAll']; ?></th>
                                <th width="15%" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWVendingQR']; ?></th>
                                <th width="15%" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWPOSCash']; ?></th>
                                <th width="15%" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWQR']; ?></th>
                                <th width="15%" class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWEDC']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) { ?>
                                <?php
                                // Init Variable
                                $nFNXshTotalBill_Footer = 0;
                                $cFCXshGrand_Footer = 0.00;
                                $cFCXrcNetVDQR_Footer = 0.00;
                                $cFCXrcNetPosCash_Footer = 0.00;
                                $cFCXrcNetPosQR_Footer = 0.00;
                                $cFCXrcNetPosEDC_Footer = 0.00
                                ?>
                                <?php foreach ($aDataReport['raItems'] as $nKey => $aValue) { ?>
                                    <?php
                                    // Set Data
                                    $cFNXshTotalBill = empty($aValue['FNXshTotalBill']) ? 0 : $aValue['FNXshTotalBill'];
                                    $cFCXshGrand = empty($aValue['FCXshGrand']) ? 0 : $aValue['FCXshGrand'];
                                    $cFCXrcNetVDQR = empty($aValue['FCXrcNetVDQR']) ? 0 : $aValue['FCXrcNetVDQR'];
                                    $cFCXrcNetPosCash = empty($aValue['FCXrcNetPosCash']) ? 0 : $aValue['FCXrcNetPosCash'];
                                    $cFCXrcNetPosQR = empty($aValue['FCXrcNetPosQR']) ? 0 : $aValue['FCXrcNetPosQR'];
                                    $cFCXrcNetPosEDC = empty($aValue['FCXrcNetPosEDC']) ? 0 : $aValue['FCXrcNetPosEDC'];
                                    ?>
                                    <tr>
                                        <td class="text-center xCNRptDetail"><?php echo $aValue['FDXshDocWeek']; ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($cFNXshTotalBill, 0); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($cFCXshGrand, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($cFCXrcNetVDQR, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($cFCXrcNetPosCash, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($cFCXrcNetPosQR, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptDetail"><?php echo number_format($cFCXrcNetPosEDC, $nOptDecimalShow); ?></td>
                                    </tr>
                                    <?php 
                                    $nFNXshTotalBill_Footer = $aValue['FNXshTotalBill_Footer'];
                                    $cFCXshGrand_Footer = $aValue['FCXshGrand_Footer'];
                                    $cFCXrcNetVDQR_Footer = $aValue['FCXrcNetVDQR_Footer'];
                                    $cFCXrcNetPosCash_Footer = $aValue['FCXrcNetPosCash_Footer'];
                                    $cFCXrcNetPosQR_Footer = $aValue['FCXrcNetPosQR_Footer'];
                                    $cFCXrcNetPosEDC_Footer = $aValue['FCXrcNetPosEDC_Footer'];
                                    ?>
                                <?php } ?>

                                <?php if ($bIsLastPage) { // Display Summary Footer ?>
                                    <tr class="xCNRptSumFooterTr">
                                        <td class="text-left xCNRptSumFooter"><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($nFNXshTotalBill_Footer, 0); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cFCXshGrand_Footer, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cFCXrcNetVDQR_Footer, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cFCXrcNetPosCash_Footer, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cFCXrcNetPosQR_Footer, $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php echo number_format($cFCXrcNetPosEDC_Footer, $nOptDecimalShow); ?></td>
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
                                <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptWeek']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWBillAll']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWWeekPriceAll']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWVendingQR']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWPOSCash']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWQR']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPDTSOWEDC']; ?></th>
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
   
            <div class="xCNRptFilterTitle">
                <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
            </div>
            <?php
                $tPosTypeText = '';
                if (empty($tPosType)) {
                    $tPosTypeText = $aDataTextRef['tRptPosType'];
                }
                if ($tPosType == '1') {
                    $tPosTypeText = $aDataTextRef['tRptPosType1'];
                }
                if ($tPosType == '2') {
                    $tPosTypeText = $aDataTextRef['tRptPosType2'];
                }
            ?>
            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทเครื่องจุดขาย ============================ -->
            <div class="xCNRptFilterBox">
                <div class="xCNRptFilter">
                    <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName']; ?> : </span> <?php echo $tPosTypeText; ?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
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