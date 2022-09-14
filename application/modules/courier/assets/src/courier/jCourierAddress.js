var tCourierAddrCryCode = $('#ohdCourierAddrCryCode').val();
var tCourierAddrCryName = $('#ohdCourierAddrCryName').val();

$("ducument").ready(function(){
    // Event Click Title Menu Courier Address
    $('#odvCRYAddressData #olbCourierAddressInfo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCourierAddressDataTable(tCourierAddrCryCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Courier Address Add
    $('#odvCRYAddressData #obtCourierAddressCallPageAdd').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallPageAddCourierAddress();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Courier Address
    $('#odvCRYAddressData #obtCourierAddressCancle').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxCourierAddressDataTable(tCourierAddrCryCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Courier Address
    $('#odvCRYAddressData #obtCourierAddressSave').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmCourierAddressForm #obtAddEditCourierAddress').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    JCNxCourierAddressSetNavDefault();
    JSxCourierAddressDataTable(tCourierAddrCryCode);
});

// Functionality: Set Courier Address Nav Default
// Parameters: -
// Creator: 12/09/2019 Wasin
// Return: view
// ReturnType: view
function JCNxCourierAddressSetNavDefault(){
    // Hide Title And Button Default
    $('#olbCourierAddressAdd').hide();
    $('#olbCourierAddressEdit').hide();
    $('#odvCourierAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbCourierAddressInfo').show();
    $('#odvCourierAddressBtnGrpInfo').show();
}


// Functionality: Call Courier Address Data Table
// Parameters: -
// Creator: 12/09/2019 Wasin
// Return: view
// ReturnType: view
function JSxCourierAddressDataTable(ptCourierCode){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "courierAddressDataTable",
        data: {
            'ptCourierCode' : ptCourierCode
        },
        success: function(tResult) {
            $('#odvCRYAddressData #odvCourierAddressContent').html(tResult);
            JCNxCourierAddressSetNavDefault();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Add Courier Address
// Parameters: Event Click Button And Function Parameter
// Creator: 12/09/2019 Wasin
// Return: view
// ReturnType: view
function JSvCallPageAddCourierAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "courierAddressPageAdd",
        data:{'ptCourierAddrCryCode' : tCourierAddrCryCode },
        success: function(tResult) {
            $('#odvCRYAddressData #odvCourierAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbCourierAddressEdit').hide();
            $('#odvCourierAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbCourierAddressAdd').show();
            $('#odvCourierAddressBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Call Page Edit Courier Address
//Parameters: Event Click Button And Function Parameter
//Creator: 12/09/2019 Wasin
//Return: view
//ReturnType: view
function JSvCallPageEditCourierAddress(poCourierAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "courierAddressPageEdit",
        data : poCourierAddressData,
        success: function(tResult){
            $('#odvCRYAddressData #odvCourierAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbCourierAddressAdd').hide();
            $('#odvCourierAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbCourierAddressEdit').show();
            $('#odvCourierAddressBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Event Add/Edit Courier Address
//Parameters: Event Click Button
//Creator: 12/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoAddEditCourierAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $('#ofmCourierAddressForm #ohdCourierAddressRoute').val(),
        data: $('#ofmCourierAddressForm').serialize(),
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxCourierAddressDataTable(tCodeReturn);
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

//Functionality: Event Delete Courier Address
//Parameters: Event Click Button
//Creator: 12/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoCourierAddressDeleteData(poCourierAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "courierAddressDeleteEvent",
        data: poCourierAddressData,
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxCourierAddressDataTable(tCodeReturn);
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