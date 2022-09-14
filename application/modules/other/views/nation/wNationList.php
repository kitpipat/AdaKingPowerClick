<div class="panel-heading">
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('other/nation/nation', 'tRSNTBCSearch') ?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvNationDataTable()" autocomplete="off" name="oetSearchAll" placeholder="<?php echo language('common/main/main', 'tPlaceholder') ?>">
					<span class="input-group-btn">
						<button id="oimSearchCard" class="btn xCNBtnSearch" type="button">
							<img onclick="JSvNationDataTable()" class="xCNIconBrowse" src="<?= base_url() . '/application/modules/common/assets/images/icons/search-24.png' ?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList">
				<button id="oimAPI" class="btn xCNBtnSearch" type="button" onclick="JSvNationDataTableAPI()">
					API
				</button>
			</div>
		</div>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataNationTableList"></section>
</div>

<div class="modal fade" id="odvModalAPINation">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block">API Nation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				ต้องการดึงข้อมูลประเทศใช่หรือไม่ ?
			</div>
			<div class="modal-footer">
				<button id="osmConfirmAPINation" type="button" class="btn xCNBTNPrimery" onClick="JSnReasonDelChoose()">
					<i class="fa fa-check-circle" aria-hidden="true"></i> <?= language('common/main/main', 'tModalConfirm') ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<i class="fa fa-times-circle" aria-hidden="true"></i> <?= language('common/main/main', 'tModalCancel') ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script>
	$('#oimSearchCard').click(function() {
		JCNxOpenLoading();
		JSvNationDataTable();
	});
	$('#oetSearchAll').keypress(function(event) {
		if (event.keyCode == 13) {
			JCNxOpenLoading();
			JSvNationDataTable();
		}
	});
</script>