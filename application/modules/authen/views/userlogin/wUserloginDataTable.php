<style>
    .xWCurLogActive {
        color: #007b00 !important;
        font-weight: bold;
        font-size: 10px;
        cursor: default;
    }
    .xWCurLogInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }
    .xWCurLogResetPassword {
        color: #0081c2 !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }
    .xWCurLogEx {
        color: red !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }
</style>

<?php

use BaconQrCode\Common\EcBlock;

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
            <table class="table table-striped xCNUserLogin" style="width:100%">
                <thead>
                    <tr>
                        <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || $aAlwEventUsrlogin['tAutStaDelete'] == 1) : 
                        ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUsrlogChoose') ?></th>
                        <?php //endif; 
                        ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUsrloginAcc') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tUsrloginPwd') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tDateStart') ?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('authen/user/user', 'tDateStop') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tLoginType') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('authen/user/user', 'tStatusUse') ?></th>

                        <!--BTN Edit-->
                        <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || $aAlwEventUsrlogin['tAutStaDelete'] == 1):
                        ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('authen/user/user', 'tUSRTBDelete') ?></th>
                        <?php //endif; 
                        ?>
                        <!--BTN Delete-->
                        <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || ($aAlwEventUsrlogin['tAutStaEdit'] == 1 || $aAlwEventUsrlogin['tAutStaRead'] == 1)):
                        ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('authen/user/user', 'tUSRTBEdit') ?></th>
                        <?php //endif; 
                        ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                            <tr class="text-center xCNTextDetail2" data-codekey="<?=$aValue['FTUsrLogin'].$aValue['FTUsrLogType']?>" data-code="<?= $aValue['FTUsrLogin'] ?>" data-typeusrlogin="<?=$aValue['FTUsrLogType']?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input 
                                            id="ocbListItem<?= $key ?>" 
                                            type="checkbox" 
                                            class="ocbListItem" 
                                            name="ocbListItem[]" 
                                            ohdUsrLogin = "<?= $aValue['FTUsrLogin']; ?>"
                                            ohdConfirmUsrCodeDelete="<?= $aValue['FTUsrCode']; ?>" 
                                            ohdConfirmLogTypeDelete="<?= $aValue['FTUsrLogType']; ?>" 
                                            ohdConfirmPwdStartDelete="<?= $aValue['FDUsrPwdStart']; ?>"
                                            <?php if ($this->session->userdata("tSesUserLogin") == $aValue['FTUsrLogin']){ echo "disabled"; } ?>
                                        >
                                        <span class="<?php if ($this->session->userdata("tSesUserLogin") == $aValue['FTUsrLogin']){ echo "xCNDocDisabled"; } ?>" >&nbsp;</span>
                                    </label>
                                </td>
                                <td nowrap class="text-left xWTdBody"><?= $aValue['FTUsrLogin']; ?></td>
                                <td nowrap class="text-center">*****</td>
                                <td nowrap class="text-center"><?= $aValue['FDUsrPwdStart']; ?></td>
                                <td nowrap class="text-center"><?= $aValue['FDUsrPwdExpired']; ?></td>
                                <?php
                                    switch ($aValue['FTUsrLogType']) {
                                        case 1:
                                            $tStaCurlogType     = language('authen/user/user', 'tTypePwd');
                                            break;
                                        case 2:
                                            $tStaCurlogType     = language('authen/user/user', 'tTypePin');
                                            break;
                                        case 3:
                                            $tStaCurlogType     = language('authen/user/user', 'tTypeRFID');
                                            break;
                                        case 4:
                                            $tStaCurlogType     = language('authen/user/user', 'tTypeQR');
                                            break;
                                        default:
                                            $tStaCurlogType     = language('authen/user/user', 'tTypePwd');
                                    }
                                ?>
                                <td nowrap class="text-left"><?php echo $tStaCurlogType; ?></a></td>

                                <?php
                                    if ($aValue['FDUsrPwdExpired'] . ' 23:59:59' < date('Y/m/d H:i:s')) {
                                        $tStaCurlogAct     = language('authen/user/user', 'tUsrExpired');
                                        $tClassStaAtv   = 'xWCurLogEx';
                                    } else {
                                        switch ($aValue['FTUsrStaActive']) {
                                            case 1:
                                                $tStaCurlogAct     = language('authen/user/user', 'tStaActiveNew1');
                                                $tClassStaAtv   = 'xWCurLogActive';
                                                break;
                                            case 2:
                                                $tStaCurlogAct     = language('authen/user/user', 'tStaActiveNew2');
                                                $tClassStaAtv   = 'xWCurLogInActive';
                                                break;
                                            case 3:
                                                $tStaCurlogAct     = language('authen/user/user', 'tStaActiveNew3');
                                                $tClassStaAtv   = 'xWCurLogResetPassword';
                                                break;
                                            default:
                                                $tStaCurlogAct     = language('authen/user/user', 'tUSRLActive');
                                                $tClassStaAtv   = 'xWCurLogActive';
                                        }
                                    }
                                ?>
                                <td nowrap class="text-left"><a class="<?php echo $tClassStaAtv ?>"><?php echo $tStaCurlogAct; ?></a></td>


                                <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || $aAlwEventUsrlogin['tAutStaDelete'] == 1): 
                                ?>
                                <td nowrap class="text-center">
                                    <?php if ($this->session->userdata("tSesUserLogin") == $aValue['FTUsrLogin']) { ?>
                                        <img class="xCNIconTable xCNDocDisabled" src="<?= base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>">
                                    <?php } else { ?>
                                        <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" onClick="JSxUSRLDelete('<?= $aValue['FTUsrLogin'] ?>','<?= language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>','<?=$aValue['FTUsrLogType']?>')">
                                    <?php } ?>
                                </td>
                                <?php //endif; 
                                ?>
                                <?php //if($aAlwEventUsrlogin['tAutStaFull'] == 1 || ($aAlwEventUsrlogin['tAutStaEdit'] == 1 || $aAlwEventUsrlogin['tAutStaRead'] == 1)) : 
                                ?>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable xWIMGShpShopEdit" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCallPageUserloginEdit('<?= $aValue['FTUsrLogin'] ?>');">
                                </td>
                                <?php //endif; 
                                ?>
                            </tr>
                        <?php } ?>
                    <?php else : ?>
                        <tr>
                            <td class='text-center xCNTextDetail2' colspan='12'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <p><?= language('common/main/main', 'tResultTotalRecord') ?> <?= $aDataList['rnAllRow'] ?> <?= language('common/main/main', 'tRecord') ?> <?= language('common/main/main', 'tCurrentPage') ?> <?= $aDataList['rnCurrentPage'] ?> / <?= $aDataList['rnAllPage'] ?></p>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <div class="xWUSRLPaging btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvUSRLClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabledLeft ?>>
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
                <button onclick="JSvUSRLClickPage('<?= $i ?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvUSRLClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!--Modal Delete Mutirecord-->
