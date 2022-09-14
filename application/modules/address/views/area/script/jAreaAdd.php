<script type="text/javascript">
    // $('.selection-2').selectpicker();
    $(document).ready(function () {
        if(JSbAreIsCreatePage()){
            // Are Code
            $("#oetAreCode").attr("disabled", true);
            $('#ocbAreAutoGenCode').change(function(){
                if($('#ocbAreAutoGenCode').is(':checked')) {
                    $('#oetAreCode').val('');
                    $("#oetAreCode").attr("disabled", true);
                    $('#odvAreCodeForm').removeClass('has-error');
                    $('#odvAreCodeForm em').remove();
                }else{
                    $("#oetAreCode").attr("disabled", false);
                }
            });
            JSxAreVisibleComponent('#odvAreAutoGenCode', true);
        }

        if(JSbAreIsUpdatePage()){
            // Sale Person Code
            $("#oetAreCode").attr("readonly", true);
            $('#odvAreAutoGenCode input').attr('disabled', true);
            JSxAreVisibleComponent('#odvAreAutoGenCode', false);    
        }

        $('#oetAreCode').blur(function(){
            JSxCheckAreCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckAreCodeDupInDB(){
        if(!$('#ocbAreAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMArea",
                    tFieldName: "FTAreCode",
                    tCode: $("#oetAreCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateAreCode").val(aResult["rtCode"]);
                    JSxAreSetValidEventBlur();
                    $('#ofmAddAre').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }

    //Functionality: Set Validate Event Blur
    //Parameters: Validate Event Blur
    //Creator: 26/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxAreSetValidEventBlur(){
        $('#ofmAddAre').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateAreCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddAre').validate({
            rules: {
                oetAreCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbAreAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                
                oetAreName:     {"required" :{}},
            },
            messages: {
                oetAreCode : {
                    "required"      : $('#oetAreCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetAreCode').attr('data-validate-dublicateCode')
                },
                oetAreName : {
                    "required"      : $('#oetAreName').attr('data-validate-required'),
                }
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
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid  = $(element).parents('.form-group').find('.help-block').length
                if(nStaCheckValid != 0){
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                }
            },
            submitHandler: function(form){}
        });
    }

</script>