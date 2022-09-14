<style>
    .xWCptActive {
        color: #007b00 !important;
        font-weight: bold;
        font-size: 10px;
        cursor: default;
    }
    .xWCptInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }
</style>

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
            <table class="table table-striped" style="width:100%">
                <thead>
					<tr class="xCNCenter">
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        	<th class="xCNTextBold" style="width:5%;"><?php echo language('bookbank/bookbank/bookbank','tBBKTableSelect')?></th>
						<?php endif; ?>
                        <th style="width:10%;"><?php echo language('bookbank/bookbank/bookbank','tBBKTableCode')?></th>
                        <th style="width:10%;"><?php echo language('bookbank/bookbank/bookbank','tBBKTableBbkName')?></th>
                        <th><?php echo language('bookbank/bookbank/bookbank','tBBKTableIDCode')?></th>
                        <th><?php echo language('bookbank/bookbank/bookbank','tBBKTableType')?></th>
                        <th><?php echo language('bookbank/bookbank/bookbank','tBBKTableBank')?></th>
                        <th><?php echo language('bookbank/bookbank/bookbank','tBBKTablebanch')?></th>
                        <th><?php echo language('bookbank/bookbank/bookbank','tBBKTableStatus')?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:6%;"><?php echo  language('bookbank/bookbank/bookbank','tBBKTableDelete')?></th>
						<?php endif; ?>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						<th class="xCNTextBold" style="width:6%;"><?php echo language('bookbank/bookbank/bookbank','tBBKTableEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ 
                            // print_r("<pre>");
                            // print_r($aValue);
                            // print_r("</pre>");
                        ?>
                        <tr class="text-center xCNTextDetail2 otrBookbank" 
                            id="otrBookbank<?=$key?>" 
                            data-code="<?=$aValue['rtBbkCode']?>" 
                            data-name="<?=$aValue['rtBbkName']?>"
                            data-tbchcode="<?=$aValue['rtBchCode']?>">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
										<span>&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                            <td class="text-left"><?=$aValue['rtBbkCode']?></td>
                            <td class="text-left"><?=$aValue['rtBbkName']?></td>
                            <td class="text-center"><?=$aValue['rtBbkAccNo']?></td>
                            <td class="text-left"><?php echo language('bookbank/bookbank/bookbank','tBBKTableType'.$aValue['rtBbkType']);?></td>
							<td class="text-left"><?=$aValue['rtBnkName']?></td>
							<td class="text-left"><?=$aValue['rtBchName']?></td>

                             <!-- สถานะการใช้งาน  1:ใช้งาน 2:ไม่ใช้งาน -->
                             <?php
                                switch ($aValue['rtBbkStaActive']) {
                                    case 1:
                                        $tStaCptUse     =  language('bookbank/bookbank/bookbank','tBBKTableActivate'.$aValue['rtBbkStaActive']);
                                        $tClassStaAtv   = 'xWCptActive';
                                    break;
                                    case 2 :
                                      $tStaCptUse       = language('bookbank/bookbank/bookbank','tBBKTableActivate'.$aValue['rtBbkStaActive']);
                                      $tClassStaAtv     = 'xWCptInActive';
                                    break;
                                    default:
                                        $tStaCptUse     =  language('bookbank/bookbank/bookbank','tBBKTableActivate'.$aValue['rtBbkStaActive']);
                                        $tClassStaAtv   = 'xWCptActive';
                                }
                            ?>
                            <td nowrap class="text-left"><a class="<?php echo $tClassStaAtv?>"><?php echo $tStaCptUse;?></a></td>
                            <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
								<td><img class="xCNIconTable xCNIconDel" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnBookBankDel(<?php echo $nCurrentPage; ?>,'<?=$aValue['rtBbkName']?>','<?php echo $aValue['rtBbkCode']?>','<?php echo $aValue['rtBchName']?>','<?php echo $aValue['rtBchCode']?>')"></td>
							<?php endif; ?>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
								<td><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageBookBankEdit('<?php echo $aValue['rtBbkCode']?>','<?php echo $aValue['rtBbkType'] ?>','<?php echo $aValue['rtBbkStaActive']?>','<?php echo $aValue['rtBchCode']?>')"></td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='10'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
               
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWCDCPaging btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvBBKClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
				<?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvBBKClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvBBKClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelBookBank">
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
                <button id="osmConfirmDelete1" type="button" class="btn xCNBTNPrimery" style="display:none;"><?=language('common/main/main', 'tModalConfirm')?></button>
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnCreditcardDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('ducument').ready(function(){
    localStorage.removeItem("LocalItemData");
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrCreditcard'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
    }
    JSxPaseCodeDelInModal();// เอารายการที่เลือกไว้มาเก็บไว้ในmodal ให้เรียบร้อยเผื่อ user สั่งลบรายการ

	$('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        var tBchCode = $(this).parent().parent().parent().data('tbchcode'); //branch code

        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName , "tBchCode": tBchCode});
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            // var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            var nIndexToRemove = -1;
            for(var nIndex = 0; nIndex < aArrayConvert[0].length; nIndex++){
                var oBbkDataRow = aArrayConvert[0][nIndex];
                if(oBbkDataRow['nCode'] == nCode && oBbkDataRow['tBchCode'] == tBchCode ){
                    nIndexToRemove = nIndex;
                    break;
                }
            }

            if( nIndexToRemove == -1 ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName , "tBchCode": tBchCode});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if( nIndexToRemove > -1){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                // var nLength = aArrayConvert[0].length;
                // for($i=0; $i<nLength; $i++){
                //     if(aArrayConvert[0][$i].nCode == nCode){
                //         delete aArrayConvert[0][$i];
                //     }
                // }
                // var aNewarraydata = [];
                // for($i=0; $i<nLength; $i++){
                //     if(aArrayConvert[0][$i] != undefined){
                //         aNewarraydata.push(aArrayConvert[0][$i]);
                //     }
                // }
                aArrayConvert[0].splice(nIndexToRemove, 1);
                localStorage.setItem("LocalItemData",JSON.stringify(aArrayConvert[0]));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
});
</script>