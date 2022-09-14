var nStaSpaBrowseType   = $('#oetSpaStaBrowse').val();
var tCallSpaBackOption  = $('#oetSpaCallBackOption').val();

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxSpaNavDefult();
    if(nStaSpaBrowseType != 1){
        JSvCallPageSpaList();
    }else{
        JSvCallPageSpaAdd();
    }
});

//function : Function Clear Defult Button Product Size
//Parameters : Document Ready
//Creator : 17/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxSpaNavDefult(){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        if(nStaSpaBrowseType != 1 || nStaSpaBrowseType == undefined){
            $('.xCNSpaVBrowse').hide();
            $('.xCNSpaVMaster').show();
            $('.xCNChoose').hide();
            $('#oliSpaTitleAdd').hide();
            $('#oliSpaTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('#odvBtnSpaInfo').show();
            $('#obtBtnSpaApv').hide();
        }else{
            $('#odvModalBody .xCNSpaVMaster').hide();
            $('#odvModalBody .xCNSpaVBrowse').show();
            $('#odvModalBody #odvSpaMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliSpaNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvSpaBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNSpaBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNSpaBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 17/10/2018 witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR,textStatus,errorThrown){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    
        JCNxCloseLoading();
        var tHtmlError = $(jqXHR.responseText);
        var tMsgError = "<h3 style='font-size:20px;color:red'>";
        tMsgError += "<i class='fa fa-exclamation-triangle'></i>";
        tMsgError += " Error<hr></h3>";
        switch (jqXHR.status) {
            case 404:
                tMsgError += tHtmlError.find('p:nth-child(2)').text();
                break;
            case 500:
                tMsgError += tHtmlError.find('p:nth-child(3)').text();
                break;

            default:
                tMsgError += 'something had error. please contact admin';
                break;
        }
        $("body").append(tModal);
        $('#modal-customs').attr("style", 'width: 450px; margin: 1.75rem auto;top:20%;');
        $('#myModal').modal({ show: true });
        $('#odvModalBody').html(tMsgError);

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//function : Call Product Size Page list  
//Parameters : Document Redy And Event Button
//Creator :	17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSpaList(){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        localStorage.tStaPageNow = 'JSvCallPageSpaList';
        $('#oetSearchSpa').val('');
        JCNxOpenLoading();    
        $.ajax({
            type: "POST",
            url: "dcmSPAMain",
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvContentPageSpa').html(tResult);
                JSvSpaDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Sale Price Adj Data List
//Parameters: Ajax Success Event 
//Creator:	15/02/2019 Napat(Jame)
//Return: View
//Return Type: View
function JSvSpaDataTable(pnPage){
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        let oAdvanceSearchData = {
            tSearchAll : $('#oetSearchSpa').val(),
            tSearchBchCodeFrom : $('#oetBchCodeFrom').val(),
            tSearchBchCodeTo : $('#oetBchCodeTo').val(),
            tSearchDocDateFrom : $('#oetSearchDocDateFrom').val(),
            tSearchDocDateTo : $('#oetSearchDocDateTo').val(),
            tSearchStaDoc : $('#ocmStaDoc').val(),
            tSearchStaApprove : $('#ocmStaApprove').val(),
            tSearchStaAct : $('#ocmStaDocAct').val(),
            tSearchStaPrcStk : $('#ocmStaPrcStk').val(),
            tSearchUsedStatus : $('#ocmUsedStatus').val()
        };

        $.ajax({
            type: "POST",
            url: "dcmSPADataTable",
            data: {
                oAdvanceSearchData   : oAdvanceSearchData,
                nPageCurrent         : nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#ostDataSpa').html(tResult);
                }
                JSxSpaNavDefult();
                JCNxLayoutControll();
                // JStCMMGetPanalLangHTML('TCNMPdtSize_L'); //โหลดภาษาใหม่
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

//function: Call Product Price Data List
//Parameters: Ajax Success Event 
//Creator:	18/02/2019 Napat(Jame)
//Return: View
//Return Type: View
// ptFocusType = 1 focus input , 2 focus scaner
function JSvSpaPdtPriDataTable(pnPage,ptFocusType){
    
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tSearchAll = $('#oetSearchSpaPdtPri').val();
        var FTXphDocNo = $('#oetXphDocNo').val();
        // var nPageCurrent = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        var tFocusType = (ptFocusType === undefined || ptFocusType == '')? '1' : ptFocusType;

        if($('#ofmAddSpa tr.otrSpaPdtPri').length == 0){
            // alert('JSvSpaPdtPriDataTable length = 0: ' + $('#ofmAddSpa tr.otrSpaPdtPri').length);
            if(pnPage != undefined){
                pnPage = pnPage-1;
                // alert('JSvSpaPdtPriDataTable pnPage != undefined: ' + $('#ofmAddSpa tr.otrSpaPdtPri').length);
            }
        // }else{
        //     alert('JSvSpaPdtPriDataTable length != 0: ' + $('#ofmAddSpa tr.otrSpaPdtPri').length);
        }

        nPageCurrent = (pnPage === undefined || pnPage == '' || pnPage <= 0)? '1' : pnPage;

        // alert('JSvSpaPdtPriDataTable nPageCurrent: ' + nPageCurrent);

        $.ajax({
            type: "POST",
            url: "dcmSPAPdtPriDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent,
                FTXphDocNo: FTXphDocNo,
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                $('#ostDataPdtPri').html(tResult);
                let oParameterSend = {
                    "FunctionName"                  : "JSxSpaSaveInLine",
                    "DataAttribute"                 : ["dataSEQ","dataPRICE","dataPAGE"],
                    "TableID"                       : "otbSpaDataList",
                    "NotFoundDataRowClass"          : "xWTextNotfoundDataSalePriceAdj",
                    "EditInLineButtonDeleteClass"   : "xWDeleteBtnEditButton",
                    "LabelShowDataClass"            : "xWShowInLine",
                    "DivHiddenDataEditClass"        : "xWEditInLine"
                };
                // JCNxSetNewEditInline(oParameterSend);
                if( tFocusType == '1' ){
                    $(".xWEditInlineElement").eq(nIndexInputEditInline).focus(function() {
                        this.select();
                    });
                    setTimeout(function() {
                        $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
                    }, 300);
                }
                $(".xWEditInlineElement").removeAttr("disabled");
                let oElement = $(".xWEditInlineElement");
                for (let nI = 0; nI < oElement.length; nI++) {
                    $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
                }
                
                $(".xWEditInlineElement").css({
                    "padding"       : "0px", 
                    "text-align"    : "right"
                });

                // var oParameterEditInLine    = {
                //     "DocModules"                    : "",
                //     "FunctionName"                  : "JSxPISaveEditInline",
                //     "DataAttribute"                 : ['data-field', 'data-seq'],
                //     "TableID"                       : "otbPIDocPdtAdvTableList",
                //     "NotFoundDataRowClass"          : "xWPITextNotfoundDataPdtTable",
                //     "EditInLineButtonDeleteClass"   : "xWPIDeleteBtnEditButtonPdt",
                //     "LabelShowDataClass"            : "xWShowInLine",
                //     "DivHiddenDataEditClass"        : "xWEditInLine"
                // }
                // JCNxSetNewEditInline(oParameterSend);
                // $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
                // $(".xWEditInlineElement").eq(nIndexInputEditInline).select();
                // $(".xWEditInlineElement").removeAttr("disabled");

                // let oElement = $(".xWEditInlineElement");
                // for(let nI=0;nI<oElement.length;nI++){
                //     $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
                // }

               var tSPAFitstPdtCode = $('#oetSPAFitstPdtCode').val();
               if(tSPAFitstPdtCode!=''){
                var tAttrIdPdtCodeFirst =  $('#ohdSPAFrtPdtCode'+tSPAFitstPdtCode).val();
                if($('#'+tAttrIdPdtCodeFirst).val()!='' && $('#'+tAttrIdPdtCodeFirst).val()!=undefined){
          
                    var tValueNext     = parseFloat($('#'+tAttrIdPdtCodeFirst).val().replace(/,/g, ''));
                    $('#'+tAttrIdPdtCodeFirst).val(tValueNext);
                    if( tFocusType == '1' ){
                        $('#'+tAttrIdPdtCodeFirst).focus();
                        $('#'+tAttrIdPdtCodeFirst).select();
                    }
                }
               }

                // JSxSpaNavDefult();
                JCNxLayoutControll();
                // JStCMMGetPanalLangHTML('TCNMPdtSize_L'); //โหลดภาษาใหม่
                JSxDisableInput();
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

//Functionality : Call Product Size Page Add  
//Parameters : Event Button Click
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSpaAdd(){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "dcmSPAPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult){
                if (nStaSpaBrowseType == 1) {
                    $('.xCNSpaVMaster').hide();
                    $('.xCNSpaVBrowse').show();
                }else{
                    $('.xCNSpaVBrowse').hide();
                    $('.xCNSpaVMaster').show();
                    $('#oliSpaTitleEdit').hide();
                    $('#oliSpaTitleAdd').show();
                    $('#odvBtnSpaInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#obtBtnSpaApv').hide();
                    $('#obtBtnSpaCancel').hide();
                    $("#obtBtnPrint").hide();
                    // $('#obtSubmit').attr('disabled',false);
                    // $('.xWBtnGrpSaveRight').attr('disabled',false);

                    // ====== Create by Witsarut 28/08/2019 ========
                    $('#obtSubmit').show();
                    $('.xWBtnGrpSaveRight').show();
                    // ====== Create by Witsarut 28/08/2019 ========
                }
                $('#odvContentPageSpa').html(tResult);
                JSxSPACheckAutoGenerate();
                JSvSpaPdtPriDataTable();
                JCNxLayoutControll();

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality : Call Product Size Page Edit  
//Parameters : Event Button Click 
//Creator : 17/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPageSpaEdit(ptXphDocNo){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageSpaEdit',ptXphDocNo);
        $.ajax({
            type: "POST",
            url: "dcmSPAPageEdit",
            data: { tXphDocNo: ptXphDocNo },
            cache: false,
            timeout: 0,
            success: function(tResult){
                if(tResult != ''){
                    // $('#obtBtnSpaApv').show();
                    // $('#obtBtnSpaCancel').show();
                    $('#oliSpaTitleAdd').hide();
                    $('#oliSpaTitleEdit').show();
                    $('#odvBtnSpaInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageSpa').html(tResult);
                   
                    $('#oetXphDocNo').addClass('xCNDisable');
                    $('#oetXphDocNo').attr('readonly', true);
                    $('.xCNBtnGenCode').attr('disabled', true);
                    $('#obtBtnSpaApv').hide();
                    $("#obtBtnPrint").hide();
                    $('#obtBtnSpaCancel').hide();
                    //  ====== Create By Witsarut 28/08/2019 ========
                    $('#obtSubmit').hide();
                    $('.xWBtnGrpSaveRight').hide();
                     //  ====== Create By Witsarut 28/08/2019 ========
                    $('.xWAutoGenerate').hide();
 
                    JCNxOpenLoading();
                    JSvSpaPdtPriDataTable();
                }
                JCNxLayoutControll();

                $("html, body").animate({scrollTop: 0}, 1000);
                // JCNxCloseLoading();

                // ============= Create by Witsarut 27/08/2019 =================

                var tUsrApv = $('#oetStaApv').val();
                var tStaDoc = $('#oetStaDoc').val();
                
                if(tUsrApv != "" || tStaDoc == '1'){
                    $('#obtBtnPrint').show();
                    $('#obtBtnSpaApv').show();
                    $('#obtBtnSpaCancel').show();
                    $('#obtSubmit').show();
                    $('.xWBtnGrpSaveRight').show();
                }else{
                    if(tStaDoc == '3'){
                        $('#obtBtnPrint').hide();
                    }
                }
                // ============= Create by Witsarut 27/08/2019 =================
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality : Event Add/Edit Sale Price Adj
//Parameters : From Submit
//Creator : 21/02/2019 Napat(Jame)
//Return : Status Event Add/Edit
//Return Type : object
function JSoAddEditSpa(ptRoute){

    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        // console.log($('#ofmAddSpa').serializeArray());
        var nRowlength = $('#ofmAddSpa tr.otrSpaPdtPri').length;
        var StartDate = $('#oetXphDStart').val();
        var StopDate = $('#oetXphDStop').val();

        if(nRowlength==0){
            FSvCMNSetMsgWarningDialog($('#ohdTextValidate').attr('validatepdrcode'));
            return ;
        }
        if(StopDate < StartDate){
            $('#oetXphDStop').focus();
            $('#oetXphDStop').closest('.form-group').addClass( "has-error" ).removeClass( "has-success" );
            FSvCMNSetMsgWarningDialog($('#ohdTextValidate').attr('validatedateimpact'));
        }else{
            $('#ofmAddSpa').validate({
                rules: {
                    oetXphDocNo         : {
                        "required": {
                            depends: function (oElement) {
                                if(ptRoute == "dcmSPAEventAdd") {
                                    if($('#ocbStaAutoGenCode').is(':checked')){
                                        return false;
                                    }else{
                                        return true;
                                    }
                                } else {
                                    return false;
                                }
                            }
                        }
                    },
                    ocmXphDocType   : "required",
                    ocmXphStaAdj    : "required",
                    ocmXphPriType   : "required",
                    oetXphDocDate   : "required",
                    oetXphDocTime   : "required",
                    oetXphDStart    : "required",
                    oetXphDStop     : "required",
                    oetXphTStart    : "required",
                    oetXphTStop     : "required",

                },
                messages: {
                    oetXphDocNo     : $('#oetXphDocNo').data('validate'),
                    ocmXphDocType   : $('#ocmXphDocType').data('validate'),
                    ocmXphStaAdj    : $('#ocmXphStaAdj').data('validate'),
                    ocmXphPriType   : $('#ocmXphPriType').data('validate'),
                    oetXphDocDate   : $('#oetXphDocDate').data('validate'),
                    oetXphDocTime   : $('#oetXphDocTime').data('validate'),
                    oetXphDStart    : $('#oetXphDStart').data('validate'),
                    oetXphDStop     : $('#oetXphDStop').data('validate'),
                    oetXphTStart    : $('#oetXphTStart').data('validate'),
                    oetXphTStop     : $('#oetXphTStop').data('validate'),
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
                    JCNxOpenLoading();
                    // console.log('Add Data Sale Price Adj to HD');
                    // console.log($('#ofmAddSpa').serialize());
                    if(nRowlength > 0){
                        $oForm = $('#ofmAddSpa').serialize() + '&nStaAction=' + '1';
                    }else if(nRowlength == 0){
                        $oForm = $('#ofmAddSpa').serialize() + '&nStaAction=' + '0';
                    }

                    $.ajax({
                        type: "POST",
                        url: ptRoute,
                        data: $oForm,
                        success: function(oResult){

                            var aReturn = JSON.parse(oResult);
                            // console.log(aReturn);

                            if(nStaSpaBrowseType != 1) {
                                if(aReturn['nStaEvent'] == 1){
                                    switch(aReturn['nStaCallBack']) {
                                        case '1':
                                            JSvCallPageSpaEdit(aReturn['tCodeReturn']);
                                            break;
                                        case '2':
                                            JSvCallPageSpaAdd();
                                            break;
                                        case '3':
                                            JSvCallPageSpaList();
                                            break;
                                        default:
                                            JSvCallPageSpaEdit(aReturn['tCodeReturn']);
                                    }
                                }else{
                                    FSvCMNSetMsgErrorDialog(aReturn['tStaMessg']);
                                    JCNxCloseLoading();
                                }
                            }else{
                                JCNxCloseLoading();
                                JCNxBrowseData(tCallSpaBackOption);
                            }

                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                },
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
    
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 18/02/2019 Napat(Jame)
//Return : object Status Delete
//Return Type : object
function JSoSpaDel(pnPage,ptXphDocNo){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];

        if (aDataSplitlength == '1') {

            $('#odvModalDelSpa').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + ptXphDocNo + ' ' + $('#oetTextComfirmDeleteYesOrNot').val());
            $('#osmConfirm').on('click', function(evt) {

                if (localStorage.StaDeleteArray != '1') {

                    $.ajax({
                        type: "POST",
                        url: "dcmSPAEventDelete",
                        data: { 'tXphDocNo': ptXphDocNo},
                        cache: false,
                        success: function(tResult) {
                            tResult = tResult.trim();
                            var tData = $.parseJSON(tResult);

                            $('#odvModalDelSpa').modal('hide');
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();
                            JSvSpaDataTable(pnPage);
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }
            });
        }

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 18/02/2019 Napat(Jame)
//Return:  object Status Delete
//Return Type: object
function JSoSpaDelChoose(pnPage){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        JCNxOpenLoading();
        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        if (aDataSplitlength > 1) {

            localStorage.StaDeleteArray = '1';

            $.ajax({
                type: "POST",
                url: "dcmSPAEventDelete",
                data: { 'tXphDocNo': aNewIdDelete },
                success: function(tResult) {
                    
                    JSxSpaNavDefult();
                    setTimeout(function() {
                        $('#odvModalDelSpa').modal('hide');
                        JSvSpaDataTable(pnPage);
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmIDDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.obtChoose').hide();
                        $('.modal-backdrop').remove();
                    }, 1000);

                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });


        } else {
            localStorage.StaDeleteArray = '0';

            return false;
        }

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 25/02/2019 Napat(Jame)
//Return : object Status Delete
//Return Type : object
function JSoSpaPdtPriDel(pnPage,ptDocNo,ptPdtCode,ptPunCode,pnSeq,ptSta){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        $('#odvModalDelSpaPdtPri').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptPdtCode + '(' + ptPunCode + ')');
        $('#osmConfirm').off('click');
        $('#osmConfirm').on('click', function() {
            $.ajax({
                type: "POST",
                url: "dcmSPAPdtPriEventDelete",
                data: { 
                    'tDocNo'    : ptDocNo,
                    'tPdtCode'  : ptPdtCode,
                    'tPunCode'  : ptPunCode,
                    'tSeq' : pnSeq,
                    'tSta' : ptSta 
                },
                cache: false,
                success: function(tResult) {
                    $('#odvModalDelSpaPdtPri').modal('hide');
                    $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                    $('#ohdConfirmPdtDelete').val('');
                    $('#ohdConfirmPunDelete').val('');
                    $('#ohdConfirmDocDelete').val('');
                    localStorage.removeItem('LocalItemData');
                    $('.modal-backdrop').remove();
                    JCNxOpenLoading();
                    JSvSpaPdtPriDataTable(pnPage);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });

    }else{

        JCNxShowMsgSessionExpired();

    }
}


//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 25/02/2019 Napat(Jame)
//Return:  object Status Delete
//Return Type: object
function JSoSpaPdtPriDelChoose(pnPage){
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        JCNxOpenLoading();

        // var aSeq = $('#ohdConfirmSeqDelete').val();
        // var aPdt = $('#ohdConfirmPdtDelete').val();
        var aDocData = $('#oetXphDocNo').val();
        // var aPun = $('#ohdConfirmPunDelete').val();

        // // PdtCode
        // var aTextSeq = aSeq.substring(0, aSeq.length - 2);
        // var aSeqSplit = aTextSeq.split(" , ");
        // var aSeqSplitlength = aSeqSplit.length;
        // // PdtCode
        // var aTextPdt = aPdt.substring(0, aPdt.length - 2);
        // var aPdtSplit = aTextPdt.split(" , ");
        // var aPdtData = [];
        // // PunCode
        // var aTextPun = aPun.substring(0, aPun.length - 2);
        // var aPunSplit = aTextPun.split(" , ");
        // var aPunData = [];

        // for ($i = 0; $i < aSeqSplitlength; $i++) {
        //     aPdtData.push(aPdtSplit[$i]);
        //     aPunData.push(aPunSplit[$i]);
        // }

        // console.log('aPdtData: ' + aPdtData);
        // console.log('aPunData: ' + aPunData);

        var oPdtDataItem = JSON.parse(localStorage.getItem('LocalItemData'));
        var nPdtDataItemLength = oPdtDataItem.length;

        if (nPdtDataItemLength > 1) {
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                format: "JSON",
                url: "dcmSPAPdtPriEventDelete",
                data: { 
                    'tDocNo' : aDocData,
                    // 'tPdtCode' : aPdtData,
                    // 'tPunCode' : aPunData,
                    'tDelType' : "M",
                    'tPdtDataItem' : JSON.stringify(oPdtDataItem)
                },
                success: function(tResult) {
                    // console.log(tResult);
                    setTimeout(function() {
                        $('#odvModalDelSpaPdtPri').modal('hide');
                        JSvSpaPdtPriDataTable(pnPage);
                        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                        $('#ohdConfirmSeqDelete').val('');
                        $('#ohdConfirmPdtDelete').val('');
                        $('#ohdConfirmPunDelete').val('');
                        $('#ohdConfirmDocDelete').val('');
                        localStorage.removeItem('LocalItemData');
                        $('.obtChoose').hide();
                        $('.modal-backdrop').remove();
                    }, 1000);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }

}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 18/02/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvSpaClickPage(ptPage) {

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPageSpa .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPageSpa .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JCNxOpenLoading();
        JSvSpaDataTable(nPageCurrent);
    
    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality : เปลี่ยนหน้า pagenation product price temp
//Parameters : Event Click Pagenation
//Creator : 03/05/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvPdtPriClickPage(ptPage) {

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWPagePdtPri .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld = $('.xWPagePdtPri .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JCNxOpenLoading();
        JSvSpaPdtPriDataTable(nPageCurrent);

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 18/02/2019 Napat(Jame)
//Return: - 
//Return Type: -
function JSxShowButtonChoose() {

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

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

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 18/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxTextinModal() {

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

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxSpaPdtPriTextinModal() {

    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tTextSeq  = '';
        var tTextPdt  = '';
        var tTextDoc  = '';
        var tTextPun  = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++){
            tTextSeq += aArrayConvert[0][$i].tSeq;
            tTextSeq += ' , ';
            tTextPdt += aArrayConvert[0][$i].tPdt;
            tTextPdt += ' , ';
            tTextDoc  += aArrayConvert[0][$i].tDoc;
            tTextDoc  += ' , ';
            tTextPun  += aArrayConvert[0][$i].tPun;
            tTextPun  += ' , ';
        }
        $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmSeqDelete').val(tTextSeq);
        $('#ohdConfirmPdtDelete').val(tTextPdt);
        $('#ohdConfirmPunDelete').val(tTextPun);
        $('#ohdConfirmDocDelete').val(tTextDoc);
    }

}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 18/02/2019 Napat(Jame)
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


//Functionality: Function Chack Value Type
//Parameters: pnValue
//Creator: 18/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxCheckValue(pnValue) {

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tVal = "";
        if(pnValue == 2 || pnValue == 4){
            tVal = $('#ohdValueType1').val();
        }else{
            tVal = $('#ohdValueType2').val();
        }

        $('#ospValueType').html(tVal);
    
    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality: Function Chack Document Type
//Parameters: pnSelected
//Creator: 04/03/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxCheckDocType(pnSelected) {

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        if(pnSelected == 1){
            $('#optStaAdj1').attr('disabled',false);
            for(var i=2;i<=5;i++){
                $('#optStaAdj'+i).attr('disabled',true);// $('#optStaAdj'+i).addClass("xCNHide");
            }
        }else if(pnSelected == 2){
            for(var i=1;i<=5;i++){
                $('#optStaAdj'+i).attr('disabled',false);
            }
        }else{
            for(var i=1;i<=5;i++){
                $('#optStaAdj'+i).attr('disabled',true);
            }
        }

        $("#ocmXphStaAdj").selectpicker("refresh");
    
    }else{

        JCNxShowMsgSessionExpired();

    }

}


//Functionality: Function Get Branch from Company
//Parameters: -
//Creator: 21/02/2019 Napat(Jame)
//Return: -
//Return Type: -
// function JSxGetBchComp(){

//     // var nStaSession = 1;
//     // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

//     //     $.ajax({
//     //         type: "POST",
//     //         url: "dcmSPAGetBchComp",
//     //         success: function(oResult) {
//     //             var aReturn = JSON.parse(oResult);
//     //             $('#oetBchCode').val(aReturn['FTBchCode']);
//     //         },
//     //         error: function(jqXHR, textStatus, errorThrown) {
//     //             JCNxResponseError(jqXHR, textStatus, errorThrown);
//     //         }
//     //     });

//     // }else{

//     //     JCNxShowMsgSessionExpired();

//     // }

//     $tBchinComp = FCNtGetBchInComp();
//     $('#oetBchCode').val($tBchinComp);

// }

//Functionality: Function Set Condition Browse
//Parameters: ptZneChain
//Creator: 22/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxSetCondition(ptZneChain){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tZneChain = JSON.parse(ptZneChain);
        oCmpBrowseBranchRef.Where.Condition = ["AND LEFT(FTZneChain, 5) = '" + tZneChain + "' AND FTZneTable = 'TCNMBranch'"];

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Functionality: Function Set input oetXphBchCode
//Parameters: ptBchCode
//Creator: 22/02/2019 Napat(Jame)
//Return: -
//Return Type: -
function JSxSetXphBchCode(ptBchCode){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tBchCode = JSON.parse(ptBchCode);
        $('#oetXphBchTo').val(tBchCode);

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function select adjust price
function JSxSpaAdjAll(){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tDocNo       = $('#oetXphDocNo').val();
        var tStaAdj      = $('#ocmXphStaAdj').val();
        var tValue       = $('#oetValue').val();
        var tChangePrice = $('#ocmChangePrice').val();
        var nRowlength = $('#ofmAddSpa tr.otrSpaPdtPri').length;

        if(tValue==''){
            FSvCMNSetMsgWarningDialog($('#ohdTextValidate').attr('validatevalue'));
            return ; 
            
        }
        if(nRowlength==0){
            FSvCMNSetMsgWarningDialog($('#ohdTextValidate').attr('validatepdrcode'));
            return ;
        }
        // console.log('tStaAdj: ' + tStaAdj);
        // console.log('tValue: ' + tValue);
        // console.log('tChangePrice: ' + tChangePrice);

        // if(tStaAdj != "" && tValue != "" && tChangePrice != ""){
        //     alert('Pass');
        // }else{
        //     alert('Please Select');
        // }
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "dcmSPAPdtPriAdjust",
            data: { 
                'tDocNo'        : tDocNo,
                'tStaAdj'       : tStaAdj,
                'tValue'        : tValue,
                'tChangePrice'  : tChangePrice
            },
            success: function(tResult) {
                // var aReturn = JSON.parse(tResult);
                // console.log(aReturn);
                JSvSpaPdtPriDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Borwse products list
function JSvPDTBrowseList(){

    var nStaSession = 1;

    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var dTime               = new Date();
        var dTimelocalStorage   = dTime.getTime();

        $.ajax({
            type: "POST",
            url: "BrowseDataPDT",
            data: {
                'Qualitysearch'   : ['SUP','NAMEPDT','CODEPDT','FromToBCH','FromToSHP','FromToPGP','FromToPTY'],
                'PriceType'       : ['Pricesell'],
                'SelectTier'      : ['PDT'],//PDT, Barcode
                'Elementreturn'   : ['oetInputTestValue','oetInputTestName'],
                'ShowCountRecord' : 10,
                'NextFunc'        : 'JSxSpaPdtPriAddTemp',
                'ReturnType'      : 'M', //S = Single M = Multi
                'SPL'             : ['',''],
                'BCH'             : [$('#oetBchCodeMulti').val(),''],//Code, Name
                'SHP'             : ['',''],
                'TimeLocalstorage': dTimelocalStorage,
                'Where'           : [" AND Products.FTPdtType <> '6' "]
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                $('#odvModalDOCPDT').modal({backdrop: 'static', keyboard: false})  
                $('#odvModalDOCPDT').modal({ show: true });

                //remove localstorage
                localStorage.removeItem("LocalItemDataPDT");
                $('#odvModalsectionBodyPDT').html(tResult);
            },
            error: function(data) {
                console.log(data);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Function Insert product to doctmp and load datatable
function JSxSpaPdtPriAddTemp(elem,ptFocusType){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var aData = JSON.parse(elem);
        var tFocusType = (ptFocusType === undefined || ptFocusType == '')? '1' : ptFocusType;
        // console.log(aData);

        if( tFocusType == '1' ){
            JCNxOpenLoading();
        }

        $.ajax({
            type: "POST",
            url: "dcmSPAPdtPriEventAddTmp",
            data: { 
                'aData'       : aData,
                // 'nSeq'        : $('#otbSpaDataList').data('totalrow'),
                'tFTBchCode'  : $('#oetBchCode').val(),
                'tFTXthDocNo' : $('#oetXphDocNo').val()
                },
            cache: false,
            success: function(tResult) {
                var aResult = JSON.parse(tResult);
                // console.log(aResult);

                $('#oetSPAFitstPdtCode').val(aData[0]['pnPdtCode']+aData[0]['ptPunCode']);
                JSvSpaPdtPriDataTable('1',tFocusType);
                // JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Show input and hide textview for edit inline
function JSxSpaEditInLine(pnSeq){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        $('.xWEditInLine'+pnSeq).removeClass('xCNHide');
        $('.xWShowInLine'+pnSeq).addClass('xCNHide');

        $('.xWShowIconCancelInLine'+pnSeq).removeClass('xCNHide');
        $('.xWShowIconSaveInLine'+pnSeq).removeClass('xCNHide');
        $('.xWShowIconEditInLine'+pnSeq).addClass('xCNHide');

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Save product price list inline
function JSxSpaSaveInLine(oEvent,oElm){
    // var nStaSession = 1;
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
     
        // var nSeq        = oElm.DataAttribute[0]['dataSEQ'];
        // var tPrice      = oElm.DataAttribute[1]['dataPRICE'];
        // var nPage       = oElm.DataAttribute[2]['dataPAGE'];
        // var tValue      = oElm.VeluesInline;
        var nDecimalShow = $('#nDecimalShow').val();
        var nSeq = $(oElm).attr('seq');
        var tPrice = $(oElm).attr('columname');
        var tColValidate = $(oElm).attr('col-validate');
        var nPage = $(oElm).attr('page');
        var b4value = parseFloat($(oElm).attr('b4value'));
        var tValue = ($(oElm).val() == "")?0:parseFloat($(oElm).val().replace(/,/g, ''));
        // alert(tValue);
        console.log(b4value);
        console.log(tValue);
        // console.log(oElm);
        // if(tValue == ""){
        //     alert('Value is null');
        //     JSvSpaPdtPriDataTable();
        // }else{
            // var tRet = parseFloat($('#ohdFCXtdPriceRet'+pnSeq).val());
            // var tWhs = parseFloat($('#ohdFCXtdPriceWhs'+pnSeq).val());
            // var tNet = parseFloat($('#ohdFCXtdPriceNet'+pnSeq).val());

            var tDocNo   = $('#otrSpaPdtPri'+nSeq).data('doc');
            var tPdtCode = $('#otrSpaPdtPri'+nSeq).data('code');
            var tPunCode = $('#otrSpaPdtPri'+nSeq).data('pun');
            var tSeq = $('#otrSpaPdtPri'+nSeq).data('seq');
            var oetSearchSpaPdtPri  = $('#oetSearchSpaPdtPri').val();
            // $('.xWShowValueFCXtdPriceRet'+pnSeq).text(tRet.toFixed(nDecimalShow));
            // $('.xWShowValueFCXtdPriceWhs'+pnSeq).text(tWhs.toFixed(nDecimalShow));
            // $('.xWShowValueFCXtdPriceNet'+pnSeq).text(tNet.toFixed(nDecimalShow));

            // $('.xWEditInLine'+pnSeq).addClass('xCNHide');
            // $('.xWShowInLine'+pnSeq).removeClass('xCNHide');
            // $('.xWShowIconSaveInLine'+pnSeq).addClass('xCNHide');
            // $('.xWShowIconEditInLine'+pnSeq).removeClass('xCNHide');
            // $('.xWShowIconCancelInLine'+pnSeq).addClass('xCNHide');

            // JCNxOpenLoading();

        if(b4value != tValue){
                // $(oElm).addClass('xCNHide');
            $.ajax({
                type: "POST",
                url: "dcmSPAPdtPriEventUpdPriTmp",
                data: { 
                    'FTXthDocNo' : tDocNo,
                    'FTPdtCode' : tPdtCode,
                    'FTPunCode' : tPunCode,
                    'ptPrice' : tPrice,
                    'ptValue' : tValue,
                    'tSearchSpaPdtPri' : oetSearchSpaPdtPri,
                    'tSeq' : tSeq,
                    'tColValidate' : tColValidate
                },
                cache: false,
                success: function(pResutl) {
                    var objResult = JSON.parse(pResutl);
                    // $(oElm).removeClass('xCNHide');
                    $(oElm).val(numberWithCommas(tValue.toFixed(nDecimalShow)));
                    $(oElm).attr('b4value',tValue);
                    // $('#otdSPATotalPrice').text(objResult['cSpaTotalPrice']);

                    var tStatus = $(oElm).parents(".otrSpaPdtPri").data("status");
                    if(tStatus == "3"){
                        $(oElm).parents(".otrSpaPdtPri").find(".xCNAdjPriceStaRmk").text("").removeClass("text-danger");
                    }
                    // JSvSpaPdtPriDataTable(nPage);
                    // JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            // $(oElm).val(accounting.formatNumber(tValue,2,','));
                 $(oElm).val(numberWithCommas(tValue.toFixed(nDecimalShow)));
        }
        // }
        if (oEvent.keyCode == 13) {
            var tNextElement = $(oElm).closest('form').find('input[type=text]');
            var tNextElementID=   tNextElement.eq( tNextElement.index(oElm)+ 1 ).attr('id');
            // console.log(tNextElementID);
            var tValueNext     = parseFloat($('#'+tNextElementID).val().replace(/,/g, ''));
            $('#'+tNextElementID).val(tValueNext);
            $('#'+tNextElementID).focus();
            $('#'+tNextElementID).select();
     
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

function JSxSpaCancelInLine(pnSeq){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        $('.xWEditInLine'+pnSeq).addClass('xCNHide');
        $('.xWShowInLine'+pnSeq).removeClass('xCNHide');

        $('.xWShowIconCancelInLine'+pnSeq).addClass('xCNHide');
        $('.xWShowIconSaveInLine'+pnSeq).addClass('xCNHide');
        $('.xWShowIconEditInLine'+pnSeq).removeClass('xCNHide');

    }else{

        JCNxShowMsgSessionExpired();

    }

}


  //พวกตัวเลขใส่ comma ให้มัน
  function numberWithCommas(x) {
    return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
}


//Function Open Column for set
function JSxOpenColumnFormSet(){
    
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        $.ajax({
            type: "POST",
            url: "dcmSPAAdvanceTableShowColList",
            data: {},
            cache: false,
            Timeout: 0,
            success: function(tResult){

                $("#odvShowOrderColumn").modal({ show: true });
                $('#odvOderDetailShowColumn').html(tResult);
                //JSCNAdjustTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Save column adjust
function JSxSaveColumnShow(){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var aColShowSet = [];
        $(".ocbColStaShow:checked").each(function(){
            aColShowSet.push($(this).data('id'));
        });

        var aColShowAllList = [];
        $(".ocbColStaShow").each(function(){
        aColShowAllList.push($(this).data('id'));
        });


        var aColumnLabelName = [];
        $(".olbColumnLabelName").each(function(){
        aColumnLabelName.push($(this).text());
        });

        var nStaSetDef;
        if($('#ocbSetToDef').is(':checked')){
        nStaSetDef = 1;
        }else{
        nStaSetDef = 0;
        }

        $.ajax({
            type: "POST",
            url: "dcmSPAAdvanceTableShowColSave",
            data: {aColShowSet:aColShowSet,
                    nStaSetDef:nStaSetDef,
                    aColShowAllList:aColShowAllList,
                    aColumnLabelName:aColumnLabelName
                    },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                $('#odvShowOrderColumn').modal('hide');
                $('.modal-backdrop').remove();
                JSvSpaPdtPriDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Display modal original price by product
function JSxSPAShowOriginalPrice(pnSeq){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tZne   = $('#oetZneChain').val();
        var tBch   = $('#oetXphBchTo').val();
        var tMer   = $('#oetMerCode').val();
        var tPpl   = $('#oetPplCode').val();
        var tAgg   = $('#oetAggCode').val();
        var tUsrLv = $('#ohdUserLevel').val();
        var tTable = '';
        var tField = '';

        // if(tAgg!=""){
        //     tTable = 'TCNTPdtPrice4AGG';
        //     tField = tAgg;
        // }else if(tZne!=""&&tBch==""&&tMer==""&&tPpl==""&&tAgg==""){
        //     tTable = 'TCNTPdtPrice4ZNE';
        //     tField = tZne;
        // }else if(tZne!=""||tBch!=""&&tMer==""&&tPpl==""&&tAgg==""){
        //     //1 TCNTPdtPrice4PDT User ธรรมดาให้เลือกสาขาของตัวเอง
        //     //2 TCNTPdtPrice4BCH User HQ สามารถเลือก สาขาอื่นๆได้
        //     if(tUsrLv=="HQ"){
        //         tTable = 'TCNTPdtPrice4BCH';
        //         tField = tBch;
        //     }else{
        //         tTable = 'TCNTPdtPrice4PDT';
        //         tField = '';
        //     }
        // }else{
        //     tTable = 'TCNTPdtPrice4PDT';
        //     tField = '';
        // }

        $.ajax({
            type: "POST",
            url: "dcmSPAOriginalPrice",
            data: {
                ptFTPdtCode       : $('#ohdFTPdtCode'+pnSeq).text(),
                ptFTPunCode       : $('#ohdFTPunCode'+pnSeq).val(),
                ptField           : tField,
                ptTable           : 'TCNTPdtPrice4PDT',
                ptFTPplCode       : $('#oetPplCode').val()
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                $('#odvModalOriginalPrice').modal('show');
                $('#odvDetailOriginalPrice').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Display modal original price by product
// function JSxSPAApproveEvent(){

//     var nStaSession = 1;
//     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

//         $.ajax({
//             type: "POST",
//             url: "dcmSPAEventApprove",
//             data: {
//                 tFTXphDocNo : $('#oetXphDocNo').val()
//             },
//             cache: false,
//             Timeout: 0,
//             success: function(tResult) {
//                 alert('Connect MQ');
//                 $('#obtBtnSpaApv').attr('disabled',true);
//             },
//             error: function(jqXHR, textStatus, errorThrown) {
//                 JCNxResponseError(jqXHR, textStatus, errorThrown);
//             }
//         });
    
//     }else{

//         JCNxShowMsgSessionExpired();

//     }
// }

//Function Check Auto Generate
function JSxSPACheckAutoGenerate(){

    if($("#ocbStaAutoGenCode").prop("checked")){
        $('#oetXphDocNo').attr('readonly',true);
    }else{
        $('#oetXphDocNo').attr('readonly',false);
    }
    $('#oetXphDocNo').val("");

}

//Function Check Relationship Date
function JSxSPACheckRelationshipDate(tID){
    
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var dStart = $('#oetXphDStart').val();
        var dStop  = $('#oetXphDStop').val();

        if(dStart != ""){
            console.log('1');
            $('.xCNStopDatePicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                startDate: dStart,
            });
            $(tID).datepicker('show');
        }else{
            console.log('2');
            $('.xCNStartDatePicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(),
            });
            $('.xCNStopDatePicker').datepicker({
                format: 'yyyy-mm-dd',
                autoclose: true,
                todayHighlight: true,
                startDate: new Date(),
            });
            $(tID).datepicker('show');
        }

    }else{

        JCNxShowMsgSessionExpired();

    }

}

//Function Disabled Input On User Approve
function JSxDisableInput(){

    var tUsrApv = $('#oetStaApv').val();
    var tStaDoc = $('#oetStaDoc').val();

    if(tUsrApv != "" || tStaDoc == '3'){

        //============= Create by Witsarut 27/08/2019 =============
            $('#obtBtnSpaApv').hide();
            $('#obtBtnPrint').attr('disabled',false);
            $('#obtBtnSpaCancel').hide();
            $('#obtSubmit').hide();
            $('.xWBtnGrpSaveRight').hide();

          //============= Create by Witsarut 27/08/2019 =============
       
        $('.xWEditInlineElement').attr('disabled',true);
        $('#oetXphDocDate').attr('disabled',true);
        $('#oetXphDocTime').attr('disabled',true);
        $('#obtXphDocDate').attr('disabled',true);
        $('#obtXphDocTime').attr('disabled',true);
        $('#ocmXphDocType').attr('disabled',true);
        $('#ocmXphStaAdj').attr('disabled',true);
        $('#oetValue').attr('disabled',true);
        $('#ocmChangePrice').attr('disabled',true);
        $('#obtAdjAll').attr('disabled',true);
        $('#btnBrowseZone').attr('disabled',true);
        $('#btnBrowseBranch').attr('disabled',true);
        $('#btnBrowseMerChrant').attr('disabled',true);
        $('#btnBrowsePdtPriList').attr('disabled',true);
        $('#btnBrowseMerchant').attr('disabled',true);
        $('#oetXphDStart').attr('disabled',true);
        $('#obtXphDStart').attr('disabled',true);
        $('#oetXphDStop').attr('disabled',true);
        $('#obtXphDStop').attr('disabled',true);

        $('#oetXphTStart').attr('disabled',true);
        $('#obtXphTStart').attr('disabled',true);

        $('#oetXphTStop').attr('disabled',true);
        $('#obtXphTStop').attr('disabled',true);

        $('#oetXphName').attr('disabled',true);
        $('#oetXphRefInt').attr('disabled',true);
        $('#oetXphRefIntDate').attr('disabled',true);
        $('#obtXphRefIntDate').attr('disabled',true);

        $('#btnBrowseAgency').attr('disabled',true);
        $('#ocmXphPriType').attr('disabled',true);
        $('#ocbXphStaDocAct').attr('disabled',true);
        $('#otaXphRmk').attr('disabled',true);

        $('#obtAddPdt').attr('disabled',true);
        $('#obtAddPdt').addClass('xCNBrowsePdtdisabled');
        $('.ocbListItem').attr('disabled',true);
        $('.ospListItem').addClass('xCNDocDisabled');
        $('.xCNDeleteInLineClick').attr('disabled',true);
        $('.xCNDeleteInLineClick').addClass('xWImgDisable');
        $('.xCNEditInLineClick').attr('disabled',true);
        $('.xCNEditInLineClick').addClass('xWImgDisable');
        $('.xWLabelInLine').addClass('xWImgDisable');
        $('.xWInLine').addClass('xWTdDisable');

        $('#oetSPAInsertScan').attr('disabled',true);
        $('.xCNImportBtn').attr('disabled',true);
        $('.xCNBTNMngTable').attr('disabled',true);
    }
}

/**
* Functionality : Action for approve
* Parameters : pbIsConfirm
* Creator : 03/03/2019 Napat(Jame)
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxSPAApprove(pbIsConfirm){
    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        try{
            if(pbIsConfirm){
                $("#odvSPAPopupApv").modal('hide');
                var tDocNo    = $('#oetXphDocNo').val();
                var tBchCode  = $('#oetBchCode').val();

                $.ajax({
                    type: "POST",
                    url: "dcmSPAEventApprove",
                    data: { 
                        tDocNo     : tDocNo,
                        tBchCode   : tBchCode,
                        dDateStart  : $('#oetXphDStart').val(),
                        tTimeStart  : $('#oetXphTStart').val(),
                        tPplCode    : $('#oetPplCode').val()
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        let aResult = JSON.parse(oResult);
                        if(aResult['nStaEvent'] != "1"){
                            FSvCMNSetMsgErrorDialog(aResult['tStaMessg']);
                        }else{
                            JSoSPASubscribeMQ();
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                $("#odvSPAPopupApv").modal('show');
            }
        }catch(err){
            console.log("JSnTWOApprove Error: ", err);
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Function Display modal original price by product
function JSxSPAUpdateStaDocCancel(){

    var nStaSession = 1;
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var tDocNo = $('#oetXphDocNo').val();

        $.ajax({
            type: "POST",
            url: "dcmSPAUpdateStaDocCancel",
            data: { 
                tDocNo  : tDocNo
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                console.log('Cancel: ' + tDocNo);
                JSvCallPageSpaEdit(tDocNo);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }else{

        JCNxShowMsgSessionExpired();

    }
}

/**
* Functionality : Check Approve Processing
* Parameters : ptStatus is status approve('' = pending, 2 = processing, 1 = approved)
* Creator : 27/02/2019 piya
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSbSPAIsStaApv(ptStatus){
    try{
        ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
        let bStatus = false;
        if(($("#oetStaPrcDoc").val() == ptStatus)){
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log("JSbSPAIsStaApv Error: ", err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbSPAIsUpdatePage(){
    try{
        var tCardShiftOutCode = $('#oetXphDocNo').val();
        var bStatus = false;
        if(!tCardShiftOutCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbSPAIsUpdatePage Error: ', err);
    }
}

/**
* Functionality : Check Delete Qname Status
* Parameters : ptStatus is status approve('' = not, 1 = removed)
* Creator : 27/02/2019 piya
* Last Modified : -
* Return : Approve status
* Return Type : boolean
*/
function JSbSPAIsStaDelQname(ptStatus){
    try{
        ptStatus = (typeof ptStatus == 'undefined') ? '' : ptStatus;
        let bStatus = false;
        if(($("#oetStaDelQname").val() == ptStatus)){
            bStatus = true;
        }
        // return bStatus;
        // alert('bStatus: ' + bStatus);
    }catch(err){
        console.log("JSbSPAIsStaDelQname Error: ", err);
    }

    // alert('JSbSPAIsStaDelQname Error : ' + bStatus);
}

function JSoSPASubscribeMQ(){
	
	//RabbitMQ
    /*===========================================================================*/

    var tLangCode = $("#ohdLangEdit").val();
    var tUsrBchCode = $("#oetBchCode").val();
    var tUsrApv     = $("#oetXthApvCodeUsrLogin").val();
    var tStaPrcDoc = $("#oetStaPrcDoc").val();
    var tUsrCode = $("#oetUsrCode").val();
    var tDocNo = $("#oetXphDocNo").val();
    var tPrefix = 'RESAJP';
    var tStaDelMQ = $("#oetStaDelQname").val();
    var tStaApv = $("#oetStaApv").val();
    var tQName = tPrefix + '_' + tDocNo + '_' +tUsrApv;

    // MQ Message Config
    var poDocConfig = {
        tLangCode: tLangCode,
        tUsrBchCode: tUsrBchCode,
        tUsrApv: tUsrApv,
        tDocNo: tDocNo,
        tPrefix: tPrefix,
        tStaDelMQ: tStaDelMQ,
        tStaApv: tStaApv,
        tQName: tQName
    };

    var poMqConfig = {
        host: 'ws://' + oSTOMMQConfig.host + ':15674/ws',
        username: oSTOMMQConfig.user,
        password: oSTOMMQConfig.password,
        vHost: oSTOMMQConfig.vhost
    };

    // Callback Page Control(function)
    var poCallback = {
        tCallPageEdit: 'JSvCallPageSpaEdit',
        tCallPageList: 'JSvCallPageSpaList'
    };

    // Update Status For Delete Qname Parameter
    var poUpdateStaDelQnameParams = {
        ptDocTableName : "TCNTPdtAdjPriHD",
        ptDocFieldDocNo: "FTXphDocNo",
        ptDocFieldStaApv: "FTXphStaPrcDoc",
        ptDocFieldStaDelMQ: "FTXphStaDelMQ",
        ptDocStaDelMQ: "1",
        ptDocNo : tDocNo    
    };

    //Check Show Progress %
	FSxCMNRabbitMQMessage(poDocConfig, poMqConfig, poUpdateStaDelQnameParams, poCallback);
    /*===========================================================================*/
    //RabbitMQ
	
}

// Create By : 25/11/2020 Napat(Jame)
function JSxSPASearchFromBarcode(poElem){
    // console.log( $(poElem).val() );
    $('#oetSPAInsertScan').attr('readonly',true);
    $.ajax({
        type: "POST",
        url : "BrowseDataPDTTableCallView",
        data: {
            aPriceType       : ['Pricesell'],
            NextFunc         : "",
            SPL              : "",
            BCH              : $('#oetBchCodeMulti').val(),
            tTextScan        : $(poElem).val()
        },
        cache   : false,
        timeout : 0,
        success : function(tResult){
            var oText = JSON.parse(tResult);
            if( oText != "800" ){
                JSxSpaPdtPriAddTemp(tResult,'2');
            }else{
                FSvCMNSetMsgWarningDialog('ไม่พบข้อมูลสินค้า กรุณาลองใหม่อีกครั้ง');
            }
            $('#oetSPAInsertScan').attr('readonly',false).val('');
            // console.log(oText);
        },
        error: function (jqXHR,textStatus,errorThrown){
            JCNxResponseError(jqXHR,textStatus,errorThrown);
        }
    });
}