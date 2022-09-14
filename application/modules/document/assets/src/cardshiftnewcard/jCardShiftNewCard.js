var nStaCardShiftNewCardBrowseType      = $('#ohdCardShiftNewCardBrowseType').val();
var tCallCardShiftNewCardBrowseOption   = $('#ohdCardShiftNewCardBrowseOption').val();

/*============================= Begin Auto Run ===============================*/
$('document').ready(function(){
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftNewCardNavDefult();
    if (nStaCardShiftNewCardBrowseType!= 1) {
        JSvCallPageCardShiftNewCardList();
    }else{
        JSvCallPageCardShiftNewCardAdd();
    }
});
/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftNewCards
 * Parameters : -
 * Creator : 03/12/2018 Wasin(Yoshi)
 * Last Modified : -
 * Return : Reset Nav Menu
 * Return Type : None
*/
function JSxCardShiftNewCardNavDefult(){
    try{
        if (nStaCardShiftNewCardBrowseType!= 1 || nStaCardShiftNewCardBrowseType== undefined) {
            $('#oliCardShiftNewCardTitleAdd').hide();
            $('#oliCardShiftNewCardTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftNewCardInfo').show();
        } else {
            $('#odvModalBody #odvCardShiftNewCardMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftNewCardNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftNewCardBtnGroup').css('padding', '0');
            // $('#odvModalBody .xCNCardShiftNewCardBrowseLine').css('padding', '0px 0px');
            // $('#odvModalBody .xCNCardShiftNewCardBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
     }catch(err){
        console.log('JSxCardShiftChangeCardShiftChangeNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 03/12/2018 Wasin(Yoshi)
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
*/
function JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown) {
    try{
        JCNxResponseError(jqXHR, textStatus, errorThrown)
    }catch(err){
        console.log('JCNxCardShiftNewCardResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftNewCards Page list
 * Parameters : {params}
 * Creator : 03/12/2018 Wasin(Yoshi)
 * Last Modified : -
 * Return : view
 * Return Type : view
*/
function JSvCallPageCardShiftNewCardList(){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            localStorage.tStaPageNow = 'JSvCallPageCardShiftNewCardList';
            $('#oetSearchCardShiftNewCard').val('');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftNewCardList",
                cache: false,
                timeout: 0,
                success: function (tResult) {
                    $('#odvContentPageCardShiftNewCard').html(tResult);
                    JSvCardShiftNewCardDataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCallPageCardShiftNewCardList Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftNewCard Data List
 * Parameters : Ajax Success Event
 * Creator : 03/12/2018 Wasin(Yoshi)
 * Last Modified : -
 * Return : view
 * Return Type : view
*/
function JSvCardShiftNewCardDataTable(pnPage){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var tSearchAll      = $('#oetSearchCardShiftNewCard').val();
            var oAdvanceSearch  = JSoCardShiftNewCardGetSearchData();
            var nPageCurrent    = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            $.ajax({
                type: "POST",
                url: "cardShiftNewCardDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftNewCard').html(tResult);
                    }
                    JSxCardShiftNewCardNavDefult();
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftNewCardDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftNewCard Page Add
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCallPageCardShiftNewCardAdd() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSnCallDeleteHelperByTable("TFNTCrdImpTmp");
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftNewCardPageAdd",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCardShiftNewCardBrowseType == 1) {
                        $('#odvModalBodyBrowse').html(tResult);
                        $('#odvModalBodyBrowse .panel-body').css('padding-top','0');
                    } else {
                        $('#oliCardShiftNewCardTitleEdit').hide();
                        $('#oliCardShiftNewCardTitleAdd').show();
                        $('#odvBtnCardShiftNewCardInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('odvContentPageCardShiftNewCard').removeClass("panel panel-headline");
                        $('#odvContentPageCardShiftNewCard').html(tResult);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftNewCardCallPageCardShiftNewCardAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftNewCard Page Edit
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftNewCardCallPageCardShiftNewCardEdit(ptCardShiftNewCardCode) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('JSvCallPageCardShiftNewCardEdit', ptCardShiftNewCardCode);
            $.ajax({
                type: "POST",
                url: "cardShiftNewCardPageEdit",
                data: {tCardShiftNewCardDocNo: ptCardShiftNewCardCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftNewCardTitleAdd').hide();
                        $('#oliCardShiftNewCardTitleEdit').show();
                        $('#odvBtnCardShiftNewCardInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftNewCard').html(tResult);
                        $('#oetCardShiftNewCardCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftNewCardCallPageCardShiftNewCardEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftNewCard
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftNewCardGenerateCardShiftNewCardCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var tTableName  = 'TFNTCrdImpHD';
            var tStaDocType = '1'; // New Card
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName, tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var tData = $.parseJSON(oResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftNewCardCode').val(tData.rtCihDocNo);
                        JSXUpdateDocNoCenter(tData.rtCihDocNo, 'TFNTCrdImpTmp');
                        $('#oetCardShiftNewCardCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('#obtGenCodeCardShiftNewCard').attr('disabled', true);
                    } else {
                        $('#oetCardShiftNewCardCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftNewCardName').focus();

                    //update docno in center
                    var tNameTableTemp = 'TFNTCrdImpTmp';
                    JSXUpdateDocNoCenter(tData.rtCihDocNo,tNameTableTemp);
                    
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftNewCardGenerateCardShiftNewCardCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftNewCard Code In DB
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftNewCardCheckCardShiftNewCardCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tCode = $('#oetCardShiftNewCardCode').val();
            var tTableName = 'TFNTCrdShiftHD';
            var tFieldName = 'FTCshDocNo';
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
                    timeout: 0,
                    success: function(tResult) {
                        var tData = $.parseJSON(tResult);
                        $('.btn-default').attr('disabled', true);
                        if (tData.rtCode == '1') { //มี Code นี้ในระบบแล้ว จะส่งไปหน้า Edit
                            alert('มี id นี้แล้วในระบบ');
                            JSvCardShiftNewCardCallPageCardShiftNewCardEdit(tCode);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftNewCardGenerateCardShiftNewCardCode();
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftNewCardCheckCardShiftNewCardCode Error: ', err);
    }
}

/**
 * Functionality : Set data on select multiple, use in table list main page
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftNewCardSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked    = $('#odvRGPList td input:checked');
        var tValue      = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrCardShiftNewCard').find('td.otdCardShiftNewCardCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxCardShiftNewCardSetDataBeforeDelMulti Error: ', err);
    }
}

/**
 * Functionality : Delete one select
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSaCardShiftNewCardCardShiftNewCardDelete(poElement, poEvent){
    try{
        var nCheckedCount   = $('#odvRGPList td input:checked').length;
        var tValue          = $(poElement).parents('tr.otrCardShiftNewCard').find('td.otdCardShiftNewCardCode').text();
        $('#ospConfirmDelete').text(tValue);
        if(nCheckedCount <= 1){
            $('#odvModalDelCardShiftNewCard').modal('show');
        }
    }catch(err){
        console.log('JSaCardShiftNewCardCardShiftNewCardDelete Error: ', err);
    }
}

/**
 * Functionality : Confirm delete
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSnCardShiftNewCardCardShiftNewCardDelChoose(){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if(nCheckedCount > 1){ // For mutiple delete

                var oChecked = $('#odvRGPList td input:checked');
                var aCardShiftNewCardCode = [];
                $(oChecked).each( function(pnIndex){
                    aCardShiftNewCardCode[pnIndex] = $(this).parents('tr.otrCardShiftNewCard').find('td.otdCardShiftNewCardCode').text();
                });
                $.ajax({
                    type: "POST",
                    url: "CardShiftNewCardDeleteMulti",
                    data: {tCardShiftNewCardCode: JSON.stringify(aCardShiftNewCardCode)},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftNewCard').modal('hide');
                        JSvCardShiftNewCardDataTable();
                        JSxCardShiftNewCardCardShiftNewCardNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{ // For single delete
                var tCardShiftNewCardCode = $('#ospConfirmDelete').text();
                $.ajax({
                    type: "POST",
                    url: "CardShiftNewCardDelete",
                    data: {tCardShiftNewCardCode: tCardShiftNewCardCode},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftNewCard').modal('hide');
                        JSvCardShiftNewCardDataTable();
                        JSxCardShiftNewCardCardShiftNewCardNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftNewCardResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSnCardShiftNewCardCardShiftNewCardDelChoose Error: ', err);
    }
}

/**
 * Functionality : Pagenation changed
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftNewCardClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftNewCard .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftNewCard .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftNewCardDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftNewCardIsCreatePage(){
    try{
        var tCardShiftNewCardCode   = $('#oetCardShiftNewCardCode').data('is-created');
        var bStatus = false;
        if(tCardShiftNewCardCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftNewCardIsCreatePage Error: ', err);
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
function JCNbCardShiftNewCardIsUpdatePage(){
    try{
        var tCardShiftNewCardCode   = $('#oetCardShiftNewCardCode').data('is-created');
        var bStatus = false;
        if(!tCardShiftNewCardCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftNewCardIsUpdatePage Error: ', err);
    }
}

/**
 * Functionality : Show or hide delete all button
 * Show on multiple selections, Hide on one or none selection 
 * Use in table list main page
 * Parameters : poElement is Itself element, poEvent is Itself event
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftNewCardVisibleDelAllBtn(poElement, poEvent){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCardShiftNewCardVisibleDelAllBtn Error: ', err);
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
function JSxCardShiftNewCardVisibleComponent(ptComponent, pbVisible, ptEffect){
    try{
        if(pbVisible == false){
            $(ptComponent).addClass('hidden');
        }
        if(pbVisible == true){
            $(ptComponent).removeClass('hidden fadeIn animated').addClass('fadeIn animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend',function(){
                $(this).removeClass('hidden fadeIn animated');
            });
        }
    }catch(err){
        console.log('JSxCardShiftNewCardVisibleComponent Error: ', err);
    }
}


// Function: Event Single Delete Document Card ShifNew Card Single
// Parameters: Function Call Page
// Creator: 25/12/2019 WitsarutBell
// Return: object Data Sta Delete
// ReturnType: object
function JSoCrdShifNewCardDelDocSingle(ptCurrentPage, ptCrdShifNewCardDocNo, ptBchCode){
    var nStaSession = JCNxFuncChkSessionExpired(); 
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
        if(typeof(ptCrdShifNewCardDocNo) != undefined && ptCrdShifNewCardDocNo != ""){
            var tTextConfrimDelSingle   = $('#oetTextComfirmDeleteSingle').val()+"&nbsp"+ptCrdShifNewCardDocNo+"&nbsp"+$('#oetTextComfirmDeleteYesOrNot').val();
            $('#odvCardShifNewCardModalDelDocSingle #ospTextConfirmDelSingle').html(tTextConfrimDelSingle);
            $('#odvCardShifNewCardModalDelDocSingle').modal('show');
            $('#odvCardShifNewCardModalDelDocSingle #osmConfirmDelSingle').unbind().click(function(){
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url : "dcmCardShifNewCardEventDelete",
                    data : {
                        tCrdShifNewCardDocNo  :  ptCrdShifNewCardDocNo,
                        tBchCode : ptBchCode
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult){
                        var aReturnData = JSON.parse(oResult);
                        if(aReturnData['nStaEvent'] == 1){
                            $('#odvCardShifNewCardModalDelDocSingle').modal('hide');
                            $('#odvCardShifNewCardModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function(){
                                JSvCardShiftNewCardDataTable(ptCurrentPage);
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
function JSxCardShifNewCardTextinModal(){
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
        } else {
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
function JStCardShifNewCardFindObjectByKey(array, key, value) {
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
function JSxShowButtonChoose() {
    var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        $("#oliCardShifNewCardBtnDeleteAll").addClass("disabled");
    } else {
        nNumOfArr = aArrayConvert[0].length;
        if (nNumOfArr > 1) {
            $("#oliCardShifNewCardBtnDeleteAll").removeClass("disabled");
        } else {
            $("#oliCardShifNewCardBtnDeleteAll").addClass("disabled");
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
function JSoCardShifNewCardDelDocMultiple(ptBchCode){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== "undefined" && nStaSession == 1){
        $("#odvCardShifNewCardModalDelMultiple").modal("hide");
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
                type: "POST",
                url : "dcmCardShifNewCardEventDeleteMulti",
                data: {
                    aDocNo: aDocNo
                },
                success: function(tResult) {
                    JSvCardShiftNewCardDataTable();
                    JSxCardShiftNewCardNavDefult();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            localStorage.StaDeleteArray = "0";
            return false;
        }
    }else {
        JCNxShowMsgSessionExpired();
    }
}