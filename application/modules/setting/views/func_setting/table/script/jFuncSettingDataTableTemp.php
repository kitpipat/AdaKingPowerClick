<script>
var aFuncUsedItem = [];

$(document).ready(function () {

    $('.selectpicker').selectpicker();

    $(".xCNFuncSettingItemUsedAll").on("change", function(){
        var bIsChecked = $(this).is(":checked");
        aFuncUsedItem = [];

        if(bIsChecked){
            $(".xCNFuncSettingItemUsed").prop("checked", true);
            var oFuncSettingItemUsed = $(".xCNFuncSettingItemUsed");
            $.each(oFuncSettingItemUsed, function(index, item){
                var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();
                var tGdtCallByName = $(item).parents('.xWFuncSettingTempItems').data('gdt_call_by_name');
                var tGhdCode = $(item).parents('.xWFuncSettingTempItems').data('ghd-code');
                var tSysCode = $(item).parents('.xWFuncSettingTempItems').data('sys-code');
                // var nGdtFuncLevel = $(item).parents('.xWFuncSettingTempItems').find('select.level').val();
                var tGdtStaUse = "1";
                aFuncUsedItem.push(
                    {
                        tGhdApp: tGhdApp,
                        tGhdCode: tGhdCode,
                        tSysCode: tSysCode,
                        tGdtCallByName: tGdtCallByName,
                        // nGdtFuncLevel: nGdtFuncLevel,
                        tGdtStaUse: tGdtStaUse
                    }
                );
            });
        }else{
            $(".xCNFuncSettingItemUsed").prop("checked", false);
            var oFuncSettingItemUsed = $(".xCNFuncSettingItemUsed");
            $.each(oFuncSettingItemUsed, function(index, item){
                var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();
                var tGdtCallByName = $(item).parents('.xWFuncSettingTempItems').data('gdt_call_by_name');
                var tGhdCode = $(item).parents('.xWFuncSettingTempItems').data('ghd-code');
                var tSysCode = $(item).parents('.xWFuncSettingTempItems').data('sys-code');
                // var nGdtFuncLevel = $(item).parents('.xWFuncSettingTempItems').find('select.level').val();
                var tGdtStaUse = "2";
                aFuncUsedItem.push(
                    {
                        tGhdApp: tGhdApp,
                        tGhdCode: tGhdCode,
                        tSysCode: tSysCode,
                        tGdtCallByName: tGdtCallByName,
                        // nGdtFuncLevel: nGdtFuncLevel,
                        tGdtStaUse: tGdtStaUse
                    }
                );
            });
        }
    });
});

/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvFuncSettingTempClickPage(ptPage) {
    var nPageCurrent = "";
    switch (ptPage) {
        case "next": //กดปุ่ม Next
            $("#odvFuncSettingTempClickPage .xWBtnNext").addClass("disabled");
            nPageOld = $("#odvFuncSettingTempClickPage .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case "previous": //กดปุ่ม Previous
            nPageOld = $("#odvFuncSettingTempClickPage .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvFuncSettingGetDataTableTemp(nPageCurrent);
}

/**
 * Functionality : Update Inline in Temp
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSxCFuncSettingUpdateFuncInTmp(poEl, ptPage) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        ptPage = (typeof ptPage === 'undefined') ? 1 : ptPage;

        var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();
        var tGdtCallByName = $(poEl).parents('.xWFuncSettingTempItems').data('gdt_call_by_name');
        var tGhdCode = $(poEl).parents('.xWFuncSettingTempItems').data('ghd-code');
        var tSysCode = $(poEl).parents('.xWFuncSettingTempItems').data('sys-code');
        // var nGdtFuncLevel = $(poEl).parents('.xWFuncSettingTempItems').find('select.level').val();
        var tGdtStaUse = ($(poEl).is(":checked"))?"1":"2";

        $.ajax({
            type: "POST",
            url: "funcSettingUpdateFuncInTmp",
            data: {
                tGhdApp: tGhdApp,
                tGhdCode: tGhdCode,
                tSysCode: tSysCode,
                // nGdtFuncLevel: nGdtFuncLevel,
                tGdtStaUse: tGdtStaUse,
                tGdtCallByName: tGdtCallByName
            },
            cache: false,
            timeout: 5000,
            success: function (tResult) {
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
 * Functionality : Update All in Temp
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSxCFuncSettingUpdateFuncAllInTmp(callback) {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {

        JCNxOpenLoading();
        
        $.ajax({
            type: "POST",
            url: "funcSettingUpdateFuncAllInTmp",
            data: {aFuncUsedItem: aFuncUsedItem},
            cache: false,
            timeout: 5000,
            success: function (tResult) {
                callback();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                JCNxCloseLoading();
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    
    }else {
        JCNxShowMsgSessionExpired();
    }
    
}

/**
 * Functionality : Save Temp to FuncDT
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSxCFuncSettingSaveEvent(poEl, ptPage) {
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        ptPage = (typeof ptPage === 'undefined') ? 1 : ptPage;
        
        JCNxOpenLoading();

        JSxCFuncSettingUpdateFuncAllInTmp(function(){
            var tGhdApp = $('#ocmFuncSettingHDGhdApp').val();

            $.ajax({
                type: "POST",
                url: "funcSettingSaveEvent",
                data: {
                    tGhdApp: tGhdApp
                },
                cache: false,
                timeout: 5000,
                success: function (tResult) {
                    JSvFuncSettingGetDataTableTemp(ptPage);
                    JCNxLayoutControll();
                    JCNxCloseLoading();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxCloseLoading();
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
    
}
</script>

