<input id="oetPadStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetPadCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>

	<div id="odvPadMainMenu" class="main-menu clearfix">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="xCNPADMaster">
					<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
						<ol id="oliMenuNav" class="breadcrumb">
							<?php FCNxHADDfavorite('PermissionApproveDoc/0/0');?> 
							<li id="oliPadTitle"     class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPagePermissionApproveDocList()"><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTitle')?></li>
							<li id="oliPadTitleEdit" class="active"><a><?php echo language('PermissionApvDoc/PermissionApvDoc/PermissionApvDoc','tPADTitleManage')?></a></li>
						</ol>
					</div>
					<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnPadAddEdit">
							<button type="button" onclick="JSvCallPagePermissionApproveDocList();" class="btn" style="background-color: #D4D4D4; color: #000000;">
									<?= language('common/main/main', 'tBack')?>
							</button>
							<button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" id="obtGpShopBySHPSave" onclick="JSxPADAddEditPermissionApproveDoc()"> <?php echo  language('common/main/main', 'tSave')?></button>
					</div>
				</div>
			</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
			<div id="odvContentPermissionApvDoc" class="panel panel-headline"></div>
	</div>
<?php else: ?>

<?php endif;?>
<script src="<?php echo base_url('application/modules/PermissionApvDoc/assets/src/PermissionApvDoc/jPermissionApvDoc.js')?>"></script>

