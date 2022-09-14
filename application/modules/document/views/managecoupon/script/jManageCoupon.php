<script>
    var nMCPStaBrowseType   = $("#oetMCPStaBrowseType").val();
    var tMCPCallBackOption  = $("#oetMCPCallBackOption").val();

    $("document").ready(function(){
        localStorage.removeItem("LocalItemData");
        
        $('#oliMCPTitle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvMCPCallPageList();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        // JSxMCPNavDefultDocument();
        JSvMCPCallPageList();

    });

    $('#obtMCPAdjustStatus').off('click').on('click',function(){
        // var tDocNoMulti = $("#ohdMCPDocNoMulti").val();
        // alert(tDocNoMulti);
        if( $(this).attr('disabled') != "disabled" ){
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docManageCouponAdjustStatus",
                data: {
                    ptDocNoMulti    : $("#ohdMCPDocNoMulti").val(),
                    ptEventAction   : $('#ohdMCPAdjType').val()
                },
                cache: false,
                timeout: 0,
                success: function (oResult){
                    var aReturnData = JSON.parse(oResult);
                    if( aReturnData['nStaEvent'] == 1 ){
                        localStorage.removeItem("LocalItemData");
                        // $("#obtMCPAdjustStatus").addClass("xCNDisabled");
                        $("#obtMCPAdjustStatus").attr('disabled',true);
                        $("#ohdMCPDocNoMulti").val('');
                        JSvMCPCallPageDataTable();
                    }else{
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxCloseLoading();
                    }
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }
    });

    function JSvMCPCallPageList(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
            $.ajax({
                type: "POST",
                url: "docManageCouponFormSearchList",
                cache: false,
                timeout: 0,
                success: function (tResult){
                    $("#odvMCPContentPageDocument").html(tResult);
                    // JSxMCPNavDefultDocument();
                    JSvMCPCallPageDataTable();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    function JSoMCPGetAdvanceSearchData(){
        var oAdvanceSearchData  = {
            tSearchAll          : $("#oetMCPSearchAllDocument").val().trim(),
            tSearchBchCode      : $("#oetMCPAdvSearchBchCode").val(),
            tSearchDocDateFrom  : $("#oetMCPAdvSearcDocDateFrom").val(),
            tSearchDocDateTo    : $("#oetMCPAdvSearcDocDateTo").val(),
            tSearchStaDoc       : $("#ocmMCPAdvSearchStaDoc").val(),
            tSearchStaDocType   : $("#ocmMCPAdvSearchDocType").val()
        };
        return oAdvanceSearchData;
    }

    function JSvMCPCallPageDataTable(pnPage){
        JCNxOpenLoading();
        let oAdvanceSearch  = JSoMCPGetAdvanceSearchData();
        let nPageCurrent    = pnPage;
        if(typeof(nPageCurrent) == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        $.ajax({
            type: "POST",
            url: "docManageCouponPageDataTable",
            data: {
                oAdvanceSearch  : oAdvanceSearch,
                nPageCurrent    : nPageCurrent,
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                var aReturnData = JSON.parse(oResult);
                if( aReturnData['nStaEvent'] == 1 ){
                    // JSxMCPNavDefultDocument();
                    $('#ostMCPDataTableDocument').html(aReturnData['tMCPViewDataTableList']);
                }else{
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                // JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    function JSxMCPClickPageList(ptPage){
        var nPageCurrent = '';
        switch (ptPage) {
            case 'next': //กดปุ่ม Next
                $('.xWBtnNext').addClass('disabled');
                nPageOld    = $('.xWMCPPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew    = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew
                break;
            case 'previous': //กดปุ่ม Previous
                nPageOld    = $('.xWMCPPageDataTable .active').text(); // Get เลขก่อนหน้า
                nPageNew    = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew
                break;
            default:
                nPageCurrent = ptPage
        }
        JSvMCPCallPageDataTable(nPageCurrent);
    }

    function JSxMCPTextinModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") { 
            $('#ohdMCPAdjType').val('');
            $('#ohdMCPDocNoMulti').val('');
            $("#obtMCPAdjustStatus").attr('disabled',true);
            $('.xWMCPDocItems').each(function(index, otr) { 
                $('#ocbListItem'+index).attr('disabled',false);
                $('#ospListItem'+index).removeClass("xCNDisabled");
            });
        }else{
            var tTextCode = "";
            var nMaxLength = aArrayConvert[0].length;
            for (var i = 0; i < nMaxLength; i++) {
                tTextCode += aArrayConvert[0][i].nCode;
                if( (i+1) != nMaxLength ){
                    tTextCode += ",";
                }
            }

            if( nMaxLength == 1 ){
                var tSelectedStatus = aArrayConvert[0][0].tStatus;

                if( tSelectedStatus == '1' ){
                    $('#obtMCPAdjustStatus').text('ปิดใช้งาน');
                }else{
                    $('#obtMCPAdjustStatus').text('เปิดใช้งาน');
                }

                $('#ohdMCPAdjType').val(tSelectedStatus);
                $('.xWMCPDocItems').each(function(index, otr) { 
                    var tTableStatus = otr.attr('data-status');
                    if( parseInt(tSelectedStatus) != parseInt(tTableStatus) ){
                        $('#ocbListItem'+index).attr('disabled',true);
                        $('#ospListItem'+index).addClass("xCNDisabled");
                    }
                });
            }

            //Disabled ปุ่ม Delete
            if ( nMaxLength >= 1 ) {
                // $("#obtMCPAdjustStatus").removeClass("xCNDisabled");
                $("#obtMCPAdjustStatus").attr('disabled',false);
            } else {
                // $("#obtMCPAdjustStatus").addClass("xCNDisabled");
                $("#obtMCPAdjustStatus").attr('disabled',true);
            }

            $("#ohdMCPDocNoMulti").val(tTextCode);
        }
    }

    function JSxMCPShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#oliMCPBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#oliMCPBtnDeleteAll").removeClass("disabled");
            } else {
                $("#oliMCPBtnDeleteAll").addClass("disabled");
            }
        }
    }

    function JStMCPFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

</script>