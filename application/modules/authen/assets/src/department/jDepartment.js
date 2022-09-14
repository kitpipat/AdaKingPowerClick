var nStaDptBrowseType   = $('#oetDptStaBrowse').val();
var tCallDptBackOption  = $('#oetDptCallBackOption').val();

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxDptNavDefult();
    if(nStaDptBrowseType != 1){
        JSvCallPageDptList(1);
    }else{
        JSvCallPageDptAdd();
    }
});

//function : Function Clear Defult Button Product Brand
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxDptNavDefult(){
    if(nStaDptBrowseType != 1 || nStaDptBrowseType == undefined){
        $('.xCNChoose').hide();
        $('#oliDptTitleAdd').hide();
        $('#oliDptTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnDptInfo').show();
    }else{
        $('#odvModalBody #odvDptMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliDptNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvDptBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNDptBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNDptBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Product Brand Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageDptList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageDptList';
        $('#oetSearchDpt').val('');
        JCNxOpenLoading();    
        $.ajax({
            type: "POST",
            url: "departmentList",
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageDpt').html(tResult);
                JSvDptDataTable(pnPage);
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
function JSvDptDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll      = $('#oetSearchDpt').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        $.ajax({
            type: "POST",
            url: "departmentDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataDpt').html(tResult);
                }
                JSxDptNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
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
function JSvCallPageDptAdd(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "departmentPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if (nStaDptBrowseType == 1) {
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                }else{
                    $('#oliDptTitleEdit').hide();
                    $('#oliDptTitleAdd').show();
                    $('#odvBtnDptInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageDpt').html(tResult);
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
function JSvCallPageDptEdit(ptDptCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageDptEdit',ptDptCode);
        $.ajax({
            type: "POST",
            url: "departmentPageEdit",
            data: { tDptCode: ptDptCode },
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliDptTitleAdd').hide();
                    $('#oliDptTitleEdit').show();
                    $('#odvBtnDptInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageDpt').html(tResult);
                    $('#oetDptCode').addClass('xCNDisable');
                    $('#oetDptCode').attr('readonly', true);
                    $('#obtGenCodeDpt').attr('disabled', true);
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

//Functionality : Event Add/Edit Product Brand
//Parameters : From Submit
//Creator : 17/10/2018 witsarut
//Return : Status Event Add/Edit Product Brand
//Return Type : object
function JSoAddEditDpt(ptRoute){
    // alert(ptRoute);
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddEditDepartment').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "departmentEventAdd"){
                if($("#ohdCheckDuplicateDptCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddEditDepartment').validate({
            rules: {
                oetDptCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "departmentEventAdd"){
                                if($('#ocbDepartmentAutoGenCode').is(':checked')){
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
                oetDptName: {"required" :{}},
            },
            messages: {
                oetDptCode : {
                    "required"      : $('#oetDptCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetDptCode').attr('data-validate-dublicateCode')
                },
                oetDptName : {
                    "required"      : $('#oetDptName').attr('data-validate-required'),
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
                    data: $('#ofmAddEditDepartment').serialize(),
                    success: function(oResult){
                        if(nStaDptBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageDptEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageDptAdd();
                                        break;
                                    case '3':
                                        JSvCallPageDptList();
                                        break;
                                    default:
                                        JSvCallPageDptEdit(aReturn['tCodeReturn']);
                                }
                            }else{
                                alert(aReturn['tStaMessg']);
                               
                                JSvCallPageDptList(); 
                                JCNxCloseLoading();
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallDptBackOption);
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

//Functionality : Generate Code Product Brand
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : Event Push Value In Input
//Return Type : -
function JStGenerateDptCode(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#oetDptCode').closest('.form-group').addClass( "has-success" ).removeClass( "has-error");
        $('#oetDptCode').closest('.form-group').find(".help-block").fadeOut('slow').remove();
        var tTableName = 'TCNMUsrDepart';
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
                    $('#oetDptCode').val(tData.rtDptCode);
                    $('#oetDptCode').addClass('xCNDisable');
                    $('#oetDptCode').attr('readonly', true);
                    $('#obtGenCodeDpt').attr('disabled', true); //เปลี่ยน Class ใหม่
                    $('#oetDptName').focus();
                } else {
                    $('#oetDptCode').val(tData.rtDesc);
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

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoDptDel(pnPage,ptName,tIDCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        if (aDataSplitlength == '1'){
            $('#odvModalDelDpt').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() +' ' + tIDCode + ' ( ' + ptName + ' )'+' ?');
            $('#osmConfirm').on('click', function(evt){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "departmentEventDelete",
                    data: { 'tIDCode': tIDCode },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == 1){
                            $('#odvModalDelDpt').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                if(aReturn["nNumRowDptLoc"]!= 0){
                                    if(aReturn["nNumRowDptLoc"]> 10){
                                        nNumPage = Math.ceil(aReturn["nNumRowDptLoc"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPageDptList(pnPage);
                                        }else{
                                            JSvCallPageDptList(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageDptList(1);
                                    }
                                }else{
                                    JSvCallPageDptList(1);
                                }

                                // JSvDptDataTable(pnPage);
                            }, 500);
                        }else{
                            alert(aReturn['tStaMessg']);                        
                        }
                        JSxDptNavDefult();
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
function JSoDptDelChoose(pnPage){
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
                url: "departmentEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function() {
                            $('#odvModalDelDpt').modal('hide');
                            JSvDptDataTable(pnPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();

                            if(aReturn["nNumRowDptLoc"]!= 0){
                                if(aReturn["nNumRowDptLoc"]> 10){
                                    nNumPage = Math.ceil(aReturn["nNumRowDptLoc"]/10);
                                    if(pnPage<=nNumPage){
                                        JSvCallPageDptList(pnPage);
                                    }else{
                                        JSvCallPageDptList(nNumPage);
                                    }
                                }else{
                                    JSvCallPageDptList(1);
                                }
                            }else{
                                JSvCallPageDptList(1);
                            }
                        },1000);
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                    JSxDptNavDefult();
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
function JSvDptClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageDpt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageDpt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvDptDataTable(nPageCurrent);
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


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbDepartmentIsCreatePage(){
    try{
        const tDptCode = $('#oetDptCode').data('is-created');    
        var bStatus = false;
        if(tDptCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbDepartmentIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbDepartmentIsUpdatePage(){
    try{
        const tDptCode = $('#oetDptCode').data('is-created');
        var bStatus = false;
        if(!tDptCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbDepartmentIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxDepartmentVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxDepartmentVisibleComponent Error: ', err);
    }
}