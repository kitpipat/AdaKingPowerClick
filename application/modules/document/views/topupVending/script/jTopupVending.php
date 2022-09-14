<script>
    var nStaTFWBrowseType = $("#oetTFWStaBrowse").val();
    var tCallTFWBackOption = $("#oetTFWCallBackOption").val();

    $("document").ready(function() {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxTopUpVendingNavDefult();

        if (nStaTFWBrowseType != 1) {
            JSvTopUpVendingCallPageList();
        } else {
            JSvTopUpVendingCallPageAdd();
        }
    });

    // Control menu bar
    function JSxTopUpVendingNavDefult() {
        if (nStaTFWBrowseType != 1 || nStaTFWBrowseType == undefined) {
            $(".xCNTFWVBrowse").hide();
            $(".xCNTFWVMaster").show();
            $("#oliTFWTitleAdd").hide();
            $("#oliTFWTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $(".obtChoose").hide();
            $("#odvBtnTFWInfo").show();
            $("#oliPITitleDetail").hide();
        } else {
            $("#odvModalBody .xCNTFWVMaster").hide();
            $("#odvModalBody .xCNTFWVBrowse").show();
            $("#odvModalBody #odvTFWMainMenu").removeClass("main-menu");
            $("#odvModalBody #oliTFWNavBrowse").css("padding", "2px");
            $("#odvModalBody #odvTFWBtnGroup").css("padding", "0");
            $("#odvModalBody .xCNTFWBrowseLine").css("padding", "0px 0px");
            $("#odvModalBody .xCNTFWBrowseLine").css(
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
    function JSvTopUpVendingCallPageList() {
        $.ajax({
            type: "GET",
            url: "TopupVendingList",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvContentPageTopUpVending").html(tResult);
                JSxTopUpVendingNavDefult();
                JSvTopUpVendingCallPagePdtDataTable();
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
    function JSvTopUpVendingCallPagePdtDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = JSoTopUpVendingGetAdvanceSearchData();
        $.ajax({
            type: "POST",
            url: "TopupVendingDataTable",
            data: {
                oAdvanceSearch: JSON.stringify(oAdvanceSearch),
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvContentTopUpVending").html(tResult);
                JSxTopUpVendingNavDefult();
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
    function JSoTopUpVendingGetAdvanceSearchData() {
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
                    tSearchStaDocAct: $("#ocmStaDocAct").val()
                };
                return oAdvanceSearchData;
            } catch (err) {
                console.log("JSoTopUpVendingGetAdvanceSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    // ค้นหาขั้นสูง - BCH
    function FSvGetSelectShpByBch(ptBchCode) {
        $.ajax({
            type: "POST",
            url: "TWXVDGetShpByBch",
            data: {
                ptBchCode: ptBchCode
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                var tData = $.parseJSON(tResult);
                $("#ostShpCode option").each(function() {
                    if ($(this).val() != "") {
                        $(this).remove();
                    }
                });

                if (tData.raItems != undefined) {
                    for (var i = 0; i < tData.raItems.length; i++) {
                        if (tData.raItems[i].rtShpCode != "") {
                            var data = {
                                id: tData.raItems[i].rtShpCode,
                                text: tData.raItems[i].rtShpName
                            };

                            var newOption = new Option(data.text, data.id, false, false);
                            $("#ostShpCode").append(newOption).trigger("change");
                        }
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : ค้นหาขั้นสูง - เคลียร์ข้อมูลออก
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingClearSearchData() {
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
                JSvTopUpVendingCallPagePdtDataTable();
            } catch (err) {
                console.log("JSxTopUpVendingClearSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : หน้าจอเพิ่ม ใบเติมสินค้า
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : Add Page
     * Return Type : View
     */
    function JSvTopUpVendingCallPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "TopupVendingCallPageAdd",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                nIndexInputEditInlineForVD = 0;
                if (nStaTFWBrowseType == 1) {
                    $(".xCNTFWVMaster").hide();
                    $(".xCNTFWVBrowse").show();
                } else {
                    $(".xCNTFWVBrowse").hide();
                    $(".xCNTFWVMaster").show();
                    $("#oliTFWTitleEdit").hide();
                    $("#oliTFWTitleAdd").show();
                    $("#odvBtnTFWInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#obtTFWApprove").hide();
                    $("#obtTFWCancel").hide();
                    $("#obtTFWVDPrint").hide();
                    $("#oliPITitleDetail").hide();
                }

                $("#odvContentPageTopUpVending").html(tResult);
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
    function JSvTopUpVendingCallPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            // JStCMMGetPanalLangSystemHTML("JSvCallPageCreditNoteEdit", ptDocNo);

            $.ajax({
                type: "POST",
                url: "TopupVendingCallPageEdit",
                data: {
                    tDocNo: ptDocNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $("#odvBtnAddEdit").show();
                        $(".xCNTFWVBrowse").hide();
                        $(".xCNTFWVMaster").show();
                        $("#oliTFWTitleEdit").show();
                        $("#oliTFWTitleAdd").hide();
                        $("#odvBtnTFWInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtTFWApprove").show();
                        $("#obtTFWCancel").show();
                        $("#obtTFWVDPrint").show();
                        $("#oliPITitleDetail").hide();

                        $("#odvContentPageTopUpVending").html(tResult);
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
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSxTopUpVendingDel(tCurrentPage, tDocNo) {
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
                            JSvTopUpVendingCallPagePdtDataTable(tCurrentPage);
                            JSxTopUpVendingNavDefult();
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
    function JSxTopUpVendingDelChoose() {
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
                        JSvTopUpVendingCallPagePdtDataTable();
                        JSxTopUpVendingNavDefult();
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

            $('#ospConfirmDelete').text($('#oetTextComfirmDeleteMulti').val());
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
    function JSvTopUpVendingDataTableClickPage(ptPage) {
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
        JSvTopUpVendingCallPagePdtDataTable(nPageCurrent);
    }


    //จากเอกสารใบเติมสินค้าแบบชุด -> เอกสารใบเติมสินค้า (วันที่ : 23/11/2020)
    function JSxRefillVDToTopUpVendingPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            JCNxOpenLoading();
            JStCMMGetPanalLangSystemHTML("JSvCallPageCreditNoteEdit", ptDocNo);

            $.ajax({
                type    : "POST",
                url     : "TopupVendingCallPageEdit",
                data    : { tDocNo: ptDocNo },
                cache   : false,
                timeout : 0,
                success : function(tResult) {

                    setTimeout(function(){
                        if (tResult != "") {
                            $("#odvBtnAddEdit").show();
                            $(".xCNTFWVBrowse").hide();
                            $(".xCNTFWVMaster").show();
                            $("#oliTFWTitleEdit").show();
                            $("#oliTFWTitleAdd").hide();
                            $("#odvBtnTFWInfo").hide();
                            $("#odvBtnAddEdit").show();
                            $("#obtTFWApprove").show();
                            $("#obtTFWCancel").show();
                            $("#obtTFWVDPrint").show();
                            $("#oliPITitleDetail").hide();

                            $("#odvContentPageTopUpVending").html(tResult);
                        }

                        JCNxLayoutControll();
                        JCNxCloseLoading();
                    }, 1000);
                },
                error   : function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });

        } else {
            JCNxShowMsgSessionExpired();
        }
    }
          
</script>