<script>
$(function () {
	$("#xWEditHome").validate({
        rules: {
            oetFTRomName: "required",
            oetFTRomSeqNo: "required",
            onbFNRomQtyBRoom: "required",
            onbFNRomQtyTRoom: "required",
            onbFNRomMaxPerson: "required",
            ocmFTRomStaAlw: "required",
        },
        messages: {
            oetFTRomName: "",
            oetFTRomSeqNo: "",
            onbFNRomQtyBRoom: "",
            onbFNRomQtyTRoom: "",
            onbFNRomMaxPerson: "",
            ocmFTRomStaAlw: "",
        },
        errorClass: "input-invalid",
        validClass: "input-valid",
        highlight: function (element, errorClass, validClass) {
            $(element).addClass(errorClass).removeClass(validClass);
            $(element).parent().addClass('focused');
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).removeClass(errorClass).addClass(validClass);
        },
        submitHandler: function (form) {
        	$('button[type=submit]').attr('disabled', true);
                $('.xCNOverlay').show();
            $.ajax({
                type: "POST",
                url: "<?php echo base_url(); ?>EditRoomAjax",
                data: $("#xWEditHome").serialize(),
                cache: false,
                success: function (msg) {
                	JSxCallPage('<?= base_url() ?>Room/<?= $oEdit[0]->FNLocID ?>/<?= $oEdit[0]->FNZneID ?>');
                        $('.xCNOverlay').hide();
                },
                error: function (data) {
                    console.log(data);
                    $('.xCNOverlay').hide();
                }
            });
            return false;
        }
    });
	$('[title]').tooltip();
});
</script>
<div class="row">
	<div class="col-md-12">
		<h4>
			<?= language('ticket/room/room', 'tRoom') ?> / <?= language('ticket/room/room', 'tEditRoom') ?>
		</h4>
	</div>
