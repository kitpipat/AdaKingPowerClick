<style>
    fieldset.scheduler-border {
        border      : 1px groove #ffffffa1 !important;
        padding     : 0 20px 20px 20px !important;
        margin      : 0 0 10px 0 !important;
    }

    legend.scheduler-border {
        text-align      : left !important;
        width           : auto;
        padding         : 0 5px;
        border-bottom   : none;
        font-weight     : bold;
    }

	.xCNBTNPrimeryCusPlus {
		border-radius: 50%;
		float: right;
		width: 30px;
		height: 30px;
		line-height: 30px;
		background-color: #1866ae;
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
	.xCNTransferBchOutTotalLabel {
		background-color: #f5f5f5;
		padding: 5px 10px;
		color: #232C3D !important;
		font-weight: 900;
	}
	.xCNTransferBchOutLabel {
		padding: 5px 10px;
		color: #232C3D !important;
		font-weight: 900;
	}
	.xCNTransferBchOutLabelFullWidth{
		width: 100%;
	}
	.xCNTransferBchOutLabelWidth{
		width: 260px;
	}
</style>

<?php
	if ($aResult['rtCode'] == "1") { // Edit
		$tBchCode = $aResult['raItems']['FTBchCode'];
		$tBchName = $aResult['raItems']['FTBchName'];
		$tDocNo = $aResult['raItems']['FTXthDocNo'];
		$tDocDate = $aResult['raItems']['FDXthDocDate'];
		$tDocTime = $aResult['raItems']['FTXthDocTime'];

		$tVATInOrEx = $aResult['raItems']['FTXthVATInOrEx'];
		$tRefExt = $aResult['raItems']['FTXthRefExt'];
		$tRefExtDate = $aResult['raItems']['FDXthRefExtDate'];
		$tRefInt = $aResult['raItems']['FTXthRefInt'];
		$tRefIntDate = $aResult['raItems']['FDXthRefIntDate'];
		$cTotal = $aResult['raItems']['FCXthTotal'];
		$cVat = $aResult['raItems']['FCXthVat'];
		$cVatable = $aResult['raItems']['FCXthVatable'];
		$tStaPrcStk = $aResult['raItems']['FTXthStaPrcStk'];
		$tStaRef = $aResult['raItems']['FNXthStaRef'];

		$tDptCode = $aResult['raItems']['FTDptCode'];

		$tSpnCode = $aResult['raItems']['FTSpnCode'];

		$tRsnCode = $aResult['raItems']['FTRsnCode'];
		$tRsnName = $aResult['raItems']['FTRsnName'];

		$tCreateByCode = $aResult['raItems']['FTCreateBy'];
		$tCreateByName = $aResult['raItems']['FTCreateByName'];

		$tUsrApvCode = $aResult['raItems']['FTXthApvCode'];
		$tUsrApvName = $aResult['raItems']['FTXthApvName'];

		$tStaDoc = $aResult['raItems']['FTXthStaDoc'];
		$tStaApv = $aResult['raItems']['FTXthStaApv'];
		$tUsrKeyCode = $aResult['raItems']['FTUsrCode']; // พนักงาน Key
		$tStaDelMQ = $aResult['raItems']['FTXthStaDelMQ'];
		$nStaDocAct = $aResult['raItems']['FNXthStaDocAct'];
		$nDocPrint = $aResult['raItems']['FNXthDocPrint'];
		$tRmk = $aResult['raItems']['FTXthRmk'];

		$tCtrName = $aResult['raItems']['FTXthCtrName'];
		$tTnfDate = $aResult['raItems']['FDXthTnfDate'];
		$tRefTnfID = $aResult['raItems']['FTXthRefTnfID'];
		$tRefVehID = $aResult['raItems']['FTXthRefVehID'];
		$tQtyAndTypeUnit = $aResult['raItems']['FTXthQtyAndTypeUnit'];
		$nShipAdd = $aResult['raItems']['FNXthShipAdd'];

		$tViaCode = $aResult['raItems']['FTViaCode'];
		$tViaName = $aResult['raItems']['FTViaName'];

		$tRoute = "docTransferBchOutEventEdit";

		$tUserBchCodeFrom = $aResult['raItems']['FTXthBchFrm'];
		$tUserBchNameFrom = $aResult['raItems']['FTXthBchFrmName'];
		$tUserMchCodeFrom = $aResult['raItems']['FTXthMerchantFrm'];
		$tUserMchNameFrom = $aResult['raItems']['FTXthMerchantFrmName'];
		$tUserShpCodeFrom = $aResult['raItems']['FTXthShopFrm'];
		$tUserShpNameFrom = $aResult['raItems']['FTXthShopFrmName'];
		$tUserWahCodeFrom = $aResult['raItems']['FTXthWhFrm'];
		$tUserWahNameFrom = $aResult['raItems']['FTXthWhFrmName'];

		$tUserBchCodeTo = $aResult['raItems']['FTXthBchTo'];
		$tUserBchNameTo = $aResult['raItems']['FTXthBchToName'];
		$tUserWahCodeTo = $aResult['raItems']['FTXthWhTo'];
		$tUserWahNameTo = $aResult['raItems']['FTXthWhToName'];

		$tStaPrcDoc = $aResult['raItems']['FTXthStaPrcDoc'];
		$nStaUploadFile = 2;

	} else { // New
		$tUserLevel = $this->session->userdata('tSesUsrLevel');
		$tBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
		$tBchName = $this->session->userdata("tSesUsrBchNameDefault");
		$tDocNo = "";
		$tDocDate = date('Y-m-d');
		$tDocTime = date('H:i');

		$tVATInOrEx = "";
		$tRefExt = "";
		$tRefExtDate = "";
		$tRefInt = "";
		$tRefIntDate = "";
		$cTotal = 0;
		$cVat = 0;
		$cVatable = 0;
		$tStaPrcStk = "";
		$tStaRef = "0";

		$tDptCode = "";

		$tSpnCode = "";

		$tRsnCode = "";
		$tRsnName = "";

		$tCreateByCode =  $this->session->userdata('tSesUsername');
		$tCreateByName = $this->session->userdata('tSesUsrUsername');

		$tUsrApvCode = "";
		$tUsrApvName = "";

		$tStaDoc = "";
		$tStaApv = "";
		$tUsrKeyCode = $this->session->userdata('tSesUsername'); // พนักงาน Key
		$tStaDelMQ = "";
		$nStaDocAct = 1;
		$nDocPrint = 0;
		$tRmk = "";

		$tCtrName = "";
		$tTnfDate = "";
		$tRefTnfID = "";
		$tRefVehID = "";
		$tQtyAndTypeUnit = "";
		$nShipAdd = "";

		$tViaCode = "";
		$tViaName = "";

		$tRoute = "docTransferBchOutEventAdd";

		$tUserBchCodeFrom = $this->session->userdata('tSesUsrBchCodeDefault');
		$tUserBchNameFrom = $this->session->userdata('tSesUsrBchNameDefault');
		$tUserMchCodeFrom = $this->session->userdata('tSesUsrMerCode');
		$tUserMchNameFrom = $this->session->userdata('tSesUsrMerName');
		$tUserShpCodeFrom = $this->session->userdata('tSesUsrShpCodeDefault');
		$tUserShpNameFrom = $this->session->userdata('tSesUsrShpNameDefault');
		$tUserWahCodeFrom = "";//$this->session->userdata('tSesUsrWahCode');
		$tUserWahNameFrom = "";//$this->session->userdata('tSesUsrWahName');

		$tUserBchCodeTo = "";
		$tUserBchNameTo = "";
		$tUserWahCodeTo = "";
		$tUserWahNameTo = "";

		$tStaPrcDoc = "";
		$nStaUploadFile = 1;

		// if ($this->session->userdata('tSesUsrLevel') == 'HQ') {
		// 	$tUserBchCodeFrom = $tBchCompCode;
		// 	$tUserBchNameFrom = $tBchCompName;
		// }
		// if ($this->session->userdata('tSesUsrLevel') == 'BCH') {
			// $tUserBchCodeFrom = $this->session->userdata('tSesUsrBchCodeDefault');
			// $tUserBchNameFrom = $this->session->userdata('tSesUsrBchNameDefault');
		// }
		// if ($this->session->userdata('tSesUsrLevel') == 'SHP') {
			// $tUserBchCodeFrom = $this->session->userdata('tSesUsrBchCode');
			// $tUserBchNameFrom = $this->session->userdata('tSesUsrBchName');

			// $tUserMchCodeFrom = $this->session->userdata('tSesUsrMerCode');
			// $tUserMchNameFrom = $this->session->userdata('tSesUsrMerName');

			// $tUserShpCodeFrom = $this->session->userdata('tSesUsrShpCodeDefault');
			// $tUserShpNameFrom = $this->session->userdata('tSesUsrShpNameDefault');

			// $tUserWahCodeFrom = $this->session->userdata('tSesUsrWahCode');
			// $tUserWahNameFrom = $this->session->userdata('tSesUsrWahName');
		// }
	}

	// if( $tStaPrcDoc != "" ){
	// 	if( $tStaPrcDoc != "1" ){
	// 		$bIsPacking = true;
	// 	}else{
	// 		$bIsPacking = false;
	// 	}
	// }else{
	// 	$bIsPacking = false;
	// }

	$nLangEdit = $this->session->userdata("tLangEdit");
	$tUsrApv = $this->session->userdata("tSesUsername");
	$tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
	$bIsAddPage = empty($tDocNo) ? true : false;
	$bIsApv = empty($tStaApv) ? false : true;
	$bIsPrcStk = ($tStaPrcStk == "1") ? true : false;
	$bIsCancel = ($tStaDoc == "3") ? true : false;
	$bIsApvOrCancel = ($bIsApv || $bIsCancel);
	$bIsMultiBch = $this->session->userdata("nSesUsrBchCount") > 1;
	$bIsShpEnabled = FCNbGetIsShpEnabled();
	$bIsPacking = ( $tStaPrcDoc != "" && $tStaPrcDoc != "1" ? true : false );
?>

<script>
	var nLangEdit = '<?php echo $nLangEdit; ?>';
	var tUsrApv = '<?php echo $tUsrApv; ?>';
	var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
	var bIsAddPage = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
	var bIsApv = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
	var bIsCancel = <?php echo ($bIsCancel) ? 'true' : 'false'; ?>;
	var bIsPrcStk = <?php echo ($bIsPrcStk) ? 'true' : 'false'; ?>;
	var bIsApvOrCancel = <?php echo ($bIsApvOrCancel) ? 'true' : 'false'; ?>;
	var tStaApv = '<?php echo $tStaApv; ?>';
	var bIsMultiBch = <?php echo ($bIsMultiBch) ? 'true' : 'false'; ?>;
	var bIsShpEnabled = <?php echo ($bIsShpEnabled) ? 'true' : 'false'; ?>;
	var bIsPacking = <?php echo ($tStaPrcDoc != "" && $tStaPrcDoc != "1") ? 'true' : 'false'; ?>;
</script>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmTransferBchOutForm">
	<input type="hidden" id="ohdTBOStaPrcDoc" name="ohdTBOStaPrcDoc" value="<?php echo $tStaPrcDoc; ?>">
	<input type="hidden" id="ohdTransferBchOutBchLogin" name="ohdTransferBchOutBchLogin" value="<?php echo $tBchCode; ?>">
	<input type="hidden" id="ohdTransferBchOutStaApv" name="ohdTransferBchOutStaApv" value="<?php echo $tStaApv; ?>">
	<input type="hidden" id="ohdTransferBchOutStaDelMQ" name="ohdTransferBchOutStaDelMQ" value="<?php echo $tStaDelMQ; ?>">
	<input type="text" class="xCNHide" id="oetTransferBchOutApvCodeUsrLogin" name="oetTransferBchOutApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<button style="display:none" type="submit" id="obtTransferBchOutSubmit" onclick="JSxTransferBchOutValidateForm();"></button>

	<div class="row">
		<div class="col-md-3">
			<!--Section : รายละเอียดเอกสาร-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?= language('document/transfer_branch_out/transfer_branch_out', 'tStatus'); ?></label>
					<a class="xCNMenuplus <?php echo ($bIsAddPage)?'collapsed':''; ?>" role="button" data-toggle="collapse" href="#odvTransferBchOutDocDetailPanel" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvTransferBchOutDocDetailPanel" class="panel-collapse collapse <?php echo ($bIsAddPage)?'':'in'; ?>" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?= language('document/transfer_branch_out/transfer_branch_out', 'tApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton">
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transfer_branch_out/transfer_branch_out', 'tDocNo'); ?></label>
						<?php if ($bIsAddPage) { ?>
							<div class="form-group" id="odvTransferBchOutAutoGenCode">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbTransferBchOutAutoGenCode" name="ocbTransferBchOutAutoGenCode" checked="true" value="1">
										<span><?= language('document/transfer_branch_out/transfer_branch_out', 'tAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="odvPunCodeForm">
								<input
								type="text"
								class="form-control xCNInputWithoutSpcNotThai"
								maxlength="20"
								id="oetTransferBchOutDocNo"
								name="oetTransferBchOutDocNo"
								data-is-created="<?php  ?>"
								placeholder="<?= language('document/transfer_branch_out/transfer_branch_out', 'tDocNo') ?>"
								value="<?php  ?>"
								data-validate-required="<?= language('document/transfer_branch_out/transfer_branch_out', 'tDocNoRequired') ?>"
								data-validate-dublicateCode="<?= language('document/transfer_branch_out/transfer_branch_out', 'tDocNoDuplicate') ?>"
								disabled readonly>
								<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW">
							</div>
						<?php } else { ?>
							<div class="form-group" id="odvPunCodeForm">
								<div class="validate-input">
									<input type="text" class="form-control xCNInputWithoutSpcNotThai " maxlength="20" id="oetTransferBchOutDocNo" name="oetTransferBchOutDocNo" data-is-created="<?php  ?>" placeholder="<?= language('document/transfer_branch_out/transfer_branch_out', 'tTFWDocNo') ?>" value="<?php echo $tDocNo; ?>" readonly onfocus="this.blur()">
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transfer_branch_out/transfer_branch_out', 'tDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTransferBchOutDocDate" name="oetTransferBchOutDocDate" value="<?= $tDocDate; ?>" data-validate-required="<?= language('document/transfer_branch_out/transfer_branch_out', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/transfer_branch_out/transfer_branch_out', 'tDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetTransferBchOutDocTime" name="oetTransferBchOutDocTime" value="<?= $tDocTime; ?>" data-validate-required="<?= language('document/transfer_branch_out/transfer_branch_out', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'tCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateByCode ?>">
								<label><?= $tCreateByName ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'tTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/transfer_branch_out/transfer_branch_out', 'tStaDoc' . $tStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'tTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/transfer_branch_out/transfer_branch_out', 'tStaApv' . $tStaApv); ?></label>
							</div>
						</div>
						<?php if ($tDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'tApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?= $tUsrApvCode ?>">
									<label><?= $tUsrApvName != '' ? $tUsrApvName : language('document/transfer_branch_out/transfer_branch_out', 'tStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!--Section : เงื่อนไขเอกสาร -->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'เงื่อนไข'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTransferBchOutDocConditionPanel" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvTransferBchOutDocConditionPanel" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="row">
							<div class="col-md-12">
								<!-- สาขาที่สร้าง -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBBchCreate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="input100 xCNHide"
										id="oetTransferBchOutBchCode"
										name="oetTransferBchOutBchCode"
										maxlength="5"
										value="<?php echo $tBchCode; ?>">
										<input
										class="form-control xWPointerEventNone"
										type="text"
										id="oetTransferBchOutBchName"
										name="oetTransferBchOutBchName"
										value="<?php echo $tBchName; ?>"
										readonly>
										<span class="input-group-btn xWConditionSearchPdt">
											<button id="obtTransferBchOutBrowseBch" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
											</button>
										</span>
									</div>
								</div>
								<!-- สาขาที่สร้าง -->
							</div>
						</div>

						<!-- ต้นทาง -->
						<fieldset class="scheduler-border">
							<legend class="scheduler-border"><?=language('document/transferreceiptbranch/transferreceiptbranch','tTBIOrigin');?></legend>

							<!-- จากกลุ่มร้านค้า -->
							<!-- <div class="form-group <?php if(!FCNbGetIsShpEnabled()) : echo 'xCNHide';  endif;?>">
								<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'กลุ่มร้านค้า'); ?></label>
								<div class="input-group">
									<input
									type="text"
									class="input100 xCNHide xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthMerchantFrmCode"
									name="oetTransferBchOutXthMerchantFrmCode"
									maxlength="5"
									value="<?php echo $tUserMchCodeFrom; ?>">
									<input
									class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
									type="text" id="oetTransferBchOutXthMerchantFrmName"
									name="oetTransferBchOutXthMerchantFrmName"
									value="<?php echo $tUserMchNameFrom; ?>"
									readonly
									data-validate-required="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBWahNameStartRequired'); ?>">
									<span class="input-group-btn xWConditionSearchPdt">
										<button id="obtTransferBchOutBrowseMerFrom" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
								<input
								type="text"
								class="input100 xCNHide"
								id="oetTransferBchOutWahInShopCode"
								name="oetTransferBchOutWahInShopCode"
								maxlength="5"
								value="<?php echo $tUserWahCodeFrom; ?>">
							</div> -->
							<!-- จากกลุ่มร้านค้า -->

							<!-- จากสาขา -->
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'สาขา'); ?></label>
								<div class="input-group">
									<input
									type="text"
									class="input100 xCNHide xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthBchFrmCode"
									name="oetTransferBchOutXthBchFrmCode"
									maxlength="5"
									value="<?php echo $tUserBchCodeFrom; ?>">
									<input
									class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
									type="text" id="oetTransferBchOutXthBchFrmName"
									name="oetTransferBchOutXthBchFrmName"
									value="<?php echo $tUserBchNameFrom; ?>"
									readonly
									data-validate-required="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBWahNameStartRequired'); ?>">
									<span class="input-group-btn xWConditionSearchPdt">
										<button id="obtTransferBchOutBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>

							<!-- จากร้านค้า -->
							<!-- <div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ร้านค้า'); ?></label>
								<div class="input-group">
									<input
									class="form-control xCNHide xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthShopFrmCode"
									name="oetTransferBchOutXthShopFrmCode"
									maxlength="5"
									value="<?php echo $tUserShpCodeFrom; ?>">
									<input
									type="text"
									class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthShopFrmName"
									name="oetTransferBchOutXthShopFrmName"
									value="<?php echo $tUserShpNameFrom; ?>"
									readonly>
									<span class="xWConDisDocument input-group-btn">
										<button id="obtTransferBchOutBrowseShpFrom" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled"><img class="xCNIconFind"></button>
									</span>
								</div>
							</div> -->

							<!-- จากคลัง -->
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'คลังสินค้า'); ?></label>
								<div class="input-group">
									<input
									type="text"
									class="input100 xCNHide xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthWhFrmCode"
									name="oetTransferBchOutXthWhFrmCode"
									maxlength="5"
									value="<?php echo $tUserWahCodeFrom; ?>">
									<input
									class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
									type="text"
									id="oetTransferBchOutXthWhFrmName"
									name="oetTransferBchOutXthWhFrmName"
									value="<?php echo $tUserWahNameFrom; ?>"
									readonly
									data-validate-required="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBPlsEnterWah'); ?>">
									<span class="input-group-btn xWConditionSearchPdt">
										<button id="obtTransferBchOutBrowseWahFrom" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>
						</fieldset>

						<!-- ปลายทาง -->
						<fieldset class="scheduler-border">
							<legend class="scheduler-border"><?=language('document/transferreceiptbranch/transferreceiptbranch','tTBITo');?></legend>

							<!-- ถึงสาขา -->
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch'); ?></label>
								<div class="input-group">
									<input
									class="form-control xCNHide xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthBchToCode"
									name="oetTransferBchOutXthBchToCode"
									maxlength="5"
									value="<?php echo $tUserBchCodeTo; ?>">
									<input
									class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
									type="text"
									id="oetTransferBchOutXthBchToName"
									name="oetTransferBchOutXthBchToName"
									placeholder="<?php echo language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIBranch'); ?>"
									value="<?php echo $tUserBchNameTo; ?>"
									readonly
									data-validate-required="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBPlsEnterBch'); ?>">
									<span class="xWConditionSearchPdt input-group-btn">
										<button id="obtTransferBchOutBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>

							<!-- ถึงคลัง -->
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'คลังสินค้า'); ?></label>
								<div class="input-group">
									<input
									type="text"
									class="input100 xCNHide xCNApvOrCanCelDisabled"
									id="oetTransferBchOutXthWhToCode"
									name="oetTransferBchOutXthWhToCode"
									maxlength="5"
									value="<?php echo $tUserWahCodeTo; ?>">
									<input
									class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
									placeholder="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'คลังสินค้า'); ?>"
									type="text"
									id="oetTransferBchOutXthWhToName"
									name="oetTransferBchOutXthWhToName"
									value="<?php echo $tUserWahNameTo; ?>"
									readonly
									data-validate-required="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'tTBPlsEnterWah'); ?>">
									<span class="input-group-btn xWConditionSearchPdt">
										<button id="obtTransferBchOutBrowseWahTo" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>
						</fieldset>

					</div>
				</div>
			</div>

			<!--Section : อ้างอิงเอกสาร -->
			<div class="panel panel-default" style="margin-bottom: 25px;display:none;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'อ้างอิงเอกสาร'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvTransferBchOutDocReferPanel" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvTransferBchOutDocReferPanel" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- เอกสารอ้างอิงภายใน -->
						<!-- <div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'เอกสารอ้างอิงภายใน'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" id="oetTransferBchOutXthRefInt" name="oetTransferBchOutXthRefInt" maxlength="20" value="<?php echo $tRefInt; ?>">
								</div>
							</div>
						</div> -->
						<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="xCNLabelFrm"><?= language('document/adjustmentcost/adjustmentcost', 'tADCRefInt'); ?></label>
								<div class="input-group" style="width:100%;">
									<input type="hidden" id="oetTransferBchOutXthRefIntOld" name="oetTransferBchOutXthRefIntOld" value="<?=@$tRefInt?>">
									<input type="text" class="input100 xCNHide" id="oetTransferBchOutXthRefInt" name="oetTransferBchOutXthRefInt" value="<?=@$tRefInt?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetTransferBchOutXthRefIntName" name="oetTransferBchOutXthRefIntName" value="<?=@$tRefInt?>" readonly placeholder="<?= language('document/adjustmentcost/adjustmentcost', 'tADCRefInt'); ?>">
									<span class="input-group-btn">
										<button id="obtTransferBchOutRefInt" type="button" class="btn xCNBtnBrowseAddOn" >
											<img src="<?=  base_url() . '/application/modules/common/assets/images/icons/find-24.png'; ?>">
										</button>
									</span>
								</div>
							</div>
						</div>
					</div>
						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'วันที่เอกสารภายใน'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										placeholder="YYYY-MM-DD" id="oetTransferBchOutXthRefIntDate" name="oetTransferBchOutXthRefIntDate" value="<?php echo $tRefIntDate; ?>">
										<span class="input-group-btn">
											<button id="obtTransferBchOutXthRefIntDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- เลขที่อ้างอิงเอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'เอกสารอ้างอิงภายนอก'); ?></label>
									<input type="text" placeholder="<?php echo language('document/transfer_branch_out/transfer_branch_out', 'เอกสารอ้างอิงภายนอก'); ?>" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" id="oetTransferBchOutXthRefExt" name="oetTransferBchOutXthRefExt" maxlength="20" value="<?php echo $tRefExt; ?>">
								</div>
							</div>
						</div>
						<!-- วันที่เอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'วันที่เอกสารภายนอก'); ?></label>
									<div class="input-group">
										<input type="text" placeholder="YYYY-MM-DD" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTransferBchOutXthRefExtDate" name="oetTransferBchOutXthRefExtDate" value="<?php echo $tRefExtDate; ?>">
										<span class="input-group-btn">
											<button id="obtTransferBchOutXthRefExtDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

					</div>
				</div>
			</div>

			<!--Section : การขนส่ง -->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'การขนส่ง'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTransferBchOutDeliveryPanel" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvTransferBchOutDeliveryPanel" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<!-- ชื่อผู้ติดต่อ -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ชื่อผู้ติดต่อ'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTransferBchOutXthCtrName" name="oetTransferBchOutXthCtrName" value="<?php echo $tCtrName; ?>">
								</div>
							</div>
						</div>
						<!-- ชื่อผู้ติดต่อ -->

						<!-- วันที่ขนส่ง -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'วันที่ขนส่ง'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTransferBchOutXthTnfDate" name="oetTransferBchOutXthTnfDate" value="<?php echo $tTnfDate; ?>">
										<span class="input-group-btn">
											<button id="obtTransferBchOutXthTnfDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- วันที่ขนส่ง -->

						<!-- อ้างอิงเลขที่ใบขนส่ง -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'อ้างอิงเลขที่ใบขนส่ง'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTransferBchOutXthRefTnfID" name="oetTransferBchOutXthRefTnfID" value="<?php echo $tRefTnfID; ?>">
								</div>
							</div>
						</div>
						<!-- อ้างอิงเลขที่ใบขนส่ง -->

						<!-- อ้างอิงเลขที่ยานพาหนะขนส่ง -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'อ้างอิงเลขที่ยานพาหนะขนส่ง'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTransferBchOutXthRefVehID" name="oetTransferBchOutXthRefVehID" value="<?php echo $tRefVehID; ?>">
								</div>
							</div>
						</div>
						<!-- อ้างอิงเลขที่ยานพาหนะขนส่ง -->

						<!-- ลักษณะหีบห่อ -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ลักษณะหีบห่อ'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTransferBchOutXthQtyAndTypeUnit" name="oetTransferBchOutXthQtyAndTypeUnit" value="<?php echo $tQtyAndTypeUnit; ?>">
								</div>
							</div>
						</div>
						<!-- ลักษณะหีบห่อ -->

						<!-- ขนส่งโดย -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ขนส่งโดย'); ?></label>
									<div class="input-group">
										<input
										class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
										type="text"
										id="oetTransferBchOutShipViaName"
										name="oetTransferBchOutShipViaName"
										value="<?php echo $tViaName; ?>"
										readonly>
										<input
										type="text"
										class="input100 xCNHide xCNApvOrCanCelDisabled"
										id="oetTransferBchOutShipViaCode"
										name="oetTransferBchOutShipViaCode"
										value="<?php echo $tViaCode; ?>">
										<span class="input-group-btn">
											<button id="obtTransferBchOutBrowseShipVia" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- ขนส่งโดย -->

						<!-- ที่อยู่สำหรับจัดส่ง -->
						<!-- <div class="row">
							<div class="col-md-12">
								<input tyle="text" class="xCNHide" id="ohdTransferBchOutXthShipAdd" name="ohdTransferBchOutXthShipAdd" value="">
								<button type="button" id="obtTBBrowseShipAdd" class="btn btn-primary <?php
									if($tRoute=="TBXEventAdd"){
										echo " xWConditionSearchPdt disabled";
									}else{

									}
								?>" style="font-size: 17px;"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ที่อยู่สำหรับจัดส่ง'); ?></button>
							</div>
						</div> -->
						<!-- ที่อยู่สำหรับจัดส่ง -->
					</div>
				</div>
			</div>

			<!--Section : อื่นๆ-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'tOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- เหตุผล -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?= language('document/transfer_branch_out/transfer_branch_out', 'เหตุผล'); ?></label>
                            <div class="input-group">
								<input
								name="oetTransferBchOutRsnName"
								id="oetTransferBchOutRsnName"
								class="form-control xWPointerEventNone xCNApvOrCanCelDisabled"
								value="<?=$tRsnName?>"
								type="text"
								readonly
                                placeholder="<?= language('document/transfer_branch_out/transfer_branch_out', 'เหตุผล') ?>">
								<input
								name="oetTransferBchOutRsnCode"
								id="oetTransferBchOutRsnCode"
								value="<?=$tRsnCode?>"
								class="form-control xCNHide xCNApvOrCanCelDisabled"
								type="text">
                                <span class="input-group-btn">
                                    <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtTransferBchOutBrowseReason" type="button">
                                        <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
						</div>
						<!-- เหตุผล -->

						<!-- หมายเหตุ -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'หมายเหตุ'); ?></label>
							<textarea class="form-control xCNInputWithoutSpc " id="otaTransferBchOutXthRmk" name="otaTransferBchOutXthRmk" maxlength="200"><?php echo $tRmk; ?></textarea>
						</div>
						<!-- หมายเหตุ -->

						<!-- เคลื่อนไหว -->
						<div class="form-group">
							<label class="fancy-checkbox">
								<input

								type="checkbox"
								value="1"
								<?php echo ($nStaDocAct == 1)?'checked':''; ?>
								id="ocbTransferBchOutXthStaDocAct"
								name="ocbTransferBchOutXthStaDocAct"
								maxlength="1">
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'เคลื่อนไหว'); ?></span>
							</label>
						</div>
						<!-- เคลื่อนไหว -->

						<!-- สถานะอ้างอิง -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'สถานะอ้างอิง'); ?></label>
							<select class="selectpicker form-control xCNApvOrCanCelDisabled" id="ostTransferBchOutXthStaRef" name="ostTransferBchOutXthStaRef" maxlength="1">
								<option value="0" <?php echo ($tStaRef == "0")?'checked':''; ?>><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ไม่เคยอ้างอิง'); ?></option>
								<option value="1" <?php echo ($tStaRef == "1")?'checked':''; ?>><?php echo language('document/transfer_branch_out/transfer_branch_out', 'อ้างอิงบางส่วน'); ?></option>
								<option value="2" <?php echo ($tStaRef == "2")?'checked':''; ?>><?php echo language('document/transfer_branch_out/transfer_branch_out', 'อ้างอิงทั้งหมด'); ?></option>
							</select>
						</div>
						<!-- สถานะอ้างอิง -->

						<!-- จำนวนครั้งที่ปริ้น -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'จำนวนครั้งที่ปริ้น'); ?></label>
							<input readonly type="text" class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled" maxlength="100" id="oetTransferBchOutXthDocPrint" name="oetTransferBchOutXthDocPrint" maxlength="1" value="">
						</div>
						<!-- จำนวนครั้งที่ปริ้น -->

						<!-- ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม'); ?></label>
							<select class="selectpicker form-control xCNApvOrCanCelDisabled" id="ocmTransferBchOutOptionAddPdt" name="ocmTransferBchOutOptionAddPdt">
								<option value="1"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'บวกจำนวนในรายการเดิม'); ?></option>
								<option value="2"><?php echo language('document/transfer_branch_out/transfer_branch_out', 'เพิ่มแถวใหม่'); ?></option>
							</select>
						</div>
						<!-- ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม -->
					</div>
				</div>
			</div>

			<!-- Panel ไฟลแนบ -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div id="odvTBOReferenceDoc" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/saleorder/saleorder', 'ไฟล์แนบ'); ?></label>
                    <a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvTBODataFile" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvTBODataFile" class="xCNMenuPanelData panel-collapse collapse" role="tabpanel">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" id="odvTBOShowDataTable">


                            </div>
                        </div>
                    </div>
                </div>
                <script>
                    let oTBOCallDataTableFile = {
                        ptElementID		: 'odvTBOShowDataTable',
                        ptBchCode		: $('#oetTransferBchOutBchCode').val(),
                        ptDocNo			: $('#oetTransferBchOutDocNo').val(),
                        ptDocKey		: 'TCNTPdtTboHD',
                        ptSessionID		: '<?=$this->session->userdata("tSesSessionID") ?>',
                        pnEvent			: <?=$nStaUploadFile?>,
                        ptCallBackFunct	: ''
                    }
                    JCNxUPFCallDataTable(oTBOCallDataTableFile);
                </script>
            </div>

		</div>

		<!--Panel ตารางฝั่งขวา-->
		<div class="col-md-9" id="odvRightPanal">
			<div class="panel panel-default xCNTransferBchOutPdtContainer" style="margin-bottom: 25px;">


				<div class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">


						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="custom-tabs-line tabs-line-bottom left-aligned">
									<ul class="nav" role="tablist">

										<!-- สินค้า -->
										<li class="xWMenu active xCNStaHideShow" style="cursor:pointer;">
											<a role="tab" data-toggle="tab" data-target="#odvTBOContentProduct" aria-expanded="true"><?= language('document/document/document', 'ข้อมูลสินค้า') ?></a>
										</li>

										<!-- อ้างอิง -->
										<li class="xWMenu xWSubTab xCNStaHideShow" style="cursor:pointer;">
											<a role="tab" data-toggle="tab" data-target="#odvTBOContentHDDocRef" aria-expanded="false"><?= language('document/document/document', 'เอกสารอ้างอิง') ?></a>
										</li>

									</ul>
								</div>
							</div>
						</div>

						<div class="tab-content">

							<!--รายการสินค้า-->
							<div id="odvTBOContentProduct" class="tab-pane fade active in" style="padding: 0px !important;">
								<div class="row p-t-15">
									<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
										<div class="form-group">
											<div class="input-group">
												<input type="text" class="form-control" maxlength="100" id="oetTransferBchOutPdtSearchAll" name="oetTransferBchOutPdtSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSxTransferBchOutGetPdtInTmp(1, true)" placeholder="<?=language('document/purchaseinvoice/purchaseinvoice','tPIFrmFilterTablePdt')?>" style="display: block;">
												<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvTBScanPdtHTML()" placeholder="แสกนสินค้า" style="display: none;" data-validate="ไม่พบข้อมูลที่แสกน">
												<span class="input-group-btn">
													<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
														<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSxTransferBchOutGetPdtInTmp(1, true)" style="display: inline-block;">
															<img src="<?php echo  base_url('application/modules/common/assets/images/icons/search-24.png'); ?>" style="width:20px;">
														</button>
														<button id="oimMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display: none;" onclick="JSvTBScanPdtHTML()">
															<img class="oimMngPdtIconScan" src="<?php echo  base_url('application/modules/common/assets/images/icons/scanner.png'); ?>" style="width:20px;">
														</button>
													</div>
												</span>
											</div>
										</div>
									</div>

									<div class="col-xs-12 <?php echo ( ($bIsApvOrCancel === false && $bIsPacking === false) )?'col-sm-5 col-md-5 col-lg-5':'col-sm-6 col-md-6 col-lg-6'; ?> text-right">
										<!-- <div id="odvTransferBchOutMngAdvTableList" class="btn-group xCNDropDrownGroup">
											<button onclick="JSxTransferBchOutPdtColumnControl()" type="button" class="btn xCNBTNMngTable <?php echo (!$bIsApvOrCancel)?'m-r-20':''; ?> xCNTransferBchOutColumnControl"><?=language('common/main/main', 'tModalAdvTable') ?></button>
										</div> -->
										<?php if( ($bIsApvOrCancel === false && $bIsPacking === false) ) { ?>
											<div id="odvTransferBchOutMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
												<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
													<?=language('common/main/main','tCMNOption')?> <span class="caret"></span>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li id="oliTransferBchOutPdtBtnDeleteMulti" class="disabled">
														<a href="javascript:;" onclick="JSxTransferBchOutCallPdtDataTableDeleteMore()"><?=language('common/main/main','tDelAll')?></a>
													</li>
												</ul>
											</div>
										<?php } ?>
									</div>
									<?php if( ($bIsApvOrCancel === false && $bIsPacking === false) ) { ?>
										<div class="col-xs-12 col-sm-1 col-md-1 col-lg-1">
											<div class="form-group">
												<div style="position: absolute;right: 15px;">
													<button type="button" class="xCNBTNPrimeryPlus xCNTransferBchOutBtnBrowsePdt" onclick="JCNvTransferBchOutBrowsePdt()">+</button>
												</div>
											</div>
										</div>
									<?php } ?>
								</div>

								<div id="odvTransferBchOutPdtDataTable"></div>

							</div>
							<!--รายการสินค้า-->

							<!-- อ้างอิงเอกสาร -->
							<div id="odvTBOContentHDDocRef" class="tab-pane fade" style="padding: 0px !important;">
								<div class="row p-t-15">
									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 text-right">
										<div style="margin-top:-2px;">
											<button type="button" id="obtTBOAddDocRef" class="xCNBTNPrimeryPlus xCNDocBrowsePdt xCNHideWhenCancelOrApprove">+</button>
										</div>
									</div>
									<div id="odvTBOTableHDRef"></div>
									<div>
									</div>
								</div>
							</div>
							<!-- อ้างอิงเอกสาร -->

						</div>
					</div>
				</div>
			</div>

			<!-- <div class="panel panel-default xCNTransferBchOutFootTotalContainer" style="margin-bottom: 25px;"> -->
				<!-- ท้ายรายการ -->
				<!-- <div class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<style>
							#odvSORowDataEndOfBill .panel-heading{
								padding-top: 10px !important;
								padding-bottom: 10px !important;
							}
							#odvSORowDataEndOfBill .panel-body{
								padding-top: 0px !important;
								padding-bottom: 0px !important;
							}
							#odvSORowDataEndOfBill .list-group-item {
								padding-left: 0px !important;
								padding-right: 0px !important;
								border: 0px solid #ddd;
							}
							.mark-font, .panel-default > .panel-heading.mark-font{
								color: #232C3D !important;
								font-weight: 900;
							}
						</style>
						<div class="row p-t-10" id="odvSORowDataEndOfBill">
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="panel panel-default">
									<div class="panel-heading">
										<div class="pull-left mark-font">ภาษีมูลค่าเพิ่ม</div>
										<div class="pull-right mark-font">ยอดภาษี</div>
										<div class="clearfix"></div>
									</div>
									<div class="panel-body">
										<ul class="list-group" id="oulTransferBchOutDataListVat"></ul>
									</div>
									<div class="panel-heading">
										<label class="pull-left mark-font">ยอดรวมภาษีมูลค่าเพิ่ม</label>
										<label class="pull-right mark-font" id="olbTransferBchOutVatSum">0.00</label>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
							<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
								<div class="panel panel-default">
									<div class="panel-body">
										<ul class="list-group">
											<li class="list-group-item">
												<label class="pull-left mark-font">จำนวนเงินรวม</label>
												<label class="pull-right mark-font" id="olbTransferBchOutSumFCXtdNet">0.00</label>
												<div class="clearfix"></div>
											</li>
											<li class="list-group-item">
												<label class="pull-left">ยอดรวมภาษีมูลค่าเพิ่ม</label>
												<label class="pull-right" id="olbTransferBchOutSumFCXtdVat">0.00</label>
												<div class="clearfix"></div>
											</li>
											<li class="list-group-item">
												<label class="pull-left">มูลค่าแยกภาษี </label>
												<label class="pull-left" style="margin-left: 5px;" id="olbSODisChgHD"></label>
												<label class="pull-right" id="olbTransferBchOutSumFCXtdNetWithoutVate">0.00</label>
												<div class="clearfix"></div>
											</li>
										</ul>
									</div>
									<div class="panel-heading">
										<label class="pull-left mark-font">จำนวนเงินรวมทั้งสิ้น</label>
										<label class="pull-right mark-font" id="olbTransferBchOutCalFCXphGrand">0.00</label>
										<div class="clearfix"></div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div> -->
			<!-- </div> -->

		</div>
	</div>
