<input id="oetRcvStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetRcvCallBackOption" type="hidden" value="<?=$tBrowseOption?>">
<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
<div class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('recive/0/0');?> 
					<li id="oliCrdTitle" class="xCNLinkClick" onclick="JSvCallPageReciveList()" style="cursor:pointer"><?= language('payment/recive/recive','tRCVTitle')?></li>
					<li id="oliRcvTitleAdd" class="active"><a><?= language('payment/recive/recive','tRCVTitleAdd')?></a></li>
					<li id="oliRcvTitleEdit" class="active"><a><?= language('payment/recive/recive','tRCVTitleEdit')?></a></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnRcvInfo">
						<?php if($aAlwEventRecive['tAutStaFull'] == 1 || $aAlwEventRecive['tAutStaAdd'] == 1) : ?>
							<button id="obtRcvAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageReciveAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnAddEdit">
						<button onclick="JSvCallPageReciveList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventRecive['tAutStaFull'] == 1 || ($aAlwEventRecive['tAutStaAdd'] == 1 || $aAlwEventRecive['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group xWHideSave">
								<button type="submit" class="btn xWBtnGrpSaveLeft " onclick="$('#obtSubmitRecive').click()"><?= language('common/main/main', 'tSave')?></button>
								<?=$vBtnSave?>
							</div>
						<?php endif; ?>
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
	<div id="odvContentPageRecive" class="panel panel-headline">
	</div>
</div>

<?php else: ?>

    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('payment/recive/recive','tRCVTitle')?></a></li>
                    <li class="active"><a><?php echo language('payment/recive/recive','tRCVTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitRecive').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
	<?php endif;?>
<script src="<?= base_url('application/modules/payment/assets/src/recive/jRecive.js')?>"></script>
