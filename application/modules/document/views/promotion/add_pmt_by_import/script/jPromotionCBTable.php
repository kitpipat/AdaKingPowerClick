<script>
    var oPromotionImportCBDatatable = null;
    var oPromotionImportCBDataSource = null;

    JSxPromotionImportCBRenderDataTable();

    $("#obtIMPConfirm").unbind().bind("click", function(){
        JSxPromotionImportCBTmpToMaster();
    });

    $("#otbPromotionImportExcelCBTable tbody").on("click", ".ocbListItem", function(){
        var nCheckedItem = $("#otbPromotionImportExcelCBTable tbody .ocbListItem:checked").length;
        
        if(nCheckedItem >= 1){
            $("li#oliBtnDeleteAll").removeClass("disabled");
        }else{
            $("li#oliBtnDeleteAll").addClass("disabled");
        }

        var tSeqNo = $(this).parents('.xCNPromotionImportCBItem').data('seq');
        var tPmdGrpName = $(this).parents('.xCNPromotionImportCBItem').data('pmd-grp-name');
        var tPbyStaBuyCond = $(this).parents('.xCNPromotionImportCBItem').data('pby-sta-buy-cond');
        var tPbyMinValue = $(this).parents('.xCNPromotionImportCBItem').data('pby-min-value');
        var tPbyMaxValue = $(this).parents('.xCNPromotionImportCBItem').data('pby-max-value');
        var tMinSetPri = $(this).parents('.xCNPromotionImportCBItem').data('pby-min-set-pri');
        var tStatus = $(this).parents('.xCNPromotionImportCBItem').data('sta');

        $(this).prop('checked', true);
        var PromotionCBLocalItemData = localStorage.getItem("PromotionCBLocalItemData");
        var obj = [];
        if(PromotionCBLocalItemData){
            obj = JSON.parse(PromotionCBLocalItemData);
        }
        var aArrayConvert = [JSON.parse(localStorage.getItem("PromotionCBLocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"tSeqNo":tSeqNo, "tPmdGrpName":tPmdGrpName, "tPbyStaBuyCond":tPbyStaBuyCond, "tPbyMinValue":tPbyMinValue, "tPbyMaxValue":tPbyMaxValue, "tMinSetPri":tMinSetPri, "tStatus": tStatus});
            localStorage.setItem("PromotionCBLocalItemData",JSON.stringify(obj));
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeqNo',tSeqNo);
            if(aReturnRepeat == 'None' ){ // ยังไม่ถูกเลือก
                obj.push({"tSeqNo":tSeqNo, "tPmdGrpName":tPmdGrpName, "tPbyStaBuyCond":tPbyStaBuyCond, "tPbyMinValue":tPbyMinValue, "tPbyMaxValue":tPbyMaxValue, "tMinSetPri":tMinSetPri, "tStatus": tStatus});
                localStorage.setItem("PromotionCBLocalItemData",JSON.stringify(obj));
            }else if(aReturnRepeat == 'Dupilcate'){	// เคยเลือกไว้แล้ว
                localStorage.removeItem("PromotionCBLocalItemData");
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
                localStorage.setItem("PromotionCBLocalItemData",JSON.stringify(aNewarraydata));
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
    function JSxPromotionImportCBRenderDataTable(){
        console.log("Render Start");
        oPromotionImportCBDatatable = $oNewJqueryVersion('#otbPromotionImportExcelCBTable').DataTable({
            serverSide: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            bInfo: false,
            ajax: function(data, callback, settings) {
                if(oPromotionImportCBDataSource == null){
                    $.ajax({
                        type: "POST",
                        url: "promotionGetImportExcelCBDataJsonInTmp",
                        async: false,
                        data: {
                            'nPageNumber': data.draw - 1,
                            'tSearch': $('#oetPromotionImpCBSearchAll').val()
                        },
                    }).success(function(response) {
                        localStorage.removeItem("PromotionCBLocalItemData");
                        oPromotionImportCBDataSource = response;
                        var oDataSet = JSxPromotionImportCBSetDataSourceTable(oPromotionImportCBDataSource, data);

                        FSxPromotionImportCBGetStaInTemp();

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
                    var oDataSet = JSxPromotionImportCBSetDataSourceTable(oPromotionImportCBDataSource, data);
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
                $(row).attr('data-pby-sta-buy-cond', data[3].tPbyStaBuyCond);
                $(row).attr('data-pby-min-value', data[4].tPbyMinValue);
                $(row).attr('data-pby-max-value', data[5].tPbyMaxValue);
                $(row).attr('data-pby-min-set-pri', data[6].tPbyMinSetPri);
                $(row).attr('data-sta', data[0].tStatus);
                $(row).attr('data-remark', data[0].tRemark);
                $(row).addClass('xCNPromotionImportCBItem');
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
                        var oCheckedItems = JSON.parse(localStorage.getItem("PromotionCBLocalItemData"));
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
                { // FTPbyStaBuyCond
                    className: "text-center",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPbyStaBuyCond

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
                { // FCPbyMinValue
                    className: "text-right",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = parseFloat(data.tPbyMinValue).toFixed(nOptDecimalShow);

                        if(['3','4','7'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[2]': {
                                    tRemark = aRemark[2];
                                    break;
                                }
                            }
                        }
                        return tRemark;
                    }
                },
                { // FCPbyMaxValue
                    className: "text-right",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = parseFloat(data.tPbyMaxValue).toFixed(nOptDecimalShow);

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
                { // FCPbyMinSetPri
                    className: "text-right",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = parseFloat(data.tPbyMinSetPri).toFixed(nOptDecimalShow);

                        if(['3','4','7'].includes(tStatus)){
                            var aRemark = data.tRemark.split("$&");
                            switch(aRemark[0]){
                                case '[4]': {
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
                        return '<img class="xCNIconTable xCNIconDel" onClick="JSxPromotionImportCBConfirmDeleteInTempBySeqInTemp(this, \'S\')" src="<?php echo base_url('/application/modules/common/assets/images/icons/delete.png'); ?>">';
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
    function JSxPromotionImportCBSetDataSourceTable(poPromotionImportCBDataSource, poData) {
        var _oPromotionImportCBDataSource = poPromotionImportCBDataSource;
        var _oDataSet = null;
        var _oRender = [];  
        var _draw = 1;
        var _recordsTotal = 0;
        var _recordsFiltered = 0; 

        console.log("Res: ", _oPromotionImportCBDataSource);
        console.log("data: ", poData);
        console.log("data.length: ", poData.length);
        console.log("data.start: ", poData.start);

        var nLength = _oPromotionImportCBDataSource.data.aResult.length;
        var nBreakPoint = 300;
        console.log("nLength Before: ", nLength);
        if(poData.start+nBreakPoint > nLength){
            nLength = nLength;
        }else{
            nLength = poData.start+nBreakPoint;
        }
        console.log("nLength After: ", nLength);

        for (var i=poData.start, ien=nLength; i<ien; i++ ) {
            var FNTmpSeq = _oPromotionImportCBDataSource.data.aResult[i].FNTmpSeq;
            var FTPmdGrpName = _oPromotionImportCBDataSource.data.aResult[i].FTPmdGrpName;
            var FTPbyStaBuyCond = _oPromotionImportCBDataSource.data.aResult[i].FTPbyStaBuyCond;
            var FCPbyMinValue = _oPromotionImportCBDataSource.data.aResult[i].FCPbyMinValue;
            var FCPbyMaxValue = _oPromotionImportCBDataSource.data.aResult[i].FCPbyMaxValue;
            var FCPbyMinSetPri = _oPromotionImportCBDataSource.data.aResult[i].FCPbyMinSetPri;
            var FTTmpRemark = _oPromotionImportCBDataSource.data.aResult[i].FTTmpRemark;
            var FTTmpStatus = _oPromotionImportCBDataSource.data.aResult[i].FTTmpStatus;

            _oRender.push([ 
                // Check Box
                {tSeqNo: FNTmpSeq, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // SeqNo
                {nTmpSeqNo: FNTmpSeq},
                // FTPmdGrpName
                {tPmdGrpName: FTPmdGrpName, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPbyStaBuyCond
                {tPbyStaBuyCond: FTPbyStaBuyCond, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FCPbyMinValue
                {tPbyMinValue: FCPbyMinValue, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FCPbyMaxValue
                {tPbyMaxValue: FCPbyMaxValue, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FCPbyMinSetPri
                {tPbyMinSetPri: FCPbyMinSetPri, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FTTmpRemark
                {tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // Delete Action
                '' 
            ]);
        }

        var _draw = poData.draw;
        var _recordsTotal = _oPromotionImportCBDataSource.recordsTotal;
        var _recordsFiltered = _oPromotionImportCBDataSource.recordsFiltered;

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
    function JSxPromotionImportCBSearchDataInTable() {
        JSxPromotionImportGetCBTable();
    }

    /**
     * Functionality : Confirm Delete by SeqNo in Temp
     * Parameters : poElm, ptDeleteType: M=Multiple, S=Single
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -s
     * Return Type : -
     */
    function JSxPromotionImportCBConfirmDeleteInTempBySeqInTemp(poElm, ptDeleteType){
        var aImportData = [];
        var aImportSeqNo = [];
        var aImportPackData;

        if(ptDeleteType == 'M'){ // Delete Multi
            if($(poElm).hasClass('disabled')){return;}

            var tConfirm = '<?php echo language('document/promotion/promotion', 'tWarMsg1'); ?>';
            console.log("tConfirm: ", tConfirm);
            $('#odvModalImportPromotionCBDelete .xCNPromotionCBConfirmDeltelLabel').html(tConfirm);

            var oImportDataSelect = JSON.parse(localStorage.getItem("PromotionCBLocalItemData"));
            $.each(oImportDataSelect, function(index, item){
                var tSeq = item.tSeqNo;
                var tPmdGrpName = item.tPmdGrpName;
                var tPbyStaBuyCond = item.tPbyStaBuyCond;
                var tPbyMinValue = item.tPbyMinValue;
                var tPbyMaxValue = item.tPbyMaxValue;
                var tMinSetPri = item.tMinSetPri;
                var tSta = item.tStatus
                aImportData.push({
                    tSeq: tSeq,
                    tPmdGrpName: tPmdGrpName,
                    tPbyStaBuyCond: tPbyStaBuyCond,
                    tPbyMinValue: tPbyMinValue,
                    tPbyMaxValue: tPbyMaxValue,
                    tMinSetPri: tMinSetPri,
                    tSta: tSta
                });
                aImportSeqNo.push(tSeq);
            });
        }

        if(ptDeleteType == 'S'){ // Delete Single
            var tSeq = $(poElm).parents('.xCNPromotionImportCBItem').data('seq');
            var tPmdGrpName = $(poElm).parents('.xCNPromotionImportCBItem').data('pmd-grp-name');
            var tPbyStaBuyCond = $(poElm).parents('.xCNPromotionImportCBItem').data('pby-sta-buy-cond');
            var tPbyMinValue = $(poElm).parents('.xCNPromotionImportCBItem').data('pby-min-value');
            var tPbyMaxValue = $(poElm).parents('.xCNPromotionImportCBItem').data('pby-max-value');
            var tMinSetPri = $(poElm).parents('.xCNPromotionImportCBItem').data('pby-min-set-pri');
            var tSta = $(poElm).parents('.xCNPromotionImportCBItem').data('sta');
            var tConfirm = $('#oetTextComfirmDeleteSingle').val() +'('+ tPbyStaBuyCond +','+ tPmdGrpName +','+ tPbyMinValue +','+ tPbyMaxValue +','+ tMinSetPri +')'+ '<?php echo language('common/main/main', 'tBCHYesOnNo')?>';
            $('#odvModalImportPromotionCBDelete .xCNPromotionCBConfirmDeltelLabel').html(tConfirm);

            aImportData.push({
                tSeq: tSeq,
                tPmdGrpName: tPmdGrpName,
                tPbyStaBuyCond: tPbyStaBuyCond,
                tPbyMinValue: tPbyMinValue,
                tPbyMaxValue: tPbyMaxValue,
                tMinSetPri: tMinSetPri,
                tSta: tSta
            });
            aImportSeqNo.push(tSeq);
        }

        aImportPackData = {
            aItems: aImportData,
            aSeqNo: aImportSeqNo
        };

        $('#odvModalImportPromotionCBDelete').modal({show: true, backdrop: false});

        $('#odvModalImportPromotionCBDelete .xCNPromotionCBImpConfirm').unbind().bind('click', function() {
            JSxPromotionImportCBDeleteInTempBySeq(poElm, aImportPackData);
        });

        $('#odvModalImportPromotionCBDelete .xCNPromotionCBImpCancel').on("click", function(){
            $('#odvModalImportPromotionCBDelete').modal('hide');
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
    function JSxPromotionImportCBDeleteInTempBySeq(poElm, poData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "promotionDeleteImportExcelCBInTempBySeq",
                data: {
                    tDataItem: JSON.stringify(poData)
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if(oResult.tCode = "1"){
                        localStorage.removeItem("PromotionCBLocalItemData");
                        $('#odvModalImportPromotionCBDelete').modal('hide');
                        oPromotionImportCBDataSource = null;
                        oPromotionImportCBDatatable.ajax.reload(null, false);
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
    function FSxPromotionImportCBGetStaInTemp(){
        $.ajax({
            type    : "POST",
            url     : "promotionGetImportExcelCBStaInTmp",
            cache   : false,
            timeout : 0,
            success : function(oResult){
                var nStaNewOrUpdate = oResult.nStaNewOrUpdate;
                var nStaSuccess = oResult.nStaSuccess;
                var nRecordTotal = oResult.nRecordTotal;

                var tTextShow = "<?php echo language('document/promotion/promotion', 'tLabel1'); ?> " + nStaSuccess + ' / ' + nRecordTotal + ' <?php echo language('document/promotion/promotion', 'tLabel2'); ?>';
                $('#odvConditionBuy .xCNPromotionCBSummaryImportText').text(tTextShow);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>