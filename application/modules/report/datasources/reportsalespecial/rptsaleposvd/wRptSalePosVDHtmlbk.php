<?php
    $aDataReport    = $aDataViewRpt['aDataReport'];
    $aDataTextRef   = $aDataViewRpt['aDataTextRef'];
    $aDataFilter    = $aDataViewRpt['aDataFilter'];
    $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
    $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];
?>
<style>
    /** Set Media Print */
    @media print{@page {size: A4 landscape;}}

    .table thead th, .table>thead>tr>th, .table tbody tr, .table>tbody>tr>td {
        border: 0px transparent !important;
    }

    .table>thead:first-child>tr:first-child>td, .table>thead:first-child>tr:first-child>th {
        border-top: 1px solid black !important;
        border-bottom: 1px solid black !important;
    }
</style>
<div id="odvRptSaleTaxByMonthlyHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <?php if (isset($aCompanyInfo) && !empty($aCompanyInfo)):?>
                        <div class="text-left">
                            <label class="xCNRptCompany"><?php echo $aCompanyInfo['FTCmpName'];?></label>
                        </div>
                        <?php if ($aCompanyInfo['FTAddVersion'] == '1') { // ที่อยู่แบบแยก ?>
                            <div class="text-left xCNRptAddress">
                                <label ><?php echo @$aCompanyInfo['FTAddV1No'] . ' ' . @$aCompanyInfo['FTAddV1Road'] . ' ' . @$aCompanyInfo['FTAddV1Soi']?>
                                <?php echo @$aCompanyInfo['FTSudName'] . ' ' . @$aCompanyInfo['FTDstName'] . ' ' . @$aCompanyInfo['FTPvnName'] . ' ' . @$aCompanyInfo['FTAddV1PostCode']?></label>
                            </div>
                        <?php } ?>
                        <?php if ($aCompanyInfo['FTAddVersion'] == '2') { // ที่อยู่แบบรวม ?>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV2Desc1'] ?></label>
                            </div>
                            <div class="text-left">
                                <label class="xCNRptLabel"><?php echo @$aCompanyInfo['FTAddV2Desc2'] ?></label>
                            </div>
                        <?php } ?>
                        <div class="text-left xCNRptAddress">
                            <label><?php echo @$aDataTextRef['tRptAddrTel'] . @$aCompanyInfo['FTCmpTel']?> <?php echo @$aDataTextRef['tRptAddrFax'] . @$aCompanyInfo['FTCmpFax']?></label>
                        </div>
                      
                    <?php endif;?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
                    <div class="text-right">
                        <label class="xCNRptDataPrint"><?php echo @$aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.@$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table" width="100%">
                    <thead>
                        <tr>
                            <th  class="text-left  xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrPos'];?></th>
                            <th  class="text-left  xCNRptColumnHeader"  style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrTaxNumber'];?></th>
                            <th  class="text-left  xCNRptColumnHeader"  style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrSaleDate'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrPaymentType'];?></th>
                            <th  class="text-left  xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrProduct'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrNet'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrPrice'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrVat'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrTotal'];?></th>
                            <th  class="text-left xCNRptColumnHeader"  style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrCstDescription'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrHnNumber'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrCtzID'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrCstName'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrCstlName'];?></th>
                            <th  class="text-right xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrCstTel'];?></th>
                            <th  class="text-left xCNRptColumnHeader" style="width:6%;vertical-align: middle; "><?php echo $aDataTextRef['tRptCrCstDescription'];?></th>    
                        </tr>
                    </thead>
                    <tbody> 
                    <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php

                                  
                                // Set ตัวแปร Sum - SubFooter
                                // $nSumSubXsdQty          = 0;
                                // $cSumSubXsdAmtB4DisChg  = 0;
                                // $cSumSubXsdDis          = 0;
                                // $cSumSubXsdVat          = 0;
                                // $cSumSubXsdNetAfHD      = 0;
                                // // Set ตัวแปร SumFooter
                                // $nSumFootXsdQty         = 0;
                                // $cSumFootXsdAmtB4DisChg = 0;
                                // $cSumFootXsdDis         = 0;
                                // $cSumFootXsdVat         = 0;
                                // $cSumFootXsdNetAfHD     = 0;
                            ?> 
                            <?php foreach($aDataReport['aRptData'] as $nKey=>$aValue):?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    // $tBchCodeGroup  = $aDataTextRef['tRptBranch'].' '.$aValue["FTBchCode"].' '.$aValue["FTBchName"];
                                    $tRptDocDate    = date('d-m-Y', strtotime($aValue["FDXshDocDate"]));
                                    // $nGroupMember   = $aValue["FNRptGroupMember"]; 
                                    $nRowPartID     = $aValue["FNRowPartID"]; 
                                ?>
                                <?php
                                    //Step 2 Groupping data
                                    // $aGrouppingData = array($tBchCodeGroup,'','','','','','');
                                    // Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                    // FCNtHRPTHeadGrouppingRptTSPBch($nRowPartID,$aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>    
                                    <td  class="text-left xCNRptDetail" ><?php echo $aValue['FTPosCode']; ?></td>
                                    <td  class="text-left xCNRptDetail"><?php echo $aValue["FTXshDocNo"]; ?></td>
                                    <td  class="text-left xCNRptDetail"><?php echo $tRptDocDate; ?></td>
                                    <td  class="text-left xCNRptDetail"><?php echo $aValue["FTRcvName"]; ?></td>
                                    <td  class="text-left xCNRptDetail" ><?php echo $aValue["FTPdtName"]; ?></td>
                                    
                                    <td  class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXrcNet"], $nOptDecimalShow)?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdVatable"], $nOptDecimalShow)?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXshVat"], $nOptDecimalShow)?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo number_format($aValue["FCXsdNetAfHD"], $nOptDecimalShow)?></td>
                                    <td  class="text-left  xCNRptDetail" width="1%"><?php  echo $aValue["FTXshRmk"]; ?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo $aValue["FTCstCode"];?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo $aValue["FTCstCardID"];?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo $aValue["FTCstName"];?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo $aValue["FTCstLastName"];?></td>
                                    <td  class="text-right xCNRptDetail"><?php echo $aValue["FTCstTel"];?></td>
                                    <td  class="text-left xCNRptDetail"><?php echo $aValue["FTXrcRmk"];?></td>
                                    
                                </tr>

                                <?php
                                    // Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    // $nSumSubXsdQty          = number_format($aValue["FCXsdQty_SubTotal"], $nOptDecimalShow);
                                    // $cSumSubXsdAmtB4DisChg  = number_format($aValue["FCXsdAmtB4DisChg_SubTotal"], $nOptDecimalShow);
                                    // $cSumSubXsdDis          = number_format($aValue["FCXsdDis_SubTotal"], $nOptDecimalShow);
                                    // // $cSumSubXsdVat          = number_format($aValue["FCXsdSetPrice_SubTotal"], $nOptDecimalShow);
                                    // $cSumSubXsdNetAfHD      = number_format($aValue["FCXsdNetAfHD_SubTotal"], $nOptDecimalShow);
                                    // $tSumBranch             = $aDataTextRef['tRptTotal'].' '.$aDataTextRef['tRptBranch'].' '.$aValue["FTBchCode"];

                                    // $aSumFooter             = array($tSumBranch,'N',$nSumSubXsdQty,'N',$cSumSubXsdAmtB4DisChg,$cSumSubXsdDis,'N',$cSumSubXsdNetAfHD);

                                    //Step 4 : สั่ง Summary SubFooter
                                    //Parameter 
                                    //$nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    //$nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    //$aSumFooter       =  ข้อมูล Summary SubFooter
                                    // FCNtHRPTSumSubFooter3($nGroupMember,$nRowPartID,$aSumFooter,2);

                                    //Step 5 เตรียม Parameter สำหรับ SumFooter
                                    $nSumFootXrcNet            = number_format($aValue["FCXrcNet_Footer"], $nOptDecimalShow);
                                    $cSumFootXsdVatable    = number_format($aValue["FCXsdVatable_Footer"], $nOptDecimalShow);
                                    $nSumFootXshVat         = number_format($aValue["FCXshVat_Footer"], $nOptDecimalShow);
                                    $cSumFootXsdNetAfHD    = number_format($aValue["FCXsdNetAfHD_Footer"], $nOptDecimalShow);
                                    // $cSumFootXsdDis             = number_format($aValue["FCXsdDis_Footer"], $nOptDecimalShow);
                                    // // $cSumSubXsdVat              = number_format($aValue["FCXsdSetPrice_Footer"], $nOptDecimalShow);
                                    // $cSumFootXsdNetAfHD         = number_format($aValue["FCXsdNetAfHD_Footer"], $nOptDecimalShow);
                                    $paFooterSumData            = array($aDataTextRef['tRptTotalFooter'],'N','N','N','N',$nSumFootXrcNet,$cSumFootXsdVatable,$nSumFootXshVat,$cSumFootXsdNetAfHD,'N','N','N','N','N','N','N','N');
                                ?>
                            <?php endforeach;?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                            ?>
                            
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>    
                </table>
            </div>
        </div>
    </div>
</div>