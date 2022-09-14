<?php
if ($aResult['rtCode'] == "1") { // Edit
	$tXthDocNo 				= $aResult['raItems']['FTXthDocNo'];
	$dXthDocDate 			= $aResult['raItems']['FDXthDocDate'];
	$tXthDocTime 			= $aResult['raItems']['FTXthDocTime'];
	$tCreateBy 				= $aResult['raItems']['FTCreateBy'];
	$tXthStaDoc 			= $aResult['raItems']['FTXthStaDoc'];
	$tXthStaApv 			= $aResult['raItems']['FTXthStaApv'];
	$tXthApvCode 			= $aResult['raItems']['FTXthApvCode'];
	$tXthStaPrcStk 			= $aResult['raItems']['FTXthStaPrcStk'];
	$tXthStaDelMQ 			= $aResult['raItems']['FTXthStaDelMQ'];
	$tCompCode              = $tCompCode;
	$tBchCode 				= $aResult['raItems']['FTBchCode'];
	$tBchName 				= $aResult['raItems']['FTBchName'];
	$tMchCode				= $aResult['raItems']['FTXthMerCode'];
	$tMchName 				= $aResult['raItems']['FTMerName'];
	$tShpCodeStart 			= $aResult['raItems']['FTXthShopFrm'];
	$tShpNameStart 			= $aResult['raItems']['FTShpNameFrm'];
	$tShpTypeStart 			= $aResult['raItems']['FTShpTypeFrm'];
	$tShpCodeEnd 			= $aResult['raItems']['FTXthShopTo'];
	$tShpNameEnd			= $aResult['raItems']['FTShpNameTo'];
	$tShpTypeEnd 			= $aResult['raItems']['FTShpTypeTo'];
	$tPosCodeStart 			= $aResult['raItems']['FTXthPosFrm'];
	$tPosNameStart 			= $aResult['raItems']['FTPosComNameF'];
	$tPosCodeEnd 			= $aResult['raItems']['FTXthPosTo'];
	$tPosNameEnd			= $aResult['raItems']['FTPosComNameT'];
	$tXthRefExt 			= $aResult['raItems']['FTXthRefExt'];
	$dXthRefExtDate 	    = $aResult['raItems']['FDXthRefExtDate'];
	$tXthRefInt 			= $aResult['raItems']['FTXthRefInt'];
	$dXthTnfDate			= $aDataHDRef['raItems']['FDXthTnfDate'];
	$tXthRefTnfID			= $aDataHDRef['raItems']['FTXthRefTnfID'];
	$tViaCode				= $aDataHDRef['raItems']['FTViaCode'];
	$tViaName				= $aDataHDRef['raItems']['FTViaName'];
	$tXthRefVehID 		    = $aDataHDRef['raItems']['FTXthRefVehID'];
	$tXthQtyAndTypeUnit	    = $aDataHDRef['raItems']['FTXthQtyAndTypeUnit'];
	$tXthShipAdd			= $aDataHDRef['raItems']['FNXthShipAdd'];
	$nXthStaDocAct 		    = $aResult['raItems']['FNXthStaDocAct'];
	$tXthStaRef				= $aResult['raItems']['FNXthStaRef'];
	$nXthDocPrint 		    = $aResult['raItems']['FNXthDocPrint'];
	$tXthRmk 				= $aResult['raItems']['FTXthRmk'];
	$tDptCode 				= $aResult['raItems']['FTDptCode'];
	$tDptName 				= $aResult['raItems']['FTDptName'];
	$tUsrCode 				= $aResult['raItems']['FTUsrCode'];
	$tUsrNameCreateBy	    = $aResult['raItems']['FTUsrName'];
	$tXthUsrNameApv 	    = $aResult['raItems']['FTUsrNameApv'];
	$dXthRefIntDate 	    = $aResult['raItems']['FDXthRefIntDate'];
	$cXthVat                = "";
	$cXthVatable            = "";
	$tXthVATInOrEx          = "";
	$tXthCtrName            = "";
	$tFNAddSeqNo            = $aDataHDRef["raItems"]["FNAddSeqNo"];
	$tFTAddV1No             = $aDataHDRef["raItems"]["FTAddV1No"];
	$tFTAddV1Soi            = $aDataHDRef["raItems"]["FTAddV1Soi"];
	$tFTAddV1Village        = $aDataHDRef["raItems"]["FTAddV1Village"];
	$tFTAddV1Road           = $aDataHDRef["raItems"]["FTAddV1Road"];
	$tFTSudName             = $aDataHDRef["raItems"]["FTSudName"];
	$tFTDstName             = $aDataHDRef["raItems"]["FTDstName"];
	$tFTPvnName             = $aDataHDRef["raItems"]["FTPvnName"];
	$tFTAddV1PostCode       = $aDataHDRef["raItems"]["FTAddV1PostCode"];
	$tRoute         	    = "TopupVendingEventEdit";

	if (isset($aAlwEvent)) {
		if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) {
			$nAutStaEdit = 1;
		} else {
			$nAutStaEdit = 0;
		}
	} else {
		$nAutStaEdit = 0;
	}

	$tUserBchCode           = $tBchCode;
	$tUserBchName           = $tBchName;
	$tUserMchCode           = $tMchCode;
	$tUserMchName           = $tMchName;
	$tUserShpCode           = $tShpCodeStart;
	$tUserShpName           = $tShpNameStart;
	$tWahCodeFrom 			= $tWahCodeInDT;
	$tWahNameFrom 			= $tWahNameInDT;

	$tStaDisabled			= "xCNHide";

} else { // New
	$tXthDocNo 				= "";
	$dXthDocDate 			= date('Y-m-d');
	$tXthDocTime 			= date('H:i');
	$tCreateBy 				= $this->session->userdata('tSesUsrUsername');
	$tXthStaDoc 			= "";
	$tXthStaApv 			= "";
	$tXthApvCode 			= "";
	$tXthStaPrcStk 		    = "";
	$tXthStaDelMQ 		    = "";
	$tCompCode              = "";
	$tUserShpType			= "";
	$tPosCodeStart 			= "";
	$tPosNameStart 			= "";
	$tPosCodeEnd 			= "";
	$tPosNameEnd			= "";
	$tBchName 				= "";
	$tMchCode				= "";
	$tMchName 				= "";
	$tShpCodeStart 			= "";
	$tShpNameStart 			= "";
	$tShpCodeEnd 			= "";
	$tShpNameEnd		    = "";
	$tXthRefExt 			= "";
	$dXthRefExtDate 	    = "";
	$tXthRefInt 			= "";
	$tXthCtrName		 	= "";
	$dXthTnfDate			= "";
	$tXthRefTnfID			= "";
	$tViaCode				= "";
	$tViaName				= "";
	$tXthRefVehID 		    = "";
	$tXthQtyAndTypeUnit	    = "";
	$tXthShipAdd			= "";
	$nXthStaDocAct 		    = "1";
	$tXthStaRef		   	    = "";
	$nXthDocPrint 		    = "0";
	$tXthRmk 				= "";
	$tXthVATInOrEx 		    = "";
	$tDptCode 				= $tDptCode;
	$tDptName 				= $this->session->userdata("tSesUsrDptName");
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy	    = $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 	    = "";
	$dXthRefIntDate 	    = "";
	$tVatCode 				= $tVatCode;
	$cXthVat 				= "";
	$cXthVatable 			= "";
	$tFNAddSeqNo            = "";
	$tFTAddV1No             = "";
	$tFTAddV1Soi            = "";
	$tFTAddV1Village        = "";
	$tFTAddV1Road           = "";
	$tFTSudName             = "";
	$tFTDstName             = "";
	$tFTPvnName             = "";
	$tFTAddV1PostCode       = "";
	$tRoute         	    = "TopupVendingEventAdd";
	$nAutStaEdit            = 0;

	$tUsrLevel 				= $this->session->userdata('tSesUsrLevel');
	if($tUsrLevel == 'SHP'){
		$tUserMchCode 			= $this->session->userdata('tSesUsrMerCode');
		$tUserMchName 			= $this->session->userdata('tSesUsrMerName');
	}else{
		$tUserMchCode 			= "";
		$tUserMchName 			= "";
	}

	if($tUsrLevel == 'SHP'){
		$tUserShpCode 			= $this->session->userdata('tSesUsrShpCodeDefault');
		$tUserShpName 			= $this->session->userdata('tSesUsrShpNameDefault');
	}else{
		$tUserShpCode 			= "";
		$tUserShpName 			= "";
	}

	$tWahCodeFrom 			= "";
	$tWahNameFrom 			= "";

	$tUserBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
	$tUserBchName = $this->session->userdata('tSesUsrBchNameDefault');

	$tStaDisabled			= "";

}

