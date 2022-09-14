<script type="text/javascript">
    $(document).ready(function(){
    
        if(JCNCstOcpIsCreatePage()){
            //Coupon Code
            $("#oetCstCode").attr("disabled", true);
            $('#ocbCustomerAutoGenCode').change(function(){
                if($('#ocbCustomerAutoGenCode').is(':checked')) {
                    $('#oetCstCode').val('');
                    $("#oetCstCode").attr("disabled", true);
                    $('#odvCstCodeForm').removeClass('has-error');
                    $('#odvCstCodeForm em').remove();
                }else{
                    $("#oetCstCode").attr("disabled", false);
                }
            });
            JSxCouponVisibleComponent('#odvCstAutoGenCode',true);
        }
        
        if(JSbCouponIsUpdatePage()){
            // Department Code
            $("#oetCstCode").attr("readonly", true);
            $('#odvCstAutoGenCode input').attr('disabled', true);
            JSxCouponVisibleComponent('#odvCstAutoGenCode', false);    
        }
    });

    $('#oetCstCode').blur(function(){
        // alert('65555');
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        if(!$('#ocbCustomerAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCst",
                    tFieldName: "FTCstCode",
                    tCode: $("#oetCstCode").val()
                },
                success: function(tResult){
                // alert(tResult);
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCstCode").val(aResult["rtCode"]);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

            // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdCheckDuplicateCstCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            },'');

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
                        "dublicateCode" :{}
                    },
                    oetCstName  : {"required" :{}},
                },
                messages: {
                    oetCstCode : {
                        "required"      : $('#oetCpnCode').attr('data-validate-required'),
                        "dublicateCode" : $('#oetCpnCode').attr('data-validate-dublicateCode')
                    },
                    oetCstName : {
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
            $('#ofmAddCustomerInfo1').submit();
        }    
    }


   





</script>