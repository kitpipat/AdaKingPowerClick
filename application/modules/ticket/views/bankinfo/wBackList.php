<?php if (@$oBifList[0]->FTBbkCode != ''): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th class="text-center" style="width: 50px;"><?= language('ticket/agency/agency', 'tSelect') ?></th>
				<th class="text-center" style="width: 100px;"><?= language('ticket/bank/bank','tImage')?></th>	
				<th class="text-center"><?= language('ticket/bank/bank','tBank')?></th>	
				<th class="text-center"><?= language('ticket/agency/agency', 'tName') ?></th>
				<th class="text-center"><?= language('ticket/bank/bank','tAccountNumber')?></th>	
				<th class="text-center"><?= language('ticket/bank/bank','tCategory')?></th>	
				<th class="text-center"><?= language('ticket/bank/bank','tStatus')?></th>	
				<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
					<th class="xCNTextBold" style="width:6%;text-align:center;"><?= language('ticket/zone/zone', 'tDelete') ?></th>
				<?php endif; ?>
				<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
					<th class="xCNTextBold" style="width:6%;text-align:center;"><?= language('ticket/zone/zone', 'tEdit') ?></th>
				<?php endif; ?>			
			</tr>
		</thead>
			<tbody>		
				<?php  foreach ($oBifList as $key => $tValue) : ?>	
					<tr class="xCNTextDetail2 otrDistrict" data-name="<?= $tValue->FTBbkName ?>" data-code="<?=$tValue->FTBbkCode;?>">
						<td>
							<label class="fancy-checkbox">
							<input id="ocbListItem<?=$key?>" type="checkbox" data-name="<?= $tValue->FTBbkName ?>" value="<?=$tValue->FTBbkCode;?>" class="ocbListItem" name="ocbListItem[]">
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
            	<td class="text-center">
            	<img class="" src="<?=$tPatchImg?>" style="width:40px;"></td>
						<td>
							<?= @$tValue->FTBnkName ?>
						</td>
						<td>
							<?php if($tValue->FTBbkName): ?>
								<?= $tValue->FTBbkName ?>
								<?php else: ?>
									<?= language('ticket/zone/zone', 'tNoData') ?>
								<?php endif; ?>
							</td>
							<td>
								<?= $tValue->FTBbkAccNo ?>
							</td>
							<td>
								<?php if ($tValue->FTBbkType == '1') {echo language('ticket/bank/bank','tSavingAccount');} ?>
								<?php if ($tValue->FTBbkType == '2') {echo language('ticket/bank/bank','tCurrentAccount');} ?>
								<?php if ($tValue->FTBbkType == '3') {echo language('ticket/bank/bank','tRegularAccount');} ?>
							</td>
							<td>
								<?php if ($tValue->FTBbkStaActive == '1') {echo language('ticket/product/product', 'tOpening');} ?>
								<?php if ($tValue->FTBbkStaActive == '2') {echo language('ticket/bank/bank','tDisabled');} ?>
							</td>
							<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
								<td class="text-center">
									<!-- <a href="#" data-name="<?= $tValue->FTBbkName ?>" onclick="JSxBankInfoDel('<?= $tValue->FTBbkCode ?>',this)"> -->
										<img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/delete.png'?>"  data-name="<?= $tValue->FTBbkName ?>" onclick="JSxBankInfoDel('<?= $nPageNo ?>','<?= $tValue->FTBbkCode ?>', '<?= $tValue->FTBbkName ?>')">
											  								
								</td>
							<?php endif; ?>
							<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
								<td class="text-center">
										<img class="xCNIconTable" src="<?php echo base_url().'application/modules/common/assets/images/icons/edit.png'?>" onclick="JSxCallPage('<?php echo base_url()?>EticketBankInfoEdit/<?= $tValue->FTBbkCode ?>');">
								</td>
							<?php endif; ?>
						</tr>
					<?php endforeach ?>		
				</tbody>
			</table>
			<?php else: ?>
		<div style="margin: auto; text-align: center; padding: 50px;">
	<?= language('ticket/user/user', 'tDataNotFound') ?></div><?php endif ?>		
<div class="modal fade" id="odvmodaldelete">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="bootbox-body"> - </span>
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


