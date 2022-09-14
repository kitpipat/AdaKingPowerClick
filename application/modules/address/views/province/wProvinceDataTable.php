<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}
?>

<?php
// echo '<pre>';
// echo print_r($aAlwEventProvince); 
// echo '</pre>';
?>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <input type="hidden" id="nCurrentPageTB" value="<?= $nCurrentPage; ?>">
        <div class="table-responsive">
            <table id="otbPvnDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if ($aAlwEventProvince['tAutStaFull'] == 1 || $aAlwEventProvince['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center" style="width:10%;"><?php echo language('address/province/province', 'tPVNTBChoose') ?></th>
                        <?php endif; ?>
                        <th nowrap class="text-center" style="width:10%;"><?php echo language('address/province/province', 'tPVNTBCode') ?></th>
                        <th nowrap class="text-center"><?php echo language('address/province/province', 'tPVNTBName') ?></th>
                        <!-- <th nowrap class="text-center"><?php echo language('address/province/province', 'tPVNZNEName') ?></th> -->
                        <?php if ($aAlwEventProvince['tAutStaFull'] == 1 || $aAlwEventProvince['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center" style="width:10%;"><?php echo language('address/province/province', 'tPVNTBDelete') ?></th>
                        <?php endif; ?>
                        <?php if ($aAlwEventProvince['tAutStaFull'] == 1 || ($aAlwEventProvince['tAutStaEdit'] == 1 || $aAlwEventProvince['tAutStaRead'] == 1)) : ?>
                            <th nowrap class="text-center" style="width:10%;"><?php echo language('address/province/province', 'tPVNTBEdit') ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $nKey => $aValue) : ?>
                            <tr class="text-center xWProvince" id="otrProvince<?php echo $nKey ?>" data-code="<?php echo $aValue['rtPvnCode'] ?>" data-name="<?php echo $aValue['rtPvnName'] ?>">
                                <?php if ($aAlwEventProvince['tAutStaFull'] == 1 || $aAlwEventProvince['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?php echo $nKey ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap><?php echo  $aValue['rtPvnCode'] ?></td>
                                <td nowrap class="text-left"><?php echo  $aValue['rtPvnName'] ?></td>
                                <!-- <td nowrap class="text-left"><?php echo  $aValue['rtZneName'] ?></td> -->
                                <?php if ($aAlwEventProvince['tAutStaFull'] == 1 || $aAlwEventProvince['tAutStaDelete'] == 1) : ?>
                                    <td nowrap>
                                        <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSnProvinceDel('<?php echo $nCurrentPage ?>','<?php echo $aValue['rtPvnName'] ?>','<?php echo $aValue['rtPvnCode'] ?>')">
                                    </td>
                                <?php endif; ?>
                                <?php if ($aAlwEventProvince['tAutStaFull'] == 1 || ($aAlwEventProvince['tAutStaEdit'] == 1 || $aAlwEventProvince['tAutStaRead'] == 1)) : ?>
                                    <td nowrap>
                                        <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageProvinceEdit('<?php echo $aValue['rtPvnCode'] ?>')">
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center' colspan='99'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main', 'tResultTotalRecord') ?> <?php echo $aDataList['rnAllRow'] ?> <?php echo language('common/main/main', 'tRecord') ?> <?php echo language('common/main/main', 'tCurrentPage') ?> <?php echo $aDataList['rnCurrentPage'] ?> / <?php echo $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageProvince btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvProvinceClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvProvinceClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvProvinceClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelProvince">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" onClick="JSoProvinceDelChoose('<?php echo $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm') ?>
                </button>
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
            JSxPaseCodeDelInModal();
        } else {
            var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxPaseCodeDelInModal();
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
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>