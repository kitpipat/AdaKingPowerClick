<?php

    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];


    //Step 6 : สั่ง Summary Footer
    $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];

    $bIsLastPage = ($nPageNo == $nTotalPage);

   
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
    .table>thead:first-child>tr:first-child>th:nth-child(3),
    .table>thead:first-child>tr:first-child>td:nth-child(4),
    .table>thead:first-child>tr:first-child>th:nth-child(4),
    .table>thead:first-child>tr:first-child>td:nth-child(5),
    .table>thead:first-child>tr:first-child>th:nth-child(5),
    .table>thead:first-child>tr:first-child>th:nth-child(6),
    .table>thead:first-child>tr:first-child>th:nth-child(7)
     
     {
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
    /* @media print{@page {size: landscape}} */
    /*แนวตั้ง*/
    @media print {
        @page {
            size: portrait
        }
    }
</style>


<div id="odvRptSaleOrderHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)) { ?>

                        <div class="text-left">
                            <label class="xCNRptCompany"><?= $aCompanyInfo['FTCmpName'] ?></label>
                        </div>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก  
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label>
                                    <?= $aCompanyInfo['FTAddV1No'] . ' ' . $aCompanyInfo['FTAddV1Village'] . ' ' . $aCompanyInfo['FTAddV1Road'] . ' ' . $aCompanyInfo['FTAddV1Soi'] ?>
                                    <?= $aCompanyInfo['FTSudName'] . ' ' . $aCompanyInfo['FTDstName'] . ' ' . $aCompanyInfo['FTPvnName'] . ' ' . $aCompanyInfo['FTAddV1PostCode'] ?>
                                </label>
                            </div>
                        <?php } ?>

                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม  
                                ?>
                            <div class="text-left xCNRptAddress">
                                <label><?= $aCompanyInfo['FTAddV2Desc1'] ?><?= $aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrTel'] . $aCompanyInfo['FTCmpTel'] ?> <?= $aDataTextRef['tRptAddrFax'] . $aCompanyInfo['FTCmpFax'] ?></label>
                        </div>
                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptAddrBranch'] . $aCompanyInfo['FTBchName'] ?></label>
                        </div>

                        <div class="text-left xCNRptAddress">
                            <label><?= $aDataTextRef['tRptTaxSalePosTaxId'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>
                    <?php } ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                    </div>
                    <div class="report-filter">
                        <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateFrom'])); ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo']; ?> : </span> <?php echo date('d/m/Y',strtotime($aDataFilter['tDocDateTo'])); ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                            <div class="row">
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="text-center xCNRptFilter">
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo $aDataFilter['tBchNameFrom']; ?></label>
                                        <label><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']; ?> : </span> <?php echo $aDataFilter['tBchNameTo']; ?></label>
                                    </div>
                                </div>
                            </div>
                        <?php }; ?>
                    </div>
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
                <table class="table">
                    <thead>
                        <tr>
                            <th class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptHNDocNo']; ?></th>
                            <th class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptHNDocDate']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1" width="13%"><?php echo $aDataTextRef['tRptHNCstCode']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1" width="13%"><?php echo $aDataTextRef['tRptHNCardID']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1" width="13%"><?php echo $aDataTextRef['tRptHNName']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1" width="13%"><?php echo $aDataTextRef['tRptHNPricePerUnit']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1" width="10%"><?php echo $aDataTextRef['tRptHNTel']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="2" width="30%"></th>
                        </tr>
                        <tr>
                            <th class="text-left xCNRptColumnHeader">&nbsp;&nbsp;<?php echo $aDataTextRef['tRptHNPdtCode']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1">&nbsp;&nbsp;<?php echo $aDataTextRef['tRptHNPdtName']; ?></th>
                            <th class="text-left xCNRptColumnHeader">&nbsp;&nbsp;<?php echo $aDataTextRef['tRptHNBarCode']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="1">&nbsp;&nbsp;<?php echo $aDataTextRef['tRptHNUnit']; ?></th>
                            <th class="text-left xCNRptColumnHeader" colspan="2">&nbsp;&nbsp;<?php echo $aDataTextRef['tRptQty']; ?></th>
                            <th class="text-left xCNRptColumnHeader">&nbsp;&nbsp;<?php echo $aDataTextRef['tRptDisCount']; ?></th>
                            <th class="text-right xCNRptColumnHeader text-right"><?php echo $aDataTextRef['tRptHNQty']; ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php foreach ($aDataReport['aRptData'] AS $nKey => $aValue) {  ?>
                                <?php 
                                        //Step 1 เตรียม Parameter สำหรับการ Groupping
                                        $tRptFTXshDocNo       = $aValue["FTXshDocNo"];  //เลขที่เอกสาร
                                        $tRptFDXsxDocDate     = date('Y-m-d',strtotime($aValue["FDXshDocDate"]));  //วันที่เอกสาร
                                        $tRptFTCstCode        = $aValue["FTCstCode"]; //รหัสผู้ป่วย
                                        $tRptFTXshCardID      = $aValue["FTXshCardID"]; //บัตรประชาชน
                                        $tRptFTXshCtrName     = $aValue["FTXshCstName"]; //ชื่อผู้ป่วย
                                        $tRptFTXsxCstTel      = $aValue["FTXshCstTel"]; //เบอร์โทร
                                        $tRptFCXshTotal       = $aValue["FCXshTotal"]; 
                                        
                                       
                                        $tRptFTPdtCode        = $aValue["FTPdtCode"]; //รหัสสินค้า
                                        $tRptFTXsdBarCode     = $aValue["FTXsdBarCode"]; //บาร์โค๊ด
                                        $tRptFTPdtName        = $aValue["FTPdtName"]; //ชื่อสินค้า
                                        $tRptFTUnitName       = $aValue["FTUnitName"]; //หน่วย
                                        $tRptFCXsdQty         = $aValue["FCXsdQty"]; //จำนวน
                                        $tRptFCXsdSetPrice    = number_format($aValue["FCXsdSetPrice"],2); //ราคา/หน่วย
                                        $tRptFCXsdDiscount    = number_format($aValue["FCXsdDiscount"],2); // ส่วนลด
                                        $tRptFCXsdNet         = number_format($aValue["FCXsdNet"],2); //จำนวนเงิน

                                        $nGroupMember         = $aValue["FNRptGroupMember"];
                                        $nRowPartID           = $aValue["FNRowPartID"];

                                        $tRptFCXsdQty_SubTotal       = number_format($aValue["FCXsdQty_SubTotal"],2);
                                        $tRptFCXsdDiscount_SubTotal  = number_format($aValue["FCXsdDiscount_SubTotal"],2);
                                        $tRptFCXsdNet_SubTotal       = number_format($aValue["FCXsdNet_SubTotal"],2);
                              
                                    ?>

                                    <!--  Step 2 แสดงข้อมูลใน TD  -->
                                    <?php  if ($nRowPartID == 1) { ?>
                                        <tr>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTXshDocNo; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFDXsxDocDate; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTCstCode; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTXshCardID; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTXshCtrName; ?></td>
                                            <td class="xCNRptGrouPing"></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTXsxCstTel;?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php if(@$tDataDoc == @$tDataDoc && @$tPdtCode == @$tPdtCode) { ?>
                                        <tr>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTPdtCode; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTPdtName; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTXsdBarCode; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFTUnitName; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFCXsdQty; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFCXsdSetPrice; ?></td>
                                            <td class="xCNRptGrouPing"><?php echo $tRptFCXsdDiscount;?></td>
                                            <td class="xCNRptGrouPing text-right"><?php echo $tRptFCXsdNet;?></td>
                                        </tr>
                                    <?php } ?>

                                    <?php 
                                        $tRptFCXsdQty_SubTotal       = number_format($aValue["FCXsdQty_SubTotal"],2);
                                        $tRptFCXsdDiscount_SubTotal  = number_format($aValue["FCXsdDiscount_SubTotal"],2);
                                        $tRptFCXsdNet_SubTotal       = number_format($aValue["FCXsdNet_SubTotal"],2);

                                        $tFCXshDiscount_Footer       = number_format($aValue["FCXshDiscount_Footer"],2);
                                        $FCXshDiscount_Footer        = number_format($aValue["FCXshDiscount_Footer"],2);
                                        $FCXhdVatable_Footer         = number_format($aValue["FCXhdVatable_Footer"],2);
                                        $FCXshVat_Footer             = number_format($aValue["FCXshVat_Footer"],2);
                                        $FCXshAmtNV_Footer           = number_format($aValue["FCXshAmtNV_Footer"],2);
                                        $FCXshGrand_Footer           = number_format($aValue["FCXshGrand_Footer"],2);

                                        $aSumFooter    = array('N','N','N',$tRptFCXsdQty_SubTotal,'N',$tRptFCXsdDiscount_SubTotal);


                                    
                                        if($nRowPartID == $nGroupMember) { 
                                            echo '<tr>';
                                            for($i = 0;$i<FCNnHSizeOf($aSumFooter);$i++){
                                                if($aSumFooter[$i] !='N'){
                                                    $tFooterVal =   $aSumFooter[$i];           
                                                }else{
                                                    $tFooterVal =   '';
                                                }
        
                                                if(intval($i) == 0){
                                                    $tClassCss = "text-left";
                                                }else{
                                                    $tClassCss = "text-left";
                                                }
    
                                                if(intval($i) == 0){
                                                    $nColspan = "colspan=2";
                                                }else{
                                                    $nColspan = "colspan=0";
                                                }
                                                echo "<td class='xCNRptGrouPing $tClassCss' $nColspan >".$tFooterVal."</td>";
                                            }
                                                echo "<td class='xCNRptGrouPing text-right' $nColspan >".$tRptFCXsdNet_SubTotal."</td>";
                                            echo "</tr>";

                                            $nFCXhdVatable     = number_format($aValue["FCXhdVatable"],2); //มูลค่าก่อนคิดภาษี
                                            $nFCXshDiscount    = number_format($aValue["FCXshDiscount"],2); //ลดท้ายบิล  
                                           
                                            $aSumFooter         = array('N','N','N','N',$aDataTextRef['tRPtHNDisCount'],$nFCXshDiscount);
                                            $aSumFooter1        = array($aDataTextRef['tRptVatTable']);

                                            echo '<tr>';
                                                for($i = 0;$i<FCNnHSizeOf($aSumFooter);$i++){
                                                    if($aSumFooter[$i] !='N'){
                                                        $tFooterVal =   $aSumFooter[$i];           
                                                    }else{
                                                        $tFooterVal =   '';
                                                    }
            
                                                    echo "<td class='xCNRptGrouPing text-left'>".$tFooterVal."</td>";
                                                }
                                                for($i = 0;$i<FCNnHSizeOf($aSumFooter1);$i++){
                                                    if($aSumFooter1[$i] !='N'){
                                                        $tFooterVal1 =   $aSumFooter1[$i];           
                                                    }else{
                                                        $tFooterVal1 =   '';
                                                    }
                                                    echo "<td class='xCNRptGrouPing text-left'>".$tFooterVal1."</td>";
                                                }
                                                echo "<td class='xCNRptGrouPing text-right' colspan='5'>".$nFCXhdVatable."</td>";
                                            echo "</tr>";


                                            $nFCXshVat         = number_format($aValue["FCXshVat"],2);  //ภาษีมูลค่าเพิ่ม
                                            $nFCXshAmtNV       = number_format($aValue["FCXshAmtNV"],2); //ยกเว้นภาษี

                                            $aSumFooterVat    = array('N','N','N','N',$aDataTextRef['tRptVat'],$nFCXshVat);
                                            $aSumFooterAmtNV  = array($aDataTextRef['tRptExceptTax']);

                                            echo '<tr>';
                                                for ($i=0;$i<FCNnHSizeOf($aSumFooterVat);$i++){
                                                    if($aSumFooterVat[$i] !='N'){
                                                        $tFooterVat =   $aSumFooterVat[$i];           
                                                    }else{
                                                        $tFooterVat = '';
                                                    }
                                                    echo "<td class='xCNRptGrouPing text-left'>".$tFooterVat."</td>";
                                                }

                                                for($i = 0;$i<FCNnHSizeOf($aSumFooterAmtNV);$i++){
                                                    if($aSumFooterAmtNV[$i] !='N'){
                                                        $tFooterValAmtNV =   $aSumFooterAmtNV[$i];           
                                                    }else{
                                                        $tFooterValAmtNV =   '';
                                                    }
                                                    echo "<td class='xCNRptGrouPing text-left'>".$tFooterValAmtNV."</td>";
                                                }
                                                echo "<td class='xCNRptGrouPing text-right' colspan='5'>".$nFCXshAmtNV."</td>";
                                            echo '</tr>';

                                            $nFCXshGrand       = number_format($aValue["FCXshGrand"],2);  //จำนวนเงินรวมทั้งสิ้น
                                            $aSumFooterText    = array('N','N','N','N',$aDataTextRef['tRptGrandTotal']);

                                            echo '<tr>';
                                                for ($i=0;$i<FCNnHSizeOf($aSumFooterText);$i++){
                                                    if($aSumFooterText[$i] !='N'){
                                                        $tFooterGrand =   $aSumFooterText[$i];           
                                                    }else{
                                                        $tFooterGrand = '';
                                                    }
                                                    echo "<td class='xCNRptGrouPing text-left'>".$tFooterGrand."</td>";
                                                }
                                                echo "<td class='xCNRptGrouPing text-right' colspan='5'>".$nFCXshGrand."</td>";
                                            echo '</tr>';

                                            $nCountDataAll = FCNnHSizeOf($aDataReport['aRptData']);
                                            if($nCountDataAll - 1 != $nKey){
                                                echo "<tr><td class='xCNRptGrouPing' colspan='9' style='border-top: dashed 1px #333 !important;'></td></tr>";
                                            }
                                        }
                                    ?>



                            <?php
                                $tDataDoc = $tRptFTXshDocNo;
                                $tPdtCode = $tRptFTPdtCode;
                        } ?>

                        <!-- Sum Footer หน้าสุดท้าย -->
                        <?php if($bIsLastPage) { ?>
                            <tr class="xCNRptSumFooterTrTop">
                                <td class="xCNRptSumFooter" colspan="8"></td>
                                
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3"></td>
                                <td class="xCNRptSumFooter" colspan="1"><?php echo $aDataTextRef['tRPtHNDisCount']; ?></td>
                                <td class="text-left xCNRptSumFooter"><?php echo number_format($aValue['FCXshDiscount_Footer'], $nOptDecimalShow); ?></td>
                                <td class="xCNRptSumFooter" colspan="1"><?php echo $aDataTextRef['tRptVatTable']; ?></td>
                                <td class="text-right xCNRptSumFooter"><?php echo number_format($aValue['FCXhdVatable_Footer'], $nOptDecimalShow); ?></td>
                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3"></td>
                                <td class="xCNRptSumFooter" colspan="1"><?php echo $aDataTextRef['tRptVat']; ?></td>
                                <td class="text-left xCNRptSumFooter"><?php echo number_format($aValue['FCXshVat_Footer'], $nOptDecimalShow); ?></td>
                                <td class="xCNRptSumFooter" colspan="1"><?php echo $aDataTextRef['tRptExceptTax']; ?></td>
                                <td class="text-right xCNRptSumFooter"><?php echo number_format($aValue['FCXshAmtNV_Footer'], $nOptDecimalShow); ?></td>

                            </tr>
                            <tr>
                                <td></td>
                                <td colspan="3"></td>
                                <td class="xCNRptSumFooter" colspan="3"><?php echo $aDataTextRef['tRptGrandTotal']; ?></td>
                                <td class="text-right xCNRptSumFooter"><?php echo number_format($aValue['FCXshGrand_Footer'], $nOptDecimalShow); ?></td>
                            </tr>

                        <?php } ?>

                        <?php } else { ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData']; ?></td>
                            </tr>
                        <?php } ?>
                    </tbody>
                </table>
            </div> 

            <!-- ============================ ฟิวเตอร์ข้อมูล ============================ -->
            <?php if ((isset($aDataFilter['tWahNameFrom']) && !empty($aDataFilter['tWahNameFrom'])) && (isset($aDataFilter['tWahNameTo']) && !empty($aDataFilter['tWahNameTo']))
                        || (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))
                        || (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                        || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                        || (isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect'])) 
                        || (isset($aDataFilter['tPosCodeSelect'])) 
                        || (isset($aDataFilter['tWahCodeSelect']))
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

            <!-- ============================ ฟิวเตอร์ข้อมูล รหัสผู้ป่วย ============================ -->
            <?php if ((isset($aDataFilter['tHNCodeFrom']) && !empty($aDataFilter['tHNCodeFrom'])) && (isset($aDataFilter['tHNCodeTo']) && !empty($aDataFilter['tHNCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                        <div class="text-left xCNRptFilter">
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptHNCodeFrom'].' : </span>'.$aDataFilter['tHNCodeFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptHNCodeTo'].' : </span>'.$aDataFilter['tHNCodeTo'];?></label>
                        </div>
                    </div>
            <?php endif; ?> 
        </div>
    </div>
</div>
