<script>
    $(document).ready(function(){
        $(".xCNRoleNotiSettingPermissionItemAll").on("change", function(){
            var bIsChecked = $(this).is(":checked");
            if(bIsChecked){
                $(".xCNRoleNotiSettingPermissionItem").prop("checked", true);
            }else{
                $(".xCNRoleNotiSettingPermissionItem").prop("checked", false);
            }
        });
    });

    //ค้นหาสินค้าใ Noti
    function JSvRoleNotiSearchHTML() {
        var value = $("#oetRoleNotiSearchAll").val().toLowerCase();
        var TrimValue = value.trim();
        $(".xCNRoleNotiSettingBody tr ").filter(function () {
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
    function JSaGetRoleNotiSettingSelect(){
        var aRoleNotiSettingItems = [];
        var oRoleNotiSettingChecked = $(".xCNRoleNotiSettingTable .xCNRoleNotiSettingPermissionItem:checked");

        $.each(oRoleNotiSettingChecked, function(){
            var tNotiCode = $(this).data("notcode");

            aRoleNotiSettingItems.push({
                tNotiCode: tNotiCode
            });
        });

        return aRoleNotiSettingItems;
    }
</script>