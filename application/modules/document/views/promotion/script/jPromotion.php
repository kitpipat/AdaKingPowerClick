<script>
    var nPromotionStaBrowseType = $("#oetPromotionStaBrowse").val();
    var tPromotionCallBackOption = $("#oetPromotionCallBackOption").val();

    $("document").ready(function() {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxPromotionNavDefult();

        if (nPromotionStaBrowseType != 1) {
            JSvPromotionCallPageList();
        } else {
            JSvPromotionCallPageAdd();
        }
    });

    // Control menu bar
    function JSxPromotionNavDefult() {
        if (nPromotionStaBrowseType != 1 || nPromotionStaBrowseType == undefined) {
            $(".xCNPromotionVBrowse").hide();
            $(".xCNPromotionVMaster").show();
            $("#oliPromotionTitleAdd").hide();
            $("#oliPromotionTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $(".obtChoose").hide();
            $("#odvPromotionBtnInfo").show();
            $("#oliPromotionTitleDetail").hide();
        } else {
            $("#odvModalBody .xCNPromotionVMaster").hide();
            $("#odvModalBody .xCNPromotionVBrowse").show();
            $("#odvModalBody #odvPromotionMainMenu").removeClass("main-menu");
            $("#odvModalBody #oliPromotionNavBrowse").css("padding", "2px");
            $("#odvModalBody #odvPromotionBtnGroup").css("padding", "0");
            $("#odvModalBody .xCNPromotionBrowseLine").css("padding", "0px 0px");
            $("#odvModalBody .xCNPromotionBrowseLine").css(
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
    function JSvPromotionCallPageList() {
        $.ajax({
            type: "GET",
            url: "promotionList",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvPromotionContentPage").html(tResult);
                JSxPromotionNavDefult();
                JSvPromotionCallPageDataTable();
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
    function JSvPromotionCallPageDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        var oAdvanceSearch = JSoPromotionGetAdvanceSearchData();
        $.ajax({
            type: "POST",
            url: "promotionDataTable",
            data: {
                oAdvanceSearch: JSON.stringify(oAdvanceSearch),
                nPageCurrent: nPageCurrent
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvPromotionContent").html(tResult);
                JSxPromotionNavDefult();
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
    function JSoPromotionGetAdvanceSearchData() {
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
                    tSearchStaDocAct: $("#ocmStaDocAct").val(),
                    tSearchUsedStatus: $("#ocmUsedStatus").val()
                };
                return oAdvanceSearchData;
            } catch (err) {
                // console.log("JSoPromotionGetAdvanceSearchData Error: ", err);
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
    function JSxPromotionClearSearchData() {
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
                JSvPromotionCallPageDataTable();
            } catch (err) {
                // console.log("JSxPromotionClearSearchData Error: ", err);
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
    function JSvPromotionCallPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "promotionCallPageAdd",
            data: {},
            cache: false,
            timeout: 5000,
            success: function(tResult) {
                nIndexInputEditInlineForVD = 0;
                if (nPromotionStaBrowseType == 1) {
                    $(".xCNPromotionVMaster").hide();
                    $(".xCNPromotionVBrowse").show();
                } else {
                    $(".xCNPromotionVBrowse").hide();
                    $(".xCNPromotionVMaster").show();
                    $("#oliPromotionTitleEdit").hide();
                    $("#oliPromotionTitleAdd").show();
                    $("#odvPromotionBtnInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#obtPromotionApprove").hide();
                    $("#obtPromotionCopy").hide();
                    $("#obtPromotionPrint").hide();
                    $("#obtPromotionCancel").hide();
                    $("#obtPromotionPrint").hide();
                    $("#oliPromotionTitleDetail").hide();
                }

                $("#odvPromotionContentPage").html(tResult);
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
    function JSvPromotionCallPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "promotionCallPageEdit",
                data: {
                    tDocNo: ptDocNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $("#odvBtnAddEdit").show();
                        $(".xCNPromotionVBrowse").hide();
                        $(".xCNPromotionVMaster").show();
                        $("#oliPromotionTitleEdit").show();
                        $("#oliPromotionTitleAdd").hide();
                        $("#odvPromotionBtnInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtPromotionApprove").show();
                        $("#obtPromotionCopy").show();
                        $("#obtPromotionPrint").show();
                        $("#obtPromotionCancel").show();
                        $("#obtPromotionPrint").show();
                        $("#oliPromotionTitleDetail").hide();

                        $("#odvPromotionContentPage").html(tResult);
                        var nPmhStaLimitCst = $("#ohdPmhStaLimitCst").val();
                        if (nPmhStaLimitCst == 1) {
                            $("#ocmPromotionPmhStaLimitCst").val("1").selectpicker("refresh");
                        } else {
                            $("#ocmPromotionPmhStaLimitCst").val("2").selectpicker("refresh");
                        }
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
    function JSxPromotionDocDel(tCurrentPage, tDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            var aData = $("#ohdConfirmIDDelete").val();
            var aTexts = aData.substring(0, aData.length - 2);
            var aDataSplit = aTexts.split(" , ");
            var aDataSplitlength = aDataSplit.length;

            if (aDataSplitlength == "1") {
                $("#odvModalDel").modal("show");
                $("#ospConfirmDelete").html("<?php echo language('document/promotion/promotion','tWarMsg25'); ?> : " + tDocNo);

                $("#osmConfirm").on("click", function(evt) {
                    $("#odvModalDel").modal("hide");
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "promotionDelDoc",
                        data: {
                            tDocNo: tDocNo
                        },
                        cache: false,
                        success: function(tResult) {
                            JSvPromotionCallPageDataTable(tCurrentPage);
                            JSxPromotionNavDefult();
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
    function JSxPromotionDelChoose() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            $("#odvModalDel").modal("hide");
            JCNxOpenLoading();

            var aData = $("#ohdConfirmIDDelete").val();
            var aTexts = aData.substring(0, aData.length - 2);
            // console.log('aTexts: ', aTexts);
            var aDataSplit = aTexts.split(" , ");
            var aDataSplitlength = aDataSplit.length;

            var aDocNo = [];
            for ($i = 0; $i < aDataSplitlength; $i++) {
                aDocNo.push(aDataSplit[$i]);
            }
            // console.log('aDocNo: ', aDocNo);
            if (aDataSplitlength > 1) {
                localStorage.StaDeleteArray = "1";
                $.ajax({
                    type: "POST",
                    url: "promotionDelDocMulti",
                    data: {
                        aDocNo: aDocNo
                    },
                    success: function(tResult) {
                        JSvPromotionCallPageDataTable();
                        JSxPromotionNavDefult();
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

            $("#ospConfirmDelete").text("<?php echo language('document/promotion/promotion', 'tWarMsg26'); ?>");
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
     * Functionality : Click Page for Document List
     * Parameters : -
     * Creator : 04/02/2020 Piya
     * Return : -
     * Return Type : -
     */
    function JSvPromotionDataTableClickPage(ptPage) {
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
        JSvPromotionCallPageDataTable(nPageCurrent);
    }
</script>