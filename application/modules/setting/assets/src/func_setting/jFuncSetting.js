var nStaFuncSettingBrowseType = $("#oetFuncSettingStaBrowse").val();
var tCallFuncSettingBackOption = $("#oetFuncSettingCallBackOption").val();

$("document").ready(function () {
    
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); /*Check เปิดปิด Menu ตาม Pin*/
    JSxFuncSettingNavDefult();

    if (nStaFuncSettingBrowseType != 1) {
        JSvFuncSettingCallPageList();
    } else {
        JSvCallPageFuncSettingAdd();
    }
    
});

/**
 * Function : Set Default Nav
 * Parameters : -
 * Creator : 22/06/2019 Piya
 * Return : -
 * Return Type : -
 */
function JSxFuncSettingNavDefult() {
    if (nStaFuncSettingBrowseType != 1 || nStaFuncSettingBrowseType == undefined) {
        $(".xCNFuncSettingVBrowse").hide();
        $(".xCNFuncSettingVMaster").show();
        $("#oliFuncSettingTitleAdd").hide();
        $("#odvBtnAddEdit").hide();
        $(".obtChoose").hide();
        $("#odvBtnFuncSettingInfo").show();
    }else {
        $("#odvModalBody .xCNFuncSettingVMaster").hide();
        $("#odvModalBody .xCNFuncSettingVBrowse").show();
        $("#odvModalBody #odvFuncSettingMainMenu").removeClass("main-menu");
        $("#odvModalBody #oliFuncSettingNavBrowse").css("padding", "2px");
        $("#odvModalBody #odvFuncSettingBtnGroup").css("padding", "0");
        $("#odvModalBody .xCNFuncSettingBrowseLine").css("padding", "0px 0px");
        $("#odvModalBody .xCNFuncSettingBrowseLine").css("border-bottom", "1px solid #e3e3e3");
    }
}

/**
 * Function : Get FuncHD List Page
 * Parameters : -
 * Creator : 22/06/2019 Piya
 * Return : -
 * Return Type : -
 */
function JSvFuncSettingCallPageList() {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
    
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type: "GET",
                url: "funcSettingGetSearchList",
                data: {},
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvContentPageFuncSetting").html(tResult);
                    JSxFuncSettingNavDefult();

                    JSvFuncSettingGetDataTableHD(); // แสดงข้อมูลใน List
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvFuncSettingCallPageList Error: ', err);
        }
        
    } else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Function : Get FuncHD Edit Page
 * Parameters : -
 * Creator : 22/06/2019 Piya
 * Return : -
 * Return Type : -
 */
function JSvFuncSettingCallPageEdit() {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        try {
            $.ajax({
                type: "GET",
                url: "funcSettingGetEditPage",
                data: {},
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    $("#odvContentPageFuncSetting").html(tResult);
                    JSxFuncSettingNavDefult();

                    JSvFuncSettingGetDataTableTemp(); // แสดงข้อมูลในหน้าแก้ไข
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvFuncSettingCallPageEdit Error: ', err);
        }
        
    }else {
        JCNxShowMsgSessionExpired();
    }
}

/**
 * Functionality : Get FuncHD Table
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : View
 * Return Type : View
 */
function JSvFuncSettingGetDataTableHD(pnPage) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        JCNxOpenLoading();
        pnPage = (typeof pnPage === 'undefinded') ? 1 : pnPage;

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();
        var nGdtFuncLevel = $('#ocmFuncSettingHDGdtFuncLevel').val();
        var tGdtStaUse = $('#ocmFuncSettingHDGdtStaUse').val();

        $.ajax({
            type: "POST",
            url: "funcSettingGetDataTableHD",
            data: {
                nPageCurrent: nPageCurrent,
                tGhdApp: tGhdApp,
                nGdtFuncLevel: nGdtFuncLevel,
                tGdtStaUse: tGdtStaUse
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                $("#odvContentFuncSettingList").html(tResult);

                JSxFuncSettingNavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }else {
        JCNxShowMsgSessionExpired();
    }
    
}

/**
 * Functionality : Get FuncHD Table Temp
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : View
 * Return Type : View
 */
function JSvFuncSettingGetDataTableTemp(pnPage) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        JCNxOpenLoading();
        pnPage = (typeof pnPage === 'undefinded') ? 1 : pnPage;

        var nPageCurrent = pnPage;
        if (nPageCurrent == undefined || nPageCurrent == "") {
            nPageCurrent = "1";
        }

        var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();

        $.ajax({
            type: "POST",
            url: "funcSettingGetDataTableTemp",
            data: {
                nPageCurrent: nPageCurrent,
                tGhdApp: tGhdApp
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                $("#odvContentFuncSettingList").html(tResult);

                JSxFuncSettingNavDefult();
                JCNxLayoutControll();
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    } else {
        JCNxShowMsgSessionExpired();
    }
    
}

/**
 * Functionality : Insert FuncDT To Temp
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : View
 * Return Type : View
 */
function JSvFuncSettingInsertDTToTemp(pnPage) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            
        JCNxOpenLoading();
        pnPage = (typeof pnPage === 'undefinded') ? 1 : pnPage;

        var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();

        $.ajax({
            type: "POST",
            url: "funcSettingInsertDTToTmp",
            data: {
                tGhdApp: tGhdApp
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                JCNxCloseLoading();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
            
    } else {
        JCNxShowMsgSessionExpired();
    }
    
}
