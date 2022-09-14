<script>
/**
 * Functionality : Open Ref PI Modal
 * Parameters : route
 * Creator : 23/05/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNoteOpenPIPanel() {
    // var tSplCode = $('#oetCreditNoteSplCode').val();
    // if(tSplCode === ''){
    //     var tWarningMessage = 'โปรดเลือกผู้จำหน่ายก่อนทำรายการ';
    //     FSvCMNSetMsgWarningDialog(tWarningMessage);
    //     return;
    // }
    
    JSxCreditNotePIHDList(1);
    $('#odvCreditNotePIPanel').modal('show');
}

/**
 * Functionality : Call PI HD List
 * Parameters : route
 * Creator : 21/06/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNotePIHDList(pnPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        $('#odvCreditNoteRefPIDTTable').html('');

        JCNxOpenLoading();

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var oAdvanceSearch = ''; // JSoCreditNoteGetAdvanceSearchData();

        if('<?=$this->session->userdata("tSesUsrLevel")?>' == 'HQ'){
            var tBCHCode = '';
        }else{
            var tBCHCode = $('#oetCreditNoteBchCode').val();
        }


        $.ajax({
            type: "POST",
            url: "creditNoteRefPIHDList",
            data: $("#ofmCreditNoteRefPIHDForm").serialize() + '&oAdvanceSearch=' + oAdvanceSearch + '&nPageCurrent=' + nPageCurrent + '&tBranch=' + tBCHCode,
            cache: false,
            success: function (tResult) {
                try{
                    var oResult = JSON.parse(tResult);
                    $("#odvCreditNoteRefPIHDTable").html(oResult.tPIViewDataTableList);
                    JCNxCloseLoading();
                }catch(err){
                    console.log('JSxCreditNotePIHDList Error: ', err);
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
        
    }else {
        JCNxShowMsgSessionExpired();
    }    
}

/**
 * Functionality : Call PI DT List
 * Parameters : route
 * Creator : 21/06/2019 Piya
 * Update : -
 * Return : -
 * Return Type : -
 */
