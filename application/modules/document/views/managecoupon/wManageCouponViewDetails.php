<style>
    .xWFontBold{
        font-size:25px !important;
        font-weight: bold !important;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" style="margin-bottom:10px;">
        <?php if ($aDataList['tCode'] == '1') : ?>
        <div class="xWFontBold">เลขที่เอกสาร : <?=$aDataList['aItems'][0]['FTBkpRef1']?></div>
        <?php endif; ?>
    </div>
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbMCPTblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th nowrap class="xCNTextBold" width="5%"><?php echo language('document/managecoupon/managecoupon','ลำดับ')?></th>
						<th nowrap class="xCNTextBold" width="12.5%"><?php echo language('document/managecoupon/managecoupon','รหัสสินค้า')?></th>
						<th nowrap class="xCNTextBold" width="26%"><?php echo language('document/managecoupon/managecoupon','ชื่อสินค้า')?></th>
                        <th nowrap class="xCNTextBold" width="26%"><?php echo language('document/managecoupon/managecoupon','เครื่องจุดขาย')?></th>
                        <th nowrap class="xCNTextBold" width="16.5%"><?php echo language('document/managecoupon/managecoupon','รหัสอ้างอิง')?></th>
						<th nowrap class="xCNTextBold" width="7%"><?php echo language('document/managecoupon/managecoupon','จำนวน')?></th>
                        <th nowrap class="xCNTextBold" width="7%"><?php echo language('document/managecoupon/managecoupon','จำนวนรับ')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if ($aDataList['tCode'] == '1') : ?>
                        <?php foreach ($aDataList['aItems'] as $nKey => $aValue) : ?>
                            <tr class="text-center xCNTextDetail2 xWMCPDocItems" id="otrMCPItemsList<?=$nKey?>">
                                <td nowrap class="text-center"><?=$aValue['FNBkdSeq']?></td>
                                <td nowrap class="text-left"><?=$aValue['FTPdtCode']?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTPdtName'])) ? $aValue['FTPdtName'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTPosName'])) ? $aValue['FTPosName'] : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTBkdDocRef'])) ? $aValue['FTBkdDocRef'] : '-' ?></td>
                                <td nowrap class="text-right"><?=number_format($aValue['FCBkdQty'],$nOptDecimalShow)?></td>
                                <td nowrap class="text-right"><?=number_format($aValue['FCBkdQtyRcv'],$nOptDecimalShow)?></td>
                            <tr>
                            <?php endforeach; ?>
                        <?php else : ?>
                            <tr>
                                <td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main', 'tCMNNotFoundData') ?></td>
                            </tr>
                        <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
</div>