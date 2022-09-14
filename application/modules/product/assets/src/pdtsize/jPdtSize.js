var nStaPszBrowseType = $('#oetPszStaBrowse').val();
var tCallPszBackOption = $('#oetPszCallBackOption').val();
// alert(nStaPszBrowseType+'//'+tCallPszBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPszNavDefult();
    if (nStaPszBrowseType != 1) {
        JSvCallPagePdtPszList();
    } else {
        JSvCallPagePdtPszAdd();
    }
});

//function : Function Clear Defult Button Product Size
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPszNavDefult() {
    if (nStaPszBrowseType != 1 || nStaPszBrowseType == undefined) {
        $('.xCNPszVBrowse').hide();
        $('.xCNPszVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPszTitleAdd').hide();
        $('#oliPszTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPszInfo').show();
    } else {
        $('#odvModalBody .xCNPszVMaster').hide();
        $('#odvModalBody .xCNPszVBrowse').show();
        $('#odvModalBody #odvPszMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPszNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPszBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPszBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPszBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 17/10/2018 witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    JCNxCloseLoading();
    var tHtmlError = $(jqXHR.responseText);
    var tMsgError = "<h3 style='font-size:20px;color:red'>";
    tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgError += " Error<hr></h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgError += tHtmlError.find('p:nth-child(2)').text();
            break;
        case 500:
            tMsgError += tHtmlError.find('p:nth-child(3)').text();
            break;

        default:
            tMsgError += 'something had error. please contact admin';
            break;
    }
    $("body").append(tModal);
    $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tMsgError);
}

