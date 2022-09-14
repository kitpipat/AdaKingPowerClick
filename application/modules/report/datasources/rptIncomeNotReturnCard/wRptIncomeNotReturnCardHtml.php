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


    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }

    /*แนวนอน*/
    @media print{@page {
        size: A4 portrait;
        margin: 5mm 5mm 5mm 5mm;
        }
    }
</style>

<div id="odvRptMovePosVDHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>


                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']?></label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?>  </label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']?></label>     <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?>    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>


                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?></label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?></label> <label><?=$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>
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
                        <tr style="border-bottom: 2px solid #ffffff !important;">
                            <th style="width:10%" nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptIncomeNotReturnCardBranch');?></th>
                            <th style="width:15%" nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptIncomeNotReturnCardShop');?></th>
                            <th style="width:15%" nowrap class="text-left xCNRptColumnHeader">&nbsp;</th>
                            <th style="width:15%" nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptIncomeNotReturnCardPos');?></th>
                            <th style="width:15%" nowrap class="text-left xCNRptColumnHeader">&nbsp;</th>
                            <th style="width:15%" nowrap class="text-left xCNRptColumnHeader">&nbsp;</th>
                            <th style="width:15%" nowrap class="text-left xCNRptColumnHeader">&nbsp;</th>
                        </tr>

                        <tr style="border-bottom: 1px solid black !important">
                            <th nowrap class="text-left xCNRptColumnHeader">&nbsp;</th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptIncomeNotReturnCardSeq');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo language('report/report/report','tRptIncomeNotReturnCardCode');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php //echo language('report/report/report','tRptIncomeNotReturnCardTopupDate');?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"><?php //echo language('report/report/report','tRptIncomeNotReturnCardUsr');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo language('report/report/report','tRptIncomeNotReturnCardAmt');?></th>
                        </tr>
                    <thead>
                    <tbody>
                    <?php
                     if(!empty($aDataReport['aRptData'])){

                            $tPosCode   = '';
                            $tShpCode   = '';
                            $tCrdCode   = '';
                            $tBchCode   = '';


                         foreach($aDataReport['aRptData'] as $k => $aValue){

                            $nCrdValue_SubTotal = $aValue['FCTxnCrdValue_SubTotal'];
                            $nCrdValue_Footer   = $aValue['FCTxnCrdValue_Footer'];


                            ?>

                            <?php  if($tBchCode!=$aValue['FTBchCode']){ ?>
                                <tr>
                                    <td colspan="6" class="text-left xCNRptSumFooter"><?php echo "(".$aValue['FTBchCode'].") ".$aValue['FTBchName']; ?></td>
                                </tr>
                            <?php } ?>

                            <?php if( ($tShpCode != $aValue['FTShpName']) || ($tPosCode != $aValue['FTPosName']) ){ ?>
                                <tr>
                                    <td class="text-left xCNRptDetail xCNRptGrouPing">&nbsp;</td>
                                    <td class="text-left xCNRptDetail xCNRptGrouPing"><?php echo (!empty($aValue['FTShpName']) ? $aValue['FTShpName'] : '-' );?></td>
                                    <td class="text-left xCNRptDetail xCNRptGrouPing">&nbsp;</td>
                                    <td class="text-left xCNRptDetail xCNRptGrouPing"><?php echo (!empty($aValue['FTPosName']) ? $aValue['FTPosName'] : '-' );?></td>
                                </tr>
                            <?php } ?>
                            <tr >
                              <td class="text-left xCNRptDetail">&nbsp;</td>
                                <td class="text-left xCNRptDetail"><?php echo $aValue['FNRowPartID'];?></td>
                                <td class="text-left xCNRptDetail"><?php echo $aValue['FTCrdCode'];?></td>
                                <td class="text-left xCNRptDetail">&nbsp;</td>
                                <td class="text-left xCNRptDetail"><?php //echo date('d/m/Y',strtotime($aValue['FDTxnTopupDate'])); ?></td>
                                <td class="text-center xCNRptDetail"><?php //echo $aValue['FTUsrName'];?></td>
                                <td class="text-right xCNRptDetail"><?php echo number_format($aValue['FCTxnCrdValue'],$nOptDecimalShow);?></td>
                            </tr >
                            <?php  if($aValue['FNRowPartID_MaxSeq']== $aValue['FNRowPartID']){ ?>
                                <tr>
                                    <td  style="border-bottom: 1px dashed #ccc !important;" class="text-left xCNRptDetail">&nbsp;</td>
                                    <td  style="border-bottom: 1px dashed #ccc !important;" colspan="1" class="text-left xCNRptSumFooter xCNRptGrouPing"><?php echo language('report/report/report','tRptTotal');?></td>
                                    <td  style="border-bottom: 1px dashed #ccc !important;" colspan="3" class="text-left xCNRptDetail ">&nbsp;</td>
                                    <td  style="border-bottom: 1px dashed #ccc !important;" colspan="2" class="text-right xCNRptDetail xCNRptGrouPing"><?php echo number_format($aValue["FCTxnCrdValue_SubTotal"], $nOptDecimalShow);?></td>
                                </tr>
                            <?php } ?>
                            <?php
                                $tShpCode   = $aValue['FTShpName'];
                                $tPosCode   = $aValue['FTPosName'];
                                $tCrdCode   = $aValue['FTCrdCode'];
                                $tBchCode   = $aValue['FTBchCode'];
                            ?>

                        <?php } ?>
                        <?php

                            $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                            if ($nPageNo == $nTotalPage) {
                        ?>

                                <tr style="border-bottom: 1px solid black !important;border-top: 1px solid black !important">
                                    <td class="text-left xCNRptSumFooter"><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                                    <td class="text-center xCNRptDetail"></td>
                                    <td class="text-center xCNRptDetail"></td>
                                    <td class="text-center xCNRptDetail"></td>
                                    <td class="text-center xCNRptDetail"></td>
                                    <td class="text-center xCNRptDetail"></td>
                                    <td class="text-right xCNRptSumFooter"><?php echo number_format($aValue['FCTxnCrdValue_Footer'],$nOptDecimalShow);?></td>
                                </tr>
                            <?php  } ?>
                        <?php }else{ ?>
                            <tr>
                                <td  colspan="6"  class="text-center xCNRptColumnFooter" ><?php echo $aDataTextRef['tRptNoData']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>

                    <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                    <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="xCNRptFilter">
                                <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                                <br>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                    <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                        <div class="xCNRptFilterBox">
                            <div class="xCNRptFilter">
                                <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
                            </div>
                        </div>
                    <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
                <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
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
