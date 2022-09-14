<?php if (@$oLocList[0]->FNLocID != ""): ?>
<div class="table-responsive">
    <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 50px;" class="text-center"><?= language('common/main/main', 'tCMNChoose') ?></th>					
                    <th style="width: 100px;" class="text-center"><b><?= language('ticket/event/event', 'tImage') ?></b></th>
                    <th class="text-center"<b><?= language('ticket/location/location', 'tLocationName') ?></b></th>
                    <th class="text-center"><b><?= language('ticket/event/event', 'tShowTime') ?></b></th>
                    <th class="text-center"><b><?= language('ticket/event/event', 'tPackageList') ?></b></th>
                    <th class="text-center"><b><?= language('ticket/zone/zone', 'tDelete') ?></b></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach (@$oLocList as $key => $tValue): ?>
                    <tr data-name="<?= $tValue->FTLocName ?>" data-code="<?= $tValue->FNLocID; ?>">
                        <td scope="row" style="vertical-align: middle;">
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?= $key ?>" type="checkbox" data-name="<?= $tValue->FTLocName ?>" value="<?= $tValue->FNLocID; ?>" class="ocbListItem" name="ocbListItem[]">
                                <span>&nbsp;</span>
                            </label>
                        </td>                        
                        <td>
                            <?php
                                if(isset($tValue->FTImgObj) && !empty($tValue->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$tValue->FTImgObj;
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$tValue->FTImgObj;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            ?>
                            <img class="img-reponsive" src="<?= $tPatchImg ?>">
                        </td>
                        <td>
                            <?php if ($tValue->FTLocName): ?>
                                <?= $tValue->FTLocName ?>
                            <?php else: ?>
                                <?= language('ticket/zone/zone', 'tNoData') ?>
                            <?php endif; ?>
                            <br>
                            <?= $tValue->FTPmoName ?><br>
                            <?= language('ticket/zone/zone', 'tAmountLimit') ?> <?= $tValue->FNLocLimit ?> <?= language('ticket/zone/zone', 'tPersons') ?><br> 	
                            <?php if ($tValue->FNCountTimeSet == "0"): ?>
                                <small class="label label-danger"><?= language('ticket/event/event', 'tNoShow') ?></small>
                            <?php else: ?>
                            <?php endif; ?>
                        </td>
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url('/EticketTimeTable/TimeTableList/' . $tValue->FNEvnID . '/' . $tValue->FNLocID . ''); ?>')"><?= language('ticket/event/event', 'tShowTime') ?></a>
                        </td>
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url('/EticketShowTimePackageList/' . $tValue->FNEvnID . '/' . $tValue->FNLocID . ''); ?>')"><?= language('ticket/event/event', 'tPackageList') ?></a>
                        </td>
                        <td class="text-center">
                            <img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/delete.png" onclick="FSxCSHTDelShowTime('<?= $tValue->FNEvnID ?>', '<?= $tValue->FNLocID ?>', ' <?= $tValue->FTLocName ?>');">						
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>

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
                    <button id="osmConfirm" onClick="FSxDelAllOnCheck('<?= $nEventID ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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
    <div style="text-align: center; padding: 10px;"> <?= language('ticket/user/user', 'tDataNotFound') ?> </div>
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