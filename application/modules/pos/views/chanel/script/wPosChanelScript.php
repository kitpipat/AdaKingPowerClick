<script type="text/javascript">
/*============================= Begin Custom Form Validate ===================*/

var bUniqueSmgCode;
$.validator.addMethod(
    "uniqueSmgCode", 
    function(tValue, oElement, aParams) {
        let tSmgCode = tValue;
        $.ajax({
            type: "POST",
            url: "slipMessageUniqueValidate/smgcode",
            data: "tSmgCode=" + tSmgCode,
            dataType:"html",
            success: function(ptMsg)
            {
                // If vatrate and vat start exists, set response to true
                bUniqueSmgCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueSmgCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueSmgCode;
    },
    "Vat Code is Already Taken"
);

// Override Error Message
jQuery.extend(jQuery.validator.messages, {
    required: "<?php echo language('pos/slipMessage/slipmessage','tSMGValidName'); ?>",
    required1: "<?php echo language('pos/slipMessage/slipmessage','tSMGValidHead'); ?>",
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
 * Functionality : (event) Add/Edit Slip Message
 * Parameters : ptRoute is route to add slip message data.
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnAddEditSlipMessage(ptRoute) {
    try{
        $('#ofmAddSlipMessage').validate({
            rules:{ 
                // oetSmgCode: {
                //     uniqueSmgCode: JCNbSlipMessageIsCreatePage(),
                //     required: true,
                //     digits: true,
                //     maxlength: 5
                // },
                oetSmgTitle: {
                    required: true
                }
            },
            messages: {
                // oetSmgCode: $('#oetSmgCode').data('validate'),
                oetSmgTitle: $('#oetSmgTitle').data('validate')
            },
            submitHandler: function(form) {
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddSlipMessage').serialize(), // + '&headReceipt=' + JSoSlipMessageSortabled('head', true) + '&endReceipt=' + JSoSlipMessageSortabled('end', true),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        if (nStaSmgBrowseType != 1) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                if (aReturn['nStaCallBack'] == '1' || aReturn['nStaCallBack'] == null) {
                                    JSvCallPageSlipMessageEdit(aReturn['tCodeReturn'])
                                } else if (aReturn['nStaCallBack'] == '2') {
                                    JSvCallPageSlipMessageAdd();
                                } else if (aReturn['nStaCallBack'] == '3') {
                                    JSvCallPageSlipMessage();
                                }
                            } else {
                                alert(aReturn['tStaMessg']);
                            }
                        } else {
                            JCNxBrowseData(tCallSmgBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxSlipMessageResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
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
                if($(element).val() == ""){return;}
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            }
        });
        
        // Head of receipt and End of receipt row validate
        $('.xWSmgDyForm').each(function () {
            $(this).rules("add", {
                required: true
            });
        });
        
    }catch(err){
        console.log('JSnAddEditSlipMessage Error: ', err);
    }
}

/*============================= End Form Validate ============================*/
</script>
