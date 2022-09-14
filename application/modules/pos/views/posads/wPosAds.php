<input id="oetAdsStaBrowse" type="hidden" value="<?php echo $nAdsBrowseType?>">
<input id="oetAdsCallBackOption" type="hidden" value="<?php echo $tAdsBrowseOption?>">
<input type="hidden" id="ohdBchCode" value="<?php echo $aDataCode['tBchCode']?>">
<input type="hidden" id="ohdShpCode" value="<?php echo $aDataCode['tShpCode']?>">
<input type="hidden" id="ohdPosCode" value="<?php echo $aDataCode['tPosCode']?>">

<?php if(isset($nAdsBrowseType) && $nAdsBrowseType == 0) : ?>
            <div class="row">
                <div class="col-xs-12 col-md-4">
                    <ol id="oliMenuNav" class="breadcrumb">
                    <li id="oliPosAdsTitle" class="xCNLinkClick" onclick="JSvCallPagePosAdsList();" style="cursor:pointer"><?= language('pos/posads/posads','tAdsTitle')?></li>
                    <li id="oliAdsTitleAdd"  class="active"><a>/ <?= language('pos/posads/posads','tAdsAdd')?></a></li>
                    <li id="oliAdsTitleEdit" class="active"><a><?= language('pos/posads/posads','tAdsEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-8 text-right">
                    <div id="odvBtnAdsInfo">
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePosAdsAdd();">+</button>
                    </div>
                <div id="odvBtnAdsAddEdit">
                        <button type="button" onclick="JSvCallPagePosAdsList();" class="btn" style="background-color: #D4D4D4; color: #000000;">
                            <?php echo language('company/shopgpbypdt/shopgpbypdt', 'tSGPPBTNCancel')?>
                        </button>
                    <?php if($aAlwEventPosAds['tAutStaFull'] == 1 || ($aAlwEventPosAds['tAutStaAdd'] == 1 || $aAlwEventPosAds['tAutStaEdit'] == 1)) : ?>
                        <button type="submit" class="btn" style="background-color: rgb(23, 155, 253); color: white;" onclick="$('#obtSubmitPosAds').click();"> 
                            <?php echo  language('common/main/main', 'tSave')?>
                        </button>
                    <?php endif; ?>
                    </div>
                </div>
            </div>
        <div class="xCNMenuCump xCNAdsBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div id="odvContentPagePosAds"></div> 
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tAdsBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tAdsBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('payment/card/card','tCRDTitle')?></a></li>
                    <li class="active"><a><?php echo language('payment/card/card','tCRDTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPosAds').click();"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?php echo base_url(); ?>application/modules/pos/assets/src/posads/jPosAds.js"></script>
