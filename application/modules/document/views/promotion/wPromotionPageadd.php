<?php
if ($aResult['rtCode'] == "1") { // Edit
	$tDocNo = $aResult['raItems']['FTPmhDocNo'];
	$tDocDate = $aResult['raItems']['FDCreateOn'];
	$tDocTime = $aResult['raItems']['FTPmhDocTime'];
	$tCreateByCode = $aResult['raItems']['FTCreateBy'];
	$tCreateByName = $aResult['raItems']['FTCreateByName'];
	// $tStaDelMQ = $aResult['raItems']['FTXthStaDelMQ'];
	$tBchCode = $aResult['raItems']['FTBchCode'];
	$tBchName = $aResult['raItems']['FTBchName'];
	$tPmhDStart = $aResult['raItems']['FDPmhDStart'];
	$tPmhDStop = $aResult['raItems']['FDPmhDStop'];
	$tPmhTStart = $aResult['raItems']['FTPmhTStartTime'];
	$tPmhTStop = $aResult['raItems']['FTPmhTStopTime'];
	$tPmhStaLimitCst = $aResult['raItems']['FTPmhStaLimitCst'];
	$tPmhStaClosed = $aResult['raItems']['FTPmhStaClosed'];
	$tStaDoc = $aResult['raItems']['FTPmhStaDoc'];
	$tStaApv = $aResult['raItems']['FTPmhStaApv'];
	$tPmhStaPrcDoc = $aResult['raItems']['FTPmhStaPrcDoc'];
	$nStaDocAct = $aResult['raItems']['FNPmhStaDocAct'];
	$tUsrCode = $aResult['raItems']['FTUsrCode']; // ผู้บันทึก
	$tUsrApvCode = $aResult['raItems']['FTPmhUsrApv']; // รหัสผู้อนุมัติ
	$tUsrApvName = $aResult['raItems']['FTUsrNameApv']; // ชื่อผู้อนุมัติ
	$tPmhStaAlwCalPntStd = $aResult['raItems']['FTPmhStaAlwCalPntStd'];
	$tPmhStaRcvFree = $aResult['raItems']['FTPmhStaRcvFree'];
	$tPmhStaLimitGet = $aResult['raItems']['FTPmhStaLimitGet'];
	$tPmhStaLimitTime = $aResult['raItems']['FTPmhStaLimitTime'];
	$tPmhStaGetPdt = $aResult['raItems']['FTPmhStaGetPdt'];
	$tPmhRefAccCode = $aResult['raItems']['FTPmhRefAccCode'];
	$tRoleCode = $aResult['raItems']['FTRolCode'];
	$tRoleName = $aResult['raItems']['FTRolName'];
	$nPmhLimitQty = $aResult['raItems']['FNPmhLimitQty'];
	$tPmhStaChkLimit = $aResult['raItems']['FTPmhStaChkLimit'];
	$tPmhStaChkCst = $aResult['raItems']['FTPmhStaChkCst'];
	$tPmhStaSpcGrpDis = $aResult['raItems']['FTPmhStaSpcGrpDis'];

	$tPmhStaGrpPriority = $aResult['raItems']['FTPmhStaGrpPriority'];
	$tPmhStaGetPri = $aResult['raItems']['FTPmhStaGetPri'];
	$tPmhStaChkQuota = $aResult['raItems']['FTPmhStaChkQuota'];
	$tPmhStaOnTopDis = $aResult['raItems']['FTPmhStaOnTopDis'];
	$tPmhStaOnTopPmt = $aResult['raItems']['FTPmhStaOnTopPmt'];

	// $nDocPrint = $aResult['raItems']['FNXthDocPrint'];
	$tRmk = $aResult['raItems']['FTPmhRmk'];
	$tPmhName = $aResult['raItems']['FTPmhName'];
	$tPmhNameSlip = $aResult['raItems']['FTPmhNameSlip'];

	$tPbyStaBuyCond = $aResult['raItems']['FTPbyStaBuyCond'];

	$tSpmStaLimitCst = @$aPdtPmtHDCstResult['raItems']['FTSpmStaLimitCst'];
	$nSpmMemAgeLT = @empty($aPdtPmtHDCstResult['raItems']['FNSpmMemAgeLT']) ? 0 : $aPdtPmtHDCstResult['raItems']['FNSpmMemAgeLT'];
	$tSpmStaChkCstDOB = @$aPdtPmtHDCstResult['raItems']['FTSpmStaChkCstDOB'];
	$nPmhCstDobPrev = @empty($aPdtPmtHDCstResult['raItems']['FNPmhCstDobPrev']) ? 0 : $aPdtPmtHDCstResult['raItems']['FNPmhCstDobPrev'];
	$nPmhCstDobNext = @empty($aPdtPmtHDCstResult['raItems']['FNPmhCstDobNext']) ? 0 : $aPdtPmtHDCstResult['raItems']['FNPmhCstDobNext'];

	$tRoute = "promotionEventEdit";

	if (isset($aAlwEvent)) {
		if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) {
			$nAutStaEdit = 1;
		} else {
			$nAutStaEdit = 0;
		}
	} else {
		$nAutStaEdit = 0;
	}

	$tRefExt = "";
} else { // New
	$tDocNo = "";
	$tDocDate = date('Y-m-d');
	$tDocTime = date('H:i');
	$tCreateByCode = $this->session->userdata('tSesUsername');
	$tCreateByName = $this->session->userdata('tSesUsrUsername');
	$tBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
	$tBchName = $this->session->userdata("tSesUsrBchNameDefault");
	$tUsrCode = $this->session->userdata('tSesUsername');
	$tPmhDStart = date('Y-m-d');
	$tPmhDStop = date('Y-m-d');
	$tPmhTStart = '00:00:00';
	$tPmhTStop = '23:59:59';
	$tPmhStaLimitCst = "1";
	$tPmhStaClosed = "";
	$tStaDoc = "";
	$tStaApv = "";
	$tPmhStaPrcDoc = "";
	$nStaDocAct = "1";
	$tUsrCode = ""; // ผู้บันทึก
	$tUsrApvCode = ""; // รหัสผู้อนุมัติ
	$tUsrApvName = ""; // ชื่อผู้อนุมัติ
	$tPmhStaAlwCalPntStd = "1";
	$tPmhStaRcvFree = "";
	$tPmhStaLimitGet = "";
	$tPmhStaLimitTime = "";
	$tPmhStaGetPdt = "1";
	$tPmhRefAccCode = "";
	$tRoleCode = "";
	$tRoleName = "";
	$nPmhLimitQty = "";
	$tPmhStaChkLimit = "";
	$tPmhStaChkCst = "";
	$tPmhStaSpcGrpDis = "1";

	$tPmhStaGrpPriority = "1";
	$tPmhStaGetPri = "1";
	$tPmhStaChkQuota = "2";
	$tPmhStaOnTopDis = "1";
	$tPmhStaOnTopPmt = "1";

	// $nDocPrint = $aResult['raItems']['FNXthDocPrint'];
	$tRmk = "";
	$tPmhName = "";
	$tPmhNameSlip = "";

	$tPbyStaBuyCond = "1";

	$tSpmStaLimitCst = "";
	$nSpmMemAgeLT = 0;
	$tSpmStaChkCstDOB = "";
	$nPmhCstDobPrev = 0;
	$nPmhCstDobNext = 0;

	$tRoute = "promotionEventAdd";
	$nAutStaEdit = 0;
	$tRefExt = "";
}

