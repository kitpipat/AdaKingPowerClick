<input id="oetZneStaBrowse" type="hidden" value="<?php echo $nZneBrowseType?>">
<input id="oetZneCallBackOption" type="hidden" value="<?php echo $tZneBrowseOption?>">

<?php if(isset($nZneBrowseType) && $nZneBrowseType == 0) : ?>
	<div id="odvZneMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('zone/0/0');?> 
						<li id="oliZneTitle" class="xCNLinkClick" onclick="JSvCallPageZoneList()" style="cursor:pointer" ><?php echo language('address/zone/zone','tZNESubTitle')?></li>
						<li id="oliZneAdd" class="active"><a><?php echo language('address/zone/zone','tZNEAddZone')?></a></li>
						<li id="oliZneEdit" class="active"><a><?php echo language('address/zone/zone','tZNEEditZone')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnZneInfo">
						<?php if($aAlwEventZone['tAutStaFull'] == 1 || $aAlwEventZone['tAutStaAdd'] == 1) : ?>
						<button onclick="JSvCallPageZoneAdd()" class="xCNBTNPrimeryPlus" type="submit" >+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnZneEditInfo">
						<button onclick="JSvCallPageZoneList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventZone['tAutStaFull'] == 1 || ($aAlwEventZone['tAutStaAdd'] == 1 || $aAlwEventZone['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitZne').click()"> <?php echo language('common/main/main', 'tSave')?></button>
							<?php echo $vBtnSave?>
						</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="xCNMenuCump xCNZneBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
	<div class="main-content">
		<div id="odvContentPageZone" class="panel panel-headline">
		</div>
	</div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tZneBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliZneNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tZneBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('address/zone/zone','tZNESubTitle')?></a></li>
                    <li class="active"><a><?php echo language('address/zone/zone','tZNEAddZone')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvZneBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitZne').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url(); ?>application/modules/address/assets/src/zone/jZone.js"></script>
