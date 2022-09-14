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
        border-bottom: 0px transparent !important;
    }

    .table>thead:first-child>tr:last-child>td,
    .table>thead:first-child>tr:last-child>th {
        border-bottom: 1px solid black !important;
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
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) {?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateFrom']; ?> : </span> <?php echo $aDataFilter['tDocDateFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCDateTo']; ?> : </span> <?php echo $aDataFilter['tDocDateTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }?>
                    </div>
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
                            "dataSource"    => $this->dataStore("RptTransferCardInfo"),
                            "cssClass"      => array(
                                "table"     => "table ",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf"=>"xCNRptSumFooter",
                            ),
                            "columns"       => array(
                                'rtRowID'       => array(
                                    "label"     => $aDataTextRef['tRPC3TBRowNuber'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FDDocDate'     => array(
                                    "label"     => $aDataTextRef['tRPC3TBDocDate'],
                                    "cssStyle" => array(
                                        "th" => "text-align:center",
                                        "td" => "text-align:center"
                                    ),
                                    "formatValue"=>function($value, $row){
                                        return empty($value) ? '' : date("Y-m-d H:i:s", strtotime($value));
                                    },
                                ),
                                'FTCvdOldCode'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBOldCardCode'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTOldCtyName'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBOldCardType'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTCvdNewCode'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBNewCardCode'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTNewCtyName'  => array(
                                    "label"     => $aDataTextRef['tRPC3TBNewCardType'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTCrdName'     => array(
                                    "label"     => $aDataTextRef['tRPC3TBCardName'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FTUsrName'  => array(
                                    "label"         => $aDataTextRef['tRPCOperator'],
                                    "cssStyle" => "text-align:left"
                                ),
                                'FCOldCrdValue' => array(
                                    "label"     => $aDataTextRef['tRPC3TBOldCrdValue'],
                                    "type"      => "number",
                                    "decimals"  => $nOptDecimalShow,
                                    "cssStyle" => array(
                                        "th" => "text-align:right",
                                        "td" => "text-align:right"
                                    ),
                                ),
                                'FCNewCrdValue' => array(
                                    "label"     => $aDataTextRef['tRPC3TBNewCrdValue'],
                                    "type"      => "number",
                                    "decimals"  => $nOptDecimalShow,
                                    "cssStyle" => array(
                                        "th" => "text-align:right",
                                        "td" => "text-align:right"
                                    ),
                                ),
                            )
                        ));
                    ?>
                <?php } else {?>
                    <table class="table">
                    <thead>
						<tr>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBRowNuber']; ?></th>
                            <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBDocDate']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBOldCardCode']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBOldCardType']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBNewCardCode']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBNewCardType']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBCardName']; ?></th>
                            <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCOperator']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBOldCrdValue']; ?></th>
                            <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPC3TBNewCrdValue']; ?></th>
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


                <?php if ((isset($aDataFilter['tCardTypeCodeOldFrom']) && !empty($aDataFilter['tCardTypeCodeOldFrom'])) && (isset($aDataFilter['tCardTypeCodeOldTo']) && !empty($aDataFilter['tCardTypeCodeOldTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตรเดิม ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeOldFrom']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameOldFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeOldTo']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameOldTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardTypeCodeNewFrom']) && !empty($aDataFilter['tCardTypeCodeNewFrom'])) && (isset($aDataFilter['tCardTypeCodeNewTo']) && !empty($aDataFilter['tCardTypeCodeNewTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทบัตรใหม่ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeNewFrom']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameNewFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTypeNewTo']; ?> : </span> <?php echo $aDataFilter['tCardTypeNameNewTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardCodeOldFrom']) && !empty($aDataFilter['tCardCodeOldFrom'])) && (isset($aDataFilter['tCardCodeOldTo']) && !empty($aDataFilter['tCardCodeOldTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เลขขัตรเดิม ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdOldFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameOldFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdOldTo']; ?> : </span> <?php echo $aDataFilter['tCardNameOldTo']; ?></label>
                        </div>
                    </div>
                <?php }?>

                <?php if ((isset($aDataFilter['tCardCodeNewFrom']) && !empty($aDataFilter['tCardCodeNewFrom'])) && (isset($aDataFilter['tCardCodeNewTo']) && !empty($aDataFilter['tCardCodeNewTo']))) {?>
                    <!-- ============================ ฟิวเตอร์ข้อมูล เลขขัตรใหม่ ============================ -->
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdNewFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameNewFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdNewTo']; ?> : </span> <?php echo $aDataFilter['tCardNameNewTo']; ?></label>
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
