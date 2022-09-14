var nStaCardShiftStatusBrowseType   = $('#oetCardShiftStatusStaBrowse').val();
var tCallCardShiftStatusBackOption  = $('#oetCardShiftStatusCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftStatusCardShiftStatusNavDefult();
    if (nStaCardShiftStatusBrowseType != 1) {
        JSvCardShiftStatusCallPageCardShiftStatus();
    } else {
        JSvCardShiftStatusCallPageCardShiftStatusAdd();
    }
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftStatus
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftStatusCardShiftStatusNavDefult() {
    try{
        if (nStaCardShiftStatusBrowseType != 1 || nStaCardShiftStatusBrowseType == undefined) {
            $('.xCNCardShiftStatusVBrowse').hide();
            $('.xCNCardShiftStatusVMaster').show();
            $('#oliCardShiftStatusTitleAdd').hide();
            $('#oliCardShiftStatusTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftStatusInfo').show();
        } else {
            $('#odvModalBody .xCNCardShiftStatusVMaster').hide();
            $('#odvModalBody .xCNCardShiftStatusVBrowse').show();
            $('#odvModalBody #odvCardShiftStatusMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftStatusNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftStatusBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCardShiftStatusBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCardShiftStatusBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCardShiftStatusCardShiftStatusNavDefult Error: ', err);
    }
}

/**
 * Functionality : Function Show Event Error
 * Parameters : Error Ajax Function
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Modal Status Error
 * Return Type : view
 */
function JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown) {
    try{
        JCNxResponseError(jqXHR, textStatus, errorThrown)
    }catch(err){
        console.log('JCNxCardShiftStatusResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftStatus Page list
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftStatusCallPageCardShiftStatus() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            localStorage.tStaPageNow = 'JSvCallPageCardShiftStatusList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "cardShiftStatusList",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvContentPageCardShiftStatus').html(tResult);
                    JSvCardShiftStatusCardShiftStatusDataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }

    }catch(err){
        console.log('JSvCardShiftStatusCallPageCardShiftStatus Error: ', err);
    }
}

