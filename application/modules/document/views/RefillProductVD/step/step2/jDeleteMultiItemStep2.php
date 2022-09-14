<script type="text/javascript">
    $(document).ready(function(){

        // Click Check Box List Delete All
        $('.ocbListItemStep2').unbind().click(function(){
            var nCode = $(this).parent().parent().parent().data('code');  //code
            var tName = $(this).parent().parent().parent().data('name');  //code
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }else{ }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxRVDTextInModal();
            }else{
                var aReturnRepeat = JStRVDFindObjectByKey(aArrayConvert[0],'nCode',nCode);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"nCode": nCode, "tName": tName });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxRVDTextInModal();
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
                    JSxRVDTextInModal();
                }
            }
            JSxRVDShowButtonChoose();
        });

        // Confirm Delete Modal Multiple
        $('#odvRVDModalDelPDTMultipleStep2 #osmConfirmDelMultipleStep2').unbind().click(function(){
            var nStaSession = JCNxFuncChkSessionExpired();
            if (typeof nStaSession !== "undefined" && nStaSession == 1) {
                JSoRVDDelDocMultiStep2();
            }else{
                JCNxShowMsgSessionExpired();
            }
        });
    });

    //เซตข้อความ
    function JSxRVDTextInModal(){
        var  aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
        }else{
            var tTextCode = "";
            for ($i = 0; $i < aArrayConvert[0].length; $i++) {
                tTextCode += aArrayConvert[0][$i].nCode;
                tTextCode += " , ";
            }


            //Disabled ปุ่ม Delete
            if(aArrayConvert[0].length > 1){
                $(".xCNIconDel").addClass("xCNDisabled");
            }else{
                $(".xCNIconDel").removeClass("xCNDisabled");
            }
            $("#ospTextConfirmDelMultipleStep2").text("ท่านต้องการลบข้อมูลทั้งหมดหรือไม่ ?");
            $("#ohdConfirmIDDelete").val(tTextCode);
            $("#ohdConfirmIDDelMultipleStep2").val(tTextCode);
        }
    }   

    //ปุ่มกดลบทั้งหมดเปิด
    function JSxRVDShowButtonChoose() {
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if (aArrayConvert[0] == null || aArrayConvert[0] == "") {
            $("#oliBtnDeleteAllStep2").addClass("disabled");
        } else {
            nNumOfArr = aArrayConvert[0].length;
            if (nNumOfArr > 1) {
                $("#oliBtnDeleteAllStep2").removeClass("disabled");
            } else {
                $("#oliBtnDeleteAllStep2").addClass("disabled");
            }
        }
    }

    //ค้นหาข้อความใน array
    function JStRVDFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //ลบข้อมูลหลายตัว
    function JSoRVDDelDocMultiStep2(){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var aDataDelMultiple    = $('#odvRVDModalDelPDTMultipleStep2 #ohdConfirmIDDelMultipleStep2').val();
            var aTextsDelMultiple   = aDataDelMultiple.substring(0, aDataDelMultiple.length - 2);
            var aDataSplit          = aTextsDelMultiple.split(" , ");
            var nDataSplitlength    = aDataSplit.length;
            var aNewIdDelete        = [];
            
            for($i = 0; $i < nDataSplitlength; $i++){
                aNewIdDelete.push(aDataSplit[$i]);
            }
            if(nDataSplitlength > 1){
                localStorage.StaDeleteArray = '1';
                $.ajax({
                    type    : "POST",
                    url     : "docRVDRefillPDTVDDeleteMultiStep2",
                    data    : { nSeq : aNewIdDelete , tDocumentNumber : $('#oetRVDDocNo').val() },
                    cache   : false,
                    timeout : 0,
                    success : function(oResult) {
                        $('#oliBtnDeleteAllStep2 a').click();

                        //remove
                        for(j=0; j<aNewIdDelete.length; j++){
                            $('.otrPdtTable2'+aNewIdDelete[j]).closest("tr").remove();
                        }

                        //ถ้ากดลบข้อมูลเเล้วจะไม่ต้อง refresh ใน step 2
                        $('#ohdRefillVDDontRefresh').val(1);

                        //ลบจนไม่มีข้อมูล
                        var nRowCount = $('.xCNTableStep2 tr').length;
                        if(nRowCount == 1){
                            var tHTMLNotFound =  '<tr class="otrDataNotFound">';
                                tHTMLNotFound += '<td class="text-center xCNTextDetail2" colspan="100%"><?= language('common/main/main','tCMNNotFoundData')?></td>';
                                tHTMLNotFound += '</tr>';
                            $('#otdTBodyTableStep2').append(tHTMLNotFound);
                        }

                        localStorage.removeItem("LocalItemData");
                        $(".ocbListItemStep2").prop("checked", false);
                        $(".xCNIconDel").removeClass("xCNDisabled");
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        JCNxResponseError(jqXHR, textStatus, errorThrown);
                    }
                });
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
</script>