<script>
    var nPTUStaBrowseType = $("#oetPTUStaBrowse").val();
    var tPTUCallBackOption = $("#oetPTUCallBackOption").val();

    $("document").ready(function() {
        localStorage.removeItem("LocalItemData");
        JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
        JSxPTUNavDefult();

        if (nPTUStaBrowseType != 1) {
            JSvPTUCallPageList();
        } else {
            JSvPTUCallPageAdd();
        }
    });

    // Control menu bar
    function JSxPTUNavDefult() {
        if (nPTUStaBrowseType != 1 || nPTUStaBrowseType == undefined) {
            $(".xCNPTUVBrowse").hide();
            $(".xCNPTUVMaster").show();
            $("#oliPTUTitleAdd").hide();
            $("#oliPTUTitleEdit").hide();
            $("#odvBtnAddEdit").hide();
            $(".obtChoose").hide();
            $("#odvPTUBtnInfo").show();
            $("#oliPTUTitleDetail").hide();
        } else {
            $("#odvModalBody .xCNPTUVMaster").hide();
            $("#odvModalBody .xCNPTUVBrowse").show();
            $("#odvModalBody #odvPTUMainMenu").removeClass("main-menu");
            $("#odvModalBody #oliPTUNavBrowse").css("padding", "2px");
            $("#odvModalBody #odvPTUBtnGroup").css("padding", "0");
            $("#odvModalBody .xCNPTUBrowseLine").css("padding", "0px 0px");
            $("#odvModalBody .xCNPTUBrowseLine").css(
                "border-bottom",
                "1px solid #e3e3e3"
            );
        }
    }

    /**
     * Functionality : เรียกหน้าแรก(รายการเอกสาร)
     * Parameters : -
     * Creator : 17/09/2020 Napat(Jame)
     * Return : Main Page
     * Return Type : View
     */
    function JSvPTUCallPageList() {
        $.ajax({
            type: "POST",
            url: "docPTUPageList",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvPTUContentPage").html(tResult);
                JSxPTUNavDefult();
                JSvPTUCallPageDataTable();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    /**
     * Functionality : เรียกตารางรายการเอกสาร
     * Parameters : -
     * Creator : 17/09/2020 Napat(Jame)
     * Return : Table List
     * Return Type : View
     */
    function JSvPTUCallPageDataTable(pnPage) {
        JCNxOpenLoading();
        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }
        console.log($('#ocmPTUShowStatus').val());
        var oAdvanceSearch = JSoPTUGetAdvanceSearchData();
        $.ajax({
            type: "POST",
            url: "docPTUPageDataTable",
            data: {
                oAdvanceSearch  : JSON.stringify(oAdvanceSearch),
                nPageCurrent    : nPageCurrent,
                tShowStatus     : $('#ocmPTUShowStatus').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResult) {
                $("#odvPTUContent").html(tResult);
                JSxPTUNavDefult();
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
     * Creator : 17/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSoPTUGetAdvanceSearchData() {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            try {
                let oAdvanceSearchData = {
                    tSearchAll          : $("#oetSearchAll").val(),
                    tSearchBchCodeFrom  : $("#oetBchCodeFrom").val(),
                    tSearchBchCodeTo    : $("#oetBchCodeTo").val(),
                    tSearchDocDateFrom  : $("#oetSearchDocDateFrom").val(),
                    tSearchDocDateTo    : $("#oetSearchDocDateTo").val(),
                    tSearchStaDoc       : $("#ocmStaDoc").val(),
                    tSearchStaApprove   : $("#ocmStaApprove").val(),
                    tSearchStaPrcStk    : $("#ocmStaPrcStk").val(),
                    tSearchStaDoc       : $("#ocmStaApprove").val(),
                    tSearchStaDocAct    : $("#ocmStaDocAct").val(),
                };
                return oAdvanceSearchData;
            } catch (err) {
                // console.log("JSoPTUGetAdvanceSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : ล้างข้อมูลค้นหาขั้นสูง
     * Parameters : -
     * Creator : 17/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     */
    function JSxPTUClearSearchData() {
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
                JSvPTUCallPageDataTable();
            } catch (err) {
                // console.log("JSxPTUClearSearchData Error: ", err);
            }
        } else {
            JCNxShowMsgSessionExpired();
        }
    }

    /**
     * Functionality : หน้าจอเพิ่มเอกสาร
     * Parameters : -
     * Creator : 18/09/2020 Napat(Jame)
     * Return : Add Page
     * Return Type : View
     */
    function JSvPTUCallPageAdd() {
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docPTUPageAdd",
            data: {},
            cache: false,
            timeout: 0,
            success: function(tResult) {
                nIndexInputEditInlineForVD = 0;
                if (nPTUStaBrowseType == 1) {
                    $(".xCNPTUVMaster").hide();
                    $(".xCNPTUVBrowse").show();
                } else {
                    $(".xCNPTUVBrowse").hide();
                    $(".xCNPTUVMaster").show();
                    $("#oliPTUTitleEdit").hide();
                    $("#oliPTUTitleAdd").show();
                    $("#odvPTUBtnInfo").hide();
                    $("#odvBtnAddEdit").show();
                    $("#obtPTUApprove").hide();
                    $("#obtPTUPrint").hide();
                    $("#obtPTUCancel").hide();
                    $("#oliPTUTitleDetail").hide();
                }
                $("#odvPTUContentPage").html(tResult);
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
     * Creator : 28/09/2020 Napat(Jame)
     * Return : Edit Page
     * Return Type : View
     */
    function JSvPTUCallPageEdit(ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            JCNxOpenLoading();

            $.ajax({
                type: "POST",
                url: "docPTUPageEdit",
                data: {
                    tDocNo: ptDocNo
                },
                cache: false,
                timeout: 0,
                success: function(tResult) {
                    if (tResult != "") {
                        $("#odvBtnAddEdit").show();
                        $(".xCNPTUVBrowse").hide();
                        $(".xCNPTUVMaster").show();
                        $("#oliPTUTitleEdit").show();
                        $("#oliPTUTitleAdd").hide();
                        $("#odvPTUBtnInfo").hide();
                        $("#odvBtnAddEdit").show();
                        $("#obtPTUApprove").show();
                        $("#obtPTUPrint").show();
                        $("#obtPTUCancel").show();
                        $("#oliPTUTitleDetail").hide();
                        $("#odvPTUContentPage").html(tResult);
                    }

                    $("#odvShwBtnSave").show();

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
     * Functionality : Multi Delete Doc
     * Parameters : -
     * Creator : 18/09/2020 Napat(Jame)
     * Return : -
     * Return Type : -
     * ptType : 1:Single,2:Multi
     */
    function JSxPTUEventDelDoc(ptType,ptDocNo) {
        var nStaSession = JCNxFuncChkSessionExpired();
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {

            
            // JCNxOpenLoading();

            var aDocNo = [];
            if( ptType == '1' ){
                aDocNo.push(ptDocNo);
                $("#odvModalDel").modal("show");
                $("#ospConfirmDelete").html("ยืนยันการลบข้อมูล หมายเลข : " + aDocNo);

                $("#osmConfirm").on("click", function(evt) {
                    $("#odvModalDel").modal("hide");
                    JCNxOpenLoading();
                    $.ajax({
                        type: "POST",
                        url: "docPTUEventDeleteDoc",
                        data: {
                            aDocNo: aDocNo
                        },
                        success: function(oResult) {
                            var aResult = $.parseJSON(oResult);
                            if( aResult['tCode'] == '1' ){
                                var nCurrentPage = $('#oetPTUCurrentPage').val();
                                JSvPTUCallPageDataTable(nCurrentPage);
                                JSxPTUNavDefult();
                            }else{
                                FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                            }
                        },
                        error: function(jqXHR, textStatus, errorThrown) {
                            JCNxResponseError(jqXHR, textStatus, errorThrown);
                        }
                    });
                });
            }else{
                $("#odvModalDel").modal("hide");

                var aData = $("#ohdConfirmIDDelete").val();
                var aTexts = aData.substring(0, aData.length - 2);
                var aDataSplit = aTexts.split(" , ");
                var aDataSplitlength = aDataSplit.length;
                for ($i = 0; $i < aDataSplitlength; $i++) {
                    aDocNo.push($.trim(aDataSplit[$i]));
                }

                JCNxOpenLoading();
                $.ajax({
                    type: "POST",
                    url: "docPTUEventDeleteDoc",
                    data: {
                        aDocNo: aDocNo
                    },
                    success: function(oResult) {
                        var aResult = $.parseJSON(oResult);
                        if( aResult['tCode'] == '1' ){
                            var nCurrentPage = $('#oetPTUCurrentPage').val();
                            JSvPTUCallPageDataTable(nCurrentPage);
                            JSxPTUNavDefult();
                        }else{
                            FSvCMNSetMsgWarningDialog(aResult['tDesc']);
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }

            // console.log('aDocNo: ', aDocNo);

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
    function JSvPTUDataTableClickPage(ptPage) {
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
        JSvPTUCallPageDataTable(nPageCurrent);
    }
    
</script>