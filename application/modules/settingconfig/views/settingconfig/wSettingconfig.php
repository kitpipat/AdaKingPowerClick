<input id="oetSettingConfigStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetSettingConfigCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvSettingConfigMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNSettingConfigVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('SettingConfig/0/0');?>
                        <li id="oliSettingConfigTitle" class="xCNLinkClick" onclick="JSvSettingConfigCallPageList()"><?php echo language('settingconfig/settingconfig/settingconfig', 'tSettingConfigTitle'); ?></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNSettingConfigBrowseLine" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvContentPageSettingConfig"></div>
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/settingconfig/assets/src/settingconfig/jSettingConfig.js'); ?>"></script>
