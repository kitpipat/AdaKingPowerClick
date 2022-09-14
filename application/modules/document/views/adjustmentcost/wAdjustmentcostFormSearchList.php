<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control xCNInpuADCthoutSingleQuote" type="text" id="oetADCSearchAll" name="oetADCSearchAll" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCFillTextSearch') ?>" onkeyup="Javascript:if(event.keyCode==13) JSvADCCallPageDataTable()" autocomplete="off">
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvADCCallPageDataTable()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <a id="oahADCAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
            <a id="oahADCSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxADCClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
        </div>
        <div id="odvADCAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmADCFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <?php
                            // if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                            //     $tBchCodeUsr = $this->session->userdata("tSesUsrBchCodeDefault");
                            //     $tBchNameUsr = $this->session->userdata("tSesUsrBchNameDefault");
                            //     if( $this->session->userdata("nSesUsrBchCount") <= 1 ){
                            //         $tBrowseBchDisabled = 'disabled';
                            //     }else{
                            //         $tBrowseBchDisabled = '';
                            //     }
                            // } else {
                            //     $tBchCodeUsr = "";
                            //     $tBchNameUsr = "";
                            //     $tBrowseBchDisabled = '';
                            // }

                            $nCountBch = $this->session->userdata("nSesUsrBchCount");
							if($nCountBch == 1){ //ค้นหาขั้นสูง
								$tBchCodeUsr        = $this->session->userdata("tSesUsrBchCodeDefault");
								$tBchNameUsr        = $this->session->userdata("tSesUsrBchNameDefault");
                                $tBrowseBchDisabled = 'disabled';
							}else{
								$tBchCodeUsr        = '';
								$tBchNameUsr        = '';
                                $tBrowseBchDisabled = '';
							}
                        ?>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchBranch'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" type="text" id="oetADCBchCodeFrom" name="oetADCBchCodeFrom" maxlength="5" value="<?= $tBchCodeUsr; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetADCBchNameFrom" name="oetABchNameFrom" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchFrom'); ?>" value="<?= $tBchNameUsr; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtADCBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?>><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchBranchTo'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetADCBchCodeTo" name="oetADCBchCodeTo" maxlength="5" value="<?= $tBchCodeUsr; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetADCBchNameTo" name="oetADCBchNameTo" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchTo'); ?>" value="<?= $tBchNameUsr; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtADCBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?>><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNDatePicker" type="text" id="oetADCDocDateFrom" name="oetADCDocDateFrom" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchFrom'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtADCDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                        <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchDocDateTo'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNDatePicker" type="text" id="oetADCDocDateTo" name="oetADCDocDateTo" placeholder="<?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchTo'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtADCDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-3 col-lg-3">
                        <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                            <label class="xCNLabelFrm"><?php echo language('document/adjustmentcost/adjustmentcost', 'tADCAdvSearchLabelStaDoc'); ?></label>
                        </div>
                        <div class="form-group">
                            <select class="selectpicker form-control" id="ocmADCStaDoc" name="ocmADCStaDoc">
                                <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group" style="width: 60%;">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtADCSubmitFrmSearchAdv" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvADCCallPageDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
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
                        <?php echo language('common/main/main', 'tCMNOption') ?>
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvADCModalDelDocMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostContentAdjustmentcost"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jAdjustmentcostFormSearchList.php') ?>