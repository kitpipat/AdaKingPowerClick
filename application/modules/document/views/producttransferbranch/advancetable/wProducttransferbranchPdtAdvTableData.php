  <div class="table-responsive">
      <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
      <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">

      <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tPdtCode?>">
      <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tPunCode?>">
      
      <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable">

        <thead>
          <tr class="xCNCenter">
            <?php if(((@$tXthStaApv == '') && @$tXthStaDoc != 3)){ ?>
            <th><?= language('document/document/document','tDocChoose')?></th>
            <?php } ?>

            <th><?= language('document/document/document','tDocNumber')?></th>

            <?php foreach($aColumnShow as $HeaderColKey=>$HeaderColVal){ ?>
              <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>">
                  <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
              </th>
            <?php } ?>

            <?php if(((@$tXthStaApv == '') && @$tXthStaDoc != 3)){ ?>
              <th><?=language('document/document/document','tDocDelete')?></th>
            <?php } ?>
            
            <?php if(@$tXthStaApv != '1'){ ?>
              <th><?=language('document/document/document','tDocEdit')?></th>
            <?php } ?>

          </tr>
        </thead>

        <tbody id="odvTBodyTBPdt">
        <?php $nNumSeq = 0; ?>
        <?php if($aDataDT['rtCode'] == 1){?>
              
            <?php foreach($aDataDT['raItems'] as $DataTableKey=>$aDataTableVal){?>
      
                    <tr class="text-center xCNTextDetail2 nItem<?=$nNumSeq?> xWPdtItem"  data-index="<?=$DataTableKey?>" data-docno="<?=$aDataTableVal['FTXthDocNo']?>" data-pdtname="<?=$aDataTableVal['FTXtdPdtName']?>" data-pdtcode="<?=$aDataTableVal['FTPdtCode']?>" data-puncode="<?=$aDataTableVal['FTPunCode']?>" data-seqno="<?=$aDataTableVal['FNXtdSeqNo']?>">
                      
                    <?php if(((@$tXthStaApv == '') && @$tXthStaDoc != 3)){?>
                      <td class="text-center">
                          <label class="fancy-checkbox">
                              <input id="ocbListItem<?=$aDataTableVal['FNXtdSeqNo']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                              <span>&nbsp;</span>
                          </label>
                      </td>
                    <?php } ?>

                      <td><?=$aDataTableVal['FNXtdSeqNo']?></td>

                      <?php foreach($aColumnShow as $DataKey=>$DataVal){

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
                                  $tAlignFormat = 'text-right';
                                  $tDataCol = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                  $InputType = 'number';
                                  $tValidateType = '';
                              }else{
                                  $tMaxlength = '';
                                  $tAlignFormat = 'text-left';
                                  $tDataCol = $aDataTableVal[$tColumnName];
                                  $InputType = 'text';
                                  $tValidateType = '';
                              }

                      ?>

                              <td nowrap class="<?=$tAlignFormat?>">
                                <?php if( ($DataVal->FTShwStaAlwEdit == 1 && in_array($tColumnName, ['FCXtdSetPrice','FCXtdQty']) && (empty($tXthStaApv) && $tXthStaDoc != 3) ) && ( $aDataTableVal['FTTmpStatus'] != 5 )):?>
                                        <label class="xCNPdtFont xWShowInLine<?=$aDataTableVal['FNXtdSeqNo']?> xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?= $tDataCol != '' ? "".$tDataCol : '-'; ?></label>
                                        <div class="xCNHide xWEditInLine<?=$aDataTableVal['FNXtdSeqNo']?>">
                                          <input  type="<?=$InputType?>" class="form-control xCNPdtEditInLine xWValueEditInLine<?=$aDataTableVal['FNXtdSeqNo']?> <?=$tValidateType?> xCNInputWithoutSpc xWEditPdtInline" id="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>" name="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>" maxlength="<?=$tMaxlength?>" value="<?=$aDataTableVal[$tColumnName]?>" data-field="<?=$tColumnName?>"  <?= $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?= $tColumnName  == 'FCXtdQty' ?>>
                                        </div>
                                <?php else: ?>
                                    <?php if( $aDataTableVal['FTTmpStatus'] != 5 ){ ?>
                                        <label class="xCNPdtFont xWShowInLine xWShowValue<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>"><?=$tDataCol?></label>
                                    <?php }else{ ?>
                                    <?php
                                        if( (empty($tXthStaApv) && $tXthStaDoc != 3) ){
                                          if($tColumnName=='FCXtdQty'){
                                              $tClassName = 'xCNTextLink';
                                              $tIconEdit = " <img class='xCNIconTable' src=".base_url('application/modules/common/assets/images/icons/edit.png')." title='Edit'>";
                                          }else{
                                              $tClassName = 'xCNTextLink';
                                              $tIconEdit = "";
                                          }
                                        }else{
                                            $tClassName = 'xCNTextLink';
                                            $tIconEdit  = "";
                                        }
                                        $aOptionFashion = array(
                                          'tDocumentBranch'     => $aDataTableVal['FTBchCode'],
                                          'tDocumentNumber'     => $aDataTableVal['FTXthDocNo'],
                                          'tDocumentProduct'    => $aDataTableVal['FTPdtCode'],
                                          'tDocumentDocKey'     => 'TCNTPdtTbxHD',
                                          'nDTSeq'              => $aDataTableVal['FNXtdSeqNo'],
                                          'tDTBarCode'          => $aDataTableVal['FTXtdBarCode'],
                                          'tDTPunCode'          => $aDataTableVal['FTPunCode'],
                                          'tNextFunc'           => 'FSvTBXPDTAddPdtIntoTableDT',
                                          'tSpcControl'         => 0,                    //0:??????????????? //1:???????????????????????????????????????????????????????????? //2:?????????????????????????????????????????????????????? //3:?????????????????????????????????
                                          'tStaEdit'            => ( $tXthStaApv == '1' || $tXthStaDoc == '3' ? '2' : '1' )
                                        );
                                        $aOption = json_encode($aOptionFashion);
                                      ?>
                                        <label class="<?=$tClassName?> xCNPdtFont xWShowInLine xWShowValue<?=$tColumnName?><?=$aDataTableVal['rtRowID']?>" onclick='JSxUpdateProductSerialandFashion(<?=$aOption?>)' ><?=$tDataCol?> <?=$tIconEdit?></label>
                                    <?php } ?>
                                <?php endif;?> 
                                <!-- <?php if($DataVal->FTShwStaAlwEdit == 1 && $tXthStaDoc != '3'){ ?>
                                        <label class="xCNPdtFont xWShowInLine<?=$aDataTableVal['FNXtdSeqNo']?> xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?= $tDataCol != '' ? "".$tDataCol : '-'; ?></label>
                                        <div class="xCNHide xWEditInLine<?=$aDataTableVal['FNXtdSeqNo']?>">
                                          <input type="<?=$InputType?>" class="form-control xCNPdtEditInLine xWValueEditInLine<?=$aDataTableVal['FNXtdSeqNo']?> <?=$tValidateType?> xCNInputWithoutSpc xWEditPdtInline" id="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>" name="ohd<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>" maxlength="<?=$tMaxlength?>" value="<?=$aDataTableVal[$tColumnName]?>" data-field="<?=$tColumnName?>"  <?= $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?= $tColumnName  == 'FCXtdQty' ?>>
                                        </div>
                                <?php }else{   ?>
                                        <label class="xCNPdtFont xWShowValue<?=$tColumnName?><?=$aDataTableVal['FNXtdSeqNo']?>"><?=$tDataCol?></label>
                                <?php } ?> -->
                              </td>

                    <?php } ?>

                    <?php if(((@$tXthStaApv == '') && @$tXthStaDoc != 3)){?>
                      <td nowrap class="text-center">
                        <label class="xCNTextLink">
                            <img 
                                class="xCNIconTable" 
                                src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" 
                                title="Remove"
                                onclick="JSnRemoveDTRow(this)"
                            >
                        </label>
                      </td>
                    <?php } ?>

                    <?php if(@$tXthStaApv != '1'){ ?>
                      <td nowrap class="text-center">
                        <label class="xCNTextLink">
                            <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" title="Edit" >
                        </label>
                      </td>
                    <?php } ?>

                </tr>
                <?php $nNumSeq++; ?>
                <?php }?>
            <?php }else{ ?>
                    <tr><td class='text-center xCNTextDetail2 xWTextNotfoundDataTablePdt' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
            <?php } ?>
        
        </tbody>
      </table>
  </div>

