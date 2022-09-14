<?php 
    // echo "<pre>"; print_r($aDataSummary); echo "</pre>"; 
    if( $aDataSummary['tCode'] == '1' ){
        $nSumQty  = $aDataSummary['aItems']['FNSumQty'];
        // $nSumPdt  = $aDataSummary['aItems']['FNSumPdt'];
        $nPageAll = $aDataSummary['aItems']['FNPageAll'];
        $nPageSel = $aDataSummary['aItems']['FNPageSel'];
    }else{
        $nSumQty  = 0;
        // $nSumPdt  = 0;
        $nPageAll = 0;
        $nPageSel = 0;
    }

    $tTextStickerPerPage    = language('product/settingprinter/settingprinter', 'tPRNPreviewTextStickerPerPage');
    $tTextStickerQty        = language('product/settingprinter/settingprinter', 'tPRNPreviewTextStickerQty');
    $tTextPageAll           = language('product/settingprinter/settingprinter', 'tPRNPreviewTextPageAll');
    $tTextPageSel           = language('product/settingprinter/settingprinter', 'tPRNPreviewTextPageSel');
?>

<input type="hidden" id="ohdPRNTextStickerPerPage" value="<?=$tTextStickerPerPage?>">
<input type="hidden" id="ohdPRNTextStickerQty" value="<?=$tTextStickerQty?>">
<!-- <input type="hidden" id="ohdPRNTextPageAll" value="<?=$tTextPageAll?>"> -->
<input type="hidden" id="ohdPRNTextPageSel" value="<?=$tTextPageSel?>">

<div class="xWPRNSection1" style="margin-bottom:10px;">
    <span id="ospPRNStickerPerPage<?=$nPrnType;?>"><?=str_replace("xxx", 0, $tTextStickerPerPage);?></span> <!-- จำนวนดวงต่อหน้า xxx ดวง -->
    <span id="ospPRNStickersQty<?=$nPrnType;?>"><?=str_replace("xxx", $nSumQty, $tTextStickerQty);?></span> <!-- จำนวนสติ๊กเกอร์ xxx ดวง -->
</div>
<table id="otbPRNPreviewHeader" class="table" style="margin-bottom: 0px;">
    <thead class="xCNPanelHeadColor">
        <tr>
            <th class="text-center" id="othCheckboxHide" style="width:3%;">
                <label class="fancy-checkbox">
                    <input id="ocbListItemAll" checked type="checkbox" class="ocbListItemAll xWPRNSelAll<?=$nPrnType;?>" name="ocbListItemAll[]" data-pritype="<?=$nPrnType;?>">
                    <span></span>
                </label>
            </th>
            <th class="xCNTextBold text-center" style="width:10%;color:white !important;vertical-align: middle;"><?php echo language('product/settingprinter/settingprinter', 'tPRNPreviewPage') ?></th>
            <th class="xCNTextBold text-center" style="width:10%;color:white !important;vertical-align: middle;"><?php echo language('document/document/document', 'tDocNumber') ?></th>
            <th class="xCNTextBold text-center" style="width:20%;color:white !important;vertical-align: middle;"><?php echo language('product/settingprinter/settingprinter', 'tLPRTPdtBarCode') ?></th>
            <th class="xCNTextBold text-center" style="width:37%;color:white !important;vertical-align: middle;"><?php echo language('product/settingprinter/settingprinter', 'tLPRTPdtName') ?></th>
            <th class="xCNTextBold text-center" style="width:10%;color:white !important;vertical-align: middle;"><?php echo language('product/settingprinter/settingprinter', 'tPRNPreviewUnit') ?></th>
            <th class="xCNTextBold text-center" style="width:10%;color:white !important;vertical-align: middle;"><?php echo language('product/settingprinter/settingprinter', 'tLPRTTotalPrint') ?></th>
        </tr>
    </thead>
