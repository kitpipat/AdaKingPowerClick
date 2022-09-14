<input type="hidden" id="ohdPpbStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<div class="col-lg-12 xCNBCMenu xWHeaderMenu xWPpbSearchPanal" style="margin: 10px 0 10px;">
	<div class="row">
		<form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPKGPriBooking">
			<input type="text" class="hidden" name="oetHidePpkID" id="oetHidePpkID" value="<?=$nPpkID?>">

			<div class="row">
				<div class="col-md-2">
					<div class="form-group">
						<div class="wrap-input100">
							<span class="label-input100"><?= language('ticket/package/package', 'tPkg_From')?></span>
							<input class="input100" type="number" min="0" name="oetPpbDayFrm" id="oetPpbDayFrm">
							<span class="focus-input100"></span>
						</div>
					</div>


				</div>
				<div class="col-md-2">
					<div class="form-group">
						<div class="wrap-input100">
							<span class="label-input100"><?= language('ticket/package/package', 'tPkg_To')?></span>
							<input class="input100" type="number" min="0" name="oetPpbDayTo" id="oetPpbDayTo">
							<span class="focus-input100"></span>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<div class="wrap-input100 input100-select">
							<span class="label-input100">ประเภท</span>
							<div>
								<select class="form-control input-valid" name="ocmPpbSign"
								id="ocmPpbSign">
								<option value="1"><?= language('ticket/package/package', 'tPkg_PackagePphSign1')?></option>
								<option value="-1"><?= language('ticket/package/package', 'tPkg_PackagePphSign-1')?></option>
							</select>
						</div>
						<span class="focus-input100"></span>
					</div>
				</div>
			</div>
			<div class="col-md-3">		
				<div class="form-group">
					<div class="wrap-input100 input100-select">
						<span class="label-input100"><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice')?></span>
						<div>
							<select class="form-control input-valid" name="ocmPpbAdjType" id="ocmPpbAdjType">
								<option value=""><?= language('ticket/package/package', 'tPkg_TypeAdjustPrice')?></option>
								<option value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
								<option value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
								<option value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
							</select>
						</div>
						<span class="focus-input100"></span>
					</div>
				</div>
			</div>
			<div class="col-md-2">
				<div class="form-group">
					<div class="wrap-input100">
						<span class="label-input100"><?= language('ticket/package/package', 'tPkg_Value')?></span>
						<input class="input100" type="number" name="oetPpbValue" id="oetPpbValue">
						<span class="focus-input100"></span>
					</div>
				</div>
			</div>
			<div class="col-md-1 text-right">
				<button type="submit" class="btn xCNBTNDefult" onclick="JSxBtnAddPKGPriBooking();"><?= language('ticket/package/package', 'tPkg_Add')?></button>
			</div>
		</div>
	</form>
