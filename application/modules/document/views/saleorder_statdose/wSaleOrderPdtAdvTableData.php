<style>
    .xCNBTNPrimeryDisChgPlus{
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
<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tSOPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tSOPunCode;?>">
        <table id="otbSODocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th><?php echo language('document/saleorder/saleorder','tSOTBChoose')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOTBNo')?></th>
                    <?php foreach($aColumnShow as $HeaderColKey => $HeaderColVal):?>
                        <th nowrap title="<?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30,"UTF-8");?>">
                            <?php echo iconv_substr($HeaderColVal->FTShwNameUsr, 0,30, "UTF-8");?>
                        </th>
                    <?php endforeach;?>
                    <th class="xCNPIBeHideMQSS"><?php echo language('document/saleorder/saleorder', 'tSOTBDelete');?></th>
                    <th class="xCNPIBeHideMQSS xWPIDeleteBtnEditButtonPdt"><?php echo language('document/saleorder/saleorder','tSOTBEdit');?></th>
                </tr>
            </thead>
            <tbody id="odvTBodySOPdtAdvTableList">
                <?php $nNumSeq  = 0;?>
                <?php if($aDataDocDTTemp['rtCode'] == 1):?>
                    <?php foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): ?>
                        <tr
                            class="text-center xCNTextDetail2 nItem<?php echo $nNumSeq?> xWPdtItem xWPdtItemList<?php echo $aDataTableVal['rtRowID']?>"
                            data-index="<?php echo $aDataTableVal['rtRowID'];?>"
                            data-docno="<?php echo $aDataTableVal['FTXthDocNo'];?>"
                            data-seqno="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                            data-seq="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                            data-pdtcode="<?php echo $aDataTableVal['FTPdtCode'];?>" 
                            data-pdtname="<?php echo $aDataTableVal['FTXtdPdtName'];?>"
                            data-puncode="<?php echo $aDataTableVal['FTPunCode'];?>"
                            data-qty="<?php echo number_format($aDataTableVal['FCXtdQty'], $nOptDecimalShow);?>"
                            data-setprice="<?php echo number_format($aDataTableVal['FCXtdSetPrice'], $nOptDecimalShow);?>"
                            data-stadis="<?php echo $aDataTableVal['FTXtdStaAlwDis']?>"
                            data-alwdis="<?php echo $aDataTableVal['FTXtdStaAlwDis']?>"
                            data-netafhd="<?php echo number_format($aDataTableVal['FCXtdNetAfHD'], $nOptDecimalShow);?>"
                            data-vat="<?=number_format($aDataTableVal['FCXtdVatRate'], $nOptDecimalShow);?>"
                            data-alwvat="<?=$aDataTableVal['FTXtdVatType'];?>"
                        >
                        <td class="text-center">
                            <label class="fancy-checkbox">
                            <?php 
                                    if(empty($tSOStaApv)){
                            ?>
                                <input id="ocbListItem<?php echo $aDataTableVal['rtRowID']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]">
                                    <?php } ?> 
                                <span></span>
                            </label>
                            <td><label><?php echo $aDataTableVal['rtRowID']?></label></td>
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
                                <td nowrap class="<?php echo $tAlignFormat?>">
                                    <?php if($DataVal->FTShwStaAlwEdit == 1 && in_array($tColumnName, ['FCXtdQty', 'FCXtdSetPrice', 'FTXtdDisChgTxt']) && (empty($tSOStaApv) && $tSOStaDoc != 3)):?>
                                        <?php if($tColumnName == 'FTXtdDisChgTxt' && $aDataTableVal['FTXtdStaAlwDis'] == '1'):?>
                                            <div class="xWPIDisChgDTForm">
                                                <button class="xCNBTNPrimeryDisChgPlus" onclick="JCNvSOCallModalDisChagDT(this)" type="button">+</button>
                                                <label class="xWPIDisChgDT" style="padding-left: 5px;padding-top: 3px;" id="olbSODisChgDT<?php echo $aDataTableVal['rtRowID']?>"><?php echo $aDataTableVal[$tColumnName];?></label>
                                            </div>
                                        <?php else:?>
                                            <label
                                                data-field="<?php echo $tColumnName?>"
                                                data-seq="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                                                data-demo="TextDEmo"
                                                class="xCNHide xCNPdtFont xWShowInLine<?php echo $aDataTableVal['rtRowID']?> xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"
                                            >
                                            <?php if($tColumnName != 'FTXtdDisChgTxt'){ ?>
                                                <?php echo  $tDataCol != '' ? "".$tDataCol : '1'; ?>
                                                <?php }else {  echo  language('document/saleorder/saleorder','tSODiscountisnotallowed');  } ?>
                                            </label>
                                            <?php if($tColumnName != 'FTXtdDisChgTxt'){ ?>
                                            <div class="xWEditInLine<?php echo $aDataTableVal['FNXtdSeqNo']?>">
                                                <input 
                                                    type="<?php echo $InputType?>" 
                                                    class="xW<?php echo $tColumnName?> form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aDataTableVal['rtRowID']?> <?php echo $tValidateType?> <?php echo $tAlignFormat;?>"
                                                    id="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                    name="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                    maxlength="<?php echo $tMaxlength?>" 
                                                    value="<?php echo $tDataCol;?>"
                                                    <?php echo $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?php echo  $tColumnName == 'FCXtdQty'; ?>
                                                    autocomplete="off"
                                                >
                                            </div>   
                                            <?php } ?>
                                        <?php endif;?>
                                    <?php else: ?>
                                        <?php if( $tColumnName == "FCXtdNet" ){ ?>
                                            <span id="ospGrandTotal<?php echo $aDataTableVal['rtRowID']?>"><?=number_format($aDataTableVal['FCXtdNet'],$nOptDecimalShow);?></span>
                                            <span id="ospnetAfterHD<?php echo $aDataTableVal['rtRowID']?>" style="display: none;"><?=number_format($aDataTableVal['FCXtdNetAfHD'],$nOptDecimalShow);?></span>
                                        <?php }else{ ?>
                                            <label class="xCNPdtFont xWShowInLine xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"><?php echo $tDataCol?></label>
                                        <?php } ?>
                                    <?php endif;?>                  
                                </td>
                            <?php endforeach; ?>
                            <td nowrap class="text-center xCNPIBeHideMQSS">
                                <label class="xCNTextLink">
                                <?php 
                                  if(empty($tSOStaApv)){ 
                                      ?>
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnSODelPdtInDTTempSingle(this)">
                                  <?php } ?>
                                </label>
                            </td>
                            <td class="xCNPIBeHideMQSS"></td>
                        </tr>
                        <?php $nNumSeq++; ?>
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td class="text-center xCNTextDetail2 xWPITextNotfoundDataPdtTable" colspan="100%"><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
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
        <div class="xWPagePIPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvSOPDTDocDTTempClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
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
                <button onclick="JSvSOPDTDocDTTempClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDocDTTemp['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSOPDTDocDTTempClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
<?php endif;?>

<!-- ============================================ Modal Confirm Delete Documet Detail Dis ============================================ -->
    <div id="odvSOModalConfirmDeleteDTDis" class="modal fade" style="z-index: 7000;">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?= language('common/main/main', 'tSOMsgNotificationChangeData') ?></label>
                </div>
                <div class="modal-body">
                    <label><?php echo language('document/saleorder/saleorder','tSOMsgTextNotificationChangeData');?></label>
                </div>
                <div class="modal-footer">
                    <button id="obtSOConfirmDeleteDTDis" data-dismiss="modal" type="button"  class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtSOCancelDeleteDTDis" data-dismiss="modal" type="button" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ================================================================================================================================= -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php  include("script/jSaleOrderPdtAdvTableData.php");?>