</form>

<?php if(!$bIsApvOrCancel) { ?>
	<!-- Begin Approve Doc -->
	<div class="modal fade xCNModalApprove" id="odvTransferBchOutPopupApv">
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
					<button onclick="JSvTransferBchOutApprove(true)" type="button" class="btn xCNBTNPrimery">
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
<?php } ?>

<!-- Begin Cancel Doc -->
<div class="modal fade" id="odvTransferBchOutPopupCancel">
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
				<button id="obtTBOShwBtnCancel" onclick="JSvTransferBchOutCancel(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button id="obtTBOShwBtnCancelOnApv" onclick="JSxTBOCancelOnApv(true)" type="button" class="btn xCNBTNPrimery">
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


<!-- Begin Pdt Column Control Panel -->
<div class="modal fade" id="odvTransferBchOutPdtColumnControlPanel" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tModalAdvTable'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="odvTransferBchOutPdtColummControlDetail">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
				<button type="button" class="btn xCNBTNPrimery" onclick="JSxTransferBchOutUpdatePdtColumn()"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
			</div>
		</div>
	</div>
</div>
<!-- End Add Cash Panel -->

<!-- =========================================== อ้างอิงเอกสารภายใน ======================================= -->
<div id="odvTransferBchOutBchModalRefIntDoc" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document" style="width: 1200px;">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/transfer_branch_out/transfer_branch_out','อ้างอิงเอกสารภายใน')?></label>
            </div>
            <div class="modal-body">
                <div class="row" id="odvTransferBchOutBchFromRefIntDoc"></div>
            </div>
            <div class="modal-footer">
                <button id="obtConfirmRefDocInt" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>


