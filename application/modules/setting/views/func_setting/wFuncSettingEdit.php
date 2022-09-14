<div class="panel panel-headline">
    <div class="panel-heading">
        <section>

            <div class="row" id="odvFuncSettingAdvanceSearchContainer">
                <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12">
                    <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'เลือกระบบ'); ?></label>
                </div>
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <select 
                            onchange="JSxFuncSettingChangeSysAppAction()"
                            class="xWSelectSysApp form-control" 
                            id="ocmFuncSettingHDGhdApp" 
                            name="ocmFuncSettingHDGhdApp">
                            <?php foreach($aSystemApp as $oSysItem) { ?>
                                <option value='<?php echo $oSysItem->FTGhdApp; ?>'><?php echo $oSysItem->FTAppName; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 pull-right">
                    <div class="form-group text-right" style="width: 100%;">
                        <label class="xCNLabelFrm">&nbsp;</label>
                        <button id="oahFuncSettingAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn" style="width:20%" onclick="JSvFuncSettingCallPageList()"><?php echo language('common/main/main', 'tCancel'); ?></button>
                        <button id="oahFuncSettingAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width:20%" onclick="JSxCFuncSettingSaveEvent()"><?php echo language('common/main/main', 'tSave'); ?></button>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
    
    <div class="panel-body">
        <section id="odvContentFuncSettingList"></section>
    </div>
</div>

<!----- Begin Modal Confirm Change System App Type ---------------------------->
<div id="odvFuncSettingModalConfirmChangeSysApp" class="modal fade" data-backdrop="static" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tCMNConfirm') ?></label>
            </div>
            <div class="modal-body">
                <?php echo language('setting/funcsetting/funcsetting', 'tFuncSettingMsgConfirmChangeSysApp'); ?>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmChangeSysApp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button id="osmCancelChangeSysApp" class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>
<!----- End Modal Confirm Change System App Type ------------------------------>
<?php include('script/jFuncSettingEdit.php'); ?>
