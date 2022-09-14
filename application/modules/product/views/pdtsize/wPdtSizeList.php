<div class="panel panel-headline"> 
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-8">
				<div class="form-group"> 
					<label class="xCNLabelFrm"><?php echo language('product/pdtsize/pdtsize','tPSZSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchPdtPsz" name="oetSearchPdtPsz" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
						<span class="input-group-btn">
							<button id="oimSearchPdtPsz" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<?php if($aAlwEventPdtSize['tAutStaFull'] == 1 || $aAlwEventPdtSize['tAutStaDelete'] == 1 ) : ?>
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-4 text-right">
					<div class="form-group"> 
						<label class="xCNLabelFrm hidden-xs"></label>
						<div >
							<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
								<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
									<?php echo language('common/main/main','tCMNOption')?>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li id="oliBtnDeleteAll" class="disabled">
										<a data-toggle="modal" data-target="#odvModalDelPdtPsz"><?php echo language('common/main/main','tDelAll')?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="panel-body">
		<section id="ostDataPdtPsz"></section>
	</div>
</div>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
	$('#oimSearchPdtPsz').click(function(){
		JCNxOpenLoading();
		JSvPdtPszDataTable();
	});
	$('#oetSearchPdtPsz').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvPdtPszDataTable();
		}
	});
</script>