<!-- ===========================================  อ้างอิงเอกสารภายใน (ภายใน หรือ ภายนอก) =========================================== -->
<div id="odvTBOModalAddDocRef" class="modal fade" tabindex="1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form id="ofmTBOFormAddDocRef" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'อ้างอิงเอกสาร') ?></label>
                </div>
                <div class="modal-body">
                    <input type="text" class="form-control xCNHide" id="oetTBORefDocNoOld" name="oetTBORefDocNoOld">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ประเภทการอ้างอิงเอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbTBORefType" name="ocbTBORefType">
                                    <option value="1" selected><?php echo language('common/main/main', 'อ้างอิงภายใน'); ?></option>
                                    <option value="3"><?php echo language('common/main/main', 'อ้างอิงภายนอก'); ?></option>
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เอกสาร'); ?></label>
                                <select class="selectpicker form-control" id="ocbTBORefDoc" name="ocbTBORefDoc">
                                    <option value="1" selected><?php echo language('common/main/main', 'ใบขอโอน - สาขา'); ?></option>
                                    <!-- <option value="2"><?php echo language('common/main/main', 'ใบสั่งงาน'); ?></option> -->
                                </select>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefInt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" id="oetTBODocRefInt" name="oetTBODocRefInt" maxlength="20" value="">
                                    <input type="text" class="form-control xWPointerEventNone" id="oetTBODocRefIntName" name="oetTBODocRefIntName" maxlength="20" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง') ?>" value="" readonly>
                                    <span class="input-group-btn">
                                        <button id="obtTBOBrowseRefDoc" type="button" class="btn xCNBtnBrowseAddOn">
                                            <img src="<?php echo  base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                        </button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetTBORefDocNo" name="oetTBORefDocNo" placeholder="<?php echo language('common/main/main', 'เลขที่เอกสารอ้างอิง'); ?>" maxlength="20" autocomplete="off">
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('document/document/document', 'วันที่เอกสารอ้างอิง'); ?></label>
                                <div class="input-group">
                                    <input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetTBORefDocDate" name="oetTBORefDocDate" placeholder="YYYY-MM-DD" autocomplete="off">
                                    <span class="input-group-btn">
                                        <button id="obtTBORefDocDate" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class="col-xs-12 col-sm-12 col-md-12 col-xs-12 xWShowRefExt">
                            <div class="form-group">
                                <label class="xCNLabelFrm"><?php echo language('common/main/main', 'ค่าอ้างอิง'); ?></label>
                                <input type="text" class="form-control" id="oetTBORefKey" name="oetTBORefKey" placeholder="<?php echo language('common/main/main', 'ค่าอ้างอิง'); ?>" maxlength="10" autocomplete="off">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button id="obtTBOConfirmAddDocRef" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="submit"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- =========================================== สร้างใบจัดสินค้า ======================================= -->
