<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage = $this->params['nCurrentPage'];
$nAllPage = $this->params['nAllPage'];
$aDataTextRef = $this->params['aDataTextRef'];
$aDataFilter = $this->params['aFilterReport'];
$aDataReport = $this->params['aDataReturn'];
$aCompanyInfo = $this->params['aCompanyInfo'];
$nOptDecimalShow = $this->params['nOptDecimalShow'];

$bIsLastPage = ($nAllPage == $nCurrentPage);
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
        font-size: 18px !important;
        font-weight: 600;
    }

    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }

    @media print{@page {size: landscape}} 
</style>

<div id="odvRptSaleShopByDateHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
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
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') {?>
                    <?php
                        $bShowFooter = false;
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                            $bShowFooter = true;
                        }
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptCardNoActivesCard"),
                            "cssClass" => array(
                                "table" => "",
                                "th"    => "xCNRptColumnHeader",
                                "td"    => "xCNRptDetail",
                                "tf"    => "xCNRptSumFooter"
                            ),
                            "columns" => array(
                                // 'rtRowID' => array(
                                //     "label" => $aDataTextRef['tRPC6TBRowNuber'],
                                //     "cssStyle" => "text-align:left"
                                // ),
                                'FTCrdCode' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardCode'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCtyName' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardType'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FTCrdName' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardName'],
                                    "cssStyle"      => array("th" => "text-align:left", "td" => "text-align:left"),
                                ),
                                'FDCrdStartDate' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardStartDate'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center",
                                        "td"    => "text-align:center"
                                    ),
                                    "formatValue"=>function($value, $row){
                                        return empty($value) ? '' : date("d/m/Y", strtotime($value));
                                    },
                                ),
                                'FDCrdExpireDate' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardExpireDate'],
                                    "cssStyle"  => array(
                                        "th"    => "text-align:center",
                                        "td"    => "text-align:center"
                                    ),
                                    "formatValue"=>function($value, $row){
                                        return empty($value) ? '' : date("d/m/Y", strtotime($value));
                                    },
                                ),
                                'FCCrdValue' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardValue'],
                                    "type" => "number",
                                    "decimals" => $nOptDecimalShow,
                                    "cssStyle"  => array(
                                        "th"    => "text-align:right",
                                        "td"    => "text-align:right"
                                    ),
                                ),
                                'FTCrdStaActive' => array(
                                    "label" => $aDataTextRef['tRPC6TBCardStatus'],
                                    "cssStyle" => "text-align:left",
                                    "formatValue" => function($tValue,$aRow){
                                        $aDataParams = $this->params['aDataTextRef'];
                                        if($tValue == '1'){
                                            return $aDataParams['tRPCStaActive1'];
                                        }else if($tValue == '2'){
                                            return $aDataParams['tRPCStaActive2'];
                                        }else{
                                            return $aDataParams['tRPCStaActive3'];
                                        }
                                    }
                                )
                            ),
                        ));
                    ?>
                <?php } else { ?>
                    <table class="table">
                        <thead>
                            <tr>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBRowNuber']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardCode']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardType']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardName']; ?></th>
                                <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardStartDate']; ?></th>
                                <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardExpireDate']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardValue']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC6TBCardStatus']; ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNRptDetail' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>

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

                <?php if ((isset($aDataFilter['tCardTypeCodeFrom']) && !empty($aDataFilter['tCardTypeCodeFrom'])) && (isset($aDataFilter['tCardTypeCodeTo']) && !empty($aDataFilter['tCardTypeCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeFrom']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeTo']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardCodeFrom']) && !empty($aDataFilter['tCardCodeFrom'])) && (isset($aDataFilter['tCardCodeTo']) && !empty($aDataFilter['tCardCodeTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTo']; ?> : </span> <?php echo $aDataFilter['tCardNameTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tDateStartFrom']) && !empty($aDataFilter['tDateStartFrom'])) && (isset($aDataFilter['tDateStartTo']) && !empty($aDataFilter['tDateStartTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล วันที่เริ่มใช้งานบัตร ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateStartFrom']; ?> : </span> <?php echo $aDataFilter['tDateStartFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateStartTo']; ?> : </span> <?php echo $aDataFilter['tDateStartTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tDateExpireFrom']) && !empty($aDataFilter['tDateExpireFrom'])) && (isset($aDataFilter['tDateExpireTo']) && !empty($aDataFilter['tDateExpireTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล วันที่บัตรหมดอายุ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateExpireFrom']; ?> : </span> <?php echo $aDataFilter['tDateExpireFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateExpireTo']; ?> : </span> <?php echo $aDataFilter['tDateExpireTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

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
