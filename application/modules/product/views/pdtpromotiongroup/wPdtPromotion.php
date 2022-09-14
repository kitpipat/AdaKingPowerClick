<input type="hidden" id="oetPmgStaBrowse"       value="<?php echo $nPmgBrowseType?>">
<input type="hidden" id="oetPmgCallBackOption"  value="<?php echo $tPmgBrowseOption?>">

<?php if(isset($nPmgBrowseType) && $nPmgBrowseType == 0):?>
    <div id="odvPmgMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliPmgMenuNav" class="breadcrumb">
                        <li id="oliPmgTitle" class="xCNLinkClick" onclick="JSvCallPagePdtPmgGrpList()" style="cursor:pointer"><?php echo language('product/pdtpromotion/pdtpromotion','tPMGTitle');?></li>
                        <li id="oliPmgTitleAdd" class="active"><a><?php echo language('product/pdtpromotion/pdtpromotion','tPMGTitleAdd');?></a></li>
                        <li id="oliPmgTitleEdit" class="active"><a><?php echo language('product/pdtpromotion/pdtpromotion','tPMGTitleEdit');?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div class="demo-button xCNBtngroup" style="width:100%;">
                        <div id="odvBtnPmgInfo">
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaAdd'] == 1):?>
                                <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtPmgGrpAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPagePdtPmgGrpList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || ($aAlwEvent['tAutStaAdd'] == 1 || $aAlwEvent['tAutStaEdit'] == 1)):?>
                                    <div class="btn-group">
                                        <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtPmtGrpSubmit();$('#obtSubmitPdtPmgGrp').click();"> <?php echo language('common/main/main', 'tSave');?></button>
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
    <div class="xCNMenuCump xCNPmgBrowseLine" id="odvMenuCump">&nbsp;</div>
    <div class="main-content">
        <div id="odvContentPagePdtPmgGrp" class="panel panel-headline">
        </div>
    </div>
<?php else:?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPmgBrowseOption;?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
					<i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPmgNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPmgBrowseOption;?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('product/pdtpromotion/pdtpromotion','tPMGTitle');?></a></li>
                    <li class="active"><a><?php echo language('product/pdtpromotion/pdtpromotion','tPMGTitleAdd');?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPmgBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
					<button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPdtPmtGrpSubmit();$('#obtSubmitPdtPmgGrp').click();"><?php echo language('common/main/main','tSave');?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>
<script src="<?= base_url('application/modules/product/assets/src/pdtpmggrp/jPdtPmgGrp.js')?>"></script>