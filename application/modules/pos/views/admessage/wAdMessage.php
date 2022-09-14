<input id="oetAdvStaBrowse" type="hidden" value="<?=$nAdvBrowseType?>">
<input id="oetAdvCallBackOption" type="hidden" value="<?=$tAdvBrowseOption?>">

<?php if(isset($nAdvBrowseType) && $nAdvBrowseType == 0) :?>
<div id="odvAdvMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb xCNBCMenu">
					<?php FCNxHADDfavorite('adMessage/0/0');?> 
					<li id="oliAdvTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageAdMessage()"><?= language('pos/admessage/admessage','tADVTitle')?></li>
					<li id="oliAdvTitleAdd" class="active"><a><?= language('pos/admessage/admessage','tADVTitleAdd')?></a></li>
					<li id="oliAdvTitleEdit" class="active"><a><?= language('pos/admessage/admessage','tADVTitleEdit')?></a></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">				
				<div id="odvBtnAdvInfo">
					<?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaAdd'] == 1) : ?>
						<button id="obtAdvAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageAdMessageAdd()">+</button>
					<?php endif; ?>
				</div>
				<div id="odvBtnAddEdit">
					<button onclick="JSvCallPageAdMessage()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
					<?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || ($aAlwEventAdMessage['tAutStaAdd'] == 1 || $aAlwEventAdMessage['tAutStaEdit'] == 1)) : ?>
						<div class="btn-group"  id="obtBarSubmitAdv">
							<div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitAdMessage').click()"><?= language('common/main/main', 'tSave')?></button>
								<?php echo $vBtnSave;?>
							</div>
						</div>
					<?php endif; ?>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNAreBrowseLine" id="odvMenuCump">
	&nbsp;
</div>

<?php else:?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tAdvBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tAdvBrowseOption?>')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('pos/admessage/admessage','tADVTitle')?></a></li>
                    <li class="active"><a><?= language('pos/admessage/admessage','tADVTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitAdMessage').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
<?php endif ;?>

<div class="main-content">
	<div id="odvContentPageAdMessage" class="panel panel-headline"></div>
</div>

<!-- <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
</div> -->

<script src="<?= base_url('application/modules/common/assets/js/jquery-ui-sortable.min.js')?>"></script>
<script src="<?= base_url('application/modules/pos/assets/src/admessage/jAdMessage.js')?>"></script>