var nStaCtyBrowseType   = $('#oetCtyStaBrowse').val();
var tCallCtyBackOption  = $('#oetCtyCallBackOption').val();
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCtyNavDefult();
    if(nStaCtyBrowseType != '1'){
        //alert('if');
        JSvCallPageCardTypeList(1);
    }else{
        //alert('else');
        JSvCallPageCardTypeAdd();
    }
});

//function : Function Clear Defult Button CardType
//Parameters : Document Ready
//Creator : 14/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxCtyNavDefult(){
    if(nStaCtyBrowseType != 1 || nStaCtyBrowseType == undefined){
        $('.xCNChoose').hide();
        $('#oliCtyTitleAdd').hide();
        $('#oliCtyTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCtyInfo').show();
    }else{
        $('#odvModalBody #odvCtyMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCtyNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCtyBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCtyBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCtyBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Page CardType list  
//Parameters : Document Redy And Event Button
//Creator :	14/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageCardTypeList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageCardTypeList';
        $('#oetSearchCardType').val('');
        JCNxOpenLoading();    
        $.ajax({
            type: "POST",
            url: "cardtypeList",
            cache: false,
            data: {
                nPageCurrent: pnPage,
            },
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageCardType').html(tResult);
                JSvCardTypeDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Product Type Data List
//Parameters: Ajax Success Event 
//Creator:	14/10/2018 witsarut
//Return: View
//Return Type: View
function JSvCardTypeDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll      = $('#oetSearchCardType').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "cardtypeDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataCardType').html(tResult);
                }
                JSxCtyNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TFNMCardType_L'); //โหลดภาษาใหม่
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

//Functionality : Call Page CardType Add  
//Parameters : Event Button Click
//Creator : 14/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageCardTypeAdd(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "cardtypePageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if (nStaCtyBrowseType == '1') {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                }else{
                    $('.xCNCtyVBrowse').hide();
                    $('.xCNCtyVMaster').show();
                    $('#oliCtyTitleEdit').hide();
                    $('#oliCtyTitleAdd').show();
                    $('#odvBtnCtyInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageCardType').html(tResult);
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

//Functionality : Call Page CardType Edit  
//Parameters : Event Button Click 
//Creator : 11/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageCardTypeEdit(ptCtyCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCardTypeEdit',ptCtyCode);
        $.ajax({
            type: "POST",
            url: "cardtypePageEdit",
            data:{tCtyCode : ptCtyCode},
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliCtyTitleAdd').hide();
                    $('#oliCtyTitleEdit').show();
                    $('#odvBtnCtyInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCardType').html(tResult);
                    $('#oetCtyCode').addClass('xCNDisable');
                    $('#oetCtyCode').attr('readonly', true);
                    $('#obtGenCodeCardType').attr('disabled', true);
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

//Functionality : Event Add/Edit CardType
//Parameters : From Submit
//Creator : 14/10/2018 witsarut
//Return : Status Event Add/Edit CardType
//Return Type : object
function JSoAddEditCardType(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCardType').validate({
            rules: {
                ocmCtyExpireType : {
                    required: true
                },
                oetCtyCode   : "required",
                oetCtyCode   : "required",
                oetCtyName   : "required",
                oetCtyDeposit : "required",
                oetCtyTopupAuto : "required",
            },
            messages: {
                ocmCtyExpireType : $('#ocmCtyExpireType').data('validate'),
                oetCtyCode   : $('#oetCtyCode').data('validate'),
                oetCtyCode   : $('#oetCtyCode').data('validate'),
                oetCtyName   : $('#oetCtyName').data('validate'),
                oetCtyDeposit : $('#oetCtyDeposit').data('validate'),
                oetCtyTopupAuto : $('#oetCtyTopupAuto').data('validate')
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
            submitHandler: function(form){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddCardType').serialize(),
                    success: function(oResult){
                        if(nStaCtyBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageCardTypeEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageCardTypeAdd();
                                        break;
                                    case '3':
                                        JSvCallPageCardTypeList();
                                        break;
                                    default:
                                        JSvCallPageCardTypeEdit(aReturn['tCodeReturn']);
                                }
                            }else{
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
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
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Generate Code CardType
//Parameters : Event Button Click
//Creator : 14/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
// function JStGenerateCardTypeCode(){
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         $('#oetCtyCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
//         $('#oetCtyCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
//         var tTableName = 'TFNMCardType';
//         JCNxOpenLoading();
//         $.ajax({
//             type: "POST",
//             url: "generateCode",
//             data: { tTableName: tTableName },
//             cache: false,
//             timeout: 0,
//             success: function(tResult) {
//                 var tData = $.parseJSON(tResult);
//                 if (tData.rtCode == '1') {
//                     $('#oetCtyCode').val(tData.rtCtyCode);
//                     $('#oetCtyCode').addClass('xCNDisable');
//                     $('#oetCtyCode').attr('readonly', true);
//                     $('#obtGenCodeCardType').attr('disabled', true); //เปลี่ยน Class ใหม่
//                     $('#oetCtyName').focus();
//                 } else {
//                     $('#oetCtyCode').val(tData.rtDesc);
//                 }
//                 JCNxCloseLoading();
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
//     }else{
//         JCNxShowMsgSessionExpired();
//     }
// }

//Functionality : Event Single Delete CardType
//Parameters : Event Icon Delete
//Creator : 14/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoCardTypeDel(tCurrentPage,tDelCode,tDelName){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(",");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];

        if (aDataSplitlength == '1'){

            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tDelCode+' ('+tDelName+')');
            $('#odvModalDelCardType').modal('show');
            $('#osmConfirm').on('click', function(evt){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardtypeEventDelete",
                    data: { 'tIDCode': tDelCode},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelCardType').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                if(aReturn["nNumRowCtyLoc"]!=0){
                                    if(aReturn["nNumRowCtyLoc"]> 10){
                                        nNumPage = Math.ceil(aReturn["nNumRowCtyLoc"]/10);
                                        if(tCurrentPage<=nNumPage){
                                            JSvCallPageCardTypeList(tCurrentPage);
                                        }else{
                                            JSvCallPageCardTypeList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageCardTypeList(1);
                                    }
                                }else{
                                    JSvCallPageCardTypeList(1);
                                }
                                // JSvCardTypeDataTable(tCurrentPage);
                            },500);
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
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: Event Multi Delete CardType
//Parameters: Event Button Delete All
//Creator: 14/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoCardTypeDelChoose(tCurrentPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1){
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "cardtypeEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDelCardType').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ospConfirmIDDelete').val('');
                        setTimeout(function() {
                            if(aReturn["nNumRowCtyLoc"]!=0){
                                if(aReturn["nNumRowPdtLoc"]>10){
                                    nNumPage = Math.ceil(aReturn["nNumRowCtyLoc"]/10);
                                    if(tCurrentPage<=nNumPage){
                                        JSvCallPageCardTypeList(tCurrentPage);
                                    }else{
                                        JSvCallPageCardTypeList(nNumPage);
                                }
                                }else{
                                    JSvCallPageCardTypeList(1);
                                }
                            }else{
                                JSvCallPageCardTypeList(1);
                            }
                            // JSvCallPageCardTypeList(tCurrentPage);
                            // $('.modal-backdrop').remove();
                        },500);
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
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/09/2018 wasin
//Return : View
//Return Type : View
function JSvCardTypeClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardType .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardType .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardTypeDataTable(nPageCurrent);
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
//Creator: 11/10/2018 wasin
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
function JSbCtyIsCreatePage(){
    try{
        const tCtyCode = $('#oetCtyCode').data('is-created');    
        var bStatus = false;
        if(tCtyCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCtyIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCtyIsUpdatePage(){
    try{
        const tCtyCode = $('#oetCtyCode').data('is-created');
        var bStatus = false;
        if(!tCtyCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCtyIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCtyVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCtyVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCtyIsCreatePage(){
    try{
        const tCtyCode = $('#oetCtyCode').data('is-created');    
        var bStatus = false;
        if(tCtyCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCtyIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCtyIsUpdatePage(){
    try{
        const tCtyCode = $('#oetCtyCode').data('is-created');
        var bStatus = false;
        if(!tCtyCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCtyIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCtyVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCtyVisibleComponent Error: ', err);
    }
}


