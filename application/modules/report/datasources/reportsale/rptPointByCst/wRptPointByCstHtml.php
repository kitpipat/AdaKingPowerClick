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

    .table>thead:first-child>tr:nth-child(1)>td, .table>thead:first-child>tr:nth-child(1)>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;

        /* background-color: #CFE2F3 !important; */
    }

    .table>thead:first-child>tr:nth-child(2)>td, .table>thead:first-child>tr:nth-child(2)>th {
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
        border-bottom: 1px solid black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
    .table>tbody>tr>td.xCNRptDetail:nth-child(5), .table>tbody>tr>td.xCNRptDetail:nth-child(5) {
        border-right: 1px dashed #ccc !important;
    }
    .table>tbody>tr>td.xCNRptGrouPing:nth-child(7), .table>tbody>tr>td.xCNRptGrouPing:nth-child(7) {
        border-right: 1px dashed #ccc !important;
    }
    .table>tbody>tr.xCNTrFooter>td:nth-child(5), .table>tbody>tr.xCNTrFooter>td:nth-child(5) {
        border-right: 1px dashed #ccc !important;
    }
    /*แนวนอน*/
    @media print{@page {
        size: A4 landscape;
        /* margin: 5mm 5mm 5mm 5mm; */
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
        }
    }
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/

</style>

<div id="odvRptPointByCstHtml">
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

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxPointByCstDocDateFrom']?></label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?>  </label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxPointByCstDocDateTo']?></label>     <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?>    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxPointByCstBchFrom']?></label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxPointByCstBchTo']?></label> <label><?=$aDataFilter['tBchNameTo'];?></label>
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
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:15%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPointByCstMember']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:13%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPointByCrdCstMember']; ?></th>

                            <th style="border-bottom: 0px !important;"></th>
                            <th style="border-bottom: 0px !important; border-right: 1px dashed #ccc !important;"></th>
                            <th nowrap colspan='3' class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPointMarking']; ?></th>
                        </tr>
                        <tr style="border-bottom: 1px solid black !important;">
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPointByCstNo']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:15%;"><?php echo $aDataTextRef['tRptPointByCstNameMember']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPointByCstDateApply']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPointByCstDateExpire']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-right: 1px dashed #ccc !important;width:10%;"></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style=" width:10%;"><?php echo $aDataTextRef['tRptPointByCstReceive']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPointByCstUse']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPointByCstBalance']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach($aDataReport['aRptData'] AS $nKey => $aValue) { ?>
                                <tr>
                                    <td nowrap class="text-left xCNRptDetail"><?php echo $aValue['FTMemCode']; ?></td>
                                    <td nowrap class="text-left xCNRptDetail"><?php echo $aValue['FTCstName']; ?></td>
                                    <td class="text-left xCNRptDetail"><?php echo $aValue['rdFDCstApply'];  ?></td>
                                    <td class="text-right xCNRptDetail"><?php echo $aValue['rdFDCstCrdExpire'];  ?></td>
                                    <td nowrap class="text-left xCNRptDetail" style="border-right: 1px dashed #ccc !important;"></td>
                                    <td nowrap class="text-right xCNRptDetail" ><?php echo number_format($aValue['FCTxnPntGet'],$nOptDecimalShow);?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCTxnPntUsed'],$nOptDecimalShow);?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCTxnPntBal'],$nOptDecimalShow);?></td>
                                </tr>
                                <?php
                                    $paFooterSumData = array(
                                        $aDataTextRef['tRptRentAmtFolCourSumText'],
                                        'N',
                                        'N',
                                        'N',
                                        'N',
                                        number_format($aValue["FCTxnPntGet_Footer"],$nOptDecimalShow),
                                        number_format($aValue["FCTxnPntUsed_Footer"],$nOptDecimalShow),
                                        number_format($aValue["FCTxnPntBal_Footer"],$nOptDecimalShow)
                                    );
                                ?>

                            <?php } ?>
                                <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>

                        <?php }else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSalePosNoData'];?></td></tr>
                        <?php } ;?>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
            <?php if ((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom'].' : </span>'.$aDataFilter['tCstCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo'].' : </span>'.$aDataFilter['tCstCodeTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tCstCodeSelect']) && !empty($aDataFilter['tCstCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCstStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCstCodeSelect']; ?></label>
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
