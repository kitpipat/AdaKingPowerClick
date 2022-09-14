var nLangEdits = $('#oetLangID').val();

// ตัวแทนขาย
$('#obtDOBrowseAgn').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowseAgn = undefined;
        oDOBrowseAgn = oDOBrowseAgnCode({
            'tReturnInputCode': 'oetDOAgnCode',
            'tReturnInputName': 'oetDOAgnName',
        });
        JCNxBrowseData('oDOBrowseAgn');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowseAgnCode = function(poReturnInputAgn) {
    let tAgnInputReturnCode = poReturnInputAgn.tReturnInputCode;
    let tAgnInputReturnName = poReturnInputAgn.tReturnInputName;
    let oAgnOptionReturn = {
        Title: ['authen/user/user', 'tBrowseAgnTitle'],
        Table: {
            Master: 'TCNMAgency',
            PK: 'FTAgnCode'
        },
        Join: {
            Table: ['TCNMAgency_L'],
            On: [
                'TCNMAgency.FTAgnCode = TCNMAgency_L.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'authen/user/user',
            ColumnKeyLang: ['tBrowseAgnCode', 'tBrowseAgnName'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMAgency.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tAgnInputReturnCode, "TCNMAgency.FTAgnCode"],
            Text: [tAgnInputReturnName, "TCNMAgency_L.FTAgnName"]
        },
    };
    return oAgnOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// คลัง
$('#obtDOBrowseWahCode').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowseWah = undefined;
        oDOBrowseWah = oDOBrowseWahCode({
            'tReturnInputCode': 'oetDOWahCode',
            'tReturnInputName': 'oetDOWahName',
        });
        JCNxBrowseData('oDOBrowseWah');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowseWahCode = function(poReturnInputWah) {
    let tInputReturnCode = poReturnInputWah.tReturnInputCode;
    let tInputReturnName = poReturnInputWah.tReturnInputName;

    var tSQLWhereBch  = "";
    var tBchCode      = $('#ohdDOBchCode').val();
    var tUsrLevel     = $('#ohdUsrLevel').val();
    var tBchMulti     = $('#ohdBchMulti').val();
    
    if(tUsrLevel != "HQ" && tBchCode == ""){
        tSQLWhereBch = " AND TCNMWaHouse_L.FTBchCode = "+tBchMulti+"";
    }else if(tUsrLevel != "HQ" && tBchCode != ""){
        tSQLWhereBch = " AND TCNMWaHouse_L.FTBchCode = "+tBchCode+"";
    }else if(tBchCode != "") {
        tSQLWhereBch = " AND TCNMWaHouse_L.FTBchCode = "+tBchCode+"";
    }else{
        var tSQLWhereBch = "";
    }

    let oOptionReturn = {
        Title: ['company/branch/branch', 'tBCHTitle'],
        Table: {
            Master: 'TCNMWaHouse_L',
            PK: 'FTWahCode'
        },
        Where: {
            Condition: [tSQLWhereBch,'AND TCNMWaHouse_L.FNLngID = '+ nLangEdits]
        },
        GrideView: {
            ColumnPathLang: 'company/branch/branch',
            ColumnKeyLang: ['tBchCode', 'tBCHSubTitle'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMWaHouse_L.FTWahCode', 'TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMWaHouse_L.FTWahCode DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMWaHouse_L.FTWahCode"],
            Text: [tInputReturnName, "TCNMWaHouse_L.FTWahName"]
        },
    };
    return oOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// รหัสสินค้า
$('#obtDOBrowsePdtCode').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowsePdt = undefined;
        oDOBrowsePdt = oDOBrowsePdtCode({
            'tReturnInputCode': 'oetDOPdtCode',
            'tReturnInputName': 'oetDOPdtName',
        });
        JCNxBrowseData('oDOBrowsePdt');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowsePdtCode = function(poReturnInputPdt) {
    let tInputReturnCode = poReturnInputPdt.tReturnInputCode;
    let tInputReturnName = poReturnInputPdt.tReturnInputName;

    let oOptionReturn = {
        Title: ['ticket/product/product', 'tProduct'],
        Table: {
            Master: 'TCNMPdt',
            PK: 'FTPdtCode'
        },
        Join: {
            Table: ['TCNMPdt_L'],
            On: [
                'TCNMPdt.FTPdtCode = TCNMPdt_L.FTPdtCode AND TCNMPdt_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'ticket/product/product',
            ColumnKeyLang: ['tCodeProduct', 'tProductInformation'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdt.FTPdtCode', 'TCNMPdt_L.FTPdtName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdt.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdt.FTPdtCode"],
            Text: [tInputReturnName, "TCNMPdt_L.FTPdtName"]
        },
    };
    return oOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// กลุ่มสินค้า
$('#obtDOBrowseGrpProductCode').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowseGrpPdt = undefined;
        oDOBrowseGrpPdt = oDOBrowseGrpPdtCode({
            'tReturnInputCode': 'oetDOGrpProductCode',
            'tReturnInputName': 'oetDOGrpProductName',
        });
        JCNxBrowseData('oDOBrowseGrpPdt');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowseGrpPdtCode = function(poReturnInputGrpPdt) {
    let tInputReturnCode = poReturnInputGrpPdt.tReturnInputCode;
    let tInputReturnName = poReturnInputGrpPdt.tReturnInputName;

    // var tPdtCode = $('#oetDOPdtCode').val();
    // var tSQLWherePdt = '';

    // if (tPdtCode != '') {
    //     tSQLWherePdt = " AND TCNMBranch.FTBchCode IN ("+tPdtCode+")";
    // }

    let oOptionReturn = {
        Title: ['product/pdtgroup/pdtgroup', 'tPGPTitle'],
        Table: {
            Master: 'TCNMPdtGrp',
            PK: 'FTPgpChain'
        },
        Join: {
            Table: ['TCNMPdtGrp_L'],
            On: [
                'TCNMPdtGrp.FTPgpChain = TCNMPdtGrp_L.FTPgpChain AND TCNMPdtGrp_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtgroup/pdtgroup',
            ColumnKeyLang: ['tPGPChainCode', 'tPGPChain'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtGrp.FTPgpChain', 'TCNMPdtGrp_L.FTPgpName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtGrp.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtGrp.FTPgpChain"],
            Text: [tInputReturnName, "TCNMPdtGrp_L.FTPgpName"]
        },
    };
    return oOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// กลุ่มสินค้า
$('#obtDOBrowsePdtBrand').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowsePdtBrand = undefined;
        oDOBrowsePdtBrand = oDOBrowsePdtBrandCode({
            'tReturnInputCode': 'oetDOProducBrandCode',
            'tReturnInputName': 'oetDOProductBrandName',
        });
        JCNxBrowseData('oDOBrowsePdtBrand');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowsePdtBrandCode = function(poReturnInputPdtBrand) {
    let tInputReturnCode = poReturnInputPdtBrand.tReturnInputCode;
    let tInputReturnName = poReturnInputPdtBrand.tReturnInputName;
    let oOptionReturn = {
        Title: ['product/pdtbrand/pdtbrand', 'tPBNTitle'],
        Table: {
            Master: 'TCNMPdtBrand',
            PK: 'FTPbnCode'
        },
        Join: {
            Table: ['TCNMPdtBrand_L'],
            On: [
                'TCNMPdtBrand.FTPbnCode = TCNMPdtBrand_L.FTPbnCode AND TCNMPdtBrand_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtbrand/pdtbrand',
            ColumnKeyLang: ['tPBNCode', 'tPBNName'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtBrand.FTPbnCode', 'TCNMPdtBrand_L.FTPbnName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtBrand.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtBrand.FTPbnCode"],
            Text: [tInputReturnName, "TCNMPdtBrand_L.FTPbnName"]
        },
    };
    return oOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// โมเดลสินค้า
$('#obtDOBrowsePdtModel').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowsePdtModel = undefined;
        oDOBrowsePdtModel = oDOBrowsePdtModelCode({
            'tReturnInputCode': 'oetDOProducModelCode',
            'tReturnInputName': 'oetDOProductModelName',
        });
        JCNxBrowseData('oDOBrowsePdtModel');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowsePdtModelCode = function(poReturnInputPdtModel) {
    let tInputReturnCode = poReturnInputPdtModel.tReturnInputCode;
    let tInputReturnName = poReturnInputPdtModel.tReturnInputName;
    let oOptionReturn = {
        Title: ['product/pdtbrand/pdtbrand', 'tPBNTitle'],
        Table: {
            Master: 'TCNMPdtModel',
            PK: 'FTPmoCode'
        },
        Join: {
            Table: ['TCNMPdtModel_L'],
            On: [
                'TCNMPdtModel.FTPmoCode = TCNMPdtModel_L.FTPmoCode AND TCNMPdtModel_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtbrand/pdtbrand',
            ColumnKeyLang: ['tPBNCode', 'tPBNName'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtModel.FTPmoCode', 'TCNMPdtModel_L.FTPmoName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtModel.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtModel.FTPmoCode"],
            Text: [tInputReturnName, "TCNMPdtModel_L.FTPmoName"]
        },
    };
    return oOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// โมเดลสินค้า
$('#obtDOBrowsePdtModel').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowsePdtModel = undefined;
        oDOBrowsePdtModel = oDOBrowsePdtModelCode({
            'tReturnInputCode': 'oetDOProducModelCode',
            'tReturnInputName': 'oetDOProductModelName',
        });
        JCNxBrowseData('oDOBrowsePdtModel');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowsePdtModelCode = function(poReturnInputPdtModel) {
    let tInputReturnCode = poReturnInputPdtModel.tReturnInputCode;
    let tInputReturnName = poReturnInputPdtModel.tReturnInputName;
    let oOptionReturn = {
        Title: ['product/pdtmodel/pdtmodel', 'tPMOTitle'],
        Table: {
            Master: 'TCNMPdtModel',
            PK: 'FTPmoCode'
        },
        Join: {
            Table: ['TCNMPdtModel_L'],
            On: [
                'TCNMPdtModel.FTPmoCode = TCNMPdtModel_L.FTPmoCode AND TCNMPdtModel_L.FNLngID = ' + nLangEdits
            ]
        },
        GrideView: {
            ColumnPathLang: 'product/pdtmodel/pdtmodel',
            ColumnKeyLang: ['tPMOCode', 'tPMOName'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtModel.FTPmoCode', 'TCNMPdtModel_L.FTPmoName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtModel.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtModel.FTPmoCode"],
            Text: [tInputReturnName, "TCNMPdtModel_L.FTPmoName"]
        },
    };
    return oOptionReturn;
}

//-------------------------------------------------------------------------
//-------------------------------------------------------------------------
//-------------------------------------------------------------------------

// ประเภทสินค้า
$('#obtDOBrowsePdtTypeCode').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        JSxCheckPinMenuClose(); // Hidden Pin Menu
        window.oDOBrowsePdtType = undefined;
        oDOBrowsePdtType = oDOBrowsePdtTypeCode({
            'tReturnInputCode': 'oetDOProducTypeCode',
            'tReturnInputName': 'oetDOProductTypeName',
        });
        JCNxBrowseData('oDOBrowsePdtType');
    } else {
        JCNxShowMsgSessionExpired();
    }
   });

var oDOBrowsePdtTypeCode = function(poReturnInputPdtType) {
    let tInputReturnCode = poReturnInputPdtType.tReturnInputCode;
    let tInputReturnName = poReturnInputPdtType.tReturnInputName;
    
    var tSQLWhereAgn = '';
    var tAgnCode     = $('#oetDOAgnCode').val();

    if(tAgnCode != ""){
        tSQLWhereAgn = "AND TCNMPdtType.FTAgnCode IN ("+tAgnCode+")";
    }else{
        tSQLWhereAgn = "";
    }

    let oOptionReturn = {
        Title: ['product/pdttype/pdttype', 'tPTYTitle'],
        Table: {
            Master: 'TCNMPdtType',
            PK: 'FTPtyCode'
        },
        Join: {
            Table: ['TCNMPdtType_L'],
            On: [
                'TCNMPdtType.FTPtyCode = TCNMPdtType_L.FTPtyCode AND TCNMPdtType_L.FNLngID = ' + nLangEdits
            ]
        },
        Where: {
            Condition: [tSQLWhereAgn]
        },
        GrideView: {
            ColumnPathLang: 'product/pdttype/pdttype',
            ColumnKeyLang: ['tPTYTBCode', 'tPTYTBName'],
            ColumnsSize: ['15%', '90%'],
            WidthModal: 50,
            DataColumns: ['TCNMPdtType.FTPtyCode', 'TCNMPdtType_L.FTPtyName'],
            DataColumnsFormat: ['', ''],
            Perpage: 10,
            OrderBy: ['TCNMPdtType.FDCreateOn DESC'],
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtType.FTPtyCode"],
            Text: [tInputReturnName, "TCNMPdtType_L.FTPtyName"]
        },
    };
    return oOptionReturn;
}

// กดรูปดูไปหน้าจอ Edit 
function JSvDOCallPageEdit(paDocNo){
    JCNxOpenLoading();
    $.ajax({
        type : "POST",
        url  : 'monDOPageEdit',
        data    : {
            'ptDocNo'       : paDocNo
        },
        cache   : false,
        timeout : 0,
        success: function (tResult) {
            var aReturnData = JSON.parse(tResult)
            // console.log(aReturnData);
            if( aReturnData['nStaEvent'] == '1' ){
                JSxDONavDefult('showpage_edit');
                $('#odvDOContentPageDocument').html(aReturnData['tViewPageEdit']);
                window.scrollTo(0, 0);
                JSvDOLoadPdtDataTableHtml();

                // เช็คว่าเอกสารยกเลิก หรือเอกสารอนุมัติ
                // JSxPAMControlFormWhenCancelOrApprove();
            }else{
                var tMessageError = aReturnData['tStaMessg'];
                FSvCMNSetMsgErrorDialog(tMessageError);
            }
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Function: Call Page List
function JSvDOCallPageList() {
    $.ajax({
        type: "GET",
        url: "docDOFormSearchList",
        cache: false,
        timeout: 0,
        success: function(tResult) {
            JSxDONavDefult('showpage_list');
            $("#odvDOContentPageDocument").html(tResult);
            JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
            JSvDOCallPageDataTable();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

function JSvDOCallPageDataTable(){
    
    JCNxOpenLoading();
    JSxCheckPinMenuClose(); // Hidden Pin Menu

    // var nStaSession     = JCNxFuncChkSessionExpired();
    // if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){

    // var nPageCurrent    = pnPage;
    // if (typeof(nPageCurrent) == undefined || nPageCurrent == "") {
    //     nPageCurrent = "1";
    // }

    var oDOAdvSearch = {
        'tDOFrmBchCode'             : $('#ohdDOFrmBchCode').val(),
        'tDOFrmBchName'             : $('#oetDOFrmBchName').val(),
        'tDOToBchCode'              : $('#ohdDOToBchCode').val(),
        'tDOToBchName'              : $('#oetDOToBchName').val(),
        'tDODocDateForm'            : $("#oetDODocDateForm").val(),
        'tDODocDateTo'              : $("#oetDODocDateTo").val(),
        'tDOStaDoc'                 : $("#ocmDOStaDoc").val(),
        'tDODocNo'                  : $("#oetDODocNo").val().trim(),
        'nPageCurrent'              : $("#ohdDOPageCurrent").val()
    };
    localStorage.setItem("oDOAdvSearch", JSON.stringify(oDOAdvSearch));

    // var oAdvanceSearch = {
    //     tDOBchCode            : $("#ohdDOFrmBchCode").val(),
    //     tStaDoc             : $("#ocmDOStaDoc").val(),
    //     tDocNo              : $("#oetDODocNo").val().trim(),
    //     tDocDateForm        : $("#oetDODocDateForm").val(),
    //     tDocDateTo          : $("#oetDODocDateTo").val(),
    //     nPageCurrent        : $("#ohdDOPageCurrent").val()
    // };

    // var oAdvanceSearch  = JSoDOGetAdvanceSearchData();

    $.ajax({
        type: "POST",
        url: "monDODataTable",
        data: {
            oAdvanceSearch  : oDOAdvSearch
        },
        cache: false,
        timeout: 0,
        success: function(wResult){
            localStorage.removeItem("DO_LocalItemDataApv");
            // var aDOAdvSearch = JSON.parse(localStorage.getItem("oDOAdvSearch"));
            // if ( aDOAdvSearch != null ) {
                
            // }

            //เคลียค่า
            // localStorage.removeItem("aValues");
            // localStorage.tCheckBackStageData = '';
            $("#ostDODataTableDocument").html(wResult);
            JCNxCloseLoading();
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
    // }
}

// Function : Call Page Product Table In Add Document
function JSvDOLoadPdtDataTableHtml(pnPage) {

    var tDODocNo = $("#oetDODocNo").val();
    var tDOStaApv = $("#ohdDOStaApv").val();
    var tDOStaDoc = $("#ohdDOStaDoc").val();

    // เช็ค สินค้าใน table หน้านั้นๆ หรือไม่ ถ้าไม่มี nPage จะถูกลบ 1
    if ($("#otbDODocPdtAdvTableList .xWPdtItem").length == 0) {
        if (pnPage != undefined) {
            pnPage = pnPage - 1;
        }
    }

    if (pnPage == '' || pnPage == null) {
        var pnNewPage = 1;
    } else {
        var pnNewPage = pnPage;
    }
    var nPageCurrent        = pnNewPage;
    var tSearchPdtAdvTable = $('#oetDOFrmFilterPdtHTML').val();

    $.ajax({
        type: "POST",
        url: "monDOPdtAdvanceTableLoadData",
        data: {
            'tSelectBCH'            : $('#ohdDOBchCode').val(),
            'ptSearchPdtAdvTable'   : tSearchPdtAdvTable,
            'ptDODocNo'             : tDODocNo,
            'ptDOStaApv'            : tDOStaApv,
            'ptDOStaDoc'            : tDOStaDoc,
            'pnDOPageCurrent'       : nPageCurrent,
            'ptDODocType'           : $('#ohdDODocType').val()
        },
        cache: false,
        Timeout: 0,
        success: function(oResult) {
            var aReturnData = JSON.parse(oResult);
            if (aReturnData['checksession'] == 'expire') {
                JCNxShowMsgSessionExpired();
            } else {
                if (aReturnData['nStaEvent'] == '1') {
                    $('#odvDODataPanelDetailPDT #odvDODataPdtTableDTTemp').html(aReturnData['tDOPdtAdvTableHtml']);
                    if ($('#ohdDOStaImport').val() == 1) {
                        $('.xDOImportDT').show();
                    }
                    JCNxCloseLoading();
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            }
        },
        error: function(jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

// Control เมนู
function JSxDONavDefult(ptType) {
    if (ptType == 'showpage_list') { // แสดง
        $('#oliDOTitle').text('ตรวจสอบสถานะใบส่งของ');
        $("#oliDOTitle").show();
        $("#odvDOBtnGrpInfo").show();
        $("#obtDOCallPageAdd").show();

        // ซ่อน
        $("#oliDOTitleAdd").hide();
        $("#oliDOTitleEdit").hide();
        $("#oliDOTitleDetail").hide();
        $("#oliDOTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#obtDOCallBackPage").hide();
        $("#obtDOPrintDoc").hide();
        $("#obtDOCancelDoc").hide();
        $("#obtDOApproveDoc").hide();
        $("#odvDOBtnGrpSave").hide();
        $("#obtDOUpdateDoc").hide();
        $('#obtDOMultiApproveDoc').show();

    } else if (ptType == 'showpage_add') { // แสดง
        $('#oliDOTitle').text('ใบส่งของ');
        $("#oliDOTitle").show();
        $("#odvDOBtnGrpSave").show();
        $("#obtDOCallBackPage").show();
        $("#oliDOTitleAdd").show();

        // ซ่อน
        $("#oliDOTitleEdit").hide();
        $("#oliDOTitleDetail").hide();
        $("#oliDOTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#obtDOPrintDoc").hide();
        $("#obtDOCancelDoc").hide();
        $("#obtDOApproveDoc").hide();
        $("#odvDOBtnGrpInfo").hide();
        $("#obtDOUpdateDoc").hide();
        $('#obtDOMultiApproveDoc').hide();
    } else if (ptType == 'showpage_edit') { // แสดง
        $('#oliDOTitle').text('ใบส่งของ');
        $("#oliDOTitle").show();
        $("#odvDOBtnGrpSave").show();
        $("#obtDOApproveDoc").show();
        $("#obtDOCancelDoc").show();
        $("#obtDOCallBackPage").show();
        $("#oliDOTitleEdit").show();
        $("#obtDOPrintDoc").show();
        $("#obtDOUpdateDoc").show();

        // ซ่อน
        $("#oliDOTitleAdd").hide();
        $("#oliDOTitleDetail").hide();
        $("#oliDOTitleAprove").hide();
        $("#odvBtnAddEdit").hide();
        $("#odvDOBtnGrpInfo").hide();
        $('#obtDOMultiApproveDoc').hide();
    }

    // ล้างค่า
    localStorage.removeItem('IV_LocalItemDataDelDtTemp');
    localStorage.removeItem('LocalItemData');
}

// Event Click Submit From Document
$('#obtDOSubmitFromDoc').unbind().click(function() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
        // JSxPAMSetStatusClickSubmit(1);
        $('#ohdDOStaSaveAndApv').val("2");
        $('#obtDOSubmitDocument').click();
    } else {
        JCNxShowMsgSessionExpired();
    }
});

// Add/Edit Document
function JSxDOAddEditDocument() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        JSxDOValidateFormDocument();
    } else {
        JCNxShowMsgSessionExpired();
    }
}

// Validate From Add Or Update Document
function JSxDOValidateFormDocument(){

    $('#ofmDOFormAdd').validate().destroy();

    $('#ofmDOFormAdd').validate({
        focusInvalid: true,
        rules: {
            // oetDODocNo : {
            //     "required" : {
            //         depends: function (oElement) {
            //             if($("#ohdDORoute").val()  ==  "docDOEventAdd"){
            //                 if($('#ocbDOStaAutoGenCode').is(':checked')){
            //                     return false;
            //                 }else{
            //                     return true;
            //                 }
            //             }else{
            //                 return false;
            //             }
            //         }
            //     }
            // },
            oetDODateSent      : {"required" : true},
        },
        messages: {
            // oetDODocNo         : {"required" : $('#oetDODocNo').attr('data-validate-required')},
            oetDODateSent       : { "required" : $('#oetDODateSent').attr('data-validate-required') },
        },
        errorElement: "em",
        errorPlacement: function (error, element) {
            error.addClass("help-block");
            if(element.prop("type") === "checkbox") {
                error.appendTo(element.parent("label"));
            }else{
                var tCheck  = $(element.closest('.form-group')).find('.help-block').length;
                if(tCheck == 0) {
                    error.appendTo(element.closest('.form-group')).trigger('change');
                }
            }
        },
        highlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').addClass("has-error");
        },
        unhighlight: function (element, errorClass, validClass) {
            $(element).closest('.form-group').removeClass("has-error");
        },
        submitHandler: function (form){
            // if(!$('#ocbDOStaAutoGenCode').is(':checked')){
            //     JSxDOValidateDocCodeDublicate();
            // }else{
            //     if($("#ohdDOCheckSubmitByButton").val() == 1){
                    JSxDOSubmitEventByButton();
            //     }
            // }
        },
    });

    // Function: Validate Success And Send Ajax Add/Update Document
    function JSxDOSubmitEventByButton(){

        JCNxOpenLoading();
        // var tDODocNo = '';
        // if($("#ohdDORoute").val() !=  "monDOEventAdd"){
        var tDODocNo    = $('#oetDODocNo').val();
        // }

        $.ajax({
            type: "POST",
            url: "monDOChkHavePdtForDocDTTemp",
            data: {
                'ptDODocNo'         : tDODocNo,
                'tDOSesSessionID'   : $('#ohdSesSessionID').val(),
                'tDOUsrCode'        : $('#ohdDOUsrCode').val(),
                'tDOLangEdit'       : $('#ohdDOLangEdit').val(),
                'tSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                // JCNxCloseLoading();
                var aDataReturnChkTmp = JSON.parse(oResult);
                // $('.xWDODisabledOnApv').attr('disabled',false);
                if (aDataReturnChkTmp['nStaReturn'] == '1'){
                    $.ajax({
                        type    : "POST",
                        url     : $("#ohdDORoute").val(),
                        data    : $("#ofmDOFormAdd").serialize(),
                        cache   : false,
                        timeout : 0,
                        success : function(oResult){
                            // JCNxCloseLoading();
                            var aDataReturnEvent    = JSON.parse(oResult);
                            if(aDataReturnEvent['nStaReturn'] == '1'){
                                var nDOStaCallBack      = aDataReturnEvent['nStaCallBack'];
                                var nDODocNoCallBack    = aDataReturnEvent['tCodeReturn'];
                                
                                let oDOCallDataTableFile = {
                                    ptElementID: 'odvDOShowDataTable',
                                    ptBchCode: $('#ohdDOBchCode').val(),
                                    ptDocNo: nDODocNoCallBack,
                                    ptDocKey:'TCNTPdtPickHD',
                                }
                                JCNxUPFInsertDataFile(oDOCallDataTableFile);

                                var bStaSaveAndApv = $('#ohdDOStaSaveAndApv').val();
                                if( bStaSaveAndApv == "1" ){
                                    JSxDOApproveDocument(false);
                                }else{
                                    switch(nDOStaCallBack){
                                        case '1' :
                                            JSvDOCallPageEdit(nDODocNoCallBack);
                                        break;
                                        // case '2' :
                                        //     JSvDOCallPageAddDoc();
                                        // break;
                                        case '3' :
                                            JSvDOCallPageList();
                                        break;
                                        default :
                                            JSvDOCallPageEdit(nDODocNoCallBack);
                                    }
                                }
                            }else{
                                var tMessageError = aDataReturnEvent['tStaMessg'];
                                FSvCMNSetMsgErrorDialog(tMessageError);
                            }
                        },
                        error   : function (jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                }else if(aDataReturnChkTmp['nStaReturn'] == '800'){
                    var tMsgDataTempFound   = aDataReturnChkTmp['tStaMessg'];
                    FSvCMNSetMsgWarningDialog('<p class="text-left">'+tMsgDataTempFound+'</p>');
                }else{
                    var tMsgErrorFunction   = aDataReturnChkTmp['tStaMessg'];
                    FSvCMNSetMsgErrorDialog('<p class="text-left">'+tMsgErrorFunction+'</p>');
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

}

// อนุมัติเอกสาร
function JSxDOApproveDocument(pbIsConfirm) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
        try {
            if (pbIsConfirm) {
                $("#odvDOModalAppoveDoc").modal('hide');
                var tDocNo      = $('#oetDODocNo').val();
                var tBchCode    = $('#ohdDOBchCode').val();
                // var tAlwQtyPickNotEqQtyOrd = $('#ohdDOAlwQtyPickNotEqQtyOrd').val();
                // return;

                $.ajax({
                    type: "POST",
                    url: "monDOApproveDocument",
                    data: {
                        tDocNo                  : tDocNo,
                        tBchCode                : tBchCode,
                        // tAlwQtyPickNotEqQtyOrd  : tAlwQtyPickNotEqQtyOrd,
                        // tDocType                : $('#ohdDODocType').val()
                    },
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        // $("#odvDOModalAppoveDoc").modal("hide");
                        // $('.modal-backdrop').remove();
                        var aReturnData = JSON.parse(tResult);
                        var tMessageError = aReturnData['tStaMessg'];
                        if (aReturnData['nStaEvent'] == '1') {

                            setTimeout(function(){
                                JSxDOCallSubscribeMQ();
                            }, 500);
                            
                            // JSvDOCallPageEdit(tDocNo);
                        } else if( aReturnData['nStaEvent'] == '800' ) {
                            setTimeout(function(){
                                FSvCMNSetMsgWarningDialog(tMessageError,'JSvDOCallPageEdit',tDocNo);
                                JCNxCloseLoading();
                            }, 500);
                        } else {
                            setTimeout(function(){
                                FSvCMNSetMsgErrorDialog(tMessageError);
                                JCNxCloseLoading();
                            }, 500);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                $("#odvDOModalAppoveDoc").modal('show');
            }
        } catch (err) {
            console.log("JSxDOApproveDocument Error: ", err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}


// Function: Cancel Document PAM
function JSnDOCancelDocument(pbIsConfirm) {
    if (pbIsConfirm) {
        var tDODocNo = $("#oetDODocNo").val();
        $.ajax({
            type: "POST",
            url: "monDOCancelDocument",
            data: {
                'ptDODocNo': tDODocNo
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvDOPopupCancel").modal("hide");
                $('.modal-backdrop').remove();
                var aReturnData = JSON.parse(tResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSvDOCallPageEdit(tDODocNo);
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                    JCNxCloseLoading();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    } else {
        $('#odvDOPopupCancel').modal({ backdrop: 'static', keyboard: false });
        $("#odvDOPopupCancel").modal("show");
    }
}