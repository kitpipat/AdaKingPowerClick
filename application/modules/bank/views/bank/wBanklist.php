<div class="panel-heading">
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('product/pdtbrand/pdtbrand','tPBNSearch')?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchBnk" name="oetSearchBnk" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
					<span class="input-group-btn">
						<button id="oimSearchBnk" class="btn xCNBtnSearch" type="button">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEventBank['tAutStaFull'] == 1 || $aAlwEventBank['tAutStaDelete'] == 1 ) : ?>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
					<?php echo language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvModalDelBnk"><?php echo language('common/main/main','tDelAll')?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif; ?>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataBnk"></section>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

<script>
	$('#oimSearchBnk').click(function(){
		JCNxOpenLoading();
		JSvBnkDataTable();
	});
	
	$('#oetSearchBnk').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvBnkDataTable();
		}
	});
</script>
