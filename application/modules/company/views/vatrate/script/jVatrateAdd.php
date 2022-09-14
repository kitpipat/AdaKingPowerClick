<script type="text/javascript">
$('document').ready(function() {

    // $('body').on('focus',".xCNDatePicker", function(){
    //     $(this).datepicker({
    //         format: 'yyyy-mm-dd',
    //         autoclose: true,
    //         todayHighlight: true,
    //         startDate: new Date(),
    //         orientation: "bottom"
    //     });
    // });
        
    $('.xCNDatePicker').datepicker({
        format: 'yyyy-mm-dd',
        autoclose: true,
        todayHighlight: true
    });

    $('#obtVatStart').click(function(event){
        $('#oetAddVatStart').datepicker('show');
    });

    $('.xWVatDelete').attr('title', '<?php echo language('common/main/main', 'tCMNActionDelete'); ?>');
    $('.xWVatEdit').attr('title', '<?php echo language('common/main/main', 'tCMNActionEdit'); ?>');
    $('.xWVatSave').attr('title', '<?php echo language('common/main/main', 'tSave'); ?>');
    $('.xWVatCancel').attr('title', '<?php echo language('common/main/main', 'tCancel'); ?>');
    
    if(JCNVatrateIsUpdatePage()){
        // Vat Rate Code
        $("#oetVatCode").attr("readonly", true);
        $('#odvVatrateAutoGenCode input').attr('disabled', true);
        JSxCardVisibleComponent('#odvVatrateAutoGenCode', false);
        
        $("#obtGenCodeVatrate").attr("disabled", true);
    }

    if(JCNVatrateIsCreatePage()){
        // Card Code
        $("#oetVatCode").attr("disabled", true);
        $('#ocbVatrateAutoGenCode').change(function(){
            if($('#ocbVatrateAutoGenCode').is(':checked')) {
                $("#oetVatCode").attr("disabled", true);
                $("#oetVatCode").val('');
                $('#odvVatrateCodeForm').removeClass('has-error');
                $('#odvVatrateCodeForm em').remove();
            }else{
                $("#oetVatCode").attr("disabled", false);
            }
        });
        JSxCardVisibleComponent('#odvVatrateAutoGenCode', true);
    }
    
});

/*============================= Begin Custom Form Validate ===================*/

var bUniqueVatCode;
$.validator.addMethod(
    "uniqueVatCode", 
    function(tValue, oElement, aParams) {
        var tAddVatCode = tValue;
        $.ajax({
            type: "POST",
            url: "vatrateUniqueValidate/vatcode",
            data: "tAddVatCode=" + tAddVatCode,
            dataType:"html",
            success: function(ptMsg){
                // If vatrate and vat start exists, set response to true
                bUniqueVatCode = ( ptMsg == 'true' ) ? false : true;                
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log('Custom validate uniqueVatCode: ', jqXHR, textStatus, errorThrown);
            },
            async: false
        });
        return bUniqueVatCode;
    },
    "Vat Code is Already Taken"
);

