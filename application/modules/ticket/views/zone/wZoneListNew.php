<?php if (@$oZneList[0]->FNZneID != ''): ?>
	<table class="table table-striped">
		<thead>
			<tr>
				<th style="width: 50px;"><?= language('common/main/main','tCMNChoose')?></th>
				<th><?= language('ticket/zone/zone', 'tImageZone') ?></th>
				<th><?= language('ticket/zone/zone', 'tName') ?></th>			
				<th><?= language('ticket/zone/zone', 'tLevel') ?></th>
				<th><?= language('ticket/zone/zone', 'tCategory') ?></th>
				<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
	            <th class="text-center"><?= language('ticket/zone/zone', 'tDelete') ?></th>
	            <?php endif; ?>
				<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
	            <th class="text-center"><?= language('ticket/zone/zone', 'tEdit') ?></th>
	            <?php endif; ?>
			</tr>
		</thead>
		<tbody>			
			<?php  foreach ($oZneList as $key => $tValue) : ?>
				<tr>
					<td scope="row" style="vertical-align: middle;">
						<label class="fancy-checkbox">
							<input id="ocbListItem<?=$key?>" type="checkbox" data-name="<?= $tValue->FTZneName ?>" value="<?=$tValue->FNZneID;?>" class="ocbListItem" name="ocbListItem[]">
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
					<img src="<?=$tPatchImg;?>" style="width: 48px;">
					</td>
					<td>
					<?php if($tValue->FTZneName): ?>
						<?= $tValue->FTZneName ?>
					<?php else: ?>
						<?= language('ticket/zone/zone', 'tNoData') ?>
					<?php endif; ?>
					</td>				
					<td>
					<?php if($tValue->FTLevName): ?>
						<?= $tValue->FTLevName ?>
					<?php else: ?>
						<?= language('ticket/zone/zone', 'tNoData') ?>
					<?php endif; ?>
					</td>			
					<td>
					<?php 
						if ($tValue->FTZneBookingType == '1') {
							echo '<a href="javascript:void(0)" style="text-decoration: none;" onclick="JSxCallPage(\''.base_url().'EticketSeatNew/'.$tValue->FNLocID.'/'.$tValue->FNZneID.'/'.($tValue->FNLevID == "" ? 0 : $tValue->FNLevID).'\');"><img src="' . base_url('application/modules/common/assets/images/icons/icons8-Armchair-100.png') . '" style="width: 18px; float: left; margin-top: 5px;"> &nbsp; '.language('ticket/zone/zone', 'tSeat').'</a>';
						} else if ($tValue->FTZneBookingType == '2') {					
							echo '<a href="javascript:void(0)" style="text-decoration: none;" onclick="JSxCallPage(\''.base_url().'EticketRoomNew/'.$tValue->FNLocID.'/'.$tValue->FNZneID.'\');"><img src="' . base_url('application/modules/common/assets/images/icons/icons8-Sleeping in Bed-100.png') . '" style="width: 18px; float: left;"> &nbsp; '.language('ticket/zone/zone', 'tRoom').'</a>';
						} else if ($tValue->FTZneBookingType == '3') {
							echo '<img src="' . base_url('application/modules/common/assets/images/icons/icons8-Ticket-100.png') . '" style="width: 18px; float: left;"> &nbsp; <span style="color: #d5d5d5;">'.language('ticket/zone/zone', 'tTicket').'</span>';
						} else {
						}	
					?>				
					</td>	
					<?php if ($oAuthen['tAutStaDelete'] == '1'): ?>
		            <td class="text-center" style=" width: 70px; ">
						<img class="xCNIconTable" src="<?php echo base_url()?>application/modules/common/assets/images/icons/delete.png" data-name="<?= $tValue->FTZneName ?>"  onclick="JSxDelZone('<?= $tValue->FNZneID ?>',this)">
					</td>
		            <?php endif; ?>
					<?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
		            <td class="text-center" style=" width: 70px; ">
						<img class="xCNIconTable" src="<?php echo base_url()?>application/modules/common/assets/images/icons/edit.png" onclick="javascript:JSxCallPage('<?php echo base_url()?>EticketEditZoneNew/<?= $tValue->FNLocID ?>/<?= $tValue->FNZneID ?><?php if ($tValue->FNStaSeat != "") {echo "/?FNStaSeat=1";}else{echo "/?FNStaSeat=0";} ?>');">
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