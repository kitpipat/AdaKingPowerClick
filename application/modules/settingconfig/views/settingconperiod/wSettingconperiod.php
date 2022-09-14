<input id="oetLimStaBrowse" type="hidden" value="<?php echo $nLimBrowseType;?>">
<input id="oetLimCallBackOption" type="hidden" value="<?php echo $tLimBrowseOption;?>">


<?php if(isset($nLimBrowseType) && $nLimBrowseType == 0): ?>
    <div id="odvLimMainMenu" class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                         <?php FCNxHADDfavorite('settingconperiod/0/0');?> 
                        <li id="oliLimTitle" class="xCNLinkClick" onclick="JSvCallPageSetConperiodList()" style="cursor:pointer"><?php echo language('settingconfig/settingconperiod/settingconperiod','tSettingConperiodTitle')?></li> <!-- เปลี่ยน -->
                        <li id="oliLimTitleAdd" class="active"><a><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMTitleAdd')?></a></li>
                        <li id="oliLimTitleEdit" class="active"><a><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMTitleEdit')?></a></li>
                    </ol>
                </div>
                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 text-right p-r-0">
                    <div id="odvBtnLimInfo">
                         <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || $aAlwEventSettconpreiod['tAutStaAdd'] == 1) : ?>
                            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSvCallPageSetConperiodAdd()">+</button>
                         <?php endif;?>
                    </div>
                    <div id="odvBtnAddEdit">
                        <button onclick="JSvCallPageSetConperiodList()" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"> <?php echo language('common/main/main', 'tBack')?></button>    
                        <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || ($aAlwEventSettconpreiod['tAutStaAdd'] == 1 || $aAlwEventSettconpreiod['tAutStaEdit'] == 1)) : ?>
                        <div class="btn-group xCNHideBtnStaAlw">
                            <button type="submit" class="btn xWBtnGrpSaveLeft" onclick="$('#obtSubmitSettingConPeriod').click()"> <?php echo language('common/main/main', 'tSave')?></button>
                            <?php echo $vBtnSave?>
                        </div>
                        <?php endif; ?>
                    </div>   
                </div>
            </div>
        </div>
    </div>
    <div class="xCNMenuCump xCNLimBrowseLine" id="odvMenuCump">
        &nbsp;
    </div>
    <div class="main-content">
        <div id="odvContentPageLim" class="panel panel-headline">
        </div>
    </div>
<?php else: ?>
    <div class="modal-header xCNModalHead">
        <div class="row">
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
                <a onclick="JCNxBrowseData('<?php echo $tLimBrowseOption?>')" class="xWBtnPrevious xCNIconBack" style="float:left;">
                    <i class="fa fa-arrow-left xCNIcon"></i>	
                </a>
                <ol id="oliLimNavBrowse" class="breadcrumb xCNMenuModalBrowse">
                    <li class="xWBtnPrevious" onclick="JCNxBrowseData('<?php echo $tLimBrowseOption?>')"><a><?php echo language('common/main/main','tShowData');?> : <?php echo  language('settingconfig/settingconperiod/settingconperiod','tSettingConperiodTitle')?></a></li>
                    <li class="active"><a><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMTitleAdd')?></a></li>
                </ol>
            </div>
            <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 text-right">
                <div id="odvLimBtnGroup" class="demo-button xCNBtngroup" style="width:100%;">
                    <button type="button" class="btn xCNBTNPrimery" onclick="$('#obtSubmitSettingConPeriod').click()"><?php echo language('common/main/main', 'tSave')?></button>
                </div>
            </div>
        </div>
    </div>
    <div id="odvModalBodyBrowse" class="modal-body xCNModalBodyAdd">
    </div>

<?php endif;?>

<script src="<?php echo base_url(); ?>application/modules/settingconfig/assets/src/settingconperiod/jSettingconperiod.js"></script>