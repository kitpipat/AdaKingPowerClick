<style>
    .xCNBTNPrimeryDisChgPlus {
        border-radius: 50%;
        float: left;
        width: 20px;
        height: 20px;
        line-height: 20px;
        background-color: #1eb32a;
        text-align: center;
        margin-top: 6px;
        /* margin-right: -15px; */
        font-size: 22px;
        color: #ffffff;
        cursor: pointer;
        -webkit-border-radius: 50%;
        -moz-border-radius: 50%;
        -ms-border-radius: 50%;
        -o-border-radius: 50%;
    }
</style>
<div class="table-responsive">
    <table class="table table-striped xWPdtTableFont" id="otbCreditNoteDOCPdtTable">
        <thead>
            <tr class="xCNCenter">
            <th><?= language('document/purchaseorder/purchaseorder', 'tPOTBChoose')?></th>
                <th><?= language('document/purchaseorder/purchaseorder', 'tPOTBNo')?></th>
                <?php foreach($aColumnShow as $HeaderColKey => $HeaderColVal) { ?>
                    <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>">
                        <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                    </th>
                <?php } ?>
                <?php if(empty($tStaApv) && $tStaDoc != 3){?>
                    <th><?= language('document/purchaseorder/purchaseorder', 'tPOTBDelete')?></th>
                    <th class="xWCreditNoteDeleteBtnEditButtonPdt"><?= language('document/purchaseorder/purchaseorder', 'tPOTBEdit')?></th>
                <?php }else { ?>
                    <th></th>
                <?php } ?>
            </tr>
        </thead>
        <tbody id="odvTBodyCreditNotePdt">
        <input type="hidden" id="ohdCreditNoteTempRows" value="<?php echo count(isset($aDataDT['raItems'])?$aDataDT['raItems']:[]); ?>">
        
        <?php $nNumSeq = 0;?>
        <?php if($aDataDT['rtCode'] == 1) { ?>
              
            <?php foreach($aDataDT['raItems'] as $DataTableKey => $aDataTableVal){?>
                <tr 
                    class="text-center xCNTextDetail2 nItem<?=$nNumSeq?> xWPdtItem"  
                    data-index="<?=$aDataTableVal['rtRowID']?>" 
                    data-docno="<?=$aDataTableVal['FTXthDocNo']?>" 
                    data-pdtname="<?=$aDataTableVal['FTXtdPdtName']?>" 
                    data-pdtcode="<?=$aDataTableVal['FTPdtCode']?>" 
                    data-puncode="<?=$aDataTableVal['FTPunCode']?>" 
                    data-net="<?=$aDataTableVal['FCXtdNet']?>"
                    data-set-price="<?=$aDataTableVal['FCXtdSetPrice']?>"
                    data-qty="<?=$aDataTableVal['FCXtdQty']?>"
                    data-stadis="<?=$aDataTableVal['FTXtdStaAlwDis']?>"
                    data-seqno="<?=$aDataTableVal['FNXtdSeqNo']?>">
                    <td class="text-center">
                        <label class="fancy-checkbox">
                            <input id="ocbListItem<?=$aDataTableVal['rtRowID']?>" type="checkbox" class="ocbListPdtItem" name="ocbListPdtItem[]">
                            <span></span>
                        </label>
                    </td>
                    <td><label><?=$aDataTableVal['rtRowID']?></label></td>
                    <?php foreach($aColumnShow as $DataKey => $DataVal) {
                        $tColumnName = $DataVal->FTShwFedShw;
                        $nColWidth = $DataVal->FNShwColWidth;

                        $tColumnDataType = substr($tColumnName, 0, 2);

                        if($tColumnDataType == 'FC'){
                            $tMaxlength = '11';
                            $tAlignFormat = 'text-right';
                            $tDataCol =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                            $InputType = 'text';
                            $tValidateType = 'xCNInputNumericWithDecimal xCNInputWithoutSpc';
                        }
                        if($tColumnDataType == 'FN'){
                            $tMaxlength = '';
                            $tAlignFormat = 'text-right';
                            $tDataCol = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                            $InputType = 'number';
                            $tValidateType = '';
                        }
                        if($tColumnDataType == 'FD'){
                            $tMaxlength = '';
                            $tAlignFormat = 'text-left';
                            $tDataCol = date('Y-m-d H:i:s'); // $aDataTableVal[$tColumnName];
                            $InputType = 'text';
                            $tValidateType = '';
                        }
                        if($tColumnDataType == 'FT'){
                            $tMaxlength = '';
                            $tAlignFormat = 'text-left';
                            $tDataCol = $aDataTableVal[$tColumnName];
                            $InputType = 'text';
                            $tValidateType = '';
                        }
                    ?>
                    
                        <td nowrap class="<?=$tAlignFormat?>">
                            <?php if(!$DataVal->FTShwStaAlwEdit == 1 && in_array($tColumnName, ['FCXtdQty', 'FCXtdSetPrice', 'FTXtdDisChgTxt']) && (empty($tStaApv) && $tStaDoc != 3)) :?>
                                <?php if($tColumnName == 'FTXtdDisChgTxt' && $aDataTableVal['FTXtdStaAlwDis'] == '1'):?>
                                    <div class="xWCreditNoteDisChgDTForm">
                                        <button class="xCNBTNPrimeryDisChgPlus" onclick="JCNvCreditNoteDisChagDT(this)" type="button" style="margin-right: 5px;">+</button>
                                        <?php 
                                            if($aDataTableVal['FTXtdDisChgTxt'] != '' || $aDataTableVal['FTXtdDisChgTxt'] != null){ //ถ้ามีส่วนลด
                                                $tTextDisChg    = '';
                                                $aExplode       = explode(",",$aDataTableVal['FTXtdDisChgTxt']);
                                                for($i=0; $i<FCNnHSizeOf($aExplode); $i++){
                                                    if(strpos($aExplode[$i],'%')){
                                                        $tTextDisChg .= $aExplode[$i] . ',';
                                                    }else{
                                                        $tTextDisChg .= number_format($aExplode[$i],2) . ',';
                                                    }

                                                    //ถ้าเป็นตัวท้ายให้ลบ comma ออก
                                                    if($i == FCNnHSizeOf($aExplode) - 1 ){
                                                        $tTextDisChg = substr($tTextDisChg,0,-1);
                                                    }
                                                }
                                            }else{//ไม่มีส่วนลด
                                                $tTextDisChg = '';
                                            }
                                        ?>
                                        <label class="xWCreditNoteDisChgDT" id="olbCreditNoteDisChgDT<?=$aDataTableVal['rtRowID']?>"><?=$tTextDisChg?></label>
                                    </div>
                                <?php else:?>
                                    <label 
                                        data-field="<?=$tColumnName?>"
                                        data-seq="<?=$aDataTableVal['FNXtdSeqNo']?>"
                                        data-demo="TextDEmo"
                                        class="xCNPdtFont xWShowInLine<?=$aDataTableVal['rtRowID']?> xWShowValue<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>"
                                    >
                                    <?php if($tColumnName != 'FTXtdDisChgTxt'){ ?>
                                        <?php echo  $tDataCol != '' ? "".$tDataCol : '1'; ?>
                                        <?php }else {  echo  language('document/saleorder/saleorder','tSODiscountisnotallowed');  } ?>
                                    </label>
                                    <?php if($tColumnName != 'FTXtdDisChgTxt'){ ?>
                                        <div class="xCNHide xWEditInLine<?=$aDataTableVal['FNXtdSeqNo']?>">
                                            <input 
                                                type="<?php echo $InputType?>" 
                                                class="form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aDataTableVal['rtRowID']?> <?php echo $tValidateType?> <?php echo $tAlignFormat;?>"
                                                id="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                name="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                maxlength="<?php echo $tMaxlength?>" 
                                                value="<?php echo $tDataCol;?>"
                                                <?php echo $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?>>
                                        </div>
                                    <?php } ?>  
                                <?php endif;?>
                            <?php else: ?>
                                <label class="xCNPdtFont xWShowInLine xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"><?php echo $tDataCol?></label>
                            <?php endif;?>  
                        </td>
                    <?php } ?>
                          
                <?php if(empty($tStaApv) && $tStaDoc != 3){?>
                    <td nowrap class="text-center">
                        <lable class="xCNTextLink">
                            <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnCrdditNoteRemoveDTRow(this)">
                        </lable>
                    </td>    
                    <td></td>
                <?php }else { ?>
                    <td></td>
                <?php } ?>
            </tr>
                <?php $nNumSeq++; ?>
            <?php } ?>
        <?php }else { ?>
            <tr><td class="text-center xCNTextDetail2 xWCreditNoteTextNotfoundDataPdtTable" colspan="100%"><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
        <?php } ?>
        
        </tbody>
    </table>
