<script type="text/javascript">
    $(document).ready(function(){
    
        if(JSbCouponIsCreatePage()){
            //Coupon Code
            $("#oetCpnCode").attr("disabled", true);
            $('#ocbCouponAutoGenCode').change(function(){
                if($('#ocbCouponAutoGenCode').is(':checked')) {
                    $('#oetCpnCode').val('');
                    $("#oetCpnCode").attr("disabled", true);
                    $('#odvCpnCodeForm').removeClass('has-error');
                    $('#odvCpnCodeForm em').remove();
                }else{
                    $("#oetCpnCode").attr("disabled", false);
                }
            });
            JSxCouponVisibleComponent('#odvCpnAutoGenCode', true);
        }
        
        if(JSbCouponIsUpdatePage()){
      
            // Department Code
            $("#oetCpnCode").attr("readonly", true);
            $('#odvCpnAutoGenCode input').attr('disabled', true);
            JSxCouponVisibleComponent('#odvCpnAutoGenCode', false);    
        }
    });

    $('#oetCpnCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        if(!$('#ocbCouponAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMCoupon",
                    tFieldName: "FTCpnCode",
                    tCode: $("#oetCpnCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCpnCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCpnCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddCoupon').validate({
                    rules: {
                        oetCpnCode : {
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
                        oetCpnName:     {"required" :{}},
                    },
                    messages: {
                        oetCpnCode : {
                            "required"      : $('#oetCpnCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetCpnCode').attr('data-validate-dublicateCode')
                        },
                        oetCpnName : {
                            "required"      : $('#oetCpnName').attr('data-validate-required'),
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
                $('#ofmAddCoupon').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }
</script>