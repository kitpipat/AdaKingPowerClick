<script>
    var nStaBrowseType   = $('#oetABBStaBrowse').val();
    var tCallBackOption  = $('#oetABBCallBackOption').val();

    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxABBNavDefult();
        JSxABBPageList();
    });

    //ซ่อนปุ่มต่างๆ
    // Create By: Napat(Jame) 02/07/2021
    function JSxABBNavDefult() {
        try {
            $('.xCNABBMaster').show();
            // $('#oliABBTitleAdd').hide();
            $('#oliABBTitleEdit').hide();
            $('#odvABBBtnAddEdit').hide();
            $('#odvABBBtnInfo').show();
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    // เรียกหน้า List มาแสดง
    // Create By: Napat(Jame) 02/07/2021
    function JSxABBPageList() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $('#oetSearchAll').val('');
                $.ajax({
                    type: "POST",
                    url: "docABBPageList",
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvABBContent').html(tResult);
                        JSxABBPageDatatable();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    // เรียกหน้า DataTable มาแสดง
    // Create By: Napat(Jame) 02/07/2021
    function JSxABBPageDatatable(pnPage,ptTypeSearch) {
        try {
            JCNxOpenLoading();
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = $('#ohdABBOldPageList').val();
            }

            var aSearchList = {
                tAgnCode   : $('#oetABBAgnCode').val(),
                tBchCode   : $('#oetABBBchCode').val(),
                tStaPrcDoc : $('#ocmABBStaPrcDoc').val(),
                tStaDocAct : $('#oetABBStaDocAct').val(),
                tDocType   : $('#oetABBDocType').val(),
                tDocNo     : $('#oetABBFilterDocNo').val(),
                tChnCode   : $('#oetABBChannel').val()
            };

            if( ptTypeSearch != "ADD" ){
                var aOldFilterList = $('#ohdABBOldFilterList').val();
                if( aOldFilterList != "" ){
                    aSearchList = JSON.parse(aOldFilterList);
                    $('#oetABBAgnCode').val(aSearchList['tAgnCode']);
                    $('#oetABBBchCode').val(aSearchList['tBchCode']);
                    $('#oetABBDocDate').val(aSearchList['dDocDate']);
                    $('#ocmABBStaPrcDoc').val(aSearchList['tStaPrcDoc']);
                    $('#oetABBChannel').val(aSearchList['tChnCode']);
                    $('#oetABBFilterDocNo').val(aSearchList['tDocNo']);
                    $('#oetABBDocType').val(aSearchList['tDocType']);
                    $('.selectpicker').selectpicker('refresh')
                }
            }else{
                $('#ohdABBOldFilterList').val(JSON.stringify(aSearchList));
            }
            $('#ohdABBOldPageList').val(nPageCurrent);

            $.ajax({
                type: "POST",
                url: "docABBPageDataTable",
                data: {
                    pnPageCurrent : nPageCurrent,
                    paSearchList  : aSearchList
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    JSxABBNavDefult();
                    JCNxLayoutControll();
                    $('#ostABBContentDatatable').html(tResult);
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    // เปลี่ยนหน้า 1 2 3 ..
    // Create By: Napat(Jame) 02/07/2021
    function JSxABBEventClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageABBPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageABBPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JSxABBPageDatatable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //Page - Edit
    function JSxABBPageEdit(ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docABBPageEdit",
                    data: {
                        ptDocNo: ptDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $(window).scrollTop(0);
                            $('.xCNABBMaster').show();
                            $('#oliABBTitleEdit').show();
                            $('#odvBtnABBInfo').hide();
                            $('#odvABBBtnAddEdit').show();
                            $('#odvABBContent').html(aReturnData['tViewPageAdd']);

                            var tABBTextBtn = "";
                            var tStaETax = "";
                            if( aReturnData['tXshStaETax'] == "" ){
                                tStaETax = '2';
                            }else{
                                tStaETax = aReturnData['tXshStaETax'];
                            }

                            if( aReturnData['nXshDocType'] == '1' ){
                                tXshDocType = '';
                            }else{
                                tXshDocType = 'CN';
                            }

                            // ABB
                            switch(tStaETax){
                                case '1':
                                    var tXshETaxStatus = aReturnData['tXshETaxStatus'];
                                    if( tXshETaxStatus != '3' ){
                                        if( tXshETaxStatus == '2' ){
                                            tABBTextBtn = JStABBChangeLangDocType('tABBBtnCheckABB',tXshDocType);
                                        }else{
                                            tABBTextBtn = JStABBChangeLangDocType('tABBBtnDownloadABB',tXshDocType);
                                        }

                                        if( aReturnData['tXshRefTax'] != "" ){ // ถ้าใน SalHD มี RefTax ให้เปิดปุ่ม download
                                            $('#obtABBDownloadDoc').show();
                                        }else{
                                            $('#obtABBDownloadDoc').hide();
                                        }
                                    }else{
                                        $('#obtABBDownloadDoc').hide();
                                    }
                                    break;
                                default:
                                    tABBTextBtn = JStABBChangeLangDocType('tABBBtnPrintABB',tXshDocType);
                                    $('#obtABBDownloadDoc').show();
                            }
                            $('#obtABBDownloadDoc').attr('data-staetax',tStaETax);
                            $('#obtABBDownloadDoc').html(tABBTextBtn);

                            // Full Tax
                            var tXshDocVatFull = aReturnData['tXshDocVatFull'];
                            var tXshStaPrcDoc  = aReturnData['tXshStaPrcDoc'];
                            if( tXshDocVatFull != "" && tXshStaPrcDoc == '5' ){ // ถ้าลูกค้าขอออกใบ Full Tax และอนุมัติ ABB แล้วให้แสดงปุ่มดาวน์โหลด Full Tax
                                var tXshStaETaxFullTax = aReturnData['tXshStaETaxFullTax'];
                                switch(tXshStaETaxFullTax){
                                    case '1':
                                        var tXshETaxStatusFullTax = aReturnData['tXshETaxStatusFullTax'];
                                        if( tXshETaxStatusFullTax == '1' ){
                                            tABBTextBtn = JStABBChangeLangDocType('tABBBtnDownloadFullTax',tXshDocType);
                                        }else{
                                            tABBTextBtn = JStABBChangeLangDocType('tABBBtnCheckFullTax',tXshDocType);
                                        }
                                        break;
                                    default:
                                        tABBTextBtn = JStABBChangeLangDocType('tABBBtnPrintFullTax',tXshDocType);
                                }
                                $('#obtABBDownloadFullTax').show();
                                $('#obtABBDownloadFullTax').attr('data-etaxstatus',tXshETaxStatusFullTax);
                                $('#obtABBDownloadFullTax').attr('data-staetax',tXshStaETaxFullTax);
                                $('#obtABBDownloadFullTax').html(tABBTextBtn);
                            }else{
                                $('#obtABBDownloadFullTax').hide();
                            }

                            JCNxLayoutControll();
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    function JStABBChangeLangDocType(ptVar,ptDocType){
        // console.log(ptVar + " - " + ptDocType);
        switch(ptVar){
            case 'tABBBtnDownloadABB':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnDownloadABB');?>';
                }else{
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnDownloadCNABB');?>';
                }
            break;
            case 'tABBBtnCheckABB':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnCheckABB');?>';
                }else{
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnCheckCNABB');?>';
                }
            break;
            case 'tABBBtnPrintABB':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnPrintABB');?>';
                }else{
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnPrintCNABB');?>';
                }
            break;
            case 'tABBBtnCheckFullTax':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnCheckFullTax');?>';
                }else{
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnCheckCNFullTax');?>';
                }
            break;
            case 'tABBBtnDownloadFullTax':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnDownloadFullTax');?>';
                }else{
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnDownloadCNFullTax');?>';
                }
            break;
            case 'tABBBtnPrintFullTax':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnPrintFullTax');?>';
                }else{
                    tReturn = '<?=language('document\abbsalerefund\abbsalerefund', 'tABBBtnPrintCNFullTax');?>';
                }
            break;
        }
        return tReturn;
        
    }

</script>