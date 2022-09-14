<script>
    $(document).ready(function(){
        JSxShowButtonChoose();
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        var nlength = $('#odvRGPList').children('tr').length;
        for($i=0; $i < nlength; $i++){
            var tDataCode = $('#otrSpaTwoPdt'+$i).data('seq');
            if(aArrayConvert == null || aArrayConvert == ''){
            }else{
                var aReturnRepeat = JStASTFindObjectByKey(aArrayConvert[0],'tSeq',tDataCode);
                if(aReturnRepeat == 'Dupilcate'){
                $('#ocbListItem'+$i).prop('checked', true);
                }else{ }
            }
        }
        $('.ocbListItem').click(function(){
            var tSeq = $(this).parent().parent().parent().data('seqno');    //Seq
            var tPdt = $(this).parent().parent().parent().data('pdtcode');  //Pdt
            var tDoc = $(this).parent().parent().parent().data('docno');    //Doc
            var tPun = $(this).parent().parent().parent().data('puncode');  //Pun

            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"tSeq": tSeq, 
                      "tPdt": tPdt, 
                      "tDoc": tDoc, 
                      "tPun": tPun 
                    });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxASTPdtTextinModal();
            }else{
                var aReturnRepeat = JStASTFindObjectByKey(aArrayConvert[0],'tSeq',tSeq);
                if(aReturnRepeat == 'None' ){
                    obj.push({"tSeq": tSeq, 
                          "tPdt": tPdt, 
                          "tDoc": tDoc, 
                          "tPun": tPun 
                        });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxASTPdtTextinModal();
                }else if(aReturnRepeat == 'Dupilcate'){
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].tSeq == tSeq){
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
                    JSxASTPdtTextinModal();
                }     
            }
            JSxShowButtonChoose();
        });

        // Create By : Napat(Jame) 30/07/2020

        sessionStorage.removeItem("EditInLine");

        $('.xCNPdtEditInLine').off('keydown');
        $('.xCNPdtEditInLine').on('keydown',function(){
            if(event.keyCode == 13){
                if(sessionStorage.getItem("EditInLine") != "2"){
                    sessionStorage.setItem("EditInLine", "1");
                    JSxAdjStkEditInLine($(this));
                }
            }
        });
        
        $('.xCNPdtEditInLine').off('focus');
        $('.xCNPdtEditInLine').on('focus',function(){
            this.select();
        });

        $('.xCNPdtEditInLine').off('change');
        $('.xCNPdtEditInLine').on('change',function(){
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxAdjStkEditInLine($(this));
            }
        });

    });
</script>