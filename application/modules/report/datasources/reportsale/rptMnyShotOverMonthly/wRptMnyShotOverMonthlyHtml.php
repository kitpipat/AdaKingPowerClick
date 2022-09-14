<?php
    $aCompanyInfo = $aDataViewRpt['aCompanyInfo'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataReport = $aDataViewRpt['aDataReport'];
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
        /*border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;*/
    }

    .table>thead:first-child>tr:first-child>td:nth-child(1),
    .table>thead:first-child>tr:first-child>th:nth-child(1),
    .table>thead:first-child>tr:first-child>td:nth-child(2),
    .table>thead:first-child>tr:first-child>th:nth-child(2),
    .table>thead:first-child>tr:first-child>td:nth-child(3),
    .table>thead:first-child>tr:first-child>th:nth-child(3) {
        border-bottom: 1px dashed #ccc !important;
    }

    .table>thead:first-child>tr:last-child>td,
    .table>thead:first-child>tr:last-child>th {
        /*border-top: 1px solid black !important;*/
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }

    .xWRptMSODlinetablemenu {

border-right: 1px dashed #ccc !important;
}
    .xWRptMSODUnderline {

border-bottom: 1px dashed #ccc !important;
}
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(3),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(4),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(5),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(6),
    .table>tbody>tr.xCNRptLastPdtList>td:nth-child(7) {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptLastGroupTr,
    .table>tbody>tr.xCNRptLastGroupTr>td {
        border: 0px solid black !important;
        border-bottom: 1px dashed #ccc !important;
    }

    .table tbody tr.xCNRptSumFooterTrTop,
    .table>tbody>tr.xCNRptSumFooterTrTop>td {
        border: 0px solid black !important;
        border-top: 1px solid black !important;
    }

    .table tbody tr.xCNRptSumFooterTrBottom,
    .table>tbody>tr.xCNRptSumFooterTrBottom>td {
        border: 0px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tfoot>tr {
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom: 6px double black !important;
    }

    /*แนวนอน*/
    @media print{@page {size: landscape}}
    /*แนวตั้ง*/
    /* @media print {
        @page {
            size: portrait
        }
    } */


</style>

<div id="odvRptAdjustStockVendingHtml">
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

                     <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                     <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>


                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'] ?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                   <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'] ?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom'] ?> : </label>   <label><?=$aDataFilter['tBchNameFrom']; ?></label>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo'] ?> : </label>   <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tMonth']) && !empty($aDataFilter['tMonth']))){ ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล เดือน ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <?php
                                        $tTextMonth = 'tRptMonth'.$aDataFilter['tMonth'];
                                    ?>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMonth']?></label> <label><?=$aDataTextRef[$tTextMonth];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                    <?php if ((isset($aDataFilter['tYear']) && !empty($aDataFilter['tYear']))){ ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ปี ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptYear']?></label> <label><?=$aDataFilter['tYear'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    &nbsp;
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>

        <div class="xCNContentReport">
            <div id="odvRptTableShotOverHtml" class="table-responsive">
            <table class="table " >
                    <thead>
                        <tr>
                            <th rowspan ="2" class="text-right xCNRptColumnHeader " style = "vertical-align : middle;text-align:left; "><?php echo $aDataTextRef['tRptMnyShowOverRowID']; ?></th>
                            <th rowspan ="2" class="text-center xCNRptColumnHeader" style ="vertical-align : middle;text-align:left; border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyUsrId']; ?></th>
                            <th colspan="31" class="text-center xCNRptColumnHeader " style ="vertical-align : middle;text-align:center; border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyDate']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="vertical-align : middle;text-align:center; border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyTotalMO']; ?></th>
                            <th colspan="4" class="text-center xCNRptColumnHeader" style="vertical-align : middle;text-align:center; border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyAmt']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader " style="vertical-align : middle;text-align:center; border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlySign']; ?></th>
                        </tr>
                        <tr>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD1']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD2']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD3']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD4']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD5']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD6']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD7']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD8']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD9']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD10']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD11']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD12']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD13']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD14']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD15']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD16']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD17']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD18']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD19']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD20']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD21']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD22']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD23']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD24']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD25']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD26']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD27']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD28']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD29']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD30']; ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyD31']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"> </th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyMM']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyShowOverMonthlyOM']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyCashIn']; ?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aDataTextRef['tRptMnyCashOut']; ?></th>
                            <th> </th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                     if(!empty($aDataReport['aRptData'])){
                         foreach($aDataReport['aRptData'] as $aData){
                    ?>
                        <tr>
                            <td  class="text-center xCNRptDetail" style="width:5%;"><?php echo $aData['RowID']; ?></td>
                            <td  class="text-left xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo $aData['FTUsrCode']; ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD1'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD2'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD3'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD4'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD5'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD6'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD7'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD8'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD9'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD10'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD11'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD12'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD13'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD14'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD15'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD16'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD17'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD18'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD19'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD20'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD21'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD22'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD23'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD24'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD25'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD26'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD27'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD28'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD29'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD30'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FTDayD31'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FCShotOver'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FCMnyShot']*(-1),2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FCMnyOver'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FCSvnCashIn'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:5%;  border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important;"><?php echo number_format($aData['FCSvnCashOut'],2); ?></td>
                            <td  class="text-right xCNRptDetail" style="width:10%;"></td>
                        </tr>
                    <?php
                            }
                        ?>
                        <?php
                            $nPageNo     = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage  = $aDataReport["aPagination"]["nTotalPage"];
                            if ($nPageNo == $nTotalPage) {
                        ?>
                              <?php
                                    echo '
                                        </tr>';
                                    echo '<tr  style="border-bottom: 1px solid black !important">
                                        <td colspan = "39"  class="text-center xCNRptSumFooter"></td>
                                    </tr>';
                                ?>

                                <tr class="xCNTrFooter">
                                    <td colspan ="2" class="text-left xCNRptSumFooter"><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD1_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD2_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD3_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD4_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD5_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD6_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD7_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD8_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD9_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD10_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD11_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD12_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD13_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD14_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD15_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD16_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD17_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD18_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD19_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD20_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD21_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD22_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD23_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD24_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD25_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD26_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD27_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD28_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD29_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD30_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FTDayD31_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FCShotOver_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FCMnyShot_Footer']*(-1),2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FCMnyOver_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FCSvnCashIn_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail" style="border-left: 1px dashed #ccc !important; border-right: 1px dashed #ccc !important; font-weight: bold;"><?php echo number_format($aData['FCSvnCashOut_Footer'],2);?></td>
                                    <td class="text-center xCNRptDetail"></td>
                                </tr>
                    <?php } ?>

                     <?php }else{ ?>
                        <tr>
                            <td  colspan="100"  class="text-center xCNRptColumnFooter" ><?php echo $aDataTextRef['tRptNoData']; ?></td>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            </div>

            <?php if( ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo'])))
                      || (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect']))
                    ) : ?>
                <div class="xCNRptFilterTitle">
                    <div class="text-left">
                        <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
            <?php if ((isset($aDataFilter['tCashierCodeFrom']) && !empty($aDataFilter['tCashierCodeFrom'])) && (isset($aDataFilter['tCashierCodeTo']) && !empty($aDataFilter['tCashierCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom'].' : </span>'.$aDataFilter['tCashierNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo'].' : </span>'.$aDataFilter['tCashierNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tCashierCodeSelect']) && !empty($aDataFilter['tCashierCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCashierStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCashierNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
            <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0): ?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"] . ' / ' . $aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif; ?>
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
    });
</script>
