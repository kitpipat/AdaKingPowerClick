<script type="text/javascript">
    $(document).ready(function() {

        $(".xCNavRow").removeClass("row").addClass("clearfix");

        $('.xCNSelectBox').selectpicker();

        $('body').on('focus', ".xCNDatePicker", function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(),
                orientation: "bottom"
            });
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#oimCardShiftChangeBrowseProvince').click(function() {
            // JCNxBrowseData('oPvnOption');
        });

        $('#oimCardShiftChangeReasonFile').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftChangeBrowseReasonFile');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftChangeFromCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftChangeBrowseFromCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#oimCardShiftChangeToCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftChangeBrowseToCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $("#oimCardShiftChangeFromCardNumber, #oimCardShiftChangeToCardNumber, #obtCardShiftChangeAddDataSource").on("click", function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.CardShiftChangeGetCardCodeTemp = JStCardShiftChangeGetCardCodeTemp();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftChangeFromCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftChangeBrowseFromCardNumberOption = oCardShiftChangeBrowseFromCardNumber(CardShiftChangeGetCardCodeTemp);
                JCNxBrowseData('oCardShiftChangeBrowseFromCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftChangeToCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftChangeBrowseToCardNumberOption = oCardShiftChangeBrowseToCardNumber(CardShiftChangeGetCardCodeTemp);
                JCNxBrowseData('oCardShiftChangeBrowseToCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtCardShiftChangeAddDataSource').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $('#testCode').val("");
                window.oCardShiftChangeBrowseAddDataSourceOption = oCardShiftChangeBrowseAddDataSource(CardShiftChangeGetCardCodeTemp);
                JCNxBrowseData('oCardShiftChangeBrowseAddDataSourceOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        if (JCNbCardShiftChangeIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftChangeCode").attr("readonly", true);
            $("#odvCardShiftChangeAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftChangeAutoGenCode', false);

            // $("#obtGenCodeCardShiftChange").attr("disabled", true);
            JSxCMNVisibleComponent('#obtCardShiftChangeBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftChangeBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftChangeBtnDocMa', true);
        }

        if (JCNbCardShiftChangeIsCreatePage()) {
            // Doc No
            $("#oetCardShiftChangeCode").attr("disabled", true);
            $('#ocbCardShiftChangeAutoGenCode').change(function() {
                if ($('#ocbCardShiftChangeAutoGenCode').is(':checked')) {
                    $("#oetCardShiftChangeCode").attr("disabled", true);
                    $('#odvCardShiftChangeDocNoForm').removeClass('has-error');
                    $('#odvCardShiftChangeDocNoForm em').remove();
                } else {
                    $("#oetCardShiftChangeCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftChangeAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftChangeBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftChangeBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftChangeBtnDocMa', false);

            JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftChangeIsUpdatePage()) {
            var tDocNo = $("#oetCardShiftChangeCode").val();
            <?php if (!empty($aCardCode)) : ?>
                <?php if ($aResult["raItems"]["rtCardShiftChangeStaDoc"] == "3") : // Cancel
                ?>
                    JSvCardShiftChangeDataSourceTable("", <?php echo json_encode($aCardCode); ?>, <?php echo json_encode($aNewCardCode); ?>, <?php echo json_encode($aReason); ?>, [], [], false, "", false, false, [], "2", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftChangeStaPrcDoc"] == "1") : // Approved
                    ?>
                        JSvCardShiftChangeDataSourceTable("", <?php echo json_encode($aCardCode); ?>, <?php echo json_encode($aNewCardCode); ?>, <?php echo json_encode($aReason); ?>, [], [], false, "", false, false, [], "1", tDocNo);
                    <?php else : // Pending
                    ?>
                        JSvCardShiftChangeDataSourceTable("", <?php echo json_encode($aCardCode); ?>, <?php echo json_encode($aNewCardCode); ?>, <?php echo json_encode($aReason); ?>, [], [], false, "1", false, false, [], "3", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftChangeApvCode").val();
        var tUsrCode = $("#ohdCardShiftChangeUsrCode").val();

        if ((JCNbCardShiftChangeIsUpdatePage() && JSbCardShiftChangeIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftChangeGetProgressAfterApvDoc();
        }

        JSxCardShiftChangeSetCardCodeTemp();
        JSxCardShiftChangeActionAfterApv();
    });

    // Set Lang Edit
    var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
    var tAgenCode = '<?php echo $this->session->userdata('tSesUsrAgnCode'); ?>';

    var tWhereCardTypeByAgenCode = "";
    var tWhereCardByAgenCode = "";
    if(tAgenCode != ''){
        tWhereCardTypeByAgenCode = " AND TFNMCardType.FTAgnCode = '" + tAgenCode + "'";
        tWhereCardByAgenCode = " AND TFNMCard.FTAgnCode = '" + tAgenCode + "'";
    }
    var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
    if (tStaUsrLevel=="HQ") {
      tConditionAgenCode = " AND TFNMCard.FTAgnCode ='' OR TFNMCard.FTAgnCode !='' ";
    }else {
      tConditionAgenCode = " AND TFNMCard.FTAgnCode ='<?php echo $this->session->userdata("tSesUsrAgnCode"); ?>'  AND TFNMCard.FTAgnCode !=''  ";
    }

    // Option Reference
    var oCardShiftChangeBrowseReasonFile = {
        Title: ['other/reason/reason', 'tRSNTitle'],
        Table: {
            Master: 'TCNMRsn',
            PK: 'FTRsnCode'
        },
        Join: {
            Table: ['TCNMRsn_L'],
            On: ['TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = ' + nLangEdits]
        },
        /*Where :{
            Condition : ["AND TCNMRsn.FTRsgCode = '007' "]
        },*/
        GrideView: {
            ColumnPathLang: 'other/reason/reason',
            ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMRsn.FDCreateOn'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftChangeReasonCodeFile", "TCNMRsn.FTRsnCode"],
            Text: ["oetCardShiftChangeReasonNameFile", "TCNMRsn_L.FTRsnName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTRsnCode']
        },*/
        // RouteFrom : 'cardShiftChange',
        RouteAddNew: 'reason',
        BrowseLev: oCardShiftChangeBrowseReason
    };

    var oCardShiftChangeBrowseReason = {
        Title: ['other/reason/reason', 'tRSNTitle'],
        Table: {
            Master: 'TCNMRsn',
            PK: 'FTRsnCode'
        },
        Join: {
            Table: ['TCNMRsn_L','TSysRsnGrp_L'],
            On: [
                'TCNMRsn_L.FTRsnCode = TCNMRsn.FTRsnCode AND TCNMRsn_L.FNLngID = ' + nLangEdits ,
                'TCNMRsn.FTRsgCode = TSysRsnGrp_L.FTRsgCode' ]
        },
        Where   : {
            Condition   : [' AND TSysRsnGrp_L.FTRsgCode = 014 ']
        },
        GrideView: {
            ColumnPathLang: 'other/reason/reason',
            ColumnKeyLang: ['tRSNTBCode', 'tRSNTBName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TCNMRsn.FTRsnCode', 'TCNMRsn_L.FTRsnName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMRsn.FDCreateOn'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftChangeReasonCode", "TCNMRsn.FTRsnCode"],
            Text: ["oetCardShiftChangeReasonName", "TCNMRsn_L.FTRsnName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTRsnCode']
        },*/
        // RouteFrom : 'cardShiftChange',
        RouteAddNew: 'reason',
        BrowseLev: oCardShiftChangeBrowseReason,
        /*DebugSQL : true*/
    };

    var oCardShiftChangeBrowseFromCardType = {
        Title: ['payment/cardtype/cardtype', 'tCTYTitle'],
        Table: {
            Master: 'TFNMCardType',
            PK: 'FTCtyCode'
        },
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            Condition : [tWhereCardTypeByAgenCode]
        },
        GrideView: {
            ColumnPathLang: 'payment/cardtype/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TFNMCardType.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftChangeFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftChangeFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        NextFunc: {
            FuncName: 'JSxCSTAddSetCodeTypeCard',
            ArgReturn: ['FTCtyName', 'FTCtyCode']
        },
        // RouteFrom : 'cardShiftChange',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftChangeBrowseType
    };

    function JSxCSTAddSetCodeTypeCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftChangeToCardTypeName').val(aData[0]);
            $('#oetCardShiftChangeToCardTypeCode').val(aData[1]);
        } else {
            $('#oetCardShiftChangeToCardTypeName').val('');
            $('#oetCardShiftChangeToCardTypeCode').val('');
        }
    }

    var oCardShiftChangeBrowseToCardType = {
        Title: ['payment/cardtype/cardtype', 'tCTYTitle'],
        Table: {
            Master: 'TFNMCardType',
            PK: 'FTCtyCode'
        },
        Join: {
            Table: ['TFNMCardType_L'],
            On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
        },
        Where: {
            Condition : [tWhereCardTypeByAgenCode]
        },
        GrideView: {
            ColumnPathLang: 'payment/cardtype/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TFNMCardType.FDCreateOn DESC']
            // SourceOrder		: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftChangeToCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftChangeToCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTCtyCode']
        },*/
        // RouteFrom : 'cardShiftChange',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftChangeBrowseType
    };

    var oCardShiftChangeBrowseFromCardNumber = function(ptNotCardCode) {

        var nFromCard = $('#oetCardShiftChangeFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftChangeToCardTypeCode').val();

        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCardType.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }

        var oOptions = {
            Title: ['payment/card/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode'
            },
            Join: {
                Table: ['TFNMCard_L', 'TFNMCardType'],
                On: [
                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                ]
            },
            Where: {
                Condition: ["AND (TFNMCard.FTCrdStaShift = '2') AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE()))" + tNotIn + tWhereInCard + tConditionAgenCode]
            },
            GrideView: {
                ColumnPathLang: 'payment/card/card',
                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCard.FDCreateOn DESC']
                // SourceOrder		: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftChangeFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftChangeFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeNumberCard',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftChange',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftChangeBrowseType,
        };
        return oOptions;
    };

    function JSxCSTAddSetCodeNumberCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftChangeToCardNumberCode').val(aData[0]);
            $('#oetCardShiftChangeToCardNumberName').val(aData[0]);
        } else {
            $('#oetCardShiftChangeToCardNumberCode').val('');
            $('#oetCardShiftChangeToCardNumberName').val('');
        }
    }

    var oCardShiftChangeBrowseToCardNumber = function(ptNotCardCode) {
        var nFromCard = $('#oetCardShiftChangeFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftChangeToCardTypeCode').val();

        var tWhereInCard = "";
        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCardType.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }

        var oOptions = {
            Title: ['payment/card/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode'
            },
            Join: {
                Table: ['TFNMCard_L', 'TFNMCardType'],
                On: [
                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                ]
            },
            Where: {
                Condition: ["AND ((TFNMCardType.FTCtyStaShift = '2') OR ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')) AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())))" + tNotIn + tWhereInCard + tWhereCardByAgenCode]
            },
            GrideView: {
                ColumnPathLang: 'payment/card/card',
                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCard.FDCreateOn DESC'],
                // SourceOrder		: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftChangeToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftChangeToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftChange',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftChangeBrowseType
        };
        return oOptions;
    };

    var oCardShiftChangeBrowseAddDataSource = function(ptNotCardCode) {
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND (TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + "))";
        }

        var oOptions = {
            Title: ['payment/card/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode',
                PKName: 'FTCrdName'
            },
            Join: {
                Table: ['TFNMCard_L', 'TFNMCardType'],
                On: [
                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                ]
            },
            Where: {
                Condition: [" AND ((TFNMCardType.FTCtyStaShift = '2') OR ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')) AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())))" + tNotIn + tWhereCardByAgenCode]
            },
            GrideView: {
                ColumnPathLang: 'payment/card/card',
                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName', 'TFNMCard.FTCrdHolderID','TFNMCardType.FTCtyStaPay'],
                DisabledColumns: [2],
                DataColumnsFormat: ['', '', ''],
                Perpage: 10,
                OrderBy: ['TFNMCard.FDCreateOn DESC']
                // SourceOrder		: "DESC"
            },
            CallBack: {
                StaDoc: '2',
                ReturnType: 'M',
                Value: ["testCode", "TFNMCard.FTCrdCode"],
                Text: ["testName", "TFNMCard_L.FTCrdName"]
            },
            NextFunc: {
                FuncName: 'JSxCardShiftChangeCallBackCardChange', // 'JSxCardShiftChangeSetDataSource',
                ArgReturn: ['FTCrdCode', 'FTCrdHolderID','FTCtyStaPay']
            },
            // RouteFrom : 'cardShiftChange',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftChangeBrowseType
        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/
    var bUniqueCardShiftChangeCode;
    $.validator.addMethod(
        "uniqueCardShiftChangeCode",
        function(tValue, oElement, aParams) {
            var tCardShiftChangeCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftChangeUniqueValidate/cardShiftChangeCode",
                data: "tCardShiftChangeCode=" + tCardShiftChangeCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftChangeCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardShiftChangeCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftChangeCode;
        },
        "Card Doc Code is Already Taken"
    );

    var bUniqueCardCode;
    $.validator.addMethod(
        "uniqueCardCode",
        function(tValue, oElement, aParams) {
            let tCardCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftChangeCardUniqueValidate/cardShiftChangeCardCode",
                data: "tCardShiftChangeCardCode=" + tCardCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardCode;
        },
        "Card Code is Already Taken"
    );

    var bUniqueCardCodeInDT;
    $.validator.addMethod(
        "uniqueCardCodeInDT",
        function(tValue, oElement, aParams) {
            let tCardCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftChangeCardUniqueValidate/cardShiftChangeCardCodeInDT",
                data: "tCardShiftChangeCardCode=" + tCardCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardCodeInDT = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardCodeInDT;
        },
        "Card Code is Already Taken DT"
    );

    var bUniqueCardCodePopUp;
    $.validator.addMethod(
        "uniqueCardCodePopUp",
        function(tValue, oElement, aParams) {
            var tNewCardCode = tValue;
            var aNewCardCode = JSaCardShiftChangeGetCardCodeInPopUp("newCardCode", false);
            var aNewCardCodeInTemp = JSaCardShiftChangeGetDataSourceCode("newCardCode", false);
            var aNewCardCodeMerge = $.merge(aNewCardCode, aNewCardCodeInTemp);

            console.log("Merge: ", aNewCardCodeMerge);
            console.log("Array1 Array: ", aNewCardCode);
            console.log("Array2 Array: ", aNewCardCodeInTemp);

            var nCount = 0;
            bUniqueCardCodePopUp = true;
            for (let nLoop = 0; nLoop < aNewCardCodeMerge.length; nLoop++) {
                if (aNewCardCodeMerge[nLoop] == tNewCardCode) {
                    nCount++;
                }
                if (nCount > 1) {
                    bUniqueCardCodePopUp = false;
                    break;
                }
            }
            return bUniqueCardCodePopUp;
        },
        "Card Code is Already Taken Temp"
    );

    var bExtensionValidate;
    $.validator.addMethod(
        "extensionValidate",
        function(tValue, oElement, tFileTypeFilter) {
            let tExtension = tValue.split('.').pop().toLowerCase();
            let aExtensions = tFileTypeFilter.split('|');

            if ($.inArray(tExtension, aExtensions) == -1) {
                console.log('Extension invalid');
                bExtensionValidate = false;
            } else {
                console.log('Extension valid');
                bExtensionValidate = true;
            }
            return bExtensionValidate;
        },
        "Extension is invalid"
    );

    var bFileSizeValidate;
    $.validator.addMethod(
        "fileSizeValidate",
        function(tValue, oElement, tFileSizeFilter) {
            let nSizeFilter = tFileSizeFilter * 100000; // convert to byte
            let nFileSize = oElement.files[0].size;
            if (nSizeFilter < nFileSize) {
                bFileSizeValidate = false;
            } else {
                bFileSizeValidate = true;
            }
            return bFileSizeValidate;
        },
        "File size is invalid"
    );

    // Override Error Message
    jQuery.extend(jQuery.validator.messages, {
        required: "This field is required.",
        remote: "Please fix this field.",
        email: "Please enter a valid email address.",
        url: "Please enter a valid URL.",
        date: "Please enter a valid date.",
        dateISO: "Please enter a valid date (ISO).",
        number: "Please enter a valid number.",
        digits: "Please enter only digits.",
        creditcard: "Please enter a valid credit card number.",
        equalTo: "Please enter the same value again.",
        accept: "Please enter a value with a valid extension.",
        maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
        minlength: jQuery.validator.format("Please enter at least {0} characters."),
        rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
        range: jQuery.validator.format("Please enter a value between {0} and {1}."),
        max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
        min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
    });

    /*============================= End Custom Form Validate =====================*/

    /**
     * Functionality : (event) Add/Edit CardShiftChange
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftChangeAddEditCardShiftChange(ptRoute) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired(); // Get Sesstion Expired
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) { // Sesstion Check

                if (JCNnCardShiftChangeCountDataSourceRow() == 0) { // Check Card Empty
                    FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                    return;
                }

                // From Validate
                $('#ofmAddCardShiftChangeMainForm').validate({
                    rules: {
                        oetCardShiftChangeCode: {
                            required: true,
                            uniqueCardShiftChangeCode: JCNbCardShiftChangeIsCreatePage(),
                            maxlength: 20
                        },
                        oetCardShiftChangeDocDate: {
                            required: true
                        }
                    },
                    messages: {
                        oetCardShiftChangeCode: {
                            required: "<?php echo language('document/card/cardchange', 'tValidCardShiftChange'); ?>",
                            uniqueCardShiftTopUpCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                            maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"

                        }
                    },
                    submitHandler: function(form) {
                        var aCardPack = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                try {
                                    var oResult = JSON.parse(tResult);
                                    if (oResult.nStaEvent == '1') {
                                        JSvCardShiftChangeCallPageCardShiftChangeEdit(oResult.tCodeReturn);
                                    } else {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    }
                                } catch (err) {}
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
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
                        $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
                    },
                    unhighlight: function(element, errorClass, validClass) {
                        $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                    }
                });

            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSnCardShiftChangeAddEditCardShiftChange Error: ", err);
        }
    }

    /**
     * Functionality : Set doc code in table to array
     * Parameters : ptGetMode is "oldCardCode", "newCardCode", "all", "cardPack", "oldCardValue", pbWrapText is true use '', false not use ''
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Doc code
     * Return Type : array
     */
    function JSaCardShiftChangeGetDataSourceCode(ptGetMode, pbWrapText) {
        try {
            ptGetMode = (typeof ptGetMode !== 'undefined') ? ptGetMode : "all";
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;

            // Set data
            let aAll = [];
            let aOldCardCode = [];
            let aNewCardCode = [];
            let aOldCardBal = [];
            let aCardPack = [];

            let oRecord = JSON.parse(($("#ospCardShiftChangeCardCodeTemp").text() == "") ? "[]" : $("#ospCardShiftChangeCardCodeTemp").text());
            // console.log("Data source: ", oRecord);
            $.each(oRecord.raItems, function(pnIndex, poElement) {
                // console.log("pnIndex: ", pnIndex);
                console.log("poElement: ", poElement.FTCvdOldCode);
                if (pbWrapText) {
                    aOldCardCode.push("'" + poElement.FTCvdOldCode + "'");
                    aNewCardCode.push("'" + poElement.FTCvdNewCode + "'");
                    aAll.push("'" + poElement.FTCvdOldCode + "'");
                    aAll.push("'" + poElement.FTCvdNewCode + "'");
                    aOldCardBal.push("'" + poElement.FCCvdOldBal + "'");

                    aCardPack.push({
                        "oldCardCode": "'" + poElement.FTCvdOldCode + "'",
                        "oldCardBal": "'" + poElement.FCCvdOldBal + "'",
                        "newCardCode": "'" + poElement.FTCvdNewCode + "'",
                        "reasonCode": "'" + $(poElement).find('.xWCardShiftChangeReasonCodeTemp').val() + "'",
                        "cardStatus": poElement.FTCvdNewCode,
                        "cardStatusRmk": poElement.FTCvdRmk
                    });
                } else {
                    aOldCardCode.push(poElement.FTCvdOldCode);
                    aNewCardCode.push(poElement.FTCvdNewCode);
                    aAll.push(poElement.FTCvdOldCode);
                    aAll.push(poElement.FTCvdNewCode);
                    aOldCardBal.push(poElement.FCCvdOldBal);

                    aCardPack.push({
                        "oldCardCode": poElement.FTCvdOldCode,
                        "oldCardBal": poElement.FCCvdOldBal,
                        "newCardCode": poElement.FTCvdNewCode,
                        "reasonCode": $(poElement).find('.xWCardShiftChangeReasonCodeTemp').val(),
                        "cardStatus": poElement.FTCvdNewCode,
                        "cardStatusRmk": poElement.FTCvdRmk
                    });
                }
            });

            if (ptGetMode == "oldCardCode") {
                return aOldCardCode;
            }
            if (ptGetMode == "oldCardValue") {
                return aOldCardBal;
            }
            if (ptGetMode == "newCardCode") {
                return aNewCardCode;
            }
            if (ptGetMode == "cardPack") {
                return aCardPack;
            }
            if (ptGetMode == "all") {
                return aAll;
            }
        } catch (err) {
            console.log("JSaCardShiftChangeGetDataSourceCode Error: ", err);
        }
    }

    /**
     * Functionality : Set card code temp
     * Parameters : -
     * Creator : 16/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeSetCardCodeTemp() {
        try {
            $("#ospCardShiftChangeCardCodeTemp").val("");
            setTimeout(function() {
                $("#ospCardShiftChangeCardCodeTemp").val(JSaCardShiftChangeGetDataSourceCode("oldCardCode", true).toString());
            }, 800);
        } catch (err) {
            console.log("JSxCardShiftChangeSetCardCodeTemp Error: ", err);
        }
    }

    /**
     * Functionality : Get card code temp
     * Parameters : -
     * Creator : 16/10/2018 piya
     * Last Modified : -
     * Return : Card code in table record
     * Return Type : string
     */
    function JStCardShiftChangeGetCardCodeTemp() {
        try {
            return $("#ospCardShiftChangeCardCodeTemp").val();
        } catch (err) {
            console.log("JStCardShiftChangeGetCardCodeTemp Error: ", err);
        }
    }

    /**
     * Functionality : Call back for browse multiple select
     * Parameters : ptCardCode
     * Creator : 15/11/2018 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftChangeCallBackCardChange(ptCard) {
        console.log("JSxCardShiftChangeCallBackCardChange", ptCard);
        JSxCardShiftChangeCallPopUpCardChange(ptCard, "select");
    }

    /**
     * Functionality : Call pop up table for card change
     * Parameters : ptCardCode, ptCallMode is "select", "filter"
     * Creator : 14/11/2018 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftChangeCallPopUpCardChange(ptCard, ptCallMode) {
        console.log("JSxCardShiftChangeCallPopUpCardChange: ", ptCard);
        try {
            var tTrBody = "";
            if (ptCallMode == "select") {
                // console.log("JSxCardShiftChangeCallPopUpCardChange: ", JSON.parse(ptCard));
                // console.log("JSxCardShiftChangeCallPopUpCardChange: ", ptCard.filter(Boolean));
                // var aCard
                if (ptCard.filter(Boolean).length < 1) { // No have card
                    JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", true, false, [], "1", "");
                    return;
                }

                /*=================================================================*/
                $.each(ptCard.filter(Boolean), function(nIndex, tValue) {
                    console.log(tValue)
                    let aCard = tValue;
                    // tCode = tCode.replace('["', "");
                    // tCode = tCode.replace('"]', "");
                    console.log("Select tCode: ", aCard);
                    tTrBody += JStCardShiftChangeSetTrBody(aCard, ++nIndex);
                });
                /*=================================================================*/
            }
            if (ptCallMode == "filter") {
                console.log("JSxCardShiftChangeCallPopUpCardChange: ", ptCard);
                if (ptCard.length < 1) {
                    JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", true, false, [], "1", "");
                    return;
                }

                /*=================================================================*/
                $.each(ptCard, function(nIndex, tValue) {
                    let aCard = tValue;
                    console.log("Filter tCode: ", aCard);
                    tTrBody += JStCardShiftChangeSetTrBody(aCard, ++nIndex);
                });
                /*=================================================================*/
            }

            let tTemplate = $("#oscCardShiftChangeModalTableTemplate").html();
            let tBody = {
                trBody: tTrBody,
                scriptTag: "script"
            };
            let tRender = JStCardShiftChangeRenderTemplate(tTemplate, tBody);

            $("#odvCardShiftChangePopUpCardChangeModal").empty();
            $("#odvCardShiftChangePopUpCardChangeModal").append(tRender);
            $(".xWCardShiftChangeBackDrop").removeClass("hidden").addClass("fade");
            $("#odvCardShiftChangePopupCardChange").modal({
                show: true,
                backdrop: false
            });

            $("#odvCardShiftChangePopupCardChange").on("hidden.bs.modal", function() {
                $(".xWCardShiftChangeBackDrop").addClass("hidden").removeClass("fade");
            });
        } catch (err) {
            console.log("JSxCardShiftChangeCallPopUpCardChange Error: ", err);
        }
    }

    /**
     * Functionality : Set <tr> body
     * Parameters : poOldCard
     * Creator : 13/11/2018 piya
     * Last Modified : -
     * Return : template
     * Return Type : string
     */
    function JStCardShiftChangeSetTrBody(paOldCard, pnIndex) {
        try {
            console.log("HOLLLL", paOldCard);
            let tTemplate = $("#oscCardShiftChangeTrBodyTemplate").html();
            let oData = {
                oldCardCode: paOldCard[0],
                oldCardHolderID: paOldCard[1],
                oldStaPay: paOldCard[2],
                index: pnIndex,
                scriptTag: "script"
            };
            console.log(oData);
            let tRender = JStCardShiftChangeRenderTemplate(tTemplate, oData);
            return tRender;
        } catch (err) {
            console.log("JStCardShiftChangeSetTrBody Error: ", err);
        }
    }

    /**
     * Functionality : Insert card to document temp
     * Parameters : aCardCode, aNewCardCode, tReasonCode
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeInsertDataToTemp(aCardCode, aNewCardCode, tReasonCode, aCardNewAndOld) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeInsertToTemp",
                    data: {
                        tCardNumber: JSON.stringify(aCardCode),
                        tNewCardNumber: JSON.stringify(aNewCardCode),
                        tCardNewAndOld: JSON.stringify(aCardNewAndOld),
                        tReasonCode: tReasonCode,
                        tDocNo: $('#oetCardShiftChangeCode').val(),
                        tBCHCode: $('#oetBCHCode_CardShiftChange').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftChangeInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : Update card on document temp
     * Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeUpdateDataOnTemp(ptCardCode, ptNewCardCode, ptReasonCode, pnSeq, pnPage, ptRmk) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeUpdateInlineOnTemp",
                    data: {
                        tCardNumber: ptCardCode,
                        tNewCardNumber: ptNewCardCode,
                        tReasonCode: ptReasonCode,
                        nSeq: pnSeq,
                        tRmk: ptRmk
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            JSvCardShiftChangeDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftChangeInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : (event) Add/Edit CardShiftChange
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftChangePopUpCardChangeValidate() {
        try {
            // console.log("TEST");
            $('#ofmAddCardShiftChangePopUpCardChangeForm').validate({
                rules: {
                    oetCardShiftChangeReasonName: {
                        required: true
                    }
                },
                messages: {
                    oetCardShiftChangeReasonName: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorReasonNotEmpty'); ?>",
                    }
                },
                submitHandler: function(form) {
                    console.log("Card change validate complete");
                    console.log("Old card code: ", JSaCardShiftChangeGetCardCodeInPopUp("oldCardCode", true));
                    console.log("New card code: ", JSaCardShiftChangeGetCardCodeInPopUp("newCardCode", true));
                    console.log("All card code: ", JSaCardShiftChangeGetCardCodeInPopUp("all", true));
                    $("#odvCardShiftChangePopupCardChange").modal("hide");
                    $("#odvCardShiftChangePopupCardChange").on("hidden.bs.modal", function() {
                        $(".xWCardShiftChangeBackDrop").addClass("hidden").removeClass("fade");
                    });

                    let aCardCode = JSaCardShiftChangeGetCardCodeInPopUp("oldCardCode", true);
                    let aNewCardCode = JSaCardShiftChangeGetCardCodeInPopUp("newCardCode", true);
                    let aReason = JSaCardShiftChangeGetCardCodeInPopUp("reason", false);
                    let aCardNewAndOld = JSaCardShiftChangeGetCardCodeInPopUp("all", true);
                    JSxCardShiftChangeInsertDataToTemp(aCardCode, aNewCardCode, aReason[0][0], aCardNewAndOld);
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
                    $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            });

            // New card in row validate
            $('.xWCardShiftChangeValidate').each(function() {
                $(this).rules("add", {
                    required: true,
                    // uniqueCardCode: true,
                    // uniqueCardCodeInDT: true,
                    // uniqueCardCodePopUp: true
                    messages: {
                        required: "รหัสบัตรใหม่ต้องไม่ว่าง"
                    }
                });
            });

        } catch (err) {
            console.log("JSnCardShiftChangeAddEditCardShiftChange Error: ", err);
        }
    }

    /**
     * Functionality : Set <tr> body
     * Parameters : ptGetMode is "oldCardCode", "newCardCode", "all", "reason"
     * Creator : 13/11/2018 piya
     * Last Modified : -
     * Return : template
     * Return Type : string
     */
    function JSaCardShiftChangeGetCardCodeInPopUp(ptGetMode, pbWrapText) {
        try {
            let aOldCardCode = [];
            let aNewCardCode = [];
            let aAll = [];
            let aReason = [];
            let oRecord = $("#otbCardShiftChangeList tr");

            $.each(oRecord, function(pnIndex, poElement) {
                if (pbWrapText) {
                    aOldCardCode.push("'" + $(poElement).find('.xWCardShiftChangeOldCardCode').text() + "'");
                    aNewCardCode.push("'" + $(poElement).find('.xWCardShiftChangeNewCardCode').val() + "'");
                    aAll.push({old: "'" + $(poElement).find('.xWCardShiftChangeOldCardCode').text() + "'", new: "'" + $(poElement).find('.xWCardShiftChangeNewCardCode').val() + "'"});
                    aReason.push(["'" + $('#oetCardShiftChangeReasonCode').val() + "'", "'" + $('#oetCardShiftChangeReasonName').val() + "'"]);
                } else {
                    aOldCardCode.push($(poElement).find('.xWCardShiftChangeOldCardCode').text());
                    aNewCardCode.push($(poElement).find('.xWCardShiftChangeNewCardCode').val());
                    aAll.push({old: $(poElement).find('.xWCardShiftChangeOldCardCode').text(), new: $(poElement).find('.xWCardShiftChangeNewCardCode').val()});
                    aReason.push([$('#oetCardShiftChangeReasonCode').val(), $('#oetCardShiftChangeReasonName').val()]);
                }
            });

            if (ptGetMode == "oldCardCode") {
                return aOldCardCode;
            }
            if (ptGetMode == "newCardCode") {
                return aNewCardCode;
            }
            if (ptGetMode == "all") {
                return aAll;
            }
            if (ptGetMode == "reason") {
                return aReason;
            }
        } catch (err) {
            console.log("JStCardShiftChangeSetTrBody Error: ", err);
        }
    }

    /**
     * Functionality : Replace value to template
     * Parameters : tTemplate, tData
     * Creator : 31/10/2018 piya
     * Last Modified : -
     * Return : view
     * Return Type : string
     */
    function JStCardShiftChangeRenderTemplate(tTemplate, tData) {
        try {
            String.prototype.fmt = function(hash) {
                let tString = this,
                    nKey;
                for (nKey in hash) {
                    tString = tString.replace(new RegExp('\\{' + nKey + '\\}', 'gm'), hash[nKey]);
                }
                return tString;
            };
            let tRender = "";
            tRender = tTemplate.fmt(tData);

            return tRender;
        } catch (err) {
            console.log("JStCardShiftChangeRenderTemplate Error: ", err);
        }
    }

    /**
     * Functionality : Set card with range filter
     * Parameters : {params}
     * Creator : 15/11/2018 piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftChangeSetDataSourceFilter() {
        try {
            if ($('input[name=orbCardShiftChangeSourceMode]:checked').val() == "range") {
                let tCardTypeCodeFrom = $('#oetCardShiftChangeFromCardTypeCode').val();
                let tCardTypeCodeTo = $('#oetCardShiftChangeToCardTypeCode').val();
                let tCardNumberCodeFrom = $('#oetCardShiftChangeFromCardNumberCode').val();
                let tCardNumberCodeTo = $('#oetCardShiftChangeToCardNumberCode').val();
                let aCardTypeCode = [];
                if (tCardTypeCodeFrom != "" && tCardTypeCodeTo != "") {
                    aCardTypeCode.push(tCardTypeCodeFrom);
                    aCardTypeCode.push(tCardTypeCodeTo);
                }

                let aCardNumberCode = [];
                if (tCardNumberCodeFrom != "" && tCardNumberCodeTo != "") {
                    aCardNumberCode.push(tCardNumberCodeFrom);
                    aCardNumberCode.push(tCardNumberCodeTo);
                }

                let aNotInCardCode = JStCardShiftChangeGetCardCodeTemp() == "" ? [] : JStCardShiftChangeGetCardCodeTemp().split(",");
                // Begin validate
                if ((aCardTypeCode.length == 0) && (aCardNumberCode.length == 0)) {
                    JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                    JSxCMNVisibleComponent("#odvCardShiftChangeAlert label.xWCheckCondition", true);
                } else {
                    JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                }
                // End validate

                if (!(aCardTypeCode.length == 0) && !(aCardNumberCode.length == 0)) {
                    JSaCardShiftChangeDataSourcePopUpTable(aCardTypeCode, aCardNumberCode, "1", "3", aNotInCardCode);
                    return;
                }
                if (!(aCardTypeCode.length == 0) || !(aCardNumberCode.length == 0)) {
                    if (!(aCardTypeCode.length == 0)) {
                        JSaCardShiftChangeDataSourcePopUpTable(aCardTypeCode, [], "1", "3", aNotInCardCode);
                        return;
                    }
                    if (!(aCardNumberCode.length == 0)) {
                        JSaCardShiftChangeDataSourcePopUpTable([], aCardNumberCode, "1", "3", aNotInCardCode);
                        return;
                    }
                }
            }

            if ($('input[name=orbCardShiftChangeSourceMode]:checked').val() == "file") {
                $("#obtSubmitCardShiftChangeSearchCardForm").trigger("click");
            }

            JSxCardShiftChangeSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftChangeSetDataSourceFilter Error: ", err);
        }
    }

    /**
     * Functionality : Call Recive Data Source List(Card)
     * @param {array} paCardTypeCodeRange,
     * @param {array} paCardCodeRange,
     * @param {string} ptStaShift,
     * @param {string} ptStaType
     * @return {array} card code
     * Creator : 15/11/2018 piya
     * Last Modified : -
     */
    function JSaCardShiftChangeDataSourcePopUpTable(paCardTypeCodeRange, paCardCodeRange, ptStaShift, ptStaType, paNotInCardNumber) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeDataSourceTable",
                    data: {
                        tCardTypeRange: JSON.stringify(paCardTypeCodeRange),
                        tCardNumberRange: JSON.stringify(paCardCodeRange),
                        tNotInCardNumber: JSON.stringify(paNotInCardNumber),
                        tStaShift: ptStaShift,
                        tStaType: ptStaType, // 1: Approve 2: Document status cancel
                        tIsGetCardCodeMode: "1"
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            var oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftChangeAlert label.xWNotFound", true);
                                return;
                            }
                            if (oResult["rtCode"] == "1") {
                                var aCardCode = oResult["raCard"];
                                JSxCardShiftChangeCallPopUpCardChange(aCardCode, "filter");
                            }
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSaCardShiftChangeDataSourcePopUpTable Error: ', err);
        }
    }

    /**
     * Functionality : Show or Hide Data Source Mode
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftChangeFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftChangeRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                JSxCMNVisibleComponent("#oahCardShiftChangeDataLoadMask", true);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftChangeFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftChangeRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                JSxCMNVisibleComponent("#oahCardShiftChangeDataLoadMask", false);
            }
            JSxCardShiftChangeSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftChangeVisibleDataSourceMode Error: ", err);
        }
    }

    /**
     * Functionality : Set after change file
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 09/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeSetImportFile(poElement, poEvent) {
        try {
            var oFile = $(poElement)[0].files[0];
            $("#oetCardShiftChangeFileTemp").val(oFile.name);
        } catch (err) {
            console.log("JSxCardShiftChangeSetImportFile Error: ", err);
        }
    }

    /**
     * Functionality : (event) Add/Edit CardShiftRefund
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeImportFileValidate() {
        console.log("Import file validate");
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oefCardShiftChangeImport: {
                        required: true,
                        extensionValidate: 'xls|xlsx',
                        fileSizeValidate: '100' // unit mb
                    },
                    oetCardShiftChangeReasonNameFile: {
                        required: true
                    }
                },
                messages: {
                    oefCardShiftChangeImport: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                        extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                        fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                    },
                    oetCardShiftChangeReasonNameFile: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorReasonNotEmpty'); ?>"
                    }
                },
                submitHandler: function(form) {
                    $('#odvCardShiftChangeModalImportFileConfirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#odvCardShiftChangeModalImportFileConfirm').modal('show');
                    $('#osmCardShiftChangeBtnImportFileConfirm').one('click', function(evt) {
                        $('#odvCardShiftChangeModalImportFileConfirm').modal('hide');
                        // let aNotInCardCode = JStCardShiftChangeGetCardCodeTemp() == "" ? [] : JStCardShiftChangeGetCardCodeTemp().split(",");
                        JSvCardShiftChangeDataSourceTableByFile("", false, "1", true, false, [], "3");
                    });
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
                    $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            });
        } catch (err) {
            console.log("JSxCardShiftChangeImportFileValidate Error: ", err);
        }
    }

    /**
     * Functionality : Display count number card
     * Parameters : ptCountNumber
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeSetCountNumber() {
        try {
            var tCountAll = $("#ohdCardShiftChangeCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftChangeCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            $("#oetCardShiftChangeCountNumber").val("");
            $("#oetCardShiftChangeCountNumber").val(tResult);
            $("#ospCardShiftChangeDataSourceCount").text("");
            $("#ospCardShiftChangeDataSourceCount").text(tResult);
        } catch (err) {
            console.log("JSxCardShiftChangeSetCountNumber Error: ", err);
        }
    }

    /**
     * Functionality : Call Recive Data Source List(Card)
     * @param {number} pnPage,
     * @param {array} paCardCode,
     * @param {array} paNewCardCode,
     * @param {string} paReason,
     * @param {array} paCardTypeCodeRange,
     * @param {array} paCardCodeRange,
     * @param {boolean} pbSetEmpty,
     * @param {string} ptStaShift,
     * @param {boolean} pbIsTemp,
     * @param {boolean} pbIsDataOnly,
     * @param {array} paNotInCardNumber,
     * @param {string} ptStaType,
     * @param {string} ptDocNo
     * @return {view} html
     * Creator : 08/10/2018 piya
     * Last Modified : -
     */
    function JSvCardShiftChangeDataSourceTable(pnPage, paCardCode, paNewCardCode, paReason, paCardTypeCodeRange, paCardCodeRange, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftChangeDataSearch').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeDataSourceTable",
                    data: {
                        tSearchAll: tSearchAll,
                        nPageCurrent: nPageCurrent,
                        tCardNumber: JSON.stringify(paCardCode),
                        tNewCardNumber: JSON.stringify(paNewCardCode),
                        tReason: JSON.stringify(paReason),
                        tCardTypeRange: JSON.stringify(paCardTypeCodeRange),
                        tCardNumberRange: JSON.stringify(paCardCodeRange),
                        tNotInCardNumber: JSON.stringify(paNotInCardNumber),
                        tSetEmpty: pbSetEmpty == true ? "1" : "0",
                        tStaShift: ptStaShift,
                        tOptionDocNo: ptDocNo,
                        tIsTemp: pbIsTemp == true ? "1" : "0",
                        tIsDataOnly: pbIsDataOnly == true ? "1" : "0",
                        tStaType: ptStaType, // 1: Approve 2: Document status cancel
                        tStaPrcDoc: $("#ohdCardShiftChangeCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftChangeCardStaDoc").val(),
                        tDocNo: $("#oetCardShiftChangeCode").val(),
                        tLastIndex: JCNnCardShiftChangeCountDataSourceRow()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            var oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftChangeAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }
                        } catch (err) {

                        }

                        if (tResult != "") {
                            $('#odvCardShiftChangeDataSource').html(tResult);
                            JSxCardShiftChangeSetHeightDataSourceTable();
                        }
                        JSxCardShiftChangeSetCountNumber();
                        JSxCardShiftChangeSetCardCodeTemp();
                        JSxCMNVisibleComponent("#odvCardShiftChangeAlert label", false);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftChangeDataSourceTable Error: ', err);
        }
    }

    /**
     * Functionality : Call Recive Data Source List(Card) by file
     * @param {number} pnPage,
     * @param {boolean} pbSetEmpty,
     * @param {string} ptStaShift,
     * @param {boolean} pbIsTemp,
     * @param {boolean} pbIsDataOnly,
     * @param {array} paNotInCardNumber,
     * @param {string} ptStaType
     * @return {view} html
     * Creator : 08/10/2018 piya
     * Last Modified : -
     */
    function JSvCardShiftChangeDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetSearchAll').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                var oFormData = new FormData();
                var oFile = $('#oefCardShiftChangeImport')[0].files[0];
                oFormData.append('oefCardShiftChangeImport', oFile);
                oFormData.append('aFile', oFile);
                var oReason = {
                    "reasonCode": $("#oetCardShiftChangeReasonCodeFile").val(),
                    "reasonName": $("#oetCardShiftChangeReasonNameFile").val()
                };
                oFormData.append('tSearchAll', tSearchAll);
                oFormData.append('nPageCurrent', nPageCurrent);
                oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
                oFormData.append('tStaShift', ptStaShift);
                oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
                oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
                oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
                oFormData.append('tStaPrcDoc', $("#ohdCardShiftChangeCardStaPrcDoc").val());
                oFormData.append('tStaDoc', $("#ohdCardShiftChangeCardStaDoc").val());
                oFormData.append('tLastIndex', JCNnCardShiftChangeCountDataSourceRow());
                oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
                oFormData.append('tStaDoc', $("#ohdCardShiftChangeCardStaDoc").val());
                oFormData.append('tReason', JSON.stringify(oReason));
                oFormData.append('tBchCode', $("#oetBCHCode_CardShiftChange").val());

                var tDocNo = $('#oetCardShiftChangeCode').val();
                if (tDocNo == '' || tDocNo == null) {
                    var tDocNo = '-';
                }
                oFormData.append('tDocNo', tDocNo);

                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeDataSourceTableByFile",
                    data: oFormData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            var aDataReturn = jQuery.parseJSON(tResult);
                            var tStaError = aDataReturn.tStaLog;

                            if (tStaError == 'E101') {
                                FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainExcelErrorFileNotMatch'); ?>');
                            } else if (tStaError == 'E102') {
                                FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainExcelErrorColunmHead'); ?>');
                            }

                            if (tStaError == 'Success') {
                                JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                            } else {
                                JCNxCloseLoading();
                            }
                        } catch (err) {
                            console.log('JSvCardShiftNewCardDataSourceTableByFile Error: ', err);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftChangeDataSourceTableByFile Error: ', err);
        }
    }

    /**
     * Functionality : Search data in table
     * Parameters : -
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeSearchDataSourceTable() {
        JSvCardShiftChangeDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeSetHeightDataSourceTable() {
        /*let nLeftContainerHeight = $(".xWLeftContainer").height();
        $("#odvCardShiftChangeDataSource .table-responsive").height(nLeftContainerHeight-181);*/
    }

    /**
     * Functionality : Count row in table
     * Parameters : -
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Row count
     * Return Type : number
     */
    function JCNnCardShiftChangeCountDataSourceRow() {
        try {
            return $("#ohdCardShiftChangeCountRowFromTemp").val();
        } catch (err) {
            console.log('JCNnCardShiftChangeCountDataSourceRow Error: ', err);
        }
    }

    /**
     * Functionality : Count row in table
     * Parameters : ptType is (pending, complete, cancel, n/a)
     * Creator : 18/10/2018 piya
     * Last Modified : -
     * Return : Check status
     * Return Type : boolean
     */
    function JCNbCardShiftChangeCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                let nRow = $('#otbCardShiftChangeDataSourceList > tr').not('.hidden').not('#otrCardShiftChangeNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            console.log('JCNbCardShiftChangeCheckTypeDataSourceRow Error: ', err);
        }
    }

    /**
     * Functionality : Action for approve
     * Parameters : pbIsConfirm
     * Creator : 17/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Empty record check
            if (JCNnCardShiftChangeCountDataSourceRow() == 0) {
                $("#odvCardShiftChangeModalEmptyCardAlert").modal("show");
                return;
            }
            if (pbIsConfirm) {
                $("#ohdCardShiftChangeCardStaPrcDoc").val(2); // Set status for processing approve
                $("#odvCardShiftChangePopupApv").modal('hide');
                JSxCMNVisibleComponent("#ospCardShiftChangeApvName", true);
                var aCard = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeEventUpdateApvDocAndCancelDoc",
                    data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCard),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        try {
                            var oResult = JSON.parse(tResult);
                            if (oResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                            }
                        } catch (e) {}
                        JSxCardShiftChangeGetProgressAfterApvDoc();
                        JSxCardShiftChangeActionAfterApv();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                console.log("StaApvDoc Call Modal");
                $("#odvCardShiftChangePopupApv").modal('show');
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Get Progress
     * Parameters :
     * Creator : 02/11/2020 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeGetProgressAfterApvDoc() {
        // Document variable
        var tLangCode = $("#ohdCardShiftChangeLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftChangeUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftChangeApvCode").val();
        var tUsrCode = $("#ohdCardShiftChangeUsrCode").val();
        var tDocNo = $("#oetCardShiftChangeCode").val();
        var tPrefix = 'RESSWAP';
        var tStaDelMQ = $("#ohdCardShiftChangeApvCode").val();
        var tStaApv = $("#ohdCardShiftChangeApvCode").val();
        var tQName = tPrefix + '_' + tDocNo + '_' + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tVhostType: 'W',
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
            // host: 'ws://<?php // echo MQ_CRD_HOST; ?>:15674/ws',
            host: '<?php echo MQ_CRD_HOST; ?>',
            port: '<?php echo MQ_CRD_PORT; ?>',
            username: '<?php echo MQ_CRD_USER; ?>',
            password: '<?php echo MQ_CRD_PASS; ?>',
            vHost: '<?php echo MQ_CRD_VHOST; ?>'
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: 'JSvCardShiftChangeCallPageCardShiftChangeEdit',
            tCallPageList: 'JSvCardShiftChangeCallPageCardShiftChange'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TFNTCrdVoidHD",
            ptDocFieldDocNo: "FTCvhDocNo",
            ptDocFieldStaApv: "FTCvhStaPrcDoc",
            ptDocFieldStaDelMQ: "FTCvhStaDelMQ",
            ptDocStaDelMQ: "1",
            ptDocNo: tDocNo
        };

        FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    }

    /**
     * Functionality : Action for document status
     * Parameters : pbIsConfirm
     * Creator : 17/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeStaDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            if (pbIsConfirm) {
                if ($("#ohdCardShiftChangeCardStaPrcDoc").val() == "") { // Pending approve status
                    $("#ohdCardShiftChangeCardStaDoc").val(3); // Set status for cancel document
                    $("#odvCardShiftChangePopupStaDoc").modal('hide');
                    var aCard = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftChangeEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCard),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            JSvCardShiftChangeCallPageCardShiftChangeEdit($("#oetCardShiftChangeCode").val());
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            } else {
                console.log("StaDoc Call Modal");
                $("#odvCardShiftChangePopupStaDoc").modal('show');
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Check Delete Qname Status
     * Parameters : ptStatus is status approve('' = not, 1 = removed)
     * Creator : 27/02/2019 piya
     * Last Modified : -
     * Return : Approve status
     * Return Type : boolean
     */
    function JSbCardShiftChangeIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftChangeStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftChangeIsStaDelQname Error: ", err);
        }
    }

    /**
     * Functionality : Check Approve Processing
     * Parameters : ptStatus is status approve('' = pending, 2 = processing, 1 = approved)
     * Creator : 27/02/2019 piya
     * Last Modified : -
     * Return : Approve status
     * Return Type : boolean
     */
    function JSbCardShiftChangeIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftChangeCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftChangeIsStaApv Error: ", err);
        }
    }

    /**
     * Functionality : Check Approve
     * Parameters : -
     * Creator : 19/10/2018 piya
     * Last Modified : -
     * Return : Approve status
     * Return Type : boolean
     */
    function JSbCardShiftChangeIsApv() {
        let bStatus = false;
        if (($("#ohdCardShiftChangeCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftChangeCardStaPrcDoc").val() == "2")) {
            bStatus = true;
        }
        return bStatus;
    }

    /**
     * Functionality : Check document status
     * Parameters : ptStaType is ("complete", "incomplete", "cancel")
     * Creator : 19/10/2018 piya
     * Last Modified : -
     * Return : Document status
     * Return Type : boolean
     */
    function JSbCardShiftChangeIsStaDoc(ptStaType) {
        let bStatus = false;
        if (ptStaType == "complete") {
            if ($("#ohdCardShiftChangeCardStaDoc").val() == "1") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "incomplete") {
            if ($("#ohdCardShiftChangeCardStaDoc").val() == "2") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "cancel") {
            if ($("#ohdCardShiftChangeCardStaDoc").val() == "3") {
                bStatus = true;
            }
            return bStatus;
        }
        return bStatus;
    }

    /**
     * Functionality : Action on document approved
     * Parameters : {params}
     * Creator : 18/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeActionAfterApv() {
        if (JCNbCardShiftChangeIsUpdatePage()) {
            if (JSbCardShiftChangeIsApv() || JSbCardShiftChangeIsStaDoc("cancel")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnCancelApv", false);
                $("#oetCardShiftChangeDocDate").attr("disabled", true);
                $(".xCNBtnDateTime").attr("disabled", true);
                if (JSbCardShiftChangeIsApv()) {
                    JSxCMNVisibleComponent("#ospCardShiftChangeApvName", true);
                }
                if (JSbCardShiftChangeIsStaDoc("cancel")) {
                    JSxCMNVisibleComponent("#ospCardShiftChangeApvName", false);
                }
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnSave", false);
            } else {
                console.log("Show Apv");
                $("#oetCardShiftChangeDocDate").attr("disabled", false);
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnApv", true);
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftChangeApvName", false);
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnSave", true);
            }

            if (!JSbCardShiftChangeIsApv() && JSbCardShiftChangeIsStaDoc("incomplete")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftChangeBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftChangeApvName", false);
            }
        }

        if (JCNbCardShiftChangeIsCreatePage()) {
            JSxCMNVisibleComponent("#obtCardShiftChangeBtnSave", true);
        }
    }

    /**
     * Functionality : Action to print document
     * Parameters : -
     * Creator : 13/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangePrint() {
        // let tLangCode = $("#ohdCardShiftChangeLangCode").val();
        // let tUsrBchCode = $("#ohdCardShiftChangeUsrBchCode").val();
        // let tDocNo = $("#oetCardShiftChangeCode").val();

        // let tUrl = "<?php echo base_url(); ?>doc_app/card_document/card_change/view/?SP_nLang=" + tLangCode + "&SP_tCmpBch=" + tUsrBchCode + "&SP_tDocNo=" + tDocNo + "&SP_tCompCode=C0001";
        // window.open(tUrl, "_blank");
        var tUsrBchCode = $("#ohdCardShiftChangeUsrBchCode").val();
        var tDocNo      = $("#oetCardShiftChangeCode").val();
        var aInfor = [
			{"Lang"         : '<?=FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?=FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tUserBchCode?>' } 
		];
        window.open("<?php echo base_url(); ?>formreport/Frm_SQL_FCCardChgCash?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>

<?php include 'jCardShiftChangeDataSourceTable.php'; ?>

<script>
    //เลือกสาขา วัฒน์ 17/08/2020
    $("#obtBrowseBCH_CardShiftChange").click(function() {
        var nLangEdits = <?php echo $this->session->userdata("tLangEdit"); ?>;
        var tUsrLevel = "<?= $this->session->userdata('tSesUsrLevel') ?>";
        var tBchMulti = "<?= $this->session->userdata("tSesUsrBchCodeMulti"); ?>";
        var tSQLWhere = "";
        if (tUsrLevel != "HQ") {
            tSQLWhere = " AND TCNMBranch.FTBchCode IN (" + tBchMulti + ") ";
        }

        window.oBrowse_Branch = {
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
                Value: ["oetBCHCode_CardShiftChange", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_CardShiftChange", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_CardShiftChange',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });

    function JSxSetConfigBCH_CardShiftChange(params) {
        if (params == 'NULL') {
            var tValue = '';
            $('#oetBCHName_CardShiftChange').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftChangeUsrBchCode').val(tValue);
    }
</script>
