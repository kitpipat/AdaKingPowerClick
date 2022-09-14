<div class="panel panel-headline"> <!-- เพิ่ม -->
    <div class="panel-heading">
        <section>

            <div class="row" id="odvFuncSettingAdvanceSearchContainer">
                <div class="col-xs-12 col-md-12 col-lg-12 col-xl-12">
                    <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tCenterModalPDTConfirm'); ?></label>
                </div>
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <select 
                            onchange="JSvFuncSettingGetDataTableHD()"
                            class="selectpicker form-control" 
                            id="ocmFuncSettingHDGhdApp" 
                            name="ocmFuncSettingHDGhdApp">
                            <option value='0'><?php echo language('common/main/main', 'tCommonSysAll'); ?></option>
                            <?php foreach($aSystemApp as $oSysItem) { ?>
                                <option value='<?php echo $oSysItem->FTGhdApp; ?>'><?php echo $oSysItem->FTAppName; ?></option>
                            <?php } ?>
                        </select>
                    </div>
                </div>
                

                <!-- ซ่อน ตอน Demo ตาม Requirement Kubota -->
                
                <!-- <div class="col-xs-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <select 
                            onchange="JSvFuncSettingGetDataTableHD()"
                            class="selectpicker form-control" 
                            id="ocmFuncSettingHDGdtFuncLevel" 
                            name="ocmFuncSettingHDGdtFuncLevel">
                            <option value='0'><?php //echo language('common/main/main', 'tCommonLevelAll'); ?></option>
                            <?php //for($nLoop=1; $nLoop<=9; $nLoop++) { ?>
                                <option value='<?php //echo $nLoop; ?>'><?php //echo $nLoop; ?></option>
                            <?php //} ?>
                        </select>
                    </div>
                </div> -->
                
                <div class="col-xs-12 col-md-2 col-lg-2">
                    <div class="form-group">
                        <select 
                            onchange="JSvFuncSettingGetDataTableHD()"
                            class="selectpicker form-control" 
                            id="ocmFuncSettingHDGdtStaUse" 
                            name="ocmFuncSettingHDGdtStaUse">
                            <option value='0'><?php echo language('common/main/main', 'tCommonStaAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tCommonActive'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tCommonNotActive'); ?></option>
                        </select>
                    </div>
                </div>
                
                <div class="col-xs-12 col-sm-2 col-md-2 col-lg-2 col-xl-1 pull-right">
                    <div class="form-group" style="width: 100%;">
                            <?php if($aAlwEvent['tAutStaEdit']==1){ ?>
                        <label class="xCNLabelFrm">&nbsp;</label>
                        <button id="oahFuncSettingAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvFuncSettingCallPageEdit()"><?php echo language('common/main/main', 'tEdit'); ?></button>
                            <?php } ?>
                    </div>
                </div>
                
            </div>
        </section>
    </div>
    
    <div class="panel-body">
        <section id="odvContentFuncSettingList"></section>
    </div>
</div>
<?php include('script/jFuncSettingSearchList.php'); ?>








