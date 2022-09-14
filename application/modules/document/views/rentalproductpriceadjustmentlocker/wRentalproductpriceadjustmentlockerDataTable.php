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
                        	<th class="xCNTextBold" style="width:5%;"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBChoose')?></th>
						<?php endif; ?>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBBchCreate')?></th>
						<th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBDocNo')?></th>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBDocDate')?></th>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBStaDoc')?></th>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBStaApv')?></th>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBStaPrc')?></th>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBCreateBy')?></th>
                        <th class="xCNTextBold"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWTBApvBy')?></th>
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
                            $tXthDocNo = $aValue['FTXphDocNo'];
                            if($aValue['FTXphStaApv'] == 1 || $aValue['FTXphStaApv'] == 2 || $aValue['FTXphStaDoc'] == 3){
                                $CheckboxDisabled = "disabled";
                                $ClassDisabled = 'xCNDocDisabled';
                                $Title = language('document/document/document','tDOCMsgCanNotDel');
                                $Onclick = '';
                            }else{
                                $CheckboxDisabled = "";
                                $ClassDisabled = '';
                                $Title = '';
                                $Onclick = "onclick=JSnTFWDel('".$nCurrentPage."','".$tXthDocNo."')";
                            }

                            //FTXphStaDoc
                            if($aValue['FTXphStaDoc'] != 3){
                                if($aValue['FTXphStaPrcDoc'] == 1){
                                    $tClassStaDoc = 'text-success';
                                }else if($aValue['FTXphStaPrcDoc'] == 2){
                                    $tClassStaDoc = 'text-warning';    
                                }else if($aValue['FTXphStaPrcDoc'] == 3){
                                    $tClassStaDoc = 'text-danger';
                                }else{
                                    $tClassStaDoc = 'text-warning';    
                                }
                            }else{
                                $tClassStaDoc = 'text-danger';
                            }
                            

                            //FTXphStaApv
                            if($aValue['FTXphStaApv'] == 1){
                                $tClassStaApv = 'text-success';
                            }else if($aValue['FTXphStaApv'] == 2){
                                $tClassStaApv = 'text-warning';    
                            }else if($aValue['FTXphStaApv'] == ''){
                                $tClassStaApv = 'text-danger';    
                            }

                            //FTXphStaPrcDoc
                            if($aValue['FTXphStaPrcDoc'] == 1){
                                $tClassPrcStk = 'text-success';
                            }else if($aValue['FTXphStaPrcDoc'] == 2){
                                $tClassPrcStk = 'text-warning';
                            }else if($aValue['FTXphStaPrcDoc'] == ''){
                                $tClassPrcStk = 'text-danger';    
                            }
                        ?>
                        <tr class="text-center xCNTextDetail2 otrPurchaseoeder" id="otrPurchaseoeder<?=$key?>" data-code="<?=$aValue['FTXphDocNo']?>" data-name="<?=$aValue['FTXphDocNo']?>">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox ">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?=$CheckboxDisabled?>>
										<span class="<?=$ClassDisabled?>">&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                            <td class="text-left"><?php echo $aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                            <td class="text-left"><?php echo $aValue['FTXphDocNo'] != '' ? $aValue['FTXphDocNo'] : '-' ?></td>
							<td class="text-left"><?php echo $aValue['FDXphDocDate'] != '' ? $aValue['FDXphDocDate'] : '-' ?></td>
                            <td class="text-left"><label class="xCNTDTextStatus <?=$tClassStaDoc?>"><?php 
                                if($aValue['FTXphStaDoc'] != 3){
                                    echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWStaDoc'.$aValue['FTXphStaPrcDoc']); 
                                }else{
                                    echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWStaDoc'.$aValue['FTXphStaDoc']); 
                                
                                }
                            ?></label></td>
							<td class="text-left"><label class="xCNTDTextStatus <?=$tClassStaApv?>"><?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWStaApv'.$aValue['FTXphStaApv'])?></label></td>
							<td class="text-left"><label class="xCNTDTextStatus <?=$tClassPrcStk?>"><?php echo language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWStaPrcStk'.$aValue['FTXphStaPrcDoc']) ?></label></td>
							<td class="text-left"><?php echo $aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : '-' ?></td>
                            <td class="text-left"><?php if($aValue['FTXphUsrApv']!=""){ echo $aValue['FTXthApvName']; }else{ ?> <?= language('document/rentalproductpriceadjustmentlocker/rentalproductpriceadjustmentlocker','tTFWNotFound')?> <?php } ?></td> 
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            	<td>
									<img class="xCNIconTable xCNIconDel <?=$ClassDisabled?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" <?=$Onclick?> title="<?=$Title?>">
								</td>
							<?php endif; ?>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                            	<td>
									<img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageTFWEdit('<?=$aValue['FTXphDocNo']?>')">
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
            <button onclick="JSvTFWClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvTFWClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTFWClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
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
				<button id="osmConfirm" onClick="JSnTFWDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
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

<script type="text/javascript">
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nCode == nCode){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
                JSxTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
</script>