$nLangEdit = $this->session->userdata("tLangEdit");
$tUsrApv = $this->session->userdata("tSesUsername");
$tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
$bIsAddPage = empty($tDocNo) ? true : false;
$bIsApv = empty($tStaApv) ? false : true;
$bIsCancel = ($tStaDoc == "3") ? true : false;
$bIsApvOrCancel = ($bIsApv || $bIsCancel);
$bIsMultiBch = $this->session->userdata("nSesUsrBchCount") > 1;
$bIsMultiShp = $this->session->userdata("nSesUsrShpCount") > 1;
$bIsShpEnabled = FCNbGetIsShpEnabled();


$aConfigParams = [
	"tSysCode" => "bCN_AlwPmtDisAvg",
	"tSysApp" => "CN",
	"tSysKey" => "Promotion",
	"tSysSeq" => "1",
	"tGmnCode" => "MPOS"
];
$aSysConfig = FCNaGetSysConfig($aConfigParams);

$tAlwPmtDisAvgConfig = "1"; // Defualt Config


if (!empty($aSysConfig['raItems'])) {
	$tUsrConfigValue = $aSysConfig['raItems']['FTSysStaUsrValue']; // Set by User
	$tDefConfigValue = $aSysConfig['raItems']['FTSysStaDefValue']; // Set by System
	$tAlwPmtDisAvgConfig = (!empty($tUsrConfigValue) || $tUsrConfigValue == "0") ? $tUsrConfigValue : $tDefConfigValue; // Config by User or Default
}
$bIsAlwPmtDisAvg = $tAlwPmtDisAvgConfig == "1";
?>
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
		display: line-block;
		font-weight: normal;
		width: 100%;
	}

	.xCNPromotionTotalLabel {
		background-color: #f5f5f5;
		padding: 5px 10px;
		color: #232C3D !important;
		font-weight: 900;
	}

	.xCNPromotionLabel {
		padding: 5px 10px;
		color: #232C3D !important;
		font-weight: 900;
	}

	.xCNPromotionLabelFullWidth {
		width: 100%;
	}

	.xCNPromotionLabelWidth {
		width: 260px;
	}

	/* Begin Step Form */
	#odvPromotionLineCont {
		width: 100%;
		height: 20%;
		margin-top: 40px;
		margin-bottom: 20px;
	}

	#odvPromotionLine {
		height: 2px;
		width: 99%;
		background: #d6d6d6;
		border-radius: 5px;
		margin: auto;
		top: 50%;
		transform: translateY(-50%);
		position: relative;
	}

	.xCNPromotionCircle {
		width: 20px;
		height: 20px;
		background: #ffffff;
		border-radius: 15px;
		position: absolute;
		top: -9px;
		border: 2px solid #d6d6d6;
		cursor: pointer;
		background: #d6d6d6;
	}

	.xCNPromotionCircle.active {
		width: 20px;
		height: 20px;
		background: #ffffff;
		border-radius: 15px;
		position: absolute;
		top: -9px;
		border: 2px solid #1d2530;
		cursor: pointer;
	}

	.xCNPromotionCircle.pass {
		width: 20px;
		height: 20px;
		background: #ffffff;
		border-radius: 15px;
		position: absolute;
		top: -9px;
		border: 2px solid #1d2530;
		cursor: pointer;
		background: #1d2530;
	}

	.xCNPromotionCircle .xCNPromotionPopupSpan {
		width: auto;
		height: auto;
		padding: 10px;
		white-space: nowrap;
		color: #1d2530;
		position: absolute;
		top: -36px;
		left: -10px;
		transition: all 0.1s ease-out;
	}

	.xCNPromotionCircle.active .xCNPromotionPopupSpan {
		font-weight: 900;
	}

	/* End Step Form */

	#odvPromotionContentPage .tab-pane {
		padding: 25px 0px !important;
	}
