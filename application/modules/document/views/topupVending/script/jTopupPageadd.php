<script>
    var nLangEdit       = '<?php echo $nLangEdit; ?>';
    var tUsrApv         = '<?php echo $tUsrApv; ?>';
    var tUserLoginLevel = '<?php echo $tUserLoginLevel; ?>';
    var bIsAddPage      = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
    var bIsApv          = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
    var bIsCancel       = <?php echo ($bIsCanCel) ? 'true' : 'false'; ?>;
    var bIsApvOrCancel  = <?php echo ($bIsApvOrCanCel) ? 'true' : 'false'; ?>;
    // console.log(tUserLoginLevel);
    $(document).ready(function() {

        $('#ocmTUVStaShwPdt , #ocbTUVStaShwPdtInStk').change(function(){
            JSxTopUpVendingGetPdtLayoutDataTableInTmp();
        });

        JSxTopUpVendingGetPdtLayoutDataTableInTmp();

        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
        });

        $('#obtXthDocDate').click(function() {
            event.preventDefault();
            $('#oetXthDocDate').datepicker('show');
        });

        $('#obtXthDocTime').click(function() {
            event.preventDefault();
            $('#oetXthDocTime').datetimepicker('show');
        });

        $('#obtXthRefExtDate').click(function() {
            event.preventDefault();
            $('#oetXthRefExtDate').datepicker('show');
        });

        $('#obtXthRefIntDate').click(function() {
            event.preventDefault();
            $('#oetXthRefIntDate').datepicker('show');
        });

        $('#obtXthTnfDate').click(function() {
            event.preventDefault();
            $('#oetXthTnfDate').datepicker('show');
        });

        $('.xCNTimePicker').datetimepicker({
            format: 'HH:mm:ss'
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });

        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#ocbTopUpVendingAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbTopUpVendingAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetTopUpVendingDocNo');
            if (bIsChecked) {
                $(oInputDocNo).attr('readonly', true);
                $(oInputDocNo).attr('disabled', true);
                $(oInputDocNo).val("");
                $(oInputDocNo).parents('.form-group').removeClass('has-error').find('em').hide();
            } else {
                $(oInputDocNo).removeAttr('readonly');
                $(oInputDocNo).removeAttr('disabled');
            }
        });


        if (tUserLoginLevel == 'HQ') {
            if (bIsAddPage) {
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);

                $('#obtBrowseTopUpVendingPos').attr('disabled', true);
                $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            } else {
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        }

        if (tUserLoginLevel == 'BCH') {
            $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            $('#obtBrowseTopUpVendingPos').attr('disabled', true);
            if (bIsAddPage) {
                $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            } else {
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        }

        if (tUserLoginLevel == 'SHP') {
            $('#obtBrowseTopUpVendingMER').attr('disabled', true);
            var tShpcount   = '<?=$this->session->userdata("nSesUsrShpCount");?>';
            if(tShpcount < 2){
                $('#obtBrowseTopUpVendingShp').attr('disabled',false);
            }
            if (bIsAddPage) {
                $('#obtBrowseTopUpVendingWah').attr('disabled', true);
            } else {
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        }

        if ($('#oetTopUpVendingWahCode').val() != "") {
            $('#obtTopUpVendingControlForm').attr('disabled', false);
        } else {
            $('#obtTopUpVendingControlForm').attr('disabled', true);
        }

        if (<?= !FCNbGetIsShpEnabled() ? '1' : '0' ?>){
            $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            $('#obtBrowseTopUpVendingWah').attr('disabled', false);
        }
        
        
        if(bIsApvOrCancel && !bIsAddPage){
            $('#obtTFWApprove').hide();
            $('#obtTFWCancel').hide();
            $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
            $('.xCNBTNMngTable').attr('disabled', true);
        }else{
            $('#odvBtnAddEdit .btn-group').show();
        }

        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });
        JSxTopUpVendingDsiabledInput();
    });

    /*===== Begin Event Browse =========================================================*/
    // เลือกสาขา
    $("#obtBrowseTopUpVendingBCH").click(function(){
        var nStaChkDataDT   = $('#otbDOCPdtTable #odvTBodyTUVPdtAdvTableList .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            tUsrLevel   = "<?=$this->session->userdata('tSesUsrLevel')?>";
            tBchMulti   = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            tSQLWhere   = "";
            if(tUsrLevel != "HQ"){
                tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
            }
            window.oBrowseTopUpVendingBranch = {
                Title   : ['authen/user/user', 'tBrowseBCHTitle'],
                Table   : {
                    Master: 'TCNMBranch',
                    PK: 'FTBchCode'
                },
                Join: {
                    Table: ['TCNMBranch_L'],
                    On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: [tSQLWhere]
                },
                GrideView: {
                    ColumnPathLang: 'authen/user/user',
                    ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                    ColumnsSize: ['10%', '75%'],
                    DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                    DataColumnsFormat: ['', ''],
                    WidthModal: 50,
                    Perpage: 10,
                    OrderBy: ['TCNMBranch.FTBchCode'],
                    SourceOrder: "ASC"
                },
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetTopUpVendingBCHCode", "TCNMBranch.FTBchCode"],
                    Text: ["oetTopUpVendingBCHName", "TCNMBranch_L.FTBchName"]
                },
                NextFunc: {
                    FuncName: 'JSxTopUpVendingCallbackBch',
                    ArgReturn: ['FTBchCode']
                },
                RouteAddNew: 'branch',
                BrowseLev: 1
            };
            JCNxBrowseData('oBrowseTopUpVendingBranch');
        }else{
            $('#odvTopUpVendingPopupFoundDataInTblDT #ohdTopUpVendingTypeClick').val('Bch');
            $('#odvTopUpVendingPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกกลุ่มธุรกิจ
    $("#obtBrowseTopUpVendingMER").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable #odvTBodyTUVPdtAdvTableList .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            window.oBrowseTopUpVendingMch = {
                Title: ['company/warehouse/warehouse', 'tWAHBwsMchTitle'],
                Table: {
                    Master: 'TCNMMerchant',
                    PK: 'FTMerCode'
                },
                Join: {
                    Table: ['TCNMMerchant_L'],
                    On: ['TCNMMerchant.FTMerCode = TCNMMerchant_L.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "') != 0"]
                },
                GrideView: {
                    ColumnPathLang: 'company/warehouse/warehouse',
                    ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                    DataColumnsFormat: ['', ''],
                    Perpage: 10,
                    OrderBy: ['TCNMMerchant.FTMerCode'],
                    SourceOrder: "ASC"
                },
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetTopUpVendingMchCode", "TCNMMerchant.FTMerCode"],
                    Text: ["oetTopUpVendingMchName", "TCNMMerchant_L.FTMerName"],
                },
                NextFunc: {
                    FuncName: 'JSxTopUpVendingCallbackMer',
                    ArgReturn: ['FTMerCode', 'FTMerName']
                },
                BrowseLev: 1,
                //DebugSQL : true
            };
            JCNxBrowseData('oBrowseTopUpVendingMch');
        }else{
            $('#odvTopUpVendingPopupFoundDataInTblDT #ohdTopUpVendingTypeClick').val('Mer');
            $('#odvTopUpVendingPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกร้านค้า / รูปแบบการจัดสินค้า
    $("#obtBrowseTopUpVendingShp").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable #odvTBodyTUVPdtAdvTableList .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            window.oBrowseTopUpVendingShp = {
                Title: ['company/shop/shop', 'tSHPTitle_LAYOUT'],
                Table: {
                    Master: 'TCNMShop',
                    PK: 'FTShpCode'
                },
                Join: {
                    Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
                    On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                        'TCNMShop.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMShop.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID= ' + nLangEdits
                    ]
                },
                Where: {
                    Condition: [
                        function() {
                            // Where Branch Shop
                            var tBchCode        = $("#oetTopUpVendingBCHCode").val();
                            var tWhereBchCode   = "";
                            if(tBchCode != ""){
                                tWhereBchCode   = " AND TCNMShop.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "' ";
                            }

                            // Where Merchant
                            var tMerCode        = $('#oetTopUpVendingMchCode').val();
                            var tWhereMerCode   = "";
                            if(tMerCode != ""){
                                tWhereMerCode   = " AND TCNMShop.FTMerCode = '" + $("#oetTopUpVendingMchCode").val() + "'";
                            }

                            var tSQL = "AND TCNMShop.FTShpStaActive = 1"+tWhereBchCode+tWhereMerCode;
                            return tSQL;
                        }
                    ]
                },
                GrideView: {
                    ColumnPathLang: 'company/shop/shop',
                    ColumnKeyLang: ['tShopCode_LAYOUT', 'tShopName_LAYOUT'],
                    ColumnsSize: ['25%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
                    DataColumnsFormat: ['', '', '', '', '', ''],
                    DisabledColumns: [2, 3, 4, 5],
                    Perpage: 10,
                    OrderBy: ['TCNMShop_L.FTShpCode'],
                    SourceOrder: "ASC"
                },
                CallBack: {
                    ReturnType: 'S',
                    Value: ["oetTopUpVendingShpCode", "TCNMShop.FTShpCode"],
                    Text: ["oetTopUpVendingShpName", "TCNMShop_L.FTShpName"],
                },
                NextFunc: {
                    FuncName: 'JSxTopUpVendingCallbackShp',
                    ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
                },
                BrowseLev: 1

            }
            JCNxBrowseData('oBrowseTopUpVendingShp');
        }else{
            $('#odvTopUpVendingPopupFoundDataInTblDT #ohdTopUpVendingTypeClick').val('Shp');
            $('#odvTopUpVendingPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกตู้
    $("#obtBrowseTopUpVendingPos").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable #odvTBodyTUVPdtAdvTableList .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            var bIsShopEnabled  = '<?= FCNbGetIsShpEnabled() ? '1' : '0' ?>';
            var tWahMasterTable = 'TVDMPosShop';
            var tPK             = "FTPosCode"; 
            var oJoinCondition  = {
                    Table: ['TCNMPos', 'TCNMPos_L', 'TCNMWaHouse', 'TCNMWaHouse_L'],
                    On: ['TVDMPosShop.FTPosCode = TCNMPos.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos.FTBchCode',
                        'TVDMPosShop.FTPosCode = TCNMPos_L.FTPosCode AND TVDMPosShop.FTBchCode = TCNMPos_L.FTBchCode',
                        'TVDMPosShop.FTPosCode = TCNMWaHouse.FTWahRefCode AND TCNMWaHouse.FTWahStaType = 6 AND TCNMPos.FTBchCode = TCNMWaHouse.FTBchCode',
                        'TCNMWaHouse.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits
                    ]
                };
            var aCondition  = [
                function() {
                    var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetTopUpVendingShpCode").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                    tSQL += " AND TCNMPos.FTPosType = '4'";
                    return tSQL;
                }
            ];
            var aDataColumns        = ['TVDMPosShop.FTPosCode', 'TCNMPos_L.FTPosName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'];
            var aDataColumnsFormat  = ['', '', '', '', '', ''];
            var aDisabledColumns    = [2, 3, 4, 5];
            var aArgReturn          = ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName'];
            window.oBrowseTopUpVendingPos = {
                Title   : ['pos/posshop/posshop', 'tPshTBPosCode'],
                Table   : {
                    Master  : tWahMasterTable,
                    PK      : tPK
                },
                Join    : oJoinCondition,
                Where   : {
                    Condition       : aCondition
                },
                GrideView: {
                    ColumnPathLang  : 'pos/posshop/posshop',
                    ColumnKeyLang   : ['tPshBRWShopTBCode', 'tPshBRWPosTBName'],
                    ColumnsSize     : ['25%', '75%'],
                    WidthModal      : 50,
                    DataColumns     : aDataColumns,
                    DataColumnsFormat: aDataColumnsFormat,
                    DisabledColumns : aDisabledColumns,
                    Perpage         : 10,
                    OrderBy         : [tWahMasterTable + '.FTPosCode'],
                    SourceOrder     : "ASC"
                },
                CallBack: {
                    ReturnType  : 'S',
                    Value       : ["oetTopUpVendingPosCode", tWahMasterTable + ".FTPosCode"],
                    Text        : ["oetTopUpVendingPosName", "TCNMPos_L.FTPosName"],
                },
                NextFunc: {
                    FuncName    : 'JSxTopUpVendingCallbackPos',
                    ArgReturn   : aArgReturn
                },
                /*BrowseLev: 1*/

            }
            JCNxBrowseData('oBrowseTopUpVendingPos');
        }else{
            $('#odvTopUpVendingPopupFoundDataInTblDT #ohdTopUpVendingTypeClick').val('Pos');
            $('#odvTopUpVendingPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกคลังสินค้า
    $("#obtBrowseTopUpVendingWah").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable #odvTBodyTUVPdtAdvTableList .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            var bIsShopEnabled = '<?= FCNbGetIsShpEnabled() ? '1' : '0' ?>';
            window.oBrowseTopUpVendingWah = {
                Title   : ['company/warehouse/warehouse', 'tWAHTitle'],
                Table   : {
                    Master  : 'TVDMPdtLayout',
                    PK      : 'FTWahCode'
                },
                Join: {
                    Table   : ["TCNMWaHouse_L"],
                    On      : ["TCNMWaHouse_L.FTWahCode = TVDMPdtLayout.FTWahCode AND TCNMWaHouse_L.FTBchCode = TVDMPdtLayout.FTBchCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits, ]
                },
                Where: {
                    Condition: [
                        function() {
                            var tSQL = "";
                            if(bIsShopEnabled == 1){
                                tSQL = " AND TVDMPdtLayout.FTBchCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                                tSQL += " AND TVDMPdtLayout.FTShpCode = '" + $('#oetTopUpVendingShpCode').val() + "'";
                                tSQL += " AND TVDMPdtLayout.FTWahCode != '' ";
                            } else {
                                tSQL = " AND TCNMWaHouse.FTWahRefCode = '" + $("#oetTopUpVendingBCHCode").val() + "'";
                            }
                            return tSQL;
                        }
                    ]
                },
                GrideView: {
                    ColumnPathLang      : 'company/warehouse/warehouse',
                    ColumnKeyLang       : ['tWahCode', 'tWahName'],
                    DataColumns         : ['TVDMPdtLayout.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat   : ['', ''],
                    DistinctField       : [0],
                    ColumnsSize         : ['15%', '75%'],
                    Perpage             : 10,
                    WidthModal          : 50,
                    OrderBy             : ['TCNMWaHouse_L.FTWahCode'],
                    SourceOrder         : "ASC"
                },
                CallBack: {
                    ReturnType  : 'M',
                    Value       : ["oetTopUpVendingWahCode", "TVDMPdtLayout.FTWahCode"],
                    Text        : ["oetTopUpVendingWahName", "TCNMWaHouse_L.FTWahName"],
                },
                NextFunc: {
                    FuncName    : 'JSxTopUpVendingCallbackWah',
                    ArgReturn   : []
                },
                RouteAddNew     : 'warehouse',
                BrowseLev       : 1,
                // DebugSQL        : true
            }
            JCNxBrowseData('oBrowseTopUpVendingWah');
        }else{
            $('#odvTopUpVendingPopupFoundDataInTblDT #ohdTopUpVendingTypeClick').val('Wah');
            $('#odvTopUpVendingPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกขนส่งโดย
    $("#obtSearchShipVia").click(function() {
        JSxCheckPinMenuClose(); 
        oTFWBrowseShipVia = {
            Title: ['document/producttransferwahouse/producttransferwahouse', 'tTFWShipViaModalTitle'],
            Table: {
                Master: 'TCNMShipVia',
                PK: 'FTViaCode'
            },
            Join: {
                Table: ['TCNMShipVia_L'],
                On: [
                    "TCNMShipVia.FTViaCode = TCNMShipVia_L.FTViaCode AND TCNMShipVia_L.FNLngID = " + nLangEdits
                ]
            },
            GrideView: {
                ColumnPathLang: 'document/producttransferwahouse/producttransferwahouse',
                ColumnKeyLang: ['tTFWShipViaCode', 'tTFWShipViaName'],
                DataColumns: ['TCNMShipVia.FTViaCode', 'TCNMShipVia_L.FTViaName'],
                DataColumnsFormat: ['', ''],
                ColumnsSize: [''],
                Perpage: 10,
                WidthModal: 50,
                OrderBy: ['TCNMShipVia.FTViaCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetTopUpVendingViaCode", "TCNMShipVia.FTViaCode"],
                Text: ["oetTopUpVendingViaName", "TCNMShipVia_L.FTViaName"],
            },
            BrowseLev: 1
        }
        JCNxBrowseData('oTFWBrowseShipVia');
    });

    /*===== End Event Browse ===========================================================*/

    /*===== Begin Callback Browse ======================================================*/
    // Browse Bch Callback
    function JSxTopUpVendingCallbackBch(params) {
        var tBchCode    = $('#oetTopUpVendingBCHCode').val();
        $('#oetTopUpVendingMchCode').val("");
        $('#oetTopUpVendingMchName').val("");

        $('#oetTopUpVendingShpCode').val("");
        $('#oetTopUpVendingShpName').val("");

        $('#oetTopUpVendingPosCode').val("");
        $('#oetTopUpVendingPosName').val("");

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);
        if (tBchCode != "") {
            $('#obtBrowseTopUpVendingMER').attr('disabled', false);
            $('#obtBrowseTopUpVendingShp').attr('disabled', false);
        }
    }

    // Browse Mer Callback
    function JSxTopUpVendingCallbackMer(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', false);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);

        $('#oetTopUpVendingShpCode').val("");
        $('#oetTopUpVendingShpName').val("");

        $('#oetTopUpVendingPosCode').val("");
        $('#oetTopUpVendingPosName').val("");

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");

        if (tBchCode != "" && tMerCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
            }
        }
    }

    // Browse Shop Callback
    function JSxTopUpVendingCallbackShp(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();
        var tShpCode = $('#oetTopUpVendingShpCode').val();

        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);

        $('#oetTopUpVendingPosCode').val("");
        $('#oetTopUpVendingPosName').val("");

        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");


        if (tBchCode != "" && tShpCode != "") {

            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }

        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
            }
        }
    }

    // Browse Pos Callback
    function JSxTopUpVendingCallbackPos(params) {

        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();
        var tShpCode = $('#oetTopUpVendingShpCode').val();
        var tPosCode = $('#oetTopUpVendingPosCode').val();
        var tWahCode = $('#oetTopUpVendingWahCode').val();
        $('#obtBrowseTopUpVendingMER').attr('disabled', true);
        $('#obtBrowseTopUpVendingShp').attr('disabled', true);
        $('#obtBrowseTopUpVendingPos').attr('disabled', true);
        $('#obtBrowseTopUpVendingWah').attr('disabled', true);
        $('#oetTopUpVendingWahCode').val("");
        $('#oetTopUpVendingWahName').val("");
        if (tBchCode != "" && tShpCode != "" && tPosCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {

                var tShpcount = '<?=$this->session->userdata("nSesUsrShpCount");?>';
                if(tShpcount < 2){
                    $('#obtBrowseTopUpVendingShp').attr('disabled',true);
                }else{
                    $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                }
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
                $('#obtBrowseTopUpVendingWah').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTopUpVendingMER').attr('disabled', false);
                $('#obtBrowseTopUpVendingShp').attr('disabled', false);
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {
                $('#obtBrowseTopUpVendingPos').attr('disabled', false);
            }
        }


    }

    // Browse Warehouse Callback
    function JSxTopUpVendingCallbackWah(params) {
        var tBchCode = $('#oetTopUpVendingBCHCode').val();
        var tMerCode = $('#oetTopUpVendingMchCode').val();
        var tShpCode = $('#oetTopUpVendingShpCode').val();
        var tPosCode = $('#oetTopUpVendingPosCode').val();
        var tWahCode = $('#oetTopUpVendingWahCode').val();

        if (tBchCode != "" && tShpCode != "" && tPosCode != "" && tWahCode != "") {
            $('#obtTopUpVendingControlForm').attr('disabled', false);
        } else {
            $('#obtTopUpVendingControlForm').attr('disabled', true);
        }
    }
    /*===== End Callback Browse ========================================================*/

    $('#obtTopUpVendingControlForm').unbind().bind('click', function() {
        if($('#oetTopUpVendingWahName').val() == ''){
            $('#oetTopUpVendingWahName').focus();
            return;
        }
        if($('#ohdTFWRoute').val()=='TopupVendingEventEdit'){
            $('#odvTopUpVendingPopupClear').modal('show');
        }else{
            JCNxOpenLoading();
            JSxTopUpVendingInsertPdtLayoutToTemp();
        }
        // JSxTopUpVendingGetPdtLayoutDataTableInTmp(1);
    });

    $('#obtTopUpVendingConfirm').unbind().bind('click', function() {
        $('#odvTopUpVendingPopupClear').modal('hide');
        JCNxOpenLoading();
        JSxTopUpVendingInsertPdtLayoutToTemp();
    });
    
    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingInsertPdtLayoutToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tMerCode = $('#oetTopUpVendingMchCode').val();
            var tShpCode = $('#oetTopUpVendingShpCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCodeInShop = $('#oetTopUpVendingWahCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "TopupVendingInsertPdtLayoutToTmp",
                data: {
                    tBchCode: tBchCode,
                    tMerCode: tMerCode,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tWahCodeInShop: tWahCodeInShop
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    console.log(oResult);
                    JSxTopUpVendingGetPdtLayoutDataTableInTmp(1);
                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Get PDT Layout in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingGetPdtLayoutDataTableInTmp(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tMerCode = $('#oetTopUpVendingMchCode').val();
            var tShpCode = $('#oetTopUpVendingShpCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCode = $('#oetTopUpVendingWahCode').val();

            // Create By : Napat(Jame) 01/09/2020
            var tStaShwPdt      = $('#ocmTUVStaShwPdt').val();
            var tStaShwPdtInStk = $("#ocbTUVStaShwPdtInStk").prop("checked");

            var tSearchAll = $('#oetTopUpVendingPdtLayoutSearchAll').val();

            JCNxOpenLoading();

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "TopupVendingGetPdtLayoutDataTableInTmp",
                data: {
                    tBchCode: tBchCode,
                    tMerCode: tMerCode,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tWahCode: tWahCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll,
                    tTypePage : '<?=$tRoute?>',
                    tStaShwPdt: tStaShwPdt,
                    tStaShwPdtInStk: tStaShwPdtInStk
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvTopupVendingPdtDataTable').html(tResult);
                    JSxTopUpVendingDsiabledInput();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    var bUniqueTopUpVendingCode;
    $.validator.addMethod(
        "uniqueTopUpVendingCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tTopUpVendingCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "TopupVendingUniqueValidate",
                    data: "tTopUpVendingCode=" + tTopUpVendingCode,
                    dataType: "JSON",
                    success: function(poResponse) {
                        bUniqueTopUpVendingCode = (poResponse.bStatus) ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Custom validate uniqueTopUpVendingCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniqueTopUpVendingCode;

            } else {
                JCNxShowMsgSessionExpired();
            }

        },
        "Doc No. is Already Taken"
    );

    /**
     * Functionality : Validate Form
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingValidateForm() {
        var oTopUpVendingForm = $('#ofmTopUpVendingForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetTopUpVendingDocNo: {
                    required: true,
                    maxlength: 20,
                    uniqueTopUpVendingCode: bIsAddPage
                },
                oetTopUpVendingDocDate: {
                    required: true
                },
                oetTopUpVendingDocTime: {
                    required: true
                },
                // oetTopUpVendingMchName: {
                //     required: true
                // },
                oetTopUpVendingShpName: {
                    required: true
                },
                oetTopUpVendingPosName: {
                    required: true
                },
                oetTopUpVendingWahName: {
                    required: true
                }
            },
            messages: {
                oetCreditNoteDocNo: {
                    "required": $('#oetCreditNoteDocNo').attr('data-validate-required')
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').removeClass("has-error");
            },
            submitHandler: function(form) {
                JSxTopUpVendingSave();
            }
        });
    }

    /**
     * Functionality : Save Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingSave() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            tCheckAfterSave = true;
            var nTotal      = 0;
            var nCountZero  = 0;
            $('#otbDOCPdtTable > tbody  > tr:not(.xWNotFoundData)').each(function(index, tr) { 
                nTotal++;
                var nValue = $(tr).find('.xCNTopUpVendingQty').val();
                if(nValue == 0 || nValue == '0'){
                    tCheckAfterSave = false;
                    nCountZero++;
                }
            });

            console.log('Total: '+nTotal);
            console.log('nCountZero: '+nCountZero);

            if(tCheckAfterSave == false){
                $('#odvTOPUPVDCheckItemHaveTopUpZero').modal('show');

                //ถ้าไม่มีการ เติม 0 วิ่งไปฟังก์ save เลย + ถ้ากดยืนยัน
                $('.xCNConfrimCheckItemHaveTopUpZero').off();
                $('.xCNConfrimCheckItemHaveTopUpZero').on('click', function(event){
                    if( nTotal == nCountZero ){ // ลบราการสินค้าที่มีจำนวนการเติม = 0 แล้วไม่มีรายการสินค้าเหลือไม่ต้องบันทึกเอกสาร
                        $('#odvTOPUPVDCheckItemHaveTopUpZero').modal('hide');
                        JSxTVDDelPdtValueZero();
                    }else{                      // ลบราการสินค้าที่มีจำนวนการเติม = 0 แล้วยังมีรายการสินค้าเหลืออยู่มากกว่า 0 ให้ทำการบันทึก
                        JSxTopUpVendingSaveToDatabase('2');
                    }
                });
            }else{
                if( nTotal > 0 ){
                    //ถ้าไม่มีการ adj 0 วิ่งไปฟังก์ save เลย + ถ้ากดยืนยัน
                    JSxTopUpVendingSaveToDatabase('1');
                }else{
                    FSvCMNSetMsgWarningDialog('ไม่สามารถบันทึกเอกสารได้ เนื่องจากไม่พบรายการสินค้า');
                }
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // ptOptionDel ลบรายการสินค้า ที่มีจำนวนเติม = 0 : 1 = ไม่ลบ , 2 = ลบ
    function JSxTopUpVendingSaveToDatabase(ptOptionDel){
        // if(pbOption == true){
            var tBchCode = $('#oetTopUpVendingBCHCode').val();
            var tMerCode = $('#oetTopUpVendingMchCode').val();
            var tShpCode = $('#oetTopUpVendingShpCode').val();
            var tPosCode = $('#oetTopUpVendingPosCode').val();
            var tWahCode = $('#oetTopUpVendingWahCode').val();

            // console.log( $("#ofmTopUpVendingForm").serialize() );
            // console.log( $("#ofmTopUpVendingForm").serialize() + '&ptOptionDel='+ptOptionDel );
            // JCNxOpenLoading();
            $.ajax({
                type        : "POST",
                url         : "<?php echo $tRoute; ?>",
                data        : $("#ofmTopUpVendingForm").serialize() + '&ptOptionDel='+ptOptionDel,
                cache       : false,
                timeout     : 0,
                success     : function(aResult) {
                    // pbOption = false;
                    $('#odvTOPUPVDCheckItemHaveTopUpZero').modal('hide');

                    var oResult = JSON.parse(aResult);
                    switch(oResult.nStaCallBack){
                        case "1" : {
                            JSvTopUpVendingCallPageEdit(oResult.tCodeReturn);
                            break;
                        }
                        case "2" : {
                            JSvTopUpVendingCallPageAdd();
                            break;
                        }
                        case "3" : {
                            JSvTopUpVendingCallPageList();
                            break;
                        }
                        default : {
                            JSvTopUpVendingCallPageEdit(oResult.tCodeReturn);    
                        }
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    // JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        // }
    }

    // ลบรายการสินค้า ที่มีจำนวนเติม = 0
    function JSxTVDDelPdtValueZero(){
        $.ajax({
            type        : "POST",
            url         : "dcmTVDEventDelPdtValueZero",
            data        : {},
            cache       : false,
            timeout     : 0,
            success     : function() {
                JSxTopUpVendingGetPdtLayoutDataTableInTmp();
                FSvCMNSetMsgWarningDialog('ไม่สามารถบันทึกเอกสารได้ เนื่องจากไม่พบรายการสินค้า');
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : ดึงข้อมูล Wah ด้วย shp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingSetWahByShop() {
        // alert('tset');
        $.ajax({
            type: "POST",
            url: "TopupVendingGetWahByShop",
            data: {
                tShpCode: $('#oetTopUpVendingShpCode').val(),
                tBchCode: $('#oetTopUpVendingBCHCode').val()
            },
            cache       : false,
            timeout     : 5000,
            dataType    : "JSON",
            success: function(oResult) {

                $('#oetTopUpVendingWahCode').val(oResult.tWahCodeByShp);
                $('#oetTopUpVendingWahName').val(oResult.tWahNameByShp);

                if (oResult.tWahCodeByShp != "") {
                    $('#obtTopUpVendingControlForm').attr('disabled', false);
                } else {
                    $('#obtTopUpVendingControlForm').attr('disabled', true);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                // JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Approve Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTopUpVendingApprove(pbIsConfirm) { 
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                var tCheckAfterSave = true;
                // var nTotal      = 0;
                // var nCountZero  = 0;
                $('#otbDOCPdtTable > tbody  > tr:not(.xWNotFoundData)').each(function(index, tr) { 
                    // nTotal++;
                    var nValue = $(tr).find('.xCNTopUpVendingQty').val();
                    if(nValue == 0 || nValue == '0'){
                        tCheckAfterSave = false;
                        // nCountZero++;
                    }
                });

                if(tCheckAfterSave == false){
                    FSvCMNSetMsgWarningDialog('ไม่สามารถอนุมัติเอกสารได้ พบรายการสินค้าจำนวนเติม 0');
                }else{
                    if (pbIsConfirm) {
                        $("#ohdXthStaApv").val(2); // Set status for processing approve
                        $("#odvTopUpVendingPopupApv").modal("hide");

                        var tDocNo = $("#oetTopUpVendingDocNo").val();
                        var tStaApv = $("#ohdXthStaApv").val();

                        JCNxOpenLoading();
                        $.ajax({
                            type: "POST",
                            url: "TopupVendingDocApprove",
                            data: {
                                tBchCode : $('#oetTopUpVendingBCHCode').val(),
                                tDocNo  : tDocNo,
                                tStaApv : tStaApv
                            },
                            cache: false,
                            timeout: 0,
                            success: function(oResult) {
                                console.log(oResult);
                                try {
                                    if (oResult.nStaEvent == "900") {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                        return;
                                    }
                                } catch (err) {}
                                JCNxCloseLoading();
                                JSoTopUpVendingSubscribeMQ();
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                                JCNxCloseLoading();
                            }
                        });
                    } else {
                        $("#odvTopUpVendingPopupApv").modal("show");
                    }
                }
            } catch (err) {
                console.log("JSvTopUpVendingApprove Error: ", err);
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Cancel Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTopUpVendingCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tDocNo = $("#oetTopUpVendingDocNo").val();

            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "TopupVendingDocCancel",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(tResult) {
                        $("#odvTopUpVendingPopupCancel").modal("hide");

                        var aResult = $.parseJSON(tResult);
                        if (aResult.nSta == 1) {
                            JSvTopUpVendingCallPageEdit(tDocNo);
                        } else {
                            JCNxCloseLoading();
                            var tMsgBody = aResult.tMsg;
                            FSvCMNSetMsgWarningDialog(tMsgBody);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvTopUpVendingPopupCancel").modal("show");
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : SubscribeMQ
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSoTopUpVendingSubscribeMQ() {
        // RabbitMQ
        /*===========================================================================*/
        // Document variable
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#oetTopUpVendingBCHCode").val();
        var tUsrApv = $("#oetXthApvCodeUsrLogin").val();
        var tDocNo = $("#oetTopUpVendingDocNo").val();
        var tPrefix = "RESTFWVD";
        var tStaApv = $("#ohdXthStaApv").val();
        var tStaDelMQ = $("#ohdXthStaDelMQ").val();
        var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode: tLangCode,
            tUsrBchCode: tUsrBchCode,
            tUsrApv: tUsrApv,
            tDocNo: tDocNo,
            tPrefix: tPrefix,
            tStaDelMQ: tStaDelMQ,
            tStaApv: tStaApv,
            tQName: tQName
        };

        // RabbitMQ STOMP Config
        var poMqConfig = {
            host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username: oSTOMMQConfig.user,
            password: oSTOMMQConfig.password,
            vHost: oSTOMMQConfig.vhost
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TVDTPdtTwxHD",
            ptDocFieldDocNo: "FTXthDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: tStaDelMQ,
            ptDocNo: tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvTopUpVendingCallPageEdit",
            tCallPageList: "JSvTopUpVendingCallPageList"
        };

        // Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            poMqConfig,
            poUpdateStaDelQnameParams,
            poCallback
        );
        /*===========================================================================*/
        // RabbitMQ
    }

    //Functionality : Print Document
    function JSvTopUpVendingPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tBchCode); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetTopUpVendingDocNo').val()  } // เลขที่เอกสาร
        ];
        window.open("<?=base_url(); ?>formreport/Frm_SQL_SMBillRefill?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }  

    // Create by : 25/11/2020 Napat(Jame)
    // ถ้าเอกสารถูกสร้างจาก ใบเติมสินค้าแบบชุด ไม่ให้แก้ไข
    function JSxTopUpVendingDsiabledInput(){
        var tXthRmk         = $('#otaTopUpVendingRmk').text();
        var dXthTnfDate     = $('#oetTopUpVendingXthRefIntDate').val();
        var tXthRefInt      = $('#oetTopUpVendingXthRefInt').val();
        // console.log(tXthRmk);
        // console.log(dXthTnfDate);
        // console.log(tXthRefInt);
        if( tXthRmk == "สร้างเอกสารจากใบเติมสินค้าแบบชุด" && tXthRefInt != '' && dXthTnfDate != '' ){
            // HD
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);

            // DT
            $('form .xCNApvOrCanCelDisabledQty').attr('disabled', true);
            $('#otbDOCPdtTable .xCNIconDel').addClass('xCNDocDisabled');
            $('#otbDOCPdtTable .xCNIconDel').removeAttr('onclick', true);
           
            $('.othShowChkbox').css('display','none');
            $('.otdShowChkbox').css('display','none');
        }
    }



    // Create by : 17/02/2022 Wasin(Yoshi)
    // เช็ค Data Tr In Table Behide Change Condition
    function JSxTopUpVDEvnConfirmDelDTTemp(){
        var tTypeClickEvent = $('#ohdTopUpVendingTypeClick').val();
        var tDocCode        = $('#oetTopUpVendingDocNo').val();
        var tBchCode        = $('#oetTopUpVendingBCHCode').val();
        var tMerCode        = $('#oetTopUpVendingMchCode').val();
        var tShpCode        = $('#oetTopUpVendingShpCode').val();
        var tPosCode        = $('#oetTopUpVendingPosCode').val();
        var tWahCode        = $('#oetTopUpVendingWahCode').val();
        $.ajax({
            type    : "POST",
            url     : "TopupVendingDeleteDataDTTemp",
            data    : {
                'tDocCode'  : tDocCode,
                'tBchCode'  : tBchCode,
                'tMerCode'  : tMerCode,
                'tShpCode'  : tShpCode,
                'tPosCode'  : tPosCode,
                'tWahCode'  : tWahCode,
            },
            success: function(tResult) {
                var aDataReturn = JSON.parse(tResult);
                if(aDataReturn['rtCode'] == '1'){
                    $('#odvTopUpVendingPopupFoundDataInTblDT').modal('hide');
                    $('.modal-backdrop').remove();
                    JSxTopUpVendingGetPdtLayoutDataTableInTmp();
                    // Check Case Click Event
                    switch(tTypeClickEvent){
                        case 'Bch':
                            JSxTopUpVendingCallbackBch(null);
                            setTimeout(function(){
                                $( "#obtBrowseTopUpVendingBCH" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Mer':
                            JSxTopUpVendingCallbackMer(null);
                            setTimeout(function(){
                                $( "#obtBrowseTopUpVendingMER" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Shp':
                            JSxTopUpVendingCallbackShp(null);
                            setTimeout(function(){
                                $( "#obtBrowseTopUpVendingShp" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Pos':
                            JSxTopUpVendingCallbackPos(null);
                            setTimeout(function(){
                                $( "#obtBrowseTopUpVendingPos" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Wah':
                            JSxTopUpVendingCallbackWah(null);
                            setTimeout(function(){
                                $( "#obtBrowseTopUpVendingWah" ).trigger( "click" );
                            },1000);
                        break;
                    }
                    $('#obtTopUpVendingControlForm').attr('disabled', true);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


</script>