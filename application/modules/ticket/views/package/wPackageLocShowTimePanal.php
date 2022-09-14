<div class="row">
	<div class="col-md-12 col-xs-12" style="background: #eeeeee;">
		<div class="col-md-1 col-xs-1 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_Round')?>
		</div>	
		<div class="col-md-4 col-xs-4 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_TblName')?>
		</div>
		<div class="col-md-3 col-xs-3 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_RoundStartsFromDate')?>
		</div>
		<div class="col-md-3 col-xs-3 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_RoundToDate')?>
		</div>
		<div class="col-md-4 col-xs-4 text-right xCNRemovePadding">
		</div>
	</div>
</div>
<?php if ( isset($oLocShwTime[0]->FNEvnID)): ?>
<?php foreach($oLocShwTime AS $aValue): ?>  
<div class="row" style="padding:5px;">
	<div class="col-md-12 col-xs-12">
		<div class="col-md-1 col-xs-1 xCNRemovePadding">
			<?= $aValue->FNTmhID ?> 
		</div>	
		<div class="col-md-4 col-xs-4 xCNRemovePadding">
			<?= $aValue->FTTmhName ?>
		</div>
		<div class="col-md-3 col-xs-3 xCNRemovePadding">
			<?= $aValue->FDShwStartDate ?> 
			<?= $aValue->FTShwStartTime ?> 
		</div>
		<div class="col-md-3 col-xs-3 xCNRemovePadding">
			<?= $aValue->FDShwEndDate ?> 
			<?= $aValue->FTShwEndTime ?> 
		</div>
		<div class="col-md-1 col-xs-1 text-right xCNRemovePadding">
			<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
				<i class="fa fa-times" style="font-size: 20px;" onclick="JSxPkgDelLocShowTime('<?= $aValue->FNEvnID ?>','<?= $aValue->FNLocID ?>','<?= $aValue->FNTmhID ?>');"></i>
			<?php endif; ?>
			
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php endif ?>