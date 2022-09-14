var tSalemachineAddrPosCode = $('#ohdSalemachineAddrPosCode').val();

$("ducument").ready(function(){

    // Event Click Title Menu Salemachine Address
    $('#odvPOSAddressData #olbSalemachineAddressInfo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxSalemachineAddressDataTable(tSalemachineAddrPosCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Salemachine Address Add
    $('#odvPOSAddressData #obtSalemachineAddressCallPageAdd').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallPageAddSalemachineAddress();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Salemachine Address
    $('#odvPOSAddressData #obtSalemachineAddressCancle').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxSalemachineAddressDataTable(tSalemachineAddrPosCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Salemachine Address
    $('#odvPOSAddressData #obtSalemachineAddressSave').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmSalemachineAddressForm #obtAddEditSalemachineAddress').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    JCNxSalemachineAddressSetNavDefault();
    JSxSalemachineAddressDataTable(tSalemachineAddrPosCode);

});


// Functionality: Set Salemachine Address Nav Default
// Parameters: -
// Creator: 16/09/2019 Wasin
// Return: view
// ReturnType: view
function JCNxSalemachineAddressSetNavDefault(){
    // Hide Title And Button Default
    $('#olbSalemachineAddressAdd').hide();
    $('#olbSalemachineAddressEdit').hide();
    $('#odvSalemachineAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbSalemachineAddressInfo').show();
    $('#odvSalemachineAddressBtnGrpInfo').show();
}

// Functionality: Call Salemachine Address Data Table
// Parameters: -
// Creator: 16/09/2019 Wasin
// Return: view
// ReturnType: view
function JSxSalemachineAddressDataTable(ptSalemachineCode){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "salemachineAddressDataTable",
        data: {
            'ptSalemachineCode' : ptSalemachineCode
        },
        success: function(tResult) {
            $('#odvPOSAddressData #odvSalemachineAddressContent').html(tResult);
            JCNxSalemachineAddressSetNavDefault();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Add Salemachine Address
// Parameters: Event Click Button And Function Parameter
// Creator: 16/09/2019 Wasin
// Return: view
// ReturnType: view
function JSvCallPageAddSalemachineAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "salemachineAddressPageAdd",
        data:{'ptSalemachineAddrPosCode' : tSalemachineAddrPosCode },
        success: function(tResult) {
            $('#odvPOSAddressData #odvSalemachineAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbSalemachineAddressEdit').hide();
            $('#odvSalemachineAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbSalemachineAddressAdd').show();
            $('#odvSalemachineAddressBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Call Page Edit Salemachine Address
//Parameters: Event Click Button And Function Parameter
//Creator: 16/09/2019 Wasin
//Return: view
//ReturnType: view
function JSvCallPageEditSalemachineAddress(poSalemachineAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "salemachineAddressPageEdit",
        data : poSalemachineAddressData,
        success: function(tResult){
            $('#odvPOSAddressData #odvSalemachineAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbSalemachineAddressAdd').hide();
            $('#odvSalemachineAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbSalemachineAddressEdit').show();
            $('#odvSalemachineAddressBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Event Add/Edit Salemachine Address
//Parameters: Event Click Button
//Creator: 16/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoAddEditSalemachineAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $('#ofmSalemachineAddressForm #ohdSalemachineAddressRoute').val(),
        data: $('#ofmSalemachineAddressForm').serialize(),
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxSalemachineAddressDataTable(tCodeReturn);
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

//Functionality: Event Delete Salemachine Address
//Parameters: Event Click Button
//Creator: 12/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoSalemachineAddressDeleteData(poSalemachineAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "salemachineAddressDeleteEvent",
        data: poSalemachineAddressData,
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxSalemachineAddressDataTable(tCodeReturn);
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