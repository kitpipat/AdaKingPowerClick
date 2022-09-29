<input type="hidden" id="oetSrvPriStaBrowse" value="<?php echo $nSrvPriBrowseType;?>">
<input type="hidden" id="oetSrvPriCallBackOption" value="<?php echo $tSrvPriBrowseOption;?>">

<?php if(isset($nSrvPriBrowseType) && $nSrvPriBrowseType == 0): ?>
	<div id="odvSrvPriMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('ServerPrinter/0/0');?> 
                        <li id="oliSrvPriTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageSrvPri('')"><?php echo language('product/settingprinter/settingprinter','tSPTitle')?></li>
						<li id="oliSrvPriTitleAdd" class="active"><a><?php echo language('product/settingprinter/settingprinter','tSPTitleAdd')?></a></li>
						<li id="oliSrvPriTitleEdit" class="active"><a><?php echo language('product/settingprinter/settingprinter','tSPTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvBtnSrvPriInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtSrvPriAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSrvPriAdd()">+</button>
							<?php endif; ?>
						</div>
						<div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
								<button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn xWBtnTab2 xWExportPrintLabelInSrv"> <?php echo language('product/settingprinter/settingprinter', 'tLPTBExport')?></button>
								<button onclick="JSvCallPageSrvPri()" class="btn xCNBTNDefult xCNBTNDefult2Btn xWBtnTab1" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
								<?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
									<div class="btn-group xWBtnTab1">
										<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSrvPri').click()"> <?php echo language('common/main/main', 'tSave')?></button>
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
	<div class="xCNMenuCump xCNSrvPriBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
        <div id="odvContentPageSrvPri" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahSrvPriBrowseCallBack" onclick="JCNxBrowseData('<?php echo $tSrvPriBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliSrvPriNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliSrvPriBrowsePrevious" onclick="JCNxBrowseData('<?php echo $tSrvPriBrowseOption?>')" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('product/settingprinter/settingprinter','tSPTitle')?></a></li>
                    <li class="active"><a><?php echo language('product/settingprinter/settingprinter','tSPTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvSrvPriBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtSrvPriBrowseSubmit" type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSrvPri').click()">
						<?php echo language('common/main/main', 'tSave');?>
					</button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/settingconfig/assets/src/settingprint/jServerPrinter.js?v=1')?>"></script>