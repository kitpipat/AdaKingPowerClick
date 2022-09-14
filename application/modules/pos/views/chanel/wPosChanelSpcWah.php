
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide'; endif; ?>"><?php echo language('pos/poschannel/poschannel', 'tCSWAgency'); ?></th>
                        <th class="xCNTextBold text-center"><?php echo language('pos/poschannel/poschannel', 'tCSWBranch'); ?></th>
                        <th class="xCNTextBold text-center"><?php echo language('pos/poschannel/poschannel', 'tCSWWahouse'); ?></th>
                        <th class="xCNTextBold text-center"><?php echo language('pos/poschannel/poschannel', 'tCSWTypeWahouse'); ?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('common/main/main', 'tDelete'); ?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('common/main/main', 'tEdit'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aDataList['tCode'] == 1) : ?>
                        <?php foreach ($aDataList['aItems'] as $key => $aValue) { ?>
                            <tr class="text-center xCNTextDetail2">
                                <td class="text-left <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide'; endif; ?>"><?php echo (empty($aValue['FTAgnName']) ? '-' : $aValue['FTAgnName']); ?></td>
                                <td class="text-left"><?php echo $aValue['FTBchName']; ?></td>
                                <td class="text-left"><?php echo $aValue['FTWahName']; ?></td>
                                <td class="text-left"><?php echo language('pos/poschannel/poschannel', 'tCSWTypeWahouse'.$aValue['FTChnStaDoc']); ?></td>
                                <td>
                                    <img onclick="JSxCHNEventSpcWahDel(false,'<?=$aValue['FTBchCode']?>','<?=$aValue['FTBchName']?>','<?=$aValue['FTWahCode']?>','<?=$aValue['FTWahName']?>');" class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" title="<?php echo language('common/main/main', 'tCMNActionDelete'); ?>">
                                </td>
                                <td>
                                    <img onclick="JSvCHNPageSpcWahEdit('<?=$aValue['FTBchCode']?>','<?=$aValue['FTWahCode']?>');" class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" title="<?php echo language('common/main/main', 'tEdit'); ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<?php if( $aDataList['nAllRow'] != 0 ){ ?>
<div id="odvCSWPageContent" class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['nAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo $aDataList['nCurrentPage']; ?> / <?php echo $aDataList['nAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageGrp btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSxCSWClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['nAllPage'], $nPage + 2)); $i++) { ?>
                <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ -->
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <button onclick="JSxCSWClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['nAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSxCSWClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<?php } ?>

<div class="modal fade" id="odvCSWModalDel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete"> - </span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>