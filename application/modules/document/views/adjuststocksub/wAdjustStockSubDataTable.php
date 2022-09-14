<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBChoose') ?></th>
                        <?php endif; ?>
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBBchCreate') ?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBDocNo') ?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBDocDate') ?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBStaDoc') ?></th>
                        <!-- <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBStaApv') ?></th> -->
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBStaPrc') ?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBCreateBy') ?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubTBApvBy') ?></th>
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionDelete') ?></th>
                        <?php endif; ?>
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionEdit/View') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <?php
                            $tXthDocNo = $aValue['FTAjhDocNo'];
                            if ($aValue['FTAjhStaApv'] == 1 || $aValue['FTAjhStaDoc'] == 3) {
                                $CheckboxDisabled = "disabled";
                                $ClassDisabled = 'xCNDocDisabled';
                                $Title = language('document/document/document', 'tDOCMsgCanNotDel');
                                $Onclick = '';
                            } else {
                                $CheckboxDisabled = "";
                                $ClassDisabled = '';
                                $Title = '';
                                $Onclick = "onclick=JSnAdjStkSubDel('" . $nCurrentPage . "','" . $tXthDocNo . "')";
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

                            //FTAjhStaPrcStk
                            if ($aValue['FTAjhStaPrcStk'] == 1) {
                                $tClassPrcStk = 'text-success';
                            } else if ($aValue['FTAjhStaPrcStk'] == 2) {
                                $tClassPrcStk = 'text-warning';
                            } else if ($aValue['FTAjhStaPrcStk'] == 0 || $aValue['FTAjhStaPrcStk'] == '') {
                                $tClassPrcStk = 'text-warning';
                            }

                            if ($aValue['FTAjhApvCode'] == "") {
                                $tApvCode = language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaApv');
                            } else {
                                $tApvCode = $aValue['FTAjhApvName'];
                            }
                            ?>
                            <tr class="text-center xCNTextDetail2 otrPurchaseoeder" id="otrPurchaseoeder<?= $key ?>" data-code="<?= $aValue['FTAjhDocNo'] ?>" data-name="<?= $aValue['FTAjhDocNo'] ?>">
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?= $CheckboxDisabled ?>>
                                            <span class="<?= $ClassDisabled ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td class="text-left"><?php echo $aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                                <td class="text-left"><?php echo $aValue['FTAjhDocNo'] != '' ? $aValue['FTAjhDocNo'] : '-' ?></td>
                                <td class="text-center"><?php echo $aValue['FDAjhDocDate'] != '' ? $aValue['FDAjhDocDate'] : '-' ?></td>
                                <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tNewProcess; ?></label></td>
                                <!-- <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaApv ?>"><?= language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaApv' . $aValue['FTAjhStaApv']) ?></label></td> -->
                                <td class="text-left"><label class="xCNTDTextStatus <?= $tClassPrcStk ?>"><?php echo language('document/adjuststocksub/adjuststocksub', 'tAdjStkSubStaPrcStk' . $aValue['FTAjhStaPrcStk']) ?></label></td>
                                <td class="text-left"><?php echo $aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : '-' ?></td>
                                <td class="text-left"><?= $tApvCode ?></td>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td>
                                        <img class="xCNIconTable xCNIconDel <?= $ClassDisabled ?>" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" <?= $Onclick ?> title="<?= $Title ?>">
                                    </td>
                                <?php endif; ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td>
                                        <?php if ($aValue['FTAjhStaApv'] == 1 || $aValue['FTAjhStaDoc'] == 3) { ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvCallPageAdjStkSubEdit('<?= $aValue['FTAjhDocNo'] ?>')">
                                        <?php } else { ?>
                                            <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageAdjStkSubEdit('<?= $aValue['FTAjhDocNo'] ?>')">
                                        <?php } ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvAdjStkSubClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
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
                <button onclick="JSvAdjStkSubClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvAdjStkSubClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDel">
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
                <!-- แก้ -->
                <button id="osmConfirm" onClick="JSnAdjStkSubDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
                <!-- แก้ -->
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function() {
        var nCode = $(this).parent().parent().parent().data('code'); //code
        var tName = $(this).parent().parent().parent().data('name'); //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if (LocalItemData) {
            obj = JSON.parse(LocalItemData);
        } else {}
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert == '' || aArrayConvert == null) {
            obj.push({
                "nCode": nCode,
                "tName": tName
            });
            localStorage.setItem("LocalItemData", JSON.stringify(obj));
            JSxTextinModal();
        } else {
            var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxTextinModal();
            } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i].nCode == nCode) {
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for ($i = 0; $i < nLength; $i++) {
                    if (aArrayConvert[0][$i] != undefined) {
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData", JSON.stringify(aNewarraydata));
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    });
</script>