<script>

$('.xCNDatePicker').datepicker({
    format: "yyyy-mm-dd",
    todayHighlight: true,
    enableOnReadonly: false,
    disableTouchKeyboard : true,
    autoclose: true
});


$('#obtFhnPdtStratDate').unbind().click(function(){
    $('#oetFhnPdtStratDate').datepicker('show');
});



if($('#odvFnhPageAddPdtName').val()==''){
    $('#odvFnhPageAddPdtName').text($('#oetPdtName').val());
}


// Click Browse Product Sub Class
$('#obFhnPdtSeasonBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtSeasonBrowsOption = oFhnPdtSeasonBrows({
        'tReturnInputCode': 'oetFhnPdtSeasonCode',
        'tReturnInputName': 'oetFhnPdtSeasonName',
        'tNextFuncName': 'JSxFhnSrtRefCodeGenerate'
    });
    JCNxBrowseData('oFhnPdtSeasonBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtSeasonBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND ( TFHMPdtSeason.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtSeason.FTAgnCode,'') = '' ) ";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableSeason'],
        Table: {
            Master: 'TFHMPdtSeason',
            PK: 'FTSeaCode'
        },
        Join: {
                Table: ['TFHMPdtSeason_L'],
                On: [
                    'TFHMPdtSeason.FTSeaCode = TFHMPdtSeason_L.FTSeaCode AND TFHMPdtSeason.FTSeaChain = TFHMPdtSeason_L.FTSeaChain AND TFHMPdtSeason_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableSeasonCode', 'tFhnPdtDataTableSeasonName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TFHMPdtSeason.FTSeaCode', 'TFHMPdtSeason_L.FTSeaName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFHMPdtSeason.FTSeaCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TFHMPdtSeason.FTSeaCode"],
            Text: [tInputReturnName, "TFHMPdtSeason_L.FTSeaName"],
        },
        NextFunc: {
            FuncName: tNextFuncName
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}



// Click Browse Product Sub Class
$('#obFhnPdtFabricBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtFabricBrowsOption = oFhnPdtFabricBrows({
        'tReturnInputCode': 'oetFhnPdtFabricCode',
        'tReturnInputName': 'oetFhnPdtFabricName',
        'tNextFuncName': 'JSxFhnSrtRefCodeGenerate'
    });
    JCNxBrowseData('oFhnPdtFabricBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtFabricBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND  ( TFHMPdtFabric.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TFHMPdtFabric.FTAgnCode,'') = '' ) ";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableFabric'],
        Table: {
            Master: 'TFHMPdtFabric',
            PK: 'FTFabCode'
        },
        Join: {
                Table: ['TFHMPdtFabric_L'],
                On: [
                    'TFHMPdtFabric.FTFabCode = TFHMPdtFabric_L.FTFabCode AND TFHMPdtFabric_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableFabricCode', 'tFhnPdtDataTableFabricName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TFHMPdtFabric.FTFabCode', 'TFHMPdtFabric_L.FTFabName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TFHMPdtFabric.FTFabCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TFHMPdtFabric.FTFabCode"],
            Text: [tInputReturnName, "TFHMPdtFabric_L.FTFabName"],
        },
        NextFunc: {
            FuncName: tNextFuncName
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}




// Click Browse Product Sub Class
$('#obFhnPdtColorBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtColorBrowsOption = oFhnPdtColorBrows({
        'tReturnInputCode': 'oetFhnPdtColorCode',
        'tReturnInputName': 'oetFhnPdtColorName',
        'tNextFuncName': 'JSxFhnSrtRefCodeGenerate'
    });
    JCNxBrowseData('oFhnPdtColorBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtColorBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND  ( TCNMPdtColor.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPdtColor.FTAgnCode,'') = '' )";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableColor'],
        Table: {
            Master: 'TCNMPdtColor',
            PK: 'FTClrCode'
        },
        Join: {
                Table: ['TCNMPdtColor_L'],
                On: [
                    'TCNMPdtColor.FTClrCode = TCNMPdtColor_L.FTClrCode AND TCNMPdtColor_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableColorCode', 'tFhnPdtDataTableColorName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TCNMPdtColor.FTClrCode', 'TCNMPdtColor_L.FTClrName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMPdtColor.FTClrCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtColor.FTClrCode"],
            Text: [tInputReturnName, "TCNMPdtColor_L.FTClrName"],
        },
        NextFunc: {
            FuncName: tNextFuncName
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}



// Click Browse Product Sub Class
$('#obFhnPdtSizeBrows').unbind().click(function() {
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
    window.oFhnPdtSizeBrowsOption = oFhnPdtSizeBrows({
        'tReturnInputCode': 'oetFhnPdtSizeCode',
        'tReturnInputName': 'oetFhnPdtSizeName',
        'tNextFuncName': 'JSxFhnSrtRefCodeGenerate'
    });
    JCNxBrowseData('oFhnPdtSizeBrowsOption');
} else {
    JCNxShowMsgSessionExpired();
}
});


