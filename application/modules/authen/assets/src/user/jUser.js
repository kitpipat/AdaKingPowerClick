var nStaUsrBrowseType = $('#oetUsrStaBrowse').val();
var tCallUsrBackOption = $('#oetUsrCallBackOption').val();

$('ducument').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxUSRNavDefult();
    if (nStaUsrBrowseType != 1) {
        JSvCallPageUserList();
    } else {
        JSvCallPageUserAdd();
    }
});

///function : Function Clear Defult Button User
//Parameters : documet ready and Function Parameter
//Last Update: 02/07/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
//Creator : 01/06/2018 wasin
//Return : Set Default Button View User
//Return Type : -
function JSxUSRNavDefult() {
    if (nStaUsrBrowseType != 1) {
        $('.xCNUsrVBrowse').hide();
        $('.xCNUsrVMaster').show();
        $('#oliUsrTitleAdd').hide();
        $('#oliUsrTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnUsrInfo').show();
    } else {
        $('#odvModalBody .xCNUsrVMaster').hide();
        $('#odvModalBody .xCNUsrVBrowse').show();
        $('#odvModalBody #odvUsrMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliUsrNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvUsrBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNUsrBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNUsrBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

///function : Call User Page list  
//Parameters : Document Ready And Event Call Back
//Creator :	01/06/2018 wasin
//Return : View Html user List
//Return Type : View
function JSvCallPageUserList() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageUserList';
        $.ajax({
            typt: "POST",
            url: "userList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageUser').html(tResult);
                JSvUserDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function : Call User Data List
//Parameters : JS Function Parameter
//Last Update: 02/07/2018 wasin [ปรับรองรับการเพิ่มข้อมูลผ่านหน้า Browse]
//Creator:	01/06/2018 wasin
//Return : View Datatable
//Return Type : View
function JSvUserDataTable(pnPage) {
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
            url: "userDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataUser').html(tResult);
                }
                JSxUSRNavDefult();
                JCNxLayoutControll();
                // JStCMMGetPanalLangHTML('TCNMUser_L'); //โหลดภาษาใหม่
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

//Functionality : Call Page User Add  
//Parameters : Event Button Click Call Function 
//Creator : 04/06/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageUserAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "userPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaUsrBrowseType == 1) {
                    $('#odvModalBody .xCNUsrVMaster').hide();
                    $('#odvModalBody .xCNUsrVBrowse').show();
                } else {
                    $('.xCNUsrVBrowse').hide();
                    $('.xCNUsrVMaster').show();
                    $('#oliUsrTitleEdit').hide();
                    $('#oliUsrTitleAdd').show();
                    $('#odvBtnUsrInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageUser').html(tResult);
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

//Functionality : Call User Page Edit  
//Parameters : Event Button Click Event
//Creator : 04/06/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageUserEdit(ptUsrCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        // JStCMMGetPanalLangSystemHTML('JSvCallPageUserEdit', ptUsrCode);
        $.ajax({
            type: "POST",
            url: "userPageEdit",
            data: { tUsrCode: ptUsrCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#oliUsrTitleAdd').hide();
                    $('#oliUsrTitleEdit').show();
                    $('#odvBtnUsrInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageUser').html(tResult);
                    $('#oetUsrCode').addClass('xCNDisable');
                    $('.xCNiConGen').attr('readonly', true);
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

function JSxUSRCheckDrumpData(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tAgnCode = $('#oetUsrAgnCode').val();
        var tBchCode = $('#oetBranchCode').val();
        var tMerCode = $('#oetUsrMerCode').val();
        var tShpCode = $('#oetShopCode').val();
        var tTitle   = "แจ้งเตือน";

        if(tAgnCode != "" && tBchCode == ""){

            // Last Update : Napat(Jame) 17/08/2020 ปิดการแจ้งเตือน Msg

            // var tMsg = "คุณต้องการสร้างผู้ใช้ให้สามารถเข้าใช้งานได้ทุกสาขาภายไต้ตัวแทนขายที่ได้กำหนดใช่หรือไม่ ?";
            // $('#odvUSRModalAlert .xCNTextModalHeard').html(tTitle);
            // $('#odvUSRModalAlert .modal-body').html(tMsg);
            // $('#odvUSRModalAlert').modal('show');

            // $('#obtUSRModalAlertConfirm').off('click');
            // $('#obtUSRModalAlertConfirm').on('click',function(){
                $('#obtUsrNewAddEdit').click();
            // }); 

        }else if(tBchCode != "" && tMerCode != "" && tShpCode == ""){
            var tMsg = "คุณต้องการสร้างผู้ใช้ให้สามารถเข้าใช้งานได้ทุกร้านค้าภายไต้กลุ่มธุรกิจที่ได้กำหนดใช่หรือไม่ ?";
            $('#odvUSRModalAlert .xCNTextModalHeard').html(tTitle);
            $('#odvUSRModalAlert .modal-body').html(tMsg);
            $('#odvUSRModalAlert').modal('show');

            $('#obtUSRModalAlertConfirm').off('click');
            $('#obtUSRModalAlertConfirm').on('click',function(){
                $('#obtUsrNewAddEdit').click();
            });

        }else{
            $('#obtUsrNewAddEdit').click();
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : (event) Add/Edit User
//Parameters : Form Submit Button
//Creator : 07/06/2018 wasin
//Last Update : 03/11/2020 Napat(Jame) เพิ่ม Validate รหัสสาขา ถ้าหากเป็นผู้ใช้ระดับ Bch และมีสาขามากกว่า 2 สาขา บังคับให้เลือกอย่างน้อย 1 สาขา
//Return : Status Add/Edit Event And Event CallBack
//Return Type : n
function JSnAddEditUser(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddEditUser').validate().destroy();

        $.validator.addMethod('dublicateCode', function(value, element){
            if(ptRoute == "userEventAdd"){
                if($("ohdCheckDuplicateUsrCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        }, '');

        var tSesUsrLoginLevel   = $('#oetUsrLoginLevel').val();
        var tUsrAgnCode         = $('#oetUsrAgnCode').val();
        var tUsrBchCount        = $('#oetUsrBchCount').val();

        $('#ofmAddEditUser').validate({
            rules: {
                oetUsrCode: {
                    "required" : {
                        depends: function(oElement){
                            if(ptRoute == "userEventAdd"){
                                if($('#ocbUserAutoGenCode').is(':checked')){
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
                oetUsrName      : {"required" :{}},
                oetRoleName     : {"required" :{}},
                oetBranchCode   : {
                    "required" : {
                        depends: function(oElement){
                            if( tUsrAgnCode != "" && tSesUsrLoginLevel != "AGN" && tSesUsrLoginLevel != "HQ" && tUsrBchCount > 1 ){
                                return true;
                            }else{
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                oetUsrCode : {
                    "required"      : $('#oetUsrCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetUsrCode').attr('data-validate-dublicateCode')
                },
                oetUsrName : {
                    "required"      : $('#oetUsrName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetUsrName').attr('data-validate-dublicateCode')
                },
                oetRoleName : {
                    "required"      : $('#oetRoleName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetRoleName').attr('data-validate-dublicateCode')
                },
                oetBranchCode : {
                    "required"      : $('#oetBranchCode').attr('data-validate-required'),
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
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
            submitHandler: function(form){
                JCNxOpenLoading();

                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddEditUser').serialize(),
                    success: function(oResult){
                        if(nStaUsrBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageUserEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageUserAdd();
                                        break;
                                    case '3':
                                        JSvCallPageUserList();
                                        break;
                                    default:
                                        JSvCallPageUserEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            }else{
                                alert(aReturn['tStaMessg']);
                                JCNxCloseLoading();
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallBntBackOption);
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

//Functionality : Generate Code User
//Parameters : Event Icon Click
//Creator : 07/06/2018 wasin
//Return : Data
//Return Type : String
function JStGenerateUserCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#oetUsrCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetUsrCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var tTableName = 'TCNMUser';
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
                    $('#oetUsrCode').val(tData.rtUsrCode);
                    $('#oetUsrCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNBtnGenCode').attr('disabled', true);
                } else {
                    $('#oetUsrCode').val(tData.rtDesc);
                }
                JCNxCloseLoading();
                $('#oetDepartName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                (jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Check User Code In DB
//Parameters : Event Enter Input Code
//Creator : 07/06/2018 wasin
//Return : Status,Message
//Return Type : String
function JStCheckUserCode() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        tCode = $('#oetUsrCode').val();
        var tTableName = 'TCNMUser';
        var tFieldName = 'FTUsrCode';
        if (tCode != '') {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: tTableName,
                    tFieldName: tFieldName,
                    tCode: tCode
                },
                cache: false,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    $('.btn-default').attr('disabled', true);
                    if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                        alert('มี id นี้แล้วในระบบ');
                        JSvCallPageUserEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateUserCode();
                    }
                
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    (jqXHR, textStatus, errorThrown);
                }
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Event Delete 
//Parameters : Event Click Button
//Creator : 07/06/2018 wasin
//Return : Status Delete
//Return Type : object
function JSnUserDel(pnPage,ptName,tIDCode,ptConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelUser').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ptConfirm );
            $('#osmConfirm').on('click', function(evt) {
                
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "userEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            $('#odvModalDelUser').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                JSvUserDataTable(pnPage);
                            }, 500);
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                        JSxUSRNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        (jqXHR, textStatus, errorThrown);
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
//Creator : 14/05/2018 wasin
//Return : Status Delete
//Return Type : array
function JSaUserDelChoose(pnPage) {
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
                url: "userEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == '1') {
                        setTimeout(function() {
                            $('#odvModalDelUser').modal('hide');
                            JSvUserDataTable(pnPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                        }, 1000);
                    } else {
                        alert(aReturn['tStaMessg']);
                    }
                    JSxUSRNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    (jqXHR, textStatus, errorThrown);
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
//Parameters : -
//Creator : 04/06/2018 wasin
//Return : View
//Return Type : View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageUser .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageUser .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvUserDataTable(nPageCurrent);
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
//Parameters: Event Select List User
//Creator: 04/06/2018 wasin
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
function JSbUsrIsCreatePage(){
    try{
        const tUsrCode = $('#oetUsrCode').data('is-created');    
        var bStatus = false;
        if(tUsrCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbUsrIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbUsrIsUpdatePage(){
    try{
        const tUsrCode = $('#oetUsrCode').data('is-created');
        var bStatus = false;
        if(!tUsrCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbUsrIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxUsrVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxUsrVisibleComponent Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbUsrIsCreatePage(){
    try{
        const tUsrCode = $('#oetUsrCode').data('is-created');    
        var bStatus = false;
        if(tUsrCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbUsrIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbUsrIsUpdatePage(){
    try{
        const tUsrCode = $('#oetUsrCode').data('is-created');
        var bStatus = false;
        if(!tUsrCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbUsrIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxUsrVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxUsrVisibleComponent Error: ', err);
    }
}





//Functionality : Check User Code In DB
//Parameters : Event Enter Input Code
//Creator : 07/06/2018 wasin
//Return : Status,Message
//Return Type : String
function JStUserRoleNext() {
    var nStaSession = JCNxFuncChkSessionExpired();
    var tHTML = '';
    var nlen = $('.xWCountNum').length;
    if(nlen > 0){
        var nCount = 0;
        var tBase = $('#ohdBaseurl').val();
        $('#otbUrsRoldList').hide();
        $('#otbUrsRoldAll').show();
        $('#oimUsrSend').show();
        $('#oimUsrNext').hide();
        $('#oimAddBrowse').hide();
        $('#oliUsrModal_step1').removeClass( "active" );
        $('#oliUsrModal_step2').addClass( "active" );
        $('#oimUsrBack').attr("disabled", false);
        $('#ohdChkbrowse').val("2");
        $( ".xCNBtnBrowseAddOn" ).each(function() {
            $(this).addClass("disabled");
        });
        $( ".xWCountNum" ).each(function() {
            var nLoop   = $(this).val();
            var nRoleId = $(this).attr("roleid");
            var tAgsID = $(this).attr("AgsID");
            var tBranchID = $(this).attr("BranchID");
            var tMerchantID = $(this).attr("MerchantID");
            var tShopID = $(this).attr("ShopID");
            var nRoleName = $('#otdRoleName'+nRoleId).text();
             tHTML += "<tr><th nowrap='' class='xCNTextBold' colspan='99'>"+nRoleName+"</th></tr>"
            for(ni=1;ni<=nLoop;ni++){
                tHTML += "<tr><td>"+ni+"</td>";
                tHTML += "<td id='otdRoleName'>"+nRoleName+"</td>";
                tHTML += "<td><input type='text' class='form-control' id='oetRoleUsrName["+nCount+"]' maxlength='100' name='oetRoleUsrName["+nCount+"]'></td>"
                tHTML += "<td><input type='email' class='form-control' id='oetRoleUsrEmail' maxlength='100' name='oetRoleUsrEmail["+nCount+"]'></td>"
                tHTML += "<td><div class='input-group'><input class='form-control xCNHide xWAdvanceSeach' type='text' id='oetDepartID["+nCount+"]' name='oetDepartID["+nCount+"]' maxlength='5'>"
                tHTML += "<input class='form-control xCNHide xWAdvanceSeach' type='text' id='oetRoldID["+nCount+"]' name='oetRoldID["+nCount+"]' maxlength='5' value='"+nRoleId+"'>"
                tHTML += "<input class='form-control xCNHide xWAdvanceSeach' type='text' id='oetAgsID["+nCount+"]' name='oetAgsID["+nCount+"]' maxlength='5' value='"+tAgsID+"'>"
                tHTML += "<input class='form-control xCNHide xWAdvanceSeach' type='text' id='oetBranchID["+nCount+"]' name='oetBranchID["+nCount+"]' maxlength='5' value='"+tBranchID+"'>"
                tHTML += "<input class='form-control xCNHide xWAdvanceSeach' type='text' id='oetMerchantID["+nCount+"]' name='oetMerchantID["+nCount+"]' maxlength='5' value='"+tMerchantID+"'>"
                tHTML += "<input class='form-control xCNHide xWAdvanceSeach' type='text' id='oetShopID["+nCount+"]' name='oetShopID["+nCount+"]' maxlength='5' value='"+tShopID+"'>"
                tHTML += "<input type='text' class='form-control xWPointerEventNone xWAdvanceSeach' id='oetDepartName["+nCount+"]' name='oetDepartName["+nCount+"]' maxlength='100' placeholder='' readonly>"
                tHTML += "<span class='input-group-btn'><button id='oimBrowseDepart' type='button' class='btn xWBrowseDepart xCNBtnBrowseAddOn' option='"+nCount+"'>"
                tHTML += "<img src='"+tBase+"/application/modules/common/assets/images/icons/find-24.png'>"
                tHTML += "</button></span></div></td>"
                tHTML += "<td><input type='text' class='form-control' id='oetRoleUsrPhone' maxlength='50' name='oetRoleUsrPhone["+nCount+"]'></td></tr>"
                nCount++;
            }
        });
        $('#otbUrsRoldAll > tbody:last').append(tHTML); 
    }else{
        FSvCMNSetMsgErrorDialog('<p class="text-left">ยังไม่ได้เลือก กลุ่มสิทธิ์</p>');
        JStUserRoleBack() 
    }
}

//Functionality : Check User Code In DB
//Parameters : Event Enter Input Code
//Creator : 07/06/2018 wasin
//Return : Status,Message
//Return Type : String
function JStUserRoleBack() {
    var nStaSession = JCNxFuncChkSessionExpired();
    
    $('#otbUrsRoldList').show();
    $('#odvUrsRoldAll').empty();
    $('#otbUrsRoldAll').hide();
    $('#oimUsrSend').hide();
    $('#oimUsrNext').show();
    $('#oimAddBrowse').show();
    $('#ohdChkbrowse').val("1");
    $('#oimUsrBack').attr("disabled", true);
    $('#oliUsrModal_step1').addClass( "active" );
    $('#oliUsrModal_step2').removeClass( "active" );
    $( ".xCNBtnBrowseAddOn" ).each(function() {
        $(this).removeClass("disabled");
    });
}


//Functionality : Call Excel
//Parameters : Call Excel
//Creator : 15/06/2021 Off
//Return : 
//Return Type : 
function JStUserRoleSend() {
    $("#ofmExportExcel").valid();
    $('#ofmExportExcel').submit();
    $('#odvModalCondition').modal('hide');
    $('.modal-backdrop').remove();
    setTimeout(function() {
        JSvUserDataTable();
    }, 500);
};

//Functionality : Export Excel UserLogin
//Parameters : Export Excel UserLogin
//Creator : 27/08/2021 Off
//Return : 
//Return Type : 
function JStUserExportMulti() {
    $("#ofmExportExcelUsr").valid();
    $('#ofmExportExcelUsr').submit();
    $('#odvModalCondition').modal('hide');
    $('.modal-backdrop').remove();
    setTimeout(function() {
        JSvUserDataTable();
    }, 500);
};


$(document).on("click", ".xCNIconDelRow", function(e) {
    $(this).parent().parent().empty();
    var nCount = 1;
    $( ".xWcount" ).each(function() {
        $(this).text(nCount);
        nCount++;
    });
});