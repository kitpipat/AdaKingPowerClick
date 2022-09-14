<script type="text/javascript">
    $(document).ready(function() {
        window.rowValidate = $('#ofmCardShiftReturnDataSourceForm').validate({
            messages: {

            },
            submitHandler: function(form) {

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
                $(element).addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).addClass("has-success").removeClass("has-error");
            }
        });
    });


    /**
     * Functionality : กด Delete
     * Parameters : poElement is Itself element, poEvent is Itself event
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnDataSourceDeleteOperator(poElement, poEvent, pnPage, ptOldCardCode, pnSeq) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                pnPage = (typeof pnPage !== 'undefined') ? pnPage : 1;
                if (JSbCardShiftReturnIsApv() || JSbCardShiftReturnIsStaDoc("cancel")) {
                    return;
                }
                $('#ospCardShiftReturnConfirDelMessage').html(ptOldCardCode);
                $('#odvCardShiftReturnModalConfirmDelRecord').modal({
                    backdrop: 'static',
                    keyboard: false
                });
                $('#odvCardShiftReturnModalConfirmDelRecord').modal('show');
                $('#osmCardShiftReturnConfirmDelRecord').unbind().click(function(evt) {
                    $('#odvCardShiftReturnModalConfirmDelRecord').modal('hide');
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
                            JSvCardShiftReturnDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
                        },
                        error: function(data) {
                            console.log(data);
                        }
                    });

                    //มูลค่าที่เหลือ
                    //JSxCardShiftReturnSetCountNumber();
                    //JSxCardShiftReturnSetCardCodeTemp();
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSxCardShiftReturnDataSourceDeleteOperator Error: ', err);
        }
    }

    /**
     * Functionality : กดปุ่ม save 
     * Parameters : poElement is Itself element, poEvent is Itself event, pnSeq is index in loop
     * Creator : 24/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnDataSourceSaveOperator(poElement, poEvent) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                var tRecordId = $(poElement).parents('.xWCardShiftReturnDataSource').attr('id');
                var oPrefixNumber = tRecordId.match(/\d+/);

                var tRmk = $(poElement).parents('.xWCardShiftReturnDataSource').find('.xWCardShiftReturnCardRmk').val();
                var tStaCard = $(poElement).parents('.xWCardShiftReturnDataSource').data('sta-card');
                if(tStaCard == "1" && tRmk != "") {
                    tRmk = $(poElement).parents('.xWCardShiftReturnDataSource').find('.xWCardShiftReturnCardRmk').val();
                }else{
                    tRmk = "";
                }

                var oRecord = {
                    nPage: $('#ohdCardShiftReturnDataSourceCurrentPage').val(),
                    nSeq: $(poElement).parents('.xWCardShiftReturnDataSource').data('seq'),
                    tCode: $(poElement).parents('.xWCardShiftReturnDataSource').find('.xWCardShiftReturnCardCode input[type=text]').val(),
                    tRmk: tRmk
                };
                
                // Update in document temp
                JSxCardShiftReturnUpdateDataOnTemp(oRecord.tCode, oRecord.nSeq, oRecord.nPage, oRecord.tRmk);
                // Remove Seft Record Backup
                localStorage.removeItem(tRecordId);
                // Visibled icons
                JSxCardShiftReturnDataSourceVisibledOperationIcon(poElement, 'save', false); // Itself hidden(save)
                JSxCardShiftReturnDataSourceVisibledOperationIcon(poElement, 'cancel', false); // hidden cancel icon
                JSxCardShiftReturnDataSourceVisibledOperationIcon(poElement, 'edit', true); // show edit icon
                $(poElement) // Active BTN
                    .parents('.xWCardShiftReturnDataSource')
                    .find('.xWCardShiftReturnCardCode input[type=text]')
                    .attr('disabled', true)
                    .removeAttr('readonly')
                    .removeClass('btn');

                $(poElement) // Active TEXT
                    .parents('.xWCardShiftReturnDataSource')
                    .find('.xWCardShiftReturnCardRmk input[type=text]')
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
     * Functionality : ฟังก์ชั่น save edit in line  
     * Parameters : tCardCode, tNewCardCode, tReasonCode, pnPage
     * Creator : 27/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnUpdateDataOnTemp(ptCardCode, pnSeq, pnPage, ptRmk) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $.ajax({
                    type: "POST",
                    url: "cardShiftReturnUpdateInlineOnTemp",
                    data: {
                        tCardCode: ptCardCode,
                        nSeq: pnSeq,
                        tRmk: ptRmk
                    },
                    cache: false,
                    Timeout: 0,
                    success: function(tResult) {
                        //alert('success');
                        JSvCardShiftReturnDataSourceTable(pnPage, [], [], [], [], [], true, "1", false, false, [], "1", "");
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
     * Functionality : control ปุ่ม เซฟ ยกเลิก บันทึก
     * Parameters : [poElement] is seft element in scope(<tr class="xWCardShiftReturnDataSource">), 
     * [ptOperation] is icon type(edit, cancel, save), [pbVisibled] is true = show, false = hide
     * Creator : 07/12/2018 piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxCardShiftReturnDataSourceVisibledOperationIcon(poElement, ptOperation, pbVisibled) {
        try {
            switch (ptOperation) {
                case 'edit': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftReturnDataSource')
                                .find('.xWCardShiftReturnEdit'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftReturnDataSource')
                                .find('.xWCardShiftReturnEdit'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'cancel': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftReturnDataSource')
                                .find('.xWCardShiftReturnCancel'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftReturnDataSource')
                                .find('.xWCardShiftReturnCancel'))
                            .addClass('hidden');
                    }
                    break;
                }
                case 'save': {
                    if (pbVisibled) { // show
                        $($(poElement) // Unhidden Cancel of seft group
                                .parents('.xWCardShiftReturnDataSource')
                                .find('.xWCardShiftReturnSave'))
                            .removeClass('hidden');
                    } else { // hide
                        $($(poElement) // Hidden Cancel of seft group
                                .parents('.xWCardShiftReturnDataSource')
                                .find('.xWCardShiftReturnSave'))
                            .addClass('hidden');
                    }
                    break;
                }
                default: {}
            }
        } catch (err) {
            console.log('JJSxCardShiftReturnDataSourceVisibledOperationIcon Error: ', err);
        }
    }

    //Page
    function JSvCardShiftReturnDataSourceClickPage(ptPage, tDocType, ptIDElement) {
        JCNxOpenLoading();
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                nPageOld = $('.xWCardShiftReturnDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWCardShiftReturnDataSourcePage .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvCardShiftReturnDataSourceTable(nPageCurrent, [], [], [], [], [], true, "1", false, false, [], "1", "");
    }
</script>