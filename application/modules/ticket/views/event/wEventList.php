<?php if (@$oEvtList[0]->FNEvnID != ''): ?>
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-center" style="width: 6px;"><?= language('common/main/main', 'tCMNChoose') ?></th>
                <th class="text-center" style="width: 10%;"><?= language('ticket/event/event', 'tImage') ?></th>	
                <th class="text-center" ><?= language('ticket/event/event', 'tEventName') ?></th>	
                <th class="text-center" ><?= language('ticket/event/event', 'tStatus') ?></th>
                <th class="text-center" ><?= language('ticket/event/event', 'tManageEvents') ?></th>
                <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                <th class="text-center" ><?= language('ticket/user/user', 'tDelete') ?></th>
                <?php endif; ?>
                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                <th class="text-center" ><?= language('ticket/user/user', 'tEdit') ?></th>
                <?php endif; ?>			
            </tr>
        </thead>
    <tbody>		
        <?php foreach ($oEvtList as $key => $oValue) : ?>	
            <tr data-name="<?= $oValue->FTEvnName ?>" data-code="<?= $oValue->FNEvnID; ?>">
                <td scope="row" style="vertical-align: middle;">
                    <label class="fancy-checkbox">
                        <input id="ocbListItem<?= $key ?>" type="checkbox" data-name="<?= $oValue->FTEvnName ?>" value="<?= $oValue->FNEvnID; ?>" class="ocbListItem" name="ocbListItem[]">
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
                <img src="<?= $tPatchImg; ?>" style="width: 75%;">
            </td>
                <td>
                    <p>
                        <?php if ($oValue->FTEvnName): ?>
                            <?= $oValue->FTEvnName ?>
                        <?php else: ?>
                            <?= language('ticket/zone/zone', 'tNoData') ?>
                        <?php endif; ?>
                    </p>
                    <div class="xWLocation-Detail" style="color: #aba9a9; font-size: 13px;">
                        <p><h4><?= $oValue->FTEvnDesc1 ?></h4></p>
                        <p><h4><?= date("d-m-Y H:i", strtotime($oValue->FDEvnStartSale)) ?>
                            <?php
                                if ($oValue->FDEvnStopSale != '') {
                                    echo ' - ' . date("d-m-Y H:i", strtotime($oValue->FDEvnStopSale));
                                }
                            ?>
                        <h4></p>
                    <p><h4>
                        <?php
                            if ($oValue->FTEvnStaUse == "2") {
                                echo language('ticket/product/product', 'tStatus') . ' : <small class="label label-danger">' . language('ticket/event/event', 'tDisabled') . '</small>';
                            }else{
                            if ($oValue->FDEvnFinish != "") {
                            if (date("Y-m-d") > date("Y-m-d", strtotime($oValue->FDEvnFinish))) {
                                echo language('ticket/product/product', 'tStatus') . ' : ' . language('ticket/event/event', 'tExpire') . '';
                            } else {
                                    echo language('ticket/product/product', 'tStatus') . ' : ' . language('ticket/event/event', 'tEnable') . '';
                                }
                            }else{
                                echo language('ticket/product/product', 'tStatus') . ' : ' . language('ticket/event/event', 'tEnable') . '';
                            }
                            }
                        ?>
                        </h4></p>
                    </div>
                </td>
                <td>
                    <?php if ($oValue->FTEvnStaPrcDoc == '1'): ?>
                        <a><span style="color: #0e9e0e;"><?= language('ticket/event/event', 'tAccepted') ?></span></a>
                    <?php else: ?>
                        <a><span style="color: #f60;"><?= language('ticket/event/event', 'tNotAccepted') ?></span></a>
                    <?php endif; ?>
                </td>
                <td>
                    <a href="#" class="link-pop" style="font-size: 13px;" onclick="JSxCallPage('<?php echo base_url(); ?>EticketShowTime/<?= $oValue->FNEvnID ?>')"><i class="fa fa-cog" aria-hidden="true"></i> <?= language('ticket/event/event', 'tManageEvents') ?></a>
                </td>
                    <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                        <td class="text-center">
                            <img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/delete.png" onclick="return JSxEVTDel('<?= $oValue->FNEvnID ?>', this)">						
                        </td>
                    <?php endif; ?>

                    <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                        <td class="text-center">
                            <img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPage('<?php echo base_url(); ?>EticketEditEvent/<?= $oValue->FNEvnID ?>')">						
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