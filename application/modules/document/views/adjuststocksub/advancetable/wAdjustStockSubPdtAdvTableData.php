<style>
.xWTableFixedRow {
    position:sticky;
    right:0px;
    background-color: #fff;
}
</style>


<div class="table-responsive">
    <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
    <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">

    <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tPdtCode?>">
    <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tPunCode?>">
      
    <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable"> <!-- table-striped -->
        <thead>
            <tr class="xCNCenter">
                <th class="xWASTRemoveOnApv"><?= language('document/purchaseorder/purchaseorder','tPOTBChoose')?></th>
                <th>ลำดับ</th>
                <?php foreach($aColumnShow as $HeaderColKey => $HeaderColVal){?>
                    <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>" 
                        <?php if($HeaderColVal->FTShwStaAlwEdit == 1){ echo ' class="xWTableFixedRow" '; echo ' style="right:'.$HeaderColVal->FNDiffTableFixed.'px" '; } ?>
                        <?php if($HeaderColVal->FNShwColWidth > 0){ echo ' width="'.$HeaderColVal->FNShwColWidth.'" '; }?>
                    >
                        <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                    </th>
                <?php }?>
                <th class="xWASTRemoveOnApv"><?= language('document/purchaseorder/purchaseorder','tPOTBDelete')?></th>
            </tr>
        </thead>
        <tbody id="odvTBodyAdjStkSubPdt">
        <?php $nNumSeq = 0; ?>
        <?php if($aDataDT['rtCode'] == 1){ ?>
              
            <?php foreach($aDataDT['raItems'] as $DataTableKey => $aDataTableVal){?>
                <tr 
                    class="text-center xCNTextDetail2 nItem<?=$nNumSeq?> xWPdtItem xWPdtItemSeq<?=$aDataTableVal['FNXtdSeqNo']?>"
                    data-index="<?=$DataTableKey?>" 
                    data-docno="<?=$aDataTableVal['FTXthDocNo']?>" 
                    data-pdtname="<?=$aDataTableVal['FTXtdPdtName']?>" 
                    data-pdtcode="<?=$aDataTableVal['FTPdtCode']?>" 
                    data-puncode="<?=$aDataTableVal['FTPunCode']?>" 
                    data-seqno="<?=$aDataTableVal['FNXtdSeqNo']?>">
                  <td class="text-center xWASTRemoveOnApv">
                      <label class="fancy-checkbox">
                          <input id="ocbListItem<?=$aDataTableVal['FNXtdSeqNo']?>" type="checkbox" class="ocbListItem xWASTDisabledOnApv" name="ocbListItem[]">
                          <span></span>
                      </label>
                  </td>
                  <td><?=$aDataTableVal['FNXtdSeqNo']?></td>
                    <?php foreach($aColumnShow as $DataKey => $DataVal){

                        $tColumnName          = $DataVal->FTShwFedShw;
                        $nColWidth            = $DataVal->FNShwColWidth;

                        $tColumnDataType      = substr($tColumnName, 0, 2);
                        $tColumnTypeDateTime  = substr($tColumnName, 9, 4);
                        
                        if($tColumnTypeDateTime == "Date"){
                            $tClassDateTime = "xWDatePickerChange";
                        }else if($tColumnTypeDateTime == "Time"){
                            $tClassDateTime = "xWTimepicker";
                        }else{
                            $tClassDateTime = "xCNPdtEditInLine";
                        }

                        if($tColumnDataType == 'FC'){
                            $tMaxlength = '11';
                            $tAlignFormat = 'text-right';
                            $tDataCol =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName],$nOptDecimalShow) : number_format(0);
                            $InputType = 'text';
                            $tValidateType = 'xCNInputNumericWithDecimal';
                        }
                        if($tColumnDataType == 'FN'){
                            $tMaxlength = '';
                            $tAlignFormat = 'text-right';
                            $tDataCol = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName],$nOptDecimalShow) : number_format(0);
                            $InputType = 'number';
                            $tValidateType = '';
                        }
                        if($tColumnDataType == 'FD'){
                            $tMaxlength = '';
                            $tAlignFormat = 'text-left';
                            $tDataCol = date('Y-m-d H:i:s');
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

                        if(isset($DataVal->FTStaFocusEdit) && $DataVal->FTStaFocusEdit == 1){
                            $nStaFocusEdit = "xWASTCanNextFocus";
                        }else{
                            $nStaFocusEdit = "";
                        }

                        if($tColumnName == "FCAjdUnitQtyC2"){
                            if($aDataTableVal["FTAjdUnitDateC2"] == "" || $aDataTableVal["FTAjdUnitTimeC2"] == ""){
                                $tDataCol = "";
                            }
                        }

                    ?>
                          <td nowrap class="<?=$tAlignFormat?> <?php if($DataVal->FTShwStaAlwEdit == 1){ echo "xWTableFixedRow"; } ?>" <?php if($DataVal->FTShwStaAlwEdit == 1){ echo ' style="right:'.$DataVal->FNDiffTableFixed.'px" '; } ?> >
                            <?php if($DataVal->FTShwStaAlwEdit == 1 && ($aDataTableVal['FTTmpStatus']!=5)){ ?>
                                <label style="display:none;" class="xWEditInlineShowOnApv xCNPdtFont xWShowInLine<?=$aDataTableVal['FNXtdSeqNo']?> xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?= $tDataCol != '' ? "".$tDataCol : '-'; ?></label>
                                <div class="xWEditInLine<?=$aDataTableVal['FNXtdSeqNo']?> xWEditInlineHideOnApv">
                                    <input 
                                        style=" background: rgb(249, 249, 249);
                                                box-shadow: 0px 0px 0px inset;
                                                border-top: 0px !important;
                                                border-left: 0px !important;
                                                border-right: 0px !important;
                                                padding: 0px !important;
                                              "
                                        type="<?=$InputType?>" 
                                        class="form-control xWASTDisabledOnApv <?php echo 'xW'.$tColumnName; ?> <?=$tValidateType?> <?=$nStaFocusEdit;?> <?=$tAlignFormat;?> <?=$tClassDateTime;?>" 
                                        id="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>" 
                                        name="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>" 
                                        value="<?=$tDataCol?>" 
                                        data-field="<?=$tColumnName?>"
                                        autocomplete="off"
                                    >
                                </div>
                            <?php }else{   ?>
                                <?php if($aDataTableVal['FTTmpStatus']!=5){ ?>
                                <label class="xCNPdtFont xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?=$tDataCol?></label>
                                <?php }else{
                                        if($tColumnName=='FCAjdUnitQtyC1' || $tColumnName=='FCAjdUnitQtyC2'){
                                            $tClassName = 'xCNTextLink';
                                            $tIconEdit = " <img class='xCNIconTable' src=".base_url('application/modules/common/assets/images/icons/edit.png')." title='Edit'>";
                                        }else{
                                            $tClassName = 'xCNTextLink';
                                            $tIconEdit = "";
                                        }
                                    ?>
                                    <?php 
                                          if($tColumnName=='FCAjdUnitQtyC2'){
                                            $nSpcControl = 2;
                                            $tNextFunc = 'FSvStkSubAddPdtIntoDocDTTempC2';
                                          }else{
                                            $nSpcControl = 1;
                                            $tNextFunc = 'FSvStkSubAddPdtIntoDocDTTempC1';
                                          }
                                          if($tAjhStaApv=='1' || $tAjhStaDoc=='3'){
                                            $tStaEdit = 2;
                                          }else{
                                            $tStaEdit = 1;
                                          }
                                            $aOptionFashion = array(
                                            'tDocumentBranch'     => $aDataTableVal['FTBchCode'],
                                            'tDocumentNumber'     => $aDataTableVal['FTXthDocNo'],
                                            'tDocumentDocKey'     => 'TCNTPdtAdjStkDT',
                                            'tDocumentProduct'    => $aDataTableVal['FTPdtCode'],
                                            'nDTSeq'              => $aDataTableVal['FNXtdSeqNo'],
                                            'tDTBarCode'          => $aDataTableVal['FTXtdBarCode'],
                                            'tDTPunCode'          => $aDataTableVal['FTPunCode'],
                                            'tNextFunc'           => $tNextFunc,
                                            'tSpcControl'         => $nSpcControl  ,                 //0:จำนวน //1:ตรวจนับครั้งที่หนึ่ง //2:ตรวจนับครั้งที่สอง //3:ตรวจนับย่อย
                                            'tStaEdit'            => $tStaEdit,
                                            );
                                            $aOption = json_encode($aOptionFashion);
                                        ?>
                                    <label class="<?=$tClassName?> xCNPdtFont xWShowInLine xWShowValue<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>" onclick='JSxUpdateProductSerialandFashion(<?=$aOption?>)' ><?=$tDataCol?> <?=$tIconEdit?></label>
                                <?php } ?>
                            <?php } ?>
                          </td>
                    <?php } ?>
                          

                  <td nowrap class="text-center xWASTRemoveOnApv">
                    <lable class="xCNTextLink">
                        <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnRemoveDTRow(this)">
                    </lable>
                  </td>

            </tr>
                <?php $nNumSeq++; ?>
            <?php } ?>
        <?php }else { ?>
            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
        <?php } ?>
        
        </tbody>
    </table>
</div>

<?php if(FCNnHSizeOf($aDataDT['raItems']) > 0){ ?>

    <div class="row">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataDT['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataDT['rnCurrentPage']?> / <?=$aDataDT['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPageAdjStkSubPdt btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button type="button" onclick="JSvAdjStkSubPdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
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
                    <button onclick="JSvAdjStkSubPdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button type="button" onclick="JSvAdjStkSubPdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

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
<div class="modal fade" id="odvModalDelPdtAdjStkSub">
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
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoAdjStkSubPdtDelChoose('<?= @$nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<?php  include("script/jAdjustStockSubPdtAdvTableData.php");?>


























