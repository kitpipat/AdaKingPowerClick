<?php
    $aCompanyInfo = $aDataViewRpt['aCompanyInfo'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataReport = $aDataViewRpt['aDataReport'];

    $aMonthLFilter[1] = array(
        '01' => 'มกราคม',
        '02' => 'กุมภาพันธ์',
        '03' => 'มีนาคม',
        '04' => 'เมษายน',
        '05' => 'พฤษภาคม',
        '06' => 'มิถุนายน',
        '07' => 'กรกฎาคม',
        '08' => 'สิงหาคม',
        '09' => 'กันยายน',
        '10' => 'ตุลาคม',
        '11' => 'พฤศจิกายน',
        '12' => 'ธันวาคม',
    );

    $aMonthLFilter[2] = array(
        '01' => 'JANUARY',
        '02' => 'FEBRUARY',
        '03' => 'MARCH',
        '04' => 'APRIL',
        '05' => 'MAY',
        '06' => 'JUNE',
        '07' => 'JULY',
        '08' => 'AUGUST',
        '09' => 'SEPTEMBER',
        '10' => 'OCTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DECEMBER',
    );


    $aMonthL[1] = array(
        '1' => 'มกราคม',
        '2' => 'กุมภาพันธ์',
        '3' => 'มีนาคม',
        '4' => 'เมษายน',
        '5' => 'พฤษภาคม',
        '6' => 'มิถุนายน',
        '7' => 'กรกฎาคม',
        '8' => 'สิงหาคม',
        '9' => 'กันยายน',
        '10' => 'ตุลาคม',
        '11' => 'พฤศจิกายน',
        '12' => 'ธันวาคม',
    );

    $aMonthL[2] = array(
        '1' => 'JANUARY',
        '2' => 'FEBRUARY',
        '3' => 'MARCH',
        '4' => 'APRIL',
        '5' => 'MAY',
        '6' => 'JUNE',
        '7' => 'JULY',
        '8' => 'AUGUST',
        '9' => 'SEPTEMBER',
        '10' => 'OCTOBER',
        '11' => 'NOVEMBER',
        '12' => 'DECEMBER',
    );

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
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 1px solid black !important;
    }
    


    /*แนวนอน*/
    /* @media print{@page {size: landscape}}  */
    /*แนวตั้ง*/
    @media print{
        @page {
        size: A4 landscape;
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
       
        }
       
        }
    
    /* @media print
{
    table.table     { page-break-after: auto; }
    table.table   tr    { page-break-inside:avoid;page-break-after: auto; }
    table.table   td    { page-break-inside:avoid; page-break-after:auto }
    table.table   thead { display:table-header-group }
    table.table   tfoot { display:table-footer-group }
} */


</style>

