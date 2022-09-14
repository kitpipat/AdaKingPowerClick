var nStaBnkBrowseType   = $('#oetBnkStaBrowse').val();
var tCallBnkBackOption  = $('#oetBnkCallBackOption').val();

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxBnkNavDefult();
    if(nStaBnkBrowseType != 1){
        JSvCallPageBnkList();
    }else{
        JSvCallPageBnkAdd();
    }
});

//function : Function Clear Defult Button Bank
//Parameters : Document Ready
//Creator : 16/06/2021 Supawat
//Return : Show Tab Menu
//Return Type : -
function JSxBnkNavDefult(){
    if(nStaBnkBrowseType != 1 || nStaBnkBrowseType == undefined){
        $('.xCNBnkVBrowse').hide();
        $('.xCNBnkVMaster').show();
        $('.xCNChoose').hide();
        $('#oliBnkTitleAdd').hide();
        $('#oliBnkTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnBnkInfo').show();
    }else{
        $('#odvModalBody .xCNBnkVMaster').hide();
        $('#odvModalBody .xCNBnkVBrowse').show();
        $('#odvModalBody #odvBnkMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBnkNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBnkBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBnkBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBnkBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Product Brand Page BAnk  
//Parameters : Document Redy And Event Button
//Creator :	16/06/2021 Supawat
//Return : View
//Return Type : View
function JSvCallPageBnkList(){
    $('#oetSearchBnk').val('');
    JCNxOpenLoading();    
    $.ajax({
        type    : "POST",
        url     : "banklist",
        cache   : false,
        timeout : 0,
        success : function(tResult){
            $('#odvContentPageBank').html(tResult);
            JSvBnkDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//function: Call Bank Data List
//Parameters: Ajax Success Event 
//Creator:	16/06/2021 Supawat
//Return: View
//Return Type: View
function JSvBnkDataTable(pnPage){
    var tSearchAll      = $('#oetSearchBnk').val();
    var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "bankDataTable",
        data: {
            tSearchAll: tSearchAll,
            nPageCurrent: nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function(tResult){
            if (tResult != "") {
                $('#ostDataBnk').html(tResult);
            }
            JSxBnkNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : Call Bank Page Add  
//Parameters : Event Button Click
//Creator : 16/06/2021 Supawat
//Return : View
//Return Type : View
function JSvCallPageBnkAdd(){
    JCNxOpenLoading();
    $.ajax({
        type    : "POST",
        url     : "bankPageAdd",
        cache   : false,
        timeout : 0,
        success: function(tResult){
            if (nStaBnkBrowseType == 1) {
                $('#odvModalBodyBrowse').html(tResult);
                $('#odvModalBodyBrowse .panel-body').css('padding-top', '0');
                $('.xCNBnkVMaster').hide();
                $('.xCNBnkVBrowse').show();
            }else{
                $('.xCNBnkVBrowse').hide();
                $('.xCNBnkVMaster').show();
                $('#oliBnkTitleEdit').hide();
                $('#oliBnkTitleAdd').show();
                $('#odvBtnBnkInfo').hide();
                $('#odvBtnAddEdit').show();
            }
            $('#odvContentPageBank').html(tResult);
       
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : function submit by submit button only
//Parameters : route
//Creator : 16/06/2021 Supawat
//Update : -
//Return : -
//Return Type : -
function JSxSetStatusClickBnkSubmit(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddBnk').validate().destroy();
        $('#ofmAddBnk').validate({
            rules: {
                oetBnkCode:  {"required" :{}},
                oetBnkName:  {"required" :{}},
            },
            messages: {
                oetBnkCode : {
                    "required"      : $('#oetBnkCode').attr('data-validate-required'),
                },
                oetBnkName : {
                    "required"      : $('#oetBnkName').attr('data-validate-required'),
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
                $.ajax({
                    type    : "POST",
                    url     : ptRoute,
                    data    : $('#ofmAddBnk').serialize(),
                    cache   : false,
                    timeout : 0,
                    success : function(tResult){
                        if(nStaBnkBrowseType != 1){
                            var aReturn = JSON.parse(tResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']){
                                    case '1' :
                                        JSvCallPageBankEdit(aReturn['tCodeReturn']);
                                    break;
                                    case '2' :
                                        JSvCallPageBnkAdd();
                                    break;
                                    case '3' :
                                        JSvCallPageBnkList();
                                    break;
                                    default:
                                        JSvCallPageBankEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            }else{
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallBnkBackOption);  
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }else{
        JCNxShowMsgSessionExpired();  
    }
}


//Functionality: Event Multi Delete
//Parameters: Event Button Delete All
//Creator: 16/06/2021 Supawat
//Return:  object Status Delete
//Return Type: object
function JSoBankDelChoose(pnPage){
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
            url: "bankEventDelete",
            data:{
                'tIDCode' : aNewIdDelete
            },
            success: function (tResult){
                tResult = tResult.trim();
                var aReturn = JSON.parse(tResult);
                if (aReturn['nStaEvent'] == '1'){
                    $('#odvModalDelBnk').modal('hide');
                    $('#ospConfirmDelete').empty();
                    localStorage.removeItem('LocalItemData');
                    $('#ospConfirmIDDelete').val('');
                    $('#ohdConfirmIDDelete').val('');
                    setTimeout(function() {
                        if(aReturn["nNumRowBnk"]!=0){
                            if(aReturn["nNumRowBnk"]>10){
                                nNumPage = Math.ceil(aReturn["nNumRowBnk"]/10);
                                if(pnPage<=nNumPage){
                                    JSvBnkDataTable(pnPage);
                                }else{
                                    JSvBnkDataTable(nNumPage);
                                }
                            }else{
                                JSvBnkDataTable(1);
                            }
                        }else{
                            JSvBnkDataTable(1);
                        }
                    }, 500);
                }else{
                    JCNxOpenLoading();
                    alert(aReturn['tStaMessg']);    
                }
                JSxBnkNavDefult();
            },
             error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        localStorage.StaDeleteArray = '0';
        return false;
    }
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 16/06/2021 Supawat
//Return : View
//Return Type : View
function JSvBankClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageBank .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageBank .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvBnkDataTable(nPageCurrent);
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 16/06/2021 Supawat
//Return : object Status Delete
//Return Type : object
function JSoBankDel(pnPage, tIDCode, ptName, tYesOnNo){
    var aData = $('#ohdConfirmIDDelete').val();
    var aTexts = aData.substring(0, aData.length - 2);
    var aDataSplit = aTexts.split(" , ");
    var aDataSplitlength = aDataSplit.length;

    if (aDataSplitlength == '1') {
        $('#odvModalDelBnk').modal('show');
        $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tIDCode + ' ( ' + ptName + ' ) '+ tYesOnNo );
        $('#osmConfirm').on('click', function(evt) {
            if (localStorage.StaDeleteArray != '1') {
                $.ajax({
                    type: "POST",
                    url : "bankEventDelete",
                    data: { 'tIDCode': tIDCode},
                    cache: false,
                    success: function(tResult){
                        tResult = tResult.trim();
                        var aReturn = $.parseJSON(tResult);
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelBnk').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            $('#ospConfirmIDDelete').val('');
                            $('#ohdConfirmIDDelete').val('');
                            setTimeout(function() {
                                if(aReturn["nNumRowBnk"]!=0){
                                    if(aReturn["nNumRowBnk"]>10){
                                        nNumPage = Math.ceil(aReturn["nNumRowBnk"]/10);
                                        if(pnPage<=nNumPage){
                                            JSvBnkDataTable(pnPage);
                                        }else{
                                            JSvBnkDataTable(nNumPage);
                                        }
                                    }else{
                                        JSvBnkDataTable(1);
                                    }
                                }else{
                                    JSvBnkDataTable(1);
                                }
                            }, 500);

                        }else{
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);   
                        }
                        JSxBnkNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        });
    }
}

//Functionality : Call Bank Page Edit  
//Parameters : Event Button Click 
//Creator : 16/06/2021 Supawat
//Return : View
//Return Type : View
function JSvCallPageBankEdit(ptBnkCode){
    JCNxOpenLoading();
    $.ajax({
        type : "POST",
        url  : "bankPageEdit",
        data : {
            tBnkCode : ptBnkCode
        },
        cache: false,
        timeout: 0,
        success: function (tResult){
            if(tResult != ''){
                $('#oliBnkTitleAdd').hide();
                $('#oliBnkTitleEdit').show();
                $('#odvBtnBnkInfo').hide();
                $('#odvBtnAddEdit').show();
                $('#odvContentPageBank').html(tResult);
                // $('#oetBnkCode').addClass('xCNDisable');
                // $('#oetBnkCode').attr('readonly', true);
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

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 16/06/2021 Supawat
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

//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 16/06/2021 Supawat
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


//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Reason
//Creator: 16/06/2021 Supawat
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
