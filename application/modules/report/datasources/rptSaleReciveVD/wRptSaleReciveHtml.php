<?php
$aDataReport = $aDataViewRpt['aDataReport'];
$aDataTextRef = $aDataViewRpt['aDataTextRef'];
$aDataFilter = $aDataViewRpt['aDataFilter'];
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
    /*แนวนอน*/
    @media print{@page {size: landscape}}
    /*แนวตั้ง*/
    /* @media print{@page {size: portrait}} */
</style>

<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                </div>
            </div>

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>

                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <!-- Create By Witsarut 04/10/2019 -->
                    <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระเงิน ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptRcvFrom'] . ' ' . $aDataFilter['tRcvNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptRcvTo'] . ' ' . $aDataFilter['tRcvNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>


                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShopNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShopNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNTextBold" style="width:5%;  padding: 15px;"><?php echo language('report/report/report', 'tRptPayby'); ?>OK</th>
                            <th nowrap class="text-left xCNTextBold" style="width:15%; padding: 10px;"><?php echo language('report/report/report', 'tRptRcvDocumentCode'); ?></th>
                            <th nowrap class="text-left xCNTextBold" style="width:15%; padding: 10px;"><?php echo language('report/report/report', 'tRptDate'); ?></th>
                            <th nowrap class="text-right xCNTextBold" style="width:5%;  padding: 10px;"><?php echo language('report/report/report', 'tRptRcvTotal'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                            // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                            $nSubSumAjdWahB4Adj = 0;
                            $nSubSumAjdUnitQty = 0;

                            $nSumFooterAjdWahB4Adj = 0;
                            $nSumFooterAjdUnitQty = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                <?php
                                // echo '<pre>';
                                // print_r($aValue);
                                // Step 1 เตรียม Parameter สำหรับการ Groupping
                                $tRcvName = $aValue["FTRcvName"];

                                $nGroupMember = $aValue["FNRptGroupMember"];
                                $nRowPartID = $aValue["FNRowPartID"];
                                ?>
                                <?php
                                //Step 2 Groupping data
                                $aGrouppingData = array($tRcvName);
                                // Parameter
                                // $nRowPartID      = ลำดับตามกลุ่ม
                                // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td></td>
                                    <td nowrap class="text-left" style="padding:7px;"><?php echo $aValue["FTXshDocNo"]; ?></td>
                                    <td nowrap class="text-left"><?php echo $aValue["FDXrcRefDate"]; ?></td>
                                    <td nowrap class="number text-right" style="padding:7px;"><?php echo number_format($aValue["FCXrcNet"], 2) ?></td>
                                </tr>
                                <?php
                                //Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                $nSubSumAjdWahB4Adj = $aValue["FCSdtSubQty"];
                                $nSubSumAjdUnitQty = $aValue["FCXrcNetFooter"];

                                $aSumFooter = array($aDataTextRef['tRptTotalSub'] . $aValue["FTRcvName"], 'N', 'N', $nSubSumAjdWahB4Adj);

                                //Step 4 : สั่ง Summary SubFooter
                                //Parameter
                                //$nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                //$nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                //$aSumFooter       =  ข้อมูล Summary SubFooter
                                FCNtHRPTSumSubFooter($nGroupMember, $nRowPartID, $aSumFooter);


                                //Step 5 เตรียม Parameter สำหรับ SumFooter
                                $nSumFooterAjdWahB4Adj = number_format($aValue["FCSdtSubQty"], 2);
                                $nSumFooterAjdUnitQty = number_format($aValue["FCXrcNetFooter"], 2);
                                $paFooterSumData = array($aDataTextRef['tRptTotalFooter'], 'N', 'N', $nSumFooterAjdUnitQty);
                                ?>
                            <?php } ?>
                            <?php
                            //Step 6 : สั่ง Summary Footer
                            $nPageNo = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                            FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
                        <?php }else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptNoData']; ?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
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
    $(document).ready(function () {
        var oFilterLabel = $('.report-filter .text-left label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function (index) {
            var nLabelWidth = $(this).outerWidth();
            if (nLabelWidth > nMaxWidth) {
                nMaxWidth = nLabelWidth;
            }
        });
        $('.report-filter .text-left label:first-child').width(nMaxWidth + 55);
    });
</script>
