<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
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

    /** แนวตั้ง */
    @media print{@page {size: landscape}}
</style>

<div id="OdvRptPdtTnfINHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 "></div>
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
                            <th nowrap class="text-left xCNRptColumnHeader" width="20%"><?php echo $aDataTextRef['tRptTnfPdtCode'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" width="30%"><?php echo $aDataTextRef['tRptTnfPdtName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-left xCNRptColumnHeader" style="text-indent: 15%;"><?php echo $aDataTextRef['tRptTnfFrom'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="text-indent: 10%;"><?php echo $aDataTextRef['tRptTnfTo'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptTnfDocNo'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptTnfDate'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRefCode'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptRefDate'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptTnfQty'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptUnit'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nFCXidQty_Footer       = 0;
                                $nFCXidQty_SubFooter    = 0;
                            ?>

                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tDocNo         = $aValue['FTXthDocNo'];
                                    $tPdtCode       = $aValue['FTPdtCode'];
                                    $tPdtName       = $aValue['FTPdtName'];
                                    $tDocDate       = date("d/m/Y", strtotime($aValue['FDXthDocDate']));
                                    if(!empty($aValue['FDXthRefIntDate'])){
                                        $tRefIntDate    = date("d/m/Y", strtotime($aValue['FDXthRefIntDate']));
                                    }else{
                                        $tRefIntDate    = "";
                                    }
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                    $tFCXidQty      = number_format($aValue['FCXidQty'],$nOptDecimalShow);
                                    $tFTPunName     = $aValue['FTPunName'];

                                ?>

                                <?php
                                    //Step 2 Groupping data
                                    $aGrouppingData = array($tPdtCode,$tPdtName,"N","N","N","N","N");

                                    if($nRowPartID == 1) {
                                        echo "<tr>";
                                        for($i = 0;$i < FCNnHSizeOf($aGrouppingData); $i++) {
                                            if(strval($aGrouppingData[$i]) != "N") {
                                                echo "<td class='xCNRptGrouPing  text-left' style='padding: 5px;'>" . $aGrouppingData[$i] . "</td>";
                                            }else{
                                                echo "<td></td>";
                                            }
                                        }
                                        echo "</tr>";
                                    }
                                ?>

                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td class="text-left xCNRptDetail">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<?php echo @$aValue["FTXthFrmName"]; ?></td>
                                    <td class="text-left xCNRptDetail" style="text-indent:20px;"><?php echo @$aValue['FTWahNameTo'];?></td>
                                    <td class="text-center xCNRptDetail"><?php echo @$aValue['FTXthDocNo'];?></td>
                                    <td class="text-center xCNRptDetail"><?php echo $tDocDate;?></td>
                                    <td class="text-center xCNRptDetail"><?php echo @$aValue['FTXthRefInt'];?></td>
                                    <td class="text-center xCNRptDetail"><?php echo $tRefIntDate;?></td>
                                    <td class="text-right xCNRptDetail"><?php echo $tFCXidQty?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $tFTPunName;?></td>
                                </tr>

                                <?php
                                    $nFCXidQty_SubFooter     = number_format($aValue["FCXidQty_SubFooter"],$nOptDecimalShow);
                                    $aSumFooter             = array($aDataTextRef['tRptAdjStkVDTotalSub'],'N','N','N','N','N',$nFCXidQty_SubFooter,'N');

                                    if($nRowPartID == $nGroupMember){
                                        echo '<tr>';
                                        for($i = 0;$i<FCNnHSizeOf($aSumFooter);$i++){

                                            if(strval($aSumFooter[$i]) != "N"){
                                                $tFooterVal = $aSumFooter[$i];
                                            }else{
                                                $tFooterVal = '';
                                            }

                                            if($i==6){
                                                $tClassCss = "text-right";
                                            }else{
                                                $tClassCss = "text-left";
                                            }
                                            echo "<td class='xCNRptGrouPing $tClassCss'  style='border-top: dashed 1px #333 !important;'>".$tFooterVal."</td>";
                                        }
                                        echo "</tr>";

                                        $nCountDataAll = FCNnHSizeOf($aDataReport['aRptData']);
                                        if($nCountDataAll - 1 != $nKey){
                                            echo "<tr><td class='xCNRptGrouPing' colspan='8' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                        }
                                    }

                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nFCXidQty_Footer      = number_format($aValue["FCXidQty_Footer"],$nOptDecimalShow);
                                    $aFooterSumData        = array($aDataTextRef['tRptAdjStkVDTotalFooter'],'N','N','N','N','N',$nFCXidQty_Footer,'N');
                                ?>
                            <?php endforeach;?>

                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                if($nPageNo == $nTotalPage){
                                    echo "<tr class='xCNTrFooter'>";
                                    for($i = 0; $i < FCNnHSizeOf($aFooterSumData); $i++){
                                        if($i == 0){
                                            $tStyle = 'text-align:left;border-top:1px solid #333;border-bottom:1px solid #333;/*background-color: #CFE2F3;*/';
                                        }else{
                                            $tStyle = 'text-align:right;border-top:1px solid #333;border-bottom:1px solid #333;/*background-color: #CFE2F3;*/';
                                        }

                                        if(strval($aFooterSumData[$i]) != "N"){
                                            $tFooterVal = $aFooterSumData[$i];
                                        }else{
                                            $tFooterVal = '';
                                        }
                                        if($i == 0) {
                                            echo "<td class='xCNRptSumFooter text-left' colspan='1'>" . $tFooterVal . "</td>";
                                        } else {
                                            echo "<td class='xCNRptSumFooter text-right'>" . $tFooterVal . "</td>";
                                        }
                                    }
                                    echo "<tr>";
                                }
                            ?>

                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>

             <!--เเสดงหน้า-->
            <div class="xCNRptFilterTitle">
                <div class="text-right">
                    <label><?=language('report/report/report','tRptPage')?> <?=$aDataReport["aPagination"]["nDisplayPage"]?> <?=language('report/report/report','tRptTo')?> <?=$aDataReport["aPagination"]["nTotalPage"]?> </label>
                </div>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล คลังสินค้า ============================ -->
            <?php if ((isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahFrom'].' : </span>'.$aDataFilter['tWahNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptWahTo'].' : </span>'. $aDataFilter['tWahNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
            <?php if ((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tPdtNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'. $aDataFilter['tPdtNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
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
