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
            <table id="otbRSTblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th nowrap class="xCNTextBold" style="width:5%;"><?php echo language('document/returnsale/returnsale','tRSTBChoose')?></th>
                        <?php endif; ?>
                        <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBBchCreate')?></th>
						<th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBDocNo')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBDocDate')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBStaDoc')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBStaPrc')?></th>
                        <!-- <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBFrmStaRef')?></th> -->
                        <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBCreateBy')?></th>
                        <th nowrap class="xCNTextBold"><?php echo language('document/returnsale/returnsale','tRSTBApvBy')?></th>
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
                                $tRSDocNo  = $aValue['FTXshDocNo'];
                                if(!empty($aValue['FTXshStaApv']) || $aValue['FTXshStaDoc'] == 3){
                                    $tCheckboxDisabled = "disabled";
                                    $tClassDisabled = 'xCNDocDisabled';
                                    $tTitle = language('document/document/document','tDOCMsgCanNotDel');
                                    $tOnclick = '';
                                }else{
                                    $tCheckboxDisabled = "";
                                    $tClassDisabled = '';
                                    $tTitle = '';
                                    $tOnclick = "onclick=JSoRSDelDocSingle('".$nCurrentPage."','".$tRSDocNo."')";
                                }
    
                                if ($aValue['FTXshStaDoc'] == 3) {
                                    $tNewProcess = language('document/returnsale/returnsale', 'tRSStaDoc3'); //ยกเลิก
                                    $tClassStaDoc = 'text-danger';
                                } else {
                                    if ($aValue['FTXshStaApv'] == 1) {
                                        $tNewProcess = language('document/returnsale/returnsale', 'tRSStaApv1'); //อนุมัติแล้ว
                                        $tClassStaDoc = 'text-success';
                                    } else {
                                        $tNewProcess = language('document/returnsale/returnsale', 'tRSStaApv'); //รออนุมัติ
                                        $tClassStaDoc = 'text-warning';
                                    }
                                }

                                // // เช็ค Text Color FTXthStaPrcStk
                                // if ($aValue['FTXshStaPrcStk'] == 1) {
                                //     $tClassPrcStk = 'text-success';
                                // } else if ($aValue['FTXshStaPrcStk'] == 2) {
                                //     $tClassPrcStk = 'text-warning';
                                // } else if ($aValue['FTXshStaPrcStk'] == '') {
                                //     // $tClassPrcStk = 'text-danger';
                                //     $tClassPrcStk = 'text-warning';
                                // } else {
                                //     $tClassPrcStk = "";
                                // }

                                if ($aValue['FTXshStaPrcStk'] == 1) {
                                    $tClassPrcStk = 'text-success';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc1');
                                } else if ($aValue['FTXshStaPrcStk'] == 2) {
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc2');
                                } else if ($aValue['FTXshStaPrcStk'] == 0 || $aValue['FTXshStaPrcStk'] == '') {
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                                }else{
                                    $tClassPrcStk = 'text-warning';
                                    $tStaPrcDoc = language('common/main/main', 'tStaPrcDoc3');
                                }
                          
                            ?>
                            <tr class="text-center xCNTextDetail2 xWPIDocItems" id="otrPurchaseInvoice<?php echo $nKey?>" data-code="<?php echo $aValue['FTXshDocNo']?>" data-name="<?php echo $aValue['FTXshDocNo']?>">
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap class="text-center">
                                        <label class="fancy-checkbox ">
                                            <input id="ocbListItem<?php echo $nKey?>" type="checkbox" class="ocbListItem" name="ocbListItem[]" <?php echo $tCheckboxDisabled;?>>
                                            <span class="<?php echo $tClassDisabled?>">&nbsp;</span>
                                        </label>
                                    </td>
                                <?php endif; ?>

                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTBchName']))? $aValue['FTBchName']   : '-' ?></td>
                                <td nowrap class="text-left"><?php echo (!empty($aValue['FTXshDocNo']))? $aValue['FTXshDocNo'] : '-' ?></td>
                                <td nowrap class="text-center"><?php echo (!empty($aValue['FDXshDocDate']))? $aValue['FDXshDocDate'] : '-' ?></td>
                                <td class="text-left"><label class="xCNTDTextStatus <?= $tClassStaDoc ?>"><?php echo $tNewProcess; ?></label></td>
                        
                                <td class="text-left">
                                        <label class="xCNTDTextStatus <?php echo $tClassPrcStk; ?>"><?php echo $tStaPrcDoc ?></label>
                                </td>
                                <!-- <td nowrap class="text-center">
                                    <label class="xCNTDTextStatus <?php echo $tClassStaRef;?>">
                                        <?php echo language('document/returnsale/returnsale','tRSLabelFrmStaRef'.$aValue['FNXshStaRef'])?>
                                    </label>
                                </td> -->
                          
                                <td nowrap class="text-center">
                                        <?php echo (!empty($aValue['FTCreateByName']))? $aValue['FTCreateByName'] : '-' ?>
                                </td>

                                <td nowrap class="text-center">
                                    <?php echo (!empty($aValue['FTXshApvName']))? $aValue['FTXshApvName'] : '-' ?>
                                </td>

                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                                    <td nowrap >
                                        <img
                                            class="xCNIconTable xCNIconDel <?php echo $tClassDisabled?>"
                                            src="<?php echo  base_url().'/application/modules/common/assets/images/icons/delete.png'?>"
                                            <?php echo $tOnclick?>
                                            title="<?php echo $tTitle?>"
                                        >
                                    </td>
                                <?php endif; ?>
                                
                                <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaRead'] == 1) : ?>
                                    <td nowrap>
                                        <?php if ($aValue['FTXshStaApv'] == 1 || $aValue['FTXshStaDoc'] == 3) { ?>
                                                <img class="xCNIconTable" style="width: 17px;" src="<?= base_url() . '/application/modules/common/assets/images/icons/view2.png' ?>" onClick="JSvRSCallPageEditDoc('<?= $aValue['FTXshDocNo'] ?>')">
                                            <?php } else { ?>
                                                <img class="xCNIconTable" src="<?= base_url() . '/application/modules/common/assets/images/icons/edit.png' ?>" onClick="JSvRSCallPageEditDoc('<?= $aValue['FTXshDocNo'] ?>')">
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
            <button onclick="JSvRSClickPageList('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                <button onclick="JSvRSClickPageList('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
            <?php } ?>

            <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
            <button onclick="JSvRSClickPageList('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
            </button>
        </div>
    </div>
</div>

<!-- ===================================================== Modal Delete Document Single ===================================================== -->
    <div id="odvRSModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
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
    <div id="odvRSModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
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
<?php include('script/jReturnSaleDataTable.php')?>

