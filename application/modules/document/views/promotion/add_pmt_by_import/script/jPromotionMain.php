<script>
    var nOptDecimalShow = <?php echo $nOptDecimalShow; ?>;

    JSxPromotionImportGetPdtGroupTable();
    JSxPromotionImportGetCBTable();
    JSxPromotionImportGetCGTable();
    $(".xCNPromotionGroup").on("click", function(){
        oPromotionImportPdtGroupDatatable.ajax.reload(null, false);
    });
    $(".xCNPromotionConditionBuy").on("click", function(){
        oPromotionImportCBDatatable.ajax.reload(null, false);
    });
    $(".xCNPromotionOption1").on("click", function(){
        oPromotionImportCGDatatable.ajax.reload(null, false);
    });

    $("#odvPromotionModalImportFile #obtIMPCancel").on("click", function(){
        JSxPromotionImportPromotionClearInTemp();
    });

    $("#odvPromotionModalImportFile #obPromotionImportConfirm").unbind().bind("click", function(){
        JSxPromotionImportPromotionTmpToMaster();
    });

    var bIsHDNoWarning = $("#otbPromotionImportExcelHDTable .xCNPromotionImportExcelHDRow").data("sta") == '1';
    if(!bIsHDNoWarning){
        var tHDWarningMsg = "<?php echo language('document/promotion/promotion','tWarMsg28'); ?>"; // Summary HD ไม่ถูกต้องกรุณาตรวจสอบไฟล์ที่นำเข้า
        FSvCMNSetMsgWarningDialog(tHDWarningMsg, '', '', false);
        $(".xCNPromotionImportConfirmBtn").attr("disabled", true).removeAttr("id");
    }else{
        $(".xCNPromotionImportConfirmBtn").attr("disabled", false).attr("id","obPromotionImportConfirm");
    }
</script>