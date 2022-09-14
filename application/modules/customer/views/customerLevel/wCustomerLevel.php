<input type="hidden" id="oetCstLevStaBrowse" value="<?php echo $nCstLevBrowseType?>">
<input type="hidden" id="oetCstLevCallBackOption" value="<?php echo $tCstLevBrowseOption?>">

<?php if(isset($nCstLevBrowseType) && $nCstLevBrowseType == 0):?>
	<div id="odvCstLevMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliCstLevMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('customerLevel/0/0');?> 
						<li id="oliCstLevTitle" class="xCNLinkClick" onclick="JSvCallPageCstLev('')"><?php echo language('customer/customerLevel/customerLevel','tCstLevTitle');?></li>
						<li id="oliCstLevTitleAdd" class="active"><a><?php echo language('customer/customerLevel/customerLevel','tCstLevTitleAdd');?></a></li>
						<li id="oliCstLevTitleEdit" class="active"><a><?php echo language('customer/customerLevel/customerLevel','tCstLevTitleEdit');?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnCstLevInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1):?>
								<button id="obtCstLevAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCstLevAdd()" title="<?php echo language('common/main/main', 'tAdd');?>">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button onclick="JSvCallPageCstLev()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack');?></button>
								<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
									<div class="btn-group">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCstLev').click()"> <?php echo language('common/main/main', 'tSave')?></button>
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
	<div class="xCNMenuCump xCNCstLevBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
        <div id="odvContentPageCstLev" class="panel panel-headline">
        </div>
    </div>
<?php else:?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tCstLevBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliCstLevNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCstLevBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('customer/customerLevel/customerLevel','tCstLevTitle');?></a></li>
                    <li class="active"><a><?php echo language('customer/customerLevel/customerLevel','tCstLevTitleAdd');?></a></li>
                </ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvCstLevBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCstLev').click()"><?php echo language('common/main/main','tSave');?></button>
                </div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?php echo base_url('application/modules/customer/assets/src/customerLevel/jCstLevel.js')?>"></script>

