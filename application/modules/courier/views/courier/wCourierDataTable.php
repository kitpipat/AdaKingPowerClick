<?php
    if($aDataList['tCode'] == '1'){
        $nCurrentPage = $aDataList['nCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
					<tr class="xCNCenter">
					<?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold" style="width:5%;"><?= language('courier/courier/courier','tCRYTBChoose')?></th>
                    <?php endif; ?>
                        <th nowrap class="xCNTextBold" style="width:7%;"><?= language('courier/courier/courier','tCRYTBImage')?></th>
						<th nowrap class="xCNTextBold" style="width:7%;"><?= language('courier/courier/courier','tCRYTBCode')?></th>
						<th nowrap class="xCNTextBold"><?= language('courier/courier/courier','tCRYTBName')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?= language('courier/courier/courier','tCRYTBType')?></th>
						<th nowrap class="xCNTextBold" style="width:15%;"><?= language('courier/courier/courier','tCRYTBBranch')?></th>
                        <th nowrap class="xCNTextBold" style="width:10%;"><?= language('courier/courier/courier','tCRYTBTel')?></th>
                        <th nowrap class="xCNTextBold" style="width:15%;"><?= language('courier/courier/courier','tCRYTBEmail')?></th>
						<?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaDelete'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
						<?php endif; ?>
						<?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaRead'] == 1) : ?>
						<th nowrap class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
				<?php if($aDataList['tCode'] == 1 ):?>
                    <?php foreach($aDataList['aItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrCourier" id="otrCourier<?=$key?>" data-code="<?=$aValue['FTCryCode']?>" data-name="<?=$aValue['FTCryName']?>" data-page="<?=$nCurrentPage?>">
							<?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaDelete'] == 1) : ?>
								<td nowrap class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
										<span>&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
                            <td nowrap class="text-center"><?=FCNtHGetImagePageList($aValue['FTImgObj'],'40px')?></td>
							<td nowrap class="text-left"><?=$aValue['FTCryCode']?></td>
                            <td nowrap class="text-left"><?=$aValue['FTCryName']?></td>
                            <td nowrap class="text-left">
                                <?php
                                    if($aValue['FTCryBusiness'] == '1'){ echo language('courier/courier/courier','tCRYTDBusiness1'); }
                                    else if($aValue['FTCryBusiness'] == '2'){ echo language('courier/courier/courier','tCRYTDBusiness2'); }
                                ?>
                            </td>
                            <td nowrap class="text-left"><?php if($aValue['FTCryBchHQ']!="1"){ echo $aValue['FTBchName']; }else{ echo language('courier/courier/courier','tCRYADDBch1'); } ?></td>
                            <td nowrap class="text-left"><?=$aValue['FTCryTel']?></td>
                            <td nowrap class="text-left"><?=$aValue['FTCryEmail']?></td>
							<?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaDelete'] == 1) : ?>
								<td nowrap><img class="xCNIconTable xCNIconDel xWCRYTDDel" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>"></td>
							<?php endif; ?>
							<?php if($aAlwEventCourier['tAutStaFull'] == 1 || $aAlwEventCourier['tAutStaRead'] == 1) : ?>
								<td nowrap><img class="xCNIconTable xWCRYTDEdit" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>"></td>
							<?php endif; ?>
                        </tr>
                    <?php } ?>
                <?php else:?>
                    <tr><td nowrap class='text-center xCNTextDetail2' colspan='9'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div class="row">
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['nAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['nCurrentPage']?> / <?=$aDataList['nAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageCourier btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvCRYClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

			<?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataList['nAllPage'],$nPage+2)); $i++){?>
				<?php
                    if($nPage == $i){
                        $tActive = 'active';
                        $tDisPageNumber = 'disabled';
                    }else{
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
            		<button onclick="JSvCRYClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['nAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvCRYClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelCourier">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoEventCourierDeleteMulti('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('ducument').ready(function(){
    $('.xWCRYTDEdit').click(function(){
        var tCode = $(this).parent().parent().data('code');
        JSvCallPageCourierEdit(tCode);
    });
    $('.xWCRYTDDel').click(function(){
        var tCode = $(this).parent().parent().data('code');
        var tName = $(this).parent().parent().data('name');
        var nPage = $(this).parent().parent().data('page');
        JSoEventCourierDelete(nPage,tCode,tName);
    });
});

JSxShowButtonChoose();
var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
var nlength = $('#odvRGPList').children('tr').length;
for($i=0; $i < nlength; $i++){
    var tDataCode = $('#otrCourier'+$i).data('code')
    if(aArrayConvert == null || aArrayConvert == ''){
    }else{
        var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nCode',tDataCode);
        if(aReturnRepeat == 'Dupilcate'){
            $('#ocbListItem'+$i).prop('checked', true);
        }else{ }
    }
}

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
