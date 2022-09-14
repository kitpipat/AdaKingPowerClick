<input type="hidden" id="ohdPkgStaPrcDoc" value="<?= $oPkgDetail[0]->FTPkgStaPrcDoc?>">
<div class="row">
	<div class="col-lg-12 xCNBCMenu xWHeaderMenu">
		<div class="row">
			<div class="col-md-8">
				<h5> <a onclick="JSxCallPageModelAndPdtPanal('<?= $nPkgID ?>')"><?= language('ticket/package/package', 'tPkg_Model')?>  / <?= language('ticket/package/package', 'tPkg_PriceByGroup')?> / </a><label id="olaZneName" style="font-weight:normal;"><?=$tZneName?></label></h5>
				<input type="text" class="hidden" id="oetHidePkgID" value="<?=$nPkgID?>">
			</div>
			<div class="col-md-4 text-right">
				<span id="ospRefreshPagePkgGrpPri" onclick="JSxCallPagePkgSpcPriByGrp('<?=$nPkgID?>','<?=$nPpkID?>','<?=$tZneName?>')" ></span>
			</div>
		</div>
	</div>
</div>
<div class="row xWPKGSearchPanal">
	<div class="col-lg-12 xCNBCMenu xWHeaderMenu" style="margin: 10px 0 10px;">
		<div class="row">
			<form action="javascript:void(0)" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmAddPackagePkgSpcGrpPri" >
				<input type="text" class="hidden" name="oetHidePpkID" id="oetHidePpkID" value="<?=$nPpkID?>">
				<div class="col-md-12">
					<div class="form-group">
						<?= language('ticket/package/package', 'tPkg_SearchCusGroup')?>
					</div>
				</div>
				<div class="col-md-4">
					<div class="form-group">
						<div class="wrap-input100 input100-select">
							<span class="label-input100"><?= language('ticket/package/package', 'tPkg_StaLimitType')?></span>
							<div>
								<select class="form-control input-valid js-example-basic-single"  name="ocmPkgGrpPriType" id="ocmPkgGrpPriType" style="width: 100%">
									<option value=""><?= language('ticket/package/package', 'tPkg_StaLimitType')?></option>
									<option value="1" data-name="<?= language('ticket/package/package', 'tPkg_Agency')?>"><?= language('ticket/package/package', 'tPkg_Agency')?></option>
									<option value="2" data-name="<?= language('ticket/package/package', 'tPkg_Customer')?>"><?= language('ticket/package/package', 'tPkg_Customer')?></option>
								</select>
							</div>
							<span class="focus-input100"></span>
						</div>
					</div>
				</div>
				<div class="col-md-3">
					<div class="form-group">
						<div class="wrap-input100 input100-select">
							<span class="label-input100"><?= language('ticket/package/package', 'tPkg_SelectCusGroup')?></span>
							<div>
								<select class="form-control input-valid js-example-basic-single" name="ocmPkgGrpPriTypeList" id="ocmPkgGrpPriTypeList" style="width: 100%"><i class="fa fa-spinner fa-spin"></i>
									<option  value=""><?= language('ticket/package/package', 'tPkg_SelectCusGroup')?></option>
									<!-- HTML Content -->
								</select>
								<!--Loading Icon -->
								<i class="fa fa-spinner fa-spin fa-3x fa-fw xWLoading" style="position: absolute;font-size:20px;margin-left:40%;margin-top: -27px;display:none;"></i>
							</div>
							<span class="focus-input100"></span>
						</div>
					</div>
				</div>
				<div class="col-md-2">
					<div class="form-group">
						<div class="wrap-input100">
							<span class="label-input100"><?= language('ticket/package/package', 'tPkg_TblPrice')?></span>
							<input class="input100" type="number" min="0" name="oetPgpPdtPrice" id="oetPgpPdtPrice">
							<span class="focus-input100"></span>
						</div>
					</div>
				</div>
				<div class="col-md-2">

				</div>
				<div class="col-md-1 text-right">
					<button type="submit" class="btn xCNBTNDefult" onclick="JSxBtnAddPkgSpcGrpPri();"><?= language('ticket/package/package', 'tPkg_Add')?></button>
				</div>
			</form>
		</div>
	</div>
</div>


