var tBranchAddressBchCode   = $('#ohdBranchAddressBchCode').val();
var tBranchAddressBchName   = $('#ohdBranchAddressBchName').val();

$("ducument").ready(function(){
    // Event Click Title Menu Branch Address
    $('#odvBranchDataAddress #olbBranchAddressInfo').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxBranchAddressDataTable(tBranchAddressBchCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Call Page Branch Address Add
    $('#odvBranchDataAddress #obtBranchAddressCallPageAdd').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSvCallPageAddBranchAddress();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Cancel Event Branch Address
    $('#odvBranchDataAddress #obtBranchAddressCancle').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSxBranchAddressDataTable(tBranchAddressBchCode);
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Add/Edit Event Branch Address
    $('#odvBranchDataAddress #obtBranchAddressSave').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $('#ofmBranchAddressForm #obtAddEditBranchAddress').trigger('click');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    JCNxBranchAddressSetNavDefault();
    JSxBranchAddressDataTable(tBranchAddressBchCode);
});

// Functionality: Set Branch Address Nav Default
// Parameters: Document Ready And Function Parameter
// Creator: 11/09/2019 Wasin
// Return: -
// ReturnType: -
function JCNxBranchAddressSetNavDefault(){
    // Hide Title And Button Default
    $('#olbBranchAddressAdd').hide();
    $('#olbBranchAddressEdit').hide();
    $('#odvBranchAddressBtnGrpAddEdit').hide();
    // Show Title And Button Default
    $('#olbBranchAddressInfo').show();
    $('#odvBranchAddressBtnGrpInfo').show();
}

// Functionality: Call Branch Address Data Table
// Parameters: -
// Creator: 11/09/2019 Wasin
// Return: view
// ReturnType: view
function JSxBranchAddressDataTable(ptBranchCode){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "branchAddressDataTable",
        data: {
            'ptBchCode' : ptBranchCode
        },
        success: function(tResult) {
            $('#odvBranchDataAddress #odvBranchAddressContent').html(tResult);
            JCNxBranchAddressSetNavDefault();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality: Call Page Add Branch Address
// Parameters: Event Click Button And Function Parameter
// Creator: 11/09/2019 Wasin
// Return: view
// ReturnType: view
function JSvCallPageAddBranchAddress() {
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "branchAddressPageAdd",
        data:{
            'ptBranchAddressBchCode' : tBranchAddressBchCode,
            'ptBranchAddressBchName' : tBranchAddressBchName
        },
        success: function(tResult) {
            $('#odvBranchDataAddress #odvBranchAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbBranchAddressEdit').hide();
            $('#odvBranchAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbBranchAddressAdd').show();
            $('#odvBranchAddressBtnGrpAddEdit').show();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Call Page Edit Branch Address
//Parameters: Event Click Button And Function Parameter
//Creator: 11/09/2019 Wasin
//Return: view
//ReturnType: object
function JSvCallPageEditBranchAddress(poBranchAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url : "branchAddressPageEdit",
        data : poBranchAddressData,
        success: function(tResult){
            $('#odvBranchDataAddress #odvBranchAddressContent').html(tResult);
            // Hide Title And Button
            $('#olbBranchAddressAdd').hide();
            $('#odvBranchAddressBtnGrpInfo').hide();
            // Show Title And Button
            $('#olbBranchAddressEdit').show();
            $('#odvBranchAddressBtnGrpAddEdit').show();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality: Event Add/Edit Branch Address
//Parameters: Event Click Button
//Creator: 10/09/2019 Wasin
//Return: view
//ReturnType: object
function JSoAddEditBranchAddress(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $('#ofmBranchAddressForm #ohdBranchAddressRoute').val(),
        data: $('#ofmBranchAddressForm').serialize(),
        success: function(tResult){
            let aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxBranchAddressDataTable(tCodeReturn);
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
function JSoBranchAddressDeleteData(poBranchAddressData){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "branchAddressDeleteEvent",
        data: poBranchAddressData,
        success: function(tResult){
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaReturn'] == 1){
                var tCodeReturn = aDataReturn['tDataCodeReturn'];
                JSxBranchAddressDataTable(tCodeReturn);
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
