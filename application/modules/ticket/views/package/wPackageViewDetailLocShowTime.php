<div class="row" style="padding:5px;">
	<div class="col-md-12 col-xs-12">
		<div class="col-md-6 col-xs-6 xCNRemovePadding">
			<?php if ( isset($oDetailTimeTable[0]->FTTmhName)): ?>
				<span style="font-weight:bold;"><?= $oDetailTimeTable[0]->FTTmhName ?></span>
			<?php endif;?>
		</div>
		<div class="col-md-6 col-xs-6 text-right xCNRemovePadding">
			<i class="fa fa-arrow-left" style="font-size: 20px;" onclick="JSxPkgModalShowTimeBack();"></i>&nbsp;&nbsp;
			<?php if ( isset($oDetailTimeTable[0]->FNTmhID)): ?>
				<i class="fa fa-plus-square" style="font-size: 20px;" onclick="JSxPkgAddLocShowTime('<?= $oDetailTimeTable[0]->FNTmhID ?>');"></i>
			<?php endif;?>
		</div>
	</div>
	<div class="col-md-12 col-xs-12" style="background: #eeeeee;">
		<div class="col-md-6 col-xs-6 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_StartTime')?> 
		</div>	
		<div class="col-md-6 col-xs-6 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_EndTime')?> 
		</div>
	</div>
</div>
<?php if ( isset($oDetailTimeTable[0]->FNTmhID)): ?>
<?php foreach($oDetailTimeTable AS $aValue): ?>  
<div class="row" style="padding-left:5px;">
	<div class="col-md-12 col-xs-12">
		<div class="col-md-6 col-xs-6 xCNRemovePadding">
			<?= $aValue->FTTmdStartTime ?> 
		</div>	
		<div class="col-md-6 col-xs-6 xCNRemovePadding">
			<?= $aValue->FTTmdEndTime ?>
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php else: ?>
<div class="row" style="padding-left:5px;">
	<div class="col-md-12 col-xs-12">
		<div class="col-md-12 col-xs-12 xCNRemovePadding">
			<?= language('ticket/package/package', 'tPkg_NoFoundDataTime')?>
		</div>	
	</div>
</div>
<?php endif;?>
