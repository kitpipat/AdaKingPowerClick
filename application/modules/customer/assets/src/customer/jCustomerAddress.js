var tCSTAddressCode = $('#ohdCSTAddressCode').val();
$("ducument").ready(function(){
    // Event Click Title Menu Customer Address
    $('#odvCSTTabAddress #olbCSTAddressInfo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCustomerAddressDataTable(tCSTAddressCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    
    // Event Click Call Page Customer Address Add
    $('#odvCSTTabAddress #obtCSTAddressCallPageAdd').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallPageAddCustomerAddress();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Customer Address
    $('#odvCSTTabAddress #obtCSTAddressCancle').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCustomerAddressDataTable(tCSTAddressCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Customer Address
    $('#odvCSTTabAddress #obtCSTAddressSave').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmCSTAddressForm #obtAddEditCSTAddress').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    JSxCheckPinMenuClose();
    JCNxCustomerAddressSetNavDefault();
    JSxCustomerAddressDataTable(tCSTAddressCode);
});

// Functionality: Set Customer Address Nav Default
// Parameters: -
// Creator: 07/11/2019 Wasin(Yoshi)
// Return: view
// ReturnType: view
function JCNxCustomerAddressSetNavDefault(){
    // Hide Title And Button Default
    $('#olbCSTAddressAdd').hide();
    $('#olbCSTAddressEdit').hide();
    $('#odvCSTAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbCSTAddressInfo').show();
    $('#odvCSTAddressBtnGrpInfo').show();
}

// Functionality: Call Customer Address Data Table
// Parameters: -
// Creator: 07/11/2019 Wasin(Yoshi)
// Return: view
// ReturnType: view
function JSxCustomerAddressDataTable(tCSTAddressCode){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "customerAddressDataTable",
        data: {
            'ptCutomerCode' : tCSTAddressCode
        },
        success: function(tResult) {
            $('#odvCSTTabAddress #odvCSTAddressContent').html(tResult);
            JCNxCustomerAddressSetNavDefault();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Add Customer Address
// Parameters: Event Click Button And Function Parameter
// Creator: 07/11/2019 Wasin(Yoshi)
// Return: view
// ReturnType: view
function JSvCallPageAddCustomerAddress(){
    JSxCheckPinMenuClose();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "customerAddressPageAdd",
        data: {
            'ptCutomerCode' : tCSTAddressCode
        },
        success: function(tResult) {
            $('#odvCSTTabAddress #odvCSTAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbCSTAddressEdit').hide();
            $('#odvCSTAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbCSTAddressAdd').show();
            $('#odvCSTAddressBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Call Page Edit Shop Address
//Parameters: Event Click Button And Function Parameter
//Creator: 10/11/2019 Wasin
//Return: view
//ReturnType: object
function JSvCallPageEditCustomerAddress(poCustomerAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "customerAddressPageEdit",
        data : poCustomerAddressData,
        success: function(tResult){
            $('#odvCSTTabAddress #odvCSTAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbCSTAddressAdd').hide();
            $('#odvCSTAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbCSTAddressEdit').show();
            $('#odvCSTAddressBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Event Add/Edit Customer Address
//Parameters: Event Click Button
//Creator: 08/11/2019 Wasin(Yoshi)
//Return: view
//ReturnType: object
function JSoAddEditCustomerAddress(){
    $('#ofmCSTAddressForm').validate().destroy();
    $('#ofmCSTAddressForm').validate({
        focusInvalid: false,
        onclick: false,
        onfocusout: false,
        onkeyup: false,
        rules: {
            'oetCSTAddressName'         : {"required" :{}},
            'oetCSTAddressAreName'      : {"required" :{}},
            'oetCSTAddressZneChainName' : {"required" :{}}
        },
        messages: {
            oetCSTAddressName           : {
                "required"  : $('#oetCSTAddressName').attr('data-validate-required'),
            },
            oetCSTAddressAreName        : {
                "required"  : $('#oetCSTAddressAreName').attr('data-validate-required'),
            },
            oetCSTAddressZneChainName   : {
                "required"  : $('#oetCSTAddressZneChainName').attr('data-validate-required'),
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
        submitHandler: function (form){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: $('#ofmCSTAddressForm #ohdCSTAddressRoute').val(),
                data: $('#ofmCSTAddressForm').serialize(),
                success: function(tResult){
                    let aDataReturn = JSON.parse(tResult);
                    if(aDataReturn['nStaReturn'] == 1){
                        var tCodeReturn = aDataReturn['tDataCodeReturn'];
                        JSxCustomerAddressDataTable(tCodeReturn);
                    }else{
                        var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                        FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });
}

//Functionality: Event Delete Customer Address
//Parameters: Event Click Button
//Creator: 11/11/2019 Wasin
//Return: Object Status Event Delete
//ReturnType: Object
function JSoCustomerAddressDeleteData(poCustomerAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "customerAddressDeleteEvent",
        data: poCustomerAddressData,
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxCustomerAddressDataTable(tCodeReturn);
            }else{
                var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}
