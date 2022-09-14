<style>
    .xWCstLogActive {
        color: #007b00 !important;
        font-weight: bold;
        font-size: 10px;
        cursor: default;
    }
    .xWCstLogInActive {
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
                        <?php //if($aAlwEventCstlogin['tAutStaFull'] == 1 || $aAlwEventCstlogin['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer','tCstlogChoose')?></th>
                        <?php //endif; ?>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('customer/customer/customer','tCstloginAcc')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer','tCstloginPwd')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('customer/customer/customer','tCstDateStart')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?php echo language('customer/customer/customer','tCstDateStop')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer','tCstLoginType')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?php echo language('customer/customer/customer','tCstStatusUse')?></th>

                        <!--BTN Edit-->
                        <?php //if($aAlwEventCstlogin['tAutStaFull'] == 1 || $aAlwEventCstlogin['tAutStaDelete'] == 1):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('customer/customer/customer','tCstTBDelete')?></th>
                        <?php //endif; ?>
                        <!--BTN Delete-->
                        <?php //if($aAlwEventCstlogin['tAutStaFull'] == 1 || ($aAlwEventCstlogin['tAutStaEdit'] == 1 || $aAlwEventCstlogin['tAutStaRead'] == 1)):?>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('customer/customer/customer','tCstTBEdit')?></th>
                        <?php //endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                            <tr class="text-center xCNTextDetail2" data-code="<?=$aValue['FDCstPwdStart']?>">
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]"
                                        ohdConfirmCstCodeDelete="<?=$aValue['FTCstCode'];?>"
                                        ohdConfirmLogTypeDelete="<?=$aValue['FTCstLogType'];?>"
                                        ohdConfirmPwdStartDelete="<?=$aValue['FDCstPwdStart'];?>">
                                        <span>&nbsp;</span>
                                    </label>
                                </td>

                                <?php 
                                    switch ($aValue['FTCstLogType']){
                                        case 0 : 
                                            $tStaCstlogName  =  $aValue['rtCstType'];
                                        break;
                                        case 5 :
                                            $tStaCstlogName  =  $aValue['rtCstType'];
                                        break;
                                        default:
                                            $tStaCstlogName  =  $aValue['FTCstLogin'];
                                    }
                                ?>

                                <td nowrap class="text-left xWTdBody"><?php echo $tStaCstlogName;?></td>
                                <td nowrap class="text-center">*****</td>

                                <td nowrap class="text-center"><?php echo $aValue['FDCstPwdStart'];?></td>
                                <td nowrap class="text-center"><?php echo $aValue['FDCstPwdExpired'];?></td>


                                <?php 
                                    switch ($aValue['FTCstLogType']) {
                                        case 0:
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypeCardCode'); 
                                        break;
                                        case 1:
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypePwd');  
                                        break;
                                        case 2:
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypePin');
                                        break;
                                        case 3:
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypeRFID');
                                        break;
                                        case 4:
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypeQR');
                                        break;
                                        case 5 :
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypeFace');
                                        break;
                                        default:
                                            $tStaCstlogType     = language('customer/customer/customer','tCstTypePwd');
                                    }
                                ?>
                                <td nowrap class="text-left"><?php echo $tStaCstlogType;?></a></td>

                                <?php 
                                    switch ($aValue['FTCstStaActive']) {
                                        case 1:
                                            $tStaCstlogAct     = language('customer/customer/customer','tCstLActive');  
                                            $tClassStaAtv   = 'xWCstLogActive';
                                            break;
                                        case 2:
                                            $tStaCstlogAct     = language('customer/customer/customer','tCstLInactive');
                                            $tClassStaAtv   = 'xWCstLogInActive';
                                            break;
                                        default:
                                            $tStaCstlogAct     = language('customer/customer/customer','tCstLActive');
                                            $tClassStaAtv   = 'xWCstLogActive';
                                    }
                                ?>

                                <td nowrap class="text-left"><a class="<?php echo $tClassStaAtv?>"><?php echo $tStaCstlogAct;?></a></td>

                                <?php //if($aAlwEventCrdlogin['tAutStaFull'] == 1 || $aAlwEventCrdlogin['tAutStaDelete'] == 1): ?>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxCSTLDelete('<?=$aValue['FTCstLogin']?>','<?=$aValue['FTCstCode'];?>', '<?=$aValue['FDCstPwdStart'];?>', '<?= language('common/main/main','tModalConfirmDeleteItemsYN')?>')">
                                    </td>
                                <?php //endif; ?>

                                <?php //if($aAlwEventCrdlogin['tAutStaFull'] == 1 || ($aAlwEventCrdlogin['tAutStaEdit'] == 1 || $aAlwEventCrdlogin['tAutStaRead'] == 1)) : ?>
                                    <td nowrap class="text-center">
                                        <img class="xCNIconTable xWIMGShpShopEdit" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageCstloginEdit('<?=$aValue['FTCstLogin']?>','<?=$aValue['FDCstPwdStart'];?>');">
                                    </td>
                                <?php //endif; ?>
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
        <div class="xWCSTLPaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvCSTLClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
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
                <button onclick="JSvCSTLClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCSTLClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
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
                <span id="ospConfirmDelete"><?php echo language('common/main/main','tModalDeleteMulti');?></span>
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSxCSTLDeleteMutirecord('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>


<!--Modal Delete Single-->
<div id="odvModalCstloginDeleteSingle" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
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
            JSxCSTLPaseCodeDelInModal();

        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',nCode);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nCode": nCode, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxCSTLPaseCodeDelInModal();

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
                JSxCSTLPaseCodeDelInModal();
                }
            }
            JSxCSTLShowButtonChoose();
        });
    });
</script>
