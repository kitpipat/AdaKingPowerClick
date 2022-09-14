<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        	<th class="xCNTextBold" style="width:5%;"><?= language('document/transferreceipt/transferreceipt','tTWITBChoose')?></th>
						<?php endif; ?>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBBchCreate')?></th>
						<th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBDocNo')?></th>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBDocDate')?></th>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBStaDoc')?></th>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBStaApv')?></th>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBStaPrc')?></th>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBCreateBy')?></th>
                        <th class="xCNTextBold"><?= language('document/transferreceipt/transferreceipt','tTWITBApvBy')?></th>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						    <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <?php 
                            $tXthDocNo = $aValue['FTXthDocNo'];
                            if($aValue['FTXthStaApv'] == 1){
                                $CheckboxDisabled = "disabled";
                                $ClassDisabled = 'xCNDocDisabled';
                                $Title = language('document/document/document','tDOCMsgCanNotDel');
                                $Onclick = '';
                            }else{
                                $CheckboxDisabled = "";
                                $ClassDisabled = '';
                                $Title = '';
                                $Onclick = "onclick=JSnTWIDel('".$nCurrentPage."','".$tXthDocNo."')";
                            }

                            //FTXthStaDoc
                            if($aValue['FTXthStaDoc'] == 1){
                                $tClassStaDoc = 'text-success';
                            }else if($aValue['FTXthStaDoc'] == 2){
                                $tClassStaDoc = 'text-warning';    
                            }else if($aValue['FTXthStaDoc'] == 3){
                                $tClassStaDoc = 'text-danger';
                            }

                            //FTXthStaApv
                            if($aValue['FTXthStaApv'] == 1){
                                $tClassStaApv = 'text-success';
                            }else if($aValue['FTXthStaApv'] == 2 || $aValue['FTXthStaApv'] == ''){
                                $tClassStaApv = 'text-danger';    
                            }

                            //FTXthStaPrcStk
                            if($aValue['FTXthStaPrcStk'] == 1){
                                $tClassPrcStk = 'text-success';
                            }else if($aValue['FTXthStaPrcStk'] == 2){
                                $tClassPrcStk = 'text-warning';
                            }else if($aValue['FTXthStaPrcStk'] == 0 || $aValue['FTXthStaPrcStk'] == ''){
                                $tClassPrcStk = 'text-danger';    
                            }

                        ?>
                        <tr class="text-center xCNTextDetail2 otrPurchaseoeder" id="otrPurchaseoeder<?=$key?>" data-code="<?=$aValue['FTXthDocNo']?>" data-name="<?=$aValue['FTXthDocNo']?>">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?=$CheckboxDisabled?>>
										<span class="<?=$ClassDisabled?>">&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                            <td class="text-left"><?php echo $aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                            <td class="text-left"><?php echo $aValue['FTXthDocNo'] != '' ? $aValue['FTXthDocNo'] : '-' ?></td>
							<td class="text-left"><?php echo $aValue['FDXthDocDate'] != '' ? $aValue['FDXthDocDate'] : '-' ?></td>
							<td class="text-left"><label class="xCNTDTextStatus <?=$tClassStaDoc?>"><?php echo language('document/transferreceipt/transferreceipt','tTWIStaDoc'.$aValue['FTXthStaDoc']) ?></label></td>
							<td class="text-left"><label class="xCNTDTextStatus <?=$tClassStaApv?>"><?= language('document/transferreceipt/transferreceipt','tTWIStaApv'.$aValue['FTXthStaApv'])?></label></td>
							<td class="text-left"><label class="xCNTDTextStatus <?=$tClassPrcStk?>"><?php echo language('document/transferreceipt/transferreceipt','tTWIStaPrcStk'.$aValue['FTXthStaPrcStk']) ?></label></td>
							<td class="text-left"><?php echo $aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : '-' ?></td>
							<td class="text-left"><?php echo $aValue['FTXthApvName'] != '' ? $aValue['FTXthApvName'] : '-' ?></td> 
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            	<td>
									<img class="xCNIconTable xCNIconDel <?=$ClassDisabled?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" <?=$Onclick?> title="<?=$Title?>">
								</td>
							<?php endif; ?>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            	<td>
									<img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageTXIEdit('<?=$aValue['FTXthDocNo']?>')">
								</td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <button onclick="JSvClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDel">
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
				<!-- แก้ -->
				<button id="osmConfirm" onClick="JSoTXIDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<!-- แก้ -->
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<?php include('script/jTransferreceiptDataTable.php')?>
