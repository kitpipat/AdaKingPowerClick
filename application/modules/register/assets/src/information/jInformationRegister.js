
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxIMRGetPageFormAndCallAPI();
    // $('.progress').hide();
});

    //Functionality : Event Call API
    //Parameters : 
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function JSxIMRGetPageFormAndCallAPI(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ImformationRegisterPageForm",
            data: { 
                tCstKey: $('#oetIMRCstKey').val(),
                tStaUpdAcc : $('#ohdStaUpdAcc').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResultHtml){
                $("#odvIMRPageFrom").html(tResultHtml);
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
    function JSvIMPInputFileAccount() {
        $(".input-file-account").before(
            function() {
                if ( ! $(this).prev().hasClass('input-ghost') ) {
                    var oElement = $("<input type='file' name='oefIMRCallApiImportAccount' id='oefIMRCallApiImportAccount' class='input-ghost' style='visibility:hidden; height:0'>");
                    oElement.attr("name",$(this).attr("name"));
                    oElement.change(function(){
                        oElement.next(oElement).find('input').val((oElement.val()).split('\\').pop());
                    });
                    $(this).find("button.btn-choose").click(function(){
                        oElement.click();
                    });
                    $(this).find("button.btn-reset").click(function(){
                        oElement.val(null);
                        $(this).parents(".input-file-account").find('input').val('');
                    });
                    $(this).find('input').css("cursor","pointer");
                    $(this).find('input').mousedown(function() {
                        $(this).parents('.input-file-account').prev().click();
                        return false;
                    });
                    return oElement;
                }
            }
        );
    }

    //Functionality : Event Call Page Register
    //Parameters : URL
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function JSvIMPInputFileLicense() {
        $(".input-file-license").before(
            function() {
                if ( ! $(this).prev().hasClass('input-ghost') ) {
                    var oElement = $("<input type='file' name='oefIMRCallApiImportLicense' id='oefIMRCallApiImportLicense' class='input-ghost' style='visibility:hidden; height:0'>");
                    oElement.attr("name",$(this).attr("name"));
                    oElement.change(function(){
                        oElement.next(oElement).find('input').val((oElement.val()).split('\\').pop());
                    });
                    $(this).find("button.btn-choose").click(function(){
                        oElement.click();
                    });
                    $(this).find("button.btn-reset").click(function(){
                        oElement.val(null);
                        $(this).parents(".input-file-license").find('input').val('');
                    });
                    $(this).find('input').css("cursor","pointer");
                    $(this).find('input').mousedown(function() {
                        $(this).parents('.input-file-license').prev().click();
                        return false;
                    });
                    return oElement;
                }
            }
        );
    }


    $(function() {
        JSvIMPInputFileAccount();
        JSvIMPInputFileLicense();
    });




    //Functionality : Event Call Page Register
    //Parameters : URL
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function JSxIMRImportAccount(){
        var file_data = $('#oefIMRCallApiImportAccount').prop('files')[0];   

        if(file_data!=undefined && file_data!=null){
        JCNxOpenLoading();
        var form_data = new FormData();                  
        form_data.append('oefIMRCallApiImportAccount', file_data);
        // alert(form_data);                             
        $.ajax({
            url: 'ImformationRegisterEventImportAccount', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            Timeout : 0,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(res){
                JCNxCloseLoading();
            var paDataReturn = JSON.parse(res);
            if(paDataReturn['rtCode']=='1'){
                FSvCMNSetMsgSucessDialog('Success');
            }else{
                FSvCMNSetMsgErrorDialog('Error');
            }
                // alert(res); 
                // display response from the PHP script, if any
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    // JCNxResponseError(jqXHR, textStatus, errorThrown);
                    // JSxSaleImportUploadFile();
                }
        });
      }else{
        FSvCMNSetMsgSucessDialog('กรุณาเลือกไฟล');

      }
    }



    
    //Functionality : Event Call Page Register
    //Parameters : URL
    //Creator : 11/01/2021
    //Return : -
    //Return Type : -
    function JSxIMRImportLicense(){
    
        var file_data = $('#oefIMRCallApiImportLicense').prop('files')[0];   
        if(file_data!=undefined && file_data!=null){
            JCNxOpenLoading();
        var form_data = new FormData();                  
        form_data.append('oefIMRCallApiImportLicense', file_data);
        // alert(form_data);                             
        $.ajax({
            url: 'ImformationRegisterEventImportLicense', // point to server-side PHP script 
            dataType: 'text',  // what to expect back from the PHP script, if anything
            cache: false,
            Timeout : 0,
            contentType: false,
            processData: false,
            data: form_data,                         
            type: 'post',
            success: function(res){
                JCNxCloseLoading();
            var paDataReturn = JSON.parse(res);
            if(paDataReturn['rtCode']=='1'){
                FSvCMNSetMsgSucessDialog('Success');
            }else{
                FSvCMNSetMsgErrorDialog('Error');
            }
                // alert(res); 
                // display response from the PHP script, if any
            },
            error: function (jqXHR, textStatus, errorThrown) {
                    // JCNxResponseError(jqXHR, textStatus, errorThrown);
                    // JSxSaleImportUploadFile();
                }
        });
        }else{
            FSvCMNSetMsgSucessDialog('กรุณาเลือกไฟล');

        }
    }



