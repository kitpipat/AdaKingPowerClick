<?php
// echo "<pre>";
// print_r($aResult);
// echo "</pre>";
if ($aResult['tCode'] == "1") { // Edit
	$tDocNo = $aResult['aItems']['FTPmhDocNo'];
	$tDocDate = $aResult['aItems']['FDPmhDocDate'];
	$tDocTime = $aResult['aItems']['FTPmhDocTime'];
	$tCreateByCode = $aResult['aItems']['FTCreateBy'];
	$tCreateByName = $aResult['aItems']['FTCreateByName'];
	// $tStaDelMQ = $aResult['aItems']['FTXthStaDelMQ'];
	$tBchCode = $aResult['aItems']['FTBchCode'];
	$tBchName = $aResult['aItems']['FTBchName'];
	$tPmhDStart = $aResult['aItems']['FDPmhDStart'];
	$tPmhDStop = $aResult['aItems']['FDPmhDStop'];
	$tPmhTStart = date('H:i:s',strtotime($aResult['aItems']['FTPmhTStart']));
	$tPmhTStop = date('H:i:s',strtotime($aResult['aItems']['FTPmhTStop']));
	// $tPmhStaLimitCst = $aResult['aItems']['FTPmhStaLimitCst'];
	$tPmhStaClosed = $aResult['aItems']['FTPmhStaClosed'];
	$tStaDoc = $aResult['aItems']['FTPmhStaDoc'];
	$tStaApv = $aResult['aItems']['FTPmhStaApv'];
	$tPmhStaPrcDoc = $aResult['aItems']['FTPmhStaPrcDoc'];
	$nStaDocAct = $aResult['aItems']['FNPmhStaDocAct'];
	$tUsrCode = $aResult['aItems']['FTUsrCode']; // ผู้บันทึก
	$tUsrApvCode = $aResult['aItems']['FTPmhUsrApv']; // รหัสผู้อนุมัติ
	$tUsrApvName = $aResult['aItems']['FTUsrNameApv']; // ชื่อผู้อนุมัติ

	$tRmk 			= ''/*$aResult['aItems']['FTPmhRmk']*/;
	$tPmhName 		= $aResult['aItems']['FTPmhName'];
	$tPmhNameSlip 	= $aResult['aItems']['FTPmhNameSlip'];

	$tPmhStaAlwRetMnyGet 	= $aResult['aItems']['FTPmhStaAlwRetMnyGet'];
    $tPmhStaAlwRetMnyPay 	= $aResult['aItems']['FTPmhStaAlwRetMnyPay'];
	$tPmhCalType 			= $aResult['aItems']['FTPmhCalType'];
	$tPTUPmhRefAccCode		= $aResult['aItems']['FTPmhRefAccCode'];

	$tRoute = "docPTUEventEdit";

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
	$tPmhDStop = date('Y-m-d', strtotime('+1 year'));
	$tPmhTStart = '00:00:00';
	$tPmhTStop = '23:59:59';
	$tPmhStaClosed = "";
	$tStaDoc = "";
	$tStaApv = "";
	$tPmhStaPrcDoc = "";
	$nStaDocAct = "1";
	$tUsrCode = ""; // ผู้บันทึก
	$tUsrApvCode = ""; // รหัสผู้อนุมัติ
	$tUsrApvName = ""; // ชื่อผู้อนุมัติ

	$tRmk = "";
	$tPmhName = "";
	$tPmhNameSlip = "";

	$tRoute = "docPTUEventAdd";
	$nAutStaEdit = 0;
    $tRefExt = "";
    $tPmhStaAlwRetMnyGet = "";
    $tPmhStaAlwRetMnyPay = "";
	$tPmhCalType = "1";
	$tPTUPmhRefAccCode = "";
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
	.xCNPromotionLabelFullWidth{
		width: 100%;
	}
	.xCNPromotionLabelWidth{
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
		background: #1d2530;
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
		border: 2px solid #1d2530;
		cursor: pointer;
	}
	.xCNPromotionCircle.active{
		background: #1d2530;
	}
	.xCNPromotionCircle.before{
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
</script>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmPTUForm">
	<input type="hidden" id="ohdPTUStaApv" name="ohdPTUStaApv" value="<?php echo $tStaApv; ?>">
	<input type="hidden" id="ohdPTUStaDelMQ" name="ohdPTUStaDelMQ" value="<?php // echo $tStaDelMQ; ?>">
	<input type="text" class="xCNHide" id="oetPTUApvCodeUsrLogin" name="oetPTUApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<button style="display:none" type="submit" id="obtPTUSubmit" onclick="JSxPTUValidateForm();"></button>

	<div class="row">
		<div class="col-md-3">
			<!--Section : รายละเอียดเอกสาร-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?= language('sale/promotiontopup/promotiontopup', 'tStatus'); ?></label>
					<a class="xCNMenuplus <?php echo ($bIsAddPage)?'collapsed':''; ?>" role="button" data-toggle="collapse" href="#odvDataPTU" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPTU" class="panel-collapse collapse <?php echo ($bIsAddPage)?'':'in'; ?>" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?= language('sale/promotiontopup/promotiontopup', 'tApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton">
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('sale/promotiontopup/promotiontopup', 'tDocNo'); ?></label>
						<?php if ($bIsAddPage) { ?>
							<div class="form-group" id="odvPTUAutoGenCode">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbPTUAutoGenCode" name="ocbPTUAutoGenCode" checked="true" value="1">
										<span><?= language('sale/promotiontopup/promotiontopup', 'tAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="odvPTUCodeForm">
								<input
								type="text"
								class="form-control xCNInputWithoutSpcNotThai"
								maxlength="20"
								id="oetPTUDocNo"
								name="oetPTUDocNo"
								data-is-created="<?php  ?>"
								placeholder="<?= language('sale/promotiontopup/promotiontopup', 'tDocNo') ?>"
								value="<?php  ?>" data-validate-required="<?= language('sale/promotiontopup/promotiontopup', 'tDocNoRequired') ?>"
								data-validate-dublicateCode="<?= language('sale/promotiontopup/promotiontopup', 'tDocNoDuplicate') ?>"
								disabled readonly>
								<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW">
							</div>
						<?php } else { ?>
							<div class="form-group" id="odvPTUCodeForm">
								<div class="validate-input">
									<input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="20" id="oetPTUDocNo" name="oetPTUDocNo" data-is-created="<?php  ?>" placeholder="<?= language('sale/promotiontopup/promotiontopup', 'tTFWDocNo') ?>" value="<?php echo $tDocNo; ?>" readonly onfocus="this.blur()">
								</div>
							</div>
						<?php } ?>


						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('sale/promotiontopup/promotiontopup', 'tDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetPTUDocDate" name="oetPTUDocDate" value="<?= $tDocDate; ?>" data-validate-required="<?= language('sale/promotiontopup/promotiontopup', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtPmtDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('sale/promotiontopup/promotiontopup', 'tDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetPTUDocTime" name="oetPTUDocTime" value="<?= $tDocTime; ?>" data-validate-required="<?= language('sale/promotiontopup/promotiontopup', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtPmtDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateByCode ?>">
								<label><?= $tCreateByName ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('sale/promotiontopup/promotiontopup', 'tStaDoc' . $tStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('sale/promotiontopup/promotiontopup', 'tStaApv' . $tStaApv); ?></label>
							</div>
						</div>
						<?php if ($tDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?= $tUsrApvCode ?>">
									<label><?= $tUsrApvName != '' ? $tUsrApvName : language('sale/promotiontopup/promotiontopup', 'tStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>

					</div>
				</div>
			</div>

			<!-- Section : เงื่อนไข-โปรโมชัน -->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('sale/promotiontopup/promotiontopup', 'tConditionsPromotion'); ?></label>
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
									<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'สาขาที่สร้าง'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="input100 xCNHide"
										id="oetPTUBchCode"
										name="oetPTUBchCode"
										maxlength="5"
										value="<?php echo $tBchCode; ?>">
										<input
										class="form-control xWPointerEventNone"
										type="text" id="oetPTUBchName"
										name="oetPTUBchName"
										value="<?php echo $tBchName; ?>"
										readonly>
										<span class="input-group-btn xWConditionSearchPdt">
											<button id="obtPTUBrowseBch" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
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
									<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tPromotionName'); ?></label>
									<input
									type="text"
									class="form-control xCNApvOrCanCelDisabled"
									id="oetPTUPmhName"
									name="oetPTUPmhName"
									maxlength="200"
									value="<?php echo $tPmhName; ?>">
								</div>
							</div>
						</div>
						<!-- เก็บชื่อ ที่ hendin ไป update หลัง approve -->
						<input type="hidden" id="ohdPTUPmhName" name="ohdPTUPmhName" value="<?php echo $tPmhName; ?>">

						<!-- ชื่อโปรโมชั่นแบบย่อ -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tOtherName'); ?></label>
									<input
									type="text"
									class="form-control xCNApvOrCanCelDisabled"
									id="oetPTUPmhNameSlip"
									name="oetPTUPmhNameSlip"
									maxlength="25"
									value="<?php echo $tPmhNameSlip; ?>">
								</div>
							</div>
						</div>
						<!-- เก็บชื่อ ที่ ชื่อโปรโมชั่นแบบย่อ ไป update หลัง approve -->
						<input type="hidden" id="ohdPTUPmhNameSlip" name="ohdPTUPmhNameSlip" value="<?php echo $tPmhNameSlip; ?>">


						<!-- รหัสอ้างอิงบัญชี -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tPTURefAccCode'); ?></label>
									<input
									type="text"
									class="form-control xCNApvOrCanCelDisabled"
									id="oetPTUPmhRefAccCode"
									name="oetPTUPmhRefAccCode"
									maxlength="20"
									value="<?php echo $tPTUPmhRefAccCode; ?>">
								</div>
							</div>
						</div>
						<!-- รหัสอ้างอิงบัญชี ที่ hendin ไป update หลัง approve -->
						<input type="hidden" id="ohdPTUPmhRefAccCode" name="ohdPTUPmhRefAccCode" value="<?php echo $tPTUPmhRefAccCode; ?>">

                        <!-- เปิดใช้งาน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input
										type="checkbox"
										value="1"
										id="ocbPTUPmhStaClosed"
										name="ocbPTUPmhStaClosed"
										maxlength="1" <?php echo $tPmhStaClosed == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tPausedTemporarily'); ?></span>
									</label>
								</div>
							</div>
						</div>

						<hr>

						<div class="row">
							<!-- จากวันที่ -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tFromDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetPTUPmhDStart"
										name="oetPTUPmhDStart"
										value="<?= $tPmhDStart; ?>">
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
									<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tToDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetPTUPmhDStop"
										name="oetPTUPmhDStop"
										value="<?= $tPmhDStop; ?>">
										<span class="input-group-btn">
											<button id="obtPmtDocDateTo" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<!-- จากเวลา -->
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tFromTime'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNTimePicker xCNApvOrCanCelDisabled"
										id="oetPTUPmhTStart"
										name="oetPTUPmhTStart"
										value="<?= $tPmhTStart; ?>">
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
									<label class="xCNLabelFrm"><?= language('sale/promotiontopup/promotiontopup', 'tToTime'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNTimePicker xCNApvOrCanCelDisabled"
										id="oetPTUPmhTStop"
										name="oetPTUPmhTStop"
										value="<?= $tPmhTStop; ?>">
										<span class="input-group-btn">
											<button id="obtPmtDocTimeTo" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

                        <div class="row">
                            <div class="col-md-12">
                                <!-- การคำนวน -->
                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tCalType'); ?></label>
                                    <select class="selectpicker form-control xCNApvOrCanCelDisabled" id="ocmPTUPmhCalType" name="ocmPTUPmhCalType">
                                        <option value="1" <?php echo $tPmhCalType == "1" ? 'selected' : ''; ?> ><?=language('sale/promotiontopup/promotiontopup', 'tCalType1');?></option>
                                        <option value="2" <?php echo $tPmhCalType == "2" ? 'selected' : ''; ?> ><?=language('sale/promotiontopup/promotiontopup', 'tCalType2');?></option>
                                    </select>
                                </div>
                            </div>
                        </div>

						<!-- การอนุญาต -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">

                                    <!-- อนุญาต นำยอดเติมไปทำรายการคืน -->
									<label class="fancy-checkbox">
										<input
										type="checkbox"
										class="xCNApvOrCanCelDisabled"
										value="1"
										id="ocbPTUPmhStaAlwRetMnyPay"
										name="ocbPTUPmhStaAlwRetMnyPay"
										maxlength="1" <?php echo $tPmhStaAlwRetMnyPay == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tStaAlwMnyPay'); ?></span>
									</label>

                                    <!-- อนุญาต นำยอดเงินรับพิเศษไปทำรายการคืน -->
                                    <label class="fancy-checkbox">
										<input
										type="checkbox"
										class="xCNApvOrCanCelDisabled"
										value="1"
										id="ocbPTUPmhStaAlwRetMnyGet"
										name="ocbPTUPmhStaAlwRetMnyGet"
										maxlength="1" <?php echo $tPmhStaAlwRetMnyGet == "1" ? 'checked' : ''; ?>>
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tStaAlwMnyGet'); ?></span>
									</label>

									<!-- เคลื่อนไหว -->
									<div class="form-group">
										<label class="fancy-checkbox">
											<input
											type="checkbox"
											class="xCNApvOrCanCelDisabled"
											value="1"
											id="ocbPTUPmhStaDocAct"
											name="ocbPTUPmhStaDocAct"
											maxlength="1" <?php echo $nStaDocAct == '1' ? 'checked' : ''; ?>>
											<span>&nbsp;</span>
											<span class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tStaDocAct'); ?></span>
										</label>
									</div>
									<!-- เคลื่อนไหว -->

								</div>
							</div>
						</div>



					</div>
				</div>
			</div>

			<!--Section : อื่นๆ-->
			<!-- <div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('sale/promotiontopup/promotiontopup', 'tOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>

				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('sale/promotiontopup/promotiontopup', 'tNote'); ?></label>
							<textarea class="form-control xCNApvOrCanCelDisabled" id="otaPTUPmhRmk" name="otaPTUPmhRmk"><?php echo $tRmk; ?></textarea>
						</div>
					</div>
				</div>
			</div> -->

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
										<div class="xCNPromotionCircle active xCNPromotionStep1" data-tab="odvPTUStep1" data-step="1" style="left: -7px;">
											<div class="xCNPromotionPopupSpan"><?php echo language('sale/promotiontopup/promotiontopup', 'tStep1'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep2" data-tab="odvPTUStep2" data-step="2" style="left: 30%;">
											<div class="xCNPromotionPopupSpan"><?php echo language('sale/promotiontopup/promotiontopup', 'tStep2'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep3" data-tab="odvPTUStep3" data-step="3" style="left: 65%;">
											<div class="xCNPromotionPopupSpan"><?php echo language('sale/promotiontopup/promotiontopup', 'tStep3'); ?></div>
										</div>
										<div class="xCNPromotionCircle xCNPromotionStep4" data-tab="odvPTUStep4" data-step="4" style="left: 99%;">
											<div class="xCNPromotionPopupSpan" style="left:-100px;"><?php echo language('sale/promotiontopup/promotiontopup', 'tStep4'); ?></div>
										</div>
										<!-- <div class="xCNPromotionCircle xCNPromotionStep5" data-tab="odvPTUStep5" data-step="5" style="left: 99%;">
											<div class="xCNPromotionPopupSpan" style="left:-100px;"><?php echo language('sale/promotiontopup/promotiontopup', 'tCheckAndConfirm'); ?></div>
										</div> -->
									</div>
								</div>

								<ul class="nav nav-tabs hidden">
									<li class="active"><a data-toggle="tab" href="#odvPTUStep1"></a></li>
									<li><a data-toggle="tab" href="#odvPTUStep2"></a></li>
									<li><a data-toggle="tab" href="#odvPTUStep3"></a></li>
									<li><a data-toggle="tab" href="#odvPTUStep4"></a></li>
									<!-- <li><a data-toggle="tab" href="#odvPTUStep5"></a></li> -->
								</ul>
								<!-- Step Control -->
								<div class="row">
									<div class="col-md-12">
										<button disabled class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPromotionBackStep" type="button" style="display: inline-block; width:150px;"> <?php echo language('sale/promotiontopup/promotiontopup', 'tBack'); ?></button>
										<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNPromotionNextStep" type="button" style="display: inline-block; width:150px;"> <?php echo language('sale/promotiontopup/promotiontopup', 'tNext'); ?></button>
									</div>
								</div>

								<div class="tab-content">
									<div id="odvPTUStep1" class="tab-pane fade in active">
										<?php include('advancetable/wPromotionTopupStep1.php'); ?>
									</div>
									<div id="odvPTUStep2" class="tab-pane fade">
										<?php include('advancetable/wPromotionTopupStep2.php'); ?>
									</div>
									<div id="odvPTUStep3" class="tab-pane fade">
										<?php include('advancetable/wPromotionTopupStep3.php'); ?>
									</div>
									<div id="odvPTUStep4" class="tab-pane fade">
										<?php /*include('advancetable/wPromotionTopupStep4.php');*/ ?>
										<div class="row">
											<div class="col-md-12">
												<div id="odvPTUDataTableStep4"></div>
											</div>
										</div>
										<?php include_once('advancetable/script/jPromotionTopupStep4.php'); ?>
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

<?php if(!$bIsApvOrCancel) { ?>
	<!-- Begin Approve Doc -->
	<div class="modal fade xCNModalApprove" id="odvPTUPopupApv">
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
					<button onclick="JSvPTUApprove(true)" type="button" class="btn xCNBTNPrimery">
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
	<div class="modal fade" id="odvPTUPopupCancel">
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
					<button onclick="JSvPTUCancel(true)" type="button" class="btn xCNBTNPrimery">
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

<?php include('script/jPromotionTopupAdd.php') ?>
<script src="<?php echo base_url('application\modules\common\assets\src\jFormValidate.js'); ?>"></script>
