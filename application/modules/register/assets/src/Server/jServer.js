var nStaSrvBrowseType = $('#oetSrvStaBrowse').val();
var tCallSrvBackOption = $('#oetSrvCallBackOption').val();
// alert(nStaSrvBrowseType+'//'+tCallSrvBackOption);

$('document').ready(function() {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSrvNavDefult();
    if (nStaSrvBrowseType != 1) {
        JSvCallPageServerList(1);
    } else {
        JSvCallPageServerAdd();
    }
    localStorage.removeItem('LocalItemData');
});

///function : Function Clear Defult Button Product Unit
//Parameters : Document Ready
//Creator : 13/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxSrvNavDefult() {
    if (nStaSrvBrowseType != 1 || nStaSrvBrowseType == undefined) {
        $('.xCNSrvVBrowse').hide();
        $('.xCNSrvVMaster').show();
        $('.xCNChoose').hide();
        $('#oliSrvTitleAdd').hide();
        $('#oliSrvTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnSrvInfo').show();
    } else {
        $('#odvModalBody #odvSrvMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliSrvNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvSrvBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNSrvBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNSrvBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 13/09/2018 wasin
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

//function : Call Product Unit Page list  
//Parameters : Document Redy And Event Button
//Creator :	13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageServerList(pnPage) {
    localStorage.tStaPageNow = 'JSvCallPageServerList';
    $('#oetSearchAll').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "ServerList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageServer').html(tResult);
            JSvServerDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function : Call Product Unit Data List
//Parameters : Ajax Success Event 
//Creator:	13/09/2018 wasin
//Return : View
//Return Type : View
function JSvServerDataTable(pnPage) {
    var tSearchAll = $('#oetSearchServer').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "ServerDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataServer').html(tResult);
            }
            JSxSrvNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TRGMPosSrv_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Unit Page Add  
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPageServerAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "ServerPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaSrvBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNSrvVBrowse').hide();
                $('.xCNSrvVMaster').show();
                $('#oliSrvTitleEdit').hide();
                $('#oliSrvTitleAdd').show();
                $('#odvBtnSrvInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageServer').html(tResult);
            $('#ocbSrvAutoGenCode').change(function() {
                $("#oetSrvCode").val("");
                if ($('#ocbSrvAutoGenCode').is(':checked')) {
                    $("#oetSrvCode").attr("readonly", true);
                    $("#oetSrvCode").attr("onfocus", "this.blur()");
                    $('#odvSrvCodeForm').removeClass('has-error');
                    $('#odvSrvCodeForm em').remove();
                } else {
                    $("#oetSrvCode").attr("readonly", false);
                    $("#oetSrvCode").removeAttr("onfocus");
                }
            });
            $("#oetSrvCode").blur(function() {
                if (!$('#ocbSrvAutoGenCode').is(':checked')) {
                    if ($("#ohdCheckSrvClearValidate").val() == 1) {
                        $('#ofmAddServer').validate().destroy();
                        $("#ohdCheckSrvClearValidate").val("0");
                    }
                    if ($("#ohdCheckSrvClearValidate").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: {
                                tTableName: "TRGMPosSrv",
                                tFieldName: "FTSrvCode",
                                tCode: $("#oetSrvCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicateSrvCode").val(aResult["rtCode"]);
                                JSxValidationFormServer("", $("#ohdServerRoute").val());
                                $('#ofmAddServer').submit();
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
    })
}

//Functionality : center validate form
//Parameters : function submit name, route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxValidationFormServer(pFnSubmitName, ptRoute) {
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "ServerEventAdd") {
            if ($('#ocbSrvAutoGenCode').is(':checked')) {
                return true;
            } else {
                if ($("#ohdCheckDuplicateSrvCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    });
    $('#ofmAddServer').validate({
        rules: {
            oetSrvCode: {
                "required": {
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if (ptRoute == "ServerEventAdd") {
                            if ($('#ocbSrvAutoGenCode').is(':checked')) {
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
            oetSrvName: {
                "required": {}
            }
        },
        messages: {
            oetSrvCode: {
                "required": $('#oetSrvCode').attr('data-validate-required'),
                "dublicateCode": $('#oetSrvCode').attr('data-validate-dublicateCode')
            },
            oetSrvName: {
                "required": $('#oetSrvName').attr('data-validate-required')
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
    if ($("#ohdCheckSrvClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddServer').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nStaSrvBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPageServerEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageServerAdd();
                                break;
                            case '3':
                                JSvCallPageServerList(1);
                                break;
                            default:
                                JSvCallPageServerEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                    }
                } else {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallSrvBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Product Unit Page Edit  
//Parameters : Event Button Click 
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageServerEdit(ptSrvCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageServerEdit', ptSrvCode);
    $.ajax({
        type: "POST",
        url: "ServerPageEdit",
        data: { tSrvCode: ptSrvCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliSrvTitleAdd').hide();
                $('#oliSrvTitleEdit').show();
                $('#odvBtnSrvInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageServer').html(tResult);
                $('#oetSrvCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);
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

//Functionality : set click status submit form from save button
//Parameters : -
//Creator : 26/03/2019 pap
//Return : -
//Return Type : -
function JSxSetStatusClickServerSubmit() {
    $("#ohdCheckSrvClearValidate").val("1");
}


//Functionality : Event Add/Edit Product Unit
//Parameters : From Submit
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : Status Event Add/Edit Product Unit
//Return Type : object
function JSoAddEditServer(ptRoute) {
    if ($("#ohdCheckSrvClearValidate").val() == 1) {
        $('#ofmAddServer').validate().destroy();
        if (!$('#ocbSrvAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TRGMPosSrv",
                    tFieldName: "FTSrvCode",
                    tCode: $("#oetSrvCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSrvCode").val(aResult["rtCode"]);
                    JSxValidationFormServer("JSxSubmitEventByButton", ptRoute);
                    $('#ofmAddServer').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JSxValidationFormServer("JSxSubmitEventByButton", ptRoute);
        }

    }
}

//Functionality : Generate Code Product Unit
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateServerCode() {
    var tTableName = 'TRGMPosSrv';
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
                $('#oetSrvCode').val(tData.rtSrvCode);
                $('#oetSrvCode').addClass('xCNDisable');
                $('#oetSrvCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
                $('#oetSrvName').focus();
            } else {
                $('#oetSrvCode').val(tData.rtDesc);
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
//Creator : 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return : object Status Delete
//Return Type : object
function JSoServerDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        // $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล : ' + tIDCode+' ('+tDelName+')');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ' + tYesOnNo);
        $('#odvModalDelServer').modal('show');
        $('#osmConfirm').on('click', function(evt) {

            $.ajax({
                type: "POST",
                url: "ServerEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    // alert(aReturn['nStaEvent']);
                    // if (aReturn['nStaEvent'] == '1'){
                    //     $('#odvModalDelServer').modal('hide');
                    //     $('#ospConfirmDelete').empty();
                    //     localStorage.removeItem('LocalItemData');

                    //     setTimeout(function() {
                    //         JSvCallPageServerList(tCurrentPage);
                    //     }, 500);
                    // }else{
                    //     JCNxOpenLoading();
                    //     alert(aReturn['tStaMessg']);                        
                    // }
                    // JSxSrvNavDefult();



                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelServer').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ohdConfirmIDDelete').val('');
                        $('#ospConfirmIDDelete').val('');
                        setTimeout(function() {
                            if (aReturn["nNumRowPdtSrv"] != 0) {
                                if (aReturn["nNumRowPdtSrv"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowPdtSrv"] / 10);
                                    if (tCurrentPage <= nNumPage) {
                                        JSvCallPageServerList(tCurrentPage);
                                    } else {
                                        JSvCallPageServerList(nNumPage);
                                    }
                                } else {
                                    JSvCallPageServerList(1);
                                }
                            } else {
                                JSvCallPageServerList(1);
                            }
                        }, 500);
                    } else {
                        JCNxOpenLoading();
                        alert(tData['tStaMessg']);
                    }
                    JSxSrvNavDefult();
                },

                // error: function(data) {
                //     console.log(data)

                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 13/09/2018 wasin
//Update: 01/04/2019 Pap
//Return:  object Status Delete
//Return Type: object

function JSoServerDelChoose() {
    var tCurrentPage = $("#nCurrentPageTB").val();
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
            url: "ServerEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                // setTimeout(function(){
                // 		$('#odvModalDelServer').modal('hide');
                // 		$('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                // 		$('#ohdConfirmIDDelete').val('');
                // 		localStorage.removeItem('LocalItemData');
                // 		JSvCallPageServerList(1);
                // 		$('.modal-backdrop').remove();
                // },500);
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelServer').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowPdtSrv"] != 0) {
                            if (aReturn["nNumRowPdtSrv"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPdtSrv"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvCallPageServerList(tCurrentPage);
                                } else {
                                    JSvCallPageServerList(nNumPage);
                                }
                            } else {
                                JSvCallPageServerList(1);
                            }
                        } else {
                            JSvCallPageServerList(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);
                }
                JSxSrvNavDefult();



            },
            error: function(data) {
                console.log(data);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvServerClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageServer .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageServer .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvServerDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 13/09/2018 wasin
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
        if (nNumOfArr > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    }
}



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
//Creator: 13/09/2018 wasin
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
        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }

        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลที่เลือกใช่หรือไม่ ?');
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}




//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 13/09/2018 wasin
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