var nStaDstBrowseType = $('#oetDstStaBrowse').val();
var tCallDstBackOption = $('#oetDstCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxDSTNavDefult();
    if (nStaDstBrowseType != 1) {
        JSvCallPageDistrictList(1);
    } else {
        JSvCallPageDistrictAdd();
    }
});

// ///function : Function Clear Defult Button District
// //Parameters : -
// //Creator : 15/05/2018 wasin
// //Return : -
// //Return Type : -
function JSxDSTNavDefult() {
    if (nStaDstBrowseType != 1 || nStaDstBrowseType == undefined) {
        $('#oliDstTitleAdd').hide();
        $('#oliDstTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnDstInfo').show();
    } else {
        $('#odvModalBody #odvDstMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliDstNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvDstBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNDstBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNDstBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// ///function : Call District Page list  
// //Parameters : - 
// //Creator :	15/05/2018 wasin
// //Last Update:	28/05/2018 wasin
// //Return : View
// //Return Type : View
function JSvCallPageDistrictList(tCurrentPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageDistrictList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "districtList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageDistrict').html(tResult);
                JSvDistrictDataTable(tCurrentPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Function : Call Recive Data List
// Parameters : Ajax Success Event 
// Creator:	15/05/2018 wasin
// Last Update:	28/05/2018 wasin
// Update:   
// Return : View
// Return Type : View
function JSvDistrictDataTable(pnPage) {
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
            url: "districtDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataDistrict').html(tResult);
                }
                JSxDSTNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMDistrict_L'); //โหลดภาษาใหม่
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

//Functionality : Call District Page Add  
//Parameters : -
//Creator : 15/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageDistrictAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "districtPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaDstBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                } else {
                    $('#oliDstTitleEdit').hide();
                    $('#oliDstTitleAdd').show();
                    $('#odvBtnDstInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageDistrict').html(tResult);
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

//Functionality : Call District Page Edit  
//Parameters : -
//Creator : 15/05/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageDistrictEdit(ptDstCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageDistrictEdit', ptDstCode);
        $.ajax({
            type: "POST",
            url: "districtPageEdit",
            data: { tDstCode: ptDstCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliDstTitleAdd').hide();
                    $('#oliDstTitleEdit').show();
                    $('#odvBtnDstInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageDistrict').html(tResult);
                    $('#oetDstCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);

                    $('#obtGenCodeZone').attr('disabled', true);
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

//Functionality : (event) Add/Edit District
//Parameters : form
//Creator : 15/05/2018 wasin
//Return : Status Add
//Return Type : n
function JSnAddEditDistrict(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddDistrict').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "districtEventAdd"){
                if($("#ohdCheckDuplicateDstCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');

        $('#ofmAddDistrict').validate({
            rules: {
                oetDstCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "districtEventAdd"){
                                if($('#ocbDstAutoGenCode').is(':checked')){
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
                oetDstName: {"required" :{}},
                // ocmRcnGroup: {"required" :{}},
            },
            messages: {
                oetDstCode : {
                    "required"      : $('#oetDstCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetDstCode').attr('data-validate-dublicateCode')
                },
                oetDstName : {
                    "required"      : $('#oetDstName').attr('data-validate-required'),
                },

                oetDstPvncode  : {
                    "required"      : $('#oetDstPvncode').attr('data-validate-required'),
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
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddDistrict').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaDstBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageDistrictEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageDistrictAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageDistrictList();
                                }
                            } else {
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxBrowseData(tCallDstBackOption);
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

// //Functionality : Generate Code District
// //Parameters : -
// //Creator : 15/05/2018 wasin
// //Return : Data
// //Return Type : String
function JStGenerateDistrictCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#oetDstCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetDstCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var tTableName = 'TCNMDistrict';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetDstCode').val(tData.rtDstCode);
                    $('#oetDstCode').addClass('xCNDisable');
                    $('#oetDstCode').attr('readonly', true);
                    $('#obtGenCodeZone').attr('disabled', true); //เปลี่ยน Class ใหม่
                } else {
                    $('#oetDstCode').val(tData.rtDesc);
                }
                $('#oetDstName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// //Functionality : Check District Code In DB
// //Parameters : -
// //Creator : 15/05/2018 wasin 
// //Return : Status,Message
// //Return Type : String
// function JStCheckDistrictCode() {
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         var tCode = $('#oetDstCode').val();
//         var tTableName = 'TCNMDistrict';
//         var tFieldName = 'FTDstCode';
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
//                 success: function(tResult) {
//                     var tData = $.parseJSON(tResult);
//                     $('.btn-default').attr('disabled', true);
//                     if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
//                         alert('มี id นี้แล้วในระบบ');
//                         JSvCallPageDistrictEdit(tCode);
//                     } else {
//                         alert('ไม่พบระบบจะ Gen ใหม่');
//                         JStGenerateDistrictCode();
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

// //Functionality : (event) Delete
// //Parameters : tIDCod รหัส District
// //Creator : 15/05/2018 wasin
// //Return : 
//Return Type :
function JSnDistrictDel(tCurrentPage,tDelName,tIDCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelDistrict').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + tDelName + ' ) ');
            $('#osmConfirm').on('click', function(evt) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "districtEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout:0,
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            $('#odvModalDelDistrict').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                if(aReturn["nNumRowDstLoc"]!=0){
                                    if(aReturn["nNumRowDstLoc"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowDstLoc"]/10);
                                        if(tCurrentPage<=nNumPage){
                                            JSvCallPageDistrictList(tCurrentPage);
                                        }else{
                                            JSvCallPageDistrictList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageDistrictList(1)
                                    }
                                }else{
                                    JSvCallPageDistrictList(1);
                                }
                                // JSvDistrictDataTable(tCurrentPage);
                            }, 500);
                        } else {
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxDSTNavDefult();
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

// //Functionality : (event) Delete All
// //Parameters :
// //Creator : 15/05/2018 wasin
// //Return : 
// //Return Type :
function JSnDistrictDelChoose() {
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
                url: "districtEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function() {
                            $('#odvModalDelDistrict').modal('hide');
                            JSvDistrictDataTable();
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();

                            if(aReturn["nNumRowDstLoc"]!=0){
                                if(aReturn["nNumRowDstLoc"]>10){
                                    nNumPage = Math.ceil(aReturn["nNumRowDstLoc"]/10);
                                    if(tCurrentPage<=nNumPage){
                                        JSvCallPageDistrictList(tCurrentPage);
                                    }else{
                                        JSvCallPageDistrictList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageDistrictList(1)
                                }
                            }else{
                                JSvCallPageDistrictList(1);
                            }

                        }, 1000);
                    } else {
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxDSTNavDefult();
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

// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 15/05/2018 wasin
// //Return : View
// //Return Type : View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageDistrict  .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageDistrict .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvDistrictDataTable(nPageCurrent);
}

// //Functionality: Function Chack And Show Button Delete All
// //Parameters: LocalStorage Data
// //Creator: 15/05/2018
// //Return: - 
// //Return Type: -
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

// //Functionality: Function Chack Value LocalStorage
// //Parameters: Event Select List District
// //Creator: 15/05/2018 wasin
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




// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbDstIsCreatePage(){
    try{
        const tDstCode = $('#oetDstCode').data('is-created');    
        var bStatus = false;
        if(tDstCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbDstIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbDstIsUpdatePage(){
    try{
        const tDstCode = $('#oetDstCode').data('is-created');
        var bStatus = false;
        if(!tDstCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbDstIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxDstVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxDstVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbDstIsCreatePage(){
    try{
        const tDstCode = $('#oetDstCode').data('is-created');    
        var bStatus = false;
        if(tDstCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbDstIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbDstIsUpdatePage(){
    try{
        const tDstCode = $('#oetDstCode').data('is-created');
        var bStatus = false;
        if(!tDstCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbDstIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxDstVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxDstVisibleComponent Error: ', err);
    }
}





