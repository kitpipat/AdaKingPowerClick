<?php if ( isset($oLocTimeTableHD[0]->FNTmhID)): ?>
<?php foreach($oLocTimeTableHD AS $aValue): ?>  
<div class="row" style="padding:5px;">
	<div class="col-md-12 col-xs-12">
		<div class="col-md-1 col-xs-1 xCNRemovePadding">
			<?= $aValue->FNTmhID ?> 
		</div>	
		<div class="col-md-10 col-xs-10 xCNRemovePadding">
			<?= $aValue->FTTmhName ?>
		</div>
		<div class="col-md-1 col-xs-1 text-right xCNRemovePadding">
				<i class="fa fa-list" style="font-size: 15px;" onclick="JSxPkgViewDetailLocShowTime('<?= $aValue->FNTmhID ?> ');"></i>
			<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
				<i class="fa fa-plus-square" style="font-size: 15px;" onclick="JSxPkgAddLocShowTime('<?= $aValue->FNTmhID ?>');"></i>
			<?php endif; ?>
		</div>
	</div>
</div>
<?php endforeach; ?>
<?php endif ?>