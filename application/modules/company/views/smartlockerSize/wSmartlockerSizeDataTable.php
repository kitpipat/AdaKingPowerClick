<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }

    $nDecimalShow = FCNxHGetOptionDecimalShow();
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <?php if($aAlwEventSMS['tAutStaFull'] == 1 || $aAlwEventSMS['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/shop/shop','tSHPTBChoose')?></th>
						<?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/smartlockerSize/smartlockerSize','tSizeCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:center;"><?php echo language('company/smartlockerSize/smartlockerSize','tSizeName')?></th>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/smartlockerSize/smartlockerSize','tSizeDim')?> <?php echo language('company/smartlockerSize/smartlockerSize','tSizeMm')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/smartlockerSize/smartlockerSize','tSizeWidth')?> <?php echo language('company/smartlockerSize/smartlockerSize','tSizeMm')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/smartlockerSize/smartlockerSize','tSizeHeight')?> <?php echo language('company/smartlockerSize/smartlockerSize','tSizeMm')?></th>
                        <!--BTN Edit-->
                        <?php if($aAlwEventSMS['tAutStaFull'] == 1 || $aAlwEventSMS['tAutStaDelete'] == 1):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBDelete')?></th>
						<?php endif; ?>
                        <!--BTN Delete-->
						<?php if($aAlwEventSMS['tAutStaFull'] == 1 || ($aAlwEventSMS['tAutStaEdit'] == 1 || $aAlwEventShop['tAutStaRead'] == 1)):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2" data-code="<?=$aValue['FTPzeCode']?>" data-name="<?=$aValue['FTSizName']?>"">
                        
                            <?php if($aAlwEventSMS['tAutStaFull'] == 1 || $aAlwEventSMS['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                            <?php endif; ?>  
                            <td nowrap class="text-left xWTdBody"><?=$aValue['FTPzeCode'] ?></td>
                            <td nowrap class="text-left"><?=$aValue['FTSizName'] ?></td>
                            <td nowrap class="text-right"><?=number_format($aValue['FCPzeDim'],$nDecimalShow) ?></td>
                            <td nowrap class="text-right"><?=number_format($aValue['FCPzeHigh'],$nDecimalShow) ?></td>
                            <td nowrap class="text-right"><?=number_format($aValue['FCPzeWide'],$nDecimalShow) ?></td>
                            <?php if($aAlwEventSMS['tAutStaFull'] == 1 || $aAlwEventSMS['tAutStaDelete'] == 1): ?>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxSMSDelete('<?=$aValue['FTPzeCode']?>','<?=$aValue['FTSizName']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                </td>
                            <?php endif; ?>
                            <?php if($aAlwEventSMS['tAutStaFull'] == 1 || ($aAlwEventSMS['tAutStaEdit'] == 1 || $aAlwEventSMS['tAutStaRead'] == 1)) : ?>
                                <td nowrap class="text-center">
                            
                                    <img class="xCNIconTable xWIMGShpShopEdit" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSmartlockerSizeEdit('<?=$aValue['FTPzeCode']?>');">
                                </td>
                            <?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='12'><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWSMLPaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSMLClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
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
                <button onclick="JSvSMLClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSMLClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!--Modal Delete Mutirecord-->
<div class="modal fade" id="odvModalDeleteMutirecord">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxSMSDeleteMutirecord()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Mutirecord-->

<!--Modal Delete Single-->
<div id="odvModalDeleteSingle" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
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
				<button id="osmConfirmDelete" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Single-->


<script>
    // Select List ShopSize Table Item
    $(function() {
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
            JSxSMSPaseCodeDelInModal();

        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxSMSPaseCodeDelInModal();

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
                JSxSMSPaseCodeDelInModal();
                }
            }
            JSxSMSShowButtonChoose();
        });
    });
</script>

