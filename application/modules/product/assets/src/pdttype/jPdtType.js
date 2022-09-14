var nStaPtyBrowseType   = $('#oetPtyStaBrowse').val();
var tCallPtyBackOption  = $('#oetPtyCallBackOption').val();
// alert(nStaPtyBrowseType+'//'+tCallPtyBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPtyNavDefult();
    if(nStaPtyBrowseType != 1){
        JSvCallPagePdtTypeList(1);
    }else{
        JSvCallPagePdtTypeAdd();
    }
});

//function : Function Clear Defult Button Product Type
//Parameters : Document Ready
//Creator : 14/09/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxPtyNavDefult(){
    if(nStaPtyBrowseType != 1 || nStaPtyBrowseType == undefined){
        $('.xCNPtyVBrowse').hide();
        $('.xCNPtyVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPtyTitleAdd').hide();
        $('#oliPtyTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPtyInfo').show();
    }else{
        $('#odvModalBody .xCNPtyVMaster').hide();
        $('#odvModalBody .xCNPtyVBrowse').show();
        $('#odvModalBody #odvPtyMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPtyNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPtyBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPtyBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPtyBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// //function : Function Show Event Error
// //Parameters : Error Ajax Function 
// //Creator : 14/09/2018 wasin
// //Return : Modal Status Error
// //Return Type : view
// function JCNxResponseError(jqXHR,textStatus,errorThrown){
//     JCNxCloseLoading();
//     var tHtmlError = $(jqXHR.responseText);
//     var tMsgError = "<h3 style='font-size:20px;color:red'>";
//     tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
//     tMsgError += " Error<hr></h3>";
//     switch (jqXHR.status) {
//         case 404:
//             tMsgError += tHtmlError.find('p:nth-child(2)').text();
//             break;
//         case 500:
//             tMsgError += tHtmlError.find('p:nth-child(3)').text();
//             break;

//         default:
//             tMsgError += 'something had error. please contact admin';
//             break;
//     }

//     $("body").append(tModal);
//     $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
//     $('#myModal').modal({ show: true });
//     $('#odvModalBody').html(tMsgError);
// }

//function : Call Product Type Page list  
//Parameters : Document Redy And Event Button
//Creator :	14/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtTypeList(pnPage){
    localStorage.tStaPageNow = 'JSvCallPagePdtTypeList';
    $('#oetSearchPdtType').val('');
    // JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdttypeList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtType').html(tResult);
            JSvPdtTypeDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Type Data List
//Parameters: Ajax Success Event 
//Creator:	14/09/2018 wasin
//Return: View
//Return Type: View
function JSvPdtTypeDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtType').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdttypeDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtType').html(tResult);
            }
            JSxPtyNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtType_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Type Page Add  
