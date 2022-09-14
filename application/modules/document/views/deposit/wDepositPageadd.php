<?php
if ($aResult['rtCode'] == "1") { // Edit

	$tDocNo = $aResult['raItems']['FTBdhDocNo'];
	$tDocDate = $aResult['raItems']['FDBdhDate'];
	$tDocTime = $aResult['raItems']['FTXthDocTime'];
	$tCreateByCode = $aResult['raItems']['FTCreateBy'];
	$tCreateByName = $aResult['raItems']['FTCreateByName'];
	$tBdtCode = $aResult['raItems']['FTBdtCode'];
	$tBdtName = $aResult['raItems']['FTBdtName'];
	$tStaDoc = $aResult['raItems']['FTBdhStaDoc'];
	$tStaApv = $aResult['raItems']['FTBdhStaApv'];
	$tUsrApvCode = $aResult['raItems']['FTBdhUsrApv'];
	$tUsrApvName = $aResult['raItems']['FTUsrNameApv'];
	$tUsrCode = $aResult['raItems']['FTUsrCode']; // ผู้บันทึก
	$tBbkCode = $aResult['raItems']['FTBbkCode'];
	$tBbkName = $aResult['raItems']['FTBbkName'];
	$tBbkBchName = $aResult['raItems']['FTBbkBchName'];
	$tBbkType = $aResult['raItems']['FTBbkType'];
	$tBbkAccNo = $aResult['raItems']['FTBbkAccNo'];
	// $tStaDelMQ = $aResult['raItems']['FTXthStaDelMQ'];
	$tBchCode = $aResult['raItems']['FTBchCode'];
	$tBchName = $aResult['raItems']['FTBchName'];
	$tMchCode = $aResult['raItems']['FTMerCode'];
	$tMchName = $aResult['raItems']['FTMerName'];
	$tShpCode = $aResult['raItems']['FTShpCode'];
	$tShpName = $aResult['raItems']['FTShpName'];
	$tRefExt = $aResult['raItems']['FTBdhRefExt'];
	$tRefExtDate = $aResult['raItems']['FDBdhRefExtDate'];
	$nStaDocAct = $aResult['raItems']['FNBdhStaDocAct'];
	// $nDocPrint = $aResult['raItems']['FNXthDocPrint'];
	$tRmk = $aResult['raItems']['FTBdhRmk'];
	$tBNKName = $aResult['raItems']['FTBnkName'];

	$tRoute = "depositEventEdit";

	if (isset($aAlwEvent)) {
		if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) {
			$nAutStaEdit = 1;
		} else {
			$nAutStaEdit = 0;
		}
	} else {
		$nAutStaEdit = 0;
	}

	$tUserBchCode = $tBchCode;
	$tUserBchName = $tBchName;
	$tUserMchCode = $tMchCode;
	$tUserMchName = $tMchName;
	$tUserShpCode = $tShpCode;
	$tUserShpName = $tShpName;

} else { // New
	$tDocNo = "";
	$tDocDate = date('Y-m-d');
	$tDocTime = date('H:i');
	$tCreateByCode = $this->session->userdata('tSesUsername');
	$tCreateByName = $this->session->userdata('tSesUsrUsername');
	$tBdtCode = "";
	$tBdtName = "";
	$tUsrCode = $this->session->userdata('tSesUsername');
	$tBbkCode = "";
	$tBbkName = "";
	$tBbkBchName = "";
	$tBbkType = "";
	$tBbkAccNo = "";
	$tStaDoc = "";
	$tStaApv = "";
	$tUsrApvCode = "";
	$tUsrApvName = "";
	// $tStaDelMQ = "";
	$tBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
	$tBchName = $this->session->userdata("tSesUsrBchNameDefault");
	$tMchCode = "";
	$tMchName = "";
	$tShpCode = "";
	$tShpName = "";
	$tRefExt = "";
	$tRefExtDate = "";
	$nStaDocAct = "1";
	$tBNKName = "";
	// $nDocPrint = "0";
	$tRmk = "";
	$tRoute = "depositEventAdd";
	$nAutStaEdit = 0;

	$tUserBchCode = "";
	$tUserBchName = "";
	$tUserMchCode = "";
	$tUserMchName = "";
	$tUserShpCode = "";
	$tUserShpName = "";

	if ($this->session->userdata('tSesUsrLevel') == 'HQ') {
		$tUserBchCode = $tBchCompCode;
		$tUserBchName = $tBchCompName;
	}
	if ($this->session->userdata('tSesUsrLevel') == 'BCH') {
		$tUserBchCode = $this->session->userdata('tSesUsrBchCode');
		$tUserBchName = $this->session->userdata('tSesUsrBchName');
	}
	if ($this->session->userdata('tSesUsrLevel') == 'SHP') {
		$tUserBchCode = $this->session->userdata('tSesUsrBchCode');
		$tUserBchName = $this->session->userdata('tSesUsrBchName');

		$tUserMchCode = $this->session->userdata('tSesUsrMerCode');
		$tUserMchName = $this->session->userdata('tSesUsrMerName');

		$tUserShpCode = $this->session->userdata('tSesUsrShpCode');
		$tUserShpName = $this->session->userdata('tSesUsrShpName');

		$tUserWahCode = $this->session->userdata('tSesUsrWahCode');
		$tUserWahName = $this->session->userdata('tSesUsrWahName');
	}
}

