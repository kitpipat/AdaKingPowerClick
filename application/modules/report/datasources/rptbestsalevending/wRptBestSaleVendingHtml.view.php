<?php
    use \koolreport\widgets\koolphp\Table;
    $aDataReport    = $this->params['aDataReport'];
    $aDataSumFoot   = $this->params['aDataSumFoot'];
    $aDataTextRef   = $this->params['aDataTextRef'];
    $aDataFilter    = $this->params['aDataFilter'];
    $aCompanyInfo   = $this->params['aCompanyInfo'];
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

    .table>tfoot>tr{
         border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom : 6px double black !important;
    }

    .xCNRptTitle {
        font-weight: 500 !important;

    }
</style>
<div id="odvRptBestSaleVendingHtml">
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
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <?php if(isset($aCompanyInfo) && !empty($aCompanyInfo)):?>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTCmpName'];?></label>
                        </div>
                        <?php if($aCompanyInfo['FTAddVersion'] == '1'): // ที่อยู่แบบแยก ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV1No'] . ' ' . @$aCompanyInfo['FTAddV1Village'] . ' ' . @$aCompanyInfo['FTAddV1Road'] . ' ' . @$aCompanyInfo['FTAddV1Soi'];?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTSudName'] . ' ' . @$aCompanyInfo['FTDstName'] . ' ' . @$aCompanyInfo['FTPvnName'] . ' ' . @$aCompanyInfo['FTAddV1PostCode'];?></label>
                            </div>
                        <?php endif;?>
                        <?php if($aCompanyInfo['FTAddVersion'] == '2'): // ที่อยู่แบบรวม ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV2Desc1'];?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV2Desc2'];?></label>
                            </div>
                        <?php endif;?>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel']?> <?php echo $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'];?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'];?></label>
                        </div>
                    <?php endif;?>
                </div>
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

                    <?php if( (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptMerFrom'].' '.$aDataFilter['tMerNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptMerTo'].' '.$aDataFilter['tMerNameTo'];?></label>
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
                        <!-- ============================ ฟิวเตอร์ข้อมูล เครื่องจุดขาย ============================ -->
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

                    <?php if( (isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtCodeFrom'].' '.$aDataFilter['tPdtNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtCodeTo'].' '.$aDataFilter['tPdtNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
                    
                    <?php if( (isset($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeFrom'])) && (isset($aDataFilter['tPdtGrpCodeTo']) && !empty($aDataFilter['tPdtGrpCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtGrpFrom'].' '.$aDataFilter['tPdtGrpNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtGrpTo'].' '.$aDataFilter['tPdtGrpNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeFrom'])) && (isset($aDataFilter['tPdtTypeCodeTo']) && !empty($aDataFilter['tPdtTypeCodeTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtTypeFrom'].' '.$aDataFilter['tPdtTypeNameFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptPdtTypeTo'].' '.$aDataFilter['tPdtTypeNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>
                                </div>
                            </div>
                            <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tPriority']) && !empty($aDataFilter['tPriority']))):?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tPriority'].' '.$aDataFilter['tPriority'];?></label>
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
            <div id="odvTblRptBestSaleVending" class="table-responsive">
                <?php if(isset($aDataReport['rtCode']) &&  !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1'):?>
                    <?php
                        if($aDataReport['rnCurrentPage'] == $aDataReport['rnAllPage']){
                            Table::create(array(
                                "dataSource"    => $this->dataStore("RptBestSaleVending"),
                                "cssClass"      => array(
                                    "table"     => "table",
                                    "tf"        => "xCNRptLabel"
                                ),
                                "showFooter"    => true,
                                "headers"       => array(
                                    array(
                                        "$aDataTextRef[tRptPdtCode]"  => array(
                                            "style"     => "text-align:left",
                                            "rowSpan"   => 1
                                        ),
                                        "$aDataTextRef[tRptPdtName]"  => array(
                                            "style"     => "text-align:left",
                                            "rowSpan"   => 1
                                        ),  
                                        "$aDataTextRef[tRptPdtGrp]"  => array(
                                            "style"     => "text-align:left",
                                            "rowSpan"   => 1
                                        ),   
                                        "$aDataTextRef[tRptNumQty]"  => array(
                                            "style"     => "text-align:right",
                                            "rowSpan"   => 1
                                        ),  
                                        "$aDataTextRef[tRptSaleNet]"  => array(
                                            "style"     => "text-align:right",
                                            "rowSpan"   => 1
                                        ),  
                                        "$aDataTextRef[tRptDisChg]"  => array(
                                            "style"     => "text-align:right",
                                            "rowSpan"   => 1
                                        ),    
                                        "$aDataTextRef[tRptGrandTotal]"  => array(
                                            "style"     => "text-align:right",
                                            "rowSpan"   => 1
                                        ),   
                                    )
                                ),
                                "columns"       => array(
                                    'rtPdtCode'     => array(
                                        "footerText"    => $aDataTextRef['tRptOverall'],
                                        "cssStyle"      => array(
                                            "th"    => "display:none",
                                            "tf"    => "text-align:left"
                                        ),
                                    ),
                                    'rtPdtName'     => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtPdtChainName'     => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtQty'         => array(
                                        "type"          => "number",
                                        "decimals"      => 2,
                                        "footerText"    => number_format($aDataSumFoot['FCXsdQty_SumFooter'],2),
                                        "cssStyle"      => array(
                                            "th"    => "display:none",
                                            "td"    => "text-align:right",
                                            "tf"    => "text-align:right"
                                        ),
                                    ),
                                    'rtNet'         => array(
                                        "type"          => "number",
                                        "decimals"      => 2,
                                        "footerText"    => number_format($aDataSumFoot['FCXsdNet_SumFooter'],2),
                                        "cssStyle"      => array(
                                            "th"    => "display:none",
                                            "td"    => "text-align:right",
                                            "tf"    => "text-align:right"
                                        ),
                                    ),
                                    'rtDisChg'      => array(
                                        "type"          => "number",
                                        "decimals"      => 2,
                                        "footerText"    => number_format($aDataSumFoot['FCXsdDisChg_SumFooter'],2),
                                        "cssStyle"      => array(
                                            "th"    => "display:none",
                                            "td"    => "text-align:right",
                                            "tf"    => "text-align:right"
                                        ),
                                    ),
                                    'rtGrandTotal'  => array(
                                        "type"          => "number",
                                        "decimals"      => 2,
                                        "footerText"    => number_format($aDataSumFoot['FCXsdGrandTotal_SumFooter'],2),
                                        "cssStyle"      => array(
                                            "th"    => "display:none",
                                            "td"    => "text-align:right",
                                            "tf"    => "text-align:right"
                                        ),
                                    )
                                ),
                            ));
                        }else{
                            Table::create(array(
                                "dataSource"    => $this->dataStore("RptBestSaleVending"),
                                "cssClass"      => array(
                                    "table" => "table",
                                ),
                                "headers"       => array(
                                    array(
                                        "$aDataTextRef[tRptPdtCode]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),
                                        "$aDataTextRef[tRptPdtName]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),  
                                        "$aDataTextRef[tRptPdtGrp]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),   
                                        "$aDataTextRef[tRptNumQty]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),  
                                        "$aDataTextRef[tRptSaleNet]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),  
                                        "$aDataTextRef[tRptDisChg]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),    
                                        "$aDataTextRef[tRptGrandTotal]"  => array(
                                            "style"     => "text-align:center",
                                            "rowSpan"   => 1
                                        ),   
                                    )
                                ),
                                "columns"       => array(
                                    'rtPdtCode'     => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtPdtName'     => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtPdtChainName'     => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtQty'         => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtNet'         => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtDisChg'         => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    ),
                                    'rtGrandTotal'         => array(
                                        "cssStyle"  => array(
                                            "th"    =>  "display:none",
                                        ),
                                    )
                                ),
                            ));
                        }
                    ?>
                <?php else:?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptPdtCode'];?></th>    
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptPdtName'];?></th>    
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptPdtGrp'];?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptNumQty'];?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptSaleNet'];?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptDisChg'];?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo @$aDataTextRef['tRptGrandTotal'];?></th>
                        </thead>
                        <tbody>
                            <tr><td class='text-center xCNTextDetail2' colspan='100'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                        </tbody>
                    </table>
                <?php endif;?>
            </div>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["rnAllPage"] > 0):?>
                            <label class="xCNRptLabel"><?php echo @$aDataReport["rnCurrentPage"].' / '.@$aDataReport["rnAllPage"]; ?></label>
                        <?php endif;?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>