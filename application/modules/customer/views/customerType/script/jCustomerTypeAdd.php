<script type="text/javascript">
    $(document).ready(function(){

        if(JSbCustomerTypeIsCreatePage()){
            //customerType Code
            $("#oetCstTypeCode").attr("disabled", true);
            $('#ocbCstTypeAutoGenCode').change(function(){
                if($('#ocbCstTypeAutoGenCode').is(':checked')) {
                    $('#oetCstTypeCode').val('');
                    $("#oetCstTypeCode").attr("disabled", true);
                    $('#odvCustomerTypeCodeForm').removeClass('has-error');
                    $('#odvCustomerTypeCodeForm em').remove();
                }else{
                    $("#oetCstTypeCode").attr("disabled", false);
                }
            });
            JSxCustomerTypeVisibleComponent('#odvCstTypeAutoGenCode', true);
        }
        
        if(JSbCustomerTypeIsUpdatePage()){
      
            // customerType Code
            $("#oetCstTypeCode").attr("readonly", true);
            $('#odvCstTypeAutoGenCode input').attr('disabled', true);
            JSxCustomerTypeVisibleComponent('#odvCstTypeAutoGenCode', false);    
        }
    });

    $('#oetCstTypeCode').blur(function(){
        JSxCheckCustomerTypeCodeDupInDB();
    });

    //Functionality : Event Check customerType
    //Parameters : Event Blur Input customerType Code
    //Creator : 05/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckCustomerTypeCodeDupInDB(){
        if(!$('#ocbCstTypeAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCstType",
                    tFieldName: "FTCtyCode",
                    tCode: $("#oetCstTypeCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCstTypeCode").val(aResult["rtCode"]);
                                // Set Validate CustomerType Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCstTypeCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddCstType').validate({
                    rules: {
                        oetCstTypeCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbCouponAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetCstTypeName:     {"required" :{}},
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
                    $('#ofmAddCstType').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }


</script>