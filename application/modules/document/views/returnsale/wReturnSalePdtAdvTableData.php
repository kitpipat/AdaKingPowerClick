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

    .xCNBTNPrimeryDisChgPlus{
        border-radius   : 50%;
        float           : left;
        width           : 20px;
        height          : 20px;
        line-height     : 20px;
        background-color: #1eb32a;
        text-align      : center;
        margin-top      : 6px;
        font-size       : 22px;
        color           : #ffffff;
        cursor          : pointer;
        -webkit-border-radius   : 50%;
        -moz-border-radius      : 50%;
        -ms-border-radius       : 50%;
        -o-border-radius        : 50%;
    }
</style>
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive xCNTablescroll">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tRSPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tRSPunCode;?>">
        <table id="otbRSDocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th><?php echo language('document/returnsale/returnsale','tRSTBChoose')?></th>
                    <!-- <th class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBNo')?></th> -->
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_pdtcode')?></th>
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_pdtname')?></th>
                    <!-- <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_barcode')?></th> -->
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_unit')?></th>
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_qty')?></th>
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_price')?></th>
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_discount')?></th>
                    <th class="xCNTextBold"><?=language('document/returnsale/returnsale','tRSTable_grand')?></th>

                    <th class="xCNPIBeHideMQSS"><?php echo language('document/returnsale/returnsale', 'tRSTBDelete');?></th>
                    <!-- <th class="xCNPIBeHideMQSS xWPIDeleteBtnEditButtonPdt"><?php echo language('document/returnsale/returnsale','tRSTBEdit');?></th> -->
                </tr>
            </thead>
            <tbody id="odvTBodyRSPdtAdvTableList">
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
                        data-seqno="<?=$nKey?>" 
                        data-setprice="<?=number_format($aDataTableVal['FCXtdSetPrice'],2);?>" 
                        data-qty="<?=$aDataTableVal['FCXtdQty'];?>" 
                        data-netafhd="<?=number_format($aDataTableVal['FCXtdNetAfHD'],2);?>" 
                        data-net="<?=number_format($aDataTableVal['FCXtdNet'],2);?>" 
                        data-stadis="<?=$aDataTableVal['FTXtdStaAlwDis'];?>" 
                        style="background-color: rgb(255, 255, 255);" 
                    >
                        <td>
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxRSSelectMulDel(this)">
                                <span class="ospListItem">&nbsp;</span>
                            </label>
                        </td>
                        <!-- <td><?=$nKey?></td> -->
                        <td><?=$aDataTableVal['FTPdtCode'];?></td>
                        <td><?=$aDataTableVal['FTXtdPdtName'];?></td>
                        <!-- <td><?=$aDataTableVal['FTXtdBarCode'];?></td> -->
                        <td><?=$aDataTableVal['FTPunName'];?></td>
                        <td class="otdQty">
                            <div class="xWEditInLine<?=$nKey?>">
                                <input type="text" class="xCNQty form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine<?=$nKey?> xWShowInLine<?=$nKey?> " id="ohdQty<?=$nKey?>" name="ohdQty<?=$nKey?>" data-seq="<?=$nKey?>" maxlength="10" value="<?=str_replace(",","",number_format($aDataTableVal['FCXtdQty'],2));?>" autocomplete="off">
                            </div>
                        </td>
                        <td class="text-right">
                            <div  style="display:none" class="xWEditInLine<?=$nKey?>">
                                <input type="text" class="xCNPrice form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine<?=$nKey?> " id="ohdPrice<?=$nKey?>" name="ohdPrice<?=$nKey?>" maxlength="10" data-alwdis="<?=$aDataTableVal['FTXtdStaAlwDis'];?>" data-seq="<?=$nKey?>" value="<?=str_replace(",","",number_format($aDataTableVal['FCXtdSetPrice'],2));?>" autocomplete="off">
                            </div>
                            <span id="ospPrice<?=$nKey?>"><?=number_format($aDataTableVal['FCXtdSetPrice'],2);?></span>
                        </td>
                        <td>
                        <?php 
                            if($aDataTableVal['FTXtdStaAlwDis'] == 1): 
                        ?>
                            <div>
                                <button class="xCNBTNPrimeryDisChgPlus" onclick="JCNvRSCallModalDisChagDT(this)" type="button">+</button>
                                <label class="xWDisChgDTTmp" style="padding-left: 5px;padding-top: 3px;" id="xWDisChgDTTmp<?=$nKey?>"><?=$aDataTableVal['FTXtdDisChgTxt'];?></label>
                            </div>
                        <?php 
                            else: 
                                echo "ไม่อนุญาติให้ส่วนลด"; 
                            endif;
                        ?>
                        </td>
                        <td class="text-right">
                            <span id="ospGrandTotal<?=$nKey?>"><?=number_format($aDataTableVal['FCXtdNet'],2);?></span>
                            <span id="ospnetAfterHD<?=$nKey?>" style="display: none;"><?=number_format($aDataTableVal['FCXtdNetAfHD'],2);?></span>
                        </td>
                        <td nowrap="" class="text-center xCNPIBeHideMQSS">
                            <label class="xCNTextLink">
                                <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnRSDelPdtInDTTempSingle(this)">
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
    <div id="odvRSModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('common/main/main', 'tRSMsgNotificationChangeData') ?></label>
                </div>
                <div class="modal-body">
                    <label><?php echo language('document/returnsale/returnsale','tRSMsgTextNotificationChangeData');?></label>
                </div>
                <div class="modal-footer">
                    <button id="obtRSConfirmDeleteDTDis" type="button"  class="btn xCNBTNPrimery" data-dismiss="modal"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtRSCancelDeleteDTDis" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'ยกเลิก');?></button>
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

