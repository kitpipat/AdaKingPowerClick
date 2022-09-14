<?php if (@$oLvlList[0]->FNLevID != ''): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th style="width: 50px;"><?= language('common/main/main','tCMNChoose')?></th>
				<th><?= language('ticket/zone/zone', 'tName') ?></th>
				<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
		            <th><?= language('ticket/user/user', 'tDelete') ?></th>
		            <?php endif; ?>
				<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
		            <th><?= language('ticket/user/user', 'tEdit') ?></th>
		        <?php endif; ?>
			</tr>
		</thead>
		<tbody>		
		<?php  foreach ($oLvlList as $key => $tValue) : ?>	
			<tr>
				<td scope="row" style="vertical-align: middle;">
					<label class="fancy-checkbox">
						<input id="ocbListItem<?=$key?>" type="checkbox" data-name="<?= $tValue->FTLevName ?>" value="<?=$tValue->FNLevID;?>" class="ocbListItem" name="ocbListItem[]">
						<span>&nbsp;</span>
					</label>
				</td>
				<td>
					<?php if($tValue->FTLevName): ?>
						<?= $tValue->FTLevName ?>
					<?php else: ?>
						<?= language('ticket/zone/zone', 'tNoData') ?>
					<?php endif; ?>
				</td>				
				<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
		            <td class="text-center" style=" width: 70px; ">
						<img class="xCNIconTable" src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/delete.png" onclick="JSxDelLev('<?= $tValue->FNLevID ?>','<?= $tValue->FNLocID ?>',this)">	
					</td>
		        <?php endif; ?>
				<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
		            <td class="text-center" style=" width: 70px; ">
						<img class="xCNIconTable" src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/edit.png" onclick="JSxCallPage('<?php echo base_url()?>EticketEditLevelNew/<?= $tValue->FNLocID ?>/<?= $tValue->FNLevID ?>');">
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
<script type="text/javascript">
	$(function() {
		$('.ocbListItem').click(function() {
			var nlength = $(".ocbListItem:checked").length;
			if (nlength <= 1) {
				$('.obtChoose').hide();
			}else {
				$('.obtChoose').show();							
			}
		});
	});
</script>