<div id="odvTBOGenDocPacking" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/transfer_branch_out/transfer_branch_out','tTBOGenDocPackTitle')?></label>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
						<b>ยืนยันสร้างใบจัดสินค้า</b>
					</div>
				</div>
            </div>
            <div class="modal-footer">
				<button id="obtTBOConfigGenDocPacking" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'กำหนดค่า')?></button>
                <button id="obtTBOConfirmGenDocPacking" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<div id="odvTBOConfigGenDocPacking" class="modal fade" tabindex="2" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?=language('document/transfer_branch_out/transfer_branch_out','tTBODocPackCondition')?></label>
            </div>
            <div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWTBOSysSeq0" name="ocbTBOCondtionGenPacking" value="0">สร้างใบจัดตามที่เก็บ
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWTBOSysSeq1" name="ocbTBOCondtionGenPacking" value="1">สร้างใบจัดตามหมวดสินค้า 1
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWTBOSysSeq2" name="ocbTBOCondtionGenPacking" value="2">สร้างใบจัดตามหมวดสินค้า 2
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWTBOSysSeq3" name="ocbTBOCondtionGenPacking" value="3">สร้างใบจัดตามหมวดสินค้า 3
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWTBOSysSeq4" name="ocbTBOCondtionGenPacking" value="4">สร้างใบจัดตามหมวดสินค้า 4
							</label>
						</div>
						<div class="checkbox">
							<label>
								<input type="checkbox" class="xWTBOSysSeq5" name="ocbTBOCondtionGenPacking" value="5">สร้างใบจัดตามหมวดสินค้า 5
							</label>
						</div>



						<!-- <div class="checkbox disabled">
							<label>
								<input type="checkbox" value="" disabled>
								Option two is disabled
							</label>
						</div> -->
					</div>
				</div>
            </div>
            <div class="modal-footer">
                <button id="obtTBOConfirmConfigGenDocPacking" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button id="obtTBOCancelConfigGenDocPacking" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!-- =========================================== สร้างใบจัดสินค้า ======================================= -->


