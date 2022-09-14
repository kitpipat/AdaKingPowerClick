<!-- View Modal Add/Edit Module -->
<div id="odvSMPModalAddEditModule" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label
                            class="xCNTextModalHeard"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuModule'); ?></label>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 text-right">
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close"
                            style="color:#FFF;opacity:1;margin-top:-11px;">
                            <span aria-hidden="true" style="font-size: 30px !important;">×</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="modal-body">
                <div class="panel-body" style="padding:10px">
                    <div class="row">
                        <div class="col-xs-12">
                            <div class="row">
                                <form action="javascript:void(0);" class="validate-form" method="post"
                                    id="ofmSMPAddEditModule">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleCode'); ?></label>
                                        <input type="hidden" id="ohdCheckDuplicateModuleCode"
                                            name="ohdCheckDuplicateModuleCode" value="1">
                                            <input type="hidden" id="ohdSeqModule"
                                            name="ohdSeqModule" value="">
                                            <input type="hidden" id="ohdModuleCode"
                                            name="ohdModuleCode" value="">
                                        <input type="text" class="form-control" maxlength="100" id="oetSMPModuleCode"
                                            name="oetSMPModuleCode"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleName'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidModuleCode'); ?>"
                                            data-validate-dublicateCode="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidModuleDupCode'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleName'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSMPModuleName"
                                            name="oetSMPModuleName"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleName'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidModuleName');?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm">
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModulePathIcon'); ?></label>
                                        <input type="text" class="form-control" maxlength="100"
                                            id="oetSMPModulePathIcon" name="oetSMPModulePathIcon"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModulePathIcon'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleSeq'); ?></label>
                                        <input type="number" class="form-control" maxlength="100" id="oetSMPModuleSeq"
                                            min="2" name="oetSMPModuleSeq"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleSeq'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidModuleSeq');?>">
                                    </div>

                                    <button type="submit" id="obtSMPModalSubmit" style="display:none"></button>
                                </form>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="btn-group pull-right" style="margin-bottom: 20px;">
                                                <button type="button" class="btn xCNBTNDefult"
                                                    style="margin-right:10px;" onclick="JSxSMUSMPCancelModal()">
                                                    <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuCancel'); ?></button>
                                                <button type="submit"
                                                    class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled"
                                                    onclick="$('#obtSMPModalSubmit').click()" id="obtSMPAddModule">
                                                    <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalSave'); ?></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php include 'script/jSettingmenuModule.php';?>
<script>

</script>