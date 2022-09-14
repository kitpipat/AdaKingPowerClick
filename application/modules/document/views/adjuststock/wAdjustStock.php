<input id="oetASTStaBrowse" type="hidden" value="<?php echo $nBrowseType?>">
<input id="oetASTCallBackOption" type="hidden" value="<?php echo $tBrowseOption?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
    <div id="odvASTMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-md-6">
                    <ol id="oliASTMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('dcmAST/0/0');?> 
                        <li id="oliASTTitle" style="cursor:pointer;"><?php echo language('document/adjuststock/adjuststock','tASTTitle');?></li>
						<li id="oliASTTitleAdd" class="active"><a><?php echo language('document/adjuststock/adjuststock','tASTTitleAdd');?></a></li>
						<li id="oliASTTitleEdit" class="active"><a><?php echo language('document/adjuststock/adjuststock','tASTTitleEdit');?></a></li>    
						<li id="oliASTTitleDetail" class="active"><a><?php echo language('document/adjuststock/adjuststock','tASTTitleDetail');?></a></li>    
                    </ol>
                </div>
                <div class="col-xs-12 col-md-6 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnASTInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtASTCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
							<?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtASTCallBackPage" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main','tBack')?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
                                    <button id="obtASTPrint" onclick="JSnASTPrintDoc()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint')?></button>
                                    <button id="obtASTCancel" onclick="JSnASTCancelDoc(false)" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel')?></button>
                                    <button id="obtASTApprove"  class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove')?></button>
                                    <div class="btn-group">
                                         <button id="obtASTSubmitFrom" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave')?></button>
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
    <div class="xCNMenuCump xCNASTBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageAST">
        </div>
    </div>
<?php else :?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahASTBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliASTNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliASTBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('document/adjuststock/adjuststock','tASTTitle');?></a></li>
                    <li class="active"><a><?php echo language('document/adjuststock/adjuststock','tASTTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvASTBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtASTBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
<?php endif;?>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/adjuststock/jAdjustStock.js"></script>