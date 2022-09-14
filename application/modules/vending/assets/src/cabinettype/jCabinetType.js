var nStaCBNBrowseType = $('#oetCBNStaBrowse').val();
var tCallCBNBackOption =$('#oetCBNStaBrowseOption').val();
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCBNNavDefult();
    if(nStaCBNBrowseType != '1'){
        JSvCallPageCabinetTypeList(1);
    }else{
        JSvCallPageCabinetTypeAdd();
    }
});

//function : Function Clear Defult Button CabinetType
//Parameters : Document Ready
//Creator : 14/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxCBNNavDefult(){
    if(nStaCBNBrowseType != 1 || nStaCBNBrowseType == undefined){
        $('.xCNChoose').hide();
        $('#oliCBNTitleAdd').hide();
        $('#oliCBNTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCBNInfo').show();
    }else{
        $('#odvModalBody #odvCBNMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCBNNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCBNBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCBNBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCBNBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// function : Call Page CabinetType list  
// Parameters : Document Redy And Event Button
// Creator :	26/02/2020 witsarut
// Return : View
// Return Type : View
function JSvCallPageCabinetTypeList(pnPage){
    var nStaSession  = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageCabinetTypeList';
        $('#oetSearchCabinetType').val('');
        JCNxOpenLoading();
        $.ajax({
            type   : "POST",
            url    : "CabinetTypeList",
            cache: false,
            data:{
                nPageCurrent: pnPage,
            },
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageCabinetType').html(tResult);
                JSvCabinetTypeDataTable(pnPage)
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}


//function: Call CabinetType Data List
//Parameters: Ajax Success Event 
//Creator:	26/02/2020 witsarut
//Return: View
//Return Type: View
function JSvCabinetTypeDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var tSearchAll =   $('#oetSearchCabinetType').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type : "POST",
            url  : "CabinetTypeDataTable", 
            data : {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout : 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataCabinetType').html(tResult);
                }
                JSxCBNNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TVDMShopType_L'); //โหลดภาษาใหม่
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


//Functionality : Call Page CabinetType Add  
//Parameters : Event Button Click
//Creator : 26/02/2020 witsarut
//Return : View
//Return Type : View
function JSvCallPageCabinetTypeAdd(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "CabinetTypePageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(nStaCBNBrowseType == '1'){
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                }else{
                    $('.xCNCBNVBrowse').hide();
                    $('.xCNCBNVMaster').show();
                    $('#oliCBNTitleEdit').hide();
                    $('#oliCBNTitleAdd').show();
                    $('#odvBtnCBNInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageCabinetType').html(tResult);
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


//Functionality : Event Add/Edit CabinetType
//Parameters : From Submit
//Creator : 14/10/2018 witsarut
//Return : Status Event Add/Edit CabinetType
//Return Type : object
function JSoAddEditCabinetType(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCabinetType').validate().destroy();

        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "CabinetTypeEventAdd"){
                if($("#ohdCheckDuplicateCBNCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');

        $('#ofmAddCabinetType').validate({
            rules: {
                oetCBNCode : {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "CabinetTypeEventAdd") {
                                if ($('#ocbCabinetTypeAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetCBNName: { "required": {} }
            },
            messages: {

                oetCBNCode: {
                    "required": $('#oetCBNCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetCBNCode').attr('data-validate-dublicateCode')
                },

                oetCBNName : {
                    "required"      : $('#oetCBNName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCBNName').attr('data-validate-dublicateCode')
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
                    data: $('#ofmAddCabinetType').serialize(),
                    success: function(oResult){
                        if(nStaCBNBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaEvent'] == 1){
                                    case '1':
                                        JSvCallPageCabinetTypeEdit(aReturn['tCodeReturn']);
                                    break;
                                    case '2':
                                        JSvCallPageCabinetTypeAdd();
                                    break;
                                    case '3':
                                        JSvCallPageCabinetTypeList();
                                    break;
                                    default:
                                        JSvCallPageCabinetTypeEdit(aReturn['tCodeReturn']);
                                }
                            }else{
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallCBNBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}


//Functionality : Call Page CardType Edit  
//Parameters : Event Button Click 
//Creator : 11/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageCabinetTypeEdit(ptCBNCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCabinetTypeEdit',ptCBNCode);
        $.ajax({
            type: "POST",
            url: "CabinetTypePageEdit",
            data:{
                tCBNCode :ptCBNCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliCBNTitleAdd').hide();
                    $('#oliCBNTitleEdit').show();
                    $('#odvBtnCBNInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCabinetType').html(tResult);      
                    $('#oetCBNCode').addClass('xCNDisable'); 
                    $('#oetCBNCode').attr('readonly', true); 
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


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/09/2018 wasin
//Return : View
//Return Type : View
function JSvCabinetClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCabinet .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCabinet .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCabinetTypeDataTable(nPageCurrent);
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsCreatePage() {
    try {
        const tRsnCode = $('#oetCBNCode').data('is-created');
        var bStatus = false;
        if (tRsnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsUpdatePage() {
    try {
        const tRsnCode = $('#oetCBNCode').data('is-created');
        var bStatus = false;
        if (!tRsnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxReasonVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxReasonVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsCreatePage() {
    try {
        const tRsnCode = $('#oetCBNCode').data('is-created');
        var bStatus = false;
        if (tRsnCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbReasonIsUpdatePage() {
    try {
        const tRsnCode = $('#oetCBNCode').data('is-created');
        var bStatus = false;
        if (!tRsnCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbReasonIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxReasonVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxReasonVisibleComponent Error: ', err);
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

//Functionality : Event Single Delete CabinetType
//Parameters : Event Icon Delete
//Creator : 14/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoCabinetTypeDel(tCurrentPage,tDelCode,tDelName,tYesOnNo){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(",");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        if (aDataSplitlength == '1'){
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tDelCode + ' '+ tYesOnNo );
            $('#odvModalDeleteMutirecord').modal('show');
            $('#osmConfirm').on('click', function(evt){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "CabinetTypeEventDelete",
                    data: { 'tIDCode': tDelCode},
                    cache: false,
                    timeout:0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if(aReturn['nStaEvent'] == '1'){
                            $('#odvModalDeleteMutirecord').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function(){
                                if(aReturn["nNumRowRsnLoc"]!=0){
                                    if(aReturn["nNumRowRsnLoc"]> 10){
                                        nNumPage = Math.ceil(aReturn["nNumRowRsnLoc"]/10);
                                        if(tCurrentPage<=nNumPage){
                                            JSvCallPageCabinetTypeList(tCurrentPage);
                                        }else{
                                            JSvCallPageCabinetTypeList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageCabinetTypeList(1)
                                    }
                                }else{
                                    JSvCallPageCabinetTypeList(1)
                                }
                            },500);
                        }else{
                            alert(aReturn['tStaMessg']);
                        }
                        JSxCBNNavDefult();
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
function JSoCabinetTypeDelChoose(tCurrentPage){
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
                url: "CabinetTypeEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == '1') {
                        $('#odvModalDeleteMutirecord').modal('hide');
                        $('#ospConfirmDelete').empty();
                        localStorage.removeItem('LocalItemData');
                        $('#ohdConfirmIDDelete').val('');
                        setTimeout(function() {
                            if(aReturn["nNumRowRsnLoc"]!=0){
                                if(aReturn["nNumRowRsnLoc"]> 10){
                                    nNumPage = Math.ceil(aReturn["nNumRowRsnLoc"]/10);
                                    if(tCurrentPage<=nNumPage){
                                        JSvCallPageCabinetTypeList(tCurrentPage);
                                    }else{
                                        JSvCallPageCabinetTypeList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageCabinetTypeList(1)
                                }
                            }else{
                                JSvCallPageCabinetTypeList(1);
                            }
                        },500);
                    }else{
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxCBNNavDefult();
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