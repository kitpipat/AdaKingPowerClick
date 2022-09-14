var nStaASTBrowseType = $("#oetASTStaBrowse").val();
var tCallASTBackOption = $("#oetASTCallBackOption").val();

$("document").ready(function() {
    sessionStorage.removeItem("EditInLine");
    localStorage.removeItem("LocalItemData");
    localStorage.removeItem("Ada.ProductListCenter");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    if (typeof(nStaASTBrowseType) != 'undefined' && nStaASTBrowseType == 0) { // เข้ามาจาก Menulist Tab
        $('#oliASTTitle').unbind().click(function() {
            JSvASTCallPageList();
        });
        $('#obtASTCallPageAdd').unbind().click(function() {
            JSvASTCallPageAdd();
        });
        $('#obtASTCallBackPage').unbind().click(function() {
            JSvASTCallPageList();
        });
        $('#obtASTCancel').unbind().click(function() {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                JSnASTCancelDoc(false);
            } else {
                JCNxShowMsgSessionExpired();
            }
        });
        $('#obtASTApprove').unbind().click(function() {
            JSxASTSetStatusClickSubmit(2);
            // JSxASTValidateViaOrderBeforeApvDoc(false);
        });
        $('#obtASTSubmitFrom').click(function() {
            JSxASTSetStatusClickSubmit(1);
            JSxValidateFormAddAST();
            //$('#obtSubmitAST').click();
            $('#ofmASTFormAdd').submit();
        });
        JSxASTNavDefult();
        JSvASTCallPageList();
    } else if (typeof(nStaASTBrowseType) != 'undefined' && nStaASTBrowseType == 1) { // เข้ามาจาก Modal Browse
        $('#oahASTBrowseCallBack').unbind().click(function() { JCNxBrowseData(tCallASTBackOption); });
        $('#oliASTBrowsePrevious').unbind().click(function() { JCNxBrowseData(tCallASTBackOption); });
        $('#obtASTBrowseSubmit').unbind().click(function() {
            JSxASTSetStatusClickSubmit(1);
            $('#obtSubmitAST').click();
        });
        JSxASTNavDefult();
        JSvASTCallPageAdd();
    } else {}
});

