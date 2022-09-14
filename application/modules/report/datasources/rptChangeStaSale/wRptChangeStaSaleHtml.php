<?php
    $nCurrentPage   = $aDataReport['rnCurrentPage'];
    $nAllPage       = $aDataReport['rnAllPage'];
    $aDataTextRef   = $aDataTextRef;
    $aDataFilter    = $aDataFilter;
    $aDataReport    = $aDataReturn;
    $aCompanyInfo   = $aCompanyInfo;
?>
<style>
    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr:last-child.xCNTrSubFooter{
        border-bottom : 1px dashed #333 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px dashed #333 !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 1px solid black !important;
    }

    .xWConditionOther{
        font-family: 'THSarabunNew-Bold';
        color: #232C3D !important;
        font-size: 20px !important;
        font-weight: 900;
    }

    /*แนวนอน*/
    @media print{@page {size: A4 landscape;}} 
    /*แนวตั้ง*/
    /* @media print{
        @page {
        size: A4 portrait;
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
        }
    } */
</style>
<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <!--  Create By Witsarut (Bell) แก้ไขเรื่องที่อยู่ และ Fillter -->
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>
                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  ?>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?> <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>
                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  ?>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>
                        <div class="xCNRptAddress">
                            <label ><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="xCNRptAddress">
                            <label ><?= $aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>
                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'].' :</span> '.date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>&nbsp;&nbsp;
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'].' :</span> '.date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'].' :</span> '.$aDataFilter['tBchNameFrom'];?></label>&nbsp;&nbsp;
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'].' :</span> '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left   xCNRptColumnHeader"  style="width:10%;border-bottom: dashed 1px #333 !important; !important"><?php echo $aDataTextRef['tRptBarchName'];?></th>
                            <th nowrap class="text-left   xCNRptColumnHeader"  style="width:15%;border-bottom: dashed 1px #333 !important; !important"><?php echo $aDataTextRef['tRptshop'];?></th>
                            <th nowrap class="text-center   xCNRptColumnHeader"  style="border-bottom: dashed 1px #333 !important; !important" colspan="2"><?php echo $aDataTextRef['tRptDNPLockersID'];?></th>
                            <th nowrap class="text-center   xCNRptColumnHeader"  style="border-bottom: dashed 1px #333 !important; !important" colspan="2"><?php echo $aDataTextRef['tRptStatus'];?></th>
                            <th style="width:5%;" rowspan="2"></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:20%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptReason'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:20%;vertical-align:middle;border-bottom: 1px solid black !important" rowspan="2"><?php echo $aDataTextRef['tRptUSerChange'];?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th></th>
                            <th nowrap class="text-left     xCNRptColumnHeader"   ><?php echo $aDataTextRef['tRptOpenSysAdminDateOpen'];?></th>
                            <th nowrap class="text-center     xCNRptColumnHeader"   style="width:5%;"><?php echo $aDataTextRef['tRptTime'];?></th>
                            <th nowrap class="text-center     xCNRptColumnHeader"   style="width:5%;"><?php echo $aDataTextRef['tRptDNPChannel'];?></th>
                            <th nowrap class="text-center     xCNRptColumnHeader"   style="width:5%;"><?php echo $aDataTextRef['tRptCoditionFrom'];?></th>
                            <th nowrap class="text-center     xCNRptColumnHeader"   style="width:5%;"><?php echo $aDataTextRef['tRptCoditionTo'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1'): ?>
                            <?php
                                $tGrouppingBch          = '';
                                $nCountBch              = 0;  
                                foreach($aDataReport['raItems'] as $aValue):

                                // Step 1 เตรียม Parameter สำหรับการ Groupping
                                $tBchCode               = $aValue['FTBchCode'];
                                $tBchName               = $aValue['FTBchName'];
                                $tShpName               = $aValue['FTShpName'];
                                $tPosCode               = $aValue['FTPosCode'];
                                $nRowPartID             = $aValue["FNRowPartID"];
                                // $nGroupMember           = $aValue["FNRptGroupMember"];  

                                // Step 2 Groupping data
                                $aGrouppingDataBch    = array('('.$tBchCode. ') '.$tBchName,'','','','','','');
                                $aGrouppingDataShp    = array($tShpName,'PID : '.$tPosCode,'','','');

                                // ขีดเส้นใต้ เมื่อจบสาขานั้น
                                if($tGrouppingBch != $tBchCode && $nCountBch > 0){
                                    $tSumFooter         = array('N','N','N','N','N','N','N','N','N');
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
                                            echo "<td class='xCNRptGrouPing' style='padding: 5px;text-indent:30%;' colspan='3'>".$aGrouppingDataShp[$i]."</td>";
                                        }else if($aGrouppingDataShp[$i] == $aGrouppingDataShp[1]){
                                            echo "<td class='xCNRptGrouPing' style='padding: 5px;' colspan='3'>".$aGrouppingDataShp[$i]."</td>";
                                        }else{
                                            echo "<td class='xCNRptGrouPing text-right'  style='padding: 5px;'>".$aGrouppingDataShp[$i]."</td>";
                                        }
                                    }
                                    echo "</tr>";
                                } 

                                switch($aValue['FTLayStaUse']){
                                    case '2':
                                        $tStaFrom   = "ไม่ใช้งาน";
                                        $tStaTo     = "ใช้งาน";
                                        break;
                                    case '3':
                                        $tStaFrom   = "ใช้งาน";
                                        $tStaTo     = "ไม่ใช้งาน";
                                        break;
                                    default:
                                        $tStaFrom   = "";
                                        $tStaTo     = "";
                                        break;
                                } 
                            ?>
                                <tr>
                                    <td></td>
                                    <td class="text-left xCNRptDetail"><?php echo date("d/m/Y", strtotime($aValue['FDXshActionDate']));?></td>
                                    <td class="text-left xCNRptDetail"><?php echo date("H:i", strtotime($aValue['FTXshActionTime']));?></td>
                                    <td class="text-right xCNRptDetail"><?php echo $aValue['FNHisLayNo']; ?></td>
                                    <td class="text-left xCNRptDetail"><?=$tStaFrom;?></td>
                                    <td class="text-left xCNRptDetail"><?=$tStaTo;?></td>
                                    <td class="text-left xCNRptDetail"></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue['FTRsnName']; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue['FTUsrName']; ?></td>
                                </tr>
                            <?php endforeach; ?>

                            <?php 
                                if ($nCurrentPage == $nAllPage) {
                                    echo "<tr'>";
                                    echo "<td class='xCNRptSumFooter text-left' colspan='9999' style='border-top: 1px solid black !important;'></td>";
                                    echo "</tr>";
                                }
                            ?>

                        <?php else:?>
                            <tr><td class="text-center xCNRptDetail" colspan="100" ><?php echo $aDataTextRef['tRptNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
            <?php if($aDataReport['rtCode'] == '800' || $nCurrentPage == $nAllPage): ?>
                <?php 
                    // if( (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo'])) || 
                    //       (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tRptPosCodeTo']) && !empty($aDataFilter['tRptPosCodeTo'])) || 
                    //       (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo'])) ){ 
                ?>
                    <div class="xCNRptFilterTitle">
                        <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                    </div>
                <?php 
                    // } 
                ?>

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




