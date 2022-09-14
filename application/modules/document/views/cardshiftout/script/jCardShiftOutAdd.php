<script type="text/javascript">
    $(document).ready(function() {

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

        $('#oimCardShiftOutBrowseProvince').click(function() {
            JCNxBrowseData('oPvnOption');
        });

        $('#oimCardShiftOutFromCardType').click(function() {
            JCNxBrowseData('oCardShiftOutBrowseFromCardType');
        });
        $('#oimCardShiftOutToCardType').click(function() {
            JCNxBrowseData('oCardShiftOutBrowseToCardType');
        });

        $("#oimCardShiftOutFromCardNumber, #oimCardShiftOutToCardNumber, #obtCardShiftOutAddDataSource").on("click", function() {
            window.CardShiftOutGetCardCodeTemp = JStCardShiftOutGetCardCodeTemp();
        });

        $('#oimCardShiftOutFromCardNumber').click(function() {
            window.oCardShiftOutBrowseFromCardNumberOption = oCardShiftOutBrowseFromCardNumber(CardShiftOutGetCardCodeTemp);
            JCNxBrowseData('oCardShiftOutBrowseFromCardNumberOption');
        });

        $('#oimCardShiftOutToCardNumber').click(function() {
            window.oCardShiftOutBrowseToCardNumberOption = oCardShiftOutBrowseToCardNumber(CardShiftOutGetCardCodeTemp);
            JCNxBrowseData('oCardShiftOutBrowseToCardNumberOption');
        });

        $('#obtCardShiftOutAddDataSource').click(function() {
            window.oCardShiftOutBrowseAddDataSourceOption = oCardShiftOutBrowseAddDataSource(CardShiftOutGetCardCodeTemp);
            JCNxBrowseData('oCardShiftOutBrowseAddDataSourceOption');
        });

        if (JCNbCardShiftOutIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftOutCode").attr("readonly", true);
            $("#odvCardShiftOutAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftOutAutoGenCode', false);

            // $("#obtGenCodeCardShiftOut").attr("disabled", true);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', true);
        }

        if (JCNbCardShiftOutIsCreatePage()) {
            // Doc No
            $("#oetCardShiftOutCode").attr("disabled", true);
            $('#ocbCardShiftOutAutoGenCode').change(function() {
                if ($('#ocbCardShiftOutAutoGenCode').is(':checked')) {
                    $("#oetCardShiftOutCode").attr("disabled", true);
                    $('#odvCardShiftOutDocNoForm').removeClass('has-error');
                    $('#odvCardShiftOutDocNoForm em').remove();
                } else {
                    $("#oetCardShiftOutCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftOutAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftOutBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftOutBtnDocMa', false);

            JSvCardShiftOutDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftOutIsUpdatePage()) {
            let tDocNo = $("#oetCardShiftOutCode").val();
            <?php if (!empty($aCardCode)) : ?>
                <?php if ($aResult["raItems"]["rtCardShiftOutStaDoc"] == "3") : // Cancel
                ?>
                    JSvCardShiftOutDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "2", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftOutStaPrcDoc"] == "1") : // Approved
                    ?>
                        JSvCardShiftOutDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "3", false, false, [], "1", tDocNo);
                    <?php else : // Pending
                    ?>
                        JSvCardShiftOutDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "3", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftOutDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftOutApvCode").val();
        var tUsrCode = $("#ohdCardShiftOutUsrCode").val();

        if ((JCNbCardShiftOutIsUpdatePage() && JSbCardShiftOutIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftOutGetProgressAfterApvDoc();
        }

        JSxCardShiftOutSetCardCodeTemp();
        console.log("GetCardCodeTemp Init: ", JStCardShiftOutGetCardCodeTemp());
        JSxCardShiftOutActionAfterApv();
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
    var oCardShiftOutBrowseFromCardType = {
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
            Condition: [tWhereCardTypeByAgenCode]
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
            Value: ["oetCardShiftOutFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftOutFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        NextFunc: {
            FuncName: 'JSxCSTAddSetCodeTypeCard',
            ArgReturn: ['FTCtyName', 'FTCtyCode']
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTCtyCode']
        },*/
        // RouteFrom : 'cardShiftOut',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftOutBrowseType
    };

    function JSxCSTAddSetCodeTypeCard(poData) {


        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftOutToCardTypeName').val(aData[0]);
            $('#oetCardShiftOutToCardTypeCode').val(aData[1]);
        } else {
            $('#oetCardShiftOutToCardTypeName').val('');
            $('#oetCardShiftOutToCardTypeCode').val('');
        }

    }

    var oCardShiftOutBrowseToCardType = {
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
            Condition: [tWhereCardTypeByAgenCode]
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
            Value: ["oetCardShiftOutToCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftOutToCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTCtyCode']
        },*/
        // RouteFrom : 'cardShiftOut',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftOutBrowseType
    };

    var oCardShiftOutBrowseFromCardNumber = function(ptNotCardCode) {

        var nFromCard = $('#oetCardShiftOutFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftOutToCardTypeCode').val();

        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCardType.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        console.log("Not Card Code: ", ptNotCardCode);
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
                Condition: ["AND ( ( (TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '1') ) AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) )" + tNotIn + tWhereInCard + tWhereCardByAgenCode]
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
                Value: ["oetCardShiftOutFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftOutFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeNumberCard',
                ArgReturn: ['FTCrdCode']
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftOut',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftOutBrowseType,
            // DebugSQL : true
        };
        return oOptions;
    };

    function JSxCSTAddSetCodeNumberCard(poData) {

        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftOutToCardNumberCode').val(aData[0]);
            $('#oetCardShiftOutToCardNumberName').val(aData[0]);
        } else {
            $('#oetCardShiftOutToCardNumberCode').val('');
            $('#oetCardShiftOutToCardNumberName').val('');
        }

    }

    var oCardShiftOutBrowseToCardNumber = function(ptNotCardCode) {


        var nFromCard = $('#oetCardShiftOutFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftOutToCardTypeCode').val();


        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCardType.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }


        console.log("Not Card Code: ", ptNotCardCode);
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
                Condition: ["AND ( ( (TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '1') ) AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) )" + tNotIn + tWhereInCard + tWhereCardByAgenCode]
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
                Value: ["oetCardShiftOutToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftOutToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftOut',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftOutBrowseType
        };
        return oOptions;
    };

    var oCardShiftOutBrowseAddDataSource = function(ptNotCardCode) {
        console.log("Not Card Code: ", ptNotCardCode);
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
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
                Condition: ["AND ( ( (TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '1') ) AND (TFNMCard.FTCrdStaActive = '1') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) )" + tNotIn + tWhereCardByAgenCode]
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
                FuncName: 'JSxCardShiftOutSetDataSource',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftOut',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftOutBrowseType
        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/
    var bUniqueCardShiftOutCode;
    $.validator.addMethod(
        "uniqueCardShiftOutCode",
        function(tValue, oElement, aParams) {
            let tCardShiftOutCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftOutUniqueValidate/cardShiftOutCode",
                data: "tCardShiftOutCode=" + tCardShiftOutCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftOutCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardShiftOutCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftOutCode;
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
     * Functionality : (event) Add/Edit CardShiftOut
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftOutAddEditCardShiftOut(ptRoute) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired(); // Get Sesstion Expired
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) { // Sesstion Check

                if (JCNnCardShiftOutCountDataSourceRow() == 0) { // Check Card Empty
                    FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                    return;
                }

                // From Validate
                $('#ofmAddCardShiftOutMainForm').validate({
                    rules: {
                        oetCardShiftOutCode: {
                            required: true,
                            uniqueCardShiftOutCode: JCNbCardShiftOutIsCreatePage(),
                            maxlength: 20
                        },
                        oetCardShiftOutDocDate: {
                            required: true
                        }
                    },
                    messages: {
                        oetCardShiftOutCode: {
                            required: "<?php echo language('document/card/cardout', 'tValidCardShifOut'); ?>",
                            uniqueCardShiftTopUpCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                            maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"

                        }
                        // oetCardShiftOutName: ""
                    },
                    submitHandler: function(form) {
                        var aCardCode = JSaCardShiftOutGetDataSourceCode(false);
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: $('#ofmAddCardShiftOutMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                try {
                                    var oResult = JSON.parse(tResult);
                                    if (oResult.nStaEvent == '1') {
                                        JSvCardShiftOutCallPageCardShiftOutEdit(oResult.tCodeReturn);
                                    } else {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    }
                                } catch (err) {}
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
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
            console.log("JSnCardShiftOutAddEditCardShiftOut Error: ", err);
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
    function JSaCardShiftOutGetDataSourceCode(pbWrapText) {
        try {
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;
            // Set data
            var aData = [];
            var oRecord = JSON.parse(($("#ospCardShiftOutCardCodeTemp").text() == "")?"[]":$("#ospCardShiftOutCardCodeTemp").text());
            // console.log("Data source: ", oRecord);
            $.each(oRecord, function(pnIndex, poElement) {
                // console.log("pnIndex: ", pnIndex);
                console.log("poElement: ", poElement.FTCrdCode);
                if (pbWrapText) {
                    aData.push("'" + poElement.FTCrdCode + "'");
                } else {
                    aData.push(poElement.FTCrdCode);
                }
            });
            return aData;
        } catch (err) {
            console.log("JSaCardShiftOutGetDataSourceCode Error: ", err);
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
    function JSxCardShiftOutSetCardCodeTemp() {
        try {
            $("#ohdCardShiftOutCardCodeTemp").val("");
            setTimeout(function() {
                $("#ohdCardShiftOutCardCodeTemp").val(JSaCardShiftOutGetDataSourceCode(true));
            }, 800);
        } catch (err) {
            console.log("JSxCardShiftOutSetCardCodeTemp Error: ", err);
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
    function JStCardShiftOutGetCardCodeTemp() {
        try {
            return $("#ohdCardShiftOutCardCodeTemp").val();
        } catch (err) {
            console.log("JStCardShiftOutGetCardCodeTemp Error: ", err);
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
    function JSxCardShiftOutSetDataSource(ptCardCode) {
        try {
            $('#testName').val('');
            $('#testCode').val('');
            console.log("JSxCardShiftOutSetDataSource: ", ptCardCode.filter(Boolean));
            if (ptCardCode.filter(Boolean).length < 1) {
                JSvCardShiftOutDataSourceTable("", [], [], [], true, "1", true, false, [], "1", "");
                return;
            }

            var aCardCode = [];
            $.each(ptCardCode.filter(Boolean), function(nIndex, tValue) {
                var tCode = "'"+tValue+"'";
                // tCode = tCode.replace('["', "'");
                // tCode = tCode.replace('"]', "'");
                aCardCode[nIndex] = tCode;
            });

            JSxCardShiftOutInsertDataToTemp([], [], aCardCode, "choose");
        } catch (err) {
            console.log("JSxCardShiftOutSetDataSource Error: ", err);
        }
    }

    /**
     * Functionality : {description}
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : 07/01/2019 Wasin(Yoshi)
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftOutSetDataSourceFilter() {
        try {
            console.log("Set Data Source");

            // เช็คนำเข้าข้อมูลตารางแบบเลือกช่วงของข้อมูล
            if ($('input[name=orbCardShiftOutSourceMode]:checked').val() == "range") {
                console.log('Range type');
                var tCardTypeCodeFrom = $('#oetCardShiftOutFromCardTypeCode').val();
                var tCardTypeCodeTo = $('#oetCardShiftOutToCardTypeCode').val();
                var tCardNumberCodeFrom = $('#oetCardShiftOutFromCardNumberCode').val();
                var tCardNumberCodeTo = $('#oetCardShiftOutToCardNumberCode').val();

                console.log("Empty: ", tCardTypeCodeFrom);

                var aCardTypeCode = [];
                if (tCardTypeCodeFrom != "" && tCardTypeCodeTo != "") {
                    aCardTypeCode.push(tCardTypeCodeFrom);
                    aCardTypeCode.push(tCardTypeCodeTo);
                }

                var aCardNumberCode = [];
                if (tCardNumberCodeFrom != "" && tCardNumberCodeTo != "") {
                    aCardNumberCode.push(tCardNumberCodeFrom);
                    aCardNumberCode.push(tCardNumberCodeTo);
                }
                console.log("JStCardShiftOutGetCardCodeTemp(): ", JStCardShiftOutGetCardCodeTemp());

                var aNotInCardCode = JStCardShiftOutGetCardCodeTemp() == "" ? [] : JStCardShiftOutGetCardCodeTemp().split(",");

                // Begin validate
                if ((aCardTypeCode.length == 0) && (aCardNumberCode.length == 0)) {
                    JSxCMNVisibleComponent("#odvCardShiftOutAlert label", false);
                    JSxCMNVisibleComponent("#odvCardShiftOutAlert label.xWCheckCondition", true);
                } else {
                    JSxCMNVisibleComponent("#odvCardShiftOutAlert label", false);
                }
                // End validate

                if (!(aCardTypeCode.length == 0) && !(aCardNumberCode.length == 0)) {
                    JSxCardShiftOutInsertDataToTemp(aCardNumberCode, aCardTypeCode, [], "between");
                    return;
                }

                if (!(aCardTypeCode.length == 0) || !(aCardNumberCode.length == 0)) {
                    console.log("Or");

                    if (!(aCardTypeCode.length == 0)) {
                        JSxCardShiftOutInsertDataToTemp([], aCardTypeCode, [], "between");
                        return;
                    }

                    if (!(aCardNumberCode.length == 0)) {
                        JSxCardShiftOutInsertDataToTemp(aCardNumberCode, [], [], "between");
                        return;
                    }
                }

            }

            // เช็คนำเข้าข้อมูลตารางแบบไฟล์ Excel
            if ($('input[name=orbCardShiftOutSourceMode]:checked').val() == "file") {
                console.log('File type');
                $("#obtSubmitCardShiftOutSearchCardForm").trigger("click");
            }
            JSxCardShiftOutSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftOutSetDataSourceFilter Error: ", err);
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
    function JSxCardShiftOutVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftOutFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftOutRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftOutAlert label", false);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftOutFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftOutRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftOutAlert label", false);
            }
            JSxCardShiftOutSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftOutVisibleDataSourceMode Error: ", err);
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
    function JSxCardShiftOutSetImportFile(poElement, poEvent) {
        try {
            console.log('Import run');
            var oFile = $(poElement)[0].files[0];
            $("#oetCardShiftOutFileTemp").val(oFile.name);
        } catch (err) {
            console.log("JSxCardShiftOutSetImportFile Error: ", err);
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
    function JSxCardShiftOutImportFileValidate() {
        console.log("Import file validate");
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oefCardShiftOutImport: {
                        required: true,
                        extensionValidate: 'xls|xlsx',
                        fileSizeValidate: '100' // unit mb
                    }
                },
                messages: {
                    oefCardShiftOutImport: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                        extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                        fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                    }
                },
                submitHandler: function(form) {
                    $('#odvCardShiftOutModalImportFileConfirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#odvCardShiftOutModalImportFileConfirm').modal('show');
                    $('#osmCardShiftOutBtnImportFileConfirm').one('click', function(evt) {
                        $('#odvCardShiftOutModalImportFileConfirm').modal('hide');
                        // let aNotInCardCode = JStCardShiftOutGetCardCodeTemp() == "" ? [] : JStCardShiftOutGetCardCodeTemp().split(",");
                        JSvCardShiftOutDataSourceTableByFile("", false, "1", true, false, [], "3");
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
            console.log("JSxCardShiftOutImportFileValidate Error: ", err);
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
    function JSxCardShiftOutSetCountNumber() {
        try {
            var tCountAll = $("#ohdCardShiftOutCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            $("#oetCardShiftOutCountNumber").val("");
            $("#oetCardShiftOutCountNumber").val(tResult);
            $("#ospCardShiftOutDataSourceCount").text("");
            $("#ospCardShiftOutDataSourceCount").text(tResult);
        } catch (err) {
            console.log("JSxCardShiftOutSetCountNumber Error: ", err);
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
     * @param {string} ptStaType
     * @param {string} ptDocNo
     * @return {view} html
     * Creator : 08/10/2018 piya
     * Last Modified : -
     */
    function JSvCardShiftOutDataSourceTable(pnPage, paCardCode, paCardTypeCodeRange, paCardCodeRange, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftOutDataSearch').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                console.log("ptStaShift: ", ptStaShift);
                $.ajax({
                    type: "POST",
                    url: "cardShiftOutDataSourceTable",
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
                        tDocNo: ptDocNo,
                        tIsTemp: pbIsTemp == true ? "1" : "0",
                        tIsDataOnly: pbIsDataOnly == true ? "1" : "0",
                        tStaType: ptStaType, // 1: Approve 2: Document status cancel
                        tStaPrcDoc: $("#ohdCardShiftOutCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftOutCardStaDoc").val(),
                        tLastIndex: JCNnCardShiftOutCountDataSourceRow(["pending", "n/a", "notfound", "fail"])
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            console.log("typeof: ", JSON.parse(tResult));
                            let oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftOutAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftOutAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }
                        } catch (err) {}

                        if (tResult != "") {
                            $('#odvCardShiftOutDataSource').html(tResult);
                            JSxCardShiftOutSetHeightDataSourceTable();
                        }
                        JSxCardShiftOutSetCountNumber();
                        JSxCardShiftOutSetCardCodeTemp();
                        JSxCMNVisibleComponent("#odvCardShiftOutAlert label", false);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftOutDataSourceTable Error: ', err);
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
    function JSvCardShiftOutDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetSearchAll').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }

                JCNxOpenLoading();
                var oFormData = new FormData();
                var oFile = $('#oefCardShiftOutImport')[0].files[0];
                oFormData.append('oefCardShiftOutImport', oFile);
                oFormData.append('tSearchAll', tSearchAll);
                oFormData.append('nPageCurrent', nPageCurrent);
                oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
                oFormData.append('tStaShift', ptStaShift);
                oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
                oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
                oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
                oFormData.append('tStaPrcDoc', $("#ohdCardShiftOutCardStaPrcDoc").val());
                oFormData.append('tStaDoc', $("#ohdCardShiftOutCardStaDoc").val());
                oFormData.append('tLastIndex', JCNnCardShiftOutCountDataSourceRow(["complete", "pending", "n/a"]));
                oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
                oFormData.append('aFile', oFile);
                oFormData.append('tBchCode', $("#oetBCHCode_CardShiftOutAdd").val());

                var tDocNo = $('#oetCardShiftOutCode').val();
                if (tDocNo == '' || tDocNo == null) {
                    var tDocNo = '-';
                }
                oFormData.append('tDocNo', tDocNo);
                $.ajax({
                    type: "POST",
                    url: "cardShiftOutDataSourceTableByFile",
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
                                JSvCardShiftOutDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                            } else {
                                JCNxCloseLoading();
                            }
                        } catch (err) {
                            console.log('JSvCardShiftOutDataSourceTableByFile Error: ', err);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftOutDataSourceTableByFile Error: ', err);
        }
    }

    /**
     * Functionality : Search data in table
     * Parameters : -
     * Creator : 11/10/2018 piya
     * Last Modified : 27/12/2018 Supawat
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutSearchDataSourceTable() {
        JSvCardShiftOutDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutSetHeightDataSourceTable() {
        // let nLeftContainerHeight = $(".xWLeftContainer").height();
        // $("#odvCardShiftOutDataSource .table-responsive").height(nLeftContainerHeight-147);
    }

    /**
     * Functionality : Delete Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutDataSourceDeleteOperator(poElement, poEvent) {
        try {
            if (JSbCardShiftOutIsApv() || JSbCardShiftOutIsStaDoc("cancel")) {
                return;
            }
            if (confirm('Delete. ?')) {
                $(poElement) // Delete Itseft Record.
                    .parents('.otrCardShiftOutDataSource')
                    .addClass('hidden');
                JSxCardShiftOutSetCountNumber();
                JSxCardShiftOutSetCardCodeTemp();
            }
        } catch (err) {
            console.log('JSxCardShiftOutDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : Count row in table
     * Parameters : paRowType is ["pending", "complete", "cancel", "n/a", "notfound", "fail"]
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Row count
     * Return Type : number
     */
    function JCNnCardShiftOutCountDataSourceRow(paRowType) {
        try {
            var tCountAll = $("#ohdCardShiftOutCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            return tResult;
        } catch (err) {
            console.log('JCNnCardShiftOutCountDataSourceRow Error: ', err);
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
    function JCNbCardShiftOutCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                var nRow = $('#otbCardShiftOutDataSourceList > tr').not('.hidden').not('#otrCardShiftOutNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            console.log('JCNbCardShiftOutCheckTypeDataSourceRow Error: ', err);
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
    function JSbCardShiftOutIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftOutStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftOutIsStaDelQname Error: ", err);
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
    function JSbCardShiftOutIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftOutCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftOutIsStaApv Error: ", err);
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
    function JSxCardShiftOutStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Empty record check
            if (JCNnCardShiftOutCountDataSourceRow(["complete", "pending", "n/a", "cancel", "notfound", "fail"]) == 0) {
                $("#odvCardShiftOutModalEmptyCardAlert").modal("show");
                return;
            }

            if (pbIsConfirm) {
                console.log("StaApvDoc Run");
                $("#ohdCardShiftOutCardStaPrcDoc").val(2); // Set status for pending approve
                console.log("Data form: ", $('#ofmAddCardShiftOutMainForm').serialize());
                $("#odvCardShiftOutPopupApv").modal('hide');
                JSxCMNVisibleComponent("#ospCardShiftOutApvName", true);
                var aCardCode = JSaCardShiftOutGetDataSourceCode(false);
                $.ajax({
                    type: "POST",
                    url: "cardShiftOutEventUpdateApvDocAndCancelDoc",
                    data: $('#ofmAddCardShiftOutMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
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
                        JSxCardShiftOutGetProgressAfterApvDoc();
                        JSxCardShiftOutActionAfterApv();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                console.log("StaApvDoc Call Modal");
                $("#odvCardShiftOutPopupApv").modal('show');
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
    function JSxCardShiftOutGetProgressAfterApvDoc(){
        // Document variable
        var tLangCode = $("#ohdCardShiftOutLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftOutUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftOutApvCode").val();
        var tUsrCode = $("#ohdCardShiftOutUsrCode").val();
        var tDocNo = $("#oetCardShiftOutCode").val();
        var tPrefix = 'RESPICKUP';
        var tStaDelMQ = $("#ohdCardShiftOutApvCode").val();
        var tStaApv = $("#ohdCardShiftOutApvCode").val();
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
            tCallPageEdit: 'JSvCardShiftOutCallPageCardShiftOutEdit',
            tCallPageList: 'JSvCardShiftOutCallPageCardShiftOut'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TFNTCrdShiftHD",
            ptDocFieldDocNo: "FTXshDocNo",
            ptDocFieldStaApv: "FTXshStaApv",
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
    function JSxCardShiftOutStaDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            if (pbIsConfirm) {
                console.log("StaDoc Run");
                if (($("#ohdCardShiftOutCardStaPrcDoc").val() == "")) { // Pending approve status
                    $("#ohdCardShiftOutCardStaDoc").val(3); // Set status for cancel document
                    console.log("Data form: ", $('#ofmAddCardShiftOutMainForm').serialize());
                    $("#odvCardShiftOutPopupStaDoc").modal('hide');
                    var aCardCode = JSaCardShiftOutGetDataSourceCode(false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftOutEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftOutMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            console.log("StaDoc: ", tResult);
                            JSvCardShiftOutCallPageCardShiftOutEdit($("#oetCardShiftOutCode").val());
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            } else {
                console.log("StaDoc Call Modal");
                $("#odvCardShiftOutPopupStaDoc").modal('show');
            }
        } else {
            JCNxShowMsgSessionExpired();
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
    function JSbCardShiftOutIsApv() {
        var bStatus = false;
        if (($("#ohdCardShiftOutCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftOutCardStaPrcDoc").val() == "2")) {
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
    function JSbCardShiftOutIsStaDoc(ptStaType) {
        var bStatus = false;
        if (ptStaType == "complete") {
            if ($("#ohdCardShiftOutCardStaDoc").val() == "1") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "incomplete") {
            if ($("#ohdCardShiftOutCardStaDoc").val() == "2") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "cancel") {
            if ($("#ohdCardShiftOutCardStaDoc").val() == "3") {
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
    function JSxCardShiftOutActionAfterApv() {
        if (JCNbCardShiftOutIsUpdatePage()) {
            if (JSbCardShiftOutIsApv() || JSbCardShiftOutIsStaDoc("cancel")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftOutBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftOutBtnCancelApv", false);
                $("#oetCardShiftOutDocDate").attr("disabled", true);
                $(".xCNBtnDateTime").attr("disabled", true);
                if (JSbCardShiftOutIsApv()) {
                    JSxCMNVisibleComponent("#ospCardShiftOutApvName", true);
                }
                if (JSbCardShiftOutIsStaDoc("cancel")) {
                    JSxCMNVisibleComponent("#ospCardShiftOutApvName", false);
                }
                JSxCMNVisibleComponent("#obtCardShiftOutBtnSave", false);
            } else {
                console.log("Show Apv");
                $("#oetCardShiftOutDocDate").attr("disabled", false);
                JSxCMNVisibleComponent("#obtCardShiftOutBtnApv", true);
                JSxCMNVisibleComponent("#obtCardShiftOutBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftOutApvName", false);
                JSxCMNVisibleComponent("#obtCardShiftOutBtnSave", true);
            }

            if (!JSbCardShiftOutIsApv() && JSbCardShiftOutIsStaDoc("incomplete")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftOutBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftOutBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftOutApvName", false);
            }
        }

        if (JCNbCardShiftOutIsCreatePage()) {
            JSxCMNVisibleComponent("#obtCardShiftOutBtnSave", true);
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
    function JSxCardShiftOutPrint() {
        var tUsrBchCode = $("#ohdCardShiftOutUsrBchCode").val();
        var tDocNo      = $("#oetCardShiftOutCode").val();
        var aInfor = [
			{"Lang"         : '<?php echo FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?= $tUserBchCode; ?>'}
		];
        window.open("<?php echo base_url(); ?>formreport/Frm_SQL_FCCardWithdrawCash?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    /**
     * Functionality : Update Card on document temp
     * Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
     * Creator : 04/01/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutUpdateDataOnTemp(ptCardCode, pnSeq, pnPage, ptRmk) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftOutUpdateInlineOnTemp",
                    data: {
                        tCardCode: ptCardCode,
                        nSeq: pnSeq,
                        tRmk: ptRmk
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success: ", tResult);
                        try {
                            JSvCardShiftOutDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
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
     * Functionality : Insert Card to document temp
     * Parameters : paRangeCardCode, paRangeCardType, paCardCode, ptInsertType is "between", "shoose"
     * Creator : 07/01/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutInsertDataToTemp(paRangeCardCode, paRangeCardType, paCardCode, ptInsertType) {

        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftOutInsertToTemp",
                    data: {
                        tRangeCardCode: JSON.stringify(paRangeCardCode),
                        tRangeCardType: JSON.stringify(paRangeCardType),
                        tCardCode: JSON.stringify(paCardCode),
                        tInsertType: ptInsertType,
                        tDocNo: $('#oetCardShiftOutCode').val(),
                        tBCHCode: $('#oetBCHCode_CardShiftOutAdd').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success: ", tResult);
                        try {
                            JSvCardShiftOutDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
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
            console.log("JSxCardShiftOutInsertDataToTemp Error: ", err);
        }
    }
</script>

<?php include 'jCardShiftOutDataSourceTable.php'; ?>

<script>
    //เลือกสาขา วัฒน์ 13/08/2020
    $("#obtBrowseBCH_CardShiftOutAdd").click(function() {
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
                Value: ["oetBCHCode_CardShiftOutAdd", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_CardShiftOutAdd", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_CardShiftOutAdd',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });

    function JSxSetConfigBCH_CardShiftOutAdd(params) {
        if (params == 'NULL') {
            var tValue = '';
            $('#oetBCHName_CardShiftOutAdd').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftOutUsrBchCode').val(tValue);
    }

    //ค้นหาการ์ดแบบยิงบาร์โค็ด
    function JSxCardShiftOutScanner() {
      var nCountNumber  = 0;
      if ($("#oetCardShiftOutCountNumber").val()=="" || $("#oetCardShiftOutCountNumber").val()=="0") {
        nCountNumber  = 0;
      }else {
        nCountNumber  = parseInt($("#oetCardShiftOutCountNumber").val());
      }

      //ถ้าไม่ได้กรอกข้อมูล หรือกรอกข้อมูลแล้วข้อมูล
      if($('#oetCardShiftOutDataScannerID').val() == ''){
        $('#oetCardShiftOutDataScannerID').focus();
        return;
      }else if($("#oetCardShiftOutDataScannerID").val() != '') {
        $.ajax({
            type    : "POST",
            url     : "cardShiftOutEventScanner",
            data    : { tScannerID : $('#oetCardShiftOutDataScannerID').val() , nCountNumber:nCountNumber},
            cache   : false,
            timeout : 0,
            success : function(tResult) {
              var aData = JSON.parse(tResult);
              if (aData['rtCode']=='1') {
                var aCardCode = [];
                aCardCode.push(aData['raItems'][0]['FTCrdCode']);
                JSxCardShiftOutSetDataSource(aCardCode);
                $("#oetCardShiftOutDataScannerID").val("");
              }else{
                if (aData['rtCode'] == '801'){
                    var tTextError = '<?=language('common/main/main','tDataDuplicate')?>';
                }else{
                    var tTextError = '<?=language('common/main/main','tMainRptNotFoundDataInDB')?>';
                }

                FSvCMNSetMsgErrorDialog(tTextError);
                $('#oetCardShiftOutDataScannerID').val('');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
            }
        });
      }
    }
</script>
