var nStaSpnBrowseType = $('#oetSpnStaBrowse').val();
var tCallSpnBackOption = $('#oetSpnCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxDPTNavDefult();
    if (nStaSpnBrowseType != 1) {
        JSvCallPageSalePerson(1);
    } else {
        JSvCallPageSalePersonAdd();
    }
});



/**
 * Functionality : Function Clear Defult Button SalePerson
 * Parameters : -
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxDPTNavDefult() {
    try{
        if (nStaSpnBrowseType != 1 || nStaSpnBrowseType == undefined) {
            $('.xCNSpnVBrowse').hide();
            $('.xCNSpnVMaster').show();
            $('#oliSpnTitleAdd').hide();
            $('#oliSpnTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnSpnInfo').show();
        } else {
            $('#odvModalBody .xCNSpnVMaster').hide();
            $('#odvModalBody .xCNSpnVBrowse').show();
            $('#odvModalBody #odvSpnMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliSpnNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvSpnBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNSpnBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNSpnBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxDPTNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
    try{
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
    }catch(err){
        console.log('JCNxResponseError Error: ', err);
    }
}

/**
 * Functionality : Call SalePerson Page list
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSalePerson(pnPage) {
    var  nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' &&  nStaSession == 1){
        localStorage.tStaPageNow = 'JSvCallPageSalePersonList';
        $('#oetSearchAll').val('');
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "salepersonList",
            cache: false,
            data:{
                nPageCurrent : pnPage,
            },
            timeout: 0,
            success: function(tResult) {
                $('#odvContentPageSalePerson').html(tResult);
                JSvSalePersonDataTable(pnPage);
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
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 28/08/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvSalePersonDataTable(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1 ){
        var tSearchAll = $('#oetSearchAll').val();
        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        // JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "salepersonDataTable",
            data: {
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                if (tResult != "") {
                    $('#ostDataSalePerson').html(tResult);
                }
                JSxDPTNavDefult();
                JCNxLayoutControll();
                JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); //โหลดภาษาใหม่
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

/**
 * Functionality : Call SalePerson Page Add
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSalePersonAdd() {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('', '');
        $.ajax({
            type: "POST",
            url: "salepersonPageAdd",
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (nStaSpnBrowseType == 1) {
                    $('.xCNSpnVMaster').hide();
                    $('.xCNSpnVBrowse').show();
                } else {
                    $('.xCNSpnVBrowse').hide();
                    $('.xCNSpnVMaster').show();
                    $('#oliSpnTitleEdit').hide();
                    $('#oliSpnTitleAdd').show();
                    $('#odvBtnSpnInfo').hide();
                    $('#odvBtnAddEdit').show();
                }
                $('#odvContentPageSalePerson').html(tResult);
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageSalePersonAdd Error: ', err);
    }
}

/**
 * Functionality : Call SalePerson Page Edit
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageSalePersonEdit(ptSpnCode) {
    try{
        JCNxOpenLoading();
        JStCMMGetPanalLangSystemHTML('JSvCallPageSalePersonEdit', ptSpnCode);

        $.ajax({
            type: "POST",
            url: "salepersonPageEdit",
            data: { tSpnCode: ptSpnCode },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                if (tResult != '') {
                    $('#oliSpnTitleAdd').hide();
                    $('#oliSpnTitleEdit').show();
                    $('#odvBtnSpnInfo').hide();
                    $('#odvBtnAddEdit').show();
                    $('#odvContentPageSalePerson').html(tResult);
                    $('#oetSpnCode').addClass('xCNDisable');
                    $('.xCNDisable').attr('readonly', true);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }catch(err){
        console.log('JSvCallPageSalePersonEdit Error: ', err);
    }
}

/**
 * Functionality : Check SalePerson Code In DB
 * Parameters : {params}
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCheckSalePersonCode() {
    try{
        var tCode = $('#oetSpnCode').val();
        var tTableName = 'TCNMSpn';
        var tFieldName = 'FTSpnCode';
        if (tCode != '') {
            $.ajax({
                type: "POST",
                url: "CheckInputGenCode",
                data: {
                    tTableName: tTableName,
                    tFieldName: tFieldName,
                    tCode: tCode
                },
                cache: false,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    $('.btn-default').attr('disabled', true);
                    if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                        alert('มี id นี้แล้วในระบบ');
                        JSvCallPageSalePersonEdit(tCode);
                    } else {
                        alert('ไม่พบระบบจะ Gen ใหม่');
                        JStGenerateSalePersonCode();
                    }
                    $('.wrap-input100').removeClass('alert-validate');
                    $('.btn-default').attr('disabled', false);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    }catch(err){
        console.log('JStCheckSalePersonCode Error: ', err);
    }
}


/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 27/08/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaSalePersonDelete(tCurrentPage,tDelCode,tDelName){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        var aData               = $('#ohdConfirmIDDelete').val();
        var aTexts              = aData.substring(0, aData.length - 2);
        var aDataSplit          = aTexts.split(",");
        var aDataSplitlength    = aDataSplit.length;
        var aNewIdDelete        = [];
        if (aDataSplitlength == '1'){
            //tDelName
            $('#ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + tDelCode+' ('+tDelName+')');
            $('#odvModalDelSalePerson').modal('show');
            $('#osmConfirm').on('click', function(evt){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "salepersonDelete",
                    data: { 'tIDCode': tDelCode},
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturn = JSON.parse(oResult);
                        if (aReturn['nStaEvent'] == '1'){
                            $('#odvModalDelSalePerson').modal('hide');
                            $('#ospConfirmDelete').empty();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                if(aReturn["nNumRowSpnLoc"]!= 0){
                                    if(aReturn["nNumRowSpnLoc"]> 10){
                                        nNumPage = Math.ceil(aReturn["nNumRowSpnLoc"]/10);
                                        if(tCurrentPage<=nNumPage){
                                            JSvCallPageSalePerson(tCurrentPage);
                                        }else{
                                            JSvCallPageSalePerson(nNumPage);
                                        }
                                    }else{
                                        JSvCallPageSalePerson(1);
                                    }
                                }else{
                                    JSvCallPageSalePerson(1);
                                }
                            },500);
                        }else{
                            JCNxOpenLoading();
                            alert(aReturn['tStaMessg']);
                        }
                        JSxDPTNavDefult();
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


//Functionality: Event Multi Delete Card
//Parameters: Event Button Delete All
//Creator: 10/10/2018 wasin
//Return:  object Status Delete
//Return Type: object
function JSnSalePersonDelChoose(tCurrentPage){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxOpenLoading();
        // var aData               = $('#ohdConfirmIDDelete').val();
        // var aTexts              = aData.substring(0, aData.length - 2);
        // var aDataSplit          = aTexts.split(" , ");
        // var aDataSplitlength    = aDataSplit.length;
        // var aNewIdDelete        = [];

        var aData = $('#ohdConfirmIDDelete').val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;
        var aNewIdDelete = [];

        for ($i = 0; $i < aDataSplitlength; $i++) {
            aNewIdDelete.push(aDataSplit[$i]);
        }

        if (aDataSplitlength > 1){
            localStorage.StaDeleteArray = '1';
            $.ajax({
                type: "POST",
                url: "salepersonDelete",
                data: { 'tIDCode': aNewIdDelete },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aReturn = JSON.parse(oResult);
                    if (aReturn['nStaEvent'] == 1) {
                        JSxDPTNavDefult();
                        setTimeout(function() {
                            $('#odvModalDelSalePerson').modal('hide');
                            JSvSalePersonDataTable(tCurrentPage);
                            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteSingle').val());
                            $('#ohdConfirmIDDelete').val('');
                            localStorage.removeItem('LocalItemData');
                            $('.obtChoose').hide();
                            $('.modal-backdrop').remove();
                            if(aReturn["nNumRowSpnLoc"]!= 0){
                                if(aReturn["nNumRowSpnLoc"]> 10){
                                    nNumPage = Math.ceil(aReturn["nNumRowSpnLoc"]/10);
                                    if(tCurrentPage<=nNumPage){
                                        JSvCallPageSalePerson(tCurrentPage);
                                    }else{
                                        JSvCallPageSalePerson(nNumPage);
                                    }
                                }else{
                                    JSvCallPageSalePerson(1);
                                }
                            }else{
                                JSvCallPageSalePerson(1);
                            }

                        },1000);
                    }else{
                        JCNxOpenLoading();
                        alert(aReturn['tStaMessg']);
                    }
                    JSxDPTNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                    // JCNxCloseLoading();
                }
            });
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}


//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 17/09/2018 wasin
//Return : View
//Return Type : View
function JSvSalePersonClickPage(ptPage){
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageSalePerson .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageSalePerson .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvSalePersonDataTable(nPageCurrent);
}


/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 31/08/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNSalePersonIsCreatePage(){
    try{
        const tSpnCode = $('#oetSpnCode').data('is-created');
        var bStatus = false;
        if(tSpnCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNSalePersonIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 24/10/2018 piya
 * Last Modified : -
 * Return : Status true is update page
 * Return Type : Boolean
 */
