<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
?>

<style>
    .xCNFooterRpt {
        border-bottom: 7px double #ddd;
    }

    .table>thead:first-child>tr:nth-child(2)>td,
    .table>thead:first-child>tr:nth-child(2)>th,
    .table>thead:first-child>tr:first-child>td,
    .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>thead:first-child>tr:first-child>th, .table>thead:first-child>tr:nth-child(2)>th {
        border-left: 0px transparent !important;
        border-right: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>th:first-child, .table>thead:first-child>tr:nth-child(2)>th:first-child {
        border-left: 1px solid black !important;
    }

    .table>thead:first-child>tr:first-child>th:last-child, .table>thead:first-child>tr:nth-child(2)>th:last-child {
        border-right: 1px solid black !important;
    }
    
    /*
    .table>thead:first-child>tr:first-child>th, .table>thead:first-child>tr:nth-child(2)>th {
        border-left: 0px transparent !important;
        border-right: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>th:first-child, .table>thead:first-child>tr:nth-child(2)>th:first-child {
        border-left: 1px solid black !important;
    }

    .table>thead:first-child>tr:first-child>th:last-child, .table>thead:first-child>tr:nth-child(2)>th:last-child {
        border-right: 1px solid black !important;
    }

    .table>thead:first-child>tr:first-child>th:nth-child(4), .table>thead:first-child>tr:nth-child(2)>th:nth-child(4) {
        border-left: 1px solid black !important;
    }
    */

    /* .table tbody tr,
    .table>tbody>tr>td {
        border-left: 1px #ddd !important;
        border-right: 1px #ddd !important;
    } */

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom: 6px double black !important;
    }

    .table tbody tr.end-row {
        border-bottom: 1px solid black !important;
    }

    .table tbody tr.hide {
        display: none;
    }
    
    .table>tfoot>tr {
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom: 6px double black !important;
    }

    /*แนวนอน*/
    @media print{@page {size: landscape}} 
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>

<div id="odvRptSaleShopByDateHtml">
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
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <!--  Create By Witsarut (Bell) แก้ไขเรื่องที่อยู่ และ Fillter -->
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aCompanyInfo['FTCmpName'];?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') {; // ที่อยู่แบบแยก ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'];?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'];?></label>
                            </div>
                        <?php }?>


                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') {; // ที่อยู่แบบรวม ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV2Desc1'];?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?=$aCompanyInfo['FTAddV2Desc2'];?></label>
                            </div>
                        <?php }?>

                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'];?> <?=$aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'];?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?=$aDataTextRef['tRptBranch'] . $aCompanyInfo['FTBchName'];?></label>
                        </div>

                    <?php }?>
                </div>
                <div class="col-xs-8 col-sm-8 col-md-8 col-lg-8 report-filter">
                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) {?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchFrom'] . ' ' . $aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptBchTo'] . ' ' . $aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <?php if ((isset($aDataFilter['tShopCodeFrom']) && !empty($aDataFilter['tShopCodeFrom'])) && (isset($aDataFilter['tShopCodeTo']) && !empty($aDataFilter['tShopCodeTo']))) {?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopFrom'] . ' ' . $aDataFilter['tShopNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptShopTo'] . ' ' . $aDataFilter['tShopNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) {?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosFrom'] . ' ' . $aDataFilter['tPosNameFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPosTo'] . ' ' . $aDataFilter['tPosNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) {?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้าง report ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . $aDataFilter['tDocDateFrom']; ?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . $aDataFilter['tDocDateTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }?>
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
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') {?>
                    <?php
                    Table::create(array(
                        "dataSource" => $this->dataStore("RptDropByDate"),
                        "cssClass" => array(
                            "table" => "table",
                        ),
                        "headers" => array(
                            array(
                                $aDataTextRef['tRptLockerDropByDateDropDate'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 1,
                                    // "rowSpan" => 2
                                ),
                                $aDataTextRef['tRptCreateOnBch'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 1,
                                    // "rowSpan" => 2
                                ),
                                $aDataTextRef['tRptXshDocNo'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 1,
                                    // "rowSpan" => 2
                                ),
                                $aDataTextRef['tRptTrackingNo'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 1,
                                ),
                                $aDataTextRef['tRptCoditionFrom'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 1,
                                ),
                                $aDataTextRef['tRptCoditionTo'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 2,
                                ),
                                $aDataTextRef['tRptStatus'] => array(
                                    "style" => "text-align:left",
                                    "colSpan" => 1,
                                ),
                            ),
                        ),
                        "columns" => array(
                            'FDXshDocDate' => array(
                                "label" => "",
                                "cssStyle" => array(
                                    // "th" => "display:none",
                                ),
                                "formatValue" => function ($value, $row) {
                                    return date("Y-m-d", strtotime($value));
                                },
                            ),
                            'FTBchName' => array(
                                "label" => "",
                                "cssStyle" => array(
                                    // "th" => "display:none",
                                ),
                                "formatValue" => function ($value, $row) {
                                    return $value;
                                },
                            ),
                            'FTXshDocNo' => array(
                                "label" => "",
                                "cssStyle" => array(
                                    // "th" => "display:none",
                                ),
                            ),
                            'FTXshRefExt' => array(
                                "label" => $aDataTextRef['tRptCabinetCode'],
                                "cssStyle" => array(
                                    // "th" => "display:none",
                                ),
                                "formatValue" => function ($value, $row) {
                                    return $value . "<br>" . $row['FTPosCode'];
                                },
                            ),
                            'FTXshFrmLogin' => array(
                                "label" => $aDataTextRef['tRptSize'],
                                "cssStyle" => array(
                                    // "th" => "display:none"
                                ),
                                "formatValue" => function ($value, $row) {
                                    return $value . "<br>" . $row['FTPzeName'];
                                },
                            ),
                            'FTXshToLogin' => array(
                                "label" => $aDataTextRef['tRptRentalRate'],
                                "cssStyle" => array(
                                    // "th" => "display:none"
                                ),
                                "formatValue" => function ($value, $row) {
                                    return $value . "<br>" . $row['FTRthCode'];
                                },
                            ),
                            'FTXsdTimeStart' => array(
                                "label" => $aDataTextRef['tRptLockerDropByDateDropTime'],
                                "cssStyle" => array(
                                    // "th" => "display:none"
                                ),
                                "formatValue" => function ($value, $row) {
                                    return "<br>" . $value;
                                },
                            ),
                            'FTStatus' => array(
                                "label" => $aDataTextRef['tRptPrice'],
                                "cssStyle" => array(
                                    // "th" => "display:none"
                                ),
                                "formatValue" => function ($value, $row) use($nOptDecimalShow){
                                    return $value . "<br>" . number_format($row['FCXsdNetAfHD'], $nOptDecimalShow);
                                },
                            ),
                        ),
                        "removeDuplicate" => array("FDXshDocDate"),
                    ));
                    ?>
                <?php } else {?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptLockerDropByDateDropDate']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptCreateOnBch']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptXshDocNo']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptTrackingNo']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptCoditionFrom']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptCoditionTo']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRptStatus']; ?></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>
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
    $(document).ready(function() {
        var oFilterLabel = $('.report-filter .text-left label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function(index) {
            var nLabelWidth = $(this).outerWidth();
            if (nLabelWidth > nMaxWidth) {
                nMaxWidth = nLabelWidth;
            }
        });
        $('.report-filter .text-left label:first-child').width(nMaxWidth + 50);
    });
</script>