var bUniqueVatStart;
$.validator.addMethod(
    "uniqueVatStart", 
    function(tValue, oElement, aParams) {
        var tAddVatStart    = tValue;
        var tAddVatRate     = aParams['vatRate'];
        var tAddVatCode     = aParams['vatCode'];   
        
        var bStatus = true;
        
        var oVatrateRecord = $('#otbRateList').find('.otrVRate').find('.xWVatStart');
        oVatrateRecord.each(function(nIndex){
            if(tAddVatStart == $(this).val()){
                bStatus = false;
            }
        });
        
        return bStatus;
    },
    "Vat Start is Already Taken"
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
* Functionality : Validate vat rate form befor save action.
* Parameters : -
* Creator : 21/08/2018 piya
* Last Modified : 27/08/2018 piya
* Return : -
* Return Type : -
*/
function JSxFormValidate(){
    try{
        $('#ofmAddVatRate').validate({
            rules: {
                oetAddVatRate: {
                    required: true,
                    digits: true,
                    maxlength: 2
                },
                oetAddVatStart: {
                    uniqueVatStart: function(element){
                        let aParams = [];
                        aParams['vatRate'] = $(this.oetAddVatRate).val();
                        aParams['vatCode'] = $(this.oetVatCode).val();
                        return aParams;
                    },
                    required: true
                }
            },
            messages: {
                oetAddVatRate: {
                    required: "<?php echo language('company/vatrate/vatrate','tVATvalidateVatrate'); ?>",
                    digits: "<?php echo language('company/vatrate/vatrate','tVATvalidateOnlyDigit'); ?>",
                    maxlength: jQuery.validator.format("<?php echo language('company/vatrate/vatrate','tVatvalidateCharacters'); ?>")
                },
                oetAddVatStart: {
                    required: "<?php echo language('company/vatrate/vatrate','tVATvalidateTaxRate'); ?>",
                    uniqueVatStart: "<?php echo language('company/vatrate/vatrate','tDateOfRepeatedUse'); ?>"
                }
            },
            submitHandler: function(form) {
                // Get Value Form Field
                var tAddVatRate     = $(form.oetAddVatRate).val();
                var dAddVatStart    = $(form.oetAddVatStart).val();

                // Reset Form Field
                $(form.oetAddVatRate).val('');
                // $(form.oetAddVatStart).val('');
   
                var tDeleteTitle    = $('.xWVatDelete').attr('title');
                var tEditTitle      = $('.xWVatEdit').attr('title');
                var tSaveTitle      = $('.xWVatSave').attr('title');
                var tCancelTitle    = $('.xWVatCancel').attr('title');
                var tBaseurl        = $('#tBaseurl').val();
                var tTrTagLast      = $('tbody#otbRateList > tr').last().find('.xWIndex').text();
                var nIndex          = (typeof tTrTagLast === 'undefined') || (tTrTagLast == '')  ? 1 : ++tTrTagLast;
                var tRow            =  '<tr class="text-center xCNTextDetail2 otrVRate" id="otrVRate' + nIndex + '">'+
                                '<td class="xWIndex">' + nIndex + '</td>'+
                                '<td class="text-left">'+ 
                                    '<div class="validate-input" data-validated="Plese Insert VatRate">'+
                                        '<input name="oetVatRate' + nIndex + '" type="text" class="xWVat xCNTextDetail2 xCNInputNumericWithoutDecimal text-right" value="' + tAddVatRate + '" disabled="true">'+ 
                                    '</div>'+
                                '</td>'+
                                '<td class="text-left">'+
                                    '<div class="validate-input" data-validated="Plese Select VatStart">'+
                                        '<input name="oetVatStrat' + nIndex + '" type="text" class="xWVatStart xCNTextDetail2 xCNDatePicker text-center" value="' + dAddVatStart + '" disabled="true" onchange="JSxVatStartRecordValidate(this, event)">'+
                                    '</div>'+    
                                '</td>'+
                                '<td></td>'+
                                '<td> <img class="xCNIconTable xWVatDelete" src="' + tBaseurl + '/application/modules/common/assets/images/icons/delete.png" onClick="JSxDeleteOperator(this, event)" title="ลบ"></td>'+
                                '<td>'+
                                    '<img class="xCNIconTable xWVatEdit" src="' + tBaseurl + '/application/modules/common/assets/images/icons/edit.png" onClick="JSxEditOperator(this, event)" title="แก้ไข"></i> '+
                                    '<img class="xCNIconTable xWVatSave hidden" src="' + tBaseurl + '/application/modules/common/assets/images/icons/save.png" onclick="JSxSaveOperator(this, event)" title="บันทึก" style="margin: 0px 3px;"></i> '+
                                    '<img class="xCNIconTable xWVatSave hidden" src="' + tBaseurl + '/application/modules/common/assets/images/icons/reply_new.png" onClick="JSxCancelOperator(this, event)" title="ยกเลิก"></i> '+
                                '</td>'+
                            '</tr>';
                $('#otbRateList').append(tRow);
                $('#otrNoVatData').css('display', 'none');

                if(JCNVatrateIsCreatePage() && JCNbEmptyRecord()){
                    $('#obtAddEditVatRate').click();

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
            }
        });
    }catch(err){
        console.log('JSxFormValidate Error: ', err);
    }
}

/*============================= End Form Validate ============================*/

/**
 * Functionality : Action to Save All Record
 * Parameters : tRoute is Path to Store Dadabase
 * Creator : 23/08/2018 piya
 * Last Modified : 28/08/2018 piya
 * Return : -
 * Return Type : -
 */
function JSxSaveVatRate(tRoute){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            
            // Check Record Validate
            if(JCNbHasInvalidRecord()){
                FSvCMNSetMsgWarningDialog('<?php echo language('company/vatrate/vatrate', 'tVatHasValid'); ?>');
                return;
            }
            
            var tOptionSave = localStorage.getItem('tBtnSaveStaActive');
            // เช็คข้อมูลอัตราภาษี
            var tDataRecord = "";
            var tDataRecord =  JCNbEmptyRecord();
            if(tDataRecord){
                $('#odvModalNotifications').modal('show');
                return
            }
            if((JCNbEmptyRecord()) && JCNVatrateIsUpdatePage()){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "vatrateDelete",
                    data: $('#ofmAddVatRate').serialize(),
                    dataType:"html",
                    async: false,
                    success: function(tResult){
                       try{
                            var oResult = JSON.parse(tResult);
                            // Save Options
                            if(tOptionSave == '1'){ // Save and view
                                JSvCallPageVatrateEdit(oResult['tCodeReturn']);
                            }
                            if(tOptionSave == '2'){ // Save and new create
                                JSvCallPageVatrateAdd();
                            }
                            if(tOptionSave == '3'){ // Save and back ot list page
                                JSvCallPageVatrateList();
                            }
                            JCNxCloseLoading();
                        }catch(err){}
                    }
                });
                return;
            }

            // // Check Empty Record
            // if(JCNbEmptyRecord()){
            //     FSvCMNSetMsgWarningDialog('<?php echo language('company/vatrate/vatrate', 'tVatEmpty'); ?>');
            //     return;
            // }

            $('#ofmSaveVatRate').validate({
                rules: {
                    oetVatCode: {
                        uniqueVatCode: JCNVatrateIsCreatePage(),
                        required: true,
                        // digits: true,
                        maxlength: 5
                    }
                },
                messages: {
                    oetVatCode: {
                        uniqueVatCode: "<?php echo language('company/vatrate/vatrate','tVatvalidateDupicateCode'); ?>",
                        required: "<?php echo language('company/vatrate/vatrate','tVATvalidateCode'); ?>",
                        // digits: "<?php echo language('company/vatrate/vatrate','tVATvalidateOnlyDigit'); ?>",
                        maxlength: jQuery.validator.format("<?php echo language('company/vatrate/vatrate','tVatvalidateCharacters'); ?>")
                    }
                },
                submitHandler: function(form) {
                    // Set data
                    var aData = [];
                    var nCountRecord = $('#otbRateList > tr').not('.hidden').not('#otrNoVatData');//.length;
                    $.each(nCountRecord, function(pnIndex, poElement){
                        aData[pnIndex] = {
                            vatRate: $(poElement).find('input.xWVat').val().replace(' %', ''),
                            vatStart: $(poElement).find('input.xWVatStart').val()
                        };
                    });

                    $.ajax({
                        type: "POST",
                        url: "vatrateCreateOrUpdate",
                        data: $('#ofmSaveVatRate').serialize() + "&tData=" + JSON.stringify(aData),
                        dataType:"html",
                        success: function(tResult){
                            try{
                                var oResult = JSON.parse(tResult);
                                // console.log("Vat Result: ", oResult);
                                // console.log("OptionSave: ", tOptionSave);
                                // Save Options
                                if(tOptionSave == '1'){ // Save and view
                                    JSvCallPageVatrateEdit(oResult['tCodeReturn']);
                                }
                                if(tOptionSave == '2'){ // Save and new create
                                    JSvCallPageVatrateAdd();
                                }
                                if(tOptionSave == '3'){ // Save and back ot list page
                                    JSvCallPageVatrateList();
                                }
                                JCNxCloseLoading();
                            }catch(err){}
                        },
                        async: false
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
                    $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            });
            
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSxSaveVatRate Error: ', err);
    }
}
</script>

