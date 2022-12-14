<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="text-center" id="othCheckboxHide" width="3%">
                            <label class="fancy-checkbox">
                                <input id="ocbCheckAll" type="checkbox" class="ocmCENCheckDeleteAll" name="ocbCheckAll" style="margin-right: 0px !important">
                                <span class=""></span>
                            </label>
                        </th>
                        <th class="xCNTextBold text-center" style="width:17%;"><?php echo language('product/settingprinter/settingprinter', 'tSPTBCode') ?></th>
                        <th class="xCNTextBold text-center" style="width:60%;"><?php echo language('product/settingprinter/settingprinter', 'tSPTBName') ?></th>
                        <th class="xCNTextBold text-center" style="width:10%;"><?php echo language('product/settingprinter/settingprinter', 'tSPTBStatus') ?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?php echo language('product/settingprinter/settingprinter', 'tSPTBDelete') ?></th>
                        <th class="xCNTextBold text-center" style="width:5%;"><?php echo language('product/settingprinter/settingprinter', 'tSPTBEdit') ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <tr class="text-center xCNTextDetail2 otrSrvPri" id="otrSrvPri<?= $key ?>" data-code="<?= $aValue['rtPrnSrvCode'] ?>" data-name="<?= $aValue['rtPrnSrvName'] ?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onchange="JSxSrvPriVisibledDelAllBtn(this, event)">
                                        <span></span>
                                    </label>
                                </td>
                                <td class="text-left otdSrvPriCode" data-agncode="<?= $aValue['rtPrnSrvAgnCode']?>"><?= $aValue['rtPrnSrvCode'] ?></td>
                                <td class="text-left otdSrvPriName"><?= $aValue['rtPrnSrvName'] ?></td>
                                <?php
                                    $tSrvPriSta = '';
                                    if ($aValue['rtPrnSrvSta'] == 1) {
                                        $tSrvPriSta = language('product/settingprinter/settingprinter', 'tSPTBActive1');
                                    } else {
                                        $tSrvPriSta = language('product/settingprinter/settingprinter', 'tSPTBActive2');
                                    }
                                ?>
                                <td class="text-left"><?php echo $tSrvPriSta;  ?></td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSaSrvPriDelete(this, event)" title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBDelete'); ?>">
                                </td>
                                <td>
                                    <img class="xCNIconTable" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageSrvPriEdit('<?= $aValue['rtPrnSrvCode'] ?>','<?=$aValue['rtPrnSrvAgnCode']?>')" title="<?php echo language('customer/customerGroup/customerGroup', 'tCstGrpTBEdit'); ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='7'><?php echo language('product/settingprinter/settingprinter', 'tLPRTNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- ????????????????????? -->
    <div class="col-md-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <!-- ????????????????????? -->
    <div class="col-md-6">
        <div class="xWPageSrvPri btn-toolbar pull-right">
            <!-- ????????????????????????????????? Class ?????????????????????????????????????????????????????? -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvSrvPriClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <!-- ????????????????????????????????? Onclick ?????????????????????????????????????????????????????? -->
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for ($i = max($nPage - 2, 1); $i <= max(0, min($aDataList['rnAllPage'], $nPage + 2)); $i++) { ?>
                <!-- ????????????????????????????????? Parameter Loop ?????????????????????????????????????????????????????? -->
                <?php
                if ($nPage == $i) {
                    $tActive = 'active';
                    $tDisPageNumber = 'disabled';
                } else {
                    $tActive = '';
                    $tDisPageNumber = '';
                }
                ?>
                <!-- ????????????????????????????????? Onclick ?????????????????????????????????????????????????????? -->
                <button onclick="JSvSrvPriClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvSrvPriClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- ????????????????????????????????? Onclick ?????????????????????????????????????????????????????? -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<script type="text/javascript">
    $('ducument').ready(function() {});
</script>