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
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom : 6px double black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        color: #232C3D !important;
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
</style>
<div id="odvRptSalePaymentSummaryHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchFrom'].' '.$aDataFilter['tBchNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchTo'].' '.$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if( (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'].' '.$aDataFilter['tShpNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'].' '.$aDataFilter['tShpNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if( (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosFrom'].' '.$aDataFilter['tPosNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosTo'].' '.$aDataFilter['tPosNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if( (isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptRcvFrom'].' '.$aDataFilter['tRcvNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptRcvTo'].' '.$aDataFilter['tRcvNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    <?php if( (isset($aDataFilter['tDateFrom']) && !empty($aDataFilter['tDateFrom'])) && (isset($aDataFilter['tDateTo']) && !empty($aDataFilter['tDateTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'].' '.$aDataFilter['tDateFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'].' '.$aDataFilter['tDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo @$aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.@$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvTblRptSalePaymentSummary" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNTextBold" style="width:40%;"><?php echo @$aDataTextRef['tRptPayby'];?></th>
                            <th nowrap class="text-right xCNTextBold" style="width:60%;"><?php echo @$aDataTextRef['tRptTotalSale'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nSubSumXrcNet  = 0;
                                $nSumFooterXrcNet   = 0;
                                $row = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): $row++ ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $tRcvCode       = $aValue["FTRcvCode"];
                                    $nGroupMember   = $aValue["FNRptGroupMember"];
                                    $nRowPartID     = $aValue["FNRowPartID"];
                                ?>
                                <?php
                                    //Step 2 Groupping data
                                    // $aGrouppingData = array($tRcvCode);
                                    // Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                    // $result = FCNtHRPTHeadSSGGroupping($nRowPartID,$aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="text-left"><?php echo $aValue["FTRcvName"];?></td>
                                    <td nowrap class="text-right"><?php echo $aValue["FCXrcNet"];?></td>
                                </tr>
                                <?php
                                    //Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    // $nSubSumAjdWahB4Adj = $aValue["FCSdtSubQty"];
                                    // $nSubSumAjdUnitQty  = $aValue["FCXrcNetFooter"];

                                    // $aSumFooter         = array('รวม'.$aValue["FTRcvName"],'N','N',$nSubSumAjdWahB4Adj);

                                    // Step 4 : สั่ง Summary SubFooter
                                    // Parameter
                                    // $nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    // $nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    // $aSumFooter       =  ข้อมูล Summary SubFooter
                                    // FCNtHRPTSumSubFooter($nGroupMember,$nRowPartID,$aSumFooter);


                                    //Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nSumFooterXrcNet   = number_format($aValue["FCXrcNet_Footer"],2);
                                    $paFooterSumData    = array($aDataTextRef['tRptTotalSale'],$nSumFooterXrcNet);
                                ?>
                            <?php endforeach;?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                            ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100'><?php echo @$aDataTextRef['tRptNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["aPagination"]["nTotalPage"] > 0):?>
                            <label class="xCNRptLabel"><?php echo @$aDataReport["aPagination"]["nDisplayPage"].' / '.@$aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    var oFilterLabel    = $('.report-filter .text-left label:first-child');
    var nMaxWidth       = 0;
    oFilterLabel.each(function(index){
        var nLabelWidth = $(this).outerWidth();
        if(nLabelWidth > nMaxWidth){
            nMaxWidth = nLabelWidth;
        }
    });
    $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
</script>