function JSxCreditNotePIDTList(pnPage, poParams) {
    try{
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
            JCNxOpenLoading();

            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = "1";
            }
            var tDocNo = '';
            if(!(poParams == null)){
                tDocNo = poParams.tDocNo
            }else{
                tDocNo = window.tPIHDDocCode
            }
            var oAdvanceSearch = ''; // JSoCreditNoteGetAdvanceSearchData();

            $.ajax({
                type: "POST",
                url: "creditNoteRefPIDTList",
                data: {
                    tDocNo: tDocNo,
                    oAdvanceSearch: oAdvanceSearch,
                    nPageCurrent: nPageCurrent
                },
                cache: false,
                success: function (tResult) {
                    try{
                        var oResult = JSON.parse(tResult);
                        $("#odvCreditNoteRefPIDTTable").html(oResult.tPIViewDataTableList);
                        JCNxCloseLoading();
                    }catch(err){
                        console.log('JSxCreditNotePIDTList Error: ', err);
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else {
            JCNxShowMsgSessionExpired();
        }
    }catch(err){
        console.log('JSxCreditNotePIDTList Error: ', err);   
    }    
}

/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCreditNotePIHDClickPage(ptPage) {
    var nPageCurrent = "";
    switch (ptPage) {
        case "next": //กดปุ่ม Next
            $("#odvCreditNotePIHDList .xWBtnNext").addClass("disabled");
            nPageOld = $("#odvCreditNotePIHDList .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case "previous": //กดปุ่ม Previous
            nPageOld = $("#odvCreditNotePIHDList .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSxCreditNotePIHDList(nPageCurrent);
}

/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvCreditNotePIDTClickPage(ptPage) {
    var nPageCurrent = "";
    switch (ptPage) {
        case "next": //กดปุ่ม Next
            $("#odvCreditNotePIDTList .xWBtnNext").addClass("disabled");
            nPageOld = $("#odvCreditNotePIDTList .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case "previous": //กดปุ่ม Previous
            nPageOld = $("#odvCreditNotePIDTList .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSxCreditNotePIDTList(nPageCurrent, null);
}

/**
 * Functionality : PI DT Selected
 * Parameters : poEl is Itself element, poEv is Itself event
 * Creator : 21/06/2019 piya
 * Last Modified : -
 * Return : -
 * Return Type : -
 */
function JSvCreditNotePIDTSelect(poEl, poEv) {
    try {
        var aPIDTSelected = [];
    } catch (err) {
        console.log('JSvCreditNotePIDTSelect Error: ', err);
    }
    
    if(!hasTablePrimary) { // ไม่มีการเลือกไว้  
        $('#' + id + '-' + item.id + '-tr-select-grid').addClass('table-primary');
        this.dtSelectTempItems.push(item); // เก็บค่า
    } else { // มีการเลือกไว้
        $('#' + id + '-' + item.id + '-tr-select-grid').removeClass('table-primary');
        var listToDelete = [item.id]; // item ที่จะเอาออก
        var arrayOfObjects = this.dtSelectTempItems; // ที่บรรจุ item

        arrayOfObjects.reduceRight(function (acc, obj, idx) {
            if (listToDelete.indexOf(obj.id) > -1) {
                arrayOfObjects.splice(idx, 1);
            }
        }, 0);
        this.dtSelectTempItems = arrayOfObjects;
    }
}

function mthInitSelectItems(items) {
    window.console.log('mthInitSelectItems: ', items);
    var id = this.id;
    $('#' + id + ' .tr-select-grid').removeClass('table-primary'); // ล้าง css class (table-primary) ทั้งหมด            
    for(var i = 0; i < items.length; i++){
        window.console.log('el id: ', '#' + id + '-' + items[i].id + '-tr-select-grid');
        $('#' + id + '-' + items[i].id + '-tr-select-grid').addClass('table-primary');
    }
}

function JSxCreditNoteSelectPIHDDOC(poEl){
    $('.xWPIHDDocItems').removeClass('xCNActive');
    $(poEl).addClass('xCNActive');
    var tDocNo = $(poEl).data('code');
    window.tPIHDDocCode = tDocNo;
    
    var poParams = {
        tDocNo: tDocNo
    };
    if(JCNbCreditNoteIsDocType('havePdt')){
        JSxCreditNotePIDTList('1', poParams);
    }
}

/**
 * ดักจับการเลือกทั้งหมด หรือไม่เลือกเลย
 * 
 */
function JSxCreditNoteSelectPIDTAll(poEl){
    var bIsChecked = $(poEl).is(':checked');
    console.log('bIsChecked: ', bIsChecked);
    if(bIsChecked){
        $('.xWCreditNoteSelectPIDTItem').prop('checked', true); // Checks it
    }else{
        $('.xWCreditNoteSelectPIDTItem').prop('checked', false); // Unchecks it
    }
}

/**
 * เพิ่มรายการสินค้าจาก เอกสาร PI ที่เลือกไปไว้ใน DT Temp
 * 
 */
function JSxCreditNoteAddPdtFromPIToDTTemp(){
    if(JCNbCreditNoteIsDocType('havePdt')) {
    
        var aPdtItems = [];
        $('.xWPIDTDocItems .xWCreditNoteSelectPIDTItem:checked').each(function(index){
            var tPdtCode    = $(this).parents('.xWPIDTDocItems').data('code');
            var tBarCode    = $(this).parents('.xWPIDTDocItems').data('barcode');
            var tPunCode    = $(this).parents('.xWPIDTDocItems').data('puncode');
            var tPrice      = $(this).parents('.xWPIDTDocItems').data('price');
            var nQty        = $(this).parents('.xWPIDTDocItems').data('qty');
            var tVatrate    = $(this).parents('.xWPIDTDocItems').data('vatrate');
            var tVatcode    = $(this).parents('.xWPIDTDocItems').data('vatcode');
            aPdtItems.push({
                pnPdtCode   : tPdtCode,
                ptBarCode   : tBarCode,
                ptPunCode   : tPunCode,
                packData    : {
                    Price   : tPrice,
                    Qty     : nQty,
                    Vatrate : tVatrate,
                    Vatcode : tVatcode
                }
            });
        });
        var tPdtItems = JSON.stringify(aPdtItems); 
        var tIsRefPI = '1';
        
        if(JSbCreditNoteSetConditionFromPI()) {
            FSvPDTAddPdtIntoTableDT(tPdtItems, tIsRefPI);
            $('#oetCreditNoteRefPICode').val(window.tPIHDDocCode);
            $('#oetCreditNoteRefPIName').val(window.tPIHDDocCode);
            $('#odvCreditNotePIPanel').modal('hide');
        }
    }
}

//เพิ่มข้อมูลใน เงื่อนไข จากเอกสาร PI ที่เลือก/
function JSbCreditNoteSetConditionFromPI(){
    var tShpCode    = $('.xWPIHDDocItems.xCNActive').data('shpcode');
    var tShpName    = $('.xWPIHDDocItems.xCNActive').data('shpname');
    var tWahCode    = $('.xWPIHDDocItems.xCNActive').data('wahcode');
    var tWahName    = $('.xWPIHDDocItems.xCNActive').data('wahname');
    var tSplcode    = $('.xWPIHDDocItems.xCNActive').data('splcode');
    var tSplname    = $('.xWPIHDDocItems.xCNActive').data('splname');
    var tVatInorEx  = $('.xWPIHDDocItems.xCNActive').data('vatinorex');
    var dDateRefIn  = $('.xWPIHDDocItems.xCNActive').data('daterefin');

    $('#oetCreditNoteMchCode').val('');
    $('#oetCreditNoteMchName').val('');
    $('#ohdCreditNoteWahCodeInShp').val('');
    $('#ohdCreditNoteWahNameInShp').val('');
    $('#oetCreditNoteShpCode').val('');
    $('#oetCreditNoteShpName').val('');
    $('#oetCreditNotePosCode').val('');
    $('#oetCreditNotePosName').val('');
    $('#ohdCreditNoteWahCode').val('');
    $('#ohdCreditNoteWahName').val('');
    $('#oetCreditNoteWahCode').val('');
    $('#oetCreditNoteWahName').val('');
    $('#oetCreditNoteShpCode').val(tShpCode);
    $('#oetCreditNoteShpName').val(tShpName);
    $('#oetCreditNoteWahCode').val(tWahCode);
    $('#oetCreditNoteWahName').val(tWahName);
    $('#oetCreditNoteXphRefIntDate').val(dDateRefIn);
    //ถ้าอ้างอิงผู้จำหน่าย
    $('#oetCreditNoteSplCode').val(tSplcode);
    $('#oetCreditNoteSplName').val(tSplname);
    $('#ocmCreditNoteXphVATInOrEx').val(tVatInorEx).selectpicker("refresh");
    return true;
}
</script>
