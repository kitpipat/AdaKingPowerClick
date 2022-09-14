<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftStatusDataSourceForm').validate({
            /*rules: {
             oetCardShiftStatusCardName1: {
             required: true,
             uniqueCardShiftStatusCode: JCNbCardShiftStatusIsCreatePage(),
             maxlength: 20
             },
             ['oetCardShiftStatusNewCardName' + pnSeq]: {
             required: true
             }
             },*/
            messages: {
                // oetCardShiftStatusCode: "",
                // oetCardShiftStatusName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftStatusGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftStatusCallPageCardShiftStatusEdit($("#oetCardShiftStatusCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
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

        $("#otbCardShiftStatusCardTable .xCNCardShiftStatusCardCode").unbind().bind("change", function(){
            console.log("Change Card");
            JSxCardShiftStatusDataSourceSaveOperator(this, null);
        });

        $('#otbCardShiftStatusCardTable .xCNCardShiftStatusCardRmk').unbind().bind('change keyup', function(event){                
            if(event.keyCode == 13) {
                JSxCardShiftStatusDataSourceSaveOperator(this, null);
            }
            if(event.type == "change"){
                JSxCardShiftStatusDataSourceSaveOperator(this, null);
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
    function JSxCardShiftStatusDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;
                if (JSbCardShiftStatusIsApv() || JSbCardShiftStatusIsStaDoc("cancel")) {
                    return;
                }
                $('#ospCardShiftStatusConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftStatusModalConfirmDelRecord').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#odvCardShiftStatusModalConfirmDelRecord').modal('show');
                $('#osmCardShiftStatusConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftStatusModalConfirmDelRecord').modal('hide');
                    $.ajax({
                        type: "POST",
                        url: "CallDeleteTemp",
                        data: {
                            ptID: ptOldCardCode,
                            pnSeq: pnSeq,
                            ptDocType: "cardShiftStatus"
                        },
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            JSvCardShiftStatusDataSourceTable(pnPage, [], [], [], true, "1", false, false, [], "1", "");
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });
                    JSxCardShiftStatusSetCountNumber();
                    JSxCardShiftStatusSetCardCodeTemp();
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftStatusDataSourceDeleteOperator Error: ', err);
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
    function JSxCardShiftStatusDataSourceSaveOperator(poElement, poEvent) {
        try {
            var tRecordId = $(poElement).parents('.xWCardShiftStatusDataSource').attr('id');
            var oPrefixNumber = tRecordId.match(/\d+/);

            var tRmk = $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardRmk input[type=text]').val();
            var tStaCard = $(poElement).parents('.xWCardShiftStatusDataSource').data('sta-card');
            if(tStaCard == "1" && tRmk != "") {
                tRmk = $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardRmk input[type=text]').val();
            }else{
                tRmk = "";
            }

            let oRecord = {
                nPage: $('#ohdCardShiftStatusDataSourceCurrentPage').val(),
                nSeq: $(poElement).parents('.xWCardShiftStatusDataSource').data('seq'),
                tNewCardCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=hidden]').val(),
                tNewCardName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusNewCardCode input[type=text]').val(),
                tOldCardCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=hidden]').val(),
                tOldCardName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusCardCode input[type=text]').val(),
                tReasonCode: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=hidden]').val(),
                tReasonName: $(poElement).parents('.xWCardShiftStatusDataSource').find('.xWCardShiftStatusReason input[type=text]').val(),
                tRmk: tRmk
            };

            // Update in document temp
            JSxCardShiftStatusUpdateDataOnTemp(oRecord.tOldCardCode, oRecord.tNewCardCode, oRecord.tReasonCode, oRecord.nSeq, oRecord.nPage, oRecord.tRmk);

            // Remove Seft Record Backup
            localStorage.removeItem(tRecordId);

        } catch (err) {
            console.log('JSxSaveOperator Error: ', err);
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
    function JSxCardShiftStatusValidateInline() {
        $('#obtCardShiftStatusSubmitForm').click();
        $('#ofmCardShiftStatusDataSourceForm').validate({
            rules: {
                oetCardShiftStatusCardName1: {
                    required: true,
                    uniqueCardShiftStatusCode: JCNbCardShiftStatusIsCreatePage(),
                    maxlength: 20
                },
                oetCardShiftStatusNewCardName1: {
                    required: true
                }
            },
            messages: {
                // oetCardShiftStatusCode: "",
                // oetCardShiftStatusName: ""
            },
            /*errorClass: "alert-validate",
             validClass: "",*/
            submitHandler: function(form) {
                /*var aCardPack = JSaCardShiftStatusGetDataSourceCode("cardPack", false);
                 console.log("aCardCode: ", aCardPack);
                 $.ajax({
                 type: "POST",
                 url: ptRoute,
                 data: $('#ofmAddCardShiftStatusMainForm').serialize() + "&" + $('#ofmSearchCard').serialize() + "&aCard=" + JSON.stringify(aCardPack),
                 cache: false,
                 timeout: 0,
                 success: function(tResult) {
                 JSvCardShiftStatusCallPageCardShiftStatusEdit($("#oetCardShiftStatusCode").val());
                 },
                 error: function(jqXHR, textStatus, errorThrown) {
                 JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
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
    function JSnCardShiftStatusChkValidateSaveRow(paDataChkValidateRow) {
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

    function JSvCardShiftStatusDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftStatusDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftStatusDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftStatusDataSourceTable(nPageCurrent, [], [], [], true, "1", false, false, [], "1", "");
        // JSvClickCallTableTemp(tDocType, nPageCurrent, ptIDElement);
    }
</script>