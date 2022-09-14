<script type="text/javascript">
    $(document).ready(function(){

        if(JSbBookbankIsCreatePage()){
            //BbkCode Code
            $("#oetBbkCode").attr("disabled", true);
            $('#ocbBookbankAutoGenCode').change(function(){
                if($('#ocbBookbankAutoGenCode').is(':checked')) {
                    $('#oetBbkCode').val('');
                    $("#oetBbkCode").attr("disabled", true);
                    $('#odvBbkCodeForm').removeClass('has-error');
                    $('#odvBbkCodeForm em').remove();
                }else{
                    $("#oetBbkCode").attr("disabled", false);
                }
            });
            JSxBookbankVisibleComponent('#odvBbkAutoGenCode', true);
        }
        
        if(JSbBookbankIsUpdatePage()){
            // Department Code
            $("#oetBbkCode").attr("readonly", true);
            $('#odvBbkAutoGenCode input').attr('disabled', true);
            JSxBookbankVisibleComponent('#odvBbkAutoGenCode', false);    
        }
    });

    $('#oetBbkCode').blur(function(){
        JSxCheckBookBankcodeDupInDB();
    });

    $('.selectpicker').selectpicker();

    //Functionality : Event Check BookBank
    //Parameters : Event Blur Input Voucher Code
    //Creator : 04/02/2020 saharat (Golf)
    //Update : -
    //Return : -
    //Return Type : -
    function JSxCheckBookBankcodeDupInDB(){
        if(!$('#ocbBookbanktoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMBookBank",
                    tFieldName: "FTBbkCode",
                    tCode: $("#oetBbkCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateBbkCode").val(aResult["rtCode"]);
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateBbkCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');
                // From Summit Validate
                $('#ofmAddBookbank').validate({
                    rules: {
                        oetBbkCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbBookbankAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetBbkName  :     {"required" :{}},
                        oetBbkAccNo :     {"required" :{}},
                    },
                    messages: {
                        oetBbkCode : {
                            "required"      : $('#oetBbkCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetBbkCode').attr('data-validate-dublicateCode')
                        },
                        oetBbkName : {
                            "required"      : $('#oetBbkName').attr('data-validate-required'),
                        },
                        oetBbkAccNo : {
                            "required"      : $('#oetBbkAccNo').attr('data-validate-required'),
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
                $('#ofmAddBookbank').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

    
</script>