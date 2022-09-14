<?php
    $aDataReport = $aDataViewRpt['aDataReport'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $nOptDecimalShow = FCNxHGetOptionDecimalShow();
    $aMm = explode("-",$aDataFilter['tDocDateFrom']);
    $aM = array("01"=>"ม.ค.","02"=>"ก.พ.","03"=>"มี.ค.","04"=>"เม.ย.","05"=>"พ.ค.","06"=>"มิ.ย.","07"=>"ก.ค.","08"=>"ส.ค.","09"=>"ก.ย.","10"=>"ต.ค.","11"=>"พ.ย.","12"=>"ธ.ค.");
    $tMon = $aM[$aMm[1]];

?>
<style>
    .xCNFooterRpt {
        border-bottom: 7px double #ddd;

    }

    .table thead th{
        border-bottom: 1px solid black !important;

    }
    .table>thead>tr>th,
    .table tbody tr,
    .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td,
    .table>thead:first-child>tr:first-child>th {
        border: 1px solid black !important;
    }

    .table>thead:first-child>tr:last-child>td,
    .table>thead:first-child>tr:last-child>th {
        border-bottom: 1px solid black !important;
    }

    .xWRptProductFillData>td:first-child {
        text-indent: 40px;
    }
    th{
      border: 1px dashed #ccc;
      padding: 5px;
    }
    td{
      border: 1px dashed #ccc;
      padding: 5px;
    }
    /*แนวนอน*/
    /* @media print{@page {size: landscape}} */
    /*แนวตั้ง*/

    @media print{@page {size: landscape;
        margin: 1.5mm 1.5mm 1.5mm 1.5mm;
    }}
</style>
<div id="odvRptAdjPriceHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>
                    <?php if( (isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom']))) { ?>
                        <!-- ===== ฟิวเตอร์ข้อมูล วันที่ =================================== -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <!-- <label class="xCNRptFilterHead"><label><?=$aDataFilter['tDocDateFrom'];?></label> -->
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDate']?></label> <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ===== ฟิวเตอร์ข้อมูล สาขา =================================== -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalePosFilterBchFrom']?></label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalePosFilterBchTo']?></label> <label><?=$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="">
                    <thead>
                        <tr style="border-top: 1px solid black;border-bottom: 1px solid black">
                          <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" style="border-left: 0px;" ><?php echo $aDataTextRef['tFTFhnRefCode'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPdtCode'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTBarCode'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPdtName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTClrName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPbnName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTDepName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTClsName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTSclName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPgpName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTCmlName'];?></th>
                            <th rowspan="3" nowrap class="text-right xCNRptColumnHeader" ><?php echo $aDataTextRef['tFCPgdPriceRet'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFDFhnStart'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTFhnModNo'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTFabName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTFhnGender'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPmoName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTSeaName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPunName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTPszName'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFTClrRmk'];?></th>
                            <th rowspan="3" nowrap class="text-left xCNRptColumnHeader" ><?php echo $aDataTextRef['tFCFhnCostStd'];?></th>
                            <th rowspan="3" nowrap class="text-right xCNRptColumnHeader" ><?php echo $aDataTextRef['tFCFhnCostOth'];?></th>
                            <th rowspan="3" nowrap class="text-right xCNRptColumnHeader" ><?php echo $aDataTextRef['tFCStfQtyEnd'];?></th>
                            <th  colspan="4" nowrap class="text-center xCNRptColumnHeader" ><?php echo $aDataTextRef['tReportSellToImp'];?></th>
                            <th  rowspan="2" colspan="3" nowrap class="text-center xCNRptColumnHeader" ><?php echo $aDataTextRef['tReportSellToExp']; ?></th>
                            <th  rowspan="2"  colspan="2"  nowrap class="text-center xCNRptColumnHeader" ><?php echo $aDataTextRef['tReportSellToA']; ?></th>
                            <th   rowspan="2"  colspan="2" nowrap class="text-center xCNRptColumnHeader"  style="border-right: 0px;"  ><?php echo $aDataTextRef['tReportSellToB'];?>(%)</th>
                        </tr>
                        <tr style="border-top: 1px solid black;border-bottom: 1px solid black">
                            <th   class="text-center "  nowrap colspan="2" ><?php echo $aDataTextRef['tReportSellToImp']; ?></th>
                            <th   class="text-center " nowrap colspan="2"  style="border-right: 0px;"  ><?php echo $aDataTextRef['tReportSellToJ']; ?></th>
                        </tr>
                        <tr  style="border-top: 1px solid black;border-bottom: 1px solid black">
                          <th nowrap  class="text-center " style="border-left: 0px;" ><?php echo $aDataTextRef['tReportSellToC'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToD'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToC'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToD'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToE'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToF'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToG'];?></th>
                          <th nowrap   class="text-center "><?php echo $aDataTextRef['tReportSellToH'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToI'];?></th>
                          <th nowrap  class="text-center "><?php echo $aDataTextRef['tReportSellToO'].$aDataTextRef['tReportSellToImp']; ?></th>
                          <th nowrap  class="text-center " style="border-right: 0px;"  ><?php echo $aDataTextRef['tReportSellToO'].$aDataTextRef['tReportSellToJ']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                                  if ($aValue["FTFhnRefCode"]=="") {
                                    $tFTFhnRefCode ="-";
                                    // code...
                                  }else {
                                    $tFTFhnRefCode = $aValue["FTFhnRefCode"];
                                  }
                                  if ($aValue["FTPdtCode"]=="") {
                                    $tFTPdtCode ="-";
                                    // code...
                                  }else {
                                    $tFTPdtCode = $aValue["FTPdtCode"];
                                  }
                                  if ($aValue["FTBarCode"]=="") {
                                    $tFTBarCode ="-";
                                    // code...
                                  }else {
                                    $tFTBarCode = $aValue["FTBarCode"];
                                  }
                                  if ($aValue["FTPdtName"]=="") {
                                    $tFTPdtName ="-";
                                    // code...
                                  }else {
                                    $tFTPdtName = $aValue["FTPdtName"];
                                  }

                                  if ($aValue["FTClrName"]=="") {
                                    $tFTClrName ="-";
                                    // code...
                                  }else {
                                    $tFTClrName = $aValue["FTClrName"];
                                  }
                                  if ($aValue["FTPbnName"]=="") {
                                    $tFTPbnName ="-";
                                    // code...
                                  }else {
                                    $tFTPbnName = $aValue["FTPbnName"];
                                  }
                                  if ($aValue["FTDepName"]=="") {
                                    $tFTDepName ="-";
                                    // code...
                                  }else {
                                    $tFTDepName = $aValue["FTDepName"];
                                  }
                                  if ($aValue["FTClsName"]=="") {
                                    $tFTClsName ="-";
                                    // code...
                                  }else {
                                    $tFTClsName = $aValue["FTClsName"];
                                  }
                                  if ($aValue["FTSclName"]=="") {
                                    $tFTSclName ="-";
                                    // code...
                                  }else {
                                    $tFTSclName = $aValue["FTSclName"];
                                  }
                                  if ($aValue["FTPgpName"]=="") {
                                    $tFTPgpName ="-";
                                    // code...
                                  }else {
                                    $tFTPgpName = $aValue["FTPgpName"];
                                  }
                                  if ($aValue["FTCmlName"]=="") {
                                    $tFTCmlName ="-";
                                    // code...
                                  }else {
                                    $tFTCmlName = $aValue["FTCmlName"];
                                  }
                                  if ($aValue["FCPgdPriceRet"]=="") {
                                    $tFCPgdPriceRet ="-";
                                    // code...
                                  }else {
                                    $tFCPgdPriceRet = $aValue["FCPgdPriceRet"];
                                  }
                                  if ($aValue["FDFhnStart"]=="") {
                                    $tFDFhnStart ="-";
                                    // code...
                                  }else {
                                    $aFDFhnStart = explode(" ",$aValue["FDFhnStart"]);
                                    $tFDFhnStart = $aFDFhnStart[0];
                                  }
                                  if ($aValue["FTFhnModNo"]=="") {
                                    $tFTFhnModNo ="-";
                                    // code...
                                  }else {
                                    $tFTFhnModNo = $aValue["FTFhnModNo"];
                                  }
                                  if ($aValue["FTFabName"]=="") {
                                    $tFTFabName ="-";
                                    // code...
                                  }else {
                                    $tFTFabName = $aValue["FTFabName"];
                                  }
                                  if ($aValue["FTFhnGender"]=="") {
                                    $tFTFhnGender ="-";
                                    // code...
                                  }else {
                                    $tFTFhnGender =  $aDataTextRef['tReportSellTolSex'.$aValue["FTFhnGender"]];
                                  }
                                  if ($aValue["FTPmoName"]=="") {
                                    $tFTPmoName ="-";
                                    // code...
                                  }else {
                                    $tFTPmoName = $aValue["FTPmoName"];
                                  }
                                  if ($aValue["FTSeaName"]=="") {
                                    $tFTSeaName ="-";
                                    // code...
                                  }else {
                                    $tFTSeaName = $aValue["FTSeaName"];
                                  }
                                  if ($aValue["FTPunName"]=="") {
                                    $tFTPunName ="-";
                                    // code...
                                  }else {
                                    $tFTPunName = $aValue["FTPunName"];
                                  }
                                  if ($aValue["FTPszName"]=="") {
                                    $tFTPszName ="-";
                                    // code...
                                  }else {
                                    $tFTPszName = $aValue["FTPszName"];
                                  }
                                  if ($aValue["FTClrRmk"]=="") {
                                    $tFTClrRmk ="-";
                                    // code...
                                  }else {
                                    $tFTClrRmk = $aValue["FTClrRmk"];
                                  }
                                  if ($aValue["FCFhnCostStd"]=="") {
                                    $tFCFhnCostStd ="-";
                                    // code...
                                  }else {
                                    $tFCFhnCostStd = $aValue["FCFhnCostStd"];
                                  }
                                  if ($aValue["FCFhnCostOth"]=="") {
                                    $tFCFhnCostOth ="-";
                                    // code...
                                  }else {
                                    $tFCFhnCostOth = $aValue["FCFhnCostOth"];
                                  }
                                  if ($aValue["FCStfQtyEnd"]=="") {
                                    $tFCStfQtyEnd ="-";
                                    // code...
                                  }else {
                                    $tFCStfQtyEnd = $aValue["FCStfQtyEnd"];
                                  }
                                  if ($aValue["FCStfQtyIN"]=="") {
                                    $tFCStfQtyIN ="-";
                                    // code...
                                  }else {
                                    $tFCStfQtyIN = $aValue["FCStfQtyIN"];
                                  }
                                  if ($aValue["FCStfInRet"]=="") {
                                    $tFCStfInRet ="-";
                                    // code...
                                  }else {
                                    $tFCStfInRet = $aValue["FCStfInRet"];
                                  }
                                  if ($aValue["FCStfQtyEndIn"]=="") {
                                    $tFCStfQtyEndIn ="-";
                                    // code...
                                  }else {
                                    $tFCStfQtyEndIn = $aValue["FCStfQtyEndIn"];
                                  }
                                  if ($aValue["FCStfEndInRet"]=="") {
                                    $tFCStfEndInRet ="-";
                                    // code...
                                  }else {
                                    $tFCStfEndInRet = $aValue["FCStfEndInRet"];
                                  }
                                  if ($aValue["FCStfQtySale"]=="") {
                                    $tFCStfQtySale ="-";
                                    // code...
                                  }else {
                                    $tFCStfQtySale = $aValue["FCStfQtySale"];
                                  }
                                  if ($aValue["FCStfGrossSales"]=="") {
                                    $tFCStfGrossSales ="-";
                                    // code...
                                  }else {
                                    $tFCStfGrossSales = $aValue["FCStfGrossSales"];
                                  }
                                  if ($aValue["FCStfNetSale"]=="") {
                                    $tFCStfNetSale ="-";
                                    // code...
                                  }else {
                                    $tFCStfNetSale = $aValue["FCStfNetSale"];
                                  }
                                  if ($aValue["FCStfOnHandQty"]=="") {
                                    $tFCStfOnHandQty ="-";
                                    // code...
                                  }else {
                                    $tFCStfOnHandQty = $aValue["FCStfOnHandQty"];
                                  }
                                  if ($aValue["FCStfOnHandRetValue"]=="") {
                                    $tFCStfOnHandRetValue ="-";
                                    // code...
                                  }else {
                                    $tFCStfOnHandRetValue = $aValue["FCStfOnHandRetValue"];
                                  }
                                  if ($aValue["FCStfPfmPeriod"]=="") {
                                    $tFCStfPfmPeriod ="-";
                                    // code...
                                  }else {
                                    $tFCStfPfmPeriod = $aValue["FCStfPfmPeriod"];
                                  }
                                  if ($aValue["FCStfPfmOverAll"]=="") {
                                    $tFCStfPfmOverAll ="-";
                                    // code...
                                  }else {
                                    $tFCStfPfmOverAll = $aValue["FCStfPfmOverAll"];
                                  }
                              echo "<tr>";
                              echo '<td nowrap class="xCNRptDetail" style="border-left: 0px;" >'.$tFTFhnRefCode.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPdtCode.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTBarCode.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPdtName.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTClrName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPbnName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTDepName.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTClsName.'&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTSclName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPgpName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTCmlName.'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCPgdPriceRet,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFDFhnStart.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTFhnModNo.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTFabName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTFhnGender.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPmoName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTSeaName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPunName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTPszName.'</td>';
                              echo '<td nowrap class="xCNRptDetail">'.$tFTClrRmk.'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCFhnCostStd,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCFhnCostOth,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfQtyEnd,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfQtyIN,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfInRet,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfQtyEndIn,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfEndInRet,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfQtySale,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfGrossSales,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfNetSale,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfOnHandQty,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfOnHandRetValue,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right">'.number_format($tFCStfPfmPeriod,$nOptDecimalShow).'</td>';
                              echo '<td nowrap class="xCNRptDetail text-right" style="border-right: 0px;"  >'.number_format($tFCStfPfmOverAll,$nOptDecimalShow).'</td>';
                              echo "</tr>";
                              ?>

                            <?php } ?>
                        <?php }else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSalePosNoData'];?></td></tr>
                        <?php } ;?>
                    </tbody>
                </table>
            </div>
            <div class="xCNRptFilterTitle"> <!-- style="margin-top: 10px;" -->
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <!-- ===== ฟิวเตอร์ข้อมูล สาขา =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            <?php if( (isset($aDataFilter['tPdtCodeFrom']) && !empty($aDataFilter['tPdtCodeFrom'])) && (isset($aDataFilter['tPdtCodeTo']) && !empty($aDataFilter['tPdtCodeTo']))) { ?>
                <!-- ===== ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeFrom'].' : </span>'.$aDataFilter['tPdtNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtCodeTo'].' : </span>'.$aDataFilter['tPdtNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>
            <?php if( (isset($aDataFilter['tRefCodeFrom']) && !empty($aDataFilter['tRefCodeFrom'])) && (isset($aDataFilter['tRefCodeTo']) && !empty($aDataFilter['tRefCodeTo']))) { ?>
                <!-- ===== ฟิวเตอร์ข้อมูล รหัสควบคุมสต็อกสินค้า =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtRefFrom'].' : </span>'.$aDataFilter['tRefCodeFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtRefTo'].' : </span>'.$aDataFilter['tRefCodeTo'];?></label>
                    </div>
                </div>
            <?php } ;?>
            <?php if( (isset($aDataFilter['tSeaCodeFrom']) && !empty($aDataFilter['tSeaCodeFrom'])) && (isset($aDataFilter['tSeaCodeTo']) && !empty($aDataFilter['tSeaCodeTo']))) { ?>
                <!-- ===== ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tSeaCodeFrom'].' : </span>'.$aDataFilter['tSeaNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tSeaCodeTo'].' : </span>'.$aDataFilter['tSeaNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>
            <?php if( (isset($aDataFilter['tFabCodeFrom']) && !empty($aDataFilter['tFabCodeFrom'])) && (isset($aDataFilter['tFabCodeTo']) && !empty($aDataFilter['tFabCodeTo']))) { ?>
                <!-- ===== ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tFabCodeFrom'].' : </span>'.$aDataFilter['tFabNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tFabCodeTo'].' : </span>'.$aDataFilter['tFabNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>
            <?php if( (isset($aDataFilter['tClrCodeFrom']) && !empty($aDataFilter['tClrCodeFrom'])) && (isset($aDataFilter['tClrCodeTo']) && !empty($aDataFilter['tClrCodeTo']))) { ?>
                <!-- ===== ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tClrCodeFrom'].' : </span>'.$aDataFilter['tClrNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tClrCodeTo'].' : </span>'.$aDataFilter['tClrNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>
            <?php if( (isset($aDataFilter['tPszCodeFrom']) && !empty($aDataFilter['tPszCodeFrom'])) && (isset($aDataFilter['tPszCodeTo']) && !empty($aDataFilter['tPszCodeTo']))) { ?>
                <!-- ===== ฟิวเตอร์ข้อมูล สินค้า =========================================== -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPszCodeFrom'].' : </span>'.$aDataFilter['tPszNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPszCodeTo'].' : </span>'.$aDataFilter['tPszNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>
            <?php if( (isset($aDataFilter['tPdtGrpCodeFrom']) && !empty($aDataFilter['tPdtGrpCodeFrom'])) && (isset($aDataFilter['tPdtGrpCodeTo']) && !empty($aDataFilter['tPdtGrpCodeTo']))) { ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มสินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpFrom'].' : </span>'.$aDataFilter['tPdtGrpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtGrpTo'].' : </span>'.$aDataFilter['tPdtGrpNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>


            <?php if( (isset($aDataFilter['tPdtTypeCodeFrom']) && !empty($aDataFilter['tPdtTypeCodeFrom'])) && (isset($aDataFilter['tPdtTypeCodeTo']) && !empty($aDataFilter['tPdtTypeCodeTo']))) { ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทสินค้า ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeFrom'].' : </span>'.$aDataFilter['tPdtTypeNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtTypeTo'].' : </span>'.$aDataFilter['tPdtTypeNameTo'];?></label>
                    </div>
                </div>
            <?php } ;?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ยี่ห้อ ============================ -->
                <?php if ((isset($aDataFilter['tPdtBrandCodeFrom']) && !empty($aDataFilter['tPdtBrandCodeFrom'])) && (isset($aDataFilter['tPdtBrandCodeTo']) && !empty($aDataFilter['tPdtBrandCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBrandFrom'] . ' : </span>' . $aDataFilter['tPdtBrandNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBrandTo'] . ' : </span>' . $aDataFilter['tPdtBrandNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>


            <!-- ============================ ฟิวเตอร์ข้อมูล รุ่น ============================ -->

                <?php if ((isset($aDataFilter['tPdtModelCodeFrom']) && !empty($aDataFilter['tPdtModelCodeFrom'])) && (isset($aDataFilter['tPdtModelCodeTo']) && !empty($aDataFilter['tPdtModelCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptModelFrom'] . ' : </span>' . $aDataFilter['tPdtModelNameFrom']; ?></label>
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptModelTo'] . ' : </span>' . $aDataFilter['tPdtModelNameTo']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล สถานะเคลื่อนไหว ============================ -->

                    <?php if ((isset($aDataFilter['tPdtStaActive']) && !empty($aDataFilter['tPdtStaActive'])) && (isset($aDataFilter['tPdtStaActive']) && !empty($aDataFilter['tPdtStaActive']))) : ?>
                      <?php $aPdtStaActive = array(
                        '1' => $aDataTextRef['tRptPdtMoving1'],
                        '2' => $aDataTextRef['tRptPdtMoving2']
                      ); ?>
                        <div class="xCNRptFilterBox">
                            <div class="text-left xCNRptFilter">
                                <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTitlePdtMoving'] . ' : </span>' . $aPdtStaActive[$aDataFilter['tPdtStaActive']]; ?></label>
                            </div>
                        </div>
                    <?php endif; ?>

                    <!-- ============================ ฟิวเตอร์ข้อมูล ใช้ราคาขาย ============================ -->

                        <?php if ((isset($aDataFilter['tPdtRptPdtType']) && !empty($aDataFilter['tPdtRptPdtType'])) && (isset($aDataFilter['tPdtRptPdtType']) && !empty($aDataFilter['tPdtRptPdtType']))) : ?>
                          <?php $aPdtRptPdtType = array(
                            '1' => $aDataTextRef['tRptPdtType1'],
                            '2' => $aDataTextRef['tRptPdtType2'],
                            '3' => $aDataTextRef['tRptPdtType3'],
                            '4' => $aDataTextRef['tRptPdtType4'],
                            '6' => $aDataTextRef['tRptPdtType6']
                          ); ?>
                            <div class="xCNRptFilterBox">
                                <div class="text-left xCNRptFilter">
                                    <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tPdtSaleType'] . ' : </span>' . $aPdtRptPdtType[$aDataFilter['tPdtRptPdtType']]; ?></label>
                                </div>
                            </div>
                        <?php endif; ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล ภาษี ============================ -->

                      <?php if ((isset($aDataFilter['tPdtRptStaVat']) && !empty($aDataFilter['tPdtRptStaVat'])) && (isset($aDataFilter['tPdtRptStaVat']) && !empty($aDataFilter['tPdtRptStaVat']))) : ?>
                        <?php $aPdtRptStaVat = array(
                          '1' => $aDataTextRef['tRptStaVa1'],
                          '2' => $aDataTextRef['tRptStaVa2']
                        ); ?>
                        <div class="xCNRptFilterBox">
                          <div class="text-left xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptStaVat'] . ' : </span>' . $aPdtRptStaVat[$aDataFilter['tPdtRptStaVat']]; ?></label>
                          </div>
                         </div>
                    <?php endif; ?>






        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if($aDataReport["aPagination"]["nTotalPage"] > 0):?>
                            <label class="xCNRptLabel"><?php echo $aDataReport["aPagination"]["nDisplayPage"].' / '.$aDataReport["aPagination"]["nTotalPage"]; ?></label>
                        <?php endif;?>
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
