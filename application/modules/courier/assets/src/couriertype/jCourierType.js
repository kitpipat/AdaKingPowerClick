var nStaCtyBrowseType   = $('#oetCtyStaBrowse').val();
var tCallCtyBackOption  = $('#oetCtyCallBackOption').val();
// alert(nStaCtyBrowseType+'//'+tCallCtyBackOption);
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCtyNavDefult();
    if(nStaCtyBrowseType != 1){
        JSvCallPageCtyList();
    }else{
        JSvCallPageCtyAdd();
    }
});

//function : Function Clear Defult Button Product Size
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxCtyNavDefult(){
    if(nStaCtyBrowseType != 1 || nStaCtyBrowseType == undefined){
        $('.xCNCtyVBrowse').hide();
        $('.xCNCtyVMaster').show();
        $('.xCNChoose').hide();
        $('#oliCtyTitleAdd').hide();
        $('#oliCtyTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCtyInfo').show();
    }else{
        $('#odvModalBody .xCNCtyVMaster').hide();
        $('#odvModalBody .xCNCtyVBrowse').show();
        $('#odvModalBody #odvCtyMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCtyNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCtyBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCtyBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCtyBrowseLine').css('border-bottom', '1px solid #e3e3e3');
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

//function : Call couriertype Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageCtyList(){
    localStorage.tStaPageNow = 'JSvCallPageCtyList';
    $('#oetSearchCty').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "courierTypeList",
        cache: false,
        timeout: 0,
        success: function(tResult){
            $('#odvContentPageCty').html(tResult);
            JSvCtyDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//function: Call couriertype Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvCtyDataTable(pnPage){
    var tSearchAll      = $('#oetSearchCty').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;

    $.ajax({
        type: "POST",
        url: "courierTypeDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if(tResult != ""){
                $('#ostDataCty').html(tResult)
            }
            JSxCtyNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TCNMCourierType_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call couriertype Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function  JSvCallPageCtyAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('', '');

    $.ajax({
        type: "POST",
        url: "courierTypePageAdd",
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(nStaCtyBrowseType == 1){
                $('.xCNCtyVMaster').hide();
                $('.xCNCtyVBrowse').show();
            }else{
                $('.xCNCtyVBrowse').hide();
                $('.xCNCtyVMaster').show();
                $('#oliCtyTitleEdit').hide();
                $('#oliCtyTitleAdd').show();
                $('#odvBtnCtyInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageCty').html(tResult);
            $('#ocbCtyAutoGenCode').change(function(){
                $("#oetCtyCode").val("");
                $("#ohdCheckDuplicateCtyCode").val("1");
                if($('#ocbCtyAutoGenCode').is(':checked')) {
                    $("#oetCtyCode").attr("readonly", true);
                    $("#oetCtyCode").attr("onfocus", "this.blur()");
                    $('#ofmAddCty').removeClass('has-error');
                    $('#ofmAddCty em').remove();
                }else{
                    $("#oetCtyCode").attr("readonly", false);
                    $("#oetCtyCode").removeAttr("onfocus");
                }
            });
            $("#oetCtyCode").blur(function(){
                if(!$('#ocbCtyAutoGenCode').is(':checked')) {
                    if($("#ohdCheckCtyClearValidate").val()==1){
                        $('#ofmAddCty').validate().destroy();
                        $("#ohdCheckCtyClearValidate").val("0");
                    } 
                    if($("#ohdCheckCtyClearValidate").val()==0){
                        $.ajax({
                            type: "POST",
                            url: "CheckInputGenCode",
                            data: {
                                tTableName : "TCNMCourierType",
                                tFieldName : "FTCtyCode",
                                tCode : $("#oetCtyCode").val()
                            },
                            cache: false,
                            timeout: 0,
                            success: function(tResult){
                                var aResult = JSON.parse(tResult); 
                                $("#ohdCheckDuplicateCtyCode").val(aResult["rtCode"]);
                                JSxValidationFormCty("",$("#ohdPdtGroupRoute").val());
                                $('#ofmAddCty').submit();
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

//Functionality : Call couriertype Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageCtyEdit(ptCtyCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPageCtyEdit',ptCtyCode);
    $.ajax({
        type: "POST",
        url: "courierTypePageEdit",
        data: {tCtyCode: ptCtyCode},
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliCtyTitleAdd').hide();
                $('#oliCtyTitleEdit').show();
                $('#odvBtnCtyInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageCty').html(tResult);
                $('#oetCtyCode').addClass('xCNDisable');
                $('#oetCtyCode').attr('readonly', true);
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

//Functionality : center validate form
//Parameters : function submit name, route
//Creator : 29/03/2019 Witsarut
//Update : -
//Return : -
//Return Type : -
function JSxValidationFormCty(pFnSubmitName,ptRoute){
    $.validator.addMethod('dublicateCode', function(value, element) {
        if(ptRoute=="courierTypeEventAdd"){
            if($('#ocbCtyAutoGenCode').is(':checked')){
                return true;
            }else{
                if($("#ohdCheckDuplicateCtyCode").val()==1){
                    return false;
                }else{
                    return true;
                }
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddCty').validate({
        rules: {
            oetCtyCode : {
                "required" :{
                // ตรวจสอบเงื่อนไข validate
                depends: function(oElement) {
                    if(ptRoute=="courierTypeEventAdd"){
                        if($('#ocbCtyAutoGenCode').is(':checked')){
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
            oetCtyName: {
                "required" :{}
            }
        },
        messages: {
            oetCtyCode : {
                "required" :$('#oetCtyCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetCtyCode').attr('data-validate-dublicateCode')
            },
            oetCtyName : {
                "required" :$('#oetCtyName').attr('data-validate-required')
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

//Functionality : set click status submit form from save button
//Parameters : -
//Creator : 26/03/2019 Bell
//Return : -
//Return Type : -
function JSxSetStatusClickCtySubmit(){
    $("#ohdCheckCtyClearValidate").val("1");
}

//Functionality : Event Add/Edit couriertype
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit couriertype
//Return Type : object
function JSoAddEditCty(ptRoute){
    if($("#ohdCheckCtyClearValidate").val()==1){
        $('#ofmAddCty').validate().destroy();
        if(!$('#ocbCtyAutoGenCode').is(':checked')) {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName : "TCNMCourierType",
                    tFieldName : "FTCtyCode",
                    tCode : $("#oetCtyCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCtyCode").val(aResult["rtCode"]);
                    JSxValidationFormCty("JSxSubmitEventByButton",ptRoute);
                    $('#ofmAddCty').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JSxValidationFormCty("JSxSubmitEventByButton",ptRoute);
        }
    }
}

//Functionality : Generate Code  TCNMCourierType
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateCtyCode(){
    $('#oetCtyCode').parent().removeClass('alert-validate');
    var tTableName = 'TCNMCourierType';
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: {tTableName: tTableName},
        cache: false,
        timeout: 0,
        success: function(tResult){
            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetCtyCode').val(tData.rtCgpCode);
                $('#oetCtyCode').addClass('xCNDisable');
                $('#oetCtyCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
                $('#oetCtyName').focus();
            } else {
                $('#oetCtyCode').val(tData.rtDesc);
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
function JSoCtyDel(pnPage,ptName,tIDCode,ptConfirm){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];


    if (aDataSplitlength == '1') {
        $('#odvModalDelCty').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ ptConfirm);
        $('#osmConfirm').on('click', function(evt) {
            
            if (localStorage.StaDeleteArray != '1') {

                $.ajax({
                    type: "POST",
                    url: "courierTypeEventDelete",
                    data: {'tIDCode' : tIDCode},
                    cache: false,
                    success: function (tResult) {
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);

                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelCty').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(aReturn["nNumRowCty"]!=0){
                                    if(aReturn["nNumRowCty"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowCty"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCtyDataTable(pnPage);
                                        }else{
                                            JSvCtyDataTable(nNumPage);
                                        }
                                    }else{
                                        JSvCtyDataTable(1);
                                    }
                                }else{
                                    JSvCtyDataTable(1);
                                }
                            }, 500);
                        }else{
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);  
                        }
                        JSxCtyNavDefult();
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
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoCtyDelChoose(pnPage){
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
            url: "courierTypeEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function (tResult){
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);

                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelCty').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowCty"]!=0){
                            if(aReturn["nNumRowCty"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowCty"]/10);
                                if(pnPage<=nNumPage){
                                    JSvCtyDataTable(pnPage);
                                }else{
                                    JSvCtyDataTable(nNumPage);
                                }
                            }else{
                                JSvCtyDataTable(1);
                            }
                        }else{
                            JSvCtyDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);                        
                }
                JSxCtyNavDefult();


            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else {
        localStorage.StaDeleteArray = '0';

        return false;
    }
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCtyClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCty .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCty .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCtyDataTable(nPageCurrent);
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

//Functionality : function submit by submit button only
//Parameters : route
//Creator : 29/03/2019 pap
//Update : -
//Return : -
//Return Type : -
function JSxSubmitEventByButton(ptRoute){
    if($("#ohdCheckCtyClearValidate").val()==1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddCty').serialize(),
            cache: false,
            timeout: 0,
            success: function(oResult){
                if(nStaCtyBrowseType != 1) {
                    var aReturn = JSON.parse(oResult);
                    if(aReturn['nStaEvent'] == 1){
                        switch(aReturn['nStaCallBack']) {
                            case '1':
                                JSvCallPageCtyEdit(aReturn['tCodeReturn']);
                                break;
                            case '2':
                                JSvCallPageCtyAdd();
                                break;
                            case '3':
                                JSvCallPageCtyList();
                                break;
                            default:
                                JSvCallPageCtyEdit(aReturn['tCodeReturn']);
                        }
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                }else{
                    JCNxCloseLoading();
                    JCNxBrowseData(tCallCtyBackOption);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}