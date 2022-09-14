<?php 
if($aResult['rtCode'] == 1){
    $tRckCode   = $aResult['raItems']['rtRckCode'];
    $tRckName   = $aResult['raItems']['rtRckName'];
	$tRckRemark = $aResult['raItems']['rtRckRmk'];
	//Route
    $tRoute     = "SHPSmartLockerEventEdit";
}else{
    $tRckCode   = "";
    $tRckName   = "";
	$tRckRemark = "";
	//Route
    $tRoute     = "SHPSmartLockerEventAdd";
}

?>
<style>
    .NumberDuplicate{
        font-size   : 15px !important;
        color       : red;
        font-style  : italic;
    }

    .xCNSearchpadding{
        padding     : 0px 3px;
    }
</style>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" id="ofmAddRac">
	<div class="row">
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
			<label class="xCNLabelFrm" style="color: #179bfd !important; cursor:pointer;" onclick="JSxGetSHPContentRack();" ><?php echo language('company/rack/rack','tRckTitle')?></label>
			<label class="xCNLabelFrm">
			<label class="xCNLabelFrm xWPageAdd" style="color: #aba9a9 !important;"> / <?php echo language('company/rack/rack','tRacAdd')?> </label> 
			<label class="xCNLabelFrm xWPageEdit hidden" style="color: #aba9a9 !important;"> / <?php echo language('company/rack/rack','tRacEdit')?> </label>   
		</div>
		<!--ปุ่มเพิ่ม-->
		<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6  text-right">
			<button type="button" onclick="JSxGetSHPContentRack();" class="btn" style="background-color: #D4D4D4; color: #000000;">
				<?php echo language('company/rack/rack', 'tRacCancel')?>
			</button>
			<button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtGpShopBySHPSave" onclick="JSnAddEditRack('<?= $tRoute?>')"> <?php echo  language('common/main/main', 'tSave')?></button>
		</div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12"><hr></div>
	</div>
	<div class="row">
		<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 row">
			<!-- Add image -->
			<div class="col-lg-4 col-md-4 col-xs-4">
				<div class="upload-img" id="oImgUpload">
						<?php
							if(isset($tImgObjAll) && !empty($tImgObjAll)){
								$tFullPatch	= './application/modules/'.$tImgObjAll;
								if(file_exists($tFullPatch)){
									$tPatchImg	= base_url().'/application/modules/'.$tImgObjAll;
								}else{
									$tPatchImg	= base_url().'application/modules/common/assets/images/200x200.png';
								}
							}else{
								$tPatchImg	= base_url().'application/modules/common/assets/images/200x200.png';
							}
						?>      
						<img id="oimImgMasterRack" class="img-responsive xCNImgCenter" style="width: 100%;" id="" src="<?php echo @$tPatchImg;?>">
					</div>
					<div class="xCNUplodeImage">
						<input type="text" class="xCNHide" id="oetImgInputRackOld"	name="oetImgInputRackOld"	value="<?php echo @$tImgName;?>">
						<input type="text" class="xCNHide" id="oetImgInputRack"		name="oetImgInputRack" 		value="<?php echo @$tImgName;?>">
						<button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('','','Rack','4/4')">  <i class="fa fa-picture-o xCNImgButton"></i> <?php echo language('common/main/main','tSelectPic')?></button>
					</div>
			</div>

			<!-- End GenCode -->
			<div class="col-lg-6 col-md-6 col-xs-6">
				<div class="form-group">
				<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/rack/rack','tRacCode')?></label>
						<div id="odvRacAutoGenCode" class="form-group">
							<div class="validate-input">
								<label class="fancy-checkbox">
								<input type="checkbox" id="ocbRacAutoGenCode" name="ocbRacAutoGenCode" checked="true" value="1">
								<span> <?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
							</label>
						</div>
					</div>
					<div id="odvRacCodeForm" class="form-group">
						<input type="hidden" id="ohdCheckDuplicateRacCode" name="ohdCheckDuplicateRacCode" value="1"> 
							<div class="validate-input">
							<input 
								type="text" 
								class="form-control xCNInputWithoutSpcNotThai xCNInputWithoutSingleQuote" 
								maxlength="5" 
								id="oetRacCode" 
								name="oetRacCode"
								data-is-created="<?php echo $tRckCode; ?>"
								placeholder="<?php echo language('company/rack/rack','tRacCode')?>"
								value="<?php echo $tRckCode; ?>" 
								data-validate-required = "<?php echo language('company/rack/rack','tRacValidCode')?>"
								data-validate-dublicateCode = "<?php echo language('company/rack/rack','tRacValidCodeDup')?>"
							>
						</div>
					</div>
				
				<div class="form-group">
					<div class="validate-input">
						<label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('company/rack/rack','tRacName')?></label>
						<input
							type="text"
							class="form-control"
							maxlength="200"
							id="oetRacName"
							name="oetRacName"
							placeholder="<?php echo language('company/rack/rack','tRacName')?>"
							autocomplete="off"
							value="<?php echo $tRckName?>"
							data-validate-required="<?php echo language('company/rack/rack','tRacValidName')?>"
						>
					</div>
				</div>
				<div class="form-group">
				<label class="xCNLabelFrm"><?= language('company/rack/rack','tRacRemark')?></label>
							<textarea class="form-control" rows="4"  maxlength="100" id="otaRacRemark" name="oetRacRemark"><?php echo $tRckRemark?></textarea>
				</div>
				
			</div>
		</div>
	</div>
</form>

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include "script/jRackAdd.php"; ?>
