<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12" >
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdTXOBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdTXOBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdTXOEditInlinePdtCode" value="<?php echo $tPdtCode?>">
        <input type="text" class="xCNHide" id="ohdTXOEditInlinePunCode" value="<?php echo $tPunCode?>">

        <table class="table table-striped xWPdtTableFont" id="otbTXODocPdtTable">
            <thead>
                <tr class="xCNCenter">
                    <th><?php echo language('document/transferout/transferout','tTXOTBChoose')?></th>
                    <?php foreach($aColumnShow as $HeaderColKey => $HeaderColVal): ?>
                        <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>">
                            <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                        </th>
                    <?php endforeach; ?>
                    <?php if((@$tXthStaApv == '') && @$tXthStaDoc != 3):?>
                        <th><?php echo language('document/transferout/transferout','tTXOTBDelete')?></th>
                        <th><?php echo language('document/transferout/transferout','tTXOTBEdit')?></th>
                    <?php endif; ?>
                </tr>
            </thead>
            <tbody id="odvTBodyTXOPdt">
                <?php $nNumSeq = 0; ?>
                <?php if($aDataDT['rtCode'] == 1):?>
                    <?php foreach($aDataDT['raItems'] as $DataTableKey => $aDataTableVal):?>
                        <tr class="text-center xCNTextDetail2 xCNDOCPdtItem nItem<?php echo $nNumSeq;?>" data-index="<?php echo $DataTableKey;?>" data-pdtname="<?php echo $aDataTableVal['FTXtdStkCode'];?>" data-pdtcode="<?php echo $aDataTableVal['FTPdtCode'];?>" data-puncode="<?php echo $aDataTableVal['FTPunCode'];?>" data-seqno="<?php echo $aDataTableVal['FNXtdSeqNo'];?>">
                            <td class="text-center">
                                <label class="fancy-checkbox">
                                    <input id="ocbListItem<?php echo $aDataTableVal['FNXtdSeqNo']?>" type="checkbox" class="xWTXOPdtListItem" name="ocbListItem[]">
                                    <span>&nbsp;</span>
                                </label>
                            </td>
                            <?php foreach($aColumnShow as $DataKey => $DataVal){
                                $tColumnName        = $DataVal->FTShwFedShw;
                                $nColWidth          = $DataVal->FNShwColWidth;
                                $tColumnDataType    = substr($tColumnName,0,2);

                                if($tColumnDataType == 'FC'){
                                    $tMaxlength     = '11';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                    $InputType      = 'text';
                                    $tValidateType  = 'xCNInputNumericWithDecimal';
                                }elseif($tColumnDataType == 'FN'){
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-right';
                                    $tDataCol       = $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                                    $InputType      = 'number';
                                    $tValidateType  = '';
                                }else{
                                    $tMaxlength     = '';
                                    $tAlignFormat   = 'text-left';
                                    $tDataCol       = $aDataTableVal[$tColumnName];
                                    $InputType      = 'text';
                                    $tValidateType  = '';
                                }
                            ?>
                                <td nowrap class="<?php echo $tAlignFormat?>">
                                    <?php if($DataVal->FTShwStaAlwEdit == 1){ ?>
                                        <label class="xCNPdtFont xWShowInLine<?php echo $aDataTableVal['FNXtdSeqNo'];?> xWShowValue<?php echo $tColumnName;?><?php echo $aDataTableVal['FNXtdSeqNo'];?>"><?php echo  $tDataCol != '' ? "".$tDataCol : '-'; ?></label>
                                        <div class="xCNHide xWEditInLine<?php echo $aDataTableVal['FNXtdSeqNo']?>">
                                            <input
                                                type="<?php echo $InputType?>"
                                                class="form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aDataTableVal['FNXtdSeqNo']?> <?php echo $tValidateType;?>"
                                                id="ohd<?php echo $tColumnName;?><?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                                name="ohd<?php echo $tColumnName;?><?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                                maxlength="<?php echo $tMaxlength;?>"
                                                value="<?php echo $aDataTableVal[$tColumnName];?>"
                                                data-field="<?php echo $tColumnName;?>"
                                                <?php echo ($tColumnName == 'FTXtdDisChgTxt')? 'readonly' : '' ?>
                                                <?php echo $tColumnName  == 'FCXtdQty'?>
                                            >
                                        </div>
                                    <?php }else{ ?>
                                        <label class="xCNPdtFont xWShowValue<?php echo $tColumnName;?><?php echo $aDataTableVal['FNXtdSeqNo'];?>"><?php echo $tDataCol;?></label>
                                        <input
                                            type="<?php echo $InputType;?>"
                                            class="xCNHide xWValueEditInLine<?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                            id="ohd<?php echo $tColumnName;?><?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                            name="ohd<?php echo $tColumnName;?><?php echo $aDataTableVal['FNXtdSeqNo'];?>"
                                            value="<?php echo $aDataTableVal[$tColumnName];?>"
                                            data-field="<?php echo $tColumnName;?>"
                                        >
                                    <?php } ?>
                                </td>
                            <?php } ?>

                            <?php if((@$tXthStaApv == '') && @$tXthStaDoc != 3): ?>
                                <td nowrap class="text-center">
                                    <label class="xCNTextLink">
                                        <img class="xCNIconTable xCNIconDel" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>" title="Remove" onclick="JSxTXORemoveRowDTTmp(this)">
                                    </label>
                                </td>
                                <td nowrap class="text-center">
                                    <img class="xCNIconTable" src="<?php echo  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" title="Edit" onclick="JSxTXOEditRowDTTmp(this)">
                                </td>
                            <?php endif;?>
                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>    
                <?php endif;?>
            </tbody>
        </table>
    </div>
