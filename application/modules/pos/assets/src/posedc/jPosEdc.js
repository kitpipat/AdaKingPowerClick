var nStaPosEdcBrowseType    = $('#oetPosEdcStaBrowse').val();
var tCallPosEdcBackOption   = $('#oetPosEdcCallBackOption').val();

$('ducument').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose();
    if(typeof(nStaPosEdcBrowseType) != 'undefined' && nStaPosEdcBrowseType == 0){

        // Event Click Navigater Title (คลิก Title)
        $('#oliPosEdcTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCallPagePosEdcList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Button Add Page
        $('#obtPosEdcCallPageAdd').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCallPagePosEdcAdd();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Call Back Page
        $('#obtPosEdcCallBackPage').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvCallPagePosEdcList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Submit From Add/Edit PosEdc
        $('#obtPosEdcSubmitFrom').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $('#obtPosEdcAddEditEvent').unbind().click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JCNxOpenLoading();
        JSxPosEdcNavDefult();
        JSvCallPagePosEdcList();
    }else{

        // Event Modal Call Back Before List
        $('#oahPosEdcBrowseCallBack').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tCallPosEdcBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Modal Call Back Previous
        $('#oliPosEdcBrowsePrevious').unbind().click(function (){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxBrowseData(tCallPosEdcBackOption);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Submit In Modal
        $('#obtPosEdcBrowseSubmit').unbind().click(function () {
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                $('#obtPosEdcAddEditEvent').unbind().click();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        JSxPosEdcNavDefult();
        JSvCallPagePosEdcAdd();
    }
});

// Function : Function Clear Defult Button Pos Edc
// Parameters : Document Ready Call Function
// Creator : 30/08/2019 wasin(Yoshi)
// LastUpdate : -
// Return : 
// Return Type : -
function JSxPosEdcNavDefult(){
    if(typeof(nStaPosEdcBrowseType) != 'undefined' && nStaPosEdcBrowseType == 0){
        $('.obtChoose').hide();
        $('#oliPosEdcTitleAdd').hide();
        $('#oliPosEdcTitleEdit').hide();
        $('#odvPosEdcBtnGrpAddEdit').hide();
        $('#odvPosEdcBtnGrpInfo').show();
    }else{
        $('#odvModalBody #odvPosEdcMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliPosEdcNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvPosEdcBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNPosEdcBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNPosEdcBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

// Function : Call PosEdc Page list  
// Parameters : Doccument Ready and Event Button Parameter
// Creator :	30/08/2019 wasin
// Last Update : -
// Return : View
// Return Type : View
function JSvCallPagePosEdcList(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $('#oetPosEdcSearchAll').val('');
        $.ajax({
            type: "GET",
            url: "posEdcList",
            success: function(tResult){
                if (tResult != "") {
                    $('#odvPosEdcContentPage').html(tResult);
                    JSvCallPagePosEdcDataTable();
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

// Function : Call Pos Edc Data Table List
// Parameters : Ajax Success Event 
// Creator:	30/08/2019 Wasin(Yoshi)
// Last Update : -
// Return : View Data Table
// Return Type : View
function JSvCallPagePosEdcDataTable(pnPage){
    var tSearchAll      = $('#oetPosEdcSearchAll').val();
    var nPageCurrent    = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') { 
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "posEdcDataTable",
        data: {
            'ptSearchAll'   : tSearchAll,
            'pnPageCurrent' : nPageCurrent
        },
        success: function(tResult) {
            var aDataReturn = JSON.parse(tResult);
            if(aDataReturn['nStaEvent'] === 1){
                $('#ostPanelDataPosEdc').html(aDataReturn['tViewDataTableList']);
            }else{
                var tMessageError   = aDataReturn['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JSxPosEdcNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function : Call Pos Edc Page Add
// Parameters : Ajax Success Event 
// Creator:	02/09/2019 Wasin(Yoshi)
// Last Update : -
// Return : View Data Page Add
// Return Type : View
function JSvCallPagePosEdcAdd(){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('','');
    $.ajax({
        type: "POST",
        url: "posEdcPageAdd",
        success: function(tResult){
            var aReturnData = JSON.parse(tResult);
            if(aReturnData['nStaEvent'] == '1'){
                if(nStaPosEdcBrowseType == '1'){
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                    $('#odvModalBodyBrowse').html(aReturnData['tPosEdcViewPageForm']);
                }else{
                    $('#oliPosEdcTitleEdit').hide();
                    $('#odvPosEdcBtnGrpInfo').hide();
                    $('#oliPosEdcTitleAdd').show();
                    $('#odvPosEdcBtnGrpAddEdit').show();
                    $('#odvPosEdcContentPage').html(aReturnData['tPosEdcViewPageForm']);
                }
            }else{
                var tMessageError   = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : Call Pos Edc Page Edit  
// Parameters : -
// Creator : 26/06/2018 wasin
// Last Update : 15/01/2019 Wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCallPagePosEdcEdit(ptPosEdcCode){
    JCNxOpenLoading();
    JStCMMGetPanalLangSystemHTML('JSvCallPagePosEdcEdit',ptPosEdcCode);
    $.ajax({
        type: "POST",
        url: "posEdcPageEdit",
        data: {ptPosEdcCode : ptPosEdcCode},
        success: function(tResult) {
            var aReturnData = JSON.parse(tResult);
            if(aReturnData['nStaEvent'] == 1){
                $('#odvPosEdcBtnGrpInfo').hide();
                $('#oliPosEdcTitleAdd').hide();
                $('#oliPosEdcTitleEdit').show();
                $('#odvPosEdcBtnGrpAddEdit').show();
                $('#odvPosEdcContentPage').html(aReturnData['tPosEdcViewPageForm']);
            }else{
                var tMessageError   = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR,textStatus,errorThrown) {
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}

// Functionality : Add/Edit Pos EDC
// Parameters : Event Click Button
// Creator : 02/09/2018 wasin(Yoshi)
// Last Update : -
// Return : Status Add
// Return Type : none
function JSxAddEditPosEdc(){
    $('#ofmAddEditPosEdc').validate().destroy();
    $.validator.addMethod('dublicateCode',function(value,element){
        if($('#ohdPosEdcRouteData').val() == "posEdcEventAdd"){
            if($("ohdCheckDuplicatePosEdcCode").val() == 1){
                return false;
            }else{
                return true;
            }
        }else{
            return true;
        }
    },'');

    $('#ofmAddEditPosEdc').validate({
        rules: {
            oetPosEdcCode: {
                "required" : {
                    depends: function(oElement){
                        if($('#ohdPosEdcRouteData').val() == "posEdcEventAdd"){
                            if($('#ocbPosEdcAutoGenCode').is(':checked')){
                                return false;
                            }else{
                                return true;
                            }
                        }else{
                            return true;
                        }
                    }
                },
                "dublicateCode": {}
            },
            oetPosEdcName:     {"required" :{}},
        },
        messages: {
            oetPosEdcCode : {
                "required"      : $('#oetPosEdcCode').attr('data-validate-required'),
                "dublicateCode" : $('#oetPosEdcCode').attr('data-validate-dublicateCode')
            },
            oetPosEdcName : {
                "required"      : $('#oetPosEdcName').attr('data-validate-required')
            },
        },
        errorElement: "em",
        errorPlacement: function (error, element ) {
            error.addClass( "help-block" );
            if ( element.prop( "type" ) === "checkbox" ) {
                error.appendTo( element.parent( "label" ) );
            } else {
                var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0){
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function(element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
        },
        unhighlight: function(element, errorClass, validClass) {
            $( element ).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
        },
        submitHandler: function(form){
            if(!$('#ocbPosEdcAutoGenCode').is(':checked')){
                JSxPosEdcValidateDocCodeDublicate();
            }else{
                JSxPosEdcSubmitEventByButton();
            }
        }
    });
}

// Functionality : Function Check Code Pos Edc Duplicate In DB
// Parameters : Function AddEdit Role
// Creator : 02/09/2019 wasin(Yoshi)
// LastUpdate: -
// Return :  Check Data Role Code
// Return Type : None Return Value Use Event Control
function JSxPosEdcValidateDocCodeDublicate(){
    $.ajax({
        type: "POST",
        url: "CheckInputGenCode",
        data: {
            'tTableName'    : 'TFNMEdc',
            'tFieldName'    : 'FTEdcCode',
            'tCode'         : $('#oetPosEdcCode').val()
        },
        success: function (tResult){
            var aResultData = JSON.parse(tResult);
            $("#ohdCheckDuplicatePosEdcCode").val(aResultData["rtCode"]);
            $('#ofmAddEditPosEdc').validate().destroy();
            $.validator.addMethod('dublicateCode', function(value,element){
                if($("#ohdPosEdcRouteData").val() == "posEdcEventAdd"){
                    if($('#ocbPosEdcAutoGenCode').is(':checked')) {
                        return true;
                    }else{
                        if($("#ohdCheckDuplicatePosEdcCode").val() == 1) {
                            return false;
                        }else{
                            return true;
                        }
                    }
                }else{
                    return true;
                }
            });

            // Set Form Validate From Add 
            $('#ofmAddEditPosEdc').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetPosEdcCode : {"dublicateCode": {}}
                },
                messages: {
                    oetPosEdcCode : {"dublicateCode"  : $('#oetPosEdcCode').attr('data-validate-dublicatecode')}
                },
                errorElement: "em",
                errorPlacement: function (error, element) {
                    error.addClass("help-block");
                    if(element.prop("type") === "checkbox") {
                        error.appendTo(element.parent("label"));
                    }else{
                        var tCheck = $(element.closest('.form-group')).find('.help-block').length;
                        if (tCheck == 0) {
                            error.appendTo(element.closest('.form-group')).trigger('change');
                        }
                    }
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass("has-error");
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).closest('.form-group').removeClass("has-error");
                },
                submitHandler: function (form) {
                    JSxPosEdcSubmitEventByButton();
                }
            });
            $("#ofmAddEditPosEdc").submit();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        },
    });
}

// Functionality : Function Check Code Pos Edc Duplicate In DB
// Parameters : Function AddEdit Role
// Creator : 02/09/2018 wasin(Yoshi)
// LastUpdate: -
// Return :  Check Data Pos Edc Code
// Return Type : None Return Value Use Event Control
function JSxPosEdcSubmitEventByButton(){
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: $('#ohdPosEdcRouteData').val(),
        data: $('#ofmAddEditPosEdc').serialize(),
        success: function (tResult){
            if(nStaPosEdcBrowseType != 1) {
                let aDataReturn = JSON.parse(tResult);
                if(aDataReturn['nStaEvent'] == '1'){
                    var nPosEdcStaCallBack  = aDataReturn['nStaCallBack'];
                    var tPosEdcCodeReturn   = aDataReturn['tCodeReturn'];
                    switch(nPosEdcStaCallBack){
                        case 1 :
                            JSvCallPagePosEdcEdit(tPosEdcCodeReturn);
                        break;
                        case 2 :
                            JSvCallPagePosEdcAdd();
                        break;
                        case 3 :
                            JSvCallPagePosEdcList();
                        break;
                        default :
                            JSvCallPagePosEdcEdit(tPosEdcCodeReturn);
                    }
                }else{
                    var tMsgErrorFunction   = aDataReturn['tStaMessg'];
                    FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                }
            }else{
                JCNxCloseLoading();
                JCNxBrowseData(tCallPosEdcBackOption);
            }
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Functionality : (event) Delete Single
// Parameters : Evnet Click Image Delete In Table List
// Creator : 03/09/2019 wasin(Yoshi)
// LastUpdate: -
// Return : Status Event Delete
// Return Type : object
function JSoPosEdcDeleteSingle(paDataDelete){
    let tPosEdcCode     = paDataDelete.tPosEdcCode;
    let tPosEdcName     = paDataDelete.tPosEdcName;
    let nPageCurrent    = paDataDelete.nPosEdcPageCurrent;
    if(typeof(tPosEdcCode) != undefined && tPosEdcCode != ""){
        var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+tPosEdcCode+" ( "+tPosEdcName+" )"+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
        $('#odvModalDeletePosEdcSingle #ospTextConfirmDelete').html(tTextConfrimDelSingle);
        $('#odvModalDeletePosEdcSingle').modal('show');
        $('#odvModalDeletePosEdcSingle #osmConfirmDelete').unbind().click(function(){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "posEdcEventDelete",
                data: {'ptDataCode' : tPosEdcCode},
                success: function(tResult){
                    var aReturnData = JSON.parse(tResult);
                    if(aReturnData['nStaEvent'] == '1'){
                        $('#odvModalDeletePosEdcSingle').modal('hide');
                        $('#odvModalDeletePosEdcSingle #ospTextConfirmDelete').html($('#oetTextComfirmDeleteSingle').val());
                        $('.modal-backdrop').remove();
                        setTimeout(function () {
                            if(aReturnData["nNumRowPosEdc"] != 0){
                                if(aReturnData["nNumRowPosEdc"] > 10){
                                    nNumPage = Math.ceil(aReturnData["nNumRowPosEdc"]/10);
                                    if(nPageCurrent <= nNumPage){
                                        JSvCallPagePosEdcDataTable(nPageCurrent);
                                    }else{
                                        JSvCallPagePosEdcDataTable(nNumPage);
                                    }
                                }else{
                                    JSvCallPagePosEdcDataTable(1);
                                }
                            }else{
                                JSvCallPagePosEdcDataTable(1);
                            }
                        }, 500);
                    }else{
                        JCNxCloseLoading();
                        FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }else{
        FSvCMNSetMsgErrorDialog('Error Not Found PosEdc Code !!');
    }
}

// Function: (event) Delete Multiple
// Parameters: Function Call Page
// Creator : 03/09/2019 wasin(Yoshi)
// LastUpdate: -
// Return: object Data Sta Delete
// ReturnType: object
function JSoPosEdcDelDocMultiple(){
    var aDataDelMultiple    = $('#odvModalDeletePosEdcMulti #ohdConfirmIDDelete').val();
    var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    var aDataSplit          = aTextsDelMultiple.split(" , ");
    var nDataSplitlength    = aDataSplit.length;
    var aNewIdDelete        = [];
    for ($i = 0; $i < nDataSplitlength; $i++) {
        aNewIdDelete.push(aDataSplit[$i]);
    }
    if(nDataSplitlength > 1) {
        JCNxOpenLoading();
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url: "posEdcEventDelete",
            data: {'ptDataCode' : aNewIdDelete},
            success: function (tResult) {
                var aReturnData = JSON.parse(tResult);
                if(aReturnData['nStaEvent'] == '1') {
                    setTimeout(function () {
                        $('#odvModalDeletePosEdcMulti').modal('hide');
                        $('#odvModalDeletePosEdcMulti #ospTextConfirmDelete').empty();
                        $('#odvModalDeletePosEdcMulti #ohdConfirmIDDelete').val('');
                        $('.modal-backdrop').remove();
                        localStorage.removeItem('LocalItemData');
                        JSvCallPagePosEdcList();
                    }, 1000);
                }else{
                    JCNxCloseLoading();
                    FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 30/03/2020 saharat(Golf)
//Return : View
//Return Type : View
function JSvPosEdcClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePosEdc .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePosEdc .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }

    JSvCallPagePosEdcDataTable(nPageCurrent);
}
