<div class="table-responsive">
    <table class="table table-striped xCNTableStep2">
        <thead>
            <tr>
                <th class="xCNTextBold text-center xCNhideWhenApproveOrCancel" style="width:7%;"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBChoose')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDCodePDT')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDNamePDT')?></th>
                <th class="xCNTextBold text-right"  style="width:12%;"><?=language('document/RefillProductVD/RefillProductVD','tRVDQtyRefill')?></th>
                <th class="xCNTextBold text-right"  style="width:12%;"><?=language('document/RefillProductVD/RefillProductVD','tRVDQtyRefillReserve')?></th>
                <th class="xCNTextBold text-center xCNhideWhenApproveOrCancel" style="width:8%; white-space: nowrap;"><?= language('common/main/main','จัดการข้อมูล')?></th>
                <th class="xCNTextBold text-center xCNhideWhenApproveOrCancel" style="width:8%;"><?= language('common/main/main','tCMNActionDelete')?></th>
            </tr>
        </thead>
        <tbody id="otdTBodyTableStep2">
            <?php if($aDataList['rtCode'] == 1 ){?>
                <?php foreach($aDataList['raItems'] AS $nKey => $aValue){ ?>
                    <tr class="xCNPdtTableStep2 otrPdtTable2<?=$aValue['FNXtdSeqNo']?>"  id="otrPdtTable2<?=$nKey?>"
                        data-code="<?= $aValue['FNXtdSeqNo']?>" 
                        data-name="<?= $aValue['FTPdtCode']?>"
                        data-pdtcode="<?= $aValue['FTPdtCode']; ?>"
                        data-seqno="<?= $aValue['FNXtdSeqNo']; ?>"
                        data-checkstk="<?= $aValue['FCXtdAmt']; ?>" >
                        <td class="text-center xCNhideWhenApproveOrCancel">
                            <label class="fancy-checkbox ">
                                <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItemStep2" name="ocbListItem[]">
                                <span class="">&nbsp;</span>
                            </label>
                        </td>
                        <td class="text-left"><?= (!empty($aValue['FTPdtCode']))? $aValue['FTPdtCode'] : '-' ?></td>
                        <td class="text-left"><?= (!empty($aValue['FTXtdPdtName']))? $aValue['FTXtdPdtName'] : '-' ?></td>
                        <?php $nRefill      = $aValue['FCLayColQtyMaxForTWXVD'] - $aValue['FCXtdAmt']; ?>
                        <?php $nFullRefill  = $nRefill; ?>
                        <?php
                            if($nRefill <= $aValue['FCXtdQty']){
                                $nRefill = $nRefill;
                            }else{
                                $nRefill = $aValue['FCXtdQty'];
                            }
                        ?>
                        <td class="text-right xCNShowWhenApv"><b><?=number_format($aValue['FCXtdQty']);?></b></td>
                        <td class="text-right xCNCheckSTKBal"><b><?=number_format($nRefill);?></b></td>
                        <td class="text-right xCNNotCheckSTKBal"><b><?=number_format($aValue['FCLayColQtyMaxForTWXVD']);?></b></td>
                        <td class="text-left xCNKeyQtyReserveInStep2<?=$nKey?>" ><input 
                            type="text" 
                            class="xCNApvOrCanCelDisabled text-right xCNInputNumericWithoutDecimal xCNInputLength xCNKeyQtyReserveInStep2" 
                            maxlength="4"
                            value="<?=(int)$aValue['FCStkQty']?>">
                        </td>
                        <td class="text-center xCNhideWhenApproveOrCancel">
                            <?php
                                //FCXtdQty จำนวน STK กลาง
                                //จำนวนที่มี < จำนวนที่เหลือในตู้
                                if($aValue['FCXtdQty'] < ($aValue['FCLayColQtyMaxForTWXVD'] - $aValue['FCXtdAmt'])){
                                    $tPDTCode       = $aValue['FTPdtCode'];
                                    $tPDTName       = str_replace(" ","##",$aValue['FTXtdPdtName']);
                                    $nQTY           = $aValue['FCXtdQty'];
                                    $nFullRefill    = $nFullRefill;
                                    $tEventProrate  = "onclick=JSxProrateByItem('$tPDTCode','$tPDTName','$nQTY','$nFullRefill');";
                                    echo "<p style='color:red; cursor: pointer; text-decoration: underline;' $tEventProrate>จัดการข้อมูล</p>";
                                }else{
                                    echo '<p>เติมเต็ม</p>';
                                }
                            ?>
                        </td>
                        <td class="text-center xCNhideWhenApproveOrCancel">
                            <img class="xCNIconTable xCNIconDel" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxDeleteStep2(this,'<?=$aValue['FTPdtCode'];?>','<?=$aValue['FNXtdSeqNo'];?>');" title="ลบช้อมูล">
                        </td>
                    </tr>
                <?php } ?>
            <?php }else{ ?>
                <tr class="otrDataNotFound">
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?> หรือ สต็อกคงเหลือคลังต้นทาง ไม่พอสำหรับการเติม</td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<!-- เอาไว้เช็คว่า modal เปิดซ้อนกันไหม-->
<input name="ohdRefillVDDontRefresh" id="ohdRefillVDDontRefresh" type="hidden" value="0">

<!-- Modal Delete PDT Multiple -->
<div id="odvRVDModalDelPDTMultipleStep2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main','tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultipleStep2" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelMultipleStep2">
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultipleStep2" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Prorate Stock by pos -->
<div id="odvRVDModalStockByPosStep2" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main','จัดการข้อมูล')?></label>
            </div>
            <div class="modal-body">
                <div id="odvModalStockByPosStep2"></div>
            </div>
            <div class="modal-footer">
                <button id="osmConfirmStockByPosStep2" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!--ไฟล์ลบ-->
<?php include('jDeleteMultiItemStep2.php'); ?>

<script>    

    //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
    JSxControlWhenApproveOrCancel();

    $(document).ready(function(){
        JSxLoopQTYInTable();
        //clear local
        // localStorage.removeItem("SetQTYInItem");

        //กดตรวจสอบสต็อกต้นทาง
        $('.xCNShowWhenApv').hide();
        $('#ocbRVDStaFullRefillPos').change(function() {
           var nValue = $('#ocbRVDStaFullRefillPos:checked').val();
           if(nValue == 'on'){
                $('.xCNCheckSTKBal').show();
                $('.xCNNotCheckSTKBal').hide();

                JSxCheckRefillNotInZero();
           }else{
                $('.xCNCheckSTKBal').hide();
                $('.xCNNotCheckSTKBal').show();

                JSxCheckRefillShowInZero();
           }
        });

        //กดตรวจสอบสต็อกต้นทาง
        var tCheckSTKBal = $('#ocbRVDStaFullRefillPos:checked').val();
        if(tCheckSTKBal == 'on'){
            $('.xCNCheckSTKBal').show();
            $('.xCNNotCheckSTKBal').hide();

            JSxCheckRefillNotInZero();
        }else{
            $('.xCNCheckSTKBal').hide();
            $('.xCNNotCheckSTKBal').show();

            JSxCheckRefillShowInZero();
        }

        //ถ้าอนุมัติเเล้วต้องโชว์จำนวนใน DT
        if($('#ohdRVDStaApv').val() == 1){
            $('.xCNShowWhenApv').show();
            $('.xCNCheckSTKBal').hide();
            $('.xCNNotCheckSTKBal').hide();
        }
    }); 

    //ถ้าเช็คสต๊อกต้นทาง ต้องห้ามให้มีการเติม 0
    function JSxCheckRefillNotInZero(){
        $('.otrDataNotFound').remove();
        var nLength = $('.xCNTableStep2 tbody tr').length;
        for(j=0; j<nLength; j++){
            var nQTY = $('.xCNTableStep2 tbody tr:eq('+j+') td:eq(3)').text();
            if(nQTY == 0){
                $('.xCNTableStep2 tbody tr:eq('+j+')').addClass('xCNWillRemoveTable');
                // $('.xCNTableStep2 tbody tr:eq('+j+')').hide();
            }
        }

        $('.xCNTableStep2 tbody .xCNWillRemoveTable').hide();
        var nLength         = $('.xCNTableStep2 tbody tr.xCNWillRemoveTable').length;
        var nLengthTable    = $('.xCNTableStep2 tbody tr').length;
        if(nLength == nLengthTable){
            var tText = "<?=language('common/main/main','tCMNNotFoundData')?>" + " หรือ สต็อกคงเหลือคลังต้นทาง ไม่พอสำหรับการเติม";
            var tHTML = "<tr class='otrDataNotFound'>";
                tHTML += "<td class='text-center xCNTextDetail2' colspan='100%'>"+tText+"</td>";
                tHTML += "</tr>";

            $('.xCNTableStep2 tbody').append(tHTML);
        }
    }

    //ถ้าเป็นไม่สนใจสต๊อกต้องเอากลับมาโชว์
    function JSxCheckRefillShowInZero(){
        $('.otrDataNotFound').remove();
        $('.xCNTableStep2 tbody .xCNWillRemoveTable').show();
    }

    //เอาข้อมูลมาลงใน input
    function JSxLoopQTYInTable(){
        var aArrayConvert   = [JSON.parse(localStorage.getItem("SetQTYInItem"))];
        if(aArrayConvert  == '' || aArrayConvert == null){ //ไม่มีข้อมูล

        }else{
            aArrayConvert[0].sort(compare);
            for(j=0; j<aArrayConvert[0].length; j++){
                var tPDTCode    = $('.xCNTableStep2 #otdTBodyTableStep2 #otrPdtTable2'+j).data('pdtcode');
                var nSEQNo      = $('.xCNTableStep2 #otdTBodyTableStep2 #otrPdtTable2'+j).data('seqno');
         
                if(aArrayConvert[0][j].nSeqNo == nSEQNo && aArrayConvert[0][j].tPdtCode == tPDTCode){
                    var nQTYReserve = aArrayConvert[0][j].nQty;
                    // console.log(nQTYReserve);
                    $('.xCNTableStep2 #otdTBodyTableStep2 #otrPdtTable2'+j+' .xCNKeyQtyReserveInStep2'+j).find("input").val(nQTYReserve);
                }
            }
            setTimeout(function(){ $('.xCNKeyQtyReserveInStep2').trigger('change'); }, 500);
        }
    }

    //เรียงลำดับจาก seq 
    function compare(a,b) {
        if( a.nSeqNo  < b.nSeqNo ){
            return -1;
        }
        if( a.nSeqNo  > b.nSeqNo ){
            return 1;
        }
        return 0;
    }

    //อัพเดท QTY สำรองการเติม
    $('.xCNKeyQtyReserveInStep2').on('change keyup', function(event){
        if(event.type == "change"){
            JSxKeyQtyReserveDataTableEditInline(this);
        }
        if(event.keyCode == 13) {
            JSxKeyQtyReserveDataTableEditInline(this);
        } 
    });

    //อัพเดท QTY สำรองการเติม
    var oDataObj        = [];
    var aNewarraydata   = [];
    function JSxKeyQtyReserveDataTableEditInline(poElm) {
        // console.log('Call Func Upda StkQty');
        var nQty        = $(poElm).val();
        var tPdtCode    = $(poElm).parents('.xCNPdtTableStep2').data('pdtcode');
        var nSeqNo      = $(poElm).parents('.xCNPdtTableStep2').data('seqno');
        var nCheckSTK   = $(poElm).parents('.xCNPdtTableStep2').data('checkstk');

        $.ajax({
            type    : "POST",
            url     : "docRVDRefillPDTVDUpdateStep2",
            data    : {
                tDocumentNumber : $('#oetRVDDocNo').val(),
                nQty            : nQty, 
                nSeqNo          : nSeqNo,
                tPdtCode        : tPdtCode, 
            },
            cache   : false,
            timeout : 0,
            success : function(tResult) {
                
                let oLocalItemDTTemp    = localStorage.getItem("SetQTYInItem");
                if(oLocalItemDTTemp){
                    oDataObj    = JSON.parse(oLocalItemDTTemp);
                }
                
                var aArrayConvert   = [JSON.parse(localStorage.getItem("SetQTYInItem"))];
                if(aArrayConvert    == '' || aArrayConvert == null){ //เพิ่มครั้งเเรก
                    oDataObj.push({
                        'tDocumentNumber'   : $('#oetRVDDocNo').val(),
                        'nSeqNo'            : nSeqNo,
                        'tPdtCode'          : tPdtCode,
                        'nQty'              : nQty
                    });
                    localStorage.setItem("SetQTYInItem",JSON.stringify(oDataObj));
                }else{
                    var aReturnRepeat = JSbCheckInLocalStorageFindObjectByKey(aArrayConvert[0],'nSeqNo',nSeqNo);
                    if(aReturnRepeat == 'None'){
                        oDataObj.push({
                            'tDocumentNumber'   : $('#oetRVDDocNo').val(),
                            'nSeqNo'            : nSeqNo,
                            'tPdtCode'          : tPdtCode,
                            'nQty'              : nQty
                        });
                        localStorage.setItem("SetQTYInItem",JSON.stringify(oDataObj));
                    }else if(aReturnRepeat == 'Dupilcate'){
                        localStorage.removeItem("SetQTYInItem");
                        var nLength = aArrayConvert[0].length;
                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i].nSeqNo == nSeqNo){
                                delete aArrayConvert[0][$i];
                            }
                        }

                        for($i=0; $i<nLength; $i++){
                            if(aArrayConvert[0][$i] != undefined){
                                aNewarraydata.push(aArrayConvert[0][$i]);
                            }
                        }

                        aNewarraydata.push({
                            'tDocumentNumber'   : $('#oetRVDDocNo').val(),
                            'nSeqNo'            : nSeqNo,
                            'tPdtCode'          : tPdtCode,
                            'nQty'              : nQty
                        });
                        localStorage.setItem("SetQTYInItem",JSON.stringify(aNewarraydata));
                        aNewarraydata = [];
                    }
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //คีย์ แล้วเช็คว่ามีจำนวนหรือยัง
    function JSbCheckInLocalStorageFindObjectByKey(array, key, value) {
        for (var i = 0; i < array.length; i++) {
            if (array[i][key] === value) {
                return "Dupilcate";
            }
        }
        return "None";
    }

    //ลบข้อมูล
    function JSxDeleteStep2(elem,ptPDTCode,ptSeq){
        $.ajax({
            type    : "POST",
            url     : "docRVDRefillPDTVDDeleteStep2",
            cache   : false,
            data    : { tDocumentNumber : $('#oetRVDDocNo').val() , tPDTCode : ptPDTCode , nSeq : ptSeq },
            timeout : 0,
            success: function(oResult) {
                $(elem).closest("tr").remove();

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
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //pop-up prorale
    function JSxProrateByItem(ptPDTCode,ptPDTName,pnQty,pnFullRefill){
        $('#odvRVDModalStockByPosStep2').modal('show');
        $.ajax({
            type    : "POST",
            url     : "docRVDRefillPDTVDShowProrate",
            cache   : false,
            data    : { tDocumentNumber : $('#oetRVDDocNo').val() , tPDTCode : ptPDTCode , tPDTName : ptPDTName , nQTY : pnQty , nFullRefill : pnFullRefill},
            timeout : 0,
            success: function(oResult) {
                var aReturnData = JSON.parse(oResult);
                $('#odvModalStockByPosStep2').html(aReturnData['tViewer']);
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>