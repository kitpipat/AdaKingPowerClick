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
    /*@media print{@page {size: landscape}}*/ 
    /*แนวตั้ง*/
    @media print{
        @page {
        size: A4 portrait;
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
       
        }
       
        }
    


</style>

<div id="odvRptSaleVatInvoiceByBillHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <!-- Witsarut (Bell) แก้ไขที่อยู่ วันที่ 24/09/2562 -->
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
                        <div class="text-left">
                            <label class="xCNRptCompany"><?php echo $aCompanyInfo['FTCmpName']; ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  ?>
                            <div class="xCNRptAddress">
                                <label ><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?> <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>


                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  ?>
                            <div class="xCNRptAddress">
                                <label ><?php echo $aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="xCNRptAddress">
                                <label ><?php echo $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="xCNRptAddress">
                            <label ><?php echo $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?> <?php echo $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax']; ?></label>
                        </div>

                        <div class="xCNRptAddress">
                            <label ><?php echo $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName']; ?></label>
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
                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- Create By Witsarut 24/09/2019 update Fillter ก่อนหน้านั้นไม่มีการ Fillter ข้อมูล -->
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>    

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>   
        </div>
        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') { ?>

                    <table class="table">
                        <thead>
                        <th nowrap  class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPayby']; ?></th>    
                        <th nowrap  class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptTotal']; ?></th>    
                        </thead>
                        <tbody>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td></tr>
                        </tbody>
                    </table>
                    <?php
                    // Check Page Footer Show Total Sum
                    // $oOptionKoolRpt = array(
                    //     "dataSource" => $this->dataStore("RptLocPayMent"),
                    //     "cssClass" => array(
                    //         "table" => "table",
                    //     ),
                    //     "showFooter" => true,
                    //     "columns" => array(
                    //         "FTRcvName" => array(
                    //             "label" => $aDataTextRef['tRptPayby'],
                    //             "formatValue" => function($tValue, $aDataRowRpt) {
                    //                 $tRptRcvNameEmpty = $this->params['aDataTextRef']['tRptRcvNameEmpty'];
                    //                 if ((isset($aDataRowRpt['FTRcvCode']) && !empty($aDataRowRpt['FTRcvCode'])) && (isset($aDataRowRpt['FTRcvName']) && !empty($aDataRowRpt['FTRcvName']))) {
                    //                     return $tValue;
                    //                 } else {
                    //                     return $tRptRcvNameEmpty;
                    //                 }
                    //             },
                    //             "cssStyle" => array(
                    //                 "th" => "text-align:left; white-space:nowrap; font-weight: bold; background-color:#CFE2F3;",
                    //                 "td" => "text-align:left;",
                    //                 "tf" => "text-align:left; font-weight: bold; background-color:#CFE2F3;"
                    //             ),
                    //             "footerText" => "<b>รวม</b>"
                    //         ),
                    //         "NET" => array(
                    //             "label" => $aDataTextRef['tRptTotal'],
                    //             "type" => "number",
                    //             "decimals" => 2,
                    //             "footer" => "sum",
                    //             "cssStyle" => array(
                    //                 "th" => "text-align: right; white-space:nowrap; font-weight: bold; background-color:#CFE2F3;",
                    //                 "td" => "text-align:right;",
                    //                 "tf" => "text-align:right; font-weight: bold; background-color:#CFE2F3;"
                    //             )
                    //         )
                    //     )
                    // );
                    // Table::create($oOptionKoolRpt);
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                        <th nowrap  class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptPayby']; ?></th>    
                        <th nowrap  class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptTotal']; ?></th>    
                        </thead>
                        <tbody>
                            <tr><td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td></tr>
                        </tbody>
                    </table>
                <?php } ?>
            </div>
            <?php if($aDataReport['rtCode'] == '800' || $nCurrentPage == $nAllPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo @$aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>
                <?php if((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo $aDataFilter['tShopNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopTo']; ?> : </span> <?php echo $aDataFilter['tShopNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo $aDataFilter['tPosNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTo']; ?> : </span> <?php echo $aDataFilter['tPosNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))): ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvFrom']; ?> : </span> <?php echo $aDataFilter['tRcvNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvTo']; ?> : </span> <?php echo $aDataFilter['tRcvNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif;?>
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









