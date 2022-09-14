<?php 
    if($aPshDataList['rtCode'] == '1'){
        $nCurrentPage = $aPshDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbLocDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventPosShop['tAutStaFull'] == 1 || $aAlwEventPosShop['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('address/zone/zone','tZNEChoose')?></th>
						<?php endif; ?>
                        <th class="text-center xCNTextBold" style="width:5%;"><?= language('pos/posshop/posshop','tPshTBNo')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posshop/posshop','tPshTBPosCode')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posshop/posshop','tPshTBPosName')?></th>

                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posshop/posshop','tPshTBSN')?></th>
                        <th class="text-center xCNTextBold" style="width:15%;"><?= language('pos/posshop/posshop','tPSHNoLayoutStatus')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posshop/posshop','tPshTBSta')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posshop/posshop','tPshTBDel')?></th>
                        <th class="text-center xCNTextBold" style="width:10%;"><?= language('pos/posshop/posshop','tPshTBEdit')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPshDataList['rtCode'] == 1 ):?>
                        <?php foreach($aPshDataList['raItems'] AS $nKey => $aValue):?>
                                <tr class="text-center xCNTextDetail2 otrPdtLoc xWPosShopDataSource"  data-shp="<?=$aValue['FTShpCode']?>"  data-bch="<?=$aValue['FTBchCode']?>" data-code="<?=$aValue['FTPosCode']?>" data-name="<?php echo $aValue['FTPosCode']?>">
                                <?php if($aAlwEventPosShop['tAutStaFull'] == 1 || $aAlwEventPosShop['tAutStaDelete'] == 1) : ?>
                                <td nowrap class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?php echo $nKey?>" class="ocbListItem" name="ocbListItem[]" type="checkbox">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                                <?php endif; ?>
                                <td class="text-center"><?php echo $nNum = $nKey + 1;?></td>
                                <td nowrap class="text-left"><?php echo $aValue['FTPosCode']?></td>
                                <td nowrap class="text-left"><?php echo $aValue['FTPosName']?></td>
                               
                                <td nowrap class="text-left"><?php echo $aValue['FTPshPosSN']?></td>
                                <td nowrap class="text-center">
                                <?php 
                                    switch ($aValue['FTShpSceLayout']) {
                                        case '1': echo language('vending/cabinet/cabinet','tTableCabinetPayPdt'); break;
                                        case '2': echo language('vending/cabinet/cabinet','tTableCabinetPaySelect'); break;
                                        case '3': echo language('vending/cabinet/cabinet','tTableCabinetSelectAdvertising'); break;

                                        case '4': echo language('vending/cabinet/cabinet','tTableCabinetSelect'); break;
                                        case '5': echo language('vending/cabinet/cabinet','tTableCabinetSellPdt'); break;
                                        case '6': echo language('vending/cabinet/cabinet','tTableCabinetSelPdtAdvertising'); break;
                                    }
                                ?>
                            </td>
                                <td nowrap class="text-center">
                                    <?php if($aValue['FTPshStaUse'] == 1){
                                        echo language('pos/posshop/posshop','tPshStaActive'); 
                                    }
                                    else{
                                        echo language('pos/posshop/posshop','tPshStaNotActive');
                                    }?>
                                </td>
                                <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPosShopDel('<?=$nCurrentPage?>','<?=$aValue['FTPosCode']?>','<?=$aValue['FTPshPosSN']?>','<?=$aValue['FTShpCode']?>','<?=$aValue['FTBchCode']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')"></td>
                                <td>
                                    <img class="xCNIconTable xWIMGPosShopEdit" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPagePosShopEventEdit('<?=$aValue['FTBchCode']?>','<?=$aValue['FTPosCode']?>','<?=$aValue['FTShpCode']?>',<?=$aValue['FTPshStaUse']?>,<?=$aValue['FTShpSceLayout']?>)">
                                </td>  
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='10'><?= language('pos/posshop/posshop','tPSHNoData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPshDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPshDataList['rnCurrentPage']?> / <?=$aPshDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePsh btn-toolbar pull-right"> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPshClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPshDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                
                <button onclick="JSvPshClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPshDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPshClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelPosShop">
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
				<button id="osmConfirmMulti" type="button" class="btn xCNBTNPrimery" onClick="JSxSMSDeleteMutirecord()"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>
<!--End modal Delete Mutirecord-->

<?php include "script/jPosShopMain.php"; ?>
<script type="text/javascript">
   // Select List ShopSize Table Item
   $(function() {
    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        var nBch  = $(this).parent().parent().parent().data('bch');  //code
        var nShp  = $(this).parent().parent().parent().data('shp');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nCode": nCode, "tName": tName, "nBch" : nBch, "nShp" : nShp});
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPSHPaseCodeDelInModal();

        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName , "nBch" : nBch, "nShp" : nShp});
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxPSHPaseCodeDelInModal();

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
                JSxPSHPaseCodeDelInModal();
                }
            }
            JSxPSHShowButtonChoose();
        });
    });
</script>