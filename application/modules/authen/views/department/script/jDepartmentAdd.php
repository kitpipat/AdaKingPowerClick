<script type="text/javascript">
    $(document).ready(function(){
        if(JSbDepartmentIsCreatePage()){
            // Department Code
            $("#oetDptCode").attr("disabled", true);
            $('#ocbDepartmentAutoGenCode').change(function(){
                if($('#ocbDepartmentAutoGenCode').is(':checked')) {
                    $('#oetDptCode').val('');
                    $("#oetDptCode").attr("disabled", true);
                    $('#odvDepartmentCodeForm').removeClass('has-error');
                    $('#odvDepartmentCodeForm em').remove();
                }else{
                    $("#oetDptCode").attr("disabled", false);
                }
            });
            JSxDepartmentVisibleComponent('#odvDepartmentAutoGenCode', true);
        }
        
        if(JSbDepartmentIsUpdatePage()){
            // Department Code
            $("#oetDptCode").attr("readonly", true);
            $('#odvDepartmentAutoGenCode input').attr('disabled', true);
            JSxDepartmentVisibleComponent('#odvDepartmentAutoGenCode', false);    
        }
    });

    $('#oetDptCode').blur(function(){
        JSxCheckDepartmentCodeDupInDB();
    });

    //Functionality : Event Check Department Duplicate
    //Parameters : Event Blur Input Department Code
    //Creator : 25/03/2019 wasin (Yoshi)
    //Return : -
    //Return Type : -
    function JSxCheckDepartmentCodeDupInDB(){
        if(!$('#ocbDepartmentAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMUsrDepart",
                    tFieldName: "FTDptCode",
                    tCode: $("#oetDptCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateDptCode").val(aResult["rtCode"]);
                    $('#ofmAddEditDepartment').validate({
                        rules: {
                            oetDptCode : {
                                "required" :{
                                    // ตรวจสอบเงื่อนไข validate
                                    depends: function(oElement) {
                                    if($('#ocbDepartmentAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                    }
                                },
                                "dublicateCode" :{}
                            },
                            oetDptName:     {"required" :{}},
                        },
                        messages: {
                            oetDptCode : {
                                "required"      : $('#oetDptCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetDptCode').attr('data-validate-dublicateCode')
                            },
                            oetDptName : {
                                "required"      : $('#oetDptName').attr('data-validate-required'),
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
                    $('#ofmAddEditDepartment').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

            // Set Validate Dublicate Code
            $.validator.addMethod('dublicateCode', function(value, element) {
                if($("#ohdCheckDuplicateDptCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            },'');

            // From Summit Validate
            
        }    
    }







</script>