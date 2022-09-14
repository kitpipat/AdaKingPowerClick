var nStaPmgBrowseType   = $('#oetPmgStaBrowse').val();
var tCallPmgBackOption  = $('#oetPmgCallBackOption').val();
// alert(nStaPmgBrowseType+'//'+tCallPmgBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPmgNavDefult();
    if(nStaPmgBrowseType != 1){
        JSvCallPagePdtPmgGrpList(1);
    }else{
        JSvCallPagePdtPmgGrpAdd();
    }
});

//function : Function Clear Defult Button Promotion Group
//Parameters : Document Ready
//Creator : 10/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxPmgNavDefult(){
    if(nStaPmgBrowseType != 1 || nStaPmgBrowseType == undefined){
        $('.obtChoose').hide();
        $('#odvPmgMainMenu #oliPmgTitleAdd').hide();
        $('#odvPmgMainMenu #oliPmgTitleEdit').hide();
        $('#odvPmgMainMenu #odvBtnAddEdit').hide();
        $('#odvPmgMainMenu #odvBtnPmgInfo').show();
    }else{
        $('#odvModalBody #odvPmgMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPmgNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPmgBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPmgBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPmgBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 10/10/2018 witsarut
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

//function : Call Promotion Group Page list  
//Parameters : Document Redy And Event Button
//Creator :	10/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPmgGrpList(pnPage){
    localStorage.tStaPageNow = 'JSvCallPagePdtPmgGrpList';
    $('#oetSearchPdtPmgGrp').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "pdtpromotionList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtPmgGrp').html(tResult);
            JSvPdtPmgGrpDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Promotion Group Data List
//Parameters: Ajax Success Event 
//Creator:	10/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPdtPmgGrpDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtPmgGrp').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "pdtpromotionDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtPmgGrp').html(tResult);
            }
            JSxPmgNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtPmtGrp_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Promotion Group Page Add  
//Parameters : Event Button Click
//Creator : 10/10/2018 witsarut
//Update : 28/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPagePdtPmgGrpAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtpromotionPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaPmgBrowseType == 1) {
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                $('#odvModalBodyBrowse').html(tResult);
            }else{
                $('#odvPmgMainMenu #oliPmgTitleEdit').hide();
                $('#odvPmgMainMenu #odvBtnPmgInfo').hide();
                $('#odvPmgMainMenu #oliPmgTitleAdd').show();
                $('#odvPmgMainMenu #odvBtnAddEdit').show();
                $('#odvContentPagePdtPmgGrp').html(tResult);
            }

            $('#ocbPmtAutoGenCode').change(function(){
                $("#oetPmtCode").val("");
                if($('#ocbPmtAutoGenCode').is(':checked')) {
                    $("#oetPmtCode").attr("readonly", true);
                    $("#oetPmtCode").attr("onfocus", "this.blur()");
                    $('#odvPmtCodeForm').removeClass('has-error');
                    $('#odvPmtCodeForm em').remove();
                }else{
                    $("#oetPmtCode").attr("readonly", false);
                    $("#oetPmtCode").removeAttr("onfocus");
                }
            });
            $("#oetPmtCode").blur(function(){
                if(!$('#ocbPmtAutoGenCode').is(':checked')) {
                    if($("#ohdCheckPmtClearValidate").val()==1){
                        $('#ofmAddPdtPmtGrp').validate().destroy();
                        $("#ohdCheckPmtClearValidate").val("0");
                    }
                    if($("#ohdCheckPmtClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtPmtGrp",
                                tFieldName : "FTPmgCode",
                                tCode : $("#oetPmtCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePmtCode").val(aResult["rtCode"]);
                                JSxValidationFormPdtPromotion("",$("#ohdPdtPromotionRoute").val());
                                $('#ofmAddPdtPmtGrp').submit();
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
function JSxValidationFormPdtPromotion(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdtpromotionEventAdd"){
            if($('#ocbPmtAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicatePmtCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddPdtPmtGrp').validate({
        rules: {
            oetPmtCode : {
                "required" :{
                  // ตรวจสอบเงื่อนไข validate
                  depends: function(oElement) {
                    if(ptRoute=="pdtpromotionEventAdd"){
                        if($('#ocbPmtAutoGenCode').is(':checked')){
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
            oetPmtName: {
                "required" :{}
            }
        },
        messages: {
            oetPmtCode : {
                "required" :$('#oetPmtCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPmtCode').attr('data-validate-dublicateCode')
            },
            oetPmtName : {
                "required" :$('#oetPmtName').attr('data-validate-required')
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
    if($("#ohdCheckPmtClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtPmtGrp').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult){
                if(nStaPmgBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtPmgGrpEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtPmgGrpAdd();
                                break;
                            case '3':
                                JSvCallPagePdtPmgGrpList(1);
                                break;
                            default:
                                JSvCallPagePdtPmgGrpEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallPmgBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Promotion Group Page Edit  
//Parameters : Event Button Click 
//Creator : 10/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePdtPmgGrpEdit(ptPmgCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtPmgGrpEdit',ptPmgCode);
    $.ajax({
        type: "POST",
        url: "pdtpromotionPageEdit",
        data: { tPmgCode: ptPmgCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliPmgTitleAdd').hide();
                $('#oliPmgTitleEdit').show();
                $('#odvBtnPmgInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtPmgGrp').html(tResult);
                $('#oetPmtCode').addClass('xCNDisable');
                $('#oetPmtCode').attr('readonly', true);
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
function JSxSetStatusClickPdtPmtGrpSubmit(){
    $("#ohdCheckPmtClearValidate").val("1");
}

//Functionality : Event Add/Edit Promotion Group
//Parameters : From Submit
//Creator : 10/10/2018 witsarut
//Update : 28/03/2019 pap
//Return : Status Event Add/Edit Promotion Group
//Return Type : object
function JSoAddEditPdtPmgGrp(ptRoute){
    if($("#ohdCheckPmtClearValidate").val()==1){
        $('#ofmAddPdtPmtGrp').validate().destroy();
        if(!$('#ocbPmtAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtPmtGrp",
                    tFieldName : "FTPmgCode",
                    tCode : $("#oetPmtCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePmtCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtPromotion("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtPmtGrp').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormPdtPromotion("JSxSubmitEventByButton",ptRoute);
        }
    }
}

//Functionality : Generate Code Promotion Group
//Parameters : Event Button Click
//Creator : 10/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtPmgGrpCode(){
    $('#oetPmtCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtPmtGrp';
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
                $('#oetPmtCode').val(tData.rtPmgCode);
                $('#oetPmtCode').addClass('xCNDisable');
                $('#oetPmtCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetPmtCode').focus();
            } else {
                $('#oetPmtCode').val(tData.rtDesc);
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
//Creator : 10/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoPdtPmgGrpDel(pnPage,ptName,tIDCode){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtPmgGrp').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtpromotionEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        // $('#odvModalDelPdtPmgGrp').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtPmgGrpDataTable(pnPage);

                        if (tData['nStaEvent'] == '1'){
                            $('#odvModalDelPdtPmgGrp').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(tData["nNumRowPdtPmg"]!=0){
                                    if(tData["nNumRowPdtPmg"]>10){
                                        nNumPage = Math.ceil(tData["nNumRowPdtPmg"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPagePdtPmgGrpList(pnPage);
                                        }else{
                                            JSvCallPagePdtPmgGrpList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPagePdtPmgGrpList(1);
                                    }
                                }else{
                                    JSvCallPagePdtPmgGrpList(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(tData['tStaMessg']);                        
                        }
                        JSxPmgNavDefult();

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
       
    //     $('#odvModalDelPdtPmgGrp').modal('show');
    //     $('#ospConfirmDelete').html('ยืนยันการลบข้อมูล หมายเลข : ' + tIDCode);
    //     $('#osmConfirm').on('click', function(evt){
    //         JCNxOpenLoading();
    //         $.ajax({
    //             type: "POST",
    //             url: "pdtpromotionEventDelete",
    //             data: { 'tIDCode': tIDCode },
    //             cache: false,
    //             timeout: 0,
    //             success: function(oResult){
    //                 var aReturn = JSON.parse(oResult);
    //                 if (aReturn['nStaEvent'] == 1){
    //                     $('#odvModalDelPdtPmgGrp').modal('hide');
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     setTimeout(function() {
    //                         JSvPdtPmgGrpDataTable();
    //                     }, 500);
    //                 }else{
    //                     alert(aReturn['tStaMessg']);                        
    //                 }
    //                 JSxPmgNavDefult();
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
//Creator: 10/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoPdtPmgGrpDelChoose(pnPage){

    JCNxOpenLoading();
    var tCurrentPage = $("#nCurrentPageTB").val();
    var aData = $('#ohdConfirmIDDelete').val();
    //console.log('DATA : ' + aData);

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
            url: "pdtpromotionEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxPmgNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtPmgGrp').modal('hide');
                //     JSvPdtPmgGrpDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);

                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtPmgGrp').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPdtPmg"]!=0){
                            if(aReturn["nNumRowPdtPmg"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPdtPmg"]/10);
                                if(tCurrentPage<=nNumPage){
                                    JSvCallPagePdtPmgGrpList(tCurrentPage);
                                }else{
                                    JSvCallPagePdtPmgGrpList(nNumPage);
                                }
                            }else{
                                JSvCallPagePdtPmgGrpList(1);
                            }
                        }else{
                            JSvCallPagePdtPmgGrpList(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);                        
                }
                JSxPmgNavDefult();

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
    //         url: "pdtpromotionEventDelete",
    //         data: { 'tIDCode': aNewIdDelete },
    //         cache: false,
    //         timeout: 0,
    //         success: function(oResult) {
    //             var aReturn = JSON.parse(oResult);
    //             if (aReturn['nStaEvent'] == 1) {
    //                 setTimeout(function() {
    //                     $('#odvModalDelPdtPmgGrp').modal('hide');
    //                     JSvCallPagePdtPmgGrpList();
    //                     $('#ospConfirmDelete').text('ยืนยันการลบข้อมูลของ : ');
    //                     $('#ospConfirmIDDelete').val('');
    //                     localStorage.removeItem('LocalItemData');
    //                     $('.modal-backdrop').remove();
    //                 },1000);
    //             }else{
    //                 alert(aReturn['tStaMessg']);
    //             }
    //             JSxPmgNavDefult();
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
//Creator : 10/10/2018 witsarut
//Return : View
//Return Type : View
function JSvPdtPmgGrpClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtPmgGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtPmgGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtPmgGrpDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 10/10/2018 witsarut
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
//Creator: 10/10/2018 witsarut
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
//Creator: 10/10/2018 witsarut
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
