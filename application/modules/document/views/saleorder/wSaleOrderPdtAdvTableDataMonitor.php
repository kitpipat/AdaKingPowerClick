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
                    <th><?php echo language('document/saleorder/saleorder','tSOTBNo')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOARPPdtImg')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOARPPdtCode')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOARPPdtName')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOARPPdtPrice')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOARPPdtQty')?></th>
                    <th><?php echo language('document/saleorder/saleorder','tSOARPPdtSubtotal')?></th>
                   
<?php  if($tSOStaApv==2 && $tSOStaDoc != 3 && $nSOLastSeq==1){  ?>
                    <th><?php echo language('document/saleorder/saleorder','tSODelete')?></th>
<?php } ?>
                </tr>
            </thead>
            <tbody id="odvTBodySOPdtAdvTableList">
                <?php $nNumSeq  = 0;?>
                <?php if($aDataDocDTTemp['rtCode'] == 1):?>
                    <?php foreach($aDataDocDTTemp['raItems'] as $DataTableKey => $aDataTableVal): ?>
                        <tr
                            class="text-center xCNTextDetail2 nItem<?php echo $nNumSeq?> xWPdtItem"
                            data-index="<?php echo $aDataTableVal['rtRowID'];?>"
                            data-docno="<?php echo $aDataTableVal['FTXthDocNo'];?>"
                            data-seqno="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                            data-pdtcode="<?php echo $aDataTableVal['FTPdtCode'];?>" 
                            data-pdtname="<?php echo $aDataTableVal['FTXtdPdtName'];?>"
                            data-puncode="<?php echo $aDataTableVal['FTPunCode'];?>"
                            data-qty="<?php echo $aDataTableVal['FCXtdQty'];?>"
                            data-setprice="<?php echo $aDataTableVal['FCXtdSetPrice'];?>"
                            data-stadis="<?php echo $aDataTableVal['FTXtdStaAlwDis']?>"
                            data-netafhd="<?php echo $aDataTableVal['FCXtdNetAfHD'];?>"
                        >
                    
                            <td><label><?php echo $aDataTableVal['rtRowID']?></label></td>
                            <?php
                                        if(isset($aDataTableVal['FTImgObj']) && !empty($aDataTableVal['FTImgObj'])){
                                            // print_r($aDataTableVal['FTImgObj']);
                                            $aValueImgExplode = explode('/modules/',$aDataTableVal['FTImgObj']);
                                            // print_r($aValueImgExplode);
                                            $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                                            if (file_exists($tFullPatch)){
                                                $tPatchImg = base_url().'application/modules/'.$aValueImgExplode[1];
                                            }else{
                                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                            }
                                        }else{
                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                        }
                                    ?>
                                    <td nowrap class="xCNBorderRight xWPdtImgtd" >
                                        <img src="<?php echo $tPatchImg;?>" class="img img-respornsive" style="width: 20%">
                                    </td>
                            <td width="6%" align="left"><?php echo $aDataTableVal['FTPdtCode'];?></td>
                            <td width="50%" align="left"><?php echo $aDataTableVal['FTXtdPdtName'];?></td>
                            <td width="8%" align="right"><?php echo $aDataTableVal['FCXtdSetPrice'];?></td>
                            <td width="6%"><?php  
                        
                            $tColumnName='FCXtdQty';
                            $tMaxlength     = '11';
                            $tAlignFormat   = 'text-right';
                            $tDataCol       =  $aDataTableVal[$tColumnName] != '' ? number_format($aDataTableVal[$tColumnName], $nOptDecimalShow, '.', ',') : number_format(0, $nOptDecimalShow,'.',',');
                            $InputType      = 'text';
                            $tValidateType  = 'xCNInputNumericWithDecimal';
                            if($tSOStaApv==2 && $tSOStaDoc != 3 && $nSOLastSeq==1){
                            ?>

                            <label 
                                                data-field="<?php echo $tColumnName?>"
                                                data-seq="<?php echo $aDataTableVal['FNXtdSeqNo']?>"
                                                data-demo="TextDEmo"
                                                class="xCNPdtFont xWShowInLine<?php echo $aDataTableVal['rtRowID']?> xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"
                                            >
                                                <?php echo  $tDataCol != '' ? "".$tDataCol : '1'; ?>
                                            </label>
                                            <div class="xCNHide xWEditInLine<?php echo $aDataTableVal['FNXtdSeqNo']?>">
                                                <input 
                                                    type="<?php echo $InputType?>" 
                                                    class="form-control xCNPdtEditInLine xWValueEditInLine<?php echo $aDataTableVal['rtRowID']?> <?php echo $tValidateType?> "
                                                    id="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                    name="ohd<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>" 
                                                    maxlength="<?php echo $tMaxlength?>" 
                                                    value="<?php echo $tDataCol;?>" 
                                                    style="text-align: right;"
                                                    <?php echo $tColumnName == 'FTXtdDisChgTxt' ? 'readonly' : '' ?> <?php echo  $tColumnName == 'FCXtdQty'; ?>>
                                            </div> 

                            <?php }else{ ?>
                                <label class="xCNPdtFont xWShowInLine xWShowValue<?php echo $tColumnName?><?php echo $aDataTableVal['rtRowID']?>"><?php echo $tDataCol?></label>
                            <?php } ?> 
                                            </td>
                            <td width="8%" align="right"><?php echo $aDataTableVal['FCXtdNet'];?></td>
                            <?php  if($tSOStaApv==2 && $tSOStaDoc != 3 && $nSOLastSeq==1){  ?>
                            <td nowrap class="text-center xCNPIBeHideMQSS">
                                <label class="xCNTextLink">
                                    <img class="xCNIconTable" src="<?php echo  base_url('application/modules/common/assets/images/icons/delete.png'); ?>" title="Remove" onclick="JSnSODelPdtInDTTempSingle(this)">
                                </label>
                            </td>
                            <?php } ?>
                            <!-- <td class="xCNPIBeHideMQSS"></td> -->
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
            <button onclick="JSvSOPDTDocDTTempClickPageMonitor('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>> 
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
                <button onclick="JSvSOPDTDocDTTempClickPageMonitor('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>
            <?php if($nPage >= $aDataDocDTTemp['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvSOPDTDocDTTempClickPageMonitor('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>> 
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
                    <button id="obtSOConfirmDeleteDTDis" type="button"  class="btn xCNBTNPrimery"><?php echo language('common/main/main', 'tModalConfirm');?></button>
                    <button id="obtSOCancelDeleteDTDis" type="button" class="btn xCNBTNDefult"><?php echo language('common/main/main', 'ยกเลิก');?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ================================================================================================================================= -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<?php  include("script/jSaleOrderPdtAdvTableDataMonitor.php");?>
