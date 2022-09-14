<?php

	//เปลี่ยนคำตาม name POS + LAYOUT + LOCKER
	if($tNameMenuGroup == 'POS'){
		$tShopCode_lang 				= language('company/shop/shop','tShopCode_POS');
		$tShopName_lang					= language('company/shop/shop','tShopName_POS');
		$tShopNodata_lang				= language('company/shop/shop','tShopNodata_POS');
		$tSHPTitle_lang					= language('company/shop/shop','tSHPTitle_POS');
		$tSHPSubTitle_lang				= language('company/shop/shop','tSHPSubTitle_POS');
		$tSHPTitleAdd_lang				= language('company/shop/shop','tSHPTitleAdd_POS');
		$tSHPTitleEdit_lang				= language('company/shop/shop','tSHPTitleEdit_POS');
	}else if($tNameMenuGroup == 'LAYOUT'){
		$tShopCode_lang 				= language('company/shop/shop','tShopCode_LAYOUT');
		$tShopName_lang					= language('company/shop/shop','tShopName_LAYOUT');
		$tShopNodata_lang				= language('company/shop/shop','tShopNodata_LAYOUT');
		$tSHPTitle_lang					= language('company/shop/shop','tSHPTitle_LAYOUT');
		$tSHPSubTitle_lang				= language('company/shop/shop','tSHPSubTitle_LAYOUT');
		$tSHPTitleAdd_lang				= language('company/shop/shop','tSHPTitleAdd_LAYOUT');
		$tSHPTitleEdit_lang				= language('company/shop/shop','tSHPTitleEdit_LAYOUT');
	}else if($tNameMenuGroup == 'LOCKER'){
		$tShopCode_lang 				= language('company/shop/shop','tShopCode_LOCKER');
		$tShopName_lang					= language('company/shop/shop','tShopName_LOCKER');
		$tShopNodata_lang				= language('company/shop/shop','tShopNodata_LOCKER');
		$tSHPTitle_lang					= language('company/shop/shop','tSHPTitle_LOCKER');
		$tSHPSubTitle_lang				= language('company/shop/shop','tSHPSubTitle_LOCKER');
		$tSHPTitleAdd_lang				= language('company/shop/shop','tSHPTitleAdd_LOCKER');
		$tSHPTitleEdit_lang				= language('company/shop/shop','tSHPTitleEdit_LOCKER');
	}

	date_default_timezone_set("Asia/Bangkok");
	if ($aResList ['rtCode'] == '1') {
		$tBchCode			= $aResList ['raItem'] ['rtBchCode'];
		$tBchName 			= $aResList ['raItem'] ['rtBchName'];
		$tShpCode			= $aResList ['raItem'] ['rtShpCode'];
		$tShpName 			= $aResList ['raItem'] ['rtShpName'];
		$tWahCode 			= $aResList ['raItem'] ['rtWahCode'];
		$tWahName			= $aResList ['raItem'] ['rtWahName'];
		$tMerCode 			= $aResList ['raItem'] ['rtMerCode'];
		$tMerName			= $aResList ['raItem'] ['rtMerName'];
		$tShpType 			= $aResList ['raItem'] ['rtShpType'];
		$tShpRegNo 			= $aResList ['raItem'] ['rtShpRegNo'];
		$tShpRefID 			= $aResList ['raItem'] ['rtShpRefID'];
		$dShpStart 			= $aResList ['raItem'] ['rdShpStart'];
		$dShpStop 			= $aResList ['raItem'] ['rdShpStop'];
		$dShpSaleStart		= $aResList ['raItem'] ['rdShpSaleStart'];
		$dShpSaleStop		= $aResList ['raItem'] ['rdShpSaleStop'];
		$tShpStaActive		= $aResList ['raItem'] ['rtShpStaActive'];
		$tShpStaClose		= $aResList ['raItem'] ['rtShpStaClose'];
		$tShpStaShwPrice    = $aResList ['raItem'] ['rtShpStaShwPrice'];
		$tShpPplCode 		= $aResList ['raItem'] ['rtPplCode'];
		$tShpPplName		= $aResList ['raItem'] ['rtPplName'];
		$dGetDataNow        = "";
		$dGetDataFuture     = "";
		if($tShpStaShwPrice != "" && $tShpStaShwPrice != "2"){$tStaCheck = "checked='true'";}else{$tStaCheck = "";};

		if(isset($aAlwEventShop)){
			if($aAlwEventShop['tAutStaFull'] == 1 || $aAlwEventShop['tAutStaEdit'] == 1){
				$nAutStaEdit = 1;
			}else{
				$nAutStaEdit = 0;
			}
		}else{
			$nAutStaEdit = 0;
		}

		if( $tShpType != 4 && $tShpType != 6 ){
			$tRoute 			= 'shopEventEdit';
			$tMenuTabDisable   	= "";
			$tMenuTabDisableV 	= "disabled xWCloseTab";
			$tMenuTabToggleV    = "false";
			$tMenuTabToggle     = "tab";

		}else{
			$tRoute 			= 'shopEventEdit';
			$tMenuTabDisable   	= "";
			$tMenuTabDisableV   = "";
			$tMenuTabToggle     = "tab";
			$tMenuTabToggleV    = "tab";
		}
	} else {
		$tBchCode 			= $this->session->userdata('tSesUsrBchCodeDefault');
		$tBchName 			= $this->session->userdata('tSesUsrBchNameDefault');
		$dShpStart 		    = "";
		$dShpStop 			= "";
		$dShpSaleStart		= "";
		$dShpSaleStop		= "";
		$tShpCode			= "";
		$tShpType			= "";
		$nAutStaEdit 		= 0;
		$tMerCode 			= "";
		$tRoute 			= 'shopEventAdd';
		$tMenuTabDisable   	= " disabled xCNCloseTabNav";
		$tMenuTabDisableV 	= " disabled xCNCloseTabNav";
		$tMenuTabToggle     = "false";
		$tMenuTabToggleV    = "false";
		$dGetDataNow        = date('Y-m-d');
		$dGetDataFuture     = date('Y-m-d', strtotime('+1 year'));
		$tStaCheck 			= "checked='true'";
		$tShpPplCode 		=  "";
		$tShpPplName		=  "";
	}
