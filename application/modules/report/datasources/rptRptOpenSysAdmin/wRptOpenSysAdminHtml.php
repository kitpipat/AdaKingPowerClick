<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];
   
?>
<style>
    /** Set Media Print */
    @media print{@page {size: A4 portrait;}}

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
<div id="odvRptOpenSysAdminHtml">
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
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptOpenSysAdminBchName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" colspan="2"><?php echo @$aDataTextRef['tRptOpenSysAdminShpName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptOpenSysAdminShpName'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:50%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptOpenSysAdminRsnName'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:20%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptOpenSysAdminUserName'];?>
                            </th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptOpenSysAdminDateOpen'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptOpenSysAdminTimeOpen'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptOpenSysAdminLayNo'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])): ?>
                            <?php
                                $tRptGrpBchCode = "";
                                $tRptGrpShpCode = "";
                                $tRptGrpPosCode = "";
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tBchCode       = $aValue["FTBchCode"];
                                    $tBchName       = $aValue["FTBchName"];
                                    $tShpCode       = $aValue["FTShpCode"];
                                    $tShpName       = $aValue["FTShpName"];
                                    $tPosCode       = $aValue["FTPosCode"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                    $nGroupMember   = $aValue["FNRptGroupMember"];

                                    //Step 2 Groupping  Data
                                    if($tRptGrpBchCode  != $tBchCode && $nRowPartID == '1'){
                                        $tTextBrachSub      = "(".$tBchCode.")"." ".$tBchName;
                                        $aGrouppingDataBch  = array($tTextBrachSub);
                                        echo "<tr>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingDataBch); $i++) {
                                            if(strval($aGrouppingDataBch[$i]) != "N") {
                                                echo "<td class='xCNRptGrouPing text-left' style='padding: 5px;' colspan='10'>" . $aGrouppingDataBch[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "<tr>";
                                        $tRptGrpBchCode = $tBchCode;
                                    }

                                    if($tRptGrpBchCode == $tBchCode && $tRptGrpShpCode != $tShpCode && $tRptGrpPosCode != $tPosCode){
                                        $tTextShopSub   = $tShpName;
                                        $tTextPosSub    = "PID : ".$tPosCode;
                                        $aGrouppingDataShopAndPos   = array("N",$tTextShopSub,$tTextPosSub);
                                        echo "<tr>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingDataShopAndPos); $i++) {
                                            if(strval($aGrouppingDataShopAndPos[$i]) != "N") {
                                                echo "<td class='xCNRptGrouPing text-left' style='padding: 5px;' colspan='2'>" . $aGrouppingDataShopAndPos[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "<tr>";
                                        $tRptGrpShpCode = $tShpCode;
                                        $tRptGrpPosCode = $tPosCode;
                                    }
                                ?>
                                <tr>
                                    <td></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FDHisDate'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTHisTime'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FNHisLayNo'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTRsnName'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTUsrName'];?></td>
                                </tr>
                                <?php
                                    if($nRowPartID == $nGroupMember){
                                        if($nPageNo == $nTotalPage){
                                            echo "<tr><td class='xCNRptGrouPing' colspan='100' style='border-top: 1px solid black !important;'></td></tr>";
                                        }else{
                                            echo "<tr><td class='xCNRptGrouPing' colspan='100' style='border-top: dashed 1px black !important;'></td></tr>";
                                        }
                                    }
                                ?>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo @$aDataTextRef['tRptNotFoundData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
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
            <?php if((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
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
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
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
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosIDTo'].' : </span>'.$aDataFilter['tPosNameFrom'];?></label>
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

        </div>
    </div>
</div>