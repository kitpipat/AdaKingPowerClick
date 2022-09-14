<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep1PmtPdtDtTable">
        <thead>
            <tr>
                <th width="2%" class="text-center">
                    <label class="fancy-checkbox">
                        <input type="checkbox" class="xCNListItemAll xCNApvOrCanCelDisabledPmtPdtDt">
                        <span>&nbsp;</span>
                    </label>
                </th>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th width="18%" class="text-left"><?php echo language('document/promotion/promotion', 'tPdtCodeName'); ?></th>
                <th width="40%" class="text-left"><?php echo language('document/promotion/promotion', 'tPdtName'); ?></th>
                <th width="15%" class="text-left"><?php echo language('document/promotion/promotion', 'tProductUnit'); ?></th>
                <th width="15%" class="text-left"><?php echo language('document/promotion/promotion', 'tBarCode'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <?php $bIsShopAll = (empty($aValue['FTPmdRefCode']) && empty($aValue['FTPmdRefName']) && empty($aValue['FTPmdSubRefName']) && empty($aValue['FTPmdBarCode'])); ?>
                    <?php if(!$bIsShopAll) { ?>
                        <tr class="xCNTextDetail2 xCNPromotionPmtPdtDtRow" data-seq-no="<?php echo $aValue['FNPmdSeq']; ?>">
                            <td class="text-center">
                                <label class="fancy-checkbox">
                                    <input type="checkbox" class="xCNListItem xCNApvOrCanCelDisabledPmtPdtDt" name="ocbListItem[]">
                                    <span>&nbsp;</span>
                                </label>
                            </td>
                            <td class="text-center"><?php echo $key+1; ?></td>
                            <td class="text-left xCNPromotionStep1PmtDtPmdRefCode"><?php echo $aValue['FTPmdRefCode']; ?></td>
                            <td class="text-left xCNPromotionStep1PmtDtPmdRefName"><?php echo $aValue['FTPmdRefName']; ?></td>
                            <td class="text-left xCNPromotionStep1PmtDtPmdSubRefName"><?php echo $aValue['FTPmdSubRefName']; ?></td>
                            <td class="text-left xCNPromotionStep1PmtDtPmdBarCode"><?php echo $aValue['FTPmdBarCode']; ?></td>
                            <td class="text-center">
                                <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                            </td>
                        </tr>
                    <?php }else{ ?>
                        <tr>
                            <td class='text-center xCNTextDetail2 xCNPromotionStep1PmtDtShopAll' data-status="1" colspan='100%'><?= language('common/main/main', 'ทั้งร้าน') ?></td>
                        </tr>
                    <?php } ?>        
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<?php if($aDataList['rnAllPage'] > 1) { ?>
    <div class="row xCNPromotionPmtPdtDtPage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep1PmtPdtDtDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                    <?php 
                        if($nPage == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvPromotionStep1PmtPdtDtDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep1PmtPdtDtDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep1PmtPdtDtTableTmp.php'); ?>