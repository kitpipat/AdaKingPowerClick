<script type="text/javascript">
    $(document).ready(function (){

        // Evnet Call Page Edit
        $('.xCNIconEdit').on("click",function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                $(this).off("click");
                let tPosEdcCode = $(this).data("code");
                JSvCallPagePosEdcEdit(tPosEdcCode);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
        
        // Event Click Delete Single
        $('.xCNIconDel').on("click",function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                var aDataDelete    = {
                    'tPosEdcCode'           : $(this).data("code"),
                    'tPosEdcName'           : $(this).data("name"),
                    'nPosEdcPageCurrent'    : $(this).data("currentpage"),
                };
                JSoPosEdcDeleteSingle(aDataDelete);
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

        // Event Selete Multi Delete
        $('.ocbListItem').on("click",function(){
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
                JCNxPosEdcTextInModal();
            }else{
                var aReturnRepeat   = JCNxPosEdcFindObjectByKey(aArrayConvert[0],'nCode',nCode);
                if(aReturnRepeat == 'None' ){
                    oObjectDataDel.push({"nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalItemData",JSON.stringify(oObjectDataDel));
                    JCNxPosEdcTextInModal();
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
                    JCNxPosEdcTextInModal();
                }
            }
            JCNxPosEdcShowBtnChoose();
        });

        $('#odvModalDeletePosEdcMulti #osmConfirmDelete').on("click",function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
                JSoPosEdcDelDocMultiple();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });

    });

    
    // Functionality: Insert Text In Modal Delete
    // Parameters: LocalStorage Data
    // Creator: 03/09/2019 wasin(Yoshi)
    // Last Update : -
    // Return: Insert Code In Text Input
    // Return Type: -
    function JCNxPosEdcTextInModal(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") { } else {
            var tTextCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += " , ";
            }
            //Disabled ปุ่ม Delete
            if(aArrayConvert[0].length > 1){
                $(".xCNIconDel").parent().addClass("xCNDisabled");
                $(".xCNIconDel").css('pointer-events','none');
            }else{
                $(".xCNIconDel").parent().removeClass("xCNDisabled");
                $(".xCNIconDel").css('pointer-events','');
            }
            $("#odvModalDeletePosEdcMulti #ospTextConfirmDelete").text($('#oetTextComfirmDeleteMulti').val());
            $("#odvModalDeletePosEdcMulti #ohdConfirmIDDelete").val(tTextCode);
        }
    }

    // Functionality: Check Data Duplicate In Array
    // Parameters: Event Select List Branch
    // Creator: 03/09/2019 wasin(Yoshi)
    // Last Update : -
    // Return: Duplicate/none
    // Return Type: string
    function JCNxPosEdcFindObjectByKey(array,key,value){
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }


    // Functionality: Function Chack And Show Button Delete All
    // Parameters: LocalStorage Data
    // Creator: 03/09/2019 wasin(Yoshi)
    // Last Update : -
    // Return: Show Button Delete All
    // Return Type: -
    function JCNxPosEdcShowBtnChoose(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert[0] == null || aArrayConvert[0] == ""){
            $("#odvMngTableList #oliBtnDeleteAll").addClass("disabled");
        }else{
            nNumOfArr   = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#odvMngTableList #oliPosEdcBtnDeleteAll").removeClass("disabled");
            } else {
                $("#odvMngTableList #oliPosEdcBtnDeleteAll").addClass("disabled");
            }
        }
    }


</script>