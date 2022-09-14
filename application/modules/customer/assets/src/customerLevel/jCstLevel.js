var nStaCstLevBrowseType    = $('#oetCstLevStaBrowse').val();
var tCallCstLevBackOption   = $('#oetCstLevCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCstLevNavDefult();
    if (nStaCstLevBrowseType != 1) {
        JSvCallPageCstLev();
    } else {
        JSvCallPageCstLevAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueCstLevCode;
$.validator.addMethod(
    "uniqueCstLevCode", 
    function(tValue, oElement, aParams) {
        let tCstLevCode = tValue;
        $.ajax({
            type: "POST",
            url: "customerLevelUniqueValidate/CstLevCode",
            data: "tCstLevCode=" + tCstLevCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueCstLevCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueCstLevCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueCstLevCode;
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
 * Functionality : (event) Add/Edit CstLev
 * Parameters : ptRoute is route to add Customer Level data.
 * Creator : 08/05/2019 saharat(Golf)
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditCstLev(ptRoute) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCstLev').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "customerLevelEventAdd"){
                if($("#ohdCheckDuplicateCstLevCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddCstLev').validate({
            rules: {
                oetCstLevCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "customerLevelEventAdd"){
                                if($('#ocbCustomerLevelAutoGenCode').is(':checked')){
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
                oetCstLevName: {"required" :{}},
            },
            messages: {
                oetCstLevCode : {
                    "required"      : $('#oetCstLevCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCstLevCode').attr('data-validate-dublicateCode')
                },
                oetCstLevName : {
                    "required"      : $('#oetCstLevName').attr('data-validate-required'),
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
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddCstLev').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCstLevBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageCstLevEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageCstLevAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageCstLev();
                            }
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxBrowseData(tCallCstLevBackOption);
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
 * Functionality : Function Clear Defult Button CstLev
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCstLevNavDefult() {
    try{
        if (nStaCstLevBrowseType != 1 || nStaCstLevBrowseType == undefined) {
            $('.obtChoose').hide();
            $('#oliCstLevTitleAdd').hide();
            $('#oliCstLevTitleEdit').hide();
            $('#odvCstLevMainMenu #odvBtnAddEdit').hide();
            $('#odvCstLevMainMenu #odvBtnCstLevInfo').show();
        } else {
            $('#odvModalBody #odvCstLevMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCstLevNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCstLevBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCstLevBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCstLevBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCstLevNavDefult Error: ', err);
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
 * Functionality : Call CstLev Page list
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstLev() {
    try{
        localStorage.tStaPageNow = 'JSvCallPageCstLevList';

        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "customerLevelList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCstLev').html(tResult);
                JSvCstLevDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstLev Error: ', err);
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
function JSvCstLevDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerLevelDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCstLev').html(tResult);
                }
                JSxCstLevNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCstLevDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CstLev Page Add
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstLevAdd() {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "customerLevelPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if(nStaCstLevBrowseType == 1) {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(tResult);
                }else{
                    $('#odvCstLevMainMenu #oliCstLevTitleEdit').hide();
                    $('#odvCstLevMainMenu #odvBtnCstLevInfo').hide();
                    $('#odvCstLevMainMenu #oliCstLevTitleAdd').show();
                    $('#odvCstLevMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageCstLev').html(tResult);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstLevAdd Error: ', err);
    }
}

/**
 * Functionality : Call CstLev Page Edit
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstLevEdit(ptCstLevCode) {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCstLevEdit', ptCstLevCode);

        $.ajax({
            type: "POST",
            url: "customerLevelPageEdit",
            data: { tCstLevCode: ptCstLevCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#odvCstLevMainMenu #oliCstLevTitleAdd').hide();
                    $('#odvCstLevMainMenu #odvBtnCstLevInfo').hide();
                    $('#odvCstLevMainMenu #oliCstLevTitleEdit').show();
                    $('#odvCstLevMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageCstLev').html(tResult);
                    $('#oetCstLevCode').addClass('xCNDisable');
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
        console.log('JSvCallPageCstLevEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CstLev
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateCstLevCode() {
    try{
        var tTableName = 'TCNMCstLev';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetCstLevCode').val(tData.rtClvCode);
                    $('#oetCstLevCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNiConGen').attr('disabled', true);
                } else {
                    $('#oetCstLevCode').val(tData.rtDesc);
                }
                $('#oetCstLevName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JStGenerateCstLevCode Error: ', err);
    }
}

/**
 * Functionality : Check CstLev Code In DB
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckCstLevCode() {
    try{
        var tCode = $('#oetCstLevCode').val();
        var tTableName = 'TCNMCstLev';
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
                        JSvCallPageCstLevEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateCstLevCode();
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
        console.log('JStCheckCstLevCode Error: ', err);
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
function JSxCstLevSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            // tValue += $(this).parents('tr.otrCstLev').find('td.otdCstLevCode').text() + ', ';
            tValue += '';
        });
        var tConfirm =$('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm + tValue);
    }catch(err){
        console.log('JSxCstLevSetDataBeforeDelMulti Error: ', err);
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
function JSaCstLevDelete(poElement = null, poEvent = null){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCstLev').find('td.otdCstLevCode').text();
        var tValueName = $(poElement).parents('tr.otrCstLev').find('td.otdCstLevName').text();
        var tConfirm =$('#ohdDeleteconfirm').val();
        var tConfirmYN =$('#ohdDeleteconfirmYN').val();
        $('#ospConfirmDelete').text(tConfirm +' ' + tValue+' ('+tValueName+')'+ tConfirmYN);
        $('#ospCode').val(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCstLev').modal('show');
        }
    }catch(err){
        console.log('JSaCstLevDelete Error: ', err);
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
function JSnCstLevDelChoose(){
    try{
        JCNxOpenLoading();

        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){ // For mutiple delete

            var oChecked = $('#odvRGPList td input:checked');
            var aCstLevCode = [];
            $(oChecked).each( function(pnIndex){
                aCstLevCode[pnIndex] = $(this).parents('tr.otrCstLev').find('td.otdCstLevCode').text();
            });

            $.ajax({
                type: "POST",
                url: "customerLevelDeleteMulti",
                data: {tCstLevCode: JSON.stringify(aCstLevCode)},
                success: function(tResult) {
                    $('#odvModalDelCstLev').modal('hide');
                    JSvCstLevDataTable();
                    JSxCstLevNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else{ // For single delete

            var tCstLevCode = $('#ospCode').val();

            $.ajax({
                type: "POST",
                url: "customerLevelDelete",
                data: {tCstLevCode: tCstLevCode},
                success: function(tResult) {
                    $('#odvModalDelCstLev').modal('hide');
                    JSvCstLevDataTable();
                    JSxCstLevNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }catch(err){
        console.log('JSnCstLevDelChoose Error: ', err);
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
function JSvCstLevClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.pagination .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.pagination .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvCstLevDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCstLevClickPage Error: ', err);
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
function JCNCstLevIsCreatePage(){
    try{
        const tCstLevCode = $('#oetCstLevCode').data('is-created');
        var bStatus = false;
        if(tCstLevCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNCstLevIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 24/10/2018 piya
 * Last Modified : -
 * Return : Status true is update page
 * Return Type : Boolean
 */
function JCNCstLevIsUpdatePage(){
    try{
        const tCstLevCode = $('#oetCstLevCode').data('is-created');
        var bStatus = false;
        if(tCstLevCode != ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNCstLevIsCreatePage Error: ', err);
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
function JSxCstLevVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCstLevVisibledDelAllBtn Error: ', err);
    }
}


// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 08/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerLevelIsCreatePage(){
    try{
        const tCstLevCode = $('#oetCstLevCode').data('is-created');    
        var bStatus = false;
        if(tCstLevCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerLevelIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 08/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerLevelIsUpdatePage(){
    try{
        const tCstLevCode = $('#oetCstLevCode').data('is-created');
        var bStatus = false;
        if(!tCstLevCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerLevelIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 05/05/2019 saharat (Golf)
// Return : -
// Return Type : -
function JSxCustomerLevelVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCustomerLevelVisibleComponent Error: ', err);
    }
}