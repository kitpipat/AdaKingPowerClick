<?php 
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<?php

//ประเภท 1:ข้อความต้อนรับ  2:ข้อความประชาสัมพันธ์  3:ภาพเคลื่อนไหว 4.ข้อความขอบคุณ 5:เสียงประชาสัมพันธ์ 6:รูปภาพ

$aAdTypeItems = [
    [
        'value' => 1,
        'text' => language('pos/admessage/admessage', 'tADVWelcomeMessage')
    ],
    [
        'value' => 2,
        'text' => language('pos/admessage/admessage', 'tADVPromotionMessage')
    ],
    [
        'value' => 3,
        'text' => language('pos/admessage/admessage', 'tADVVideo')
    ],
    [
        'value' => 4,
        'text' => language('pos/admessage/admessage', 'tADVThankyou')
    ],
    [
        'value' => 5,
        'text' => language('pos/admessage/admessage', 'tADVSound')
    ],
    [
        'value' => 6,
        'text' => language('pos/admessage/admessage', 'tADVPicture')
    ],

];

$aStaUseItems = [
    [
        'value' => 1,
        'text' => language('pos/admessage/admessage', 'tADVEnabled')
    ],
    [
        'value' => 2,
        'text' => language('pos/admessage/admessage', 'tADVDisabled')
    ]
];

?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped" style="width:100%">
                <thead>
					<tr class="xCNCenter">
                    <?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?= language('pos/admessage/admessage','tADVTBChoose')?></th>
                    <?php endif; ?>
                        <th nowrap class="xCNTextBold text-left" style="width:10%;"><?= language('pos/admessage/admessage','tADVTBCode')?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:35%;"><?= language('pos/admessage/admessage','tADVTBName')?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:15%;"><?= language('pos/admessage/admessage','tADVTBType')?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?= language('pos/admessage/admessage','tADVTBStartDate')?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;"><?= language('pos/admessage/admessage','tADVTBEndDate')?></th>
                        <th nowrap class="xCNTextBold text-left" style="width:5%;"><?= language('pos/admessage/admessage','tADVTBStaUse')?></th>
                    <?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaDelete'] == 1) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?= language('pos/admessage/admessage','tADVTBDelete')?></th>
                    <?php endif; ?>
                    <?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaRead'] == 1) : ?>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;"><?= language('pos/admessage/admessage','tADVTBEdit')?></th>
                    <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
				<?php if($aDataList['rtCode'] == 1 ):?>
                    <?php foreach($aDataList['raItems'] AS $key=>$aValue){ ?>
                        <tr class="text-center xCNTextDetail2 otrAdMessage" id="otrAdMessage<?=$key?>" data-code="<?=$aValue['rtAdvCode']?>" data-name="<?=$aValue['rtAdvName']?>">
							<?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaDelete'] == 1) : ?>
								<td nowrap class="text-center">
									<label class="fancy-checkbox">
										<input id="ocbListItem<?=$key?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
										<span>&nbsp;</span>
									</label>
								</td>
							<?php endif; ?>
							<td nowrap class="text-left otdAdvCode"><?=$aValue['rtAdvCode']?></td>
                            <td nowrap class="text-left"><?=$aValue['rtAdvName']?></td>
                            <td nowrap class="text-left">
                                <?php foreach($aAdTypeItems as $aAdTypeItem) : ?>
                                    <?php if($aAdTypeItem['value'] == $aValue['rtAdvType']) : ?>
                                    <?=$aAdTypeItem['text']?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
                            <td nowrap class="text-center"><?=date_format(date_create($aValue['rdAdvStart']),'d/m/Y')?></td>
                            <td nowrap class="text-center"><?=date_format(date_create($aValue['rdAdvStop']),'d/m/Y')?></td>
                            <td nowrap class="text-left">
                                <?php foreach($aStaUseItems as $aStaUseItem) : ?>
                                    <?php if($aValue['rtAdvStaUse'] == $aStaUseItem['value']) : ?>
                                        <?=$aStaUseItem['text']?>
                                    <?php endif; ?>
                                <?php endforeach; ?>
                            </td>
							<?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaDelete'] == 1) : ?>
								<td nowrap><img class="xCNIconTable xCNIconDel" src="<?= base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSaAdMessageDelete('<?=$nCurrentPage?>','<?=$aValue['rtAdvName']?>','<?=$aValue['rtAdvCode']?>')"></td>
							<?php endif; ?>
							<?php if($aAlwEventAdMessage['tAutStaFull'] == 1 || $aAlwEventAdMessage['tAutStaRead'] == 1) : ?>
								<td nowrap><img class="xCNIconTable" src="<?= base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvCallPageAdMessageEdit('<?=$aValue['rtAdvCode']?>')"></td>
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
		<p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageAdMessage btn-toolbar pull-right">
			<?php if($nPage == 1){ $tDisabled = 'disabled'; }else{ $tDisabled = '-';} ?>
            <button onclick="JSvAdMessageClickPage('previous')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-left f-s-14 t-plus-1"></i></button>

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
            		<button onclick="JSvAdMessageClickPage('<?=$i?>')" type="button" class="btn xCNBTNNumPagenation <?=$tActive?>" <?=$tDisPageNumber ?>><?=$i?></button>
			<?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){ $tDisabled = 'disabled'; }else{ $tDisabled = '-'; } ?>
			<button onclick="JSvAdMessageClickPage('next')" class="btn btn-white btn-sm" <?=$tDisabled?>><i class="fa fa-chevron-right f-s-14 t-plus-1"></i></button>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalDelAdMessage">
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
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSnAdMessageDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<script type="text/javascript">
$('ducument').ready(function(){
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
		var tDataCode = $('#otrAdMessage'+$i).data('code')
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
    })
});
</script>