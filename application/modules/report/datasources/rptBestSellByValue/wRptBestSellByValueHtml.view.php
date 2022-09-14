<?php
    use \koolreport\widgets\koolphp\Table;
    $nCurrentPage = $this->params['nCurrentPage'];
    $nAllPage = $this->params['nAllPage'];
    $aDataTextRef = $this->params['aDataTextRef'];
    $aDataReport = $this->params['aDataReturn'];
    $aCompanyInfo = $this->params['aCompanyInfo'];
    $aDataFilter = $this->params['aDataFilter'];
    $aSumDataReport = $this->params['aSumDataReport'];
    $nDecimalShw = FCNxHGetOptionDecimalShow();
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
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
        border-
         : 1px solid black !important;
    }
    .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        /* color: #232C3D !important; */
        font-size: 18px !important;
        font-weight: 600;
    }
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }
/*

    .xCNFoot{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
    }

    .cssItem{
        text-align:left;
        white-space:nowrap;
        font-weight: bold;
        background-color:#CFE2F3;
    } */

    /*แนวนอน*/
    @media print{@page {size: A4 landscape;
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
    }}

</style>

<div id="odvRptSaleVatInvoiceByBillHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">

            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['aDataFilter']['tBchNameFrom']) && !empty($aDataFilter['aDataFilter']['tBchNameFrom'])) && (isset($aDataFilter['aDataFilter']['tBchNameTo']) && !empty($aDataFilter['aDataFilter']['tBchNameTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </label>   <label><?=$aDataFilter['aDataFilter']['tBchNameFrom']; ?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </label>   <label><?=$aDataFilter['aDataFilter']['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['aDataFilter']['tDocDateFrom']) && !empty($aDataFilter['aDataFilter']['tDocDateFrom'])) && (isset($aDataFilter['aDataFilter']['tDocDateTo']) && !empty($aDataFilter['aDataFilter']['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']?> : </label>   <label><?=date("d/m/Y", strtotime($aDataFilter['aDataFilter']['tDocDateFrom'])); ?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']?> : </label>   <label><?=date("d/m/Y", strtotime($aDataFilter['aDataFilter']['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right xCNRptFilter">
                        <?php date_default_timezone_set('Asia/Bangkok'); ?>
                        <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tRptTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvTableKoolReport" class="table-responsive">
                <?php if(isset($aDataReport['rtCode']) &&  !empty($aDataReport['rtCode']) && $aDataReport['rtCode'] == '1'):?>
                    <?php
                        $bShowFooter = false;
                        if( $nCurrentPage == $nAllPage ) {
                            $bShowFooter = true;
                        }
                    ?>
                    <?php
                        // Check Page Footer Show Total Sum
                            $oOptionKoolRpt = array(
                                "dataSource" => $this->dataStore("RptBestSellByValue"),
                                "showFooter" => $bShowFooter,
                                "cssClass" => array(
                                    "table" => "table",
                                    "th" => "xCNRptColumnHeader",
                                    "td" => "xCNRptDetail",
                                    "tf" => "xCNFoot",
                                ),
                                // "showFooter"=>true,
                                "columns" => array(
                                    "FTPdtCode" => array(
                                        "cssStyle" => array(
                                            "tf" => "padding-left: 10px; font-size: 18px !important; font-weight: bold",
                                            "td" => "text-align:left;"
                                        ),
                                        "label" => $aDataTextRef['tPdtCode'],
                                        "footerText" => $aDataTextRef['tRptTotalSub'],
                                    ),
                                    "FTXsdPdtName" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left"
                                        ),
                                        "label" => $aDataTextRef['tPdtName'],
                                    ),
                                    "FTPgpChainName" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left"
                                        ),
                                        "label" => $aDataTextRef['tPdtGrp'],
                                    ),
                                    "FCXsdQty" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left"
                                        ),
                                        "label" => $aDataTextRef['tQty'],

                                    ),
                                    "FTPunName" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left",
                                            "th" => "text-align:left"
                                        ),
                                        "label" => $aDataTextRef['tRptUnit'],

                                    ),

                                    "FCXsdDigChg" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left"
                                        ),
                                    ),
                                    "FCXsdDis" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left"
                                        ),
                                        "label" => $aDataTextRef['tPdtCode'],
                                    ),
                                    "FCXsdSetPrice" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:right",
                                            "th" => "text-align:right"
                                        ),
                                        "label" => $aDataTextRef['tRptAverage'],
                                        "type" =>"number",
                                        "decimals" => $nDecimalShw,

                                    ),
                                    "FCXsdNetAfHD" => array(
                                        "cssStyle" => array(
                                            "tf" => "font-weight: bold;",
                                            "td" => "text-align:left"
                                        ),
                                        "label" => $aDataTextRef['tPdtCode'],
                                    ),
                                    "FCXsdQty" => array(
                                        "cssStyle" => array(
                                            "th" => "text-align:right",
                                            "tf" => "text-align:right; font-size: 18px !important; font-weight: bold",
                                            "td" => "text-align:right"
                                        ),
                                        "label" => $aDataTextRef['tQty'],
                                        "type" =>"number",
                                        "decimals" => $nDecimalShw,
                                        "footerText" => $bShowFooter ? number_format($aSumDataReport['FCXsdSumQty'], $nDecimalShw) : '',
                                    ),
                                    "FCXsdDigChg" => array(
                                        "cssStyle" => array(
                                            "th" => "text-align:right",
                                            "tf" => "text-align:right; font-size: 18px !important; font-weight: bold",
                                            "td" => "text-align:right"
                                        ),
                                        "label" => $aDataTextRef['tSales'],
                                        "type" =>"number",
                                        "decimals" => $nDecimalShw,
                                        "footerText" => $bShowFooter ? number_format($aSumDataReport['FCXsdSumDigChg'], $nDecimalShw) : '',
                                    ),
                                    "FCXsdDis" => array(
                                        "cssStyle" => array(
                                            "th" => "text-align:right",
                                            "tf" => "text-align:right; font-size: 18px !important; font-weight: bold",
                                            "td" => "text-align:right"
                                        ),
                                        "label" => $aDataTextRef['tDiscount'],
                                        "type" => "number",
                                        "decimals" => $nDecimalShw,
                                        "footerText" => $bShowFooter ? number_format($aSumDataReport['FCXsdSumDis'], $nDecimalShw) : '',
                                    ),
                                    "FCXsdNetAfHD" => array(
                                        "cssStyle" => array(
                                            "th" => "text-align:right",
                                            "tf" => "text-align:right; font-size: 18px !important; font-weight: bold",
                                            "td" => "text-align:right"
                                        ),
                                        "label" => $aDataTextRef['tTotalsales'],
                                        "type" =>"number",
                                        "decimals" => $nDecimalShw,
                                        "footerText" => $bShowFooter ? number_format($aSumDataReport['FCSumFooter'], $nDecimalShw) : '',
                                    )
                                )
                            );


                        // Create Table Kool Report
                        Table::create($oOptionKoolRpt);
                    ?>
                <?php else:?>
                        <table class="table">
                            <thead>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tPdtCode'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tPdtName'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tPdtGrp'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tQty'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptUnit'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tSales'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tDiscount'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tRptAverage'];?></th>
                                <th nowrap  class="text-center xCNRptColumnHeader"><?php echo @$aDataTextRef['tTotalsales'];?></th>
                            </thead>
                            <tbody>
                                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                            </tbody>
                        </table>
                <?php endif;?>
            </div>

            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['aDataFilter']['tBchCodeSelect']) && !empty($aDataFilter['aDataFilter']['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['aDataFilter']['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['aDataFilter']['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['aDataFilter']['tMerCodeFrom']) && !empty($aDataFilter['aDataFilter']['tMerCodeFrom'])) && (isset($aDataFilter['aDataFilter']['tMerCodeTo']) && !empty($aDataFilter['aDataFilter']['tMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['aDataFilter']['tMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['aDataFilter']['tMerNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['aDataFilter']['tMerCodeSelect']) && !empty($aDataFilter['aDataFilter']['tMerCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['aDataFilter']['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['aDataFilter']['tMerNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
            <?php if ((isset($aDataFilter['aDataFilter']['tShpCodeFrom']) && !empty($aDataFilter['aDataFilter']['tShpCodeFrom'])) && (isset($aDataFilter['aDataFilter']['tShpCodeTo']) && !empty($aDataFilter['aDataFilter']['tShpCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['aDataFilter']['tShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['aDataFilter']['tShpNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['aDataFilter']['tShpCodeSelect']) && !empty($aDataFilter['aDataFilter']['tShpCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['aDataFilter']['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['aDataFilter']['tShpNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['aDataFilter']['tPosCodeFrom']) && !empty($aDataFilter['aDataFilter']['tPosCodeFrom'])) && (isset($aDataFilter['aDataFilter']['tPosCodeTo']) && !empty($aDataFilter['aDataFilter']['tPosCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['aDataFilter']['tPosCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['aDataFilter']['tPosCodeTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['aDataFilter']['tPosCodeSelect']) && !empty($aDataFilter['aDataFilter']['tPosCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['aDataFilter']['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['aDataFilter']['tPosCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['aDataFilter']['tPdtNameFrom']) && !empty($aDataFilter['aDataFilter']['tPdtNameFrom'])) && (isset($aDataFilter['aDataFilter']['tPdtNameTo']) && !empty($aDataFilter['aDataFilter']['tPdtNameTo']))): ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล สินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['aDataFilter']['tPdtNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['aDataFilter']['tPdtNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['aDataFilter']['tPdtGrpNameFrom']) && !empty($aDataFilter['aDataFilter']['tPdtGrpNameFrom'])) && (isset($aDataFilter['aDataFilter']['tPdtGrpNameTo']) && !empty($aDataFilter['aDataFilter']['tPdtGrpNameTo']))): ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'].' : </span>'.$aDataFilter['aDataFilter']['tPdtGrpNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'].' : </span>'.$aDataFilter['aDataFilter']['tPdtGrpNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['aDataFilter']['tPdtTypeNameFrom']) && !empty($aDataFilter['aDataFilter']['tPdtTypeNameFrom'])) && (isset($aDataFilter['aDataFilter']['tPdtTypeNameTo']) && !empty($aDataFilter['aDataFilter']['tPdtTypeNameTo']))): ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeFrom'].' : </span>'.$aDataFilter['aDataFilter']['tPdtTypeNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeTo'].' : </span>'.$aDataFilter['aDataFilter']['tPdtTypeNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>


            <!-- ============================ ฟิวเตอร์ข้อมูล Top ============================ -->
            <?php if ((isset($aDataFilter['aDataFilter']['tTopPdt']) && !empty($aDataFilter['aDataFilter']['tTopPdt']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPriority'].' : </span>'.$aDataFilter['aDataFilter']['tTopPdt'];?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล tRptPosType ============================ -->
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['aDataFilter']['tPosType']]; ?></label>
                </div>
            </div>

        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                    <label class="xCNRptLabel"><?php echo $nCurrentPage.' / '.$nAllPage; ?></label>
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
        $('tfoot').find('tr').attr('style', 'border-top: 1px solid black !important;border-bottom: 1px solid black !important;');
        var tFoot = $('tfoot').html();

        $('tfoot').remove();

        <?php if($nCurrentPage==$nAllPage) { ?>
            $('tbody').append(tFoot);
        <?php } ?>
    });
</script>
