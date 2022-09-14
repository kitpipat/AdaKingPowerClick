<script>

  $(document).ready(function(){

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
            JSxTFWPdtTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"tSeq": tSeq, 
                          "tPdt": tPdt, 
                          "tDoc": tDoc, 
                          "tPun": tPun 
                        });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTFWPdtTextinModal();
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
                JSxTFWPdtTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
  });

  // Check All
  $('#ocbCheckAll').click(function(){
        if($(this).is(':checked')==true){
            $('.ocbListItem').prop('checked',true);
            $("#odvTWIMngDelPdtInTableDT #oliTWIBtnDeleteMulti").removeClass("disabled");
        }else{
            $('.ocbListItem').prop('checked',false);
            $("#odvTWIMngDelPdtInTableDT #oliTWIBtnDeleteMulti").addClass("disabled");
        }
    });

    function FSxDOSelectAll(){
        if($('.ocbListItemAll').is(":checked")){
            $('.ocbListItem').each(function (e) { 
                if(!$(this).is(":checked")){
                    $(this).on( "click", FSxDOSelectMulDel(this) );
                }
            });
        }else{
            $('.ocbListItem').each(function (e) { 
                if($(this).is(":checked")){
                    $(this).on( "click", FSxDOSelectMulDel(this) );
                }
            });
        }
    }

    //ลบสินค้าใน Tmp - หลายตัว
    function FSxDOSelectMulDel(ptElm){
        var tDoc    = $('#oetXthDocNo').val();
        var tSeq    = $(ptElm).parents('.xWPdtItem').data('seqno');
        var tPdt  = $(ptElm).parents('.xWPdtItem').data('pdtcode');
        var tPun  = $(ptElm).parents('.xWPdtItem').data('puncode');
        $(ptElm).prop('checked', true);
        let oLocalItemDTTemp    = localStorage.getItem("LocalItemData");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tDoc'    : tDoc,
                'tSeq'    : tSeq,
                'tPdt'  : tPdt,
                'tPun'  : tPun,
            });
            localStorage.setItem("LocalItemData",JSON.stringify(oDataObj));
            JSxTFWPdtTextinModal();
        }else{
            var aReturnRepeat   = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
            if(aReturnRepeat == 'None' ){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tDoc'    : tDoc,
                    'tSeq'    : tSeq,
                    'tPdt'  : tPdt,
                    'tPun'  : tPun,
                });
                localStorage.setItem("LocalItemData",JSON.stringify(oDataObj));
                JSxTFWPdtTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("LocalItemData");
                $(ptElm).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeq == tSeq){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTFWPdtTextinModal();
            }
        }
        JSxShowButtonChoose();
    
    }
    ohdXthStaApv = $("#ohdXthStaApv").val();
    ohdXthStaDoc = $("#ohdXthStaDoc").val();
    ohdXthStaPrcStk = $("#ohdXthStaPrcStk").val();

    if (ohdXthStaApv == 1 || ohdXthStaDoc == 3) {
        $(".xCNTWIBeHideMQSS").hide();
    }
</script>


