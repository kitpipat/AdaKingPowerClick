<?php
if($aResult['rtCode'] == "1"){
	$tXthDocNo 				= $aResult['raItems']['FTXthDocNo'];
	$dXthDocDate 			= $aResult['raItems']['FDXthDocDate'];
	$tXthDocTime 			= $aResult['raItems']['FTXthDocTime'];
	$tCreateBy 				= $aResult['raItems']['FTCreateBy'];
	$tXthStaDoc 			= $aResult['raItems']['FTXthStaDoc'];
	$tXthStaApv 			= $aResult['raItems']['FTXthStaApv'];
	$tXthApvCode 			= $aResult['raItems']['FTXthApvCode'];
	$tXthStaPrcStk 			= $aResult['raItems']['FTXthStaPrcStk'];
	$tXthStaDelMQ 			= $aResult['raItems']['FTXthStaDelMQ'];
	// $tShpCode 				= $aResult['raItems']['FTShpCode'];
	// $tShpName 				= $aResult['raItems']['FTShpName'];
	$tCompCode = $tCompCode;
	$tBchCode 				= $aResult['raItems']['FTBchCode'];
	$tBchName 				= $aResult['raItems']['FTBchName'];
	$tMchCode					=	$aResult['raItems']['FTXthMerCode'];
	$tMchName 				=	$aResult['raItems']['FTMerName'];
	$tShpCodeStart 				= $aResult['raItems']['FTXthShopFrm'];
	$tShpNameStart 				= $aResult['raItems']['FTShpNameFrm'];
	$tShpTypeStart 				= $aResult['raItems']['FTShpTypeFrm'];
	// $tShpCodeEnd 				= $aResult['raItems']['FTXthShopTo'];
	// $tShpNameEnd				= $aResult['raItems']['FTShpNameTo'];
	// $tShpTypeEnd 				= $aResult['raItems']['FTShpTypeTo'];
	$tPosCodeStart 				= $aResult['raItems']['FTXthPosFrm'];
	$tPosNameStart 				= $aResult['raItems']['FTPosComNameF'];
	// $tPosCodeEnd 				= $aResult['raItems']['FTXthPosTo'];
	// $tPosNameEnd				= $aResult['raItems']['FTPosComNameT'];
	$tWahCodeStart 			= $aResult['raItems']['FTXthWhFrm'];
	$tWahNameStart 			= $aResult['raItems']['FTXthWhNameFrm'];
	// $tWahCodeEnd 			 = $aResult['raItems']['FTXthWhTo'];
	// $tWahNameEnd 			 = $aResult['raItems']['FTXthWhNameTo'];
	$tUserBchCode      =  $tUserBchCode;
	$tUserBchName      =  "";
	$tUserMchCode      =  $tUserMchCode;
	$tUserMchName      =  "";
	$tUserShpCode      =  $tUserShpCode;
	$tUserShpName      =  "";
	$tUserWahCode 		 = "";
	$tUserWahName 		 = "";
	// $tMchCode					=	$tMchCode;
	// $tMchName 				=	$tMchName;
	// $tShpCodeStart 				= $aResult['raItems']['FTShpCode'];
	// $tShpNameStart 				= $aResult['raItems']['FTShpName'];
	// $tWahCodeStart 			= $aResult['raItems']['FTXthWhFrm'];
	// $tWahNameStart 			= $aResult['raItems']['FTWahNameFrm'];
	// $tShpCodeEnd 				= $tShpCodeEnd;
	// $tShpNameEnd				= $tShpNameEnd;
	// $tWahCodeEnd 			 = $tWahCodeEnd;
	// $tWahNameEnd 			 = $tWahNameEnd;
	// $tWahCodeTo 	    = $aResult['raItems']['FTXthWhTo'];
	// $tWahNameTo 	    = $aResult['raItems']['FTWahNameTo'];
	//$tXthRefExt 			= $aResult['raItems']['FTXthRefExt'];
	//$dXthRefExtDate 	= $aResult['raItems']['FDXthRefExtDate'];
	//$tXthRefInt 			= $aResult['raItems']['FTXthRefInt'];
	// $dXthTnfDate			= $aDataHDRef['raItems']['FDXthTnfDate'];
	// $tXthRefTnfID			= $aDataHDRef['raItems']['FTXthRefTnfID'];
	// $tViaCode					= $aDataHDRef['raItems']['FTViaCode'];
	// $tViaName					= $aDataHDRef['raItems']['FTViaName'];
	// $tXthRefVehID 		= $aDataHDRef['raItems']['FTXthRefVehID'];
	// $tXthQtyAndTypeUnit	= $aDataHDRef['raItems']['FTXthQtyAndTypeUnit'];
	// $tXthShipAdd			= $aDataHDRef['raItems']['FNXthShipAdd'];
	$nXthStaDocAct 		= $aResult['raItems']['FNXthStaDocAct'];
	//$tXthStaRef				= $aResult['raItems']['FNXthStaRef'];
	$nXthDocPrint 		= $aResult['raItems']['FNXthDocPrint'];
	// $tSplCode 			= $aResult['raItems']['FTSplCode'];
	// $tSplName 			= $aResult['raItems']['FTSplName'];
	$tXthRmk 					= $aResult['raItems']['FTXthRmk'];
	// $nXthDocType 		= $aResult['raItems']['FNXthDocType'];
	// $tXthCshOrCrd 		= $aResult['raItems']['FTXthCshOrCrd'];
	$tDptCode 				= $aResult['raItems']['FTDptCode'];
	$tDptName 				= $aResult['raItems']['FTDptName'];
	$tUsrCode 				= $aResult['raItems']['FTUsrCode'];
	$tUsrNameCreateBy	= $aResult['raItems']['FTCreateBy'];
	$tXthUsrNameApv 	= $aResult['raItems']['FTUsrNameApv'];
	//$dXthRefIntDate 	= $aResult['raItems']['FDXthRefIntDate'];
    $cXthVat ="";
    $cXthVatable="";
    $tXthVATInOrEx="";
    $tXthCtrName="";
	//Event Control
	if(isset($aAlwEvent)){
		if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaEdit'] == 1){
			$nAutStaEdit = 1;
		}else{
			$nAutStaEdit = 0;
		}
	}else{
		$nAutStaEdit = 0;
	}
	
	// $tFNAddSeqNo = $aDataHDRef["raItems"]["FNAddSeqNo"];
	// $tFTAddV1No = $aDataHDRef["raItems"]["FTAddV1No"];
	// $tFTAddV1Soi = $aDataHDRef["raItems"]["FTAddV1Soi"];
	// $tFTAddV1Village = $aDataHDRef["raItems"]["FTAddV1Village"];
	// $tFTAddV1Road = $aDataHDRef["raItems"]["FTAddV1Road"];
	// $tFTSudName = $aDataHDRef["raItems"]["FTSudName"];
	// $tFTDstName = $aDataHDRef["raItems"]["FTDstName"];
	// $tFTPvnName = $aDataHDRef["raItems"]["FTPvnName"];
	// $tFTAddV1PostCode = $aDataHDRef["raItems"]["FTAddV1PostCode"];

	//Event Control
	$tRoute         	= "ADJSTKVDEventEdit";	
	$tRsCode = $aResult['raItems']['FTRsnCode'];
	$tRsName = $aResult['raItems']['FTRsnName'];
}else{
	$tXthDocNo 				= "";
	$dXthDocDate 			= "";
	$tXthDocTime 			= "";
	$tCreateBy 				= $this->session->userdata('tSesUsrUsername');
	$tXthStaDoc 			= "";
	$tXthStaApv 			= "";
	$tXthApvCode 			= "";
	$tXthStaPrcStk 		= "";
	$tXthStaDelMQ 		= "";
	$tCompCode = $tCompCode;
	$tBchCompCode 				= $tBchCompCode;
	$tBchCompName 				= $tBchCompName;
	$tUserBchCode      =  $tBchCode;
	$tUserBchName      =  $tBchName;
	$tUserMchCode      =  $tMchCode;
	$tUserMchName      =  $tMchName;
	$tUserShpCode      =  $tShpCodeStart;
	$tUserShpName      =  $tShpNameStart;
	$tUserShpType			 = 	$tShpTypeStart;
	$tPosCodeStart 				= "";
	$tPosNameStart 				= "";
	// $tPosCodeEnd 				= "";
	// $tPosNameEnd				= "";
	$tUserWahCode 		 = $tWahCodeStart;
	$tUserWahName 		 = $tWahNameStart;
	if($tBchCode!=""){
		$tBchCode 				= $tBchCode;
	}else{
		$tBchCode				= $tBchCompCode;
	}
	$tBchName 				= "";
	$tMchCode					=	"";
	$tMchName 				=	"";
	$tShpCodeStart 				= "";
	$tShpNameStart 				= "";
	// $tShpCodeEnd 				= "";
	// $tShpNameEnd				= "";
	$tWahCodeStart 			= "";
	$tWahNameStart 			= "";
	// $tWahCodeEnd 			 = "";
	// $tWahNameEnd 			 = "";
	$tXthRefExt 			= "";
	$dXthRefExtDate 	= "";
	$tXthRefInt 			= "";
	$tXthCtrName		 	= "";
	$dXthTnfDate			= "";
	$tXthRefTnfID			= "";
	$tViaCode					= "";
	$tViaName					= "";
	$tXthRefVehID 		= "";
	$tXthQtyAndTypeUnit	= "";
	$tXthShipAdd			= "";	
	$nXthStaDocAct 		= "";
	$tXthStaRef		   	= "";
	$nXthDocPrint 		= "0";
	// $tSplCode 				= "";
	// $tSplName 				= "";
	$tXthRmk 					= "";
	// $nXthDocType 			= "";
	// $tXthCshOrCrd 		    = "";
	$tXthVATInOrEx 		= "";
	$tDptCode 				= $tDptCode; 
	$tDptName 				= $this->session->userdata("tSesUsrDptName"); 
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy	= $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 	= "";
	$dXthRefIntDate 	= "";
	$tVatCode 				= $tVatCode;
	// $cXthVATRate 			= $cVatRate;
	$cXthVat 					= "";
	$cXthVatable 			= "";
	//TAPTOrdHDSpl
	// $tXthTaxAdd			    = "";
	$tFNAddSeqNo = "";
	$tFTAddV1No = "";
	$tFTAddV1Soi = "";
	$tFTAddV1Village = "";
	$tFTAddV1Road = "";
	$tFTSudName = "";
	$tFTDstName = "";
	$tFTPvnName = "";
	$tFTAddV1PostCode = "";


	$tRoute         	    = "ADJSTKVDEventAdd";
	$nAutStaEdit = 0; //Event Control
	$tRsCode = "";
	$tRsName = "";
}
$tUserType = "";
if($tUserBchCode=='' && $tUserShpCode==''){
	$tUserType = "HQ";
}else{
	if($tUserBchCode!='' && $tUserShpCode==''){
		$tUserType = "BCH";
	}else if($tUserBchCode!='' && $tUserShpCode!=''){
		$tUserType = "SHP";
	}
}
?>
<div id="aa"></div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddTFW">
	<input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" value="<?php echo base_url(); ?>">
	<input type="hidden" id="ohdTFWAutStaEdit" name="ohdTFWAutStaEdit" value="<?php echo $nAutStaEdit; ?>">
	<input type="hidden" id="ohdXthStaApv" name="ohdXthStaApv" value="<?php echo $tXthStaApv; ?>">
	<input type="hidden" class="" id="ohdXthStaDoc" name="ohdXthStaDoc" value="<?php echo $tXthStaDoc; ?>">
	<input type="hidden" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" value="<?php echo $tXthStaPrcStk; ?>">
	<input type="hidden" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" value="<?php echo $tXthStaDelMQ; ?>">
	<input type="hidden" id="ohdTFWRoute" name="ohdTFWRoute" value="<?php echo $tRoute; ?>">
	<button style="display:none" type="submit" id="obtSubmitTFW" onclick="JSnAddEditTFW();"></button>
	<input type="text" class="xCNHide" id="ohdSesUsrBchCode" name="ohdSesUsrBchCode" value="<?php echo $this->session->userdata("tSesUsrBchCode"); ?>"> 
	<input type="text" class="xCNHide" id="ohdCompCode" name="ohdCompCode" value="<?php echo $tCompCode; ?>"> 
	<input type="text" class="xCNHide" id="ohdBchCode" name="ohdBchCode" value="<?php echo $tBchCode; ?>"> 
	<input type="text" class="xCNHide" id="ohdOptAlwSavQty0" name="ohdOptAlwSavQty0" value="<?php echo $nOptDocSave?>">
	<input type="text" class="xCNHide" id="ohdOptScanSku" name="ohdOptScanSku" value="<?php echo $nOptScanSku?>">
	<input type="text" class="xCNHide" id="ohdDptCode" name="ohdDptCode" maxlength="5" value="<?php echo $tDptCode;?>">
	<input type="text" class="xCNHide" d="oetUsrCode" name="oetUsrCode" maxlength="20" value="<?php echo $tUsrCode?>">
	<input type="text" class="xCNHide" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin" maxlength="20" value="<?php echo $this->session->userdata('tSesUsername'); ?>">
	<input type="text" class="xCNHide" id="ohdLangEdit" name="ohdLangEdit" maxlength="1" value="<?php echo $this->session->userdata("tLangEdit"); ?>">
	<input type="text" class="xCNHide" id="ohdStatusLoadPdtToTem" name="ohdStatusLoadPdtToTem" value="0">
	<input type="text" class="xCNHide" id="ohdCheckSetDataDTFromTmp" name="ohdCheckSetDataDTFromTmp" value="1">
	<div class="row">
		<div class="col-md-4">
			<div class="panel panel-default" style="margin-bottom: 25px;"> 
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvDataPromotion" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataPromotion" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWApproved'); ?></label>
						</div>
						<input type="hidden" value="0" id="ohdCheckTFWSubmitByButton" name="ohdCheckTFWSubmitByButton"> 
						<input type="hidden" value="0" id="ohdCheckTFWClearValidate" name="ohdCheckTFWClearValidate"> 
						<label class="xCNLabelFrm"><span style = "color:red">*</span><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWDocNo'); ?></label>
						<?php
						if($tRoute=="ADJSTKVDEventAdd"){
						?>
						<div class="form-group" id="odvPunAutoGenCode">
							<div class="validate-input">
								<label class="fancy-checkbox">
									<input type="checkbox" id="ocbTFWAutoGenCode" name="ocbTFWAutoGenCode" checked="true" value="1">
									<span> <?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWAutoGenCode'); ?></span>
								</label>
							</div>
						</div>
						<div class="form-group" id="odvPunCodeForm">
							<input 
									type="text" 
									class="form-control xCNInputWithoutSpcNotThai" 
									maxlength="20" 
									id="oetXthDocNo" 
									name="oetXthDocNo"
									data-is-created="<?php  ?>"
									placeholder="<?= language('document/adjuststockvd/producttransferwahousevd', 'tTFWDocNo')?>"
									value="<?php  ?>" 
									data-validate-required="<?php echo language('document/adjuststockvd/producttransferwahousevd','tTFWDocNoRequired')?>"
									data-validate-dublicateCode="<?php echo language('document/adjuststockvd/producttransferwahousevd','tTFWDocNoDuplicate')?>"
									readonly
									onfocus="this.blur()">
							<input type="hidden" value="2" id="ohdCheckDuplicateTFW" name="ohdCheckDuplicateTFW"> 
						</div>
						<?php
						}else{
						?>
						<div class="form-group" id="odvPunCodeForm">
							<div class="validate-input">
								<input 
										type="text" 
										class="form-control xCNInputWithoutSpcNotThai" 
										maxlength="20" 
										id="oetXthDocNo" 
										name="oetXthDocNo"
										data-is-created="<?php  ?>"
										placeholder="<?= language('document/adjuststockvd/producttransferwahousevd', 'tTFWDocNo')?>"
										value="<?php echo $tXthDocNo; ?>" 
										readonly
										onfocus="this.blur()">
							</div>
						</div>
						<?php
						}
						?>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWDocDate'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oetXthDocDate" name="oetXthDocDate" value="<?php echo $dXthDocDate; ?>" data-validate-required="<?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWPlsEnterDocDate'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWDocTime'); ?></label>
							<div class="input-group">
								<input type="text" class="form-control xCNTimePicker" id="oetXthDocTime" name="oetXthDocTime" value="<?php echo $tXthDocTime; ?>" data-validate-required="<?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWPlsEnterDocTime'); ?>">
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?php echo $tCreateBy?>">
								<label><?php echo $tUsrNameCreateBy?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWStaDoc'.$tXthStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWStaApv'.$tXthStaApv); ?></label>
							</div>
						</div>
						<?php 
						if($tXthDocNo != ''){
						?>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWApvBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?php echo $tXthApvCode?>">
								<label><?php echo $tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/adjuststockvd/producttransferwahousevd', 'tTFWStaDoc'); ?></label>
							</div>
						</div>
						<?php 
						} 
						?>
					</div>
				</div>    
			</div>
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWTnfCondition'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvWarehouse" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvWarehouse" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">
						<!-- สาขา -->
						<?php
							if($tRoute  == "ADJSTKVDEventAdd"){
								if($this->session->userdata('tSesUsrLevel') == "HQ"){
									$tDisabled  = '';
									$tNameElmID = 'obtBrowseASTBCH';
								}else{
									$tDisabled  = 'disabled';
									$tNameElmID = '';
								}
							}else{
								$tDisabled = 'disabled';
								$tNameElmID = '';
							}

						?>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTBranch');?></label>
									<div class="input-group">
										<input
											type="text"
											class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
											id="oetBchCode"
											name="oetBchCode"
											maxlength="5"
											value="<?php echo $tBchCompCode;?>"
										>
										<input
											type="text"
											class="form-control xWPointerEventNone"
											id="oetBchName"
											name="oetBchName"
											maxlength="100"
											placeholder="<?php echo language('document/adjuststock/adjuststock','tASTBranch');?>"
											value="<?php echo $tBchCompName;?>"
											readonly
										>
										<span class="input-group-btn">
											<button id="<?=$tNameElmID?>" type="button" class="btn xCNBtnBrowseAddOn  <?=$tDisabled?>">
												<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>
						<!-- สาขา -->
						<!-- กลุ่มร้านค้า -->
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
							<label class="xCNLabelFrm">กลุ่มร้านค้า</label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetMchCode" name="oetMchCode" maxlength="5" value="<?php
									if($tRoute=="ADJSTKVDEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserMchCode; 
										}  
									}else{
										echo $tMchCode;
									}
								?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetMchName" name="oetMchName" value="<?php 
									if($tRoute=="ADJSTKVDEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserMchName; 
										}  
									}else{
										echo $tMchName;
									}
								?>" readonly>
								<span class="xWConditionSearchPdt input-group-btn
								<?php 
									if($tRoute=="ADJSTKVDEventAdd"){
										if($tUserType == "SHP"){ 
											if($tUserMchName!=""){
												echo language('common/main/main','tTextDiabled');
											} 
										}else{
											if($tUserType == "HQ" && !$tBchCompCode){
												echo language('common/main/main','tTextDiabled');
											}
											
										}   
									}else{
										if($tUserType == "SHP"){ 
											echo language('common/main/main','tTextDiabled');
										}
									}
								?>
								">
									<button id="obtTFWBrowseMch" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn
									<?php 
										if($tRoute=="ADJSTKVDEventAdd"){
											if($tUserType == "SHP"){ 
												if($tUserMchName!=""){
													echo language('common/main/main','tTextDiabled');
												} 
											}else{
												if($tUserType == "HQ" && !$tBchCompCode){
													echo language('common/main/main','tTextDiabled');
												}
												
											}   
										}else{
											if($tUserType == "SHP"){ 
												echo language('common/main/main','tTextDiabled');
											}
										}
									?>
									">
										<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>
						<!-- กลุ่มร้านค้า -->
						<!-- ต้นทาง -->
							
								<!-- ร้านเริ่ม -->
							<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
								<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWShop'); ?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetShpCodeStart" name="oetShpCodeStart" maxlength="5" value="<?php 
									if($tRoute=="ADJSTKVDEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserShpCode; 
										}  
									}else{
										echo $tShpCodeStart;
									}
									?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetShpNameStart" name="oetShpNameStart" value="<?php 
									if($tRoute=="ADJSTKVDEventAdd"){
										if($tUserType == "SHP"){ 
											echo $tUserShpName; 
										}  
									}else{
										echo $tShpNameStart;
									} 
									?>" readonly>
									<span class="xWConditionSearchPdt input-group-btn <?php
										if($tRoute=="ADJSTKVDEventAdd"){
									?>
											disabled
									<?php
										}else{
											
											if($tUserType == "SHP"){ 
												echo language('common/main/main','tTextDiabled');
											}else{
											
												if($tMchCode==""){
													echo language('common/main/main','tTextDiabled');
												}
											}
										}
									?>">
										<button id="obtTFWBrowseShpStart" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn <?php
										if($tRoute=="ADJSTKVDEventAdd"){
									?>
											disabled
									<?php
										}else{
											if($tUserType == "SHP"){ 
												echo language('common/main/main','tTextDiabled');
											}else{
											
												if($tMchCode==""){
													echo language('common/main/main','tTextDiabled');
												}
											}
										
										}
									?>">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>
							<!-- ร้านเริ่ม -->
							<!-- เครื่องจุดขาย เริ่ม -->
							<div class="form-group">
								<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWPos'); ?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetPosCodeStart" name="oetPosCodeStart" maxlength="5" value="<?php
										if($tRoute!="ADJSTKVDEventAdd"){
											echo $tPosCodeStart;
										}
									?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetPosNameStart" name="oetPosNameStart" value="<?php
										if($tRoute!="ADJSTKVDEventAdd"){
											echo $tPosNameStart;
										}
									?>" readonly>
									<span class="xWConditionSearchPdt input-group-btn 
									<?php 
										if($tRoute=="ADJSTKVDEventAdd"){
											if($tUserType == "SHP"){ 
												if($tUserShpType!=4){
													echo language('common/main/main','tTextDiabled');
												} 
											}else{
												echo language('common/main/main','tTextDiabled');
											}  
										}
									?>">
										<button id="obtTFWBrowsePosStart" type="button" class=" btn xCNBtnBrowseAddOn xWConditionSearchPdt
										<?php 
										if($tRoute=="ADJSTKVDEventAdd"){
											if($tUserType != "SHP"){ 
											// 	if($tUserShpType!=4){
											// 		echo language('common/main/main','tTextDiabled');
											// 	} 
											// }else{
												echo language('common/main/main','tTextDiabled');
											}  
										}
										?>">
											<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
										</button>
									</span>
								</div>
							</div>
							<!-- เครื่อง เริ่ม -->
							<!-- คลังเริ่ม -->
							<div class="form-group">
                                                <label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWWarehouseFrom'); ?></label>
                                                <div class="input-group">
                                                    <input name="oetWahNameStart" id="oetWahNameStart" class="form-control" value="<?php echo $tWahNameStart;?>" type="text" readonly=""
                                                        data-validate="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBIPlsEnterWahTo') ?>" 
                                                        placeholder="<?= language('document/transferreceiptbranch/transferreceiptbranch', 'tTBITablePDTWah') ?>" 
                                                    >
                                                    <input name="ohdWahCodeStart" id="ohdWahCodeStart" value="<?php echo $tWahCodeStart;?>" class="form-control xCNHide xCNClearValue" type="text">
                                                    <span class="input-group-btn">
                                                        <button class="btn xCNBtnBrowseAddOn xCNApvOrCanCelDisabled" id="obtASTBrowseWah" type="button">
                                                            <img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
                                                        </button>
                                                    </span>
                                                </div>
                                            </div>
							<!-- <div class="form-group">
								<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWWarehouseFrom'); ?></label>
								<div class="form-group">
									<input type="text" class="input100 xCNHide" id="ohdWahCodeStart" name="ohdWahCodeStart" maxlength="5" 
										value="<?php 
											if($tRoute!="ADJSTKVDEventAdd"){
												echo $tWahCodeStart;
											}
										// if($tRoute=="ADJSTKVDEventAdd"){
										// 	if($tUserType == "SHP"){ 
										// 		echo $tUserWahCode; 
										// 	}  
										// }else{
										// 	echo $tWahCodeStart;
										// }
									?>">
									<input class="form-control xWPointerEventNone" type="text" id="oetWahNameStart" name="oetWahNameStart" value="<?php 
										if($tRoute!="ADJSTKVDEventAdd"){
											echo $tWahNameStart;
										}
									// if($tRoute=="ADJSTKVDEventAdd"){
									// 	if($tUserType == "SHP"){ 
									// 		echo $tUserWahName; 
									// 	}  
									// }else{
									// 	echo $tWahNameStart;
									// }
									?>" readonly data-validate-required="<?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWWahNameStartRequired'); ?>">
									
								</div>
							</div> -->
							<!-- เหตุผล -->
							<div class="form-group">
								<label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTReason'); ?></label>
								<div class="input-group">
									<input class="form-control xCNHide" id="oetASTRsnCode" name="oetASTRsnCode" maxlength="5" value="<?php 
									if($tRoute=="ADJSTKVDEventEdit"){
										echo $tRsCode;
									}
									?>">
									<input
										type="text"
										class="form-control xWPointerEventNone"
										id="oetASTRsnName"
										name="oetASTRsnName"
										value="<?php 
										if($tRoute=="ADJSTKVDEventEdit"){
											echo $tRsName;
										}
										?>"
										readonly data-validate-required="<?php echo language('document/adjuststock/adjuststock', 'tASTPlsEnterReason'); ?>"
									>
									<span class="xWConditionSearchPdt input-group-btn">
										<button id="obtASTBrowseRsn" type="button" class="xWConditionSearchPdt btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
									</span>
								</div>
							</div>
						<!-- ต้นทาง -->
						<div class="row xCNMarginTop30px">
							<div class="col-md-6 btn-group xCNDropDrownGroup">
								<button type="button" id="obtTWXVDControlFormClear" class="btn xCNBTNMngTable" style="width:100%;font-size: 17px;"><?php echo language('document/adjuststock/adjuststock', 'tASTClearData'); ?></button>
							</div>
							<div class="col-md-6">
								<button type="button" id="obtTWXVDControlForm" class="btn btn-primary xWConditionSearchPdt" disabled style="width:100%;font-size: 17px;"><?php echo language('document/adjuststock/adjuststock', 'tASTSearchProduct'); ?></button>
							</div>
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
										<input type="text" class="form-control" maxlength="100" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvDOCSearchPdtHTML()" placeholder="<?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWSearchPdt'); ?>">
										<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvTFWScanPdtHTML()" placeholder="<?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWScanPdt'); ?>" style="display:none;" data-validate="<?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFXVDSearchNotFound'); ?>">
										<span class="input-group-btn">
											<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
												<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvDOCSearchPdtHTML()">
													<img  src="<?php echo  base_url().'application/modules/common/assets/images/icons/search-24.png'?>" style="width:20px;">
												</button>
												<button id="oimMngPdtIconScan" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" style="display:none;" onclick="JSvTFWScanPdtHTML()">
													<img class="oimMngPdtIconScan" src="<?php echo  base_url().'application/modules/common/assets/images/icons/scanner.png'?>" style="width:20px;">
												</button>
												<button type="button" class="btn xCNDocDrpDwn xCNBtnDocSchAndScan" data-toggle="dropdown">
													<i class="fa fa-chevron-down f-s-14 t-plus-1" style="font-size: 12px;"></i>
												</button>
												<ul class="dropdown-menu" role="menu">
													<li>
														<a id="oliMngPdtSearch"><label><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWSearchPdt'); ?></label></a>
														<a id="oliMngPdtScan"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWScanPdt'); ?></a>
													</li>
												</ul>
											</div>
										</span>
									</div>
								</div>
							</div>
							<!-- <div class="col-md-6">
								<div class="btn-group xCNDropDrownGroup right">
									<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
										<?php // echo language('common/main/main','tCMNOption')?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li id="oliBtnDeleteAll" class="disabled">
											<a data-toggle="modal" data-target="#odvModalDelPdtTFW"><?php //echo language('common/main/main','tDelAll')?></a>
										</li>
									</ul>
								</div>
							</div> -->
						</div>
						<div id="odvPdtTablePanal">
						</div>
						<div id="odvPdtTablePanalDataHide">
						</div>
					</div>
				</div>
			</div>
			








			<!-- <div class="row">
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
								<label class="xCNLabelFrm"><?php //echo language('document/transferreceipt/transferreceipt', 'tTWITotalCash'); ?></label>
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
								<label class="xCNLabelFrm"><?php //echo language('document/transferreceipt/transferreceipt', 'tTWIGrandB4Wht'); ?></label>
							</div>
							<div class="col-lg-6 text-center">
								<label class="xCNLabelFrm" id="othFCXthGrandB4Wht">-</label>
							</div>
						</div>
					</div>
				</div>
			</div> -->















		</div>
	</div>