</div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <p><?php echo language('common/main/main','tResultTotalRecord');?> <?php echo $aDataDT['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataDT['rnCurrentPage']?> / <?php echo $aDataDT['rnAllPage']?></p>
</div>
<div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
    <div class="xWPageTXOPdt btn-toolbar pull-right">
        <?php if($aDataDT['rnCurrentPage'] == 1){ $tTXODisabledLeft = 'disabled'; }else{ $tTXODisabledLeft = '-';} ?>
        <button onclick="JSvTXOPdtDTClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tTXODisabledLeft ?>> 
            <i class="fa fa-chevron-left f-s-14 t-plus-1"></i>
        </button>

        <?php for($i=max($aDataDT['rnCurrentPage']-2, 1); $i<=max(0, min($aDataDT['rnAllPage'],$aDataDT['rnCurrentPage']+2)); $i++):?> 
            <?php 
                if($aDataDT['rnCurrentPage'] == $i){ 
                    $tActive = 'active'; 
                    $tDisPageNumber = 'disabled';
                }else{ 
                    $tActive = '';
                    $tDisPageNumber = '';
                }
            ?>
            <button onclick="JSvTXOPdtDTClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
        <?php endfor;?>
        
        <?php if($aDataDT['rnCurrentPage'] >= $aDataDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
        <button onclick="JSvTXOPdtDTClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
            <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
        </button>
    </div>
</div>

<!-- ==========================================================  Modal Show Colums Adv Product DT Temp ========================================================== -->
    <div id="odvTXOShowOrderColumn" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalAdvTable')?></label>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body" id="odvTXOOderDetailShowColumn"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal"><?php echo language('common/main/main','tModalAdvClose')?></button>
                    <button type="button" class="btn btn-primary" onclick="JSxTXOSaveColumnDTPdtTemp()"><?php echo language('common/main/main','tModalAdvSave')?></button>
                </div>
            </div>
        </div>    
    </div>
<!-- ============================================================================================================================================================ -->

<!-- ==============================================================  Modal Delete Product DT Temp =============================================================== -->
    <div id="odvTXOModalDelPdtDTTemp" class="modal fade" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTXOConfirmDelPdtDTTemp"> - </span>
                    <input type='hidden' id="ohdTXOConfirmSeqDelete">
                    <input type='hidden' id="ohdTXOConfirmPdtDelete">
                    <input type='hidden' id="ohdTXOConfirmPunDelete">
                    <input type='hidden' id="ohdTXOConfirmDocDelete">
                </div>
                <div class="modal-footer">
                    <button id="osmTXOConfirmPdtDTTemp" type="button" class="btn xCNBTNPrimery" ><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ============================================================================================================================================================ -->
<?php include('script/jTransferoutPdtAdvTableData.php')?>