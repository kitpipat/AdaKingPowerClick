<script>
    var nStaBrowseType   = $('#oetCSSStaBrowse').val();
    var tCallBackOption  = $('#oetCSSCallBackOption').val();

    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxCSSNavDefult();
        JSxCSSPageList();
    });

    //ซ่อนปุ่มต่างๆ
    // Create By: Napat(Jame) 02/07/2021
    function JSxCSSNavDefult() {
        try {
            $('.xCNCSSMaster').show();
            // $('#oliCSSTitleAdd').hide();
            $('#oliCSSTitleEdit').hide();
            $('#odvCSSBtnAddEdit').hide();
            $('#odvCSSBtnInfo').show();
        } catch (oErr) {
            FSvCMNSetMsgWarningDialog(oErr.message);
        }
    }

    // เรียกหน้า List มาแสดง
    // Create By: Napat(Jame) 02/07/2021
    function JSxCSSPageList() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $('#oetSearchAll').val('');
                $.ajax({
                    type: "POST",
                    url: "docCSSPageList",
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvCSSContent').html(tResult);
                        JSxCSSPageDatatable();
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
    function JSxCSSPageDatatable(pnPage,ptTypeSearch) {
        try {
            JCNxOpenLoading();
            var nPageCurrent = pnPage;
            if (nPageCurrent == undefined || nPageCurrent == "") {
                nPageCurrent = $('#ohdCSSOldPageList').val();
            }

            var aSearchList = {
                tAgnCode   : $('#oetCSSAgnCode').val(),
                tBchCode   : $('#oetCSSBchCode').val(),
                dDocDate   : $('#oetCSSDocDate').val(),
                tStaPrcDoc : $('#ocmCSSStaPrcDoc').val(),
                tChnCode   : $('#oetCSSChannel').val(),
                tDocNo     : $('#oetCSSFilterDocNo').val(),
                tDocType   : $('#oetCSSDocType').val()
            };

            if( ptTypeSearch != "ADD" ){
                var aOldFilterList = $('#ohdCSSOldFilterList').val();
                if( aOldFilterList != "" ){
                    aSearchList = JSON.parse(aOldFilterList);
                    $('#oetCSSAgnCode').val(aSearchList['tAgnCode']);
                    $('#oetCSSBchCode').val(aSearchList['tBchCode']);
                    $('#oetCSSDocDate').val(aSearchList['dDocDate']);
                    $('#ocmCSSStaPrcDoc').val(aSearchList['tStaPrcDoc']);
                    $('#oetCSSChannel').val(aSearchList['tChnCode']);
                    $('#oetCSSFilterDocNo').val(aSearchList['tDocNo']);
                    $('#oetCSSDocType').val(aSearchList['tDocType']);
                    $('.selectpicker').selectpicker('refresh')
                }
            }else{
                $('#ohdCSSOldFilterList').val(JSON.stringify(aSearchList));
            }

            $('#ohdCSSOldPageList').val(nPageCurrent);

            $.ajax({
                type: "POST",
                url: "docCSSPageDataTable",
                data: {
                    pnPageCurrent : nPageCurrent,
                    paSearchList  : aSearchList
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    JSxCSSNavDefult();
                    JCNxLayoutControll();
                    $('#ostCSSContentDatatable').html(tResult);
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
    function JSxCSSEventClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageCSSPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageCSSPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JSxCSSPageDatatable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //Page - Edit
    function JSxCSSPageEdit(ptDocNo) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docCSSPageEdit",
                    data: {
                        ptDocNo: ptDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        // console.log(aReturnData);
                        if (aReturnData['nStaEvent'] == '1') {
                            $(window).scrollTop(0);
                            $('.xCNCSSMaster').show();
                            $('#oliCSSTitleEdit').show();
                            $('#odvBtnCSSInfo').hide();
                            $('#odvCSSBtnAddEdit').show();
                            $('#odvCSSContent').html(aReturnData['tViewPageAdd']);

                            var tCSSTextBtn = "";
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
                                            tCSSTextBtn = JStCSSChangeLangDocType('tCSSBtnCheckABB',tXshDocType);
                                        }else{
                                            tCSSTextBtn = JStCSSChangeLangDocType('tCSSBtnDownloadABB',tXshDocType);
                                        }
                                        if( aReturnData['tXshRefTax'] != "" ){ // ถ้าใน SalHD มี RefTax ให้เปิดปุ่ม download
                                            $('#obtCSSDownloadDoc').show();
                                        }else{
                                            $('#obtCSSDownloadDoc').hide();
                                        }
                                    }else{
                                        $('#obtCSSDownloadDoc').hide();
                                    }
                                    break;
                                default:
                                    tCSSTextBtn = JStCSSChangeLangDocType('tCSSBtnPrintABB',tXshDocType);
                                    $('#obtCSSDownloadDoc').show();
                            }
                            $('#obtCSSDownloadDoc').attr('data-staetax',tStaETax);
                            $('#obtCSSDownloadDoc').html(tCSSTextBtn);

                            // Full Tax
                            var tXshDocVatFull = aReturnData['tXshDocVatFull'];
                            var tXshStaPrcDoc  = aReturnData['tXshStaPrcDoc'];
                            if( tXshDocVatFull != "" && tXshStaPrcDoc == '5' ){ // ถ้าลูกค้าขอออกใบ Full Tax และอนุมัติ ABB แล้วให้แสดงปุ่มดาวน์โหลด Full Tax
                                var tXshStaETaxFullTax = aReturnData['tXshStaETaxFullTax'];
                                // console.log(tXshStaETaxFullTax);
                                switch(tXshStaETaxFullTax){
                                    case '1':
                                        var tXshETaxStatusFullTax = aReturnData['tXshETaxStatusFullTax'];
                                        if( tXshETaxStatusFullTax != '1' ){
                                            tCSSTextBtn = JStCSSChangeLangDocType('tCSSBtnCheckFullTax',tXshDocType);
                                        }else{
                                            tCSSTextBtn = JStCSSChangeLangDocType('tCSSBtnDownloadFullTax',tXshDocType);
                                        }
                                        break;
                                    default:
                                        tCSSTextBtn = JStCSSChangeLangDocType('tCSSBtnPrintFullTax',tXshDocType);
                                }

                                $('#obtCSSDownloadFullTax').show();
                                $('#obtCSSDownloadFullTax').attr('data-etaxstatus',tXshETaxStatusFullTax);
                                $('#obtCSSDownloadFullTax').attr('data-staetax',tXshStaETaxFullTax);
                                $('#obtCSSDownloadFullTax').html(tCSSTextBtn);
                            }else{
                                $('#obtCSSDownloadFullTax').hide();
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

    function JStCSSChangeLangDocType(ptVar,ptDocType){
        // console.log(ptVar + " - " + ptDocType);
        switch(ptVar){
            case 'tCSSBtnDownloadABB':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownloadABB');?>';
                }else{
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownloadCNABB');?>';
                }
            break;
            case 'tCSSBtnCheckABB':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnCheckABB');?>';
                }else{
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnCheckCNABB');?>';
                }
            break;
            case 'tCSSBtnPrintABB':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnPrintABB');?>';
                }else{
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnPrintCNABB');?>';
                }
            break;
            case 'tCSSBtnCheckFullTax':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnCheckFullTax');?>';
                }else{
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnCheckCNFullTax');?>';
                }
            break;
            case 'tCSSBtnDownloadFullTax':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownloadFullTax');?>';
                }else{
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnDownloadCNFullTax');?>';
                }
            break;
            case 'tCSSBtnPrintFullTax':
                if( ptDocType == '' ){
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnPrintFullTax');?>';
                }else{
                    tReturn = '<?=language('document/checkstatussale/checkstatussale', 'tCSSBtnPrintCNFullTax');?>';
                }
            break;
        }
        return tReturn;
        
    }

</script>