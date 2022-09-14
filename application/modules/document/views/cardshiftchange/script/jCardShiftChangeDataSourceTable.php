<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftChangeDataSourceForm').validate({
            /*rules: {
             oetCardShiftChangeCardName1: {
             required: true,
             uniqueCardShiftChangeCode: JCNbCardShiftChangeIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftChangeNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftChangeCode: "",
                // oetCardShiftChangeName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftChangeCallPageCardShiftChangeEdit($("#oetCardShiftChangeCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
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
    function JSxCardShiftChangeDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;

            if (JSbCardShiftChangeIsApv() || JSbCardShiftChangeIsStaDoc("cancel")) {
                return;
            }
            $('#ospCardShiftChangeConfirDelMessage').html(ptOldCardCode);
            $('#odvCardShiftChangeModalConfirmDelRecord').modal({
                backdrop: 'static',
                keyboard: false
            });
            $('#odvCardShiftChangeModalConfirmDelRecord').modal('show');

            $('#osmCardShiftChangeConfirmDelRecord').unbind().click(function(evt) {

                $('#odvCardShiftChangeModalConfirmDelRecord').modal('hide');

                $.ajax({
                    type: "POST",
                    url: "CallDeleteTemp",
                    data: {
                        ptID: ptOldCardCode,
                        pnSeq: pnSeq,
                        ptDocType: "CardTnfChangeCard"
                    },
                    cache: false,
                    success: function(tResult) {
                        JSvCardShiftChangeDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                    },
                    error: function(data) {
                        console.log(data);
                    }
                });

                JSxCardShiftChangeSetCountNumber();
                JSxCardShiftChangeSetCardCodeTemp();

            });

        } catch (err) {
            console.log('JSxCardShiftChangeDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : Confirm Record Before to Save.
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop, pnSeq
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDataSourceSaveOperator(poElement, poEvent, pnSeq) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftChangeDataSource').attr('id');
            var oPrefixNumber = tRecordId.match(/\d+/);

            var tRmk = $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardRmk').val();
            var tStaCard = $(poElement).parents('.xWCardShiftChangeDataSource').data('sta-card');
            if (tStaCard == "1" && tRmk != "") {
                tRmk = $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardRmk').val();
            } else {
                tRmk = "";
            }

            let oRecord = {
                nPage: $('#ohdCardShiftChangeDataSourceCurrentPage').val(),
                nSeq: $(poElement).parents('.xWCardShiftChangeDataSource').data('seq'),
                tNewCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftChangeDataSource').find('.xWCardShiftChangeReason input[type=text]').val(),

                tRmk: tRmk
            };

            // เช็ค Validate Row
            /*var nStaChkSaveRow = JSnCardShiftChangeChkValidateSaveRow(aDataChkValidateRow);
            if (nStaChkSaveRow == 0) {
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatusRmk').val(nStaChkSaveRow);
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatus').val(1);
            } else {
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatusRmk').val(nStaChkSaveRow);
                $('#' + tRecordId + ' .xWCardShiftChangeStatus .xWNewCardStatus').val(2);
            }*/

            // Update in document temp
            JSxCardShiftChangeUpdateDataOnTemp(oRecord.tOldCardCode, oRecord.tNewCardCode, oRecord.tReasonCode, oRecord.nSeq, oRecord.nPage, oRecord.tRmk);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
        }
    }

    /**
     * Functionality : Visibled operation icon
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftChangeDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftChangeDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeEdit'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeEdit'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'cancel': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeCancel'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeCancel'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'save': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeSave'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftChangeDataSource')
                                .find('.xWCardShiftChangeSave'))
                            .addClass('hidden');
                    }
                    break;
                }
                default: {}
            }
        } catch (err) {
            console.log('JJSxCardShiftChangeDataSourceVisibledOperationIcon Error: ', err);
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
    function JSxCardShiftChangeValidateInline() {
        $('#obtCardShiftChangeSubmitForm').click();
        $('#ofmCardShiftChangeDataSourceForm').validate({
            rules: {
                oetCardShiftChangeCardName1: {
                    required: true,
                    uniqueCardShiftChangeCode: JCNbCardShiftChangeIsCreatePage(),
                    maxlength: 20
                },
                oetCardShiftChangeNewCardName1: {
                    required: true
                }
            },
            messages: {
                // oetCardShiftChangeCode: "",
                // oetCardShiftChangeName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftChangeGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftChangeMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftChangeCallPageCardShiftChangeEdit($("#oetCardShiftChangeCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
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
    function JSnCardShiftChangeChkValidateSaveRow(paDataChkValidateRow) {
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

    function JSvCardShiftChangeDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftChangeDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftChangeDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftChangeDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
        // JSvClickCallTableTemp(tDocType, nPageCurrent, ptIDElement);
    }
</script>