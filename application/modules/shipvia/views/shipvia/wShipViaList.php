<div class="panel-heading"> 
	<div class="row">
		<div class="col-xs-8 col-md-4 col-lg-4">
			<div class="form-group"> 
				<label class="xCNLabelFrm"><?php echo language('common/main/main','tSearchNew')?></label>
				<div class="input-group">
					<input type="text" class="form-control" id="oetSearchShipVia" name="oetSearchShipVia" placeholder="<?php echo language('common/main/main','tSearchNew')?>">
					<span class="input-group-btn">
						<button id="oimSearchShipVia" class="btn xCNBtnSearch" type="button">
							<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
						</button>
					</span>
				</div>
			</div>
		</div>
		<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
		<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:34px;">
			<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
				<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
				<?php echo language('common/main/main', 'tCMNOption') ?>
					<span class="caret"></span>
				</button>
				<ul class="dropdown-menu" role="menu">
					<li id="oliBtnDeleteAll" class="disabled">
						<a data-toggle="modal" data-target="#odvModalDelShipVia"><?php echo language('common/main/main', 'tDelAll') ?></a>
					</li>
				</ul>
			</div>
		</div>
		<?php endif;?>
	</div>
</div>
<div class="panel-body">
	<section id="ostDataShipVia"></section>
</div>

<div class="modal fade" id="odvModalDelShipVia">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main', 'tModalDelete')?></h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal"> - </span>
				<input type='hidden' id="ospConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<!-- แก้ -->
				<button id="osmConfirm" onClick="JSoShipViaDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script>
	$('#oimSearchShipVia').click(function(){
		JCNxOpenLoading();
		JSvShipViaDataTable();
	});
	$('#oetSearchShipVia').keypress(function(event){
		if(event.keyCode == 13){
			JCNxOpenLoading();
			JSvShipViaDataTable();
		}
	});
</script>
