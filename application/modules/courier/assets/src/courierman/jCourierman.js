var nStaCpgBrowseType = $('#oetCpgStaBrowse').val();
var tCallCpgBackOption = $('#oetCpgCallBackOption').val();
// alert(nStaCpgBrowseType+'//'+tCallCpgBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCpgNavDefult();
    if (nStaCpgBrowseType != 1) {
        JSvCallPageCurmanList();
    } else {
        JSvCallPageCurmanAdd();
    }
});

//function : Function Clear Defult Button Product Size
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxCpgNavDefult() {
    if (nStaCpgBrowseType != 1 || nStaCpgBrowseType == undefined) {
        $('.xCNCpgVBrowse').hide();
        $('.xCNCpgVMaster').show();
        $('.xCNChoose').hide();
        $('#oliCpgTitleAdd').hide();
        $('#oliCpgTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCpgInfo').show();
    } else {
        $('#odvModalBody .xCNCpgVMaster').hide();
        $('#odvModalBody .xCNCpgVBrowse').show();
        $('#odvModalBody #odvCpgMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCpgNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCpgBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCpgBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCpgBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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
function JSvCallPageCurmanList() {
    localStorage.tStaPageNow = 'JSvCallPageCurmanList';
    $('#oetSearchCpg').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "courierManList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageCpg').html(tResult);
            JSvCurmanDataTable();
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
function JSvCurmanDataTable(pnPage) {
    var tSearchAll = $('#oetSearchCpg').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "courierManDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataCpg').html(tResult);
            }
            JSxCpgNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMCourierGrp_L'); //โหลดภาษาใหม่
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
function JSvCallPageCurmanAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "courierManPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaCpgBrowseType == 1) {
                $('.xCNCpgVMaster').hide();
                $('.xCNCpgVBrowse').show();
            } else {
                $('.xCNCpgVBrowse').hide();
                $('.xCNCpgVMaster').show();
                $('#oliCpgTitleEdit').hide();
                $('#oliCpgTitleAdd').show();
                $('#odvBtnCpgInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageCpg').html(tResult);
            $('#ocbCpgAutoGenCode').change(function() {
                $("#oetCpgCode").val("");
                $("#ohdCheckDuplicateCpgCode").val("1");
                if ($('#ocbCpgAutoGenCode').is(':checked')) {
                    $("#oetCpgCode").attr("readonly", true);
                    $("#oetCpgCode").attr("onfocus", "this.blur()");
                    $('#ofmAddCpg').removeClass('has-error');
                    $('#ofmAddCpg em').remove();
                } else {
                    $("#oetCpgCode").attr("readonly", false);
                    $("#oetCpgCode").removeAttr("onfocus");
                }
            });
            $("#oetCpgCode").blur(function() {
                if (!$('#ocbCpgAutoGenCode').is(':checked')) {
                    if ($("#ohdCheckCpgClearValidate").val() == 1) {
                        $('#ofmAddCpg').validate().destroy();
                        $("#ohdCheckCpgClearValidate").val("0");
                    }
                    if ($("#ohdCheckCpgClearValidate").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: {
                                tTableName: "TCNMCourierGrp",
                                tFieldName: "FTCgpCode",
                                tCode: $("#oetCpgCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicateCpgCode").val(aResult["rtCode"]);
                                JSxValidationFormCpg("", $("#ohdPdtGroupRoute").val());
                                $('#ofmAddCpg').submit();

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
function JSxValidationFormCpg(pFnSubmitName, ptRoute) {
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "courierGrpEventAdd") {
            if ($('#ocbCpgAutoGenCode').is(':checked')) {
                return true;
            } else {
                if ($("#ohdCheckDuplicateCpgCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    }, '');
    $('#ofmAddCpg').validate({
        rules: {
            oetCpgCode: {
                "required": {
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if (ptRoute == "courierGrpEventAdd") {
                            if ($('#ocbCpgAutoGenCode').is(':checked')) {
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
            oetCpgName: {
                "required": {}
            }
        },
        messages: {
            oetCpgCode: {
                "required": $('#oetCpgCode').attr('data-validate-required'),
                "dublicateCode": $('#oetCpgCode').attr('data-validate-dublicateCode')
            },
            oetCpgName: {
                "required": $('#oetCpgName').attr('data-validate-required')
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
    
    if ($("#ohdCheckCpgClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddCpg').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                console.log(oResult);
                if (nStaCpgBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPageCpgEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageCurmanAdd();
                                break;
                            case '3':
                                JSvCallPageCurmanList();
                                break;
                            default:
                                JSvCallPageCpgEdit(aReturn['tCodeReturn']);
                        }
                        JCNxImgWarningMessage(aReturn['aImgReturn']);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                } else {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallCpgBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call couierman Size Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageCpgEdit(ptCrycode, ptID, ptStaActive) {
    // alert(ptCrycode+ptID);
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageCpgEdit', ptCrycode, ptID);
    $.ajax({
        type: "POST",
        url: "courierManPageEdit",
        data: {
            tCrycode: ptCrycode,
            tID: ptID
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliCpgTitleAdd').hide();
                $('#oliCpgTitleEdit').show();
                $('#odvBtnCpgInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageCpg').html(tResult);
                $('#oetCpgCode').addClass('xCNDisable');
                $('#oetCpgCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            $("#ocbManSta option[value='" + ptStaActive + "']").attr('selected', true).trigger('change');

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
function JSxSetStatusClickCpgSubmit() {

    $("#ohdCheckCpgClearValidate").val("1");
}


//Functionality : Event Add/Edit couierman
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit couierman Size
//Return Type : object
function JSoAddEditCpg(ptRoute) {
    var tStaActive = $('#ocbManSta').val();
    $.ajax({
        type: "POST",
        url: ptRoute,
        data: $('#ofmAddCurman').serialize(),
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var oStatus = JSON.parse(tResult);
            if (oStatus.nStaEvent == 900) {
                alert('ไม่สามารถบันทึกข้อมูลได้เนื่องจากข้อมูลซ้ำ');
                JSvCallPageCurmanAdd();
            } else {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    switch (aReturn['nStaCallBack']) {
                        case '1':
                            // alert(aReturn['tCrycode']+'==='+aReturn['tID']);
                            JSvCallPageCpgEdit(aReturn['tCrycode'], aReturn['tID'], tStaActive);
                            break;
                        case '2':
                            JSvCallPageCurmanAdd();
                            break;
                        case '3':
                            JSvCallPageCurmanList();
                            break;
                        default:
                            JSvCallPageCpgEdit(aReturn['tCrycode'], aReturn['tID'], tStaActive);
                    }
                }
            }


        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Generate Code Product Size
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateCpgCode() {
    $('#oetCpgCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMCourierGrp';
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
                $('#oetCpgCode').val(tData.rtCgpCode);
                $('#oetCpgCode').addClass('xCNDisable');
                $('#oetCpgCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetCpgName').focus();
            } else {
                $('#oetCpgCode').val(tData.rtDesc);
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
function JSoCpgDel(pnPage, ptName, tManCode, tID, tCryCode) {
    var tConfrim = $('#ohdDeleteconfirmYN').val();
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelCpg').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + tManCode + ' ( ' + ptName + ' ) ' + tConfrim);
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "courierManEventDelete",
                    data: {
                        'tID': tID,
                        'tCryCode': tCryCode,
                    },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);

                        // $('#odvModalDelCpg').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvCurmanDataTable(pnPage);
                        if (aReturn['nStaEvent'] == '1') {
                            $('#odvModalDelCpg').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if (aReturn["nNumRowCpg"] != 0) {
                                    if (aReturn["nNumRowCpg"] > 10) {
                                        nNumPage = Math.ceil(aReturn["nNumRowCpg"] / 10);
                                        if (pnPage <= nNumPage) {
                                            JSvCurmanDataTable(pnPage);
                                        } else {
                                            JSvCurmanDataTable(nNumPage);
                                        }
                                    } else {
                                        JSvCurmanDataTable(1);
                                    }
                                } else {
                                    JSvCurmanDataTable(1);
                                }
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxCpgNavDefult();

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
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoCpgDelChoose(pnPage) {
    JCNxOpenLoading();

    var aID = $('#ohdConfirmIDDelete').val();
    var aCode = $('#ohdConfirmCodeDelete').val();

    var aTexts = aID.substring(0, aID.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    aTexts = aCode.substring(0, aCode.length - 2);
    aDataSplit = aTexts.split(" , ");
    aDataSplitlength = aDataSplit.length;
    aNewCodeDelete = [];

    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewCodeDelete.push(aDataSplit[$i]);
    }
    // alert(aNewIdDelete);
    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "courierManEventDelete",
            data: {
                'tID': aNewIdDelete,
                'tCryCode': aNewCodeDelete

            },
            success: function(tResult) {

                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);


                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelCpg').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowCpg"] != 0) {
                            if (aReturn["nNumRowCpg"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowCpg"] / 10);
                                if (pnPage <= nNumPage) {
                                    JSvCurmanDataTable(pnPage);
                                } else {
                                    JSvCurmanDataTable(nNumPage);
                                }
                            } else {
                                JSvCurmanDataTable(1);
                            }
                        } else {
                            JSvCurmanDataTable(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxCpgNavDefult();


            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCpgClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCpg .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCpg .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCurmanDataTable(nPageCurrent);
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
        var tTextId = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
            tTextId += aArrayConvert[0][$i].nID;
            tTextId += ' , ';

        }
        // alert(tTextCode+tTextId+'>>');
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextId);
        $('#ohdConfirmCodeDelete').val(tTextCode);
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