<?php
if ($aResult['rtCode'] == "1") {
	$tXthDocNo 			= $aResult['raItems']['FTXthDocNo'];
	$dXthDocDate 		= $aResult['raItems']['FDXthDocDate'];
	$tCreateBy 			= $aResult['raItems']['FTCreateBy'];
	$tXthStaDoc 		= $aResult['raItems']['FTXthStaDoc'];
	$tXthStaApv 		= $aResult['raItems']['FTXthStaApv'];
	$tXthApvCode 		= $aResult['raItems']['FTXthApvCode'];
	$tXthStaPrcStk 		= $aResult['raItems']['FTXthStaPrcStk'];
	$tXthStaDelMQ 		= $aResult['raItems']['FTXthStaDelMQ'];
	$tBchCode 			= $aResult['raItems']['FTBchCode'];
	$tBchName 			= $aResult['raItems']['FTBchName'];
	$tXthRefExt 		= $aResult['raItems']['FTXthRefExt'];
	$dXthRefExtDate 	= $aResult['raItems']['FDXthRefExtDate'];
	$tXthRefInt 		= $aResult['raItems']['FTXthRefInt'];
	$tXthCtrName		= $aResult['raItems']['FTXthCtrName'];
	$dXthTnfDate		= $aResult['raItems']['FDXthTnfDate'];
	$tXthRefTnfID		= $aResult['raItems']['FTXthRefTnfID'];
	$tViaCode			= $aResult['raItems']['FTViaCode'];
	$tViaName			= $aResult['raItems']['FTViaName'];
	$tXthRefVehID 		= $aResult['raItems']['FTXthRefVehID'];
	$tXthQtyAndTypeUnit	= $aResult['raItems']['FTXthQtyAndTypeUnit'];
	$tXthShipAdd		= $aResult['raItems']['FNXthShipAdd'];
	$nXthStaDocAct 		= $aResult['raItems']['FNXthStaDocAct'];
	$tXthStaRef			= $aResult['raItems']['FNXthStaRef'];
	$nXthDocPrint 		= $aResult['raItems']['FNXthDocPrint'];
	$tXthRmk 			= $aResult['raItems']['FTXthRmk'];
	$tDptCode 			= $aResult['raItems']['FTDptCode'];
	$tDptName 			= $aResult['raItems']['FTDptName'];
	$tUsrCode 			= $aResult['raItems']['FTUsrCode'];
	$tUsrNameCreateBy	= $aResult['raItems']['FTUsrName'];
	$tXthUsrNameApv     = $aResult['raItems']['FTUsrNameApv'];
	$tXthVATInOrEx		= $aResult['raItems']['FTXthVATInOrEx'];
	$dXthRefIntDate 	= $aResult['raItems']['FDXthRefIntDate'];
	$cXthVat 			= $aResult['raItems']['FCXthVat'];
	$cXthVatable 		= $aResult['raItems']['FCXthVatable'];
	$tRsnCode 			= $aResult['raItems']['FTRsnCode'];
	$tRsnName 			= $aResult['raItems']['FTRsnName'];

	if ($tTXIDocType == 'WAH') {

		//Merchant
		$tXthMerCode 		= $aResult['raItems']['FTXthMerCode'];
		$tXthMerName 		= $aResult['raItems']['FTMerName'];
		//Merchant

		//Shop
		$tShpCodeFrm 		= $aResult['raItems']['FTXthShopFrm'];
		$tShpNameFrm 		= $aResult['raItems']['FTShpNameFrm'];
		$tShpTypeFrm 		= $aResult['raItems']['FTShpTypeFrm'];

		$tShpCodeTo 		= $aResult['raItems']['FTXthShopTo'];
		$tShpNameTo 		= $aResult['raItems']['FTShpNameTo'];
		$tShpTypeTo 		= $aResult['raItems']['FTShpTypeTo'];
		//Shop

		//Pos
		$tPosCodeFrm 		= $aResult['raItems']['FTPosCodeFrm'];
		$tPosNameFrm 		= $aResult['raItems']['FTPosNameFrm'];

		$tPosCodeTo 		= $aResult['raItems']['FTPosCodeTo'];
		$tPosNameTo 		= $aResult['raItems']['FTPosNameTo'];
		//Pos

		//Wah
		$tWahCodeFrm 		= $aResult['raItems']['FTXthWhFrm'];
		$tWahNameFrm 		= $aResult['raItems']['FTWahNameFrm'];
		$tWahCodeTo 	    = $aResult['raItems']['FTXthWhTo'];
		$tWahNameTo 	    = $aResult['raItems']['FTWahNameTo'];
		//Wah

	} else {

		//Merchant
		$tXthMerCode		= "";
		$tXthMerName		= "";
		//Merchant

		//Shop
		$tShpCodeFrm 		= "";
		$tShpNameFrm 		= "";
		$tShpTypeFrm 		= "";

		$tShpCodeTo 		= "";
		$tShpNameTo 		= "";
		$tShpTypeTo 		= "";
		//Shop

		//Pos
		$tPosCodeFrm 		= "";
		$tPosNameFrm 		= "";

		//Wah
		$tWahCodeFrm 		= "";
		$tWahNameFrm 		= "";
		$tWahCodeTo 	    = "";
		$tWahNameTo 	    = "";
		//Wah
	}

	//Event Control
	if (isset($aAlwEvent)) {
		if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1) {
			$nAutStaEdit = 1;
		} else {
			$nAutStaEdit = 0;
		}
	} else {
		$nAutStaEdit = 0;
	}
	//Event Control

	$tRoute         		= "dcmTXIEventEdit";
} else {

	$tXthDocNo 				= "";
	$dXthDocDate 			= "";
	$tCreateBy 				= $this->session->userdata('tSesUsrUsername');
	$tXthStaDoc 			= "";
	$tXthStaApv 			= "";
	$tXthApvCode 			= "";
	$tXthStaPrcStk 			= "";
	$tXthStaDelMQ 			= "";
	$tBchCode 				= $tBchCode;
	$tBchName 				= $tBchName;
	$tWahCodeFrm 			= "";
	$tWahNameFrm 			= "";
	$tWahCodeTo 			= "";
	$tWahNameTo 			= "";
	$tXthRefExt 			= "";
	$dXthRefExtDate 	    = "";
	$tXthRefInt 			= "";
	$tXthCtrName		    = "";
	$dXthTnfDate		    = "";
	$tXthRefTnfID			= "";
	$tViaCode				= "";
	$tViaName				= "";
	$tXthRefVehID 		    = "";
	$tXthQtyAndTypeUnit	    = "";
	$tXthShipAdd		    = "";
	$nXthStaDocAct 		    = "";
	$tXthStaRef		    	= "";
	$nXthDocPrint 		    = "0";
	$tXthRmk 				= "";
	$tDptCode 				= $tDptCode;
	$tDptName 				= $this->session->userdata("tSesUsrDptName");
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy       = $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 	    = "";
	$tXthVATInOrEx			= "";
	$dXthRefIntDate 	    = "";
	$tVatCode 				= $tVatCode;
	$cXthVat 				= "";
	$cXthVatable 			= "";
	$tRsnCode 				= "";
	$tRsnName 				= "";

	$tRoute         	    = "dcmTXIEventAdd";
	$nAutStaEdit 			= 0; //Event Control





	//Merchant
	$tXthMerCode		= "";
	$tXthMerName		= "";
	//Merchant

	//Shop
	$tShpCodeFrm 		= "";
	$tShpNameFrm 		= "";
	$tShpTypeFrm 		= "";

	$tShpCodeTo 		= "";
	$tShpNameTo 		= "";
	$tShpTypeTo 		= "";
	//Shop

	//Pos
	$tPosCodeFrm 		= "";
	$tPosNameFrm 		= "";

	//Wah
	$tWahCodeFrm 		= "";
	$tWahNameFrm 		= "";
	$tWahCodeTo 	    = "";
	$tWahNameTo 	    = "";
	//Wah

}

