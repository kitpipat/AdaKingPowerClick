<script type="text/javascript">
   
    $('.xWPdtSetEdit').off('click');
    $('.xWPdtSetEdit').on('click',function(){
        var tPdtCode = $(this).parent().parent().data('pdtcode');
        JSxPdtSetCallPageEdit(tPdtCode);
    });

    $('.xWPdtSetDelete').off('click');
    $('.xWPdtSetDelete').on('click',function(){
        var tPdtCode = $(this).parent().parent().data('pdtcode');
        var tPdtName = $(this).parent().parent().data('pdtname');
        JSxPdtSetEventDelete(tPdtCode,tPdtName);
    });

    // $('.xWPdtSetEditInLine').click(function(){JSxClickEventEditInlineData(this);});
    // $('.xWPdtSetSaveInLine').click(function(){JSxClickEventSaveInlineData(this);});
    // $('.xWPdtSetCancelInLine').click(function(){JSxClickEventCancleInlineData(this);});
    // $('.xWPdtSetDeleteInLine').click(function(){JSxClickEventDelInlineData(this);});

    // Function : Function Add Condition Config Product Set
    // Parameters : 
    // Creator : 07/02/2019 wasin(Yoshi)
    // Return : Add Div Data Config Product Set
    // Return Type : -
    // function JSxAddRowDataConfigPdtSet(){
    //     var nPdtSetStaConfig = $('#odvPdtContentSet #odvPdtSetConfig .xWPDTSetConfig').length;
    //     if(nPdtSetStaConfig == 0){
    //         // Append Div Config Price Set
    //         $('#odvPdtContentSet #odvPdtSetConfig')
    //         .append($('<div>')
    //         .attr('id','odvPdtSetChackBoxSta')
    //         .attr('class','col-xs-12 col-sm-12 col-md-12 col-lg-12 xWPDTSetConfig')
    //             .append($('<div>')
    //             .attr('class','row')
    //                 // Append Div แสดงรายการย่อย
    //                 .append($('<div>')
    //                 .attr('class','col-xs-12 col-sm-12 col-md-2 col-lg-2')
    //                     .append($('<div>')
    //                     .attr('class','form-group')
    //                         .append($('<label>')
    //                         .attr('class','fancy-checkbox')
    //                             .append($('<input>')
    //                             .attr('type','checkbox')
    //                             .attr('id','ocbPdtStaSetShwDT')
    //                             .prop('checked',true)
    //                             )
    //                             .append($('<span>')
    //                             .text('<?php echo language("product/product/product","tPDTSetStaSetShwDT")?>')
    //                             )
    //                         )
    //                     )
    //                 )
    //                 // Append Div ใช้ราคาย่อย
    //                 .append($('<div>')
    //                 .attr('class','col-xs-12 col-sm-12 col-md-2 col-lg-2')
    //                     .append($('<div>')
    //                     .attr('class','form-group')
    //                         .append($('<label>')
    //                         .attr('class','fancy-checkbox')
    //                         .css('pointer-events','none')
    //                             .append($('<input>')
    //                             .attr('type','checkbox')
    //                             .attr('id','ocbPdtSubPrice')
    //                             .prop('checked',true)
    //                                 .click(function(){
    //                                     JSxClickEvnPdtSetSubPrice(this);
    //                                 })
    //                             )
    //                             .append($('<span>')
    //                             .text('<?php echo language("product/product/product","tPDTSetStaSetSubPri")?>')
    //                             )
    //                         )
    //                     )
    //                 )
    //                 // Append Div ใช้ราคาชุด
    //                 .append($('<div>')
    //                 .attr('class','col-xs-12 col-sm-12 col-md-2 col-lg-2')
    //                     .append($('<div>')
    //                     .attr('class','form-group')
    //                         .append($('<label>')
    //                         .attr('class','fancy-checkbox')
    //                             .append($('<input>')
    //                             .attr('type','checkbox')
    //                             .attr('id','ocbPdtSetPrice')
    //                                 .click(function(){
    //                                     JSxClickEvnPdtSetPriceSet(this);
    //                                 })
    //                             )
    //                             .append($('<span>')
    //                             .text('<?php echo language("product/product/product","tPDTSetStaSetPriSet")?>')
    //                             )
    //                         )
    //                     )
    //                 )
    //             )
    //         ).hide().fadeIn('slow')
    //     }
    // }

    // Function : Function Click Condition Congfig Product Set Sub Price (ใช้ราคาย่อย)
    // Parameters : 
    // Creator : 07/02/2019 wasin(Yoshi)
    // Return : Event Select Product Price Set
    // Return Type : -
    function JSxClickEvnPdtSetSubPrice(oEvent){
        var nStaChkSubPri   = ($(oEvent).is(':checked')) ? 1 : 0;
        if(nStaChkSubPri == 1){
            $('#ocbPdtSetPrice').prop('checked',false);
            $('#ocbPdtSetPrice').prop('readonly',false);
            $('#ocbPdtSetPrice').parent().css('pointer-events','');
            $('#ocbPdtSubPrice').prop('readonly', true);
            $('#ocbPdtSubPrice').parent().css('pointer-events','none');
        }   
    }

    // Function : Function Click Condition Congfig ProductSet Peice Set (ใช้ราคาชุด)
    // Parameters : 
    // Creator : 07/02/2019 wasin(Yoshi)
    // Return : Event Select Product Set Price Set
    // Return Type : -
    function JSxClickEvnPdtSetPriceSet(oEvent){
        var nStaChkSetPri   = ($(oEvent).is(':checked')) ? 1 : 0;
        if(nStaChkSetPri == 1){
            $('#ocbPdtSubPrice').prop('checked',false);
            $('#ocbPdtSubPrice').prop('readonly', false);
            $('#ocbPdtSubPrice').parent().css('pointer-events','');
            $('#ocbPdtSetPrice').prop('readonly', true);
            $('#ocbPdtSetPrice').parent().css('pointer-events','none');
        }
    };

    // Function : Func.Pdt Event Click Edit Inline 
    // Parameters : 
    // Creator : 07/02/2019 wasin(Yoshi)
    // Return : Call Event Edit In Line
    // Return Type : -
    function JSxClickEventEditInlineData(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tPdtSetStaEditInline    =   $('#ohdPdtSetStaEditInline').val();
            if(tPdtSetStaEditInline == 0){
                var tPdtSetPdtCode      = $(oEvent).parents('.xWPdtSetRow').data('pdtcode');
                var tLocalName          = 'LSPdtSet'+tPdtSetPdtCode;
                var oPdtSetDataLocal    = {
                    'tProductSetPdtCode' : $(oEvent).parents('.xWPdtSetRow').data('pdtcode'),
                    'tProductSetPdtName' : $(oEvent).parents('.xWPdtSetRow').data('pdtname'),
                    'tProductSetQty'     : $(oEvent).parents('.xWPdtSetRow').find('input[type=text].xCNPdtSetQty').val()
                };
                // Backup Seft Record
                localStorage.setItem(tLocalName,JSON.stringify(oPdtSetDataLocal));

                // Visibled icons
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetEditInLine').addClass('xCNHide');
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetSaveInLine').removeClass('xCNHide');
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetCancelInLine').removeClass('xCNHide');

                $(oEvent).parents('.xWPdtSetRow').find('input[type=text].xCNPdtSetQty').attr('readonly',false)
                $('#ohdPdtSetStaEditInline').val(1);
            }else{
                var tMsgEventEditInline =   '<?php echo language("product/product/product","tPDTEditInlineUse")?>';
                FSvCMNSetMsgWarningDialog(tMsgEventEditInline);
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }
    
    // Function : Func.Pdt Event Click Save Inline 
    // Parameters : 
    // Creator : 08/02/2019 wasin(Yoshi)
    // Return : Call Event Save In Line
    // Return Type : -
    function JSxClickEventSaveInlineData(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tPdtSetStaEditInline = $('#ohdPdtSetStaEditInline').val();
            if(tPdtSetStaEditInline == 1){
                var tPdtSetPdtCode  = $(oEvent).parents('.xWPdtSetRow').data('pdtcode');
                var tLocalName      = 'LSPdtSet'+tPdtSetPdtCode;

                // Remove Seft Record Backup
                localStorage.removeItem(tLocalName);
                
                // Visibled icons
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetEditInLine').removeClass('xCNHide');
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetSaveInLine').addClass('xCNHide');
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetCancelInLine').addClass('xCNHide');

                $(oEvent).parents('.xWPdtSetRow').find('input[type=text].xCNPdtSetQty').attr('readonly',true)
                $('#ohdPdtSetStaEditInline').val(0);
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function : Func.Pdt Event Click Cancle Inline 
    // Parameters : 
    // Creator : 08/02/2019 wasin(Yoshi)
    // Return : Call Event Cancle In Line
    // Return Type : -
    function JSxClickEventCancleInlineData(oEvent){
        var nStaSession = JCNxFuncChkSessionExpired();
        if(typeof(nStaSession) !== 'undefined' && nStaSession == 1){
            var tPdtSetStaEditInline = $('#ohdPdtSetStaEditInline').val();
            if(tPdtSetStaEditInline == 1){
                var tPdtSetPdtCode  = $(oEvent).parents('.xWPdtSetRow').data('pdtcode');
                var tLocalName      = 'LSPdtSet'+tPdtSetPdtCode;
                // Restore Seft Record
                var oBackupRecord   = JSON.parse(localStorage.getItem(tLocalName));
                $(oEvent).parents('.xWPdtSetRow').find('input[type=text].xCNPdtSetQty').val(oBackupRecord['tProductSetQty']);

                // Remove Seft Record Backup
                localStorage.removeItem(tLocalName);

                // Visibled icons
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetEditInLine').removeClass('xCNHide');
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetSaveInLine').addClass('xCNHide');
                $(oEvent).parents('.xWPdtSetRow').find('.xWPdtSetCancelInLine').addClass('xCNHide');

                $(oEvent).parents('.xWPdtSetRow').find('input[type=text].xCNPdtSetQty').attr('readonly',true)
                $('#ohdPdtSetStaEditInline').val(0);
            }
        }else{
            JCNxShowMsgSessionExpired();
        }
    }

    // Function : Func.Pdt Event Click Delect Inline 
    // Parameters : 
    // Creator : 08/02/2019 wasin(Yoshi)
    // Return : Call Event Cancle In Line
    // Return Type : -
    // function JSxClickEventDelInlineData(oEvent){
    //     $(oEvent).parents('.xWPdtSetRow').fadeOut('slow',function(){
    //         $(this).remove();
    //         var tPdtSetCode = '';
    //         var tPdtSetName = '';
    //         $('#odvPdtContentSet #otbPdtProductSetData tbody .xWPdtSetRow').each(function(){
    //             var tPdtCode    = $(this).data('pdtcode');
    //             var tPdtName    = $(this).data('pdtname');
    //             tPdtSetCode += tPdtCode+','
    //             tPdtSetName += tPdtName+','
    //         })
    //         $('#ohdPdtSetCode').val(tPdtSetCode.substring(0,tPdtSetCode.length - 1));
    //         $('#ohdPdtSetName').val(tPdtSetName.substring(0,tPdtSetName.length - 1));
    //         var nCoutePdtSetRow = $('#odvPdtContentSet #otbPdtProductSetData tbody .xWPdtSetRow').length;
    //         if(nCoutePdtSetRow == 0){
    //             $('#odvPdtContentSet #otbPdtProductSetData tbody').append($('<tr>')
    //             .attr('class','xWPdtSetNoData')
    //                 .append($('<td>')
    //                 .attr('class','text-center xCNTextDetail2')
    //                 .attr('colspan','99')
    //                 .text('<?php echo language("common/main/main","tCMNNotFoundData");?>')
    //                 )
    //             )
    //             $('#odvPdtSetConfig').empty();
    //         }
    //     });
    // }

</script>