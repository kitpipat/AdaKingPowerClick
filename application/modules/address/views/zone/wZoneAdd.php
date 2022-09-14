<?php
 if(@$nResult['rtCode'] == '1'){
  //Success

  //Table Master
	$tZneCode       	= $nResult['roItem']['rtZneCode'];
	$nZneLevel      	= $nResult['roItem']['rnZneLevel'];
	$tZneParent     	= $nResult['roItem']['rtZneParent'];
	$tZneChain      	= $nResult['roItem']['rtZneChain'];
	$tAreCode      		= $nResult['roItem']['rtAreCode'];
	$tAreName       	= $nResult['roItem']['rtAreName'];  
	$tZneName       	= $nResult['roItem']['rtZneName'];
	$tZneParentName 	= $nResult['roItem']['rtZneParentName'];
	$tZneChainName  	= $nResult['roItem']['rtZneChainName'];
	$tZneRmk  			= $nResult['roItem']['rtZneRemark'];
	$tMenuTabDisable    = "";
	$tMenuTabToggle     = "tab";
	$tRoute 			= 'zoneEventEdit'; //Route ควบคุมการทำงาน Edit

 }else{

	$tZneCode       	= "";
	$nZneLevel      	= "";
	$tZneParent     	= "";
	$tZneChain      	= "";
	$tAreCode      		= "";
	$tAreName       	= "";
	$tZneName       	= "";
	$tZneParentName 	= "";
	$tZneChainName  	= "";
	$tZneRmk  			= "";
	$tRoute 			= 'zoneEventAdd'; //Route ควบคุมการทำงาน Add
	$tMenuTabDisable    = "disabled xWCloseTab";
	$tMenuTabToggle     = "false";
 }
?>


<input type="text" class="xCNHide" id="ohdZneParent" value="<?php echo @$tZneParent?>">
<div class="panel-body">	
	<!-- Nav Tab Add Product -->
	<div id="odvPdtRowNavMenu" class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
			<div class="custom-tabs-line tabs-line-bottom left-aligned">
				<ul class="nav" role="tablist">
					<li id="oliZneDataAddInfo1" class="xWMenu active" data-menutype="MN">
						<a role="tab" data-toggle="tab" data-target="#odvZneContentInfo" aria-expanded="true"><?php echo language('address/zone/zone','tZneTitle')?></a>
					</li>
				
					<li id="oliZneDataAddSet" class="xWMenu xWSubTab <?php echo $tMenuTabDisable;?>" data-menutype="SET">
						<a role="tab" data-toggle="<?php echo $tMenuTabToggle;?>" data-target="#odvZneContentSet" aria-expanded="false"><?php echo language('address/zone/zone','tZneRefer')?></a>
					</li>

				</ul>
			</div>
		</div>
	</div>
		
