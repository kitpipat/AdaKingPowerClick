<?php
    use \koolreport\widgets\koolphp\Table;
    $nCurrentPage    = $this->params['nCurrentPage'];
    $nAllPage        = $this->params['nAllPage'];
    $aDataTextRef    = $this->params['aDataTextRef'];
    $aDataFilter     = $this->params['aFilterReport'];
    $aDataReport     = $this->params['aDataReturn'];
    $aCompanyInfo    = $this->params['aCompanyInfo'];
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
        border-bottom: 1px solid black !important;
    }

    .table>tbody:last-child>tr:last-child>td.xCNRptSumFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody>tr.xCNTrSubFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table>tbody>tr.xCNTrFooter {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }

    .table tbody tr.xCNHeaderGroup,
    .table>tbody>tr.xCNHeaderGroup>td {
        font-size: 18px !important;
        font-weight: 600;
    }

    .table>tbody>tr.xCNHeaderGroup>td:nth-child(4),
    .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    }


    /*แนวนอน*/
    @media print{@page {size: landscape}}
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>

<div id="odvRptTopUpHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
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
                  "dataSource"        => $this->dataStore("RptUseCard2"),
                  "cssClass"          => array(
                      "table" => "table",
                  ),
                  "columns"           => array(
                      'rtBchCode'         => array(
                          "label"         => $aDataTextRef['tRPC15TBBchCode'],
                          "cssStyle"      => "text-align:left",
                      ),
                      'rtBchName'         => array(
                          "label"         => $aDataTextRef['tRPC15TBBchName'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeBchName    = explode(";",$tValue);
                              return $aExplodeBchName[1];
                          },
                      ),
                      'rtCrdCode'         => array(
                          "label"         => $aDataTextRef['tRPC15TBCardCode'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeCrdCode    = explode(";",$tValue);
                              return $aExplodeCrdCode[1];
                          },
                      ),
                      'rtCtyName'         => array(
                          "label"         => $aDataTextRef['tRPC15TBCardType'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeCtyName    = explode(";",$tValue);
                              return $aExplodeCtyName[2];
                          }
                      ),
                      'rtCrdName'         => array(
                          "label"         => $aDataTextRef['tRPC15TBCardName'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeCrdName    = explode(";",$tValue);
                              return $aExplodeCrdName[2];
                          }
                      ),
                      'rtCrdHolderID'     => array(
                          "label"         => $aDataTextRef['tRPC15TBCardHolderID'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeCrdHolderID    = explode(";",$tValue);
                              return $aExplodeCrdHolderID[2];
                          }
                      ),
                      'rtDptName'         => array(
                          "label"         => $aDataTextRef['tRPC15TBDptName'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeDptName    = explode(";",$tValue);
                              return $aExplodeDptName[2];
                          }
                      ),
                      'rdTxnDocDate'      => array(
                          "label"         => $aDataTextRef['tRPC15TBCardTxnDocDate'],
                          "cssStyle"      => "text-align:center",
                          'formatValue'   => function($tDateTime){
                            return date('Y-m-d H:i:s ',strtotime($tDateTime));
                        },
                      ),
                      'rtTxnDocTypeName'  => array(
                          "label"         => $aDataTextRef['tRPC15TBType'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeTxnDocTypeName = explode(";",$tValue);
                              if($aData['FNLngID'] == 1 ){
                                  return $aExplodeTxnDocTypeName[2];
                              }else{
                                  return $aExplodeTxnDocTypeName[3];
                              }
                          }
                      ),

                      'rtCrdStaActive'    => array(
                          "label"         => $aDataTextRef['tRPC15TBCardStaActive'],
                          "cssStyle"      => "text-align:left",
                          "formatValue"   => function($tValue){
                              $aDataTextRef   = $this->params['aDataTextRef'];
                              $aExplodeCrdStaActive = explode(';',$tValue);
                              switch($aExplodeCrdStaActive[2]){
                                  case '1':
                                      return $aDataTextRef['tRPC15CardDetailStaActive1'];
                                  break;
                                  case '2':
                                      return $aDataTextRef['tRPC15CardDetailStaActive2'];
                                  break;
                                  case '3':
                                      return $aDataTextRef['tRPC15CardDetailStaActive3'];
                                  break;
                                  default:
                                      return $aDataTextRef['tRPC15CardDetailStaActive'];
                              }
                          }
                      ),

                      'rcTxnValue'        => array(
                          "label"         => $aDataTextRef['tRPC15TBTxnValue'],
                          "cssStyle"      => "text-align:right",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeTxnValue = explode(";",$tValue);
                              return number_format($aExplodeTxnValue[2], 2);
                          }
                      ),
                      'rcCrdBalance'      => array(
                          "label"         => $aDataTextRef['tRPC15TBCrdBalance'],
                          "cssStyle"      => "text-align:right",
                          "formatValue"   => function($tValue,$aData){
                              $aExplodeCrdBalance = explode(";",$tValue);
                              if(!empty($aExplodeCrdBalance)){
                                if($aExplodeCrdBalance[2] != ''){
                                    return number_format($aExplodeCrdBalance[2], 2);
                                }else{
                                    return number_format(0, 2);
                                }

                              }else{
                                return number_format(0, 2);
                              }

                          }
                      )
                  ),
                  "removeDuplicate"   =>  array("rtBchCode","rtBchName","rtCrdCode","rtCtyName","rtCrdHolderID","rtCrdName","rtDptName","rtCrdStaActive","rcCrdBalance")
              ));

                    ?>
                <?php } else {?>
                    <table class="table">
                        <thead>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBBchCode']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBBchName']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCardCode']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCardType']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCardName']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCardHolderID']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBDptName']; ?></th>
                            <th nowrap class="text-center" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCardTxnDocDate']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBType']; ?></th>
                            <th nowrap class="text-left" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCardStaActive']; ?></th>
                            <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPC15TBTxnValue']; ?></th>
                            <th nowrap class="text-right" style="width:10%"><?php echo $aDataTextRef['tRPC15TBCrdBalance']; ?></th>
                        </thead>
                        <tbody>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('report/report/report', 'tCMNNotFoundData'); ?></td>
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
