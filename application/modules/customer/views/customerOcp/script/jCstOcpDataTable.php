<script type="text/javascript">
    $(document).ready(function(){

        // Evnet Call Page Edit
        $('.xCNIconEdit').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                let tCstOcpCode = $(this).data("code");
                JSvCallPageCstOcpEdit(tCstOcpCode);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Click Delete Single
        $('.xCNIconDel').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var aDataDelete    = {
                    'tCstOcpCode'           : $(this).data("code"),
                    'tCstOcpName'           : $(this).data("name"),
                    'nCstOcpPageCurrent'    : $(this).data("currentpage"),
                };
                JSoCstOcpEventDeleteSingle(aDataDelete);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Selete Multi Delete
        $('.ocbListItem').unbind().click(function(){
            var nCode   = $(this).parents('tr').data('code');
            var tName   = $(this).parents('tr').data('name');
            $(this).prop('checked', true);
            var oLocalItemData  = localStorage.getItem("LocalItemData");
            var oObjectDataDel  = [];
            if(oLocalItemData){
                oObjectDataDel  = JSON.parse(oLocalItemData);
            }
            var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                oObjectDataDel.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(oObjectDataDel));
                JCNxCstOcpTextInModal();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewArraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewArraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewArraydata));
                JCNxCstOcpTextInModal();
            }
            JCNxCstOcpShowBtnChoose();
        });

        $('#odvModalDeleteCstOcpMulti #osmConfirmDelete').on("click",function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSoPosEdcDelDocMultiple();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

    });
</script>