<script>

if($('#oetFhnPdtCode').val()==''){
    $('#odvFnhPdtName').text($('#oetPdtName').val());
    $('#oetFhnPdtCode').val($('#oetPdtCode').val());
}

$('#oimSearchFhnPdtColorSze').unbind().click(function(){
    JCNxOpenLoading();
    JSvFhnPdtClrPszLoadDataTable();
});

$('#oetSearchFhnPdtColorSze').keypress(function(event){
    if(event.keyCode == 13){
        JCNxOpenLoading();
        JSvFhnPdtClrPszLoadDataTable();
    }
});

$('#obtPdtFashionBack').unbind().click(function(){
    $('a[data-target="#odvPdtContentInfo1"]').click();
    $('#obtCallBackProductList').removeClass('xCNHide');
});

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : Event Click Pagenation
//Creator : 13/09/2018 wasin
//Return : View
//Return Type : View
function JSvFhnPdtClickPage(ptPage) {
    var nPageCurrent = '';
    switch (ptPage) {
        case 'next': //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPageFhnPdt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

            nPageCurrent = nPageNew
            break;
        case 'previous': //กดปุ่ม Previous
            nPageOld = $('.xWPageFhnPdt .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }
    JCNxOpenLoading();
    JSvFhnPdtClrPszLoadDataTable(nPageCurrent);
}

// Click Browse Product Depart
$('#obFhnPdtDepartBrows').click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        window.oFhnPdtDepartBrowsOption = oCatProductBrows({
            'tReturnInputCode'  : 'oetFhnPdtDepartCode',
            'tReturnInputName'  : 'oetFhnPdtDepartName',
            'nCatLevel'         : 1,
            'tCatParent'        : ''
            // 'tNextFuncName': ''
        });
        JCNxBrowseData('oFhnPdtDepartBrowsOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});


// Option Add Browse Product Depart
// var oFhnPdtDepartBrows = function(poReturnInput) {
//     var tInputReturnCode = poReturnInput.tReturnInputCode;
//     var tInputReturnName = poReturnInput.tReturnInputName;
//     var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

//     var tConditionWhere = '';
//         if(tSesUsrAgnCode!=''){
//             tConditionWhere +=" AND ( TFHMPdtF1Depart.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtF1Depart.FTAgnCode,'') = '' )   ";
//         }

//     var oOptionReturn = {
//         Title: ['product/product/product', 'tFhnPdtDepart'],
//         Table: {
//             Master: 'TFHMPdtF1Depart',
//             PK: 'FTDepCode'
//         },
//         Join: {
//                 Table: ['TFHMPdtF1Depart_L'],
//                 On: [
//                     'TFHMPdtF1Depart.FTDepCode = TFHMPdtF1Depart_L.FTDepCode AND TFHMPdtF1Depart_L.FNLngID = ' + nLangEdits,
//                 ]
//         },
//         Where: {
//             Condition: [tConditionWhere]
//         },
//         GrideView: {
//             ColumnPathLang: 'product/product/product',
//             ColumnKeyLang: ['tFhnPdtDepartCode', 'tFhnPdtDepartName'],
//             ColumnsSize: ['20%', '80%'],
//             DataColumns: ['TFHMPdtF1Depart.FTDepCode', 'TFHMPdtF1Depart_L.FTDepName'],
//             DataColumnsFormat: ['', ''],
//             WidthModal: 50,
//             Perpage: 10,
//             OrderBy: ['TFHMPdtF1Depart.FTDepCode'],
//             SourceOrder: "DESC"
//         },
//         CallBack: {
//             ReturnType: 'S',
//             Value: [tInputReturnCode, "TFHMPdtF1Depart.FTDepCode"],
//             Text: [tInputReturnName, "TFHMPdtF1Depart_L.FTDepName"],
//         },
//         // NextFunc: {
//         //     FuncName: tNextFuncName,
//         //     ArgReturn: ['FTEvnCode', 'FTEvnName']
//         // },
//         // RouteAddNew: 'productNoSaleEvent',
//         BrowseLev: 1
//     }
//     return oOptionReturn;
// }



// Click Browse Product Class
$('#obFhnPdtClassBrows').click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        window.oFhnPdtClassBrowsOption = oCatProductBrows({
            'tReturnInputCode'  : 'oetFhnPdtClassCode',
            'tReturnInputName'  : 'oetFhnPdtClassName',
            'nCatLevel'         : 2,
            'tCatParent'        : 'oetFhnPdtDepartCode'
            // 'tNextFuncName': ''
        });
        JCNxBrowseData('oFhnPdtClassBrowsOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});


// Option Add Browse Product Class
// var oFhnPdtClassBrows = function(poReturnInput) {
//     var tInputReturnCode = poReturnInput.tReturnInputCode;
//     var tInputReturnName = poReturnInput.tReturnInputName;
//     var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

//     var tConditionWhere = '';
//         if(tSesUsrAgnCode!=''){
//             tConditionWhere +=" AND ( TFHMPdtF2Class.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtF2Class.FTAgnCode,'') = '' )  ";
//         }

//     var oOptionReturn = {
//         Title: ['product/product/product', 'tFhnPdtClass'],
//         Table: {
//             Master: 'TFHMPdtF2Class',
//             PK: 'FTClsCode'
//         },
//         Join: {
//                 Table: ['TFHMPdtF2Class_L'],
//                 On: [
//                     'TFHMPdtF2Class.FTClsCode = TFHMPdtF2Class_L.FTClsCode AND TFHMPdtF2Class_L.FNLngID = ' + nLangEdits,
//                 ]
//         },
//         Where: {
//             Condition: [tConditionWhere]
//         },
//         GrideView: {
//             ColumnPathLang: 'product/product/product',
//             ColumnKeyLang: ['tFhnPdtClassCode', 'tFhnPdtClassName'],
//             ColumnsSize: ['20%', '80%'],
//             DataColumns: ['TFHMPdtF2Class.FTClsCode', 'TFHMPdtF2Class_L.FTClsName'],
//             DataColumnsFormat: ['', ''],
//             WidthModal: 50,
//             Perpage: 10,
//             OrderBy: ['TFHMPdtF2Class.FTClsCode'],
//             SourceOrder: "DESC"
//         },
//         CallBack: {
//             ReturnType: 'S',
//             Value: [tInputReturnCode, "TFHMPdtF2Class.FTClsCode"],
//             Text: [tInputReturnName, "TFHMPdtF2Class_L.FTClsName"],
//         },
//         // NextFunc: {
//         //     FuncName: tNextFuncName,
//         //     ArgReturn: ['FTEvnCode', 'FTEvnName']
//         // },
//         // RouteAddNew: 'productNoSaleEvent',
//         BrowseLev: 1
//     }
//     return oOptionReturn;
// }




// Click Browse Product Sub Class
$('#obFhnPdtSubClassBrows').click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        window.oFhnPdtSubClassBrowsOption = oCatProductBrows({
            'tReturnInputCode'  : 'oetFhnPdtSubClassCode',
            'tReturnInputName'  : 'oetFhnPdtSubClassName',
            'nCatLevel'         : 3,
            'tCatParent'        : 'oetFhnPdtClassCode'
            // 'tNextFuncName': ''
        });
        JCNxBrowseData('oFhnPdtSubClassBrowsOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});


// Option Add Browse Product Sub Class
// var oFhnPdtSubClassBrows = function(poReturnInput) {
//     var tInputReturnCode = poReturnInput.tReturnInputCode;
//     var tInputReturnName = poReturnInput.tReturnInputName;
//     var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

//     var tConditionWhere = '';
//         if(tSesUsrAgnCode!=''){
//             tConditionWhere +=" AND ( TFHMPdtF3SubClass.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtF3SubClass.FTAgnCode,'') = '' ) ";
//         }

//     var oOptionReturn = {
//         Title: ['product/product/product', 'tFhnPdtSubClass'],
//         Table: {
//             Master: 'TFHMPdtF3SubClass',
//             PK: 'FTSclCode'
//         },
//         Join: {
//                 Table: ['TFHMPdtF3SubClass_L'],
//                 On: [
//                     'TFHMPdtF3SubClass.FTSclCode = TFHMPdtF3SubClass_L.FTSclCode AND TFHMPdtF3SubClass_L.FNLngID = ' + nLangEdits,
//                 ]
//         },
//         Where: {
//             Condition: [tConditionWhere]
//         },
//         GrideView: {
//             ColumnPathLang: 'product/product/product',
//             ColumnKeyLang: ['tFhnPdtSubClassCode', 'tFhnPdtSubClassName'],
//             ColumnsSize: ['20%', '80%'],
//             DataColumns: ['TFHMPdtF3SubClass.FTSclCode', 'TFHMPdtF3SubClass_L.FTSclName'],
//             DataColumnsFormat: ['', ''],
//             WidthModal: 50,
//             Perpage: 10,
//             OrderBy: ['TFHMPdtF3SubClass.FTSclCode'],
//             SourceOrder: "DESC"
//         },
//         CallBack: {
//             ReturnType: 'S',
//             Value: [tInputReturnCode, "TFHMPdtF3SubClass.FTSclCode"],
//             Text: [tInputReturnName, "TFHMPdtF3SubClass_L.FTSclName"],
//         },
//         // NextFunc: {
//         //     FuncName: tNextFuncName,
//         //     ArgReturn: ['FTEvnCode', 'FTEvnName']
//         // },
//         // RouteAddNew: 'productNoSaleEvent',
//         BrowseLev: 1
//     }
//     return oOptionReturn;
// }






// Click Browse Product Sub Class
$('#obFhnPdtGroupBrows').click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        window.oFhnPdtGroupBrowsOption = oCatProductBrows({
            'tReturnInputCode'  : 'oetFhnPdtGroupCode',
            'tReturnInputName'  : 'oetFhnPdtGroupName',
            'nCatLevel'         : 4,
            'tCatParent'        : 'oetFhnPdtSubClassCode'
            // 'tNextFuncName': ''
        });
        JCNxBrowseData('oFhnPdtGroupBrowsOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});


// Option Add Browse Product Sub Class
// var oFhnPdtGroupBrows = function(poReturnInput) {
//     var tInputReturnCode = poReturnInput.tReturnInputCode;
//     var tInputReturnName = poReturnInput.tReturnInputName;
//     var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

//     var tConditionWhere = '';
//         if(tSesUsrAgnCode!=''){
//             tConditionWhere +=" AND ( TFHMPdtF4Group.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtF4Group.FTAgnCode,'') = '' ) ";
//         }

//     var oOptionReturn = {
//         Title: ['product/product/product', 'tFhnPdtGroup'],
//         Table: {
//             Master: 'TFHMPdtF4Group',
//             PK: 'FTPgpCode'
//         },
//         Join: {
//                 Table: ['TFHMPdtF4Group_L'],
//                 On: [
//                     'TFHMPdtF4Group.FTPgpCode = TFHMPdtF4Group_L.FTPgpCode AND TFHMPdtF4Group_L.FNLngID = ' + nLangEdits,
//                 ]
//         },
//         Where: {
//             Condition: [tConditionWhere]
//         },
//         GrideView: {
//             ColumnPathLang: 'product/product/product',
//             ColumnKeyLang: ['tFhnPdtGroupCode', 'tFhnPdtGroupName'],
//             ColumnsSize: ['20%', '80%'],
//             DataColumns: ['TFHMPdtF4Group.FTPgpCode', 'TFHMPdtF4Group_L.FTPgpName'],
//             DataColumnsFormat: ['', ''],
//             WidthModal: 50,
//             Perpage: 10,
//             OrderBy: ['TFHMPdtF4Group.FTPgpCode'],
//             SourceOrder: "DESC"
//         },
//         CallBack: {
//             ReturnType: 'S',
//             Value: [tInputReturnCode, "TFHMPdtF4Group.FTPgpCode"],
//             Text: [tInputReturnName, "TFHMPdtF4Group_L.FTPgpName"],
//         },
//         // NextFunc: {
//         //     FuncName: tNextFuncName,
//         //     ArgReturn: ['FTEvnCode', 'FTEvnName']
//         // },
//         // RouteAddNew: 'productNoSaleEvent',
//         BrowseLev: 1
//     }
//     return oOptionReturn;
// }






// Click Browse Product Sub Class
$('#obFhnPdtComLinesBrows').click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        window.oFhnPdtComLinesBrowsOption = oCatProductBrows({
            'tReturnInputCode'  : 'oetFhnPdtComLinesCode',
            'tReturnInputName'  : 'oetFhnPdtComLinesName',
            'nCatLevel'         : 5,
            'tCatParent'        : 'oetFhnPdtGroupCode'
            // 'tNextFuncName': ''
        });
        JCNxBrowseData('oFhnPdtComLinesBrowsOption');
    } else {
        JCNxShowMsgSessionExpired();
    }
});


// Option Add Browse Product Sub Class
// var oFhnPdtComLinesBrows = function(poReturnInput) {
//     var tInputReturnCode = poReturnInput.tReturnInputCode;
//     var tInputReturnName = poReturnInput.tReturnInputName;
//     var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';

//     var tConditionWhere = '';
//         if(tSesUsrAgnCode!=''){
//             tConditionWhere +=" AND ( TFHMPdtF5ComLines.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtF5ComLines.FTAgnCode,'') = '' ) ";
//         }

//     var oOptionReturn = {
//         Title: ['product/product/product', 'tFhnPdtComLines'],
//         Table: {
//             Master: 'TFHMPdtF5ComLines',
//             PK: 'FTCmlCode'
//         },
//         Join: {
//                 Table: ['TFHMPdtF5ComLines_L'],
//                 On: [
//                     'TFHMPdtF5ComLines.FTCmlCode = TFHMPdtF5ComLines_L.FTCmlCode AND TFHMPdtF5ComLines_L.FNLngID = ' + nLangEdits,
//                 ]
//         },
//         Where: {
//             Condition: [tConditionWhere]
//         },
//         GrideView: {
//             ColumnPathLang: 'product/product/product',
//             ColumnKeyLang: ['tFhnPdtComLinesCode', 'tFhnPdtComLinesName'],
//             ColumnsSize: ['20%', '80%'],
//             DataColumns: ['TFHMPdtF5ComLines.FTCmlCode', 'TFHMPdtF5ComLines_L.FTCmlName'],
//             DataColumnsFormat: ['', ''],
//             WidthModal: 50,
//             Perpage: 10,
//             OrderBy: ['TFHMPdtF5ComLines.FTCmlCode'],
//             SourceOrder: "DESC"
//         },
//         CallBack: {
//             ReturnType: 'S',
//             Value: [tInputReturnCode, "TFHMPdtF5ComLines.FTCmlCode"],
//             Text: [tInputReturnName, "TFHMPdtF5ComLines_L.FTCmlName"],
//         },
//         // NextFunc: {
//         //     FuncName: tNextFuncName,
//         //     ArgReturn: ['FTEvnCode', 'FTEvnName']
//         // },
//         // RouteAddNew: 'productNoSaleEvent',
//         BrowseLev: 1
//     }
//     return oOptionReturn;
// }



// Click Browse Product Sub Class
$('#obtPdtFashionSave').click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

        var tPdtForSystem = $('#ocmPdtForSystem').val();
        if( tPdtForSystem == '5' ){
            var aStaModel = JSaCheckModelNoPdtFhn();
            if(aStaModel['rtCode']=='1'){
                var tMsg = "<?=language('product/product/product', 'tFhnPdtValidateModelNoDup')?> ";
                FSvCMNSetMsgWarningDialog(tMsg);
                return false;
            }

            if($('#oetFhnPdtModelNo').val()==''){
                var tMsg = "<?=language('product/product/product', 'tFhnPdtValidateRepleace')?> ";
                FSvCMNSetMsgWarningDialog(tMsg);
                $('#oetFhnPdtModelNo').val($('#oetPdtCode').val());
                // return false;
            }

            if($('.xWPdtFhnRow').length==0){
                var tMsg = "<?=language('product/product/product', 'tFhnPdtValidate')?><?=language('product/product/product', 'tFhnPdtDetail')?> ";
                FSvCMNSetMsgWarningDialog(tMsg);
                return false;
            }
        }

        JSnPdtFhnAddEdit();

    } else {
        JCNxShowMsgSessionExpired();
    }
});



