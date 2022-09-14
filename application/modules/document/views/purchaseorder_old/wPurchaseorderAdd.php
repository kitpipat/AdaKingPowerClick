<?php
if($aResult['rtCode'] == "1"){

	$tWahCode 			= $tWahCode;
	$tWahName 			= $tWahName;
	$tBchCode 			= $aResult['raItems']['FTBchCode'];
	$tXphDocNo 			= $aResult['raItems']['FTXphDocNo'];
	$tShpCode 			= $aResult['raItems']['FTShpCode'];
	$tShpName 			= $aResult['raItems']['FTShpName'];
	$nXphDocType 		= $aResult['raItems']['FNXphDocType'];
	$dXphDocDate 		= $aResult['raItems']['FDXphDocDate'];
	$tXphCshOrCrd 		= $aResult['raItems']['FTXphCshOrCrd'];
	$tXphVATInOrEx 		= $aResult['raItems']['FTXphVATInOrEx'];
	$tDptCode 			= $aResult['raItems']['FTDptCode'];
	$tDptName 			= $aResult['raItems']['FTDptName'];
	$tUsrCode 			= $aResult['raItems']['FTUsrCode'];
	$tUsrNameCreateBy	= $aResult['raItems']['FTUsrName'];
	$tCreateBy 			= $aResult['raItems']['FTCreateBy'];
	$tXphApvCode 		= $aResult['raItems']['FTXphApvCode'];
	$tXphUsrNameApv = $aResult['raItems']['FTUsrNameApv'];
	$tSplCode 			= $aResult['raItems']['FTSplCode'];
	$tSplName 			= $aResult['raItems']['FTSplName'];
	$tXphRefExt 		= $aResult['raItems']['FTXphRefExt'];
	$dXphRefExtDate 	= $aResult['raItems']['FDXphRefExtDate'];
	$tXphRefInt 		= $aResult['raItems']['FTXphRefInt'];
	$dXphRefIntDate 	= $aResult['raItems']['FDXphRefIntDate'];
	$tXphRefAE 			= $aResult['raItems']['FTXphRefAE'];
	$nXphDocPrint 		= $aResult['raItems']['FNXphDocPrint'];
	$tRteCode 			= $aResult['raItems']['FTRteCode'];
	$cXphRteFac 		= $aResult['raItems']['FCXphRteFac'];
	$tVatCode 			= $aResult['raItems']['FTVatCode'];
	$cXphVATRate 		= $aResult['raItems']['FCXphVATRate'];
	$cXphRefAEAmt 		= $aResult['raItems']['FCXphRefAEAmt'];
	$cXphVat 			= $aResult['raItems']['FCXphVat'];
	$cXphVatable 		= $aResult['raItems']['FCXphVatable'];
	$cXphWpTax 			= $aResult['raItems']['FCXphWpTax'];
	$tXphRmk 			= $aResult['raItems']['FTXphRmk'];
	$tXphStaDoc 		= $aResult['raItems']['FTXphStaDoc'];
	$tXphStaApv 		= $aResult['raItems']['FTXphStaApv'];
	$nXphStaDocAct 		= $aResult['raItems']['FNXphStaDocAct'];

	//TAPTOrdHDSpl
	$tXphRefVehID 		= $aResult['raItems']['FTXphRefVehID'];
	$tXphRefInvNo 		= $aResult['raItems']['FTXphRefInvNo'];
	$nXphCrTerm 		= $aResult['raItems']['FNXphCrTerm'];
	$tXphQtyAndTypeUnit	= $aResult['raItems']['FTXphQtyAndTypeUnit'];
	$tXphShipAdd		= $aResult['raItems']['FNXphShipAdd'];
	$tXphTaxAdd			= $aResult['raItems']['FNXphTaxAdd'];
	$dXphDueDate		= $aResult['raItems']['FDXphDueDate'];
	$dXphTnfDate		= $aResult['raItems']['FDXphTnfDate'];
	$dXphBillDue		= $aResult['raItems']['FDXphBillDue'];
	$tXphDstPaid		= $aResult['raItems']['FTXphDstPaid'];
	$tXphCtrName		= $aResult['raItems']['FTXphCtrName'];

	//Event Control
	if(isset($aAlwEventPO)){
		if($aAlwEventPO['tAutStaFull'] == 1 || $aAlwEventPO['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	//Event Control

	$tRoute         	= "POEventEdit";
	
}else{

	$tWahCode 			= $tWahCode;
	$tWahName 			= $tWahName;
	$tBchCode 			= "";
	$tXphDocNo 			= "";
	$tShpCode 			= $tShpCode;
	$tShpName 			= $tShpName;
	$nXphDocType 		= "";
	$dXphDocDate 		= "";
	$tXphCshOrCrd 		= "";
	$tXphVATInOrEx 		= "";
	$tDptCode 			= $tDptCode; 
	$tDptName 			= $this->session->userdata("tSesUsrDptName"); 
	$tUsrCode 			= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy = $this->session->userdata('tSesUsrUsername');
	$tCreateBy 			= $this->session->userdata('tSesUsrUsername');
	$tXphApvCode 		= "";
	$tXphUsrNameApv = "";
	$tSplCode 			= "";
	$tSplName 			= "";
	$tXphRefExt 		= "";
	$dXphRefExtDate 	= "";
	$tXphRefInt 		= "";
	$dXphRefIntDate 	= "";
	$tXphRefAE 			= "";
	$nXphDocPrint 		= "";
	$tRteCode 			= $tCmpRteCode; //ได้จาก Company Rate Code 
	$cXphRteFac 		= $cXphRteFac;
	$tVatCode 			= $tVatCode;
	$cXphVATRate 		= $cVatRate;
	$cXphRefAEAmt 		= "";
	$cXphVat 			= "";
	$cXphVatable 		= "";
	$cXphWpTax 			= "";
	$tXphRmk 			= "";
	$tXphStaDoc 		= "";
	$tXphStaApv 		= "";
	$nXphStaDocAct 		= "";

	//TAPTOrdHDSpl
	$tXphRefVehID 		= "";
	$tXphRefInvNo		= "";
	$nXphCrTerm 		= "";
	$tXphQtyAndTypeUnit	= "";
	$tXphTaxAdd			= "";
	$tXphShipAdd		= "";	
	$dXphDueDate		= "";
	$dXphTnfDate		= "";
	$dXphBillDue		= "";
	$tXphDstPaid		= "";
	$tXphCtrName		= "";

	$tRoute         	= "POEventAdd";

	$nAutStaEdit = 0; //Event Control
}
?>

<input type="hidden" id="ohdPOAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
<input type="hidden" id="ohdXphStaApv" value="<?php echo $tXphStaApv; ?>">
<input type="hidden" id="ohdXphStaDoc" value="<?php echo $tXphStaDoc; ?>">
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPO">
<button style="display:none" type="submit" id="obtSubmitPO" onclick="JSnAddEditPO('<?php echo $tRoute; ?>')"></button>
<input type="text" class="xCNHide" id="ohdSesUsrBchCode" value="<?php echo $this->session->userdata("tSesUsrBchCode"); ?>"> 
<input type="text" class="xCNHide" id="ohdBchCode" value="<?php echo $tBchCode; ?>"> 
<input type="text" class="xCNHide" id="ohdOptAlwSavQty0" name="ohdOptAlwSavQty0" value="<?php echo $nOptDocSave?>">
<input type="text" class="xCNHide" id="ohdOptScanSku" name="ohdOptScanSku" value="<?php echo $nOptScanSku?>">
	
	<div class="row">
	<div class="col-md-4">
		<div class="panel panel-default" style="margin-bottom: 25px;"> 
			<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOStatus'); ?></label>
				<a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvDataPromotion" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
				<div class="panel-body xCNPDModlue">
						<?php ?>
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?php echo language('document/purchaseorder/purchaseorder', 'tPOApproved'); ?></label>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODocNo'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xWTooltipsBT" id="oetXphDocNo" name="oetXphDocNo" maxlength="10" value="<?php echo $tXphDocNo; ?>" onkeyup="JStCMNCheckDuplicateCodeMaster('oetXphDocNo','JSvCallPagePOEdit','TAPTOrdHD','FTXphDocNo')" data-validate="<?php echo language('document/purchaseorder/purchaseorder', 'tPOPlsEnterOrRunDocNo'); ?>" placeholder="#####">
								<?php if(@$tXphDocNo){
									$tStaDisabled = 'disabled' ;
								}else{
									$tStaDisabled = '' ;
								}?>
								<span class="input-group-btn">
									<button class="btn xCNBtnGenCode" type="button" onclick="JStGeneratePOCode()" <?php echo $tStaDisabled; ?>>
										<i class="fa fa-magic"></i>
									</button>
								</span>
							</div>
						</div>
						<!-- <div class="form-group">
							<label class="xCNLabelFrm">วันที่เอกสาร</label>
							<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphDocDate" name="oetXphDocDate" value="<?php echo $dXphDocDate; ?>" data-validate="Plese Enter">
							<img class="xCNIconBrowse" src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
						</div> -->

						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphDocDate" name="oetXphDocDate" value="<?php echo $dXphDocDate; ?>" data-validate="<?php echo language('document/purchaseorder/purchaseorder', 'tPOPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXphDocDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODepart'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="ohdDptCode" name="ohdDptCode" maxlength="5" value="<?php echo $tDptCode;?>">
								<label><?php echo $tDptName?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?php echo $tCreateBy?>">
								<label><?php echo $tUsrNameCreateBy?></label>
							</div>
						</div>
						<?php if($tXphDocNo != ''){?>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOApvBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetXphApvCode" name="oetXphApvCode" maxlength="20" value="<?php echo $tXphApvCode?>">
								<label><?php echo $tXphUsrNameApv?></label>
							</div>
						</div>
						<?php } ?>
				</div>
			</div>    
		</div>


		<div class="panel panel-default" style="margin-bottom: 25px;">
			<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOWarehouse'); ?></label>
				<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvWarehouse" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvWarehouse" class="panel-collapse collapse in" role="tabpanel">
				<div class="panel-body xCNPDModlue">
						
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShop'); ?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetShpCode" name="oetShpCode" maxlength="5" value="<?php echo $tShpCode?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetShpCodeName" name="oetShpCodeName" value="<?php echo $tShpName?>" readonly>
								<span class="input-group-btn">
									<button id="oimPOBrowseShp" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOWarehouse'); ?></label>
							<div class="input-group">
								<input type="text" class="input100 xCNHide" id="ohdWahCode" name="ohdWahCode" maxlength="5" value="<?php echo $tWahCode?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetWahCodeName" name="oetWahCodeName" value="<?php echo $tWahName; ?>" readonly>
								<span class="input-group-btn">
									<button id="oimPmtBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
				</div>
			</div> 
		</div>


		<div class="panel panel-default" style="margin-bottom: 25px;">
			<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefDoc'); ?></label>
				<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataGeneralInfo" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvDataGeneralInfo" class="panel-collapse collapse in" role="tabpanel">
				<div class="panel-body xCNPDModlue">
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefExt'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" id="oetXphRefExt" name="oetXphRefExt" maxlength="20" value="<?php echo $tXphRefExt?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefExtDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphRefExtDate" name="oetXphRefExtDate" value="<?php echo $dXphRefExtDate?>">
										<span class="input-group-btn">
											<button id="obtXphRefExtDate" type="button" class="btn xCNBtnDateTime">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefInt'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" id="oetXphRefInt" name="oetXphRefInt" maxlength="20" value="<?php echo $tXphRefInt?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefIntDate'); ?></label>
									<div class="input-group">
										<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphRefIntDate" name="oetXphRefIntDate" value="<?php echo $dXphRefIntDate?>">
										<span class="input-group-btn">
											<button id="obtXphRefIntDate" type="button" class="btn xCNBtnDateTime">
												<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						
						<div class="row">
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefVehID'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXphRefVehID" name="oetXphRefVehID" value="<?php echo $tXphRefVehID?>">
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefInvNo'); ?></label>
									<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXphRefInvNo" name="oetXphRefInvNo" value="<?php echo $tXphRefInvNo?>">
								</div>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								
							</div>
							<div class="col-md-6">
								<div class="form-group">
									<label class="fancy-checkbox">
										<input type="checkbox" class="ocbListItem" id="ocbXphStaDocAct" name="ocbXphStaDocAct" maxlength="1" <?php echo $nXphStaDocAct == '' ? 'checked' : $nXphStaDocAct == '1' ? 'checked' : '0'; ?> >
										<span>&nbsp;</span>
										<span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOStaDocAct'); ?></span>
									</label>
								</div>
							</div>
						</div>
				</div>
			</div>    
		</div>

		<div class="panel panel-default" style="margin-bottom: 25px;">
			<div id="odvHeadDateTime" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOPaymentAndAddress'); ?></label>
				<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvPaymentAndAddress" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvPaymentAndAddress" class="panel-collapse collapse" role="tabpanel">
				<div class="panel-body xCNPDModlue">
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOCshOrCrd'); ?></label>
								<input type="text" class="xCNHide" id="ohdXphCshOrCrd" name="ohdXphCshOrCrd" maxlength="1" value="<?php echo $tXphCshOrCrd?>">
								<select class="selectpicker form-control" id="ostXphCshOrCrd" name="ostXphCshOrCrd">
									<option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOCash'); ?></option>
									<option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOCredit'); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOCrTerm'); ?></label>
								<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXphCrTerm" name="oetXphCrTerm" value="<?php echo  ($nXphCrTerm != '' ? $nXphCrTerm : 0) ?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORteName'); ?></label>
								<div class="input-group">
									<input type="text" class="form-control xCNHide" id="ohdXphRteFac" name="ohdXphRteFac" maxlength="18" value="<?php echo $cXphRteFac?>">
									<input class="form-control xCNHide" type="text" id="oetRteCode" name="oetRteCode" maxlength="5" value="<?php echo $tRteCode?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetRteName" name="oetRteName" value="<?php echo $tRteCode?>" readonly>
									<span class="input-group-btn">
										<button id="oimPOBrowseRate" type="button" class="btn xCNBtnBrowseAddOn">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<input type="text" class="form-control xCNHide" id="ohdVatCode" name="ohdVatCode" maxlength="5" value="<?php echo $tVatCode?>">
								<input type="text" class="form-control xCNHide" id="ohdXphVATRate" name="ohdXphVATRate" maxlength="18" value="<?php echo $cXphVATRate?>">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOVATInOrEx'); ?></label>
								<input type="text" class="xCNHide" id="ohdXphVATInOrEx" name="ohdXphVATInOrEx" maxlength="1" value="<?php echo $tXphVATInOrEx?>">
								<select class="selectpicker form-control" id="ostXphVATInOrEx" name="ostXphVATInOrEx" maxlength="1">
									<option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOVATIn'); ?></option>
									<option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOVATEx'); ?></option>
								</select>
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOQtyAndTypeUnit'); ?></label>
								<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXphQtyAndTypeUnit" name="oetXphQtyAndTypeUnit" value="<?php echo $tXphQtyAndTypeUnit?>">
							</div>
						</div>
					</div>
					<div class="row">
						<div class="col-md-12">
							<input tyle="text" class="xCNHide" id="ohdXphShipAdd" name="ohdXphShipAdd" value="<?php echo $tXphShipAdd?>">
							<button type="button" id="obtPOBrowseShipAdd" class="btn btn-primary" style="font-size: 17px;">+ <?php echo language('document/purchaseorder/purchaseorder', 'tPOShipAddress'); ?></button>

							<input tyle="text" class="xCNHide" id="ohdXphTaxAdd" name="ohdXphTaxAdd" value="<?php echo $tXphTaxAdd?>">
							<button type="button" id="obtPOBrowseTaxAdd" class="btn btn-primary" style="float: right;font-size: 17px;">+ <?php echo language('document/purchaseorder/purchaseorder', 'tPOTaxAddress'); ?></button>
						</div>
					</div>
				</div>
			</div>    
		</div>

		<div class="panel panel-default" style="margin-bottom: 60px;">
			<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOConditionAndAllow'); ?></label>
				<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvConditionAndAllow" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvConditionAndAllow" class="panel-collapse collapse" role="tabpanel">
				<div class="panel-body xCNPDModlue">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODueDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphDueDate" name="oetXphDueDate" value="<?php echo $dXphDueDate?>">
								<span class="input-group-btn">
									<button id="obtXphDueDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTnfDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphTnfDate" name="oetXphTnfDate" value="<?php echo $dXphTnfDate?>">
								<span class="input-group-btn">
									<button id="obtXphTnfDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOBillDue'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXphBillDue" name="oetXphBillDue" value="<?php echo $dXphBillDue?>">
								<span class="input-group-btn">
									<button id="obtXphBillDue" type="button" class="btn xCNBtnDateTime">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODstPaid'); ?></label>
							<input type="text" class="xCNHide" id="ohdXphDstPaid" name="ohdXphDstPaid" value="<?php echo $tXphDstPaid?>">
							<select class="selectpicker form-control" id="ostXphDstPaid" name="ostXphDstPaid" maxlength="1">
								<option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOFreightPrepaid'); ?></option>
								<option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOFreightCollect'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOCtrName'); ?></label>
							<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetXphCtrName" name="oetXphCtrName" value="<?php echo $tXphCtrName?>">
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOUsrKey'); ?></label>
							<input type="text" class="form-control xCNInputWithoutSpc" maxlength="100" id="oetUsrCode" name="oetUsrCode" maxlength="20" value="<?php echo $tUsrCode?>" disabled="disabled">
						</div> 
						<!-- 
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOUsrSale'); ?></label>
							<div class="input-group">
								<input class="form-control" type="hidden" id="oetSpnCode" name="oetSpnCode" maxlength="20" value="<?php echo $tSpnCode?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetSpnName" name="oetSpnName" value="<?php echo $tSpnName?>" readonly>
								<span class="input-group-btn">
									<button id="oimPOBrowseSpn" type="button" class="btn xCNBtnBrowseAddOn">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						เอาออกแล้ว พี่ที Confirm -->
				</div>
			</div>    
		</div>



		<!-- <div class="panel panel-default" style="margin-bottom: 60px;">
			<div id="odvHeadAllow" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
				<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOOptionDocument'); ?></label>
				<a class="xCNMenuplus collapsed" role="button" data-toggle="collapse" href="#odvOptionDocument" aria-expanded="true">
					<i class="fa fa-plus xCNPlus"></i>
				</a>
			</div>
			<div id="odvOptionDocument" class="panel-collapse collapse" role="tabpanel">
				<div class="panel-body xCNPDModlue">
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOOptDocSaveAlwOrdIs0'); ?></label>
							<select class="selectpicker form-control" id="ostOptAlwSavQty0" name="ostOptAlwSavQty0" maxlength="1">
								<option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOOptDocAlw'); ?></option>
								<option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOOptDocNotAlw'); ?></option>
							</select>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODataAddFormat'); ?></label>
							
							<select class="selectpicker form-control" id="ostOptScanSku" name="ostOptScanSku" maxlength="1">
								<option value="1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOOptDocAddQty'); ?></option>
								<option value="2"><?php echo language('document/purchaseorder/purchaseorder', 'tPOOptDocAddRow'); ?></option>
							</select>
						</div>
				</div>
			</div>    
		</div> -->

	</div>
	


	<div class="col-md-8" id="odvRightPanal">
		<!-- Suplier -->
		<div class="panel panel-default" style="margin-bottom: 25px;"> 
			<div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
				<div class="panel-body xCNPDModlue">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOSuplier'); ?></label>
						<div class="input-group">
							<input class="form-control" type="hidden" id="ohdOldSplCode" name="ohdOldSplCode" maxlength="20" value="<?php echo $tSplCode?>">
							<input class="form-control" type="hidden" id="oetOldSplName" name="oetOldSplName" maxlength="20" value="<?php echo $tSplName?>">
							<input class="form-control" type="hidden" id="oetSplCode" name="oetSplCode" maxlength="20" value="<?php echo $tSplCode?>">
							<input class="form-control xWPointerEventNone" type="text" id="oetSplName" name="oetSplName" value="<?php echo $tSplName?>" readonly>
							<span class="input-group-btn">
								<button id="oimPOBrowseSpl" type="button" class="btn xCNBtnBrowseAddOn">
									<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
								</button>
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<!-- Suplier -->

		<!-- Pdt -->
		<div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;"> 
			<div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
				<div class="panel-body xCNPDModlue">
					<div class="row" style="margin-top: 10px;">
						<div class="col-md-6">
							<div class="form-group">
								<div class="input-group">
									<input type="text" class="form-control" maxlength="100" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvDOCSearchPdtHTML()" placeholder="<?php echo language('document/purchaseorder/purchaseorder', 'tPOSearchPdt'); ?>">
									<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvPOScanPdtHTML()" placeholder="<?php echo language('document/purchaseorder/purchaseorder', 'tPOScanPdt'); ?>" style="display:none;" data-validate="ไม่พบข้อมูลที่แสกน">
									<span class="input-group-btn">
										<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
											<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvDOCSearchPdtHTML()">
												<img  src="<?php echo  base_url().'application/modules/common/assets/images/icons/search-24.png'?>" style="width:20px;">
											</button>
											<button id="oimMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvPOScanPdtHTML()">
												<img class="oimMngPdtIconScan" src="<?php echo  base_url().'application/modules/common/assets/images/icons/scanner.png'?>" style="width:20px;">
											</button>
											<button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
												<i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
											</button>
											<ul class="dropdown-menu" role="menu">
												<li id="oliBtnDeleteAll">
													<a id="oliMngPdtSearch"><label><?php echo language('document/purchaseorder/purchaseorder', 'tPOSearchPdt'); ?></label></a>
													<a id="oliMngPdtScan"><?php echo language('document/purchaseorder/purchaseorder', 'tPOScanPdt'); ?></a>
												</li>
											</ul>
										</div>
									</span>
								</div>
							</div>
						</div>
						<div class="col-md-6">
							<div class="form-group">
								<div style="position: absolute;right: 15px;top:-5px;">
									<button class="xCNBTNPrimeryPlus xCNDocBrowsePdt" onclick="JCNvPOBrowsePdt()" type="button">+</button>
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
									<div class="col-md-12" >
										
										<div id="odvRowMenu" class="row">
											<div class="custom-tabs-line tabs-line-bottom left-aligned">
												<div class="row">
													<div id="odvNavMenu" class="col-xs-12 col-sm-10 col-md-10 col-lg-10">
														<ul class="nav" role="tablist">
															<li id="oliPdtInfo1" class="xWMenu active" data-menutype="MN">
																<a role="tab" data-toggle="tab" data-target="#odvTabRemark" aria-expanded="true" style="padding: 4px 15px;"><?php echo language('document/purchaseorder/purchaseorder', 'tPORemark'); ?></a>
															</li>
															<li id="oliPdtInfo2" class="xWMenu" data-menutype="MN">
																<a role="tab" data-toggle="tab" data-target="#odvTabPdtImg" aria-expanded="false" style="padding: 4px 15px;"><?php echo language('document/purchaseorder/purchaseorder', 'tPOPdtImg'); ?></a>
															</li>
														</ul>
													</div>
												</div>
											</div>
										</div>
										<!-- Content tab -->
										<div id="odvRowContent" class="row">
											<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
												<div class="tab-content" style="height:295px;">
													<!-- Tab From Info -->
													<div id="odvTabRemark" class="tab-pane fade active in" style="padding:10px;">
														<div class="form-group">
															<!-- <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORemark'); ?></label> -->
															<textarea class="form-control" id="otaXphRmk" name="otaXphRmk" rows="10" maxlength="200" style="resize: none;height:270px;"><?php echo $tXphRmk?></textarea>
														</div>
													</div>
													<div id="odvTabPdtImg" class="tab-pane fade" style="padding:10px;">
														<div id="odvShowPdtImgScan">
															<img class="img-responsive xCNPdtImgScan" id="oimPdtImgScan" src="<?php echo base_url();?>application/modules/common/assets/images/Noimage.png">
															<div id="odvImageTumblr" style="padding-top:10px;overflow-x:auto;" class="table-responsive">
																	<!-- Image Panal HTML Ajax-->
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
										
									</div>
									<div class="col-md-12"  style="min-height:42px;border-top: 1px solid #dee2e6;">
										<label id="othFCXphGrandText" style="margin-top: 7px;margin-left: 10px;"></label>
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
														<div class="row">
															<div class="col-sm-4">
																<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTotalCash'); ?></label>
															</div>
															<div class="col-sm-8">
																
															</div>
														</div>
													</td>
													<td class="text-right">
														<label id="othFCXphTotal">-</label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left">
														<div class="row">
															<div class="col-sm-4">
																<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPODisChgTxt'); ?></label> 
															</div>
															<div class="col-sm-8">
																<div class="input-group">
																	<input type="text" class="form-control xCNDisable" id="oetFTXphDisChgTxt" name="oetFTXphDisChgTxt"  readonly>
																	<span class="input-group-btn">
																		<button id="oimPOBrowseHDDis" type="button" class="btn xCNBtnBrowseAddOn">
																			<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
																		</button>
																	</span>
																</div>
															</div>
														</div>
													</td>
													<td class="text-right">
														<label id="othFCXphDis">-</label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"> 
														<div class="row">
															<div class="col-sm-4">
																<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPORefAEAmt'); ?></label>
															</div>
															<div class="col-sm-8">
																<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="20" id="oetXphRefAEAmtInput" name="oetXphRefAEAmtInput"  onkeyup="JSvPOCallGetHDDisTableData()" onblur="JSxPOAdjInputFormat('oetXphRefAEAmtInput')" value="<?php echo  $cXphRefAEAmt != '' ? "".number_format($cXphRefAEAmt, $nOptDecimalShow, '.', ' ') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
															</div>
														</div>
													</td>
													<td class="text-right">
														<label id="othFCXphRefAEAmt">-</label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"><label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOAfDisChgAE'); ?></label></td>
													<td class="text-right">
														<label id="othFCXphAfDisChgAE">-</label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"><label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOVatable'); ?></label></td>
													<td class="text-right">
														<label id="othFCXphVatable">-</label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"> 
														<div class="row">
															<div class="col-sm-4">
																<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOVatRate'); ?></label>
															</div>
															<div class="col-sm-8">
																<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="10" id="oetXphVatRateInput" name="oetXphVatRateInput"  data-validate="Please Insert Vat." onkeyup="JSvPOCallGetHDDisTableData()" onblur="JSxPOAdjInputFormat('oetXphVatRateInput')" value="<?php echo  $cXphVATRate != '' ? "".number_format($cXphVATRate, $nOptDecimalShow, '.', ' ') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
															</div>
														</div>
													</td>
													<td class="text-right">
														<label id="othFCXphVat"><?php echo  $cXphVATRate != '0' ? "".number_format($cXphVATRate, $nOptDecimalShow, '.', ' ') : '-' ?></label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"><label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOGrandB4Wht'); ?></label></td>
													<td class="text-right">
														<label id="othFCXphGrandB4Wht">-</label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"> 
														<div class="row">
															<div class="col-sm-4">
																<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOWpTax'); ?></label>
															</div>
															<div class="col-sm-8">
																<input type="text" class="form-control xCNInputNumericWithDecimal" maxlength="10" id="oetFCXphWpTaxInput" name="oetFCXphWpTaxInput"  onkeyup="JSvPOCallGetHDDisTableData()" onblur="JSxPOAdjInputFormat('oetFCXphWpTaxInput')" value="<?php echo  $cXphWpTax != '' ? "".number_format($cXphWpTax, $nOptDecimalShow, '.', ' ') : number_format(0, $nOptDecimalShow, '.', ' ') ?>">
															</div>
														</div>
													</td>
													<td class="text-right">
														<label id="othFCXphWpTax"><?php echo  $cXphWpTax != '0' ? "".number_format($cXphWpTax, $nOptDecimalShow, '.', ' ') : '-' ?></label>
													</td>
												</tr>
												<tr>
													<td class="xCNTextDetail1 text-left"><label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tPOGrand'); ?></label></td>
													<td class="text-right">
														<label id="othFCXphGrand">-</label>
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
<div class="modal fade" id="odvPOBrowseShipAdd" style="">
	<div class="modal-dialog" style="width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/purchaseorder/purchaseorder', 'tPOShipAddress'); ?></label>
					</div>
					<div class="col-xs-12 col-md-6 text-right"> 
							<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPOAddShipAdd()"><?php echo language('common/main/main', 'tModalConfirm')?></button>  
							<button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button> 
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
											<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOAddInfo'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6 text-right">
											<a style="font-size: 14px !important;color: #179bfd;">
												<i class="fa fa-pencil" id="oliBtnEditShipAdd"><?php echo language('document/purchaseorder/purchaseorder', 'tPOChange'); ?></i>
											</a> 
										</div>
									</div>
							</div>
							<div>
								<div class="panel-body xCNPDModlue">
									<input type="text" class="xCNHide" id="ohdShipAddSeqNo">
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1No'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddAddV1No">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1Village'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1Soi">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1Soi'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1Village">-</label>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1Road'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1Road">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1SubDist'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1SubDist">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1DstCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1DstCode">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1PvnCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1PvnCode">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1PostCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1PostCode">-</label> 
										</div>
									</div>
								</div>
							</div>    
						</div>
					</div>
				</div>
				
			</div>
			
		</div>
	</div>
</div>


<div class="modal fade" id="odvPOBrowseTaxAdd" style="">
	<div class="modal-dialog" style="width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTaxAddress'); ?></label>
					</div>
					<div class="col-xs-12 col-md-6 text-right"> 
							<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnPOAddTaxAdd()"><?php echo language('common/main/main', 'tModalConfirm')?></button>  
							<button class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button> 
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
											<label class="xCNTextDetail1"><?php echo language('document/purchaseorder/purchaseorder', 'tPOTaxAddressInfo'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6 text-right">
											<a style="font-size: 14px !important;color: #179bfd;">
												<i class="fa fa-pencil" id="oliBtnEditTaxAdd"><?php echo language('document/purchaseorder/purchaseorder', 'tPOChange'); ?></i>
											</a> 
										</div>
									</div>
							</div>
							<div>
								<div class="panel-body xCNPDModlue">
									<input type="text" class="xCNHide" id="ohdTaxAddSeqNo">
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1No'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddAddV1No">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1Village'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1Soi">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1Soi'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1Village">-</label>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1Road'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1Road">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1SubDist'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1SubDist">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1DstCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1DstCode">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1PvnCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1PvnCode">-</label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'tBrowseADDV1PostCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospTaxAddV1PostCode">-</label> 
										</div>
									</div>
								</div>
							</div>    
						</div>
					</div>
				</div>
				
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

<div class="modal fade" id="odvModalEditPODisHD">
	<div class="modal-dialog xCNDisModal">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block"><label class="xCNLabelFrm"><?php echo language('common/main/main', 'tPODisEndOfBill'); ?></label></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tPODisType'); ?></label>
						<select class="selectpicker form-control" id="ostXphHDDisChgText" name="ostXphHDDisChgText">
							<option value="3"><?php echo  language('document/purchaseorder/purchaseorder','tDisChgTxt3')?></option>
							<option value="4"><?php echo  language('document/purchaseorder/purchaseorder','tDisChgTxt4')?></option>
							<option value="1"><?php echo  language('document/purchaseorder/purchaseorder','tDisChgTxt1')?></option>
							<option value="2"><?php echo  language('document/purchaseorder/purchaseorder','tDisChgTxt2')?></option>
						</select>
					</div>
					</div>
					<div class="col-md-4">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tPOValue'); ?></label>
						<input type="text" class="form-control xCNInputNumericWithDecimal" id="oetXddHDDis" name="oetXddHDDis" maxlength="11" placeholder="">
					</div>
					<div class="col-md-2">
					<div class="form-group">
						<button type="button" class="btn btn-primary xCNBtnAddDis" onclick="FSvPOAddHDDis()">
						<label class="xCNLabelAddDis">+</label>
						</button>
					</div>
					</div>
				</div>
        		<div id="odvHDDisListPanal"></div>
				<input type='hidden' id="ohdConfirmIDDelete">
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvPOPopupApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgApv')?></label>
			</div>
			<div class="modal-body">
                <p><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgWarningiApv')?></p>
                <ul>
                    <li><?php echo  language('document/purchaseorder/purchaseorder','tPOMsg1')?></li>
                    <li><?php echo  language('document/purchaseorder/purchaseorder','tPOMsg2')?></li>
                    <li><?php echo  language('document/purchaseorder/purchaseorder','tPOMsg3')?></li>
                    <li><?php echo  language('document/purchaseorder/purchaseorder','tPOMsg4')?></li>
                </ul>
                <p><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgCheckforacc')?></p>
                <p><strong><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgConfrimApv')?></strong></p>
			</div>
			<div class="modal-footer">
                <button onclick="JSnPOApprove(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvPOPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgCancel')?></label>
			</div>
			<div class="modal-body">
                <p id="obpMsgApv"><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgDocProcess')?></p>
                <p><strong><?php echo  language('document/purchaseorder/purchaseorder','tPOMsgCanCancel')?></strong></p>
			</div>
			<div class="modal-footer">
                <button onclick="JSnPOCancel(true)" type="button" class="btn xCNBTNPrimery">
					<?php echo language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script type="text/javascript">

/* Disabled Enter in Form */
$(document).keypress(
	function(event){
		if (event.which == '13') {
		event.preventDefault();
		}
	}
);

$(document).ready(function(){

	$('#oliMngPdtScan').click(function(){
		//Hide
		$('#oetSearchPdtHTML').hide();
		$('#oimMngPdtIconSearch').hide();
		//Show
		$('#oetScanPdtHTML').show();
		$('#oimMngPdtIconScan').show();
	});

	$('#oliMngPdtSearch').click(function(){
		//Hide
		$('#oetScanPdtHTML').hide();
		$('#oimMngPdtIconScan').hide();
		//Show
		$('#oetSearchPdtHTML').show();
		$('#oimMngPdtIconSearch').show();
	});

	$('.selectpicker').selectpicker();
	
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
	    autoclose: true,
        todayHighlight: true,
	});

	//DATE
	$('#obtXphDocDate').click(function(){
		event.preventDefault();
		$('#oetXphDocDate').datepicker('show');
	});

	$('#obtXphRefExtDate').click(function(){
		event.preventDefault();
		$('#oetXphRefExtDate').datepicker('show');
	});

	$('#obtXphRefIntDate').click(function(){
		event.preventDefault();
		$('#oetXphRefIntDate').datepicker('show');
	});

	$('#obtXphDueDate').click(function(){
		event.preventDefault();
		$('#oetXphDueDate').datepicker('show');
	});

	$('#obtXphTnfDate').click(function(){
		event.preventDefault();
		$('#oetXphTnfDate').datepicker('show');
	});

	$('#obtXphBillDue').click(function(){
		event.preventDefault();
		$('#oetXphBillDue').datepicker('show');
	});
	//DATE


	$('.xCNTimePicker').datetimepicker({
        format: 'LT'
	});
	
    $('.xWTooltipsBT').tooltip({'placement': 'bottom'});
	$('[data-toggle="tooltip"]').tooltip({'placement': 'top'});


	tSpmCode = $('#oetSpmCode').val();

  	$('#oimPOBrowseHDDis').click(function(ele){
    
			$('#odvModalEditPODisHD').modal('show');

			JSvPOCallGetHDDisTableData();

	});

	$('#obtPOBrowseShipAdd').click(function(ele){
		
		tBchCode = $('#ohdSesUsrBchCode').val();
		tXphShipAdd = $('#ohdXphShipAdd').val();
		
		JSvPOGetShipAddData(tBchCode,tXphShipAdd);
	});

	$('#obtPOBrowseTaxAdd').click(function(ele){
		
		tBchCode = $('#ohdSesUsrBchCode').val();
		tXphTaxAdd = $('#ohdXphTaxAdd').val();
		
		JSvPOGetTaxAddData(tBchCode,tXphTaxAdd);
	});

	
	$('#oetSplCode').change(function(){
		//Clear Modal Pdt เพื่อโหลดใหม่ตอนเปลี่ยน Spl
		$('#odvBrowsePdtPanal').html('');
	});

	//Set Session ว่าเป็น รวมในหรือแยกนอก
	$('#ostXphVATInOrEx').change(function(e){

		ptXphDocNo 	= $('#oetXphDocNo').val();
		tXphVATInOrEx 	= $('#ostXphVATInOrEx').val();

		//ล้าง HTML Modal Browse Product
		$('#odvBrowsePdtPanal').html('');
		$('#ohdXphVATInOrEx').val(tXphVATInOrEx);
		
		$.ajax({
            type: "POST",
            url: "POSetSessionVATInOrEx",
            data: {
					ptXphDocNo:ptXphDocNo,
					tXphVATInOrEx:tXphVATInOrEx
				},
            cache: false,
            Timeout: 0,
            success: function(tResult) {

				// console.log('set session done: '+tResult);
				JSvPOLoadPdtDataTableHtml();

            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
        });
	});

	$('#ostPmcGetCond').on('change', function (e) {
    var nSelected = $("option:selected", this);
    var nValue = this.value;
    	if(nValue == 1 || nValue == 3){
			// alert('ราคา')
			$('.xWCdGetValue').removeClass('xCNHide');
			$('.xWCdGetQty').addClass('xCNHide');
			$('.xWCdPerAvgDis').addClass('xCNHide');

		}else if(nValue == 2){
			// alert('จำนวน %')
			$('.xWCdGetValue').addClass('xCNHide');
			$('.xWCdGetQty').addClass('xCNHide');
			$('.xWCdPerAvgDis').removeClass('xCNHide');

		}else if(nValue == 4){
			// alert('จำนวน แต้ม')
			$('.xWCdGetValue').addClass('xCNHide');
			$('.xWCdGetQty').removeClass('xCNHide');
			$('.xWCdPerAvgDis').addClass('xCNHide');

		}

		$('#oetPmcGetQty').val('');
		$('#oetPmcGetValue').val('');
		$('#oetPmcPerAvgDis').val('');

	});

	//Set DocDate is Date Now	
	dCurrentDate = new Date();
	if($('#oetXphDocDate').val()==''){
		$('#oetXphDocDate').datepicker("setDate",dCurrentDate); // Doc Date
	}
	if($('#oetXphTnfDate').val()==''){
		$('#oetXphTnfDate').datepicker("setDate",dCurrentDate); // 
	}
	if($('#oetXphBillDue').val()==''){
		$('#oetXphBillDue').datepicker("setDate",dCurrentDate); // 
	}

	//Config Option ScanSku
	// nOptScanSku = $('#ohdOptScanSku').val();
	// $('#ostOptScanSku').val(nOptScanSku).attr('selected',true).trigger('change');

	//Config Option DocSave
	// nOptAlwSavQty0 = $('#ohdOptAlwSavQty0').val();
	// $('#ostOptAlwSavQty0').val(nOptAlwSavQty0).attr('selected',true).trigger('change');

});



//Lang Edit In Browse
var nLangEdits = <?php echo $this->session->userdata("tLangEdit")?>;
//Set Option Browse -----------
//Option Depart
var oPmhBrowseDepart = {
    Title : ['pos5/user','tBrowseDPTTitle'],
    Table:{Master:'TCNMUsrDepart',PK:'FTDptCode'},
    Join :{
        Table:	['TCNMUsrDepart_L'],
        On:['TCNMUsrDepart_L.FTDptCode = TCNMUsrDepart.FTDptCode AND TCNMUsrDepart_L.FNLngID = '+nLangEdits,]
	},
    GrideView:{
        ColumnPathLang	: 'pos5/user',
        ColumnKeyLang	: ['tBrowseDPTCode','tBrowseDPTName'],
        DataColumns		: ['TCNMUsrDepart.FTDptCode','TCNMUsrDepart_L.FTDptName'],
        ColumnsSize     : ['10%','75%'],
        DataColumnsFormat : ['',''],
        WidthModal      : 50,
        Perpage			: 10,
		OrderBy			: ['TCNMUsrDepart.FTDptCode'],
		SourceOrder		: "ASC"
    },
    CallBack:{
        ReturnType	: 'S',
        Value		: ["oetPmhDepartCode","TCNMUsrDepart.FTDptCode"],
		Text		: ["oetPmhDepartName","TCNMUsrDepart_L.FTDptName"],
    },
    RouteAddNew : 'department',
    BrowseLev : nStaPOBrowseType
}
//Option Depart

//Option Zone
var oPmhBrowseZone = {
	Title : ['pos5/zone','tZNESubTitle'],
	Table:{Master:'TCNMZone',PK:'FTZneCode'},
	Join :{
		Table:	['TCNMZone_L'],
		On:['TCNMZone_L.FTZneCode = TCNMZone.FTZneCode AND TCNMZone_L.FNLngID = '+nLangEdits,]
	},
	Filter:{
		Selector:'oetBchAreCode',
		Table:'TCNMZone',
        Key:'FTAreCode'
	},
	GrideView:{
		ColumnPathLang	: 'pos5/zone',
		ColumnKeyLang	: ['tZNECode','tZNEName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMZone.FTZneCode','TCNMZone_L.FTZneName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMZone.FTZneCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetPmhZneTo","TCNMZone.FTZneCode"],
		Text		: ["oetPmhZneToName","TCNMZone_L.FTZneName"],
	},

	RouteAddNew : 'zone',
	BrowseLev : nStaPOBrowseType
}
//Option Zone
//Option Branch
var oPmhBrowseBranch = {
	
	Title : ['pos5/branch','tBCHTitle'],
	Table:{Master:'TCNMBranch',PK:'FTBchCode'},
	Join :{
		Table:	['TCNMBranch_L'],
		On:['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'pos5/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMBranch_L.FTBchName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetPmhBchTo","TCNMBranch.FTBchCode"],
		Text		: ["oetPmhBchToName","TCNMBranch_L.FTBchName"],
	},
	RouteFrom : 'promotion',
	RouteAddNew : 'branch',
	BrowseLev : nStaPOBrowseType
}
//Option Branch
//Option Customer Group
var oPmhBrowseCstGrp = {
	
	Title : ['pos5/branch','tBCHTitle'],
	Table:{Master:'TCNMCstGrp',PK:'FTCgpCode'},
	Join :{
		Table:	['TCNMCstGrp_L'],
		On:['TCNMCstGrp_L.FTCgpCode = TCNMCstGrp.FTCgpCode AND TCNMCstGrp_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'pos5/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMCstGrp.FTCgpCode','TCNMCstGrp_L.FTCgpName'],
		DataColumnsFormat : ['',''],
		Perpage			: 5,
		OrderBy			: ['TCNMCstGrp_L.FTCgpName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetPmgCode","TCNMCstGrp.FTCgpCode"],
		Text		: ["oetPmgCodeName","TCNMCstGrp_L.FTCgpName"],
	},
	RouteAddNew : 'customergroup',
	BrowseLev : nStaPOBrowseType
}
//Option Customer Group
//Option Suplier
var oPOBrowseSpl = {
	
	Title : ['supplier/supplier/supplier','tSPLTitle'],
	Table:{Master:'TCNMSpl',PK:'FTSplCode'},
	Join :{
		Table:	['TCNMSpl_L','TCNMSplCredit'],
		On:['TCNMSpl_L.FTSplCode = TCNMSpl.FTSplCode AND TCNMSpl_L.FNLngID = '+nLangEdits,
			'TCNMSpl_L.FTSplCode = TCNMSplCredit.FTSplCode'
		]
	},
	Where:{
            Condition : ["AND TCNMSpl.FTSplStaActive = '1' "]
        },
	GrideView:{
		ColumnPathLang	: 'supplier/supplier/supplier',
		ColumnKeyLang	: ['tSPLTBCode','tSPLTBName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMSpl.FTSplCode','TCNMSpl_L.FTSplName','TCNMSplCredit.FNSplCrTerm','TCNMSplCredit.FCSplCrLimit','TCNMSpl.FTSplStaVATInOrEx','TCNMSplCredit.FTSplTspPaid'],
		DataColumnsFormat : ['',''],
		DisabledColumns	:[2,3,4,5],
		Perpage			: 5,
		OrderBy			: ['TCNMSpl_L.FTSplName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetSplCode","TCNMSpl.FTSplCode"],
		Text		: ["oetSplName","TCNMSpl_L.FTSplName"],
	},
	NextFunc:{
		FuncName:'JSxPOGetDataToFillSpl',
		ArgReturn:['FNSplCrTerm','FCSplCrLimit','FTSplStaVATInOrEx','FTSplTspPaid','FTSplCode','FTSplName']
    },
	RouteAddNew : 'supplier',
	BrowseLev : nStaPOBrowseType

}
//Option Suplier

//Option Suplier
var oPOBrowseShp = {

	Title : ['company/shop/shop','tSHPTitle'],
	Table:{Master:'TCNMShop',PK:'FTShpCode'},
	Join :{
		Table:	['TCNMShop_L','TCNMWaHouse_L'],
		On:['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = '+nLangEdits,
			'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FNLngID= '+nLangEdits
		]
	},
	GrideView:{
		ColumnPathLang	: 'company/branch/branch',
		ColumnKeyLang	: ['tBCHCode','tBCHName'],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMShop.FTShpCode','TCNMShop_L.FTShpName','TCNMShop.FTWahCode','TCNMWaHouse_L.FTWahName'],
		DataColumnsFormat : ['','','',''],
		DisabledColumns	:[2,3],
		Perpage			: 5,
		OrderBy			: ['TCNMShop_L.FTShpName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetShpCode","TCNMShop.FTShpCode"],
		Text		: ["oetShpCodeName","TCNMShop_L.FTShpName"],
	},
	NextFunc:{
		FuncName:'JSxPOGetWahFormShop',
		ArgReturn:['FTWahCode','FTWahName']
    },
	RouteAddNew : 'shop',
	BrowseLev 	: nStaPOBrowseType

}
//Option Suplier

//Option WareHouse
var oPOBrowseWah = {
	Title : ['company/warehouse/warehouse','tWAHTitle'],
	Table:{Master:'TCNMWaHouse',PK:'FTWahCode'},
	Join :{
		Table:	['TCNMWaHouse_L'],
		On:['TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = '+nLangEdits,]
	},
	// Where :{
	// Condition : ["AND TCNMWaHouse.FTWahStaType = '3' "]
	// },
	GrideView:{
		ColumnPathLang	: 'company/warehouse/warehouse',
		ColumnKeyLang	: ['tWahCode','tWahName'],
		DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
		DataColumnsFormat : ['',''],
		ColumnsSize     : ['15%','75%'],
		Perpage			: 5,
		WidthModal      : 50,
		OrderBy			: ['TCNMWaHouse_L.FTWahName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["ohdWahCode","TCNMWaHouse.FTWahCode"],
		Text		: ["oetWahCodeName","TCNMWaHouse_L.FTWahName"],
	},

	RouteAddNew : 'warehouse',
	BrowseLev : nStaPOBrowseType
}
//Option WareHouse

//option Rate 
var oPOBrowseRate = {
	Title : ['company/company/company','tBrowseRTETitle'],
	Table:{Master:'TFNMRate',PK:'FTRteCode'},
	Join :{
		Table:	['TFNMRate_L'],
		On:['TFNMRate_L.FTRteCode = TFNMRate.FTRteCode AND TFNMRate_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'company/company/company',
		ColumnKeyLang	: ['tBrowseRTECode','tBrowseRTEName'],
		DataColumns		: ['TFNMRate.FTRteCode','TFNMRate_L.FTRteName'],
		DataColumnsFormat : ['',''],
		ColumnsSize     : ['15%','75%'],
		Perpage			: 10,
		WidthModal      : 50,
		OrderBy			: ['TFNMRate.FTRteCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetRteCode","TFNMRate.FTRteCode"],
		Text		: ["oetRteName","TFNMRate.FTRteCode"],
	},
	RouteAddNew : 'rate',
	BrowseLev : nStaPOBrowseType
}
//option Rate 
//Option SalePerson
var oPOBrowseSpn = {
	
	Title : ['pos5/saleperson','tSPNTitle'],
	Table:{Master:'TCNMSpn',PK:'FTSpnCode'},
	Join :{
		Table:	['TCNMSpn_L'],
		On:['TCNMSpn_L.FTSpnCode = TCNMSpn.FTSpnCode AND TCNMSpn_L.FNLngID = '+nLangEdits,]
	},
	GrideView:{
		ColumnPathLang	: 'pos5/saleperson',
		ColumnKeyLang	: ['tSPNCode','tSPNName','','',''],
		ColumnsSize     : ['15%','75%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMSpn.FTSpnCode','TCNMSpn_L.FTSpnName'],
		DataColumnsFormat : ['',''],
		DisabledColumns	:[2,3,4],
		Perpage			: 5,
		OrderBy			: ['TCNMSpn_L.FTSpnName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["oetSpnCode","TCNMSpn.FTSpnCode"],
		Text		: ["oetSpnName","TCNMSpn_L.FTSpnName"],
	},
	RouteAddNew : 'suplier',
	BrowseLev : nStaPOBrowseType

}
//Option SalePerson
//option Ship Address 
var oPOBrowseShipAdd = {
	Title : ['document/purchaseorder/purchaseorder','tBrowseADDTitle'],
	Table:{Master:'TCNMAddress_L',PK:'FNAddSeqNo'},
	Where :{
		Condition : ['AND TCNMAddress_L.FNLngID='+nLangEdits, 
		]
	},
	GrideView:{
		ColumnPathLang	: 'document/purchaseorder/purchaseorder',
		ColumnKeyLang	: ['tBrowseADDBch','tBrowseADDSeq','tBrowseADDV1No','tBrowseADDV1Soi','tBrowseADDV1Village','tBrowseADDV1Road','tBrowseADDV1SubDist','tBrowseADDV1DstCode','tBrowseADDV1PvnCode','tBrowseADDV1PostCode'],
		DataColumns		: ['TCNMAddress_L.FTAddRefCode','TCNMAddress_L.FNAddSeqNo','TCNMAddress_L.FTAddV1No','TCNMAddress_L.FTAddV1Soi','TCNMAddress_L.FTAddV1Village','TCNMAddress_L.FTAddV1Road','TCNMAddress_L.FTAddV1SubDist','TCNMAddress_L.FTAddV1DstCode','TCNMAddress_L.FTAddV1PvnCode','TCNMAddress_L.FTAddV1PostCode'],
		DataColumnsFormat : ['','','','','','','','','',''],
		ColumnsSize     : [''],
		Perpage			: 10,
		WidthModal      : 50,
		OrderBy			: ['TCNMAddress_L.FTAddRefCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["ohdShipAddSeqNo","TCNMAddress_L.FNAddSeqNo"],
		Text		: ["ohdShipAddSeqNo","TCNMAddress_L.FNAddSeqNo"],
	},
	NextFunc:{
		FuncName:'JSxPOAftSelectShipAddress',
		ArgReturn:['FTAddRefCode','FNAddSeqNo']
    },
	RouteAddNew : 'address',
	BrowseLev : nStaPOBrowseType
}
//option Ship Address 
//option Tax Address 
var oPOBrowseTaxAdd = {
	Title : ['document/purchaseorder/purchaseorder','tBrowseADDTitle'],
	Table:{Master:'TCNMAddress_L',PK:'FNAddSeqNo'},
	Where :{
		Condition : ['AND TCNMAddress_L.FNLngID='+nLangEdits, 
		]
	},
	GrideView:{
		ColumnPathLang	: 'document/purchaseorder/purchaseorder',
		ColumnKeyLang	: ['tBrowseADDBch','tBrowseADDSeq','tBrowseADDV1No','tBrowseADDV1Soi','tBrowseADDV1Village','tBrowseADDV1Road','tBrowseADDV1SubDist','tBrowseADDV1DstCode','tBrowseADDV1PvnCode','tBrowseADDV1PostCode'],
		DataColumns		: ['TCNMAddress_L.FTAddRefCode','TCNMAddress_L.FNAddSeqNo','TCNMAddress_L.FTAddV1No','TCNMAddress_L.FTAddV1Soi','TCNMAddress_L.FTAddV1Village','TCNMAddress_L.FTAddV1Road','TCNMAddress_L.FTAddV1SubDist','TCNMAddress_L.FTAddV1DstCode','TCNMAddress_L.FTAddV1PvnCode','TCNMAddress_L.FTAddV1PostCode'],
		DataColumnsFormat : ['','','','','','','','','',''],
		ColumnsSize     : [''],
		Perpage			: 10,
		WidthModal      : 50,
		OrderBy			: ['TCNMAddress_L.FTAddRefCode'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'S',
		Value		: ["ohdTaxAddSeqNo","TCNMAddress_L.FNAddSeqNo"],
		Text		: ["ohdTaxAddSeqNo","TCNMAddress_L.FNAddSeqNo"],
	},
	NextFunc:{
		FuncName:'JSxPOAftSelectTaxAddress',
		ArgReturn:['FTAddRefCode','FNAddSeqNo']
    },
	RouteAddNew : 'rate',
	BrowseLev : nStaPOBrowseType
}
//option Tax Address 



//Event Browse
$('#oimPmtBrowseDepart').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPmhBrowseDepart');});
$('#oimPmhBrowseZone').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPmhBrowseZone');});
$('#oimPmhBrowseBranch').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPmhBrowseBranch');});
$('#oimPmtBrowseCstGrp').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPmhBrowseCstGrp');});
$('#oimPOBrowseSpl').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPOBrowseSpl');});
$('#oimPOBrowseShp').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPOBrowseShp');});
$('#oimPmtBrowseWah').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPOBrowseWah');});
$('#oimPOBrowseRate').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPOBrowseRate');});
$('#oimPOBrowseSpn').click(function(){ localStorage.GrpBothNumItem = ''; JCNxBrowseData('oPOBrowseSpn');});

//Event Browse ShipAdd
$('#oliBtnEditShipAdd').click(function(){ JCNxBrowseData('oPOBrowseShipAdd'); });

//Event Browse TaxAdd
$('#oliBtnEditTaxAdd').click(function(){ JCNxBrowseData('oPOBrowseTaxAdd'); });


//Option Promotion GrpBuy
var oPOBrowsePdt = {
	
	Title : ['product/product/product','tPDTTitle'],
	Table:{Master:'TCNMPdt',PK:'FTPdtCode'},
	Join :{
		Table:	['TCNMPdt_L','TCNMPdtPackSize','TCNMPdtUnit_L','TCNMPdtBar','TCNMPdtSpl','TCNTPdtPrice4PDT'],
		On:['TCNMPdt_L.FTPdtCode 			= 	TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = '+nLangEdits,
			"TCNMPdt.FTPdtCode				= 	TCNMPdtPackSize.FTPdtCode AND TCNMPdtPackSize.FCPdtUnitFact = '1'",
			'TCNMPdtPackSize.FTPunCode		= 	TCNMPdtUnit_L.FTPunCode AND TCNMPdtUnit_L.FNLngID='+nLangEdits,
			'TCNMPdt.FTPdtCode				= 	TCNMPdtBar.FTPdtCode AND TCNMPdtPackSize.FTPunCode = TCNMPdtBar.FTPunCode',
			'TCNMPdt.FTPdtCode				= 	TCNMPdtSpl.FTPdtCode',
			'TCNTPdtPrice4PDT.FTPdtCode	= 	TCNMPdt.FTPdtCode  AND TCNTPdtPrice4PDT.FTPunCode  = TCNMPdtPackSize.FTPunCode AND TCNTPdtPrice4PDT.FTPghDocType = 1 AND TCNTPdtPrice4PDT.FDPghDStart <= GETDATE()',
			]
	},
	Where:{
		Condition : ["AND TCNMPdt.FTPdtType IN('1','2','4') AND TCNMPdt.FTPdtStaActive='1' AND TCNMPdt.FTPdtForSystem = '1' AND TCNMPdt.FTPdtStaActive = '1' "]
	},
	Filter:{
		Selector:'oetSplCode',
		Table:'TCNMPdtSpl',
        Key:'FTSplCode'
	},
	GrideView:{
		ColumnPathLang	: 'pos5/product',
		ColumnKeyLang	: ['tPDTCode','tPDTName','tPDTTBUnit','tPDTTBPrice',''],
		ColumnsSize     : ['15%','25%','20%','20%'],
        WidthModal      : 50,
		DataColumns		: ['TCNMPdt.FTPdtCode','TCNMPdt_L.FTPdtName','TCNMPdtUnit_L.FTPunName','TCNTPdtPrice4PDT.FCPgdPriceRET','TCNMPdtUnit_L.FTPunCode'],
		DataColumnsFormat : ['','','',''],
		DisabledColumns	:[4],
		Perpage			: 10,
		OrderBy			: ['TCNMPdt_L.FTPdtName'],
		SourceOrder		: "ASC"
	},
	CallBack:{
		ReturnType	: 'M',
		StaDoc		: '1',
		StaSingItem : '1',
		Value		: ["ohdPOPdtCode","TCNMPdt.FTPdtCode"],
		Text		: ["ohdPOPdtName","TCNMPdt_L.FTPdtName"],
		
	},
	BrowsePdt : 1,
	NextFunc:{
		FuncName:'JSxPOAddPdtInRow',
		ArgReturn:['FTPdtCode','FTPunCode']
    },
	RouteAddNew : 'product',
	BrowseLev : nStaPOBrowseType,
	DebugSQL : 0,
}
//Option Promotion GrpBuy

//Event Browse
$('#obtPOBrowsePdt').click(function(){ JCNxBrowseProductData('oPOBrowsePdt');});


// put ค่าจาก Modal ลง Input หน้า Add
function JSnPOAddShipAdd(){
	tShipAddSeqNoSelect = $('#ohdShipAddSeqNo').val();
	$('#ohdXphShipAdd').val(tShipAddSeqNoSelect);

	//Auto เลือก ถ้าเป็นค่าว่าง
	tXphTaxAdd = $('#ohdXphTaxAdd').val();
	if(tXphTaxAdd == ''){
		$('#ohdXphTaxAdd').val(tShipAddSeqNoSelect);
	}

	$('#odvPOBrowseShipAdd').modal('toggle');
}

// put ค่าจาก Modal ลง Input หน้า Add
function JSnPOAddTaxAdd(){
	tTaxAddSeqNoSelect = $('#ohdTaxAddSeqNo').val();
	$('#ohdXphTaxAdd').val(tTaxAddSeqNoSelect);

	//Auto เลือก ถ้าเป็นค่าว่าง
	tXphShipAdd = $('#ohdXphShipAdd').val();
	if(tXphShipAdd == ''){
		$('#ohdXphShipAdd').val(tTaxAddSeqNoSelect);
	}

	$('#odvPOBrowseTaxAdd').modal('toggle');
}


//Get ข้อมูล Address มาใส่ modal แบบ Array
function JSvPOGetShipAddData(tBchCode,tXphShipAdd){
	
	$.ajax({
            type: "POST",
            url: "POGetAddress",
            data: {
					tBchCode:tBchCode,
					tXphShipAdd:tXphShipAdd
				},
            cache: false,
            Timeout: 0,
            success: function(tResult) {

				aData = JSON.parse(tResult);

				if(aData != 0){
					$('#ospShipAddAddV1No').text(aData[0]['FTAddV1No']);
					$('#ospShipAddV1Soi').text(aData[0]['FTAddV1Soi']);
					$('#ospShipAddV1Village').text(aData[0]['FTAddV1Village']);
					$('#ospShipAddV1Road').text(aData[0]['FTAddV1Road']);
					$('#ospShipAddV1SubDist').text(aData[0]['FTSudName']);
					$('#ospShipAddV1DstCode').text(aData[0]['FTDstName']);
					$('#ospShipAddV1PvnCode').text(aData[0]['FTPvnName']);
					$('#ospShipAddV1PostCode').text(aData[0]['FTAddV1PostCode']);
				}else{
					$('#ospShipAddAddV1No').text('-');
					$('#ospShipAddV1Soi').text('-');
					$('#ospShipAddV1Village').text('-');
					$('#ospShipAddV1Road').text('-');
					$('#ospShipAddV1SubDist').text('-');
					$('#ospShipAddV1DstCode').text('-');
					$('#ospShipAddV1PvnCode').text('-');
					$('#ospShipAddV1PostCode').text('-');
				}

				//เอาค่าจาก input หลัก มาใส่ input ใน modal
				$('#ohdShipAddSeqNo').val(tXphShipAdd);
				//Show
				$('#odvPOBrowseShipAdd').modal('show');

            },
            error: function(jqXHR, textStatus, errorThrown) {

            }
		});
}


//Get ข้อมูล Address มาใส่ modal แบบ Array
function JSvPOGetTaxAddData(tBchCode,tXphTaxAdd){

		$.ajax({
			type: "POST",
			url: "POGetAddress",
			data: {
					tBchCode:tBchCode,
					tXphShipAdd:tXphTaxAdd
				},
			cache: false,
			Timeout: 0,
			success: function(tResult) {

				aData = JSON.parse(tResult);

				if(aData != 0){
					$('#ospTaxAddAddV1No').text(aData[0]['FTAddV1No']);
					$('#ospTaxAddV1Soi').text(aData[0]['FTAddV1Soi']);
					$('#ospTaxAddV1Village').text(aData[0]['FTAddV1Village']);
					$('#ospTaxAddV1Road').text(aData[0]['FTAddV1Road']);
					$('#ospTaxAddV1SubDist').text(aData[0]['FTSudName']);
					$('#ospTaxAddV1DstCode').text(aData[0]['FTDstName']);
					$('#ospTaxAddV1PvnCode').text(aData[0]['FTPvnName']);
					$('#ospTaxAddV1PostCode').text(aData[0]['FTAddV1PostCode']);
				}else{
					$('#ospTaxAddAddV1No').text('-');
					$('#ospTaxAddV1Soi').text('-');
					$('#ospTaxAddV1Village').text('-');
					$('#ospTaxAddV1Road').text('-');
					$('#ospTaxAddV1SubDist').text('-');
					$('#ospTaxAddV1DstCode').text('-');
					$('#ospTaxAddV1PvnCode').text('-');
					$('#ospTaxAddV1PostCode').text('-');
				}

				//เอาค่าจาก input หลัก มาใส่ input ใน modal
				$('#ohdTaxAddSeqNo').val(tXphTaxAdd);
				//Show
				$('#odvPOBrowseTaxAdd').modal('show');

			},
			error: function(jqXHR, textStatus, errorThrown) {

			}
		});
	

}


function JSxPOAftSelectShipAddress(poJsonData){
	
	tBchCode = $('#ohdBchCode').val();

	//ถ้าไม่มีการเลือก มาจะส่ง NULL
	if(poJsonData != 'NULL'){
		aData = JSON.parse(poJsonData);
		tAddBch 	= aData[0];
		tAddSeqNo 	= aData[1];
	}else{
		tAddBch 	= 0;
		tAddSeqNo 	= 0;
	}

	JSvPOGetShipAddData(tBchCode,tAddSeqNo);

}

function JSxPOAftSelectTaxAddress(poJsonData){

	tBchCode = $('#ohdBchCode').val();

	//ถ้าไม่มีการเลือก มาจะส่ง NULL
	if(poJsonData != 'NULL'){
		aData = JSON.parse(poJsonData);
		tAddBch 	= aData[0];
		tAddSeqNo 	= aData[1];
	}else{
		tAddBch 	= 0;
		tAddSeqNo 	= 0;
	}
	
	JSvPOGetTaxAddData(tBchCode,tAddSeqNo);

}


function JSxPOAddPdtInRow(poJsonData){

		for (var n = 0; n < poJsonData.length; n++) {
			
			tdVal = $('.nItem'+n).data('otrval')
			
			if(tdVal != '' && tdVal == undefined){
					
					nTRID = JCNnRandomInteger(100,1000000);

					aColDatas = JSON.parse(poJsonData[n]);
					tPdtCode = aColDatas[0];
					tPunCode = aColDatas[1];
					FSvPDTAddPdtIntoTableDT(tPdtCode,tPunCode);

			}
		}

}


//Function Call Edit Pdt set qty
function JSnEditDTRow(event){

		var tEditSeqNo = $(event).parents().eq(2).attr('data-seqno');
		
		$('.xWShowInLine'+tEditSeqNo).addClass('xCNHide');
		$('.xWEditInLine'+tEditSeqNo).removeClass('xCNHide');
		
		$(event).parents().eq(2).find('.xWPdtOlaShowQty').addClass('xCNHide')
        $(event).parents().eq(2).find('.xWPdtDivSetQty').removeClass('xCNHide')
		$(event).parents().eq(2).find('.xWPdtDivSetQty').find('.xWPdtSetInputQty').focus();
		
		$(event).parent().empty().append($('<img>')
								.attr('class','xCNIconTable')
								.attr('title','Save')
								.attr('src',tBaseURL+'/application/modules/common/assets/images/icons/save.png')
									.click(function(){
										JSnSaveDTEdit(this);
									})
								);

}

//Function Save Pdt Set Qty
function JSnSaveDTEdit(event){

		var nPdtValQty 	 = $(event).parents().eq(2).find('.xWPdtSetInputQty').val();
		var tEditSeqNo = $(event).parents().eq(2).attr('data-seqno');
		var aField = [];
		var aValue = [];
		
		$(".xWValueEditInLine"+tEditSeqNo).each(function(index){
			tValue = $(this).val();
			tField = $(this).attr('data-field');
			$('.xWShowValue'+tField+tEditSeqNo).text(tValue);
			aField.push(tField);
			aValue.push(tValue);
		});

		FSvPOEditPdtIntoTableDT(tEditSeqNo,aField,aValue);

		$('.xWShowInLine'+tEditSeqNo).removeClass('xCNHide');
		$('.xWEditInLine'+tEditSeqNo).addClass('xCNHide');

		$(event).parent().empty().append($('<img>')
		.attr('class','xCNIconTable')
		.attr('src',tBaseURL+'application/modules/common/assets/images/icons/edit.png')
			.click(function(){
				JSnEditDTRow(this);
			})
		);

}

// Function : Del Row Html
function JSnRemoveDTRow(ele){

	var nRowID = $(ele).parent().parent().parent().attr('id');
	var tVal = $(ele).parent().parent().parent().attr('data-pdtcode');
	var tIndex = $(ele).parent().parent().parent().attr('data-index');

	JSnPORemoveDTInFile(tIndex,tVal);

	$(ele).parent().parent().parent().remove();

}



//Functionality : Select Spl To input
//Parameters : -
//Creator : 01/08/2018 Krit(Copter)
//Return : View
//Return Type : value to input
function JSxPOGetDataToFillSpl(poJsonData){

	tOldSplCode = $('#ohdOldSplCode').val();
	tOldSplName = $('#oetOldSplName').val();
	tNewSplCode = $('#oetSplCode').val();

	bStaHavePdt = $('#odvPdtTablePanal tbody tr').hasClass('xCNDOCPdtItem');

	//Check ว่ามีการเปลี่ยน Spl หรือไม่
	if(tOldSplCode != tNewSplCode && tOldSplCode != '' && bStaHavePdt === true){

			bootbox.confirm({
				title: aLocale['tWarning'],
				message: 'Suplier มีการเปลี่ยนแปลง Product ที่ถูกเพิ่มแล้วจะถูกล้างค่า ต้องการทำต่อหรือไม่ ?',
				buttons: {
						cancel: {
								label: aLocale['tBtnConfirm'],
								className: 'xCNBTNPrimery'
						},
						confirm: {
								label: aLocale['tBtnClose'],
								className: 'xCNBTNDefult'
						}
				},
				callback: function (result) {
						if (result == false) {
								
								aJsonData 			= JSON.parse(poJsonData);
								nXphCrTerm 			= days = parseInt(aJsonData[0], 10);  //
								tSplCrLimit			= aJsonData[1] //
								tSplStaVATInOrEx 	= aJsonData[2] //
								tSplTspPaid 		= aJsonData[3] //
								tSplCode			= aJsonData[4] //
								tSplName			= aJsonData[5] //

								$('#ohdOldSplCode').val(tSplCode).trigger('change');
								$('#oetOldSplName').val(tSplName).trigger('change');

								//Put Data into Form
								//สด/เครดิต
								if(nXphCrTerm > 0){
									$('#ostXphCshOrCrd').val('2').trigger('change');
								}else{
									$('#ostXphCshOrCrd').val('1').trigger('change');
								}
								//จำนวนวันเครดิต
								$('#oetXphCrTerm').val(nXphCrTerm);

								//ประเภทภาษี 1.รวมใน 2.แยกนอกแยกนอก
								if(tSplStaVATInOrEx == ''){
									tSplStaVATInOrEx = 1; //Def value 
								}
								$('#ostXphVATInOrEx').val(tSplStaVATInOrEx).trigger('change');

								dDocDate = $('#oetXphDocDate').val(); // Doc Date
								date = new Date($("#oetXphDocDate").val());


								if(!isNaN(date.getTime())){
									date.setDate(date.getDate() + days);
									$('#oetXphDueDate').datepicker("setDate",date); //วันที่ครบกำหนดชำระนที่ครบกำหนดชำระ
								} else {
									alert("Please Enter Date");  
									$('#oetXphDocDate').focus();
								}

								//การชำระเงิน
								if(tSplTspPaid == ''){
									tSplTspPaid = 1; //Def value 
								}
								$('#ostXphDstPaid').val(tSplTspPaid).trigger('change');

								$('#oetXphCtrName').val(tSplName);

								//ลบข้อมูล สินค้าใน File
								JSnPORemoveAllDTInFile();

						}else{
							$('#oetSplCode').val(tOldSplCode).trigger('change');
							$('#oetSplName').val(tOldSplName).trigger('change');
						}
				}
		});

	}else{
								aJsonData 			= JSON.parse(poJsonData);
								nXphCrTerm 			= days = parseInt(aJsonData[0], 10);  //
								tSplCrLimit			= aJsonData[1] //
								tSplStaVATInOrEx 	= aJsonData[2] //
								tSplTspPaid 		= aJsonData[3] //
								tSplCode			= aJsonData[4] //
								tSplName			= aJsonData[5] //

								$('#ohdOldSplCode').val(tSplCode).trigger('change');
								$('#oetOldSplName').val(tSplName).trigger('change');

								//Put Data into Form
								//สด/เครดิต
								if(nXphCrTerm > 0){
									$('#ostXphCshOrCrd').val('2').trigger('change');
								}else{
									$('#ostXphCshOrCrd').val('1').trigger('change');
								}
								//จำนวนวันเครดิต
								$('#oetXphCrTerm').val(nXphCrTerm);

								//ประเภทภาษี 1.รวมใน 2.แยกนอกแยกนอก
								if(tSplStaVATInOrEx == ''){
									tSplStaVATInOrEx = 1; //Def value 
								}
								$('#ostXphVATInOrEx').val(tSplStaVATInOrEx).trigger('change');

								dDocDate = $('#oetXphDocDate').val(); // Doc Date
								date = new Date($("#oetXphDocDate").val());


								if(!isNaN(date.getTime())){
									date.setDate(date.getDate() + days);
									$('#oetXphDueDate').datepicker("setDate",date); //วันที่ครบกำหนดชำระนที่ครบกำหนดชำระ
								} else {
									alert("Please Enter Date");  
									$('#oetXphDocDate').focus();
								}

								//การชำระเงิน
								if(tSplTspPaid == ''){
									tSplTspPaid = 1; //Def value 
								}
								$('#ostXphDstPaid').val(tSplTspPaid).trigger('change');

								$('#oetXphCtrName').val(tSplName);
	}

}

function JSxPOGetWahFormShop(poJsonData){

	if(poJsonData != undefined){
		aData = JSON.parse(poJsonData);
		
		tWahCode = aData[0];
		tWahName = aData[1];
	
		if(tWahCode != '' && tWahCode != undefined){
			$('#ohdWahCode').val(tWahCode);
			$('#oetWahCodeName').val(tWahName);
		}else{
			$('#ohdWahCode').val('');
			$('#oetWahCodeName').val('');

		}
	}

}


function FSvPOAddHDDis(){

	tHDXphDisChgText = $('#ostXphHDDisChgText').val();
	cHDXphDis     = $('#oetXddHDDis').val();
	tHDXphDocNo  = $('#oetXphDocNo').val();
	tHDBchCode   = $('#ohdSesUsrBchCode').val();

	nPlusOld = '';
	nPercentOld = '';
	tPlusNew = '';
	nPercentNew = '';
	tOldDisHDChgLength = '';

	if(tHDXphDisChgText == 1 || tHDXphDisChgText == 2){
		tPlusNew = '+';
	}
	if(tHDXphDisChgText == 2 || tHDXphDisChgText == 4){
		nPercentNew = '%';
	}

	//หา length ที่มีอยู่ ของ HD
	$('.xWAlwEditXpdHDDisChgValue').each(function(e){
		nDistypeOld = $(this).data('distype');
		if(nDistypeOld == 1 || nDistypeOld == 2){
			nPlusOld = '+';
		}
		if(nDistypeOld == 2 || nDistypeOld == 4){
			nPercentOld = '%';
		}
		tOldDisHDChgLength += nPlusOld+$(this).text()+nPercentOld+','
	});
	tNewDisHDChgLength = tPlusNew+accounting.formatNumber(cHDXphDis, nOptDecimalSave,"")+nPercentNew;
	//เอาทั้งสองมาต่อกัน
	tCurDisHDChgLength = tOldDisHDChgLength+tNewDisHDChgLength
	//หาจำนวนตัวอักษร
	nCurDisHDChgLength = tCurDisHDChgLength.length;

	if(cHDXphDis == ''){
		$('#oetXddHDDis').focus();
	}else{
		//Check ขนาดของ Text DisChgText
		if(nCurDisHDChgLength <= 20){
			$.ajax({
				type: "POST",
				url: "POAddHDDisIntoTable",
				data: {  
						tHDXphDocNo  : tHDXphDocNo,
						tHDBchCode   : tHDBchCode,
						tHDXphDisChgText : tHDXphDisChgText,
						cHDXphDis     : cHDXphDis
				},
				cache: false,
				timeout: 5000,
				success: function(tResult){

					JSvPOLoadPdtDataTableHtml();

				},
				error: function(jqXHR, textStatus, errorThrown) {
					(jqXHR, textStatus, errorThrown);
				}
			});
		}else{
			alert('ไม่สามารถเพิ่มได้ จำนวนขนาดเกิน 20');
		}

	}
}




</script>