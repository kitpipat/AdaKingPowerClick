<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-body"> <!-- เพิ่ม -->
        <section id="ostSearchRecive">
            <div class="row">
                <div class="col-lg-6  col-md-6 col-xs-12">
                    <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                        <label class="xCNLabelFrm"><?php echo language('common/main/main','tSearch'); ?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" placeholder="<?php echo language('common/main/main','tSearch'); ?>" onkeypress="Javascript:if(event.keyCode==13) JSvCardShiftOutCardShiftOutDataTable()">
                            <span class="input-group-btn">
                                <button id="oimSearchCardShiftOut" class="btn xCNBtnSearch" type="button" onclick="JSvCardShiftOutCardShiftOutDataTable()">
                                    <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                                <a id="oahCardShiftOutAdvanceSearch" style="margin-left: 10px;" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                                <a id="oahCardShiftOutSearchReset" style="margin-left: 1px;" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxCardShiftOutClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row hidden" id="odvCardShiftOutAdvanceSearchContainer" style="margin-bottom: 20px;">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftOutSearchDocDateFrom" 
                                    id="oetCardShiftOutSearchDocDateFrom" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardout', 'tCardShiftOutFrom'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftOutSearchDocDateFrom').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftOutSearchDocDateTo" 
                                    id="oetCardShiftOutSearchDocDateTo" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardout', 'tCardShiftOutTo'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftOutSearchDocDateTo').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutTBDocStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftOutStaDoc" name="ocmCardShiftOutStaDoc">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='1'><?php echo language('document/card/cardout','tCardShiftOutTBComplete'); ?></option>
                            <option value='2'><?php echo language('document/card/cardout','tCardShiftOutTBIncomplete'); ?></option>
                            <option value='3'><?php echo language('document/card/cardout','tCardShiftOutTBCancel'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardout','tCardShiftOutTBApproveStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftOutStaApprove" name="ocmCardShiftOutStaApprove">
                            <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                            <option value='3'><?php echo language('document/card/cardout','tCardShiftOutTBPending'); ?></option>
                            <option value='2'><?php echo language('document/card/cardout','tCardShiftOutTBProcessing'); ?></option>
                            <option value='1'><?php echo language('document/card/cardout','tCardShiftOutTBApproved'); ?></option>
                            <option value='4'><?php echo language('document/card/cardout','N/A'); ?></option>
                        </select>
                    </div>
                </div>
                <div class="col-lg-12">
                    <a id="oahCardShiftOutAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvCardShiftOutCardShiftOutDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
                </div>
            </div>
        </section>
    </div>

    <div class="panel-heading">
		<div class="row">
            <div class="col-xs-8 col-md-4 col-lg-4"></div>
            
            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                <div class="col-xs-12 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                            <?= language('common/main/main','tCMNOption')?>
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li id="oliBtnDeleteAll" class="disabled">
                                <a href="javascript:;" onclick="JSxCardShiftOutDelChoose()"><?= language('common/main/main','tDelAll')?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
		</div>
	</div>

    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataCardShiftOut"></section>
        <!-- End DataTable-->
    </div>
</div>

<?php include 'script/jCardShiftOutList.php'; ?>



