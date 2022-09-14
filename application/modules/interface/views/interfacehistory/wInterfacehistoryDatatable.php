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
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr class="xCNCenter">
                        <th><?php echo language('interface/interfacehistory', 'tIFHSequence') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHList') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHType') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHNamefile') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHReference') ?></th>
                        <th style="min-width: 90px;"><?php echo language('interface/interfacehistory', 'tIFHDate') ?></th>
                        <th style="min-width: 80px;"><?php echo language('interface/interfacehistory', 'tIFHTime') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHStatus') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHReportError') ?></th>
                        <th><?php echo language('interface/interfacehistory', 'tIFHRmk') ?></th>
                        <th width="10%"><?php echo language('interface/interfacehistory', 'tIFHBtnDownload'); ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <tr>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                <?php endif; ?>

                                <td nowrap class="text-center"><?= $aValue['FNRowID'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTLogTask'] ?></td>

                                <td nowrap class="text-left">
                                    <?php if ($aValue['FTLogType'] == '1') : ?>
                                        <?php echo language('interface/interfacehistory', 'tIFHImport'); ?>
                                    <?php else : ?>
                                        <?php echo language('interface/interfacehistory', 'tIFHExport'); ?>
                                    <?php endif; ?>
                                </td>

                                <td nowrap class="text-left"><?= $aValue['FTLogTaskRef'] ?></td>
                                <td nowrap class="text-left"><?= $aValue['FTLogRefNo'] ?></td>
                                <td nowrap class="text-center"><?php if($aValue['FDCreateLog']!=""){ echo date('Y-m-d', strtotime($aValue['FDCreateLog'])); } ?></td>
                                <td nowrap class="text-center"><?php if($aValue['FDCreateLog']!=""){ echo date('H:i:s', strtotime($aValue['FDCreateLog'])); } ?></td>
                                <td nowrap class="text-center">
                                    <?php if ($aValue['FTLogStaPrc'] == '1') : ?>
                                        <lable class="xCNTDTextStatus text-success"><?php echo language('interface/interfacehistory', 'tIFHSuccess'); ?></lable>
                                    <?php else : ?>
                                        <lable class="xCNTDTextStatus text-danger"><?php echo language('interface/interfacehistory', 'tIFHFail'); ?></lable>
                                    <?php endif; ?>
                                </td>

                                <td nowrap class="text-center">
                                    <?php if ($aValue['FTLogStaSend'] == '1') : ?>
                                        <lable class="xCNTDTextStatus text-success"><?php echo "ส่งแล้ว"; ?></lable>
                                    <?php else : ?>
                                        <lable class="xCNTDTextStatus text-danger"><?php echo "ยังไม่ส่ง"; ?></lable>
                                    <?php endif; ?>
                                </td>

                                <td class="text-left">
                                    <?php if ($aValue['FTLogStaPrc'] == '2' && $aValue['FTLogType'] == '2') { ?>
                                        <?= $aValue['FTErrDesc']; ?>
                                    <?php } else { ?>
                                        <?= language('interface/interfacehistory', 'tIFHItemNumber'); ?> <?= number_format($aValue['FNLogQtyAll']) ?>
                                        <?= language('interface/interfacehistory', 'tIFHSuccess'); ?> <?= number_format($aValue['FNLogQtyDone']) ?>
                                        <?= language('interface/interfacehistory', 'tIFHUnsuccess'); ?>
                                        <?php $nCountUnSuccess = $aValue['FNLogQtyAll'] - $aValue['FNLogQtyDone']; ?>
                                        <?= number_format($nCountUnSuccess) ?>
                                    <?php } ?>
                                </td>

                                <td nowrap class="text-center">
                                    <?php
                                    // if($aValue['FTInfFile'] == '' || $aValue['FTStaDone'] == '2'){
                                    //     $tDisableButton = "disabled";
                                    // }else{
                                    //     $tDisableButton = "";
                                    // }
                                    if($nStaPathServerFile==1){
                                        $tUrlDownLoadFile = $tPathFile.$aValue['FTLogTaskRef'];
                                    }else{
                                        $tUrlDownLoadFile = base_url().'application\modules\interface\views\interfacehistory\wInterfacehistoryDownload.php?ptFile='.base64_encode($aValue['FTLogTaskRef']).'&ptPath='.base64_encode($tPathFile);
                                    }

                                    ?>
                                    <a href="<?=$tUrlDownLoadFile?>" target="_blank">
                                        <?php if ($aValue['FTLogType'] == 1) { ?>
                                            <button type="button" class="btn btn-primary xWIFXBtnDownload"><?php echo language('interface/interfacehistory', 'tIFHBtnDownload'); ?></button>
                                        <?php } else { ?>
                                        <?php } ?>
                                    </a>
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='11'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWCDCPaging btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabled = 'disabled';
            } else {
                $tDisabled = '-';
            } ?>
            <button onclick="JSvCPNClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabled ?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

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
                <button onclick="JSvCPNClickPage('<?= $i ?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabled = 'disabled';
            } else {
                $tDisabled = '-';
            } ?>
            <button onclick="JSvCPNClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabled ?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelBookBank">
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
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnCreditcardDelChoose('<?= $nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    $('ducument').ready(function() {
        JSxShowButtonChoose();
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        var nlength = $('#odvRGPList').children('tr').length;
        for ($i = 0; $i < nlength; $i++) {
            var tDataCode = $('#otrCreditcard' + $i).data('code')
            if (aArrayConvert == null || aArrayConvert == '') {} else {
                var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCode', tDataCode);
                if (aReturnRepeat == 'Dupilcate') {
                    $('#ocbListItem' + $i).prop('checked', true);
                } else {}
            }
        }

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
    });
</script>
