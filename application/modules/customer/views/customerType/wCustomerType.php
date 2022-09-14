<input type="hidden" id="oetCstTypeStaBrowse" value="<?php echo $nCstTypeBrowseType?>">
<input type="hidden" id="oetCstTypeCallBackOption" value="<?php echo $tCstTypeBrowseOption?>">

<?php if(isset($nCstTypeBrowseType) && $nCstTypeBrowseType == 0): ?>
	<div id="odvCstTypeMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('customerType/0/0');?> 
                        <li id="oliCstTypeTitle" class="xCNLinkClick" onclick="JSvCallPageCstType('')" style="cursor:pointer"><?php echo language('customer/customerType/customerType','tCstTypeTitle'); ?></li> <!-- เปลี่ยน -->
						<li id="oliCstTypeTitleAdd" class="active"><a><?php echo language('customer/customerType/customerType','tCstTypeTitleAdd')?></a></li>
						<li id="oliCstTypeTitleEdit" class="active"><a><?php echo language('customer/customerType/customerType','tCstTypeTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnCstTypeInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1):?>
								<button id="obtCstTypeAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCstTypeAdd()">+</button>
							<?php endif;?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button onclick="JSvCallPageCstType()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo  language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
									<div class="btn-group">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCstType').click()"> <?php echo  language('common/main/main', 'tSave')?></button>
										<?php echo $vBtnSave?>
									</div>
								<?php endif;?>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNCstTypeBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
        <div id="odvContentPageCstType" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tCstTypeBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliCstTypeNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCstTypeBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('customer/customerType/customerType','tCstTypeTitle');?></a></li>
                    <li class="active"><a><?php echo language('customer/customerType/customerType','tCstTypeTitleAdd');?></a></li>
                </ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvCstTypeBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCstType').click()"><?php echo language('common/main/main', 'tSave');?></button>
                </div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/customer/assets/src/customerType/jCstType.js')?>"></script>

