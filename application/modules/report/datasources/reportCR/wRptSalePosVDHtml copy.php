<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
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
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        /* background-color: #CFE2F3 !important; */
    }

    .table>tbody>tr.xCNTrFooter{
        /* border-top: 1px solid black !important; */
        border-top: dashed 1px #333 !important;
        border-bottom : 1px solid black !important;
        
        /* border-bottom : 6px double black !important; */
        /* background-color: #CFE2F3 !important; */
    }

    /* .table tbody tr.xCNHeaderGroup, .table>tbody>tr.xCNHeaderGroup>td {
        font-family: THSarabunNew;
        color: #232C3D !important;
        font-size: 18px !important;
        font-weight: 600;
    } */
    /* .table>tbody>tr.xCNHeaderGroup>td:nth-child(4), .table>tbody>tr.xCNHeaderGroup>td:nth-child(5) {
        text-align: right;
    } */

    /*แนวนอน*/
    @media print{@page {size: landscape;
        margin: 1.5mm 1.5mm 1.5mm 1.5mm;
    }} 
    

    /*แนวตั้ง*/
    /* @media print{@page {size: portrait}} */

</style>

<div id="odvRptTaxSalePosHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if(isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>
                    
                        <div class="text-left">
                            <label class="xCNRptCompany"><?=$aCompanyInfo['FTCmpName']?></label>
                        </div>

                        <?php if($aCompanyInfo['FTAddVersion'] == '1'){ // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label ><?=$aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi']?>
                                <?=$aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>

                        <?php if($aCompanyInfo['FTAddVersion'] == '2'){ // ที่อยู่แบบรวม ?>
                            <div class="text-left xCNRptAddress">
                                <label><?=$aCompanyInfo['FTAddV2Desc1']?></label>
                            </div>
                            <div class="text-left xCNRptAddress">
                                <label><?=$aCompanyInfo['FTAddV2Desc2']?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosTel'] . $aCompanyInfo['FTCmpTel']?> <?=$aDataTextRef['tRptTaxSalePosFax'] . $aCompanyInfo['FTCmpFax']?></label>
                        </div>
                        <!-- <div class="text-left xCNRptAddress">
                            <label><?=$aDataTextRef['tRptTaxSalePosBch'] . $aCompanyInfo['FTBchName']?></label>
                        </div>
                     -->
                      

                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">

                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalePosFilterDocDateFrom']?></label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?>  </label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalePosFilterDocDateTo']?></label>     <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?>    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
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
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:10%;"><?php echo $aDataTextRef['tRptCrPos'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:15%;"><?php echo $aDataTextRef['tRptCrTaxNumber'];?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader"  style="width:15%;"><?php echo $aDataTextRef['tRptCrSaleDate'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:8%;"><?php echo $aDataTextRef['tRptCrPaymentType'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrProduct'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrNet'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrPrice'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrVat'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrTotal'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrDescription'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrHnNumber'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrCtzID'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrCstName'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrCstlName'];?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef['tRptCrCstTel'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo $aDataTextRef[''];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>  
                            <?php 
                            // $paFooterSumData1 = 0;
                            // $paFooterSumData2 = 0;
                            // $paFooterSumData3 = 0;
                            // $nSeq = 1;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) { ?>
                                
                               
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="text-left xCNRptColumnHeader"><?php echo $aValue['FTPosCode']; ?></td>
                                    <td nowrap class="text-left xCNRptColumnHeader"><?php echo $aValue["FTXshDocNo"]; ?></td>
                                    <td nowrap class="text-left xCNRptColumnHeader"><?php echo $aValue["FDXshDocDate"]; ?></td>
                                    <td nowrap class="text-left xCNRptColumnHeader"><?php echo $aValue["FTFmtName"]; ?></td>
                                    <td nowrap class="text-left xCNRptColumnHeader"><?php echo $aValue["FTPdtName"]; ?></td>
                                    
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo number_format($aValue["FCXrcNet"],2)?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo number_format($aValue["FCXsdVatable"],2)?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo number_format($aValue["FCXshVat"],2)?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo number_format($aValue["FCXsdNetAfHD"],2)?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FTSalRmk"];?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FNCstID"];?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FTCstCardID"];?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FTCstName"];?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FTCstLastName"];?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FTCstTel"];?></td>
                                    <td nowrap class="text-right xCNRptColumnHeader"><?php echo $aValue["FTSalRmkBill"];?></td>
                                    
                                    
                                    
                                </tr>
                              
                            <?php } ?>
                           
                        <?php } ;?>
                    </tbody>
                </table>
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
 
            <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-left">
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTaxSalePosFilterDocDateFrom'].' '.$aDataFilter['tDocDateFrom'];?></label>
                                    <label class="xCNRptLabel"><?php echo $aDataTextRef['tRptTaxSalePosFilterDocDateTo'].' '.$aDataFilter['tDocDateTo'];?></label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>
            <!-- ============================ ฟิวเตอร์ข้อมูล tRptPosType ============================
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['aDataFilter']['tPosType']]; ?></label>
                </div>
            </div>
                

          -->

                    <!-- ============================ ฟิวเตอร์ข้อมูล ประเภทจุดขาย ============================ -->
                    <?php if(isset($aDataFilter['tPosType'])){ ?>

<div class="xCNRptFilterBox">
    <div class="text-left xCNRptFilter">
        <label class="xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']];?></label>
    </div>
</div>

<?php } ?>
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