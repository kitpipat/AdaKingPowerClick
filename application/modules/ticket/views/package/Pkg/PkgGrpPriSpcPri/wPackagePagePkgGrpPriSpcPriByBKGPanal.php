<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<div class="row xWPKGSearchPanal" style="margin-top: 8px;">
	<form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPKGGrpPriBooking">
			<input type="text" class="hidden" name="oetHidePkgID" id="oetHidePkgID" value="<?=$nPkgID?>">
			<input type="text" class="hidden" name="oetHidePgpGrpID" id="oetHidePgpGrpID" value="<?=$nPgpGrpID?>">

			<div class="col-md-2">
					<div class="form-group">
						<input type="text" class="form-control" name="oetGpbDayFrm" id="oetGpbDayFrm" placeholder="<?= language('ticket/package/package', 'tPkg_From')?>">
					</div>
			</div>
			<div class="col-md-2">
					<div class="form-group">
						<input type="text" class="form-control" name="oetGpbDayTo" id="oetGpbDayTo" placeholder="<?= language('ticket/package/package', 'tPkg_To')?>">
					</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<select class="selectpicker form-control" name="ocmGpbSign" id="ocmGpbSign">
						<option value="1"><?= language('ticket/package/package', 'tPkg_PackagePphSign1')?></option>
						<option value="-1"><?= language('ticket/package/package', 'tPkg_PackagePphSign-1')?></option>
					</select>
				</div>
			</div>
			<div class="col-md-3">
				<div class="form-group">
						<select class="selectpicker form-control" name="ocmGpbAdjType" id="ocmGpbAdjType">
							<option value=""><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice')?></option>
							<option value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
							<option value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
							<option value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
						</select>
				</div>

				
			</div>
			<div class="col-md-2">
					<div class="form-group">
						<input type="number" class="form-control" name="oetGpbValue" id="oetGpbValue" placeholder="<?= language('ticket/package/package', 'tPkg_Value')?>">
					</div>
			</div>
			<div class="col-md-1 text-right">
				<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxBtnAddPKGGrpPriBooking();" style="margin-top:-3px;">+</button>
			</div>
	</form>
</div>
<div class="row">
	<div class="col-lg-12 xWpage-body">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div style="margin-top:10px;">
					<div class="xCNPdtPanal" id="odvPkgProductPanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238);border-width: 2px;">
						<table  class="table table-hover">
							<thead>
								<tr>
									<th><?= language('ticket/package/package', 'tPkg_TblNo')?></th>
									<th><?= language('ticket/package/package', 'tPkg_From')?></th>
									<th><?= language('ticket/package/package', 'tPkg_To')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Sign')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Condition')?></th>
									<th><?= language('ticket/package/package', 'tPkg_TblPrice')?></th>
									<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
									<th><?= language('ticket/user/user', 'tDelete') ?></th>
									<th><?= language('ticket/user/user', 'tEdit') ?></th>
									<?php endif; ?>
								</tr>
							</thead>
							<?php if(isset($oGrpPriBKG[0]->FNPgpGrpID)):?>
							<?php foreach ($oGrpPriBKG AS $aValue):?>
								<tr onclick="JSxPkgEditClickGrpPriBKGTR('<?= $aValue->RowID ?>');">
									<td class="xWRmLine"><?= $aValue->RowID ?></td>
									<td class="xWRmLine"><span id="ospGpbDayFrm<?= $aValue->RowID ?>"><?= $aValue->FNGpbDayFrm ?></span></td>
									<td class="xWRmLine"><span id="ospGpbDayTo<?= $aValue->RowID ?>"><?= $aValue->FNGpbDayTo ?></span></td>
									<td class="xWRmLine"><span id="ospGpbSign<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_Sign'.$aValue->FNGpbSign)?></span></td>
									<td class="xWRmLine">
										<span class="xWGpbShow" id="ospGpbAdjType<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_PackageAdjType'.$aValue->FTGpbAdjType)?></span>
										<input class="hidden" id="ohdGpbAdjType<?= $aValue->RowID ?>" value="<?= $aValue->FTGpbAdjType ?>">
										<div class="xWoet" style="display:none;">
											<select class="selectpicker form-control input-valid xWEditPkgAdjType" name="ocmEditGpbAdjType<?= $aValue->RowID ?>" id="ocmEditGpbAdjType<?= $aValue->RowID ?>">
												<option value=""><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice')?></option>
				                           		<option class="xWEdtGpbAdjType1" value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
				                           		<option class="xWEdtGpbAdjType2" value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
				                           		<option class="xWEdtGpbAdjType3" value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
											</select>
										</div>
									</td>
									<td class="xWRmLine"><span class="xWGpbShow" id="ospGpbValue<?= $aValue->RowID ?>"><?= $aValue->FCGpbValue ?></span> <input type="text" class="form-control xWoet xWoetGpbValue" id="oetGpbValue<?= $aValue->RowID ?>" value="<?= $aValue->FCGpbValue ?>" style="display:none;width: 80px;"></td>
									<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
										<td class="xWRmLine text-center" >
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxPkgDelGrpPriBKG('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')">
										</td>
										<td class="xWRmLine text-center xWEditBtn " id="othEditPdtBtn<?= $aValue->RowID ?>" >
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxPkgEditGrpPriBKGBtn('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')">
										</td>
										<td class="xWRmLine text-center xWSaveBtn" id="othSavePdtBtn<?= $aValue->RowID ?>"  style="display:none;">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/save.png" onclick="JSxPkgSaveGrpPriBKG('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')">
										</td>
									<?php endif; ?>
								</tr>
							<?php endforeach;?>
							<?php else :?>
							<tbody>
								<tr>
									<td colspan="8" style="text-align:center;"><?= language('ticket/package/package', 'tPkg_NoReservation')?></td>
								</tr>
							</tbody>
							<?php endif;?>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>

	$('.selectpicker').selectpicker();

	nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();
	if(nStaPrcDoc != ''){
		nHeight = $(window).height()-590;
		$('#odvPkgProductPanal').css('height',nHeight)
		$('.xWPKGSearchPanal').css('display','none');
	}else{
		nHeight = $(window).height()-686;
		$('#odvPkgProductPanal').css('height',nHeight);
		$('.xWPKGSearchPanal').css('display','block');
	}

	
	$('#ocmPkgTchGroup').change(function(){
		nTchID = this.value;
		JSxPkgCstGetSelectPdtHTML(nTchID);
	});

	
	$('.xWEditGpbAdjType').change(function(){
		nGpbAdjType = this.value;
		if(nGpbAdjType != ''){
			$('.xWEditGpbAdjType').removeClass('input-invalid');
		}
	});
	
	$('.xWoetGpbValue').change(function(){
		nGpbValue = this.value;
		if(nGpbValue != ''){
			$('.xWoetGpbValue').removeClass('input-invalid');
		}
	});

	
	
</script>
