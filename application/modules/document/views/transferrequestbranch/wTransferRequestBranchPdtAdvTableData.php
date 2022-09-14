<style>
    #odvRowDataEndOfBill .panel-heading{
        padding-top     : 10px !important;
        padding-bottom  : 10px !important;
    }
    #odvRowDataEndOfBill .panel-body{
        padding-top     : 0px !important;
        padding-bottom  : 0px !important;
    }
    #odvRowDataEndOfBill .list-group-item {
        padding-left    : 0px !important;
        padding-right   : 0px !important;
        border          : 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color           : #232C3D !important;
        font-weight     : 900;
    }

</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tTRBPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tTRBPunCode;?>">
        <input type="text" class="xCNHide" id="ohdTRBRtCode" value="<?php echo $aDataDocDTTemp['rtCode'];?>">
        <input type="text" class="xCNHide" id="ohdTRBStaDoc" value="<?php echo $tTRBStaDoc;?>">
        <input type="text" class="xCNHide" id="ohdTRBStaApv" value="<?php echo $tTRBStaApv;?>">
        <table id="otbTRBDocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th class="text-center" id="othCheckboxHide">
                        <label class="fancy-checkbox">
                            <input id="ocbCheckAll" type="checkbox" class="ocbListItemAll" name="ocbCheckAll" onclick="FSxTRBSelectAll(this)">
                            <span class="">&nbsp;</span>
                        </label>
                    </th>
                    <th class="xCNTextBold"><?=language('document/transferrequestbranch/transferrequestbranch','tTRBTable_pdtcode')?></th>
                    <th class="xCNTextBold"><?=language('document/transferrequestbranch/transferrequestbranch','tTRBTable_pdtname')?></th>
                    <th class="xCNTextBold"><?=language('document/transferrequestbranch/transferrequestbranch','tTRBTable_barcode')?></th>
                    <th class="xCNTextBold"><?=language('document/transferrequestbranch/transferrequestbranch','tTRBTable_qty')?></th>
                    <th class="xCNTextBold"><?=language('document/transferrequestbranch/transferrequestbranch','tTRBTable_unit')?></th>
                    <th class="xCNPIBeHideMQSS"><?php echo language('common/main/main','tCMNActionDelete')?></th>
                </tr>
            </thead>
            <tbody id="odvTBodyTRBPdtAdvTableList">
            <?php 
                if($aDataDocDTTemp['rtCode'] == 1):
                    foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): 
                        $nKey = $aDataTableVal['FNXtdSeqNo'];
            ?>
                    <tr class="otr<?=$aDataTableVal['FTPdtCode'];?><?php echo $aDataTableVal['FTXtdBarCode'];?> xWPdtItem xWPdtItemList<?=$nKey?>" 
                        data-alwvat="<?=$aDataTableVal['FTXtdVatType'];?>" 
                        data-vat="<?=$aDataTableVal['FCXtdVatRate']?>" 
                        data-key="<?=$nKey?>" 
                        data-pdtcode="<?=$aDataTableVal['FTPdtCode'];?>" 
                        data-pdtName="<?=$aDataTableVal['FTXtdPdtName'];?>" 
                        data-seqno="<?=$nKey?>" 
                        data-setprice="<?=$aDataTableVal['FCXtdSetPrice'];?>" 
                        data-qty="<?=$aDataTableVal['FCXtdQty'];?>" 
                        data-netafhd="<?=$aDataTableVal['FCXtdNetAfHD'];?>" 
                        data-net="<?=$aDataTableVal['FCXtdNet'];?>" 
                        data-stadis="<?=$aDataTableVal['FTXtdStaAlwDis'];?>" 
                    >
                        <td class="otdListItem">
                            <label class="fancy-checkbox text-center">
                                <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxTRBSelectMulDel(this)">
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </td>
                        <td><?=$aDataTableVal['FTPdtCode'];?></td>
                        <td><?=$aDataTableVal['FTXtdPdtName'];?></td>
                        <td><?=$aDataTableVal['FTXtdBarCode'];?></td>
                        <td><?=$aDataTableVal['FTPunName'];?></td>
                        <td class="otdQty">
                            <div class="xWEditInLine<?=$nKey?>">
                                <input type="text" class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine<?=$nKey?> xWShowInLine<?=$nKey?> " id="ohdQty<?=$nKey?>" name="ohdQty<?=$nKey?>" data-seq="<?=$nKey?>" data-factor="<?=$aDataTableVal['FCXtdFactor']?>" maxlength="10" value="<?=str_replace(",","",number_format($aDataTableVal['FCXtdQty'],2));?>" autocomplete="off">
                            </div>
                        </td>
                        <td nowrap="" class="text-center xCNPIBeHideMQSS">
                            <label class="xCNTextLink">
                                <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnTRBDelPdtInDTTempSingle(this)">
                            </label>
                        </td>
                    </tr>
            <?php 
                    endforeach;
                else:
            ?>
                <tr><td class="text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
            <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- ============================================ Modal Confirm Delete Documet Detail Dis ============================================ -->
    <div id="odvTRBModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('common/main/main', 'tTRBMsgNotificationChangeData') ?></label>
                </div>
                <div class="modal-body">
                    <label><?php echo language('document/purchaseorder/purchaseorder','tTRBMsgTextNotificationChangeData');?></label>
                </div>
                <div class="modal-footer">
                    <button id="obtTRBConfirmDeleteDTDis" type="button"  class="btn xCNBTNPrimery" data-dismiss="modal"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtTRBCancelDeleteDTDis" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ================================================================================================================================= -->



