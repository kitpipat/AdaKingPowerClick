<script type="text/javascript">
    $(document).ready(function(){
    
        if(JSbSupplierIsCreatePage()){
            //supplierlev Code
            $("#oetSplCode").attr("disabled", true);
            $('#ocbSplAutoGenCode').change(function(){
                if($('#ocbSplAutoGenCode').is(':checked')) {
                    $('#oetSplCode').val('');
                    $("#oetSplCode").attr("disabled", true);
                    $('#odvSplCodeForm').removeClass('has-error');
                    $('#odvSplCodeForm em').remove();
                }else{
                    $("#oetSplCode").attr("disabled", false);
                }
            });
            JSxSupplierVisibleComponent('#odvSupplierAutoGenCode', true);
        }
        
        if(JSbSupplierUpdatePage()){
            // supplierlev Code
            $("#oetSplCode").attr("readonly", true);
            $('#odvSupplierAutoGenCode input').attr('disabled', true);
            JSxSupplierVisibleComponent('#odvSupplierAutoGenCode', false);    
        }
    });

    $('#oetSplCode').blur(function(){
        // alert('65555');
        JSxCheckSupplierlevCodeDupInDB();
    });
  
    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Return : -
    //Return Type : -
    function JSxCheckSupplierlevCodeDupInDB(){
        if(!$('#ocbSplAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSpl",
                    tFieldName: "FTSplCode",
                    tCode: $("#oetSplCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                // alert(tResult);
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSpl").val(aResult["rtCode"]);
                    // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateSpl").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddsupplier1').validate({
                    rules: {
                        oetSplCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbSplAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetSplName:     {"required" :{}},
                        oemtSplEmail:     {"email" :{}},
                    },
                    messages: {
                        oetSplCode : {
                            "required"      : $('#oetSplCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetSplCode').attr('data-validate-dublicateCode')
                        },
                        oetSplName : {
                            "required"      : $('#oetSplName').attr('data-validate-required'),
                        },
                        oemtSplEmail : {
                            "email"      : $('#oemtSplEmail').attr('data-validate-email'),
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
                $('#ofmAddsupplier1').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

            

        }    
    }







</script>
