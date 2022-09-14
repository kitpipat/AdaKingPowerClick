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
	$tCompCode 				= $tCompCode;
	$tBchCode 				= $aResult['raItems']['FTBchCode'];
	$tBchName 				= $aResult['raItems']['FTBchName'];
	$tMchCode				= $aResult['raItems']['FTXthMerCode'];
	$tMchName 				= $aResult['raItems']['FTMerName'];
	$tShpCodeStart 			= $aResult['raItems']['FTXthShopFrm'];
	$tShpNameStart 			= $aResult['raItems']['FTShpNameFrm'];
	$tShpTypeStart 			= $aResult['raItems']['FTShpTypeFrm'];
	$tPosCodeStart 			= $aResult['raItems']['FTXthPosFrm'];
	$tPosNameStart 			= $aResult['raItems']['FTPosComNameF'];
	$tWahCodeStart 			= $aResult['raItems']['FTXthWhFrm'];
	$tWahNameStart 			= $aResult['raItems']['FTXthWhNameFrm'];
	$nXthStaDocAct 			= $aResult['raItems']['FNXthStaDocAct'];
	$nXthDocPrint 			= $aResult['raItems']['FNXthDocPrint'];
	$tXthRmk 				= $aResult['raItems']['FTXthRmk'];
	$tDptCode 				= $aResult['raItems']['FTDptCode'];
	$tDptName 				= $aResult['raItems']['FTDptName'];
	$tUsrCode 				= $aResult['raItems']['FTUsrCode'];
	$tUsrNameCreateBy		= $aResult['raItems']['FTCreateBy'];
	$tXthUsrNameApv 		= $aResult['raItems']['FTUsrNameApv'];
    $cXthVat 				= "";
    $cXthVatable			= "";
    $tXthVATInOrEx			= "";
	$tXthCtrName			= "";
	$tRoute         		= "ADJSTKVDEventEdit";
	$tRsCode 				= $aResult['raItems']['FTRsnCode'];
	$tRsName 				= $aResult['raItems']['FTRsnName'];
}else{
	$tXthDocNo 				= "";
	$dXthDocDate 			= date('Y-m-d');
	$tXthDocTime 			= date('H:i');
	$tCreateBy 				= $this->session->userdata('tSesUsrUsername');
	$tXthStaDoc 			= "";
	$tXthStaApv 			= "";
	$tXthApvCode 			= "";
	$tXthStaPrcStk 			= "";
	$tXthStaDelMQ 			= "";
	$tPosCodeStart 			= "";
	$tPosNameStart 			= "";
	$tBchName 				= "";
	$tMchCode				= "";
	$tMchName 				= "";
	$tShpCodeStart 			= "";
	$tShpNameStart 			= "";
	$tWahCodeStart 			= "";
	$tWahNameStart 			= "";
	$tXthRefExt 			= "";
	$dXthRefExtDate 		= "";
	$tXthRefInt 			= "";
	$tXthCtrName		 	= "";
	$dXthTnfDate			= "";
	$tXthRefTnfID			= "";
	$tViaCode				= "";
	$tViaName				= "";
	$tXthRefVehID 			= "";
	$tXthQtyAndTypeUnit		= "";
	$tXthShipAdd			= "";
	$nXthStaDocAct 			= "99";
	$tXthStaRef		   		= "";
	$nXthDocPrint 			= "0";
	$tXthRmk 				= "";
	$tXthVATInOrEx 			= "";
	$tDptCode 				= $tDptCode;
	$tDptName 				= $this->session->userdata("tSesUsrDptName");
	$tUsrCode 				= $this->session->userdata('tSesUsername');
	$tUsrNameCreateBy		= $this->session->userdata('tSesUsrUsername');
	$tXthUsrNameApv 		= "";
	$dXthRefIntDate 		= "";
	$tVatCode 				= "";
	$cXthVat 				= "";
	$cXthVatable 			= "";
	$tFNAddSeqNo 			= "";
	$tFTAddV1No 			= "";
	$tFTAddV1Soi 			= "";
	$tFTAddV1Village 		= "";
	$tFTAddV1Road 			= "";
	$tFTSudName 			= "";
	$tFTDstName 			= "";
	$tFTPvnName 			= "";
	$tFTAddV1PostCode 		= "";
	$tRoute         	    = "ADJSTKVDEventAdd";
	$tRsCode 				= "";
	$tRsName 				= "";
}

