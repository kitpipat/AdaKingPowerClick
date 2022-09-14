<?php if (@$oValues[0] != ''): ?>
<?php $nCount = FCNnHSizeOf($oValues); ?>

<?php foreach($oValues AS $aValue): ?>
<?php $aValueM = explode("^", $aValue);?>
<?php 
$tPdtCode = $aValueM[0];
$tPdtTchGroup = $aValueM[1];
$tPdtName = $aValueM[2];
?>
<tr id="otr<?= $tPdtCode ?>">
	<input type="hidden" name="oetPdtCodeArr[]" value="<?= $tPdtCode ?>"> 
   <td><?= $tPdtName ?></td>
   <td><input type="number" min="0" style="width: 100%;" name="oetPdtMaxPersonArr[]" value="1" class="xWCNFormInput pull-left"></td>
   <td><input type="number" min="0" style="width: 100%;" name="oetPdtMaxPriceArr[]" value="150.00" class="xWCNFormInput pull-left"></td>
   <td><a href="#" data-toggle="modal" data-target="#modal-addgrp-day" onclick="javascript: $('#modal-addgrp-day #myModalLabel span').text('ตั๋วผู้ใหญ่ไทย');"><img src="<?php echo base_url('application/modules/common/assets/images/icons/add.png'); ?>" style="width: 20px;"> <?= language('ticket/package/package', 'tPkg_Price')?></a></td>
   <td class="xCNDkkB"><a href="#" data-toggle="modal" data-target="#modal-show-park-group"><img src="<?php echo base_url('application/modules/common/assets/images/icons/add.png'); ?>" style="width: 20px;"> <?= language('ticket/package/package', 'tPkg_TblGroup')?></a></td>
   <td><a href="#" onclick="JSxRemovePdt('<?= $tPdtCode ?>','<?= $tPdtCode ?>^<?= $tPdtTchGroup ?>^<?= $tPdtName ?>')" ><i class="fa fa-trash-o" aria-hidden="true" style="color: #087380"></i> <?= language('ticket/package/package', 'tPkg_Delete')?></a></td>
</tr>
<?php endforeach; ?>
<?php else: ?>

<div style="margin: auto; text-align: center; padding: 50px;">
	<?= language('ticket/package/package', 'tPkg_NoData')?> 
</div>
<?php endif; ?>
