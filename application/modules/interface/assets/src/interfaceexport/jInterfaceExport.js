
var nStaInterfaceImportBrowseType = $('#oetInterfaceExportStaBrowse').val();
var tCallInterfaceImportBackOption = $('#oetInterfaceExportCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    // $('.progress').hide();
});

//function : CheckSuccessProgress
//Parameters :
//Creator :	05/03/2020 Napat(Jame)
//Return : 1 = success , 2 = pendding
//Return Type :
function JSxIFXCheckSuccessProgress(){
    let nCounUnSucees = 0;
    $('.progress-bar-chekbox:checked').each(function(){
        let tIdElement =  $(this).attr('idpgb');
        if($('.'+tIdElement).data('status') == 2){
            nCounUnSucees++;
        }
    });
    if(nCounUnSucees > 0){
        return false;
    }else{
        return true;
    }
}

//function : Call Rabbit MQ
//Parameters :
//Creator :	05/03/2020  Napat(Jame)
//Return :
//Return Type :
function JSxIFXCallRabbitMQ(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        $.ajax({
            type: "POST",
            url: "interfaceexportAction",
            data: $('#ofmInterfaceExport').serialize()+"&ptTypeEvent="+'getpassword',
            cache: false,
            Timeout: 0,
            success: function(tResult){
                // console.log(tResult);
                var aResult = JSON.parse(tResult);
                if(aResult.tHost == '' || aResult.tPort == ''  || aResult.tPassword == '' || aResult.tUser == '' || aResult.tVHost == ""){
                    alert('Connect ใน ตั้งค่า Config ไม่ครบ');
                    return;
                }else{
                    var tPassword = JCNtAES128DecryptData(aResult.tPassword,'5YpPTypXtwMML$u@','zNhQ$D%arP6U8waL');

                    $.ajax({
                        type    : "POST",
                        url     : "interfaceexportAction",
                        data    : $('#ofmInterfaceExport').serialize()+"&ptTypeEvent="+'confirm'+'&tPassword='+tPassword,
                        cache   : false,
                        Timeout : 0,
                        success: function(tResult){
                            // console.log(tResult);

                            // $('.xWIFXDisabledOnProcess').attr('disabled',true); //ปิดปุ่ม และ inputs ทั้งหมด
                            // $('#obtInterfaceExportConfirm').attr('disabled',true);

                            $('.progress-bar-chekbox:checked').each(function(){
                                let tIdElement =  $(this).data('type');
                                $('.xWIFX'+tIdElement+'Progress').css('display','block');
                            });
                            // $('.xWIFXProgress').css('display','block');

                            JCNxCloseLoading();

                            $('.xWIFXDisabledOnProcess').attr('disabled',false); //เปิดปุ่ม และ inputs ทั้งหมด
                            $('#obtInterfaceExportConfirm').attr('disabled',false);
                            $('.xWIFXProgress').css('display','none');
                            $('#odvInterfaceEmportSuccess').modal('show');
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
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function : Subscribe Queue
//Parameters :
//Creator :	05/03/2020  Napat(Jame)
//Return :
//Return Type :
function JSxIFXSubScribeQName(){

	    $('input').prop('disabled',false);
		$('button').prop('disabled',false);

    let tUserCode = $('#tUserCode').val();
    var oIFXclient = Stomp.client('ws://' + oSTOMMQConfig.host + ':15674/ws');
    // ****** Send Rabbit MQ ******
    var on_connect = function(x){
        oIFXclient.subscribe('/queue/LK_RPTransferResponseSAP',function(res){  // ตอนนี้ใช้ Queue LK_QProgressBar
            // console.log("body",res.body);
            let aRes = JSON.parse(res.body);
            if(parseInt(aRes['pnStatus']) == 1){
                var tDisplay = $('.xWIFX' + aRes['ptType'] + 'TextDisplay').data('success');
                $('.xWIFX' + aRes['ptType'] + 'TextDisplay').addClass('text-success');
            }else{
                var tDisplay = $('.xWIFX' + aRes['ptType'] + 'TextDisplay').data('fail');
                $('.xWIFX' + aRes['ptType'] + 'TextDisplay').addClass('text-danger');
            }

            $('.xWIFX' + aRes['ptType'] + 'Progress').css('display','none'); // ปิด spinner
            $('.xWIFX' + aRes['ptType'] + 'TextDisplay').data('status','1');
            $('.xWIFX' + aRes['ptType'] + 'TextDisplay').css('display','block');
            $('.xWIFX' + aRes['ptType'] + 'TextDisplay').text(tDisplay);

            if(JSxIFXCheckSuccessProgress() == true){
                oIFXclient.disconnect();
                $('.xWIFXDisabledOnProcess').attr('disabled',false); //เปิดปุ่ม และ inputs ทั้งหมด
                $('#obtInterfaceExportConfirm').attr('disabled',false);
                $('.xWIFXProgress').css('display','none');
            }

            // if(aRes['pnStatus'] != 2){
            //     let nReSucess = JSxIFXUpdateProgress(aRes['pnProgress'],aRes['ptType']);
            //     if(nReSucess == 1){
            //         oIFXclient.disconnect();
            //         $('#obtInterfaceExportConfirm').attr('disabled',false);
            //     }
            // }else{
            //     $('#odvIFXProgressBar_'+aRes['ptType']).attr('status',2);
            //     $('#odvIFXProgressBar_'+aRes['ptType']).parent().hide();
            //     $('#ospIFXText_'+aRes['ptType']).text(aRes['ptDescription']);
            //     $('#ospIFXText_'+aRes['ptType']).css('color','red');
            //     $('#ospIFXText_'+aRes['ptType']).show();

            //     let nStatus = JSxIFXCheckSuccessProgress();
            //     if(nStatus == 1){
            //         oIFXclient.disconnect();
            //         $('#obtInterfaceExportConfirm').attr('disabled',false);
            //     }
            // }

        });
    }
    var on_error = function(x) {
        console.log(x);
    }

    oIFXclient.connect(oSTOMMQConfig.user, oSTOMMQConfig.password, on_connect, on_error, oSTOMMQConfig.vhost);
    // ****** Send Rabbit MQ ******
}

//function : Set Data Input To
//Parameters :
//Creator :	05/03/2020 Napat(Jame)
//Return :
//Return Type :
function JSxIFXAfterBrowseSaleFrom(oElem){
    var aElem = JSON.parse(oElem);
    var tDocNo = aElem[0];
    var tValueTo     = $('#oetITFXXshDocNoTo').val();
    if(tValueTo == ""){
        $('#oetITFXXshDocNoTo').val(tDocNo);
    }
}

//function : Set Data Input From
//Parameters :
//Creator :	05/03/2020 Napat(Jame)
//Return :
//Return Type :
function JSxIFXAfterBrowseSaleTo(oElem){
    var aElem = JSON.parse(oElem);
    var tDocNo = aElem[0];
    var tValueFrom   = $('#oetITFXXshDocNoFrom').val();
    if(tValueFrom == ""){
        $('#oetITFXXshDocNoFrom').val(tDocNo);
    }
}

//function : Claer Input DocNo Bill When Select Date
//Parameters :
//Creator :	05/03/2020 Napat(Jame)
//Return :
//Return Type :
function JSxIFXAfterChangeDateClearBrowse(){
    $('#oetITFXXshDocNoFrom').val('');
    $('#oetITFXXshDocNoTo').val('');
}

//function : Set Progress to Default
//Parameters :
//Creator :	06/03/2020 Napat(Jame)
//Return :
//Return Type :
function JSxIFXDefualValueProgress(){
    $('.xWIFXTextDisplay').css('display','none').removeClass('text-success').removeClass('text-danger').text('').data('status','2');
    // $('.progress-bar-chekbox:checked').each(function(){
    //     let tIdElement =  $(this).attr('idpgb');
    //     $('#odvIFXProgressBar_'+tIdElement).attr('status',1);
    //     $('#odvIFXProgressBar_'+tIdElement).attr('aria-valuenow',0);
    //     $('#odvIFXProgressBar_'+tIdElement).css('width','0%');
    //     $('#odvIFXProgressBar_'+tIdElement).text('0%');
    //     $('#ospIFXText_'+tIdElement).hide();
    //     $('.progress').show();
    // });
}