?>
<input type="hidden" id="ohdShpAutStaEdit" value="<?= $nAutStaEdit?>">
<input id="oetSHPMerCode" type="hidden" value="<?= $tMerCode; ?>" >
<input id="oetSHPType"  type="hidden" value="<?= $tShpType; ?>" >

<div id="odvShopPanelBody" class="panel-body">
	<!-- Nav Tab Add Product -->
	<div id="odvShopRowNavMenu" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<!--
						เงื่อนไขเพิ่ม 1 กรกฎาคม 2562
						ถ้า shop type เป็น : 5 ตู้ฝากของ
						ต้องซ่อนแท็บ  - รูปแบบตู้ (vending)
									- ประเภทตู้ (vending)
									- GP สินค้า
						ต้องเปิดแท็บ  - ประเภทตู้ (locker)
									- ขนาด (locker)
									- รูปแบบตู้ (loker)
					-->
					<!--ข้อมูลทั่วไป-->
					<li id="oliSHPDetail" class="xCNSHPTab active" data-typetab="main" data-tabtitle="shpinfo">
						<a role="tab" data-toggle="tab" data-target="#odvSHPContentInfoDT" aria-expanded="true">
							<?php echo language('company/shop/shop','tNameTabNormal');?>
						</a>
					</li>

					<?php if($tNameMenuGroup != 'LOCKER'){ ?> <!-- Locker ไม่ใช้คลัง -->
					<!-- คลังสินค้า -->
					<li id="oliSHPWah" class="xCNSHPTab<?php echo @$tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="shpwah" onclick="JSxShpWahGetContent();">
						<a role="tab" data-toggle="<?php echo @$tMenuTabToggle;?>" data-target="#odvSHPWah" aria-expanded="true">
							<?php echo language('company/shop/shop','tSHPWah');?>
						</a>
					</li>
					<?php } ?>

					<?php if( $tShpType == 4 || $tShpType == 6 ){ ?>
						<!--เครื่องจุดขาย-->
						<li id="oliSHPPOSShop" class="xCNSHPTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="shpposshop">
							<a role="tab" data-toggle="<?php echo $tMenuTabToggle?>" data-target="#odvSHPContentInfoPS" aria-expanded="false">
								<?php echo language('company/shop/shop','tNameTabPosshop')?>
							</a>
						</li>

						<!-- ชั้นตู้ cabinet-->
						<li id="oliSHPVedingCabinet" class="xCNSHPTab<?php echo $tMenuTabDisableV;?>" data-typetab="sub" data-tabtitle="shpvdcabinet">
							<a role="tab" data-toggle="<?php echo $tMenuTabToggleV?>" data-target="#odvSHPContentInfoCabinet" aria-expanded="false">
								<?php echo language('company/shop/shop','tNameTabVendingCabinet');?>
							</a>
						</li>

						<!--รูปแบบตู้ vending-->
						<li id="oliSHPVedingShoplayout" class="xCNSHPTab<?php echo $tMenuTabDisableV;?>" data-typetab="sub" data-tabtitle="shpvdlayout">
							<a role="tab" data-toggle="<?php echo $tMenuTabToggleV?>" data-target="#odvSHPContentInfoVLY" aria-expanded="false"><?php echo language('company/shop/shop','tNameTabVendinglayOut')?></a>
						</li>

						<!--ประเภทตู้ vending-->
						<!-- <li id="oliSHPVedingType" class="xCNSHPTab<?php //echo $tMenuTabDisableV;?>" data-typetab="sub" data-tabtitle="shpvdtype">
							<a role="tab" data-toggle="<?php //echo $tMenuTabToggleV?>" data-target="#odvSHPContentInfoVT" aria-expanded="false">
								<?php //echo language('company/shop/shop','tNameTabVendingType');?>
							</a>
						</li> -->

					<?php }else if($tShpType == 5){ ?>
						<!--เครื่องจุดขาย-->
						<li id="oliSHPPOSShop" class="xCNSHPTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="shpposshop">
							<a role="tab" data-toggle="<?php echo $tMenuTabToggle?>" data-target="#odvSHPContentInfoPS" aria-expanded="false">
								<?php echo language('company/shop/shop','tNameTabPosshop')?>
							</a>
						</li>
						<!--ขนาด smart locker-->
						<li id="oliSmartLockerSize" class="xCNSHPTab" data-typetab="sub" data-tabtitle="shplksize">
							<a role="tab" data-toggle="tab" data-target="#odvSHPContentSmartLockerSize" aria-expanded="false">
								<?php echo language('company/shop/shop','tNameTabSmartLockerSize');?>
							</a>
						</li>
						<!--กลุ่มช่อง smart locker-->
						<li id="oliSmartLockerRack" class="xCNSHPTab" data-typetab="sub" data-tabtitle="shpRack">
							<a role="tab" data-toggle="tab" data-target="#odvSHPContentRack" aria-expanded="false">
								<?php echo language('company/rack/rack','tRckTitle');?>
							</a>
						</li>
						<!--ประเภทตู้ smart locker-->
						<li id="oliSmartLockerType" class="xCNSHPTab" data-typetab="sub" data-tabtitle="shplktype">
							<a role="tab" data-toggle="tab" data-target="#odvSHPContentSmartLockerType" aria-expanded="false">
								<?php echo language('company/shop/shop','tNameTabSmartLockerLayout');?>
							</a>
						</li>
						<!--รูปแบบตู้ smart locker-->
						<li id="oliSmartLockerLayout" class="xCNSHPTab" data-typetab="sub" data-tabtitle="shplklayout">
							<a role="tab" data-toggle="tab" data-target="#odvSHPContentSmartLockerLayout" aria-expanded="false">
								<?php echo language('company/shop/shop','tNameTabSmartLockeType');?>
							</a>
						</li>
					<?php } ?>

					<!--GP ร้านค้า-->
					<!-- <li id="oliSHPGPShop" class="xCNSHPTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="shpgpshop">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle?>" data-target="#odvSHPContentInfoGPS" aria-expanded="false">
							<?php echo language('company/shop/shop','tNameTabGPShop');?>
						</a>
					</li> -->

					<?php if($tShpType != 5){ ?>
					<!--GP สินค้า-->
					<!-- <li id="oliSHPGPProduct" class="xCNSHPTab<?php echo $tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="shpgpproduct">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle?>" data-target="#odvSHPContentInfoGPP" aria-expanded="false">
							<?php echo language('company/shop/shop','tNameTabGPProduct');?>
						</a>
					</li> -->

					<?php } ?>
					<!-- ที่อยู่ร้านค้า -->
					<li id="oliSHPAddress" class="xCNSHPTab<?php echo @$tMenuTabDisable;?>" data-typetab="sub" data-tabtitle="shpaddress">
						<a role="tab" data-toggle="<?php echo @$tMenuTabToggle;?>" data-target="#odvSHPAddressData" aria-expanded="true">
							<?php echo language('company/shop/shop','tNameTabAddress');?>
						</a>
					</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- Content tab Add Product -->
	<div id="odvPdtShopContentMenu" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="tab-content">
				<!-- Tab Content Detail -->
				<div id="odvSHPContentInfoDT" class="tab-pane fade active in">
					<form class="validate-form"  action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddShop">
						<div class=""  style="padding-top:0px !important;">
							<input type="text" class="xCNHide" id="ohdBchCode" name="ohdBchCode"
								value="<?php echo @$tBchCode?>"> <input type="text" class="xCNHide"
								id="ohdShpCode" name="ohdShpCode" value="<?php echo @$tShpCode?>"> <input
								type="text" class="xCNHide" id="ohdShpType" name="ohdShpType"
								value="<?php echo @$tShpType?>">
								<input type="text" class="xCNHide" id="ohdShpStaActive" name="ohdShpStaActive" value="<?php echo @$tShpStaActive?>">
								<input type="text" class="xCNHide" id="ohdShpStaClose" name="ohdShpStaClose" value="<?php echo @$tShpStaClose?>">

							<button class="btn btn-default xCNHide" id="obtSubmitShp" type="submit" onclick="JSnAddEditShop('<?php echo @$tRoute ?>','<?php echo @$tStaPage?>')">
								<i class="fa fa-floppy-o"></i> <?php echo language('common/main/main', 'tSave')?>
							</button>
							<div class="row">
								<div class="col-md-3" style="display:none;">
									<div class="form-group" >
										<div id="odvCompLogo">
											<?php
												if(isset($tImgObjAll) && !empty($tImgObjAll)){
													$tFullPatch = './application/modules/'.$tImgObjAll;
													if (file_exists($tFullPatch)){
														$tPatchImg = base_url().'/application/modules/'.$tImgObjAll;
													}else{
														$tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
													}
												}else{
													$tPatchImg = base_url().'application/modules/common/assets/images/300x60.png';
												}
											?>
											<img class="img-responsive xCNImgCenter" id="oimImgMastershop" name="oimImgMastershop" src="<?php echo $tPatchImg;?>">
										</div>
										<div class="form-group">
											<div class="xCNUplodeImage">
												<input type="text" class="xCNHide" id="oetImgInputshopOld" name="oetImgInputshopOld" value="<?php echo @$tImgName;?>">
												<input type="text" class="xCNHide" id="oetImgInputshop" name="oetImgInputshop" value="<?php echo @$tImgName;?>">
												<button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','shop')"><i class="fa fa-picture-o xCNImgButton"></i>  <?php echo language('common/main/main','tSelectPic')?></button>
											</div>
										</div>
									</div>
								</div>
								<div class="col-md-6">
									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<label class="xCNLabelFrm"><span style="color:red">*</span><?=$tShopCode_lang?></label>
											<div id="odvShopAutoGenCode" class="form-group">
												<div class="validate-input">
													<label class="fancy-checkbox">
														<input type="checkbox" id="ocbShopAutoGenCode" name="ocbShopAutoGenCode" checked="true" value="1">
														<span> <?=language('common/main/main', 'tGenerateAuto'); ?></span>
													</label>
												</div>
											</div>
											<div class="form-group" id="odvShopCodeForm">
												<input type="hidden" id="ohdCheckDuplicateShpCode" name="ohdCheckDuplicateShpCode" value="1">
												<div class="validate-input">
													<input
														type="text"
														class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
														maxlength="5"
														id="oetShpCode"
														name="oetShpCode"
														data-is-created="<?php echo @$tShpCode; ?>"
														placeholder="<?=$tShopCode_lang?>"
														value="<?php echo @$tShpCode; ?>"
														data-validate-required = "<?php echo language('company/shop/shop','tSHPValishopCode')?>"
														data-validate-dublicateCode = "<?php echo language('company/shop/shop','tSHPValishopCodeDup')?>"
													>
												</div>
											</div>
											<div class="form-group">
												<label class="xCNLabelFrm"><span style="color:red">*</span><?=$tShopName_lang?></label>
												<input
													type="text"
													class="form-control"
													id="oetShpName"
													name="oetShpName"
													placeholder="<?=$tShopName_lang?>"
													maxlength="100"
													value="<?php echo @$tShpName?>"
													data-validate-required = "<?php echo language('company/shop/shop','tSHPValishopName')?>"
												>
											</div>
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tType')?><?=$tSHPTitle_lang?></label>
													<?php if($tNameMenuGroup == 'POS') { ?>
														<select class="selectpicker form-control" id="ocmShpType" name="ocmShpType" maxlength="1" readonly>
															<option value="1"><?php echo language('company/shop/shop', 'tShpType1') ?></option>
															<option value="2"><?php echo language('company/shop/shop', 'tShpType2') ?></option>
															<option value="3"><?php echo language('company/shop/shop', 'tShpType3') ?></option>
														</select>
													<?php } ?>

													<?php if($tNameMenuGroup == 'LAYOUT') { ?>
														<select class="selectpicker form-control" id="ocmShpType" name="ocmShpType" maxlength="1" readonly>
															<option value="4"><?php echo language('company/shop/shop', 'tShpType4') ?></option>
															<!-- <option value="6"><?php //echo language('company/shop/shop', 'tShpType6') ?></option> -->
														</select>
													<?php } ?>

													<?php if($tNameMenuGroup == 'LOCKER'){ ?>
														<select class="selectpicker form-control" id="ocmShpType" name="ocmShpType" maxlength="1" readonly>
															<option value="5"><?php echo language('company/shop/shop', 'tShpType5') ?></option>
														</select>
													<?php } ?>
											</div>

											<script>
												var tUsrLevel = '<?=$this->session->userdata('tSesUsrLevel')?>';
												if( tUsrLevel != "HQ" ){
													// BCH - SHP
													var tBchCount = '<?=$this->session->userdata("nSesUsrBchCount")?>';
													if(tBchCount < 2){
														$('#oimShpBrowseBch').attr('disabled',true);
													}
												}
											</script>

											<div class="form-group">
												<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/branch/branch','tBCHTitle')?></label>
												<div class="input-group">
												 <?php 	//$this->session->userdata("tSesUsrLevel"); ?>
													<input type="hidden" id="oetShpBchCodeHidden" name="oetShpBchCodeHidden" maxlength="200" value="<?=@$tBchCode?>" >
													<input
														type="text"
														class="form-control xCNHide xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote"
														id="oetShpBchCode"
														name="oetShpBchCode"
														maxlength="200"
														value="<?php echo @$tBchCode?>"
													>
													<input
														type="text"
														class="form-control xWPointerEventNone"
														id="oetShpBchName"
														name="oetShpBchName"
														maxlength="100"
														placeholder="<?php echo language('company/shop/shop','tSHPValishopBranch')?>"
														value="<?php echo @$tBchName?>"
														data-validate-required = "<?=language('company/shop/shop','tSHPValishopBranch')?>"
														readonly
													>
													<span class="input-group-btn">
														<?php if ($this->session->userdata("tSesUsrLevel") != "HQ") { ?>
															<?php if($tNameMenuGroup == 'LAYOUT'){ ?>
																<button id="oimShpBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" disabled>
																	<img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
																</button>
															<?php }else{ ?>
																<button id="oimShpBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
																	<img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
																</button>
															<?php } ?>

														<?php }else { ?>
															<button id="oimShpBrowseBch" type="button" class="btn xCNBtnBrowseAddOn">
																<img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
															</button>
														<?php } ?>

													</span>
												</div>
											</div>

											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/merchant/merchant','tMerchantTitle')?></label>
												<div class="input-group">
													<input
														type="text"
														class="form-control xCNHide"
														id="oetShpMerCode"
														name="oetShpMerCode"
														maxlength="200"
														value="<?php echo @$tMerCode?>"
													>
													<input
														type="text"
														class="form-control xWPointerEventNone"
														id="oetShpMerName"
														name="oetShpMerName"
														maxlength="100"
														placeholder="<?php echo language('company/merchant/merchant','tSHPValishopMer')?>"
														value="<?php echo @$tMerName?>"
														data-validate-required = "<?php echo language('company/shop/shop','tSHPValishopMer')?>"
														readonly
													>
													<span class="input-group-btn">

													<!-- ตรวจสอบว่า shop นี้มีการผูก MerCode หรือยัง ถ้ามีแล้ว ไม่สามารถแก้ MerCode ได้ -->
													<!-- ถ้าเป็น LAYOUT ตู้ขายสินค้าจะไม่สามารถเเก้ Merchant ได้ -->
													<?php if($tNameMenuGroup == 'LAYOUT'){ ?>
														<?php if($tMerCode == ""){ ?>
															<button id="oimShpBrowseMer" type="button" class="btn xCNBtnBrowseAddOn">
																<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
															</button>
														<?php }else { ?>
															<button id="oimShpBrowseMer" type="button" class="btn xCNBtnBrowseAddOn" disabled>
																<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
															</button>
														<?php } ?>
													<?php }else{ ?>
														<button id="oimShpBrowseMer" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													<?php } ?>


													</span>
												</div>
											</div>

											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('customer/customer/customer','tCSTPplRet');?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNHide" id="oetBchPplRetCode" name="oetBchPplRetCode" value="<?php echo @$tShpPplCode; ?>">
													<input type="text" class="form-control xWPointerEventNone" id="oetBchPplRetName" name="oetBchPplRetName" value="<?php echo @$tShpPplName; ?>" readonly>
													<span class="input-group-btn">
														<button id="oimBchBrowsePpl" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
													</span>
												</div>
											</div>

										<!-- <div id="odvTypeWahCode">
											<div class="form-group">
												<input
													type="hidden"
													class="form-control xCNHide"
													id="ohdOldWahCode"
													name="ohdOldWahCode"
													maxlength="5"
													value="<?php echo @$tWahCode?>"
												>
												<label class="xCNLabelFrm"><span style ="color:red">*</span><?php echo language('company/branch/branch','tBCHWarehouse')?></label>
												<div class="input-group">
													<input
														type="text"
														class="form-control xCNHide"
														id="oetShpWahCode"
														name="oetShpWahCode"
														maxlength="5"
														value="<?php echo @$tWahCode?>"
													>
													<input
														type="text"
														class="form-control xWPointerEventNone"
														id="oetWahName"
														name="oetWahName"
														maxlength="100"
														placeholder="<?php echo language('company/shop/shop','tSHPValishopWarehouse')?>"
														value="<?php echo @$tWahName?>"
														data-validate-required = "<?php echo language('company/shop/shop','tSHPValishopWarehouse')?>"
														readonly
													>
													<span class="input-group-btn">
														<button id="oimShpBrowseWah" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div> -->
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpRegNo')?></label>
												<input type="text" class="form-control"
														id="oetShpRegNo" name="oetShpRegNo" maxlength="13" value="<?php echo @$tShpRegNo?>">
											</div>

											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpRefID')?></label>
												<input type="text" class="form-control" id="oetShpRefID" name="oetShpRefID" maxlength="30" value="<?php echo @$tShpRefID?>">
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStart')?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetShpStart" name="oetShpStart" value="<?php if($dShpStart != ""){ echo $dShpStart;}else{echo $dGetDataNow;}?>" >
													<span class="input-group-btn">
														<button id="obtShpStart" type="button" class="btn xCNBtnDateTime">
															<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStop')?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetShpStop" name="oetShpStop" value="<?php if($dShpStop != ""){ echo $dShpStop;}else{echo $dGetDataFuture;}?>">
													<span class="input-group-btn">
														<button id="obtShpStop" type="button" class="btn xCNBtnDateTime">
															<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpSaleStart')?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetShpSaleStart" name="oetShpSaleStart" value="<?php if($dShpSaleStart != ""){ echo $dShpSaleStart;}else{echo $dGetDataNow;}?>">
													<span class="input-group-btn">
														<button id="obtShpSaleStart" type="button" class="btn xCNBtnDateTime">
															<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>

										<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpSaleStop')?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNDatePicker xCNInputMaskDate text-center" id="oetShpSaleStop" name="oetShpSaleStop" value="<?php if($dShpSaleStop != ""){ echo $dShpSaleStop;}else{echo $dGetDataFuture;}?>">
													<span class="input-group-btn">
														<button id="obtShpSaleStop" type="button" class="btn xCNBtnDateTime">
															<img src="<?php echo  base_url().'application/modules/common/assets/images/icons/icons8-Calendar-100.png'?>">
														</button>
													</span>
												</div>
											</div>
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tShpStaActive')?></label>
												<select class="selectpicker form-control" id="ocmShpStaActive" name="ocmShpStaActive" maxlength="1">
													<!-- <option value=""><?php echo language('common/main/main', 'tCMNBlank-NA') ?></option> -->
													<option value="1"><?php echo language('company/branch/branch', 'tBCHStaActive1') ?></option>
													<option value="2"><?php echo language('company/branch/branch', 'tBCHStaActive2') ?></option>
												</select>
											</div>
										</div>
									</div>

									<!-- <div class="row xCNStaShwPrice">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPPriceDisplayStatus')?></label>
													<div class="form-check">
														<input type="checkbox" class="form-check-input" name="ocbShpStaShwPrice" id="ocbShpStaShwPrice" <?php echo $tStaCheck;?>>
														<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPShowPrice')?></label>
												</div>
											</div>
										</div>
									</div> -->

									<div class="row xCNStaShwPrice">
										<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
											<label class="xCNLabelFrm"><?php echo language('company/shop/shop','tSHPPriceDisplayStatus')?></label>
												<div id="odvShopAutoGenCode" class="form-group">
													<div class="validate-input">
													<label class="fancy-checkbox">
														<input type="checkbox" class="form-check-input" name="ocbShpStaShwPrice" id="ocbShpStaShwPrice" <?php echo $tStaCheck;?>>
														<span><?php echo language('company/shop/shop','tSHPShowPrice')?></span>
													</label>
												</div>
											</div>
										</div>
									</div>
								</div>


							</div>
						</div>
					</form>
				</div>

				<!-- Tab Shp Wah -->
				<div id="odvSHPWah" class="tab-pane fade">
				</div>

				<!-- Tab Shop Address -->
				<div id="odvSHPAddressData" class="tab-pane fade">
				</div>

				<!-- Tab Content POS Shop-->
				<div id="odvSHPContentInfoPS" class="tab-pane fade">
				</div>
				<?php if($tShpType != 5){ ?>
				<!--Tab Content Veding Shop layout -->
				<div id="odvSHPContentInfoVLY" class="tab-pane fade">
				</div>

				<!--Tab Content Veding Type -->
				<div id="odvSHPContentInfoVT" class="tab-pane fade">
				</div>

				<!--Tab Content Veding Cabinet -->
				<div id="odvSHPContentInfoCabinet" class="tab-pane fade">
				</div>

				<?php }else{ ?>

					<!--Tab Content Smart Locker Type -->
					<div id="odvSHPContentSmartLockerType" class="tab-pane fade"></div>

					<!--Tab Content Smart Locker Size -->
					<div id="odvSHPContentSmartLockerSize" class="tab-pane fade"></div>

					<!--Tab Content Smart Locker Layout -->
					<div id="odvSHPContentSmartLockerLayout" class="tab-pane fade"></div>

					<!--Tab Content Smart Locker Rack -->
					<div id="odvSHPContentRack" class="tab-pane fade"></div>

				<?php } ?>

				<!--Tab Content GP Product -->
				<?php if($tShpType != 5){ ?>
				<div id="odvSHPContentInfoGPP" class="tab-pane fade">
				</div>
				<?php } ?>

				<!--Tab Content GP Shop -->
				<div id="odvSHPContentInfoGPS" class="tab-pane fade">
				</div>

			</div>
		</div>
	</div>
	<!-- Content tab Add Product -->
</div>
<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jShopAdd.php"; ?>
