<input id="oetPgpStaBrowse" type="hidden" value="<?php echo $nPgpBrowseType?>">
<input id="oetPgpCallBackOption" type="hidden" value="<?php echo $tPgpBrowseOption?>">

<?php if(isset($nPgpBrowseType) && $nPgpBrowseType == 0) : ?>
    <div id="odvPgpMenuTitle" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNPgpVMaster">
                    <div class="col-xs-12 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('pdtgroup/0/0');?> 
                            <li id="oliPgpTitle" class="xCNLinkClick" onclick="JSvCallPagePdtGroupList()" style="cursor:pointer"><?php echo language('product/pdtgroup/pdtgroup','tPGPTitle')?></li>
                            <li id="oliPgpTitleAdd" class="active"><a><?php echo language('product/pdtgroup/pdtgroup','tPGPTitleAdd')?></a></li>
                            <li id="oliPgpTitleEdit" class="active"><a><?php echo language('product/pdtgroup/pdtgroup','tPGPTitleEdit')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnPgpInfo">
                            <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || $aAlwEventPdtGroup['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPagePdtGroupAdd()">+</button>
                            <?php endif; ?>
                        </div>
                        <div id="odvBtnAddEdit" style="margin-top:3px">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPagePdtGroupList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                <?php if($aAlwEventPdtGroup['tAutStaFull'] == 1 || ($aAlwEventPdtGroup['tAutStaAdd'] == 1 || $aAlwEventPdtGroup['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickPdtGroupSubmit();$('#obtSubmitPdtGroup').click();"> <?php echo language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="xCNPgpVBrowse">
                    <div class="col-xs-12 col-md-6">
                        <a onclick="JCNxBrowseData('<?php echo $tPgpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                            <i class="fa fa-arrow-left xCNBackBowse"></i>	
                        </a>
                        <ol id="oliPgpNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                            <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPgpBrowseOption?>')"><a>แสดงข้อมูล : <?php echo language('product/pdtgroup/pdtgroup','tPGPTitle')?></a></li>
                            <li class="active"><a><?php echo  language('product/pdtunit/pdtunit','tPGPTitleAdd')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-6 text-right">
                        <div id="odvPgpBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                            <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitPdtGroup').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                        </div>
                    </div>
                </div> -->
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNPgpBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPagePdtGroup"></div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tPgpBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPgpNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tPgpBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?= language('product/pdtgroup/pdtgroup','tPGPTitle')?></a></li>
                    <li class="active"><a><?= language('product/pdtgroup/pdtgroup','tPGPTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="JSxSetStatusClickPdtGroupSubmit();$('#obtSubmitPdtGroup').click();"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>
<script src="<?php echo  base_url('application/modules/product/assets/src/pdtgroup/jPdtGroup.js')?>"></script>

