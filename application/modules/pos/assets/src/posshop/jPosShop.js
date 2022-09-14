var nStaPshBrowseType = $('#oetPshStaBrowse').val();
var tCallPshBackOption = $('#oetPshCallBackOption').val();

//function : Call POS SHOP Page list  
//Parameters : Document Redy And Event Button
//Creator :	12/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvCallPagePosShopMain(ptBchCode, ptShpCode, ptShpName) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "posshopList",
        data: {
            tBchCode: ptBchCode,
            tShpCode: ptShpCode
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $('#odvBtnGrpShop').hide();
            $('#odvContentPageShop').html(tResult);
            $('#oetBchCode').val(ptBchCode);
            $('#oetShpCode').val(ptShpCode);
            $('#oetShpName').val(ptShpName);
            JSvPosShopDataTable(ptBchCode, ptShpCode, 1);
            $('#odvBtnPdtInfo').hide();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//ค้นหา
function JSvSearchAll() {
    var tBchCode = $('#oetPshPSHBchCode').val();
    var tShpCode = $('#oetPshPSHShpCod').val();
    var pnPage = 1;
    JSvPosShopDataTable(tBchCode, tShpCode, pnPage)
}
//function: Call POS SHOP
//Parameters: Ajax Success Event 
//Creator:	12/02/2019 Napat(Jame)
//Return: View
//Return Type: View
function JSvPosShopDataTable(ptBchCode, ptShpCode, pnPage) {
    var tSearchAll = $('#oetSearchPosShop').val();
    var tShpType = $('#oetPshPSHShpType').val();
    var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "posshopDataTable",
        data: {
            tBchCode: ptBchCode,
            tShpCode: ptShpCode,
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
            tShpType: tShpType
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $('#odvPSHContentInfoPS').html(tResult);
            }

            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMShop_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add POS SHOP
//Parameters : From Submit
//Creator : 08/07/2019 saharat(Golf)
//Return : Status Event Add POS SHOP
//Return Type : object
function JSoAddPosShop(ptRoute) {
    $('#ofmAddPosShop').validate({
        rules: {
            oetShpName: "required",
            oetPosName: "required",
            oetPshPosSN: "required",
            ocmPshStaUse: "required",
            oetPshPosShopIP: "required",
            oetPshPosShopPort: "required"
        },
        messages: {
            oetShpName: $('#oetShpName').data('validate'),
            oetPosName: $('#oetPosName').data('validate'),
            oetPshPosSN: $('#oetPshPosSN').data('validate'),
            ocmPshStaUse: $('#ocmPshStaUse').data('validate'),
            oetPshPosShopIP: $('#oetPshPosShopIP').data('validate'),
            oetPshPosShopPort: $('#oetPshPosShopIP').data('validate'),
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
            // JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddPosShop').serialize(),
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        // $('#oetPshPosSN').val('');
                        // $('#oetPosCode').val('');
                        // $('#oetPosName').val('');
                        // JSvCallPagePosShopEventEdit(aReturn['tCodeReturn']['FTBchCode'],aReturn['tCodeReturn']['FTPosCode'],aReturn['tCodeReturn']['FTShpCode'],aReturn['tCodeReturn']['FTPshStaUse'])
                        JSxGetSHPContentInfoPS();
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
    });
}

//Functionality : Event Edit POS SHOP
//Parameters : From Submit
//Creator : 13/02/2019 Napat(Jame)
//Return : Status Event Edit POS SHOP
//Return Type : object
function JSoEditPosShop() {
    $('#ofmEditPosShop').validate({
        rules: {},
        messages: {},
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
            // console.log($('#ofmEditPosShop').serializeArray());
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "posshopEventAdd",
                data: $('#ofmEditPosShop').serialize(),
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        JSvCallPagePosShopMain(aReturn['tCodeReturn']['FTBchCode'], aReturn['tCodeReturn']['FTShpCode'], aReturn['tCodeReturn']['FTShpName']);
                        // JSvPosShopDataTable(aReturn['tCodeReturn']['FTBchCode'],aReturn['tCodeReturn']['FTShpCode'],1);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
    });
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 23/07/2019 saharat(Golf)
//Return : object Status Delete
//Return Type : object
function JSoPosShopDel(pnPage, ptPosCode, ptPshPosSN, ptShpCode, ptBchCode, tYesOnNo) {
    var tShpType = $('#oetPshPSHShpType').val();
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;

    if (aDataSplitlength == '1') {
        $('#odvModalDelPosShop').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptPosCode + ' ( ' + ptPshPosSN + ' ) ' + tYesOnNo);
        $('#osmConfirm').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "posshopEventDelete",
                data: {
                    'FTBchCode': ptBchCode,
                    'FTShpCode': ptShpCode,
                    'FTPosCode': ptPosCode,
                    'tShpType': tShpType
                },
                cache: false,
                success: function(tResult) {
                    tResult = tResult.trim();
                    var tData = $.parseJSON(tResult);
                    $('#odvModalDelPosShop').modal('hide');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    // ptBchCode = null;
                    JSvPosShopDataTable(ptBchCode, ptShpCode, pnPage);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });


        });
    }
}

