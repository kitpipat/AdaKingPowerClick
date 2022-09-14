<input type="hidden" id="oetCstOcpStaBrowse" value="<?php echo $nCstOcpBrowseType?>">
<input type="hidden" id="oetCstOcpCallBackOption" value="<?php echo $tCstOcpBrowseOption?>">

<?php if(isset($nCstOcpBrowseType) && $nCstOcpBrowseType == 0): ?>
	<div id="odvCstOcpMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<li id="oliCstOcpTitle" class="xCNLinkClick" onclick="JSvCallPageCstOcp('')"><?php echo language('customer/customerOcp/customerOcp','tCstOcpTitle')?></li>
						<li id="oliCstOcpTitleAdd" class="active"><a><?php echo language('customer/customerOcp/customerOcp','tCstOcpTitleAdd')?></a></li>
						<li id="oliCstOcpTitleEdit" class="active"><a><?php echo language('customer/customerOcp/customerOcp','tCstOcpTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnCstOcpInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtCstOcpAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCstOcpAdd()" title="<?php echo language('common/main/main', 'tAdd'); ?>">+</button>
							<?php endif;?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button onclick="JSvCallPageCstOcp()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo  language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
									<div class="btn-group">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCstOcp').click()"> <?php echo  language('common/main/main', 'tSave')?></button>
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
	<div class="xCNMenuCump xCNCstOcpBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
        <div id="odvContentPageCstOcp" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
		<div class="row">
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
				<a onclick="JCNxBrowseData('<?php echo $tCstOcpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
				</a>
				<ol id="oliCstOcpNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCstOcpBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('customer/customerOcp/customerOcp','tCstOcpTitle');?></a></li>
                    <li class="active"><a><?php echo language('customer/customerOcp/customerOcp','tCstOcpTitleAdd');?></a></li>
                </ol>
			</div>
			<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
				<div id="odvCstOcpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCstOcp').click()"><?php echo language('common/main/main', 'tSave')?></button>
				</div>
			</div>
		</div>
	</div>
	<div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/customer/assets/src/customerOcp/jCstOcp.js')?>"></script>