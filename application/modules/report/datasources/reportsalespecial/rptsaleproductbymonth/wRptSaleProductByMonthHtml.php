<?php
$aCompanyInfo       = $aDataViewRpt['aCompanyInfo'];
$aDataFilter        = $aDataViewRpt['aDataFilter'];
$aDataTextRef       = $aDataViewRpt['aDataTextRef'];
$aDataReport        = $aDataViewRpt['aDataReport'];
$nOptDecimalShow    = $aDataViewRpt['nOptDecimalShow'];
?>

<style>
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
        border-bottom: 6px double black !important;
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

    /*แนวนอน*/
    @media print{@page {
        size: A4 portrait;
        }}

    } 
</style>


<?php 
    //ประเภทการชำระเงินจาก
    switch ($aDataFilter['tPosTypeFrom']) {
        case "1":
            $tPosTypeFrom = 'Vending QR';
            $bPosTypeFrom = true;
            break;
        case "2":
            $tPosTypeFrom = "POS Cash";
            $bPosTypeFrom = true;
            break;
        case "3":
            $tPosTypeFrom = "POS QR";
            $bPosTypeFrom = true;
            break;
        case "4":
            $tPosTypeFrom = "POS EDC";
            $bPosTypeFrom = true;
            break;
        default:
            $tPosTypeFrom = $aDataTextRef['tRptSaleTypeSalePaymentAll'];
            $bPosTypeFrom = false;
    }

    //ประเภทการชำระเงินถึง
    switch ($aDataFilter['tPosTypeTo']) {
        case "1":
            $tPosTypeTo = 'Vending QR';
            $bPosTypeTo = true;
            break;
        case "2":
            $tPosTypeTo = "POS Cash";
            $bPosTypeTo = true;
            break;
        case "3":
            $tPosTypeTo = "POS QR";
            $bPosTypeTo = true;
            break;
        case "4":
            $tPosTypeTo = "POS EDC";
            $bPosTypeTo = true;
            break;
        default:
            $tPosTypeTo = $aDataTextRef['tRptSaleTypeSalePaymentAll'];
            $bPosTypeTo = false;
    }
?>

