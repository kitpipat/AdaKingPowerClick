<div class="panel panel-headline"> 
	<div class="panel-heading"> 
		<div class="row">
			<div class="col-lg-4 col-md-4 col-xs-12 col-sm-12">
				<div class="form-group">
					<label class="xCNLabelFrm"><?php echo language('payment/installmentterms/installmentterms','tSTMSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control" id="oetSearchGroupSupplier" name="oetSearchGroupSupplier" placeholder="<?php echo language('payment/installmentterms/installmentterms','tSTMSearchData')?>">
						<span class="input-group-btn">
							<button id="oimSearchGroupSupplier" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-lg-8 col-md-8 col-xs-12 col-sm-12 text-right">
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
									<a data-toggle="modal" data-target="#odvStmModalDelete"><?php echo language('common/main/main','tDelAll')?></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<section id="ostStmContentDataTable"></section>
	</div>
</div>
<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

<div class="modal fade" id="odvStmModalDelete">
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
				<button id="osmConfirm" onClick="JSoStmDeleteChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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
	$('#oimSearchGroupSupplier').click(function(){
		JCNxOpenLoading();
		JSvStmCallPageDataTable();
	});
	$('#oetSearchGroupSupplier').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvStmCallPageDataTable();
		}
	});
</script>