//Check User Level
$tUserLevel = "HQ";
if ($tUserLoginBchCode != "") {
	$tUserLevel = "Bch";
}

if ($tUserLoginShpCode != "") {
	$tUserLevel = "Shp";
}






?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddTXI">
	<input type="text" class="form-control xCNHide" id="ohdTXIAutStaEdit" name="ohdTXIAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
	<input type="text" class="form-control xCNHide" id="ohdXthStaApv" name="ohdXthStaApv" value="<?php echo $tXthStaApv; ?>">
	<input type="text" class="form-control xCNHide" id="ohdXthStaDoc" name="ohdXthStaDoc" value="<?php echo $tXthStaDoc; ?>">
	<input type="text" class="form-control xCNHide" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" value="<?php echo $tXthStaPrcStk; ?>">
	<input type="text" class="form-control xCNHide" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" value="<?php echo $tXthStaDelMQ; ?>">
	<button style="display:none" type="submit" id="obtSubmitTXI" onclick="JSnAddEditTXI('<?php echo $tRoute; ?>')"></button>
	<input type="text" class="form-control xCNHide" id="ohdSesUsrBchCode" value="<?php echo $this->session->userdata("tSesUsrBchCode"); ?>">
	<input type="text" class="form-control xCNHide" id="ohdBchCode" value="<?php echo $tUserLoginBchCode; ?>">
	<input type="text" class="form-control xCNHide" id="ohdOptAlwSavQty0" name="ohdOptAlwSavQty0" value="<?php echo $nOptDocSave ?>">
	<input type="text" class="form-control xCNHide" id="ohdOptScanSku" name="ohdOptScanSku" value="<?php echo $nOptScanSku ?>">
	<input type="text" class="form-control xCNHide" id="ohdDptCode" name="ohdDptCode" maxlength="5" value="<?php echo $tDptCode; ?>">
	<input type="text" class="form-control xCNHide" id="oetUsrCode" name="oetUsrCode" maxlength="20" value="<?php echo $tUsrCode ?>">
	<input type="text" class="form-control xCNHide" id="ohdTXIDocType" name="ohdTXIDocType" maxlength="20" value="<?php echo $tTXIDocType ?>">
	<input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">



	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<?php ?>
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?php echo language('document/transferreceipt/transferreceipt', 'tTWIApproved'); ?></label>
						</div>
						<?php if (@$tXthDocNo == '') { ?>
							<div class="form-group">
								<label class="fancy-checkbox">
									<input type="checkbox" class="ocbListItem" id="ocbStaAutoGenCode" name="ocbStaAutoGenCode" maxlength="1" checked="checked">
									<span>&nbsp;</span>
									<span class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIAutoGenCode'); ?></span>
								</label>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIDocNo'); ?></label>
							<input type="text" class="form-control xWTooltipsBT" id="oetXthDocNo" name="oetXthDocNo" maxlength="20" value="<?php echo $tXthDocNo; ?>" onkeyup="JStCMNCheckDuplicateCodeMaster('oetXthDocNo','JSvCallPageTXIEdit','TCNTPdtTnfHD','FTXthDocNo')" data-validate="<?php echo language('document/transferreceipt/transferreceipt', 'tTWIPlsEnterOrRunDocNo'); ?>" placeholder="##########">
							<?php
							if (@$tXthDocNo) {
								$tStaDisabled = 'disabled';
							} else {
								$tStaDisabled = '';
							}
							?>
							<!-- <span class="input-group-btn">
								<button class="btn xCNBtnGenCode" type="button" onclick="JStGenerateTWICode()" <?php echo $tStaDisabled; ?>>
									<i class="fa fa-magic"></i>
								</button>
							</span> -->
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDate" name="oetXthDocDate" value="<?php echo $dXthDocDate; ?>" data-validate="<?php echo language('document/transferreceipt/transferreceipt', 'tTWIPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWICreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?php echo $tCreateBy ?>">
								<label><?php echo $tUsrNameCreateBy ?></label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/transferreceipt/transferreceipt', 'tTWIStaDoc' . $tXthStaDoc); ?></label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/transferreceipt/transferreceipt', 'tTWIStaApv' . $tXthStaApv); ?></label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITBStaPrc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/transferreceipt/transferreceipt', 'tTWIStaPrcStk' . $tXthStaPrcStk); ?></label>
							</div>
						</div>



						<?php if ($tXthDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?php echo $tXthApvCode ?>">
									<label><?php echo $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/transferreceipt/transferreceipt', 'tTWIStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>


			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIReference'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataGeneralInfo" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataGeneralInfo" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<!-- เลขที่อ้างอิงเอกสารภายใน -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefInt'); ?></label>
							<div class="input-group">
								<input type="text" class="input100 xCNHide" id="oetXthRefInt" name="oetXthRefInt" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tXthRefInt  : "" ?>" value="<?php echo $tXthRefInt ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetXthRefIntName" name="oetXthRefIntName" value="<?php echo $tXthRefInt ?>" readonly>
								<span class="input-group-btn">
									<button id="obtTXIBrowseRefInt" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefIntDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthRefIntDate" name="oetXthRefIntDate" value="<?php echo $dXthRefIntDate ?>">
										<span class="input-group-btn">
											<button id="obtXthRefIntDate" type="button" class="btn xCNBtnDateTime">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
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
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefExt'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" id="oetXthRefExt" name="oetXthRefExt" maxlength="20" value="<?php echo $tXthRefExt ?>">
								</div>
							</div>
						</div>

						<!-- วันที่เอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefExtDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthRefExtDate" name="oetXthRefExtDate" value="<?php echo $dXthRefExtDate ?>">
										<span class="input-group-btn">
											<button id="obtXthRefExtDate" type="button" class="btn xCNBtnDateTime">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>


						<!-- จากคลังสินค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefReason'); ?></label>
							<div class="input-group">
								<input type="text" class="input100 xCNHide" id="oetRsnCode" name="oetRsnCode" maxlength="5" value="<?= $tRsnCode ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetRsnName" name="oetRsnName" value="<?php echo $tRsnName; ?>" readonly>
								<span class="input-group-btn">
									<button id="obtTXIBrowseRsn" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

					</div>
				</div>
			</div>

			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITnfCondition'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvWarehouse" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvWarehouse" class="panel-collapse collapse in" role="tabpanel">

					<input type="text" class="xCNHide" id="ohdUserLoginBchCode" id="ohdUserLoginBchCode" value="<?= $tUserLoginBchCode ?>">
					<input type="text" class="xCNHide" id="ohdUserLoginBchName" id="ohdUserLoginBchName" value="<?= $tUserLoginBchName ?>">
					<input type="text" class="xCNHide" id="ohdUserLoginShpCode" id="ohdUserLoginShpCode" value="<?= $tUserLoginShpCode ?>">
					<input type="text" class="xCNHide" id="ohdUserLoginShpName" id="ohdUserLoginShpName" value="<?= $tUserLoginShpName ?>">

					<?php if ($tTXIDocType == "WAH") { ?>
						<div class="xCNHide">
							<?= "User Level : " . $tUserLevel . "<br>"; ?>
							<?= "UserLogin Branch : " . $tUserLoginBchCode . "<br>"; ?>
							<?= "UserLogin Merchant : " . $tUserLoginMerCode . "<br>"; ?>
							<?= "UserLogin Shop : " . $tUserLoginShpCode . "<br>"; ?>
							<?= "UserLogin ShopType : " . $tUserLoginShpType . "<br>"; ?>
							<?= "UserLogin Wah : " . $tUserLoginWahCode . "<br>"; ?>
						</div>
						<?php

						//Controll Pos From
						if ($tUserLoginShpType == "4") {
							$tPosDivHide = "";
							$tPosDisabled = "";
						} else {
							$tPosDivHide = "xCNHide";
							$tPosDisabled = "disabled";
						}

						switch ($tUserLevel) {
							case 'Bch':
								$tBchCodeValue	= $tUserLoginBchCode;
								$tBchNameValue	= $tUserLoginBchName;
								$tBchDisabled	= "disabled";

								$tMerCodeValue	= "";
								$tMerNameValue	= "";
								$tMerDisabled	= "";

								//ร้านค้า ต้นทาง
								$tShpCodeValue	= "";
								$tShpNameValue	= "";
								$tShpDisabled	= "disabled";
								//ร้านค้า ปลายทาง
								$tShpToDisabled	= "disabled";

								//คลัง ต้นทาง
								$tWahCodeValue	= "";
								$tWahNameValue	= "";
								$tWahDisabled	= "disabled";
								//คลัง ปลายทาง
								$tWahToDisabled	= "disabled";
								break;

							case 'Shp':
								$tBchCodeValue	= $tUserLoginBchCode;
								$tBchNameValue	= $tUserLoginBchName;
								$tBchDisabled	= "disabled";

								$tMerCodeValue	= $tUserLoginMerCode;
								$tMerNameValue	= $tUserLoginMerName;
								$tMerDisabled	= "disabled";
								//ร้านค้า ต้นทาง
								$tShpCodeValue	= $tUserLoginShpCode;
								$tShpNameValue	= $tUserLoginShpName;
								$tShpDisabled	= "disabled";
								//ร้านค้า ปลายทาง
								$tShpToDisabled	= "";

								//คลัง ต้นทาง
								$tWahCodeValue	= $tUserLoginWahCode;
								$tWahNameValue	= $tUserLoginWahName;
								$tWahDisabled	= "disabled";
								//คลัง ปลายทาง
								$tWahToDisabled	= "";

								break;

							default:

								$tBchCodeValue	= "";
								$tBchNameValue	= "";
								$tBchDisabled	= "";

								$tMerCodeValue	= "";
								$tMerNameValue	= "";
								$tMerDisabled	= "";

								//ร้านค้า ต้นทาง
								$tShpCodeValue	= "";
								$tShpNameValue	= "";
								$tShpDisabled	= "disabled";
								//ร้านค้า ปลายทาง
								$tShpToDisabled	= "disabled";

								//คลัง ต้นทาง
								$tWahCodeValue	= "";
								$tWahNameValue	= "";
								$tWahDisabled	= "disabled";
								//คลัง ปลายทาง
								$tWahToDisabled	= "disabled";

								break;
						}

						?>
						<div class="panel-body xCNPDModlue">
							<div class="form-group xCNHide">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIBranch'); ?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetBchCode" name="oetBchCode" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tBchCode  : $tBchCodeValue ?>" value="<?php echo $tXthDocNo != '' ? $tBchCode  : $tBchCodeValue ?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetBchName" name="oetBchName" data-oldval="<?php echo $tXthDocNo != '' ? $tBchName  : $tBchNameValue ?>" value="<?php echo $tXthDocNo != '' ? $tBchName  : $tBchNameValue ?>" readonly>
									<span class="xWConditionSearchPdt input-group-btn">
										<button id="obtTXIBrowseBch" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn" <?php echo $tBchDisabled; ?>>
											<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
										</button>
									</span>
								</div>
							</div>
							<!-- กลุ่มร้านค้า -->
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIMerchant'); ?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetMchCode" name="oetMchCode" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tXthMerCode : $tMerCodeValue ?>" value="<?php echo $tXthDocNo != '' ? $tXthMerCode : $tMerCodeValue ?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetMchName" name="oetMchName" data-oldval="<?php echo $tXthDocNo != '' ? $tXthMerName : $tMerNameValue ?>" value="<?php echo $tXthDocNo != '' ? $tXthMerName : $tMerNameValue ?>" readonly>
									<span class="xWConditionSearchPdt input-group-btn">
										<button id="obtTXIBrowseMch" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn" <?php echo $tMerDisabled ?>>
											<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
										</button>
									</span>
								</div>
							</div>
							<!-- กลุ่มร้านค้า -->

							<div style="border:1px solid #ccc;position:relative;padding:15px;margin-top:30px;">
								<label class="xCNLabelFrm" style="position:absolute;top:-15px;left:15px;background: #fff;padding-left: 10px;padding-right: 10px;"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIFrom'); ?></label>
								<!-- ร้านเริ่ม -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIShop'); ?></label>
									<div class="input-group">
										<input class="form-control xCNHide" id="oetShpCodeStart" name="oetShpCodeStart" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tShpCodeFrm : $tShpCodeValue ?>" value="<?php echo $tXthDocNo != '' ? $tShpCodeFrm : $tShpCodeValue ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetShpNameStart" name="oetShpNameStart" data-oldval="<?php echo $tXthDocNo != '' ? $tShpNameFrm : $tShpNameValue ?>" value="<?php echo $tXthDocNo != '' ? $tShpNameFrm : $tShpNameValue ?>" readonly>
										<span class="xWConditionSearchPdt input-group-btn">
											<button id="obtTXIBrowseShpStart" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn" <?php echo $tXthMerCode != '' ? "" : $tShpDisabled ?>>
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- ร้านเริ่ม -->

								<!-- เครื่อง เริ่ม -->
								<div class="form-group <?php echo $tShpTypeFrm == '4' ? "" : $tPosDivHide ?>">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIPos'); ?></label>
									<div class="input-group">
										<input class="form-control xCNHide" id="oetPosCodeStart" name="oetPosCodeStart" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tPosCodeFrm : '' ?>" value="<?php echo $tXthDocNo != '' ? $tPosCodeFrm : '' ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetPosNameStart" name="oetPosNameStart" data-oldval="<?php echo $tXthDocNo != '' ? $tPosNameFrm : '' ?>" value="<?php echo $tXthDocNo != '' ? $tPosNameFrm : '' ?>" readonly>
										<span class="xWConditionSearchPdt input-group-btn">
											<button id="obtTXIBrowsePosStart" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn" <?php echo $tShpTypeFrm == '4' ? "" : $tPosDisabled ?>>
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- เครื่อง เริ่ม -->
								<!-- คลังเริ่ม -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIWarehouseFrom'); ?></label>
									<div class="input-group">
										<input type="text" class="input100 xCNHide" id="ohdWahCodeStart" name="ohdWahCodeStart" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tWahCodeFrm : $tWahCodeValue ?>" value="<?php echo $tXthDocNo != '' ? $tWahCodeFrm : $tWahCodeValue ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetWahNameStart" name="oetWahNameStart" data-validate="<?php echo language('document/transferreceipt/transferreceipt', 'tTWIPlsEnterWahFrm'); ?>" data-oldval="<?php echo $tXthDocNo != '' ? $tWahNameFrm : $tWahNameValue ?>" value="<?php echo $tXthDocNo != '' ? $tWahNameFrm : $tWahNameValue ?>" readonly>
										<span class="input-group-btn">
											<button id="obtTXIBrowseWahStart" type="button" class="btn xCNBtnBrowseAddOn" <?php echo (($tWahCodeFrm != "" && $tPosCodeFrm == "")  ? ($tPosCodeFrm == "" ? $tWahDisabled : "") : ($tBchCode != "" && $tXthMerCode != "" && $tPosCodeFrm == "" ? "" : $tWahDisabled)) ?>>
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- คลังเริ่ม -->
							</div>


							<!-- ปลายทาง -->
							<div style="border:1px solid #ccc;position:relative;padding:15px;margin-top:30px;">
								<label class="xCNLabelFrm" style="position:absolute;top:-15px;left:15px;background: #fff;padding-left: 10px;padding-right: 10px;"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITo'); ?></label>
								<!-- ร้านปลายทาง -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIShop'); ?></label>
									<div class="input-group">
										<input class="form-control xCNHide" id="oetShpCodeEnd" name="oetShpCodeEnd" maxlength="5" data-oldval="<?php echo $tShpCodeTo ?>" value="<?php echo $tShpCodeTo ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetShpNameEnd" name="oetShpNameEnd" data-validate="<?php echo language('document/transferreceipt/transferreceipt', 'tTWIPlsEnterWahTo'); ?>" value="<?php echo $tShpNameTo ?>" readonly>
										<span class="xWConditionSearchPdt input-group-btn">
											<button id="obtTXIBrowseShpEnd" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn" <?php echo ($tShpCodeTo != "" ? "" : ($tXthMerCode != "" ? "" : $tShpToDisabled)) ?>>
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- ร้านปลายทาง -->
								<!-- เครื่องจบ -->
								<div class="form-group <?php echo $tShpTypeTo == '4' ? "" : $tPosDivHide ?>"" >
																																																																																																																																															<label class=" xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIPos'); ?></label>
									<div class="input-group">
										<input class="form-control xCNHide" id="oetPosCodeEnd" name="oetPosCodeEnd" maxlength="5" data-oldval="<?php echo $tXthDocNo != '' ? $tPosCodeTo : '' ?>" value="<?php echo $tXthDocNo != '' ? $tPosCodeTo : '' ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetPosNameEnd" name="oetPosNameEnd" value="<?php echo $tXthDocNo != '' ? $tPosNameTo : '' ?>" readonly>
										<span class="xWConditionSearchPdt input-group-btn">
											<button id="obtTXIBrowsePosEnd" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn" <?php echo $tShpTypeTo == '4' ? "" : $tPosDisabled ?>>
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- เครื่องจบ -->
								<!-- คลังจบ -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIWarehouseFrom'); ?></label>
									<div class="input-group">
										<input type="text" class="input100 xCNHide" id="ohdWahCodeEnd" name="ohdWahCodeEnd" maxlength="5" value="<?php echo $tWahCodeTo ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetWahNameEnd" name="oetWahNameEnd" data-validate="<?php echo language('document/transferreceipt/transferreceipt', 'tTWIPlsEnterWahTo'); ?>" value="<?php echo $tWahNameTo ?>" readonly>
										<span class="input-group-btn">
											<button id="obtTXIBrowseWahEnd" type="button" class="btn xCNBtnBrowseAddOn" <?php echo (($tWahCodeTo != "" && $tPosCodeTo == "")  ? ($tPosCodeTo == "" ? $tWahDisabled : "") : ($tBchCode != "" && $tXthMerCode != "" && $tPosCodeTo == "" ? "" : $tWahDisabled)) ?>>
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- คลังจบ -->
							</div>
							<!-- ปลายทาง -->

						</div>

					<?php } else { ?>
						<div class="panel-body xCNPDModlue">
							<div style="border:1px solid #ccc;position:relative;padding:15px;margin-top:30px;">
								<label class="xCNLabelFrm" style="position:absolute;top:-15px;left:15px;background: #fff;padding-left: 10px;padding-right: 10px;"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIFrom'); ?></label>

								<!-- Branch -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIBranch'); ?></label>
									<div class="input-group">
										<input class="form-control xCNHide" id="oetBchCode" name="oetBchCode" maxlength="5" value="">
										<input class="form-control xWPointerEventNone" type="text" id="oetBchName" name="oetBchName" value="" readonly>
										<!-- ถ้า user มีสาขาจะไม่สามารถ Brw ได้ -->
										<span class="input-group-btn">
											<button id="obtTXIBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- Branch -->

								<!-- Merchant -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIMerchant'); ?></label>
									<div class="input-group">
										<input class="form-control xCNHide" id="oetMerCode" name="oetMerCode" maxlength="5" value="">
										<input class="form-control xWPointerEventNone" type="text" id="oetMerName" name="oetMerName" value="" readonly>
										<!-- ถ้า user มีสาขาจะไม่สามารถ Brw ได้ -->
										<span class="input-group-btn">
											<button id="obtTXIBrowseMer" type="button" class="btn xCNBtnBrowseAddOn">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- Merchant -->

								<!-- ร้านค้า -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIShop'); ?></label>
									<div <?= $tShpCode != '' ? '' : 'class="input-group" '; ?>>
										<input class="form-control xCNHide" id="oetShpCode" name="oetShpCode" maxlength="5" value="<?php echo $tShpCode ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetShpName" name="oetShpName" value="<?php echo $tShpName ?>" readonly>
										<!-- ถ้า user มีร้านค้าจะไม่สามารถ Brw ได้ -->
										<?php if ($tShpCode == '') { ?>
											<span class="input-group-btn">
												<button id="obtTXIBrowseShp" type="button" class="btn xCNBtnBrowseAddOn" disabled>
													<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
												</button>
											</span>
										<?php } ?>
									</div>
								</div>
								<!-- ร้านค้า -->

								<!-- จากคลังสินค้า -->
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIWarehouseFrom'); ?></label>
									<div class="input-group">
										<input type="text" class="input100 xCNHide" id="ohdWahCodeFrom" name="ohdWahCodeFrom" maxlength="5" value="<?php echo $tWahCodeFrm ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetWahNameFrom" name="oetWahNameFrom" value="<?php echo $tWahNameFrm; ?>" readonly>
										<span class="input-group-btn">
											<button id="obtTXIBrowseWahFrom" type="button" class="btn xCNBtnBrowseAddOn">
												<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
											</button>
										</span>
									</div>
								</div>
								<!-- จากคลังสินค้า -->
							</div>
						</div>
					<?php } ?>
				</div>
			</div>


			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadDateTime" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIDelivery'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDelivery" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDelivery" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWICtrName'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthCtrName" name="oetXthCtrName" value="<?php echo $tXthCtrName ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITnfDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthTnfDate" name="oetXthTnfDate" value="<?php echo $dXthTnfDate ?>">
										<span class="input-group-btn">
											<button id="obtXthTnfDate" type="button" class="btn xCNBtnDateTime">
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
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefTnfID'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthRefTnfID" name="oetXthRefTnfID" value="<?php echo $tXthRefTnfID ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIViaCode'); ?></label>
									<div class="input-group">
										<input type="text" class="input100 xCNHide" id="ohdViaCode" name="ohdViaCode" maxlength="5" value="<?php echo $tViaCode ?>">
										<input class="form-control xWPointerEventNone" type="text" id="oetViaName" name="oetViaName" data-validate="กรุณาเลือก ถึงคลัง" value="<?php echo $tViaName ?>" readonly="">
										<span class="input-group-btn">
											<button id="obtTXIBrowseVia" type="button" class="btn xCNBtnBrowseAddOn">
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
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRefVehID'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthRefVehID" name="oetXthRefVehID" value="<?php echo $tXthRefVehID ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIQtyAndTypeUnit'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthQtyAndTypeUnit" name="oetXthQtyAndTypeUnit" value="<?php echo $tXthQtyAndTypeUnit ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<input tyle="text" class="xCNHide" id="ohdXthShipAdd" name="ohdXthShipAdd" value="<?php echo $tXthShipAdd ?>">
								<button type="button" id="obtTXIBrowseShipAdd" class="btn btn-primary" style="font-size: 17px;">+ <?php echo language('document/transferreceipt/transferreceipt', 'tTWIShipAddress'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIVATInOrEx'); ?></label>
							<input type="text" class="xCNHide" id="ohdXthVATInOrEx" name="ohdXthVATInOrEx" value="<?= $tXthVATInOrEx ?>">
							<select class="selectpicker form-control" id="ostXthVATInOrEx" name="ostXthVATInOrEx" maxlength="1">
								<option value="1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIVATIn'); ?></option>
								<option value="2" selected><?php echo language('document/transferreceipt/transferreceipt', 'tTWIVATEx'); ?></option>
							</select>
						</div>



						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRemark'); ?></label>
							<textarea class="form-control" id="otaXthRmk" name="otaXthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?php echo $tXthRmk ?></textarea>
						</div>

						<div class="form-group">
							<label class="fancy-checkbox">
								<input type="checkbox" id="ocbXthStaDocAct" name="ocbXthStaDocAct" maxlength="1" <?php echo $nXthStaDocAct == '' ? 'checked' : $nXthStaDocAct == '1' ? 'checked' : '0'; ?>>
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tTWIStaDocAct'); ?></span>
							</label>
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIRef'); ?>: <?php echo language('document/transferreceipt/transferreceipt', 'tTWIStaRef' . $tXthStaRef); ?></label>
						</div>

						<!-- จำนวนครั้งที่พิมพ์ -->
						<div class="form-group" style="margin-top:15px;">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIDocPrint'); ?></label>
							<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthDocPrint" name="oetXthDocPrint" maxlength="1" value="<?= $nXthDocPrint ?>" readonly>
						</div>
						<!-- จำนวนครั้งที่พิมพ์ -->

						<!-- ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/producttransferwahouse/producttransferwahouse', 'tTFWOptionAddPdt'); ?></label>
							<select class="selectpicker form-control" id="ocmTXIOptionAddPdt" name="ocmTXIOptionAddPdt">
								<option value="1"><?php echo language('document/producttransferwahouse/producttransferwahouse', 'tTFWOptionAddPdtAddNumPdt'); ?></option>
								<option value="2"><?php echo language('document/producttransferwahouse/producttransferwahouse', 'tTFWOptionAddPdtAddNewRow'); ?></option>
							</select>
						</div>
						<!-- ตัวเลือกในการเพิ่มรายการสินค้าจากเมนูสแกนสินค้าในหน้าเอกสาร * กรณีเพิ่มสินค้าเดิม -->

					</div>
				</div>
			</div>


			<!-- <div class="panel panel-default" style="margin-bottom: 60px;">
			<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOptionDocument'); ?></label>
				<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOptionDocument" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvOptionDocument" class="panel-collapse collapse" role="tabpanel">
				<div class="panel-body xCNPDModlue">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOptDocSaveAlwOrdIs0'); ?></label>
							<select class="selectpicker form-control" id="ostOptAlwSavQty0" name="ostOptAlwSavQty0" maxlength="1">
								<option value="1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOptDocAlw'); ?></option>
								<option value="2"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOptDocNotAlw'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIDataAddFormat'); ?></label>
							
							<select class="selectpicker form-control" id="ostOptScanSku" name="ostOptScanSku" maxlength="1">
								<option value="1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOptDocAddQty'); ?></option>
								<option value="2"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIOptDocAddRow'); ?></option>
							</select>
						</div>
				</div>
			</div>    
		</div> -->

		</div>



		<div class="col-md-8" id="odvRightPanal">
			<!-- Suplier -->

			<!-- Suplier -->

			<!-- Pdt -->
			<div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;">
				<div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
					<div class="panel-body xCNPDModlue">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group">
										<input type="text" class="form-control" maxlength="100" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvDOCSearchPdtHTML()" placeholder="<?php echo language('document/transferreceipt/transferreceipt', 'tTWISearchPdt'); ?>">
										<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvTWIScanPdtHTML()" placeholder="<?php echo language('document/transferreceipt/transferreceipt', 'tTWIScanPdt'); ?>" style="display:none;" data-validate="ไม่พบข้อมูลที่แสกน">
										<span class="input-group-btn">
											<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
												<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvDOCSearchPdtHTML()">
													<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/search-24.png' ?>" style="width:20px;">
												</button>
												<button id="oimMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvTWIScanPdtHTML()">
													<img class="oimMngPdtIconScan" src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/scanner.png' ?>" style="width:20px;">
												</button>
												<button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
													<i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a id="oliMngPdtSearch"><label><?php echo language('document/transferreceipt/transferreceipt', 'tTWISearchPdt'); ?></label></a>
														<a id="oliMngPdtScan"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIScanPdt'); ?></a>
													</li>
												</ul>
											</div>
										</span>
									</div>
								</div>
							</div>
							<div class="col-md-5">
								<div class="btn-group xCNDropDrownGroup right">
									<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
										<?php echo language('common/main/main', 'tCMNOption') ?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li id="oliBtnDeleteAll" class="disabled">
											<a data-toggle="modal" data-target="#odvModalDelPdtTXI"><?php echo language('common/main/main', 'tDelAll') ?></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<div style="position: absolute;right: 15px;top:-5px;">
										<button class="xCNBTNPrimeryPlus xCNDocBrowsePdt" onclick="JCNvTWIBrowsePdt()" type="button">+</button>

										<button class="xCNBTNPrimeryPlus xCNDocBrowsePdt" onclick="JSvTWIBrowsePdt()" type="button">x</button>
									</div>
								</div>
							</div>
						</div>
						<div id="odvPdtTablePanal">
						</div>
						<div id="odvPdtTablePanalDataHide">
						</div>
					</div>
				</div>
			</div>


			<div class="row">
				<div class="col-lg-7">
					<div class="col-md-12 panel panel-default" style="background: white;height: 180px;">
						<div class="row" style="background: #eeeeee;">
							<div class="col-md-12">
								<label class="xCNLabelFrm" id="othFCXthGrandText" style="margin:5px 0 5px;">-</label>
							</div>
						</div>
						<div class="row" id="odvVatPanal">
							<div class="table-responsive" style="height: 100px;overflow-y: scroll;">
								<table class="table xWPdtTableFont">
									<tbody>
										<tr>
											<td class="text-left xCNTextDetail2">
												<span id="othFCXthGrandText">-</span>
											</td>
										</tr>
									</tbody>
								</table>
							</div>
						</div>
						<div class="row" style="background: #eeeeee; padding-top: 6px; padding-bottom: 6px;">
							<div class="col-md-12">
								<div class="row">
									<div class="col-lg-6">
										<label class="xCNLabelFrm">ยอดรวมภาษี</label>
									</div>
									<div class="col-lg-6 text-right">
										<label class="xCNLabelFrm" id="olaSumXtdVat">-</label>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="col-lg-5">
					<div class="col-md-12 panel panel-default" style="background: white;height: 180px;">
						<div class="col-md-12" style="padding:15px;">
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWITotalCash'); ?></label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="othFCXthTotal">-</label>
							</div>
						</div>
						<div class="col-md-12" style="padding:15px;">
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm">ภาษีมูลค่าเพิ่ม</label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="olaVatTotal">-</label>
							</div>
						</div>
						<div class="col-md-12" style="padding:15px;">
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIGrandB4Wht'); ?></label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="othFCXthGrandB4Wht">-</label>
							</div>
						</div>
					</div>
				</div>
			</div>

		</div>
	</div>

