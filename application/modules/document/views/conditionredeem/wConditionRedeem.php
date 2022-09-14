<input id="oetRDHStaBrowseType"     type="hidden" value="<?php echo @$nRDHBrowseType;?>">
<input id="oetRDHCallBackOption"    type="hidden" value="<?php echo @$tRDHBrowseOption;?>">

<?php if (isset($nRDHBrowseType) && $nRDHBrowseType == 0): ?>
    <div id="odvRDHMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                    <ol id="oliRDHMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmRDH/0/0');?>
                        <li id="oliRDHTitle" style="cursor:pointer;"><?php echo language('document/conditionredeem/conditionredeem','tRDHTitleMenu');?></li>
                        <li id="oliRDHTitleAdd" class="active"><a><?php echo language('document/conditionredeem/conditionredeem','tRDHTitleAdd'); ?></a></li>
                        <li id="oliRDHTitleEdit" class="active"><a><?php echo language('document/conditionredeem/conditionredeem','tRDHTitleEdit'); ?></a></li>
                        <li id="oliRDHTitleDetail" class="active"><a><?php echo language('document/conditionredeem/conditionredeem','tRDHTitleDetail'); ?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvRDHBtnGrpInfo">
                            <?php if ($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
                                <button id="obtRDHCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvRDHBtnGrpAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtRDHCallBackPage"  class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack'); ?></button>
                                <?php if ($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)): ?>
                                    <button id="obtRDHPrintDoc" onclick="JSvRDHPrintDoc();" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?=language('common/main/main', 'tCMNPrint')?></button>
                                    <button id="obtRDHCancelDoc" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel'); ?></button>
                                    <button id="obtRDHApproveDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove'); ?></button> 
                                    <!-- <button id="obtRDHNextStepDoc" class="btn xCNBTNPrimery xCNBTNPrimery2Btn next-step" type="button"> <?php //echo language('document/conditionredeem/conditionredeem', 'tRdhBtnNext'); ?></button>  -->
                                  
                                    <div  id="odvRDHBtnGrpSave"     class="btn-group">
                                        <button id="obtRDHSubmitFromDoc" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave'); ?></button>
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
    <div class="xCNMenuCump xCNRDHBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvRDHContentPageDocument">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahRDHBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliRDHNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliRDHBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main', 'tShowData'); ?> : <?php echo language('document/conditionredeem/conditionredeem','tRDHTitleMenu');?></a></li>
                    <li class="active"><a><?php echo language('document/conditionredeem/conditionredeem','tRDHTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvRDHBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtRDHBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave'); ?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif; ?>
<script type="text/javascript" src="<?php echo base_url(); ?>application/modules/document/assets/src/conditionredeem/jConditionRedeem.js"></script>