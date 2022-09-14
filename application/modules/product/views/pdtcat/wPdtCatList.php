
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-8">
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('product/pdtcat/pdtcat','tCATSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchPdtCat" name="oetSearchPdtCat" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
						<span class="input-group-btn">
							<button id="oimSearchPdtCat" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
				<div class="col-lg-6 col-md-6 col-xs-12 col-sm-4 text-right">
					<div class="form-group">
						<label class="xCNLabelFrm hidden-xs"></label>
						<div >
							<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
								<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
									<?= language('common/main/main','tCMNOption')?>
									<span class="caret"></span>
								</button>
								<ul class="dropdown-menu" role="menu">
									<li id="oliBtnDeleteAll" class="disabled">
										<a data-toggle="modal" data-target="#odvModalDelPdtCat"><?= language('common/main/main','tDelAll')?></a>
									</li>
								</ul>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
	<div class="panel-body">
		<div id="ostDataPdtCat"></div>
	</div>


<div class="modal fade" id="odvModalDelPdtCat">
 	<div class="modal-dialog">
  		<div class="modal-content">
        	<div class="modal-header xCNModalHead">
    		<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
   		</div>
        <div class="modal-body">
   			<span id="ospConfirmDelete"> - </span>
    		<input type='hidden' id="ohdConfirmIDDelete">
   		</div>
   		<div class="modal-footer">
    		<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtCatDelChoose()">
     			<?=language('common/main/main', 'tModalConfirm')?>
    		</button>
    		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
     			<?=language('common/main/main', 'tModalCancel')?>
    		</button>
   		</div>
  	</div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>


<script>
	$('#oimSearchPdtCat').click(function(){
		JCNxOpenLoading();
		JSvPdtCatDataTable();
	});
	$('#oetSearchPdtCat').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvPdtCatDataTable();
		}
	});
</script>
