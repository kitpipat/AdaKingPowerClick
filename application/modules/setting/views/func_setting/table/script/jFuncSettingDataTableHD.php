<script>
/**
 * Functionality : เปลี่ยนหน้า pagenation
 * Parameters : -
 * Creator : 05/09/2019 Piya
 * Return : View
 * Return Type : View
 */
function JSvFuncSettingHDClickPage(ptPage) {
    var nPageCurrent = "";
    switch (ptPage) {
        case "next": //กดปุ่ม Next
            $("#odvFuncSettingHDClickPage .xWBtnNext").addClass("disabled");
            nPageOld = $("#odvFuncSettingHDClickPage .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) + 1; // +1 จำนวน
            nPageCurrent = nPageNew;
            break;
        case "previous": //กดปุ่ม Previous
            nPageOld = $("#odvFuncSettingHDClickPage .xWPage .active").text(); // Get เลขก่อนหน้า
            nPageNew = parseInt(nPageOld, 10) - 1; // -1 จำนวน
            nPageCurrent = nPageNew;
            break;
        default:
            nPageCurrent = ptPage;
    }
    JSvFuncSettingGetDataTableHD(nPageCurrent);
}
</script>

