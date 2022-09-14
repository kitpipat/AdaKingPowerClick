<script>

    var tUsrLevel 	  	    = "<?=$this->session->userdata("tSesUsrLevel");?>";
    var tBchCodeMulti 	    = "<?=$this->session->userdata("tSesUsrBchCodeMulti");?>";
    var nLangEdits          = "<?=$this->session->userdata("tLangEdit")?>";

    $("document").ready(function(){
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu*/
        JSvLGHCallPageList();
    });

    $('#ocmLGHReqType').off('change').on('change', function(){
        var tReqType = $(this).val();
        if( tReqType == '1' ){
            $('#odvLGHDateFile').show();
        }else{
            $('#odvLGHDateFile').hide();
        }
    });

    $('#ocmLGHReqPosType').off('change').on('change', function(){
        $(this).selectpicker('refresh');
        $('#oetLGHReqPosCode').val('');
        $('#oetLGHReqPosName').val('');
    });

    $('#oetLGHReqBchCode').off('change').on('change', function(){
        $('#oetLGHReqPosCode').val('');
        $('#oetLGHReqPosName').val('');
    });

    $('#obtLGHConfirm').off('click').on('click', function(){
        var tReqDateFile    = $('#oetLGHReqDateFile').val();
        var tReqType        = $('#ocmLGHReqType').val();
        if( tReqDateFile == "" && tReqType == '1' ){
            FSvCMNSetMsgWarningDialog('กรุณากำหนดวันที่ของข้อมูลที่คุณต้องการ');
            return;
        }

        $('#odvLGHModalRequestFile').modal('hide');

        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "toolLogHistoryEventRequestFile",
            data: $('#ofmLGHRequestData').serialize(),
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                if( aResult['nStaEvent'] == '1' ){
                    $('#ofmLGHRequestData input').val('');
                    $('#ofmLGHRequestData #ocmLGHReqType').val('1');
                    $('#ofmLGHRequestData #ocmLGHReqPosType').val('');
                    $('#ofmLGHRequestData .xCNDatePicker').datepicker('setDate', null);
                    $('#ofmLGHRequestData .selectpicker').selectpicker('refresh');
                    FSvCMNSetMsgWarningDialog(aResult['tStaMessg']);
                    JSvLGHPageDataTable();
                }else{
                    FSvCMNSetMsgErrorDialog(aResult['tStaMessg']);
                    JCNxCloseLoading();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    });

    // Date File
    $('#obtLGHReqDateFile').off('click').on('click', function(){
        $('#oetLGHReqDateFile').datepicker('show');
    });

    $('#obtLGHReqBrowseBch').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oLGHBrowseRequestBch = oLGHBrowseBchOption({
                'tReturnInputCode': 'oetLGHReqBchCode',
                'tReturnInputName': 'oetLGHReqBchName',
            });
            JCNxBrowseData('oLGHBrowseRequestBch');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtLGHReqBrowsePos').unbind().click(function() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose(); // Hidden Pin Menu
            oLGHBrowseRequestPos = oLGHBrowsePosOption({
                'tReturnInputCode'  : 'oetLGHReqPosCode',
                'tReturnInputName'  : 'oetLGHReqPosName',
                'tParamBchCode'     : $('#oetLGHReqBchCode').val(),
                'tParamPosType'     : $('#ocmLGHReqPosType').val()
            });
            JCNxBrowseData('oLGHBrowseRequestPos');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    $('#obtLGHRequest').off('click').on('click', function(){
        $('#odvLGHModalRequestFile').modal('show');
    });

    function JSvLGHCallPageList(){
        JCNxOpenLoading();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "toolLogHistoryPageList",
                cache: false,
                timeout: 0,
                success: function (tResult){
                    $("#odvLGHContentPageDocument").html(tResult);
                    JSvLGHPageDataTable();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    function JSvLGHPageDataTable(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {

            var nPageCurrent = 1;
            if( pnPage == "" || pnPage === undefined ){
                nPageCurrent = 1;
            }else{
                nPageCurrent = pnPage;
            }

            JCNxOpenLoading();

            var oLGHAdvSearch = {
                'tLGHBchCode'           : $('#oetLGHBchCode').val(),
                'tLGHPosType'           : $('#ocmLGHPosType').val(),
                'tLGHPosCode'           : $('#oetLGHPosCode').val(),
                'tLGHDocDateForm'       : $('#oetLGHDocDateForm').val(),
                'tLGHDocDateTo'         : $('#oetLGHDocDateTo').val(),
                'tLGHStatus'            : $("#ocmLGHStatus").val(),
                'tLGHType'              : $("#ocmLGHType").val(),
                'nPageCurrent'          : nPageCurrent
            };

            $.ajax({
                type: "POST",
                url: "toolLogHistoryPageDataTable",
                data: {
                    oAdvanceSearch  : oLGHAdvSearch
                },
                cache: false,
                timeout: 0,
                success: function (tResult){
                    $("#ostLGHDataTableDocument").html(tResult);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    var oLGHBrowseBchOption = function(poReturnInputBch) {
        let tInputReturnCode    = poReturnInputBch.tReturnInputCode;
        let tInputReturnName    = poReturnInputBch.tReturnInputName;
        var tSQLWhereBch        = '';
        
        if(tUsrLevel != "HQ"){
            tSQLWhereBch += " AND TCNMBranch.FTBchCode IN ("+tBchCodeMulti+")";
        }

        let oOptionReturn = {
            Title: ['company/branch/branch', 'tBCHTitle'],
            Table: {
                Master: 'TCNMBranch',
                PK: 'FTBchCode'
            },
            Join: {
                Table: ['TCNMBranch_L'],
                On: [
                    'TCNMBranch.FTBchCode = TCNMBranch_L.FTBchCode AND TCNMBranch_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tSQLWhereBch]
            },
            GrideView: {
                ColumnPathLang: 'company/branch/branch',
                ColumnKeyLang: ['tBchCode', 'tBCHSubTitle'],
                ColumnsSize: ['15%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMBranch.FTBchCode', 'TCNMBranch_L.FTBchName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMBranch.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMBranch.FTBchCode"],
                Text: [tInputReturnName, "TCNMBranch_L.FTBchName"]
            },
        };
        return oOptionReturn;
    }

    var oLGHBrowsePosOption = function(poReturnInput) {
        let tInputReturnCode    = poReturnInput.tReturnInputCode;
        let tInputReturnName    = poReturnInput.tReturnInputName;
        let tParamBchCode       = poReturnInput.tParamBchCode;
        let tParamPosType       = poReturnInput.tParamPosType;
        var tSQLWhere           = "";

        if( tParamPosType != "" ){
            tSQLWhere += " AND TCNMPos.FTPosType = '"+tParamPosType+"' ";
        }

        if( tParamBchCode != "" ){
            tSQLWhere += " AND TCNMPos.FTBchCode = '"+tParamBchCode+"' ";
        }
        
        if(tUsrLevel != "HQ"){
            tSQLWhere += " AND TCNMPos.FTBchCode IN ("+tBchCodeMulti+")";
        }

        let oOptionReturn = {
            Title: ['pos/salemachine/salemachine', 'tPOSTitle'],
            Table: {
                Master: 'TCNMPos',
                PK: 'FTPosCode'
            },
            Join: {
                Table: ['TCNMPos_L'],
                On: [
                    'TCNMPos.FTBchCode = TCNMPos_L.FTBchCode AND TCNMPos.FTPosCode = TCNMPos_L.FTPosCode AND TCNMPos_L.FNLngID = ' + nLangEdits
                ]
            },
            Where: {
                Condition: [tSQLWhere]
            },
            GrideView: {
                ColumnPathLang: 'pos/salemachine/salemachine',
                ColumnKeyLang: ['tPOSCode', 'tPOSName'],
                ColumnsSize: ['15%', '90%'],
                WidthModal: 50,
                DataColumns: ['TCNMPos.FTPosCode', 'TCNMPos_L.FTPosName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMPos.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMPos.FTPosCode"],
                Text: [tInputReturnName, "TCNMPos_L.FTPosName"]
            },
        };
        return oOptionReturn;
    }

    function JSvLGHClickPageList(pnPage){
        var nPageCurrent = '';
        switch(pnPage){
            case 'next' :
                $('.xWBtnNext').addClass('disabled');
                nPageOld = $('.xWLGHPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน

                nPageCurrent = nPageNew
            break;
            case 'previous' :
                nPageOld = $('.xWLGHPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
            break;
            default:
                nPageCurrent = pnPage
        }
        JSvLGHPageDataTable(nPageCurrent);
    }

</script>