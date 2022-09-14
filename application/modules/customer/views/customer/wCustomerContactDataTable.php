<style>
.xWImgCustomer {
    max-width: 50px;
}
</style>
<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <!-- <table class="table table-hover table-responsive" style="width:100%"> -->
            <table class="table table-striped" style="width:100%">
                <thead>
                    <tr class="xCNCenter">
                        <?php if(false) : ?>
                        <th nowrap class="xCNTextBold text-left" style="width:13.333%;"><?= language('customer/customer/customer','tCSTRfidImage')?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold text-left" style="width:30%;"><?= language('customer/customer/customer','tCSTContactName')?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:30%;"><?= language('customer/customer/customer','tCSTContactEmail')?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:30%;"><?= language('customer/customer/customer','tCSTContactTel')?></th>
                        <?php if(false) : ?>
                        <th nowrap class="xCNTextBold text-left" style="width:13.333%;"><?= language('customer/customer/customer','tCSTContactFax')?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:13.333%;"><?= language('customer/customer/customer','tCSTContactComment')?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTDelete')?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?= language('customer/customer/customer','tCSTEdit')?></th>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                <?php if($aDataList['rtCode'] == 1 ) : ?>
                    <?php foreach($aDataList['raItems'] as $key => $aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrContact" id="<?=$aValue['rtCtrSeq']?>">
                            <input type="hidden" value="<?php echo $aValue['rtCtrFax']; ?>" class="xWCtrFax">
                            <input type="hidden" value="<?php echo $aValue['rtCtrRmk']; ?>" class="xWCtrRmk">
                            <input type="hidden" value="<?php echo $aValue['rtCtrSeq']; ?>" class="xWCtrSeq">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddSeqNo']; ?>" class="xWCtrSeqNo">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddV1No']; ?>" class="xWCtrNo">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddV1Soi']; ?>" class="xWCtrSoi">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddV1Village']; ?>" class="xWCtrVillage">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddV1Road']; ?>" class="xWCtrRoad">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddCountry']; ?>" class="xWCtrCountry">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddZoneCode']; ?>" class="xWCtrZoneCode">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddZoneName']; ?>" class="xWCtrZoneName">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddAreaCode']; ?>" class="xWCtrAreaCode">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddProvinceCode']; ?>" class="xWCtrPvnCode">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddProvinceName']; ?>" class="xWCtrPvnName">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddDistrictCode']; ?>" class="xWCtrDstCode">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddDistrictName']; ?>" class="xWCtrDstName">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddSubDistrictCode']; ?>" class="xWCtrSubDistCode">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddSubDistrictName']; ?>" class="xWCtrSubDistName">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddPostCode']; ?>" class="xWCtrPostCode">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddWebsite']; ?>" class="xWCtrWebsite">
                            <input type="hidden" value="<?php echo empty($aValue['rtCtrAddLongitude'])?"100.50182294100522":$aValue['rtCtrAddLongitude']; ?>" class="xWCtrLongitude">
                            <input type="hidden" value="<?php echo empty($aValue['rtCtrAddLatitude'])?"13.757309968845291":$aValue['rtCtrAddLatitude']; ?>" class="xWCtrLatitude">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddV2Desc1']; ?>" class="xWCtrDesc1">
                            <input type="hidden" value="<?php echo $aValue['rtCtrAddV2Desc2']; ?>" class="xWCtrDesc2">
                            <?php
                            /*$tCstImage;
                            if($aValue['rtImgObj'] != ''){
                                $tCstImage = 'system/' . $aValue['rtImgObj'];
                            }
                            else{
                                $tCstImage = 'images/Noimage.png';
                            }*/
                            ?>
                            <?php if(false) : ?>
                            <td class="text-left"><img class="xWImgCustomer" src="<?php echo base_url() . 'application/assets/' . $tCstImage; ?>"></td>
                            <?php endif; ?>
                            <td class="text-left xWCtrName"><?=$aValue['rtCtrName']?></td>
                            <td class="text-left xWCtrEmail"><?=$aValue['rtCtrEmail']?></td>
                            <td class="text-left xWCtrTel"><?=$aValue['rtCtrTel']?></td>

                            <td nowrap class="text-center">
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSxCSTCtrDeleteOperator('<?php echo $aValue['rtCtrName']?>','<?php echo $aValue['rtCstCode'];?>','<?php echo $aValue['rtCtrSeq'];?>','<?php echo language('common/main/main','tBCHYesOnNo')?>')">
                            </td>

                            <td>
                                <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSxCSTCtrEditOperator(this, event)">
                            </td>
                            <!-- <td><i style="display:block;text-align:center;" class="xWCstCtrDeleteOperator fa fa-trash-o fa-lg" onClick="JSxCSTCtrDeleteOperator(this, event)"></i></td>
                            <td><i style="display:block;text-align:center;" class="xWCstCtrEditOperator fa fa-pencil-square-o fa-lg" onClick="JSxCSTCtrEditOperator(this, event)"></i></td> -->
                        </tr>
                    <?php } ?>
                <?php else : ?>
                    <tr><td class='text-center xCNTextDetail2' colspan='5'><?= language('common/main/main','tCMNNotFoundData')?> </td></tr>
                <?php endif;?>
                </tbody>
			</table>
        </div>
    </div>
</div>

<div class="row">
    <!-- เปลี่ยน -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
         <p><?php echo language('common/main/main','tResultTotalRecord');?> <?php echo $aDataList['rnAllRow'];?> <?php echo language('common/main/main','tRecord');?> <?php echo $aDataList['rnCurrentPage']; ?> / <?php echo $aDataList['rnAllPage']; ?></p>
    </div>
    <!-- เปลี่ยน -->
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageCstContact btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvCSTCtrClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for($i = max($nPage-2, 1); $i <= max(0, min($aDataList['rnAllPage'],$nPage+2)); $i++){?>
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
                <button onclick="JSvCSTCtrClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvCSTCtrClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> <!-- เปลี่ยนชื่อ Onclick เป็นของเรื่องนั้นๆ --> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
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
$('ducument').ready(function(){});
</script>
