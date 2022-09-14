<input id="oetCtyStaBrowse" type="hidden" value="<?=$nCtyBrowseType?>">
<input id="oetCtyCallBackOption" type="hidden" value="<?=$tCtyBrowseOption?>">

<?php if(isset($nCtyBrowseType) && $nCtyBrowseType == 0) : ?>
    <div id="odvCtyMainMenu" class="main-menu"> <!-- เปลี่ยน -->
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb"> <!-- เปลี่ยน -->
                        <?php FCNxHADDfavorite('cardtype/0/0');?> 
                        <li id="oliCtyTitle" class="xCNLinkClick" onclick="JSvCallPageCardTypeList()" style="cursor:pointer"><?php echo language('payment/cardtype/cardtype','tCTYTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliCtyTitleAdd" class="active"><a><?php echo language('payment/cardtype/cardtype','tCTYTitleAdd')?></a></li>
                        <li id="oliCtyTitleEdit" class="active"><a><?php echo language('payment/cardtype/cardtype','tCTYTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0"> <!-- เปลี่ยน -->
                    <div id="odvBtnCtyInfo">
                        <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || $aAlwEventCardtype['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageCardTypeAdd()">+</button>
                        <?php endif; ?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <div class="demo-button xCNBtngroup" style="width:100%;">
                        <button onclick="JSvCallPageCardTypeList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                        <?php if($aAlwEventCardtype['tAutStaFull'] == 1 || ($aAlwEventCardtype['tAutStaAdd'] == 1 || $aAlwEventCardtype['tAutStaEdit'] == 1)) : ?>
                            <div class="btn-group">
                                <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitCardType').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                                <?php echo $vBtnSave?>
                            </div>
                        </div>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNCtyBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageCardType" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tCtyBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliPvnNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tCtyBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('payment/cardtype/cardtype','tCTYTitle')?></a></li>
                    <li class="active"><a><?php echo language('payment/cardtype/cardtype','tCTYTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvPvnBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitCardType').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>
<?php endif;?>

<script src="<?= base_url('application/modules/payment/assets/src/cardtype/jCardType.js')?>"></script>