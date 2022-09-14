
<script type="text/javascript">
    $(document).ready(function () {
        
    });

    //tab -> ตั้งค่าเลเอาท์
    function JSxGetPSHContentLayoutSetting(){
            var tBchCode    = $('#oetPshPSHBchCode').val();
            var tShpCode    = $('#oetPshPSHShpCod').val();
            var tMerCode    = $('#oetPshPSHMerCode').val();
            var tPosCode    = $('#oetPshPSHPosCode').val();
            
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $.ajax({
                    type	: "POST",
                    url		: "PSHSmartLockerShopPosCallPageSetting",
                    data	: {
                        tBchCode        : tBchCode,
                        tShpCode        : tShpCode,
                        tMerCode        : tMerCode,
                        tPosCode        : tPosCode
                    },
                    cache	: false,
                    timeout	: 0,
                    success	: function(tResult){
                        $('#odvPSHContentInfoST').html(tResult);
                        JSvPSHDataTable(tBchCode,tShpCode,1);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }else{
            JCNxShowMsgSessionExpired();
        }
     
    }

    //ค้นหา
    function JSvPSHSearchAll(){
        var tBCHCode       =  $('#oetPSHBchCode').val();
        var tBchCodeOver   =  $('#ocmPshBchCode option:selected').text();
        var tSHPCode       =  $('#oetPSHShpCode').val();
        JSvPSHDataTable(tBCHCode, tSHPCode, 1, tBchCodeOver);
    }

    //tab -> ตรวจสอบสถานะ
    function JSxGetPSHContentCheckStatus(){
        var tBchCode    = $('#oetPshPSHBchCode').val();
        var tShpCode    = $('#oetPshPSHShpCod').val();
        var tMerCode    = $('#oetPshPSHMerCode').val();
        var tSaleMac    = $('#oetPosCodeSN').val();
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            $.ajax({
                type	: "POST",
                url		: "PSHSmartLockerCheckStatusMain",
                data	: {
                    tBchCode        : tBchCode,
                    tShpCode        : tShpCode,
                    tMerCode        : tMerCode,
                    tSaleMac        : tSaleMac
                },
                cache	: false,
                timeout	: 0,
                success	: function(tResult){
                    $('#odvPSHContentInfoCS').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    //tab -> ปรับสถานะ
    function JSxGetPSHContentAdjustStatus(){
        var tRefCode = $('#ospRefCode').text();;
        
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            
            $.ajax({
                type: "POST",
                url: "smartLockerAdjustStatusMainPage",
                data: {
                    tRefCode: tRefCode
                },
                cache: false,
                timeout: 0,
                success: function(tResult){
                    $('#odvPSHContentInfoCG').html(tResult);
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
            
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
    //โหลด ข้อมูล
    function JSvPSHDataTable(ptBchCode, ptShpCode, pnPage, ptBchCodeOver){
        var tRakCode      = $('#osmPSHRakName').val();
        var tLayNo        = $('#osmPSHLayNo').val();
        var tRow          = $('#oetSearchPSHRow').val();
        var tColumn       = $('#oetSearchPSHColumn').val();
        var tMerCode      = $('#oetPshPSHMerCode').val();
        var tPosCode      = $('#oetPshPSHPosCode').val();

        var nPageCurrent    = (pnPage === undefined || pnPage == '')? '1' : pnPage;
        JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "PSHSmartLockerShopPosDataTable",
            data: {
                    tBchCode        :   ptBchCode,
                    tBchCodeOver    :   ptBchCodeOver,
                    tShpCode        :   ptShpCode,
                    nPageCurrent    :   nPageCurrent,
                    tRakCode        :   tRakCode,
                    tLayNo          :   tLayNo,
                    tRow            :   tRow,
                    tColumn         :   tColumn,
                    tMerCode        :   tMerCode,
                    tPosCode        :   tPosCode
                    
                },
                cache: false,
                Timeout: 0,
                success: function(tResult){
                    if (tResult != "") {
                        $('#odvContentPSHLSettingDataTable').html(tResult);
                }
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //เลือก สาขา
    $('#ocmPshBchCode').bind('change', function(ev) {
        $("#osmPSHRakName").val('').selectpicker("refresh");
        $("#osmPSHLayNo").val('').selectpicker("refresh");
        $('#oetSearchPSHRow').val('');
        $('#oetSearchPSHColumn').val('');
        var tBCHCode       =  $('#oetPSHBchCode').val();
        var tBchCodeOver   =  $('#ocmPshBchCode option:selected').text();
        var tSHPCode       =  $('#oetPSHShpCode').val();
        JSvPSHDataTable(tBCHCode, tSHPCode, 1, tBchCodeOver);
    });

    //call page Add
    function JSvCallPagePosShopEventAdd(){
        var tBchCode        = $('#oetPshPSHBchCode').val();
        var tShpCode        = $('#oetPshPSHShpCod').val();
        var tMerCode        = $('#oetPshPSHMerCode').val();
        var tShpTypeCode    = $('#oetPshPSHShpType').val();
        var tShpType        = $('#ocmShpType').val();
        $.ajax({
        type: "POST",
        url: "posshoppageadd",
        data: {
            tBchCode : tBchCode,
            tShpCode : tShpCode,
            tMerCode : tMerCode,
            tShpTypeCode : tShpTypeCode,
            tShpType : tShpType,
        },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            $('#ospShpType').val(tShpTypeCode);
            $('#odvPshContent').html(tResult);
        },
            error: function(data) {
                console.log(data);
            }
        });  
    }

    //call page Edit
    function JSvCallPagePosShopEventEdit(ptBchCode,ptPosCode,ptShpCode,pnPshStaUse,pnPshSceLayout){
        var tShpTypeCode    = $('#oetPshPSHShpType').val();
        var tShpType        = $('#ocmShpType').val();
        const nPshStaUse    = pnPshStaUse;
        const nPshSceLayout = pnPshSceLayout;
        $.ajax({
        type: "POST",
        url: "posshopEventpageedit",
        data: {
            tBchCode : ptBchCode,
            tPosCode : ptPosCode,
            tShpCode : ptShpCode,
            tShpTypeCode : tShpTypeCode,
            tShpType : tShpType,
        },
        cache: false,
        timeout: 5000,
        success: function(tResult) {
            $('#odvPshContent').html(tResult);
            $("#ocmPshStaUse option[value='" + nPshStaUse + "']").attr('selected', true).trigger('change');
            $("#ocmPshStaSceLayout option[value='" + nPshSceLayout + "']").attr('selected', true).trigger('change');

        },
            error: function(data) {
                console.log(data);
            }
        });  
    }

//Functionality : เปลี่ยนหน้า pagenation
//Parameters : -
//Creator : 08/08/2019 saharat(Golf)
//Return : View
//Return Type : View
function JSvPshClickPage(ptPage) {
        var tBchCode        = $('#oetPshPSHBchCode').val();
        var tShpCode        = $('#oetPshPSHShpCod').val();
    var nPageCurrent = '';
    switch (ptPage) {
        case "next": //กดปุ่ม Next
            $('.xWBtnNext').addClass('disabled');
            nPageOld = $('.xWPSHPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew
            break;
        case "previous": //กดปุ่ม Previous
            nPageOld = $('.xWPSHPaging .active').text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew
            break;
        default:
            nPageCurrent = ptPage
    }

    JSvPSHDataTable(tBchCode,tShpCode,nPageCurrent);
}


</script>




