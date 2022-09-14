var nStaPgpBrowseType = $('#oetPgpStaBrowse').val();
var tCallPgpBackOption = $('#oetPgpCallBackOption').val();
// alert(nStaPgpBrowseType+'//'+tCallPgpBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxMgpNavDefult();
    if (nStaPgpBrowseType != 1) {
        JSvCallPageMgpGroupList(1);
    } else {
        JSvCallPagePdtGroupAdd();
    }
});

///function : Function Clear Defult Button Product Unit
//Parameters : Document Ready
//Creator : 13/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxMgpNavDefult() {
    if (nStaPgpBrowseType != 1 || nStaPgpBrowseType == undefined) {
        $('.xCNPgpVBrowse').hide();
        $('.xCNPgpVMaster').show();
        $('.xCNChoose').hide();
        $('#oliMgpTitleAdd').hide();
        $('#oliMgpTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnMgpInfo').show();
    } else {
        $('#odvModalBody .xCNPgpVMaster').hide();
        $('#odvModalBody .xCNPgpVBrowse').show();
        $('#odvModalBody #odvMgpMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliMgpNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvMgpBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPgpBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPgpBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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
function JSvCallPageMgpGroupList(pnPage) {
    localStorage.tStaPageNow = 'JSvCallPageMgpGroupList';
    $('#oetSearchAll').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "MerPdtGroupList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageMerchantProduct').html(tResult);
            JSvMgpGroupDataTable(pnPage);
            JCNxCloseLoading();
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
function JSvMgpGroupDataTable(pnPage) {
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtgroupDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataPdtGroup').html(tResult);
            }
            JSxMgpNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtGrp_L'); //โหลดภาษาใหม่
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
//Updatae : 26/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPagePdtGroupAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtgroupPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaPgpBrowseType == 1) {
                $('.xCNPgpVMaster').hide();
                $('.xCNPgpVBrowse').show();
            } else {
                $('.xCNPgpVBrowse').hide();
                $('.xCNPgpVMaster').show();
                $('#oliPgpTitleEdit').hide();
                $('#oliPgpTitleAdd').show();
                $('#odvBtnPgpInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtGroup').html(tResult);
            $('#ocbPgpAutoGenCode').change(function() {
                $("#oetPgpCode").val("");
                $("#ohdCheckDuplicatePgpCode").val("1");
                if ($('#ocbPgpAutoGenCode').is(':checked')) {
                    $("#oetPgpCode").attr("readonly", true);
                    $("#oetPgpCode").attr("onfocus", "this.blur()");
                    $('#ofmAddPdtGroup').removeClass('has-error');
                    $('#ofmAddPdtGroup em').remove();
                } else {
                    $("#oetPgpCode").attr("readonly", false);
                    $("#oetPgpCode").removeAttr("onfocus");
                }
            });
            $("#oetPgpCode").blur(function() {
                if (!$('#ocbPgpAutoGenCode').is(':checked')) {
                    if ($("#ohdCheckPdtGroupClearValidate").val() == 1) {
                        $('#ofmAddPdtGroup').validate().destroy();
                        $("#ohdCheckPdtGroupClearValidate").val("0");
                    }
                    if ($("#ohdCheckPdtGroupClearValidate").val() == 0) {
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: {
                                tTableName: "TCNMPdtGrp",
                                tFieldName: "FTPgpCode",
                                tCode: $("#oetPgpCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult) {
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePgpCode").val(aResult["rtCode"]);
                                JSxValidationFormPdtGroup("", $("#ohdPdtGroupRoute").val());
                                $('#ofmAddPdtGroup').submit();

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
function JSxValidationFormPdtGroup(pFnSubmitName, ptRoute) {
    $.validator.addMethod('dublicateCode', function(value, element) {
        if (ptRoute == "pdtgroupEventAdd") {
            if ($('#ocbPgpAutoGenCode').is(':checked')) {
                return true;
            } else {
                if ($("#ohdCheckDuplicatePgpCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            }
        } else {
            return true;
        }
    }, '');
    $('#ofmAddPdtGroup').validate({
        rules: {
            oetPgpCode: {
                "required": {
                    // ตรวจสอบเงื่อนไข validate
                    depends: function(oElement) {
                        if (ptRoute == "pdtgroupEventAdd") {
                            if ($('#ocbPgpAutoGenCode').is(':checked')) {
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
            oetPgpName: {
                "required": {}
            }
        },
        messages: {
            oetPgpCode: {
                "required": $('#oetPgpCode').attr('data-validate-required'),
                "dublicateCode": $('#oetPgpCode').attr('data-validate-dublicateCode')
            },
            oetPgpName: {
                "required": $('#oetPgpName').attr('data-validate-required')
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
    if ($("#ohdCheckPdtGroupClearValidate").val() == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtGroup').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult) {
                if (nStaPgpBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        switch (aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtGroupEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtGroupAdd();
                                break;
                            case '3':
                                JSvCallPagePdtGroupList(1);
                                break;
                            default:
                                JSvCallPagePdtGroupEdit(aReturn['tCodeReturn']);
                        }
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                    }
                } else {
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPgpBackOption);
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
function JSvCallPagePdtGroupEdit(ptPgpCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtGroupEdit', ptPgpCode);
    $.ajax({
        type: "POST",
        url: "pdtgroupPageEdit",
        data: { tPgpCode: ptPgpCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliPgpTitleAdd').hide();
                $('#oliPgpTitleEdit').show();
                $('#odvBtnPgpInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtGroup').html(tResult);
                $('#oetPgpCode').addClass('xCNDisable');
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
function JSxSetStatusClickPdtGroupSubmit() {
    $("#ohdCheckPdtGroupClearValidate").val("1");
}


//Functionality : Event Add/Edit Product Unit
//Parameters : From Submit
//Creator : 13/09/2018 wasin
//Updatae : 26/03/2019 pap
//Return : Status Event Add/Edit Product Unit
//Return Type : object
function JSoAddEditPdtGroup(ptRoute) {
    if ($("#ohdCheckPdtGroupClearValidate").val() == 1) {
        $('#ofmAddPdtGroup').validate().destroy();
        if (!$('#ocbPgpAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TCNMPdtGrp",
                    tFieldName: "FTPgpCode",
                    tCode: $("#oetPgpCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePgpCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtGroup("JSxSubmitEventByButton", ptRoute);
                    $('#ofmAddPdtGroup').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JSxValidationFormPdtGroup("JSxSubmitEventByButton", ptRoute);
        }

    }

}

//Functionality : Generate Code Product Unit
//Parameters : Event Button Click
//Creator : 13/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtGroupCode() {
    var tTableName = 'TCNMPdtGrp';
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
                $('#oetPgpCode').val(tData.rtPgpCode);
                $('#oetPgpCode').addClass('xCNDisable');
                $('#oetPgpCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
                $('#oetPgpName').focus();
            } else {
                $('#oetPgpCode').val(tData.rtDesc);
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
//Update: 1/04/2019 pap
//Return : object Status Delete
//Return Type : object
function JSoPdtGroupDel(tCurrentPage, tIDCode, tDelName) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();


    if (aDataSplitlength == '1') {
        $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' (' + tDelName + ') ' + tConfirmYN);
        $('#odvModalDelPdtGroup').modal('show');
        $('#osmConfirm').on('click', function(evt) {

            $.ajax({
                type: "POST",
                url: "pdtgroupEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {

                    var aReturn = JSON.parse(oResult);
                    // if (aReturn['nStaEvent'] == '1'){
                    //     $('#odvModalDelPdtGroup').modal('hide');
                    //     $('#ospConfirmDelete').empty();
                    //     localStorage.removeItem('LocalItemData');
                    //     $('#ospConfirmIDDelete').val('');
                    //     setTimeout(function() {
                    //         JSvCallPagePdtGroupList(tCurrentPage);
                    //     }, 500);
                    // }else{
                    //     JCNxOpenLoading();
                    //     alert(aReturn['tStaMessg']);                        
                    // }
                    // JSxPgpNavDefult();

                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelPdtGroup').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ospConfirmIDDelete').val('');
                        $('#ohdConfirmIDDelete').val('');
                        setTimeout(function() {
                            if (aReturn["nNumRowPdtPgp"] != 0) {
                                if (aReturn["nNumRowPdtPgp"] > 10) {
                                    nNumPage = Math.ceil(aReturn["nNumRowPdtPgp"] / 10);
                                    if (tCurrentPage <= nNumPage) {
                                        JSvCallPagePdtGroupList(tCurrentPage);
                                    } else {
                                        JSvCallPagePdtGroupList(nNumPage);
                                    }
                                } else {
                                    JSvCallPagePdtGroupList(1);
                                }
                            } else {
                                JSvCallPagePdtGroupList(1);
                            }
                        }, 500);
                    } else {
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxLocNavDefult();
                },

                error: function(data) {
                    console.log(data)

                    // error: function(jqXHR, textStatus, errorThrown) {
                    //     JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 13/09/2018 wasin
//Update: 1/04/2019 pap
//Return:  object Status Delete
//Return Type: object

function JSoPdtGroupDelChoose() {

    JCNxOpenLoading();
    var tCurrentPage = $("#nCurrentPageTB").val();
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
            url: "pdtgroupEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {

                // setTimeout(function(){
                // 		$('#odvModalDelPdtGroup').modal('hide');
                // 		$('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                // 		$('#ohdConfirmIDDelete').val('');
                // 		localStorage.removeItem('LocalItemData');
                // 		JSvCallPagePdtGroupList();
                // 		$('.modal-backdrop').remove();
                // },500);


                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDelPdtGroup').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if (aReturn["nNumRowPdtPgp"] != 0) {
                            if (aReturn["nNumRowPdtPgp"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowPdtPgp"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvCallPagePdtGroupList(tCurrentPage);
                                } else {
                                    JSvCallPagePdtGroupList(nNumPage);
                                }
                            } else {
                                JSvCallPagePdtGroupList(1);
                            }
                        } else {
                            JSvCallPagePdtGroupList(1);
                        }
                    }, 500);
                } else {
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);
                }
                JSxLocNavDefult();
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
function JSvPdtGroupClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtGroup .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtGroup .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtGroupDataTable(nPageCurrent);
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

        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm);
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