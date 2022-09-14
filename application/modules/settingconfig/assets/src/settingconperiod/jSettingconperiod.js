var nStaLimBrowseType = $('#oetLimStaBrowse').val();
var tCallLimBackOption = $('#oetLimCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxLimNavDefult();
    if (nStaLimBrowseType != '1') {
        JSvCallPageSetConperiodList();
    } else {
        JSvCallPageSetConperiodAdd();
    }

    $('.xCNHideBtnStaAlw').hide();

});


//function : Function Clear Defult Button Card
//Parameters : Document Ready
//Creator : 07/10/2020 Witsarut (Bell)
//Return : Show Tab Menu
//Return Type : -
function JSxLimNavDefult(){
    if (nStaLimBrowseType != 1 || nStaLimBrowseType == undefined) {
        $('.xCNChoose').hide();
        $('#oliLimTitleAdd').hide();
        $('#oliLimTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnLimInfo').show();
    }else{
        $('#odvModalBody #odvLimMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliLimNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvLimBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNLimBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNLimBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Page SettingConditionPeriod list  
//Parameters : Document Redy And Event Button
//Creator : 07/10/2020 Witsarut (Bell)
//Return : View
//Return Type : View
function JSvCallPageSetConperiodList(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'unundefineddefined' && nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageSetConperiodList';
        JCNxOpenLoading();
        $.ajax({
            type : "POST",
            url: "settingconperiodList",
            cache : false,
            data: {
                nPageCurrent: pnPage,
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageLim').html(tResult);
                JSvSetConperiodDataTable(pnPage);
            },
             error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call SettingConperiod Data List
//Parameters: Ajax Success Event 
//Creator:	07/10/2020 Witsarut (Bell)
//Return: View
//Return Type: View
function JSvSetConperiodDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var tSearchAll = $('#oetSearchSettingConperiod').val();
  
        var nPageCurrent = (pnPage === undefined || pnPage == '') ? '1' : pnPage;

        $.ajax({
            type: "POST",
            url : "settingconperiodDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataSettingConperiod').html(tResult);
                }
                JSxLimNavDefult();
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

//Functionality : Call Page Card Add  
//Parameters : Event Button Click
//Creator :  08-10-2020 Witsarut(Bell)
//Return : View
//Return Type : View
function JSvCallPageSetConperiodAdd(){
    $('.xCNHideBtnStaAlw').hide();
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type : "POST",
            url: "settingconperiodPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(nStaLimBrowseType == 1){
                    $('#odvModalBodyBrowse').html(tResult);
                    $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                }else{
                    $('.xCNLimVBrowse').hide();
                    $('.xCNLimVMaster').show();
                    $('#oliLimTitleEdit').hide();
                    $('#oliLimTitleAdd').show();
                    $('#odvBtnLimInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageLim').html(tResult);
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

//Functionality : Event Add/Edit SettingConditionperiod
//Parameters : From Submit
//Creator : 08-10-2020 Witsarut(Bell)
//Return : Status Event Add/Edit Card
//Return Type : object
function JSoAddEditSettingConperiod(ptRoute){
   
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        if( $('#otbLimDataListPageAdd tbody tr').length > 0 && $('#otbLimDataListPageAdd tbody tr td').hasClass('xCNEmptyData') != true ){
            $('#ofmAddSetingConperiod').validate().destroy();
            $('#ofmAddSetingConperiod').validate({
                focusInvalid: false,
                onclick: false,
                onfocusout: false,
                onkeyup: false,
                rules: {
                    oetLhdName:  {"required" :{}},
                    oetGrpRolName:  {"required" :{}},
                },
                messages: {
                    oetLhdName : {
                        "required"      : $('#oetLhdName').attr('data-validate-required'),
                    },
                    oetGrpRolName : {
                        "required"      : $('#oetGrpRolName').attr('data-validate-required'),
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
                    $(element).closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
                },
                unhighlight: function(element, errorClass, validClass) {
                    $(element).closest('.form-group').addClass( "has-success" ).removeClass( "has-error" );
                },
                submitHandler: function(form){
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data: $('#ofmAddSetingConperiod').serialize(),
                        success: function(tResult){
                            var aData = JSON.parse(tResult);
                            var tChkStaWarm  = $('.xCNHideChkStaWarm').last().val();
                            if(tChkStaWarm == 2){
                                $('.xCNHideStaWarm').hide();
                            }else{
                                $('.xCNHideStaWarm').show();
                            }

                            if(aData["nStaEvent"]==1){
                                switch(aData['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageLimEdit(aData['tReturnLhdCode'],aData['tReturnRolCode']);
                                    break;
                                    case '2':
                                        JSvCallPageSetConperiodAdd();
                                    break;
                                    case '3':
                                        JSvCallPageSetConperiodList(1);
                                    break;
                                    default :
                                    JSvCallPageLimEdit(aData['tReturnLhdCode'],aData['tReturnRolCode']);

                                }
                            }
                            JCNxCloseLoading();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }else{
            alert('ไม่สามารถเพิ่มข้อมูลได้ กรุณาเพิ่มข้อมูล');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}


// function Edit
// witsarut 12-10-2020
function JSoAddEditSettingConperiodEdit(ptRouteEdit){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        console.log( $('#otbLimDataListPageAdd tbody tr').length );
        if( $('#otbLimDataListPageAdd tbody tr').length > 0 ){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: ptRouteEdit,
                data: $('#ofmAddSetingConperiodEdit').serialize(),
                success: function(tResult){
                    var aData = JSON.parse(tResult);

                    var tChkStaWarm  = $('.xCNHideChkStaWarm').last().val();

                    if(tChkStaWarm == 2){
                        $('.xCNHideStaWarm').hide();
                    }else{
                        $('.xCNHideStaWarm').show();
                    }
                    
                    if(aData["nStaEvent"]==1){
                        switch(aData['nStaCallBack']) {
                            case '2':
                                JSvCallPageSetConperiodAdd();
                            break;
                            case '3':
                                JSvCallPageSetConperiodList(1);
                            break;
                        }
                    }
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            alert('ไม่สามารถเพิ่มข้อมูลได้ กรุณาเพิ่มข้อมูล');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality: (event) Delete
//Parameters: Button Event [tIDCode tUsrCode]
//Creator: 12/09/2019 Witsarut (Bell)
//Update: -
//Return: Event Delete Reason List
//Return Type: -
function JSoLimDel(pnPage,ptLhdCode,ptRolCode,ptLhdName,tYesOnNo){
    $('#odvModalDeleteSingle').modal('show');
    $('#odvModalDeleteSingle #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptLhdCode + ' (' + ptLhdName  + ') ' + tYesOnNo );
    $('#odvModalDeleteSingle #osmConfirmDelete').on('click', function(evt) {
        $.ajax({
            type: "POST",
            url: "settingconperiodEventDelete",
            data : {
                ptLhdCode : ptLhdCode,
                ptRolCode : ptRolCode
            },
            cache: false,
            success: function(tResult){
                tResult = tResult.trim();
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDeleteSingle').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowLimLoc"]!=0){
                            if(aReturn["nNumRowLimLoc"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowLimLoc"]/10);
                                if(pnPage<=nNumPage){
                                    JSvSetConperiodDataTable(pnPage);
                                }else{
                                    JSvSetConperiodDataTable(nNumPage);
                                }
                            }else{
                                JSvSetConperiodDataTable(1);
                            }
                        }else{
                            JSvSetConperiodDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);    
                }
                JSxLimNavDefult();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    });
}

//Functionality : (event) Delete All
//Parameters :
//Creator : 11/06/2019 Witsarut (Bell)
//Return : 
//Return Type :
function JSoLimDelChoose(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        var aDataLhdCode = [];
        var aDataRolCode = [];
        var ocbListItem     = $(".ocbListItem");
        for(var nI = 0;nI<ocbListItem.length;nI++){
            if($($(".ocbListItem").eq(nI)).prop('checked')){
                aDataLhdCode.push($($(".ocbListItem").eq(nI)).attr("ohdLhdCode"));
                aDataRolCode.push($($(".ocbListItem").eq(nI)).attr("ohdRolCode"));
            }
        }
        
        $.ajax({
            type : "POST",
            url: "settingconperiodEventDeleteMultiple",
            data: {
                paDataLhdCode : aDataLhdCode,
                paDataRolCode : aDataRolCode
            },
            cache: false,
            timeout:0,
            success: function (tResult){
                tResult = tResult.trim();
                var aReturn = JSON.parse(tResult);
                if(aReturn['nStaEvent'] == '1'){
                    $('#odvModalDeleteMutirecord').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $(".modal-backdrop").remove();
                    setTimeout(function() {
                        if(aReturn["nNumRowLimLoc"]!=0){
                            if(aReturn["nNumRowLimLoc"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowLimLoc"]/10);
                                if(pnPage<=nNumPage){
                                    JSvSetConperiodDataTable(pnPage);
                                }else{
                                    JSvSetConperiodDataTable(nNumPage);
                                }
                            }else{
                                JSvSetConperiodDataTable(1);
                            }
                        }else{
                            JSvSetConperiodDataTable(1);
                        }
                    }, 500);

                }else{
                    alert(aReturn['tStaMessg']);
                }
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

//Functionality : Call Page SettingConditionPeriod Edit  
//Parameters : Event Button Click 
//Creator : 11/10/2018 wasin
//Return : View
//Return Type : View
function JSvCallPageLimEdit(ptLhdCode,ptRolCode,ptSeq){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "settingconperiodPageEdit",
            data:{
                tLhdCode : ptLhdCode,
                tRolCode :ptRolCode,
                tSeq : ptSeq
            },
            cache:false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    $('#oliLimTitleAdd').hide();
                    $('#oliLimTitleEdit').show();
                    $('#odvBtnLimInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageLim').html(tResult);
                }
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

// function ClickPage
function JSvLimClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageSettingCoperiod .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageSettingCoperiod .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCallPageSetConperiodList(nPageCurrent);

}

//เพิ่มข้อมูล
function JSvCallCheckRolAndLimit(){

    $('#otbLimDataListPageAdd').find('.xCNEmptyData').remove();

    // ลบ Seq ถังขยะตัวสุดท้ายเสมอ
    // $('#otbLimDataListPageAdd').find('tr:last td:eq(5)').find('.xCNIconTable').addClass('xCNDocDisabled').prop("onclick", null).off("click");
    $('#otbLimDataListPageAdd').find('.xCNIconTable').addClass('xCNDocDisabled');
    

    var tImgPath  = $('#ohdBaseURL').val()+'/application/modules/common/assets/images/icons/delete.png';
    var tSeqRec   = $('#otbLimDataListPageAdd').find('tr:last td:first').text();
    var nDefault = '0.00';
    if( tSeqRec == "" ){
        tSeqRec  = 1;
    }else{
        tSeqRec = parseInt(tSeqRec) + parseInt(1);
    }

    if($('#oetChkStaAlwMinMax').val() == 1 || $('#oetChkStaAlwMinMax').val() == 2){
        $('#otbLimDataListPageAdd').find('.xCNIconTable').addClass('xCNDocDisabled');

        var tImgPath  = $('#ohdBaseURL').val()+'/application/modules/common/assets/images/icons/delete.png';
        var tSeqRec   = $('#otbLimDataListPageAdd').find('tr:last td:first').text();
        var nDefault = '0.00';
        if( tSeqRec == "" ){
            tSeqRec  = 1;
        }else{
            tSeqRec = parseInt(tSeqRec) + parseInt(1);
        }
        
        var tReplaceComma = $('#otbLimDataListPageAdd').find('tr:last td:eq(1)').find('input').val();
    }else{
        var tReplaceComma = $('#otbLimDataListPageAdd').find('tr:last td:eq(2)').find('input').val();
    }

 

    var tNewReplaceComma = 0.00;
    if( tReplaceComma != undefined ){
        tNewReplaceComma  = tReplaceComma.replace(/,/g, '');
    }

    var tValueMax = parseFloat(tNewReplaceComma) + parseFloat(0.01);

    nValNuformatmber = parseFloat(tValueMax).toFixed(2)
    var nValNuformatmber = Number(tValueMax).toLocaleString('en');
    var thtml  = '<tr data-default="'+nValNuformatmber+'" data-defaultMax="'+nValNuformatmber+'" data-seqnumber="'+tSeqRec+'">';
        thtml  += '<td width="3%" style="height:38px;" class="text-center">'+tSeqRec+'</td>';   
        if($('#oetChkStaAlwMinMax').val() == 1){
            thtml  += '<td width="15%"><input style="height:38px; text-align:right;" class="xCNEditInLine" data-desc="min" type="text" name="oetMinValue[]" value='+nDefault+'></td>';        
        }else if($('#oetChkStaAlwMinMax').val() == 2){
            thtml  += '<td width="15%"><input style="height:38px; text-align:right;" class="xCNEditInLine" data-desc="max" type="text" name="oetMaxValue[]" value='+nValNuformatmber+'></td>';        
        }else{
            thtml  += '<td width="15%"><input style="height:38px; text-align:right;" class="xCNEditInLine" data-desc="min" type="text" name="oetMinValue[]" value='+nDefault+'></td>';
            thtml  += '<td width="15%"><input style="height:38px; text-align:right;" class="xCNEditInLine" data-desc="max" type="text" name="oetMaxValue[]" value='+nValNuformatmber+'></td>';    
        }
        thtml  += '<td width="15%" class="text-center" valign="bottom">';
        thtml  += '<select class="selectpicker form-control xCNHideChkStaWarm" name="ocmLimStaWarn[]" maxlength="1">';
        thtml  += '<option value="1">เตือนทำงานต่อได้</option>';
        thtml  += '<option value="2">เตือนไม่อนุญาตให้ทำงานต่อ</option>';
        thtml  += '</select>';
        thtml  += '</td>';        
        thtml  += '<td width="20%"><input style="height:38px;" type="text" name="oetSpcValue[]"></td>';        
        thtml  += '<td width="5%" class="text-center">';
        thtml  += '<img class="xCNIconTable xCNIconDel" src='+tImgPath+' onClick="JSoLimDelChkRole(this)">'; 
        thtml  += '</td>';
        thtml  +='</tr>';

    $("#otbLimDataListPageAdd tbody").append(thtml);
    $('.selectpicker').selectpicker();
    JSxCallEditInline();
}

// functon Delete checkRols
// Create Witsarut 09-10-2020
function JSoLimDelChkRole(elem){
    var tCheckClassDelete = $(elem).hasClass('xCNDocDisabled');
    if(tCheckClassDelete == false){
        $(elem).closest("tr").remove();
    }

    if($('#oetChkStaAlwMinMax').val() == 1 || $('#oetChkStaAlwMinMax').val() == 2){

        $('#otbLimDataListPageAdd').find('tr:last td:eq(4)').find('.xCNIconTable').removeClass('xCNDocDisabled');
    }else{
        $('#otbLimDataListPageAdd').find('tr:last td:eq(5)').find('.xCNIconTable').removeClass('xCNDocDisabled');
    }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 08/10/2020 Witsarut
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDelete').val(tTextCode);
    }
}


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator:  08/10/2020 Witsarut
//Return: Duplicate/none
//Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 08/10/2020 Witsarut
//Return: - 
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {
        $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $('#odvMngTableList #oliBtnDeleteAll').removeClass('disabled');
        } else {
            $('#odvMngTableList #oliBtnDeleteAll').addClass('disabled');
        }
    }
}

