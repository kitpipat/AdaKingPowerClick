var nStaCstTypeBrowseType   = $('#oetCstTypeStaBrowse').val();
var tCallCstTypeBackOption  = $('#oetCstTypeCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCstTypeNavDefult();
    if (nStaCstTypeBrowseType != 1) {
        JSvCallPageCstType();
    } else {
        JSvCallPageCstTypeAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueCstTypeCode;
$.validator.addMethod(
    "uniqueCstTypeCode", 
    function(tValue, oElement, aParams) {
        let tCstTypeCode = tValue;
        $.ajax({
            type: "POST",
            url: "customerTypeUniqueValidate/CstTypeCode",
            data: "tCstTypeCode=" + tCstTypeCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueCstTypeCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueCstTypeCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueCstTypeCode;
    },
    "Vat Code is Already Taken"
);

// Override Error Message
jQuery.extend(jQuery.validator.messages, {
    required: "This field is required.",
    remote: "Please fix this field.",
    email: "Please enter a valid email address.",
    url: "Please enter a valid URL.",
    date: "Please enter a valid date.",
    dateISO: "Please enter a valid date (ISO).",
    number: "Please enter a valid number.",
    digits: "Please enter only digits.",
    creditcard: "Please enter a valid credit card number.",
    equalTo: "Please enter the same value again.",
    accept: "Please enter a value with a valid extension.",
    maxlength: jQuery.validator.format("Please enter no more than {0} characters."),
    minlength: jQuery.validator.format("Please enter at least {0} characters."),
    rangelength: jQuery.validator.format("Please enter a value between {0} and {1} characters long."),
    range: jQuery.validator.format("Please enter a value between {0} and {1}."),
    max: jQuery.validator.format("Please enter a value less than or equal to {0}."),
    min: jQuery.validator.format("Please enter a value greater than or equal to {0}.")
});

/*============================= End Custom Form Validate =====================*/

/*============================= Begin Form Validate ==========================*/

/**
 * Functionality : (event) Add/Edit CstType
 * Parameters : ptRoute is route to add Customer Type data.
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditCstType(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddCstType').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "customerTypeEventAdd") {
                if ($("#ohdCheckDuplicateCstTypeCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');
        $('#ofmAddCstType').validate({
            rules: {
                oetCstTypeCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "customerTypeEventAdd") {
                                if ($('#ocbCstTypeAutoGenCode').is(':checked')) {
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

                oetCstTypeName: {"required" :{}},
            },
            messages: {
                oetCstTypeCode : {
                    "required"      : $('#oetCstTypeCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCstTypeCode').attr('data-validate-dublicateCode')
                },
                oetCstTypeName : {
                    "required"      : $('#oetCstTypeName').attr('data-validate-required'),
                },
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
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function(form) {

            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddCstType').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCstTypeBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageCstTypeEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageCstTypeAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageCstType();
                            }
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxBrowseData(tCallCstTypeBackOption);
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
/*============================= End Form Validate ============================*/

/**
 * Functionality : Function Clear Defult Button CstType
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCstTypeNavDefult() {
    try{
        if(nStaCstTypeBrowseType != 1 || nStaCstTypeBrowseType == undefined) {
            $('.obtChoose').hide();
            $('#oliCstTypeTitleAdd').hide();
            $('#oliCstTypeTitleEdit').hide();
            $('#odvCstTypeMainMenu #odvBtnAddEdit').hide();
            $('#odvCstTypeMainMenu #odvBtnCstTypeInfo').show();
        }else{
            $('#odvModalBody #odvCstTypeMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCstTypeNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCstTypeBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNPosEdcBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNPosEdcBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCstTypeNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    try{
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
    }catch(err){
        console.log('JCNxResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CstType Page list
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstType() {
    try{
        localStorage.tStaPageNow = 'JSvCallPageCstTypeList';

        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "customerTypeList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCstType').html(tResult);
                JSvCstTypeDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstType Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCstTypeDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerTypeDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCstType').html(tResult);
                }
                JSxCstTypeNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCstTypeDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CstType Page Add
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstTypeAdd() {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "customerTypePageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if(nStaCstTypeBrowseType == 1) {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(tResult);
                } else {
                    $('#odvCstTypeMainMenu #oliCstTypeTitleEdit').hide();
                    $('#odvCstTypeMainMenu #odvBtnCstTypeInfo').hide();
                    $('#odvCstTypeMainMenu #oliCstTypeTitleAdd').show();
                    $('#odvCstTypeMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageCstType').html(tResult);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstTypeAdd Error: ', err);
    }
}

/**
 * Functionality : Call CstType Page Edit
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstTypeEdit(ptCstTypeCode) {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCstTypeEdit', ptCstTypeCode);
        $.ajax({
            type: "POST",
            url: "customerTypePageEdit",
            data: { tCstTypeCode: ptCstTypeCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliCstTypeTitleAdd').hide();
                    $('#odvBtnCstTypeInfo').hide();
                    $('#oliCstTypeTitleEdit').show();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCstType').html(tResult);
                    $('#oetCstTypeCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstTypeEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CstType
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateCstTypeCode(poElement, poEvent) {
    try{
        var tTableName = 'TCNMCstType';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetCstTypeCode').val(tData.rtCtyCode);
                    $('#oetCstTypeCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $(poElement).attr('disabled', true);
                } else {
                    $('#oetCstTypeCode').val(tData.rtDesc);
                }
                $('#oetCstTypeName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JStGenerateCstTypeCode Error: ', err);
    }
}

/**
 * Functionality : Check CstType Code In DB
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckCstTypeCode() {
    try{
        var tCode = $('#oetCstTypeCode').val();
        var tTableName = 'TCNMCstType';
        var tFieldName = 'FTCgpCode';
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
                        JSvCallPageCstTypeEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateCstTypeCode();
                    }
                    $('.wrap-input100').removeClass('alert-validate');
                    $('.btn-default').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }catch(err){
        console.log('JStCheckCstTypeCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += '';
        });
        var tConfirm =$('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm + tValue .replace(/, $/,""));
    }catch(err){
        console.log('JSxSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCstTypeDelete(poElement = null, poEvent = null){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCstType').find('td.otdCstTypeCode').text();
        var tValueName = $(poElement).parents('tr.otrCstType').find('td.otdCstTypeName').text();
        var tConfirm =$('#ohdDeleteconfirm').val();
        var tConfirmYN =$('#ohdDeleteconfirmYN').val();
        $('#ospConfirmDelete').text(tConfirm +' ' + tValue+' ('+tValueName+')'+ tConfirmYN);
        $('#ospCode').val(tValue);
        if(nCheckedCount <= 1){
            $('#odvModalDelCstType').modal('show');
        }
    }catch(err){
        console.log('JSaCstTypeDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCstTypeDelChoose(){
    try{
        JCNxOpenLoading();

        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){ // For mutiple delete

            var oChecked = $('#odvRGPList td input:checked');
            var aCstTypeCode = [];
            $(oChecked).each( function(pnIndex){
                aCstTypeCode[pnIndex] = $(this).parents('tr.otrCstType').find('td.otdCstTypeCode').text();
            });

            $.ajax({
                type: "POST",
                url: "customerTypeDeleteMulti",
                data: {tCstTypeCode: JSON.stringify(aCstTypeCode)},
                success: function(tResult) {
                    $('#odvModalDelCstType').modal('hide');
                    JSvCstTypeDataTable();
                    JSxCstTypeNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else{ // For single delete

            var tCstTypeCode = $('#ospCode').val();
            
            $.ajax({
                type: "POST",
                url: "customerTypeDelete",
                data: {tCstTypeCode: tCstTypeCode},
                success: function(tResult) {
                    $('#odvModalDelCstType').modal('hide');
                    JSvCstTypeDataTable();
                    JSxCstTypeNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }catch(err){
        console.log('JSnCstTypeDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSCstTypevClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageCstType .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageCstType .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvCstTypeDataTable(nPageCurrent);
    }catch(err){
        console.log('JSCstTypevClickPage Error: ', err);
    }
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNIsCreatePage(){
    try{
        const tCstTypeCode = $('#oetCstTypeCode').data('is-created');
        var bStatus = false;
        if(tCstTypeCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 26/09/2018 piya
 * Last Modified : -
 * Return : Status true is update page
 * Return Type : Boolean
 */
function JCNbCstTypeIsUpdatePage(){
    try{
        const tVCode = $('#oetCstTypeCode').data('is-created');
        let bStatus = false;
        if(tVCode != ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JJCNbCstTypeIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxVisibledDelAllBtn Error: ', err);
    }
}


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 08/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerTypeIsCreatePage(){
    try{
        const tCstTypeCode = $('#oetCstTypeCode').data('is-created');    
        var bStatus = false;
        if(tCstTypeCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerTypeIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerTypeIsUpdatePage(){
    try{
        const tCstTypeCode = $('#oetCstTypeCode').data('is-created');
        var bStatus = false;
        if(!tCstTypeCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerTypeIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCustomerTypeVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCustomerTypeVisibleComponent Error: ', err);
    }
}
