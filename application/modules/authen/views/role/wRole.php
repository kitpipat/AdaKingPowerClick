<input id="oetRoleStaBrowse" type="hidden" value="<?php echo $nRoleBrowseType;?>">
<input id="oetRoleCallBackOption" type="hidden" value="<?php echo $tRoleBrowseOption;?>">

<?php if(isset($nRoleBrowseType) && $nRoleBrowseType == 0) : ?>
    <div id="odvRoleMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oRoleliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('role/0/0');?> 
                        <li id="oliRoleTitle" style="cursor:pointer"><?php echo language('authen/role/role','tROLTitle')?></li>
                        <li id="oliRoleTitleAdd" class="active"><a><?php echo language('authen/role/role','tROLTitleAdd')?></a></li>
                        <li id="oliRoleTitleEdit" class="active"><a><?php echo language('authen/role/role','tROLTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvRoleBtnGrpInfo">
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtRoleCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
							<?php endif; ?>
                        </div>
                        <div id="odvRoleBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtRoleCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack');?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
                                    <div class="btn-group odvRoleBtnGrpSave">
                                        <button id="obtRoleSubmitFrom" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main','tSave');?></button>
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
    <div class="xCNMenuCump xCNRoleBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvRoleContentPage" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahRoleBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliRoleNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliRoleBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('authen/role/role','tROLTitle');?></a></li>
                    <li class="active"><a><?php echo language('authen/role/role','tROLTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvRoleBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtRoleBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave');?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?php echo base_url('application/modules/authen/assets/src/role/jRole.js?v=1')?>"></script>