<script>

    $(document).ready(function(){

        sessionStorage.removeItem("EditInLine");

        var nStaApv = parseInt($('#ohdAdjStkSubAjhStaApv').val());
        var nStaDoc = parseInt($('#ohdAdjStkSubAjhStaDoc').val());
        if(nStaApv == 1 || nStaDoc == 3){
            $('.xWASTDisabledOnApv').attr('disabled',true);
            $('.xWASTRemoveOnApv').remove();
            $('.xWEditInlineHideOnApv').hide();
            $('.xWEditInlineShowOnApv').show();
        }
        
        //Put Sum HD In Footer
        // $('#othFCXthTotal').text($('#ohdFCXthTotalShow').val());

        JSxShowButtonChoose();

        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        var nlength = $('#odvRGPList').children('tr').length;
        for($i=0; $i < nlength; $i++){
            var tDataCode = $('#otrSpaTwoPdt'+$i).data('seq');
        if(aArrayConvert == null || aArrayConvert == ''){
        }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tDataCode);
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
                JSxAdjStkSubPdtTextinModal();
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"tSeq": tSeq, 
                            "tPdt": tPdt, 
                            "tDoc": tDoc, 
                            "tPun": tPun 
                            });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxAdjStkSubPdtTextinModal();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
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
                    JSxAdjStkSubPdtTextinModal();
                }
            }
            JSxShowButtonChoose();
        });

        $('.xCNPdtEditInLine').off('keydown');
        $('.xCNPdtEditInLine').on('keydown',function(){
            if(event.keyCode == 13){
                if(sessionStorage.getItem("EditInLine") != "2"){
                    sessionStorage.setItem("EditInLine", "1");
                    JSxASTEditInLine($(this),1);
                }
            }
        });
        
        $('.xCNPdtEditInLine').off('focus');
        $('.xCNPdtEditInLine').on('focus',function(){
            this.select();
        });

        $(".xWDatePickerChange").datepicker({
            // setDate                 : new Date(),
            format          		: 'yyyy-mm-dd',
            // container       		: $('.xWForm-GroupDatePicker').length>0 ? $('.xWForm-GroupDatePicker').parent() : "body",
            todayHighlight  		: true,
            enableOnReadonly		: false,
            disableTouchKeyboard 	: true,
            autoclose       		: true,
            orientation     		: 'bottom'
            // startDate               : new Date(),
            
        }).on("blur", function() {
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxASTEditInlineCheckDate($(this));
                console.log('blur');
            }
            
        }).on("keydown", function() {
            if(event.keyCode == 13){
                console.log('enter');
                if(sessionStorage.getItem("EditInLine") != "2"){
                    sessionStorage.setItem("EditInLine", "1");
                    JSxASTEditInlineCheckDate($(this));
                    console.log('keydown');
                }
                // this.blur();
                // event.preventDefault();
            }
        }).on('hide', function() {
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxASTEditInlineCheckDate($(this));
                // console.log('hide');
            }
            
            // if($(this).val()==""){
            //     $(this).val(JStASTGetDateTime(121));
            // }
        });

        // $('.xWDatePickerChange').off('change');
        // $('.xWDatePickerChange').on('change',function(){
        //     if(sessionStorage.getItem("EditInLine") != "2"){
        //         sessionStorage.setItem("EditInLine", "1");
        //         JSxASTEditInLine($(this),2);
        //         console.log('xWDatePickerChange change');
        //     }
        // });

        $('.xCNPdtEditInLine').off('change');
        $('.xCNPdtEditInLine').on('change',function(){
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxASTEditInLine($(this),1);
            }
            // console.log('xCNPdtEditInLine change');
        });

        $('.xWTimepicker').datetimepicker({
            format                  : 'HH:mm:ss',
            // widgetParent            : $('.xWForm-GroupDatePicker').length > 0 ? $('.xWForm-GroupDatePicker').parent() : "body",
        }).on('dp.hide', function(){
            if(sessionStorage.getItem("EditInLine") != "2"){
                sessionStorage.setItem("EditInLine", "1");
                JSxASTEditInlineCheckTime($(this));
                // console.log('time hide');
            }
        });

    });

</script>









