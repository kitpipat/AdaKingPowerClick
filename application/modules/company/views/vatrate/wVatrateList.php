<div class="panel-heading">
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
				<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew'); ?></label>
				<div class="input-group">
					<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvVatrateDataTable()" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
					<span class="input-group-btn">
						<button id="oimSearchCstGrp" class="btn xCNBtnSearch" type="button" onclick="JSvVatrateDataTable()">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEventVatrate['tAutStaFull'] == 1 || ($aAlwEventVatrate['tAutStaAdd'] == 1 || $aAlwEventVatrate['tAutStaEdit'] == 1)) : ?>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
					<?php echo language('common/main/main','tCMNOption'); ?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a href="javascript:;" data-toggle="modal" data-target="#odvModalDelVatrate" onclick="JSxVatrateSetDataBeforeDelMulti()"><?php echo language('common/main/main','tCMNDeleteAll'); ?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataVatrate"></section>
</div>


<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
