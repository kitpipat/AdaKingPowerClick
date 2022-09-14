<script type="text/javascript">

 // ตรวจสอบระดับของ User  07/02/2020 Saharat(Golf)
 var tStaUsrLevel    = '<?php  echo $this->session->userdata("tSesUsrLevel"); ?>';
    var tUsrBchCode     = '<?php  echo $this->session->userdata("tSesUsrBchCodeDefault"); ?>';
    var tUsrBchName     = '<?php  echo $this->session->userdata("tSesUsrBchNameDefault"); ?>';

    $(document).ready(function(){
        
      // ตรวจสอบระดับUser banch  07/02/2020 Saharat(Golf)
    //   if(tUsrBchCode  != ""){ 
    //         $('#oetBbkBchCode').val(tUsrBchCode);
    //         $('#oetBbkBchName').val(tUsrBchName);
    //         $('#obtBbkBrowseBch').attr("disabled", true);
    //     }
        
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
        // JSxCheckBookBankcodeDupInDB();
    });

    //Functionality : Event Check BookBank
    //Parameters : Event Blur Input Voucher Code
    //Creator : 04/02/2020 saharat (Golf)
    //Update : -
    //Return : -
    //Return Type : -
    function JSxCheckBookBankcodeDupInDB(){
        if(!$('#ocbBookbanktoGenCode').is(':checked')){
            // From Summit Validate
            // if($('#oetBbkBchName').val() == ''){
            //     $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            // }
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TFNMBookBank",
                    tFieldName: "FTBbkCode",
                    tCode: $("#oetBbkCode").val(),
                    tFiledBch: 'FTBchCode',
                    tBchCode: $("#oetBchCode").val()
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
                        oetBbkName    :     {"required" :{}},
                        oetBbkAccNo   :     {"required" :{}},
                        oetBbkBchName :     {"required" :{}},
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
                        oetBbkBchName : {
                            "required"      : $('#oetBbkBchName').attr('data-validate-required'),
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

    $( "#oliBBKDetail" ).click(function() {
        JSvBookbankContentDetail();
    });

    $( "#oliBBKAccountActivity" ).click(function() {
        JSvkBookbankContentAccountActivity()
    });

    $('.selectpicker').selectpicker();

    // //Functionality : Event  call page ContentDetail BookBank
    // //Parameters : -
    // //Creator : 03/01/2020 saharat (Golf)
    // //Update : -
    // //Return : view
    // //Return Type : view
    // function JSvBookbankContentDetail(){
    //     JCNxOpenLoading();
    //     $.ajax({
    //             type: "GET",
    //             url: "BookBankEventCallPageContentDetail",
    //             cache: false,
    //             timeout: 0,
    //             success: function(tResult){
    //                 let tDataBookbank  = ('#ohdDataBookbank').val();
    //                 console.log(tDataBookbank);
    //                 $('#odvBBKContentAccountActivity').hide();
    //                 $('#odvBBKContentDetail').show();
    //                 $('#odvBBKContentDetail').html(tResult);
    //                 JCNxCloseLoading();
    //             },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }

    // //Functionality : Event  call page ContentAccountActivity
    // //Parameters : -
    // //Creator : 03/01/2020 saharat (Golf)
    // //Update : -
    // //Return : view
    // //Return Type : view
    // function JSvkBookbankContentAccountActivity(){
    //     JCNxOpenLoading();
    //     $.ajax({
    //             type: "GET",
    //             url: "BookBankEventCallPageContentAccountActivity",
    //             cache: false,
    //             timeout: 0,
    //             success: function(tResult){
    //                 $('#odvBBKContentDetail').hide();
    //                 $('#odvBBKContentAccountActivity').show();
    //                 $('#odvBBKContentAccountActivity').html(tResult);
    //                 JCNxCloseLoading();
    //             },
    //         error: function(jqXHR, textStatus, errorThrown) {
    //             JCNxResponseError(jqXHR, textStatus, errorThrown);
    //         }
    //     });
    // }

</script>