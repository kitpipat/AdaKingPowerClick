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
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tPAMPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tPAMPunCode;?>">
        <input type="text" class="xCNHide" id="ohdPAMRtCode" value="<?php echo $aDataDocDTTemp['rtCode'];?>">
        <input type="text" class="xCNHide" id="ohdPAMStaDoc" value="<?php echo $tPAMStaDoc;?>">
        <input type="text" class="xCNHide" id="ohdPAMStaApv" value="<?php echo $tPAMStaApv;?>">
        <table id="otbPAMDocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th class="text-center" id="othCheckboxHide">
                        <label class="fancy-checkbox">
                            <input id="ocbCheckAll" type="checkbox" class="ocbListItemAll" name="ocbCheckAll" onclick="FSxPAMSelectAll(this)">
                            <span class="">&nbsp;</span>
                        </label>
                    </th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_pdtcode')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_pdtname')?></th>
                    <th nowrap class="xCNTextBold"><?=language('document/productarrangement/productarrangement','หมายเลขซีเรียล')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_qty')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','tPAMTable_barcode')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','จำนวน')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','จำนวนจัด')?></th>
                    <th class="xCNTextBold"><?=language('document/productarrangement/productarrangement','หมายเหตุ')?></th>
                    <th class="xCNPIBeHideMQSS"><?php echo language('common/main/main','tCMNActionDelete')?></th>
                </tr>
            </thead>
            <tbody id="odvTBodyPAMPdtAdvTableList">
            <?php 
                if($aDataDocDTTemp['rtCode'] == 1):
                    foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): 
                        $nKey = $aDataTableVal['FNXtdSeqNo'];

                        if( ($aDataTableVal['FTXtdPdtSetOrSN'] == '3' || $aDataTableVal['FTXtdPdtSetOrSN'] == '4') && $aAlwEnterSN === true ){
                            $tShwPdtSN      = '<a href="#" class="xWPAMViewPdtSN"><u>หมายเลขซีเรียล</u></a>';
                            $tDisabledQty   = "disabled";
                        }else{
                            $tShwPdtSN      =  "-";
                            $tDisabledQty   = "";
                        }
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
                        data-barcode="<?=$aDataTableVal['FTXtdBarCode'];?>"
                    >
                        <td class="otdListItem">
                            <label class="fancy-checkbox text-center">
                                <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxPAMSelectMulDel(this)">
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </td>
                        <td><?=$aDataTableVal['FTPdtCode'];?></td>
                        <td><?=$aDataTableVal['FTXtdPdtName'];?></td>
                        <td nowrap><?=$tShwPdtSN?></td>
                        <td><?=$aDataTableVal['FTPunName'];?></td>
                        <td><?=$aDataTableVal['FTXtdBarCode'];?></td>
                        <td class="text-right"><?=number_format($aDataTableVal['FCXtdQtyOrd'],$nOptDecimalShow);?></td>
                        <td class="otdQty">
                            <div class="xWEditInLine<?=$nKey?>">
                                <input  type="text" 
                                        class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine<?=$nKey?> xWShowInLine<?=$nKey?>" 
                                        id="ohdQty<?=$nKey?>" 
                                        name="ohdQty<?=$nKey?>" 
                                        data-seq="<?=$nKey?>" 
                                        data-factor="<?=str_replace(",","",number_format($aDataTableVal['FCXtdFactor'],$nOptDecimalShow));?>"
                                        data-qtyord="<?=str_replace(",","",number_format($aDataTableVal['FCXtdQtyOrd'],$nOptDecimalShow));?>" 
                                        maxlength="10" 
                                        value="<?=str_replace(",","",number_format($aDataTableVal['FCXtdQty'],$nOptDecimalShow));?>" 
                                        autocomplete="off"
                                        <?=$tDisabledQty?>
                                >
                            </div>
                        </td>
                        <td class="otdRmk">
                            <div class="xWEditInLineRmk<?=$nKey?>">
                                <input  type="text" 
                                        class="xCNRmk form-control xCNPdtEditInLine text-left xWRemarkEditInLine<?=$nKey?>" 
                                        id="ohdRmk<?=$nKey?>" 
                                        name="ohdRmk<?=$nKey?>" 
                                        data-seq="<?=$nKey?>" 
                                        maxlength="200" 
                                        value="<?=$aDataTableVal['FTXtdRmk']?>" 
                                        autocomplete="off"
                                >
                            </div>
                        </td>
                        <td nowrap="" class="text-center xCNPIBeHideMQSS">
                            <label class="xCNTextLink">
                                <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnPAMDelPdtInDTTempSingle(this)">
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
    <div id="odvPAMModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('common/main/main', 'tPAMMsgNotificationChangeData') ?></label>
                </div>
                <div class="modal-body">
                    <label><?php echo language('document/purchaseorder/purchaseorder','tPAMMsgTextNotificationChangeData');?></label>
                </div>
                <div class="modal-footer">
                    <button id="obtPAMConfirmDeleteDTDis" type="button"  class="btn xCNBTNPrimery" data-dismiss="modal"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtPAMCancelDeleteDTDis" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'ยกเลิก');?></button>
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
<?php  //include("script/jProductArrangementAdd.php");?>
<?php  include("script/jProductArrangementPdtAdvTableData.php");?>

