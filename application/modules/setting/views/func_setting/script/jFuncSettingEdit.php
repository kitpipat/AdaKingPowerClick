<script type="text/javascript">

$(document).ready(function(){
    
    $('.xWSelectSysApp').selectpicker();
    
    $("#oliFuncSettingTitleEdit").show();
    
    JSvFuncSettingInsertDTToTemp();
    
    window.tSelecSysAppVal = $('#ocmFuncSettingHDGhdApp').val();
    
});

/**
 * Functionality : Change SystApp Action
 * Parameters : -
 * Creator : 22/05/2019 Piya
 * Last Modified : -
 * Return : 
 * Return Type : 
 */
function JSxFuncSettingChangeSysAppAction() {
    
    var nStaSession = JCNxFuncChkSessionExpired();
    if (typeof nStaSession !== "undefined" && nStaSession == 1) {
        
        $("#odvFuncSettingModalConfirmChangeSysApp").modal('show');
        $("#odvFuncSettingModalConfirmChangeSysApp #osmConfirmChangeSysApp").unbind('click').on('click', function(){
            $("#odvFuncSettingModalConfirmChangeSysApp").modal('hide');
            JSvFuncSettingInsertDTToTemp(); 
            JSvFuncSettingGetDataTableTemp();
            window.tSelecSysAppVal = $('#ocmFuncSettingHDGhdApp').val();
            return;
        });
        
        $("#odvFuncSettingModalConfirmChangeSysApp #osmCancelChangeSysApp").unbind('click').on('click', function(){
            $('.xWSelectSysApp').val(window.tSelecSysAppVal).selectpicker('refresh');
        });
    } else {
        JCNxShowMsgSessionExpired();
    }
    
}
</script>
