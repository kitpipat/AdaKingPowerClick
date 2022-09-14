<div class="row">
	<div class="col-sm-12">
		 <?php if (isset($oPkgGrpPriDOWList[0]->FNPgpGrpID)): ?>
		 <?php foreach($oPkgGrpPriDOWList AS $aValue): ?>
			<div class="col-sm-2" onclick="<?=$aValue->FNPgpGrpID ?>" style="margin-top:20px;">
				<div style="background:#eeeeee;text-align:center;height: 110px;">
					<label style="margin-top: 25px;"><?= language('ticket/package/package', 'tPkg_PackageDayOfWeek'.$aValue->FNGpdDayOfWeek)?><label>
				</div>
				<div style="margin-top: -40px; text-align:center;"	>
					<?php if($oPkgDetail[0]->FTPkgStaPrcDoc != '1'):?>
						<input type="number" min="0" class="form-control" id="oetEditGpdPrice<?=$aValue->FNGpdDayOfWeek ?>" onkeypress="javascript: if (event.keyCode == 13) {event.preventDefault(); JSnPKGEditGrpPriSpcPriByDOW('<?=$aValue->FNPgpGrpID ?>','<?=$aValue->FNGpdDayOfWeek ?>');}" onfocusout="JSnPKGGrpPriSpcPriByDOWFocusOut();" style="position: relative;width: 94%;margin-left: 5px;text-align:right;" value="<?= $aValue->FCGpdPrice ?>">	
					<?php else : ?>
						<label><?= $aValue->FCGpdPrice ?></label>
					<?php endif; ?>
				</div>
		 	</div>

		 <?php endforeach;?>
		 <?php endif;?>
	 </div>
</div>
