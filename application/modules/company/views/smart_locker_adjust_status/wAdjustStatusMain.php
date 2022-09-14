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

<div class="row">
    
    <div class="col-xs-12 col-sm-12 col-md-3 col-lg-3">
        <!-- สาขา -->
        <div class="form-group">
            <label class="xCNLabelFrm">สาขา</label>
            <div class="input-group">
                <input 
                    class="form-control xCNHide" 
                    id="oetSMLKAdjStaBchCode" 
                    name="oetSMLKAdjStaBchCode" 
                    maxlength="5" 
                    value="<?php echo !empty($aOneBch) ? $aOneBch['FTBchCode'] : ''; ?>">
                <input 
                    class="form-control xWPointerEventNone" 
                    type="text" 
                    id="oetSMLKAdjStaBchName" 
                    name="oetSMLKAdjStaBchName" 
                    value="<?php echo !empty($aOneBch) ? $aOneBch['FTBchName'] : ''; ?>"
                    readonly>
                <span class="input-group-btn">
                    <button id="obtSMLKAdjStaBrowseBch" type="button" class="btn xCNBtnBrowseAddOn" <?php echo !empty($aOneBch) ? 'disabled' : ''; ?>>
                        <img src="<?php echo base_url('application/modules/common/assets/images/icons/find-24.png'); ?>">
                    </button>
                </span>
            </div>
        </div>
        <!-- สาขา -->
    </div>

    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
        <!-- กลุ่มช่อง -->
        <div class="form-group">
            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutTitleGroup')?></label>
            <select class="selectpicker form-control" id="ocmSMLKAdjStaRackCode" name="ocmSMLKAdjStaRackCode" maxlength="1">
                <option value=''><?=language('company/smartlockerlayout/smartlockerlayout', 'tSMLLayoutSelectAll')?></option>
                <?php foreach($aRack['aItems'] as $item) { ?>
                    <option value="<?=$item['FTRakCode']?>"><?=$item['FTRakName']?></option>
                <?php } ?>
            </select>
        </div>
        <!-- กลุ่มช่อง -->
    </div>

    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
        <!-- วันที่ -->
        <div class="form-group">
            <label class="xCNLabelFrm">วันที่</label>
            <div class="input-group">
                <input 
                    type="text" 
                    class="form-control xCNDatePicker xCNInputMaskDate" 
                    id="oetSMLKAdjStaDate" 
                    name="oetSMLKAdjStaDate">
                <span class="input-group-btn">
                    <button type="button" class="btn xCNBtnDateTime" onclick="$('#oetSMLKAdjStaDate').focus()">
                        <img src="<?php echo base_url('/application/modules/common/assets/images/icons/icons8-Calendar-100.png'); ?>">
                    </button>
                </span>
            </div>
        </div>
        <!-- วันที่ -->
    </div>

    <div class="col-xs-12 col-sm-12 col-md-1 col-lg-1">
        <div class="form-group" style="width: 100%;">
            <label class="xCNLabelFrm" style="width: 100%;">&nbsp;</label>
            <button class="btn xCNBTNPrimery" style="width:100%" onclick="JSvSMLKAdjStaCallPageDataTable(1)">ค้นหา</button>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
        <div class="form-group" style="width: 100%;">
            <label class="xCNLabelFrm" style="width: 100%;">&nbsp;</label>
            <button class="btn xCNBTNDefult xCNBTNDefult1Btn" style="width:100%" onclick="JSxSMLKAdjStaClearSearchData()"><?php echo language('common/main/main', 'tClearSearch'); ?></button>
        </div>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-2 col-lg-2">
        <div class="form-group" style="width: 100%;">
            <label class="xCNLabelFrm" style="width: 100%;">&nbsp;</label>
            <button class="xCNBTNPrimeryPlus" type="button" onclick="JSxSMLKAdjStaCallAddPage()">+</button>
        </div>
    </div>
    
</div>

<div class="row">
    <!-- Begin Data Table -->
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvSMLKAdjStatusDataTableList"></div>
    </div>
    <!-- End Data Table -->
</div>
<script src="<?php echo base_url('application/modules/common/assets/js/jquery.mask.js') ?>"></script>
<script src="<?php echo base_url('application/modules/common/assets/src/jFormValidate.js') ?>"></script>

<script>
    $('ducument').ready(function () {
        
    });
</script>
<?php include('script/jAdjustStatusMain.php'); ?>
