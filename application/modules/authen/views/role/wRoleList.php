<div class="panel-heading">
	<div class="row">
		<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12">
			<div class="form-group">
				<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvCallPageRoleDataTable(1)" autocomplete="off" name="oetSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
					<span class="input-group-btn">
						<button id="oimSearchCard" class="btn xCNBtnSearch" type="button">
							<img onclick="JSvCallPageRoleDataTable(1)" class="xCNIconBrowse" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1 ):?>
			<div class="col-lg-6 col-md-6 col-xs-12 col-sm-12 text-right">
				<div class="form-group"> 
					<label class="xCNLabelFrm hidden-xs hidden-sm"></label>
					<div >
						<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
							<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
								<?php echo language('common/main/main','tCMNOption')?>
								<span class="caret"></span>
							</button>
							<ul class="dropdown-menu" role="menu">
								<li id="oliBtnDeleteAll" class="disabled">
									<a data-toggle="modal" data-target="#odvModalDelRole"><?php echo language('common/main/main','tDelAll')?></a>
								</li>
							</ul>
						</div>
					</div>
				</div>
			</div>
		<?php endif; ?>
	</div>
</div>
<div class="panel-body">
	<section id="ostPanelDataRole"></section>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>