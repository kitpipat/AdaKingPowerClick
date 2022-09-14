<?php
    if($aDataList['rtCode'] == '1'){
        $nCurrentPage   = $aDataList['rnCurrentPage'];
    }else{
        $nCurrentPage = '1';
    }
?>
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <label class="xCNLabelFrm xWFont-size-30px"><?php echo language('document/purchaseinvoice/purchaseinvoice','รายละเอียด')?></label>
        <div class="table-responsive">
            <table id="otbPITblDataDocHDList" class="table table-striped">
                <thead>
                    <tr class="xCNCenter">
                        <th class="xCNTextBold" style="width:5%;"><?php echo language('document/purchaseinvoice/purchaseinvoice','tPITBChoose')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','รหัสสินค้า')?></th>
			<th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','ชื่อสินค้า')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','หน่วย')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','จำนวน')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','ราคา/หน่วย')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','ส่วนลด')?></th>
                        <th class="xCNTextBold"><?php echo language('document/purchaseinvoice/purchaseinvoice','จำนวนเงินรวม')?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php if($aDataList['rtCode'] == 1 ):?>
                        <?php foreach($aDataList['raItems'] AS $nKey => $aValue): ?>
                            <tr 
                                class="text-center xCNTextDetail2 xWPIDTDocItems" 
                                id="otrCreditNotePIDTDoc<?php echo $aValue['FNRowID']; ?>" 
                                data-code="<?php echo $aValue['FTPdtCode']?>" 
                                data-barcode="<?php echo $aValue['FTXpdBarCode']?>"
                                data-puncode="<?php echo $aValue['FTPunCode']?>"
                                data-price="<?php echo $aValue['FCXpdSetPrice']?>"
                                data-qty="<?php echo $aValue['FCXpdQty']?>"
                                data-vatrate="<?php echo $aValue['FCXpdVatRate']?>"
                                data-vatcode="<?php echo $aValue['FTVatCode']?>">
                                <td>
                                    <div class="form-group" style="margin-bottom: 0px !important;">
                                        <label class="fancy-checkbox">
                                            <input type="checkbox" checked="true" class="xWCreditNoteSelectPIDTItem">
                                            <span>&nbsp;</span>
                                        </label>
                                    </div>
                                </td>
                                <td class="text-left"><?php echo (!empty($aValue['FTPdtCode']))? $aValue['FTPdtCode']   : '-' ?></td>
                                <td class="text-left"><?php echo (!empty($aValue['FTXpdPdtName']))? $aValue['FTXpdPdtName'] : '-' ?></td>
                                <td class="text-center"><?php echo (!empty($aValue['FTPunName']))? $aValue['FTPunName'] : '-' ?></td>
                                <td class="text-center">
                                    <?php echo (!empty($aValue['FCXpdQty']))? $aValue['FCXpdQty'] : '0.00' ?>
                                </td>
                                <td class="text-center">
                                    <?php echo (!empty($aValue['FCXpdSetPrice']))? $aValue['FCXpdSetPrice'] : '0.00' ?>
                                </td>                                
                                <td class="text-center"><?php echo (!empty($aValue['FTXpdDisChgTxt']))? $aValue['FTXpdDisChgTxt'] : '' ?></td>
                                <td class="text-center">
                                    <?php echo (!empty($aValue['FCXpdNet']))? $aValue['FCXpdNet'] : '0.00' ?>
                                </td>
                            </tr>
                        <?php endforeach;?>
                    <?php else:?>
                        <tr><td class='text-center xCNTextDetail2' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                    <?php endif;?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="col-xs-2 col-sm-2 col-md-2 col-lg-2">
        <!-- เลือก -->
        <div class="form-group">
            <label class="fancy-checkbox">
                <input type="checkbox" value="1" id="ocbCreditNoteSelectAll" name="ocbCreditNoteSelectAll" maxlength="1" checked="true" onclick="JSxCreditNoteSelectPIDTAll(this)">
                <span>&nbsp;</span>
                <span class="xCNLabelFrm"><?php echo language('document/purchaseorder/purchaseorder', 'เลือกทั้งหมด'); ?></span>
            </label>
        </div>
        <!-- เลือก -->
    </div>
</div>
<?php if($aDataList['rnAllPage'] > 1) : ?>
    <div class="row" id="odvCreditNotePIDTList">
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <p><?php echo language('common/main/main','tResultTotalRecord')?> <?php echo $aDataList['rnAllRow']?> <?php echo language('common/main/main','tRecord')?> <?php echo language('common/main/main','tCurrentPage')?> <?php echo $aDataList['rnCurrentPage']?> / <?php echo $aDataList['rnAllPage']?></p>
        </div>
        <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
            <div class="xWPage btn-toolbar pull-right">
                <?php if($nPage == 1){ $tDisabledLeft = 'disabled'; }else{ $tDisabledLeft = '-';} ?>
                <button onclick="JSvCreditNotePIDTClickPage('previous')" class="btn btn-white btn-sm" <?php echo $tDisabledLeft ?>>
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
                    <button onclick="JSvCreditNotePIDTClickPage('<?php echo $i?>')" type="button" class="btn xCNBTNNumPagenation <?php echo $tActive ?>" <?php echo $tDisPageNumber ?>><?php echo $i?></button>
                <?php } ?>

                <?php if($nPage >= $aDataList['rnAllPage']){  $tDisabledRight = 'disabled'; }else{  $tDisabledRight = '-';  } ?>
                <button onclick="JSvCreditNotePIDTClickPage('next')" class="btn btn-white btn-sm" <?php echo $tDisabledRight ?>>
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













































