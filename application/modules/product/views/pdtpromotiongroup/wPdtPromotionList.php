<div class="panel-heading">
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('product/pdtpromotion/pdtpromotion','tPMGSearch')?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchPdtPmgGrp" name="oetSearchPdtPmgGrp" placeholder="<?php echo language('product/pdtpromotion/pdtpromotion','tPMGSearch')?>">
					<span class="input-group-btn">
						<button id="oimSearchPdtPmgGrp" class="btn xCNBtnSearch" type="button">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || $aAlwEventPdtPromotion['tAutStaDelete'] == 1 ) : ?>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
					<?php echo language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvModalDelPdtPmgGrp"><?php echo language('common/main/main','tDelAll')?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataPdtPmgGrp"></section>
</div>
<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<script>
	$('#oimSearchPdtPmgGrp').click(function(){
		JCNxOpenLoading();
		JSvPdtPmgGrpDataTable();
	});
	$('#oetSearchPdtPmgGrp').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvPdtPmgGrpDataTable();
		}
	});
</script>
