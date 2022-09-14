
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxLRNGetPageFormAndCallAPI();
    // $('.progress').hide();
});

    //Functionality : Event Call API
    //Parameters : 
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function JSxLRNGetPageFormAndCallAPI(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "LicenseRenewPageForm",
            data: { 
                tCstKey: $('#oetIMRCstKey').val(),
                tStaUpdAcc : $('#ohdStaUpdAcc').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResultHtml){
                $("#odvLRNPageFrom").html(tResultHtml);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
}


    //Functionality : Event Call Page Register
    //Parameters : URL
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function FSvIMRCallPageRegister(tURL){

            // ฟังก์ชั่น Check Session
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $.ajax({
                    url: tURL,
                    type: "POST",
                    error: function (jqXHR, textStatus, errorThrown) {
        
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    },
                    success: function (tView) {

                        //console.log(tView);
                        $(window).scrollTop(0);
                        $('.odvMainContent').html(tView);

                        // Chk Status Favorite
                        JSxChkStaDisFavorite(tURL);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }

}

    //Functionality : Event Call Page Register
    //Parameters : URL
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function FSxLRNCallCheckBill(){

            // ฟังก์ชั่น Check Session
            var oInputChecked = $("input:checkbox:checked").map(function(){
                return $(this).val();
              });
            
            var nRenewmonth = $('#ocmRenewmonth').val();
            if(nRenewmonth!='' && oInputChecked.length>0){
                JCNxOpenLoading();
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var oPackageLicCode = $('.ocbPackageLicCode:checked').map(function(){ return $(this).val(); }).get();
                var oFeatureLicCode = $('.ocbFeatureLicCode:checked').map(function(){ return $(this).val(); }).get();
                var oClientLicCode = [];
                 $('.ocbClientLicCode:checked').map(function(index){ oClientLicCode[index] = { nSeqUUid :$(this).data('uuid') , tPosCode:$(this).val()  }  }).get();
            
                $.ajax({
                    url: 'LicenseRenewCallCheckBill',
                    type: "POST",
                    data: {
                        oPackageLicCode:oPackageLicCode,
                        oFeatureLicCode:oFeatureLicCode,
                        oClientLicCode:oClientLicCode,
                        nRenewmonth:nRenewmonth
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                   
                        JCNxCloseLoading();
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    },
                    success: function (tResult) {

                        FSvLRNCallPageRegisterCheckBill();
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }else{
        
        }

    }




    //Functionality : Event Call Page Register
    //Parameters : URL
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function FSvLRNCallPageRegisterCheckBill(){
        $.ajax({
            url: 'BuyLicense/2',
            type: "POST",
            error: function (jqXHR, textStatus, errorThrown) {
            JCNxCloseLoading();
            JCNxResponseError(jqXHR, textStatus, errorThrown);
            },
            success: function (tView) {
            $(window).scrollTop(0);
            $('.odvMainContent').html(tView);
        
            setTimeout(function(){ JSxNextStepToPageDatatableListExtend(); }, 1000);
            }
        });
    }