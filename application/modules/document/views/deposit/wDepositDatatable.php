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
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('document/deposit/deposit', 'tTBChoose') ?></th>
                        <?php } ?>
                        <th class="xCNTextBold"><?= language('document/deposit/deposit', 'tTBBchCreate') ?></th>
                        <th class="xCNTextBold"><?= language('document/deposit/deposit', 'tTBDocNo') ?></th>
                        <th class="xCNTextBold"><?= language('document/deposit/deposit', 'tTBDocDate') ?></th>

                        <th nowrap class="xCNTextBold"><?php echo language('document/deposit/deposit','tTBStaDoc')?></th>
                        
                        <!-- <th nowrap class="xCNTextBold"><?php echo language('document/deposit/deposit','tTBStaPrc')?></th> -->

                        <th class="xCNTextBold"><?= language('document/deposit/deposit', 'tTBCreateBy') ?></th>
                        <th class="xCNTextBold"><?= language('document/deposit/deposit', 'tTBApvBy') ?></th>
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionDelete') ?></th>
                        <?php } ?>
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) { ?>
                            <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main', 'tCMNActionEdit') ?></th>
                        <?php } ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) { ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <?php
                            $tDocNo = $aValue['FTBdhDocNo'];
                            if ($aValue['FTBdhStaApv'] == 1 || $aValue['FTBdhStaApv'] == 2 || $aValue['FTBdhStaDoc'] == 3) {
                                $CheckboxDisabled = "disabled";
                                $ClassDisabled = 'xCNDocDisabled';
                                $Title = language('document/document/document', 'tDOCMsgCanNotDel');
                                $Onclick = '';
                            } else {
                                $CheckboxDisabled = "";
                                $ClassDisabled = '';
                                $Title = '';
                                $Onclick = "onclick=JSxDepositDocDel('" . $nCurrentPage . "','" . $tDocNo . "')";
                            }

                            //FTBdhStaDoc
                            if($aValue['FTBdhStaDoc'] == 3){
                                $tClassStaDoc   = 'text-danger';
                                $tStaDoc = language('document/couponsetup/couponsetup','tTFXVDStaDoc3');
                            }else if($aValue['FTBdhStaApv'] == 1){
                                $tClassStaDoc   = 'text-success';
                                $tStaDoc = language('document/couponsetup/couponsetup','tTFXVDStaDoc1');   
                            }else{
                                $tClassStaDoc   = 'text-warning';
                                $tStaDoc = language('document/couponsetup/couponsetup','tTFXVDStaDoc');
                            }

                            //FTBdhStaApv
                            // if ($aValue['FTBdhStaApv'] == 1) {
                            //     $tClassStaApv = 'text-success';
                            // } else if ($aValue['FTBdhStaApv'] == 2) {
                            //     $tClassStaApv = 'text-warning';
                            // } else if ($aValue['FTBdhStaApv'] == '') {
                            //     $tClassStaApv = 'text-danger';
                            // }

                            ?>

                            <tr class="text-center xCNTextDetail2" id="otrDepositHD<?= $key ?>" data-code="<?= $aValue['FTBdhDocNo'] ?>" data-name="<?= $aValue['FTBdhDocNo'] ?>">
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?= $CheckboxDisabled ?>>
                                            <span class="<?= $ClassDisabled ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php } ?>
                                <td class="text-left"><?= $aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                                <td class="text-left"><?= $aValue['FTBdhDocNo'] != '' ? $aValue['FTBdhDocNo'] : '-' ?></td>
                                <td class="text-center"><?= $aValue['FDBdhDate'] != '' ? date('Y-m-d', strtotime($aValue['FDBdhDate'])) : '-' ?></td>


                                <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tStaDoc; ?></label></td>

                                <!-- <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo language('document/deposit/deposit', 'tStaDoc' . $aValue['FTBdhStaDoc']) ?></label></td>
                                <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaApv ?>"><?= language('document/deposit/deposit', 'tStaApv' . $aValue['FTBdhStaApv']) ?></label></td> -->


                                <td class="text-left"><?= $aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : '-' ?></td>
                                <?php
                                $tApvName = language('document/deposit/deposit', 'tNotFound');
                                if ($aValue['FTBdhUsrApv'] != "") {
                                    $tApvName = $aValue['FTXthApvName'];
                                }
                                ?>
                                <td class="text-left"><?php echo $tApvName; ?></td>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                                    <td>
                                        <img class="xCNIconTable xCNIconDel <?= $ClassDisabled ?>" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>" <?= $Onclick ?> title="<?= $Title ?>">
                                    </td>
                                <?php } ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td>
                                        <?php if ($aValue['FTBdhStaApv'] == 1 || $aValue['FTBdhStaDoc'] == 3) { ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvDepositCallPageEdit('<?= $aValue['FTBdhDocNo'] ?>')">
                                        <?php } else { ?>
                                            <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvDepositCallPageEdit('<?= $aValue['FTBdhDocNo'] ?>')">
                                        <?php } ?>
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php } ?>
                    <?php } else { ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvDepositDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvDepositDataTableClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvDepositDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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
                <button id="osmConfirm" onClick="JSxDepositDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?= language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function() {
        var nCode = $(this).parent().parent().parent().data('code'); // code
        var tName = $(this).parent().parent().parent().data('name'); // code
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
            if (aReturnRepeat == 'None') { // ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxTextinModal();
            } else if (aReturnRepeat == 'Dupilcate') { // เคยเลือกไว้แล้ว
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
    })
</script>