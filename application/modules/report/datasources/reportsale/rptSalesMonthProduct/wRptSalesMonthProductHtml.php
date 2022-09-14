<?php
    $aCompanyInfo = $aDataViewRpt['aCompanyInfo'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataReport = $aDataViewRpt['aDataReport'];
    // echo "<pre>"; print_r($aDataFilter); print_r($aDataTextRef); exit;
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

    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;

    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;

        border-bottom : 6px double black !important;
    }

    .table>tfoot>tr{
        border-top: 1px solid black !important;

        border-bottom : 6px double black !important;
    }
</style>

<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'] ?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                   <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'] ?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] ?> : </label>   <label><?=$aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] ?> : </label>   <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    &nbsp;
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvRptTableShotOverHtml" class="table-responsive">
            <table class="table" >
                    <thead>
                        <tr>
                            <th  class="text-center xCNRptColumnHeader" style="width:10%" ><?php echo $aDataTextRef['tRptSMPCode']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPPdtName']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm1']; ?></th>
                            <th  class="text-right xCNRptColumnHeader" ><?php echo $aDataTextRef['tRptSMPm2']; ?></th>
                            <th  class="text-right xCNRptColumnHeader" ><?php echo $aDataTextRef['tRptSMPm3']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm4']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm5']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm6']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm7']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm8']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm9']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm10']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm11']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPm12']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptSMPSum']; ?></th>
                        </tr>
                    </thead>
                    <tbody>

                        <?php
                            if(!empty($aDataReport['aRptData'])){
                            foreach($aDataReport['aRptData'] as $aData){
                        ?>
                            <tr>
                                <td  class="text-left xCNRptDetail" ><?php echo $aData['FTPdtCode']; ?></td>
                                <td  class="text-left xCNRptDetail" ><?php echo $aData['FTPdtName']; ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty01'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty02'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty03'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty04'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty05'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty06'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty07'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty08'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty09'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty10'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty11'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQty12'],2); ?></td>
                                <td  class="text-right xCNRptDetail" ><?php echo number_format($aData['FCXsdQtyTotal'],2); ?></td>
                            </tr>
                        <?php } ?>

                        <?php
                            $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];

                            if ($nPageNo == $nTotalPage) { ?>
                                <?php 
                                    $cXrcGrand_Footer    = $aData['FCXsdQtyTotal_Footer'];
                                    $FCXsdQty01_Footer   = $aData['FCXsdQty01_Footer'];
                                    $FCXsdQty02_Footer   = $aData['FCXsdQty02_Footer'];
                                    $FCXsdQty03_Footer   = $aData['FCXsdQty03_Footer'];
                                    $FCXsdQty04_Footer   = $aData['FCXsdQty04_Footer'];
                                    $FCXsdQty05_Footer   = $aData['FCXsdQty05_Footer'];
                                    $FCXsdQty06_Footer   = $aData['FCXsdQty06_Footer'];
                                    $FCXsdQty07_Footer   = $aData['FCXsdQty07_Footer'];
                                    $FCXsdQty08_Footer   = $aData['FCXsdQty08_Footer'];
                                    $FCXsdQty09_Footer   = $aData['FCXsdQty09_Footer'];
                                    $FCXsdQty10_Footer   = $aData['FCXsdQty10_Footer'];
                                    $FCXsdQty11_Footer   = $aData['FCXsdQty11_Footer'];
                                    $FCXsdQty12_Footer   = $aData['FCXsdQty12_Footer'];
                                ?>
                                <tr class="xCNRptSumFooterTr">
                                    <td colspan="2" class="text-left xCNRptSumFooter"><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty01_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty02_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty03_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty04_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty05_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty06_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty07_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty08_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty09_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty10_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty11_Footer,2); ?></td>
                                    <td  class="text-right xCNRptSumFooter" ><?php echo number_format($FCXsdQty12_Footer,2); ?></td>
                                    <td class="text-right xCNRptSumFooter"><?php echo number_format($cXrcGrand_Footer,2); ?></td>
                                </tr>
                            <?php }
                        ?>
                        <?php  }else{ ?>
                        <tr>
                            <td  colspan="14"  class="text-center xCNRptColumnFooter"   ><?php echo $aDataTextRef['tRptNoData']; ?></td>
                        </tr>
                    <?php } ?>
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


                        <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
                        <?php if ((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tCstCodeSelect']) && !empty($aDataFilter['tCstCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCstStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCstNameSelect']; ?></label>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระ ============================ -->
            <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvFrom'].' : </span>'.$aDataFilter['tRcvNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvTo'].' : </span>'. $aDataFilter['tRcvNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ปี ============================ -->
            <?php if ((isset($aDataFilter['tYear']) && !empty($aDataFilter['tYear']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptYear'].' </span>'.$aDataFilter['tYear'];?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล แคชเชียร์ ============================ -->
            <?php if ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierFrom'].' : </span>'.$aDataFilter['tCashierNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierTo'].' : </span>'.$aDataFilter['tCashierNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tCashierCodeSelect']) && !empty($aDataFilter['tCashierCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCashierFrom']; ?> : </span> <?php echo ($aDataFilter['bCashierStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCashierCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
            <?php if((isset($aDataFilter['tRptPdtCodeFrom']) && !empty($aDataFilter['tRptPdtCodeFrom'])) && (isset($aDataFilter['tRptPdtCodeTo']) && !empty($aDataFilter['tRptPdtCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tRptPdtNameFrom'];?></label>
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['tRptPdtNameTo'];?></label>
                    </div>
                </div>
            <?php endif;?>

        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0): ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif; ?>
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
