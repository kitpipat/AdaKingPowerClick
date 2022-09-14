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
                            <th class="xCNTextBold" style="width:5%;"><?= language('document/promotion/promotion', 'tTBChoose') ?></th>
                        <?php } ?>
                        <th class="xCNTextBold" style="width:10%;"><?= language('document/promotion/promotion', 'tTBBchCreate') ?></th>
                        <th class="xCNTextBold" style="width:10%;"><?= language('document/promotion/promotion', 'tTBDocNo') ?></th>
                        <th class="xCNTextBold" style="width:10%;"><?= language('document/promotion/promotion', 'tTBDocDate') ?></th>
                        <th class="xCNTextBold"><?= language('document/promotion/promotion', 'tPromotionName') ?></th>
                        <th class="xCNTextBold" style="width:10%;"><?= language('document/promotion/promotion', 'tTBStaDoc') ?></th>
                        <!-- <th nowrap class="xCNTextBold" style="width:10%;"><?php echo language('common/main/main', 'tStaPrcDocTitle'); ?></th> -->
                        <!-- <th class="xCNTextBold"><?= language('document/promotion/promotion', 'tTBStaPrc') ?></th> -->
                        <!-- <th class="xCNTextBold"><?= language('document/promotion/promotion', 'tLabel18') ?></th> -->
                        <th class="xCNTextBold" style="width:10%;"><?= language('document/promotion/promotion', 'tTBCreateBy') ?></th>
                        <th class="xCNTextBold" style="width:10%;"><?= language('document/promotion/promotion', 'tTBApvBy') ?></th>
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
                            $tDocNo = $aValue['FTPmhDocNo'];
                            if ($aValue['FTPmhStaApv'] == 1 || $aValue['FTPmhStaApv'] == 2 || $aValue['FTPmhStaDoc'] == 3) {
                                $CheckboxDisabled = "disabled";
                                $ClassDisabled = 'xCNDocDisabled';
                                $Title = language('document/document/document', 'tDOCMsgCanNotDel');
                                $Onclick = '';
                            } else {
                                $CheckboxDisabled = "";
                                $ClassDisabled = '';
                                $Title = '';
                                $Onclick = "onclick=JSxPromotionDocDel('" . $nCurrentPage . "','" . $tDocNo . "')";
                            }

                            // FTPmhStaDoc
                            if ($aValue['FTPmhStaDoc'] == 3) {
                                $tClassStaDoc = 'text-danger';
                                $tStaDoc = language('common/main/main', 'tStaDoc3');
                            } else if ($aValue['FTPmhStaApv'] == 1) {
                                $tClassStaDoc = 'text-success';
                                $tStaDoc = language('common/main/main', 'tStaDoc1');
                            } else {
                                $tClassStaDoc = 'text-warning';
                                $tStaDoc = language('common/main/main', 'tStaDoc');
                            }

                            //StaPrcDoc
                            // if ($aValue['FTPmhStaPrcDoc'] == 1) {
                            //     $tClassPrcStk = 'text-success';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                            // } else if ($aValue['FTPmhStaPrcDoc'] == 2) {
                            //     $tClassPrcStk = 'text-warning';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                            // } else if ($aValue['FTPmhStaPrcDoc'] == 0 || $aValue['FTPmhStaPrcDoc'] == '') {
                            //     $tClassPrcStk = 'text-warning';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                            // }     
                         
                            /*===== Begin UsedStatus ===================================*/
                            if ($aValue['UsedStatus'] == "1") {
                                $tClassStaUse = 'text-warning';
                                $tPmtUsedStatusShow = language('document/promotion/promotion', 'tPausedTemporarily');
                            }

                            if (in_array($aValue['UsedStatus'], ["2","3"])) {
                                $tClassStaUse = 'text-success';
                                if($aValue['UsedStatus'] == "2"){
                                    $tPmtUsedStatusShow = language('document/promotion/promotion', 'tActive');
                                }else{
                                    $tPmtUsedStatusShow = language('document/promotion/promotion', 'tLabel12');
                                }  
                            }

                            if (in_array($aValue['UsedStatus'], ["4","5"])) {
                                $tClassStaUse = 'text-danger';
                                if($aValue['UsedStatus'] == "4"){
                                    $tPmtUsedStatusShow = language('document/promotion/promotion', 'tPmhDateExp');
                                }else{
                                    $tPmtUsedStatusShow = language('document/promotion/promotion', 'tStaDoc3');
                                }
                            }
                            /*===== End UsedStatus =====================================*/

                            // FTPmhStaClosed,FNPmhStaDocAct
                            // if ($aValue['FNPmhStaDocAct'] == 1) {
                            //     if($aValue['FTPmhStaClosed']==0){
                            //         $tClassStaUse = 'text-success';  
                            //         $tPmtStaUseShow = language('document/promotion/promotion', 'tActive');
                            //     }else{
                            //         $tClassStaUse = 'text-warning';
                            //         $tPmtStaUseShow = language('document/promotion/promotion', 'tPausedTemporarily');
                            //     }
                            // } else{
                            //     $tClassStaUse = 'text-danger';
                            //     $tPmtStaUseShow = language('document/promotion/promotion', 'tNotActive');
                            // }

                            // $dPmhDStop= date('Y-m-d',strtotime($aValue['FDPmhDStop']));
                            // $dPmhTStop= date('H:i:s',strtotime($aValue['FDPmhTStop']));
                            // $dPmhExp = date('Y-m-d H:i:s' , strtotime($dPmhDStop.' '.$dPmhTStop));

                            // if(strtotime(date('Y-m-d')) <=  strtotime($dPmhExp)){
                            //     $tClassStaExp = 'text-success';  
                            //     $tPmtStaExpShow = language('document/promotion/promotion', 'tPmhDateNonExp');
                            // }else{
                            //     $tClassStaExp = 'text-danger';  
                            //     $tPmtStaExpShow = language('document/promotion/promotion', 'tPmhDateExp');
                            // }

                            $bIsApvOrCancel = ($aValue['FTPmhStaApv'] == 1 || $aValue['FTPmhStaApv'] == 2) || ($aValue['FTPmhStaDoc'] == 3 );
                            ?>

                            <tr class="text-center xCNTextDetail2" id="otrPromotionHD<?= $key ?>" data-code="<?= $aValue['FTPmhDocNo'] ?>" data-name="<?= $aValue['FTPmhDocNo'] ?>">
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?= $CheckboxDisabled ?>>
                                            <span class="<?= $ClassDisabled ?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php } ?>
                                <td class="text-left"><?= $aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                                <td class="text-left"><?= $aValue['FTPmhDocNo'] != '' ? $aValue['FTPmhDocNo'] : '-' ?></td>
                                <td class="text-center"><?= $aValue['FDCreateOn'] != '' ? date('d/m/Y', strtotime($aValue['FDCreateOn'])) : '-' ?></td>
                                <td class="text-left"><?= $aValue['FTPmhName'] != '' ? $aValue['FTPmhName'] : '-' ?></td>
                                <!-- <td class="text-left">
                                    <label class="xCNTDTextStatus <?= $tClassStaDoc ?>">
                                        <?php echo language('document/promotion/promotion', 'tStaDoc' . $aValue['FTPmhStaDoc']) ?>
                                    </label>
                                </td> -->
                                <td class="text-left">
                                    <label class="xCNTDTextStatus <?= $tClassStaDoc ?>">
                                    <?php echo $tStaDoc ?>
                                    </label>
                                </td>
                                <!-- <td class="text-left">
                                    <label class="xCNTDTextStatus <?= $tClassPrcStk ?>">
                                        <?php echo language('document/promotion/promotion', 'tStaPrcStk' . $aValue['FTPmhStaApv']) ?>
                                    </label>
                                </td> -->
                                <!-- <td class="text-left"><label class="xCNTDTextStatus <?= $tClassPrcStk ?>"><?php echo $tStaPrcDoc; ?></label></td> -->
                                <!-- <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaExp ?>"><?php echo $tPmtStaExpShow; ?></label></td> -->
                                <td class="text-left"><?= $aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : '-' ?></td>
                                <?php
                                $tApvName = language('document/promotion/promotion', 'tNotFound');
                                if ($aValue['FTPmhUsrApv'] != "") {
                                    $tApvName = $aValue['FTXthApvName'];
                                }
                                ?>
                                <td class="text-left"><?php echo $tApvName; ?></td>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) { ?>
                                    <td>
                                        <img class="xCNIconTable xCNIconDel <?= $ClassDisabled ?>" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>" <?= $Onclick ?> title="<?= $Title ?>">
                                    </td>
                                <?php } ?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) { ?>
                                    <td>
                                        <?php if($bIsApvOrCancel) { ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?= base_url('application/modules/common/assets/images/icons/view2.png'); ?>" onClick="JSvPromotionCallPageEdit('<?= $aValue['FTPmhDocNo'] ?>')">
                                        <?php }else{ ?>
                                            <img class="xCNIconTable" src="<?= base_url('application/modules/common/assets/images/icons/edit.png') ?>" onClick="JSvPromotionCallPageEdit('<?= $aValue['FTPmhDocNo'] ?>')">
                                        <?php } ?>
                                    </td>
                                <?php } ?>
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
            <button onclick="JSvPromotionDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvPromotionDataTableClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvPromotionDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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
                <button id="osmConfirm" onClick="JSxPromotionDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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