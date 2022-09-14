<div class="table-responsive">
    <table class="table table-striped xCNTableStep3">
        <thead>
            <tr>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDCodePDT')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDNamePDT')?></th>
                <th class="xCNTextBold text-right"  style="width:12%;"><?=language('document/RefillProductVD/RefillProductVD','tRVDQtyRefillTotal')?></th>
            </tr>
        </thead>
        <tbody id="otdTBodyTableStep3">
            <?php if($aDataList['rtCode'] == 1 ){?>
                <?php foreach($aDataList['raItems'] AS $nKey => $aValue){ ?>
                    <tr class="xCNPdtTableStep2"  id="otrPdtTable2<?=$nKey?>"
                        data-pdtcode="<?= $aValue['FTPdtCode']; ?>"
                        data-seqno="<?= $aValue['FNXtdSeqNo']; ?>"
                        data-checkstk="<?= $aValue['FCXtdAmt']; ?>" >
                        <td class="text-left"><?= (!empty($aValue['FTPdtCode']))? $aValue['FTPdtCode'] : '-' ?></td>
                        <td class="text-left"><?= (!empty($aValue['FTXtdPdtName']))? $aValue['FTXtdPdtName'] : '-' ?></td>
                        <?php 
                            $nRefill = $aValue['FCLayColQtyMaxForTWXVD'] - $aValue['FCXtdAmt'];
                            if($nRefill <= $aValue['FCXtdQty']){
                                $nRefill = $nRefill;
                            }else{
                                $nRefill = $aValue['FCXtdQty'];
                            }
                            $nTotal = $nRefill + $aValue['FCStkQty'];
                        ?>
                        <td class="text-right xCNShowWhenApv"><b><?=number_format($aValue['FCXtdQty']);?></b></td>
                        <td class="text-right xCNCheckSTKBal"><b><?=number_format($nTotal);?></b></td>
                        <td class="text-right xCNNotCheckSTKBal"><b><?=number_format($aValue['FCLayColQtyMaxForTWXVD']);?></b></td>
                    </tr>
                <?php } ?>
            <?php }else{ ?>
                <tr class="otrDataNotFound">
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td>
                </tr>
            <?php } ?>
        </tbody>
    </table>
</div>

<script>
    //เช็คว่าเอกสารอนุมัติ หรือ ยกเลิกหรือเปล่า
    JSxControlWhenApproveOrCancel();

    $(document).ready(function(){

        $('.xCNShowWhenApv').hide();
        $('#ocbRVDStaFullRefillPos').change(function() {
           var nValue = $('#ocbRVDStaFullRefillPos:checked').val();
           if(nValue == 'on'){
                $('.xCNCheckSTKBal').show();
                $('.xCNNotCheckSTKBal').hide();

                JSxCheckRefillNotInZeroStep3();
           }else{
                $('.xCNCheckSTKBal').hide();
                $('.xCNNotCheckSTKBal').show();

                JSxCheckRefillShowInZeroStep3();
           }
        });

        var tCheckSTKBal = $('#ocbRVDStaFullRefillPos:checked').val();
        if(tCheckSTKBal == 'on'){
            $('.xCNCheckSTKBal').show();
            $('.xCNNotCheckSTKBal').hide();

            JSxCheckRefillNotInZeroStep3();
        }else{
            $('.xCNCheckSTKBal').hide();
            $('.xCNNotCheckSTKBal').show();

            JSxCheckRefillShowInZeroStep3();
        }

        //ถ้าอนุมัติเเล้วต้องโชว์จำนวนใน DT
        if($('#ohdRVDStaApv').val() == 1){
            $('.xCNShowWhenApv').show();
            $('.xCNCheckSTKBal').hide();
            $('.xCNNotCheckSTKBal').hide();
        }

    }); 

    //ถ้าเช็คสต๊อกต้นทาง ต้องห้ามให้มีการเติม 0
    function JSxCheckRefillNotInZeroStep3(){
        $('.otrDataNotFound').remove();
        var nLength = $('.xCNTableStep3 tbody tr').length;
        for(j=0; j<nLength; j++){
            var nQTY = $('.xCNTableStep3 tbody tr:eq('+j+') td:eq(2)').text();
            if(nQTY == 0){
                $('.xCNTableStep3 tbody tr:eq('+j+')').addClass('xCNWillRemoveTable');
            }
        }

        $('.xCNTableStep3 tbody .xCNWillRemoveTable').hide();
        var nLength         = $('.xCNTableStep3 tbody tr.xCNWillRemoveTable').length;
        var nLengthTable    = $('.xCNTableStep3 tbody tr').length;
        if(nLength == nLengthTable){
            var tText = "<?=language('common/main/main','tCMNNotFoundData')?>" + " หรือ สต็อกคงเหลือคลังต้นทาง ไม่พอสำหรับการเติม";
            var tHTML = "<tr class='otrDataNotFound'>";
                tHTML += "<td class='text-center xCNTextDetail2' colspan='100%'>"+tText+"</td>";
                tHTML += "</tr>";

            $('.xCNTableStep3 tbody').append(tHTML);
        }
    }

    //ถ้าเป็นไม่สนใจสต๊อกต้องเอากลับมาโชว์
    function JSxCheckRefillShowInZeroStep3(){
        $('.otrDataNotFound').remove();
        $('.xCNTableStep3 tbody .xCNWillRemoveTable').show();
    }

</script>