<?php include('script/jTransferBchOutPageadd.php') ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
	// $('#obtTransferBchOutRefInt').on('click',function(){
    //     JSxCallPageTransferBchOutRefIntDoc();
    // });

	//Ref เอกสาร
	function JSxCallPageTransferBchOutRefIntDoc(){
        var tBCHCode = $('#oetTransferBchOutBchCode').val()
        var tBCHName = $('#oetTransferBchOutBchName').val()



        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTransferBchOutRefIntDoc",
            data: {
                'tBCHCode'      : tBCHCode,
                'tBCHName'      : tBCHName,
            },
            cache: false,
            Timeout: 0,
            success: function (oResult){
                JCNxCloseLoading();
                $('#odvTransferBchOutBchModalRefIntDoc #odvTransferBchOutBchFromRefIntDoc').html(oResult);

				// $('#odvTBOModalAddDocRef').modal('hide');
				setTimeout(function(){
					$('#odvTransferBchOutBchModalRefIntDoc').modal({backdrop : 'static' , show : true});
				}, 500);

            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

	//กดยืนยัน Ref เอกสารใบรับของ
	$('#obtConfirmRefDocInt').click(function(){
		var tRefIntDocNo    =  $('.xDocuemntRefInt.active').data('docno');
		var tRefIntDocDate  =  $('.xDocuemntRefInt.active').data('docdate');
		// var tRefIntBchCode  =  $('.xDocuemntRefInt.active').data('bchcode');
		// var aSeqNo 			=  $('.ocbRefIntDocDT:checked').map(function(elm){ return $(this).val(); }).get();

		//ถ้าไม่เลือกเอกสารอ้างอิงมา
		if( tRefIntDocNo != undefined ){

			// var tSplStaVATInOrEx =  $('.xDocuemntRefInt.active').data('vatinroex');
			// var cSplCrLimit      =  $('.xDocuemntRefInt.active').data('crtrem');
			// var nSplCrTerm       =  $('.xDocuemntRefInt.active').data('crlimit');
			// var tSplCode         =  $('.xDocuemntRefInt.active').data('splcode');
			// var tSplName         =  $('.xDocuemntRefInt.active').data('splname');
			// var tSPlPaidType     =  $('.xDocuemntRefInt.active').data('dstpain');
			// var tVatcode         =  $('.xDocuemntRefInt.active').data('vatcode');
			// var nVatrate         =  $('.xDocuemntRefInt.active').data('vatrate');

			// var poParams = {
			// 	FTSplCode           : tSplCode,
			// 	FTSplName           : tSplName,
			// 	FTSplStaVATInOrEx   : tSplStaVATInOrEx,
			// 	FTRefIntDocNo       : tRefIntDocNo,
			// 	FTRefIntDocDate     : tRefIntDocDate,
			// 	FNXphCrTerm         : nSplCrTerm
			// };

			//อ้างอิงเอกสารภายใน
			$('#oetTBODocRefInt').val(tRefIntDocNo);
			$('#oetTBODocRefIntName').val(tRefIntDocNo);

			//วันที่อ้างอิงเอกสารใน
			$('#oetTBORefDocDate').val(tRefIntDocDate).datepicker("refresh");

			// JCNxOpenLoading();
			// $.ajax({
			// 	type    : "POST",
			// 	url     : "docTransferBchOutRefIntDocInsertDTToTemp",
			// 	data    : {
			// 		'tTransferBchOutDocNo'          : $('#oetTransferBchOutDocNo').val(),
			// 		'tTransferBchOutFrmBchCode'     : $('#oetTransferBchOutBchCode').val(),
			// 		'tRefIntDocNo'      			: tRefIntDocNo,
			// 		'tRefIntBchCode'    			: tRefIntBchCode,
			// 		'tSplStaVATInOrEx'  			: tSplStaVATInOrEx,
			// 		'aSeqNo'            			: aSeqNo
			// 	},
			// 	cache: false,
			// 	Timeout: 0,
			// 	success: function (oResult){
			// 		//โหลดสินค้าใน Temp
			// 		JSxTransferBchOutGetPdtInTmp();
			// 		JCNxCloseLoading();
			// 	},
			// 	error: function (jqXHR, textStatus, errorThrown) {
			// 		JCNxResponseError(jqXHR, textStatus, errorThrown);
			// 	}
			// });

		}else{
			//อ้างอิงเอกสารภายใน
			$('#oetTBODocRefInt').val('');
			$('#oetTBODocRefIntName').val('');

			//วันที่อ้างอิงเอกสารใน
			$('#oetTBORefDocDate').val('').datepicker("refresh");
		}

		// setTimeout(function(){
		// 	$('#odvTBOModalAddDocRef').modal('show');
		// }, 500);

	});

</script>
