<script type="text/javascript">
    $(document).ready(function(){

        if(JSbSetprinterIsCreatePage()){
            //CrdCode Code
            $("#oetSprCode").attr("disabled", true);
            $('#ocbSetprinerAutoGenCode').change(function(){
                if($('#ocbSetprinerAutoGenCode').is(':checked')) {
                    $('#oetSprCode').val('');
                    $("#oetSprCode").attr("disabled", true);
                    $('#odvSetprinterCodeForm').removeClass('has-error');
                    $('#odvSetprinterCodeForm em').remove();
                }else{
                    $("#oetSprCode").attr("disabled", false);
                }
            });
            JSxSetprinterVisibleComponent('#odvSetprinterAutoGenCode', true);
        }
        
        if(JSbSetprinterIsUpdatePage()){
      
            // Department Code
            $("#oetSprCode").attr("readonly", true);
            $('#odvSetprinterAutoGenCode input').attr('disabled', true);
            JSxSetprinterVisibleComponent('#odvSetprinterAutoGenCode', false);    
        }
    });

    $('#oetSprCode').blur(function(){
        JSxCheckSetprinterCodeDupInDB();
    });

    //Functionality : Event Check 
    //Parameters : Event Blur Input Voucher Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //update : 30/05/2019 saharat(Golf)
    //Return : -
    //Return Type : -
    function JSxCheckSetprinterCodeDupInDB(){
        if(!$('#ocbSetprinerAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMPrinter",
                    tFieldName: "FTPrnCode",
                    tCode: $("#oetSprCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSptCode").val(aResult["rtCode"]);
                     // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateSptCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmSetprinter').validate({
                    rules: {
                        oetSprCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbSetprinerAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetSprName:     {"required" :{}},
                    },
                    messages: {
                        oetSprCode: {
                            "required": $('#oetSprCode').attr('data-validate-required'),
                            "dublicateCode": $('#oetSprCode').attr('data-validate-dublicateCode')
                        },
                        oetSprName: {
                            "required": $('#oetSprName').attr('data-validate-required'),
                            "dublicateCode": $('#oetSprName').attr('data-validate-dublicateCode')
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
                // $('#ofmSetprinter').submit();
                
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

</script>