<div id="odvRptProductTransferHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?>
                                    <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxSalePosTaxId'] . ' ' . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>

                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                            
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>
                
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </span>   <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </span>      <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tMonthFrom']) && !empty($aDataFilter['tMonthFrom'])) && (isset($aDataFilter['tMonthTo']) && !empty($aDataFilter['tMonthTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ช่วงเดือน ============================ -->
                        <?php
                            $tTextMonthFrom     = 'tRptMonth'.$aDataFilter['tMonthFrom'];
                            $tTextMonthTo       = 'tRptMonth'.$aDataFilter['tMonthTo'];
                            $tYear              = $aDataFilter['tYear'];
                        ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center xCNRptFilter">
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTMonthBetweenFrom']?> : </span>   <label><?=$aDataTextRef[$tTextMonthFrom]; ?></label>&nbsp;
                                    <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTMonthBetweenTo']?> : </span>    <label><?=$aDataTextRef[$tTextMonthTo]; ?> <?=$tYear?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 "></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <?php date_default_timezone_set('Asia/Bangkok'); ?>
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:left; width:10%;"><?=$aDataTextRef['tRptMonthOnly']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:right; width:5%;"><?=$aDataTextRef['tRptRentBillAmount']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:right; width:10%;"><?=$aDataTextRef['tRptSalePDTMonthTotal']; ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:right; width:10%; display:none;" id="othDataType1">Vending QR</th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:right; width:10%; display:none;" id="othDataType2">POS Cash</th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:right; width:10%; display:none;" id="othDataType3">POS QR</th>
                            <th nowrap class="text-left xCNRptColumnHeader"   style="vertical-align : middle;text-align:right; width:10%; display:none;" id="othDataType4">POS EDC</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <!--กลาง-->
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <tr>
                                    <?php
                                        if(strlen($aValue['FTXshDocMonth']) == 1){
                                            $tTextMonth  = 'tRptMonth0'.$aValue['FTXshDocMonth'];
                                        }else{
                                            $tTextMonth  = 'tRptMonth'.$aValue['FTXshDocMonth'];
                                        }
                                    ?>
                                    <td class="text-left xCNRptDetail"><?=$aDataTextRef[$tTextMonth]; ?></td>
                                    <td class="text-right xCNRptDetail"><?=number_format($aValue["FNXshTotalBill"] , 0);?></td>
                                    <td class="text-right xCNRptDetail"><?=number_format($aValue["FCXshGrand"], $nOptDecimalShow)?></td>
                                    <td class="text-right xCNRptDetail xTDDataType1" style="display:none;"><?=number_format($aValue["FCXrcNetVDQR"], $nOptDecimalShow)?></td>
                                    <td class="text-right xCNRptDetail xTDDataType2" style="display:none;"><?=number_format($aValue["FCXrcNetPosCash"], $nOptDecimalShow)?></td>
                                    <td class="text-right xCNRptDetail xTDDataType3" style="display:none;"><?=number_format($aValue["FCXrcNetPosQR"], $nOptDecimalShow)?></td>
                                    <td class="text-right xCNRptDetail xTDDataType4" style="display:none;"><?=number_format($aValue["FCXrcNetPosEDC"], $nOptDecimalShow)?></td>
                                </tr>    
                            <?php } ?>

                            <!--ล่าง-->                
                            <?php
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];

                                if ($nPageNo == $nTotalPage) { ?>
                                    <tr class='xCNRptSumFooterTr'>
                                        <td class="text-left xCNRptSumFooter"><?=$aDataTextRef['tRptTotalFooter']; ?></td>
                                        <td class="text-right xCNRptSumFooter"><?=number_format($aValue["FNXshTotalBill_Footer"],0)?></td>
                                        <td class="text-right xCNRptSumFooter"><?=number_format($aValue["FCXshGrand_Footer"], $nOptDecimalShow)?></td>
                                        <td class="text-right xCNRptSumFooter xTDFooterDataType1" style="display:none;"><?=number_format($aValue["FCXrcNetVDQR_Footer"], $nOptDecimalShow)?></td>
                                        <td class="text-right xCNRptSumFooter xTDFooterDataType2" style="display:none;"><?=number_format($aValue["FCXrcNetPosCash_Footer"], $nOptDecimalShow)?></td>
                                        <td class="text-right xCNRptSumFooter xTDFooterDataType3" style="display:none;"><?=number_format($aValue["FCXrcNetPosQR_Footer"], $nOptDecimalShow)?></td>
                                        <td class="text-right xCNRptSumFooter xTDFooterDataType4" style="display:none;"><?=number_format($aValue["FCXrcNetPosEDC_Footer"], $nOptDecimalShow)?></td>
                                    </tr>
                                <?php }
                            ?>

                        <?php } else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData']; ?></td></tr>
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

                <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
                <?php 
                    if($bPosTypeFrom == false || $bPosTypeTo == false){ ?>
                        <div class="xCNRptFilterBox">
                            <div class="text-left xCNRptFilter">
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTByDayType'].' : </span>'.$aDataTextRef['tRptSaleTypeSalePaymentAll'];?></label>
                            </div>
                        </div>
                    <?php }else{ ?>
                        <div class="xCNRptFilterBox">
                            <div class="text-left xCNRptFilter">
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTByDayTypeFrom'].' : </span>'.$tPosTypeFrom;?></label>
                                <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTByDayTypeTo'].' : </span>'.$tPosTypeTo;?></label>
                            </div>
                        </div>
                    <?php }
                ?>
        </div>
        
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0) { ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php } ?>
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
        
        //control การเอามาแสดง
        var nPosTypeFrom    =  '<?=$aDataFilter['tPosTypeFrom']?>';
        var nPosTypeTo      =  '<?=$aDataFilter['tPosTypeTo']?>';
        if(nPosTypeFrom == '' || nPosTypeTo == ''){
            nPosTypeFrom    = 1;
            nPosTypeTo      = 4;
        }

        //เลือกถึงน้อยกว่า จาก
        if(nPosTypeTo < nPosTypeFrom){
            nOldForm        = nPosTypeFrom;
            nOldTo          = nPosTypeTo;

            nPosTypeFrom    = nOldTo;
            nPosTypeTo      = nOldForm;
        }

        for(i=nPosTypeFrom; i<=nPosTypeTo; i++){
            $('#othDataType'+i).show();
            $('.xTDDataType'+i).show();
            $('.xTDFooterDataType'+i).show();
        }
        
    });
</script>