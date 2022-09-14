var nStaCardShiftRefundBrowseType   = $('#oetCardShiftRefundStaBrowse').val();
var tCallCardShiftRefundBackOption  = $('#oetCardShiftRefundCallBackOption').val();

/*============================= Begin Auto Run ===============================*/

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxCardShiftRefundCardShiftRefundNavDefult();
    if (nStaCardShiftRefundBrowseType != 1) {
        JSvCardShiftRefundCallPageCardShiftRefund();
    } else {
        JSvCardShiftRefundCallPageCardShiftRefundAdd();
    }
});

/*============================= End Auto Run =================================*/

/**
 * Functionality : Function Clear Defult Button CardShiftRefund
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSxCardShiftRefundCardShiftRefundNavDefult() {
    try{
        if (nStaCardShiftRefundBrowseType != 1 || nStaCardShiftRefundBrowseType == undefined) {
            $('.xCNCardShiftRefundVBrowse').hide();
            $('.xCNCardShiftRefundVMaster').show();
            $('#oliCardShiftRefundTitleAdd').hide();
            $('#oliCardShiftRefundTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('.obtChoose').hide();
            $('#odvBtnCardShiftRefundInfo').show();
        } else {
            $('#odvModalBody .xCNCardShiftRefundVMaster').hide();
            $('#odvModalBody .xCNCardShiftRefundVBrowse').show();
            $('#odvModalBody #odvCardShiftRefundMainMenu').removeClass('main-menu');
            $('#odvModalBody #oliCardShiftRefundNavBrowse').css('padding', '2px');
            $('#odvModalBody #odvCardShiftRefundBtnGroup').css('padding', '0');
            $('#odvModalBody .xCNCardShiftRefundBrowseLine').css('padding', '0px 0px');
            $('#odvModalBody .xCNCardShiftRefundBrowseLine').css('border-bottom', '1px solid #e3e3e3');
        }
    }catch(err){
        console.log('JSxCardShiftRefundCardShiftRefundNavDefult Error: ', err);
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
function JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown) {
    try{
        JCNxResponseError(jqXHR, textStatus, errorThrown)
    }catch(err){
        console.log('JCNxCardShiftRefundResponseError Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftRefund Page list
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftRefundCallPageCardShiftRefund() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            localStorage.tStaPageNow = 'JSvCallPageCardShiftRefundList';
            $('#oetSearchAll').val('');
            $.ajax({
                type: "POST",
                url: "cardShiftRefundList",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    $('#odvContentPageCardShiftRefund').html(tResult);
                    JSvCardShiftRefundCardShiftRefundDataTable();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftRefundCallPageCardShiftRefund Error: ', err);
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
function JSvCardShiftRefundCardShiftRefundDataTable(pnPage) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tSearchAll = $('#oetSearchAll').val();
            var oAdvanceSearch = JSoCardShiftRefundGetSearchData();
            console.log('Search data: ', oAdvanceSearch);
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == '') {
                nPageCurrent = '1';
            }
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "cardShiftRefundDataTable",
                data: {
                    tSearchAll: tSearchAll,
                    tAdvanceSearch: JSON.stringify(oAdvanceSearch),
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                Timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $('#ostDataCardShiftRefund').html(tResult);
                    }
                    JSxCardShiftRefundCardShiftRefundNavDefult();
                    JCNxLayoutControll();
                    // JStCMMGetPanalLangHTML('TCNMUsrDepart_L'); // โหลดภาษาใหม่
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftRefundCardShiftRefundDataTable Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftRefund Page Add
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftRefundCallPageCardShiftRefundAdd() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JSnCallDeleteHelperByTable("TFNTCrdTopUpTmp");
            JCNxOpenLoading();
            // JStCMMGetPanalLangSystemHTML('', '');
            $.ajax({
                type: "POST",
                url: "cardShiftRefundPageAdd",
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (nStaCardShiftRefundBrowseType == 1) {
                        $('.xCNCardShiftRefundVMaster').hide();
                        $('.xCNCardShiftRefundVBrowse').show();
                    } else {
                        $('.xCNCardShiftRefundVBrowse').hide();
                        $('.xCNCardShiftRefundVMaster').show();
                        $('#oliCardShiftRefundTitleEdit').hide();
                        $('#oliCardShiftRefundTitleAdd').show();
                        $('#odvBtnCardShiftRefundInfo').hide();
                        $('#odvBtnAddEdit').show();
                    }
                    $('#odvContentPageCardShiftRefund').html(tResult);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftRefundCallPageCardShiftRefundAdd Error: ', err);
    }
}

/**
 * Functionality : Call CardShiftRefund Page Edit
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : view
 * Return Type : view
 */
