var nStaCrdBrowseType   = $('#oetCrdStaBrowse').val();
var tCallCrdBackOption  = $('#oetCrdCallBackOption').val();
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCrdNavDefult();
    if(nStaCrdBrowseType != '1'){
        JSvCallPageCardList();
    }else{
        JSvCallPageCardAdd();
    }
});

//function : Function Clear Defult Button Card
//Parameters : Document Ready
//Creator : 10/10/2018 wasin
//Return : Show Tab Menu
//Return Type : -
function JSxCrdNavDefult(){
    if(nStaCrdBrowseType != 1 || nStaCrdBrowseType == undefined){
        $('.xCNChoose').hide();
        $('#oliCrdTitleAdd').hide();
        $('#oliCrdTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCrdInfo').show();
    }else{
        $('#odvModalBody #odvCrdMainMenu').removeClass('main-menu');   
        $('#odvModalBody #oliCrdNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCrdBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCrdBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCrdBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Page Card list  
//Parameters : Document Redy And Event Button
//Creator :	10/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageCardList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageCardList';
        $('#oetSearchCard').val('');
        JCNxOpenLoading();    
        $.ajax({
            type: "POST",
            url: "cardList",
            cache: false,
            data: {
                nPageCurrent: pnPage,
            },
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageCard').html(tResult);
                JSvCardDataTable(pnPage);
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
//Creator:	10/10/2018 wasin
//Return: View
//Return Type: View
function JSvCardDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll      = $('#oetSearchCard').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "cardDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataCard').html(tResult);
                }
                JSxCrdNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TFNMCard_L'); //โหลดภาษาใหม่
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

//Functionality : Call Page Card Add  
//Parameters : Event Button Click
//Creator : 10/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageCardAdd(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "cardPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if (nStaCrdBrowseType == '1') {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                }else{
                    $('.xCNCrdVBrowse').hide();
                    $('.xCNCrdVMaster').show();
                    $('#oliCrdTitleEdit').hide();
                    $('#oliCrdTitleAdd').show();
                    $('#odvBtnCrdInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageCard').html(tResult);
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

//Functionality : Call Page Card Edit  
//Parameters : Event Button Click 
//Creator : 11/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageCardEdit(ptCrdCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCardEdit',ptCrdCode);
        $.ajax({
            type: "POST",
            url: "cardPageEdit",
            data:{tCrdCode : ptCrdCode},
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliCrdTitleAdd').hide();
                    $('#oliCrdTitleEdit').show();
                    $('#odvBtnCrdInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCard').html(tResult);
                    //$('#oetCrdCode').addClass('xCNDisable');

                    // $('#oetCrdCode').attr('readonly', false);

                    $('.xCNBtnGenCode').attr('disabled', false);
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

//Functionality : Event Add/Edit Card
//Parameters : From Submit
//Creator : 10/10/2018 wasin
//Return : Status Event Add/Edit Card
//Return Type : object
function JSoAddEditCard(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tCrdHolderID = $("#oetCrdHolderID").val();
        var nCrdStaAct = $("#ocmCrdStaAct").val();   
        $('#ofmAddCard').validate().destroy();

        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "cardEventAdd"){
                if($("#ohdCheckDuplicateCrdCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');


        $('#ofmAddCard').validate({
            rules: {
                oetCrdCode: {
                    "required" : {
                        depents: function(oElement){
                            if(ptRoute == "cardEventAdd"){
                                if($('#ocbCardAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true
                                }
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                    oetCrdCtyCode:  {"required" :{}},
                    oetCrdCtyName:  {"required" :{}},
                    oetCrdCtyName : {"required" :{}},
                    // oetCrdHolderID : {"required" :{}},
            },
            messages: {
                oetCrdCode : {
                    "required"      : $('#oetCrdCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCrdCode').attr('data-validate-dublicateCode')
                },
             
                oetCrdCtyCode : {
                    "required"      : $('#oetCrdCtyCode').attr('data-validate-required'),
                },

                oetCrdCtyName : {
                    "required"      : $('#oetCrdCtyName').attr('data-validate-required'),
                },

                oetCrdCtyName : {
                    "required"      : $('#oetCrdCtyName').attr('data-validate-required'),
                },

                // oetCrdHolderID : {
                //     "required"      : $('#oetCrdHolderID').attr('data-validate-required'),
                // },
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
                    data: $('#ofmAddCard').serialize(),
                    success: function(oResult){
                        if(nStaCrdBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageCardEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageCardAdd();
                                        break;
                                    case '3':
                                        JSvCallPageCardList();
                                        break;
                                    default:
                                        JSvCallPageCardEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            }else{
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallCrdBackOption);
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

// //Functionality : Generate Code Card
// //Parameters : Event Button Click
// //Creator : 10/10/2018 wasin
// //Return : Event Push Value In Input
// //Return Type : -
// function JStGenerateCardCode(){
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         $('#oetCrdCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
//         $('#oetCrdCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
//         var tTableName = 'TFNMCard';
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
//                     $('#oetCrdCode').val(tData.rtCrdCode);
//                     $('#oetCrdCode').addClass('xCNDisable');
//                     $('#oetCrdCode').attr('readonly', true);
//                     $('.xCNBtnGenCode').attr('disabled', true); //เปลี่ยน Class ใหม่
//                     $('#oetCrdName').focus();
//                 } else {
//                     $('#oetCrdCode').val(tData.rtDesc);
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

//Functionality : Event Single Delete Card
//Parameters : Event Icon Delete
//Creator : 10/10/2018 wasin
//Return : object Status Delete
//Return Type : object
function JSoCardDel(tCurrentPage,tDelCode,tDelName){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var tTextComfirmDelete  = $('#oetTextComfirmDeleteYesOrNot').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(",");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        if (aDataSplitlength == '1'){
            //tDelName
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tDelCode+' ('+tDelName+') '+tTextComfirmDelete);
            $('#odvModalDelCard').modal('show');
            $('#osmConfirm').on('click', function(evt){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardEventDelete",
                    data: { 'tIDCode': tDelCode},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelCard').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                JSvCardDataTable(tCurrentPage);
                            },500);
                        }else{
                            alert(aReturn['tStaMessg']);
                        }
                        JSxCrdNavDefult();
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

//Functionality: Event Multi Delete Card
//Parameters: Event Button Delete All
//Creator: 10/10/2018 wasin
//Return:  object Status Delete
//Return Type: object
function JSoCardDelChoose(tCurrentPage){
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
                url: "cardEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function() {
                            $('#odvModalDelCard').modal('hide');
                            $('#ospConfirmDelete').empty();
                            $('#ohdConfirmIDDelete').val('');
                            JSvCallPageCardList(tCurrentPage);
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                        },1000);
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                    JSxCrdNavDefult();
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
function JSvCardClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCard .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCard .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardDataTable(nPageCurrent);
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



function JStChkStaAct(ptCrdHolderID){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type: "POST",
            url: "checkStatusActive",
            data: {
                tCrdHolderID: ptCrdHolderID
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                alert(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseErroe(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}






// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCrdIsCreatePage(){
    try{
        const tCrdCode = $('#oetCrdCode').data('is-created');    
        var bStatus = false;
        if(tCrdCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCrdIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCrdIsUpdatePage(){
    try{
        const tCrdCode = $('#oetCrdCode').data('is-created');
        var bStatus = false;
        if(!tCrdCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCrdIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCrdVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCrdVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCrdIsCreatePage(){
    try{
        const tCrdCode = $('#oetCrdCode').data('is-created');    
        var bStatus = false;
        if(tCrdCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCrdIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCrdIsUpdatePage(){
    try{
        const tCrdCode = $('#oetCrdCode').data('is-created');
        var bStatus = false;
        if(!tCrdCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCrdIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCrdVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCrdVisibleComponent Error: ', err);
    }
}



