<?php
if ($nStaAddOrEdit == 1) {
	$tRoute = "merchantEventEdit";
	$tMcnCode = $aResult['raItems']['rtMcnCode'];
	$tMcnName = $aResult['raItems']['rtMcnName'];
	$tMcnEmail = $aResult['raItems']['rtMcnEmail'];
	$tMcnTel = $aResult['raItems']['rtMcnTel'];
	$tMcnFax = $aResult['raItems']['rtMcnFax'];
	$tMcnMo	= $aResult['raItems']['rtMcnMo'];
	$tMcnRemark = $aResult['raItems']['rtMcnRmk'];
	$tMenuTabToggle = "tab";
	$tMenuTabDisable = "";
	$tOnclickEventPdtGrp = " onclick='JSxGetMGPContentInfo();'";
} else {
	$tRoute	= "merchantEventAdd";
	$tMcnCode = "";
	$tMcnName = "";
	$tMcnEmail = "";
	$tMcnTel = "";
	$tMcnFax = "";
	$tMcnMo = "";
	$tMcnRemark = "";
	$tMenuTabDisable = "disabled xCNCloseTabNav";
	$tMenuTabDisableV = "disabled xCNCloseTabNav";
	$tMenuTabToggle = "false";
	$tMenuTabToggleV = "false";
	$tOnclickEventPdtGrp = "";
	$tOnclickEventMerchantAddress = "";
}

