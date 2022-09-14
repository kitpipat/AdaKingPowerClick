<script type="text/javascript">
    var nLangEdits = '<?php echo $this->session->userdata("tLangEdit"); ?>';
    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';

    $(document).ready(function() {

    });

    $('.xCNDatePicker').selectpicker();

    // Click Button Date
    $('#obtMmtBrowseDateStart').unbind().click(function() {
        $('#oetMmtDateStart').datepicker('show');
    });

    $('#obtMmtBrowseDateTo').unbind().click(function() {
        $('#oetMmtDateTo').datepicker('show');
    });


    // Event Date Picker
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtMmtMultiBrowseBranch').unbind().click(function() {
        //เปิดปุ่ม
        // $('#obtMmtMultiBrowseBranch').attr("disabled", true);

        // เซตค่าว่าง ร้านค่า
        $('#oetMmtShpStaSelectAll').val('');
        $('#oetMmtShpCodeSelect').val('');
        $('#oetMmtShpNameSelect').val('');

        // เซตค่าว่าง คลังสินค้า
        $('#oetMmtWahStaSelectAll').val('');
        $('#oetMmtWahCodeSelect').val('');
        $('#oetMmtWahNameSelect').val('');

        //เซตค่าว่าง สินค้า
        $('#oetMmtPdtStaSelectAll').val('');
        $('#oetMmtPdtCodeSelect').val('');
        $('#oetMmtPdtNameSelect').val('');

        // $('#obtMmtMultiBrowseShop').attr('disabled',true);
        // $('#obtMmtMultiBrowseWaHouse').attr('disabled',true);
        // $('#obtMmtMultiBrowseProduct').attr('disabled',true);




        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

            var tUsrLevel = "<?php echo $this->session->userdata("tSesUsrLevel"); ?>";
            var tBchCodeMulti = "<?php echo $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
            var nCountBch = "<?php echo $this->session->userdata("nSesUsrBchCount"); ?>";
            let tWhere = "";

            if (tUsrLevel != "HQ") {
                tWhere = " AND TCNMBranch.FTBchCode IN (" + tBchCodeMulti + ") ";
            } else {
                tWhere = "";
            }

            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oBranchBrowseMultiOption = undefined;
            oBranchBrowseMultiOption = {
                Title: ['company/branch/branch', 'tBCHTitle'],
                Table: {
                    Master: 'TCNMBranch',
                    PK: 'FTBchCode'
                },
                Join: {
                    Table: ['TCNMBranch_L'],
                    On: ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: [tWhere]
                },
                GrideView: {
                    ColumnPathLang: 'company/branch/branch',
                    ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                    Perpage: 10,
                },
                CallBack: {
                    // StausAll    : ['oetMmtBchStaSelectAll'],
                    ReturnType: 'S',
                    Value: ['oetMmtBchCodeSelect', 'TCNMBranch.FTBchCode'],
                    Text: ['oetMmtBchNameSelect', 'TCNMBranch_L.FTBchName']
                },
                NextFunc: {
                    FuncName: "JSvMevementBntBch",
                    ArgReturn: ['FTBchCode', 'FTBchName']
                },
            };
            // JCNxBrowseMultiSelect('oBranchBrowseMultiOption');
            JCNxBrowseData('oBranchBrowseMultiOption');
            // $('#obtMmtMultiBrowseBranch').attr("disabled", false);
        } else {
            JCNxShowMsgSessionExpired();
        }
    });
    //เปิดปุ่ม
    function JSvMevementBntBch(PtDataBch) {
        if (PtDataBch == 'NULL') {
            $('#obtMmtMultiBrowseShop').attr('disabled', true);
            $('#obtMmtMultiBrowseWaHouse').attr('disabled', true);
            $('#obtMmtMultiBrowseProduct').attr('disabled', true);
        } else {
            $('#obtMmtMultiBrowseShop').removeAttr('disabled');
            $('#obtMmtMultiBrowseWaHouse').removeAttr('disabled');
            $('#obtMmtMultiBrowseProduct').removeAttr('disabled');
        }
        return;
        // $('#obtMmtMultiBrowseBranch').attr("disabled", false);
    }
    // =========================================== Event Browse Multi Branch ===========================================

    // ============================================ Event Browse Multi Shop ============================================
    $('#obtMmtMultiBrowseShop').unbind().click(function() {
        //ปิดปุ่ม
        // $('#obtMmtMultiBrowseShop').attr("disabled", true);

        // เซตค่าว่าง คลังสินค้า
        $('#oetMmtWahStaSelectAll').val('');
        $('#oetMmtWahCodeSelect').val('');
        $('#oetMmtWahNameSelect').val('');

        //เซตค่าว่าง สินค้า
        $('#oetMmtPdtStaSelectAll').val('');
        $('#oetMmtPdtCodeSelect').val('');
        $('#oetMmtPdtNameSelect').val('');

        var nStaSession = JCNxFuncChkSessionExpired();
        let tBchcode = $('#oetMmtBchCodeSelect').val();

        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oShopBrowseMultiOption = undefined;
            tShpWhereBch = "";
            tBchcode = tBchcode.replace(/,/g, "','");
            tShpWhereBch = "AND TCNMShop.FTBchCode IN ('" + tBchcode + "') ";
            oShopBrowseMultiOption = {
                Title: ['company/shop/shop', 'tSHPTitle'],
                Table: {
                    Master: 'TCNMShop',
                    PK: 'FTShpCode'
                },
                Join: {
                    Table: ['TCNMShop_L', 'TCNMBranch_L'],
                    On: [
                        'TCNMShop.FTBchCode = TCNMShop_L.FTBchCode      AND TCNMShop.FTShpCode = TCNMShop_L.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                        'TCNMShop.FTBchCode = TCNMBranch_L.FTBchCode    AND TCNMBranch_L.FNLngID = ' + nLangEdits
                    ]
                },
                Where: {
                    Condition: [tShpWhereBch]
                },
                GrideView: {
                    ColumnPathLang: 'company/shop/shop',
                    ColumnKeyLang: ['tSHPTBBranch', 'tSHPTBCode', 'tSHPTBName'],
                    ColumnsSize: ['15%', '15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMBranch_L.FTBchName', 'TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                    DataColumnsFormat: ['', '', ''],
                    OrderBy: ['TCNMShop.FDCreateOn DESC'],
                    Perpage: 10,
                },
                CallBack: {
                    StausAll: ['oetMmtShpStaSelectAll'],
                    Value: ['oetMmtShpCodeSelect', "TCNMShop.FTShpCode"],
                    Text: ['oetMmtShpNameSelect', "TCNMShop_L.FTShpName"]
                },
                // NextFunc    : {
                // FuncName    : "JSvMevementBntShp",
                // ArgReturn   : ['FTBchCode','FTShpCode']
                // },
                // DebugSQL : true
            };
            JCNxBrowseMultiSelect('oShopBrowseMultiOption');
            $('#obtMmtMultiBrowseShop').attr("disabled", false);
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //เปิดปุ่ม
    // function JSvMevementBntShp(PtDataShp){
    //     console.log('JSvMevementBntShp');
    //     console.log(PtDataShp);
    //     $('#obtMmtMultiBrowseShop').attr("disabled", false);
    // }
    // ============================================ END Event Browse Multi Shop ============================================

    // =========================================== Event Browse Multi WaHouse ===========================================
    $('#obtMmtMultiBrowseWaHouse').unbind().click(function() {
        //ปิดปุ่ม
        //เซตค่าว่าง สินค้า
        $('#oetMmtPdtStaSelectAll').val('');
        $('#oetMmtPdtCodeSelect').val('');
        $('#oetMmtPdtNameSelect').val('');
        var nStaSession = JCNxFuncChkSessionExpired();
        let tBchcode = $('#oetMmtBchCodeSelect').val();
        let tShpcode = $('#oetMmtShpCodeSelect').val();
        let tTable = "TCNMWaHouse";

        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oWaHouseBrowseMultiOption = undefined;
            tWahWherWah = "";
            tWahWherWah = "AND TCNMWaHouse.FTBchCode = '" + $('#oetMmtBchCodeSelect').val() + "' ";
            var tOrderBy = tTable + ".FDCreateOn DESC";
            oWaHouseBrowseMultiOption = {
                Title: ['company/warehouse/warehouse', 'tWAHSubTitle'],
                Table: {
                    Master: tTable,
                    PK: 'FTWahCode'
                },
                Join: {
                    Table: ['TCNMWaHouse_L'],
                    On: ['TCNMWaHouse_L.FTWahCode = "' + tTable + '".FTWahCode AND "' + tTable + '".FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits]
                },
                Where: {
                    Condition: [tWahWherWah]
                },
                GrideView: {
                    ColumnPathLang: 'company/warehouse/warehouse',
                    ColumnKeyLang: ['tWahCode', 'tWahName'],
                    ColumnsSize: ['15%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['"' + tTable + '".FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                    DataColumnsFormat: ['', ''],
                    OrderBy: [tOrderBy],
                    Perpage: 10,
                },
                CallBack: {
                    StausAll: ['oetMmtWahStaSelectAll'],
                    Value: ['oetMmtWahCodeSelect', '"' + tTable + '".FTWahCode'],
                    Text: ['oetMmtWahNameSelect', 'TCNMWaHouse_L.FTWahName']
                }
            };
            JCNxBrowseMultiSelect('oWaHouseBrowseMultiOption');
            $('#obtMmtMultiBrowseWaHouse').attr("disabled", false);
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //เปิดปุ่ม
    function JSvMevementBntWah(PtDataWah) {
        $('#obtMmtMultiBrowseWaHouse').attr("disabled", false);
    }
    // =========================================== Event Browse Multi WaHouse ===========================================

    // =========================================== Event Browse Multi Branch ===========================================
    $('#obtMmtMultiBrowseProduct').unbind().click(function() {
        // ปิดปุ่ม
        // $('#obtMmtMultiBrowseProduct').attr("disabled", true);
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            window.oProductBrowseMultiOptionMovement = undefined;
            let tSessionUsrLev = '<?=$this->session->userdata('tSesUsrLevel')?>';
            let tBchCodeSess = $('#oetMmtBchCodeSelect').val();
            let tCondition = '';
            if (tBchCodeSess != '' && tSessionUsrLev!= 'HQ') {
                tCondition += " AND ( TCNMPdtSpcBch.FTBchCode = '" + tBchCodeSess + "' OR ( TCNMPdtSpcBch.FTBchCode IS NULL OR TCNMPdtSpcBch.FTBchCode ='' ) )";
            }

            let tAgnCode        = '<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>';
            if( tAgnCode != '' ){
                tCondition += " AND TCNMPdtSpcBch.FTAgnCode = '"+tAgnCode+"' ";
            }


            oProductBrowseMultiOptionMovement = {
                Title: ['product/product/product', 'tPDTTitle'],
                Table: {
                    Master: 'TCNMPdt',
                    PK: 'FTPdtCode'
                },
                Join: {
                    Table: ['TCNMPdt_L', 'TCNMPdtSpcBch'],
                    On: [
                        'TCNMPdt_L.FTPdtCode = TCNMPdt.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits,
                        'TCNMPdtSpcBch.FTPdtCode = TCNMPdt.FTPdtCode'
                    ]
                },
                Where: {
                    Condition: [tCondition]
                },
                GrideView: {
                    ColumnPathLang: 'product/product/product',
                    ColumnKeyLang: ['tPDTCode', 'tPDTName'],
                    ColumnsSize: ['10%', '75%'],
                    WidthModal: 50,
                    DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
                    DataColumnsFormat: ['', ''],
                    Perpage: 10,
                    OrderBy: ['TCNMPdt.FDCreateOn DESC'],
                    SourceOrder: "ASC"
                },
                CallBack: {
                    StaSingItem: '1',
                    ReturnType: 'M',
                    Value: ['oetMmtPdtCodeSelect', "TCNMPdt.FTPdtCode"],
                    Text: ['oetMmtPdtNameSelect', "TCNMPdt_L.FTPdtName"],
                },
                // RouteAddNew : 'saleperson',
                BrowseLev: 1,
                //DebugSQL : true
            }
            JCNxBrowseData('oProductBrowseMultiOptionMovement');


            $('#obtMmtMultiBrowseProduct').attr("disabled", false);
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //เปิดปุ่ม
    function JSvMevementBntPdt(PtDataPdt) {
        $('#obtMmtMultiBrowseProduct').attr("disabled", false);
    }
    // =========================================== Event Browse Multi Branch ===========================================
</script>