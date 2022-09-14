var nStaVocBrowseType = $('#oetVocStaBrowse').val();
var tCallVocBackOption = $('#oetVocCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCPTNavDefult();

    if (nStaVocBrowseType != 1) {
        JSvCallPageCouponTypeList();
    } else {
        JSvCallPageCoupontypeAdd();
    }
});

function JSxCPTNavDefult() {
    if (nStaVocBrowseType != 1 || nStaVocBrowseType == undefined) {
        $('.xCNVocVBrowse').hide();
        $('.xCNVocVMaster').show();
        $('#oliVocTitleAdd').hide();
        $('#oliVocTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('.obtChoose').hide();
        $('#odvBtnVocInfo').show();
    } else {
        $('#odvModalBody .xCNVocVMaster').hide();
        $('#odvModalBody .xCNVocVBrowse').show();
        $('#odvModalBody #odvVocMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliVocNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvVocBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNVocBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNVocBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 19/12/2019 Witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    JCNxCloseLoading();
    var tHtmlError = $(jqXHR.responseText);
    var tMsgError = "<h3 style='font-size:20px;color:red'>";
    tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
    tMsgError += " Error<hr></h3>";
    switch (jqXHR.status) {
        case 404:
            tMsgError += tHtmlError.find('p:nth-child(2)').text();
            break;
        case 500:
            tMsgError += tHtmlError.find('p:nth-child(3)').text();
            break;

        default:
            tMsgError += 'something had error. please contact admin';
            break;
    }
    $("body").append(tModal);
    $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
    $('#myModal').modal({ show: true });
    $('#odvModalBody').html(tMsgError);
}



//Functionality : (event) Add/Edit Voucher
//Parameters : form
//Creator : 19/12/2019 Witsarut
//Return : Status Add
//Return Type : n
function JSnAddEditCoutype(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCoupontype').validate().destroy();

        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "CoupontypeEventAdd"){
                if($("#ohdCheckDuplicateCptCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        
        $('#ofmAddCoupontype').validate({
            rules: {
                oetCptCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "CoupontypeEventAdd"){
                                if($('#ocbCoupontypeAutoGenCode').is(':checked')){
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
                oetCptName: { "required": {} }
            },
            messages: {
                oetCptCode : {
                    "required"      : $('#oetCptCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCptCode').attr('data-validate-dublicateCode')
                },
                oetCptName : {
                    "required"      : $('#oetCptName').attr('data-validate-required'),
                }
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
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddCoupontype').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaVocBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageCoupontypeTypeEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageCoupontypeAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageCouponTypeList();
                            }
                        } else {
                            // alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxBrowseData(tCallVocBackOption);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
    });
}
}

///function : Call Reason Page list  
//Parameters : - 
//Creator:	08/05/2018 Witsarut
//Update:   -
//Return : View
//Return Type : View
function JSvCallPageCouponTypeList() {

    localStorage.tStaPageNow = 'JSvCallPageCouponTypeList';

    $.ajax({
        type: "GET",
        url: "CoupontypeFormSearchList",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            $('#odvContentPageCoupontype').html(tResult);
            JSxCPTNavDefult();
            JSvCallPageCouponTypeDataTable(); //แสดงข้อมูลใน List
        },
        error: function(data) {
            console.log(data);
        }
    });
}


///function : Call Rack Data List
//Parameters : Ajax Success Event 
//Creator:	20/12/2019 Witsarut(Bell)
//Update:  - 
//Return : View
//Return Type : View
function JSvCallPageCouponTypeDataTable(pnPage) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        $.ajax({
            type: "POST",
            url: "CoupontypeDataTable",
            data: {            
                    tSearchAll: tSearchAll,
                    nPageCurrent: nPageCurrent
                },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if(tResult != ""){
                    $('#odvContentPageCoupontypeData').html(tResult);
                }
                JSxCPTNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TFNMCouponType_L'); //โหลดภาษาใหม่
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

//Functionality : Call Credit Page Edit  
//Parameters : -
//Creator : 19/12/2019 Witsarut
//Return : View
//Return Type : View
function JSvCallPageCoupontypeAdd() {
    $.ajax({
        type: "GET",
        url: "CoupontypePageAdd",
        data: {},
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            if (nStaVocBrowseType == 1) {
                // $('.xCNVocVMaster').hide();
                // $('.xCNVocVBrowse').show();
                $("#odvModalBodyBrowse").html(tResult);
                $("#odvModalBodyBrowse .panel-body").css("padding-top", "0");
            } else {
                $('.xCNVocVBrowse').hide();
                $('.xCNVocVMaster').show();
                $('#oliVocTitleEdit').hide();
                $('#oliVocTitleAdd').show();
                $('#odvBtnVocInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#obtBarSubmitVoc').show();

            $('#odvContentPageCoupontype').html(tResult);
        },
        error: function(data) {
            console.log(data);
        }
    });
}


//Functionality : Call Credit Page Edit
//Parameters : -
//Creator : 19/12/2019 Witsarut
//Return : View
//Return Type : View
function JSvCallPageCoupontypeTypeEdit(ptCptCode){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1 ){

        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCoupontypeTypeEdit', ptCptCode);
        $.ajax({
            type: "POST",
            url: "CoupontypePageEdit",
            data: { tCptCode : ptCptCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliVocTitleAdd').hide();
                    $('#oliVocTitleEdit').show();
                    $('#odvBtnVocInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCoupontype').html(tResult);
                    $('#oetCptCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    $('.xCNiConGen').hide();
                    $('#obtGenCodeVoc').attr('disabled', true);
                }
    
                // Control หน้า edit ทั้งหมดจะแก้ไขไม่ได้
                // if ($('#ohdVocAutStaEdit').val() == 0) {
                //     $('#obtBarSubmitVoc').hide();
                //     $('.xCNUplodeImage').hide();
                //     $('.xCNIconBrowse').hide();
                //     $("select").prop('disabled', true);
                //     $('input').attr('disabled', true);
                // }else{
                    
                //     $('#obtBarSubmitVoc').show();
                //     $('.xCNUplodeImage').show();
                //     $('.xCNIconBrowse').show();
                //     $("select").prop('disabled', false);
                //     $('input').attr('disabled', false);
                // }
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



//Functionality : gen code Branch
//Parameters : -
//Creator : 19/12/2019 Witsarut
//Return : Data
//Return Type : String
function JStBCHGenerateVoucherCode() {

    JCNxOpenLoading();

    var tTableName = 'TFNMVoucher';
    $.ajax({
        type: "POST",
        url: "generateCode",
        data: { tTableName: tTableName },
        cache: false,
        success: function(tResult) {

            var tData = $.parseJSON(tResult);
            if (tData.rtCode == '1') {
                $('#oetVotCode').val(tData.rtVocCode);

                $('.xCNDisable').attr('readonly', true);
                $('#oetVotCode').addClass('xCNDisable');
                $('.xCNDisable').attr('readonly', true);

                //ปุ่ม Gen
                $('.xCNiConGen').css('display', 'none');

            } else {
                $('#oetVotCode').val(tData.rtDesc);
            }
            JCNxCloseLoading();
            $('#oetVocName').focus();
        },
        error: function(data) {
            console.log(data);
        }
    });
}


// //Functionality : (event) Delete
// //Parameters : tIDCode รหัส Voucher
// //Creator :19/12/2019 Witsarut
// //Return : 
//Return Type : Status Number
function JSnCoupontypeDel(pnPage,ptName,tIDCode) {
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;
    var aNewIdDelete = [];

    if (aDataSplitlength == '1') {
        $('#odvModalDelVoucher').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ');
        $('#osmConfirm').on('click', function(evt) {

            if (localStorage.StaDeleteArray != '1') {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "CoupontypeEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult) {
                        tResult = tResult.trim();
                        var tData = $.parseJSON(tResult);
                        if (tData['nStaEvent'] == '1'){
                            $('#odvModalDelVoucher').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            setTimeout(function(){
                                if(tData["nNumRowCouponType"]!=0){
                                    if(tData["nNumRowCouponType"]>10){
                                        nNumPage = Math.ceil(tData["nNumRowCouponType"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvCallPageCouponTypeDataTable(pnPage);
                                        }else{
                                            JSvCallPageCouponTypeDataTable(nNumPage)
                                        }
                                    }else{
                                        JSvCallPageCouponTypeDataTable(1)
                                    }
                                }else{
                                    JSvCallPageCouponTypeDataTable(1)
                                }
                            },500);
                        }else{
                            JCNxCloseLoading();
                            alert(tData['tStaMessg']);  
                        }
                        JSxCPTNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }

}


//Functionality : (event) Delete All
//Parameters :
//Creator : 04/07/2018 Krit
//Return : 
//Return Type :
function JSnCoupontypeDelChoose(pnPage) {
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
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "CoupontypeEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                tResult = tResult.trim();
                var tData = JSON.parse(tResult);
                if (tData['nStaEvent'] == '1'){
                    $('#odvModalDelVoucher').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(tData["nNumRowCouponType"]!=0){
                            if(tData["nNumRowCouponType"]>10){
                                nNumPage = Math.ceil(tData["nNumRowCouponType"]/10);
                                if(pnPage<=nNumPage){
                                    JSvCallPageCouponTypeDataTable(pnPage);
                                }else{
                                    JSvCallPageCouponTypeDataTable(nNumPage)
                                }
                            }else{
                                JSvCallPageCouponTypeDataTable(1)
                            }
                        }else{
                            JSvCallPageCouponTypeDataTable(1)
                        }
                    }, 500);
                }else{
                    JCNxCloseLoading();
                    alert(aReturn['tStaMessg']); 
                }
                JSxCPTNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        localStorage.StaDeleteArray = '0';

        return false;
    }
}


// //Functionality : เปลี่ยนหน้า pagenation
// //Parameters : -
// //Creator : 02/07/2018 Krit(Copter)
// //Return : View
// //Return Type : View
function JSvVOCClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvCallPageCouponTypeDataTable(nPageCurrent);
}



//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
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
//Creator: 15/05/2018 wasin
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
//Parameters: Event Select List Branch
//Creator: 06/06/2018 Krit
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

//Functionality: Search Voucher List
//Parameters: tSearchAll = ข้อความที่ใช้ค้นหา , nPageCurrent = 1
//Creator: 15/01/2019 Jame
//Return: View
//Return Type: View
function JSvSearchAllCoupontype() {
    var tSearchAll = $('#oetSearchAll').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "CoupontypeDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: 1
        },
        cache: false,
        Timeout: 0,
        success: function(tResult) {

            if (tResult != "") {
                $('#odvContentPageCoupontypeData').html(tResult);
            }
            
            JSxCPTNavDefult();
            JCNxLayoutControll();
            JStCMMGetPanalLangHTML('TFNMCouponType_L'); //โหลดภาษาใหม่
            JCNxCloseLoading();
        },
        error: function(data) {
            console.log(data);
        }
    });
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCoupontypeIsCreatePage(){
    try{
        const tVotCodeCode = $('#oetCptCode').data('is-created');    
        var bStatus = false;
        if(tVotCodeCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCoupontypeIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCoupontypeIsUpdatePage(){
    try{
        const tVotCode = $('#oetCptCode').data('is-created');
        var bStatus = false;
        if(!tVotCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCoupontypeIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCoupontypeVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCoupontypeVisibleComponent Error: ', err);
    }
}
