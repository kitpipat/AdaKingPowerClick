<input id="oetSettingMenuStaBrowse" type="hidden" value="<?=$nSettingMenuBrowseType?>">
<input id="oetSettingMenuCallBackOption" type="hidden" value="<?=$tSettingMenuBrowseOption?>">

<div id="odvSMUSettingMenuMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNDpcDisVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                    <?php FCNxHADDfavorite('settingmenu/0/0');?>
                        <li id="oliDpcDisTitle" class="xCNLinkClick" onclick="JSxSMUSettingMenuCallPage()"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuAndReportTitle'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNSettingConfigBrowseLine" id="odvMenuCump">&nbsp;</div>
<div class="main-content">
    <div id="odvSMUContentPageSettingMenu">
    </div>
    <div id="odvSMUContentPageSettingReport">
    </div>
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/settingconfig/assets/src/settingmenu/jSettingmenu.js'); ?>"></script>