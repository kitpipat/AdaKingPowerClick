<?php 

?>
<style>
    .NumberDuplicate{
        font-size   : 15px !important;
        color       : red;
        font-style  : italic;
    }

    .xCNSearchpadding{
        padding     : 0px 3px;
    }
</style>

<input type="hidden" id="ohdSMLKAdjStaIsView" value="0">

<div class="row">
    <!--ฟิลเตอร์ค้นหา-->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <!-- Breadcrumb -->
        <ol id="oliMenuNav" class="breadcrumb">
            <li id="oliSMLKAdjStaTitle" class="xCNLinkClick" onclick="JSxGetPSHContentAdjustStatus()" style="cursor:pointer"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaStaAdj')?></li>
            <li id="oliSMLKAdjStaAdd" class="active" style="display: inline-block;"><a><?=language('common/main/main', 'tAdd')?></a></li>
        </ol>
        <!-- Breadcrumb -->
    </div>

    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="form-group" style="width: 100%;">
            <button class="btn xCNBTNDefult xCNBTNDefult1Btn" style="width:100%" onclick="JSxGetPSHContentAdjustStatus()"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaCancel')?></button>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <div class="form-group" style="width: 100%;">
            <button class="btn xCNBTNPrimery" style="width:100%" onclick="$('#obtSubmitSMLKAdjStaForm').trigger('click')"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSave')?></button>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group" style="width: 100%;">
            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxSMLKAdjStaOpenRackChannelPanel()">+</button>
        </div>
    </div>
</div>

<form class="contact100-form validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmSMLKAdjStaForm" name="ofmSMLKAdjStaForm">
    <button style="display:none" type="submit" id="obtSubmitSMLKAdjStaForm" onclick="JSxSMLKAdjStaSave()"></button>
    <div class="row" style="margin-top: 20px;">
        <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
            <!-- เงื่อนไข -->
            <div class="panel panel-default" style="margin-bottom: 25px;">
                <div class="panel-heading xCNPanelHeadColor" role="tab" style="padding-top:10px;padding-bottom:10px;">
                    <label class="xCNTextDetail1"><?php echo language('document/document/document', 'tDocCondition'); ?></label>
                    <a class="xCNMenuplus" role="button" data-toggle="collapse" href="#odvSMLKAdjStaConditionPanel" aria-expanded="true">
                        <i class="fa fa-plus xCNPlus"></i>
                    </a>
                </div>
                <div id="odvSMLKAdjStaConditionPanel" class="xCNMenuPanelData panel-collapse collapse in" role="tabpanel">
                    <div class="panel-body xCNPDModlue">

                        <!-- สาขา -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaBch')?></label>
                            <div class="input-group">
                                <input 
                                    class="form-control xCNHide" 
                                    id="oetSMLKAdjStaAddBchCode" 
                                    name="oetSMLKAdjStaAddBchCode" 
                                    maxlength="5" 
                                    value="<?php echo !empty($aOneBch) ? $aOneBch['FTBchCode'] : ''; ?>">
                                <input 
                                    class="form-control xWPointerEventNone" 
                                    type="text" 
                                    id="oetSMLKAdjStaAddBchName" 
                                    name="oetSMLKAdjStaAddBchName" 
                                    value="<?php echo !empty($aOneBch) ? $aOneBch['FTBchName'] : ''; ?>"
                                    readonly>
                                <span class="input-group-btn">
                                    <button id="obtSMLKAdjStaAddBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?php echo !empty($aOneBch) ? 'disabled' : ''; ?>>
                                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                                    </button>
                                </span>
                            </div>
                        </div>
                        <!-- สาขา -->

                        <!-- ตู้ Locker -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaLocker')?></label>
                            <input 
                                class="form-control" 
                                type="text" 
                                id="ocmSMLKAdjStaLockerCode" 
                                name="ocmSMLKAdjStaLockerCode" 
                                value="<?=$tLockerCode?>" 
                                readonly="true">
                        </div>
                        <!-- ตู้ Locker -->

                        <!-- กลุ่มช่อง -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutTitleGroup')?></label>
                            <input type="hidden" id="ocmSMLKAdjAddStaRackCode-" name="ocmSMLKAdjAddStaRackCode-">
                            <select 
                                class="selectpicker form-control" 
                                id="ocmSMLKAdjAddStaRackCode" 
                                name="ocmSMLKAdjAddStaRackCode" 
                                maxlength="1" title="<?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSelectGroupChannel')?>" 
                                onchange="JSvSMLKAdjStaClearTemp()">
                                <?php
                                if(!empty($aRack['aItems'])){
                                 foreach($aRack['aItems'] as $index => $item) { ?>
                                    <option value="<?=$item['FTRakCode']?>" <?php echo ($index == 0) ? 'selected' : ''; ?>><?=$item['FTRakName']?></option>
                                <?php } 
                                 }
                                ?>
                            </select>
                        </div>
                        <!-- กลุ่มช่อง -->

                        <!-- สถานะ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSta')?></label>
                            <select 
                                class="selectpicker form-control" 
                                id="ocmSMLKAdjStaAddStatus" 
                                name="ocmSMLKAdjStaAddStatus" 
                                maxlength="1" 
                                title="<?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSelectSta')?>" 
                                onchange="JSvSMLKAdjStaUpdateStaUseInTemp()">
                                <option value="1" selected><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaEmpty')?></option>
                                <option value="2"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaUse')?></option>
                                <option value="3"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaDisable')?></option>
                            </select>
                        </div>
                        <!-- สถานะ -->

                        <!-- วันที่ปรับ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaAdjDate')?></label>
                            <div class="form-group">
                                <input 
                                class="form-control" 
                                type="text" 
                                id="oetSMLKAdjStaAddDate" 
                                name="oetSMLKAdjStaAddDate" 
                                value="<?=date('Y-m-d')?>" 
                                readonly="true">
                                <?php if(false) { ?>
                                <input 
                                    type="text" 
                                    class="form-control xCNDatePicker xCNInputMaskDate" 
                                    id="oetSMLKAdjStaAddDate" 
                                    name="oetSMLKAdjStaAddDate" 
                                    value="<?=date('Y-m-d')?>">
                                <span class="input-group-btn">
                                    <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetSMLKAdjStaAddDate').focus()">
                                        <img src="<?php echo base_url('/application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                                    </button>
                                </span>
                                <?php } ?>
                            </div>
                        </div>
                        <!-- วันที่ปรับ -->

                        <!-- ผู้ปรับ -->
                        <div class="form-group">
                            <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaAdjUsr')?></label>
                            <input type="hidden" id="ohdSMLKAdjStaUserCode" name="ohdSMLKAdjStaUserCode" value="<?=$aUserLogin['FTUsrCode']?>">
                            <input 
                                class="form-control" 
                                type="text" 
                                id="ocmSMLKAdjStaUserName" 
                                name="ocmSMLKAdjStaUserName" 
                                value="<?=$aUserLogin['FTUsrName']?>" 
                                readonly="true">
                        </div>
                        <!-- ผู้ปรับ -->

                    </div> 
                </div> 
            </div>
            <!-- เงื่อนไข -->
        </div>
        <!-- Begin Data Table -->
        <div class="col-xs-12 col-sm-12 col-md-9 col-lg-9">
            <div id="odvSMLKAdjStatusDataTableTempList"></div>
        </div>
        <!-- End Data Table -->
    </div>
</form>

<?php include('rack/wAdjustStatusRackChannelModal.php'); ?>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script>
    $('ducument').ready(function () {
        
    });
</script>
<?php include('script/jAdjustStatusAdd.php'); ?>
