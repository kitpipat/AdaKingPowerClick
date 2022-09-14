<input id="oetPplStaBrowse" type="hidden" value="<?=$nPplBrowseType?>">
<input id="oetPplCallBackOption" type="hidden" value="<?=$tPplBrowseOption?>">

<?php if(isset($nPplBrowseType) && $nPplBrowseType == 0) : ?>
    <div id="odvPpgMainMenu" class="main-menu"> 
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb"> 
                        <?php FCNxHADDfavorite('pdtpricegroup/0/0');?> 
                        <li id="oliPplTitle" class="xCNLinkClick" onclick="JSvCallPagePdtPriceList()" style="cursor:pointer"><?= language('product/pdtpricelist/pdtpricelist','tPPLTitle')?></li> 
                        <li id="oliPplTitleAdd" class="active"><a><?= language('product/pdtpricelist/pdtpricelist','tPPLTitleAdd')?></a></li>
                        <li id="oliPplTitleEdit" class="active"><a><?= language('product/pdtpricelist/pdtpricelist','tPPLTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnPplInfo">
                        <?php if($aAlwEventPdtPrice['tAutStaFull'] == 1 || $aAlwEventPdtPrice['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtPriceAdd()">+</button>
                        <?php endif;?>
                    </div>
                <div id="odvBtnAddEdit">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <button onclick="JSvCallPagePdtPriceList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                        <?php if($aAlwEventPdtPrice['tAutStaFull'] == 1 || ($aAlwEventPdtPrice['tAutStaAdd'] == 1 || $aAlwEventPdtPrice['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                            <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtPriceGroupSubmit();$('#obtSubmitPdtPrice').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                            <?php echo $vBtnSave?>
							</div>
                        <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNPplBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvContentPagePdtPrice"  class="panel panel-headline"></div>
    </div>
<?php else: ?>

    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPplBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPplNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPplBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('product/pdtpricelist/pdtpricelist','tPPLTitle')?></a></li>
                    <li class="active"><a><?php echo language('product/pdtpricelist/pdtpricelist','tPPLTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPplBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPdtPriceGroupSubmit();$('#obtSubmitPdtPrice').click()""><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>

<?php  endif; ?>

<script src="<?= base_url('application/modules/product/assets/src/pdtpricegroup/jPdtPriceGroup.js')?>"></script>