function JSvCardShiftRefundCallPageCardShiftRefundEdit(ptCardShiftRefundCode) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            // JStCMMGetPanalLangSystemHTML('JSvCallPageCardShiftRefundEdit', ptCardShiftRefundCode);
            $.ajax({
                type: "POST",
                url: "cardShiftRefundPageEdit",
                data: {tCardShiftRefundDocNo: ptCardShiftRefundCode },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != '') {
                        $('#oliCardShiftRefundTitleAdd').hide();
                        $('#oliCardShiftRefundTitleEdit').show();
                        $('#odvBtnCardShiftRefundInfo').hide();
                        $('#odvBtnAddEdit').show();
                        $('#odvContentPageCardShiftRefund').html(tResult);
                        $('#oetCardShiftRefundCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                    }
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSvCardShiftRefundCallPageCardShiftRefundEdit Error: ', err);
    }
}

/**
 * Functionality : Generate Code CardShiftRefund
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : data
 * Return Type : string
 */
function JStCardShiftRefundGenerateCardShiftRefundCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tTableName = 'TFNTCrdTopUpHD';
            var tStaDocType = '2'; // Void Topup
            $.ajax({
                type: "POST",
                url: "generateCodeV5",
                data: { tTableName: tTableName, tStaDoc: tStaDocType },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    var tData = $.parseJSON(tResult);
                    if (tData.rtCode == '1') {
                        $('#oetCardShiftRefundCode').val(tData.rtCthDocNo);
                        JSXUpdateDocNoCenter(tData.rtCthDocNo,'TFNTCrdTopUpTmp');
                        $('#oetCardShiftRefundCode').addClass('xCNDisable');
                        $('.xCNDisable').attr('readonly', true);
                        //----------Hidden ปุ่ม Gen
                        $('.xCNBtnGenCode').attr('disabled', true);
                    } else {
                        $('#oetCardShiftRefundCode').val(tData.rtDesc);
                    }
                    $('#oetCardShiftRefundName').focus();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftRefundGenerateCardShiftRefundCode Error: ', err);
    }
}

/**
 * Functionality : Check CardShiftRefund Code In DB
 * Parameters : {params}
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : status, message
 * Return Type : string
 */
function JStCardShiftRefundCheckCardShiftRefundCode() {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tCode = $('#oetCardShiftRefundCode').val();
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
                            JSvCardShiftRefundCallPageCardShiftRefundEdit(tCode);
                        } else {
                            alert('ไม่พบระบบจะ Gen ใหม่');
                            JStCardShiftRefundGenerateCardShiftRefundCode();
                        }
                        $('.wrap-input100').removeClass('alert-validate');
                        $('.btn-default').attr('disabled', false);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JStCardShiftRefundCheckCardShiftRefundCode Error: ', err);
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
function JSxCardShiftRefundSetDataBeforeDelMulti(){ // Action start after delete all button click.
    try{
        var oChecked = $('#odvRGPList td input:checked');
        var tValue = '';
        $(oChecked).each( function(pnIndex){
            tValue += $(this).parents('tr.otrCardShiftRefund').find('td.otdCardShiftRefundCode').text() + ', ';
        });
        $('#ospConfirmDelete').text(tValue.replace(/, $/,""));
    }catch(err){
        console.log('JSxCardShiftRefundSetDataBeforeDelMulti Error: ', err);
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
function JSaCardShiftRefundCardShiftRefundDelete(poElement, poEvent){
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;

        var tValue = $(poElement).parents('tr.otrCardShiftRefund').find('td.otdCardShiftRefundCode').text();
        $('#ospConfirmDelete').text(tValue);

        if(nCheckedCount <= 1){
            $('#odvModalDelCardShiftRefund').modal('show');
        }
    }catch(err){
        console.log('JSaCardShiftRefundCardShiftRefundDelete Error: ', err);
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
function JSnCardShiftRefundCardShiftRefundDelChoose(){
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            JCNxOpenLoading();
            var nCheckedCount = $('#odvRGPList td input:checked').length;
            if(nCheckedCount > 1){ // For mutiple delete

                var oChecked = $('#odvRGPList td input:checked');
                var aCardShiftRefundCode = [];
                $(oChecked).each( function(pnIndex){
                    aCardShiftRefundCode[pnIndex] = $(this).parents('tr.otrCardShiftRefund').find('td.otdCardShiftRefundCode').text();
                });

                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundDeleteMulti",
                    data: {tCardShiftRefundCode: JSON.stringify(aCardShiftRefundCode)},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftRefund').modal('hide');
                        JSvCardShiftRefundCardShiftRefundDataTable();
                        JSxCardShiftRefundCardShiftRefundNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }else{ // For single delete

                var tCardShiftRefundCode = $('#ospConfirmDelete').text();

                $.ajax({
                    type: "POST",
                    url: "cardShiftRefundDelete",
                    data: {tCardShiftRefundCode: tCardShiftRefundCode},
                    success: function(tResult) {
                        $('#odvModalDelCardShiftRefund').modal('hide');
                        JSvCardShiftRefundCardShiftRefundDataTable();
                        JSxCardShiftRefundCardShiftRefundNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxCardShiftRefundResponseError(jqXHR, textStatus, errorThrown);
                    }
                });

            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSnCardShiftRefundCardShiftRefundDelChoose Error: ', err);
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
function JSvCardShiftRefundClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageCardShiftRefund .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardShiftRefund .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvCardShiftRefundCardShiftRefundDataTable(nPageCurrent);
}

/**
 * Functionality : Is create page.
 * Parameters : -
 * Creator : 30/10/2018 piya
 * Last Modified : -
 * Return : Status true is create page
 * Return Type : Boolean
 */
function JCNbCardShiftRefundIsCreatePage(){
    try{
        const tCardShiftRefundCode = $('#oetCardShiftRefundCode').data('is-created');
        var bStatus = false;
        if(tCardShiftRefundCode == ""){ // No have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftRefundIsCreatePage Error: ', err);
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
function JCNbCardShiftRefundIsUpdatePage(){
    try{
        const tCardShiftRefundCode = $('#oetCardShiftRefundCode').data('is-created');
        var bStatus = false;
        if(!tCardShiftRefundCode == ""){ // Have data
            bStatus = true;
        }
        return bStatus;
    }catch(err){
        console.log('JCNbCardShiftRefundIsUpdatePage Error: ', err);
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
function JSxCardShiftRefundVisibleDelAllBtn(poElement, poEvent){ // Action start after change check box value.
    try{
        var nCheckedCount = $('#odvRGPList td input:checked').length;
        if(nCheckedCount > 1){
            $('#oliBtnDeleteAll').removeClass("disabled");
        }else{
            $('#oliBtnDeleteAll').addClass("disabled");
        }
    }catch (err){
        console.log('JSxCardShiftRefundVisibleDelAllBtn Error: ', err);
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
function JSxCardShiftRefundVisibleComponent(ptComponent, pbVisible, ptEffect){
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
        console.log('JSxCardShiftRefundVisibleComponent Error: ', err);
    }
}


