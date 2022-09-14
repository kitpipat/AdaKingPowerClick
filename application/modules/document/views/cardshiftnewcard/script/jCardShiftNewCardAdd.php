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

        $('#oimCardShiftNewCardBrowseProvince').click(function() {
            JCNxBrowseData('oPvnOption');
        });

        $('#oimCardShiftNewCardFromCardType').click(function() {
            JCNxBrowseData('oCardShiftNewCardBrowseFromCardType');
        });
        $('#oimCardShiftNewCardToCardType').click(function() {
            JCNxBrowseData('oCardShiftNewCardBrowseToCardType');
        });

        $("#oimCardShiftNewCardFromCardNumber, #oimCardShiftNewCardToCardNumber, #obtCardShiftNewCardAddDataSource").on("click", function() {
            window.CardShiftNewCardGetCardCodeTemp = JStCardShiftNewCardGetCardCodeTemp();
        });
        $('#oimCardShiftNewCardFromCardNumber').click(function() {
            window.oCardShiftNewCardBrowseFromCardNumberOption = oCardShiftNewCardBrowseFromCardNumber(CardShiftNewCardGetCardCodeTemp);
            JCNxBrowseData('oCardShiftNewCardBrowseFromCardNumberOption');
        });

        $('#oimCardShiftNewCardToCardNumber').click(function() {
            window.oCardShiftNewCardBrowseToCardNumberOption = oCardShiftNewCardBrowseToCardNumber(CardShiftNewCardGetCardCodeTemp);
            JCNxBrowseData('oCardShiftNewCardBrowseToCardNumberOption');
        });

        $('#obtCardShiftNewCardAddDataSource').click(function() {
            window.oCardShiftNewCardBrowseAddDataSourceOption = oCardShiftNewCardBrowseAddDataSource(CardShiftNewCardGetCardCodeTemp);
            JCNxBrowseData('oCardShiftNewCardBrowseAddDataSourceOption');
        });

        if (JCNbCardShiftNewCardIsUpdatePage()) {
            // Doc No
            $("#oetCardShiftNewCardCode").attr("readonly", true);
            $("#odvCardShiftNewCardAutoGenCode input").attr("disabled", true);
            JSxCMNVisibleComponent('#odvCardShiftNewCardAutoGenCode', false);

            // $("#obtGenCodeCardShiftNewCard").attr("disabled", true);
            JSxCMNVisibleComponent('#obtCardShiftNewCardBtnApv', true);
            JSxCMNVisibleComponent('#obtCardShiftNewCardBtnCancelApv', true);
            JSxCMNVisibleComponent('#obtCardShiftNewCardBtnDocMa', true);
        }

        if (JCNbCardShiftNewCardIsCreatePage()) {
            // Doc No
            $("#oetCardShiftNewCardCode").attr("disabled", true);
            $('#ocbCardShiftNewCardAutoGenCode').change(function() {
                if ($('#ocbCardShiftNewCardAutoGenCode').is(':checked')) {
                    $("#oetCardShiftNewCardCode").attr("disabled", true);
                    $('#odvCardShiftNewCardDocNoForm').removeClass('has-error');
                    $('#odvCardShiftNewCardDocNoForm em').remove();
                } else {
                    $("#oetCardShiftNewCardCode").attr("disabled", false);
                }
            });
            JSxCMNVisibleComponent('#odvCardShiftNewCardAutoGenCode', true);

            JSxCMNVisibleComponent('#obtCardShiftNewCardBtnApv', false);
            JSxCMNVisibleComponent('#obtCardShiftNewCardBtnCancelApv', false);
            JSxCMNVisibleComponent('#obtCardShiftNewCardBtnDocMa', false);

            JSvCardShiftNewCardDataSourceTable("", {}, true, "1", false, false, [], "1", "");
        }

        if (JCNbCardShiftNewCardIsUpdatePage()) {
            let tDocNo = $("#oetCardShiftNewCardCode").val();
            <?php if (!empty($tDocNo)) : ?>
                <?php if ($aResult["raItems"]["rtCardShiftNewCardStaDoc"] == "3") : // Cancel  
                ?>
                    JSvCardShiftNewCardDataSourceTable("", {}, false, "2", false, false, [], "2", tDocNo);
                <?php else : ?>
                    <?php if ($aResult["raItems"]["rtCardShiftNewCardStaPrcDoc"] == "1") : // Approved  
                    ?>
                        JSvCardShiftNewCardDataSourceTable("", {}, false, "3", false, false, [], "1", tDocNo);
                    <?php else : // Pending  
                    ?>
                        JSvCardShiftNewCardDataSourceTable("", {}, false, "2", false, false, [], "3", tDocNo);
                    <?php endif; ?>
                <?php endif; ?>
            <?php else : ?>
                JSvCardShiftNewCardDataSourceTable("", {}, true, "1", false, false, [], "1", "");
            <?php endif; ?>
        }

        var tUsrApv = $("#ohdCardShiftNewCardApvCode").val();
        var tUsrCode = $("#ohdCardShiftNewCardUsrCode").val();

        if ((JCNbCardShiftNewCardIsUpdatePage() && JSbCardShiftNewCardIsStaApv('2')) && (tUsrCode == tUsrApv)) { // 2 = Processing and user approved
            JSxCardShiftNewGetProgressAfterApvDoc();
        }

        JSxCardShiftNewCardSetCardCodeTemp();
        console.log("GetCardCodeTemp Init: ", JStCardShiftNewCardGetCardCodeTemp());
        JSxCardShiftNewCardActionAfterApv();

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
    var oCardShiftNewCardBrowseFromCardType = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
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
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize: ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TFNMCardType_L.FTCtyName'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftNewCardFromCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftNewCardFromCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
         FuncName:'JSxCSTAddSetAreaCode',
         ArgReturn:['FTCtyCode']
         },*/
        // RouteFrom : 'cardShiftNewCard',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftNewCardBrowseType
    };

    var oCardShiftNewCardBrowseToCardType = {
        Title: ['pos5/cardtype', 'tCTYTitle'],
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
            ColumnPathLang: 'pos5/cardtype',
            ColumnKeyLang: ['tCTYCode', 'tCTYName'],
            // ColumnsSize     : ['15%', '85%'],
            WidthModal: 50,
            DataColumns: ['TFNMCardType.FTCtyCode', 'TFNMCardType_L.FTCtyName'],
            DisabledColumns: [],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TFNMCardType_L.FTCtyName'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: ["oetCardShiftNewCardToCardTypeCode", "TFNMCardType.FTCtyCode"],
            Text: ["oetCardShiftNewCardToCardTypeName", "TFNMCardType_L.FTCtyName"]
        },
        /*NextFunc:{
         FuncName:'JSxCSTAddSetAreaCode',
         ArgReturn:['FTCtyCode']
         },*/
        // RouteFrom : 'cardShiftNewCard',
        RouteAddNew: 'cardtype',
        BrowseLev: nStaCardShiftNewCardBrowseType
    };

    var oCardShiftNewCardBrowseFromCardNumber = function(ptNotCardCode) {
        console.log("Not Card Code: ", ptNotCardCode);
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }
        var oOptions = {
            Title: ['pos5/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode'
            },
            Join: {
                Table: ['TFNMCard_L','TFNMCardType'],
                On: [
                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                ]
            },
            Where: {
                Condition: ["AND TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaShift = '1' AND TFNMCard.FTCrdStaShift = '1' AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn + tWhereCardByAgenCode]
            },
            GrideView: {
                ColumnPathLang: 'pos5/card',
                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCard_L.FTCrdName'],
                SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftNewCardFromCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftNewCardFromCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
             FuncName:'JSxCSTAddSetAreaCode',
             ArgReturn:['FTCrdCode']
             },*/
            // RouteFrom : 'cardShiftNewCard',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftNewCardBrowseType
        };
        return oOptions;
    };

    var oCardShiftNewCardBrowseToCardNumber = function(ptNotCardCode) {
        console.log("Not Card Code: ", ptNotCardCode);
        var tNotIn = "";
        if (!ptNotCardCode == "") {
            tNotIn = "AND TFNMCard.FTCrdCode NOT IN (" + ptNotCardCode + ")";
        }
        var oOptions = {
            Title: ['pos5/card', 'tCRDTitle'],
            Table: {
                Master: 'TFNMCard',
                PK: 'FTCrdCode'
            },
            Join: {
                Table: ['TFNMCard_L','TFNMCardType'],
                On: [
                    'TFNMCard_L.FTCrdCode = TFNMCard.FTCrdCode AND TFNMCard_L.FNLngID = ' + nLangEdits,
                    'TFNMCardType.FTCtyCode = TFNMCard.FTCtyCode'
                ]
            },
            Where: {
                Condition: ["AND TFNMCard.FTCrdStaActive = '1' AND TFNMCardType.FTCtyStaShift = '1' AND TFNMCard.FTCrdStaShift = '1' AND (CONVERT(date, TFNMCard.FDCrdExpireDate) > CONVERT(date, GETDATE())) " + tNotIn + tWhereCardByAgenCode]
            },
            GrideView: {
                ColumnPathLang: 'pos5/card',
                ColumnKeyLang: ['tCRDTBCode', 'tCRDTBName', ''],
                // ColumnsSize     : ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TFNMCard.FTCrdCode', 'TFNMCard_L.FTCrdName'],
                DisabledColumns: [],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TFNMCard_L.FTCrdName'],
                SourceOrder: "DESC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: ["oetCardShiftNewCardToCardNumberCode", "TFNMCard.FTCrdCode"],
                Text: ["oetCardShiftNewCardToCardNumberName", "TFNMCard_L.FTCrdCode"]
            },
            /*NextFunc:{
             FuncName:'JSxCSTAddSetAreaCode',
             ArgReturn:['FTCrdCode']
             },*/
            // RouteFrom : 'cardShiftNewCard',
            RouteAddNew: 'card',
            BrowseLev: nStaCardShiftNewCardBrowseType
        };
        return oOptions;
    };

    /*============================= Begin Custom Form Validate ===================*/
    var bUniqueCardShiftNewCardCode;
    $.validator.addMethod(
        "uniqueCardShiftNewCardCode",
        function(tValue, oElement, aParams) {
            var tCardShiftNewCardCode = tValue;
            $.ajax({
                type: "POST",
                url: "cardShiftNewCardUniqueValidate/cardShiftNewCardCode",
                data: "tCardShiftNewCardCode=" + tCardShiftNewCardCode,
                dataType: "html",
                success: function(ptMsg) {
                    // If vatrate and vat start exists, set response to true
                    bUniqueCardShiftNewCardCode = (ptMsg == 'true') ? false : true;
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log('Custom validate uniqueCardShiftNewCardCode: ', jqXHR, textStatus, errorThrown);
                },
                async: false
            });
            return bUniqueCardShiftNewCardCode;
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
     * Functionality : (event) Add/Edit CardShiftNewCard
     * Parameters : ptRoute is route to add Customer Group data.
     * Creator : 08/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSnCardShiftNewCardAddEditCardShiftNewCard(ptRoute) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

                if (JCNnCardShiftNewCardCountDataSourceRow() == 0) { // Check Card Empty
                    FSvCMNSetMsgWarningDialog('<?php echo language('document/card/main', 'tMainEmptyRecordAlert'); ?>');
                    return;
                }

                // From Validate
                $('#ofmAddCardShiftNewCardMainForm').validate({
                    rules: {
                        oetCardShiftNewCardCode: {
                            required: true,
                            uniqueCardShiftNewCardCode: JCNbCardShiftNewCardIsCreatePage(),
                            maxlength: 20
                        },
                        oetCardShiftNewCardDocDate: {
                            required: true
                        }
                    },
                    messages: {
                        oetCardShiftNewCardCode: {
                            required: "<?php echo language('document/card/newcard', 'tValidCardShifNewCard'); ?>",
                            uniqueCardShiftTopUpCode: "<?php echo language('document/card/main', 'tMainDocNoDup'); ?>",
                            maxlength: "<?php echo language('document/card/main', 'tMainDocNoOverLength'); ?>"

                        }
                        // oetCardShiftNewCardName: ""
                    },
                    /*errorClass: "alert-validate",
                     validClass: "",*/
                    submitHandler: function(form) {
                        var aNewCard = JSaCardShiftNewCardGetDataSourceNewCard(false, false);
                        $.ajax({
                            type: "POST",
                            url: ptRoute,
                            data: $('#ofmAddCardShiftNewCardMainForm').serialize() + "&aNewCard=" + JSON.stringify(aNewCard),
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                console.log(tResult);
                                try {
                                    var oResult = JSON.parse(tResult);
                                    if (oResult.nStaEvent == '1') {
                                        JSvCardShiftNewCardCallPageCardShiftNewCardEdit(oResult.tCodeReturn);
                                    } else {
                                        FSvCMNSetMsgErrorDialog(oResult.tStaMessg);
                                    }
                                } catch (err) {}
                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
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
            console.log("JSnCardShiftNewCardAddEditCardShiftNewCard Error: ", err);
        }
    }

    /**
     * Functionality : Set doc code in table to array
     * Parameters : pbWrapText is true use '', false not use '', pbCardCodeOnly is true return card code only, false return all
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Doc code
     * Return Type : array
     */
    function JSaCardShiftNewCardGetDataSourceNewCard(pbWrapText, pbCardCodeOnly) {
        try {
            pbWrapText = (typeof pbWrapText !== 'undefined') ? pbWrapText : false;
            pbCardCodeOnly = (typeof pbCardCodeOnly !== 'undefined') ? pbCardCodeOnly : true;
            var aData = [];
            var oRecord = JSON.parse(($("#ospCardShiftNewCardCardCodeTemp").text() == '')?'[]':$("#ospCardShiftNewCardCardCodeTemp").text());
            $.each(oRecord.raItems, function(pnIndex, poElement) {
                if (pbWrapText) {
                    if (pbCardCodeOnly) {
                        aData[pnIndex] = "'" + poElement.FTCidCrdCode + "'";
                    } else {
                        aData[pnIndex] = {
                            tNewCardCode: "'" + poElement.FTCidCrdCode + "'",
                            tNewCardName: "'" + poElement.FTCidCrdName + "'",
                            tCardTypeCode: "'" + poElement.FTCtyCode + "'",
                            tDepartmentCode: "'" + poElement.FTCtyName + "'",
                            tNewCardStaRmk: poElement.FTCidRmk,
                            tNewCardStatus: poElement.FTCidStaCrd
                        };
                    }
                } else {
                    if (pbCardCodeOnly) {
                        aData[pnIndex] = poElement.FTCidCrdCode;
                    } else {
                        aData[pnIndex] = {
                            tNewCardCode: poElement.FTCidCrdCode,
                            tNewCardName: poElement.FTCidCrdName,
                            tCardTypeCode: poElement.FTCtyCode,
                            tDepartmentCode: poElement.FTCtyName,
                            tNewCardStaRmk: poElement.FTCidRmk,
                            tNewCardStatus: poElement.FTCidStaCrd
                        };
                    }
                }
            });
            return aData;
        } catch (err) {
            console.log("JSaCardShiftNewCardGetDataSourceNewCard Error: ", err);
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
    function JSxCardShiftNewCardSetCardCodeTemp() {
        try {
            $("#ohdCardShiftNewCardCardCodeTemp").val("");
            setTimeout(function() {
                $("#ohdCardShiftNewCardCardCodeTemp").val(JSaCardShiftNewCardGetDataSourceNewCard(true, true).toString());
            }, 800);
        } catch (err) {
            console.log("JSxCardShiftNewCardSetCardCodeTemp Error: ", err);
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
    function JStCardShiftNewCardGetCardCodeTemp() {
        try {
            return $("#ohdCardShiftNewCardCardCodeTemp").val();
        } catch (err) {
            console.log("JStCardShiftNewCardGetCardCodeTemp Error: ", err);
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
    function JSxCardShiftNewCardSetDataSource(ptCardCode) {
        try {
            console.log("JSxCardShiftNewCardSetDataSource: ", ptCardCode.filter(Boolean));
            if (ptCardCode.filter(Boolean).length < 1) {
                JSvCardShiftNewCardDataSourceTable("", [], [], [], true, "1", true, false, [], "1", "");
                return;
            }

            var aCardCode = [];
            $.each(ptCardCode.filter(Boolean), function(nIndex, tValue) {
                var tCode = "'"+tValue+"'";
                // tCode = tCode.replace('["', "'");
                // tCode = tCode.replace('"]', "'");
                aCardCode[nIndex] = tCode;
            });
            console.log("aCardCode: ", aCardCode);
            if (JCNnCardShiftNewCardCountDataSourceRow(["complete", "pending", "n/a"]) > 0) {
                JSvCardShiftNewCardDataSourceTable("", aCardCode, [], [], false, "1", true, true, [], "3", "");
            } else {
                JSvCardShiftNewCardDataSourceTable("", aCardCode, [], [], false, "1", true, false, [], "3", "");
            }
        } catch (err) {
            console.log("JSxCardShiftNewCardSetDataSource Error: ", err);
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
    function JSxCardShiftNewCardSetDataSourceFilter() {
        try {
            console.log("Set Data Source");
            if ($('input[name=orbCardShiftNewCardSourceMode]:checked').val() == "range") {
                console.log('Range type');
                /**
                 * tCardStaSelectTabRange       สถานะการเลือกแท๊บวิธีการนำเข้าตารางห
                 * tCardShiftNewCardCtyCode     รหัสประเภทบัตร
                 * tCardShiftNewCardDptCode     รหัสแผนก
                 * tSingleAddCardCode           รหัสที่ได้จากการ Gen ข้อมูล
                 * tRangeDataAddPreFix          Prefix ในการต่อข้อมูลรหัสบัตร
                 * tRangeDataAddNumberCode      เลขรันรหัสบัตร
                 * tRangeDataQtyCard            จำนวนที่ต้อการรันรหัสบัตร
                 */
                var tCardStaSelectTabRange = $('#ohdCardShiftNewCardStaSelectTabAdd').val();
                var tCardShiftNewCardCtyCode = $('#oetCardShiftNewCardCtyCode').val();
                var tCardShiftNewCardCtyName = $('#oetCardShiftNewCardCtyName').val();
                var tCardShiftNewCardDptCode = $('#oetCardShiftNewCardDptCode').val();
                var tCardShiftNewCardDptName = $('#oetCardShiftNewCardDptName').val();
                var tSingleAddCardCode = $('#oetSingleAddCardCode').val();
                var tRangeDataAddPreFix = $('#oetRangeDataAddPreFix').val();
                var tRangeDataAddNumberCode = $('#oetRangeDataAddNumberCode').val();
                var tRangeDataQtyCard = $('#oetRangeDataQtyCard').val();
                var oDataCardShiftNewCard = {
                    'tCardStaSelectTabRange': tCardStaSelectTabRange,
                    'tCardShiftNewCardCtyCode': tCardShiftNewCardCtyCode,
                    'tCardShiftNewCardCtyName': tCardShiftNewCardCtyName,
                    'tCardShiftNewCardDptCode': tCardShiftNewCardDptCode,
                    'tCardShiftNewCardDptName': tCardShiftNewCardDptName,
                    'tSingleAddCardCode': tSingleAddCardCode,
                    'tRangeDataAddPreFix': tRangeDataAddPreFix,
                    'tRangeDataAddNumberCode': tRangeDataAddNumberCode,
                    'tRangeDataQtyCard': tRangeDataQtyCard
                };

                if (tCardStaSelectTabRange == 1 && tCardStaSelectTabRange != "") {
                    console.log("Card code temp: ", JSaCardShiftNewCardGetDataSourceNewCard(false, true));
                    if (tSingleAddCardCode != "" && tCardShiftNewCardCtyCode != "" /*&& tCardShiftNewCardDptCode != ""*/) {
                        JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label.xWCheckCondition", false);
                        JSxCardShiftNewCardInsertDataToTemp(oDataCardShiftNewCard);
                    } else {
                        JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label.xWCheckCondition", true);
                    }
                } else if (tCardStaSelectTabRange == 2 && tCardStaSelectTabRange != "") {
                    if (tRangeDataAddNumberCode != "" && tRangeDataQtyCard != "" && tCardShiftNewCardCtyCode != "" /*&& tCardShiftNewCardDptCode != ""*/) {
                        JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label.xWCheckCondition", false);
                        JSxCardShiftNewCardInsertDataToTemp(oDataCardShiftNewCard);
                    } else {
                        JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label.xWCheckCondition", true);
                    }
                } else {}
            }

            if ($('input[name=orbCardShiftNewCardSourceMode]:checked').val() == "file") {
                console.log('File type');
                $("#obtSubmitCardShiftNewCardSearchCardForm").trigger("click");
            }
            JSxCardShiftNewCardSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftNewCardSetDataSourceFilter Error: ", err);
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
    function JSxCardShiftNewCardInsertDataToTemp(poDataSet) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardInsertToTemp",
                    data: {
                        tDataSet: JSON.stringify(poDataSet),
                        tDocNo: $('#oetCardShiftNewCardCode').val(),
                        tBCHCode: $('#ohdCardShiftNewCardUsrBchCode').val()
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success: ", tResult);
                        try {
                            JSvCardShiftNewCardDataSourceTable("", {}, true, "1", false, false, [], "1", "");
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftNewCardInsertDataToTemp Error: ", err);
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
    function JSxCardShiftNewCardUpdateDataOnTemp(poNewCard, pnSeq, pnPage, ptValueNext, ptNextElementID) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardUpdateInlineOnTemp",
                    data: {
                        tNewCard: JSON.stringify(poNewCard),
                        nSeq: pnSeq,
                        tDocNo: $('#oetCardShiftNewCardCode').val()
                    },
                    cache: false,
                    Timeout: 5000,
                    success: function(tResult) {
                        console.log("Success: ", tResult);
                        try {
                            JSvCardShiftNewCardDataSourceTable(pnPage, {}, true, "1", false, false, [], "1", "", ptValueNext, ptNextElementID);
                        } catch (err) {}
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log("JSxCardShiftNewCardInsertDataToTemp Error: ", err);
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
    function JSxCardShiftNewCardVisibleDataSourceMode(poElement, poEvent) {
        try {
            if ($(poElement).val() == "file") {
                JSxCMNVisibleComponent("#odvCardShiftNewCardFileContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftNewCardRangeContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label", false);
            }
            if ($(poElement).val() == "range") {
                JSxCMNVisibleComponent("#odvCardShiftNewCardFileContainer", false);
                JSxCMNVisibleComponent("#odvCardShiftNewCardRangeContainer", true);
                JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label", false);
            }
            JSxCardShiftNewCardSetHeightDataSourceTable();
        } catch (err) {
            console.log("JSxCardShiftNewCardVisibleDataSourceMode Error: ", err);
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
    function JSxCardShiftNewCardSetImportFile(poElement, poEvent) {
        try {
            console.log('Import run');
            var oFile = $(poElement)[0].files[0];
            $("#oetCardShiftNewCardFileTemp").val(oFile.name);
        } catch (err) {
            console.log("JSxCardShiftNewCardSetImportFile Error: ", err);
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
    function JSxCardShiftNewCardImportFileValidate() {
        console.log("Import file validate");
        try {
            $('#ofmSearchCard').validate({
                rules: {
                    oefCardShiftNewCardImport: {
                        required: true,
                        extensionValidate: 'xls|xlsx',
                        fileSizeValidate: '100' // unit mb
                    }
                },
                messages: {
                    oefCardShiftNewCardImport: {
                        required: "<?php echo language('document/card/main', 'tMainExcelErrorFileNotEmpty'); ?>",
                        extensionValidate: "<?php echo language('document/card/main', 'tMainExcelErrorExtendsion'); ?>",
                        fileSizeValidate: "<?php echo language('document/card/main', 'tMainExcelErrorFileSize'); ?>"
                    }
                },
                submitHandler: function(form) {
                    $('#odvModalImportFileConfirm').modal({
                        backdrop: 'static',
                        keyboard: false
                    });
                    $('#odvModalImportFileConfirm').modal('show');
                    $('#odvModalImportFileConfirm #osmConfirm').on('click', function(evt) {
                        $('#odvModalImportFileConfirm').modal('hide');
                        // $('#otbCardShiftNewCardCardTable tbody').empty();
                        // let aNotInCardCode = JStCardShiftNewCardGetCardCodeTemp() == "" ? [] : JStCardShiftNewCardGetCardCodeTemp().split(",");
                        JSvCardShiftNewCardDataSourceTableByFile("", false, "1", true, true, [], "3");
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
            console.log("JSxCardShiftNewCardImportFileValidate Error: ", err);
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
    function JSxCardShiftNewCardSetCountNumber() {
        try {
            var tCountAll = $("#ohdCardShiftNewCardCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftNewCardCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            $("#oetCardShiftNewCardCountNumber").val("");
            $("#oetCardShiftNewCardCountNumber").val(tResult);
            $("#ospCardShiftNewCardDataSourceCount").text("");
            $("#ospCardShiftNewCardDataSourceCount").text(tResult);
        } catch (err) {
            console.log("JSxCardShiftNewCardSetCountNumber Error: ", err);
        }
    }

    /**
     * Functionality : Call Recive Data Source List(Card)
     * @param {number} pnPage, 
     * @param {object} poDataCardShiftNewCard
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
    function JSvCardShiftNewCardDataSourceTable(pnPage, poDataCardShiftNewCard, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType, ptDocNo, ptValueNext, ptNextElementID) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetCardShiftNewCardDataSearch').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                // JCNxOpenLoading();
                console.log("ptStaShift: ", ptStaShift);
                $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardDataSourceTable",
                    data: {
                        tSearchAll: tSearchAll,
                        nPageCurrent: nPageCurrent,
                        tDataCardShiftNewCard: JSON.stringify(poDataCardShiftNewCard),
                        tNotInCardNumber: JSON.stringify(paNotInCardNumber),
                        tSetEmpty: pbSetEmpty == true ? "1" : "0",
                        tStaShift: ptStaShift,
                        tDocNo: ptDocNo,
                        tIsTemp: pbIsTemp == true ? "1" : "0",
                        tIsDataOnly: pbIsDataOnly == true ? "1" : "0",
                        tStaType: ptStaType, // 1: Approve 2: Document status cancel
                        tStaPrcDoc: $("#ohdCardShiftNewCardCardStaPrcDoc").val(),
                        tStaDoc: $("#ohdCardShiftNewCardCardStaDoc").val(),
                        tLastIndex: JCNnCardShiftNewCardCountDataSourceRow(["pending", "n/a", "notfound", "fail"])
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success");
                        try {
                            console.log("typeof: ", JSON.parse(tResult));
                            var oResult = JSON.parse(tResult);
                            if (oResult["rtCode"] == "800") {
                                JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label", false);
                                JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label.xWNotFound", true);
                                JCNxCloseLoading();
                                return;
                            }

                        } catch (err) {

                        }

                        if (tResult != "") {
                            $('#odvCardShiftNewCardDataSource').html(tResult);
                            JSxCardShiftNewCardSetHeightDataSourceTable();
                        }
                        JSxCardShiftNewCardSetCountNumber();
                        JSxCardShiftNewCardSetCardCodeTemp();
                        JSxCMNVisibleComponent("#odvCardShiftNewCardAlert label", false);
                        JCNxCloseLoading();
                        $('#' + ptNextElementID).val(ptValueNext);
                        $('#' + ptNextElementID).focus();
                        $('#' + ptNextElementID).select();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftNewCardDataSourceTable Error: ', err);
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
    function JSvCardShiftNewCardDataSourceTableByFile(pnPage, pbSetEmpty, ptStaShift, pbIsTemp, pbIsDataOnly, paNotInCardNumber, ptStaType) {
        try {
            var tBchCode = $('#ohdCardShiftNewCardUsrBchCode').val();

            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tSearchAll = $('#oetSearchAll').val();
                var nPageCurrent = pnPage;
                if (nPageCurrent == undefined || nPageCurrent == '') {
                    nPageCurrent = '1';
                }
                JCNxOpenLoading();
                //console.log("ptStaShift: ", ptStaShift);

                var oFormData = new FormData();
                var oFile = $('#oefCardShiftNewCardImport')[0].files[0];
                console.log("File: ", oFile);
                oFormData.append('oefCardShiftNewCardImport', oFile);

                oFormData.append('tSearchAll', tSearchAll);
                oFormData.append('nPageCurrent', nPageCurrent);
                oFormData.append('tSetEmpty', pbSetEmpty == true ? "1" : "0");
                oFormData.append('tStaShift', ptStaShift);
                oFormData.append('tIsTemp', pbIsTemp == true ? "1" : "0");
                oFormData.append('tIsDataOnly', pbIsDataOnly == true ? "1" : "0");
                oFormData.append('tNotInCardNumber', JSON.stringify(paNotInCardNumber));
                oFormData.append('tStaPrcDoc', $("#ohdCardShiftNewCardCardStaPrcDoc").val());
                oFormData.append('tStaDoc', $("#ohdCardShiftNewCardCardStaDoc").val());
                oFormData.append('tLastIndex', JCNnCardShiftNewCardCountDataSourceRow(["complete", "pending", "n/a"]));
                oFormData.append('tStaType', ptStaType); // 1: Approve 2: Document status cancel
                oFormData.append('aFile', oFile);
                oFormData.append('tBchCode', tBchCode);

                var tDocNo = $('#oetCardShiftNewCardCode').val();
                if (tDocNo == '' || tDocNo == null) {
                    var tDocNo = '-';
                }
                oFormData.append('tDocNo', tDocNo);

                $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardDataSourceTableByFile",
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
                                JSvCardShiftNewCardDataSourceTable("", {}, true, "1", false, false, [], "1", "");
                            } else {
                                JCNxCloseLoading();
                            }
                        } catch (err) {
                            console.log('JSvCardShiftNewCardDataSourceTableByFile Error: ', err);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvCardShiftNewCardDataSourceTableByFile Error: ', err);
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
    function JSxCardShiftNewCardSearchDataSourceTable() {
        JSvCardShiftNewCardDataSourceTable("", {}, true, "1", false, false, [], "1", "");
    }

    /**
     * Functionality : Set data source table height
     * Parameters : -
     * Creator : 24/10/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftNewCardSetHeightDataSourceTable() {
        /*let nLeftContainerHeight = $(".xWLeftContainer").height();
         $("#odvCardShiftNewCardDataSource .table-responsive").height(nLeftContainerHeight-147);*/
    }

    /**
     * Functionality : Count row in table
     * Parameters : paRowType is ["pending", "complete", "cancel", "n/a", "notfound", "fail"]
     * Creator : 11/10/2018 piya
     * Last Modified : -
     * Return : Row count
     * Return Type : number
     */
    function JCNnCardShiftNewCardCountDataSourceRow(paRowType) {
        try {
            var tCountAll = $("#ohdCardShiftNewCardCountRowFromTemp").val();
            var tCountSuccess = $("#ohdCardShiftNewCardCountSuccess").val();
            if (tCountAll == '' || tCountAll == null || tCountAll == 0) {
                var tResult = '';
            } else {
                var tResult = tCountSuccess + ' / ' + tCountAll;
            }
            return tResult;
        } catch (err) {
            console.log('JCNnCardShiftNewCardCountDataSourceRow Error: ', err);
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
    function JCNbCardShiftNewCardCheckTypeDataSourceRow(ptType) {
        try {
            if (ptType == "pending") {
                var nRow = $('#otbCardShiftNewCardDataSourceList > tr').not('.hidden').not('#otrCardShiftNewCardNoData').length;
            }
            if (ptType == "complete") {

            }
            if (ptType == "cancel") {

            }
            if (ptType == "n/a") {

            }
        } catch (err) {
            console.log('JCNbCardShiftNewCardCheckTypeDataSourceRow Error: ', err);
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
    function JSxCardShiftNewCardStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Empty record check
            if (JCNnCardShiftNewCardCountDataSourceRow(["complete", "pending", "n/a", "cancel", "notfound", "fail"]) == 0) {
                $("#odvCardShiftNewCardModalEmptyCardAlert").modal("show");
                return;
            }

            if (pbIsConfirm) {
                console.log("StaApvDoc Run");
                $("#ohdCardShiftNewCardCardStaPrcDoc").val(2); // Set status for pending approve
                console.log("Data form: ", $('#ofmAddCardShiftNewCardMainForm').serialize());
                $("#odvCardShiftNewCardPopupApv").modal('hide');
                JSxCMNVisibleComponent("#ospCardShiftNewCardApvName", true);
                var aNewCard = JSaCardShiftNewCardGetDataSourceNewCard(false, false);
                $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardEventUpdateApvDocAndCancelDoc",
                    data: $('#ofmAddCardShiftNewCardMainForm').serialize() + "&aNewCard=" + JSON.stringify(aNewCard),
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
                        JSxCardShiftNewGetProgressAfterApvDoc();
                        JSxCardShiftNewCardActionAfterApv();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                console.log("StaApvDoc Call Modal");
                $("#odvCardShiftNewCardPopupApv").modal('show');
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
    function JSxCardShiftNewGetProgressAfterApvDoc(){
        // Document variable
        var tLangCode = $("#ohdCardShiftNewCardLangCode").val();
        var tUsrBchCode = $("#ohdCardShiftNewCardUsrBchCode").val();
        var tUsrApv = $("#ohdCardShiftNewCardApvCode").val();
        var tUsrCode = $("#ohdCardShiftNewCardUsrCode").val();
        var tDocNo = $("#oetCardShiftNewCardCode").val();
        var tPrefix = 'RESNEW';
        var tStaDelMQ = $("#ohdCardShiftNewCardApvCode").val();
        var tStaApv = $("#ohdCardShiftNewCardApvCode").val();
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
            tCallPageEdit: 'JSvCardShiftNewCardCallPageCardShiftNewCardEdit',
            tCallPageList: 'JSvCallPageCardShiftNewCardList'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TFNTCrdImpHD",
            ptDocFieldDocNo: "FTCihDocNo",
            ptDocFieldStaApv: "FTCihStaPrcDoc",
            ptDocFieldStaDelMQ: "FTCihStaDelMQ",
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
    function JSxCardShiftNewCardStaDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            if (pbIsConfirm) {
                console.log("StaDoc Run");
                if (($("#ohdCardShiftNewCardCardStaPrcDoc").val() == "")) { // Pending approve status
                    $("#ohdCardShiftNewCardCardStaDoc").val(3); // Set status for cancel document
                    console.log("Data form: ", $('#ofmAddCardShiftNewCardMainForm').serialize());
                    $("#odvCardShiftNewCardPopupStaDoc").modal('hide');
                    var aNewCard = JSaCardShiftNewCardGetDataSourceNewCard(false, false);
                    $.ajax({
                        type: "POST",
                        url: "cardShiftNewCardEventUpdateApvDocAndCancelDoc",
                        data: $('#ofmAddCardShiftNewCardMainForm').serialize() + "&aNewCard=" + JSON.stringify(aNewCard),
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            console.log("StaDoc: ", tResult);
                            JSvCardShiftNewCardCallPageCardShiftNewCardEdit($("#oetCardShiftNewCardCode").val());
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            } else {
                console.log("StaDoc Call Modal");
                $("#odvCardShiftNewCardPopupStaDoc").modal('show');
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
    function JSbCardShiftNewCardIsStaDelQname(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftNewCardStaDelQname").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftNewCardIsStaDelQname Error: ", err);
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
    function JSbCardShiftNewCardIsStaApv(ptStatus) {
        try {
            ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
            let bStatus = false;
            if (($("#ohdCardShiftNewCardCardStaPrcDoc").val() == ptStatus)) {
                bStatus = true;
            }
            return bStatus;
        } catch (err) {
            console.log("JSbCardShiftNewCardIsStaApv Error: ", err);
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
    function JSbCardShiftNewCardIsApv() {
        var bStatus = false;
        if (($("#ohdCardShiftNewCardCardStaPrcDoc").val() == "1") || ($("#ohdCardShiftNewCardCardStaPrcDoc").val() == "2")) {
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
    function JSbCardShiftNewCardIsStaDoc(ptStaType) {
        var bStatus = false;
        if (ptStaType == "complete") {
            if ($("#ohdCardShiftNewCardCardStaDoc").val() == "1") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "incomplete") {
            if ($("#ohdCardShiftNewCardCardStaDoc").val() == "2") {
                bStatus = true;
            }
            return bStatus;
        }
        if (ptStaType == "cancel") {
            if ($("#ohdCardShiftNewCardCardStaDoc").val() == "3") {
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
    function JSxCardShiftNewCardActionAfterApv() {
        if (JCNbCardShiftNewCardIsUpdatePage()) {
            if (JSbCardShiftNewCardIsApv() || JSbCardShiftNewCardIsStaDoc("cancel")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnCancelApv", false);
                $("#oetCardShiftNewCardDocDate").attr("disabled", true);
                $(".xCNBtnDateTime").attr("disabled", true);
                if (JSbCardShiftNewCardIsApv()) {
                    JSxCMNVisibleComponent("#ospCardShiftNewCardApvName", true);
                }
                if (JSbCardShiftNewCardIsStaDoc("cancel")) {
                    JSxCMNVisibleComponent("#ospCardShiftNewCardApvName", false);
                }
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnSave", false);
            } else {
                console.log("Show Apv");
                $("#oetCardShiftNewCardDocDate").attr("disabled", false);
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnApv", true);
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftNewCardApvName", false);
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnSave", true);
            }

            if (!JSbCardShiftNewCardIsApv() && JSbCardShiftNewCardIsStaDoc("incomplete")) {
                console.log("Hide Apv");
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnApv", false);
                JSxCMNVisibleComponent("#obtCardShiftNewCardBtnCancelApv", true);
                JSxCMNVisibleComponent("#ospCardShiftNewCardApvName", false);
            }
        }

        if (JCNbCardShiftNewCardIsCreatePage()) {
            JSxCMNVisibleComponent("#obtCardShiftNewCardBtnSave", true);
        }
    }

    /**
     * Functionality : Action to print document
     * Parameters : -
     * Creator : 29/10/2018 piya
     * Last Modified : 16/10/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftNewCardPrint() {
        var tUsrBchCode = $("#ohdCardShiftNewCardUsrBchCode").val();
        var tDocNo = $("#oetCardShiftNewCardCode").val();
        var aInfor = [
			{"Lang"         : '<?php echo FCNaHGetLangEdit(); ?>'}, // Lang ID
			{"ComCode"      : '<?php echo FCNtGetCompanyCode(); ?>'}, // Company Code
			{"BranchCode"   : '<?=FCNtGetAddressBranch($tUserBchCode); ?>' }, // สาขาที่ออกเอกสาร
			{"DocCode"      : tDocNo }, // เลขที่เอกสาร
            {"DocBchCode"   : '<?= $tUserBchCode; ?>'}
		];
		window.open("<?php echo base_url(); ?>formreport/Frm_SQL_FCCardNew?infor=" + JCNtEnCodeUrlParameter(aInfor), '_blank');
    }
</script>

<?php include 'jCardShiftNewCardDataSourceTable.php'; ?>


<script>
    //เลือกสาขา วัฒน์ 13/08/2020
    $("#obtBrowseBCH_CardShiftNewCard").click(function() {
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
                Value: ["oetBCHCode_CardShiftNewCard", "TCNMBranch.FTBchCode"],
                Text: ["oetBCHName_CardShiftNewCard", "TCNMBranch_L.FTBchName"]
            },
            NextFunc: {
                FuncName: 'JSxSetConfigBCH_CardShiftNewCard',
                ArgReturn: ['FTBchCode']
            },
            RouteAddNew: 'branch',
            BrowseLev: 1
        };
        JCNxBrowseData('oBrowse_Branch');
    });

    function JSxSetConfigBCH_CardShiftNewCard(params) {
        if (params == 'NULL') {
            var tValue = '';
            $('#oetBCHName_CardShiftNewCard').focus();
        } else {
            var tJSON = JSON.parse(params);
            var tBCHCode = tJSON[0];
            var tValue = tBCHCode;
        }

        $('#ohdCardShiftNewCardUsrBchCode').val(tValue);
    }
</script>