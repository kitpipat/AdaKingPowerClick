<style>
    .xCNBTNPrimeryDisChgPlus{
        border-radius           : 50%;
        float                   : left;
        width                   : 20px;
        height                  : 20px;
        line-height             : 20px;
        background-color        : #1eb32a;
        text-align              : center;
        margin-top              : 6px;
        font-size               : 22px;
        color                   : #ffffff;
        cursor                  : pointer;
        -webkit-border-radius   : 50%;
        -moz-border-radius      : 50%;
        -ms-border-radius       : 50%;
        -o-border-radius        : 50%;
    }
</style>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?=$tTWIPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?=$tTWIPunCode;?>">
        
        <table id="otbTWIDocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <?php if((@$tTWIStaApv == '') && @$tTWIStaDoc != 3) { ?>
                        <th><?=language('document/purchaseinvoice/purchaseinvoice','tPITBChoose')?></th>
                    <?php } ?>
                    <th><?=language('document/purchaseinvoice/purchaseinvoice','tPITBNo')?></th>
                    <?php foreach($aColumnShow as $HeaderColKey => $HeaderColVal):?>
                        <th nowrap title="<?=iconv_substr($HeaderColVal->FTShwNameUsr, 0,30,"UTF-8");?>">
                            <?=iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                        </th>
                    <?php endforeach;?>
                    <?php if((@$tTWIStaApv == '') && @$tTWIStaDoc != 3) { ?>
                        <th class="xCNTWIBeHideMQSS"><?=language('document/purchaseinvoice/purchaseinvoice', 'tPITBDelete');?></th>
                        <th class="xCNTWIBeHideMQSS xWTWIDeleteBtnEditButtonPdt"><?php echo language('document/saleorder/saleorder','tSOTBEdit');?></th>
                    <?php } ?>
                </tr>
            </thead>
            <tbody id="odvTBodyTWIPdtAdvTableList">
                <?php $nNumSeq  = 0;?>
                <?php if($aDataDocDTTemp['rtCode'] == 1):?>
                    <?php foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): ?>
                        <tr
                            class="text-center xCNTextDetail2 nItem<?=$nNumSeq?> xWPdtItem"
                            data-index="<?=$aDataTableVal['rtRowID'];?>"
                            data-docno="<?=$aDataTableVal['FTXthDocNo'];?>"
                            data-seqno="<?=$aDataTableVal['FNXtdSeqNo']?>"
                            data-pdtcode="<?=$aDataTableVal['FTPdtCode'];?>" 
                            data-pdtname="<?=$aDataTableVal['FTXtdPdtName'];?>"
                            data-puncode="<?=$aDataTableVal['FTPunCode'];?>"
                            data-qty="<?=$aDataTableVal['FCXtdQty'];?>"
                            data-setprice="<?=$aDataTableVal['FCXtdSetPrice'];?>"
                            data-stadis="<?=$aDataTableVal['FTXtdStaAlwDis']?>"
                            data-netafhd="<?=$aDataTableVal['FCXtdNetAfHD'];?>"
                        >   
                            <?php if((@$tTWIStaApv == '') && @$tTWIStaDoc != 3) { ?>
                                <td class="text-center">
                                    <label class="fancy-checkbox">
                                        <input id="ocbListItem<?=$aDataTableVal['rtRowID']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                        <span></span>
                                    </label>
                                </td>
                            <?php } ?>
                            <td><label><?=$aDataTableVal['rtRowID']?></label></td>
                            <?php foreach($aColumnShow as $DataKey => $DataVal): ?>
                            <?php
                                $tColumnName        = $DataVal->FTShwFedShw;
                                $nColWidth          = $DataVal->FNShwColWidth;
                                $tColumnDataType    = substr($tColumnName, 0, 2);
                                if($tColumnDataType == 'FC'){
                                    $tMaxlength     = '11';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                    $InputType      = 'text';
                                    $tValidateType  = 'xCNInputNumericWithDecimal';
                                }
                                if($tColumnDataType == 'FN'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                    $InputType      = 'number';
                                    $tValidateType  = '';
                                }
                                if($tColumnDataType == 'FD'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = date('Y-m-d H:i:s');
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                                if($tColumnDataType == 'FT'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = $aDataTableVal[$tColumnName];
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                            ?>
                                <td nowrap class="<?=$tAlignFormat?>">
                                    <?php if($DataVal->FTShwStaAlwEdit == 1 && in_array($tColumnName, ['FCXtdSetPrice','FCXtdQty']) && (empty($tTWIStaApv) && $tTWIStaDoc != 3)):?>
                                            <label 
                                                data-field="<?=$tColumnName?>"
                                                data-seq="<?= $aDataTableVal['FNXtdSeqNo']?>"
                                                data-demo="TextDEmo"
                                                class="xCNPdtFont xWShowInLine<?=$aDataTableVal['rtRowID']?> xWShowValue<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>"
                                            >
                                                <?=$tDataCol != '' ? "".$tDataCol : '1'; ?>
                                            </label>
                                            <div class="xCNHide xWEditInLine<?=$aDataTableVal['FNXtdSeqNo']?>">
                                                <input 
                                                    type="<?=$InputType?>" 
                                                    class="form-control xCNPdtEditInLine xWValueEditInLine<?=$aDataTableVal['rtRowID']?> <?=$tValidateType?> <?=$tAlignFormat;?>"
                                                    id="ohd<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>" 
                                                    name="ohd<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>" 
                                                    maxlength="<?=$tMaxlength?>" 
                                                    value="<?=$tDataCol;?>"
                                                    <?=$tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?=$tColumnName == 'FCXtdQty'; ?>>
                                            </div>       
                                    <?php else: ?>
                                        <label class="xCNPdtFont xWShowInLine xWShowValue<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>"><?=$tDataCol?></label>
                                    <?php endif;?>                  
                                </td>
                            <?php endforeach; ?>
                            <?php if((@$tTWIStaApv == '') && @$tTWIStaDoc != 3){ ?>
                                <td nowrap class="text-center xCNTWIBeHideMQSS">
                                    <label class="xCNTextLink">
                                        <img class="xCNIconTable" src="<?= base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnTWIDelPdtInDTTempSingle(this)">
                                    </label>
                                </td>
                            <?php } ?>
                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td class="text-center xCNTextDetail2 xWTWITextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<?php if($aDataDocDTTemp['rnAllPage'] > 1) : ?>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataDocDTTemp['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataDocDTTemp['rnCurrentPage']?> / <?php echo $aDataDocDTTemp['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTWIPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTWIPDTDocDTTempClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
                <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
            </button>
            <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataDocDTTemp['rnAllPage'],$nPage+2)); $i++){?> 
                <?php 
                    if($nPage == $i){ 
                        $tActive = 'active'; 
                        $tDisPageNumber = 'disabled';
                    }else{ 
                        $tActive = '';
                        $tDisPageNumber = '';
                    }
                ?>
                <button onclick="JSvTWIPDTDocDTTempClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDocDTTemp['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTWIPDTDocDTTempClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
<?php endif;?>

<!-- ============================================ Modal Confirm Delete Documet Detail Dis ============================================ -->
    <div id="odvPIModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('common/main/main', 'tPIMsgNotificationChangeData') ?></label>
                </div>
                <div class="modal-body">
                    <label><?php echo language('document/purchaseinvoice/purchaseinvoice','tPIMsgTextNotificationChangeData');?></label>
                </div>
                <div class="modal-footer">
                    <button id="obtPIConfirmDeleteDTDis" type="button"  class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtPICancelDeleteDTDis" type="button" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ================================================================================================================================= -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<script>
    //ลบสินค้าใน Tmp - หลายตัว
    $('#otbTWIDocPdtAdvTableList #odvTBodyTWIPdtAdvTableList .ocbListItem').unbind().click(function(){
        var tTWIDocNo    = $('#oetTWIDocNo').val();
        var tTWISeqNo    = $(this).parents('.xWPdtItem').data('seqno');
        var tTWIPdtCode  = $(this).parents('.xWPdtItem').data('pdtcode');
        var tTWIPunCode  = $(this).parents('.xWPdtItem').data('puncode');
        $(this).prop('checked', true);
        let oLocalItemDTTemp    = localStorage.getItem("TWI_LocalItemDataDelDtTemp");
        let oDataObj            = [];
        if(oLocalItemDTTemp){
            oDataObj    = JSON.parse(oLocalItemDTTemp);
        }
        let aArrayConvert   = [JSON.parse(localStorage.getItem("TWI_LocalItemDataDelDtTemp"))];
        if(aArrayConvert == '' || aArrayConvert == null){
            oDataObj.push({
                'tDocNo'    : tTWIDocNo,
                'tSeqNo'    : tTWISeqNo,
                'tPdtCode'  : tTWIPdtCode,
                'tPunCode'  : tTWIPunCode,
            });
            localStorage.setItem("TWI_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
            JSxTWITextInModalDelPdtDtTemp();
        }else{
            var aReturnRepeat   = JStTWIFindObjectByKey(aArrayConvert[0],'tSeqNo',tTWISeqNo);
            if(aReturnRepeat == 'None' ){
                //ยังไม่ถูกเลือก
                oDataObj.push({
                    'tDocNo'    : tTWIDocNo,
                    'tSeqNo'    : tTWISeqNo,
                    'tPdtCode'  : tTWIPdtCode,
                    'tPunCode'  : tTWIPunCode,
                });
                localStorage.setItem("TWI_LocalItemDataDelDtTemp",JSON.stringify(oDataObj));
                JSxTWITextInModalDelPdtDtTemp();
            }else if(aReturnRepeat == 'Dupilcate'){
                localStorage.removeItem("TWI_LocalItemDataDelDtTemp");
                $(this).prop('checked', false);
                var nLength = aArrayConvert[0].length;
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i].tSeqNo == tTWISeqNo){
                        delete aArrayConvert[0][$i];
                    }
                }
                var aNewarraydata   = [];
                for($i=0; $i<nLength; $i++){
                    if(aArrayConvert[0][$i] != undefined){
                        aNewarraydata.push(aArrayConvert[0][$i]);
                    }
                }
                localStorage.setItem("TWI_LocalItemDataDelDtTemp",JSON.stringify(aNewarraydata));
                JSxTWITextInModalDelPdtDtTemp();
            }
        }
        JSxTWIShowButtonDelMutiDtTemp();
    });
    
    $(document).ready(function(){
        if((tTWIStaDoc == 3) || (tTWIStaApvDoc == 1 && tTWIStaPrcStkDoc == 1)){
                $('#otbTWIDocPdtAdvTableList .xCNPIBeHideMQSS').hide();
        }else{
            var oParameterEditInLine    = {
                "DocModules"                    : "",
                "FunctionName"                  : "JSxTWISaveEditInline",
                "DataAttribute"                 : ['data-field', 'data-seq'],
                "TableID"                       : "otbTWIDocPdtAdvTableList",
                "NotFoundDataRowClass"          : "xWTWITextNotfoundDataPdtTable",
                "EditInLineButtonDeleteClass"   : "xWTWIDeleteBtnEditButtonPdt",
                "LabelShowDataClass"            : "xWShowInLine",
                "DivHiddenDataEditClass"        : "xWEditInLine"
            }
            JCNxSetNewEditInline(oParameterEditInLine);

            $(".xWEditInlineElement").eq(nIndexInputEditInline).focus();
            $(".xWEditInlineElement").eq(nIndexInputEditInline).select();
            $(".xWEditInlineElement").removeAttr("disabled");

            let oElement = $(".xWEditInlineElement");
            for(let nI=0;nI<oElement.length;nI++){
                $(oElement.eq(nI)).val($(oElement.eq(nI)).val().trim());
            }
        }
    });
</script>