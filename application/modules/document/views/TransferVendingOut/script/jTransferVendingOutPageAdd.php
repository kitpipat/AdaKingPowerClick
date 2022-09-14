<script>
    var nLangEdit           = '<?php echo $nLangEdit; ?>';
    var tUsrApv             = '<?php echo $tUsrApv; ?>';
    var tUserLoginLevel     = '<?php echo $tUsrLevel; ?>';
    var bIsAddPage          = <?php echo ($bIsAddPage) ? 'true' : 'false'; ?>;
    var bIsApv              = <?php echo ($bIsApv) ? 'true' : 'false'; ?>;
    var bIsCancel           = <?php echo ($bIsCanCel) ? 'true' : 'false'; ?>;
    var bIsApvOrCancel      = <?php echo ($bIsApvOrCanCel) ? 'true' : 'false'; ?>;

    $(document).ready(function() {

        $('#ocmTUVStaShwPdt , #ocbTUVStaShwPdtInStk').change(function(){
            JSxTVOGetPdtLayoutDataTableInTmp();
        });

        JSxTVOGetPdtLayoutDataTableInTmp();

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

        $('#ocbTVOAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbTVOAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetTVODocNo');
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
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOWah').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
            } else {
                $('#obtBrowseTVOWah').attr('disabled', false);
            }
        }

        if (tUserLoginLevel == 'BCH') {
            $('#obtBrowseTVOShp').attr('disabled', false);
            $('#obtBrowseTVOPos').attr('disabled', false);
            if (bIsAddPage) {
                $('#obtBrowseTVOWah').attr('disabled', true);
            } else {
                $('#obtBrowseTVOWah').attr('disabled', false);
            }
        }

        if (tUserLoginLevel == 'SHP') {
            $('#obtBrowseTVOMER').attr('disabled', true);
            var tShpcount = '<?=$this->session->userdata("nSesUsrShpCount");?>';
            if(tShpcount < 2){
                $('#obtBrowseTVOShp').attr('disabled',false);
            }
                    
            if (bIsAddPage) {
                $('#obtBrowseTVOWah').attr('disabled', true);
            } else {
                $('#obtBrowseTVOWah').attr('disabled', false);
            }
        }

        if ($('#oetTVOWahCode').val() != "") {
            $('#obtTVOControlForm').attr('disabled', false);
        } else {
            $('#obtTVOControlForm').attr('disabled', true);
        }

        if (<?= !FCNbGetIsShpEnabled() ? '1' : '0' ?>){
            $('#obtBrowseTVOPos').attr('disabled', false);
            $('#obtBrowseTVOWah').attr('disabled', false);
        }
        

        if(bIsApvOrCancel && !bIsAddPage){
            $('#obtTVOApprove').hide();
            $('#obtTVOCancel').hide();
            $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
            $("#obtTVOVDPrint").show();
        }else{
            $('#odvBtnAddEdit .btn-group').show();
            // $("#obtTVOVDPrint").hide();
        }

        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });
        
        // $('#obtBrowseTVOPos').attr('disabled', true);

    });

    /*===== Begin Event Browse =========================================================*/
    // เลือกสาขา
    $("#obtBrowseTVOBCH").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            // option Ship Address 
            tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
            tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            tSQLWhere = "";
            if(tUsrLevel != "HQ"){
                tSQLWhere = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+") ";
            }
            window.oBrowseTVOBranch = {
                Title: ['authen/user/user', 'tBrowseBCHTitle'],
                Table: {
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
                    Value: ["oetTVOBCHCode", "TCNMBranch.FTBchCode"],
                    Text: ["oetTVOBCHName", "TCNMBranch_L.FTBchName"]
                },
                NextFunc: {
                    FuncName: 'JSxTVOCallbackBch',
                    ArgReturn: ['FTBchCode']
                },
                RouteAddNew: 'branch',
                BrowseLev: 1
            };
            JCNxBrowseData('oBrowseTVOBranch');
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('Bch');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกกลุ่มธุรกิจ
    $("#obtBrowseTVOMER").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            // option Ship Address 
            window.oBrowseTVOMch = {
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
                    Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetTVOBCHCode").val() + "') != 0"]
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
                    Value: ["oetTVOMchCode", "TCNMMerchant.FTMerCode"],
                    Text: ["oetTVOMchName", "TCNMMerchant_L.FTMerName"],
                },
                NextFunc: {
                    FuncName: 'JSxTVOCallbackMer',
                    ArgReturn: ['FTMerCode', 'FTMerName']
                },
                BrowseLev: 1,
                //DebugSQL : true
            };
            JCNxBrowseData('oBrowseTVOMch');
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('Mer');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        } 
    });

    // เลือกร้านค้า
    $("#obtBrowseTVOShp").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            // Option Shop
            window.oBrowseTVOShp = {
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
                            var tBchCode        = $("#oetTVOBCHCode").val();
                            var tWhereBchCode   = "";
                            if(tBchCode != ""){
                                tWhereBchCode   = " AND TCNMShop.FTBchCode = '" + $("#oetTVOBCHCode").val() + "' ";
                            }
                            // Where Merchant
                            var tMerCode        = $('#oetTVOMchCode').val();
                            var tWhereMerCode   = "";
                            if(tMerCode != ""){
                                tWhereMerCode   = " AND TCNMShop.FTMerCode = '" + $("#oetTVOMchCode").val() + "'";
                            }
                            var tSQL = "AND TCNMShop.FTShpStaActive = 1 "+tWhereBchCode+tWhereMerCode;
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
                    Value: ["oetTVOShpCode", "TCNMShop.FTShpCode"],
                    Text: ["oetTVOShpName", "TCNMShop_L.FTShpName"],
                },
                NextFunc: {
                    FuncName: 'JSxTVOCallbackShp',
                    ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
                },
                BrowseLev: 1
            }
            JCNxBrowseData('oBrowseTVOShp');
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('Shp');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกตู้
    $("#obtBrowseTVOPos").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            // option Pos 
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
            var aCondition = [
                                function() {
                                    var tSQL = "AND TCNMPos.FTPosStaUse = 1 AND TVDMPosShop.FTShpCode = '" + $("#oetTVOShpCode").val() + "' AND TVDMPosShop.FTBchCode = '" + $("#oetTVOBCHCode").val() + "'";
                                    tSQL += " AND TCNMPos.FTPosType = '4'";
                                    return tSQL;
                                }
                            ];
            var aDataColumns        = ['TVDMPosShop.FTPosCode', 'TCNMPos_L.FTPosName', 'TVDMPosShop.FTShpCode', 'TVDMPosShop.FTBchCode', 'TCNMWaHouse.FTWahCode', 'TCNMWaHouse_L.FTWahName'];
            var aDataColumnsFormat  = ['', '', '', '', '', ''];
            var aDisabledColumns    = [2, 3, 4, 5];
            var aArgReturn          = ['FTBchCode', 'FTShpCode', 'FTPosCode', 'FTWahCode', 'FTWahName'];
            window.oBrowseTVOPos = {
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
                    Value       : ["oetTVOPosCode", tWahMasterTable + ".FTPosCode"],
                    Text        : ["oetTVOPosName", "TCNMPos_L.FTPosName"],
                },
                NextFunc: {
                    FuncName    : 'JSxTVOCallbackPos',
                    ArgReturn   : aArgReturn
                },
                /*BrowseLev: 1*/

            }
            JCNxBrowseData('oBrowseTVOPos');
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('Pos');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกคลังสินค้า
    $("#obtBrowseTVOWah").click(function() {
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            // option warehouse 
            var bIsShopEnabled = '<?= FCNbGetIsShpEnabled() ? '1' : '0' ?>';
            var tWahMasterTable = 'TCNMWaHouse';
            var tPK = "FTWahCode"; 
            var tPKName = "FTWahName"; 
            if(bIsShopEnabled == 1){
                tWahMasterTable = 'TCNMShpWah';
                tPK = "FTWahCode"; 
                tPKName = "FTWahName"; 
            }
            window.oBrowseTVOWah = {
                Title: ['company/warehouse/warehouse', 'tWAHTitle'],
                Table: {
                    Master  : tWahMasterTable,
                    PK      : tPK,
                    PKName  : tPKName
                },
                Join: {
                    Table: ["TCNMWaHouse_L"],
                    On: ["TCNMWaHouse_L.FTWahCode = "+tWahMasterTable+".FTWahCode AND TCNMWaHouse_L.FTBchCode = "+tWahMasterTable+".FTBchCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits, ]
                },
                Where: {
                    Condition: [
                        function() {
                            var tSQL = "";
                            if(bIsShopEnabled == 1){
                                tSQL = " AND TCNMShpWah.FTBchCode = '" + $("#oetTVOBCHCode").val() + "'";
                                tSQL += " AND TCNMShpWah.FTShpCode = '" + $('#oetTVOShpCode').val() + "'";
                            } else {
                                tSQL = " AND TCNMWaHouse.FTWahRefCode = '" + $("#oetTVOBCHCode").val() + "'";
                            }
                            return tSQL;
                        }
                    ]
                },
                GrideView: {
                    ColumnPathLang: 'company/warehouse/warehouse',
                    ColumnKeyLang: ['tWahCode', 'tWahName'],
                    DataColumns: [tWahMasterTable+'.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat: ['', ''],
                    ColumnsSize: ['15%', '75%'],
                    Perpage: 10,
                    WidthModal: 50,
                    OrderBy: ['TCNMWaHouse_L.FTWahName'],
                    SourceOrder: "ASC"
                },
                CallBack: {
                    ReturnType: 'M',
                    Value: ["oetTVOWahCode", tWahMasterTable+".FTWahCode"],
                    Text: ["oetTVOWahName", "TCNMWaHouse_L.FTWahName"],
                },
                NextFunc: {
                    FuncName: 'JSxTVOCallbackWah',
                    ArgReturn: []
                },
                RouteAddNew: 'warehouse',
                BrowseLev: 1
            }
            JCNxBrowseData('oBrowseTVOWah');
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('Wah');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        }
    });

    // เลือกขนส่งโดย
    $("#obtSearchShipVia").click(function() {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
        // option Ship Address 
        oTVOBrowseShipVia = {
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
                Value: ["oetTVOViaCode", "TCNMShipVia.FTViaCode"],
                Text: ["oetTVOViaName", "TCNMShipVia_L.FTViaName"],
            },
            BrowseLev: 1
        }
        JCNxBrowseData('oTVOBrowseShipVia');
    });
    /*===== End Event Browse ===========================================================*/

    /*===== Begin Callback Browse ======================================================*/
    // Browse Bch Callback
    function JSxTVOCallbackBch(params) {
        var tBchCode = $('#oetTVOBCHCode').val();

        $('#oetTVOWahCodeFrom').val('');
        $('#oetTVOWahNameFrom').val('');

        $('#oetTVOMchCode').val("");
        $('#oetTVOMchName').val("");

        $('#oetTVOShpCode').val("");
        $('#oetTVOShpName').val("");

        $('#oetTVOPosCode').val("");
        $('#oetTVOPosName').val("");

        $('#oetTVOWahCode').val("");
        $('#oetTVOWahName').val("");

        $('#obtBrowseTVOMER').attr('disabled', true);
        $('#obtBrowseTVOShp').attr('disabled', true);
        $('#obtBrowseTVOPos').attr('disabled', true);
        $('#obtBrowseTVOWah').attr('disabled', true);
        if (tBchCode != "") {
            $('#obtBrowseTVOMER').attr('disabled', false);
            $('#obtBrowseTVOShp').attr('disabled', false);
        }
    }

    // Browse Mer Callback
    function JSxTVOCallbackMer(params) {
        var tBchCode = $('#oetTVOBCHCode').val();
        var tMerCode = $('#oetTVOMchCode').val();

        $('#obtBrowseTVOMER').attr('disabled', true);
        $('#obtBrowseTVOShp').attr('disabled', false);
        $('#obtBrowseTVOPos').attr('disabled', true);
        $('#obtBrowseTVOWah').attr('disabled', true);

        $('#oetTVOWahCodeFrom').val('');
        $('#oetTVOWahNameFrom').val('');

        $('#oetTVOShpCode').val("");
        $('#oetTVOShpName').val("");

        $('#oetTVOPosCode').val("");
        $('#oetTVOPosName').val("");

        $('#oetTVOWahCode').val("");
        $('#oetTVOWahName').val("");

        if (tBchCode != "" && tMerCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTVOMER').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTVOMER').attr('disabled', false);
            }
        }
    }

    // Browse Shop Callback
    function JSxTVOCallbackShp(params) {
        var tBchCode = $('#oetTVOBCHCode').val();
        var tMerCode = $('#oetTVOMchCode').val();
        var tShpCode = $('#oetTVOShpCode').val();

        $('#obtBrowseTVOMER').attr('disabled', true);
        $('#obtBrowseTVOShp').attr('disabled', true);
        $('#obtBrowseTVOPos').attr('disabled', true);
        $('#obtBrowseTVOWah').attr('disabled', true);

        $('#oetTVOWahCodeFrom').val('');
        $('#oetTVOWahNameFrom').val('');

        $('#oetTVOPosCode').val("");
        $('#oetTVOPosName').val("");

        $('#oetTVOWahCode').val("");
        $('#oetTVOWahName').val("");

        if (tBchCode != ""  && tShpCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
            }
        }
    }

    // Browse Pos Callback
    function JSxTVOCallbackPos(params) {

        /* นำคลังจากตู้สินค้ามาใส่ */
        if( params != "NULL" ){
            var oResult = JSON.parse(params);
            $('#oetTVOWahCodeFrom').val(oResult[3]);
            $('#oetTVOWahNameFrom').val(oResult[4]);
        }else{
            $('#oetTVOWahCodeFrom').val('');
            $('#oetTVOWahNameFrom').val('');
        }

        var tBchCode = $('#oetTVOBCHCode').val();
        var tMerCode = $('#oetTVOMchCode').val();
        var tShpCode = $('#oetTVOShpCode').val();
        var tPosCode = $('#oetTVOPosCode').val();
        var tWahCode = $('#oetTVOWahCode').val();

        $('#obtBrowseTVOMER').attr('disabled', true);
        $('#obtBrowseTVOShp').attr('disabled', false);
        $('#obtBrowseTVOPos').attr('disabled', true);
        $('#obtBrowseTVOWah').attr('disabled', true);

        // $('#oetTVOWahCode').val("");
        // $('#oetTVOWahName').val("");

        // JSxTVOSetWahByShop()

        if (tBchCode != "" && tMerCode != "" && tShpCode != "" && tPosCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
                $('#obtBrowseTVOWah').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
                $('#obtBrowseTVOWah').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {

                var tShpcount = '<?=$this->session->userdata("nSesUsrShpCount");?>';
                if(tShpcount < 2){
                    $('#obtBrowseTVOShp').attr('disabled',true);
                }else{
                    $('#obtBrowseTVOShp').attr('disabled', false);
                }
                $('#obtBrowseTVOPos').attr('disabled', false);
                $('#obtBrowseTVOWah').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtBrowseTVOMER').attr('disabled', false);
                $('#obtBrowseTVOShp').attr('disabled', false);
                $('#obtBrowseTVOPos').attr('disabled', false);
            }
            if (tUserLoginLevel == "SHP") {
                $('#obtBrowseTVOPos').attr('disabled', false);
            }
        }


    }

    // Browse Warehouse Callback
    function JSxTVOCallbackWah(params) {
        var tBchCode = $('#oetTVOBCHCode').val();
        var tMerCode = $('#oetTVOMchCode').val();
        var tShpCode = $('#oetTVOShpCode').val();
        var tPosCode = $('#oetTVOPosCode').val();
        var tWahCode = $('#oetTVOWahCode').val();

        if (tBchCode != "" && tShpCode != "" && tPosCode != "" && tWahCode != "") {
            $('#obtTVOControlForm').attr('disabled', false);
        } else {
            $('#obtTVOControlForm').attr('disabled', true);
        }
    }

    /*===== End Callback Browse ========================================================*/

    $('#obtTVOControlForm').unbind().bind('click', function() {
        console.log('Select List');
        if($('#oetTVOWahName').val() == ''){
            $('#oetTVOWahName').focus();
            return;
        }
        JCNxOpenLoading();
        JSxTVOInsertPdtLayoutToTemp();
        // JSxTVOGetPdtLayoutDataTableInTmp(1);
    });

    /**
     * Functionality : Insert PDT Layout to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTVOInsertPdtLayoutToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTVOBCHCode').val();
            var tMerCode = $('#oetTVOMchCode').val();
            var tShpCode = $('#oetTVOShpCode').val();
            var tPosCode = $('#oetTVOPosCode').val();
            var tWahCodeInShop = $('#oetTVOWahCode').val();

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
                    JSxTVOGetPdtLayoutDataTableInTmp(1);
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
     * Creator : 08/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxTVOGetPdtLayoutDataTableInTmp(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTVOBCHCode').val();
            var tMerCode = $('#oetTVOMchCode').val();
            var tShpCode = $('#oetTVOShpCode').val();
            var tPosCode = $('#oetTVOPosCode').val();
            var tWahCode = $('#oetTVOWahCode').val();

            // Create By : Napat(Jame) 01/09/2020
            var tStaShwPdt      = $('#ocmTUVStaShwPdt').val();
            var tStaShwPdtInStk = $("#ocbTUVStaShwPdtInStk").prop("checked");

            var tSearchAll = $('#oetTVOPdtLayoutSearchAll').val();

            JCNxOpenLoading();

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "docTVOPageDataTablePdtLayout",
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

    var bUniqueTVOCode;
    $.validator.addMethod(
        "uniqueTVOCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tTVOCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "TopupVendingUniqueValidate",
                    data: "tTVOCode=" + tTVOCode,
                    dataType: "JSON",
                    success: function(poResponse) {
                        bUniqueTVOCode = (poResponse.bStatus) ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Custom validate uniqueTVOCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniqueTVOCode;

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
    function JSxTVOValidateForm() {
        var oTVOForm = $('#ofmTVOForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetTVODocNo: {
                    required: true,
                    maxlength: 20,
                    uniqueTVOCode: bIsAddPage
                },
                oetTVODocDate: {
                    required: true
                },
                oetTVODocTime: {
                    required: true
                },
                // oetTVOMchName: {
                //     required: true
                // },
                oetTVOShpName: {
                    required: true
                },
                oetTVOPosName: {
                    required: true
                },
                oetTVOWahName: {
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
                JSxTVOSave();
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
    function JSxTVOSave() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetTVOBCHCode').val();
            var tMerCode = $('#oetTVOMchCode').val();
            var tShpCode = $('#oetTVOShpCode').val();
            var tPosCode = $('#oetTVOPosCode').val();
            var tWahCode = $('#oetTVOWahCode').val();

            // console.log( $("#ofmTVOForm").serializeArray() );

            // JCNxOpenLoading();
            $.ajax({
                type        : "POST",
                url         : "<?php echo $tRoute; ?>",
                data        : $("#ofmTVOForm").serialize(),
                cache       : false,
                // timeout     : 5000,
                success     : function(aResult) {
                    var oResult = JSON.parse(aResult);
                    console.log(oResult);
                    console.log('pass');
                    switch(oResult.nStaCallBack){
                        case "1" : {
                            JSvTVOCallPageEdit(oResult.tCodeReturn);
                            break;
                        }
                        case "2" : {
                            JSxTVOPageAdd();
                            break;
                        }
                        case "3" : {
                            JSxTVOPageList();
                            break;
                        }
                        default : {
                            JSvTVOCallPageEdit(oResult.tCodeReturn);    
                        }
                    }
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
     * Functionality : ดึงข้อมูล Wah ด้วย shp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTVOSetWahByShop() {
        // alert('tset');
        $.ajax({
            type: "POST",
            url: "TopupVendingGetWahByShop",
            data: {
                tShpCode: $('#oetTVOShpCode').val(),
                tBchCode: $('#oetTVOBCHCode').val()
            },
            cache       : false,
            timeout     : 5000,
            dataType    : "JSON",
            success: function(oResult) {

                $('#oetTVOWahCode').val(oResult.tWahCodeByShp);
                $('#oetTVOWahName').val(oResult.tWahNameByShp);

                if (oResult.tWahCodeByShp != "") {
                    $('#obtTVOControlForm').attr('disabled', false);
                } else {
                    $('#obtTVOControlForm').attr('disabled', true);
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
    function JSvTVOApprove(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                if (pbIsConfirm) {
                    $("#ohdXthStaApv").val(2); // Set status for processing approve
                    $("#odvTVOPopupApv").modal("hide");

                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "docTVOEventApprove",
                        data: {
                            tBchCode : $('#oetTVOBCHCode').val(),
                            tDocNo   : $("#oetTVODocNo").val()
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
                            
                            JSoTVOSubscribeMQ();
                            JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            JCNxCloseLoading();
                        }
                    });
                } else {
                    $("#odvTVOPopupApv").modal("show");
                }
            } catch (err) {
                console.log("JSvTVOApprove Error: ", err);
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
    function JSvTVOCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tDocNo = $("#oetTVODocNo").val();
            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "docTVOEventCancleDoc",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(tResult) {
                        $("#odvTVOPopupCancel").modal("hide");

                        var aResult = $.parseJSON(tResult);
                        if (aResult.nSta == 1) {
                            JSvTVOCallPageEdit(tDocNo);
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
                $("#odvTVOPopupCancel").modal("show");
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
    function JSoTVOSubscribeMQ() {
        // RabbitMQ
        /*===========================================================================*/
        // Document variable
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#oetTVOBCHCode").val();
        var tUsrApv = $("#oetXthApvCodeUsrLogin").val();
        var tDocNo = $("#oetTVODocNo").val();
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
            tCallPageEdit: "JSvTVOCallPageEdit",
            tCallPageList: "JSxTVOPageList"
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

    // Create By : Napat(Jame) 08/09/2020
    $('#obtTVOBrowseRefInt').off('click');
    $('#obtTVOBrowseRefInt').on('click',function(){
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            var tSQLWhere = "";
            tSQLWhere += " AND TVDTPdtTwxHD.FTBchCode = '" + $('#oetTVOBCHCode').val() + "' ";
            tSQLWhere += " AND TVDTPdtTwxHD.FTXthStaApv = '1' AND ISNULL(TVDTPdtTwxHD.FTXthRefInt,'') = '' ";
            tSQLWhere += " AND TVDTPdtTwxHD.FTXthDocType = '1' ";
            if( $('#oetTVOMchCode').val() != "" ){
                tSQLWhere += " AND TVDTPdtTwxHD.FTXthMerCode = '" + $('#oetTVOMchCode').val() + "' ";
            }

            if( $('#oetTVOShpCode').val() != "" ){
                tSQLWhere += " AND ( TVDTPdtTwxHD.FTXthShopFrm = '" + $('#oetTVOShpCode').val() + "' OR TVDTPdtTwxHD.FTXthShopTo = '" + $('#oetTVOShpCode').val() + "' ) ";
            }

            if( $('#oetTVOPosCode').val() != "" ){
                tSQLWhere += " AND ( TVDTPdtTwxHD.FTXthPosFrm = '" + $('#oetTVOPosCode').val() + "' OR TVDTPdtTwxHD.FTXthPosTo = '" + $('#oetTVOPosCode').val() + "' ) ";
            }
            window.oTVOBrowseRefInt = {
                Title                   : ['document/topupVending/topupVending', 'tTitle'],
                Table: {
                    Master              : 'TVDTPdtTwxHD',
                    PK                  : 'FTXthDocNo'
                },
                Join: {
                    Table: ['TCNMMerchant_L','TCNMShop_L','TCNMPos_L','TCNMWaHouse','TCNMWaHouse_L','TCNMUser_L'],
                    On: [
                        " TVDTPdtTwxHD.FTXthMerCode = TCNMMerchant_L.FTMerCode  AND TCNMMerchant_L.FNLngID = " + nLangEdits,
                        " TVDTPdtTwxHD.FTXthShopFrm = TCNMShop_L.FTShpCode      AND TVDTPdtTwxHD.FTBchCode = TCNMShop_L.FTBchCode   AND TCNMShop_L.FNLngID = " + nLangEdits,
                        " TVDTPdtTwxHD.FTXthPosFrm  = TCNMPos_L.FTPosCode       AND TVDTPdtTwxHD.FTBchCode = TCNMPos_L.FTBchCode    AND TCNMPos_L.FNLngID  = " + nLangEdits,
                        " TVDTPdtTwxHD.FTXthPosFrm  = TCNMWaHouse.FTWahRefCode  AND TCNMWaHouse.FTWahStaType = 6                    AND TVDTPdtTwxHD.FTBchCode = TCNMWaHouse.FTBchCode ",
                        " TCNMWaHouse.FTWahCode     = TCNMWaHouse_L.FTWahCode   AND TCNMWaHouse_L.FTBchCode = TCNMWaHouse.FTBchCode AND TCNMWaHouse_L.FNLngID = " + nLangEdits,
                        " TCNMUser_L.FTUsrCode      = TVDTPdtTwxHD.FTCreateBy   AND TCNMUser_L.FNLngID = " + nLangEdits,
                    ]
                },
                Where: {
                    Condition           : [ tSQLWhere ]
                },
                GrideView: {
                    ColumnPathLang      : 'document/topupVending/topupVending',
                    ColumnKeyLang       : ['tDocNo', 'tDocDate','tCreateBy'],
                    ColumnsSize         : ['20%', '55%','25%'],
                    DataColumns         : [ 'TVDTPdtTwxHD.FTXthDocNo', 'TVDTPdtTwxHD.FDXthDocDate', 'TCNMUser_L.FTUsrName',
                                            'TVDTPdtTwxHD.FTXthMerCode','TCNMMerchant_L.FTMerName',
                                            'TVDTPdtTwxHD.FTXthShopFrm','TCNMShop_L.FTShpName',
                                            'TVDTPdtTwxHD.FTXthPosFrm','TCNMPos_L.FTPosName',
                                            'TCNMWaHouse.FTWahCode','TCNMWaHouse_L.FTWahName'
                                        ],
                    DataColumnsFormat   : ['', '',''],
                    DisabledColumns     : [3, 4, 5, 6, 7, 8, 9, 10],
                    WidthModal          : 5,
                    Perpage             : 10,
                    OrderBy             : ['TVDTPdtTwxHD.FDCreateOn DESC'],
                    // SourceOrder         : "DESC"
                },
                CallBack: {
                    ReturnType          : 'S',
                    Value               : ["oetTVOXthRefInt", "TVDTPdtTwxHD.FTXthDocNo"],
                    Text                : ["oetTVOXthRefInt", "TVDTPdtTwxHD.FTXthDocNo"]
                },
                NextFunc: {
                    FuncName            : 'JSxTVOCallBackRefInt',
                    ArgReturn           : ['FTXthDocNo','FDXthDocDate','FTXthMerCode','FTMerName','FTXthShopFrm','FTShpName','FTXthPosFrm','FTPosName','FTWahCode','FTWahName']
                },
                RouteAddNew             : 'docTVO',
                BrowseLev               : 1,
                // DebugSQL                : true
            };
            JCNxBrowseData('oTVOBrowseRefInt');
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('RefIn');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        }
    });

    // Browse RefInt Callback
    // Create By : Napat(Jame) 08/09/2020
    function JSxTVOCallBackRefInt(oParams){
        if( oParams != "NULL" ){
            var aResult = JSON.parse(oParams);

            // วันที่เอกสารอ้างอิง
            $('#oetTVOXthRefIntDate').val(aResult[1].substr(0, 10));

            // Merchant
            $('#oetTVOMchCode').val(aResult[2]);
            $('#oetTVOMchName').val(aResult[3]);
            $('#obtBrowseTVOMER').attr('disabled',false);

            // Shop
            $('#oetTVOShpCode').val(aResult[4]);
            $('#oetTVOShpName').val(aResult[5]);
            $('#obtBrowseTVOShp').attr('disabled',false);

            // Shop Pos
            $('#oetTVOPosCode').val(aResult[6]);
            $('#oetTVOPosName').val(aResult[7]);
            $('#obtBrowseTVOPos').attr('disabled',false);

            // Wahouse from
            $('#oetTVOWahCodeFrom').val(aResult[8]);
            $('#oetTVOWahNameFrom').val(aResult[9]);

            //เพิ่มสินค้า ตามเอกสารอ้างอิงใบเติมสินค้า
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTVOEventMoveDTFromRefInt",
                data: {
                    tDocNo          : $('#oetTVODocNo').val(),
                    tBchCode        : $('#oetTVOBCHCode').val(),
                    tDocNoRefInt    : aResult[0]
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = $.parseJSON(oResult);
                    // console.log(aResult);
                    if (aResult['tCode'] == 1) {
                        JSxTVOGetPdtLayoutDataTableInTmp();
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else{
            $('#oetTVOXthRefIntDate').val('');
        }
    }

    // Create By : Napat(Jame) 08/09/2020
    $('#obtTVOBrowsePdt').off('click');
    $('#obtTVOBrowsePdt').on('click',function(){

        var tBchName = $('#oetTVOBCHName').val();
        var tMerName = $('#oetTVOMchName').val();
        var tShpName = $('#oetTVOShpName').val();
        var tPosName = $('#oetTVOPosName').val();
        var tWahName = $('#oetTVOWahNameFrom').val();
        if( tBchName == "" || tShpName == "" || tPosName == "" || tWahName == "" ){
            alert('เงื่อนไขไม่ครบถ้วน');
            if( tBchName == "" ){ $('#oetTVOBCHName').closest('.form-group').addClass("has-error"); }else{ $('#oetTVOBCHName').closest('.form-group').removeClass("has-error"); }
            if( tMerName == "" ){ $('#oetTVOMchName').closest('.form-group').addClass("has-error"); }else{ $('#oetTVOMchName').closest('.form-group').removeClass("has-error"); }
            if( tShpName == "" ){ $('#oetTVOShpName').closest('.form-group').addClass("has-error"); }else{ $('#oetTVOShpName').closest('.form-group').removeClass("has-error"); }
            if( tPosName == "" ){ $('#oetTVOPosName').closest('.form-group').addClass("has-error"); }else{ $('#oetTVOPosName').closest('.form-group').removeClass("has-error"); }
            if( tWahName == "" ){ $('#oetTVOWahNameFrom').closest('.form-group').addClass("has-error"); }else{ $('#oetTVOWahNameFrom').closest('.form-group').addClass("has-error"); }
        }else{

            $('#oetTVOBCHName, #oetTVOMchName, #oetTVOShpName, #oetTVOPosName, #oetTVOWahNameFrom').closest('.form-group').removeClass("has-error");
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();

            var tSQLWhere = "";
            tSQLWhere += " AND TVDMPdtLayout.FTBchCode = '" + $('#oetTVOBCHCode').val() + "' ";

            if( $('#oetTVOMchCode').val() != "" ){
                tSQLWhere += " AND TVDMPdtLayout.FTMerCode = '" + $('#oetTVOMchCode').val() + "' ";
            }

            if( $('#oetTVOShpCode').val() != "" ){
                tSQLWhere += " AND TVDMPdtLayout.FTShpCode = '" + $('#oetTVOShpCode').val() + "' ";
            }

            // Create By : Napat(Jame) 17/12/2020
            var tAllPdtInDB = $('#oetTVOAllPdtInDB').val();
            if( tAllPdtInDB != "" ){
                tSQLWhere += " AND TVDMPdtLayout.FTPdtCode NOT IN (" + tAllPdtInDB + ") ";
            }

            window.oTVOBrowsePdt = {
                Title                   : ['product/product/product', 'tPDTTitle'],
                Table: {
                    Master              : 'TVDMPdtLayout',
                    PK                  : 'FTPdtCode'
                },
                Join: {
                    Table: ['TCNMPdt_L A'],
                    On: [
                        " TVDMPdtLayout.FTPdtCode = A.FTPdtCode AND A.FNLngID = " + nLangEdits + " INNER JOIN TCNMPdt_L B ON TVDMPdtLayout.FTPdtCode = B.FTPdtCode AND B.FNLngID = " + nLangEdits
                    ]
                },
                Where: {
                    Condition           : [ tSQLWhere ]
                },
                GrideView: {
                    ColumnPathLang      : 'product/product/product',
                    ColumnKeyLang       : ['tPDTCode', 'tPDTName'],
                    ColumnsSize         : ['20%', '80%'],
                    DataColumns         : ['TVDMPdtLayout.FTPdtCode', 'B.FTPdtName'],
                    DataColumnsFormat   : ['', ''],
                    DistinctField       : ['TVDMPdtLayout.FTPdtCode'],
                    // DisabledColumns     : [2, 3, 4, 5, 6, 7, 8, 9],
                    WidthModal          : 10,
                    Perpage             : 1000,
                    OrderBy             : ['TVDMPdtLayout.FDCreateOn DESC'],
                    // SourceOrder         : "DESC"
                },
                CallBack: {
                    ReturnType          : 'M',
                    Value               : ["oetTVOPdtCodeMulti", "TVDMPdtLayout.FTPdtCode"],
                    Text                : ["oetTVOPdtNameMulti", "B.FTPdtName"]
                },
                NextFunc: {
                    FuncName            : 'JSxTVOCallBackBrowseAddPdt',
                    ArgReturn           : ['FTPdtCode','FTPdtName']
                },
                SearchFilter            : 'HTML',
                RouteAddNew             : 'docTVO',
                BrowseLev               : 1,
                // DebugSQL                : true
            };
            JCNxBrowseData('oTVOBrowsePdt');
        }

    });

    $('#oetTVOBCHCode, #oetTVOShpCode, #oetTVOPosCode').off('change').on('change', function(){
        // console.log('enter change event');
        setTimeout(function() {
            var tTVOBchCode = $('#oetTVOBCHCode').val();
            var tTVOShpCode = $('#oetTVOShpCode').val();
            var tTVOPosCode = $('#oetTVOPosCode').val();
            // console.log(tTVOBchCode,tTVOShpCode,tTVOPosCode);
            if( tTVOBchCode == "" || tTVOShpCode == "" || tTVOPosCode == "" ){
                $('#obtTVOLoadPdtLayout').attr('disabled', true); //ปิดปุ่ม ตรวจสอบ
            }else{
                $('#obtTVOLoadPdtLayout').attr('disabled', false); //เปิดปุ่ม ตรวจสอบ
            }
        }, 500);
    });

    $('#obtTVOLoadPdtLayout').off('click').on('click',function(){
        var nStaChkDataDT   = $('#otbDOCPdtTable tbody .xCNTopUpVendingPdtLayoutRow').length;
        if(nStaChkDataDT == 0){
            $(".modal.fade:not(#odvTVOBrowseShipAdd,#odvModalDOCPDT,#odvModalWanning,#odvModalInfoMessage,#odvShowOrderColumn,#odvTVOPopupApv,#odvModalDelPdtTVO,#odvTVOPopupFoundDataInTblDT)").remove();
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTVOEventInsertPdtLayoutToTmp",
                data: {
                    tDocNo              : $('#oetTVODocNo').val(),
                    tBchCode            : $('#oetTVOBCHCode').val(),
                    tMerCode            : $('#oetTVOMchCode').val(),
                    tShpCode            : $('#oetTVOShpCode').val(),
                    tWahCodeFrom        : $('#oetTVOWahCodeFrom').val(),
                    tPackDataPdt        : '',
                    tStaClearPdtInTmp   : 'true'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = $.parseJSON(oResult);
                    if (aResult['tCode'] == 1) {
                        JSxTVOGetPdtLayoutDataTableInTmp();
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            $('#odvTVOPopupFoundDataInTblDT #ohdTVOTypeClick').val('LoadPdt');
            $('#odvTVOPopupFoundDataInTblDT').modal('show');
        }
    });

    // Create By : Napat(Jame) 08/09/2020
    function JSxTVOCallBackBrowseAddPdt(oParams){
        if( oParams[0] !== null ){
            var tPackDataPdt = "";
            for(var i=0; i < oParams.length; i++){
                var aResult = oParams[i];
                if( i == ( oParams.length - 1 ) ){
                    tPackDataPdt += "'"+aResult[0]+"'";
                }else{
                    tPackDataPdt += "'"+aResult[0]+"',";
                }
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTVOEventInsertPdtLayoutToTmp",
                data: {
                    tDocNo              : $('#oetTVODocNo').val(),
                    tBchCode            : $('#oetTVOBCHCode').val(),
                    tMerCode            : $('#oetTVOMchCode').val(),
                    tShpCode            : $('#oetTVOShpCode').val(),
                    tWahCodeFrom        : $('#oetTVOWahCodeFrom').val(),
                    tPackDataPdt        : tPackDataPdt,
                    tStaClearPdtInTmp   : 'false'
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = $.parseJSON(oResult);
                    if ( aResult['tCode'] == '1' ) {
                        // เคลียร์ input ที่เก็บรหัสสินค้า ตอนที่เลือกสินค้ามาจาก browse
                        $('#oetTVOPdtCodeMulti').val('');
                        $('#oetTVOPdtNameMulti').val('');
                        JSxTVOGetPdtLayoutDataTableInTmp();
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
        }
    }

    //print wat
    function JSxTVOPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?php echo FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetTVODocNo').val() } // เลขที่เอกสาร
        ];
        window.open("<?php echo base_url(); ?>formreport/Frm_SQL_SMBillReFundVD?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    // Delete DT Temp All Clear Data
    // Create by : 17/02/2022 Wasin(Yoshi)
    function JSxTVOEventConfirmDelDTTempAll(){
        JCNxOpenLoading();
        var tTypeClickEvent = $('#ohdTVOTypeClick').val();
        var tDocCode        = $('#oetTVODocNo').val();
        var tBchCode        = $('#oetTVOBCHCode').val();
        var tMerCode        = $('#oetTVOMchCode').val();
        var tShpCode        = $('#oetTVOShpCode').val();
        var tPosCode        = $('#oetTVOPosCode').val();
        $.ajax({
            type    : "POST",
            url     : "docTVOEventDelDTTempAll",
            data    : {
                'tDocCode'  : tDocCode,
                'tBchCode'  : tBchCode,
                'tMerCode'  : tMerCode,
                'tShpCode'  : tShpCode,
                'tPosCode'  : tPosCode,
            },
            success: function(tResult) {
                var aDataReturn = JSON.parse(tResult);
                if(aDataReturn['rtCode'] == '1'){
                    $('#odvTVOPopupFoundDataInTblDT').modal('hide');
                    $('.modal-backdrop').remove();
                    $('.xCNTopUpVendingPdtLayoutRow').remove();
                    JSxTVOGetPdtLayoutDataTableInTmp();
                    // Check Case Click Event
                    switch(tTypeClickEvent){
                        case 'Bch':
                            JSxTVOCallbackBch("NULL");
                            setTimeout(function(){
                                $( "#obtBrowseTVOBCH" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Mer':
                            JSxTVOCallbackMer("NULL");
                            setTimeout(function(){
                                $( "#obtBrowseTVOMER" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Shp':
                            JSxTVOCallbackShp("NULL");
                            setTimeout(function(){
                                $( "#obtBrowseTVOShp" ).trigger( "click" );
                            },1000);
                        break;
                        case 'Pos':
                            var params  = "NULL";
                            JSxTVOCallbackPos(params);
                            setTimeout(function(){
                                $( "#obtBrowseTVOPos" ).trigger( "click" );
                            },1000);
                        break;
                        case 'RefIn':
                            $('#oetTVOWahCodeFrom').val('');
                            $('#oetTVOWahNameFrom').val('');

                            $('#oetTVOMchCode').val("");
                            $('#oetTVOMchName').val("");

                            $('#oetTVOShpCode').val("");
                            $('#oetTVOShpName').val("");

                            $('#oetTVOPosCode').val("");
                            $('#oetTVOPosName').val("");

                            $('#oetTVOWahCode').val("");
                            $('#oetTVOWahName').val("");

                            $('#obtBrowseTVOMER').attr('disabled', true);
                            $('#obtBrowseTVOShp').attr('disabled', true);
                            $('#obtBrowseTVOPos').attr('disabled', true);
                            $('#obtBrowseTVOWah').attr('disabled', true);
                            if (tBchCode != "") {
                                $('#obtBrowseTVOMER').attr('disabled', false);
                                $('#obtBrowseTVOShp').attr('disabled', false);
                            }

                            $('#oetTVOXthRefInt').val("");
                            $('#oetTVOXthRefIntDate').val("");

                            setTimeout(function(){
                                $( "#obtTVOBrowseRefInt" ).trigger( "click" );
                            },1000);
                        break;
                        case 'LoadPdt':
                            setTimeout(function(){
                                $( "#obtTVOLoadPdtLayout" ).trigger( "click" );
                            },1000);
                        break;
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>