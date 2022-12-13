<input id="oetInterfaceExportStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetInterfaceExportCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php
	if($this->session->userdata("tSesUsrLevel") == "HQ"){
		$tDisabled = "";
	}else{
		$nCountBch = $this->session->userdata("nSesUsrBchCount");
		if($nCountBch == 1){
			$tDisabled = "disabled";
		}else{
			$tDisabled = "";
		}
	}

	$tUserBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
	$tUserBchName = $this->session->userdata("tSesUsrBchNameDefault");
?>

<?php
	$dBchStartFrm		= date('Y-m-d');
	$dBchStartTo		= date('Y-m-d');
?>
<div id="odvCpnMaIFXenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('interfaceexport/0/0');?>
					<li id="oliInterfaceExportTitle" class="xCNLinkClick" style="cursor:pointer" ><?php echo language('interface/interfaceexport/interfaceexport','tITFXTitle') ?></li>
				</ol>
			</div>

			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div id="odvBtnCmpEditInfo">
			<button id="obtInterfaceExportConfirm" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('interface/interfaceexport/interfaceexport','tITFXTConfirm')  ?></button>
				</div>

			</div>
		</div>
	</div>
</div>
<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmInterfaceExport">
<div class="main-content">
	<div class="panel panel-headline">
	<input type="hidden" name="tUserCode" id="tUserCode" value="<?=$this->session->userdata('tSesUserCode')?>">
	<div class="row">
    <div class="col-md-12">

		<div class="panel-body">

			<div class="col-md-12 xCNHide">
				<input type="checkbox" name="ocbReqpairExport" id="ocbReqpairExport"  value="1" > เฉพาะรายการส่งไม่สำเร็จ
			</div>
				<div class="table-responsive" style="padding:20px">
						<table id="otbCtyDataList" class="table table-striped"> <!-- เปลี่ยน -->
							<thead>
								<tr>
									<th width="4%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXID'); ?></th>
									<th width="5%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXSelect'); ?></th>
									<th width="20%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXList'); ?></th>
									<th nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXCondition'); ?></th>
									<!-- <th width="15%" nowrap class="text-center xCNTextBold"><?php echo language('interface/interfaceexport/interfaceexport','tITFXTStatus'); ?></th> -->
								</tr>
							</thead>
							<tbody>
								<tr>
									<td align="center">1</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo @$aDataMasterImport[0]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport0" value="<?=$aDataMasterImport[0]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo @$aDataMasterImport[0]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<!-- สาขา -->
											<div class="row">
												<div class="col-md-2"><?php echo language('company/branch/branch', 'tBCHTitle'); ?></div>
												<div class="col-md-10">

													<div id="odvCondition1" class="row">
														<div class="col-lg-5">

															<div class="form-group">
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXBchCodeFin" name="oetIFXBchCodeFin" maxlength="5" value="<?php echo $tUserBchCode; ?>">
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXBchNameFin" name="oetIFXBchNameFin" value="<?php echo $tUserBchName; ?>" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowseBchFin" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess" <?php echo $tDisabled; ?> >
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>

														</div>
													</div>

												</div>
											</div>
											<!-- สาขา -->
											<!-- คลัง -->
											<div class="row">
												<div class="col-md-2"><?php echo language('company/shop/shop', 'tSHPWah'); ?></div>
												<div class="col-md-10">
													<div id="odvCondition10" class="row">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXWahCodeFin" name="oetIFXWahCodeFin" maxlength="5" >
																	<input class="form-control xWPointerEventNone" data-validate-required="กรุณากรอกตัวแทนขาย" type="text" id="oetIFXWahNameFin" name="oetIFXWahNameFin" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowseWahFin" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess">
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- คลัง -->
											<!-- เครื่องจุดขาย -->
											<div class="row">
												<div class="col-md-2"><?php echo language('company/shop/shop', 'tNameTabPosshop'); ?></div>
												<div class="col-md-10">
													<div id="odvCondition2" class="row">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXPosCodeFin" name="oetIFXPosCodeFin" maxlength="5" >
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXPosNameFin" name="oetIFXPosNameFin" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowsePosFin" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess">
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
											<!-- เครื่องจุดขาย -->

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterDate');?></div>
												<div class="col-md-10">
													<div id="odvCondition3" class="row">

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" value="<?php echo $dBchStartFrm; ?>"class="form-control xWITFXDatePickerFinance xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" autocomplete="off" id="oetITFXDateFromFinanceFin" name="oetITFXDateFromFinanceFin" maxlength="10">
																	<span class="input-group-btn">
																		<button id="obtITFXDateFromFinanceFin" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>

														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text"value="<?php echo $dBchStartTo; ?>" class="form-control xWITFXDatePickerFinance xCNDatePicker xCNDatePickerEnd xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess" autocomplete="off" id="oetITFXDateToFinanceFin" name="oetITFXDateToFinanceFin" maxlength="10">
																	<span class="input-group-btn">
																		<button id="obtITFXDateToFinanceFin" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>

													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
												<div class="col-md-10">
													<div id="odvCondition6" class="row">
														<div class="col-lg-5">
															<div class="form-group">
																<select class="selectpicker form-control" id="ocmITFXXshType" name="ocmITFXXshType">
																	<option value='1'><?php echo language('interface/interfacehistory','tITFXFilterTypeSal'); ?></option>
																	<option value='9'><?php echo language('interface/interfacehistory','tITFXFilterTypeRe'); ?></option>
																</select>
															</div>
														</div>

														<div class="col-lg-1">

														</div>

														<div class="col-lg-5">

														</div>

													</div>
												</div>
											</div>
											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterDocSal');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXXshDocNoFromFin" name="oetITFXXshDocNoFromFin" readonly>
																	<!-- <input type="text" class="form-control xWPointerEventNone xWRptAllInput" id="oetRptBchNameFrom" name="oetRptBchNameFrom" readonly=""> -->
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromSaleFin" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXXshDocNoToFin" name="oetITFXXshDocNoToFin" readonly>
																	<!-- <input type="text" class="form-control xWPointerEventNone xWRptAllInput" id="oetRptBchNameTo" name="oetRptBchNameTo" readonly=""> -->
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToSaleFin" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>
								<tr>
									<td align="center">2</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[1]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[1]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[1]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">

											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => '00018'
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => '00018'
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => '00018'
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> '00018'
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
												<div class="col-md-10">
													<div id="odvCondition6" class="row">
														<div class="col-lg-5">
															<div class="form-group">
																<select class="selectpicker form-control" id="ocmITFXTaxType00018" name="ocmITFXTaxType00018">
																	<option value='4'><?php echo language('interface/interfaceexport/interfaceexport','tITFXFilterTypeAbbTax'); ?></option>
																	<option value='5'><?php echo language('interface/interfaceexport/interfaceexport','tITFXFilterTypeCNTax'); ?></option>
																</select>
															</div>
														</div>
													</div>
												</div>
											</div>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTypeAbbTax');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromTax00018" name="oetITFXFromTax00018" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromTax00018" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToTax00018" name="oetITFXToTax00018" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToTax00018" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>
								<tr>
									<td align="center">3</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo @$aDataMasterImport[2]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport2" value="<?=$aDataMasterImport[2]['FTApiCode']?>" idpgb="xWIFXExpBonTextDisplay" data-type="ExpBon">
									</td>
									<td align="left"><?php echo @$aDataMasterImport[2]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">

											<!-- สาขา -->
											<div class="row">
												<div class="col-md-2"><?php echo language('company/branch/branch', 'tBCHTitle'); ?></div>
												<div class="col-md-10">

													<div id="odvCondition4" class="row">
														<div class="col-lg-5">

															<div class="form-group">
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXBchCodeSale" name="oetIFXBchCodeSale" maxlength="5" value="<?php echo $tUserBchCode; ?>">
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXBchNameSale" name="oetIFXBchNameSale" value="<?php echo $tUserBchName; ?>" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowseBchSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess" <?php echo $tDisabled; ?> >
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>

														</div>
													</div>

												</div>
											</div>
											<!-- สาขา -->
											<!-- เครื่องจุดขาย -->
											<div class="row">
												<div class="col-md-2"><?php echo language('company/shop/shop', 'tNameTabPosshop'); ?></div>
												<div class="col-md-10">

													<div id="odvCondition5" class="row">
														<div class="col-lg-5">

															<div class="form-group">
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXPosCodeSale" name="oetIFXPosCodeSale" maxlength="5" >
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXPosNameSale" name="oetIFXPosNameSale" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowsePosSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess">
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>

														</div>
													</div>

												</div>
											</div>
											<!-- เครื่องจุดขาย -->
											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterDate');?></div>
												<div class="col-md-10">

													<div id="odvCondition6" class="row">

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input
																		type="text"
																		class="form-control xWITFXDatePickerSale xCNDatePicker xCNDatePickerStart xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess"
																		autocomplete="off"
																		id="oetITFXDateFromSale"
																		name="oetITFXDateFromSale"
																		maxlength="10"
																		value=<?=$dBchStartFrm;?>>
																	<span class="input-group-btn">
																		<button id="obtITFXDateFromSale" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>

														<div class="col-lg-1" hidden>
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>

														<div class="col-lg-5" hidden>
															<div class="form-group">
																<div class="input-group">
																	<input type="text"
																		class="form-control xWITFXDatePickerSale xCNDatePicker xCNDatePickerEnd xCNInputMaskDate xWRptAllInput xWIFXDisabledOnProcess"
																		autocomplete="off" id="oetITFXDateToSale"
																		name="oetITFXDateToSale"
																		maxlength="10"
																		value="<?=$dBchStartTo;?>">
																	<span class="input-group-btn">
																		<button id="obtITFXDateToSale" type="button" class="btn xCNBtnDateTime xWIFXDisabledOnProcess"><img class="xCNIconCalendar"></button>
																	</span>
																</div>
															</div>
														</div>

													</div>

												</div>
											</div>
											<!-- รหัสรอบการขาย -->
											<div class="row">
												<div class="col-md-2"><?php echo language('sale/salemonitor/salemonitor', 'tSMTShiftCodes'); ?></div>
												<div class="col-md-10">

													<div id="odvCondition5" class="row">
														<div class="col-lg-5">

															<div class="form-group">
																<div class="input-group">
																	<input class="form-control xCNHide" id="oetIFXShiftCodeSale" name="oetIFXShiftCodeSale" maxlength="5" >
																	<input class="form-control xWPointerEventNone" type="text" id="oetIFXShiftNameSale" name="oetIFXShiftNameSale" readonly>
																	<span class="input-group-btn">
																		<button id="obtIFXBrowseShiftSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess">
																			<img src="<?php echo  base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
																		</button>
																	</span>
																</div>
															</div>

														</div>
													</div>

												</div>
											</div>
											<!-- endรหัสรอบการขาย -->
											<div class="row" hidden>
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterDocSal');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition1" class="row xCNFilterRangeMode">

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXXshDocNoFrom" name="oetITFXXshDocNoFrom" readonly>
																	<!-- <input type="text" class="form-control xWPointerEventNone xWRptAllInput" id="oetRptBchNameFrom" name="oetRptBchNameFrom" readonly=""> -->
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>

														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>

														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXXshDocNoTo" name="oetITFXXshDocNoTo" readonly>
																	<!-- <input type="text" class="form-control xWPointerEventNone xWRptAllInput" id="oetRptBchNameTo" name="oetRptBchNameTo" readonly=""> -->
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToSale" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
									</td>
								</tr>

								<tr>
									<td align="center">4</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[8]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[8]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[8]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[8]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[8]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[8]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>
											<!-- รอบการส่ง Default 1 -->
											<div class="row xCNHide">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
												<div class="col-md-10">
													<div id="odvCondition6" class="row">
														<div class="col-lg-5">
															<div class="form-group">
																<input type="number" class="form-control" id="oetDeliveryRound00037" name="oetDeliveryRound00037" value="1">
															</div>
														</div>
													</div>
												</div>
											</div>

											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[8]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<!-- จากเอกสาร ถึงเอกสาร -->
											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00037" name="oetITFXFromDocCode00037" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00037" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00037" name="oetITFXToDocCode00037" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00037" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">5</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[9]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[9]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[9]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[9]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[9]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[9]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row  xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00038" name="oetDeliveryRound00038" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[9]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00038" name="oetITFXFromDocCode00038" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00038" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00038" name="oetITFXToDocCode00038" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00038" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">6</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[7]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[7]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[7]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[7]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[7]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[7]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00036" name="oetDeliveryRound00036" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[7]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00036" name="oetITFXFromDocCode00036" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00036" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00036" name="oetITFXToDocCode00036" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00036" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">7</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[10]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[10]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[10]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[10]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[10]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[10]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00039" name="oetDeliveryRound00039" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[10]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00039" name="oetITFXFromDocCode00039" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00039" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00039" name="oetITFXToDocCode00039" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00039" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">8</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[4]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[4]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[4]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[4]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[4]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[4]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00033" name="oetDeliveryRound00033" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[4]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00033" name="oetITFXFromDocCode00033" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00033" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00033" name="oetITFXToDocCode00033" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00033" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">9</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[6]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[6]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[6]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[6]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[6]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[6]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00035" name="oetDeliveryRound00035" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[6]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00035" name="oetITFXFromDocCode00035" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00035" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00035" name="oetITFXToDocCode00035" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00035" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">10</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[5]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[5]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[5]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[5]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[5]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[5]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00034" name="oetDeliveryRound00034" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[5]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00034" name="oetITFXFromDocCode00034" readonly>
																	<input type="hidden" class="form-control xWRptAllInput" id="ohdITFXFromDocName00034" name="ohdITFXFromDocName00034" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00034" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00034" name="oetITFXToDocCode00034" readonly>
																	<input type="hidden" class="form-control xWRptAllInput" id="ohdITFXToDocName00034" name="ohdITFXToDocName00034" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00034" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">11</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[11]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[11]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[11]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[11]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[11]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[11]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00040" name="oetDeliveryRound00040" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[11]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00040" name="oetITFXFromDocCode00040" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00040" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00040" name="oetITFXToDocCode00040" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00040" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">12</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[12]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[12]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[12]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[12]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tApiPK'		 => $aDataMasterImport[12]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tApiPK'		 => $aDataMasterImport[12]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

												<!-- รอบการส่ง Default 1 -->
												<div class="row xCNHide">
													<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterType');?></div>
													<div class="col-md-10">
														<div id="odvCondition6" class="row">
															<div class="col-lg-5">
																<div class="form-group">
																	<input type="number" class="form-control" id="oetDeliveryRound00041" name="oetDeliveryRound00041" value="1">
																</div>
															</div>
														</div>
													</div>
												</div>
	
											<?php
												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[12]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00041" name="oetITFXFromDocCode00041" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00041" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00041" name="oetITFXToDocCode00041" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00041" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">13</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[13]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[13]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[13]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[13]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' => 'Warehouse',
													'tWahType'		 => '6', // คลัง VD
													'tApiPK'		 => $aDataMasterImport[13]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													'tPosType'		 => '4', // ตู้ขายสินค้า
													'tApiPK'		 => $aDataMasterImport[13]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' 	=> 'Date',
													'tConditionFromTo' 	=> true,
													'tApiPK'		 	=> $aDataMasterImport[13]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData); 
											?>

											<div class="row">
												<div class="col-md-2"><?=language('interface/interfaceexport/interfaceexport','tITFXSalDocNo');?></div>
												<div class="col-md-10">
													<div class="xCNFilterBox"><div id="odvCondition" class="row xCNFilterRangeMode">
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXFromDocCode00042" name="oetITFXFromDocCode00042" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseFromDocCode00042" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
														<div class="col-lg-1">
															<p class="xCNTextTo"><?=language('interface/interfaceexport/interfaceexport','tITFXFilterTo');?></p>
														</div>
														<div class="col-lg-5">
															<div class="form-group">
																<div class="input-group">
																	<input type="text" class="form-control xWRptAllInput" id="oetITFXToDocCode00042" name="oetITFXToDocCode00042" readonly>
																	<span class="input-group-btn">
																		<button id="obtITFXBrowseToDocCode00042" type="button" class="btn xCNBtnBrowseAddOn xWIFXDisabledOnProcess"><img class="xCNIconFind"></button>
																	</span>
																</div>
															</div>
														</div>
													</div>
												</div>
											</div>

										</div>
										</div>
									</td>
								</tr>

								<tr>
									<td align="center">14</td>
									<td align="center">
										<input type="hidden"  name="ocmIFXExportName[]"  value="<?php echo $aDataMasterImport[14]['FTApiCode'] ?>" >
										<input type="checkbox" class="progress-bar-chekbox xWIFXDisabledOnProcess" name="ocmIFXExport[]" id="ocmIFXExport1" value="<?=$aDataMasterImport[14]['FTApiCode']?>" idpgb="xWIFXExpFinTextDisplay" data-type="ExpFin">
									</td>
									<td align="left"><?php echo $aDataMasterImport[14]['FTApiName'] ?></td>
									<td>
										<div class="col-md-12">
											<?php 
												$aPackData = array(
													'tConditionType' => 'Branch',
													'tApiPK'		 => $aDataMasterImport[14]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												// $aPackData = array(
												// 	'tConditionType' => 'Warehouse',
												// 	// 'tWahType'		 => '6', // คลัง VD
												// 	'tApiPK'		 => $aDataMasterImport[14]['FTApiCode']
												// );
												// echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'Pos',
													// 'tPosType'		 => '4', // ตู้ขายสินค้า
													'tApiPK'		 => $aDataMasterImport[14]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												// $aPackData = array(
												// 	'tConditionType' 	=> 'Date',
												// 	'tConditionFromTo' 	=> false,
												// 	'tApiPK'		 	=> $aDataMasterImport[14]['FTApiCode']
												// );
												// echo FCNtHShwCondition($aPackData); 

												$aPackData = array(
													'tConditionType' => 'DocType',
													'tApiPK'		 => $aDataMasterImport[14]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);

												$aPackData = array(
													'tConditionType' 	=> 'Browse',
													'tConditionFromTo' 	=> false,
													'tBrowseTable'		=> 'TPSTSalHD',
													'tBrowseType'		=> '1',
													'tBrowseCondition'	=> '',
													'tApiPK'		 	=> $aDataMasterImport[14]['FTApiCode']
												);
												echo FCNtHShwCondition($aPackData);
											?>

										</div>
										</div>
									</td>
								</tr>

							</tbody>
						</table>

						<input hidden type="checkbox" name="ocmIFXChkAll" class="xWIFXDisabledOnProcess" id="ocmIFXChkAll" value="1" checked > <?php //echo language('interface/interfaceexport/interfaceexport','tITFXSelectAll'); ?>
					</div>
				</div>
			</div>
		</div>

	</div>
</div>
</form>


<!--Modal Success-->
<div class="modal fade" id="odvInterfaceEmportSuccess">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?=language('interface/interfaceexport/interfaceexport','tStatusProcess'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?=language('interface/interfaceexport/interfaceexport','tContentProcess'); ?></p>
            </div>
            <div class="modal-footer">
                <button data-dismiss="modal" id="obtIFXModalMsgConfirm" type="button" class="btn xCNBTNPrimery">
                    <?=language('common/main/main', 'tModalConfirm'); ?>
                </button>
				<button type="button" id="obtIFXModalMsgCancel" class="btn xCNBTNDefult" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel'); ?>
				</button>
            </div>
        </div>
    </div>
</div>



<script src="<?php echo base_url('application/modules/interface/assets/src/interfaceexport/jInterfaceExport.js')?>"></script>
<script>
	$('#ocbReqpairExport').click(function(){
		// Last Update : Napat(Jame) 17/08/2020 แก้ปัญหาติ๊ก checkbox แล้วกดปุ่มเมนูซ้ายมือไม่ได้
		if($(this).prop('checked') == true){
			$('.xWIFXDisabledOnProcess').prop('disabled',true);
			// $('input').prop('disabled',true);
			// $('button').prop('disabled',true);
		}else{
			$('.xWIFXDisabledOnProcess').prop('disabled',false);
			// $('input').prop('disabled',false);
			// $('button').prop('disabled',false);
		}
		$('#ocbReqpairExport').prop('disabled',false);
		$('#obtInterfaceExportConfirm').prop('disabled',false);
		$('#obtIFXModalMsgConfirm').prop('disabled',false);
	});

	$( document ).ready(function() {
		$('.selectpicker').selectpicker();
		$('.xCNDatePicker').datepicker({
			format: 'yyyy-mm-dd',
			autoclose: true,
			todayHighlight: true,
			// startDate: new Date()
		}).on('changeDate',function(ev){
			JSxIFXAfterChangeDateClearBrowse();
		});
	});


	$('#oetITFXDateFromSale').on('change',function(){
		if($('#oetITFXDateToSale').val() == ""){
			$('#oetITFXDateToSale').val($('#oetITFXDateFromSale').val());
		}
	});

	$('#oetITFXDateToSale').on('change',function(){
		if($('#oetITFXDateFromSale').val() == ""){
			$('#oetITFXDateFromSale').val($('#oetITFXDateToSale').val());
		}
	});

	$('#oetITFXDateFromFinanceFin').on('change',function(){
		if($('#oetITFXDateToFinanceFin').val() == ""){
			$('#oetITFXDateToFinanceFin').val($('#oetITFXDateFromFinanceFin').val());
		}
	});

	$('#oetITFXDateToFinanceFin').on('change',function(){
		if($('#oetITFXDateFromFinanceFin').val() == ""){
			$('#oetITFXDateFromFinanceFin').val($('#oetITFXDateToFinanceFin').val());
		}
	});



	// Date For SaleHD
	$('#obtITFXDateFromSale').off('click').on('click',function(){
		$('#oetITFXDateFromSale').datepicker('show');
	});

	$('#obtITFXDateToSale').off('click').on('click',function(){
		$('#oetITFXDateToSale').datepicker('show');
	});



	// Date For Finance
	$('#obtITFXDateFromFinanceFin').off('click').on('click',function(){
		$('#oetITFXDateFromFinanceFin').datepicker('show');
	});

	$('#obtITFXDateToFinanceFin').off('click').on('click',function(){
		$('#oetITFXDateToFinanceFin').datepicker('show');
	});

	// $('.xWITFXDatePickerFinance').datepicker({
	// 	format					: 'dd/mm/yyyy',
	// 	disableTouchKeyboard 	: true,
	// 	enableOnReadonly		: false,
	// 	autoclose				: true,
	// });

	function JSxCreateDataBillToTemp(pnType){
		let dDateFrom		 = $('#oetITFXDateFromSale').val();
		let dDateTo			 = $('#oetITFXDateToSale').val();
		let tIFXBchCodeSale  = $('#oetIFXBchCodeSale').val();

		$.ajax({
				type    : "POST",
				url     : "interfaceexportFilterBill",
				data    : {
					oetITFXDateFromSale:dDateFrom,
					oetITFXDateToSale:dDateTo,
					oetIFXBchCodeSale:tIFXBchCodeSale,
				},
				cache   : false,
				Timeout : 0,
				success: function(tResult){
					if(pnType==1){
						window.oITFXBrowseFromSale = undefined;
						oITFXBrowseFromSale        = oITFXBrowseSaleOption({
							'tReturnInputCode'  : 'oetITFXXshDocNoFrom',
							'tReturnInputName'  : '',
							'tNextFuncName'     : 'JSxIFXAfterBrowseSaleFrom',
							'aArgReturn'        : ['FTXshDocNo']
						});
						JCNxBrowseData('oITFXBrowseFromSale');
					}else{
						window.oITFXBrowseToSale = undefined;
						oITFXBrowseToSale        = oITFXBrowseSaleOption({
							'tReturnInputCode'  : 'oetITFXXshDocNoTo',
							'tReturnInputName'  : '',
							'tNextFuncName'     : 'JSxIFXAfterBrowseSaleTo',
							'aArgReturn'        : ['FTXshDocNo']
						});
						JCNxBrowseData('oITFXBrowseToSale');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JCNxResponseError(jqXHR, textStatus, errorThrown);
				}
			});
	}

	function JSxCreateDataBillToTempFin(pnType){
		let dDateFrom		 = $('#oetITFXDateFromSale').val();
		let dDateTo			 = $('#oetITFXDateToSale').val();
		let tIFXBchCodeSale  = $('#oetIFXBchCodeSale').val();

		$.ajax({
				type    : "POST",
				url     : "interfaceexportFilterBill",
				data    : {
					oetITFXDateFromSale:dDateFrom,
					oetITFXDateToSale:dDateTo,
					oetIFXBchCodeSale:tIFXBchCodeSale,
				},
				cache   : false,
				Timeout : 0,
				success: function(tResult){
					if(pnType==1){
						window.oITFXBrowseFromSale = undefined;
						oITFXBrowseFromSale        = oITFXBrowseSaleOption({
							'tReturnInputCode'  : 'oetITFXXshDocNoFromFin',
							'tReturnInputName'  : '',
							'tNextFuncName'     : 'JSxIFXAfterBrowseSaleFrom',
							'aArgReturn'        : ['FTXshDocNo']
						});
						JCNxBrowseData('oITFXBrowseFromSale');
					}else{
						window.oITFXBrowseToSale = undefined;
						oITFXBrowseToSale        = oITFXBrowseSaleOption({
							'tReturnInputCode'  : 'oetITFXXshDocNoToFin',
							'tReturnInputName'  : '',
							'tNextFuncName'     : 'JSxIFXAfterBrowseSaleTo',
							'aArgReturn'        : ['FTXshDocNo']
						});
						JCNxBrowseData('oITFXBrowseToSale');
					}
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JCNxResponseError(jqXHR, textStatus, errorThrown);
				}
			});
	}

	$('#obtITFXBrowseFromSale').off('click').on('click',function(){
		JSxCreateDataBillToTemp(1);
	});
	// $('#obtITFXBrowseFromSaleFin').off('click').on('click',function(){
	// 	JSxCreateDataBillToTempFin(1);
	// });

	$('#obtITFXBrowseToSale').off('click').on('click',function(){
		JSxCreateDataBillToTemp(2);
	});

	// $('#obtITFXBrowseToSaleFin').off('click').on('click',function(){
	// 	JSxCreateDataBillToTempFin(2);
	// });



	// var oITFXBrowseSaleOption = function(poReturnInput){
    // let tNextFuncName    = poReturnInput.tNextFuncName;
    // let aArgReturn       = poReturnInput.aArgReturn;
    // let tInputReturnCode = poReturnInput.tReturnInputCode;
	// 	let tInputReturnName = poReturnInput.tReturnInputName;
	// 	let dDateFrom		 = $('#oetITFXDateFromSale').val();
	// 	let dDateTo			 = $('#oetITFXDateToSale').val();
	// 	let tIFXBchCodeSale  = $('#oetIFXBchCodeSale').val();
	// 	let tWhere		     = "";
	// 	let tSessionUserCode  = '<?=$this->session->userdata('tSesUserCode')?>'


	// 		tWhere += " AND TCNTBrsBillTmp.FTUsrCode = '"+tSessionUserCode+"' ";




    //     let oOptionReturn    = {
    //         Title: ['interface/interfaceexport/interfaceexport','tITFXDataSal'],
    //         Table:{Master:'TCNTBrsBillTmp',PK:'FTXshDocNo'},
	// 		Where: {
    //                 Condition: [tWhere]
	// 		},
	// 		// Filter:{
	// 		// 	Selector    : 'oetIFXBchCodeSale',
	// 		// 	Table       : 'TCNTBrsBillTmp',
	// 		// 	Key         : 'FTBchCode'
	// 		// },
    //         GrideView:{
    //             ColumnPathLang	: 'interface/interfaceexport/interfaceexport',
    //             ColumnKeyLang	: ['tITFXSalDocNo','tITFXSalDate'],
    //             ColumnsSize     : ['30%','50%','20%'],
    //             WidthModal      : 50,
    //             DataColumns		: ['TCNTBrsBillTmp.FTXshDocNo','TCNTBrsBillTmp.FDXshDocDate'],
    //             DataColumnsFormat : ['','',''],
    //             Perpage			: 10,
    //             OrderBy			: ['FTXshDocNo ASC'],
    //         },
    //         CallBack:{
    //             ReturnType	: 'S',
    //             Value		: [tInputReturnCode,"TCNTBrsBillTmp.FTXshDocNo"],
    //             Text		: [tInputReturnName,"TCNTBrsBillTmp.FTXshDocNo"]
	// 		},
    //         NextFunc : {
    //             FuncName    : tNextFuncName,
    //             ArgReturn   : aArgReturn
    //         }
    //         // RouteAddNew: 'branch',
    //         // BrowseLev: 1
    //     };
    //     return oOptionReturn;
	// };

	$('#ocmIFXChkAll').off('click').on('click',function(){
		if($(this).prop('checked') == true){
			$('.progress-bar-chekbox').prop('checked',true);
		}else{
			$('.progress-bar-chekbox').prop('checked',false);
		}
	});

	$('#obtInterfaceExportConfirm').off('click').on('click',function(){

		$('#ofmInterfaceExport').validate({
			rules: {
				oetITFXDateFromFinanceFin : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport0').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateToFinanceFin : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport0').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateFrom00018 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateTo00018 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateFromSale : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport2').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},

				oetITFXDateFrom00037 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateTo00037 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},

				oetITFXDateFrom00038 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateTo00038 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},

				oetITFXDateFrom00036 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
				oetITFXDateTo00036 : {
					"required" :{
						depends: function(oElement) {
							if( $('#ocmIFXExport1').is(':checked') ){
								return true;
							}else{
								return false;
							}
						}
					}
				},
			},
			messages: {
				// oetSptCode : {
				// 	"required"      : $('#oetSptCode').attr('data-validate-required'),
				// 	"dublicateCode" : $('#oetSptCode').attr('data-validate-dublicateCode')
				// },
				// oetStyName : {
				// 	"required"      : $('#oetStyName').attr('data-validate-required'),
				// },
			},
			errorElement: "em",
			errorPlacement: function (error, element ) {
				error.addClass( "help-block" );
				if ( element.prop( "type" ) === "checkbox" ) {
					error.appendTo( element.parent( "label" ) );
				} else {
					var tCheck = $(element.closest('.form-group')).find('.help-block').length;
					if(tCheck == 0){
						error.appendTo(element.closest('.form-group')).trigger('change');
					}
				}
			},
			highlight: function ( element, errorClass, validClass ) {
				$( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
			},
			unhighlight: function (element, errorClass, validClass) {
				$( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
			},
			submitHandler: function(form){
				let nImpportFile = $('.progress-bar-chekbox:checked').length;
				if(nImpportFile > 0){
					JCNxOpenLoading();
					JSxIFXDefualValueProgress();
					JSxIFXCallRabbitMQ();
				}else{
					FSvCMNSetMsgWarningDialog('Please Select Information For Export');
				}
			}
		});

		$('#ofmInterfaceExport').submit();

		// if ($("#oetITFXDateFromFinanceFin").val()=='') {
		// 	$("#oetITFXDateFromFinanceFin").closest('.form-group').addClass("has-error").removeClass("has-success");
		// }else if ($("#oetITFXDateToFinanceFin").val()=='') {
		// 	$("#oetITFXDateToFinanceFin").closest('.form-group').addClass("has-error").removeClass("has-success");
		// }else if( $('#oetITFXDateFromSale').val() == '' ){
		// 	$("#oetITFXDateFromSale").closest('.form-group').addClass("has-error").removeClass("has-success");
		// }else {
		// 	$("#oetITFXDateFromFinanceFin").closest('.form-group').addClass("has-success").removeClass("has-error");
		// 	$("#oetITFXDateToFinanceFin").closest('.form-group').addClass("has-success").removeClass("has-error");
		// 	let nImpportFile = $('.progress-bar-chekbox:checked').length;
		// 	if(nImpportFile > 0){
		// 		JCNxOpenLoading();
		// 		JSxIFXDefualValueProgress();
		// 		JSxIFXCallRabbitMQ();
		// 	}else{
		// 		FSvCMNSetMsgWarningDialog('Please Select Information For Export');
		// 	}
		// }
	});
	$('#obtIFXBrowseAgn00033').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXAgnCode00033',
			'tReturnInputName'  : 'oetIFXAgnName00033',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00035').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXAgnCode00035',
			'tReturnInputName'  : 'oetIFXAgnName00035',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00034').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXAgnCode00034',
			'tReturnInputName'  : 'oetIFXAgnName00034',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00036').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXTwiAgnCode00036',
			'tReturnInputName'  : 'oetIFXTwiAgnName00036',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00037').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXTwoAgnCode00037',
			'tReturnInputName'  : 'oetIFXTwoAgnName00037',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00038').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXTwiAgnCode00038',
			'tReturnInputName'  : 'oetIFXTwiAgnName00038',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00039').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXTFWAgnCode00039',
			'tReturnInputName'  : 'oetIFXTFWAgnName00039',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00040').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXAgnCode00040',
			'tReturnInputName'  : 'oetIFXAgnName00040',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseAgn00041').off('click').on('click',function(){
		window.oITFXBrowseAgn = undefined;
		oITFXBrowseAgn        = oITFXBrowseAgnOption({
			'tReturnInputCode'  : 'oetIFXAgnCode00041',
			'tReturnInputName'  : 'oetIFXAgnName00041',
		});
		JCNxBrowseData('oITFXBrowseAgn');
	});

	$('#obtIFXBrowseBchFin').off('click').on('click',function(){
		window.oITFXBrowseBch = undefined;
		oITFXBrowseBch        = oITFXBrowseBchOption({
			'tReturnInputCode'  : 'oetIFXBchCodeFin',
			'tReturnInputName'  : 'oetIFXBchNameFin',
		});
		JCNxBrowseData('oITFXBrowseBch');
	});

	$('#obtIFXBrowseBchSale').off('click').on('click',function(){
		window.oITFXBrowseBch = undefined;
		oITFXBrowseBch        = oITFXBrowseBchOption({
			'tReturnInputCode'  : 'oetIFXBchCodeSale',
			'tReturnInputName'  : 'oetIFXBchNameSale',
		});
		JCNxBrowseData('oITFXBrowseBch');
	});

	$('#obtIFXBrowseWahFin').off('click').on('click',function(){
		window.oITFXBrowseWahFin = undefined;
		oITFXBrowseWahFin      = oITFXBrowseWahOption({
			'tIFXBchCode'		: $('#oetIFXBchCodeFin').val(),
			'tReturnInputCode'  : 'oetIFXWahCodeFin',
			'tReturnInputName'  : 'oetIFXWahNameFin',
		});
		JCNxBrowseData('oITFXBrowseWahFin');
	});
	$('#obtIFXBrowseShiftSale').off('click').on('click',function(){
		window.oITFXBrowseShiftSale = undefined;
		oITFXBrowseShiftSale      = oITFXBrowseShiftOption({
			'tTFXShiftBchCode'  : $('#oetIFXBchCodeSale').val(),
			'tTFXShiftPosCode'  : $('#oetIFXPosCodeSale').val(),
			'tTFXShiftDocDate'  : $('#oetITFXDateFromSale').val(),
			'tReturnInputCode'  : 'oetIFXShiftCodeSale',
			'tReturnInputName'  : 'oetIFXShiftNameSale',
		});
		JCNxBrowseData('oITFXBrowseShiftSale');
	});

	$('#obtIFXBrowsePosFin').off('click').on('click',function(){
		window.oITFXBrowsePosFin = undefined;
		oITFXBrowsePosFin      = oITFXBrowsePosOption({
			'tIFXBchCode'		: $('#oetIFXBchCodeFin').val(),
			'tReturnInputCode'  : 'oetIFXPosCodeFin',
			'tReturnInputName'  : 'oetIFXPosNameFin',
		});
		JCNxBrowseData('oITFXBrowsePosFin');
	});
	$('#obtIFXBrowsePosSale').off('click').on('click',function(){
		window.oITFXBrowsePosSale = undefined;
		oITFXBrowsePosSale      = oITFXBrowsePosSaleOption({
			'tTFXShiftBchCode'  : $('#oetIFXBchCodeSale').val(),
			'tReturnInputCode'  : 'oetIFXPosCodeSale',
			'tReturnInputName'  : 'oetIFXPosNameSale',
		});
		JCNxBrowseData('oITFXBrowsePosSale');
	});

	// ส่งออก ใบรับโอนสินค้าจาก (TR-Draft)
	// Browse ใบขอโอน
	$('#obtITFXBrowseFromDocCode00036').off('click').on('click',function(){
		window.oITFXBrowseDoc00036 = undefined;
		oITFXBrowseDoc00036 = oITFXBrowseDocReqBchHDOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00036',
			'tReturnInputName'  : 'oetITFXFromDocCode00036',
			'tBchCode00036'		: $('#oetIFXBchCode00036').val(),
			'tDateFrom00036' 	: $('#oetITFXDateFrom00036').val(),
			'tDateTo00036' 		: $('#oetITFXDateTo00036').val()
		});
		JCNxBrowseData('oITFXBrowseDoc00036');
	});

	$('#obtITFXBrowseToDocCode00036').off('click').on('click',function(){
		window.oITFXBrowseDoc00036 = undefined;
		oITFXBrowseDoc00036 = oITFXBrowseDocReqBchHDOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00036',
			'tReturnInputName'  : 'oetITFXToDocCode00036',
			'tBchCode00036'		: $('#oetIFXBchCode00036').val(),
			'tDateFrom00036' 	: $('#oetITFXDateFrom00036').val(),
			'tDateTo00036' 		: $('#oetITFXDateTo00036').val()
		});
		JCNxBrowseData('oITFXBrowseDoc00036');
	});

	//ระหว่างเอกสาร Two
	$('#obtITFXBrowseFromDocCode00037').off('click').on('click',function(){
		window.oITFXBrowseDocTwo = undefined;
		oITFXBrowseDocTwo        = oITFXBrowseDocTwoOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00037',
			'tReturnInputName'  : 'oetITFXFromDocCode00037',
			'tBchCode00037' 	: $('#oetIFXBchCode00037').val(),
			'tDateFrom00037' 	: $('#oetITFXDateFrom00037').val(),
			'tDateTo00037' 		: $('#oetITFXDateTo00037').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwo');
	});

	$('#obtITFXBrowseToDocCode00037').off('click').on('click',function(){
		window.oITFXBrowseDocTwo = undefined;
		oITFXBrowseDocTwo        = oITFXBrowseDocTwoOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00037',
			'tReturnInputName'  : 'oetITFXToDocCode00037',
			'tBchCode00037' 	: $('#oetIFXBchCode00037').val(),
			'tDateFrom00037' 	: $('#oetITFXDateFrom00037').val(),
			'tDateTo00037' 		: $('#oetITFXDateTo00037').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwo');
	});

	//ระหว่างเอกสาร Txo
	$('#obtITFXBrowseFromDocCode00038').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocTXOOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00038',
			'tReturnInputName'  : 'oetITFXFromDocCode00038',
			'tBchCode00038' 	: $('#oetIFXBchCode00038').val(),
			'tDateFrom00038' 	: $('#oetITFXDateFrom00038').val(),
			'tDateTo00038' 		: $('#oetITFXDateTo00038').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	$('#obtITFXBrowseToDocCode00038').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocTXOOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00038',
			'tReturnInputName'  : 'oetITFXToDocCode00038',
			'tBchCode00038' 	: $('#oetIFXBchCode00038').val(),
			'tDateFrom00038' 	: $('#oetITFXDateFrom00038').val(),
			'tDateTo00038' 		: $('#oetITFXDateTo00038').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	//ระหว่างเอกสาร โอนระหว่างคลัง
	$('#obtITFXBrowseFromDocCode00039').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocTFWOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00039',
			'tReturnInputName'  : 'oetITFXFromDocCode00039',
			'tBchCode00039' 	: $('#oetIFXBchCode00039').val(),
			'tDateFrom00039' 	: $('#oetITFXDateFrom00039').val(),
			'tDateTo00039' 		: $('#oetITFXDateTo00039').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	$('#obtITFXBrowseToDocCode00039').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocTFWOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00039',
			'tReturnInputName'  : 'oetITFXToDocCode00039',
			'tBchCode00039' 	: $('#oetIFXBchCode00039').val(),
			'tDateFrom00039' 	: $('#oetITFXDateFrom00039').val(),
			'tDateTo00039' 		: $('#oetITFXDateTo00039').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	//เอกสาร Status การรับของ (ลูกค้า)
	$('#obtITFXBrowseFromDocCode00033').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocDOOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00033',
			'tReturnInputName'  : 'oetITFXFromDocCode00033',
			'tBchCode00033'		: $('#oetIFXBchCode00033').val(),
			'tDateFrom00033'	: $('#oetITFXDateFrom00033').val(),
			'tDateTo00033'		: $('#oetITFXDateTo00033').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	$('#obtITFXBrowseToDocCode00033').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocDOOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00033',
			'tReturnInputName'  : 'oetITFXToDocCode00033',
			'tBchCode00033'		: $('#oetIFXBchCode00033').val(),
			'tDateFrom00033'	: $('#oetITFXDateFrom00033').val(),
			'tDateTo00033'		: $('#oetITFXDateTo00033').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});
	
	//ส่งออก Status จัดสินค้า
	$('#obtITFXBrowseFromDocCode00035').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocPdtPickOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00035',
			'tReturnInputName'  : 'oetITFXFromDocCode00035',
			'tBchCode00035'		: $('#oetIFXBchCode00035').val(),
			'tDateFrom00035'	: $('#oetITFXDateFrom00035').val(),
			'tDateTo00035'		: $('#oetITFXDateTo00035').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	$('#obtITFXBrowseToDocCode00035').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocPdtPickOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00035',
			'tReturnInputName'  : 'oetITFXToDocCode00035',
			'tBchCode00035'		: $('#oetIFXBchCode00035').val(),
			'tDateFrom00035'	: $('#oetITFXDateFrom00035').val(),
			'tDateTo00035'		: $('#oetITFXDateTo00035').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	//ส่งออก Payin Slip
	$('#obtITFXBrowseFromDocCode00034').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocDepositOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00034',
			'tReturnInputName'  : 'ohdITFXFromDocName00034',
			'tBchCode00034'		: $('#oetIFXBchCode00034').val(),
			'tDateFrom00034'	: $('#oetITFXDateFrom00034').val(),
			'tDateTo00034'		: $('#oetITFXDateTo00034').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});

	$('#obtITFXBrowseToDocCode00034').off('click').on('click',function(){
		window.oITFXBrowseDocTwi = undefined;
		oITFXBrowseDocTwi        = oITFXBrowseDocDepositOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00034',
			'tReturnInputName'  : 'ohdITFXToDocName00034',
			'tBchCode00034'		: $('#oetIFXBchCode00034').val(),
			'tDateFrom00034'	: $('#oetITFXDateFrom00034').val(),
			'tDateTo00034'		: $('#oetITFXDateTo00034').val()
		});
		JCNxBrowseData('oITFXBrowseDocTwi');
	});
	

	// $('#obtITFXBrowseToDocCode00040').off('click').on('click',function(){
	// 	window.oITFXBrowseDocTwi = undefined;
	// 	oITFXBrowseDocTwi        = oITFXBrowseDocDepositOption({
	// 		'tReturnInputCode'  : 'oetITFXToDocCode00040',
	// 		'tReturnInputName'  : 'oetITFXDateTo00040',
	// 	});
	// 	JCNxBrowseData('oITFXBrowseDocTwi');
	// });

	//	ส่งออก Member - Earn/Burn Point(Sale)
	$('#obtITFXBrowseFromDocCode00040').off('click').on('click',function(){
		window.oITFXBrowseDocEBM = undefined;
		oITFXBrowseDocEBM        = oITFXBrowseDocEBOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00040',
			'tReturnInputName'  : 'oetITFXFromDocCode00040',
			'tWhereType'  		: '1',
			'tBchCode'			: $('#oetIFXBchCode00040').val(),
			'tDateFrom'			: $('#oetITFXDateFrom00040').val(),
			'tDateTo'			: $('#oetITFXDateTo00040').val(),
			'tWahCode'			: $('#oetIFXWahCode00040').val(),
			'tPosCode'			: $('#oetIFXPosCode00040').val(),
		});
		JCNxBrowseData('oITFXBrowseDocEBM');
	});

	$('#obtITFXBrowseToDocCode00040').off('click').on('click',function(){
		window.oITFXBrowseDocEBM = undefined;
		oITFXBrowseDocEBM        = oITFXBrowseDocEBOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00040',
			'tReturnInputName'  : 'oetITFXToDocCode00040',
			'tWhereType'  		: '1',
			'tBchCode'			: $('#oetIFXBchCode00040').val(),
			'tDateFrom'			: $('#oetITFXDateFrom00040').val(),
			'tDateTo'			: $('#oetITFXDateTo00040').val(),
			'tWahCode'			: $('#oetIFXWahCode00040').val(),
			'tPosCode'			: $('#oetIFXPosCode00040').val(),
		});
		JCNxBrowseData('oITFXBrowseDocEBM');
	});

	//	ส่งออก Earn/Burn Point(Return)
	$('#obtITFXBrowseFromDocCode00041').off('click').on('click',function(){
		window.oITFXBrowseDocEBP = undefined;
		oITFXBrowseDocEBP        = oITFXBrowseDocEBOption({
			'tReturnInputCode'  : 'oetITFXFromDocCode00041',
			'tReturnInputName'  : 'oetITFXFromDocCode00041',
			'tWhereType'  		: '9',
			'tBchCode'			: $('#oetIFXBchCode00041').val(),
			'tDateFrom'			: $('#oetITFXDateFrom00041').val(),
			'tDateTo'			: $('#oetITFXDateTo00041').val(),
			'tWahCode'			: $('#oetIFXWahCode00041').val(),
			'tPosCode'			: $('#oetIFXPosCode00041').val(),
		});
		JCNxBrowseData('oITFXBrowseDocEBP');
	});

	$('#obtITFXBrowseToDocCode00041').off('click').on('click',function(){
		window.oITFXBrowseDocEBP = undefined;
		oITFXBrowseDocEBP        = oITFXBrowseDocEBOption({
			'tReturnInputCode'  : 'oetITFXToDocCode00041',
			'tReturnInputName'  : 'oetITFXToDocCode00041',
			'tWhereType'  		: '9',
			'tBchCode'			: $('#oetIFXBchCode00041').val(),
			'tDateFrom'			: $('#oetITFXDateFrom00041').val(),
			'tDateTo'			: $('#oetITFXDateTo00041').val(),
			'tWahCode'			: $('#oetIFXWahCode00041').val(),
			'tPosCode'			: $('#oetIFXPosCode00041').val(),
		});
		JCNxBrowseData('oITFXBrowseDocEBP');
	});

	var oITFXBrowseDocEBOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tWhereType = poReturnInput.tWhereType;
		var tWhere = "";
		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		if (tWhereType == '1') {
			tWhere += " AND TPSTSalHD.FNXshDocType = '1' ";
		} else {
			tWhere += " AND TPSTSalHD.FNXshDocType = '9' ";
		}

		let tBchCode = poReturnInput.tBchCode;
		let tWahCode = poReturnInput.tWahCode;
		let tPosCode = poReturnInput.tPosCode;
		let tDateFrom = poReturnInput.tDateFrom;
		let tDateTo = poReturnInput.tDateTo;

		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

		if( tBchCode != "" ){
			tWhere += " AND TPSTSalHD.FTBchCode = '"+tBchCode+"' ";
		}

		if( tWahCode != "" ){
			tWhere += " AND TPSTSalHD.FTWahCode = '"+tWahCode+"' ";
		}

		if( tPosCode != "" ){
			tWhere += " AND TPSTSalHD.FTPosCode = '"+tPosCode+"' ";
		}

        let oOptionReturn    = {
            Title: ['interface/interfaceexport/interfaceexport','tITFXDataSal'],
            Table:{Master:'TPSTSalHD',PK:'FTXshDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TPSTSalHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['35%','35%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TPSTSalHD.FTXshDocNo','TPSTSalHD.FDXshDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TPSTSalHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TPSTSalHD.FTXshDocNo"],
                Text		: [tInputReturnName,"TPSTSalHD.FTXshDocNo"]
			},
        };
        return oOptionReturn;
	};

	$('#obtITFXBrowseFromDocCode00042').off('click').on('click',function(){
		window.oITFXBrowseDocSalVD = undefined;
		oITFXBrowseDocSalVD        = oITFXBrowseDocSalVDOption({
			'tDocType'  		: '1',
			'tBchCode'			: $('#oetIFXBchCode00042').val(),
			'tWahCode'			: $('#oetIFXWahCode00042').val(),
			'tPosCode'			: $('#oetIFXPosCode00042').val(),
			'dDocDateFrom'		: $('#oetITFXDateFrom00042').val(),
			'dDocDateTo'		: $('#oetITFXDateTo00042').val(),
			'tReturnInputCode'  : 'oetITFXFromDocCode00042',
			'tReturnInputName'  : 'oetITFXFromDocCode00042',
		});
		JCNxBrowseData('oITFXBrowseDocSalVD');
	});

	$('#obtITFXBrowseToDocCode00042').off('click').on('click',function(){
		window.oITFXBrowseDocSalVD = undefined;
		oITFXBrowseDocSalVD        = oITFXBrowseDocSalVDOption({
			'tDocType'  		: '1',
			'tBchCode'			: $('#oetIFXBchCode00042').val(),
			'tWahCode'			: $('#oetIFXWahCode00042').val(),
			'tPosCode'			: $('#oetIFXPosCode00042').val(),
			'dDocDateFrom'		: $('#oetITFXDateFrom00042').val(),
			'dDocDateTo'		: $('#oetITFXDateTo00042').val(),
			'tReturnInputCode'  : 'oetITFXToDocCode00042',
			'tReturnInputName'  : 'oetITFXToDocCode00042',
		});
		JCNxBrowseData('oITFXBrowseDocSalVD');
	});

	var oITFXBrowseDocSalVDOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		var nLangEdits  	 = '<?php echo $this->session->userdata("tLangEdit");?>';
		var tWhere 			 = "";

		let tDocType 		 = poReturnInput.tDocType;
		let tBchCode		 = poReturnInput.tBchCode;
		let tWahCode		 = poReturnInput.tWahCode;
		let tPosCode		 = poReturnInput.tPosCode;
		let dDocDateFrom	 = poReturnInput.dDocDateFrom;
		let dDocDateTo	 	 = poReturnInput.dDocDateTo;
		
		if( dDocDateFrom == "" ){
			dDocDateFrom = dDocDateTo;
		}

		if( dDocDateTo == "" ){
			dDocDateTo = dDocDateFrom;
		}

		if ( tDocType == '1' ) {
			tWhere += " AND TVDTSalHD.FNXshDocType = '1' ";
		} else {
			tWhere += " AND TVDTSalHD.FNXshDocType = '9' ";
		}

		if( tBchCode != "" ){
			tWhere += " AND TVDTSalHD.FTBchCode = '"+tBchCode+"' ";
		}
		if( tWahCode != "" ){
			tWhere += " AND TVDTSalHD.FTWahCode = '"+tWahCode+"' ";
		}
		if( tPosCode != "" ){
			tWhere += " AND TVDTSalHD.FTPosCode = '"+tPosCode+"' ";
		}

		if( dDocDateFrom != "" && dDocDateTo != "" ){
			tWhere += " AND (CONVERT(VARCHAR(10),TVDTSalHD.FDXshDocDate,121) BETWEEN '"+dDocDateFrom+"' AND '"+dDocDateTo+"' OR CONVERT(VARCHAR(10),TVDTSalHD.FDXshDocDate,121) BETWEEN '"+dDocDateTo+"' AND '"+dDocDateFrom+"') ";
		}

        let oOptionReturn    = {
            Title: ['interface/interfaceexport/interfaceexport','tITFXDataSal'],
            Table:{Master:'TVDTSalHD',PK:'FTXshDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TVDTSalHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['20%','60%','20%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TVDTSalHD.FTXshDocNo','TVDTSalHD.FDXshDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TVDTSalHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TVDTSalHD.FTXshDocNo"],
                Text		: [tInputReturnName,"TVDTSalHD.FTXshDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocDepositOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let tBchCode = poReturnInput.tBchCode00034;
		let tDateFrom = poReturnInput.tDateFrom00034;
		let tDateTo = poReturnInput.tDateTo00034;
		var tWhere = "";

		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TFNTBnkDplHD.FDBdhDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TFNTBnkDplHD.FDBdhDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

		if( tBchCode != "" ){
			tWhere += " AND TFNTBnkDplHD.FTBchCode = '"+tBchCode+"' ";
		}

        let oOptionReturn    = {
            Title: ['interface/interfaceexport/interfaceexport','ใบนำฝาก'],
            Table:{Master:'TFNTBnkDplHD',PK:'FTBdhDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TFNTBnkDplHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['30%','40%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TFNTBnkDplHD.FTBdhDocNo','TFNTBnkDplHD.FDBdhDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TFNTBnkDplHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TFNTBnkDplHD.FTBdhDocNo"],
                Text		: [tInputReturnName,"TFNTBnkDplHD.FTBdhDocNo"]
			},
			// DebugSQL: true,
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocPdtPickOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tBchCode = poReturnInput.tBchCode00035;
		let tDateFrom = poReturnInput.tDateFrom00035;
		let tDateTo = poReturnInput.tDateTo00035;
		var tWhere 			 = "";
		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TCNTPdtPickHD.FDXthDocDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TCNTPdtPickHD.FDXthDocDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

		if( tBchCode != "" ){
			tWhere += " AND TCNTPdtPickHD.FTBchCode = '"+tBchCode+"' ";
		}

        let oOptionReturn    = {
            Title: ['interface/interfaceexport/interfaceexport','tITFXPdtPick'],
            Table:{Master:'TCNTPdtPickHD',PK:'FTXthDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNTPdtPickHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['30%','40%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TCNTPdtPickHD.FTXthDocNo','TCNTPdtPickHD.FDXthDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TCNTPdtPickHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNTPdtPickHD.FTXthDocNo"],
                Text		: [tInputReturnName,"TCNTPdtPickHD.FTXthDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocDOOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tBchCode = poReturnInput.tBchCode00033;
		let tDateFrom = poReturnInput.tDateFrom00033;
		let tDateTo = poReturnInput.tDateTo00033;
		var tWhere 			 = "";
		var nLangEdits       = '<?php echo $this->session->userdata("tLangEdit");?>';

		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TARTDoHD.FDXshDocDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TARTDoHD.FDXshDocDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

		if( tBchCode != "" ){
			tWhere += " AND TARTDoHD.FTBchCode = '"+tBchCode+"' ";
		}

        let oOptionReturn    = {
            Title: ['interface/interfaceexport/interfaceexport','tITFXDo'],
            Table:{Master:'TARTDoHD',PK:'FTXshDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TARTDoHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['35%','35%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TARTDoHD.FTXshDocNo','TARTDoHD.FDXshDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TARTDoHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TARTDoHD.FTXshDocNo"],
                Text		: [tInputReturnName,"TARTDoHD.FTXshDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocTwoOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tBchCode00037 	 = poReturnInput.tBchCode00037;
		var tWhere 			 = "";
		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

		if( tBchCode00037 != "" ){
			tWhere += " AND TCNTPdtTwoHD.FTBchCode = '"+tBchCode00037+"' ";
		}

		let tDateFrom = poReturnInput.tDateFrom00037;
		let tDateTo = poReturnInput.tDateTo00037;

		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TCNTPdtTwoHD.FDXthDocDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TCNTPdtTwoHD.FDXthDocDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

		tWhere += " AND TCNTPdtTwoHD.FNXthDocType = '2' ";

        let oOptionReturn    = {
            Title: ['document/transferwarehouseout/transferwarehouseout','tTWOTitle_2'],
            Table:{Master:'TCNTPdtTwoHD',PK:'FTXthDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNTPdtTwoHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['35%','35%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TCNTPdtTwoHD.FTXthDocNo','TCNTPdtTwoHD.FDXthDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TCNTPdtTwoHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNTPdtTwoHD.FTXthDocNo"],
                Text		: [tInputReturnName,"TCNTPdtTwoHD.FTXthDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocTXOOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tBchCode00038 	 = poReturnInput.tBchCode00038;
		var tWhere 			 = "";
		var nLangEdits  	 = '<?php echo $this->session->userdata("tLangEdit");?>';

		if( tBchCode00038 != "" ){
			tWhere += " AND TCNTPdtTwiHD.FTBchCode = '"+tBchCode00038+"' ";
		}

		let tDateFrom = poReturnInput.tDateFrom00038;
		let tDateTo = poReturnInput.tDateTo00038;
		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TCNTPdtTwiHD.FDXthDocDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TCNTPdtTwiHD.FDXthDocDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

		tWhere += " AND TCNTPdtTwiHD.FNXthDocType = '1' ";

        let oOptionReturn    = {
            Title: ['document/adjustmentcost/adjustmentcost','tWITitle'],
            Table:{Master:'TCNTPdtTwiHD',PK:'FTXthDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNTPdtTwiHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['35%','35%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TCNTPdtTwiHD.FTXthDocNo','TCNTPdtTwiHD.FDXthDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TCNTPdtTwiHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNTPdtTwiHD.FTXthDocNo"],
                Text		: [tInputReturnName,"TCNTPdtTwiHD.FTXthDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocTFWOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tBchCode00039 	 = poReturnInput.tBchCode00039;
		let tDateFrom00039 	 = poReturnInput.tDateFrom00039;
		let tDateTo00039 	 = poReturnInput.tDateTo00039;

		var tWhere			 = "";

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		if( tBchCode00039 != "" ){
			tWhere += " AND TCNTPdtTwxHD.FTBchCode = '"+tBchCode00039+"' ";
		}

		if( tDateFrom00039 != "" && tDateTo00039 != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TCNTPdtTwxHD.FDXthDocDate,121) BETWEEN '"+tDateFrom00039+"' AND '"+tDateTo00039+"' OR CONVERT(VARCHAR(10),TCNTPdtTwxHD.FDXthDocDate,121) BETWEEN '"+tDateTo00039+"' AND '"+tDateFrom00039+"' ) ";
		}

        let oOptionReturn    = {
            Title: ['document/adjustmentcost/adjustmentcost','ใบโอนสินค้าระหว่างคลัง'],
            Table:{Master:'TCNTPdtTwxHD',PK:'FTXthDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNTPdtTwxHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['35%','35%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TCNTPdtTwxHD.FTXthDocNo','TCNTPdtTwxHD.FDXthDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TCNTPdtTwxHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNTPdtTwxHD.FTXthDocNo"],
                Text		: [tInputReturnName,"TCNTPdtTwxHD.FTXthDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseDocReqBchHDOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tBchCode00036 	 = poReturnInput.tBchCode00036;
		var tWhere 			 = "";

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		if( tBchCode00036 != "" ){
			tWhere += " AND TCNTPdtReqBchHD.FTBchCode = '"+tBchCode00036+"' ";
		}

		let tDateFrom = poReturnInput.tDateFrom00036;
		let tDateTo = poReturnInput.tDateTo00036;
		if( tDateFrom != "" && tDateTo != "" ){
			tWhere += " AND ( CONVERT(VARCHAR(10),TCNTPdtReqBchHD.FDXthDocDate,121) BETWEEN '"+tDateFrom+"' AND '"+tDateTo+"' OR CONVERT(VARCHAR(10),TCNTPdtReqBchHD.FDXthDocDate,121) BETWEEN '"+tDateTo+"' AND '"+tDateFrom+"' ) ";
		}

        let oOptionReturn    = {
            Title: ['document/transferreceiptNew/transferreceiptNew','ใบขอโอน - สาขา'],
            Table:{Master:'TCNTPdtReqBchHD',PK:'FTXthDocNo'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNTPdtReqBchHD.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'document/transferwarehouseout/transferwarehouseout',
                ColumnKeyLang	: ['tTWOBranch','tTWODocNo','tTWODocDate'],
                ColumnsSize     : ['30%','40%','30%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch_L.FTBchName','TCNTPdtReqBchHD.FTXthDocNo','TCNTPdtReqBchHD.FDXthDocDate'],
                DataColumnsFormat : ['','','Date:0'],
                Perpage			: 10,
                OrderBy			: ['TCNTPdtReqBchHD.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNTPdtReqBchHD.FTXthDocNo"],
				Text		: [tInputReturnName,"TCNTPdtReqBchHD.FTXthDocNo"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseAgnOption = function(poReturnInput){
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';

        let oOptionReturn    = {
            Title: ['ticket/agency/agency','tAggTitle'],
            Table:{Master:'TCNMAgency',PK:'FTAgnCode'},
			Join: {
                Table: ['TCNMAgency_L'],
                On:['TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = '+nLangEdits]
			},
            GrideView:{
                ColumnPathLang	: 'ticket/agency/agency',
                ColumnKeyLang	: ['tAggCode','tAggName'],
                ColumnsSize     : ['30%','70%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMAgency.FTAgnCode','TCNMAgency_L.FTAgnName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMAgency.FTAgnCode"],
                Text		: [tInputReturnName,"TCNMAgency_L.FTAgnName"]
			},
        };
        return oOptionReturn;
	};

	var oITFXBrowseShiftOption = function(poReturnInput){
		let tNextFuncName    = poReturnInput.tNextFuncName;
		let aArgReturn       = poReturnInput.aArgReturn;
		let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tTFXShiftDocDate = poReturnInput.tTFXShiftDocDate;
		let tTFXShiftBchCode = poReturnInput.tTFXShiftBchCode;
		let tTFXShiftPosCode = poReturnInput.tTFXShiftPosCode;

		var tUsrLevel     			= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tSesUsrBchCodeDefault 	= "<?=$this->session->userdata("tSesUsrBchCodeDefault");?>";
		// var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		// var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
		// var tBchCodeFin = $("#oetIFXBchCodeFin").val();
		let tWhere		     = "";

		// if(tUsrLevel != "HQ"){
		// 	tWhere = " AND TPSTShiftHD.FTBchCode IN ("+tBchCodeMulti+") ";
		// }else{
		// 	tWhere = " AND TPSTShiftHD.FTBchCode IN ("+tBchCodeFin+") ";
		// }

		if( tTFXShiftDocDate != "" ){
			tWhere += " AND CONVERT(VARCHAR(10),TPSTShiftHD.FDShdSaleDate,121) = '"+tTFXShiftDocDate+"' ";
		}

		if( tTFXShiftBchCode != "" ){ 												
			tWhere += " AND TPSTShiftHD.FTBchCode = '"+tTFXShiftBchCode+"' ";			// ดึงสาขาจาก Input ให้เลือกบนหน้าจอ
		}else{																			// ถ้าไม่เลือกสาขา
			if( tUsrLevel != "HQ" ){													// ถ้าไม่ใช่ HQ
				tWhere += " AND TPSTShiftHD.FTBchCode = '"+tSesUsrBchCodeDefault+"' ";  // จะดึงสาขา Default มาแทน
			}																			// ถ้าเป็น HQ จะแสดงทุกสาขา
		}

		if( tTFXShiftPosCode != "" ){
			tWhere += " AND TPSTShiftHD.FTPosCode = '"+tTFXShiftPosCode+"' ";
		}

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let oOptionReturn    = {
			Title: ['sale/salemonitor/salemonitor','tSMTInformation-Shift'],
			Table:{Master:'TPSTShiftHD',PK:'FTShfCode'},
			// Join: {
			// 	Table: ['TCNMBranch_L'],
			// 	On: [
			// 		'TCNMBranch_L.FTBchCode = TPSTShiftHD.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits
			// 	]
			// },
			Where: {
				Condition: [tWhere]
			},
			GrideView:{
				ColumnPathLang	: 'sale/salemonitor/salemonitor',
				ColumnKeyLang	: ['tSMTShiftCode','tSMTShift-opendate','tSMTShift-closedate'],
				ColumnsSize     : ['60%','20%','20%'],
				WidthModal      : 50,
				DataColumns		: ['TPSTShiftHD.FTShfCode','TPSTShiftHD.FDShdSignIn','TPSTShiftHD.FDShdSignOut'],
				DataColumnsFormat : ['','Date:0','Date:0'],
				Perpage			: 10,
				OrderBy			: ['TPSTShiftHD.FDCreateOn DESC'],
			},
			CallBack:{
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TPSTShiftHD.FTShfCode"],
				Text		: [tInputReturnName,"TPSTShiftHD.FTShfCode"]
			},
		};
		return oOptionReturn;
	};
	var oITFXBrowseWahOption = function(poReturnInput){
		let tNextFuncName    = poReturnInput.tNextFuncName;
		let aArgReturn       = poReturnInput.aArgReturn;
		let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tTFXWahBchCode   = poReturnInput.tIFXBchCode;
		let tIFXWahType      = poReturnInput.tIFXWahType;

		var tUsrLevel     			= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tBchCodeMulti 			= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		var tSesUsrBchCodeDefault 	= "<?=$this->session->userdata("tSesUsrBchCodeDefault");?>";
		// var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
		// var tBchCodeFin = $("#oetIFXBchCodeFin").val();
		let tWhere		     = "";

		if( tTFXWahBchCode != "" ){ 												
			tWhere += " AND TCNMWaHouse.FTBchCode = '"+tTFXWahBchCode+"' ";			// ดึงสาขาจาก Input ให้เลือกบนหน้าจอ
		}else{																		// ถ้าไม่เลือกสาขา
			if( tUsrLevel != "HQ" ){												// ถ้าไม่ใช่ HQ
				tWhere += " AND TCNMWaHouse.FTBchCode = '"+tSesUsrBchCodeDefault+"' ";  // จะดึงสาขา Default มาแทน
			}																		// ถ้าเป็น HQ จะแสดงทุกสาขา
		}

		if( tIFXWahType !== "ALL" && tIFXWahType !== undefined ){
			tWhere += " AND TCNMWaHouse.FTWahStaType = '"+tIFXWahType+"' ";
		}

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let oOptionReturn    = {
			Title: ['pos/salemachine/salemachine','tPOSTitle'],
			Table:{Master:'TCNMWaHouse',PK:'FTWahCode'},
			Join: {
				Table: ['TCNMWaHouse_L'],
				On: [
					'TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FTWahCode = TCNMWaHouse.FTWahCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [tWhere]
			},
			GrideView:{
				ColumnPathLang	: 'company/warehouse/warehouse',
				ColumnKeyLang	: ['tWahCode','tWahName'],
				ColumnsSize     : ['30%','70%'],
				WidthModal      : 50,
				DataColumns		: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
				DataColumnsFormat : ['',''],
				Perpage			: 10,
				OrderBy			: ['TCNMWaHouse.FDCreateOn DESC'],
			},
			CallBack:{
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
				Text		: [tInputReturnName,"TCNMWaHouse_L.FTWahName"]
			},
		};
		return oOptionReturn;
	};
	var oITFXBrowsePosSaleOption = function(poReturnInput){
		let tNextFuncName    = poReturnInput.tNextFuncName;
		let aArgReturn       = poReturnInput.aArgReturn;
		let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tTFXShiftBchCode = poReturnInput.tTFXShiftBchCode;

		var tUsrLevel     			= "<?=$this->session->userdata("tSesUsrLevel");?>";
		var tSesUsrBchCodeDefault 	= "<?=$this->session->userdata("tSesUsrBchCodeDefault");?>";
		// var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		// var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
		// var tBchCodeFin = $("#oetIFXBchCodeFin").val();
		let tWhere		     = "";

		// if(tUsrLevel != "HQ"){
		// 	tWhere = " AND TCNMPos.FTBchCode IN ("+tBchCodeMulti+") ";
		// }else{
		// 	tWhere = " AND TCNMPos.FTBchCode IN ("+tBchCodeFin+") ";
		// }
		
		if( tTFXShiftBchCode != "" ){ 												
			tWhere += " AND TCNMPos.FTBchCode = '"+tTFXShiftBchCode+"' ";			// ดึงสาขาจาก Input ให้เลือกบนหน้าจอ
		}else{																		// ถ้าไม่เลือกสาขา
			if( tUsrLevel != "HQ" ){												// ถ้าไม่ใช่ HQ
				tWhere += " AND TCNMPos.FTBchCode = '"+tSesUsrBchCodeDefault+"' ";  // จะดึงสาขา Default มาแทน
			}																		// ถ้าเป็น HQ จะแสดงทุกสาขา
		}

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let oOptionReturn    = {
			Title: ['pos/salemachine/salemachine','tPOSTitle'],
			Table:{Master:'TCNMPos',PK:'FTPosCode'},
			Join: {
				Table: ['TCNMPos_L'],
				On: [
					'TCNMPos_L.FTBchCode = TCNMPos.FTBchCode AND TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [tWhere]
			},
			GrideView:{
				ColumnPathLang	: 'pos/salemachine/salemachine',
				ColumnKeyLang	: ['tPOSCode','tPOSName'],
				ColumnsSize     : ['30%','70%'],
				WidthModal      : 50,
				DataColumns		: ['TCNMPos.FTPosCode','TCNMPos_L.FTPosName'],
				DataColumnsFormat : ['',''],
				Perpage			: 10,
				OrderBy			: ['TCNMPos.FDCreateOn DESC'],
			},
			CallBack:{
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMPos.FTPosCode"],
				Text		: [tInputReturnName,"TCNMPos_L.FTPosName"]
			},
		};
		return oOptionReturn;
	};
	
	var oITFXBrowsePosOption = function(poReturnInput){
		let tNextFuncName    = poReturnInput.tNextFuncName;
		let aArgReturn       = poReturnInput.aArgReturn;
	  	let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		let tIFXBchCode      = poReturnInput.tIFXBchCode;
		let tIFXPosType		 = poReturnInput.tIFXPosType;

		var tUsrLevel     			= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tSesUsrBchCodeDefault 	= "<?=$this->session->userdata("tSesUsrBchCodeDefault");?>";
		// var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		// var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
		// var tBchCodeFin = $("#oetIFXBchCodeFin").val();
		let tWhere		     = "";

		if( tIFXBchCode != "" ){ 												
			tWhere += " AND TCNMPos.FTBchCode = '"+tIFXBchCode+"' ";				// ดึงสาขาจาก Input ให้เลือกบนหน้าจอ
		}else{																		// ถ้าไม่เลือกสาขา
			if( tUsrLevel != "HQ" ){												// ถ้าไม่ใช่ HQ
				tWhere += " AND TCNMPos.FTBchCode = '"+tSesUsrBchCodeDefault+"' ";  // จะดึงสาขา Default มาแทน
			}																		// ถ้าเป็น HQ จะแสดงทุกสาขา
		}

		if( tIFXPosType !== "ALL" && tIFXPosType !== undefined ){
			tWhere += " AND TCNMPos.FTPosType = '"+tIFXPosType+"' ";
		}

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let oOptionReturn    = {
			Title: ['pos/salemachine/salemachine','tPOSTitle'],
			Table:{Master:'TCNMPos',PK:'FTPosCode'},
			Join: {
				Table: ['TCNMPos_L'],
				On: [
					'TCNMPos_L.FTBchCode = TCNMPos.FTBchCode AND TCNMPos_L.FTPosCode = TCNMPos.FTPosCode AND TCNMPos_L.FNLngID = ' + nLangEdits
				]
			},
			Where: {
				Condition: [tWhere]
			},
			GrideView:{
				ColumnPathLang	: 'pos/salemachine/salemachine',
				ColumnKeyLang	: ['tPOSCode','tPOSName'],
				ColumnsSize     : ['30%','70%'],
				WidthModal      : 50,
				DataColumns		: ['TCNMPos.FTPosCode','TCNMPos_L.FTPosName'],
				DataColumnsFormat : ['',''],
				Perpage			: 10,
				OrderBy			: ['TCNMPos.FDCreateOn DESC'],
			},
			CallBack:{
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TCNMPos.FTPosCode"],
				Text		: [tInputReturnName,"TCNMPos_L.FTPosName"]
			},
		};
		return oOptionReturn;
	};
	var oITFXBrowseBchOption = function(poReturnInput){
        let tNextFuncName    = poReturnInput.tNextFuncName;
        let aArgReturn       = poReturnInput.aArgReturn;
        let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;

		var tUsrLevel     = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
		var nCountBch     = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
		let tWhere		     = "";

		if(tUsrLevel != "HQ"){
			tWhere = " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
		}else{
			tWhere = "";
		}

		var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
        let oOptionReturn    = {
            Title: ['company/branch/branch','tBCHTitle'],
            Table:{Master:'TCNMBranch',PK:'FTBchCode'},
			Join: {
                Table: ['TCNMBranch_L'],
                On:['TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits]
			},
			Where: {
				Condition: [tWhere]
			},
            GrideView:{
                ColumnPathLang	: 'company/branch/branch',
                ColumnKeyLang	: ['tBCHCode','tBCHName'],
                ColumnsSize     : ['30%','70%'],
                WidthModal      : 50,
                DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
                DataColumnsFormat : ['',''],
                Perpage			: 10,
                OrderBy			: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack:{
                ReturnType	: 'S',
                Value		: [tInputReturnCode,"TCNMBranch.FTBchCode"],
                Text		: [tInputReturnName,"TCNMBranch_L.FTBchName"]
			},
        };
        return oOptionReturn;
	};

	// Create By : Napat(Jame) 17/08/2020 เมื่อกดปุ่มยืนยันให้วิ่งไปที่หน้า ประวัตินำเข้า-ส่งออก
	$('#obtIFXModalMsgConfirm').off('click');
	$('#obtIFXModalMsgConfirm').on('click',function(){
		// ใส่ timeout ป้องกัน modal-backdrop
		setTimeout(function(){
			$.ajax({
				type    : "POST",
				url     : "interfacehistory/0/0",
				data    : {},
				cache   : false,
				Timeout : 0,
				success: function(tResult){
					$('.odvMainContent').html(tResult);
				},
				error: function(jqXHR, textStatus, errorThrown) {
					JCNxResponseError(jqXHR, textStatus, errorThrown);
				}
			});
		}, 100);
	});

	$('#obtITFXBrowseFromSaleFin').off('click').on('click',function(){
		window.oITFXBrowseSale = undefined;
		oITFXBrowseSale      = oITFXBrowseSaleOption({
			'tTFXSaleBchCode'   	: $('#oetIFXBchCodeFin').val(),
			'tTFXSaleWahCode'   	: $('#oetIFXWahCodeFin').val(),
			'tTFXSalePosCode'   	: $('#oetIFXPosCodeFin').val(),
			'tTFXSaleType'			: $('#ocmITFXXshType').val(),
			'tTFXSaleDocDateFrom'   : $('#oetITFXDateFromFinanceFin').val(),
			'tTFXSaleDocDateTo'   	: $('#oetITFXDateToFinanceFin').val(),
			'tReturnInputCode'  	: 'oetITFXXshDocNoFromFin',
			'tReturnInputName'  	: 'oetITFXXshDocNoFromFin',
		});
		JCNxBrowseData('oITFXBrowseSale');
	});

	$('#obtITFXBrowseToSaleFin').off('click').on('click',function(){
		window.oITFXBrowseSale = undefined;
		oITFXBrowseSale      = oITFXBrowseSaleOption({
			'tTFXSaleBchCode'   	: $('#oetIFXBchCodeFin').val(),
			'tTFXSaleWahCode'   	: $('#oetIFXWahCodeFin').val(),
			'tTFXSalePosCode'   	: $('#oetIFXPosCodeFin').val(),
			'tTFXSaleType'			: $('#ocmITFXXshType').val(),
			'tTFXSaleDocDateFrom'   : $('#oetITFXDateFromFinanceFin').val(),
			'tTFXSaleDocDateTo'   	: $('#oetITFXDateToFinanceFin').val(),
			'tReturnInputCode'  	: 'oetITFXXshDocNoToFin',
			'tReturnInputName'  	: 'oetITFXXshDocNoToFin',
		});
		JCNxBrowseData('oITFXBrowseSale');
	});

	var oITFXBrowseSaleOption = function(poReturnInput){
		let tNextFuncName    = poReturnInput.tNextFuncName;
		let aArgReturn       = poReturnInput.aArgReturn;
		let tInputReturnCode = poReturnInput.tReturnInputCode;
		let tInputReturnName = poReturnInput.tReturnInputName;
		// let tTFXShiftDocDate = poReturnInput.tTFXShiftDocDate;
		let tTFXSaleBchCode  = poReturnInput.tTFXSaleBchCode;
		let tTFXSaleWahCode  = poReturnInput.tTFXSaleWahCode;
		let tTFXSalePosCode  = poReturnInput.tTFXSalePosCode;
		let tTFXSaleType 	 = poReturnInput.tTFXSaleType;
		let tTFXDocType		 = poReturnInput.tTFXDocType;

		let tTFXSaleDocDateFrom 	= poReturnInput.tTFXSaleDocDateFrom;
		let tTFXSaleDocDateTo 		= poReturnInput.tTFXSaleDocDateTo;

		

		if( tTFXSaleBchCode === undefined ){ tTFXSaleBchCode = ''; }
		if( tTFXSaleWahCode === undefined ){ tTFXSaleWahCode = ''; }
		if( tTFXSalePosCode === undefined ){ tTFXSalePosCode = ''; }
		if( tTFXSaleType === undefined ){ tTFXSaleType = ''; }

		if( tTFXSaleDocDateFrom === undefined ){ tTFXSaleDocDateFrom = ''; }
		if( tTFXSaleDocDateTo === undefined ){ tTFXSaleDocDateTo = ''; }

		var tUsrLevel     			= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tSesUsrBchCodeDefault 	= "<?=$this->session->userdata("tSesUsrBchCodeDefault");?>";
		let tWhere		     		= "";
		
		if( tTFXSaleDocDateFrom == "" && tTFXSaleDocDateTo != "" ){
			tTFXSaleDocDateFrom = tTFXSaleDocDateTo;
		}

		if( tTFXSaleDocDateFrom != "" && tTFXSaleDocDateTo == "" ){
			tTFXSaleDocDateTo = tTFXSaleDocDateFrom;
		}

		if( tTFXSaleDocDateFrom != "" && tTFXSaleDocDateTo != "" ){
			tWhere += " AND (CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) BETWEEN '"+tTFXSaleDocDateFrom+"' AND '"+tTFXSaleDocDateTo+"' OR CONVERT(VARCHAR(10),TPSTSalHD.FDXshDocDate,121) BETWEEN '"+tTFXSaleDocDateTo+"' AND '"+tTFXSaleDocDateFrom+"') ";
		}

		if( tTFXSaleBchCode != "" ){ 												
			tWhere += " AND TPSTSalHD.FTBchCode = '"+tTFXSaleBchCode+"' ";				// ดึงสาขาจาก Input ให้เลือกบนหน้าจอ
		}else{																			// ถ้าไม่เลือกสาขา
			if( tUsrLevel != "HQ" ){													// ถ้าไม่ใช่ HQ
				tWhere += " AND TPSTSalHD.FTBchCode = '"+tSesUsrBchCodeDefault+"' ";  	// จะดึงสาขา Default มาแทน
			}																			// ถ้าเป็น HQ จะแสดงทุกสาขา
		}

		if( tTFXSaleWahCode != "" ){
			tWhere += " AND TPSTSalHD.FTWahCode = '"+tTFXSaleWahCode+"' ";
		}

		if( tTFXSalePosCode != "" ){
			tWhere += " AND TPSTSalHD.FTPosCode = '"+tTFXSalePosCode+"' ";
		}

		if( tTFXDocType === undefined ){ // ถ้าไม่มีประเภทเอกสารให้เลือกบนหน้าจอ ให้ยึดจาก พารามิเตอร์ที่ส่งมา
			if( tTFXSaleType != "" ){ // ถ้ามีพารามิเตอร์ที่ส่งมา
				tWhere += " AND TPSTSalHD.FNXshDocType = "+tTFXSaleType;
			}
		}else{ // ถ้ามีให้เลือกประเภทเอกสารบนหน้าจอส่งออก ให้นำมาใช้งาน
			tWhere += " AND TPSTSalHD.FNXshDocType = "+tTFXDocType;
		}

		// var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let oOptionReturn    = {
			Title: ['interface/interfaceexport/interfaceexport','tITFXDataSal'],
			Table: { Master:'TPSTSalHD',PK:'FTXshDocNo' },
			Where: {
				Condition: [tWhere]
			},
			GrideView:{
				ColumnPathLang	: 'interface/interfaceexport/interfaceexport',
				ColumnKeyLang	: ['tITFXSalDocNo','เลขที่อ้างอิงเอกสารภายนอก','tITFXSalDate'],
				// ColumnsSize     : ['30%','30%','30%','10%'],
				WidthModal      : 50,
				DataColumns		: ['TPSTSalHD.FTXshDocNo','TPSTSalHD.FTXshRefExt','TPSTSalHD.FDXshDocDate'],
				DataColumnsFormat : ['','','','Date:0'],
				Perpage			: 10,
				OrderBy			: ['TPSTSalHD.FDCreateOn DESC'],
			},
			CallBack:{
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TPSTSalHD.FTXshDocNo"],
				Text		: [tInputReturnName,"TPSTSalHD.FTXshDocNo"]
			},
			NextFunc : {
                FuncName    : 'JSxIFXSalNextFunc',
                ArgReturn   : ["FTXshDocNo"]
            }
		};
		return oOptionReturn;
	};

	function JSxIFXSalNextFunc(poData){
		// console.log($ptData);
		if( poData != "NULL" ){
			var paData     = JSON.parse(poData);
			var tDocNoTo   = $('#oetITFXXshDocNoToFin').val();
			var tDocNoFrom = $('#oetITFXXshDocNoFromFin').val();
			var tDocNoSelected = paData[0];

			if( tDocNoTo == "" ){
				$('#oetITFXXshDocNoToFin').val(tDocNoSelected);
			}else if( tDocNoFrom == "" ){
				$('#oetITFXXshDocNoFromFin').val(tDocNoSelected);
			}
		}
		/*else{

		}*/
	}

	$('#ocmITFXXshType').on('change',function(){
		$('#oetITFXXshDocNoToFin').val('');
		$('#oetITFXXshDocNoFromFin').val('');
	});

	$('#obtITFXBrowseFromTax00018').off('click').on('click',function(){
		window.oITFXBrowseTax = undefined;
		oITFXBrowseTax	= oITFXBrowseTaxOption({
			'tTFXTaxBchCode'   		: $('#oetIFXBchCode00018').val(),
			'tTFXTaxWahCode'   		: $('#oetIFXWahCode00018').val(),
			'tTFXTaxPosCode'   		: $('#oetIFXPosCode00018').val(),
			'tTFXTaxType'			: $('#ocmITFXTaxType00018').val(),
			'tTFXTaxDocDateFrom'   	: $('#oetITFXDateFrom00018').val(),
			'tTFXTaxDocDateTo'   	: $('#oetITFXDateTo00018').val(),
			'tReturnInputCode'  	: 'oetITFXFromTax00018',
			'tReturnInputName'  	: 'oetITFXFromTax00018',
		});
		JCNxBrowseData('oITFXBrowseTax');
	});

	$('#obtITFXBrowseToTax00018').off('click').on('click',function(){
		window.oITFXBrowseTax = undefined;
		oITFXBrowseTax	= oITFXBrowseTaxOption({
			'tTFXTaxBchCode'   		: $('#oetIFXBchCode00018').val(),
			'tTFXTaxWahCode'   		: $('#oetIFXWahCode00018').val(),
			'tTFXTaxPosCode'   		: $('#oetIFXPosCode00018').val(),
			'tTFXTaxType'			: $('#ocmITFXTaxType00018').val(),
			'tTFXTaxDocDateFrom'   	: $('#oetITFXDateFrom00018').val(),
			'tTFXTaxDocDateTo'   	: $('#oetITFXDateTo00018').val(),
			'tReturnInputCode'  	: 'oetITFXToTax00018',
			'tReturnInputName'  	: 'oetITFXToTax00018',
		});
		JCNxBrowseData('oITFXBrowseTax');
	});

	var oITFXBrowseTaxOption = function(poReturnInput){
		// let tNextFuncName    = poReturnInput.tNextFuncName;
		// let aArgReturn       = poReturnInput.aArgReturn;
		let tInputReturnCode 		= poReturnInput.tReturnInputCode;
		let tInputReturnName 		= poReturnInput.tReturnInputName;

		let tTFXTaxBchCode  		= poReturnInput.tTFXTaxBchCode;
		let tTFXTaxWahCode  		= poReturnInput.tTFXTaxWahCode;
		let tTFXTaxPosCode  		= poReturnInput.tTFXTaxPosCode;
		let tTFXTaxType 	 		= poReturnInput.tTFXTaxType;

		let tTFXTaxDocDateFrom 		= poReturnInput.tTFXTaxDocDateFrom;
		let tTFXTaxDocDateTo 		= poReturnInput.tTFXTaxDocDateTo;

		var tUsrLevel     			= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
		var tSesUsrBchCodeDefault 	= "<?=$this->session->userdata("tSesUsrBchCodeDefault");?>";
		let tWhere		     		= "";
		
		if( tTFXTaxDocDateFrom == "" && tTFXTaxDocDateTo != "" ){
			tTFXTaxDocDateFrom = tTFXTaxDocDateTo;
		}

		if( tTFXTaxDocDateFrom != "" && tTFXTaxDocDateTo == "" ){
			tTFXTaxDocDateTo = tTFXTaxDocDateFrom;
		}

		if( tTFXTaxDocDateFrom != "" && tTFXTaxDocDateTo != "" ){
			tWhere += " AND (CONVERT(VARCHAR(10),TPSTTaxHD.FDXshDocDate,121) BETWEEN '"+tTFXTaxDocDateFrom+"' AND '"+tTFXTaxDocDateTo+"' OR CONVERT(VARCHAR(10),TPSTTaxHD.FDXshDocDate,121) BETWEEN '"+tTFXTaxDocDateTo+"' AND '"+tTFXTaxDocDateFrom+"') ";
		}

		if( tTFXTaxBchCode != "" ){ 												
			tWhere += " AND TPSTTaxHD.FTBchCode = '"+tTFXTaxBchCode+"' ";				// ดึงสาขาจาก Input ให้เลือกบนหน้าจอ
		}else{																			// ถ้าไม่เลือกสาขา
			if( tUsrLevel != "HQ" ){													// ถ้าไม่ใช่ HQ
				tWhere += " AND TPSTTaxHD.FTBchCode = '"+tSesUsrBchCodeDefault+"' ";  	// จะดึงสาขา Default มาแทน
			}																			// ถ้าเป็น HQ จะแสดงทุกสาขา
		}

		if( tTFXTaxWahCode != "" ){
			tWhere += " AND TPSTTaxHD.FTWahCode = '"+tTFXTaxWahCode+"' ";
		}

		if( tTFXTaxPosCode != "" ){
			tWhere += " AND TPSTTaxHD.FTPosCode = '"+tTFXTaxPosCode+"' ";
		}

		if( tTFXTaxType != "" ){
			tWhere += " AND TPSTTaxHD.FNXshDocType = "+tTFXTaxType+" ";
		}

		// var nLangEdits  = '<?php echo $this->session->userdata("tLangEdit");?>';
		let oOptionReturn    = {
			Title: ['interface/interfaceexport/interfaceexport','tITFXFilterTypeAbbTax'],
			Table: { Master:'TPSTTaxHD',PK:'FTXshDocNo' },
			Join: {
                Table: ['TPSTSalHD'],
                On:["TPSTSalHD.FTBchCode = TPSTTaxHD.FTBchCode AND TPSTSalHD.FTXshDocNo = TPSTTaxHD.FTXshRefExt"] /* AND TPSTTaxHD.FTXshStaDoc IN ('1','5') */
			},
			Where: {
				Condition: [ tWhere ]
			},
			GrideView:{
				ColumnPathLang	: 'interface/interfaceexport/interfaceexport',
				ColumnKeyLang	: ['tITFXSalDocNo','เลขที่อ้างอิงเอกสารภายนอก','tITFXSalDate'],
				// ColumnsSize     : ['30%','30%','30%','10%'],
				WidthModal      : 50,
				DataColumns		: ['TPSTTaxHD.FTXshDocNo','TPSTSalHD.FTXshRefExt','TPSTTaxHD.FDXshDocDate'],
				DataColumnsFormat : ['','','Date:0'],
				Perpage			: 10,
				OrderBy			: ['TPSTTaxHD.FDCreateOn DESC'],
			},
			CallBack:{
				ReturnType	: 'S',
				Value		: [tInputReturnCode,"TPSTTaxHD.FTXshDocNo"],
				Text		: [tInputReturnName,"TPSTTaxHD.FTXshDocNo"]
			},
			NextFunc : {
                FuncName    : 'JSxIFXTaxNextFunc',
                ArgReturn   : ["FTXshDocNo"]
            },
			// DebugSQL: true
		};
		return oOptionReturn;
	};

	function JSxIFXTaxNextFunc(poData){
		if( poData != "NULL" ){
			var paData     = JSON.parse(poData);
			var tDocNoTo   = $('#oetITFXToTax00018').val();
			var tDocNoFrom = $('#oetITFXFromTax00018').val();
			var tDocNoSelected = paData[0];

			if( tDocNoTo == "" ){
				$('#oetITFXToTax00018').val(tDocNoSelected);
			}else if( tDocNoFrom == "" ){
				$('#oetITFXFromTax00018').val(tDocNoSelected);
			}
		}
	}

</script>
