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
                            <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBChoose');?></th>
                        <?php endif;?>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBBranchCode'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:25%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDocNo'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDocDate'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBCardNumber'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDocStatus'); ?></th>
                        <!-- <th nowrap class="xCNTextBold text-center" style="width:10%;"><?php echo language('common/main/main', 'tStaPrcDocTitle'); ?></th> -->
                        
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBDelete');?></th>
                        <?php endif;?>

                        <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaEdit'] == 1 || $aAlwEvent['tAutStaRead'] == 1))  : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?php echo language('document/card/cardreturn','tCardShiftReturnTBEdit'); ?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key => $aValue) : ?>
                        <?php 
                            $tBchCodeEdit = $aValue['rtCardShiftReturnBchCode'];
                            $tCardShiftReturnNo   = $aValue['rtCardShiftReturnDocNo'];

                            if($aValue['rtCardShiftReturnCshStaDoc'] == 3 || $aValue['rtCardShiftReturnCshStaApv'] == 3 || $aValue['rtCardShiftReturnCshStaApv']  == 1 || $aValue['rtCardShiftReturnCshStaApv'] == 2) {
                                $tCheckboxDisabled  = "disabled";
                                $tClassDisabled     = 'xCNDocDisabled';
                                $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                $tOnclick           = '';
                            }else{
                                $tCheckboxDisabled  = "";
                                $tClassDisabled     = '';
                                $tTitle             = '';
                                $tOnclick           = "onclick=JSoCrdShifReturnDelDocSingle('".$nCurrentPage."','".$tCardShiftReturnNo."','".$tBchCodeEdit."')";
                            }
                        ?>

                        <tr class="text-center xCNTextDetail2" id="otrCardShiftReturn<?= $key ?>" data-code="<?= $aValue['rtCardShiftReturnDocNo'] ?>" data-name="<?= $aValue['rtCardShiftReturnDocNo'] ?>">  
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                <td nowrap class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled;?>>
                                        <span class="<?php echo $tClassDisabled?>">&nbsp;</span>
                                    </label>
                                </td>

                            <?php endif;?>
                            <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftReturnBchCode']?></td>
                            <td nowrap class="text-left"><?php echo @$aValue['rtCardShiftReturnDocNo']; ?></td>
                            <td nowrap class="text-center"><?php echo date('d/m/Y', strtotime(@$aValue['rtCardShiftReturnDocDate'])); ?></td>
                            <td nowrap class="text-left"><?php echo @number_format($aValue['rtCardShiftReturnCshCardQty'], 0); ?></td>
                            <?php
                            $tCshStaDoc = "";
                            //StaDoc
                            if($aValue['rtCardShiftReturnCshStaDoc'] == 3){
                                $tClassStaDoc   = 'text-danger';
                                $tStaDoc = language('common/main/main','tStaDoc3');
                            }else if($aValue['rtCardShiftReturnCshStaApv'] == 1){
                                $tClassStaDoc   = 'text-success';
                                $tStaDoc = language('common/main/main','tStaDoc1');   
                            }else{
                                $tClassStaDoc   = 'text-warning';
                                $tStaDoc = language('common/main/main','tStaDoc');
                            }

                            ?>
                            <td nowrap class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tStaDoc; ?></label></td>
                            <?php 
                            //StaPrcDoc
                            // if ($aValue['rtCardShiftReturnCshStaPrcDoc'] == 1) {
                            //     $tClassPrcStk = 'text-success';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                            // } else if ($aValue['rtCardShiftReturnCshStaPrcDoc'] == 2) {
                            //     $tClassPrcStk = 'text-warning';
                            //     $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                            // } else if ($aValue['rtCardShiftReturnCshStaPrcDoc'] == 0 || $aValue['rtCardShiftReturnCshStaPrcDoc'] == '') {
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

                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                <td>
                                    <?php if ($aValue['rtCardShiftReturnCshStaApv'] == 1 || $aValue['rtCardShiftReturnCshStaDoc'] == 3) { ?>
                                        <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvCardShiftReturnCallPageCardShiftReturnEdit('<?= $aValue['rtCardShiftReturnDocNo'] ?>')">
                                    <?php } else { ?>
                                        <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvCardShiftReturnCallPageCardShiftReturnEdit('<?= $aValue['rtCardShiftReturnDocNo'] ?>')">
                                    <?php } ?>
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php endforeach; ?>
                <?php else:?>
                    <tr><td nowrap class='text-center xCNTextDetail2' colspan='9'><?php echo language('common/main/main','tCMNNotFoundData'); ?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord'); ?> <?php echo $aDataList['rnAllRow']; ?> <?php echo language('common/main/main','tRecord'); ?> <?php echo language('common/main/main','tCurrentPage'); ?> <?=$aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCardShiftReturn btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCardShiftReturnClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvCardShiftReturnClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCardShiftReturnClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
<div id="odvCardShifReturnModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
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
<div class="modal fade" id="odvModalDelCardShiftReturn">
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
                <button id="osmConfirm" onClick="JSoCardShifReturnCardDelDocMultiple()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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
            JSxCardReturnTextinModal();
        }else{
            var aReturnRepeat = JStCardReturnFindObjectByKey(aArrayConvert[0], 'nCode', nCode);
            if (aReturnRepeat == 'None') { // ยังไม่ถูกเลือก
                obj.push({
                    "nCode": nCode,
                    "tName": tName
                });
                localStorage.setItem("LocalItemData", JSON.stringify(obj));
                JSxCardReturnTextinModal();
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
                JSxCardReturnTextinModal();
            }
        }
        JSxShowButtonChoose();
    });


</script>
