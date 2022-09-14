<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input
                            class="form-control xCNInpuTXOthoutSingleQuote"
                            type="text"
                            id="oetCPHSearchAllDocument"
                            name="oetCPHSearchAllDocument"
                            placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHFillTextSearch')?>"
                            autocomplete="off"
                        >
                        <span class="input-group-btn">
                            <button id="obtCPHSerchAllDocument" type="button" class="btn xCNBtnDateTime"><img class="xCNIconSearch"></button>
                        </span>
                    </div>    
                </div>
            </div>
            <button id="obtCPHAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></button>
            <button id="obtCPHSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
        </div>
        <div id="odvCPHAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmCPHFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <?php
								if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
									if( $this->session->userdata("nSesUsrBchCount") <= 1 ){ //ค้นหาขั้นสูง
										$tBCHCode 	= $this->session->userdata("tSesUsrBchCodeDefault");
										$tBCHName 	= $this->session->userdata("tSesUsrBchNameDefault");
									}else{
										$tBCHCode 	= '';
										$tBCHName 	= '';
									}
								}else{
									$tBCHCode 		= '';
									$tBCHName 		= '';
								}
							?>
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranch'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" type="text" id="oetCPHAdvSearchBchCodeFrom" name="oetCPHAdvSearchBchCodeFrom" maxlength="5" value="<?= $tBCHCode; ?>">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetCPHAdvSearchBchNameFrom"
                                    name="oetCPHAdvSearchBchNameFrom"
                                    placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHAdvSearchFrom'); ?>"
                                    readonly
                                    value="<?= $tBCHName; ?>" 
                                >
                                <span class="input-group-btn">
                                    <button id="obtCPHAdvSearchBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranchTo'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetCPHAdvSearchBchCodeTo"name="oetCPHAdvSearchBchCodeTo" maxlength="5" value="<?= $tBCHCode; ?>">
                                <input
                                    class="form-control xWPointerEventNone"
                                    type="text"
                                    id="oetCPHAdvSearchBchNameTo"
                                    name="oetCPHAdvSearchBchNameTo"
                                    placeholder="<?php echo language('document/couponsetup/couponsetup','tCPHAdvSearchTo'); ?>"
                                    readonly
                                    value="<?= $tBCHName; ?>"
                                >
                                <span class="input-group-btn">
                                    <button id="obtCPHAdvSearchBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" ><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input
                                    class="form-control xCNDatePicker"
                                    type="text"
                                    id="oetCPHAdvSearcDocDateFrom"
                                    name="oetCPHAdvSearcDocDateFrom"
                                    placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCPHAdvSearchDateFrom'); ?>"
                                    autocomplete="off"
                                >
                                <span class="input-group-btn" >
                                    <button id="obtCPHAdvSearchDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
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
                                id="oetCPHAdvSearcDocDateTo"
                                name="oetCPHAdvSearcDocDateTo"
                                placeholder="<?php echo language('document/couponsetup/couponsetup', 'tCPHAdvSearchDateTo'); ?>"
                                autocomplete="off"
                            >
                            <span class="input-group-btn" >
                                <button id="obtCPHAdvSearchDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                            </span>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <!-- From Search Advanced Status Doc -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHAdvSearchStaDoc'); ?></label>
                            <select class="selectpicker form-control" id="ocmCPHAdvSearchStaDoc" name="ocmCPHAdvSearchStaDoc">
                                <option value='0'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocAll'); ?></option>
                                <option value='1'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocApv'); ?></option>
                                <option value='2'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocWaitApv'); ?></option>
                                <option value='3'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>

                    <!-- From Search Advanced Status Process Stock -->
                    <!-- <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/couponsetup/couponsetup','tCPHAdvSearchStaPrcStk'); ?></label>
                            <select class="selectpicker form-control" id="ocmCPHAdvSearchStaPrcStk" name="ocmCPHAdvSearchStaPrcStk">
                                <option value='0'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocAll'); ?></option>
                                <option value='1'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocProcessor'); ?></option>
                                <option value='3'><?php echo language('document/couponsetup/couponsetup','tCPHStaDocNotProcessed'); ?></option>
                            </select>
                        </div>
                    </div> -->
                    <!-- Button Form Search Advanced -->
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group" style="width:60%;float:left;">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtCPHAdvSearchSubmitForm" class="btn xCNBTNPrimery" style="width:100%"><?php echo language('common/main/main', 'tSearch'); ?></button>
                        </div>
                    </div>
                </div>    
            </form>
        </div>
    </div>
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-4">
            </div>
            <div class="col-xs-12 col-sm-12 col-md-12 col-lg-8 text-right" style="margin-top:-35px;">
            
				<!-- <button type="button" id="obtCPHEventImportFile" class="btn xCNBTNImportFile"><?= language('common/main/main','tImport')?></button> -->
			
                <div id="odvCPHMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?php echo language('common/main/main','tCMNOption')?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
						<li id="oliCPHBtnDeleteAll" class="disabled">
							<a data-toggle="modal" data-target="#odvCPHModalDelDocMultiple"><?php echo language('common/main/main','tCMNDeleteAll')?></a>
						</li>
					</ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostCPHDataTableDocument"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php include('script/jCouponSetUpFormSearchList.php')?>