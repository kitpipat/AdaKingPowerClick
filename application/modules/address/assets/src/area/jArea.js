var nStaAreBrowseType   = $('#oetAreStaBrowse').val();
var tCallAreBackOption  = $('#oetAreCallBackOption').val();

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxAreNavDefult();
    if(nStaAreBrowseType != 1){
        JSvCallPageAreList(1);
    }else{
        JSvCallPageAreAdd();
    }
});

//function : Function Clear Defult Button Product Brand
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxAreNavDefult(){
    if(nStaAreBrowseType != 1 || nStaAreBrowseType == undefined){
        $('.xCNChoose').hide();
        $('#oliAreTitleAdd').hide();
        $('#oliAreTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnAreInfo').show();
    }else{
        $('#odvModalBody #odvAreMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliAreNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvAreBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNAreBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNAreBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Product Brand Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageAreList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageAreList';
        $('#oetSearchAre').val('');
        JCNxOpenLoading();    
        $.ajax({
            type: "POST",
            url: "areaList",
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageAre').html(tResult);
                JSvAreDataTable(pnPage);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Product Brand Data List
//Parameters: Ajax Success Event 
//Creator:	17/10/2018 witsarut
//Return: View
//Return Type: View
function JSvAreDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll      = $('#oetSearchAre').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "areaDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataAre').html(tResult);
                }
                JSxAreNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMArea_L'); //โหลดภาษาใหม่
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

//Functionality : Call Product Brand Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageAreAdd(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "areaPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if (nStaAreBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                }else{
                    $('#oliAreTitleEdit').hide();
                    $('#oliAreTitleAdd').show();
                    $('#odvBtnAreInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageAre').html(tResult);
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

//Functionality : Call Product Brand Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageAreEdit(ptAreCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageAreEdit',ptAreCode);
        $.ajax({
            type: "POST",
            url: "areaPageEdit",
            data: { tAreCode: ptAreCode },
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliAreTitleAdd').hide();
                    $('#oliAreTitleEdit').show();
                    $('#odvBtnAreInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageAre').html(tResult);
                    $('#oetAreCode').addClass('xCNDisable');
                    $('#oetAreCode').attr('readonly', true);
                    $('#obtGenCodeAre').attr('disabled', true);
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


//Functionality : Generate Code Product Brand
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
// function JStGenerateAreCode(){
//     var nStaSession = JCNxFuncChkSessionExpired();
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
//         $('#oetAreCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
//         $('#oetAreCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
//         var tTableName = 'TCNMArea';
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
//                     $('#oetAreCode').val(tData.rtAreCode);
//                     $('#oetAreCode').addClass('xCNDisable');
//                     $('#oetAreCode').attr('readonly', true);
//                     $('#obtGenCodeAre').attr('disabled', true); //เปลี่ยน Class ใหม่
//                     $('#oetAreName').focus();
//                 } else {
//                     $('#oetAreCode').val(tData.rtDesc);
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

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoAreDel(pnPage,ptName,tIDCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        if (aDataSplitlength == '1'){
            $('#odvModalDelAre').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' )');
            $('#osmConfirm').on('click', function(evt){
                // JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "areaEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == 1){
                            $('#odvModalDelAre').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                if(aReturn["nNumRowAreLoc"]!=0){
                                    if(aReturn["nNumRowAreLoc"]> 10){
                                        nNumPage = Math.ceil(aReturn["nNumRowAreLoc"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPageAreList(pnPage);
                                        }else{
                                            JSvCallPageAreList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageAreList(1);
                                    }
                                }else{
                                    JSvCallPageAreList(1);
                                }

                                // JSvAreDataTable(pnPage);
                            }, 500);
                        }else{
                            alert(aReturn['tStaMessg']);                        
                        }
                        JSxAreNavDefult();
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

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/10/2018 witsarut
//Return:  object Status Delete
//Return Type: object
function JSoAreDelChoose(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        var aData       = $('#ohdConfirmIDDelete').val();
        var aTexts      = aData.substring(0, aData.length - 2);
        var aDataSplit  = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1){
            localStorage.StaDeleteArray = '1';

            $.ajax({
                type: "POST",
                url: "areaEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function() {
                            $('#odvModalDelAre').modal('hide');
                            JSvAreDataTable(pnPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            if(aReturn["nNumRowAreLoc"]!=0){
                                if(aReturn["nNumRowAreLoc"]> 10){
                                    nNumPage = Math.ceil(aReturn["nNumRowAreLoc"]/10);
                                    if(pnPage<=nNumPage){
                                        JSvCallPageAreList(pnPage);
                                    }else{
                                        JSvCallPageAreList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageAreList(1);
                                }
                            }else{
                                JSvCallPageAreList(1);
                            }
                        }, 500);
                    }else{
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxAreNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvAreClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageAre .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageAre .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvAreDataTable(nPageCurrent);
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



//Functionality : (event) Add/Edit Area
//Parameters : form
//Creator : 11/05/2018 witsarut
//Return : Status Add
//Return Type : n
function JSoAddEditAre(ptRoute){
    $('#ofmAddAre').validate().destroy();
    $.validator.addMethod('dublicateCode', function(value, element){
        if(ptRoute == 'areaEventAdd'){
            if($("#ohdCheckDuplicateAreCode").val() == 1){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    }, '');

    $('#ofmAddAre').validate({
        rules: {
            oetAreCode:  {
                "required" : {
                    depends: function(oElement){
                        if(ptRoute == "areaEventAdd"){
                            if($('#ocbAreAutoGenCode').is(':checked')){
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
            oetAreName: {"required" :{}},
        },


        messages: {
            oetAreCode : {
                "required"      : $('#oetAreCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetAreCode').attr('data-validate-dublicateCode')
            },
            oetAreName : {
                "required"      : $('#oetAreName').attr('data-validate-required'),
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
                data: $('#ofmAddAre').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    
                    if (aReturn['nStaEvent'] == 1) {
                        if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                            JSvCallPageAreEdit(aReturn['tCodeReturn']);
                        } else if (aReturn['nStaCallBack'] == '2') {
                            JSvCallPageAreAdd();
                        } else if (aReturn['nStaCallBack'] == '3') {
                            JSvCallPageAreList(pnPage);
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
function JSbAreIsCreatePage(){
    try{
        const tAreCode = $('#oetAreCode').data('is-created');    
        var bStatus = false;
        if(tAreCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbAreIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbAreIsUpdatePage(){
    try{
        const tAreCode = $('#oetAreCode').data('is-created');
        var bStatus = false;
        if(!tAreCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbAreIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxAreVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxAreVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbAreIsCreatePage(){
    try{
        const tAreCode = $('#oetAreCode').data('is-created');    
        var bStatus = false;
        if(tAreCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbAreIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbAreIsUpdatePage(){
    try{
        const tAreCode = $('#oetAreCode').data('is-created');
        var bStatus = false;
        if(!tAreCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbAreIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxAreVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxAreVisibleComponent Error: ', err);
    }
}

