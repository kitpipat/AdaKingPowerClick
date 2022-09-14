<div class="row xWPkgRow" >
	<div class="row">
		<div class="col-md-12 col-xs-12" style="background:white;">
		
			<button type="button" class="close" onclick="JSxPKGCloseDialogWarning();" style="margin-top:5px;"><span aria-hidden="true">×</span></button>
			<div style="padding-top:10px;">
				<div>
					<img src="<?php echo base_url('application/modules/common/assets/images/icons/warning-50.png'); ?>" style="width: 40px;float:left;">
				</div>
				<div style="padding-left: 50px;">
					<label style="font-size: 18px;"><?= language('ticket/package/package', 'tPkg_WarningPackage')?></label>
					<label style="font-weight:normal;"><?= language('ticket/package/package', 'tPkg_PackageIncompleteDataPleseCheck')?></label>
				</div>
			</div>
			<hr class="xCNHr">
			
		</div>
	</div>
	
	
	<?php if (@$oPkgNoPdtList[0]->FNPkgID != ''): ?>
	<div class="col-md-12 col-xs-12 xCNRemovePadding" style="height:150px;background: white;overflow-x: hidden;overflow-y: auto;">
    <?php
    $i = 1;
    foreach($oPkgNoPdtList AS $aValue): ?>
    
	<div class="row"">
		<div class="col-md-12 col-xs-12" style="background: white;">
			<div class="col-md-12 col-xs-12">
				<div class="col-md-8 col-xs-8 xCNRemovePadding">
					<div>
						<label style="font-weight: normal;"><?= $aValue->FTPkgName ?></label>
					</div>
					<div>
						<label style="font-weight: normal;color:red;"><?= language('ticket/package/package', 'tPkg_NotDefineProduct')?></label>	
					</div>
				</div>
				<div class="col-md-2 col-xs-2 xCNRemovePadding">
					<div style="text-align: left; margin-top: 7px;">
						<i class="fa fa-times" style="font-size: 25px;" onclick="JSxDeletePkgNoPdt('<?= $aValue->FNPkgID ?>')"></i>
					</div>
				</div>
				<div class="col-md-2 col-xs-2 xCNRemovePadding">
					<div style="text-align: right; margin-top: 7px;">
						<i class="fa fa-pencil" style="font-size: 25px;" onclick="JSxCallPageEditPkg('<?= $aValue->FNPkgID ?>')"></i>
					</div>
				</div>
			</div>
			<hr class="xCNHr">
		</div>
		
	</div>
	
	<?php endforeach; ?>
	</div>
	<?php else: ?>
	<div class="row" >
    <div class="col-md-12 col-xs-12" style="background: white;">
		<div class="col-md-12 col-xs-12">
				<?= language('ticket/package/package', 'tPkg_NoData')?>
		</div>
		<hr class="xCNHr">
	</div>
	</div>
	<?php endif ?>
	
	<div class="row" style="background: white;padding-bottom: 20px;">
		&nbsp;
	</div>
</div>