<style>
    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: none !important;
    }
    .table>tbody>tr>th, .table>tbody>tr>td {
        padding: 5px !important;
    }
    .xWDOVFontHead {
        font-size: 21px !important;
        font-weight: bold !important;
    }
    .xWDOVDisplaySummary {
        font-size: 25px !important;
        font-weight: bold !important;
    }
    #odvMapMakerExample {
        margin-top: 5px;
        margin-bottom: 5px;
        color: #232C3D;
    }
    #odvMapMakerExample .xWMapMakerList {
        display: inline-block;
        margin-right: 20px;
    }
    #odvMapMakerExample .xWMapMakerPoint {
        width: 11px;
        height: 11px;
        display: inline-block;
        border-radius: 100%;
        vertical-align: middle;
        margin-top: -2px;
        margin-right: 3px;
    }
    #odvMapMakerExample .xWMapMakerLabel {
        display: inline-block;
        vertical-align: middle;
        font-size: 14px !important;
    }
</style>

<div class="panel panel-headline">
    <div id="odvDOVBody" class="panel-body">
        <!-- แผนที่ -->
        <div id="odvContentMap" class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
            <div id="odvGraphShwUsageLabel" class="xWDOVFontHead text-center"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVGraphShwUsage')?></div>
            <div id="odvMap" style="width: 100%; height: 495px"></div> <!-- 750px ( 535-40 ) -->
            <div id="odvMapMakerExample">
                <div class="row">
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                        <?php $aColorPosType = array("#f06292", "#29b6f6", "#8bc34a", "#fdd835"); ?>
                        <?php foreach($aDataPosType as $nIndex => $aValue): ?>
                            <div class="xWMapMakerList">
                                <div class="xWMapMakerPoint" style="background-color: <?=$aColorPosType[$nIndex]?>;"></div>
                                <div class="xWMapMakerLabel"><?=$aValue['tTitle']?></div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right"><span style='color: #c8c8c8; font-size: 16px !important;'><?=$dDataLastUpdOn?></span></div>
                </div>
            </div>
        </div>

        <!-- ข้อมูล -->
        <div id="odvContentData" class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
            <div class="row">
                <!-- จำนวนจุดขายทั่วประเทศแยกตามเครื่องจุดขาย -->
                <div id="odvDOVAllPos" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-left">
                            <span class="xWDOVFontHead"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVNumberSalesPointsByPOS')?></span>
                        </div>
                        <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                            <span class="xWDOVFontHead"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVTotalSaleSummary')?></span>
                        </div>
                    </div>
                    <table class="table table-responsive" style="margin-bottom: 0px;">
                        <tr style='border-bottom: 1px solid #dee2e6 !important;'>
                            <?php
                                foreach($aDataPosType as $aValue){
                                    echo '<th nowrap class="text-right" style="width: 13%;">'.$aValue['tTitle'].'</th>';
                                }
                            ?>
                            <th nowrap class="text-right"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVTotalSale')?></th>
                        </tr>
                        <tr>
                            <?php
                                foreach($aDataPosType as $aValue){
                                    echo '<td nowrap class="text-right"><span class="xWDOVDisplaySummary">'.$aValue['cValue'].'</span></td>';
                                }
                            ?>
                            <td nowrap class="text-right"><span class="xWDOVDisplaySummary"><?=number_format($cTotalSale,$nDecimalShow)?></span> </td>
                        </tr>
                    </table>
                </div>
                
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="row">
                        <!-- กราฟแสดงยอดขายตามภูมิภาค -->
                        <div id="odvChart1" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="xWDOVFontHead text-left"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVGraphShwSaleByRegion')?></div>
                            <div id="odvChartSaleByRegion"></div>
                            <!-- <iframe src="<?php echo base_url(); ?>application/modules/sale/views/dashboardoverview/datasources/chartsalebyregion/wChartSaleByRegionFrame.php" width="100%" height="100%" id="oifChartSaleByRegionFrame" scrolling="no"></iframe> -->
                        </div>
                        <!-- กราฟแสดงยอดขายตามประเภทจุดขาย -->
                        <div id="odvChart2" class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                            <div class="xWDOVFontHead text-left"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVGraphShwSaleByPosType')?></div>
                            <div id="odvChartSaleByPosType"></div>
                            <!-- <iframe src="<?php echo base_url(); ?>application/modules/sale/views/dashboardoverview/datasources/chartsalebyregion/wChartSaleByPosTypeFrame.php" width="100%" height="100%" id="oifChartSaleByPosTypeFrame" scrolling="no"></iframe> -->
                        </div>
                    </div>
                </div>
                <!-- 10 อันดับขายดีตามมูลค่าขาย -->
                <div id="odvDOVTop10SaleByValue" class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <span class="xWDOVFontHead"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVStoreSalesData')?></span> <!-- tDOVTopBestSellers -->
                    <div id="odvDOVTableTop10" class="table-responsive" style='height: 130px;'>
                        <table class="table" style="margin-bottom: 0px;">
                            <tr style='border-bottom: 1px solid #dee2e6 !important;'>
                                <th nowrap class="text-center" style='width: 13%;'><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVOrder')?></th>
                                <th nowrap class="text-left" style='width: 13%;'><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVShopName')?></th> <!-- tDOVProductName -->
                                <th nowrap class="text-left" style='width: 13%;'><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVSalDate')?></th>
                                <th nowrap class="text-right"><?=language('sale/dashboardoverview/dsahboardoverview', 'tDOVValue')?></th>
                            </tr>
                            <?php foreach($aDataTopPdt as $nIndex => $aValue): ?>
                            <tr>
                                <td nowrap class="text-center"><?=$nIndex+1?></td>
                                <td nowrap class="text-left"><?=$aValue['tTitle']?></td>
                                <td nowrap class="text-left"><?=$aValue['tDate']?></td>
                                <td nowrap class="text-right"><?=number_format($aValue['cValue'],$nDecimalShow)?></td>
                            </tr>
                            <?php endforeach; ?>
                        </table>
                    </div>
                </div>

            </div>
        </div>
        
    </div>
</div>

<?php include "script/jDashBoardOverview.php"; ?>