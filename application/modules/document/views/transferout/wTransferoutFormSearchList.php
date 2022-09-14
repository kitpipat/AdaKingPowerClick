<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuTXOthoutSingleQuote"
                            type="text"
                            id="oetSearchAll"
                            name="oetSearchAll"
                            placeholder="<?php echo language('document/transferout/transferout','tTXOFillTextSearch')?>"
                            onkeyup="Javascript:if(event.keyCode==13) JSvTXOCallPageDataTable()"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvTXOCallPageDataTable()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <a id="oahTXOAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
            <a id="oahTXOSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxTXOClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
        </div>
        <div id="odvTXOAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmTXOFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOBranch'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNHide"
                                    type="text"
                                    id="oetTxoBchCodeFrom"
                                    name="oetTxoBchCodeFrom"
                                    maxlength="5"
                                >
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetTxoBchNameFrom"
                                    name="oetTxoBchNameFrom"
                                    placeholder="<?php echo language('document/transferout/transferout','tTXOFrom'); ?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtTxoBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="input-group">
                                <input 
                                    class="form-control xCNHide" 
                                    id="oetTxoBchCodeTo"
                                    name="oetTxoBchCodeTo" 
                                    maxlength="5"
                                >
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetTxoBchNameTo"
                                    name="oetTxoBchNameTo"
                                    placeholder="<?php echo language('document/transferout/transferout','tTXOTo'); ?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtTxoBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXODocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetTxoDocDateFrom"
                                    name="oetTxoDocDateFrom"
                                    placeholder="<?php echo language('document/transferout/transferout', 'tTXOFrom'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtTxoDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetTxoDocDateTo"
                                    name="oetTxoDocDateTo"
                                    placeholder="<?php echo language('document/transferout/transferout', 'tTXOTo'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtTxoDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- From Search Advanced Status Doc -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOLabelStaDoc'); ?></label>
                            <select class="selectpicker form-control" id="ocmTxoStaDoc" name="ocmTxoStaDoc">
                                <option value='0'><?php echo language('common/main/main','tStaDocAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main','tStaDocComplete'); ?></option>
                                <option value='2'><?php echo language('common/main/main','tStaDocinComplete'); ?></option>
                                <option value='3'><?php echo language('common/main/main','tStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- From Search Advanced Status Approve -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOStaApprove'); ?></label>
                            <select class="selectpicker form-control" id="ocmTxoStaApprove" name="ocmTxoStaApprove">
                                <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main','tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main','tStaDocPendingApv'); ?></option>
                                
                            </select>
                        </div>
                    </div>
                    <!-- From Search Advanced Status Process Stock -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/transferout/transferout','tTXOStaPrcStk'); ?></label>
                            <select class="selectpicker form-control" id="ocmTxoStaPrcStk" name="ocmTxoStaPrcStk">
                                <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main','tStaDocProcessor'); ?></option>
                                <option value='2'><?php echo language('common/main/main','tStaDocProcessing'); ?></option>
                                <option value='3'><?php echo language('common/main/main','tStaDocPendingProcessing'); ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- Button Form Search Advanced -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtTXOSubmitFrmSearchAdv" class="btn xCNBTNPrimery" style="width:100%"><?php echo language('common/main/main', 'tSearch'); ?></button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-8 col-sm-4 col-md-4 col-lg-4">
            </div>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
					<button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?php echo language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
					</button>
					<ul class="dropdown-menu" role="menu">
						<li id="oliBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvTxoModalDelDocMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
				</div>
            </div>
        </div>
    </div>
    <div class="panel-body">
		<section id="ostContentTransferOut"></section>
	</div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jTransferoutFormSearchList.php')?>