<!--ทำรายการส่วนลด-->
<div id="odvModalDiscount" class="modal fade" tabindex="-1" role="dialog" style="max-width: 1500px; margin: 1.75rem auto; width: 85%;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
                <!--ส่วนหัว-->
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block">ส่วนลด/ชาร์จ ท้ายบิล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <!--รายละเอียด-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="btn-group pull-right" style="margin-bottom: 20px; width: 300px;">
                                <button 
                                    type="button" 
                                    id="obtAddDisChg" 
                                    class="btn xCNBTNPrimery pull-right" 
                                    onclick="JCNvAddDisChgRow()" 
                                    style="width: 100%;"><?=language('document/purchaseinvoice/purchaseinvoice','tPIMDAddEditDisChg') ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive" style="min-height: 300px; max-height: 300px; overflow-y: scroll;">
                                <table id="otbDisChgDataDocHDList" class="table">
                                    <thead>
                                        <tr class="xCNCenter">
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIsequence')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIBeforereducing')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIValuereducingcharging')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIAfterReducing')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIType')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIDiscountcharge')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPITBDelete')?></th>
                                        </tr>    
                                    </thead>
                                    <tbody>
                                        <tr class="otrDisChgHDNotFound"><td class="text-center xCNTextDetail2" colspan='100%'><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--ปุ่มยืนยันหรือยกเลิก-->
                <div class="modal-footer">
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main','tCancel');?></button>
                    <button onclick="JSxDisChgSave()" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main','tCMNOK');?></button>
                </div>
            </div>
        </div>
    </div>
</div>

<?php  include("script/jReturnSalePdtAdvTableData.php");?>

<script>  
    $( document ).ready(function() {
        JSxAddScollBarInTablePdt();
        JSxRendercalculate();
        JSxEditQtyAndPrice();    
        if($('#ohdRSStaApv').val()==1){
            $('.xCNBTNPrimeryDisChgPlus').hide();
            $('.xCNIconTable').hide();
            $('.xCNPdtEditInLine').attr('readonly',true);
            $('#obtRSBrowseCustomer').attr('disabled',true);
            $('.ocbListItem').attr('disabled',true);
        }

    });

    var nOptDecimalSave = $('#ohdOptDecimalSave').val();
    var nOptDecimalShow = $('#ohdOptDecimalShow').val();
    
    // Next Func จาก Browse PDT Center
    function FSvRSNextFuncB4SelPDT(ptPdtData){
        var aPackData = JSON.parse(ptPdtData);
        // console.log(aPackData[0]);
        for(var i=0;i<aPackData.length;i++){
            var aNewPackData = JSON.stringify(aPackData[i]);
            var aNewPackData = "["+aNewPackData+"]";
            FSvRSAddPdtIntoDocDTTemp(aNewPackData);         // Append HMTL
            FSvRSAddBarcodeIntoDocDTTemp(aNewPackData);     // Insert Database
        }
    }

    // Append PDT
    function FSvRSAddPdtIntoDocDTTemp(ptPdtData){
        JCNxCloseLoading();
        var aPackData = JSON.parse(ptPdtData);
        console.log(aPackData[0]);
        var tCheckIteminTableClass = $('#otbRSDocPdtAdvTableList tbody tr td').hasClass('xCNTextNotfoundDataPdtTable');
        // var tCheckIteminTable = $('#otbRSDocPdtAdvTableList tbody tr').length;
        if(tCheckIteminTableClass==true){
            $('#otbRSDocPdtAdvTableList tbody').html('');
            var nKey    = 1;
        }else{
            var nKey    = parseInt($('#otbRSDocPdtAdvTableList tr:last').attr('data-seqno')) + parseInt(1);
        }

        var nLen    = aPackData.length;
        var tHTML   = '';
        // var nKey    = parseInt($('#otbRSDocPdtAdvTableList tbody tr').length) + parseInt(1);
        
        for(var i=0; i<nLen; i++){

            var oData           = aPackData[i];
            var oResult         = oData.packData;

            console.log(oResult);

            oResult.NetAfHD     = (oResult.NetAfHD == '' || oResult.NetAfHD === undefined ? 0 : oResult.NetAfHD);
            oResult.Qty         = (oResult.Qty == '' || oResult.Qty === undefined ? 1 : oResult.Qty);
            oResult.Net         = (oResult.Net == '' || oResult.Net === undefined ? oResult.PriceRet : oResult.Net);
            oResult.tDisChgTxt  = (oResult.tDisChgTxt == '' || oResult.tDisChgTxt === undefined ? '' : oResult.tDisChgTxt);

            var tBarCode        = oResult.Barcode;          //บาร์โค๊ด
            var tProductCode    = oResult.PDTCode;          //รหัสสินค้า
            var tProductName    = oResult.PDTName;          //ชื่อสินค้า
            var tUnitName       = oResult.PUNName;          //ชื่อหน่วยสินค้า
            var nPrice          = (parseFloat(oResult.PriceRet)).toFixed(nOptDecimalSave);            //ราคา
            var nPriceShw          = (parseFloat(oResult.PriceRet)).toFixed(nOptDecimalShow);
            // var nGrandTotal     = (nPrice * 1).toFixed(2);  //ราคารวม
            var nAlwDiscount    = (oResult.AlwDis == '' || oResult.AlwDis === undefined ? 2 : oResult.AlwDis);           //อนุญาติคำนวณลด
            var nAlwVat         = (oResult.AlwVat == '' || oResult.AlwVat === undefined ? 0 : oResult.AlwVat);           //อนุญาติคำนวณภาษี
            var nVat            = (parseFloat(oResult.nVat)).toFixed(nOptDecimalSave);              //ภาษี
            var nQty            = parseInt(oResult.Qty);             //จำนวน
            var nNetAfHD        = (parseFloat(oResult.NetAfHD)).toFixed(nOptDecimalSave);
            var cNet            = (parseFloat(oResult.Net)).toFixed(nOptDecimalSave);
            var cNetShw        = (parseFloat(oResult.Net)).toFixed(nOptDecimalShow);
            var tDisChgTxt      = oResult.tDisChgTxt;

            // console.log(oData);

            var tDuplicate = $('#otbRSDocPdtAdvTableList tbody tr').hasClass('otr'+tProductCode+tBarCode);
            var InfoOthReAddPdt = $('#ocmRSFrmInfoOthReAddPdt').val();
            if(tDuplicate == true && InfoOthReAddPdt==1){
                //ถ้าสินค้าซ้ำ ให้เอา Qty +1
                var nValOld     = $('.otr'+tProductCode+tBarCode).find('.xCNQty').val();
                var nNewValue   = parseInt(nValOld) + parseInt(1);
                $('.otr'+tProductCode+tBarCode).find('.xCNQty').val(nNewValue);

                var nGrandOld   = $('.otr'+tProductCode+tBarCode).find('.xCNPrice').val();
                var nGrand      = parseInt(nNewValue) * parseFloat(nGrandOld);
                var nSeqOld     = $('.otr'+tProductCode+tBarCode).find('.xCNPrice').attr('data-seq');
                $('#ospGrandTotal'+nSeqOld).text(numberWithCommas(nGrand.toFixed(nOptDecimalShow)));
            }else{
                //ถ้าสินค้าไม่ซ้ำ ก็บวกเพิ่มต่อเลย
                if(nAlwDiscount == 1){ //อนุญาติลด
                    var oAlwDis = '<div>';
                        oAlwDis += '<button class="xCNBTNPrimeryDisChgPlus" onclick="JCNvRSCallModalDisChagDT(this)" type="button">+</button>'; //JCNvDisChgCallModalDT(this)
                        oAlwDis += '<label class="xWDisChgDTTmp" style="padding-left: 5px;padding-top: 3px;" id="xWDisChgDTTmp'+nKey+'">'+tDisChgTxt+'</label>';
                        oAlwDis += '</div>';
                }else{
                    var oAlwDis = 'ไม่อนุญาติให้ส่วนลด';
                }

                //ราคา
                var oPrice = nPriceShw+'<div style="display:none" class="xWEditInLine'+nKey+'">';
                    oPrice += '<input ';
                    oPrice += 'type="text" ';
                    oPrice += 'class="xCNPrice form-control xCNInputNumericWithDecimal xCNPdtEditInLine text-right xWValueEditInLine'+nKey+' "';
                    oPrice += 'id="ohdPrice'+nKey+'" ';
                    oPrice += 'name="ohdPrice'+nKey+'" '; 
                    oPrice += 'maxlength="10" '; 
                    oPrice += 'data-alwdis='+nAlwDiscount+' ';
                    oPrice += 'data-seq='+nKey+' ';
                    oPrice += 'value="'+nPrice+'"';
                    oPrice += 'autocomplete="off" >';
                    oPrice += '</div>';  

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
                tHTML += '  data-alwvat="'+nAlwVat+'"';
                tHTML += '  data-vat="'+nVat+'"';
                tHTML += '  data-key="'+nKey+'"';
                tHTML += '  data-pdtcode="'+tProductCode+'"';
                // tHTML += '  data-puncode="'+tProductCode+'"';
                tHTML += '  data-seqno="'+nKey+'"';
                tHTML += '  data-setprice="'+nPrice+'"';
                tHTML += '  data-qty="'+nQty+'"';
                tHTML += '  data-netafhd="'+nNetAfHD+'"';
                tHTML += '  data-net="'+cNet+'"';
                tHTML += '  data-stadis="'+nAlwDiscount+'"';

                tHTML += '>';
                tHTML += '<td>';
                tHTML += '  <label class="fancy-checkbox">';
                tHTML += '      <input id="ocbListItem'+nKey+'" type="checkbox" class="ocbListItem" name="ocbListItem[]" onclick="FSxRSSelectMulDel(this)">';
                tHTML += '      <span class="ospListItem">&nbsp;</span>';
                tHTML += '  </label>';
                tHTML += '</td>';
                // tHTML += '<td>'+nKey+'</td>';
                tHTML += '<td>'+tProductCode+'</td>';
                tHTML += '<td>'+tProductName+'</td>';
                // tHTML += '<td>'+tBarCode+'</td>';
                tHTML += '<td>'+tUnitName+'</td>';
                tHTML += '<td class="otdQty">'+oQty+'</td>';
                tHTML += '<td class="otdPrice text-right">'+oPrice+'</td>';
                tHTML += '<td>'+oAlwDis+'</td>';
                tHTML += '<td class="text-right"><span id="ospGrandTotal'+nKey+'">'+cNetShw+'</span>';
                tHTML += '    <span id="ospnetAfterHD'+nKey+'" style="display: none;">'+nNetAfHD+'</span>';
                tHTML += '</td>';    
                tHTML += '<td nowrap class="text-center xCNPIBeHideMQSS">';
                tHTML += '  <label class="xCNTextLink">';
                tHTML += '      <img class="xCNIconTable" src="application/modules/common/assets/images/icons/delete.png" title="Remove" onclick="JSnRSDelPdtInDTTempSingle(this)">';
                tHTML += '  </label>';
                tHTML += '</td>';
                tHTML += '</tr>';
                nKey++;
            }
        }

        //สร้างตาราง
        $('#otbRSDocPdtAdvTableList tbody').append(tHTML);

        JSxAddScollBarInTablePdt();
        JSxRendercalculate();
        JSxEditQtyAndPrice();
    }

