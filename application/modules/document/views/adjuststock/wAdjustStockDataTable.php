<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?php echo  language('document/adjuststock/adjuststock', 'tASTTBChoose') ?></th>
                        <?php endif; ?>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBBchCreate') ?></th>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBDocNo') ?></th>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBDocDate') ?></th>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBStaDoc') ?></th>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBStaPrc') ?></th>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBCreateBy') ?></th>
                        <th class="xCNTextBold"><?php echo language('document/adjuststock/adjuststock', 'tASTTBApvBy') ?></th>

                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionDelete') ?></th>
                        <?php endif; ?>

                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionEdit') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php
                        if (FCNnHSizeOf($aDataList['raItems']) != 0) {
                            foreach ($aDataList['raItems'] as $nKey => $aValue) : ?>
                                <?php
                                $tASTDocNo  =   $aValue['FTAjhDocNo'];
                                if ($aValue['FTAjhStaApv'] == 1 || $aValue['FTAjhStaApv'] == 2 || $aValue['FTAjhStaDoc'] == 3) {
                                    $tCheckboxDisabled  = "disabled";
                                    $tClassDisabled     = "xCNDocDisabled";
                                    $tTitle             = language('document/document/document', 'tDOCMsgCanNotDel');
                                    $tOnclick           = '';
                                } else {
                                    $tCheckboxDisabled  = "";
                                    $tClassDisabled     = '';
                                    $tTitle             = '';
                                    $tOnclick           = "onclick=JSoASTDelDocSingle('" . $nCurrentPage . "','" . $tASTDocNo . "')";
                                }

                                if ($aValue['FTAjhStaDoc'] == 3) {
                                    $tNewProcess =  language('document/adjuststock/adjuststock', 'tASTStaDoc3'); //ยกเลิก
                                    $tClassStaDoc = 'text-danger';
                                } else {
                                    if ($aValue['FTAjhStaApv'] == 1) {
                                        $tNewProcess =  language('document/adjuststock/adjuststock', 'tASTStaApv1'); //อนุมัติแล้ว
                                        $tClassStaDoc = 'text-success';
                                    } else {
                                        $tNewProcess = language('document/adjuststock/adjuststock', 'tASTStaApv'); //รออนุมัติ
                                        $tClassStaDoc = 'text-warning';
                                    }
                                }

                                // เช็ค Text Color FTAjhStaPrcStk
                                if ($aValue['FTAjhStaPrcStk'] == 1) {
                                    $tClassPrcStk = 'text-success';
                                } else if ($aValue['FTAjhStaPrcStk'] == 2) {
                                    $tClassPrcStk = 'text-warning';
                                } else if ($aValue['FTAjhStaPrcStk'] == '') {
                                    $tClassPrcStk = 'text-warning';
                                } else {
                                    $tClassPrcStk = "";
                                }



                                ?>
                                <tr id="otrAdjustStock<?php echo $nKey ?>" class="text-center xCNTextDetail2 otrAdjustStock" data-code="<?php echo $aValue['FTAjhDocNo'] ?>" data-name="<?php echo $aValue['FTAjhDocNo'] ?>">
                                    <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                        <td class="text-center">
                                            <label class="fancy-checkbox ">
                                                <input id="ocbListItem<?php echo $nKey ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled; ?>>
                                                <span class="<?php echo $tClassDisabled ?>">&nbsp;</span>
                                            </label>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-left"><?php echo (!empty($aValue['FTBchName'])) ? $aValue['FTBchName'] : '-' ?></td>
                                    <td class="text-left"><?php echo (!empty($aValue['FTAjhDocNo'])) ? $aValue['FTAjhDocNo'] : '-' ?></td>
                                    <td class="text-left"><?php echo (!empty($aValue['FDAjhDocDate'])) ? $aValue['FDAjhDocDate'] : '-' ?></td>
                                    <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tNewProcess; ?></label></td>

                                    <td class="text-left">
                                        <label class="xCNTDTextStatus <?php echo $tClassPrcStk; ?>"><?php echo language('document/adjuststock/adjuststock', 'tASTStaPrcStk' . $aValue['FTAjhStaPrcStk']) ?></label>
                                    </td>
                                    <td class="text-left">
                                        <?php echo (!empty($aValue['FTCreateByName'])) ? $aValue['FTCreateByName'] : '-' ?>
                                    </td>
                                    <td class="text-left">
                                        <?php echo (!empty($aValue['FTAjhApvName'])) ? $aValue['FTAjhApvName'] : '-' ?>
                                    </td>
                                    <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                        <td>
                                            <img class="xCNIconTable xCNIconDel <?php echo $tClassDisabled ?>" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" <?php echo $tOnclick ?> title="<?php echo $tTitle ?>">
                                        </td>
                                    <?php endif; ?>
                                    <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                        <td>
                                            <?php if ($aValue['FTAjhStaApv'] == 1 || $aValue['FTAjhStaDoc'] == 3) { ?>
                                                <img class="xCNIconTable" style="width: 17px;" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvASTCallPageEdit('<?php echo $aValue['FTAjhDocNo'] ?>')">
                                            <?php } else { ?>
                                                <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvASTCallPageEdit('<?php echo $aValue['FTAjhDocNo'] ?>')">
                                            <?php } ?>
                                            <!-- <img class="xCNIconTable xCNIconEdit" onClick="JSvASTCallPageEdit('<?php echo $aValue['FTAjhDocNo'] ?>')"> -->
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;
                        } else { ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aDataList['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataList['rnCurrentPage'] ?> / <?php echo $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageASTPdt btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvASTClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>

            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <button onclick="JSvASTClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvASTClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<!-- ===================================================== Modal Delete Document Single ===================================================== -->
<div id="odvASTModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmASTConfirmPdtDTTemp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================================================================================================== -->

<!-- ===================================================== Modal Delete Document Multiple =================================================== -->
<div id="odvASTModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================================================================================================== -->
<?php include('script/jAdjustStockDataTable.php'); ?>