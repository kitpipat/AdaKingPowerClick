var nStaPhwBrowseType = $('#oetPhwStaBrowse').val();
var tCallPhwBackOption = $('#oetPhwCallBackOption').val();

$('document').ready(function() {


});

//function : Function Clear Defult Button SaleMachineDevice
//Parameters : Document Ready
//Creator : 07/11/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPhwNavDefult() {
    if (nStaPhwBrowseType != 1 || nStaPhwBrowseType == undefined) {
        $('.xCNPhwVBrowse').hide();
        $('.xCNPhwVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPhwTitleAdd').hide();
        $('#oliPhwTitleEdit').hide();
        $('#oliPhwTitleAddPageDivice').hide();
        $('#odvBtnMacAddEdit').hide();
        $('#odvBtnMacPhwInfo').show();
    } else {
        $('#odvModalBody .xCNPhwVMaster').hide();
        $('#odvModalBody .xCNPhwVBrowse').show();
        $('#odvModalBody #odvPhwMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPhwNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPhwBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPhwBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPhwBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function
//Creator : 07/11/2018 witsarut
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


//function : Call SaleMachineDevice Page list
//Parameters : Document Redy And Event Button
//Creator :	07/11/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSaleMachineDeviceIndex(pnPosCode) {
    $.ajax({
        type: 'GET',
        url: "salemachinedevice/0/0",
        data: {
            'tPosCode': pnPosCode
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('.odvMainContent').html(tResult);
            JSxPhwNavDefult();
            JSvCallPageSaleMachineDeviceList(pnPosCode);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    })
}

//function : Call SaleMachine Page list
//Parameters : Document Redy And Event Button
//Creator :	07/11/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSaleMachineIndex() {
    $.ajax({
        type: 'POST',
        url: "salemachine/0/0",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('.odvMainContent').html(tResult);
            // JSvCallPageSaleMachineDeviceList();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    })
}
//function : Call SaleMachineDevice Page list
//Parameters : Document Redy And Event Button
//Creator :	07/11/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSaleMachineDeviceList(pnPosCode) {
    localStorage.tStaPageNow = 'JSvCallPageSaleMachineDeviceList';
    $('#oetSearchSaleMachineDevice').val('');

    $.ajax({
        type: "POST",
        url: "salemachinedeviceList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageSaleMachineDevice').html(tResult);
            JSvSaleMachineDeviceDataTable(1, pnPosCode);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call SaleMachineDevice Data List
//Parameters: Ajax Success Event
//Creator:	07/11/2018 witsarut
//Return: View
//Return Type: View
function JSvSaleMachineDeviceDataTable(pnPage, pnPosCode) {
    var tSearchAll = $('#oetSearchSaleMachineDevice').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    JCNxOpenLoading();
    var tSMDBchCode = $('#oetPosBchCode').val();
    $.ajax({
        type: "POST",
        url: "salemachinedeviceDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
            nPosCode: pnPosCode,
            tBchCode : tSMDBchCode
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvMachineContentPage').html(tResult);
                $('#odvBtnMacPhwSearch').show();
                $('#odvMngTableList').show();

            }
            JSxPhwNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call SaleMachineDevice Page Add
//Parameters : Event Button Click
//Creator : 07/11/2018 witsarut
//Update : 03/04/2019 pap
//Return : View
//Return Type : View
function JSvCallPageSaleMachineDeviceAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    var tPosCode = $('#oetPosCode').val();

    var tBchCode = $('#oetPosBchCode').val();
    $.ajax({
        type: "POST",
        url: "salemachinedevicePageAdd",
        cache: false,
        data: {
            'tPosCode': tPosCode ,
            'tBchCode' : tBchCode
         },
        timeout: 0,
        success: function(tResult) {
            if (nStaPhwBrowseType == 1) {
                $('.xCNPhwVMaster').hide();
                $('.xCNPhwVBrowse').show();

            } else {
                $('.xCNPhwVBrowse').hide();
                $('.xCNPhwVMaster').show();
                $('#oliPhwTitleEdit').hide();

                $('#oliPhwTitleAdd').show();
                $('#oliPhwTitleAddPageDivice').hide();
                $('#odvBtnMacPhwInfo').hide();
                $('#odvBtnMacAddEdit').show();
            }
            $('#odvMachineContentPage').html(tResult);
            $('#odvBtnMacPhwSearch').hide();
            $('#odvMngTableList').hide();

            $('#ocbPhwAutoGenCode').change(function() {
                $("#oetPhwCode").val("");
                if ($('#ocbPhwAutoGenCode').is(':checked')) {
                    $("#oetPhwCode").attr("readonly", true);
                    $("#oetPhwCode").attr("onfocus", "this.blur()");
                    $('#odvPhwCodeForm').removeClass('has-error');
                    $('#odvPhwCodeForm em').remove();
                } else {
                    $("#oetPhwCode").attr("readonly", false);
                    $("#oetPhwCode").removeAttr("onfocus");
                }
            });

            $("#oetPhwCode").blur(function() {
                if (!$('#ocbPhwAutoGenCode').is(':checked')) {
                    if ($("#ohdCheckPhwClearValidate").val() == 1) {
                        $('#ofmAddSaleMachineDevice').validate().destroy();
                        $("#ohdCheckPhwClearValidate").val("0");
                    }

                    if ($("#ohdCheckPhwClearValidate").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "salemachineCheckInputGenCode",
                            data: {
                                tPhwCode: $("#oetPhwCode").val(),
                                tPosCode: $("#ohdPosCodeMachinedevice").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePhwCode").val(aResult["rtCode"]);
                                JSxValidationFormPhw("", $("#ohdPhwRoute").val());
                                JSxValidationFormPhw("", $("#ohdBchCode").val());
                                $('#ofmAddSaleMachineDevice').submit();
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
function JSxValidationFormPhw(pFnSubmitName, ptRoute) {
    // alert(pFnSubmitName);
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "salemachinedeviceEventAdd") {
            if ($('#ocbPhwAutoGenCode').is(':checked')) {
                return true;
            } else {
                if ($("#ohdCheckDuplicatePhwCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    });
    $('#ofmAddSaleMachineDevice').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetPhwCode: {
                "required": {
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if (ptRoute == "salemachinedeviceEventAdd") {
                            if ($('#ocbPhwAutoGenCode').is(':checked')) {
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
            oetPhwName: {
                "required": {}
            },
            oetNamePrinter: {
                "required": {
                    depends: function(oElement) {

                        if ($("#ocmShwPrinter").val() == 1 ||
                            $("#ocmShwPrinter").val() == 4 ||
                            $("#ocmShwPrinter").val() == 6) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            },
            oetBaudRate: {
                "required": {
                    depends: function(oElement) {

                        if ($("#ocmShwPrinter").val() == 6) {
                            return true;
                        } else {
                            return false;
                        }
                    }
                }
            }
        },
        messages: {
            oetPhwCode: {
                "required"       : $('#oetPhwCode').attr('data-validate-required'),
                "dublicateCode"  : $('#oetPhwCode').attr('data-validate-dublicateCode')
            },
            oetPhwName: {
                "required": $('#oetPhwName').attr('data-validate-required')
            },
            oetNamePrinter: {
                "required": $('#oetNamePrinter').attr('data-validate-required')
            },
            oetBaudRate: {
                "required": $('#oetBaudRate').attr('data-validate-required')
            }
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
            if (pFnSubmitName != "") {
                window[pFnSubmitName](ptRoute);
            }
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
    if ($("#ohdCheckPhwClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddSaleMachineDevice').serialize(),
            success: function(oResult) {
                if (nStaPhwBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPageSaleMachineDeviceEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageSaleMachineDeviceAdd();
                                break;
                            case '3':
                                JSvSaleMachineDeviceDataTable(1, aReturn['tPosCode']);
                                break;
                            default:
                                JSvCallPageSaleMachineDeviceEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call SaleMachineDevice Page Edit
//Parameters : Event Button Click
//Creator : 07/11/2018 witsarut
//Update : 03/04/2019 pap
//Return : View
//Return Type : View
function JSvCallPageSaleMachineDeviceEdit(ptPhwCode,ptBchCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageSaleMachineDeviceEdit', ptPhwCode);
    var tPosCode = $('#oetPosCode').val();
    $.ajax({
        type: "POST",
        url: "salemachinedevicePageEdit",
        data: {
            'tPhwCode'  : ptPhwCode,
            'tPosCode'  : tPosCode,
            'ptBchCode' : ptBchCode
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaPhwBrowseType == 1) {
                $('.xCNPhwVMaster').hide();
                $('.xCNPhwVBrowse').show();

            } else {
                $('.xCNPhwVBrowse').hide();
                $('.xCNPhwVMaster').show();
                $('#oliPhwTitleEdit').show();

                $('#oliPhwTitleAdd').hide();
                $('#oliPhwTitleAddPageDivice').hide();
                $('#odvBtnMacPhwInfo').hide();
                $('#odvBtnMacAddEdit').show();
            }

            oComport = $('#ocmComport').val();
                $("#ocmComport option[value='" + oComport + "']").attr('selected', true).trigger('change');


            $('#odvMachineContentPage').html(tResult);
            $('#odvBtnMacPhwSearch').hide();
            $('#odvMngTableList').hide();
            $('#oetPhwCode').addClass('xCNDisable');
            $('#oetPhwCode').attr('readonly', true);
            $('.xCNBtnGenCode').attr('disabled', true);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Functionality : set click status submit form from save button
//Parameters : -
//Creator : 26/03/2019 pap
//Return : -
//Return Type : -
function JSxSetStatusClickPhwSubmit() {
    $("#ohdCheckPhwClearValidate").val("1");
}

function JSoAddEditSaleMachineDevice(ptRoute) {
//   alert (ptRoute);
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddSaleMachineDevice').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "salemachinedeviceEventAdd") {
                if ($("#ohdCheckDuplicatePhwCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddSaleMachineDevice').validate({
            rules: {
                oetPhwCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "salemachinedeviceEventAdd") {
                                if ($('#ocbPhwAutoGenCode').is(':checked')) {
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

                oetPhwName: {
                    "required": {}
                },
                oetNamePrinter: {
                    "required": {
                        depends: function(oElement) {

                            if ($("#ocmShwPrinter").val() == 1 ||
                                $("#ocmShwPrinter").val() == 4 ||
                                $("#ocmShwPrinter").val() == 6) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                },
                oetBaudRate: {
                    "required": {
                        depends: function(oElement) {

                            if ($("#ocmShwPrinter").val() == 6) {
                                return true;
                            } else {
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                oetPhwCode: {
                    "required": $('#oetPhwCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetPhwCode').attr('data-validate-dublicateCode')
                },
                oetPhwName: {
                    "required": $('#oetPhwName').attr('data-validate-required'),
                    "dublicateCode": $('#oetPhwCode').attr('data-validate-dublicateCode')
                },
                oetNamePrinter: {
                    "required": $('#oetNamePrinter').attr('data-validate-required'),
                    "dublicateCode": $('#oetPhwCode').attr('data-validate-dublicateCode')
                },
                oetBaudRate: {
                    "required": $('#oetBaudRate').attr('data-validate-required'),
                    "dublicateCode": $('#oetPhwCode').attr('data-validate-dublicateCode')
                }
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
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddSaleMachineDevice').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        console.log(tResult);
                        if (nStaPhwBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                JSvSaleMachineDeviceDataTable(1, aReturn['tPosCode']);
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
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





//Functionality : Generate Code SaleMachineDevice
//Parameters : Event Button Click
//Creator : 07/11/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateSaleMachineDeviceCode() {
    $('#oetPhwCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPosHW';
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
                $('#oetPhwCode').val(tData.rtPhwCode);
                $('#oetPhwCode').addClass('xCNDisable');
                $('#oetPhwCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPhwName').focus();
            } else {
                $('#oetPhwCode').val(tData.rtDesc);
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
//Creator : 07/11/2018 witsarut
//Update : 03/04/2019 pap
//Return : object Status Delete
//Return Type : object
function JSoSaleMachineDeviceDel(pnPage, ptName, tIDCode, tYesOnNo, ptBchCode) {
    var tPosCode = $('#ohdPosCode').val();
    var aData       = $('#ohdConfirmIDDelete').val();
    var aTexts      = aData.substring(0, aData.length - 2);
    var aDataSplit      = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;

    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelSaleMachineDevice').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + tYesOnNo);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                $.ajax({
                    type: "POST",
                    url: "salemachinedeviceEventDelete",
                    data: {
                        'tIDCode'   : tIDCode,
                        'tPosCode'  : $("#oetPosCode").val(),
                        'ptBchCode' : ptBchCode
                    },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        // $('#odvModalDelSaleMachineDevice').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvSaleMachineDeviceDataTable(pnPage,tPosCode);



                        if (tData['nStaEvent'] == '1') {
                            $('#odvModalDelSaleMachineDevice').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if (tData["nNumRowPhw"] != 0) {
                                    if (tData["nNumRowPhw"] > 10) {
                                        nNumPage = Math.ceil(tData["nNumRowPhw"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvSaleMachineDeviceDataTable(pnPage, $("#oetPosCode").val());
                                        } else {
                                            JSvSaleMachineDeviceDataTable(nNumPage, $("#oetPosCode").val());
                                        }
                                    } else {
                                        JSvSaleMachineDeviceDataTable(1, $("#oetPosCode").val());
                                    }
                                } else {
                                    JSvSaleMachineDeviceDataTable(1, $("#oetPosCode").val());
                                }
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(tData['tStaMessg']);
                        }
                        JSxPhwNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }

}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 07/11/2018 witsarut
//Update : 03/04/2019 pap
//Return:  object Status Delete
//Return Type: object
function JSoSaleMachineDeviceDelChoose(pnPage) {
    JCNxOpenLoading();
    var tCurrentPage = $("#nCurrentPageTB").val();
    var tPosCode = $('#ohdPosCode').val();
    var tNamepage = '';
    var aDataIdBranch = '';
    var nStaBrowse = '';
    var tStaInto = '';
    var aData       = $('#ohdConfirmIDDelete').val();
    var aDataBch    = $('#ohdConfirmBchDelete').val();
    //console.log('DATA : ' + aData);

    var aTexts      = aData.substring(0, aData.length - 2);
    var aTextsBch   = aDataBch.substring(0, aDataBch.length - 2);

    var aDataSplit      = aTexts.split(" , ");
    var aDataBchSplit   = aTextsBch.split(" , ");

    var aDataSplitlength = aDataSplit.length;

    var aNewIdDelete = [];
    var aNewBchDelete = [];





    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
        aNewBchDelete.push(aDataBchSplit[$i]);
    }

    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "salemachinedeviceEventDelete",
            data: {
                'tIDCode'    : aNewIdDelete,
                'tPosCode'   : $("#oetPosCode").val() ,
                'ptBchCode'  : aNewBchDelete
            },
            success: function(tResult) {

                // JSxPhwNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelSaleMachineDevice').modal('hide');
                //     JSvSaleMachineDeviceDataTable(pnPage,tPosCode);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);

                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelSaleMachineDevice').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowPhw"] != 0) {
                            if (aReturn["nNumRowPhw"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPhw"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvSaleMachineDeviceDataTable(tCurrentPage, $("#oetPosCode").val());
                                } else {
                                    JSvSaleMachineDeviceDataTable(nNumPage, $("#oetPosCode").val());
                                }
                            } else {
                                JSvSaleMachineDeviceDataTable(1, $("#oetPosCode").val());
                            }
                        } else {
                            JSvSaleMachineDeviceDataTable(1, $("#oetPosCode").val());
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxPhwNavDefult();


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
    //         url: "salemachinedeviceEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelSaleMachineDevice').modal('hide');
    //                     JSvCallPageSaleMachineDeviceList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPhwNavDefult();
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
//Creator : 07/11/2018 witsarut
//Return : View
//Return Type : View
function JSvSaleMachineDeviceClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageSaleMachineDevice .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageSaleMachineDevice .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvSaleMachineDeviceDataTable(nPageCurrent, $("#oetPosCode").val());
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 07/11/2018 witsarut
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
//Creator: 07/11/2018 witsarut
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        var tBchCode  = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';

            tBchCode += aArrayConvert[0][$i].tBch;
            tBchCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
        $('#ohdConfirmBchDelete').val(tBchCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 07/11/2018 witsarut
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