</form>
<!-- Modal Address-->
<div class="modal fade" id="odvTFWBrowseShipAdd">
	<div class="modal-dialog" style="width: 800px;">
		<div class="modal-content">
			<div class="modal-header">
				<div class="row">
					<div class="col-xs-12 col-md-6">
						<label class="xCNTextModalHeard" style="font-weight: bold; font-size: 20px;"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWShipAddress'); ?></label>
					</div>
					<div class="col-xs-12 col-md-6 text-right"> 
							<button class="btn xCNBTNPrimery xCNBTNPrimery2Btn" onclick="JSnTFWAddShipAdd()"><?php echo language('common/main/main', 'tModalConfirm')?></button>  
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
											<label class="xCNTextDetail1"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWAddInfo'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6 text-right">
											<a style="font-size: 14px !important;color: #179bfd;">
												<i class="fa fa-pencil" id="oliBtnEditShipAdd"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tTFWChange'); ?></i>
											</a> 
										</div>
									</div>
							</div>
							<div>
								<div class="panel-body xCNPDModlue">
									<input type="text" class="xCNHide" id="ohdShipAddSeqNo" value="<?php 
											if($tFNAddSeqNo!=""){
												echo $tFNAddSeqNo;
											}else{
												echo "";
											} 
											?>">
									<?php
										$tFormat = FCNaHAddressFormat('TCNMBranch');//1 ที่อยู่ แบบแยก  ,2  แบบรวม
										if($tFormat == '1'):
									?>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1No'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddAddV1No"><?php 
											if($tFNAddSeqNo!=""){
												echo $tFNAddSeqNo;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1Village'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1Soi"><?php 
											if($tFTAddV1Soi!=""){
												echo $tFTAddV1Soi;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1Soi'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1Village"><?php 
											if($tFTAddV1Village!=""){
												echo $tFTAddV1Village;
											}else{
												echo "-";
											} 
											?></label>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1Road'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1Road"><?php 
											if($tFTAddV1Road!=""){
												echo $tFTAddV1Road;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1SubDist'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1SubDist"><?php 
											if($tFTSudName!=""){
												echo $tFTSudName;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1DstCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1DstCode"><?php 
											if($tFTDstName!=""){
												echo $tFTDstName;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1PvnCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1PvnCode"><?php 
											if($tFTPvnName!=""){
												echo $tFTPvnName;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<div class="row">
										<div class="col-xs-6 col-md-6">
											<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd', 'tBrowseADDV1PostCode'); ?></label> 
										</div>
										<div class="col-xs-6 col-md-6">
											<label id="ospShipAddV1PostCode"><?php 
											if($tFTAddV1PostCode!=""){
												echo $tFTAddV1PostCode;
											}else{
												echo "-";
											} 
											?></label> 
										</div>
									</div>
									<?php else:?>
										<div class="row">
												<div class="col-lg-12">
														<div class="form-group">
																<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd','tBrowseADDV2Desc1')?></label><br>
																<label id="ospShipAddV2Desc1" name="ospShipAddV2Desc1">-</label>
														</div>
												</div>
										</div>
										<div class="row">
												<div class="col-lg-12">
														<div class="form-group">
																<label class="xCNLabelFrm"><?php echo language('document/adjuststockvd/producttransferwahousevd','tBrowseADDV2Desc2')?></label><br>
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
<div class="modal fade" id="odvTFWPopupApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
					<ul>
						<li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
						<li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
						<li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
						<li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
					</ul>
				<p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
				<p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
			</div>
			<div class="modal-footer">
				<button onclick="JSnTFWApprove(true)" type="button" class="btn xCNBTNPrimery">
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
      <div class="modal-body">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main', 'tModalAdvClose'); ?></button>
        <button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?php echo language('common/main/main', 'tModalAdvSave'); ?></button>
      </div>
    </div>
  </div>
</div>
<div class="modal fade" id="odvModalEditTFWDisHD">
	<div class="modal-dialog xCNDisModal">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block"><label class="xCNLabelFrm"><?php echo language('common/main/main', 'tTFWDisEndOfBill'); ?></label></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<div class="row">
					<div class="col-md-6">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tTFWDisType'); ?></label>
						<select class="selectpicker form-control" id="ostXthHDDisChgText" name="ostXthHDDisChgText">
							<option value="3"><?php echo  language('document/adjuststockvd/producttransferwahousevd','tDisChgTxt3')?></option>
							<option value="4"><?php echo  language('document/adjuststockvd/producttransferwahousevd','tDisChgTxt4')?></option>
							<option value="1"><?php echo  language('document/adjuststockvd/producttransferwahousevd','tDisChgTxt1')?></option>
							<option value="2"><?php echo  language('document/adjuststockvd/producttransferwahousevd','tDisChgTxt2')?></option>
						</select>
					</div>
					</div>
					<div class="col-md-4">
						<label class="xCNLabelFrm"><?php echo language('common/main/main', 'tTFWValue'); ?></label>
						<input type="text" class="form-control xCNInputNumericWithDecimal" id="oetXddHDDis" name="oetXddHDDis" maxlength="11" placeholder="">
					</div>
					<div class="col-md-2">
					<div class="form-group">
						<button type="button" class="btn btn-primary xCNBtnAddDis" onclick="FSvTFWAddHDDis()">
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
<div class="modal fade" id="odvTFWPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('document/document/document','tDocCancelTheDocument'); ?></label>
			</div>
			<div class="modal-body">
                <p id="obpMsgApv"><?php echo language('document/document/document','tDocCancelAlert1'); ?></p> 
                <p><strong><?php echo language('document/document/document','tDocCancelAlert2'); ?></strong></p>
			</div>
			<div class="modal-footer">
                <button onclick="JSnTFWCancel(true)" type="button" class="btn xCNBTNPrimery">
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
<?php include('script/jProducttransferwahouseAdd.php')?>
