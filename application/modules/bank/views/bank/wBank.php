<input id="oetBnkStaBrowse" type="hidden" value="<?=$nBnkBrowseType?>">
<input id="oetBnkCallBackOption" type="hidden" value="<?=$tBnkBrowseOption?>">

<?php if(isset($nBnkBrowseType) && $nBnkBrowseType == 0) : ?>
    <div id="odvBnkMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBnkVMaster">
                    <div class="col-xs-12 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <?php FCNxHADDfavorite('bankindex/0/0');?>
                            <li id="oliBnkTitle" class="xCNLinkClick" onclick="JSvCallPageBnkList()" style="cursor:pointer"><?= language('bank/bank/bank','tBNKTitle')?></li> <!-- เปลี่ยน -->
                            <li id="oliBnkTitleAdd" class="active"><a><?= language('bank/bank/bank','tBNKTitleAdd')?></a></li>
                            <li id="oliBnkTitleEdit" class="active"><a><?= language('bank/bank/bank','tBNKTitleEdit')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-4 text-right p-r-0">
                        <div id="odvBtnBnkInfo">
                            <?php if($aAlwEventBank['tAutStaFull'] == 1 || $aAlwEventBank['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageBnkAdd()">+</button>
                            <?php endif;?>
                        </div>
                        <div id="odvBtnAddEdit">
                            <div class="demo-button xCNBtngroup" style="width:100%;">
                                <button onclick="JSvCallPageBnkList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>
                                <?php if($aAlwEventBank['tAutStaFull'] == 1 || ($aAlwEventBank['tAutStaAdd'] == 1 || $aAlwEventBank['tAutStaEdit'] == 1)) : ?>
                                <div class="btn-group">
                                    <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="JSxSetStatusClickBnkSubmit();$('#obtSubmitBnk').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                                    <?php echo $vBtnSave?>
                                </div>
                                <?php endif;?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="xCNBnkVBrowse">
                    <div class="col-xs-12 col-md-6">
                        <a onclick="JCNxBrowseData('<?php echo $tBnkBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;font-size:19px;">
                            <i class="fa fa-arrow-left xCNBackBowse"></i>
                        </a>
                        <ol id="oliPunNavBrowse" class="breadcrumb xCNBCMenu" style="margin-left:25px">
                            <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBnkBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo language('bank/bank/bank','tBNKTitle')?></a></li>
                            <li class="active"><a><?php echo  language('bank/bank/bank','tBNKTitleAdd')?></a></li>
                        </ol>
                    </div>
                    <div class="col-xs-12 col-md-6 text-right">
                        <div id="odvPunBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                            <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitBnk').click()"><?php echo  language('common/main/main', 'tSave')?></button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNBnkBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageBank"  class="panel panel-headline"> </div>
    </div>
<?php else :?>
	<div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tBnkBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>
                </a>
                <ol id="oliBchNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tBnkBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('bank/bank/bank','tBNKTitle')?></a></li>
                    <li class="active"><a><?php echo language('bank/bank/bank','tBNKTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvBchBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitBnk').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd"></div>
<?php endif;?>
<script src="<?= base_url('application/modules/bank/assets/src/bank/jBank.js')?>"></script>
