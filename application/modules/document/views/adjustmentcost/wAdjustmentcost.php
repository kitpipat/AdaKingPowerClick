<input id="oetADCStaBrowse" type="hidden" value="<?php echo $nBrowseType?>">
<input id="oetADCCallBackOption" type="hidden" value="<?php echo $tBrowseOption?>">
<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
    <div id="odvADCMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliADCMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('docADCCost/0/0');?> 
                        <li id="oliADCTitle" style="cursor:pointer;"><?php echo language('document/adjustmentcost/adjustmentcost','tADCTitle');?></li>
						<li id="oliADCTitleAdd" class="active"><a><?php echo language('document/adjustmentcost/adjustmentcost','tADCTitleAdd');?></a></li>
						<li id="oliADCTitleEdit" class="active"><a><?php echo language('document/adjustmentcost/adjustmentcost','tADCTitleEdit');?></a></li>    
						<li id="oliADCTitleDetail" class="active"><a><?php echo language('document/adjustmentcost/adjustmentcost','tADCTitleDetail');?></a></li>    
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvADCBtnInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtADCCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
							<?php endif; ?>
                        </div>
                        <div id="odvADCBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtADCCallBackPage" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack')?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
                                    <button id="obtADCPrint" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint')?></button>
                                    <button id="obtADCCancel" onclick="JSnADCCancelDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel')?></button>
                                    <button id="obtADCApprove"  class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove')?></button>
                                    <div class="btn-group">
                                         <button id="obtADCSubmitFrom" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave')?></button>
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
    <div class="xCNMenuCump xCNADCBrowseLine" id="odvADCMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvADCContentPage">
        </div>
    </div>
<?php else :?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahADCBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliADCNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliADCBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('document/adjustmentcost/adjustmentcost','tADCTitle');?></a></li>
                    <li class="active"><a><?php echo language('document/adjustmentcost/adjustmentcost','tADCTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvADCBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtADCBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/adjustmentcost/jAdjustmentcost.js"></script>