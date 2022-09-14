<div class="row">
	<input type="hidden" name="ohdMerchantcode" id="ohdMerchantcode" value="<?php echo $tMgpCode; ?>"/>

	<div class="col-xs-3 col-md-3 col-lg-3 text-left">
		<label class="xCNLabelFrm xCNLinkClick xCNMgpTitle" onclick="JSxGetMGPContentInfo();"><?= language('product/merpdtgroup/merpdtgroup','tMgpTitle')?></label>
		<label class="xCNLabelFrm xCNLinkClick xCNMgpTitleAdd xCNHide" onclick="JSxGetMGPContentInfo();"><?= language('product/merpdtgroup/merpdtgroup','tMgpTitleAdd')?></label>
		<label class="xCNLabelFrm xCNLinkClick xCNMgpTitleEdit xCNHide"  onclick="JSxGetMGPContentInfo();"><?= language('product/merpdtgroup/merpdtgroup','tMgpTitleEdit')?></label>
	</div>

	<div class="col-xs-9 col-md-9 col-lg-9">
		<div id="odvBtnAddSave" class="pull-right">
			<div>
				<button type="submit" class="btn xCNMgpAdd xCNHide" onclick="$('#obtSubmitMgp').click()" style="background-color: rgb(23, 155, 253); color: white;"> <?php echo  language('common/main/main', 'tSave')?></button>
				<button class="xCNBTNPrimeryPlus xCNMgpPageAdd" type="button" onclick="JSvCallPageProductGroupAdd()">+</button>
			</div>
		</div>	
	</div>	

	<div class="col-xs-12 col-md-12 col-lg-12">
		<div id="odvBtnMGPInfo" class="row">
				<div class="col-xs-8 col-md-4 col-lg-4">
					<div class="form-group">
						<label class="xCNLabelFrm"><?php echo language('product/merpdtgroup/merpdtgroup','tMgpSearch')?></label>
						<div class="input-group">
							<input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetSearchAll" onkeypress="Javascript:if(event.keyCode==13) JSvMgpGroupDataTable()" autocomplete="off" name="oetSearchAll" placeholder="<?php echo language('common/main/main','tPlaceholder'); ?>">
							<span class="input-group-btn">
								<button class="btn xCNBtnSearch" type="button" onclick="JSvMgpGroupDataTable()">
									<img class="xCNIconAddOn" src="<?php echo base_url().'/application/modules/common/assets/images/icons/search-24.png'?>">
								</button>
							</span>
						</div>
					</div>
				</div>
			<?php if($aAlwEventMgp['tAutStaFull'] == 1 || $aAlwEventMgp['tAutStaDelete'] == 1 ) : ?>
				<div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:25px;">
					<div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
						<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
							<?php echo language('common/main/main','tCMNOption')?>
							<span class="caret"></span>
						</button>
						<ul class="dropdown-menu" role="menu">
							<li id="oliBtnDeleteAll" class="disabled">
								<a data-toggle="modal" data-target="#odvModalDeleteMutirecord"><?php echo language('common/main/main','tDelAll')?></a>
							</li>
						</ul>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</div>

	<div class="col-xs-12 col-md-12 col-lg-12">
		<div class="row">
			<section id="ostDataProductGroup"></section>
		</div>
	</div>
</div>

<script src="<?php echo base_url(); ?>application/modules/common/assets/js/jquery.mask.js"></script>
<script src="<?php echo base_url(); ?>application/modules/common/assets/src/jFormValidate.js"></script>