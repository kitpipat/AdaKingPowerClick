
<?php


if($aResult['rtCode']=='1'){
	$tRoute = "customerBuyLicEventEdit";
	$tCbrRefBch =	$aResult['raItems']['rtCbrRefBch'];
	$tCbrRefPos =	$aResult['raItems']['rtCbrRefPos'];
	$nLicUUIDSeq =	$aResult['raItems']['rnLicUUIDSeq'];
	$tLicPdtCode =	$aResult['raItems']['rtLicPdtCode'];
	$tPdtName =	$aResult['raItems']['rtPdtName'];
	$tPtyName =	$aResult['raItems']['rtPtyName'];
	$tPtyCode =	$aResult['raItems']['rtPtyCode'];
	$tLicRefSaleDoc = $aResult['raItems']['rtLicRefSaleDoc'];
	$nMonth =	$aResult['raItems']['rnMonth'];
	$dLicStart =	$aResult['raItems']['rdLicStart'];
	$dLicFinish =	$aResult['raItems']['rdLicFinish'];
	$tRegStaActive =	$aResult['raItems']['rtRegStaActive'];
	$nLicStaUse =	$aResult['raItems']['rtLicStaUse'];
	$tLicRefUUID =	$aResult['raItems']['rtLicRefUUID'];
	$tPageEvent =	language('customerlicense/customerlicense/customerlicense','tCLBPageEdit');
}else{

	$tRoute = "customerBuyLicEventAdd";
	$tCbrRefBch =	'';
	$tCbrRefPos =   '';
	$nLicUUIDSeq =  '';
	$tLicPdtCode =	'';
	$tPdtName =	'';
	$tPtyName =	'';
	$tPtyCode =  '';
	$tLicRefSaleDoc =	'';
	$nMonth =	'';
	$dLicStart =	'';
	$dLicFinish =	'';
	$tRegStaActive =	'';
	$nLicStaUse = '';
	$tLicRefUUID =	'';
	$tPageEvent =	language('customerlicense/customerlicense/customerlicense','tCLBPageAdd');
}

