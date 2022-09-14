var nStaInterfaceImportBrowseType = $('#oetInterfaceImportStaBrowse').val();
var tCallInterfaceImportBackOption = $('#oetInterfaceImportCallBackOption').val();
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    // $('.progress').hide();
});
//function : Event Click Checkbox all  
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
$('#ocmINMChkAll').click(function() {

    if ($(this).prop('checked') == true) {
        $('.progress-bar-chekbox').prop('checked', true);
    } else {
        $('.progress-bar-chekbox').prop('checked', false);
    }
});


//function : DefualValueProgress
//Parameters :
//Creator :	06/03/2020 nale
//Return : 
//Return Type : 

function JSxINMDefualValueProgress() {

    $('.xWINMTextDisplay').css('display', 'none').removeClass('text-success').removeClass('text-danger').text('').data('status', '2');
    // $('.progress-bar-chekbox:checked').each(function(){

    //     let tIdElement =  $(this).attr('idpgb');
    //     $('#odv'+tIdElement).attr('aria-valuenow',0);
    //     $('#odv'+tIdElement).css('width','0%');
    //     $('#odv'+tIdElement).text('0%');
    //     $('#odv'+tIdElement).attr('status',1);
    //     $('#osp'+tIdElement).hide();
    //     $('#otd'+tIdElement).show();
    // });

}
//function : UpdateProgress
//Parameters : pnPer ptType
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
function JSxINMUpdateProgress(pnPer, ptType) {

    $('#odvINM' + ptType + 'ProgressBar').attr('aria-valuenow', pnPer);
    $('#odvINM' + ptType + 'ProgressBar').css('width', pnPer + '%');
    $('#odvINM' + ptType + 'ProgressBar').text(pnPer + '%');
    let nSuccessType = 0;
    if (pnPer == 100) {
        $('#odvINM' + ptType + 'ProgressBar').attr('status', 2);
        nSuccessType = JSxINMCheckSuccessProgress();

        setTimeout(() => {
            $('#odvINM' + ptType + 'ProgressBar').parent().hide();
            $('#ospINM' + ptType + 'ProgressBar').css('color', 'green');
            $('#ospINM' + ptType + 'ProgressBar').show();
            let tstingshow = $('#ospINM' + ptType + 'ProgressBar').attr('distext');
            $('#ospINM' + ptType + 'ProgressBar').text(tstingshow);

        }, 3000);

    }
    return nSuccessType;
}

//function : CheckSuccessProgress 
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 1 = success , 2 = pendding
//Return Type : 
function JSbINMCheckSuccessProgress() {
    let nCounUnSucees = 0;
    $('.progress-bar-chekbox:checked').each(function() {
        let tIdElement = $(this).attr('idpgb');
        if ($('.' + tIdElement).data('status') == 2) {
            nCounUnSucees++;
        }
    });

    if (nCounUnSucees > 0) {
        return false;
    } else {
        return true;
    }
}
//function : Click Confrim  
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
$('#obtInterfaceImportConfirm').click(function() {
    //    let nImpportFile = $('.progress-bar-chekbox:checked').length;
    //     if(nImpportFile > 0){
    JCNxOpenLoading();
    JSxINMDefualValueProgress();
    JSxINMCallRabbitMQ();
    // }else{
    //     alert('Please Select Imformation For Import');
    // }

});

//function : Call Rabbit MQ 
//Parameters : 
//Creator :	05/03/2020 nale
//Return : 
//Return Type : 
function JSxINMCallRabbitMQ() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

        $.ajax({
            type: "POST",
            url: "interfaceimportAction",
            data: $('#ofmInterfaceImport').serialize() + "&ptTypeEvent=" + 'getpassword',
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                // console.log(tResult);
                var aResult = JSON.parse(tResult);
                if (aResult.tHost == '' || aResult.tPort == '' || aResult.tPassword == '' || aResult.tUser == '' || aResult.tVHost == "") {
                    alert('Connect ใน ตั้งค่า Config ไม่ครบ');
                    return;
                } else {
                    var tPassword = JCNtAES128DecryptData(aResult.tPassword, '5YpPTypXtwMML$u@', 'zNhQ$D%arP6U8waL');

                    $.ajax({
                        type: "POST",
                        url: "interfaceimportAction",
                        data: $('#ofmInterfaceImport').serialize() + "&ptTypeEvent=" + 'confirm' + '&tPassword=' + tPassword,
                        cache: false,
                        Timeout: 0,
                        success: function(tResult) {
                            console.log(tResult);
                            // $('#obtInterfaceImportConfirm').attr('disabled', true);
                            // $('.xWINMProgress').css('display', 'block');

                            $('.progress-bar-chekbox:checked').each(function(e) {
                                var nValue = $(this).val();
                                switch (nValue) {
                                    case '00006':
                                        $('.xWINM'+nValue+'Progress').css('display', 'block');
                                    break;
                                    case '00007':
                                        $('.xWINM'+nValue+'Progress').css('display', 'block');
                                    break;
                                  }
                            });
                            JCNxCloseLoading();
                         
                            $('#obtInterfaceImportConfirm').attr('disabled', false);
                            $('.xWINMProgress').css('display', 'none');
                            $('#odvInterfaceImportSuccess').modal('show');
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}

