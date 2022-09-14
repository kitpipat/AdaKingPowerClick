<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];
?>
<style>
     @media print{@page {size: A4 portrait;}}

    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .xWRptTextIdent{
        text-indent: 30px !important;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: dashed 1px black !important; 
    }

    #otrRptSumFooter{
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }
</style>
<div id="odvRptLockerPaymentHtml">
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
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่จอง ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))): ?>
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
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptLockerPaymentXrceDocNo'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptLockerPaymentXrcDocDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" colspan="3"><?php echo @$aDataTextRef['tRptLockerPaymentXrcCustomer'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptLockerPaymentXrcNet'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptLockerPaymentXrcDis'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptLockerPaymentXrcGrand'];?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-left xCNRptColumnHeader" colspan="2"><?php echo @$aDataTextRef['tRptLockerPaymentXsdDocNo'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptLockerPaymentXsdDocDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptLockerPaymentXsdNet'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptLockerPaymentXsdPayB4'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptLockerPaymentXsdRefPaid'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptLockerPaymentXsdGrand'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptLockerPaymentXsdLeft'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])): ?>
                            <?php
                                $tRptGrpXrcDocNo    = "";
                            ?>
                            <?php foreach($aDataReport['aRptData'] as $nKey => $aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $tBchCode       = $aValue["FTBchCode"];
                                    $tXrcDocNo      = $aValue["FTXrcDocNo"];
                                    $tXshDocType    = $aValue["FTXshDocType"];
                                    $tXrcDocDate    = $aValue["FDXrcDocDate"];
                                    $tCstCode       = $aValue["FTCstCode"];
                                    $tCstName       = $aValue["FTCstName"];
                                    $tXrcNet        = floatval($aValue["FCXrcNet"]);
                                    $tXrcDis        = floatval($aValue["FCXrcDis"]);
                                    $tXrcGrand      = floatval($aValue["FCXrcGrand"]);

                                    // Groupping Recive Doc No
                                    if($tRptGrpXrcDocNo != $tXrcDocNo && $tXshDocType == 1 &&  $nRowPartID == 1){
                                        if(!empty($tCstCode) || !empty($tCstName)){
                                            $tTextCustomer  = "(".$tCstCode.") ".$tCstName;
                                        }else{
                                            $tTextCustomer  = "";
                                        }

                                        $aGrpDataXrcDocNo   = array($tXrcDocNo,$tXrcDocDate,$tTextCustomer,'N','N',$tXrcNet,$tXrcDis,$tXrcGrand);
                                        echo "<tr>";
                                            for($i = 0;$i < FCNnHSizeOf($aGrpDataXrcDocNo); $i++) {
                                                if(is_float($aGrpDataXrcDocNo[$i])){
                                                    echo "<td class='xCNRptGrouPing text-right'>".number_format($aGrpDataXrcDocNo[$i],$nOptDecimalShow)."</td>";
                                                }else{
                                                    if(strval($aGrpDataXrcDocNo[$i]) != "N") {
                                                        echo "<td class='xCNRptGrouPing text-left'>" . $aGrpDataXrcDocNo[$i] . "</td>";
                                                    }else{
                                                        echo "<td></td>";
                                                    }
                                                }
                                            }
                                        echo "</tr>";
                                    }
                                    $tRptGrpXrcDocNo = $tXrcDocNo;
                                ?>
                                <?php if($tRptGrpXrcDocNo == $tXrcDocNo && $tXshDocType == 2): ?>
                                    <tr>
                                        <td class="text-left xCNRptDetail xWRptTextIdent" colspan="2"><?php echo @$aValue['FTXsdRefDocNo'];?></td>
                                        <td class="text-left xCNRptDetail"><?php echo @$aValue['FTXsdDocDate'];?></td>
                                        <td class="text-right xCNRptDetail"><?php echo @number_format($aValue['FCXsdNet'],$nOptDecimalShow);?></td>
                                        <td class="text-right xCNRptDetail"><?php echo @number_format($aValue['FCXsdPayB4'],$nOptDecimalShow);?></td>
                                        <td class="text-right xCNRptDetail"><?php echo @number_format($aValue['FCXsdRefPaid'],$nOptDecimalShow);?></td>
                                        <td class="text-right xCNRptDetail"><?php echo @number_format($aValue['FCXsdGrand'],$nOptDecimalShow);?></td>
                                        <td class="text-right xCNRptDetail"><?php echo @number_format($aValue['FCXsdLeft'],$nOptDecimalShow);?></td>
                                    </tr>
                                <?php endif;?>
                                <?php
                                    // Check Underline Sum Groupping
                                    if($nRowPartID == $nGroupMember){
                                        if($nPageNo == $nTotalPage){
                                            if($nKey+1 == $aValue['FNCountAll_Footer']){
                                                $aGrpDataXrcDocNo   = [
                                                    $aDataTextRef['tRptLockerPaymentTotalFooter'],
                                                    'N',
                                                    'N',
                                                    'N',
                                                    'N',
                                                    floatval($aValue['FCXrcNet_Footer']),
                                                    floatval($aValue['FCXrcDis_Footer']),
                                                    floatval($aValue['FCXrcGrand_Footer'])
                                                ];
                                                echo "<tr id='otrRptSumFooter'>";
                                                    for($i = 0;$i < FCNnHSizeOf($aGrpDataXrcDocNo); $i++) {
                                                        if(is_float($aGrpDataXrcDocNo[$i])){
                                                            echo "<td class='xCNRptGrouPing text-right'>".number_format($aGrpDataXrcDocNo[$i],$nOptDecimalShow)."</td>";
                                                        }else{
                                                            if(strval($aGrpDataXrcDocNo[$i]) != "N") {
                                                                echo "<td class='xCNRptGrouPing text-left'>" . $aGrpDataXrcDocNo[$i] . "</td>";
                                                            }else{
                                                                echo "<td></td>";
                                                            }
                                                        }
                                                    }
                                                echo "</tr>";
                                            }else{
                                                echo "<tr><td class='xCNRptGrouPing' colspan='100' style='border-top: dashed 1px black !important;'></td></tr>";
                                            }
                                        }else{
                                            echo "<tr><td class='xCNRptGrouPing' colspan='100' style='border-top: dashed 1px black !important;'></td></tr>";
                                        }
                                    }
                                ?>
                            <?php endforeach;?>
                        <?php else:  ?>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo @$aDataTextRef['tRptNotFoundData'];?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>            
                </div>
            </div>

            <?php if($nPageNo == $nTotalPage): ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                
                <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                <?php if((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo $aDataFilter['tMerNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerTo']; ?> : </span> <?php echo $aDataFilter['tMerNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif;?>    

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
                <?php endif;?>

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
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDFrom']; ?> : </span> <?php echo $aDataFilter['tPosNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDTo']; ?> : </span> <?php echo $aDataFilter['tPosNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif;?>    

                <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
                <?php if((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo $aDataFilter['tCstNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo']; ?> : </span> <?php echo $aDataFilter['tCstNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
            <?php endif; ?>
        </div>
    </div>
</div>