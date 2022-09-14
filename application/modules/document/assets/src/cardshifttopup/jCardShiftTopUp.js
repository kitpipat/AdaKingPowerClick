var nStaCardShiftTopUpBrowseType = $('#oetCardShiftTopUpStaBrowse').val();
var tCallCardShiftTopUpBackOption = $('#oetCardShiftTopUpCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftTopUpCardShiftTopUpNavDefult();
    if (nStaCardShiftTopUpBrowseType != 1) {
        JSvCardShiftTopUpCallPageCardShiftTopUp();
    } else {
        JSvCardShiftTopUpCallPageCardShiftTopUpAdd();
    }
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftTopUp
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftTopUpCardShiftTopUpNavDefult() {
    try{
        if (nStaCardShiftTopUpBrowseType != 1 || nStaCardShiftTopUpBrowseType == undefined) {
            $('.xCNCardShiftTopUpVBrowse').hide();
            $('.xCNCardShiftTopUpVMaster').show();
            $('#oliCardShiftTopUpTitleAdd').hide();
            $('#oliCardShiftTopUpTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftTopUpInfo').show();
        } else {
            $('#odvModalBody .xCNCardShiftTopUpVMaster').hide();
            $('#odvModalBody .xCNCardShiftTopUpVBrowse').show();
            $('#odvModalBody #odvCardShiftTopUpMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftTopUpNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftTopUpBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCardShiftTopUpBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCardShiftTopUpBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCardShiftTopUpCardShiftTopUpNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown) {
    try{
        JCNxResponseError(jqXHR, textStatus, errorThrown)
    }catch(err){
        console.log('JCNxCardShiftTopUpResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftTopUp Page list
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftTopUpCallPageCardShiftTopUp() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            localStorage.tStaPageNow = 'JSvCallPageCardShiftTopUpList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "cardShiftTopUpList",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvContentPageCardShiftTopUp').html(tResult);
                    JSvCardShiftTopUpCardShiftTopUpDataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftTopUpCallPageCardShiftTopUp Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftTopUpCardShiftTopUpDataTable(pnPage) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSearchAll      = $('#oetSearchAll').val();
            var oAdvanceSearch  = JSoCardShiftTopUpGetSearchData();
            var nPageCurrent    = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftTopUpDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftTopUp').html(tResult);
                    }
                    JSxCardShiftTopUpCardShiftTopUpNavDefult();
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); // โหลดภาษาใหม่
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftTopUpCardShiftTopUpDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftTopUp Page Add
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftTopUpCallPageCardShiftTopUpAdd() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSnCallDeleteHelperByTable("TFNTCrdTopUpTmp");
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftTopUpPageAdd",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCardShiftTopUpBrowseType == 1) {
                        $('.xCNCardShiftTopUpVMaster').hide();
                        $('.xCNCardShiftTopUpVBrowse').show();
                    } else {
                        $('.xCNCardShiftTopUpVBrowse').hide();
                        $('.xCNCardShiftTopUpVMaster').show();
                        $('#oliCardShiftTopUpTitleEdit').hide();
                        $('#oliCardShiftTopUpTitleAdd').show();
                        $('#odvBtnCardShiftTopUpInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageCardShiftTopUp').html(tResult);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftTopUpCallPageCardShiftTopUpAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftTopUp Page Edit
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftTopUpCallPageCardShiftTopUpEdit(ptCardShiftTopUpCode) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('JSvCallPageCardShiftTopUpEdit', ptCardShiftTopUpCode);
            $.ajax({
                type: "POST",
                url: "cardShiftTopUpPageEdit",
                data: {tCardShiftTopUpDocNo: ptCardShiftTopUpCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftTopUpTitleAdd').hide();
                        $('#oliCardShiftTopUpTitleEdit').show();
                        $('#odvBtnCardShiftTopUpInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftTopUp').html(tResult);
                        $('#oetCardShiftTopUpCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftTopUpCallPageCardShiftTopUpEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftTopUp
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftTopUpGenerateCardShiftTopUpCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTableName = 'TFNTCrdTopUpHD';
            var tStaDocType = '1'; // Topup Card
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName, tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftTopUpCode').val(tData.rtCthDocNo);
                        $('#oetCardShiftTopUpCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('.xCNBtnGenCode').attr('disabled', true);

                        //update docno in center
                        var tNameTableTemp = 'TFNTCrdTopUpTmp';
                        JSXUpdateDocNoCenter(tData.rtCthDocNo,tNameTableTemp);
                    } else {
                        $('#oetCardShiftTopUpCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftTopUpName').focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftTopUpGenerateCardShiftTopUpCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftTopUp Code In DB
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftTopUpCheckCardShiftTopUpCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tCode = $('#oetCardShiftTopUpCode').val();
            var tTableName = 'TFNTCrdTopUpHD';
            var tFieldName = 'FTXshDocNo';
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
                            JSvCardShiftTopUpCallPageCardShiftTopUpEdit(tCode);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftTopUpGenerateCardShiftTopUpCode();
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftTopUpCheckCardShiftTopUpCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftTopUpSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrCardShiftTopUp').find('td.otdCardShiftTopUpCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxCardShiftTopUpSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCardShiftTopUpCardShiftTopUpDelete(poElement, poEvent){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCardShiftTopUp').find('td.otdCardShiftTopUpCode').text();
        $('#ospConfirmDelete').text(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCardShiftTopUp').modal('show');
        }
    }catch(err){
        console.log('JSaCardShiftTopUpCardShiftTopUpDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCardShiftTopUpCardShiftTopUpDelChoose(){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if(nCheckedCount > 1){ // For mutiple delete

                var oChecked = $('#odvRGPList td input:checked');
                var aCardShiftTopUpCode = [];
                $(oChecked).each( function(pnIndex){
                    aCardShiftTopUpCode[pnIndex] = $(this).parents('tr.otrCardShiftTopUp').find('td.otdCardShiftTopUpCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpDeleteMulti",
                    data: {tCardShiftTopUpCode: JSON.stringify(aCardShiftTopUpCode)},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftTopUp').modal('hide');
                        JSvCardShiftTopUpCardShiftTopUpDataTable();
                        JSxCardShiftTopUpCardShiftTopUpNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }else{ // For single delete

                var tCardShiftTopUpCode = $('#ospConfirmDelete').text();

                $.ajax({
                    type: "POST",
                    url: "cardShiftTopUpDelete",
                    data: {tCardShiftTopUpCode: tCardShiftTopUpCode},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftTopUp').modal('hide');
                        JSvCardShiftTopUpCardShiftTopUpDataTable();
                        JSxCardShiftTopUpCardShiftTopUpNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftTopUpResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSnCardShiftTopUpCardShiftTopUpDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftTopUpClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftTopUp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftTopUp .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftTopUpCardShiftTopUpDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftTopUpIsCreatePage(){
    try{
        const tCardShiftTopUpCode = $('#oetCardShiftTopUpCode').data('is-created');
        var bStatus = false;
        if(tCardShiftTopUpCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftTopUpIsCreatePage Error: ', err);
    }
}

/**
 * Functionality : Is update page.
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftTopUpIsUpdatePage(){
    try{
        const tCardShiftTopUpCode = $('#oetCardShiftTopUpCode').data('is-created');
        var bStatus = false;
        if(!tCardShiftTopUpCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftTopUpIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftTopUpVisibleDelAllBtn(poElement, poEvent){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCardShiftTopUpVisibleDelAllBtn Error: ', err);
    }
}

/**
* Functionality : Show or Hide Component
* Parameters : ptComponent is element on document(id or class or...),pbVisible is visible
* Creator : 09/10/2018 piya
* Last Modified : -
* Return : -
* Return Type : -
*/
function JSxCardShiftTopUpVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCardShiftTopUpVisibleComponent Error: ', err);
    }
}



// Function: Event Single Delete Document Card Topup Single
// Parameters: Function Call Page
// Creator: 25/12/2019 Witsarut Bell
// Return: object Data Sta Delete
// ReturnType: object
function JSoCrdShifTopUpDelDocSingle(ptCurrentPage, ptCrdShifTopUpDocNo, ptBchCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
        if(typeof(ptCrdShifTopUpDocNo) != undefined && ptCrdShifTopUpDocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptCrdShifTopUpDocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvCardShifTopupModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvCardShifTopupModalDelDocSingle').modal('show');
            $('#odvCardShifTopupModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "cardTopupEventDelete",
                    data : {
                        tCrdShifTopUpDocNo : ptCrdShifTopUpDocNo,
                        tBchCode : ptBchCode
                    },
                    cache:false,
                    timeout:0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == 1){
                            $('#odvCardShifTopupModalDelDocSingle').modal('hide');
                            $('#odvCardShifTopupModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function(){
                                JSvCardShiftTopUpCardShiftTopUpDataTable(ptCurrentPage);
                            },500);
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
            FSvCMNSetMsgErrorDialog('Error Not Found Document Number !!');
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}


//Functionality: Insert Text In Modal Delete
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Witsarut(Bell)
//Return: Insert Code In Text Input
//Return Type: -
function JSxCardShifTopUpTextinModal(){
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") { } else {
        var tTextCode = "";
        for ($i = 0; $i < aArrayConvert[0].length; $i++) {
            tTextCode += aArrayConvert[0][$i].nCode;
            tTextCode += " , ";
        }

        //Disabled ปุ่ม Delete
        if (aArrayConvert[0].length > 1) {
            $(".xCNIconDel").addClass("xCNDisabled");
        }else{
            $(".xCNIconDel").removeClass("xCNDisabled");
        }

        $("#ospConfirmDelete").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
        $("#ohdConfirmIDDelete").val(tTextCode);

    }
}

//Functionality: Function Chack Value LocalStorage
//Parameters: Event Select List Branch
//Creator: 25/12/2019 Witsarut(Bell)
//Return: Duplicate/none
//Return Type: string
function JStCardShifTopupFindObjectByKey(array, key, value){
    for (var i = 0; i < array.length; i++) {
        if (array[i][key] === value) {
            return "Dupilcate";
        }
    }
    return "None";
}

//Functionality: Function Chack And Show Button Delete All
//Parameters: LocalStorage Data
//Creator: 25/12/2019 Wasin(Yoshi)
//Return: Show Button Delete All
//Return Type: -
function JSxShowButtonChoose(){
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliBtnCardTopUpDeleteAll").addClass("disabled");
    }else{
        nNumOfArr = aArrayConvert[0].length;
        if(nNumOfArr > 1){
            $("#oliBtnCardTopUpDeleteAll").removeClass("disabled");
        }else{
            $("#oliBtnCardTopUpDeleteAll").addClass("disabled");
        }
    }
}


/**
 * Functionality : Multi Delete Doc
 * Parameters : -
 * Creator : 23/11/2020 Witsarut (Bell)
 * Return : -
 * Return Type : -
 */
function JSoCardTopUpDelDocMultiple(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
        $("#odvCardTopupModalDelMultiple").modal("hide");
        JCNxOpenLoading();

        var aData = $("#ohdConfirmIDDelete").val();
        var aTexts = aData.substring(0, aData.length - 2);
        var aDataSplit = aTexts.split(" , ");
        var aDataSplitlength = aDataSplit.length;

        var aDocNo = [];
        for ($i = 0; $i < aDataSplitlength; $i++) {
            aDocNo.push(aDataSplit[$i]);
        }
        if (aDataSplitlength > 1) {
            localStorage.StaDeleteArray = "1";
            $.ajax({
                type : "POST",
                url : "cardTopupEventDeleteMulti",
                data :{
                    aDocNo: aDocNo
                },
                cache:false,
                timeout:0,
                success: function(oResult){
                    JSvCardShiftTopUpCardShiftTopUpDataTable();
                    JSxCardShiftTopUpCardShiftTopUpNavDefult();
                },
            });
        }else{
            localStorage.StaDeleteArray = "0";
            return false;
        }
    }else{
        JCNxShowMsgSessionExpired();
    }
}