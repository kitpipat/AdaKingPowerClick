<script type="text/javascript">
    $(document).ready(function(){

        if(JSbShipviaIsCreatePage()){
            // Shipvia Code
            $("#oetViaCode").attr("disabled", true);
            $('#ocbShipviaAutoGenCode').change(function(){
                if($('#ocbShipviaAutoGenCode').is(':checked')) {
                    $('#oetViaCode').val('');
                    $("#oetViaCode").attr("disabled", true);
                    $('#odvShipviaCodeForm').removeClass('has-error');
                    $('#odvShipviaCodeForm em').remove();
                }else{
                    $("#oetViaCode").attr("disabled", false);
                }
            });
            JSxShipviaVisibleComponent('#odvShipviaAutoGenCode', true);
        }
        
        if(JSbShipviaIsUpdatePage()){
            // Department Code
            $("#oetViaCode").attr("readonly", true);
            $('#odvShipviaAutoGenCode input').attr('disabled', true);
            JSxShipviaVisibleComponent('#odvShipviaAutoGenCode', false);    
        }
    });

    $('#oetViaCode').blur(function(){
        JSxCheckShipviaCodeDupInDB();
    });

    //Functionality : Event Check ShipVia
    //Parameters : Event Blur Input ShipVia Code
    //Creator : 02/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckShipviaCodeDupInDB(){
        if(!$('#ocbShipviaAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMShipVia",
                    tFieldName: "FTViaCode",
                    tCode: $("#oetViaCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateViaCode").val(aResult["rtCode"]); 
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateViaCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddShipVia').validate({
                    rules: {
                        oetViaCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbShipviaAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetViaName:     {"required" :{}},
                    },
                    messages: {
                        oetViaCode : {
                            "required"      : $('#oetViaCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetViaCode').attr('data-validate-dublicateCode')
                        },
                        oetViaName : {
                            "required"      : $('#oetViaName').attr('data-validate-required'),
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
                $('#ofmAddShipVia').submit();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }    
    }

 
</script>