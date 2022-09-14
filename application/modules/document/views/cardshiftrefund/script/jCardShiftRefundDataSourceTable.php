<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftRefundDataSourceForm').validate({
            /*rules: {
             oetCardShiftRefundCardName1: {
             required: true,
             uniqueCardShiftRefundCode: JCNbCardShiftRefundIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftRefundNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftRefundCode: "",
                // oetCardShiftRefundName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftRefundGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftRefundMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftRefundCallPageCardShiftRefundEdit($("#oetCardShiftRefundCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                 }
                 });*/
            },
            /*errorPlacement: function(error, element) {
             $(element).parent('.validate-input').attr('data-validate', error[0].textContent);
             }
             highlight: function(element, errorClass, validClass) {
             $(element).parent().addClass(errorClass).removeClass(validClass);
             },
             unhighlight: function(element, errorClass, validClass) {
             $(element).parent().removeClass(errorClass).addClass(validClass);
             },*/
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
                $(element).addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("has-success").removeClass("has-error");
            }
        });
    });

    /**
     * Functionality : Delete Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;

                if (JSbCardShiftRefundIsApv() || JSbCardShiftRefundIsStaDoc("cancel")) {
                    return;
                }
                $('#ospCardShiftRefundConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftRefundModalConfirmDelRecord').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#odvCardShiftRefundModalConfirmDelRecord').modal('show');
                $('#osmCardShiftRefundConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftRefundModalConfirmDelRecord').modal('hide');
                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {
                            ptID: ptOldCardCode,
                            pnSeq: pnSeq,
                            ptDocType: "cardShiftRefund"
                        },
                        cache: false,
                        success: function(tResult) {
                            JSvCardShiftRefundDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftRefundDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : Confirm Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundDataSourceSaveOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftRefundDataSource').attr('id');
            console.log("poElement: ", poElement);
            console.log("tRecordId: ", tRecordId);
            var oPrefixNumber = tRecordId.match(/\d+/);

            var tRmk = $(poElement).parents('.xWCardShiftRefundDataSource').find('.xWCardShiftRefundRmk').val();
            var tStaCard = $(poElement).parents('.xWCardShiftRefundDataSource').data('sta-card');
            if (tStaCard == "1" && tRmk != "") {
                tRmk = $(poElement).parents('.xWCardShiftRefundDataSource').find('.xWCardShiftRefundRmk').val();
            } else {
                tRmk = "";
            }

            var oRecord = {
                nPage: $('#ohdCardShiftRefundDataSourceCurrentPage').val(),
                nSeq: $(poElement).parents('.xWCardShiftRefundDataSource').data('seq'),
                tCardCode: $(poElement).parents('.xWCardShiftRefundDataSource').find('.xWCardShiftRefundCardCode input[type=text]').val(),
                tCardValue: $(poElement).parents('.xWCardShiftRefundDataSource').find('.xWCardShiftRefundValue input[type=text]').val(),
                tRmk: tRmk
            };

            // Update in document temp
            JSxCardShiftRefundUpdateDataOnTemp(oRecord.tCardCode, oRecord.tCardValue, oRecord.nSeq, oRecord.nPage, oRecord.tRmk);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);
        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
     * Functionality : ฟังก์ชั่น save edit in line  
     * Parameters : tCardCode, tCardTPCode, nSeq, nPage
     * Creator : 08/01/2019 Krit(Copter)
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundUpdateDataOnTemp(ptCardCode, ptCardValue, pnSeq, pnPage, ptRmk) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundUpdateInlineOnTemp",
                    data: {
                        tCardCode: ptCardCode,
                        tCardValue: ptCardValue,
                        nSeq: pnSeq,
                        tRmk: ptRmk
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        console.log("Success: ", tResult);
                        try {
                            JSvCardShiftRefundDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
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
            console.log("JSxCardShiftRefundInsertDataToTemp Error: ", err);
        }
    }

    /**
     * Functionality : Visibled operation icon
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftRefundDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftRefundDataSource')
                                .find('.xWCardShiftRefundEdit'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftRefundDataSource')
                                .find('.xWCardShiftRefundEdit'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'cancel': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftRefundDataSource')
                                .find('.xWCardShiftRefundCancel'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftRefundDataSource')
                                .find('.xWCardShiftRefundCancel'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'save': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftRefundDataSource')
                                .find('.xWCardShiftRefundSave'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftRefundDataSource')
                                .find('.xWCardShiftRefundSave'))
                            .addClass('hidden');
                    }
                    break;
                }
                default: {}
            }
        } catch (err) {
            console.log('JJSxCardShiftRefundDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    /**
     * Functionality : Validate inline.
     * Parameters : -
     * Creator : 26/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftRefundValidateInline() {
        $('#obtCardShiftRefundSubmitForm').click();
        $('#ofmCardShiftRefundDataSourceForm').validate({
            rules: {
                oetCardShiftRefundCardName1: {
                    required: true,
                    uniqueCardShiftRefundCode: JCNbCardShiftRefundIsCreatePage(),
                    maxlength: 20
                },
                oetCardShiftRefundNewCardName1: {
                    required: true
                }
            },
            messages: {
                // oetCardShiftRefundCode: "",
                // oetCardShiftRefundName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftRefundGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftRefundMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftRefundCallPageCardShiftRefundEdit($("#oetCardShiftRefundCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                 }
                 });*/
            },
            /*errorPlacement: function(error, element) {
             $(element).parent('.validate-input').attr('data-validate', error[0].textContent);
             }
             highlight: function(element, errorClass, validClass) {
             $(element).parent().addClass(errorClass).removeClass(validClass);
             },
             unhighlight: function(element, errorClass, validClass) {
             $(element).parent().removeClass(errorClass).addClass(validClass);
             },*/
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
                $(element).addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("has-success").removeClass("has-error");
            }
        });
    }

    /**
     * Functionality : Function Check Validate Row Tabel
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 10/12/2018 wasin(Yoshi)
     * Return : Status Check Validate
     * Return Type : Number
     */
    function JSnCardShiftRefundChkValidateSaveRow(paDataChkValidateRow) {
        try {
            if (paDataChkValidateRow['tCrdShiftNewCardCode'] != "") {
                var nStaChkCodeDup = $.ajax({
                    type: "POST",
                    url: "cardShiftNewCardChkCardCodeDup",
                    data: {
                        tCardCodeChkDup: paDataChkValidateRow['tCrdShiftNewCardCode']
                    },
                    async: false
                }).responseText;
                if (nStaChkCodeDup != 0) {
                    return 4;
                }
            } else {
                return 1;
            }

            if (paDataChkValidateRow['tCrdShiftNewCardName'] != "") {
                var tCharacterReg = /^\s*[a-z,A-Z,ก-๙, ,0-9,@,-]+\s*$/;
                var tCardName = paDataChkValidateRow['tCrdShiftNewCardName'];
                if (tCharacterReg.test(tCardName) == false) {
                    return 16;
                }
            }

            if (paDataChkValidateRow['tCrdShiftNewCtyCode'] == "" && paDataChkValidateRow['tCrdShiftNewCtyName'] == "") {
                return 5;
            }

            if (paDataChkValidateRow['tCrdShiftNewDptCode'] == "" && paDataChkValidateRow['tCrdShiftNewDptName'] == "") {
                return 12;
            }
            return 0;
        } catch (err) {
            console.log('Error JSnCardShiftNewCardChkValidateSaveRow' + err);
        }
    }

    //Page
    function JSvCardShiftRefundDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftRefundDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftRefundDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftRefundDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
        // JSvClickCallTableTemp(tDocType, nPageCurrent, ptIDElement);
    }
</script>