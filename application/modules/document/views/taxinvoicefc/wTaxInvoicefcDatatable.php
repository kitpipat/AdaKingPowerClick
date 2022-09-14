<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" style="width:5%;"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXNum')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPDTCode')?></th>
						<th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPDTName')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPDTUnit')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPDTQty')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPDTDiscount')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPDTTotal')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aGetDT['rtCode'] == 1):?>
                        <?php foreach($aGetDT['raItems'] as $nKey => $aValue): ?>
                            <tr class="text-center xCNTextDetail2">  
                                <td class="text-left"><label><?=$aValue['FNRowID']?></label></td>
                                <td class="text-left"><label><?=$aValue['FTPdtCode']?></label></td>
                                <td class="text-left"><label><?=$aValue['FTXsdPdtName']?></label></td>
                                <td class="text-left"><label><?=$aValue['FTPunName']?></label></td>
                                <td class="text-right"><label><?=number_format($aValue['FCXsdQty'],2)?></label></td>
                                <td class="text-right"><label><?=number_format($aValue['FCXsdDis'] + $aValue['FCXsdChg']+$aValue['DISPMT'],2)?></label></td>
                                <td class="text-right"><label><?=number_format($aValue['FCXsdNet'] - $aValue['DISPMT'],2)?></label></td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class="text-center xCNTextDetail2" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--Page-->
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aGetDT['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aGetDT['rnCurrentPage']?> / <?=$aGetDT['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTAXPDT btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>

            <button onclick="JSvTAXClickPagePDT('Fisrt')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i><i class="fa fa-chevron-left f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
            <button onclick="JSvTAXClickPagePDT('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aGetDT['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTAXClickPagePDT('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aGetDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTAXClickPagePDT('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
            <button onclick="JSvTAXClickPagePDT('Last')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?> style="padding: 5px 10px;">
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i><i class="fa fa-chevron-right f-s-14 t-plus-1" style="margin-left: -3px;"></i>
            </button>
        </div>
    </div>
</div>

<script>
     //เปลี่ยนหน้า 1 2 3 ..
     function JSvTAXClickPagePDT(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case 'Fisrt': //กดหน้าแรก
                    nPageCurrent 	= 1;
                break;
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld        = $(".xWPageTAXPDT .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld        = $(".xWPageTAXPDT .active").text(); // Get เลขก่อนหน้า
                    nPageNew        = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent    = nPageNew;
                    break;
                case 'Last': //กดหน้าสุดท้าย
                    nPageCurrent 	= '<?=$aGetDT['rnAllPage']?>';
                break;
                default:
                    nPageCurrent    = ptPage;
            }
            if('<?=$tTypePage?>' == 'Preview'){
                JSxRanderDTPreview(nPageCurrent);
            }else{
                JSxRanderHDDT('',nPageCurrent);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

</script>