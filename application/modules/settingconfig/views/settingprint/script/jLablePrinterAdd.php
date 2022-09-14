<script type="text/javascript">
    $(document).ready(function(){
  
        if(JSbLabPriIsCreatePage()){
            //Lable Printer Code
            $("#oetLabPriCode").attr("disabled", true);
            $('#ocbLabPriAutoGenCode').change(function(){
                if($('#ocbLabPriAutoGenCode').is(':checked')) {
                    $('#oetLabPriCode').val('');
                    $("#oetLabPriCode").attr("disabled", true);
                    $('#odvLabPriCodeForm').removeClass('has-error');
                    $('#odvLabPriCodeForm em').remove();
                }else{
                    $("#oetLabPriCode").attr("disabled", false);
                }
            });
            JSxLabPriVisibleComponent('#odvLabPriAutoGenCode', true);
        }
        
        if(JSbLabPriIsUpdatePage()){
      
            // Lable Printer Code
            $("#oetLabPriCode").attr("readonly", true);
            $('#odvLabPriAutoGenCode input').attr('disabled', true);
            JSxLabPriVisibleComponent('#odvLabPriAutoGenCode', false);    
        }
    });

    // $('#oetLabPriCode').blur(function(){
    //     JSxCheckDepartmentCodeDupInDB();
    // });

    //Functionality : Event Check Lable Printer
    //Parameters : Event Blur Input Lable Printer Code
    //Creator : 21/12/2021 Worakorn
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        if(!$('#ocbLabPriAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMPrnLabel",
                    tFieldName: "FTPlbCode",
                    tCode: $("#oetLabPriCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateLabPriCode").val(aResult["rtCode"]);
                    // Set Validate Lable Printer Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateLabPriCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddLabPri').validate({
                    rules: {
                        oetLabPriCode : {
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
                        oetLabPriName:     {"required" :{}},
                    },
                    messages: {
                        oetLabPriCode : {
                            "required"      : $('#oetLabPriCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetLabPriCode').attr('data-validate-dublicateCode')
                        },
                        oetLabPriName : {
                            "required"      : $('#oetLabPriName').attr('data-validate-required'),
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
                $('#ofmAddLabPri').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }







</script>