function FSxRSSelectMulDel(ptElm){
    // $('#otbRSDocPdtAdvTableList #odvTBodyRSPdtAdvTableList .ocbListItem').click(function(){
        let tRSDocNo    = $('#oetRSDocNo').val();
        let tRSSeqNo    = $(ptElm).parents('.xWPdtItem').data('key');
        let tRSPdtCode  = $(ptElm).parents('.xWPdtItem').data('pdtcode');
        let tRSBarCode  = $(ptElm).parents('.xWPdtItem').data('barcode');
        // let tRSPunCode  = $(this).parents('.xWPdtItem').data('puncode');
        $(ptElm).prop('checked', true);
        let oLocalItemDTTemp    = localStorage.getItem("RS_LocalItemDataDelDtTemp");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("RS_LocalItemDataDelDtTemp"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tDocNo'    : tRSDocNo,
                'tSeqNo'    : tRSSeqNo,
                'tPdtCode'  : tRSPdtCode,
                'tBarCode'  : tRSBarCode,
                // 'tPunCode'  : tRSPunCode,
            });
            localStorage.setItem("RS_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
            JSxRSTextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStRSFindObjectByKey(aArrayConvert[0],'tSeqNo',tRSSeqNo);
            if(aReturnRepeat == 'None' ){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tDocNo'    : tRSDocNo,
                    'tSeqNo'    : tRSSeqNo,
                    'tPdtCode'  : tRSPdtCode,
                    'tBarCode'  : tRSBarCode,
                    // 'tPunCode'  : tRSPunCode,
                });
                localStorage.setItem("RS_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                JSxRSTextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("RS_LocalItemDataDelDtTemp");
                $(ptElm).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeqNo == tRSSeqNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("RS_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                JSxRSTextInModalDelPdtDtTemp();
            }
        }
        JSxRSShowButtonDelMutiDtTemp();
    // });
}

