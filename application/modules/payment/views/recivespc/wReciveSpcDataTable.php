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
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcApp') ?></th>
                        <?php if(FCNbGetIsAgnEnabled()){ ?>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvAggGrp') ?></th>
                        <?php } ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRCVSpcBch') ?></th>
                        <?php if(FCNbGetIsShpEnabled()){ ?>
                        <th nowrap class="xCNTextBold" style="width:13%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvMerChant') ?></th>
                        <th nowrap class="xCNTextBold" style="width:13%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvShp') ?></th>
                        <?php } ?>
                        <th nowrap class="xCNTextBold" style="width:13%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvPos') ?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('payment/recivespc/recivespc', 'tRcvSpcConnection') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('payment/recivespc/recivespc', 'tRcvSpcDelete') ?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?= language('payment/recivespc/recivespc', 'tRcvSpcEdit') ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php if (!empty($aDataList['raItems'])) { ?>
                            <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                                <tr class="text-center xCNTextDetail2 xWRcvSpcItems" data-key="<?php echo $key; ?>" data-rcvcode="<?php echo $aValue['FTRcvCode']; ?>" data-rcvname="<?php echo $aValue['FTRcvName']; ?>" data-appcode="<?php echo $aValue['FTAppCode']; ?>" data-appname="<?php echo $aValue['FTAppName']; ?>" data-rcvseq="<?php echo $aValue['FNRcvSeq']; ?>" data-bchcode="<?php echo $aValue['FTBchCode']; ?>" data-mercode="<?php echo $aValue['FTMerCode']; ?>" data-shpcode="<?php echo $aValue['FTShpCode']; ?>" data-aggcode="<?php echo $aValue['FTAggCode']; ?>" data-poscode="<?php echo $aValue['FTPosCode']; ?>">
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                            <span></span>
                                        </label>
                                    </td>
                                    <?php
                                    if ($aValue['FTAppCode'] == '' || $aValue['FTAppCode'] == null) {
                                        $tShowAppName =  language('payment/recivespc/recivespc', 'tRcvSpcAllApp');
                                    } else {
                                        $tShowAppName = $aValue['FTAppName'];
                                    }
                                    if ($aValue['FTAggCode'] == '' || $aValue['FTAggCode'] == null) {
                                        $tShowAgnName = language('payment/recivespc/recivespc', 'tRcvSpcAllAgg');
                                    } else {
                                        $tShowAgnName = $aValue['FTAgnName'];
                                    }
                                    if ($aValue['FTBchCode'] == '' || $aValue['FTBchCode'] == null) {
                                        $tShowBchName = language('payment/recivespc/recivespc', 'tRcvSpcAllBch');
                                    } else {
                                        $tShowBchName = $aValue['FTBchName'];
                                    }
                                    if ($aValue['FTMerCode'] == '' || $aValue['FTMerCode'] == null) {
                                        $tShowMerName = language('payment/recivespc/recivespc', 'tRcvSpcAllMer');
                                    } else {
                                        $tShowMerName = $aValue['FTMerName'];
                                    }
                                    if ($aValue['FTShpCode'] == '' || $aValue['FTShpCode'] == null) {
                                        $tShowShpName = language('payment/recivespc/recivespc', 'tRcvSpcAllShp');
                                    } else {
                                        $tShowShpName = $aValue['FTShpName'];
                                    }
                                    if ($aValue['FTPosCode'] == '' || $aValue['FTPosCode'] == null) {
                                        $tShowPosName = language('payment/recivespc/recivespc', 'tRcvSpcAllPos');
                                    } else {
                                        $tShowPosName = $aValue['FTPosName'];
                                    }
                                    ?>

                                    <td nowrap class="text-left xWTdBody"><?= $tShowAppName; ?></td>
                                    <?php if(FCNbGetIsAgnEnabled()){ ?>
                                    <td nowrap class="text-left xWTdBody"><?= $tShowAgnName; ?></td>
                                    <?php } ?>
                                    <td nowrap class="text-left xWTdBody"><?= $tShowBchName; ?></td>
                                    <?php if(FCNbGetIsShpEnabled()){ ?>
                                    <td nowrap class="text-left xWTdBody"><?= $tShowMerName; ?></td>
                                    <td nowrap class="text-left xWTdBody"><?= $tShowShpName; ?></td>
                                    <?php } ?>
                                    <td nowrap class="text-left xWTdBody"><?= $tShowPosName; ?></td>
                                    <?php if ($aValue['FNRcvSeq'] != '' || $aValue['FNRcvSeq'] != null) {
                                        $tShowRcvSeq =   language('payment/recivespc/recivespc', 'tRcvSpcConnection')  . $aValue['FNRcvSeq'];
                                    } else {
                                        $tShowRcvSeq = '';
                                    } ?>
                                    <td nowrap class="text-left xWTdBody"><?php echo $tShowRcvSeq; ?></td>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable xWRcvSpcEventDelSingle" id="oimListItem<?= $key ?>" src="<?php echo base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>">
                                    </td>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable xWRcvSpcEventEdit" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>">
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
                        <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxRCVSpcDeleteMutirecord('<?= $nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
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
        <script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
        <script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
        <script>
            $(document).ready(function() {
              var nRow = $('.xWRcvSpcItems').valueOf().length;
              var nRowData = $('.xWRcvSpcItems').valueOf().data('key');
              if (nRow==1) {
                $("#ocbListItem"+nRowData+"").prop("disabled",true);
                $("#oimListItem"+nRowData+"").prop("disabled",true);
                $("#oimListItem"+nRowData+"").addClass("xCNDocDisabled");
              }else {
                $("#ocbListItem"+nRowData+"").prop("disabled",false);
                $("#oimListItem"+nRowData+"").prop("disabled",false);
                $("#oimListItem"+nRowData+"").removeClass("xCNDocDisabled");
              }
            });
            // Event Click Delete Single
            $('.xWRcvSpcEventDelSingle').unbind().click(function() {
                var nRowData = $('.xWRcvSpcItems').valueOf().length;
                if (nRowData==1) {

                }else {
                  let nStaSession = JCNxFuncChkSessionExpired();

                  if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                      let aDataWhere = {
                          'ptRcvCode': $(this).parents('.xWRcvSpcItems').data('rcvcode'),
                          'ptRcvName': $(this).parents('.xWRcvSpcItems').data('rcvname'),
                          'ptAppCode': $(this).parents('.xWRcvSpcItems').data('appcode'),
                          'ptAppName': $(this).parents('.xWRcvSpcItems').data('appname'),
                          'pnRcvSeq': $(this).parents('.xWRcvSpcItems').data('rcvseq'),
                          'ptBchCode': $(this).parents('.xWRcvSpcItems').data('bchcode'),
                          'ptMerCode': $(this).parents('.xWRcvSpcItems').data('mercode'),
                          'ptShpCode': $(this).parents('.xWRcvSpcItems').data('shpcode'),
                          'ptAggCode': $(this).parents('.xWRcvSpcItems').data('aggcode'),
                          'ptPosCode': $(this).parents('.xWRcvSpcItems').data('poscode'),
                      };
                      JSxRCVSpcDelete(aDataWhere);
                  } else {
                      JCNxShowMsgSessionExpired();
                  }
                }

            });

            // Event Edit
            $('.xWRcvSpcEventEdit').unbind().click(function() {
                let nStaSession = JCNxFuncChkSessionExpired();
                if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                    let aDataWhereEdit = {
                        'ptRcvCode': $(this).parents('.xWRcvSpcItems').data('rcvcode'),
                        'ptRcvName': $(this).parents('.xWRcvSpcItems').data('rcvname'),
                        'ptAppCode': $(this).parents('.xWRcvSpcItems').data('appcode'),
                        'ptAppName': $(this).parents('.xWRcvSpcItems').data('appname'),
                        'pnRcvSeq': $(this).parents('.xWRcvSpcItems').data('rcvseq'),
                        'ptBchCode': $(this).parents('.xWRcvSpcItems').data('bchcode'),
                        'ptMerCode': $(this).parents('.xWRcvSpcItems').data('mercode'),
                        'ptShpCode': $(this).parents('.xWRcvSpcItems').data('shpcode'),
                        'ptAggCode': $(this).parents('.xWRcvSpcItems').data('aggcode'),
                        'ptPosCode': $(this).parents('.xWRcvSpcItems').data('poscode'),
                    };
                    JSvCallPageRcvSpcEdit(aDataWhereEdit);
                } else {
                    JCNxShowMsgSessionExpired();
                }
            });

            // Select List Userlogin Table Item
            $(function() {
                $('.ocbListItem').click(function() {
                    // var nCode = $(this).parents('.xWRcvSpcItems').data('appcode'); //code
                    // var tName = $(this).parents('.xWRcvSpcItems').data('appname'); //code
                    var nKey = $(this).parents('.xWRcvSpcItems').data('key'); //code
                    $(this).prop('checked', true);
                    var LocalItemData = localStorage.getItem("LocalItemData");
                    var obj = [];
                    if (LocalItemData) {
                        obj = JSON.parse(LocalItemData);
                    } else {}
                    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
                    if (aArrayConvert == '' || aArrayConvert == null) {
                        obj.push({
                            // "nCode": nCode,
                            // "tName": tName
                            "nKey": nKey
                        });
                        localStorage.setItem("LocalItemData", JSON.stringify(obj));
                        JSxRCVSPCPaseCodeDelInModal();

                    } else {
                        var aReturnRepeat = findObjectByKey(aArrayConvert[0], 'nKey', nKey);
                        if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                            obj.push({
                                // "nCode": nCode,
                                // "tName": tName
                                "nKey": nKey
                            });
                            localStorage.setItem("LocalItemData", JSON.stringify(obj));
                            JSxRCVSPCPaseCodeDelInModal();

                        } else if (aReturnRepeat == 'Dupilcate') { //เคยเลือกไว้แล้ว
                            localStorage.removeItem("LocalItemData");
                            $(this).prop('checked', false);
                            var nLength = aArrayConvert[0].length;
                            for ($i = 0; $i < nLength; $i++) {
                                if (aArrayConvert[0][$i].nKey == nKey) {
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
                            JSxRCVSPCPaseCodeDelInModal();
                        }
                    }
                    JSxRCVSPCShowButtonChoose();
                });
            });
        </script>
