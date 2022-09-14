<script type="text/javascript">
    $(document).ready(function(){
        
        if(JSbCustomerOcpIsCreatePage()){
            //CustomerOcp Code
            $("#oetCstOcpCode").attr("disabled", true);
            $('#ocbCstOcpAutoGenCode').change(function(){
                if($('#ocbCstOcpAutoGenCode').is(':checked')) {
                    $('#oetCstOcpCode').val('');
                    $("#oetCstOcpCode").attr("disabled", true);
                    $('#odvCustomerOcpCodeForm').removeClass('has-error');
                    $('#odvCustomerOcpCodeForm em').remove();
                }else{
                    $("#oetCstOcpCode").attr("disabled", false);
                }
            });
            JSxCustomerOcpVisibleComponent('#odvCstOcpAutoGenCode', true);
        }
        
        if(JSbCustomerOcplIsUpdatePage()){ 
            // CustomerOcp Code
            $("#oetCstOcpCode").attr("readonly", true);
            $('#odvCstOcpAutoGenCode input').attr('disabled', true);
            JSxCustomerOcpVisibleComponent('#odvCstOcpAutoGenCode', false);    
        }
    });

    $('#oetCstOcpCode').blur(function(){
        JSxChecCustomerOcpCodeDupInDB();
    });

    //Functionality : Event Check CustomerOcp
    //Parameters : Event Blur Input CustomerOcp Code
    //Creator : 09/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxChecCustomerOcpCodeDupInDB(){
        if(!$('#ocbCstOcpAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCstOcp",
                    tFieldName: "FTOcpCode",
                    tCode: $("#oetCstOcpCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCstOcpCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCstOcpCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddCstOcp').validate({
                    rules: {
                        oetCstOcpCode : {
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
                        oetCstOcpName:     {"required" :{}},
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
                    highlight: function ( element, errorClass, validClass ) {
                        $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                    },
                    unhighlight: function (element, errorClass, validClass) {
                        $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                    },
                    submitHandler: function(form){}
                });
                // Submit From
                $('#ofmAddCstOcp').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

</script>