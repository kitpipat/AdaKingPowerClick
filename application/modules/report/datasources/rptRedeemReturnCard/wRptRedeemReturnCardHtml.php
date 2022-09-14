<?php

    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $nOptDecimalShow = FCNxHGetOptionDecimalShow();
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
    .table>thead:first-child>tr:first-child>th:nth-child(3) {
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

    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 20px !important;
        /* font-weight: 600; */
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
        border-bottom: 6px double black !important;
    }

    .xWRptProductFillData>td:first-child {
        text-indent: 40px;
    }

    /*แนวนอน*/
    /* @media print{@page {size: landscape}} */
    /*แนวตั้ง*/
    @media print {
        @page {
            size: portrait
        }
    }


    .xCNLeft { text-align: left; }
    .xCNRight { text-align: right; width:10%; }
    .xCNCenter { text-align: center; width:10%; }

</style>



<div id="odvRptProductTransferHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 text-center">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>

                    <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
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
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center">
                                        <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </label>   <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                        <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </label>     <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                        <div class="text-right">
                            <?php date_default_timezone_set('Asia/Bangkok'); ?>
                            <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left xCNRptColumnHeader" width="17%"><?php echo $aDataTextRef['tRptRedeemReturnCardBranch']; ?></th>
                            <th class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptRedeemReturnCardDocNo']; ?></th>
                            <th class="text-left xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptRedeemReturnCardDocDate']; ?></th>
                            <th class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptRedeemReturnCardShop']; ?></th>
                            <th class="text-left xCNRptColumnHeader" width="13%"><?php echo $aDataTextRef['tRptRedeemReturnCardPos']; ?></th>
                            <th class="text-center xCNRptColumnHeader" width="13%"></th>
                            <th class="text-left xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptRedeemReturnCardUsrReturn']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="8" width="50%"></th>
                        </tr>
                        <tr>
                            <th class="text-left xCNRptColumnHeader"></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRedeemReturnCardSeq']; ?></th>
                            <th class="text-left xCNRptColumnHeader"></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRedeemReturnCardResidualVal']; ?></th>
                            <th class="text-left xCNRptColumnHeader"></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRedeemReturnCardValNotRet']; ?></th>
                            <th class="text-left xCNRptColumnHeader"></th>
                            <th class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRedeemReturnCardValRet']; ?></th>

                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                                $tTempDocNo = '';
                                $tTempSeq   = 1;
                            ?>

                            <?php foreach ($aDataReport['aRptData'] AS $nKey => $aValue) {  ?>

                                <?php
                                    $tRptGtpBchCode = "";
                                    $tRptGtpShpCode = "";
                                    $tRptGtpDocNo   = "";

                                    $nCountBchCode  = 0;
                                    $nCountShpCode  = 0;
                                    $nCountDocNo    = 0;

                                    if($tTempDocNo !=  $aValue['FTTxnDocNoRef']){
                                        $tTempSeq   = 1;
                                    }
                                ?>


                                <?php
                                    $tRptFTXshDocNoRef  = $aValue['FTTxnDocNoRef']; //รหัสเอกสาร
                                    $tRptFDTxnDocDate   = date('d/m/Y',strtotime($aValue["FDTxnDocDate"]));  //วันที่เอกสาร

                                    $tRptBchCode    = $aValue['FTBchCode'];  // สาขา
                                    $tRptBchName    =  $aValue['FTBchName']; // ชื่อสาขา

                                    $tRptShpCode    = $aValue['FTShpCode'];  //รหัสร้านค้า
                                    $tRptShpName    = (!empty($aValue['FTShpName']) ? $aValue['FTShpName'] : '-' );  //ชื่อร้านค้า

                                    $tRptPosCode    = $aValue['FTPosCode'];  //รหัสจุดขาย
                                    $tRptPosName    = (!empty($aValue['FTPosName']) ? $aValue['FTPosName'] : '-' );  //ชื่อจุดขาย

                                    $nUsrCode     = $aValue["FTUsrCode"]; //รหัสผู้ทำรายการคืน
                                    $nUsrName     = $aValue["FTUsrName"]; //ผู้ทำรายการคืน

                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"];


                                    $nCrdValue      = number_format($aValue['FCTxnCrdValue'],$nOptDecimalShow);  //มูลค่าคงเหลือ
                                    $nValNotRet     = number_format($aValue['FCTxnValNotRet'],$nOptDecimalShow);  //ยอดห้ามคืน
                                    $nValRet      = number_format($aValue['FCTxnValRet'],$nOptDecimalShow);  //ยอดคืนเงิน



                                    if($aValue['FNRowPartIDBch'] == 1){
                                        if(isset($tRptBchCode) && !empty($tRptBchCode)){
                                            $tTextBrachName  = $aValue["FTBchName"];
                                        }else{
                                            $tTextBrachName = $aDataTextRef['tRptNotFoundBranch'];
                                        }

                                        //เส้น Group
                                        if ($nRowPartID == $nGroupMember) {
                                            echo "<tr><td class='xCNRptGrouPing' colspan='8' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                        }

                                        $aGrouppingDataBch  = array($tTextBrachName);
                                        echo "<tr>";
                                        for ($i = 0; $i < FCNnHSizeOf($aGrouppingDataBch); $i++) {
                                            if (strval($aGrouppingDataBch[$i]) != "N") {
                                                echo "<td class='xCNRptGrouPing text-left' style='padding: 5px;' colspan='8'>" . $aGrouppingDataBch[$i] . "</td>";
                                            } else {
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "<tr>";
                                        $tRptGtpBchCode = $tRptBchCode;
                                        $nCountBchCode + 1;
                                    }


                                    if($aValue['FNRowPartIDDocRef'] == 1){
                                        $aGrouppingDataDocNo  = array('N',$tRptFTXshDocNoRef,$tRptFDTxnDocDate,$tRptShpName,$tRptPosName,'N',$nUsrName);
                                        echo "<tr class='xCNHeaderGroup'>";
                                            for($i = 0;$i<FCNnHSizeOf($aGrouppingDataDocNo);$i++){
                                                if($aGrouppingDataDocNo[$i] !== 'N'){
                                                    echo "<td nowrap style='padding: 5px;' class='xCNLeft xCNRptGrouPing'>".$aGrouppingDataDocNo[$i]."</td>";
                                                }else{
                                                    echo "<td></td>";
                                                }
                                            }
                                        echo "</tr>";
                                    }

                                    $aGrouppingDataDocNo  = array('N',$aValue['FNRowPartIDDocRef'],'N',$nCrdValue,'N',$nValNotRet,'N',$nValRet);
                                    echo "<tr class='xCNHeaderGroup'>";
                                        for($i = 0;$i<FCNnHSizeOf($aGrouppingDataDocNo);$i++){
                                            if($aGrouppingDataDocNo[$i] !== 'N'){
                                                echo "<td class='xCNLeft'>".$aGrouppingDataDocNo[$i]."</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                    echo "</tr>";


                                    if($aValue['FNRowPartIDDocRef_MaxSeq'] == $tTempSeq){
                                        $nCrdValue_SubByBill   = number_format($aValue["FCTxnCrdValue_SubByBill"],$nOptDecimalShow);
                                        $nValNotRet_SubByBill  = number_format($aValue["FCTxnValNotRet_SubByBill"],$nOptDecimalShow);
                                        $nValRet_SubByBill     = number_format($aValue["FCTxnValRet_SubByBill"],$nOptDecimalShow);

                                        $aSumSubByBIllFooter   = array('N',$aDataTextRef['tRptRedeemReturnCardAmt'],'N',$nCrdValue_SubByBill,'N',$nValNotRet_SubByBill,'N',$nValRet_SubByBill);
                                        echo "<tr class='xCNHeaderGroup' style='border-bottom: dashed 1px #ccc !important;'>";


                                            for($i = 0;$i<FCNnHSizeOf($aSumSubByBIllFooter);$i++){
                                                if($aSumSubByBIllFooter[$i] !== 'N'){
                                                    echo "<td class='xCNleft xCNRptGrouPing'>".$aSumSubByBIllFooter[$i]."</td>";
                                                }else{
                                                    echo "<td></td>";
                                                }
                                            }
                                        echo "</tr>";
                                    }

                                ?>

                                <?php
                                    //Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    $nCrdValue_SubTotal   = number_format($aValue["FCTxnCrdValue_SubTotal"],$nOptDecimalShow);
                                    $nValNotRet_SubTotal  = number_format($aValue["FCTxnValNotRet_SubTotal"],$nOptDecimalShow);
                                    $nValRet_SubTotal     = number_format($aValue["FCTxnValRet_SubTotal"],$nOptDecimalShow);
                                    $aSumFooter           = array($aDataTextRef['tRptTotal'].' '.$aValue["FTBchName"],$nCrdValue_SubTotal,'N',$nValNotRet_SubTotal,'N',$nValRet_SubTotal);


                                    //Step 4 : สั่ง Summary SubFooter
                                    //Parameter
                                    if($nRowPartID == $nGroupMember){
                                        echo '<tr>';
                                        for($i = 0;$i<FCNnHSizeOf($aSumFooter);$i++){
                                            if($aSumFooter[$i] !='N'){
                                                $tFooterVal =   $aSumFooter[$i];
                                            }else{
                                                $tFooterVal =   '';
                                            }

                                            if(intval($i) == 0){
                                                $tClassCss = "text-left";
                                            }else{
                                                $tClassCss = "text-left";
                                            }

                                            if(intval($i) == 0){
                                                $nColspan = "colspan=3";
                                            }else{
                                                $nColspan = "colspan=0";
                                            }
                                            echo "<td class='xCNRptGrouPing $tClassCss' $nColspan style='border-top: dashed 1px #333 !important;'>".$tFooterVal."</td>";
                                        }
                                        echo "</tr>";

                                        $nCountDataAll = FCNnHSizeOf($aDataReport['aRptData']);
                                        if($nCountDataAll - 1 != $nKey){
                                            echo "<tr><td class='xCNRptGrouPing' colspan='9' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                        }
                                    }

                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nCrdValue_Footer    = number_format($aValue["FCTxnCrdValue_Footer"],$nOptDecimalShow);
                                    $nValNotRet_Footer   = number_format($aValue["FCTxnValNotRet_Footer"],$nOptDecimalShow);
                                    $nValRet_Footer      = number_format($aValue["FCTxnValRet_Footer"],$nOptDecimalShow);
                                    $paFooterSumData     = array($aDataTextRef['tRptFooterSumAll'],'N','N',$nCrdValue_Footer,'N',$nValNotRet_Footer,'N',$nValRet_Footer);


                                    $tTempSeq++;
                                    $tTempDocNo = $aValue['FTTxnDocNoRef'];
                                ?>

                            <?php  } ?>


                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];

                                if($nPageNo == $nTotalPage){
                                    echo "<tr class='xCNTrFooter'>";
                                        for($i= 0;$i<FCNnHSizeOf($paFooterSumData);$i++){
                                            if($i==0){
                                                $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;font-size: 18px !important; font-weight: bold;';
                                                }else{
                                                $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;font-size: 18px !important; font-weight: bold;';
                                            }
                                            if($paFooterSumData[$i] !='N'){
                                                $tFooterVal =   $paFooterSumData[$i];
                                                }else{
                                                    $tFooterVal =   '';
                                            }
                                            echo "<td style='$tStyle;padding: 4px;'>".$tFooterVal."</td>";
                                        }
                                    echo "<tr>";
                                }

                            ?>

                        <?php }else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptRedeemReturnCardNoData'];?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))
                        || (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                        || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect']))
                        || (isset($aDataFilter['tPosCodeSelect']))
                        ){ ?>
            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>
            <?php } ;?>

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
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["aPagination"]["nTotalPage"] > 0):?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"].' / '.$aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
