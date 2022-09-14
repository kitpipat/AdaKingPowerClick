var nStaPosEdcBrowseType    = $('#oetPosRegStaBrowse').val();
var tCallPosEdcBackOption   = $('#oetPosRegCallBackOption').val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); 
    JSvPosRegisterCallPageList();
});

// Function : Call Page List
// Crete By Witsarut 14/07/2020
function JSvPosRegisterCallPageList(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        try{
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "posregList",
                data    : {},
                cache   : false,
                timeout : 5000,
                success : function(tResult){
                    $('#odvContentPagePosRegister').html(tResult);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch(err){
            console.log('JSvPosRegisterCallPageList Error: ', err);
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function  Load Table Setting 
//Create By Witsarut 14/07/2020
function JSvPosRegisterLoadTable(){
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try{
            localStorage.removeItem('LocalItemData');

            var tStaApv   = $("#ocmStaApv option:selected").val();
            var tSearch   = $('#oetSearchAll').val();

            $.ajax({
                type    : "POST",
                url     : "posregLoadTable",
                data    : {tStaApv : tStaApv, tSearch : tSearch},
                cache   : false,
                timeout : 5000,
                success : function (tResult){
                    aPackData       = [];
                    aPackDataInput  = [];
                    $('#odvContentPosRegisterTable').html(tResult);
                    JSxControlScroll();
                    JCNxCloseLoading();

                    if(tStaApv == '1'){
                        $(".xCNBTNSave").hide();
                        $(".xCNBTNCancel").show();
                        $(".XCNhideDatePic").hide();
                        $(".XCNLabelHide").hide();
                        $(".ocbListItem").attr("disabled", false);
                    }else if(tStaApv == '2'){
                        $(".XCNLabelHide").show();
                        $(".XCNhideDatePic").show();
                        $(".xCNBTNCancel").hide();
                        $(".xCNBTNSave").show();
                    }else if(tStaApv == '0'){
                        $(".XCNLabelHide").show();
                        $(".XCNhideDatePic").show();
                        $(".xCNBTNCancel").hide();
                        $(".xCNBTNSave").show();
                    }else if(tStaApv == '3'){
                        $(".xCNBTNCancel").hide();
                        $(".xCNBTNSave").hide();
                        $(".XCNLabelHide").hide();
                        $(".XCNhideDatePic").hide();
                        $(".ocbListItem").attr("disabled", true);
                        $("#oetAllCheck").attr("disabled", true);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvPosRegisterCallPageList Error: ', err);
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//ควบคุมตารางให้มีสกอร์ หรือไม่มีสกอร์
function JSxControlScroll(){
    var nWindowHeight = ( $(window).height() - 460 ) / 2 ;

    //สำหรับตารางที่เป็นเช็คบ๊อก
    var nLenCheckbox =  $('#otbTableForCheckbox tbody tr').length;
    if(nLenCheckbox > 6){
        $('.xCNTableHeightCheckbox').css('height',nWindowHeight);
    }else{
        $('.xCNTableHeightCheckbox').css('height','auto');
    }
}


//function : Event Save 
//Create By Witsarut 14/07/2020
function JSxPosRegisterSave(){
    var nStaSession  = JCNxFuncChkSessionExpired();
    var tPosRegDate  =  $('#oetPosRegDate').val();
    var aDataBchCode = [[],[]];
    var aDataPosCode = [[],[]];
    var aDataohdPrgDate = [[],[]];
    var aDataMacAddr = [[],[]];
    var aDataPrgExp  = [[],[]];
    var aDataPrivateKey = [[],[]];
    var aDataEncPassword = [[],[]];
    var nI = 0;
    var tEncryptPassword='';
    $('.ocbListItem').each(function(){
        if($(this).is(':checked') && $(this).attr('disabled') === undefined ) {
            var ohdBchCode =  $(this).attr('ohdBchCode'); //รหัสสาขา
            var ohdPosCode =  $(this).attr('ohdPosCode'); //รหัสเครื่องจุดขาย
            var ohdPrgDate =  $(this).attr('ohdPrgDate');  //วันที่ลงทะเบียน
            var ohdMacAddr =  $(this).attr('ohdMacAddr'); //รหัส Mac Addr ของเครื่องจุดขาย (POS)
            var ohdPrgExp  =  $(this).attr('ohdPrgExp');  //วันที่ลงทะเบียนหมดอายุ
            var oetPosRegDate  = $('#oetPosRegDate').val();  //วันที่ลงทะเบียนหมดอายุ
            var ohdPrivateKey = $(this).attr('ohdPrivateKey');
            
            // เข้ารหัส AES 128 

            // ของเก่า ไม่มี Branch เข้า รหัส
            // tEncryptPassword = ohdPosCode+':'+ohdMacAddr+':'+oetPosRegDate+':'+ohdPrivateKey;

            // เพิ่ม BchCode เข้ารหัส 
            tEncryptPassword =  ohdBchCode+':'+ohdPosCode+':'+ohdMacAddr+':'+oetPosRegDate+':'+ohdPrivateKey;
            tEncPassword  = JCNtAES128EncryptData(tEncryptPassword, tKey, tIV);

            aDataBchCode[nI] = {
                ohdBchCode:ohdBchCode ,
            };

            aDataPosCode[nI] = {
                ohdPosCode:ohdPosCode,
            };

            aDataohdPrgDate[nI] = {
                ohdPrgDate:ohdPrgDate , 
            };

            aDataMacAddr[nI] = {
                ohdMacAddr:ohdMacAddr, 
            };

            aDataPrgExp[nI] = {
                ohdPrgExp:ohdPrgExp,
            };

            aDataPrivateKey[nI] = {
                ohdPrivateKey:ohdPrivateKey,
            };

            aDataEncPassword[nI] = {
                tEncPassword:tEncPassword
            };

         nI++;
        }

    });

    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type  : "POST",
            url   : "posregSaveData",
            data: { 
                    aDataBchCode : aDataBchCode,
                    aDataPosCode : aDataPosCode,
                    aDataohdPrgDate : aDataohdPrgDate,
                    aDataMacAddr : aDataMacAddr,
                    aDataPrgExp : aDataPrgExp,
                    aDataPrivateKey:aDataPrivateKey,
                    aDataEncPassword:aDataEncPassword,
                    tPosRegDate  : tPosRegDate
                },
            cache : false,
            timeout : 0,
            success: function(tResult){
                JSvPosRegisterCallPageList();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}



//function confirm modal
function JSxPosRegModalConfirm(){

    $('#odvModalConCancel').modal('hide');
    JCNxOpenLoading();

    var aDataCancelBchCode = [[],[]];
    var aDataCancelPosCode = [[],[]];
    var aDataCancelMacAddr = [[],[]];
    var aDataCancelPrgDate = [[],[]];
    var aDataCancelEncPassword = [[],[]];
    var nJ = 0;

    $('.ocbListItem').each(function(){
        if($(this).is(':checked')) {
            var ohdCancelBchCode =  $(this).attr('ohdBchCode'); //รหัสสาขา
            var ohdCancelPosCode =  $(this).attr('ohdPosCode'); //รหัสเครื่องจุดขาย
            var ohdCancelMacAddr =  $(this).attr('ohdMacAddr'); //รหัส Mac Addr ของเครื่องจุดขาย (POS)
            var ohdCancelPrgDate =  $(this).attr('ohdPrgDate');  //วันที่ลงทะเบียน

            tEncryptCancelPassword = '';

            aDataCancelBchCode[nJ] = {
                ohdCancelBchCode : ohdCancelBchCode ,
            };

            aDataCancelPosCode[nJ] = {
                ohdCancelPosCode : ohdCancelPosCode,
            };

            aDataCancelMacAddr[nJ] = {
                ohdCancelMacAddr:ohdCancelMacAddr, 
            };

            aDataCancelPrgDate[nJ] = {
                ohdCancelPrgDate:ohdCancelPrgDate , 
            };

            aDataCancelEncPassword[nJ] = {
                tEncryptCancelPassword:tEncryptCancelPassword,
            };
            nJ++;
        }
    });

    var nStaSession  = JCNxFuncChkSessionExpired();

    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type : "POST",
            url  : "posregCancelData",
            data : {
                aDataCancelBchCode : aDataCancelBchCode,
                aDataCancelPosCode : aDataCancelPosCode,
                aDataCancelMacAddr : aDataCancelMacAddr,
                aDataCancelPrgDate : aDataCancelPrgDate,
                aDataCancelEncPassword : aDataCancelEncPassword
            },
            cache : false,
            timeout : 0,
            success: function(tResult){
                JSvPosRegisterCallPageList();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }

}

// function Show Modal
// Create By Witsarut 16/07/2020
function JSxPosRegisterCancel(){
    $('#odvModalConCancel').modal('show');
}