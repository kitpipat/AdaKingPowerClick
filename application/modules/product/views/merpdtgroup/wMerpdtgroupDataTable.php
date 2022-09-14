<?php 
    if($aMgpDataList['rtCode'] == '1'){
        $nCurrentPage = $aMgpDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value="<?=$nCurrentPage?>">
        <div class="table-responsive">
            <table id="otbPgpDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventProductGroup['tAutStaFull'] == 1 || $aAlwEventProductGroup['tAutStaDelete'] == 1 ) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/pdtgroup/pdtgroup','tPGPTBChoose')?></th>
                        <?php endif; ?>
                        <th class="text-center xCNTextBold"><?= language('product/pdtgroup/pdtgroup','tPGPTBCode')?></th>
                        <th class="text-center xCNTextBold"><?= language('product/merpdtgroup/merpdtgroup','tMgpProductGroup')?></th>

                        <?php if($aAlwEventProductGroup['tAutStaFull'] == 1 || $aAlwEventProductGroup['tAutStaDelete'] == 1 ) : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/merpdtgroup/merpdtgroup','tMGPTBDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEventProductGroup['tAutStaFull'] == 1 || ($aAlwEventProductGroup['tAutStaEdit'] == 1 || $aAlwEventProductGroup['tAutStaRead'] == 1))  : ?>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('product/merpdtgroup/merpdtgroup','tMGPTBEdit')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aMgpDataList['rtCode'] == 1 ):?>
                        <?php foreach($aMgpDataList['raItems'] AS $nKey => $aValue):?>
                            <tr class="text-center otrPdtGroup" id="otrPdtGroup<?php echo $nKey?>" data-code="<?php echo $aValue['rtMgpCode']?>" data-name="<?php echo $aValue['rtMgpName']?>">
                                <?php if($aAlwEventProductGroup['tAutStaFull'] == 1 || $aAlwEventProductGroup['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td><?php echo $aValue['rtMgpCode']?></td>
                                <td class="text-left"><?=$aValue['rtMgpName']?></td>

                                <?php if($aAlwEventProductGroup['tAutStaFull'] == 1 || $aAlwEventProductGroup['tAutStaDelete'] == 1 ) : ?>
                                <td><img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSnMerchantGroupDel('<?=$nCurrentPage?>','<?php echo $aValue['rtMgpCode']?>','<?=$aValue['rtMgpName']?>')"></td>
                                <?php endif; ?>
                                <?php if($aAlwEventProductGroup['tAutStaFull'] == 1 || ($aAlwEventProductGroup['tAutStaEdit'] == 1 || $aAlwEventProductGroup['tAutStaRead'] == 1))  : ?>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageMerProductGroupEdit('<?php echo $aValue['rtMgpCode']?>')"></td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='7'><?php echo  language('product/pdtgroup/pdtgroup','tPGPTBNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aMgpDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aMgpDataList['rnCurrentPage']?> / <?=$aMgpDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtGroup btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtGroupClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aMgpDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvPdtGroupClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aMgpDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtGroupClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal fade" id="odvModalDelMerPdt">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
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
                <input type='hidden' id="ohdBchCode">
                <input type='hidden' id="ohdShpCode">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxMGPDeleteMutirecord()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Mutirecord-->

<?php include "script/jMerpdtgroupAdd.php"; ?>
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
    });
</script>