<?php

    if($aLimDataList['rtCode'] == '1'){
        $nCurrentPage = $aLimDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
    
    //Decimal Show
    $tDecShow = FCNxHGetOptionDecimalShow();  
?>


<div class="row">
    <div class="col-md-12">
        <input type="hidden" id="nCurrentPageTB" value=""> 
        <div class="table-responsive">
            <table id="otbLimDataList" class="table table-striped">
                <thead>
                    <tr>
                        <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || $aAlwEventSettconpreiod['tAutStaDelete'] == 1) : ?>
                            <th width="3%" class="xCNTextBold text-center">
                                <label class="fancy-checkbox">
                                    <span style="font-family: THSarabunNew-Bold; font-weight: 500;"><?=language('settingconfig/settingconperiod/settingconperiod', 'tLimChoose');?></span>
                                </label>
                            </th>
                        <?php endif;?>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMCode'); ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMCondition'); ?></th>
                        <th nowrap class="text-center xCNTextBold"><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMRoleGroup'); ?></th>
                        <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || $aAlwEventSettconpreiod['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="text-center xCNTextBold"><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMDelete'); ?></th>
                        <?php endif;?>
                        <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || ($aAlwEventSettconpreiod['tAutStaEdit'] == 1 || $aAlwEventSettconpreiod['tAutStaRead'] == 1))  : ?>
                            <th nowrap class="text-center xCNTextBold"><?php echo language('settingconfig/settingconperiod/settingconperiod','tLIMEdit'); ?></th>
                        <?php endif;?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aLimDataList['rtCode'] == 1 ):?>
                        <?php foreach($aLimDataList['raItems'] AS $nKey => $aValue) : ?>
                            <tr class="text-cengter xCNTextDetail2" data-code="<?=$aValue['rtLhdCode']?>,<?=$aValue['rtRolCode']?>">
                                <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || $aAlwEventSettconpreiod['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"
                                            ohdLhdCode="<?=$aValue['rtLhdCode'];?>"
                                            ohdRolCode="<?=$aValue['rtRolCode'];?>"
                                            ohdLimSeq="<?=$aValue['rtLimSeq'];?>"
                                        >  <span></span>
                                    </label>
                                </td>
                                <?php endif;?>
                                <td width ="8%" class="text-left"><?php echo $aValue['rtLhdCode'];?></td>
                                <td width ="30%" class="text-left"><?php echo $aValue['rtLhdName'];?></td>
                                <td width ="15%" class="text-left"><?php echo $aValue['rtRolName'];?></td>

                                <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || $aAlwEventSettconpreiod['tAutStaDelete'] == 1) : ?>
                                    <td width="5%" class="text-center">
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoLimDel('<?php echo $nCurrentPage;?>','<?php echo $aValue['rtLhdCode']?>','<?php echo $aValue['rtRolCode']?>','<?php echo $aValue['rtLhdName'];?>','<?php echo language('common/main/main','tBCHYesOnNo')?>')">
                                    </td>
                                <?php endif;?>

                                <?php if($aAlwEventSettconpreiod['tAutStaFull'] == 1 || ($aAlwEventSettconpreiod['tAutStaEdit'] == 1 || $aAlwEventSettconpreiod['tAutStaRead'] == 1)) : ?>
                                    <td width="5%" class="text-center">
                                        <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageLimEdit('<?php echo $aValue['rtLhdCode']?>','<?php echo $aValue['rtRolCode'];?>','<?php echo $aValue['rtLimSeq'];?>')">
                                    </td>
                                <?php endif;?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td nowrap class='text-center xCNTextDetail2' colspan='99'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aLimDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aLimDataList['rnCurrentPage']?> / <?php echo $aLimDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageSettingCoperiod btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvLimClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aLimDataList['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvLimClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aLimDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvLimClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!--Modal Delete Mutirecord-->
<div id="odvModalDeleteMutirecord" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content text-left">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
                <span id="ospConfirmDelete"></span>
			</div>
			<div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoLimDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!--Modal Delete Single-->
<div id="odvModalDeleteSingle" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
	<div class="modal-dialog">
		<div class="modal-content text-left">
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

<script type="text/javascript">

    $('.ocbListItem').click(function(){
        var nCode = $(this).parent().parent().parent().data('code');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        
        $(this).prop('checked', true);
        
        var LocalItemData = localStorage.getItem("LocalItemData");
        
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{}
        
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
</script>

<?php include_once('script/jSettingconperiod.php'); ?>






