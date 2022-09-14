<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" style="width:5%;"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXNum')?></th>
                        <th class="xCNTextBold" style="width:210px;"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXDocNo')?></th>
                        <th class="xCNTextBold" style="width:210px;"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXDocDate')?></th>
                        <th class="xCNTextBold"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXCustomerName')?></th>
                        <th class="xCNTextBold" style="width:90px;"><?=language('document/taxinvoicefc/taxinvoicefc','tTAXPreview')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aABB['rtCode'] == 1):?>
                        <?php foreach($aABB['raItems'] as $nKey => $aValue): ?>
                            <tr class="text-center xCNTextDetail2">  
                                <td class="text-left"><?=$aValue['FNRowID']?></td>
                                <td class="text-left"><?=$aValue['FTXshDocNo']?></td>
                                <td class="text-left"><?=$aValue['FDXshDocDate']?></td>
                                <td class="text-left"><?=$aValue['FTAddName']?></td>
                                <td class="text-center">
                                    <img class="xCNIconTable" onClick="JSvTAXLoadPageAddOrPreview('<?=$aValue['FTBchCode']?>','<?=$aValue['FTXshDocNo']?>')" src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>" >
                                </td>
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
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aABB['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aABB['rnCurrentPage']?> / <?=$aABB['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTAXPDT btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTAXClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aABB['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTAXClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aABB['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTAXClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<script>
     //เปลี่ยนหน้า 1 2 3 ..
     function JSvTAXClickPageList(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
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
                default:
                    nPageCurrent    = ptPage;
            }
            JSxLoadContentDatatable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

</script>