<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCPdtTable">
        <thead>
            <tr>
                <th width="8%" class="text-center othShowChkbox">
                    <label class="fancy-checkbox">
                        <input type="checkbox" class="ocbHeadCheckBox xCNApvOrCanCelDisabled" name="oetAllCheck" id="oetAllCheck">
                        <span style="font-family: THSarabunNew-Bold; font-weight: 500;">
                            <!-- <?=language('document/TopupVending/TopupVending', 'tTBChoose');?> -->
                        </span>
                    </label>
                </th>
                <th width="5%" class="text-center"><?php echo language('document/TopupVending/TopupVending', 'tTBNo'); ?></th>
                <th width="15%" class="text-left"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtCodeName'); ?></th>
                <th class="text-left"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtName'); ?></th>
                <th width="10%" class="text-left"><?php echo language('document/TopupVending/TopupVending', 'tChannelGroup'); ?></th>
                <th width="5%" class="text-center"><?php echo language('document/TopupVending/TopupVending', 'tRow'); ?></th>
                <th width="5%"class="text-center"><?php echo language('document/TopupVending/TopupVending', 'tColumn'); ?></th>
                <th width="10%" class="text-right othShowChkbox"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtBalance'); ?></th>
                <th width="10%" class="text-right"><?php echo language('document/TopupVending/TopupVending', 'tTFXVDPdtMaxTransfer'); ?></th>
                <th width="10%" class="text-right"><?php echo language('document/TopupVending/TopupVending', 'tRefillQty'); ?></th>
                <th width="5%" class="othShowChkbox text-center"><?php echo language('document/TopupVending/TopupVending', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody id="odvTBodyTUVPdtAdvTableList">
            <?php if ($aDataList['rtCode'] == 1) { ?>
                <?php foreach ($aDataList['raItems'] as $key => $aValue) { ?>
                    <tr class="xCNTextDetail2 xCNTopUpVendingPdtLayoutRow" 
                        data-id ="<?php echo $aValue['FNRowID']; ?>"
                        data-seq-no="<?php echo $aValue['FNXtdSeqNo']; ?>"
                        data-checkSTK="<?php echo $aValue['FTXtdStaPrcStk']; ?>"
                        data-stkshop="<?php echo number_format($aValue['FCXtdQtyAll']);?>"
                        >
                        <td class="text-center otdShowChkbox">
                            <label class="fancy-checkbox">
                                <input id="ocbListItem<?=$aValue['FNRowID'];?>" type="checkbox" class="ocbListItem xCNApvOrCanCelDisabled" name="ocbListItem[]">
                                <span></span>
                            </label>
                        </td>
                        <td class="text-center"><?php echo $key+1; ?></td>
                        <td class="text-left xCNTopUpVendingPdtLayoutPdtCode"><?php echo $aValue['FTPdtCode']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTXtdPdtName']; ?></td>
                        <td class="text-left"><?php echo $aValue['FTCabNameForTWXVD']; ?></td>
                        <td class="text-center"><?php echo number_format($aValue['FNLayRowForTWXVD']); ?></td>
                        <td class="text-center"><?php echo number_format($aValue['FNLayColForTWXVD']); ?></td>
                        <td class="text-right xCNTopUpVendingPdtLayoutStkQty othShowChkbox"><?php echo number_format($aValue['FCStkQty']); ?></td>
                        <td class="text-right xCNTopUpVendingPdtLayoutMaxQty"><?php echo number_format($aValue['FCLayColQtyMaxForTWXVD']); ?></td>
                        <td class="text-right">
                            <input 
                            type="text" 
                            class="text-right xCNTopUpVendingQty xCNInputNumericWithoutDecimal xCNInputLength xCNApvOrCanCelDisabledQty xCNApvOrCanCelDisabled" 
                            data-length="3"
                            value="<?php echo number_format($aValue['FCXtdQty']); ?>">
                        </td>
                        <td class="text-center othShowChkbox">
                            <img class="xCNIconTable xCNIconDel xCNApvOrCanCelDisabled" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                        </td>
                    </tr>
                <?php } ?>
            <?php } else { ?>
                <tr class='xWNotFoundData'>
                    <td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main', 'tCMNNotFoundData') ?></td>
                </tr>
            <?php }; ?>
        </tbody>
    </table>
</div>

<!-- ============================================================== ลบสินค้าแบบหลายตัว  ============================================================ -->
<div id="odvTUVModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type="hidden" id="ohdConfirmTUVSeqNoDelete" name="ohdConfirmTUVSeqNoDelete">
                <input type="hidden" id="ohdConfirmTUVPdtCodeDelete" name="ohdConfirmTUVPdtCodeDelete">
            </div>

            <div class="modal-footer">
				<button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm') ?></button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
			</div>
        </div>
    </div>
</div>

<!-- ============================================================== ลบสินค้าแบบหลายตัว  ============================================================ -->


<?php include('script/jTopupVendingPdtDataTable.php'); ?>