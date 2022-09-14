<input id="oetPriRntLkStaBrowse"      type="hidden" value="<?php echo $nPriRntLkBrowseType?>">
<input id="oetPriRntLkCallBackOption" type="hidden" value="<?php echo $tPriRntLkBrowseOption?>">

<?php if(isset($nPriRntLkBrowseType) && empty($nPriRntLkBrowseType)): ?>
    <div id="odvPriRntLkMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliPriRntLkMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmPriRentLocker/0/0');?> 
						<li id="oliPriRntLkTitle" style="cursor:pointer;"><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTitleMenu');?></li>
						<li id="oliPriRntLkTitleAdd" class="active"><a><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTitleAdd');?></a></li>
						<li id="oliPriRntLkTitleEdit" class="active"><a><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTitleEdit');?></a></li>
					</ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvPriRntLkBtnGrpInfo">
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtPriRntLkCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
							<?php endif; ?>
                        </div>
                        <div id="odvPriRntLkBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtPriRntLkCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack');?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <div class="btn-group">
                                        <button id="obtPriRntLkSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main','tSave');?></button>
                                        <?php echo $vBtnSave?>
                                    </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNPriRntLkBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvPriRntLkContentPage">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahPriRntLkBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPriRntLkNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliPriRntLkBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('document/purchaseinvoice/purchaseinvoice','tPITitleMenu');?></a></li>
                    <li class="active"><a><?php echo language('document/pricerentlocker/pricerentlocker','tPriRntLkTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPriRntLkBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtPriRntLkBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave');?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url();?>application/modules/document/assets/src/pricerentlocker/jPriceRentLocker.js"></script>