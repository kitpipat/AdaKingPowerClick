<?php if (@$oLocList[0]->FNLocID != ""): ?>
    <?php $nCounts = FCNnHSizeOf($oLocList); ?>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th style="width: 50px;"><?= language('common/main/main', 'tCMNChoose') ?></th>					
                    <th style="width: 100px;"><b><?= language('ticket/location/location', 'tImage') ?></b></th>
                    <th><b><?= language('ticket/location/location', 'tLocationName') ?></b></th>
                    <th><b><?= language('ticket/location/location', 'tLayout') ?></b></th>
                    <th><b><?= language('ticket/location/location', 'tManageholiday') ?></b></th>
                    <th><b>จัดการชั้น</b></th>
                    <th><b>จัดการโซน</b></th>
                    <th><b>จัดการประตู</b></th>
                    <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
                        <?php if ($nCounts > 1): ?>
                            <th class="text-center"><b><?= language('ticket/user/user', 'tDelete') ?></b></th>
                        <?php endif; ?>
                    <?php endif; ?>
                    <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                        <th  class="text-center"><b><?= language('ticket/user/user', 'tEdit') ?></b></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody>
                <?php foreach (@$oLocList as $key => $tValue): ?>
                    <tr class="xCNTextDetail2 otrDistrict" data-name="<?= $tValue->FTLocName ?>" data-code="<?=$tValue->FNLocID;?>">
                        <td scope="row" style="vertical-align: middle;">
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?= $key ?>" type="checkbox" data-name="<?= $tValue->FTLocName ?>" value="<?= $tValue->FNLocID; ?>" class="ocbListItem" name="ocbListItem[]">
                                <span>&nbsp;</span>
                            </label>
                        </td>
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
                        <td><img class="" src="<?=$tPatchImg?>" style="width:100%;"></td>
                        <td>
                            <b>				
                                <?php if ($tValue->FTLocName): ?>
                                    <?= $tValue->FTLocName ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                <?php endif; ?>
                            </b>
                            <br>
                            <div class="xWLocation-Detail">
                                <?= language('ticket/zone/zone', 'tAmountLimit') ?> <?= $tValue->FNLocLimit ?> <?= language('ticket/zone/zone', 'tPersons') ?><br> 
                                <?php if (@$tValue->FTLocTimeOpening == ""): ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tOpeninghours') ?> <?= $tValue->FTLocTimeOpening ?> - <?= $tValue->FTLocTimeClosing ?><br>
                                <?php endif; ?>					 
                                <?= language('ticket/zone/zone', 'tLocation') ?>
                                <?php
                                $tStr = (string) $tValue->FNPvnName2;
                                echo substr($tStr, 0, strlen($tStr) - 2);
                                ?>
                            </div>
                            </div>
                        </td>
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLayoutNew/<?= $tValue->FNLocID ?>')">
                                <i class="fa fa-map"></i> <?= language('ticket/location/location', 'tLayout') ?>&nbsp;
                            </a>
                        </td>
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocDayOffNew/<?= $tValue->FNLocID ?>')">
                                <i class="fa fa-calendar"></i> <?= language('ticket/location/location', 'tHolidayDeal') ?> &nbsp;
                            </a>							
                        </td>
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLevelNew/<?= $tValue->FNLocID ?>')">
                                <i class="fa fa-cog"></i> จัดการชั้น &nbsp;
                            </a>	
                            					
                        </td>	
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url(); ?>EticketZoneNew/<?= $tValue->FNLocID ?>')">
                                <i class="fa fa-cog"></i> จัดการโซน &nbsp;
                            </a>							
                        </td>	
                        <td>
                            <a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url(); ?>EticketGateNew/<?= $tValue->FNLocID ?>')">
                                <i class="fa fa-cog"></i> จัดการประตู &nbsp;
                            </a>							
                        </td>	
                        <?php if ($oAuthen['tAutStaDelete'] == '1'): ?>									
                            <?php if ($nCounts > 1): ?>
                                <td class="text-center">
                                    <!-- <a href="#" class="xWBtnDelLoc xWBtnDelLocChk" data-name="<?= $tValue->FTLocName ?>" onclick="return FsxDelLoc('<?= $tValue->FNLocID ?>', this)">
                                        <i style="margin-left: 10px;" class="fa fa-trash-o fa-lg"></i>
                                    </a> -->
                                    <img class="xCNIconTable" src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/delete.png" onclick="return FsxDelLoc('<?=$nPageNo?>','<?= $tValue->FNLocID ?>', '<?= $tValue->FTLocName ?>')">	
                                </td>
                            <?php endif; ?>
                        <?php endif; ?>
                        <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                            <td class="text-center">
                                <!-- <a href="#" onclick="JSxCallPage('<?php echo base_url(); ?>EticketEditLoc/<?= $tValue->FNLocID ?>/<?= $tValue->FNPmoID ?>')">
                                    <i style="margin-left: 10px;" class="fa fa-pencil-square-o fa-lg"></i>
                                </a> -->
                                <img class="xCNIconTable" src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPage('<?php echo base_url(); ?>EticketEditLocNew/<?= $tValue->FNLocID ?>/<?= $nParkId ?>')">
                 
                            </td>
                        <?php endif; ?>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>


<?php else: ?>            	
    <div style="text-align: center; padding: 10px;"> <?= language('ticket/user/user', 'tDataNotFound') ?> </div>
<?php endif ?>
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