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
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('company/shop/shop','tShpWahChoose')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('company/shop/shop','tWahCode')?></th>
                        <th nowrap class="xCNTextBold" style="width:60%;text-align:center;"><?php echo language('company/shop/shop','tWahName')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('company/shop/shop','tShpWahDelete')?></th>
                    </tr>
                </thead>
                <tbody id="odvShpWahList">
                    <?php if($aDataList['rtCode'] == 1 ):?>  
                        <?php if(!empty($aDataList['raItems'])) { ?>
                            <?php foreach($aDataList['raItems'] AS $key =>$aValue){ ?>
                                <tr class="text-center xCNTextDetail2" data-code="<?=$aValue['FTWahCode']?>">
                                    <td class="text-center">
                                        <label class="fancy-checkbox">
                                            <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"
                                            ohdBchCodeDelete="<?=$aValue['FTBchCode'];?>"
                                            ohdShopCodeDelete="<?=$aValue['FTShpCode'];?>"
                                            ohdWahCodeDelete="<?=$aValue['FTWahCode'];?>">
                                            <span>&nbsp;</span>
                                        </label>
                                    </td>
                                    <td nowrap class="text-center"><?php echo $aValue['FTWahCode'];?></td>
                                    <td nowrap class="text-left"><?php echo $aValue['FTWahName'];?></td>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxShpWahDelete('<?=$aValue['FTBchCode']?>','<?=$aValue['FTShpCode']?>','<?=$aValue['FTWahCode']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    </td>
                                </tr>
                            <?php } ?>
                        <?php } ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='12'><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<!-- click Page -->
<div class="row">
	<div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?=language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?=language('common/main/main','tRecord')?> <?=language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWShpWahPaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvShpWahClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
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
                <button onclick="JSvShpWahClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvShpWahClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
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
            <span id="ospConfirmDelete"></span>
                   
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxSHPWAHDeleteMutirecord('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

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
    // Select List Userlogin Table Item
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
            JSxShpWahPaseCodeDelInModal();

        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxShpWahPaseCodeDelInModal();

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
                JSxShpWahPaseCodeDelInModal();
                }
            }
            JSxShpWahShowButtonChoose();
        });
    });
</script>

