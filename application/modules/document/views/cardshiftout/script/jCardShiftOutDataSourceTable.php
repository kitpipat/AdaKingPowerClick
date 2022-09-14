<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftOutDataSourceForm').validate({
            /*rules: {
             oetCardShiftOutCardName1: {
             required: true,
             uniqueCardShiftOutCode: JCNbCardShiftOutIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftOutNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftOutCode: "",
                // oetCardShiftOutName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftOutGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftOutMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftOutCallPageCardShiftOutEdit($("#oetCardShiftOutCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
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
    function JSxCardShiftOutDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;
                if (JSbCardShiftOutIsApv() || JSbCardShiftOutIsStaDoc("cancel")) {
                    return;
                }
                $('#ospCardShiftOutConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftOutModalConfirmDelRecord').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#odvCardShiftOutModalConfirmDelRecord').modal('show');
                $('#osmCardShiftOutConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftOutModalConfirmDelRecord').modal('hide');

                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {
                            ptID: ptOldCardCode,
                            pnSeq: pnSeq,
                            ptDocType: "cardShiftOut"
                        },
                        cache: false,
                        success: function(tResult) {
                            JSvCardShiftOutDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });

                    JSxCardShiftOutSetCountNumber();
                    JSxCardShiftOutSetCardCodeTemp();

                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftOutDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : Edit Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutDataSourceEditOperator(poElement, poEvent, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                if (JSbCardShiftOutIsApv() || JSbCardShiftOutIsStaDoc("cancel")) {
                    return;
                }
                JSxCardShiftOutSetCardCodeTemp();
                var tRecordId = $(poElement).parents('.xWCardShiftOutDataSource').attr('id');
                var oRecord = {
                    tNewCardCode: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutNewCardCode input[type=hidden]').val(),
                    tNewCardName: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutNewCardCode input[type=text]').val(),
                    tOldCardCode: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardCode input[type=hidden]').val(),
                    tOldCardName: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardCode input[type=text]').val(),
                    tReasonCode: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutReason input[type=hidden]').val(),
                    tReasonName: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutReason input[type=text]').val(),

                    tRmk: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardRmk input[type=hidden]').val(),
                    tRmkName: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardRmk input[type=text]').val()
                };
                // Backup Seft Record
                localStorage.setItem(tRecordId, JSON.stringify(oRecord));

                // Visibled icons
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'edit', false); // Itself hidden(edit)
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'cancel', true); // hidden cancel icon
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'save', true); // hidden save icon

                $(poElement) // Active Old Card Code Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

                $(poElement) // Active New Card Name Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutNewCardCode input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');

                $(poElement) // Active Reason Name Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutReason input[type=text]')
                    .removeAttr('disabled')
                    .attr('readonly', true)
                    .addClass('btn');


                $(poElement) // Active TEXT
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutCardRmk input[type=text]')
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
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutDataSourceCancelOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tRecordId = $(poElement).parents('.xWCardShiftOutDataSource').attr('id');

                // Restore Seft Record
                var oBackupRecord = JSON.parse(localStorage.getItem(tRecordId));
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutNewCardCode input[type=hidden]').val(oBackupRecord.tNewCardCode);
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutNewCardCode input[type=text]').val(oBackupRecord.tNewCardName);
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardCode input[type=hidden]').val(oBackupRecord.tOldCardCode);
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardCode input[type=text]').val(oBackupRecord.tOldCardName);
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutReason input[type=hidden]').val(oBackupRecord.tReasonCode);
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutReason input[type=text]').val(oBackupRecord.tReasonName);

                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardRmk input[type=hidden]').val(oBackupRecord.tRmk);
                $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardRmk input[type=text]').val(oBackupRecord.tRmkName);


                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);

                // Visibled icons
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'cancel', false); // Itself hidden(cancel)
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'save', false); // hidden save icon
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

                $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');


                $(poElement) // Active TEXT
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutCardRmk input[type=text]')
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
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutDataSourceSaveOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tRecordId = $(poElement).parents('.xWCardShiftOutDataSource').attr('id');
                var oPrefixNumber = tRecordId.match(/\d+/);

                var tRmk = $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardRmk').val();
                var tStaCard = $(poElement).parents('.xWCardShiftOutDataSource').data('sta-card');
                if(tStaCard == "1" && tRmk != "") {
                    tRmk = $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardRmk').val();
                }else{
                    tRmk = "";
                }

                var oRecord = {
                    nPage: $('#ohdCardShiftOutDataSourceCurrentPage').val(),
                    nSeq: $(poElement).parents('.xWCardShiftOutDataSource').data('seq'),
                    tCardCode: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardCode').val(),
                    tCardName: $(poElement).parents('.xWCardShiftOutDataSource').find('.xWCardShiftOutCardName').val(),
                    tRmk: tRmk
                };

                // Update in document temp
                JSxCardShiftOutUpdateDataOnTemp(oRecord.tCardCode, oRecord.nSeq, oRecord.nPage, oRecord.tRmk);

                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);

                // Visibled icons
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
                JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon

                $(poElement) // Remove Active Old Card Code Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Remove Active New Card Name Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutNewCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Remove Active Reason Name Field.
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutReason input[type=text]')
                    .attr('disabled', true)
                    .attr('readonly', true)
                    .removeClass('btn');


                $(poElement) // Active TEXT
                    .parents('.xWCardShiftOutDataSource')
                    .find('.xWCardShiftOutCardRmk input[type=text]')
                    .attr('disabled', true)
                    .removeClass('text');
                F
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
     * Functionality : Visibled operation icon
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftOutDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftOutDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftOutDataSource')
                                .find('.xWCardShiftOutEdit'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftOutDataSource')
                                .find('.xWCardShiftOutEdit'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'cancel': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftOutDataSource')
                                .find('.xWCardShiftOutCancel'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftOutDataSource')
                                .find('.xWCardShiftOutCancel'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'save': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftOutDataSource')
                                .find('.xWCardShiftOutSave'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftOutDataSource')
                                .find('.xWCardShiftOutSave'))
                            .addClass('hidden');
                    }
                    break;
                }
                default: {}
            }
        } catch (err) {
            console.log('JJSxCardShiftOutDataSourceVisibledOperationIcon Error: ', err);
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
    function JSxCardShiftOutValidateInline() {
        $('#obtCardShiftOutSubmitForm').click();
        $('#ofmCardShiftOutDataSourceForm').validate({
            rules: {
                oetCardShiftOutCardName1: {
                    required: true,
                    uniqueCardShiftOutCode: JCNbCardShiftOutIsCreatePage(),
                    maxlength: 20
                },
                oetCardShiftOutNewCardName1: {
                    required: true
                }
            },
            messages: {
                // oetCardShiftOutCode: "",
                // oetCardShiftOutName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftOutGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftOutMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftOutCallPageCardShiftOutEdit($("#oetCardShiftOutCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftOutResponseError(jqXHR, textStatus, errorThrown);
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
    function JSnCardShiftOutChkValidateSaveRow(paDataChkValidateRow) {
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

    function JSvCardShiftOutDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftOutDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftOutDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftOutDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
    }
</script>