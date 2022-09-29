<script type="text/javascript">
    $(document).ready(function() {

        $('#odvBtnAddEdit .xWBtnTab1').show();

        if (JSbSrvPriIsCreatePage()) {
            $('#odvBtnAddEdit .xWBtnTab2').hide();
            //Server Printer Code
            $("#oetSrvPriCode").attr("disabled", true);
            $('#ocbSrvPriAutoGenCode').change(function() {
                if ($('#ocbSrvPriAutoGenCode').is(':checked')) {
                    $('#oetSrvPriCode').val('');
                    $("#oetSrvPriCode").attr("disabled", true);
                    $('#odvSrvPriCodeForm').removeClass('has-error');
                    $('#odvSrvPriCodeForm em').remove();
                } else {
                    $("#oetSrvPriCode").attr("disabled", false);
                }
            });
            JSxSrvPriVisibleComponent('#odvSrvPriAutoGenCode', true);
        }

        if (JSbSrvPriIsUpdatePage()) {
            $('#odvBtnAddEdit .xWBtnTab2').show();
            // Server Printer  Code
            $("#oetSrvPriCode").attr("readonly", true);
            $('#odvSrvPriAutoGenCode input').attr('disabled', true);
            JSxSrvPriVisibleComponent('#odvSrvPriAutoGenCode', false);
        }
    });

    $('.xWTooltipsBT').tooltip({
        'placement': 'bottom'
    });
    $('[data-toggle="tooltip"]').tooltip({
        'placement': 'top'
    });

    $('#oimSrvPriBrowseProvince').click(function() {
        JCNxBrowseData('oPvnOption');
    });

    if (JCNSrvPriIsUpdatePage()) {
        $("#obtGenCodeSrvPri").attr("disabled", true);
    }

    //BrowseAgn 
    $('#oimSrvPriBrowseAgn').click(function(e) {
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oSrbPriBrowseAgencyOption = oSrvPriBrowseAgn({
                'tReturnInputCode': 'oetSrvPriAgnCode',
                'tReturnInputName': 'oetSrvPriAgnName',
            });
            JCNxBrowseData('oSrbPriBrowseAgencyOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    var nLangEdits = <?php echo $this->session->userdata("tLangEdit") ?>;

    //Option Agn
    var oSrvPriBrowseAgn = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;

        var oOptionReturn = {
            Title: ['ticket/agency/agency', 'tAggTitle'],
            Table: {
                Master: 'TCNMAgency',
                PK: 'FTAgnCode'
            },
            Join: {
                Table: ['TCNMAgency_L'],
                On: ['TCNMAgency_L.FTAgnCode = TCNMAgency.FTAgnCode AND TCNMAgency_L.FNLngID = ' + nLangEdits]
            },
            GrideView: {
                ColumnPathLang: 'ticket/agency/agency',
                ColumnKeyLang: ['tAggCode', 'tAggName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMAgency.FTAgnCode', 'TCNMAgency_L.FTAgnName'],
                DataColumnsFormat: ['', ''],
                Perpage: 10,
                OrderBy: ['TCNMAgency.FDCreateOn DESC'],
            },
            CallBack: {
                ReturnType: 'S',
                Value: [tInputReturnCode, "TCNMAgency.FTAgnCode"],
                Text: [tInputReturnName, "TCNMAgency_L.FTAgnName"],
            },
            RouteAddNew: 'agency',
            BrowseLev: 1,
        }
        return oOptionReturn;
    }

    var tStaUsrLevel = '<?php echo $this->session->userdata("tSesUsrLevel"); ?>';
    if (tStaUsrLevel == 'BCH' || tStaUsrLevel == 'SHP') {
        $('#oimSrvPriBrowseAgn').attr("disabled", true);
    }

    // Create By : Napat(Jame) 26/09/2022
    $('#oliSrvPriInfo2').off('click').on('click', function(){
        if(!$(this).hasClass('disabled')){
            $('#odvBtnAddEdit .xWBtnTab1').hide();
            var tTitleName = '<?=language('product/settingprinter/settingprinter','tSPTBName')?> : ' + $('#oetSrvPriName').val();
            $('#olbSrvPriSpcName').text(tTitleName);
            FSxSrvPriSpcDataTable();
        }
    });

    $('#oliSrvPriInfo1').off('click').on('click', function(){
        $('#odvBtnAddEdit .xWBtnTab1').show();
    });

    // Create By : Napat(Jame) 28/09/2022
    function FSxSrvPriSpcDataTable(){
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "ServerPrinterSpcDataTable",
            data: { 
                ptAgnCode : $('#oetSrvPriAgnCode').val(),
                ptSrvCode : $('#ohdSrvPriCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $('#odvSrvPriSpcContent').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    // Create By : Napat(Jame) 26/09/2022
    $('#obtrSrvPriSpcAdd').off('click').on('click', function(e){
        e.preventDefault();
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            JSxCheckPinMenuClose();
            window.oBrowsePrnLabelOption = oBrowsePrnLabel({
                'tReturnInputCode': 'oetPrnLabelCode',
                'tReturnInputName': 'oetPrnLabelName',
                'tAgnCode': $('#oetSrvPriAgnCode').val(),
            });
            // JCNxBrowseData('oBrowsePrnLabelOption');
            JCNxBrowseMultiSelect('oBrowsePrnLabelOption');
        } else {
            JCNxShowMsgSessionExpired();
        }
    });

    // Create By : Napat(Jame) 26/09/2022
    var oBrowsePrnLabel = function(poReturnInput) {
        var tInputReturnCode = poReturnInput.tReturnInputCode;
        var tInputReturnName = poReturnInput.tReturnInputName;
        var tAgnCode = poReturnInput.tAgnCode;

        var oOptionReturn = {
            Title: ['product/settingprinter/settingprinter', 'tLPTitle'],
            Table: {
                Master: 'TCNMPrnLabel',
                PK: 'FTPlbCode'
            },
            Join: {
                Table: ['TCNMPrnLabel_L'],
                On: ['TCNMPrnLabel_L.FTAgnCode = TCNMPrnLabel.FTAgnCode AND TCNMPrnLabel_L.FTPlbCode = TCNMPrnLabel.FTPlbCode AND TCNMPrnLabel_L.FNLngID = ' + nLangEdits]
            },
            Where: {
                Condition: [" AND (TCNMPrnLabel.FTAgnCode = '"+tAgnCode+"' OR ISNULL(TCNMPrnLabel.FTAgnCode,'') = '') "],
            },
            GrideView: {
                ColumnPathLang: 'product/settingprinter/settingprinter',
                ColumnKeyLang: ['tLPTBCode', 'tLPTBName'],
                ColumnsSize: ['15%', '85%'],
                WidthModal: 50,
                DataColumns: ['TCNMPrnLabel.FTPlbCode', 'TCNMPrnLabel_L.FTPblName', 'TCNMPrnLabel.FTLblCode', 'TCNMPrnLabel.FTAgnCode'],
                DataColumnsFormat: ['', ''],
                DisabledColumns: [2,3],
                Perpage: 10,
                OrderBy: ['TCNMPrnLabel.FDCreateOn DESC'],
            },
            CallBack: {
                // ReturnType: 'M',
                Value: [tInputReturnCode, "TCNMPrnLabel.FTPlbCode"],
                Text: [tInputReturnName, "TCNMPrnLabel_L.FTPblName"],
            },
            NextFunc: {
                FuncName: 'FSxSrvPriSpcAddData',
                ArgReturn: ['FTPlbCode', 'FTLblCode', 'FTAgnCode']
            },
        }
        return oOptionReturn;
    }

    // Create By : Napat(Jame) 28/09/2022
    function FSxSrvPriSpcAddData(paData){
        if( paData[0] !== null ){

            var aPackData = [];
            for (let i = 0; i < paData.length; i++) {
                var aData = JSON.parse(paData[i]);
                var aInsData = {
                    FTAgnCode : aData[2].toString(),
                    FTSrvCode : $('#ohdSrvPriCode').val().toString(),
                    FTPlbCode : aData[0].toString(),
                    FTLblCode : aData[1].toString(),
                };
                aPackData.push(aInsData);
            }

            $.ajax({
                type: "POST",
                url: "ServerPrinterSpcAddData",
                data: {
                    paPackData : aPackData,
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = JSON.parse(oResult);
                    if( aResult['tCode'] == '1' ){
                        FSxSrvPriSpcDataTable();
                    }else{
                        FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }

    }
    
    // Create By : Napat(Jame) 28/09/2022
    function JSxSrvPriSpcDelete(pnKey){
        var tPlbCode = $('#otrSrvPriSpc'+pnKey).attr('data-plbcode');
        var tPlbName = $('#otrSrvPriSpc'+pnKey).attr('data-plbname');

        $('#odvSrvPriSpcModalDel .modal-body').html('<?=language('common/main/main', 'tModalConfirmDeleteItems')?>'+' '+tPlbCode+' ('+tPlbName+') '+'<?=language('common/main/main', 'tModalConfirmDeleteItemsYN')?>');
        $('#odvSrvPriSpcModalDel').modal('show');

        $('#obtSrvPriSpcConfirm').off('click').on('click', function(){
            $('#odvSrvPriSpcModalDel').modal('hide');
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "ServerPrinterSpcDelData",
                data: {
                    ptAgnCode : $('#otrSrvPriSpc'+pnKey).attr('data-agncode'),
                    ptSrvCode : $('#otrSrvPriSpc'+pnKey).attr('data-srvcode'),
                    ptPlbCode : tPlbCode,
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    var aResult = JSON.parse(oResult);
                    if( aResult['tCode'] == '1' ){
                        FSxSrvPriSpcDataTable();
                    }else{
                        FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    }

    // Create By : Napat(Jame) 28/09/2022
    $('.xWExportPrintLabelInSrv').off('click').on('click', function(e){
        var nCountSpc = parseInt($('#ohdSrvPriCountSpc').val());
        if( nCountSpc > 0 ){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "ServerPrinterSpcExportJson",
                data: {
                    ptAgnCode   : $("#oetSrvPriAgnCode").val(),
                    ptSrvCode   : $("#ohdSrvPriCode").val(),
                },
                success: function(tResult) {
                    
                    var oBlob = new Blob([tResult]);
                    var oLink = document.createElement('a');
                
                    oLink.href = window.URL.createObjectURL(oBlob);
                    oLink.download = "Setup_Printer.json";
                    oLink.click();
                    
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            FSvCMNSetMsgWarningDialog('กรุณากำหนดรูปแบบการพิมพ์');
        }
    });

</script>