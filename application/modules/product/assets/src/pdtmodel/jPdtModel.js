var nStaPmoBrowseType   = $('#oetPmoStaBrowse').val();
var tCallPmoBackOption  = $('#oetPmoCallBackOption').val();
// alert(nStaPmoBrowseType+'//'+tCallPmoBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPmoNavDefult();
    if(nStaPmoBrowseType != 1){
        JSvCallPagePdtPmoList();
    }else{
        JSvCallPagePdtPmoAdd();
    }
});

//function : Function Clear Defult Button Product Model
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPmoNavDefult(){
    if(nStaPmoBrowseType != 1 || nStaPmoBrowseType == undefined){
        $('.xCNPmoVBrowse').hide();
        $('.xCNPmoVMaster').show();
        $('.xCNChoose').hide();
        $('#oliPmoTitleAdd').hide();
        $('#oliPmoTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnPmoInfo').show();
    }else{
        $('#odvModalBody .xCNPmoVMaster').hide();
        $('#odvModalBody .xCNPmoVBrowse').show();
        $('#odvModalBody #odvPmoMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPmoNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPmoBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPmoBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPmoBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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

//function : Call Product Model Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPmoList(){
    localStorage.tStaPageNow = 'JSvCallPagePdtPmoList';
    $('#oetSearchPdtPmo').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdtmodelList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtPmo').html(tResult);
            JSvPdtPmoDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Model Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPdtPmoDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtPmo').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtmodelDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtPmo').html(tResult);
            }
            JSxPmoNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtModel_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Model Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPmoAdd(){
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtmodelPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaPmoBrowseType == 1) {
                $('.xCNPmoVMaster').hide();
                $('.xCNPmoVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            }else{
                $('.xCNPmoVBrowse').hide();
                $('.xCNPmoVMaster').show();
                $('#oliPmoTitleEdit').hide();
                $('#oliPmoTitleAdd').show();
                $('#odvBtnPmoInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPmo').html(tResult);
            }
            
            $('#ocbPmoAutoGenCode').change(function(){
                $("#oetPmoCode").val("");
                $("#ohdCheckDuplicatePmoCode").val("1");
                if($('#ocbPmoAutoGenCode').is(':checked')) {
                    $("#oetPmoCode").attr("readonly", true);
                    $("#oetPmoCode").attr("onfocus", "this.blur()");
                    $('#ofmAddPdtPmo').removeClass('has-error');
                    $('#ofmAddPdtPmo em').remove();
                }else{
                    $("#oetPmoCode").attr("readonly", false);
                    $("#oetPmoCode").removeAttr("onfocus");
                }
            });
            $("#oetPmoCode").blur(function(){
                if(!$('#ocbPmoAutoGenCode').is(':checked')) {
                    if($("#ohdCheckPmoClearValidate").val()==1){
                        $('#ofmAddPdtPmo').validate().destroy();
                        $("#ohdCheckPmoClearValidate").val("0");
                    }
                    if($("#ohdCheckPmoClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtModel",
                                tFieldName : "FTPmoCode",
                                tCode : $("#oetPmoCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePmoCode").val(aResult["rtCode"]);
                                JSxValidationFormPmo("",$("#ohdPmoRoute").val());
                                $('#ofmAddPdtPmo').submit();
                                
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
function JSxValidationFormPmo(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdtmodelEventAdd"){
            if($('#ocbPmoAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicatePmoCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddPdtPmo').validate({
        rules: {
            oetPmoCode : {
                "required" :{
                // ตรวจสอบเงื่อนไข validate
                depends: function(oElement) {
                    if(ptRoute=="pdtmodelEventAdd"){
                        if($('#ocbPmoAutoGenCode').is(':checked')){
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
            oetPmoName: {
                "required" :{}
            }
        },
        messages: {
            oetPmoCode : {
                "required" :$('#oetPmoCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPmoCode').attr('data-validate-dublicateCode')
            },
            oetPmoName : {
                "required" :$('#oetPmoName').attr('data-validate-required')
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
    if($("#ohdCheckPmoClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtPmo').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult){
                if(nStaPmoBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtPmoEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtPmoAdd();
                                break;
                            case '3':
                                JSvCallPagePdtPmoList();
                                break;
                            default:
                                JSvCallPagePdtPmoEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPmoBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}


//Functionality : Call Product Model Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPmoEdit(ptPmoCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtPmoEdit',ptPmoCode);
    $.ajax({
        type: "POST",
        url: "pdtmodelPageEdit",
        data: { tPmoCode: ptPmoCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliPmoTitleAdd').hide();
                $('#oliPmoTitleEdit').show();
                $('#odvBtnPmoInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPmo').html(tResult);
                $('#oetPmoCode').addClass('xCNDisable');
                $('#oetPmoCode').attr('readonly', true);
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
function JSxSetStatusClickPmoSubmit(){
    $("#ohdCheckPmoClearValidate").val("1");
}

//Functionality : Event Add/Edit Product Model
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit Product Model
//Return Type : object
function JSoAddEditPdtPmo(ptRoute){
    if($("#ohdCheckPmoClearValidate").val()==1){
        $('#ofmAddPdtPmo').validate().destroy();
        if(!$('#ocbPmoAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtModel",
                    tFieldName : "FTPmoCode",
                    tCode : $("#oetPmoCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePmoCode").val(aResult["rtCode"]);
                    JSxValidationFormPmo("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtPmo').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormPmo("JSxSubmitEventByButton",ptRoute);
        }
        
    }
}

//Functionality : Generate Code Product Model
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtPmoCode(){
    $('#oetPmoCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtModel';
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
                $('#oetPmoCode').val(tData.rtPmoCode);
                $('#oetPmoCode').addClass('xCNDisable');
                $('#oetPmoCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPmoName').focus();
            } else {
                $('#oetPmoCode').val(tData.rtDesc);
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
function JSoPdtPmoDel(pnPage,ptName,tIDCode,tYesOnNo){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtPmo').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtmodelEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);

                        // $('#odvModalDelPdtPmo').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtPmoDataTable(pnPage);
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelPdtPmo').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(aReturn["nNumRowPmo"]!=0){
                                    if(aReturn["nNumRowPmo"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowPmo"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvPdtPmoDataTable(pnPage);
                                        }else{
                                            JSvPdtPmoDataTable(nNumPage);
                                        }
                                    }else{
                                        JSvPdtPmoDataTable(1);
                                    }
                                }else{
                                    JSvPdtPmoDataTable(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);                        
                        }
                        JSxPmoNavDefult();
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
       
    //     $('#odvModalDelPdtPmo').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtmodelEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtPmo').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtPmoDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxPmoNavDefult();
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
function JSoPdtPmoDelChoose(pnPage){
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
            url: "pdtmodelEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxPmoNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtPmo').modal('hide');
                //     JSvPdtPmoDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);
                var aReturn = $.parseJSON(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtPmo').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPmo"]!=0){
                            if(aReturn["nNumRowPmo"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPmo"]/10);
                                if(pnPage<=nNumPage){
                                    JSvPdtPmoDataTable(pnPage);
                                }else{
                                    JSvPdtPmoDataTable(nNumPage);
                                }
                            }else{
                                JSvPdtPmoDataTable(1);
                            }
                        }else{
                            JSvPdtPmoDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);                        
                }
                JSxPmoNavDefult();

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
    //         url: "pdtmodelEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtPmo').modal('hide');
    //                     JSvCallPagePdtPmoList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPmoNavDefult();
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
function JSvPdtPmoClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtPmo .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtPmo .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtPmoDataTable(nPageCurrent);
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
