var tShpAddrBchCode = $('#ohdShpAddrBchCode').val();
var tShpAddrShpCode = $('#ohdShpAddrShpCode').val();
var tShpAddrShpName = $('#ohdShpAddrShpName').val();

$("ducument").ready(function(){
    // Event Click Title Menu Shop Address
    $('#odvSHPAddressData #olbShopAddressInfo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxShopAddressDataTable(tShpAddrShpCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Shop Address Add
    $('#odvSHPAddressData #obtShopAddressCallPageAdd').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallPageAddShopAddress();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Shop Address
    $('#odvSHPAddressData #obtShopAddressCancle').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxShopAddressDataTable(tShpAddrShpCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Shop Address
    $('#odvSHPAddressData #obtShopAddressSave').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmShopAddressForm #obtAddEditShopAddress').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    JCNxShopAddressSetNavDefault();
    JSxShopAddressDataTable(tShpAddrShpCode);
});

// Functionality: Set Shop Address Nav Default
// Parameters: -
// Creator: 10/09/2019 Wasin
// LastUpdate : -
// Return: view
// ReturnType: view
function JCNxShopAddressSetNavDefault(){
    // Hide Title And Button Default
    $('#olbShopAddressAdd').hide();
    $('#olbShopAddressEdit').hide();
    $('#odvShopAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbShopAddressInfo').show();
    $('#odvShopAddressBtnGrpInfo').show();
}

// Functionality: Call Shop Address Data Table
// Parameters: -
// Creator: 10/09/2019 Wasin
// LastUpdate : -
// Return: view
// ReturnType: view
function JSxShopAddressDataTable(ptShopCode){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "shopAddressDataTable",
        data: {
            'ptShopCode' : ptShopCode
        },
        success: function(tResult) {
            $('#odvSHPAddressData #odvShopAddressContent').html(tResult);
            JCNxShopAddressSetNavDefault();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Add Shop Address
// Parameters: Event Click Button And Function Parameter
// Creator: 10/09/2019 Wasin
// LastUpdate: -
// Return: view
// ReturnType: view
function JSvCallPageAddShopAddress() {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "shopAddressPageAdd",
        data:{'ptShpAddrShpCode' : tShpAddrShpCode },
        success: function(tResult) {
            $('#odvSHPAddressData #odvShopAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbShopAddressEdit').hide();
            $('#odvShopAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbShopAddressAdd').show();
            $('#odvShopAddressBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Call Page Edit Shop Address
//Parameters: Event Click Button And Function Parameter
//Creator: 10/09/2019 Wasin
//Return: view
//ReturnType: object
function JSvCallPageEditShopAddress(poShopAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "shopAddressPageEdit",
        data : poShopAddressData,
        success: function(tResult){
            $('#odvSHPAddressData #odvShopAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbShopAddressAdd').hide();
            $('#odvShopAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbShopAddressEdit').show();
            $('#odvShopAddressBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Event Add/Edit Shop Address
//Parameters: Event Click Button
//Creator: 10/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoAddEditShopAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $('#ofmShopAddressForm #ohdShopAddressRoute').val(),
        data: $('#ofmShopAddressForm').serialize(),
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxShopAddressDataTable(tCodeReturn);
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

//Functionality: Event Delete Address
//Parameters: Event Click Button
//Creator: 11/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoShopAddressDeleteData(poShopAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "shopAddressDeleteEvent",
        data: poShopAddressData,
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxShopAddressDataTable(tCodeReturn);
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
