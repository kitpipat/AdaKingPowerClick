<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
  <div class="table-responsive">
      <table class="table table-striped xWPdtTableFont" id="otbTransferBchOutPdtTable">
          <thead>
              <tr class="xCNCenter">
                  <?php if( ($bIsApvOrCancel === false && $bIsPacking === false) ){?>
                      <th nowrap class="xCNTextBold text-center" style="max-width:50px;">
                          <label class="fancy-checkbox">
                              <input type="checkbox" class="ocmCENCheckDeleteAll" id="ocmCENCheckDeleteAll" >
                              <span class="ospListItem"></span>
                          </label>
                      </th> 
                  <?php } ?>

                  <?php foreach($aColumnShow as $HeaderColKey=>$HeaderColVal) { ?>
                      <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>">
                          <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                      </th>
                  <?php } ?>

                  <?php if( ($bIsApvOrCancel === false && $bIsPacking === false) ){?>
                      <th ><?= language('document/purchaseorder/purchaseorder', 'tPOTBDelete')?></th>
                      <th class="xWCreditNoteDeleteBtnEditButtonPdt"><?= language('document/purchaseorder/purchaseorder', 'tPOTBEdit')?></th>
                  <?php }else { ?>
                      <th></th>
                  <?php } ?>
              </tr>
          </thead>

          <tbody class="xCNTransferBchOutTBodyPdtItem">
              <?php $nNumSeq = 1; ?>
              <?php if($aDataList['rtCode'] == 1) { ?>

                  <?php foreach($aDataList['raItems'] as $DataTableKey=>$aDataTableVal) { ?>
                      <tr
                      class="text-center xCNTextDetail2 nItem<?=$nNumSeq?> xWTransferBchOutPdtItem"
                      data-index="<?=$DataTableKey?>"
                      data-docno="<?=$aDataTableVal['FTXthDocNo']?>"
                      data-pdtname="<?=$aDataTableVal['FTXtdPdtName']?>"
                      data-pdtcode="<?=$aDataTableVal['FTPdtCode']?>"
                      data-puncode="<?=$aDataTableVal['FTPunCode']?>"
                      data-seqno="<?=$aDataTableVal['FNXtdSeqNo']?>">
                          <?php if( ($bIsApvOrCancel === false && $bIsPacking === false) ){?>
                              <td class="text-center">
                                  <label class="fancy-checkbox" style="width: auto;">
                                      <input id="ocbTransferBchOutPdtListItem<?=$aDataTableVal['FNXtdSeqNo']?>" type="checkbox" class="ocbListItem ocbTransferBchOutPdtListItem" name="ocbTransferBchOutPdtListItem[]">
                                      <span></span>
                                  </label>
                              </td>
                          <?php } ?>
                              <?php
                              foreach($aColumnShow as $DataKey => $DataVal) {

                                  $tColumnName = $DataVal->FTShwFedShw;
                                  $nColWidth = $DataVal->FNShwColWidth;

                                  $tColumnDataType = substr($tColumnName,0,2);

                                  if($tColumnDataType == 'FC'){
                                      $tMaxlength = '11';
                                      $tAlignFormat = 'text-right';
                                      $tDataCol =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                      $InputType = 'text';
                                      $tValidateType = 'xCNInputNumericWithDecimal';
                                  }elseif($tColumnDataType == 'FN'){
                                      $tMaxlength = '';
                                      if($tColumnName == "FNXtdSeqNo"){
                                          $tAlignFormat = 'text-center';
                                          $tDataCol = $nNumSeq;
                                      }else{
                                          $tAlignFormat = 'text-right';
                                          $tDataCol = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                          $InputType = 'number';
                                          $tValidateType = '';
                                      }
                                  }else{
                                      $tMaxlength = '';
                                      $tAlignFormat = 'text-left';
                                      $tDataCol = $aDataTableVal[$tColumnName];
                                      $InputType = 'text';
                                      $tValidateType = '';
                                  }
                              ?>

                              <td nowrap class="<?=$tAlignFormat?>">
                                  <?php if( ($DataVal->FTShwStaAlwEdit == 1) && ( ($bIsApvOrCancel === false && $bIsPacking === false) || ($bIsPacked === true) ) && $bAlwEditQty === true ){ ?>
                                      <label
                                      data-field="<?=$tColumnName?>"
                                      data-seq="<?=$aDataTableVal['FNXtdSeqNo']?>"
                                      data-qtyord="<?=$aDataTableVal['FCXtdQtyOrd']?>"
                                      data-qtypick="<?=$aDataTableVal['FCXtdQtyPick']?>"
                                      data-ispack="<?php if( $bIsPacking ){ echo "true"; }else{ echo "false"; } ?>"
                                      class="xCNPdtFont xCNApvOrCanCelDisabledPdt xWShowInLine<?=$aDataTableVal['FNXtdSeqNo']?> xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?= $tDataCol != '' ? "".$tDataCol : '-'; ?>
                                      </label>
                                      <div class="xCNHide xWEditInLine<?=$aDataTableVal['FNXtdSeqNo']?>">
                                          <input
                                          type="<?=$InputType?>"
                                          class="form-control xCNApvOrCanCelDisabledPdt xCNPdtEditInLine xWValueEditInLine<?=$aDataTableVal['FNXtdSeqNo']?> <?=$tValidateType?> xCNInputWithoutSpc xWEditPdtInline"
                                          id="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"
                                          name="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"
                                          maxlength="<?=$tMaxlength?>"
                                          value="<?=$aDataTableVal[$tColumnName]?>"
                                          <?= $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?= $tColumnName  == 'FCXtdQty' ?>>
                                      </div>
                                  <?php }else {   ?>
                                      <label class="xCNPdtFont xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?=$tDataCol?></label>
                                  <?php } ?>
                              </td>

                          <?php } ?>

                          <?php if( ($bIsApvOrCancel === false && $bIsPacking === false) ){?>
                              <td nowrap class="text-center">
                                  <lable class="xCNTextLink">
                                      <img class="xCNIconTable xCNIconDel" src="<?php echo base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove">
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
                      <tr><td class='text-center xCNTextDetail2 xWTransferBchOutTextNotfoundDataPdtTable' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
              <?php } ?>
          </tbody>
      </table>
  </div>
</div>


<?php if($aDataList['rnAllPage'] > 1) { ?>
    <div class="row odvTransferBchOutPdtDataTable">
        <div class="col-md-6">
            <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataList['rnCurrentPage']?> / <?=$aDataList['rnAllPage']?></p>
        </div>
        <div class="col-md-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvTransferBchOutPdtDataTableClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvTransferBchOutPdtDataTableClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>
                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvTransferBchOutPdtDataTableClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php } ?>

<?php include('script/jTransferBchOutPdtDataTable.php'); ?>
