<?php
if ($aDataList['rtCode'] == '1') {
    $nCurrentPage   = $aDataList['rnCurrentPage'];
} else {
    $nCurrentPage   = '1';
}
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbCPHTblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('document/couponsetup/couponsetup', 'tCPHTBChoose') ?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHTBBchCreate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHTBDocNo')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHLabelFrmCptName')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHTBDocDate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHTBStatusDoc')?></th>
                        
                        <th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','สถานะคูปอง')?></th>

						<th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHTUserCreate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/couponsetup/couponsetup','tCPHTUserAppove')?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('common/main/main','tCMNActionDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) : ?>
						    <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $nKey => $aValue) : ?>
                            <?php
                                $tCPHDocNo  = $aValue['FTCphDocNo'];
                                if(!empty($aValue['FTCphStaApv']) || $aValue['FTCphStaDoc'] == 3){
                                    $tCheckboxDisabled  = "disabled";
                                    $tClassDisabled     = 'xCNDocDisabled';
                                    $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                    $tOnclick           = '';
                                }else{
                                    $tCheckboxDisabled  = "";
                                    $tClassDisabled     = '';
                                    $tTitle             = '';
                                    $tOnclick           = "onclick=JSoCPHDelDocSingle('".$nCurrentPage."','".$tCPHDocNo."')";
                                }

                                if($aValue['FTCphStaDoc'] == 3){
                                    $tClassStaDoc   = 'text-danger';
                                    $tStaDoc = language('document/couponsetup/couponsetup','tCPHStaDoc3');
                                }else if($aValue['FTCphStaApv'] == 1){
                                    $tClassStaDoc   = 'text-success';
                                    $tStaDoc = language('document/couponsetup/couponsetup','tCPHStaDoc1');   
                                }else{
                                    $tClassStaDoc   = 'text-warning';
                                    $tStaDoc = language('document/couponsetup/couponsetup','tCPHStaDoc');
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 xWCPHDocItems" id="otrCouponSetUp<?php echo $nKey ?>" data-code="<?php echo $aValue['FTCphDocNo'] ?>" data-name="<?php echo $aValue['FTCphDocNo'] ?>">
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?php echo $nKey ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled; ?>>
                                            <span class="<?php echo $tClassDisabled ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTBchName'])) ? $aValue['FTBchName'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTCphDocNo'])) ? $aValue['FTCphDocNo'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTCpnName'])) ? $aValue['FTCpnName'] : '-' ?></td>
                                <td nowrap class="text-center"><?php echo (!empty($aValue['FDCphDocDate'])) ? $aValue['FDCphDocDate'] : '-' ?></td>
                                <td nowrap class="text-left">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>">
                                        <?php echo $tStaDoc ?>
                                    </label>
                                </td>
                                <?php   
                                $tStaCurlogAct = '';
                                $tClassStaAtv = '';
                                if ($aValue['FDCphDateStop'].' '. $aValue['FTCphTimeStop'] < date('Y-m-d H:i:s')) {
                                    $tStaCurlogAct     = language('authen/user/user', 'tUsrExpired');
                                    $tClassStaDoc   = 'text-danger';
                                }else{
                                    if($aValue['FTCPHStaClosed'] == 1){
                                        if($aValue['FTCphStaDoc'] == 3){
                                            $tClassStaDoc   = 'text-danger';
                                            $tStaCurlogAct = language('document/couponsetup/couponsetup','tCPHStaDoc3');
                                        }else if($aValue['FTCphStaApv'] == 1){
                                            $tClassStaDoc   = 'text-success';
                                            $tStaCurlogAct = language('document/couponsetup/couponsetup','tCPHStaDocUse');   
                                        }else{
                                            $tClassStaDoc   = 'text-warning';
                                            $tStaCurlogAct = language('document/couponsetup/couponsetup','tCPHStaDoc');
                                        }
                                    }else{
                                        $tClassStaDoc   = 'text-danger';
                                        $tStaCurlogAct  = language('document/couponsetup/couponsetup','tCPHLabelFrmCouponStaClosed');
                                    }
                                }
                                ?>
                                <td nowrap class="text-center">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaDoc?>">
                                    <?php echo $tStaCurlogAct ?>
                                    </label>
                                </td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTUsrNameIns'])) ? $aValue['FTUsrNameIns'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTUsrNameApv'])) ? $aValue['FTUsrNameApv'] : '-' ?></td>

                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap>
                                        <img class="xCNIconTable xCNIconDel <?php echo $tClassDisabled ?>" src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>" <?php echo $tOnclick ?> title="<?php echo $tTitle ?>">
                                    </td>
                                <?php endif; ?>

                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td>
                                        <?php if ($aValue['FTCphStaApv'] == 1 || $aValue['FTCphStaDoc'] == 3) { ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvCPHCallPageEditDocument('<?= $aValue['FTCphDocNo'] ?>')">
                                        <?php } else { ?>
                                            <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCPHCallPageEditDocument('<?= $aValue['FTCphDocNo'] ?>')">
                                        <?php } ?>
                                    </td>
                                <?php endif; ?>
                            <tr>
                            <?php endforeach; ?>
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
        <div class="xWCPHPageDataTable btn-toolbar pull-right">
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvCPHClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvCPHClickPageList('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>

            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvCPHClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>
<!-- ===================================================== Modal Delete Document Single ===================================================== -->
<div id="odvCPHModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ======================================================================================================================================== -->

<!-- ===================================================== Modal Delete Document Multiple =================================================== -->
<div id="odvCPHModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
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

<script type="text/javascript">
    $(document).ready(function() {
        $('.ocbListItem').unbind().click(function() {
            var nCode = $(this).parents('xWCPHDocItems').data('code'); //code
            var tName = $(this).parents('xWCPHDocItems').data('name'); //code
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
                JSxCPHTextinModal();
            } else {
                var aReturnRepeat = JStCPHFindObjectByKey(aArrayConvert[0], 'nCode', nCode);
                if (aReturnRepeat == 'None') { //ยังไม่ถูกเลือก
                    obj.push({
                        "nCode": nCode,
                        "tName": tName
                    });
                    localStorage.setItem("LocalItemData", JSON.stringify(obj));
                    JSxCPHTextinModal();
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
                    JSxCPHTextinModal();
                }
            }
            JSxCPHShowButtonChoose();
        });

        $('#odvCPHModalDelDocMultiple #osmConfirmDelMultiple').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JSoCPHDelDocMultiple();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
    });
</script>