<script>  
    
    $( document ).ready(function() {
        JSxAddScollBarInTablePdt();
        JSxEditQtyAndPrice();
        
        var tStaApv     = $('#ohdPAMStaApv').val();
        var tStaDoc     = $('#ohdPAMStaDoc').val();
        var tStaDocAuto = $('#ohdPAMStaDocAuto').val();

        if( (tStaDoc == '3') || (tStaApv == '1' && tStaDoc == '1') || tStaDocAuto == '1' ){
            $('.xCNBTNPrimeryDisChgPlus').hide();
            $("#othCheckboxHide").hide();
            $(".xCNPIBeHideMQSS").hide();
            $(".xCNIconTable").attr("onclick", "").unbind("click");
            // $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtPAMBrowseCustomer').attr('disabled',true);
            $('.otdListItem').hide();
        }

        //     ไม่ยกเลิก       หรือ        รออนุมัติ และเอกสารสมบูรณ์     หรือ     GenAuto
        if( (tStaDoc != '3') || (tStaApv != '1' && tStaDoc == '1') || tStaDocAuto == '1' ){
            $('.xCNPdtEditInLine').attr('readonly',false); // เปิด input key DT
        }


        if( (tStaDoc == '3') || (tStaApv == '1' && tStaDoc == '1') ){
            $('.xCNPdtEditInLine').attr('readonly',true);
        }

        JSxPAMCountPdtItems()
    
    });


    // Next Func จาก Browse PDT Center
    function FSvPAMNextFuncB4SelPDT(ptPdtData){
        var aPackData = JSON.parse(ptPdtData);
        // console.log(aPackData[0]);
        for(var i=0;i<aPackData.length;i++){
            var aNewPackData = JSON.stringify(aPackData[i]);
            var aNewPackData = "["+aNewPackData+"]";
            FSvPAMAddPdtIntoDocDTTemp(aNewPackData);         // Append HMTL
            FSvPAMAddBarcodeIntoDocDTTemp(aNewPackData);     // Insert Database
        }
    }

    // Append PDT
    function FSvPAMAddPdtIntoDocDTTemp(ptPdtData){
        JCNxCloseLoading();
        var aPackData = JSON.parse(ptPdtData);
        //console.log(aPackData[0]);
        var tCheckIteminTableClass = $('#otbPAMDocPdtAdvTableList tbody tr td').hasClass('xCNTextNotfoundDataPdtTable');
        var nPAMODecimalShow = $('#ohdPAMODecimalShow').val();
        // var tCheckIteminTable = $('#otbPAMDocPdtAdvTableList tbody tr').length;
        if(tCheckIteminTableClass==true){
            $('#otbPAMDocPdtAdvTableList tbody').html('');
            var nKey    = 1;
        }else{
            var nKey    = parseInt($('#otbPAMDocPdtAdvTableList tr:last').attr('data-seqno')) + parseInt(1);
        }

        var nLen    = aPackData.length;
        var tHTML   = '';
        // var nKey    = parseInt($('#otbPAMDocPdtAdvTableList tbody tr').length) + parseInt(1);
        
        for(var i=0; i<nLen; i++){

            var oData           = aPackData[i];
            var oResult         = oData.packData;

            //console.log(oResult);

            oResult.NetAfHD     = (oResult.NetAfHD == '' || oResult.NetAfHD === undefined ? 0 : oResult.NetAfHD);
            oResult.Qty         = (oResult.Qty == '' || oResult.Qty === undefined ? 1 : oResult.Qty);
            oResult.Net         = (oResult.Net == '' || oResult.Net === undefined ? oResult.Price : oResult.Net);
            oResult.tDisChgTxt  = (oResult.tDisChgTxt == '' || oResult.tDisChgTxt === undefined ? '' : oResult.tDisChgTxt);

            var tBarCode        = oResult.Barcode;          //บาร์โค๊ด
            var tProductCode    = oResult.PDTCode;          //รหัสสินค้า
            var tProductName    = oResult.PDTName;          //ชื่อสินค้า
            var tUnitName       = oResult.PUNName;          //ชื่อหน่วยสินค้า
            var nQty            = parseInt(oResult.Qty);             //จำนวน

            // console.log(oData);

            var tDuplicate = $('#otbPAMDocPdtAdvTableList tbody tr').hasClass('otr'+tProductCode+tBarCode);
            var InfoOthReAddPdt = $('#ocmPAMFrmInfoOthReAddPdt').val();
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
                tHTML += '      <input id="ocbListItem'+nKey+'" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxPAMSelectMulDel(this)">';
                tHTML += '      <span class="ospListItem">&nbsp;</span>';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '<td>'+tProductCode+'</td>';
                tHTML += '<td>'+tProductName+'</td>';
                tHTML += '<td>'+tBarCode+'</td>';
                tHTML += '<td>'+tUnitName+'</td>';
                tHTML += '<td class="otdQty">'+oQty+'</td>';
                if($('#ohdPOSTaImport').val()==1){
                tHTML += '<td class="xPAMImportDT"> </td>';
                }
                tHTML += '<td nowrap class="text-center xCNPIBeHideMQSS">';
                tHTML += '  <label class="xCNTextLink">';
                tHTML += '      <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnPAMDelPdtInDTTempSingle(this)">';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '</tr>';
                nKey++;
            }
        }

        //สร้างตาราง
        $('#otbPAMDocPdtAdvTableList tbody').append(tHTML);

        JSxPAMCountPdtItems();
        JSxAddScollBarInTablePdt();
        JSxEditQtyAndPrice();
    }
    // Check All
    $('#ocbCheckAll').click(function(){
        if($(this).is(':checked')==true){
            $('.ocbListItem').prop('checked',true);
            $("#odvPAMMngDelPdtInTableDT #oliPAMBtnDeleteMulti").removeClass("disabled");
        }else{
            $('.ocbListItem').prop('checked',false);
            $("#odvPAMMngDelPdtInTableDT #oliPAMBtnDeleteMulti").addClass("disabled");
        }
    });

    function FSxPAMSelectMulDel(ptElm){
    // $('#otbPAMDocPdtAdvTableList #odvTBodyPAMPdtAdvTableList .ocbListItem').click(function(){
        let tPAMDocNo    = $('#oetPAMDocNo').val();
        let tPAMSeqNo    = $(ptElm).parents('.xWPdtItem').data('key');
        let tPAMPdtCode  = $(ptElm).parents('.xWPdtItem').data('pdtcode');
        let tPAMBarCode  = $(ptElm).parents('.xWPdtItem').data('barcode');
        var nPAMODecimalShow = $('#ohdPAMODecimalShow').val();
        // let tPAMPunCode  = $(this).parents('.xWPdtItem').data('puncode');
        $(ptElm).prop('checked', true);
        let oLocalItemDTTemp    = localStorage.getItem("PAM_LocalItemDataDelDtTemp");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("PAM_LocalItemDataDelDtTemp"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tDocNo'    : tPAMDocNo,
                'tSeqNo'    : tPAMSeqNo,
                'tPdtCode'  : tPAMPdtCode,
                'tBarCode'  : tPAMBarCode,
                // 'tPunCode'  : tPAMPunCode,
            });
            localStorage.setItem("PAM_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
            JSxPAMTextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStPAMFindObjectByKey(aArrayConvert[0],'tSeqNo',tPAMSeqNo);
            if(aReturnRepeat == 'None' ){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tDocNo'    : tPAMDocNo,
                    'tSeqNo'    : tPAMSeqNo,
                    'tPdtCode'  : tPAMPdtCode,
                    'tBarCode'  : tPAMBarCode,
                    // 'tPunCode'  : tPAMPunCode,
                });
                localStorage.setItem("PAM_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                JSxPAMTextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("PAM_LocalItemDataDelDtTemp");
                $(ptElm).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeqNo == tPAMSeqNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("PAM_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                JSxPAMTextInModalDelPdtDtTemp();
            }
        }
        JSxPAMShowButtonDelMutiDtTemp();
        // });
    }

    function JSxAddScollBarInTablePdt(){
        $('#otbPAMDocPdtAdvTableList >tbody >tr').css('background-color','#ffffff');
        var rowCount = $('#otbPAMDocPdtAdvTableList >tbody >tr').length;
            if(rowCount >= 2){
                $('#otbPAMDocPdtAdvTableList >tbody >tr').last().css('background-color','rgb(226, 243, 255)');
        
            }
            
        if(rowCount >= 7){
            $('.xWShowInLine' + rowCount).focus();

            $('html, body').animate({
                scrollTop: ($("#oetPAMInsertBarcode").offset().top)-80
            }, 0);
        }

        if($('#oetPAMFrmCstCode').val() != ''){
            $('#oetPAMInsertBarcode').focus();
        }
    }

    var tStaEditInline = '2';

    //เเก้ไขจำนวน
    function JSxEditQtyAndPrice() {
        $('.xCNPdtEditInLine').click(function() {
            $(this).focus().select();
        });

        // $('.xCNQty').change(function(e){
        $('.xCNQty').off().on('change keypress', function(e) {
            if(e.type === 'change' || e.keyCode === 13){
                if( tStaEditInline == '2' ){
                    tStaEditInline = '1';
                    // console.log('Type: '+e.type);
                    // console.log('keyCode: '+e.keyCode);

                    var nSeq        = $(this).attr('data-seq');
                    var nQty        = parseFloat($('#ohdQty'+nSeq).val());
                    var cFactor     = $(this).attr('data-factor');
                    var cQtyOrd     = parseFloat($(this).attr('data-qtyord'));
                    // var nDocType    = $('#ohdPAMDocType').val();
                    var tAlwQtyPickNotEqQtyOrd = $('#ohdPAMAlwQtyPickNotEqQtyOrd').val();

                    // console.log('nQty: '+nQty);
                    // console.log('cQtyOrd: '+cQtyOrd);
                    // console.log('nDocType: '+nDocType);

                    // ใบจัดสินค้าที่เกิดจากใบขาย จัดสินค้าได้ไม่เกินจำนวนใบขาย
                    // if( nDocType == '2' ){
                    if( tAlwQtyPickNotEqQtyOrd == 'false' ){ //อนุญาตจัดสินค้าไม่เท่ากับจำนวนสั่ง
                        if( nQty > cQtyOrd ){
                            $('#ohdQty'+nSeq).val(cQtyOrd);
                            JSxPAMPdtEditInline('Qty',nSeq,cQtyOrd,cFactor);
                            setTimeout(function(){ 
                                tStaEditInline = '2';
                            }, 500);
                            return;
                        }
                    }
                    // }

                    var nNextTab    = parseInt(nSeq)+1;
                    $('.xWValueEditInLine'+nNextTab).focus().select();
                    JSxPAMPdtEditInline('Qty',nSeq,nQty,cFactor);
                }
            }
        });

        $('.xCNRmk').off().on('change keypress', function(e) {
            if(e.type === 'change' || e.keyCode === 13){
                if( tStaEditInline == '2' ){
                    tStaEditInline = '1';
                    // console.log('Type: '+e.type);
                    // console.log('keyCode: '+e.keyCode);

                    var nSeq        = $(this).attr('data-seq');
                    var tRmk        = $('#ohdRmk'+nSeq).val();
                    var nNextTab    = parseInt(nSeq)+1;
                    $('.xWRemarkEditInLine'+nNextTab).focus().select();
                    JSxPAMPdtEditInline('Rmk',nSeq,tRmk,0);
                }
            }
        });

    }

    //เเก้ไขจำนวน และ ราคา
    function JSxPAMPdtEditInline(ptType,pnSeq,ptValue,pcFactor){
        if(pnSeq != undefined){
            $.ajax({
                type    : "POST",
                url     : "docPAMEditPdtInDTDocTemp",
                data    : {
                    'tPAMBchCode'   : $("#ohdPAMBchCode").val(),
                    'tPAMDocNo'     : $("#oetPAMDocNo").val(),

                    'tPAMType'      : ptType,
                    'nPAMSeqNo'     : pnSeq,
                    'tPAMValue'     : ptValue,
                    'cPAMFactor'    : pcFactor
                },
                catch   : false,
                timeout : 0,
                success : function (oResult){
                    tStaEditInline = '2';
                },
                error   : function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
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

    function FSxPAMSelectAll(){
    if($('.ocbListItemAll').is(":checked")){
        $('.ocbListItem').each(function (e) { 
            if(!$(this).is(":checked")){
                $(this).on( "click", FSxPAMSelectMulDel(this) );
            }
    });
    }else{
        $('.ocbListItem').each(function (e) { 
            if($(this).is(":checked")){
                $(this).on( "click", FSxPAMSelectMulDel(this) );
            }
    });
    }
    
}

</script>


