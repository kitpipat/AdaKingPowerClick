var nStaCstOcpBrowseType    = $('#oetCstOcpStaBrowse').val();
var tCallCstOcpBackOption   = $('#oetCstOcpCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCstOcpNavDefult();
    if (nStaCstOcpBrowseType != 1) {
        JSvCallPageCstOcp();
    } else {
        JSvCallPageCstOcpAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueCstOcpCode;
$.validator.addMethod(
    "uniqueCstOcpCode", 
    function(tValue, oElement, aParams) {
        let tCstOcpCode = tValue;
        $.ajax({
            type: "POST",
            url: "customerOcpUniqueValidate/CstOcpCode",
            data: "tCstOcpCode=" + tCstOcpCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueCstOcpCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueCstOcpCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueCstOcpCode;
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
 * Functionality : (event) Add/Edit CstOcp
 * Parameters : ptRoute is route to add Customer Ocp data.
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditCstOcp(ptRoute) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCstOcp').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "customerOcpEventAdd"){
                if($("#ohdCheckDuplicateCstOcpCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddCstOcp').validate({
            rules: {
                oetCstOcpCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "customerOcpEventAdd"){
                                if($('#ocbCstOcpAutoGenCode').is(':checked')){
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
                oetCstOcpName: {"required" :{}},
            },
            messages: {
                oetCstOcpCode : {
                    "required"      : $('#oetCstOcpCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCstOcpCode').attr('data-validate-dublicateCode')
                },
                oetCstOcpName : {
                    "required"      : $('#oetCstOcpName').attr('data-validate-required'),
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
                data: $('#ofmAddCstOcp').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCstOcpBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageCstOcpEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageCstOcpAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageCstOcp();
                            }
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxBrowseData(tCallCstOcpBackOption);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        },
        errorPlacement: function(error, element) {
            $(element).parent('.validate-input').attr('data-validate', error[0].textContent);
            }
        });
    }
}

/*============================= End Form Validate ============================*/

/**
 * Functionality : Function Clear Defult Button CstOcp
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCstOcpNavDefult() {
    try{
        if(nStaCstOcpBrowseType != 1 || nStaCstOcpBrowseType == undefined) {
            $('.obtChoose').hide();
            $('#odvCstOcpMainMenu #oliCstOcpTitleAdd').hide();
            $('#odvCstOcpMainMenu #oliCstOcpTitleEdit').hide();
            $('#odvCstOcpMainMenu #odvBtnAddEdit').hide();
            $('#odvCstOcpMainMenu #odvBtnCstOcpInfo').show();
        }else{
            $('#odvModalBody #odvCstOcpMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCstOcpNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCstOcpBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNPosEdcBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNPosEdcBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCstOcpNavDefult Error: ', err);
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
 * Functionality : Call CstOcp Page list
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstOcp() {
    try{
        localStorage.tStaPageNow = 'JSvCallPageCstOcpList';

        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "customerOcpList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCstOcp').html(tResult);
                JSvCstOcpDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstOcp Error: ', err);
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
function JSvCstOcpDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerOcpDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCstOcp').html(tResult);
                }
                JSxCstOcpNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCstOcpDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CstOcp Page Add
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstOcpAdd() {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "customerOcpPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if(nStaCstOcpBrowseType == 1) {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(tResult);
                }else{
                    $('#odvCstOcpMainMenu #oliCstOcpTitleEdit').hide();
                    $('#odvCstOcpMainMenu #odvBtnCstOcpInfo').hide();
                    $('#odvCstOcpMainMenu #oliCstOcpTitleAdd').show();
                    $('#odvCstOcpMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageCstOcp').html(tResult);
                }

                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstOcpAdd Error: ', err);
    }
}

/**
 * Functionality : Call CstOcp Page Edit
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstOcpEdit(ptCstOcpCode) {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCstOcpEdit', ptCstOcpCode);

        $.ajax({
            type: "POST",
            url: "customerOcpPageEdit",
            data: { tCstOcpCode: ptCstOcpCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#odvCstOcpMainMenu #oliCstOcpTitleAdd').hide();
                    $('#odvCstOcpMainMenu #oliCstOcpTitleEdit').show();
                    $('#odvCstOcpMainMenu #odvBtnCstOcpInfo').hide();
                    $('#odvCstOcpMainMenu #odvBtnAddEdit').show();
                    
                    $('#odvContentPageCstOcp').html(tResult);
                    $('#oetCstOcpCode').addClass('xCNDisable');
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
        console.log('JSvCallPageCstOcpEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CstOcp
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateCstOcpCode() {
    try{
        var tTableName = 'TCNMCstOcp';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetCstOcpCode').val(tData.rtOcpCode);
                    $('#oetCstOcpCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNiConGen').attr('disabled', true);
                } else {
                    $('#oetCstOcpCode').val(tData.rtDesc);
                }
                $('#oetCstOcpName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JStGenerateCstOcpCode Error: ', err);
    }
}

/**
 * Functionality : Check CstOcp Code In DB
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckCstOcpCode() {
    try{
        var tCode = $('#oetCstOcpCode').val();
        var tTableName = 'TCNMCstOcp';
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
                        JSvCallPageCstOcpEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateCstOcpCode();
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
        console.log('JStCheckCstOcpCode Error: ', err);
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
function JSxCstOcpSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrCstOcp').find('td.otdCstOcpCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxCstOcpSetDataBeforeDelMulti Error: ', err);
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
function JSaCstOcpDelete(poElement = null, poEvent = null){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCstOcp').find('td.otdCstOcpCode').text();
        $('#ospConfirmDelete').text(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCstOcp').modal('show');
        }
    }catch(err){
        console.log('JSaCstOcpDelete Error: ', err);
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
function JSnCstOcpDelChoose(){
    try{
        JCNxOpenLoading();

        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){ // For mutiple delete

            var oChecked = $('#odvRGPList td input:checked');
            var aCstOcpCode = [];
            $(oChecked).each( function(pnIndex){
                aCstOcpCode[pnIndex] = $(this).parents('tr.otrCstOcp').find('td.otdCstOcpCode').text();
            });

            $.ajax({
                type: "POST",
                url: "customerOcpDeleteMulti",
                data: {tCstOcpCode: JSON.stringify(aCstOcpCode)},
                success: function(tResult) {
                    $('#odvModalDelCstOcp').modal('hide');
                    JSvCstOcpDataTable();
                    JSxCstOcpNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else{ // For single delete

            var tCstOcpCode = $('#ospConfirmDelete').text();

            $.ajax({
                type: "POST",
                url: "customerOcpDelete",
                data: {tCstOcpCode: tCstOcpCode},
                success: function(tResult) {
                    $('#odvModalDelCstOcp').modal('hide');
                    JSvCstOcpDataTable();
                    JSxCstOcpNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }
    }catch(err){
        console.log('JSnCstOcpDelChoose Error: ', err);
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
function JSvCstOcpClickPage(ptPage) {
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
        JSvCstOcpDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCstOcpClickPage Error: ', err);
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
function JCNCstOcpIsCreatePage(){
    try{
        const tCstOcpCode = $('#oetCstOcpCode').data('is-created');
        var bStatus = false;
        if(tCstOcpCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNCstOcpIsCreatePage Error: ', err);
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
function JCNCstOcpIsUpdatePage(){
    try{
        const tCstOcpCode = $('#oetCstOcpCode').data('is-created');
        var bStatus = false;
        if(tCstOcpCode != ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNCstOcpIsUpdatePage Error: ', err);
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
function JSxCstOcpVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCstOcpVisibledDelAllBtn Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 08/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerOcpIsCreatePage(){
    try{
        const tCstOcpCode   = $('#oetCstOcpCode').data('is-created');    
        var bStatus = false;
        if(tCstOcpCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerOcpIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 08/05/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerOcplIsUpdatePage(){
    try{
        const tCstOcpCode = $('#oetCstOcpCode').data('is-created');
        var bStatus = false;
        if(!tCstOcpCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerOcplIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 05/05/2019 saharat (Golf)
// Return : -
// Return Type : -
function JSxCustomerOcpVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCustomerOcpVisibleComponent Error: ', err);
    }
}