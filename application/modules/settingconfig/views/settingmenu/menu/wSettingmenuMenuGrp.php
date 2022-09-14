<!-- View Modal Add/Edit MenuGrp -->
<div id="odvSMPModalAddEditMenuGrp" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <div class="row">
                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
                        <label
                            class="xCNTextModalHeard"><?php echo language('settingconfig/settingmenu/settingmenu', 'tSettingMenuGroup'); ?></label>
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
                                    id="ofmSMPAddEditMenuGrp">

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalModuleName');?></label>
                                        <div class="input-group">
                                            <input type="text" class="form-control xCNHide" id="oetSMPMenuGrpModuleCode" data-menugrp=""
                                                name="oetSMPMenuGrpModuleCode">
                                            <input type="text" class="form-control xWPointerEventNone"
                                                id="oetSMPMenuGrpModuleName" name="oetSMPMenuGrpModuleName"
                                                autocomplete="off"
                                                data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidModuleName');?>"
                                                readonly>
                                            <span class="input-group-btn">
                                                <button id="oimSMPBrowseModule" type="button"
                                                    class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                                            </span>
                                        </div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpCode'); ?></label>
                                        <input type="hidden" id="ohdCheckDuplicateMenuGrpCode"
                                            name="ohdCheckDuplicateMenuGrpCode" value="1">
                                        <input type="hidden" id="ohdSeqMenuGrp"
                                            name="ohdSeqMenuGrp" value="">
                                        <input type="hidden" id="ohdMenuGrpCode"
                                            name="ohdMenuGrpCode" value="">
                                        <input type="text" class="form-control" maxlength="100" id="oetSMPMenuGrpCode"
                                            name="oetSMPMenuGrpCode"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpCode'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidMenuGrpCode'); ?>"
                                            data-validate-dublicateCode="<?php echo language('settingconfig/settingmenu/settingmenu', 'tValidMenuGrpDupCode'); ?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpName'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSMPMenuGrpName"
                                            name="oetSMPMenuGrpName"
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpName'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidMenuGrpName');?>">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><span style="color:red">*</span>
                                            <?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpSeq'); ?></label>
                                        <input type="text" class="form-control" maxlength="100" id="oetSMPMenuGrpSeq"
                                            name="oetSMPMenuGrpSeq" data-menuseq=""
                                            placeholder="<?php echo language('settingconfig/settingmenu/settingmenu', 'tModalMenuGrpSeq'); ?>"
                                            autocomplete="off"
                                            data-validate-required="<?php echo language('settingconfig/settingmenu/settingmenu','tValidMenuGrpSeq');?>">
                                    </div>
                                    <button type="submit" id="obtSMPModalMenuGrpSubmit" style="display:none"></button>
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
                                                    onclick="$('#obtSMPModalMenuGrpSubmit').click()"
                                                    id="obtSMPAddMenuGrp">
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
<?php include 'script/jSettingmenuMenuGrp.php';?>