function JSaCheckModelNoPdtFhn(){
    var aReultData = [];
    $.ajax({
        type: "POST",
        url: 'pdtFashionCheckModelNo',
        data: {tFhnPdtModelNo:$('#oetFhnPdtModelNo').val() , tPdtCode:$('#oetPdtCode').val()},
        async: false,
        timeout: 0,
        success: function(tResult) {
            let aReturn = JSON.parse(tResult);
            aReultData = aReturn;
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
     return aReultData;

}
// Add Edit From TFHMPdtFhn
function JSnPdtFhnAddEdit(){

    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: 'pdtFashionAddEditEvent',
        data: $('#ofmAddEditProductFashion').serialize(),
        cache: false,
        timeout: 0,
        success: function(tResult) {
            let aReturn = JSON.parse(tResult);
            if (aReturn['nStaEvent'] == 1) {
                JSxPdtFashionCallPageForm();
            }
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });

}

// Option Browse Category
// Create By : Napat(Jame) 01/07/2021
var oCatProductBrows = function(poReturnInput) {
    var tInputReturnCode    = poReturnInput.tReturnInputCode;
    var tInputReturnName    = poReturnInput.tReturnInputName;
    var nCatLevel           = poReturnInput.nCatLevel;
    var tCatParent          = $('#'+poReturnInput.tCatParent).val();
    var tSesUsrAgnCode      = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tLabelCode = '';
    var tLabelName = '';
    var tLabelTitle = '';

    switch(nCatLevel){
        case 2:
            tLabelTitle = 'tFhnPdtClass';
            tLabelCode = 'tFhnPdtClassCode';
            tLabelName = 'tFhnPdtClassName';
        break;
        case 3:
            tLabelTitle = 'tFhnPdtSubClass';
            tLabelCode = 'tFhnPdtSubClassCode';
            tLabelName = 'tFhnPdtSubClassName';
        break;
        case 4:
            tLabelTitle = 'tFhnPdtGroup';
            tLabelCode = 'tFhnPdtGroupCode';
            tLabelName = 'tFhnPdtGroupName';
        break;
        case 5:
            tLabelTitle = 'tFhnPdtComLines';
            tLabelCode = 'tFhnPdtComLinesCode';
            tLabelName = 'tFhnPdtComLinesName';
        break;
        default:
            tLabelTitle = 'tFhnPdtDepart';
            tLabelCode  = 'tFhnPdtDepartCode';
            tLabelName  = 'tFhnPdtDepartName';
    }

    var tConditionWhere = '';
    if( tSesUsrAgnCode != '' ){
        tConditionWhere +=" AND ( TCNMPdtCatInfo.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPdtCatInfo.FTAgnCode,'') = '' )   ";
    }

    tConditionWhere += " AND TCNMPdtCatInfo.FNCatLevel = "+nCatLevel+" ";
    tConditionWhere += " AND TCNMPdtCatInfo.FTCatStaUse = '1' ";


    var oOptionReturn = {
        Title: ['product/product/product', tLabelTitle],
        Table: {
            Master: 'TCNMPdtCatInfo',
            PK: 'FTCatCode'
        },
        Join: {
            Table: ['TCNMPdtCatInfo_L'],
            On: [
                'TCNMPdtCatInfo.FTCatCode = TCNMPdtCatInfo_L.FTCatCode AND TCNMPdtCatInfo.FNCatLevel = TCNMPdtCatInfo_L.FNCatLevel AND TCNMPdtCatInfo_L.FNLngID = ' + nLangEdits,
            ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: [tLabelCode, tLabelName],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TCNMPdtCatInfo.FTCatCode', 'TCNMPdtCatInfo_L.FTCatName'],
            DataColumnsFormat: ['', ''],
            // DisabledColumns: [2],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMPdtCatInfo.FDCreateOn'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtCatInfo.FTCatCode"],
            Text: [tInputReturnName, "TCNMPdtCatInfo_L.FTCatName"],
        },
        // NextFunc: {
        //     FuncName: 'JSxCatCheckBrowseLevel',
        //     ArgReturn: ['FTCatCode', 'FTCatName']
        // },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}

// เมื่อโหลดหน้า หมวดหมู่ ตรวจสอบ input code ของทุกหมวดว่ามี value ไหม ถ้าไม่มีให้ปิดไว้
// Create By : Napat(Jame) 01/07/2021
// function JSxCatCheckBrowseLevel(){
//     $('.xWCatChkValDisBtn').each(function(){
//         if( $(this).val() == "" ){ // ถ้า value ว่าง
//             var nCatLevel       = parseInt($(this).attr('data-catlevel'));
//             var nCatLevelBefore = nCatLevel - 1;
//             if( nCatLevel != 1 ){ // และไม่ใช่ Category Level 1
//                 var tValueBefore = $('.xWCatCodeLevel'+nCatLevelBefore).val(); // ตรวจสอบว่า Category Level -1 ได้กำหนดหรือยัง
//                 if( tValueBefore == "" ){
//                     $('.xWCatLevel'+nCatLevel).attr('disabled',true); // ถ้ายังไม่กำหนด ให้ปิด Btn
//                 }else{
//                     $('.xWCatLevel'+nCatLevel).attr('disabled',false); // ถ้ากำหนดแล้ว ให้เปิด Btn
//                 }
//             }
//         }
//     });
// }

$('document').ready(function(){
    // JSxCatCheckBrowseLevel();

    var tPdtForSystem   = $('#ocmPdtForSystem').val();
    var tLangCatPdtMod  = "";
    if( tPdtForSystem != '5' ){
        tLangCatPdtMod = '<?= language('product/product/product', 'tCatPdtMod') ?>';
    }else{
        tLangCatPdtMod = '<span style="color:red">*</span> <?= language('product/product/product', 'tFhnPdtMod') ?>';
    }
    $('#olbCatPdtMod').html(tLangCatPdtMod);
});


</script>
