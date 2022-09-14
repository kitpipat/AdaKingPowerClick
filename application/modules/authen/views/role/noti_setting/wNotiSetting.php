<style>
    .xCNRoleNotiSettingTableResponsive{
        height: 150px;
        max-height: 500px;
        overflow: scroll;
    }
</style>
<div class="panel panel-default" style="margin-top: 10px;">
    <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
        <label class="xCNTextDetail1"><?php echo language('setting/funcsetting/funcsetting', 'ตั้งค่าแจ้งเตือน'); ?></label>
    </div>

    <div class="panel-collapse collapse in" role="tabpanel">
        <div class="panel-body xCNPDModlue">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group">
                        <input 
                        type="text" 
                        class="form-control xCNInputWithoutSingleQuote" 
                        id="oetRoleNotiSearchAll" 
                        name="oetRoleNotiSearchAll"
                        autocomplete="off" 
                        onkeyup="JSvRoleNotiSearchHTML()"
                        placeholder="<?=language('common/main/main', 'tSearch'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="table-responsive xCNRoleNotiSettingTableResponsive">
                        <table class="table table-striped xCNRoleNotiSettingTable">
                            <thead>
                                <tr class="xCNCenter">
                                    <th class="xCNTextBold" width="15%"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingSeq'); ?></th>
                                    <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tNotSettingType'); ?></th>
                                    <th class="xCNTextBold" width="15%">
                                        <label class="fancy-checkbox">
                                            <input 
                                            class="xCNRoleNotiSettingPermissionItemAll" 
                                            type="checkbox">
                                            <span><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingOptDocAlw'); ?></span>
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="xCNRoleNotiSettingBody">
                                <?php if ($aDataNotiSettingList['rtCode'] == 1) : ?>
                                    <?php $tBreakPoint = '' ?>
                                    <?php foreach ($aDataNotiSettingList['raItems'] as $nKey => $aValue) : ?>
                                        <tr class="text-center xCNTextDetail2 xCNRoleNotiSettingItems">
                                            <td class="text-center"><?php echo $nKey+1; ?></td>
                                            <td class="text-left"><?php echo (!empty($aValue['FTNotTypeName'])) ? $aValue['FTNotTypeName'] : '' ?></td>
                                            <td class="text-center">
                                                <label class="fancy-checkbox">
                                                <input
                                                <?php echo ($aValue['FTRptCode'] != "")? 'checked':''; ?> 
                                                class="xCNRoleNotiSettingPermissionItem" 
                                                type="checkbox" 
                                                data-notcode="<?php echo $aValue['FTNotCode']; ?>" 
                                                >
                                                    <span></span>
                                                </label>
                                            </td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php include('script/jNotiSetting.php'); ?>