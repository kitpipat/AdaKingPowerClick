<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuTXOthoutSingleQuote"
                            type="text"
                            id="oetPOSearchAllDocument"
                            name="oetPOSearchAllDocument"
                            placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOFillTextSearch')?>"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button id="obtPOSerchAllDocument" type="button" class="btn xCNBtnDateTime"><img class="xCNIconSearch"></button>
                        </span>
                    </div>
                </div>
            </div>
            <button id="obtPOAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></button>
            <button id="obtPOSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
        </div>
        <div id="odvPOAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmPOFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOAdvSearchBranch'); ?></label>
                            <div class="input-group">
                            <?php
                                    if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                                        if( $this->session->userdata("nSesUsrBchCount") <= 1 ){ //ค้นหาขั้นสูง
                                            $tBCHCode   = $this->session->userdata("tSesUsrBchCodeDefault");
                                            $tBCHName   = $this->session->userdata("tSesUsrBchNameDefault");
                                        }else{
                                            $tBCHCode   = '';
                                            $tBCHName   = '';
                                        }
                                    } else {
                                        $tBCHCode       = "";
                                        $tBCHName       = "";
                                    }
                                ?>
                                <input class="form-control xCNHide" type="text" id="oetPOAdvSearchBchCodeFrom" name="oetPOAdvSearchBchCodeFrom" maxlength="5" value="<?= $tBCHCode; ?>">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetPOAdvSearchBchNameFrom"
                                    name="oetPOAdvSearchBchNameFrom"
                                    placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOAdvSearchFrom'); ?>"
                                    readonly
                                    value="<?= $tBCHName; ?>"
                                >
                                <span class="input-group-btn">
                                    <button id="obtPOAdvSearchBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetPOAdvSearchBchCodeTo"name="oetPOAdvSearchBchCodeTo" maxlength="5" value="<?= $tBCHCode; ?>">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetPOAdvSearchBchNameTo"
                                    name="oetPOAdvSearchBchNameTo"
                                    placeholder="<?php echo language('document/purchaseorder/purchaseorder','tPOAdvSearchTo'); ?>"
                                    readonly
                                    value="<?= $tBCHName; ?>"
                                >
                                <span class="input-group-btn">
                                    <button id="obtPOAdvSearchBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetPOAdvSearcDocDateFrom"
                                    name="oetPOAdvSearcDocDateFrom"
                                    placeholder="<?php echo language('document/purchaseorder/purchaseorder', 'tPOAdvSearchDateFrom'); ?>"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtPOAdvSearchDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
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
                                id="oetPOAdvSearcDocDateTo"
                                name="oetPOAdvSearcDocDateTo"
                                placeholder="<?php echo language('document/purchaseorder/purchaseorder', 'tPOAdvSearchDateTo'); ?>"
                            >
                            <span class="input-group-btn" >
                                <button id="obtPOAdvSearchDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- From Search Advanced Status Doc -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOAdvSearchStaDoc'); ?></label>
                            <select class="selectpicker form-control" id="ocmPOAdvSearchStaDoc" name="ocmPOAdvSearchStaDoc">
                                <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>
                    <!-- From Search Advanced Status Approve -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3 hide">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder','tPOAdvSearchStaApprove'); ?></label>
                            <select class="selectpicker form-control" id="ocmPOAdvSearchStaApprove" name="ocmPOAdvSearchStaApprove">
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
                                    <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                    <option value='1' selected><?php echo language('common/main/main', 'tStaDocActMove'); ?></option>
                                    <option value='2'><?php echo language('common/main/main', 'tStaDocActNotMoving'); ?></option>
                                </select>
                        </div>
                    </div>
                    <!-- From Search Advanced Status Process Stock -->
                    <!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
               
                    </div> -->
                    <!-- Button Form Search Advanced -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group" style="width:60%;">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtPOAdvSearchSubmitForm" class="btn xCNBTNPrimery" style="width:100%"><?php echo language('common/main/main', 'tSearch'); ?></button>
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
                <div id="odvPOMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?php echo language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
						<li id="oliPOBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvPOModalDelDocMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostPODataTableDocument"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jPurchaseOrderFormSearchList.php')?>