?>
<input type="hidden" name="ohdMerchantcode" id="ohdMerchantcode" value="<?php echo $tMcnCode; ?>" />
<div class="panel-body">
	<!-- Nav Tab Add Product -->
	<div id="odvPdtRowNavMenu" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<!--ข้อมูลทั่วไป-->
					<li id="oliSHPDetail" class="xWMenu active" data-menutype="DT">
						<a role="tab" data-toggle="tab" data-target="#odvSHPContentInfoDT" aria-expanded="true"><?php echo language('company/shop/shop', 'tNameTabNormal') ?></a>
					</li>
					<!--กลุ่มสินค้า-->
					<li id="oliSHPPOSShop" class="xWMenu xWSubTab <?php echo $tMenuTabDisable ?>" data-menutype="MGP" <?php echo $tOnclickEventPdtGrp; ?>>
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle ?>" data-target="#odvMGPContentInfo" aria-expanded="false"><?php echo language('merchant/merchant/merchant', 'tMCNTBMgp') ?></a>
					</li>
					<!--ที่อยู่-->
					<li id="oliSHPPOSShop" class="xWMenu xWSubTab <?php echo $tMenuTabDisable ?>" data-menutype="PS">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle ?>" data-target="#odvMerchantContentAddress" aria-expanded="false"><?php echo language('merchant/merchant/merchant', 'tMCNAddress') ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>

	<!-- Content tab Add Merchat -->
	<div id="odvPdtRowContentMenu" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="tab-content">
				<!-- Tab Content Detail -->
				<div id="odvSHPContentInfoDT" class="tab-pane fade active in">

					<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddMerchant">
						<button style="display:none" type="submit" id="obtSubmitMerchant" onclick="JSnAddEditMerchant('<?php echo $tRoute ?>')"></button>
						<div class="panel-body" style="padding-top:20px !important;">

							<div class="row">
								<div class="col-xs-12 col-md-6 col-lg-6">
									<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('merchant/merchant/merchant', 'tMCNTBCode') ?></label>
									<div id="odvReasonAutoGenCode" class="form-group">
										<div class="validate-input">
											<label class="fancy-checkbox">
												<input type="checkbox" id="ocbMerchantAutoGenCode" name="ocbMerchantAutoGenCode" checked="true" value="1">
												<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
											</label>
										</div>
									</div>

									<div id="odvMerchantCodeForm" class="form-group">
										<input type="hidden" id="ohdCheckDuplicateMcnCode" name="ohdCheckDuplicateMcnCode" value="1">
										<div class="validate-input">
											<input type="text" class="form-control xCNGenarateCodeTextInputValidate" maxlength="5" id="oetMcnCode" name="oetMcnCode" data-is-created="<?php echo $tMcnCode; ?>" placeholder="<?php echo language('merchant/merchant/merchant', 'tMCNTBCode'); ?>" value="<?php echo $tMcnCode; ?>" data-validate-required="<?php echo language('merchant/merchant/merchant', 'tMCNValidCode') ?>" data-validate-dublicateCode="<?php echo language('merchant/merchant/merchant', 'tMCNValidCodeDup') ?>">
										</div>
									</div>

								</div>
							</div>
							<div class="row">
								<div class="col-xs-12 col-md-6 col-lg-6">
									<div class="form-group">
										<div class="validate-input">
											<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('merchant/merchant/merchant', 'tMCNTBName') ?></label>
											<input type="text" class="form-control" maxlength="200" id="oetMcnName" name="oetMcnName" placeholder="<?php echo language('merchant/merchant/merchant', 'tMCNTBName') ?>" value="<?php echo $tMcnName ?>" data-validate-required="<?php echo language('merchant/merchant/merchant', 'tMCNValidName') ?>">
										</div>
									</div>
									<div class="form-group">
										<label class="xCNLabelFrm"><?= language('merchant/merchant/merchant', 'tMCNEmail') ?></label>
										<input class="form-control" maxlength="100" id="oetMcnEmail" name="oetMcnEmail" value="<?= $tMcnEmail ?>" data-validate-email="<?php echo language('merchant/merchant/merchant', 'tMCNValidEmail') ?>" placeholder="<?php echo language('merchant/merchant/merchant', 'tMCNEmail') ?>">
									</div>
									<div class="form-group">
										<label class="xCNLabelFrm"><?= language('merchant/merchant/merchant', 'tMCNTel') ?></label>
										<input class="form-control " maxlength="50" id="oetMcnTel" name="oetMcnTel" value="<?= $tMcnTel ?>" placeholder="<?php echo language('merchant/merchant/merchant', 'tMCNTel') ?>">
									</div>
									<div class="form-group">
										<label class="xCNLabelFrm"><?= language('merchant/merchant/merchant', 'tMCNFax') ?></label>
										<input class="form-control " maxlength="50" id="oetMcnFax" name="oetMcnFax" value="<?= $tMcnFax ?>" placeholder="<?php echo language('merchant/merchant/merchant', 'tMCNFax') ?>">

									</div>
									<div class="form-group">
										<label class="xCNLabelFrm"><?= language('merchant/merchant/merchant', 'tMCNMo') ?></label>
										<input maxlength="50" class="form-control " maxlength="100" id="oetMcnMo" name="oetMcnMo" value="<?= $tMcnMo ?>" placeholder="<?php echo language('merchant/merchant/merchant', 'tMCNMo') ?>">
									</div>
									<div class="form-group">
										<label class="xCNLabelFrm"><?= language('merchant/merchant/merchant', 'tMCNNote') ?></label>
										<textarea class="form-control" rows="4" maxlength="100" id="otaMcnRemark" name="otaMcnRemark"><?= $tMcnRemark ?></textarea>
									</div>

								</div>
							</div>
						</div>
					</form>

				</div>

				<!-- Tab Content Address-->
				<div id="odvMerchantContentAddress" class="tab-pane fade">
					<div class="row">
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<label id="olbMerchantAddressInfo" class="xCNLabelFrm xCNLinkClick"><?php echo language('merchant/merchant/merchant', 'tMCNAddressTitle'); ?></label>
							<label id="olbMerchantAddressAdd" class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant', 'tMCNAddressTitleAdd'); ?></label>
							<label id="olbMerchantAddressEdit" class="xCNLabelFrm"><?php echo language('merchant/merchant/merchant', 'tMCNAddressTitleEdit'); ?></label>
						</div>
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<div id="odvMerchantBtnGrpInfo">
									<button id="obtMerchantAddressPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
								</div>
								<div id="odvMerchantBtnGrpAddEdit">
									<div class="demo-button xCNBtngroup" style="width:100%;">
										<button id="obtMerchantAddressCancle" type="button" class="btn" style="background-color:#D4D4D4; color:white;">
											<?php echo language('common/main/main', 'tCancel') ?>
										</button>
										<button id="obtMerchantAddressAdd" type="button" class="btn" style="background-color:#179BFD; color:white;">
											<?php echo language('common/main/main', 'tSave') ?>
										</button>
									</div>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div id="odvContentAddress"></div>
					</div>
					<script>
						var tMerchantCode = $('#oetMcnCode').val();
						$(document).ready(function() {
							// Event Click Address
							$('#olbMerchantAddressInfo').unbind().click(function() {
								var nStaSession = JCNxFuncChkSessionExpired();

								if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
									JSxAddressDatatable(tMerchantCode);
								} else {
									JCNxShowMsgSessionExpired();
								}
							});

							// Event Click Add Address
							$('#obtMerchantAddressPageAdd').unbind().click(function() {
								var nStaSession = JCNxFuncChkSessionExpired();
								if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
									JSvCallPageMerchantAddAddress();
								} else {
									JCNxShowMsgSessionExpired();
								}
							});

							// Event Cancel Event Merchant Address
							$('#obtMerchantAddressCancle').unbind().click(function() {
								var nStaSession = JCNxFuncChkSessionExpired();
								if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
									JSxAddressDatatable(tMerchantCode);
								} else {
									JCNxShowMsgSessionExpired();
								}
							});

							// Event Add Event Merchant Address
							$('#obtMerchantAddressAdd').unbind().click(function() {
								var nStaSession = JCNxFuncChkSessionExpired();
								if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
									$('#obtAddEditMerchantAddress').trigger('click');
								} else {
									JCNxShowMsgSessionExpired();
								}
							});

							JSxAddressDatatable(tMerchantCode);
						});
					</script>
				</div>

				<!-- Tab Content MerchantProduct Group -->
				<div id="odvMGPContentInfo" class="tab-pane fade">
				</div>

			</div>
		</div>
	</div>
	<!-- Content tab Add Merchat -->

</div>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include "script/jMerchantAdd.php"; ?>