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
	// $tCompCode              = $tCompCode;
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
	$tRoute         	    = "docTVOEventEdit";

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
	$tWahCodeFrom 			= $aResult['raItems']['FTWahCodeFrm'];
	$tWahNameFrom 			= $aResult['raItems']['FTWahNameFrm'];

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
	// $tCompCode              = "";
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
	$tDptCode 				= $this->session->userdata("tSesUsrDptCode");
	$tDptName 				= $this->session->userdata("tSesUsrDptName");
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy	    = $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 	    = "";
	$dXthRefIntDate 	    = "";
	// $tVatCode 				= $tVatCode;
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
	$tRoute         	    = "docTVOEventAdd";
	$nAutStaEdit            = 0;


	// if($tUsrLevel == 'SHP'){
	$tUserMchCode 			= $this->session->userdata('tSesUsrMerCode');
	$tUserMchName 			= $this->session->userdata('tSesUsrMerName');
	$tUserShpCode 			= $this->session->userdata('tSesUsrShpCodeDefault');
	$tUserShpName 			= $this->session->userdata('tSesUsrShpNameDefault');
	// }else{
	// 	$tUserMchCode 			= "";
	// 	$tUserMchName 			= "";
	// 	$tUserShpCode 			= "";
	// 	$tUserShpName 			= "";
	// }

	$tWahCodeFrom 			= "";
	$tWahNameFrom 			= "";

	$tUserBchCode 			= $this->session->userdata('tSesUsrBchCodeDefault');
	$tUserBchName 			= $this->session->userdata('tSesUsrBchNameDefault');

	$tStaDisabled			= "";

}

$nLangEdit 					= $this->session->userdata("tLangEdit");
$tUsrApv 					= $this->session->userdata("tSesUsername");
$tUsrLevel 					= $this->session->userdata('tSesUsrLevel');

