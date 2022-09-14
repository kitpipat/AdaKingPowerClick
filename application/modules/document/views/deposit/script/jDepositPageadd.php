<script>
    $(document).ready(function() {

        JSxDepositGetCashInTmp();
        JSxDepositGetChequeInTmp();

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

        $('#ocbDepositAutoGenCode').unbind().bind('change', function() {
            var bIsChecked = $('#ocbDepositAutoGenCode').is(':checked');
            var oInputDocNo = $('#oetDepositDocNo');
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

        if(bIsAddPage){
            if (tUserLoginLevel == 'HQ') {
                $('#obtDepositBrowseShp').attr('disabled', true);
                // $('#obtDepositBrowseAccountTo').attr('disabled', true);
            }

            if (tUserLoginLevel == 'BCH' || tUserLoginLevel == 'HQ') {
                $('#obtDepositBrowseShp').attr('disabled', true);
                // $('#obtDepositBrowseAccountTo').attr('disabled', true);
            }

            if (tUserLoginLevel == 'SHP') {
                $('#obtDepositBrowseMer').attr('disabled', true);
                $('#obtDepositBrowseShp').attr('disabled', true);
            }
        }

        if (bIsApvOrCancel && !bIsAddPage) {
            $('#obtDepositApprove').hide();
            $('#obtDepositCancel').hide();
            $('#odvBtnAddEdit .btn-group').hide();
            $('form .xCNApvOrCanCelDisabled').attr('disabled', true);
        } else {
            $('#odvBtnAddEdit .btn-group').show();
        }

        /*===== Begin Control สาขาที่สร้าง ================================================*/
        if ((tUserLoginLevel == "HQ") || (!bIsAddPage) || (!bIsMultiBch)) {
            $("#obtDepositBrowseBch").attr('disabled', true);
        }
        /*===== End Control สาขาที่สร้าง ==================================================*/

        $(document).on('keyup keypress', 'form input[type="text"]', function(e) {
            if (e.which == 13) {
                e.preventDefault();
                return false;
            }
        });

        /*===== Begin Control ประเภทรายการฝาก ===========================================*/
        if(!$('#ocbDepositCashType').is(':checked')){
            $('.xCNDepositCashContainer').hide();
        }
        if(!$('#ocbDepositChequeType').is(':checked')){
            $('.xCNDepositChequeContainer').hide();
        }

        $('#ocbDepositCashType, #ocbDepositChequeType').on('change', function(event){
            let bIsCashTypeChecked = $('#ocbDepositCashType').is(':checked');
            let bIsChequeTypeChecked = $('#ocbDepositChequeType').is(':checked');

            if(event.target.name == "ocbDepositCashType"){
                if(bIsCashTypeChecked){
                    $('.xCNDepositCashContainer').show();
                }else{
                    $('.xCNDepositCashContainer').hide();
                    JSvDepositClearCashInTemp();
                }
            }

            if(event.target.name == "ocbDepositChequeType"){
                if(bIsChequeTypeChecked){
                    $('.xCNDepositChequeContainer').show();
                }else{
                    $('.xCNDepositChequeContainer').hide();
                    JSvDepositClearChequeInTemp();
                }
            }

            if(bIsCashTypeChecked || bIsChequeTypeChecked){
                $('.xCNDepositFootTotalContainer').show();
            }else{
                $('.xCNDepositFootTotalContainer').hide();
            }
        });
        /*===== End Control ประเภทรายการฝาก =============================================*/
    });

    /*===== Begin Event Browse =========================================================*/
    // สาขาที่สร้าง
    $("#obtDepositBrowseBch").click(function() {
        // option
        window.oDepositBrowseBch = {
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
                Condition: [" AND TCNMBranch.FTBchCode IN(<?php echo $this->session->userdata('tSesUsrBchCodeMulti'); ?>)"]
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
                Value: ["oetDepositBchCode", "TCNMBranch.FTBchCode"],
                Text: ["oetDepositBchName", "TCNMBranch_L.FTBchName"]
            },
            /* NextFunc: {
                FuncName: 'JSxDepositCallbackBch',
                ArgReturn: ['FTBchCode']
            }, */
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oDepositBrowseBch');
    });

    // เลือกกลุ่มธุรกิจ
    $("#obtDepositBrowseMer").click(function() {
        // option Ship Address
        window.oDepositBrowseMch = {
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
                Condition: ["AND (SELECT COUNT(FTShpCode) FROM TCNMShop WHERE TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTMerCode = TCNMMerchant.FTMerCode AND TCNMShop.FTBchCode = '" + $("#oetDepositBchCode").val() + "') != 0"]
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
                Value: ["oetDepositMchCode", "TCNMMerchant.FTMerCode"],
                Text: ["oetDepositMchName", "TCNMMerchant_L.FTMerName"],
            },
            NextFunc: {
                FuncName: 'JSxDepositCallbackMer',
                ArgReturn: ['FTMerCode', 'FTMerName']
            },
            BrowseLev: 1,
            //DebugSQL : true
        };
        JCNxBrowseData('oDepositBrowseMch');
    });

    // เลือกร้านค้า
    $("#obtDepositBrowseShp").click(function() {
        // Option Shop
        window.oDepositBrowseShp = {
            Title: ['company/shop/shop', 'tSHPTitle'],
            Table: {
                Master: 'TCNMShop',
                PK: 'FTShpCode'
            },
            Join: {
                Table: ['TCNMShop_L'],
                On: ['TCNMShop_L.FTShpCode = TCNMShop.FTShpCode AND TCNMShop.FTBchCode = TCNMShop_L.FTBchCode AND TCNMShop_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = "AND TCNMShop.FTShpStaActive = 1 AND TCNMShop.FTBchCode = '" + $("#oetDepositBchCode").val() + "' AND TCNMShop.FTMerCode = '" + $("#oetDepositMchCode").val() + "'";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBCHCode', 'tBCHName'],
                ColumnsSize: ['25%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMShop.FTShpCode', 'TCNMShop_L.FTShpName', 'TCNMShop.FTShpType', 'TCNMShop.FTBchCode'],
                DataColumnsFormat: ['', '', '', ''],
                DisabledColumns: [2, 3],
                Perpage: 10,
                OrderBy: ['TCNMShop_L.FTShpName'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetDepositShpCode", "TCNMShop.FTShpCode"],
                Text: ["oetDepositShpName", "TCNMShop_L.FTShpName"],
            },
            NextFunc: {
                FuncName: 'JSxDepositCallbackShp',
                ArgReturn: ['FTBchCode', 'FTShpCode', 'FTShpType']
            },
            BrowseLev: 1


        }
        JCNxBrowseData('oDepositBrowseShp');
    });

    // เลือกบัญชีที่นำเข้า
    $("#obtDepositBrowseAccountTo").click(function() {
        // option BookBank
        window.oDepositBrowseAccountTo = {
            Title: ['BookBank/BookBank/BookBank', 'tBBKTitle'],
            Table: {
                Master: 'TFNMBookBank',
                PK: 'FTBbkCode'
            },
            Join: {
                Table: ['TFNMBookBank_L' , 'TCNMBranch_L' , 'TFNMBank_L'],
                On: [
                    'TFNMBookBank.FTBbkCode = TFNMBookBank_L.FTBbkCode AND TFNMBookBank.FTBchCode = TFNMBookBank_L.FTBchCode AND TFNMBookBank_L.FNLngID = ' + nLangEdits ,
                    'TFNMBookBank.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits ,
                    'TFNMBookBank.FTBnkCode = TFNMBank_L.FTBnkCode AND TFNMBank_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = " AND TFNMBookBank.FTBchCode = '" + $("#oetDepositBchCode").val() + "' ";
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'BookBank/BookBank/BookBank',
                ColumnKeyLang: ['tBBKTableCode', 'tBBKTableNameBookbank'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TFNMBookBank.FTBbkCode', 'TFNMBookBank_L.FTBbkName', 'TFNMBookBank.FTBbkType', 'TFNMBookBank.FTBbkAccNo','TCNMBranch_L.FTBchName','TFNMBank_L.FTBnkName'],
                DataColumnsFormat: ['', '', '', ''],
                DisabledColumns: [2, 3,4,5],
                Perpage: 10,
                OrderBy: ['TFNMBookBank.FTBbkCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetDepositAccountCodeTo", "TFNMBookBank.FTBbkCode"],
                Text: ["oetDepositAccountNameTo", "TFNMBookBank_L.FTBbkName"],
            },
            NextFunc: {
                FuncName: 'JSxDepositCallbackAccountTo',
                ArgReturn: ['FTBbkCode', 'FTBbkName', 'FTBbkType', 'FTBbkAccNo','FTBchName','FTBnkName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oDepositBrowseAccountTo');
    });

    // เลือกผู้ใช้งานระบบ
    $("#obtDepositBrowseUsr").click(function() {
        // option User
        window.oDepositBrowseUsr = {
            Title: ['authen/user/user', 'tUSRTitle'],
            Table: {
                Master: 'TCNMUser',
                PK: 'FTUsrCode'
            },
            Join: {
                Table: ['TCNMUser_L', 'TCNTUsrGroup'],
                On: ['TCNMUser.FTUsrCode = TCNMUser_L.FTUsrCode AND TCNMUser_L.FNLngID = ' + nLangEdits, 'TCNTUsrGroup.FTUsrCode = TCNMUser.FTUsrCode']
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = " AND TCNTUsrGroup.FTBchCode = '" + $("#oetDepositBchCode").val() + "'"; // ไม่ใช่ HQ ค้นหาได้แค่สาขาตัวเอง

                        if (tUserLoginLevel == "HQ") { // HQ ค้นหาได้ทั้งหมด
                            var tSQL = "";
                        }else{
                            var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode"); ?>';
                            var tSQL = " AND TCNTUsrGroup.FTAgnCode = '" + tSesUsrAgnCode + "'";
                        }

                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'authen/user/user',
                ColumnKeyLang: ['tUSRCode', 'tUSRTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TCNMUser.FTUsrCode', 'TCNMUser_L.FTUsrName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMUser.FTUsrCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetDepositUsrCode", "TCNMUser.FTUsrCode"],
                Text: ["oetDepositUsrName", "TCNMUser_L.FTUsrName"],
            },
            /* NextFunc: {
                FuncName: 'JSxDepositCallbackUsr',
                ArgReturn: ['FTUsrCode', 'FTUsrName']
            }, */
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oDepositBrowseUsr');
    });

    // เลือกธนาคาร
    $("#obtDepositBrowseBank").click(function() {
        // option User
        window.oDepositBrowseBank = {
            Title: ['bank/bank/bank', 'tBNKTitle'],
            Table: {
                Master: 'TFNMBank',
                PK: 'FTBnkCode'
            },
            Join: {
                Table: ['TFNMBank_L'],
                On: ['TFNMBank.FTBnkCode = TFNMBank_L.FTBnkCode AND TFNMBank_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = " AND TFNMBank.FTBchCode = '" + $("#oetDepositBchCode").val() + "'"; // ไม่ใช่ HQ ค้นหาได้แค่สาขาตัวเอง

                        if (tUserLoginLevel == "HQ") { // HQ ค้นหาได้ทั้งหมด
                            tSQL = "";
                        }

                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'bank/bank/bank',
                ColumnKeyLang: ['tBNKTBCode', 'tBNKTBName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TFNMBank.FTBnkCode', 'TFNMBank_L.FTBnkName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMBank.FTBnkCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetDepositBankCode", "TFNMBank.FTBnkCode"],
                Text: ["oetDepositBankName", "TFNMBank_L.FTBnkName"],
            },
            /* NextFunc: {
                FuncName: 'JSxDepositCallbackBank',
                ArgReturn: ['FTBnkCode', 'FTBnkName']
            }, */
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oDepositBrowseBank');
    });

    // เลือกประเภทการนำฝาก
    $("#obtDepositBrowseDepositType").click(function() {
        // option User
        window.oDepositBrowseDepositType = {
            Title: ['bankdeptype/bankdeptype/bankdeptype', 'tBDTTitle'],
            Table: {
                Master: 'TFNMBnkDepType',
                PK: 'FTBdtCode'
            },
            Join: {
                Table: ['TFNMBnkDepType_L'],
                On: ['TFNMBnkDepType.FTBdtCode = TFNMBnkDepType_L.FTBdtCode AND TFNMBnkDepType_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [
                    function() {
                        if (tUserLoginLevel == "HQ") {
                            var tSQL = "";
                        }else{
                            var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode"); ?>';
                            var tSQL = " AND TFNMBnkDepType.FTAgnCode = '" + tSesUsrAgnCode + "'";
                        }
                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'bankdeptype/bankdeptype/bankdeptype',
                ColumnKeyLang: ['tBdtCode', 'tBdtName'],
                ColumnsSize: ['15%', '75%'],
                WidthModal: 50,
                DataColumns: ['TFNMBnkDepType.FTBdtCode', 'TFNMBnkDepType_L.FTBdtName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMBnkDepType.FTBdtCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetDepositTypeCode", "TFNMBnkDepType.FTBdtCode"],
                Text: ["oetDepositTypeName", "TFNMBnkDepType_L.FTBdtName"],
            },
            /* NextFunc: {
                FuncName: 'JSxDepositCallbackDepositType',
                ArgReturn: ['FTBdtCode', 'FTBdtName']
            }, */
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oDepositBrowseDepositType');
    });

    // เลือกสมุดเช็ค
    $("#obtDepositBrowseBookCheque").click(function() {
        // option User
        window.oDepositBrowseBookCheque = {
            Title: ['bookcheque/bookcheque/bookcheque', 'tBcqTitle'],
            Table: {
                Master: 'TFNMBookCheque',
                PK: 'FTChqCode'
            },
            Join: {
                Table: ['TFNMBookCheque_L', 'TFNMBank_L'],
                On: [
                    'TFNMBookCheque_L.FTChqCode = TFNMBookCheque.FTChqCode AND TFNMBookCheque_L.FNLngID = ' + nLangEdits,
                    'TFNMBank_L.FTBnkCode = TFNMBookCheque.FTBbkCode AND TFNMBank_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [
                    function() {
                        var tSQL = " AND TFNMBookCheque.FTBchCode = '" + $("#oetDepositBchCode").val() + "'"; // ไม่ใช่ HQ ค้นหาได้แค่สาขาตัวเอง

                        if (tUserLoginLevel == "HQ") { // HQ ค้นหาได้ทั้งหมด
                            tSQL = "";
                        }

                        return tSQL;
                    }
                ]
            },
            GrideView: {
                ColumnPathLang: 'bookcheque/bookcheque/bookcheque',
                ColumnKeyLang: ['tBcqtChqCode', 'tBcqtBBName'],
                ColumnsSize: ['15%', '75%'],
                DisabledColumns: [2],
                WidthModal: 50,
                DataColumns: ['TFNMBookCheque.FTChqCode', 'TFNMBookCheque_L.FTChqName', 'TFNMBank_L.FTBnkName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMBookCheque.FTChqCode'],
                SourceOrder: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetDepositChequeAddRefNoCode", "TFNMBookCheque.FTChqCode"],
                Text: ["oetDepositChequeAddRefNoName", "TFNMBookCheque_L.FTChqName"],
            },
            NextFunc: {
                FuncName: 'JSxDepositCallbackBookCheque',
                ArgReturn: ['FTChqCode', 'FTChqName', 'FTBnkName']
            },
            BrowseLev: 1,
            // DebugSQL : true
        }
        JCNxBrowseData('oDepositBrowseBookCheque');
    });
    /*===== End Event Browse ===========================================================*/

    /*===== Begin Callback Browse ======================================================*/
    // Browse Bch Callback
    function JSxDepositCallbackBch(params) {
        var tBchCode = $('#oetDepositBchCode').val();

        $('#oetDepositMchCode').val("");
        $('#oetDepositMchName').val("");

        $('#oetDepositShpCode').val("");
        $('#oetDepositShpName').val("");

        $('#oetDepositPosCode').val("");
        $('#oetDepositPosName').val("");

        $('#oetDepositWahCode').val("");
        $('#oetDepositWahName').val("");

        $('#obtDepositBrowseMer').attr('disabled', true);
        $('#obtDepositBrowseShp').attr('disabled', true);
        $('#obtDepositBrowseAccountTo').attr('disabled', true);
        $('#obtDepositBrowseWah').attr('disabled', true);

        if (tBchCode != "") {
            $('#obtDepositBrowseMer').attr('disabled', false);
        }
    }

    // Browse Mer Callback
    function JSxDepositCallbackMer(params) {
        var tBchCode = $('#oetDepositBchCode').val();
        var tMerCode = $('#oetDepositMchCode').val();

        $('#obtDepositBrowseMer').attr('disabled', true);
        $('#obtDepositBrowseShp').attr('disabled', true);
        $('#obtDepositBrowseAccountTo').attr('disabled', true);

        $('#oetDepositShpCode').val("");
        $('#oetDepositShpName').val("");

        $('#oetDepositAccountCodeTo').val("");
        $('#oetDepositAccountNameTo').val("");

        $('#oetDepositAccountType').val("");
        $('#oetDepositAccountID').val("");

        if (tBchCode != "" && tMerCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtDepositBrowseMer').attr('disabled', false);
                $('#obtDepositBrowseShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtDepositBrowseMer').attr('disabled', false);
                $('#obtDepositBrowseShp').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtDepositBrowseMer').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtDepositBrowseMer').attr('disabled', false);
            }
        }
    }

    // Browse Shop Callback
    function JSxDepositCallbackShp(params) {
        var tBchCode = $('#oetDepositBchCode').val();
        var tMerCode = $('#oetDepositMchCode').val();
        var tShpCode = $('#oetDepositShpCode').val();

        $('#obtDepositBrowseMer').attr('disabled', true);
        $('#obtDepositBrowseShp').attr('disabled', true);
        $('#obtDepositBrowseAccountTo').attr('disabled', true);

        $('#oetDepositAccountCodeTo').val("");
        $('#oetDepositAccountNameTo').val("");

        $('#oetDepositAccountType').val("");
        $('#oetDepositAccountID').val("");

        if (tBchCode != "" && tMerCode != "" && tShpCode != "") {
            if (tUserLoginLevel == "HQ") {
                $('#obtDepositBrowseMer').attr('disabled', false);
                $('#obtDepositBrowseShp').attr('disabled', false);
                $('#obtDepositBrowseAccountTo').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtDepositBrowseMer').attr('disabled', false);
                $('#obtDepositBrowseShp').attr('disabled', false);
                $('#obtDepositBrowseAccountTo').attr('disabled', false);
            }
        } else {
            if (tUserLoginLevel == "HQ") {
                $('#obtDepositBrowseMer').attr('disabled', false);
                $('#obtDepositBrowseShp').attr('disabled', false);
            }
            if (tUserLoginLevel == "BCH") {
                $('#obtDepositBrowseMer').attr('disabled', false);
                $('#obtDepositBrowseShp').attr('disabled', false);
            }
        }
    }

    // Browse BankAccount Callback
    function JSxDepositCallbackAccountTo(params) {
        try {

            // params : ['FTBbkCode', 'FTBbkName', 'FTBbkType', 'FTBbkAccNo']
            var tBbkCode = '';
            var tBbkName = '';
            var tBbkType = '';
            var tBbkAccNo = '';
            var tShowBCH = '';
            var tShowBank = '';

            if (params != "NULL") {
                oParams = JSON.parse(params);
                tBbkCode = oParams[0];
                tBbkName = oParams[1];
                tBbkType = oParams[2];
                tBbkAccNo = oParams[3];
                tShowBCH = oParams[4];
                tShowBank = oParams[5];
            }

            var tBbkTypeText = '';

            switch (tBbkType) {
                case "1": {
                    tBbkTypeText = '<?php echo language('document/deposit/deposit', 'tSaveUp'); ?>';
                    break;
                }
                case "2": {
                    tBbkTypeText = '<?php echo language('document/deposit/deposit', 'tCurrentAccount'); ?>';
                    break;
                }
                case "3": {
                    tBbkTypeText = '<?php echo language('document/deposit/deposit', 'tRegular'); ?>';
                    break;
                }
                default: {}
            }

            $('#oetDepositAccountType').val(tBbkTypeText);
            $('#oetDepositAccountID').val(tBbkAccNo);
            $('#oetDepositShowBCH').val(tShowBCH);
            $('#oetDepositShowBANK').val(tShowBank);

        } catch (err) {
            console.log('JSxDepositCallbackAccountTo Err: ', err);
        }

    }

    // Browse Book Cheque Callback
    function JSxDepositCallbackBookCheque(params){
        // params : ['FTChqCode', 'FTChqName', 'FTBnkName']
        try{
            var tBnkName = "";
            if(params != "NULL"){
                $oParams  = JSON.parse(params);
                tBnkName = $oParams[2];
            }
            $('#oetDepositChequeBank').val("");
            $('#oetDepositChequeBank').val(tBnkName);
        }catch(err){
            console.log('JSxDepositCallbackBookCheque Err: ', err);
        }
    }
    /*===== End Callback Browse ========================================================*/

    var bUniqueDepositCode;
    $.validator.addMethod(
        "uniqueDepositCode",
        function(tValue, oElement, aParams) {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {

                var tDepositCode = tValue;
                $.ajax({
                    type: "POST",
                    url: "depositUniqueValidate",
                    data: "tDepositCode=" + tDepositCode,
                    dataType: "JSON",
                    success: function(poResponse) {
                        bUniqueDepositCode = (poResponse.bStatus) ? false : true;
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log('Custom validate uniqueDepositCode: ', jqXHR, textStatus, errorThrown);
                    },
                    async: false
                });
                return bUniqueDepositCode;

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
    function JSxDepositValidateForm() {
        var oTopUpVendingForm = $('#ofmDepositForm').validate({
            focusInvalid: false,
            onclick: false,
            onfocusout: false,
            onkeyup: false,
            rules: {
                oetDepositDocNo: {
                    required: true,
                    maxlength: 20,
                    uniqueDepositCode: bIsAddPage
                },
                oetDepositDocDate: {
                    required: true
                },
                oetDepositDocTime: {
                    required: true
                },
                oetDepositMchName: {
                    required: true
                },
                oetDepositShpName: {
                    required: true
                },
                oetDepositAccountNameTo: {
                    required: true
                }
            },
            messages: {
                oetDepositDocNo: {
                    "required": $('#oetDepositDocNo').attr('data-validate-required')
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
                JSxDepositSave();
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
    function JSxDepositSave() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();
            var tMerCode = $('#oetDepositMchCode').val();
            var tShpCode = $('#oetDepositShpCode').val();
            var tPosCode = $('#oetDepositPosCode').val();
            var tWahCode = $('#oetDepositWahCode').val();

            // JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "<?php echo $tRoute; ?>",
                data: $("#ofmDepositForm").serialize(),
                cache: false,
                timeout: 5000,
                dataType: "JSON",
                success: function(oResult) {
                    switch (oResult.nStaCallBack) {
                        case "1": {
                            JSvDepositCallPageEdit(oResult.tCodeReturn);
                            break;
                        }
                        case "2": {
                            JSvDepositCallPageAdd();
                            break;
                        }
                        case "3": {
                            JSvDepositCallPageList();
                            break;
                        }
                        default: {
                            JSvDepositCallPageEdit(oResult.tCodeReturn);
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
     * Functionality : Approve Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvDepositApprove(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            try {
                if (pbIsConfirm) {
                    $("#ohdDepositStaApv").val(2); // Set status for processing approve
                    $("#odvDepositPopupApv").modal("hide");

                    var tDocNo = $("#oetDepositDocNo").val();
                    var tDocDate = $("#oetDepositDocDate").val();
                    var tBchCode = $("#oetDepositBchCode").val();
                    var tStaApv = $("#ohdDepositStaApv").val();

                    JCNxOpenLoading();

                    $.ajax({
                        type: "POST",
                        url: "depositDocApprove",
                        data: {
                            tDocNo: tDocNo,
                            tDocDate : tDocDate,
                            tBchCode : tBchCode,
                            tStaApv: tStaApv
                        },
                        cache: false,
                        timeout: 0,
                        success: function(oResult) {
                            try {
                                if (oResult.nStaEvent == "900") {
                                    FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    JCNxCloseLoading();
                                    return;
                                }else{
                                    JSvDepositCallPageEdit(tDocNo);
                                }
                            } catch (err) {}
                            JCNxCloseLoading();
                            // JSoDepositSubscribeMQ(); // เอกสารนี้ไม่ต้องรอข้อความตอบกลับ
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                            JCNxCloseLoading();
                        }
                    });
                } else {
                    // console.log("StaApvDoc Call Modal");
                    $("#odvDepositPopupApv").modal("show");
                }
            } catch (err) {
                console.log("JSvDepositApprove Error: ", err);
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
    function JSvDepositCancel(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tDocNo = $("#oetDepositDocNo").val();

            if (pbIsConfirm) {
                $.ajax({
                    type: "POST",
                    url: "depositDocCancel",
                    data: {
                        tDocNo: tDocNo
                    },
                    cache: false,
                    timeout: 5000,
                    success: function(tResult) {
                        $("#odvDepositPopupCancel").modal("hide");

                        var aResult = $.parseJSON(tResult);
                        if (aResult.nSta == 1) {
                            JSvDepositCallPageEdit(tDocNo);
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
                $("#odvDepositPopupCancel").modal("show");
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
    function JSoDepositSubscribeMQ() {
        // RabbitMQ
        /*===========================================================================*/
        // Document variable
        var tLangCode = $("#ohdLangEdit").val();
        var tUsrBchCode = $("#oetDepositBchCode").val();
        var tUsrApv = $("#oetDepositApvCodeUsrLogin").val();
        var tDocNo = $("#oetDepositDocNo").val();
        var tPrefix = "RESTFWVD";
        var tStaApv = $("#ohdDepositStaApv").val();
        var tStaDelMQ = $("#ohdDepositStaDelMQ").val();
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
            ptDocTableName: "TFNTBnkDplHD",
            ptDocFieldDocNo: "FTBdhDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: tStaDelMQ,
            ptDocNo: tDocNo
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: "JSvDepositCallPageEdit",
            tCallPageList: "JSvDepositCallPageList"
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


    /*===== Begin Cash Process =========================================================*/
    /**
     * Functionality : Get Cash in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositGetCashInTmp(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();
            var tMerCode = $('#oetDepositMchCode').val();
            var tShpCode = $('#oetDepositShpCode').val();
            var tPosCode = $('#oetDepositPosCode').val();
            var tWahCode = $('#oetDepositWahCode').val();

            var tSearchAll = $('#oetDepositPdtLayoutSearchAll').val();

            JCNxOpenLoading();

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "depositGetCashInTmp",
                data: {
                    tBchCode: tBchCode,
                    tMerCode: tMerCode,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tWahCode: tWahCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    JSxUpdateFootTatal(oResult.calInTmp);
                    $('#odvDepositCashDataTable').html(oResult.html);
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

    function JSvDepositInsertCashToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();
            var tCashDate = $('#oetDepositCashAddDate').val();
            var cCashValue = $('#oetDepositCashAddValue').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "depositInsertCashToTmp",
                data: {
                    tBchCode: tBchCode,
                    tCashDate: tCashDate,
                    cCashValue: cCashValue
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxDepositGetCashInTmp(1);
                    $('#odvDepositPopupCashAdd').modal('hide');
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

    function JSvDepositClearCashInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "depositClearCashInTmp",
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxDepositGetCashInTmp(1);
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
    /*===== End Cash Process ===========================================================*/

    /*===== Begin Cheque Process =======================================================*/
    /**
     * Functionality : Get Cheque in Temp
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxDepositGetChequeInTmp(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();
            var tMerCode = $('#oetDepositMchCode').val();
            var tShpCode = $('#oetDepositShpCode').val();
            var tPosCode = $('#oetDepositPosCode').val();
            var tWahCode = $('#oetDepositWahCode').val();

            var tSearchAll = $('#oetDepositPdtLayoutSearchAll').val();

            JCNxOpenLoading();

            (pnPage == '' || (typeof pnPage) == 'undefined') ? pnPage = 1: pnPage = pnPage;

            $.ajax({
                type: "POST",
                url: "depositGetChequeInTmp",
                data: {
                    tBchCode: tBchCode,
                    tMerCode: tMerCode,
                    tShpCode: tShpCode,
                    tPosCode: tPosCode,
                    tWahCode: tWahCode,
                    nPageCurrent: pnPage,
                    tSearchAll: tSearchAll
                },
                cache: false,
                timeout: 5000,
                success: function(oResult) {
                    JSxUpdateFootTatal(oResult.calInTmp);
                    $('#odvDepositChequeDataTable').html(oResult.html);
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

    function JSvDepositInsertChequeToTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var tBchCode = $('#oetDepositBchCode').val();
            var tChequeRefNo = $('#oetDepositChequeAddRefNoCode').val();
            var tBnkName = $('#oetDepositChequeBank').val();
            var cChequeValue = $('#oetDepositChequeAddValue').val();

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "depositInsertChequeToTmp",
                data: {
                    tBchCode: tBchCode,
                    tChequeRefNo: tChequeRefNo,
                    cChequeValue: cChequeValue,
                    tChequeBnkName: tBnkName
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxDepositGetChequeInTmp(1);
                    $('#odvDepositPopupChequeAdd').modal('hide');
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

    function JSvDepositClearChequeInTemp() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "depositClearChequeInTmp",
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    JSxDepositGetChequeInTmp(1);
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
    /*===== End Cheque Process =========================================================*/

    function JSxUpdateFootTatal(poParms){
        console.log('JSxUpdateFootTatal: ', poParms);
        $('.xCNDepositTotalText').text(poParms.FTBddRefAmtTotalText)
        $('.xCNDepositTotal').text(poParms.FCBddRefAmtTotal);
    }

    //พิมพ์
    function JSxDepositPrintDoc(){
        var aInfor = [
            {"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
            {"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
            {"BranchCode"   : '<?=FCNtGetAddressBranch($tBchCode); ?>' }, // สาขาที่ออกเอกสาร
            {"DocCode"      : $('#oetDepositDocNo').val()  }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tBchCode;?>'}
        ];
        window.open("<?=base_url()?>formreport/Frm_SQL_FCBnkDeposit?infor="+JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>
