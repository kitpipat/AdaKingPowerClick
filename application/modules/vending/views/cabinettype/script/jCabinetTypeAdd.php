<script type="text/javascript">

    $('.selection-2').selectpicker();

    $(document).ready(function () {
        if(JSbReasonIsCreatePage()){
            $("#oetCBNCode").attr("disabled", true);

            $('#ocbCabinetTypeAutoGenCode').change(function(){
                if($('#ocbCabinetTypeAutoGenCode').is(':checked')) {
                    $('#oetCBNCode').val('');
                    $("#oetCBNCode").attr("disabled", true);
                    $('#odvCabinetTypeCodeForm').removeClass('has-error');
                    $('#odvCabinetTypeCodeForm em').remove();
                }else{
                    $("#oetCBNCode").attr("disabled", false);
                }
            });
            JSxReasonVisibleComponent('#odvCabinetTypeAutoGenCode', true);
        }

        if(JSbReasonIsUpdatePage()){
            // Sale Person Code
            $("#oetCBNCode").attr("readonly", true);
            $('#odvCabinetTypeAutoGenCode input').attr('disabled', true);
            JSxReasonVisibleComponent('#odvCabinetTypeAutoGenCode', false);    
        }

        $('#oetCBNCode').blur(function(){
            JSxCheckReasonCodeDupInDB();
        });
    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckReasonCodeDupInDB(){
        if(!$('#ocbCabinetTypeAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: "TVDMShopType",
                    tFieldName: "FTShtCode",
                    tCode: $("#oetCBNCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateCBNCode").val(aResult["rtCode"]);
                    JSxReasonSetValidEventBlur();
                    $('#ofmAddCabinetType').submit();
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
        $('#ofmAddCabinetType').validate().destroy();

            // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateCBNCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddCabinetType').validate({
            rules: {
                oetCBNCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbCabinetTypeAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetCBNName:     {"required" :{}},
            },
            messages: {
                oetCBNCode : {
                    "required"      : $('#oetCBNCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetCBNCode').attr('data-validate-dublicateCode')
                },
                oetCBNName : {
                    "required"      : $('#oetCBNName').attr('data-validate-required'),
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