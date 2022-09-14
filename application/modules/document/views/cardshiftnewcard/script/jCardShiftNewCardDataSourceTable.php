<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftNewCardDataSourceForm').validate({
            /*rules: {
             oetCardShiftNewCardCardName1: {
             required: true,
             uniqueCardShiftNewCardCode: JCNbCardShiftNewCardIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftNewCardNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftNewCardCode: "",
                // oetCardShiftNewCardName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftNewCardGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftNewCardMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftNewCardCallPageCardShiftNewCardEdit($("#oetCardShiftNewCardCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
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
    function JSxCardShiftNewCardDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq, pntFNSeq,ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                poElement = (typeof poElement !== 'undefined') ? poElement : null;
                poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;
                pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;
                ptOldCardCode = (typeof ptOldCardCode !== 'undefined') ? ptOldCardCode : "";
                pnSeq = (typeof pnSeq !== 'undefined') ? pnSeq : 0;

                if (JSbCardShiftNewCardIsApv() || JSbCardShiftNewCardIsStaDoc("cancel")) {
                    return;
                }

                $('#ospCardShiftNewCardConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftNewCardModalConfirmDelRecord').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#odvCardShiftNewCardModalConfirmDelRecord').modal('show');

                $('#osmCardShiftNewCardConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftNewCardModalConfirmDelRecord').modal('hide');

                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {
                            ptID: ptOldCardCode,
                            pnSeq: pnSeq,
                            ptDocType: "NewCard",
                            ptDocNo:ptDocNo
                        },
                        cache: false,
                        success: function(tResult) {
                            JSvCardShiftNewCardDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                            // JSxCardShiftNewCardDataSourceSaveOperator(poElement, poEvent, pntFNSeq, pnPage);
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });

                    JSxCardShiftNewCardSetCountNumber();
                    JSxCardShiftNewCardSetCardCodeTemp();
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftNewCardDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : Edit Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftNewCardDataSourceEditOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                poElement = (typeof poElement !== 'undefined') ? poElement : null;
                poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;

                if (JSbCardShiftNewCardIsApv() || JSbCardShiftNewCardIsStaDoc("cancel")) {
                    return;
                }
                var tRecordId = $(poElement).parents('.xWCardShiftNewCardDataSource').attr('id');
                var oRecord = {
                    tNewCardCode: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCardCode input[type=text]').val(),
                    tHolderID: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardHolderID input[type=text]').val(),
                    tNewCardName: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCardName input[type=text]').val(),
                    tCardTypeCode: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCty input[type=hidden]').val(),
                    tCardTypeName: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCty input[type=text]').val(),
                    tDepartmentCode: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardDepart input[type=hidden]').val(),
                    tDepartmentName: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardDepart input[type=text]').val(),

                    tRmk: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardRmk input[type=hidden]').val(),
                    tRmkName: $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardRmk input[type=text]').val()

                };
                // Backup Seft Record
                localStorage.setItem(tRecordId, JSON.stringify(oRecord));

                // Visibled icons
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon

                $(poElement) // Active New Card Code Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCardCode input[type=text]')
                    .removeAttr('disabled')
                    .addClass('active');

                $(poElement) // Active HolderID Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardHolderID input[type=text]')
                    .removeAttr('disabled')
                    .addClass('active');

                $(poElement) // Active New Card Name Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCardName input[type=text]')
                    .removeAttr('disabled')
                    .addClass('active');

                $(poElement) // Active Card Type Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCty input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

                $(poElement) // Active Department Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardDepart input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

                $(poElement) // Active TEXT
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardRmk input[type=text]')
                    .removeAttr('disabled')
                    .attr('maxlength', 50)
                    .addClass('text');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxEditOperator Error: ', err);
        }
    }

    /**
     * Functionality : Cancel Edit Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftNewCardDataSourceCancelOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                poElement = (typeof poElement !== 'undefined') ? poElement : null;
                poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;

                var tRecordId = $(poElement).parents('.xWCardShiftNewCardDataSource').attr('id');

                // Restore Seft Record
                var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCardCode input[type=text]').val(oBackupRecord.tNewCardCode);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardHolderID input[type=text]').val(oBackupRecord.tHolderID);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCardName input[type=text]').val(oBackupRecord.tNewCardName);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCty input[type=hidden]').val(oBackupRecord.tCardTypeCode);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCty input[type=text]').val(oBackupRecord.tCardTypeName);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardDepart input[type=hidden]').val(oBackupRecord.tDepartmentCode);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardDepart input[type=text]').val(oBackupRecord.tDepartmentName);

                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardRmk input[type=hidden]').val(oBackupRecord.tRmk);
                $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardRmk input[type=text]').val(oBackupRecord.tRmkName);

                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);

                // Visibled icons
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

                $(poElement) // Remove Active New Card Code Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeClass('active');

                $(poElement) // Remove Active HolderID Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardHolderID input[type=text]')
                    .attr('disabled', true)
                    .removeClass('active');

                $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCardName input[type=text]')
                    .attr('disabled', true)
                    .removeClass('active');

                $(poElement) // Remove Active Card Type Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCty input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Remove Active Department Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardDepart input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Active TEXT
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardRmk input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly', true)
                    .removeClass('text ');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCancelOperator Error: ', err);
        }
    }

    /**
     * Functionality : Confirm Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftNewCardDataSourceSaveOperator(poElement, poEvent, pnSeq, pnPage,ptValueNext,ptNextElementID) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                poElement = (typeof poElement !== 'undefined') ? poElement : null;
                poEvent = (typeof poEvent !== 'undefined') ? poEvent : null;
                pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;
                pnSeq = (typeof pnSeq !== 'undefined') ? pnSeq : 0;

                var tRecordId = $(poElement).parents('.xWCardShiftNewCardDataSource').attr('id');
                var oPrefixNumber = tRecordId.match(/\d+/);
                var oDataChkValidateRow = {
                    'nPage': $('#ohdCardShiftNewCardDataSourceCurrentPage').val(),
                    'nSeq': $(poElement).parents('.xWCardShiftNewCardDataSource').data('seq'),
                    'tCrdShiftNewCardCode': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCardCode input[type=text]').val(),
                    'tCrdShiftNewCardHolderID': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardHolderID input[type=text]').val(),
                    'tCrdShiftNewCardName': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCardName input[type=text]').val(),
                    'tCrdShiftNewCtyCode': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCty input[type=hidden]').val(),
                    'tCrdShiftNewCtyName': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardCty input[type=text]').val(),
                    'tCrdShiftNewDptCode': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardDepart input[type=hidden]').val(),
                    'tCrdShiftNewDptName': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardDepart input[type=text]').val(),
                    'tCrdShiftNewRmk': $(poElement).parents('.xWCardShiftNewCardDataSource').find('.xWCardShiftNewCardRmk input[type=text]').val(),
                    'tValueNext': ptValueNext,
                    'tNextElementID':ptNextElementID
                };


                JSxCardShiftNewCardUpdateDataOnTemp(oDataChkValidateRow, pnSeq, pnPage,ptValueNext,ptNextElementID);

                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);
                // Visibled icons
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
                JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

                $(poElement) // Remove Active New Card Code Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeClass('active');

                $(poElement) // Remove Active HolderID Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardHolderID input[type=text]')
                    .attr('disabled', true)
                    .removeClass('active');

                $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCardName input[type=text]')
                    .attr('disabled', true)
                    .removeClass('active');

                $(poElement) // Remove Active Card Type Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardCty input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Remove Active Department Field.
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardDepart input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');


                $(poElement) // Active TEXT
                    .parents('.xWCardShiftNewCardDataSource')
                    .find('.xWCardShiftNewCardRmk input[type=text]')
                    .attr('disabled', true)
                    .removeClass('text');
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
     * Functionality : Visibled operation icon
     * Parameters : [poElement] is seft element in scope(<tr class="otrCardShiftNewCardDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftNewCardDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftNewCardDataSource')
                                .find('.xWCardShiftNewCardEdit'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftNewCardDataSource')
                                .find('.xWCardShiftNewCardEdit'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'cancel': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftNewCardDataSource')
                                .find('.xWCardShiftNewCardCancel'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftNewCardDataSource')
                                .find('.xWCardShiftNewCardCancel'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'save': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftNewCardDataSource')
                                .find('.xWCardShiftNewCardSave'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftNewCardDataSource')
                                .find('.xWCardShiftNewCardSave'))
                            .addClass('hidden');
                    }
                    break;
                }
                default: {}
            }
        } catch (err) {
            console.log('JJSxCardShiftNewCardDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    /**
     * Functionality : Function Check Validate Row Tabel
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 10/12/2018 wasin(Yoshi)
     * Return : Status Check Validate
     * Return Type : Number
     */
    function JSnCardShiftNewCardChkValidateSaveRow(paDataChkValidateRow) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
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
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('Error JSnCardShiftNewCardChkValidateSaveRow' + err);
        }
    }

    /**
     * Functionality : Function Check Validate Row Tabel
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 10/12/2018 wasin(Yoshi)
     * Return : Status Check Validate
     * Return Type : Number
     */
    function JSnCardShiftNewCardChkValidateSaveRow(paDataChkValidateRow) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
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
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('Error JSnCardShiftNewCardChkValidateSaveRow' + err);
        }
    }

    function JSvCardShiftNewCardDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftNewCardDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftNewCardDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftNewCardDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
    }
</script>