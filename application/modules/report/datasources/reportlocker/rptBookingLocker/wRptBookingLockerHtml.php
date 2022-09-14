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
<div id="odvRptBookingLockerHtml">
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
                                    <label><?php echo $aDataTextRef['tRptDateFrom'].' '.date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptDateTo'].' '.date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
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
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptBookingLockerBranch'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" colspan="2"><?php echo @$aDataTextRef['tRptBookingLockerShop'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" colspan="3"><?php echo @$aDataTextRef['tRptBookingLockerPosLK'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:5%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerRate'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:15%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerUser'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:10%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerRefCst'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:10%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerRefCstDoc'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:10%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerRefCstLogin'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:10%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerProducer'];?>
                            </th>
                            <th nowrap class="text-center xCNRptColumnHeader" rowspan="2" style="width:10%;vertical-align:middle;border-bottom:1px solid black !important;">
                                <?php echo @$aDataTextRef['tRptBookingLockerStaBook'];?>
                            </th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptBookingLockerDocNo'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo @$aDataTextRef['tRptBookingLockerDocDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo @$aDataTextRef['tRptBookingLockerDocTime'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo @$aDataTextRef['tRptBookingLockerLayNo'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo @$aDataTextRef['tRptBookingLockerSize'];?></th>
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
                                    $tBchCode       = $aValue["FTBkgToBch"];
                                    $tBchName       = $aValue["FTBkgToBchName"];
                                    $tShpCode       = $aValue["FTBkgToShp"];
                                    $tShpName       = $aValue["FTBkgToShpName"];
                                    $tPosCode       = $aValue["FTBkgToPos"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    //Step 2 Groupping  Data
                                    // Group Ping Branch
                                    if($tRptGrpBchCode != $tBchCode){
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
                                    }
                                    $tRptGrpShpCode = $tShpCode;
                                    $tRptGrpPosCode = $tPosCode;
                                ?>
                                <tr>
                                    <td></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FNBkgDocID'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FDBkgToStartDate'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTBkgToStartTime'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FNBkgToLayNo'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTBkgToSizeName'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTBkgToRate'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTUsrName'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTBkgRefCst'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTBkgRefCstDoc'];?></td>
                                    <td class="text-left xCNRptDetail"><?php echo @$aValue['FTBkgRefCstLogin'];?></td>
                                    <td class="text-center xCNRptDetail"><?php echo @$aValue['FTBkgProducer'];?></td>
                                    <?php
                                        $tStatusBooking  = 'tRptStaBooking'.$aValue['FTBkgStaBook'];
                                    ?>
                                    <td class="text-center xCNRptDetail"><?php echo @$aDataTextRef[$tStatusBooking];?></td>
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
                            <?php endforeach; ?>
                        <?php else:?>
                            <tr><td class='text-center xCNRptColumnHeader' colspan='100%'><?php echo @$aDataTextRef['tRptNotFoundData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo @$aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>

                <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
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
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosLockerFrom']; ?> : </span> <?php echo $aDataFilter['tPosCodeFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosLockerTo']; ?> : </span> <?php echo $aDataFilter['tPosCodeTo']; ?></label>
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

                <!-- =========================== ฟิวเตอร์ข้อมูล จองช่องฝากของ ========================== -->
                <?php if((isset($aDataFilter['tPzeCodeFrom']) && !empty($aDataFilter['tPzeCodeFrom'])) && (isset($aDataFilter['tPzeCodeTo']) && !empty($aDataFilter['tPzeCodeTo']))): ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopSizeForm']; ?> : </span> <?php echo $aDataFilter['tPzeNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopSizeTo']; ?> : </span> <?php echo $aDataFilter['tPzeNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif;?>
                <?php if (isset($aDataFilter['tPzeCodeSelect']) && !empty($aDataFilter['tPzeCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPzeFrom']; ?> : </span> <?php echo ($aDataFilter['bPzeStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPzeNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <?php
                    // สถานะจอง
                    if(isset($aDataFilter['tStaBooking']) && !empty($aDataFilter['tStaBooking'])){
                        $tStaBooking        = 'tRptStaBooking'.$aDataFilter['tStaBooking'];
                        $tTextStaBooking    =  $aDataTextRef[$tStaBooking];
                    }else{
                        $tTextStaBooking    = $aDataTextRef['tRptStaBookingAll'];
                    }
                ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptStaBooking']; ?> : </span> <?php echo @$tTextStaBooking;?></label>
                    </div>
                </div>
                <?php
                    // จองจากระบบ
                    if(isset($aDataFilter['tStaProducer']) && !empty($aDataFilter['tStaProducer'])){
                        $tTextStaProducer   = $aDataFilter['tStaProducer'];
                    }else{
                        $tTextStaProducer   = $aDataTextRef['tRptStaProducerAll'];
                    }
                ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptStaProducer']; ?> : </span> <?php echo @$tTextStaProducer;?></label>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>    
</div>

