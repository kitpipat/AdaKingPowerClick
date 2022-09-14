<input type="hidden" id="ohdTCGBrowseType"    value="<?php echo $nTCGBrowseType;?>">
<input type="hidden" id="ohdTCGBrowseOption"  value="<?php echo $tTCGBrowseOption;?>">

<?php if (isset($nTCGBrowseType) && $nTCGBrowseType == 0): ?>
    <div id="odvTCGMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliTCGMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('pdtTouchGroup/0/0');?> 
                        <li id="oliTCGTitle" style="cursor:pointer;"><?php echo @$aTextLang['tTCGTitleMenu'];?></li>
                        <li id="oliTCGTitleAdd" class="active"><a><?php echo @$aTextLang['tTCGTitleAdd'];?></a></li>
                        <li id="oliTCGTitleEdit" class="active"><a><?php echo @$aTextLang['tTCGTitleEdit'];?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvTCGBtnGrpInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button id="obtTCGCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvTCGBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtTCGCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo @$aTextLang['tBack'];?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <div  id="odvTCGBtnGrpSave"     class="btn-group">
                                        <button id="obtTCGSubmitForm" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo @$aTextLang['tSave']; ?></button>
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
    <div class="xCNMenuCump xCNTCGBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvTCGContentPageDocument" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahTCGBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliTCGNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliTCGBrowsePrevious" class="xWBtnPrevious"><a><?php echo @$aTextLang['tShowData'];?> : <?php echo @$aTextLang['tTCGTitleMenu'];?></a></li>
                    <li class="active"><a><?php echo @$aTextLang['tTCGTitleAdd'];?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvTCGBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTCGBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo @$aTextLang['tSave'];?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/product/assets/src/pdttouchgroup/jProductTouchGroup.js"></script>
