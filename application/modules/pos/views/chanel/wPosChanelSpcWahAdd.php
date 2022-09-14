<?php

    $tSesUsrLevel       = $this->session->userdata("tSesUsrLevel");

    if( $aDataList['tCode'] == '1' ){
        $tCSWRoute   = 'chanelEventSpcWahEdit';
        $tCSWAgnCode = $aDataList['aItems'][0]['FTAgnCode'];
        $tCSWAgnName = $aDataList['aItems'][0]['FTAgnName'];
        $tCSWBchCode = $aDataList['aItems'][0]['FTBchCode'];
        $tCSWBchName = $aDataList['aItems'][0]['FTBchName'];
        $tCSWType    = $aDataList['aItems'][0]['FTChnStaDoc'];
        $tCSWWahCode = $aDataList['aItems'][0]['FTWahCode'];
        $tCSWWahName = $aDataList['aItems'][0]['FTWahName'];
    }else{
        $tCSWRoute   = 'chanelEventSpcWahAdd';
        $tCSWAgnCode = $this->session->userdata("tSesUsrAgnCode");
        $tCSWAgnName = $this->session->userdata("tSesUsrAgnName");

        if( $tSesUsrLevel != "HQ" ){
            $tCSWBchCode = $this->session->userdata("tSesUsrBchCodeDefault");
            $tCSWBchName = $this->session->userdata("tSesUsrBchNameDefault");
        }else{
            $tCSWBchCode = "";
            $tCSWBchName = "";
        }

        $tCSWType    = '1';
        $tCSWWahCode = '';
        $tCSWWahName = '';
    }
?>

<form class="validate-form" action="javascript:void(0)" method="post" enctype="multipart/form-data" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmCSWAddEdit">
    <button style="display:none" type="submit" id="obtCSWSubmit" onclick="JSxCHNSpcWahSaveAddEdit('<?=$tCSWRoute?>')"></button>

    <input type="text" class="form-control xCNHide" id="oetCSWAgnCodeOld" name="oetCSWAgnCodeOld" value="<?php echo $tCSWAgnCode; ?>">
    <input type="text" class="form-control xCNHide" id="oetCSWBchCodeOld" name="oetCSWBchCodeOld" value="<?php echo $tCSWBchCode; ?>">
    <input type="text" class="form-control xCNHide" id="oetCSWWahCodeOld" name="oetCSWWahCodeOld" value="<?php echo $tCSWWahCode; ?>">

    <div class="panel-body" style="padding-top:20px !important;">
        <div class="row">
            <div class="col-xs-12 col-md-5 col-lg-5">

                <!-- ตัวแทนขาย -->
                <div class="form-group <?php if (!FCNbGetIsAgnEnabled()) : echo 'xCNHide'; endif; ?>">
                    <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCSWAgency'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCSWAgnCode" name="oetCSWAgnCode" value="<?php echo $tCSWAgnCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCSWAgnName" name="oetCSWAgnName" placeholder="" value="<?php echo $tCSWAgnName; ?>" readonly>
                        <span class="input-group-btn">
                            <button id="obtCSWBrowseAgn" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
                <!-- ตัวแทนขาย -->

                <!-- สาขา -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/poschannel/poschannel', 'tCSWBranch'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCSWBchCode" name="oetCSWBchCode" value="<?php echo $tCSWBchCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCSWBchName" name="oetCSWBchName" placeholder="" value="<?php echo $tCSWBchName; ?>" data-validate="<?=language('pos/poschannel/poschannel', 'tCSWValidateBranch');?>" readonly>
                        <span class="input-group-btn">
                            <button id="obtCSWBrowseBch" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
                <!-- สาขา -->

                <!-- ประเภทคลัง -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><?php echo language('pos/poschannel/poschannel', 'tCSWTypeWahouse'); ?></label>
                    <select id="osbCSWType" name="osbCSWType" class="form-control selectpicker">
                        <option value="1" <?php echo ($tCSWType == '1' ? 'selected' : ''); ?> ><?php echo language('pos/poschannel/poschannel', 'tCSWTypeWahouse1'); ?></option>
                        <option value="2" <?php echo ($tCSWType == '2' ? 'selected' : ''); ?> ><?php echo language('pos/poschannel/poschannel', 'tCSWTypeWahouse2'); ?></option>
                    </select>
                </div>
                <!-- ประเภทคลัง -->

                <!-- คลัง -->
                <div class="form-group">
                    <label class="xCNLabelFrm"><span style="color:red">*</span><?php echo language('pos/poschannel/poschannel', 'tCSWWahouse'); ?></label>
                    <div class="input-group">
                        <input type="text" class="form-control xCNHide" id="oetCSWWahCode" name="oetCSWWahCode" value="<?php echo $tCSWWahCode; ?>">
                        <input type="text" class="form-control xWPointerEventNone" id="oetCSWWahName" name="oetCSWWahName" placeholder="" value="<?php echo $tCSWWahName; ?>" data-validate="<?=language('pos/poschannel/poschannel', 'tCSWValidateWahouse');?>" readonly>
                        <span class="input-group-btn">
                            <button id="obtCSWBrowseWah" type="button" class="btn xCNBtnBrowseAddOn"><img class="xCNIconFind"></button>
                        </span>
                    </div>
                </div>
                <!-- คลัง -->
              
            </div>
        </div>
    </div>
</form> 

