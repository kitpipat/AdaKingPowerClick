<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <!-- <th class="xCNTextBold text-center" style="width:5%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBChoose') ?></th>-->
                        <th class="text-center" id="othCheckboxHide" width="3%">
                            <label class="fancy-checkbox">
                                <input id="ocbCheckAll" type="checkbox" class="ocmCENCheckDeleteAll" name="ocbCheckAll" style="margin-right: 0px !important">
                                <span class=""></span>
                            </label>
                        </th>
                        <th class="xCNTextBold text-center" style="width:20%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBCode') ?></th>
                        <th class="xCNTextBold text-center" style="width:30%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBName') ?></th>
                        <th class="xCNTextBold text-center" style="width:30%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBLableFormat') ?></th>
                        <!-- <th class="xCNTextBold text-center" style="width:20%;">อ้างอิงพอร์ต</th> -->
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBStatus') ?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBDelete') ?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?php echo language('product/settingprinter/settingprinter', 'tLPTBEdit') ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <tr class="text-center xCNTextDetail2 otrLabPri" id="otrLabPri<?= $key ?>" data-code="<?= $aValue['rtPrnLabCode'] ?>" data-name="<?= $aValue['rtPrnLabName'] ?>" data-agn="<?= $aValue['FTAgnCode'] ?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem  xWCheckBox_<?=$aValue['FTAgnCode']?>_<?=$aValue['rtPrnLabCode']?>" name="ocbListItem[]" onchange="JSxLabPriVisibledDelAllBtn(this, event)">
                                        <span></span>
                                    </label>
                                </td>
                                <td class="text-left otdLabPriCode"><?= $aValue['rtPrnLabCode'] ?></td>
                                <td class="text-left otdLabPriName"><?= $aValue['rtPrnLabName'] ?></td>
                                <td class="text-left otdLabPriName"><?= $aValue['rtLabFrtName'] ?></td>
                                <!-- <td class="text-left otdLabPriName"><?= $aValue['rtPortPrnName'] ?></td>
                                <td class="text-left otdLabPriName"><?= $aValue['rtLabFrtName'] ?></td> -->
                                <?php
                                $tLabPriSta = '';
                                if ($aValue['rtPrnLabSta'] == 1) {
                                    $tLabPriSta = language('product/settingprinter/settingprinter', 'tLPTBActive1');
                                } else {
                                    $tLabPriSta = language('product/settingprinter/settingprinter', 'tLPTBActive2');
                                }
                                ?>
                                <td class="text-left"><?php echo $tLabPriSta;  ?></td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSaLabPriDelete(this,'<?= $aValue['FTAgnCode'] ?>')" title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBDelete'); ?>">
                                </td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageLabPriEdit('<?= $aValue['rtPrnLabCode'] ?>','<?= $aValue['FTAgnCode'] ?>')" title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBEdit'); ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='6'><?php echo language('product/settingprinter/settingprinter', 'tLPRTNotFoundData') ?></td>
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
        <div class="xWPageLabPri btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvLabPriClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvLabPriClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvLabPriClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
    // $('ducument').ready(function() {});
    $(function() {

        $('.ocbListItem').click(function() {
            var tAgnCode = $(this).parent().parent().parent().data('agn'); // Agncode
            var nCode = $(this).parent().parent().parent().data('code'); //code
            var tName = $(this).parent().parent().parent().data('name'); //code

            var tCode = tAgnCode+","+nCode;

            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if (LocalItemData) {
                obj = JSON.parse(LocalItemData);
            } else {}
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if (aArrayConvert == '' || aArrayConvert == null) {
                obj.push({
                    "nCode": tCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            } else {
                var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', tCode);
                if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                    obj.push({
                        "nCode": tCode,
                        "tName": tName
                    });
                    localStorage.setItem("LocalItemData", JSON.stringify(obj));
                    JSxPaseCodeDelInModal();
                } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i].nCode == tCode) {
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
        });

    });
</script>