/**
 * Functionality : Call Recive Data List
 * Parameters : Ajax Success Event
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftStatusCardShiftStatusDataTable(pnPage) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSearchAll      = $('#oetSearchAll').val();
            var oAdvanceSearch  = JSoCardShiftStatusGetSearchData();
            var nPageCurrent    = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent    = '1';
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftStatusDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftStatus').html(tResult);
                    }
                    JSxCardShiftStatusCardShiftStatusNavDefult();
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); // โหลดภาษาใหม่
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftStatusCardShiftStatusDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftStatus Page Add
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftStatusCallPageCardShiftStatusAdd() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSnCallDeleteHelperByTable("TFNTCrdVoidTmp");
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftStatusPageAdd",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCardShiftStatusBrowseType == 1) {
                        $('.xCNCardShiftStatusVMaster').hide();
                        $('.xCNCardShiftStatusVBrowse').show();
                    } else {
                        $('.xCNCardShiftStatusVBrowse').hide();
                        $('.xCNCardShiftStatusVMaster').show();
                        $('#oliCardShiftStatusTitleEdit').hide();
                        $('#oliCardShiftStatusTitleAdd').show();
                        $('#odvBtnCardShiftStatusInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageCardShiftStatus').html(tResult);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftStatusCallPageCardShiftStatusAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftStatus Page Edit
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftStatusCallPageCardShiftStatusEdit(ptCardShiftStatusCode) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('JSvCallPageCardShiftStatusEdit', ptCardShiftStatusCode);
            $.ajax({
                type: "POST",
                url: "cardShiftStatusPageEdit",
                data: {tCardShiftStatusDocNo: ptCardShiftStatusCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftStatusTitleAdd').hide();
                        $('#oliCardShiftStatusTitleEdit').show();
                        $('#odvBtnCardShiftStatusInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftStatus').html(tResult);
                        $('#oetCardShiftStatusCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftStatusCallPageCardShiftStatusEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftStatus
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftStatusGenerateCardShiftStatusCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTableName  = 'TFNTCrdVoidHD';
            var tStaDocType = '1'; // Change Status
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName, tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftStatusCode').val(tData.rtCvhDocNo);
                        JSXUpdateDocNoCenter(tData.rtCvhDocNo, 'TFNTCrdVoidTmp');
                        $('#oetCardShiftStatusCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('.xCNBtnGenCode').attr('disabled', true);
                    } else {
                        $('#oetCardShiftStatusCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftStatusName').focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftStatusGenerateCardShiftStatusCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftStatus Code In DB
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftStatusCheckCardShiftStatusCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tCode       = $('#oetCardShiftStatusCode').val();
            var tTableName  = 'TFNTCrdVoidHD';
            var tFieldName  = 'FTCvhDocNo';
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
                            JSvCardShiftStatusCallPageCardShiftStatusEdit(tCode);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftStatusGenerateCardShiftStatusCode();
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftStatusCheckCardShiftStatusCode Error: ', err);
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
function JSxCardShiftStatusSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrCardShiftStatus').find('td.otdCardShiftStatusCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxCardShiftStatusSetDataBeforeDelMulti Error: ', err);
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
function JSaCardShiftStatusCardShiftStatusDelete(poElement, poEvent){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        var tValue = $(poElement).parents('tr.otrCardShiftStatus').find('td.otdCardShiftStatusCode').text();
        $('#ospConfirmDelete').text(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCardShiftStatus').modal('show');
        }
    }catch(err){
        console.log('JSaCardShiftStatusCardShiftStatusDelete Error: ', err);
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
function JSnCardShiftStatusCardShiftStatusDelChoose(){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var nCheckedCount   = $('#odvRGPList td input:checked').length;
            if(nCheckedCount > 1){ // For mutiple delete

                var oChecked    = $('#odvRGPList td input:checked');
                var aCardShiftStatusCode = [];
                $(oChecked).each( function(pnIndex){
                    aCardShiftStatusCode[pnIndex] = $(this).parents('tr.otrCardShiftStatus').find('td.otdCardShiftStatusCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusDeleteMulti",
                    data: {tCardShiftStatusCode: JSON.stringify(aCardShiftStatusCode)},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftStatus').modal('hide');
                        JSvCardShiftStatusCardShiftStatusDataTable();
                        JSxCardShiftStatusCardShiftStatusNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }else{ // For single delete
                var tCardShiftStatusCode = $('#ospConfirmDelete').text();
                $.ajax({
                    type: "POST",
                    url: "cardShiftStatusDelete",
                    data: {tCardShiftStatusCode: tCardShiftStatusCode},
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvModalDelCardShiftStatus').modal('hide');
                        JSvCardShiftStatusCardShiftStatusDataTable();
                        JSxCardShiftStatusCardShiftStatusNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftStatusResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSnCardShiftStatusCardShiftStatusDelChoose Error: ', err);
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
function JSvCardShiftStatusClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftStatus .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftStatus .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftStatusCardShiftStatusDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftStatusIsCreatePage(){
    try{
        const tCardShiftStatusCode = $('#oetCardShiftStatusCode').data('is-created');
        var bStatus = false;
        if(tCardShiftStatusCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftStatusIsCreatePage Error: ', err);
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
function JCNbCardShiftStatusIsUpdatePage(){
    try{
        const tCardShiftStatusCode = $('#oetCardShiftStatusCode').data('is-created');
        var bStatus = false;
        if(!tCardShiftStatusCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftStatusIsUpdatePage Error: ', err);
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
function JSxCardShiftStatusVisibleDelAllBtn(poElement, poEvent){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCardShiftStatusVisibleDelAllBtn Error: ', err);
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
function JSxCardShiftStatusVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCardShiftStatusVisibleComponent Error: ', err);
    }
}


