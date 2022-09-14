<?php
    $aDataFilterReport  = $aDataViewRpt['aDataFilter'];
    $aDataTextRef       = $aDataViewRpt['aDataTextRef'];
    $aDataReport        = $aDataViewRpt['aDataReport'];
    $nOptDecimalShow = $aDataViewRpt['nOptDecimalShow'];
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

        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrFooter{
        /* background-color: #CFE2F3 !important; */
        /* border-bottom : 6px double black !important; */
        /* border-top: dashed 1px #333 !important; */
        border-top: 1px solid black !important;
        border-
         : 1px solid black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
    /*แนวนอน*/
    @media print{
            @page {
                size: A4 landscape;
                margin: 5mm 5mm 5mm 5mm;
            }
    }
    /*แนวตั้ง*/
    /* @media print{@page {size: portrait}} */
</style>

<div id="odvRptSaleByProductHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <!-- <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                </div>
            </div> -->
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'].' : </span>'.date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'].' : </span>'.date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'].' : </span>'.$aDataFilter['tBchNameFrom'];?></label>
                                    <label class="xCNRptLabel"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'].' : </span>'.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
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
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:7%"><?php  echo $aDataTextRef['tRptPdtCode']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" ><?php  echo $aDataTextRef['tRptPdtName']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" ><?php  echo $aDataTextRef['tRptPdtGrp']; ?></th>

                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%"><?php  echo $aDataTextRef['tRptQty'] ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%"><?php  echo $aDataTextRef['tRptUnit']?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%"><?php   echo $aDataTextRef['tRptSales']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%"><?php   echo $aDataTextRef['tRptDiscount']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%"><?php  echo $aDataTextRef['tRptAveragePrice']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:5%"><?php  echo $aDataTextRef['tRptGrand']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร Sum - SubFooter
                                $nSumSubXsdQty          = 0;
                                $cSumSubXsdAmtB4DisChg  = 0;
                                $cSumSubXsdDis          = 0;
                                $cSumSubXsdVat          = 0;
                                $cSumSubXsdNetAfHD      = 0;
                                // Set ตัวแปร SumFooter
                                $nSumFootXsdQty         = 0;
                                $cSumFootXsdAmtB4DisChg = 0;
                                $cSumFootXsdDis         = 0;
                                $cSumFootXsdVat         = 0;
                                $cSumFootXsdNetAfHD     = 0;
                            ?>
                            <?php foreach($aDataReport['aRptData'] as $nKey=>$aValue):?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tBchCodeGroup  = $aDataTextRef['tRptBranch'].' '.$aValue["FTBchCode"].' '.$aValue["FTBchName"];
                                    // $tRptDocDate    = date('Y-m-d H:i:s', strtotime($aValue["FDCreateOn"]));
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                ?>
                                <?php
                                    //Step 2 Groupping data
                                    $aGrouppingData = array($tBchCodeGroup);
                                    // Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                    FCNtHRPTHeadGrouppingRptTSPBch($nRowPartID,$aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td class="text-left xCNRptDetail"><?php echo '&nbsp;&nbsp;'.$aValue["FTPdtCode"];?></td>
                                    <td class="text-left xCNRptDetail">
                                        <?php
                                            echo ($aValue["FTXsdPdtName"] != "" ? $aValue["FTXsdPdtName"] : "-");
                                            if(empty($aDataFilter['tPosType']) && $aValue["FNAppType"] == '2'){
                                                echo " (Vending)";
                                            }
                                        ?>
                                    </td>
                                    <td class="text-left xCNRptDetail"><?php echo ($aValue["FTPgpChainName"] != "" ? $aValue["FTPgpChainName"] : "-");?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdQty"], $nOptDecimalShow);?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue['FTPunName'];?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdAmtB4DisChg"], $nOptDecimalShow);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdDis"], $nOptDecimalShow);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdSetPrice"], $nOptDecimalShow);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdNetAfHD"], $nOptDecimalShow);?></td>
                                </tr>

                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    $nSumSubXsdQty          = number_format($aValue["FCXsdQty_SubTotal"], $nOptDecimalShow);
                                    $cSumSubXsdAmtB4DisChg  = number_format($aValue["FCXsdAmtB4DisChg_SubTotal"], $nOptDecimalShow);
                                    $cSumSubXsdDis          = number_format($aValue["FCXsdDis_SubTotal"], $nOptDecimalShow);
                                    // $cSumSubXsdVat          = number_format($aValue["FCXsdSetPrice_SubTotal"], $nOptDecimalShow);
                                    $cSumSubXsdNetAfHD      = number_format($aValue["FCXsdNetAfHD_SubTotal"], $nOptDecimalShow);
                                    $tSumBranch             = $aDataTextRef['tRptTotal'].' '.$aDataTextRef['tRptBranch'].' '.$aValue["FTBchCode"];

                                    $aSumFooter             = array($tSumBranch,'N',$nSumSubXsdQty,'N',$cSumSubXsdAmtB4DisChg,$cSumSubXsdDis,'N',$cSumSubXsdNetAfHD);

                                    //Step 4 : สั่ง Summary SubFooter
                                    //Parameter
                                    //$nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    //$nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    //$aSumFooter       =  ข้อมูล Summary SubFooter
                                    FCNtHRPTSumSubFooter3($nGroupMember,$nRowPartID,$aSumFooter,2);

                                    //Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nSumFootXsdQty             = number_format($aValue["FCXsdQty_Footer"], $nOptDecimalShow);
                                    $cSumFootXsdAmtB4DisChg     = number_format($aValue["FCXsdAmtB4DisChg_Footer"], $nOptDecimalShow);
                                    $cSumFootXsdDis             = number_format($aValue["FCXsdDis_Footer"], $nOptDecimalShow);
                                    // $cSumSubXsdVat              = number_format($aValue["FCXsdSetPrice_Footer"], $nOptDecimalShow);
                                    $cSumFootXsdNetAfHD         = number_format($aValue["FCXsdNetAfHD_Footer"], $nOptDecimalShow);
                                    $paFooterSumData            = array($aDataTextRef['tRptTotalFooter'],'N','N',$nSumFootXsdQty,'N',$cSumFootXsdAmtB4DisChg,$cSumFootXsdDis,'N',$cSumFootXsdNetAfHD);
                                ?>
                            <?php endforeach;?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                            ?>

                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>

             <!-- ============================ ฟิวเตอร์ข้อมูล ============================ -->
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

            <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))): ?>

                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tPdtNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['tPdtNameTo'];?></label>
                    </div>
                </div>

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtGrpNameFrom']) && !empty($aDataFilter['tPdtGrpNameFrom'])) && (isset($aDataFilter['tPdtGrpNameTo']) && !empty($aDataFilter['tPdtGrpNameTo']))): ?>

                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'].' : </span>'.$aDataFilter['tPdtGrpNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'].' : </span>'.$aDataFilter['tPdtGrpNameTo'];?></label>
                    </div>
                </div>

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
            <?php if((isset($aDataFilter['tPdtTypeNameFrom']) && !empty($aDataFilter['tPdtTypeNameFrom'])) && (isset($aDataFilter['tPdtTypeNameTo']) && !empty($aDataFilter['tPdtTypeNameTo']))): ?>

                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeFrom'].' : </span>'.$aDataFilter['tPdtTypeNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeTo'].' : </span>'.$aDataFilter['tPdtTypeNameTo'];?></label>
                    </div>
                </div>

            <?php endif;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทจุดขาย ============================ -->
            <?php if(isset($aDataFilter['tPosType'])){ ?>

                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']];?></label>
                    </div>
                </div>

            <?php } ?>


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
