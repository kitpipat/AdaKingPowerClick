<?php 
// echo '<pre>';
// echo print_r($aAlwEventBranch); 
// echo '</pre>';
?>

<div class="panel-heading"> <!-- เพิ่ม -->
	<div class="row"> <!-- เพิ่ม -->
		<div class="col-xs-12 col-md-4 col-lg-4">
			<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
				<label class="xCNLabelFrm"><?= language('company/branch/branch','tBCHSearch')?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeyup="Javascript:if(event.keyCode==13) JSvBranchDataTable()" value="<?=@$tSearch?>" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
					<span class="input-group-btn">
						<button class="btn xCNBtnSearch" type="button" onclick="JSvBranchDataTable()" >
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>	

		<?php if($aAlwEventBranch['tAutStaFull'] == 1 || $aAlwEventBranch['tAutStaDelete'] == 1 ) : ?>
		<div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:34px;">

			<?php if($aAlwEventBranch['tAutStaFull'] == 1 || ($aAlwEventBranch['tAutStaAdd'] == 1)){ ?>
				<button type="button" id="odvEventImportFileBCH" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button>
			<?php } ?>

			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
					<?= language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvmodaldeleteBranch"><?= language('common/main/main','tDelAll')?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif; ?>

	</div>
</div>

<div class="panel-body">
	<section id="ostDataBranch"></section>
</div>


<div class="modal fade" id="odvmodaldeleteBranch">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" style="display:inline-block"><?=language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnBranchDelChoose()">
					<i class="fa fa-check-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalConfirm')?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<i class="fa fa-times-circle" aria-hidden="true"></i> <?=language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
	//supawat 03/07/2020
	//กดนำเข้า จะวิ่งไป Modal popup ที่ center
	$('#odvEventImportFileBCH').click(function() {
		var tNameModule = 'Branch';
		var tTypeModule = 'master';
		var tAfterRoute = 'branchPageImportDataTable';

		var aPackdata = {
			'tNameModule' : tNameModule,
			'tTypeModule' : tTypeModule,
			'tAfterRoute' : tAfterRoute
		};
		JSxImportPopUp(aPackdata);
	});
</script>