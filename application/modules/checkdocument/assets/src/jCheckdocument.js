
$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxMNTGetPageForm();
    // $('.progress').hide();
    // console.log(JCNtAES128EncryptData('Moe29161',tKey,tIV));
});

//Functionality : Event Call API
//Parameters : 
//Creator : 11/01/2021
//Return : -
//Return Type : -
function JSxMNTGetPageForm(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "mntDocStaPageForm",
            data: { 
                tMNTTypePage: $('#ohdMNTTypePage').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResultHtml){
                $('#oliMNTTitleEdit').hide();
                $('#odvMNTBtnGrpInfo').hide();
                $('#obtMNTCallPageAdd').show();
                $('#oliMNTTitleAdd').hide();
                $('#odvMNTBtnGrpAddEdit').hide();
                $("#odvMNTPageFrom").html(tResultHtml);
                // JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
}



//Functionality : Event Call API
//Parameters : 
//Creator : 11/01/2021
//Return : -
//Return Type : -
function JSxMNTGetPageSumary(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "mntDocStaPageSumary",
        data: { 
            tMNTTypePage: $('#ohdMNTTypePage').val(),
            tMNTDocDateFrom : $('#oetMNTDocDateFrom').val(),
            tMNTDocDateTo : $('#oetMNTDocDateTo').val(),
            tMNTDocType : $('#ocmMNTDocType').val(),
            tMNTBchCode: $('#oetMNTBchCode').val(),
        },
        cache: false,
        timeout: 0,
        success: function(tResultHtml){
            $("#odvCheckdocSumary").html(tResultHtml);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



//Functionality : Event Call API
//Parameters : 
//Creator : 11/01/2021
//Return : -
//Return Type : -
function JSxMNTGetPageDataTable(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "mntDocStaPageDataTable",
        data: { 
            tMNTTypePage: $('#ohdMNTTypePage').val(),
            tMNTDocDateFrom : $('#oetMNTDocDateFrom').val(),
            tMNTDocDateTo : $('#oetMNTDocDateTo').val(),
            tMNTDocType : $('#ocmMNTDocType').val(),
            tMNTBchCode: $('#oetMNTBchCode').val(),
        },
        cache: false,
        timeout: 0,
        success: function(tResultHtml){
            $("#odvCheckdocDataTable").html(tResultHtml);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



    // Event Click Button Add Page
    $('#obtMNTCallPageAdd').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSvMNTCallPageAdd();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    // Event Click Button Add Page
    $('#obtMNTCallBackPage').unbind().click(function(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            JSxMNTGetPageForm();
        }else{
            JCNxShowMsgSessionExpired();
        }
    });
    

// Functionality : Call Role Page Add  
// Parameters : Event Button Click Call Page And Document Ready
// Creator : 22/06/2018 wasin
// Last Update : 15/08/2019 Wasin(Yoshi)
// Return : View Page Add
// Return Type : View
function JSvMNTCallPageAdd(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "mntDocStaPageAdd",
        cache: false,
        success: function(tResult){
            // var aReturnData = JSON.parse(tResult);
            // if(aReturnData['nStaEvent'] == '1'){
          
                    $('#oliMNTTitleEdit').hide();
                    $('#odvMNTBtnGrpInfo').hide();
                    $('#obtMNTCallPageAdd').hide();
                    $('#oliMNTTitleAdd').show();
                    $('#odvMNTBtnGrpAddEdit').show();
                    $('#odvMNTPageFrom').html(tResult);
                
            // }else{
            //     var tMessageError = aReturnData['tStaMessg'];
            //     FSvCMNSetMsgErrorDialog(tMessageError);
            // }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}



//Functionality : (event) Add/Edit Reason
//Parameters : form
//Creator : 09/05/2018 wasin
//Return : object Status Event And Event Call Back
//Return Type : object
function JSnAddEditMntDoc(ptRoute) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        $('#ofmAddMntDoc').validate().destroy();

        $('#ofmAddMntDoc').validate({
            rules: {
                oetMNTBchName: { "required": {} },
                oetMNTDesc1: { "required": {} },
                oetMNTDesc2: { "required": {} },
            },
            messages: {
                oetMNTBchName: {
                    "required": $('#oetMNTBchName').attr('data-validate-required'),
                },
                oetMNTDesc1: {
                    "required": $('#oetMNTDesc1').attr('data-validate-required'),
                },
                oetMNTDesc2: {
                    "required": $('#oetMNTDesc2').attr('data-validate-required'),
                }
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
                var nStaCheckValid = $(element).parents('.form-group').find('.help-block').length
                if (nStaCheckValid != 0) {
                    $(element).closest('.form-group').addClass("has-success").removeClass("has-error");
                }
            },
            submitHandler: function(form) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: 'mntStaDocEventAdd',
                    data: $('#ofmAddMntDoc').serialize(),
                    async: false,
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                            $("#odvMntModalConfirm").modal("hide");
                            JSxMNTGetPageForm();
                            JCNxCloseLoading();
                           
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
}



        // Event Click Appove Document
        $('#obtMntSendNoti').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $('#odvMntModalConfirm').modal({backdrop:'static',keyboard:false});
                $("#odvMntModalConfirm").modal("show");
            }else{
                JCNxShowMsgSessionExpired();
            }
        });



