<?php

    use \koolreport\widgets\koolphp\Table;

    $nCurrentPage    = $this->params['nCurrentPage'];
    $nAllPage        = $this->params['nAllPage'];
    $aDataTextRef    = $this->params['aDataTextRef'];
    $aDataFilter     = $this->params['aFilterReport'];
    $aDataReport     = $this->params['aDataReturn'];
    $aCompanyInfo    = $this->params['aCompanyInfo'];
    $nOptDecimalShow = $this->params['nOptDecimalShow'];
    $aSumDataReport  = $this->params['aSumDataReport'];

    $bIsLastPage = ($nAllPage == $nCurrentPage);
?>

<style>
    /*แนวนอน*/
    @media print{@page {size: landscape}} 
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>

<div id="odvRptTopUpHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?>
                                    <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptFaxNo'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptBranch'] .' '. $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxNo'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tRptBchCodeFrom']) && !empty($aDataFilter['tRptBchCodeFrom'])) && (isset($aDataFilter['tRptBchCodeTo']) && !empty($aDataFilter['tRptBchCodeTo']))) { ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo $aDataFilter['tRptBchNameFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']; ?> : </span> <?php echo $aDataFilter['tRptBchNameTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }; ?>

                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo $aDataFilter['tDocDateFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo $aDataFilter['tDocDateTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
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
                            "dataSource"        => $this->dataStore("RptTopUp"),
                            "showFooter"        => $bShowFooter,
                            "cssClass"          => array(
                                "table" => "table table-bordered",
                                "th"    => "xCNReportTBHeard",
                                "td"    => "xCNReportTBData"
                            ),
                            "columns"           => array(
                                'FTCrdCode'     => array(
                                    "label"     => $aDataTextRef['tRPC14TBCardCode'],
                                    "cssStyle"      => "text-align:left",
                                ),
                                'FTCtyName'     => array(
                                    "label"     => $aDataTextRef['tRPC14TBCardTypeName'],  
                                    "cssStyle"      => "text-align:left",         
                                    "formatValue"   => function($tValue,$aRow){
                                        $aExplodeCtyName = explode(";",$tValue);
                                        return $aExplodeCtyName[1];
                                    },      
                                ),
                                'FTCrdHolderID' => array(
                                    "label"     => $aDataTextRef['tRPC14TBCardHolderID'],
                                    "formatValue"   => function($tValue,$aRow){
                                        $aExplodeCrdHolderID = explode(";",$tValue);
                                        return $aExplodeCrdHolderID[1];
                                    },
                                    "cssStyle"      => "text-align:left",
                                ),
                                'FTCrdName'     => array(
                                    "label"     => $aDataTextRef['tRPC14TBCardName'],
                                    "cssStyle"      => "text-align:left", 
                                ),
                                'FTDptName'     => array(
                                    "label"     => $aDataTextRef['tRPC14TBDptName'],
                                    "formatValue"   => function($tValue,$aRow){
                                        $aExplodeDptName = explode(";",$tValue);
                                        return $aExplodeDptName[1];
                                    },
                                    "cssStyle"      => "text-align:left",
                                ),
                                'FTTxnDocNoRef' => array(
                                    "label"     => $aDataTextRef['tRPC14TBCardTxnDocNoRef'],
                                    "cssStyle"      => "text-align:left",
                                ),
                                'FTUsrName'     => array(
                                    "label"     => $aDataTextRef['tRPC14TBCardUsrName'],
                                    "cssStyle"      => "text-align:left",
                                ),
                                'FDTxnDocDate'      => array(
                                    "label"         => $aDataTextRef['tRPC14TBCardTxnDocDate'],
                                    "cssStyle"      => "text-align:center",
                                    'formatValue'   => function($tDateTime){
                                        return date('Y-m-d H:i:s ',strtotime($tDateTime));
                                    },
                                ),
                                'FTCrdStaActive'    => array(
                                    "label"         => $aDataTextRef['tRPC14TBCardStaActive'],
                                    "cssStyle"      => "text-align:left",
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? $aDataTextRef['tRPCTBFooterSumAll'] : '',
                                    "formatValue"   => function($tValue){
                                        $aDataTextRef   = $this->params['aDataTextRef'];
                                        switch($tValue){
                                            case '1':
                                                return $aDataTextRef['tRPC14CardDetailStaActive1'];
                                            break;
                                            case '2':
                                                return $aDataTextRef['tRPC14CardDetailStaActive2'];
                                            break;
                                            case '3':
                                                return $aDataTextRef['tRPC14CardDetailStaActive3'];
                                            break;
                                            default:
                                                return $aDataTextRef['tRPC14CardDetailStaActive'];
                                        }
                                    }
                                ),
                                'FCTxnCrdValue' => array(
                                    "label"         => $aDataTextRef['tRPC14TBCardTxnCrdValue'],
                                    "type"          => "number",
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format(@$aSumDataReport[0]['FCTxnCrdValue'], $nOptDecimalShow) : '',
                                    "decimals"      => 2,
                                    "cssStyle"      => "text-align:right",
                                ),
                                'FCTxnValue'    => array(
                                    "label"         => $aDataTextRef['tRPC14TBCardTxnValue'],
                                    "type"          => "number",
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format(@$aSumDataReport[0]['FCTxnValue'], $nOptDecimalShow) : '',
                                    "decimals"      => 2,
                                    "cssStyle"      => "text-align:right",
                                ),
                                'FCTxnValAftTrans'  => array(
                                    "label"         => $aDataTextRef['tRPC14TBCardTxnValAftTrans'],
                                    "type"          => "number",
                                    "footer"        => '',
                                    "footerText"    => $bShowFooter ? number_format(@$aSumDataReport[0]['FCTxnValAftTrans'], $nOptDecimalShow) : '',
                                    "decimals"      => 2,
                                    "cssStyle"      => "text-align:right",
                                ),
                            ),
                            "removeDuplicate"   =>  array("FTCrdCode","FTCtyName","FTCrdHolderID","FTCrdName","FTDptName")
                        ));

                    ?>
                <?php } else {?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardCode']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardTypeName']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardHolderID']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardName']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBDptName']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardTxnDocNoRef']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardUsrName']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardTxnDocDate']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardStaActive']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardTxnCrdValue']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardTxnValue']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC14TBCardTxnValAftTrans']; ?></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('report/report/report', 'tCMNNotFoundData'); ?></td>
                            </tr>
                        </tbody>
                    </table>
                <?php }?>
            </div>
        <?php if ($bIsLastPage) { // Display Last Page ?>        
            <div class="xCNRptFilterTitle">
                <label><u><?php echo $aDataTextRef['tRptConditionInReport']; ?></u></label>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล หมายเลขบัตร ============================ -->
            <?php if ((isset($aDataFilter['tRptCardCode']) && !empty($aDataFilter['tRptCardCode'])) && (isset($aDataFilter['tRptCardCodeTo']) && !empty($aDataFilter['tRptCardCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeFrom']; ?> : </span> <?php echo $aDataFilter['tRptCardName']; ?></label>
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCardCodeTo']; ?> : </span> <?php echo $aDataFilter['tRptCardNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล รหัสพนักงาน ============================ -->
            <?php if ((isset($aDataFilter['tRptEmpCode']) && !empty($aDataFilter['tRptEmpCode'])) && (isset($aDataFilter['tRptEmpCodeTo']) && !empty($aDataFilter['tRptEmpCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCEmpCodeFrom']; ?> : </span> <?php echo $aDataFilter['tRptEmpName']; ?></label>
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCEmpCodeTo']; ?> : </span> <?php echo $aDataFilter['tRptEmpNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สถานะบัตร ============================ -->
            <?php if ((isset($aDataFilter['ocmRptStaCardFrom']) && !empty($aDataFilter['ocmRptStaCardFrom'])) && (isset($aDataFilter['ocmRptStaCardTo']) && !empty($aDataFilter['ocmRptStaCardTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataFilter['tRptStaCardFrom']; ?></label>
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataFilter['tRptStaCardTo']; ?></label>
                    </div>
                </div>
            <?php else: ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdFrom']; ?> : </span> <?php echo $aDataTextRef['tRptAll']; ?></label>
                        <label class='xCNRptDisplayBlock'><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRPCStaCrdTo']; ?> : </span> <?php echo $aDataTextRef['tRptAll']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
        <?php  } ?>
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