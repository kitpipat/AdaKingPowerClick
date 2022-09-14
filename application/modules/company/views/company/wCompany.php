<link rel="stylesheet" href="<?php echo base_url(); ?>application/modules/company/assets/css/localcss/ada.utilitycompany.css">

<input id="oetCmpStaBrowse" type="hidden" value="<?php echo $nCmpBrowseType;?>">
<input id="oetCmpCallBackOption" type="hidden" value="<?php echo $tCmpBrowseOption;?>">

<?php if(isset($nCmpBrowseType) && $nCmpBrowseType == 0):?>
	<div id="odvCmpMenuTitle" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('company/0/0');?> 
						<li id="oliCMPTitle" onclick="JSvCallPageCompanyList()" style="cursor:pointer"><?php echo language('company/company/company','tCMPTitle')?></li>
                        <li id="oliCMPEditInfo" class="active"><a><?php echo language('company/company/company','tCMPTitleEditInfo')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div  id="odvBtnCmpInfo">
						<?php if($aAlwEventCompany['tAutStaFull'] == 1 || ($aAlwEventCompany['tAutStaAdd'] == 1 || $aAlwEventCompany['tAutStaEdit'] == 1)) : ?>
                        	<button class="btn xCNBTNPrimery" type="button" onclick="JSxCallPageCompanyEdit()"><?php echo language('company/company/company','tCMPEdit');?></button>
						<?php endif; ?>	
					</div>
					<div id="odvBtnAddEdit">
						<div class="demo-button xCNBtngroup" style="width:100%;">
							<button onclick="JSvCallPageCompanyList()" class="btn xCNBTNDefult " type="button"> <?php echo language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventCompany['tAutStaFull'] == 1 || ($aAlwEventCompany['tAutStaAdd'] == 1 || $aAlwEventCompany['tAutStaEdit'] == 1)) : ?>
								<button onclick="$('#obtEditCompany').click()" class="btn xCNBTNPrimery " type="button"> <?php echo language('common/main/main', 'tSave')?></button>
							<?php endif; ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNCmpBrowseLine" id="odvMenuCump">&nbsp;</div>
	<div class="main-content">
		<div id="odvContentPageCompany"></div>
	</div>

	<script src="<?php echo base_url('application/modules/company/assets/src/company/jCompany.js')?>"></script>
<?php endif;?>