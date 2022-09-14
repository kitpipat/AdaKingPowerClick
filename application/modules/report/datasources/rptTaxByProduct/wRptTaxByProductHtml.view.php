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
$oMTaxByProduct = $this->params['oMTaxByProduct'];

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
        /*border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;*/
    }

    .table>thead:first-child>tr:first-child>td:nth-child(1),
    .table>thead:first-child>tr:first-child>th:nth-child(1),
    .table>thead:first-child>tr:first-child>td:nth-child(2),
    .table>thead:first-child>tr:first-child>th:nth-child(2),
    .table>thead:first-child>tr:first-child>td:nth-child(3),
    .table>thead:first-child>tr:first-child>th:nth-child(3),
    .table>thead:first-child>tr:first-child>td:nth-child(4),
    .table>thead:first-child>tr:first-child>th:nth-child(4),
    .table>thead:first-child>tr:first-child>td:nth-child(5),
    .table>thead:first-child>tr:first-child>th:nth-child(5),
    .table>thead:first-child>tr:first-child>td:nth-child(6),
    .table>thead:first-child>tr:first-child>th:nth-child(6) {
        border-bottom: 1px dashed #ccc !important;
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

    .table tbody tr.xCNRptLastGroupTr,
    .table>tbody>tr.xCNRptLastGroupTr>td {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptSumFooterTrTop,
    .table>tbody>tr.xCNRptSumFooterTrTop>td {
        border: 0px solid black !important;
        border-top: 1px solid black !important;
    }

    .table tbody tr.xCNRptSumFooterTrBottom,
    .table>tbody>tr.xCNRptSumFooterTrBottom>td {
        border: 0px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tfoot>tr {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }


    /*แนวนอน*/
    /* @media print{@page {size: landscape}} */
    /*แนวตั้ง*/
    @media print {
        @page {
            size: portrait
        }
    }
</style>

<div id="odvRptSaleByBillHtml">
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
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1' || true) { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th nowrap class="text-left xCNRptColumnHeader" width="18%"><?php echo $aDataTextRef['tRptBillNo']; ?></th>
                                <th nowrap class="text-left xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptTaxSalePosDocRef']; ?></th>
                                <th nowrap class="text-left xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptCst']; ?></th>
                                <th nowrap style="border-right: 1px solid black !important;" nowrap class="text-left xCNRptColumnHeader" colspan="4"><?php echo $aDataTextRef['tRptDate']; ?></th>
                                <th nowrap class="text-right xCNRptColumnHeader" colspan="2">มูลค่า(จากระบบ)</th>
                                <th nowrap style="border-right: 1px solid black !important;" nowrap class="text-left xCNRptColumnHeader" colspan="2">มูลค่า(คำนวนใหม่)</th>
                                <th nowrap style="border-right: 1px solid black !important;"></th>
                                <th></th>
                            </tr>
                            <tr>
                                <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tSeqPdtCode']; ?></th>
                                <th nowrap class="text-left xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRptPdtName']; ?></th>
                                <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptQty']; ?></th>
                                <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPricePerUnit']; ?></th>
                                <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSales']; ?></th>
                                <th nowrap class="text-right xCNRptColumnHeader" style="border-right: 1px solid black !important;"><?php echo $aDataTextRef['tRptDiscount']; ?></th>
                                <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptVat'];?></th>
                                <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSeparateTax'];?></th>
                                <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptVat'];?></th>
                                <th nowrap style="border-right: 1px solid black !important;" nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSeparateTax'];?></th>
                                <th nowrap style="border-right: 1px solid black !important;" nowrap class="text-center xCNRptColumnHeader">ผลต่างภาษี</th>
                                <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptGrandSale']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php if (isset($aDataReport['raItems']) && !empty($aDataReport['raItems'])) { ?>
                                <?php
                                // Init Variable
                                $bIsRcFirst = true;
                                $tLastPdtList = '';
                                $nIndex = 1;

                                $nResultVat = 0;
                                $nResultSplitAmount = 0;
                                $nDiffVat = 0;


                                ?>
                                <?php foreach ($aDataReport['raItems'] as $nKey => $aValue) { ?>
                                  
                                    <?php
                                        // Set Data
                                        $tRptDocNo = $aValue["FTXshDocNo"];
                                        $tRptDocDate = date('Y-m-d', strtotime($aValue["FDXshDocDate"]));
                                        $tRptCstCode = $aValue["FTCstCode"];
                                        $tRptCstName = $aValue["FTCstName"];
                                        $tRptRefInt = $aValue['FTXshRefInt'];
                                        $tRptPdtCode = $aValue['FTPdtCode'];
                                        $tRptPdtName = $aValue['FTPdtName'];
                                        $tRptRcvName = $aValue['FTRcvName'];
                                        $tRptXrcRefNo1 = $aValue['FTXrcRefNo1'];
                                        $tRptBnkName = $aValue['FTBnkName'];
                                        $tRptPunName = $aValue['FTPunName'];

                                        $nRptXsdQty = $aValue['FCXsdQty'];
                                        $nRptXsdSetPrice = $aValue['FCXsdSetPrice'];
                                        $nRptXsdAmt = $aValue['FCXsdAmt'];
                                        $nRptXsdDis = $aValue['FCXsdDis'];
                                        $nRptXsdNet = $aValue['FCXsdNet'];

                                        $nRptXrcNet = empty($aValue['FCXrcNet']) ? 0 : $aValue['FCXrcNet'];
                                        $nRptSumXsdAmt = $aValue['FCXsdAmt_SubTotal'];
                                        $nRptSumXsdDis = $aValue['FCXsdDis_SubTotal'];
                                        $nRptSumXsdNet = $aValue['FCXsdNet_SubTotal'];

                                        $nGroupMember = $aValue["FNRptGroupMember"];
                                        $nRowPartID = $aValue["FNRowPartID"];

                                        $nRowType = $aValue['FNType'];
                                        $nCount_DT = $aValue['FNCount_DT'];
                                        $nCount_RC = $aValue['FNCount_RC'];

                                        //เพิ่ม Vat และ VatTable
                                        $nRptVat = $aValue['FCXshVat'];
                                        $nRptVatable = $aValue['FCXshVatable'];

                                        $nLastDT = $nCount_DT + 1;
                                        $nFirstRC = $nLastDT + 1;
                                        $nLastRC = $nLastDT + $nCount_RC;

                                    // ---------------------------------------------------------------------------------------------

                                        // คำนวน มูลค่า(คำนวนใหม่)
                                        $nAmtB4DisChg  = $aValue['FCXsdAmtB4DisChg']; //มูลค่ารวมก่อนลด
                                        $nNetAFDis     = $aValue['FCXsdNetAFDis'];
                                        $nVatType      = $aValue['FTXsdVatType'];   // ประเภทภาษี 1:มีภาษี, 2:ไม่มีภาษี
                                        $nVatRate      = $aValue['FCXsdVatRate'];   //อัตราภาษี ณ. ซื้อ
                                        $nVATInOrEx    = $aValue['FTXshVATInOrEx']; //ภาษีมูลค่าเพิ่ม 1:รวมใน, 2:แยกนอก
                                        $nDocType      = $aValue['FNXshDocType'];




                                        //หาภาษี มูลค่า(คำนวนใหม่)
                                        if($nVatType == 1){
                                            if($nVATInOrEx == 1){
                                                $nResultVat = $nNetAFDis-(($nNetAFDis*100)/(100+$nVatRate));   //รวมใน
                                                
                                            }else if($nVATInOrEx == 2){
                                                $nResultVat   = (($nNetAFDis*(100+$nVatRate))/100)-$nNetAFDis; //แยกนอก
                                            }
                                        }else{
                                            $nResultVat = 0.00;
                                        }
                                        
                                        //ยอดแยกภาษี มูลค่า(คำนวนใหม่)
                                        $nResultSplitAmount = $nNetAFDis - $nResultVat;

                                        
                                        // Type 9 R=คืน Type 1=ขาย
                                        if($nDocType == 9){
                                          $nResultVat =  $nResultVat * (-1);
                                        }

                                        $nDiffVat = str_replace(',','',number_format($nRptVat,2, '.', '')) - str_replace(',','',number_format($nResultVat,2, '.', ''));

                                    // ---------------------------------------------------------------------------------------------

                                    ?>

                                    <?php if ($nRowPartID == 1) { // Display Group Header ?>
                                        <?php $nIndex = 1; ?>
                                        <tr>
                                            <td class="xCNRptGrouPing"><?php echo $tRptDocNo; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptRefInt; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo empty($tRptCstCode) ? $aDataTextRef['tRptCstNormal'] : '(' . $tRptCstCode . ')' . $tRptCstName; ?></td>
                                            <td class="xCNRptGrouPing" colspan="2"><?php echo $tRptDocDate; ?></td>
                                            <td></td>
                                            <td style="border-right: 1px solid black !important;"></td>
                                            <td style="border-right: 1px solid black !important;" colspan="4"></td>
                                            <td style="border-right: 1px solid black !important;"></td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($nRowPartID > 1 && $nRowType == 2) { // Display Body Data ?>
                                        <tr class="<?php echo $tLastPdtList; ?>">
                                            <td class="xCNRptDetail"><?php echo $nIndex . ' '; ?><?php echo $tRptPdtCode; ?></td>
                                            <td class="xCNRptDetail" colspan="2"><?php echo $tRptPdtName; ?></td>
                                            <td class="xCNRptDetail"><?php echo number_format($nRptXsdQty, $nOptDecimalShow); ?> <?php echo $tRptPunName; ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($nRptXsdSetPrice, $nOptDecimalShow); ?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($nRptXsdAmt, $nOptDecimalShow); ?></td>
                                            <td style="border-right: 1px solid black !important;" class="text-right xCNRptDetail"><?php echo number_format($nRptXsdDis, $nOptDecimalShow); ?></td>

                                            <!-- เพิ่ม Vat และ Vatable เข้าไป -->
                                            <td class="text-right xCNRptDetail"><?php echo number_format($nRptVat, $nOptDecimalShow);?></td>    
                                            <td class="text-right xCNRptDetail"><?php echo number_format($nRptVatable, $nOptDecimalShow);?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($nResultVat, $nOptDecimalShow);?></td>
                                            <td style="border-right: 1px solid black !important;" class="text-right xCNRptDetail"><?php echo number_format($nResultSplitAmount, $nOptDecimalShow);?></td>
                                            <td style="border-right: 1px solid black !important;" class="text-right xCNRptDetail"><?php echo number_format($nDiffVat, $nOptDecimalShow);?></td>
                                            <td class="text-right xCNRptDetail"><?php echo number_format($nRptXsdNet, $nOptDecimalShow); ?></td>
                                        </tr>
                                        <?php $nIndex++; ?>
                                    <?php } ?>

                                    <?php if ($nRowType == 3 && $nFirstRC == $nRowPartID) { // Display Sub Sum RC ?>
                                        <?php $bIsRcFirst = false; ?>
                                    <?php } ?>

                                    <?php if ($nRowType == 3 && $nCount_RC > 1) { // Display Sub Sum RC ?>
                                        <tr>
                                            <!-- <td class="xCNRptGrouPing" colspan="5"><?php //echo $tRptRcvName; ?> <?php //echo ' ' . $tRptXrcRefNo1 . $tRptBnkName . ' : ' . number_format($nRptXrcNet, $nOptDecimalShow); ?> บาท</td> -->
                                            <td class="text-right xCNRptGrouPing"></td>
                                            <td class="text-right xCNRptGrouPing"></td>
                                        </tr>
                                    <?php } ?>

                                    <?php if ($nRowPartID == $nGroupMember && $nRowType == 3 && !$bIsRcFirst) { // Display Sub Sum HD ?>
                                        <?php
                                        $bIsRcFirst = true;
                                        $aGetHDParams = [
                                            'tDocNo' => $tRptDocNo,
                                            'tCompName' => $tCompName,
                                            'tRptCode' => $tRptCode,
                                            'tUserSessionID' => $tUserSessionID,
                                            'tPosType' => $tPosType
                                        ];
                                        $aHD = $oMTaxByProduct->FMaMRPTGetHDByDocNo($aGetHDParams);
                                        ?>
                                        <tr class="xCNRptLastGroupTr">
                                            <td style="padding:0px; margin:0px;" class="xCNRptGrouPing" colspan="14"></td>
                                        </tr>
                                    <?php } ?>

                                <?php } ?>

                                <?php if ($bIsLastPage) { // Display Summary Footer ?>
                                    <?php
                                    $aGetHDParams = [
                                        'tDocNo' => $tRptDocNo,
                                        'tCompName' => $tCompName,
                                        'tRptCode' => $tRptCode,
                                        'tUserSessionID' => $tUserSessionID,
                                        'tPosType' => $tPosType
                                    ];

                                    $aSumFooter = $oMTaxByProduct->FMaMRPTSumFooterAll($aGetHDParams);

                                        // $nSumVat = 7;

                                        // // มูลค่า(คำนวนใหม่)
                                        // //New ภาษี 
                                        // $nResSumFooter     = $aSumFooter['FCXsdAmt_SumFooter'] - $aSumFooter['FCXshVat_SumFooter'];
                                        // $nSumFooterNewVat  =  $nResSumFooter * $nSumVat / 100;

                                        // // มูลค่า(คำนวนใหม่)
                                        // // ยอดแยกภาษี	
                                        // $nSumFooterNewVatable = $aSumFooter['FCXsdAmt_SumFooter'] - $nSumFooterNewVat;

                                        // // ผลต่าง
                                        // $nSumFooterDiff = $aSumFooter['FCXshVat_SumFooter'] - $nSumFooterNewVat;


                                    ?>
                                    <!-- <tr class="xCNRptSumFooterTrTop">
                                        <td  style="border-right: 1px solid black !important;" class="xCNRptSumFooter" colspan="7"><?php //echo $aDataTextRef['tRptTotalAllSale']; ?></td>
                                      
                                        <td class="text-right xCNRptSumFooter"><?php //echo number_format($aSumFooter['FCXshVat_SumFooter'], $nOptDecimalShow); ?></td>
                                        <td class="text-right xCNRptSumFooter"><?php //echo number_format($aSumFooter['FCXshVatable_SumFooter'], $nOptDecimalShow); ?></td>

                                        <td class="text-right xCNRptSumFooter"><?php //echo number_format($nSumFooterNewVat, $nOptDecimalShow);?></td>
                                        <td style="border-right: 1px solid black !important;" class="text-right xCNRptSumFooter"><?php //echo number_format($nSumFooterNewVatable, $nOptDecimalShow);?></td>
                                        <td style="border-right: 1px solid black !important;" class="text-right xCNRptSumFooter"><?php //echo number_format($nSumFooterDiff, $nOptDecimalShow);?></td>

                                        <td class="text-right xCNRptSumFooter"><?php //echo number_format($aSumFooter['FCXsdNet_SumFooter'], $nOptDecimalShow); ?></td>
                                    </tr> -->
                                    <tr class="xCNRptSumFooterTrBottom">
                                        <td style="padding:0px; margin:0px;" class="xCNRptSumFooter" colspan="13"></td>
                                    </tr>
                                <?php } ?>

                            <?php } else { ?>
                                <tr>
                                    <td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptNoData']; ?></td>
                                </tr>
                            <?php } ?>
                        </tbody>
                    </table>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="text-left xCNRptColumnHeader" width="17%"><?php echo $aDataTextRef['tRptBillNo']; ?></th>
                                <th class="text-left xCNRptColumnHeader" width="20%"><?php echo $aDataTextRef['tRptTaxSalePosDocRef']; ?></th>
                                <th class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptCst']; ?></th>
                                <th class="text-left xCNRptColumnHeader" colspan="2" width="20%"><?php echo $aDataTextRef['tRptDate']; ?></th>
                                <th class="text-left xCNRptColumnHeader" colspan="3" width="30%"></th>
                            </tr>
                            <tr>
                                <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tSeqPdtCode']; ?></th>
                                <th class="text-left xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRptPdtName']; ?></th>
                                <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptQty']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPricePerUnit']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSales']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptDiscount']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptGrandSale']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
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
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
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
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
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
            
            <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
            <?php if ((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo $aDataFilter['tCstNameFrom']; ?></label>
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo']; ?> : </span> <?php echo $aDataFilter['tCstNameTo']; ?></label>
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