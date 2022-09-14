<div class="table-responsive">
    <?php 
        // Create By : Napat(Jame) 17/12/2020
        if( $aDataList['rtCode'] == 1 ){
            $tAllPdtInDB = "'";
            $nCount      = 0;
            foreach ($aDataList['aAllItemsInDB'] as $key => $aValue) { 
                $nCount++;
                if( FCNnHSizeOf($aDataList['aAllItemsInDB']) == $nCount ){
                    $tAllPdtInDB .= $aValue['FTPdtCode'];
                }else{
                    $tAllPdtInDB .= $aValue['FTPdtCode']."','";
                }
                
            }
            $tAllPdtInDB .= "'";
        }else{
            $tAllPdtInDB = "";
        }
    ?>
    <input type="hidden" id="oetTVOAllPdtInDB" value="<?=$tAllPdtInDB;?>">
    <table class="table table-striped xWPdtTableFont" id="otbDOCPdtTable">
        <thead>
            <tr>
                <th style="min-width: 50px;width: 50px;" class="text-center xCNCheckboxWhenDelete">
                    <label class="fancy-checkbox">
                        <input type="checkbox" class="ocbHeadCheckBox xCNApvOrCanCelDisabled" name="oetAllCheck" id="oetAllCheck">
                        <span style="font-family: THSarabunNew-Bold; font-weight: 500;">
                            <!-- <?=language('document/TopupVending/TopupVending', 'tTBChoose');?> -->
                        </span>
                    </label>
                    <!-- <?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTBChoose'); ?> -->
                </th>
                <th style="min-width: 50px;width: 50px;vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTBNo'); ?></th>
                <th style="vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTFXVDPdtCodeName'); ?></th>
                <th style="vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTFXVDPdtName'); ?></th>
                <th style="vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tChannelGroup'); ?></th>
                <th style="min-width: 50px;width: 50px;vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRow'); ?></th>
                <th style="min-width: 50px;width: 50px;vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tColumn'); ?></th>
                <th style="min-width: 65px;width: 65px;vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTFXVDPdtBalance'); ?></th>
                <th style="vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTFXVDPdtMaxTransfer'); ?></th>
                <th style="vertical-align: middle;" class="text-center"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tRefillQty'); ?></th>
                <th style="min-width: 50px;width: 50px;vertical-align: middle;" class="text-center xCNCheckboxWhenDelete"><?php echo language('document/TransferVendingOut/TransferVendingOut', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody>
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNTopUpVendingPdtLayoutRow" data-pdtcode="<?php echo $aValue['FTPdtCode']; ?>" data-pdtname="<?php echo $aValue['FTXtdPdtName']; ?>" data-seq-no="<?php echo $aValue['FNXtdSeqNo']; ?>" data-max-qty="<?=number_format($aValue['FCLayColQtyMaxForTWXVD']);?>" data-stk-qty="<?=number_format($aValue['FCStkQty']);?>" >
                        <td class="text-center xCNCheckboxWhenDelete">
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?php echo $aValue['FNXtdSeqNo']?>" type="checkbox" class="ocbListItem xCNApvOrCanCelDisabledQty" name="ocbListItem[]">
                                <span>&nbsp;</span>
                            </label>
                        </td>
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left xCNTopUpVendingPdtLayoutPdtCode"><?php echo $aValue['FTPdtCode']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTXtdPdtName']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTCabNameForTWXVD']; ?></td>
                        <td class="text-center"><?php echo number_format($aValue['FNLayRowForTWXVD']); ?></td>
                        <td class="text-center"><?php echo number_format($aValue['FNLayColForTWXVD']); ?></td>
                        <td class="text-right xCNTopUpVendingPdtLayoutStkQty"><?php echo number_format($aValue['FCStkQty']); ?></td>
                        <td class="text-left"><?php echo $aValue['FTWahName']; ?></td> <!-- xCNTopUpVendingPdtLayoutMaxQty number_format($aValue['FCLayColQtyMaxForTWXVD']); -->
                        <td class="text-right">
                            <input 
                                type="text" 
                                class="text-right xCNPdtEditInLine xWFCXtdQty xCNInputNumericWithoutDecimal xCNInputLength xCNApvOrCanCelDisabledQty" 
                                data-length="3"
                                data-field="FCXtdQty"
                                value="<?php echo number_format($aValue['FCXtdQty']); ?>"
                                style=" background: rgb(249, 249, 249);
                                        box-shadow: 0px 0px 0px inset;
                                        border-top: 0px !important;
                                        border-left: 0px !important;
                                        border-right: 0px !important;
                                        padding: 0px !important; 
                                        max-width: 50px; "
                            >
                        </td>
                        <td class="text-center xCNCheckboxWhenDelete">
                            <img class="xCNIconTable xCNIconDel" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!-- Modal Delete Items -->
<div class="modal fade" id="odvTVOModalDelPdt">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
                <input type='hidden' id="ohdConfirmIDDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" data-dismiss="modal" onClick="JSxTVOPdtDelChoose('<?=@$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<?php include('script/jTransferVendingOutPdtDataTable.php'); ?>