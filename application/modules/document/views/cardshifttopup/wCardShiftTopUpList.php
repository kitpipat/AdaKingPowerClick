<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-heading"> <!-- เพิ่ม -->
        <section id="ostSearchRecive">
            <div class="row">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                        <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" placeholder="<?= language('common/main/main','tSearch')?>" onkeypress="Javascript:if(event.keyCode==13) JSvCardShiftTopUpCardShiftTopUpDataTable()">
                            <span class="input-group-btn">
                                <button id="oimSearchCardShiftTopUp" class="btn xCNBtnSearch" type="button" onclick="JSvCardShiftTopUpCardShiftTopUpDataTable()">
                                    <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                                <a id="oahCardShiftTopUpAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                                <a id="oahCardShiftTopUpSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxCardShiftTopUpClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6 text-right" style="margin-top:34px;">
                    <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                        <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                            ตัวเลือก
                            <span class="caret"></span>
                        </button>
                        <ul class="dropdown-menu" role="menu">
                            <li id="oliBtnCardTopUpDeleteAll" class="disabled">
                                <a data-toggle="modal" data-target="#odvCardTopupModalDelMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
            <div class="row hidden" id="odvCardShiftTopUpAdvanceSearchContainer">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftTopUpSearchDocDateFrom" 
                                    id="oetCardShiftTopUpSearchDocDateFrom" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardtopup', 'tCardShiftTopUpFrom'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftTopUpSearchDocDateFrom').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftTopUpSearchDocDateTo" 
                                    id="oetCardShiftTopUpSearchDocDateTo" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardtopup', 'tCardShiftTopUpTo'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftTopUpSearchDocDateTo').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardtopup','tCardShiftTopUpTBDocStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftTopUpStaDoc" name="ocmCardShiftTopUpStaDoc">
                            <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                            <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                        </select>
                    </div>
                </div>
                <!-- <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tStaPrcDocTitle'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftTopUpStaPrcDoc" name="ocmCardShiftTopUpStaPrcDoc">
                            <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocProcessor'); ?></option> -->
                            <!-- <option value='2'><?php echo language('common/main/main', 'tStaDocProcessing'); ?></option> -->
                            <!-- <option value='3'><?php echo language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
                        </select>
                    </div>
                </div> -->
                <!-- From Search Advanced Status Doc Aaction -->
				<div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tStaDocAct'); ?></label>
                        <select class="selectpicker form-control" id="ocmStaDocAct" name="ocmStaDocAct">
                            <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                            <option value='1' selected><?php echo language('common/main/main', 'tStaDocActMove'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocActNotMoving'); ?></option>
                        </select>
                    </div>
                </div>
                
                <div class="col-lg-12">
                    <a id="oahCardShiftTopUpAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvCardShiftTopUpCardShiftTopUpDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
                </div>
            </div>
        </section>
    </div>
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataCardShiftTopUp"></section>
        <!-- End DataTable-->
    </div>
</div>
<?php include 'script/jCardShiftTopUpList.php'; ?>

