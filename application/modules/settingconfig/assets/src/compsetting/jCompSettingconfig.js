var nStaCompSettingConfigBrowseType     = $("#oetCompSettingStaBrowse").val();
var tCallCompSettingConfigBackOption    = $("#oetCompSettingCallBackOption").val();

$("document").ready(function () {
    localStorage.removeItem("LocalItemData");
    JSxCheckPinMenuClose(); 
    JSvCompSettingConfigCallPageList();
});

//Get FuncHD List Page
function JSvCompSettingConfigCallPageList() {
    JCNxOpenLoading();
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try {
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "CompSettingConfigGetList",
                data    : {},
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvContentPageCompSettingConfig").html(tResult);
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvCompSettingConfigCallPageList Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}

//Load View Setting Config Search 
function JSvCompSettingConfigLoadViewSearch(){
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        try{
            localStorage.removeItem('LocalItemData');
            $.ajax({
                type    : "POST",
                url     : "CompSettingConfigLoadViewSearch",
                data    : {},
                cache   : false,
                timeout : 5000,
                success : function (tResult) {
                    $("#odvInforSettingconfig").html(tResult);
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }catch (err) {
            console.log('JSvCompSettingConfigLoadViewSearch Error: ', err);
        }
    } else {
        JCNxShowMsgSessionExpired();
    }
}













