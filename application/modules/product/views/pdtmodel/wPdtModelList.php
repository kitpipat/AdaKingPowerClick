<div class="panel panel-headline">
	<div class="panel-heading">
		<div class="row">
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-8">
				<div class="form-group"> 
					<label class="xCNLabelFrm"><?php echo language('product/pdtmodel/pdtmodel','tPMOSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control" id="oetSearchPdtPmo" name="oetSearchPdtPmo" placeholder="<?php echo language('common/main/main','tPlaceholder')?>">
						<span class="input-group-btn">
							<button id="oimSearchPdtPmo" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<?php if($aAlwEventPdtModel['tAutStaFull'] == 1 || $aAlwEventPdtModel['tAutStaDelete'] == 1 ) : ?>
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
										<a data-toggle="modal" data-target="#odvModalDelPdtPmo"><?php echo language('common/main/main','tDelAll')?></a>
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
		<section id="ostDataPdtPmo"></section>
	</div>
</div>
<div class="modal fade" id="odvModalDelPdtPmo">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal"> - </span>
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmConfirm" onClick="JSoPdtPmoDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	$('#oimSearchPdtPmo').click(function(){
		JCNxOpenLoading();
		JSvPdtPmoDataTable();
	});
	$('#oetSearchPdtPmo').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvPdtPmoDataTable();
		}
	});
</script>
