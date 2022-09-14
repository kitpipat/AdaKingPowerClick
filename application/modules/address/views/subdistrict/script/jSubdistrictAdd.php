<script type="text/javascript">
    // $('.selection-2').selectpicker();


    $(document).ready(function () {
        if(JSbSdtIsCreatePage()){
            // Sdt Code
            $("#oetSdtCode").attr("disabled", true);
            $('#ocbSubdistrictAutoGenCode').change(function(){
                if($('#ocbSubdistrictAutoGenCode').is(':checked')) {
                    $('#oetSdtCode').val('');
                    $("#oetSdtCode").attr("disabled", true);
                    $('#odvSubdistrictCodeForm').removeClass('has-error');
                    $('#odvSubdistrictCodeForm em').remove();
                }else{
                    $("#oetSdtCode").attr("disabled", false);
                }
            });
            JSxSdtVisibleComponent('#odvDistrictAutoGenCode', true);
        }

        if(JSbSdtIsUpdatePage()){
            // Sale Person Code
            $("#oetSdtCode").attr("readonly", true);
            $('#odvDistrictAutoGenCode input').attr('disabled', true);
            JSxSdtVisibleComponent('#odvDistrictAutoGenCode', false);    
        }

        $('#oetSdtCode').blur(function(){
            JSxCheckSdtCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckSdtCodeDupInDB(){
        if(!$('#ocbSubdistrictAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMSubDistrict",
                    tFieldName: "FTSudCode",
                    tCode: $("#oetSdtCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateSdtCode").val(aResult["rtCode"]);
                    JSxSdtSetValidEventBlur();
                    $('#ofmAddSubdistrict').submit();
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
    function JSxSdtSetValidEventBlur(){
        $('#ofmAddSubdistrict').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateSdtCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddSubdistrict').validate({
            rules: {
                oetSdtCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbSubdistrictAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                
                oetSdtName:     {"required" :{}},
            },
            messages: {
                oetSdtCode : {
                    "required"      : $('#oetSdtCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetSdtCode').attr('data-validate-dublicateCode')
                },
                oetSdtName : {
                    "required"      : $('#oetSdtName').attr('data-validate-required'),
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