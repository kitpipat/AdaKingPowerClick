<?php if (@$oRomList[0]->FNRomID != ''): ?>
	<table class="table table-hover">
		<thead>
			<tr>
				<th><?= language('ticket/zone/zone', 'tNo') ?></th>
				<th><?= language('ticket/room/room', 'tImageRoom') ?></th>
				<th><?= language('ticket/room/room', 'tNumber') ?></th>
				<th><?= language('ticket/zone/zone', 'tName') ?></th>
				<th><?= language('ticket/zone/zone', 'tLevel') ?></th>
				<th><?= language('ticket/room/room', 'tAmountBedrooms') ?></th>
				<th><?= language('ticket/room/room', 'tAmountBathrooms') ?></th>
				<th><?= language('ticket/room/room', 'tAmount') ?></th>								
				<th><?= language('ticket/room/room', 'tStatus') ?></th>
				<?php if ($oAuthen[0]->FTGadStaAlwDel == '1'): ?>
	            <th><?= language('ticket/zone/zone', 'tDelete') ?></th>
	            <?php endif; ?>
				<?php if ($oAuthen[0]->FTGadStaAlwW == '1'): ?>
	            <th><?= language('ticket/zone/zone', 'tEdit') ?></th>
	            <?php endif; ?>
			</tr>
		</thead>
		<tbody>			
			<?php  foreach ($oRomList as $key => $tValue) : ?>	
			<tr>
				<td><?= $tValue->RowID ?></td>
				<td>
					<?php
						if(isset($tValue->FTImgObj) && !empty($tValue->FTImgObj)){
							$tFullPatch = './application/modules/common/assets/system/systemimage/'.$tValue->FTImgObj;
							if (file_exists($tFullPatch)){
								$tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$tValue->FTImgObj;
							}else{
								$tPatchImg = base_url().'application/modules/common/assets/images/5,3.png';
							}
						}else{
							$tPatchImg = base_url().'application/modules/common/assets/images/5,3.png';
						}
					?>
					<img src="<?=$tPatchImg;?>" style="width: 50px;">
				</td>
				<td><?= $tValue->FTRomSeqNo ?></td>
				<td><?= $tValue->FTRomName ?></td>
				<td><?= $tValue->FTLevName ?></td>
				<td><?= $tValue->FNRomQtyBRoom ?></td>
				<td><?= $tValue->FNRomQtyTRoom ?></td>
				<td><?= $tValue->FNRomMaxPerson ?></td>			
				<td><?php			
					if ($tValue->FTRomStaAlw == '1') {
						echo '<small class="label label-success">' . language('ticket/room/room', 'tOpening') . '</small>';
					} elseif($tValue->FTRomStaAlw == '3') {
						echo '<small class="label label-danger">' . language('ticket/room/room', 'tWasteRepair') . '</small>';					
					}
					?></td>
				<?php if ($oAuthen[0]->FTGadStaAlwDel == '1'): ?>
	            <td style="width: 70px;">
						<button class="btn btn-border btn-outline btn-default" onclick="JSxDelRoom('<?= $tValue->FNRomID ?>', '<?= $tValue->FNPdtID ?>','<?= language('ticket/center/center', 'Confirm') ?>')">
							<i class="fa fa-remove"></i> <?= language('ticket/user/user', 'tDelete') ?>
						</button>
				</td>
	            <?php endif; ?>
				<?php if ($oAuthen[0]->FTGadStaAlwW == '1'): ?>
	            <td style="width: 70px;">
						<button class="btn btn-border btn-outline btn-default" onclick="javascript:JSxCallPage('<?php echo base_url()?>EditRoom/<?= $tValue->FNRomID ?>/<?= $tValue->FNLocID ?>');">
							<i class="fa fa-pencil"></i> <?= language('ticket/user/user', 'tEdit') ?>
						</button>
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