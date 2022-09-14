<script type="text/javascript">
JSxControlRegBusOth();
    $('#ocmRegBusType').on('change',function(){
        JSxControlRegBusOth();
    });

function JSxControlRegBusOth(){
    if($('#ocmRegBusType').val()=='5'){
                $('#odvRegBusOth').show();
            }else{
                $('#odvRegBusOth').hide();
            }
}


// Functionality : Applove Document 
// Parameters : Event Click Buttom
// Creator : 09/07/2019 Wasin(Yoshi)
// LastUpdate: -
// Return : Status Applove Document
// Return Type : -
function JSxAPCApproveCst(pbIsConfirm){
    if(pbIsConfirm){

        var tAPCSrvCode = $('#oetAPCSrvCode').val();
        if(tAPCSrvCode!=''){

            $("#odvAPCModalAppoveCst").modal("hide");
        $('body').removeClass('modal-open');
        $('.modal-backdrop').remove();
        $.ajax({
            type : "POST",
            url : "ApproveCstOnChecked",
            data: {
                'rnRegID'   : $('#ohdRegID').val(),
                'tAPCSrvCode' : tAPCSrvCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult){
                console.log(tResult);
                try {
                    let oResult = JSON.parse(tResult);
                    if (oResult.nStaEvent == "1") {
                     FSvCMNSetMsgSucessDialog(oResult.tStaMessg);
                     JSvAPCApproveCstGetPageList();
                     $('#oetAPCSrvCode').val('');
                     $('#oetAPCSrvName').val('');
                        }else{
                     FSvCMNSetMsgWarningDialog(oResult.tStaMessg);
                    }
          
                } catch (err) {}
                // JSoSOCallSubscribeMQ();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }else{
        FSvCMNSetMsgWarningDialog('กรุณาเลือกเซิฟเวอร์');
    }
    }else{
        $('#odvAPCModalAppoveCst').modal({backdrop:'static',keyboard:false});
        $("#odvAPCModalAppoveCst").modal("show");
    }
}




$('#obtBrowseAPCSrvCode').on('click', function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            // Create By Witsarut 04/10/2019
            JSxCheckPinMenuClose();
            // Create By Witsarut 04/10/2019
            window.oPdtBrowseAPCSrvCodeOption = oPdtBrowseAPCSrvCode({
                'tReturnInputCode': 'oetAPCSrvCode',
                'tReturnInputName': 'oetAPCSrvName'
            });
            JCNxBrowseData('oPdtBrowseAPCSrvCodeOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });



        // Option Browse Product Vat
        var oPdtBrowseAPCSrvCode = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var tRegLicType = $('#ocmRegLicType').val();
        var oOptionReturn = {
            Title: ['customerlicense/customerlicense/customerlicense', 'tCLBSrvTitle'],
            Table: {
                Master: 'TRGMPosSrv',
                PK: 'FTSrvCode'
            },
            Join: {
                Table: ['TRGMPosSrv_L'],
                On: ['TRGMPosSrv.FTSrvCode = TRGMPosSrv_L.FTSrvCode']
            },
            Where: {
                Condition: [
                    "AND TRGMPosSrv.FTSrvGroup = '"+tRegLicType+"' ",
                ]
            },
            GrideView: {
                ColumnPathLang: 'customerlicense/customerlicense/customerlicense',
                ColumnKeyLang: ['tCLBSrvCode', 'tCLBSrvName'],
                DataColumns: ['TRGMPosSrv.FTSrvCode', 'TRGMPosSrv_L.FTSrvName'],
                Perpage: 10,
                OrderBy: ['TRGMPosSrv.FDCreateOn DESC'],
                // SourceOrder		: "ASC"
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TRGMPosSrv.FTSrvCode"],
                Text: [tInputReturnName, "TRGMPosSrv_L.FTSrvName"],
            },
            // DebugSQL : true
        };
        return oOptionReturn;
    }



</script>
