var nStaCstBrowseType = $('#oetCstStaBrowse').val();
var tCallCstBackOption = $('#oetCstCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCLNNavDefult();
    if (nStaCstBrowseType != 1) {
        JSvCLNCallPageCustomer();
    } else {
        JSvCLNCallPageCustomerAdd();
    }
});

/*============================= End Auto Run =================================*/

/*============================= Begin Custom Form Validate ===================*/

var bUniqueCstCode;
$.validator.addMethod(
    "uniqueCstCode", 
    function(tValue, oElement, aParams) {
        let tCstCode = tValue;
        $.ajax({
            type: "POST",
            url: "customerlicenseUniqueValidate/cstcode",
            data: "tCstCode=" + tCstCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueCstCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueCstCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueCstCode;
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
 * Functionality : (event) Add/Edit Customer
 * Parameters : ptRoute is route to add customer data.
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : - 
 */
function JSnCSTAddEditCustomer(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddCustomerInfo1').serialize() + "&" + $('#ofmAddCustomerInfo2').serialize() + "&" + $('#ofmAddCustomerImageForm').serialize(),
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaCstBrowseType != 1) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn["nStaEvent"] == 1) {
                        if (aReturn["nStaCallBack"] == "1" ||
                            aReturn["nStaCallBack"] == null
                        ) {
                            JSvCLNCallPageCustomerEdit(aReturn["tCodeReturn"]);
                        } else if (aReturn["nStaCallBack"] == "2") {
                            JSvCLNCallPageCustomerEdit(aReturn["tCodeReturn"]);
                        } else if (aReturn["nStaCallBack"] == "3") {
                            JSvCLNCallPageCustomer();
                        }
                        JCNxImgWarningMessage(aReturn['aImgReturn']);
                    } else {
                        tMsgBody = aReturn["tStaMessg"];
                        FSvCMNSetMsgWarningDialog(tMsgBody);
                    }
                    
                    
                    
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}
 

/*============================= End Form Validate ============================*/

/**
 * Functionality : Function Clear Defult Button Customer
 * Parameters : -
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCLNNavDefult() {
    try{
        if (nStaCstBrowseType != 1 || nStaCstBrowseType == undefined) {
            $('.xCNCstVBrowse').hide();
            $('.xCNCstVMaster').show();
            $('#oliCstTitleAdd').hide();
            $('#oliCstTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCstInfo').show();
        } else {
            $('#odvModalBody .xCNCstVMaster').hide();
            $('#odvModalBody .xCNCstVBrowse').show();
            $('#odvModalBody #odvCstMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCstNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCstBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCstBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCstBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxDPTNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxCSTResponseError(jqXHR, textStatus, errorThrown) {
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
        console.log('JCNxCSTResponseError Error: ', err);
    }
}

/**
 * Functionality : Call Customer Page list
 * Parameters : {params}
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCLNCallPageCustomer() {
    try{
        localStorage.tStaPageNow = 'JSvCallPageCustomerList';
        $('#oetSearchAll').val('');
        $.ajax({
            type: "POST",
            url: "customerlicenseList",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCustomer').html(tResult);
                JSvCLNCustomerDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCustomer Error: ', err);
    }
    
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCLNCustomerDataTable(pnPage) {
    try{
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == '') {
            nPageCurrent = '1';
        }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "customerlicenseDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 5000,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataCustomer').html(tResult);
                }
                JSxCLNNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMCst_L'); // โหลดภาษาใหม่
                $('#odvBtnAddEdit .xWBtnSave').removeClass('hidden');
                $('#odvCstMasterImgContainer').removeClass('hidden');
                $('#odvContentContainer').removeClass('xWFullWidth');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCLNCustomerDataTable Error: ', err);
    }
}

/**
 * Functionality : Call Customer Page Add
 * Parameters : {params}
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCLNCallPageCustomerAdd() {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "customerlicensePageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaCstBrowseType == 1) {
                    $('.xCNCstVMaster').hide();
                    $('.xCNCstVBrowse').show();
                } else {
                    $('.xCNCstVBrowse').hide();
                    $('.xCNCstVMaster').show();
                    $('#oliCstTitleEdit').hide();
                    $('#oliCstTitleAdd').show();
                    $('#odvBtnCstInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageCustomer').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
                $('#oetCstCode,#oetCstName,#oetCstIdenNum,#oetCstBirthday,#oetCstTaxIdenNum,#oetCstTel,#oetCstEmail,#otaCstRemark').blur(function(){
                    $('#ohdCheckSubmitByButton').val(0);
                    JSxCheckCustomerValidateForm();
                });
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCustomerAdd Error: ', err);
    }
}

//Functionality : Event Check Customer
//Parameters : Event Blur Input Customer Code
//Creator : 30/08/2019 saharat (Golf)
//Update :-
//Return : -
//Return Type : -
function JSxCheckCustomerValidateForm(){
    // From Summit Validate
    $('#ofmAddCustomerInfo1').validate().destroy();
    $('#ofmAddCustomerInfo1').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,                     
        onkeyup: false,
        rules: {
            oetCstCode : {
                "required" : {
                     // ตรวจสอบเงื่อนไข validate
                     depends: function(oElement) {
                        if($('#ocbCustomerAutoGenCode').is(':checked')){
                            //ทำ validate
                            return false; 
                        }else{
                            //ไม่ทำ validate
                            return true;
                        }
                    }
                }
            },
            oetCstName: { 
                "required": true
            },

           // ....
        },
        messages: {
            oetCstCode : {
                "required"      : $('#oetCstCode').attr('data-validate-required')
                
            },
            oetCstName : {
                "required"      : $('#oetCstName').attr('data-validate-required')
               
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
        highlight: function ( element, errorClass, validClass ) {
            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function (element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form){
            if($('#ocbCustomerAutoGenCode').is(':checked')){
                var tRout = $('#ohdFunctionAddEditCustomer').val(); 
                if($("#ohdCheckSubmitByButton").val()==1){
                    JSnCSTAddEditCustomer(tRout);
                }
                
            }else{
                console.log(3);
                JSxCheckCustomerCodeDupInDB();
            }
            
            
        }
    });
    $('#ofmAddCustomerInfo1').submit();       
       
}    

   //Functionality : Event Check Customer
    //Parameters : Event Blur Input Customer Code
    //Creator : 30/08/2019 saharat (Golf)
    //Update :-
    //Return : -
    //Return Type : -
    function JSxCheckCustomerCodeDupInDB(){
        if(!$('#ocbCustomerAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCst",
                    tFieldName: "FTCstCode",
                    tCode: $("#oetCstCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCstCode").val(aResult["rtCode"]);
                    $('#ofmAddCustomerInfo1').validate().destroy();  
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdCheckDuplicateCstCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },);
                    // From Summit Validate
                    $('#ofmAddCustomerInfo1').validate({
                        rules: {
                            oetCstCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbCustomerAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                    }
                                },
                                "dublicateCode": {}
                            },
                            oetCstName: { "required": {} },
                        },
                        messages: {
                            oetCstCode : {
                                "required"      : $('#oetCstCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetCstCode').attr('data-validate-dublicateCode')
                            },
                            oetCstName : {
                                "required"      : $('#oetCstName').attr('data-validate-required'),
                                "dublicateCode" : $('#oetCstName').attr('data-validate-dublicateCode')
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
                        highlight: function ( element, errorClass, validClass ) {
                            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                        },
                        unhighlight: function (element, errorClass, validClass) {
                            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                        },
                        submitHandler: function(form){
                            var tRout = $('#ohdFunctionAddEditCustomer').val(); 
                            // Submit From
                            if($("#ohdCheckSubmitByButton").val()==1){
                                JSnCSTAddEditCustomer(tRout);
                            }
                            
                        }
                    });
                    $('#ofmAddCustomerInfo1').submit();
                   
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }
    
/**
 * Functionality : Call Customer Page Edit
 * Parameters : {params}
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCLNCallPageCustomerEdit(ptCstCode) {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCustomerEdit', ptCstCode);

        $.ajax({
            type: "POST",
            url: "customerlicensePageEdit",
            data: { tCstCode: ptCstCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliCstTitleAdd').hide();
                    $('#oliCstTitleEdit').show();
                    $('#odvBtnCstInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageCustomer').html(tResult);
                    $('#oetCstCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageCustomerEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code Customer
 * Parameters : {params}
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCLNGenerateCustomerCode(poElement, poEvent) {
    try{
        var tTableName = 'TCNMCst';
        $.ajax({
            type: "POST",
            url: "generateCode",
            data: { tTableName: tTableName },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                if (tData.rtCode == '1') {
                    $('#oetCstCode').val(tData.rtCstCode);
                    $('#oetCstCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                    //----------Hidden ปุ่ม Gen
                    $(poElement).attr('disabled', true);
                } else {
                    $('#oetCstCode').val(tData.rtDesc);
                }
                $('#oetCstName').focus();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JStCLNGenerateCustomerCode Error: ', err);
    }
}

/**
 * Functionality : Check Customer Code In DB
 * Parameters : {params}
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCLNCheckCustomerCode() {
    try{
        var tCode = $('#oetCstCode').val();
        var tTableName = 'TCNMCst';
        var tFieldName = 'FTCstCode';
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
                    if (tData.rtCode == '1') { // มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                        alert('มี id นี้แล้วในระบบ');
                        JSvCLNCallPageCustomerEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStCLNGenerateCustomerCode();
                    }
                    $('.wrap-input100').removeClass('alert-validate');
                    $('.btn-default').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }catch(err){
        console.log('JStCLNCheckCustomerCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCLNSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        // var oChecked = $('#odvRGPList td input:checked');
        // var tValue = '';
        // $(oChecked).each( function(pnIndex){
        //     tValue += $(this).parents('.otrCustomer').find('.xWCustomerCode').val() + ', ';
        // });
        // $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
    }catch(err){
        console.log('JSxCLNSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCLNDelete(ptCstCode){
    try{
        // var nCheckedCount = $('#odvRGPList td input:checked').length;

        // var tValue = $(poElement).parents('.otrCustomer').find('.xWCustomerCode').val();
        // $('#ospConfirmDelete').text(tValue);

        // if(nCheckedCount <= 1){
        //     $('#odvModalDelCustomer').modal('show');
        // }

        $('#ohdConfirmIDDelete').val(ptCstCode + " , ");
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val() + " " + ptCstCode);
        $('#odvModalDelCustomer').modal('show');

        // JCNxOpenLoading();
        // $.ajax({
        //     type: "POST",
        //     url: "customerlicenseDelete",
        //     data: { tCstCode: ptCstCode },
        //     cache: false,
        //     timeout: 0,
        //     success: function(tResult) {
        //         setTimeout(function() {
        //             JSvCLNCustomerDataTable();
        //             JSxCLNNavDefult();
        //             $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
        //             $('#ohdConfirmIDDelete').val('');
        //             localStorage.removeItem('LocalItemData');
        //         }, 500);
        //     },
        //     error: function(jqXHR, textStatus, errorThrown) {
        //         JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
        //     }
        // });
    }catch(err){
        console.log('JSaCLNDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCSTDelChoose(){
    try{
        JCNxOpenLoading();

        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        // if(aDataSplitlength > 1) {
        //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        // }else{
        //     $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val() + aDataSplit[0]);
        // }
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "customerlicenseDeleteMulti",
            data: { 'tIDCode': aNewIdDelete },
            timeout: 0,
            success: function(tResult) {
                console.log(tResult);
                setTimeout(function() {
                    $('#odvModalDelCustomer').modal('hide');
                    JSvCLNCustomerDataTable();
                    JSxCLNNavDefult();
                    $('#ospConfirmDelete').text('');
                    $('#ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        // } else {
        //     localStorage.StaDeleteArray = '0';
        //     return false;
        // }

        // var nCheckedCount = $('#odvRGPList td input:checked').length;
        // if(nCheckedCount > 1){ // For mutiple delete

        //     var oChecked = $('#odvRGPList td input:checked');
        //     var aCstCode = [];
        //     $(oChecked).each( function(pnIndex){
        //         aCstCode[pnIndex] = $(this).parents('otrCustomer').find('.xWCustomerCode').val();
        //     });

        //     console.log($(this).parents('otrCustomer').find('.xWCustomerCode').val());
        //     console.log(aCstCode);

        //     $.ajax({
        //         type: "POST",
        //         url: "customerlicenseDeleteMulti",
        //         data: {tCstCode: JSON.stringify(aCstCode)},
        //         success: function(tResult) {
        //             console.log(tResult);
        //             $('#odvModalDelCustomer').modal('hide');
        //             JSvCLNCustomerDataTable();
        //             JSxCLNNavDefult();
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
        //         }
        //     });

        // }else{ // For single delete

        //     var tCstCode = $('#ospConfirmDelete').text();

        //     $.ajax({
        //         type: "POST",
        //         url: "customerlicenseDelete",
        //         data: {tCstCode: tCstCode},
        //         success: function(tResult) {
        //             $('#odvModalDelCustomer').modal('hide');
        //             JSvCLNCustomerDataTable();
        //             JSxCLNNavDefult();
        //         },
        //         error: function(jqXHR, textStatus, errorThrown) {
        //             JCNxCSTResponseError(jqXHR, textStatus, errorThrown);
        //         }
        //     });

        // }
    }catch(err){
        console.log('JSnCSTDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCLNClickPage(ptPage) {
    try{
        var nPageCurrent = '';
        var nPageNew;
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageCst .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageCst .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvCLNCustomerDataTable(nPageCurrent);
    }catch(err){
        console.log('JSvCLNClickPage Error: ', err);
    }
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCSTIsCreatePage(){
    try{
        const tCstCode = $('#oetCstCode').data('is-created');
        var bStatus = false;
        if(tCstCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCSTIsCreatePage Error: ', err);
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
function JCNbCSTIsUpdatePage(){
    try{
        const tVCode = $('#oetCstCode').data('is-created');
        let bStatus = false;
        if(tVCode != ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCSTIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 18/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCLNVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch(err){
        console.log('JSxCLNVisibledDelAllBtn Error: ', err);
    }
}

/**
 * Functionality : Show or hide Save and Cancel button
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 20/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCLNVisibledActionSubMenu(poElement, poEvent){
    
    $('a[data-toggle="tab"]').on('shown.bs.tab', function (poElement) {
        
        let tTabId = $(poElement.target).parents('.xWMenu').attr('id');
        JSxCLNSetNavTabActive(tTabId);
        $("#obtSubSave").attr("onclick", "$('#obtSave_" + tTabId + "').click()");
        $("#obtSubCancel").attr("onclick", "$('#obtCancel_" + tTabId + "').click()");
        
        if(!JSbCLNIsNavTabActive('oliCstContact')){
            JSxCLNVisibleComponent('#obtSubSave', true); // Show Sub Save
            JSxCLNVisibleComponent('#obtSubCancel', true); // Show Sub Cancel
        }else{
            if($("#xWContactFormContainer").hasClass('hidden')){
                JSxCLNVisibleComponent('#obtSubSave', false); // Hide Sub Save
                JSxCLNVisibleComponent('#obtSubCancel', false); // Hide Sub Cancel
            }
        }
    });
    
    if($(poElement).parent().hasClass('enabled') && $(poElement).hasClass('xWOption')) {
        $('.xWActionSubMenu').removeClass('hidden');
        $('#odvBtnAddEdit .xWBtnSave').addClass('hidden');

        if($(poElement).hasClass('xWDelSubMenu')){
            $('.xWActionSubMenu').addClass('hidden');
        }

    }else{
        $('.xWActionSubMenu').addClass('hidden');
        $('#odvBtnAddEdit .xWBtnSave').removeClass('hidden');
    }
}

/**
 * Functionality : Set tab active value
 * Parameters : ptTabName is id tag (<li id="")
 * Creator : 21/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCLNSetNavTabActive(ptTabName = "oliCstInfo1"){
    $('#ohdNavActive').val(ptTabName);
}

/**
 * Functionality : Check tab active
 * Parameters : ptTabName is tag name 
 * ("oliCstInfo1", "oliCstInfo2", "oliCstAddress", "oliCstContact", 
 * "oliCstCardInfo", "oliCstCredit", "oliCstRfid")
 * Creator : 21/09/2018 piya
 * Last Modified : -
 * Return : Status false or true
 * Return Type : boolean
 */
function JSbCLNIsNavTabActive(ptTabName){
    let bStatus = false;
    if($('#ohdNavActive').val() == ptTabName){
        bStatus = true;
    }
    return bStatus;
}

/**
* Functionality : Show or Hide Component
* Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
* Creator : 27/09/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCLNVisibleComponent(ptComponent, pbVisible){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            $(ptComponent).removeClass('hidden');
        }
    }catch(err){
        console.log('JSxCLNVisibleComponent Error: ', err);
    }
}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 15/05/2018 wasin
//Return: -
//Return Type: -
function JSxTextinModal() {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {

    }else{

        var tText = '';
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tText += aArrayConvert[0][$i].tName + '(' + aArrayConvert[0][$i].nCode + ') ';
            tText += ' , ';

            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';

        }
        var tTexts = tText.substring(0, tText.length - 2);
        var tConfirm =$('#ohdDeleteChooseconfirm').val();
        $('#ospConfirmDelete').text(tConfirm);
        $('#ohdConfirmIDDelete').val(tTextCode);

    }
}

//Functionality: Function check Value LocalStorage
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

//Functionality: Function check And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 15/05/2018
//Return: - 
//Return Type: -
function JSxShowButtonChoose(){
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

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 30/08/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerIsCreatePage() {
    try {
        const tCstCode = $('#oetCstCode').data('is-created');
        var bStatus = false;
        if (tCstCode == "") { // No have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbCustomerIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 30/08/2019 saharat(Golf)
// Return: object Status Delete
// ReturnType: boolean
function JSbCustomerIsUpdatePage() {
    try {
        const tCstCode = $('#oetCstCode').data('is-created');
        var bStatus = false;
        if (!tCstCode == "") { // Have data
            bStatus = true;
        }
        return bStatus;
    } catch (err) {
        console.log('JSbCustomerIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator: 30/08/2019 saharat(Golf)
// Return : -
// Return Type : -
function JSxCustomerVisibleComponent(ptComponent, pbVisible, ptEffect) {
    try {
        if (pbVisible == false) {
            $(ptComponent).addClass('hidden');
        }
        if (pbVisible == true) {
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function() {
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    } catch (err) {
        console.log('JSxCustomerVisibleComponent Error: ', err);
    }
}



// Get Data Customer Code ไป
// Create By Witsarut 25/11/2019
function JSxCLNloginGetContent(){

    $('.xWBtnSave').addClass('hidden');

    var ptCstCode = $('#oetCstCode').val();
    // Check Login Expried
    var nStaSession = JCNxFuncChkSessionExpired();

    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type : "POST",
            url  : "customerlogin",
            data : {
                tCstCode : ptCstCode
            },
            cache    : false,
            timeout : 0,
            success : function(tResult){
                $('#odvTabCstlogin').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}
