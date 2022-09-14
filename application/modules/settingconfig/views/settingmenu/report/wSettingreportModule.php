<!-- View Modal Add/Edit Module -->
<div id="odvSRTModalAddEditModuleReport" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label
                            class="xCNTextModalHeard"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingReportModule'); ?></label>
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
                                    id="ofmSRTAddEditModuleReport">
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptCode'); ?></label>
                                        <div class="form-group" id="odvSRTRptModCode">
                                            <div class="validate-input">
                                                <label class="fancy-checkbox">
                                                    <input type="checkbox" id="ocbSRTRptModCode" name="ocbSRTRptModCode"
                                                        checked="true" value="1">
                                                    <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ohdCheckDuplicateModuleRptCode"
                                            name="ohdCheckDuplicateModuleRptCode" value="1">
                                        <input type="hidden" id="ohdSeqModuleRpt"
                                            name="ohdSeqModuleRpt" value="">
                                        <input type="hidden" id="ohdModuleCodeRpt"
                                            name="ohdModuleCodeRpt" value="">
                                        <input type="text" class="form-control" maxlength="100" id="oetSRTModuleRptCode"
                                            name="oetSRTModuleRptCode"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptCode'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidModuleRptCode'); ?>"
                                            data-validate-dublicateCode="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidModuleRptDupCode'); ?>">
                                    </div>
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptName'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSRTModuleName"
                                            name="oetSRTModuleName"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptName'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidModuleRptName');?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm">
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalReportRouteName'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSRTModuleUrl"
                                            name="oetSRTModuleUrl"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalReportRouteName'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptSeq'); ?></label>
                                        <input type="number" class="form-control" maxlength="100" id="oetSRTModuleSeq"
                                            min="1" name="oetSRTModuleSeq"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptSeq'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidModuleRptSeq');?>">
                                    </div>

                                    <button type="submit" id="obtSRTModalSubmit" style="display:none"></button>
                                </form>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="btn-group pull-right" style="margin-bottom: 20px;">
                                                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"
                                                    aria-label="Close" style="margin-right:10px;">
                                                    <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuCancel'); ?></button>
                                                <button type="submit"
                                                    class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled"
                                                    onclick="$('#obtSRTModalSubmit').click()" id="obtSRTAddModule">
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
<?php include 'script/jSettingreportModule.php';?>