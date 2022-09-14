<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <!--ค้นหาธรรมดา-->
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuASTthoutSingleQuote"
                            type="text"
                            id="oetSearchAll"
                            name="oetSearchAll"
                            placeholder="<?=language('document/adjuststock/adjuststock','tASTFillTextSearch')?>"
                            onkeyup="Javascript:if(event.keyCode==13) JSvTRNCallPageTransferReceiptDataTable()"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvTRNCallPageTransferReceiptDataTable()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>

            <!--ค้นหาขั้นสูง-->
            <a id="oahPOAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?=language('common/main/main', 'tAdvanceSearch'); ?></a>

            <!--ล้างข้อมูลค้นหา-->
            <a class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxPOClearSearchData()"><?=language('common/main/main', 'tClearSearch'); ?></a>
        </div>

        <!--ค้นหาขั้นสูง-->
        <div id="odvPOAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmASTFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchBranch'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNHide"
                                    type="text"
                                    id="oetAPOBchCodeFrom"
                                    name="oetAPOBchCodeFrom"
                                    maxlength="5"
                                >
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetAPOBchNameFrom"
                                    name="oetAPOBchNameFrom"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock','tASTAdvSearchFrom'); ?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtAPOBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
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
                                    id="oetAPOBchCodeTo"
                                    name="oetAPOBchCodeTo" 
                                    maxlength="5"
                                >
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetAPOBchNameTo"
                                    name="oetAPOBchNameTo"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock','tASTAdvSearchTo'); ?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtAPOBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetAPODocDateFrom"
                                    name="oetAPODocDateFrom"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchFrom'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtAPODocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
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
                                    id="oetAPODocDateTo"
                                    name="oetAPODocDateTo"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchTo'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtAPODocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- From Search Advanced Status Doc -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchLabelStaDoc'); ?></label>
                            <select class="selectpicker form-control" id="ocmAPOStaDoc" name="ocmAPOStaDoc">
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
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchStaApprove'); ?></label>
                            <select class="selectpicker form-control" id="ocmAPOStaApprove" name="ocmAPOStaApprove">
                                <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main','tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main','tStaDocPendingApv'); ?></option>
                                
                            </select>
                        </div>
                    </div>
                    <!-- Button Form Search Advanced -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtPOSubmitFrmSearchAdv" class="btn xCNBTNPrimery" style="width:100%"><?php echo language('common/main/main', 'tSearch'); ?></button>
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
            <!--ตัวเลือกลบหลายตัว-->
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
                <div id="odvMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?=language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvTWIModalDelDocMultiple"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <!--Content-->
		<section id="ostContentPO"></section>
	</div>
</div>

<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jAdvancedSearch.php')?>