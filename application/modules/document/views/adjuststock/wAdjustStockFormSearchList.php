<div class="panel panel-headline">
    <div class="panel-heading">
        <div class="row">
            <div class="col-xs-3 col-sm-3 col-md-3 col-lg-3">
                <div class="form-group">
                    <div class="input-group">
                        <input class="form-control xCNInpuASTthoutSingleQuote" type="text" id="oetSearchAll" name="oetSearchAll" placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTFillTextSearch') ?>" onkeyup="Javascript:if(event.keyCode==13) JSvASTCallPageDataTable()" autocomplete="off">
                        <span class="input-group-btn">
                            <button type="button" class="btn xCNBtnDateTime" onclick="JSvASTCallPageDataTable()">
                                <img class="xCNIconSearch">
                            </button>
                        </span>
                    </div>
                </div>
            </div>
            <a id="oahASTAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
            <a id="oahASTSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxASTClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
        </div>
        <div id="odvASTAdvanceSearchContainer" class="hidden" style="margin-bottom:20px;">
            <form id="ofmASTFromSerchAdv" class="validate-form" action="javascript:void(0)" method="post">
                <div class="row">
                    <!-- From Search Advanced  Branch -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <?php
                        if ( $this->session->userdata("tSesUsrLevel") != "HQ" ){
                            if( $this->session->userdata("nSesUsrBchCount") <= 1 ){
                                $tBrowseBchDisabled = 'disabled';
                                $tBchCodeUsr        = $this->session->userdata("tSesUsrBchCodeDefault");
                                $tBchNameUsr        = $this->session->userdata("tSesUsrBchNameDefault");
                            }else{
                                $tBrowseBchDisabled = '';
                                $tBchCodeUsr        = '';
                                $tBchNameUsr        = '';
                            }
                        } else {
                            $tBchCodeUsr = "";
                            $tBchNameUsr = "";
                            $tBrowseBchDisabled = '';
                        }
                        ?>
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranch'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" type="text" id="oetASTBchCodeFrom" name="oetASTBchCodeFrom" maxlength="5" value="<?= $tBchCodeUsr; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetASTBchNameFrom" name="oetASTBchNameFrom" placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchFrom'); ?>" value="<?= $tBchNameUsr; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtASTBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?>><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranchTo'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetASTBchCodeTo" name="oetASTBchCodeTo" maxlength="5" value="<?= $tBchCodeUsr; ?>">
                                <input class="form-control xWPointerEventNone" type="text" id="oetASTBchNameTo" name="oetASTBchNameTo" placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchTo'); ?>" value="<?= $tBchNameUsr; ?>" readonly>
                                <span class="input-group-btn">
                                    <button id="obtASTBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" <?php echo $tBrowseBchDisabled; ?>><img class="xCNIconFind"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <!-- From Search Advanced  DocDate -->
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchDocDate'); ?></label>
                            <div class="input-group">
                                <input class="form-control xCNDatePicker" type="text" id="oetASTDocDateFrom" name="oetASTDocDateFrom" placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchFrom'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtASTDocDateForm" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"></label>
                            <div class="input-group">
                                <input class="form-control xCNDatePicker" type="text" id="oetASTDocDateTo" name="oetASTDocDateTo" placeholder="<?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchTo'); ?>">
                                <span class="input-group-btn">
                                    <button id="obtASTDocDateTo" type="button" class="btn xCNBtnDateTime"><img class="xCNIconCalendar"></button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-xs-12 col-md-3 col-lg-3">
                        <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchLabelStaDoc'); ?></label>
                        </div>
                        <div class="form-group">
                            <select class="selectpicker form-control" id="ocmASTStaDoc" name="ocmASTStaDoc">
                                <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-3 col-lg-3">
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchStaPrcStk'); ?></label>
                            <select class="selectpicker form-control" id="ocmASTStaPrcStk" name="ocmASTStaPrcStk">
                                <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocProcessor'); ?></option>
                                <!-- <option value='2'><?php echo language('common/main/main', 'tStaDocProcessing'); ?></option> -->
                                <option value='3'><?php echo language('common/main/main', 'tStaDocPendingProcessing'); ?></option>
                            </select>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-6 col-md-2 col-lg-2">
                        <div class="form-group" style="width: 60%;">
                            <label class="xCNLabelFrm">&nbsp;</label>
                            <button id="obtASTSubmitFrmSearchAdv" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvCallPageCreditNotePdtDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
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
                            <a data-toggle="modal" data-target="#odvASTModalDelDocMultiple"><?= language('common/main/main', 'tDelAll') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="ostContentAdjustStock"></section>
    </div>
</div>
<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jAdjustStockFormSearchList.php') ?>