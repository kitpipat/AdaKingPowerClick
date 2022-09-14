<style>
    .xWCurLogActive {
        color: #007b00 !important;
        font-weight: bold;
        font-size: 10px;
        cursor: default;
    }
    .xWCurLogInActive {
        color: #7b7f7b !important;
        font-weight: bold;
        cursor: default;
        font-size: 10px;
    }
</style>

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
                        <?php if($aAlwEventCURL['tAutStaFull'] == 1 || $aAlwEventCURL['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('courier/courier/courier','tCurlogChoose')?></th>
						<?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('courier/courier/courier','tCurloginAcc')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('courier/courier/courier','tCurloginPwd')?></th>
						<th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('courier/courier/courier','tDateStart')?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;text-align:center;"><?php echo language('courier/courier/courier','tDateStop')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('courier/courier/courier','tLoginType')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('courier/courier/courier','tStatusUse')?></th>

                        <!--BTN Edit-->
                        <?php if($aAlwEventCURL['tAutStaFull'] == 1 || $aAlwEventCURL['tAutStaDelete'] == 1):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBDelete')?></th>
						<?php endif; ?>
                        <!--BTN Delete-->
						<?php if($aAlwEventCURL['tAutStaFull'] == 1 || ($aAlwEventCURL['tAutStaEdit'] == 1 || $aAlwEventCURL['tAutStaRead'] == 1)):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2" data-code="<?=$aValue['FTManLogin']?>">
                            <?php if($aAlwEventCURL['tAutStaFull'] == 1 || $aAlwEventCURL['tAutStaDelete'] == 1) : ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"
                                        ohdConfirmCryCodeDelete="<?=$aValue['FTCryCode'];?>"
                                        ohdConfirmCardIdDelete="<?=$aValue['FTManCardID'];?>"
                                        ohdConfirmLogTypeDelete="<?=$aValue['FTManLogType'];?>"
                                        ohdConfirmPwdStartDelete="<?=$aValue['FDManPwdStart'];?>">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>
                            <?php endif; ?>  
                            <td nowrap class="text-left xWTdBody"><?=$aValue['FTManLogin'];?></td>
                            <td nowrap class="text-center">*****</td>
                            <td nowrap class="text-center"><?=$aValue['FDManPwdStart'];?></td>
                            <td nowrap class="text-center"><?=$aValue['FDManPwdExpired'];?></td>

                            <?php 
                                switch ($aValue['FTManLogType']) {
                                    case 1:
                                        $tStaCurlogType     = language('courier/courier/courier','tTypePwd');  
                                        break;
                                    case 2:
                                        $tStaCurlogType     = language('courier/courier/courier','tTypePin');
                                        break;
                                    case 3:
                                        $tStaCurlogType     = language('courier/courier/courier','tTypeRFID');
                                        break;
                                    case 4:
                                        $tStaCurlogType     = language('courier/courier/courier','tTypeQR');
                                        break;
                                    default:
                                        $tStaCurlogType     = language('courier/courier/courier','tTypePwd');
                                }
                            ?>
                            <td nowrap class="text-left"><?php echo $tStaCurlogType;?></a></td>

                            <?php 
                                switch ($aValue['FTManStaActive']) {
                                    case 1:
                                        $tStaCurlogAct     = language('courier/courier/courier','tCURLActive');  
                                        $tClassStaAtv   = 'xWCurLogActive';
                                        break;
                                    case 2:
                                        $tStaCurlogAct     = language('courier/courier/courier','tCURLInactive');
                                        $tClassStaAtv   = 'xWCurLogInActive';
                                        break;
                                    default:
                                        $tStaCurlogAct     = language('courier/courier/courier','tCURLActive');
                                        $tClassStaAtv   = 'xWCurLogActive';
                                }
                            ?>
                            <td nowrap class="text-left"><a class="<?php echo $tClassStaAtv?>"><?php echo $tStaCurlogAct;?></a></td>


                            <?php if($aAlwEventCURL['tAutStaFull'] == 1 || $aAlwEventCURL['tAutStaDelete'] == 1): ?>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxCURLDelete('<?=$aValue['FTManLogin']?>','<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                </td>
                            <?php endif; ?>
                            <?php if($aAlwEventCURL['tAutStaFull'] == 1 || ($aAlwEventCURL['tAutStaEdit'] == 1 || $aAlwEventCURL['tAutStaRead'] == 1)) : ?>
                                <td nowrap class="text-center">
                            
                                    <img class="xCNIconTable xWIMGShpShopEdit" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCourierloginEdit('<?=$aValue['FTManLogin']?>');">
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
            <button onclick="JSvCURLClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
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
                <button onclick="JSvCURLClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCURLClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxCURLDeleteMutirecord('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
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

