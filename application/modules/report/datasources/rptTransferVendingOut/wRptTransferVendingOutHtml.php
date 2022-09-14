<?php
    $aCompanyInfo       = $aDataViewRpt['aCompanyInfo'];
    $aDataFilter        = $aDataViewRpt['aDataFilter'];
    $aDataTextRef       = $aDataViewRpt['aDataTextRef'];
    $aDataReport        = $aDataViewRpt['aDataReport'];
    $nOptDecimalShow    = $aDataViewRpt['nOptDecimalShow'];
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
        border-bottom: dashed 1px #333 !important; 
    }


    .xWRptMovePosVDData>td:first-child{
        text-indent: 40px;
    }

    /*แนวนอน*/
    @media print{@page {
        size: A4 landscape;
        margin: 5mm 5mm 5mm 5mm;
        }
    } 
</style>
<div id="odvRptTransferVendingOutHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) {?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo $aDataFilter['tDocDateFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo $aDataFilter['tDocDateTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptBarchCode');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptXshDocNo');?></th>
                            <th nowrap colspan="2" nowrap class="text-center xCNRptColumnHeader"><?php echo language('report/report/report','tRptDateDocument');?></th>
                            <th nowrap colspan="3" nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptTakeoutPdt');?></th>
                            <th></th>
                            <th></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptListener');?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:14%;"><?php echo language('report/report/report','tRptPdtCode');?></th>
                            <th nowrap colspan="2" class="text-left xCNRptColumnHeader" style="width:20%;"><?php echo language('report/report/report','tRptPdtName');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report','tRptCabinetclass');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report','tRptChannel');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%;"><?php echo language('report/report/report','tRptCabinetnumber');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:15%;text-indent: 100px;"><?php echo language('report/report/report','tRptFromWareHouse');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:15%;text-indent: 40px;"><?php echo language('report/report/report','tRptWareHouseTo');?></th>
                            <th></th>
                        </tr>
                    </thead>

                        <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $tRptGtpBchCode = "";
                                $tRptGtpShpCode = "";
                                $nCountBchCode  = 0;
                                $nCountShpCode  = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tBchCode       = $aValue["FTBchCode"];
                                    $tBchName       = $aValue["FTBchName"];
                                    $tShpCode       = $aValue["FTShpCode"];
                                    $tShpName       = $aValue["FTShpName"];
                                    $tDocNo         = $aValue["FTXthDocNo"];
                                    $tDocDate       = date("Y-m-d", strtotime($aValue["FDXthDocDate"]));
                                    $tPosCode       = $aValue["FTPosCode"];
                                    $tPosName       = $aValue["FTPosName"];
                                    $tUsrName       = $aValue["FTUsrName"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                    // $nGroupMember   = $aValue["FNRptGroupMember_SUBPDT"];

                                    //Step 2 Groupping  Data
                                    // Grouping Branch
                                    if($aValue['FNRowPartIDBch'] == 1){
                                        if(isset($tBchCode) && !empty($tBchCode)){
                                            $tTextBrachName = $tBchCode.' - '.@$tBchName;
                                        }else{
                                            $tTextBrachName = language('report/report/report','tRptNotFoundBranch');
                                        }
                                        $aGrouppingDataBch  = array($tTextBrachName);
                                        echo "<tr>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingDataBch); $i++) {
                                            if(strval($aGrouppingDataBch[$i]) != "N") {
                                                echo "<td nowrap class='xCNRptGrouPing text-left' style='padding: 5px;' colspan='10'>" . $aGrouppingDataBch[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "<tr>";
                                        $tRptGtpBchCode = $tBchCode;
                                        $nCountBchCode+1;
                                    }

                                
                                    // Grouping Shp
                                    if($aValue['FNRowShpIDWah'] == 1){
                                        if(isset($tShpCode) && !empty($tShpCode)){
                                            $tTexShpName = $tShpCode.' - '.$tShpName;
                                        }else{
                                            $tTexShpName = language('report/report/report','tRptNotFoundWarehouse');
                                        }
                                        $aGrouppingDataShp  = array($tTexShpName);
                                        echo "<tr>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingDataShp); $i++) {
                                            if(strval($aGrouppingDataShp[$i]) != "N") {
                                                echo "<td nowrap class='xCNRptGrouPing  text-left' style='padding: 5px;text-indent: 40px;' colspan='10'>" . $aGrouppingDataShp[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "<tr>";
                                        $tRptGtpShpCode = $tShpCode;
                                        $nCountShpCode+1;
                                    }

                                    $aGrouppingDocNo  = array($tDocNo,$tDocDate,$tPosCode,$tPosName,$tUsrName);
                                    if($nRowPartID == 1){
                                        echo "<tr class='xCNHeaderGroup'>";
                                        echo "<td></td>";
                                        for($i = 0;$i<FCNnHSizeOf($aGrouppingDocNo);$i++){
                                            if($aGrouppingDocNo[$i] !== 'N'){
                                                if($aGrouppingDocNo[$i] == $tDocDate){
                                                    echo "<td nowrap colspan='2' class = 'xCNRptDetail text-center' style='padding: 5px;'>".$aGrouppingDocNo[$i]."</td>";
                                                }
                                                else if($aGrouppingDocNo[$i] == $tPosName){
                                                    echo "<td nowrap colspan='4' class = 'xCNRptDetail text-left' style='padding: 5px;'>".$aGrouppingDocNo[$i]."</td>";
                                                }
                                                else{
                                                    echo "<td nowrap class = 'xCNRptDetail text-left' style='padding: 5px;'>".$aGrouppingDocNo[$i]."</td>";
                                                }
                                                
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>

                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <?php
                                    $tPdtCode       = $aValue["FTPdtCode"];
                                    $tPdtName       = $aValue["FTPdtName"];
                                    $nLayRow        = $aValue["FNLayRow"];
                                    $nLayCol        = $aValue["FNLayCol"];
                                    $nXtdQty        = $aValue["FCXtdQty"];
                                    $tWahFrm        = $aValue["FTXtdWahFrm"];
                                    $tWahTo         = $aValue["FTXtdWahTo"];
                                ?>
                                <tr class="xWRptMovePosVDData">
                                    <td></td>
                                    <td nowrap class="text-left xCNRptDetail" style="text-indent: 40px;"><?php echo $tPdtCode; ?></td>
                                    <td nowrap colspan='2' class="text-left xCNRptDetail"><?php echo $tPdtName; ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $nLayRow; ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $nLayCol; ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($nXtdQty , $nOptDecimalShow); ?></td>
                                    <td nowrap class="text-left xCNRptDetail" style="text-indent: 100px;"><?php echo $tWahFrm; ?></td>
                                    <td nowrap colspan='2' class="text-left xCNRptDetail" style="text-indent: 40px;"><?php echo $tWahTo; ?></td>
                                </tr>
                            <?php endforeach;?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData'];?></td></tr>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom'].' : </span>'.$aDataFilter['tWahNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahTo'].' : </span>'.$aDataFilter['tWahNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?> 
            <?php if (isset($aDataFilter['tWahCodeSelect']) && !empty($aDataFilter['tWahCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjWahFrom']; ?> : </span> <?php echo ($aDataFilter['bWahStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tWahNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>  

            <?php if ((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tPdtNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['tPdtNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?> 
            <?php if (isset($aDataFilter['tPdtCodeSelect']) && !empty($aDataFilter['tPdtCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom']; ?> : </span> <?php echo ($aDataFilter['bPdtStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPdtNameSelect']; ?></label>
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


