
	<div class="panel-heading"> <!-- เพิ่ม -->
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
				<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
					<label class="xCNLabelFrm"><?php echo language('pos/salemachine/salemachine','tPOSSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchSaleMachine" name="oetSearchSaleMachine" placeholder="<?php echo language('pos/salemachine/salemachine','tPOSSearchData')?>">
						<span class="input-group-btn">
							<button id="oimSearchSaleMachine" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">

				<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1)){ ?>
					<button type="button" id="odvEventImportFilePos" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button>
				<?php } ?>

				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?= language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDelSaleMachine"><?php echo language('common/main/main','tCMNDeleteAll'); ?></a>
						</li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="panel-body">
		<section id="ostDataSaleMachine"></section>
	</div>

<input type="hidden" name="ohdDeleteChooseconfirm" id="ohdDeleteChooseconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsAll') ?>">
<input type="hidden" name="ohdDeleteconfirm" id="ohdDeleteconfirm" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItems') ?>">
<input type="hidden" name="ohdDeleteconfirmYN" id="ohdDeleteconfirmYN" value="<?php echo language('common/main/main', 'tModalConfirmDeleteItemsYN') ?>">

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>

<script>
	$('#oimSearchSaleMachine').click(function(){
		JCNxOpenLoading();
		JSvSaleMachineDataTable();
	});

	$('#oetSearchSaleMachine').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvSaleMachineDataTable();
		}
	});

	// 13/07/2020 Piya
	// กดนำเข้า จะวิ่งไป Modal popup ที่ center
	$('#odvEventImportFilePos').click(function() {
		localStorage.removeItem("LocalItemData");
		
		var tNameModule = 'Pos';
		var tTypeModule = 'master';
		var tAfterRoute = 'salemachineImportGetDataInTemp';

		var aPackdata = {
			'tNameModule' : tNameModule,
			'tTypeModule' : tTypeModule,
			'tAfterRoute' : tAfterRoute
		};
		JSxImportPopUp(aPackdata);
	});
</script>
