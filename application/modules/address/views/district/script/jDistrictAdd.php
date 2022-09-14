<script type="text/javascript">
    // $('.selection-2').selectpicker();


    $(document).ready(function () {
        if(JSbDstIsCreatePage()){
            // Dst Code
            $("#oetDstCode").attr("disabled", true);
            $('#ocbDstAutoGenCode').change(function(){
                if($('#ocbDstAutoGenCode').is(':checked')) {
                    $('#oetDstCode').val('');
                    $("#oetDstCode").attr("disabled", true);
                    $('#odvDstCodeForm').removeClass('has-error');
                    $('#odvDstCodeForm em').remove();
                }else{
                    $("#oetDstCode").attr("disabled", false);
                }
            });
            JSxDstVisibleComponent('#odvDistrictAutoGenCode', true);
        }

        if(JSbDstIsUpdatePage()){
            // Sale Person Code
            $("#oetDstCode").attr("readonly", true);
            $('#odvDistrictAutoGenCode input').attr('disabled', true);
            JSxDstVisibleComponent('#odvDistrictAutoGenCode', false);    
        }

        $('#oetDstCode').blur(function(){
            JSxCheckDstCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckDstCodeDupInDB(){
        if(!$('#ocbDstAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMDistrict",
                    tFieldName: "FTDstCode",
                    tCode: $("#oetDstCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateDstCode").val(aResult["rtCode"]);
                    JSxDstSetValidEventBlur();
                    $('#ofmAddDistrict').submit();
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
    function JSxDstSetValidEventBlur(){
        $('#ofmAddDistrict').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateDstCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddDistrict').validate({
            rules: {
                oetDstCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbDstAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                
                oetDstName:     {"required" :{}},
            },
            messages: {
                oetDstCode : {
                    "required"      : $('#oetDstCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetDstCode').attr('data-validate-dublicateCode')
                },
                oetDstName : {
                    "required"      : $('#oetDstName').attr('data-validate-required'),
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