</div>
<form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="xWEditHome" novalidate="novalidate">
		<div class="row">
			<div class="col-md-4 col-sm-4 col-xs-12">		
				<div class="upload-img" id="oImgUpload" style="margin-bottom: 10px;">

					<?php if ($oEdit[0]->FTImgObj != ""):  ?>
						<a href="javascript:void(0)" id="oDelImgRoom" onclick="JSxROMDelImg('<?= $oEdit[0]->FNImgID ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>					
						<img src="<?=base_url()?><?php echo $oEdit[0]->FTImgObj;?>" style="width: 100%;" id="oImageThumbnail">
					<?php else : ?>
						<img src="<?php echo base_url('application/modules/common/assets/images/5,3.png');?>" style="width: 100%;" id="oImageThumbnail">
					<?php endif; ?>

					<span class="btn-file"> 
						<img src="<?php echo base_url('application/modules/common/assets/icons/icons8-Camera.png');?>" style="width: 24px;">				
						<input type="file" accept="image/*" id="ofilePhotoAdd" onchange="FCNCropper(this, 5 / 3);"> 
						<input type="hidden" name="ohdRoomImg" id="ohdPhotoAdd">
					</span>
					<div class="text-center" style="margin-top: -30px;">
						<span><?= language('ticket/about/about', 'tImage') ?></span>
					</div>
				</div>
			</div>
			<div class="col-md-8 col-sm-4 col-xs-12">
				<input type="hidden" name="ohdRomID" value="<?= $oEdit[0]->FNRomID ?>">
				<input type="hidden" name="ohdFNPdtID" value="<?= $oEdit[0]->FNPdtID ?>">
				<div class="form-group">
					<input type="text" class="form-control" name="oetFTRomName" value="<?= $oEdit[0]->FTRomName ?>" placeholder="<?= language('ticket/room/room', 'tRoomName') ?>" id="oetFTRomNameAdd">
	            </div>
	            <div class="form-group">
					<select class="form-control" name="ocmFNTcgID" id="ocmFNTcgID" title="<?= language('ticket/room/room', 'tSelectGroup') ?>">
	                	<option value=""><?= language('ticket/room/room', 'tSelectGroup') ?></option>
	                	<?php  foreach ($oTcg as $key => $tValue) : ?>
							<option value="<?= $tValue->FNTcgID ?>"<?php if($tValue->FNTcgID == $oEdit[0]->FNTcgID){ echo ' selected="selected"'; } ?>><?= $tValue->FTTcgName ?></option>
						<?php  endforeach; ?>
	                </select>
	            </div>
	            <div class="form-group">
					<select class="form-control" name="ocmFNLevID" id="ocmFNLevID" title="<?= language('ticket/zone/zone', 'tSelectlevel') ?>">
	                	<option value=""><?= language('ticket/zone/zone', 'tSelectlevel') ?></option>
	                	<?php  foreach ($oLev as $key => $tValue) : ?>
							<option value="<?= $tValue->FNLevID ?>" <?php if ($oEdit[0]->FNLevID == $tValue->FNLevID) {echo 'selected="selected"';} ?>><?= $tValue->FTLevName ?></option>
						<?php  endforeach; ?>
	                </select>
	            </div>      
	            <div class="form-group">
					<input type="text" class="form-control" name="oetFTRomLatitude" value="<?= $oEdit[0]->FTRomLatitude ?>" placeholder="Latitude" title="Latitude" id="oetFTRomLatitude">
	            </div>	            
	            <div class="form-group">
					<input type="text" class="form-control" name="oetFTRomLongitude" value="<?= $oEdit[0]->FTRomLongitude ?>" placeholder="Longitude" title="Longitude" id="oetFTRomLongitude">
	            </div>	            
	            <div class="form-group">
					<input type="text" class="form-control" name="oetFTRomSeqNo" value="<?= $oEdit[0]->FTRomSeqNo ?>" placeholder="<?= language('ticket/room/room', 'tNumber') ?>" title="<?= language('ticket/room/room', 'tNumber') ?>" id="oetFTRomSeqNo">
	            </div>	            
	            <div class="form-group">
					<input type="number" min="0" class="form-control" name="onbFNRomQtyBRoom" value="<?= $oEdit[0]->FNRomQtyBRoom ?>" placeholder="<?= language('ticket/room/room', 'tAmountBedrooms') ?>" title="<?= language('ticket/room/room', 'tAmountBedrooms') ?>" id="onbFNRomQtyBRoom">
	            </div>
	            <div class="form-group">
					<input type="number" min="0" class="form-control" name="onbFNRomQtyTRoom" value="<?= $oEdit[0]->FNRomQtyTRoom ?>" placeholder="<?= language('ticket/room/room', 'tAmountBathrooms') ?>" title="<?= language('ticket/room/room', 'tAmountBathrooms') ?>" id="onbFNRomQtyTRoom">
	            </div>
	            <div class="form-group">
					<input type="number" min="0" class="form-control" name="onbFNRomMaxPerson" value="<?= $oEdit[0]->FNRomMaxPerson ?>" placeholder="<?= language('ticket/room/room', 'tAmount') ?>" title="<?= language('ticket/room/room', 'tAmount') ?>" id="onbFNRomMaxPerson">
	            </div>
	            <div class="form-group">
					<input type="number" min="0" class="form-control" name="onbFNRomMinDayBook" value="<?= $oEdit[0]->FNRomMinDayBook ?>" placeholder="<?= language('ticket/room/room', 'tMinimumBookingDays') ?>" title="<?= language('ticket/room/room', 'tMinimumBookingDays') ?>" id="onbFNRomMinDayBook">
	            </div>
	            <div class="form-group">
					<input type="number" min="0" class="form-control" name="onbFNRomDayBooking" value="<?= $oEdit[0]->FNRomDayBooking ?>" placeholder="<?= language('ticket/room/room', 'tMaximumBookingDays') ?>" title="<?= language('ticket/room/room', 'tMaximumBookingDays') ?>" id="onbFNRomDayBooking">
	            </div>
	            <div class="form-group">
					<input type="number" min="0" class="form-control" name="onbFNRomDayPreBooking" value="<?= $oEdit[0]->FNRomDayPreBooking ?>" placeholder="<?= language('ticket/room/room', 'tAdvanceBookingDays') ?>" title="<?= language('ticket/room/room', 'tAdvanceBookingDays') ?>" id="onbFNRomDayPreBooking">
	            </div>
	            <div class="form-group">
	            	<textarea class="form-control" placeholder="<?= language('ticket/room/room', 'tFacilities') ?>" title="<?= language('ticket/room/room', 'tFacilities') ?>" name="otaFTRomFacility"><?= $oEdit[0]->FTRomFacility ?></textarea>
	            </div>
	            <div class="form-group">
	            	<select class="form-control" name="ocmFTRomStaAlw" id="ocmFTRomStaAlw" title="<?= language('ticket/room/room', 'tSelectStatus') ?>">
	                	<option value="" <?php if ($oEdit[0]->FTRomStaAlw == ""){echo "selected";} ?>><?= language('ticket/room/room', 'tSelectStatus') ?></option>
	                	<option value="1" <?php if ($oEdit[0]->FTRomStaAlw == "1"){echo "selected";} ?>><?= language('ticket/room/room', 'tOpening') ?></option>
	                	<option value="3" <?php if ($oEdit[0]->FTRomStaAlw == "3"){echo "selected";} ?>><?= language('ticket/room/room', 'tWasteRepair') ?></option>
	                </select>
	            </div>       
	            <div class="form-group">
	            	<label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTRomStaAir" type="checkbox" <?php if ($oEdit[0]->FTRomStaAir == "1"){echo "checked";} ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tAirConditioning') ?></label>
	            </div>
	            <div class="form-group">
	            	<label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTRomStaFan" type="checkbox" <?php if ($oEdit[0]->FTRomStaFan == "1"){echo "checked";} ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tFan') ?></label>
	            </div>
	            <div class="form-group">
	            	<label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTRomStaHeater" type="checkbox" <?php if ($oEdit[0]->FTRomStaHeater == "1"){echo "checked";} ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tWaterHeater') ?></label>
	            </div>
	            <div class="form-group">
	            	<label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTRomStaWifi" type="checkbox" <?php if ($oEdit[0]->FTRomStaWifi == "1"){echo "checked";} ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tWifi') ?></label>
	            </div>
	            <div class="form-group">
	            	<label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTRomStaBreakfast" type="checkbox" <?php if ($oEdit[0]->FTRomStaBreakfast == "1"){echo "checked";} ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tBreakfast') ?></label>
	            </div>
	            <div class="form-group">
	            	<label style="font-weight: normal; margin-bottom: 0;"><input value="1" name="ocbFTRomStaAlwAddBed" type="checkbox" <?php if ($oEdit[0]->FTRomStaAlwAddBed == "1"){echo "checked";} ?> style="float: left; margin-right: 5px;"> <?= language('ticket/room/room', 'tExtraBedAllowed') ?></label>
	            </div>	            
	            <div class="form-group">
	            	<textarea class="form-control" name="otaFTRomRemark" placeholder="<?= language('ticket/zone/zone', 'tRemarks') ?>" title="<?= language('ticket/zone/zone', 'tRemarks') ?>"><?= $oEdit[0]->FTRomRemark ?></textarea>
	            </div>
			</div>
		</div>
		<hr>
		<div>
			<div class="pull-right" style="margin-bottom: 10px;">
				<button type="button" onclick="JSxCallPage('<?= base_url() ?>Room/<?= $oEdit[0]->FNLocID ?>/<?= $oEdit[0]->FNZneID ?>');" class="btn btn btn-default"><?= language('ticket/user/user', 'tCancel') ?></button>
				<button type="submit" class="btn btn-outline-primary"><?= language('ticket/user/user', 'tSave') ?></button>			
			</div>
		</div>
</form> 