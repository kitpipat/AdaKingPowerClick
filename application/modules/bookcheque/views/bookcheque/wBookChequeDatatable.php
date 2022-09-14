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
					<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaDelete'] == 1) : ?>
                        <th class="xCNTextBold" style="width:5%;"><?= language('ticket/agency/agency','tSelect')?></th>
						<?php endif; ?>
						<th class="xCNTextBold"><?= language('bookcheque/bookcheque/bookcheque','tBcqBch')?></th>
                        <th class="xCNTextBold"><?= language('bookcheque/bookcheque/bookcheque','tBcqCode')?></th>
						<th class="xCNTextBold"><?= language('bookcheque/bookcheque/bookcheque','tBcqName')?></th>
                        <th class="xCNTextBold"><?= language('bookcheque/bookcheque/bookcheque','tBcqBbkName')?></th>
                        <th class="xCNTextBold"><?= language('bookcheque/bookcheque/bookcheque','tBcqDocnumMin')?></th>
                        <th class="xCNTextBold"><?= language('bookcheque/bookcheque/bookcheque','tBcqDocnumMax')?></th>
						<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaDelete'] == 1) : ?>
						<th class="xCNTextBold" style="width:10%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaRead'] == 1) : ?>
						<th class="xCNTextBold" style="width:10%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
				<?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrBank" 
                            id="otrBank<?=$key?>" 
                            data-code="<?=$aValue['FTChqCode']?>" 
                            data-name="<?=$aValue['FTChqName']?>"
                            data-tbchcode="<?=$aValue['FTBchCode']?>">
							<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
										<span>&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                           
                           
                            <td class="text-left"><?=$aValue['FTBchName']?></td>
                            <td class="text-left"><?=$aValue['FTChqCode']?></td>
                            <td class="text-left"><?=$aValue['FTChqName']?></td>
                            <td class="text-left"><?=$aValue['FTBbkName']?></td>
                            <td class="text-right"><?=$aValue['FNChqMin']?></td>
                            <td class="text-right"><?=$aValue['FNChqMax']?></td>
                        
							<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaDelete'] == 1) : ?>
								<td><img    class="xCNIconTable xCNIconDel" 
                                            src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>"    
                                            onclick="JSnBCqdelete('<?php echo $nCurrentPage?>','<?=$aValue['FTChqName']?>','<?php echo $aValue['FTChqCode']?>', '<?= $aValue['FTBchName']; ?>', '<?= $aValue['FTBchCode']; ?>')"></td>
							<?php endif; ?>
							<?php if($aAlwEventBookCheque['tAutStaFull'] == 1 || $aAlwEventBookCheque['tAutStaRead'] == 1) : ?>
								<td><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onclick="JSvBCQCallEdit('<?php echo $aValue['FTChqCode']?>', '<?= $aValue['FTBchCode']; ?>')"></td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='9'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
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
            <button onclick="JSvCPNClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

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
            		<button onclick="JSvCPNClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvCPNClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelChq">
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
                <?php //ปุ่มosmConfirmDelete1 _จะแสดงเมื่อกดปุ่มถังขยะที่อยู่ท้ายรายการเชคเท่านั้น ที่เหลือจะแสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น?>
                <button id="osmConfirmDelete1" type="button" class="btn xCNBTNPrimery" style="display:none"><?=language('common/main/main', 'tModalConfirm')?></button>
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onclick="JSnBCQDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
                <?php //end ปุ่มosmConfirmDelete1 _จะแสดงเมื่อกดปุ่มถังขยะที่อยู่ท้ายรายการเชคเท่านั้น ที่เหลือจะแสดงปุ่ม osmConfirm _เป็นค่าเริ่มต้น?>
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
		var tDataCode = $('#otrBank'+$i).data('code')
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
        //เวลาจะอ้างถึง cheque ต้องเอา branch code ไปใช้คู่กับเลขเชคด้วย 09/04/2020 surawat
        var tBchCode = $(this).parent().parent().parent().data('tbchcode'); //branch code
        //end เวลาจะอ้างถึง cheque ต้องเอา branch code ไปใช้คู่กับเลขเชคด้วย 09/04/2020 surawat
        
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }

        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            //เวลาจะอ้างถึง cheque ต้องเอา branch code ไปใช้คู่กับเลขเชคด้วย 09/04/2020 surawat
            obj.push({"nCode": nCode, "tName": tName , "tBchCode": tBchCode});
            //end เวลาจะอ้างถึง cheque ต้องเอา branch code ไปใช้คู่กับเลขเชคด้วย 09/04/2020 surawat
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            //หากเคยมีการเลือก Cheque นี้มาก่อน จะหมายถึงการเอาออกจากรายการเคยเลือกไว้ 09/04/2020 surawat
            var nIndexToRemove = -1;
            for(var nIndex = 0; nIndex < aArrayConvert[0].length; nIndex++){
                var oChqDataRow = aArrayConvert[0][nIndex];
                if(oChqDataRow['nCode'] == nCode && oChqDataRow['tBchCode'] == tBchCode ){
                    nIndexToRemove = nIndex;
                    break;
                }
            }
            //end หากเคยมีการเลือก Cheque นี้มาก่อน จะหมายถึงการเอาออกจากรายการเคยเลือกไว้ 09/04/2020 surawat
            
            if( nIndexToRemove == -1 ){//ยังไม่เคยถูกเลือก จะเพิ่มรายการใหม่เข้าไป 09/04/2020 surawat
                obj.push({"nCode": nCode, "tName": tName, "tBchCode": tBchCode});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModal();
            }else if( nIndexToRemove > -1){	//เคยเลือกไว้แล้ว จะลบรายการนั้นออก 09/04/2020 surawat
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                aArrayConvert[0].splice(nIndexToRemove, 1);
                localStorage.setItem("LocalItemData",JSON.stringify(aArrayConvert[0]));
                JSxPaseCodeDelInModal();
            }
        }
        JSxShowButtonChoose();
    })
});
</script>