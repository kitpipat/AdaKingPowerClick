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
	$tShpCode 			= $aResult['raItems']['FTShpCode'];
	$tShpName 			= $aResult['raItems']['FTShpName'];
	$tWahCodeFrm		= $aResult['raItems']['FTXthWhFrm'];
	$tWahNameFrm 		= $aResult['raItems']['FTWahNameFrm'];
	$tWahCodeTo 	 	= $aResult['raItems']['FTXthWhTo'];
	$tWahNameTo 		= $aResult['raItems']['FTWahNameTo'];
	$tXthRefExt 		= $aResult['raItems']['FTXthRefExt'];
	$dXthRefExtDate		= $aResult['raItems']['FDXthRefExtDate'];
	$tXthRefInt 		= $aResult['raItems']['FTXthRefInt'];
	$tXthCtrName		= $aResult['raItems']['FTXthCtrName'];
	$dXthTnfDate		= $aResult['raItems']['FDXthTnfDate'];
	$tXthRefTnfID		= $aResult['raItems']['FTXthRefTnfID'];
	$tViaCode			= $aResult['raItems']['FTViaCode'];
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
	$tXthUsrNameApv		= $aResult['raItems']['FTUsrNameApv'];
	$tXthVATInOrEx		= $aResult['raItems']['FTXthVATInOrEx'];
	$dXthRefIntDate		= $aResult['raItems']['FDXthRefIntDate'];
	$cXthVat 			= $aResult['raItems']['FCXthVat'];
	$cXthVatable 		= $aResult['raItems']['FCXthVatable'];
	$tRsnCode 			= $aResult['raItems']['FTRsnCode'];
	$tRsnName 			= $aResult['raItems']['FTRsnName'];

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

	$tRoute         		= "TWOEventEdit";
} else {

	$tXthDocNo 				= "";
	$dXthDocDate 			= "";
	$tCreateBy 				= $this->session->userdata('tSesUsrUsername');
	$tXthStaDoc 			= "";
	$tXthStaApv 			= "";
	$tXthApvCode 			= $this->session->userdata('tSesUsername');
	$tXthStaPrcStk 		= "";
	$tXthStaDelMQ 		= "";
	$tBchCode 				= $tBchCode;
	$tBchName 				= $tBchName;
	$tShpCode 				= $tShpCode;
	$tShpName 				= $tShpName;
	$tWahCodeFrm 			= $tWahCode;
	$tWahNameFrm 			= $tWahName;
	$tWahCodeTo 			= "";
	$tWahNameTo 			= "";
	$tXthRefExt 			= "";
	$dXthRefExtDate 	= "";
	$tXthRefInt 			= "";
	$tXthCtrName		 	= "";
	$dXthTnfDate			= "";
	$tXthRefTnfID			= "";
	$tViaCode					= "";
	$tXthRefVehID 		= "";
	$tXthQtyAndTypeUnit = "";
	$tXthShipAdd			= "";
	$nXthStaDocAct 		= "";
	$tXthStaRef		  	= "";
	$nXthDocPrint 		= "";
	$tXthRmk 					= "";
	$tDptCode 				= $tDptCode;
	$tDptName 				= $this->session->userdata("tSesUsrDptName");
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy	= $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 	= "";
	$tXthVATInOrEx		= "";
	$dXthRefIntDate 	= "";
	$tVatCode 				= $tVatCode;
	$cXthVat 					= "";
	$cXthVatable 			= "";
	$tRsnCode 				= "";
	$tRsnName 				= "";

	$tRoute         	= "TWOEventAdd";

	$nAutStaEdit 			= 0; //Event Control
}
?>


