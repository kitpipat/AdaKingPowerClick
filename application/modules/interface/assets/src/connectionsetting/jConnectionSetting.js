var nStaInterfaceImportBrowseType  = $('#oetInterfaceImportStaBrowse').val();
var tCallInterfaceImportBackOption = $('#oetInterfaceImportCallBackOption').val();


$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/

    JSvConnectionSettingList(1);

    // create By Witsarut 15/05/2020
    // Default หน้าแรก
    JSxCallGetConGeneral();

});

//function : Call ConnsetGen Page list
//Parameters : Document Redy And Event Button
//Creator :	15/05/2020 Witsarut (Bell)
//Return : View
//Return Type : View
function JSvConnectionSettingList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAllNotSet  = $('#oetSearchAllNotSet').val();
        var tSearchAllSetUp   = $('#oetSearchAllSetUp').val();
        // JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "connectionsettingDataTable",
            data    : {
                nPageCurrent : pnPage,
                tSearchAllNotSet : tSearchAllNotSet,
                tSearchAllSetUp  : tSearchAllSetUp
            },
            cache   : false,
            timeout : 0,
            async   : false,
            success : function(tResult){
                $('#odvWahouse').html(tResult);
                JSxControlScroll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function : Call connectionsetting Page list
// Parameters : -
// Creator :	14/05/2020 saharat(Golf)
// Last Update:
// Return : View
// Return Type : View
function JSxCallGetContent() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type: "GET",
            url: "connectionsettingCallPageList",
            cache: false,
            timeout : 0,
            async   : false,
            success: function(tResult) {
                JSvConnectionSettingList(1);
                // $('#odvWahouse').html(tResult);
                JSxControlScroll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function : Call Customer Page list
// Parameters : -
// Creator :	02/08/2021 Amontep(Mos)
// Last Update:
// Return : View
// Return Type : View
function JSxCallGetCustomer() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type: "GET",
            url: "masCustomersettingCallPageList",
            cache: false,
            timeout : 0,
            async   : false,
            success: function(tResult) {
                $('#odvCustomer').html(tResult);
                JSxControlScroll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

// Function : Call connectionsetting Page list
// Parameters : -
// Creator :	14/05/2020 Witsarut(Bell)
// Last Update:
// Return : View
// Return Type : View
function JSxCallGetConGeneral(){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    // If has Session
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type    : "POST",
            url     : "connectSetGenaral",
            cache	: false,
            timeout	: 0,
            success	: function(tResult){
                $('#odvGeneralInformation').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }

}

// Function : Call connectionsetting Page list
// Parameters : -
// Creator :	14/05/2020 saharat(Golf)
// Last Update:
// Return : View
// Return Type : View
function JSvCallPageAddWahouse() {
    JCNxOpenLoading();
    $.ajax({
        type: "GET",
        url: "connectionsettingCallPageAddWahouse",
        cache: false,
        success: function(tResult) {
            $('#odvWahouse').html(tResult);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : insert data ConnectionSetting
// Parameters : form ofmAddConnectionSetting
// Creator :	15/05/2020 saharat(Golf)
// Last Update:
// Return : View
// Return Type : View
function JSnAddEditConnectionSetting(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    var tBchCode   = $('#oetCssBchCode').val();

    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddConnectionSetting').validate().destroy();
        $('#ofmAddConnectionSetting').validate({
            rules: {

                //oetCssAgnName:   { "required": {} },
                oetCssBchName:   { "required": {} },
                oetCssWahName:   { "required": {} },
                oetCssWahRefNo:  { "required": {} },

            },
            messages: {
                // oetCssAgnName: {
                //     "required"      :      $('#oetCssAgnName').attr('data-validate-required'),
                //     "dublicateCode" :      $('#oetCssAgnName').attr('data-validate-dublicateCode'),
                // },
                oetCssBchName: {
                    "required"      :      $('#oetCssBchName').attr('data-validate-required'),
                    "dublicateCode" :      $('#oetCssBchName').attr('data-validate-dublicateCode'),
                },
                oetCssWahName: {
                    "required"      :      $('#oetCssWahName').attr('data-validate-required'),
                    "dublicateCode" :      $('#oetCssWahName').attr('data-validate-dublicateCode'),
                },
                oetCssWahRefNo: {
                    "required"      :      $('#oetCssWahRefNo').attr('data-validate-required'),
                    "dublicateCode" :      $('#oetCssWahRefNo').attr('data-validate-dublicateCode'),
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
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddConnectionSetting').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        JSxCallGetContent();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}

//Functionality : Call ConnectionSetting PageEdit
//Parameters : function Parameters
//Creator : 15/05/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageEditConnectionSetting(ptMerCode,ptBchCode,ptShpCode,ptWahCode) {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "connectionsettingCallPageEdit",
        data: {
            tMerCode: ptMerCode,
            tBchCode: ptBchCode,
            tShpCode: ptShpCode,
            tWahCode: ptWahCode,
        },
        success: function(tResult) {
            $('#odvWahouse').html(tResult);
            JCNxCloseLoading();

        },
        error: function(data) {
            console.log(data);
        }
    });
}

//ควบคุมตารางให้มีสกอร์ หรือไม่มีสกอร์
function JSxControlScroll(){
    var nWindowHeight = ( $(window).height() - 50 ) / 2 ;

    //สำหรับตารางที่เป็นเช็คบ๊อก
    var nLenCheckbox =  $('#otbTableForCheckbox tbody tr').length;
    if(nLenCheckbox > 6){
        $('.xCNTableHeightCheckbox').css('height',nWindowHeight);
    }else{
        $('.xCNTableHeightCheckbox').css('height','auto');
    }

    //สำหรับตารางอื่นๆ
    var nLenInput =  $('#otbTableForInput tbody tr').length;
    if(nLenCheckbox < 6){
        var nWindowHeightInput = ( $(window).height() - 125 ) / 2 ;
    }else{
        var nWindowHeightInput = nWindowHeight;
    }

    if(nLenInput > 6){
        $('.xCNTableHeightInput').css('height',nWindowHeightInput);
    }else{
        $('.xCNTableHeightInput').css('height','auto');
    }
}

// Function delete sigle
// Create witsarut 21/05/2020
function JSxConSetDelete(ptAgnCode, ptBchCode,ptShpCode, ptWahCode, tYesOnNo){
    $('#odvModalDeleteSingle').modal('show');
    $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptAgnCode + ' '+ tYesOnNo );
    $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt){
        $.ajax({
            type  : "POST",
            url:  "connectionsettingEventDelete",
            data : {
                tAgnCode : ptAgnCode,
                tBchCode : ptBchCode,
                tShpCode : ptShpCode,
                tWahCode : ptWahCode,
            },
            cache: false,
            success: function(tResult){
                $('#odvModalDeleteSingle').modal('hide');
                setTimeout(function(){
                    JSxCallGetContent();
                }, 500);
            },

        });
    });
}


//Functionality : (event) Delete All
//Parameters :
//Creator : 11/06/2019 Witsarut (Bell)
//Return :
//Return Type :
function  JSxDeleteMutirecord(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        var aDataAgnCode    =[];
        var aDataMerCode    =[];
        var aDataWahCode    =[];
        var ocbListItem     = $(".ocbListItem");
        for(var nI = 0;nI<ocbListItem.length;nI++){
            if($($(".ocbListItem").eq(nI)).prop('checked')){
                aDataAgnCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmAgnCodeDelete"));
                aDataBchCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmBchDelete"));
                aDataShpCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmShpDelete"));
                aDataWahCode.push($($(".ocbListItem").eq(nI)).attr("ohdConfirmWahDelete"));
            }
        }

        $.ajax({
            type: "POST",
            url:  "connectionsettingEventDeleteMultiple",
            data: {
                'paDataAgnCode'   : aDataAgnCode,
                'paDataBchCode'   : aDataBchCode,
                'paDataShpCode'   : aDataShpCode,
                'paDataWahCode'   : aDataWahCode,
            },
            cache: false,
            success: function (tResult){
                tResult = tResult.trim();
                var aReturn = $.parseJSON(tResult);
                if(aReturn['nStaEvent'] == '1'){
                    $('#odvModalDeleteMutirecord').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    setTimeout(function(){
                        JSxCallGetContent();
                    }, 500);
                }else{
                    alert(aReturn['tStaMessg']);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}



//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 05/07/2019 witsarut (Bell)
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
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


//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 05/07/2019 witsarut (Bell)
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

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 05/07/2019 witsarut (Bell)
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
