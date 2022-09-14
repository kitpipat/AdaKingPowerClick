<input id="oetRacStaBrowse" type="hidden" value="<?php echo $nRacBrowseType?>">
<input id="oetRacCallBackOption" type="hidden" value="<?php echo $tRacBrowseOption?>">

<?php if(isset($nRacBrowseType) && $nRacBrowseType == 0) : ?>
	<div id="odvRsnMainMenu" class="main-menu">
		<div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
				<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('rack/0/0');?> 
						<li id="oliRsnTitle" onclick="JSvCallPageRackList()" style="cursor:pointer"><?php echo language('company/rack/rack','tRckTitle')?></li>
						<li id="oliRsnTitleAdd" class="active"><a><?php echo language('company/rack/rack','tRacAdd')?></a></li>
						<li id="oliRsnTitleEdit" class="active"><a><?php echo language('company/rack/rack','tRacEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
					<div id="odvBtnRsnInfo">
					<?php if($aAlwEventRack['tAutStaFull'] == 1 || ($aAlwEventRack['tAutStaAdd'] == 1 || $aAlwEventRack['tAutStaEdit'] == 1)) : ?>
						<button class="xCNBTNPrimeryPlus" type="submit" onclick="JSvCallPageRackAdd()">+</button>
					<?php endif;?>
					</div>
					<div id="odvBtnRsnAddEdit">
						<button onclick="JSvCallPageRackList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventRack['tAutStaFull'] == 1 || ($aAlwEventRack['tAutStaAdd'] == 1 || $aAlwEventRack['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group">
							<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitRack').click()"> <?php echo language('common/main/main', 'tSave')?></button>
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
                <a onclick="JCNxBrowseData('<?php echo $tRacBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tRacBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('other/reason/reason','กลุ่มช่อง')?></a></li>
                    <li class="active"><a><?php echo language('other/reason/reason','เพิ่มกลุ่มช่อง')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitRack').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/company/assets/src/rack/jRack.js'); ?>"></script>