<script>

    var nLangEdit = '<?php echo $this->session->userdata("tLangEdit"); ?>';

    if( $('#oetCSWBchCode').val() != "" ){
        $('#obtCSWBrowseWah').attr('disabled', false);
    }else{
        $('#obtCSWBrowseWah').attr('disabled', true);
    }

    $('.selectpicker').selectpicker();

    $('#obtCSWBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oCSWBrowseAgencyOption = oCSWBrowseAgency({
                'tReturnInputCode': 'oetCSWAgnCode',
                'tReturnInputName': 'oetCSWAgnName',
                'tParamsChnAgn'   : $('#oetChnAgnCode').val()
            });
            JCNxBrowseData('oCSWBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var oCSWBrowseAgency = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tParamsChnAgn    = poReturnInput.tParamsChnAgn;
        var tWhere           = "";

        // ถ้า Channel กำหนดเฉพาะสาขา หน้ากำหนดคลังก็ต้องดึงมาเฉพาะสาขานั้น ตามมาสเตอร์ Channel
        if( tParamsChnAgn != "" ){
            tWhere += " AND TCNMAgency.FTAgnCode = '"+tParamsChnAgn+"' ";
        }

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdit]
            },
            Where:{
                Condition : [tWhere]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            NextFunc: {
                FuncName: 'JSxCSWNextFuncAgn',
                ArgReturn: ['FTAgnCode']
            },
            RouteAddNew: 'agency',
            BrowseLev: 1,
        }
        return oOptionReturn;
    }

    function JSxCSWNextFuncAgn(poArg){
        $('#obtCSWBrowseWah').attr('disabled', true);
        $('#oetCSWBchCode').val('');
        $('#oetCSWBchName').val('');
        $('#oetCSWWahCode').val('');
        $('#oetCSWWahName').val('');
        
    }

    $('#obtCSWBrowseBch').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oCSWBrowseBranchOption = oCSWBrowseBranch({
                'tReturnInputCode': 'oetCSWBchCode',
                'tReturnInputName': 'oetCSWBchName',
                'tParamsAgnCode'  : $('#oetCSWAgnCode').val(),
                'tParamsChnBch'   : $('#oetWahBchCodeCreated').val()
            });
            JCNxBrowseData('oCSWBrowseBranchOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var oCSWBrowseBranch = function(poReturnInput) {
        let tBchInputReturnCode = poReturnInput.tReturnInputCode;
        let tBchInputReturnName = poReturnInput.tReturnInputName;
        let tParamsAgnCode      = poReturnInput.tParamsAgnCode;
        let tParamsChnBch       = poReturnInput.tParamsChnBch;
        // let aBchArgReturn = poReturnInput.aArgReturn;

        var tUsrLevel 	  	= "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
        var tBchCodeMulti 	= "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tWhere 			= "";

        // ถ้า Channel กำหนดเฉพาะสาขา หน้ากำหนดคลังก็ต้องดึงมาเฉพาะสาขานั้น ตามมาสเตอร์ Channel
        if( tParamsChnBch != "" ){
            tWhere += " AND TCNMBranch.FTBchCode = '"+tParamsChnBch+"' ";
        }

        if( tParamsAgnCode != "" ){
            tWhere += " AND TCNMBranch.FTAgnCode = '"+tParamsAgnCode+"' ";
        }

        if(tUsrLevel != "HQ"){
            tWhere += " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+") ";
        }else{
            tWhere += "";
        }

        let oBchOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdit]
            },
            Where:{
                Condition : [tWhere]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tBchInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tBchInputReturnName, "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxCSWNextFuncBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        }
        return oBchOptionReturn;
    }

    function JSxCSWNextFuncBch(poArg){
        if( poArg != 'NULL' ){
            $('#obtCSWBrowseWah').attr('disabled', false);
        }else{
            $('#obtCSWBrowseWah').attr('disabled', true);
        }
        $('#oetCSWWahCode').val('');
        $('#oetCSWWahName').val('');
        
    }

    $('#obtCSWBrowseWah').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oCSWBrowseWahouseOption = oCSWBrowseWahouse({
                'tParamsBchCode'  : $('#oetCSWBchCode').val(),
                'tReturnInputCode': 'oetCSWWahCode',
                'tReturnInputName': 'oetCSWWahName',
            });
            JCNxBrowseData('oCSWBrowseWahouseOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var oCSWBrowseWahouse = function(poDataFnc){
        var tBchCode            = poDataFnc.tParamsBchCode;
        var tInputReturnCode    = poDataFnc.tReturnInputCode;
        var tInputReturnName    = poDataFnc.tReturnInputName;
        // var aArgReturn          = poDataFnc.aArgReturn;

        var oOptionReturn   = {
            Title: ["company/warehouse/warehouse","tWAHTitle"],
            Table: { Master:"TCNMWaHouse", PK:"FTWahCode"},
            Join: {
                Table: ["TCNMWaHouse_L"],
                On: ["TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse.FTBchCode=TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = '"+nLangEdit+"'"]
            },
            Where: {
                Condition : [" AND TCNMWaHouse.FTBchCode = '"+tBchCode+"' "]
            },
            GrideView:{
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWahCode','tWahName'],
                DataColumns: ['TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['',''],
                ColumnsSize: ['15%','75%'],
                Perpage: 5,
                WidthModal: 50,
                OrderBy: ['TCNMWaHouse.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType  : 'S',
                Value       : [tInputReturnCode,"TCNMWaHouse.FTWahCode"],
                Text        : [tInputReturnName,"TCNMWaHouse_L.FTWahName"]
            },
            RouteAddNew: 'warehouse',
            BrowseLev: 1
        }
        return oOptionReturn;
    }


</script>

