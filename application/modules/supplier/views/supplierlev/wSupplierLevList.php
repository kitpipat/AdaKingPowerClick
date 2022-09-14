<div class="panel panel-headline"> 
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-8">
				<div class="form-group"> 
					<label class="xCNLabelFrm"><?php echo language('supplier/supplierlev/supplierlev','tSLVSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control" id="oetSearchSupplierLevel" name="oetSearchSupplierLevel" placeholder="<?php echo language('supplier/supplierlev/supplierlev','tSLVSearchData')?>">
						<span class="input-group-btn">
							<button id="oimSearchSupplierLevel" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<?php if($aAlwEventSupplierLevel['tAutStaFull'] == 1 || $aAlwEventSupplierLevel['tAutStaDelete'] == 1 ) : ?>
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
										<a data-toggle="modal" data-target="#odvModalDelSupplierLevel"><?php echo language('common/main/main','tDelAll')?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			<?php endif; ?>
		</div>
	</div>
	<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
	<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
	<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

	<div class="panel-body">
		<section id="ostDataSupplierLevel"></section>
	</div>
</div>

<script>
	$('#oimSearchSupplierLevel').click(function(){
		JCNxOpenLoading();
		JSvSupplierLevelDataTable();
	});
	$('#oetSearchSupplierLevel').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvSupplierLevelDataTable();
		}
	});
</script>
