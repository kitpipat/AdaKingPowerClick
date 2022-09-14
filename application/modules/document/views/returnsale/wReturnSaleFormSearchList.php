<?php
	if ($this->session->userdata("tSesUsrLevel") != "HQ" ){
		$tBchCodeDefault = $this->session->userdata("tSesUsrBchCodeDefault");
		$tBchNameDefault = $this->session->userdata("tSesUsrBchNameDefault");
		if( $this->session->userdata("nSesUsrBchCount") <= 1 ){
			$tBrowseBchDisabled = 'disabled';
		}else{
			$tBrowseBchDisabled = '';
		}
	} else {
		$tBchCodeDefault = "";
		$tBchNameDefault = "";
		$tBrowseBchDisabled = '';
	}
?>
<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuTXOthoutSingleQuote"
                            type="text"
                            id="oetRSSearchAllDocument"
                            name="oetRSSearchAllDocument"
                            placeholder="<?php echo language('document/returnsale/returnsale','tRSFillTextSearch')?>"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button id="obtRSSerchAllDocument" type="button" class="btn xCNBtnDateTime"><img class="xCNIconSearch"></button>
                        </span>
                    </div>
                </div>
            </div>
            <button id="obtRSAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></button>
            <button id="obtRSSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
        </div>
        <div id="odvRSAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmRSFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSAdvSearchBranch'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" type="text" id="oetRSAdvSearchBchCodeFrom" name="oetRSAdvSearchBchCodeFrom" value="<?=$tBchCodeDefault;?>" maxlength="5">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetRSAdvSearchBchNameFrom"
                                    name="oetRSAdvSearchBchNameFrom"
                                    value="<?=$tBchNameDefault;?>"
                                    placeholder="<?php echo language('document/returnsale/returnsale','tRSAdvSearchFrom'); ?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtRSAdvSearchBrowseBchFrom" <?=$tBrowseBchDisabled;?> type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetRSAdvSearchBchCodeTo"name="oetRSAdvSearchBchCodeTo" value="<?=$tBchCodeDefault;?>" maxlength="5">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetRSAdvSearchBchNameTo"
                                    name="oetRSAdvSearchBchNameTo"
                                    value="<?=$tBchNameDefault;?>"
                                    placeholder="<?php echo language('document/returnsale/returnsale','tRSAdvSearchTo'); ?>"
                                    readonly
                                >
                                <span class="input-group-btn">
                                    <button id="obtRSAdvSearchBrowseBchTo" <?=$tBrowseBchDisabled;?> type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetRSAdvSearcDocDateFrom"
                                    name="oetRSAdvSearcDocDateFrom"
                                    placeholder="<?php echo language('document/returnsale/returnsale', 'tRSAdvSearchDateFrom'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtRSAdvSearchDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <label class="xCNLabelFrm"></label>
                        <div class="input-group">
                            <input
                                class="form-control xCNDatePicker"
                                type="text"
                                id="oetRSAdvSearcDocDateTo"
                                name="oetRSAdvSearcDocDateTo"
                                placeholder="<?php echo language('document/returnsale/returnsale', 'tRSAdvSearchDateTo'); ?>"
                            >
                            <span class="input-group-btn" >
                                <button id="obtRSAdvSearchDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- From Search Advanced Status Doc -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSAdvSearchStaDoc'); ?></label>
                            <select class="selectpicker form-control" id="ocmRSAdvSearchStaDoc" name="ocmRSAdvSearchStaDoc">
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
                            <label class="xCNLabelFrm"><?php echo language('document/returnsale/returnsale','tRSAdvSearchStaApprove'); ?></label>
                            <select class="selectpicker form-control" id="ocmRSAdvSearchStaApprove" name="ocmRSAdvSearchStaApprove">
                                <option value='0'><?php echo language('common/main/main','tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main','tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main','tStaDocPendingApv'); ?></option>
                            </select>
                        </div>    
                    </div>
                    <!-- Button Form Search Advanced -->
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
						<div class="form-group" style="width: 60%;">
							<label class="xCNLabelFrm">&nbsp;</label>
							<button id="obtRSAdvSearchSubmitForm" class="btn xCNBTNPrimery" style="width:100%"><?php echo language('common/main/main', 'tSearch'); ?></button>
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
                <div id="odvRSMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?php echo language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
						<li id="oliRSBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvRSModalDelDocMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostRSDataTableDocument"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jReturnSaleFormSearchList.php')?>