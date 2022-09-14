<style>
    .table>tbody>tr>td.text-danger{
        color: #F9354C !important;
    }
</style>
<?php 
    if($aPdtPriDataList['rtCode'] == '1'){
        $nCurrentPage = $aPdtPriDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>

<!-- <div class="row">
    <div class="col-md-12">
        <div class="text-right"><label onclick="JSxOpenColumnFormSet()" style="cursor:pointer"><?= language('common/main/main','tModalAdvTable')?></label></div>
    </div>
</div> -->

<?php 
    $tImportStatus = "1";
    if( $aPdtPriDataList['rtCode'] == 1 ){
        foreach($aPdtPriDataList['raItems'] as $DataTableKey => $DataTableVal){
            if( $DataTableVal['FTTmpStatus'] != '1' ){
                $tImportStatus = $DataTableVal['FTTmpStatus'];
            }
        }
    }
?>

<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table id="otbSpaDataList" class="table table-striped" style="margin-bottom: 0px;">
                <thead>
                    <tr>
                    <th><?= language('document/salepriceadj/salepriceadj','tPdtPriTBChoose')?></th>
                    <?php foreach($aColumnShow as $HeaderColKey=>$HeaderColVal){?>
                        <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>">
                            <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                        </th>
                    <?php }?>
                    <!-- <th><?php echo language('document/salepriceadj/salepriceadj','tPdtPriTBChoose'); ?></th> -->
                    <?php if(@$tXphStaApv != 1 && @$tXphStaDoc != 3){?>
                        <?php if( $tImportStatus != "1" ){ ?>
                            <th><?= language('document/salepriceadj/salepriceadj','หมายเหตุ')?></th>
                        <?php } ?>
                        <th class="xWDeleteBtnEditButton"><?= language('document/salepriceadj/salepriceadj','tPdtPriTBEdit')?></th>
                    <?php } ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aPdtPriDataList['rtCode'] == 1 ):?>
                        <?php $nIndex = 1; ?>
                        <?php foreach($aPdtPriDataList['raItems'] as $DataTableKey => $DataTableVal){ ?>
                            <tr class="text-center xCNTextDetail2 otrSpaPdtPri" 
                            id="otrSpaPdtPri<?=$DataTableVal['FNXtdSeqNo']?>" 
                            name="otrSpaPdtPri" 
                            data-doc="<?=$DataTableVal['FTXthDocNo']?>" 
                            data-code="<?=$DataTableVal['FTPdtCode']?>" 
                            data-pun="<?=$DataTableVal['FTPunCode']?>" 
                            data-seq="<?=$DataTableVal['FNXtdSeqNo']?>"
                            data-status="<?=$DataTableVal['FTTmpStatus']?>"
                            data-rmk="<?=$DataTableVal['FTTmpRemark']?>" 
                            data-page="<?=$nCurrentPage?>">
                                <td nowrap class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$DataTableVal['FNXtdSeqNo']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span class="ospListItem">&nbsp;</span>
                                    </label>
                                    <input type="hidden" id="ohdFTPunCode<?=$DataTableVal['FNXtdSeqNo']?>" name="ohdFTPunCode<?=$DataTableVal['FNXtdSeqNo']?>" value="<?=$DataTableVal['FTPunCode']?>">
                                    <input type="hidden" id="ohdFTXpdShpTo<?=$DataTableVal['FNXtdSeqNo']?>" name="ohdFTXpdShpTo<?=$DataTableVal['FNXtdSeqNo']?>" value="<?=$DataTableVal['FTXtdShpTo']?>">
                                    <input type="hidden" id="ohdFTXpdBchTo<?=$DataTableVal['FNXtdSeqNo']?>" name="ohdFTXpdBchTo<?=$DataTableVal['FNXtdSeqNo']?>" value="<?=$DataTableVal['FTXtdBchTo']?>">
                                </td>
                                <?php  
                                    $aDataSeqCollumSumFooter = [];

                                    foreach($aColumnShow as $DataKey=>$DataVal){ 

                                        $tColumnName = $DataVal->FTShwFedShw;
                                        $nColWidth   = $DataVal->FNShwColWidth;

                                        if($tColumnName=='FCXtdPriceNet'){
                                            $aDataSeqCollumSumFooter[] = $tColumnName;
                                        }

                                        if($tColumnName=='FCXtdPriceRet'){
                                            $aDataSeqCollumSumFooter[] = $tColumnName;
                                        }

                                        if($tColumnName=='FCXtdPriceWhs'){
                                            $aDataSeqCollumSumFooter[] = $tColumnName;
                                        }

                                        $tColumnDataType = substr($tColumnName,0,2);

                                        if($tColumnDataType == 'FC'){
                                            $tMaxlength = '11';
                                            $tAlignFormat = 'text-right';
                                            $tDataCol =  $DataTableVal[$tColumnName] != '' ? number_format($DataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                            $InputType = 'text';
                                            $tValidateType = 'xCNInputNumericWithDecimal';
                                        }elseif($tColumnDataType == 'FN'){
                                            $tMaxlength = '';
                                            $tAlignFormat = 'text-right';
                                            $tDataCol = $DataTableVal[$tColumnName] != '' ? number_format($DataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                            $InputType = 'number';
                                            $tValidateType = '';
                                        }else{
                                            $tMaxlength = '';
                                            $tAlignFormat = 'text-left';
                                            $tDataCol = $DataTableVal[$tColumnName];
                                            $InputType = 'text';
                                            $tValidateType = '';
                                        }

                                        $tFieldCol = "";

                                        switch($tColumnName){
                                            case 'FNXtdSeqNo': {
                                                $tAlignFormat = 'text-center';
                                                $tDataCol = $DataTableVal[$tColumnName];
                                                break;
                                            }
                                            case 'FTDefalutPrice': {
                                                $tDataCol = "<label id='olaOriginalPrice".$DataTableVal['FNXtdSeqNo']."' class='xWOriginalPriceClick xCNLinkClick' data-seq='".$DataTableVal['FNXtdSeqNo']."' style='cursor:pointer'>".language('document/salepriceadj/salepriceadj', 'tPdtPriTBPriceOgn')."</label>";
                                                break;
                                            }
                                            case 'FTPdtCode': {
                                                if(in_array($DataTableVal['FTTmpStatus'], ["3","4"]) && explode("$&", $DataTableVal['FTTmpRemark'])[0] == "[0]"){
                                                    $tFieldCol = "[0]";
                                                    $tDataCol = explode("$&", $DataTableVal['FTTmpRemark'])[2];
                                                }
                                                break;
                                            }
                                            case 'FCXtdPriceRet': {
                                                if(in_array($DataTableVal['FTTmpStatus'], ["3","4"]) && explode("$&", $DataTableVal['FTTmpRemark'])[0] == "[2]"){
                                                    $tDataCol = explode("$&", $DataTableVal['FTTmpRemark'])[2];
                                                    $tFieldCol = "[3]";
                                                }
                                                break;
                                            }
                                        }

                                ?>

                                <td nowrap class="<?=$tAlignFormat?>">
                                    <?php if($DataVal->FTShwStaAlwEdit == 1){ ?>
                                            <!-- <label
                                                dataSEQ = '<?=$DataTableVal['FNXtdSeqNo']?>' 
                                                dataPRICE = '<?=$tColumnName?>'
                                                dataPAGE = "<?=$aPdtPriDataList['rnCurrentPage']?>";
                                                class = "xCNPdtFont xWShowInLine<?=$DataTableVal['FNXtdSeqNo']?> xWShowValue<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>"
                                            >
                                            <?=$tDataCol?>
                                            </label> -->

                                            <input type="hidden" 
                                            name="ohdSPAFrtPdtCode" 
                                            id="ohdSPAFrtPdtCode<?=$DataTableVal['FTPdtCode']?><?=$DataTableVal['FTPunCode']?>"
                                            value="ohd<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>">

                                            <div class=" xWEditInLine<?=$DataTableVal['FNXtdSeqNo']?>">
                                                <input 
                                                    style="    
                                                        background: rgb(249, 249, 249);
                                                        box-shadow: 0px 0px 0px inset;
                                                        border-top: 0px !important;
                                                        border-left: 0px !important;
                                                        border-right: 0px !important;
                                                        padding: 0px;
                                                        text-align: right;
                                                    "
                                                    type="<?=$InputType?>" 
                                                    class="form-control xStaDocEdit xWValueEditInLine<?=$DataTableVal['FNXtdSeqNo']?> <?=$tValidateType?> <?=$tAlignFormat;?>"
                                                    id="ohd<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>" 
                                                    name="ohd<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>" 
                                                    maxlength="<?=$tMaxlength?>" 
                                                    value="<?=$tDataCol?>"
                                                    autocomplete="off"
                                                    seq="<?=$DataTableVal['FNXtdSeqNo']?>"
                                                    columname="<?=$tColumnName?>"
                                                    col-validate="<?php echo $tFieldCol; ?>"
                                                    page="<?=$nPage?>"
                                                    b4value="<?=$tDataCol?>"
                                                    onkeypress=" if(event.keyCode==13 ){     event.preventDefault(); return JSxSpaSaveInLine(event,this); } "
                                                    onfocusout="JSxSpaSaveInLine(event,this)"
                                                    onclick="JSxSPASetValueCommaOut(this)"
                                                >
                                            </div>
                                    <?php }else{   ?>
                                        <label 
                                        class="xCNPdtFont xWShowInLine xWShowValue<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>" 
                                        id="ohd<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>" ><?=$tDataCol?></label>
                                        <!-- <label class="xCNPdtFont xWShowValue<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>"><?=$tDataCol?></label>
                                        <input type="<?=$InputType?>" class="xCNHide xWValueEditInLine<?=$DataTableVal['FNXtdSeqNo']?>" id="ohd<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>" name="ohd<?=$tColumnName?><?=$DataTableVal['FNXtdSeqNo']?>" value="<?=$tDataCol?>" data-field="<?=$tColumnName?>"> -->
                                    <?php } ?>
                                </td>

                            <?php } ?>
                            
                            <?php if( $tImportStatus != "1" ){ ?>
                                <td nowrap class="xCNAdjPriceStaRmk text-left text-danger">
                                    <?php 
                                        if(in_array($DataTableVal['FTTmpStatus'], ["3","4","7"])){
                                            echo explode("$&", $DataTableVal['FTTmpRemark'])[1];
                                        }else{
                                            echo $DataTableVal['FTTmpRemark'];
                                        }
                                    ?>
                                </td>
                            <?php } ?>
                                
                            <?php if(@$tXphStaApv != 1 && @$tXphStaDoc != 3){?>
                            
                                <td nowrap class="text-center xWInLine">
                                <label class="xCNTextLink xWLabelInLine">
                                    <img class="xCNIconTable xCNDeleteInLineClick" data-seq="<?=$DataTableVal['FNXtdSeqNo']?>" src="<?=base_url().'/application/modules/common/assets/images/icons/delete.png'?>" title="Remove">
                                </label>
                                </td>
                                <!-- <td nowrap class="text-center xWInLine">
                                <label class="xCNTextLink xWLabelInLine">
                                    <img id="oimSpaPdtPriEdit xWDeleteBtnEditButton" data-seq="<?=$DataTableVal['FNXtdSeqNo']?>" class="xWShowIconEditInLine<?=$DataTableVal['FNXtdSeqNo']?> xCNIconTable xCNEditInLineClick" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>">
                                    <img id="oimSpaPdtPriSave xWDeleteBtnEditButton" data-seq="<?=$DataTableVal['FNXtdSeqNo']?>" class="xWShowIconSaveInLine<?=$DataTableVal['FNXtdSeqNo']?> xCNIconTable xCNSaveInLineClick xCNHide" src="<?=base_url().'/application/modules/common/assets/images/icons/save.png'?>">
                                    <img id="oimSpaPdtPriCancel xWDeleteBtnEditButton" data-seq="<?=$DataTableVal['FNXtdSeqNo']?>" class="xWShowIconCancelInLine<?=$DataTableVal['FNXtdSeqNo']?> xCNIconTable xCNCancelInLineClick xCNHide" src="<?=base_url().'/application/modules/common/assets/images/icons/reply_new.png'?>">
                                </label>
                                </td> -->
                            <?php } ?>
                            </tr>
                            <?php $nIndex++ ?>
                        <?php } ?>
                 
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2 xWTextNotfoundDataSalePriceAdj' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>

        </div>
    </div>
</div>

<div class="row" style="margin-top:10px;">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aPdtPriDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aPdtPriDataList['rnCurrentPage']?> / <?=$aPdtPriDataList['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPagePdtPri btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPdtPriClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aPdtPriDataList['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                 
                <button onclick="JSvPdtPriClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aPdtPriDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPdtPriClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Items -->
<div class="modal fade" id="odvModalDelSpaPdtPri">
	<div class="modal-dialog">
		<div class="modal-content">
			<div class="modal-header xCNModalHead">
				<label class="xCNTextModalHeard"><?=language('common/main/main', 'tModalDelete')?></label>
			</div>
			<div class="modal-body">
				<span id="ospConfirmDelete"> - </span>
                <input type='hidden' id="ohdConfirmSeqDelete">
				<input type='hidden' id="ohdConfirmPdtDelete">
                <input type='hidden' id="ohdConfirmPunDelete">
                <input type='hidden' id="ohdConfirmDocDelete">
			</div>
			<div class="modal-footer">
				<button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoSpaPdtPriDelChoose('<?=$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
        		<button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!-- Modal Show Original Price -->
<div class="modal fade" id="odvModalOriginalPrice" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="xCNTextModalHeard" id="exampleModalLabel"><?= language('document/salepriceadj/salepriceadj','tPdtPriTiTleOrnPri')?></label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="odvDetailOriginalPrice">
        ...
      </div>
    </div>
  </div>
</div>

<!-- Modal Show Column -->
<div class="modal fade" id="odvShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <label class="xCNTextModalHeard" id="exampleModalLabel"><?= language('common/main/main','tModalAdvTable')?></label>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body" id="odvOderDetailShowColumn">
        ...
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= language('common/main/main','tModalAdvClose')?></button>
        <button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?= language('common/main/main','tModalAdvSave')?></button>
      </div>
    </div>
  </div>
</div>

<script type="text/javascript">
$('.xCNDeleteInLineClick').off('click');
$('.xCNDeleteInLineClick').on('click',function(){
    var nSeq  = $(this).data('seq');
    var nPage = $('#otrSpaPdtPri'+nSeq).data('page');
    var tDoc  = $('#otrSpaPdtPri'+nSeq).data('doc');
    var tPdt  = $('#otrSpaPdtPri'+nSeq).data('code');
    var tPun  = $('#otrSpaPdtPri'+nSeq).data('pun');
    var tSta  = $('#otrSpaPdtPri'+nSeq).data('status');

    JSoSpaPdtPriDel(nPage,tDoc,tPdt,tPun,nSeq,tSta);
});

// $('.xCNEditInLineClick').click(function(){
//     var elem = $(this).data('seq');
//     JSxSpaEditInLine(elem);
// });

// $('.xCNSaveInLineClick').click(function(){
//     var elem = $(this).data('seq');
//     JSxSpaSaveInLine(elem);
// });

// $('.xCNCancelInLineClick').click(function(){
//     var elem = $(this).data('seq');
//     JSxSpaCancelInLine(elem);
// });

if($('#ohdXphStaApv').val()==1){
        $('.xStaDocEdit').prop('disabled',true);
    }

function JSxSPASetValueCommaOut(e){

    var tValueNext     = parseFloat($(e).val().replace(/,/g, ''));
            $(e).val(tValueNext);
            $(e).focus();
            $(e).select();
    
}


$('.xWOriginalPriceClick').click(function(){
    var elem = $(this).data('seq');
    JSxSPAShowOriginalPrice(elem);
});

$('ducument').ready(function(){
    JSxShowButtonChoose();
	var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
	var nlength = $('#odvRGPList').children('tr').length;
	for($i=0; $i < nlength; $i++){
        var tDataCode = $('#otrSpaPdtPri'+$i).data('seq');
		if(aArrayConvert == null || aArrayConvert == ''){
		}else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tDataCode);
			if(aReturnRepeat == 'Dupilcate'){
				$('#ocbListItem'+$i).prop('checked', true);
			}else{ }
		}
	}

	$('.ocbListItem').click(function(){
        var tSeq = $(this).parent().parent().parent().data('seq'); // Pdt
        var tPdt = $(this).parent().parent().parent().data('code'); // Pdt
        var tDoc = $(this).parent().parent().parent().data('doc'); // Doc
        var tPun = $(this).parent().parent().parent().data('pun'); // Pun
        var tSta = $(this).parent().parent().parent().data('status'); // Pun

        $(this).prop('checked', true);
        var LocalItemData = localStorage.getItem("LocalItemData");
        var obj = [];
        if(LocalItemData){
            obj = JSON.parse(LocalItemData);
        }else{ }
        var aArrayConvert = [JSON.parse(localStorage.getItem("LocalItemData"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            obj.push({"tSeq": tSeq, "tPdt": tPdt, "tDoc": tDoc, "tPun": tPun, "tSta" : tSta });
            localStorage.setItem("LocalItemData",JSON.stringify(obj));
            JSxSpaPdtPriTextinModal();
        }else{
            var aReturnRepeat = findObjectByKey(aArrayConvert[0],'tSeq',tSeq);
            if(aReturnRepeat == 'None' ){ // ยังไม่ถูกเลือก
                obj.push({"tSeq": tSeq, "tPdt": tPdt, "tDoc": tDoc, "tPun": tPun, "tSta" : tSta });
                localStorage.setItem("LocalItemData",JSON.stringify(obj));
                JSxSpaPdtPriTextinModal();
            }else if(aReturnRepeat == 'Dupilcate'){	// เคยเลือกไว้แล้ว
                localStorage.removeItem("LocalItemData");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeq == tSeq){
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
                JSxSpaPdtPriTextinModal();
            }
        }
        JSxShowButtonChoose();
    })
});
</script>