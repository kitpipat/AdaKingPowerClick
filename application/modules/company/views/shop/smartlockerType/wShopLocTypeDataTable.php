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
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tShopNumber')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;text-align:center;"><?=language('company/shop/shop','tNameTabSmartLockerLayout')?></th>
						<th nowrap class="xCNTextBold" style="width:20%;text-align:center;"><?=language('company/shop/shop','tLocTypeName')?></th>
                        <th nowrap class="xCNTextBold" style="width:20%;text-align:center;"><?=language('company/shop/shop','tLocRemark')?></th>
                        <th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBDelete')?></th>
						<th nowrap class="xCNTextBold" style="width:5%;text-align:center;"><?=language('company/shop/shop','tSHPTBEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2">
                            <?php  
                                    if($aValue['FTShtType'] ==1){
                                        $FTShtType =  language('supplier/supplier/supplier','tGeneralLoc');
                                    }else if($aValue['FTShtType']  ==2){
                                        $FTShtType = language('supplier/supplier/supplier','tTempleLoc');
                                    }
                            ?>
                            <td nowrap class="text-center"><?=$key+1?></td>
                            <td nowrap class="text-left"><?=$FTShtType?></td>
                            <td nowrap class="text-left"><?=$aValue['FTShtName'] ?></td>
                            <td nowrap class="text-left"><?=$aValue['FTShtRemark'] ?></td>
                            <td nowrap class="text-center">
                                <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxSmartLockerTypeDelete('<?=$aValue['FTBchCode']?>','<?=$aValue['FTShpCode']?>','<?=$aValue['FTShtType']?>','<?=$aValue['FTShtName']?>');">
                            </td>
                            <td nowrap class="text-center">
                                <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSxSmartLockerTypeEdit('<?=$aValue['FTBchCode']?>','<?=$aValue['FTShpCode']?>','<?=$aValue['FTShtType']?>');">
                            </td>
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
    <!-- <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWSMLPaging btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSMLClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabledLeft ?>> 
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
                <button onclick="JSvSMLClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive ?>" <?=$tDisPageNumber ?>><?=$i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSMLClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div> -->
</div>


<!--Modal Delete Single-->
<div id="odvModalDeleteSmartLockertType" class="modal fade" tabindex="-1" role="dialog" data-backdrop="static" data-keyboard="false" style="overflow: hidden auto; z-index: 7000; display: none;">
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
    
    //Event Delete
    function JSxSmartLockerTypeDelete(ptBchCode,ptShpCode,ptType,ptName){
        $('#odvModalDeleteSmartLockertType').modal('show');
        $('#odvModalDeleteSmartLockertType #ospConfirmDelete').html($('#oetTextComfirmDeleteSingle').val() + ' ' + ptName);
        $('#odvModalDeleteSmartLockertType #osmConfirmDelete').click('click', function(evt) {
            JCNxOpenLoading();
            $.ajax({
                type    : "POST",
                url     : "LocTypeEventDelete",
                data    : { 
                    ptBchCode   : ptBchCode,
                    ptShpCode   : ptShpCode,
                    ptType      : ptType
                },
                cache: false,
                success: function(tResult) {
                    $('#odvModalDeleteSmartLockertType').modal('hide');
                    JSxGetSHPContentSmartLockerType();
                    JCNxCloseLoading();
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        });        
    }

    //Event Edit
    function JSxSmartLockerTypeEdit(ptBchCode,ptShpCode,ptType){
        $.ajax({
            type    : "POST",
            url     : "LocTypeDataAddOrEdit",
            data    : {
                tBchCode        : ptBchCode,
                tShpCode        : ptShpCode,
                tTypePage       : 'pageedit'
            },
            cache   : false,
            timeout : 5000,
            success: function(tResult) {
                $('#odvSHPContentSmartLockerType').html(tResult);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }
</script>