//Parameters : Event Button Click
//Creator : 14/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtTypeAdd(){
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdttypePageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaPtyBrowseType == 1) {
                $('.xCNPtyVMaster').hide();
                $('.xCNPtyVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            }else{
                $('.xCNPtyVBrowse').hide();
                $('.xCNPtyVMaster').show();
                $('#oliPtyTitleEdit').hide();
                $('#oliPtyTitleAdd').show();
                $('#odvBtnPtyInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtType').html(tResult);
            }
            
            $('#ocbPtyAutoGenCode').change(function(){
                $("#oetPtyCode").val("");
                if($('#ocbPtyAutoGenCode').is(':checked')) {
                    $("#oetPtyCode").attr("readonly", true);
                    $("#oetPtyCode").attr("onfocus", "this.blur()");
                    $('#odvPtyCodeForm').removeClass('has-error');
                    $('#odvPtyCodeForm em').remove();
                }else{
                    $("#oetPtyCode").attr("readonly", false);
                    $("#oetPtyCode").removeAttr("onfocus");
                }
            });
            $("#oetPtyCode").blur(function(){
                if(!$('#ocbPtyAutoGenCode').is(':checked')) {
                    if($("#ohdCheckPtyClearValidate").val()==1){
                        $('#ofmAddPdtType').validate().destroy();
                        $("#ohdCheckPtyClearValidate").val("0");
                    }
                    if($("#ohdCheckPtyClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtType",
                                tFieldName : "FTPtyCode",
                                tCode : $("#oetPtyCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePtyCode").val(aResult["rtCode"]);
                                JSxValidationFormPdtType("",$("#ohdPdtTypeRoute").val());
                                $('#ofmAddPdtType').submit();
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
function JSxValidationFormPdtType(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdttypeEventAdd"){
            if($('#ocbPtyAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicatePtyCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    });
    $('#ofmAddPdtType').validate({
        rules: {
            oetPtyCode : {
                "required" :{
                  // ตรวจสอบเงื่อนไข validate
                  depends: function(oElement) {
                    if(ptRoute=="pdttypeEventAdd"){
                        if($('#ocbPtyAutoGenCode').is(':checked')){
                            return false;
                        }else{
                            return true;
                        }
                    }else{
                        return false;
                    }
                  }
                },
                "dublicateCode" :{}
            },
            oetPtyName: {
                "required" :{}
            }
        },
        messages: {
            oetPtyCode : {
                "required" :$('#oetPtyCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPtyCode').attr('data-validate-dublicateCode')
            },
            oetPtyName : {
                "required" :$('#oetPtyName').attr('data-validate-required')
            },
        },
        errorElement: "em",
        errorPlacement: function (error, element ) {
            error.addClass( "help-block" );
            if ( element.prop( "type" ) === "checkbox" ) {
                error.appendTo( element.parent( "label" ) );
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0){
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function ( element, errorClass, validClass ) {
            $( element ).closest('.form-group').addClass( "has-error" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).closest('.form-group').removeClass( "has-error" );
        },
        submitHandler: function(form){
            if(pFnSubmitName!=""){
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
function JSxSubmitEventByButton(ptRoute){
    if($("#ohdCheckPtyClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtType').serialize(),
            success: function(oResult){
                if(nStaPtyBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtTypeEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtTypeAdd();
                                break;
                            case '3':
                                JSvCallPagePdtTypeList(1);
                                break;
                            default:
                                JSvCallPagePdtTypeEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPtyBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Product Type Page Edit  
//Parameters : Event Button Click 
//Creator : 17/09/2018 wasin
//Return : View
//Return Type : View
function JSvCallPagePdtTypeEdit(ptPtyCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtTypeEdit',ptPtyCode);
    $.ajax({
        type: "POST",
        url: "pdttypePageEdit",
        data: { tPtyCode: ptPtyCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliPtyTitleAdd').hide();
                $('#oliPtyTitleEdit').show();
                $('#odvBtnPtyInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtType').html(tResult);
                $('#oetPtyCode').addClass('xCNDisable');
                $('#oetPtyCode').attr('readonly', true);
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
function JSxSetStatusClickPdtTypeSubmit(){
    $("#ohdCheckPtyClearValidate").val("1");
}

//Functionality : Event Add/Edit Product Type
//Parameters : From Submit
//Creator : 17/09/2018 wasin
//Return : Status Event Add/Edit Product Type
//Return Type : object
function JSoAddEditPdtType(ptRoute){
    if($("#ohdCheckPtyClearValidate").val()==1){
        $('#ofmAddPdtType').validate().destroy();
        if(!$('#ocbPtyAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtType",
                    tFieldName : "FTPtyCode",
                    tCode : $("#oetPtyCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePtyCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtType("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtType').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormPdtType("JSxSubmitEventByButton",ptRoute);
        }
        
    }
}

//Functionality : Generate Code Product Type
//Parameters : Event Button Click
//Creator : 17/09/2018 wasin
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtTypeCode(){
    var tTableName = 'TCNMPdtType';
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
                $('#oetPtyCode').val(tData.rtPtyCode);
                $('#oetPtyCode').addClass('xCNDisable');
                $('#oetPtyCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPtyCode').focus();
                $('#oetPtyName').focus();
            } else {
                $('#oetPtyCode').val(tData.rtDesc);
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
//Creator : 17/09/2018 wasin
//Return : object Status Delete
//Return Type : object
function JSoPdtTypeDel(pnPage,ptName,tIDCode,tYesOnNo){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtType').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdttypeEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        // $('#odvModalDelPdtType').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtTypeDataTable(pnPage);

                        if (tData['nStaEvent'] == '1'){
                            $('#odvModalDelPdtType').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(tData["nNumRowPdtPty"]!=0){
                                    if(tData["nNumRowPdtPty"]>10){
                                        nNumPage = Math.ceil(tData["nNumRowPdtPty"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPagePdtTypeList(pnPage);
                                        }else{
                                            JSvCallPagePdtTypeList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPagePdtTypeList(1);
                                    }
                                }else{
                                    JSvCallPagePdtTypeList(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(tData['tStaMessg']);                        
                        }
                        JSxPtyNavDefult();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
    // var aData               = $('#ospConfirmIDDelete').val();
    // var aTexts              = aData.substring(0, aData.length - 2);
    // var aDataSplit          = aTexts.split(" , ");
    // var aDataSplitlength    = aDataSplit.length;
    // var aNewIdDelete        = [];
    // if (aDataSplitlength == '1'){
       
    //     $('#odvModalDelPdtType').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdttypeEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtType').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtTypeDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxPtyNavDefult();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     });
    // }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/09/2018 wasin
//Return:  object Status Delete
//Return Type: object
function JSoPdtTypeDelChoose(pnPage){
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
            url: "pdttypeEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxPtyNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtType').modal('hide');
                //     JSvPdtTypeDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);

                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtType').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPdtPty"]!=0){
                            if(aReturn["nNumRowPdtPty"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPdtPty"]/10);
                                if(tCurrentPage<=nNumPage){
                                    JSvCallPagePdtTypeList(tCurrentPage);
                                }else{
                                    JSvCallPagePdtTypeList(nNumPage);
                                }
                            }else{
                                JSvCallPagePdtTypeList(1);
                            }
                        }else{
                            JSvCallPagePdtTypeList(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);                        
                }
                JSxPtyNavDefult();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });


    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }

    // JCNxOpenLoading();
    // var aData       = $('#ospConfirmIDDelete').val();
    // var aTexts      = aData.substring(0, aData.length - 2);
    // var aDataSplit  = aTexts.split(" , ");
    // var aDataSplitlength = aDataSplit.length;
    // var aNewIdDelete = [];
    // for ($i = 0; $i < aDataSplitlength; $i++) {
    //     aNewIdDelete.push(aDataSplit[$i]);
    // }
    // if (aDataSplitlength > 1){
    //     localStorage.StaDeleteArray = '1';
    //     $.ajax({
    //         type: "POST",
    //         url: "pdttypeEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtType').modal('hide');
    //                     JSvCallPagePdtTypeList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPtyNavDefult();
    //         },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }else{
    //     localStorage.StaDeleteArray = '0';
    //     return false;
    // }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/09/2018 wasin
//Return : View
//Return Type : View
function JSvPdtTypeClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtType .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtType .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtTypeDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 17/09/2018 wasin
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
//Creator: 17/09/2018 wasin
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
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 17/09/2018 wasin
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
