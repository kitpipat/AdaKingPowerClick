<input id="oetTXOStaBrowse" type="hidden" value="<?php echo $nBrowseType?>">
<input id="oetTXOCallBackOption" type="hidden" value="<?php echo $tBrowseOption?>">
<input id="oetTXODocType" type="hidden" value="<?php echo $tDocType?>">

<?php if(isset($nBrowseType) && $nBrowseType == 0) : ?>
    <div id="odvTXOMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
					<ol id="oliTXOMenuNav" class="breadcrumb">
						<li id="oliTXOTitle" style="cursor:pointer;"><?php echo language('document/transferout/transferout','tTXOTitle'.$tDocType);?></li>
						<li id="oliTXOTitleAdd" class="active"><a><?php echo language('document/transferout/transferout','tTXOTitleAdd');?></a></li>
						<li id="oliTXOTitleEdit" class="active"><a><?php echo language('document/transferout/transferout','tTXOTitleEdit');?></a></li>
					</ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnTXOInfo">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1) : ?>
								<button id="obtTXOCallPageAdd" class="xCNBTNPrimeryPlus" type="button">+</button>
							<?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
							<div class="demo-button xCNBtngroup" style="width:100%;">
                                <button id="obtTXOCallBackPage" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)) : ?>
                                    <button id="obtTXOCancel" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCancel')?></button>
                                    <button id="obtTXOApprove" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNApprove')?></button>
                                    <button id="obtTXOPrint" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tCMNPrint')?></button>
                                    <div class="btn-group">
                                        <button id="obtTXOSubmitFrom" type="button" class="btn xWBtnGrpSaveLeft"> <?php echo language('common/main/main', 'tSave')?></button>
                                        <?php echo $vBtnSave?>
                                    </div>
                                <?php endif; ?>
							</div>
						</div>
					</div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNTXOBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageTXO">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a id="oahTXOBrowseCallBack" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliTXONavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li id="oliTXOBrowsePrevious" class="xWBtnPrevious"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('document/transferout/transferout','tTXOTitle'.$tDocName);?></a></li>
                    <li class="active"><a><?php echo language('document/transferout/transferout','tTXOTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvTXOBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button id="obtTXOBrowseSubmit" type="button" class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
        
    </div>
<?php endif;?>
<script type="text/javascript">
    var nLangEdits  = <?php echo $this->session->userdata("tLangEdit"); ?>;
</script>
<script type="text/javascript" src="<?php echo base_url() ?>application/modules/document/assets/src/transferout/jTransferout.js"></script>

