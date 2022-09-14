<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPITBChoose')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPITBNo')?></th>
                        <th class="xCNTextBold"><?=language('document/transferwarehouseout/transferwarehouseout','tTWODocNo')?></th>
                        <th class="xCNTextBold"><?=language('document/transferwarehouseout/transferwarehouseout','tTWOTablePDTBch')?></th>
                        <th class="xCNTextBold"><?=language('document/transferwarehouseout/transferwarehouseout','tTWOTablePDTShp')?></th>
                        <th class="xCNTextBold"><?=language('document/transferwarehouseout/transferwarehouseout','tTWOTablePDTName')?></th>
                        <th class="xCNTextBold"><?=language('document/transferwarehouseout/transferwarehouseout','tTWOTablePDTCode')?></th>
                        <th class="xCNTextBold"><?=language('document/transferwarehouseout/transferwarehouseout','tTWOTablePDTUnit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataCN['rtCode'] != 800){
                        $aItem = $aDataCN['raItems']; ?>
                        <?php for($i=0; $i<FCNnHSizeOf($aItem); $i++){ ?>
                            <tr 
                                class="text-center xCNTextDetail2 nItem<?=$i?> xWPdtItem"
                                data-index="<?=$aItem[$i]['rtRowID'];?>"
                                data-docno="<?=$aItem[$i]['FTXshDocNo'];?>"
                                data-pdtcode="<?=$aItem[$i]['FTPdtCode'];?>" 
                                data-pdtname="<?=$aItem[$i]['FTXsdPdtName'];?>"
                                data-puncode="<?=$aItem[$i]['FTPunCode'];?>"
                                data-seqitem="<?=$aItem[$i]['FNXsdSeqNo'];?>"
                                data-barcode="<?=$aItem[$i]['FTBarCode'];?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$aItem[$i]['rtRowID']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span></span>
                                    </label>
                                </td>
                                <td class="text-left"><?=$aItem[$i]['rtRowID'];?></td>
                                <td class="text-left"><?=$aItem[$i]['FTXshDocNo'];?></td>
                                <td class="text-left"><?=$aItem[$i]['FTBchName'];?></td>
                                <td class="text-left"><?=$aItem[$i]['FTShpName'];?></td>
                                <td class="text-left"><?=$aItem[$i]['FTXsdPdtName'];?></td>
                                <td class="text-left"><?=$aItem[$i]['FTPdtCode'];?></td>
                                <td class="text-left"><?=$aItem[$i]['FTPunName'];?></td>
                            </tr>
                        <?php } ?>
                    <?php }else{ ?>
                        <tr><td class="text-center xCNTextDetail2 xWTWOTextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<script>
    //เพิ่มสินค้าลง Tmp
    $('#osmConfirmPDTCN').click(function() {
        var aItem = [];
        $(".ocbListItem:checked").each(function() {
            var tRefSODocno    = $(this).parents('.xWPdtItem').data('docno');
            var tRefSOPdtCode  = $(this).parents('.xWPdtItem').data('pdtcode');
            var tRefSOPunCode  = $(this).parents('.xWPdtItem').data('puncode');
            var tRefSOBarCode  = $(this).parents('.xWPdtItem').data('barcode');
            var tRefSeqItem    = $(this).parents('.xWPdtItem').data('seqitem'); 
            aItem.push({
                'tDocNo'     : tRefSODocno,
                'pnPdtCode'  : tRefSOPdtCode,
                'ptPunCode'  : tRefSOPunCode,
                'ptBarCode'  : tRefSOBarCode,
                'ptSeqItem'  : tRefSeqItem
            });
        }); 

        var ptXthDocNoSend = $("#oetTWODocNo").val();
        if(aItem.length != 0){
            $.ajax({
                type    : "POST",
                url     : "TWOTransferwarehouseoutAddPdtIntoDTDocTemp",
                data    : {
                    'tTWODocNo'          : ptXthDocNoSend,
                    'tTWOPdtData'        : JSON.stringify(aItem),
                    'tType'              : 'CN'
                },
                cache   : false,
                timeout : 0,
                success : function (oResult){
                    aItem = [];
                    JSvTRNLoadPdtDataTableHtml();
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            console.log('no item');
        }
    });
</script>