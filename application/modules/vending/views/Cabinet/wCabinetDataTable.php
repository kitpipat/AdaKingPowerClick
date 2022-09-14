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
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th class="xCNTextBold text-center"     style="width:10%;"><?=language('vending/cabinet/cabinet','tTableCabinetSelect'); ?></th>
                        <th class="xCNTextBold text-left"       style="width:10%;"><?=language('vending/cabinet/cabinet','tTableCabinetName'); ?></th>
                        <!-- <th class="xCNTextBold text-left"       style="width:10%;"><? //=language('vending/cabinet/cabinet','tTableCabinetCodeRef'); ?></th> -->
                        <!-- <th class="xCNTextBold text-left"       style="width:10%;"><?=language('vending/cabinet/cabinet','tTableCabinetType'); ?></th> -->
                        <th class="xCNTextBold text-left"       style="width:15%;"><?=language('vending/cabinet/cabinet','tTableCabinetTypeRef'); ?></th>
                        <!-- <th class="xCNTextBold text-right"      style="width:10%;"><? //=language('vending/cabinet/cabinet','tTableCabinetSeq'); ?></th> -->
                        <th class="xCNTextBold text-right"      style="width:10%;"><?=language('vending/cabinet/cabinet','tTableCabinetMaxRow'); ?></th>
                        <th class="xCNTextBold text-right"      style="width:10%;"><?=language('vending/cabinet/cabinet','tTableCabinetMaxColumn'); ?></th>
                        <th class="xCNTextBold text-center"     style="width:10%;"><?=language('supplier/supplier/supplier','tDelete'); ?></th>
                        <th class="xCNTextBold text-center"     style="width:10%;"><?=language('supplier/supplier/supplier','tEdit'); ?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $key => $aValue){ ?>
                            <tr class="text-center xCNTextDetail2 otrCabinet" id="otrCabinet<?=$key;?>" data-bch="<?=$aValue['FTBchCode']; ?>" data-shp="<?=$aValue['FTShpCode']; ?>" data-seq="<?=$aValue['FNCabSeq'];?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$key; ?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <td class="text-left"><?=$aValue['FTCabName']; ?></td>
                                <!-- <td class="text-left"><?//=$aValue['FTShpCode']; ?></td> -->

                                <?php 
                                    // if($aValue['FNCabType'] == 1){
                                    //     $tCabinetType = language('vending/cabinet/cabinet','tSelectCabinetTypeVending');
                                    // }else{
                                    //     $tCabinetType = language('vending/cabinet/cabinet','tSelectCabinetTypeLocker');
                                    // }
                                ?>
                                <!-- <td class="text-left"><?=$tCabinetType;?></td> -->
                                <td class="text-left"><?=$aValue['FTShtName'] . ' (' . $aValue['FTShtCode'] . ')'; ?></td>
                                <!-- <td class="text-right"><?=$aValue['FNCabSeq']; ?></td> -->
                                <td class="text-right"><?=$aValue['FNCabMaxRow']; ?></td>
                                <td class="text-right"><?=$aValue['FNCabMaxCol']; ?></td>
                                <td>
                                    <!-- <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCabinetDelete('<?=$nCurrentPage?>','<?=$aValue['FTShpCode']?>','<?=$aValue['FNCabSeq']?>','<?=$tCabinetType?>')" title="<?=language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>"> -->
                                    <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaCabinetDelete('<?=$nCurrentPage?>','<?=$aValue['FTShpCode']?>','<?=$aValue['FNCabSeq']?>')" title="<?=language('pos/slipMessage/slipmessage', 'tSMGTBDelete'); ?>">

                                </td>
                                <td>
                                    <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCabinetEdit('<?=$aValue['FTShpCode']; ?>','<?=$aValue['FNCabSeq']?>')" title="<?=language('pos/slipMessage/slipmessage', 'tSMGTBEdit'); ?>">
                                </td>
                            </tr>
                        <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='9'><?=language('common/main/main','tCMNNotFoundData');?></td></tr>
                    <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo $aDataList['rnCurrentPage']; ?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-md-6">
        <div class="xWPageCabinet btn-toolbar pull-right"> <!-- เปลี่ยนชื่อ Class เป็นของเรื่องนั้นๆ --> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvClickPageCabinet('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?> <!-- เปลี่ยนชื่อ Parameter Loop เป็นของเรื่องนั้นๆ --> 
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
                <button onclick="JSvClickPageCabinet('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvClickPageCabinet('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<!--DELETE Single-->
<div class="modal fade" id="odvModalDelCabinet">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onclick="JSxCabinetDeleteSingle()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!--DELETE Muti-->
<div class="modal fade" id="odvModalDelCabinetMuti">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDeleteMuti"> - </span>
				<input type='hidden' id="ohdConfirmIDDeleteMuti">
			</div>
			<div class="modal-footer">
				<button type="button" class="btn xCNBTNPrimery" onclick="JSxCabinetDeleteMuti()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>


<script type="text/javascript">
    $('ducument').ready(function(){
        localStorage.removeItem("LocalItemData");
        $('.ocbListItem').click(function(){
            var nSHP = $(this).parent().parent().parent().data('shp');  
            var nSEQ = $(this).parent().parent().parent().data('seq'); 
            $(this).prop('checked', true);
            var LocalItemData = localStorage.getItem("LocalItemData");
            var obj = [];
            if(LocalItemData){
                obj = JSON.parse(LocalItemData);
            }else{ }
            var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
            if(aArrayConvert == '' || aArrayConvert == null){
                obj.push({"nSHP": nSHP, "nSEQ": nSEQ });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPaseCodeDelInModalCabinet();
            }else{
                var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nSEQ',nSEQ);
                if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                    obj.push({"nSHP": nSHP, "nSEQ": nSEQ });
                    localStorage.setItem("LocalItemData",JSON.stringify(obj));
                    JSxPaseCodeDelInModalCabinet();
                }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                    localStorage.removeItem("LocalItemData");
                    $(this).prop('checked', false);
                    var nLength = aArrayConvert[0].length;
                    for($i=0; $i<nLength; $i++){
                        if(aArrayConvert[0][$i].nSEQ == nSEQ){
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
                    JSxPaseCodeDelInModalCabinet();
                }
            }
            JSxShowButtonChoose();
        })
    });
</script>