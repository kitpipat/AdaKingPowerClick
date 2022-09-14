<div class="panel-heading">
	<div class="row">
		<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch')?></label>
				<div class="input-group">
					<input
						type="text"
						class="form-control"
						id="oetSearchAll"
						name="oetSearchAll"
						onkeypress="Javascript:if(event.keyCode==13) JSvCstGrpDataTable()"
						placeholder="<?php echo language('customer/customerGroup/customerGroup','tCstGroupSearchData')?>"
					>
					<span class="input-group-btn">
						<button id="oimSearchCstGrp" class="btn xCNBtnSearch" type="button" onclick="JSvCstGrpDataTable()">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ):?>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?php echo language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a href="javascript:;" data-toggle="modal" data-target="#odvModalDelCstGrp" onclick="JSxCstGrpSetDataBeforeDelMulti()"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
				</div>
			</div>
		<?php endif;?>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataCstGrp"></section>
</div>

<div class="modal fade" id="odvModalDelCstGrp">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
			<span id="ospConfirmDelete"></span>
			<span id="ospCode"></span>
			<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
			<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
			<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">
				
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnCstGrpDelChoose()">
					<?=language('common/main/main', 'tModalConfirm')?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>
