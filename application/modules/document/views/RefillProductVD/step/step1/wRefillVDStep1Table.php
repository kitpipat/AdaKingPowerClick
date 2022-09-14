<div class="table-responsive">
    <table class="table table-striped xCNTableStep1">
        <thead>
            <tr>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBBch')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBShp')?></th>
                <th class="xCNTextBold text-left"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBPos')?></th>
                <th class="xCNTextBold text-center xCNhideWhenApproveOrCancel" style="width:8%;"><?= language('common/main/main','tCMNActionDelete')?></th>
            </tr>
        </thead>
        <tbody id="otdTBodyTableStep1">
            <?php if($aDataList['rtCode'] == 1 ){?>
                <?php foreach($aDataList['raItems'] AS $nKey => $aValue){ ?>
                    <?php $nSeqNo   = $aValue['FNXtdSeqNo']; ?>
                    <?php $tBCHCode = $aValue['FTBchCode']; ?>
                    <tr>
                        <td class="text-left"><?= (!empty($aValue['FTBchName']))? $aValue['FTBchName'] : '-' ?></td>
                        <td class="text-left"><?= (!empty($aValue['FTShpName']))? $aValue['FTShpName'] : '-' ?></td>
                        <td class="text-left"><?= (!empty($aValue['FTPosName']))? $aValue['FTPosName'] : '-' ?></td>
                        <td class="text-center xCNhideWhenApproveOrCancel">
                            <img class="xCNIconTable xCNIconDel" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onclick="JSxDeleteStep1('<?=$tBCHCode?>','<?=$nSeqNo?>');" title="ลบช้อมูล">
                        </td>
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

    //ลบข้อมูลตามรายงานของ step1
    function JSxDeleteStep1(ptBchCode,pnSeq){
        $.ajax({
            type    : "POST",
            url     : "docRVDRefillPDTVDDeleteStep1",
            cache   : false,
            data    : { tDocumentNumber : $('#oetRVDDocNo').val() , tBCHCode : ptBchCode , nSeq : pnSeq },
            timeout : 0,
            success: function(oResult) {
                JSvRVDCallTableStep1();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>