// Option Add Browse Product Sub Class
var oFhnPdtSizeBrows = function(poReturnInput) {
    var tInputReturnCode = poReturnInput.tReturnInputCode;
    var tInputReturnName = poReturnInput.tReturnInputName;
    var tSesUsrAgnCode = '<?=$this->session->userdata("tSesUsrAgnCode")?>';
    var tNextFuncName = poReturnInput.tNextFuncName;
    var tConditionWhere = '';
        if(tSesUsrAgnCode!=''){
            tConditionWhere +=" AND  ( TCNMPdtSize.FTAgnCode = '"+tSesUsrAgnCode+"' OR ISNULL(TCNMPdtSize.FTAgnCode,'') = '' ) ";
        }

    var oOptionReturn = {
        Title: ['product/product/product', 'tFhnPdtDataTableSize'],
        Table: {
            Master: 'TCNMPdtSize',
            PK: 'FTPszCode'
        },
        Join: {
                Table: ['TCNMPdtSize_L'],
                On: [
                    'TCNMPdtSize.FTPszCode = TCNMPdtSize_L.FTPszCode AND TCNMPdtSize_L.FNLngID = ' + nLangEdits,
                ]
        },
        Where: {
            Condition: [tConditionWhere]
        },
        GrideView: {
            ColumnPathLang: 'product/product/product',
            ColumnKeyLang: ['tFhnPdtDataTableSizeCode', 'tFhnPdtDataTableSizeName'],
            ColumnsSize: ['20%', '80%'],
            DataColumns: ['TCNMPdtSize.FTPszCode', 'TCNMPdtSize_L.FTPszName'],
            DataColumnsFormat: ['', ''],
            WidthModal: 50,
            Perpage: 10,
            OrderBy: ['TCNMPdtSize.FTPszCode'],
            SourceOrder: "DESC"
        },
        CallBack: {
            ReturnType: 'S',
            Value: [tInputReturnCode, "TCNMPdtSize.FTPszCode"],
            Text: [tInputReturnName, "TCNMPdtSize_L.FTPszName"],
        },
        NextFunc: {
            FuncName: tNextFuncName,
        },
        // RouteAddNew: 'productNoSaleEvent',
        BrowseLev: 1
    }
    return oOptionReturn;
}


function JSxFhnSrtRefCodeGenerate(){

    if($("#ohdPdtClrSzeEvent").val()=='pdtFashionEventAdd'){
    var tFhnPdtRefCode = $('#oetFhnPdtSeasonCode').val()+$('#oetFhnModNo').val()+$('#oetFhnPdtFabricCode').val()+$('#oetFhnPdtColorCode').val()+$('#oetFhnPdtSizeCode').val();
    $('#oetFhnPdtRefCode').val(tFhnPdtRefCode);
    }
}




// Click Browse Product Sub Class
$('#obtPdtClrSzeSave').unbind().click(function() {
    JCNxOpenLoading();
var nStaSession = JCNxFuncChkSessionExpired();
if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {

    if($('#oetFhnPdtRefCode').val()==''){
            var tMsg = "<?=language('product/product/product', 'tFhnPdtValidate')?> "+$('#oetFhnPdtRefCode').data('validate');
            FSvCMNSetMsgWarningDialog(tMsg);
            JCNxCloseLoading();
            return false;
        }

        JSnFhnPdtClrSzeAddEdit();

} else {
    JCNxShowMsgSessionExpired();
}
});



// Add Edit From TFHMPdtFhn
function JSnFhnPdtClrSzeAddEdit(){
 var tPdtClrSzeEvent = $('#ohdPdtClrSzeEvent').val();
 JCNxOpenLoading();
$.ajax({
    type: "POST",
    url: tPdtClrSzeEvent,
    data: $('#ofmAddEditPdtClrSze').serialize(),
    cache: false,
    timeout: 0,
    success: function(tResult) {
        let aReturn = JSON.parse(tResult);
        if (aReturn['nStaEvent'] == 1) {
            JSvFhnPdtClrPszLoadDataTable();
            if(aReturn['nFhnSeq'] == '1'){
                JSnPdtFhnAddEdit();
            }
        }else{
            FSvCMNSetMsgWarningDialog(aReturn['tStaMessg']);
        }
        JCNxCloseLoading();
    },
    error: function(jqXHR, textStatus, errorThrown) {
        JCNxResponseError(jqXHR, textStatus, errorThrown);
    }
});

}


</script>