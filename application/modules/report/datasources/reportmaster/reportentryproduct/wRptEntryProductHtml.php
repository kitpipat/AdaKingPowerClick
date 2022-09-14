<?php
    $aDataReport = $aDataViewRpt['aDataReport'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $nOptDecimalShow = FCNxHGetOptionDecimalShow();
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

    .xWRptProductFillData>td:first-child {
        text-indent: 40px;
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
                <table class="table">
                    <thead>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:5%;"><?php echo $aDataTextRef['tPdtnu'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPdtCode'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:15%;"><?php echo $aDataTextRef['tPdtName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPgpChainName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPtyName'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPdtSaleType'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tBarCode'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPunCode'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPunName'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPdtUnitFact'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPdtPriceRET'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPdtCostInPerUnit'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPdtCostInTotal'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tPgdPriceRetTotal'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) {

                              $aFTPdtSaleType = array(
                                '1' => $aDataTextRef['tRptPdtType1'],
                                '2' => $aDataTextRef['tRptPdtType2'],
                                '3' => $aDataTextRef['tRptPdtType3'],
                                '4' => $aDataTextRef['tRptPdtType4'],
                                '6' => $aDataTextRef['tRptPdtType6']
                              );

                              ?>
                                <tr>
                                  <td class="xCNRptDetail"><?php echo $aValue['FNRowPartID']; ?></td>
                                  <td class="xCNRptDetail"><?php echo $aValue["FTPdtCode"]; ?></td>
                                  <td class="xCNRptDetail"><?php echo $aValue["FTPdtName"]; ?></td>
                                  <td class="xCNRptDetail"><?php if($aValue["FTPgpChainName"]==""){ echo "-"; }else{echo $aValue["FTPgpChainName"]; } ?></td>
                                  <td class="xCNRptDetail"><?php if($aValue["FTPtyName"]==""){ echo "-"; }else{ echo $aValue["FTPtyName"]; } ?></td>
                                  <td class="xCNRptDetail"><?php echo $aFTPdtSaleType[$aValue["FTPdtSaleType"]];1 ?></td>
                                  <td class="xCNRptDetail"><?php echo $aValue["FTBarCode"]; ?></td>
                                  <td class="xCNRptDetail"><?php echo $aValue["FTPunCode"]; ?></td>
                                  <td class="xCNRptDetail"><?php if($aValue["FTPunName"]==""){ echo "-"; }else{  echo $aValue["FTPunName"]; } ?></td>
                                  <td class="xCNRptDetail text-right"><?php echo number_format($aValue["FCPdtUnitFact"],0); ?></td>
                                  <td class="xCNRptDetail text-right"><?php echo number_format($aValue["FCPdtPriceRET"],$nOptDecimalShow); ?></td>
                                  <td class="xCNRptDetail text-right"><?php echo number_format($aValue["FCPdtCostInPerUnit"],$nOptDecimalShow); ?></td>
                                  <td class="xCNRptDetail text-right"><?php echo number_format($aValue["FCPdtCostInTotal"],$nOptDecimalShow); ?></td>
                                  <td class="xCNRptDetail text-right"><?php echo number_format($aValue["FCPgdPriceRetTotal"],$nOptDecimalShow); ?></td>
                                </tr>
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
