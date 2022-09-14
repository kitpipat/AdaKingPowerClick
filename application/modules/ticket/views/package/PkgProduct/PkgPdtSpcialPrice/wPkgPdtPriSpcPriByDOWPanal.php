<div class="row">
	<div class="col-sm-12">
		 <?php if (isset($oPkgPdtPriDOWList[0]->FNPkgPdtID)): ?>
		 <?php foreach($oPkgPdtPriDOWList AS $aValue): ?>
			<div class="col-sm-2" onclick="<?=$aValue->FNPkgPdtID ?>" style="margin-top:20px;">
				<div style="background:#eeeeee;text-align:center;height: 110px;">
					<label style="margin-top: 25px;"><?= language('ticket/package/package', 'tPkg_PackageDayOfWeek'.$aValue->FNPpdDayOfWeek)?><label>
				</div>
				<div style="margin-top: -40px; text-align:center;">
					<?php if($oPkgDetail[0]->FTPkgStaPrcDoc != '1'):?>
						<input type="number" min="0" class="form-control" id="oetEditPdtPrice<?=$aValue->FNPpdDayOfWeek ?>" style="position: relative;width: 94%;margin-left: 5px;text-align:right;" onkeypress="javascript: if (event.keyCode == 13) {event.preventDefault(); JSnPKGEditPdtPriSpcPriByDOW('<?=$aValue->FNPkgPdtID ?>','<?=$aValue->FNPpdDayOfWeek ?>');}" onfocusout="JSnPKGPdtPriSpcPriByDOWFocusOut();" value="<?= $aValue->FCPpdPrice ?>">
					<?php else : ?>
						<label><?= $aValue->FCPpdPrice ?></label>
					<?php endif; ?>
				</div>
		 	</div>
		 <?php endforeach;?>
		 <?php endif;?>
	 </div>
</div>