<div class="row">
	<div class="col-lg-12 xWpage-body">
		<div class="row">
			<div class="col-md-12 col-xs-12">
				<div style="margin-top:10px;">
					<div class="xCNPdtPanal" id="odvPkgSpcGrpPriPanal" style="overflow-x:hidden;overflow-y:auto;border-color: rgb(238, 238, 238); border-style: solid; border-width: 2px;">
						<table  class="table table-hover">
							<thead>
								<tr>
									<th><?= language('ticket/package/package', 'tPkg_TblNo')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Name')?></th>
									<th><?= language('ticket/package/package', 'tPkg_TblGroup')?></th>
									<th><?= language('ticket/package/package', 'tPkg_Price')?></th>
									<th></th>
									<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
										<th></th>
										<th></th>
									<?php endif; ?>
								</tr>
							</thead>
							<?php if(isset($oPkgGrpPriList[0]->FNPgpGrpID)):?>
								<?php foreach ($oPkgGrpPriList AS $aValue):?>

									<tr onclick="JSxPkgClickAthROWSpcPriByGrp('<?= $aValue->RowID ?>');">
										<th class="xWRmLine"><?= $aValue->RowID ?></th>
										<th class="xWRmLine"><?= $aValue->FTGrpName ?></th>
										<th class="xWRmLine"><?=language('ticket/package/package', 'tPkg_PackagePgpType'.$aValue->FTPgpType)?></th>
										<th class="xWRmLine">
											<span class="xWEditPgpPdtPrice" id="ospEditPgpPdtPrice<?= $aValue->RowID ?>"><?= $aValue->FCPgpPdtPrice ?></span>
											<input type="text" class="form-control xWoet" id="oetEditPgpPdtPrice<?= $aValue->RowID ?>" style="width:100px;display:none;text-align:right" onkeypress="return event.charCode >= 48 && event.charCode <= 57" value="<?= $aValue->FCPgpPdtPrice ?>" disabled>
										</th>
										<th class="xWRmLine" onclick="JSxPkgCallPageGrpPriSpcPri('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->FTGrpName ?>','<?=$tZneName?>','<?=$nPpkID?>');"><i class="fa fa-cog" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_SpacialPrice')?></label></th>
										<?php if($oPkgDetail[0]->FTPkgStaPrcDoc == ''): ?>
											<th class="xWRmLine" onclick="JSxPkgDelPkgSpcPriByGrp('<?= $aValue->FNPgpGrpID ?>')"><i class="fa fa-times" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_Delete')?></label></th>

											<th class="xWRmLine xWEditBtn" id="othEditSpcPriByGrpBtn<?= $aValue->FNPgpGrpID ?>" onclick="JSxPkgEditSpcPriByGrpBtn('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')"><i class="fa fa-pencil" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_Edit')?></label></th>
											<th class="xWRmLine xWSaveBtn" id="othSaveSpcPriByGrpBtn<?= $aValue->FNPgpGrpID ?>" onclick="JSxPkgEditPkgSpcPriByGrp('<?= $aValue->FNPgpGrpID ?>','<?= $aValue->RowID ?>')" style="display:none;"><i class="fa fa-floppy-o" ></i> <label style="cursor:pointer;font-weight:normal;"><?= language('ticket/package/package', 'tPkg_Save')?></label></th>
										<?php endif; ?>
									</tr>

								<?php endforeach;?>
								<?php else :?>
									<tbody>
										<tr>
											<td colspan="7" style="text-align:center;"><?= language('ticket/package/package', 'tPkg_NoGroup')?></td>
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

		$(document).ready(function() {
			$('.js-example-basic-single').select2();
		});

		nStaPrcDoc = $('#ohdPkgStaPrcDoc').val();

		if(nStaPrcDoc != ''){
			nHeight = $(window).height()-247;
			$('#odvPkgSpcGrpPriPanal').css('height',nHeight)
			$('.xWPKGSearchPanal').css('display','none');
		}else{
			nHeight = $(window).height()-365;
			$('#odvPkgSpcGrpPriPanal').css('height',nHeight);
			$('.xWPKGSearchPanal').css('display','block');
		}




		$('#ocmPkgGrpPriType').change(function(){
			nPgpType = this.value;
			JStPkgGetSelectPkgGrpPriHTML(nPgpType);
		});

	</script>