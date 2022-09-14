<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage = '1';
}

?>


<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?= $nCurrentPage; ?>">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:3%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcChoose') ?></th>
                        <th nowrap class="xCNTextBold" style="width:50%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnectionType') ?></th>
                        <th nowrap class="xCNTextBold" style="width:3%;text-align:center;"><?= language('payment/recivespc/recivespc', 'tRcvSpcDelete') ?></th>
                        <th nowrap class="xCNTextBold" style="width:3%;text-align:center;"><?= language('payment/recivespc/recivespc', 'tRcvSpcEdit') ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <input type="hidden" id="ohdRevCodeDel" name="ohdRevCodeDel" value="<?php echo $FTRcvCode; ?>">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php if (!empty($aDataList['raItems'])) { ?>
                            <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                                <?php $nChkDel = $this->mReciveSpcCfg->FSaMRCVSPCChkDelete($FTRcvCode, $aValue['FNRcvSeq']);
                                if ($nChkDel > 0) {
                                    $tDisDel = 'xCNDocDisabled';
                                    $tDisDelChk = 'disabled';
                                    $tClassDel = '';
                                } else {
                                    $tDisDel = '';
                                    $tDisDelChk = '';
                                    $tClassDel = 'xWRcvSpcCfgEventDelSingle';
                                }
                                ?>
                                <tr class="text-center xCNTextDetail2 xWRcvSpcItems" data-rcvcode="<?php echo $FTRcvCode; ?>" data-rcvseq="<?php echo $aValue['FNRcvSeq']; ?>">
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input <?php echo $tDisDelChk; ?> id="ocbListItemCfg<?= $key ?>" type="checkbox" class="ocbListItemCfg" name="ocbListItemCfg[]">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                    <td nowrap class="text-left xWTdBody"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection') ?> <?= $aValue['FNRcvSeq']; ?></td>


                                    <td nowrap class="text-center ">
                                        <img class="xCNIconTable xWImgDisable <?php echo $tClassDel; ?>  <?php echo $tDisDel; ?>" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>">
                                    </td>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable xWRcvSpcCfgEventEdit" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='12'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>

                </tbody>
            </table>
        </div>
        <div>
        </div>

        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <div class="xWRcbvSpcPaging btn-toolbar pull-right">
                    <?php if ($nPage == 1) {
                        $tDisabledLeft = 'disabled';
                    } else {
                        $tDisabledLeft = '-';
                    } ?>
                    <button onclick="JSvRCVSPCClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabledLeft ?>>
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
                        <button onclick="JSvRCVSPCClickPage('<?= $i ?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i ?></button>
                    <?php } ?>
                    <?php if ($nPage >= $aDataList['rnAllPage']) {
                        $tDisabledRight = 'disabled';
                    } else {
                        $tDisabledRight = '-';
                    } ?>
                    <button onclick="JSvRCVSPCClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabledRight ?>>
                        <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                    </button>
                </div>
            </div>
        </div>

        <!--Modal Delete Mutirecord-->
        <div class="modal fade" id="odvModalDeleteMutirecordCfg">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header xCNModalHead">
                        <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
                    </div>
                    <div class="modal-body">
                        <span id="ospConfirmDeleteCfg"></span>

                    </div>
                    <div class="modal-footer">
                        <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxRCVSpcCfgDeleteMutirecord('<?= $nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
                        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
                    </div>
                </div>
            </div>
        </div>

        <!--Modal Delete Single-->
        <div id="odvModalDeleteSingleCfg" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header xCNModalHead">
                        <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
                    </div>
                    <div class="modal-body">
                        <span id="ospConfirmDeleteCfg"> - </span>
                        <input type='hidden' id="ohdConfirmIDDeleteCfg">
                    </div>
                    <div class="modal-footer">
                        <button id="osmConfirmDeleteCfg" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm') ?></button>
                        <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
                    </div>
                </div>
            </div>
        </div>
        <!--End modal Delete Single-->

        <script>
            // Event Click Delete Single
            $('.xWRcvSpcCfgEventDelSingle').unbind().click(function() {
                let nStaSession = JCNxFuncChkSessionExpired();
                if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                    let aDataWhere = {
                        'ptRcvCode': $(this).parents('.xWRcvSpcItems').data('rcvcode'),
                        'pnRcvSeq': $(this).parents('.xWRcvSpcItems').data('rcvseq')
                    };;
                    JSxRCVSpcCfgDelete(aDataWhere);
                } else {
                    JCNxShowMsgSessionExpired();
                }
            });

            // Event Edit
            $('.xWRcvSpcCfgEventEdit').unbind().click(function() {
                let nStaSession = JCNxFuncChkSessionExpired();
                if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                    let aDataWhereEdit = {
                        'ptRcvCode': $(this).parents('.xWRcvSpcItems').data('rcvcode'),
                        'pnRcvSeq': $(this).parents('.xWRcvSpcItems').data('rcvseq')
                    };
                    JSvCallPageRcvSpcCfgEdit(aDataWhereEdit);
                } else {
                    JCNxShowMsgSessionExpired();
                }
            });

            // Select List Userlogin Table Item
            $(function() {
                $('.ocbListItemCfg').click(function() {
                    // var ptRcvCode = $(this).parents('.xWRcvSpcItems').data('rcvcode'); //code
                    var pnRcvSeq = $(this).parents('.xWRcvSpcItems').data('rcvseq'); //code
                    $(this).prop('checked', true);
                    var LocalItemData = localStorage.getItem("LocalItemData");
                    var obj = [];
                    if (LocalItemData) {
                        obj = JSON.parse(LocalItemData);
                    } else {}
                    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
                    if (aArrayConvert == '' || aArrayConvert == null) {
                        obj.push({
                            // "tRcvCode": ptRcvCode,
                            "nRcvSeq": pnRcvSeq
                        });
                        localStorage.setItem("LocalItemData", JSON.stringify(obj));
                        JSxRCVSPCPaseCodeDelInModalCfg();

                    } else {
                        var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nRcvSeq', pnRcvSeq);
                        if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                            obj.push({
                                // "tRcvCode": ptRcvCode,
                                "nRcvSeq": pnRcvSeq
                            });
                            localStorage.setItem("LocalItemData", JSON.stringify(obj));
                            JSxRCVSPCPaseCodeDelInModalCfg();

                        } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                            localStorage.removeItem("LocalItemData");
                            $(this).prop('checked', false);
                            var nLength = aArrayConvert[0].length;
                            for ($i = 0; $i < nLength; $i++) {
                                if (aArrayConvert[0][$i].nRcvSeq == pnRcvSeq) {
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
                            JSxRCVSPCPaseCodeDelInModalCfg();
                        }
                    }
                    JSxRCVSPCShowButtonChoose();
                });
            });
        </script>