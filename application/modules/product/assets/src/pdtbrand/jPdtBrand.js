var nStaPbnBrowseType   = $('#oetPbnStaBrowse').val();
var tCallPbnBackOption  = $('#oetPbnCallBackOption').val();
// alert(nStaPbnBrowseType+'//'+tCallPbnBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPbnNavDefult();
    if(nStaPbnBrowseType != 1){
        JSvCallPagePdtPbnList();
    }else{
        JSvCallPagePdtPbnAdd();
    }
});

//function : Function Clear Defult Button Product Brand
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPbnNavDefult(){
    if(nStaPbnBrowseType != 1 || nStaPbnBrowseType == undefined){
        $('.xCNPbnVBrowse').hide();
        $('.xCNPbnVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPbnTitleAdd').hide();
        $('#oliPbnTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPbnInfo').show();
    }else{
        $('#odvModalBody .xCNPbnVMaster').hide();
        $('#odvModalBody .xCNPbnVBrowse').show();
        $('#odvModalBody #odvPbnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPbnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPbnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPbnBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPbnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 17/10/2018 witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR,textStatus,errorThrown){
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

//function : Call Product Brand Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPbnList(){
    localStorage.tStaPageNow = 'JSvCallPagePdtPbnList';
    $('#oetSearchPdtPbn').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdtbrandList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtPbn').html(tResult);
            JSvPdtPbnDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Brand Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPdtPbnDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtPbn').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtbrandDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtPbn').html(tResult);
            }
            JSxPbnNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtBrand_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Brand Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPbnAdd(){
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtbrandPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaPbnBrowseType == 1) {
                $('.xCNPbnVMaster').hide();
                $('.xCNPbnVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            }else{
                $('.xCNPbnVBrowse').hide();
                $('.xCNPbnVMaster').show();
                $('#oliPbnTitleEdit').hide();
                $('#oliPbnTitleAdd').show();
                $('#odvBtnPbnInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPbn').html(tResult);
            }
            
            $('#ocbPbnAutoGenCode').change(function(){
                $("#oetPbnCode").val("");
                $("#ohdCheckDuplicatePbnCode").val("1");
                if($('#ocbPbnAutoGenCode').is(':checked')) {
                    $("#oetPbnCode").attr("readonly", true);
                    $("#oetPbnCode").attr("onfocus", "this.blur()");
                    $('#ofmAddPdtPbn').removeClass('has-error');
                    $('#ofmAddPdtPbn em').remove();
                }else{
                    $("#oetPbnCode").attr("readonly", false);
                    $("#oetPbnCode").removeAttr("onfocus");
                }
            });
            $("#oetPbnCode").blur(function(){
                if(!$('#ocbPbnAutoGenCode').is(':checked')) {
                    if($("#ohdCheckPbnClearValidate").val()==1){
                        $('#ofmAddPdtPbn').validate().destroy();
                        $("#ohdCheckPbnClearValidate").val("0");
                    }
                    if($("#ohdCheckPbnClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtBrand",
                                tFieldName : "FTPbnCode",
                                tCode : $("#oetPbnCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePbnCode").val(aResult["rtCode"]);
                                JSxValidationFormPbn("",$("#ohdPbnRoute").val());
                                $('#ofmAddPdtPbn').submit();
                                
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
function JSxValidationFormPbn(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdtbrandEventAdd"){
            if($('#ocbPbnAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicatePbnCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddPdtPbn').validate({
        rules: {
            oetPbnCode : {
                "required" :{
                // ตรวจสอบเงื่อนไข validate
                depends: function(oElement) {
                    if(ptRoute=="pdtbrandEventAdd"){
                        if($('#ocbPbnAutoGenCode').is(':checked')){
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
            oetPbnName: {
                "required" :{}
            }
        },
        messages: {
            oetPbnCode : {
                "required" :$('#oetPbnCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPbnCode').attr('data-validate-dublicateCode')
            },
            oetPbnName : {
                "required" :$('#oetPbnName').attr('data-validate-required')
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
    if($("#ohdCheckPbnClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtPbn').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult){
                if(nStaPbnBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtPbnEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtPbnAdd();
                                break;
                            case '3':
                                JSvCallPagePdtPbnList();
                                break;
                            default:
                                JSvCallPagePdtPbnEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPbnBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Product Brand Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPbnEdit(ptPbnCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtPbnEdit',ptPbnCode);
    $.ajax({
        type: "POST",
        url: "pdtbrandPageEdit",
        data: { tPbnCode: ptPbnCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliPbnTitleAdd').hide();
                $('#oliPbnTitleEdit').show();
                $('#odvBtnPbnInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPbn').html(tResult);
                $('#oetPbnCode').addClass('xCNDisable');
                $('#oetPbnCode').attr('readonly', true);
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
function JSxSetStatusClickPbnSubmit(){
    $("#ohdCheckPbnClearValidate").val("1");
}


//Functionality : Event Add/Edit Product Brand
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit Product Brand
//Return Type : object
function JSoAddEditPdtPbn(ptRoute){
    if($("#ohdCheckPbnClearValidate").val()==1){
        $('#ofmAddPdtPbn').validate().destroy();
        if(!$('#ocbPbnAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtBrand",
                    tFieldName : "FTPbnCode",
                    tCode : $("#oetPbnCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePbnCode").val(aResult["rtCode"]);
                    JSxValidationFormPbn("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtPbn').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormPbn("JSxSubmitEventByButton",ptRoute);
        }
        
    }
}

//Functionality : Generate Code Product Brand
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtPbnCode(){
    $('#oetPbnCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtBrand';
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
                $('#oetPbnCode').val(tData.rtPbnCode);
                $('#oetPbnCode').addClass('xCNDisable');
                $('#oetPbnCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPbnName').focus();
            } else {
                $('#oetPbnCode').val(tData.rtDesc);
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
function JSoPdtPbnDel(pnPage,ptName,tIDCode,tYesOnNo){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtPbn').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtbrandEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);

                        // $('#odvModalDelPdtPbn').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtPbnDataTable(pnPage);
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelPdtPbn').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(aReturn["nNumRowPbn"]!=0){
                                    if(aReturn["nNumRowPbn"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowPbn"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvPdtPbnDataTable(pnPage);
                                        }else{
                                            JSvPdtPbnDataTable(nNumPage);
                                        }
                                    }else{
                                        JSvPdtPbnDataTable(1);
                                    }
                                }else{
                                    JSvPdtPbnDataTable(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);                        
                        }
                        JSxPbnNavDefult();
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
       
    //     $('#odvModalDelPdtPbn').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtbrandEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtPbn').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtPbnDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxPbnNavDefult();
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
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoPdtPbnDelChoose(pnPage){
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
            url: "pdtbrandEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxPbnNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtPbn').modal('hide');
                //     JSvPdtPbnDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtPbn').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPbn"]!=0){
                            if(aReturn["nNumRowPbn"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPbn"]/10);
                                if(pnPage<=nNumPage){
                                    JSvPdtPbnDataTable(pnPage);
                                }else{
                                    JSvPdtPbnDataTable(nNumPage);
                                }
                            }else{
                                JSvPdtPbnDataTable(1);
                            }
                        }else{
                            JSvPdtPbnDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);                        
                }
                JSxPbnNavDefult();

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
    //         url: "pdtbrandEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtPbn').modal('hide');
    //                     JSvCallPagePdtPbnList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPbnNavDefult();
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
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvPdtPbnClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtPbn .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtPbn .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtPbnDataTable(nPageCurrent);
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