</div>
</div>
<div class="row">
	<div class="col-lg-12 xWpage-body">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div style="margin-top:10px;">
					<div class="xCNPdtPanal" id="odvPpbProductPanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238);border-width: 2px;border-style: solid; border-width: 2px; ">
						<table  class="table table-hover">
							<thead>
								<tr>
									<th><?= language('ticket/package/package', 'tPkg_TblNo')?></th>
									<th><?= language('ticket/package/package', 'tPkg_From')?></th>
									<th><?= language('ticket/package/package', 'tPkg_To')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Sign')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Condition')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Price')?></th>
									<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
										<th></th>
										<th></th>
									<?php endif; ?>
								</tr>
							</thead>
							
							<?php if(isset($oPkgPriBKG[0]->FNPpkID)):?>
								<?php foreach ($oPkgPriBKG AS $aValue):?>
									<tr onclick="JSxPkgEditClickPkgPriBKGTR('<?= $aValue->RowID ?>');">
										<td class="xWRmLine"><?= $aValue->RowID ?></td>
										<td class="xWRmLine"><span id="ospPkgDayFrm<?= $aValue->RowID ?>"><?= $aValue->FNPpbDayFrm ?></span></td>
										<td class="xWRmLine"><span id="ospPkgDayTo<?= $aValue->RowID ?>"><?= $aValue->FNPpbDayTo ?></span></td>
										<td class="xWRmLine"><span id="ospPkgSign<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_Sign'.$aValue->FNPpbSign)?></span></td>
										<!-- <th class="xWRmLine">
											<span class="xWPkgShow" id="ospPkgAdjType<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_PackageAdjType'.$aValue->FTPpbAdjType)?></span>
											<input class="hidden" id="ohdPkgAdjType<?= $aValue->RowID ?>" value="<?= $aValue->FTPpbAdjType ?>">
											<select class="selectpicker form-control input-valid xWoet xWEditPkgAdjType" name="ocmEditPkgAdjType<?= $aValue->RowID ?>" id="ocmEditPkgAdjType<?= $aValue->RowID ?>" style="display:none;">
												<option value=""><?= language('ticket/package/package', 'tPkg_DiscountIs')?></option>
												<option class="xWEdtPkgAdjType1" value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
												<option class="xWEdtPkgAdjType2" value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
												<option class="xWEdtPkgAdjType3" value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
											</select>
										</th> -->

										<td class="xWRmLine">
											<span class="xWPdtShow" id="ospPkgAdjType<?= $aValue->RowID ?>"><?= language('ticket/package/package', 'tPkg_PackageAdjType'.$aValue->FTPpbAdjType)?></span>
											<input class="hidden" id="ohdPkgAdjType<?= $aValue->RowID ?>" value="<?= $aValue->FTPpbAdjType ?>">
											<div class="xWoet" style="display:none;">
												<select class="selectpicker form-control input-valid xWEditPkgAdjType" name="ocmEditPkgAdjType<?= $aValue->RowID ?>" id="ocmEditPkgAdjType<?= $aValue->RowID ?>">
													<option value=""><?= language('ticket/package/package', 'tPkg_DiscountIs')?></option>
													<option class="xWEdtPdtAdjType1" value="1"><?= language('ticket/package/package', 'tPkg_PackageAdjType1')?></option>
													<option class="xWEdtPdtAdjType2" value="2"><?= language('ticket/package/package', 'tPkg_PackageAdjType2')?></option>
													<option class="xWEdtPdtAdjType3" value="3"><?= language('ticket/package/package', 'tPkg_PackageAdjType3')?></option>
												</select>
											</div>
										</td>
										
										<td class="xWRmLine"><span class="xWPkgShow" id="ospPkgValue<?= $aValue->RowID ?>"><?= $aValue->FCPpbValue ?></span> <input type="text" class="form-control xWoet xWoetPkgValue" id="oetPkgValue<?= $aValue->RowID ?>" value="<?= $aValue->FCPpbValue ?>" style="display:none;width: 80px;"></td>

										<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
											<td class="xWRmLine text-right"><span onclick="JSxPkgDelPpkPriBKG('<?= $aValue->FNPpkID ?>','<?= $aValue->FNPpbDayFrm ?>','<?= $aValue->FNPpbDayTo ?>')"><i class="fa fa-times" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_Delete')?></label></span></td>
											<td class="xWRmLine text-right xWEditBtn " id="othEditPkgBtn<?= $aValue->RowID ?>"><span onclick="JSxPkgEditPkgPriBKGBtn('<?= $aValue->FNPpkID ?>','<?= $aValue->RowID ?>')"><i class="fa fa-pencil" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_Edit')?></label></span></td>
											<td class="xWRmLine text-right xWSaveBtn" id="othSavePkgBtn<?= $aValue->RowID ?>" onclick="JSxPkgSavePkgPriBKG('<?= $aValue->FNPpkID ?>','<?= $aValue->RowID ?>')" style="display:none;"><i class="fa fa-floppy-o" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_Save')?></label></td>
										<?php endif; ?>

									</tr>

								<?php endforeach;?>
								<?php else :?>
									<tbody>
										<tr>
											<td colspan="7" style="text-align:center;"><?= language('ticket/package/package', 'tPkg_NoReservation')?></td>
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

		nStaPrcDoc = $('#ohdPpbStaPrcDoc').val();

		if(nStaPrcDoc != ''){
			nHeight = $(window).height()-247;
			$('#odvPpbProductPanal').css('height',nHeight)
			$('.xWPpbSearchPanal').css('display','none');
		}else{
			nHeight = $(window).height()-370;
			$('#odvPpbProductPanal').css('height',nHeight);
			$('.xWPpbSearchPanal').css('display','block');
		}


		$('.xWEditPpbAdjType').change(function(){
			nPpbAdjType = this.value;
			if(nPpbAdjType != ''){
				$('.xWEditPpbAdjType').removeClass('input-invalid');
			}
		});

		$('.xWoetPkgValue').change(function(){
			nPpbValue = this.value;
			if(nPpbValue != ''){
				$('.xWoetPkgValue').removeClass('input-invalid');
			}
		});



	</script>
