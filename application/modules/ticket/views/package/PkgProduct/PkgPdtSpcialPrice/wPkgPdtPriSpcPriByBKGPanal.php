<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<?php if($oPkgDetail[0]->FTPkgStaPrcDoc != '1'):?>
<div class="row">
	<div class="col-lg-12 xCNBCMenu">
			<form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPKGPdtPriBooking">
				<input type="text" class="hidden" name="oetHidePkgID" id="oetHidePkgID" value="<?=$nPkgID?>">
				<input type="text" class="hidden" name="oetHidePkgPdtID" id="oetHidePkgPdtID" value="<?=$nPkgPdtID?>">
				<div class="row">
					<div class="col-md-2">
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_From') ?></label>
							<input class="form-control" type="number" name="oetPpbDayFrm" id="oetPpbDayFrm">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_To') ?></label>
							<input class="form-control" type="number" name="oetPpbDayTo" id="oetPpbDayTo">
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="xCNLabelFrm">ประเภท</label>
							<select class="selectpicker form-control input-valid" name="ocmPpbSign" id="ocmPpbSign">
								<option value="1"><?= language('ticket/package/package', 'tPkg_PackagePphSign1')?></option>
								<option value="-1"><?= language('ticket/package/package', 'tPkg_PackagePphSign-1')?></option>
							</select>
						</div>
					</div>
					<div class="col-md-3">
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice') ?></label>
							<select class="selectpicker form-control input-valid" name="ocmPpbAdjType" id="ocmPpbAdjType">
								<option value=""><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice')?></option>
								<option value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
								<option value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
								<option value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
							</select>
						</div>
					</div>
					<div class="col-md-2">
						<div class="form-group">
							<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Value') ?></label>
							<input class="form-control" type="number" name="oetPpbValue" id="oetPpbValue">
						</div>
					</div>
					<div class="col-md-1 text-right">
						<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxBtnAddPKGPdtPriBooking();" style="margin-top:25px;">+</button>
					</div>
				</div>
		</form>
	</div>
</div>
<?php endif; ?>
<div class="row">
	<div class="col-lg-12 xWpage-body">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div class="xCNPdtPanal" id="odvPkgPdtPriBKGPanal" style="">
					<table  class="table table-hover">
						<thead>
							<tr>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_TblNo')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_From')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_To')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_Sign')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_Condition')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_Price')?></th>
								<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
									<th class="text-center"><?= language('ticket/package/package', 'tPkg_Delete')?></th>
									<th class="text-center"><?= language('ticket/package/package', 'tPkg_Edit')?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<?php if(isset($oPdtPriBKG[0]->FNPkgPdtID)):?>
							<?php foreach ($oPdtPriBKG AS $aValue):?>
								<tr onclick="JSxPkgEditClickPdtPriBKGTR('<?= $aValue->RowID ?>');">
									<td class="xWRmLine"><?= $aValue->RowID ?></td>
									<td class="xWRmLine"><span id="ospPdtDayFrm<?= $aValue->RowID ?>"><?= $aValue->FNPpbDayFrm ?></span></td>
									<td class="xWRmLine"><span id="ospPdtDayTo<?= $aValue->RowID ?>"><?= $aValue->FNPpbDayTo ?></span></td>
									<td class="xWRmLine"><span id="ospPdtSign<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_Sign'.$aValue->FNPpbSign)?></span></td>
									<td class="xWRmLine">
										<span class="xWPdtShow" id="ospPdtAdjType<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_PackageAdjType'.$aValue->FTPpbAdjType)?></span>
										<input class="hidden" id="ohdPdtAdjType<?= $aValue->RowID ?>" value="<?= $aValue->FTPpbAdjType ?>">
										<div class="xWoet" style="display:none;">
											<select class="selectpicker form-control input-valid xWEditPpbAdjType" name="ocmEditPdtAdjType<?= $aValue->RowID ?>" id="ocmEditPdtAdjType<?= $aValue->RowID ?>">
												<option value=""><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice')?></option>
												<option class="xWEdtPdtAdjType1" value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
												<option class="xWEdtPdtAdjType2" value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
												<option class="xWEdtPdtAdjType3" value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
											</select>
										</div>
									</td>
									<td class="xWRmLine"><span class="xWPdtShow" id="ospPdtValue<?= $aValue->RowID ?>"><?= $aValue->FCPpbValue ?></span> <input type="text" class="form-control xWoet xWoetPdtValue" id="oetPdtValue<?= $aValue->RowID ?>" value="<?= $aValue->FCPpbValue ?>" style="display:none;width: 80px;"></td>

									<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
										<td class="xWRmLine text-center">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxPkgDelPdtPriBKG('<?= $aValue->FNPkgPdtID ?>','<?= $aValue->RowID ?>')">
										</td>
										<td class="xWRmLine text-center xWEditBtn" id="othEditPdtBtn<?= $aValue->RowID ?>">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxPkgEditPdtPriBKGBtn('<?= $aValue->FNPkgPdtID ?>','<?= $aValue->RowID ?>')">
										</td>
										<td class="xWRmLine text-center xWSaveBtn" id="othSavePdtBtn<?= $aValue->RowID ?>" style="display:none;">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/save.png" onclick="JSxPkgSavePdtPriBKG('<?= $aValue->FNPkgPdtID ?>','<?= $aValue->RowID ?>')">
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

	<script>

		$('.selectpicker').selectpicker();

		nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();

		if(nStaPrcDoc != ''){
			nHeight = $(window).height()-547;
			// $('#odvPkgPdtPriBKGPanal').css('height',nHeight)
			// $('.xWPKGSearchPanal').css('display','none');
		}else{
			nHeight = $(window).height()-686;
			// $('#odvPkgPdtPriBKGPanal').css('height',nHeight);
			// $('.xWPKGSearchPanal').css('display','block');
		}

		$('.xWEditPpbAdjType').change(function(){
			nPpbAdjType = this.value;
			if(nPpbAdjType != ''){
				$('.xWEditPpbAdjType').removeClass('input-invalid');
			}
		});

		$('.xWoetPdtValue').change(function(){
			nPpbValue = this.value;
			if(nPpbValue != ''){
				$('.xWoetPdtValue').removeClass('input-invalid');
			}
		});

	</script>
