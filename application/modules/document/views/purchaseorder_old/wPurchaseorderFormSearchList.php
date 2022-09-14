


<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-body">
		<section id="ostSearchPromotion">
				<div class="row">
					<div class="col-xs-2 col-md-2">
						<div class="form-group">
							<select class="selectpicker form-control" id="ostBchCode" name="ostBchCode" data-live-search="true">
								<option value="">-- <?= language('document/purchaseorder/purchaseorder','tPOAllBranch')?> --</option>
								<?php if(@is_array($aBchData) == 1): ?>
										<?php foreach($aBchData['raItems'] AS $key=>$aValue){ ?>
											<option value="<?=$aValue['rtBchCode']?>"><?=$aValue['rtBchName']?></option>
									<?php } ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="col-xs-2 col-md-2">
						<div class="form-group">
							<select class="selectpicker form-control" id="ostShpCode" name="ostShpCode" data-live-search="true">
								<option value="">-- <?= language('document/purchaseorder/purchaseorder','tPOShop')?> --</option>
								<?php if(@is_array($aShpData) == 1): ?>
										<?php foreach($aShpData['raItems'] AS $key=>$aValue){ ?>
											<option value="<?=$aValue['rtShpCode']?>"><?=$aValue['rtShpName']?></option>
									<?php } ?>
								<?php endif; ?>
							</select>
						</div>
					</div>
					<div class="col-xs-2 col-md-2">
						<div class="form-group">
								<select class="selectpicker form-control" id="ostXphStaDoc" name="ostXphStaDoc" data-live-search="true">
									<option value="">-- <?= language('document/purchaseorder/purchaseorder','tPOStaDoc')?> --</option>
									<option value="1"><?= language('document/purchaseorder/purchaseorder','tPOStaDoc1')?></option>
									<option value="2"><?= language('document/purchaseorder/purchaseorder','tPOStaDoc2')?></option>
									<option value="3"><?= language('document/purchaseorder/purchaseorder','tPOStaDoc3')?></option>
								</select>
						</div>
					</div>
					<div class="col-xs-2 col-md-2">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphDocDateFrom" name="oetXphDocDateFrom" placeholder="วันที่เอกสาร">
								<span class="input-group-btn">
									<button id="obtXphDocDateFrom" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
					</div>
					<div class="col-xs-2 col-md-2">
						<div class="form-group">
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphDocDateTo" name="oetXphDocDateTo" placeholder="ถึงวันที่">
								<span class="input-group-btn">
									<button id="obtXphDocDateTo" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
					</div>
					
					<div class="col-xs-2 col-md-2">
						<div class="form-group">
								<div class="input-group">
								<input class="form-control xCNInputWithoutSingleQuote" type="text" id="oetXphDocNo" name="oetXphDocNo" placeholder="เลขที่เอกสาร" onkeyup="Javascript:if(event.keyCode==13) JSvCallPagePODataTable()" autocomplete="off">
									<span class="input-group-btn">
										<button type="button" class="btn xCNBtnDateTime" onclick="JSvCallPagePODataTable()">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/search-24.png'?>">
										</button>
									</span>
								</div>
						</div>
					</div>
				</div>
		</section>
	</div>
	<div class="panel-heading"> <!-- เพิ่ม -->
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
			</div>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?= language('common/main/main','tCMNOption')?>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDelPO"><?= language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<section id="odvContentPurchaseorder"></section>
	</div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">

$(document).ready(function(){
	
	$('.selectpicker').selectpicker();

	$('#obtXphDocDateFrom').click(function(){
		event.preventDefault();
		$('#oetXphDocDateFrom').datepicker('show');
	});

	$('#obtXphDocDateTo').click(function(){
		event.preventDefault();
		$('#oetXphDocDateTo').datepicker('show');
	});

	$('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        todayHighlight: true,
	});

	$(".selection-2").select2({
		// minimumResultsForSearch: 20,
		dropdownParent: $('#dropDownSelect1')
	});

	FSvGetSelectShpByBch('');

	$('#ostBchCode').change(function(){
		tBchCode = $(this).val();
		FSvGetSelectShpByBch(tBchCode);
	});

});

</script>