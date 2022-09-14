var nStaCardShiftChangeBrowseType = $('#oetCardShiftChangeStaBrowse').val();
var tCallCardShiftChangeBackOption = $('#oetCardShiftChangeCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftChangeCardShiftChangeNavDefult();
    if (nStaCardShiftChangeBrowseType != 1) {
        JSvCardShiftChangeCallPageCardShiftChange();
    } else {
        JSvCardShiftChangeCallPageCardShiftChangeAdd();
    }
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftChange
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftChangeCardShiftChangeNavDefult() {
    try{
        if (nStaCardShiftChangeBrowseType != 1 || nStaCardShiftChangeBrowseType == undefined) {
            $('.xCNCardShiftChangeVBrowse').hide();
            $('.xCNCardShiftChangeVMaster').show();
            $('#oliCardShiftChangeTitleAdd').hide();
            $('#oliCardShiftChangeTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftChangeInfo').show();
        } else {
            $('#odvModalBody .xCNCardShiftChangeVMaster').hide();
            $('#odvModalBody .xCNCardShiftChangeVBrowse').show();
            $('#odvModalBody #odvCardShiftChangeMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftChangeNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftChangeBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCardShiftChangeBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCardShiftChangeBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCardShiftChangeCardShiftChangeNavDefult Error: ', err);
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
function JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown) {
    try{
        JCNxResponseError(jqXHR, textStatus, errorThrown)
    }catch(err){
        console.log('JCNxCardShiftChangeResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftChange Page list
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftChangeCallPageCardShiftChange() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            localStorage.tStaPageNow = 'JSvCallPageCardShiftChangeList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "cardShiftChangeList",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvContentPageCardShiftChange').html(tResult);
                    JSvCardShiftChangeCardShiftChangeDataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftChangeCallPageCardShiftChange Error: ', err);
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
function JSvCardShiftChangeCardShiftChangeDataTable(pnPage) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSearchAll = $('#oetSearchAll').val();
            var oAdvanceSearch = JSoCardShiftChangeGetSearchData();
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftChangeDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftChange').html(tResult);
                    }
                    JSxCardShiftChangeCardShiftChangeNavDefult();
                    JCNxLayoutControll();
                    JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); // โหลดภาษาใหม่
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftChangeCardShiftChangeDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftChange Page Add
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftChangeCallPageCardShiftChangeAdd() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSnCallDeleteHelperByTable("TFNTCrdVoidTmp");
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftChangePageAdd",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCardShiftChangeBrowseType == 1) {
                        $('.xCNCardShiftChangeVMaster').hide();
                        $('.xCNCardShiftChangeVBrowse').show();
                    } else {
                        $('.xCNCardShiftChangeVBrowse').hide();
                        $('.xCNCardShiftChangeVMaster').show();
                        $('#oliCardShiftChangeTitleEdit').hide();
                        $('#oliCardShiftChangeTitleAdd').show();
                        $('#odvBtnCardShiftChangeInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageCardShiftChange').html(tResult);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftChangeCallPageCardShiftChangeAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftChange Page Edit
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftChangeCallPageCardShiftChangeEdit(ptCardShiftChangeCode) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML('JSvCallPageCardShiftChangeEdit', ptCardShiftChangeCode);
            $.ajax({
                type: "POST",
                url: "cardShiftChangePageEdit",
                data: {tCardShiftChangeDocNo: ptCardShiftChangeCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftChangeTitleAdd').hide();
                        $('#oliCardShiftChangeTitleEdit').show();
                        $('#odvBtnCardShiftChangeInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftChange').html(tResult);
                        $('#oetCardShiftChangeCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftChangeCallPageCardShiftChangeEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftChange
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftChangeGenerateCardShiftChangeCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTableName = 'TFNTCrdVoidHD';
            var tStaDocType = '2'; // Change Card
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName , tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftChangeCode').val(tData.rtCvhDocNo);
                        JSXUpdateDocNoCenter(tData.rtCvhDocNo, 'TFNTCrdVoidTmp');
                        $('#oetCardShiftChangeCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('.xCNBtnGenCode').attr('disabled', true);
                    } else {
                        $('#oetCardShiftChangeCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftChangeName').focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftChangeGenerateCardShiftChangeCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftChange Code In DB
 * Parameters : {params}
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftChangeCheckCardShiftChangeCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tCode = $('#oetCardShiftChangeCode').val();
            var tTableName = 'TFNTCrdVoidHD';
            var tFieldName = 'FTCvhDocNo';
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
                            JSvCardShiftChangeCallPageCardShiftChangeEdit(tCode);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftChangeGenerateCardShiftChangeCode();
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftChangeCheckCardShiftChangeCode Error: ', err);
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
function JSxCardShiftChangeSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrCardShiftChange').find('td.otdCardShiftChangeCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxCardShiftChangeSetDataBeforeDelMulti Error: ', err);
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
function JSaCardShiftChangeCardShiftChangeDelete(poElement, poEvent){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCardShiftChange').find('td.otdCardShiftChangeCode').text();
        $('#ospConfirmDelete').text(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCardShiftChange').modal('show');
        }
    }catch(err){
        console.log('JSaCardShiftChangeCardShiftChangeDelete Error: ', err);
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
function JSnCardShiftChangeCardShiftChangeDelChoose(){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if(nCheckedCount > 1){
                // For mutiple delete
                var oChecked = $('#odvRGPList td input:checked');
                var aCardShiftChangeCode = [];
                $(oChecked).each( function(pnIndex){
                    aCardShiftChangeCode[pnIndex] = $(this).parents('tr.otrCardShiftChange').find('td.otdCardShiftChangeCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeDeleteMulti",
                    data: {tCardShiftChangeCode: JSON.stringify(aCardShiftChangeCode)},
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvModalDelCardShiftChange').modal('hide');
                        JSvCardShiftChangeCardShiftChangeDataTable();
                        JSxCardShiftChangeCardShiftChangeNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }else{
                // For single delete
                var tCardShiftChangeCode = $('#ospConfirmDelete').text();
                $.ajax({
                    type: "POST",
                    url: "cardShiftChangeDelete",
                    data: {tCardShiftChangeCode: tCardShiftChangeCode},
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvModalDelCardShiftChange').modal('hide');
                        JSvCardShiftChangeCardShiftChangeDataTable();
                        JSxCardShiftChangeCardShiftChangeNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftChangeResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSnCardShiftChangeCardShiftChangeDelChoose Error: ', err);
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
function JSvCardShiftChangeClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftChange .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftChange .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftChangeCardShiftChangeDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 08/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftChangeIsCreatePage(){
    try{
        const tCardShiftChangeCode = $('#oetCardShiftChangeCode').data('is-created');
        var bStatus = false;
        if(tCardShiftChangeCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftChangeIsCreatePage Error: ', err);
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
function JCNbCardShiftChangeIsUpdatePage(){
    try{
        const tCardShiftChangeCode = $('#oetCardShiftChangeCode').data('is-created');
        var bStatus = false;
        if(tCardShiftChangeCode != ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftChangeIsUpdatePage Error: ', err);
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
function JSxCardShiftChangeVisibleDelAllBtn(poElement, poEvent){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCardShiftChangeVisibleDelAllBtn Error: ', err);
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
function JSxCardShiftChangeVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCardShiftChangeVisibleComponent Error: ', err);
    }
}



