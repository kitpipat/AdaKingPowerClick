<script>
    var oDatatable = null;
    var oDataSource = null;

    $(document).ready(function(){
        JSxPosImportRenderDataTable();

        $("#obtIMPConfirm").unbind().bind("click", function(){
            JSxPosImportTmpToMaster();
        });

        $("#otbPosImportTable tbody").on("click", ".ocbListItem", function(){
            var nCheckedItem = $("#otbPosImportTable tbody .ocbListItem:checked").length;
            
            if(nCheckedItem >= 1){
                $("li#oliBtnDeleteAll").removeClass("disabled");
            }else{
                $("li#oliBtnDeleteAll").addClass("disabled");
            }

            var tSeqNo = $(this).parents('.xCNPosImportItem').data('seq');
            var tBchCode = $(this).parents('.xCNPosImportItem').data('bch-code');
            var tPosCode = $(this).parents('.xCNPosImportItem').data('pos-code');
            var tStatus = $(this).parents('.xCNPosImportItem').data('sta');

            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"tSeqNo":tSeqNo, "tBchCode":tBchCode, "tPosCode":tPosCode, "tStatus": tStatus});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeqNo',tSeqNo);
                if(aReturnRepeat == 'None' ){           // ยังไม่ถูกเลือก
                    obj.push({"tSeqNo":tSeqNo, "tBchCode": tBchCode, "tPosCode": tPosCode, "tStatus": tStatus});
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                }else if(aReturnRepeat == 'Dupilcate'){	// เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].tSeqNo == tSeqNo){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                }
            }
        });

        $("#obtIMPCancel").on("click", function(){
            JSxPosImportClearInTemp();
        });
    });

    /**
     * Functionality : Get Import Data in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPosImportRenderDataTable(){
        console.log("Render Start");
        oDatatable = $oNewJqueryVersion('#otbPosImportTable').DataTable({
            serverSide: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            bInfo: false,
            ajax: function(data, callback, settings) {
                if(oDataSource == null){
                    $.ajax({
                        type: "POST",
                        url: "salemachineImportGetDataJsonInTemp",
                        async: false,
                        data: {
                            'nPageNumber': data.draw - 1,
                            'tSearch': $('#oetPOSImpSearchAll').val()
                        },
                    }).success(function(response) {
                        localStorage.removeItem("LocalItemData");
                        oDataSource = response;
                        var oDataSet = JSxPosImportSetDataSourceTable(oDataSource, data);

                        FSxMSALGetStaInTemp();

                        setTimeout( function () {
                            callback({
                                draw : data.draw,
                                data : oDataSet.oRender,
                                recordsTotal: oDataSet.recordsTotal,
                                recordsFiltered: oDataSet.recordsFiltered
                            });
                        }, 50);

                        JCNxCloseLoading();
                    }).fail(function(err){
                        JCNxCloseLoading();
                        console.error('error...', err)
                    })
                }else{
                    var oDataSet = JSxPosImportSetDataSourceTable(oDataSource, data);
                    setTimeout( function () {
                        callback({
                            draw : data.draw,
                            data : oDataSet.oRender,
                            recordsTotal: oDataSet.recordsTotal,
                            recordsFiltered: oDataSet.recordsFiltered
                        });
                    }, 50);
                }
            },
            scrollY: '50vh',
            scrollCollapse: false,
            scroller: {
                loadingIndicator: true
            },
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-seq', data[0].tSeqNo);
                $(row).attr('data-bch-code', data[2].tBchCode);
                $(row).attr('data-pos-code', data[3].tPosCode);
                $(row).attr('data-pos-name', data[4].tPosName);
                $(row).attr('data-sta', data[0].tStatus);
                $(row).attr('data-remark', data[0].tRemark);
                $(row).addClass('xCNPosImportItem');
            },
            /* columnDefs: [
                {
                    'targets': 0,
                    'className': "text-center",
                    'createdCell':  function (td, cellData, rowData, row, col) {
                        // $(td).attr('id', 'otherID'); 
                    }
                }
            ], */
            columns:[
                { // Check Box
                    className: "text-center",
                    render: function(data, type, row){
                        var tChecked = "";
                        var oCheckedItems = JSON.parse(localStorage.getItem("LocalItemData"));
                        $.each(oCheckedItems, function(index, item){
                            if(data.tSeqNo == item.tSeqNo){
                                tChecked = "checked";
                            }
                        });
                            
                            
                        var tCheckBoxDelete = "<label class='fancy-checkbox' style='text-align: center;'>";
                            tCheckBoxDelete += "<input type='checkbox' class='ocbListItem' " +tChecked+ " name='ocbListItem[]'>";
                            tCheckBoxDelete += "<span>&nbsp;</span>";
                            tCheckBoxDelete += "</label>";
                        return tCheckBoxDelete;
                    }
                },
                { // SeqNo
                    className: "text-center",
                    render: function(data, type, row){
                        return data.nTmpSeqNo;
                    }
                },
                { // FTBchCode
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tBchCode

                        if(['3','4'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[0]': {
                                    tRemark = aRemark[2];
                                    break;
                                }
                                defult : {}
                            }
                        }
                        return tRemark;
                    }
                },
                /* { // FTBchName
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tBchName
                        return tRemark;
                    }
                }, */
                { // FTPosCode
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPosCode

                        if(['3','4'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[1]': {
                                    tRemark = aRemark[2];
                                    break;
                                }
                                defult : {}
                            }
                        }
                        return tRemark;
                    }
                },
                { // FTPosName
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPosName

                        if(['3','4'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[2]': {
                                    tRemark = aRemark[2];
                                    break;
                                }
                                defult : {}
                            }
                        }
                        return tRemark;
                    }
                },
                { // FTPosType
                    className: "text-center",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPosType

                        if(['3','4'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[3]': {
                                    tRemark = aRemark[2];
                                    break;
                                }
                            }
                        }
                        return tRemark;
                    }
                },
                { // FTPosRegNo
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPosRegNo

                        if(['3','4'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[4]': {
                                    tRemark = aRemark[2];
                                    break;
                                }
                                defult : {}
                            }
                        }
                        return tRemark;
                    }
                },
                { // Remark
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        if(tStatus != 1){
                            var tStyleList = "color:red !important; font-weight:bold;"; 
                        }else{
                            var tStyleList = '';
                        }
                        
                        var tRemark = data.tRemark;

                        if(['3','4'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            tRemark = aRemark[1];
                        }

                        return '<label style="'+tStyleList+'">'+tRemark+'<label>';
                    }
                },
                { // Delete Action
                    className: "text-center",
                    render: function(data, type, row){
                        return '<img class="xCNIconTable xCNIconDel" onClick="JSxPosImportConfirmDeleteInTempBySeqInTemp(this, \'S\')" src="<?php echo base_url('/application/modules/common/assets/images/icons/delete.png'); ?>">';
                    }
                }
            ]
        });
        $('.dataTables_scrollBody').css('min-height','400px');
    }

    /**
     * Functionality : Set Data Source for Data Table
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPosImportSetDataSourceTable(poDataSource, poData) {
        var _oDataSource = poDataSource;
        var _oDataSet = null;
        var _oRender = [];  
        var _draw = 1;
        var _recordsTotal = 0;
        var _recordsFiltered = 0; 

        console.log("Res: ", _oDataSource);
        console.log("data: ", poData);
        console.log("data.length: ", poData.length);
        console.log("data.start: ", poData.start);

        var nLength = _oDataSource.data.aResult.length;
        var nBreakPoint = 300;
        console.log("nLength Before: ", nLength);
        if(poData.start+nBreakPoint > nLength){
            nLength = nLength;
        }else{
            nLength = poData.start+nBreakPoint;
        }
        console.log("nLength After: ", nLength);

        for (var i=poData.start, ien=nLength; i<ien; i++ ) {
            var FNTmpSeq = _oDataSource.data.aResult[i].FNTmpSeq;
            var FTBchCode = _oDataSource.data.aResult[i].FTBchCode;
            // var FTBchName = _oDataSource.data.aResult[i].FTBchName;
            var FTPosCode = _oDataSource.data.aResult[i].FTPosCode;
            var FTPosName = (_oDataSource.data.aResult[i].FTPosName == '' || _oDataSource.data.aResult[i].FTPosName == null) ? 'N/A' : _oDataSource.data.aResult[i].FTPosName;
            var FTPosType = (_oDataSource.data.aResult[i].FTPosType == '' || null) ? 'N/A' : _oDataSource.data.aResult[i].FTPosType;
            var FTPosRegNo = (_oDataSource.data.aResult[i].FTPosRegNo == '' || _oDataSource.data.aResult[i].FTPosRegNo == null) ? 'N/A' : _oDataSource.data.aResult[i].FTPosRegNo;
            var FTTmpRemark = _oDataSource.data.aResult[i].FTTmpRemark;
            var FTTmpStatus = _oDataSource.data.aResult[i].FTTmpStatus;

            _oRender.push([ 
                // Check Box
                {tSeqNo: FNTmpSeq, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // SeqNo
                {nTmpSeqNo: FNTmpSeq},
                // FTBchCode
                {tBchCode: FTBchCode, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTBchName
                // {tBchName: FTBchName, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPosCode
                {tPosCode: FTPosCode, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPosName
                {tPosName: FTPosName, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPosType
                {tPosType: FTPosType, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPosRegNo
                {tPosRegNo: FTPosRegNo, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FTTmpRemark
                {tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // Delete Action
                '' 
            ]);
        }

        var _draw = poData.draw;
        var _recordsTotal = _oDataSource.recordsTotal;
        var _recordsFiltered = _oDataSource.recordsFiltered;

        _oDataSet = {
            oRender: _oRender,
            recordsTotal: _recordsTotal,
            recordsFiltered: _recordsFiltered
        }
        
        return _oDataSet;
    }

    /**
     * Functionality : Search Data Temp in Html
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPosImportSearchDataInTable() {
        JSxPOSImportDataTable();
    }

    /**
     * Functionality : ย้ายข้อมูล Tmp ลง Master
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPosImportTmpToMaster() {
        var tTypeCaseDuplicate = $("input[name='orbPOSCaseInsAgain']:checked").val();
        $.ajax({
            type: "POST",
            url: "salemachineImportTempToMaster",
            data: {
                'tTypeCaseDuplicate': tTypeCaseDuplicate
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                console.log('oResult: ', oResult);
                if(oResult.tCode == "1"){
                    $('#odvModalImportFile').modal('hide');
                    JSvCallPageSaleMachineList();
                }else{
                    var tWarningMessage = oResult.tDesc;
                    FSvCMNSetMsgWarningDialog(tWarningMessage, '', '', false);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Confirm Delete by SeqNo in Temp
     * Parameters : poElm, ptDeleteType: M=Multiple, S=Single
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -s
     * Return Type : -
     */
    function JSxPosImportConfirmDeleteInTempBySeqInTemp(poElm, ptDeleteType){
        var aImportData = [];
        var aImportSeqNo = [];
        var aImportPackData;

        if(ptDeleteType == 'M'){ // Delete Multi
            if($(poElm).hasClass('disabled')){return;}

            var tConfirm = $('#ohdDeleteChooseconfirm').val();
            $('#odvModalDeleteImportPos #ospConfirmDelete').html(tConfirm);

            var oImportDataSelect = JSON.parse(localStorage.getItem("LocalItemData"));
            $.each(oImportDataSelect, function(index, item){
                var tSeq = item.tSeqNo;
                var tBchCode = item.tBchCode;
                var tPosCode = item.tPosCode;
                var tSta = item.tStatus
                aImportData.push({
                    tSeq: tSeq,
                    tBchCode: tBchCode,
                    tPosCode: tPosCode,
                    tSta: tSta
                });
                aImportSeqNo.push(tSeq);
            });
        }

        if(ptDeleteType == 'S'){ // Delete Single
            var tSeq = $(poElm).parents('.xCNPosImportItem').data('seq');
            var tBchCode = $(poElm).parents('.xCNPosImportItem').data('bch-code');
            var tPosCode = $(poElm).parents('.xCNPosImportItem').data('pos-code');
            var tPosName = $(poElm).parents('.xCNPosImportItem').data('pos-name');
            var tSta = $(poElm).parents('.xCNPosImportItem').data('sta');
            var tConfirm = $('#oetTextComfirmDeleteSingle').val() + tPosCode + ' (' + tPosName + ')' + '<?php echo language('common/main/main', 'tBCHYesOnNo')?>';
            $('#odvModalDeleteImportPos #ospConfirmDelete').html(tConfirm);

            aImportData.push({
                tSeq: tSeq,
                tBchCode: tBchCode,
                tPosCode: tPosCode,
                tSta: tSta
            });
            aImportSeqNo.push(tSeq);
        }

        aImportPackData = {
            aItems: aImportData,
            aSeqNo: aImportSeqNo
        };

        $('#odvModalDeleteImportPos').modal({show: true, backdrop: false});

        $('#obtPOSImpConfirm').unbind().bind('click', function() {
            JSxPosImportDeleteInTempBySeq(poElm, aImportPackData);
        });

        $('#obtPOSImpCancel').on("click", function(){
            $('#odvModalDeleteImportPos').modal('hide');
        });
        
    }

    /**
     * Functionality : Delete by SeqNo in Temp
     * Parameters : poData = {
     * aItems: [{tSeq: '', tBchCode: '', tPosCode: '', tSta: ''}, ...]
     * aSeqNo: ['seq1', 'seq2', ...]
     * }
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPosImportDeleteInTempBySeq(poElm, poData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "salemachineImportDeleteInTempBySeq",
                data: {
                    tPdtDataItem: JSON.stringify(poData)
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if(oResult.tCode = "1"){
                        localStorage.removeItem("LocalItemData");
                        $('#odvModalDeleteImportPos').modal('hide');
                        oDataSource = null;
                        oDatatable.ajax.reload(null, false);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }    
    }

    /**
     * Functionality : Get Import Data in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPOSImportDataTable() {
        var tPOSImpSearchAll = $('#oetPOSImpSearchAll').val();
        $.ajax({
            type: "POST",
            url: "salemachineImportGetDataInTemp",
            data: {
                'tPOSImpSearchAll': tPOSImpSearchAll,
                'tSearch': $('#oetPOSImpSearchAll').val()
            },
            cache: false,
            Timeout: 0,
            success: function(tResult) {
                localStorage.removeItem("LocalItemData");
                $('#odvContentRenderHTMLImport').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                localStorage.removeItem("LocalItemData");
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Clear Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPosImportClearInTemp() {
        $.ajax({
            type: "POST",
            url: "salemachineImportClearInTemp",
            data: {},
            cache: false,
            timeout: 0,
            success: function(oResult) {
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Get Status in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function FSxMSALGetStaInTemp(){
        $.ajax({
            type    : "POST",
            url     : "salemachineImportGetStaInTemp",
            cache   : false,
            timeout : 0,
            success : function(oResult){
                var nStaNewOrUpdate = oResult.nStaNewOrUpdate;
                var nStaSuccess = oResult.nStaSuccess;
                var nRecordTotal = oResult.nRecordTotal;

                var tTextShow = "รอการนำเข้า " + nStaSuccess + ' / ' + nRecordTotal + ' รายการ - อัพเดทข้อมูล ' + nStaNewOrUpdate + ' / ' + nRecordTotal + ' รายการ';
                $('#ospTextSummaryImport').text(tTextShow);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>