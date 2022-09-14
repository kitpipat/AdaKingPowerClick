<?php
    $aCompanyInfo = $aDataViewRpt['aCompanyInfo'];
    $aDataFilter = $aDataViewRpt['aDataFilter'];
    $aDataTextRef = $aDataViewRpt['aDataTextRef'];
    $aDataReport = $aDataViewRpt['aDataReport'];
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
        border-top: 1px solid black !important;
        /*background-color: #CFE2F3 !important;*/
        border-bottom : 1px solid black !important;
    }
    /* table {
        table-layout: fixed;
     }
    table td {
        word-wrap: break-word;
     } */
    /* .test {
    width: 11em; 
    border: 1px solid #000000;
    word-wrap: break-word;
    } */

    /*แนวนอน*/
    /*@media print{@page {size: landscape}}*/ 
    /*แนวตั้ง*/
    @media print{
        @page {
        size: A4 landscape;
        /* margin: 1.5mm 1.5mm 1.5mm 1.5mm; */
       
        }
        table {
        table-layout: fixed;
          }
        table td {
            word-wrap: break-word;
        } 
        }
    
    /* @media print
{
    table.table     { page-break-after: auto; }
    table.table   tr    { page-break-inside:avoid;page-break-after: auto; }
    table.table   td    { page-break-inside:avoid; page-break-after:auto }
    table.table   thead { display:table-header-group }
    table.table   tfoot { display:table-footer-group }
} */


</style>

<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">

        <div class="xCNHeaderReport">
         
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?> <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?></label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?></label>
                            <label><?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosTaxId'] . $aCompanyInfo['FTAddTaxNo']?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

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
            <div id="odvRptTableAdvance" class="table-responsive">
            <table class="table" width="100%">
                    <thead>
                        <tr>
                            
                            <th  class="text-center xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptSalNotPassDocNo']; ?></th>
                            <th  class="text-center xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptSalNotPassDocDate']; ?></th>
                            <th  class="text-center xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptSalNotPassDateApp']; ?></th>
                            <th  class="text-center xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptSalNotPassAppName']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassCstCode']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassCardID']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:12%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassCstName']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassTel']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:8%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassPdtCode']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassPdtBarCode']; ?></th>
                            <th  class="text-center xCNRptColumnHeader"style="width:8%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassPdtName']; ?></th>
                            <th  class="text-right xCNRptColumnHeader"style="width:6%;vertical-align: middle;"><?php echo $aDataTextRef['tRptSalNotPassQty']; ?></th>
                            <th  class="text-left xCNRptColumnHeader" style="width:6%;vertical-align: middle;  "><?php echo $aDataTextRef['tRptSalNotPassUnit']; ?></th>
                            <th  class="text-center xCNRptColumnHeader" style="width:6%;vertical-align: middle;  "><?php echo $aDataTextRef['tRptSalNotPassRmk']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                     if(!empty($aDataReport['aRptData'])){
                         foreach($aDataReport['aRptData'] as $aData){

                            $cXrcNet_Footer = $aData['FCXsdQty_Footer'];
                  
                    ?>
                        <tr>
                            <td  class="text-left xCNRptDetail" style="width:6%;"><?php echo $aData['FTXshDocNo']; ?></td>
                            <td  class="text-center xCNRptDetail" style="width:6%; "><?php echo date('d/m/Y',strtotime($aData['FDXshDocDate'])); ?></td>
                            <td  class="text-center xCNRptDetail" style="width:6%; "><?php echo date('d/m/Y',strtotime($aData['FDDateApp'])); ?></td>
                            <td  class="text-left xCNRptDetail" style="width:6%; "><?php echo $aData['FTAppName']; ?></td>
                            <td  class="text-left xCNRptDetail" style="width:6%; "><?php echo $aData['FTCstCode']; ?></td>
                            <td  class="text-left xCNRptDetail" style="width:6%; "><?php echo $aData['FTXshCardID']; ?></td>
                            <td  class="text-left xCNRptDetail" style="width:12%; "><?php echo $aData['FTXshCstName']; ?></td>
                            <td  class="text-right xCNRptDetail" style="width:6%; "><?php echo $aData['FTXshCstTel']; ?></td>
                            <td  class="text-right xCNRptDetail"style="width:6%;"><?php echo $aData['FTPdtCode']; ?></td>
                            <td  class="text-right xCNRptDetail "style="width:6%;"><?php echo $aData['FTXsdBarCode'];?></td>
                            <td  class="text-left xCNRptDetail"style="width:8%;"><?php echo $aData['FTPdtName']; ?></td>
                            <td  class="text-right xCNRptDetail"style="width:6%;"><?php echo number_format($aData['FCXsdQty'],2); ?></td>
                            <td  class="text-left xCNRptDetail"style="width:6%;"><?php echo $aData['FTUnitName']; ?></td>
                            <td  class="text-left xCNRptDetail"style="width:6%;"><?php echo $aData['FTXsdRmk'];?></td>
                        </tr>
                    <?php
                            }
                            ?>

                            <?php  
                            
                            $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                            $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                            if ($nPageNo == $nTotalPage) {
                            ?>
    
                        <tr  class="xCNTrFooter">
                            <td  colspan="11"  class="text-left xCNRptSumFooter"   ><?php echo $aDataTextRef['tRptTotalFooter']; ?></td>
        
                            <td    class="text-right xCNRptSumFooter"   ><?php echo number_format($cXrcNet_Footer,2); ?></td>
                            <td  colspan="2"  class="text-left xCNRptSumFooter"   ></td>
                        </tr>
                        
                    <?php 
                            } 
                    ?>
                     <?php   }else{ 
                            ?>
                        <tr>
                            <td  colspan="12"  class="text-center xCNRptColumnFooter"   ><?php echo $aDataTextRef['tRptNoData']; ?></td>
                        </tr>
                    <?php   
                    }
                    ?>
                    </tbody>
                </table>
            </div>

            <div class="xCNRptFilterTitle">
                <div class="text-left">
                    <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                </div>
            </div>

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['tMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['tMerNameTo'];?></label>
                    </div>
                </div>
            <?php endif; ?>  
            <?php if (isset($aDataFilter['tMerCodeSelect']) && !empty($aDataFilter['tMerCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom']; ?> : </span> <?php echo ($aDataFilter['bMerStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tMerNameSelect']; ?></label>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทการชำระ ============================ -->
            <?php if ((isset($aDataFilter['tRcvCodeFrom']) && !empty($aDataFilter['tRcvCodeFrom'])) && (isset($aDataFilter['tRcvCodeTo']) && !empty($aDataFilter['tRcvCodeTo']))): ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvFrom'].' : </span>'.$aDataFilter['tRcvNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptRcvTo'].' : </span>'. $aDataFilter['tRcvNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
            
            <!-- ============================ ฟิวเตอร์ข้อมูล เครืองจุดขาย ============================ -->
            <?php if ((isset($aDataFilter['nPosType']) && !empty($aDataFilter['nPosType']))){ ?>
                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['nPosType']] ?></label>
                    </div>
                </div> -->
            <?php }else{ ?>
                <!-- <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['nPosType']] ?></label>
                    </div>
                </div> -->
            <?php } ?>
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













