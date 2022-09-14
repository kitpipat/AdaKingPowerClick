<?php if (@$oPdtList[0]->FNPdtID != ''): ?>

<?php foreach($oPdtList AS $aValue): ?>
<tr>
   <td style="width: 10%;">
      <input type="checkbox" class="xCNCheckbox" name="pdt_group[]" id="oet<?= $aValue->FTPdtCode ?>" value="<?= $aValue->FTPdtCode ?>^<?= $aValue->FTTcgName ?>^<?= $aValue->FTPdtName ?>">
   </td>
   <td style="width: 30%;"><?= $aValue->FTTcgName ?></td>
   <td style="width: 60%;"><?= $aValue->FTPdtName ?></td>
</tr>
<?php endforeach; ?>
<?php else: ?>

<div style="margin: auto; text-align: center; padding: 50px;">
	<?= language('ticket/package/package', 'tPkg_NoData')?> 
</div>
<?php endif; ?>