<!--ลบสินค้าแบบตัวเดียว-->
<div id="odvModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmTWIConfirmPdtDTTemp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!--ลบสินค้าแบบหลายตัว-->
<div id="odvModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>
<?php  //include("script/jDeliveryOrderAdd.php");?>
<?php  include("script/jTransferRequestBranchPdtAdvTableData.php");?>

<script>  
    
    $( document ).ready(function() {
        JSxAddScollBarInTablePdt();
        JSxEditQtyAndPrice();    
        if($('#ohdTRBStaApv').val()==1 && $('#ohdTRBStaDoc').val()==1){
            $('.xCNBTNPrimeryDisChgPlus').hide();
            $("#othCheckboxHide").hide();
            $(".xCNPIBeHideMQSS").hide();
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtTRBBrowseCustomer').attr('disabled',true);
            $('.otdListItem').hide();
        }else if($('#ohdTRBStaDoc').val()==3){
            $('.xCNBTNPrimeryDisChgPlus').hide();
            $("#othCheckboxHide").hide();
            $(".xCNPIBeHideMQSS").hide();
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtTRBBrowseCustomer').attr('disabled',true);
            $('.otdListItem').hide();
        }

        JSxTRBCountPdtItems()
    
    });


    // Next Func จาก Browse PDT Center
    function FSvTRBNextFuncB4SelPDT(ptPdtData){
        var aPackData = JSON.parse(ptPdtData);
        // console.log(aPackData[0]);
        for(var i=0;i<aPackData.length;i++){
            var aNewPackData = JSON.stringify(aPackData[i]);
            var aNewPackData = "["+aNewPackData+"]";
            FSvTRBAddPdtIntoDocDTTemp(aNewPackData);         // Append HMTL
            FSvTRBAddBarcodeIntoDocDTTemp(aNewPackData);     // Insert Database
        }
    }

    // Append PDT
    function FSvTRBAddPdtIntoDocDTTemp(ptPdtData){
        JCNxCloseLoading();
        var aPackData = JSON.parse(ptPdtData);
        //console.log(aPackData[0]);
        // var tCheckIteminTableClass = $('#otbTRBDocPdtAdvTableList tbody tr td').hasClass('xCNTextNotfoundDataPdtTable');
        var nTRBODecimalShow = $('#ohdTRBODecimalShow').val();
        var tCheckIteminTable = $('.xWPdtItem').length;
        if(tCheckIteminTable==0){
            $('#otbTRBDocPdtAdvTableList tbody').html('');
            var nKey    = 1;
        }else{
            var nKey    = parseInt($('#otbTRBDocPdtAdvTableList tr:last').attr('data-seqno')) + parseInt(1);
        }

        var nLen    = aPackData.length;
        var tHTML   = '';
        // var nKey    = parseInt($('#otbTRBDocPdtAdvTableList tbody tr').length) + parseInt(1);
        
        for(var i=0; i<nLen; i++){

            var oData           = aPackData[i];
            var oResult         = oData.packData;

            // console.log(oResult);

            oResult.NetAfHD     = (oResult.NetAfHD == '' || oResult.NetAfHD === undefined ? 0 : oResult.NetAfHD);
            oResult.Qty         = (oResult.Qty == '' || oResult.Qty === undefined ? 1 : oResult.Qty);
            oResult.Net         = (oResult.Net == '' || oResult.Net === undefined ? oResult.Price : oResult.Net);
            oResult.tDisChgTxt  = (oResult.tDisChgTxt == '' || oResult.tDisChgTxt === undefined ? '' : oResult.tDisChgTxt);

            var tBarCode        = oResult.Barcode;          //บาร์โค๊ด
            var tProductCode    = oResult.PDTCode;          //รหัสสินค้า
            var tProductName    = oResult.PDTName;          //ชื่อสินค้า
            var tUnitName       = oResult.PUNName;          //ชื่อหน่วยสินค้า
            var nQty            = parseInt(oResult.Qty);    //จำนวน
            var nUnitFact       = parseInt(oResult.UnitFact);    //จำนวน

            // console.log(oData);

            var tDuplicate = $('#otbTRBDocPdtAdvTableList tbody tr').hasClass('otr'+tProductCode+tBarCode);
            var InfoOthReAddPdt = $('#ocmTRBFrmInfoOthReAddPdt').val();
            if(tDuplicate == true && InfoOthReAddPdt==1){
                //ถ้าสินค้าซ้ำ ให้เอา Qty +1
                var nValOld     = $('.otr'+tProductCode+tBarCode).find('.xCNQty').val();
                var nNewValue   = parseInt(nValOld) + parseInt(1);

                // รวมสินค้าซ้ำกรณีที่เปลี่ยนจากเลือกแบบแยกรายการเป็นบวกในรายการเดียวกัน
                var tCname = 'otr'+tProductCode+tBarCode;
                $('.'+tCname).each(function (e) { 
                        if(e == '0'){
                            $(this).find('.xCNQty').val(nNewValue);
                        }
                });

                //$('.otr'+tProductCode+tBarCode).find('.xCNQty').val(nNewValue);
            }else{//ถ้าสินค้าไม่ซ้ำ ก็บวกเพิ่มต่อเลย
                //จำนวน
                var oQty = '<div class="xWEditInLine'+nKey+'">';
                    oQty += '<input ';
                    oQty += 'type="text" ';
                    oQty += 'class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine'+nKey+' xWShowInLine'+nKey+' "';
                    oQty += 'id="ohdQty'+nKey+'" ';
                    oQty += 'name="ohdQty'+nKey+'" '; 
                    oQty += 'data-seq='+nKey+' ';
                    oQty += 'data-factor='+nUnitFact+' ';
                    oQty += 'maxlength="10" '; 
                    oQty += 'value="'+nQty+'"';
                    oQty += 'autocomplete="off" >';
                    oQty += '</div>';  

                tHTML += '<tr class="otr'+tProductCode+''+tBarCode+' xWPdtItem xWPdtItemList'+nKey+'"';
                tHTML += '  data-key="'+nKey+'"';
                tHTML += '  data-pdtcode="'+tProductCode+'"';
                tHTML += '  data-seqno="'+nKey+'"';
                tHTML += '  data-qty="'+nQty+'"';

                tHTML += '>';
                tHTML += '<td class="otdListItem">';
                tHTML += '  <label class="fancy-checkbox text-center">';
                tHTML += '      <input id="ocbListItem'+nKey+'" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxTRBSelectMulDel(this)">';
                tHTML += '      <span class="ospListItem">&nbsp;</span>';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '<td>'+tProductCode+'</td>';
                tHTML += '<td>'+tProductName+'</td>';
                tHTML += '<td>'+tBarCode+'</td>';
                tHTML += '<td>'+tUnitName+'</td>';
                tHTML += '<td class="otdQty">'+oQty+'</td>';
                if($('#ohdPOSTaImport').val()==1){
                tHTML += '<td class="xTRBImportDT"> </td>';
                }
                tHTML += '<td nowrap class="text-center xCNPIBeHideMQSS">';
                tHTML += '  <label class="xCNTextLink">';
                tHTML += '      <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnTRBDelPdtInDTTempSingle(this)">';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '</tr>';
                nKey++;
            }
        }

        //สร้างตาราง
        $('#otbTRBDocPdtAdvTableList tbody').append(tHTML);

        JSxTRBCountPdtItems();
        JSxAddScollBarInTablePdt();
        JSxEditQtyAndPrice();
    }
    // Check All
    $('#ocbCheckAll').click(function(){
        if($(this).is(':checked')==true){
            $('.ocbListItem').prop('checked',true);
            $("#odvTRBMngDelPdtInTableDT #oliDOBtnDeleteMulti").removeClass("disabled");
        }else{
            $('.ocbListItem').prop('checked',false);
            $("#odvTRBMngDelPdtInTableDT #oliDOBtnDeleteMulti").addClass("disabled");
        }
    });

    function FSxTRBSelectMulDel(ptElm){
    // $('#otbTRBDocPdtAdvTableList #odvTBodyTRBPdtAdvTableList .ocbListItem').click(function(){
        let tTRBDocNo    = $('#oetTRBDocNo').val();
        let tTRBSeqNo    = $(ptElm).parents('.xWPdtItem').data('key');
        let tTRBPdtCode  = $(ptElm).parents('.xWPdtItem').data('pdtcode');
        let tTRBBarCode  = $(ptElm).parents('.xWPdtItem').data('barcode');
        var nTRBODecimalShow = $('#ohdTRBODecimalShow').val();
        // let tTRBPunCode  = $(this).parents('.xWPdtItem').data('puncode');
        $(ptElm).prop('checked', true);
        let oLocalItemDTTemp    = localStorage.getItem("TRB_LocalItemDataDelDtTemp");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("TRB_LocalItemDataDelDtTemp"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tTRBcNo'    : tTRBDocNo,
                'tSeqNo'    : tTRBSeqNo,
                'tPdtCode'  : tTRBPdtCode,
                'tBarCode'  : tTRBBarCode,
                // 'tPunCode'  : tTRBPunCode,
            });
            localStorage.setItem("TRB_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
            JSxTRBTextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStTRBFindObjectByKey(aArrayConvert[0],'tSeqNo',tTRBSeqNo);
            if(aReturnRepeat == 'None' ){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tTRBcNo'    : tTRBDocNo,
                    'tSeqNo'    : tTRBSeqNo,
                    'tPdtCode'  : tTRBPdtCode,
                    'tBarCode'  : tTRBBarCode,
                    // 'tPunCode'  : tTRBPunCode,
                });
                localStorage.setItem("TRB_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                JSxTRBTextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("TRB_LocalItemDataDelDtTemp");
                $(ptElm).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeqNo == tTRBSeqNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("TRB_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                JSxTRBTextInModalDelPdtDtTemp();
            }
        }
        JSxTRBShowButtonDelMutiDtTemp();
        // });
    }

    function JSxAddScollBarInTablePdt(){
        $('#otbTRBDocPdtAdvTableList >tbody >tr').css('background-color','#ffffff');
        var rowCount = $('#otbTRBDocPdtAdvTableList >tbody >tr').length;
            if(rowCount >= 2){
                $('#otbTRBDocPdtAdvTableList >tbody >tr').last().css('background-color','rgb(226, 243, 255)');
        
            }
            
        if(rowCount >= 7){
            $('.xWShowInLine' + rowCount).focus();

            $('html, body').animate({
                scrollTop: ($("#oetTRBInsertBarcode").offset().top)-80
            }, 0);
        }

        if($('#oetTRBFrmCstCode').val() != ''){
            $('#oetTRBInsertBarcode').focus();
        }
    }

        //เเก้ไขจำนวน
    function JSxEditQtyAndPrice() {
        $('.xCNPdtEditInLine').click(function() {
            $(this).focus().select();
        });

        // $('.xCNQty').change(function(e){
        $('.xCNQty').off().on('change keyup', function(e) {
            if(e.type === 'change' || e.keyCode === 13){
                var nSeq    = $(this).attr('data-seq');
                var nQty        = $('#ohdQty'+nSeq).val();
                nNextTab = parseInt(nSeq)+1;
                $('.xWValueEditInLine'+nNextTab).focus().select();
                
                JSxGetDisChgList(nSeq);
            }
        });

    }

    //เเก้ไขจำนวน และ ราคา
    function JSxGetDisChgList(pnSeq){

        var nQty             = $('#ohdQty'+pnSeq).val();
        var nFactor          = $('#ohdQty'+pnSeq).attr('data-factor');
        // console.log(nFactor);
        var tTRBDocNo        = $("#oetTRBDocNo").val();
        var tTRBBchCode      = $("#oetTRBFrmBchCode").val();
        if(pnSeq != undefined){
            $.ajax({
                type    : "POST",
                url     : "docTRBEditPdtInDTDocTemp",
                data    : {
                    'tTRBBchCode'        : tTRBBchCode,
                    'tTRBDocNo'          : tTRBDocNo,
                    'nTRBSeqNo'          : pnSeq,
                    'nQty'               : nQty,
                    'pnFactor'            : nFactor
                },
                catch   : false,
                timeout : 0,
                success : function (oResult){ },
                error   : function (jqXHR, textStatus, errorThrown) { }
            });
        }
    }

    $(document).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });

    function FSxTRBSelectAll(){
    if($('.ocbListItemAll').is(":checked")){
        $('.ocbListItem').each(function (e) { 
            if(!$(this).is(":checked")){
                $(this).on( "click", FSxTRBSelectMulDel(this) );
            }
    });
    }else{
        $('.ocbListItem').each(function (e) { 
            if($(this).is(":checked")){
                $(this).on( "click", FSxTRBSelectMulDel(this) );
            }
    });
    }
    
}

</script>


