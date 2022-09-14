<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbPromotionImportExcelHDTable">
        <thead>
            <tr>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel50'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel51'); ?></th>
                <th nowrap width="auto" class="text-center"><?php echo language('document/promotion/promotion', 'tLabel52'); ?></th>
                <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo  language('common/main/main', 'tRemark'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataListCoupon['tCode'] == 1) { ?>
                <?php foreach ($aDataListCoupon['aResult'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNPromotionImportExcelHDRow">
                        <td nowrap class="text-center"><?php echo $aValue['FTPgtStaCoupon']; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTCphDocNo']; ?></td>
                        <td nowrap class="text-left"><?php echo $aValue['FTPgtCpnText']; ?></td>
                        <td nowrap class="text-left"><label style="color:red !important; font-weight:bold;"><?php echo $aValue['FTTmpRemark']; ?></label></td>
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

<?php include('script/jPromotionHDTable.php'); ?>