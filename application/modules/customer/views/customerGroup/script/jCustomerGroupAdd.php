<script type="text/javascript">
    $(document).ready(function(){
  
        if(JSbCustomerGroupIsCreatePage()){
            //CustomerGroup Code
            $("#oetCstGrpCode").attr("disabled", true);
            $('#ocbCustomerGroupAutoGenCode').change(function(){
                if($('#ocbCustomerGroupAutoGenCode').is(':checked')) {
                    $('#oetCstGrpCode').val('');
                    $("#oetCstGrpCode").attr("disabled", true);
                    $('#odvCstGrpCodeForm').removeClass('has-error');
                    $('#odvCstGrpCodeForm em').remove();
                }else{
                    $("#oetCstGrpCode").attr("disabled", false);
                }
            });
            JSxCustomerGroupVisibleComponent('#odvCstGrpAutoGenCode', true);
        }
        
        if(JSbCustomerGroupIsUpdatePage()){
      
            // CustomerGroup Code
            $("#oetCstGrpCode").attr("readonly", true);
            $('#odvCstGrpAutoGenCode input').attr('disabled', true);
            JSxCustomerGroupVisibleComponent('#odvCstGrpAutoGenCode', false);    
        }
    });

    $('#oetCstGrpCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check CustomerGroup
    //Parameters : Event Blur Input CustomerGroup Code
    //Creator : 08/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        if(!$('#ocbCustomerGroupAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCstGrp",
                    tFieldName: "FTCgpCode",
                    tCode: $("#oetCstGrpCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCstGrpCode").val(aResult["rtCode"]);
                    // Set Validate CustomerGroup Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCstGrpCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddCstGrp').validate({
                    rules: {
                        oetCstGrpCode : {
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
                        oetCstGrpName:     {"required" :{}},
                    },
                    messages: {
                        oetCstGrpCode : {
                            "required"      : $('#oetCstGrpCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetCstGrpCode').attr('data-validate-dublicateCode')
                        },
                        oetCstGrpName : {
                            "required"      : $('#oetCstGrpName').attr('data-validate-required'),
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
                $('#ofmAddCstGrp').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>