<div id="odvRptAdjustStockVendingHtml">
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
                                <label><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?> <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?></label>
                            <label><?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'] ?></label>
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
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tRptCrSaleMonth-Title']; ?></label>
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

                    <?php if ((isset($aDataFilter['tMonth']) && !empty($aDataFilter['tMonth'])) && (isset($aDataFilter['tMonthT']) && !empty($aDataFilter['tMonthT']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTMonthBetweenFrom'] ?> : </label>   <label><?=$aMonthLFilter[$aDataFilter['nLangID']][$aDataFilter['tMonth']]; ?></label>
                                    &nbsp;
                                   <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptSalePDTMonthBetweenTo'] ?> : </label>   <label><?=$aMonthLFilter[$aDataFilter['nLangID']][$aDataFilter['tMonthT']].' '.$aDataFilter['tYear'] ?></label> 
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
            <div id="odvRptTableAdvance" class="table-responsive">
            <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-left xCNRptColumnHeader" style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-Month']; ?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-QtyBill']; ?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-GrandTotal']; ?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:10%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-CuponDiscount']; ?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-AmtAFdisc']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-Vatable']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-Vat']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-allinone']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-E-locker']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:10%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-Doctor']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptCrSaleMonth-Telemedicine']; ?></th>
                          
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                     if(!empty($aDataReport['aRptData'])){
                         foreach($aDataReport['aRptData'] as $aData){

                            $nCshCountBill_Footer=$aData['FNcshCountBill_Footer'];
                            $cXsdGrandTotal_Footer=$aData['FCXsdGrandTotal_Footer'];
                            $cXshCashCoupon_Footer=$aData['FCXshCashCoupon_Footer'];
                            $cXshAmtAFDisc_Footer=$aData['FCXshAmtAFDisc_Footer'];
                            $cXsdVatable_Footer=$aData['FCXsdVatable_Footer'];
                            $cXsdVat_Footer=$aData['FCXsdVat_Footer'];
                            $cXshAllInOne_Footer=$aData['FCXshAllInOne_Footer'];
                            $cXshElocker_Footer=$aData['FCXshElocker_Footer'];
                            $cXshDoctor_Footer=$aData['FCXshDoctor_Footer'];
                            $cXshTelemedi_Footer=$aData['FCXshTelemedi_Footer'];

                    ?>
                        <tr>
                            <td  class="text-left xCNRptDetail" style="width:5%;  "><?php echo $aMonthL[$aDataFilter['nLangID']][$aData['FNSaleMonthly']]; ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%; "><?php echo number_format($aData['FNcshCountBill'],0); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%; "><?php echo number_format($aData['FCXsdGrandTotal'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%; "><?php echo number_format($aData['FCXshCashCoupon'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:10%; "><?php echo number_format($aData['FCXshAmtAFDisc'],2); ?></td>
                            <td  class="text-right xCNRptDetail"style="width:5%;"><?php echo number_format($aData['FCXsdVatable'],2); ?></td>
                            <td  class="text-right xCNRptDetail"style="width:5%;"><?php echo number_format($aData['FCXsdVat'],2); ?></td>
                            <td  class="text-right xCNRptDetail"style="width:5%;"><?php echo number_format($aData['FCXshAllInOne'],2); ?></td>
                            <td  class="text-right xCNRptDetail"style="width:5%;"><?php echo number_format($aData['FCXshElocker'],2); ?></td>
                            <td  class="text-right xCNRptDetail"style="width:5%;"><?php echo number_format($aData['FCXshDoctor'],2); ?></td>
                            <td  class="text-right xCNRptDetail"style="width:5%;"><?php echo number_format($aData['FCXshTelemedi'],2); ?></td>
                
         
                        </tr>
                    <?php
                            }
                            ?>
                        <tr class="xCNTrFooter">
                            <td    class="text-left xCNRptSumFooter"   ><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($nCshCountBill_Footer,0); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXsdGrandTotal_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXshCashCoupon_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXshAmtAFDisc_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXsdVatable_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXsdVat_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXshAllInOne_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXshElocker_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXshDoctor_Footer,2); ?></td>
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXshTelemedi_Footer,2); ?></td>
                        </tr>

                     <?php   }else{ 
                            ?>
                        <tr>
                            <td  colspan="11"  class="text-center xCNRptColumnFooter"   ><?php echo $aDataTextRef['tRptNoData']; ?></td>
                        </tr>
                    <?php   
                    }
                    ?>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระ ============================ -->
            <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvFrom'].' : </span>'.$aDataFilter['tRcvNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvTo'].' : </span>'. $aDataFilter['tRcvNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- ============================ ฟิวเตอร์ข้อมูล เครืองจุดขาย ============================ -->
            <?php if ((isset($aDataFilter['nPosType']) && !empty($aDataFilter['nPosType']))){ ?>
                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['nPosType']] ?></label>
                    </div>
                </div> -->
            <?php }else{ ?>
                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['nPosType']] ?></label>
                    </div>
                </div> -->
            <?php } ?>
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













