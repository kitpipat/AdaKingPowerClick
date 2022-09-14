<script type="text/javascript">
    $(document).ready(function(){
        if(JSbCreditcardIsCreatePage()){
            //CrdCode Code
            $("#oetCrdCode").attr("disabled", true);
            $('#ocbCreditcardAutoGenCode').change(function(){
                if($('#ocbCreditcardAutoGenCode').is(':checked')) {
                    $('#oetCrdCode').val('');
                    $("#oetCrdCode").attr("disabled", true);
                    $('#odvCreditcardCodeForm').removeClass('has-error');
                    $('#odvCreditcardCodeForm em').remove();
                }else{
                    $("#oetCrdCode").attr("disabled", false);
                }
            });
            JSxCredditcardVisibleComponent('#odvCreditcardAutoGenCode', true);
        }
        
        if(JSbCreditcardIsUpdatePage()){
      
            // Department Code
            $("#oetCrdCode").attr("readonly", true);
            $('#odvCreditcardAutoGenCode input').attr('disabled', true);
            JSxCredditcardVisibleComponent('#odvCreditcardAutoGenCode', false);    
        }
    });

    $('#oetCrdCode').blur(function(){
        JSxCheckCreditcardCodeDupInDB();
    });

    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckCreditcardCodeDupInDB(){

        if(!$('#ocbCreditcardAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMCreditCard",
                    tFieldName: "FTCrdCode",
                    tCode: $("#oetCrdCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCrdCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCrdCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');
                // From Summit Validate
                $('#ofmAddCreditcard').validate({
                    rules: {
                        oetCrdCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbCreditcardAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetCrdName:     {"required" :{}},
                    },
                    messages: {
                        oetCrdCode : {
                            "required"      : $('#oetCrdCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetCrdCode').attr('data-validate-dublicateCode')
                        },
                        oetCrdName : {
                            "required"      : $('#oetCrdName').attr('data-validate-required'),
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
                    submitHandler: function(form){}
                });
                // Submit From
                $('#ofmAddCreditcard').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>