<script type="text/javascript">
    $(document).ready(function(){
        if(JSbCustomerLevelIsCreatePage()){
            //CustomerLevel Code
            $("#oetCstLevCode").attr("disabled", true);
            $('#ocbCustomerLevelAutoGenCode').change(function(){
                if($('#ocbCustomerLevelAutoGenCode').is(':checked')) {
                    $('#oetCstLevCode').val('');
                    $("#oetCstLevCode").attr("disabled", true);
                    $('#odvCstLevCodeForm').removeClass('has-error');
                    $('#odvCstLevCodeForm em').remove();
                }else{
                    $("#oetCstLevCode").attr("disabled", false);
                }
            });
            JSxCustomerLevelVisibleComponent('#odvCstLevAutoGenCode', true);
        }
        
        if(JSbCustomerLevelIsUpdatePage()){
      
            // CustomerLevel Code
            $("#oetCstLevCode").attr("readonly", true);
            $('#odvCstLevAutoGenCode input').attr('disabled', true);
            JSxCustomerLevelVisibleComponent('#odvCstLevAutoGenCode', false);    
        }
    });

    $('#oetCstLevCode').blur(function(){
        JSxCheckCustomerLevelCodeDupInDB();
    });

    //Functionality : Event Check CustomerLevel
    //Parameters : Event Blur Input CustomerLevel Code
    //Creator : 08/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckCustomerLevelCodeDupInDB(){
        if(!$('#ocbCustomerLevelAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMCstLev",
                    tFieldName: "FTClvCode",
                    tCode: $("#oetCstLevCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                // alert(tResult);
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCstLevCode").val(aResult["rtCode"]);      
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateCstLevCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddCstLev').validate({
                    rules: {
                        oetCstLevCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbCustomerLevelAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetCstLevName:     {"required" :{}},
                    },
                    messages: {
                        oetCstLevCode : {
                            "required"      : $('#oetCstLevCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetCstLevCode').attr('data-validate-dublicateCode')
                        },
                        oetCstLevName : {
                            "required"      : $('#oetCstLevName').attr('data-validate-required'),
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
                $('#ofmAddCstLev').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

</script>