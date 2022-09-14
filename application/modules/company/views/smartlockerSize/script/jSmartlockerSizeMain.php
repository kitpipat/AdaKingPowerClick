<script type="text/javascript">
    $(document).ready(function () {
    JSvSMSList(1);

    if(JSbShopSizeIsCreatePage()){
        $("#oetPzeCode").attr("disabled", true);
    $('#ocbShopSizeAutoGenCode').change(function(){
   if($('#ocbShopSizeAutoGenCode').is(':checked')) {
       $('#oetPzeCode').val('');
       $("#oetPzeCode").attr("disabled", true);
       $('#odvShopSizeCodeForm').removeClass('has-error');
       $('#odvShopSizeCodeForm em').remove();
   }else{
       $("#oetPzeCode").attr("disabled", false);
    }
    });
        JSxShopSizeVisibleComponent('#odvShopSizeAutoGenCode', true);
    }

    if(JSbShopSizeIsUpdatePage()){
    // ShopSize Code
    $("#oetPzeCode").attr("readonly", true);
    $('#odvShopSizeAutoGenCode input').attr('disabled', true);
    JSxShopSizeVisibleComponent('#odvShopSizeAutoGenCode', false);    

    }
    });
    $('#oetPzeCode').blur(function(){
    JSxChecShopSizeCodeDupInDB();
    });

    //Functionality : Event Check ShopSize
    //Parameters : Event Blur Input ShopSize Code
    //Creator : 04/07/2019 saharat(Golf)
    //Return : -
    //Return Type : -
    function JSxChecShopSizeCodeDupInDB(){
    if(!$('#ocbShopSizeAutoGenCode').is(':checked')){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: { 
            tTableName: "TRTMShopSize",
            tFieldName: "FTPzeCode",
            tCode: $("#oetPzeCode").val()
        },
        cache: false,
        timeout: 0,
        success: function(tResult){
            var aResult = JSON.parse(tResult);
            $("#ohdCheckDuplicateSMSCode").val(aResult["rtCode"]);  
        // Set Validate ShopSize Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateSMSCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddSms').validate({
            rules: {
                oetPzeCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                        if($('#ocbShopSizeAutoGenCode').is(':checked')){
                            return false;
                        }else{
                            return true;
                        }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetSizName:     {"required" :{}},
                oetPzeDim:     {"required" :{}},
                oetPzeHigh:     {"required" :{}},
                oetPzeWide:     {"required" :{}},
            },
            messages: {
                oetPzeCode : {
                    "required"      : $('#oetPzeCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetPzeCode').attr('data-validate-dublicateCode')
                },
                oetSizName : {
                    "required"      : $('#oetSizName').attr('data-validate-required'),
                    "dublicateCode" : $('#oetPzeCode').attr('data-validate-dublicateCode')
                },
                oetPzeDim : {
                        "required"      : $('#oetPzeDim').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeDim').attr('data-validate-dublicateCode')
                    },
                oetPzeHigh : {
                        "required"      : $('#oetPzeHigh').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeHigh').attr('data-validate-dublicateCode')
                    },
                oetPzeWide : {
                        "required"      : $('#oetPzeWide').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeWide').attr('data-validate-dublicateCode')
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
        $('#ofmAddSms').submit();
        },
        error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        }    
    }

    //Functionality : Add Data Agency Add/Edit  
    //Parameters : from ofmAddSms
    //Creator : 04/07/2019 saharat(Golf)
    //Return : View
    //Return Type : View
    function JSvSMSAddEdit(ptRoute) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmAddSms').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value, element) {
                if(ptRoute == "SHPSmartLockerSizeEventAdd"){
                    if($("#ohdCheckDuplicateSMSCode").val() == 1){
                        return false;
                    }else{
                        return true;
                    }
                }else{
                    return true;
                }
            },'');
            $('#ofmAddSms').validate({
                rules: {
                    oetPzeCode:     {
                        "required": {
                            depends: function(oElement) {
                                if(ptRoute == "SHPSmartLockerSizeEventAdd"){
                                    if($('#ocbShopSizeAutoGenCode').is(':checked')){
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
                    oetSizName  : {"required" :{}},
                    oetPzeDim   : {"required" :{}},
                    oetPzeHigh  : {"required" :{}},
                    oetPzeWide  : {"required" :{}},
                },
                messages: {
                    oetPzeCode : {
                        "required"      : $('#oetPzeCode').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeCode').attr('data-validate-dublicateCode')
                    },
                    oetSizName : {
                        "required"      : $('#oetSizName').attr('data-validate-required'),
                        "dublicateCode" : $('#oetSizName').attr('data-validate-dublicateCode')
                    },
                    oetPzeDim : {
                        "required"      : $('#oetPzeDim').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeDim').attr('data-validate-dublicateCode')
                    },
                    oetPzeHigh : {
                        "required"      : $('#oetPzeHigh').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeHigh').attr('data-validate-dublicateCode')
                    },
                    oetPzeWide : {
                        "required"      : $('#oetPzeWide').attr('data-validate-required'),
                        "dublicateCode" : $('#oetPzeWide').attr('data-validate-dublicateCode')
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
                    data: $('#ofmAddSms').serialize(),
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                            var aReturn = JSON.parse(tResult);
                            // JSvCallPageSmartlockerSizeEdit(aReturn.tCodeReturn);
                            JSxGetSHPContentSmartLockerSize();

                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                },
            });
        }
    }

    //Call list
    function JSvSMSList(nPage){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "SHPSmartLockerSizeDataTable",
            data    : {
                nPageCurrent    : nPage,
                tSearchAll      : ''
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentSMSSizeDataTable').html(tView);
                JCNxCloseLoading();
            },

            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เปลี่ยนหน้า pagenation
    function JSvSMLClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWSMLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
            break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWSMLPaging .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
            break;
            default:
            nPageCurrent = ptPage;
        }
        JSvSMSList(nPageCurrent);
    }

    //Event ลบข้อมูลรายการเดียว
    function JSxSMSDelete(ptPzeCode, ptSizName, tYesOnNo){
        $('#odvModalDeleteSingle').modal('show');
        $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptPzeCode + ' ( ' + ptSizName + ' ) '+ tYesOnNo );
        $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
            $.ajax({
                type: "POST",
                url: "SHPSmartLockerSizeEventDelete",
                data: { 
                    tPzeCode   : ptPzeCode
                },
                cache: false,
                success: function(tResult) {
                    aReturn = tResult.trim();
                    var aReturn = $.parseJSON(aReturn);
                    $('#odvModalDeleteSingle').modal('hide');
                    // setTimeout(function(){
                    //     JSvSMSList(1);
                    // }, 500);
                    setTimeout(function() {
                        if (aReturn["nNumRowSMSPUN"] != 0) {
                            if (aReturn["nNumRowSMSPUN"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowSMSPUN"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvSMSList(tCurrentPage);
                                } else {
                                    JSvSMSList(nNumPage);
                                }
                            } else {
                                JSvSMSList(1);
                            }
                        } else {
                            JSvSMSList(1);
                        }
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }

    //Functionality : (event) Delete All
    //Parameters :
    //Creator : 11/06/2019 saharat
    //Return : 
    //Return Type :
    function JSxSMSDeleteMutirecord() {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "SHPSmartLockerSizeEventDelete",
                data: { 'tPzeCode': aNewIdDelete },
                success: function(tReturn) {
                    aReturn = tReturn.trim();
                    var aReturn = $.parseJSON(aReturn);
                    $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#odvModalDeleteMutirecord #ohdConfirmIDDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    $('#odvModalDeleteMutirecord').modal('hide');
                    setTimeout(function() {
                        if (aReturn["nNumRowSMSPUN"] != 0) {
                            if (aReturn["nNumRowSMSPUN"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowSMSPUN"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvSMSList(tCurrentPage);
                                } else {
                                    JSvSMSList(nNumPage);
                                }
                            } else {
                                JSvSMSList(1);
                            }
                        } else {
                            JSvSMSList(1);
                        }
                    }, 500);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }

    //Functionality: Function Chack And Show Button Delete All
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 Saharat(Golf)
    //Return: - 
    //Return Type: -
    function JSxSMSShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
            } else {
                $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
            }
        }
    }

    //Functionality: Insert Text In Modal Delete
    //Parameters: LocalStorage Data
    //Creator: 05/07/2019 Saharat(Golf)
    //Return: -
    //Return Type: -
    function JSxSMSPaseCodeDelInModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
            var tTextCode = '';
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += ' , ';
            }
            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
            $('#ohdConfirmIDDelete').val(tTextCode);
        }
    }

    //Functionality: Function Chack Value LocalStorage
    //Parameters: Event Select List Branch
    //Creator: 05/07/2019 Saharat(Golf)
    //Return: Duplicate/none
    //Return Type: string
    function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return 'Dupilcate';
            }
        }
        return 'None';
    }

    //Functionality : Call Credit Page Add  
    //Parameters : -
    //Creator : 10/06/2019 saharat(Golf)
    //Return : View
    //Return Type : View
    function JSvCallPageSmartlockerSizeAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "GET",
            url: "SHPSmartLockerSizePageAdd",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $('#odvSHPContentSmartLockerSize').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Functionality : Call Credit Page Edit  
    //Parameters : -
    //Creator : 10/06/2019 saharat(Golf)
    //Return : View
    //Return Type : View
    function JSvCallPageSmartlockerSizeEdit(ptPzeCode) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "SHPSmartLockerSizePageEdit",
            data:{
                tPzeCode : ptPzeCode
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $('#odvSHPContentSmartLockerSize').html(tResult);
                $('.xWPageAdd').addClass('hidden');
                $('.xWPageEdit').removeClass('hidden');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Functionality: Function Check Is Create Page
    // Parameters: Event Documet Redy
    // Creator: 04/07/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbShopSizeIsCreatePage(){
        try{
            const tPzeCode = $('#oetPzeCode').data('is-created');    
            var bStatus = false;
            if(tPzeCode == ""){ // No have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbShopSizeIsCreatePage Error: ', err);
        }
    }

    // Functionality: Function Check Is Update Page
    // Parameters: Event Documet Redy
    // Creator: 04/07/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbShopSizeIsUpdatePage(){
        try{
            const tPzeCode = $('#oetPzeCode').data('is-created');
            var bStatus = false;
            if(!tPzeCode == ""){ // Have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbShopSizeIsUpdatePage Error: ', err);
        }
    }

    // Functionality : Show or Hide Component
    // Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
    // Creator: 04/07/2019 saharat(Golf)
    // Return : -
    // Return Type : -
    function JSxShopSizeVisibleComponent(ptComponent, pbVisible, ptEffect){
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
            console.log('JSxShopSizeVisibleComponent Error: ', err);
        }
    }
</script>