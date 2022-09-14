//Click Datatable 
function JSvClickCallTableTemp(tDocType,pnPage,ptIDElement){
    var nStaSession = JCNxFuncChkSessionExpired();
    if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
        JCNxCloseLoading();
        if(!ptIDElement){   var ptIDElement = 'odvPanelCmdMngDataDetail'}

        var tSearch         = $('#oetSearchImportHelper').val();
        var tSelectOption   = $('#ocmCmdDataEntry').val();

        switch (tSelectOption) {
            case '1': //บัตรใหม่
                var tDocType = 'NewCard';
                break;
            case '2': //เติมเงิน
                var tDocType = 'TopUp';
                break;
            case '3': //เปลี่ยนบัตร
                var tDocType = 'CardTnfChangeCard';
                break;
            case '4': //ล้างบัตร
                var tDocType = 'ClearCard';
                break;
            default:
                nPageCurrent = 'xxx'
        }

        $.ajax({
            type: "POST",
            url: "CallTableTemp",
            cache: false,
            data: {
                tDocType     : tDocType,
                nPageCurrent : pnPage,
                ptIDElement  : ptIDElement,
                ptSearchAll  : tSearch
            },
            timeout: 0,
            success: function(oDataReturn){
                var aDataReturn = jQuery.parseJSON(oDataReturn);
                $('#' + ptIDElement).html(aDataReturn['tHtmlView']);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        JCNxShowMsgSessionExpired();
    }
}

//Click Page
function JSvClickPageINHelper(ptPage,tDocType,ptIDElement) {
    JCNxOpenLoading();

    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            nPageOld = $('.xWPageCardHelper .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageCardHelper .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }

    JSvClickCallTableTemp(tDocType,nPageCurrent,ptIDElement);
}

//Delete
function JSnCallPageExcelHelperDel(pnPage,tDocType,pnSeq,ptID,ptIDElement){
    $('#odvModalDelExcelRecord').modal('toggle');
    
    if(ptID == '' || ptID == null){
        ptID = '-';
    }else{
        ptID = ptID;
    }
    $('#ospConfirmDeleteExcelRecord').html($('#oetTextComfirmDeleteSingle').val() + ptID);
    $('#osmConfirmExcelRecord').unbind().click(function(evt) {
        $.ajax({
            type: "POST",
            url: "CallDeleteTemp",
            data: { ptID : ptID , pnSeq : pnSeq , ptDocType : tDocType },
            cache: false,
            success: function(tResult) {
                $('#odvModalDelExcelRecord').modal('toggle');
                JSvClickCallTableTemp(tDocType,pnPage,ptIDElement);
            },
            error: function(data) {
                console.log(data);
            }
        });
    });
}

//Delete By Table
function JSnCallDeleteHelperByTable(ptTableName){
    $.ajax({
        type: "POST",
        url: "CallClearTempByTable",
        data: { ptTableName : ptTableName },
        cache: false,
        success: function(tResult) { 
            //console.log('Clear Data สำเร็จ');
        },
        error: function(data) {
            console.log(data);
        }
    });
}

//Update DocNo in Table
function JSXUpdateDocNoCenter(ptDocNo, ptTableName){
    $.ajax({
        type: "POST",
        url: "CallUpdateDocNoinTempByTable",
        data: { 
            tDocNo: ptDocNo, 
            tTableName: ptTableName 
        },
        cache: false,
        success: function(tResult) { 
            //console.log('Update DocNo สำเร็จ');
        },
        error: function(data) {
            console.log(data);
        }
    });
}