var nStaPvnBrowseType = $('#oetPvnStaBrowse').val();
var tCallPvnBackOption = $('#oetPvnCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPVNNavDefult();
    if (nStaPvnBrowseType != 1) {
        JSvCallPageProvinceList(1);
    } else {
        JSvCallPageProvinceAdd();
    }
});

///function : Function Clear Defult Button Province
//Parameters : -
//Creator : 10/05/2018 wasin
//Return : -
//Return Type : -
function JSxPVNNavDefult() {
    if (nStaPvnBrowseType != 1) {
        $('#oliPvnTitleAdd').hide();
        $('#oliPvnTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnPvnInfo').show();
    } else {
        $('#odvModalBody #odvPvnMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPvnNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPvnBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPvnBrowseLine').css('padding', '0px 0px');
    }
}

///function : Call Province Page list  
//Parameters : Document Ready And Event Save Call Back
//Creator :	14/05/2018 wasin
//Last Modified : 30/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageProvinceList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageProvinceList';
        $('#oetSearchProvince').val('');
        $.ajax({
            type: "POST",
            url: "provinceList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageProvince').html(tResult);
                JSvProvinceDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

///function : Call Province Data List
//Parameters : JS Function Parameter
//Creator: 14/05/2018 wasin
//Last Modified: 30/05/2018 wasin
//Return : View
//Return Type : View
function JSvProvinceDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll = $('#oetSearchProvince').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "provinceDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataProvince').html(tResult);
                }
                JSxPVNNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMProvince_L'); //โหลดภาษาใหม่
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

// //Functionality : Call Province Page Add  
// //Parameters : -
// //Creator : 14/05/2018 wasin
// //Return : View
// //Return Type : View
function JSvCallPageProvinceAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "provincePageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaPvnBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                } else {
                    $('#oliPvnTitleEdit').hide();
                    $('#oliPvnTitleAdd').show();
                    $('#odvBtnPvnInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageProvince').html(tResult);
                JCNxLayoutControll();
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

// //Functionality : Call Province Page Edit  
// //Parameters : -
// //Creator : 14/05/2018 wasin
// //Return : View
// //Return Type : View
function JSvCallPageProvinceEdit(ptPvnCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageProvinceEdit', ptPvnCode);
        $.ajax({
            type: "POST",
            url: "provincePageEdit",
            data: { tPvnCode: ptPvnCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#oliPvnTitleAdd').hide();
                    $('#oliPvnTitleEdit').show();
                    $('#odvBtnPvnInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageProvince').html(tResult);

                    $('#oetPvnCode').attr('readonly', true);
                    $('#obtGenCodeProvince').attr('disabled', true);
                }
                JCNxLayoutControll();
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

// //Functionality : Generate Code Province
// //Parameters : -
// //Creator : 14/05/2018 wasin
// //Return : Data
// //Return Type : String
// function JStGenerateProvinceCode() {
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         var tTableName = 'TCNMProvince';
//         $.ajax({
//             type: "POST",
//             url: "generateCode",
//             data: { tTableName: tTableName },
//             cache: false,
//             timeout: 0,
//             success: function(tResult) {
//                 var tData = $.parseJSON(tResult);
//                 if (tData.rtCode == '1') {
//                     $('#oetPvnCode').val(tData.rtPvnCode);
//                     $('#oetPvnCode').addClass('xCNDisable');
//                     $('.xCNDisable').attr('readonly', true);
//                     //----------Hidden ปุ่ม Gen
//                     $('.xCNiConGen').css('display', 'none');
//                     $('#obtGenCodeProvince').attr('disabled', true);
//                 } else {
//                     $('#oetPvnCode').val(tData.rtDesc);
//                 }
//                 $('#oetPvnName').focus();
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }else{
//         JCNxShowMsgSessionExpired();
//     }
// }

// //Functionality : Check Province Code In DB
// //Parameters : -
// //Creator : 14/05/2018 wasin 
// //Return : Status,Message
// //Return Type : String
// function JStCheckProvinceCode() {
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         var tCode = $('#oetPvnCode').val();
//         var tTableName = 'TCNMProvince';
//         var tFieldName = 'FTPvnCode';
//         if (tCode != '') {
//             $.ajax({
//                 type: "POST",
//                 url: "CheckInputGenCode",
//                 data: {
//                     tTableName: tTableName,
//                     tFieldName: tFieldName,
//                     tCode: tCode
//                 },
//                 cache: false,
//                 timeout: 0,
//                 success: function(tResult) {
//                     var tData = $.parseJSON(tResult);
//                     $('.btn-default').attr('disabled', true);
//                     if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
//                         alert('มี id นี้แล้วในระบบ');
//                         JSvCallPageProvinceEdit(tCode);
//                     } else {
//                         alert('ไม่พบระบบจะ Gen ใหม่');
//                         JStGenerateProvinceCode();
//                     }
//                     $('.wrap-input100').removeClass('alert-validate');
//                     $('.btn-default').attr('disabled', false);
//                 },
//                 error: function(jqXHR, textStatus, errorThrown) {
//                     JCNxResponseError(jqXHR, textStatus, errorThrown);
//                 }
//             });
//         }
//     }else{
//         JCNxShowMsgSessionExpired();
//     }
// }

// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 14/05/2018 wasin
// //Return : View
// //Return Type : View
function JSvProvinceClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageProvince .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageProvince .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvProvinceDataTable(nPageCurrent);
}

// //Functionality: Function Chack And Show Button Delete All
// //Parameters: LocalStorage Data
// //Creator: 14/05/2018
// //Return: - 
// //Return Type: -

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


// //Functionality: Insert Text In Modal Delete
// //Parameters: LocalStorage Data
// //Creator: 14/05/2018 wasin
// //Return: -
// //Return Type: -
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

// //Functionality: Function Chack Value LocalStorage
// //Parameters: Event Select List Reason
// //Creator: 14/05/2018 wasin
// //Return: Duplicate/none
// //Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

// //Functionality : (event) Delete
// //Parameters : tIDCod รหัส Province
// //Creator : 14/05/2018 wasin
// //Return : 
// //Return Type :
function JSnProvinceDel(pnPage,tDelName,tIDCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelProvince').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val()  + tIDCode + ' ( ' + tDelName + ' ) ');
            $('#osmConfirm').on('click', function(evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "provinceEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            $('#odvModalDelProvince').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                if(aReturn["nNumRowPvnLoc"]!= 0){
                                    if(aReturn["nNumRowPvnLoc"]> 10){
                                        nNumPage = Math.ceil(aReturn["nNumRowPvnLoc"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPageProvinceList(pnPage);
                                        }else{
                                            JSvCallPageProvinceList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageProvinceList(1);
                                    }
                                }else{
                                    JSvCallPageProvinceList(1);
                                }
                                // JSvCallPageProvinceList(tCurrentPage);
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : (event) Delete All
//Parameters :
//Creator : 14/05/2018 wasin
//Return :
//Return Type :
function JSoProvinceDelChoose(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
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
                url: "provinceEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                timeout: 5000,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvModalDelProvince').modal('hide');
                            JSvCallPageProvinceList(pnPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            ('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            if(aReturn["nNumRowPvnLoc"]!= 0){
                                if(aReturn["nNumRowPvnLoc"]> 10){
                                    nNumPage = Math.ceil(aReturn["nNumRowPvnLoc"]/10);
                                    if(tCurrentPage<=nNumPage){
                                        JSvCallPageProvinceList(pnPage);
                                    }else{
                                        JSvCallPageProvinceList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageProvinceList(1);
                                }
                            }else{
                                JSvCallPageProvinceList(1);
                            }
                        }, 1500);
                    } else {
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}



function JSnAddEditProvince(ptRoute){
    $('#ofmAddProvince').validate().destroy();
    $.validator.addMethod('dublicateCode', function(value, element){
        if(ptRoute == 'provinceEventAdd'){
            if($("#ohdCheckDuplicatePvnCode").val() == 1){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }, '');
    $('#ofmAddProvince').validate({
        rules: {
            oetRcvCode:  {
                "required" : {
                    depends: function(oElement){
                        if(ptRoute == "reciveEventAdd"){
                            if($('#ocbPvnAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                },
                "dublicateCode": {}
            },    
            oetRcvName: {"required" :{}},
        },
        messages: {
            oetPvnCode : {
                "required"      : $('#oetPvnCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPvnCode').attr('data-validate-dublicateCode')
            },
            oetPvnName : {
                "required"      : $('#oetPvnName').attr('data-validate-required'),
            }
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
            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddProvince').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    
                    if (aReturn['nStaEvent'] == 1) {
                        if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                            JSvCallPageProvinceEdit(aReturn['tCodeReturn']);
                        } else if (aReturn['nStaCallBack'] == '2') {
                            JSvCallPageProvinceAdd();
                        } else if (aReturn['nStaCallBack'] == '3') {
                            JSvCallPageProvinceList(pnPage);
                        }
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                },
                error: function(data) {
                    console.log(data);
                }
            });
        },
    });

}



// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbPvnIsCreatePage(){
    try{
        const tPvnCode = $('#oetPvnCode').data('is-created');    
        var bStatus = false;
        if(tPvnCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbPvnIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbPvnIsUpdatePage(){
    try{
        const tPvnCode = $('#oetPvnCode').data('is-created');
        var bStatus = false;
        if(!tPvnCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbPvnIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxPvnVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxPvnVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbPvnIsCreatePage(){
    try{
        const tPvnCode = $('#oetPvnCode').data('is-created');    
        var bStatus = false;
        if(tPvnCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbPvnIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbPvnIsUpdatePage(){
    try{
        const tPvnCode = $('#oetPvnCode').data('is-created');
        var bStatus = false;
        if(!tPvnCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbPvnIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxPvnVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxPvnVisibleComponent Error: ', err);
    }
}






