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

  // function JSxEditInLinePdt(event){

  //     var tEditSeqNo = $(event).parents().eq(2).attr('data-seqno');
  //     var tEditPdtCode = $(event).parents().eq(2).attr('data-pdtcode');
  //     var tEditPunCode = $(event).parents().eq(2).attr('data-puncode');

  //     var aField = [];
  //     var aValue = [];

  //     $(".xWValueEditInLine"+tEditSeqNo).each(function(index){
  //       tValue = $(this).val();
  //       tField = $(this).attr('data-field');
  //       $('.xWShowValue'+tField+tEditSeqNo).text(tValue);
  //       aField.push(tField);
  //       aValue.push(tValue);
  //     });

  //     FSvPOEditInLinePdtDT(tEditSeqNo,aField,aValue);

  // }

  // //Function : เพิ่มสินค้าจาก ลง Table ฝั่ง Client
  // //Create : 2018-08-28 Krit(Copter)
  // function FSvPOEditInLinePdtDT(ptEditSeqNo,paField,paValue){

  //   ptXphDocNo = $('#oetXphDocNo').val();

  //   $.ajax({
  //       type: "POST",
  //       url: "POEditPdtIntoTableDT",
  //       data: { 
  //               ptXphDocNo : ptXphDocNo,
  //               ptEditSeqNo : ptEditSeqNo,
  //               paField     : paField,
  //               paValue     : paValue
  //       },
  //       cache: false,
  //       timeout: 5000,
  //       success: function(tResult){

  //         JSvPOLoadEditInLinePdtDT(ptEditSeqNo);

  //       },
  //       error: function(data) {
  //           console.log(data);
  //       }
  //   });
  // }


  // 	//Function : Gen  Html มาแปะ ในหน้า App Po
	// function JSvPOLoadEditInLinePdtDT(ptEditSeqNo){

  //   tXphDocNo = $('#oetXphDocNo').val();

  //   $.ajax({
  //       type: "POST",
  //       url: "POPdtAdvanceTableLoadData",
  //       data: { 
  //               tXphDocNo : tXphDocNo,
  //               ptEditSeqNo:ptEditSeqNo
  //             },
  //       cache: false,
  //       Timeout: 0,
  //       success: function(tResult) {
  //           //GET Value New
  //           $('#odvPdtTablePanalDataHide').html(tResult);
  //           FCXpdCostEx     = $('#odvPdtTablePanalDataHide #ohdFCXpdCostEx'+ptEditSeqNo).val();
  //           FCXpdCostIn     = $('#odvPdtTablePanalDataHide #ohdFCXpdCostIn'+ptEditSeqNo).val();
  //           FCXpdFactor     = $('#odvPdtTablePanalDataHide #ohdFCXpdFactor'+ptEditSeqNo).val();
  //           FCXpdNet        = $('#odvPdtTablePanalDataHide #ohdFCXpdNet'+ptEditSeqNo).val();
  //           FCXpdAmt        = $('#odvPdtTablePanalDataHide #ohdFCXpdAmt'+ptEditSeqNo).val();
  //           FCXpdDisChgAvi  = $('#odvPdtTablePanalDataHide #ohdFCXpdDisChgAvi'+ptEditSeqNo).val();
  //           FCXpdNetAfHD    = $('#odvPdtTablePanalDataHide #ohdFCXpdNetAfHD'+ptEditSeqNo).val();
  //           FCXpdNetEx      = $('#odvPdtTablePanalDataHide #ohdFCXpdNetEx'+ptEditSeqNo).val();
  //           FCXpdQtyAll     = $('#odvPdtTablePanalDataHide #ohdFCXpdQtyAll'+ptEditSeqNo).val();
  //           FCXpdQtyLef     = $('#odvPdtTablePanalDataHide #ohdFCXpdQtyLef'+ptEditSeqNo).val();
  //           FCXpdQtyRfn     = $('#odvPdtTablePanalDataHide #ohdFCXpdQtyRfn'+ptEditSeqNo).val();
  //           FCXpdSalePrice  = $('#odvPdtTablePanalDataHide #ohdFCXpdSalePrice'+ptEditSeqNo).val();
  //           FCXpdStkFac     = $('#odvPdtTablePanalDataHide #ohdFCXpdStkFac'+ptEditSeqNo).val();
  //           FCXpdVatable    = $('#odvPdtTablePanalDataHide #ohdFCXpdVatable'+ptEditSeqNo).val();
  //           FCXpdVatRate    = $('#odvPdtTablePanalDataHide #ohdFCXpdVatRate'+ptEditSeqNo).val();
  //           FCXpdVat        = $('#odvPdtTablePanalDataHide #ohdFCXpdVat'+ptEditSeqNo).val();
  //           FCXpdWhtRate    = $('#odvPdtTablePanalDataHide #ohdFCXpdWhtRate'+ptEditSeqNo).val();
  //           FCXpdWhtAmt     = $('#odvPdtTablePanalDataHide #ohdFCXpdWhtAmt'+ptEditSeqNo).val();
  //           FTPunCode       = $('#odvPdtTablePanalDataHide #ohdFTPunCode'+ptEditSeqNo).val();
  //           FTSrnCode       = $('#odvPdtTablePanalDataHide #ohdFTSrnCode'+ptEditSeqNo).val();
  //           FTVatCode       = $('#odvPdtTablePanalDataHide #ohdFTVatCode'+ptEditSeqNo).val();
  //           FTXpdRmk        = $('#odvPdtTablePanalDataHide #ohdFTXpdRmk'+ptEditSeqNo).val();
  //           FTXpdStkCode    = $('#odvPdtTablePanalDataHide #ohdFTXpdStkCode'+ptEditSeqNo).val();
  //           FTXpdVatType    = $('#odvPdtTablePanalDataHide #ohdFTXpdVatType'+ptEditSeqNo).val();
  //           FTXpdWhtCode    = $('#odvPdtTablePanalDataHide #ohdFTXpdWhtCode'+ptEditSeqNo).val();

  //           $('#odvPdtTablePanalDataHide').html('');

  //           //Set New Value
  //           //FCXpdCostEx
  //           $('.xWShowValueFCXpdCostEx'+ptEditSeqNo).text(FCXpdCostEx);
  //           $('#ohdFCXpdCostEx'+ptEditSeqNo).val(FCXpdCostEx);
  //           //FCXpdCostIn
  //           $('.xWShowValueFCXpdCostIn'+ptEditSeqNo).text(FCXpdCostIn);
  //           $('#ohdFCXpdCostIn'+ptEditSeqNo).val(FCXpdCostIn);
  //           //FCXpdFactor
  //           $('.xWShowValueFCXpdFactor'+ptEditSeqNo).text(FCXpdFactor);
  //           $('#ohdFCXpdFactor'+ptEditSeqNo).val(FCXpdFactor);
  //           //FCXpdNet
  //           $('.xWShowValueFCXpdNet'+ptEditSeqNo).text(FCXpdNet);
  //           $('#ohdFCXpdNet'+ptEditSeqNo).val(FCXpdNet);
  //           //FCXpdAmt
  //           $('.xWShowValueFCXpdAmt'+ptEditSeqNo).text(FCXpdAmt);
  //           $('#ohdFCXpdAmt'+ptEditSeqNo).val(FCXpdAmt);
  //           //FCXpdDisChgAvi
  //           $('.xWShowValueFCXpdDisChgAvi'+ptEditSeqNo).text(FCXpdDisChgAvi);
  //           $('#ohdFCXpdDisChgAvi'+ptEditSeqNo).val(FCXpdDisChgAvi);
  //           //FCXpdNetAfHD
  //           $('.xWShowValueFCXpdNetAfHD'+ptEditSeqNo).text(FCXpdNetAfHD);
  //           $('#ohdFCXpdNetAfHD'+ptEditSeqNo).val(FCXpdNetAfHD);
  //           //FCXpdNetEx
  //           $('.xWShowValueFCXpdNetEx'+ptEditSeqNo).text(FCXpdNetEx);
  //           $('#ohdFCXpdNetEx'+ptEditSeqNo).val(FCXpdNetEx);
  //           //FCXpdQtyAll
  //           $('.xWShowValueFCXpdQtyAll'+ptEditSeqNo).text(FCXpdQtyAll);
  //           $('#ohdFCXpdQtyAll'+ptEditSeqNo).val(FCXpdQtyAll);
  //           //FCXpdQtyLef
  //           $('.xWShowValueFCXpdQtyLef'+ptEditSeqNo).text(FCXpdQtyLef);
  //           $('#ohdFCXpdQtyLef'+ptEditSeqNo).val(FCXpdQtyLef);
  //           //FCXpdQtyRfn
  //           $('.xWShowValueFCXpdQtyRfn'+ptEditSeqNo).text(FCXpdQtyRfn);
  //           $('#ohdFCXpdQtyRfn'+ptEditSeqNo).val(FCXpdQtyRfn);
  //           //FCXpdSalePrice
  //           $('.xWShowValueFCXpdSalePrice'+ptEditSeqNo).text(FCXpdSalePrice);
  //           $('#ohdFCXpdSalePrice'+ptEditSeqNo).val(FCXpdSalePrice);
  //           //FCXpdStkFac
  //           $('.xWShowValueFCXpdStkFac'+ptEditSeqNo).text(FCXpdStkFac);
  //           $('#ohdFCXpdStkFac'+ptEditSeqNo).val(FCXpdStkFac);
  //           //FCXpdVatable
  //           $('.xWShowValueFCXpdVatable'+ptEditSeqNo).text(FCXpdVatable);
  //           $('#ohdFCXpdVatable'+ptEditSeqNo).val(FCXpdVatable);
  //           //FCXpdVatRate
  //           $('.xWShowValueFCXpdVatRate'+ptEditSeqNo).text(FCXpdVatRate);
  //           $('#ohdFCXpdVatRate'+ptEditSeqNo).val(FCXpdVatRate);
  //           //FCXpdVat
  //           $('.xWShowValueFCXpdVat'+ptEditSeqNo).text(FCXpdVat);
  //           $('#ohdFCXpdVat'+ptEditSeqNo).val(FCXpdVat);
  //           //FCXpdWhtRate
  //           $('.xWShowValueFCXpdWhtRate'+ptEditSeqNo).text(FCXpdWhtRate);
  //           $('#ohdFCXpdWhtRate'+ptEditSeqNo).val(FCXpdWhtRate);
  //           //FCXpdWhtAmt
  //           $('.xWShowValueFCXpdWhtAmt'+ptEditSeqNo).text(FCXpdWhtAmt);
  //           $('#ohdFCXpdWhtAmt'+ptEditSeqNo).val(FCXpdWhtAmt);
  //           //FTPunCode
  //           $('.xWShowValueFTPunCode'+ptEditSeqNo).text(FTPunCode);
  //           $('#ohdFTPunCode'+ptEditSeqNo).val(FTPunCode);
  //           //FTSrnCode
  //           $('.xWShowValueFTSrnCode'+ptEditSeqNo).text(FTSrnCode);
  //           $('#ohdFTSrnCode'+ptEditSeqNo).val(FTSrnCode);
  //           //FTVatCode
  //           $('.xWShowValueFTVatCode'+ptEditSeqNo).text(FTVatCode);
  //           $('#ohdFTVatCode'+ptEditSeqNo).val(FTVatCode);
  //           //FTXpdRmk
  //           $('.xWShowValueFTXpdRmk'+ptEditSeqNo).text(FTXpdRmk);
  //           $('#ohdFTXpdRmk'+ptEditSeqNo).val(FTXpdRmk);
  //           //FTXpdStkCode
  //           $('.xWShowValueFTXpdStkCode'+ptEditSeqNo).text(FTXpdStkCode);
  //           $('#ohdFTXpdStkCode'+ptEditSeqNo).val(FTXpdStkCode);
  //           //FTXpdVatType
  //           $('.xWShowValueFTXpdVatType'+ptEditSeqNo).text(FTXpdVatType);
  //           $('#ohdFTXpdVatType'+ptEditSeqNo).val(FTXpdVatType);
  //           //FTXpdWhtCode
  //           $('.xWShowValueFTXpdWhtCode'+ptEditSeqNo).text(FTXpdWhtCode);
  //           $('#ohdFTXpdWhtCode'+ptEditSeqNo).val(FTXpdWhtCode);

  //           //Load HDDis Table Panal และ Modal
  //           JSvPOCallGetHDDisTableData();

  //           JCNxCloseLoading();
  //       },
  //       error: function(jqXHR, textStatus, errorThrown) {
  //       }
  //   });

  // }

  // $('.xWPOBrowseDisType').click(function(ele){

  //       var nKey   = $(this).parents().eq(4).attr('data-index');
  //       var tDocNo   = $('#oetXphDocNo').val();
  //       var tPdtName = $(this).parents().eq(4).attr('data-pdtname');
  //       var nSeqNo = $(this).parents().eq(4).attr('data-seqno');


  //           $('#ospShowPdtName').text(tPdtName);
  //           $('#odvModalEditPODisDT').modal('show');
        
  //       JSvPOCallGetDTDisTableData(nKey,tDocNo,nSeqNo);

  // });

  // function JSvPOCallGetDTDisTableData(pnKey,ptDocNo,pnSeqNo){
    
  //               $.ajax({
  //               type: "POST",
  //               url: "POGetDTDisTableData",
  //               data: { 'nKey'    : pnKey,
  //                       'tDocNo'  : ptDocNo,
  //                       'nSeqNo'  : pnSeqNo
  //               },
  //               cache: false,
  //               success: function(tResult) {
                  
  //                 $('#odvPdtDisListPanal').html(tResult);

  //                 //Load HDDis Table Panal แลt Modal
  //                 JSvPOCallGetHDDisTableData();

  //               },
  //               error: function(jqXHR, textStatus, errorThrown) {
  //                   (jqXHR, textStatus, errorThrown);
  //               }
  //           });

  // }

  // function FSvPOAddDTDis(){

  //   tDisChgText = $('#ostXphDisChgText').val();
  //   cXddDis     = $('#oetXddDis').val();
  //   ptXphDocNo  = $('#oetXphDocNo').val();
  //   ptBchCode   = $('#ohdSesUsrBchCode').val();
  //   pnKey       = $('#ohdnKey').val();
  //   ptSeqNo     = $('#ohdSeqNo').val();
  //   ptXpdSeqNo  = $('#ohdXpdSeqNo').val();
    
  //   ptXpdDisChgAvi   = $('#ohdXpdDisChgAvi').val();

  //   nPlusOld = '';
  //   nPercentOld = '';
  //   tPlusNew = '';
  //   nPercentNew = '';
  //   tOldDisDTChgLength = '';

  //   if(tDisChgText == 1 || tDisChgText == 2){
  //     tPlusNew = '+';
  //   }
  //   if(tDisChgText == 2 || tDisChgText == 4){
	// 	  nPercentNew = '%';
	//   }

  //   //หา length ที่มีอยู่ ของ HD
  //   $('.xWAlwEditXpdDTDisChgValue').each(function(e){
  //     nDistypeOld = $(this).data('distype');
  //     if(nDistypeOld == 1 || nDistypeOld == 2){
  //       nPlusOld = '+';
  //     }
  //     if(nDistypeOld == 2 || nDistypeOld == 4){
  //       nPercentOld = '%';
  //     }
  //     tOldDisDTChgLength += nPlusOld+$(this).text()+nPercentOld+','
  //   });
  //   tNewDisDTChgLength = tPlusNew+accounting.formatNumber(cXddDis, nOptDecimalSave,"")+nPercentNew;
  //   //เอาทั้งสองมาต่อกัน
  //   tCurDisDTChgLength = tOldDisDTChgLength+tNewDisDTChgLength
  //   //หาจำนวนตัวอักษร
  //   nCurDisDTChgLength = tCurDisDTChgLength.length;

  //   if(cXddDis == ''){
  //     $('#oetXddDis').focus();
  //   }else{
  //     //Check ขนาดของ Text DisChgText
  //     if(nCurDisDTChgLength <= 20){
  //       $.ajax({
  //         type: "POST",
  //         url: "POAddDTDisIntoTable",
  //         data: {
  //                 ptXphDocNo  : ptXphDocNo,
  //                 ptBchCode   : ptBchCode,
  //                 pnKey       : pnKey,
  //                 ptXpdSeqNo  : ptXpdSeqNo,
  //                 ptXpdDisChgAvi : ptXpdDisChgAvi,
  //                 tDisChgText : tDisChgText,
  //                 cXddDis     : cXddDis
  //         },
  //         cache: false,
  //         timeout: 5000,
  //         success: function(tResult){
              
  //             JSvPOCallGetDTDisTableData(pnKey,ptXphDocNo,ptSeqNo);

  //         },
  //         error: function(data) {
  //             console.log(data);
  //         }
  //       });
  //     }else{
  //       alert('ไม่สามารถเพิ่มได้ จำนวนขนาดเกิน 20');
  //     }
  //   }
  // }

</script>