</table>
<div class="table-responsive" style="height: 387px;">
    <table id="otbPRNPreview" class="table">
        <tbody>
            <?php if ($aDataList['tCode'] == '1') : ?>
                <?php foreach ($aDataList['aItems'] as $key => $aValue) { ?>
                    <tr class="text-center xCNTextDetail2" id="otrLabPri<?=$aValue['FNSeq']?>" data-seq="<?=$aValue['FNSeq']?>" data-code="<?=$aValue['FTBarCode']?>" data-name="<?=$aValue['FTPdtName']?>">
                        <?php if( $aValue['FNGroupPage'] == 1 ): ?>
                            <td class="text-center" style="width:4.3%;vertical-align: middle;" rowspan="<?=$aValue['FNGroupPageMax']?>">
                                <label class="fancy-checkbox">
                                    <input id="ocbListItem<?=$aValue['FNPage']?>" <?php if( $aValue['FTPlbStaSelect'] == '1' ){ echo "checked"; } ?> type="checkbox" class="ocbListItem xWPRNSel<?=$aValue['FTPlbPriType'];?>" name="ocbListItem[]" data-page="<?php echo $aValue['FNPage']; ?>" data-pritype="<?php echo $aValue['FTPlbPriType']; ?>">
                                    <span></span>
                                </label>
                            </td>
                            <td class="text-center" style="width:9.8%;vertical-align: middle;" rowspan="<?=$aValue['FNGroupPageMax']?>"><?=$aValue['FNPage']?></td>
                        <?php endif; ?>
                        <td style="width:10%;" class="text-center"><?=$aValue['FNSeq']?></td>
                        <td style="width:19.8%;" class="text-left"><?=$aValue['FTBarCode']?></td>
                        <td style="width:36.7%;" class="text-left"><?=$aValue['FTPdtName']?></td>
                        <td style="width:9.9%;" class="text-left"><?=$aValue['FTPdtContentUnit']?></td>
                        <td style="width:10%;" class="text-right" style="padding-right: 10px;"><?=$aValue['FNPlbQty']?></td>
                    </tr>
                <?php } ?>
            <?php else : ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='6'><?php echo language('product/settingprinter/settingprinter', 'tLPRTNotFoundData') ?></td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>
<div class="xWPRNSection3" style="margin-top:15px;">
    <span id="ospPRNPageAll<?=$nPrnType;?>"><?=str_replace("xxx", $nPageAll, $tTextPageAll);?></span> <!-- จำนวนทั้งหมด xxx หน้า  -->
    <span id="ospPRNPageSelected<?=$nPrnType;?>"><?=str_replace("xxx", $nPageSel, $tTextPageSel);?></span> <!-- จำนวนที่สั่งพิมพ์ xxx หน้า -->
    <input id="ohdPRNPageSelected<?=$nPrnType;?>" type="hidden" value="<?=$nPageSel?>">
</div>

