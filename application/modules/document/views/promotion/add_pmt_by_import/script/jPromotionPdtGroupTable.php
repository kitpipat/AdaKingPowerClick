<script>
    var oPromotionImportPdtGroupDatatable = null;
    var oPromotionImportPdtGroupDataSource = null;

    JSxPromotionImportPdtGroupRenderDataTable();

    $("#obtIMPConfirm").unbind().bind("click", function(){
        JSxPromotionImportPdtGroupTmpToMaster();
    });

    $("#otbPromotionImportExcelPdtGroupTable tbody").on("click", ".ocbListItem", function(){
        var nCheckedItem = $("#otbPromotionImportExcelPdtGroupTable tbody .ocbListItem:checked").length;
        
        if(nCheckedItem >= 1){
            $("li#oliBtnDeleteAll").removeClass("disabled");
        }else{
            $("li#oliBtnDeleteAll").addClass("disabled");
        }

        var tSeqNo = $(this).parents('.xCNPromotionImportPdtGroupItem').data('seq');
        var tPmdStaType = $(this).parents('.xCNPromotionImportPdtGroupItem').data('pmd-sta-type');
        var tPmdGrpName = $(this).parents('.xCNPromotionImportPdtGroupItem').data('pmd-grp-name');
        var tPmdBarCode = $(this).parents('.xCNPromotionImportPdtGroupItem').data('pmd-barcode');
        var tPmdSubRef = $(this).parents('.xCNPromotionImportPdtGroupItem').data('pmd-subref');
        var tStatus = $(this).parents('.xCNPromotionImportPdtGroupItem').data('sta');

        $(this).prop('checked', true);
        var PromotionPdtGroupLocalItemData = localStorage.getItem("PromotionPdtGroupLocalItemData");
        var obj = [];
        if(PromotionPdtGroupLocalItemData){
            obj = JSON.parse(PromotionPdtGroupLocalItemData);
        }
        var aArrayConvert = [JSON.parse(localStorage.getItem("PromotionPdtGroupLocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"tSeqNo":tSeqNo, "tPmdStaType":tPmdStaType, "tPmdGrpName":tPmdGrpName, "tPmdBarCode":tPmdBarCode, "tPmdSubRef":tPmdSubRef, "tStatus": tStatus});
            localStorage.setItem("PromotionPdtGroupLocalItemData",JSON.stringify(obj));
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeqNo',tSeqNo);
            if(aReturnRepeat == 'None' ){ // ยังไม่ถูกเลือก
                obj.push({"tSeqNo":tSeqNo, "tPmdStaType":tPmdStaType, "tPmdGrpName":tPmdGrpName, "tPmdBarCode":tPmdBarCode, "tPmdSubRef":tPmdSubRef, "tStatus": tStatus});
                localStorage.setItem("PromotionPdtGroupLocalItemData",JSON.stringify(obj));
            }else if(aReturnRepeat == 'Dupilcate'){	// เคยเลือกไว้แล้ว
                localStorage.removeItem("PromotionPdtGroupLocalItemData");
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
                localStorage.setItem("PromotionPdtGroupLocalItemData",JSON.stringify(aNewarraydata));
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
    function JSxPromotionImportPdtGroupRenderDataTable(){
        console.log("Render Start");
        oPromotionImportPdtGroupDatatable = $oNewJqueryVersion('#otbPromotionImportExcelPdtGroupTable').DataTable({
            serverSide: true,
            ordering: false,
            searching: false,
            lengthChange: false,
            bInfo: false,
            ajax: function(data, callback, settings) {
                if(oPromotionImportPdtGroupDataSource == null){
                    $.ajax({
                        type: "POST",
                        url: "promotionGetImportExcelPdtGroupDataJsonInTmp",
                        async: false,
                        data: {
                            'nPageNumber': data.draw - 1,
                            'tSearch': $('#oetPromotionImpPdtGroupSearchAll').val()
                        },
                    }).success(function(response) {
                        localStorage.removeItem("PromotionPdtGroupLocalItemData");
                        oPromotionImportPdtGroupDataSource = response;
                        var oDataSet = JSxPromotionImportPdtGroupSetDataSourceTable(oPromotionImportPdtGroupDataSource, data);

                        FSxPromotionImportPdtGroupGetStaInTemp();

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
                    var oDataSet = JSxPromotionImportPdtGroupSetDataSourceTable(oPromotionImportPdtGroupDataSource, data);
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
                $(row).attr('data-pmd-sta-type', data[2].tPmdStaType);
                $(row).attr('data-pmd-grp-name', data[3].tPmdGrpName);
                $(row).attr('data-pmd-barcode', data[4].tPmdBarCode);
                $(row).attr('data-pmd-subref', data[5].tPmdSubRef);
                $(row).attr('data-sta', data[0].tStatus);
                $(row).attr('data-remark', data[0].tRemark);
                $(row).addClass('xCNPromotionImportPdtGroupItem');
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
                        var oCheckedItems = JSON.parse(localStorage.getItem("PromotionPdtGroupLocalItemData"));
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
                { // FTPmdStaType
                    className: "text-center",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPmdStaType

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
                { // FTPmdGrpName
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPmdGrpName

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
                { // FTPmdBarCode
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPmdBarCode

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
                { // FTPmdSubRef
                    className: "text-center",
                    render: function(data, type, row){
                        var tStatus = data.tStatus;
                        var tRemark = data.tPmdSubRef

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
                        return '<img class="xCNIconTable xCNIconDel" onClick="JSxPromotionImportPdtGroupConfirmDeleteInTempBySeqInTemp(this, \'S\')" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>">';
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
    function JSxPromotionImportPdtGroupSetDataSourceTable(poPromotionImportPdtGroupDataSource, poData) {
        var _oPromotionImportPdtGroupDataSource = poPromotionImportPdtGroupDataSource;
        var _oDataSet = null;
        var _oRender = [];  
        var _draw = 1;
        var _recordsTotal = 0;
        var _recordsFiltered = 0; 

        console.log("Res: ", _oPromotionImportPdtGroupDataSource);
        console.log("data: ", poData);
        console.log("data.length: ", poData.length);
        console.log("data.start: ", poData.start);

        var nLength = _oPromotionImportPdtGroupDataSource.data.aResult.length;
        var nBreakPoint = 300;
        console.log("nLength Before: ", nLength);
        if(poData.start+nBreakPoint > nLength){
            nLength = nLength;
        }else{
            nLength = poData.start+nBreakPoint;
        }
        console.log("nLength After: ", nLength);

        for (var i=poData.start, ien=nLength; i<ien; i++ ) {
            var FNTmpSeq = _oPromotionImportPdtGroupDataSource.data.aResult[i].FNTmpSeq;
            var FTPmdStaType = _oPromotionImportPdtGroupDataSource.data.aResult[i].FTPmdStaType;
            var FTPmdGrpName = _oPromotionImportPdtGroupDataSource.data.aResult[i].FTPmdGrpName;
            var FTPmdBarCode = _oPromotionImportPdtGroupDataSource.data.aResult[i].FTPmdBarCode;
            var FTPmdSubRef = _oPromotionImportPdtGroupDataSource.data.aResult[i].FTPmdSubRef;
            var FTTmpRemark = _oPromotionImportPdtGroupDataSource.data.aResult[i].FTTmpRemark;
            var FTTmpStatus = _oPromotionImportPdtGroupDataSource.data.aResult[i].FTTmpStatus;

            _oRender.push([ 
                // Check Box
                {tSeqNo: FNTmpSeq, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // SeqNo
                {nTmpSeqNo: FNTmpSeq},
                // FTPmdStaType
                {tPmdStaType: FTPmdStaType, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPmdGrpName
                {tPmdGrpName: FTPmdGrpName, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPmdBarCode
                {tPmdBarCode: FTPmdBarCode, tStatus: FTTmpStatus, tRemark: FTTmpRemark}, 
                // FTPmdSubRef
                {tPmdSubRef: FTPmdSubRef, tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // FTTmpRemark
                {tStatus: FTTmpStatus, tRemark: FTTmpRemark},
                // Delete Action
                '' 
            ]);
        }

        var _draw = poData.draw;
        var _recordsTotal = _oPromotionImportPdtGroupDataSource.recordsTotal;
        var _recordsFiltered = _oPromotionImportPdtGroupDataSource.recordsFiltered;

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
    function JSxPromotionImportPdtGroupSearchDataInTable() {
        JSxPromotionImportGetPdtGroupTable();
    }

    /**
     * Functionality : Confirm Delete by SeqNo in Temp
     * Parameters : poElm, ptDeleteType: M=Multiple, S=Single
     * Creator : 30/10/2018 Piya
     * Last Modified : -
     * Return : -s
     * Return Type : -
     */
    function JSxPromotionImportPdtGroupConfirmDeleteInTempBySeqInTemp(poElm, ptDeleteType){
        var aImportData = [];
        var aImportSeqNo = [];
        var aImportPackData;

        if(ptDeleteType == 'M'){ // Delete Multi
            if($(poElm).hasClass('disabled')){return;}

            var tConfirm = '<?php echo language('document/promotion/promotion','tWarMsg1'); ?>'; // ยืนยันการลบข้อมูลที่เลือกใช่หรือไม่ ?
            console.log("tConfirm: ", tConfirm);
            $('#odvModalImportPromotionPdtGroupDelete .xCNPromotionPdtGroupConfirmDeltelLabel').html(tConfirm);

            var oImportDataSelect = JSON.parse(localStorage.getItem("PromotionPdtGroupLocalItemData"));
            $.each(oImportDataSelect, function(index, item){
                var tSeq = item.tSeqNo;
                var tPmdStaType = item.tPmdStaType;
                var tPmdGrpName = item.tPmdGrpName;
                var tPmdBarCode = item.tPmdBarCode;
                var tPmdSubRef = item.tPmdSubRef;
                var tSta = item.tStatus
                aImportData.push({
                    tSeq: tSeq,
                    tPmdStaType: tPmdStaType,
                    tPmdGrpName: tPmdGrpName,
                    tPmdBarCode: tPmdBarCode,
                    tPmdSubRef: tPmdSubRef,
                    tSta: tSta
                });
                aImportSeqNo.push(tSeq);
            });
        }

        if(ptDeleteType == 'S'){ // Delete Single
            var tSeq = $(poElm).parents('.xCNPromotionImportPdtGroupItem').data('seq');
            var tStaType = $(poElm).parents('.xCNPromotionImportPdtGroupItem').data('pmd-sta-type');
            var tPmdGrpName = $(poElm).parents('.xCNPromotionImportPdtGroupItem').data('pmd-grp-name');
            var tPmdBarCode = $(poElm).parents('.xCNPromotionImportPdtGroupItem').data('pmd-barcode');
            var tPmdSubRef = $(poElm).parents('.xCNPromotionImportPdtGroupItem').data('pmd-subref');
            var tSta = $(poElm).parents('.xCNPromotionImportPdtGroupItem').data('sta');
            var tConfirm = $('#oetTextComfirmDeleteSingle').val() +'('+ tStaType +','+ tPmdGrpName +','+ tPmdBarCode +','+ tPmdSubRef +')'+ '<?php echo language('common/main/main', 'tBCHYesOnNo')?>';
            $('#odvModalImportPromotionPdtGroupDelete .xCNPromotionPdtGroupConfirmDeltelLabel').html(tConfirm);

            aImportData.push({
                tSeq: tSeq,
                tStaType: tStaType,
                tPmdGrpName: tPmdGrpName,
                tPmdBarCode: tPmdBarCode,
                tPmdSubRef: tPmdSubRef,
                tSta: tSta
            });
            aImportSeqNo.push(tSeq);
        }

        aImportPackData = {
            aItems: aImportData,
            aSeqNo: aImportSeqNo
        };

        $('#odvModalImportPromotionPdtGroupDelete').modal({show: true, backdrop: false});

        $('#odvModalImportPromotionPdtGroupDelete .xCNPromotionPdtGroupImpConfirm').unbind().bind('click', function() {
            JSxPromotionImportPdtGroupDeleteInTempBySeq(poElm, aImportPackData);
        });

        $('#odvModalImportPromotionPdtGroupDelete .xCNPromotionPdtGroupImpCancel').on("click", function(){
            $('#odvModalImportPromotionPdtGroupDelete').modal('hide');
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
    function JSxPromotionImportPdtGroupDeleteInTempBySeq(poElm, poData) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "promotionDeleteImportExcelPdtGroupInTempBySeq",
                data: {
                    tDataItem: JSON.stringify(poData)
                },
                cache: false,
                timeout: 0,
                success: function(oResult) {
                    if(oResult.tCode = "1"){
                        localStorage.removeItem("PromotionPdtGroupLocalItemData");
                        $('#odvModalImportPromotionPdtGroupDelete').modal('hide');
                        oPromotionImportPdtGroupDataSource = null;
                        oPromotionImportPdtGroupDatatable.ajax.reload(null, false);
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
    function FSxPromotionImportPdtGroupGetStaInTemp(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $.ajax({
                type    : "POST",
                url     : "promotionGetImportExcelPdtGroupStaInTmp",
                cache   : false,
                timeout : 0,
                success : function(oResult){
                    var nStaNewOrUpdate = oResult.nStaNewOrUpdate;
                    var nStaSuccess = oResult.nStaSuccess;
                    var nRecordTotal = oResult.nRecordTotal;

                    var tTextShow = "<?php echo language('document/promotion/promotion', 'tLabel1'); ?> " + nStaSuccess + ' / ' + nRecordTotal + ' <?php echo language('document/promotion/promotion', 'tLabel2'); ?>';
                    $('#odvPromotionGroup .xCNPromotionPdtGroupSummaryImportText').text(tTextShow);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }
</script>