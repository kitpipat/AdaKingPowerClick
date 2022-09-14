<script>
    var nStaTBIBrowseType = $('#oetTBIStaBrowse').val();
    var tCallTBIBackOption = $('#oetTBICallBackOption').val();

    $('document').ready(function() {
        localStorage.removeItem('LocalItemData');
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxTBINavDefult();
        if (typeof(nStaTBIBrowseType) != 'undefined' && (nStaTBIBrowseType == 0 || nStaTBIBrowseType==2 )) {
            // JSvTBICallPageTransferReceipt();
            $('#oliTBITitle').unbind().click(function() {
                localStorage.tCheckBackStage = '';
                var nStaSession = JCNxFuncChkSessionExpired();
                if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                    JSvTBICallPageTransferReceipt();
                } else {
                    JCNxShowMsgSessionExpired();
                }
            }); 

            $('#obtTBICallBackPage').unbind().click(function() {
                var nStaSession = JCNxFuncChkSessionExpired();
                if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                    //กดปุ่มย้อนกลับ ถ้ามาจาก "หน้าจอจัดการใบสั่งสินค้าจากสาขา" เวลาย้อนกลับต้องกลับไปหน้าจอเดิม
                    if (localStorage.tCheckBackStage != '') {
                        if(localStorage.tCheckBackStage == 'PageMangeDocOrderBCH'){
                            var tRoute = 'docMngDocPreOrdB/0/0';
                        }else if(localStorage.tCheckBackStage = 'monDocTransfer'){
                            var tRoute = 'monSDT/1/0';
                        }
                        JSxBackStageToMangeDocOrderBCH(tRoute);
                    }else{ //กลับสู่หน้า List
                        JSvTBICallPageTransferReceipt();
                    }
                } else {
                    JCNxShowMsgSessionExpired();
                }
            });

            switch(nStaTBIBrowseType){
                case '2':
                    var tAgnCode = $('#oetTBIJumpAgnCode').val();
                    var tBchCode = $('#oetTBIJumpBchCode').val();
                    var tDocNo = $('#oetTBIJumpDocNo').val();
                    JSvTBICallPageEdit(tDocNo);
                break;
                default:
                    JSvTBICallPageTransferReceipt();
            }
        }
    });

    //กดปุ่มย้อนกลับ ถ้ามาจาก "หน้าจอจัดการใบสั่งสินค้าจากสาขา" เวลาย้อนกลับต้องกลับไปหน้าจอเดิม
    function JSxBackStageToMangeDocOrderBCH(ptRoute){
        $.ajax({
            type    : "GET",
            url     : ptRoute,
            cache   : false,
            timeout : 5000,
            success : function (tResult) {
                $(window).scrollTop(0);
                $('.odvMainContent').html(tResult);

                //เก็บเอาไว้ว่า มาจากหน้าจอจัดการใบสั่งสินค้าจากสาขา
                localStorage.tCheckBackStage = '';
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }


    //ซ่อนปุ่มต่างๆ
    function JSxTBINavDefult() {
        try {
            $('.xCNTBIMaster').show();
            $('#oliTBITitleAdd').hide();
            $('#oliTBITitleEdit').hide();
            $('#odvBtnAddEdit').hide();
            $('#odvBtnTBIInfo').show();
        } catch (err) {
            console.log('JSxCardShiftTopUpCardShiftTopUpNavDefult Error: ', err);
        }
    }

    //Page - List
    function JSvTBICallPageTransferReceipt() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                $('#oetSearchAll').val('');
                $.ajax({
                    type: "POST",
                    url: "docTBIPageList",
                    cache: false,
                    timeout: 0,
                    success: function(tResult) {
                        $('#odvContentTransferReceipt').html(tResult);
                        JSvTBICallPageTransferReceiptDataTable();
                        localStorage.tCheckBackStage = '';
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTBIResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvTBICallPageTransferReceipt Error: ', err);
        }
    }

    //Page - Datatable
    function JSvTBICallPageTransferReceiptDataTable(pnPage) {
        JCNxOpenLoading();
        var oAdvanceSearch = JSoTBIGetAdvanceSearchData();
        var nTBIDocType = $('#ohdTBIDocType').val();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        // JCNxCloseLoading();
        $.ajax({
            type: "POST",
            url: "docTBIPageDataTable",
            data: {
                oAdvanceSearch: oAdvanceSearch,
                nTBIDocType: nTBIDocType,
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                if (aReturnData['nStaEvent'] == '1') {
                    JSxTBINavDefult();
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
    function JSvTBITransferReceiptAdd() {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docTBIPageAdd",
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('.xCNTBIMaster').show();
                            $('#oliTBITitleEdit').hide();
                            $('#oliTBITitleAdd').show();
                            $('#odvBtnTBIInfo').hide();
                            $('#odvBtnAddEdit').show();
                            JSxControlBTN('PAGEADD');
                            $('#odvContentTransferReceipt').html(aReturnData['tViewPageAdd']);
                            JCNxLayoutControll();
                            JCNxCloseLoading();

                            //Load PDT - TABLE
                            JSvTBILoadPdtDataTableHtml();
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTBIResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvTBITransferReceiptAdd Error: ', err);
        }
    }

    //Page - Edit
    function JSvTBICallPageEdit(ptDocNumber) {
        try {
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== 'undefined' && nStaSession == 1) {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docTBIPageEdit",
                    data: {
                        ptDocNumber: ptDocNumber,
                        ptTBIDocType: $('#ohdTBIDocType').val()
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('.xCNTBIMaster').show();
                            $('#oliTBITitleEdit').show();
                            $('#oliTBITitleAdd').hide();
                            $('#odvBtnTBIInfo').hide();
                            $('#odvBtnAddEdit').show();
                            // JSxControlBTN('PAGEEDIT');
                            $('#odvContentTransferReceipt').html(aReturnData['tViewPageAdd']);
                            JCNxLayoutControll();
                            // JCNxCloseLoading();

                            //Load PDT - TABLE
                            JSvTBILoadPdtDataTableHtml();
                        } else {
                            var tMessageError = aReturnData['tStaMessg'];
                            FSvCMNSetMsgErrorDialog(tMessageError);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxTBIResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                JCNxShowMsgSessionExpired();
            }
        } catch (err) {
            console.log('JSvTBICallPageEdit Error: ', err);
        }
    }

    //Control ปุ่ม
    function JSxControlBTN(ptTypeEvent) {
        if (ptTypeEvent == 'PAGEADD') {
            $('#obtTBIPrintDoc').hide();
            $('#obtTBICancelDoc').hide();
            $('#obtTBIApproveDoc').hide();
        }
    }

    //Page - Product Table
    function JSvTBILoadPdtDataTableHtml(pnPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            if ($("#ohdTBIRoute").val() == "docTBIEventAdd") {
                var tTBIDocNo = "";
            } else {
                var tTBIDocNo = $("#oetTBIDocNo").val();
            }

            var tTBIStaApv = $("#ohdTBIStaApv").val();
            var tTBIStaDoc = $("#ohdTBIStaDoc").val();

            if (pnPage == '' || pnPage == null) {
                var pnNewPage = 1;
            } else {
                var pnNewPage = pnPage;
            }
            var nPageCurrent = pnNewPage;
            var tSearchPdtAdvTable = $('#oetTBIFrmFilterPdtHTML').val();

            $.ajax({
                type: "POST",
                url: "docTBIPagePdtAdvanceTableLoadData",
                data: {
                    'ptSearchPdtAdvTable': tSearchPdtAdvTable,
                    'ptTBIDocNo': tTBIDocNo,
                    'ptTBIStaApv': tTBIStaApv,
                    'ptTBIStaDoc': tTBIStaDoc,
                    'pnTBIPageCurrent': nPageCurrent,
                    'ptTBIBchCode': $('#oetTBIBchCode').val()
                },
                cache: false,
                Timeout: 0,
                success: function(oResult) {
                    localStorage.removeItem('TBI_LocalItemDataDelDtTemp');
                    var aReturnData = JSON.parse(oResult);
                    if (aReturnData['nStaEvent'] == '1') {
                        $('#odvTBIDataPdtTableDTTemp').html(aReturnData['tTBIPdtAdvTableHtml']);
                        var aTBIEndOfBill = aReturnData['aTBIEndOfBill'];
                        // JSxTBISetFooterEndOfBill(aTBIEndOfBill);
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
    function JCNxTBIResponseError(jqXHR, textStatus, errorThrown) {
        try {
            JCNxResponseError(jqXHR, textStatus, errorThrown)
        } catch (err) {
            console.log('JCNxTBIResponseError Error: ', err);
        }
    }

    //ฟังก์ชั่น get ค่า INPUT Search
    function JSoTBIGetAdvanceSearchData() {
        var oAdvanceSearchData = {
            tSearchAll: $("#oetSearchAll").val(),
            tSearchBchCodeFrom: $("#oetASTBchCodeFrom").val(),
            tSearchBchCodeTo: $("#oetASTBchCodeTo").val(),
            tSearchDocDateFrom: $("#oetASTDocDateFrom").val(),
            tSearchDocDateTo: $("#oetASTDocDateTo").val(),
            tSearchStaDoc: $("#ocmASTStaDoc").val(),
            tSearchStaApprove: $("#ocmASTStaApprove").val(),
            tSearchStaDocAct: $("#ocmStaDocAct").val(),
            tSearchStaPrcStk: $("#ocmASTStaPrcStk").val()
        };
        return oAdvanceSearchData;
    }

    //ฟังก์ชั่นล้างค่า Input Advance Search
    function JSxTBIClearSearchData() {
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
            JSvTBICallPageTransferReceiptDataTable();
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //เปลี่ยนหน้า 1 2 3 ..
    function JSvTBIClickPage(ptPage) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var nPageCurrent = "";
            switch (ptPage) {
                case "next": //กดปุ่ม Next
                    $(".xWBtnNext").addClass("disabled");
                    nPageOld = $(".xWPageTBIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                case "previous": //กดปุ่ม Previous
                    nPageOld = $(".xWPageTBIPdt .active").text(); // Get เลขก่อนหน้า
                    nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                    nPageCurrent = nPageNew;
                    break;
                default:
                    nPageCurrent = ptPage;
            }
            JSvTBICallPageTransferReceiptDataTable(nPageCurrent);
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //ลบ HD - ตัวเดียว
    function JSoTBIDelDocSingle(ptCurrentPage, ptTBIDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            $('#odvTBIModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val() + ptTBIDocNo);
            $('#odvTBIModalDelDocSingle').modal('show');
            $('#odvTBIModalDelDocSingle #osmTBIConfirmPdtDTTemp ').unbind().click(function() {
                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docTBIEventDelete",
                    data: {
                        'tTBIDocNo': ptTBIDocNo
                    },
                    cache: false,
                    timeout: 0,
                    success: function(oResult) {
                        var aReturnData = JSON.parse(oResult);
                        if (aReturnData['nStaEvent'] == '1') {
                            $('#odvTBIModalDelDocSingle').modal('hide');
                            $('#odvTBIModalDelDocSingle #ospTextConfirmDelSingle').html($('#oetTextComfirmDeleteSingle').val());
                            $('.modal-backdrop').remove();
                            setTimeout(function() {
                                JSvTBICallPageTransferReceipt();
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

    // //ลบ HD - หลายตัว
    // function JSoTBIDelDocMultiple(){
    //     var nStaSession = JCNxFuncChkSessionExpired();
    //     if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
    //         var aDataDelMultiple    = $('#odvTBIModalDelDocMultiple #ohdConfirmIDDelMultiple').val();
    //         var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
    //         var aDataSplit          = aTextsDelMultiple.split(" , ");
    //         var nDataSplitlength    = aDataSplit.length;
    //         var aNewIdDelete        = [];

    //         for($i = 0; $i < nDataSplitlength; $i++){
    //             aNewIdDelete.push(aDataSplit[$i]);
    //         }
    //         if(nDataSplitlength > 1){
    //             JCNxOpenLoading();
    //             localStorage.StaDeleteArray = '1';
    //             $.ajax({
    //                 type    : "POST",
    //                 url     : "docTBIEventDelete",
    //                 data    : {'tTBIDocNo': aNewIdDelete},
    //                 cache: false,
    //                 timeout: 0,
    //                 success: function(oResult) {
    //                     var aReturnData = JSON.parse(oResult);
    //                     if(aReturnData['nStaEvent'] == '1'){
    //                         $('#odvTBIModalDelDocMultiple').modal('hide');
    //                         $('#odvTBIModalDelDocMultiple #ospTextConfirmDelMultiple').empty();
    //                         $('#odvTBIModalDelDocMultiple #ohdConfirmIDDelMultiple').val('');
    //                         $('.modal-backdrop').remove();
    //                         localStorage.removeItem('LocalItemData');
    //                         setTimeout(function () {
    //                             JSvTBICallPageTransferReceipt();
    //                         }, 500);
    //                     }else{
    //                         JCNxCloseLoading();
    //                         FSvCMNSetMsgErrorDialog(aReturnData['tStaMessg']);
    //                     }
    //                 },
    //                 error: function (jqXHR, textStatus, errorThrown) {
    //                     JCNxResponseError(jqXHR, textStatus, errorThrown);
    //                 }
    //             });
    //         }
    //     }else{
    //         JCNxShowMsgSessionExpired();
    //     }
    // }

    //ยกเลิกเอกสาร
    function JSxTBITransferReceiptDocCancel(pbIsConfirm) {
        tTBIDocNo = $("#oetTBIDocNo").val();
        var tBIBchCode = $('#oetTBIBchCode').val();
        if (pbIsConfirm) {
            $.ajax({
                type: "POST",
                url: "docTBIEventCencel",
                data: {
                    tTBIDocNo: tTBIDocNo,
                    tBIBchCode: tBIBchCode
                },
                cache: false,
                timeout: 5000,
                success: function(tResult) {
                    $("#odvTBIPopupCancel").modal("hide");
                    aResult = $.parseJSON(tResult);
                    if (aResult.nSta == 1) {
                        JSvTBICallPageEdit(tTBIDocNo);
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
            $("#odvTBIPopupCancel").modal("show");
        }
    }

    //อนุมัติเอกสาร
    function JSxTBITransferReceiptStaApvDoc(pbIsConfirm) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                if (pbIsConfirm) {
                    $("#ohdTBIStaPrcStk").val(2); // Set status for processing approve
                    $('#odvTBIModalAppoveDoc').modal("hide");

                    var tXthDocNo = $("#oetTBIDocNo").val();
                    var tXthStaApv = $("#ohdTBIStaApv").val();

                    $.ajax({
                        type: "POST",
                        url: "docTBIEventApproved",
                        data: {
                            tXthDocNo: tXthDocNo,
                            tXthStaApv: tXthStaApv,
                            tXthDocType: $('#ohdTBIFrmDocType').val(),
                            tXthBchCode: $('#oetTBIBchCode').val()
                        },
                        cache: false,
                        timeout: 0,
                        success: function(tResult) {
                            if (tResult.nStaEvent == "900") {
                                FSvCMNSetMsgErrorDialog(tResult.tStaMessg);
                                JCNxCloseLoading();
                                return;
                            }
                            JSoTBISubscribeMQ();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                } else {
                    $('#odvTBIModalAppoveDoc').modal("show");
                }
            } catch (err) {
                console.log("JSnTFWApprove Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    //อนุมัติเอกสาร
    function JSoTBISubscribeMQ() {
        var tLangCode = $("#ohdTBILangEdit").val();
        var tUsrBchCode = $("#oetTBIBchCode").val();
        var tUsrApv = $("#ohdTBIApvCodeUsrLogin").val();
        var tDocNo = $("#oetTBIDocNo").val();
        var tPrefix = 'RESTBI';
        var tStaApv = $("#ohdTBIStaApv").val();
        var tStaDelMQ = $("#ohdTBIStaDelMQ").val();
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
            tCallPageEdit: 'JSvTBICallPageEdit',
            tCallPageList: 'JSvTBICallPageTransferReceipt'
        };

        // Update Status For Delete Qname Parameter
        var poUpdateStaDelQnameParams = {
            ptDocTableName: "TCNTPdtTbiHD",
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
    /**
     * Functionality : Function Chack Value LocalStorage
     * Parameters : array, key, value
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function findObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }
    /**
     * Functionality : Function Chack And Show Button Delete All
     * Parameters : LocalStorage Data
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalTransferBchOutHDItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#oliBtnDeleteAll").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#oliBtnDeleteAll").removeClass("disabled");
            } else {
                $("#oliBtnDeleteAll").addClass("disabled");
            }
        }
    }
</script>
