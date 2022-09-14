<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage    = $this->params['nCurrentPage'];
$nAllPage        = $this->params['nAllPage'];
$aDataTextRef    = $this->params['aDataTextRef'];
$aDataFilter     = $this->params['aFilterReport'];
$aDataReport     = $this->params['aDataReturn'];
$aCompanyInfo    = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];
$aSumDataReport = $this->params['aSumDataReport'];

$bIsLastPage = ($nAllPage == $nCurrentPage);
?>

<style>
    /*แนวนอน*/
    @media print {
        @page {
            size: landscape
        }
    }

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
        border-bottom: 1px solid black !important;
    }

    .table>tbody:last-child>tr:last-child>td.xCNRptSumFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table tbody tr.xCNHeaderGroup,
    .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }

    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
</style>

<div id="odvRptTopUpHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-12 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter"></div>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') { ?>
                    <?php
                    $bShowFooter = false;
                    if (($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                        $bShowFooter = true;
                    }
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptCardDetail"),
                            "showFooter" => $bShowFooter,
                            "cssClass" => array(
                                "table" => "",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf" => "xCNRptSumFooter"
                            ),
                            "columns"       => array(
                                'FTCrdCode'         => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardCode'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                    "footerText"    => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '',
                                ),
                                'FTCrdName'         => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardName'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCrdStaType'      => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardFormat'],
                                    "formatValue"   => function ($tValue) {
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        if ($tValue == '1') {
                                            return $aDataTextRef['tRPCCardDetailStaType1'];
                                        } else if ($tValue == '2') {
                                            return $aDataTextRef['tRPCCardDetailStaType2'];
                                        } else {
                                            return '-';
                                        }
                                    },
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCtyName'         => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardType'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FDCrdStartDate'    => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardDateStart'],
                                    "cssStyle"      => "text-align:center",
                                    "formatValue"   => function ($tValue) {
                                        return date_format(date_create($tValue),'d/m/Y');
                                    }
                                ),
                                'FDCrdExpireDate'   => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardDateExpire'],
                                    "cssStyle"      => "text-align:center",
                                    "formatValue"   => function ($tValue) {
                                        return date_format(date_create($tValue),'d/m/Y');
                                    }
                                ),
                                'FTCrdStaActive'    => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardStatus'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                    "formatValue"   => function ($tValue) {
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        switch ($tValue) {
                                            case '1':
                                                return $aDataTextRef['tRPCCardDetailStaActive1'];
                                                break;
                                            case '2':
                                                return $aDataTextRef['tRPCCardDetailStaActive2'];
                                                break;
                                            case '3':
                                                return $aDataTextRef['tRPCCardDetailStaActive3'];
                                                break;
                                        }
                                    }
                                ),
                                'FNCrdStaExpr'      => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardStatusExpire'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                    "formatValue"   => function ($tValue) {
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        switch ($tValue) {
                                            case '1':
                                                return $aDataTextRef['tRPCCardDetailStaExpr1'];
                                                break;
                                            case '2':
                                                return $aDataTextRef['tRPCCardDetailStaExpr2'];
                                                break;
                                        }
                                    }
                                ),
                                'FCCrdValue'        => array(
                                    "label"         => $aDataTextRef['tRPC11TBCardBalance'],
                                    "type"          => "number",
                                    "cssStyle"      => "text-align:right",
                                    "decimals"      => $nOptDecimalShow,
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format(@$aSumDataReport[0]['FCCrdValue'], $nOptDecimalShow) : '',
                                ),
                            )
                        ));

                        ?>
                        <?php } else { ?>
                            <table class="table">
                                <thead>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardCode']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardName']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardFormat']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardType']; ?></th>
                                    <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardDateStart']; ?></th>
                                    <th nowrap class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardDateExpire']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardStatus']; ?></th>
                                    <th nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardStatusExpire']; ?></th>
                                    <th nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC11TBCardBalance']; ?></th>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('report/report/report', 'tCMNNotFoundData'); ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        <?php } ?>
            </div>

            <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                        || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect']))
                        || (isset($aDataFilter['tPosCodeSelect']))
                        ){ ?>
                <div class="xCNRptFilterTitle">
                    <div class="text-left">
                        <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                    </div>
                </div>
                <?php } ;?>


                <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
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


                <?php if ((isset($aDataFilter['tRptCardTypeCodeFrom']) && !empty($aDataFilter['tRptCardTypeCodeFrom'])) && (isset($aDataFilter['tRptCardTypeCodeTo']) && !empty($aDataFilter['tRptCardTypeCodeTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardTypeNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardTypeNameTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['tRptCardCode']) && !empty($aDataFilter['tRptCardCode'])) && (isset($aDataFilter['tRptCardCodeTo']) && !empty($aDataFilter['tRptCardCodeTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardName']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardNameTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['ocmRptStaCardFrom']) && !empty($aDataFilter['ocmRptStaCardFrom'])) && (isset($aDataFilter['ocmRptStaCardTo']) && !empty($aDataFilter['ocmRptStaCardTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล สถานะบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataFilter['tRptStaCardFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataFilter['tRptStaCardTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['tRptDateStartFrom']) && !empty($aDataFilter['tRptDateStartFrom'])) && (isset($aDataFilter['tRptDateStartTo']) && !empty($aDataFilter['tRptDateStartTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล จากวันที่เริ่มต้นใช้งาน ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateStarFrom']; ?> : </span> <?php echo $aDataFilter['tRptDateStartFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateStarTo']; ?> : </span> <?php echo $aDataFilter['tRptDateStartTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>

                <?php if ((isset($aDataFilter['tRptDateExpireFrom']) && !empty($aDataFilter['tRptDateExpireFrom'])) && (isset($aDataFilter['tRptDateExpireTo']) && !empty($aDataFilter['tRptDateExpireTo']))) { ?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล จากวันที่หมดอายุ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateExpireFrom']; ?> : </span> <?php echo $aDataFilter['tRptDateExpireFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateExpireTo']; ?> : </span> <?php echo $aDataFilter['tRptDateExpireTo']; ?></label>
                        </div>
                    </div>
                <?php } ?>


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
        var tFoot = $('tfoot').html();
        $('tfoot').remove();
        $('tbody').append(tFoot);
    });
</script>
