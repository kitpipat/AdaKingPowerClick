var nStaPadBrowseType  = $('#oetBbkStaBrowse').val();
var tCallPadBackOption = $('#oetBbkCallBackOption').val();

$('document').ready(function() {
    localStorage.removeItem('LocalItemData');
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxPADNavDefult();

    if (nStaPadBrowseType != 1) {
        JSvCallPagePermissionApproveDocList();
    } else {
        // JSvCallPageBookBankAdd();
    }

});

function JSxPADNavDefult() {
    if (nStaPadBrowseType != 1 || nStaPadBrowseType == undefined) {
        $('.xCNCdcVBrowse').hide();
        $('.xCNBbkVMaster').show();
        $('#oliPadTitleAdd').hide();
        $('#oliPadTitleEdit').hide();
        $('#odvBtnPadAddEdit').hide();
        $('#odvBtnBbkInfo').show();
        $('.obtChoose').hide();
    } else { 
        $('#odvModalBody .xCNCdcVMaster').hide();
        $('#odvModalBody .xCNCdcVBrowse').show();
        $('#odvModalBody #odvCdcMainMenu').removeClass('main-menu');
        $('#odvModalBody #oliBbkNavBrowse').css('padding', '2px');
        $('#odvModalBody #odvBbkBtnGroup').css('padding', '0');
        $('#odvModalBody .xCNBbkBrowseLine').css('padding', '0px 0px');
        $('#odvModalBody .xCNBbkBrowseLine').css('border-bottom', '1px solid #e3e3e3');
    }
}

//function : Function Show Event Error
//Parameters : Error Ajax Function 
//Creator : 17/02/2020 Saharat(Golf)
//Return : Modal Status Error
//Return Type : view
function JCNxResponseError(jqXHR, textStatus, errorThrown) {
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
}

//Functionality : Call Page PermissionApproveDoc
//Parameters : -
//Creator : 17/02/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPagePermissionApproveDocList() {
    $.ajax({
        type: "GET",
        url: "PermissionApproveDocList",
        cache: false,
        success: function(tResult) {
            $('#odvContentPermissionApvDoc').html(tResult);
            JSxPADNavDefult();
            //แสดงข้อมูลใน List
            JSvCallPagePermissionApproveDocDataTable(); 
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Functionality : โหลดข้อมูล ข้อมูล PermissionApproveDoc
//Parameters : pnPage หน้าของข้อมูล
//Creator : 17/02/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPagePermissionApproveDocDataTable(pnPage) {
    var tSearchAll = $('#oetSearchAll').val();
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "PermissionApproveDocDataTable",
        data: {            
                tSearchAll: tSearchAll,
                nPageCurrent: nPageCurrent
            },
        cache: false,
        success: function(tResult) {
            $('#odvContentPermissionApvDocData').html(tResult);
            JSxPADNavDefult();
            JCNxLayoutControll();
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

//Functionality : Add Data PermissionApproveDoc add/updata  
//Parameters : page wPermissionApvDocDataTable
//Creator : 17/12/2020 Saharat(Golf)
//Return : -
//Return Type : -
function JSxPADAddEditPermissionApproveDoc() {
        let nCountDataInTableDT = $('#odvRGPList .odvListData').length;
        if(nCountDataInTableDT > 0){
            let tPadDapTable   = $('#oetPadDapTable').val();
            let tPadDapRefType = $('#oetPadDapRefType').val();

            var aDataDetailItems    = [];
            $('#odvRGPList .odvListData').each(function(){
                let tDapseq      = $(this).data('seq');
                let tDapuserrole = $(this).data('userrole');
                let tDaptable    = $(this).data('table');
                let tDaptype     = $(this).data('type');
                let tDatCode     = $(this).data('code');
                let tColorCode   = $('#oetSltColor'+tDapseq).val();
                aDataDetailItems.push({
                    'tDapSeq'       : tDapseq,
                    'tUserrole'     : tDapuserrole,
                    'tTable'        : tDaptable,
                    'tType'         : tDaptype,
                    'tCode'         : tDatCode,
                    'tColorCode'    :tColorCode
                });
            });
            $.ajax({
                type: "POST",
                url: 'PermissionApproveDocEventAdd',
                data: { 'aDetailItems'    : JSON.stringify(aDataDetailItems),
                        'tPadDapTable'    : tPadDapTable,
                        'tPadDapRefType'  : tPadDapRefType,
                },  
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    let tDapTable = $('#oetPadDapTable').val();
                    let tDapRefType = $('#oetPadDapRefType').val();
                    let tSdtDocName = $('#ohdSdtDocName').val();
                    JSvCallPagePermissionApproveDocEdit(tDapTable,tDapRefType,tSdtDocName,1);
                },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
}

//Functionality : Call Page Edit  
//Parameters :  page wPermissionApvDocDataTable
//Creator :  17/02/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvCallPagePermissionApproveDocEdit(ptDapTable,ptDapRefType,ptSdtDocName,pnPage){
    var nPageCurrent = pnPage;
    if (nPageCurrent == undefined || nPageCurrent == '') {
        nPageCurrent = '1';
    }
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "PermissionApproveDocPageEdit",
        data: { 
                tDapTable    : ptDapTable,
                tDapRefType  : ptDapRefType,
                tSdtDocName  : ptSdtDocName,
                nPageCurrent : nPageCurrent
         },
        cache: false,
        success: function(tResult) {
            if (tResult != '') {
                $('#oliPadTitleEdit').show();
                $('#odvContentPermissionApvDoc').html(tResult);
                $('#odvBtnPadAddEdit').show();
            }   
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 17/02/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvPADClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPagePermissionApproveDocDataTable(nPageCurrent);
}

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 04/02/2020 Saharat(Golf)
//Return : View
//Return Type : View
function JSvPADClickPageEdit(ptPage) {
    let tDapTable   = $('#oetPadDapTable').val();
    let tDapRefType = $('#oetPadDapRefType').val();
    let tSdtDocName = $('#ohdSdtDocName').val();

    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWCDCPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JSvCallPagePermissionApproveDocEdit(tDapTable,tDapRefType,tSdtDocName,nPageCurrent);
}


