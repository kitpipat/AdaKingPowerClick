<script>
    var nStaTRNBrowseType = $('#oetTRNStaBrowse').val();
    var tCallTRNBackOption = $('#oetTRNCallBackOption').val();

    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxTRNNavDefult();
        JSvTRNCallPageTransferReceipt();
    });

    //ซ่อนปุ่มต่างๆ
    function JSxTRNNavDefult() {
        try {
            $('.xCNTRNMaster').show();
            $('#oliTransferReceiptTitleAdd').hide();
            $('#oliTransferReceiptTitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('#odvBtnTransferReceiptInfo').show();
        } catch (err) {
            console.log('JSxCardShiftTopUpCardShiftTopUpNavDefult Error: ', err);
        }
    }

    //Page - List
    function JSvTRNCallPageTransferReceipt() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $('#oetSearchAll').val('');
                $.ajax({
                    type: "POST",
                    url: "TXOOutTransferReceiptList",
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvContentTransferReceipt').html(tResult);
                        JSvTRNCallPageTransferReceiptDataTable();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvTRNCallPageTransferReceipt Error: ', err);
        }
    }

    //Page - Datatable
    function JSvTRNCallPageTransferReceiptDataTable(pnPage) {
        JCNxOpenLoading();
        var oAdvanceSearch = JSoTRNGetAdvanceSearchData();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        JCNxCloseLoading();
        $.ajax({
            type: "POST",
            url: "TXOOutTransferReceiptDataTable",
            data: {
                oAdvanceSearch: oAdvanceSearch,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTRNNavDefult();
                    $('#ostContentTransferreceipt').html(aReturnData['tViewDataTable']);
                } else {
                    var tMessageError = aReturnData['tStaMessg'];
                    FSvCMNSetMsgErrorDialog(tMessageError);
                }
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Page - Add
    function JSvTRNTransferReceiptAdd() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "TXOOutTransferReceiptPageAdd",
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('.xCNTRNMaster').show();
                            $('#oliTransferReceiptTitleEdit').hide();
                            $('#oliTransferReceiptTitleAdd').show();
                            $('#odvBtnTransferReceiptInfo').hide();
                            $('#odvBtnAddEdit').show();
                            JSxControlBTN('PAGEADD');
                            $('#odvContentTransferReceipt').html(aReturnData['tViewPageAdd']);
                            JCNxLayoutControll();
                            JCNxCloseLoading();

                            //Load PDT - TABLE
                            JSvTRNLoadPdtDataTableHtml();
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvTRNTransferReceiptAdd Error: ', err);
        }
    }

    //Page - Edit - ใบรับเข้า
    function JSvTWICallPageEdit(ptDocNumber) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "TXOOutTransferReceiptPageEdit",
                    data: {
                        ptDocNumber: ptDocNumber
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('.xCNTRNMaster').show();
                            $('#oliTransferReceiptTitleEdit').show();
                            $('#oliTransferReceiptTitleAdd').hide();
                            $('#odvBtnTransferReceiptInfo').hide();
                            $('#odvBtnAddEdit').show();
                            JSxControlBTN('PAGEEDIT');
                            $('#odvContentTransferReceipt').html(aReturnData['tViewPageAdd']);
                            JCNxLayoutControll();
                            JCNxCloseLoading();

                            //Load PDT - TABLE
                            JSvTRNLoadPdtDataTableHtml();
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTRNResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvTWICallPageEdit Error: ', err);
        }
    }

    //Control ปุ่ม
    function JSxControlBTN(ptTypeEvent) {
        if (ptTypeEvent == 'PAGEADD') {
            $('#obtTrnOutPrintDoc').hide();
            $('#obtTWICancelDoc').hide();
            $('#obtTWIApproveDoc').hide();
        }
    }

    //Page - Product Table
    function JSvTRNLoadPdtDataTableHtml(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            if ($("#ohdTWIRoute").val() == "dcmTWIEventAdd") {
                var tTWIDocNo = "";
            } else {
                var tTWIDocNo = $("#oetTWIDocNo").val();
            }

            var tTWIStaApv = $("#ohdTWIStaApv").val();
            var tTWIStaDoc = $("#ohdTWIStaDoc").val();

            if (pnPage == '' || pnPage == null) {
                var pnNewPage = 1;
            } else {
                var pnNewPage = pnPage;
            }
            var nPageCurrent = pnNewPage;
            var tSearchPdtAdvTable = $('#oetTWIFrmFilterPdtHTML').val();

            $.ajax({
                type: "POST",
                url: "TXOOutTransferReceiptPdtAdvanceTableLoadData",
                data: {
                    'ptSearchPdtAdvTable': tSearchPdtAdvTable,
                    'ptTWIDocNo': tTWIDocNo,
                    'ptTWIStaApv': tTWIStaApv,
                    'ptTWIStaDoc': tTWIStaDoc,
                    'pnTWIPageCurrent': nPageCurrent,
                    'tBCH': $('#oetSOFrmBchCode').val()
                },
                cache: false,
                Timeout: 0,
                success: function(oResult) {
                    localStorage.removeItem('TWI_LocalItemDataDelDtTemp');
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        $('#odvTWIDataPdtTableDTTemp').html(aReturnData['tTWIPdtAdvTableHtml']);
                        // var aTWIEndOfBill    = aReturnData['aTWIEndOfBill'];
                        // JSxTWISetFooterEndOfBill(aTWIEndOfBill);
                        JCNxCloseLoading();
                    } else {
                        var tMessageError = aReturnData['tStaMessg'];
                        FSvCMNSetMsgErrorDialog(tMessageError);
                        JCNxCloseLoading();
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

    //แสดง error
    function JCNxTRNResponseError(jqXHR, textStatus, errorThrown) {
        try {
            JCNxResponseError(jqXHR, textStatus, errorThrown)
        } catch (err) {
            console.log('JCNxTRNResponseError Error: ', err);
        }
    }

    //ฟังก์ชั่น get ค่า INPUT Search
    function JSoTRNGetAdvanceSearchData() {
        var oAdvanceSearchData = {
            tSearchAll: $("#oetSearchAll").val(),
            tSearchBchCodeFrom: $("#oetASTBchCodeFrom").val(),
            tSearchBchCodeTo: $("#oetASTBchCodeTo").val(),
            tSearchDocDateFrom: $("#oetASTDocDateFrom").val(),
            tSearchDocDateTo: $("#oetASTDocDateTo").val(),
            tSearchStaDoc: $("#ocmASTStaDoc").val(),
            tSearchStaDocAct: $("#ocmStaDocAct").val(),
            tSearchStaApprove: $("#ocmASTStaApprove").val(),
            tSearchStaPrcStk: $("#ocmASTStaPrcStk").val()
        };
        return oAdvanceSearchData;
    }

    //ฟังก์ชั่นล้างค่า Input Advance Search
    function JSxTRNClearSearchData() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $("#oetSearchAll").val("");
            $("#oetASTBchCodeFrom").val("");
            $("#oetASTBchNameFrom").val("");
            $("#oetASTBchCodeTo").val("");
            $("#oetASTBchNameTo").val("");
            $("#oetASTDocDateFrom").val("");
            $("#oetASTDocDateTo").val("");
            $(".xCNDatePicker").datepicker("setDate", null);
            $(".selectpicker").val("0").selectpicker("refresh");
            JSvTRNCallPageTransferReceiptDataTable();
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //เปลี่ยนหน้า 1 2 3 ..
    function JSvTWIClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageTWIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageTWIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JSvTRNCallPageTransferReceiptDataTable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบ HD - ตัวเดียว
    function JSoTWIDelDocSingle(ptCurrentPage, ptTWIDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $('#odvTWIModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ptTWIDocNo);
            $('#odvTWIModalDelDocSingle').modal('show');
            $('#odvTWIModalDelDocSingle #osmTWIConfirmPdtDTTemp ').unbind().click(function() {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "TXOOutTransferReceiptEventDelete",
                    data: {
                        'tTWIDocNo': ptTWIDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvTWIModalDelDocSingle').modal('hide');
                            $('#odvTWIModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                JSvTRNCallPageTransferReceipt();
                            }, 500);
                        } else {
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            });
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบ HD - หลายตัว
    function JSoTWIDelDocMultiple() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
            var aDataDelMultiple = $('#odvTWIModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
            var aTextsDelMultiple = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
            var aDataSplit = aTextsDelMultiple.split(" , ");
            var nDataSplitlength = aDataSplit.length;
            var aNewIdDelete = [];

            for ($i = 0; $i < nDataSplitlength; $i++) {
                aNewIdDelete.push(aDataSplit[$i]);
            }
            if (nDataSplitlength > 1) {
                JCNxOpenLoading();
                localStorage.StaDeleteArray = '1';
                $.ajax({
                    type: "POST",
                    url: "TXOOutTransferReceiptEventDelete",
                    data: {
                        'tTWIDocNo': aNewIdDelete
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvTWIModalDelDocMultiple').modal('hide');
                            $('#odvTWIModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
                            $('#odvTWIModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
                            $('.modal-backdrop').remove();
                            localStorage.removeItem('LocalItemData');
                            setTimeout(function() {
                                JSvTRNCallPageTransferReceipt();
                            }, 500);
                        } else {
                            JCNxCloseLoading();
                            FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ยกเลิกเอกสาร
    function JSxTRNTransferReceiptDocCancel(pbIsConfirm) {
        tTWIDocNo = $("#oetTWIDocNo").val();
        if (pbIsConfirm) {
            $.ajax({
                type: "POST",
                url: "TXOOutTransferReceiptEventCencel",
                data: {
                    tTWIDocNo: tTWIDocNo
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvTWIPopupCancel").modal("hide");
                    aResult = $.parseJSON(tResult);
                    if (aResult.nSta == 1) {
                        JSvTWICallPageEdit(tTWIDocNo);
                    } else {
                        JCNxCloseLoading();
                        tMsgBody = aResult.tMsg;
                        FSvCMNSetMsgErrorDialog(tMsgBody);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        } else {
            $("#odvTWIPopupCancel").modal("show");
        }
    }

    //อนุมัติเอกสาร
    function JSxTRNTransferReceiptStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                if (pbIsConfirm) {
                    $("#ohdTWIStaPrcStk").val(2); // Set status for processing approve 
                    $('#odvTWIModalAppoveDoc').modal("hide");

                    var tXthDocNo = $("#oetTWIDocNo").val();
                    var tXthStaApv = $("#ohdTWIStaApv").val();
                    var tXthBchCode = $('#oetSOFrmBchCode').val();

                    $.ajax({
                        type: "POST",
                        url: "TXOOutTransferReceiptEventApproved",
                        data: {
                            tXthDocNo: tXthDocNo,
                            tXthStaApv: tXthStaApv,
                            tXthBchCode: tXthBchCode
                        },
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            if (tResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(tResult.tStaMessg);
                                JCNxCloseLoading();
                                return;
                            }
                            JSoTWISubscribeMQ();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#odvTWIModalAppoveDoc').modal("show");
                }
            } catch (err) {
                console.log("JSnTFWApprove Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //อนุมัติเอกสาร
    function JSoTWISubscribeMQ() {
        var tLangCode = $("#ohdTWILangEdit").val();
        var tUsrBchCode = $("#ohdTWIBchCode").val();
        var tUsrApv = $("#ohdTWISesUsrLogin").val();
        var tDocNo = $("#oetTWIDocNo").val();
        var tPrefix = 'RESTWI';
        var tStaApv = $("#ohdTWIStaApv").val();
        var tStaDelMQ = $("#ohdTWIStaDelMQ").val();
        var tQName = tPrefix + "_" + tDocNo + "_" + tUsrApv;

        // MQ Message Config
        var poDocConfig = {
            tLangCode: tLangCode,
            tUsrBchCode: tUsrBchCode,
            tUsrApv: tUsrApv,
            tDocNo: tDocNo,
            tPrefix: tPrefix,
            tStaDelMQ: tStaDelMQ,
            tStaApv: tStaApv,
            tQName: tQName
        };

        // RabbitMQ STOMP Config
        var poMqConfig = {
            host: "ws://" + oSTOMMQConfig.host + ":15674/ws",
            username: oSTOMMQConfig.user,
            password: oSTOMMQConfig.password,
            vHost: oSTOMMQConfig.vhost
        };

        // Callback Page Control(function)
        var poCallback = {
            tCallPageEdit: 'JSvTWICallPageEdit',
            tCallPageList: 'JSvTRNCallPageTransferReceipt'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TCNTPdtTwiHD",
            ptDocFieldDocNo: "FTXthDocNo",
            ptDocFieldStaApv: "FTXthStaPrcStk",
            ptDocFieldStaDelMQ: "FTXthStaDelMQ",
            ptDocStaDelMQ: "1",
            ptDocNo: tDocNo
        };

        //Check Show Progress %
        FSxCMNRabbitMQMessage(
            poDocConfig,
            poMqConfig,
            poUpdateStaDelQnameParams,
            poCallback
        );
    }

</script>
