<?php
  $nOptDecimalShow = FCNxHGetOptionDecimalShow(); 
?>
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
    <input type="text" class="xCNHide" id="ohdEditInlineSetDTSeq" value="<?php echo $tPdtCode?>">
    <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?php echo $tPdtCode?>">
    <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?php echo $tPunCode?>">
      
    <table class="table table-striped xWPdtTableFont" id="otbDOCCashTable">
        <thead>
      
            <tr class="xCNCenter">
                <th><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumTBChoose')?></th>
                <th><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumTBNo')?></th>
             
                    <th nowrap><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumPdtCode')?></th>
                    <th nowrap><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumPdtName')?></th>
                    <!-- <th nowrap ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumBarCode')?></th> -->
                    <th nowrap><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumLocer')?></th>
                    <th nowrap><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumPunName')?></th>
                    <th nowrap><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumUnitfact')?></th>
                    <th nowrap class="xCheckTimeCountC1 xCheckTimeCount "  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumDateCount')?></th>
                    <th nowrap class="xCheckTimeCountC1 xCheckTimeCount "  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumTimeCount')?></th>
                    <th nowrap class="xCheckTimeCountC1 xCheckTimeCount " ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumCount1')?></th>
                    <th nowrap class="xCheckTimeCountC2 xCheckTimeCount "  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumDateCount')?></th>
                    <th nowrap class="xCheckTimeCountC2 xCheckTimeCount "  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumTimeCount')?></th>
                    <th nowrap class="xCheckTimeCountC2 xCheckTimeCount "  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumCount2')?></th>
                    <th nowrap class="xCheckTimeCount xCheckTimeCount xWSticky xStickyCust1"  style="right:400px ;width:80px"><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumDateCount')?></th>
                    <th nowrap class="xCheckTimeCount xCheckTimeCount xWSticky xStickyCust2" style="right:320px ;width:80px"><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumTimeCount')?></th>
                    <th nowrap class="xCheckTimeCount xCheckTimeCount xWSticky xStickyCust3" style="right:240px ;width:80px"><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumUseDesionMy')?></th>
                    <th nowrap class="xShowOnEdit xWSticky "  style="right:160px ;width:80px"  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumB4Adjust')?></th>
                    <th nowrap class="xShowOnEdit xWSticky "  style="right:80px ;width:80px"  ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumAdjust')?></th>
                    <th nowrap class="xShowOnEdit xWSticky "  style="right:0px ;width:80px" ><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumAfterAdjust')?></th>
           
                <?php if(@$tXthStaApv != 1 && @$tXthStaDoc != 3){?>
                    <th><?= language('document/adjuststocksum/adjuststocksum','tAdjStkSumTBDelete')?></th>
                    <!-- <th><?= language('document/adjuststocksum/adjuststocksum','tPOTBEdit')?></th> -->
                <?php } ?>
            </tr>
        </thead>
        <tbody id="odvTBodyAdjStkSumPdt">
        <?php $nNumSeq = 0; ?>
        <?php
        

        
        if($aDataDT['rtCode'] == 1){ ?>
              
            <?php foreach($aDataDT['raItems'] as $DataTableKey => $aDataTableVal){
                

                $aOptionFashionC1 = array(
                    'tDocumentBranch'     => $aDataTableVal['FTBchCode'],
                    'tDocumentNumber'     => $aDataTableVal['FTXthDocNo'],
                    'tDocumentDocKey'     => 'TCNTPdtAdjStkHD',
                    'tDocumentProduct'    => $aDataTableVal['FTPdtCode'],
                    'nDTSeq'              => $aDataTableVal['FNXtdSeqNo'],
                    'tDTBarCode'          => $aDataTableVal['FTXtdBarCode'],
                    'tDTPunCode'          => $aDataTableVal['FTPunCode'],
                    'tDocumentPlcCode'    => $aDataTableVal['FTAjdPlcCode'],
                    'tNextFunc'           => 'FSvStkSubAddPdtIntoDocDTTempC3',
                    'tSpcControl'         => 1   ,                //0:จำนวน //1:ตรวจนับครั้งที่หนึ่ง //2:ตรวจนับครั้งที่สอง //3:ตรวจนับย่อย
                    'tStaEdit'            => 2
                    );
                    $aOptionC1 = json_encode($aOptionFashionC1);

                $aOptionFashionC2 = array(
                    'tDocumentBranch'     => $aDataTableVal['FTBchCode'],
                    'tDocumentNumber'     => $aDataTableVal['FTXthDocNo'],
                    'tDocumentDocKey'     => 'TCNTPdtAdjStkHD',
                    'tDocumentProduct'    => $aDataTableVal['FTPdtCode'],
                    'nDTSeq'              => $aDataTableVal['FNXtdSeqNo'],
                    'tDTBarCode'          => $aDataTableVal['FTXtdBarCode'],
                    'tDTPunCode'          => $aDataTableVal['FTPunCode'],
                    'tDocumentPlcCode'    => $aDataTableVal['FTAjdPlcCode'],
                    'tNextFunc'           => 'FSvStkSubAddPdtIntoDocDTTempC3',
                    'tSpcControl'         => 2   ,                //0:จำนวน //1:ตรวจนับครั้งที่หนึ่ง //2:ตรวจนับครั้งที่สอง //3:ตรวจนับย่อย
                    'tStaEdit'            => 2
                    );
                    $aOptionC2 = json_encode($aOptionFashionC2);
    

                $aOptionFashionC3 = array(
                    'tDocumentBranch'     => $aDataTableVal['FTBchCode'],
                    'tDocumentNumber'     => $aDataTableVal['FTXthDocNo'],
                    'tDocumentDocKey'     => 'TCNTPdtAdjStkHD',
                    'tDocumentProduct'    => $aDataTableVal['FTPdtCode'],
                    'nDTSeq'              => $aDataTableVal['FNXtdSeqNo'],
                    'tDTBarCode'          => $aDataTableVal['FTXtdBarCode'],
                    'tDTPunCode'          => $aDataTableVal['FTPunCode'],
                    'tDocumentPlcCode'    => $aDataTableVal['FTAjdPlcCode'],
                    'tNextFunc'           => 'FSvStkSubAddPdtIntoDocDTTempC3',
                    'tSpcControl'         => 3   ,                //0:จำนวน //1:ตรวจนับครั้งที่หนึ่ง //2:ตรวจนับครั้งที่สอง //3:ตรวจนับย่อย
                    'tStaEdit'            => 1
                    );
                 $aOptionC3 = json_encode($aOptionFashionC3);
        


                 if($aDataTableVal['FTTmpStatus']=='5'){
                    $tClassName = 'xCNTextLink';
                    $tOnClickC1 = " onclick='JSxUpdateProductSerialandFashion(".$aOptionC1.")' ";
                    $tOnClickC2 = " onclick='JSxUpdateProductSerialandFashion(".$aOptionC2.")' ";
                    $tOnClickC3 = " onclick='JSxAJHSetDTSeqPdt4Fhn(".$aDataTableVal['FNXtdSeqNo'].");JSxUpdateProductSerialandFashion(".$aOptionC3.")' ";
                    $tIconView = " <img class='xCNIconTable' src=".base_url('application/modules/common/assets/images/icons/view2.png')." title='view'>";
                }else{
                    $tClassName = '';
                    $tOnClickC1 = "";
                    $tOnClickC2 = "";
                    $tOnClickC3 = "";
                    $tIconView = " ";
                }


                ?>
                <tr 
                    id="otrSpaPdtPri<?=$aDataTableVal['FNXtdSeqNo']?>"
                    class="text-center xCNTextDetail2 nItem<?=$nNumSeq?> xWPdtItem"  
                    data-index="<?=$DataTableKey?>" 
                    data-docno="<?=$aDataTableVal['FTXthDocNo']?>" 
                    data-pdtname="<?=$aDataTableVal['FTXtdPdtName']?>" 
                    data-pdtcode="<?=$aDataTableVal['FTPdtCode']?>" 
                    data-puncode="<?=$aDataTableVal['FTPunCode']?>" 
                    data-seqno="<?=$aDataTableVal['FNXtdSeqNo']?>">
                  <td class="text-center">
                      <label class="fancy-checkbox">
                          <input id="ocbListItem<?=$aDataTableVal['FNXtdSeqNo']?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" value="<?=$aDataTableVal['FNXtdSeqNo']?>" >
                          <span></span>
                      </label>
                  </td>
                  <td class=""><?=$aDataTableVal['FNXtdSeqNo']?></td>
               
                  <td nowrap class="text-left ">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFTPdtCode<?=$aDataTableVal['FNXtdSeqNo']?>" ><?=$aDataTableVal['FTPdtCode']?></label>
                 </td>
                 <td nowrap class="text-left">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFTPdtCode<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=$aDataTableVal['FTXtdPdtName']?></label>
                 </td>
                 <!-- <td nowrap class="text-left">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFTXtdBarCode<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=$aDataTableVal['FTXtdBarCode']?></label>
                 </td> -->
                 <td nowrap class="text-left">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFTAjdPlcCode<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=$aDataTableVal['FTAjdPlcCode']?></label>
                 </td>
                 <td nowrap class="text-left">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFTPunName<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=$aDataTableVal['FTPunName']?></label>
                 </td>
                 <td nowrap class="text-right">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFCPdtUnitFact<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=number_format($aDataTableVal['FCPdtUnitFact'],$nOptDecimalShow)?></label>
                 </td>
                  <!-- นับ1 -->
                 <td nowrap class="text-left xCheckTimeCountC1 xCheckTimeCount">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFDAjdDateC1<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=date('d/m/Y',strtotime($aDataTableVal['FDAjdDateTimeC1']))?></label>
                 </td>
                 <td nowrap class="text-left xCheckTimeCountC1 xCheckTimeCount">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFDAjdTimeC1<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=date('H:i',strtotime($aDataTableVal['FDAjdDateTimeC1']))?></label>
                 </td>
                 <td nowrap class="text-right xCheckTimeCountC1 xCheckTimeCount">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFCAjdUnitQtyC1<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC1?>><?=number_format($aDataTableVal['FCAjdUnitQtyC1'],$nOptDecimalShow)?> <?=$tIconView?></label>
                 </td>
                <!-- นับ2 -->
                 <td nowrap class="text-left xCheckTimeCountC2 xCheckTimeCount">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFDAjdDateC2<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC2?>><?=date('d/m/Y',strtotime($aDataTableVal['FDAjdDateTimeC2']))?></label>
                 </td>
                 <td nowrap class="text-left xCheckTimeCountC2 xCheckTimeCount">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFDAjdTimeC2<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC2?>><?=date('H:i',strtotime($aDataTableVal['FDAjdDateTimeC2']))?></label>
                 </td>
                 <td nowrap class="text-right xCheckTimeCountC2 xCheckTimeCount">
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFCAjdUnitQtyC2<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC2?>><?=number_format($aDataTableVal['FCAjdUnitQtyC2'],$nOptDecimalShow)?> <?=$tIconView?></label>
                 </td>
                <!-- กำหนดเอง -->
                 <td nowrap class="text-left xCheckTimeCount xCheckTimeCount xWSticky xStickyCust1" style="right:400px ;width:80px"  >
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFDAjdDateC3<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC3?>><?php if(!empty($aDataTableVal['FDAjdDateTime'])){ echo  date('d/m/Y',strtotime($aDataTableVal['FDAjdDateTime'])); }  ?></label>
                 </td>
                 <td nowrap class="text-left xCheckTimeCount xCheckTimeCount xWSticky xStickyCust2" style="right:320px ;width:80px" >
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFDAjdTimeC3<?=$aDataTableVal['FNXtdSeqNo']?>" <?=$tOnClickC3?>><?php if(!empty($aDataTableVal['FDAjdDateTime'])){ echo  date('H:i',strtotime($aDataTableVal['FDAjdDateTime'])); } ?></label>
                 </td>
                 <td nowrap class="text-right xCheckTimeCount xCheckTimeCount xWSticky xStickyCust3"  style="right:240px ;width:80px" >
                 <?php if($aDataTableVal['FTTmpStatus']!=5){ ?>
                  <input 
                            type="text" 
                            style="    
                                                        background: rgb(249, 249, 249);
                                                        box-shadow: 0px 0px 0px inset;
                                                        border-top: 0px !important;
                                                        border-left: 0px !important;
                                                        border-right: 0px !important;
                                                        padding: 0px;
                                                        text-align: right;
                                                    "
                            class="form-control xCNPdtEditInLine xWValueEditInLine<?=$aDataTableVal['FNXtdSeqNo']?> xCNInputNumericWithDecimal xCNInputMaskCurrencySm  text-right" 
                            id="ohdFCAjdUnitQty<?=$aDataTableVal['FNXtdSeqNo']?>" 
                            name="ohdFCAjdUnitQty<?=$aDataTableVal['FNXtdSeqNo']?>" 
                            maxlength="11" 
                            value="<?php if(!empty($aDataTableVal['FCAjdUnitQty'])){ echo number_format($aDataTableVal['FCAjdUnitQty'],$nOptDecimalShow); }else{ echo number_format(0,$nOptDecimalShow) ; } ?>" 
                            data-field="FCAjdUnitQty"
                            seq="<?=$aDataTableVal['FNXtdSeqNo']?>"
                            unitfact="<?=$aDataTableVal['FCPdtUnitFact']?>"
                            columname="FCAjdUnitQty"
                            col-validate="0"
                            page="<?=$nPage?>"
                            b4value="<?php if(!empty($aDataTableVal['FCAjdUnitQty'])){ echo $aDataTableVal['FCAjdUnitQty']; }else{ echo 0 ; } ?>"
                            onkeypress=" if(event.keyCode==13 ){ return JSxAdjStkSumSaveInLine(event,this); } "
                            onfocusout="JSxAdjStkSumSaveInLine(event,this)"
                            onclick="JSxSPASetValueCommaOut(this)"
                                                      >
                <?php }else{ 
                          
                            $tIconEdit = " <img class='xCNIconTable' src=".base_url('application/modules/common/assets/images/icons/edit.png')." title='Edit'>";

                    ?> 
                
                    <label class="xCNPdtFont <?=$tClassName?> xWShowInLine xWShowValueFCAjdUnitQty<?=$aDataTableVal['rtRowID']?>" <?=$tOnClickC3?> ><?php if(!empty($aDataTableVal['FCAjdUnitQty'])){ echo number_format($aDataTableVal['FCAjdUnitQty'],$nOptDecimalShow); }else{ echo number_format(0,$nOptDecimalShow) ; } ?> <?=$tIconEdit?></label>
                <?php } ?>
                 </td>
      
                <!-- ก่อนปรับ -->
                 <td nowrap class="text-right xShowOnEdit xWSticky" style="right:160px ;width:80px" >
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFCAjdWahB4Adj<?=$aDataTableVal['FNXtdSeqNo']?>"><?=number_format($aDataTableVal['FCAjdWahB4Adj'],$nOptDecimalShow)?></label>
                 </td>
                <!-- ปรับ [+ -] -->
                 <td nowrap class="text-right xShowOnEdit xWSticky" style="right:80px ;width:80px" >
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueFCAjdQtyAllDiff<?=$aDataTableVal['FNXtdSeqNo']?>"><?=number_format($aDataTableVal['FCAjdQtyAllDiff'],$nOptDecimalShow)?></label>
                 </td>
                <!-- หลังปรับ -->
                 <td nowrap class="text-right xShowOnEdit xWSticky" style="right:0px ;width:80px" >
                  <label class="xCNPdtFont <?=$tClassName?> xWShowValueAfterAdj<?=$aDataTableVal['FNXtdSeqNo']?>"><?=number_format($aDataTableVal['FCAjdWahB4Adj']+$aDataTableVal['FCAjdQtyAllDiff'],$nOptDecimalShow)?></label>
                 </td>

                <?php //if((@$tXthStaApv == '') && @$tXthStaDoc != 3) { ?>
                  <td nowrap class="text-center">
                    <lable class="xCNTextLink">
                        <img class="xCNIconTable xCNIconDel" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnRemoveDTRow(this)">
                    </lable>
                  </td>
                  <!-- <td nowrap class="text-center">
                    <lable class="xCNTextLink">
                        <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/edit.png'); ?>" title="Edit" onclick="JSnEditDTRow(this)">
                    </lable>
                  </td> -->
                <?php //} ?>
            </tr>
                <?php $nNumSeq++; ?>
            <?php } ?>
        <?php }else { ?>
            <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
        <?php } ?>
        
        </tbody>
    </table>
</div>

<div class="row">
    <div class="col-md-6">
        <p><?= language('common/main/main','tResultTotalRecord')?> <?=$aDataDT['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?=$aDataDT['rnCurrentPage']?> / <?=$aDataDT['rnAllPage']?></p>
    </div>
    <div class="col-md-6">
        <div class="xWPageAdjStkSumPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvAdjStkSumPdtClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
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
                <button onclick="JSvAdjStkSumPdtClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDT['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvAdjStkSumPdtClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

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
<div class="modal fade" id="odvModalDelPdtAdjStkSum">
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
                <button id="osmConfirm" type="button" class="btn xCNBTNPrimery" onClick="JSoAdjStkSumPdtDelChoose('<?= @$nCurrentPage ?>')"><?= language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?= language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>

<?php  include("script/jAdjustStockSumPdtAdvTableData.php");?>


























