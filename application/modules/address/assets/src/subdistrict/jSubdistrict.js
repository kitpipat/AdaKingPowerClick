var nStaSdtBrowseType = $('#oetSdtStaBrowse').val();
var tCallSdtBackOption = $('#oetSdtCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSDTNavDefult();
    if (nStaSdtBrowseType != 1) {
        JSvCallPageSubdistrictList(1);
    } else {
        JSvCallPageSubdistrictAdd();
    }
});

///function : Function Clear Defult Button Subdistrict
//Parameters : Document Ready and Function Event
//Creator : 12/06/2018 wasin
//Return : Defaut view Button
//Return Type : n/a
function JSxSDTNavDefult() {
    if (nStaSdtBrowseType != 1) {
        $('#oliSdtTitleAdd').hide();
        $('#oliSdtTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnSdtInfo').show();
    } else {
        $('#odvModalBody #odvSdtMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliSdtNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvSdtBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNSdtBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNSdtBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call Subdistrict Page list  
//Parameters : Document Ready And Event Save Call Back
//Creator :	12/06/2018 wasin
//Last Modified : 
//Return : View
//Return Type : View
function JSvCallPageSubdistrictList(tCurrentPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageSubdistrictList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "subdistrictList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageSubdistrict').html(tResult);
                JSvSubdistrictDataTable(tCurrentPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Function : Call Subdistrict Data List
//Parameters : JS Function Parameter
//Creator: 12/06/2018 wasin
//Last Modified: -
//Return : Data View
//Return Type : View
function JSvSubdistrictDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "subdistrictDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataSubdistrict').html(tResult);
                }
                JSxSDTNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMSubDistrict_L'); //โหลดภาษาใหม่
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

//Functionality : Call Subdistrict Page Add  
//Parameters : Event Function Button
//Creator : 12/06/2018 wasin
//Last Modifile : -
//Return : View
//Return Type : View
function JSvCallPageSubdistrictAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "subdistrictPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaSdtBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                } else {
                    $('.xCNSdtVBrowse').hide();
                    $('.xCNSdtVMaster').show();
                    $('#oliSdtTitleEdit').hide();
                    $('#oliSdtTitleAdd').show();
                    $('#odvBtnSdtInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageSubdistrict').html(tResult);
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

//Functionality : Call Province Page Edit  
//Parameters : Event Function Button 
//Creator : 12/06/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageSubdistrictEdit(ptSdtCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageSubdistrictEdit', ptSdtCode);
        $.ajax({
            type: "POST",
            url: "subdistrictPageEdit",
            data: { tSdtCode: ptSdtCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#oliSdtTitleAdd').hide();
                    $('#oliSdtTitleEdit').show();
                    $('#odvBtnSdtInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageSubdistrict').html(tResult);
                    $('#oetSdtCode').addClass('xCNDisable');

                    $('#oetSdtCode').attr('readonly', true);
                    $('#obtGenCodeSubDis').attr('disabled', true);

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

//Functionality : Event Add/Edit Subdistrict
//Parameters : Form Submit Button
//Creator : 012/06/2018 wasin
//Return : Status Add/Edit Event And Event CallBack
//Return Type : n
function JSnAddEditSubdistrict(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddSubdistrict').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "subdistrictEventAdd"){
                if($("#ohdCheckDuplicateSdtCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');

        $('#ofmAddSubdistrict').validate({
            rules: {
                oetSdtCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "subdistrictEventAdd"){
                                if($('#ocbSubdistrictAutoGenCode').is(':checked')){
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
                oetSdtName: {"required" :{}},
               
            },
            messages: {
                oetSdtCode : {
                    "required"      : $('#oetSdtCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetSdtCode').attr('data-validate-dublicateCode')
                },
                oetSdtName : {
                    "required"      : $('#oetSdtName').attr('data-validate-required'),
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
                    data: $('#ofmAddSubdistrict').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaSdtBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageSubdistrictEdit(aReturn['tCodeReturn']);
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageSubdistrictAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageSubdistrictList();
                                }
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSdtBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Generate Code Subdistrict
//Parameters : Event Icon Click
//Creator : 07/06/2018 wasin
//Return : Data
//Return Type : String
function JStGenerateSubdistrictCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#oetSdtCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetSdtCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var tTableName = 'TCNMSubDistrict';
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
                    $('#oetSdtCode').val(tData.rtSudCode);
                    $('#oetSdtCode').addClass('xCNDisable');
                    $('#oetSdtCode').attr('readonly', true);
                    $('#obtGenCodeSubDis').attr('disabled', true); //เปลี่ยน Class ใหม่
                } else {
                    $('#oetSdtCode').val(tData.rtDesc);
                }
                JCNxCloseLoading();
                $('#oetSdtPvncode').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Check Subdistrict Code In DB
//Parameters : Event Enter Input Code
//Creator : 12/06/2018 wasin
//Return : Status,Message
//Return Type : String
// function JStCheckSubdistrictCode() {
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         tCode = $('#oetSdtCode').val();
//         var tTableName = 'TCNMSubDistrict';
//         var tFieldName = 'FTSudCode';
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
//                         JSvCallPageSubdistrictEdit(tCode);
//                     } else {
//                         alert('ไม่พบระบบจะ Gen ใหม่');
//                         JStGenerateSubdistrictCode();
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

//Functionality : Event Delete Subdistrict
//Parameters : Event Click Button
//Creator : 12/06/2018 wasin
//Return : Status Delete
//Return Type : object
function JSnSubdistrictDel(tCurrentPage,tDelName,tIDCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];

        if (aDataSplitlength == '1') {
            $('#odvModalDelSubdistrict').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ');
            $('#osmConfirm').on('click', function(evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "subdistrictEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            $('#odvModalDelSubdistrict').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                if(aReturn["nNumRowSudLoc"]!=0){
                                    if(aReturn["nNumRowSudLoc"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowSudLoc"]/10);
                                        if(tCurrentPage<=nNumPage){
                                            JSvCallPageSubdistrictList(tCurrentPage);
                                        }else{
                                            JSvCallPageSubdistrictList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageSubdistrictList(1);
                                    }
                                }else{
                                    JSvCallPageSubdistrictList(1);
                                }
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxSDTNavDefult();
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

//Functionality : Event Delete All 
//Parameters : Buttom Event Click
//Creator : 12/06/2018 wasin
//Return : Status Delete
//Return Type : array
function JSaSubdistrictDelChoose(pnpage) {
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
                url: "subdistrictEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvModalDelSubdistrict').modal('hide');
                            JSvSubdistrictDataTable(pnpage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            if(aReturn["nNumRowSudLoc"]!=0){
                                if(aReturn["nNumRowSudLoc"]>10){
                                    nNumPage = Math.ceil(aReturn["nNumRowSudLoc"]/10);
                                    if(tCurrentPage<=nNumPage){
                                        JSvCallPageSubdistrictList(tCurrentPage);
                                    }else{
                                        JSvCallPageSubdistrictList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageSubdistrictList(1);
                                }
                            }else{
                                JSvCallPageSubdistrictList(1);
                            }
                        }, 1000);
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

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Button
//Creator : 12/06/2018 wasin
//Return : View
//Return Type : View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWSUBPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWSUBPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvSubdistrictDataTable(nPageCurrent);
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
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
//Creator: 11/10/2018 wasin
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


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 12/06/2018 wasin
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







// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSdtIsCreatePage(){
    try{
        const tSdtCode = $('#oetSdtCode').data('is-created');    
        var bStatus = false;
        if(tSdtCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSdtIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSdtIsUpdatePage(){
    try{
        const tSdtCode = $('#oetSdtCode').data('is-created');
        var bStatus = false;
        if(!tSdtCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSdtIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSdtVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxSdtVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSdtIsCreatePage(){
    try{
        const tSdtCode = $('#oetSdtCode').data('is-created');    
        var bStatus = false;
        if(tSdtCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSdtIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSdtIsUpdatePage(){
    try{
        const tSdtCode = $('#oetSdtCode').data('is-created');
        var bStatus = false;
        if(!tSdtCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSdtIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSdtVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxSdtVisibleComponent Error: ', err);
    }
}






