var nStaCstGrpBrowseType    = $('#oetCstGrpStaBrowse').val();
var tCallCstGrpBackOption   = $('#oetCstGrpCallBackOption').val();
/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCstGrpNavDefult();
    if(nStaCstGrpBrowseType != 1) {
        JSvCallPageCstGrp();
    }else{
        JSvCallPageCstGrpAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueCstGrpCode;
$.validator.addMethod(
    "uniqueCstGrpCode", 
    function(tValue, oElement, aParams) {
        let tCstGrpCode = tValue;
        $.ajax({
            type: "POST",
            url: "customerGroupUniqueValidate/CstGrpCode",
            data: "tCstGrpCode=" + tCstGrpCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueCstGrpCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueCstGrpCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueCstGrpCode;
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
 * Functionality : (event) Add/Edit CstGrp
 * Parameters : ptRoute is route to add Customer Group data.
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditCstGrp(ptRoute) {

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddCstGrp').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "customerGroupEventAdd"){
                if($("#ohdCheckDuplicateCstGrpCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddCstGrp').validate({
            rules: {
                oetCstGrpCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "customerGroupEventAdd"){
                                if($('#ocbCustomerGroupAutoGenCode').is(':checked')){
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
                oetCstGrpName: {"required" :{}},
            },
            messages: {
                oetCstGrpCode : {
                    "required"      : $('#oetCstGrpCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCstGrpCode').attr('data-validate-dublicateCode')
                },
                oetCstGrpName : {
                    "required"      : $('#oetCstGrpName').attr('data-validate-required'),
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
                data: $('#ofmAddCstGrp').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCstGrpBrowseType != 1) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                JSvCallPageCstGrpEdit(aReturn['tCodeReturn'])
                            } else if (aReturn['nStaCallBack'] == '2') {
                                JSvCallPageCstGrpAdd();
                            } else if (aReturn['nStaCallBack'] == '3') {
                                JSvCallPageCstGrp();
                            }
                        } else {
                            alert(aReturn['tStaMessg']);
                        }
                    } else {
                        JCNxCloseLoading();
                        JCNxBrowseData(tCallCstGrpBackOption);
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
 * Functionality : Function Clear Defult Button CstGrp
 * Parameters : -
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCstGrpNavDefult() {
    try{
        if(nStaCstGrpBrowseType != 1 || nStaCstGrpBrowseType == undefined) {
            $('.obtChoose').hide();
            $('#oliCstGrpTitleAdd').hide();
            $('#oliCstGrpTitleEdit').hide();
            $('#odvCstGrpMainMenu #odvBtnAddEdit').hide();
            $('#odvCstGrpMainMenu #odvBtnCstGrpInfo').show();
        }else{
            $('#odvModalBody #odvCstGrpMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCstGrpNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCstGrpBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCstGrpBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCstGrpBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCstGrpNavDefult Error: ', err);
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
 * Functionality : Call CstGrp Page list
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstGrp() {
    try{
        localStorage.tStaPageNow = 'JSvCallPageCstGrpList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "customerGroupList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCstGrp').html(tResult);
                JSvCstGrpDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstGrp Error: ', err);
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
function JSvCstGrpDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerGroupDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCstGrp').html(tResult);
                }
                JSxCstGrpNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCstGrpDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CstGrp Page Add
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstGrpAdd() {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "customerGroupPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if(nStaCstGrpBrowseType == 1) {
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(tResult);
                }else{
                    $('#odvCstGrpMainMenu #oliCstGrpTitleEdit').hide();
                    $('#odvCstGrpMainMenu #odvBtnCstGrpInfo').hide();
                    $('#odvCstGrpMainMenu #oliCstGrpTitleAdd').show();
                    $('#odvCstGrpMainMenu #odvBtnAddEdit').show();
                    $('#odvContentPageCstGrp').html(tResult);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCstGrpAdd Error: ', err);
    }
}

/**
 * Functionality : Call CstGrp Page Edit
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCstGrpEdit(ptCstGrpCode) {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCstGrpEdit', ptCstGrpCode);

        $.ajax({
            type: "POST",
            url: "customerGroupPageEdit",
            data: { tCstGrpCode: ptCstGrpCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliCstGrpTitleAdd').hide();
                    $('#oliCstGrpTitleEdit').show();
                    $('#odvBtnCstGrpInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCstGrp').html(tResult);
                    $('#oetCstGrpCode').addClass('xCNDisable');
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
        console.log('JSvCallPageCstGrpEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CstGrp
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStGenerateCstGrpCode() {
    try{
        var tTableName = 'TCNMCstGrp';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetCstGrpCode').val(tData.rtCgpCode);
                    $('#oetCstGrpCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $('.xCNiConGen').attr('disabled', true);
                } else {
                    $('#oetCstGrpCode').val(tData.rtDesc);
                }
                $('#oetCstGrpName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JStGenerateCstGrpCode Error: ', err);
    }
}

/**
 * Functionality : Check CstGrp Code In DB
 * Parameters : {params}
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckCstGrpCode() {
    try{
        var tCode = $('#oetCstGrpCode').val();
        var tTableName = 'TCNMCstGrp';
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
                        JSvCallPageCstGrpEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateCstGrpCode();
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
        console.log('JStCheckCstGrpCode Error: ', err);
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
function JSxCstGrpSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += '';
        });
        var tConfirm =$('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm + tValue);
    }catch(err){
        console.log('JSxCstGrpSetDataBeforeDelMulti Error: ', err);
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
function JSaCstGrpDelete(poElement = null, poEvent = null){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCstGrp').find('td.otdCstGrpCode').text();
        var tValueName = $(poElement).parents('tr.otrCstGrp').find('td.otdCstGrpName').text();
        var tConfirm =$('#ohdDeleteconfirm').val();
        var tConfirmYN =$('#ohdDeleteconfirmYN').val();
        $('#ospConfirmDelete').text(tConfirm +' ' + tValue+' ('+tValueName+')'+ tConfirmYN);
        $('#ospCode').val(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCstGrp').modal('show');
        }
    }catch(err){
        console.log('JSaCstGrpDelete Error: ', err);
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
function JSnCstGrpDelChoose(){
    try{
        JCNxOpenLoading();

        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){ // For mutiple delete

            var oChecked = $('#odvRGPList td input:checked');
            var aCstGrpCode = [];
            $(oChecked).each( function(pnIndex){
                aCstGrpCode[pnIndex] = $(this).parents('tr.otrCstGrp').find('td.otdCstGrpCode').text();
            });

            $.ajax({
                type: "POST",
                url: "customerGroupDeleteMulti",
                data: {tCstGrpCode: JSON.stringify(aCstGrpCode)},
                success: function(tResult) {
                    $('#odvModalDelCstGrp').modal('hide');
                    JSvCstGrpDataTable();
                    JSxCstGrpNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else{ // For single delete

            var tCstGrpCode = $('#ospCode').val();
            // alert("=="+tCstGrpCode);
            $.ajax({
                type: "POST",
                url: "customerGroupDelete",
                data: {tCstGrpCode: tCstGrpCode},
                success: function(tResult) {
                    $('#odvModalDelCstGrp').modal('hide');
                    JSvCstGrpDataTable();
                    JSxCstGrpNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
           

        }
        JCNxCloseLoading();
    }catch(err){
        console.log('JSnCstGrpDelChoose Error: ', err);
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
function JSvCstGrpClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageCstGrp .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageCstGrp .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvCstGrpDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCstGrpClickPage Error: ', err);
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
function JCNCstGrpIsCreatePage(){
    try{
        const tCstGrpCode = $('#oetCstGrpCode').data('is-created');
        var bStatus = false;
        if(tCstGrpCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNCstGrpIsCreatePage Error: ', err);
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
function JCNCstGrpIsUpdatePage(){
    try{
        const tCstGrpCode = $('#oetCstGrpCode').data('is-created');
        var bStatus = false;
        if(tCstGrpCode != ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNCstGrpIsUpdatePage Error: ', err);
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
function JSxCstGrpVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCstGrpVisibledDelAllBtn Error: ', err);
    }
}

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerGroupIsCreatePage(){
    try{
        const tCstGrpCode = $('#oetCstGrpCode').data('is-created');    
        var bStatus = false;
        if(tCstGrpCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbCustomerGroupIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerGroupIsUpdatePage(){
    try{
        const tCstGrpCode = $('#oetCstGrpCode').data('is-created');
        var bStatus = false;
        if(!tCstGrpCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbVoucherIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxCustomerGroupVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxVoucherVisibleComponent Error: ', err);
    }
}
