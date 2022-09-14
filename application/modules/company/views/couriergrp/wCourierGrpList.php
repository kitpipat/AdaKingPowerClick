<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-heading"> <!-- เพิ่ม -->
		<div class="row">
			<div class="col-xs-8 col-md-4 col-lg-4">
				<div class="form-group"> <!-- เปลี่ยน From Imput Class -->
					<label class="xCNLabelFrm"><?php echo language('company/couriergrp/couriergrp','tPSZSearch')?></label>
					<div class="input-group">
						<input type="text" class="form-control xCNInputWithoutSpc" id="oetSearchCouriergrp" name="oetSearchCouriergrp" placeholder="<?php echo language('company/couriergrp/couriergrp','tPSZSearch')?>">
						<span class="input-group-btn">
							<button id="oimSearchCouriergrp" class="btn xCNBtnSearch" type="button">
								<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
							</button>
						</span>
					</div>
				</div>
			</div>
			<?php if($aAlwEventCourierGrp['tAutStaFull'] == 1 || $aAlwEventCourierGrp['tAutStaDelete'] == 1 ) : ?>
			<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
				<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
						<?php echo language('common/main/main','tCMNOption')?>
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvModalDelCouriergrp"><?php echo language('common/main/main','tDelAll')?></a>
						</li>
					</ul>
				</div>
			</div>
			<?php endif; ?>
		</div>
	</div>
	<div class="panel-body">
		<section id="ostDataCouriergrp"></section>
	</div>
</div>
<script src="<?= base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?= base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
	$('#oimSearchCouriergrp').click(function(){
		JCNxOpenLoading();
		JSvCouriergrpDataTable();
	});
	$('#oetSearchCouriergrp').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvCouriergrpDataTable();
		}
	});
</script>