if($aResult['rtCode'] == "1"){
    //Page : EDIT
    $tBchName = $aResult['raItems']['FTBchName'];
    $tBchCode = $aResult['raItems']['FTBchCode'];
}else{
    //Page : ADD
    $tBchName = $this->session->userdata('tSesUsrBchNameDefault');
    $tBchCode = $this->session->userdata('tSesUsrBchCodeDefault');
}
?>

<style>
	.xCNClassBlockEventClick{
		opacity			: 0.5;
		pointer-events	: none;
		cursor			: no-drop;
	}
</style>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddADJVD">
	<input type="hidden" id="ohdBaseUrl" name="ohdBaseUrl" 						value="<?=base_url(); ?>">
	<input type="hidden" id="ohdBchCodeOld" name="ohdBchCodeOld" 				value="<?=$tBchCode; ?>">
	<input type="hidden" id="ohdXthStaApv" name="ohdXthStaApv" 					value="<?=$tXthStaApv; ?>">
	<input type="hidden" id="ohdXthStaDoc" name="ohdXthStaDoc" 					value="<?=$tXthStaDoc; ?>">
	<input type="hidden" id="ohdXthStaPrcStk" name="ohdXthStaPrcStk" 			value="<?=$tXthStaPrcStk; ?>">
	<input type="hidden" id="ohdXthStaDelMQ" name="ohdXthStaDelMQ" 				value="<?=$tXthStaDelMQ; ?>">
	<input type="hidden" id="ohdADJVDRoute" name="ohdADJVDRoute"				value="<?=$tRoute; ?>">
	<input type="hidden" id="ohdCompCode" name="ohdCompCode" 					value="<?=$tCompCode; ?>">
	<input type="hidden" id="ohdDptCode" name="ohdDptCode" 						value="<?=$tDptCode;?>">
	<input type="hidden" id="oetUsrCode" name="oetUsrCode" 						value="<?=$tUsrCode?>">
	<input type="hidden" id="oetXthApvCodeUsrLogin" name="oetXthApvCodeUsrLogin"value="<?=$this->session->userdata('tSesUsername'); ?>">
	<input type="hidden" id="ohdLangEdit" name="ohdLangEdit" 					value="<?=$this->session->userdata("tLangEdit"); ?>">

	<button style="display:none" type="submit" id="obtSubmitADJVD" onclick="JSxAddEditADJVD();"></button>
	<div class="row">
		<div class="col-md-3">
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadStatus" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDStatus'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse"  href="#odvDataInfomation" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataInfomation" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body">
						<div class="form-group xCNHide" style="text-align: right;">
							<label class="xCNTitleFrom "><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDApproved'); ?></label>
						</div>
						<label class="xCNLabelFrm"><span style = "color:red">*</span><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDDocNo'); ?></label>
						<?php if($tRoute=="ADJSTKVDEventAdd"){ ?>
							<div class="form-group">
								<div class="validate-input">
									<label class="fancy-checkbox">
										<input type="checkbox" id="ocbADJVDAutoGenCode" name="ocbADJVDAutoGenCode" checked="true" value="1">
										<span><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDAutoGenCode'); ?></span>
									</label>
								</div>
							</div>
							<div class="form-group">
								<input
										type="text"
										class="form-control xCNInputWithoutSpcNotThai"
										maxlength="20"
										id="oetXthDocNo"
										name="oetXthDocNo"
										placeholder="<?= language('document/adjuststockvd/adjuststockvd', 'tADJVDDocNo')?>"
										value=""
										data-validate="<?=language('document/adjuststockvd/adjuststockvd','tADJVDDocNoRequired')?>"
										data-validate-dublicateCode="<?=language('document/adjuststockvd/adjuststockvd','tADJVDDocNoDuplicate')?>"
										readonly>
							</div>
						<?php }else{ ?>
							<div class="form-group">
								<div class="validate-input">
									<input
										type="text"
										class="form-control xCNInputWithoutSpcNotThai"
										maxlength="20"
										id="oetXthDocNo"
										name="oetXthDocNo"
										data-is-created="<?php  ?>"
										placeholder="<?= language('document/adjuststockvd/adjuststockvd', 'tADJVDDocNo')?>"
										value="<?=$tXthDocNo; ?>"
										readonly>
								</div>
							</div>
						<?php } ?>

						<!--วันที่เอกสาร-->
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDDocDate'); ?></label>
							<div class="input-group">
								<input 
									type="text"
									class="form-control xCNDatePicker xCNInputMaskDate"
									id="oetXthDocDate" 
									name="oetXthDocDate" 
									value="<?=$dXthDocDate; ?>" 
									data-validate="<?=language('document/adjuststockvd/adjuststockvd', 'tADJVDPlsEnterDocDate'); ?>"
									<?php echo ($tXthStaApv == '1')? 'disabled' : ''; ?>
								>
								<span class="input-group-btn">
									<button id="obtXthDocDate" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>

						<!--เวลาเอกสาร-->
						<div class="form-group">
							<label class="xCNLabelFrm"><span style="color:red">*</span><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDDocTime'); ?></label>
							<div class="input-group">
								<input 
									type="text"
									class="form-control xCNTimePicker"
									id="oetXthDocTime"
									name="oetXthDocTime"
									value="<?=$tXthDocTime; ?>"
									data-validate="<?=language('document/adjuststockvd/adjuststockvd', 'tADJVDPlsEnterDocTime'); ?>"
									<?php echo ($tXthStaApv == '1')? 'disabled' : ''; ?>
								>
								<span class="input-group-btn">
									<button id="obtXthDocTime" type="button" class="btn xCNBtnDateTime">
										<img src="<?= base_url().'/application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
									</button>
								</span>
							</div>
						</div>

						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDCreateBy'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<input type="text" class="xCNHide" id="oetCreateBy" name="oetCreateBy" value="<?=$tCreateBy?>">
								<label><?=$tUsrNameCreateBy?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDTBStaDoc'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDStaDoc'.$tXthStaDoc); ?></label>
							</div>
						</div>
						<div class="row">
							<div class="col-md-6">
								<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDTBStaApv'); ?></label>
							</div>
							<div class="col-md-6 text-right">
								<label><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDStaApv'.$tXthStaApv); ?></label>
							</div>
						</div>
						<?php if($tXthDocNo != ''){ ?>
							<div class="row">
								<div class="col-md-6">
									<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDApvBy'); ?></label>
								</div>
								<div class="col-md-6 text-right">
									<input type="text" class="xCNHide" id="oetXthApvCode" name="oetXthApvCode" maxlength="20" value="<?=$tXthApvCode?>">
									<label><?=$tXthUsrNameApv != '' ? $tXthUsrNameApv : language('document/adjuststockvd/adjuststockvd', 'tADJVDStaDoc'); ?></label>
								</div>
							</div>
						<?php } ?>
					</div>
				</div>
			</div>
			<div class="panel panel-default" style="margin-bottom: 25px;">
				<div id="odvHeadGeneralInfo" class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
					<label class="xCNTextDetail1"><?=language('document/adjuststockvd/adjuststockvd', 'เงื่อนไขการตรวจนับ'); ?></label>
					<a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvDataADJVD" aria-expanded="true">
						<i class="fa fa-plus xCNPlus"></i>
					</a>
				</div>
				<div id="odvDataADJVD" class="panel-collapse collapse in" role="tabpanel">
					<div class="panel-body xCNPDModlue">

						<!-- สาขา -->
						<script>
                            var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                            if( tUsrLevel != "HQ" ){
                                var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount");?>';
                                if(tBchCount < 2){
                                    $('#obtBrowseBCH_ADJVending').attr('disabled',true);
                                }
                            }
                        </script>
						<div class="row">
							<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
								<div class="form-group">
									<label class="xCNLabelFrm"><?=language('document/adjuststock/adjuststock','tASTBranch');?></label>
									<div class="input-group">
										<input
											type="text"
											class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
											id="oetBchCode"
											name="oetBchCode"
											maxlength="5"
											value="<?=$tBchCode?>"
										>
										<input
											type="text"
											class="form-control xWPointerEventNone"
											id="oetBchName"
											name="oetBchName"
											maxlength="100"
											placeholder="<?=language('document/adjuststock/adjuststock','tASTBranch');?>"
											value="<?=$tBchName?>"
											readonly
										>
										<span class="input-group-btn">
											<button id="obtBrowseBCH_ADJVending" type="button" class="btn xCNBtnBrowseAddOn">
												<img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
											</button>
										</span>
									</div>
								</div>
							</div>
						</div>

						<!-- กลุ่มร้านค้า -->
						<script>
                            var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                            if( tUsrLevel == "SHP" ){
								$('#obtADJVDBrowseMch').attr('disabled',true);
								$('#oetMchCode').val('<?=$this->session->userdata("tSesUsrMerCode");?>');
								$('#oetMchName').val('<?=$this->session->userdata("tSesUsrMerName");?>');
                            }
                        </script>
						<div class="form-group <?=!FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
							<label class="xCNLabelFrm">กลุ่มร้านค้า</label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetMchCode" name="oetMchCode" maxlength="5" value="<?=$tMchCode?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetMchName" name="oetMchName" value="<?=$tMchName?>" placeholder="กลุ่มร้านค้า" readonly>
								<span class=" input-group-btn">
									<button id="obtADJVDBrowseMch" type="button" class=" btn xCNBtnBrowseAddOn">
										<img src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>

						<!-- ร้านค้า -->
						<script>
                            var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
                            if( tUsrLevel == "SHP" ){
								var tSHPCount	= '<?=$this->session->userdata("nSesUsrShpCount");?>';
                                if(tSHPCount < 2){
									$('#obtADJ_VendingBrowseShp').attr('disabled',true);
                                }else{
									$('#obtADJ_VendingBrowseShp').removeClass('xCNClassBlockEventClick');
									$('#obtADJ_VendingBrowseShp').removeClass('disabled');
									$('#obtADJ_VendingBrowseShp').attr('disabled',false);
								}

								if('<?=$aResult['rtCode']?>' != 1){ //เข้ามาแบบขา Insert
									$('#oetShpCodeStart').val('<?=$this->session->userdata("tSesUsrShpCodeDefault");?>');
									$('#oetShpNameStart').val('<?=$this->session->userdata("tSesUsrShpNameDefault");?>');
								}

								//ถ้าเป็นร้านค้า เครื่องจุดขายต้องเปิด
								$('#obtADJVDBrowsePosStart').removeClass('xCNClassBlockEventClick');
								$('#obtADJVDBrowsePosStart').removeClass('disabled');
								$('#obtADJVDBrowsePosStart').attr('disabled',false);
                            }
                        </script>
						<div class="form-group <?= !FCNbGetIsShpEnabled() ? 'xCNHide' : ''; ?>">
							<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDShopVD'); ?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetShpCodeStart" name="oetShpCodeStart" maxlength="5" value="<?=$tShpCodeStart;?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetShpNameStart" name="oetShpNameStart"  placeholder="<?=language('document/adjuststockvd/adjuststockvd', 'tADJVDShopVD'); ?>" value="<?=$tShpNameStart;?>" readonly>
								<span class=" input-group-btn">
									<button class="btn xCNBtnBrowseAddOn" id="obtADJ_VendingBrowseShp" type="button">
										<img src="<?=base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>

						<!-- เครื่องจุดขาย -->
						<div class="form-group">
							<label class="xCNLabelFrm"><span class="text-danger">*</span><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDPos'); ?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetPosCodeStart" name="oetPosCodeStart" maxlength="5" value="<?=$tPosCodeStart?>">
								<input class="form-control xWPointerEventNone" type="text" id="oetPosNameStart" name="oetPosNameStart" placeholder="<?=language('document/adjuststockvd/adjuststockvd', 'tADJVDPos'); ?>" value="<?=$tPosNameStart?>" readonly>
								<span class=" input-group-btn ">
									<button id="obtADJVDBrowsePosStart" type="button" class="btn xCNBtnBrowseAddOn xCNClassBlockEventClick">
										<img src="<?= base_url().'application/modules/common/assets/images/icons/find-24.png'?>">
									</button>
								</span>
							</div>
						</div>

						<!-- คลัง -->
						<div class="form-group">
							<label class="xCNLabelFrm"><?=language('document/adjuststockvd/adjuststockvd', 'tADJVDPosWah'); ?></label>
							<div class="">
								<input class="form-control xCNHide" type="text" name="ohdWahCodeStart" id="ohdWahCodeStart" value="<?=$tWahCodeStart?>">
								<input name="oetWahNameStart" id="oetWahNameStart" class="form-control" value="<?=$tWahNameStart?>" type="text" readonly=""
									data-validate="กรุณาระบุคลังเครื่องจุดขาย"
									placeholder="คลังเครื่องจุดขาย"
								>
								<span class="input-group-btn" style="display:none;">
									<button id="obtADJVDBrowseWah" class="btn xCNBtnBrowseAddOn xCNClassBlockEventClick" type="button">
										<img src="<?= base_url() . '/application/modules/common/assets/images/icons/find-24.png' ?>">
									</button>
								</span>
							</div>
						</div>

						<!-- เหตุผล -->
						<div class="form-group">
							<label class="xCNLabelFrm"><span class="text-danger">*</span><?=language('document/adjuststock/adjuststock', 'tASTReason'); ?></label>
							<div class="input-group">
								<input class="form-control xCNHide" id="oetASTRsnCode" name="oetASTRsnCode" maxlength="5" value="<?=$tRsCode?>">
								<input type="text" class="form-control xWPointerEventNone" id="oetASTRsnName" name="oetASTRsnName" value="<?=$tRsName?>" readonly data-validate="<?=language('document/adjuststock/adjuststock', 'tASTPlsEnterReason'); ?>"
								>
								<span class="input-group-btn">
									<button id="obtASTBrowseRsn" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
								</span>
							</div>
						</div>

						<!-- สถานะเคลื่อนไหว-->
						<div class="form-group">
							<label class="fancy-checkbox">
								<input type="checkbox" value="1" id="ocbASTStaDocAct" name="ocbASTStaDocAct" maxlength="1"
									<?php
										if($nXthStaDocAct == 1 && $nXthStaDocAct != 0){
											echo 'checked';
										}else if($nXthStaDocAct == 99){
											echo 'checked';
										}
									?>>
									<span>&nbsp;</span>
									<span class="xCNLabelFrm"><?php echo language('document/adjuststockvd/adjuststockvd','tADJVDStaDocAct');?></span>
							</label>
						</div>

						<div class="row xCNMarginTop30px">
							<div class="col-md-6 btn-group xCNDropDrownGroup">
								<button type="button" id="obtADJVDControlFormClear" class="btn xCNBTNMngTable xCNWhenAprOrCancel" style="width:100%;font-size: 17px;"><?=language('document/adjuststock/adjuststock', 'tASTClearData'); ?></button>
							</div>
							<div class="col-md-6">
								<button type="button" id="obtADJVDControlFormSearchPDT" class="btn btn-primary xCNWhenAprOrCancel" disabled style="width:100%;font-size: 17px;"><?=language('document/adjuststock/adjuststock', 'ตรวจสอบ'); ?></button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="col-md-9" id="odvRightPanal">
			<div class="panel panel-default" style="margin-bottom: 25px;position: relative;min-height: 200px;">
				<div class="panel-collapse collapse in" role="tabpanel" data-grpname="Condition">
					<div class="panel-body xCNPDModlue">
						<div class="row" style="margin-top: 10px;">
							<div class="col-md-6">
								<div class="form-group">
									<div class="input-group">
										<input type="text" class="form-control" maxlength="100" id="oetSearchPdtHTML" name="oetSearchPdtHTML" onkeyup="JSvDOCSearchPdtHTML()" placeholder="<?=language('document/adjuststockvd/adjuststockvd', 'tADJVDSearchPdt'); ?>">
										<input type="text" class="form-control" maxlength="100" id="oetScanPdtHTML" name="oetScanPdtHTML" onkeyup="Javascript:if(event.keyCode==13) JSvADJVDScanPdtHTML()" placeholder="<?=language('document/adjuststockvd/adjuststockvd', 'tADJVDScanPdt'); ?>" style="display:none;" data-validate="<?=language('document/adjuststockvd/adjuststockvd', 'tTFXVDSearchNotFound'); ?>">
										<span class="input-group-btn">
											<div id="odvMngTableList" class="xCNDropDrownGroup input-group-append">
												<button id="oimMngPdtIconSearch" type="button" class="btn xCNBTNMngTable xCNBtnDocSchAndScan" onclick="JSvDOCSearchPdtHTML()">
													<img  src="<?=base_url().'application/modules/common/assets/images/icons/search-24.png'?>" style="width:20px;">
												</button>
											</div>
										</span>
									</div>
								</div>
							</div>

							<!-- ตัวเลือกข้อมูล Delete Multi -->
							<!-- Create By WItsarut 2/09/2020 -->
							<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
								<div id="odvADJVDMngDelPdtInTableDT" class="btn-group xCNDropDrownGroup">
									<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
										<?= language('common/main/main', 'tCMNOption') ?>
										<span class="caret"></span>
									</button>
									<ul class="dropdown-menu" role="menu">
										<li id="oliADJVDBtnDeleteMulti" class="disabled">
											<a data-toggle="modal" data-target="#odvADJVDModalDelPdtInDTTempMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
										</li>
									</ul>
								</div>
							</div>
						</div>
						<div id="odvContentPdtTableADJVDPanal"></div>
					</div>
				</div>
			</div>
		</div>
	</div>