<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddTWO">
	<input type="hidden" id="ohdTWOAutStaEdit" name="ohdTWOAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
	<input type="hidden" id="ohdXthStaApv" name="ohdXthStaApv" value="<?php echo $tXthStaApv; ?>">
	<input type="hidden" class="" id="ohdXthStaDoc" name="ohdXthStaDoc" value="<?php echo $tXthStaDoc; ?>">
	<input type="hidden" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" value="<?php echo $tXthStaPrcStk; ?>">
	<input type="hidden" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" value="<?php echo $tXthStaDelMQ; ?>">
	<button style="display:none" type="submit" id="obtSubmitTWO" onclick="JSnAddEditTWO('<?php echo $tRoute; ?>')"></button>
	<input type="text" class="xCNHide" id="ohdSesUsrBchCode" name="ohdSesUsrBchCode" value="<?php echo $this->session->userdata("tSesUsrBchCode"); ?>">
	<input type="text" class="xCNHide" id="ohdBchCode" name="ohdBchCode" value="<?php echo $tBchCode; ?>">
	<input type="text" class="xCNHide" id="ohdOptAlwSavQty0" name="ohdOptAlwSavQty0" value="<?php echo $nOptDocSave ?>">
	<input type="text" class="xCNHide" id="ohdOptScanSku" name="ohdOptScanSku" value="<?php echo $nOptScanSku ?>">
	<input type="text" class="xCNHide" id="ohdDptCode" name="ohdDptCode" maxlength="5" value="<?php echo $tDptCode; ?>">
	<input type="text" class="xCNHide" id="oetUsrCode" name="oetUsrCode" maxlength="20" value="<?php echo $tUsrCode ?>">
	<input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">

	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<?php ?>
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOApproved'); ?></label>
						</div>
						<?php echo $this->session->userdata("tSesUsrBchCode"); ?>
						<?php if (@$tXthDocNo == '') { ?>
							<div class="form-group">
								<label class="fancy-checkbox">
									<input type="checkbox" id="ocbStaAutoGenCode" name="ocbStaAutoGenCode" maxlength="1" checked="checked">
									<span>&nbsp;</span>
									<span class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOAutoGenCode'); ?></span>
								</label>
							</div>
						<?php } ?>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWODocNo'); ?></label>
							<?php if (@$tXthDocNo) {
								$tStaDisabled = 'readonly';
							} else {
								$tStaDisabled = '';
							} ?>
							<input type="text" class="form-control" id="oetXthDocNo" name="oetXthDocNo" disabled="disabled" maxlength="20" value="<?php echo $tXthDocNo; ?>" onkeyup="JStCMNCheckDuplicateCodeMaster('oetXthDocNo','JSvCallPageTWOEdit','TCNTPdtTwoHD','FTXthDocNo')" data-validate="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOPlsEnterOrRunDocNo'); ?>" placeholder="##########" <?= $tStaDisabled ?>>
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWODocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDate" name="oetXthDocDate" value="<?php echo $dXthDocDate; ?>" data-validate="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?php echo $tCreateBy ?>">
								<label><?php echo $tUsrNameCreateBy ?></label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaDoc' . $tXthStaDoc); ?></label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaApv' . $tXthStaApv); ?></label>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTBStaPrc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaPrcStk' . $tXthStaPrcStk); ?></label>
							</div>
						</div>

						<?php if ($tXthDocNo != '') { ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?php echo $tXthApvCode ?>">
									<label><?php echo $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>


			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTnfCondition'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvWarehouse" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvWarehouse" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- สาขา -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOBranch'); ?></label>
							<div <?= $tBchCode != '' ? '' : 'class="input-group" '; ?>>
								<input class="form-control xCNHide" id="oetBchCode" name="oetBchCode" maxlength="5" value="<?php echo $tBchCode ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetBchName" name="oetBchName" value="<?php echo $tBchName ?>" readonly>
								<!-- ถ้า user มีสาขาจะไม่สามารถ Brw ได้ -->
								<?php if ($tBchCode == '') { ?>
									<span class="input-group-btn">
										<button id="obtTWOBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
											<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
										</button>
									</span>
								<?php } ?>
							</div>
						</div>

						<!-- ร้านค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShop'); ?></label>
							<div <?= $tShpCode != '' ? '' : 'class="input-group" '; ?>>
								<input class="form-control xCNHide" id="oetShpCode" name="oetShpCode" maxlength="5" value="<?php echo $tShpCode ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetShpName" name="oetShpName" value="<?php echo $tShpName ?>" readonly>
								<!-- ถ้า user มีร้านค้าจะไม่สามารถ Brw ได้ -->
								<?php if ($tShpCode == '') { ?>
									<span class="input-group-btn">
										<button id="obtTWOBrowseShp" type="button" class="btn xCNBtnBrowseAddOn" disabled="disabled">
											<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
										</button>
									</span>
								<?php } ?>
							</div>
						</div>

						<!-- จากคลังสินค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOWarehouseFrom'); ?></label>
							<div class="input-group">
								<input type="text" class="input100 xCNHide" id="ohdWahCodeFrom" name="ohdWahCodeFrom" maxlength="5" value="<?php echo $tWahCodeFrm ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetWahNameFrom" name="oetWahNameFrom" value="<?php echo $tWahNameFrm; ?>" readonly>
								<span class="input-group-btn">
									<button id="obtTWOBrowseWahFrom" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<!-- จากคลังสินค้า -->

						<!-- จากคลังสินค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOWarehouseTo'); ?></label>
							<div class="input-group">
								<input type="text" class="input100 xCNHide" id="ohdWahCodeTo" name="ohdWahCodeTo" maxlength="5" value="<?php echo $tWahCodeTo ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetWahNameTo" name="oetWahNameTo" value="<?php echo $tWahNameTo; ?>" readonly>
								<span class="input-group-btn">
									<button id="obtTWOBrowseWahTo" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>
						<!-- จากคลังสินค้า -->

						<!-- จำนวนครั้งที่พิมพ์ -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWODocPrint'); ?></label>
							<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthDocPrint" name="oetXthDocPrint" maxlength="1" value="<?= $nXthDocPrint ?>">
						</div>
						<!-- จำนวนครั้งที่พิมพ์ -->
					</div>
				</div>
			</div>


			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOReference'); ?></label>
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
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefExt'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" id="oetXthRefExt" name="oetXthRefExt" maxlength="20" value="<?php echo $tXthRefExt ?>">
								</div>
							</div>
						</div>

						<!-- วันที่เอกสารภายนอก -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefExtDate'); ?></label>
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

						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefInt'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" id="oetXthRefInt" name="oetXthRefInt" maxlength="20" value="<?php echo $tXthRefInt ?>">
								</div>
							</div>
						</div>

						<!-- วันที่เอกสารภายใน -->
						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefIntDate'); ?></label>
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

						<!-- จากคลังสินค้า -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefReason'); ?></label>
							<div class="input-group">
								<input type="text" class="input100 xCNHide" id="oetRsnCode" name="oetRsnCode" maxlength="5" value="<?= $tRsnCode ?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetRsnName" name="oetRsnName" value="<?php echo $tRsnName; ?>" readonly>
								<span class="input-group-btn">
									<button id="obtTWOBrowseRsn" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>


					</div>
				</div>
			</div>

			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadDateTime" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWODelivery'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvDelivery" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDelivery" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOCtrName'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthCtrName" name="oetXthCtrName" value="<?php echo $tXthCtrName ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTnfDate'); ?></label>
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
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefTnfID'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthRefTnfID" name="oetXthRefTnfID" value="<?php echo $tXthRefTnfID ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOViaCode'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetViaCode" name="oetViaCode" value="<?php echo $tViaCode ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORefVehID'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthRefVehID" name="oetXthRefVehID" value="<?php echo $tXthRefVehID ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOQtyAndTypeUnit'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXthQtyAndTypeUnit" name="oetXthQtyAndTypeUnit" value="<?php echo $tXthQtyAndTypeUnit ?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-12">
								<input tyle="text" class="xCNHide" id="ohdXthShipAdd" name="ohdXthShipAdd" value="<?php echo $tXthShipAdd ?>">
								<button type="button" id="obtTWOBrowseShipAdd" class="btn btn-primary" style="font-size: 17px;">+ <?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipAddress'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>

			<div class="panel panel-default" style="margin-bottom: 60px;">
				<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOOther'); ?></label>
					<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOther" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvOther" class="panel-collapse collapse" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOVATInOrEx'); ?></label>
							<input type="text" class="xCNHide" id="ohdXthVATInOrEx" name="ohdXthVATInOrEx" value="<?= $tXthVATInOrEx ?>">
							<select class="selectpicker form-control" id="ostXthVATInOrEx" name="ostXthVATInOrEx" maxlength="1">
								<option value="1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOVATIn'); ?></option>
								<option value="2"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOVATEx'); ?></option>
							</select>
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORef'); ?>: <?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOStaRef' . $tXthStaRef); ?></label>
						</div>

						<div class="form-group">
							<label class="fancy-checkbox">
								<input type="checkbox" class="" id="ocbXthStaDocAct" name="ocbXthStaDocAct" maxlength="1" <?php echo $nXthStaDocAct == '' ? 'checked' : $nXthStaDocAct == '1' ? 'checked' : '0'; ?>>
								<span>&nbsp;</span>
								<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tTWOStaDocAct'); ?></span>
							</label>
						</div>

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWORemark'); ?></label>
							<textarea class="form-control" id="otaXthRmk" name="otaXthRmk" rows="10" maxlength="200" style="resize: none;height:86px;"><?php echo $tXthRmk ?></textarea>
						</div>

					</div>
				</div>
			</div>
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
										<input type="text" class="form-control" maxlength="100" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvDOCSearchPdtHTML()" placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOSearchPdt'); ?>">
										<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvTWOScanPdtHTML()" placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOScanPdt'); ?>" style="display:none;" data-validate="ไม่พบข้อมูลที่แสกน">
										<span class="input-group-btn">
											<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
												<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvDOCSearchPdtHTML()">
													<img src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/search-24.png' ?>" style="width:20px;">
												</button>
												<button id="oimMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvTWOScanPdtHTML()">
													<img class="oimMngPdtIconScan" src="<?php echo  base_url() . 'application/modules/common/assets/images/icons/scanner.png' ?>" style="width:20px;">
												</button>
												<button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
													<i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a id="oliMngPdtSearch"><label><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOSearchPdt'); ?></label></a>
														<a id="oliMngPdtScan"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOScanPdt'); ?></a>
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
											<a data-toggle="modal" data-target="#odvModalDelPdtTWO"><?php echo language('common/main/main', 'tDelAll') ?></a>
										</li>
									</ul>
								</div>
							</div>
							<div class="col-md-1">
								<div class="form-group">
									<div style="position: absolute;right: 15px;top:-5px;">
										<button class="xCNBTNPrimeryPlus xCNDocBrowsePdt" onclick="JCNvTWOBrowsePdt()" type="button">+</button>
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
			<!-- Pdt -->

			<div class="panel panel-headline" style="border: none;">
				<div class="row">
					<div class="col-md-12">
						<div class="row">
							<div class="col-md-6" style="padding-right: 0px;">
								<!-- Pdt -->
								<!-- <div class="row"> -->
								<div class="col-md-12" style="border-top: 1px solid #dee2e6;padding-right: 0px;padding-left: 0px;">
									<div class="table-responsive">
										<table class="table xWPdtTableFont" style="margin-bottom: 0px;">
											<tbody>
												<tr>
													<td class="text-left xCNTextDetail2">
														<label id="othFCXthGrandText">-</label>
													</td>
												</tr>
											</tbody>
										</table>
									</div>
								</div>
								<div class="col-md-12" id="odvVatPanal" style="min-height:42px;padding-right: 0px;padding-left: 0px;">

								</div>
								<!-- </div> -->
								<!-- Pdt -->
							</div>

							<div class="col-md-6" style="padding-left: 0px;">
								<!-- Pdt -->
								<div class="table-responsive">
									<table class="table table-striped" id="otbHDSumAll" style="margin-bottom: 0px;">
										<thead>
										</thead>
										<tbody>
											<tr>
												<td class="xCNTextDetail1 text-left">
													<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOTotalCash'); ?></label>
												</td>
												<td class="text-right">
													<label id="othFCXthTotal">-</label>
												</td>
											</tr>
											<tr>
												<td class="xCNTextDetail1 text-left"><label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOGrandB4Wht'); ?></label></td>
												<td class="text-right">
													<label id="othFCXthGrandB4Wht">-</label>
												</td>
											</tr>
										</tbody>
									</table>
								</div>
								<!-- Pdt -->
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>

