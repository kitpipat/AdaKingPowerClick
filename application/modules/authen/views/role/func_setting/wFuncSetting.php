<style>
    .xCNRoleFuncSettingTableResponsive{
        height: 500px;
        max-height: 500px;
        overflow: scroll;
    }
</style>
<div class="panel panel-default" style="margin-top: 10px;">
    <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
        <label class="xCNTextDetail1"><?php echo language('setting/funcsetting/funcsetting', 'tROLFunction'); ?></label>
    </div>

    <div class="panel-collapse collapse in" role="tabpanel">
        <div class="panel-body xCNPDModlue">
            <div class="row">
                <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
                    <div class="form-group" id="odvRoleFuncSearchAll">
                        <input 
                        type="text" 
                        class="form-control xCNInputWithoutSingleQuote" 
                        id="oetRoleFuncSearchAll" 
                        name="oetRoleFuncSearchAll"
                        autocomplete="off"
                        onkeyup="JSvRoleFnSearchHTML()"
                        placeholder="<?=language('common/main/main', 'tSearch'); ?>">
                    </div>
                </div>
                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                    <div class="table-responsive xCNRoleFuncSettingTableResponsive">
                        <table class="table table-striped xCNRoleFuncSettingTable">
                            <thead>
                                <tr class="xCNCenter">
                                    <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingSeq'); ?></th>
                                    <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingSys'); ?></th>
                                    <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingFuncGroup'); ?></th>
                                    <th class="xCNTextBold"><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingFunc'); ?></th>
                                    <th class="xCNTextBold">
                                        <label class="fancy-checkbox">
                                            <input 
                                            class="xCNRoleFuncSettingPermissionItemAll" 
                                            type="checkbox">
                                            <span><?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingOptDocAlw'); ?></span>
                                        </label>
                                    </th>
                                </tr>
                            </thead>
                            <tbody class="xCNRoleFuncSettingBody">
                                <?php if ($aDataFuncSettingList['rtCode'] == 1) : ?>
                                    <?php $tBreakPoint = '' ?>
                                    <?php foreach ($aDataFuncSettingList['raItems'] as $nKey => $aValue) : ?>
                                        <tr class="text-center xCNTextDetail2 xCNRoleFuncSettingItems">
                                            <td class="text-center"><?php echo $nKey+1; ?></td>
                                            <td class="text-left"><?php echo (!empty($aValue['FTAppName'])) ? $aValue['FTAppName']   : '' ?></td>
                                            <td class="text-left"><?php echo (!empty($aValue['FTKbdScreen'])) ? $aValue['FTKbdScreen']   : '' ?></td>
                                            <td class="text-left"><?php echo (!empty($aValue['FTGdtName'])) ? $aValue['FTGdtName'] : '' ?></td>
                                            <td class="text-center">
                                                <label class="fancy-checkbox">
                                                <input
                                                <?php echo ($aValue['FTUfrStaAlw'] == "1")? 'checked':''; ?> 
                                                class="xCNRoleFuncSettingPermissionItem" 
                                                type="checkbox" 
                                                data-ghd-app="<?php echo $aValue['FTGhdApp']; ?>" 
                                                data-ghd-code="<?php echo isset($aValue['FTGhdCode'])?$aValue['FTGhdCode']:''; ?>" 
                                                data-sys-code="<?php echo $aValue['FTSysCode']; ?>">
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
<?php include('script/jFuncSetting.php'); ?>