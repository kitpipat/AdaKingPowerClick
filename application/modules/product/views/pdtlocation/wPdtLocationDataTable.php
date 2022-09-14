<?php 
    if($aLocDataList['rtCode'] == '1'){
        $nCurrentPage = $aLocDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbLocDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || $aAlwEventPdtLocation['tAutStaDelete'] == 1) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtlocation/pdtlocation','tLOCChoose')?></th>
                        <?php endif; ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtlocation/pdtlocation','tLOCCode')?></th>
                        <th class="text-center xCNTextBold" style="width:50%;"><?= language('product/pdtlocation/pdtlocation','tLOCName')?></th>
                        <!-- <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtlocation/pdtlocation','tLOCPdtLoc')?></th> -->
                        <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || $aAlwEventPdtLocation['tAutStaDelete'] == 1) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtlocation/pdtlocation','tLOCDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || ($aAlwEventPdtLocation['tAutStaEdit'] == 1 || $aAlwEventPdtLocation['tAutStaRead'] == 1))  : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtlocation/pdtlocation','tLOCEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aLocDataList['rtCode'] == 1 ):?>
                        <?php foreach($aLocDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center xCNTextDetail2 otrPdtLoc" id="otrPdtLoc<?=$nKey?>" data-code="<?=$aValue['rtLocCode']?>" data-name="<?=$aValue['rtLocName']?>">
                                <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || $aAlwEventPdtLocation['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td><?=$aValue['rtLocCode']?></td>
                                <td class="text-left"><?=$aValue['rtLocName']?></td>
                                <!-- <td class="text-center"><button class="btn xCNBTNDefult xCNBTNDefult1Btn xWBtnSetVDLayOut" onClick="JSvCallPagePdtLocManage('<?=$aValue['rtLocCode']?>');"><?= language('product/pdtlocation/pdtlocation','tLOCManage')?></button></td> -->
                                <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || $aAlwEventPdtLocation['tAutStaDelete'] == 1) : ?>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtLocDel('<?=$nCurrentPage?>','<?=$aValue['rtLocName']?>','<?=$aValue['rtLocCode']?>')"></td>
                                <?php endif; ?>
                                <?php if($aAlwEventPdtLocation['tAutStaFull'] == 1 || ($aAlwEventPdtLocation['tAutStaEdit'] == 1 || $aAlwEventPdtLocation['tAutStaRead'] == 1)) : ?>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePdtLocEdit('<?=$aValue['rtLocCode']?>')"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='7'><?= language('product/pdtlocation/pdtlocation','tLOCNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aLocDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aLocDataList['rnCurrentPage']?> / <?=$aLocDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtLoc btn-toolbar pull-right"> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtLocClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aLocDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                
                <button onclick="JSvPdtLocClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aLocDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtLocClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal fade" id="odvModalDelPdtLoc">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtLocDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
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
		var tDataCode = $('#otrPdtLoc'+$i).data('code')
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
</script>