</form>

<!-- Modal Address-->
<div class="modal fade" id="odvTWOBrowseShipAdd" style="">
	<div class="modal-dialog" style="width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOShipAddress'); ?></label>
					</div>
					<div class="col-xs-12 col-md-6 text-right">
						<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnTWOAddShipAdd()"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
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
										<label class="xCNTextDetail1"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOAddInfo'); ?></label>
									</div>
									<div class="col-xs-6 col-md-6 text-right">
										<a style="font-size: 14px !important;color: #179bfd;">
											<i class="fa fa-pencil" id="oliBtnEditShipAdd"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTWOChange'); ?></i>
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
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1No'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddAddV1No">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1Village'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1Soi">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1Soi'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1Village">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1Road'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1Road">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1SubDist'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1SubDist">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1DstCode'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1DstCode">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1PvnCode'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1PvnCode">-</label>
											</div>
										</div>
										<div class="row">
											<div class="col-xs-6 col-md-6">
												<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV1PostCode'); ?></label>
											</div>
											<div class="col-xs-6 col-md-6">
												<label id="ospShipAddV1PostCode">-</label>
											</div>
										</div>

									<?php else : ?>
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV2Desc1') ?></label><br>
													<label id="ospShipAddV2Desc1" name="ospShipAddV2Desc1">-</label>
												</div>
											</div>
										</div>
										<div class="row">
											<div class="col-lg-12">
												<div class="form-group">
													<label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tBrowseADDV2Desc2') ?></label><br>
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


<div class="modal fade" id="odvTWOPopupApv">
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
				<button onclick="JSnTWOApprove(true)" type="button" class="btn xCNBTNPrimery">
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
			<div class="modal-header">
				<h5 class="modal-title" id="exampleModalLabel"><?php echo language('common/main/main', 'tModalAdvTable'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body" id="odvOderDetailShowColumn">
				...
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
				<button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
			</div>
		</div>
	</div>
</div>


<div class="modal fade" id="odvTWOPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('document/adjuststock/adjuststock', 'tASTCanDoc'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?php echo language('document/adjuststock/adjuststock', 'tASTDocRemoveCantEdit'); ?></p>
				<p><?php echo language('document/adjuststock/adjuststock', 'tASTCancel'); ?></p>
			</div>
			<div class="modal-footer">
				<button onclick="JSnTWOCancel(true)" type="button" class="btn xCNBTNPrimery">
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
<?php include('script/jTransferwarehouseoutAdd.php') ?>