<div class="modal fade" id="odvModalDeleteMutirecord">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete"></span>

            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxUSRLDeleteMutirecord('<?= $nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!--Modal Delete Single-->
<div id="odvModalDeleteSingle" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
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
                <button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!--End modal Delete Single-->


<script>
    // Select List Userlogin Table Item
    $(function() {
        $('.ocbListItem').click(function() {
            var nCodeKey    = $(this).parent().parent().parent().data('codekey'); 
            var nCode       = $(this).parent().parent().parent().data('code'); 
            var tName       = $(this).parent().parent().parent().data('name'); 
            var tType       = $(this).parent().parent().parent().data('typeusrlogin'); 
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if (LocalItemData) {
                obj = JSON.parse(LocalItemData);
            } else {}
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if (aArrayConvert == '' || aArrayConvert == null) {
                obj.push({
                    "nCodeKey"  : nCodeKey,
                    "nCode"     : nCode,
                    "tName"     : tName,
                    'tType'     : tType
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxUSRLPaseCodeDelInModal();
            } else {
                var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nCodeKey', nCodeKey);
                if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                    obj.push({
                        "nCodeKey"  : nCodeKey,
                        "nCode"     : nCode,
                        "tName"     : tName,
                        'tType'     : tType
                    });
                    localStorage.setItem("LocalItemData", JSON.stringify(obj));
                    JSxUSRLPaseCodeDelInModal();
                } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for ($i = 0; $i < nLength; $i++) {
                        if (aArrayConvert[0][$i].nCodeKey == nCodeKey) {
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
                    JSxUSRLPaseCodeDelInModal();
                }
            }
            JSxUSRLShowButtonChoose();
        });
    });
</script>