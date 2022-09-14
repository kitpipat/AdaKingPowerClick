<script type="text/javascript">
    // $(document).ready(function () {
    

    $(document).ready(function () {
        JSvRackList(1);
        if(JSbReasonIsCreatePage()){
            // Reason Code
            $("#oetRacCode").attr("disabled", true);
            $('#ocbRacAutoGenCode').change(function(){
                if($('#ocbRacAutoGenCode').is(':checked')) {
                    $('#oetRacCode').val('');
                    $("#oetRacCode").attr("disabled", true);
                    $('#odvRacCodeForm').removeClass('has-error');
                    $('#odvRacCodeForm em').remove();
                }else{
                    $("#oetRacCode").attr("disabled", false);
                }
            });
            JSxReasonVisibleComponent('#odvRacAutoGenCode', true);
        }

        if(JSbReasonIsUpdatePage()){
            // Sale Person Code
            $("#oetRacCode").attr("readonly", true);
            $('#odvRacAutoGenCode input').attr('disabled', true);
            JSxReasonVisibleComponent('#odvRacAutoGenCode', false);    
        }

        $('#oetRacCode').blur(function(){
            JSxCheckReasonCodeDupInDB();
        });
   
    });

    if(JSbReasonIsCreatePage()){
            // Reason Code
            $("#oetRacCode").attr("disabled", true);
            $('#ocbRacAutoGenCode').change(function(){
                if($('#ocbRacAutoGenCode').is(':checked')) {
                    $('#oetRacCode').val('');
                    $("#oetRacCode").attr("disabled", true);
                    $('#odvRacCodeForm').removeClass('has-error');
                    $('#odvRacCodeForm em').remove();
                }else{
                    $("#oetRacCode").attr("disabled", false);
                }
            });
            JSxReasonVisibleComponent('#odvRacAutoGenCode', true);
        }

        if(JSbReasonIsUpdatePage()){
            // Sale Person Code
            $("#oetRacCode").attr("readonly", true);
            $('#odvRacAutoGenCode input').attr('disabled', true);
            JSxReasonVisibleComponent('#odvRacAutoGenCode', false);    
        }

        $('#oetRacCode').blur(function(){
            JSxCheckReasonCodeDupInDB();
        });


    //Functionality: Event Check Sale Person Duplicate
    //Parameters: Event Blur Input Sale Person Code
    //Creator: 25/03/2019 wasin (Yoshi)
    //Return: -
    //ReturnType: -
    function JSxCheckReasonCodeDupInDB(){
        if(!$('#ocbRacAutoGenCode').is(':checked')){
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: { 
                    tTableName: "TRTMShopRack",
                    tFieldName: "FTRakCode",
                    tCode: $("#oetRacCode").val()
                },
                async : false,
                cache: false,
                timeout: 0,
                success: function(tResult){
                    var aResult = JSON.parse(tResult);
                    $("#ohdCheckDuplicateRacCode").val(aResult["rtCode"]);
                    JSxReasonSetValidEventBlur();
                    $('#ofmAddRac').submit();
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
    function JSxReasonSetValidEventBlur(){
        $('#ofmAddRac').validate().destroy();

        // Set Validate Dublicate Code
        $.validator.addMethod('dublicateCode', function(value, element) {
            if($("#ohdCheckDuplicateRacCode").val() == 1){
                return false;
            }else{
                return true;
            }
        },'');

        // From Summit Validate
        $('#ofmAddRac').validate({
            rules: {
                oetRacCode : {
                    "required" :{
                        // ตรวจสอบเงื่อนไข validate
                        depends: function(oElement) {
                            if($('#ocbRacAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    },
                    "dublicateCode" :{}
                },
                oetRacName:     {"required" :{}}
            },
            messages: {
                oetRacCode : {
                    "required"      : $('#oetRacCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetRacCode').attr('data-validate-dublicateCode')
                },
                oetRacName : {
                    "required"      : $('#oetRacName').attr('data-validate-required'),
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
            submitHandler: function(form){

            }
        });
    }

//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 09/05/2018 wasin
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditRack(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddRac').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if (ptRoute == "rackEventAdd") {
                if ($("#ohdCheckDuplicateRacCode").val() == 1) {
                    return false;
                } else {
                    return true;
                }
            } else {
                return true;
            }
        }, '');


        $('#ofmAddRac').validate({
            rules: {
                oetRacCode: {
                    "required": {
                        depends: function(oElement) {
                            if (ptRoute == "reasonEventAdd") {
                                if ($('#ocbRacAutoGenCode').is(':checked')) {
                                    return false;
                                } else {
                                    return true;
                                }
                            } else {
                                return true;
                            }
                        }
                    },
                    "dublicateCode": {}
                },
                oetRacName: { "required": {} }
            },
            messages: {
                oetRacCode: {
                    "required": $('#oetRacCode').attr('data-validate-required'),
                    "dublicateCode": $('#oetRacCode').attr('data-validate-dublicateCode')
                },
                oetRacName: {
                    "required": $('#oetRacName').attr('data-validate-required'),
                }
            },
            errorElement: "em",
            errorPlacement: function(error, element) {
                error.addClass("help-block");
                if (element.prop("type") === "checkbox") {
                    error.appendTo(element.parent("label"));
                } else {
                    var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                    if (tCheck == 0) {
                        error.appendTo(element.closest('.form-group')).trigger('change');
                    }
                }
            },
            highlight: function(element, errorClass, validClass) {
                $(element).closest('.form-group').addClass("has-error").removeClass("has-success");
            },
            unhighlight: function(element, errorClass, validClass) {
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmAddRac').serialize(),
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        var aReturn = JSON.parse(tResult);
                        if (aReturn['nStaEvent'] == 1) {
                            JSvRackList(1);
                        }else{
                            JSxCheckReasonCodeDupInDB();
                            $('#ofmAddRac').submit();
                        }
                    JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Call Reason Page Edit  
//Parameters : -
//Creator: 09/05/2018 wasin(yoshi)
//Update: 15/10/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPageRackEdit(ptRckCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageReasonEdit', ptRckCode);
        $.ajax({
            type: "POST",
            url: "SHPSmartLockerEventPageEdit",
            data: { tRckCode: ptRckCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#odvContentRackDataTable').html(tResult);
                    $('#odvControlEventButtonTitle').addClass('hidden');
                    $('#oetRacCode').addClass('xCNDisable');
                    $('.xWPageAdd').addClass('hidden');
                    $('.xWPageEdit').removeClass('hidden');
                    $('.xCNDisable').attr('readonly', true);
                    $('.xCNiConGen').attr('disabled', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

    //Call list
    function JSvRackList(nPage){
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "SHPSmartLockerrackList",
            data    : {
                nPageCurrent    : nPage,
                tSearchAll      : ''
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentRackDataTable').html(tView);
                $('#odvControlEventButtonTitle').removeClass('hidden');
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
  //Functionality: (event) Delete
//Parameters: Button Event [tIDCode รหัสกลุ่มช่อง]
//Creator: 29/08/2019 Saharat(Golf)
//Update: -
//Return: Event Delete Reason List
//Return Type: -
function JSnRackDel(tCurrentPage, ptName, tIDCode) {
    var nStaSession = JCNxFuncChkSessionExpired();
    var tYesOnNo = $('#oetTextComfirmDeleteYesOrNot').val();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        if (aDataSplitlength == '1') {
            $('#odvModalDelRack').modal('show');
            $('#odvModalDelRack #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) ' + tYesOnNo);
            $('#osmConfirm').on('click', function(evt) {
                if (localStorage.StaDeleteArray != '1') {
                    $.ajax({
                        type: "POST",
                        url: "rackEventDelete",
                        data: { 'tIDCode': tIDCode },
                        cache: false,
                        success: function(tResult) {
                            var aReturn = JSON.parse(tResult);
                            if (aReturn['nStaEvent'] == 1) {
                                $('#odvModalDelRack').modal('hide');
                                $('#odvModalDelRack #ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                                $('#ohdConfirmIDDelete').val('');
                                localStorage.removeItem('LocalItemData');
                                $('.modal-backdrop').remove();
                                setTimeout(function() {
                                    if (aReturn["nNumRowRck"] != 0) {
                                        if (aReturn["nNumRowRck"] > 10) {
                                            nNumPage = Math.ceil(aReturn["nNumRowRck"] / 10);
                                            if (tCurrentPage <= nNumPage) {
                                                JSvRackList(tCurrentPage);
                                            } else {
                                                JSvRackList(nNumPage);
                                            }
                                        } else {
                                            JSvRackList(1);
                                        }
                                    } else {
                                        JSvRackList(1);
                                    }
                                }, 500);
                            } else {
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                                //alert(aReturn['tStaMessg']);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

    //Functionality : (event) Delete All
//Parameters : Button Event 
//Creator : 29/08/2019 Saharat(Golf)
//Update: -
//Return : Event Delete All Select List
//Return Type : -
function JSnRackDelChoose(tCurrentPage) {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
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
            url: "rackEventDelete",
            data: { 'tIDCode': aNewIdDelete },
            success: function(tResult) {
                var aReturn = JSON.parse(tResult);
                $('#odvModalDelRack').modal('hide');
                $('#ohdConfirmIDDelete').val('');
                localStorage.removeItem('LocalItemData');
                $('.modal-backdrop').remove();
                if (aReturn['nStaEvent'] == '1') {
                    setTimeout(function() {
                        if (aReturn["nNumRowRck"] != 0) {
                            if (aReturn["nNumRowRck"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRowRck"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvRackList(tCurrentPage);
                                } else {
                                    JSvRackList(nNumPage);
                                }
                            } else {
                                JSvRackList(1);
                            }
                        } else {
                            JSvRackList(1);
                        }
                    }, 1000);
                } else {
                    alert(aReturn['tStaMessg']); 
                }
                JCNxCloseLoading();
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
    function JSxShowButtonChoose() {
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
    function JSxPaseCodeDelInModal() {
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
    //Creator : 15/10/2019 saharat(Golf)
    //Return : View
    //Return Type : View
    function SHPSmartLockerrackPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "GET",
            url: "SHPSmartLockerrackPageAdd",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $('#odvContentRackDataTable').html(tResult);
                $('.xWPageAdd').removeClass('hidden');
                $('.xWPageEdit').addClass('hidden');
                $('#odvControlEventButtonTitle').addClass('hidden');
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
    function JSbReasonIsCreatePage(){
        try{
            const tRacCode = $('#oetRacCode').data('is-created');    
            var bStatus = false;
            if(tRacCode == ""){ // No have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbRackIsCreatePage Error: ', err);
        }
    }

    // Functionality: Function Check Is Update Page
    // Parameters: Event Documet Redy
    // Creator: 04/07/2019 saharat(Golf)
    // Return: object Status Delete
    // ReturnType: boolean
    function JSbReasonIsUpdatePage(){
        try{
            const tRacCode = $('#oetRacCode').data('is-created');
            var bStatus = false;
            if(!tRacCode == ""){ // Have data
                bStatus = true;
            }
            return bStatus;
        }catch(err){
            console.log('JSbReasonIsUpdatePage Error: ', err);
        }
    }

    // Functionality : Show or Hide Component
    // Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
    // Creator: 04/07/2019 saharat(Golf)
    // Return : -
    // Return Type : -
    function JSxReasonVisibleComponent(ptComponent, pbVisible, ptEffect){
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

    //Choose Checkbox
    function JSxReasonVisibledDelAllBtn(poElement, poEvent) { // Action start after change check box value.
    try {
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if (nCheckedCount > 1) {
            $('#oliBtnDeleteAll').removeClass("disabled");
        } else {
            $('#oliBtnDeleteAll').addClass("disabled");
        }
        if (nNumOfArr > 1) {
            $('.xCNIconDel').addClass('xCNDisabled');
        } else {
            $('.xCNIconDel').removeClass('xCNDisabled');
        }
    } catch (err) {
        console.log('JSxReasonVisibledDelAllBtn Error: ', err);
    }
}

//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 09/05/2018 wasin
//Update: 15/10/2019 Saharat(Golf)
//Return: View
//Return Type: View
function JSvClickPage(ptPage) {
    var nPageCurrent = '';
    var nPageNew;
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageReasonGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageReasonGrp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvRackList(nPageCurrent);
}

</script>