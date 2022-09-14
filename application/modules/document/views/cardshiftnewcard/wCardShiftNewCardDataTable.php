<?php
    if($aDataList['rtCode'] == '1'){
       $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage   = '1';
    }

?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBChoose');?></th>
                        <?php endif;?>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTBBranchCode'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:25%;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTBDocNo'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTBDocDate'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTBCardNumber'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTBDocStatus'); ?></th>
                        <!-- <th nowrap class="xCNTextBold text-left" style="width:10%;"><?php echo language('common/main/main', 'tStaPrcDocTitle'); ?></th> -->
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard','tCardShiftNewCardTBDelete');?></th>
                        <?php endif;?>  
                        <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1)) : ?>
                            <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/newcard', 'tCardShiftNewCardTBEdit'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if ($aDataList['rtCode'] == 1) : ?>
                        <?php foreach ($aDataList['raItems'] as $key => $aValue) : ?>
                            <?php 
                                $tBchCodeEdit = $aValue['rtCardShiftNewCardBchCode'];
                                $tCardShiftNewCardNo   = $aValue['rtCardShiftNewCardDocNo'];
                                $bIsApvOrCancel = ($aValue['rtCardShiftNewCardCshStaPrcDoc'] == 1 || $aValue['rtCardShiftNewCardCshStaPrcDoc'] == 2) || ($aValue['rtCardShiftNewCardCshStaPrcDoc'] == 3 );

                                if($bIsApvOrCancel){
                                    $tCheckboxDisabled  = "disabled";
                                    $tClassDisabled     = 'xCNDocDisabled';
                                    $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                    $tOnclick           = '';
                                }else{
                                    $tCheckboxDisabled  = "";
                                    $tClassDisabled     = '';
                                    $tTitle             = '';
                                    $tOnclick           = "onclick=JSoCrdShifNewCardDelDocSingle('".$nCurrentPage."','".$tCardShiftNewCardNo."','".$tBchCodeEdit."')";
                                }
                               
                            ?>
                            <tr class="text-center xCNTextDetail2" id="otrCardShiftNewCard<?= $key ?>" data-code="<?= $aValue['rtCardShiftNewCardDocNo'] ?>" data-name="<?= $aValue['rtCardShiftNewCardDocNo'] ?>">  
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center"> 
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?php echo $key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled;?>>
                                            <span class="<?php echo $tClassDisabled?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif;?>
                                <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftNewCardBchCode'] ?></td>
                                <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftNewCardDocNo']; ?></td>
                                <td nowrap class="text-center"><?php echo date('d/m/Y', strtotime(@$aValue['rtCardShiftNewCardDocDate'])); ?></td>
                                <td nowrap class="text-left"><?php echo @number_format($aValue['rtCardShiftNewCardCshCardQty'], 0); ?></td>
                                <?php
                                $tCshStaDoc = "";
                                $tClassStaDoc = "";
                                $tStaDoc = "";
                                
                                //StaDoc
                                if($aValue['rtCardShiftNewCardCshStaDoc'] == 3){
                                    $tClassStaDoc = 'text-danger';
                                    $tStaDoc = language('common/main/main', 'tStaDoc3');
                                }else if(!empty($aValue['rtCardShiftNewCardApvCode'])){
                                    $tClassStaDoc = 'text-success';
                                    $tStaDoc = language('common/main/main', 'tStaDoc1'); 
                                }else{
                                    $tClassStaDoc = 'text-warning';
                                    $tStaDoc = language('common/main/main', 'tStaDoc');
                                }


                                ?>
                                <td nowrap class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tStaDoc; ?></label></td>
                                <?php
                                $tCshStaPrcDoc = "";
                                
                                // StaPrcDoc
                                // if ($aValue['rtCardShiftNewCardCshStaPrcDoc'] == 1) {
                                //     $tClassPrcStk = 'text-success';
                                //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                                // } else if ($aValue['rtCardShiftNewCardCshStaPrcDoc'] == 2) {
                                //     $tClassPrcStk = 'text-warning';
                                //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                                // } else if ($aValue['rtCardShiftNewCardCshStaPrcDoc'] == 0 || $aValue['rtCardShiftNewCardCshStaPrcDoc'] == '') {
                                //     $tClassPrcStk = 'text-warning';
                                //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                                // }
                                ?>
                                <!-- <td nowrap class="text-left"><label class="xCNTDTextStatus <?= $tClassPrcStk ?>"><?php echo $tStaPrcDoc; ?></label></td> -->

                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1): ?>
                                    <td nowrap>
                                        <img
                                            class="xCNIconTable xCNIconDel <?php echo @$tClassDisabled?>"
                                            src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                            <?php echo @$tOnclick?>
                                            title="<?php echo @$tTitle?>"
                                        >
                                    </td>
                                <?php endif;?>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1) { ?>
                                    <td>
                                        <?php if($bIsApvOrCancel) { ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvCardShiftNewCardCallPageCardShiftNewCardEdit('<?= $aValue['rtCardShiftNewCardDocNo'] ?>')">
                                        <?php } else { ?>
                                            <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCardShiftNewCardCallPageCardShiftNewCardEdit('<?= $aValue['rtCardShiftNewCardDocNo'] ?>')">
                                        <?php } ?>
                                    </td>
                                <?php } ?>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td nowrap class='text-center xCNTextDetail2' colspan='9'><?php echo language('common/main/main', 'tCMNNotFoundData'); ?></td>
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
        <p><?php echo language('common/main/main', 'tResultTotalRecord'); ?> <?php echo $aDataList['rnAllRow']; ?> <?php echo language('common/main/main', 'tRecord'); ?> <?php echo language('common/main/main', 'tCurrentPage'); ?> <?php echo $aDataList['rnCurrentPage']; ?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCardShiftNewCard btn-toolbar pull-right">
            <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ -->
            <?php if ($nPage == 1) {
                $tDisabledLeft = 'disabled';
            } else {
                $tDisabledLeft = '-';
            } ?>
            <button onclick="JSvCardShiftNewCardClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvCardShiftNewCardClickPage('<?php echo $i ?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i ?></button>
            <?php } ?>
            <?php if ($nPage >= $aDataList['rnAllPage']) {
                $tDisabledRight = 'disabled';
            } else {
                $tDisabledRight = '-';
            } ?>
            <button onclick="JSvCardShiftNewCardClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ -->
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
<div id="odvCardShifNewCardModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ======================================================================================================================================== -->

<!-- ===================================================== Modal Delete Document Multiple =================================================== -->
<div class="modal fade" id="odvCardShifNewCardModalDelMultiple">
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
                <button id="osmConfirm" onClick="JSoCardShifNewCardDelDocMultiple()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?= language('common/main/main', 'tModalConfirm') ?>
                </button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
                    <?= language('common/main/main', 'tModalCancel') ?>
                </button>
            </div>
        </div>
    </div>
</div>

<!-- ======================================================================================================================================== -->

<script type="text/javascript">
    $('.ocbListItem').unbind().click(function(){
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
            JSxCardShifNewCardTextinModal();
        } else {
            var aReturnRepeat = JStCardShifNewCardFindObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { // ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxCardShifNewCardTextinModal();
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
                JSxCardShifNewCardTextinModal();
            }
        }
        JSxShowButtonChoose();
        
    });
</script>