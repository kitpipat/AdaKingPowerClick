<input id="oetBbkStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetBbkCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
<div id="odvCdcMainMenu" class="main-menu clearfix">
	<div class="xCNMrgNavMenu">
		<div class="row xCNavRow" style="width:inherit;">
			<div class="xCNBBKMaster">
			<div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
				<ol id="oliMenuNav" class="breadcrumb">
					<?php FCNxHADDfavorite('BookBank/0/0');?> 
					<li id="oliBbkTitle"     class="xCNLinkClick" style="cursor:pointer" onclick="JSvCallPageBookBankList()"><?php echo language('BookBank/BookBank/BookBank','tBBKTitle')?></li>
					<li id="oliBbkTitleAdd"  class="active"><a><?php echo language('BookBank/BookBank/BookBank','tBBKTitleAdd')?></a></li>
					<li id="oliBbkTitleEdit" class="active"><a><a><?php echo language('BookBank/BookBank/BookBank','tBBKTitleEdit')?></a></li>
				</ol>
			</div>
			<div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
				<div class="demo-button xCNBtngroup" style="width:100%;">
					<div id="odvBtnBbkInfo">
						<?php if($aAlwEventBookBank['tAutStaFull'] == 1 || $aAlwEventBookBank['tAutStaAdd'] == 1) : ?>
							<button id="obtฺCdcAdd" class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageBookBankAdd()">+</button>
						<?php endif; ?>
					</div>
					<div id="odvBtnBbkAddEdit">
						<button onclick="JSvCallPageBookBankList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"><?= language('common/main/main', 'tBack')?></button>
						<?php if($aAlwEventBookBank['tAutStaFull'] == 1 || ($aAlwEventBookBank['tAutStaAdd'] == 1 || $aAlwEventBookBank['tAutStaEdit'] == 1)) : ?>
							<div class="btn-group"  id="obtBarSubmitBbk">
								<div class="btn-group">
									<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitBookBank').click()"><?= language('common/main/main', 'tSave')?></button>
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
	<div id="odvContentPageBookBank" class="panel panel-headline"></div>
</div>
<?php else: ?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?=$tBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliBbkNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBrowseOption; ?>')"><a><?php echo language('common/main/main', 'tShowData')?> : <?php echo language('BookBank/BookBank/BookBank','tBBKTitle')?></a></li>
                    <li class="active"><a><?php echo language('BookBank/BookBank/BookBank','tBBKTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBbkBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitBookBank').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body">
    </div>
<?php endif;?>

<script src="<?php echo base_url('application/modules/BookBank/assets/src/BookBank/jBookBank.js')?>"></script>