//function : Call Product Size Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPszList() {
    localStorage.tStaPageNow = 'JSvCallPagePdtPszList';
    $('#oetSearchPdtPsz').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtsizeList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPagePdtPsz').html(tResult);
            JSvPdtPszDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Size Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPdtPszDataTable(pnPage) {
    var tSearchAll = $('#oetSearchPdtPsz').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtsizeDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataPdtPsz').html(tResult);
            }
            JSxPszNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtSize_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Size Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPszAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtsizePageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaPszBrowseType == 1) {
                $('.xCNPszVMaster').hide();
                $('.xCNPszVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNPszVBrowse').hide();
                $('.xCNPszVMaster').show();
                $('#oliPszTitleEdit').hide();
                $('#oliPszTitleAdd').show();
                $('#odvBtnPszInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtPsz').html(tResult);
            $('#ocbPszAutoGenCode').change(function() {
                $("#oetPszCode").val("");
                $("#ohdCheckDuplicatePszCode").val("1");
                if ($('#ocbPszAutoGenCode').is(':checked')) {
                    $("#oetPszCode").attr("readonly", true);
                    $("#oetPszCode").attr("onfocus", "this.blur()");
                    $('#ofmAddPdtPsz').removeClass('has-error');
                    $('#ofmAddPdtPsz em').remove();
                } else {
                    $("#oetPszCode").attr("readonly", false);
                    $("#oetPszCode").removeAttr("onfocus");
                }
            });
            $("#oetPszCode").blur(function() {
                if (!$('#ocbPszAutoGenCode').is(':checked')) {
                    if ($("#ohdCheckPszClearValidate").val() == 1) {
                        $('#ofmAddPdtPsz').validate().destroy();
                        $("#ohdCheckPszClearValidate").val("0");
                    }
                    if ($("#ohdCheckPszClearValidate").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: {
                                tTableName: "TCNMPdtSize",
                                tFieldName: "FTPszCode",
                                tCode: $("#oetPszCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePszCode").val(aResult["rtCode"]);
                                JSxValidationFormPsz("", $("#ohdPdtGroupRoute").val());
                                // $('#ofmAddPdtPsz').submit();

                            },
                            error: function(jqXHR, textStatus, errorThrown) {
                                JCNxResponseError(jqXHR, textStatus, errorThrown);
                            }
                        });
                    }
                }
            });
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : center validate form
//Parameters : function submit name, route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidationFormPsz(pFnSubmitName, ptRoute) {
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "pdtsizeEventAdd") {
            if ($('#ocbPszAutoGenCode').is(':checked')) {
                return true;
            } else {
                if ($("#ohdCheckDuplicatePszCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    }, '');
    $('#ofmAddPdtPsz').validate({
        rules: {
            oetPszCode: {
                "required": {
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if (ptRoute == "pdtsizeEventAdd") {
                            if ($('#ocbPszAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    }
                },
                "dublicateCode": {}
            },
            oetPszName: {
                "required": {}
            }
        },
        messages: {
            oetPszCode: {
                "required": $('#oetPszCode').attr('data-validate-required'),
                "dublicateCode": $('#oetPszCode').attr('data-validate-dublicateCode')
            },
            oetPszName: {
                "required": $('#oetPszName').attr('data-validate-required')
            },
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
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function(element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function(form) {
            // if (pFnSubmitName != "") {
            //     window[pFnSubmitName](ptRoute);
            // }
        }
    });


}

//Functionality : function submit by submit button only
//Parameters : route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton(ptRoute) {

    if ($("#ohdCheckPszClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtPsz').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nStaPszBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtPszEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtPszAdd();
                                break;
                            case '3':
                                JSvCallPagePdtPszList();
                                break;
                            default:
                                JSvCallPagePdtPszEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                } else {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPszBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Product Size Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPszEdit(ptPszCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtPszEdit', ptPszCode);
    $.ajax({
        type: "POST",
        url: "pdtsizePageEdit",
        data: { tPszCode: ptPszCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliPszTitleAdd').hide();
                $('#oliPszTitleEdit').show();
                $('#odvBtnPszInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPsz').html(tResult);
                $('#oetPszCode').addClass('xCNDisable');
                $('#oetPszCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality : Add Data Product Size Add/Edit  
//Parameters : from ofmAddPdtPsz
//Creator : 25/07/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSoAddEditPdtPsz(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddPdtPsz').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "pdtsizeEventAdd") {
                if ($("#ohdCheckDuplicatePszCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddPdtPsz').validate({
            rules: {
                oetPszCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "pdtsizeEventAdd") {
                                if ($('#ocbPszAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },

                oetPszName: { "required": {} },

            },
            messages: {
                oetPszCode: {
                    "required": $('#oetPszCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetPszCode').attr('data-validate-dublicateCode')
                },
                oetPszName: {
                    "required": $('#oetPszName').attr('data-validate-required'),
                    "dublicateCode": $('#oetPszName').attr('data-validate-dublicateCode')
                },

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
            },
            submitHandler: function(form) {
                $.ajax({
                    cache: false,
                    timeout: 0,
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddPdtPsz').serialize(),
                    success: function(tResult) {
                        if (nStaPszBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPagePdtPszEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPagePdtPszAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPagePdtPszList();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxBrowseData(tCallPszBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}


//Functionality : Generate Code Product Size
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtPszCode() {
    $('#oetPszCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtSize';
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetPszCode').val(tData.rtPszCode);
                $('#oetPszCode').addClass('xCNDisable');
                $('#oetPszCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPszName').focus();
            } else {
                $('#oetPszCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoPdtPszDel(pnPage, ptName, tIDCode, tYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtPsz').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + tYesOnNo);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtsizeEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);

                        // $('#odvModalDelPdtPsz').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtPszDataTable(pnPage);
                        if (aReturn['nStaEvent'] == '1') {
                            $('#odvModalDelPdtPsz').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if (aReturn["nNumRowPsz"] != 0) {
                                    if (aReturn["nNumRowPsz"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowPsz"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvPdtPszDataTable(pnPage);
                                        } else {
                                            JSvPdtPszDataTable(nNumPage);
                                        }
                                    } else {
                                        JSvPdtPszDataTable(1);
                                    }
                                } else {
                                    JSvPdtPszDataTable(1);
                                }
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxPszNavDefult();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
    // var aData               = $('#ospConfirmIDDelete').val();
    // var aTexts              = aData.substring(0, aData.length - 2);
    // var aDataSplit          = aTexts.split(" , ");
    // var aDataSplitlength    = aDataSplit.length;
    // var aNewIdDelete        = [];
    // if (aDataSplitlength == '1'){

    //     $('#odvModalDelPdtPsz').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtsizeEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtPsz').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtPszDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxPszNavDefult();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     });
    // }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoPdtPszDelChoose(pnPage) {
    JCNxOpenLoading();

    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }

    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "pdtsizeEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                // JSxPszNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtPsz').modal('hide');
                //     JSvPdtPszDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);


                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelPdtPsz').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowPsz"] != 0) {
                            if (aReturn["nNumRowPsz"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPsz"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvPdtPszDataTable(pnPage);
                                } else {
                                    JSvPdtPszDataTable(nNumPage);
                                }
                            } else {
                                JSvPdtPszDataTable(1);
                            }
                        } else {
                            JSvPdtPszDataTable(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxPszNavDefult();


            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }
    // JCNxOpenLoading();
    // var aData       = $('#ospConfirmIDDelete').val();
    // var aTexts      = aData.substring(0, aData.length - 2);
    // var aDataSplit  = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    // var aNewIdDelete = [];
    // for ($i = 0; $i < aDataSplitlength; $i++) {
    //     aNewIdDelete.push(aDataSplit[$i]);
    // }
    // if (aDataSplitlength > 1){
    //     localStorage.StaDeleteArray = '1';
    //     $.ajax({
    //         type: "POST",
    //         url: "pdtsizeEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtPsz').modal('hide');
    //                     JSvCallPagePdtPszList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPszNavDefult();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }else{
    //     localStorage.StaDeleteArray = '0';
    //     return false;
    // }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvPdtPszClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtPsz .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtPsz .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtPszDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 17/10/2018 witsarut
//Return: - 
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 17/10/2018 witsarut
//Return: -
//Return Type: -
function JSxTextinModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 17/10/2018 witsarut
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}