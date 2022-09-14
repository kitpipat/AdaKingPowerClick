	<!-- Title Bar Menu Product -->
	<div id="odvAdjPdtMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb xCNBCMenu xWProductBreadcrumb">
						<?php FCNxHADDfavorite('adjustProduct');?> 
						<li id="oliAdjPdtTitle" style="cursor:pointer">
                           <?php echo language('product/product/product','tAdjPdtTitle')?>
						</li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnAdjPdtAddEdit">
                        <button id="obtCallBackAdjustProductExport" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('product/product/product', 'tAdjPdtExport')?></button>
						<button id="obtCallBackAdjustProductList" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventAdjPdt['tAutStaFull'] == 1 || ($aAlwEventAdjPdt['tAutStaAdd'] == 1 || $aAlwEventAdjPdt['tAutStaEdit'] == 1)) : ?>
				
								<button id="obtMainAlertConfirmUpdate" type="button" class="btn btn xCNBTNPrimery xCNBTNPrimery2Btn"> 
									<?php echo language('common/main/main', 'tSave')?>
								</button>
				
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>

	<!-- Menu Cump Product -->
	<div class="xCNMenuCump xCNPdtBrowseLine" id="odvMenuCump">&nbsp;</div>

	<!-- Div Content Product -->
	<div class="main-content">
        <div id="odvContentPageAdjustProduct" class="panel panel-headline"></div>
	</div>

	<div class="modal fade" id="odvAJPModalConfirmUpdate">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header xCNModalHead">
					<label class="xCNTextModalHeard"><?=language('product/product/product', 'tAdjPdtMassageConfirmAlter')?></label>
				</div>
				<div class="modal-body">
					<?=language('product/product/product', 'tAdjPdtMassageConfirm1')?> <span id="ospAJPCoutTotalSelecet">0</span> <?=language('product/product/product', 'tAdjPdtMassageConfirm2')?>
			
				</div>
				<div class="modal-footer">
					<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tCancel')?></button>
					<button id="obtMainSaveAdjustProduct" type="button" class="btn xCNBTNPrimery" ><?=language('common/main/main', 'tModalConfirm')?></button>
				</div>
			</div>
		</div>
	</div>
<?php include "script/jAdjustProduct.php"; ?>