$nLangEdit = $this->session->userdata("tLangEdit");
$tUsrApv = $this->session->userdata("tSesUsername");
$tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
$bIsAddPage = empty($tDocNo) ? true : false;
$bIsApv = empty($tStaApv) ? false : true;
$bIsCanCel = ($tStaDoc == "3") ? true : false;
$bIsApvOrCanCel = ($bIsApv || $bIsCanCel);
$bIsMultiBch = $this->session->userdata("nSesUsrBchCount") > 1;
$bIsShpEnabled = FCNbGetIsShpEnabled();
?>
<script>
	var nLangEdit = '<?php echo $nLangEdit; ?>';
    var tUsrApv = '<?php echo $tUsrApv; ?>';
    var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
    var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
    var bIsApv = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
    var bIsCancel = <?php echo ($bIsCanCel) ? 'true' : 'false'; ?>;
    var bIsApvOrCancel = <?php echo ($bIsApvOrCanCel) ? 'true' : 'false'; ?>;
    var bIsMultiBch = <?php echo ($bIsMultiBch) ? 'true' : 'false'; ?>;
	var bIsShpEnabled = <?php echo ($bIsShpEnabled) ? 'true' : 'false'; ?>;
</script>

<style>
	.xCNBTNPrimeryCusPlus {
		border-radius: 50%;
		float: right;
		width: 30px;
		height: 30px;
		line-height: 30px;
		background-color: #179BFD;
		text-align: center;
		margin-top: 8px;
		/* margin-right: -15px; */
		font-size: 29px;
		color: #ffffff;
		cursor: pointer;
		-webkit-border-radius: 50%;
		-moz-border-radius: 50%;
		-ms-border-radius: 50%;
		-o-border-radius: 50%;
	}
	.fancy-checkbox {
		display: inline-block;
		font-weight: normal;
		width: 120px;
	}
	.xCNDepositTotalLabel {
		background-color: #f5f5f5;
		padding: 5px 10px;
		color: #232C3D !important;
		font-weight: 900;
	}
	.xCNDepositLabel {
		padding: 5px 10px;
		color: #232C3D !important;
		font-weight: 900;
	}
	.xCNDepositLabelFullWidth{
		width: 100%;
	}
	.xCNDepositLabelWidth{
		width: 260px;
	}
