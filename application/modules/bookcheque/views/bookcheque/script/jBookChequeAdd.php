<script type="text/javascript">
    $(document).ready(function(){

    
    if(JSBookChequeIsUpdatePage()){
        $("#oetChqCode").attr("readonly", true);
        $('#odvChqAutoGenCode input').attr('disabled', true);
        JSxBookChequeVisibleComponent('#odvChqAutoGenCode', false);    

        }
    });
    
    $('#oetChqCode').blur(function(){
        JSxCheckChqCodeDupInDB();
    });

    //Functionality : Event Check Agency
    //Parameters : Event Blur Input Agency Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Update : 30/05/2019 saharat (Golf)
    //Return : -
    //Return Type : -
    function JSxCheckChqCodeDupInDB(){
        if(!$('#ocbChqAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMBookCheque",
                    tFieldName: "FTChqCode",
                    tCode: $("#oetChqCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateChqCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateChqCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddBookCheque').validate({
                    rules: {
                        oetChqCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbChqAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetChqName:     {"required" :{}},
                        // oetAgnEmail:     {"required" :{}},
                    },
                    messages: {
                        oetChqCode : {
                            "required"      : $('#oetChqCode').attr('data-validate-required'),
                            "dublicateCode" : $('#oetChqCode').attr('data-validate-dublicateCode')
                        },
                        oetChqName : {
                            "required"      : $('#oetChqName').attr('data-validate-required'),
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
                $('#ofmAddBookCheque').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }


</script>