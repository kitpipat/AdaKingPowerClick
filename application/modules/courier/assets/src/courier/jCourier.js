var nStaCryBrowseType   = $('#oetCryStaBrowse').val();
var tCallCryBackOption  = $('#oetCryCallBackOption').val();

$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCRYNavDefult();

    if(nStaCryBrowseType != 1){
        JSvCallPageCourierList();
    }else{
        JSvCallPageCourierAdd();
    }
});

//function : Function Clear Defult Button Product Size
//Parameters : Document Ready
//Creator : 09/07/2019 Napat(Jame)
//Return : Show Tab Menu
//Return Type : -
function JSxCRYNavDefult(){
    if(nStaCryBrowseType != 1 || nStaCryBrowseType == undefined){
        $('.xCNCryVBrowse').hide();
        $('.xCNCryVMaster').show();
        $('.xCNChoose').hide();
        $('#oliCryTitleAdd').hide();
        $('#oliCryTitleEdit').hide();
        $('#odvBtnAddEdit').hide();
        $('#odvBtnCryInfo').show();
    }else{
        $('#odvModalBody .xCNCryVMaster').hide();
        $('#odvModalBody .xCNCryVBrowse').show();
        $('#odvModalBody #odvCryMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliCryNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvCryBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNCryBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNCryBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Call Courier Page list  
//Parameters : 
//Creator :	09/07/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvCallPageCourierList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;

        localStorage.tStaPageNow = 'JSvCallPageCourierList';
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "courierList",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageCourier').html(tResult);
                JSxCRYNavDefult();
                JSvCallPageCourierDataTable(nPageCurrent);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Call Courier Data List
//Parameters: Ajax Success Event 
//Creator:	09/07/2019 Napat(Jame)
//Return: View
//Return Type: View
function JSvCallPageCourierDataTable(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        var tSearchAll      = $('#oetSearchAll').val();
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "courierDataTable",
            data: {
                nPageCurrent         : nPageCurrent,
                tSearchAll           : tSearchAll
            },
            cache: false,
            Timeout: 0,
            success: function(tResult){
                if (tResult != "") {
                    $('#odvContentCourierData').html(tResult);
                }
                JSxCRYNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMCourier_L');
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


// Functionality : เปลี่ยนหน้า pagenation
// Parameters : Event Click Pagenation
// Creator : 25/02/2019 wasin(Yoshi)
// Return : View
// Return Type : View
function JSvCRYClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCourier .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCourier .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCallPageCourierDataTable(nPageCurrent);
    $('.xWCRYBTNBackPage').attr('data-page',nPageCurrent);
    $('.xWCRYBTNBackPage').data('page',nPageCurrent);
    // $('#ohdPdtCurrentPageDataTable').val(nPageCurrent);
}

//Functionality : Call Courier Page Add/Edit  
//Parameters : -
//Creator : 09/07/2019 Napat(Jame)
//Return : View
//Return Type : View
function JSvCallPageCourierAdd() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "courierPageAdd",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaCryBrowseType == 1) {
                    $('.xCNCryVMaster').hide();
                    $('.xCNCryVBrowse').show();
                } else {
                    $('.xCNCryVBrowse').hide();
                    $('.xCNCryVMaster').show();
                    $('#oliCryTitleEdit').hide();
                    $('#oliCryTitleAdd').show();
                    $('#odvBtnCryInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                // $('#obtBarSubmitCpn').show();
                $('#odvContentPageCourier').html(tResult);
                $('#oetCryCode').attr('readonly',true);
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

// Function: Call Product Page Edit  
// Parameters:  Event Click Add Button 
// Creator:	01/02/2019 wasin(Yoshi)
// Return: View
// Return Type: View
function JSvCallPageCourierEdit(ptCryCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageCourierEdit',ptCryCode);
        $.ajax({
            type: "POST",
            url: "courierPageEdit",
            data:{ ptCryCode : ptCryCode },
            cache: false,
            timeout: 0,
            async: false,
            success: function(oResult){
                var aReturnData = JSON.parse(oResult);
                if(aReturnData['nStaEvent'] == 1){
                    $('#oliCryTitleAdd').hide();
                    $('#odvBtnCryInfo').hide();

                    $('#oliCryTitleEdit').show();
                    $('#odvBtnAddEdit').show();

                    $('.xCNBtngroup').show();

                    $('#odvContentPageCourier').html(aReturnData['tCryPageAdd']);
                    $('#odvContentCourierAddress').html(aReturnData['tCryAddressPage']);
                    $('#oetCryCode').attr('readonly',true);
                    $('.xWAutoGenerate').hide();
                }else{
                    var tMessageError   = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
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

//Functionality : Event Add/Edit Sale Price Adj
//Parameters : From Submit
//Creator : 21/02/2019 Napat(Jame)
//Return : Status Event Add/Edit
//Return Type : object
function JSoEventCourierAddEdit(ptRoute){
    console.log('JSoEventCourierAddEdit');
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmCourierAdd').validate({
            rules: {
                oetCryName         :    "required",
                oetCryTaxNo     : {
                    "required": {
                        depends: function (oElement) {
                            if($('#ocmCryBusiness').val() != 1){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                oetCryCardID     : {
                    "required": {
                        depends: function (oElement) {
                            if($('#ocmCryBusiness').val() != 2){
                                return false;
                            }else{
                                return true;
                            }
                        }
                    }
                },
                oetCryCode         : {
                    "required": {
                        depends: function (oElement) {
                            if(ptRoute == "courierEventAdd") {
                                if($('#ocbCryStaAutoGenCode').is(':checked')){
                                    // console.log('oetCryCode if');
                                    return false;
                                }else{
                                    // console.log('oetCryCode else(2)');
                                    return true;
                                }
                            }else{
                                // console.log('oetCryCode else(1)');
                                return false;
                            }
                        }
                    }
                }
            },
            messages: {
                oetCryName   : $('#oetCryName').data('validate'),
                oetCryCode   : $('#oetCryCode').data('validate'),
                oetCryCardID : $('#oetCryCardID').data('validate'),
                oetCryTaxNo  : $('#oetCryTaxNo').data('validate'),
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
                // console.log($('#ofmCourierAdd').serializeArray());
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: ptRoute,
                    data: $('#ofmCourierAdd').serialize(),
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if(nStaCryBrowseType != 1) {
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageCourierEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageCourierAdd();
                                        break;
                                    case '3':
                                        JSvCallPageCourierList();
                                        break;
                                    default:
                                        JSvCallPageCourierEdit(aReturn['tCodeReturn']);
                                }
                                JCNxImgWarningMessage(aReturn['aImgReturn']);
                            }else{
                                alert(aReturn['tStaMessg']);
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
    }else{
        JCNxShowMsgSessionExpired();
    }
}

// Functionality: Function Chack And Show Button Delete All
// Parameters: LocalStorage Data
// Creator : 25/02/2019 wasin(Yoshi)
// Return: - 
// Return Type: -
function JSxShowButtonChoose(){
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

// Functionality: Insert Text In Modal Delete
// Parameters: LocalStorage Data
// Creator : 25/02/2019 wasin(Yoshi)
// Return: -
// Return Type: -
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

// Functionality: Function Chack Value LocalStorage
// Parameters: Event Select List Reason
// Creator: 25/02/2019 wasin(Yoshi)
// Return: Duplicate/none
// Return Type: string
function findObjectByKey(array, key, value) {
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return 'Dupilcate';
        }
    }
    return 'None';
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoEventCourierDelete(pnPage,ptCode,ptName){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(" , ");
        var aDataSplitlength    = aDataSplit.length;

        if (aDataSplitlength == '1'){
            $('#odvModalDelCourier').modal('show');
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + ptCode + '(' + ptName + ') ' + $('#oetTextComfirmDeleteYesOrNot').val());
            $('#osmConfirm').on('click', function(evt){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "courierEventDelete",
                    data: { 'tIDCode': ptCode },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == 1){
                            $('#odvModalDelCourier').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            $('#ospConfirmDelete').text();
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            JSvCallPageCourierDataTable(pnPage);
                        }else{
                            alert(aReturn['tStaMessg']);                     
                        }
                        JCNxCloseLoading();
                        JSxCRYNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Functionality : Event Single Delete
//Parameters : Event Icon Delete
//Creator : 17/10/2018 witsarut
//Return : object Status Delete
//Return Type : object
function JSoEventCourierDeleteMulti(pnPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        var aData       = $('#ohdConfirmIDDelete').val();
        var aTexts      = aData.substring(0, aData.length - 2);
        var aDataSplit  = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1){
            localStorage.StaDeleteArray = '1';

            $.ajax({
                type: "POST",
                url: "courierEventDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        setTimeout(function() {
                            $('#odvModalDelCourier').modal('hide');
                            $('body').removeClass('modal-open');
                            $('.modal-backdrop').remove();
                            $('#ospConfirmDelete').text();
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.modal-backdrop').remove();

                            JSvCallPageCourierDataTable(pnPage);
                        }, 500);
                    }else{
                        alert(aReturn['tStaMessg']);
                    }
                    JCNxCloseLoading();
                    JSxCRYNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            localStorage.StaDeleteArray = '0';
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Courier Control Birtday date and Sex Select
//Parameters: value text
//Creator:	18/07/2562 Napat(Jame)
//Return: -
//Return Type: -
function JSxCourierControlSex(ptValue){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        if(ptValue == '2'){
            $('.xWCrySexControl').removeClass('xCNHide');
            $('.xWCryDobControl').removeClass('xCNHide');
            
        }else{
            $('.xWCrySexControl').addClass('xCNHide');
            $('.xWCryDobControl').addClass('xCNHide');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//function: Courier Control Branch Select
//Parameters: value text
//Creator:	18/07/2562 Napat(Jame)
//Return: -
//Return Type: -
function JSxCourierControlBranch(ptValue){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        if(ptValue == '2'){
            $('.xWCryBchControl').removeClass('xCNHide');
        }else{
            $('.xWCryBchControl').addClass('xCNHide');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}