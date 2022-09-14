<input id="oetEvnStaBrowse" type="hidden" value="<?=$nEvnBrowseType?>">
<input id="oetEvnCallBackOption" type="hidden" value="<?=$tEvnBrowseOption?>">

<?php if(isset($nEvnBrowseType) && $nEvnBrowseType == 0) : ?>
<div id="odvEvnMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNEvnVMaster">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <li id="oliEvnTitle" onclick="JSvCallPagePdtNoSleByEvnList()" style="cursor:pointer"><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTitle')?></li>
                        <li id="oliEvnTitleAdd" class="active"><a><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTitleAdd')?></a></li>
                        <li id="oliEvnTitleEdit" class="active"><a><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnEvnInfo">
                            <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtNoSleByEvnAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit" style="margin-top:3px">
                            <button onclick="JSvCallPagePdtNoSleByEvnList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?= language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtNoSieByEvn['tAutStaFull'] == 1 || ($aAlwEventPdtNoSieByEvn['tAutStaAdd'] == 1 || $aAlwEventPdtNoSieByEvn['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
								<button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtNoSaleSubmit(1);$('#obtSubmitPdtNoSleByEvn').click()"> <?= language('common/main/main', 'tSave')?></button>
								<?=$vBtnSave?>
							</div>
                            <?php endif; ?>
                        </div>
                </div>
            </div>
            <div class="xCNEvnVBrowse">
                <div class="col-xs-12 col-md-6">
                    <a onclick="JCNxBrowseData('<?=$tEvnBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
						<i class="fa fa-arrow-left xCNIcon"></i>	
					</a>
                    <ol id="oliEvnNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                        <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?=$tEvnBrowseOption?>')"><a>แสดงข้อมูล : <?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTitle')?></a></li>
                        <li class="active"><a><?= language('product/pdtnoslebyevn/pdtnoslebyevn','tEVNTitleAdd')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right">
                    <div id="odvEvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                        <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtNoSleByEvn').click()"><?= language('common/main/main', 'tSave')?></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php endif;?>
<div class="xCNMenuCump xCNEvnBrowseLine" id="odvMenuCump">
	&nbsp;
</div>
<div class="main-content">
	<div id="odvContentPagePdtNoSleByEvn"></div>
</div>
<script src="<?= base_url('application/modules/product/assets/src/pdtnoslebyevn/jPdtNoSleByEvn.js')?>"></script>