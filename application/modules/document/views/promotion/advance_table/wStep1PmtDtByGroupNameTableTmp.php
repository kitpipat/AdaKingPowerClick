<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionStep1PmtPdtDtGroupNameTable">
        <thead>
            <tr>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBNo'); ?></th>
                <th width="45%" class="text-left"><?php echo language('document/promotion/promotion', 'tGroupName'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/promotion/promotion', 'tGroupType'); ?></th>
                <th width="20%" class="text-left"><?php echo language('document/promotion/promotion', 'tJoiningType'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/promotion/promotion', 'tTBDelete'); ?></th>
                <th width="5%" class="text-left"><?php echo language('document/promotion/promotion', 'tTitleEdit'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr 
                    class="xCNTextDetail2 xCNPromotionPmtPdtDtGroupNameRow" 
                    data-group-name="<?php echo $aValue['FTPmdGrpName']; ?>" 
                    data-sta-type="<?php echo $aValue['FTPmdStaType']; ?>"
                    data-sta-list-type="<?php echo $aValue['FTPmdStaListType']; ?>">
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left"><?php echo $aValue['FTPmdGrpName']; ?></td>
                        <td class="text-left"><?php echo language('document/promotion/promotion', 'tStaType'.$aValue['FTPmdStaType']); ?></td>
                        <td class="text-left"><?php echo $aValue['FTPmdStaListTypeName'] ?></td>
                        <td class="text-center">
                            <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                        <td class="text-center">
                            <img class="xCNIconTable xCNIconEdit" src="<?= base_url('application/modules/common/assets/images/icons/edit.png') ?>">
                            <img class="xCNIconTable xCNIconView xCNHide" src="<?= base_url('application/modules/common/assets/images/icons/view.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!-- ไว้ตรวจสอบว่ามีการ สร้างกลุ่มยกเว้นหรือไม่ และใช้ สินค้า หรือ ยี่ห้อ -->
<input type="hidden" id="ohdPromotionPmtDtStaListTypeInTmp" value="<?php echo $tPmdStaListType; ?>">

<?php if($aDataList['rnAllPage'] > 1) { ?>
    <div class="row xCNPromotionPmtPdtDtGroupNamePage">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvPromotionStep1PmtPdtDtGroupNameDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvPromotionStep1PmtPdtDtGroupNameDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvPromotionStep1PmtPdtDtGroupNameDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jStep1PmtDtGroupNameTableTmp.php'); ?>