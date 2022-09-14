<input type="hidden" id="oetPosEdcStaBrowse" value="<?php echo $nPosEdcBrowseType;?>">
<input type="hidden" id="oetPosEdcCallBackOption" value="<?php echo $tPosEdcBrowseOption;?>">

<?php if(isset($nPosEdcBrowseType) && $nPosEdcBrowseType == 0): ?>
    <div id="odvPosEdcMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oPosEdcliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('posEdc/0/0');?> 
                        <li id="oliPosEdcTitle" style="cursor:pointer"><?php echo language('pos/posedc/posedc','tPosEdcTitle');?></li>
                        <li id="oliPosEdcTitleAdd" class="active"><a><?php echo language('pos/posedc/posedc','tPosEdcTitleAdd');?></a></li>
                        <li id="oliPosEdcTitleEdit" class="active"><a><?php echo language('pos/posedc/posedc','tPosEdcTitleEdit');?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvPosEdcBtnGrpInfo">
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtPosEdcCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
							<?php endif; ?>
                        </div>
                        <div id="odvPosEdcBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtPosEdcCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack');?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
                                    <div class="btn-group">
                                        <button id="obtPosEdcSubmitFrom" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main','tSave');?></button>
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
    <div class="xCNMenuCump xCNPosEdcBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvPosEdcContentPage" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahPosEdcBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPosEdcNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliPosEdcBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('pos/posedc/posedc','tPosEdcTitle');?></a></li>
                    <li class="active"><a><?php echo language('pos/posedc/posedc','tPosEdcTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPosEdcBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtPosEdcBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave');?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script src="<?php echo base_url('application/modules/pos/assets/src/posedc/jPosEdc.js')?>"></script>