<script>
$(document).ready(function(){

    $('.selectpicker').selectpicker('refresh');

    $('.xCNDatePicker').datepicker({
        format: "yyyy-mm-dd",
        todayHighlight: true,
        enableOnReadonly: false,
        disableTouchKeyboard : true,
        autoclose: true
    });

    $('#obtTransferBchOutBrowseBchRefIntDoc').click(function(){
        $('#odvTransferBchOutModalRefIntDoc').modal('hide');
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            window.oTransferBchOutBrowseBranchOption  = undefined;
            oTransferBchOutBrowseBranchOption         = oBranchOption_BranchOut({
                'tReturnInputCode'          : 'oetTransferBchOutRefIntBchCode',
                'tReturnInputName'          : 'oetTransferBchOutRefIntBchName',
                'tNextFuncName'             : 'JSxTransferBchOutRefIntNextFunctBrowsBranch',
                'tTransferBchOutAgnCode'    : '',
                'aArgReturn'                : ['FTBchCode','FTBchName','FTWahCode','FTWahName'],
            });
            JCNxBrowseData('oTransferBchOutBrowseBranchOption');
        }else{
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtTransferBchOutBrowseRefExtDocDateFrm').unbind().click(function(){
        $('#oetTransferBchOutRefIntDocDateFrm').datepicker('show');
    });

    $('#obtTransferBchOutBrowseRefExtDocDateTo').unbind().click(function(){
        $('#oetTransferBchOutRefIntDocDateTo').datepicker('show');
    });

    JSxRefIntDocHDDataTable();
});

 // ตัวแปร Option Browse Modal สาขา
 var oBranchOption_BranchOut = function(poDataFnc){
    var tInputReturnCode    = poDataFnc.tReturnInputCode;
    var tInputReturnName    = poDataFnc.tReturnInputName;
    var tNextFuncName       = poDataFnc.tNextFuncName;
    var tAgnCode            = poDataFnc.tTransferBchOutAgnCode;
    var aArgReturn          = poDataFnc.aArgReturn;

    tUsrLevel = "<?=$this->session->userdata('tSesUsrLevel')?>";
    tBchMulti = "<?=$this->session->userdata("tSesUsrBchCodeMulti"); ?>";
    tSQLWhereBch = "";
    tSQLWhereAgn = "";

    if(tUsrLevel != "HQ"){
        tSQLWhereBch = " AND TCNMBranch.FTBchCode IN ("+tBchMulti+")";
    }

    if(tAgnCode != ""){
        tSQLWhereAgn = " AND TCNMBranch.FTAgnCode IN ("+tAgnCode+")";
    }

    // ตัวแปร ออฟชั่นในการ Return
    var oOptionReturn       = {
        Title: ['authen/user/user', 'tBrowseBCHTitle'],
        Table: {
            Master  : 'TCNMBranch',
            PK      : 'FTBchCode'
        },
        Join: {
            Table   : ['TCNMBranch_L','TCNMWaHouse_L'],
            On      : ['TCNMBranch_L.FTBchCode = TCNMBranch.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits,
                        'TCNMBranch.FTWahCode = TCNMWaHouse_L.FTWahCode AND TCNMBranch.FTBchCode = TCNMWaHouse_L.FTBchCode AND TCNMWaHouse_L.FNLngID ='+nLangEdits,]
        },
        Where : {
            Condition : [tSQLWhereBch,tSQLWhereAgn]
        },
        GrideView: {
            ColumnPathLang      : 'authen/user/user',
            ColumnKeyLang       : ['tBrowseBCHCode', 'tBrowseBCHName'],
            ColumnsSize         : ['10%', '75%'],
            DataColumns         : ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName','TCNMWaHouse_L.FTWahCode','TCNMWaHouse_L.FTWahName'],
            DataColumnsFormat   : ['', ''],
            DisabledColumns     : [2,3],
            WidthModal          : 50,
            Perpage             : 10,
            OrderBy             : ['TCNMBranch.FTBchCode'],
            SourceOrder         : "ASC"
        },
        NextFunc:{
            FuncName:tNextFuncName
        },
        CallBack: {
            ReturnType  : 'S',
            Value       : [tInputReturnCode, "TCNMBranch.FTBchCode"],
            Text        : [tInputReturnName, "TCNMBranch_L.FTBchName"]
        },
    };
    return oOptionReturn;
}


$('#odvTransferBchOutModalRefIntDoc').on('hidden.bs.modal', function () {
    $('#wrapper').css('overflow','auto');
    $('#odvTransferBchOutModalRefIntDoc').css('overflow','auto');

});

$('#odvTransferBchOutModalRefIntDoc').on('show.bs.modal', function () {
    $('#wrapper').css('overflow','hidden');
    $('#odvTransferBchOutModalRefIntDoc').css('overflow','auto');
});

function JSxTransferBchOutRefIntNextFunctBrowsBranch(ptData){
    JSxCheckPinMenuClose();
    $('#odvTransferBchOutModalRefIntDoc').modal("show");
}

$('#obtRefIntDocFilter').on('click',function(){
    JSxRefIntDocHDDataTable();
});

function JSxRefIntDocHDDataTable(pnPage){
    if(pnPage == '' || pnPage == null){
        var pnNewPage = 1;
    }else{
        var pnNewPage = pnPage;
    }
    var nPageCurrent        = pnNewPage;
    var tTransferBchOutRefIntBchCode    = $('#oetTBIBchCodeTo').val();
    var tTransferBchOutRefIntDocNo      = $('#oetTransferBchOutRefIntDocNo').val();
    var tTransferBchOutRefIntDocDateFrm = $('#oetTransferBchOutRefIntDocDateFrm').val();
    var tTransferBchOutRefIntDocDateTo  = $('#oetTransferBchOutRefIntDocDateTo').val();
    var tTransferBchOutRefIntStaDoc     = $('#oetTransferBchOutRefIntStaDoc').val();
    JCNxOpenLoading();
    $.ajax({
        type: "POST",
        url: "docTBITransferBchOutRefIntDocDataTable",
        data: {
            'tTransferBchOutRefIntBchCode'     : tTransferBchOutRefIntBchCode,
            'tTransferBchOutRefIntDocNo'       : tTransferBchOutRefIntDocNo,
            'tTransferBchOutRefIntDocDateFrm'  : tTransferBchOutRefIntDocDateFrm,
            'tTransferBchOutRefIntDocDateTo'   : tTransferBchOutRefIntDocDateTo,
            'tTransferBchOutRefIntStaDoc'      : tTransferBchOutRefIntStaDoc,
            'nTransferBchOutRefIntPageCurrent' : nPageCurrent,
        },
        cache: false,
        Timeout: 0,
        success: function (oResult){
            $('#odvRefIntDocHDDataTable').html(oResult);
            JCNxCloseLoading();
        },
        error: function (jqXHR, textStatus, errorThrown) {
            JCNxResponseError(jqXHR, textStatus, errorThrown);
        }
    });
}

</script>
