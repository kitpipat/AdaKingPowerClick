<script type="text/javascript">
    $(document).ready(function() {

        $(".xCNavRow").removeClass("row").addClass("clearfix");

        $('.xCNSelectBox').selectpicker();

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

        $('#oimCardShiftStatusBrowseProvince').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oPvnOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftStatusFromCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftStatusBrowseFromCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#oimCardShiftStatusToCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftStatusBrowseToCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $("#oimCardShiftStatusFromCardNumber, #oimCardShiftStatusToCardNumber, #obtCardShiftStatusAddDataSource").on("click", function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.CardShiftStatusGetCardCodeTemp = JStCardShiftStatusGetCardCodeTemp();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#oimCardShiftStatusFromCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftStatusBrowseFromCardNumberOption = oCardShiftStatusBrowseFromCardNumber(CardShiftStatusGetCardCodeTemp);
                JCNxBrowseData('oCardShiftStatusBrowseFromCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftStatusToCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftStatusBrowseToCardNumberOption = oCardShiftStatusBrowseToCardNumber(CardShiftStatusGetCardCodeTemp);
                JCNxBrowseData('oCardShiftStatusBrowseToCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtCardShiftStatusAddDataSource').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftStatusBrowseAddDataSourceOption = oCardShiftStatusBrowseAddDataSource(CardShiftStatusGetCardCodeTemp);
                JCNxBrowseData('oCardShiftStatusBrowseAddDataSourceOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        if (JCNbCardShiftStatusIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftStatusCode").attr("readonly", true);
            $("#odvCardShiftStatusAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftStatusAutoGenCode', false);

            // $("#obtGenCodeCardShiftStatus").attr("disabled", true);
            JSxCMNVisibleComponent('#obtCardShiftStatusBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftStatusBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftStatusBtnDocMa', true);
        }

        if (JCNbCardShiftStatusIsCreatePage()) {
            // Doc No
            $("#oetCardShiftStatusCode").attr("disabled", true);
            $('#ocbCardShiftStatusAutoGenCode').change(function() {
                if ($('#ocbCardShiftStatusAutoGenCode').is(':checked')) {
                    $("#oetCardShiftStatusCode").attr("disabled", true);
                    $('#odvCardShiftStatusDocNoForm').removeClass('has-error');
                    $('#odvCardShiftStatusDocNoForm em').remove();
                } else {
                    $("#oetCardShiftStatusCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftStatusAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftStatusBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftStatusBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftStatusBtnDocMa', false);

            JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftStatusIsUpdatePage()) {
            let tDocNo = $("#oetCardShiftStatusCode").val();
            <?php if (!empty($aCardCode)) : ?>
                <?php if ($aResult["raItems"]["rtCardShiftStatusStaDoc"] == "3") : // Cancel 
                ?>
                    JSvCardShiftStatusDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "", false, false, [], "2", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftStatusStaPrcDoc"] == "1") : // Approved 
                    ?>
                        console.log("")
                        JSvCardShiftStatusDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "", false, false, [], "1", tDocNo);
                    <?php else : // Pending 
                    ?>
                        JSvCardShiftStatusDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "1", false, false, [], "3", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftStatusApvCode").val();
        var tUsrCode = $("#ohdCardShiftStatusUsrCode").val();

        if ((JCNbCardShiftStatusIsUpdatePage() && JSbCardShiftStatusIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftStatusGetProgressAfterApvDoc();
        }

        JSxCardShiftStatusSetCardCodeTemp();
        JSxCardShiftStatusActionAfterApv();
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

    // Option Reference
    var oCardShiftStatusBrowseFromCardType = {
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
            Value: ["oetCardShiftStatusFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftStatusFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        NextFunc: {
            FuncName: 'JSxCSTAddSetCodeTypeCard',
            ArgReturn: ['FTCtyName', 'FTCtyCode']
        },
        // RouteFrom : 'cardShiftStatus',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftStatusBrowseType
    };

    function JSxCSTAddSetCodeTypeCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftStatusToCardTypeName').val(aData[0]);
            $('#oetCardShiftStatusToCardTypeCode').val(aData[1]);
        } else {
            $('#oetCardShiftStatusToCardTypeName').val('');
            $('#oetCardShiftStatusToCardTypeCode').val('');
        }
    }

    var oCardShiftStatusBrowseToCardType = {
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
            OrderBy: ['TFNMCardType.FDCreateOn DESC'],
            // SourceOrder		: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftStatusToCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftStatusToCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTCtyCode']
        },*/
        // RouteFrom : 'cardShiftStatus',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftStatusBrowseType
    };

    var oCardShiftStatusBrowseFromCardNumber = function(ptNotCardCode) {
        var nFromCard = $('#oetCardShiftStatusFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftStatusToCardTypeCode').val();

        var tWhereInCard = "";
        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        console.log("Not Card Code: ", ptNotCardCode);
        let tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }

        let oOptions = {
            Title: ['payment/card/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode'
            },
            Join: {
                Table: ['TFNMCard_L'],
                On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tNotIn + tWhereInCard + tWhereCardByAgenCode]
                // Condition : ["AND ((TFNMCard.FTCrdStaType = 1 AND TFNMCard.FTCrdStaShift = 1) OR TFNMCard.FTCrdStaType = 2)" + tNotIn]
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
                Value: ["oetCardShiftStatusFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftStatusFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },

            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeNumberCard',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftStatus',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftStatusBrowseType
        };
        return oOptions;
    };

    function JSxCSTAddSetCodeNumberCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftStatusToCardNumberCode').val(aData[0]);
            $('#oetCardShiftStatusToCardNumberName').val(aData[0]);
        } else {
            $('#oetCardShiftStatusToCardNumberCode').val('');
            $('#oetCardShiftStatusToCardNumberName').val('');
        }
    }

    var oCardShiftStatusBrowseToCardNumber = function(ptNotCardCode) {
        var nFromCard = $('#oetCardShiftStatusFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftStatusToCardTypeCode').val();

        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        console.log("Not Card Code: ", ptNotCardCode);
        let tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }
        let oOptions = {
            Title: ['payment/card/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode'
            },
            Join: {
                Table: ['TFNMCard_L'],
                On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tNotIn + tWhereInCard + tWhereCardByAgenCode]
                // Condition : ["AND ((TFNMCard.FTCrdStaType = 1 AND TFNMCard.FTCrdStaShift = 1) OR TFNMCard.FTCrdStaType = 2)" + tNotIn]
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
                Value: ["oetCardShiftStatusToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftStatusToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftStatus',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftStatusBrowseType
        };
        return oOptions;
    };

    var oCardShiftStatusBrowseAddDataSource = function(ptNotCardCode) {
        console.log("Not Card Code: ", ptNotCardCode);
        let tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }
        let oOptions = {
            Title: ['payment/card/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode',
                PKName: 'FTCrdName'
            },
            Join: {
                Table: ['TFNMCard_L'],
                On: ['TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [tNotIn + tWhereCardByAgenCode]
                // Condition : ["AND ((TFNMCard.FTCrdStaType = 1 AND TFNMCard.FTCrdStaShift = 1) OR TFNMCard.FTCrdStaType = 2)" + tNotIn]
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
                FuncName: 'JSxCardShiftStatusSetDataSource',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftStatus',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftStatusBrowseType,
        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/
    var bUniqueCardShiftStatusCode;
    $.validator.addMethod(
        "uniqueCardShiftStatusCode",
        function(tValue, oElement, aParams) {
            let tCardShiftStatusCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftStatusUniqueValidate/cardShiftStatusCode",
                data: "tCardShiftStatusCode=" + tCardShiftStatusCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftStatusCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardShiftStatusCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftStatusCode;
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
     * Functionality : (event) Add/Edit CardShiftStatus
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftStatusAddEditCardShiftStatus(ptRoute) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                if (JCNnCardShiftStatusCountDataSourceRow() == 0) { // Check Card Empty
                    FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                    return;
                }

                // From Validate
                $('#ofmAddCardShiftStatusMainForm').validate({
                    rules: {
                        oetCardShiftStatusCode: {
                            required: true,
                            uniqueCardShiftStatusCode: JCNbCardShiftStatusIsCreatePage(),
                            maxlength: 20
                        },
                        oetCardShiftStatusDocDate: {
                            required: true
                        }
                    },
                    messages: {
                        oetCardShiftStatusCode: {
                            required: "<?php echo language('document/card/cardstatus', 'tValidCardShifStatus'); ?>",
                            uniqueCardShiftTopUpCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                            maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"

                        }
                        // oetCardShiftStatusName: ""
                    },
                    submitHandler: function(form) {
                        var aCardCode = JSaCardShiftStatusGetDataSourceCode("oldCardCode", false);
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                try {
                                    var oResult = JSON.parse(tResult);
                                    if (oResult.nStaEvent == '1') {
                                        JSvCardShiftStatusCallPageCardShiftStatusEdit(oResult.tCodeReturn);
                                    } else {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    }
                                } catch (err) {}
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
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
            console.log("JSnCardShiftStatusAddEditCardShiftStatus Error: ", err);
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
    function JSaCardShiftStatusGetDataSourceCode(ptGetMode, pbWrapText) {
        try {
            ptGetMode = (typeof ptGetMode !== 'undefined') ? ptGetMode : "all";
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;

            // Set data
            let aAll = [];
            let aOldCardCode = [];
            let aNewCardCode = [];
            let aOldCardBal = [];
            let aCardPack = [];

            let oRecord = JSON.parse(($("#ospCardShiftStatusCardCodeTemp").text() == "")?"[]":$("#ospCardShiftStatusCardCodeTemp").text());
            // console.log("Data source: ", oRecord);
            $.each(oRecord.raItems, function(pnIndex, poElement) {
                // console.log("pnIndex: ", pnIndex);
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
            console.log("JSaCardShiftStatusGetDataSourceCode Error: ", err);
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
    function JSxCardShiftStatusSetCardCodeTemp() {
        try {
            $("#ohdCardShiftStatusCardCodeTemp").val("");
            setTimeout(function() {
                $("#ohdCardShiftStatusCardCodeTemp").val(JSaCardShiftStatusGetDataSourceCode("oldCardCode", true).toString());
            }, 800);
        } catch (err) {
            console.log("JSxCardShiftStatusSetCardCodeTemp Error: ", err);
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
    function JStCardShiftStatusGetCardCodeTemp() {
        try {
            return $("#ohdCardShiftStatusCardCodeTemp").val();
        } catch (err) {
            console.log("JStCardShiftStatusGetCardCodeTemp Error: ", err);
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
    function JSxCardShiftStatusSetDataSource(ptCardCode) {
        try {
            if (ptCardCode.filter(Boolean).length < 1) {
                JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", true, false, [], "1", "");
                return;
            }
            var aCardCode = [];
            $.each(ptCardCode.filter(Boolean), function(nIndex, tValue) {
                var tCode = "'"+tValue+"'";
                // tCode = tCode.replace('["', "'");
                // tCode = tCode.replace('"]', "'");
                aCardCode[nIndex] = tCode;
            });
            JSxCardShiftStatusInsertDataToTemp([], [], aCardCode, "choose");
        } catch (err) {
            console.log("JSxCardShiftStatusSetDataSource Error: ", err);
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
    function JSxCardShiftStatusSetDataSourceFilter() {
        try {
            if ($('input[name=orbCardShiftStatusSourceMode]:checked').val() == "range") {
                console.log('Range type');
                let tCardTypeCodeFrom = $('#oetCardShiftStatusFromCardTypeCode').val();
                let tCardTypeCodeTo = $('#oetCardShiftStatusToCardTypeCode').val();
                let tCardNumberCodeFrom = $('#oetCardShiftStatusFromCardNumberCode').val();
                let tCardNumberCodeTo = $('#oetCardShiftStatusToCardNumberCode').val();
                console.log("Empty: ", tCardTypeCodeFrom);
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
                console.log("JStCardShiftStatusGetCardCodeTemp(): ", JStCardShiftStatusGetCardCodeTemp());

                let aNotInCardCode = JStCardShiftStatusGetCardCodeTemp() == "" ? [] : JStCardShiftStatusGetCardCodeTemp().split(",");

                // Begin validate
                if ((aCardTypeCode.length == 0) && (aCardNumberCode.length == 0)) {
                    JSxCMNVisibleComponent("#odvCardShiftStatusAlert label", false);
                    JSxCMNVisibleComponent("#odvCardShiftStatusAlert label.xWCheckCondition", true);
                } else {
                    JSxCMNVisibleComponent("#odvCardShiftStatusAlert label", false);
                }
                // End validate

                if (!(aCardTypeCode.length == 0) && !(aCardNumberCode.length == 0)) {
                    JSxCardShiftStatusInsertDataToTemp(aCardNumberCode, aCardTypeCode, [], "between");
                    return;
                }
                if (!(aCardTypeCode.length == 0) || !(aCardNumberCode.length == 0)) {
                    console.log("Or");
                    if (!(aCardTypeCode.length == 0)) {
                        JSxCardShiftStatusInsertDataToTemp([], aCardTypeCode, [], "between");
                        return;
                    }
                    if (!(aCardNumberCode.length == 0)) {
                        JSxCardShiftStatusInsertDataToTemp(aCardNumberCode, [], [], "between");
                        return;
                    }
                }
            }

            if ($('input[name=orbCardShiftStatusSourceMode]:checked').val() == "file") {
                console.log('File type');
                $("#obtSubmitCardShiftStatusSearchCardForm").trigger("click");
            }
            JSxCardShiftStatusSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftStatusSetDataSourceFilter Error: ", err);
        }
    }

    /**
     * Functionality : Insert card to document temp
     * Parameters : paRangeCardCode, paRangeCardType, paCardCode, ptInsertType is "between", "shoose"
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusInsertDataToTemp(paRangeCardCode, paRangeCardType, paCardCode, ptInsertType) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusInsertToTemp",
                    data: {
                        tRangeCardCode: JSON.stringify(paRangeCardCode),
                        tRangeCardType: JSON.stringify(paRangeCardType),
                        tCardCode: JSON.stringify(paCardCode),
                        tInsertType: ptInsertType,
                        tDocNo: $('#oetCardShiftStatusCode').val(),
                        tBCHCode: $('#oetBCHCode_CardShiftStatus').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success DOCNO: ", tResult);
                        try {
                            JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftStatusInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : Update card on document temp
     * Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
     * Creator : 4/1/2019 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusUpdateDataOnTemp(ptCardCode, ptNewCardCode, ptReasonCode, pnSeq, pnPage, ptRmk) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusUpdateInlineOnTemp",
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
                        JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftStatusInsertDataToTemp Error: ", err);
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
    function JSxCardShiftStatusVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftStatusFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftStatusRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftStatusAlert label", false);
                JSxCMNVisibleComponent("#oahCardShiftStatusDataLoadMask", true);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftStatusFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftStatusRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftStatusAlert label", false);
                JSxCMNVisibleComponent("#oahCardShiftStatusDataLoadMask", false);
            }
            JSxCardShiftStatusSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftStatusVisibleDataSourceMode Error: ", err);
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
    function JSxCardShiftStatusSetImportFile(poElement, poEvent) {
        try {
            console.log('Import run');
            let oFile = $(poElement)[0].files[0];
            $("#oetCardShiftStatusFileTemp").val(oFile.name);
        } catch (err) {
            console.log("JSxCardShiftStatusSetImportFile Error: ", err);
        }
    }

    /**
     * Functionality : (event) Add/Edit CardShiftStatus
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusImportFileValidate() {
        console.log("Import file validate");
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oefCardShiftStatusImport: {
                        required: true,
                        extensionValidate: 'xls|xlsx',
                        fileSizeValidate: '100' // unit mb
                    }
                },
                messages: {
                    oefCardShiftStatusImport: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                        extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                        fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                    }
                },
                submitHandler: function(form) {
                    $('#odvCardShiftStatusModalImportFileConfirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#odvCardShiftStatusModalImportFileConfirm').modal('show');
                    $('#osmCardShiftStatusBtnImportFileConfirm').one('click', function(evt) {
                        $('#odvCardShiftStatusModalImportFileConfirm').modal('hide');
                        JSvCardShiftStatusDataSourceTableByFile("", false, "1", true, false, [], "3");
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
            console.log("JSxCardShiftStatusImportFileValidate Error: ", err);
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
    function JSxCardShiftStatusSetCountNumber() {
        try {
            var tCountAll = $("#ohdCardShiftStatusCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftStatusCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            $("#oetCardShiftStatusCountNumber").val("");
            $("#oetCardShiftStatusCountNumber").val(tResult);
            $("#ospCardShiftStatusDataSourceCount").text("");
            $("#ospCardShiftStatusDataSourceCount").text(tResult);
        } catch (err) {
            console.log("JSxCardShiftStatusSetCountNumber Error: ", err);
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
    function JSvCardShiftStatusDataSourceTable(pnPage, paCardCode, paCardTypeCodeRange, paCardCodeRange, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftStatusDataSearch').val();
                var nPageCurrent = pnPage;
                console.log("nPage: ", pnPage);
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                console.log("ptStaShift: ", ptStaShift);
                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusDataSourceTable",
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
                        tStaPrcDoc: $("#ohdCardShiftStatusCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftStatusCardStaDoc").val(),
                        tDocNo: $("#oetCardShiftStatusCode").val(),
                        tLastIndex: JCNnCardShiftStatusCountDataSourceRow(["pending", "n/a", "notfound"])
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success");
                        try {
                            console.log("typeof: ", JSON.parse(tResult));
                            let oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftStatusAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftStatusAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }
                        } catch (err) {

                        }

                        if (tResult != "") {
                            $('#odvCardShiftStatusDataSource').html(tResult);
                            JSxCardShiftStatusSetHeightDataSourceTable();
                        }
                        JSxCardShiftStatusSetCountNumber();
                        JSxCardShiftStatusSetCardCodeTemp();
                        JSxCMNVisibleComponent("#odvCardShiftStatusAlert label", false);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftStatusDataSourceTable Error: ', err);
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
    function JSvCardShiftStatusDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
        try {
            var tSearchAll = $('#oetSearchAll').val();
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            JCNxOpenLoading();
            console.log("ptStaShift: ", ptStaShift);

            var oFormData = new FormData();

            let oFile = $('#oefCardShiftStatusImport')[0].files[0];
            console.log("File: ", oFile);
            oFormData.append('oefCardShiftStatusImport', oFile);

            oFormData.append('tSearchAll', tSearchAll);
            oFormData.append('nPageCurrent', nPageCurrent);
            oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
            oFormData.append('tStaShift', ptStaShift);
            oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
            oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
            oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
            oFormData.append('tStaPrcDoc', $("#ohdCardShiftStatusCardStaPrcDoc").val());
            oFormData.append('tStaDoc', $("#ohdCardShiftStatusCardStaDoc").val());
            oFormData.append('tLastIndex', JCNnCardShiftStatusCountDataSourceRow(["complete", "pending", "n/a"]));
            oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
            oFormData.append('aFile', oFile);
            oFormData.append('tBchCode', $("#oetBCHCode_CardShiftStatus").val());

            var tDocNo = $('#oetCardShiftStatusCode').val();
            if (tDocNo == '' || tDocNo == null) {
                var tDocNo = '-';
            }
            oFormData.append('tDocNo', tDocNo);

            $.ajax({
                type: "POST",
                url: "cardShiftStatusDataSourceTableByFile",
                data: oFormData,
                cache: false,
                contentType: false,
                processData: false,
                Timeout: 5000,
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
                            JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
                        } else {
                            JCNxCloseLoading();
                        }
                    } catch (err) {
                        console.log('JSvCardShiftStatusDataSourceTableByFile Error: ', err);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (err) {
            console.log('JSvCardShiftStatusDataSourceTableByFile Error: ', err);
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
    function JSxCardShiftStatusSearchDataSourceTable() {
        JSvCardShiftStatusDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusSetHeightDataSourceTable() {
        /*let nLeftContainerHeight = $(".xWLeftContainer").height();
        $("#odvCardShiftStatusDataSource .table-responsive").height(nLeftContainerHeight-181);*/
    }

    /**
     * Functionality : Delete Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    /*function JSxCardShiftStatusDataSourceDeleteOperator(poElement, poEvent){
        try{
            if(JSbCardShiftStatusIsApv() || JSbCardShiftStatusIsStaDoc("cancel")){return;}
            if(confirm('Delete. ?')){
                $(poElement) // Delete Itseft Record.
                    .parents('.otrCardShiftStatusDataSource')
                    .addClass('hidden');
                JSxCardShiftStatusSetCountNumber();  
                JSxCardShiftStatusSetCardCodeTemp();
            }
        }catch(err){
            console.log('JSxCardShiftStatusDataSourceDeleteOperator Error: ', err);
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
    function JCNnCardShiftStatusCountDataSourceRow() {
        try {
            return $('#ohdCardShiftStatusCountRowFromTemp').val();
        } catch (err) {
            console.log('JCNnCardShiftStatusCountDataSourceRow Error: ', err);
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
    function JCNbCardShiftStatusCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                let nRow = $('#otbCardShiftStatusDataSourceList > tr').not('.hidden').not('#otrCardShiftStatusNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            console.log('JCNbCardShiftStatusCheckTypeDataSourceRow Error: ', err);
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
    function JSxCardShiftStatusStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Empty record check
            if (JCNnCardShiftStatusCountDataSourceRow() == 0) {
                $("#odvCardShiftStatusModalEmptyCardAlert").modal("show");
                return;
            }

            if (pbIsConfirm) {
                console.log("StaApvDoc Run");
                $("#ohdCardShiftStatusCardStaPrcDoc").val(2); // Set status for processing approve
                console.log("Data form: ", $('#ofmAddCardShiftStatusMainForm').serialize());
                $("#odvCardShiftStatusPopupApv").modal('hide');
                JSxCMNVisibleComponent("#ospCardShiftStatusApvName", true);
                var aCardCode = JSaCardShiftStatusGetDataSourceCode(false);
                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusEventUpdateApvDocAndCancelDoc",
                    data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        console.log(tResult);
                        try {
                            let oResult = JSON.parse(tResult);
                            if (oResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                            }
                        } catch (e) {}
                        JSxCardShiftStatusGetProgressAfterApvDoc();
                        JSxCardShiftStatusActionAfterApv();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                console.log("StaApvDoc Call Modal");
                $("#odvCardShiftStatusPopupApv").modal('show');
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
    function JSxCardShiftStatusGetProgressAfterApvDoc(){
        // Document variable
        var tLangCode = $("#ohdCardShiftStatusLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftStatusUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftStatusApvCode").val();
        var tUsrCode = $("#ohdCardShiftStatusUsrCode").val();
        var tDocNo = $("#oetCardShiftStatusCode").val();
        var tPrefix = 'RESADJSTATUS';
        var tStaDelMQ = $("#ohdCardShiftStatusApvCode").val();
        var tStaApv = $("#ohdCardShiftStatusApvCode").val();
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
            tCallPageEdit: 'JSvCardShiftStatusCallPageCardShiftStatusEdit',
            tCallPageList: 'JSvCardShiftStatusCallPageCardShiftStatus'
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
    function JSxCardShiftStatusStaDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            if (pbIsConfirm) {
                if ($("#ohdCardShiftStatusCardStaPrcDoc").val() == "") { // Pending approve status
                    $("#ohdCardShiftStatusCardStaDoc").val(3); // Set status for cancel document
                    $("#odvCardShiftStatusPopupStaDoc").modal('hide');
                    var aCardCode = JSaCardShiftStatusGetDataSourceCode(false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftStatusEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            JSvCardShiftStatusCallPageCardShiftStatusEdit($("#oetCardShiftStatusCode").val());
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            } else {
                $("#odvCardShiftStatusPopupStaDoc").modal('show');
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
    function JSbCardShiftStatusIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftStatusStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftStatusIsStaDelQname Error: ", err);
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
    function JSbCardShiftStatusIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftStatusCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftStatusIsStaApv Error: ", err);
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
    function JSbCardShiftStatusIsApv() {
        var bStatus = false;
        if (($("#ohdCardShiftStatusCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftStatusCardStaPrcDoc").val() == "2")) {
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
    function JSbCardShiftStatusIsStaDoc(ptStaType) {
        var bStatus = false;
        if (ptStaType == "complete") {
            if ($("#ohdCardShiftStatusCardStaDoc").val() == "1") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "incomplete") {
            if ($("#ohdCardShiftStatusCardStaDoc").val() == "2") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "cancel") {
            if ($("#ohdCardShiftStatusCardStaDoc").val() == "3") {
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
    function JSxCardShiftStatusActionAfterApv() {
        if (JCNbCardShiftStatusIsUpdatePage()) {
            if (JSbCardShiftStatusIsApv() || JSbCardShiftStatusIsStaDoc("cancel")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnCancelApv", false);
                $("#oetCardShiftStatusDocDate").attr("disabled", true);
                $(".xCNBtnDateTime").attr("disabled", true);
                if (JSbCardShiftStatusIsApv()) {
                    JSxCMNVisibleComponent("#ospCardShiftStatusApvName", true);
                }
                if (JSbCardShiftStatusIsStaDoc("cancel")) {
                    JSxCMNVisibleComponent("#ospCardShiftStatusApvName", false);
                }
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnSave", false);
            } else {
                console.log("Show Apv");
                $("#oetCardShiftStatusDocDate").attr("disabled", false);
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnApv", true);
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftStatusApvName", false);
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnSave", true);
            }

            if (!JSbCardShiftStatusIsApv() && JSbCardShiftStatusIsStaDoc("incomplete")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftStatusBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftStatusApvName", false);
            }
        }

        if (JCNbCardShiftStatusIsCreatePage()) {
            JSxCMNVisibleComponent("#obtCardShiftStatusBtnSave", true);
        }
    }

    /**
     * Functionality : Action to print document
     * Parameters : -
     * Creator : 29/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftStatusPrint() {
        var tUsrBchCode = $("#ohdCardShiftStatusUsrBchCode").val();
        var tDocNo      = $("#oetCardShiftStatusCode").val();
        var aInfor = [
			{"Lang"         : '<?php echo FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : tUsrBchCode}
		];
		window.open("<?php echo base_url(); ?>formreport/Frm_SQL_FCCardChgStaCashCrd?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>

<script>
    //เลือกสาขา วัฒน์ 13/08/2020
    $("#obtBrowseBCH_CardShiftStatus").click(function() {
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
                Value: ["oetBCHCode_CardShiftStatus", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_CardShiftStatus", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_CardShiftStatus',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });

    function JSxSetConfigBCH_CardShiftStatus(params) {
        if (params == 'NULL') {
            var tValue = '';
            $('#oetBCHName_CardShiftStatus').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftStatusUsrBchCode').val(tValue);
    }

    //ค้นหาการ์ดแบบยิงบาร์โค็ด
    function JSxCardShiftStatusScanner(){
        var nCountNumber  = 0;
        if ($("#oetCardShiftStatusDataScannerID").val() == "" || $("#oetCardShiftStatusDataScannerID").val()=="0") {
            nCountNumber  = 0;
        }else {
            nCountNumber  = parseInt($("#oetCardShiftStatusDataScannerID").val());
        }

        //ถ้าไม่ได้กรอกข้อมูล หรือกรอกข้อมูลแล้วข้อมูล
        if($('#oetCardShiftStatusDataScannerID').val() == ''){
            $('#oetCardShiftStatusDataScannerID').focus();
            return;
        }else if($("#oetCardShiftStatusDataScannerID").val() != '') {
            $.ajax({
                type    : "POST",
                url     : "cardShiftStatusEventScanner",
                data    : { tScannerID : $('#oetCardShiftStatusDataScannerID').val() , nCountNumber:nCountNumber},
                cache   : false,
                timeout : 0,
                success : function(tResult) {
                    var aData = JSON.parse(tResult);
                    if (aData['rtCode']=='1') {
                        var aCardCode = [];
                        aCardCode.push(aData['raItems'][0]['FTCrdCode']);
                        JSxCardShiftStatusSetDataSource(aCardCode);
                        $("#oetCardShiftStatusDataScannerID").val("");
                    }else {
                        if (aData['rtCode'] == '801'){
                            var tTextError = '<?=language('common/main/main','tDataDuplicate')?>';
                        }else{
                            var tTextError = '<?=language('common/main/main','tMainRptNotFoundDataInDB')?>';
                        }

                        FSvCMNSetMsgErrorDialog(tTextError);
                        $('#oetCardShiftStatusDataScannerID').val('');
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }  
    }
</script>