$nLangEdit = $this->session->userdata("tLangEdit");
$tUsrApv = $this->session->userdata("tSesUsername");
$tUserLoginLevel = $this->session->userdata("tSesUsrLevel");
$bIsAddPage = empty($tXthDocNo) ? true : false;
$bIsApv = empty($tXthStaApv) ? false : true;
$bIsCanCel = ($tXthStaDoc == "3") ? true : false;
$bIsApvOrCanCel = ($bIsApv || $bIsCanCel);
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmTopUpVendingForm">
	<input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?php echo base_url(); ?>">
	<input type="hidden" id="ohdTFWAutStaEdit" name="ohdTFWAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
	<input type="hidden" id="ohdXthStaApv" name="ohdXthStaApv" value="<?php echo $tXthStaApv; ?>">
	<input type="hidden" class="" id="ohdXthStaDoc" name="ohdXthStaDoc" value="<?php echo $tXthStaDoc; ?>">
	<input type="hidden" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" value="<?php echo $tXthStaPrcStk; ?>">
	<input type="hidden" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" value="<?php echo $tXthStaDelMQ; ?>">
	<input type="hidden" id="ohdTFWRoute" name="ohdTFWRoute" value="<?php echo $tRoute; ?>">
	<input type="text" class="xCNHide" id="ohdSesUsrBchCode" name="ohdSesUsrBchCode" value="<?php echo $this->session->userdata("tSesUsrBchCode"); ?>">
	<input type="text" class="xCNHide" id="ohdCompCode" name="ohdCompCode" value="<?php echo $tCompCode; ?>">
	<input type="text" class="xCNHide" id="ohdBchCode" name="ohdBchCode" value="<?php echo $tBchCode; ?>">
	<input type="text" class="xCNHide" id="ohdOptAlwSavQty0" name="ohdOptAlwSavQty0" value="<?php echo $nOptDocSave ?>">
	<input type="text" class="xCNHide" id="ohdOptScanSku" name="ohdOptScanSku" value="<?php echo $nOptScanSku ?>">
	<input type="text" class="xCNHide" id="ohdTopUpVendingDptCode" name="ohdTopUpVendingDptCode" maxlength="5" value="<?php echo $tDptCode; ?>">
	<input type="text" class="xCNHide" d="oetTopUpVendingUsrCode" name="oetTopUpVendingUsrCode" maxlength="20" value="<?php echo $tUsrCode ?>">
	<input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<input type="text" class="xCNHide" id="ohdStatusLoadPdtToTem" name="ohdStatusLoadPdtToTem" value="0">
	<input type="text" class="xCNHide" id="ohdCheckSetDataDTFromTmp" name="ohdCheckSetDataDTFromTmp" value="1">
	<button style="display:none" type="submit" id="obtSubmitTopUpVending" onclick="JSxTopUpVendingValidateForm();"></button>

	<div class="row">

		<!--Panel เงื่อนไข-->
		<div class="col-md-3">
			<!--Section : เงื่อนไข-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?= language('document/topupVending/topupVending', 'tStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?= language('document/topupVending/topupVending', 'tApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton">
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/topupVending/topupVending', 'tDocNo'); ?></label>
						<?php if ($bIsAddPage) { ?>
							<div class="form-group" id="odvPunAutoGenCode">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbTopUpVendingAutoGenCode" name="ocbTopUpVendingAutoGenCode" checked="true" value="1">
										<span><?= language('document/topupVending/topupVending', 'tAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="odvPunCodeForm">
								<input
								type="text"
								class="form-control xCNInputWithoutSpcNotThai"
								maxlength="20"
								id="oetTopUpVendingDocNo"
								name="oetTopUpVendingDocNo"
								data-is-created="<?php  ?>"
								placeholder="<?= language('document/topupVending/topupVending', 'tDocNo') ?>"
								value="<?php  ?>" data-validate-required="<?= language('document/topupVending/topupVending', 'tDocNoRequired') ?>"
								data-validate-dublicateCode="<?= language('document/topupVending/topupVending', 'tDocNoDuplicate') ?>"
								disabled readonly>
								<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW">
							</div>
						<?php } else { ?>
							<div class="form-group" id="odvPunCodeForm">
								<div class="validate-input">
									<input type="text" class="form-control xCNInputWithoutSpcNotThai" maxlength="20" id="oetTopUpVendingDocNo" name="oetTopUpVendingDocNo" data-is-created="<?php  ?>" placeholder="<?= language('document/topupVending/topupVending', 'tTFWDocNo') ?>" value="<?php echo $tXthDocNo; ?>" readonly onfocus="this.blur()">
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/topupVending/topupVending', 'tDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTopUpVendingDocDate" name="oetTopUpVendingDocDate" value="<?= $dXthDocDate; ?>" data-validate-required="<?= language('document/topupVending/topupVending', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/topupVending/topupVending', 'tDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetTopUpVendingDocTime" name="oetTopUpVendingDocTime" value="<?= $tXthDocTime; ?>" data-validate-required="<?= language('document/topupVending/topupVending', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateBy ?>">
								<label><?= $tUsrNameCreateBy ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/topupVending/topupVending', 'tStaDoc' . $tXthStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/topupVending/topupVending', 'tStaApv' . $tXthStaApv); ?></label>
							</div>
						</div>
						<?php if ($tXthDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?= $tXthApvCode ?>">
									<label><?= $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/topupVending/topupVending', 'tStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!--Section : เงื่อนไขการเติม-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/topupVending/topupVending', 'tCondition'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvCondition" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>

				<div id="odvCondition" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<!--สาขา-->
						<script>
							var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
							if( tUsrLevel != "HQ" ){
								//BCH - SHP
								var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
								if(tBchCount < 2){
									$('#obtBrowseTopUpVendingBCH').attr('disabled',true);
								}
							}


						</script>

						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tBCH'); ?></label>
							<div class="input-group">
								<input name="oetTopUpVendingBCHName" id="oetTopUpVendingBCHName" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="" placeholder="<?= language('document/topupvending/topupvending', 'tBCH') ?>" data-validate-required="<?= language('document/topupvending/topupvending', 'tTopUpVendingBCHValidate') ?>">
								<input name="oetTopUpVendingBCHCode" id="oetTopUpVendingBCHCode" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTopUpVendingBCH" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--กลุ่มธุรกิจ-->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWShopGrp'); ?></label>
							<div class="input-group">
								<input name="oetTopUpVendingMchName" id="oetTopUpVendingMchName" class="form-control" value="<?php echo $tUserMchName; ?>" type="text" readonly placeholder="<?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWShopGrp') ?>" data-validate-required="<?= language('document/topupvending/topupvending', 'tTopUpVendingMerValidate') ?>">
								<input name="oetTopUpVendingMchCode" id="oetTopUpVendingMchCode" value="<?php echo $tUserMchCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTopUpVendingMER" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--ร้านค้า-->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/topupVending/topupVending', 'tShopVD'); ?></label>
							<div class="input-group">
								<input 
									name="oetTopUpVendingShpName"
									id="oetTopUpVendingShpName"
									class="form-control"
									value="<?php echo $tUserShpName; ?>"
									type="text" 
									readonly="" 
									placeholder="<?= language('document/topupVending/topupVending', 'tShopVD') ?>" 
									data-validate-required="<?= language('document/topupvending/topupvending', 'tTopUpVendingShpValidate') ?>">
								<input name="oetTopUpVendingShpCode" id="oetTopUpVendingShpCode" value="<?php echo $tUserShpCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTopUpVendingShp" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--ตู้สินค้า-->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/topupvending/topupvending', 'tCabinet'); ?> - เติมไปยังตู้</label>
							<div class="input-group">
								<input
								name="oetTopUpVendingPosName"
								id="oetTopUpVendingPosName"
								class="form-control"
								value="<?php echo $tPosNameEnd; ?>"
								type="text"
								readonly
								placeholder="<?= language('document/topupvending/topupvending', 'tCabinet') ?>"
								data-validate-required="<?= language('document/topupvending/topupvending', 'tCabinetValidate') ?>">
								<input name="oetTopUpVendingPosCode" id="oetTopUpVendingPosCode" value="<?php echo $tPosCodeEnd; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTopUpVendingPos" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div> <hr></div>

						<!--คลังสินค้า-->
						<div class="form-group">
							<label class="xCNLabelFrm">เลือกสินค้าจากคลัง</label>
							<div class="input-group">
								<input
								name="oetTopUpVendingWahName"
								id="oetTopUpVendingWahName"
								class="form-control"
								value="<?php echo $tWahNameFrom; ?>"
								type="text"
								readonly
								placeholder="<?= language('document/topupvending/topupvending', 'tWah') ?>"
								data-validate-required="<?= language('document/topupvending/topupvending', 'tWahValidate') ?>">
								<input name="oetTopUpVendingWahCode" id="oetTopUpVendingWahCode" value="<?php echo $tWahCodeFrom; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTopUpVendingWah" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<div class="row xCNMarginTop30px">
							<div class="col-md-6 pull-right">
								<button
								type="button"
								disabled="disabled"
								id="obtTopUpVendingControlForm"
								class="btn btn-primary xCNApvOrCanCelDisabled"
								style="width:100%;font-size: 17px;">
									<?php echo language('document/topupVending/topupVending', 'ตรวจสอบ'); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Section : ข้อมูลอ้างอิง-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/topupVending/topupVending', 'tReference'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataGeneralInfo" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataGeneralInfo" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- เลขที่อ้างอิงเอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tRefExt'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									id="oetTopUpVendingXthRefExt"
									name="oetTopUpVendingXthRefExt"
									maxlength="20"
									value="<?php echo $tXthRefExt ?>">
								</div>
							</div>
						</div>
						<!-- วันที่เอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tRefExtDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetTopUpVendingXthRefExtDate"
										name="oetTopUpVendingXthRefExtDate"
										value="<?php echo $dXthRefExtDate ?>">
										<span class="input-group-btn">
											<button id="obtXthRefExtDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
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
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tRefInt'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									id="oetTopUpVendingXthRefInt"
									name="oetTopUpVendingXthRefInt"
									maxlength="20"
									value="<?php echo $tXthRefInt ?>">
								</div>
							</div>
						</div>
						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tRefIntDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetTopUpVendingXthRefIntDate"
										name="oetTopUpVendingXthRefIntDate"
										value="<?php echo $dXthRefIntDate ?>">
										<span class="input-group-btn">
											<button id="obtXthRefIntDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
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

			<!--Section : การขนส่ง-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadDateTime" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/topupVending/topupVending', 'tDelivery'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDelivery" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDelivery" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tCtrName'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTopUpVendingXthCtrName"
									name="oetTopUpVendingXthCtrName"
									value="<?php echo $tXthCtrName ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tTnfDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetTopUpVendingXthTnfDate"
										name="oetTopUpVendingXthTnfDate"
										value="<?php echo $dXthTnfDate ?>">
										<span class="input-group-btn">
											<button id="obtXthTnfDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tRefTnfID'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTopUpVendingXthRefTnfID"
									name="oetTopUpVendingXthRefTnfID"
									value="<?php echo $tXthRefTnfID ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tViaCode'); ?></label>
									<div class="input-group">
										<input class="form-control xWPointerEventNone" type="text" id="oetTopUpVendingViaName" name="oetTopUpVendingViaName" value="<?php echo $tViaName ?>" readonly>
										<input
										type="text"
										class="input100 xCNHide xCNApvOrCanCelDisabled"
										id="oetTopUpVendingViaCode"
										name="oetTopUpVendingViaCode"
										value="<?php echo $tViaCode ?>">
										<span class="input-group-btn">
											<button id="obtSearchShipVia" type="button" class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tRefVehID'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTopUpVendingXthRefVehID"
									name="oetTopUpVendingXthRefVehID"
									value="<?php echo $tXthRefVehID ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tQtyAndTypeUnit'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTopUpVendingXthQtyAndTypeUnit"
									name="oetTopUpVendingXthQtyAndTypeUnit"
									value="<?php echo $tXthQtyAndTypeUnit ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input tyle="text" class="xCNHide xCNApvOrCanCelDisabled" id="ohdTopUpVendingXthShipAdd" name="ohdTopUpVendingXthShipAdd" value="<?php echo $tXthShipAdd ?>">
								<button
								type="button"
								id="obtTFWBrowseShipAdd"
								class="btn btn-primary xCNApvOrCanCelDisabled"
								style="font-size: 17px;">
									<?php echo language('document/topupVending/topupVending', 'tShipAddress'); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Section : อื่นๆ-->
			<div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/topupVending/topupVending', 'tOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tNote'); ?></label>
							<textarea class="form-control xCNApvOrCanCelDisabled" id="otaTopUpVendingRmk" name="otaTopUpVendingRmk"><?php echo $tXthRmk; ?></textarea>
						</div>
						<div class="form-group">
							<label class="fancy-checkbox">
								<input
								type="checkbox"
								class="xCNApvOrCanCelDisabled"
								value="1"
								id="ocbTopUpVendingXthStaDocAct"
								name="ocbTopUpVendingXthStaDocAct"
								maxlength="1" <?php echo $nXthStaDocAct == '1' ? 'checked' : ''; ?>>
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tTFWStaDocAct'); ?></span>
							</label>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tStaRef'); ?></label>
							<input type="text" class="xCNHide xCNApvOrCanCelDisabled" id="ohdXthStaRef" name="ohdXthStaRef" value="<?php echo $tXthStaRef ?>">
							<select class="selectpicker form-control xCNApvOrCanCelDisabled" id="ostTopUpVendingXthStaRef" name="ostTopUpVendingXthStaRef" maxlength="1">
								<option value="0"><?php echo language('document/topupVending/topupVending', 'tStaRef0'); ?></option>
								<option value="1"><?php echo language('document/topupVending/topupVending', 'tStaRef1'); ?></option>
								<option value="2"><?php echo language('document/topupVending/topupVending', 'tStaRef2'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/topupVending/topupVending', 'tDocPrint'); ?></label>
							<input
							readonly
							type="text"
							class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
							maxlength="100" id="oetTopUpVendingXthDocPrint"
							name="oetTopUpVendingXthDocPrint"
							maxlength="1"
							value="<?= $nXthDocPrint ?>">
						</div>

					</div>
				</div>
			</div>
		</div>

		<!--Panel ตารางฝั่งขวา-->
		<div class="col-md-9" id="odvRightPanal">
			<div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;">
				<div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
					<div class="panel-heading xCNPDModlue">
						<div class="row">
							<div class="col-md-4">
								<div class="form-group">
									<div class="input-group">
										<input
										class="form-control xCNInputWithoutSingleQuote"
										type="text" id="oetTopUpVendingPdtLayoutSearchAll"
										name="oetTopUpVendingPdtLayoutSearchAll"
										placeholder="<?= language('document/topupVending/topupVending', 'tFillTextSearch') ?>"
										onkeyup="Javascript:if(event.keyCode==13) JSxTopUpVendingGetPdtLayoutDataTableInTmp()"
										autocomplete="off">
										<span class="input-group-btn">
											<button type="button" class="btn xCNBtnDateTime" onclick="JSxTopUpVendingGetPdtLayoutDataTableInTmp()">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/search-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-row">
									<div class="form-group col-md-5">
										<select class="selectpicker form-control <?=$tStaDisabled;?>" id="ocmTUVStaShwPdt" name="ocmTUVStaShwPdt" maxlength="1">
											<option value="1" selected><?php echo language('document/topupVending/topupVending', 'แสดงสินค้าทั้งหมด'); ?></option>
											<option value="0"><?php echo language('document/topupVending/topupVending', 'เฉพาะสินค้าที่ต้องเติม'); ?></option>
										</select>
									</div>
									<div class="form-group col-md-7" style="margin-top: 6px;margin-bottom: 0px;">
										<input class="form-check-input <?=$tStaDisabled;?>" type="checkbox" id="ocbTUVStaShwPdtInStk" name="ocbTUVStaShwPdtInStk" value="1" checked>
										<label class="form-check-label <?=$tStaDisabled;?>" for="ocbTUVStaShwPdtInStk">แสดงเฉพาะสินค้าที่มีในสต็อก</label>
									</div>
								</div>
							</div>

							<!-- ตัวเลือกข้อมูล Delete Multi -->
							<!-- Create By WItsarut 2/09/2020 -->
							<div class="col-xs-2 col-sm-2 col-md-2 col-lg-2 text-right">
								<div id="odvTUVMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
									<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
										<?= language('common/main/main', 'tCMNOption') ?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li id="oliTUVBtnDeleteMulti" class="disabled">
											<a data-toggle="modal" data-target="#odvTUVModalDelPdtInDTTempMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
										</li>
									</ul>
								</div>
							</div>

						</div>
						<div id="odvTopupVendingPdtDataTable" style="margin-top: 10px;"></div>
						<div id="odvPdtTablePanalDataHide"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<div class="modal fade xCNModalApprove" id="odvTopUpVendingPopupApv">
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
				<button onclick="JSvTopUpVendingApprove(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvTopUpVendingPopupCancel">
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
				<button onclick="JSvTopUpVendingCancel(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--สินค้า มีการเติมเป็น 0-->
<div class="modal fade" id="odvTOPUPVDCheckItemHaveTopUpZero">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?=language('document/adjuststockvd/adjuststockvd','เอกสารการเติมสินค้าครั้งนี้มีสินค้า ที่เติมเป็น 0 ยืนยันที่จะลบสินค้า ?'); ?>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xCNConfrimCheckItemHaveTopUpZero">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvTopUpVendingPopupClear">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?=language('document/adjuststockvd/adjuststockvd','ข้อมูลสินค้าที่สร้างจะถูกล้างค่า ยืนยันการทำรายการต่อหรอไม่ ?'); ?>
			</div>
			<div class="modal-footer">
                <button type="button" id="obtTopUpVendingConfirm" class="btn xCNBTNPrimery">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvTopUpVendingPopupFoundDataInTblDT">
	<input type="hidden" id="ohdTopUpVendingTypeClick" name="ohdTopUpVendingTypeClick">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?=language('document/adjuststockvd/adjuststockvd','มีข้อมูลรายการสินค้าเดิมในระบบ ท่านต้องการที่จะลบข้อมูลรายการสินค้า ใช่ หรือ ไม่ ?'); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"	onclick="JSxTopUpVDEvnConfirmDelDTTemp()">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>


<?php include('script/jTopupPageadd.php') ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
