<script>
    $(document).ready(function(){
        // ========== Event Search Menu ==========
        // $("#odvRoleFuncSearchAll #oetRoleFuncSearchAll").on("keyup", function() {
        //     alert("sssss");
        //     var value = $(this).val().toLowerCase();
        //     $("#xCNRoleFuncSettingBody tr").filter(function() {
        //         $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
        //     });
        // });

        $(".xCNRoleFuncSettingPermissionItemAll").on("change", function(){
            var bIsChecked = $(this).is(":checked");
            if(bIsChecked){
                $(".xCNRoleFuncSettingPermissionItem").prop("checked", true);
            }else{
                $(".xCNRoleFuncSettingPermissionItem").prop("checked", false);
            }
        });
    });

    //ค้นหาสินค้าใ Function
    function JSvRoleFnSearchHTML() {
        var value = $("#oetRoleFuncSearchAll").val().toLowerCase();
        var TrimValue = value.trim();
        $(".xCNRoleFuncSettingBody tr ").filter(function () {
            tText = $(this).toggle($(this).text().toLowerCase().indexOf(TrimValue) > -1);
        });
    }
    
    /**
     * Functionality: Get Function Setting Role on Selected
     * Creator: 24/04/2020 piya
     * LastUpdate: -
     * Return : Function Setting Role on Selected Items
     * ReturnType: array
     */
    function JSaGetRoleFuncSettingSelect(){
        var aRoleFuncSettingItems = [];
        var oRoleFuncSettingChecked = $(".xCNRoleFuncSettingTable .xCNRoleFuncSettingPermissionItem:checked");
        var oRoleFuncSettingNotChecked = $(".xCNRoleFuncSettingTable .xCNRoleFuncSettingPermissionItem:not(:checked)");

        $.each(oRoleFuncSettingChecked, function(){
            var tGhdApp = $(this).data("ghd-app");
            var tGhdCode = $(this).data("ghd-code");
            var tSysCode = $(this).data("sys-code");

            aRoleFuncSettingItems.push({
                tGhdApp: tGhdApp,
                tGhdCode: tGhdCode,
                tSysCode: tSysCode
            });
        });

        return aRoleFuncSettingItems;
    }

    function JSaGetRoleFuncSettingNotSelect(){
        var aRoleFuncSettingNotCheckedItems = [];
        var oRoleFuncSettingNotChecked = $(".xCNRoleFuncSettingTable .xCNRoleFuncSettingPermissionItem:not(:checked)");

        $.each(oRoleFuncSettingNotChecked, function(){
            var tGhdApp = $(this).data("ghd-app");
            var tGhdCode = $(this).data("ghd-code");
            var tSysCode = $(this).data("sys-code");

            aRoleFuncSettingNotCheckedItems.push({
                tGhdApp: tGhdApp,
                tGhdCode: tGhdCode,
                tSysCode: tSysCode
            });
        });

        return aRoleFuncSettingNotCheckedItems;
    }
</script>