//Functionality : Call POS SHOP Page Edit  
//Parameters : Event Button Click 
//Creator : 13/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvCallPagePosShopEdit(ptBchCode, ptShpCode, ptPosCode) {
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePosShopEdit', ptShpCode);
    var FTShpName = $('#oetShpName').val();
    var tData = "'" + ptBchCode + "','" + ptShpCode + "','" + FTShpName + "'";
    var tSubmit = "$('#obtSubmitEditPsh').click()";
    var tShpType = $('#oetPshPSHShpType').val();
    $.ajax({
        type: "POST",
        url: "posshopPageEdit",
        data: {
            tBchCode: ptBchCode,
            tShpCode: ptShpCode,
            tPosCode: ptPosCode,
            tShpType: tShpType
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != '') {
                JSxSHPNavDefult();
                $('#odvBtnShpInfo').hide();
                $('#odvBtnGrpShop').show();
                //Append Title POSSHOP
                $('#oliMenuNav').append($('<li>')
                        .attr('id', 'oliPshTile')
                        .attr('class', 'active xWPshTitle')
                        .attr('onclick', 'JSvCallPagePosShopMain(' + tData + ')')
                        .append($('<a>')
                            .text($('#ohdPshTitle').val())
                        )
                    )
                    //Append Title POSSHOP Edit
                $('#oliMenuNav').append($('<li>')
                    .attr('id', 'oliPshTileEdit')
                    .attr('class', 'active xWPshTitleEdit')
                    .append($('<a>')
                        .text($('#ohdPshTitleEdit').val())
                    )
                )

                $('.xWPshBtnSaveandCancel').remove();
                //Append Button Save and Cancel
                $('#odvBtnGrpShop').append($('<div>')
                    .attr('class', 'xWPshBtnSaveandCancel')
                    .append($('<button>')
                        .attr('class', 'btn xCNBTNDefult xCNBTNDefult2Btn')
                        .attr('type', 'button')
                        .attr('onclick', 'JSvCallPagePosShopMain(' + tData + ')')
                        .text('ย้อนกลับ')
                    )

                    .append($('<div>')
                        .attr('class', 'btn-group')
                        .append($('<button>')
                            .attr('type', 'submit')
                            .attr('class', 'btn btn-default xWBtnGrpSaveLeft')
                            .attr('onclick', tSubmit)
                            .text($('#ohdTextSave').val())
                        )

                        .append($('<button>')
                            .attr('type', 'button')
                            .attr('class', 'btn btn-default xWBtnGrpSaveRight dropdown-toggle')
                            .attr('data-toggle', 'dropdown')
                            .attr('aria-haspopup', 'true')
                            .attr('aria-expanded', 'false')

                            .append($('<span>')
                                .attr('class', 'caret')
                            )

                            .append($('<span>')
                                .attr('class', 'sr-only')
                                .text('Toggle Dropdown')
                            )
                        )

                        .append($('<ul>')
                            .attr('class', 'dropdown-menu xWDrpDwnMenuMargLft')

                            .append($('<li>')
                                .attr('class', 'xWolibtnsave1 xWBtnSaveActive')
                                .attr('onclick', 'JSvChangeBtnSaveAction(1)')
                                .append($('<a>')
                                    .attr('href', '#')
                                    .text('บันทึกและดู')
                                )
                            )

                            .append($('<li>')
                                .attr('class', 'xWolibtnsave2')
                                .attr('onclick', 'JSvChangeBtnSaveAction(2)')
                                .append($('<a>')
                                    .attr('href', '#')
                                    .text('บันทึกและเพิ่มใหม่')
                                )
                            )

                            .append($('<li>')
                                .attr('class', 'xWolibtnsave3')
                                .attr('onclick', 'JSvChangeBtnSaveAction(3)')
                                .append($('<a>')
                                    .attr('href', '#')
                                    .text('บันทึกและกลับ')
                                )
                            )

                        )
                    )
                )

                $('#odvContentPageShop').html(tResult);
                $('#btnBrowseShop').attr('disabled', true);
                $('#btnBrowsePos').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Event Add FTBchCode to input
//Parameters : from NextFunc
//Creator : 13/02/2019 Napat(Jame)
//Return : -
//Return Type : -
function JSxAddBchCode(ptBchCode) {
    var aReturn = JSON.parse(ptBchCode);
    $('#oetBchCode').val(aReturn[0]);

    var tBchCode = $('#oetBchCode').val();
    var tShpCode = $('#oetShpCode').val();

    //console.log('tBchCode: ' + tBchCode);
    //console.log('tShpCode: ' + tShpCode);

    JSvPosShopDataTable(tBchCode, tShpCode, 1);

}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvPshClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePsh .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePsh .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPosShopDataTable($('#oetBchCode').val(), $('#oetShpCode').val(), nPageCurrent);
}


//Functionality : (event) Delete All
//Parameters :
//Creator : 11/06/2019 saharat
//Return : 
//Return Type :
function JSxSMSDeleteMutirecord() {
    var tBchCode = $('#ohdBchCode').val();
    var tShpCode = $('#ohdShpCode').val();
    var aData = $('#odvModalDeleteMutirecord #ohdConfirmIDDelete').val();

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
            url: "posshopEventDelete",
            data: {
                'FTPosCode': aNewIdDelete,
                'FTBchCode': tBchCode,
                'FTShpCode': tShpCode
            },
            cache: false,
            timeout: 0,
            success: function(aReturn) {
                $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#odvModalDeleteMutirecord').val());
                $('#odvModalDeleteMutirecord #ohdConfirmIDeleteMutirecord').val('');
                localStorage.removeItem('LocalItemData');
                $('.modal-backdrop').remove();
                $('#odvModalDeleteMutirecord #odvModalDeleteMutirecord').modal('hide');
                setTimeout(function() {
                    JSvSearchAll();
                }, 500);
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

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 05/07/2019 Saharat(Golf)
//Return: - 
//Return Type: -
function JSxPSHShowButtonChoose() {
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
//Creator: 05/07/2019 Saharat(Golf)
//Return: -
//Return Type: -
function JSxPSHPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        var nBchCode = '';
        var nShpCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            nBchCode += aArrayConvert[0][$i].nBch;
            nShpCode += aArrayConvert[0][$i].nShp;
            tTextCode += ' , ';
        }

        $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#odvModalDeleteMutirecord #ohdConfirmIDDelete').val(tTextCode);
        $('#odvModalDeleteMutirecord #ohdBchCode').val(nBchCode);
        $('#odvModalDeleteMutirecord #ohdShpCode').val(nShpCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 05/07/2019 Saharat(Golf)
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
};