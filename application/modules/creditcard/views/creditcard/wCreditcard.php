<input id="oetCdcStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetCdcCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
<div id="odvCdcMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNWahVMaster">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('creditcard/0/0');?> 
					<li id="oliCdcTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageCreditcardList()"><?php echo language('creditcard/creditcard/creditcard','tCDCTitle')?></li>
					<li id="oliCdcTitleAdd" class="active"><a><?php echo language('creditcard/creditcard/creditcard','tCDCTitleAdd')?></a></li>
					<li id="oliCdcTitleEdit" class="active"><a><a><?php echo language('creditcard/creditcard/creditcard','tCDCTitleEdit')?></a></li>
				</ol>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnCdcInfo">
						<?php if($aAlwEventCreditcard['tAutStaFull'] == 1 || $aAlwEventCreditcard['tAutStaAdd'] == 1) : ?>
							<button id="obtฺCdcAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCreditcardAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnAddEdit">
						<button onclick="JSvCallPageCreditcardList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventCreditcard['tAutStaFull'] == 1 || ($aAlwEventCreditcard['tAutStaAdd'] == 1 || $aAlwEventCreditcard['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group"  id="obtBarSubmitCdc">
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCreditcard').click()"><?= language('common/main/main', 'tSave')?></button>
									<?=$vBtnSave?>
								</div>
							</div>
						<?php endif; ?>
					</div>
				</div>
			</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump" id="odvMenuCump">
    &nbsp;
</div>
<div class="main-content">
	<div id="odvContentPageCreditcard" class="panel panel-headline"></div>
</div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliCdcNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption; ?>')"><a><?php echo language('common/main/main', 'tShowData')?> : <?php echo language('creditcard/creditcard/creditcard','tCDCTitle')?></a></li>
                    <li class="active"><a><?php echo language('creditcard/creditcard/creditcard','tCDCTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvCdcBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitWah').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/creditcard/assets/src/creditcard/jCreditcard.js')?>"></script>

