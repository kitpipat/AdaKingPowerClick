<script type="text/javascript">
    $(document).ready(function(){

        if(JSbCoupontypeIsCreatePage()){
            // Coupontype Code
            $("#oetCptCode").attr("disabled", true);
            $('#ocbCoupontypeAutoGenCode').change(function(){
                if($('#ocbCoupontypeAutoGenCode').is(':checked')) {
                    $('#oetCptCode').val('');
                    $("#oetCptCode").attr("disabled", true);
                    $('#odvCoupontypeCodeForm').removeClass('has-error');
                    $('#odvCoupontypeCodeForm em').remove();
                }else{
                    $("#oetCptCode").attr("disabled", false);
                }
            });
            JSxCoupontypeVisibleComponent('#odvCoupontypeAutoGenCode', true);
        }
        
        if(JSbCoupontypeIsUpdatePage()){
            // Department Code
            $("#oetCptCode").attr("readonly", true);
            $('#odvCoupontypeAutoGenCode input').attr('disabled', true);
            JSxCoupontypeVisibleComponent('#odvCoupontypeAutoGenCode', false);    
        }
    });

    $('#oetCptCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check Voucher
    //Parameters : Event Blur Input Voucher Code
    //Creator : 02/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        
        if(!$('#ocbCoupontypeAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMCouponType",
                    tFieldName: "FTCptCode",
                    tCode: $("#oetCptCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                // alert(tResult);
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCptCode").val(aResult["rtCode"]);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

            // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdCheckDuplicateCptCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            },'');

            // From Summit Validate
            $('#ofmAddCoupontype').validate({
                rules: {
                    oetVotCode : {
                        "required" :{
                            // ตรวจสอบเงื่อนไข validate
                            depends: function(oElement) {
                            if($('#ocbCoupontypeAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                            }
                        },
                        "dublicateCode" :{}
                    },
                    oetCptName:     {"required" :{}},
                },
                messages: {
                    oetCptCode : {
                        "required"      : $('#oetCptCode').attr('data-validate-required'),
                        "dublicateCode" : $('#oetCptCode').attr('data-validate-dublicateCode')
                    },
                    oetCptName : {
                        "required"      : $('#oetCptName').attr('data-validate-required'),
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
            $('#ofmAddCoupontype').submit();

        }    
    }

    





</script>