</form>

<!--กรุณาเลือกเหตุผล-->
<div class="modal fade" id="odvADJVDReasonIsNull">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv">กรุณากรอกเหตุผลในการตรวจนับครั้งนี้</p>
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--อนุมัติ-->
<div class="modal fade xCNModalApprove" id="odvADJVDPopupApv">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('common/main/main','tApproveTheDocument'); ?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p><?=language('common/main/main','tMainApproveStatus'); ?></p>
					<ul>
						<li><?=language('common/main/main','tMainApproveStatus1'); ?></li>
						<li><?=language('common/main/main','tMainApproveStatus2'); ?></li>
						<li><?=language('common/main/main','tMainApproveStatus3'); ?></li>
						<li><?=language('common/main/main','tMainApproveStatus4'); ?></li>
					</ul>
				<p><?=language('common/main/main','tMainApproveStatus5'); ?></p>
				<p><strong><?=language('common/main/main','tMainApproveStatus6'); ?></strong></p>
			</div>
			<div class="modal-footer">
				<button onclick="JSxADJVDApprove(true)" type="button" class="btn xCNBTNPrimery">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--ยกเลิกเอกสาร-->
<div class="modal fade" id="odvADJVDPopupCancel">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocCancelTheDocument'); ?></label>
			</div>
			<div class="modal-body">
                <p id="obpMsgApv"><?=language('document/document/document','tDocCancelAlert1'); ?></p>
                <p><strong><?=language('document/document/document','tDocCancelAlert2'); ?></strong></p>
			</div>
			<div class="modal-footer">
                <button onclick="JSxADJVDCancel(true)" type="button" class="btn xCNBTNPrimery">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="odvADJVDChangeData">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
                <p id="obpMsgApv">ข้อมูลทั้งหมดจะถูกลบเมื่อเปลี่ยนเงื่อนไข กดยืนยันเพื่อทำรายการใหม่</p>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xCNConfrimChangeData">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!--สินค้า มีการตรวจนับเป็น 0-->
<div class="modal fade" id="odvADJVDCheckItemHaveAdjZero">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?=language('document/adjuststockvd/adjuststockvd','tDocADJZero'); ?></p>
			</div>
			<div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xCNConfrimCheckItemHaveAdjZero">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>

<!-- Modal แจ้งเตือน ลบ ข้อมูลรายการสินค้าทั้งหมด -->
<div class="modal fade" 	id="odvADJVDPopupFoundDataInTblDT">
	<input type="hidden" 	id="odvADJVDTypeClick" name="odvADJVDTypeClick">
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





<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<?php include('script/jAdjust_stock_vending.php')?>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