// Function: Set Defult Nav Menu 
// Parameters: Document Ready And Button Event Click
// Creator: 06/06/2019 Wasin(Yoshi)
// LastUpdate:
// Return: Set Default Nav Menu Adjust Stock
// ReturnType: -
function JSxASTNavDefult() {
    if (typeof(nStaASTBrowseType) != 'undefined' && nStaASTBrowseType == 0) { // เข้ามาจาก Menulist Tab
        $('.xCNChoose').hide();
        $('#oliASTTitleAdd').hide();
        $('#oliASTTitleEdit').hide();
        $('#oliASTTitleDetail').hide();
        $('#odvBtnAddEdit').hide();

        $('#odvBtnASTInfo').show();
    } else if (typeof(nStaASTBrowseType) != 'undefined' && nStaASTBrowseType == 1) { // เข้ามาจาก Modal Browse
        $('#odvModalBody #odvASTMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliASTNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvASTBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNASTBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNASTBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    } else {}
}

// Function: Call Page List Document
// Parameters: Document Redy Function
// Creator: 06/06/2019 Wasin(Yoshi)
// LastUpdate:
// Return: Call View Adjust Stock List
// ReturnType: View
function JSvASTCallPageList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        $.ajax({
            type: "GET",
            url: "dcmASTFormSearchList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvContentPageAST").html(tResult);
                JSxASTNavDefult();
                JSvASTCallPageDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Get Data Advanced Search
// Parameters: Function Call Page
// Creator: 02/05/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: object Data Advanced Search
// ReturnType: object
function JSoASTGetAdvanceSearchData() {
    var oAdvanceSearchData = {
        tSearchAll: $("#oetSearchAll").val(),
        tSearchBchCodeFrom: $("#oetASTBchCodeFrom").val(),
        tSearchBchCodeTo: $("#oetASTBchCodeTo").val(),
        tSearchDocDateFrom: $("#oetASTDocDateFrom").val(),
        tSearchDocDateTo: $("#oetASTDocDateTo").val(),
        tSearchStaDoc: $("#ocmASTStaDoc").val(),
        // tSearchStaDocAct: $("#ocmStaDocAct").val(),
        tSearchStaApprove: $("#ocmASTStaApprove").val(),
        tSearchStaPrcStk: $("#ocmASTStaPrcStk").val()
    };
    return oAdvanceSearchData;
}

// Function: Call Page Data Table Document
// Parameters: Function Call Page
// Creator: 06/06/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: Call View Adjust Stock Data Table
// ReturnType: View
function JSvASTCallPageDataTable(pnPage) {
    JCNxOpenLoading();
    var oAdvanceSearch = JSoASTGetAdvanceSearchData();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == "") {
        nPageCurrent = "1";
    }
    $.ajax({
        type: "POST",
        url: "dcmASTDataTable",
        data: {
            oAdvanceSearch: oAdvanceSearch,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['nStaEvent'] == '1') {
                JSxASTNavDefult();
                $('#ostContentAdjustStock').html(aReturnData['tViewDataTable']);
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: เปลี่ยนหน้า Pagenation หน้า Table List Document
// Parameters: Event Click Pagenation
// Creator: 07/06/2019 Wasin(Yoshi)
// Return: View
// ReturnType : View
function JSvASTClickPage(ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                nPageOld = $(".xWPageASTPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPageASTPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvASTCallPageDataTable(nPageCurrent);
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Single Delete Document Single
// Parameters: Event Click Button Delete Document Single
// Creator: 07/06/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: object Data Status Delete
// ReturnType: object
function JSoASTDelDocSingle(ptCurrentPage, ptASTDocNo) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        $('#odvASTModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ptASTDocNo);
        $('#odvASTModalDelDocSingle').modal('show');
        $('#odvASTModalDelDocSingle #osmASTConfirmPdtDTTemp ').unbind().click(function() {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "dcmASTEventDelete",
                data: { 'tASTDocNo': ptASTDocNo },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        $('#odvASTModalDelDocSingle').modal('hide');
                        $('#odvASTModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                        $('.modal-backdrop').remove();
                        setTimeout(function() {
                            JSvASTCallPageDataTable(ptCurrentPage);
                        }, 500);
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function: Event Mutiple Delete Doc Mutiple
// Parameters: Function Call Page
// Creator: 07/06/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSoASTDelDocMultiple() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aDataDelMultiple = $('#odvASTModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
        var aTextsDelMultiple = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
        var aDataSplit = aTextsDelMultiple.split(" , ");
        var nDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];

        for ($i = 0; $i < nDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (nDataSplitlength > 1) {
            JCNxOpenLoading();
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "dcmASTEventDelete",
                data: { 'tASTDocNo': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvASTModalDelDocMultiple').modal('hide');
                            $('#odvASTModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvASTModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            JSvASTCallPageList();
                        }, 1000);
                    } else {
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
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

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 07/06/2019 Wasin(Yoshi)
//Return: Show Button Delete All
//Return Type: -
function JSxASTShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliBtnDeleteAll").addClass("disabled");
        }
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/06/2019 WItsarut(Bell)
//Return: -
//Return Type: -
function JSxASTPdtTextinModal() {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof nStaSession !== "undefined" && nStaSession == 1){
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
        var tTextSeq = "";
        var tTextPdt = "";
        var tTextDoc = "";
        var tTextPun = "";
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextSeq += aArrayConvert[0][$i].tSeq;
            tTextSeq += " , ";
            tTextPdt += aArrayConvert[0][$i].tPdt;
            tTextPdt += " , ";
            tTextDoc += aArrayConvert[0][$i].tDoc;
            tTextDoc += " , ";
            tTextPun += aArrayConvert[0][$i].tPun;
            tTextPun += " , ";
        }
        $("#ospASTConfirmDelPdtDTTemp").text($("#oetTextComfirmDeleteMulti").val());
        $("#ohdASTConfirmSeqDelete").val(tTextSeq);
        $("#ohdASTConfirmPdtDelete").val(tTextPdt);
        $("#ohdASTConfirmPunDelete").val(tTextPun);
        $("#ohdASTConfirmDocDelete").val(tTextDoc);
    }
    // }else{
    //     JCNxShowMsgSessionExpired();
    // }
}


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 07/06/2019 Wasin(Yoshi)
//Return: Duplicate/none
//Return Type: string
function JStASTFindObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

// Functionality : Call Page Adjust Stock Add Page
// Parameters : Event Click Buttom
// Creator : 07/06/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvASTCallPageAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmASTPageAdd",
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    if (nStaASTBrowseType == '1') {
                        $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                        $('#odvModalBodyBrowse').html(aReturnData['tASTViewPageAdd']);
                    } else {
                        $('#oliASTTitleEdit').hide();
                        $("#obtASTApprove").hide();
                        $("#obtASTCancel").hide();
                        $('#odvBtnASTInfo').hide();
                        $('#obtASTPrint').hide();
                        $('#oliASTTitleAdd').show();
                        $('#odvBtnAddEdit').show();
                        // ================== Create By Witsarut 28/08/2019 ==================
                        $(".xWBtnGrpSaveLeft").show();
                        $(".xWBtnGrpSaveRight").show();
                        // ================== Create By Witsarut 28/08/2019 ==================
                        $('#odvContentPageAST').html(aReturnData['tASTViewPageAdd']);
                    }

                    JCNxASTControlObjAndBtn();
                    JSvASTLoadPdtDataTableHtml(1);


                    // $('#obtASTBrowseWah').attr('disabled', true);
                    $('#obtASTBrowseShp').attr('disabled', true);
                    $('#obtASTBrowsePos').attr('disabled', true);

                    if (aReturnData['tUsrLevel'] == "SHP") {
                        $('#obtASTBrowseMer').attr('disabled', true);
                        // $('#obtASTBrowseShp').attr('disabled', true);
                        $('#obtASTBrowsePos').attr('disabled', false);
                    }



                    $("#oetASTDocNo,#oetASTDocDate,#oetASTDocTime").blur(function() {
                        JSxASTSetStatusClickSubmit(0);
                        JSxValidateFormAddAST();
                        $('#ofmASTFormAdd').submit();
                    });



                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }

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

function JSvASTCallPageEdit(ptXthDocNo) {
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML("JSvASTCallPageEdit", ptXthDocNo);
    $.ajax({
        type: "POST",
        url: "dcmASTPageEdit",
        data: { ptXthDocNo: ptXthDocNo },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            if (tResult != "") {
                $("#oliASTTitleAdd").hide();
                $("#oliASTTitleEdit").show();
                $("#odvBtnASTInfo").hide();
                $("#odvBtnAddEdit").show();
                $("#odvContentPageAST").html(tResult);
                $("#oetASTDocNo").addClass("xCNDisable");
                $(".xCNDisable").attr("readonly", true);
                $(".xCNiConGen").hide();
                $("#obtASTApprove").show();
                $("#obtASTPrint").show();
                $("#obtASTCancel").show();
                // ================== Create By Witsarut 28/08/2019 ==================
                $(".xWBtnGrpSaveLeft").show();
                $(".xWBtnGrpSaveRight").show();
                // ================== Create By Witsarut 28/08/2019 ==================
            }

            //Control Event Button
            if ($("#ohdASTAutStaEdit").val() == 0) {
                $(".xCNUplodeImage").hide();
                $(".xCNIconBrowse").show();
                $(".xCNEditRowBtn").show();
                $("select").prop("disabled", false);
                $("input").attr("disabled", false);
            } else {
                $(".xCNUplodeImage").show();
                $(".xCNIconBrowse").show();
                $(".xCNEditRowBtn").show();
                $("select").prop("disabled", false);
                $("input").attr("disabled", false);
            }
            //Control Event Button

            //Function Load Table Pdt ของ TFW
            JSvASTLoadPdtDataTableHtml(1);

            //Put Data
            // ohdXthCshOrCrd = $("#ohdXthCshOrCrd").val();
            // $("#ostXthCshOrCrd option[value='" + ohdXthCshOrCrd + "']")
            //   .attr("selected", true)
            //   .trigger("change");

            // Control Object And Button ปิด เปิด
            JCNxASTControlObjAndBtn();
            JCNxLayoutControll();
            $(".xWConditionSearchPdt.disabled").attr("disabled", "disabled");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Product Table Add In Document
// Parameters: Function Ajax Success
// Creator: 10/06/2019 Wasin(Yoshi)
// LastUpdate: -
// Return: View
// ReturnType : View
function JSvASTLoadPdtDataTableHtml(pnPage) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if(typeof nStaSession !== "undefined" && nStaSession == 1){
    JCNxOpenLoading();
    if ($("#ohdASTRoute").val() == "dcmASTEventAdd") {
        var tASTDocNo = "";
    } else {
        var tASTDocNo = $("#oetASTDocNo").val();
    }
    var tSearchAll = $('#oetASTSearchPdtHTML').val();
    var tASTStaApv = $("#ohdASTStaApv").val();
    var tASTStaDoc = $("#ohdASTStaDoc").val();


    var nASTApvSeqChk = $('#ostASTApvSeqChk').val();
    $.ajax({
        type: "POST",
        url: "dcmASTPdtAdvanceTableLoadData",
        data: {
            'ptSearchAll': tSearchAll,
            'ptASTDocNo': tASTDocNo,
            'ptASTStaApv': tASTStaApv,
            'ptASTStaDoc': tASTStaDoc,
            'pnASTApvSeqChk': nASTApvSeqChk,
            'pnASTPageCurrent': pnPage
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {
            var aReturnData = JSON.parse(tResult);
            if (aReturnData['nStaEvent'] == '1') {
                var tASTPdtAdvTableView = aReturnData['tASTPdtAdvTableView'];
                $('#ofmASTFormAdd #odvASTPdtTablePanal').html(tASTPdtAdvTableView);
                // setTimeout(function() {
                    JCNxCloseLoading();
                // }, 500);
            } else {
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
                JCNxCloseLoading();
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            // alert(textStatus);
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    // }else{
    //     JCNxShowMsgSessionExpired();
    // } 
}

//Functionality : main validate form (validate ขั้นที่ 1 ตรวจสอบทั่วไป)
//Parameters : -
//Creator : 19/06/2019 Witsarut(Bell)
//Update : -
//Return : -
//Return Type : - 
function JSxValidateFormAddAST() {

    if ($("#ohdCheckASTClearValidate").val() != 0) {
        $('#ofmASTFormAdd').validate().destroy();
    }
    $('#ofmASTFormAdd').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            oetASTDocNo: {
                "required": {
                    depends: function(oElement) {
                        if ($("#ohdASTRoute").val() == "dcmASTEventAdd") {
                            if ($('#ocbASTStaAutoGenCode').is(':checked')) {
                                return false;
                            } else {
                                return true;
                            }
                        } else {
                            return false;
                        }
                    }
                }
            },
            oetASTDocDate: {
                "required": true
            },
            oetASTWahName: {
                "required": true
            },
            oetASTBchName: {
                "required": true
            },
            //  ******  ปิด การ validate ของเหตุผล  9/01/2020 ******
            // เปิดการ validate อีกครั้ง 24/07/2020 Napat(Jame)
            oetASTRsnName: {
                "required": true
            }
        },
        messages: {
            oetASTDocNo: {
                "required": $('#oetASTDocNo').attr('data-validate-required')
            },
            oetASTDocDate: {
                "required": $('#oetASTDocDate').attr('data-validate-required')
            },
            oetASTWahName: {
                "required": $('#oetASTWahName').attr('data-validate-required')
            },
            oetASTBchName: {
                "required": $('#oetASTBchName').attr('data-validate-required')
            },
            //  ******  ปิด การ validate ของเหตุผล  9/01/2020 ******
            // เปิดการ validate อีกครั้ง 24/07/2020 Napat(Jame)
            oetASTRsnName: {
                "required": $('#oetASTRsnName').attr('data-validate-required')
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
        invalidHandler: function(event, validator) {
            if ($("#ohdCheckASTSubmitByButton").val() == 1) {
                FSvCMNSetMsgWarningDialog("<p>โปรดระบุข้อมูลให้สมบูรณ์</p>");
            }
        },
        submitHandler: function(form) {
            if ($("#ohdASTRoute").val() == "dcmASTEventAdd") {
                if (!$('#ocbASTStaAutoGenCode').is(':checked')) {
                    JSxValidateASTCodeDublicate();
                } else {
                    if ($('#ohdCheckASTSubmitByButton').val() == 1) {

                        JSxSubmitEventByButton();
                    }
                }
            } else {
                if ($('#ohdCheckASTSubmitByButton').val() == 1) {

                    JSxSubmitEventByButton();
                }
            }

        }
    });
    if ($("#ohdCheckASTClearValidate").val() != 0) {
        $('#ofmASTFormAdd').submit();
        $("#ohdCheckASTClearValidate").val(0);
    }
}

//Functionality : validate TFW Code (validate ขั้นที่ 2 ตรวจสอบรหัสเอกสาร)
//Parameters : -
//Creator : 20/06/2019 Bell
//Update : -
//Return : -
//Return Type : -
function JSxValidateASTCodeDublicate() {
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            tTableName: "TCNTPdtAdjStkHD",
            tFieldName: "FTAjhDocNo",
            tCode: $("#oetASTDocNo").val()
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            var aResult = JSON.parse(tResult);
            $("#ohdASTCheckDuplicateCode").val(aResult["rtCode"]);
            if ($("#ohdCheckASTClearValidate").val() != 1) {
                $('#ofmASTFormAdd').validate().destroy();
            }
            $.validator.addMethod('dublicateCode', function(value, element) {
                if ($("#ohdASTRoute").val() == "dcmASTEventAdd") {
                    if ($('#ocbASTStaAutoGenCode').is(':checked')) {
                        return true;
                    } else {
                        if ($("#ohdASTCheckDuplicateCode").val() == 1) {
                            return false;
                        } else {
                            return true;
                        }
                    }
                } else {
                    return true;
                }
            });
            $('#ofmASTFormAdd').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetASTDocNo: {
                        "dublicateCode": {}
                    }
                },
                messages: {
                    oetASTDocNo: {
                        "dublicateCode": "ไม่สามารถใช้รหัสเอกสารนี้ได้"
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
                invalidHandler: function(event, validator) {
                    if ($("#ohdCheckASTSubmitByButton").val() == 1) {
                        FSvCMNSetMsgWarningDialog("<p>โปรดระบุข้อมูลให้สมบูรณ์</p>");
                    }
                },
                highlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function(form) {
                    if ($("ohdCheckASTSubmitByButton").val() == 1) {
                        JSxSubmitEventByButton();
                    }
                }
            });
            if ($("#ohdCheckASTClearValidate").val() != 1) {
                $("#ofmASTFormAdd").submit();
                $("ohdCheckASTClearValidate").val(1);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality : function submit by submit button only (ส่งข้อมูลที่ผ่านการ validate ไปบันทึกฐานข้อมูล)
//Parameters : route
//Creator : 20/06/2019 Bell
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton() {
    var tDocNoSend = ""
    if ($('#ohdASTRoute').val() != "dcmASTEventAdd") {
        tDocNoSend = $("#oetASTDocNo").val();
    }
    $.ajax({
        type: "POST",
        url: "dcmASTCheckPdtTmpForTransfer",
        data: { tDocNo: tDocNoSend },
        cache: false,
        timeout: 0,
        success: function(tResult) {

            var bReturn = JSON.parse(tResult);
            if (bReturn) {
                $.ajax({
                    type: "POST",
                    url: $("#ohdASTRoute").val(),
                    data: $("#ofmASTFormAdd").serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaASTBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn["nStaEvent"] == 1) {
                                if (
                                    aReturn["nStaCallBack"] == "1" ||
                                    aReturn["nStaCallBack"] == null
                                ) {
                                    JSvASTCallPageEdit(aReturn['tCodeReturn']);
                                } else if (aReturn["nStaCallBack"] == "2") {
                                    JSvASTCallPageAdd();
                                } else if (aReturn["nStaCallBack"] == "3") {
                                    JSvASTCallPageList();
                                }
                            } else {
                                tMessageError = aReturnData['tStaMessg'];
                                FSvCMNSetMsgWarningDialog(tMessageError);
                            }
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                FSvCMNSetMsgWarningDialog("<p>โปรดระบุสินค้าที่ท่านต้องการนับรายการสินค้า</p>");
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Function : Control Object And Button ปิด เปิด
function JCNxASTControlObjAndBtn() {
    //Check สถานะอนุมัติ
    ohdXthStaApv = $("#ohdASTStaApv").val();
    ohdASTStaDoc = $("#ohdASTStaDoc").val();

    //Set Default
    //Btn Cancel
    $("#obtASTCancel").attr("disabled", false);
    //Btn Apv
    $("#obtASTApprove").attr("disabled", false);
    $("#obtASTPrint").attr("disabled", false);
    $(".form-control").attr("disabled", false);
    $(".ocbListItem").attr("disabled", false);
    // $(".xCNBtnBrowseAddOn").attr("disabled", false);
    $(".xCNBtnDateTime").attr("disabled", false);
    $(".xCNDocBrowsePdt")
        .attr("disabled", false)
        .removeClass("xCNBrowsePdtdisabled");
    $(".xCNDocDrpDwn").show();
    $("#oetASTSearchPdtHTML").attr("disabled", false);
    $(".xWBtnGrpSaveLeft").attr("disabled", false);
    $(".xWBtnGrpSaveRight").attr("disabled", false);
    $("#oliBtnEditShipAdd").show();
    $("#oliBtnEditTaxAdd").show();

    if (ohdXthStaApv == 1) {
        //Btn Apv
        $("#obtASTApprove").hide();
        $("#obtASTPrint").attr("disabled", false);

        // ========== Edit By Witsarut 27/08/2019 ==================
        $("#obtASTCancel").hide();
        $(".xWBtnGrpSaveLeft").hide();
        $(".xWBtnGrpSaveRight").hide();
        // ========== Edit By Witsarut 27/08/2019 ==================

        //Control input ปิด
        $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt")
            .attr("disabled", true)
            .addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetASTSearchPdtHTML").attr("disabled", false);
        $("#oliBtnEditShipAdd").hide();
        $("#oliBtnEditTaxAdd").hide();
        $('#ocbASTStaDocAct').attr("disabled", true)
    }

    //Check สถานะเอกสาร
    if (ohdASTStaDoc == 3) {
        //Btn Cancel
        $("#obtASTCancel").hide();
        //Btn Apv
        $("#obtASTApprove").hide();
        // ========== Edit By Witsarut 27/08/2019 ==================
        $("#obtASTPrint").hide();
        // ========== Edit By Witsarut 27/08/2019 ==================
        //Control input ปิด
        $(".form-control").attr("disabled", true);
        $(".ocbListItem").attr("disabled", true);
        $(".xCNBtnBrowseAddOn").attr("disabled", true);
        $(".xCNBtnDateTime").attr("disabled", true);
        $(".xCNDocBrowsePdt")
            .attr("disabled", true)
            .addClass("xCNBrowsePdtdisabled");
        $(".xCNDocDrpDwn").hide();
        $("#oetASTSearchPdtHTML").attr("disabled", false);
        $(".xWBtnGrpSaveLeft").hide();
        // ========== Edit By Witsarut 27/08/2019 ==================
        $(".xWBtnGrpSaveRight").hide();
        $("#oliBtnEditShipAdd").hide();
        // ========== Edit By Witsarut 27/08/2019 ==================
        $("#oliBtnEditTaxAdd").hide();
        $('#ocbASTStaDocAct').attr("disabled", true)
    }

}

//Functionality : (event) Add/Edit
//Parameters : form
//Creator : 20/06/2019 bell
//Return : Status Add
//Return Type : n
function JSxASTAddEditDocument() {
    JSxValidateFormAddAST();
}

/*
function : Function Browse Pdt
Parameters : Error Ajax Function 
Creator : 20/06/2019 Witsarut(Bell)
Return : Modal Status Error
Return Type : view
*/
function JCNvAdjStkBrowsePdt() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        aMulti = [];
        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                Qualitysearch: [
                    /*"NAMEPDT",
                    "CODEPDT",
                    "SUP",
                    "PurchasingManager",
                    "NAMEPDT",
                    "CODEPDT",
                    "BARCODE",
                    'LOC',
                    "FromToBCH",
                    "Merchant",
                    "FromToSHP",
                    "FromToPGP",
                    "FromToPTY",
                    "PDTLOGSEQ"*/
                ],
                PriceType: ["Cost", "tCN_Cost", "Company", "1"],
                SelectTier: ["Barcode"],
                ShowCountRecord: 10,
                NextFunc: "FSvPDTAddPdtIntoTableDT",
                ReturnType: "M",
                SPL: ["", ""],
                BCH: [$("#oetASTBchCode").val(), $("#oetASTBchCode").val()],
                SHP: [$("#oetASTShopCode").val(), $("#oetASTShopCode").val()],
                MER: [$("#oetASTMerCode").val(), $("#oetASTMerCode").val()],
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $(".modal.fade:not(#odvModalDOCPDT, #odvModalWanning, #odvASTModalDelPdtDTTemp,#odvModalInfoMessage)").remove();
                $("#odvModalDOCPDT").modal({ backdrop: "static", keyboard: false });
                $("#odvModalDOCPDT").modal({ show: true });

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $("#odvModalsectionBodyPDT").html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
// Create : 2019-06-21 Witsarut(Bell)
function FSvPDTAddPdtIntoTableDT(pjPdtData) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JCNxOpenLoading();
        var ptXthDocNoSend = "";
        if ($("#ohdASTRoute").val() == "dcmASTEventEdit") {
            ptXthDocNoSend = $("#oetASTDocNo").val();
        }

        $.ajax({
            type: "POST",
            url: "dcmASTAddPdtIntoTableDT",
            data: {
                ptAjhDocNo: ptXthDocNoSend,
                pjPdtData: pjPdtData,
                pnAdjStkSubOptionAddPdt: '2' // เพิ่มแถวใหม่ // $("#ocmAdjStkOptionAddPdt").val()
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                JSvASTLoadPdtDataTableHtml(1);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }

}

// Function : แก้ไขสินค้าจาก Table PDT ฝั่ง Client
// Create : 2019-06-21 Witsarut(Bell)
function FSvASTEditPdtIntoTableDT(ptEditSeqNo, paField, paValue) {

    ptXthDocNo = $("#oetASTDocNo").val();
    ptBchCode = $("#ohdASTSesUsrBchCode").val();

    $.ajax({
        type: "POST",
        url: "dcmASTEditPdtIntoTableDT",
        data: {
            ptXthDocNo: ptXthDocNo,
            ptEditSeqNo: ptEditSeqNo,
            paField: paField,
            paValue: paValue
        },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            JSvASTLoadPdtDataTableHtml(1);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality: Del Pdt In Row Html And Del in DB
//Parameters: Event Proporty
//Creator: 04/04/2019 Witsarut(Bell)
//Return:  Call function Delete
function JSxASTRemoveRowDTTmp(ele) {
    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var tVal    = $(ele).parent().parent().attr("data-pdtcode");
        var tSeqno  = $(ele).parent().parent().attr("data-seqno");
        // $(ele).parent().parent().parent().remove();
        JSnASTRemoveDTTemp(tSeqno, tVal);
    // } else {
    //     JCNxShowMsgSessionExpired();
    // }
}


//Functionality: Remove DT Temp
//Parameters: Event Proporty
//Creator: 24/06/2019 Witsarut(Bell)
//Return:  Call function Delete
function JSnASTRemoveDTTemp(ptSeqno, ptPdtCode) {

    // var nStaSession = JCNxFuncChkSessionExpired();
    // if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        ptXthDocNo  = $('#oetASTDocNo').val();
        nPage       = $(".xWPageASTPdt .active").text();
        ptRoute     = $('#ohdASTRoute').val();

        $.ajax({
            type: "POST",
            url: "dcmASTRemovePdtInDTTmp",
            data: {
                ptXthDocNo: ptXthDocNo,
                ptSeqno: ptSeqno,
                ptPdtCode: ptPdtCode,
                ptRoute: ptRoute
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                JSvASTLoadPdtDataTableHtml(nPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    // } else {
    //     JCNxShowMsgSessionExpired();
    // }
}

//Functionality: Event Edit Pdt Table
//Parameters: Event Proporty
//Creator: 24/06/2019 Witsarut(Bell)
//Return:  Status Edit
function JSnEditDTRow(event) {
    var tTypeButton = $(".xCNTextDetail2.xWPdtItem > td > lable > img").not("[title='Remove']");
    for (var nI = 0; nI < tTypeButton.length; nI++) {
        if ($(tTypeButton.get(nI)).attr("title") == "Edit") {
            $(tTypeButton.get(nI)).addClass("xCNDisabled");
            $(tTypeButton.get(nI)).attr("onclick", "");
            $(tTypeButton.get(nI)).unbind("click");
        }
    }
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {

        var tEditSeqNo = $(event)
            .parents()
            .eq(2)
            .attr("data-seqno");
        $(".xWShowInLine" + tEditSeqNo).addClass("xCNHide");
        $(".xWEditInLine" + tEditSeqNo).removeClass("xCNHide");

        $(event)
            .parents()
            .eq(2)
            .find(".xWPdtOlaShowQty")
            .addClass("xCNHide");

        $(event)
            .parents()
            .eq(2)
            .find(".xWPdtDivSetQty")
            .removeClass("xCNHide");
        $(event)
            .parents()
            .eq(2)
            .find(".xWPdtDivSetQty")
            .find(".xWPdtSetInputQty")
            .focus();

        $($(event).parent().parent().parent().find("td div input.xWValueEditInLine" + tEditSeqNo)).blur(function(event) {
            if ($(event.target).val() == "") {
                $(event.target).val(0);
            }
        });
        $(event)
            .parent()
            .empty()
            .append(
                $("<img>")
                .attr("class", "xCNIconTable")
                .attr("title", "Save")
                .attr(
                    "src",
                    tBaseURL +
                    "/application/modules/common/assets/images/icons/save.png"
                )
                .click(function() {
                    JSnSaveDTEditNewInline({
                        VeluesInline: $(this).val(),
                        Element: $(this)
                    });
                })
            );
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Save Pdt And Calculate Field
//Parameters: Event Proporty
//Creator: 24/06/2019 Witsarut(Bell)
//Return:  Cpntroll input And Call Function Edit
function JSnSaveDTEditNewInline(paEvent) {
    var tEditSeqNo = $(paEvent.Element).parents().eq(2).attr("data-seqno");
    var aDataUpdateEditInLine = [];

    $(".xWValueEditInLine" + tEditSeqNo).each(function(index) {
        if (!$(this).is(':disabled')) {
            tValue = $(this).val();
            tField = $(this).attr("data-field");
            $(".xWShowValue" + tField + tEditSeqNo).text(tValue);
            aDataUpdateEditInLine.push({
                'tValue': tValue,
                'tField': tField
            });
        }
    });
    JSaUpdateInLineData(aDataUpdateEditInLine, tEditSeqNo);
}

function JSaUpdateInLineData(paDataEditInLine, ptEditSeqNo) {
    $.ajax({
        type: "POST",
        url: "dcmASTUpdateInline",
        data: {
            tASTBchCode: $('#oetASTBchCode').val(),
            tASTDocNo: $('#oetASTDocNo').val(),
            tASTSeqUpd: ptEditSeqNo,
            aASTDataEditInLine: paDataEditInLine
        },
        success: function(tResult) {
            var aDataReturn = JSON.parse(tResult);
            if (aDataReturn['tStaCode'] == '1') {
                JSvASTLoadPdtDataTableHtml(1);
            } else {
                var tMsgStaErr = aDataReturn['tStaMsgErr'];
                JCNxResponseError(tMsgStaErr);
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSxSaveColumnShow() {
    var aColShowSet = [];
    $(".xWASTInputColStaShow:checked").each(function() {
        aColShowSet.push($(this).data("id"));
    });

    var aColShowAllList = [];
    $("#xWASTInputColStaShow").each(function() {
        aColShowAllList.push($(this).data("id"));
    });

    var aColumnLabelName = [];
    $(".xWASTLabelColumnName").each(function() {
        aColumnLabelName.push($(this).text());
    });

    var nStaSetDef;
    if ($("#ocbASTSetDefAdvTable").is(":checked")) {
        nStaSetDef = 1;
    } else {
        nStaSetDef = 0;
    }

    $.ajax({
        type: "POST",
        url: "dcmASTAdvanceTableShowColSave",
        data: {
            aColShowSet: aColShowSet,
            nStaSetDef: nStaSetDef,
            aColShowAllList: aColShowAllList,
            aColumnLabelName: aColumnLabelName
        },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            $("#odvASTOrderAdvTblColumns").modal("hide");
            $(".modal-backdrop").remove();
            JSvASTLoadPdtDataTableHtml(1);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality: Event Pdt Multi Delete
//Parameters: Event Button Delete All
//Creator: 24/06/2019 Witsarut(Bell)
//Return:  object Status Delete
//Return Type: object
function JSoASTPdtDelChoose(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var aSeq = $("#ohdASTConfirmSeqDelete").val();
        var tDocNo = $("#oetASTDocNo").val();

        //PdtCode
        var aTextSeq = aSeq.substring(0, aSeq.length - 2);
        var aSeqSplit = aTextSeq.split(" , ");
        var aSeqSplitlength = aSeqSplit.length;
        //Seq
        var aTextSeq = aSeq.substring(0, aSeq.length - 2);
        var aSeqSplit = aTextSeq.split(" , ");
        var aSeqData = [];

        for ($i = 0; $i < aSeqSplitlength; $i++) {
            aSeqData.push(aSeqSplit[$i]);
        }

        if (aSeqSplitlength > 1) {
            localStorage.StaDeleteArray = "1";

            $.ajax({
                type: "POST",
                url: "dcmASTPdtMultiDeleteEvent",
                data: {
                    tDocNo: tDocNo,
                    tSeqCode: aSeqData
                },
                success: function(tResult) {
                    console.log(tResult);
                    setTimeout(function() {
                        $("#odvASTModalDelPdtDTTemp").modal("hide");
                        JSvASTLoadPdtDataTableHtml(1);
                        $("#ospASTConfirmDelPdtDTTemp").text($("#oetTextComfirmDeleteSingle").val());
                        $("#ohdASTConfirmSeqDelete").val("");
                        $("#ohdASTConfirmPdtDelete").val("");
                        $("#ohdASTConfirmPunDelete").val("");
                        $("#ohdASTConfirmDocDelete").val("");
                        localStorage.removeItem("LocalItemData");
                        $(".obtChoose").hide();
                        $(".modal-backdrop").remove();
                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = "0";
            return false;
        }
    } else {
        JCNxShowMsgSessionExpired();
    }

}


//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 24/06/2019 Witsarut(Bell)
//Return: -
//Return Type: 
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliASTDelPdtDT").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliASTDelPdtDT").removeClass("disabled");
        } else {
            $("#oliASTDelPdtDT").addClass("disabled");
        }
    }
}


//Functionality: Event Edit Inline Pdt Table
//Parameters: Event Proporty
//Creator: 04/04/2019 Witsarut(Bel;l)
//Return:  Status Edit
function JSxASTEditRowDTTmp(event) {

    var tTypeButton = $(".xCNTextDetail2.xWPdtItem > td > lable > img").not("[title='Remove']");
    for (var nI = 0; nI < tTypeButton.length; nI++) {
        if ($(tTypeButton.get(nI)).attr("title") == "Edit") {
            $(tTypeButton.get(nI)).addClass("xCNDisabled");
            $(tTypeButton.get(nI)).attr("onclick", "");
            $(tTypeButton.get(nI)).unbind("click");
        }
    }
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var tEditSeqNo = $(event)
            .parents()
            .eq(2)
            .attr("data-seqno");
        $(".xWShowInLine" + tEditSeqNo).addClass("xCNHide");
        $(".xWEditInLine" + tEditSeqNo).removeClass("xCNHide");

        $(event)
            .parents()
            .eq(2)
            .find(".xWPdtOlaShowQty")
            .addClass("xCNHide");

        $(event)
            .parents()
            .eq(2)
            .find(".xWPdtDivSetQty")
            .removeClass("xCNHide");

        $(event)
            .parents()
            .eq(2)
            .find(".xWPdtDivSetQty")
            .find(".xWPdtSetInputQty")
            .focus();

        $($(event).parent().parent().parent().find("td div input.xWValueEditInLine" + tEditSeqNo)).blur(function(event) {
            if ($(event.target).val() == "") {
                $(event.target).val(0);
            }
        });

        $(event)
            .parent()
            .empty()
            .append(
                $("<img>")
                .attr("class", "xCNIconTable")
                .attr("title", "Save")
                .attr(
                    "src",
                    tBaseURL +
                    "/application/modules/common/assets/images/icons/save.png"
                )
                .click(function() {
                    JSnSaveDTEditNewInline({
                        VeluesInline: $(this).val(),
                        Element: $(this)
                    });
                })
            );

    } else {
        JCNxShowMsgSessionExpired();
    }
}


//Functionality : Generate Code Subdistrict
//Parameters : Event Icon Click
//Creator : 26/06/2019 Witsarut
//Return : Data
//Return Type : String
function JStGenerateASTCode() {
    var tTableName = "TCNTPdtAdjStkHD";
    JCNxOpenLoading();

    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        timeout: 0,
        success: function(tResult) {
            console.log(tResult);
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == "1") {
                console.log(tData);
                $('#oetASTDocNo').val(tData.rtXthDocNo);
                $("#oetASTDocNo").addClass("xCNDisable");
                $(".xCNDisable").attr("readonly", true);
                //----------Hidden ปุ่ม Gen
                $(".xCNBtnGenCode").attr("disabled", true);
                $('#oetASTDocDate').focus();
                $('#oetASTDocDate').focus();

                JStCMNCheckDuplicateCodeMaster(
                    "oetASTDocNo",
                    "JSvASTCallPageEdit",
                    "TCNTPdtAdjStkHD",
                    "FTAjhDocNo"
                );
            } else {
                $("#oetASTDocNo").val(tData.rtDesc);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


// Functionality : Action for approve
// Parameters : pbIsConfirm
// Creator : 11/04/2019 Witsarut(Bell)
// Last Modified : -
// Return : -
// Return Type : -
function JSnASTCancelDoc(pbIsConfirm) {

    tXthDocNo = $("#oetASTDocNo").val();

    if (pbIsConfirm) {
        $.ajax({
            type: "POST",
            url: "dcmASTCancel",
            data: {
                tXthDocNo: tXthDocNo
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $("#odvASTPopupCancel").modal("hide");
                aResult = $.parseJSON(tResult);
                if (aResult.nSta == 1) {
                    JSvASTCallPageEdit(tXthDocNo);

                } else {
                    JCNxCloseLoading();
                    tMsgBody = aResult.tMsg;
                    FSvCMNSetMsgWarningDialog(tMsgBody);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        //Check Status Approve for Control Msg In Modal
        nStaApv = $("#ohdASTStaApv").val();
        if (nStaApv == 1) {
            $("#obpMsgApv").show();
        } else {
            $("#obpMsgApv").hide();
        }
        $("#odvASTPopupCancel").modal("show");

    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function
//Creator : 04/07/2018 Krit
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
            tMsgError += tHtmlError.find("p:nth-child(2)").text();
            break;
        case 500:
            tMsgError += tHtmlError.find("p:nth-child(3)").text();
            break;

        default:
            tMsgError += "something had error. please contact admin";
            break;
    }
    $("body").append(tModal);
    $("#modal-customs").attr(
        "style",
        "width: 450px; margin: 1.75rem auto;top:20%;"
    );
    $("#myModal").modal({ show: true });
    $("#odvModalBody").html(tMsgError);
}



//Functionality : Action for approve
//Parameters : pbIsConfirm
//Creator : 11/04/2019 Witsarut(Bell)
//Last Modified : -
//Return : -
//Return Type : -
function JSnASTApprove(pbIsConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            if (pbIsConfirm) {
                $("#ohdCardShiftTopUpCardStaPrcDoc").val(2); // Set status for processing approve 
                $('#odvASTModalAppoveDoc').modal("hide");

                var tXthDocNo = $("#oetASTDocNo").val();
                var tXthStaApv = $("#ohdASTStaApv").val();
                var tASTBchCode = $("#oetASTBchCode").val();
                $.ajax({
                    type: "POST",
                    url: "dcmASTApprove",
                    data: {
                        tXthDocNo: tXthDocNo,
                        tXthStaApv: tXthStaApv,
                        tBchCode: tASTBchCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        tResult = tResult.replace("\r\n", "");
                        let oResult = JSON.parse(tResult);
                        if (oResult["nStaEvent"] == "900") {
                            FSvCMNSetMsgErrorDialog(oResult["tStaMessg"]);
                        } else {
                            JSoASTSubscribeMQ();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                //console.log("StaApvDoc Call Modal");
                $('#odvASTModalAppoveDoc').modal("show");
            }
        } catch (err) {
            console.log("JSnTFWApprove Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


//Functionality : Action for approve
//Parameters : pbIsConfirm
//Creator : 29/06/2019 Witsarut(Bell)
//Last Modified : 30/07/2019 Wasin (Yoshi)
//Return : -
//Return Type : -
function JSoASTSubscribeMQ() {
    //RabbitMQ
    /*===========================================================================*/
    // Document variable
    var tLangCode = $("#ohdASTLangEdit").val();
    var tUsrBchCode = $("#ohdASTBchCode").val();
    var tUsrApv = $("#ohdASTApvCodeUsrLogin").val();
    var tDocNo = $("#oetASTDocNo").val();
    var tPrefix = 'RESAJS';
    var tStaApv = $("#ohdASTStaApv").val();
    var tStaDelMQ = $("#ohdASTStaDelMQ").val();
    var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

    // MQ Message Config
    var poDocConfig = {
        tLangCode: tLangCode,
        tUsrBchCode: tUsrBchCode,
        tUsrApv: tUsrApv,
        tDocNo: tDocNo,
        tPrefix: tPrefix,
        tStaDelMQ: tStaDelMQ,
        tStaApv: tStaApv,
        tQName: tQName
    };

    // console.log(poDocConfig);

    // RabbitMQ STOMP Config
    var poMqConfig = {
        host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
        username: oSTOMMQConfig.user,
        password: oSTOMMQConfig.password,
        vHost: oSTOMMQConfig.vhost
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: 'JSvASTCallPageEdit',
        tCallPageList: 'JSvASTCallPageList'
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams = {
        ptDocTableName: "TCNTPdtAdjStkHD",
        ptDocFieldDocNo: "FTAjhDocNo",
        ptDocFieldStaApv: "FTAjhStaPrcStk",
        ptDocFieldStaDelMQ: "FTAjhStaDelMQ",
        ptDocStaDelMQ: "1",
        ptDocNo: tDocNo
    };


    //Check Show Progress %
    FSxCMNRabbitMQMessage(
        poDocConfig,
        poMqConfig,
        poUpdateStaDelQnameParams,
        poCallback
    );

    //Check Show Progress %
    // FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    /*===========================================================================*/
    // RabbitMQ
}

/**
 * Functionality : Check Delete Qname Status
 * Parameters : ptStatus is status approve('' = not, 1 = removed)
 * Creator : 27/02/2019 piya
 * Last Modified : -
 * Return : Approve status
 * Return Type : boolean
 */
function JSbASTIsStaDelQname(ptStatus) {
    try {
        ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
        let bStatus = false;
        if (($("#ohdASTStaDelMQ").val() == ptStatus)) {
            bStatus = true;
        }
        // return bStatus;
        // alert('bStatus: ' + bStatus);
    } catch (err) {
        console.log("JSbASTIsStaDelQname Error: ", err);
    }
    // alert('JSbSPAIsStaDelQname Error : ' + bStatus);
}


/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbASTIsUpdatePage() {
    try {
        var tCardShiftOutCode = $('#oetASTDocNo').val();
        var bStatus = false;
        if (!tCardShiftOutCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JCNbASTIsUpdatePage Error: ', err);
    }
}


/**
 * Functionality : Check Approve Processing
 * Parameters : ptStatus is status approve('' = pending, 2 = processing, 1 = approved)
 * Creator : 27/02/2019 piya
 * Last Modified : -
 * Return : Approve status
 * Return Type : boolean
 */
function JSbASTIsStaApv(ptStatus) {
    try {
        ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
        let bStatus = false;
        if (($("#ohdASTStaApv").val() == ptStatus)) {
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log("JSbASTIsStaApv Error: ", err);
    }
}



//Functionality : main validate form (validate ขั้นที่ พิเศษ ตรวจสอบเลขที่การขนส่ง)
//Parameters : -
//Creator : 22/05/2019 pap
//Update : -
//Return : -
//Return Type : -
// function JSxASTValidateViaOrderBeforeApvDoc(){

// }

//Functionality : เซ็ตค่าเพื่อให้รู้ว่าตอนนี้กดปุ่มบันทึกหลักจริงๆ (เพราะมีการซัมมิทฟอร์มแต่ไม่บันทึกเพื่อให้เกิด validate ใน on blur)
//Parameters : -
//Creator : 20/06/2019 Bell
//Update : -
//Return : -
//Return Type : -
function JSxASTSetStatusClickSubmit(pnStatus) {
    $("#ohdCheckASTSubmitByButton").val(pnStatus);
}

//Function : Search Pdt
//Parameters : -
//Creator : 30/06/2019 Witsarut(Bell)
//Last Modified : -
//Return : -
//Return Type : -
function JSvASTSearchPdtHTML() {
    var value = $("#oetASTSearchPdtHTML")
        .val()
        .toLowerCase();
    $("#otbASTDocPdtAdvTable tbody tr ").filter(function() {
        tText = $(this).toggle(
            $(this)
            .text()
            .toLowerCase()
            .indexOf(value) > -1
        );
    });
}

//Function : Scan Pdt
//Parameters : -
//Creator : 30/06/2019 Witsarut(Bell)
//Last Modified : -
//Return : -
//Return Type : -
function JSvASTScanPdtHTML() {

    tBarCode = $("#oetASTScanPdtHTML").val();
    tSplCode = $("#oetSplCode").val();

    if (tBarCode != "") {
        JCNxOpenLoading();

        $.ajax({
            type: "POST",
            url: "dcmASTGetPdtBarCode",
            data: {
                tBarCode: tBarCode,
                tSplCode: tSplCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                aResult = $.parseJSON(tResult);

                if (aResult.aData != 0) {
                    tData = $.parseJSON(aResult.aData);

                    tPdtCode = tData[0].FTPdtCode;
                    tPunCode = tData[0].FTPunCode;

                    //Funtion Add Pdt To Table
                    FSvPDTAddPdtIntoTableDT(tPdtCode, tPunCode);

                    $("#oetASTScanPdtHTML").val("");
                    $("#oetASTScanPdtHTML").focus();
                } else {
                    JCNxCloseLoading();
                    tMsgBody = aResult.tMsg;
                    FSvCMNSetMsgWarningDialog(tMsgBody);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        $("#oetASTScanPdtHTML").focus();
    }
}

//Functionality : เปลี่ยนหน้า pagenation product table
//Parameters : Event Click Pagination
//Creator : 01/07/2019 Witsarut(Bell)
//Return : View
//Return Type : View
function JSvASTPdtDTClickPage(ptPage) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        var nPageCurrent = 0;
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPageASTPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPageASTPdt .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JCNxOpenLoading();

        JSvASTLoadPdtDataTableHtml(nPageCurrent);


    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 01/07/2017 "Witsarut"
//Return: -
//Return Type: -
function JSxASTTextInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
        var tTextCode = "";
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += " , ";
        }


        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $(".xCNIconDel").addClass("xCNDisabled");
        } else {
            $(".xCNIconDel").removeClass("xCNDisabled");
        }
        $("#ospTextConfirmDelMultiple").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
        $("#ohdConfirmIDDelete").val(tTextCode);
        $("#ohdConfirmIDDelMultiple").val(tTextCode);
    }
}

//Create By : Napat(Jame) 2020/07/29
function JSxASTEventAddProducts() {

    var aDataCondition = {};
    jQuery.each($('#ofmASTFilterDataCondition').serializeArray(), function(i, aRes) {
        if (aRes.value == "") {
            tResult = null;
        } else {
            tResult = aRes.value;
        }
        aDataCondition[aRes.name] = tResult;
    });

    var aDataInsert = {
        tBchCode: $('#oetASTBchCode').val(),
        tDocNo: $('#oetASTDocNo').val()
    };

    // console.log(aDataCondition);
    // console.log(aDataInsert);

    $.ajax({
        type: "POST",
        url: "docAdjStkEventAddProducts",
        data: {
            paCondition: aDataCondition,
            paDataInsert: aDataInsert
        },
        cache: false,
        Timeout: 0,
        success: function(oResult) {
            var aResult = $.parseJSON(oResult);
            // console.log(aResult);

            switch (aResult['tCode']) {
                case '1':
                    $('#odvAdjStkFilterDataCondition').modal('hide');
                    JSvASTLoadPdtDataTableHtml(1);
                    break;
                default:
                    alert(aResult['tDesc']);
                    break;
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Create By : Napat(Jame) 30/07/2020
function JSxAdjStkEditInLine(poElm) {
    if (sessionStorage.getItem("EditInLine") == "1") {
        sessionStorage.setItem("EditInLine", "2");

        // Get Variable
        var tDocNo = $('#oetASTDocNo').val();
        var nSeq = poElm.parent().parent().parent().attr('data-seqno');
        var tField = poElm.attr('data-field');
        var nIndex = $('.xW' + tField).index(poElm);
        var nVal = parseInt($(poElm).val());

        // Check Values
        if (tDocNo == "" || tDocNo === undefined) { tDocNo = ' '; }
        if (isNaN(nVal) || nVal === undefined) { nVal = 0; }

        // Next Focus Inputs
        $('.xW' + tField).eq(nIndex + 1).focus();

        // Remove Session
        sessionStorage.removeItem("EditInLine");

        // Call Ajax
        // $.ajax({
        //     type: "POST",
        //     url: "dcmASTUpdateInline",
        //     data: {
        //         tASTDocNo           : $('#oetASTDocNo').val(),
        //         tASTSeqUpd          : ptEditSeqNo,
        //         aASTDataEditInLine  : paDataEditInLine
        //     },
        //     success: function (tResult){
        //         var aDataReturn = JSON.parse(tResult);
        //         if(aDataReturn['tStaCode'] == '1'){
        //             JSvASTLoadPdtDataTableHtml(1);
        //         }else{
        //             var tMsgStaErr  = aDataReturn['tStaMsgErr'];
        //             JCNxResponseError(tMsgStaErr);
        //         }
        //     },
        //     error: function (jqXHR, textStatus, errorThrown) {
        //         JCNxResponseError(jqXHR, textStatus, errorThrown);
        //     }
        // });
        $.ajax({
            type: "POST",
            url: "dcmASTUpdateInline",
            data: {
                ptDocNo: tDocNo,
                pnSeq: nSeq,
                pnVal: nVal,
                ptField: tField
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturn = JSON.parse(oResult);
                // console.log(aReturn);
                if (aReturn['nStaQuery'] != 1) {
                    JCNxResponseError(aReturn['nStaQuery']['tStaMeg']);
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }
}