$bIsAddPage 				= empty($tXthDocNo) ? true : false;
$bIsApv 					= empty($tXthStaApv) ? false : true;
$bIsCanCel 					= ($tXthStaDoc == "3") ? true : false;
$bIsApvOrCanCel 			= ($bIsApv || $bIsCanCel);
?>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmTVOForm">
	<input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?php echo base_url(); ?>">
	<input type="hidden" id="ohdTVOAutStaEdit" name="ohdTVOAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
	<input type="hidden" id="ohdXthStaApv" name="ohdXthStaApv" value="<?php echo $tXthStaApv; ?>">
	<input type="hidden" class="" id="ohdXthStaDoc" name="ohdXthStaDoc" value="<?php echo $tXthStaDoc; ?>">
	<input type="hidden" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" value="<?php echo $tXthStaPrcStk; ?>">
	<input type="hidden" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" value="<?php echo $tXthStaDelMQ; ?>">
	<input type="hidden" id="ohdTVORoute" name="ohdTVORoute" value="<?php echo $tRoute; ?>">
	<input type="text" class="xCNHide" id="ohdBchCode" name="ohdBchCode" value="<?php echo $tUserBchCode; ?>">
	<input type="text" class="xCNHide" id="ohdTVODptCode" name="ohdTVODptCode" maxlength="5" value="<?php echo $tDptCode; ?>">
	<input type="text" class="xCNHide" d="oetTVOUsrCode" name="oetTVOUsrCode" maxlength="20" value="<?php echo $tUsrCode ?>">
	<input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<input type="text" class="xCNHide" id="ohdStatusLoadPdtToTem" name="ohdStatusLoadPdtToTem" value="0">
	<input type="text" class="xCNHide" id="ohdCheckSetDataDTFromTmp" name="ohdCheckSetDataDTFromTmp" value="1">
	<button style="display:none" type="submit" id="obtSubmitTVO" onclick="JSxTVOValidateForm();"></button>

	<div class="row">

		<!--Panel เงื่อนไข-->
		<div class="col-md-3">
			<!--Section : เงื่อนไข-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?= language('document/TransferVendingOut/TransferVendingOut', 'tStatus'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?= language('document/TransferVendingOut/TransferVendingOut', 'tApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTVOSubmitByButton" name="ohdCheckTVOSubmitByButton">
						<input type="hidden" value="0" id="ohdCheckTVOClearValidate" name="ohdCheckTVOClearValidate">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/TransferVendingOut/TransferVendingOut', 'tDocNo'); ?></label>
						<?php if ($bIsAddPage) { ?>
							<div class="form-group" id="odvPunAutoGenCode">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbTVOAutoGenCode" name="ocbTVOAutoGenCode" checked="true" value="1">
										<span><?= language('document/TransferVendingOut/TransferVendingOut', 'tAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group" id="odvPunCodeForm">
								<input
								type="text"
								class="form-control xCNInputWithoutSpcNotThai"
								maxlength="20"
								id="oetTVODocNo"
								name="oetTVODocNo"
								data-is-created="<?php  ?>"
								placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tDocNo') ?>"
								value="<?php  ?>" data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tDocNoRequired') ?>"
								data-validate-dublicateCode="<?= language('document/TransferVendingOut/TransferVendingOut', 'tDocNoDuplicate') ?>"
								disabled readonly>
								<input type="hidden" value="2" id="ohdCheckDuplicateTVO" name="ohdCheckDuplicateTVO">
							</div>
						<?php } else { ?>
							<div class="form-group" id="odvPunCodeForm">
								<div class="validate-input">
									<input type="text" class="form-control xCNInputWithoutSpcNotThai xCNApvOrCanCelDisabled" maxlength="20" id="oetTVODocNo" name="oetTVODocNo" data-is-created="<?php  ?>" placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tTFWDocNo') ?>" value="<?php echo $tXthDocNo; ?>" readonly onfocus="this.blur()">
								</div>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/TransferVendingOut/TransferVendingOut', 'tDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled" id="oetTVODocDate" name="oetTVODocDate" value="<?= $dXthDocDate; ?>" data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?= language('document/TransferVendingOut/TransferVendingOut', 'tDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker xCNApvOrCanCelDisabled" id="oetTVODocTime" name="oetTVODocTime" value="<?= $tXthDocTime; ?>" data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime xCNApvOrCanCelDisabled">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?= $tCreateBy ?>">
								<label><?= $tUsrNameCreateBy ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/TransferVendingOut/TransferVendingOut', 'tStaDoc' . $tXthStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?= language('document/TransferVendingOut/TransferVendingOut', 'tStaApv' . $tXthStaApv); ?></label>
							</div>
						</div>
						<?php if ($tXthDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?= $tXthApvCode ?>">
									<label><?= $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/TransferVendingOut/TransferVendingOut', 'tStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>

			<!--Section : เงื่อนไขการเติม-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tCondition'); ?></label>
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
									$('#obtBrowseTVOBCH').attr('disabled',true);
								}
							}
						</script>

						<!--สาขา-->
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tBCH'); ?></label>
							<div class="input-group">
								<input name="oetTVOBCHName" id="oetTVOBCHName" class="form-control" value="<?=$tUserBchName?>" type="text" readonly="" placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tBCH') ?>" data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tTopUpVendingBCHValidate') ?>">
								<input name="oetTVOBCHCode" id="oetTVOBCHCode" value="<?=$tUserBchCode?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTVOBCH" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--กลุ่มธุรกิจ-->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWShopGrp'); ?></label>
							<div class="input-group">
								<input name="oetTVOMchName" id="oetTVOMchName" class="form-control" value="<?php echo $tUserMchName; ?>" type="text" readonly placeholder="<?= language('document/producttransferwahouse/producttransferwahouse', 'tTFWShopGrp') ?>" data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tTopUpVendingMerValidate') ?>">
								<input name="oetTVOMchCode" id="oetTVOMchCode" value="<?php echo $tUserMchCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTVOMER" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--ร้านค้า / รูปแบบการจัดสินค้า -->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tShopVD'); ?></label>
							<div class="input-group">
								<input 
									name="oetTVOShpName"
									id="oetTVOShpName"
									class="form-control"
									value="<?php echo $tUserShpName; ?>"
									type="text"
									readonly=""
									placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tShopVD') ?>" 
									data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tTopUpVendingShpValidate') ?>"
								>
								<input name="oetTVOShpCode" id="oetTVOShpCode" value="<?php echo $tUserShpCode; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTVOShp" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!--ตู้สินค้า-->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tCabinet'); ?></label>
							<div class="input-group">
								<input
								name="oetTVOPosName"
								id="oetTVOPosName"
								class="form-control"
								value="<?php echo $tPosNameEnd; ?>"
								type="text"
								readonly
								placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tCabinet') ?>"
								data-validate-required="<?= language('document/TransferVendingOut/TransferVendingOut', 'tCabinetValidate') ?>">
								<input name="oetTVOPosCode" id="oetTVOPosCode" value="<?php echo $tPosCodeEnd; ?>" class="form-control xCNHide" type="text">
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtBrowseTVOPos" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!-- คลังจากตู้สินค้า -->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : '' ?>">
							<label class="xCNLabelFrm"><?= language('document/TransferVendingOut/TransferVendingOut', 'tVDOConditionWahFrom'); ?></label>
							<input name="oetTVOWahCodeFrom" id="oetTVOWahCodeFrom" value="<?php echo $tWahCodeFrom; ?>" class="form-control xCNHide" type="text">
							<input name="oetTVOWahNameFrom" id="oetTVOWahNameFrom" value="<?php echo $tWahNameFrom; ?>" class="form-control xCNApvOrCanCelDisabled" type="text" placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tVDOConditionWahFrom') ?>"  disabled>
						</div>

						<div class="row xCNMarginTop30px">
							<div class="col-md-6 pull-right">
								<button type="button" id="obtTVOLoadPdtLayout" class="btn btn-primary xCNApvOrCanCelDisabled" style="width:100%;font-size: 17px;">ตรวจสอบ</button>
							</div>
						</div>

						<hr>

						<!-- อ้างอิงเอกสารภายใน -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefInt'); ?></label>
							<div class="input-group">
								<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									id="oetTVOXthRefInt"
									name="oetTVOXthRefInt"
									maxlength="20"
									value="<?php echo $tXthRefInt ?>"
									placeholder="<?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefInt'); ?>"
									disabled="true"
								>
								<span class="input-group-btn">
									<button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtTVOBrowseRefInt" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!-- วันที่เอกสารภายใน -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefIntDate'); ?></label>
							<input
								type="text"
								class="form-control xCNApvOrCanCelDisabled"
								id="oetTVOXthRefIntDate"
								name="oetTVOXthRefIntDate"
								value="<?php echo $dXthRefIntDate ?>"
								disabled="true"
							>
						</div>


					</div>
				</div>
			</div>

			<!--Section : ข้อมูลอ้างอิง-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tReference'); ?></label>
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
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefExt'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									id="oetTVOXthRefExt"
									name="oetTVOXthRefExt"
									maxlength="20"
									value="<?php echo $tXthRefExt ?>">
								</div>
							</div>
						</div>
						<!-- วันที่เอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefExtDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetTVOXthRefExtDate"
										name="oetTVOXthRefExtDate"
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

					</div>
				</div>
			</div>

			<!--Section : การขนส่ง-->
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadDateTime" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tDelivery'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDelivery" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDelivery" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tCtrName'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTVOXthCtrName"
									name="oetTVOXthCtrName"
									value="<?php echo $tXthCtrName ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTnfDate'); ?></label>
									<div class="input-group">
										<input
										type="text"
										class="form-control xCNDatePicker xCNInputMaskDate xCNApvOrCanCelDisabled"
										id="oetTVOXthTnfDate"
										name="oetTVOXthTnfDate"
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
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefTnfID'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTVOXthRefTnfID"
									name="oetTVOXthRefTnfID"
									value="<?php echo $tXthRefTnfID ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tViaCode'); ?></label>
									<div class="input-group">
										<input class="form-control xWPointerEventNone" type="text" id="oetTVOViaName" name="oetTVOViaName" value="<?php echo $tViaName ?>" readonly>
										<input
										type="text"
										class="input100 xCNHide xCNApvOrCanCelDisabled"
										id="oetTVOViaCode"
										name="oetTVOViaCode"
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
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefVehID'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTVOXthRefVehID"
									name="oetTVOXthRefVehID"
									value="<?php echo $tXthRefVehID ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tQtyAndTypeUnit'); ?></label>
									<input
									type="text"
									class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
									maxlength="100"
									id="oetTVOXthQtyAndTypeUnit"
									name="oetTVOXthQtyAndTypeUnit"
									value="<?php echo $tXthQtyAndTypeUnit ?>">
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-md-12">
								<input tyle="text" class="xCNHide xCNApvOrCanCelDisabled" id="ohdTVOXthShipAdd" name="ohdTVOXthShipAdd" value="<?php echo $tXthShipAdd ?>">
								<button
								type="button"
								id="obtTVOBrowseShipAdd"
								class="btn btn-primary xCNApvOrCanCelDisabled"
								style="font-size: 17px;">
									<?php echo language('document/TransferVendingOut/TransferVendingOut', 'tShipAddress'); ?>
								</button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<!--Section : อื่นๆ-->
			<div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tNote'); ?></label>
							<textarea class="form-control xCNApvOrCanCelDisabled" id="otaTVORmk" name="otaTVORmk"><?php echo $tXthRmk; ?></textarea>
						</div>
						<div class="form-group">
							<label class="fancy-checkbox">
								<input
								type="checkbox"
								class="xCNApvOrCanCelDisabled"
								value="1"
								id="ocbTVOXthStaDocAct"
								name="ocbTVOXthStaDocAct"
								maxlength="1" <?php echo $nXthStaDocAct == '1' ? 'checked' : ''; ?>>
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tTFWStaDocAct'); ?></span>
							</label>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tStaRef'); ?></label>
							<input type="text" class="xCNHide xCNApvOrCanCelDisabled" id="ohdXthStaRef" name="ohdXthStaRef" value="<?php echo $tXthStaRef ?>">
							<select class="selectpicker form-control xCNApvOrCanCelDisabled" id="ostTVOXthStaRef" name="ostTVOXthStaRef" maxlength="1">
								<option value="0"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tStaRef0'); ?></option>
								<option value="1"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tStaRef1'); ?></option>
								<option value="2"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tStaRef2'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tDocPrint'); ?></label>
							<input
							readonly
							type="text"
							class="form-control xCNInputWithoutSpc xCNApvOrCanCelDisabled"
							maxlength="100" id="oetTVOXthDocPrint"
							name="oetTVOXthDocPrint"
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
										type="text" id="oetTVOPdtLayoutSearchAll"
										name="oetTVOPdtLayoutSearchAll"
										placeholder="<?= language('document/TransferVendingOut/TransferVendingOut', 'tFillTextSearch') ?>"
										onkeyup="Javascript:if(event.keyCode==13) JSxTVOGetPdtLayoutDataTableInTmp()"
										autocomplete="off">
										<span class="input-group-btn">
											<button type="button" class="btn xCNBtnDateTime" onclick="JSxTVOGetPdtLayoutDataTableInTmp()">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/search-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-8">
								<div class="form-row">
									<div class="form-group col-md-7 text-left" style="margin-top: 6px;margin-bottom: 0px;">
										<input class="form-check-input <?=$tStaDisabled;?>" type="checkbox" id="ocbTUVStaShwPdtInStk" name="ocbTUVStaShwPdtInStk" value="1" checked>
										<label class="form-check-label <?=$tStaDisabled;?>" for="ocbTUVStaShwPdtInStk"><?=language('document/TransferVendingOut/TransferVendingOut', 'tVDOStaShwPdtInStk') ?></label>
									</div>
									<div class="form-group col-md-4 text-right">
										<div class="btn-group xCNDropDrownGroup">
                                            <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                                                <?php echo language('common/main/main','tCMNOption')?>
                                                <span class="caret"></span>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li id="oliBtnDeleteAll" class="disabled">
                                                    <a data-toggle="modal" data-target="#odvTVOModalDelPdt"><?php echo language('common/main/main','tDelAll')?></a>
                                                </li>
                                            </ul>
                                        </div>
									</div>
									<div class="form-group col-md-1 text-right">
										<div class="form-group">
											<input type="text" class="xCNHide" id="oetTVOPdtCodeMulti" name="oetTVOPdtCodeMulti" value="">
											<input type="text" class="xCNHide" id="oetTVOPdtNameMulti" name="oetTVOPdtNameMulti" value="">
											<button type="button" id="obtTVOBrowsePdt" class="xCNBTNPrimeryPlus xCNDocBrowsePdt">+</button>
                                        </div>
									</div>
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

<div class="modal fade xCNModalApprove" id="odvTVOPopupApv">
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
				<button onclick="JSvTVOApprove(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvTVOPopupCancel">
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
				<button onclick="JSvTVOCancel(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade xCNModalDelDTTemp" id="odvTVOPopupFoundDataInTblDT">
	<input type="hidden" id="ohdTVOTypeClick" name="ohdTVOTypeClick">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?=language('document/adjuststockvd/adjuststockvd','มีข้อมูลรายการสินค้าเดิมในระบบ ท่านต้องการที่จะลบข้อมูลรายการสินค้า ใช่ หรือ ไม่ ?'); ?>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery"	onclick="JSxTVOEventConfirmDelDTTempAll()">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<?php include('script/jTransferVendingOutPageAdd.php'); ?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
