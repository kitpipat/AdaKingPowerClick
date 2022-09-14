var nStaAdsBrowseType   = $('#oetAdsStaBrowse').val();
var tCallAdsBackOption  = $('#oetAdsCallBackOption').val();
var tBchCode            = $('#ohdBchCode').val();
var tShpCode            = $('#ohdShpCode').val();
var tPosCode            = $('#ohdPosCode').val(); 

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxAdsNavDefult();
    if(nStaAdsBrowseType != 1){
        JSvCallPagePosAdsList();
    }else{
        JSvCallPagePosAdsAdd();
    }
});

//function : Function Clear Defult Button PosAds
//Parameters : Document Ready
//Creator : 30/10/2018 witsarut
//Return : Show Tab Menu
//Return Type : -
function JSxAdsNavDefult(){
    if(nStaAdsBrowseType != 1 || nStaAdsBrowseType == undefined){
        $('.xCNAdsVBrowse').hide();
        $('.xCNAdsVMaster').show();
        $('.xCNChoose').hide();
        $('#oliAdsTitleAdd').hide();
        $('#oliAdsTitleEdit').hide();
        $('#oliAdsTitleAddPageDivice').hide();
        $('#odvBtnAdsAddEdit').hide();
        $('#odvBtnAdsInfo').show();
    }else{
        $('#odvModalBody .xCNAdsVMaster').hide();
        $('#odvModalBody .xCNAdsVBrowse').show();
        $('#odvModalBody #odvAdsMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliAdsNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvAdsBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNAdsBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNAdsBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 30/10/2018 witsarut
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR,textStatus,errorThrown){
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
}

//function : Call PosAds Page list  
//Parameters : Document Redy And Event Button
//Creator :	30/10/2018 witsarut
//Return : View
//Return Type : View
function JSvCallPagePosAdsList(){
    localStorage.tStaPageNow = 'JSvCallPagePosAdsList';
    $('#oetSearchPosAds').val('');
    JCNxOpenLoading();    
    $.ajax({
        type: "POST",
        url: "posAdsList",
        cache: false,
        timeout: 0,
        data:{
                tPosCode: $("#ohdTPosCode").val()
        },
        success: function(tResult){
            $('#odvContentPagePosAds').html(tResult);
            JSvPosAdsDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call PosAds Data List
//Parameters: Ajax Success Event 
//Creator:	30/10/2018 witsarut
//Return: View
//Return Type: View
function JSvPosAdsDataTable(pnPage){
    JCNxOpenLoading();   
    var tSearchAll      = $('#oetSearchPosAds').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    $.ajax({
        type: "POST",
        url: "posAdsDataTable",
        data: {
            tSearchAll   : tSearchAll,
            nPageCurrent : nPageCurrent,
            tPosCode     : tPosCode,
            ptBchCode    : $('#oetPosBchCode').val(),
            ptShpCode    : $('#ohdPosShpCode').val()
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataPosAds').html(tResult);
            }
            JSxAdsNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
            localStorage.removeItem("LocalItemDataAds");
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call PosAds Page Add  
//Parameters : Event Button Click
//Creator : 30/10/2018 witsarut
//Last Update : 11/08/2020 Napat(Jame) เปลี่ยนเป็นดึงจาก Browse สาขา FTBchCode
//Return : View
//Return Type : View
function JSvCallPagePosAdsAdd(){
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('', '');
    var tPosCode = $('#ohdPosCode').val();
    var tBchCode = $('#oetPosBchCode').val(); //$('#ohdBchCode').val();
    var tShpCode = $('#ohdShpCode').val();

    $.ajax({
        type: "POST",
        url:  "posAdsPageAdd",
        data: {
              tPosCode  : tPosCode,
              tBchCode  : tBchCode,
              tShpCode  : tShpCode
        },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if (nStaAdsBrowseType == 1) {
                $('.xCNAdsVMaster').hide();
                $('.xCNAdsVBrowse').show();
                $('#odvModalBodyBrowse').html(tResult)
                $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
            }else{
                $('.xCNAdsVBrowse').hide();
                $('.xCNAdsVMaster').show();
                $('#oliAdsTitleEdit').hide();
                $('#oliAdsTitleAdd').show();
                $('#odvBtnAdsInfo').hide();
                $('#odvBtnAdsAddEdit').show();
            }
            $('#odvContentPagePosAds').html(tResult);
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call PosAds Page Edit  
//Parameters : Event Button Click 
//Creator : 17/09/2019 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPagePosAdsEdit(ptBchCode,ptShpCode,ptPosCode,ptPsdSeq){
    JCNxOpenLoading();
    // JStCMMGetPanalLangSystemHTML('JSvCallPagePosAdsEdit',ptPosCode);
    $.ajax({
        type: "POST",
        url: "posAdsPageEdit",
        data: { 
                tBchCode : ptBchCode,
                tShpCode : ptShpCode,
                tPosCode : ptPosCode,
                tPsdSeq  : ptPsdSeq
            },
        cache: false,
        timeout: 0,
        success: function(tResult){
            if(tResult != ''){
                $('#oliAdsTitleAdd').hide();
                $('#oliAdsTitleEdit').show();
                $('.xCNAdsVBrowse').hide();
                $('.xCNAdsVMaster').show();
                $('#odvBtnAdsInfo').hide();
                $('#odvBtnAdsAddEdit').show();

                $('#odvContentPagePosAds').html(tResult);
                //ดึงค่าจากตัวแปร
                var tPsdPosition  = $('#ohdPsdPosition').val();
                var tPsdWide      = $('#ohdPsdWide').val();
                var tPsdHigh      = $('#ohdPsdHigh').val();
                //เซตค่าให้ option
                $("#ocmPosition option[value='" + tPsdPosition + "']").attr('selected', true).trigger('change');
                $("#ocmPosWidth option[value='" + tPsdWide + "']").attr('selected', true).trigger('change');
                $("#ocmPosHeigh option[value='" + tPsdHigh + "']").attr('selected', true).trigger('change');

                $('#oetAdsCode').addClass('xCNDisable');
                $('#oetAdsCode').attr('readonly', true);
                $('.xCNBtnGenCode').attr('disabled', true);
            }
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}


//Functionality : Event Add/Edit PosAds
//Parameters : From Submit
//Creator : 30/10/2018 witsarut
//update  : 12/09/2019 Saharat(Golf)
//Return : Status Event Add/Edit PosAds
//Return Type : object
function JSoAddEditPosAds(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmPosAsd').validate({
            rules: {
                oetPosAdvertiseCode:    "required",
                oetPosAdvertiseName:    "required",

            },
            messages: {
                oetPosAdvertiseCode: $('#oetPosAdvertiseCode').data('validate'),
                oetPosAdvertiseName: $('#oetPosAdvertiseName').data('validate')
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
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmPosAsd').serialize(),
                    success: function(oResult){
                        if(nStaAdsBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                JSvCallPagePosAdsList();
    
                            }else{
                                alert(aReturn['tStaMessg']);
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallBntBackOption);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            },
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 30/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoPosAdsDel(ptCurrentPage,ptSeqNo,tYesOnNo,ptBchCode,ptShpCode,ptPosCode){

    var nStaSession = JCNxFuncChkSessionExpired();
    $('#odvModalDelPosAds').modal('show');
    $('#odvModalDelPosAds .ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ptCurrentPage + ' ( ' + ptSeqNo + ' ) '+ tYesOnNo );
    $('#odvModalDelPosAds #osmConfirmDelete').on('click', function(evt) {
        $.ajax({
            type:   "POST",
            url:    "posAdsEventDelete",
            data: {
                tCurrentPage   : ptCurrentPage,
                tSeqNo         : ptSeqNo,
                tBchCode       : ptBchCode,
                tShpCode       : ptShpCode,
                tPosCode       : ptPosCode
            },
            cache: false,
            success: function(tResult){
                $('#odvModalDelPosAds').modal('hide');
                setTimeout(function(){
                    JSvCallPagePosAdsList();
                }, 500);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });
}

  
    


//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 17/09/2019 Saharat(Golf)
//Return:  object Status Delete
//Return Type: object
function JSxPosAdsDeleteMutirecord(tCurrentPage){
    JCNxOpenLoading();
    var aDataBch = $('#ohdConfirmIDDeleteMutirecordBch').val();
    var aDataShp = $('#ohdConfirmIDDeleteMutirecordShp').val();
    var aDataPos = $('#ohdConfirmIDDeleteMutirecordPos').val();
    var aDataSeq = $('#ohdConfirmIDDeleteMutirecordSeq').val();

    var aBchCode = aDataBch.substring(0, aDataBch.length - 2);
    var aShpCode = aDataShp.substring(0, aDataShp.length - 2);
    var aPosCode = aDataPos.substring(0, aDataPos.length - 2);
    var aSeq     = aDataSeq.substring(0, aDataSeq.length - 2);

    var aDataSplitBch = aBchCode.split(" , ");
    var aDataSplitShp = aShpCode.split(" , ");
    var aDataSplitPos = aPosCode.split(" , ");
    var aDataSplitSeq = aSeq.split(" , ");

    var aDataSplitlength   = aDataSplitSeq.length;

    var aNewBchCodeDelete  = [];
    var aNewShpCodeDelete  = [];
    var aNewPosCodeDelete  = [];
    var aNewSeqDelete      = [];
    for ($i = 0; $i < aDataSplitlength; $i++) {
        aNewBchCodeDelete.push(aDataSplitBch[$i]);
        aNewShpCodeDelete.push(aDataSplitShp[$i]);
        aNewPosCodeDelete.push(aDataSplitPos[$i]);
        aNewSeqDelete.push(aDataSplitSeq[$i]);
    }
    if (aDataSplitlength > 1) {
        localStorage.StaDeleteArray = '1';
        $.ajax({
            type: "POST",
            url:  "posAdsEventDeleteMultiple",
            data: { 
                    'aBchCode' : aNewBchCodeDelete,
                    'aShpCode' : aNewShpCodeDelete,
                    'tPosCode' : aNewPosCodeDelete ,
                    'tSeq'     : aNewSeqDelete,
            },
            success: function(aReturn) {
                aReturn = aReturn.trim();
                var aReturn = $.parseJSON(aReturn);
                if (aReturn['nStaEvent'] == '1') {
                    $('#odvModalDeleteMutirecord').modal('hide');
                    $('๒odvModalDeleteMutirecord #ospConfirmDelete').text($('#ohdConfirmIDDeleteMutirecord').val());
                    $('#ohdConfirmIDDeleteMutirecordBch').val('');
                    $('#ohdConfirmIDDeleteMutirecordShp').val('');
                    $('#ohdConfirmIDDeleteMutirecordPos').val('');
                    $('#ohdConfirmIDDeleteMutirecordSeq').val('');
                    localStorage.removeItem('LocalItemDataAds');
                    $('.modal-backdrop').remove();
                    setTimeout(function() {
                        if (aReturn["nNumRow"] != 0) {
                            if (aReturn["nNumRow"] > 10) {
                                nNumPage = Math.ceil(aReturn["nNumRow"] / 10);
                                if (tCurrentPage <= nNumPage) {
                                    JSvPosAdsDataTable(tCurrentPage);
                                } else {
                                    JSvPosAdsDataTable(nNumPage);
                                }
                            } else {
                                JSvPosAdsDataTable(1);
                            }
                        } else {
                            JSvPosAdsDataTable(1);
                        }
                    }, 500);
                } else {
                    alert(aReturn['tStaMessg']);
                }
                JSxAdsNavDefult();
                JCNxOpenLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    } else {
        localStorage.StaDeleteArray = '0';
        return false;
    }

}



//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 30/10/2018 witsarut
//Return : View
//Return Type : View
function JSvPosAdsClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPagePosAds .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPagePosAds .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvPosAdsDataTable(nPageCurrent);
}


//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 17/09/2019 saharat(Golf)
//Return: - 
//Return Type: -
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataAds"))];
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


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 17/09/2019 saharat(Golf)
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

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 17/09/2019 saharat(Golf)
//Return: -
//Return Type: -
function JSxPaseCodeDelInModal() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemDataAds"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == '') {} else {
        var tSeqCode = '';
        var tPosCode = '';
        var tShpCode = '';
        var tBchCode = '';
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tSeqCode += aArrayConvert[0][$i].nSeq;
            tSeqCode += ' , ';
            tPosCode += aArrayConvert[0][$i].nPos;
            tPosCode += ' , ';
            tBchCode += aArrayConvert[0][$i].nBch;
            tBchCode += ' , ';
            tShpCode += aArrayConvert[0][$i].nShp;
            tShpCode += ' , ';
        }
        $('#odvModalDeleteMutirecord #ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
        $('#ohdConfirmIDDeleteMutirecordBch').val(tBchCode);
        $('#ohdConfirmIDDeleteMutirecordShp').val(tShpCode);
        $('#ohdConfirmIDDeleteMutirecordPos').val(tPosCode);
        $('#ohdConfirmIDDeleteMutirecordSeq').val(tSeqCode);
    }
}
