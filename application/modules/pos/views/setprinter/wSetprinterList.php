<div class="panel-heading">
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
				<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch'); ?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvSetprinterDataTable()" placeholder="<?php echo language('common/main/main','tSearch'); ?>">
					<span class="input-group-btn">
						<button id="oimSearchSetPrinter" class="btn xCNBtnSearch" type="button" onclick="JSvSetprinterDataTable()">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
					<?= language('common/main/main','tCMNOption')?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvModalDelSetprinter"><?php echo language('common/main/main','tCMNDeleteAll'); ?></a>
					</li>
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataSetprinter"></section>
</div>
