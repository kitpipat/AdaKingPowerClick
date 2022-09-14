<?php
    $aDataCompany       = $aDataViewRpt['aDataCompany'];
    $aDataFilterReport  = $aDataViewRpt['aDataFilter'];
    $aDataTextRef       = $aDataViewRpt['aDataTextRef'];
    $aDataBranchAddress = $aDataTextRef['aDataBranchAddress'];
    $aDataReport        = $aDataViewRpt['aDataReport'];
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
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrSubFooter{
        border-top: 1px solid black !important;
        border-bottom : 1px solid black !important;
        background-color: #CFE2F3 !important;
    }

    .table>tbody>tr.xCNTrFooter{
        border-top: 1px solid black !important;
        background-color: #CFE2F3 !important;
        border-bottom : 6px double black !important;
    }
    .table>tbody>tr.xCNHeaderGroup{
        border-bottom : 1px solid black !important;
        border-top : 1px solid black !important;
    }
    /*แนวนอน*/
    @media print{@page {size: landscape}}
    /*แนวตั้ง*/
    /*@media print{@page {size: portrait}}*/
</style>
<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-center">
                        <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                    <div class="text-left">
                        <label class="xCNRptLabel"><?php echo @$aDataTextRef['tTitleCompName'];?></label>
                        <?php if($aDataFilter['tDocDateFrom'] !== '' && $aDataFilter['tDocDateFrom'] != '') : ?><br>
                        <?php echo language('report/report/report','tRptDateFrom') ?> 
                        <?php echo $aDataFilter['tDocDateFrom'] ?> 
                        <?php echo language('report/report/report','tRptDateTo') ?>
                        <?php echo $aDataFilter['tDocDateFrom'] ?> 
                        <?php endif;?> 
                    </div>
                    <?php if($aDataBranchAddress['FTAddVersion'] == 1):?>
                        <?php
                            // Check Data Address Road
                            if(isset($aDataBranchAddress['FTAddV1Road']) && !empty($aDataBranchAddress['FTAddV1Road'])){
                                $tTextLabeltRoad = $aDataTextRef['tRptAddrRoad'].$aDataBranchAddress['FTAddV1Road'];
                            }else{
                                $tTextLabeltRoad = $aDataTextRef['tRptAddrRoad'].' -';
                            }
                            
                            // Check Data Address Soi
                            if(isset($aDataBranchAddress['FTAddV1Soi']) && !empty($aDataBranchAddress['FTAddV1Soi'])){
                                $tTextLabeltSoi  = $aDataTextRef['tRptAddrSoi'].$aDataBranchAddress['FTAddV1Soi'];
                            }else{
                                $tTextLabeltSoi  = $aDataTextRef['tRptAddrSoi'].' -';
                            }
                        ?>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo @$aDataBranchAddress['FTAddV1No'].' '.@$tTextLabeltRoad.' '.@$tTextLabeltSoi;?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel">
                                <?php echo @$aDataBranchAddress['FTSudName'].' '.$aDataBranchAddress['FTDstName'].' '.$aDataBranchAddress['FTPvnName'].' '.$aDataBranchAddress['FTAddV1PostCode']?>
                            </label>
                        </div>
                    <?php elseif($aDataBranchAddress['FTAddVersion'] == 2):?>
                        <?php
                            // Cheack Address Ver 2 Des 1
                            if(isset($aDataBranchAddress['FTAddV2Desc1']) && !empty($aDataBranchAddress['FTAddV2Desc1'])){
                                $tTextLabelAddrV2Desc1  = $aDataTextRef['tRptAddV2Desc1'].' '.$aDataBranchAddress['FTAddV2Desc1'];
                            }else{
                                $tTextLabelAddrV2Desc1  = $aDataTextRef['tRptAddV2Desc1'].' -';
                            }

                            // Cheack Address Ver 2 Des 1
                            if(isset($aDataBranchAddress['FTAddV2Desc2']) && !empty($aDataBranchAddress['FTAddV2Desc2'])){
                                $tTextLabelAddrV2Desc2  = $aDataTextRef['tRptAddV2Desc2'].' '.$aDataBranchAddress['FTAddV2Desc2'];
                            }else{
                                $tTextLabelAddrV2Desc2  = $aDataTextRef['tRptAddV2Desc2'].' -';
                            }
                        ?>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $tTextLabelAddrV2Desc1;?></label>
                        </div>
                        <div class="text-left">
                            <label class="xCNRptLabel"><?php echo $tTextLabelAddrV2Desc2;?></label>
                        </div>
                    <?php else: endif;?>
                    <div class="text-left">
                        <?php 
                            if($aDataCompany['rtCode'] == 1){
                                $tTextLabelTel  = $aDataCompany['raItems']['rtCmpTel'];
                            }else{
                                $tTextLabelTel  = '-';
                            }
                        ?>
                        <label class="xCNRptLabel"><?php echo @$aDataTextRef['tRptAddrTel'].' '.@$tTextLabelTel;?></label>
                    </div>
                    <div class="text-left">
                        <?php 
                            if($aDataCompany['rtCode'] == 1){
                                $tTextLabelFax  = $aDataCompany['raItems']['rtCmpFax'];
                            }else{
                                $tTextLabelFax  = '-';
                            }
                        ?>
                        <label class="xCNRptLabel"><?php echo @$aDataTextRef['tRptAddrFax'].' '.@$tTextLabelFax;?></label>
                    </div>
                    <div class="text-left">
                        <?php
                            if(isset($aDataBranchAddress['FTBchName']) && !empty($aDataBranchAddress['FTBchName'])){
                                $tTextLabelBranch   = $aDataBranchAddress['FTBchName'];
                            }else{
                                $tTextLabelBranch   = '-';
                            }
                        ?>
                        <label class="xCNRptLabel"><?php echo @$aDataTextRef['tRptAddrBranch'].' '.@$tTextLabelBranch;?></label>
                    </div>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <label class="xCNRptLabel"><?php echo @$aDataTextRef['tDatePrint'].' '.date('d/m/Y').' '.@$aDataTextRef['tTimePrint'].' '.date('H:i:s');?></label>
                    </div>
                </div>
            </div>
        </div>
        <div class="xCNContentReport">
            <div id="odvRptTableAdvance" class="table-responsive">
                <table class="table">
                    <thead>
                        <tr>                     
                            <th nowrap class="text-center xCNTextBold" style="width:10%; padding: 15px;"><?php echo  language('report/report/report','tRptDocument');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:15%; padding: 10px;"><?php echo  language('report/report/report','tRptDateDocument');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:10%; padding: 10px;"><?php echo  language('report/report/report','tRptFromWareHouse');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:10%; padding: 10px;"><?php  echo  language('report/report/report','tRptToWareHouse');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:5%;  padding: 10px;"><?php  echo  language('report/report/report','tRptAdjStkVDPdtCode');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:10%; padding: 10px;"><?php  echo  language('report/report/report','tRptAdjStkVDPdtName');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:5%; padding: 10px;"><?php  echo  language('report/report/report','tRptAdjStkVDLayRow');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:5%; padding: 10px;"><?php  echo  language('report/report/report','tRptAdjStkVDLayCol');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:5%; padding: 10px;"><?php  echo  language('report/report/report','tRptTransferamount');?></th>
                            <th nowrap class="text-center xCNTextBold" style="width:5%; padding: 10px;"><?php  echo  language('report/report/report','tRptListener');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nSubSumAjdWahB4Adj     = 0;
                                $nSubSumAjdUnitQty      = 0;

                                $nSumFooterAjdWahB4Adj  = 0;
                                $nSumFooterAjdUnitQty   = 0;
                            ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <?php
                                    // Step 1 เตรียม Parameter สำหรับการ Groupping
                                    $thDocNo     = $aValue["FTXthDocNo"];  
                                    $thDocDate   = $aValue["FDXthDocDate"];  
                                    $thWhFrm     = $aValue["FTXthWhFrmName"];  
                                    $thWhTo      = $aValue["FTXthWhToName"];  
                                    $tUser       = $aValue["FTXtdUsrKey"];  
    

                                    $nGroupMember   = $aValue["FNRptGroupMember"]; 
                                    $nRowPartID     = $aValue["FNRowPartID"]; 
                                ?>
                                <?php
                                    //Step 2 Groupping data
                                    $aGrouppingData = array($thDocNo,$thDocDate,$thWhFrm,$thWhTo,'N','N','N','N','N',$tUser);
                                    // Parameter
                                    // $nRowPartID      = ลำดับตามกลุ่ม
                                    // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                    FCNtHRPTHeadGroupping($nRowPartID,$aGrouppingData);
                                ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td></td>
                                    <td></td>
                                    <td></td>
                                    <td></td>

                                    <td nowrap class="text-left"><?php echo $aValue["FTPdtCode"];?></td>
                                    <td nowrap class="text-left"><?php echo $aValue["FTPdtName"];?></td>
                                    <td nowrap class="text-center"><?php echo $aValue["FNLayRow"];?></td>
                                    <td nowrap class="text-center"><?php echo $aValue["FNLayCol"];?></td>
                                    <td nowrap class="text-center"><?php echo $aValue["FCXtdQty"];?></td>
                                    <td nowrap class="text-center"></td>
                                </tr>

                                <?php
                                    //Step 3 : เตรียม Parameter สำหรับ Summary Sub Footer
                                    // $nSubSumAjdWahB4Adj = $aValue["FCAjdWahB4Adj_SubTotal"];
                                    // $nSubSumAjdUnitQty  = $aValue["FCAjdUnitQty_SubTotal"];

                                    // $aSumFooter         = array($aDataTextRef['tRptAdjStkVDTotalSub'],'N','N','N','N','N','N',$nSubSumAjdWahB4Adj,$nSubSumAjdUnitQty);

                                    //Step 4 : สั่ง Summary SubFooter
                                    //Parameter 
                                    //$nGroupMember     = จำนวนข้อมูลทั้งหมดในกลุ่ม
                                    //$nRowPartID       = ลำดับข้อมูลในกลุ่ม
                                    //$aSumFooter       =  ข้อมูล Summary SubFooter
                                    // FCNtHRPTSumSubFooter($nGroupMember,$nRowPartID,$aSumFooter);


                                    //Step 5 เตรียม Parameter สำหรับ SumFooter
                                    // $nSumFooterAjdWahB4Adj  = number_format($aValue["FCAjdWahB4Adj_Footer"],2);
                                    // $nSumFooterAjdUnitQty   = number_format($aValue["FCAjdUnitQty_Footer"],2);
                                    // $paFooterSumData        = array($aDataTextRef['tRptAdjStkVDTotalFooter'],'N','N','N','N','N','N',$nSumFooterAjdWahB4Adj,$nSumFooterAjdUnitQty);
                                ?>
                            <?php endforeach;?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                // FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                            ?>
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptAdjStkNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>
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


