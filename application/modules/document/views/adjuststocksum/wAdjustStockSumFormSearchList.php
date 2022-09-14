<div class="panel panel-headline"> <!-- เพิ่ม -->
    <div class="panel-heading">
        <section id="ostSearchPromotion">
            <div class="row">
                <div class="col-xs-3 col-md-3">
                    <div class="form-group">
                        <div class="input-group">
                            <input 
                                class="form-control xCNInputWithoutSingleQuote" 
                                type="text" id="oetSearchAll" 
                                name="oetSearchAll" 
                                placeholder="<?= language('document/adjuststocksum/adjuststocksum', 'tAdjStkSumFillTextSearch') ?>" 
                                onkeyup="javascript: if(event.keyCode == 13) {JSvCallPageAdjStkSumPdtDataTable()}" 
                                autocomplete="off">
                            <span class="input-group-btn">
                                <button type="button" class="btn xCNBtnDateTime" onclick="JSvCallPageAdjStkSumPdtDataTable()">
                                    <img src="<?php echo base_url('application/modules/common/assets/images/icons/search-24.png'); ?>">
                                </button>
                            </span>
                        </div>
                    </div>
                </div>
                <a id="oahAdjStkSumAdvanceSearch" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;"><?php echo language('common/main/main', 'tAdvanceSearch'); ?></a>
                <a id="oahAdjStkSumSearchReset" class="btn xCNBTNDefult xCNBTNDefult1Btn" href="javascript:;" onclick="JSxAdjStkSumClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></a>
            </div>

            <div class="row hidden" id="odvAdjStkSumAdvanceSearchContainer" style="margin-bottom:20px;">
                <div class="col-xs-12 col-md-6 col-lg-6">

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
                            $tBchCodeDefault        = "";
                            $tBchNameDefault        = "";
                            $tBrowseBchDisabled     = '';
                        }
                    ?>

                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tAdjStkSumBranch'); ?></label>
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetBchCodeFrom" name="oetBchCodeFrom" value="<?=$tBchCodeDefault;?>" maxlength="5">
                                <input 
                                    class="form-control xWPointerEventNone" 
                                    type="text" id="oetBchNameFrom" 
                                    name="oetBchNameFrom" 
                                    value="<?=$tBchNameDefault;?>"
                                    placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tFrom'); ?>" 
                                    readonly>
                                <!-- ถ้า user มีสาขาจะไม่สามารถ Brw ได้ -->
                                <span class="input-group-btn" >
                                    <button id="obtAdjStkSumBrowseBchFrom" type="button" class="btn xCNBtnBrowseAddOn" <?=$tBrowseBchDisabled;?> >
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <label class="xCNLabelFrm"><?php echo language('document/adjuststock/adjuststock', 'tASTAdvSearchBranchTo'); ?></label>
                        <div class="form-group">
                            <div class="input-group">
                                <input class="form-control xCNHide" id="oetBchCodeTo" name="oetBchCodeTo" value="<?=$tBchCodeDefault;?>" maxlength="5">
                                <input class="form-control xWPointerEventNone" type="text" id="oetBchNameTo" name="oetBchNameTo" value="<?=$tBchNameDefault;?>" placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTo'); ?>" readonly>
                                <!-- ถ้า user มีสาขาจะไม่สามารถ Brw ได้ -->
                                <span class="input-group-btn" >
                                    <button id="obtAdjStkSumBrowseBchTo" type="button" class="btn xCNBtnBrowseAddOn" <?=$tBrowseBchDisabled;?> >
                                        <img src="<?php echo base_url() . 'application/modules/common/assets/images/icons/find-24.png' ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xs-12 col-md-6 col-lg-6">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tAdjStkSumTBDocDate'); ?></label>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-right-15">
                        <div class="form-group">
                            <div class="input-group">
                                <input  class="form-control input100 xCNDatePicker" type="text" id="oetSearchDocDateFrom" name="oetSearchDocDateFrom" placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tFrom'); ?>">
                                <span class="input-group-btn" >
                                    <button id="obtSearchDocDateFrom" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-xs-6 no-padding padding-left-15">
                        <div class="form-group">
                            <div class="input-group">
                                <input  class="form-control input100 xCNDatePicker" type="text" id="oetSearchDocDateTo" name="oetSearchDocDateTo" placeholder="<?php echo language('document/transferwarehouseout/transferwarehouseout', 'tTo'); ?>">
                                <span class="input-group-btn" >
                                    <button id="obtSearchDocDateTo" type="button" class="btn xCNBtnDateTime">
                                        <img src="<?php echo base_url(); ?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                    </button>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tAdjStkSumTBStaDoc'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmStaDoc" name="ocmStaDoc">
                            <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocComplete'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocinComplete'); ?></option>
                            <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                        </select>
                    </div>
                </div> -->
                <div class="col-xs-12 col-md-3 col-lg-3">
                        <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                            <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tAdjStkSumTBStaDoc'); ?></label>
                        </div>
                        <div class="form-group">
                            <select class="selectpicker form-control" id="ocmStaDoc" name="ocmStaDoc">
                                <option value='0'><?php echo language('common/main/main', 'tStaDocAll'); ?></option>
                                <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                                <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                                <option value='3'><?php echo language('common/main/main', 'tStaDocCancel'); ?></option>
                            </select>
                        </div>
                    </div>
                <!-- <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tAdjStkSumTBStaApv'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmStaApprove" name="ocmStaApprove">
                            <option value='0'><?php echo language('common/main/main', 'tAll'); ?></option>
                            <option value='1'><?php echo language('common/main/main', 'tStaDocApv'); ?></option>
                            <option value='2'><?php echo language('common/main/main', 'tStaDocPendingApv'); ?></option>
                        </select>
                    </div>
                </div> -->
                <div class="col-xs-12 col-md-3 col-lg-3">
                    <div class="col-lg-12 col-md-12 col-xs-12 no-padding">
                        <label class="xCNLabelFrm"><?php echo language('document/transferwarehouseout/transferwarehouseout', 'tAdjStkSumTBStaPrc'); ?></label>
                    </div>
                    <div class="form-group">
                        <select class="selectpicker form-control" id="ocmStaPrcStk" name="ocmStaPrcStk">
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
                        <button id="oahAdjStkSumAdvanceSearchSubmit" class="btn xCNBTNPrimery" style="width:100%" onclick="JSvCallPageAdjStkSumPdtDataTable()"><?php echo language('common/main/main', 'tSearch'); ?></button>
                    </div>
                </div>
            </div>
        </section>
    </div>
    <div class="panel-heading"> <!-- เพิ่ม -->
        <div class="row">
            <div class="col-xs-8 col-md-4 col-lg-4">
            </div>
            <div class="col-xs-4 col-md-8 col-lg-8 text-right" style="margin-top:-35px;">
                <div id="odvAdjStkSumMngTableList" class="btn-group xCNDropDrownGroup">
                    <button type="button" class="btn xCNBTNMngTable" data-toggle="dropdown">
                        <?= language('common/main/main', 'tCMNOption') ?>
                    </button>
                    <ul class="dropdown-menu" role="menu">
                        <li id="oliAdjStkSumBtnDeleteAll" class="disabled">
                            <a data-toggle="modal" data-target="#odvModalDel"><?= language('common/main/main', 'tCMNDeleteAll') ?></a>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="panel-body">
        <section id="odvContentAdjustStockSumTable"></section>
    </div>
</div>

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>
<?php include('script/jAdjustStockSumFormSearchList.php') ?>








