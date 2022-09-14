var nStaSgpBrowseType = $('#oetSgpStaBrowse').val();
var tCallSgpBackOption = $('#oetSgpCallBackOption').val();
// alert(nStaSgpBrowseType+'//'+tCallSgpBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSgpNavDefult();
    if (nStaSgpBrowseType != 1) {
        JSvCallPageGroupSupplierList();
    } else {
        JSvCallPageGroupSupplierAdd();
    }
});

//function : Function Clear Defult Button GroupSupplier
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxSgpNavDefult() {
    if (nStaSgpBrowseType != 1 || nStaSgpBrowseType == undefined) {
        $('.xCNSgpVBrowse').hide();
        $('.xCNSgpVMaster').show();
        $('.xCNChoose').hide();
        $('#oliSgpTitleAdd').hide();
        $('#oliSgpTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnSgpInfo').show();
    } else {
        $('#odvModalBody .xCNSgpVMaster').hide();
        $('#odvModalBody .xCNSgpVBrowse').show();
        $('#odvModalBody #odvSgpMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliSgpNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvSgpBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNSgpBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNSgpBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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

//function : Call GroupSupplier Page list  
//Parameters : Document Redy And Event Button
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageGroupSupplierList() {
    localStorage.tStaPageNow = 'JSvCallPageGroupSupplierList';
    $('#oetSearchGroupSupplier').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "groupsupplierList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvContentPageGroupSupplier').html(tResult);
            JSvGroupSupplierDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call GroupSupplier Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvGroupSupplierDataTable(pnPage) {
    var tSearchAll = $('#oetSearchGroupSupplier').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "groupsupplierDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostDataGroupSupplier').html(tResult);
            }
            JSxSgpNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMSplGrp_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call GroupSupplier Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageGroupSupplierAdd() {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "groupsupplierPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaSgpBrowseType == 1) {
                $('.xCNSgpVMaster').hide();
                $('.xCNSgpVBrowse').show();
            } else {
                $('.xCNSgpVBrowse').hide();
                $('.xCNSgpVMaster').show();
                $('#oliSgpTitleEdit').hide();
                $('#oliSgpTitleAdd').show();
                $('#odvBtnSgpInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageGroupSupplier').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call GroupSupplier Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageGroupSupplierEdit(ptSgpCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageGroupSupplierEdit', ptSgpCode);
    $.ajax({
        type: "POST",
        url: "groupsupplierPageEdit",
        data: { tSgpCode: ptSgpCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliSgpTitleAdd').hide();
                $('#oliSgpTitleEdit').show();
                $('#odvBtnSgpInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageGroupSupplier').html(tResult);
                $('#oetGspCode').addClass('xCNDisable');
                $('#oetGspCode').attr('readonly', true);
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

//Functionality : Event Add/Edit GroupSupplier
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit GroupSupplier
//Return Type : object
function JSoAddEditGroupSupplier(ptRoute) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddGroupSupplier').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "groupsupplierEventAdd") {
                if ($("#ohdCheckDuplicateSgpCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddGroupSupplier').validate({
            rules: {
                oetGspCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "groupsupplierEventAdd") {
                                if ($('#ocbGroupSupplierAutoGenCode').is(':checked')) {
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
                oetSgpName: { "required": {} },
            },
            messages: {
                oetGspCode: {
                    "required": $('#oetGspCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetGspCode').attr('data-validate-dublicateCode')
                },
                oetSgpName: {
                    "required": $('#oetSgpName').attr('data-validate-required'),
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
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddGroupSupplier').serialize(),

                    success: function(oResult) {
                        if (nStaSgpBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageGroupSupplierEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageGroupSupplierAdd();
                                        break;
                                    case '3':
                                        JSvCallPageGroupSupplierList();
                                        break;
                                    default:
                                        JSvCallPageGroupSupplierEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSgpBackOption);
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

//Functionality : Generate Code GroupSupplier
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateGroupSupplierCode() {
    $('#oetGspCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMSplGrp';
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
                $('#oetGspCode').val(tData.rtSgpCode);
                $('#oetGspCode').addClass('xCNDisable');
                $('#oetGspCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetSgpName').focus();
            } else {
                $('#oetGspCode').val(tData.rtDesc);
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
function JSoGroupSupplierDel(tIDCode, tName) {
    var aData = $('#ospConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();

    if (aDataSplitlength == '1') {

        $('#odvModalDelGroupSupplier').modal('show');
        $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' (' + tName + ') ' + tConfirmYN);
        $('#osmConfirm').on('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "groupsupplierEventDelete",
                data: { 'tIDCode': tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        $('#odvModalDelGroupSupplier').modal('hide');
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvGroupSupplierDataTable();
                        }, 500);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxSgpNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoGroupSupplierDelChoose() {
    JCNxOpenLoading();
    var aData = $('#ospConfirmIDDelete').val();
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
            url: "groupsupplierEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvModalDelGroupSupplier').modal('hide');
                        JSvCallPageGroupSupplierList();
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                    }, 1000);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JSxSgpNavDefult();
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
function JSvGroupSupplierClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageGroupSupplier .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageGroupSupplier .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvGroupSupplierDataTable(nPageCurrent);
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
        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        var tTexts = tText.substring(0, tText.length - 2);
        var tConfirm = $('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm);
        $('#ospConfirmIDDelete').val(tTextCode);
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


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 29/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbGroupSupplierSgpIsCreatePage() {
    try {
        const tSgpCode = $('#oetGspCode').data('is-created');
        var bStatus = false;
        if (tSgpCode == "" || tSgpCode == null) { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbGroupSupplierSgpIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 29/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbGroupSupplierSgplIsUpdatePage() {
    try {
        const tSgpCode = $('#oetGspCode').data('is-created');
        var bStatus = false;
        if (!tSgpCode == "" || !tSgpCode == null) { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbGroupSupplierSgplIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 29/05/2019 saharat (Golf)
// Return : -
// Return Type : -
function JSxGroupSupplierSgpVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxGroupSupplierSgpVisibleComponent Error: ', err);
    }
}