

<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $aDataSumFoot   = $aDataViewRpt['aDataSumFoot'];

    $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];

?>
<style>

 /** Set Media Print */
 @media print{@page {size: A4 landscape;}}
 
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
        border-bottom : 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
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
        /* border-bottom: 6px double black !important; */
    }

    .table tbody tr.xCNRptSumFooterTr,
    .table>tbody>tr.xCNRptSumFooterTr>td {
        border: 0px solid black !important;
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tfoot>tr {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }
</style>

<div id="odvRptTaxSalePosHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if(isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
                    
                        <div class="text-left">
                            <label class="xCNRptCompany"><?=$aCompanyInfo['FTCmpName']?></label>
                        </div>

                        <?php if($aCompanyInfo['FTAddVersion'] == '1'){ // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label ><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']?>
                                <?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>

                        <?php if($aCompanyInfo['FTAddVersion'] == '2'){ // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?=$aCompanyInfo['FTAddV2Desc1']?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?=$aCompanyInfo['FTAddV2Desc2']?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel']?> <?=$aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax']?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName']?></label>
                        </div>
                    
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptDailySalePosAddrTaxNo'] . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']?> : </label>  <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?>  </label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?>    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </label> <label><?=$aDataFilter['tBchNameTo'];?></label>
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
                            <th nowrap class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvDate'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvbill'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvPricetotal'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvPriceDiscount'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvPriceAfterDiscount'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvVatTable'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvVat'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvAll'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvEL'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvDA'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptDailySalePosSvTD'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>  

                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>

                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="text-center xCNRptDetail"><?php echo date('d/m/Y',strtotime($aValue['FDXshDocDate'])); ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FNcshCountBill'],0) ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdGrandTotal"],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXshCashCoupon'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXshAmtAFDisc'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdVatable'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdVat'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXshAllInOne'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXshElocker'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXshDoctor'],2)?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXshTelemedi'],2)?></td>
                                </tr>
                                <?php
                                    // Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $paFooterSumData = array(
                                        $aDataTextRef['tRptDailySalePosFooter'],
                                        number_format($aDataSumFoot["FNcshCountBill_Sum"],0),
                                        number_format($aDataSumFoot["FCXsdGrandTotal_Sum"],2),
                                        number_format($aDataSumFoot["FCXshCashCoupon_Sum"],2),
                                        number_format($aDataSumFoot["FCXshAmtAFDisc_Sum"],2),
                                        number_format($aDataSumFoot["FCXsdVatable_Sum"],2),
                                        number_format($aDataSumFoot["FCXsdVat_Sum"],2),
                                        number_format($aDataSumFoot["FCXshAllInOne_Sum"],2),
                                        number_format($aDataSumFoot["FCXshElocker_Sum"],2),
                                        number_format($aDataSumFoot["FCXshDoctor_Sum"],2),
                                        number_format($aDataSumFoot["FCXshTelemedi_Sum"],2),
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
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo $aDataTextRef['tRptTaxSalePosNoData'];?></td></tr>
                        <?php } ;?>
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
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerNameTo']) && !empty($aDataFilter['tMerNameTo']))) : ?>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
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


