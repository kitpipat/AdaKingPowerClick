<div id="odvSRTModalAddEditReportMenu" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label
                            class="xCNTextModalHeard"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingReport_Menu'); ?></label>
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
                                    id="ofmSRTAddEditReportMenu">
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span>
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleRptName');?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide"
                                                    id="oetSRTReportGrpModMenuCode" data-menugrp=""
                                                    name="oetSRTReportGrpModMenuCode">
                                                <input type="text" class="form-control xWPointerEventNone"
                                                    id="oetSRTReportGrpModMenuName" name="oetSRTReportGrpModMenuName"
                                                    autocomplete="off"
                                                    data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tModalModuleRptName');?>"
                                                    readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtSRTBrowseModMenuRpt" type="button"
                                                        class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span>
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptGrpName');?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide"
                                                    id="oetSRTReportMenuGrpCode">
                                                <input type="text" class="form-control xWPointerEventNone"
                                                    id="oetSRTReportMenuGrpName" name="oetSRTReportMenuGrpName"
                                                    autocomplete="off"
                                                    data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tModalRptGrpName');?>"
                                                    readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtSRTBrowseGrpRpt" type="button"
                                                        class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span>
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenuCode'); ?></label>
                                            <div class="form-group" id="odvSRTRptMenuCode">
                                                <div class="validate-input">
                                                    <label class="fancy-checkbox">
                                                        <input type="checkbox" id="ocbSRTRptMenuCode"
                                                            name="ocbSRTRptMenuCode" checked="true" value="1">
                                                        <span><?php echo language('common/main/main', 'tGenerateAuto'); ?></span>
                                                    </label>
                                                </div>
                                            </div>
                                                                                        
                                            <input type="hidden" id="ohdCheckDuplicateRptMenuCode"
                                                name="ohdCheckDuplicateRptMenuCode" value="1">
                                            <input type="hidden" id="ohdSeqRptList"
                                                name="ohdSeqRptList" value="">
                                            <input type="hidden" id="ohdRptListCode"
                                                name="ohdRptListCode" value="">

                                            <input type="text" class="form-control" maxlength="100"
                                                id="oetSRTRptMenuCode" name="oetSRTRptMenuCode"
                                                placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenuCode'); ?>"
                                                autocomplete="off"
                                                data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidRptMenuCode'); ?>"
                                                data-validate-dublicateCode="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidRptMenuDupCode'); ?>">
                                        </div>
                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span>
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenuName'); ?></label>
                                            <input type="text" class="form-control" maxlength="100"
                                                id="oetSRTRptMenuName" name="oetSRTRptMenuName"
                                                placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenuName'); ?>"
                                                autocomplete="off"
                                                data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidRptMenuSeq');?>">
                                        </div>

                                        <div class="form-group">
                                            <label class="xCNLabelFrm"><span style="color:red">*</span>
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenuSeq'); ?></label>
                                            <input type="text" class="form-control" maxlength="100"
                                                id="oetSRTRptMenuSeq" name="oetSRTRptMenuSeq" data-menuseq=""
                                                placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenuSeq'); ?>"
                                                autocomplete="off"
                                                data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidRptMenuSeq');?>">
                                        </div>
                                    </div>


                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8">
                                        <div class="form-group">
                                            <label class="xCNLabelFrm">
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalReportRouteMenu'); ?></label>
                                            <input type="text" class="form-control" maxlength="100"
                                                id="oetSRTRptMenuUrl" name="oetSRTRptMenuUrl"
                                                placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalReportRouteMenu'); ?>">

                                        </div>

                                        <div class="form-group" style="margin-bottom: 0px;">
                                            <label class="xCNLabelFrm">
                                                <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalRptMenufilter');?></label>
                                            <div class="input-group">
                                                <input type="text" class="form-control xCNHide"
                                                    id="oetSRTReportMenuFilterCode">
                                                <input type="text" class="form-control xWPointerEventNone"
                                                    id="oetSRTReportMenuFilterName" name="oetSRTReportMenuFilterName"
                                                    readonly>
                                                <span class="input-group-btn">
                                                    <button id="obtSRTBrowseFilterRpt" type="button"
                                                        class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                                </span>
                                            </div>
                                        </div>
                                        <div style="white-space:nowrap;width:100%;overflow-x:auto;margin-bottom: 10px;">
                                            <div id="odvFilterShow" style="margin-bottom: 10px;margin-top: 10px;">
                                            </div>
                                        </div>
                                        <button type="submit" id="obtSRTModalRptMenuSubmit"
                                            style="display:none"></button>
                                    </div>
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
                                                    onclick="$('#obtSRTModalRptMenuSubmit').click()"
                                                    id="obtSRTAddMenuMenu">
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
<?php include 'script/jSettingReportMenu.php';?>