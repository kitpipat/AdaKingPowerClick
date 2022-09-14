<?php if(!$bIsApvOrCancel) { ?>
    <div class="row">
        <div class="col-md-12">
            <button 
            class="xCNBTNPrimeryPlus pull-right" 
            id="obtPromotionStep1AddGroupNameBtn" 
            data-backdrop="static" 
            data-keyboard="false" 
            type="button" 
            data-toggle="modal" 
            data-target="#odvPromotionAddPmtGroupModal" 
            style="margin-bottom: 10px;">+</button>
        </div>
    </div>
<?php } ?>

<div class="row">
    <div class="col-md-12">
        <div id="odvPromotionPmtPdtDtGroupNameDataTable"></div>
    </div>
</div>

<!-- Begin Add PDT Promotion Group -->
<div class="modal fade" id="odvPromotionAddPmtGroupModal" tabindex="-1" role="dialog" aria-hidden="true" style="overflow: scroll;">
    <div class="modal-dialog" style="width: 100%;width: 85%;margin: 1.75rem auto;top: 0%;">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/promotion/promotion', 'tPromotionGroup_Create'); ?></h5>
                <!-- <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button> -->
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="btn-group pull-right" style="margin-bottom: 20px;">
                            <button onclick="JCNvPromotionStep1BtnCancelCreateGroupName()" type="button" class="btn xCNBTNDefult" data-dismiss="modal" style="margin-right:10px;">
                                <?php echo language('common/main/main', 'tCancel'); ?>
                            </button>
                            <button onclick="JCNvPromotionStep1ConfirmToSave()" type="button" class="btn xCNBTNPrimery xCNAddPmtGroupModalCanCelDisabled">
                                <?php echo language('common/main/main', 'tSave'); ?>
                            </button>
                        </div>
                    </div>
                </div>
                <!-- Begin PDT Table -->
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tGroupName'); ?></label>
                            <input 
                            type="text" 
                            class="form-control xCNAddPmtGroupModalCanCelDisabled" 
                            id="oetPromotionGroupNameTmp" 
                            name="oetPromotionGroupNameTmp" 
                            maxlength="50" 
                            value="<?php echo $tRefExt ?>">
                            <input type="hidden" value="" name="ohdPromotionGroupNameTmpOld" id="ohdPromotionGroupNameTmpOld">
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tGroupType'); ?></label>
                            <select class="selectpicker form-control xCNAddPmtGroupModalCanCelDisabled" id="ocmPromotionGroupTypeTmp" name="ocmPromotionGroupTypeTmp">
                                <option value='1'><?php echo language('document/promotion/promotion', 'tJoiningGroup'); ?></option>
                                <option value='2'><?php echo language('document/promotion/promotion', 'tExclusionGroup'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tItemType'); ?></label>
                            <select class="selectpicker form-control xCNAddPmtGroupModalCanCelDisabled" id="ocmPromotionListTypeTmp" name="ocmPromotionListTypeTmp">
                                <?php foreach($aPdtCond as $aPdtCondItem) { ?>
                                    <?php if($aPdtCondItem['FTPmtStaUse'] != "1"){continue;}?>
                                    <option
                                    class="xCNPdtCond<?php echo $aPdtCondItem['FNPmtID']; ?>"
                                    data-id="<?php echo $aPdtCondItem['FNPmtID']; ?>" 
                                    data-ref-code="<?php echo $aPdtCondItem['FTPmtRefCode']; ?>"
                                    data-ref-pdt="<?php echo $aPdtCondItem['FTPmtRefPdt']; ?>"
                                    data-sub-ref="<?php echo $aPdtCondItem['FTPmtSubRef']; ?>"
                                    data-sub-ref-pdt="<?php echo $aPdtCondItem['FTPmtSubRefPdt']; ?>"
                                    data-sta-use="<?php echo $aPdtCondItem['FTPmtStaUse']; ?>"
                                    data-drop-name="<?php echo $aPdtCondItem['FTDropName']; ?>"
                                    data-ref-n="<?php echo $aPdtCondItem['FTPmtRefN']; ?>"
                                    data-sub-ref-n="<?php echo $aPdtCondItem['FTPmtSubRefN']; ?>"
                                    data-sub-ref-n-title="<?php echo $aPdtCondItem['FTSubRefNTitle']; ?>"
                                    value='<?php echo $aPdtCondItem['FNPmtID']; ?>'><?php echo $aPdtCondItem['FTDropName']; ?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <input type="hidden" value="" name="ohdPromotionBrandCodeTmp" id="ohdPromotionBrandCodeTmp">
                    <input type="hidden" value="" name="ohdPromotionBrandNameTmp" id="ohdPromotionBrandNameTmp">
                    
                    <div class="col-md-6">
                        <!-- Import Excel -->
                        <label class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tPMTImportForExcel'); ?></label> 
                        <a href="<?php echo base_url('application/modules/document/assets/src/promotion/Promotion_Import_Template.xlsx'); ?>"><u><?php echo language('document/promotion/promotion', 'Template download.'); ?></u></a>
                        <div class="form-group pull-left">
                            <div class="input-group">
                                <input 
                                type="text" 
                                class="form-control xCNAddPmtGroupModalCanCelDisabled" 
                                id="oetPromotionStep1PmtFileName" 
                                name="oetPromotionStep1PmtFileName" 
                                placeholder="เลือกไฟล์" 
                                readonly="">
                                <input 
                                type="file" 
                                class="form-control" 
                                style="visibility: hidden; position: absolute;" 
                                id="oefPromotionStep1PmtFileExcel" 
                                name="oefPromotionStep1PmtFileExcel" 
                                onchange="JSxPromotionStep1SetImportFile(this, event)" 
                                accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel">
                                <span class="input-group-btn">
                                    <button type="button" class="btn btn-primary xCNPromotionStep1BtnShooseFile xCNAddPmtGroupModalCanCelDisabled" style="border-radius: 0px 5px 5px 0px;" onclick="$('#oefPromotionStep1PmtFileExcel').click()">
                                        <?php echo language('common/main/main', 'tSelectedImport'); ?>                                                            
                                    </button>
                                </span>
                                <span class="input-group-btn">
                                    <button 
                                    id="obtPromotionStep1ImportFile" 
                                    type="button" 
                                    class="btn btn-success xCNAddPmtGroupModalCanCelDisabled" 
                                    style="margin-left: 10px; border-radius: 5px;" 
                                    onclick="JSxPromotionStep1ConfirmImportFile()" 
                                    disabled>
                                        <?php echo language('common/main/main', 'tTitleTempalateImport'); ?>
                                    </button>
                                </span>
                                <span class="input-group-btn">
                                    <!-- ทั้งร้าน -->
                                    <label class="fancy-checkbox pull-left" style="width:auto; margin-left: 20px;">
                                        <input 
                                        type="checkbox" 
                                        class="xCNAddPmtGroupModalCanCelDisabled" 
                                        value="1" 
                                        id="ocbPromotionPmtPdtDtShopAll" 
                                        name="ocbPromotionPmtPdtDtShopAll"
                                        maxlength="1">
                                        <span>&nbsp;</span>
                                        <span class="xCNLabelFrm"><?php echo language('document/promotion/promotion', 'tUseTheWholeStore'); ?></span>
                                    </label> 
                                    <!-- ทั้งร้าน -->
                                </span>
                            </div>
                        </div>
                        <!-- Import Excel -->
                    </div>

                    <div class="col-md-6">
                        <label class="xCNLabelFrm">&nbsp;</label>
                        <div class="clear-fix"></div>
                        
                        <!-- Add Btn -->
                        <button class="xCNBTNPrimeryPlus pull-right xCNPromotionStep1BtnBrowse xCNAddPmtGroupModalCanCelDisabled" onclick="JCNvPromotionStep1Browse()" type="button" style="margin-bottom: 10px;">+</button>
                        <!-- Add Btn -->

                        <!-- Options -->
                        <div class="btn-group xCNDropDrownGroup pull-right" style="margin-right: 20px;">
                            <button type="button" class="btn xCNBTNMngTable xCNPromotionStep1BtnDropDrownOption xCNAddPmtGroupModalCanCelDisabled" data-toggle="dropdown" aria-expanded="false">
                            <?php echo language('document/promotion/promotion', 'tOptions'); ?> <span class="caret"></span>
                            </button>
                            <ul class="dropdown-menu" role="menu">
                                <li>
                                    <a class="xCNPromotionStep1BtnDeleteMore"><?php echo language('document/promotion/promotion', 'tDeleteAll'); ?></a>
                                </li>
                            </ul>
                        </div>
                        <!-- Options -->
                    </div>

                    <div class="col-md-12"><div id="odvPromotionPmtDtTableTmp" style="overflow: scroll; max-height: 500px;"></div></div>
                </div>
                <!-- End PDT Table -->
            </div>
            <!-- <div class="modal-footer"></div> -->
        </div>
    </div>
</div>
<!-- End Add PDT Promotion Group -->
    
<?php include_once('script/jStep1.php'); ?>