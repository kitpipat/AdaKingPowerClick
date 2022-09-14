<script type="text/javascript">
    $('#oetAddID').on('change', function(e) {

        var tID = $('#oetAddID').val();
        var tcont = true;
        var tAgsID = $("#oetAgencyID").val();
        var tBranchID = $("#oetBranchID").val();
        var tMerchantID = $("#oetMerchantID").val();
        var tShopID = $("#oetShopID").val();
        $(".xWEachId").each(function() {
            var tusedId = $(this).attr('value');
            if (tusedId == tID) {
                tcont = false;
            }
        });
        if (tID != '' && tcont === true) {
            $('.xWNodata').remove();
            var nNumItems = $('.xWcount').length + 1;
            var tName = $('#oetAddName').val();
            var tHTML = "<tr><td class='xWcount'>" + nNumItems + "</td>";
            tHTML += "<td value='" + tID + "' class='xWEachId' id='otdRoleName" + tID + "'>" + tName + "</td><";
            tHTML += "<td><input type='number' class='xWCountNum' id='oetCountNum' name='oetCountNum' min='1' value='1' roleid='" + tID + "' AgsID='" + tAgsID + "' BranchID='" + tBranchID + "' MerchantID='" + tMerchantID + "' ShopID='" + tShopID + "'></td>"
            tHTML += "<td class='text-center'><img class='xCNIconTable xCNIconDelRow' src='<?php echo base_url() . '/application/modules/common/assets/images/icons/delete.png' ?>'></td></tr>"
            $('#otbUrsRoldList > tbody:last').append(tHTML);
        }

    });

    $(document).ready(function(){
        $('.selectpicker').selectpicker();

        $('.xCNDatePicker').datepicker({
            format: 'yyyy-mm-dd',
            enableOnReadonly: false,
            disableTouchKeyboard : true,
            autoclose: true
        });
        
    // Doc Date From
    $('#obtUSRAdvSearchDocDateForm').unbind().click(function(){
        $('#oetUSRAdvSearcDocDateFrom').datepicker('show');
    });

    // Doc Date To
    $('#obtUSRAdvSearchDocDateTo').unbind().click(function(){
        $('#oetUSRAdvSearcDocDateTo').datepicker('show');
    });
});


    //Depoy Browse
    $(document).on("click", ".xWBrowseDepart", function(e) {
        var nOption = $(this).attr("option");
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseAdd = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";
                var oOptionReturn = {
                    Title: ['authen/user/user', 'tBrowseDPTTitle'],
                    Table: {
                        Master: 'TCNMUsrDepart',
                        PK: 'FTDptCode'
                    },
                    Join: {
                        Table: ['TCNMUsrDepart_L'],
                        On: ['TCNMUsrDepart.FTDptCode = TCNMUsrDepart_L.FTDptCode AND TCNMUsrDepart_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseDPTCode', 'tBrowseDPTName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMUsrDepart.FTDptCode', 'TCNMUsrDepart_L.FTDptName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMUsrDepart.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMUsrDepart.FTDptCode"],
                        Text: [tInputReturnName, "TCNMUsrDepart_L.FTDptName"],
                    },
                    RouteAddNew: 'Add',
                    BrowseLev: 1,
                }

                return oOptionReturn;
            }
            window.oPdtBrowseDepart = oBrowseAdd({
                'tReturnInputCode': 'oetDepartID' + nOption,
                'tReturnInputName': 'oetDepartName' + nOption,
            });
            JCNxBrowseData('oPdtBrowseDepart');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    //Add Browse
    $('#oimAddBrowse').click(function(e) {
        var tAgsID = $("#oetAgencyID").val();
        var tBranchID = $("#oetBranchID").val();
        var tMerchantID = $("#oetMerchantID").val();
        var tShopID = $("#oetShopID").val();
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseAdd = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";
                if (tAgsID != '') {
                    tSQLWhere += "AND TCNMUsrRoleSpc.FTAgnCode = " + tAgsID;
                }
                var oOptionReturn = {
                    Title: ['authen/user/user', 'tUSRRole'],
                    Table: {
                        Master: 'TCNMUsrRoleSpc',
                        PK: 'FTRolCode'
                    },
                    Join: {
                        Table: ['TCNMUsrRole', 'TCNMUsrRole_L'],
                        On: ['TCNMUsrRole.FTRolCode = TCNMUsrRoleSpc.FTRolCode', 'TCNMUsrRole.FTRolCode = TCNMUsrRole_L.FTRolCode AND TCNMUsrRole_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseROLCode', 'tBrowseROLName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMUsrRoleSpc.FTRolCode', 'TCNMUsrRole_L.FTRolName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMUsrRoleSpc.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMUsrRoleSpc.FTRolCode"],
                        Text: [tInputReturnName, "TCNMUsrRole_L.FTRolName"],
                    },
                    RouteAddNew: 'Add',
                    BrowseLev: 1,
                }

                return oOptionReturn;
            }
            window.oPdtBrowseAgency = oBrowseAdd({
                'tReturnInputCode': 'oetAddID',
                'tReturnInputName': 'oetAddName',
            });
            JCNxBrowseData('oPdtBrowseAgency');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    ////browse AGS
    $('#oimBrowseAgs').click(function(e) {
        var tOptionCar = $(this).attr("option");
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
                    Title: ['authen/user/user', 'tUSRAgency'],
                    Table: {
                        Master: 'TCNMAgency',
                        PK: 'FTAgnCode'
                    },
                    Join: {
                        Table: ['TCNMAgency_L'],
                        On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseAgnCode', 'tBrowseAgnName'],
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
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseAgency = oBrowseCarType({
                'tReturnInputCode': 'oetAgencyID',
                'tReturnInputName': 'oetAgencyName',
            });
            JCNxBrowseData('oPdtBrowseAgency');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

        ////browse AGS Excel
        $('#oimBrowseAgsExcel').click(function(e) {
        var tOptionCar = $(this).attr("option");
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
                    Title: ['authen/user/user', 'tUSRAgency'],
                    Table: {
                        Master: 'TCNMAgency',
                        PK: 'FTAgnCode'
                    },
                    Join: {
                        Table: ['TCNMAgency_L'],
                        On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseAgnCode', 'tBrowseAgnName'],
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
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseAgency = oBrowseCarType({
                'tReturnInputCode': 'oetExcelAgencyID',
                'tReturnInputName': 'oetExcelAgencyName',
            });
            JCNxBrowseData('oPdtBrowseAgency');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    ////browse Branch
    $('#oimBrowseBranch').click(function(e) {
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
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
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                        Text: [tInputReturnName, "TCNMBranch_L.FTBchName"],
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseBranch = oBrowseCarType({
                'tReturnInputCode': 'oetBranchID',
                'tReturnInputName': 'oetBranchName',
            });
            JCNxBrowseData('oPdtBrowseBranch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

        ////browse Branch Excel
        $('#oimExcelBrowseBranch').click(function(e) {
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
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
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMBranch.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                        Text: [tInputReturnName, "TCNMBranch_L.FTBchName"],
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseBranch = oBrowseCarType({
                'tReturnInputCode': 'oetExcelBranchID',
                'tReturnInputName': 'oetExcelBranchName',
            });
            JCNxBrowseData('oPdtBrowseBranch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


    ////browse Merchant
    $('#oimBrowseMerchant').click(function(e) {
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
                    Title: ['authen/user/user', 'tBrowseMERTitle'],
                    Table: {
                        Master: 'TCNMMerchant',
                        PK: 'FTMerCode'
                    },
                    Join: {
                        Table: ['TCNMMerchant_L'],
                        On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseMERCode', 'tBrowseMERName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMMerchant.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMMerchant.FTMerCode"],
                        Text: [tInputReturnName, "TCNMMerchant_L.FTMerName"],
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseMerchangt = oBrowseCarType({
                'tReturnInputCode': 'oetMerchantID',
                'tReturnInputName': 'oetMerchantName',
            });
            JCNxBrowseData('oPdtBrowseMerchangt');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

        ////browse Merchant Excel
        $('#oimExcelBrowseMerchant').click(function(e) {
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
                    Title: ['authen/user/user', 'tBrowseMERTitle'],
                    Table: {
                        Master: 'TCNMMerchant',
                        PK: 'FTMerCode'
                    },
                    Join: {
                        Table: ['TCNMMerchant_L'],
                        On: ['TCNMMerchant_L.FTMerCode = TCNMMerchant.FTMerCode AND TCNMMerchant_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseMERCode', 'tBrowseMERName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMMerchant.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMMerchant.FTMerCode"],
                        Text: [tInputReturnName, "TCNMMerchant_L.FTMerName"],
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseMerchangt = oBrowseCarType({
                'tReturnInputCode': 'oetExcelMerchantID',
                'tReturnInputName': 'oetExcelMerchantName',
            });
            JCNxBrowseData('oPdtBrowseMerchangt');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    ////browse Shop
    $('#oimBrowseShop').click(function(e) {
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
                    Title: ['authen/user/user', 'tBrowseSHPTitle'],
                    Table: {
                        Master: 'TCNMShop',
                        PK: 'FTShpCode'
                    },
                    Join: {
                        Table: ['TCNMShop_L'],
                        On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseSHPCode', 'tBrowseSHPName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMShop.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMShop.FTShpCode"],
                        Text: [tInputReturnName, "TCNMShop_L.FTShpName"],
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseShop = oBrowseCarType({
                'tReturnInputCode': 'oetShopID',
                'tReturnInputName': 'oetShopName',
            });
            JCNxBrowseData('oPdtBrowseShop');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });


        ////browse Shop Excel
        $('#oimExcelBrowseShop').click(function(e) {
        var tchkbrowse = $("#ohdChkbrowse").val();
        if (tchkbrowse == '2') {
            return;
        }
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;
            var oBrowseCarType = function(poReturnInput) {
                var tInputReturnCode = poReturnInput.tReturnInputCode;
                var tInputReturnName = poReturnInput.tReturnInputName;
                var tSQLWhere = "";

                var oOptionReturn = {
                    Title: ['authen/user/user', 'tBrowseSHPTitle'],
                    Table: {
                        Master: 'TCNMShop',
                        PK: 'FTShpCode'
                    },
                    Join: {
                        Table: ['TCNMShop_L'],
                        On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop_L.FNLngID = ' + nLangEdits]
                    },
                    Where: {
                        Condition: [tSQLWhere]
                    },
                    GrideView: {
                        ColumnPathLang: 'authen/user/user',
                        ColumnKeyLang: ['tBrowseSHPCode', 'tBrowseSHPName'],
                        ColumnsSize: ['15%', '85%'],
                        WidthModal: 50,
                        DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName'],
                        DataColumnsFormat: ['', ''],
                        Perpage: 10,
                        OrderBy: ['TCNMShop.FDCreateOn DESC'],
                    },
                    CallBack: {
                        ReturnType: 'S',
                        Value: [tInputReturnCode, "TCNMShop.FTShpCode"],
                        Text: [tInputReturnName, "TCNMShop_L.FTShpName"],
                    },
                    RouteAddNew: 'agency',
                    BrowseLev: 1,
                }
                return oOptionReturn;
            }
            window.oPdtBrowseShop = oBrowseCarType({
                'tReturnInputCode': 'oetExcelShopID',
                'tReturnInputName': 'oetExcelShopName',
            });
            JCNxBrowseData('oPdtBrowseShop');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

</script>