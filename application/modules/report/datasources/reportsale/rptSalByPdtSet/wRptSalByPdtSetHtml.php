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

    }

    .xGropingLev {
       /* border-top: 1px solid black !important; */
       border-top: dashed 1px #333 !important;
        border-bottom : 1px solid black !important;
    }
    /*แนวนอน*/
    @media print{@page {size: landscape;
        margin: 1.5mm 1.5mm 1.5mm 1.5mm;
    }}
</style>

<div id="odvRptSaleMemberHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 report-filter">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo $aDataTextRef['tTitleReport']; ?></label>
                            </div>
                        </div>
                    </div>

                    <?php if((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))): ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่สร้างเอกสาร ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalByPdtSetDocDateFrom']?></label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?>  </label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalByPdtSetDocDateTo']?></label>     <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?>    </label>
                                </div>
                            </div>
                        </div>
                    <?php endif;?>

                    <?php if( (isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalByPdtSetBchFrom']?></label> <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptTaxSalByPdtSetBchTo']?></label> <label><?=$aDataFilter['tBchNameTo'];?></label>
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

                            <th nowrap class="text-left  xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetBranch');?></th>
                            <th nowrap class="text-left  xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetPdtCode');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:20%;"><?php echo language('report/report/report', 'tRptSalByPdtSetPdtName');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetPdtGroup');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetQty');?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetUnit');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetSalAmt');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetDisAmt');?></th>
                            <th nowrap class="text-right xCNRptColumnHeader" style="width:10%;"><?php echo language('report/report/report', 'tRptSalByPdtSetTotal');?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])) { ?>
                            <?php
                            $tFTBchName = '';
                            $nRowIDMax  = 1;
                            $tSpacebar  ='&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;';
                            foreach ($aDataReport['aRptData'] as $nKey => $aValue) {

                                if(@$tFTBchCode!=$aValue['FTBchCode']){ $nRowIDMax = $aValue['FNRowPartID']; ?>
                                    <tr>
                                        <td colspan="6" nowrap class="text-left xCNRptGrouPing"><?=language('report/report/report', 'tRptAddrBranch');?> (<?php echo $aValue['FTBchCode'].') '.$aValue['FTBchName']; ?></td> 
                                    </tr>
                                <?php } ?>

                                <?php
                                    if($aValue['FTPdtCodeSet']==''){
                                        if($aValue['FTPdtStaSet']=='3'){
                                            $txCNRptGrouPing    = 'xCNRptGrouPing';
                                            $tFTPunName         = 'ชุด';
                                        }else{
                                            $txCNRptGrouPing    = '';
                                            $tFTPunName         = $aValue['FTPunName'];
                                        } ?>
                                    <tr>
                                        <td nowrap class="text-left xCNRptDetail <?=$txCNRptGrouPing?>"></td>
                                        <td nowrap class="text-left xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo $aValue['FTPdtCode']; ?></td>
                                        <td nowrap class="text-left xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo $aValue['FTXsdPdtName']; ?></td>
                                        <td nowrap class="text-left xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo $aValue['FTPgpChainName']; ?></td>
                                        <td nowrap class="text-right xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo number_format($aValue['FCXsdQty'],$nOptDecimalShow); ?></td>
                                        <td nowrap class="text-left xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo  $tFTPunName;  ?></td>
                                        <td nowrap class="text-right xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo number_format($aValue['FCXsdNet'],$nOptDecimalShow); ?></td>
                                        <td nowrap class="text-right xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo number_format($aValue['FCXddValue'],$nOptDecimalShow); ?></td>
                                        <td nowrap class="text-right xCNRptDetail <?=$txCNRptGrouPing?>"><?php echo number_format($aValue['FCXsdNetAfHD'],$nOptDecimalShow); ?></td>
                                    </tr>
                                <?php }else{ ?>
                                    <tr>
                                        <td nowrap class="text-left xCNRptDetail"> </td>
                                        <td nowrap class="text-left xCNRptDetail" ><?=$tSpacebar?><?php echo $aValue['FTPdtCodeSet']; ?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue['FTXsdPdtName']; ?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue['FTPgpChainName']; ?></td>
                                        <td nowrap class="text-right xCNRptDetail"><?php echo number_format($aValue['FCXsdQty'],$nOptDecimalShow); ?></td>
                                        <td nowrap class="text-left xCNRptDetail"><?php echo $aValue['FTPunName'];  ?></td>
                                        <td nowrap class="text-right xCNRptDetail"></td>
                                        <td nowrap class="text-right xCNRptDetail"></td>
                                        <td nowrap class="text-right xCNRptDetail"></td>
                                    </tr>
                                <?php } ?>

                                <?php if($nRowIDMax==$aValue['RowIDMax']){ ?>
                                    <tr class="xGropingLev" style="border-top: 1px dashed black !important;border-bottom : 1px dashed black !important;">
                                        <td nowrap  colspan="6" class="text-left xCNRptGrouPing"><?=language('report/report/report', 'tRptTaxSalePosTotal');?></td>
                                        <td nowrap class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXsdNet_SUMBch'],$nOptDecimalShow); ?></td>
                                        <td nowrap class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXshDis_SUMBch'],$nOptDecimalShow); ?></td>
                                        <td nowrap class="text-right xCNRptGrouPing"><?php echo number_format($aValue['FCXshNetAfHD_SUMBch'],$nOptDecimalShow); ?></td>
                                    </tr>
                                <?php } ?>

                                <?php
                                    $tFTBchCode = $aValue['FTBchCode'];
                                    $nRowIDMax++;
                                    $paFooterSumData = array(
                                        $aDataTextRef['tRptSalByPdtSetTotalGrand'],'N','N','N','N','N',number_format($aValue["FCXsdNet_Footer"],2),number_format($aValue["FCXshDis_Footer"],2),number_format($aValue["FCXsdNetAfHD_Footer"],2)
                                    );
                                ?>
                            <?php } ?>
                            <?php
                                // Step 6 : สั่ง Summary Footer
                                $nPageNo        = $aDataReport["aPagination"]["nDisplayPage"];
                                $nTotalPage     = $aDataReport["aPagination"]["nTotalPage"];
                                FCNtHRPTSumFooter($nPageNo, $nTotalPage, $paFooterSumData);
                            ?>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
            <?php if (isset($aDataFilter['tBchCodeSelect']) && !empty($aDataFilter['tBchCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']; ?> : </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

             <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มธุรกิจ ============================ -->
            <?php if ((isset($aDataFilter['tRptMerCodeFrom']) && !empty($aDataFilter['tRptMerCodeFrom'])) && (isset($aDataFilter['tRptMerCodeTo']) && !empty($aDataFilter['tRptMerCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantFrom'].' : </span>'.$aDataFilter['tRptMerNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjMerChantTo'].' : </span>'.$aDataFilter['tRptMerNameTo'];?></label>
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
            <?php if ((isset($aDataFilter['tRptShpCodeFrom']) && !empty($aDataFilter['tRptShpCodeFrom'])) && (isset($aDataFilter['tRptShpCodeTo']) && !empty($aDataFilter['tRptShpCodeTo']))) : ?>
                <div class="xCNRptFilterBox">
                    <div class="text-left xCNRptFilter">
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopFrom'].' : </span>'.$aDataFilter['tRptShpNameFrom'];?></label>
                        <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjShopTo'].' : </span>'.$aDataFilter['tRptShpNameTo'];?></label>
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
            <?php if ((isset($aDataFilter['tRptPosCodeFrom']) && !empty($aDataFilter['tRptPosCodeFrom'])) && (isset($aDataFilter['tRptPosCodeTo']) && !empty($aDataFilter['tRptPosCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tRptPosCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tRptPosCodeTo'];?></label>
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

            <!-- ============================ ฟิวเตอร์ข้อมูล ลูกค้า ============================ -->
            <?php if ((isset($aDataFilter['tCstCodeFrom']) && !empty($aDataFilter['tCstCodeFrom'])) && (isset($aDataFilter['tCstCodeTo']) && !empty($aDataFilter['tCstCodeTo']))) : ?>
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom'].' : </span>'.$aDataFilter['tCstCodeFrom'];?></label>
                    <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstTo'].' : </span>'.$aDataFilter['tCstCodeTo'];?></label>
                </div>
            </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tCstCodeSelect']) && !empty($aDataFilter['tCstCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptCstFrom']; ?> : </span> <?php echo ($aDataFilter['bCstStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tCstCodeSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล tRptPosType ============================ -->
            <div class="xCNRptFilterBox">
                <div class="text-left xCNRptFilter">
                    <label class="xCNRptLabel xCNRptDisplayBlock" ><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptPosTypeName'].' : </span>'.$aDataTextRef['tRptPosType'.$aDataFilter['tPosType']]; ?></label>
                </div>
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
