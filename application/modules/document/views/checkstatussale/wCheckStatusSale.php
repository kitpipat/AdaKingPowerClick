<input id="oetCSSStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetCSSCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<style>
.xWCSSDotStatus {
    width: 8px;
    height: 8px;
    border-radius: 100%;
    background: black;
    display: inline-block;
    margin-right: 5px;
}
.xWSCCStatusColor{
    font-weight: bold;
}
.xWCSSGreenColor{
    color:#2ECC71;
}
.xWCSSYellowColor{
    color:#F1C71F;
}
.xWCSSGrayColor{
    color:#7B7B7B;
}
.xWCSSRedColor{
    color:#d74141;
}

.xWCSSGreenBG{
    background-color:#2ECC71;
}
.xWCSSYellowBG{
    background-color:#F1C71F;
}
.xWCSSGrayBG{
    background-color:#7B7B7B;
}
.xWCSSRedBG{
    background-color:#d74141;
}
</style>

<div id="odvCSSMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNCSSMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('docCSS/0/0');?>
						<li id="oliCSSTitle"     class="xCNLinkClick" onclick="JSxCSSPageList('')"><?= language('document/checkstatussale/checkstatussale','tCSSTitle')?></li>
						<li id="oliCSSTitleEdit" class="active"><a href="javascrip:;"><?= language('document/checkstatussale/checkstatussale','tCSSEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvCSSBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" onclick="JSxCSSPageList()"><?=language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aPermission['tAutStaFull'] == 1 || ($aPermission['tAutStaAdd'] == 1 || $aPermission['tAutStaEdit'] == 1)): ?>
                                    <button id="obtCSSGenDocDelivery" class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button"> <?=language('document/checkstatussale/checkstatussale', 'สร้างใบส่ง'); ?></button>
                                    <button id="obtCSSGenDocPack" class="btn xCNBTNDefult xCNBTNDefult2Btn xCNHide" type="button"> <?=language('document/checkstatussale/checkstatussale', 'สร้างใบจัด'); ?></button>
                                    <a href="" download="" class="xWCSSOnDownload xCNHide" target="_blank"></a>
                                    <a href="" download="" class="xWCSSOnDownloadFullTax xCNHide" target="_blank"></a>
                                    <button id="obtCSSDownloadDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" > <?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownloadABB'); ?></button>
                                    <button id="obtCSSDownloadFullTax" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownloadFullTax'); ?></button>
                                    <button id="obtCSSApproveDoc" 	class="btn xCNBTNPrimery xCNBTNPrimery2Btn xWCSSHideObj" type="button"> <?=language('common/main/main', 'tCMNApprove'); ?></button>                                  
                                    <div id="odvCSSBtnGrpSave" 		class="btn-group xWCSSHideObj">
                                        <button id="obtCSSSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"><?=language('common/main/main', 'tSave'); ?></button>
                                        <?php echo $vBtnSave ?>
                                    </div>
                                <?php endif; ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNCSSLine" id="odvMenuCump">
	&nbsp;
</div>

<input type="hidden" id="ohdCSSOldFilterList" value="">
<input type="hidden" id="ohdCSSOldPageList" value="1">

<div class="main-content" id="odvCSSMainContent" style="background-color: #F0F4F7;">    
	<div id="odvCSSContent"></div>
</div>

<iframe id="oifCSSPrintABB" height="0"></iframe>
<iframe id="oifCSSPrintFullTax" height="0"></iframe>

<?php include('script/jCheckStatusSale.php') ?>