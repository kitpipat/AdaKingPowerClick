<div class="row">
	<div class="col-sm-12">
		 <?php if (isset($oPkgPriDOWList[0]->FNPpkID)): ?>
		 <?php foreach($oPkgPriDOWList AS $aValue): ?>
			<div class="col-sm-2" style="margin-top:20px;">
				<div style="background:#eeeeee;text-align:center;height: 110px;">
					<label style="margin-top: 25px;"><?= language('ticket/package/package', 'tPkg_PackageDayOfWeek'.$aValue->FNPpdDayOfWeek)?><label>
				</div>
				<div style="margin-top: -40px; text-align:center;">
				<?php if($oPkgDetail[0]->FTPkgStaPrcDoc != '1'):?>
					<input type="number" min="0" class="form-control" id="oetEditPkgPrice<?=$aValue->FNPpdDayOfWeek ?>" onkeypress="javascript: if (event.keyCode == 13) {event.preventDefault(); JSnPKGEditPkgPriByDOW('<?=$aValue->FNPpkID ?>','<?=$aValue->FNPpdDayOfWeek ?>');}" onfocusout="JSnPKGPriSpcPriByDOWFocusOut();" style="position: relative;width: 94%;margin-left: 5px;text-align:right;" value="<?= $aValue->FCPpdPrice ?>">
				<?php else : ?>
					<label><?= $aValue->FCPpdPrice ?></label>
				<?php endif; ?>
				</div>
		 	</div>
		 <?php endforeach;?>
		 <?php endif;?>
	</div>
</div>