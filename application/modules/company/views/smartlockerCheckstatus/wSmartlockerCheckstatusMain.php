
<div class="row">

    <!--ค้นหาสาขา-->
    <?php 
    $tSesUserLevel = $this->session->userdata("tSesUsrLevel");
    if (strpos($tBchCode, ',') !== false) {
        $tMutiBch = true;
    }else{
        $tMutiBch = false;
    } 
    if($tSesUserLevel == 'HQ' && $tMutiBch == true){ ?>
        <div class="col-xs-4 col-md-2 col-lg-2">
            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch')?></label>
            <div class="input-group">
                <input name="oetInputPSHCheckStatusBchName" id="oetInputPSHCheckStatusBchName" class="form-control xCNRemoveValue"  type="text" readonly="" placeholder="<?=language('company/shopgpbyshp/shopgpbyshp','tSMLLayoutTableBch')?>">
                <input name="oetInputPSHCheckStatusBchCode" id="oetInputPSHCheckStatusBchCode" class="form-control xCNHide xCNRemoveValue"  type="text" >
                <span class="input-group-btn">
                    <button class="btn xCNBtnBrowseAddOn" id="obtPSHCheckStatusBrowseBranch" type="button">
                        <img src="<?=base_url().'/application/modules/common/assets/images/icons/find-24.png'?>">
                    </button>
                </span>
            </div>
        </div>
    <?php }else{ ?>
        <div class="col-xs-4 col-md-2 col-lg-2">
            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTableBch')?></label>
            <input type="hidden" id="oetInputPSHCheckStatusBchCode" value="<?=$tNameBch['raItems']['FTBchCode']?>">
            <input type="text" disabled value="<?=$tNameBch['raItems']['FTBchName']?>">
        </div>
    <?php } ?>

    <!--กลุ่มช่อง-->
    <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
        <div class="form-group">
            <label class="xCNLabelFrm"><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutTitleGroup')?></label>
            <select class="form-control" id="osmPSHCheckStatusLayoutRack">
                <?php 
                    if($aResultRack['rtCode'] == 800){ ?>
                        <option value=''><?=language('company/smartlockerlayout/smartlockerlayout','tSMLLayoutSelectAll')?></option>
                    <?php }else{ 
                        for($i=0; $i<FCNnHSizeOf($aResultRack['aList']); $i++){ ?>
                            <option value="<?=$aResultRack['aList'][$i]['FTRakCode']?>"><?=$aResultRack['aList'][$i]['FTRakName']?></option>
                        <?php } ?>
                    <?php } ?>
            </select>
        </div>
    </div>

    <!--BTN ค้นหา-->
    <div class="col-xs-4 col-sm-2 col-md-2 col-lg-2">
        <div class="form-group" id="odvPSHCheckStatusProcess" style="margin-top: 27px;">
            <button type="submit" style="float: right;  width: 100%;" id="" class="btn btn-primary" onclick="JSvPSHCheckStatusTableData();"><?php echo language('company/smartlockerCheckstatus/smartlockerCheckstatus', 'tPSHCheckStatusBTNProcess')?></button>
        </div>
    </div>

    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div id="odvPSHCheckStatusContent" class="row" style="margin-top: 15px"></div>
    </div>

</div>
<?php include "script/jSmartlockerCheckstatus.php"; ?>

<script>
    //Browse สาขา
    var nLangEdits  = <?=$this->session->userdata("tLangEdit")?>;
    var tBchCode    = "<?=$tBchCode?>";
    var oSMLBrowseCheckStatusBranch = {
        Title   : ['company/branch/branch','tBCHTitle'],
        Table   : {Master:'TCNMBranch',PK:'FTBchCode',PKName:'FTBchName'},
        Join    : {
            Table   : ['TCNMBranch_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = '+nLangEdits,]
        },
        Where   : {
            Condition : ["AND TCNMBranch.FTBchCode IN ("+tBchCode+") "]
        },
        GrideView   : {
            ColumnPathLang	: 'company/branch/branch',
            ColumnKeyLang	: ['tBCHCode','tBCHName'],
            ColumnsSize     : ['15%','75%'],
            WidthModal      : 50,
            DataColumns		: ['TCNMBranch.FTBchCode','TCNMBranch_L.FTBchName'],
            DataColumnsFormat : ['',''],
            Perpage			: 5,
            OrderBy			: ['TCNMBranch_L.FTBchName'],
            SourceOrder		: "ASC"
        },
        CallBack:{
            ReturnType	: 'S',
            Value		: ["oetInputPSHCheckStatusBchCode","TCNMBranch.FTBchCode"],
            Text		: ["oetInputPSHCheckStatusBchName","TCNMBranch_L.FTBchName"],
        }
        // DebugSQL : true
    }
    $('#obtPSHCheckStatusBrowseBranch').click(function(){ 
        JCNxBrowseData('oSMLBrowseCheckStatusBranch'); 
        JCNxCloseLoading();
    });
</script>