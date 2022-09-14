<div class="table-responsive">
    <table class="table table-striped xCNTableProrateStep2">
        <thead>
            <tr>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBPos')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDCodePDT')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDNamePDT')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','ชั้น')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','ช่อง')?></th>
                <th class="xCNTextBold text-right"><?=language('document/RefillProductVD/RefillProductVD','จำนวนคงเหลือ')?></th>
                <th class="xCNTextBold text-right" style="width: 100px;"><?=language('document/RefillProductVD/RefillProductVD','tRVDQtyRefill')?></th>
            </tr>
        </thead>
        <tbody id="otdTBodyTableProrateStep2">
            <?php 
                $bCheckSave = false; //ถ้าเคยมีการกด save เเล้ว ไม่ต้องให้คำนวณ prorate
                $tPosCode   = ''; 
                $aQTYByPos  = [];
                $nAVGCode   = 0;
            ?>
            <?php foreach($aDataList['raItems'] AS $nKey => $aValue){ ?>

                <?php 
                    //รอบแรก
                    if($nKey == 0){
                        $tPosCode = $aValue['FTPosCode'];

                        if($aValue['FCXtdQty'] != '' || $aValue['FCXtdQty'] != null){
                            $bCheckSave = true;
                        }else{
                            $bCheckSave = false;
                        }
                    }

                    //หาจำนวนต่อ pos
                    if($aValue['FTPosCode'] == $tPosCode){
                        $nAVGCode  = intval($nAVGCode) + intval($aValue['AVGQTY']);
                    }else{
                        //ถ้าขึ้นรอบใหม่ให้ push
                        array_push($aQTYByPos,array('POS' => $tPosCode , 'QTYAll' => $nAVGCode));
                        $tPosCode   = $aValue['FTPosCode'];
                        $nAVGCode   = $aValue['AVGQTY'];
                    }

                    //ถ้ารอบสุดท้าย
                    if($nKey == FCNnHSizeOf($aDataList['raItems']) - 1){
                        array_push($aQTYByPos,array('POS' => $tPosCode , 'QTYAll' => $nAVGCode));
                    }
                ?>
                <tr 
                    data-pdtcode='<?=$tPDTCode?>' 
                    data-pos='<?=$aValue['FTPosCode']?>' 
                    data-max='<?=$aValue['FCLayColQtyMax']?>' 
                    data-havestk='<?=number_format($aValue['FCStkQty'],0);?>' 
                    data-refill='<?=number_format($aValue['AVGQTY'],0);?>'
                    data-row='<?= $aValue['FNLayRow']; ?>'
                    data-col='<?= $aValue['FNLayCol']; ?>'
                    >
                    <td class="text-left"><?= $aValue['FTPosName'] ?></td>
                    <td class="text-left"><?= $tPDTCode ?></td>
                    <td class="text-left"><?= str_replace("##"," ",$tPDTName); ?></td>
                    <td class="text-left"><?= $aValue['FNLayRow']; ?></td>
                    <td class="text-left"><?= $aValue['FNLayCol']; ?></td>
                    <td class="text-right"><?= number_format($aValue['FCStkQty'],0); ?></td>
                    <td class="text-left"><input 
                            type="text" 
                            maxlength="2"
                            class="text-right xCNInputNumericWithoutDecimal xCNInputLength xCNClassValueInProrate" 
                            maxlength="4"
                            data-valuedefault="<?=number_format($aValue['FCXtdQty'],0);?>"
                            value="<?=number_format($aValue['FCXtdQty'],0);?>">
                    </td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
    <p id="ospTextOver" style="display:none; color:red; font-weight:bold; text-align:right;"> จำนวนเติมเกินขนาดช่อง </p>
    <p id="ospTextMax" style="display:none; color:red; font-weight:bold; text-align:right;"> จำนวนเติมรวมทั้งหมด 'เกินกว่า' จำนวนคงเหลือ </p>
    <p id="ospTextMin" style="display:none; color:red; font-weight:bold; text-align:right;"> จำนวนเติมรวมทั้งหมด 'น้อยกว่า' จำนวนคงเหลือ </p>
</div>

<?php $aConvertToJS = json_encode($aQTYByPos); ?>

<script>
    //Prorate
    var aQTYByPos       = $.parseJSON('<?=$aConvertToJS?>');
    var nCountPos       = '<?=FCNnHSizeOf($aQTYByPos)?>';
    var nCountPDTFull   = '<?=$nFullRefill?>';
    var nQTY            = '<?=$nQTY?>';
    var nSumPercent     = 0;
    var aProratePrecent = [];
                    
    if('<?=$bCheckSave?>' == false){
        
        //หาเป็น percent
        for(var i=0; i<nCountPos; i++){
            var nQtyPDT = aQTYByPos[i].QTYAll;
            
            //ถ้าเป็นรอบสุดท้ายจะใช้อีกสูตร
            if(i == (nCountPos - 1)){
                for(var k=0; k<aProratePrecent.length; k++){
                    nSumPercent = nSumPercent + aProratePrecent[k];
                }
                var nResultProrate = 100 - nSumPercent;
                aProratePrecent.push(nResultProrate);
            }else{
                var nResultProrate = nQtyPDT * 100 / nCountPDTFull;
                aProratePrecent.push(Math.round(nResultProrate));
            }
        }

        //หาเป็นจำนวนชิ้น
        var nSumUnit     = 0;
        var aProrateUnit = [];
        for(var u=0; u<aProratePrecent.length; u++){
            var tPosCode        = aQTYByPos[u].POS;
            var nQTYPDTPercent  = aProratePrecent[u];

            //ถ้าเป็นรอบสุดท้ายจะใช้อีกสูตร
            if(u == (aProratePrecent.length - 1)){
                for(var m=0; m<aProrateUnit.length; m++){
                    nSumUnit = nSumUnit + aProrateUnit[m].QTY;
                }
                var nResultProrate = nQTY - nSumUnit;
                aProrateUnit.push({'POS' : tPosCode, 'QTY' : nResultProrate});
            }else{
                var nResultProrate = nQTYPDTPercent * nQTY / 100;
                aProrateUnit.push({'POS' : tPosCode, 'QTY' : Math.round(nResultProrate)});
            }
        }

        //เอาจำนวนที่หาได้ กลับไปใส่ตาม pos
        var nQTYUse     = 0;
        var nSTKBal     = 0;
        var bCheckSTK   = false;
        for(var m=0; m<aProrateUnit.length; m++){
            $('table > #otdTBodyTableProrateStep2  > tr').each(function(index, tr) { 
                var tPosTable   = $(tr).data('pos');
                var nMax        = $(tr).data('max');
                var nHaveSTK    = $(tr).data('havestk');
                if(tPosTable == aProrateUnit[m].POS){

                    if(bCheckSTK == true){
                        nQTYUse = nSTKBal - nQTYUse;
                    }else{
                        nQTYUse =  aProrateUnit[m].QTY - nQTYUse;
                    }
                    
                    nRefill = nMax - nHaveSTK;
                    if(nRefill >= nQTYUse){
                        nQTYUseShow = nQTYUse;
                        nSTKBal     = nQTYUse;
                        bCheckSTK   = true;

                        // console.log('IF' + 'ต้องเติม : ' + nSTKBal);
                    }else{
                        nQTYUseShow = nRefill;
                        nSTKBal     = nQTYUse - nQTYUseShow;
                        bCheckSTK   = false;

                        // console.log('ELSE' + 'ต้องเติม : ' + nSTKBal);
                    }

                    $(tr).find("input[type='text']").val(nSTKBal);
                    $(tr).find("input[type='text']").attr('data-valuedefault',nSTKBal);
                    nQTYUse = nSTKBal
                }else{
                    nQTYUse = 0;
                    bCheckSTK = false;
                }
            });
        }
    }
    
    //เปลี่ยนจำนวน
    var nCheckValue = 0;
    $('.xCNClassValueInProrate').on('change keyup', function(event){
        if(event.type == "change"){
            JSxChangeValueInProrate(this);
        }
        if(event.keyCode == 13) {
            JSxChangeValueInProrate(this);
        } 
    });

    //เปลี่ยนจำนวนใน prorate [edit inline]
    function JSxChangeValueInProrate(elem){
        //ทุกครั้งที่ key ต้องซ่อนข้อความ
        $('#ospTextMax').hide();
        $('#ospTextMin').hide();
        $('#ospTextOver').hide();

        //ล้างค่า
        nCheckValue = 0;

        var nNewQty = $(elem).val();
        $('table > #otdTBodyTableProrateStep2  > tr').each(function(index, tr) { 
            nCheckValue = parseInt(nCheckValue) + parseInt($(tr).find("input[type='text']").val());
        });

        //จำนวนรวมทั้งหมด มากกว่าจำนวนที่ต้องเติม
        if(nCheckValue > nQTY){
            $('#ospTextMax').show();
            $('#ospTextMax').text("จำนวนเติมรวมทั้งหมด 'เกินกว่า' จำนวนคงเหลือ " + '[ ' + nQTY + ' ชิ้น ]');
            var nValueOld    = $(elem).data('valuedefault'); 
            $(elem).val(nValueOld);
            $(elem).focus();
        }else{
            //จำนวนที่ต้องเติมได้
            var nRefill    = $(elem).parent().parent().data('refill'); 
            if(nNewQty > nRefill){
                $('#ospTextOver').show();
                var nValueOld    = $(elem).data('valuedefault'); 
                $(elem).val(nValueOld);
                $(elem).focus();
            }
        }
    }

    //กดยืนยัน prorate
    $('#osmConfirmStockByPosStep2').off();
    $('#osmConfirmStockByPosStep2').on('click',function(){
        //ทุกครั้งที่ key ต้องซ่อนข้อความ
        $('#ospTextMax').hide();
        $('#ospTextMin').hide();
        $('#ospTextOver').hide();

        //ล้างค่า
        nCheckValue         = 0;
        var aPackDataIns    = [];

        //หาจำนวน
        $('table > #otdTBodyTableProrateStep2  > tr').each(function(index, tr) { 
            var tPosTable   = $(tr).data('pos');
            var tPdtcode    = $(tr).data('pdtcode');
            var nRow        = $(tr).data('row');
            var nCol        = $(tr).data('col');

            nCheckValue     = parseInt(nCheckValue) + parseInt($(tr).find("input[type='text']").val());

            //เก็บตัวเลขเอาไว้ใน array
            tDataArray = {
                'POS' : tPosTable, 
                'PDT' : tPdtcode , 
                'ROW' : nRow ,
                'COL' : nCol ,
                'QTY' : $(tr).find("input[type='text']").val()
            }
            aPackDataIns.push(tDataArray);
        });

        //ถ้าจำนวนน้อยกว่า ต้องเติมให้ครบ
        if(nCheckValue < nQTY){
            $('#ospTextMin').show();
            $('#ospTextMin').text("จำนวนเติมรวมทั้งหมด 'น้อยกว่า' จำนวนคงเหลือ " + '[ ' + nQTY + ' ชิ้น ]');
            return;
        }else{
             //เอาจำนวนที่แก้ไปลงใน temp
            $.ajax({
                type    : "POST",
                url     : "docRVDRefillPDTVDStep2SaveInTemp",
                cache   : false,
                data    : { BCH : $('#oetRVDBchCode').val() ,tDocumentNumber : $('#oetRVDDocNo').val() , aPackDataIns : aPackDataIns},
                timeout : 0,
                success: function(oResult) {
                    $('#odvRVDModalStockByPosStep2').modal('hide');
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.log(jqXHR, textStatus, errorThrown);
                }
            });
        }

    });

</script>