<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbDOCPdtTable">
        <thead>
            <tr class="xCNCenter ">
                <th width="5%" class="text-center othShowChkbox">
                    <label class="fancy-checkbox">
                        <input type="checkbox" class="ocbHeadCheckBox" name="oetAllCheck" id="oetAllCheck">
                        <span></span>
                    </label>
                </th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tADJVDTBNo'); ?></th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtCodeName'); ?></th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtName'); ?></th>
                <th><?= language('vending/cabinet/cabinet', 'tTiTleCabinetHead'); ?></th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtRow'); ?></th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtCol'); ?></th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtDateInput'); ?></th>
                <th><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtTimeInput'); ?></th>
                <th class="othShowBalance"><?= language('document/adjuststockvd/adjuststockvd', 'ยอดก่อนนับ'); ?></th>
                <th style="width:130px;"><?= language('document/adjuststockvd/adjuststockvd', 'tTFXVDPdtCounted'); ?></th>
                <th class="othShowBalance"><?= language('document/adjuststockvd/adjuststockvd', 'ผลต่าง [+-]'); ?></th>
                <th class="othShowBalance"><?= language('document/adjuststockvd/adjuststockvd', 'คงเหลือหลังตรวจนับ'); ?></th>
                <th width="5%" class="othShowChkbox text-center"><?php echo language('document/TopupVending/TopupVending', 'tTBDelete'); ?></th>
            </tr>
        </thead>
        <tbody id="odvTBodyADJVDPdtAdvTableList">
            <?php
                if($aDataList['rtCode'] == 1 ){
                    foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="xWPdtItem xCNADJVendingPdtLayoutRow" 
                            data-id="<?=$aValue['FNRowID'];?>"
                            data-seq-no="<?=$aValue['FNXtdSeqNo'];?>" 
                            data-pdtCode="<?=$aValue['FTPdtCode'];?>"
                            data-pdtName="<?=$aValue['FTPdtName'];?>"
                            data-seq-cabinet ="<?=$aValue["FNCabSeqForTWXVD"];?>"
                            >
                            <td nowrap class="text-center otdShowChkbox">
                                <label class="fancy-checkbox">
                                    <input id="ocbListItem<?=$aValue['FNRowID'];?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                    <span></span>
                                </label>
                            </td>
                            <td class="text-center"><label><?= $aValue["FNRowID"]; ?></label></td>
                            <td nowrap class="xCNADJVendingPdtLayoutPdtCode"><label><?= $aValue["FTPdtCode"]; ?></label></td>
                            <td style="max-width: 200px !important;"><label><?= $aValue["FTPdtName"]; ?></label></td>
                            <td style="max-width: 200px !important;"><label><?= $aValue["FTCabName"]; ?></label></td>
                            <td nowrap class="text-center"><label><?= $aValue["FNLayRowForADJSTKVD"]; ?></label></td>
                            <td nowrap class="text-center"><label><?= $aValue["FNLayColForADJSTKVD"]; ?></label></td>
                            <td>
                                <label>
                                    <?php if($aValue["FCDateTimeInputForADJSTKVD"] != ''){ 
                                        echo date("d/m/Y",strtotime($aValue["FCDateTimeInputForADJSTKVD"])); 
                                    } ?>
                                </label>
                            </td>
                            <td>
                                <label>
                                    <?php if($aValue["FCDateTimeInputForADJSTKVD"]!=""){ 
                                        echo date("H:i:s",strtotime($aValue["FCDateTimeInputForADJSTKVD"])); 
                                    } ?>
                                </label>
                            </td>
                            <td class="otdShowBalance text-right"><label><?= number_format($aValue["FCAjdWahB4Adj"]); ?></label></td>
                            <td class="text-right">
                                <!--จำนวนตรวจนับควรจะ defulat เอาคงเหลือมาโชว์ -->
                                <?php
                                    $tKeyADJQty = number_format($aValue['FCUserInPutForADJSTKVD']);
                                ?>
                                <input 
                                    type="text" 
                                    class="text-right xCNADJVDKeyQty xCNInputNumericWithoutDecimal xCNInputLength xCNApvOrCanCelDisabledQty" 
                                    data-length="3"
                                    value="<?=$tKeyADJQty?>"
                                    style="min-width: 100px;"
                                >
                            </td>
                            <td class="otdShowBalance text-right"><label><?= number_format($aValue["FCStkQty"]); ?></label></td>
                            <td class="otdShowBalance text-right"><label><?= number_format($aValue["FCAjdWahB4Adj"] + $aValue["FCStkQty"]); ?></label></td>
                            <td class="text-center othShowChkbox">
                                <img class="xCNIconTable xCNIconDel xCNApvOrCanCelDisabledDelete" onclick="JSxDeletePDTInTmp(this)" src="<?= base_url('application/modules/common/assets/images/icons/delete.png') ?>">
                            </td>
                        </tr>
                    <?php } ?>
                <?php }else{ ?>
                    <tr><td colspan="100%" class="text-center xCNNotfound"><span><?=language('common/main/main','tCMNNotFoundData')?></span></td></tr>
                <?php } ?>
        </tbody>
    </table>
</div>

<div class="row" id="odvPaginationBtn">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?></p>
    </div>
</div>

<!--สินค้า มีการตรวจนับเป็น 0-->
<div class="modal fade" id="odvADJVDCheckItemHaveAdjZero">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('document/document/document','tDocStawarning'); ?></label>
			</div>
			<div class="modal-body">
				<p id="obpMsgApv"><?=language('document/adjuststockvd/adjuststockvd','tDocADJZero'); ?> 
			</div>
			<div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xCNConfrimCheckItemHaveAdjZero">
					<?=language('common/main/main', 'tModalConfirm'); ?>
				</button>
				<button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel'); ?>
				</button>
			</div>
		</div>
	</div>
</div>



<!-- ============================================================== ลบสินค้าแบบหลายตัว  ============================================================ -->
<div id="odvADJVDModalDelPdtInDTTempMultiple" class="modal fade" tabindex="-1" role="dialog">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
			<div class="modal-body">
				<span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type="hidden" id="ohdConfirmADJVDSeqNoDelete" name="ohdConfirmADJVDSeqNoDelete">
				<input type="hidden" id="ohdConfirmADJVDPdtCodeDelete" name="ohdConfirmADJVDPdtCodeDelete">
				<input type="hidden" id="ohdConfirmADJVDSeqCabinetDelete" name="ohdConfirmADJVDSeqCabinetDelete">
                <input type="hidden" id="ohdConfirmADJVDShopDelete" name="ohdConfirmADJVDShopDelete">
			</div>

			<div class="modal-footer">
				<button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm') ?></button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
			</div>
		</div>
	</div>		
</div>		
<!-- ============================================================== ลบสินค้าแบบหลายตัว  ============================================================ -->


<?php include('script/jAdjVDEditinline.php'); ?>

