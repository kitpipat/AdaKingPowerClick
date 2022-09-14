<script type="text/javascript">
    $('.selection-2').selectpicker();

    $('#ocmRcnGroup').change(function() {
        $('#ocmRcnGroup-error').hide();
    });

    $(document).ready(function () {
        if(JSbReasonIsCreatePage()){
            // Reason Code
            $("#oetRacCode").attr("disabled", true);
            $('#ocbRacAutoGenCode').change(function(){
                if($('#ocbRacAutoGenCode').is(':checked')) {
                    $('#oetRacCode').val('');
                    $("#oetRacCode").attr("disabled", true);
                    $('#odvRacCodeForm').removeClass('has-error');
                    $('#odvRacCodeForm em').remove();
                }else{
                    $("#oetRacCode").attr("disabled", false);
                }
            });
            JSxReasonVisibleComponent('#odvRacAutoGenCode', true);
        }

        if(JSbReasonIsUpdatePage()){
            // Sale Person Code
            $("#oetRacCode").attr("readonly", true);
            $('#odvRacAutoGenCode input').attr('disabled', true);
            JSxReasonVisibleComponent('#odvRacAutoGenCode', false);    
        }

        $('#oetRacCode').blur(function(){
            JSxCheckReasonCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckReasonCodeDupInDB(){
        if(!$('#ocbRacAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TRTMShopRack",
                    tFieldName: "FTRakCode",
                    tCode: $("#oetRacCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateRacCode").val(aResult["rtCode"]);
                    JSxReasonSetValidEventBlur();
                    $('#ofmAddRac').submit();
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
    function JSxReasonSetValidEventBlur(){
        $('#ofmAddRac').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateRacCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddRac').validate({
            rules: {
                oetRacCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbRacAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetRacName:     {"required" :{}}
            },
            messages: {
                oetRacCode : {
                    "required"      : $('#oetRacCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetRacCode').attr('data-validate-dublicateCode')
                },
                oetRacName : {
                    "required"      : $('#oetRacName').attr('data-validate-required'),
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