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

        $('#oimCardShiftReturnBrowseProvince').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oPvnOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftReturnFromCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftReturnBrowseFromCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftReturnToCardType').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxBrowseData('oCardShiftReturnBrowseToCardType');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $("#oimCardShiftReturnFromCardNumber, #oimCardShiftReturnToCardNumber, #obtCardShiftReturnAddDataSource").on("click", function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.CardShiftReturnGetCardCodeTemp = JStCardShiftReturnGetCardCodeTemp();
                JStCardShiftReturnGetCardOnHD();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftReturnFromCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftReturnBrowseFromCardNumberOption = oCardShiftReturnBrowseFromCardNumber(CardShiftReturnGetCardCodeTemp, tCardNoOnHD);
                JCNxBrowseData('oCardShiftReturnBrowseFromCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#oimCardShiftReturnToCardNumber').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftReturnBrowseToCardNumberOption = oCardShiftReturnBrowseToCardNumber(CardShiftReturnGetCardCodeTemp, tCardNoOnHD);
                JCNxBrowseData('oCardShiftReturnBrowseToCardNumberOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        $('#obtCardShiftReturnAddDataSource').click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                window.oCardShiftReturnBrowseAddDataSourceOption = oCardShiftReturnBrowseAddDataSource(CardShiftReturnGetCardCodeTemp, tCardNoOnHD);
                JCNxBrowseData('oCardShiftReturnBrowseAddDataSourceOption');
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        if (JCNbCardShiftReturnIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftReturnCode").attr("readonly", true);
            $("#odvCardShiftReturnAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftReturnAutoGenCode', false);

            // $("#obtGenCodeCardShiftReturn").attr("disabled", true);
            JSxCMNVisibleComponent('#obtCardShiftReturnBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftReturnBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftReturnBtnDocMa', true);
        }

        if (JCNbCardShiftReturnIsCreatePage()) {
            // Doc No
            $("#oetCardShiftReturnCode").attr("disabled", true);
            $('#ocbCardShiftReturnAutoGenCode').change(function() {
                if ($('#ocbCardShiftReturnAutoGenCode').is(':checked')) {
                    $("#oetCardShiftReturnCode").attr("disabled", true);
                    $('#odvCardShiftReturnDocNoForm').removeClass('has-error');
                    $('#odvCardShiftReturnDocNoForm em').remove();
                } else {
                    $("#oetCardShiftReturnCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftReturnAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftReturnBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftReturnBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftReturnBtnDocMa', false);

            JSvCardShiftReturnDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftReturnIsUpdatePage()) {
            var tDocNo = $("#oetCardShiftReturnCode").val();
            <?php if (!empty($aCardCode)) : // Have card 
            ?>
                <?php if ($aResult["raItems"]["rtCardShiftReturnStaDoc"] == "3") : // Cancel
                ?>
                    JSvCardShiftReturnDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "2", false, false, [], "2", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftReturnStaPrcDoc"] == "1") : // Approved
                    ?>
                        JSvCardShiftReturnDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "3", false, false, [], "1", tDocNo);
                    <?php else : // Pending 
                    ?>
                        JSvCardShiftReturnDataSourceTable("", <?php echo json_encode($aCardCode); ?>, [], [], false, "3", false, false, [], "4", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftReturnDataSourceTable("", [], [], [], true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftReturnApvCode").val();
        var tUsrCode = $("#ohdCardShiftReturnUsrCode").val();
        
        if ((JCNbCardShiftReturnIsUpdatePage() && JSbCardShiftReturnIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftReturnGetProgressAfterApvDoc();
        }

        JSxCardShiftReturnSetCardCodeTemp();
        // console.log("GetCardCodeTemp Init: ", JStCardShiftReturnGetCardCodeTemp());
        JSxCardShifOutActionAfterApv();
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
    var oCardShiftReturnBrowseFromCardType = {
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
            Value: ["oetCardShiftReturnFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftReturnFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        NextFunc: {
            FuncName: 'JSxCSTAddSetCodeTypeCard',
            ArgReturn: ['FTCtyName', 'FTCtyCode']
        },
        // RouteFrom : 'cardShiftReturn',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftReturnBrowseType
    };

    function JSxCSTAddSetCodeTypeCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftReturnToCardTypeName').val(aData[0]);
            $('#oetCardShiftReturnToCardTypeCode').val(aData[1]);
        } else {
            $('#oetCardShiftReturnToCardTypeName').val('');
            $('#oetCardShiftReturnToCardTypeCode').val('');
        }
    }

    var oCardShiftReturnBrowseToCardType = {
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
            Value: ["oetCardShiftReturnToCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftReturnToCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
            FuncName:'JSxCSTAddSetAreaCode',
            ArgReturn:['FTCtyCode']
        },*/
        // RouteFrom : 'cardShiftReturn',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftReturnBrowseType
    };

    var oCardShiftReturnBrowseFromCardNumber = function(ptNotCardCode, ptCardCode) {
        var nFromCard = $('#oetCardShiftReturnFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftReturnToCardTypeCode').val();

        var tWhereInCard = "";

        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCard.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }
        // console.log("Not Card Code: ", ptNotCardCode);
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }
        var tNotInCard = "";
        if (!ptCardCode == "" && JCNbCardShiftReturnIsUpdatePage()) {
            tNotInCard = " AND TFNMCard.FTCrdCode NOT IN (" + ptCardCode + ")";
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
                Condition: ["AND ( ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')) )" + tNotIn + tWhereInCard + tWhereCardByAgenCode]
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
                OrderBy: ['TFNMCard.FDCreateOn'],
                SourceOrder: "DESC",
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftReturnFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftReturnFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            NextFunc: {
                FuncName: 'JSxCSTAddSetCodeNumberCard',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftReturn',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftReturnBrowseType,
            // DebugSQL : true
        };
        return oOptions;
    };

    function JSxCSTAddSetCodeNumberCard(poData) {
        if (poData != 'NULL') {
            const aData = JSON.parse(poData);
            $('#oetCardShiftReturnToCardNumberCode').val(aData[0]);
            $('#oetCardShiftReturnToCardNumberName').val(aData[0]);
        } else {
            $('#oetCardShiftReturnToCardNumberCode').val('');
            $('#oetCardShiftReturnToCardNumberName').val('');
        }
    }

    var oCardShiftReturnBrowseToCardNumber = function(ptNotCardCode, ptCardCode) {
        var nFromCard = $('#oetCardShiftReturnFromCardTypeCode').val();
        var nToCard = $('#oetCardShiftReturnToCardTypeCode').val();

        var tWhereInCard = "";
        if (nFromCard != '' || nToCard != '') {
            tWhereInCard = " AND TFNMCard.FTCtyCode IN (" + nFromCard + "," + nToCard + ")";
        }

        // console.log("Not Card Code: ", ptNotCardCode);
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }

        var tNotInCard = "";
        if (!ptCardCode == "" && JCNbCardShiftReturnIsUpdatePage()) {
            tNotInCard = " AND TFNMCard.FTCrdCode NOT IN (" + ptCardCode + ")";
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
                Condition: ["AND ( ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')) )" + tNotIn + tWhereInCard + tWhereCardByAgenCode]
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
                // SourceOrder		: "DESC",
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftReturnToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftReturnToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
                FuncName:'JSxCSTAddSetAreaCode',
                ArgReturn:['FTCrdCode']
            },*/
            // RouteFrom : 'cardShiftReturn',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftReturnBrowseType
        };
        return oOptions;
    };

    var oCardShiftReturnBrowseAddDataSource = function(ptNotCardCode, ptCardCode) {
        // console.log("Not Card Code: ", ptNotCardCode);
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = " AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }
        var tNotInCard = "";
        if (!ptCardCode == "" && JCNbCardShiftReturnIsUpdatePage()) {
            tNotInCard = " AND TFNMCard.FTCrdCode NOT IN (" + ptCardCode + ")";
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
                Condition: ["AND ( ((TFNMCardType.FTCtyStaShift = '1') AND (TFNMCard.FTCrdStaShift = '2')) )" + tNotIn + tWhereCardByAgenCode]
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
                // SourceOrder		: "DESC",
            },
            CallBack: {
                StaDoc: 2,
                ReturnType: 'M',
                Value: ["testCode", "TFNMCard.FTCrdCode"],
                Text: ["testName", "TFNMCard_L.FTCrdName"]
            },
            NextFunc: {
                FuncName: 'JSxCardShiftReturnSetDataSource',
                ArgReturn: ['FTCrdCode']
            },
            // RouteFrom : 'cardShiftReturn',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftReturnBrowseType,
            // DebugSQL : true

        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/

    var bUniqueCardShiftReturnCode;
    $.validator.addMethod(
        "uniqueCardShiftReturnCode",
        function(tValue, oElement, aParams) {
            var tCardShiftReturnCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftReturnUniqueValidate/cardShiftReturnCode",
                data: "tCardShiftReturnCode=" + tCardShiftReturnCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftReturnCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardShiftReturnCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftReturnCode;
        },
        "Card Doc Code is Already Taken"
    );

    $.validator.addMethod(
        "regex",
        function(value, element, regexp) {
            var re = new RegExp(regexp);
            return this.optional(element) || re.test(value);
        },
        "Please check your input."
    );

    var bExtensionValidate;
    $.validator.addMethod(
        "extensionValidate",
        function(tValue, oElement, tFileTypeFilter) {
            let tExtension = tValue.split('.').pop().toLowerCase();
            let aExtensions = tFileTypeFilter.split('|');

            if ($.inArray(tExtension, aExtensions) == -1) {
                // console.log('Extension invalid');
                bExtensionValidate = false;
            } else {
                // console.log('Extension valid');
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
     * Functionality : (event) Add/Edit CardShiftReturn
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftReturnAddEditCardShiftReturn(ptRoute) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

            if (JCNnCardShiftReturnCountDataSourceRow() == 0) { // Check Card Empty
                FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                return;
            }

            // From Validate
            $('#ofmAddCardShiftReturnMainForm').validate({
                rules: {
                    oetCardShiftReturnCode: {
                        required: true,
                        uniqueCardShiftReturnCode: JCNbCardShiftReturnIsCreatePage(),
                        maxlength: 20
                    },
                    oetCardShiftReturnDocDate: {
                        required: true
                    }
                },
                messages: {
                    oetCardShiftReturnCode: {
                        required: "<?php echo language('document/card/cardreturn', 'tValidCardShiftReturn'); ?>",
                        uniqueCardShiftTopUpCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                        maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"
                    }
                },
                submitHandler: function(form) {
                    var aCardCode = JSaCardShiftReturnGetDataSourceCode(false);
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data: $('#ofmAddCardShiftReturnMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            try {
                                var oResult = JSON.parse(tResult);
                                if (oResult.nStaEvent == '1') {
                                    JSvCardShiftReturnCallPageCardShiftReturnEdit(oResult.tCodeReturn);
                                } else {
                                    FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                }
                            } catch (err) {}
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
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
    }

    /**
     * Functionality : Set doc code in table to array
     * Parameters : pbWrapText is true use '', false not use ''
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Doc code
     * Return Type : array
     */
    function JSaCardShiftReturnGetDataSourceCode(pbWrapText) {
        try {
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;
            // Set data
            var aData = [];
            var oRecord = JSON.parse(($("#ospCardShiftReturnCardCodeTemp").text() == "") ? "[]" : $("#ospCardShiftReturnCardCodeTemp").text());
            $.each(oRecord, function(pnIndex, poElement) {
                if (pbWrapText) {
                    aData.push("'" + poElement.FTCrdCode + "'");
                } else {
                    aData.push(poElement.FTCrdCode);
                }
            });
            return aData;
        } catch (err) {
            JCNxCardShiftReturnResponseError("JSaCardShiftReturnGetDataSourceCode Error: ", err);
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
    function JSxCardShiftReturnSetCardCodeTemp() {
        try {
            $("#ohdCardShiftReturnCardCodeTemp").val("");
            setTimeout(function() {
                $("#ohdCardShiftReturnCardCodeTemp").val(JSaCardShiftReturnGetDataSourceCode(true));
            }, 800);
        } catch (err) {
            JCNxCardShiftReturnResponseError("JSxCardShiftReturnSetCardCodeTemp Error: ", err);
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
    function JStCardShiftReturnGetCardCodeTemp() {
        try {
            return $("#ohdCardShiftReturnCardCodeTemp").val();
        } catch (err) {
            JCNxCardShiftReturnResponseError("JStCardShiftReturnGetCardCodeTemp Error: ", err);
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
    function JSxCardShiftReturnSetDataSource(ptCardCode) {
        console.log(ptCardCode);
            $('#testName').val('');
            $('#testCode').val('');
        try {
            if (ptCardCode.filter(Boolean).length < 1) {
                JSvCardShiftReturnDataSourceTable("", [], [], [], true, "3", true, false, [], "1", "");
                return;
            }

            var aCardCode = [];
            $.each(ptCardCode.filter(Boolean), function(nIndex, tValue) {
                var tCode = "'"+tValue+"'";
                // tCode = tCode.replace('["', "'");
                // tCode = tCode.replace('"]', "'");
                aCardCode[nIndex] = tCode;
            });
            JSxCardShiftReturnInsertDataToTemp(aCardCode);
        } catch (err) {
            JCNxCardShiftReturnResponseError("JSxCardShiftReturnSetDataSource Error: ", err);
        }
    }

    //Insert Choose
    function JSxCardShiftReturnInsertDataToTemp(paCardCode) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnInsertToTemp",
                    data: {
                        tInsertType: 'choose',
                        tCardCode: JSON.stringify(paCardCode),
                        tDocNo: $('#oetCardShiftReturnCode').val(),
                        tBCHCode: $('#oetBCHCode_CardShiftReturn').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JSvCardShiftReturnDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            JCNxCardShiftReturnResponseError("JSxCardShiftReturnInsertDataToTemp Error: ", err);
        }
    }

    //Insert Between
    function JSxCardShiftReturnInsertDataToTempBetween(paRangeCardCode, paRangeCardType, paCardCode, ptInsertType) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnInsertToTemp",
                    data: {
                        tInsertType: 'between',
                        tRangeCardCode: JSON.stringify(paRangeCardCode),
                        tRangeCardType: JSON.stringify(paRangeCardType),
                        tCardCode: JSON.stringify(paCardCode),
                        tDocNo: $('#oetCardShiftReturnCode').val(),
                        tBCHCode: $('#oetBCHCode_CardShiftReturn').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        JSvCardShiftReturnDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            JCNxCardShiftReturnResponseError("JSxCardShiftReturnInsertDataToTemp Error: ", err);
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
    function JSxCardShiftReturnSetDataSourceFilter() {
        try {
            if ($('input[name=orbCardShiftReturnSourceMode]:checked').val() == "range") {
                var tCardTypeCodeFrom = $('#oetCardShiftReturnFromCardTypeCode').val();
                var tCardTypeCodeTo = $('#oetCardShiftReturnToCardTypeCode').val();
                var tCardNumberCodeFrom = $('#oetCardShiftReturnFromCardNumberCode').val();
                var tCardNumberCodeTo = $('#oetCardShiftReturnToCardNumberCode').val();
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

                var aNotInCardCode = JStCardShiftReturnGetCardCodeTemp() == "" ? [] : JStCardShiftReturnGetCardCodeTemp().split(",");

                // Begin validate
                if ((aCardTypeCode.length == 0) && (aCardNumberCode.length == 0)) {
                    JSxCMNVisibleComponent("#odvCardShiftReturnAlert label", false);
                    JSxCMNVisibleComponent("#odvCardShiftReturnAlert label.xWCheckCondition", true);
                } else {
                    JSxCMNVisibleComponent("#odvCardShiftReturnAlert label", false);
                }
                // End validate

                if (!(aCardTypeCode.length == 0) && !(aCardNumberCode.length == 0)) {
                    JSxCardShiftReturnInsertDataToTempBetween(aCardNumberCode, aCardTypeCode, [], "between");
                    return;
                }
                if (!(aCardTypeCode.length == 0) || !(aCardNumberCode.length == 0)) {
                    // console.log("Or");
                    if (!(aCardTypeCode.length == 0)) {
                        JSxCardShiftReturnInsertDataToTempBetween([], aCardTypeCode, [], "between");
                        return;
                    }
                    if (!(aCardNumberCode.length == 0)) {
                        JSxCardShiftReturnInsertDataToTempBetween(aCardNumberCode, [], [], "between");
                        return;
                    }
                }
            }
            if ($('input[name=orbCardShiftReturnSourceMode]:checked').val() == "file") {
                // console.log('File type');
                $("#obtSubmitCardShiftReturnSearchCardForm").trigger("click");
            }
            JSxCardShiftReturnSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftReturnSetDataSourceFilter Error: ", err);
        }
    }

    /**
     * Functionality : Show or Hide Data Source Mode
     * Parameters : poElement is Itself element, poEvent is Itself event
     * @return {type} descriptionReturn : -
     * Creator : 08/10/2018 piya
     * Last Modified : -
     */
    function JSxCardShiftReturnVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftReturnFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftReturnRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftReturnAlert label", false);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftReturnFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftReturnRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftReturnAlert label", false);
            }
            JSxCardShiftReturnSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftReturnVisibleDataSourceMode Error: ", err);
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
    function JSxCardShiftReturnSetImportFile(poElement, poEvent) {
        try {
            let oFile = $(poElement)[0].files[0];
            $("#oetCardShiftReturnFileTemp").val(oFile.name);
        } catch (err) {
            console.log("JSxCardShiftReturnSetImportFile Error: ", err);
        }
    }

    /**
     * Functionality : (event) Add/Edit CardShiftReturn
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnImportFileValidate() {
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oefCardShiftReturnImport: {
                        required: true,
                        extensionValidate: 'xls|xlsx',
                        fileSizeValidate: '100' // unit mb
                    }
                },
                messages: {
                    oefCardShiftReturnImport: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                        extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                        fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                    }
                },
                submitHandler: function(form) {
                    $('#odvCardShiftReturnModalImportFileConfirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#odvCardShiftReturnModalImportFileConfirm').modal('show');
                    $('#osmCardShiftReturnBtnImportFileConfirm').one('click', function(evt) {
                        $('#odvCardShiftReturnModalImportFileConfirm').modal('hide');
                        JSvCardShiftReturnDataSourceTableByFile("", false, "1", true, false, [], "3");
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
            console.log("JSxCardShiftReturnImportFileValidate Error: ", err);
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
    function JSxCardShiftReturnSetCountNumber() {
        try {
            var tCountAll = $("#ohdCardShiftReturnCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            $("#oetCardShiftReturnCountNumber").val("");
            $("#oetCardShiftReturnCountNumber").val(tResult);
            $("#ospCardShiftReturnDataSourceCount").text("");
            $("#ospCardShiftReturnDataSourceCount").text(tResult);
        } catch (err) {
            console.log("JSxCardShiftReturnSetCountNumber Error: ", err);
        }

    }

    /**
     * Functionality : Get Card number on HD
     * Parameters : -
     * Creator : 26/10/2018 piya
     * Last Modified : -
     * Return : Card number
     * Return Type : string
     */
    function JStCardShiftReturnGetCardOnHD() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "GET",
                    url: "cardShiftReturnGetCardOnHD",
                    data: {},
                    cache: false,
                    Timeout: 0,
                    async: false,
                    success: function(tResult) {
                        try {
                            window.tCardNoOnHD = JSON.parse(tResult).toString();
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JStCardShiftReturnGetCardOnHD Error: ", err);
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
     * Creator : 10/10/2018 piya
     * Last Modified : -
     */
    function JSvCardShiftReturnDataSourceTable(pnPage, paCardCode, paCardTypeCodeRange, paCardCodeRange, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftReturnDataSearch').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnDataSourceTable",
                    data: {
                        tSearchAll: tSearchAll,
                        nPageCurrent: nPageCurrent,
                        tCardNumber: JSON.stringify(paCardCode),
                        tCardTypeRange: JSON.stringify(paCardTypeCodeRange),
                        tCardNumberRange: JSON.stringify(paCardCodeRange),
                        tNotInCardNumber: JSON.stringify(paNotInCardNumber),
                        tSetEmpty: pbSetEmpty == true ? "1" : "0",
                        tStaShift: ptStaShift,
                        tDocNo: ptDocNo,
                        tIsTemp: pbIsTemp == true ? "1" : "0",
                        tIsDataOnly: pbIsDataOnly == true ? "1" : "0",
                        tStaType: ptStaType, // 1: Approve 2: Document status cancel
                        tStaPrcDoc: $("#ohdCardShiftReturnCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftReturnCardStaDoc").val(),
                        tLastIndex: JCNnCardShiftReturnCountDataSourceRow(["pending", "n/a", "notfound", "fail"])
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        try {
                            let oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftReturnAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftReturnAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }
                        } catch (err) {

                        }

                        if (tResult != "") {
                            $('#odvCardShiftReturnDataSource').html(tResult);
                            JSxCardShiftReturnSetHeightDataSourceTable();
                        }
                        JSxCardShiftReturnSetCountNumber();
                        JSxCardShiftReturnSetCardCodeTemp();
                        JSxCMNVisibleComponent("#odvCardShiftReturnAlert label", false);
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftReturnDataSourceTable Error: ', err);
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
    function JSvCardShiftReturnDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
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
                var oFile = $('#oefCardShiftReturnImport')[0].files[0];
                oFormData.append('oefCardShiftReturnImport', oFile);
                oFormData.append('tSearchAll', tSearchAll);
                oFormData.append('nPageCurrent', nPageCurrent);
                oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
                oFormData.append('tStaShift', ptStaShift);
                oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
                oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
                oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
                oFormData.append('tStaPrcDoc', $("#ohdCardShiftReturnCardStaPrcDoc").val());
                oFormData.append('tStaDoc', $("#ohdCardShiftReturnCardStaDoc").val());
                oFormData.append('tLastIndex', JCNnCardShiftReturnCountDataSourceRow(["complete", "pending", "n/a"]));
                oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
                oFormData.append('aFile', oFile);
                oFormData.append('tBchCode', $("#oetBCHCode_CardShiftReturn").val());

                var tDocNo = $('#oetCardShiftReturnCode').val();
                if (tDocNo == '' || tDocNo == null) {
                    var tDocNo = '-';
                }
                oFormData.append('tDocNo', tDocNo);
                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnDataSourceTableByFile",
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
                                JSvCardShiftReturnDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
                            } else {
                                JCNxCloseLoading();
                            }
                        } catch (err) {
                            console.log('JSvCardShiftReturnDataSourceTableByFile Error: ', err);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftReturnDataSourceTableByFile Error: ', err);
        }
    }

    /**
     * Functionality : Search data in table
     * Parameters : -
     * Creator : 11/10/2018 piya
     * Last Modified : 27/12/2018 supawat
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnSearchDataSourceTable() {
        JSvCardShiftReturnDataSourceTable("", [], [], [], [], [], true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnSetHeightDataSourceTable() {
        // let nLeftContainerHeight = $(".xWLeftContainer").height();
        // $("#odvCardShiftReturnDataSource .table-responsive").height(nLeftContainerHeight-147);
    }

    /**
     * Functionality : Delete Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnDataSourceDeleteOperator(poElement, poEvent) {
        try {
            if (JSbCardShiftReturnIsApv() || JSbCardShiftReturnIsStaDoc("cancel")) {
                return;
            }
            if (confirm('Delete. ?')) {
                $(poElement) // Delete Itseft Record.
                    .parents('.otrCardShiftReturnDataSource')
                    .addClass('hidden');
                JSxCardShiftReturnSetCountNumber();
                JSxCardShiftReturnSetCardCodeTemp();
            }
        } catch (err) {
            console.log('JSxCardShiftReturnDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : Count row in table
     * Parameters : paRowType is ["pending", "complete", "cancel", "n/a", "notfound"]
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Row count
     * Return Type : number
     */
    function JCNnCardShiftReturnCountDataSourceRow(paRowType) {
        try {
            var tCountAll = $("#ohdCardShiftReturnCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            return tResult;
        } catch (err) {
            console.log('JCNnCardShiftReturnCountDataSourceRow Error: ', err);
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
    function JCNbCardShiftReturnCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                var nRow = $('#otbCardShifOutDataSourceList > tr').not('.hidden').not('#otrCardShifReturnNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            // console.log('JCNbCardShiftReturnCheckTypeDataSourceRow Error: ', err);
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
    function JSxCardShiftReturnStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Empty record check
            if (JCNnCardShiftReturnCountDataSourceRow(["complete", "pending", "n/a", "cancel", "notfound", "fail"]) == 0) {
                $("#odvCardShiftReturnModalEmptyCardAlert").modal("show");
                return;
            }

            if (pbIsConfirm) {
                $("#ohdCardShiftReturnCardStaPrcDoc").val(2); // Set status for pending approve
                $("#odvCardShiftReturnPopupApv").modal('hide');
                JSxCMNVisibleComponent("#ospCardShiftReturnApvName", true);
                var aCardCode = JSaCardShiftReturnGetDataSourceCode(false);
                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnEventUpdateApvDocAndCancelDoc",
                    data: $('#ofmAddCardShiftReturnMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        try {
                            let oResult = JSON.parse(tResult);
                            if (oResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                            }
                        } catch (e) {}
                        JSxCardShiftReturnGetProgressAfterApvDoc();
                        JSxCardShifOutActionAfterApv();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvCardShiftReturnPopupApv").modal('show');
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
    function JSxCardShiftReturnGetProgressAfterApvDoc() {
        // Document variable
        var tLangCode = $("#ohdCardShiftReturnLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftReturnUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftReturnApvCode").val();
        var tUsrCode = $("#ohdCardShiftReturnUsrCode").val();
        var tDocNo = $("#oetCardShiftReturnCode").val();
        var tPrefix = 'RESRETURN';
        var tStaDelMQ = $("#ohdCardShiftReturnApvCode").val();
        var tStaApv = $("#ohdCardShiftReturnApvCode").val();
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
            tCallPageEdit: 'JSvCardShiftReturnCallPageCardShiftReturnEdit',
            tCallPageList: 'JSvCardShiftReturnCallPageCardShiftReturn'
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
    function JSxCardShiftReturnStaDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            if (pbIsConfirm) {
                if ($("#ohdCardShiftReturnCardStaPrcDoc").val() == "") { // Pending approve status
                    $("#ohdCardShiftReturnCardStaDoc").val(3); // Set status for cancel document
                    $("#odvCardShiftReturnPopupStaDoc").modal('hide');
                    var aCardCode = JSaCardShiftReturnGetDataSourceCode(false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftReturnEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftReturnMainForm').serialize() + "&aCardCode=" + JSON.stringify(aCardCode),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            JSvCardShiftReturnCallPageCardShiftReturnEdit($("#oetCardShiftReturnCode").val());
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            } else {
                $("#odvCardShiftReturnPopupStaDoc").modal('show');
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
    function JSbCardShiftReturnIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftReturnStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftReturnIsStaDelQname Error: ", err);
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
    function JSbCardShiftReturnIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftReturnCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftReturnIsStaApv Error: ", err);
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
    function JSbCardShiftReturnIsApv() {
        var bStatus = false;
        if (($("#ohdCardShiftReturnCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftReturnCardStaPrcDoc").val() == "2")) {
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
    function JSbCardShiftReturnIsStaDoc(ptStaType) {
        var bStatus = false;
        if (ptStaType == "complete") {
            if ($("#ohdCardShiftReturnCardStaDoc").val() == "1") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "incomplete") {
            if ($("#ohdCardShiftReturnCardStaDoc").val() == "2") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "cancel") {
            if ($("#ohdCardShiftReturnCardStaDoc").val() == "3") {
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
    function JSxCardShifOutActionAfterApv() {
        if (JCNbCardShiftReturnIsUpdatePage()) {
            if (JSbCardShiftReturnIsApv() || JSbCardShiftReturnIsStaDoc("cancel")) {
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnCancelApv", false);
                $("#oetCardShiftReturnDocDate").attr("disabled", true);
                $(".xCNBtnDateTime").attr("disabled", true);
                if (JSbCardShiftReturnIsApv()) {
                    JSxCMNVisibleComponent("#ospCardShiftReturnApvName", true);
                }
                if (JSbCardShiftReturnIsStaDoc("cancel")) {
                    JSxCMNVisibleComponent("#ospCardShiftReturnApvName", false);
                }
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnSave", false);
            } else {
                $("#oetCardShiftReturnDocDate").attr("disabled", false);
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnApv", true);
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftReturnApvName", false);
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnSave", true);
            }

            if (!JSbCardShiftReturnIsApv() && JSbCardShiftReturnIsStaDoc("incomplete")) {
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftReturnBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftReturnApvName", false);
            }
        }

        if (JCNbCardShiftReturnIsCreatePage()) {
            JSxCMNVisibleComponent("#obtCardShiftReturnBtnSave", true);
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
    function JSxCardShiftReturnPrint() {
        var tUsrBchCode = $("#ohdCardShiftReturnUsrBchCode").val();
        var tDocNo      = $("#oetCardShiftReturnCode").val();
        var aInfor = [
			{"Lang"         : '<?php echo FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : tUsrBchCode}
		];
		window.open("<?php echo base_url(); ?>formreport/Frm_SQL_FCCardReturnCash?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>
<?php include 'jCardShiftReturnDataSourceTable.php'; ?>

<script>
    //เลือกสาขา วัฒน์ 13/08/2020
    $("#obtBrowseBCH_CardShiftReturn").click(function() {
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
                Value: ["oetBCHCode_CardShiftReturn", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_CardShiftReturn", "TCNMBranch_L.FTBchName"]
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
            $('#oetBCHName_CardShiftReturn').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftReturnUsrBchCode').val(tValue);
    }

    //ค้นหาการ์ดแบบยิงบาร์โค็ด
    function JSxCardShiftReturnScanner() {
      var nCountNumber  = 0;
      if ($("#oetCardShiftReturnCountNumber").val()=="" || $("#oetCardShiftReturnCountNumber").val()=="0") {
        nCountNumber  = 0;
      }else {
        nCountNumber  = parseInt($("#oetCardShiftReturnCountNumber").val());
      }

      //ถ้าไม่ได้กรอกข้อมูล หรือกรอกข้อมูลแล้วข้อมูล
      if($('#oetCardShiftReturnDataScannerID').val() == ''){
        $('#oetCardShiftReturnDataScannerID').focus();
        return;
      }else if($("#oetCardShiftReturnDataScannerID").val() != '') {
        $.ajax({
            type    : "POST",
            url     : "cardShiftReturnEventScanner",
            data    : { tScannerID : $('#oetCardShiftReturnDataScannerID').val() , nCountNumber:nCountNumber},
            cache   : false,
            timeout : 0,
            success : function(tResult) {
              var aData = JSON.parse(tResult);
              if (aData['rtCode']=='1') {
                var aCardCode = [];
                aCardCode.push(aData['raItems'][0]['FTCrdCode']);
                JSxCardShiftReturnSetDataSource(aCardCode);
                $("#oetCardShiftReturnDataScannerID").val("");
              }else{
                if (aData['rtCode'] == '801'){
                    var tTextError = '<?=language('common/main/main','tDataDuplicate')?>';
                }else{
                    var tTextError = '<?=language('common/main/main','tMainRptNotFoundDataInDB')?>';
                }

                FSvCMNSetMsgErrorDialog(tTextError);
                $('#oetCardShiftReturnDataScannerID').val('');
              }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCardShiftReturnResponseError(jqXHR, textStatus, errorThrown);
            }
        });
      }
    }
</script>