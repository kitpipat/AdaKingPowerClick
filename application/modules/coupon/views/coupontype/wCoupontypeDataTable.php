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
					<tr>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center xCNTextBold" style="width:5%;"><?= language('coupon/coupontype/coupontype','tCPTTBChoose')?></th>
						<?php endif; ?>
                        <th nowrap class="text-center xCNTextBold" style="width:10%;"><?php echo language('coupon/coupontype/coupontype','tCPTTBCode')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:30%;"><?php echo language('coupon/coupontype/coupontype','tCPTTBName')?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:10%"><?php echo language('coupon/coupontype/coupontype','tCPTCouponType');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:10%"><?php echo language('coupon/coupontype/coupontype','tCPTStaChkCopon');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:10%"><?php echo language('coupon/coupontype/coupontype','tCPTStaChkHQ');?></th>
                        <th nowrap class="text-center xCNTextBold" style="width:10%"><?php echo language('coupon/coupontype/coupontype','tCptStaUse');?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th nowrap class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						    <th nowrap class="text-center xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
            <tbody id="odvRGPList">
				<?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrVoucher" id="otrVoucher<?=$key?>" data-code="<?=$aValue['FTCptCode']?>" data-name="<?=$aValue['FTCptName']?>">
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
								<td class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
										<span>&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
							<td nowrap class="text-left"><?=$aValue['FTCptCode']?></td>
                            <td nowrap class="text-left"><?=$aValue['FTCptName']?></td>

                            <!-- ประเภทคูปอง  1: คูปองเงินสด 2: คูปองส่วนลด -->
                            <?php 
                                switch ($aValue['FTCptType']){
                                    case 1:
                                        $tCouponType   = language('coupon/coupontype/coupontype','tCPTCouponType1');
                                    break;
                                    case 2:
                                        $tCouponType   = language('coupon/coupontype/coupontype','tCPTCouponType2');
                                    break;
                                    default:
                                        $tCouponType   = language('coupon/coupontype/coupontype','tCPTCouponType1');
                                }
                            ?>

                            <td nowrap class="text-left"><?php echo $tCouponType;?></td>

                            <!-- สถานะตรวจสอบคูปอง  1 : ไม่ตรวจสอบ 2: ตรวจสอบ -->
                            <?php 
                                switch ($aValue['FTCptStaChk']){
                                    case 1:
                                        $tCouponChk   = language('coupon/coupontype/coupontype','tCPTCouponChk1');
                                    break;
                                    case 2:
                                        $tCouponChk   = language('coupon/coupontype/coupontype','tCPTCouponChk2');
                                    break;
                                    default:
                                        $tCouponChk   = language('coupon/coupontype/coupontype','tCPTCouponChk1');
                                }
                            ?>
                            <td nowrap class="text-left"><?php echo $tCouponChk;?></td>

                            <!-- ใช้ตรวจสอบคูปอง ของสาขา 1: HQ 2: Branch Defualt:Branch -->
                            <?php 
                                    switch ($aValue['FTCptStaChkHQ']){
                                        case 1:
                                            $tStaChkCoupon  = language('coupon/coupontype/coupontype','tCPTStaChkHQ1');
                                        break;
                                        case 2: 
                                            $tStaChkCoupon  = language('coupon/coupontype/coupontype','tCPTStBranch');
                                        break;
                                        default:
                                            $tStaChkCoupon  = language('coupon/coupontype/coupontype','tCPTStaChkHQ1');
                                    }
                            
                            ?>
                            <td nowrap class="text-left"><?php echo $tStaChkCoupon;?></td>

                            <!-- สถานะการใช้งาน  1:ใช้งาน 2:ไม่ใช้งาน -->
                            <?php
                                switch ($aValue['FTCptStaUse']) {
                                    case 1:
                                        $tStaCptUse    =  language('promotion/voucher/vouchertype','tVOTTBUsing');
                                        $tClassStaAtv  = 'xWCptActive';
                                    break;
                                    case 2 :
                                      $tStaCptUse   = language('promotion/voucher/vouchertype','tVOTTBNoUsing');
                                      $tClassStaAtv  = 'xWCptInActive';
                                    break;
                                    default:
                                        $tStaCptUse    =  language('promotion/voucher/vouchertype','tVOTTBUsing');
                                        $tClassStaAtv  = 'xWCptActive';
                                }
                            ?>
                    
                            <td nowrap class="text-left"><a class="<?php echo $tClassStaAtv?>"><?php echo $tStaCptUse;?></a></td>

							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                <td>
                                    <?php if(!FCNbIsHaveCoupInCouponHD($aValue['FTCptCode'])) : // No have user in role ?>
                                        <img class="xCNIconTable xCNIconDel" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnCoupontypeDel('<?=$nCurrentPage?>','<?=$aValue['FTCptName']?>','<?=$aValue['FTCptCode']?>')">
                                    <?php else : // have user in role?>
                                        <img class="xCNIconTable" src="<?php echo base_url().'/application/modules/common/assets/images/icons/delete.png'?>" style="opacity: 0.2;">
                                    <?php endif; ?>
                                </td>
							<?php endif; ?>
							<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
								<td><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCoupontypeTypeEdit('<?=$aValue['FTCptCode']?>')"></td>
							<?php endif; ?>
                            </tr>
                            <?php } ?>
                            <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWCDCPaging btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvVOCClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

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
            		<button onclick="JSvVOCClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvVOCClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>




<div class="modal fade" id="odvModalDelVoucher">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnCoupontypeDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
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
		var tDataCode = $('#otrVoucher'+$i).data('code')
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