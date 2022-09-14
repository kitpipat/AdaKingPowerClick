<script type="text/javascript">
    $(document).ready(function(){
        $('.ocbListItem').unbind().click(function(){
            var nCode   = $(this).parents('tr').data('code');
            var tName   = $(this).parents('tr').data('name');

            $(this).prop('checked', true);
            var LocalItemData   = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }else{ }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPriRntLkTextinModal();
            }else{
                var aReturnRepeat = JStPriRntLkFindObjectByKey(aArrayConvert[0],'nCode',nCode);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxPriRntLkTextinModal();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].nCode == nCode){
                            delete aArrayConvert[0][$i];
                        }
                    }
                    var aNewarraydata = [];
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i] != undefined){
                            aNewarraydata.push(aArrayConvert[0][$i]);
                        }
                    }
                    localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                    JSxPriRntLkTextinModal();
                }
            }
            JSxPriRntLkShowButtonChoose();
        });

        // Confrime Delete Mutiple
        $('#odvPriRntLkModalDelDocMultiple #osmConfirmDelMultiple').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                JSoPriRntLkDelDocMultiple();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Confrime Delete Single
        $('#otbPriRntLkTblDataDocHDList .xWPriRntLkDelSingle').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                var tPriRntLkCode   =   $(this).parents('tr').data('code');
                var tPriRntLkName   =   $(this).parents('tr').data('name');
                JSoPriRntLkDelDocSingle(tPriRntLkCode,tPriRntLkName);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Call Page Edit
        $('#otbPriRntLkTblDataDocHDList .xWPriRntLkEditData').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JCNxOpenLoading();
                var tPIDocNo    = $(this).data('code')
                JSvPriRntLkCallPageEdit(tPIDocNo);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Search Table
        $('#obtPriRntLkSerchAll').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== "undefined" && nStaSession == 1) {
                JSvPriRntLkCallPageDataTable();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });




    });
</script>