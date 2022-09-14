var nStaSCLBrowseType   = $('#oetSCLStaBrowse').val();
var tCallSCLBackOption  = $('#oetSCLCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSCLNavDefult();
    if (nStaSCLBrowseType != 1) {
        JSvSCLCallPageList(1);
    } else {
        JSvCallPageFashionDepartAdd();
    }
});

/*============================= End Auto Run =================================*/

//Creator : 27/04/2021 Napat(Jame)
function JSxSCLNavDefult() {
    try {
        if (nStaSCLBrowseType != 1 || nStaSCLBrowseType == undefined) {
            $('.xCNSCLVBrowse').hide();
            $('.xCNSCLVMaster').show();
            $('#oliSCLTitleAdd').hide();
            $('#oliSCLTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnSCLInfo').show();
        } else {
            $('#odvModalBody .xCNSCLVMaster').hide();
            $('#odvModalBody .xCNSCLVBrowse').show();
            $('#odvModalBody #odvSCLMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliSCLNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvSCLBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNSCLBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNSCLBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    } catch (err) {
        console.log('JSxSCLNavDefult Error: ', err);
    }
}

//Creator : 27/04/2021 Napat(Jame)
function JSvSCLCallPageList(pnPage) {
    try {
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "masSCLPageList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvSCLContentPage').html(tResult);
                JSvSCLCallDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxChanelResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } catch (err) {
        console.log('JSvSCLCallPageList Error: ', err);
    }
}

//Creator : 27/04/2021 Napat(Jame)
function JSvSCLCallDataTable(pnPage) {
    try {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masSCLPageDataTable",
            data: {
                tSearchAll      : tSearchAll,
                nPageCurrent    : nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostSCLDataTable').html(tResult);
                }
                JSxSCLNavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    } catch (err) {
        console.log('JSvSCLCallDataTable Error: ', err);
    }
}

//Creator : 27/04/2021 Napat(Jame)
function JSxSCLCallPageAdd() {
    try {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masSCLPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaSCLBrowseType == 1) {
                    $('.xCNSCLVMaster').hide();
                    $('.xCNSCLVBrowse').show();
                } else {
                    $('.xCNSCLVBrowse').hide();
                    $('.xCNSCLVMaster').show();
                    $('#oliSCLTitleEdit').hide();
                    $('#oliSCLTitleAdd').show();
                    $('#odvBtnSCLInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvSCLContentPage').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    } catch (err) {
        console.log('JSxSCLCallPageAdd Error: ', err);
    }
}

//Creator : 27/04/2021 Napat(Jame)
function JSxSCLEventAddEdit(ptRoute) {
    $('#ofmSCLAdd').validate().destroy();
    $('#ofmSCLAdd').validate({
        rules: {
            oetSclCode: {
                "required": {
                    depends: function(oElement) {
                        if (ptRoute == "masSCLEventAdd") {
                            if ($('#ocbSCLAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return true;
                        }
                    }
                },
            },
            oetSclName: { "required": {} },
        },
        messages: {
            oetSclCode: {
                "required": $('#oetSclCode').attr('data-validate-required'),
            },
            oetSclName: {
                "required": $('#oetSclName').attr('data-validate-required'),
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
                data: $('#ofmSCLAdd').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == 1) {
                        if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                            JSxSCLCallPageEdit(aReturn['tCodeReturn']);
                        } else if (aReturn['nStaCallBack'] == '2') {
                            JSxSCLCallPageAdd();
                        } else if (aReturn['nStaCallBack'] == '3') {
                            JSvSCLCallPageList();
                        }
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    JCNxCloseLoading();
                }
            });
        },
    });
}

//Creator : 27/04/2021 Napat(Jame)
function JSxSCLCallPageEdit(ptSclCode) {
    try {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "masSCLPageEdit",
            data: { 
                tSclCode: ptSclCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#odvSCLContentPage').html(tResult);
                    $('#oliSCLTitleAdd').hide();
                    $('#oliSCLTitleEdit').show();
                    $('#odvBtnSCLInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    } catch (err) {
        console.log('JSvCallPageFashionDepartEdit Error: ', err);
    }
}

//Creator : 28/04/2021 Napat(Jame)
function JSxSCLPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nKey;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Creator : 28/04/2021 Napat(Jame)
function JSxSCLShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvSCLTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvSCLTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvSCLTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

//Creator : 28/04/2021 Napat(Jame)
function JSxSCLFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

//Creator : 28/04/2021 Napat(Jame)
function JSxSCLEventDeleteMulti(nPageCurent){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 3);
    var aDataSplit = aTexts.split(" , ");

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "masSCLEventDelete",
        data: {
            aDataCodeDel : aDataSplit
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aReturn = $.parseJSON(tResult);
            if (aReturn['nStaEvent'] == '1') {
                $('#odvSCLModalDelMulti').modal('hide');
                $('#ospConfirmDelete').empty();
                localStorage.removeItem('LocalItemData');
                setTimeout(function() {
                    JSvSCLCallDataTable(nPageCurent);
                }, 500);
            } else {
                alert(aReturn['tStaMessg']);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            JCNxCloseLoading();
        }
    });
}

//Creator : 28/04/2021 Napat(Jame)
function JSxSCLEventDeleteSingle(nPageCurent,tDataCode,tDataName){
    $('#odvSCLModalDelSingle').modal('show');
    $('#odvSCLModalDelSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + tDataCode + ' ( ' + tDataName + ' ) ');
    $('#odvSCLModalDelSingle #osmConfirm').on('click', function(evt) {
        JCNxOpenLoading();

        var aCodeDel = [];
        aCodeDel.push(tDataCode);

        console.log(aCodeDel);

        $.ajax({
            type: "POST",
            url: "masSCLEventDelete",
            data: {
                aDataCodeDel : aCodeDel
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == 1) {
                    $('#odvSCLModalDelSingle').modal('hide');
                    $('#odvSCLModalDelSingle #ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        JSvSCLCallDataTable(nPageCurent);
                    }, 500);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
                JCNxCloseLoading();
            }
        });
    });
}

//Creator : 28/04/2021 Napat(Jame)
function JSxSCLClickPage(ptPage) {
    try {
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageGrp .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageGrp .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvSCLCallDataTable(nPageCurrent);
    } catch (err) {
        console.log('JSxSCLClickPage Error: ', err);
    }
}