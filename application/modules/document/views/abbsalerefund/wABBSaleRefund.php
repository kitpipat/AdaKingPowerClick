<input id="oetABBStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetABBCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<style>
.xWABBDotStatus {
    width: 8px;
    height: 8px;
    border-radius: 100%;
    background: black;
    display: inline-block;
    margin-right: 5px;
}
.xWABBStatusColor{
    font-weight: bold;
}
.xWABBGreenColor{
    color:#2ECC71;
}
.xWABBYellowColor{
    color:#F1C71F;
}
.xWABBGrayColor{
    color:#7B7B7B;
}
.xWABBGreenBG{
    background-color:#2ECC71;
}
.xWABBYellowBG{
    background-color:#F1C71F;
}
.xWABBGrayBG{
    background-color:#7B7B7B;
}
</style>

<div id="odvABBMainMenu" class="main-menu">
	<div class="xCNMrgNavMenu">
		<div class="xCNavRow" style="width:inherit;">

			<div class="xCNABBMaster row">
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">		
					<ol id="oliMenuNav" class="breadcrumb">
						<?php FCNxHADDfavorite('docABB/0/0');?>
						<li id="oliABBTitle"     class="xCNLinkClick" onclick="JSxABBPageList('')"><?= language('document/abbsalerefund/abbsalerefund','tABBTitle')?></li>
						<li id="oliABBTitleEdit" class="active"><a href="javascrip:;"><?= language('document/abbsalerefund/abbsalerefund','tABBEdit')?></a></li>
					</ol>
				</div>
				<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
					<div class="demo-button xCNBtngroup" style="width:100%;">
						<div id="odvABBBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" onclick="JSxABBPageList()"><?=language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aPermission['tAutStaFull'] == 1 || ($aPermission['tAutStaAdd'] == 1 || $aPermission['tAutStaEdit'] == 1)): ?>
                                    <a href="" download="" class="xWABBOnDownload xCNHide"></a>
									<a href="" download="" class="xWABBOnDownloadFullTax xCNHide"></a>
                                    <button id="obtABBDownloadDoc" 	class="btn xCNBTNDefult xCNBTNDefult2Btn" 	type="button" > <?=language('document/checkstatussale/checkstatussale', 'tABBBtnDownloadABB'); ?></button>
                                    <button id="obtABBDownloadFullTax" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('document/checkstatussale/checkstatussale', 'tABBBtnDownloadFullTax'); ?></button>
                                <?php endif; ?>
                            </div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
<div class="xCNMenuCump xCNABBLine" id="odvMenuCump">
	&nbsp;
</div>

<input type="hidden" id="ohdABBOldFilterList" value="">
<input type="hidden" id="ohdABBOldPageList" value="1">

<div class="main-content" id="odvABBMainContent" style="background-color: #F0F4F7;">    
	<div id="odvABBContent"></div>
</div>
<iframe id="oifABBPrint" height="0"></iframe>
<iframe id="oifABBPrintFullTax" height="0"></iframe>

<?php include('script/jABBSaleRefund.php') ?>