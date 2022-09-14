<?php 
    if($aPmgDataList['rtCode'] == '1'){
        $nCurrentPage = $aPmgDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbPmgDataList" class="table table-striped"> <!-- เปลี่ยน -->
                <thead>
                    <tr>
                        <?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || $aAlwEventPdtPromotion['tAutStaDelete'] == 1) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtpromotion/pdtpromotion','tPMGTBChoose')?></th>
                        <?php endif; ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtpromotion/pdtpromotion','tPMGTBCode')?></th>
                        <th class="text-center xCNTextBold" style="width:60%;"><?= language('product/pdtpromotion/pdtpromotion','tPMGTBName')?></th>
                        <?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || $aAlwEventPdtPromotion['tAutStaDelete'] == 1) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtpromotion/pdtpromotion','tPMGTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || ($aAlwEventPdtPromotion['tAutStaEdit'] == 1 || $aAlwEventPdtPromotion['tAutStaRead'] == 1))  : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtpromotion/pdtpromotion','tPMGTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPmgDataList['rtCode'] == 1 ):?>
                        <?php foreach($aPmgDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center xCNTextDetail2 otrPdtPmgGrp" id="otrPdtPmgGrp<?=$nKey?>" data-code="<?=$aValue['rtPmgCode']?>" data-name="<?=$aValue['rtPmgName']?>">
                                <?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || $aAlwEventPdtPromotion['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td><?=$aValue['rtPmgCode']?></td>
                                <td class="text-left"><?=$aValue['rtPmgName']?></td>
                                <?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || $aAlwEventPdtPromotion['tAutStaDelete'] == 1) : ?>
                                <td>
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtPmgGrpDel('<?=$nCurrentPage?>','<?=$aValue['rtPmgName']?>','<?=$aValue['rtPmgCode']?>')">
                                </td>
                                <?php endif; ?>
                                <?php if($aAlwEventPdtPromotion['tAutStaFull'] == 1 || ($aAlwEventPdtPromotion['tAutStaEdit'] == 1 || $aAlwEventPdtPromotion['tAutStaRead'] == 1)) : ?>
                                <td>
                                    <!-- เปลี่ยน -->
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtPmgGrpEdit('<?php echo $aValue['rtPmgCode']?>')">
                                </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('product/pdtpromotion/pdtpromotion','tPMGTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPmgDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPmgDataList['rnCurrentPage']?> / <?=$aPmgDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtPmgGrp btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtPmgGrpClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPmgDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvPdtPmgGrpClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPmgDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtPmgGrpClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelPdtPmgGrp">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtPmgGrpDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
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
		var tDataCode = $('#otrPdtPmgGrp'+$i).data('code')
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
});


    // $('.ocbListItem').click(function(){
    //     var nCode = $(this).parent().parent().parent().data('code');  //code
    //     var tName = $(this).parent().parent().parent().data('name');  //code
    //     $(this).prop('checked', true);
    //     var LocalItemData = localStorage.getItem("LocalItemData");
    //     var obj = [];
    //     if(LocalItemData){
    //         obj = JSON.parse(LocalItemData);
    //     }else{ }
    //     var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
    //     if(aArrayConvert == '' || aArrayConvert == null){
    //         obj.push({"nCode": nCode, "tName": tName });
    //         localStorage.setItem("LocalItemData",JSON.stringify(obj));
    //         JSxTextinModal();
    //     }else{
    //         var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
    //         if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
    //             obj.push({"nCode": nCode, "tName": tName });
    //             localStorage.setItem("LocalItemData",JSON.stringify(obj));
    //             JSxTextinModal();
    //         }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
    //             localStorage.removeItem("LocalItemData");
    //             $(this).prop('checked', false);
    //             var nLength = aArrayConvert[0].length;
    //             for($i=0; $i<nLength; $i++){
    //                 if(aArrayConvert[0][$i].nCode == nCode){
    //                     delete aArrayConvert[0][$i];
    //                 }
    //             }
    //             var aNewarraydata = [];
    //             for($i=0; $i<nLength; $i++){
    //                 if(aArrayConvert[0][$i] != undefined){
    //                     aNewarraydata.push(aArrayConvert[0][$i]);
    //                 }
    //             }
    //             localStorage.setItem("LocalItemData",JSON.stringify(aNewarraydata));
    //             JSxTextinModal();
    //         }
    //     }
    //     JSxShowButtonChoose();
    // })
</script>