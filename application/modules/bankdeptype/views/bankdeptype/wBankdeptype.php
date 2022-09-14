<input id="nStaBdtStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetBdtCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
<div id="odvCpnMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('bankindex/0/0');?>  
					<li id="oliBdtTitle" class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageBDTList()"><?php echo  language('bankdeptype/bankdeptype/bankdeptype', 'tBDTTitle'); ?></li>
					<li id="oliBdtAdd"  class="active" ><a><?php echo  language('bankdeptype/bankdeptype/bankdeptype', 'tBdtAdd'); ?></a></li> 
					<li id="oliBdtEdit" class="active" ><a><?php echo  language('bankdeptype/bankdeptype/bankdeptype', 'tBdtEdit'); ?></a></li>
				</ol>
			</div>
			
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
			<div id="odvBtnCmpEditInfo">
							<button onclick="JSvCallPageBDTList()" id="obtBarBack" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="submit"> <?= language('common/main/main', 'tBack')?></button>
							<?php if($aAlwEventBankdeptype['tAutStaFull'] == 1 || ($aAlwEventBankdeptype['tAutStaAdd'] == 1 || $aAlwEventBankdeptype['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group">
								<button onclick="$('#obtSubmitBdt').click()" class="btn btn-default xWBtnGrpSaveLeft" type="submit"> <?= language('common/main/main', 'tSave')?></button>
								<?=$vBtnSave?>
							</div>
							<?php endif; ?>
				</div>
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnBdtinfo">
						<?php if($aAlwEventBankdeptype['tAutStaFull'] == 1 || $aAlwEventBankdeptype['tAutStaAdd'] == 1) : ?>
							<button id="obtBdtAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageBDTAdd()">+</button>
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
	<div id="odvContentPageBdt" class="panel panel-headline">
	</div>
</div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tBrowseOption?>')"><a><?= language('common/main/main', 'tShowData')?> : <?= language('bank/bank/bank','tBNKTitleAdd')?></a></li>
                    <!-- <li class="active"><a><?= language('bank/bank/bank','tbank')?></a></li> -->
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitBdt').click()"><?= language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
	
    </div>
<?php endif;?>
<script src="<?php echo base_url('application/modules/bankdeptype/assets/src/bankdeptype/jbankdeptype.js')?>"></script>