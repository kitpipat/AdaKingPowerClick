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

        $('#oimCardShiftTopUpBrowseProvince').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oPvnOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftTopUpFromCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftTopUpBrowseFromCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#oimCardShiftTopUpToCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftTopUpBrowseToCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $("#oimCardShiftTopUpFromCardNumber, #oimCardShiftTopUpToCardNumber, #obtCardShiftTopUpAddDataSource").on("click", function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.CardShiftTopUpGetCardCodeTemp = JStCardShiftTopUpGetCardCodeTemp();
                console.log("Card In Temp: ", JStCardShiftTopUpGetCardCodeTemp());
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#oimCardShiftTopUpFromCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftTopUpBrowseFromCardNumberOption = oCardShiftTopUpBrowseFromCardNumber(CardShiftTopUpGetCardCodeTemp);
                JCNxBrowseData('oCardShiftTopUpBrowseFromCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftTopUpToCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftTopUpBrowseToCardNumberOption = oCardShiftTopUpBrowseToCardNumber(CardShiftTopUpGetCardCodeTemp);
                JCNxBrowseData('oCardShiftTopUpBrowseToCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtCardShiftTopUpAddDataSource').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftTopUpBrowseAddDataSourceOption = oCardShiftTopUpBrowseAddDataSource(CardShiftTopUpGetCardCodeTemp);
                JCNxBrowseData('oCardShiftTopUpBrowseAddDataSourceOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        if (JCNbCardShiftTopUpIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftTopUpCode").attr("readonly", true);
            $("#odvCardShiftTopUpAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftTopUpAutoGenCode', false);

            JSxCMNVisibleComponent('#obtCardShiftTopUpBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftTopUpBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftTopUpBtnDocMa', true);
        }

        if (JCNbCardShiftTopUpIsCreatePage()) {
            // Doc No
            $("#oetCardShiftTopUpCode").attr("disabled", true);
            $('#ocbCardShiftTopUpAutoGenCode').change(function() {
                if ($('#ocbCardShiftTopUpAutoGenCode').is(':checked')) {
                    $("#oetCardShiftTopUpCode").attr("disabled", true);
                    $('#odvCardShiftTopUpDocNoForm').removeClass('has-error');
                    $('#odvCardShiftTopUpDocNoForm em').remove();
                } else {
                    $("#oetCardShiftTopUpCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftTopUpAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftTopUpBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftTopUpBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftTopUpBtnDocMa', false);

            JSvCardShiftTopUpDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftTopUpIsUpdatePage()) {
            $("#obtGenCodeCardShiftTopUp").attr("disabled", true);
            let tDocNo = $("#oetCardShiftTopUpCode").val();
            <?php if (!empty($aCardCode)) : ?>
                <?php if ($aResult["raItems"]["rtCardShiftTopUpStaDoc"] == "3") : // Cancel
                ?>
                    JSvCardShiftTopUpDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "1", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftTopUpStaPrcDoc"] == "1") : // Approved
                    ?>
                        //console.log("")
                        JSvCardShiftTopUpDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "3", false, false, [], "1", tDocNo);
                    <?php else : // Pending
                    ?>
                        JSvCardShiftTopUpDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "1", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftTopUpDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftTopUpApvCode").val();
        var tUsrCode = $("#ohdCardShiftTopUpUsrCode").val();

        if ((JCNbCardShiftTopUpIsUpdatePage() && JSbCardShiftTopUpIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftTopUpGetProgressAfterApvDoc();
        }

        JSxCardShiftTopUpSetCardCodeTemp();
        //console.log("GetCardCodeTemp Init: ", JStCardShiftTopUpGetCardCodeTemp());
        JSxCardShiftTopUpActionAfterApv();
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
    var oCardShiftTopUpBrowseFromCardType = {
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
            Value: ["oetCardShiftTopUpFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftTopUpFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        NextFunc: {
            FuncName: 'JSxCSTAddSetCodeTypeCard',
            ArgReturn: ['FTCtyName', 'FTCtyCode']
        },
        // RouteFrom : 'cardShiftTopUp',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftTopUpBrowseType
    };

    function JSxCSTAddSetCodeTypeCard(poData) {



        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftTopUpToCardTypeName').val(aData[0]);
            $('#oetCardShiftTopUpToCardTypeCode').val(aData[1]);
        } else {
            $('#oetCardShiftTopUpToCardTypeName').val('');
            $('#oetCardShiftTopUpToCardTypeCode').val('');
        }

    }

    var oCardShiftTopUpBrowseToCardType = {
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
            Value: ["oetCardShiftTopUpToCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftTopUpToCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTCtyCode']
        },*/
        // RouteFrom : 'cardShiftTopUp',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftTopUpBrowseType
    };

    var oCardShiftTopUpBrowseFromCardNumber = function(ptNotCardCode) {
        var nFromCard = $('#oetCardShiftTopUpFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftTopUpToCardTypeCode').val();

        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCard.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
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
                Condition: ["AND TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaPay = '1' AND ((TFNMCard.FTCrdStaShift = '2' AND TFNMCardType.FTCtyStaShift = '1') OR TFNMCardType.FTCtyStaShift = '2') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn + tWhereInCard + tWhereCardByAgenCode]
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
                Value: ["oetCardShiftTopUpFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftTopUpFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeNumberCard',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftTopUp',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftTopUpBrowseType
        };
        return oOptions;
    };

    function JSxCSTAddSetCodeNumberCard(poData) {

        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftTopUpToCardNumberCode').val(aData[0]);
            $('#oetCardShiftTopUpToCardNumberName').val(aData[0]);
        } else {
            $('#oetCardShiftTopUpToCardNumberCode').val('');
            $('#oetCardShiftTopUpToCardNumberName').val('');
        }

    }

    var oCardShiftTopUpBrowseToCardNumber = function(ptNotCardCode) {
        var nFromCard = $('#oetCardShiftTopUpFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftTopUpToCardTypeCode').val();

        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCard.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
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
                Condition: ["AND TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaPay = '1' AND ((TFNMCard.FTCrdStaShift = '2' AND TFNMCardType.FTCtyStaShift = '1') OR TFNMCardType.FTCtyStaShift = '2') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn + tWhereInCard + tWhereCardByAgenCode]
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
                Value: ["oetCardShiftTopUpToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftTopUpToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftTopUp',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftTopUpBrowseType
        };
        return oOptions;
    };

    //ปุ่ม + บนขวา
    var oCardShiftTopUpBrowseAddDataSource = function(ptNotCardCode) {
        //console.log("Not Card Code: ", ptNotCardCode);
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
                Condition: ["AND TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaPay = '1' AND ((TFNMCard.FTCrdStaShift = '2' AND TFNMCardType.FTCtyStaShift = '1') OR TFNMCardType.FTCtyStaShift = '2') AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn + tWhereCardByAgenCode]
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
                FuncName: 'JSxCardShiftTopUpSetDataSource',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftTopUp',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftTopUpBrowseType
        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/
    var bUniqueCardShiftTopUpCode;
    $.validator.addMethod(
        "uniqueCardShiftTopUpCode",
        function(tValue, oElement, aParams) {
            let tCardShiftTopUpCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftTopUpUniqueValidate/cardShiftTopUpCode",
                data: "tCardShiftTopUpCode=" + tCardShiftTopUpCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftTopUpCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    //console.log('Custom validate uniqueCardShiftTopUpCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftTopUpCode;
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
                //console.log('Extension invalid');
                bExtensionValidate = false;
            } else {
                //console.log('Extension valid');
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
     * Functionality : (event) Add/Edit CardShiftTopUp
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftTopUpAddEditCardShiftTopUp(ptRoute) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                if (JCNnCardShiftTopUpCountDataSourceRow() == 0) { // Check Card Empty
                    FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                    return;
                }

                // From Validate
                $('#ofmAddCardShiftTopUpMainForm').validate({
                    rules: {
                        oetCardShiftTopUpCode: {
                            required: true,
                            uniqueCardShiftTopUpCode: JCNbCardShiftTopUpIsCreatePage(),
                            maxlength: 20
                        },
                        oetCardShiftTopUpDocDate: {
                            required: true
                        }
                        /*oetCardShiftTopUpCardValue: {
                            required: true,
                            digits: true
                        }*/
                    },
                    messages: {
                        oetCardShiftTopUpCode: {
                            required: "<?php echo language('document/card/cardtopup', 'tValidCardShifTopUp'); ?>",
                            uniqueCardShiftTopUpCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                            maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"

                        }
                        // oetCardShiftTopUpName: ""
                    },
                    submitHandler: function(form) {
                        var aCardCode = JSaCardShiftTopUpGetDataSourceCode(false);
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: $('#ofmAddCardShiftTopUpMainForm').serialize() + "&" + $('#ofmCardValue').serialize() + "&aCardCode=" + JSON.stringify(aCardCode) + "&aValue=" + $('#ohdCardShiftTopUpCountRowFromTemp').val(),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                try {
                                    var oResult = JSON.parse(tResult);
                                    if (oResult.nStaEvent == '1') {
                                        JSvCardShiftTopUpCallPageCardShiftTopUpEdit(oResult.tCodeReturn);
                                    } else {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    }
                                } catch (err) {}
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
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
            console.log("JSnCardShiftTopUpAddEditCardShiftTopUp Error: ", err);
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
    function JSaCardShiftTopUpGetDataSourceCode(pbWrapText) {
        try {
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;

            // Set data
            var aData = [];

            let oRecord = JSON.parse(($("#ospCardShiftTopUpCardCodeTemp").text() == "") ? "[]" : $("#ospCardShiftTopUpCardCodeTemp").text());
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
            console.log("JSaCardShiftTopUpGetDataSourceCode Error: ", err);
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
    function JSxCardShiftTopUpSetCardCodeTemp() {
        try {
            $("#ohdCardShiftTopUpCardCodeTemp").val("");
            setTimeout(function() {
                $("#ohdCardShiftTopUpCardCodeTemp").val(JSaCardShiftTopUpGetDataSourceCode(true).toString());
            }, 800);
        } catch (err) {
            console.log("JSxCardShiftTopUpSetCardCodeTemp Error: ", err);
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
    function JStCardShiftTopUpGetCardCodeTemp() {
        try {
            return $("#ohdCardShiftTopUpCardCodeTemp").val();
        } catch (err) {
            console.log("JStCardShiftTopUpGetCardCodeTemp Error: ", err);
        }
    }

    /**
     * Functionality : Next Funct ของปุ่ม + บนขวา
     * Parameters : {params}
     * Creator : dd/mm/yyyy piya
     * Last Modified : -
     * Return : {return}
     * Return Type : {type}
     */
    function JSxCardShiftTopUpSetDataSource(ptCardCode) {
        $('#testName').val('');
        $('#testCode').val('');
        try {
            //console.log("JSxCardShiftTopUpSetDataSource: ", ptCardCode.filter(Boolean));
            if (ptCardCode.filter(Boolean).length < 1) {
                JSvCardShiftTopUpDataSourceTable("", [], [], [], true, "1", true, false, [], "1", "");
                return;
            }

            var aCardCode = [];
            $.each(ptCardCode.filter(Boolean), function(nIndex, tValue) {
                var tCode = "'"+tValue+"'";
                // tCode = tCode.replace('["', "'");
                // tCode = tCode.replace('"]', "'");
                aCardCode[nIndex] = tCode;
            });
            JSxCardShiftTopUpInsertDataToTemp(aCardCode);
        } catch (err) {
            console.log("JSxCardShiftTopUpSetDataSource Error: ", err);
        }
    }

    /**
     * Functionality : Insert Card to document temp by choose
     * Parameters : paRangeCardCode, paRangeCardType, paCardCode, ptInsertType is "between", "shoose"
     * Creator : 07/01/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpInsertDataToTemp(aCardCode) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpInsertToTemp",
                    data: {
                        tInsertType: 'choose',
                        tCard: JSON.stringify(aCardCode),
                        tValue: $('#oetCardShiftTopUpCardValue').val(),
                        tDocNo: $('#oetCardShiftTopUpCode').val(),
                        tBCHCode: $('#oetBCHCode_cardShiftTopUp').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JSvCardShiftTopUpDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftTopUpInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : Insert Card to document temp by between
     * Parameters : paRangeCardCode, paRangeCardType, paCardCode, ptInsertType is "between", "shoose"
     * Creator : 07/01/2019 Wasin(Yoshi)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpInsertDataToTempBetween(paRangeCardCode, paRangeCardType, paCardCode, ptInsertType) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpInsertToTemp",
                    data: {
                        tInsertType: 'between',
                        tRangeCardCode: JSON.stringify(paRangeCardCode),
                        tRangeCardType: JSON.stringify(paRangeCardType),
                        tCardCode: JSON.stringify(paCardCode),
                        tValue: $('#oetCardShiftTopUpCardValue').val(),
                        tDocNo: $('#oetCardShiftTopUpCode').val(),
                        tBCHCode: $('#oetBCHCode_cardShiftTopUp').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JSvCardShiftTopUpDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.log(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftTopUpInsertDataToTemp Error: ", err);
        }
    }


    /**
     * Functionality : Control select insert to temp by file or range
     * Parameters : -
     * Creator : 16/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpSetDataSourceFilter() {
        try {
            //console.log("Set Data Source");
            if ($('input[name=orbCardShiftTopUpSourceMode]:checked').val() == "range") {
                //console.log('Range type');
                let tCardTypeCodeFrom = $('#oetCardShiftTopUpFromCardTypeCode').val();
                let tCardTypeCodeTo = $('#oetCardShiftTopUpToCardTypeCode').val();
                let tCardNumberCodeFrom = $('#oetCardShiftTopUpFromCardNumberCode').val();
                let tCardNumberCodeTo = $('#oetCardShiftTopUpToCardNumberCode').val();
                //console.log("Empty: ", tCardTypeCodeFrom);
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

                // Begin validate
                if ((aCardTypeCode.length == 0) && (aCardNumberCode.length == 0)) {
                    JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label", false);
                    JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label.xWCheckCondition", true);
                } else {
                    JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label", false);
                }
                // End validate

                if (!(aCardTypeCode.length == 0) && !(aCardNumberCode.length == 0)) {
                    JSxCardShiftTopUpInsertDataToTempBetween(aCardNumberCode, aCardTypeCode, [], "between");
                    return;
                }
                if (!(aCardTypeCode.length == 0) || !(aCardNumberCode.length == 0)) {
                    //console.log("Or");
                    if (!(aCardTypeCode.length == 0)) {
                        JSxCardShiftTopUpInsertDataToTempBetween([], aCardTypeCode, [], "between");
                        return;
                    }
                    if (!(aCardNumberCode.length == 0)) {
                        JSxCardShiftTopUpInsertDataToTempBetween(aCardNumberCode, [], [], "between");
                        return;
                    }
                }
            }
            if ($('input[name=orbCardShiftTopUpSourceMode]:checked').val() == "file") {
                //console.log('File type');
                $("#obtSubmitCardShiftTopUpSearchCardForm").trigger("click");
            }
            JSxCardShiftTopUpSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftTopUpSetDataSourceFilter Error: ", err);
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
    function JSxCardShiftTopUpVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftTopUpFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftTopUpRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label", false);
                JSxCardShiftOutVisibleComponent("#oahCardShiftTopUpDataLoadMask", true);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftTopUpFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftTopUpRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label", false);
                JSxCardShiftOutVisibleComponent("#oahCardShiftTopUpDataLoadMask", false);
            }
            JSxCardShiftTopUpSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftTopUpVisibleDataSourceMode Error: ", err);
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
    function JSxCardShiftTopUpSetImportFile(poElement, poEvent) {
        try {
            //console.log('Import run');
            let oFile = $(poElement)[0].files[0];
            $("#oetCardShiftTopUpFileTemp").val(oFile.name);
            //console.log(oFile);
        } catch (err) {
            console.log("JSxCardShiftTopUpSetImportFile Error: ", err);
        }
    }

    /**
     * Functionality : มูลค่าที่เหลือ
     * Parameters : ptCountNumber
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpSetCountNumber() {
        try {
            let nRows = JCNnCardShiftTopUpCountDataSourceRow(["complete", "pending", "n/a", "cancel", "notfound", "fail"]);
            //var nRows = $('#ohdCardShiftTopUpCountRowFromTemp').val();
            $("#oetCardShiftTopUpCountNumber").val("");
            $("#oetCardShiftTopUpCountNumber").val(nRows);
            $("#ospCardShiftTopUpDataSourceCount").text("");
            $("#ospCardShiftTopUpDataSourceCount").text(nRows);
        } catch (err) {
            console.log("JSxCardShiftTopUpSetCountNumber Error: ", err);
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
    function JSxCardShiftTopUpImportFileValidate() {
        //console.log("Import file validate");
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oefCardShiftTopUpImport: {
                        required: true,
                        extensionValidate: 'xls|xlsx',
                        fileSizeValidate: '100' // unit mb
                    }
                },
                messages: {
                    oefCardShiftTopUpImport: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                        extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                        fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                    }
                },
                submitHandler: function(form) {
                    $('#odvCardShiftTopUpModalImportFileConfirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#odvCardShiftTopUpModalImportFileConfirm').modal('show');
                    $('#osmCardShiftTopUpBtnImportFileConfirm').one('click', function(evt) {
                        $('#odvCardShiftTopUpModalImportFileConfirm').modal('hide');
                        // let aNotInCardCode = JStCardShiftOutGetCardCodeTemp() == "" ? [] : JStCardShiftOutGetCardCodeTemp().split(",");
                        JSvCardShiftTopUpDataSourceTableByFile("", false, "1", true, false, [], "3");
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
            console.log("JSxCardShiftTopUpImportFileValidate Error: ", err);
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
    function JSvCardShiftTopUpDataSourceTable(pnPage, paCardCode, paCardTypeCodeRange, paCardCodeRange, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo) {

        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftTopUpDataSearch').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpDataSourceTable",
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
                        tStaPrcDoc: $("#ohdCardShiftTopUpCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftTopUpCardStaDoc").val(),
                        tDocNo: $("#oetCardShiftTopUpCode").val(),
                        tLastIndex: JCNnCardShiftTopUpCountDataSourceRow(["pending", "n/a", "notfound", "fail"])
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JCNxCloseLoading();

                        try {
                            let oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }
                        } catch (err) {

                        }

                        if (tResult != "") {
                            $('#odvCardShiftTopUpDataSource').html(tResult);
                            JSxCardShiftTopUpSetHeightDataSourceTable();
                        }

                        JSxCardShiftTopUpSetCountNumber();
                        JSxCardShiftTopUpSetCardCodeTemp();
                        //JSxCardShiftTopUpSetTotalVat(100);
                        JSxCMNVisibleComponent("#odvCardShiftTopUpAlert label", false);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftTopUpDataSourceTable Error: ', err);
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
    function JSvCardShiftTopUpDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
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
                let oFile = $('#oefCardShiftTopUpImport')[0].files[0];
                oFormData.append('oefCardShiftTopUpImport', oFile);
                oFormData.append('tSearchAll', tSearchAll);
                oFormData.append('nPageCurrent', nPageCurrent);
                oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
                oFormData.append('tStaShift', ptStaShift);
                oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
                oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
                oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
                oFormData.append('tStaPrcDoc', $("#ohdCardShiftTopUpCardStaPrcDoc").val());
                oFormData.append('tStaDoc', $("#ohdCardShiftTopUpCardStaDoc").val());
                oFormData.append('tLastIndex', JCNnCardShiftTopUpCountDataSourceRow(["complete", "pending", "n/a"]));
                oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
                oFormData.append('aFile', oFile);
                oFormData.append('tBchCode', $("#oetBCHCode_cardShiftTopUp").val());

                var tDocNo = $('#oetCardShiftTopUpCode').val();
                if (tDocNo == '' || tDocNo == null) {
                    var tDocNo = '-';
                }
                oFormData.append('tDocNo', tDocNo);

                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpDataSourceTableByFile",
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
                                JSvCardShiftTopUpDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                            } else {
                                JCNxCloseLoading();
                            }
                        } catch (err) {
                            console.log('JSvCardShiftNewCardDataSourceTableByFile Error: ', err);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftTopUpDataSourceTableByFile Error: ', err);
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
    function JSxCardShiftTopUpSearchDataSourceTable() {
        JSvCardShiftTopUpDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpSetHeightDataSourceTable() {
        /*try{
            let nLeftContainerHeight = $(".xWLeftContainer").height();
            $("#odvCardShiftTopUpDataSource .table-responsive").height(nLeftContainerHeight-177);
        }catch(err){
            console.log("JSxCardShiftTopUpSetHeightDataSourceTable Error: ", err);
        }*/
    }

    /**
     * Functionality : Count row in table
     * Parameters : paRowType is ["pending", "complete", "cancel", "n/a", "notfound", "fail"]
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Row count
     * Return Type : number
     */
    function JCNnCardShiftTopUpCountDataSourceRow(paRowType) {
        try {
            var tCountAll = $("#ohdCardShiftTopUpCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            return tResult;
        } catch (err) {
            console.log('JCNnCardShiftTopUpCountDataSourceRow Error: ', err);
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
    function JCNbCardShiftTopUpCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                let nRow = $('#otbCardShiftTopUpDataSourceList > tr').not('.hidden').not('#otrCardShiftTopUpNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            console.log('JCNbCardShiftTopUpCheckTypeDataSourceRow Error: ', err);
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
    function JSxCardShiftTopUpStaApvDoc(pbIsConfirm) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                // Empty record check
                if ($("#ohdCardShiftTopUpCountRowFromTemp").val() == 0) {
                    $("#odvCardShiftTopUpModalEmptyCardAlert").modal("show");
                    return;
                }

                if (pbIsConfirm) {
                    //console.log("StaApvDoc Run");
                    $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve
                    //console.log("Data form: ", $('#ofmAddCardShiftTopUpMainForm').serialize());
                    $("#odvCardShiftTopUpPopupApv").modal('hide');
                    JSxCMNVisibleComponent("#ospCardShiftTopUpApvName", true);
                    var aCardCode = JSaCardShiftTopUpGetDataSourceCode(false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftTopUpEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftTopUpMainForm').serialize() + "&" + $('#ofmCardValue').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            //console.log(tResult);
                            try {
                                let oResult = JSON.parse(tResult);
                                if (oResult.nStaEvent == "900") {
                                    FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                }
                            } catch (e) {}
                            JSxCardShiftTopUpGetProgressAfterApvDoc();
                            JSxCardShiftTopUpActionAfterApv();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    //console.log("StaApvDoc Call Modal");
                    $("#odvCardShiftTopUpPopupApv").modal('show');
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftTopUpStaApvDoc Error: ", err);
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
    function JSxCardShiftTopUpGetProgressAfterApvDoc(){
        // Document variable
        var tLangCode = $("#ohdCardShiftTopUpLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftTopUpUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftTopUpApvCode").val();
        var tUsrCode = $("#ohdCardShiftTopUpUsrCode").val();
        var tDocNo = $("#oetCardShiftTopUpCode").val();
        var tPrefix = 'RESTOPUP';
        var tStaDelMQ = $("#ohdCardShiftTopUpApvCode").val();
        var tStaApv = $("#ohdCardShiftTopUpApvCode").val();
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
            tCallPageEdit: 'JSvCardShiftTopUpCallPageCardShiftTopUpEdit',
            tCallPageList: 'JSvCardShiftTopUpCallPageCardShiftTopUp'
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
    function JSxCardShiftTopUpStaDoc(pbIsConfirm) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                if (pbIsConfirm) {
                    //console.log("StaDoc Run");
                    if ($("#ohdCardShiftTopUpCardStaPrcDoc").val() == "") { // Pending approve status
                        $("#ohdCardShiftTopUpCardStaDoc").val(3); // Set status for cancel document
                        //console.log("Data form: ", $('#ofmAddCardShiftTopUpMainForm').serialize());
                        $("#odvCardShiftTopUpPopupStaDoc").modal('hide');
                        var aCardCode = JSaCardShiftTopUpGetDataSourceCode(false);
                        $.ajax({
                            type: "POST",
                            url: "cardShiftTopUpEventUpdateApvDocAndCancelDoc",
                            data: $('#ofmAddCardShiftTopUpMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                //console.log("StaDoc: ", tResult);
                                JSvCardShiftTopUpCallPageCardShiftTopUpEdit($("#oetCardShiftTopUpCode").val());
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
                    }
                } else {
                    //console.log("StaDoc Call Modal");
                    $("#odvCardShiftTopUpPopupStaDoc").modal('show');
                }
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftTopUpStaDoc Error: ", err);
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
    function JSbCardShiftTopUpIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftTopUpStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftTopUpIsStaDelQname Error: ", err);
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
    function JSbCardShiftTopUpIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftTopUpCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftTopUpIsProcessApv Error: ", err);
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
    function JSbCardShiftTopUpIsApv() {
        try {
            let bStatus = false;
            if (($("#ohdCardShiftTopUpCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftTopUpCardStaPrcDoc").val() == "2")) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftTopUpIsApv Error: ", err);
        }
    }

    /**
     * Functionality : Check document status
     * Parameters : ptStaType is ("complete", "incomplete", "cancel")
     * Creator : 19/10/2018 piya
     * Last Modified : -
     * Return : Document status
     * Return Type : boolean
     */
    function JSbCardShiftTopUpIsStaDoc(ptStaType) {
        try {
            let bStatus = false;
            if (ptStaType == "complete") {
                if ($("#ohdCardShiftTopUpCardStaDoc").val() == "1") {
                    bStatus = true;
                }
                return bStatus;
            }
            if (ptStaType == "incomplete") {
                if ($("#ohdCardShiftTopUpCardStaDoc").val() == "2") {
                    bStatus = true;
                }
                return bStatus;
            }
            if (ptStaType == "cancel") {
                if ($("#ohdCardShiftTopUpCardStaDoc").val() == "3") {
                    bStatus = true;
                }
                return bStatus;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftTopUpIsStaDoc Error: ", err);
        }
    }

    /**
     * Functionality : Action on document approved
     * Parameters : {params}
     * Creator : 18/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftTopUpActionAfterApv() {
        try {
            if (JCNbCardShiftTopUpIsUpdatePage()) {
                if (JSbCardShiftTopUpIsApv() || JSbCardShiftTopUpIsStaDoc("cancel")) {
                    //console.log("Hide Apv");
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnApv", false);
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnCancelApv", false);
                    $("#oetCardShiftTopUpDocDate").attr("disabled", true);
                    $("#oetCardShiftTopUpCardValue").attr("disabled", true);
                    $(".xCNBtnDateTime").attr("disabled", true);
                    if (JSbCardShiftTopUpIsApv()) {
                        JSxCMNVisibleComponent("#ospCardShiftTopUpApvName", true);
                    }
                    if (JSbCardShiftTopUpIsStaDoc("cancel")) {
                        JSxCMNVisibleComponent("#ospCardShiftTopUpApvName", false);
                    }
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnSave", false);
                } else {
                    //console.log("Show Apv");
                    $("#oetCardShiftTopUpDocDate").attr("disabled", false);
                    $("#oetCardShiftTopUpCardValue").attr("disabled", false);
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnApv", true);
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnCancelApv", true);
                    JSxCMNVisibleComponent("#ospCardShiftTopUpApvName", false);
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnSave", true);
                }

                if (!JSbCardShiftTopUpIsApv() && JSbCardShiftTopUpIsStaDoc("incomplete")) {
                    //console.log("Hide Apv");
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnApv", false);
                    JSxCMNVisibleComponent("#obtCardShiftTopUpBtnCancelApv", true);
                    JSxCMNVisibleComponent("#ospCardShiftTopUpApvName", false);
                }
                JSxCMNVisibleComponent('#obtCardShiftTopUpBtnDocMa', true);
            }

            if (JCNbCardShiftTopUpIsCreatePage()) {
                JSxCMNVisibleComponent("#obtCardShiftTopUpBtnSave", true);
                JSxCMNVisibleComponent('#obtCardShiftTopUpBtnDocMa', false);
            }
        } catch (err) {
            console.log("JSxCardShiftTopUpActionAfterApv Error: ", err);
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
    function JSxCardShiftTopUpSetTotalVat(nDisplayDelay) {
        try {
            $("#otrCardShiftTopUpTotalVat").remove();

            setTimeout(function() {
                if (JCNnCardShiftTopUpCountDataSourceRow(["complete", "pending", "n/a", "cancel"]) > 0) {
                    let tTemplate = $("#oscCardShiftTopUpTotalTopUpTemplate").html();
                    let tCardValue = parseInt($("#oetCardShiftTopUpCardValue").val() == "" ? 0 : $("#oetCardShiftTopUpCardValue").val());
                    let tTotalValue = tCardValue * JCNnCardShiftTopUpCountDataSourceRow(["complete", "pending", "n/a", "cancel", "notfound", "fail"]);
                    let tVat = parseInt($("#ohdCardShiftTopUpVat").val());
                    let tTotalVat = ((tTotalValue * tVat) / 100) + tTotalValue;
                    //console.log("tCardValue: ", tCardValue);
                    //console.log("tTotalValue: ", tTotalValue);
                    //console.log("tVat: ", tVat);
                    //console.log("JCNnCardShiftTopUpCountDataSourceRow: ", JCNnCardShiftTopUpCountDataSourceRow(["complete", "pending", "n/a", "cancel"]));
                    let oData = {
                        totalValue: tTotalValue.toLocaleString() + ".00",
                        vat: tVat,
                        totalVat: tTotalVat.toLocaleString() + ".00"
                    };
                    let tRender = JStCardShiftTopUpRenderTemplate(tTemplate, oData);
                    $("#otbCardShiftTopUpDataSourceList").append(tRender);
                    $("#otrCardShiftTopUpTotalVat").fadeIn(900);
                }
            }, nDisplayDelay);
        } catch (err) {
            console.log("JSxCardShiftTopUpSetTotalVat Error: ", err);
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
    function JStCardShiftTopUpRenderTemplate(tTemplate, tData) {
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
            console.log("JStCardShiftTopUpRenderTemplate Error: ", err);
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
    function JSxCardShiftTopUpPrint() {
        let tLangCode   = $("#ohdCardShiftTopUpLangCode").val();
        let tUsrBchCode = $("#ohdCardShiftTopUpUsrBchCode").val();
        let tDocNo      = $("#oetCardShiftTopUpCode").val();

        var aInfor = [
            {"Lang"         : '<?= FCNaHGetLangEdit(); ?>'},
            {"ComCode"      : '<?= FCNtGetCompanyCode(); ?>'},
            {"BranchCode"   : '<?= FCNtGetAddressBranch($tUserBchCode); ?>' },
            {"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?=$tUserBchCode;?>'}
        ];
        window.open('<?php echo base_url(); ?>' + "formreport/Frm_SQL_FCCardTopUp?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }

    /**
     * Functionality : Check record type exists
     * Parameters : tRecordType is "temp", "pending", "aproved", "docCancel"
     * Creator : 01/11/2018 piya
     * Last Modified : -
     * Return : Exists status
     * Return Type : boolean
     */
    function JStCardShiftTopUpHasRecord(tRecordType) {
        try {
            let bStatus = false;
            if (tRecordType == "temp") {
                let nTempRecordCount = $("#otbCardShiftTopUpDataSourceList tr.xWTemp").length();
                if (nTempRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
            if (tRecordType == "pending") {
                let nPendingRecordCount = $("#otbCardShiftTopUpDataSourceList tr.xWApvPending").length();
                if (nPendingRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
            if (tRecordType == "aproved") {
                let nApvCompleteRecordCount = $("#otbCardShiftTopUpDataSourceList tr.xWApvComplete").length();
                if (nApvCompleteRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
            if (tRecordType == "docCancel") {
                let nDocCancelRecordCount = $("#otbCardShiftTopUpDataSourceList tr.xWDocCancel").length();
                if (nDocCancelRecordCount > 0) {
                    bStatus = true;
                }
                return bStatus;
            }
        } catch (err) {
            console.log("JStCardShiftTopUpHasRecord Error: ", err);
        }
    }
</script>

<?php include 'jCardShiftTopUpDataSourceTable.php'; ?>

<script>
    //เลือกสาขา วัฒน์ 13/08/2020
    $("#obtBrowseBCH_cardShiftTopUp").click(function() {
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
                Value: ["oetBCHCode_cardShiftTopUp", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_cardShiftTopUp", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_cardShiftTopUp',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });

    function JSxSetConfigBCH_cardShiftTopUp(params) {
        if (params == 'NULL') {
            var tValue = '';
            $('#oetBCHName_cardShiftTopUp').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftTopUpUsrBchCode').val(tValue);
    }
    //ค้นหาการ์ดแบบยิงบาร์โค็ด
    function JSxCardShiftTopUpScanner() {
      //ถ้าไม่ได้กรอกข้อมูล หรือกรอกข้อมูลแล้วข้อมูล
      if($('#oetCardShiftTopUpDataScannerID').val() == ''){
        $('#oetCardShiftTopUpDataScannerID').focus();
        return;
      }else if($("#oetCardShiftTopUpDataScannerID").val() != '') {
        $.ajax({
            type    : "POST",
            url     : "cardShiftTopUpEventScanner",
            data    : { tScannerID : $('#oetCardShiftTopUpDataScannerID').val()},
            cache   : false,
            timeout : 0,
            success : function(tResult) {
              var aData = JSON.parse(tResult);
              if (aData['rtCode']=='1') {
                var aCardCode = [];
                aCardCode.push(aData['raItems'][0]['FTCrdCode']);
                JSxCardShiftTopUpSetDataSource(aCardCode);
                $("#oetCardShiftTopUpDataScannerID").val("");
              }else{
                if (aData['rtCode'] == '801'){
                    var tTextError = '<?=language('common/main/main','tDataDuplicate')?>';
                }else{
                    var tTextError = '<?=language('common/main/main','tMainRptNotFoundDataInDB')?>';
                }

                FSvCMNSetMsgErrorDialog(tTextError);
                $('#oetCardShiftTopUpDataScannerID').val('');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
            }
        });
      }
    }
</script>
