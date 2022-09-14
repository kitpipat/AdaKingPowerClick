<?php
$aCompanyInfo = $aDataViewRpt['aDataCompany'];
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
        background-color: #CFE2F3 !important;
        /*border-bottom : 6px double black !important;*/
    }

    .table>tbody>tr.xCNHeaderGroup {
        border-bottom: 1px solid black !important;
        border-top: 1px solid black !important;
    }

    /*แนวนอน*/
    @media print {
        @page {
            size: landscape
        }
    }
    /*แนวตั้ง*/
    /* @media print{@page {size: portrait}} */
</style>
<div id="odvRptProductTransferHtml">
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
                            <label><?= $aDataTextRef['tRptTaxNo'] . ' : ' . $aCompanyInfo['FTAddTaxNo'] ?></label>
                        </div>
                    <?php } ?>
                </div>

                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 ">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <b><label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label></b>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) : ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center ">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateFrom'];?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?> </label>
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptDateTo'];?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?> </label>
                                </div>
                            </div>
                        </div>
                    <?php endif; ?>
                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4"></div>

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
                            <th nowrap width="15%" class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptDocument'); ?></th>
                            <th nowrap width="25%" class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptDateDocument'); ?></th>
                            <th nowrap width="15%" class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptFromWareHouse'); ?></th>
                            <th nowrap width="15%" class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptToWareHouse'); ?></th>
                            <th nowrap width="30%" colspan="6" nowrap class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptListener'); ?></th>
                        </tr>
                        <tr>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptAdjStkVDPdtCode'); ?></th>
                            <th nowrap class="text-left xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptAdjStkVDPdtName'); ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptAdjStkVDLayRow'); ?></th>
                            <th nowrap class="text-right xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptAdjStkVDLayCol'); ?></th>
                            <th colspan="5" nowrap class="text-right xCNRptColumnHeader"><?php echo  language('report/report/report', 'tRptTransferamount'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) : ?>
                            <?php
                                // Set ตัวแปร SumSubFooter และ ตัวแปร SumFooter
                                $nSubSumAjdWahB4Adj     = 0;
                                $nSubSumAjdUnitQty      = 0;

                                $nSumFooterAjdWahB4Adj  = 0;
                                $nSumFooterAjdUnitQty   = 0;
                                ?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey => $aValue) : ?>
                                <?php
                                        // Step 1 เตรียม Parameter สำหรับการ Groupping
                                        $thDocNo     = $aValue["FTXthDocNo"];
                                        $thDocDate   = empty($aValue["FDXthDocDate"]) ? '' : date('d/m/Y H:i:s', strtotime($aValue["FDXthDocDate"]));
                                        $thWhFrm     = $aValue["FTXthWhFrmName"];
                                        $thWhTo      = $aValue["FTXthWhToName"];
                                        $tUser       = $aValue["FTXtdUsrKey"];

                                        $nGroupMember   = $aValue["FNRptGroupMember"];
                                        $nRowPartID     = $aValue["FNRowPartID"];
                                        ?>
                                <?php
                                        //Step 2 Groupping data
                                        $aGrouppingData = array($thDocNo, $thDocDate, $thWhFrm, $thWhTo, $tUser);
                                        // Parameter
                                        // $nRowPartID      = ลำดับตามกลุ่ม
                                        // $aGrouppingData  = ข้อมูลสำหรับ Groupping
                                        FCNtHRPTHeadGroupping($nRowPartID, $aGrouppingData);
                                        ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <tr>
                                    <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTPdtCode"]; ?></td>
                                    <td nowrap class="text-left xCNRptDetail"><?php echo $aValue["FTPdtName"]; ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FNLayRow"]; ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FNLayCol"]; ?></td>
                                    <td nowrap class="text-right xCNRptDetail"><?php echo $aValue["FCXtdQty"]; ?></td>
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
                            <?php endforeach; ?>
                            <?php
                                //Step 6 : สั่ง Summary Footer
                                $nPageNo    = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage = $aDataReport["aPagination"]["nTotalPage"];
                                // FCNtHRPTSumFooter($nPageNo,$nTotalPage,$paFooterSumData);
                                ?>
                        <?php else : ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo @$aDataTextRef['tRptAdjStkNoData']; ?></td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo'])) 
                        || (isset($aDataFilter['tShpTCodeFrom']) && !empty($aDataFilter['tShpTCodeFrom'])) && (isset($aDataFilter['tShpTCodeTo']) && !empty($aDataFilter['tShpTCodeTo']))
                        || (isset($aDataFilter['tShpRCodeFrom']) && !empty($aDataFilter['tShpRCodeFrom'])) && (isset($aDataFilter['tShpRCodeTo']) && !empty($aDataFilter['tShpRCodeTo']))
                        || (isset($aDataFilter['tPosTCodeFrom']) && !empty($aDataFilter['tPosTCodeFrom'])) && (isset($aDataFilter['tPosTCodeTo']) && !empty($aDataFilter['tPosTCodeTo']))
                        || (isset($aDataFilter['tPosRCodeFrom']) && !empty($aDataFilter['tPosRCodeFrom'])) && (isset($aDataFilter['tPosRCodeTo']) && !empty($aDataFilter['tPosRCodeTo']))
                        || (isset($aDataFilter['tWahTCodeFrom']) && !empty($aDataFilter['tWahTCodeFrom'])) && (isset($aDataFilter['tWahTCodeTo']) && !empty($aDataFilter['tWahTCodeTo']))
                        || (isset($aDataFilter['tWahRCodeFrom']) && !empty($aDataFilter['tWahRCodeFrom'])) && (isset($aDataFilter['tWahRCodeTo']) && !empty($aDataFilter['tWahRCodeTo']))
                        ) { ?>
                <div class="xCNRptFilterTitle">
                    <div class="text-left">
                        <label class="xCNTextConsOth"><?=$aDataTextRef['tRptConditionInReport'];?></label>
                    </div>
                </div>
            <?php } ;?>

            <?php if ((isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))) { ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerFrom'].' : </span>'.$aDataFilter['tMerNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptMerTo'].' : </span>'.$aDataFilter['tMerNameTo']; ?></label>
                    </div>
                </div>
            <?php }; ?>

            <?php if ((isset($aDataFilter['tShpTCodeFrom']) && !empty($aDataFilter['tShpTCodeFrom'])) && (isset($aDataFilter['tShpTCodeTo']) && !empty($aDataFilter['tShpTCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้าที่โอน ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShpTFrom'].' : </span>'.$aDataFilter['tShpTNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShpTTo'].' : </span>'.$aDataFilter['tShpTNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['tShpRCodeFrom']) && !empty($aDataFilter['tShpRCodeFrom'])) && (isset($aDataFilter['tShpRCodeTo']) && !empty($aDataFilter['tShpRCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล ร้านค้าที่รับโอน ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShpRFrom'].' : </span>'.$aDataFilter['tShpRNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptShpRTo'].' : </span>'. $aDataFilter['tShpRNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['tPosTCodeFrom']) && !empty($aDataFilter['tPosTCodeFrom'])) && (isset($aDataFilter['tPosTCodeTo']) && !empty($aDataFilter['tPosTCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล ตู้ที่โอน ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTFrom'].' : </span>'.$aDataFilter['tPosTCodeFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTTo'].' : </span>'.$aDataFilter['tPosTCodeTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['tPosRCodeFrom']) && !empty($aDataFilter['tPosRCodeFrom'])) && (isset($aDataFilter['tPosRCodeTo']) && !empty($aDataFilter['tPosRCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล ตู้ที่รับโอน ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosRFrom'].' : </span>'.$aDataFilter['tPosRCodeFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosRTo'].' : </span>'.$aDataFilter['tPosRCodeTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['tWahTCodeFrom']) && !empty($aDataFilter['tWahTCodeFrom'])) && (isset($aDataFilter['tWahTCodeTo']) && !empty($aDataFilter['tWahTCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล คลังที่โอน ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['TRptWahTFrom'].' : </span>'.$aDataFilter['tWahTNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['TRptWahTTo'].' : </span>'.$aDataFilter['tWahTNameTo']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <?php if ((isset($aDataFilter['tWahRCodeFrom']) && !empty($aDataFilter['tWahRCodeFrom'])) && (isset($aDataFilter['tWahRCodeTo']) && !empty($aDataFilter['tWahRCodeTo']))) : ?>
                <!-- ============================ ฟิวเตอร์ข้อมูล คลังที่รับโอน ============================ -->
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['TRptWahRFrom'].' : </span>'.$aDataFilter['tWahRNameFrom']; ?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['TRptWahRTo'].' : </span>'.$aDataFilter['tWahRNameFrom']; ?></label>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="xCNFooterPageRpt">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="text-right">
                        <?php if ($aDataReport["aPagination"]["nTotalPage"] > 0) : ?>
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
        var oFilterLabel = $('.sreport-filter .text-center label:first-child');
        var nMaxWidth = 0;
        oFilterLabel.each(function(index){
            var nLabelWidth = $(this).outerWidth();
            if(nLabelWidth > nMaxWidth){
                nMaxWidth = nLabelWidth;
            }
        });
        $('.sreport-filter .text-center label:first-child').width(nMaxWidth + 50);
    });
</script>