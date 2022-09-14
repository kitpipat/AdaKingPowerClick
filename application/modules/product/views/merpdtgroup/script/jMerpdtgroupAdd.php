<script type="text/javascript">
   $(document).ready(function () {
    if(JSbMerchantProductIsCreatePage()){
        $("#oetMgpCode").attr("disabled", true);
        $('#ocbMgpAutoGenCode').change(function(){
            if($('#ocbMgpAutoGenCode').is(':checked')) {
                $('#oetMgpCode').val('');
                $("#oetMgpCode").attr("disabled", true);
                $('#odvMerchantCodeForm').removeClass('has-error');
                $('#odvMerchantCodeForm em').remove();
            }else{
                $("#oetMgpCode").attr("disabled", false);
            }
        });
        JSxMerchantProductVisibleComponent('#odvMgpAutoGenCode', true);
    }

    if(JSbMerchantProductIsUpdatePage()){
        // Sale Person Code
        $("#oetMgpCode").attr("readonly", true);
        $('#odvMgpAutoGenCode input').attr('disabled', true);
        JSxMerchantProductVisibleComponent('#odvMgpAutoGenCode', false);    
    }

    $('#oetMgpCode').blur(function(){
        JSxCheckMerchantCodeDupInDB();
    });
    });
    //Functionality : Event Check MerchantProduct Group
    //Parameters : Event Blur Input Voucher Code
    //Creator : 02/05/2019 saharat (golf)
    //Return : -
    //Return Type : -
    function JSxCheckMerchantCodeDupInDB(){
        if(!$('#ocbMgpAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TCNMMerPdtGrp",
                    tFieldName: "FTMgpCode",
                    tCode: $("#oetMgpCode").val()
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateMgpCode").val(aResult["rtCode"]);  
                // Set Validate Dublicate Code
                $.validator.addMethod('dublicateCode', function(value, element) {
                    if($("#ohdCheckDuplicateMgpCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                },'');

                // From Summit Validate
                $('#ofmAddPdtGroup').validate({
                    rules: {
                        oetMgpCode : {
                            "required" :{
                                // ตรวจสอบเงื่อนไข validate
                                depends: function(oElement) {
                                if($('#ocbMgpAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                                }
                            },
                            "dublicateCode" :{}
                        },
                        oetMgpName  : {"required" :{}},
                        },
                        messages: {
                            oetMgpCode : {
                                "required"      : $('#oetMgpCode').attr('data-validate-required'),
                                "dublicateCode" : $('#oetMgpCode').attr('data-validate-dublicateCode')
                            },
                            oetMgpName : {
                                "required"      : $('#oetMgpName').attr('data-validate-required'),
                                "dublicateCode" : $('#oetMgpName').attr('data-validate-dublicateCode')
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
                $('#ofmAddPdtGroup').submit();

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }    
    }

    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddPdtGroup
    //Creator : 10/06/2019 saharat(Golf)
    //Return : View
    //Return Type : View
    function  JSnAddEditMerchantProduct(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddPdtGroup').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "MerchantProductEventAdd"){
                if($("#ohdCheckDuplicateMgpCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddPdtGroup').validate({
            rules: {
                oetMgpCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "MerchantProductEventAdd"){
                                if($('#ocbMgpAutoGenCode').is(':checked')){
                                    return false;
                                }else{
                                    return true;
                                }
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },   
                oetMgpName  : {"required" :{}},

            },
            messages: {
                oetMgpCode : {
                    "required"      : $('#oetMgpCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetMgpCode').attr('data-validate-dublicateCode')
                },
                oetMgpName : {
                    "required"      : $('#oetMgpName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetMgpName').attr('data-validate-dublicateCode')
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
            highlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            },
            unhighlight: function(element, errorClass, validClass) {
                $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
            },
        submitHandler: function(form) {
            $.ajax({
                type: "POST",
                url: ptRoute,
                data: $('#ofmAddPdtGroup').serialize(),
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var aReturn = JSON.parse(tResult);
                    if (aReturn['nStaEvent'] == 1) {
                        // JSvCallPageMerProductGroupEdit(aReturn['tCodeReturn']);
                        JSvMgpGroupDataTable(1);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
    }

    // Functionality: Function Check Is Create Page
    // Parameters: Event Documet Redy
    // Creator: 07/06/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbMerchantProductIsCreatePage(){
        try{
            const tMgpCode = $('#oetMgpCode').data('is-created');    
            var bStatus = false;
            if(tMgpCode == ""){ // No have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbMerchantProductIsCreatePage Error: ', err);
        }
    }

    // Functionality: Function Check Is Update Page
    // Parameters: Event Documet Redy
    // Creator: 07/06/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbMerchantProductIsUpdatePage(){
        try{
            const tMgpCode = $('#oetMgpCode').data('is-created');
            var bStatus = false;
            if(!tMgpCode == ""){ // Have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbMerchantProductIsUpdatePage Error: ', err);
        }
    }

    // Functionality : Show or Hide Component
    // Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
    // Creator: 07/06/2019 saharat(Golf)
    // Return : -
    // Return Type : -
    function JSxMerchantProductVisibleComponent(ptComponent, pbVisible, ptEffect){
        try{
            if(pbVisible == false){
                $(ptComponent).addClass('hidden');
            }
            if(pbVisible == true){

                $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                    $(this).removeClass('hidden fadeIn animated');
                });
            }
        }catch(err){
            console.log('JSxMerchantProductVisibleComponent Error: ', err);
        }
    }

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvPdtGroupClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePdtGroup .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePdtGroup .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvMgpGroupDataTable(nPageCurrent);
}



</script>