function JCNSalePersonIsUpdatePage(){
    try{
        const tSpnCode = $('#oetSpnCode').data('is-created');
        var bStatus = false;
        if(tSpnCode != ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNSalePersonIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxSalePersonVisibledDelAllBtn(poElement = null, poEvent = null){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch(err){
        console.log('JSxSalePersonVisibledDelAllBtn Error: ', err);
    }
}

/**
 * Functionality : Show or hide reference mode(select branch or shop level)
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 03/09/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxVisibledRefMode(poElement = null, poEvent = null){
    try{
        let tMode = $(poElement).val();
        if(tMode == 1){ // Branch level
            $('#xWBranchMode').show();
            $('#xWShopMode').hide();
        }
        if(tMode == 2){ // Shop level
            $('#xWBranchMode').hide();
            $('#xWShopMode').show();
        }
    }catch(err){
        console.log('JSxVisibledRefMode Error: ', err);
    }
}


//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 11/10/2018 wasin
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
//Creator: 11/10/2018 wasin
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
//Creator: 11/10/2018 wasin
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

//Functionality : Event Add/Edit Card
//Parameters : From Submit
//Creator : 10/10/2018 wasin
//Return : Status Event Add/Edit Card
//Return Type : object
function JSnAddEditSalePerson(ptRoute){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        $('#ofmAddSalePerson').validate().destroy();
        $.validator.addMethod('dublicateCode', function(value, element) {
            if(ptRoute == "salepersonEventAdd"){
                if($("#ohdCheckDuplicateSpnCode").val() == 1){
                    return false;
                }else{
                    return true;
                }
            }else{
                return true;
            }
        },'');
        $('#ofmAddSalePerson').validate({
            rules: {
                oetSpnCode:     {
                    "required": {
                        depends: function(oElement) {
                            if(ptRoute == "salepersonEventAdd"){
                                if($('#ocbSalePersonAutoGenCode').is(':checked')){
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
                oetSpnName:     {"required" :{}},
                oetSpnEmail:    {"required" :{}},
            },
            messages: {
                oetSpnCode : {
                    "required"      : $('#oetSpnCode').attr('data-validate-required'),
                    "dublicateCode" : $('#oetSpnCode').attr('data-validate-dublicateCode')
                },
                oetSpnName : {
                    "required"      : $('#oetSpnName').attr('data-validate-required'),
                },
                oetSpnEmail: {
                    "required"      : $('#oetSpnEmail').attr('data-validate-required'),
                }
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
                    data: $('#ofmAddSalePerson').serialize(),
                    success: function(oResult){
                        if(nStaSpnBrowseType != 1) {
                            var aReturn = JSON.parse(oResult);
                            if(aReturn['nStaEvent'] == 1){
                                switch(aReturn['nStaCallBack']) {
                                    case '1':
                                        JSvCallPageSalePersonEdit(aReturn['tCodeReturn']);
                                        break;
                                    case '2':
                                        JSvCallPageSalePersonAdd();
                                        break;
                                    case '3':
                                        JSvCallPageSalePerson();
                                        break;
                                    default:
                                        JSvCallPageSalePersonEdit(aReturn['tCodeReturn']);
                                }
                            }else{
                                JCNxCloseLoading();
                                FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
                            }
                        }else{
                            JCNxCloseLoading();
                            JCNxBrowseData(tCallSpnBackOption);
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

// Functionality: Function Check Is Create Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSalePersonIsCreatePage(){
    try{
        const tSpnCode = $('#oetSpnCode').data('is-created');    
        var bStatus = false;
        if(tSpnCode == "" || tSpnCode === undefined){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSalePersonIsCreatePage Error: ', err);
    }
}

// Functionality: Function Check Is Update Page
// Parameters: Event Documet Redy
// Creator: 22/03/2019 wasin(Yoshi)
// Return: object Status Delete
// ReturnType: boolean
function JSbSalePersonIsUpdatePage(){
    try{
        const tSpnCode = $('#oetSpnCode').data('is-created');
        var bStatus = false;
        if(!tSpnCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JSbSalePersonIsUpdatePage Error: ', err);
    }
}

// Functionality : Show or Hide Component
// Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
// Creator : 22/03/2019 Wasin (Yoshi)
// Return : -
// Return Type : -
function JSxSalePersonVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            // $(ptComponent).removeClass('hidden');
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxSalePersonVisibleComponent Error: ', err);
    }
}


