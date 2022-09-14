<script type="text/javascript">
 $(document).ready(function(){
    $('.selectpicker').selectpicker();
    if(JSbCustomerIsCreatePage()){
        //Customer Code
        $("#oetCstCode").attr("disabled", true);
        $('#ocbCustomerAutoGenCode').change(function(){
            if($('#ocbCustomerAutoGenCode').is(':checked')) {
                $('#oetCstCode').val('');
                $("#oetCstCode").attr("disabled", true);
                $('#odvCstCodeForm').removeClass('has-error');
                $('#odvCstCodeForm em').remove();
            }else{
                $("#oetCstCode").attr("disabled", false);
            }
        });
        JSxCustomerVisibleComponent('#ocbCustomerAutoGenCode', true);
    }
    
    if(JSbCustomerIsUpdatePage()){
        // Customer Code
        $("#oetCstCode").attr("readonly", true);
        $('#odvCstAutoGenCode input').attr('disabled', true);
        JSxCustomerVisibleComponent('#odvCstAutoGenCode', false);    

        }
    });

    // $('#oetCstCode').blur(function(){
    //     JSxCheckCustomerCodeDupInDB();
    // });


    // //Functionality : Event Check Customer
    // //Parameters : Event Blur Input Customer Code
    // //Creator : 30/08/2019 saharat (Golf)
    // //Update :-
    // //Return : -
    // //Return Type : -
    // function JSxCheckCustomerCodeDupInDB(){
    //     if(!$('#ocbCustomerAutoGenCode').is(':checked')){
    //         $.ajax({
    //             type: "POST",
    //             url: "CheckInputGenCode",
    //             data: { 
    //                 tTableName: "TCNMCst",
    //                 tFieldName: "FTCstCode",
    //                 tCode: $("#oetCstCode").val()
    //             },
    //             cache: false,
    //             timeout: 0,
    //             success: function(tResult){
    //             var aResult = JSON.parse(tResult);
    //             $("#ohdCheckDuplicateCstCode").val(aResult["rtCode"]);  
    //             // Set Validate Dublicate Code
    //             $.validator.addMethod('dublicateCode', function(value, element) {
    //                 if($("#ohdCheckDuplicateCstCode").val() == 1){
    //                     return false;
    //                 }else{
    //                     return true;
    //                 }
    //             },);
    //             // From Summit Validate
    //             $('#ofmAddCustomerInfo1').validate({
    //                 rules: {
    //                     oetCstCode : {
    //                         "required" :{
    //                             // ตรวจสอบเงื่อนไข validate
    //                             depends: function(oElement) {
    //                             if($('#ocbCustomerAutoGenCode').is(':checked')){
    //                                 return false;
    //                             }else{
    //                                 return true;
    //                             }
    //                             }
    //                         },
    //                         "dublicateCode": {}
    //                     },
    //                     oetCstName: { "required": {} },
    //                 },
    //                 messages: {
    //                     oetCstCode : {
    //                         "required"      : $('#oetCstCode').attr('data-validate-required'),
    //                         "dublicateCode" : $('#oetCstCode').attr('data-validate-dublicateCode')
    //                     },
    //                     oetCstName : {
    //                         "required"      : $('#oetCstName').attr('data-validate-required'),
    //                         "dublicateCode" : $('#oetCstName').attr('data-validate-dublicateCode')
    //                     },
    //                 },
    //                 errorElement: "em",
    //                 errorPlacement: function (error, element ) {
    //                     error.addClass( "help-block" );
    //                     if ( element.prop( "type" ) === "checkbox" ) {
    //                         error.appendTo( element.parent( "label" ) );
    //                     } else {
    //                         var tCheck = $(element.closest('.form-group')).find('.help-block').length;
    //                         if(tCheck == 0){
    //                             error.appendTo(element.closest('.form-group')).trigger('change');
    //                         }
    //                     }
    //                 },
    //                 highlight: function ( element, errorClass, validClass ) {
    //                     $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
    //                 },
    //                 unhighlight: function (element, errorClass, validClass) {
    //                     $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
    //                 },
    //                 submitHandler: function(form){}
    //             });
    //                 // Submit From
    //                 $('#ofmAddCustomerInfo1').submit();
    //             },
    //             error: function(jqXHR, textStatus, errorThrown) {
    //                 JCNxResponseError(jqXHR, textStatus, errorThrown);
    //             }
    //         });
    //     }    
    // }
</script>
