<?php
    if($aPhwDataList['rtCode'] == '1'){
        $nCurrentPage = $aPhwDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>


<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbPhwDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSChooseDevice')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSCodeDevice')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSTypeDevice')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSNameDevice')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSConTypeDevice')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSDelete')?></th>
                        <th nowarp class="text-center xCNTextBold" style="width:10%;"><?= language('pos/salemachine/salemachine','tPOSEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPhwDataList['rtCode'] == 1 ):?>
                        <?php foreach($aPhwDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center xCNTextDetail2 otrSaleMachineDevice" id="otrSaleMachineDevice<?=$nKey?>" data-code="<?=$aValue['rtPhwCode']?>" data-bch="<?=$aValue['rtBchCode']?>" data-name="<?=$aValue['rtPhwName']?>">
                                <td nowarp class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td nowarp class="text-center"><?=$aValue['rtPhwCode']?></td>
                                <td nowarp class="text-left"><?=$aValue['rtShwName']?></td>
                                <td nowarp class="text-left"><?=$aValue['rtPhwName']?></td>
                              <?php
                                    if($aValue['rtConnType'] == "1"){
                                       $tConnType = "Printer";
                                    }else if($aValue['rtConnType'] == "2"){
                                       $tConnType = "Comport";
                                    }else if($aValue['rtConnType'] == "3"){
                                       $tConnType = "TCP";
                                    }else if($aValue['rtConnType'] == "4"){
                                        $tConnType = "BT";
                                    }else if($aValue['rtConnType'] == "5"){
                                        $tConnType = "USB";
                                    }else if($aValue['rtConnType'] == "6"){
                                        $tConnType = "Offline";
                                    }else if($aValue['rtConnType'] == "9"){
                                        $tConnType = "VD";
                                    }else{
                                        $tConnType = "N/A";
                                    }
                               ?>
                                <td nowrap class="text-left"><?php echo $tConnType; ?></td>

                                <td nowarp>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoSaleMachineDeviceDel('<?= $nCurrentPage?>','<?= $aValue['rtPhwName']?>','<?= $aValue['rtPhwCode']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>','<?= $aValue['rtBchCode']?>')">
                                </td>
                                <td nowarp>
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageSaleMachineDeviceEdit('<?php echo $aValue['rtPhwCode']?>','<?= $aValue['rtBchCode']?>')">
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='7'><?= language('pos/salemachine/salemachine','tPOSNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>


<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPhwDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPhwDataList['rnCurrentPage']?> / <?=$aPhwDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageSaleMachineDevice btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvSaleMachineDeviceClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aPhwDataList['rnAllPage'],$nPage+2)); $i++){?>
				<?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvSaleMachineDeviceClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aPhwDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvSaleMachineDeviceClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelSaleMachineDevice">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<input type='hidden' id="ohdConfirmIDDelete">
                <input type='hidden' id="ohdConfirmBchDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoSaleMachineDeviceDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
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
		var tDataCode = $('#otrSaleMachineDevice'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
	}

	$('.ocbListItem').click(function(){
        var tBch  = $(this).parent().parent().parent().data('bch');  //Bch
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
            obj.push({"nCode": nCode, "tName": tName, "tBch": tBch });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxPaseCodeDelInModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName, "tBch": tBch });
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
