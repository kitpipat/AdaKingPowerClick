<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInputWithoutSingleQuote"
                            type="text"
                            id="oetSearchAll"
                            name="oetSearchAll"
                            placeholder="<?=language('document/adjuststock/adjuststock','tASTFillTextSearch')?>"
                            onkeyup="Javascript:if(event.keyCode==13) JSvTBICallPageTransferReceiptDataTable()"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvTBICallPageTransferReceiptDataTable()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <a id="oahTRNAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?=language('common/main/main', 'tAdvanceSearch'); ?></a>
            <a id="oahTRNSearchReset"   class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxTBIClearSearchData()"><?=language('common/main/main', 'tClearSearch'); ?></a>
        </div>
        <!--ค้นหาขั้นสูง-->
        <div id="odvTRNAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmASTFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <?php
                        if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                            if( $this->session->userdata("nSesUsrBchCount") <= 1 ){
                                $tBrowseBchDisabled = 'disabled';
                                $tBchCodeDefault    = $this->session->userdata("tSesUsrBchCodeDefault");
                                $tBchNameDefault    = $this->session->userdata("tSesUsrBchNameDefault");
                            }else{
                                $tBrowseBchDisabled = '';
                                $tBchCodeDefault    = '';
                                $tBchNameDefault    = '';
                            }
                        } else {
                            $tBchCodeDefault = "";
                            $tBchNameDefault = "";
                            $tBrowseBchDisabled = '';
                        }
                    ?>

                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchBranch'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNHide"
                                    type="text"
                                    id="oetASTBchCodeFrom"
                                    name="oetASTBchCodeFrom"
                                    maxlength="5"
                                    value="<?=$tBchCodeDefault;?>"
                                >
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetASTBchNameFrom"
                                    name="oetASTBchNameFrom"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock','tASTAdvSearchFrom'); ?>"
                                    value="<?=$tBchNameDefault;?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtASTBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?> ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranchTo'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNHide"
                                    id="oetASTBchCodeTo"
                                    name="oetASTBchCodeTo"
                                    maxlength="5"
                                    value="<?=$tBchCodeDefault;?>"
                                >
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetASTBchNameTo"
                                    name="oetASTBchNameTo"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock','tASTAdvSearchTo'); ?>"
                                    readonly
                                    value="<?=$tBchNameDefault;?>"
                                >
                                <span class="input-group-btn">
                                    <button id="obtASTBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?>><img class="xCNIconFind"></button>
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
                                    id="oetASTDocDateFrom"
                                    name="oetASTDocDateFrom"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchFrom'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtASTDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
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
                                    id="oetASTDocDateTo"
                                    name="oetASTDocDateTo"
                                    placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchTo'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtASTDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
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
                            <select class="selectpicker form-control" id="ocmASTStaDoc" name="ocmASTStaDoc">
                                <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- From Search Advanced Status Approve -->
                    <!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchStaApprove'); ?></label>
                            <select class="selectpicker form-control" id="ocmASTStaApprove" name="ocmASTStaApprove">
                                <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main','tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main','tStaDocPendingApv'); ?></option>

                            </select>
                        </div>
                    </div> -->
                    <!-- From Search Advanced Status Process Stock -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock','tASTAdvSearchStaPrcStk'); ?></label>
                            <select class="selectpicker form-control" id="ocmASTStaPrcStk" name="ocmASTStaPrcStk">
                                <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocProcessor'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocProcessing'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- From Search Advanced Status Doc Aaction -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('common/main/main', 'tStaDocAct'); ?></label>
                            <select class="selectpicker form-control" id="ocmStaDocAct" name="ocmStaDocAct">
                                <option value=''><?php echo language('common/main/main', 'tAll'); ?></option>
                                <option value='Active' selected><?php echo language('common/main/main', 'tStaDocActMove'); ?></option>
                                <option value='InActive'><?php echo language('common/main/main', 'tStaDocActNotMoving'); ?></option>
                            </select>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group" style="width: 60%;">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtTWISubmitFrmSearchAdv" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvTBICallPageTransferReceiptDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
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
                        <?=language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvTBIModalDelDocMultiple"><?= language('common/main/main','tDelAll')?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
		<section id="ostContentTransferreceipt"></section>
	</div>
</div>

<script src="<?=base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?=base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jTransferReceiptbranchSearchList.php')?>
