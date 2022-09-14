<script>
    var oPromotionImportCGDatatable = null;
    var oPromotionImportCGDataSource = null;

    JSxPromotionImportCGRenderDataTable();

    $("#obtIMPConfirm").unbind().bind("click", function(){
        JSxPromotionImportCGTmpToMaster();
    });

    $("#otbPromotionImportExcelCGTable tbody").on("click", ".ocbListItem", function(){
        var nCheckedItem = $("#otbPromotionImportExcelCGTable tbody .ocbListItem:checked").length;
        
        if(nCheckedItem >= 1){
            $("li#oliBtnDeleteAll").removeClass("disabled");
        }else{
            $("li#oliBtnDeleteAll").addClass("disabled");
        }

        var tSeqNo = $(this).parents('.xCNPromotionImportCGItem').data('seq');
        var tPmdGrpName = $(this).parents('.xCNPromotionImportCGItem').data('pmd-grp-name');
        var tPgtStaGetType = $(this).parents('.xCNPromotionImportCGItem').data('pgt-sta-get-type');
        var tPgtGetvalue = $(this).parents('.xCNPromotionImportCGItem').data('pgt-get-value');
        var tPgtGetQty = $(this).parents('.xCNPromotionImportCGItem').data('pgt-get-qty');
        var tStatus = $(this).parents('.xCNPromotionImportCGItem').data('sta');

        $(this).prop('checked', true);
        var PromotionCGLocalItemData = localStorage.getItem("PromotionCGLocalItemData");
        var obj = [];
        if(PromotionCGLocalItemData){
            obj = JSON.parse(PromotionCGLocalItemData);
        }
        var aArrayConvert = [JSON.parse(localStorage.getItem("PromotionCGLocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"tSeqNo":tSeqNo, "tPmdGrpName":tPmdGrpName, "tPgtStaGetType":tPgtStaGetType, "tPgtGetvalue":tPgtGetvalue, "tPgtGetQty":tPgtGetQty, "tStatus": tStatus});
            localStorage.setItem("PromotionCGLocalItemData",JSON.stringify(obj));
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeqNo',tSeqNo);
            if(aReturnRepeat == 'None' ){ // ยังไม่ถูกเลือก
                obj.push({"tSeqNo":tSeqNo, "tPmdGrpName":tPmdGrpName, "tPgtStaGetType":tPgtStaGetType, "tPgtGetvalue":tPgtGetvalue, "tPgtGetQty":tPgtGetQty, "tStatus": tStatus});
                localStorage.setItem("PromotionCGLocalItemData",JSON.stringify(obj));
            }else if(aReturnRepeat == 'Dupilcate'){	// เคยเลือกไว้แล้ว
                localStorage.removeItem("PromotionCGLocalItemData");
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
                localStorage.setItem("PromotionCGLocalItemData",JSON.stringify(aNewarraydata));
            }
        }
    });

    /**
     * Functionality : Get Import Data in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportCGRenderDataTable(){
        console.log("Render Start");
        oPromotionImportCGDatatable = $oNewJqueryVersion('#otbPromotionImportExcelCGTable').DataTable({
            serverSide: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            bInfo: false,
            ajax: function(data, callback, settings) {
                if(oPromotionImportCGDataSource == null){
                    $.ajax({
                        type: "POST",
                        url: "promotionGetImportExcelCGDataJsonInTmp",
                        async: false,
                        data: {
                            'nPageNumber': data.draw - 1,
                            'tSearch': $('#oetPromotionImpCGSearchAll').val()
                        },
                    }).success(function(response) {
                        localStorage.removeItem("PromotionCGLocalItemData");
                        oPromotionImportCGDataSource = response;
                        var oDataSet = JSxPromotionImportCGSetDataSourceTable(oPromotionImportCGDataSource, data);

                        FSxPromotionImportCGGetStaInTemp();

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
                    var oDataSet = JSxPromotionImportCGSetDataSourceTable(oPromotionImportCGDataSource, data);
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
            scrollY: '35vh',
            scrollCollapse: false,
            scroller: {
                loadingIndicator: true
            },
            createdRow: function(row, data, dataIndex) {
                $(row).attr('data-seq', data[0].tSeqNo);
                $(row).attr('data-pmd-grp-name', data[2].tPmdGrpName);
                $(row).attr('data-pgt-sta-get-type', data[3].tPgtStaGetType);
                $(row).attr('data-pgt-get-value', data[4].tPgtGetvalue);
                $(row).attr('data-pgt-get-qty', data[5].tPgtGetQty);
                $(row).attr('data-sta', data[0].tStatus);
                $(row).attr('data-remark', data[0].tRemark);
                $(row).addClass('xCNPromotionImportCGItem');
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
                        var oCheckedItems = JSON.parse(localStorage.getItem("PromotionCGLocalItemData"));
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
                { // FTPmdGrpName
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPmdGrpName

                        if(['3','4','7'].includes(tStatus)){
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
                { // FTPgtStaGetType
                    className: "text-center",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPgtStaGetType

                        if(['3','4','7'].includes(tStatus)){
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
                { // FCPgtGetvalue
                    className: "text-right",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = parseFloat(data.tPgtGetvalue).toFixed(nOptDecimalShow);

                        if(['3','4','7'].includes(tStatus)){
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
                { // FCPgtGetQty
                    className: "text-right",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = parseFloat(data.tPgtGetQty).toFixed(nOptDecimalShow);

                        if(['3','4','7'].includes(tStatus)){
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
                { // Remark
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        if(tStatus != 1){
                            var tStyleList = "color:red !important; font-weight:bold;"; 
                        }else{
                            var tStyleList = '';
                        }
                        
                        var tRemark = data.tRemark;

                        if(['3','4','7'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            tRemark = aRemark[1];
                        }

                        return '<label style="'+tStyleList+'">'+tRemark+'<label>';
                    }
                },
                { // Delete Action
                    className: "text-center",
                    render: function(data, type, row){
                        return '<img class="xCNIconTable xCNIconDel" onClick="JSxPromotionImportCGConfirmDeleteInTempBySeqInTemp(this, \'S\')" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>">';
                    }
                }
            ]
        });
        $('.dataTables_scrollBody').css('min-height','300px');
    }

    /**
     * Functionality : Set Data Source for Data Table
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function JSxPromotionImportCGSetDataSourceTable(poPromotionImportCGDataSource, poData) {
        var _oPromotionImportCGDataSource = poPromotionImportCGDataSource;
        var _oDataSet = null;
        var _oRender = [];  
        var _draw = 1;
        var _recordsTotal = 0;
        var _recordsFiltered = 0; 

        console.log("Res: ", _oPromotionImportCGDataSource);
        console.log("data: ", poData);
        console.log("data.length: ", poData.length);
        console.log("data.start: ", poData.start);

        var nLength = _oPromotionImportCGDataSource.data.aResult.length;
        var nBreakPoint = 300;
        console.log("nLength Before: ", nLength);
        if(poData.start+nBreakPoint > nLength){
            nLength = nLength;
        }else{
            nLength = poData.start+nBreakPoint;
        }
        console.log("nLength After: ", nLength);

        for (var i=poData.start, ien=nLength; i<ien; i++ ) {
            var FNTmpSeq = _oPromotionImportCGDataSource.data.aResult[i].FNTmpSeq;
            var FTPmdGrpName = _oPromotionImportCGDataSource.data.aResult[i].FTPmdGrpName;
            var FTPgtStaGetType = _oPromotionImportCGDataSource.data.aResult[i].FTPgtStaGetType;
            var FCPgtGetvalue = _oPromotionImportCGDataSource.data.aResult[i].FCPgtGetvalue;
            var FCPgtGetQty = _oPromotionImportCGDataSource.data.aResult[i].FCPgtGetQty;
            var FTTmpRemark = _oPromotionImportCGDataSource.data.aResult[i].FTTmpRemark;
            var FTTmpStatus = _oPromotionImportCGDataSource.data.aResult[i].FTTmpStatus;

            _oRender.push([ 
                // Check Box
                {tSeqNo: FNTmpSeq, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // SeqNo
                {nTmpSeqNo: FNTmpSeq},
                // FTPmdGrpName
                {tPmdGrpName: FTPmdGrpName, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPgtStaGetType
                {tPgtStaGetType: FTPgtStaGetType, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FCPgtGetvalue
                {tPgtGetvalue: FCPgtGetvalue, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FCPgtGetQty
                {tPgtGetQty: FCPgtGetQty, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FTTmpRemark
                {tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // Delete Action
                '' 
            ]);
        }

        var _draw = poData.draw;
        var _recordsTotal = _oPromotionImportCGDataSource.recordsTotal;
        var _recordsFiltered = _oPromotionImportCGDataSource.recordsFiltered;

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
    function JSxPromotionImportCGSearchDataInTable() {
        JSxPromotionImportGetCGTable();
    }

    /**
     * Functionality : Confirm Delete by SeqNo in Temp
     * Parameters : poElm, ptDeleteType: M=Multiple, S=Single
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -s
     * Return Type : -
     */
    function JSxPromotionImportCGConfirmDeleteInTempBySeqInTemp(poElm, ptDeleteType){
        var aImportData = [];
        var aImportSeqNo = [];
        var aImportPackData;

        if(ptDeleteType == 'M'){ // Delete Multi
            if($(poElm).hasClass('disabled')){return;}

            var tConfirm = '<?php echo language('document/promotion/promotion','tWarMsg1'); ?>';
            console.log("tConfirm: ", tConfirm);
            $('#odvModalImportPromotionCGDelete .xCNPromotionCGConfirmDeltelLabel').html(tConfirm);

            var oImportDataSelect = JSON.parse(localStorage.getItem("PromotionCGLocalItemData"));
            $.each(oImportDataSelect, function(index, item){
                var tSeq = item.tSeqNo;
                var tPmdGrpName = item.tPmdGrpName;
                var tPgtStaGetType = item.tPgtStaGetType;
                var tPgtGetvalue = item.tPgtGetvalue;
                var tPgtGetQty = item.tPgtGetQty;
                var tSta = item.tStatus
                aImportData.push({
                    tSeq: tSeq,
                    tPgtStaGetType: tPgtStaGetType,
                    tPmdGrpName: tPmdGrpName,
                    tPgtGetvalue: tPgtGetvalue,
                    tPgtGetQty: tPgtGetQty,
                    tSta: tSta
                });
                aImportSeqNo.push(tSeq);
            });
        }

        if(ptDeleteType == 'S'){ // Delete Single
            var tSeq = $(poElm).parents('.xCNPromotionImportCGItem').data('seq');
            var tPmdGrpName = $(poElm).parents('.xCNPromotionImportCGItem').data('pmd-grp-name');
            var tPgtStaGetType = $(poElm).parents('.xCNPromotionImportCGItem').data('pgt-sta-get-type');
            var tPgtGetvalue = $(poElm).parents('.xCNPromotionImportCGItem').data('pgt-get-value');
            var tPgtGetQty = $(poElm).parents('.xCNPromotionImportCGItem').data('pgt-get-qty');
            var tSta = $(poElm).parents('.xCNPromotionImportCGItem').data('sta');
            var tConfirm = $('#oetTextComfirmDeleteSingle').val() +'('+ tPmdGrpName +','+ tPgtStaGetType +','+ tPgtGetvalue +','+ tPgtGetQty +')'+ '<?php echo language('common/main/main', 'tBCHYesOnNo')?>';
            $('#odvModalImportPromotionCGDelete .xCNPromotionCGConfirmDeltelLabel').html(tConfirm);

            aImportData.push({
                tSeq: tSeq,
                tPmdGrpName: tPmdGrpName,
                tPgtStaGetType: tPgtStaGetType,
                tPgtGetvalue: tPgtGetvalue,
                tPgtGetQty: tPgtGetQty,
                tSta: tSta
            });
            aImportSeqNo.push(tSeq);
        }

        aImportPackData = {
            aItems: aImportData,
            aSeqNo: aImportSeqNo
        };

        $('#odvModalImportPromotionCGDelete').modal({show: true, backdrop: false});

        $('#odvModalImportPromotionCGDelete .xCNPromotionCGImpConfirm').unbind().bind('click', function() {
            JSxPromotionImportCGDeleteInTempBySeq(poElm, aImportPackData);
        });

        $('#odvModalImportPromotionCGDelete .xCNPromotionCGImpCancel').on("click", function(){
            $('#odvModalImportPromotionCGDelete').modal('hide');
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
    function JSxPromotionImportCGDeleteInTempBySeq(poElm, poData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "promotionDeleteImportExcelCGInTempBySeq",
                data: {
                    tDataItem: JSON.stringify(poData)
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if(oResult.tCode = "1"){
                        localStorage.removeItem("PromotionCGLocalItemData");
                        $('#odvModalImportPromotionCGDelete').modal('hide');
                        oPromotionImportCGDataSource = null;
                        oPromotionImportCGDatatable.ajax.reload(null, false);
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
     * Functionality : Get Status in Temp
     * Parameters : -
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -
     * Return Type : -
     */
    function FSxPromotionImportCGGetStaInTemp(){
        $.ajax({
            type    : "POST",
            url     : "promotionGetImportExcelCGStaInTmp",
            cache   : false,
            timeout : 0,
            success : function(oResult){
                var nStaNewOrUpdate = oResult.nStaNewOrUpdate;
                var nStaSuccess = oResult.nStaSuccess;
                var nRecordTotal = oResult.nRecordTotal;

                var tTextShow = "<?php echo language('document/promotion/promotion', 'tLabel1'); ?> " + nStaSuccess + ' / ' + nRecordTotal + ' <?php echo language('document/promotion/promotion', 'tLabel2'); ?>';
                $('#odvOption1 .xCNPromotionCGSummaryImportText').text(tTextShow);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>