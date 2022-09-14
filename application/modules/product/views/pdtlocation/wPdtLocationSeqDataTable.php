<?php 
    $tSeq = 0;
    if($aLocSeqData['rtCode'] == '1'){
        $nCurrentPage = $aLocSeqData['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div id="odvDataTableProduct" class="table-responsive">
    <table id="otbDataTableLocSeq" class="table">
        <thead>
            <tr>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTTBChoose')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTCode')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTName')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTSrnNo')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTBarcode')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTTitleUnit')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tLOCTBLast')?></th>
                <th nowrap class="text-center xCNTextBold" style="width:5%;"><?php echo language('product/pdtlocation/pdtlocation','tPDTTBDelete')?></th>
            </tr>
        </thead>
        <tbody id="odvPdtDataList">
        <?php if(@is_array($aLocSeqData['raItems']) == 1): ?>
            <?php foreach($aLocSeqData['raItems'] AS $key=>$aValue){ ?>
                <?php
                    if($aValue['rtPldSeq'] == ""){
                        $tSeq++;
                    }else{
                        $tSeq = $aValue['rtPldSeq'];
                    }
                ?>

                <tr class="text-center xCNTextDetail xWDataTableLocSeq" id="otrPdtLocSeq<?=$key?>" data-plc="<?=$FTPlcCode?>" data-bar="<?=$aValue['rtBarCode']?>" data-name="<?=$aValue['rtPdtName']?>">
                    <td style="width:5%">
                        <label class="fancy-checkbox">
                            <input id="ocbListItem<?=$tSeq?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                            <span>&nbsp;</span>
                        </label>
                        <input name="ohdGrpPdt[]" type="hidden" class="xCNHide" value="<?=$FTPlcCode?>,<?=$aValue['rtBarCode']?>">
                    </td>
                    <td style="width:5%"><?=$aValue['rtPdtCode']?></td>
                    <td class="text-left" style="width:10%"><?=$aValue['rtPdtName']?></td>
                    <td style="width:5%"><?=$tSeq?></td>
                    <td class="text-left" style="width:5%"><?=$aValue['rtBarCode']?></td>
                    <td><?=$aValue['rtPunName']?></td>
                    <td><?=$aValue['rtPlcName']?></td>
                    <td><img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" onClick="JSoPdtLocSeqDel('<?=$nCurrentPage?>','<?=$aValue['rtPdtName']?>','<?=$aValue['rtBarCode']?>','<?=$FTPlcCode?>')"></td>
                </tr>
            <?php } ?>

        <?php else: ?>
            <tr class="xCNTextDetail"><td class='text-center' colspan='99'>ไม่พบรายการ</td></tr>
        <?php endif; ?>
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aLocSeqData['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aLocSeqData['rnCurrentPage']?> / <?=$aLocSeqData['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtLocSeq btn-toolbar pull-right"> 
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtLocSeqClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aLocSeqData['rnAllPage'],$nPage+2)); $i++){?>
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                
                <button onclick="JSvPdtLocSeqClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aLocSeqData['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtLocSeqClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>


<div class="modal fade" id="odvModalDelPdtLocSeq">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
				<!-- <input type='hidden' id="ohdConfirmPlcCodeDelete"> -->
                <input type='hidden' id="ohdConfirmBarCodeDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoPdtLocSeqDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
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
		var tDataCode = $('#otrPdtLocSeq'+$i).data('code')
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
			var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nBar',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
	}

	$('.ocbListItem').click(function(){
        var nPlc = $(this).parent().parent().parent().data('plc');  //code
        var nBar = $(this).parent().parent().parent().data('bar');  //code
        var tName = $(this).parent().parent().parent().data('name');  //code
        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"nBar": nBar,"nPlc": nPlc, "tName": tName });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxTextinModalSeq();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'nBar',nBar);
            if(aReturnRepeat == 'None' ){           //ยังไม่ถูกเลือก
                obj.push({"nBar": nBar,"nPlc": nPlc, "tName": tName });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxTextinModalSeq();
            }else if(aReturnRepeat == 'Dupilcate'){	//เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].nBar == nBar){
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
                JSxTextinModalSeq();
            }
        }
        JSxShowButtonChoose();
    })
});
</script>