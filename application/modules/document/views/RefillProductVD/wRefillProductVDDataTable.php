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
                            <th class="xCNTextBold" style="width:5%;"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBChoose')?></th>
                        <?php endif; ?>
                        <th class="xCNTextBold"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBBchCreate')?></th>
						<th class="xCNTextBold"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBDocNo')?></th>
                        <th class="xCNTextBold"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBDocDate')?></th>
                        <th class="xCNTextBold"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBStaDoc')?></th>
                        <th class="xCNTextBold"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBCreateBy')?></th>
                        <th class="xCNTextBold"><?=language('document/RefillProductVD/RefillProductVD','tRVDTBApvBy')?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionDelete')?></th>
                        <?php endif; ?>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
						    <th class="xCNTextBold" style="width:5%;"><?= language('common/main/main','tCMNActionEdit')?></th>
						<?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvRGPList">
                    <?php if($aDataList['rtCode'] == 1 ):?>
                    <?php 
                        if(FCNnHSizeOf($aDataList['raItems'])!=0){
                            foreach($aDataList['raItems'] AS $nKey => $aValue):?>
                                <?php
                                    $tDocumentNumber  =   $aValue['FTXthDocNo'];
                                    if($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaApv'] == 2 || $aValue['FTXthStaDoc'] == 3){
                                        $tCheckboxDisabled  = "disabled";
                                        $tClassDisabled     = "xCNDocDisabled";
                                        $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                        $tOnclick           = '';
                                    }else{
                                        $tCheckboxDisabled  = "";
                                        $tClassDisabled     = '';
                                        $tTitle             = '';
                                        $tOnclick           = "onclick=JSoRVDDelDocSingle('".$nCurrentPage."','".$tDocumentNumber."')";
                                    }
                                    
                                    //เช็คสถานะใหม่
                                    if($aValue['FTXthStaDoc'] == 3){ 
                                        //ยกเลิก
                                        $tTextStatus = language('document/RefillProductVD/RefillProductVD','tRVDStaDoc3');
                                        $tClassStaDoc = 'text-danger';
                                    }else if($aValue['FTXthStaApv'] == 1){ 
                                        //อนุมัติเเล้ว
                                        $tTextStatus = language('document/RefillProductVD/RefillProductVD','tRVDStaApv1');
                                        $tClassStaDoc = 'text-success';
                                    }else{ 
                                        //รออนุมัติ
                                        $tTextStatus = language('document/RefillProductVD/RefillProductVD','tRVDStaApv');
                                        $tClassStaDoc = 'text-warning';   
                                    }

                                ?>
                                <tr id="otrRVD<?= $nKey?>" class="text-center xCNTextDetail2 otrRVD" data-code="<?= $aValue['FTXthDocNo']?>" data-name="<?= $aValue['FTXthDocNo']?>">
                                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                        <td class="text-center">
                                            <label class="fancy-checkbox ">
                                                <input id="ocbListItem<?= $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?= $tCheckboxDisabled;?>>
                                                <span class="<?= $tClassDisabled?>">&nbsp;</span>
                                            </label>
                                        </td>
                                    <?php endif; ?>
                                    <td class="text-left"><?= (!empty($aValue['FTBchName']))? $aValue['FTBchName'] : '-' ?></td>
                                    <td class="text-left"><?= (!empty($aValue['FTXthDocNo']))? $aValue['FTXthDocNo'] : '-' ?></td>
                                    <td class="text-center"><?= (!empty($aValue['FDXthDocDate']))? $aValue['FDXthDocDate'] : '-' ?></td>
                                    <td class="text-left">
                                        <label class="xCNTDTextStatus <?= $tClassStaDoc;?>"><?= $tTextStatus ?></label>
                                    </td>
                                    <td class="text-left">
                                        <?= (!empty($aValue['FTCreateByName']))? $aValue['FTCreateByName'] : '-' ?>
                                    </td>
                                    <td class="text-left">
                                        <?= (!empty($aValue['FTXthStaApv']))? $aValue['FTXthApvName'] : '-' ?>
                                    </td>
                                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                        <td>
                                            <img
                                                class="xCNIconTable xCNIconDel <?= $tClassDisabled?>"
                                                src="<?=  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                                <?= $tOnclick?>
                                                title="<?= $tTitle?>"
                                            >
                                        </td>
                                    <?php endif; ?>
                                    <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                        <td>
                                            <?php if($aValue['FTXthStaApv'] == 1 || $aValue['FTXthStaDoc'] == 3){ ?>
                                                <img class="xCNIconTable" style="width: 17px;" src="<?=  base_url().'/application/modules/common/assets/images/icons/view2.png'?>" onClick="JSvRVDCallPageEdit('<?=$aValue['FTXthDocNo']?>')">
                                            <?php }else{ ?>
                                                <img class="xCNIconTable" src="<?=  base_url().'/application/modules/common/assets/images/icons/edit.png'?>" onClick="JSvRVDCallPageEdit('<?=$aValue['FTXthDocNo']?>')">
                                            <?php } ?>
                                        </td>
                                    <?php endif; ?>
                                </tr>
                            <?php endforeach;
                        } else{ ?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?= language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php } ?>
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
        <p><?= language('common/main/main','tResultTotalRecord')?> <?= $aDataList['rnAllRow']?> <?= language('common/main/main','tRecord')?> <?= language('common/main/main','tCurrentPage')?> <?= $aDataList['rnCurrentPage']?> / <?= $aDataList['rnAllPage']?></p>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="xWPageTWOPdt btn-toolbar pull-right">
            <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
            <button onclick="JSvTWOClickPage('previous')" class="btn btn-white btn-sm" <?= $tDisabledLeft ?>>
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
                <button onclick="JSvTWOClickPage('<?= $i?>')" type="button" class="btn xCNBTNNumPagenation <?= $tActive ?>" <?= $tDisPageNumber ?>><?= $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvTWOClickPage('next')" class="btn btn-white btn-sm" <?= $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- Modal Delete Document Single -->
<div id="odvRVDModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmRVDConfirmPdtDTTemp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!-- Modal Delete Document Multiple -->
<div id="odvRVDModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('common/main/main','tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelMultiple" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
                <input type='hidden' id="ohdConfirmIDDelMultiple">
            </div>
            <div class="modal-footer">
                <button id="osmConfirmDelMultiple" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?= language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?= language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<?php include('script/jRefillProductVDDataTable.php');?>