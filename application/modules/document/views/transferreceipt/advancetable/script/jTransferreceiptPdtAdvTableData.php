<script type="text/javascript">

  $('document').ready(function(){

    //Put Sum HD In Footer
    $('#othFCXthTotal').text($('#ohdFCXthTotalShow').val());

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
        var tPun = $(this).parent().parent().parent().data('puncode');  //Pun
        var tBar = $(this).parent().parent().parent().data('barcode');  //BarCode
        var tDoc = $(this).parent().parent().parent().data('docno');    //Doc

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
                      "tPun": tPun,
                      "tBar": tBar               
                    });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTXIPdtTextinModal();
            
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"tSeq": tSeq, 
                          "tPdt": tPdt, 
                          "tDoc": tDoc, 
                          "tPun": tPun,
                          "tBar": tBar
                        });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTXIPdtTextinModal();
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
                JSxTXIPdtTextinModal();
            }
        }

        JSxShowButtonChoose();
    })
});
</script>