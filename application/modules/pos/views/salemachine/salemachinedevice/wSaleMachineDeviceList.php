<div class="panel panel-headline">
	<div class="panel-heading">
		<label id="olaMachineDevice" name="olaMachineDevice"></label>
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchSaleMachineDevice" name="oetSearchSaleMachineDevice" autocomplete="off"  placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
						<span class="input-group-btn">
							<button class="btn xCNBtnSearch" type="button" id="obtSearchSaleMachineDevice" name="obtSearchSaleMachineDevice">
								<img class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?= language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvModalDelSaleMachineDevice"><?= language('common/main/main','tDelAll')?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<div id="ostDataSaleMachineDevice"></div>
	</div>
</div>

<script>
	$('#obtSearchSaleMachineDevice').click(function(){
		var tPosCode = $('#ohdPosCode').val();
		JCNxOpenLoading();
		JSvSaleMachineDeviceDataTable('',tPosCode);
		$
	});
	$('#oetSearchSaleMachineDevice').keypress(function(event){
		if(event.keyCode == 13){
			var tPosCode = $('#ohdPosCode').val();
			JCNxOpenLoading();
			JSvSaleMachineDeviceDataTable('',tPosCode);
		}
	});
	$( document ).ready(function(){
		var nPosCode = $('#ohdPosCode').val();
		$('#olaMachineDevice').text('<?= language('pos/salemachine/salemachine','tPOSTitle');?> ' + nPosCode);
	});
</script>
