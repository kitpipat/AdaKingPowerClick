<script>

    $("document").ready(function () {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); 
        JSxPONavDefult();
        JSvPOCallPageList();
    });

    //control เมนู
    function JSxPONavDefult() {
        $("#oliPOTitleAdd").hide();
        $("#oliPOTitleEdit").hide();
        $("#odvBtnAddEdit").hide();

        $('#odvBtnPOPageAddorEdit').show();
    }

    //โหลด List
    function JSvPOCallPageList(){
        $.ajax({
            type    : "GET",
            url     : "docPOList",
            data    : {},
            cache   : false,
            timeout : 5000,
            success : function (tResult) {
                $("#odvContentPO").html(tResult);
                JSxPONavDefult();
                JSvPOCallPageDataTable();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //โหลด Table
    function JSvPOCallPageDataTable(pnPage){
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            var oAdvanceSearch = JSoPOGetAdvanceSearchData();
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = "1";
            }

            $.ajax({
                type    : "POST",
                url     : "docPODataTable",
                data    : {
                    oAdvanceSearch  : oAdvanceSearch,
                    nPageCurrent    : nPageCurrent
                },
                cache   : false,
                timeout : 5000,
                success : function (oResult) {
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        JSxPONavDefult();
                        $('#ostContentPO').html(aReturnData['tViewDataTable']);
                    } else {
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                    }
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ข้อมูลค้นหาขั้นสูง 
    function JSoPOGetAdvanceSearchData() {
        try {
            let oAdvanceSearchData = {
                tSearchAll          : $("#oetSearchAll").val(),
                tSearchBchCodeFrom  : $("#oetAPOBchNameFrom").val(),
                tSearchBchCodeTo    : $("#oetAPOBchCodeTo").val(),
                tSearchDocDateFrom  : $("#oetAPODocDateFrom").val(),
                tSearchDocDateTo    : $("#oetAPODocDateTo").val(),
                tSearchStaDoc       : $("#ocmAPOStaDoc").val(),
                tSearchStaApprove   : $("#ocmAPOStaApprove").val(),
                tSearchStaPrcStk    : $("#ocmAPOStaPrcStk").val()
            };
            return oAdvanceSearchData;
        } catch (err) {
            console.log("ค้นหาขั้นสูง Error: ", err);
        }
    }

    //โหลด หน้าจอเพิ่ม หรือ หน้าจอแก้ไข
    function JSvPOPageAdd(ptType){
        try{
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JCNxOpenLoading();
                $.ajax({
                    type    : "POST",
                    url     : "docPOPageAdd",
                    cache   : false,
                    timeout : 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvBtnPOPageAddorEdit').hide();

                            if(ptType == 'pageadd'){
                                $('#oliPOTitleAdd').show();
                            }else{
                                $('#oliPOTitleEdit').show();
                            }
                            
                            $('#odvContentPO').html(aReturnData['tViewPageAdd']);
                            JCNxCloseLoading();
                        }else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
                JCNxShowMsgSessionExpired();
            }
        }catch(err){
            console.log('JSvPOPageAdd Error: ', err);
        }
    }
    
    //ย้อนกลับไปหน้า List
    function JSvPOCallPageMain(){
        $.ajax({
            type    : "GET",
            url     : "docPOList",
            data    : {},
            cache   : false,
            timeout : 5000,
            success : function (tResult) {
                $("#odvContentPO").html(tResult);
                JSxPONavDefult();
                JSvPOCallPageDataTable();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>