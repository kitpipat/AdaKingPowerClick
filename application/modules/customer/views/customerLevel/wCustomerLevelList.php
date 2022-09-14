<div class="panel-heading">
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" onkeypress="javascript:if(event.keyCode==13) JSvCstLevDataTable()" autocomplete="off" placeholder="<?= language('customer/customerLevel/customerLevel','tCstLevSearchData')?>">
					<span class="input-group-btn">
						<button id="oimSearchCstLev" class="btn xCNBtnSearch" type="button" onclick="JSvCstLevDataTable()">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?php echo language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a href="javascript:;" data-toggle="modal" data-target="#odvModalDelCstLev" onclick="JSxCstLevSetDataBeforeDelMulti()"><?= language('common/main/main','tCMNDeleteAll')?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataCstLev"></section>
</div>
	
<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

<div class="modal fade" id="odvModalDelCstLev">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"></span>
				<span id="ospCode"></span>			
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" onClick="JSnCstLevDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
                        <?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>
