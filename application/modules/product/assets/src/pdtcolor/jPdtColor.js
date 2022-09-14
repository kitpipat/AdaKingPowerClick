var nStaClrBrowseType   = $('#oetClrStaBrowse').val();
var tCallClrBackOption  = $('#oetClrCallBackOption').val();
// alert(nStaClrBrowseType+'//'+tCallClrBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxClrNavDefult();
    if(nStaClrBrowseType != 1){
        JSvCallPagePdtClrList();
    }else{
        JSvCallPagePdtClrAdd();
    }
});

//function : Function Clear Defult Button Product Color
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxClrNavDefult(){
    if(nStaClrBrowseType != 1 || nStaClrBrowseType == undefined){
        $('.xCNClrVBrowse').hide();
        $('.xCNClrVMaster').show();
        $('.xCNChoose').hide();
        $('#oliClrTitleAdd').hide();
        $('#oliClrTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnClrInfo').show();
    }else{
        $('#odvModalBody .xCNClrVMaster').hide();
        $('#odvModalBody .xCNClrVBrowse').show();
        $('#odvModalBody #odvClrMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliClrNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvClrBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNClrBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNClrBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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

//function : Call Product Color Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtClrList(){
    localStorage.tStaPageNow = 'JSvCallPagePdtClrList';
    $('#oetSearchPdtClr').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdtcolorList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtClr').html(tResult);
            JSvPdtClrDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Color Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPdtClrDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtClr').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtcolorDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtClr').html(tResult);
            }
            JSxClrNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtColor_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Color Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtClrAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtcolorPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaClrBrowseType == 1) {
                $('.xCNClrVMaster').hide();
                $('.xCNClrVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
            }else{
                $('.xCNClrVBrowse').hide();
                $('.xCNClrVMaster').show();
                $('#oliClrTitleEdit').hide();
                $('#oliClrTitleAdd').show();
                $('#odvBtnClrInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtClr').html(tResult);
            $('#ocbClrAutoGenCode').change(function(){
                $("#oetClrCode").val("");
                $("#ohdCheckDuplicateClrCode").val("1");
                if($('#ocbClrAutoGenCode').is(':checked')) {
                    $("#oetClrCode").attr("readonly", true);
                    $("#oetClrCode").attr("onfocus", "this.blur()");
                    $('#ofmAddPdtClr').removeClass('has-error');
                    $('#ofmAddPdtClr em').remove();
                }else{
                    $("#oetClrCode").attr("readonly", false);
                    $("#oetClrCode").removeAttr("onfocus");
                }
            });
            $("#oetClrCode").blur(function(){
                if(!$('#ocbClrAutoGenCode').is(':checked')) {
                    if($("#ohdCheckClrClearValidate").val()==1){
                        $('#ofmAddPdtClr').validate().destroy();
                        $("#ohdCheckClrClearValidate").val("0");
                    }
                    if($("#ohdCheckClrClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtColor",
                                tFieldName : "FTClrCode",
                                tCode : $("#oetClrCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicateClrCode").val(aResult["rtCode"]);
                                JSxValidationFormClr("",$("#ohdClrRoute").val());
                                $('#ofmAddPdtClr').submit();
                                
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
function JSxValidationFormClr(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdtcolorEventAdd"){
            if($('#ocbClrAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicateClrCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddPdtClr').validate({
        rules: {
            oetClrCode : {
                "required" :{
                // ตรวจสอบเงื่อนไข validate
                depends: function(oElement) {
                    if(ptRoute=="pdtcolorEventAdd"){
                        if($('#ocbClrAutoGenCode').is(':checked')){
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
            oetClrName: {
                "required" :{}
            }
        },
        messages: {
            oetClrCode : {
                "required" :$('#oetClrCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetClrCode').attr('data-validate-dublicateCode')
            },
            oetClrName : {
                "required" :$('#oetClrName').attr('data-validate-required')
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
    if($("#ohdCheckClrClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtClr').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult){
                if(nStaClrBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtClrEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtClrAdd();
                                break;
                            case '3':
                                JSvCallPagePdtClrList();
                                break;
                            default:
                                JSvCallPagePdtClrEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallClrBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}


//Functionality : Call Product Color Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtClrEdit(ptClrCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtClrEdit',ptClrCode);
    $.ajax({
        type: "POST",
        url: "pdtcolorPageEdit",
        data: { tClrCode: ptClrCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliClrTitleAdd').hide();
                $('#oliClrTitleEdit').show();
                $('#odvBtnClrInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtClr').html(tResult);
                $('#oetClrCode').addClass('xCNDisable');
                $('#oetClrCode').attr('readonly', true);
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
function JSxSetStatusClickClrSubmit(){
    $("#ohdCheckClrClearValidate").val("1");
}

//Functionality : Event Add/Edit Product Color
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit Product Color
//Return Type : object
function JSoAddEditPdtClr(ptRoute){
    if($("#ohdCheckClrClearValidate").val()==1){
        $('#ofmAddPdtClr').validate().destroy();
        if(!$('#ocbClrAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtColor",
                    tFieldName : "FTClrCode",
                    tCode : $("#oetClrCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateClrCode").val(aResult["rtCode"]);
                    JSxValidationFormClr("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtClr').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormClr("JSxSubmitEventByButton",ptRoute);
        }
        
    }
}

//Functionality : Generate Code Product Color
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtClrCode(){
    $('#oetClrCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtColor';
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
                $('#oetClrCode').val(tData.rtClrCode);
                $('#oetClrCode').addClass('xCNDisable');
                $('#oetClrCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetClrName').focus();
            } else {
                $('#oetClrCode').val(tData.rtDesc);
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
function JSoPdtClrDel(pnPage,ptName,tIDCode,tYesOnNo){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtClr').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtcolorEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);

                        // $('#odvModalDelPdtClr').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtClrDataTable(pnPage);
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelPdtClr').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(aReturn["nNumRowPdtClr"]!=0){
                                    if(aReturn["nNumRowPdtClr"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowPdtClr"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvPdtClrDataTable(pnPage);
                                        }else{
                                            JSvPdtClrDataTable(nNumPage);
                                        }
                                    }else{
                                        JSvPdtClrDataTable(1);
                                    }
                                }else{
                                    JSvPdtClrDataTable(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);                        
                        }
                        JSxClrNavDefult();

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
       
    //     $('#odvModalDelPdtClr').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtcolorEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtClr').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtClrDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxClrNavDefult();
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
function JSoPdtClrDelChoose(pnPage){
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
            url: "pdtcolorEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxClrNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtClr').modal('hide');
                //     JSvPdtClrDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);
                var aReturn = $.parseJSON(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtClr').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPdtClr"]!=0){
                            if(aReturn["nNumRowPdtClr"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPdtClr"]/10);
                                if(pnPage<=nNumPage){
                                    JSvPdtClrDataTable(pnPage);
                                }else{
                                    JSvPdtClrDataTable(nNumPage);
                                }
                            }else{
                                JSvPdtClrDataTable(1);
                            }
                        }else{
                            JSvPdtClrDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);                        
                }
                JSxClrNavDefult();

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
    //         url: "pdtcolorEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtClr').modal('hide');
    //                     JSvCallPagePdtClrList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxClrNavDefult();
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
function JSvPdtClrClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtClr .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtClr .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtClrDataTable(nPageCurrent);
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
