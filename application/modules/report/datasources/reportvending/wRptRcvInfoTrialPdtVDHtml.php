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
        border-bottom: dashed 1px #333 !important;
    }

    /** แนวตั้ง */
    @media print{@page {size: landscape}}
</style>
<div id="odvRptAdjustStockVendingHtml">
    <div class="container-fluid xCNLayOutRptHtml">
        <div class="xCNHeaderReport">
            <div class="row">
                <?php include 'application\modules\report\datasources\Address\wRptAddress.php'; ?>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="text-center">
                                <label class="xCNRptTitle"><?php echo @$aDataTextRef['tTitleReport'];?></label>
                            </div>
                        </div>
                    </div>

                    <?php if ((isset($aDataFilter['tBchCodeFrom']) && !empty($aDataFilter['tBchCodeFrom'])) && (isset($aDataFilter['tBchCodeTo']) && !empty($aDataFilter['tBchCodeTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล สาขา ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchFrom']?> : </label>   <label><?=$aDataFilter['tBchNameFrom'];?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBchTo']?> : </label>     <label><?=$aDataFilter['tBchNameTo']; ?></label>
                                </div>
                            </div>
                        </div>
                    <?php }; ?>

                    <?php if ((isset($aDataFilter['tDocDateFrom']) && !empty($aDataFilter['tDocDateFrom'])) && (isset($aDataFilter['tDocDateTo']) && !empty($aDataFilter['tDocDateTo']))) { ?>
                        <!-- ============================ ฟิวเตอร์ข้อมูล วันที่ ============================ -->
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                <div class="text-center">
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjDateFrom']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateFrom']));?></label>&nbsp;
                                    <label class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjDateTo']?> : </label>   <label><?=date('d/m/Y',strtotime($aDataFilter['tDocDateTo']));?></label>
                                </div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
                <div class="col-xs-4 col-sm-4 col-md-4 col-lg-4 "></div>
            </div>
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 table-responsive">
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
                            <th nowrap class="text-center xCNRptColumnHeader" width="2%"></th>
                            <th nowrap class="text-left xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptSalDocNo'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptDate'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" width="10%"><?php echo $aDataTextRef['tRptType'];?></th>
                            <th nowrap class="text-left xCNRptColumnHeader" width="8%"><?php echo $aDataTextRef['tRptStatus'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptStartDate'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader" width="15%"><?php echo $aDataTextRef['tRptExpiredDate'];?></th>
                            <th nowrap class="text-center xCNRptColumnHeader"></th>
                            <th nowrap class="text-center xCNRptColumnHeader"></th>
                            <th nowrap class="text-center xCNRptColumnHeader"></th>
                            <th nowrap class="text-center xCNRptColumnHeader"></th>
                            <th nowrap class="text-center xCNRptColumnHeader"></th>
                        </tr>
                        <tr>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-center xCNRptColumnHeader"></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-left xCNRptColumnHeader"><?php echo $aDataTextRef['tRptPdtCode'];?></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-left xCNRptColumnHeader" colspan="3"><?php echo $aDataTextRef['tRptPdtName'];?></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-left xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRptPos'];?></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-left xCNRptColumnHeader" colspan="2"><?php echo $aDataTextRef['tRptCodeRef'];?></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-center xCNRptColumnHeader"></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptBkdQty'];?></th>
                            <th style="border-bottom: 1px solid black !important;" nowrap class="text-right xCNRptColumnHeader"><?php echo $aDataTextRef['tRptBkdQtyRcv'];?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if(isset($aDataReport['aRptData']) && !empty($aDataReport['aRptData'])):?>
                            <?php foreach ($aDataReport['aRptData'] as $nKey=>$aValue): ?>
                                <!--  Step 2 แสดงข้อมูลใน TD  -->
                                <?php
                                    switch($aValue['FTBkpType']){
                                        case "2":
                                            $tCouponName = language('document/managecoupon/managecoupon','tMCPType1'); 
                                            break;
                                        case "1":
                                            $tCouponName = language('document/managecoupon/managecoupon','tMCPType2'); 
                                            break;
                                        default:
                                            $tCouponName = "-";
                                    }

                                    switch($aValue['FTBkpStatusReal']){
                                        case '1':
                                            $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus1'); // จอง
                                            break;
                                        case '2':
                                            $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus2'); // รับบางส่วน
                                            break;
                                        case '3':
                                            $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus3'); // รับทั้งหมด
                                            break;
                                        case '4':
                                            $tStaName   = language('document/managecoupon/managecoupon','tMCPStatus4'); // ยกเลิก
                                            break;
                                        case '5':
                                            $tStaName   = language('document/managecoupon/managecoupon','tMCPStatusExpire'); // หมดอายุ
                                            break;
                                        default:
                                            $tStaName = "-";
                                            break;
                                    }

                                    $tStrTime = strtotime($aValue['FDBkpDate']);
                                    $aDate    = getDate($tStrTime);
                                    if( $aDate['seconds'] == 0 && $aDate['minutes'] == 0 && $aDate['hours'] == 0 ){
                                        $dBkpDate    = date_format(date_create($aValue['FDBkpDate']), 'Y-m-d');
                                        $dBkpDateExp = date_format(date_create($aValue['FDBkpDateExpire']), 'Y-m-d');
                                    }else{
                                        $dBkpDate    = date_format(date_create($aValue['FDBkpDate']), 'Y-m-d H:i:s');
                                        $dBkpDateExp = date_format(date_create($aValue['FDBkpDateExpire']), 'Y-m-d H:i:s');
                                    }
                                ?>

                                <?php if( $aValue["FTBchSeq"] == '1' ){ ?>
                                <tr>
                                    <td class="text-left xCNRptDetail" colspan="100%"><?="<b>".$aDataTextRef['tRptBranch']." (".$aValue["FTBchCode"].") ".$aValue["FTBchName"]."</b>"?></td>
                                </tr>
                                <?php } ?>

                                <?php if( $aValue["FTRef1Seq"] == '1' ){ ?>
                                <tr>
                                    <td class="text-left xCNRptGrouPing"></td>
                                    <td class="text-left xCNRptGrouPing"><?php echo $aValue['FTBkpRef1'];?></td>
                                    <td class="text-center xCNRptGrouPing"><?php echo date_format(date_create($aValue['FDXshDocDate']),"d/m/Y");?></td>
                                    <td class="text-left xCNRptGrouPing"><?php echo $tCouponName;?></td>
                                    <td class="text-left xCNRptGrouPing"><?php echo $tStaName;?></td>
                                    <td class="text-center xCNRptGrouPing"><?=$dBkpDate;?></td>
                                    <td class="text-center xCNRptGrouPing"><?=$dBkpDateExp;?></td>
                                </tr>
                                <?php } ?>

                                <tr>
                                    <td class="text-left xCNRptDetail"></td>
                                    <td class="text-left xCNRptDetail"><?php echo "&nbsp;&nbsp;&nbsp;".$aValue['FTRef1Seq'].". ".$aValue['FTPdtCode'];?></td>
                                    <td class="text-left xCNRptDetail" colspan="3"><?php echo $aValue['FTPdtName'];?></td>
                                    <td class="text-left xCNRptDetail" colspan="2"><?php echo $aValue['FTPosName'];?></td>
                                    <td class="text-left xCNRptDetail" colspan="2"><?php echo (empty($aValue['FTBkpRef2']) ? '-' : $aValue['FTBkpRef2']);?></td>
                                    <td class="text-left xCNRptDetail"></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCBkdQty"], $nOptDecimalShow);?></td>
                                    <td class="text-right xCNRptDetail"><?php echo number_format($aValue["FCBkdQtyRcv"], $nOptDecimalShow);?></td>
                                </tr>

                                <?php if( $aValue["FTRef1Seq"] == $aValue["FTRef1MaxSeq"] ){ ?>
                                    <tr>
                                        <td></td>
                                        <td style="border-bottom: dashed 1px #d9d9d9 !important;" colspan="100%"></td>
                                    </tr>
                                <?php } ?>
                            <?php endforeach;?>
                            
                        <?php else:?>
                            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo $aDataTextRef['tRptAdjStkNoData'];?></td></tr>
                        <?php endif;?>
                    </tbody>
                </table>
            </div>

            <?php if( (isset($aDataFilter['tMerCodeFrom']) && !empty($aDataFilter['tMerCodeFrom'])) && (isset($aDataFilter['tMerCodeTo']) && !empty($aDataFilter['tMerCodeTo']))
                        || (isset($aDataFilter['tShpCodeFrom']) && !empty($aDataFilter['tShpCodeFrom'])) && (isset($aDataFilter['tShpCodeTo']) && !empty($aDataFilter['tShpCodeTo']))
                        || (isset($aDataFilter['tPosCodeFrom']) && !empty($aDataFilter['tPosCodeFrom'])) && (isset($aDataFilter['tPosCodeTo']) && !empty($aDataFilter['tPosCodeTo']))
                        || (isset($aDataFilter['tWahCodeFrom']) && !empty($aDataFilter['tWahCodeFrom'])) && (isset($aDataFilter['tWahCodeTo']) && !empty($aDataFilter['tWahCodeTo']))
                        || (isset($aDataFilter['tBchCodeSelect']))
                        || (isset($aDataFilter['tMerCodeSelect']))
                        || (isset($aDataFilter['tShpCodeSelect']))
                        || (isset($aDataFilter['tPosCodeSelect']))
                        || (isset($aDataFilter['tWahCodeSelect']))
                        ) { ?>
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
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptBranch']; ?> </span> <?php echo ($aDataFilter['bBchStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tBchNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล กลุ่มร้านค้า ============================ -->
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
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosFrom'].' : </span>'.$aDataFilter['tPosNameFrom'];?></label>
                            <label class="xCNRptLabel xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptAdjPosTo'].' : </span>'.$aDataFilter['tPosNameTo'];?></label>
                        </div>
                    </div>
            <?php endif; ?>
            <?php if (isset($aDataFilter['tPosCodeSelect']) && !empty($aDataFilter['tPosCodeSelect'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptVending']; ?> : </span> <?php echo ($aDataFilter['bPosStaSelectAll']) ? $aDataTextRef['tRptAll'] : $aDataFilter['tPosNameSelect']; ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล ประเภท ============================ -->
            <?php if (isset($aDataFilter['tCouponType'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptType']; ?> : </span> <?php echo (empty($aDataFilter['tCouponType']) ? $aDataTextRef['tRptAll'] : $aDataTextRef['tRptCoponType'.$aDataFilter['tCouponType']]); ?></label>
                    </div>
                </div>
            <?php endif; ?>

            <!-- ============================ ฟิวเตอร์ข้อมูล สถานะ ============================ -->
            <?php if (isset($aDataFilter['tCouponStatus'])) : ?>
                <div class="xCNRptFilterBox">
                    <div class="xCNRptFilter">
                        <label class="xCNRptDisplayBlock"><span class="xCNRptFilterHead"><?php echo $aDataTextRef['tRptStatus']; ?> : </span> <?php echo (empty($aDataFilter['tCouponStatus']) ? $aDataTextRef['tRptAll'] : $aDataTextRef['tRptCoponStatus'.$aDataFilter['tCouponStatus']]); ?></label>
                
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
