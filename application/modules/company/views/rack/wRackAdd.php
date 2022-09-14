<?php 
if($aResult['rtCode'] == 1){
    $tRckCode   = $aResult['raItems']['rtRckCode'];
    $tRckName   = $aResult['raItems']['rtRckName'];
	$tRckRemark = $aResult['raItems']['rtRckRmk'];
	//Route
    $tRoute     = "rackEventEdit";
}else{
    $tRckCode   = "";
    $tRckName   = "";
	$tRckRemark = "";
	//Route
    $tRoute     = "rackEventAdd";
}

?>
<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddRac">
<button style="display:none" type="submit" id="obtSubmitRack" onclick="JSnAddEditRack('<?php echo $tRoute?>')"></button>
	<div class="panel-body"  style="padding-top:20px !important;">
		<div class="row">
			<div class="col-xs-4 col-md-4 col-lg-4"> 
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
			<div class="col-xs-8 col-md-8 col-lg-8">
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
