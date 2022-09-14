var nStaBchBrowseType = $('#oetBchStaBrowse').val();
var tCallBchBackOption = $('#oetBchCallBackOption').val();

$('ducument').ready(function() {
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxBCHNavDefult();

    if (nStaBchBrowseType != 1) {
        JSvBCHCallPageBranchList();
    } else {
        JSvBCHCallPageBranchAdd();
    }
});



function JSxBCHNavDefult() {
    if (nStaBchBrowseType != 1 || tCallBchBackOption == undefined) {
        $('#odvBtnShpInfoFromBch').hide();
        $('#oliBCHAdd').hide();
        $('#oliBCHEdit').hide();
        $('#oliBCHSHP').hide();
        $('#oliBCHSHPAdd').hide();
        $('#odvBtnCmpEditInfo').hide();
        $('#oliBCHSHPEdit').hide();
        $('#odvBtnBchInfo').show();
        $('.obtChoose').hide();
    } else {
        $('#odvModalBody #odvBchMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBchNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBchBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBchBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBchBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}


// Functionality : Get PostCode
// Parameters : District Code (ptDstCode)
// Creater : 23/05/2018 Krit(Copter)
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : Number
function JStBCHGetDistrictPostCode(ptDstCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $.ajax({
            type: "POST",
            url: "districtGetPostCode",
            data: {
                tDstCode: ptDstCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {

                //เอาค่า PostCode ที่ได้มาไป put ใส่ Input PostCode
                $('#oetAddV1PostCode').val(tResult);

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Call Branch PageEdit
// Parameters : function Parameters
// Creator : 27/03/2018 wasin(yoshi)
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvBCHCallPageBranchEdit(ptBchCode) {
    var nStaSession = JCNxFuncChkSessionExpired();

    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('JSvBCHCallPageBranchEdit', ptBchCode);
        $.ajax({
            type: "POST",
            url: "branchPageEdit",
            data: {
                tBchCode: ptBchCode,
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageBranch').html(tResult);
                //Put Data
                ohdBchPriority = $('#ohdBchPriority').val();
                $("#ocmBchPriority option[value='" + ohdBchPriority + "']").attr('selected', true).trigger('change');


                ohdBchType = $('#ohdBchType').val();
                $("#ocmBchType option[value='" + ohdBchType + "']").attr('selected', true).trigger('change');

                ohdBchStaActive = $('#ohdBchStaActive').val();
                $("#ocmBchStaActive option[value='" + ohdBchStaActive + "']").attr('selected', true).trigger('change');

                oetZneCode = $('#oetZneCode').val();
                if (oetZneCode != '') {
                    $('.xWZneName').removeClass('xWCurNotAlw');
                    $('.xWZneName i').removeClass('xWPointerEventNone');

                    $('.xWPvnName').removeClass('xWCurNotAlw');
                    $('.xWPvnName i').removeClass('xWPointerEventNone');
                }

                oetAddV1PvnCode = $('#oetAddV1PvnCode').val();
                if (oetAddV1PvnCode != '') {
                    $('.xWPvnName').removeClass('xWCurNotAlw');
                    $('.xWPvnName i').removeClass('xWPointerEventNone');
                }

                oetAddV1DstCode = $('#oetAddV1DstCode').val();
                if (oetAddV1DstCode != '') {
                    $('.xWDstName').removeClass('xWCurNotAlw');
                    $('.xWDstName i').removeClass('xWPointerEventNone');
                }

                //Put Data
                //Disabled input
                $('#oetBchCode').addClass('xCNCursorNotAlw').attr('readonly', true);
                $('#odvBchAutoGenCode').addClass('xCNHide');

                $('#oliBCHEdit').show();
                $('#oliBCHAdd').hide();
                $('#odvBtnBchInfo').hide();
                $('#odvBtnCmpEditInfo').show();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// function : Call Branch Pagelist
// Parameters : tSearchAll : ข้อความที่ใช้ค้นหา , nPageCurrent = 1 Refresh หน้า
// Creator :
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvBCHCallPageBranchList(tNamepage, nPage, pnStaBrowse, ptStaInto, ptInputId) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        localStorage.removeItem('LocalItemData'); //remove ค่า ที่เก็บ Chkbox หน้า List
        localStorage.tStaPageNow = 'JSvBCHCallPageBranchList';
        nStaBrowse = pnStaBrowse;
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = nPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        $.ajax({
            type: "POST",
            url: "branchList",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
                nStaBrowse: pnStaBrowse,
                tNamepage: tNamepage,
                tStaInto: ptStaInto,
                tInputId: ptInputId
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageBranch').html(tResult);
                JSvBranchDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function : Call Branch Data List
// Parameters : Ajax Success Event 
// Creator:	05/06/2018 Krit
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvBranchDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "branchDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataBranch').html(tResult);
                }
                localStorage.tStaPageNow = 'JSvBCHCallPageBranchList';

                JSxBCHNavDefult();
                JCNxLayoutControll();
                JStBCHCallCstProfile();

                // JStCMMGetPanalLangHTML('TCNMBranch_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : Call Branch PageAdds
// Parameters : function Parameters
// Creator :
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvBCHCallPageBranchAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "branchPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaBchBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                } else {
                    $('#oliBCHAdd').show();
                    $('#oliBCHEdit').hide();
                    $('#odvBtnBchInfo').hide();
                    $('#odvBtnCmpEditInfo').show();
                }

                $('#odvContentPageBranch').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : (event) Delete แบบ ID 1 ตัว
// Parameters : tIDCode รหัส
// Creator : 10/5/2018 Krit(Copter)
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : -
// Return Type : n
function JSnBranchDel(tCurrentPage, tIDCode, tDelName, tYesOnNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ospConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvmodaldeleteBranch').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' (' + tDelName + ')' + tYesOnNo);
            $('#osmConfirm').on('click', function(evt) {
                if (localStorage.StaDeleteArray != '1') {
                    $.ajax({
                        type: "POST",
                        url: "branchEventDelete",
                        data: {
                            'tIDCode': tIDCode
                        },
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            tResult = tResult.trim();
                            var tData = $.parseJSON(tResult);
                            $('#odvmodaldeleteBranch').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ospConfirmIDDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                JSvBranchDataTable(tCurrentPage);
                            }, 500);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Functionality : (event) Delete แบบ เลือก Id หลายตัว ส่งค่า Array ไปลบ 
// Parameters : tIDCode รหัส
// Creator : 10/05/2018 Krit(Copter)
// Last Update: 15/01/2019 Wasin(Yoshi)
// Return : -
// Return Type : n
function JSnBranchDelChoose() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        var tNamepage = '';
        var aDataIdBranch = '';
        var nStaBrowse = '';
        var tStaInto = '';
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
                url: "branchEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                timeout: 0,
                success: function(tResult) {
                    // FSnBCHDeleteFolderImg(aNewIdDelete); //พอลบเสร็จ ส่งไป ลบ Folder ที่ FS ถัดไป
                    setTimeout(function() {
                        $('#odvmodaldeleteBranch').modal('hide');
                        JSvBranchDataTable();
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
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
    } else {
        JCNxShowMsgSessionExpired();
    }
}


// Functionality : (event) Delete Folder รับค่า ID เป็น Array มาแล้วส่งไปลบทีละ ID  
// Parameters : tIDCode รหัส
// Creator : 10/05/2018 Krit(Copter)
// Return : -
// Return Type : n
function FSnBCHDeleteFolderImg(paIdDelete) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        aIdDelete = [];
        aIdDelete += paIdDelete;
        aIdDelete = aIdDelete.trim('');
        arrNewIdDelete = aIdDelete.split(',');
        nNum = arrNewIdDelete.length;
        for (i = 0; i < nNum; i++) {
            nId = arrNewIdDelete[i];
            $.ajax({
                type: "POST",
                url: "branchEventDeleteFolder",
                data: { 'tIDCode': nId },
                timeout: 0,
                success: function(tResult) {

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 27/03/2018 wasin(yoshi)
//Return : Status Add
//Return Type : n
function JSnAddEditBranch(ptNameContentNow, ptNameContentBrowse, ptRouteBrowse, pnPage, pnStaBrowse, tRouteEvent, ptStaInto) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddBranch').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (tRouteEvent == "branchEventAdd") {
                if ($("#ohdCheckDuplicateBchCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddBranch').validate({
            rules: {
                oetBchCode: {
                    "required": {
                        depends: function(oElement) {
                            if (tRouteEvent == "branchEventAdd") {
                                if ($('#ocbBrachAutoGenCode').is(':checked')) {
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

                oetBchName:  { "required": {} },
                oetBchRegNo: { "required": {} },
            },
            messages: {
                oetBchCode: {
                    "required"      : $('#oetBchCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetBchCode').attr('data-validate-dublicateCode')
                },
                oetBchName: {
                    "required": $('#oetBchName').attr('data-validate-required'),
                    "dublicateCode": $('#oetBchName').attr('data-validate-dublicateCode')
                },
                oetBchRegNo: {
                    "required": $('#oetBchRegNo').attr('data-validate-required'),
                    "dublicateCode": $('#oetBchRegNo').attr('data-validate-dublicateCode')
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

                // Create By Napat(Jame) 08/06/2020
                // Fixed Issue No.8
                var dDateStart      = $('#oetBchStart').val();
                var dDateEnd        = $('#oetBchStop').val();
                var dDateSaleStart  = $('#oetBchSaleStart').val();
                var dDateSaleEnd    = $('#oetBchSaleStop').val();

                if(dDateStart > dDateEnd){
                    FSvCMNSetMsgErrorDialog('วันที่เริ่มดำเนินการ ต้องน้อยกว่า วันที่สิ้นสุดดำเนินการ');
                    return false;
                }

                if(dDateSaleStart > dDateSaleEnd){
                    FSvCMNSetMsgErrorDialog('วันที่เริ่มขาย ต้องน้อยกว่า วันที่สิ้นสุดการขาย');
                    return false;
                }

                JCNxOpenLoading();
                var nStaChkDisable = 2;
                if( $('#ocmBchType').attr('disabled') === 'disabled' ){
                    $('#ocmBchType').attr('disabled',false); // เปิดให้ Serialize ดึง Value จาก Input
                    nStaChkDisable = 1;
                }
                $.ajax({
                    type: "POST",
                    url: tRouteEvent,
                    data: $("#ofmAddBranch").serialize(),
                    timeout: 0,
                    success: function(oResult) {

                        if( nStaChkDisable == 1 ){
                            $('#ocmBchType').attr('disabled',true); // ปิด Input ไว้เหมือนเดิม หลังจากใช้งานเสร็จแล้ว
                        }

                        if (nStaBchBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if (aReturn['nStaEvent'] == 1) {
                                switch (aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvBCHCallPageBranchEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvBCHCallPageBranchAdd();
                                        break;
                                    case '3':
                                        JSvBCHCallPageBranchList(1);
                                        break;
                                    default:
                                        JSvBCHCallPageBranchEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallBchBackOption);
                        }
                        // if (nStaBchBrowseType != 1) {
                        //     tResult = tResult.trim('')
                        //     aResult = tResult.split(',');

                        //     tBchCode = $('#oetBchCode').val();
                        //     if (tBchCode == '') {
                        //         tBchCode = aResult[2];
                        //     }

                        //     if (aResult[0] == '1') {
                        //         /*เงือนไข Load หน้าหลังจาก Save*/
                        //         tBtnSaveStaActive = localStorage.tBtnSaveStaActive
                        //         if (tBtnSaveStaActive == undefined) {
                        //             JSvBCHCallPageBranchEdit(tBchCode);
                        //         }
                        //         switch (tBtnSaveStaActive) {
                        //             case '1':
                        //                 /*บีนทึกแล้วดู*/
                        //                 localStorage.tControlBtn = 1 /*Set localStorage เพื่อใช้  Check สถานะว่ามาจากหน้า Add แล้วไปหน้า Edit ต่อเพื่อใช้ Control ปุ่ม*/
                        //                 JSvBCHCallPageBranchEdit(tBchCode);
                        //                 break;
                        //             case '2':
                        //                 /*บีนทึกแล้วสร้างใหม่*/
                        //                 JSvBCHCallPageBranchAdd();
                        //                 break;
                        //             case '3':
                        //                 /*บีนทึกแล้วกลับไปหน้า List*/
                        //                 JSvBCHCallPageBranchList();
                        //                 break;
                        //             default:
                        //         }
                        //         /*เงือนไข Load หน้าหลังจาก Save*/

                        //     } else {
                        //         // alert(aResult[1]);
                        //         if (aResult[0] != 1) { /* Duplicate ไปหน้า Edit*/
                        //             JSvBCHCallPageBranchEdit(tBchCode);
                        //         }
                        //     }
                        // } else {
                        //     JCNxBrowseData(tCallBchBackOption);
                        // }
                        // JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 27/03/2018 Krit(Copter)
//Return : View
//Return Type : View
function JSvBCHClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageBranch .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageBranch .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvBranchDataTable(nPageCurrent);
}


//Functionality : gen code Branch
//Parameters : -
//Creator : 04/04/2018 Krit(Copter)
//Return : Data
//Return Type : String
function JStBCHGenerateBranchCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#oetBchCode').closest('.form-group').addClass("has-success").removeClass("has-error");
        $('#oetBchCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        JCNxOpenLoading();
        var tTableName = 'TCNMBranch';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            success: function(tResult) {

                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetBchCode').val(tData.rtBchCode);
                    $('.xCNDisable').attr('readonly', true);
                    $('#oetBchCode').addClass('xCNDisable');
                    $('#oetBchCode').attr('readonly', true);

                    //ปุ่ม Gen
                    $('#oetBranchGencode').attr('disabled', true);
                    //JStCMNCheckDuplicateCodeMaster('oetBchCode','JSvBCHCallPageBranchEdit','TCNMBranch','FTBchCode');
                } else {
                    $('#oetBchCode').val(tData.rtDesc);
                }
                JCNxCloseLoading();

            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}


function JSxBCHShowButtonChoose() {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('.obtChoose').hide();
    } else {

        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('.obtChoose').show();
        } else {
            $('.obtChoose').hide();
        }

    }
}

//Functionality: Function check And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
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
            $('.xCNIconDel').css("pointer-events", "none");
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
//Return: -
//Return Type: -
function JSxTextinModal() {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {

    } else {

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
        $('#ohdConfirmIDDelete').val(tTextCode);


    }
}


//Functionality: Function check Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 06/06/2018 Krit
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

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 12/06/2019 saharat(Golf)
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbBrachIsCreatePage() {
    try {
        const tBchCode = $('#oetBchCode').data('is-created');
        var bStatus = false;
        if (tBchCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbBrachIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 12/06/2019 saharat(Golf)
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbBrachIsUpdatePage() {
    try {
        const tBchCode = $('#oetBchCode').data('is-created');
        var bStatus = false;
        if (!tBchCode == "") {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbBrachIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or Hide Component
 * Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
 * Creator : 12/06/2019 saharat(Golf)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxBrachVisibleComponent(ptComponent, pbVisible, ptEffect) {
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
        console.log('JSxBrachVisibleComponent Error: ', err);
    }
}


//Functionality : Call API Cst Profile
//Parameters : -
//Creator : 03/02/2021 Nale
//Return : Data
//Return Type : String
function JStBCHCallCstProfile() {
    var tBchSessionCstKey = $('#oetBchSessionCstKey').val();
    if(tBchSessionCstKey!=''){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "branchCallCstProfile",
            data: { oetBchSessionCstKey: tBchSessionCstKey },
            cache: false,
            success: function(tResult) {
                var aData = $.parseJSON(tResult);

                if(aData['rtCode']=='001'){
                    if(aData['roItem']['raoCstBch'][0]['rtCbrRefBch']!=''){
                        $('#oimBtnDelBch' + aData['roItem']['raoCstBch'][0]['rtCbrRefBch']).addClass('xCNDisabled').removeClass('xCNIconDel');
                        $('#oimBtnDelBch' + aData['roItem']['raoCstBch'][0]['rtCbrRefBch']).attr('onClick','');

                        $('.xCNCheckBoxDeleteBranchByBCH' + aData['roItem']['raoCstBch'][0]['rtCbrRefBch']).addClass('xCNDocDisabled');
                        $('.ocbListItem' + aData['roItem']['raoCstBch'][0]['rtCbrRefBch']).attr('disabled',true); 
                    }
                }
                JCNxCloseLoading();

            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}
}