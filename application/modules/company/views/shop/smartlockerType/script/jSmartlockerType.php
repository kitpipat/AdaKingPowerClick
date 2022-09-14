<script type="text/javascript">
    $(document).ready(function () {
        JSvSmartLockertTypeList(1);
    });

    //List
    function JSvSmartLockertTypeList(pnPage){
        if(pnPage == ''){ pnPage = 1 }
        $.ajax({
            type	: "POST",
            url		: "LocTypeDataTable",
            data	: {
                tBchCode        : $('#ohdSmartLockerTypeBCH').val(),
                tShpCode        : $('#ohdSmartLockerTypeSHP').val(),
                nPageCurrent    : pnPage
            },
            cache	: false,
            timeout	: 0,
            success	: function(tResult){
                JCNxCloseLoading();
                $('#odvContentShopLayoutType').html(tResult);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Page Add
    function JSvCallPageSmartlockerTypeAdd() {
        JCNxOpenLoading();
        $.ajax({
            type    : "POST",
            url     : "LocTypeDataAddOrEdit",
            data    : {
                tBchCode        : $('#ohdSmartLockerTypeBCH').val(),
                tShpCode        : $('#ohdSmartLockerTypeSHP').val(),
                tTypePage       : 'pageadd'
            },
            cache   : false,
            timeout : 5000,
            success: function(tResult) {
                $('#odvSHPContentSmartLockerType').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Event Add
    function JSvSmartLockertTypeEventAdd(){
        $.ajax({
            type	: "POST",
            url		: "LocTypeEventAdd",
            data	: $('#ofmAddSmartLockerType').serialize(),
            cache	: false,
            timeout	: 0,
            success	: function(tResult){
                if(tResult == 1){
                    alert('สาขานี้ถูกใช้งานเเล้ว');
                }else{
                    JSxGetSHPContentSmartLockerType();
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Event Edit 
    function JSvSmartLockertTypeEventEdit(pnBchCode,pnShpCode){
        $.ajax({
            type	: "POST",
            url		: "LocTypeEventEdit",
            data	: $('#ofmAddSmartLockerType').serialize() + '&ptShpCode=' + pnShpCode + '&ptBchCode=' + pnBchCode,
            cache	: false,
            timeout	: 0,
            success	: function(tResult){
                JSxGetSHPContentSmartLockerType();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    

</script>