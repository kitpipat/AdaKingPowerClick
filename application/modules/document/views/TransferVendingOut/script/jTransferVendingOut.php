<script>
    var nStaTVOBrowseType   = $("#oetTVOStaBrowse").val();
    var tCallTVOBackOption  = $("#oetTVOCallBackOption").val();

    $("document").ready(function() {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxTVONavDefult();

        if (nStaTVOBrowseType != 1) {
            JSxTVOPageList();
        } else {
            JSxTVOPageAdd();
        }
    });

    // Control menu bar
    function JSxTVONavDefult() {
        if (nStaTVOBrowseType != 1 || nStaTVOBrowseType == undefined) {
            $(".xCNTVOVBrowse").hide();
            $(".xCNTVOVMaster").show();
            $("#oliTVOTitleAdd").hide();
            $("#oliTVOTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $(".obtChoose").hide();
            $("#odvBtnTVOInfo").show();
            $("#oliPITitleDetail").hide();
        } else {
            $("#odvModalBody .xCNTVOVMaster").hide();
            $("#odvModalBody .xCNTVOVBrowse").show();
            $("#odvModalBody #odvTVOMainMenu").removeClass("main-menu");
            $("#odvModalBody #oliTVONavBrowse").css("padding", "2px");
            $("#odvModalBody #odvTVOBtnGroup").css("padding", "0");
            $("#odvModalBody .xCNTVOBrowseLine").css("padding", "0px 0px");
            $("#odvModalBody .xCNTVOBrowseLine").css(
                "border-bottom",
                "1px solid #e3e3e3"
            );
        }
    }

    /**
     * Functionality : เรียกหน้าแรก(รายการเอกสาร)
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Return : Main Page
     * Return Type : View
     */
    function JSxTVOPageList() {
        $.ajax({
            type: "GET",
            url: "docTVOPageList",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                $("#odvTVOContentPage").html(tResult);
                JSxTVONavDefult();
                JSxTVOPageDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : เรียกตารางรายการเอกสาร
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Return : Table List
     * Return Type : View
     */
    function JSxTVOPageDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = JSoTVOGetAdvanceSearchData();
        $.ajax({
            type: "POST",
            url: "docTVOPageDataTable",
            data: {
                oAdvanceSearch  : JSON.stringify(oAdvanceSearch),
                nPageCurrent    : nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvTVOContentPageList").html(tResult);
                JSxTVONavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : Click Page for Documet List
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxTVODataTableClickPage(ptPage) {
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
        JSxTVOPageDataTable(nPageCurrent);
    }

    /**
     * Functionality : ค้นหาขั้นสูง
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSoTVOGetAdvanceSearchData() {
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
                console.log("JSoTVOGetAdvanceSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : ค้นหาขั้นสูง - เคลียร์ข้อมูลออก
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxTVOClearSearchData() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                $("#oetSearchAll").val("");
                $("#oetBchCodeFrom").val("");
                $("#oetBchNameFrom").val("");
                $("#oetBchCodeTo").val("");
                $("#oetBchNameTo").val("");
                $("#oetSearchDocDateFrom").val("");
                $("#oetSearchDocDateTo").val("");
                $(".xCNDatePicker").datepicker("setDate", null);
                $(".selectpicker").val("0").selectpicker("refresh");
                JSxTVOPageDataTable();
            } catch (err) {
                console.log("JSxTVOClearSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : หน้าจอเพิ่ม
     * Parameters : -
     * Creator : 03/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxTVOPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docTVOPageAdd",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                nIndexInputEditInlineForVD = 0;
                if (nStaTVOBrowseType == 1) {
                    $(".xCNTVOVMaster").hide();
                    $(".xCNTVOVBrowse").show();
                } else {
                    $(".xCNTVOVBrowse").hide();
                    $(".xCNTVOVMaster").show();
                    $("#oliTVOTitleEdit").hide();
                    $("#oliTVOTitleAdd").show();
                    $("#odvBtnTVOInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#obtTVOApprove").hide();
                    $("#obtTVOPrint").hide();
                    $("#obtTVOCancel").hide();
                    $("#obtTVOVDPrint").hide();
                    $("#oliPITitleDetail").hide();
                }

                $("#odvTVOContentPage").html(tResult);
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
     * Creator : 09/09/2020 Napat(Jame)
     * Return : Edit Page
     * Return Type : View
     */
    function JSvTVOCallPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            $.ajax({
                type: "POST",
                url: "docTVOPageEdit",
                data: {
                    tDocNo: ptDocNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $("#odvBtnAddEdit").show();
                        $(".xCNTVOVBrowse").hide();
                        $(".xCNTVOVMaster").show();
                        $("#oliTVOTitleEdit").show();
                        $("#oliTVOTitleAdd").hide();
                        $("#odvBtnTVOInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtTVOApprove").show();
                        $("#obtTVOPrint").show();
                        $("#obtTVOCancel").show();
                        $("#obtTVOVDPrint").show();
                        $("#oliPITitleDetail").hide();

                        $("#odvTVOContentPage").html(tResult);
                    }

                    // Control Object And Button ปิด เปิด
                    // JCNxCreditNoteControlObjAndBtn();
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
     * Creator : 10/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxTVODel(tCurrentPage, tDocNo) {
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
                        url: "TopupVendingDelDoc",
                        data: {
                            tDocNo: tDocNo
                        },
                        cache: false,
                        success: function(tResult) {
                            JSxTVOPageDataTable(tCurrentPage);
                            JSxTVONavDefult();
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
     * Creator : 10/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxTVODelChoose() {
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
                    url: "TopupVendingDelDocMulti",
                    data: {
                        aDocNo: aDocNo
                    },
                    success: function(tResult) {
                        JSxTVOPageDataTable();
                        JSxTVONavDefult();
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
     * Creator : 10/09/2020 Napat(Jame)
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
     * Creator : 10/09/2020 Napat(Jame)
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
     * Creator : 10/09/2020 Napat(Jame)
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
</script>