</style>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmDepositForm">
	<input type="hidden" id="ohdDepositStaApv" name="ohdDepositStaApv" value="<?php echo $tStaApv; ?>">
	<input type="hidden" id="ohdDepositStaDelMQ" name="ohdDepositStaDelMQ" value="<?php // echo $tStaDelMQ; ?>">
	<input type="text" class="xCNHide" id="oetDepositApvCodeUsrLogin" name="oetDepositApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<button style="display:none" type="submit" id="obtDepositSubmit" onclick="JSxDepositValidateForm();"></button>

	<div class="row">
		<!--Panel เงื่อนไข-->
		<div class="col-md-3">
			<!--Section : เงื่อนไข-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?= language('document/deposit/deposit', 'tStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?= language('document/deposit/deposit', 'tApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton">
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/deposit/deposit', 'tDocNo'); ?></label>
						<?php if ($bIsAddPage) { ?>
							<div class="form-group" id="odvDepositAutoGenCode">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbDepositAutoGenCode" name="ocbDepositAutoGenCode" checked="true" value="1">
										<span><?= language('document/deposit/deposit', 'tAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="odvPunCodeForm">
								<input
								type="text"
								class="form-control xCNInputWithoutSpcNotThai"
								maxlength="20"
								id="oetDepositDocNo"
								name="oetDepositDocNo"
								data-is-created="<?php  ?>"
								placeholder="<?= language('document/deposit/deposit', 'tDocNo') ?>"
								value="<?php  ?>" data-validate-required="<?= language('document/deposit/deposit', 'tDocNoRequired') ?>"
								data-validate-dublicateCode="<?= language('document/deposit/deposit', 'tDocNoDuplicate') ?>"
								disabled readonly>
								<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW">
							</div>
						<?php } else { ?>
							<div class="form-group" id="odvPunCodeForm">
								<div class="validate-input">
									<input type="text" class="form-control xCNInputWithoutSpcNotThai xCNApvOrCanCelDisabled" maxlength="20" id="oetDepositDocNo" name="oetDepositDocNo" data-is-created="<?php  ?>" placeholder="<?= language('document/deposit/deposit', 'tTFWDocNo') ?>" value="<?php echo $tDocNo; ?>" readonly onfocus="this.blur()">
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/deposit/deposit', 'tDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetDepositDocDate" name="oetDepositDocDate" value="<?= $tDocDate; ?>" data-validate-required="<?= language('document/deposit/deposit', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/deposit/deposit', 'tDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetDepositDocTime" name="oetDepositDocTime" value="<?= $tDocTime; ?>" data-validate-required="<?= language('document/deposit/deposit', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/deposit/deposit', 'tCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateByCode ?>">
								<label><?= $tCreateByName ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/deposit/deposit', 'tTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/deposit/deposit', 'tStaDoc' . $tStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/deposit/deposit', 'tTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/deposit/deposit', 'tStaApv' . $tStaApv); ?></label>
							</div>
						</div>
						<?php if ($tDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?= language('document/deposit/deposit', 'tApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?= $tUsrApvCode ?>">
									<label><?= $tUsrApvName != '' ? $tUsrApvName : language('document/deposit/deposit', 'tStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!-- Section : เงื่อนไขการนำฝาก -->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/deposit/deposit', 'tDepositCondition'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvCondition" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>

				<div id="odvCondition" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- สาขาที่สร้าง -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'สาขาที่สร้าง'); ?></label>
							<div class="input-group">
								<input
								type="text"
								class="input100 xCNHide"
								id="oetDepositBchCode"
								name="oetDepositBchCode"
								maxlength="5"
								value="<?php echo $tBchCode; ?>">
								<input
								class="form-control xWPointerEventNone"
								type="text" id="oetDepositBchName"
								name="oetDepositBchName"
								value="<?php echo $tBchName; ?>"
								readonly>
								<span class="input-group-btn xWConditionSearchPdt">
									<button id="obtDepositBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						<!-- สาขาที่สร้าง -->

						<!--ประเภทธุรกิจ-->
						<!-- <div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tBusinessType'); ?></label>
							<div class="input-group">
								<input name="oetDepositMchName" id="oetDepositMchName" class="form-control" value="<?php echo $tUserMchName; ?>" type="text" readonly placeholder="<?= language('document/producttransferwahouse/producttransferwahouse', 'tBusinessType') ?>">
								<input name="oetDepositMchCode" id="oetDepositMchCode" value="<?php echo $tUserMchCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtDepositBrowseMer" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div> -->
						<input name="oetDepositMchCode" id="oetDepositMchCode" value="" class="form-control xCNHide" type="text">


						<!--ร้านค้า-->
						<!-- <div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/deposit/deposit', 'tShop'); ?></label>
							<div class="input-group">
								<input name="oetDepositShpName" id="oetDepositShpName" class="form-control" value="<?php echo $tUserShpName; ?>" type="text" readonly="" placeholder="<?= language('document/deposit/deposit', 'tTFWShop') ?>">
								<input name="oetDepositShpCode" id="oetDepositShpCode" value="<?php echo $tUserShpCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtDepositBrowseShp" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div> -->

						<!--เข้าบัญชี-->
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/deposit/deposit', 'tIntoAccount'); ?></label>
							<div class="input-group">
								<input
								name="oetDepositAccountNameTo"
								id="oetDepositAccountNameTo"
								class="form-control"
								value="<?php echo $tBbkName; ?>"
								type="text"
								readonly
								placeholder="<?= language('document/deposit/deposit', 'tIntoAccount') ?>">
								<input name="oetDepositAccountCodeTo" id="oetDepositAccountCodeTo" value="<?php echo $tBbkCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn" id="obtDepositBrowseAccountTo" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!-- สาขา -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?=Language('document/deposit/deposit', 'tBCH'); ?></label>
							<input
							readonly
							type="text"
							class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
							id="oetDepositShowBCH"
							name="oetDepositShowBCH"
							value="<?php echo $tBbkBchName ?>">
						</div>

						<!-- ชื่อธนาคาร -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?=Language('document/deposit/deposit', 'tBank'); ?></label>
							<input
							readonly
							type="text"
							class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
							id="oetDepositShowBANK"
							name="oetDepositShowBANK"

							value="<?php echo $tBNKName ?>">
						</div>

						<!-- ประเภทบัญชี แสดงอย่างเดียว -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tAccountType'); ?></label>
							<input
							readonly
							type="text"
							class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
							id="oetDepositAccountType"
							name="oetDepositAccountType"
							maxlength="20"
							<?php
							$tBbkTypeText = '';
							switch($tBbkType){
								case "1" : {
									$tBbkTypeText = language('document/deposit/deposit', 'tSaveUp');
									break;
								}
								case "2" : {
									$tBbkTypeText = language('document/deposit/deposit', 'tCurrentAccount');
									break;
								}
								case "3" : {
									$tBbkTypeText = language('document/deposit/deposit', 'tRegular');
									break;
								}
								default : {}
							}
							?>
							value="<?php echo $tBbkTypeText ?>">
						</div>

						<!-- เลขที่บัญชี แสดงอย่างเดียว -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tAccountNumber'); ?></label>
							<input
							readonly
							type="text"
							class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
							id="oetDepositAccountID"
							name="oetDepositAccountID"

							value="<?php echo $tBbkAccNo ?>">
						</div>

						<!--ประเภทรายการฝาก-->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tDepositTypeList'); ?></label>
						</div>
						<div class="form-group">
							<label class="fancy-checkbox">
								<input
								type="checkbox"
								class="xCNApvOrCanCelDisabled"
								value="1"
								id="ocbDepositCashType"
								name="ocbDepositCashType"
								disabled
								checked
								maxlength="1">
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tCash'); ?></span>
							</label>
							<label class="fancy-checkbox">
								<input
								type="checkbox"
								class="xCNApvOrCanCelDisabled"
								value="1"
								id="ocbDepositChequeType"
								name="ocbDepositChequeType"
								disabled
								maxlength="1">
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tCheque'); ?></span>
							</label>
						</div>

						<!--ประเภทการนำฝาก-->
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tDepositType'); ?></label>
							<div class="input-group">
								<input
								name="oetDepositTypeName"
								id="oetDepositTypeName"
								class="form-control"
								value="<?php echo $tBdtName; ?>"
								type="text"
								readonly
								placeholder="<?= language('document/producttransferwahouse/producttransferwahouse', 'tDepositType') ?>"
								data-validate-required="<?= language('document/deposit/deposit', 'tTopUpVendingMerValidate') ?>">
								<input name="oetDepositTypeCode" id="oetDepositTypeCode" value="<?php echo $tBdtCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtDepositBrowseDepositType" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--ผู้นำฝาก-->
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tDepositor'); ?></label>
							<div class="input-group">
								<input
								name="oetDepositUsrName"
								id="oetDepositUsrName"
								class="form-control"
								value="<?php echo $tCreateByName; ?>"
								type="text"
								readonly
								placeholder="<?= language('document/producttransferwahouse/producttransferwahouse', 'tDepositor') ?>"
								data-validate-required="<?= language('document/deposit/deposit', 'tTopUpVendingMerValidate') ?>">
								<input name="oetDepositUsrCode" id="oetDepositUsrCode" value="<?php echo $tUsrCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtDepositBrowseUsr" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Section : ข้อมูลอ้างอิง-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/deposit/deposit', 'tReference'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDataGeneralInfo" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataGeneralInfo" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- เลขที่อ้างอิงเอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tRefExt'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									id="oetDepositBdhRefExt"
									name="oetDepositBdhRefExt"
									maxlength="20"
									value="<?php echo $tRefExt ?>">
								</div>
							</div>
						</div>
						<!-- วันที่เอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tRefExtDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetDepositBdhRefExtDate"
										name="oetDepositBdhRefExtDate"
										value="<?php echo $tRefExtDate ?>">
										<span class="input-group-btn">
											<button id="obtXthRefExtDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Section : อื่นๆ-->
			<div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/deposit/deposit', 'tOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tNote'); ?></label>
							<textarea class="form-control xCNApvOrCanCelDisabled" id="otaDepositBdhRmk" name="otaDepositBdhRmk"><?php echo $tRmk; ?></textarea>
						</div>
						<div class="form-group">
							<label class="fancy-checkbox">
								<input
								type="checkbox"
								class="xCNApvOrCanCelDisabled"
								value="1"
								id="ocbDepositBdhStaDocAct"
								name="ocbDepositBdhStaDocAct"
								maxlength="1" <?php echo $nStaDocAct == '1' ? 'checked' : ''; ?>>
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tTFWStaDocAct'); ?></span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Panel ตารางฝั่งขวา-->
		<div class="col-md-9" id="odvRightPanal">
			<div class="panel panel-default xCNDepositCashContainer" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/deposit/deposit', 'tCashDepositItem'); ?></label>
					<div style="position: absolute;right: 15px;top:-5px;">
						<?php if(!$bIsApvOrCanCel) { ?>
							<button type="button" class="xCNBTNPrimeryCusPlus" data-toggle="modal" data-target="#odvDepositPopupCashAdd">+</button>
						<?php } ?>
					</div>
				</div>

				<!-- รายการนำฝากเงินสด -->
				<div class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div id="odvDepositCashDataTable"></div>
					</div>
				</div>
			</div>


			<div class="panel panel-default xCNDepositChequeContainer" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/deposit/deposit', 'tChequeDepositItem'); ?></label>
					<div style="position: absolute;right: 15px;top:-5px;">
						<?php if(!$bIsApvOrCanCel) { ?>
							<button type="button" class="xCNBTNPrimeryCusPlus" data-toggle="modal" data-target="#odvDepositPopupChequeAdd">+</button>
						<?php } ?>
					</div>
				</div>

				<!-- รายการนำฝากเช็ค -->
				<div class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div id="odvDepositChequeDataTable"></div>
					</div>
				</div>
			</div>

			<div class="panel panel-default xCNDepositFootTotalContainer" style="margin-bottom: 25px;">
				<!-- รวม Cash-Cheque -->
				<div class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="row">
							<div class="col-md-7 text-left">
								<label class="xCNDepositTotalText xCNDepositTotalLabel xCNDepositLabelFullWidth"></label>
							</div>
							<div class="col-md-5 text-right">
								<div class="xCNDepositLabelFullWidth">
									<label class="xCNDepositCashTotalLabel xCNDepositLabel pull-left"><?php echo language('document/deposit/deposit', 'tGrandTotal'); ?></label><label class="xCNDepositTotal xCNDepositTotalLabel xCNDepositLabelWidth"></label>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</form>

<?php if(!$bIsApvOrCanCel) { ?>
	<!-- Begin Approve Doc -->
	<div class="modal fade xCNModalApprove" id="odvDepositPopupApv">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tApproveTheDocument'); ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<p><?php echo language('common/main/main', 'tMainApproveStatus'); ?></p>
					<ul>
						<li><?php echo language('common/main/main', 'tMainApproveStatus1'); ?></li>
						<li><?php echo language('common/main/main', 'tMainApproveStatus2'); ?></li>
						<li><?php echo language('common/main/main', 'tMainApproveStatus3'); ?></li>
						<li><?php echo language('common/main/main', 'tMainApproveStatus4'); ?></li>
					</ul>
					<p><?php echo language('common/main/main', 'tMainApproveStatus5'); ?></p>
					<p><strong><?php echo language('common/main/main', 'tMainApproveStatus6'); ?></strong></p>
				</div>
				<div class="modal-footer">
					<button onclick="JSvDepositApprove(true)" type="button" class="btn xCNBTNPrimery">
						<?php echo language('common/main/main', 'tModalConfirm'); ?>
					</button>
					<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
						<?php echo language('common/main/main', 'tModalCancel'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Approve Doc -->

	<!-- Begin Cancel Doc -->
	<div class="modal fade" id="odvDepositPopupCancel">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header xCNModalHead">
					<label class="xCNTextModalHeard"><?php echo language('document/document/document', 'tDocDocumentCancel') ?></label>
				</div>
				<div class="modal-body">
					<p id="obpMsgApv"><?php echo language('document/document/document', 'tDocCancelText1') ?></p>
					<p><strong><?php echo language('document/document/document', 'tDocCancelText2') ?></strong></p>
				</div>
				<div class="modal-footer">
					<button onclick="JSvDepositCancel(true)" type="button" class="btn xCNBTNPrimery">
						<?php echo language('common/main/main', 'tModalConfirm'); ?>
					</button>
					<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
						<?php echo language('common/main/main', 'tModalCancel'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Cancel Doc -->

	<!-- Begin Add Cash Panel -->
	<div class="modal fade" id="odvDepositPopupCashAdd" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" style="width: 50%;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/deposit/deposit', 'tAddCashDeposit'); ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<!-- อ้างอิงยอดวันที่ -->
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tReferenceDate'); ?></label>
								<input type="text" class="form-control xCNDatePicker" id="oetDepositCashAddDate" name="oetDepositCashAddDate" value="<?php echo date('Y-m-d'); ?>">
							</div>
						</div>
						<!-- จำนวนเงิน -->
						<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tAmountOfMoney'); ?></label>
								<input type="number" class="form-control xCNInputWithoutSingleQuote " id="oetDepositCashAddValue" name="oetDepositCashAddValue">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button onclick="JSvDepositInsertCashToTemp()" type="button" class="btn xCNBTNPrimery">
						<?php echo language('common/main/main', 'tAdd'); ?>
					</button>
					<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
						<?php echo language('common/main/main', 'tModalCancel'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Cash Panel -->

	<!-- Begin Add Cheque Panel -->
	<div class="modal fade" id="odvDepositPopupChequeAdd" data-backdrop="static" data-keyboard="false">
		<div class="modal-dialog" style="width: 50%;">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/deposit/deposit', 'tAddCheckDeposit'); ?></h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">
					<div class="row">
						<!-- อ้างอิงเลขที่เช็ค -->
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tReferenceChequeNumber'); ?></label>
								<div class="input-group">
									<input
									name="oetDepositChequeAddRefNoName"
									id="oetDepositChequeAddRefNoName"
									class="form-control"
									value=""
									type="text"
									readonly
									placeholder="<?= language('document/deposit/deposit', 'tReferenceChequeNumber') ?>"
									data-validate-required="<?= language('document/deposit/deposit', 'tTopUpVendingMerValidate') ?>">
									<input name="oetDepositChequeAddRefNoCode" id="oetDepositChequeAddRefNoCode" value="" class="form-control xCNHide" type="text">
									<span class="input-group-btn">
										<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtDepositBrowseBookCheque" type="button">
											<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
										</button>
									</span>
								</div>
							</div>
						</div>
						<!-- ธนาคาร -->
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tBank'); ?></label>
								<input type="text" class="form-control" id="oetDepositChequeBank" name="oetDepositChequeBank" readonly>
							</div>
						</div>
						<!-- จำนวนเงิน -->
						<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/deposit/deposit', 'tAmountOfMoney'); ?></label>
								<input type="number" class="form-control xCNInputWithoutSingleQuote xCNInputNumericWithDecimal" id="oetDepositChequeAddValue" name="oetDepositChequeAddValue">
							</div>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button onclick="JSvDepositInsertChequeToTemp()" type="button" class="btn xCNBTNPrimery">
						<?php echo language('common/main/main', 'tAdd'); ?>
					</button>
					<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
						<?php echo language('common/main/main', 'tModalCancel'); ?>
					</button>
				</div>
			</div>
		</div>
	</div>
	<!-- End Add Cheque Panel -->
<?php } ?>

<?php include('script/jDepositPageadd.php') ?>
<script src="<?php echo base_url('application\modules\common\assets\src\jFormValidate.js'); ?>"></script>
