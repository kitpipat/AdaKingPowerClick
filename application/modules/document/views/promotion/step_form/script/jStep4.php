<script>
    $(document).ready(function() {
        if (!bIsApvOrCancel) {
            if (tUserLoginLevel == 'HQ') {
                // สาขาต้นทางต้องถูกกำหนดก่อนที่จะเลือก กลุ่มร้านค้าปลายทาง
                if ($('#oetPromotionStep4BchCode').val() == '') { // ไม่ได้กำหนดสาขาต้นทาง
                    $('#obtPromotionStep4BrowseMer').attr('disabled', true);
                } else { // กำหนดสาขาต้นทางแล้ว
                    $('#obtPromotionStep4BrowseMer').attr('disabled', false);
                }
                $('#obtPromotionStep4BrowseShp').attr('disabled', true);
            }

            if (tUserLoginLevel == 'BCH') {
                if (!bIsMultiBch) {
                    $('#obtPromotionStep4BrowseBch').attr('disabled', true);
                }
                $('#obtPromotionStep4BrowseAgency').attr('disabled', true);
                $('#obtPromotionStep4BrowseShp').attr('disabled', true);
            }

            <?php if (FCNbGetIsShpEnabled()) { ?>
                if (tUserLoginLevel == 'SHP') {
                    if (!bIsMultiBch) {
                        $('#obtPromotionStep4BrowseBch').attr('disabled', true);
                    }
                    $('#obtPromotionStep4BrowseAgency').attr('disabled', true);
                    $('#obtPromotionStep4BrowseMer').attr('disabled', true);
                    $('#obtPromotionStep4BrowseShp').attr('disabled', true);
                }

                if ($('#oetPromotionStep4MerchantCode').val() != '') { // กำหนดกลุ่มร้านค้าต้นทางแล้ว
                    $('#obtPromotionStep4BrowseShp').attr('disabled', false);
                }
            <?php } ?>
        }
    });

    /*===== Begin PdtPmtHDCstPri Table Process =========================================*/
    /**
     * Functionality : Get PdtPmtHDCstPri in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4GetPdtPmtHDCstPriInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep4GetPriceGroupConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    $('.xCNPromotionStep4TablePriceGroupCondition').html(oResult.html);

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

    /**
     * Functionality : Insert PdtPmtHDCstPri to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep4InsertPdtPmtHDCstPriToTemp(ptParams) {
        $('#ohdPromotionStep4PriceGroupCodeTmp').val("");
        $('#ohdPromotionStep4PriceGroupNameTmp').val("");

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep4InsertPriceGroupConditionToTmp",
                data: {
                    tBchCode: tBchCode,
                    tPplList: ptParams
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxPromotionStep4GetPdtPmtHDCstPriInTmp(1, true);
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

    /**
     * Functionality : Clear PdtPmtHDCstPri in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep4ClearPdtPmtHDCstPriInTemp(pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var bLoadingGet = false;

            if (pbUseLoading) {
                JCNxOpenLoading();
                bLoadingGet = true;
            }

            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();

            $.ajax({
                type: "POST",
                url: "promotionStep1ClearPmtDtInTmp",
                cache: false,
                data: {
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld
                },
                timeout: 5000,
                success: function(tResult) {
                    JSxPromotionStep1GetPdtPmtHDCstPriInTmp(1, bLoadingGet);
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

    /**
     * Functionality : Browse Price Group
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4BrowsePriceGroup() {
        // option Brand
        window.oPromotionBrowseBrand = {
            Title: ['product/pdtpricelist/pdtpricelist', 'tPPLTitle'],
            Table: {
                Master: 'TCNMPdtPriList',
                PK: 'FTPplCode',
                PKName: 'FTPplName'
            },
            Join: {
                Table: ['TCNMPdtPriList_L'],
                On: ['TCNMPdtPriList.FTPplCode = TCNMPdtPriList_L.FTPplCode AND TCNMPdtPriList_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        return " AND TCNMPdtPriList.FTPplCode NOT IN (SELECT FTPplCode FROM TCNTPdtPmtHDCstPri_Tmp WHERE FTSessionID = '<?php echo $this->session->userdata("tSesSessionID"); ?>')";
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'product/pdtpricelist/pdtpricelist',
                ColumnKeyLang: ['tPPLTBCode', 'tPPLTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMPdtPriList.FTPplCode', 'TCNMPdtPriList_L.FTPplName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMPdtPriList.FTPplCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["ohdPromotionStep4PriceGroupCodeTmp", "TCNMPdtPriList.FTPplCode"],
                Text: ["ohdPromotionStep4PriceGroupNameTmp", "TCNMPdtPriList_L.FTPplName"],
            },
            NextFunc: {
                FuncName: 'JSvPromotionStep4InsertPdtPmtHDCstPriToTemp',
                ArgReturn: ['FTPplCode', 'FTPplName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oPromotionBrowseBrand');
    }
    /*===== End PdtPmtHDCstPri Table Process ===============================================*/


    /*===== Begin PdtPmtHDBch Table Process ===========================================*/
    /**
     * Functionality : Get PdtPmtHDBch in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4GetPdtPmtHDBchInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep4GetBchConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    $('.xCNPromotionStep4TableBranchCondition').html(oResult.html);
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

    /**
     * Functionality : Insert PdtPmtHDBch to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep4InsertPdtPmtHDBchToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tAgnCode = $('#oetPromotionStep4AgencyCode').val();
            var tAgnName = $('#oetPromotionStep4AgencyName').val();
            var tBchCode = $('#oetPromotionStep4BchCode').val();
            var tBchName = $('#oetPromotionStep4BchName').val();
            var tMerCode = $('#oetPromotionStep4MerchantCode').val();
            var tMerName = $('#oetPromotionStep4MerchantName').val();
            var tShpCode = $('#oetPromotionStep4ShopCode').val();
            var tShpName = $('#oetPromotionStep4ShopName').val();


            // if (tAgnCode == '' || tAgnCode == undefined) {
            //     var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg30'); ?>'; // กรุณาเลือกตัวแทนขายก่อนบันทึก
            //     FSvCMNSetMsgWarningDialog(tWarningMessage);
            //     return;
            // }

            <?php if (!FCNbUsrIsAgnLevel()) { ?>
                if (tBchCode == '' || tBchCode == undefined) {
                    var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg3'); ?>'; // กรุณาเลือกสาขาก่อนบันทึก
                    FSvCMNSetMsgWarningDialog(tWarningMessage);
                    return;
                }
            <?php } ?>
            <?php if (FCNbGetIsShpEnabled() && false) { ?>
                if (tUserLoginLevel == "BCH") {
                    if (tMerCode == '' || tMerCode == undefined) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg4'); ?>'; // กรุณาเลือกกลุ่มร้านค้าก่อนบันทึก
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                }

                if (tUserLoginLevel == "SHP") {
                    if (tMerCode == '' || tMerCode == undefined) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg4'); ?>'; // กรุณาเลือกกลุ่มร้านค้าก่อนบันทึก
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                    if (tShpCode == '' || tShpCode == undefined) {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg5'); ?>'; // กรุณาเลือกร้านค้าก่อนบันทึก
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                        return;
                    }
                }
            <?php } ?>

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep4InsertBchConditionToTmp",
                data: {
                    tAgnCode: tAgnCode,
                    tAgnName: tAgnName,
                    tBchCode: tBchCode,
                    tBchName: tBchName,
                    tMerCode: tMerCode,
                    tMerName: tMerName,
                    tShpCode: tShpCode,
                    tShpName: tShpName
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    if (oResult.nStaEvent == "1") {
                        JSxPromotionStep4GetPdtPmtHDBchInTmp(1, true);
                        $('#odvPromotionStep4AddBchConditionPanel').modal('hide');
                    }
                    if (oResult.nStaEvent == "007") {
                        var tWarningMessage = '<?php echo language('document/promotion/promotion', 'tWarMsg6'); ?>'; // เงื่อนไขที่เลือกมีการกำหนดไว้แล้ว
                        FSvCMNSetMsgWarningDialog(tWarningMessage);
                    }
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

    /**
     * Functionality : Add Bch Condition Panel
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4AddBchConditionPanel() {
        // if(bIsShpEnabled){
        $('#odvPromotionStep4AddBchConditionPanel').modal('show');
        // }else{
        //     $("#obtPromotionStep4BrowseBch").trigger('click');
        // }
    }

    /*===== Begin Event Browse =========================================================*/
    // Agency
    $("#obtPromotionStep4BrowseAgency").click(function() {
        // option 
        window.oPromotionStep4BrowseAgency = {
            Title: ['authen/user/user', 'tBrowseBCHTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = "";
                        if (tUserLoginLevel != "HQ") {
                            tSQL += " AND TCNMAgency.FTAgnCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>' ";
                        }
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tBrowseBCHCode', 'tBrowseBCHName'],
                ColumnsSize: ['10%', '75%'],
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMAgency.FTAgnCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionStep4AgencyCode", "TCNMAgency.FTAgnCode"],
                Text: ["oetPromotionStep4AgencyName", "TCNMAgency_L.FTAgnName"]
            },
            NextFunc: {
                FuncName: 'JSxPromotionStep4CallbackAgency',
                ArgReturn: ['FTAgnCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oPromotionStep4BrowseAgency');
    });

    // สาขา
    $("#obtPromotionStep4BrowseBch").click(function() {
        // option 
        window.oPromotionStep4BrowseBch = {
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
                // Condition: [" AND TCNMBranch.FTBchCode IN(SELECT FTBchCode FROM TCNMShop WHERE FTBchCode = '" + $('#oetPromotionStep4BchCode').val() + "') "]
                Condition: [
                    function() {
                        var bIsAgnEmpty = ($("#oetPromotionStep4AgencyCode").val() == "") || $("#oetPromotionStep4AgencyCode").val() == undefined;
                        var tSQL = " AND TCNMBranch.FTBchCode NOT IN(SELECT FTPmhBchTo AS FTBchCode FROM TCNTPdtPmtHDBch_Tmp WHERE FTSessionID = '<?php echo $this->session->userdata("tSesSessionID"); ?>')";
                        if (!bIsAgnEmpty && tUserLoginLevel == "HQ") {
                            tSQL += " AND TCNMBranch.FTAgnCode = '" + $('#oetPromotionStep4AgencyCode').val() + "'";
                        }
                        if (tUserLoginLevel != "HQ") {
                            tSQL += " AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>) ";
                        }
                        return tSQL;
                    }
                ]
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
                Value: ["oetPromotionStep4BchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetPromotionStep4BchName", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxPromotionStep4CallbackBch',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1,
            // DebugSQL : true
        };
        JCNxBrowseData('oPromotionStep4BrowseBch');
    });

    // กลุ่มธุรกิจ
    $("#obtPromotionStep4BrowseMer").click(function() {
        // option
        window.oPromotionStep4BrowseMer = {
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
                // Condition: [" AND TCNMMerchant.FTMerCode IN(SELECT FTMerCode FROM TCNMShop WHERE FTBchCode = '" + $('#oetPromotionStep4BchCode').val() + "') "]
                Condition: [
                    function() {
                        var tSQL = "";
                        if (tUserLoginLevel == "SHP") {
                            tSQL += " AND TCNMMerchant.FTMerCode IN (SELECT FTMerCode FROM TCNMShop WHERE FTShpCode IN (<?php echo $this->session->userdata('tSesUsrShpCodeMulti'); ?>)) AND FTBchCode = '" + $('#oetPromotionStep4BchCode').val() + "'";
                        }
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/warehouse/warehouse',
                ColumnKeyLang: ['tWAHBwsMchCode', 'tWAHBwsMchNme'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMMerchant.FTMerCode', 'TCNMMerchant_L.FTMerName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMMerchant.FTMerCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionStep4MerchantCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetPromotionStep4MerchantName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxPromotionStep4CallbackMer',
                ArgReturn: ['FTMerCode', 'FTMerName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        };
        JCNxBrowseData('oPromotionStep4BrowseMer');
    });

    // ร้านค้า
    $("#obtPromotionStep4BrowseShp").click(function() {
        // Option Shop
        window.oPromotionStep4BrowseShp = {
            Title: ['company/shop/shop', 'tSHPTitle'],
            Table: {
                Master: 'TCNMShop',
                PK: 'FTShpCode'
            },
            Join: {
                Table: ['TCNMShop_L', 'TCNMWaHouse_L'],
                On: [
                    'TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits,
                    'TCNMWaHouse_L.FTWahCode = TCNMShop.FTWahCode AND TCNMWaHouse_L.FTBchCode = TCNMShop.FTBchCode AND TCNMWaHouse_L.FNLngID = ' + nLangEdits,
                ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = " AND TCNMShop.FTShpType = '1' AND TCNMShop.FTMerCode = '" + $('#oetPromotionStep4MerchantCode').val() + "' AND TCNMShop.FTBchCode = '" + $('#oetPromotionStep4BchCode').val() + "'";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode', 'TCNMShop.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
                DataColumnsFormat: ['', '', '', '', '', ''],
                DisabledColumns: [2, 3, 4, 5],
                Perpage: 5,
                OrderBy: ['TCNMShop_L.FTShpName'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionStep4ShopCode", "TCNMShop.FTShpCode"],
                Text: ["oetPromotionStep4ShopName", "TCNMShop_L.FTShpName"],
            },
            NextFunc: {
                FuncName: 'JSxPromotionStep4CallbackShp',
                ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType', 'FTWahCode', 'FTWahName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oPromotionStep4BrowseShp');
    });
    /*===== End Event Browse ===========================================================*/

    /*===== Begin Callback Browse ======================================================*/
    // Browse Bch Callback
    function JSxPromotionStep4CallbackBch(params) {
        var tBchCode = $('#oetPromotionStep4BchCode').val();

        $('#oetPromotionStep4MerchantCode').val("");
        $('#oetPromotionStep4MerchantName').val("");
        $('#oetPromotionStep4ShopCode').val("");
        $('#oetPromotionStep4ShopName').val("");

        $('#obtPromotionStep4BrowseMer').attr('disabled', true);
        $('#obtPromotionStep4BrowseShp').attr('disabled', true);

        if (tBchCode != "") {
            $('#obtPromotionStep4BrowseMer').attr('disabled', false);
        }

        if (!bIsShpEnabled) {
            JSvPromotionStep4InsertPdtPmtHDBchToTemp();
        }
    }

    // Browse Mer Callback
    function JSxPromotionStep4CallbackMer(params) {
        var tMerCode = $('#oetPromotionStep4MerchantCode').val();

        $('#oetPromotionStep4ShopCode').val("");
        $('#oetPromotionStep4ShopName').val("");

        $('#obtPromotionStep4BrowseShp').attr('disabled', true);

        if (tMerCode != "") {
            $('#obtPromotionStep4BrowseShp').attr('disabled', false);
        }
    }

    // Browse Shop Callback
    function JSxPromotionStep4CallbackShp(params) {
        var aParam = JSON.parse(params);
        $('#oetPromotionStep4WahInShopCode').val(aParam[3]);
    }
    /*===== End PdtPmtHDBch Table Process ==============================================*/

    /**
     * Functionality : Browse Channel
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4AddChnConditionPanel() {
        // var tBchCode = $('#oetPromotionBchCode').val();
        // option Brand
        window.oPromotionBrowseChanel = {
            Title: ['pos/poschannel/poschannel', 'tCHNLabelTitle'],
            Table: {
                Master: 'TCNMChannel',
                PK: 'FTChnCode'
            },
            Join: {
                Table: ['TCNMChannelSpc', 'TCNMChannel_L'],
                On: ['TCNMChannelSpc.FTChnCode = TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnCode = TCNMChannel.FTChnCode  AND TCNMChannel_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        var bIsAgnEmpty = ($("#oetPromotionStep4AgencyCode").val() == "") || $("#oetPromotionStep4AgencyCode").val() == undefined;
                        var tSQL = " AND TCNMChannel.FTChnCode NOT IN (SELECT FTChnCode FROM TCNTPdtPmtHDChn_Tmp WHERE FTSessionID = '<?php echo $this->session->userdata("tSesSessionID"); ?>') ";
                        if (!bIsAgnEmpty && tUserLoginLevel == "HQ") {
                            tSQL += " AND ( TCNMChannelSpc.FTAgnCode = '" + $('#oetPromotionStep4AgencyCode').val() + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) ";
                        }

                        var tSesUsrLoginLevel = '<?= $this->session->userdata("tSesUsrLoginLevel") ?>';

                        if (tSesUsrLoginLevel != "HQ") {
                            var tSesUsrAgnCode = '<?= $this->session->userdata("tSesUsrAgnCode") ?>';
                            tSQL += " AND ( TCNMChannelSpc.FTAgnCode = '" + tSesUsrAgnCode + "' OR ISNULL(TCNMChannelSpc.FTAgnCode,'') = '' ) ";

                            if (tSesUsrLoginLevel != "AGN") {
                                var tSesUsrBchCodeMulti = "<?= $this->session->userdata("tSesUsrBchCodeMulti") ?>";
                                tSQL += " AND ( TCNMChannelSpc.FTBchCode IN (" + tSesUsrBchCodeMulti + ") OR ISNULL(TCNMChannelSpc.FTBchCode,'') = '' ) ";
                            }

                            if (tSesUsrLoginLevel == "SHP") {
                                var tSesUsrShpCodeMulti = "<?= $this->session->userdata("tSesUsrShpCodeMulti") ?>";
                                tSQL += " AND ( TCNMChannelSpc.FTShpCode IN (" + tSesUsrShpCodeMulti + ") OR ISNULL(TCNMChannelSpc.FTShpCode,'') = '' ) ";
                            }
                        }
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'pos/poschannel/poschannel',
                ColumnKeyLang: ['tCHNLabelChannelCode', 'tCHNLabelChannelName'],
                ColumnsSize: ['15%', '85%'],
                DataColumns: ['TCNMChannel.FTChnCode', 'TCNMChannel_L.FTChnName'],
                DataColumnsFormat: ['', ''],
                WidthModal: 50,
                Perpage: 10,
                OrderBy: ['TCNMChannel.FDCreateOn DESC']
                // SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetPromotionStep4ChnCode", "TCNMChannel.FTChnCode"],
                Text: ["oetPromotionStep4ChnName", "TCNMChannel_L.FTChnName"]
            },
            NextFunc: {
                FuncName: 'JSxPromotionStep4CallbackChn',
                ArgReturn: ['FTChnCode', 'FTChnName']
            },
            RouteAddNew: 'chanel',
            BrowseLev: 1,
            // DebugSQL : true
        };
        JCNxBrowseData('oPromotionBrowseChanel');


    }


    /**
     * Functionality : Get Channel in Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4GetHDChnInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep4GetChnConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    $('.xCNPromotionStep4TableChanelCondition').html(oResult.html);

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

    /**
     * Functionality : Insert PdtPmtHDChn to Temp
     * Parameters : -
     * Creator : 04/01/2021 Worakorn
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4CallbackChn(ptParams) {
        $('#oetPromotionStep4ChnCode').val("");
        $('#oetPromotionStep4ChnName').val("");

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep4InsertChnConditionToTmp",
                data: {
                    tBchCode: tBchCode,
                    tChnList: ptParams
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxPromotionStep4GetHDChnInTmp(1, true);
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



    /*===== Begin PdtPmtHDCstLev Table Process =========================================*/
    /**
     * Functionality : Get PdtPmtHDCstLev in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4GetPdtPmtHDCstLevInTmp(pnPage, pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

            if (pbUseLoading) {
                JCNxOpenLoading();
            }

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "promotionStep4GetCstLevConditionInTmp",
                data: {
                    tBchCode: tBchCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    $('.xCNPromotionStep4TableCstLevCondition').html(oResult.html);

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

    /**
     * Functionality : Insert PdtPmtHDCstLev to Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep4InsertPdtPmtHDCstLevToTemp(ptParams) {
        $('#ohdPromotionStep4CstLevCodeTmp').val("");
        $('#ohdPromotionStep4CstLevNameTmp').val("");

        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetPromotionBchCode').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionStep4InsertCstLevConditionToTmp",
                data: {
                    tBchCode: tBchCode,
                    tPplList: ptParams
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    JSxPromotionStep4GetPdtPmtHDCstLevInTmp(1, true);
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

    /**
     * Functionality : Clear PdtPmtHDCstLev in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionStep4ClearPdtPmtHDCstLevInTemp(pbUseLoading) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var bLoadingGet = false;

            if (pbUseLoading) {
                JCNxOpenLoading();
                bLoadingGet = true;
            }

            var tPmtGroupNameTmp = $('#oetPromotionGroupNameTmp').val();
            var tPmtGroupNameTmpOld = $('#ohdPromotionGroupNameTmpOld').val();

            $.ajax({
                type: "POST",
                url: "promotionStep1ClearPmtDtInTmp",
                cache: false,
                data: {
                    tPmtGroupNameTmp: tPmtGroupNameTmp,
                    tPmtGroupNameTmpOld: tPmtGroupNameTmpOld
                },
                timeout: 0,
                success: function(tResult) {
                    JSxPromotionStep1GetPdtPmtHDCstLevInTmp(1, bLoadingGet);
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

    /**
     * Functionality : Browse Price Group
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxPromotionStep4BrowseCstLev() {
        // option Brand
        window.oPromotionBrowseBrand = {
            Title: ['customer/customerlevel/customerlevel', 'tCstLevTitle'],
            Table: {
                Master: 'TCNMCstLev',
                PK: 'FTClvCode',
                PKName: 'FTClvName'
            },
            Join: {
                Table: ['TCNMCstLev_L'],
                On: ['TCNMCstLev.FTClvCode = TCNMCstLev_L.FTClvCode AND TCNMCstLev_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        return " AND TCNMCstLev.FTClvCode NOT IN (SELECT FTClvCode FROM TCNTPdtPmtHDCstLev_Tmp WHERE FTSessionID = '<?php echo $this->session->userdata("tSesSessionID"); ?>')";
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'customer/customerlevel/customerlevel',
                ColumnKeyLang: ['tCstLevTBCode', 'tCstLevTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMCstLev.FTClvCode', 'TCNMCstLev_L.FTClvName'],
                DataColumnsFormat: ['', ''],
                Perpage: 5,
                OrderBy: ['TCNMCstLev.FTClvCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["ohdPromotionStep4CstLevCodeTmp", "TCNMCstLev.FTClvCode"],
                Text: ["ohdPromotionStep4CstLevNameTmp", "TCNMCstLev_L.FTClvName"],
            },
            NextFunc: {
                FuncName: 'JSvPromotionStep4InsertPdtPmtHDCstLevToTemp',
                ArgReturn: ['FTClvCode', 'FTClvName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oPromotionBrowseBrand');
    }
    /*===== End PdtPmtHDCstLev Table Process ===============================================*/

    // Create By : Napat(Jame) 02/02/2565
    // function JSxPromotionStep4GetHDPnpInTmp(pnPage, pbUseLoading) {
    //     var nStaSession = JCNxFuncChkSessionExpired();
    //     if (typeof nStaSession !== "undefined" && nStaSession == 1) {

    //         var tBchCode = $('#oetPromotionBchCode').val();

    //         var tSearchAll = $('#oetPromotionPdtLayoutSearchAll').val();

    //         if (pbUseLoading) {
    //             JCNxOpenLoading();
    //         }

    //         (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

    //         $.ajax({
    //             type: "POST",
    //             url: "promotionStep4GetPnpConditionInTmp",
    //             data: {
    //                 tBchCode: tBchCode,
    //                 nPageCurrent: pnPage,
    //                 tSearchAll: tSearchAll
    //             },
    //             cache: false,
    //             success: function(oResult) {
    //                 $('.xCNPromotionStep4TablePromotionOnPromotionCondition').html(oResult.html);

    //                 JCNxCloseLoading();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxCloseLoading();
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });

    //     } else {
    //         JCNxShowMsgSessionExpired();
    //     }
    // }

    // Create By : Napat(Jame) 02/02/2565
    // function JSxPromotionStep4CallbackPnp(ptParams) {
    //     $('#oetPromotionStep4PnpCode').val("");
    //     $('#oetPromotionStep4PnpName').val("");

    //     var nStaSession = JCNxFuncChkSessionExpired();
    //     if (typeof nStaSession !== "undefined" && nStaSession == 1) {

    //         var tBchCode = $('#oetPromotionBchCode').val();

    //         JCNxOpenLoading();

    //         $.ajax({
    //             type: "POST",
    //             url: "promotionStep4InsertPnpConditionToTmp",
    //             data: {
    //                 tBchCode: tBchCode,
    //                 tPnpList: ptParams
    //             },
    //             cache: false,
    //             timeout: 5000,
    //             success: function(tResult) {
    //                 JSxPromotionStep4GetHDPnpInTmp(1, true);
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxCloseLoading();
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });

    //     } else {
    //         JCNxShowMsgSessionExpired();
    //     }
    // }

    /**
     * Functionality : Browse Promotion On Promtoion
     * Parameters : -
     * Creator : 01/10/2021 Worakorn
     * Return : -
     * Return Type : -
     */
    // function JSxPromotionStep4AddPnpConditionPanel() {
    //     var tBchCode = $('#ohdPromotionBchCode').val();
    //     var tAgnCode = $('#ohdPromotionAgnCode').val();

    //     window.oPromotionBrowsePromotionOnPromotion = {
    //         Title: ['document/promotion/promotion', 'tPnpLabelTitle'],
    //         Table: {
    //             Master: 'TCNTPdtPmtHD',
    //             PK: 'FTPmhDocNo'
    //         },
    //         Join: {
    //             Table: ['TCNTPdtPmtHD_L', 'TCNTPdtPmtHDBch'],
    //             On: [
    //                 'TCNTPdtPmtHD_L.FTPmhDocNo = TCNTPdtPmtHD.FTPmhDocNo  AND TCNTPdtPmtHD_L.FNLngID = ' + nLangEdits,
    //                 'TCNTPdtPmtHDBch.FTBchCode = TCNTPdtPmtHD.FTBchCode  AND TCNTPdtPmtHDBch.FTPmhDocNo = TCNTPdtPmtHD.FTPmhDocNo '
    //             ]
    //         },
    //         Where: {
    //             Condition: [
    //                 function() {
    //                     var tSQL  = "";
    //                     tSQL += " AND TCNTPdtPmtHD.FTPmhStaApv = '1' AND TCNTPdtPmtHD.FTPmhStaClosed = '0' AND CONVERT(VARCHAR(10),TCNTPdtPmtHD.FDPmhDStop,121) >= CONVERT(VARCHAR(10),GETDATE(),121) AND CONVERT(VARCHAR, TCNTPdtPmtHD.FDPmhTStop, 24) >= CONVERT(VARCHAR, GETDATE(), 24) ";
    //                     tSQL += " AND ( ( ";
    //                     if( tAgnCode != "" ){
    //                         tSQL += " TCNTPdtPmtHDBch.FTPmhAgnTo IN ('"+tAgnCode+"') AND ";
    //                     }
    //                     tSQL += " TCNTPdtPmtHDBch.FTPmhBchTo IN ("+tBchCode+") AND TCNTPdtPmtHDBch.FTPmhStaType = '1') ";
    //                     tSQL += "  OR ( ";
    //                     if( tAgnCode != "" ){
    //                         tSQL += " TCNTPdtPmtHDBch.FTPmhAgnTo NOT IN ('"+tAgnCode+"') AND ";
    //                     }
    //                     tSQL += " TCNTPdtPmtHDBch.FTPmhBchTo NOT IN ("+tBchCode+") AND TCNTPdtPmtHDBch.FTPmhStaType = '2') ";
    //                     tSQL += "  OR (ISNULL(TCNTPdtPmtHDBch.FTPmhAgnTo,'') = '' AND ISNULL(TCNTPdtPmtHDBch.FTPmhBchTo,'') = ''  ) ";
    //                     tSQL += "  OR TCNTPdtPmtHD.FTBchCode IN("+tBchCode+") ) ";
    //                     return tSQL;
    //                 }
    //             ]
    //         },
    //         GrideView: {
    //             DistinctField: ['TCNTPdtPmtHD.FTPmhDocNo'],
    //             ColumnPathLang: 'document/promotion/promotion',
    //             ColumnKeyLang: ['tPnpLabelChannelCode', 'tPnpLabelChannelName'],
    //             ColumnsSize: ['15%', '85%'],
    //             DataColumns: ['TCNTPdtPmtHD.FTPmhDocNo', 'TCNTPdtPmtHD_L.FTPmhName'],
    //             DataColumnsFormat: ['', ''],
    //             WidthModal: 50,
    //             Perpage: 10,
    //             OrderBy: ['TCNTPdtPmtHD.FDCreateOn DESC']
    //             // SourceOrder: "ASC"
    //         },
    //         CallBack: {
    //             ReturnType: 'S',
    //             Value: ["oetPromotionStep4RcvCode", "TCNTPdtPmtHD.FTPmhDocNo"],
    //             Text: ["oetPromotionStep4RcvName", "TCNTPdtPmtHD_L.FTPmhName"]
    //         },
    //         NextFunc: {
    //             FuncName: 'JSxPromotionStep4CallbackPnp',
    //             ArgReturn: ['FTPmhDocNo', 'FTPmhName']
    //         },
    //         // RouteAddNew: 'customerlevel',
    //         // BrowseLev: 1,
    //         // DebugSQL : true
    //     };
    //     JCNxBrowseData('oPromotionBrowsePromotionOnPromotion');

    // }

</script>