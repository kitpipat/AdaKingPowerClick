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
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                        	<th class="xCNTextBold" style="width:5%;"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBChoose')?></th>
						<?php endif; ?>
                        <th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBBchCreate')?></th>
						<th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBDocNo')?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBDocDate')?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBStaDoc')?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBStaPrc')?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBCreateBy')?></th>
                        <th class="xCNTextBold"><?= language('document/adjuststockvd/adjuststockvd','tADJVDTBApvBy')?></th>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						<th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php 
                        if(FCNnHSizeOf($aDataList['raItems'])!=0){

                        
                            foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                            <?php 
                                $tXthDocNo = $aValue['FTXthDocNo'];
                                if($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaApv'] == 2 || $aValue['FTXthStaDoc'] == 3){
                                    $CheckboxDisabled = "disabled";
                                    $ClassDisabled = 'xCNDocDisabled';
                                    $Title = language('document/document/document','tDOCMsgCanNotDel');
                                    $Onclick = '';
                                }else{
                                    $CheckboxDisabled = "";
                                    $ClassDisabled = '';
                                    $Title = '';
                                    $Onclick = "onclick=JSnADJVDDel('".$nCurrentPage."','".$tXthDocNo."')";
                                }

                                //StaDoc
                                if($aValue['FTXthStaDoc'] == 3){
                                    $tClassStaDoc = 'text-danger';
                                    $tStaDoc = language('common/main/main', 'tStaDoc3');
                                }else if(!empty($aValue['FTXthStaApv'])){
                                    $tClassStaDoc = 'text-success';
                                    $tStaDoc = language('common/main/main', 'tStaDoc1'); 
                                }else{
                                    $tClassStaDoc = 'text-warning';
                                    $tStaDoc = language('common/main/main', 'tStaDoc');
                                }

                                //StaPrcDoc
                                if ($aValue['FTXthStaPrcStk'] == 1) {
                                    $tClassPrcStk = 'text-success';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                                } else if ($aValue['FTXthStaPrcStk'] == 2) {
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc2');
                                } else if ($aValue['FTXthStaPrcStk'] == 0 || $aValue['FTXthStaPrcStk'] == '') {
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                                }
                            ?>
                            <tr class="text-left xCNTextDetail2 otrPurchaseoeder" id="otrPurchaseoeder<?=$key?>" data-code="<?=$aValue['FTXthDocNo']?>" data-name="<?=$aValue['FTXthDocNo']?>">
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?=$CheckboxDisabled?>>
                                            <span class="<?=$ClassDisabled?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td class="text-left"><?=$aValue['FTBchName'] != '' ? $aValue['FTBchName'] : '-' ?></td>
                                <td class="text-left"><?=$aValue['FTXthDocNo'] != '' ? $aValue['FTXthDocNo'] : '-' ?></td>
                                <td class="text-center"><?=$aValue['FDXthDocDate'] != '' ? $aValue['FDXthDocDate'] : '-' ?></td>
                                <td class="text-left"><label class="xCNTDTextStatus <?=$tClassStaDoc?>"><?=$tStaDoc ?></label></td>
                                <td class="text-left"><label class="xCNTDTextStatus <?=$tClassPrcStk?>"><?=$tStaPrcDoc ?></label></td>
                                <td class="text-left"><?=$aValue['FTCreateByName'] != '' ? $aValue['FTCreateByName'] : '-' ?></td>
                                <td class="text-left"><?php if($aValue['FTXthApvCode']!=""){ echo $aValue['FTXthApvName']; }else{ ?> <?= language('document/adjuststockvd/adjuststockvd','tADJVDNotFound')?> <?php } ?></td> 
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <img class="xCNIconTable xCNIconDel <?=$ClassDisabled?>" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" <?=$Onclick?> title="<?=$Title?>">
                                    </td>
                                <?php endif; ?>
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td class="text-center">
                                        <?php if($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaDoc'] == 3){ ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/view2.png'?>" onClick="JSvCallPageADJVDEdit('<?php echo $aValue['FTXthDocNo']?>')">
                                        <?php }else{ ?>
                                            <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageADJVDEdit('<?php echo $aValue['FTXthDocNo']?>')">
                                        <?php } ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php 
                            }
                        } else{ ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                  <?php } ?>
                <?php else:?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPage btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvADJVDClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvADJVDClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvADJVDClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDel">
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
				<button id="osmConfirm" onClick="JSxADJVDDelChoose()" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button">
					<?=language('common/main/main', 'tModalConfirm')?>
				</button>
				<button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button" data-dismiss="modal">
					<?=language('common/main/main', 'tModalCancel')?>
				</button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code'); 
        var tName = $(this).parent().parent().parent().data('name'); 
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
</script>