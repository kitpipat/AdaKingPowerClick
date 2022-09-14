<?php

	if(isset($aResult['rtCode']) && $aResult['rtCode'] == 1){
		$tRoute				= 'branchEventEdit';
		// Control Tab Menu
		$tMenuTabDisable	= "";
		$tMenuTabToggle		= "tab";

		// Data Form Info
		$dBchStart       	= $aResult['roItem']['rdBchStart'];
		$dBchStop       	= $aResult['roItem']['rdBchStop'];
		$dBchSaleStart      = $aResult['roItem']['rdBchSaleStart'];
		$dBchSaleStop       = $aResult['roItem']['rdBchSaleStop'];
		$tBchType       	= $aResult['roItem']['rtBchType'];
		$tBchCode       	= $aResult['roItem']['rtBchCode'];
		$tBchName			= $aResult['roItem']['rtBchName'];
		$tBchWahCode		 = $aResult['roItem']['rtWahCode'];
		$tBchWahName		= $aResult['roItem']['rtWahName'];
		$tBtnWahCode        = "";
		$tBchRmk			= $aResult['roItem']['rtBchRmk'];
		$tBchPriority       = $aResult['roItem']['rtBchPriority'];
		$tBchRefID       	= $aResult['roItem']['rtBchRefID'];
		$tBchStaActive      = $aResult['roItem']['rtBchStaActive'];
		$tBchRegNo			= $aResult['roItem']['rtBchRegNo'];
		$tBchStaHQ			= $aResult['roItem']['rtBchStaHQ'];
		$tSysLangBCH		= $aResult['roItem']['FNBchDefLang'];
		$tBchPplCode		= $aResult['roItem']['rtPplCode'];
		$tBchPplName		= $aResult['roItem']['rtPplName'];
		// $tBchMerCode		= $aResult['roItem']['rtMerCode'];
		// $tBchMerName		= $aResult['roItem']['rtMerName'];
		$tBchAgnCode		= $aResult['roItem']['FTAgnCode'];
		$tBchAgnName		= $aResult['roItem']['FTAgnName'];
	}else{
		$tRoute				= 'branchEventAdd';
		// Control Tab Menu
		$tMenuTabDisable	= " disabled xCNCloseTabNav";
		$tMenuTabToggle 	= "false";

		// Data Form Info
		$dBchStart		= date('Y-m-d');
		$dBchStop	    = date('Y-m-d', strtotime('+1 year'));
		$dBchSaleStart  = date('Y-m-d');
		$dBchSaleStop   = date('Y-m-d', strtotime('+1 year'));
		$tBchType		= "";
		$tBchCode		= "";
		$tBchName       = "";
		$tBchWahCode	= "00001";
		$tBchWahName	= "คลังขาย";
		$tBtnWahCode    = "disabled";
		$tBchRmk        = "";
		$tBchPriority	= "";
		$tBchRefID		= "";
		$tBchStaActive	= "";
		$tBchRegNo		= "";
		$tBchStaHQ		= "";
		$tSysLangBCH	= 1;
		$tPplCode		= "";
		$tPplName		= "";
		// $tBchMerCode	= "";
		// $tBchMerName	= "";
		$tBchAgnCode		= "";
		$tBchAgnName		= "";
	}