</style>

<script>
	var nLangEdit = '<?php echo $nLangEdit; ?>';
	var tUsrApv = '<?php echo $tUsrApv; ?>';
	var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
	var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
	var bIsApv = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
	var bIsCancel = <?php echo ($bIsCancel) ? 'true' : 'false'; ?>;
	var bIsApvOrCancel = <?php echo ($bIsApvOrCancel) ? 'true' : 'false'; ?>;
	var bIsMultiBch = <?php echo ($bIsMultiBch) ? 'true' : 'false'; ?>;
	var bIsMultiShp = <?php echo ($bIsMultiShp) ? 'true' : 'false'; ?>;
	var bIsShpEnabled = <?php echo ($bIsShpEnabled) ? 'true' : 'false'; ?>;
	var bIsAlwPmtDisAvg = <?php echo ($bIsAlwPmtDisAvg) ? 'true' : 'false'; ?>;
</script>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmPromotionForm">
	<input type="hidden" id="ohdPromotionStaApv" name="ohdPromotionStaApv" value="<?php echo $tStaApv; ?>">
	<input type="hidden" id="ohdPmhStaLimitCst" name="ohdPmhStaLimitCst" value="<?php echo $tPmhStaLimitCst; ?>">
	<input type="hidden" id="ohdPromotionStaDelMQ" name="ohdPromotionStaDelMQ" value="<?php // echo $tStaDelMQ; 
																						?>">
	<input type="text" class="xCNHide" id="oetPromotionApvCodeUsrLogin" name="oetPromotionApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<input type="text" class="xCNHide" id="oetPromotionchCodeMulti" name="oetPromotionchCodeMulti" value="<?php if ($this->session->userdata('tSesUsrLevel') != 'HQ') {
																												echo str_replace("'", "", $this->session->userdata('tSesUsrBchCodeMulti'));
																											} ?>">
	<button style="display:none" type="submit" id="obtPromotionSubmit" onclick="JSxPromotionValidateForm();"></button>

	<div class="row">
		<div class="col-md-3">
			<!--Section : รายละเอียดเอกสาร-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?= language('document/promotion/promotion', 'tStatus'); ?></label>
					<a class="xCNMenuplus <?php echo ($bIsAddPage) ? 'collapsed' : ''; ?>" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse <?php echo ($bIsAddPage) ? '' : 'in'; ?>" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?= language('document/promotion/promotion', 'tApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton">
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/promotion/promotion', 'tDocNo'); ?></label>
						<?php if ($bIsAddPage) { ?>
							<div class="form-group" id="odvPromotionAutoGenCode">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbPromotionAutoGenCode" name="ocbPromotionAutoGenCode" checked="true" value="1">
										<span><?= language('document/promotion/promotion', 'tAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="odvPromotionCodeForm">
								<input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="20" id="oetPromotionDocNo" name="oetPromotionDocNo" data-is-created="<?php  ?>" placeholder="<?php echo language('document/promotion/promotion', 'tDocNo') ?>" value="<?php  ?>" data-validate-required="<?php echo language('document/promotion/promotion', 'tDocNoRequired') ?>" data-validate-duplicate="<?php echo language('document/promotion/promotion', 'tDocNoDuplicate') ?>" disabled readonly>
								<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW">
							</div>
						<?php } else { ?>
							<div class="form-group" id="odvPromotionCodeForm">
								<div class="validate-input">
									<input type="text" class="form-control xCNInputWithoutSpcNotThai xCNCanCelDisabled" maxlength="20" id="oetPromotionDocNo" name="oetPromotionDocNo" data-is-created="<?php  ?>" placeholder="<?= language('document/promotion/promotion', 'tTFWDocNo') ?>" value="<?php echo $tDocNo; ?>" readonly onfocus="this.blur()">
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/promotion/promotion', 'tDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetPromotionDocDate" name="oetPromotionDocDate" value="<?= $tDocDate; ?>" data-validate-required="<?= language('document/promotion/promotion', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtPmtDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/promotion/promotion', 'tDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetPromotionDocTime" name="oetPromotionDocTime" value="<?= $tDocTime; ?>" data-validate-required="<?= language('document/promotion/promotion', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtPmtDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateByCode ?>">
								<label><?= $tCreateByName ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/promotion/promotion', 'tStaDoc' . $tStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/promotion/promotion', 'tStaApv' . $tStaApv); ?></label>
							</div>
						</div>
						<?php if ($tDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?= $tUsrApvCode ?>">
									<label><?= $tUsrApvName != '' ? $tUsrApvName : language('document/promotion/promotion', 'tStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>

			<!-- Section : เงื่อนไข-โปรโมชัน -->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tConditionsPromotion'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvConditionTime" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>

				<div id="odvConditionTime" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="row">
							<div class="col-md-12">
								<!-- สาขาที่สร้าง -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tTBBchCreate'); ?></label>
									<div class="input-group">
										<input type="text" class="input100 xCNHide" id="oetPromotionBchCode" name="oetPromotionBchCode" maxlength="5" value="<?php echo $tBchCode; ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetPromotionBchName" name="oetPromotionBchName" value="<?php echo $tBchName; ?>" readonly>
										<span class="input-group-btn xWConditionSearchPdt">
											<button id="obtPromotionBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- สาขาที่สร้าง -->
							</div>
						</div>

						<!-- ชื่อโปรโมชั่น -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPromotionName'); ?></label>
									<input type="text" class="form-control xCNApvOrCanCelDisabled" id="oetPromotionPmhName" name="oetPromotionPmhName" maxlength="200" value="<?php echo $tPmhName; ?>">
								</div>
							</div>
						</div>

						<!-- ชื่ออื่น -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tOtherName'); ?></label>
									<input type="text" class="form-control xCNApvOrCanCelDisabled" id="oetPromotionPmhNameSlip" name="oetPromotionPmhNameSlip" maxlength="25" value="<?php echo $tPmhNameSlip; ?>">
								</div>
							</div>
						</div>

						<!-- เงื่อนไขการซื้อ -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPurchaseConditions'); ?></label>
									<select class="selectpicker form-control" id="ocmPromotionPbyStaBuyCond" name="ocmPromotionPbyStaBuyCond" <?php echo ($bIsApvOrCancel) ? 'disabled' : ''; ?>>
										<option value='1' <?php echo ($tPbyStaBuyCond == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tFullyPurchased'); ?></option>
										<option value='2' <?php echo ($tPbyStaBuyCond == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tFullyWorth'); ?></option>
										<option value='3' <?php echo ($tPbyStaBuyCond == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByNumberRange'); ?></option>
										<option value='4' <?php echo ($tPbyStaBuyCond == "4") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByValueRange'); ?></option>
										<!-- <option value='5' <?php echo ($tPbyStaBuyCond == "5") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByTimeRange'); ?></option> -->
										<option value='5' <?php echo ($tPbyStaBuyCond == "5") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByTimeRange_FullyPurchased'); ?></option>
										<option value='6' <?php echo ($tPbyStaBuyCond == "6") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tByTimeRange_FullyWorth'); ?></option>
									</select>
								</div>
							</div>
						</div>

						<!-- กลุ่มคำนวนโปรโมชั่น -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel5'); ?></label>
									<?php
										$aIsAlwFuncInRoleParams = [
											"tUfrGrpRef" 	=> "050",
											"tUfrRef" 		=> "KB106",
											"tGhdApp" 		=> "SB"
										];
										$bIsAlwFuncInRoleBruteForced = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);

										$aIsAlwFuncInRoleParams = [
											"tUfrGrpRef" 	=> "050",
											"tUfrRef" 		=> "KB107",
											"tGhdApp" 		=> "SB"
										];
										$bIsAlwFuncInRoleMemberPrice = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
									?>
									<select class="selectpicker form-control" id="ocmPromotionPmhStaGrpPriority" name="ocmPromotionPmhStaGrpPriority" <?php echo ($bIsApvOrCancel) ? 'disabled' : ''; ?>>
										<option value='0' <?php echo ($tPmhStaGrpPriority == "0") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'Price Group'); ?></option>
										<option value='1' <?php echo ($tPmhStaGrpPriority == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'The Best'); ?></option>
										<?php if ($bIsAlwFuncInRoleBruteForced) { ?>
											<option value='2' <?php echo ($tPmhStaGrpPriority == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'Brute Forced'); ?></option>
										<?php } ?>
										<?php if ($bIsAlwFuncInRoleMemberPrice) { ?>
											<option value='3' <?php echo ($tPmhStaGrpPriority == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'Member Price'); ?></option>
										<?php } ?>
									</select>
								</div>
							</div>

							<!-- เลือกรับโปรโมชั่น โดยผู้ใช้ / ลูกค้า -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tProductSelectionConditions'); ?></label>
									<select class="selectpicker form-control" id="ocmPromotionPmhStaGetPdt" name="ocmPromotionPmhStaGetPdt" <?php echo ($bIsApvOrCancel) ? 'disabled' : ''; ?>>
										<option value='1' <?php echo ($tPmhStaGetPdt == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tMorePrice'); ?></option>
										<option value='2' <?php echo ($tPmhStaGetPdt == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tLessPrice'); ?></option>
										<option value='3' <?php echo ($tPmhStaGetPdt == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tCustom'); ?></option>
									</select>
								</div>
							</div>
						</div>

						<!-- คิดทั้งหมด / คิดต่อสมาชิก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tAllThought_PerMember'); ?></label>
									<select class="selectpicker form-control xPromotionPmhStaLimitCst" id="ocmPromotionPmhStaLimitCst" name="ocmPromotionPmhStaLimitCst" <?php echo ($bIsApvOrCancel) ? 'disabled' : ''; ?>>
										<option value='1'><?php echo language('document/promotion/promotion', 'tLabel6'); ?></option>
										<option value='2' selected><?php echo language('document/promotion/promotion', 'tLabel7'); ?></option>
									</select>
								</div>
							</div>
						</div>

						<!-- การใช้งานยอดเพื่อคำนวน -->
						<!-- 052	KB108	1	การใช้งานยอดเพื่อคำนวน  (Saleprice/Netprice) -->
						<?php
						$aIsAlwFuncInRoleParams = [
							"tUfrGrpRef" => "052",
							"tUfrRef" => "KB108",
							"tGhdApp" => "SB"
						];
						$bIsAlwFuncInRolePmhStaGetPri = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
						?>
						<div class="row <?php echo ($bIsAlwFuncInRolePmhStaGetPri) ? '' : 'hidden'; ?>">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel8'); ?></label>
									<select class="selectpicker form-control" id="ocmPromotionPmhStaGetPri" name="ocmPromotionPmhStaGetPri" <?php echo ($bIsApvOrCancel) ? 'disabled' : ''; ?>>
										<option value='1' <?php echo ($tPmhStaGetPri == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tLabel9'); ?></option>
										<option value='2' <?php echo ($tPmhStaGetPri == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tLabel10'); ?></option>
									</select>
								</div>
							</div>
						</div>

						<!-- เช็คเงื่อนไขโควต้าจากระบบอื่น -->
						<!-- 051	KB107	1	เช็คเงื่อนไขจำกัดโควต้าจากระบบอื่น -->
						<?php
						$aIsAlwFuncInRoleParams = [
							"tUfrGrpRef" => "051",
							"tUfrRef" => "KB107",
							"tGhdApp" => "SB"
						];
						$bIsAlwFuncInRolePmhStaChkQuota = FCNbIsAlwFuncInRole($aIsAlwFuncInRoleParams);
						?>
						<div class="row <?php echo ($bIsAlwFuncInRolePmhStaChkQuota) ? '' : 'hidden'; ?>">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNApvOrCanCelDisabled" value="1" id="ocbPromotionPmhStaChkQuota" name="ocbPromotionPmhStaChkQuota" maxlength="1" <?php echo $tPmhStaChkQuota == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel3'); ?></span>
									</label>
								</div>
							</div>
						</div>

						<!-- มีส่วนลดแล้วสามารถคำนวนโปรโมชั่นนี้ได้ -->
						<div class="row hidden">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNCanCelDisabled" value="1" id="ocbPromotionPmhStaOnTopDis" name="ocbPromotionPmhStaOnTopDis" maxlength="1" <?php echo $tPmhStaOnTopDis == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLabel4'); ?></span>
									</label>
								</div>
							</div>
						</div>

						<!-- อนุญาต คำนวนรายการที่ได้รับโปรโมชั่นแล้ว -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNApvOrCanCelDisabled" value="1" id="ocbPromotionPmhStaOnTopPmt" name="ocbPromotionPmhStaOnTopPmt" maxlength="1" <?php echo $tPmhStaOnTopPmt == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tAllowedToCalculatePromotionsThatHaveAlreadyBeenReceived'); ?></span>
									</label>
								</div>
							</div>
						</div>

						<!-- ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ -->
						<!-- <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input
										type="checkbox"
										class="xCNCanCelDisabled"
										value="1"
										id="ocbPromotionPmhStaSpcGrpDis"
										name="ocbPromotionPmhStaSpcGrpDis"
										maxlength="1" <?php echo $tPmhStaSpcGrpDis == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'ใช้เฉลี่ยส่วนลดกลุ่มรับอัตโนมัติ'); ?></span>
									</label>
								</div>
							</div>
						</div> -->

						<hr>

						<div class="row">
							<!-- จากวันที่ -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tFromDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetPromotionPmhDStart" name="oetPromotionPmhDStart" value="<?= $tPmhDStart; ?>">
										<span class="input-group-btn">
											<button id="obtPmtDocDateFrom" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<!-- ถึงวันที่ -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tToDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetPromotionPmhDStop" name="oetPromotionPmhDStop" value="<?= $tPmhDStop; ?>">
										<span class="input-group-btn">
											<button id="obtPmtDocDateTo" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<!-- จากเวลา -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tFromTime'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetPromotionPmhTStart" name="oetPromotionPmhTStart" value="<?= $tPmhTStart; ?>">
										<span class="input-group-btn">
											<button id="obtPmtDocTimeFrom" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<!-- ถึงเวลา -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tToTime'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetPromotionPmhTStop" name="oetPromotionPmhTStop" value="<?= $tPmhTStop; ?>">
										<span class="input-group-btn">
											<button id="obtPmtDocTimeTo" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

						<!-- หยุดรายการชัวคราว -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNCanCelDisabled" value="1" id="ocbPromotionPmhStaClosed" name="ocbPromotionPmhStaClosed" maxlength="1" <?php echo $tPmhStaClosed == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPausedTemporarily'); ?></span>
									</label>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!--Section : เงื่อนไข-ลูกค้า-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tConditionsCustomers'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDataGeneralInfo" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataGeneralInfo" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="row hidden">
							<!-- อนุญาต เอายอดไปคำนวนแต้ม -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNApvOrCanCelDisabled" value="1" id="ocbPromotionPmhStaAlwCalPntStd" name="ocbPromotionPmhStaAlwCalPntStd" maxlength="1" <?php echo $tPmhStaAlwCalPntStd == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tAllowToCalculateTheAmount'); ?></span>
									</label>
								</div>
							</div>
						</div><!-- row -->

						<!-- <hr> -->

						<div class="row">
							<!-- Begin Group -->
							<!-- เงื่อนไข การรับโปรโมชั่น -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tConditionsForReceivingPromotions'); ?></label>
									<select class="selectpicker form-control" id="ocmPromotionPmhStaRcvFree" name="ocmPromotionPmhStaRcvFree" <?php echo ($bIsApvOrCancel) ? 'disabled' : ''; ?>>
										<option value='1' <?php echo ($tPmhStaRcvFree == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPointOfSaleAutomaticCalculation'); ?></option>
										<option value='2' <?php echo ($tPmhStaRcvFree == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tOptionalSellingPoint'); ?></option>
										<option value='3' <?php echo ($tPmhStaRcvFree == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tServicePoint'); ?></option>
									</select>
								</div>
							</div>
							<!-- End Group -->
						</div><!-- row -->

						<hr>

						<div class="row">
							<!-- Begin Group -->
							<!-- สิทธิ์อนุญาต -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('document/promotion/promotion', 'tPermission'); ?></label>
									<div class="input-group">
										<?php $bIsPmhStaGetPdtType3 = ($tPmhStaGetPdt == "3"); ?>
										<input <?php echo ($bIsPmhStaGetPdtType3) ? '' : 'disabled'; ?> name="oetPromotionRoleName" id="oetPromotionRoleName" class="form-control" value="<?php echo $tRoleName; ?>" type="text" readonly placeholder="<?= language('document/promotion/promotion', 'tPermission') ?>">
										<input <?php echo ($bIsPmhStaGetPdtType3) ? '' : 'disabled'; ?> name="oetPromotionRoleCode" id="oetPromotionRoleCode" value="<?php echo $tRoleCode; ?>" class="form-control xCNHide" type="text">
										<span class="input-group-btn">
											<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtPromotionBrowseRole" type="button" <?php echo ($bIsPmhStaGetPdtType3) ? '' : 'disabled'; ?>>
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<!-- End Group -->
						</div><!-- row -->

						<hr>

						<div class="row">
							<!-- Begin Group -->
							<!-- จำกัดจำนวนครั้ง -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNApvOrCanCelDisabled" value="1" id="ocbPromotionPmhStaLimitGet" name="ocbPromotionPmhStaLimitGet" maxlength="1" <?php echo $tPmhStaLimitGet == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tLimitedNumberOfTimes'); ?></span>
									</label>
								</div>
							</div>
							<?php $bIsPmtStaLimitGetActive = $tPmhStaLimitGet == "1"; ?>
							<!-- จำนวนครั้ง(จำกัดจำนวนครั้งที่จะได้รับ โปรโมชั่น) -->
							<div class="col-md-12">
								<div class="form-group">
									<input <?php echo ($bIsPmtStaLimitGetActive) ? '' : 'disabled'; ?> type="text" class="form-control text-right xCNInputLength xCNApvOrCanCelDisabled" id="oetPromotionPmhLimitQty" name="oetPromotionPmhLimitQty" maxlength="15" data-length="15" value="<?php echo $nPmhLimitQty; ?>">
								</div>
							</div>
							<!-- FTPmhStaLimitTime -->
							<div class="col-md-12">
								<div class="form-group">
									<select class="selectpicker form-control" id="ocmPromotionPmhStaLimitTime" name="ocmPromotionPmhStaLimitTime" <?php echo ($bIsPmtStaLimitGetActive) ? '' : 'disabled'; ?>>
										<option value='1' <?php echo ($tPmhStaLimitTime == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerDay'); ?></option>
										<option value='2' <?php echo ($tPmhStaLimitTime == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerMonth'); ?></option>
										<option value='3' <?php echo ($tPmhStaLimitTime == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerYear'); ?></option>
									</select>
								</div>
							</div>
							<!-- FTPmhStaChkLimit -->
							<div class="col-md-12">
								<div class="form-group">
									<select class="selectpicker form-control" id="ocmPromotionPmhStaChkLimit" name="ocmPromotionPmhStaChkLimit" <?php echo ($bIsPmtStaLimitGetActive) ? '' : 'disabled'; ?>>
										<option value='1' <?php echo ($tPmhStaChkLimit == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerBranch'); ?></option>
										<option value='2' <?php echo ($tPmhStaChkLimit == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerCompany'); ?></option>
										<option value='3' <?php echo ($tPmhStaChkLimit == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerCustomer'); ?></option>
										<option value='4' <?php echo ($tPmhStaChkLimit == "4") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tPerBill'); ?></option>
									</select>
								</div>
							</div>
							<!-- End Group -->
						</div><!-- row -->

						<hr>

						<!-- Begin Group -->
						<!-- ตรวจสอบเงื่อนไขลูกค้า -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="xCNApvOrCanCelDisabled" value="1" id="ocbPromotionPmhStaChkCst" name="ocbPromotionPmhStaChkCst" maxlength="1" <?php echo $tPmhStaChkCst == '1' ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tCheckCustomerConditions'); ?></span>
									</label>
								</div>
							</div>
						</div><!-- row -->

						<div class="row">
							<?php $bIsPmhStaChkCstActive = $tPmhStaChkCst == "1"; ?>
							<!-- FTSpmStaLimitCst -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tMembershipDuration'); ?></label>
									<select class="selectpicker form-control" id="ocmPromotionSpmStaLimitCst" name="ocmPromotionSpmStaLimitCst" <?php echo ($bIsPmhStaChkCstActive) ? '' : 'disabled'; ?>>
										<option value='1' <?php echo ($tSpmStaLimitCst == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tLessThan'); ?></option>
										<option value='2' <?php echo ($tSpmStaLimitCst == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tLessThanOrEqualTo'); ?></option>
										<option value='3' <?php echo ($tSpmStaLimitCst == "3") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tEqualTo'); ?></option>
										<option value='4' <?php echo ($tSpmStaLimitCst == "4") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tMoreThanOrEqualTo'); ?></option>
										<option value='5' <?php echo ($tSpmStaLimitCst == "5") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tMoreThan'); ?></option>
									</select>
								</div>
							</div>
							<!-- FNSpmMemAgeLT -->
							<div class="col-md-6">
								<div class="form-group text-right">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tNumberOfDays'); ?></label>
									<input <?php echo ($bIsPmhStaChkCstActive) ? '' : 'disabled'; ?> type="text" class="form-control text-right xCNApvOrCanCelDisabled xCNInputNumericWithoutDecimal" id="oetPromotionSpmMemAgeLT" name="oetPromotionSpmMemAgeLT" data-length="15" maxlength="15" value="<?php echo $nSpmMemAgeLT; ?>">
								</div>
							</div>
						</div><!-- row -->

						<div class="row">
							<!-- FTSpmStaChkCstDOB -->
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tMemberMonthBirth'); ?></label>
									<select class="selectpicker form-control" id="ocmPromotionSpmStaChkCstDOB" name="ocmPromotionSpmStaChkCstDOB" <?php echo ($bIsPmhStaChkCstActive) ? '' : 'disabled'; ?>>
										<option value='1' <?php echo ($tSpmStaChkCstDOB == "1") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tActive'); ?></option>
										<option value='2' <?php echo ($tSpmStaChkCstDOB == "2") ? 'selected' : ''; ?>><?php echo language('document/promotion/promotion', 'tNotActive'); ?></option>
									</select>
								</div>
							</div>
							<!-- ก่อนหน้า FNPmhCstDobPrev -->
							<div class="col-md-3">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPrevious'); ?></label>
									<input <?php echo ($bIsPmhStaChkCstActive) ? '' : 'disabled'; ?> type="text" class="form-control text-right xCNInputLength xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabled" id="oetPromotionPmhCstDobPrev" name="oetPromotionPmhCstDobPrev" maxlength="15" data-length="15" value="<?php echo $nPmhCstDobPrev; ?>">
								</div>
							</div>
							<!-- ย้อนหลัง FNPmhCstDobNext -->
							<div class="col-md-3">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPreviousPast'); ?></label>
									<input <?php echo ($bIsPmhStaChkCstActive) ? '' : 'disabled'; ?> type="text" class="form-control text-right xCNInputLength xCNInputNumericWithoutDecimal xCNApvOrCanCelDisabled" id="oetPromotionPmhCstDobNext" name="oetPromotionPmhCstDobNext" maxlength="15" data-length="15" value="<?php echo $nPmhCstDobNext; ?>">
								</div>
							</div>
						</div><!-- row -->
						<!-- End Group -->

					</div>
				</div>
			</div>

			<!--Section : อื่นๆ-->
			<div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/promotion/promotion', 'tOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>

				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- รหัสอ้างอิงบัญชีของโปรโมชั่น -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPromotionAccountReferenceCode'); ?></label>
									<input type="text" class="form-control xCNApvOrCanCelDisabled" id="oetPromotionPmhRefAccCode" name="oetPromotionPmhRefAccCode" maxlength="20" value="<?php echo $tPmhRefAccCode; ?>">
								</div>
							</div>
						</div>

						<!-- หมายเหตุ -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tNote'); ?></label>
							<textarea class="form-control xCNApvOrCanCelDisabled" id="otaPromotionPmhRmk" name="otaPromotionPmhRmk"><?php echo $tRmk; ?></textarea>
						</div>

						<!-- เคลื่อนไหว -->
						<div class="form-group">
							<label class="fancy-checkbox">
								<input type="checkbox" class="xCNApvOrCanCelDisabled" value="1" id="ocbPromotionPmhStaDocAct" name="ocbPromotionPmhStaDocAct" maxlength="1" <?php echo $nStaDocAct == '1' ? 'checked' : ''; ?>>
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tStaDocAct'); ?></span>
							</label>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!--Panel ตารางฝั่งขวา-->
		<div class="col-md-9" id="odvRightPanal">

			<div class="panel panel-default xCNPromotionFootTotalContainer" style="margin-bottom: 25px;">
				<!-- รวม Cash-Cheque -->
				<div class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="row">
							<div class="col-md-12">

								<div id="odvPromotionLineCont">
									<div id="odvPromotionLine">
										<div class="xCNPromotionCircle active xCNPromotionStep1" data-tab="odvPromotionStep1" data-step="1" style="left: -7px;">
											<div class="xCNPromotionPopupSpan"><?php echo language('document/promotion/promotion', 'tCreateGroup_Product'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep2" data-tab="odvPromotionStep2" data-step="2" style="left: 25%;">
											<div class="xCNPromotionPopupSpan"><?php echo language('document/promotion/promotion', 'tDefineBuying_ReceivingGroups'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep3" data-tab="odvPromotionStep3" data-step="3" style="left: 50%;">
											<div class="xCNPromotionPopupSpan"><?php echo language('document/promotion/promotion', 'tDefineGroupConditions'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep4" data-tab="odvPromotionStep4" data-step="4" style="left: 75%;">
											<div class="xCNPromotionPopupSpan"><?php echo language('document/promotion/promotion', 'tDefineSpecificConditions'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep5" data-tab="odvPromotionStep5" data-step="5" style="left: 99%;">
											<div class="xCNPromotionPopupSpan" style="left:-100px;"><?php echo language('document/promotion/promotion', 'tCheckAndConfirm'); ?></div>
										</div>
									</div>
								</div>

								<ul class="nav nav-tabs hidden">
									<li class="active"><a data-toggle="tab" href="#odvPromotionStep1"></a></li>
									<li><a data-toggle="tab" href="#odvPromotionStep2"></a></li>
									<li><a data-toggle="tab" href="#odvPromotionStep3"></a></li>
									<li><a data-toggle="tab" href="#odvPromotionStep4"></a></li>
									<li><a data-toggle="tab" href="#odvPromotionStep5"></a></li>
								</ul>
								<!-- Step Control -->
								<div class="row">
									<div class="col-md-12">
										<button disabled class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPromotionBackStep" type="button" style="display: inline-block; width:150px;"> <?php echo language('document/promotion/promotion', 'tBack'); ?></button>
										<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPromotionNextStep" type="button" style="display: inline-block; width:150px;"> <?php echo language('document/promotion/promotion', 'tNext'); ?></button>
									</div>
								</div>

								<div class="tab-content xCNPromotionTabContent">
									<div id="odvPromotionStep1" class="tab-pane fade in active">
										<?php include('step_form/wStep1.php'); ?>
									</div>
									<div id="odvPromotionStep2" class="tab-pane fade">
										<?php include('step_form/wStep2.php'); ?>
									</div>
									<div id="odvPromotionStep3" class="tab-pane fade">
										<?php include('step_form/wStep3.php'); ?>
									</div>
									<div id="odvPromotionStep4" class="tab-pane fade">
										<?php include('step_form/wStep4.php'); ?>
									</div>
									<div id="odvPromotionStep5" class="tab-pane fade">
										<?php include('step_form/wStep5.php'); ?>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>
</form>

<?php if (!$bIsApvOrCancel) { ?>
	<!-- Begin Approve Doc -->
	<div class="modal fade xCNModalApprove" id="odvPromotionPopupApv">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="xCNHeardModal modal-title" style="display:inodvPromotionLine-block"><?php echo language('common/main/main', 'tApproveTheDocument'); ?></h5>
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
					<button onclick="JSvPromotionApprove(true)" type="button" class="btn xCNBTNPrimery">
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
	<div class="modal fade" id="odvPromotionPopupCancel">
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
					<button onclick="JSvPromotionCancel(true)" type="button" class="btn xCNBTNPrimery">
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
<?php } ?>


<!-- ================================================== Modal Copy Document Appove ================================================== -->
<div id="odvPromotionModalCopyDoc" class="modal fade xCNModalApprove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/promotion/promotion', 'tPmtHDCopy'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><strong><?php echo language('document/promotion/promotion', 'tPmtMsgConfirmCopyDoc'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxPromotionCopyDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<?php include('script/jPromotionPageadd.php') ?>
<script src="<?php echo base_url('application\modules\common\assets\src\jFormValidate.js'); ?>"></script>