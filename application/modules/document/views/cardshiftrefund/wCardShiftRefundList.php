<div class="panel panel-headline"> <!-- เพิ่ม -->
	<div class="panel-body"> <!-- เพิ่ม -->
        <section id="ostSearchRecive">
            <div class="row">
                <div class="col-lg-6 col-md-6 col-xs-12">
                    <div class="form-group"> <!-- เปลี่ยน From Imput Class -->
                        <label class="xCNLabelFrm"><?= language('common/main/main','tSearch')?></label>
                        <div class="input-group">
                            <input type="text" class="form-control" id="oetSearchAll" name="oetSearchAll" placeholder="<?= language('common/main/main','tSearch')?>" onkeypress="Javascript:if(event.keyCode==13) JSvCardShiftRefundCardShiftRefundDataTable()">
                            <span class="input-group-btn">
                                <button id="oimSearchCardShiftRefund" class="btn xCNBtnSearch" type="button" onclick="JSvCardShiftRefundCardShiftRefundDataTable()">
                                    <img class="xCNIconAddOn" src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                                <a id="oahCardShiftRefundAdvanceSearch" style="margin-left: 10px;"class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                                <a id="oahCardShiftRefundSearchReset" style="margin-left: 1px;" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxCardShiftRefundClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
                            </span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row hidden" id="odvCardShiftRefundAdvanceSearchContainer" style="margin-bottom: 20px;">
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftRefundSearchDocDateFrom" 
                                    id="oetCardShiftRefundSearchDocDateFrom" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardrefund', 'tCardShiftRefundFrom'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftRefundSearchDocDateFrom').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="validate-input">
                                <input 
                                    class="form-control input100 xCNDatePicker" 
                                    type="text" 
                                    name="oetCardShiftRefundSearchDocDateTo" 
                                    id="oetCardShiftRefundSearchDocDateTo" 
                                    aria-invalid="false" 
                                    placeholder="<?php echo language('document/card/cardrefund', 'tCardShiftRefundTo'); ?>"
                                    data-validate="Please Insert Doc Date">
                                <span class="prefix xCNiConGen xCNIconBrowse"><i class="fa fa-calendar" aria-hidden="true" onclick="$('#oetCardShiftRefundSearchDocDateTo').focus()"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/card/cardrefund','tCardShiftRefundTBDocStatus'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmCardShiftRefundStaDoc" name="ocmCardShiftRefundStaDoc">
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
                        <select class="selectpicker form-control" id="ocmCardShiftRefundStaPrcDoc" name="ocmCardShiftRefundStaPrcDoc">
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
                        <select class="selectpicker form-control" id="ocmCardShiftRefundStaDocAct" name="ocmCardShiftRefundStaDocAct">
                            <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                            <option value='1' selected><?php echo language('common/main/main', 'tStaDocActMove'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocActNotMoving'); ?></option>
                        </select>
                    </div>
				</div>
                <div class="col-lg-12">
                    <a id="oahCardShiftRefundAdvanceSearchSubmit" class="btn xCNBTNDefult xCNBTNDefult1Btn pull-right" href="javascript:;" onclick="JSvCardShiftRefundCardShiftRefundDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></a>
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
                                <a href="javascript:;" onclick="JSxCardShiftRefundDelChoose()"><?= language('common/main/main','tDelAll')?></a>
                            </li>
                        </ul>
                    </div>
                </div>
            <?php endif; ?>
		</div>
    </div>
    
    <div class="panel-body">
        <!--- Data Table -->
        <section id="ostDataCardShiftRefund"></section>
        <!-- End DataTable-->
    </div>
</div>
<?php include 'script/jCardShiftRefundList.php'; ?>




