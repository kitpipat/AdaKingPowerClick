<script>
    var nTransferBchOutStaBrowseType = $("#oetTransferBchOutStaBrowse").val();
    var tTransferBchOutCallBackOption = $("#oetTransferBchOutCallBackOption").val();

    $("document").ready(function() {
        localStorage.tCheckBackStage = '';
        localStorage.removeItem("LocalTransferBchOutHDItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxTransferBchOutNavDefult();
        $('#oliTransferBchOutTitle').unbind().click(function() {
            localStorage.tCheckBackStage = '';
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvTransferBchOutCallPageList();
            } else {
                JCNxShowMsgSessionExpired();
            }
        });

        if (nTransferBchOutStaBrowseType != 1) {
            // JSvTransferBchOutCallPageList();
            switch(nTransferBchOutStaBrowseType){
            case '2':
                var tAgnCode = $('#oetTransferBchOutJumpAgnCode').val();
                var tBchCode = $('#oetTransferBchOutJumpBchCode').val();
                var tDocNo = $('#oetTransferBchOutJumpDocNo').val();
                JSvTransferBchOutCallPageEdit(tDocNo);
            break;
            default:
                JSvTransferBchOutCallPageList();
        }
        } else {
            JSvTransferBchOutCallPageAdd();
        }
    });

    // Control menu bar
    function JSxTransferBchOutNavDefult() {
        if (nTransferBchOutStaBrowseType != 1 || nTransferBchOutStaBrowseType == undefined) {
            $(".xCNTransferBchOutVBrowse").hide();
            $(".xCNTransferBchOutVMaster").show();
            $("#oliTransferBchOutTitleAdd").hide();
            $("#oliTransferBchOutTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $(".obtChoose").hide();
            $("#odvTransferBchOutBtnInfo").show();
            $("#oliTransferBchOutTitleDetail").hide();
        } else {
            $("#odvModalBody .xCNTransferBchOutVMaster").hide();
            $("#odvModalBody .xCNTransferBchOutVBrowse").show();
            $("#odvModalBody #odvTransferBchOutMainMenu").removeClass("main-menu");
            $("#odvModalBody #oliTransferBchOutNavBrowse").css("padding", "2px");
            $("#odvModalBody #odvTransferBchOutBtnGroup").css("padding", "0");
            $("#odvModalBody .xCNTransferBchOutBrowseLine").css("padding", "0px 0px");
            $("#odvModalBody .xCNTransferBchOutBrowseLine").css(
                "border-bottom",
                "1px solid #e3e3e3"
            );
        }
    }

    /**
     * Functionality : เรียกหน้าแรก(รายการเอกสาร)
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Main Page
     * Return Type : View
     */
    function JSvTransferBchOutCallPageList() {
        if(localStorage.tCheckBackStage = 'monDocTransfer' && localStorage.tCheckBackStage != ''){
            var tRoute = 'monSDT/1/0';
        }else{
            var tRoute = 'docTransferBchOutList';
        }


        //กลับสู่หน้า List
        $.ajax({
            type: "GET",
            url: tRoute,
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                if (tRoute == 'monSDT/1/0') {
                    $(window).scrollTop(0);
                    $('.odvMainContent').html(tResult);
                } else {
                    $("#odvTransferBchOutContentPage").html(tResult);
                    JSxTransferBchOutNavDefult();
                    JSvTransferBchOutCallPageDataTable();
                }
                localStorage.tCheckBackStage = '';
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });

    }

    /**
     * Functionality : เรียกตารางรายการเอกสาร
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Table List
     * Return Type : View
     */
    function JSvTransferBchOutCallPageDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = JSoTransferBchOutGetAdvanceSearchData();
        $.ajax({
            type: "POST",
            url: "docTransferBchOutDataTable",
            data: {
                oAdvanceSearch: JSON.stringify(oAdvanceSearch),
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $("#odvTransferBchOutContent").html(tResult);
                JSxTransferBchOutNavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : ค้นหาขั้นสูง
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSoTransferBchOutGetAdvanceSearchData() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                let oAdvanceSearchData = {
                    tSearchAll: $("#oetSearchAll").val(),
                    tSearchBchCodeFrom: $("#oetBchCodeFrom").val(),
                    tSearchBchCodeTo: $("#oetBchCodeTo").val(),
                    tSearchDocDateFrom: $("#oetSearchDocDateFrom").val(),
                    tSearchDocDateTo: $("#oetSearchDocDateTo").val(),
                    tSearchStaDoc: $("#ocmStaDoc").val(),
                    tSearchStaApprove: $("#ocmStaApprove").val(),
                    tSearchStaDocAct: $("#ocmStaDocAct").val(),
                    tSearchStaPrcStk: $("#ocmStaPrcStk").val()
                };
                return oAdvanceSearchData;
            } catch (err) {
                console.log("JSoTransferBchOutGetAdvanceSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : ล้างข้อมูลค้นหาขั้นสูง
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutClearSearchData() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                var nCountBch = "<?=$this->session->userdata("nSesUsrBchCount"); ?>";
                if(nCountBch != 1){ //ถ้ามีมากกว่า 1 สาขาต้อง reset
                    $("#oetBchCodeFrom").val("");
                    $("#oetBchNameFrom").val("");
                    $("#oetBchCodeTo").val("");
                    $("#oetBchNameTo").val("");
                }

                $("#oetSearchAll").val("");
                $("#oetSearchDocDateFrom").val("");
                $("#oetSearchDocDateTo").val("");
                $(".xCNDatePicker").datepicker("setDate", null);
                $(".selectpicker").val("0").selectpicker("refresh");
                JSvTransferBchOutCallPageDataTable();
            } catch (err) {
                console.log("JSxTransferBchOutClearSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : หน้าจอเพิ่มเอกสาร
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Add Page
     * Return Type : View
     */
    function JSvTransferBchOutCallPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTransferBchOutCallPageAdd",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                nIndexInputEditInlineForVD = 0;
                if (nTransferBchOutStaBrowseType == 1) {
                    $(".xCNTransferBchOutVMaster").hide();
                    $(".xCNTransferBchOutVBrowse").show();
                } else {
                    $(".xCNTransferBchOutVBrowse").hide();
                    $(".xCNTransferBchOutVMaster").show();
                    $("#oliTransferBchOutTitleEdit").hide();
                    $("#oliTransferBchOutTitleAdd").show();
                    $("#odvTransferBchOutBtnInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#obtTransferBchOutApprove").hide();
                    $("#obtTransferBchOutPrint").hide();
                    $("#obtTransferBchOutCancel").hide();
                    $("#obtTransferBchOutPrint").hide();
                    $("#oliTransferBchOutTitleDetail").hide();
                }

                $("#odvTransferBchOutContentPage").html(tResult);
                $(window).scrollTop(0);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : เรียกหน้าแก้ไข
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Edit Page
     * Return Type : View
     */
    function JSvTransferBchOutCallPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "docTransferBchOutCallPageEdit",
                data: {
                    tDocNo: ptDocNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $(".xCNTransferBchOutVBrowse").hide();
                        $(".xCNTransferBchOutVMaster").show();
                        $("#oliTransferBchOutTitleEdit").show();
                        $("#oliTransferBchOutTitleAdd").hide();
                        $("#odvTransferBchOutBtnInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtTransferBchOutApprove").show();
                        $("#obtTransferBchOutPrint").show();
                        $("#obtTransferBchOutCancel").show();
                        $("#oliTransferBchOutTitleDetail").hide();
                        $("#odvTransferBchOutContentPage").html(tResult);

                        $(window).scrollTop(0);
                    }

                    JCNxLayoutControll();
                    JCNxCloseLoading();
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
     * Functionality : Delete Doc
     * Parameters : tCurrentPage, tDocNo
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutDocDel(tCurrentPage, tDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var aData = $("#ohdConfirmIDDelete").val();
            var aTexts = aData.substring(0, aData.length - 2);
            var aDataSplit = aTexts.split(" , ");
            var aDataSplitlength = aDataSplit.length;

            if (aDataSplitlength == "1") {
                $("#odvModalDel").modal("show");
                $("#ospConfirmDelete").html("ยืนยันการลบข้อมูล หมายเลข : " + tDocNo);

                $("#osmConfirm").on("click", function(evt) {
                    $("#odvModalDel").modal("hide");
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "docTransferBchOutDelDoc",
                        data: {
                            tDocNo: tDocNo
                        },
                        cache: false,
                        success: function(tResult) {
                            JSvTransferBchOutCallPageDataTable(tCurrentPage);
                            JSxTransferBchOutNavDefult();
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                });
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Multi Delete Doc
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTransferBchOutDelChoose() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").modal("hide");
            JCNxOpenLoading();

            var aData = $("#ohdConfirmIDDelete").val();
            var aTexts = aData.substring(0, aData.length - 2);
            console.log('aTexts: ', aTexts);
            var aDataSplit = aTexts.split(" , ");
            var aDataSplitlength = aDataSplit.length;

            var aDocNo = [];
            for ($i = 0; $i < aDataSplitlength; $i++) {
                aDocNo.push(aDataSplit[$i]);
            }
            console.log('aDocNo: ', aDocNo);
            if (aDataSplitlength > 1) {
                localStorage.StaDeleteArray = "1";
                $.ajax({
                    type: "POST",
                    url: "docTransferBchOutDelDocMulti",
                    data: {
                        aDocNo: aDocNo
                    },
                    success: function(tResult) {
                        JSvTransferBchOutCallPageDataTable();
                        JSxTransferBchOutNavDefult();
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            } else {
                localStorage.StaDeleteArray = "0";
                return false;
            }

        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : Insert Text In Modal Delete
     * Parameters : LocalStorage Data
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTextinModal() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalTransferBchOutHDItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {} else {
            var tTextCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += " , ";
            }
            //Disabled ปุ่ม Delete
            if (aArrayConvert[0].length > 1) {
                $(".xCNIconDel").addClass("xCNDisabled");
            } else {
                $(".xCNIconDel").removeClass("xCNDisabled");
            }

            $("#ospConfirmDelete").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
            $("#ohdConfirmIDDelete").val(tTextCode);
        }
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
     * Functionality : Click Page for Documet List
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvTransferBchOutDataTableClickPage(ptPage) {
        var nPageCurrent = "";
        switch (ptPage) {
            case "next": //กดปุ่ม Next
                $(".xWBtnNext").addClass("disabled");
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
                nPageCurrent = nPageNew;
                break;
            case "previous": //กดปุ่ม Previous
                nPageOld = $(".xWPage .active").text(); // Get เลขก่อนหน้า
                nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
                nPageCurrent = nPageNew;
                break;
            default:
                nPageCurrent = ptPage;
        }
        JSvTransferBchOutCallPageDataTable(nPageCurrent);
    }
</script>
