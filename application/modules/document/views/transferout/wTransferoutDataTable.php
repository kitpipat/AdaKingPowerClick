<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?php echo  language('document/transferout/transferout','tTXOTBChoose')?></th>
                        <?php endif; ?>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBBchCreate')?></th>
						<th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBDocNo')?></th>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBDocDate')?></th>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBStaDoc')?></th>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBStaApv')?></th>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBStaPrc')?></th>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBCreateBy')?></th>
                        <th class="xCNTextBold"><?php echo language('document/transferout/transferout','tTXOTBApvBy')?></th>

                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
                        <?php endif; ?>
                        
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						    <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <?php
                                $tTXODocNo  = $aValue['FTXthDocNo'];
                                if($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaApv'] == 2 || $aValue['FTXthStaDoc'] == 3){
                                    $tCheckboxDisabled  = "disabled";
                                    $tClassDisabled     = "xCNDocDisabled";
                                    $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                    $tOnclick           = '';
                                }else{
                                    $tCheckboxDisabled  = "";
                                    $tClassDisabled     = '';
                                    $tTitle             = '';
                                    $tOnclick           = "onclick=JSnTXODelDocSingle('".$nCurrentPage."','".$tTXODocNo."')";
                                }

                                //FTXthStaDoc
                                if($aValue['FTXthStaDoc'] == 1){
                                    $tClassStaDoc = 'text-success';
                                }else if($aValue['FTXthStaDoc'] == 2){
                                    $tClassStaDoc = 'text-warning';    
                                }else if($aValue['FTXthStaDoc'] == 3){
                                    $tClassStaDoc = 'text-danger';
                                }

                                //FTXthStaApv
                                if($aValue['FTXthStaApv'] == 1){
                                    $tClassStaApv = 'text-success';
                                }else if($aValue['FTXthStaApv'] == 2){
                                    $tClassStaApv = 'text-warning';    
                                }else if($aValue['FTXthStaApv'] == ''){
                                    $tClassStaApv = 'text-danger';    
                                }

                                //FTXthStaPrcStk
                                if($aValue['FTXthStaPrcStk'] == 1){
                                    $tClassPrcStk = 'text-success';
                                }else if($aValue['FTXthStaPrcStk'] == 2){
                                    $tClassPrcStk = 'text-warning';
                                }else if($aValue['FTXthStaPrcStk'] == ''){
                                    $tClassPrcStk = 'text-danger';    
                                }
                            ?>
                            <tr class="text-center xCNTextDetail2 otrTransferout" id="otrTransferout<?php echo $nKey?>" data-code="<?php echo $aValue['FTXthDocNo']?>" data-name="<?php echo $aValue['FTXthDocNo']?>">
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled;?>>
                                            <span class="<?php echo $tClassDisabled?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>
                                <td class="text-left"><?php echo (!empty($aValue['FTBchName']))? $aValue['FTBchName'] : '-' ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FTXthDocNo']))? $aValue['FTXthDocNo'] : '-' ?></td>
                                <td class="text-center"><?php echo (!empty($aValue['FDXthDocDate']))? $aValue['FDXthDocDate'] : '-' ?></td>
                                <td class="text-center">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaDoc;?>"><?php echo language('document/transferout/transferout','tTXOStaDoc'.$aValue['FTXthStaDoc']) ?></label>
                                </td>
                                <td class="text-center">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaApv;?>"><?php echo language('document/transferout/transferout','tTXOStaApv'.$aValue['FTXthStaApv'])?></label>
                                </td>
                                <td class="text-center">
                                    <label class="xCNTDTextStatus <?php echo $tClassPrcStk;?>"><?php echo language('document/transferout/transferout','tTXOStaPrcStk'.$aValue['FTXthStaPrcStk']) ?></label>
                                </td>
                                <td class="text-center">
                                    <?php echo (!empty($aValue['FTCreateByName']))? $aValue['FTCreateByName'] : '-' ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (!empty($aValue['FTXthApvName']))? $aValue['FTXthApvName'] : '-' ?>
                                </td>

                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td>
                                        <img
                                            class="xCNIconTable xCNIconDel <?php echo $tClassDisabled?>"
                                            src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                            <?php echo $tOnclick?>
                                            title="<?php echo $tTitle?>"
                                        >
                                    </td>
                                <?php endif; ?>

                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td>
                                        <img class="xCNIconTable xCNIconEdit" onClick="JSvTXOCallPageEdit('<?php echo $aValue['FTXthDocNo']?>')">
                                    </td>
                                <?php endif; ?>

                            </tr>
                        <?php endforeach; ?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
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
        <div class="xWPage btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTXOClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvTXOClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTXOClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
    <div id="odvTxoModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
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
    <div id="odvTxoModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
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
<?php include('script/jTransferoutDataTable.php')?>