function JSxAddScollBarInTablePdt(){
    $('#otbRSDocPdtAdvTableList >tbody >tr').css('background-color','#ffffff');
    var rowCount = $('#otbRSDocPdtAdvTableList >tbody >tr').length;
        if(rowCount >= 2){
            $('#otbRSDocPdtAdvTableList >tbody >tr').last().css('background-color','rgb(226, 243, 255)');
       
        }

    if(rowCount >= 7){
        $('.xCNTablescroll').css('height','450px');
        $('.xWShowInLine' + rowCount).focus();

        $('html, body').animate({
             scrollTop: ($("#oetRSInsertBarcode").offset().top)-80
         }, 0);
    }



        
        if($('#oetRSFrmCstCode').val() != ''){
            $('#oetRSInsertBarcode').focus();
        }

    }
    //คำนวณจำนวนเงินจากตางราง DT
    function JSxRendercalculate(){

        var nTotal                  = 0;
        var nTotal_alwDiscount      = 0;

        $(".xCNPrice").each(function(e) {
            var nSeq   = $(this).attr('data-seq');
            var nValue = $('#ospGrandTotal'+nSeq).text();
            var nValue = nValue.replace(/,/g, '');

            nTotal = parseFloat(nTotal) + parseFloat(nValue);
         
            if($(this).attr('data-alwdis') == 1){
                nTotal_alwDiscount = parseFloat(nTotal_alwDiscount) + parseFloat(nValue);
            };
        });
   
        //จำนวนเงินรวม
        $('#olbSumFCXtdNet').text(numberWithCommas(parseFloat(nTotal).toFixed(nOptDecimalShow)));

        //จำนวนเงินรวม ที่อนุญาติลด
        $('#olbSumFCXtdNetAlwDis').val(nTotal_alwDiscount);

        //คิดส่วนลดใหม่
        var tChgHD          = $('#olbDisChgHD').text();
        console.log(tChgHD);
        var nNewDiscount    = 0;
        if(tChgHD != '' && tChgHD != null){ //มีส่วนลดท้ายบิล
            var aChgHD      = tChgHD.split(",");
            var nNetAlwDis  = $('#olbSumFCXtdNetAlwDis').val();
        
            for(var i=0; i<aChgHD.length; i++){
                // console.log('ยอดที่มันเอาไปคิดทำส่วนลด : ' + nNetAlwDis);
                if(aChgHD[i] != '' && aChgHD[i] != null){
                    if(aChgHD[i].search("%") == -1){ 
                     
                        //ไม่เจอ = ต้องคำนวณแบบบาท
                        var nVal        = aChgHD[i];
                        var nCal        = (parseFloat(nNetAlwDis) + parseFloat(nVal));
                        // console.log('ลดเเล้วเหลือ : ' + nCal)
                        nNewDiscount    = parseFloat(nCal);
                        nNetAlwDis      = nNewDiscount;
                        nNewDiscount    = 0;
                    }else{ 
               
                        //เจอ = ต้องคำนวณแบบ %
                        var nPercent    = aChgHD[i];
                        var nPercent    = nPercent.replace("%", "");
                        var tCondition  = nPercent.substr(0, 1);
                        var nValPercent = Math.abs(nPercent);
                        if(tCondition == '-'){
                            var nCal        = parseFloat(nNetAlwDis) - ((parseFloat(nNetAlwDis) * nValPercent) / 100);
                            if(nCal == 0){
                                var nCal        = -nNetAlwDis;
                            }else{
                                var nCal        = nCal;
                            }
                        }else if(tCondition == '+'){
                            var nCal        = parseFloat(nNetAlwDis) + ((parseFloat(nNetAlwDis) * nValPercent) / 100);
                        }

                        // console.log('ลดเเล้วเหลือ : ' + nCal);
                        nNewDiscount    = parseFloat(nCal);
                        nNetAlwDis      = nNewDiscount;
                        nNewDiscount    = 0;
                    }
                }
            }
            var nDiscount = (nNetAlwDis - parseFloat($('#olbSumFCXtdNetAlwDis').val()));
                            console.log(nDiscount,"nDiscount");
                        
            $('#olbSumFCXtdAmt').text(numberWithCommas(parseFloat(nDiscount).toFixed(nOptDecimalShow)));

            //Prorate
            JSxProrate();
        }

        //ยอดรวมหลังลด/ชาร์จ
        var nTotalFisrt = $('#olbSumFCXtdNet').text().replace(/,/g, '');
        var nDiscount   = $('#olbSumFCXtdAmt').text().replace(/,/g, '');
        var nResult     = parseFloat(Math.abs(nTotalFisrt))+parseFloat(nDiscount);
        $('#olbSumFCXtdNetAfHD').text(numberWithCommas(parseFloat(nResult).toFixed(nOptDecimalShow)));

        //คำนวณภาษี
        JSxCalculateVat();
    }

 //Prorate ส่วนลดเฉลี่ยท้ายบิล
 function JSxProrate(){
        //pnSumDiscount         : ส่วนลดท้ายบิลทั้งหมด
        //pnSum                 : ราคาทั้งหมดหลังหักส่วนลดต่อชิ้น
        var pnSumDiscount       = $('#olbSumFCXtdAmt').text().replace(/,/g, '');
        var pnSum               = $('#olbSumFCXtdNetAlwDis').val().replace(/,/g, '');
        var length              = $(".xCNPrice").length;
        var nSumProrate         = 0;
        var nDifferenceProrate  = 0;
        $(".xCNPrice").each(function(index,e) {
            var nSeq    = $(this).attr('data-seq');
            var alwdis  = $(this).attr('data-alwdis');

            var nValue  = $('#ospGrandTotal'+nSeq).text();
            var nValue  = parseFloat(nValue.replace(/,/g, ''));
           var nProrate = (pnSumDiscount * nValue) / pnSum;
           var netAfterHD = 0 ;
            // console.log(alwdis,'alwdis');
           if(alwdis==1){
            // console.log(pnSumDiscount,'pnSumDiscount');
            // console.log(nValue,'nProrate');
            // console.log(nProrate,'netAfterHD');
        //    console.log(nValue,'nValue');
           //ผลรวม prorate ที่เหลือต้องเอาไป + ตัวสุดท้าย
           nSumProrate     = parseFloat(nSumProrate) + parseFloat(nProrate);
           if(index === (length - 1)){
                nDifferenceProrate = pnSumDiscount - nSumProrate;
                nProrate = nProrate + nDifferenceProrate;
                netAfterHD =  nValue + nProrate;
            }else{
                nProrate = nProrate;
                netAfterHD =  nValue + nProrate;
            }
       
        //    $('#ospnetAfterHD'+nSeq).text(numberWithCommas(Math.abs(parseFloat(nProrate).toFixed(2))));
          
            // var nNetb4hd = parseFloat($('#ospnetAfterHD'+nSeq).text().replace(/,/g, ''));
            // console.log(nNetb4hd,'nNetb4hd');
            // console.log(nProrate,'nProrate');
           $('#ospnetAfterHD'+nSeq).text(numberWithCommas(parseFloat(nValue+nProrate).toFixed(nOptDecimalShow)));
        }
        });    
    }


    //เเก้ไขจำนวน และ ราคา
    function JSxEditQtyAndPrice(){

        $('.xCNPdtEditInLine').click(function(){
            $(this).focus().select();
        });

        // $('.xCNQty').change(function(e){
        $('.xCNPdtEditInLine').off().on('change keyup',function(e){
            if(e.type === 'change' || e.keyCode === 13){
                console.log(e.type);
                // var nValue      = $(this).val();
                var nSeq    = $(this).attr('data-seq');
                var nValueQty   = $(this).val();
                var nQty    = $('.xWPdtItemList'+nSeq).attr('data-qty');
                var cPrice  = $('.xWPdtItemList'+nSeq).attr('data-setprice');
                var tRSRefDocNo  = $('#oetRSRefDocNo').val();

                    if(tRSRefDocNo!=''){
                        var aResChkQty = JSaRSQtyLimitReturnItem(nSeq,nValueQty);
                    }else{
                        var aResChkQty = '1';
                    }

                    if(aResChkQty=='1'){            
                                // var nNewValue   = parseInt(nValue) * parseFloat($('#ohdPrice'+nSeq).val());
                                // $('#ospGrandTotal'+nSeq).text(numberWithCommas(nNewValue.toFixed(2)));
                                // JSxRendercalculate();

                                // ตรวจสอบลดรายการ
                                var tDisChgDTTmp = $('#xWDisChgDTTmp'+nSeq).text();
                                if(tDisChgDTTmp == ''){
                                    JSxGetDisChgList(nSeq,0);
                                    $(':input:eq(' + ($(':input').index(this) + 1) +')').focus().select();
                                }else{
                                    // มีลด/ชาร์จ
                                    $('#odvRSModalConfirmDeleteDTDis').modal({
                                        backdrop: 'static',
                                        show: true
                                    });
                                    
                                    // $('#odvRSModalConfirmDeleteDTDis #obtRSConfirmDeleteDTDis').unbind();
                                    $('#odvRSModalConfirmDeleteDTDis #obtRSConfirmDeleteDTDis').off('click');
                                    $('#odvRSModalConfirmDeleteDTDis #obtRSConfirmDeleteDTDis').on('click',function(){
                                        // $('#odvRSModalConfirmDeleteDTDis').modal('hide');
                                        // $('.modal-backdrop').remove();
                                        JSxGetDisChgList(nSeq,1);
                                        $(':input:eq(' + ($(':input').index(this) + 1) +')').focus().select();
                                    });

                                    // $('#odvRSModalConfirmDeleteDTDis #obtRSCancelDeleteDTDis').unbind();
                                    $('#odvRSModalConfirmDeleteDTDis #obtRSCancelDeleteDTDis').off('click');
                                    $('#odvRSModalConfirmDeleteDTDis #obtRSCancelDeleteDTDis').on('click',function(){
                                        // $('.modal-backdrop').remove();
                                        e.preventDefault();
                                        $('#ohdQty'+nQty).val(nQty);
                                        $('#ohdPrice'+nQty).val(cPrice);
                                    });

                                    // $('#odvRSModalConfirmDeleteDTDis').modal('show');
                                }


                            } //aResChkQty
            }
        });

    }

    // ptStaDelDis = 1 ลบ DTDis
    // ptStaDelDis = 0 ไม่ลบ DTDis
    function JSxGetDisChgList(pnSeq,pnStaDelDis){
        var tChgDT      = $('#xWDisChgDTTmp'+pnSeq).text();
        var cPrice      = $('#ohdPrice'+pnSeq).val();
        var nQty        = $('#ohdQty'+pnSeq).val();
        var cResult     = parseFloat(cPrice * nQty);

        console.log(cPrice);

        // Fixed ราคาต่อหน่วย 2 ตำแหน่ง
        $('#ohdPrice'+pnSeq).val(parseFloat(cPrice).toFixed(nOptDecimalSave));

        // Update Value
        $('#ospGrandTotal'+pnSeq).text(numberWithCommas(parseFloat(cResult).toFixed(nOptDecimalShow)));
        $('.xWPdtItemList'+pnSeq).attr('data-qty',nQty);
        $('.xWPdtItemList'+pnSeq).attr('data-setprice',parseFloat(cPrice).toFixed(nOptDecimalSave));
        $('.xWPdtItemList'+pnSeq).attr('data-net',parseFloat(cResult).toFixed(nOptDecimalSave));
        if(pnStaDelDis == 1){
            $('#xWDisChgDTTmp'+pnSeq).text('');
        }

        // ถ้าไม่มีลดท้ายบิล ให้ปรับ NetAfHD
        if($('#olbDisChgHD').text() == ''){
            $('#ospnetAfterHD'+pnSeq).text(parseFloat(cResult).toFixed(nOptDecimalShow));
            $('.xWPdtItemList'+pnSeq).attr('data-netafhd',parseFloat(cResult).toFixed(nOptDecimalSave));
        }

        JSxRendercalculate();

        var tRSDocNo        = $("#oetRSDocNo").val();
        var tRSBchCode      = $("#oetRSFrmBchCode").val();
        $.ajax({
            type: "POST",
            url: "dcmRSEditPdtIntoDTDocTemp",
            data: {
                'tRSBchCode'    : tRSBchCode,
                'tRSDocNo'      : tRSDocNo,
                'nRSSeqNo'      : pnSeq,
                'nQty'          : nQty,
                'cPrice'        : cPrice,
                'cNet'          : cResult,
                'nStaDelDis'    : pnStaDelDis,
                'ohdSesSessionID'   : $('#ohdSesSessionID').val(),
                'ohdRSUsrCode'        : $('#ohdRSUsrCode').val(),
                'ohdRSLangEdit'       : $('#ohdRSLangEdit').val(),
                'ohdSesUsrLevel'      : $('#ohdSesUsrLevel').val(),
                'ohdRSSesUsrBchCode'  : $('#ohdRSSesUsrBchCode').val(),
            },
            cache: false,
            timeout: 0,
            success: function (oResult){
                // if(oResult == 'expire'){
                //     JCNxShowMsgSessionExpired();
                // }else{
                //     JSvSOLoadPdtDataTableHtml();
                // }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSxGetDisChgList(pnSeq,pnStaDelDis);
            }
        });
       

    }



    //คำนวณภาษี
    $('#ocmVatInOrEx').change(function (){ JSxCalculateVat(); });  
    function JSxCalculateVat(){
        var tVatList  = '';
        var aVat      = [];
        $('#otbRSDocPdtAdvTableList tbody tr').each(function(){
            var nAlwVat  = $(this).attr('data-alwvat');
            var nVat     = parseFloat($(this).attr('data-vat'));
            var nKey     = $(this).attr('data-key');
            var tTypeVat = $('#ohdRSCmpRetInOrEx').val();;

            console.log(nVat);    
            if(nAlwVat == 1){ 
                //อนุญาติคิด VAT
                if(tTypeVat == 1){ 
                    // ภาษีรวมใน tRSot = net - ((net * 100) / (100 + rate));
                    var net       = parseFloat($('#ospnetAfterHD'+nKey).text().replace(/,/g, ''));
                    var nTotalVat = net - (net * 100 / (100 + nVat));
                    var nResult   = parseFloat(nTotalVat).toFixed(nOptDecimalSave);
                }else if(tTypeVat == 2){
                    // ภาษีแยกนอก tRSot = net - (net * (100 + 7) / 100) - net;
                    var net       = parseFloat($('#ospnetAfterHD'+nKey).text().replace(/,/g, ''));
                    var nTotalVat = (net * (100 + nVat) / 100) - net;
                    var nResult   = parseFloat(nTotalVat).toFixed(nOptDecimalSave);
                }

                var oVat = { VAT: nVat , VALUE: nResult };
                aVat.push(oVat);
            }
        });


        //เรียงลำดับ array ใหม่
        aVat.sort(function (a, b) {
            return a.VAT - b.VAT;
        });

        //รวมค่าใน array กรณี vat ซ้ำ
        var nVATStart       = 0;
        var nSumValueVat    = 0;
        var aSumVat         = [];
        for(var i=0; i<aVat.length; i++){
            if(nVATStart == aVat[i].VAT){
                nSumValueVat = nSumValueVat + parseFloat(aVat[i].VALUE);
                aSumVat.pop();
            }else{
                nSumValueVat = 0;
                nSumValueVat = nSumValueVat + parseFloat(aVat[i].VALUE);
                nVATStart    = aVat[i].VAT;
            }

            var oSum = { VAT: nVATStart , VALUE: nSumValueVat };
            aSumVat.push(oSum);
        }

        //  console.log(aVat);


        var cRSVatRate =  parseFloat($('#ohdRSVatRate').val());
        var nRSCmpRetInOrEx = $('#ohdRSCmpRetInOrEx').val();
        // ภาษีรวมใน tRSot = net - ((net * 100) / (100 + rate));
        var cSumFCXtdNetAfHD  = parseFloat($('#olbSumFCXtdNetAfHD').text().replace(/,/g, ''));
        var nSumVatHD = cSumFCXtdNetAfHD - ((cSumFCXtdNetAfHD * 100)/(100 + cRSVatRate));
        
        //ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbVatSum').text(numberWithCommas(parseFloat(nSumVatHD).toFixed(nOptDecimalShow)));

                //เอา VAT ไปทำในตาราง
        var nSumVat = 0;
        var nCount = 1;
        for(var j=0; j<aSumVat.length; j++){
            var tVatRate    = aSumVat[j].VAT;
                  if(nCount!=aSumVat.length){
                    var tSumVat     = parseFloat(aSumVat[j].VALUE).toFixed(nOptDecimalShow) == 0 ? '0.00' : parseFloat(aSumVat[j].VALUE).toFixed(nOptDecimalShow);
                    }else{
                    var tSumVat     = (nSumVatHD - nSumVat).toFixed(nOptDecimalShow);
                    }
            tVatList    += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
            nSumVat += parseFloat(aSumVat[j].VALUE);
            nCount++;
        }
        
        $('#oulDataListVat').html(tVatList);

        //ยอดรวมภาษีมูลค่าเพิ่ม
        $('#olbSumFCXtdVat').text(numberWithCommas(parseFloat(nSumVatHD).toFixed(nOptDecimalShow)));
        $('#ohdSumFCXtdVat').val(nSumVatHD.toFixed(nOptDecimalSave));
        //สรุปราคารวม
        var tTypeVat = $('#ohdRSCmpRetInOrEx').val();;
        if(tTypeVat == 1){ //คิดแบบรวมใน
            var nTotal          = parseFloat($('#olbSumFCXtdNetAfHD').text().replace(/,/g, ''));
            var nResultTotal    = nTotal;
        }else if(tTypeVat == 2){ //คิดแบบแยกนอก
            var nTotal          = parseFloat($('#olbSumFCXtdNetAfHD').text().replace(/,/g, ''));
            var nVat            = parseFloat($('#olbSumFCXtdVat').text().replace(/,/g, ''));
            var nResultTotal    = parseFloat(nTotal) + parseFloat(nVat);
        }

        //จำนวนเงินรวมทั้งสิ้น
        $('#olbCalFCXphGrand').text(numberWithCommas(parseFloat(nResultTotal).toFixed(nOptDecimalShow)));

        //ราคารวมทั้งหมด ตัวเลขบาท
        var tTextTotal  = $('#olbCalFCXphGrand').text().replace(/,/g, '');
        var tThaibath 	= ArabicNumberToText(tTextTotal);
        $('#odvDataTextBath').text(tThaibath);
    }


    //พวกตัวเลขใส่ comma ให้มัน
    function numberWithCommas(x) {
        return x.toString().replace(/\B(?<!\.\d*)(?=(\d{3})+(?!\d))/g, ",");
    }
    



    //Modal กำหนดส่วนลด HD
    function JCNLoadPanelDisChagHD(){
        $('#odvModalDiscount').modal({backdrop: 'static', keyboard: false})  
        $('#odvModalDiscount').modal('show');
    }

    //เพิ่มส่วนลด
    function JCNvAddDisChgRow(){
        var tDuplicate = $('#otrRSDisChgHDNotFound tbody tr').hasClass('otrRSDisChgHDNotFound');
        if(tDuplicate == true){
            //ล้างค่า
            $('#otrRSDisChgHDNotFound tbody').html('');
        }

        //เพิ่มค่า
        var nKey = parseInt($('#otrRSDisChgHDNotFound tbody tr').length) + parseInt(1);

        //จำนวนเงินรวม ที่อนุญาติลด
        var nRowCount   = $('.xWDiscountChgTrTag').length;
        if(nRowCount > 0){
            var oLastRow   = $('.xWDiscountChgTrTag').last();
            var nNetAlwDis = oLastRow.find('td label.xCNDisChgAfterDisChg').text();
        }else{
            var nNetAlwDis = ($('#olbSumFCXtdNetAlwDis').val() == 0) ? '0.00' : $('#olbSumFCXtdNetAlwDis').val();
        }

        var     tSelectTypeDiscount =  '<td nowrap style="padding-left: 5px !important;">';
                tSelectTypeDiscount += '<div class="form-group" style="margin-bottom: 0px !important;">';
                tSelectTypeDiscount += '<select class="dischgselectpicker form-control xCNDisChgType" onchange="JSxCalculateDiscountChg(this);">';
                tSelectTypeDiscount += '<option value="1"><?=language('common/main/main', 'ลดบาท'); ?></option>';
                tSelectTypeDiscount += '<option value="2"><?=language('common/main/main', 'ลด %'); ?></option>';
                tSelectTypeDiscount += '<option value="3"><?=language('common/main/main', 'ชาร์จบาท'); ?></option>';
                tSelectTypeDiscount += '<option value="4"><?=language('common/main/main', 'ชาร์ท %'); ?></option>';
                tSelectTypeDiscount += '</select>';
                tSelectTypeDiscount += '</div>';
                tSelectTypeDiscount += '</td>';

        var     tDiscount =  '<td nowrap style="padding-left: 5px !important;">';
                tDiscount += '<div class="form-group" style="margin-bottom: 0px !important;">';
                tDiscount += '<input class="form-control xCNInputNumericWithDecimal xCNDisChgNum" onchange="JSxCalculateDiscountChg(this);" onkeyup="javascript:if(event.keyCode==13) JSxCalculateDiscountChg(this);" type="text">';
                tDiscount += '</div>';
                tDiscount += '</td>';

        var     tHTML = '';
                tHTML += '<tr class="xWDiscountChgTrTag" >';
                tHTML += '<td>'+nKey+'</td>';
                tHTML += '<td class="text-right"><label class="xCNBeforeDisChg">'+numberWithCommas(parseFloat(nNetAlwDis).toFixed(nOptDecimalShow))+'</label></td>';
                tHTML += '<td class="text-right"><label class="xCNDisChgValue">'+'0.00'+'</label></td>';
                tHTML += '<td class="text-right"><label class="xCNDisChgAfterDisChg">'+'0.00'+'</label></td>'; 
                tHTML += tSelectTypeDiscount;
                tHTML += tDiscount;
                tHTML += '<td nowrap="" class="text-center">';
                tHTML += '<label class="xCNTextLink">';
                tHTML += '<img class="xCNIconTable xWDisChgRemoveIcon" src="<?=base_url('application/modules/common/assets/images/icons/delete.png')?>" title="Remove" onclick="JSxRemoveDiscountRow(this)">';
                tHTML += '</label>';
                tHTML += '</td>';
                tHTML += '</tr>';
        $('#otbDisChgDataDocHDList tbody').append(tHTML);
        JSxCalculateDiscountChg();
    }

    //ลบส่วนลด
    function JSxRemoveDiscountRow(elem){

    }

    //คีย์ส่วนลด
    function JSxCalculateDiscountChg(){
        $('.xWDiscountChgTrTag').each(function(index){
            if($('.xWDiscountChgTrTag').length == 1){
                // $('img.xWPIDisChgRemoveIcon').first().attr('onclick','JSxPIResetDisChgRemoveRow(this)').css('opacity', '1');
            }else{
                // $('img.xWPIDisChgRemoveIcon').first().attr('onclick','').css('opacity','0.2');
            }

            var cBeforeDisChg = $('#olbSumFCXtdNetAlwDis').val();
            $(this).find('td label.xCNBeforeDisChg').first().text(accounting.formatNumber(cBeforeDisChg, 2, ','));
            
            var cCalc;
            var nDisChgType         = $(this).find('td select.xCNDisChgType').val();
            var cDisChgNum          = $(this).find('td input.xCNDisChgNum').val();
            var cDisChgBeforeDisChg = accounting.unformat($(this).find('td label.xCNBeforeDisChg').text());
            var cDisChgValue        = $(this).find('td label.xCNDisChgValue').text();
            var cDisChgAfterDisChg  = $(this).find('td label.xCNDisChgAfterDisChg').text();

            if(nDisChgType == 1){ // ลดบาท
                cCalc = parseFloat(cDisChgBeforeDisChg) - parseFloat(cDisChgNum);
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
            }
            
            if(nDisChgType == 2){ // ลด %
                var cDisChgPercent  = (cDisChgBeforeDisChg * parseFloat(cDisChgNum)) / 100;
                cCalc = parseFloat(cDisChgBeforeDisChg) - cDisChgPercent;
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
            }
            
            if(nDisChgType == 3){ // ชาร์จบาท
                cCalc = parseFloat(cDisChgBeforeDisChg) + parseFloat(cDisChgNum);
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgNum, 2, ','));
            }
            
            if(nDisChgType == 4){ // ชาร์ท %
                var cDisChgPercent = (parseFloat(cDisChgBeforeDisChg) * parseFloat(cDisChgNum)) / 100;
                cCalc = parseFloat(cDisChgBeforeDisChg) + cDisChgPercent;
                $(this).find('td label.xCNDisChgValue').text(accounting.formatNumber(cDisChgPercent, 2, ','));
            }

            $(this).find('td label.xCNDisChgAfterDisChg').text(accounting.formatNumber(cCalc, 2, ','));
            $(this).next().find('td label.xCNBeforeDisChg').text(accounting.formatNumber(cCalc, 2, ','));
        });
    }



    /**
        * Functionality: Save Discount And Chage Footer HD (ลดท้ายบิล)
        * Parameters: Event Proporty
        * Creator: 22/05/2019 Piya  
        * Return: Open Modal Discount And Change HD
        * Return Type: View
    */
    function JCNvRSMngDocDisChagHD(event){

        //หาราคาที่อนุญาติลดเท่านั้น - วัฒน์
        // $.ajax({
        //     type    : "POST",
        //     url     : "GetPriceAlwDiscount",
        //     data    : { 'tDocno' : $('#oetRSDocNo').val() , 'tBCHCode' : $('#oetRSFrmBchCode').val() },
        //     cache   : false,
        //     timeout : 0,
        //     success : function(oResult) {
        //         var aTotal = JSON.parse(oResult);
        //         cSumFCXtdNet = aTotal.nTotal;
        //         $('#olbSumFCXtdNetAlwDis').val(cSumFCXtdNet);
        //     }
        // });
        // var cSumFCXtdNet = $('#olbSumFCXtdNet').text().replace(/,/g, '');
        // $('#olbSumFCXtdNetAlwDis').val(cSumFCXtdNet);

        // var nStaSession = JCNxFuncChkSessionExpired();
        var nStaSession = 1;
        if (typeof nStaSession !== "undefined" && nStaSession == 1) {
            var oRSDisChgParams = {
                DisChgType: 'disChgHD'
            };
            JSxRSOpenDisChgPanel(oRSDisChgParams);
        }else{
            JCNxShowMsgSessionExpired();
        } 
}


    /**
        * Function: Set Data Value End Of Bile
        * Parameters: Document Type
        * Creator: 01/07/2019 wasin(Yoshi)
        * LastUpdate: -
        * Return: Set Value In Text From
        * ReturnType: None
    */
    function JSxRSSetFooterEndOfBill(poParams){
        /* ================================================= Left End Of Bill ================================================= */
            // Set Text Bath
            var tTextBath   = poParams.tTextBath;
            $('#odvDataTextBath').text(tTextBath);

            // รายการ vat
            var aVatItems   = poParams.aEndOfBillVat.aItems;
            var tVatList    = "";
            if(aVatItems.length > 0){
                for(var i = 0; i < aVatItems.length; i++){
                    var tVatRate = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                    var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow?>);
                    var tSumVat = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow;?>) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(<?php echo $nOptDecimalShow?>);
                    tVatList += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
                    
                    // var tVatRate    = parseFloat(aVatItems[i]['FCXtdVatRate']).toFixed(0);
                    // var tSumVat     = parseFloat(aVatItems[i]['FCXtdVat']).toFixed(0) == 0 ? '0.00' : parseFloat(aVatItems[i]['FCXtdVat']).toFixed(2);
                    // tVatList        += '<li class="list-group-item"><label class="pull-left">'+ tVatRate + '%</label><label class="pull-right">' + tSumVat + '</label><div class="clearfix"></div></li>';
                }
            }
            $('#oulDataListVat').html(tVatList);
            
            // ยอดรวมภาษีมูลค่าเพิ่ม
            var cSumVat     = poParams.aEndOfBillVat.cVatSum;
            $('#olbVatSum').text(cSumVat);
        /* ==================================================================================================================== */

        /* ================================================= Right End Of Bill ================================================ */
            var cCalFCXphGrand      = poParams.aEndOfBillCal.cCalFCXphGrand;
            var cSumFCXtdAmt        = poParams.aEndOfBillCal.cSumFCXtdAmt;
            var cSumFCXtdNet        = poParams.aEndOfBillCal.cSumFCXtdNet;
            var cSumFCXtdNetAfHD    = poParams.aEndOfBillCal.cSumFCXtdNetAfHD;
            var cSumFCXtdVat        = poParams.aEndOfBillCal.cSumFCXtdVat;
            var tDisChgTxt          = poParams.aEndOfBillCal.tDisChgTxt;
            
            // จำนวนเงินรวม
            $('#olbSumFCXtdNet').text(cSumFCXtdNet);
            // ลด/ชาร์จ
            $('#olbSumFCXtdAmt').text(cSumFCXtdAmt);
            // ยอดรวมหลังลด/ชาร์จ
            $('#olbSumFCXtdNetAfHD').text(cSumFCXtdNetAfHD);
            // ยอดรวมภาษีมูลค่าเพิ่ม
            $('#olbSumFCXtdVat').text(cSumFCXtdVat);
            $('#ohdSumFCXtdVat').val(cSumFCXtdVat.replace(",", ""));
            // จำนวนเงินรวมทั้งสิ้น
            $('#olbCalFCXphGrand').text(cCalFCXphGrand);
            //จำนวนลด/ชาร์จ ท้ายบิล
            $('#olbDisChgHD').text(tDisChgTxt);
        /* ==================================================================================================================== */
    }

    $(document).on("keypress", 'form', function (e) {
        var code = e.keyCode || e.which;
        if (code == 13) {
            e.preventDefault();
            return false;
        }
    });



    function JSaRSQtyLimitReturnItem(pnSeq,pnQty){
        var nStaSuccess = '';
        var tRSRefDocNo        = $("#oetRSRefDocNo").val();
        var tRSBchCode      = $("#oetRSFrmBchCode").val();
        $.ajax({
            type: "POST",
            url: "dcmRSQtyLimitRetunItem",
            data: {
                'tRSBchCode'    : tRSBchCode,
                'tRSRefDocNo'   : tRSRefDocNo,
                'nRSSeqNo'      : pnSeq,
                'nQty'          : pnQty
            },
            cache: false,
            timeout: 0,
            async: false,
            success: function (oResult){
                var aResult = JSON.parse(oResult);
                    if(aResult['tCode']=='1'){
                     $('#ohdQty'+pnSeq).val(parseFloat(aResult['nQty']).toFixed(<?php echo $nOptDecimalShow?>));
                     nStaSuccess = aResult['tCode'];
                    }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                // JCNxResponseError(jqXHR, textStatus, errorThrown);
                JSaRSChkLimitReturnItem(pnSeq,pnQty);
            }
        });

        return nStaSuccess.toString();
    }

</script>