if($tPtyCode=='00003'){
	$tDisplay="";
}else{
	$tDisplay="none";
}
?>
<style>
.select-group input.form-control{ width: 65%}
.select-group select.input-group-addon { width: 35%; }
</style>
<input type="hidden" name="ohdCbrRefBch" id="ohdCbrRefBch" value="<?=$tCbrRefBch?>" >
<input type="hidden" name="ohdLicUUIDSeq" id="ohdLicUUIDSeq" value="<?=$nLicUUIDSeq?>" >
<input type="hidden" name="ohdCbrRouteBuyLic" id="ohdCbrRouteBuyLic" value="<?=$tRoute?>" >
<div class="">
    <div class="">

		<div class="row">
			<div class="col-xs-6 col-md-6 col-lg-6">
					<span class="xCNLinkClick" onclick="JSvCBLCstBuyLicGetPageList();" ><b><?php echo language('customerlicense/customerlicense/customerlicense','tCLNCstLicenseTitle')?></b></span> / <?=$tPageEvent?>
			</div>
			<div class="col-xs-6 col-md-6 col-lg-6">
					<button type="button" class="btn btn-default" onclick="JSvCBLCstBuyLicGetPageList();" >ยกเลิก</button>  <button type="button" class="btn btn-primary" onclick="JSxCBLCstBuyLicAddUpdateEvent()" >บันทึก</button>
			</div>
		</div>
        <div class="row">

			<div class="col-xs-8 col-md-6 col-lg-6">

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCBLPdtCode')?></label>
						<input type="text" name="oetLicPdtCode" id="oetLicPdtCode" class="form-control"  maxlength="5" autocomplete="off" readonly value="<?=$tLicPdtCode?>">
				</div>

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCBLPdtName')?></label>
				
						<input type="text" name="oetPdtName" id="oetPdtName" autocomplete="off" class="form-control" readonly value="<?=$tPdtName?>">
					
				</div>
	

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCBLPdtType')?></label>
				
						<input type="text" name="oetPtyName" id="oetPtyName" autocomplete="off" class="form-control" readonly value="<?=$tPtyName?>">
					
				</div>

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCBLTLiveTime')?></label>
					<div class="input-group"> 
						<input type="number" name="oenMonth" id="oenMonth" autocomplete="off" class="form-control" readonly value="<?=$nMonth?>">
						<span class="input-group-addon"><?= language('customerlicense/customerlicense/customerlicense','tCBLMonth')?></span>
					</div>

				</div>

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCBLSaleDocNo')?></label>
						<input type="text" name="oetLicRefSaleDoc" id="oetLicRefSaleDoc" class="form-control" readonly value="<?=$tLicRefSaleDoc?>">
				</div>


				<div class="form-group">
						<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense', 'tCBLStratDate'); ?></label>
						<div class="input-group">
							<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oedLicStart" name="oedLicStart" autocomplete="off" value="<?= $dLicStart; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDocDate'); ?>">
							<span class="input-group-btn">
							<button id="otbLicStart" type="button" class="btn xCNBtnDateTime">
								<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
							</button>
						</span>
					</div>
				</div>

				<div class="form-group">
						<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense', 'tCBLEndDate'); ?></label>
						<div class="input-group">
							<input type="text" class="form-control xCNDatePicker xCNInputMaskDate" id="oedLicFinish" name="oedLicFinish" autocomplete="off" value="<?= $dLicFinish; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tSpaValidXphDocDate'); ?>">
							<span class="input-group-btn">
								<button id="obtLicFinish" type="button" class="btn xCNBtnDateTime">
									<img src="<?= base_url() . '/application/modules/common/assets/images/icons/icons8-Calendar-100.png' ?>">
								</button>
							</span>
					</div>
				</div>

				<div class="form-group"  style="display:<?=$tDisplay?>">
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense', 'tCLBCstBchCode'); ?></label>
						<div class="input-group select-group" style="width: 100%;">
							<input type="text" class="form-control" id="oetCbrRefBch" name="oetCbrRefBch" maxlength='5' autocomplete="off" value="<?= $tCbrRefBch; ?>" data-validate="<?= language('customerlicense/customerlicense/customerlicense', 'tCLBCstBchCodeValidate'); ?>">
									<select class="form-control input-group-addon" id="ocmCbrRefBc">
									   <option value=""><?= language('customerlicense/customerlicense/customerlicense', 'tCBLBchCustomize'); ?></option>
										<?php
											if($oReusltBranch['rtCode']=='1'){
												foreach($oReusltBranch['roItem'] as $nKey => $aDataBranch){
										?>
										<option value="<?=$aDataBranch['rtBchCode']?>" <?php  if($tCbrRefBch==$aDataBranch['rtBchCode']){ echo 'selected'; } ?>><?='('.$aDataBranch['rtBchCode'].') '.$aDataBranch['rtBchName']?></option>
											<?php } 
													}  ?>
													
									</select>
						</div>
				</div>

				<div class="form-group"  style="display:<?=$tDisplay?>">
						<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense', 'tCLBCstPosCode'); ?></label>
						<input type="text" class="form-control" id="oetCbrRefPos" name="oetCbrRefPos" maxlength='5' autocomplete="off" value="<?= $tCbrRefPos; ?>" readonly data-validate="<?= language('customerlicense/customerlicense/customerlicense', 'tCLBCstPosCodeValidate'); ?>">
				</div>

				<div class="form-group"  style="display:<?=$tDisplay?>">
						<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense', 'tCBLUUID'); ?></label>
						<div class="input-group">
							<input type="text" class="form-control" id="oetLicRefUUID" name="oetLicRefUUID" autocomplete="off" value="<?= $tLicRefUUID; ?>" data-validate="<?= language('document/salepriceadj/salepriceadj', 'tCLBUUIDCodeValidate'); ?>">
							<span class="input-group-btn">
							<button id="obtPosActivate" type="button" class="btn btn-success">
								Activate
							</button>
						</span>
					</div>
				</div>

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCBLStatus')?></label>
					<select name="ocmLicStaUse" id="ocmLicStaUse"   class="form-control">
						<option value="1" <?php if($nLicStaUse==1){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tCBLStatus1')?></option>
						<option value="2" <?php if($nLicStaUse==2){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tCBLStatus2')?></option>
					</select>
				</div>



			</div>



		</div>
    </div>
</div>

<?php Include 'script/jCstScriptBuyLicPageForm.php'; ?>
