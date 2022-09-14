
$(function(){
    JSvConnsetGenList(1);
})


//function : Call ConnsetGen Page list  
//Parameters : Document Redy And Event Button
//Creator :	15/05/2020 Witsarut (Bell)
//Return : View
//Return Type : View
function JSvConnsetGenList(pnPage){
    var nStaSession     = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll      = $('#oetSearchAll').val();
        var tStaApiTxnType  = $('#oetAPIStaApiTxnType').val();
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "connsetGenDataTable",
            data    :  {
                nPageCurrent   : pnPage,
                tSearchAll     : tSearchAll,
                tStaApiTxnType : tStaApiTxnType
            },
            cache   : false,
            Timeout : 0,
            async   : false,
            success : function(tView){
                $('#odvContentConnSetGenDataTable').html(tView);
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


//Functionality : Add Data Agency Add/Edit  
//Parameters : from ofmAddEditConnSetGenaral
//Creator : 18/05/2020 witsarut (Bell)
//Return : View
//Return Type : View
function JSxConnSetGenSaveAddEdit(ptRoute){

    $('input[type=password]').each(function(){
        // alert(tKey+ '//' + tIV);

        if($(this).val() != '' ){
            if($(this).val()!=$(this).data('oldpws')){
                var tPws = JCNtAES128EncryptData($(this).val(),tKey,tIV);
                $(this).val(tPws);
            }
        }

        // alert($(this).val()+"== "+tPws);
     })

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $.ajax({
            type: "POST",
            url: ptRoute,
            data: $('#ofmAddEditConnSetGenaral').serialize(),
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var aData = JSON.parse(tResult);
                if(aData["nStaEvent"] == 900){
                    var tMsgErrorFunction   = aData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                    var nSeqDup =aData['nSeqDup'];
                    $('#oetSeqGrp'+nSeqDup).focus();
                }else{
                    FSvCMNSetMsgWarningDialog("บันทึกการตั้งค่าเรียบร้อยแล้ว กรุณา Restart MQAdaLink-Interface");
                    JSvConnsetGenList(1);
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

//โชว์ Modal ยกเลิก
function JSxConnsetGenCancel(){
    $('#odvModalConCancel').modal('show');
}

//Event Modal ยกเลิก
function JSxConSetGenModalCancel(){
    $('#odvModalConCancel').modal('hide');
    $('#oetSearchAll').val('');
    $('#oetSearchAPI').val('');
    JSvConnsetGenList();
}


//Functionality : Call Page Edit APiAuth
//Parameters : Event Button Click 
//Creator : 29/5/2020 witsarut
//Return : View
//Return Type : View
function JSvCallPageEditApiAuth(paSeq, ptApiCode,ptAgnCode,ptBchCode){
    var paApiUrl   = $('#oetApiUrl').val();
    var paApiSeq   = $('#oetApiSeq').val();
    var pafmtCode = $('#oetFmtCode').val();
    var nStaSession   = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type : "POST",
            url : "ConSettingGanPageEditApiAuth",
            data : {
               tSeq : paSeq,
               tApiCode : ptApiCode,
               tAgnCode : ptAgnCode,
               tBchCode : ptBchCode,
               tApiUrl  : paApiUrl,
               tApiSeq  : paApiSeq,
               tFmtCode : pafmtCode,
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvContentConnSetGenDataTable').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    
}

//Functionality : Call Page Edit  
//Parameters : Event Button Click 
//Creator : 29/5/2020 witsarut
//Return : View
//Return Type : View
function JSvCallPageSetEdit(paDataSeq, paApiCode){

    var nPage = 1;
    var nStaSession     = JCNxFuncChkSessionExpired();
    var tSearchAPiAuthor   = $('#oetSearchAllGanPage').val();

    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ConSettingGanPageEdit",
            data: {
                DataSeq       : paDataSeq,
                nPageCurrent  : nPage,
                tSearchAPiAuthor : tSearchAPiAuthor,
                tApiCode   : paApiCode 
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#obtConnSetGenSave').hide();
                $('#obtConnSetGenCancel').hide();
                $('.input-group').hide();
                $('#odvContentConnSetGenDataTable').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call ConnectSettingGanaral Page Add  
//Parameters : Event Button Click
//Creator : 30/05/2005 witsarut
//Return : View
//Return Type : View
function JSvCallPageAddSetGanaral(){
    var tApiCode = $('#oetApiCode').val();
    var tApiSeq  = $('#oetApiSeq').val();
    var tApiUrl   = $('#oetApiUrl').val();
    var paFmtCode       = $('#oetFmtCode').val();
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type : "POST",
            url  : "ConSettingGanPageAdd",
            data : {
                tApiCode : tApiCode,
                tApiSeq  : tApiSeq,
                tApiUrl  : tApiUrl,
                tFmtCode : paFmtCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvContentConnSetGenDataTable').html(tResult);
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


//Functionality : Add Data Add/Edit  
//Parameters : from ofmAddEditConnSetGenaral
//Creator : 31/05/2020 witsarut (Bell)
//Return : View
//Return Type : View
function JSxSaveAddEdit2(ptRoute){

    var paAgnCode       = $('#oetSetAgnCode').val();
    var paBchCode       = $('#oetSetBchCode').val();
    var paApiUserName   = $('#oetApiUsrName').val();
    // var paApiPassword   = $('#oetApiPassword').val();
    var paApiKey        = $('#oetApiKey').val();
    var paApiRemark     = $('#otaApiRemark').val();
    var paCmpCode       = $('#oetCmpCode').val();
    var paApiCode       = $('#oetApiCode').val();
    var paGrpSeq        = $('#oetApiSeq').val();
    var paApiUrl        = $('#oetApiUrl').val();
    var paFmtCode       = $('#oetfmtCode').val();

    if($('#oetApiPassword').data('oldpws')!=$('#oetApiPassword').val()){
      var tApiPassword   = JCNtAES128EncryptData($('#oetApiPassword').val(),tKey,tIV);
    }else{
      var tApiPassword  = $('#oetApiPassword').val();
    }


    var nStaSession     = JCNxFuncChkSessionExpired();

    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddEditSetGenaral1').validate().destroy();
        $('#ofmAddEditSetGenaral1').validate({
            rules: {
                oetSetAgnName:   { "required": {} },
                oetSetBchName:   { "required": {} },
                oetfmtName:       { "required": {} },
            },
            messages: {
                oetSetAgnName: {
                    "required"      :      $('#oetSetAgnName').attr('data-validate-required'),
                    "dublicateCode" :      $('#oetSetAgnName').attr('data-validate-dublicateCode'),
                },
                oetSetBchName: {
                    "required"      :      $('#oetSetBchName').attr('data-validate-required'),
                    "dublicateCode" :      $('#oetSetBchName').attr('data-validate-dublicateCode'),
                },
                oetfmtName: {
                    "required"      :      $('#oetfmtName').attr('data-validate-required'),
                    "dublicateCode" :      $('#oetfmtName').attr('data-validate-dublicateCode'),
                },
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
                $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
            },
            submitHandler: function(form) {

                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: {
                       tAgnCode    : paAgnCode,
                       tBchCode    : paBchCode,
                       tApiUserName : paApiUserName,
                       tApiPassword : tApiPassword,
                       tApiKey     : paApiKey,
                       tApiRemark  : paApiRemark,
                       tCmpCode    : paCmpCode,
                       tApiCode    : paApiCode,
                       tApiUrl     : paApiUrl,
                       tFmtCode   : paFmtCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        console.log(JSON.parse(tResult));
                      var objJSon =  JSON.parse(tResult);
                      if(objJSon['nStaEvent']==1){
                        JSvCallPageSetEdit(paGrpSeq, paApiCode);
                      }else{
                           alert(objJSon['tStaMessg']);
                      }
                        JCNxCloseLoading();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }
}


//Functionality: (event) Delete
//Parameters: Button Event [tIDCode tUsrCode]
//Creator: 10/05/2018 Witsarut (Bell)
//Update: -
//Return: Event Delete Reason List
//Return Type: -
function JSoConSetGanDel(ptApiCode, ptAgnCode, ptBchCode ,ptSeq, ptSpaUsrCode, tYesOnNo){
    $('#odvModalDeleteSingle').modal('show');
    $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptSpaUsrCode + ' '+ tYesOnNo );
    $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ConSettingGenaralEventDelete",
            data: {
                tApiCode    : ptApiCode,
                tAgnCode    : ptAgnCode,
                tBchCode    : ptBchCode,
                tSeq        : ptSeq,
                tSpaUsrCode : ptSpaUsrCode,
            },
            cache: false,
            success: function(tResult){
                $('#odvModalDeleteSingle').modal('hide');
                setTimeout(function(){
                    JSvCallPageSetEdit(ptSeq, ptApiCode);
                    JCNxCloseLoading();
                },500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    })
}


//Functionality: เปลี่ยนหน้า pagenation
//Parameters: -
//Creator: 09/05/2018 Witsarut
//Update: -
//Return: View
//Return Type: View
function JSvConSetClickPage(ptPage){
    var nPageCurrent = "";
    switch (ptPage) {
        case "next": //กดปุ่ม Next
            $(".xWBtnNext").addClass("disabled");
            nPageOld = $(".xWSETPaging .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 1) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
        break;
        case "previous": //กดปุ่ม Previous
            nPageOld = $(".xWSETPaging .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 1) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
        break;
        default:
        nPageCurrent = ptPage;
    }
}