<?php

use \koolreport\widgets\koolphp\Table;

$nCurrentPage       = $this->params['nCurrentPage'];
$nAllPage           = $this->params['nAllPage'];
$aDataTextRef       = $this->params['aDataTextRef'];
$aDataFilter        = $this->params['aFilterReport'];
$aDataReport        = $this->params['aDataReturn'];
$aCompanyInfo       = $this->params['aCompanyInfo'];
$nOptDecimalShow    = $this->params['nOptDecimalShow'];
$aSumDataReport     = $this->params['aDataReturn']['aDataSumFooterReport'];

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
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้าง report ============================ -->
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
            <div id="odvRptTableAdvance" class="table-responsive">
                <?php if (isset($aDataReport['rtCode']) && !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1') {?>
                    <?php
                        $bShowFooter = false;
                        if(($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage'])) {
                            $bShowFooter = true;
                        }
                    ?>
                    <?php
                        Table::create(array(
                            "dataSource" => $this->dataStore("RptUseCard1"),
                            "cssClass" => array(
                                "table" => "table",
                                "th" => "xCNRptColumnHeader",
                                "td" => "xCNRptDetail",
                                "tf"=>"xCNRptSumFooter",
                            ),
                            "showFooter" => $bShowFooter,
                            "columns" => array(
                                'rtCrdCode' => array(
                                    "label" => $aDataTextRef['tRPCCardCode'],
                                    "cssStyle" =>array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left;",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                    "footerText" => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '',
                                ),
                                'rtCrdName' => array(
                                    "label" => $aDataTextRef['tRPCCardName'],
                                    "formatValue" => function($tValue,$aData){
                                        $aExplodeCrdName = explode(";",$tValue);
                                        return $aExplodeCrdName[1];
                                    },
                                    "cssStyle" => array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                ),
                                'rtTxnPosType' => array(
                                    "label" => $aDataTextRef['tRPCCardPosType'],
                                    "formatValue" => function($tValue,$aRow){
                                        $aExplodeShpCode = explode(';',$tValue);
                                        $aDataText = $this->params['aDataTextRef'];
                                        return $aExplodeShpCode[1];
                                    },
                                    "cssStyle" => array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                ),
                                'rtTxnDocNo' => array(
                                    "label" => $aDataTextRef['tRPCCardTxnDocNo'],
                                    "formatValue" => function($tValue,$aData){
                                        $aExplodeTxnDocNo = explode(";",$tValue);
                                        return $aExplodeTxnDocNo[1];
                                    },
                                    "cssStyle" =>array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                ),
                                'rtTxnDocNoRef' => array(
                                    "label" => $aDataTextRef['tRPCCardTxnDocNoRef'],
                                    "formatValue" => function($tValue,$aData){
                                        $aExplodeTxnDocNoRef = explode(";",$tValue);
                                        return $aExplodeTxnDocNoRef[1];
                                    },
                                    "cssStyle" => array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                ),
                                'rtTxnDocTypeName' => array(
                                    "label" => $aDataTextRef['tRPCCardTxnDocTypeName'],
                                    "formatValue" => function($tValue,$aRow){
                                        $aExplodeTxtDocTypeName = explode(";",$tValue);
                                        if($aRow['FNLngID'] == 1){
                                            return $aExplodeTxtDocTypeName[1];
                                        }else{
                                            return $aExplodeTxtDocTypeName[2];
                                        }
                                    },
                                    "cssStyle" =>array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                ),
                                'rtTxnDocCreateBy' => array(
                                    "label" => $aDataTextRef['tRPCOperator'],
                                    "formatValue" => function($tValue,$aRow){
                                        $aExplodeTxtDocOperatorName = explode(";",$tValue);
                                        if($aRow['FNLngID'] == 1){
                                            return $aExplodeTxtDocOperatorName[1];
                                        }else{
                                            return $aExplodeTxtDocOperatorName[2];
                                        }
                                    },
                                    "cssStyle" =>array(
                                        "th" => "text-align:left",
                                        "td" => "text-align:left",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                ),
                                'rtTxnDocDate' => array(
                                    "label" => $aDataTextRef['tRPCCardTxnDocDate'],
                                    // "footerText" => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '',
                                    "cssStyle" => array(
                                        "th" => "text-align:center",
                                        "td" => "text-align:center",
                                        "tf" => "text-align:right;border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    ),
                                    "formatValue" => function($tValue,$aRow){
                                        return empty($tValue) ? '' : date("Y-m-d H:i:s", strtotime($tValue));
                                    },
                                ),
                                'rtTxnValue' => array(
                                    "label" => $aDataTextRef['tRPCCardTxnValue'],
                                    /*"formatValue"   => function($tValue,$aRow){
                                        $aExplodeTxnValue = explode(";",$tValue);
                                        return number_format(intval($aExplodeTxnValue[1]),2);
                                    },*/
                                    "type" => "number",
                                    "decimals" => $nOptDecimalShow,
                                    "footer" => '',
                                    "footerText" => $bShowFooter ? number_format(@$aSumDataReport[0]['FCTxnValueSum'], $nOptDecimalShow) : '',
                                    "cssStyle" =>array(
                                        "th" => "text-align:right",
                                        "td" => "text-align:right",
                                        "tf" => "text-align:right;border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    )
                                ),
                                'rtCrdBalance' => array(
                                    "label" => $aDataTextRef['tRPCCardBalance'],
                                    "formatValue" => function($tValue,$aRow){
                                        $aExplodeCrdBalance = explode(";",$tValue);
                                        return number_format(intval($aExplodeCrdBalance[1]), 2);
                                    },
                                    "cssStyle" =>array(
                                        "th" => "text-align:right",
                                        "td" => "text-align:right",
                                        'tf' => "border-top: 1px solid black !important;border-bottom: 1px solid black !important;"
                                    )
                                ),
                            ),
                            "removeDuplicate" => array("rtCrdCode", "rtCrdName", "rtCrdBalance")
                        ));
                    ?>
                <?php } else {?>
                    <table class="table">
                        <thead>
						    <tr>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardCode']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardName']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardPosType']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardTxnDocNo']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardTxnDocNoRef']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardTxnDocTypeName']; ?></th>
                                <th class="xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCOperator']; ?></th>
                                <th class="text-center xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardTxnDocDate']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardTxnValue']; ?></th>
                                <th class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRPCCardBalance']; ?></th>
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


                <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
                <?php if ((isset($aDataFilter['tCardCodeFrom']) && !empty($aDataFilter['tCardCodeFrom'])) && (isset($aDataFilter['tCardCodeTo']) && !empty($aDataFilter['tCardCodeTo']))) {?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdFrom']; ?> : </span> <?php echo $aDataFilter['tCardNameFrom']; ?></label>
                            <br>
                            <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCCrdTo']; ?> : </span> <?php echo $aDataFilter['tCardNameTo']; ?></label>
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
