<script type="text/javascript">
    // $('.selection-2').selectpicker();


    $(document).ready(function () {
        if(JSbPvnIsCreatePage()){
            // Pvn Code
            $("#oetPvnCode").attr("disabled", true);
            $('#ocbPvnAutoGenCode').change(function(){
                if($('#ocbPvnAutoGenCode').is(':checked')) {
                    $('#oetPvnCode').val('');
                    $("#oetPvnCode").attr("disabled", true);
                    $('#odvPvnCodeForm').removeClass('has-error');
                    $('#odvPvnCodeForm em').remove();
                }else{
                    $("#oetPvnCode").attr("disabled", false);
                }
            });
            JSxPvnVisibleComponent('#odvPvnAutoGenCode', true);
        }

        if(JSbPvnIsUpdatePage()){
            // Sale Person Code
            $("#oetPvnCode").attr("readonly", true);
            $('#odvPvnAutoGenCode input').attr('disabled', true);
            JSxPvnVisibleComponent('#odvPvnAutoGenCode', false);    
        }

        $('#oetPvnCode').blur(function(){
            JSxCheckPvnCodeDupInDB();
        });

    });

    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckPvnCodeDupInDB(){
        if(!$('#ocbPvnAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMProvince",
                    tFieldName: "FTPvnCode",
                    tCode: $("#oetPvnCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicatePvnCode").val(aResult["rtCode"]);
                    JSxPvnSetValidEventBlur();
                    $('#ofmAddProvince').submit();
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
    function JSxPvnSetValidEventBlur(){
        $('#ofmAddProvince').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicatePvnCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddProvince').validate({
            rules: {
                oetPvnCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbPvnAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                
                oetPvnName:     {"required" :{}},
            },
            messages: {
                oetPvnCode : {
                    "required"      : $('#oetPvnCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetPvnCode').attr('data-validate-dublicateCode')
                },
                oetPvnName : {
                    "required"      : $('#oetPvnName').attr('data-validate-required'),
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