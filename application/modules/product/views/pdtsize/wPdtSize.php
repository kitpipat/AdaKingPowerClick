<input id="oetPszStaBrowse" type="hidden" value="<?=$nPszBrowseType?>">
<input id="oetPszCallBackOption" type="hidden" value="<?=$tPszBrowseOption?>">

<?php if(isset($nPszBrowseType) && $nPszBrowseType == 0) : ?>
    <div id="odvPszMainMenu" class="main-menu"> <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
			<div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('pdtsize/0/0');?> 
                        <li id="oliPszTitle" class="xCNLinkClick" onclick="JSvCallPagePdtPszList()" style="cursor:pointer"><?= language('product/pdtsize/pdtsize','tPSZTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliPszTitleAdd" class="active"><a><?= language('product/pdtsize/pdtsize','tPSZTitleAdd')?></a></li>
                        <li id="oliPszTitleEdit" class="active"><a><?= language('product/pdtsize/pdtsize','tPSZTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-md-4 text-right p-r-0">
                    <div id="odvBtnPszInfo">
                        <?php if($aAlwEventPdtSize['tAutStaFull'] == 1 || $aAlwEventPdtSize['tAutStaAdd'] == 1) : ?>
                        <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtPszAdd()">+</button>
                        <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit" style="margin-top:3px">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                            <button onclick="JSvCallPagePdtPszList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                            <?php if($aAlwEventPdtSize['tAutStaFull'] == 1 || ($aAlwEventPdtSize['tAutStaAdd'] == 1 || $aAlwEventPdtSize['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitPdtPsz').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                            <?php endif;?>
                        </div>
                    </div>
                </div>
            </div>        
        </div>
    </div>
    <div class="xCNMenuCump xCNPtyBrowseLine" id="odvMenuCump">
		&nbsp;
	</div>
    <div class="main-content">
        <div id="odvContentPagePdtPsz"></div>
    </div>
<?php else:?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPszBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPunNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPszBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('product/pdtsize/pdtsize','tPSZTitle')?></a></li>
                    <li class="active"><a><?php echo  language('product/pdtsize/pdtsize','tPSZTitleAdd')?></a></li>    
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtPsz').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>
<script src="<?= base_url('application/modules/product/assets/src/pdtsize/jPdtSize.js')?>"></script>