<script>

    var nPriType = <?=$nPrnType;?>;
    if( nPriType == 1 ){
        nStickPerPage = $('#ohdPRNRptNormalQtyPerPage').val();
    }else{
        nStickPerPage = $('#ohdPRNRptPromotionQtyPerPage').val();
    }
    var tTextStickerPerPage = $('#ohdPRNTextStickerPerPage').val().replace("xxx", nStickPerPage);
    $('#ospPRNStickerPerPage'+nPriType).html(tTextStickerPerPage);

    $('#otbPRNPreview .ocbListItem').off().on('click',function() {
        var nPriType = $(this).attr('data-pritype');
        if ($('#otbPRNPreview .xWPRNSel'+nPriType+':checked').length == $('#otbPRNPreview .xWPRNSel'+nPriType).length) {
            $('#otbPRNPreview .xWPRNSelAll'+nPriType).prop('checked', true);
        } else {
            $('#otbPRNPreview .xWPRNSelAll'+nPriType).prop('checked', false);
        }

        if ($(this).is(":checked")) {
            var tValueChecked = 'true'; 
        } else {
            var tValueChecked = 'false';
        }

        var aData = {
            pnPage          : $(this).attr('data-page'),
            ptPriType       : nPriType,
            ptValueChecked  : tValueChecked,
            ptSelType       : 'One'
        };
        JSxPRNPreviewUpdStaSel(aData);
    });

    $('#otbPRNPreviewHeader .ocbListItemAll').off().on('click',function() {
        var nPriType = $(this).attr('data-pritype');
        $('#otbPRNPreview .xWPRNSel'+nPriType).prop('checked', this.checked);

        var aData = {
            pnPage          : '',
            ptPriType       : nPriType,
            ptValueChecked  : this.checked,
            ptSelType       : 'All'
        };
        JSxPRNPreviewUpdStaSel(aData);
    });

    function JSxPRNPreviewUpdStaSel(paData){
        var nPriType = paData['ptPriType'];
        $.ajax({
            type: "POST",
            url: "PrintBarCodeUpdStaSelHDTmp",
            data: {
                ptValueChecked   : paData['ptValueChecked'],
                pnPage           : paData['pnPage'],
                ptPriType        : nPriType,
                ptSelType        : paData['ptSelType']
            },
            cache: false,
            Timeout: 0,
            success: function(oResult) {
                var aResult = JSON.parse(oResult);
                // console.log(aResult);
                if( aResult['tCode'] == '1' ){
                    // var nSumPdt     = aResult['aItems']['FNSumPdt'];
                    var nSumQty     = aResult['aItems']['FNSumQty'];
                    var nPageAll    = aResult['aItems']['FNPageAll'];
                    var nPageSel    = aResult['aItems']['FNPageSel'];
                }else{
                    // var nSumPdt     = 0;
                    var nSumQty     = 0;
                    var nPageAll    = 0;
                    var nPageSel    = 0;
                }

                if( nPriType == 1 ){
                    nStickPerPage = $('#ohdPRNRptNormalQtyPerPage').val();
                }else{
                    nStickPerPage = $('#ohdPRNRptPromotionQtyPerPage').val();
                }

                var tTextStickerPerPage = $('#ohdPRNTextStickerPerPage').val().replace("xxx", nStickPerPage);
                var tTextStickerQty     = $('#ohdPRNTextStickerQty').val().replace("xxx", nSumQty);
                // var tTextPageAll     = $('#ohdPRNTextPageAll').val().replace("xxx", nPageAll);
                var tTextPageSel        = $('#ohdPRNTextPageSel').val().replace("xxx", nPageSel);
                
                $('#ospPRNStickerPerPage'+nPriType).html(tTextStickerPerPage);
                $('#ospPRNStickersQty'+nPriType).html(tTextStickerQty);
                // $('#ospPRNPageAll'+nPriType).html("จำนวนทั้งหมด "+nPageAll+" หน้า");
                $('#ospPRNPageSelected'+nPriType).html(tTextPageSel);
                $('#ohdPRNPageSelected'+nPriType).val(nPageSel);


                var tPriceType    = $('#ocbPrnBarSheet').val();
                // console.log(tPriceType);
                if( tPriceType != "All" ){
                    // console.log(nPageSel);
                    // ถ้าเลือก ราคาปกติ หรือราคาโปรโมชั่น ให้เช็คจำนวนหน้าที่สั่งพิมพ์ ของตัวเอง
                    if( nPageSel == 0 ){
                        $('#osmConfirmSendPrint').attr('disabled', true);
                    }else{
                        $('#osmConfirmSendPrint').attr('disabled', false);
                    }
                }else{
                    // ถ้าเลือก ทั้งคู่ ให้เช็คจำนวนหน้าที่สั่งพิมพ์ ของ Normal และPromotion ด้วย
                    var nNormalPageSelected     = $('#ohdPRNPageSelected1').val();
                    var nPromotionPageSelected  = $('#ohdPRNPageSelected2').val();
                    // console.log(nNormalPageSelected);
                    // console.log(nPromotionPageSelected);
                    if( nNormalPageSelected == 0 && nPromotionPageSelected == 0 ){
                        $('#osmConfirmSendPrint').attr('disabled', true);
                    }else{
                        $('#osmConfirmSendPrint').attr('disabled', false);
                    }
                }

            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>