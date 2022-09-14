<input id="oetFuncSettingStaBrowse" type="hidden" value="<?=$nBrowseType?>">
<input id="oetFuncSettingCallBackOption" type="hidden" value="<?=$tBrowseOption?>">

<div id="odvFuncSettingMainMenu" class="main-menu">
    <div class="xCNMrgNavMenu">
        <div class="row xCNavRow" style="width:inherit;">
            <div class="xCNFuncSettingVMaster">
                <div class="col-xs-12 col-md-8">
                    <ol id="oliMenuNav" class="breadcrumb">
                        <?php FCNxHADDfavorite('funcSetting/0/0');?> 
                        <li id="oliFuncSettingTitle" class="xCNLinkClick" onclick="JSvFuncSettingCallPageList()"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingTitle'); ?></li>
                        <li id="oliFuncSettingTitleEdit" class="active"><a href="javascript:;"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingTitleEdit'); ?></a></li>
                    </ol>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="xCNMenuCump xCNFuncSettingBrowseLine" id="odvMenuCump">&nbsp;</div>

<div class="main-content">
    <div id="odvContentPageFuncSetting"></div>
</div>

<script type="text/javascript" src="<?php echo base_url('application/modules/setting/assets/src/func_setting/jFuncSetting.js'); ?>"></script>
