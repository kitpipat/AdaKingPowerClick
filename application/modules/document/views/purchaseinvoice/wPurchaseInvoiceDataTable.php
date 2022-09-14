<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbPITblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBChoose')?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBBchCreate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBDocNo')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBDocDate')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBStaDoc')?></th>
                        <!-- <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBStaApv')?></th> -->
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBStaPrc')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBCreateBy')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBApvBy')?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('common/main/main','tCMNActionDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						    <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <?php
                                $tPIDocNo  = $aValue['FTXphDocNo'];
                                if(!empty($aValue['FTXphStaApv']) || $aValue['FTXphStaDoc'] == 3){
                                    $tCheckboxDisabled = "disabled";
                                    $tClassDisabled = 'xCNDocDisabled';
                                    $tTitle = language('document/document/document','tDOCMsgCanNotDel');
                                    $tOnclick = '';
                                }else{
                                    $tCheckboxDisabled = "";
                                    $tClassDisabled = '';
                                    $tTitle = '';
                                    $tOnclick = "onclick=JSoPIDelDocSingle('".$nCurrentPage."','".$tPIDocNo."')";
                                }
    
                                // //FTXphStaDoc
                                // if($aValue['FTXphStaDoc'] == 1){
                                //     $tClassStaDoc = 'text-success';
                                // }else if($aValue['FTXphStaDoc'] == 2){
                                //     $tClassStaDoc = 'text-warning';    
                                // }else if($aValue['FTXphStaDoc'] == 3){
                                //     $tClassStaDoc = 'text-danger';
                                // }
    
                                // //FTXphStaApv
                                // if($aValue['FTXphStaApv'] == 1){
                                //     $tClassStaApv = 'text-success';
                                // }else if($aValue['FTXphStaApv'] == 2 || $aValue['FTXphStaApv'] == ''){
                                //     $tClassStaApv = 'text-danger';    
                                // }
                                if ($aValue['FTXphStaDoc'] == 3) {
                                    $tClassStaDoc = 'text-danger';
                                    $tStaDoc = language('common/main/main', 'tStaDoc3');
                                } else if ($aValue['FTXphStaApv'] == 1) {
                                    $tClassStaDoc = 'text-success';
                                    $tStaDoc = language('common/main/main', 'tStaDoc1');
                                } else {
                                    $tClassStaDoc = 'text-warning';
                                    $tStaDoc = language('common/main/main', 'tStaDoc');
                                }

                                if ($aValue['FTXphStaPrcStk'] == 1) {
                                    $tClassPrcStk = 'text-success';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                                } else if ($aValue['FTXphStaPrcStk'] == 2) {
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc2');
                                } else if ($aValue['FTXphStaPrcStk'] == 0 || $aValue['FTXphStaPrcStk'] == '') {
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                                }
                            ?>
                            <tr class="text-left xCNTextDetail2 xWPIDocItems" id="otrPurchaseInvoice<?php echo $nKey?>" data-code="<?php echo $aValue['FTXphDocNo']?>" data-name="<?php echo $aValue['FTXphDocNo']?>">
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled;?>>
                                            <span class="<?php echo $tClassDisabled?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>

                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTBchName']))? $aValue['FTBchName']   : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTXphDocNo']))? $aValue['FTXphDocNo'] : '-' ?></td>
                                <td nowrap class="text-center"><?php echo (!empty($aValue['FDXphDocDate']))? $aValue['FDXphDocDate'] : '-' ?></td>
                                <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tStaDoc; ?></label></td>

                                <!-- <td nowrap class="text-left">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>">
                                        <?php echo language('document/purchaseinvoice/purchaseinvoice','tPIStaDoc'.$aValue['FTXphStaDoc']) ?>
                                    </label>
                                </td>
                                <td nowrap class="text-left">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaApv;?>">
                                        <?php echo language('document/purchaseinvoice/purchaseinvoice','tPIStaApv'.$aValue['FTXphStaApv'])?>
                                    </label>
                                </td> -->
                                <td nowrap class="text-left">
                                    <label class="xCNTDTextStatus <?php echo $tClassPrcStk;?>">
                                    <?php echo $tStaPrcDoc; ?>
                                </label>
                                </td>

                                <td nowrap class="text-left">
                                        <?php echo (!empty($aValue['FTCreateByName']))? $aValue['FTCreateByName'] : '-' ?>
                                </td>

                                <td nowrap class="text-left">
                                    <?php echo (!empty($aValue['FTXphApvName']))? $aValue['FTXphApvName'] : '-' ?>
                                </td>

                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <img
                                            class="xCNIconTable xCNIconDel <?php echo $tClassDisabled?>"
                                            src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                            <?php echo $tOnclick?>
                                            title="<?php echo $tTitle?>"
                                        >
                                    </td>
                                <?php endif; ?>
                                
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <?php if($aValue['FTXphStaApv'] == 1 || $aValue['FTXphStaDoc'] == 3){ ?>
                                            <img class="xCNIconTable" style="width: 17px;" src="<?=base_url().'/application/modules/common/assets/images/icons/view2.png'?>" onClick="JSvPICallPageEditDoc('<?=$aValue['FTXphDocNo']?>')">
                                        <?php }else{ ?>
                                            <img class="xCNIconTable" src="<?=base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvPICallPageEditDoc('<?=$aValue['FTXphDocNo']?>')">
                                        <?php } ?>
                                    </td>
                                <?php endif; ?>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="row">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPIPageDataTable btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvPIClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvPIClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvPIClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
    <div id="odvPIModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelSingle" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>
<!-- ======================================================================================================================================== -->

<!-- ===================================================== Modal Delete Document Multiple =================================================== -->
    <div id="odvPIModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header xCNModalHead">
                    <label class="xCNTextModalHeard"><?php echo language('common/main/main','tModalDelete')?></label>
                </div>
                <div class="modal-body">
                    <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                    <input type='hidden' id="ohdConfirmIDDelMultiple">
                </div>
                <div class="modal-footer">
                    <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                    <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
                </div>
            </div>
        </div>
    </div>        
<!-- ======================================================================================================================================== -->
<?php include('script/jPurchaseInvoiceDataTable.php')?>

