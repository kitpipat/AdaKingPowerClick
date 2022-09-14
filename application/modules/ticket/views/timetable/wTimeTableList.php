<?php if (@$oList[0]->FNTmhID != ''): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th style="width: 50px;"><?= language('common/main/main','tCMNChoose')?></th>
				<th><?= language('ticket/zone/zone', 'tName') ?></th>		
				<th><?= language('ticket/timetable/timetable', 'tShowTime') ?></th>		
				<th><?= language('ticket/room/room', 'tStatus') ?></th>		
				<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
				<th class="text-center"><?= language('ticket/zone/zone', 'tDelete') ?></th>
				<?php endif; ?>
				<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
				<th class="text-center"><?= language('ticket/zone/zone', 'tEdit') ?></th>
				<?php endif; ?>			
			</tr>
		</thead>
		<tbody>		
			<?php  foreach ($oList as $key => $oValue) : ?>	
				<tr data-name="<?= $oValue->FTTmhName ?>" data-code="<?=$oValue->FNTmhID;?>">
					<td class="text-center" scope="row" style="vertical-align: middle;">
						<label class="fancy-checkbox">
							<input id="ocbListItem<?=$key?>" type="checkbox" data-name="<?= $oValue->FTTmhName ?>" value="<?=$oValue->FNTmhID;?>" class="ocbListItem" name="ocbListItem[]">
							<span>&nbsp;</span>
						</label>
					</td>
					<td>
						<?php if($oValue->FTTmhName): ?>
							<div><?= $oValue->FTTmhName ?></div>
							<?php
							$aMTTBDT = $this->mTimeTable->FSxMTTBDT($oValue->FNTmhID);
							if (@$aMTTBDT[0]->FNTmhID == '') {
								echo '<small class="label label-danger">' . language('ticket/timetable/timetable', 'tNoShowTime') . '</small>';
							}
							?>
							<?php else: ?>
								<?= language('ticket/zone/zone', 'tNoData') ?>
							<?php endif; ?>
					</td>					
					<td>	
						<a href="#" class="link-pop" onclick="JSxCallPage('<?php echo base_url()?>EticketTimeTableDT/<?= $oValue->FNTmhID ?>');"><i class="fa fa-cog" aria-hidden="true"></i> <?= language('ticket/timetable/timetable', 'tManageShowTime') ?></a>				
					</td>					
					<td>
						<?php			
						if ($oValue->FTTmhStaActive == '1') {
							echo '<small class="label label-success">' . language('ticket/timetable/timetable', 'tOpening') . '</small>';
						} elseif($oValue->FTTmhStaActive == '2') {
							echo '<small class="label label-danger">' . language('ticket/timetable/timetable', 'tClosing') . '</small>';					
						}
						?>
					</td>
					<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
						<td class="text-center" style="width: 80px;">
							<img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/delete.png" data-name="<?= $oValue->FTTmhName ?>" onclick="JSxTTBHDel('<?= $oValue->FNTmhID ?>',this)">						
						</td>
					<?php endif; ?>
						<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
						<td class="text-center" style="width: 80px;">
							<img class="xCNIconTable" src="<?php echo base_url() ?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPage('<?php echo base_url()?>EticketTimeTable/EditTimeTable/<?= $oValue->FNTmhID ?>');">						
						</td>
						<?php endif; ?>
				</tr>
				<?php endforeach ?>		
			</tbody>
		</table>
<?php else: ?>
	<div style="margin: auto; text-align: center; padding: 50px;">
		<?= language('ticket/user/user', 'tDataNotFound') ?>
	</div>	
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
                <button id="osmConfirm" onClick="FSxDelAllOnCheckHD('<?= $nPageNo ?>')" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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