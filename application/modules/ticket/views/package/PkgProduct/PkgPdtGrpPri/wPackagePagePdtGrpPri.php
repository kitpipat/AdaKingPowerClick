<!-- รายละเอียดแพ็คเกจ  -->
	<div class="row">
		<div class="col-lg-12 xCNBCMenu xWHeaderMenu">
			<div class="row">
				<div class="col-md-8">
					<span onclick="JSxCallPageModelAndPdtPanal('<?= $nPkgID ?>')"><?= language('ticket/package/package', 'tPkg_Product')?></span>  / <label id="olaPdtNameHeader" style="font-weight:normal;"></label>  / <?= language('ticket/package/package', 'tPkg_GrpSpcPri')?>
					<input type="text" class="hidden" id="oetHidePkgPdtID" value="<?= $nPkgPdtID ?>">
				</div>
				<div class="col-md-4 text-right">

				</div>
			</div>
		</div>
	</div>
		<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
		<div class="row xWPKGSearchPanal">
			<form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPackagePdtGrpPri" >
				<input type="text" class="hidden" name="oetHidePkgID" id="oetHidePkgID" value="<?=$nPkgID?>">
				<div class="col-md-12">
					<div class="form-group">
						<?= language('ticket/package/package', 'tPkg_SearchCusGroup')?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectCusGroup') ?></label>
						<select class="selectpicker form-control input-valid"  name="ocmPkgGrpPriType" id="ocmPkgGrpPriType">
							<option value=""><?= language('ticket/package/package', 'tPkg_SelectCusGroup')?></option>
							<option value="1" data-name="<?= language('ticket/package/package', 'tPkg_Agency')?>"><?= language('ticket/package/package', 'tPkg_Agency')?></option>
							<option value="2" data-name="<?= language('ticket/package/package', 'tPkg_Customer')?>"><?= language('ticket/package/package', 'tPkg_Customer')?></option>
						</select>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_SelectCusGroup') ?></label>
						<select class="selectpicker form-control input-valid" name="ocmPkgGrpPriTypeList" id="ocmPkgGrpPriTypeList"><i class="fa fa-spinner fa-spin"></i>
							<option  value=""><?= language('ticket/package/package', 'tPkg_SelectCusGroup')?></option>
							<!-- HTML Content -->
						</select>
						<!--Loading Icon -->
						<i class="fa fa-spinner fa-spin fa-3x fa-fw xWLoading" style="position: absolute;font-size:20px;margin-left:40%;margin-top: -27px;display:none;"></i>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<label class="xCNLabelFrm"><?= language('ticket/package/package', 'tPkg_Price') ?></label>
						<input class="input100" type="number" min="0" name="oetPgpPdtPrice" id="oetPgpPdtPrice">
					</div>
				</div>
				<div class="col-md-2">
				</div>
				<div class="col-md-1 text-right">
					<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSxBtnAddPkgPdtGrpPri();" style="margin-top:25px;">+</button>
				</div>
			</form>
		</div>

	<div class="row">
		<div class="main-content">
			<div style="margin-top:10px;">
				<div class="xCNPdtPanal" id="odvPkgSpcGrpPriPanal">
					<table  class="table table-hover">
						<thead>
							<tr>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_TblNo')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_TblName')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_TblGroup')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_Price')?></th>
								<th class="text-center"><?= language('ticket/package/package', 'tPkg_SpacialPrice')?></th>
								<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
									<th class="text-center"><?= language('ticket/package/package', 'tPkg_Delete')?></th>
									<th class="text-center"><?= language('ticket/package/package', 'tPkg_Edit')?></th>
								<?php endif; ?>
							</tr>
						</thead>
						<?php if(isset($oPkgPdtPriByGrpList[0]->FNPgpGrpID)):?>
							<?php foreach ($oPkgPdtPriByGrpList AS $aValue):?>

								<tr onclick="JSxPkgClickAthROWPdtPriByGrp('<?= $aValue->RowID ?>');">
									<td class="xWRmLine"><?= $aValue->RowID ?></td>
									<td class="xWRmLine"><?= $aValue->FTGrpName ?></td>
									<td class="xWRmLine"><?=language('ticket/package/package', 'tPkg_PackagePgpType'.$aValue->FTPgpType)?></td>
									<td class="xWRmLine">
										<span class="xWEditPgpPdtPrice" id="ospEditPgpPdtPrice<?= $aValue->RowID ?>"><?= $aValue->FCPgpPdtPrice ?></span>
										<input type="text" class="form-control xWoet" id="oetEditPgpPdtPrice<?= $aValue->RowID ?>" style="display:none;width:100px;text-align:right" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?= $aValue->FCPgpPdtPrice ?>" disabled>
									</td>
									<td class="xWRmLine" onclick="JSxPkgCallPageGrpPriSpcPri('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->FTGrpName ?>','<?=$tPdtName?>','<?=$nPkgPdtID?>','2')"><i class="fa fa-cog" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_SpacialPrice')?></label></td>
									<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
										<td class="xWRmLine text-center">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/delete.png" onclick="JSxPkgDelPkgPdtPriByGrp('<?= $aValue->FNPgpGrpID ?>')">
										</td>
										<td class="xWRmLine xWEditBtn text-center" id="othEditPdtPriByGrpBtn<?= $aValue->FNPgpGrpID ?>">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/edit.png" onclick="JSxPkgEditPdtPriByGrpBtn('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')">
										</td>
										<td class="xWRmLine xWSaveBtn text-center" id="othSavePdtPriByGrpBtn<?= $aValue->FNPgpGrpID ?>"  style="display:none;">
											<img class="xCNIconTable" src="<?=base_url();?>application/modules/common/assets/images/icons/save.png" onclick="JSxPkgEditPkgPdtPriByGrp('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')">
										</td>
									<?php endif; ?>
								</tr>

							<?php endforeach;?>
							<?php else :?>
								<tbody>
									<tr>
										<td colspan="7" style="text-align:center;"><?= language('ticket/package/package', 'tPkg_DontHavePdt')?></td>
									</tr>
								</tbody>
							<?php endif;?>
						</table>
				</div>
			</div>
		</div>
	</div>



	<script>

		$('.selectpicker').selectpicker();

		$(document).ready(function() {
			$('.js-example-basic-single').select2();
		});

		nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();

		if(nStaPrcDoc != ''){
			nHeight = $(window).height()-247;
			$('#odvPkgSpcGrpPriPanal').css('height',nHeight)
			$('.xWPKGSearchPanal').css('display','none');
		}else{
			nHeight = $(window).height()-569;
			$('#odvPkgSpcGrpPriPanal').css('height',nHeight);
			$('.xWPKGSearchPanal').css('display','block');
		}


		$('#ospPdtName').text($('#olaPdtNameHeader').text());


		$('#ocmPkgGrpPriType').change(function(){
			nPgpType = this.value;
			JStPkgGetSelectPkgGrpPriHTML(nPgpType);
		});

	</script>