<input id="oetRsnStaBrowse" type="hidden" value="<?php echo $nRsnBrowseType?>">
<input id="oetRsnCallBackOption" type="hidden" value="<?php echo $tRsnBrowseOption?>">

<?php if(isset($nRsnBrowseType) && $nRsnBrowseType == 0) : ?>
	<div id="odvRsnMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('reason/0/0');?> 
						<li id="oliRsnTitle" onclick="JSvCallPageReasonList()" style="cursor:pointer"><?php echo language('other/reason/reason','tRSNTitle')?></li>
						<li id="oliRsnTitleAdd" class="active"><a><?php echo language('other/reason/reason','tRSNTitleAdd')?></a></li>
						<li id="oliRsnTitleEdit" class="active"><a><?php echo language('other/reason/reason','tRSNTitleEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnRsnInfo">
					<?php if($aAlwEventReason['tAutStaFull'] == 1 || ($aAlwEventReason['tAutStaAdd'] == 1 || $aAlwEventReason['tAutStaEdit'] == 1)) : ?>
						<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSvCallPageReasonAdd()">+</button>
					<?php endif;?>
					</div>
					<div id="odvBtnRsnAddEdit">
						<button onclick="JSvCallPageReasonList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventReason['tAutStaFull'] == 1 || ($aAlwEventReason['tAutStaAdd'] == 1 || $aAlwEventReason['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitReason').click()"> <?php echo language('common/main/main', 'tSave')?></button>
							<?php echo $vBtnSave?>
						</div>
					<?php endif;?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNRsnBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageReason" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tRsnBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tRsnBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('other/reason/reason','tRSNTitle')?></a></li>
                    <li class="active"><a><?php echo language('other/reason/reason','tRSNTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitReason').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/other/assets/src/reason/jReason.js'); ?>"></script>