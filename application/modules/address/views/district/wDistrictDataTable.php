<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
	<input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage;?>">
        <div class="table-responsive">
            <table class="table table-striped" >
                <thead>
                    <tr>
						<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || $aAlwEventDistrict['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('address/district/district','tDSTTBChoose')?></th>
                        <?php endif; ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('address/district/district','tDSTTBCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:30%;text-align:center;"><?php echo language('address/district/district','tDSTTBName')?></th>
                        <th nowrap class="xCNTextBold" style="width:30%;text-align:center;"><?php echo language('address/district/district','tDSTTBProvince')?></th>
						<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || $aAlwEventDistrict['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('address/district/district','tDSTTBDelete')?></th>
                        <?php endif; ?>
						<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || ($aAlwEventDistrict['tAutStaEdit'] == 1 || $aAlwEventDistrict['tAutStaRead'] == 1))  : ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('address/district/district','tDSTTBEdit')?></th>
						<?php endif; ?>
					</tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrDistrict" id="otrDistrict<?php echo $key?>" data-code="<?php echo $aValue['rtDstCode']?>" data-name="<?php echo $aValue['rtDstName']?>">
							<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || $aAlwEventDistrict['tAutStaDelete'] == 1) : ?>
							<td nowrap class="text-center">
								<label class="fancy-checkbox">
									<input id="ocbListItem<?php echo $key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
									<span>&nbsp;</span>
								</label>
							</td>
							<?php endif; ?>
                            <td nowrap><?php echo $aValue['rtDstCode']?></td>
                            <td nowrap class="text-left"><?php echo $aValue['rtDstName']?></td>
                            <td nowrap class="text-left"><?php echo $aValue['rtPvnName']?></td>
							<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || $aAlwEventDistrict['tAutStaDelete'] == 1) : ?>
							<td nowrap>
								<img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnDistrictDel('<?php echo $nCurrentPage?>','<?php echo $aValue['rtDstName']?>','<?php echo $aValue['rtDstCode']?>')">
							</td>
							<?php endif; ?>
							<?php if($aAlwEventDistrict['tAutStaFull'] == 1 || ($aAlwEventDistrict['tAutStaEdit'] == 1 || $aAlwEventDistrict['tAutStaRead'] == 1)) : ?>
							<td nowrap>
								<img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageDistrictEdit('<?php echo $aValue['rtDstCode']?>')">
							</td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='6'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
		<p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageDistrict btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
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
                <button onclick="JSvClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelDistrict">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
				<input type='hidden' id="ohdConfirmIDDelete">

				<!-- <span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ospConfirmIDDelete"> -->
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" onClick="JSnDistrictDelChoose()"  class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?php echo language('common/main/main', 'tModalConfirm')?>
				</button>
				<button type="button" class="btn xCNBTNDefult xCNBTNDefult2Btn" data-dismiss="modal">
					<?php echo language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
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
				JSxPaseCodeDelInModal();
			}else{
				var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
				if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
					obj.push({"nCode": nCode, "tName": tName });
					localStorage.setItem("LocalItemData",JSON.stringify(obj));
					JSxPaseCodeDelInModal();
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
					JSxPaseCodeDelInModal();
				}
			}
			JSxShowButtonChoose();
		})
	});
</script>