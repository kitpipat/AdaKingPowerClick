<?php if (@$oPmtList[0]->FNPmhID != ''): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" style="width: 50px;"><?= language('common/main/main', 'tCMNChoose') ?></th>
                <th class="text-center" style="width: 100px;"><?= language('ticket/bank/bank', 'tImage') ?></th>	
                <th class="text-center" ><?= language('ticket/promotion/promotion', 'tPromotionCode') ?></th>	
                <th class="text-center" ><?= language('ticket/promotion/promotion', 'tPromotionName') ?></th>
                <th class="text-center" ><?= language('ticket/promotion/promotion', 'tStartDate') ?></th>
                <th class="text-center" ><?= language('ticket/promotion/promotion', 'tEndDate') ?></th>
                <th class="text-center" ><?= language('ticket/promotion/promotion', 'tUsageStatus') ?></th>
                <th class="text-center" ><?= language('ticket/promotion/promotion', 'tStatus') ?></th>
                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                    <th class="text-center" ><?= language('ticket/zone/zone', 'tDelete') ?></th>
                <?php endif; ?>
                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                    <th class="text-center" ><?= language('ticket/zone/zone', 'tEdit') ?></th>
                <?php endif; ?>			
            </tr>
        </thead>
        <tbody>		
            <?php foreach ($oPmtList as $key => $oValue) : ?>	
                <tr data-name="<?= $oValue->FTPmhName ?>" data-code="<?= $oValue->FNPmhID; ?>">
                    <td scope="row" style="vertical-align: middle;">
                        <label class="fancy-checkbox">
                            <input id="ocbListItem<?= $key ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" data-name="<?= $oValue->FTPmhName ?>" value="<?= $oValue->FNPmhID; ?>">
                            <span>&nbsp;</span>
                        </label>
                    </td>
                    <td class="text-center">
                        <?php
                            if(isset($oValue->FTImgObj) && !empty($oValue->FTImgObj)){
                                $tFullPatch = './application/modules/'.$oValue->FTImgObj;
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/'.$oValue->FTImgObj;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                        ?>
                        <img src="<?= $tPatchImg; ?>" style="width: 57%;">
                    </td>
                    <td>
                        <?= @$oValue->FTPmhCode ?>
                    </td>
                    <td>
                        <?= @$oValue->FTPmhName ?>
                    </td>
                    <td>
                        <?= ($oValue->FDPmhActivate == "" ? "" : date("d-m-Y", strtotime($oValue->FDPmhActivate))) ?> <?= date("H:s", strtotime($oValue->FDPmhTActivate)) ?>
                    </td>
                    <td>
                        <?= ($oValue->FDPmhExpired == "" ? "" : date("d-m-Y", strtotime($oValue->FDPmhExpired))) ?> <?= date("H:s", strtotime($oValue->FDPmhTExpired)) ?>
                    </td>
                    <td>
                        <?php if ($oValue->FTPmhClosed == '0'): ?>
                            <?= language('ticket/promotion/promotion', 'tEnable') ?>
                        <?php else: ?>
                            <?= language('ticket/promotion/promotion', 'tDisabled') ?>
                        <?php endif; ?>
                    </td>
                    <td>
                        <?php if ($oValue->FTPmhStaPrcDoc == '1'): ?>
                            <span style="color: #0e9e0e;"><?= language('ticket/event/event', 'tAccepted') ?></span>
                        <?php else: ?>
                            <span style="color: #f60;"><?= language('ticket/event/event', 'tNotAccepted') ?></span>
                        <?php endif; ?>
                    </td>
                    <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                        <td class="text-center">
                            <img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/delete.png" onclick="JSxPmtDel('<?= $nPageNo ?>','<?= $oValue->FNPmhID ?>','<?= $oValue->FTPmhName ?>')">						
                        </td>
                    <?php endif; ?>
                    <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                        <td class="text-center">
                            <img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPage('<?php echo base_url() ?>EticketPromotionEdit/<?= $oValue->FNPmhID ?>');">						
                        </td>
                    <?php endif; ?>
                </tr>
            <?php endforeach ?>		
        </tbody>
    </table>

<div class="modal fade" id="odvmodaldelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete" class="xCNTextModal"> - </span>
                <input type='hidden' id="ospConfirmIDDelete">
            </div>
            <div class="modal-footer">
                <!-- แก้ -->
                <button id="osmConfirm" onClick="FSxDelAllOnCheck('<?= $nPageNo ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                    <?php echo language('common/main/main', 'tModalConfirm')?>
                </button>
                <!-- แก้ -->
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel')?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php else: ?>
    <div style="margin: auto; text-align: center; padding: 50px;">
        <?= language('ticket/user/user', 'tDataNotFound') ?>
    </div>	
<?php endif ?>		
<script type="text/javascript">
    $(function() {
        $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    });
    });
</script>