var nStaPunBrowseType = $('#oetPunStaBrowse').val();
var tCallPunBackOption = $('#oetPunCallBackOption').val();
// alert(nStaPunBrowseType+'//'+tCallPunBackOption);

$('document').ready(function() {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPunNavDefult();
    if (nStaPunBrowseType != 1) {
        JSvCallPagePdtUnitList(1);
    } else {
        JSvCallPagePdtUnitAdd();
    }
    localStorage.removeItem('LocalItemData');
});

///function : Function Clear Defult Button Product Unit
//Parameters : Document Ready
//Creator : 13/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxPunNavDefult() {
    if (nStaPunBrowseType != 1 || nStaPunBrowseType == undefined) {
        $('.xCNPunVBrowse').hide();
        $('.xCNPunVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPunTitleAdd').hide();
        $('#oliPunTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPunInfo').show();
    } else {
        $('#odvModalBody #odvPunMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPunNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPunBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPunBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPunBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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
function JSvCallPagePdtUnitList(pnPage) {
    localStorage.tStaPageNow = 'JSvCallPagePdtUnitList';
    $('#oetSearchAll').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtunitList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPagePdtUnit').html(tResult);
            JSvPdtUnitDataTable(pnPage);
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
function JSvPdtUnitDataTable(pnPage) {
    var tSearchAll = $('#oetSearchPdtUnit').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtunitDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataPdtUnit').html(tResult);
            }
            JSxPunNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtUnit_L'); //โหลดภาษาใหม่
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
function JSvCallPagePdtUnitAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtunitPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaPunBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            } else {
                $('.xCNPunVBrowse').hide();
                $('.xCNPunVMaster').show();
                $('#oliPunTitleEdit').hide();
                $('#oliPunTitleAdd').show();
                $('#odvBtnPunInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtUnit').html(tResult);
            $('#ocbPunAutoGenCode').change(function() {
                $("#oetPunCode").val("");
                if ($('#ocbPunAutoGenCode').is(':checked')) {
                    $("#oetPunCode").attr("readonly", true);
                    $("#oetPunCode").attr("onfocus", "this.blur()");
                    $('#odvPunCodeForm').removeClass('has-error');
                    $('#odvPunCodeForm em').remove();
                } else {
                    $("#oetPunCode").attr("readonly", false);
                    $("#oetPunCode").removeAttr("onfocus");
                }
            });
            $("#oetPunCode").blur(function() {
                if (!$('#ocbPunAutoGenCode').is(':checked')) {
                    if ($("#ohdCheckPunClearValidate").val() == 1) {
                        $('#ofmAddPdtUnit').validate().destroy();
                        $("#ohdCheckPunClearValidate").val("0");
                    }
                    if ($("#ohdCheckPunClearValidate").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: {
                                tTableName: "TCNMPdtUnit",
                                tFieldName: "FTPunCode",
                                tCode: $("#oetPunCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePunCode").val(aResult["rtCode"]);
                                JSxValidationFormPdtUnit("", $("#ohdPdtunitRoute").val());
                                $('#ofmAddPdtUnit').submit();
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
function JSxValidationFormPdtUnit(pFnSubmitName, ptRoute) {
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "pdtunitEventAdd") {
            if ($('#ocbPunAutoGenCode').is(':checked')) {
                return true;
            } else {
                if ($("#ohdCheckDuplicatePunCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    });
    $('#ofmAddPdtUnit').validate({
        rules: {
            oetPunCode: {
                "required": {
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if (ptRoute == "pdtunitEventAdd") {
                            if ($('#ocbPunAutoGenCode').is(':checked')) {
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
            oetPunName: {
                "required": {}
            }
        },
        messages: {
            oetPunCode: {
                "required": $('#oetPunCode').attr('data-validate-required'),
                "dublicateCode": $('#oetPunCode').attr('data-validate-dublicateCode')
            },
            oetPunName: {
                "required": $('#oetPunName').attr('data-validate-required')
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
    if ($("#ohdCheckPunClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtUnit').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nStaPunBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtUnitEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtUnitAdd();
                                break;
                            case '3':
                                JSvCallPagePdtUnitList(1);
                                break;
                            default:
                                JSvCallPagePdtUnitEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                    }
                } else {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPunBackOption);
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
function JSvCallPagePdtUnitEdit(ptPunCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtUnitEdit', ptPunCode);
    $.ajax({
        type: "POST",
        url: "pdtunitPageEdit",
        data: { tPunCode: ptPunCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliPunTitleAdd').hide();
                $('#oliPunTitleEdit').show();
                $('#odvBtnPunInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtUnit').html(tResult);
                $('#oetPunCode').addClass('xCNDisable');
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
function JSxSetStatusClickPdtUnitSubmit() {
    $("#ohdCheckPunClearValidate").val("1");
}


//Functionality : Event Add/Edit Product Unit
//Parameters : From Submit
//Creator : 13/09/2018 wasin
//Update : 29/03/2019 pap
//Return : Status Event Add/Edit Product Unit
//Return Type : object
function JSoAddEditPdtUnit(ptRoute) {
    if ($("#ohdCheckPunClearValidate").val() == 1) {
        $('#ofmAddPdtUnit').validate().destroy();
        if (!$('#ocbPunAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMPdtUnit",
                    tFieldName: "FTPunCode",
                    tCode: $("#oetPunCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePunCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtUnit("JSxSubmitEventByButton", ptRoute);
                    $('#ofmAddPdtUnit').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JSxValidationFormPdtUnit("JSxSubmitEventByButton", ptRoute);
        }

    }
}

//Functionality : Generate Code Product Unit
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtUnitCode() {
    var tTableName = 'TCNMPdtUnit';
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
                $('#oetPunCode').val(tData.rtPunCode);
                $('#oetPunCode').addClass('xCNDisable');
                $('#oetPunCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
                $('#oetPunName').focus();
            } else {
                $('#oetPunCode').val(tData.rtDesc);
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
function JSoPdtUnitDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        // $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล : ' + tIDCode+' ('+tDelName+')');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ' + tYesOnNo);
        $('#odvModalDelPdtUnit').modal('show');
        $('#osmConfirm').on('click', function(evt) {

            $.ajax({
                type: "POST",
                url: "pdtunitEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    // alert(aReturn['nStaEvent']);
                    // if (aReturn['nStaEvent'] == '1'){
                    //     $('#odvModalDelPdtUnit').modal('hide');
                    //     $('#ospConfirmDelete').empty();
                    //     localStorage.removeItem('LocalItemData');

                    //     setTimeout(function() {
                    //         JSvCallPagePdtUnitList(tCurrentPage);
                    //     }, 500);
                    // }else{
                    //     JCNxOpenLoading();
                    //     alert(aReturn['tStaMessg']);                        
                    // }
                    // JSxPunNavDefult();



                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelPdtUnit').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ohdConfirmIDDelete').val('');
                        $('#ospConfirmIDDelete').val('');
                        setTimeout(function() {
                            if (aReturn["nNumRowPdtPUN"] != 0) {
                                if (aReturn["nNumRowPdtPUN"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowPdtPUN"] / 10);
                                    if (tCurrentPage <= nNumPage) {
                                        JSvCallPagePdtUnitList(tCurrentPage);
                                    } else {
                                        JSvCallPagePdtUnitList(nNumPage);
                                    }
                                } else {
                                    JSvCallPagePdtUnitList(1);
                                }
                            } else {
                                JSvCallPagePdtUnitList(1);
                            }
                        }, 500);
                    } else {
                        JCNxOpenLoading();
                        alert(tData['tStaMessg']);
                    }
                    JSxPunNavDefult();
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

function JSoPdtUnitDelChoose() {
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
            url: "pdtunitEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                // setTimeout(function(){
                // 		$('#odvModalDelPdtUnit').modal('hide');
                // 		$('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                // 		$('#ohdConfirmIDDelete').val('');
                // 		localStorage.removeItem('LocalItemData');
                // 		JSvCallPagePdtUnitList(1);
                // 		$('.modal-backdrop').remove();
                // },500);
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelPdtUnit').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowPdtPUN"] != 0) {
                            if (aReturn["nNumRowPdtPUN"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPdtPUN"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvCallPagePdtUnitList(tCurrentPage);
                                } else {
                                    JSvCallPagePdtUnitList(nNumPage);
                                }
                            } else {
                                JSvCallPagePdtUnitList(1);
                            }
                        } else {
                            JSvCallPagePdtUnitList(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);
                }
                JSxPunNavDefult();



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
function JSvPdtUnitClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtUnit .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtUnit .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtUnitDataTable(nPageCurrent);
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