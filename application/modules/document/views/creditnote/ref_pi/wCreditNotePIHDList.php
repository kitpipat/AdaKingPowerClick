<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<style>
    .xWPIHDDocItems:hover {
        cursor: pointer;
    }
    .xWPIHDDocItems.xCNActive {
        background-color: #179bfd !important;
    }
</style>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table id="otbPITblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
			<th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBDocNo')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBDocDate')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','ผู้จำหน่าย')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','วันครบกำหนด')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <?php
                                $tPIDocNo  = $aValue['FTXphDocNo'];
                                if($aValue['FTXphStaApv'] == 1 || $aValue['FTXphStaApv'] == 2 || $aValue['FTXphStaDoc'] == 3){
                                    $tCheckboxDisabled  = "disabled";
                                    $tClassDisabled     = "xCNDocDisabled";
                                    $tTitle             = language('document/document/document','tDOCMsgCanNotDel');
                                    $tOnclick           = '';
                                }else{
                                    $tCheckboxDisabled  = "";
                                    $tClassDisabled     = '';
                                    $tTitle             = '';
                                    $tOnclick           = "onclick=JSoPIDelDocSingle('".$nCurrentPage."','".$tPIDocNo."')";
                                }
                                
                                // Check Color Text Document Status Doc
                                switch($aValue['FTXphStaDoc']){
                                    case '1' :
                                        $tClassStaDoc   = 'text-success';
                                    break;
                                    case '2' :
                                        $tClassStaDoc   = 'text-warning';
                                    break;
                                    case '3':
                                        $tClassStaDoc   = 'text-danger';
                                    break;
                                    default:
                                        $tClassStaDoc   = "";
                                }

                                // Check Color Text Document Status Appove
                                if($aValue['FTXphStaApv'] == 1){
                                    $tClassStaApv   = 'text-success';
                                }else if($aValue['FTXphStaApv'] == 2){
                                    $tClassStaApv   = 'text-warning';    
                                }else if($aValue['FTXphStaApv'] == ''){
                                    $tClassStaApv   = 'text-danger';    
                                }

                                // heck Color Text Document Status Process Stock
                                if($aValue['FTXphStaPrcStk'] == 1){
                                    $tClassPrcStk   = 'text-success';
                                }else if($aValue['FTXphStaPrcStk'] == 2){
                                    $tClassPrcStk   = 'text-warning';
                                }else if($aValue['FTXphStaPrcStk'] == ''){
                                    $tClassPrcStk   = 'text-danger';    
                                }
                            ?>
                            <tr 
                                class="text-center xCNTextDetail2 xWPIHDDocItems" 
                                id="otrCreditNotePIHDDoc<?php echo $nKey?>" 
                                onclick="JSxCreditNoteSelectPIHDDOC(this)"
                                data-code="<?php echo $aValue['FTXphDocNo']?>"
                                data-wahcode="<?php echo $aValue['FTWahCode']?>"
                                data-wahname="<?php echo $aValue['FTWahName']?>"
                                data-shpcode="<?php echo $aValue['FTShpCode']?>"
                                data-shpname="<?php echo $aValue['FTShpName']?>"
                                data-splcode="<?php echo $aValue['FTSplCode']?>"
                                data-splname="<?php echo $aValue['FTSplName']?>"
                                data-vatinorex="<?php echo $aValue['FTXphVATInOrEx']?>"
                                data-daterefin="<?php echo date('Y-m-d', strtotime(str_replace('/', '-', $aValue['FDXphDocDate']))); ?>"
                                >
                                
                                <td class="text-left"><?php echo (!empty($aValue['FTXphDocNo']))? $aValue['FTXphDocNo']   : '-' ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FDXphDocDate']))? $aValue['FDXphDocDate'] : '-' ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FDXphDocDate']))? $aValue['FTSplName'] : '-' ?></td>
                                <td class="text-left"></td>
                                
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

<?php if($aDataList['rnAllPage'] > 1) : ?>
    <div class="row" id="odvCreditNotePIHDList">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvCreditNotePIHDClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvCreditNotePIHDClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>

                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvCreditNotePIHDClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
                    <i class="fa fa-chevron-right f-s-14 t-plus-1"></i>
                </button>
            </div>
        </div>
    </div>
<?php endif; ?>

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




































