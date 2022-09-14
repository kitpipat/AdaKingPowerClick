<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];
?>
<style>
    /** Set Media Print */
    @media print{@page {size: A4 landscape;}}

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }
</style>
<div id="odvRptSaleTaxByMonthlyHtml">
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
                    <?php if((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?> 

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <?php  $tTextMonth     = 'tRptMonth'.date("m", strtotime($aDataFilter['tDocDateFrom'])); ?>
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMonth']?></span>   <label><?= $aDataTextRef[$tTextMonth] ?></label>&nbsp;
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptYear']?></span>   <label><?= date("Y", strtotime($aDataFilter['tDocDateFrom'])) ?></label>&nbsp;
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php /*if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']?> : </span>   <label><?= date("d/m/Y", strtotime($aDataFilter['tDocDateFrom'])); ?></label>&nbsp;
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']?> : </span>   <label><?= date("d/m/Y", strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;*/ ?>

                    <?php /*if ((isset($aDataFilter['tMonth']) && !empty($aDataFilter['tMonth']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล เดือน ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <?php
                                        $tTextMonth = 'tRptMonth'.$aDataFilter['tMonth'];
                                    ?>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMonth']?></label> <label><?php echo $aDataTextRef[$tTextMonth];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;*/ ?>

                    <?php /*if ((isset($aDataFilter['tYear']) && !empty($aDataFilter['tYear']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ปี ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptYear']?></label> <label><?php echo $aDataFilter['tYear'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;*/ ?>
                
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
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
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:5%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyPos'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:5%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyPayment'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:10%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyEjNo'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:25%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyProduct'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:10%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyFirstName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:10%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyLastName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="width:10%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyIDCardNo'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"  style="width:5%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyVatTable'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"  style="width:5%;"><?php echo @$aDataTextRef['tRptSaleTaxByMonthlyVatAmount'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])): ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue): ?>
                                <?php
                                    $nRowID         = $aValue['FNRowID'];
                                    $nRowDataAll    = $aValue['FNDataAll_Footer'];
                                    $nRowPartID     = $aValue['FNRowPartID'];
                                    $nRowGroupData  = $aValue['FNRptGroupMember'];
                                ?>
                                <tr>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTPosCode'];?></td>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTFmtName'];?></td>
                                    <td class="text-center  xCNRptDetail"><?php echo date('d/m/Y',strtotime(@$aValue['FDXshDocDate']));?></td>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTXshDocNo'];?></td>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTPdtName'];?></td>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTCstName'];?></td>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTCstLastName'];?></td>
                                    <td class="text-left    xCNRptDetail"><?php echo @$aValue['FTCstCode'];?></td>
                                    <td class="text-right   xCNRptDetail"><?php echo number_format($aValue['FCXsdVatable'],$nOptDecimalShow);?></td>
                                    <td class="text-right   xCNRptDetail"><?php echo number_format($aValue['FCXsdVat'],$nOptDecimalShow);?></td>
                                </tr>
                                <?php
                                    // Group Sub Footer
                                    if($nRowPartID == $nRowGroupData){
                                        $tTextTotal         = $aDataTextRef['tRptSaleTaxByMonthlyTotal'];
                                        $tTextPos           = $aDataTextRef['tRptSaleTaxByMonthlyPos'];
                                        $tTextPayment       = $aDataTextRef['tRptSaleTaxByMonthlyPayment'];
                                        $tFooterSubRcv      = $tTextTotal." (".$tTextPayment.": ".$aValue['FTFmtName'].")";
                                        $cXsdVatableSubRcv  = floatval($aValue['FCXsdVatable_SubTotal']);
                                        $cXsdVatSubRcv      = floatval($aValue['FCXsdVat_SubTotal']);
                                        $aGrpDataSubRcv     = array($tFooterSubRcv,$cXsdVatableSubRcv,$cXsdVatSubRcv);
                                        echo "<tr style='border-top:1px dashed black !important;border-bottom:1px dashed black !important;'>";
                                            for($i = 0;$i < FCNnHSizeOf($aGrpDataSubRcv); $i++){
                                                if(is_float($aGrpDataSubRcv[$i])){
                                                    echo "<td class='xCNRptGrouPing text-right' style='padding: 5px;'>".number_format($aGrpDataSubRcv[$i],$nOptDecimalShow)."</td>";
                                                }else{
                                                    echo "<td class='xCNRptGrouPing text-left'  style='padding: 5px;' colspan='8'>".$aGrpDataSubRcv[$i]."</td>";
                                                }
                                            }
                                        echo "</tr>";
                                    }

                                    // Group Footer
                                    if($nRowID == $nRowDataAll && $nPageNo == $nTotalPage){
                                        $tFooterAll         = $aDataTextRef['tRptSaleTaxByMonthlyTotalAll'];
                                        $cXsdVatableFooter  = floatval($aValue['FCXsdVatable_Footer']);
                                        $cXsdVatFooter      = floatval($aValue['FCXsdVat_Footer']);
                                        $aGrpDataFooterAll  = array($tFooterAll,$cXsdVatableFooter,$cXsdVatFooter);
                                        echo "<tr style='border-top: 1px solid black !important;border-bottom: 1px solid black !important;'>";
                                            for($i = 0;$i < FCNnHSizeOf($aGrpDataFooterAll); $i++) {
                                                if(is_float($aGrpDataFooterAll[$i])){
                                                    echo "<td class='xCNRptGrouPing text-right' style='padding: 5px;'>".number_format($aGrpDataFooterAll[$i],$nOptDecimalShow)."</td>";
                                                }else{
                                                    echo "<td class='xCNRptGrouPing text-left'  style='padding: 5px;' colspan='8'>".$aGrpDataFooterAll[$i]."</td>";
                                                }
                                            }
                                        echo "</tr>";
                                    }
                                ?>
                            <?php endforeach; ?>
                        <?php else:  ?>
                            <tr><td class='text-center xCNRptColumnHeader' colspan='100%'><?php echo @$aDataTextRef['tRptNotFoundData'];?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
                <?php if((isset($aDataFilter['tMerCodeFrom'])   && !empty($aDataFilter['tMerCodeFrom']))    && (isset($aDataFilter['tMerCodeTo'])   && !empty($aDataFilter['tMerCodeTo']))
                    || (isset($aDataFilter['tShpCodeFrom'])     && !empty($aDataFilter['tShpCodeFrom']))    && (isset($aDataFilter['tShpCodeTo'])   && !empty($aDataFilter['tShpCodeTo']))
                    || (isset($aDataFilter['tPosCodeFrom'])     && !empty($aDataFilter['tPosCodeFrom']))    && (isset($aDataFilter['tPosCodeTo'])   && !empty($aDataFilter['tPosCodeTo']))
                    || (isset($aDataFilter['tRcvCodeFrom'])     && !empty($aDataFilter['tRcvCodeFrom']))    && (isset($aDataFilter['tRcvCodeTo'])   && !empty($aDataFilter['tRcvCodeTo']))
                    || (isset($aDataFilter['tBchCodeSelect'])   && !empty($aDataFilter['tBchCodeSelect']))
                    || (isset($aDataFilter['tMerCodeSelect'])   && !empty($aDataFilter['tMerCodeSelect']))
                    || (isset($aDataFilter['tShpCodeSelect'])   && !empty($aDataFilter['tShpCodeSelect']))
                    || (isset($aDataFilter['tPosCodeSelect'])   && !empty($aDataFilter['tPosCodeSelect']))
                ) { ?>
                    <div class="xCNRptFilterTitle">
                        <div class="text-left">
                            <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
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

                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
                    <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="text-left xCNRptFilter">
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvFrom'].' : </span>'.$aDataFilter['tRcvNameFrom'];?></label>
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvTo'].' : </span>'.$aDataFilter['tRcvNameTo'];?></label>
                            </div>
                        </div>
                    <?php endif; ?> 

                <?php }; ?>
            <?php endif;?>
        </div>
    </div>
</div>