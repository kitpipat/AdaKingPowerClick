<script type="text/javascript">
    $(document).ready(function() {

        // ให้ Disabled ไว้ก่อน  ถ้ามีการเลือก จากประเภทบัตรแล้ว กับ ถึงประเภทบัตร ค่อยเปิด
        //Create By witsarut 
        $("#oimCardShiftRefundFromCardNumber").attr("disabled", true); //จากหมายเลขบัตร
        $("#oimCardShiftRefundToCardNumber").attr("disabled", true); //ถึงหมายเลขบัตร


        $(".xCNavRow").removeClass("row").addClass("clearfix");

        $('body').on('focus', ".xCNDatePicker", function() {
            $(this).datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                // startDate: new Date(),
                orientation: "bottom"
            });
        });

        $('.xWTooltipsBT').tooltip({
            'placement': 'bottom'
        });
        $('[data-toggle="tooltip"]').tooltip({
            'placement': 'top'
        });

        $('#oimCardShiftRefundBrowseProvince').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oPvnOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        // $('#oimCardShiftRefundFromCardType').click(function() {
        //     var nStaSession = JCNxFuncChkSessionExpired();
        //     if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        //         JCNxBrowseData('oCardShiftRefundBrowseFromCardType');
        //     } else {
        //         JCNxShowMsgSessionExpired();
        //     }
        // });
        // $('#oimCardShiftRefundToCardType').click(function() {
        //     var nStaSession = JCNxFuncChkSessionExpired();
        //     if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        //         JCNxBrowseData('oCardShiftRefundBrowseToCardType');
        //     } else {
        //         JCNxShowMsgSessionExpired();
        //     }
        // });

        $("#oimCardShiftRefundFromCardNumber, #oimCardShiftRefundToCardNumber, #obtCardShiftRefundAddDataSource").on("click", function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.CardShiftRefundGetCardCodeTemp = JStCardShiftRefundGetCardCodeTemp();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#oimCardShiftRefundFromCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftRefundBrowseFromCardNumberOption = oCardShiftRefundBrowseFromCardNumber(CardShiftRefundGetCardCodeTemp);
                JCNxBrowseData('oCardShiftRefundBrowseFromCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftRefundToCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftRefundBrowseToCardNumberOption = oCardShiftRefundBrowseToCardNumber(CardShiftRefundGetCardCodeTemp);
                JCNxBrowseData('oCardShiftRefundBrowseToCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtCardShiftRefundAddDataSource').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftRefundBrowseAddDataSourceOption = oCardShiftRefundBrowseAddDataSource(CardShiftRefundGetCardCodeTemp);
                JCNxBrowseData('oCardShiftRefundBrowseAddDataSourceOption');
            } else {

            }
        });

        if (JCNbCardShiftRefundIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftRefundCode").attr("readonly", true);
            $("#odvCardShiftRefundAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftRefundAutoGenCode', false);

            // $("#obtGenCodeCardShiftRefund").attr("disabled", true);
            JSxCMNVisibleComponent('#obtCardShiftRefundBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftRefundBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftRefundBtnDocMa', true);
        }

        if (JCNbCardShiftRefundIsCreatePage()) {
            // Doc No
            $("#oetCardShiftRefundCode").attr("disabled", true);
            $('#ocbCardShiftRefundAutoGenCode').change(function() {
                if ($('#ocbCardShiftRefundAutoGenCode').is(':checked')) {
                    $("#oetCardShiftRefundCode").attr("disabled", true);
                    $('#odvCardShiftRefundDocNoForm').removeClass('has-error');
                    $('#odvCardShiftRefundDocNoForm em').remove();
                } else {
                    $("#oetCardShiftRefundCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftRefundAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftRefundBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftRefundBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftRefundBtnDocMa', false);

            JSvCardShiftRefundDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftRefundIsUpdatePage()) {
            var tDocNo = $("#oetCardShiftRefundCode").val();
            <?php if (!empty($aCardCode)) : ?>
                <?php if ($aResult["raItems"]["rtCardShiftRefundStaDoc"] == "3") : // Cancel 
                ?>
                    JSvCardShiftRefundDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "1", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftRefundStaPrcDoc"] == "1") : // Approved 
                    ?>
                        JSvCardShiftRefundDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "3", false, false, [], "1", tDocNo);
                    <?php else : // Pending 
                    ?>
                        JSvCardShiftRefundDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "1", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftRefundDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftRefundApvCode").val();
        var tUsrCode = $("#ohdCardShiftRefundUsrCode").val();

        if ((JCNbCardShiftRefundIsUpdatePage() && JSbCardShiftRefundIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftRefundGetProgressAfterApvDoc();
        }
        
        JSxCardShiftRefundSetCardCodeTemp();
        console.log("GetCardCodeTemp Init: ", JStCardShiftRefundGetCardCodeTemp());
        JSxCardShiftRefundActionAfterApv();
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

    $("#oimCardShiftRefundFromCardType").click(function() {
        let tCardType       = $('#oetCardShiftRefundCardType').val();
        let tWhereCondition = "";
        if( tCardType != "" ){
            tWhereCondition += " AND TFNMCardType.FTCtyStaPay = '"+tCardType+"' ";
        }

        window.oCardShiftRefundBrowseFromCardType = {
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
                Condition : [ tWhereCardTypeByAgenCode + " " + tWhereCondition ]
            },
            GrideView: {
                ColumnPathLang: 'payment/cardtype/cardtype',
                ColumnKeyLang: ['tCTYCode', 'tCTYName'],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName','TFNMCardType.FTCtyStaPay'],
                DisabledColumns: ['2'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCardType.FDCreateOn DESC']
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftRefundFromCardTypeCode", "TFNMCardType.FTCtyCode"],
                Text: ["oetCardShiftRefundFromCardTypeName", "TFNMCardType_L.FTCtyName"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeTypeCard',
                ArgReturn: ['FTCtyName', 'FTCtyCode','FTCtyStaPay']
            },
            RouteAddNew: 'cardtype',
            BrowseLev: nStaCardShiftRefundBrowseType
        };
        JCNxBrowseData('oCardShiftRefundBrowseFromCardType');
    });

    function JSxCSTAddSetCodeTypeCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            // console.log(aData);

            if( $('#oetCardShiftRefundToCardTypeCode').val() == "" ){
                $('#oetCardShiftRefundToCardTypeName').val(aData[0]);
                $('#oetCardShiftRefundToCardTypeCode').val(aData[1]);
            }

            if( $('#oetCardShiftRefundFromCardTypeCode').val() == "" ){
                $('#oetCardShiftRefundFromCardTypeName').val(aData[0]);
                $('#oetCardShiftRefundFromCardTypeCode').val(aData[1]);
            }

            // $('#oetCardShiftRefundToCardTypeName').val(aData[0]);
            // $('#oetCardShiftRefundToCardTypeCode').val(aData[1]);
            if( $('#oetCardShiftRefundCardType').val() == "" ){
                $('#oetCardShiftRefundCardType').val(aData[2]);
            }

            // if( $('#oetCardShiftRefundCardType').val() != aData[2] ){
            //     $('#oetCardShiftRefundCardType').val(aData[2]);
            // }


            $("#oimCardShiftRefundFromCardNumber").attr("disabled", false); //จากหมายเลขบัตร
            $("#oimCardShiftRefundToCardNumber").attr("disabled", false); //ถึงหมายเลขบัตร


        } else {

            let tRoute = $('#oetCardShiftRefundRoute').val();
            if( $('#oetCardShiftRefundToCardTypeCode').val() == "" && $('#oetCardShiftRefundFromCardTypeCode').val() == "" && tRoute == "cardShiftRefundEventAdd" ){
                $('#oetCardShiftRefundCardType').val('');
            }

            // $('#oetCardShiftRefundToCardTypeName').val('');
            // $('#oetCardShiftRefundToCardTypeCode').val('');
        }
    }

    $("#oimCardShiftRefundToCardType").click(function() {
        let tCardType       = $('#oetCardShiftRefundCardType').val();
        let tWhereCondition = "";
        if( tCardType != "" ){
            tWhereCondition += " AND TFNMCardType.FTCtyStaPay = '"+tCardType+"' ";
        }

        window.oCardShiftRefundBrowseToCardType = {
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
                Condition : [ tWhereCardTypeByAgenCode + " " + tWhereCondition ]
            },
            GrideView: {
                ColumnPathLang: 'payment/cardtype/cardtype',
                ColumnKeyLang: ['tCTYCode', 'tCTYName'],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName','TFNMCardType.FTCtyStaPay'],
                DisabledColumns: ['2'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCardType.FDCreateOn DESC']
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftRefundToCardTypeCode", "TFNMCardType.FTCtyCode"],
                Text: ["oetCardShiftRefundToCardTypeName", "TFNMCardType_L.FTCtyName"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeTypeCard',
                ArgReturn: ['FTCtyName', 'FTCtyCode','FTCtyStaPay']
            },
            RouteAddNew: 'cardtype',
            BrowseLev: nStaCardShiftRefundBrowseType
        };
        JCNxBrowseData('oCardShiftRefundBrowseToCardType');
    });

    // var oCardShiftRefundBrowseToCardType = {
    //     Title: ['payment/cardtype/cardtype', 'tCTYTitle'],
    //     Table: {
    //         Master: 'TFNMCardType',
    //         PK: 'FTCtyCode'
    //     },
    //     Join: {
    //         Table: ['TFNMCardType_L'],
    //         On: ['TFNMCardType_L.FTCtyCode = TFNMCardType.FTCtyCode AND TFNMCardType_L.FNLngID = ' + nLangEdits]
    //     },
    //     Where: {
    //         Condition : [tWhereCardTypeByAgenCode]
    //     },
    //     GrideView: {
    //         ColumnPathLang: 'payment/cardtype/cardtype',
    //         ColumnKeyLang: ['tCTYCode', 'tCTYName'],
    //         // ColumnsSize     : ['15%', '85%'],
    //         WidthModal: 50,
    //         DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
    //         DisabledColumns: [],
    //         DataColumnsFormat: ['', ''],
    //         Perpage: 10,
    //         OrderBy: ['TFNMCardType.FDCreateOn DESC']
    //         // ourceOrder		: "DESC"S
    //     },
    //     CallBack: {
    //         ReturnType: 'S',
    //         Value: ["oetCardShiftRefundToCardTypeCode", "TFNMCardType.FTCtyCode"],
    //         Text: ["oetCardShiftRefundToCardTypeName", "TFNMCardType_L.FTCtyName"]
    //     },
    //     /*NextFunc:{
    //         FuncName:'JSxCSTAddSetAreaCode',
    //         ArgReturn:['FTCtyCode']
    //     },*/
    //     // RouteFrom : 'cardShiftRefund',
    //     RouteAddNew: 'cardtype',
    //     BrowseLev: nStaCardShiftRefundBrowseType
    // };

    var oCardShiftRefundBrowseFromCardNumber = function(ptNotCardCode) {
        // console.log("Not Card Code: ", ptNotCardCode);
        var nFromCard = $('#oetCardShiftRefundFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftRefundToCardTypeCode').val();

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
                Condition: ["" +
                    " AND TFNMCard.FTCrdCode IN (SELECT CB.FTCrdCode FROM(SELECT CRD.FTCrdCode, SUM(CASE WHEN CRDB.FTCrdTxnCode='001' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) CashIn," +
                    " SUM(CASE WHEN CRDB.FTCrdTxnCode='002' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Promotion , SUM(CASE WHEN CRDB.FTCrdTxnCode='003' THEN ISNULL(CRDB.FCCrdValue,0)" +
                    " ELSE 0 END) DepositCrd , SUM(CASE WHEN CRDB.FTCrdTxnCode='004' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) DepositPdt , SUM(CASE WHEN CRDB.FTCrdTxnCode='005' THEN ISNULL(CRDB.FCCrdValue,0)" +
                    " ELSE 0 END) NotReturn , SUM(CASE WHEN CRDB.FTCrdTxnCode='006' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Payment FROM TFNMCard CRD WITH (NOLOCK)" +
                    " LEFT JOIN TFNMCardBal CRDB WITH (NOLOCK) ON CRDB.FTCrdCode = CRD.FtCrdCode GROUP BY CRD.FTCrdCode ) CB)" +
                    " AND TFNMCard.FTCrdStaActive = '1' AND (TFNMCard.FTCrdStaShift = '2') AND CONVERT(VARCHAR,TFNMCard.FDCrdExpireDate, 111) >= CONVERT(VARCHAR,GETDATE(), 111)" + tNotIn + tWhereInCard + tWhereCardByAgenCode
                ]
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
                Value: ["oetCardShiftRefundFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftRefundFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeNumberCard',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftRefund',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftRefundBrowseType,
            // DebugSQL : true,
        };
        return oOptions;
    };

    function JSxCSTAddSetCodeNumberCard(poData) {

        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftRefundToCardNumberCode').val(aData[0]);
            $('#oetCardShiftRefundToCardNumberName').val(aData[0]);
        } else {
            $('#oetCardShiftRefundToCardNumberCode').val('');
            $('#oetCardShiftRefundToCardNumberName').val('');
        }

    }

    var oCardShiftRefundBrowseToCardNumber = function(ptNotCardCode) {
        // console.log("Not Card Code: ", ptNotCardCode);
        var nFromCard = $('#oetCardShiftRefundFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftRefundToCardTypeCode').val();

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
                Condition: ["" +
                    " AND TFNMCard.FTCrdCode IN (SELECT CB.FTCrdCode FROM(SELECT CRD.FTCrdCode, SUM(CASE WHEN CRDB.FTCrdTxnCode='001' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) CashIn," +
                    " SUM(CASE WHEN CRDB.FTCrdTxnCode='002' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Promotion , SUM(CASE WHEN CRDB.FTCrdTxnCode='003' THEN ISNULL(CRDB.FCCrdValue,0)" +
                    " ELSE 0 END) DepositCrd , SUM(CASE WHEN CRDB.FTCrdTxnCode='004' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) DepositPdt , SUM(CASE WHEN CRDB.FTCrdTxnCode='005' THEN ISNULL(CRDB.FCCrdValue,0)" +
                    " ELSE 0 END) NotReturn , SUM(CASE WHEN CRDB.FTCrdTxnCode='006' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Payment FROM TFNMCard CRD WITH (NOLOCK)" +
                    " LEFT JOIN TFNMCardBal CRDB WITH (NOLOCK) ON CRDB.FTCrdCode = CRD.FtCrdCode GROUP BY CRD.FTCrdCode ) CB)" +
                    " AND TFNMCard.FTCrdStaActive = '1' AND (TFNMCard.FTCrdStaShift = '2') AND CONVERT(VARCHAR,TFNMCard.FDCrdExpireDate, 111) >= CONVERT(VARCHAR,GETDATE(), 111)" + tNotIn + tWhereInCard + tWhereCardByAgenCode
                ]
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
                Value: ["oetCardShiftRefundToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftRefundToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftRefund',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftRefundBrowseType
        };
        return oOptions;
    };

    var oCardShiftRefundBrowseAddDataSource = function(ptNotCardCode) {
        console.log("Not Card Code: ", ptNotCardCode);

        var nFromCard = $('#oetCardShiftRefundFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftRefundToCardTypeCode').val();

        var tWhereInCard = "";
        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCardType.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }

        let tCardType       = $('#oetCardShiftRefundCardType').val();
        let tWhereCondition = "";
        if( tCardType != "" ){
            tWhereCondition += " AND TFNMCardType.FTCtyStaPay = '"+tCardType+"' ";
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
                Condition: ["" +
                    tWhereCondition + 
                    " AND TFNMCard.FTCrdCode IN (SELECT CB.FTCrdCode FROM(SELECT CRD.FTCrdCode, SUM(CASE WHEN CRDB.FTCrdTxnCode='001' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) CashIn," +
                    " SUM(CASE WHEN CRDB.FTCrdTxnCode='002' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Promotion , SUM(CASE WHEN CRDB.FTCrdTxnCode='003' THEN ISNULL(CRDB.FCCrdValue,0)" +
                    " ELSE 0 END) DepositCrd , SUM(CASE WHEN CRDB.FTCrdTxnCode='004' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) DepositPdt , SUM(CASE WHEN CRDB.FTCrdTxnCode='005' THEN ISNULL(CRDB.FCCrdValue,0)" +
                    " ELSE 0 END) NotReturn , SUM(CASE WHEN CRDB.FTCrdTxnCode='006' THEN ISNULL(CRDB.FCCrdValue,0) ELSE 0 END) Payment FROM TFNMCard CRD WITH (NOLOCK)" +
                    " LEFT JOIN TFNMCardBal CRDB WITH (NOLOCK) ON CRDB.FTCrdCode = CRD.FtCrdCode GROUP BY CRD.FTCrdCode ) CB )" +
                    " AND TFNMCard.FTCrdStaActive = '1' AND (TFNMCard.FTCrdStaShift = '2') AND CONVERT(VARCHAR,TFNMCard.FDCrdExpireDate, 111) >= CONVERT(VARCHAR,GETDATE(), 111)" + tNotIn + tWhereInCard + tWhereCardByAgenCode
                ]
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
                StaDoc: 2,
                ReturnType: 'M',
                Value: ["testCode", "TFNMCard.FTCrdCode"],
                Text: ["testName", "TFNMCard_L.FTCrdName"]
            },
            NextFunc: {
                FuncName: 'JSxCardShiftRefundSetDataSource',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftRefund',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftRefundBrowseType,
            // DebugSQL: true,
        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/

    var bUniqueCardShiftRefundCode;
    $.validator.addMethod(
        "uniqueCardShiftRefundCode",
        function(tValue, oElement, aParams) {
            let tCardShiftRefundCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftRefundUniqueValidate/cardShiftRefundCode",
                data: "tCardShiftRefundCode=" + tCardShiftRefundCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftRefundCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardShiftRefundCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftRefundCode;
        },
        "Card Doc Code is Already Taken"
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
     * Functionality : (event) Add/Edit CardShiftRefund
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftRefundAddEditCardShiftRefund(ptRoute) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                if (JCNnCardShiftRefundCountDataSourceRow() == 0) { // Check Card Empty
                    FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                    return;
                }

                // From Validate
                $('#ofmAddCardShiftRefundMainForm').validate({
                    rules: {
                        oetCardShiftRefundCode: {
                            required: true,
                            uniqueCardShiftRefundCode: JCNbCardShiftRefundIsCreatePage(),
                            maxlength: 20
                        },
                        oetCardShiftRefundDocDate: {
                            required: true
                        },
                        oetCardShiftRefundCardValue: {
                            required: true,
                            digits: true
                        }
                    },
                    messages: {
                        oetCardShiftRefundCode: {
                            required: "<?php echo language('document/card/cardrefund', 'tValidCardShifRefund'); ?>",
                            uniqueCardShiftRefundCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                            maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"

                        }
                        // oetCardShiftRefundName: ""
                    },
                    submitHandler: function(form) {
                        var aCardCode = JSaCardShiftRefundGetDataSourceCode(false);
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: $('#ofmAddCardShiftRefundMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                try {
                                    var oResult = JSON.parse(tResult);
                                    if (oResult.nStaEvent == '1') {
                                        JSvCardShiftRefundCallPageCardShiftRefundEdit(oResult.tCodeReturn);
                                    } else {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    }
                                } catch (err) {}
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
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
            console.log("JSnCardShiftRefundAddEditCardShiftRefund Error: ", err);
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
    function JSnCardShiftRefundCardValueValidate() {
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oetCardShiftRefundCardValue: {
                        required: true,
                        digits: true
                    }
                },
                messages: {
                    // oetCardShiftRefundCode: "",
                    // oetCardShiftRefundName: ""
                },
                submitHandler: function(form) {},
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
            console.log("JSnCardShiftRefundCardValueValidate Error: ", err);
        }
    }

    /**
     * Functionality : Set doc code in table to array
     * Parameters : pbWrapText is true use '', false not use ''
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Doc code
     * Return Type : array
     */
    function JSaCardShiftRefundGetDataSourceCode(pbWrapText) {
        try {
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;
            // Set data
            var aData = [];
            var oRecord = JSON.parse(($("#ospCardShiftRefundCardCodeTemp").text() == "") ? "[]" : $("#ospCardShiftRefundCardCodeTemp").text());
            $.each(oRecord.raItems, function(pnIndex, poElement) {
                if (pbWrapText) {
                    aData.push("'" + poElement.FTCrdCode + "'");
                } else {
                    aData.push(poElement.FTCrdCode);
                }
            });
            return aData;
        } catch (err) {
            console.log("JSaCardShiftRefundGetDataSourceCode Error: ", err);
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
    function JSxCardShiftRefundSetCardCodeTemp() {
        try {
            $("#ohdCardShiftRefundCardCodeTemp").val("");
            setTimeout(function() {
                $("#ohdCardShiftRefundCardCodeTemp").val(JSaCardShiftRefundGetDataSourceCode(true).toString());
            }, 800);
        } catch (err) {
            console.log("JSxCardShiftRefundSetCardCodeTemp Error: ", err);
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
    function JStCardShiftRefundGetCardCodeTemp() {
        try {
            return $("#ohdCardShiftRefundCardCodeTemp").val();
        } catch (err) {
            console.log("JStCardShiftRefundGetCardCodeTemp Error: ", err);
        }
    }

    /**
     * Functionality : Call back for browse multiple select
     * Parameters : ptCardCode
     * Creator : 07/01/2019 Krit(Copter)
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftRefundCallBackCardRefund(ptCard) {
        JSxCardShiftRefundCallPopUpCardRefund(ptCard, "select");
    }

    /**
     * Functionality : Call pop up table for card Refund
     * Parameters : ptCardCode, ptCallMode is "select", "filter"
     * Creator : 14/11/2018 Krit(Copter)
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftRefundCallPopUpCardRefund(ptCard, ptCallMode) {
        try {
            var tTrBody = "";
            if (ptCallMode == "select") {
                if (ptCard.filter(Boolean).length < 1) { // No have card
                    JSvCardShiftRefundDataSourceTable("", [], [], [], [], [], true, "1", true, false, [], "1", "");
                    return;
                }

                /*=================================================================*/
                $.each(ptCard.filter(Boolean), function(nIndex, tValue) {
                    let aCard = JSON.parse(tValue);
                    // tCode = tCode.replace('["', "");
                    // tCode = tCode.replace('"]', "");
                    console.log("Select tCode: ", aCard);
                    tTrBody += JStCardShiftRefundSetTrBody(aCard, ++nIndex);
                });
                /*=================================================================*/
            }
            if (ptCallMode == "filter") {
                if (ptCard.length < 1) {
                    JSvCardShiftRefundDataSourceTable("", [], [], [], [], [], true, "1", true, false, [], "1", "");
                    return;
                }

                /*=================================================================*/
                $.each(ptCard, function(nIndex, tValue) {
                    var aCard = tValue;
                    tTrBody += JStCardShiftRefundSetTrBody(aCard, ++nIndex);
                });
                /*=================================================================*/
            }
            var tTemplate = $("#oscCardShiftRefundModalTableTemplate").html();
            var tBody = {
                trBody: tTrBody,
                scriptTag: "script"
            };
            var tRender = JStCardShiftRefundRenderTemplate(tTemplate, tBody);
            $("#odvCardShiftRefundPopUpCardRefundModal").empty();
            $("#odvCardShiftRefundPopUpCardRefundModal").append(tRender);
            $(".xWCardShiftRefundBackDrop").removeClass("hidden").addClass("fade");
            $("#odvCardShiftRefundPopupCardRefund").modal({
                show: true,
                backdrop: false
            });

            $("#odvCardShiftRefundPopupCardRefund").on("hidden.bs.modal", function() {
                $(".xWCardShiftRefundBackDrop").addClass("hidden").removeClass("fade");
            });
        } catch (err) {
            console.log("JSxCardShiftRefundCallPopUpCardRefund Error: ", err);
        }
    }

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftRefundSetDataSource(ptCardCode) {
        console.log(ptCardCode)
        $('#testName').val('');
        $('#testCode').val('');
        try {
            if (ptCardCode.filter(Boolean).length < 1) {
                JSvCardShiftRefundDataSourceTable("", [], [], [], true, "1", true, false, [], "1", "");
                return;
            }
            var aCardCode = [];
            $.each(ptCardCode.filter(Boolean), function(nIndex, tValue) {
                var tCode = "'"+tValue+"'";
                // tCode = tCode.replace('["', "'");
                // tCode = tCode.replace('"]', "'");
                aCardCode[nIndex] = tCode;
            });
            JSxCardShiftRefundInsertDataToTemp(aCardCode);
        } catch (err) {
            console.log("JSxCardShiftRefundSetDataSource Error: ", err);
        }
    }

    // Insert Choose
    function JSxCardShiftRefundInsertDataToTemp(aCardCode) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundInsertToTemp",
                    data: {
                        tBCHCode: $('#oetBCHCode_cardshiftrefund').val(),
                        tInsertType: 'choose',
                        tCard: JSON.stringify(aCardCode),
                        tValue: 15,
                        tDocNo: $('#oetCardShiftRefundCode').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JSvCardShiftRefundDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftRefundInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftRefundSetDataSourceFilter() {
        try {
            //console.log("Set Data Source");
            if ($('input[name=orbCardShiftRefundSourceMode]:checked').val() == "range") {
                // console.log('Range type');
                let tCardTypeCodeFrom = $('#oetCardShiftRefundFromCardTypeCode').val();
                let tCardTypeCodeTo = $('#oetCardShiftRefundToCardTypeCode').val();
                let tCardNumberCodeFrom = $('#oetCardShiftRefundFromCardNumberCode').val();
                let tCardNumberCodeTo = $('#oetCardShiftRefundToCardNumberCode').val();
                // console.log("Empty: ", tCardTypeCodeFrom);
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
                // console.log("JStCardShiftRefundGetCardCodeTemp(): ", JStCardShiftRefundGetCardCodeTemp());

                let aNotInCardCode = JStCardShiftRefundGetCardCodeTemp() == "" ? [] : JStCardShiftRefundGetCardCodeTemp().split(",");

                // Begin validate
                if ((aCardTypeCode.length == 0) && (aCardNumberCode.length == 0)) {
                    JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                    JSxCMNVisibleComponent("#odvCardShiftRefundAlert label.xWCheckCondition", true);
                } else {
                    JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                }
                // End validate

                if (!(aCardTypeCode.length == 0) && !(aCardNumberCode.length == 0)) {
                    JSxCardShiftRefundInsertDataToTempBetween(aCardNumberCode, aCardTypeCode, [], "between");
                    // JSaCardShiftRefundDataSourcePopUpTable(aCardTypeCode, aCardNumberCode, "1", "3", aNotInCardCode);
                    return;
                }
                if (!(aCardTypeCode.length == 0) || !(aCardNumberCode.length == 0)) {
                    if (!(aCardTypeCode.length == 0)) {
                        JSxCardShiftRefundInsertDataToTempBetween([], aCardTypeCode, [], "between");
                        // JSaCardShiftRefundDataSourcePopUpTable(aCardTypeCode, [], "1", "1", aNotInCardCode);
                        return;
                    }
                    if (!(aCardNumberCode.length == 0)) {
                        JSxCardShiftRefundInsertDataToTempBetween(aCardNumberCode, [], [], "between");
                        // JSaCardShiftRefundDataSourcePopUpTable([], aCardNumberCode, "1", "1", aNotInCardCode);
                        return;
                    }
                }
            }
            if ($('input[name=orbCardShiftRefundSourceMode]:checked').val() == "file") {
                console.log('File type');
                $("#obtSubmitCardShiftRefundSearchCardForm").trigger("click");
            }
            JSxCardShiftRefundSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftRefundSetDataSourceFilter Error: ", err);
        }
    }

    // Insert Between
    function JSxCardShiftRefundInsertDataToTempBetween(paRangeCardCode, paRangeCardType, paCardCode, ptInsertType) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundInsertToTemp",
                    data: {
                        tBCHCode: $('#oetBCHCode_cardshiftrefund').val(),
                        tInsertType: 'between',
                        tRangeCardCode: JSON.stringify(paRangeCardCode),
                        tRangeCardType: JSON.stringify(paRangeCardType),
                        tCardCode: JSON.stringify(paCardCode),
                        tValue: $('#oetCardShiftRefundCardValue').val(),
                        tDocNo: $('#oetCardShiftRefundCode').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JSvCardShiftRefundDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftRefundInsertDataToTemp Error: ", err);
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
    function JSaCardShiftRefundDataSourcePopUpTable(paCardTypeCodeRange, paCardCodeRange, ptStaShift, ptStaType, paNotInCardNumber) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundDataSourceTable",
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
                        console.log("Success: ", tResult);
                        try {
                            console.log("typeof: ", JSON.parse(tResult));
                            let oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftRefundAlert label.xWNotFound", true);
                                return;
                            }
                            if (oResult["rtCode"] == "1") {
                                let aCardCode = oResult["raCard"];
                                console.log("A Card Code: ", aCardCode);
                                JSxCardShiftRefundCallPopUpCardRefund(aCardCode, "filter");
                            }
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSaCardShiftRefundDataSourcePopUpTable Error: ', err);
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
    function JSxCardShiftRefundVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftRefundFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftRefundRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                JSxCMNVisibleComponent("#oahCardShiftRefundDataLoadMask", true);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftRefundFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftRefundRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                JSxCMNVisibleComponent("#oahCardShiftRefundDataLoadMask", false);
            }
            JSxCardShiftRefundSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftRefundVisibleDataSourceMode Error: ", err);
        }
    }

    /**
     * Functionality : Set after Refund file
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 09/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundSetImportFile(poElement, poEvent) {
        try {
            //console.log('Import run');
            var oFile = $(poElement)[0].files[0];
            $("#oetCardShiftRefundFileTemp").val(oFile.name);
        } catch (err) {
            console.log("JSxCardShiftRefundSetImportFile Error: ", err);
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
    function JSxCardShiftRefundSetCountNumber() {
        try {
            var nRows = JCNnCardShiftRefundCountDataSourceRow();
            $("#oetCardShiftRefundCountNumber").val("");
            $("#oetCardShiftRefundCountNumber").val(nRows);
            $("#ospCardShiftRefundDataSourceCount").text("");
            $("#ospCardShiftRefundDataSourceCount").text(nRows);
        } catch (err) {
            console.log("JSxCardShiftRefundSetCountNumber Error: ", err);
        }
    }

    /**
     * Functionality : (event) Add/Edit CardShiftRefund
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 06/11/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundImportFileValidate() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $('#ofmSearchCard').validate({
                    rules: {
                        oefCardShiftRefundImport: {
                            required: true,
                            extensionValidate: 'xls|xlsx',
                            fileSizeValidate: '100' // unit mb
                        }
                    },
                    messages: {
                        oefCardShiftRefundImport: {
                            required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                            extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                            fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                        }
                    },
                    submitHandler: function(form) {
                        $('#odvCardShiftRefundModalImportFileConfirm').modal({
                            backdrop: 'static',
                            keyboard: false
                        });
                        $('#odvCardShiftRefundModalImportFileConfirm').modal('show');
                        $('#osmCardShiftRefundBtnImportFileConfirm').one('click', function(evt) {
                            $('#odvCardShiftRefundModalImportFileConfirm').modal('hide');
                            // let aNotInCardCode = JStCardShiftOutGetCardCodeTemp() == "" ? [] : JStCardShiftOutGetCardCodeTemp().split(",");
                            JSvCardShiftRefundDataSourceTableByFile("", false, "3", true, false, [], "3");
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
            console.log("JSxCardShiftRefundImportFileValidate Error: ", err);
        }
    }

    /**
     * Functionality : Call Recive Data Source List(Card)
     * @param {number} pnPage, 
     * @param {array} paCardCode, 
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
    function JSvCardShiftRefundDataSourceTable(pnPage, paCardCode, paCardTypeCodeRange, paCardCodeRange, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftRefundDataSearch').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundDataSourceTable",
                    data: {
                        tSearchAll: tSearchAll,
                        nPageCurrent: nPageCurrent,
                        tCardNumber: JSON.stringify(paCardCode),
                        tCardTypeRange: JSON.stringify(paCardTypeCodeRange),
                        tCardNumberRange: JSON.stringify(paCardCodeRange),
                        tNotInCardNumber: JSON.stringify(paNotInCardNumber),
                        tSetEmpty: pbSetEmpty == true ? "1" : "0",
                        tStaShift: ptStaShift,
                        tOptionDocNo: ptDocNo,
                        tIsTemp: pbIsTemp == true ? "1" : "0",
                        tIsDataOnly: pbIsDataOnly == true ? "1" : "0",
                        tStaType: ptStaType, // 1: Approve 2: Document status cancel
                        tStaPrcDoc: $("#ohdCardShiftRefundCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftRefundCardStaDoc").val(),
                        tDocNo: $("#oetCardShiftRefundCode").val(),
                        tLastIndex: JCNnCardShiftRefundCountDataSourceRow(["pending", "n/a", "notfound", "fail"])
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JCNxCloseLoading();
                        try {
                            console.log("typeof: ", JSON.parse(tResult));
                            let oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftRefundAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }
                        } catch (err) {

                        }

                        if (tResult != "") {
                            $('#odvCardShiftRefundDataSource').html(tResult);
                            JSxCardShiftRefundSetHeightDataSourceTable();
                        }

                        JSxCardShiftRefundSetCountNumber();
                        JSxCardShiftRefundSetCardCodeTemp();
                        // JSxCardShiftRefundSetTotalVat(100); // Display vat total
                        JSxCMNVisibleComponent("#odvCardShiftRefundAlert label", false);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftRefundDataSourceTable Error: ', err);
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
    function JSvCardShiftRefundDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
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
                var oFile = $('#oefCardShiftRefundImport')[0].files[0];
                oFormData.append('oefCardShiftRefundImport', oFile);
                oFormData.append('tSearchAll', tSearchAll);
                oFormData.append('nPageCurrent', nPageCurrent);
                oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
                oFormData.append('tStaShift', ptStaShift);
                oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
                oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
                oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
                oFormData.append('tStaPrcDoc', $("#ohdCardShiftRefundCardStaPrcDoc").val());
                oFormData.append('tStaDoc', $("#ohdCardShiftRefundCardStaDoc").val());
                oFormData.append('tLastIndex', JCNnCardShiftRefundCountDataSourceRow(["complete", "pending", "n/a"]));
                oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
                oFormData.append('aFile', oFile);
                oFormData.append('tBchCode', $("#oetBCHCode_cardshiftrefund").val());

                var tDocNo = $('#oetCardShiftRefundCode').val();
                if (tDocNo == '' || tDocNo == null) {
                    var tDocNo = '-';
                }
                oFormData.append('tDocNo', tDocNo);
                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundDataSourceTableByFile",
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
                                JSvCardShiftRefundDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                            } else {
                                JCNxCloseLoading();
                            }
                        } catch (err) {
                            console.log('JSvCardShiftRefundDataSourceTableByFile Error: ', err);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftRefundDataSourceTableByFile Error: ', err);
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
    function JSxCardShiftRefundSearchDataSourceTable() {
        JSvCardShiftRefundDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundSetHeightDataSourceTable() {
        /*try{
            let nLeftContainerHeight = $(".xWLeftContainer").height();
            $("#odvCardShiftRefundDataSource .table-responsive").height(nLeftContainerHeight-147);
        }catch(err){
            console.log("JSxCardShiftRefundSetHeightDataSourceTable Error: ", err);
        }*/
    }

    /**
     * Functionality : Delete Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    /*function JSxCardShiftRefundDataSourceDeleteOperator(poElement, poEvent){
        try{
            if(JSbCardShiftRefundIsApv() || JSbCardShiftRefundIsStaDoc("cancel")){return;}
            if(confirm('Delete. ?')){
                $(poElement) // Delete Itseft Record.
                    .parents('.otrCardShiftRefundDataSource')
                    .addClass('hidden');
                JSxCardShiftRefundSetCountNumber();  
                JSxCardShiftRefundSetCardCodeTemp();
                JSxCardShiftRefundSetTotalVat(100);
            }
        }catch(err){
            console.log('JSxCardShiftRefundDataSourceDeleteOperator Error: ', err);
        }
    }*/

    /**
     * Functionality : Count row in table
     * Parameters : -
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Row count
     * Return Type : number
     */
    function JCNnCardShiftRefundCountDataSourceRow() {
        try {
            var tCountAll = $("#ohdCardShiftRefundCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            return tResult;
        } catch (err) {
            console.log('JCNnCardShiftRefundCountDataSourceRow Error: ', err);
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
    function JCNbCardShiftRefundCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                let nRow = $('#otbCardShifOutDataSourceList > tr').not('.hidden').not('#otrCardShifOutNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            console.log('JCNbCardShiftRefundCheckTypeDataSourceRow Error: ', err);
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
    function JSxCardShiftRefundStaApvDoc(pbIsConfirm) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                // Empty record check
                if ($("#ohdCardShiftRefundCountRowFromTemp").val() == 0) {
                    $("#odvCardShiftRefundModalEmptyCardAlert").modal("show");
                    return;
                }

                if (pbIsConfirm) {
                    $("#ohdCardShiftRefundCardStaPrcDoc").val(2); // Set status for processing approve
                    $("#odvCardShiftRefundPopupApv").modal('hide');
                    JSxCMNVisibleComponent("#ospCardShiftRefundApvName", true);
                    var aCardCode = JSaCardShiftRefundGetDataSourceCode(false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftRefundEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftRefundMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            try {
                                let oResult = JSON.parse(tResult);
                                if (oResult.nStaEvent == "900") {
                                    FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                }
                            } catch (e) {}
                            JSxCardShiftRefundGetProgressAfterApvDoc();
                            JSxCardShiftRefundActionAfterApv();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    console.log("StaApvDoc Call Modal");
                    $("#odvCardShiftRefundPopupApv").modal('show');
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftRefundStaApvDoc Error: ", err);
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
    function JSxCardShiftRefundGetProgressAfterApvDoc(){
        // Document variable
        var tLangCode = $("#ohdCardShiftRefundLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftRefundUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftRefundApvCode").val();
        var tUsrCode = $("#ohdCardShiftRefundUsrCode").val();
        var tDocNo = $("#oetCardShiftRefundCode").val();
        var tPrefix = 'RESCHKOUT';
        var tStaDelMQ = $("#ohdCardShiftRefundApvCode").val();
        var tStaApv = $("#ohdCardShiftRefundApvCode").val();
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
            tCallPageEdit: 'JSvCardShiftRefundCallPageCardShiftRefundEdit',
            tCallPageList: 'JSvCardShiftRefundCallPageCardShiftRefund'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TFNTCrdTopUpHD",
            ptDocFieldDocNo: "FTXshDocNo",
            ptDocFieldStaApv: "FTXshStaPrcDoc",
            ptDocFieldStaDelMQ: "FTXshStaDelMQ",
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
    function JSxCardShiftRefundStaDoc(pbIsConfirm) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                if (pbIsConfirm) {
                    if ($("#ohdCardShiftRefundCardStaPrcDoc").val() == "") { // Pending approve status
                        $("#ohdCardShiftRefundCardStaDoc").val(3); // Set status for cancel document
                        $("#odvCardShiftRefundPopupStaDoc").modal('hide');
                        var aCardCode = JSaCardShiftRefundGetDataSourceCode(false);
                        $.ajax({
                            type: "POST",
                            url: "cardShiftRefundEventUpdateApvDocAndCancelDoc",
                            data: $('#ofmAddCardShiftRefundMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                console.log("StaDoc: ", tResult);
                                JSvCardShiftRefundCallPageCardShiftRefundEdit($("#oetCardShiftRefundCode").val());
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
                    }
                } else {
                    console.log("StaDoc Call Modal");
                    $("#odvCardShiftRefundPopupStaDoc").modal('show');
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftRefundStaDoc Error: ", err);
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
    function JSbCardShiftRefundIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftRefundStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftRefundIsStaDelQname Error: ", err);
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
    function JSbCardShiftRefundIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftRefundCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftRefundIsStaApv Error: ", err);
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
    function JSbCardShiftRefundIsApv() {
        var bStatus = false;
        if (($("#ohdCardShiftRefundCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftRefundCardStaPrcDoc").val() == "2")) {
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
    function JSbCardShiftRefundIsStaDoc(ptStaType) {

        var bStatus = false;
        if (ptStaType == "complete") {
            if ($("#ohdCardShiftRefundCardStaDoc").val() == "1") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "incomplete") {
            if ($("#ohdCardShiftRefundCardStaDoc").val() == "2") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "cancel") {
            if ($("#ohdCardShiftRefundCardStaDoc").val() == "3") {
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
    function JSxCardShiftRefundActionAfterApv() {
        try {
            if (JCNbCardShiftRefundIsUpdatePage()) {
                if (JSbCardShiftRefundIsApv() || JSbCardShiftRefundIsStaDoc("cancel")) {
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnApv", false);
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnCancelApv", false);
                    $("#oetCardShiftRefundDocDate").attr("disabled", true);
                    $("#oetCardShiftRefundCardValue").attr("disabled", true);
                    $(".xCNBtnDateTime").attr("disabled", true);
                    if (JSbCardShiftRefundIsApv()) {
                        JSxCMNVisibleComponent("#ospCardShiftRefundApvName", true);
                    }
                    if (JSbCardShiftRefundIsStaDoc("cancel")) {
                        JSxCMNVisibleComponent("#ospCardShiftRefundApvName", false);
                    }
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnSave", false);
                } else {
                    $("#oetCardShiftRefundDocDate").attr("disabled", false);
                    $("#oetCardShiftRefundCardValue").attr("disabled", false);
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnApv", true);
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnCancelApv", true);
                    JSxCMNVisibleComponent("#ospCardShiftRefundApvName", false);
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnSave", true);
                }

                if (!JSbCardShiftRefundIsApv() && JSbCardShiftRefundIsStaDoc("incomplete")) {
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnApv", false);
                    JSxCMNVisibleComponent("#obtCardShiftRefundBtnCancelApv", true);
                    JSxCMNVisibleComponent("#ospCardShiftRefundApvName", false);
                }
                JSxCMNVisibleComponent('#obtCardShiftRefundBtnDocMa', true);
            }

            if (JCNbCardShiftRefundIsCreatePage()) {
                JSxCMNVisibleComponent("#obtCardShiftRefundBtnSave", true);
                JSxCMNVisibleComponent('#obtCardShiftRefundBtnDocMa', false);
            }
        } catch (err) {
            console.log("JSxCardShiftRefundActionAfterApv Error: ", err);
        }
    }

    /**
     * Functionality : Display vat total
     * Parameters : nDisplayDelay
     * Creator : 31/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundSetTotalVat(nDisplayDelay) {
        try {
            $("#otrCardShiftRefundTotalVat").remove();

            setTimeout(function() {
                if (JCNnCardShiftRefundCountDataSourceRow(["complete", "pending", "n/a", "cancel"]) > 0) {
                    var tTemplate = $("#oscCardShiftRefundTotalTopUpTemplate").html();
                    var tTotalValue = JSnCardShiftRefundGetSumCardValue();
                    $("#oetCardShiftRefundTotalValue").val(tTotalValue);
                    var oData = {
                        totalValue: tTotalValue.toLocaleString() + ".00"
                    };
                    var tRender = JStCardShiftRefundRenderTemplate(tTemplate, oData);
                    $("#otbCardShiftRefundDataSourceList").append(tRender);
                    $("#otrCardShiftRefundTotalVat").fadeIn(900);
                }
            }, nDisplayDelay);
        } catch (err) {
            console.log("JSxCardShiftRefundSetTotalVat Error: ", err);
        }
    }

    /**
     * Functionality : Sum card value in table temp
     * Parameters : -
     * Creator : 01/11/2018 piya
     * Last Modified : -
     * Return : Sum card value
     * Return Type : number
     */
    function JSnCardShiftRefundGetSumCardValue() {
        try {
            var oRecord = null,
                nSumValue = 0;
            oRecord = $("#otbCardShiftRefundDataSourceList tr td.xWCardShiftRefundCardValue");
            $.each(oRecord, function(pnIndex, poElement) {
                nSumValue += parseInt($(poElement).text());
            });
            return nSumValue;
        } catch (err) {
            console.log("JSnCardShiftRefundGetSumCardValue Error: ", err);
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
    function JStCardShiftRefundRenderTemplate(tTemplate, tData) {
        try {
            String.prototype.fmt = function(hash) {
                var tString = this,
                    nKey;
                for (nKey in hash) {
                    tString = tString.replace(new RegExp('\\{' + nKey + '\\}', 'gm'), hash[nKey]);
                }
                return tString;
            };
            var tRender = "";
            tRender = tTemplate.fmt(tData);

            return tRender;
        } catch (err) {
            console.log("JStCardShiftRefundRenderTemplate Error: ", err);
        }
    }

    /**
     * Functionality : Check record type exists
     * Parameters : tRecordType is "temp", "pending", "aproved", "docCancel"
     * Creator : 01/11/2018 piya
     * Last Modified : -
     * Return : Exists status
     * Return Type : boolean
     */
    function JStCardShiftRefundHasRecord(tRecordType) {
        try {
            var bStatus = false;
            if (tRecordType == "temp") {
                var nTempRecordCount = $("#otbCardShifOutDataSourceList tr.xWTemp").length();
                if (nTempRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
            if (tRecordType == "pending") {
                var nPendingRecordCount = $("#otbCardShifOutDataSourceList tr.xWApvPending").length();
                if (nPendingRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
            if (tRecordType == "aproved") {
                var nApvCompleteRecordCount = $("#otbCardShifOutDataSourceList tr.xWApvComplete").length();
                if (nApvCompleteRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
            if (tRecordType == "docCancel") {
                var nDocCancelRecordCount = $("#otbCardShifOutDataSourceList tr.xWDocCancel").length();
                if (nDocCancelRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
        } catch (err) {
            console.log("JStCardShiftRefundHasRecord Error: ", err);
        }
    }

    /**
     * Functionality : Action to print document
     * Parameters : -
     * Creator : 08/01/2019 Krit(Copter)
     * Last Modified : 16/11/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundPrint() {
        var tLangCode = $("#ohdCardShiftRefundLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftRefundUsrBchCode").val();
        var tDocNo = $("#oetCardShiftRefundCode").val();
        var aInfor = [
            {"Lang"         : tLangCode},
            {"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'},
            {"BranchCode"   : tUsrBchCode},
            {"DocCode"      : tDocNo}
        ];
        window.open('<?php echo base_url(); ?>'+"formreport/Frm_SQL_FCCardRefundCash?infor="+JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>
<?php include 'jCardShiftRefundDataSourceTable.php'; ?>


<script>
    //เลือกสาขา วัฒน์ 13/08/2020
    $("#obtBrowseBCH_cardshiftrefund").click(function() {
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
                Value: ["oetBCHCode_cardshiftrefund", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_cardshiftrefund", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_cardshiftrefund',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });

    function JSxSetConfigBCH_cardshiftrefund(params) {
        if (params == 'NULL') {
            var tValue = '';
            $('#oetBCHName_cardshiftrefund').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftRefundUsrBchCode').val(tValue);
    }

    //ค้นหาการ์ดแบบยิงบาร์โค็ด
    function JSxCardShiftRefundScanner() {
      var nCountNumber  = 0;
      if ($("#oetCardShiftRefundCountNumber").val()=="" || $("#oetCardShiftRefundCountNumber").val()=="0") {
        nCountNumber  = 0;
      }else {
        nCountNumber  = parseInt($("#oetCardShiftRefundCountNumber").val());
      }

      //ถ้าไม่ได้กรอกข้อมูล หรือกรอกข้อมูลแล้วข้อมูล
      if($('#oetCardShiftRefundDataScannerID').val() == ''){
        $('#oetCardShiftRefundDataScannerID').focus();
        return;
      }else if($("#oetCardShiftRefundDataScannerID").val() != '') {
        $.ajax({
            type    : "POST",
            url     : "cardShiftRefundEventScanner",
            data    : { tScannerID : $('#oetCardShiftRefundDataScannerID').val() , nCountNumber:nCountNumber},
            cache   : false,
            timeout : 0,
            success : function(tResult) {
              var aData = JSON.parse(tResult);
              if (aData['rtCode']=='1') {
                var aCardCode = [];
                aCardCode.push(aData['raItems'][0]['FTCrdCode']);
                JSxCardShiftRefundSetDataSource(aCardCode);
                $("#oetCardShiftRefundDataScannerID").val("");
              }else{
                if (aData['rtCode'] == '801'){
                    var tTextError = '<?=language('common/main/main','tDataDuplicate')?>';
                }else{
                    var tTextError = '<?=language('common/main/main','tMainRptNotFoundDataInDB')?>';
                }

                FSvCMNSetMsgErrorDialog(tTextError);
                $('#oetCardShiftRefundDataScannerID').val('');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
            }
        });
      }
    }
</script>