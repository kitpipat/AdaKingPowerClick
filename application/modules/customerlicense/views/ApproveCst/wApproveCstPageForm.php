
<?php


if($aResult['rtCode']=='1'){
	$tRoute = "ApproveCstEventEdit";
	$rnRegID =	$aResult['raItems']['FNRegID'];
	$rtRegBusName =	$aResult['raItems']['FTRegBusName'];
	$rnRegQtyBch =	$aResult['raItems']['FNRegQtyBch'];
	$rtRegLicGroup =	$aResult['raItems']['FTRegLicGroup'];
	$rtRegLicType = $aResult['raItems']['FTRegLicType'];
	$rtRegBusOth =	$aResult['raItems']['FTRegBusOth'];
	$rtRegRefCst =	$aResult['raItems']['FTRegRefCst'];
	$rtRegStaConfirm =	$aResult['raItems']['FTRegStaConfirm'];
	$rtRegStaActive =	$aResult['raItems']['FTRegStaActive'];

	$rtRegEmail   =	$aResult['raItems']['FTRegEmail'];
	$rtRegTel     =	$aResult['raItems']['FTRegTel'];

	$tPageEvent =	language('customerlicense/customerlicense/customerlicense','tCLBPageEdit');


}else{

	$tRoute = "ApproveCstEventAdd";
	$rnRegID =	'';
	$rtRegBusName =	'';
	$rnRegQtyBch =	'';
	$rtRegLicGroup ='';
	$rtRegLicType = '';;
	$rtRegBusOth =	'';
	$rtRegRefCst =	'';
	$rtRegStaConfirm =	'';
	$rtRegStaActive =	'';

	$rtRegEmail   =	'';
	$rtRegTel     =	'';

	$tPageEvent =	language('customerlicense/customerlicense/customerlicense','tCLBPageAdd');
}

?>
<input type="hidden" name="ohdRegID" id="ohdRegID" value="<?=$rnRegID?>" >
<input type="hidden" name="ohdRegRoute" id="ohdRegRoute" value="<?=$tRoute?>" >
<div class="panel panel-headline">
    <div class="panel-body" style="padding-top:20px !important;">
	<!-- <div class="col-xs-12 col-md-12 text-right p-r-0">
				<a id="obtAPCApproveCstExportJson" class="btn btn-info"  href="<?=base_url('ApproveCstExportJson?nRegID='.$rnRegID)?>" ><?php echo language('customerlicense/customerlicense/customerlicense', 'tAPCRegExportJson'); ?></a>             
		</div> -->
        <div class="col-xl-12 col-lg-12 col-md-12" id="odvContentContainer">
        <div class="row">

			<div class="col-xs-8 col-md-6 col-lg-6">

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegBusName')?></label>
						<input type="text" name="oetRegBusName" id="oetRegBusName" class="form-control"  maxlength="255" autocomplete="off" readnly value="<?=$rtRegBusName?>">
				</div>

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegQtyBch')?></label>
				
						<input type="number" name="oenRegQtyBch" id="oenRegQtyBch" autocomplete="off" class="form-control"  value="<?=$rnRegQtyBch?>">
					
				</div>
	

				<!-- <div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup')?></label>
				
						<select class="form-control" name="ocmRegLicGroup" id="ocmRegLicGroup" >
						    <option value="" ></option> 
							<option value="00001" <?php if($rtRegLicGroup=='00001'){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup00001')?></option> 
							<option value="00002" <?php if($rtRegLicGroup=='00002'){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup00002')?></option> 
							<option value="00003" <?php if($rtRegLicGroup=='00003'){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup00003')?></option>
							<option value="00004" <?php if($rtRegLicGroup=='00004'){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicGroup00004')?></option>  
						</select>
					
				</div> -->

				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicType')?></label>
					<select class="form-control" name="ocmRegLicType" id="ocmRegLicType" >
							<option value="1" <?php if($rtRegLicType=='1'){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicType1')?></option> 
							<option value="2" <?php if($rtRegLicType=='2'){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tAPCRegLicType2')?></option> 
						</select>

				</div>

				
				<div class="form-group" > 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegBusType')?></label>
						<input type="text" name="oetRegBusOth" id="oetRegBusOth" class="form-control"  value="<?=$rtRegBusOth?>">
				</div>

				<div class="form-group" > 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegRefCst')?></label>
						<input type="text" name="oetRegRefCst" id="oetRegRefCst" class="form-control"  value="<?=$rtRegRefCst?>">
				</div>
				


				<div class="form-group" > 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCSTEmail')?></label>
						<input type="text" name="oetRegEmail" id="oetRegEmail" class="form-control"  value="<?=$rtRegEmail?>">
				</div>


				<div class="form-group" > 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tCSTTel')?></label>
						<input type="text" name="oetRegTel" id="oetRegTel" class="form-control"  value="<?=$rtRegTel?>">
				</div>


				<div class="form-group"> 
					<label class="xCNLabelFrm"><?= language('customerlicense/customerlicense/customerlicense','tAPCRegStaActive')?></label>
					<select name="ocmRegStaActive" id="ocmRegStaActive"   class="form-control">
						<option value="1" <?php if($rtRegStaActive==1){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tRegStaActive1')?></option>
						<option value="2" <?php if($rtRegStaActive==2){ echo 'selected'; } ?>><?= language('customerlicense/customerlicense/customerlicense','tRegStaActive2')?></option>
					</select>
				</div>



			</div>



		</div>
    </div>
</div>
</div>
</div>
<?php Include 'script/jApproveCstPageForm.php'; ?>
