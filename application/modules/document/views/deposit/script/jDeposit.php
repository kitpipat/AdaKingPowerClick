<script>
    var nDepositStaBrowseType = $("#oetDepositStaBrowse").val();
    var tDepositCallBackOption = $("#oetDepositCallBackOption").val();

    $("document").ready(function() {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxDepositNavDefult();

        if (nDepositStaBrowseType != 1) {
            JSvDepositCallPageList();
        } else {
            JSvDepositCallPageAdd();
        }
    });

    // Control menu bar
    function JSxDepositNavDefult() {
        if (nDepositStaBrowseType != 1 || nDepositStaBrowseType == undefined) {
            $(".xCNDepositVBrowse").hide();
            $(".xCNDepositVMaster").show();
            $("#oliDepositTitleAdd").hide();
            $("#oliDepositTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $(".obtChoose").hide();
            $("#odvDepositBtnInfo").show();
            $("#oliDepositTitleDetail").hide();
        } else {
            $("#odvModalBody .xCNDepositVMaster").hide();
            $("#odvModalBody .xCNDepositVBrowse").show();
            $("#odvModalBody #odvDepositMainMenu").removeClass("main-menu");
            $("#odvModalBody #oliDepositNavBrowse").css("padding", "2px");
            $("#odvModalBody #odvDepositBtnGroup").css("padding", "0");
            $("#odvModalBody .xCNDepositBrowseLine").css("padding", "0px 0px");
            $("#odvModalBody .xCNDepositBrowseLine").css(
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
    function JSvDepositCallPageList() {
        $.ajax({
            type: "GET",
            url: "depositList",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $("#odvDepositContentPage").html(tResult);
                JSxDepositNavDefult();
                JSvDepositCallPageDataTable();
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
    function JSvDepositCallPageDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = JSoDepositGetAdvanceSearchData();
        $.ajax({
            type: "POST",
            url: "depositDataTable",
            data: {
                oAdvanceSearch: JSON.stringify(oAdvanceSearch),
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $("#odvDepositContent").html(tResult);
                JSxDepositNavDefult();
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
    function JSoDepositGetAdvanceSearchData() {
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
                    tSearchStaPrcStk: $("#ocmStaPrcStk").val(),
                    tSearchStaDocAct:$("#ocmStaDocAct").val(),
                };
                return oAdvanceSearchData;
            } catch (err) {
                console.log("JSoDepositGetAdvanceSearchData Error: ", err);
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
    function JSxDepositClearSearchData() {
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
                JSvDepositCallPageDataTable();
            } catch (err) {
                console.log("JSxDepositClearSearchData Error: ", err);
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
    function JSvDepositCallPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "depositCallPageAdd",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                nIndexInputEditInlineForVD = 0;
                if (nDepositStaBrowseType == 1) {
                    $(".xCNDepositVMaster").hide();
                    $(".xCNDepositVBrowse").show();
                } else {
                    $(".xCNDepositVBrowse").hide();
                    $(".xCNDepositVMaster").show();
                    $("#oliDepositTitleEdit").hide();
                    $("#oliDepositTitleAdd").show();
                    $("#odvDepositBtnInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#obtDepositApprove").hide();
                    $("#obtDepositPrint").hide();
                    $("#obtDepositCancel").hide();
                    $("#obtDepositPrint").hide();
                    $("#oliDepositTitleDetail").hide();
                }

                $("#odvDepositContentPage").html(tResult);
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
    function JSvDepositCallPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "depositCallPageEdit",
                data: {
                    tDocNo: ptDocNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $("#odvBtnAddEdit").show();
                        $(".xCNDepositVBrowse").hide();
                        $(".xCNDepositVMaster").show();
                        $("#oliDepositTitleEdit").show();
                        $("#oliDepositTitleAdd").hide();
                        $("#odvDepositBtnInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtDepositApprove").show();
                        $("#obtDepositPrint").show();
                        $("#obtDepositCancel").show();
                        $("#obtDepositPrint").show();
                        $("#oliDepositTitleDetail").hide();

                        $("#odvDepositContentPage").html(tResult);
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
    function JSxDepositDocDel(tCurrentPage, tDocNo) {
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
                        url: "depositDelDoc",
                        data: {
                            tDocNo: tDocNo
                        },
                        cache: false,
                        success: function(tResult) {
                            JSvDepositCallPageDataTable(tCurrentPage);
                            JSxDepositNavDefult();
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
    function JSxDepositDelChoose() {
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
                    url: "depositDelDocMulti",
                    data: {
                        aDocNo: aDocNo
                    },
                    success: function(tResult) {
                        JSvDepositCallPageDataTable();
                        JSxDepositNavDefult();
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
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
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
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
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
    function JSvDepositDataTableClickPage(ptPage) {
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
        JSvDepositCallPageDataTable(nPageCurrent);
    }
</script>