</div>

<?php if($aDataDT['rnAllPage'] > 1) : ?>
    <div class="row">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataDT['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataDT['rnCurrentPage']?> / <?=$aDataDT['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPageCreditNotePdt btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvCreditNotePdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
                    <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
                </button>
                <?php for($i=max($nPage-2, 1); $i<=max(0, min($aDataDT['rnAllPage'],$nPage+2)); $i++){?> 
                    <?php 
                        if($nPage == $i){ 
                            $tActive = 'active'; 
                            $tDisPageNumber = 'disabled';
                        }else{ 
                            $tActive = '';
                            $tDisPageNumber = '';
                        }
                    ?>
                    <button onclick="JSvCreditNotePdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvCreditNotePdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

<!-- Modal -->
<div class="modal fade" id="odvShowOrderColumn" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <label class="xCNTextModalHeard" id="exampleModalLabel"><?= language('common/main/main', 'tModalAdvTable') ?></label>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body" id="odvOderDetailShowColumn">
                ...
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal"><?= language('common/main/main', 'tModalAdvClose') ?></button>
                <button type="button" class="btn btn-primary" onclick="JSxSaveColumnShow()"><?= language('common/main/main', 'tModalAdvSave') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Items -->
<div class="modal fade" id="odvModalDelPdtCreditNote">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span id="ospConfirmDelete"> - </span>
                <input type='hidden' id="ohdConfirmSeqDelete">
                <input type='hidden' id="ohdConfirmPdtDelete">
                <input type='hidden' id="ohdConfirmPunDelete">
                <input type='hidden' id="ohdConfirmDocDelete">
            </div>
            <div class="modal-footer">
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoCreditNotePdtDelChoose('<?= @$nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Confirm Delete DTDis -->
<div class="modal fade" id="odvModalConfirmDeleteDTDis" style="z-index: 7000;">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIMsgNotificationChangeData') ?></label>
            </div>
            <div class="modal-body">
                <label><?= language('document/purchaseinvoice/purchaseinvoice', 'tPIMsgTextNotificationChangeData') ?></label>
            </div>
            <div class="modal-footer">
                <button id="obtCreditNoteConfirmDeleteDTDis" type="button" class="btn xCNBTNPrimery"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button id="obtCreditNoteCancelDeleteDTDis" type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<?php  include("script/jCreditNotePdtAdvTableData.php");?>











































































































































