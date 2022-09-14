<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-hover" style="width:100%">
                <thead>
                    <tr>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('common/main/main','tCMNChoose')?></th>
						<?php endif; ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('company/branch/branch','tBCHLogo')?></th>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('company/shop/shop','tShopCode')?></th>
						<th nowrap class="xCNTextBold" style="width:30%;text-align:center;"><?= language('company/shop/shop','tShopName')?></th>
						<th nowrap class="xCNTextBold" style="width:30%;text-align:center;"><?= language('company/shop/shop','tShopPdt')?></th>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('company/shop/shop','tShopActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?= language('company/shop/shop','tShopActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 && @$aDataList['raItems'] ):?>
				
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
					<?php 	
						if($aValue['rtImgObj'] != ''){ 
							$tImgObj = base_url()."/application/modules/common/assets/system/systemimage/".$aValue['rtImgObj']; 
					   	}else{ 
							$tImgObj = "http://www.bagglove.com/images/400X200.gif"; 
						}
					?>
                        <tr class="text-center xCNTextDetail2 otrDistrict" id="otrShop<?=$key?>" data-code="<?=$aValue['rtShpCode']?>" data-name="<?=$aValue['rtShpCode']?>">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<td class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
									<span>&nbsp;</span>
								</label>
							</td>
							<?php endif; ?>
                            <td><img src="<?=$tImgObj?>" class="xWLogoInRow" ></td>
                            <td class="text-left"><?=$aValue['rtShpCode']?></td>
                            <td class="text-left"><?=$aValue['rtShpName']?></td>
							<td class="text-left">สินค้า</td>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<td><i style="display:block;text-align:center;" class="fa fa-trash-o fa-lg" onClick="JSnShopDelFromBch('<?=$aValue['rtShpCode']?>')"></i></td>
							<?php endif; ?>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
							<td><i style="display:block;text-align:center;" class="fa fa-pencil-square-o fa-lg" onClick="JSvSHPEditPageFromBch('<?=$aValue['rtBchCode']?>','<?=$aValue['rtShpCode']?>')"></i></td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='6'><?=language('common/main/main', 'tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6 xCNPadT30">
        <p>พบข้อมูลทั้งหมด <?=$aDataList['rnAllRow']?> รายการ แสดงหน้า <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <nav class="pull-right" aria-label="Page navigation">
            <ul class="xWSHPPaging pagination justify-content-center">
                <?php if($nPage == 1){ $tDisabled = 'xCNDisable'; }else{ $tDisabled = '-';} ?>
                <li class="page-item previous <?=$tDisabled?>">
                    <a class="page-link xWBtnPrevious <?=$tDisabled?>" data-npage="previous" tabindex="0" onclick="JSvSHPClickPageFromBch('previous')"><?=language('common/main/main','tPrevious')?></a>
                </li>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
                    <?php if($nPage == $i){ $tActive = 'active'; }else{ $tActive = '-'; }?>
                    <li class="page-item <?=$tActive?>">
                        <a class="page-link" onclick="JSvSHPClickPageFromBch('<?=$i?>')"><?=$i?></a>
                    </li>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'xCNDisable'; }else{ $tDisabled = '-'; } ?>
                <li class="page-item next <?=$tDisabled?>">
		            <a class="page-link xWBtnNext <?=$tDisabled?>" data-npage="next" tabindex="0" onclick="JSvSHPClickPageFromBch('next')"><?=language('common/main/main','tNext')?></a>
                </li>
            </ul>
        </nav>
    </div>
</div>
<script type="text/javascript">
$('ducument').ready(function(){
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrDistrict'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
	}
	$('#odvRGPList tr td').click(function(){
		if($(this).is(":last-child")){
			//alert('into Function delete');
		}else if( $(this).is(":nth-last-child(2)")){
			//alert('into Function delete');
		}else{
			$('#odvRGPList > tr').css('background-color','#FFFFFF');
			$(this).parent('tr').css('background-color','#4fbcf31a');
			var nCode = $(this).parent('tr').data('code');  //code
			var tName = $(this).parent('tr').data('name');  //name
			$(this).parent('tr').find('.ocbListItem').prop('checked', true);
			
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
					$('#odvRGPList > tr').css('background-color','');
					$(this).parent('tr').css('background-color','');
					localStorage.removeItem("LocalItemData");
					$(this).parent('tr').find('.ocbListItem').prop('checked', false);
					
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
		}
	});
});
</script>