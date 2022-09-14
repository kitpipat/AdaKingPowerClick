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

<input type="hidden" id="ohdSMLKAdjStaIsView" value="1">

<div class="row">
    <!--ฟิลเตอร์ค้นหา-->
    <div class="col-xs-12 col-sm-12 col-md-6 col-lg-6">
        <!-- Breadcrumb -->
        <ol id="oliMenuNav" class="breadcrumb">
            <li id="oliSMLKAdjStaTitle" class="xCNLinkClick" onclick="JSxGetPSHContentAdjustStatus()" style="cursor:pointer"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaStaAdj')?></li>
            <li id="oliSMLKAdjStaAdd" class="active" style="display: inline-block;"><a><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaHis')?></a></li>
        </ol>
        <!-- Breadcrumb -->
    </div>
</div>

<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="form-group" style="width: 100%;">
            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxSMLKAdjStaCallAddPage()">+</button>
        </div>
    </div>
</div>

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
                        <div class="form-group">
                            <input 
                                class="form-control xCNHide" 
                                id="oetSMLKAdjStaAddBchCode" 
                                name="oetSMLKAdjStaAddBchCode" 
                                maxlength="5" 
                                value="<?=$tBchCode?>">
                            <input 
                                class="form-control" 
                                type="text"  
                                value="<?=$tBchName?>"
                                id="oetSMLKAdjStaAddBchName" 
                                name="oetSMLKAdjStaAddBchName"
                                readonly>
                        </div>
                    </div>
                    <!-- สาขา -->

                    <!-- ตู้ Locker -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaLocker')?></label>
                        <input 
                            class="form-control" 
                            id="ocmSMLKAdjStaLockerCode" 
                            name="ocmSMLKAdjStaLockerCode"
                            type="text" 
                            value="<?=$tPosCode?>" 
                            readonly="true">
                    </div>
                    <!-- ตู้ Locker -->

                    <!-- กลุ่มช่อง -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutTitleGroup')?></label>
                        <input 
                            class="form-control xCNHide" 
                            id="ocmSMLKAdjAddStaRackCode"
                            name="ocmSMLKAdjAddStaRackCode"
                            maxlength="5" 
                            value="<?=$tRackCode?>">
                        <input 
                            class="form-control" 
                            id="ocmSMLKAdjAddStaRackName"
                            name="ocmSMLKAdjAddStaRackCodeName"
                            type="text" 
                            value="<?=$tRackName?>" 
                            readonly="true">
                    </div>
                    <!-- กลุ่มช่อง -->

                    <!-- สถานะ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaSta')?></label>
                        <input 
                            class="form-control xCNHide" 
                            id="ocmSMLKAdjStaAddStatus"
                            name="ocmSMLKAdjStaAddStatus"
                            maxlength="5" 
                            value="">
                        <?php 
                        $tStaText = '';
                        if($tHisStaUse == '1'){$tStaText = language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaEmpty');}
                        if($tHisStaUse == '2'){$tStaText = language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaUse');}
                        if($tHisStaUse == '3'){$tStaText = language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaDisable');}
                        ?>
                        <input 
                            class="form-control" 
                            type="text" 
                            value="<?=$tStaText?>" 
                            readonly="true">
                    </div>
                    <!-- สถานะ -->

                    <!-- วันที่ปรับ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaAdjDate')?></label>
                        <div class="form-group">
                            <input 
                            class="form-control" 
                            type="text" 
                            value="<?=date_format(date_create($tHisDate), 'Y-m-d H:i:s')?>" 
                            readonly="true">
                        </div>
                    </div>
                    <!-- วันที่ปรับ -->

                    <!-- ผู้ปรับ -->
                    <div class="form-group">
                        <label class="xCNLabelFrm"><?=language('company/smart_locker_adjust_status/smartlockeradjsta', 'tSMLKAdjStaAdjUsr')?></label>
                        <input 
                            class="form-control" 
                            type="text" 
                            value="<?=$tHisUserName?>" 
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

<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script>
    $('ducument').ready(function () {
        
    });
</script>
<?php include('script/jAdjustStatusAdd.php'); ?>
