<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <input type="text" class="xCNHide" id="ohdBrowseDataPdtCode" value="">
        <input type="text" class="xCNHide" id="ohdBrowseDataPunCode" value="">
        <input type="text" class="xCNHide" id="ohdEditInlinePdtCode" value="<?=$tSOPdtCode;?>">
        <input type="text" class="xCNHide" id="ohdEditInlinePunCode" value="<?=$tSOPunCode;?>">
        <table id="otbSODocPdtAdvTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th><?=language('document/saleorder/saleorder','tSOTBNo')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPConfirm')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPdtPhoto')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPdtImg')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPhotoCompere')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPdtCode')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPdtName')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPReson')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPdtQty')?></th>
                    <th><?=language('document/saleorder/saleorder','tSOARPPdtQty')?></th>
                </tr>
            </thead>
            <tbody id="odvTBodySOPdtAdvTableList">
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
                            <td><label><?=$aDataTableVal['rtRowID']?></label></td>
                            <td width="10%">

                                <?php  
                                    if($aDataTableVal['FTXsdStaPrcStk'] == 1 || $aDataTableVal['FTXsdStaPrcStk'] == 2){
                                        $tDisabled  = 'disabled';
                                        $tCondition = 'have';
                                    }else{
                                        $tDisabled  = '';
                                        $tCondition = 'none';
                                    }
                                ?>

                                <?php if($tCondition == 'have'){ ?>
                                    <?php 
                                    if($aDataTableVal['FTXsdStaPrcStk'] == 1){
                                       $tNameLabel = language('document/saleorder/saleorder','tApprovePDTByRole1'); 
                                    }else if($aDataTableVal['FTXsdStaPrcStk'] == 2){
                                        $tNameLabel = language('document/saleorder/saleorder','tApprovePDTByRole2'); 
                                    }
                                    ?>
                                    <span style="text-align: left; display: block;"><?=$tNameLabel?></span>
                                <?php }else{ ?>
                                    <div style="margin: 0px 0px 5px 0px;">
                                        <select class="selectpicker form-control xCNSelectApproveByRole" id="ocmPDTByRole<?=$aDataTableVal['rtRowID']?>" name="ocmPDTByRole[]" maxlength="1">
                                            <option value=""  data-seqcode="<?=$aDataTableVal['FNXtdSeqNo']?>" data-pdtcode="<?=$aDataTableVal['FTPdtCode'];?>" data-index="<?=$aDataTableVal['rtRowID'];?>" data-pdtcode="<?=$aDataTableVal['FNXtdSeqNo']?>"><?=language('document/saleorder/saleorder','tApprovePDTByRole0')?></option>
                                            <option value="1" data-seqcode="<?=$aDataTableVal['FNXtdSeqNo']?>" data-pdtcode="<?=$aDataTableVal['FTPdtCode'];?>" data-index="<?=$aDataTableVal['rtRowID'];?>" data-pdtcode="<?=$aDataTableVal['FNXtdSeqNo']?>"><?=language('document/saleorder/saleorder','tApprovePDTByRole1')?></option>
                                            <option value="2" data-seqcode="<?=$aDataTableVal['FNXtdSeqNo']?>" data-pdtcode="<?=$aDataTableVal['FTPdtCode'];?>" data-index="<?=$aDataTableVal['rtRowID'];?>" data-pdtcode="<?=$aDataTableVal['FNXtdSeqNo']?>"><?=language('document/saleorder/saleorder','tApprovePDTByRole2')?></option>
                                        </select>
                                    </div>
                                <?php } ?>
                            </td>
                                <?php
                                              if(isset($aDataTableVal['FTImgObj']) && !empty($aDataTableVal['FTImgObj'])){
                                                $tImgObj = substr($aDataTableVal['FTImgObj'],0,1);
                                                $tStyle  = "";
                                                // ตรวจสอบ Code Color Saharat(Golf)
                                                if($tImgObj != '#'){
                                                    $aValueImgExplode = explode('/modules/',$aDataTableVal['FTImgObj']);
                                                    $tFullPatch = './application/modules/'.$aValueImgExplode[1];
                                                    if (file_exists($tFullPatch)){
                                                        $tPatchImg = base_url().'application/modules/'.$aValueImgExplode[1];
                                                    }else{
                                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                                    }
                
                                                }else{  
                                                    $tPatchImg     = "0";
                                                    $tStyleName    = $aDataTableVal['FTImgObj'];
                                              }
                                            }else{
                                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                            }
                
                                ?>
                            <td nowrap class="xCNBorderRight xWPdtImgtd" width="15%">
                            <!-- ตรวจสอบว่าเป็น รูป หรือ สี  23/02/2020 Saharat(Golf)-->
                            <?php if($tPatchImg != '0') : ?>
                                <img src="<?php echo $tPatchImg;?>" class="img img-respornsive" style="width: 20%">
                            <?php else: ?>
                                <div class="text-center"> <span  style="height:40px;width:100%;background-color:<?php echo $tStyleName ?>;display:inline-block;"></span></div>
                            <?php endif; ?>
                            <!-- ecd ตรวจสอบว่าเป็น รูป หรือ สี -->
                             </td>
                            <td nowrap class="xCNBorderRight xWPdtImgtd" width="15%"><img src="" class="img img-respornsive oimSOPhotoShow" style="width: 20%"></td>
                            <td width="6%" align="left"><button type="button" class="btn btn-warning" onclick="JSxSOAPCompPareModalLoad(<?=$aDataTableVal['rtRowID']?>)" > A | B </button></td>
                            <td width="6%" align="left"><?=$aDataTableVal['FTPdtCode'];?></td>
                            <td width="20%" align="left"><?=$aDataTableVal['FTXtdPdtName'];?></td>
                            <td width="20%" align="right"><input <?=$tDisabled?> type="text" class="form-control"  name="oetSOAPReason[]" class="oetSOAPReason" id="oetSOAPReason<?=$aDataTableVal['rtRowID']?>"></td>
                            <td width="5%" align="center"><?=$aDataTableVal['FCXtdQty'];?></td>
                            <td width="5%" align="center"><?=$aDataTableVal['FCXtdQty'];?></td>
                        </tr>
                        <?php $nNumSeq++; ?>

                        <!-- ======================================================================== View Modal Appove Document  ======================================================================== -->
                        <div id="odvSOModalComparePdt<?=$aDataTableVal['rtRowID']?>" class="modal fade">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('document/saleorder/saleorder','tSOARPPhotoComperepdt'); ?></h5>
                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                            <span aria-hidden="true">&times;</span>
                                        </button>
                                    </div>
                                    <div class="col-md-12">
                                        <br>
                                        <div class="col-md-2">
                                            <p><strong><?php echo language('document/saleorder/saleorder','tSOARPPdtCode')?></strong></p>
                                            <p><?php echo $aDataTableVal['FTPdtCode'];?></p>
                                            <br>
                                        </div>
                                        <div class="col-md-10">
                                            <p><strong><?php echo language('document/saleorder/saleorder','tSOARPPdtName')?></strong></p>
                                            <p><?php echo $aDataTableVal['FTXtdPdtName'];?></p>
                                            <br>
                                        </div>
                                        <div class="col-md-6">
                                            <img src="<?php echo $tPatchImg;?>" class="img img-respornsive"  style="width: 100%;border: solid 1px;padding: 10px;">
                                        </div>
                                        <div class="col-md-6">
                                            <img src="" class="img img-respornsive oimSOPhotoShow"  style="width: 100%;border: solid 1px;padding: 10px;">
                                        </div>
                                    </div>
                                    <div class="modal-footer"></div>
                                </div>
                            </div>
                        </div>
                        <!-- ============================================================================================================================================================================= -->
                    <?php endforeach;?>
                <?php else:?>
                    <tr><td class="text-center xCNTextDetail2 xWPITextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
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

<script>
   var tPathPhoTo =  $('#ohdSOPatchPhoto').val();
   $('.oimSOPhotoShow').attr('src',tPathPhoTo);
   $('#odvSaleOrderEndOfBillMonitor').hide();
   $('#odvSOApAll').show();
   $('#oliSOTitleConimg').show();
   $('#oliSOTitleAprove').hide();

   $('.selectpicker').selectpicker();

</script>
