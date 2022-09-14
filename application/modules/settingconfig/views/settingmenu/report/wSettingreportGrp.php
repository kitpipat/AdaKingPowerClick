<div id="odvSRTModalAddEditReportGrp" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label
                            class="xCNTextModalHeard"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingReportGroup'); ?></label>
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
                                    id="ofmSRTAddEditReportGrp">

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptName');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetSRTReportGrpModuleCode"
                                                data-menugrp="" name="oetSRTReportGrpModuleCode">
                                            <input type="text" class="form-control xWPointerEventNone"
                                                id="oetSRTReportGrpModuleName" name="oetSRTReportGrpModuleName"
                                                autocomplete="off"
                                                data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tModalModuleRptName');?>"
                                                readonly>
                                            <span class="input-group-btn">
                                                <button id="obtSRTBrowseModuleRpt" type="button"
                                                    class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpCode'); ?></label>
                                        <div class="form-group" id="odvSRTRptGrpCode">
                                            <div class="validate-input">
                                                <label class="fancy-checkbox">
                                                    <input type="checkbox" id="ocbSRTRptGrpCode" name="ocbSRTRptGrpCode"
                                                        checked="true" value="1">
                                                    <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                </label>
                                            </div>
                                        </div>
                                        <input type="hidden" id="ohdCheckDuplicateRptGrpCode"
                                            name="ohdCheckDuplicateRptGrpCode" value="1">
                                        <input type="hidden" id="ohdSeqMenuGrpRpt"
                                            name="ohdSeqMenuGrpRpt" value="">
                                        <input type="hidden" id="ohdMenuGrpCodeRpt"
                                            name="ohdMenuGrpCodeRpt" value="">
                                            
                                        <input type="text" class="form-control" maxlength="100" id="oetSRTRptGrpCode"
                                            name="oetSRTRptGrpCode"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpCode'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidMenuGrpCode'); ?>"
                                            data-validate-dublicateCode="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidRptGrpDupCode'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpName'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSRTRptGrpName"
                                            name="oetSRTRptGrpName"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpName'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidRptGrpName');?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpSeq'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSRTRptGrpSeq"
                                            name="oetSRTRptGrpSeq" data-menuseq=""
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpSeq'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidRptGrpSeq');?>">
                                    </div>
                                    <button type="submit" id="obtSRTModalRptGrpSubmit" style="display:none"></button>
                                </form>
                                <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                                    <div class="row">
                                        <div class="col-lg-12">
                                            <div class="btn-group pull-right" style="margin-bottom: 20px;">
                                                <button type="button" class="btn xCNBTNDefult"
                                                    style="margin-right:10px;" data-dismiss="modal">
                                                    <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalCancel'); ?></button>
                                                <button type="submit"
                                                    class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled"
                                                    onclick="$('#obtSRTModalRptGrpSubmit').click()"
                                                    id="obtSRTAddMenuGrp">
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
<?php include 'script/jSettingreportGrp.php';?>