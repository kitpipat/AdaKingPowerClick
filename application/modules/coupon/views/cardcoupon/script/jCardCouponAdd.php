<script type="text/javascript">
    $(document).ready(function(){

        if(JSbCardCouponIsCreatePage()){
            // Coupontype Code
            $("#oetCclCode").attr("disabled", true);
            $('#ocbCardCouponAutoGenCode').change(function(){
                if($('#ocbCardCouponAutoGenCode').is(':checked')) {
                    $('#oetCclCode').val('');
                    $("#oetCclCode").attr("disabled", true);
                    $('#odvCardCouponCodeForm').removeClass('has-error');
                    $('#odvCardCouponCodeForm em').remove();
                }else{
                    $("#oetCclCode").attr("disabled", false);
                }
            });
            JSxCardCouponVisibleComponent('#odvCardCouponAutoGenCode', true);
        }
        
        if(JSbCardCouponIsUpdatePage()){
            // Department Code
            $("#oetCclCode").attr("readonly", true);
            $('#odvCardCouponAutoGenCode input').attr('disabled', true);
            JSxCardCouponVisibleComponent('#odvCardCouponAutoGenCode', false);    
        }
    });

    $('#oetCclCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 02/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        
        if(!$('#ocbCardCouponAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMCrdCpnList",
                    tFieldName: "FTCclCode",
                    tCode: $("#oetCclCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCptCode").val(aResult["rtCode"]);     
                    // Set Validate Dublicate Code
                    $.validator.addMethod('dublicateCode', function(value, element) {
                        if($("#ohdCheckDuplicateCptCode").val() == 1){
                            return false;
                        }else{
                            return true;
                        }
                    },'');

                    // From Summit Validate
                    $('#ofmAddCardCoupon').validate({
                        rules: {
                            oetCclCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbCardCouponAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                    }
                                },
                                "dublicateCode" :{}
                            },
                            oetCclName:     {"required" :{}},
                        },
                        messages: {
                            oetCclCode : {
                                "required"      : $('#oetCclCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetCclCode').attr('data-validate-dublicateCode')
                            },
                            oetCclName : {
                                "required"      : $('#oetCclName').attr('data-validate-required'),
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
                    $('#ofmAddCardCoupon').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

</script>