?>
<div id="odvBranchPanelBody" class="panel-body" style="padding-top:10px !important;">
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<li id="oliBchTabInfoNav" class="xCNBCHTab active" data-typetab="main" data-tabtitle="bchinfo">
						<a role="tab" data-toggle="tab" data-target="#odvBranchDataInfo" aria-expanded="true">
							<?php echo language('company/branch/branch','tBCHHeadTabInfo')?>
						</a>
					</li>
					<li id="oliBchTabInfoNav" class="xCNBCHTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="bchaddress">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvBranchDataAddress" aria-expanded="true">
							<?php echo language('company/branch/branch','tBCHHeadTabAddress')?>
						</a>
					</li>
					<li id="oliBchSetConnect" class="xCNBCHTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="bchsetconnection">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvBranchSetConnection"  aria-expanded="true">
							<?php //echo language('company/branch/branch', 'tBCHSettingconnection') ?>
						</a>
					</li>
				</ul>
			</div>
			<div id="odvBchContentDataTab" class="row">
				<div class="col-xs-12 col-sm-12 col-md-12 col-xs-12">
					<div class="tab-content">
						<!-- Tab Info Data Branch -->
						<div id="odvBranchDataInfo" class="tab-pane active" style="margin-top:10px;" role="tabpanel" aria-expanded="true">
							<div class="row" style="margin-right:-30px; margin-left:-30px;">
								<div class="main-content" style="padding-bottom:0px !important;">
									<form id="ofmAddBranch" class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data">
										<input type="hidden" id="ohdBchPriority" value="<?php echo @$tBchPriority ?>">
										<input type="hidden" id="ohdBchType" value="<?php echo @$tBchType?>">
										<input type="hidden" id="ohdBchStaActive" value="<?php echo @$tBchStaActive?>">
										<input type="hidden" id="ohdBchRouteData" name="ohdBchRouteData" value="<?php echo $tRoute;?>">
										<button
											type="submit"
											id="obtSubmitBch"
											class="btn xCNHide"
											onclick="JSnAddEditBranch('','odvContentPanalBranch','BranchList','1','99','<?php echo @$tRoute?>','');">
										</button>
										<div class="row">
											<div class="col-xs-12 col-sm-12 col-md-4 col-lg-4">
												<?php echo FCNtHGetContentUploadImage(@$tImgObjPath, 'branch');?>
											</div>
											<div class="col-xs-12 col-sm-12 col-md-8 col-lg-8">
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('company/branch/branch','tBchCode');?></label>
															<div id="odvBchAutoGenCode" class="form-group">
																<div class="validate-input">
																	<label class="fancy-checkbox">
																		<input type="checkbox" id="ocbBrachAutoGenCode" name="ocbBrachAutoGenCode" checked="true" value="1">
																		<span> <?php echo language('common/main/main','tGenerateAuto');?></span>
																	</label>
																</div>
															</div>
															<div id="odvBchCodeForm" class="form-group">
																<input type="hidden" id="ohdCheckDuplicateBchCode" name="ohdCheckDuplicateBchCode" value="1">
																<div class="validate-input">
																	<input
																		type="text"
																		class="form-control xCNGenarateCodeTextInputValidate"
																		maxlength="5"
																		id="oetBchCode"
																		name="oetBchCode"
																		value="<?php echo $tBchCode;?>"
																		data-is-created="<?php echo $tBchCode;?>"
																		autocomplete="off"
																		placeholder="<?php echo language('company/branch/branch','tBchCode');?>"
																		data-validate-required="<?php echo language('company/branch/branch','tSHPValiBranchCode');?>"
																		data-validate-dublicateCode="<?php echo language('company/branch/branch','tSHPValidCheckCode');?>"
																	>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="row">
												   <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm">
																<span class="text-danger">*</span> <?php echo language('company/branch/branch','tBCHName');?>
															</label>
															<input
																type="text"
																class="form-control"
																maxlength="100"
																id="oetBchName"
																name="oetBchName"
																autocomplete="off"
																placeholder="<?php echo language('company/branch/branch','tBCHName');?>"
																data-validate-required ="<?php echo language('company/branch/branch','tSHPValiBranchName')?>"
																value="<?php echo @$tBchName?>"
															>
														</div>
													</div>

													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
													</div>

													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHWarehouse');?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetBchWahCode" name="oetBchWahCode" value="<?php echo @$tBchWahCode; ?>">
																<input type="text" class="form-control xWPointerEventNone" id="oetBchWahName" name="oetBchWahName" value="<?php echo @$tBchWahName; ?>" readonly>
																<span class="input-group-btn">
																	<button id="obtBchBrowseWah" <?=$tBtnWahCode?> type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>

													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTPplRet');?></label>
															<div class="input-group">
																<input type="text" class="form-control xCNHide" id="oetBchPplRetCode" name="oetBchPplRetCode" value="<?php echo @$tBchPplCode; ?>">
																<input type="text" class="form-control xWPointerEventNone" id="oetBchPplRetName" name="oetBchPplRetName" value="<?php echo @$tBchPplName; ?>" readonly>
																<span class="input-group-btn">
																	<button id="oimBchBrowsePpl" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>

													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHBchType');?></label>

															<?php
																$tSesUsrLoginLevel = $this->session->userdata("tSesUsrLoginLevel");

																$tDisabled = '';
																if($this->session->userdata("tSesUsrAgnCode") != ""){
																	$tDisabled = "disabled";
																}
															?>
															<select class="selectpicker form-control" id="ocmBchType" name="ocmBchType" value="<?php echo @$tBchType;?>"  <?php echo $tDisabled ?>>
																<option value="1"<?php echo (@$tBchType == 1)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHBchTypeSEL1');?>
																</option>
																<option value="2"<?php echo (@$tBchType == 2)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHBchTypeSEL2');?>
																</option>
																<option value="3"<?php echo (@$tBchType == 3)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHBchTypeSEL3');?>
																</option>
																<option value="4"<?php echo (@$tBchType == 4 || $tDisabled == 'disabled')? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHBchTypeSEL4');?>
																</option>
															</select>
														</div>
													</div>

												</div>


												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><span class="text-danger">*</span> <?php echo language('company/branch/branch','tBCHBchRegNo');?></label>
															<input
																type="text"
																class="form-control"
																maxlength="30"
																id="oetBchRegNo"
																name="oetBchRegNo"
																autocomplete="off"
																placeholder="<?php echo language('company/branch/branch','tBCHBchRegNo');?>"
																data-validate-required ="<?php echo language('company/branch/branch','tSHPValiBchRegNo');?>"
																value="<?php echo @$tBchRegNo;?>"
															>
														</div>
													</div>

													<!-- Agency -->
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm xWBchDisplayAgency"><?php echo language('company/branch/branch','tBchAgnTitle');?></label>
															<div class="input-group xWBchDisplayAgency">
																<input type="text" class="form-control xCNHide" id="oetBchAgnCode" name="oetBchAgnCode" value="<?=$tBchAgnCode;?>">
																<input type="text" class="form-control xWPointerEventNone" id="oetBchAgnName" name="oetBchAgnName" value="<?=$tBchAgnName;?>" readonly>
																<span class="input-group-btn">
																	<button id="obtBchBrowseAgency" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
																</span>
															</div>
														</div>
													</div>
													<!-- Agency -->

												</div>
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHBchPriority');?></label>
															<select class="selectpicker form-control" id="ocmBchPriority" name="ocmBchPriority" value="<?php echo @$tBchPriority;?>">
																<option value="1"<?php echo (@$tBchPriority == 1)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHPriority1');?>
																</option>
																<option value="2"<?php echo (@$tBchPriority == 2)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHPriority2');?>
																</option>
																<option value="3"<?php echo (@$tBchPriority == 3)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHPriority3');?>
																</option>
																<option value="4"<?php echo (@$tBchPriority == 4)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHPriority4');?>
																</option>
																<option value="5"<?php echo (@$tBchPriority == 5)? " selected" : "";?>>
																	<?php echo language('company/branch/branch', 'tBCHPriority5');?>
																</option>
															</select>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHBchStaActive');?></label>
															<select class="selectpicker form-control" id="ocmBchStaActive" name="ocmBchStaActive" value="<?php echo @$tBchStaActive;?>">
																<option value="1"<?php (@$tBchStaActive == 1)? " selected" : "";?>>
																	<?php echo language('company/branch/branch','tBCHStaActive1');?>
																</option>
																<option value="2"<?php (@$tBchStaActive == 2)? " selected" : "";?>>
																	<?php echo language('company/branch/branch','tBCHStaActive2');?>
																</option>
															</select>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHBchStart');?></label>
															<div class="input-group">
																<input
																	type="text"
																	class="form-control xCNDatePicker xCNInputMaskDate text-center"
																	id="oetBchStart"
																	name="oetBchStart"
																	value="<?php echo @$dBchStart;?>"
																>
																<span class="input-group-btn">
																	<button id="obtBchStart" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
																</span>
															</div>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHBchStop');?></label>
															<div class="input-group">
																<input
																	type="text"
																	class="form-control xCNDatePicker xCNInputMaskDate text-center"
																	id="oetBchStop"
																	name="oetBchStop"
																	value="<?php echo @$dBchStop;?>"
																>
																<span class="input-group-btn">
																	<button id="obtBchStop" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tBCHBchSaleStart');?></label>
															<div class="input-group">
																<input
																	type="text"
																	class="form-control xCNDatePicker xCNInputMaskDate text-center"
																	id="oetBchSaleStart"
																	name="oetBchSaleStart"
																	value="<?php echo @$dBchSaleStart;?>"
																>
																<span class="input-group-btn">
																	<button id="obtBchSaleStart" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
																</span>
															</div>
														</div>
													</div>
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo language('company/branch/branch','tBCHBchSaleStop');?></label>
															<div class="input-group">
																<input
																	type="text"
																	class="form-control xCNDatePicker xCNInputMaskDate text-center"
																	id="oetBchSaleStop"
																	name="oetBchSaleStop"
																	value="<?php echo @$dBchSaleStop;?>"
																>
																<span class="input-group-btn">
																	<button id="obtBchSaleStop" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
																</span>
															</div>
														</div>
													</div>
												</div>
												<div class="row">
													<!--ภาษาของสาขา-->
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?=language('company/branch/branch','tBCHSystemLang');?></label>
															<select class="selectpicker form-control" id="ocmLangBchSystem" name="ocmLangBchSystem">
																<?php
																if($aSysLangForBch['rtCode'] == '800'){ ?>
																	<option value="0" selected><?=language('common/main/main', 'tCMNNotFoundData');?></option>
																<?php }else{ ?>
																	<?php for($i=0; $i<FCNnHSizeOf($aSysLangForBch); $i++){ ?>
																		<option value="<?=$aSysLangForBch['raItems'][$i]['FNLngID']?>" <?=(@$tSysLangBCH == $aSysLangForBch['raItems'][$i]['FNLngID'])? " selected" : "";?> "><?=$aSysLangForBch['raItems'][$i]['FTLngName'];?></option>
																	<?php } ?>
																<?php } ?>
															</select>
															<script>
																$('select[name=ocmLangBchSystem]').val('<?=$tSysLangBCH?>');
																$('.selectpicker').selectpicker('refresh');
															</script>
														</div>
													</div>

													<!--รหัสอ้างอิง-->
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="xCNLabelFrm"><?php echo  language('company/branch/branch','tBCHBchRefID')?></label>
															<input
																class="form-control"
																type="text" id="oetBchRefID"
																name="oetBchRefID"
																maxlength="30"
																placeholder="<?php echo language('company/branch/branch','tBCHBchRefID')?>"
																value="<?php echo @$tBchRefID?>"
															>
														</div>
													</div>
												</div>

												<div class="row">
													<div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
														<div class="form-group">
															<label class="fancy-checkbox">
																<script>
																	var tBchStaHQ = "<?php echo $tBchStaHQ;?>";
																	if(tBchStaHQ == 1){
																		$('#ocbBchStaHQ').prop("checked",true);
																	}else{
																		$('#ocbBchStaHQ').prop("checked",false);
																	}
																</script>
																<input type="checkbox" id="ocbBchStaHQ" name="ocbBchStaHQ" value="1">
																<span><?php echo language('company/branch/branch','tBCHBchStaHQ')?></span>
															</label>
														</div>
													</div>
												</div>
											</div>
										</div>
									</form>
								</div>
							</div>
						</div>
						<!-- Tab SetingConection ตั้งค่าการเชื่อมต่อ -->
						<div id="odvBranchSetConnection" class="tab-pane fade">
							<div class="row" style="margin-right:-30px; margin-left:-30px;">
								<div class="main-content" style="padding-bottom:0px !important;">
								</div>
							</div>
						</div>
						<!-- Tab Info Data Branch Address -->
						<div id="odvBranchDataAddress" class="tab-pane fade">
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<?php include "script/jBranchAdd.php";?>