<?php
  if($aDataDT['rnAllPage'] > 1){
?>
  <div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataDT['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataDT['rnCurrentPage']?> / <?=$aDataDT['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageTBPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTBPdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
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
                
                <button onclick="JSvTBPdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTBPdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
  </div>
<?php
  }
?>

<!-- Modal -->
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

<!-- Modal Delete Items -->
<div class="modal fade" id="odvModalDelPdtTB">
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
				  <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoTBPdtDelChoose('<?=@$nCurrentPage?>')"><?=language('common/main/main', 'tModalConfirm')?></button>
          <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main', 'tModalCancel')?></button>
			</div>
		</div>
	</div>
</div>

<!-- Sum HD -->
<?php 
    if(!empty($aDataDTSum[0]['FCXtdAmt']) && $aDataDTSum[0]['FCXtdAmt'] != ''){
        $FCXtdAmt = $aDataDTSum[0]['FCXtdAmt'];
    }else{
        $FCXtdAmt = 0;
    }
?>

<input type="text" class="form-control xCNHide" id="ohdFCXthTotal" name="ohdFCXthTotal" value="<?php echo $FCXtdAmt; ?> ">
<input type="text" class="form-control xCNHide" id="ohdFCXthTotalShow" name="ohdFCXthTotalShow" value="<?php echo number_format($FCXtdAmt, $nOptDecimalShow, '.', ','); ?> ">
<!-- Sum HD -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<?php  include("script/jProducttransferbranchPdtAdvTableData.php");?>