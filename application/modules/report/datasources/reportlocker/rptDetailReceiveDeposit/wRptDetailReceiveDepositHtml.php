<?php
    $aDataReport     = $aDataViewRpt['aDataReport'];
    $aDataTextRef    = $aDataViewRpt['aDataTextRef'];
    $aDataFilter     = $aDataViewRpt['aDataFilter'];
    $nPageNo         = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage      = $aDataReport["aPagination"]["nTotalPage"];
    $nOptDecimalShow = $aDataViewRpt['nOptDecimalShow'];
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
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <?php 
                            $dDateFilterFrom = date_create($aDataFilter['tDocDateFrom']); 
                            $dDateFilterTo   = date_create($aDataFilter['tDocDateTo']); 
                        ?> 
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><?php echo $aDataTextRef['tRptDateFrom'].' '.date_format($dDateFilterFrom,"d/m/Y");?></label>&nbsp;&nbsp;
                                    <label><?php echo $aDataTextRef['tRptDateTo'].' '.date_format($dDateFilterTo,"d/m/Y");?></label>
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
                            <th nowrap class="text-left   xCNRptColumnHeader"  style="width:3%;vertical-align:middle;"><?php echo $aDataTextRef['tRptBarchName'];?></th>
                            <th nowrap class="text-left   xCNRptColumnHeader"  style="width:10%;vertical-align:middle;"><?php echo $aDataTextRef['tRptshop'];?></th>
                            <th nowrap class="text-left   xCNRptColumnHeader"  ></th>
                            <th nowrap class="text-left   xCNRptColumnHeader"  style="vertical-align:middle;border-bottom: dashed 1px #333 !important; !important" colspan="5"><?php echo $aDataTextRef['tRptRentAmountPosID'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:15%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptDNPTrackingNumber'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:15%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptDNPRecipient'];?></th>

                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:1%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptLockerPickByDatePickDate'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:1%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptTime'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:1%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptStaPickUp'];?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   ><?php echo $aDataTextRef['tRptXshDocNo'];?></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   style="width:1%;"><?php echo $aDataTextRef['tRptDNPDepositDate'];?></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   style="width:1%;"><?php echo $aDataTextRef['tRptTime'];?></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   style="width:1%;"><?php echo $aDataTextRef['tRptDNPChannel'];?></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   style="width:1%;"><?php echo $aDataTextRef['tRptSize'];?></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   style="width:5%;"><?php echo $aDataTextRef['tRptBookingLockerRate'];?></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   style="width:10%;"><?php echo $aDataTextRef['tRptDNPDepositor'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])): ?>
                        <?php 
                                $tGrouppingBch      = "";
                                $nCountBch          = 0; 
                                $nXshBillQTY_SUMBCH = 0;   
                                $nXshGrand_SUMBCH   = 0;   
                                $nXshBillQTY_SUMSHP = 0;   
                                $nXshGrand_SUMSHP   = 0; 
                                $nXshBillQTY_Footer = 0;
                                $nXshGrand_Footer   = 0;      
                        ?>
                        <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                            <?php 
                                // Step 1 เตรียม Parameter สำหรับการ Groupping
                                $tBchCode               = $aValue['FTBchCode'];
                                $tBchName               = $aValue['FTBchName'];
                                $tShpName               = $aValue['FTShpName'];
                                $tPosCode               = $aValue['FTPosCode'];
                                $nRowPartID             = $aValue["FNRowPartID"]; 
                                // $nGroupMember           = $aValue["FNRptGroupMember"];     
                            ?>
                            <?php 
                                // Step 2 Groupping data
                                $aGrouppingDataBch    = array('('.$tBchCode. ') '.$tBchName,'','','','','','','','','','');
                                $aGrouppingDataShp    = array($tShpName,'PID : '.$tPosCode,'','','','','','','');

                                // ขีดเส้นใต้ เมื่อจบสาขานั้น
                                if($tGrouppingBch != $tBchCode &&  $nCountBch > 0){
                                $tSumFooter         = array('N','N','N','N','N','N','N','N','N','N','N','N','N');
                                if($nRowPartID == 1){
                                    echo '<tr>';
                                    for($i = 0;$i<FCNnHSizeOf($tSumFooter);$i++){
                                        if($tSumFooter[$i] !='N'){
                                            $tFooter =   $tSumFooter[$i];           
                                        }else{
                                            $tFooter =   '';
                                        }
                                            echo "<td class='xCNRptGrouPing'  style='border-bottom: dashed 1px #333 !important;' >".$tFooter."</td>";
                                        }
                                        echo '</tr>';
                                    }
                                }

                                // จัด Groupping สาขา 
                                if($tGrouppingBch != $tBchCode){
                                    if($nRowPartID == 1){
                                        echo "<tr>";
                                        for($i = 0;$i<FCNnHSizeOf($aGrouppingDataBch);$i++){
                                            if($aGrouppingDataBch [$i] == $aGrouppingDataBch[0] ){
                                                echo "<td class='xCNRptGrouPing  text-left'  style='padding: 5px;' colspan='3'>". $aGrouppingDataBch[$i]."</td>";
                                            }else{
                                                echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>". $aGrouppingDataBch[$i]."</td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                    
                                    $tGrouppingBch = $tBchCode;
                                    $nCountBch++;
                            
                                }
                                
                                // จัด Groupping ร้านค้า
                                if($aValue["FNRowPartID"] == 1){
                                    echo "<tr>";
                                    for($i = 0;$i<FCNnHSizeOf($aGrouppingDataShp);$i++){
                                        if($aGrouppingDataShp[$i] == $aGrouppingDataShp[0]){
                                            echo "<td class='xCNRptGrouPing' style='padding: 5px;text-indent:15%;' colspan='3'>".$aGrouppingDataShp[$i]."</td>";
                                        }else if($aGrouppingDataShp[$i] == $aGrouppingDataShp[1]){
                                            echo "<td class='xCNRptGrouPing' style='padding: 5px;' colspan='3'>".$aGrouppingDataShp[$i]."</td>";
                                        }else{
                                            echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$aGrouppingDataShp[$i]."</td>";
                                        }
                                    }
                                    echo "</tr>";
                                } 
                                
                                if( empty($aValue['FDXshDatePick']) && empty($aValue['FTXshTimePick']) ){
                                    $tStaPick   = 'ยังไม่รับ';
                                    $tDatePick  = "-";
                                    $tTimePick  = "-";
                                }else{
                                    $tStaPick = 'รับแล้ว';
                                    $tDatePick  = date('d/m/Y',strtotime($aValue['FDXshDatePick']));
                                    $tTimePick  = date('H:i',strtotime($aValue['FTXshTimePick']));
                                }
                            ?>

                            <!--  Step 2 แสดงข้อมูลใน TD  -->
                            <tr>
                                <td nowrap class="xCNRptDetail"></td>
                                <td nowrap class="text-left   xCNRptDetail"><?=$aValue['FTXshDocNo'];?></td>
                                <td nowrap class="text-center xCNRptDetail"><?=date('d/m/Y',strtotime($aValue['FDXshDocDate']));?></td>
                                <td nowrap class="text-center xCNRptDetail"><?=date('H:i',strtotime($aValue['FTXshDocTime']));?></td>
                                <td nowrap class="text-right  xCNRptDetail"><?=$aValue['FNXsdLayNo'];?></td>
                                <td nowrap class="text-right  xCNRptDetail"><?=$aValue['FTSizName'];?></td> 
                                <td nowrap class="text-left   xCNRptDetail"><?=$aValue['FTRthName'];?></td> 
                                <td nowrap class="text-left   xCNRptDetail"><?='('.$aValue['FTXshFrmLogin'].') '.$aValue['FTXshFrmLoginName'];?></td> 
                                <td nowrap class="text-left   xCNRptDetail"><?=$aValue['FTXshRefExt'];?></td> 
                                <td nowrap class="text-left   xCNRptDetail"><?=$aValue['FTXshToLoginName'];?></td> 
                                <td nowrap class="text-center xCNRptDetail"><?=$tDatePick;?></td> 
                                <td nowrap class="text-center xCNRptDetail"><?=$tTimePick;?></td> 
                                <td nowrap class="text-left xCNRptDetail"><?=$tStaPick;?></td> 
                            </tr>
                        <?php endforeach; ?>


                        <?php 
                            $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];

                            if ($nPageNo == $nTotalPage) {
                                echo "<tr'>";
                                echo "<td class='xCNRptSumFooter text-left' colspan='9999' style='border-top: 1px solid black !important;'></td>";
                                echo "</tr>";
                            }
                        ?>


                        <?php else: ?>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptTaxSaleLockerNoData'];?></td></tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
            
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

             <?php endif; ?>
        </div>
    </div>    
</div>
