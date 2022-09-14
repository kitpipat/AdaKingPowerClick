var nStaStmBrowseType = $('#oetStmStaBrowse').val();
var tCallStmBackOption = $('#oetStmCallBackOption').val();
// alert(nStaStmBrowseType+'//'+tCallStmBackOption);
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxStmNavDefult();
    if (nStaStmBrowseType != 1) {
        JSvStmCallPageList();
    } else {
        JSvStmCallPageAdd();
    }
});

// Create By : Napat(Jame) 08/11/2021
function JSxStmNavDefult() {
    if (nStaStmBrowseType != 1 || nStaStmBrowseType == undefined) {
        $('.xCNStmVBrowse').hide();
        $('.xCNStmVMaster').show();
        $('.xCNChoose').hide();
        $('#oliStmTitleAdd').hide();
        $('#oliStmTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnStmInfo').show();
    } else {
        $('#odvModalBody .xCNStmVMaster').hide();
        $('#odvModalBody .xCNStmVBrowse').show();
        $('#odvModalBody #odvStmMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliStmNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvStmBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNStmBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNStmBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Create By : Napat(Jame) 08/11/2021
function JSvStmCallPageList() {
    localStorage.tStaPageNow = 'JSvStmCallPageList';
    $('#oetSearchGroupSupplier').val('');
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masInstallmentTermsList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvStmContentPage').html(tResult);
            JSvStmCallPageDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Create By : Napat(Jame) 08/11/2021
function JSvStmCallPageDataTable(pnPage) {
    var tSearchAll = $('#oetSearchGroupSupplier').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "masInstallmentTermsDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#ostStmContentDataTable').html(tResult);
            }
            JSxStmNavDefult();
            JCNxLayoutControll();
            // JStCMMGetPanalLangHTML('TCNMSplGrp_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Create By : Napat(Jame) 08/11/2021
function JSvStmCallPageAdd() {
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "masInstallmentTermsPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (nStaStmBrowseType == 1) {
                $('.xCNStmVMaster').hide();
                $('.xCNStmVBrowse').show();
            } else {
                $('.xCNStmVBrowse').hide();
                $('.xCNStmVMaster').show();
                $('#oliStmTitleEdit').hide();
                $('#oliStmTitleAdd').show();
                $('#odvBtnStmInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvStmContentPage').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Create By : Napat(Jame) 08/11/2021
function JSvStmCallPageEdit(ptStmCode) {
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('JSvStmCallPageEdit', ptStmCode);
    $.ajax({
        type: "POST",
        url: "masInstallmentTermsPageEdit",
        data: { tStmCode: ptStmCode },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliStmTitleAdd').hide();
                $('#oliStmTitleEdit').show();
                $('#odvBtnStmInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvStmContentPage').html(tResult);
                $('#oetStmCode').addClass('xCNDisable');
                $('#oetStmCode').attr('readonly', true);
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

// Create By : Napat(Jame) 08/11/2021
function JSoStmAddEdit(ptRoute) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmStmAdd').validate().destroy();
        // $.validator.addMethod('dublicateCode', function(value, element) {
        //     if (ptRoute == "masInstallmentTermsEventAdd") {
        //         if ($("#ohdStmCheckDuplicateCode").val() == 1) {
        //             return false;
        //         } else {
        //             return true;
        //         }
        //     } else {
        //         return true;
        //     }
        // }, '');
        $('#ofmStmAdd').validate({
            rules: {
                oetStmCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "masInstallmentTermsEventAdd") {
                                if ($('#ocbStmAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    }
                    // ,"dublicateCode": {}
                },
                oetStmName: { "required": {} },
            },
            messages: {
                oetStmCode: {
                    "required": $('#oetStmCode').attr('data-validate-required')
                    // ,"dublicateCode": $('#oetStmCode').attr('data-validate-dublicateCode')
                },
                oetStmName: {
                    "required": $('#oetStmName').attr('data-validate-required'),
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
                    data: $('#ofmStmAdd').serialize(),

                    success: function(oResult) {
                        if (nStaStmBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvStmCallPageEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvStmCallPageAdd();
                                        break;
                                    case '3':
                                        JSvStmCallPageList();
                                        break;
                                    default:
                                        JSvStmCallPageEdit(aReturn['tCodeReturn']);
                                }
                            } else {
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                                JCNxCloseLoading();
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallStmBackOption);
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

// Create By : Napat(Jame) 08/11/2021
function JSoStmDelete(tIDCode, tName) {
    var aData = $('#ospConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    var tConfirm = $('#ohdDeleteconfirm').val();
    var tConfirmYN = $('#ohdDeleteconfirmYN').val();

    if (aDataSplitlength == '1') {

        $('#odvStmModalDelete').modal('show');
        $('#ospConfirmDelete').text(tConfirm + ' ' + tIDCode + ' (' + tName + ') ' + tConfirmYN);
        $('#osmConfirm').on('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "masInstallmentTermsEventDelete",
                data: { 'tIDCode' : tIDCode },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        $('#odvStmModalDelete').modal('hide');
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        setTimeout(function() {
                            JSvStmCallPageDataTable();
                        }, 500);
                    } else {
                        FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                        JCNxCloseLoading();
                    }
                    JSxStmNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }
}

// Create By : Napat(Jame) 08/11/2021
function JSoStmDeleteChoose() {
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
            url: "masInstallmentTermsEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                if (aReturn['nStaEvent'] == 1) {
                    setTimeout(function() {
                        $('#odvStmModalDelete').modal('hide');
                        JSvStmCallPageList();
                        $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
                        $('#ospConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                    }, 1000);
                } else {
                    FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                    JCNxCloseLoading();
                }
                JSxStmNavDefult();
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

// Create By : Napat(Jame) 08/11/2021
function JSxStmClickPage(ptPage) {
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
    JSvStmCallPageDataTable(nPageCurrent);
}

// Create By : Napat(Jame) 08/11/2021
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

// Create By : Napat(Jame) 08/11/2021
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

// Create By : Napat(Jame) 08/11/2021
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// Create By : Napat(Jame) 08/11/2021
function JSbStmIsCreatePage() {
    try {
        const tStmCode = $('#oetStmCode').data('is-created');
        var bStatus = false;
        if (tStmCode == "" || tStmCode == null) { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbStmIsCreatePage Error: ', err);
    }
}

// Create By : Napat(Jame) 08/11/2021
function JSbStmIsUpdatePage() {
    try {
        const tStmCode = $('#oetStmCode').data('is-created');
        var bStatus = false;
        if (!tStmCode == "" || !tStmCode == null) { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbStmIsUpdatePage Error: ', err);
    }
}

// Create By : Napat(Jame) 08/11/2021
function JSxStmVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxStmVisibleComponent Error: ', err);
    }
}

// Create By : Napat(Jame) 08/11/2021
function JSxStmSubPageDataTable(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masInstallmentTermsSubDataTable",
        data: {
            tAgnCode: $('#oetStmAgnCode').val(),
            tStmCode: $('#oetStmCode').val(),
            tCrdCode: '',
            tBnkCode: ''
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvBtnAddEdit').hide();
                $('#odvStmSubContentDataTable').html(tResult);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}