<div id="odvPdtRowContentMenu" class="row">		
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">	
		<div class="tab-content">
			<!-- Tab Content Detail  1-->
			<div id="odvZneContentInfo" class="tab-pane fade active in">
				<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddZone">
				<button style="display:none" type="submit" id="obtSubmitZne" onclick="JSnAddEditZone('<?php echo $tRoute?>');" class="btn xCNBTNPrimery xCNBTNPrimery2Btn xCNHide" ></button>	
					<div class="row">
						<div class="tab-content">
							<div class="col-md-12 xCNDivOverFlow">
									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<div class="validate-input">
													<label class="fancy-checkbox">
														<input class="ocbListItem"  id="ocbSelectRoot"  name="ocbSelectRoot" type="checkbox">
															<span class="xCNLabelFrm"> &nbsp; <?php echo language('address/zone/zone','tZNEFirstlevel')?></span>
													</label>
												</div>		
											</div>
										</div>
									</div>
									<div class="row xWPanalZneChain">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZNEChooseZone')?></label>
												<div class="input-group">
													<input type="text" class="xCNHide"  id="oetZneChainOld" name="oetZneChainOld" value="<?php echo @$tZneChain?>" >
													<input type="text" class="xCNHide"  id="oetZneParentNameOld" name="oetZneParentNameOld" placeholder="<?php echo language('address/zone/zone','tZNEChooseZone')?>" value="<?php echo @$tZneChainName?>">
													<input type="text" class="form-control xCNHide" id="oetZneParent" name="oetZneParent" value="<?php echo @$tZneParent?>">
													<input type="text" class="form-control xWPointerEventNone" id="oetZneParentName" name="oetZneParentName" maxlength="100" placeholder="<?php if(@$tZneChainName != ''){ echo @$tZneChainName; }else{echo language('address/zone/zone','tZneValiZone'); } ?>"  value="<?php echo @$tZneChainName ?>" readonly  data-validate="<?php echo language('address/zone/zone','tZneValiZone')?>">
													<span class="input-group-btn">
														<button id="oimBrowseZneParent" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div>
											
										</div>
									</div>

									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<!-- <div class="form-group">
												<label class="xCNLabelFrm"><?php echo language('address/area/area','tARETitle')?></label>
												<div class="input-group">
													<input type="text" class="form-control xCNHide" id="oetAreCode" name="oetAreCode" maxlength="5" value="<?php echo @$tAreCode?>">
													<input type="text" class="form-control xWPointerEventNone" id="oetAreName" name="oetAreName" maxlength="100" placeholder="#####" value="<?php echo @$tAreName?>" readonly>
													<span class="input-group-btn">
														<button id="oimBrowseArea" type="button" class="btn xCNBtnBrowseAddOn">
															<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
														</button>
													</span>
												</div>
											</div> -->
										</div>
									</div>

									
									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="row">
												<div class="col-md-12">
													<div class="form-group">
														<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('address/zone/zone','tZNECode')?><?php echo  language('address/zone/zone','tZNETitle')?></label>
															<div id="odvZneAutoGenCode" class="form-group">
																<div class="validate-input">
																<label class="fancy-checkbox">
																<input type="checkbox" id="ocbZoneAutoGenCode" name="ocbZoneAutoGenCode" checked="true" value="1">
																<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
															</label>
														</div>
													</div>
														<div id="odvZneCodeForm" class="form-group">
															<input type="hidden" id="ohdCheckDuplicateZneCode" name="ohdCheckDuplicateZneCode" value="1"> 
																<div class="validate-input">
																	<input 
																	type="text" 
																	class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote\" 
																	maxlength="5" 
																	id="oetZneCode" 
																	name="oetZneCode"
																	value="<?php echo $tZneCode ?>"
																	data-is-created="<?php echo $tZneCode ?>"
																	placeholder="<?= language('address/zone/zone','tZNEZCode')?>"
																	data-validate-required = "<?= language('address/zone/zone','tZneValiBranchCode')?>"
																	data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValidCodeDup')?>"
																	>
																</div>
															</div>
														</div>

												</div>
											</div>
										</div>
									</div>
									<div class="row">
										<div class="col-xs-12 col-md-5 col-lg-5">
											<div class="form-group">
												<div class="validate-input" data-validate="Please Enter">
													<label class="xCNLabelFrm"><span class="text-danger">*</span><?php echo  language('address/zone/zone','tZNEName')?></label>
													<input class="xCNHide" type="text" id="oetZneNameOldTab1" name="oetZneNameOldTab1" value="<?php echo @$tZneName?>"
													data-validate-required = "<?php echo language('address/zone/zone','tZneValiZoneName')?>" 
													 >
													<input class="form-control" maxlength="100" type="text" id="oetZneNameTab1" name="oetZneNameTab1" maxlength="100" value="<?php echo @$tZneName?>"
													data-validate-required = "<?php echo language('address/zone/zone','tZneValiZoneName')?>"
													placeholder="<?php echo  language('address/zone/zone','tZNEName')?>" 
													autocomplete="off"
													 >
													<span class="focus-"></span>
												</div>
											</div>
										</div>
									</div>
								<div class="row">
									<div class="col-xs-12 col-md-5 col-lg-5">
										<div class="form-group">
											<label class="xCNLabelFrm"><?php echo language('address/zone/zone','tZneRemark')?></label>
											<textarea class="form-control xCNInputWithoutSpc" maxlength="100" rows="4" id="oetZneRemark" name="oetZneRemark"><?php echo @$tZneRmk; ?></textarea>
										</div>
									</div>
								</div>
							</div>
						</div>	
					</div>
				</form>
			</div>


			<!-- Tab Content Detail  2 -->
					<div id="odvZneContentSet" class="tab-pane fade">
						<div class="panel-heading">
						<div class="row">
							<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddReferzone">
								<input type="hidden" id="oetZneChain" name="oetZneChain" value="<?php echo $tZneChain;?>">
									<div class="col-xs-12 col-lg-2 col-md-12">
										<div class="form-group">
											<div class="validate-input">
												<label class="xCNLabelFrm"><?php echo  language('address/zone/zone','tZNECode')?><?php echo  language('address/zone/zone','tZNETitle')?></label>
												<input type="text" class="xCNInputWithoutSpc" maxlength="100" id="oetZneCodeTab2" name="oetZneCodeTab2" value="<?php echo @$tZneCode;?>">
											</div>
										</div>
									</div>

									<div class="col-xs-12 col-lg-2 col-md-12">
									<!-- <input type="hidden" id="oetZneCodeTab2" name="oetZneCodeTab2"  value="<?php echo @$tZneCode;?>"> -->
									<input type="text" class="xCNHide"  id="oetZneChainOldTab2" name="oetZneChainOldTab2" value="<?php echo @$tZneChain?>" >
										<div class="form-group">
											<div class="validate-input">
												<label class="xCNLabelFrm"><?php echo language("address/zone/zone","tZNEName");?></label>
												<input type="hidden" id="oetZneNameOld" name="oetZneNameOld"  value="<?php echo @$tZneName;?>">
												<input type="text" class="xCNInputWithoutSpc" maxlength="100" id="oetZneName" name="oetZneName" value="<?php echo @$tZneName;?>">
											</div>
										</div>
									</div>
								
									<div class="col-xs-12 col-lg-2 col-md-2">
										<div class="form-group">
										<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tTypeDetailRefer');?></label>
											<select class="selectpicker form-control" id="ocmTypeRefer" name="ocmTypeRefer" maxlength="1"
											data-validate-required = "<?= language('address/zone/zone','tZneValiTypeRefer')?>"
                                   		    data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiTypeRefer')?>"
											>
												<!-- <option value=""><?php echo language('common/main/main','tCMNBlank-NA');?></option> -->
												<option value="TCNMBranch"><?php echo language('address/zone/zone','tZneSltBranch');?></option>
												<option value="TCNMUser"><?php echo language('address/zone/zone','tZneSleUSer');?></option>
												<option value="TCNMSpn"><?php echo language('address/zone/zone','tZneSltSaleman');?></option>
												<option value="TCNMShop"><?php echo language('address/zone/zone','tZneSltShop');?></option>
												<option value="TCNMPos"><?php echo language('address/zone/zone','tZneSltPos');?></option>
											</select>
										</div>
									</div>
										
									<!-- ฺBrowse Branch (สาขา) -->
									<div class="col-xs-12 col-lg-2 col-md-2" id="odvZneBranch" >
										<div class="form-group">
											<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltBranch');?></label>
											<div class="input-group">
												<input type="text" class="form-control xCNHide" id="oetZneBchCode" name="oetZneBchCode" value="<?php echo @$tZneBranchCode;?>">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneBchName" name="oetZneBchName" placeholder="<?php echo language('address/zone/zone','tZneSltBranch');?>" value="<?php echo @$tZneBranchName;?>"
												data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                                   				data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
												" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseBranch" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>

									<!-- Browse User (ผู้ใช้)-->
									<div class="col-xs-12 col-lg-2 col-md-2" id="odvZneUSer">
										<div class="form-group">
											<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSleUSer');?></label>
											<div class="input-group">
												<input type="text" class="form-control xCNHide" id="oetZneUSerCode" name="oetZneUSerCode" value="<?php echo @$tZneUSerCode;?>">
												<input type="text" class="from-control xCNInputWithoutSpcNotThai" id="oetZneUSerName"  name="oetZneUSerName"  placeholder="<?php echo language('address/zone/zone','tZneSleUSer');?>" value="<?php echo @$tZneUserName;?>"
												data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                                   				data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
												" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseUSer" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>

									<!-- Browse SaleMan พนักงานขาย -->
									<div class="col-xs-12 col-lg-2 col-md-2" id="odvZneSaleMan">
										<div class="form-group">
										<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltSaleman');?></label>
											<div class="input-group">
												<input type="text" class="form-control xCNHide" id="oetZneSpnCode" name="oetZneSpnCode" maxlength="5" value="<?php echo @$tZneSpnCode?>">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneSpnName" name="oetZneSpnName" maxlength="100" placeholder="<?php echo language('address/zone/zone','tZneSltSaleman');?>" value="<?php echo @$tZneSpnName?>"
												data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                                   				data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
												" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseSaleMan" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>

									<!-- Browse Shop (ร้านค้า) -->
									<div class="col-xs-12 col-lg-2 col-md-2" id="odvZneShop">
										<div class="form-group" >
										<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltShop');?></label>
											<div class="input-group">
												<input type="text" class="form-control xCNHide" id="oetZneShopCode" name="oetZneShopCode" value="<?php echo @$tZneShpCode?>">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZneShopName" name="oetZneShopName"  placeholder="<?php echo language('address/zone/zone','tZneSltShop');?>" value="<?php echo @$tZneShpName?>"
												data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                                   				data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
												" readonly>
												<span class="input-group-btn">
													<button id="obtBrowseShop" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>
										
									<!-- Browse Pos (เครื่องจุดขาย) -->
									<div class="col-xs-12 col-lg-2 col-md-2" id="odvZnePos">	
										<div class="form-group" >
										<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('address/zone/zone','tZneSltPos');?></label>
											<div class="input-group" >
												<input type="text" class="form-control xCNHide" id="oetZnePosCode" name="oetZnePosCode" maxlength="5" value="<?php echo @$tZnePosCode?>">
												<input type="text" class="form-control xCNInputWithoutSpcNotThai" id="oetZnePosName" name="oetZnePosName"  placeholder="<?php echo language('address/zone/zone','tZneSltPos');?>" value="<?php echo @$tZneComName?>"
												data-validate-required = "<?= language('address/zone/zone','tZneValiReference')?>"
                                   				data-validate-dublicateCode = "<?= language('address/zone/zone','tZneValiReference')?>
												" readonly>
												<span class="input-group-btn">
													<button id="obtBrowsePOS" type="button" class="btn xCNBtnBrowseAddOn">
														<img src="<?php echo  base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
													</button>
												</span>
											</div>
										</div>
									</div>

									<div class="col-xs-12 col-lg-2 col-md-2">
										<div class="form-group">
											<div class="validate-input">
												<label class="xCNLabelFrm"><?php echo language("address/zone/zone","tZneKeyRefer");?></label>
												<input type="text" class="xCNInputWithoutSpc" maxlength="100" id="oetKeyReferName" name="oetKeyReferName" value="<?php echo @$tKeyReferName;?>">
											</div>
										</div>
									</div>
									<br>
									<div class="col-xs-12 col-lg-2 col-md-2">
										<div class="form-group">
											<div id="odvBtnZneRefer">
												<!-- <button class="btn xCNBTNPrimery" type="button"><?php echo language('address/zone/zone','tZneAdd');?></button>	 -->
												<button  type="submit" id="obtSubmitZneTab2" class="btn xCNBTNPrimery" onclick="JSnAddReferZone()" ><?php echo language('address/zone/zone','tZneAdd');?></button>		
											</div>
										</div>
									</div>
								</form>
							</div>
						</div>
				        <script type="text/javascript">
							  window.onload = JSvZoneObjDataTable();
						</script>
					<div class="panel-body">
						<div id="odvContentZoneObjData"></div>
					</div>
						</tbody>
					</table>
				</div>
			<!-- Tab Content Detail  2 -->

			</div>
		</div>
	</div>
</div>

<!-- div Dropdownbox -->
<div id="dropDownSelect1"></div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>
<?php include "script/jZoneAdd.php"; ?>






	
