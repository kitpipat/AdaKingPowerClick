<div class="row">
	<div class="col-md-12">
		<label class="xCNLabelFrm"><label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tZone')?></label></label>
	</div>
</div>
<div style="margin-top:5px;">
	<div class="xCNModPanal" id="odvPkgZonePanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;margin-bottom:5px;">
		<div class="row">
			<div class="col-md-12 col-xs-12" style="background: #eeeeee;">
			<div class="col-md-1 col-xs-1 xCNRemovePadding" style="text-align:center;">
			<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Select')?></label>
			</div>	
			<div class="col-md-11 col-xs-11 xCNRemovePadding">
			<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tName')?></label>
		</div>
	</div>
</div>
	<?php if(isset($oZoneList[0]->FNZneID)): ?>
		<?php foreach ($oZoneList AS $aValue):?>
		<div class="row xCNRe xCNBKT<?= $aValue->FTZneBookingType ?>" style="padding: 2px;">
		
			<div class="col-md-12">
					<div class="col-md-1 col-xs-1 xCNRemovePadding" style="text-align:center;">
						<input type="checkbox" class="xWSelcectordZone" name="ordZone[]" data-zonetype="<?= $aValue->FTZneBookingType ?>" id="ordZone<?= $aValue->FNZneID ?>" data-bookingtype="<?= $aValue->FTZneBookingType ?>"  value="<?= $aValue->FNZneID ?>" >
					</div>	
					<div class="col-md-8 col-xs-8 xCNRemovePadding">
							 <?= $aValue->FTZneName ?> (<?= language('ticket/package/package', 'tPkg_PackageBookingType'.$aValue->FTZneBookingType)?>)
					</div>
					<div class="col-md-3 col-xs-3">
							 <input type="number" min="0" class="xCNZonePri" name="oetZonePri<?= $aValue->FNZneID ?>" id="oetZonePri<?= $aValue->FNZneID ?>" placeholder="<?= language('ticket/package/package', 'tPkg_Price')?>" style="display:none; width:100%;">
					</div>
			</div>
		</div>
		<?php endforeach; ?>
		<?php else:?>
				<div class="row">
					<div class="col-md-12 col-xs-12" style="text-align:center;">
							<p><?= language('ticket/package/package', 'tPkg_NoData')?></p>
					</div>
				</div>
	<?php endif;?>

</div>

<script>
	nHeight = $(window).height()-355;
	$('#odvPkgZonePanal').css('height',nHeight);

	//Select Zone ตาง Booking Type
	$('.xWSelcectordZone').change(function(){
		
		$(".xWSelcectordZone").toggle(this.checked);

		if($(".xWSelcectordZone").is(':checked')){
			nZoneID = this.value;
			nZoneBKT = $(this).data("bookingtype")
// 			alert(nZoneBKT+" "+nZoneID);
			$('.xCNRe').css('display','none');
			$('.xCNBKT'+nZoneBKT).css('display','block');
			$('.xWSelcectordZone').css('display','');

			nPkgType = $("#ohdPkgType").val();

			
// 			alert($('#ordZone'+nZoneID).val());
			if($('#ordZone'+nZoneID).is(':checked')){
				$('#ordZone'+nZoneID).prop('selected',true);
				$('#ordZone'+nZoneID).attr('selected',true);
				
				if(nPkgType == 2){
					$('#oetZonePri'+nZoneID).css('display','');
				}
			}else{
				$('#ordZone'+nZoneID).prop('selected',false);
				$('#ordZone'+nZoneID).attr('selected',false);
				$('#oetZonePri'+nZoneID).css('display','none');
			}
			
		}else{
			
			$('.xCNZonePri').css('display','none');
			$('.xCNRe').css('display','block');
			$('.xWSelcectordZone').css('display','');
			
		}
	});
</script>