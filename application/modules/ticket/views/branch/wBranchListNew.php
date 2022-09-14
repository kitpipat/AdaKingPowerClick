<?php 
    if($oPageNo != '1'){
        $nCurrentPage = $oPageNo;
    }else{
        $nCurrentPage ='1';
    }
?>

<div class="col-md-12">
    <div class="table-responsive">
        <table class="table table-striped">
            <thead>
                <tr>
                    <th class="xCNTextBold text-center" style="width:2%"><?= language('ticket/agency/agency', 'tSelect') ?></th>
                    <th class="xCNTextBold" style="width:5%;text-align:center;"><?= language('ticket/location/location', 'tImage') ?></th>
                    <th class="xCNTextBold" style="width:5%;text-align:center;"><?= language('common/main/main','tCMNCode')?></th>
                    <th class="xCNTextBold" style="width:60%;text-align:center;"><?= language('common/main/main','tCMNName')?></th>
                    <th class="xCNTextBold" style="width:5%;text-align:center;"><?= language('ticket/user/user', 'tDelete') ?></th>
                    <th class="xCNTextBold" style="width:7%;text-align:center;"><?= language('ticket/park/park', 'tManagelocations') ?></th>
            </thead>
            <tbody id="odvRGPList">
            <?php if (@$oPrkList[0]->FNPmoID != ''): ?>
            <?php foreach ($oPrkList as $key => $aValue): ?>	

            <tr class="xCNTextDetail2 otrDistrict" data-name="<?= $aValue->FTPmoName ?>" data-code="<?=$aValue->FNPmoID;?>">
                <td class="text-center">
                    <label class="fancy-checkbox">
                        <input id="ocbListItem<?= $key ?>" type="checkbox" data-name="<?= $aValue->FTPmoName ?>" value="<?= $aValue->FNPmoID ?>" class="ocbListItem" name="ocbListItem[]">
                        <span></span>
                    </label>
                </td>
                    <?php
                        if(isset($aValue->FTImgObj) && !empty($aValue->FTImgObj)){
                            $tFullPatch = './application/modules/'.$aValue->FTImgObj;
                            if (file_exists($tFullPatch)){
                                $tPatchImg = base_url().'/application/modules/'.$aValue->FTImgObj;
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                        }else{
                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                        }
                    ?>
                    <td><img class="" src="<?=$tPatchImg?>" style="width:36px;"></td>
                    <td class="text-left"><?php if ($aValue->FNPmoID != ""): ?><?= $aValue->FNPmoID ?><?php else: ?><?= language('ticket/zone/zone', 'tNoData') ?><?php endif ?></td>
                    <td class="text-left"><?php if ($aValue->FTPmoName != ""): ?><?= $aValue->FTPmoName ?><?php else: ?><?= language('ticket/zone/zone', 'tNoData') ?><?php endif ?></td>
                    <td class="text-center">
                        <!-- <img class="xCNIconTable" src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/delete.png" onclick="JSxPRKDel('<?= @$aValue->FNPmoID ?>')" > -->
                        <img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"  onclick="JSxPRKDel('<?=$nCurrentPage?>','<?= $aValue->FNPmoID ?>', '<?= $aValue->FTPmoName ?>')">	
                    </td>
                    <td class="text-center">
                        <!-- <img class="xCNIconTable" src="<?php echo  base_url().'application/modules/common/assets/images/icons/edit.png'?>" title="<?= language('ticket/park/park', 'tManage') ?>" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $aValue->FNPmoID ?>')"> -->
                        <img class="xCNIconTable" src="<?php echo  base_url().'application/modules/common/assets/images/icons/edit.png'?>" title="<?= language('ticket/park/park', 'tManage') ?>" onclick="JSxCallPage('<?php echo base_url(); ?>EticketEditBranch/<?= $aValue->FNPmoID ?>')">
                    </td>
                    
                </tr>
            <?php endforeach; ?>
            <?php else: ?>
                <tr><td class='text-center xCNTextDetail2' colspan='100%'><?=language('common/main/main', 'tCMNNotFoundData')?></td></tr>
            <?php endif ?>
            </tbody>
        </table>
    </div>
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
            <button id="osmConfirm" onClick="FSxDelAllOnCheckAgn('<?= $nCurrentPage ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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