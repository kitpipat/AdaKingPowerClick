<?php
$aDataReport        = $aDataViewRpt['aDataReport'];
$aDataTextRef       = $aDataViewRpt['aDataTextRef'];
$aDataFilter        = $aDataViewRpt['aDataFilter'];
$nOptDecimalShow    = $aDataViewRpt['nOptDecimalShow'];
$nPageNo            = $aDataReport["aPagination"]["nDisplayPage"];
$nTotalPage         = $aDataReport["aPagination"]["nTotalPage"];
?>
<style>

    .table>tbody>tr>td.xCNRptGrouPing {
        font-family: THSarabunNew-Bold;
        color: #232C3D !important;
        font-size: 20px !important;
        font-weight: 900;
    }

    .xCNFooterRpt {
        border-bottom : 7px double #ddd;
    }

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
    }

    .table>tbody>tr:last-child.xCNTrSubFooter{
        border-bottom : 1px dashed #333 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px dashed #333 !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 1px solid black !important;
    }
    .xWConditionOther{
        font-family: 'THSarabunNew-Bold';
        color: #232C3D !important;
        font-size: 20px !important;
        font-weight: 900;
    }
    /*แนวนอน*/
    /*@media print{@page {size: landscape}}*/
    /*แนวตั้ง*/
    @media print{
        @page {
            size: A4 portrait;
            /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
        }
    }
</style>

<div id="odvRptTaxSaleLockerHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?></label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?></label> <label><?=$aDataFilter['tBchNameTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ;?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptDateFrom'] . ' ' . date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                    &nbsp;&nbsp;
                                    <label class="xCNRptFilter"><?php echo $aDataTextRef['tRptDateTo'] . ' ' . date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4"></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class=" xCNRptDataPrint"><?php echo $aDataTextRef['tDatePrint'] . ' ' . date('d/m/Y') . ' ' . $aDataTextRef['tTimePrint'] . ' ' . date('H:i:s'); ?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>

                      <tr>
                          <th nowrap class="text-center xCNRptColumnHeader" style="width:5%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSno']; ?></th>
                          <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSDate']; ?></th>
                          <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSBill']; ?></th>
                          <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSRefDoc']; ?></th>
                          <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSCus']; ?></th>
                          <th nowrap class="text-center xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSRemark']; ?></th>
                          <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSValues']; ?></th>
                          <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSVat']; ?></th>
                          <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSUnVat']; ?></th>
                          <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSRnd']; ?></th>
                          <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;border-bottom: 0px !important;"><?php echo $aDataTextRef['tRptPSSSum']; ?></th>
                      </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php  $aNewData = array();  ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) {
                              // print_r($aDataReport['aRptData'][$nKey]);
                              // echo "<hr />";
                               if (isset($aNewData[$aValue['FTPosCode']])) {
                                  if (isset($aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']])) {
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                                      'FTCstCode' => $aValue['FTCstCode'],
                                      'FTXshRmk' => $aValue['FTXshRmk'],
                                      'FCXshVatable' => $aValue['FCXshVatable'],
                                      'FCXshVat' => $aValue['FCXshVat'],
                                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                                      'FCXshRnd' => $aValue['FCXshRnd'],
                                      'FCXshGrand' => $aValue['FCXshGrand']
                                    );
                                  }else {
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'] = array();
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                                      'FTCstCode' => $aValue['FTCstCode'],
                                      'FTXshRmk' => $aValue['FTXshRmk'],
                                      'FCXshVatable' => $aValue['FCXshVatable'],
                                      'FCXshVat' => $aValue['FCXshVat'],
                                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                                      'FCXshRnd' => $aValue['FCXshRnd'],
                                      'FCXshGrand' => $aValue['FCXshGrand']
                                    );
                                  }
                               }else {
                                  $aNewData[$aValue['FTPosCode']] = array();
                                  if (isset($aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']])) {
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                                      'FTCstCode' => $aValue['FTCstCode'],
                                      'FTXshRmk' => $aValue['FTXshRmk'],
                                      'FCXshVatable' => $aValue['FCXshVatable'],
                                      'FCXshVat' => $aValue['FCXshVat'],
                                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                                      'FCXshRnd' => $aValue['FCXshRnd'],
                                      'FCXshGrand' => $aValue['FCXshGrand']
                                    );
                                  }else {
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'] = array();
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['Name'] = $aValue['FTChnName'];
                                    $aNewData[$aValue['FTPosCode']][$aValue['FTChnCode']]['aValues'][] = array(
                                      'FDXshDocDate' => $aValue['FDXshDocDate'],
                                      'FTXshDocNo' => $aValue['FTXshDocNo'],
                                      'FTXshRefInt' => $aValue['FTXshRefInt'],
                                      'FTCstCode' => $aValue['FTCstCode'],
                                      'FTXshRmk' => $aValue['FTXshRmk'],
                                      'FCXshVatable' => $aValue['FCXshVatable'],
                                      'FCXshVat' => $aValue['FCXshVat'],
                                      'FCXshAmtNV' => $aValue['FCXshAmtNV'],
                                      'FCXshRnd' => $aValue['FCXshRnd'],
                                      'FCXshGrand' => $aValue['FCXshGrand']
                                    );
                                  }
                               }

                            }

                            foreach ($aNewData as $tKey => $aValue) {
                               ?>
                              <tr>
                                <th nowrap class="text-left xCNRptDetail" colspan="2"><?php echo "เครื่องจุดขาย : ".$tKey; ?></th>
                                <th nowrap class="text-left xCNRptDetail" colspan="9"></th>
                              </tr>
                              <?php foreach ($aNewData[$tKey] as $tTkey => $value) { ?>
                                <tr>
                                  <th nowrap class="text-left xCNRptDetail" ></th>
                                  <th nowrap class="text-left xCNRptDetail" ><?php echo "ช่องทางการขาย : ".$tTkey." ".$aNewData[$tKey][$tTkey]['Name']; ?></th>
                                  <th nowrap class="text-left xCNRptDetail" colspan="9"></th>
                                </tr>
                                <?php $nRow = 1;  ?>
                                <?php foreach ($aNewData[$tKey][$tTkey]['aValues'] as $nkeys => $tValues) {
                                  $tDocDate  = substr($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FDXshDocDate'],0,10);
                                  ?>
                                  <tr>
                                    <td nowrap class="text-center xCNRptDetail" ><?php echo $nRow++; ?></td>
                                    <td nowrap class="text-left xCNRptDetail" ><?php echo $tDocDate; ?></td>
                                    <td nowrap class="text-left xCNRptDetail" ><?php echo $aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTXshDocNo']; ?></td>
                                    <td nowrap class="text-left xCNRptDetail" ><?php echo $aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTXshRefInt']; ?></td>
                                    <td nowrap class="text-left xCNRptDetail" ><?php echo $aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTCstCode']; ?></td>
                                    <td nowrap class="text-left xCNRptDetail" ><?php echo $aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FTXshRmk']; ?></td>
                                    <td nowrap class="text-right xCNRptDetail" ><?php echo number_format($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshVatable'],$nOptDecimalShow); ?></td>
                                    <td nowrap class="text-right xCNRptDetail" ><?php echo number_format($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshVat'],$nOptDecimalShow); ?></td>
                                    <td nowrap class="text-right xCNRptDetail" ><?php echo number_format($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshAmtNV'],$nOptDecimalShow); ?></td>
                                    <td nowrap class="text-right xCNRptDetail" ><?php echo number_format($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshRnd'],$nOptDecimalShow); ?></td>
                                    <td nowrap class="text-right xCNRptDetail" ><?php echo number_format($aNewData[$tKey][$tTkey]['aValues'][$nkeys]['FCXshGrand'],$nOptDecimalShow); ?></td>
                                  </tr>
                                <?php } ?>
                              <?php } ?>
                            <?php }   ?>
                        <?php } else { ?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptTaxSaleLockerNoData']; ?></td></tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div>
            <?php if($nPageNo == $nTotalPage): ?>
                <div class="xCNRptFilterTitle">
                    <label><u><?php echo @$aDataTextRef['tRptConditionInReport']; ?></u></label>
                </div>

                <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้า ============================ -->
                <?php if ((isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['tShpNameFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['tShpNameTo'];?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tShpCodeSelect']) && !empty($aDataFilter['tShpCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShopFrom']; ?> : </span> <?php echo ($aDataFilter['bShpStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tShpNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล จุดขาย ============================ -->
                <?php if ((isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom'].' : </span>'.$aDataFilter['tPosCodeFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTo'].' : </span>'.$aDataFilter['tPosCodeTo'];?></label>
                    </div>
                </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosFrom']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
                <?php if ((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom'].' : </span>'.$aDataFilter['tCstNameFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo'].' : </span>'.$aDataFilter['tCstNameTo'];?></label>
                        </div>
                    </div>
                <?php endif; ?>
                <?php if (isset($aDataFilter['tCstCodeSelect']) && !empty($aDataFilter['tCstCodeSelect'])) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="xCNRptFilter">
                            <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCstStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCstNameSelect']; ?></label>
                        </div>
                    </div>
                <?php endif; ?>

                <!-- ============================ ฟิวเตอร์ข้อมูล ช่องทางการขาย ============================ -->
                <?php if ((isset($aDataFilter['tChnCodeFrom']) && !empty($aDataFilter['tChnCodeFrom'])) && (isset($aDataFilter['tChnCodeTo']) && !empty($aDataFilter['tChnCodeTo']))) : ?>
                    <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptChnFrom'].' : </span>'.$aDataFilter['tChnNameFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptChnTo'].' : </span>'.$aDataFilter['tChnNameTo'];?></label>
                        </div>
                    </div>
                <?php endif; ?>

                
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
