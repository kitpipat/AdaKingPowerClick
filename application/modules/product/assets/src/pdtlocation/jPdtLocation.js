var nStaLocBrowseType   = $('#oetLocStaBrowse').val();
var tCallLocBackOption  = $('#oetLocCallBackOption').val();

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxLocNavDefult();
    if(nStaLocBrowseType != 1){
        JSvCallPagePdtLocList(1);
    }else{
        JSvCallPagePdtLocAdd();
    }
});

//function : Function Clear Defult Button Product Size
//Parameters : Document Ready
//Creator : 01/02/2019 Napat(Jame)
//Return : Show Tab Menu
//Return Type : -
function JSxLocNavDefult(){
    if(nStaLocBrowseType != 1 || nStaLocBrowseType == undefined){
        $('.xCNLocVBrowse').hide();
        $('.xCNLocVMaster').show();
        $('.xCNChoose').hide();
        $('#oliLocTitleAdd').hide();
        $('#oliLocTitleManage').hide();
        $('#oliLocTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnLocInfo').show();
    }else{
        $('#odvModalBody .xCNLocVMaster').hide();
        $('#odvModalBody .xCNLocVBrowse').show();
        $('#odvModalBody #odvLocMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliLocNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvLocBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNLocBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNLocBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 01/02/2019 Napat(Jame)
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

//function : Call Product Size Page list  
//Parameters : Document Redy And Event Button
//Creator :	01/02/2019 Napat(Jame)
//Update :	01/04/2019 Pap
//Return : View
//Return Type : View
function JSvCallPagePdtLocList(pnPage){
    localStorage.tStaPageNow = 'JSvCallPagePdtLocList';
    $('#oetSearchPdtLoc').val('');
   
    $.ajax({
        type: "POST",
        url: "pdtlocationList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPagePdtLoc').html(tResult);
            JSvPdtLocDataTable(pnPage);
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Product Size Data List
//Parameters: Ajax Success Event 
//Creator:	01/02/2019 Napat(Jame)
//Return: View
//Return Type: View
function JSvPdtLocDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtLoc').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtlocationDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPdtLoc').html(tResult);
            }
            JSxLocNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtLoc_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Size Page Add  
//Parameters : Event Button Click
//Creator : 01/02/2019 Napat(Jame)
//Updatae : 26/03/2019 pap
//Return : View
//Return Type : View
function JSvCallPagePdtLocAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');
    $.ajax({
        type: "POST",
        url: "pdtlocationPageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaLocBrowseType == 1) {
                $('.xCNLocVMaster').hide();
                $('.xCNLocVBrowse').show();
            }else{
                $('.xCNLocVBrowse').hide();
                $('.xCNLocVMaster').show();
                $('#oliLocTitleEdit').hide();
                $('#oliLocTitleManage').hide();
                $('#oliLocTitleAdd').show();
                $('#odvBtnLocInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPagePdtLoc').html(tResult);
            $('#ocbPlcAutoGenCode').change(function(){
                $("#oetPlcCode").val("");
                if($('#ocbPlcAutoGenCode').is(':checked')) {
                    $("#oetPlcCode").attr("readonly", true);
                    $("#oetPlcCode").attr("onfocus", "this.blur()");
                    $('#odvPlcCodeForm').removeClass('has-error');
                    $('#odvPlcCodeForm em').remove();
                }else{
                    $("#oetPlcCode").attr("readonly", false);
                    $("#oetPlcCode").removeAttr("onfocus");
                }
            });
            $("#oetPlcCode").blur(function(){
                if(!$('#ocbPlcAutoGenCode').is(':checked')) {
                    if($("#ohdCheckPlcClearValidate").val()==1){
                        $('#ofmAddPdtLoc').validate().destroy();
                        $("#ohdCheckPlcClearValidate").val("0");
                    }
                    if($("#ohdCheckPlcClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: { 
                                tTableName : "TCNMPdtLoc",
                                tFieldName : "FTPlcCode",
                                tCode : $("#oetPlcCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult);
                                $("#ohdCheckDuplicatePlcCode").val(aResult["rtCode"]);
                                JSxValidationFormPdtLocation("",$("#ohdPdtLocationRoute").val());
                                $('#ofmAddPdtLoc').submit();
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
function JSxValidationFormPdtLocation(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="pdtlocationEventAdd"){
            if($('#ocbPlcAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicatePlcCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddPdtLoc').validate({
        rules: {
            oetPlcCode : {
                "required" :{
                  // ตรวจสอบเงื่อนไข validate
                  depends: function(oElement) {
                    if(ptRoute=="pdtlocationEventAdd"){
                        if($('#ocbPlcAutoGenCode').is(':checked')){
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
            oetPlcName: {
                "required" :{}
            }
        },
        messages: {
            oetPlcCode : {
                "required" :$('#oetPlcCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPlcCode').attr('data-validate-dublicateCode')
            },
            oetPlcName : {
                "required" :$('#oetPlcName').attr('data-validate-required')
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
    if($("#ohdCheckPlcClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddPdtLoc').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult){
                if(nStaLocBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPagePdtLocEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPagePdtLocAdd();
                                break;
                            case '3':
                                JSvCallPagePdtLocList(1);
                                break;
                            default:
                                JSvCallPagePdtLocEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallLocBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

function JSoAddEditLocSeq(ptRoute){
    // console.log($('#ofmAddLocSeq').serializeArray());
    $.ajax({
        type: "POST",
        url: ptRoute,
        data: $('#ofmAddLocSeq').serialize(),
        cache: false,
        timeout: 0,
        success: function(tResult) {
            // console.log(tResult);
            var aReturn = JSON.parse(tResult);
            JSvCallPagePdtLocManage(aReturn['tCodeReturn']);
            // if (nStaPmtBrowseType != 1) {
            //     var aReturn = JSON.parse(tResult);
            //     if (aReturn['nStaEvent'] == 1) {
            //         if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
            //             JSvCallPagePdtLocManage(aReturn['tCodeReturn'])
            //         } else if (aReturn['nStaCallBack'] == '2') {
            //             JSvPdtLocDataTable();
            //         } else if (aReturn['nStaCallBack'] == '3') {
            //             JSvPdtLocDataTable();
            //         }
            //     } else {
            //         alert(aReturn['tStaMessg']);
            //     }
            // } else {
            //     JCNxBrowseData(tCallPmtBackOption);
            // }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Product Location Page Edit  
//Parameters : Event Button Click 
//Creator : 01/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvCallPagePdtLocEdit(ptPlcCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtLocEdit',ptPlcCode);
    $.ajax({
        type: "POST",
        url: "pdtlocationPageEdit",
        data: { tPlcCode: ptPlcCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliLocTitleAdd').hide();
                $('#oliLocTitleManage').hide();
                $('#oliLocTitleEdit').show();
                $('#odvBtnLocInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtLoc').html(tResult);
                $('#oetPlcCode').addClass('xCNDisable');
                $('#oetPlcCode').attr('readonly', true);
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

function JSvCallPageManage(ptPlcCode){
    var aReturn = JSON.parse(ptPlcCode);
    JSvCallPagePdtLocManage(aReturn[0]);
}

//Functionality : Call Product Location Page Manage  
//Parameters : Event Button Click 
//Creator : 06/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvCallPagePdtLocManage(ptPlcCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePdtLocManage',ptPlcCode);
    $.ajax({
        type: "POST",
        url: "pdtlocationPageManage",
        data: { tPlcCode: ptPlcCode },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliLocTitleManage').show();
                $('#oliLocTitleAdd').hide();
                $('#oliLocTitleEdit').hide();
                $('#odvBtnLocInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPagePdtLoc').html(tResult);
                $('#btnBrowseProductType').attr('disabled',true);
                JSvPdtLocSeqDataTable();
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
function JSxSetStatusClickPdtUnitSubmit(){
    $("#ohdCheckPlcClearValidate").val("1");
}

//Functionality : Event Add/Edit Product Size
//Parameters : From Submit
//Creator : 01/02/2019 Napat(Jame)
//Updatae : 29/03/2019 pap
//Return : Status Event Add/Edit Product Size
//Return Type : object
function JSoAddEditPdtLoc(ptRoute){
    if($("#ohdCheckPlcClearValidate").val()==1){
        $('#ofmAddPdtLoc').validate().destroy();
        if(!$('#ocbPlcAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMPdtLoc",
                    tFieldName : "FTPlcCode",
                    tCode : $("#oetPlcCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePlcCode").val(aResult["rtCode"]);
                    JSxValidationFormPdtLocation("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddPdtLoc').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormPdtLocation("JSxSubmitEventByButton",ptRoute);
        }
        
    }
}

//Functionality : Generate Code Product Size
//Parameters : Event Button Click
//Creator : 01/02/2019 Napat(Jame)
//Return : Event Push Value In Input
//Return Type : -
function JStGeneratePdtLocCode(){
    $('#oetPlcCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMPdtLoc';
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
                $('#oetPlcCode').val(tData.rtPlcCode);
                $('#oetPlcCode').addClass('xCNDisable');
                $('#oetPlcCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //Add Attr disalbed to Button Gen Code
                $('#oetPlcName').focus();
            } else {
                $('#oetPlcCode').val(tData.rtDesc);
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
//Creator : 04/02/2019 Napat(Jame)
//Update : 01/04/2019 Pap
//Return : object Status Delete
//Return Type : object
function JSoPdtLocDel(pnPage,ptName,tIDCode){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtLoc').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + tIDCode + '(' + ptName + ') ' + $('#oetTextComfirmDeleteYesOrNot').val());
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtlocationEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);
                        // alert(tData['nStaEvent']);
                        // $('#odvModalDelPdtLoc').modal('hide');
                        // $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        // $('#ohdConfirmIDDelete').val('');
                        // localStorage.removeItem('LocalItemData');
                        // $('.modal-backdrop').remove();
                        // JSvPdtLocDataTable(pnPage);
                        if (tData['nStaEvent'] == '1'){
                            $('#odvModalDelPdtLoc').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(tData["nNumRowPdtLoc"]!=0){
                                    if(tData["nNumRowPdtLoc"]>10){
                                        nNumPage = Math.ceil(tData["nNumRowPdtLoc"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPagePdtLocList(pnPage);
                                        }else{
                                            JSvCallPagePdtLocList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPagePdtLocList(1);
                                    }
                                }else{
                                    JSvCallPagePdtLocList(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(tData['tStaMessg']);                        
                        }
                        JSxLocNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 04/02/2019 Napat(Jame)
//Update: 01/04/2019 Pap
//Return:  object Status Delete
//Return Type: object
function JSoPdtLocDelChoose(pnPage){
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
            url: "pdtlocationEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                
                // JSxLocNavDefult();
                // setTimeout(function() {
                //     $('#odvModalDelPdtLoc').modal('hide');
                //     JSvPdtLocDataTable(pnPage);
                //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                //     $('#ohdConfirmIDDelete').val('');
                //     localStorage.removeItem('LocalItemData');
                //     $('.obtChoose').hide();
                //     $('.modal-backdrop').remove();
                // }, 1000);
                

                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelPdtLoc').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ohdConfirmIDDelete').val('');
                    $('#ospConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowPdtLoc"]!=0){
                            if(aReturn["nNumRowPdtLoc"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowPdtLoc"]/10);
                                if(tCurrentPage<=nNumPage){
                                    JSvCallPagePdtLocList(tCurrentPage);
                                }else{
                                    JSvCallPagePdtLocList(nNumPage);
                                }
                            }else{
                                JSvCallPagePdtLocList(1);
                            }
                        }else{
                            JSvCallPagePdtLocList(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(tData['tStaMessg']);                        
                }
                JSxLocNavDefult();

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

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 01/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvPdtLocClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtLoc .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtLoc .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtLocDataTable(nPageCurrent);
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 11/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvPdtLocSeqClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtLocSeq .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtLocSeq .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPdtLocSeqDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 01/02/2019 Napat(Jame)
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
//Creator: 01/02/2019 Napat(Jame)
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

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 01/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxTextinModalSeq() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextBar = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextBar += aArrayConvert[0][$i].nBar;
            tTextBar += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmBarCodeDelete').val(tTextBar);
        // $('#ohdConfirmPlcCodeDelete').val(tTextPlc);
    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 01/02/2019 Napat(Jame)
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

//function : Function Disabled Browse and Clear Text Product Location
//Parameters : Number
//Creator : 06/02/2019 Napat(Jame)
//Return : -
//Return Type : -
function JSxLocChangeOptions(pnType){
    if(pnType==1){
        //Import Product Group
        $('#btnBrowseProductType').attr('disabled',true);
        $('#btnBrowseProductGroup').attr('disabled',false);
        $('#oetPtyName').val('');
    }else if(pnType==2){
        //Import Product Type
        $('#btnBrowseProductType').attr('disabled',false);
        $('#btnBrowseProductGroup').attr('disabled',true);
        $('#oetPgpName').val('');
    }
}

//function: Browse Product and Add to Database
//Parameters: -
//Creator:	04/02/2019 Napat(Jame)
//Return: View
//Return Type: View
function JSxLocImportTable(){
    var nSta        = $('input[name=ocbLocImport]:checked').val();
    var FTPlcCode   = $('#oetPlcCode').val();
    var tIDCode     = "";
    var tUrl        = "";
    
    if(nSta==1){
        //Import Product Group
        tIDCode = $('#oetPgpCode').val();
        tUrl    = "pdtlocationProductGroup";
    }else if(nSta==2){
        //Import Product Type
        tIDCode = $('#oetPtyCode').val();
        tUrl    = "pdtlocationProductType";
    }

    var count = $('#otbDataTableLocSeq tr.xWDataTableLocSeq').length;

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: tUrl,
        data: { 
            'tIDCode'   : tIDCode,
            'FTPlcCode' : FTPlcCode,
            'FNPldSeq'  : count
        },
        success: function(oResult) {
            var aReturn = JSON.parse(oResult);
            if(aReturn['rtCode'] == 905){
                alert('Error Not Found Product');
            }else{
                JSvPdtLocSeqDataTable();
            }
            JCNxCloseLoading();

        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Loc Seq Data Table
//Parameters: Ajax Success Event 
//Creator:	04/02/2019 Napat(Jame)
//Return: View
//Return Type: View
function JSvPdtLocSeqDataTable(pnPage){
    var tSearchAll      = $('#oetSearchPdtLocSeq').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    var FTPlcCode       = $('#oetPlcCode').val();

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "pdtlocationLocSeqDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
            FTPlcCode: FTPlcCode,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#odvContentManageDataList').html(tResult);
            }
            // JSxLocNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMPdtLoc_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Event Single Delete
//Parameters: pnPage,ptName,ptBarCode,ptPlcCode
//Creator: 04/02/2019 Napat(Jame)
//Return:  object Status Delete
//Return Type: object
function JSoPdtLocSeqDel(pnPage,ptName,ptBarCode,ptPlcCode){
    var aData = $('#ohdConfirmBarCodeDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {

        $('#odvModalDelPdtLocSeq').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + ptBarCode + '(' + ptName + ') ' + $('#oetTextComfirmDeleteYesOrNot').val());
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "pdtlocationSeqEventDelete",
                    data: { 
                        'tBarCode': ptBarCode, 
                        'tPlcCode': ptPlcCode
                    },
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);

                        $('#odvModalDelPdtLocSeq').modal('hide');
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.modal-backdrop').remove();
                        JSvPdtLocSeqDataTable(pnPage);
                        // JSoAddEditLocSeq('pdtlocationEventManageEdit')

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }


        });
    }
}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 04/02/2019 Napat(Jame)
//Return:  object Status Delete
//Return Type: object
function JSoPdtLocSeqDelChoose(pnPage){
    JCNxOpenLoading();

    var tPlcCode = $('#oetPlcCode').val();

    //BarCode
    var aData = $('#ohdConfirmBarCodeDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewBarCodeDelete = [];

    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewBarCodeDelete.push(aDataSplit[$i]);
    }

    if (aDataSplitlength > 1) {

        localStorage.StaDeleteArray = '1';

        $.ajax({
            type: "POST",
            url: "pdtlocationSeqEventDelete",
            data: { 
                'tBarCode': aNewBarCodeDelete, 
                'tPlcCode': tPlcCode
            },
            success: function(tResult) {
                
                // JSxLocNavDefult();
                setTimeout(function() {
                    $('#odvModalDelPdtLocSeq').modal('hide');
                    JSvPdtLocSeqDataTable(pnPage);
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.obtChoose').hide();
                    $('.modal-backdrop').remove();
                }, 1000);

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