</form>

<div class="modal fade" id="odvModalTXIPDT" tabindex="-1" role="dialog" style="overflow: hidden auto; z-index: 5000; display: none;">
	<div class="modal-dialog" role="document" style="width: 85%; margin: 1.75rem auto;top:0%;">
		<div class="modal-content" id="odvModalBodyTWIPDT">
			<div class="modal-header xCNModalHead">
				<div class="row">
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
						<label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('common/main/main', 'tShowData') . language('common/main/main', 'tModalHeadnamePDT'); ?></label>
					</div>
					<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
						<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JCNxConfirmSelectedTXIPDT()"><?php echo language('common/main/main', 'tModalAdvChoose') ?></button>
						<button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal" onclick="JCNxCloseTXIPDT()"><?= language('common/main/main', 'tCMNClose'); ?></button>
					</div>
				</div>
			</div>
			<div class="modal-body" id="odvModalsectionBodyTXIPDT">

			</div>
		</div>
	</div>
</div>
<!-- End Modal PDT for:supawat -->




<!-- Modal Address-->
<div class="modal fade" id="odvTXIBrowseShipAdd" style="">
	<div class="modal-dialog" style="width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIShipAddress'); ?></label>
					</div>
					<div class="col-xs-12 col-md-6 text-right">
						<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnTXIAddShipAdd()"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
						<button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
					</div>
				</div>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-xs-12 col-md-12">
						<div class="panel panel-default" style="margin-bottom: 5px;">
							<div class="panel-heading xCNPanelHeadColor" style="padding-top:5px !important;padding-bottom:5px !important;">
								<div class="row">
									<div class="col-xs-6 col-md-6">
										<label class="xCNTextDetail1"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIAddInfo'); ?></label>
									</div>
									<div class="col-xs-6 col-md-6 text-right">
										<a style="font-size: 14px !important;color: #179bfd;">
											<i class="fa fa-pencil" id="oliBtnEditShipAdd"><?php echo language('document/transferreceipt/transferreceipt', 'tTWIChange'); ?></i>
										</a>
									</div>
								</div>
							</div>
							<div>
								<div class="panel-body xCNPDModlue">
									<input type="text" class="xCNHide" id="ohdShipAddSeqNo">
									<?php
									$tFormat = FCNaHAddressFormat('TCNMBranch'); //1 ที่อยู่ แบบแยก  ,2  แบบรวม
									if ($tFormat == '1') :
										?>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1No'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddAddV1No">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1Village'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1Soi">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1Soi'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1Village">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1Road'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1Road">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1SubDist'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1SubDist">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1DstCode'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1DstCode">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1PvnCode'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1PvnCode">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV1PostCode'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1PostCode">-</label>
											</div>
										</div>

									<?php else : ?>
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV2Desc1') ?></label><br>
													<label id="ospShipAddV2Desc1" name="ospShipAddV2Desc1">-</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="xCNLabelFrm"><?php echo language('document/transferreceipt/transferreceipt', 'tBrowseADDV2Desc2') ?></label><br>
													<label id="ospShipAddV2Desc2" name="ospShipAddV2Desc2">-</label>
												</div>
											</div>
										</div>
									<?php endif; ?>

								</div>
							</div>
						</div>
					</div>
				</div>

			</div>

		</div>
	</div>
</div>



<div class="modal fade xCNModalApprove" id="odvTXIPopupApv">
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
				<button id="obtCardShiftTopUpPopupApvConfirm" onclick="JSnTWIApprove(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="odvShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalAdvTable'); ?></label>
			</div>
			<div class="modal-body" id="odvOderDetailShowColumn">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onclick="JSxSaveColumnShow('')"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="odvTXIPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard">ยกเลิกเอกสาร</label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv">เอกสารใบนี้ทำการประมวลผล หรือยกเลิกแล้ว ไม่สามารถแก้ไขได้</p>
				<p>คุณต้องการที่จะยกเลิกเอกสารนี้หรือไม่?</p>
			</div>
			<div class="modal-footer">
				<button onclick="JSnTWICancel(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jTransferreceiptAdd.php') ?>