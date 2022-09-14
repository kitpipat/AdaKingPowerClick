<style>
    #odvRowDataEndOfBill .panel-heading{
        padding-top     : 10px !important;
        padding-bottom  : 10px !important;
    }
    #odvRowDataEndOfBill .panel-body{
        padding-top     : 0px !important;
        padding-bottom  : 0px !important;
    }
    #odvRowDataEndOfBill .list-group-item {
        padding-left    : 0px !important;
        padding-right   : 0px !important;
        border          : 0px solid #ddd;
    }
    .mark-font, .panel-default > .panel-heading.mark-font{
        color           : #232C3D !important;
        font-weight     : 900;
    }

    .xCNBTNPrimeryDisChgPlus{
        border-radius   : 50%;
        float           : left;
        width           : 20px;
        height          : 20px;
        line-height     : 20px;
        background-color: #1eb32a;
        text-align      : center;
        margin-top      : 6px;
        font-size       : 22px;
        color           : #ffffff;
        cursor          : pointer;
        -webkit-border-radius   : 50%;
        -moz-border-radius      : 50%;
        -ms-border-radius       : 50%;
        -o-border-radius        : 50%;
    }
</style>

<!--ส่วนตารางสินค้า-->
<div class="row">
    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
        <div class="table-responsive">
            <table class="table table-striped" id="otbTablePDTTmp">
                <thead>
                    <tr class="xCNCenter">
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
                            <th class="xCNTextBold" style="width:5%;"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_choose')?></th>
                        <?php endif; ?>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_num')?></th>
						<th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_pdtcode')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_pdtname')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_barcode')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_unit')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_qty')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_price')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_discount')?></th>
                        <th class="xCNTextBold"><?=language('document/purchaseorderNew/purchaseorderNew','tPOTable_grand')?></th>
                        <?php if($aAlwEvent['tAutStaFull'] == 1 || $aAlwEvent['tAutStaDelete'] == 1) : ?>
							<th class="xCNTextBold" style="width:5%;"><?= language('document/adjuststock/adjuststock','tPOTable_delete')?></th>
                        <?php endif; ?>
                    </tr>
                </thead>
                <tbody id="odvTmpList">
                    <tr><td class='text-center xCNTextDetail2 xCNTextNotfoundDataPdtTable' colspan='100%'><?php echo language('common/main/main','tCMNNotFoundData')?></td></tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<!--ส่วนสรุปท้ายบิล-->
<div class="row" id="odvRowDataEndOfBill">
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-heading mark-font" id="odvDataTextBath"></div>
        </div>
        <div class="panel panel-default">
            <div class="panel-heading">
                <div class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBVatRate');?></div>
                <div class="pull-right mark-font"><?=language('document/saleorder/saleorder','tSOTBAmountVat');?></div>
                <div class="clearfix"></div>
            </div>
            <div class="panel-body">
                <ul class="list-group" id="oulDataListVat">
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBTotalValVat');?></label>
                <label class="pull-right mark-font" id="olbVatSum">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6">
        <div class="panel panel-default">
            <div class="panel-body">
                <ul class="list-group">
                    <li class="list-group-item">
                        <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBSumFCXtdNet');?></label>
                        <input type="text" id="olbSumFCXtdNetAlwDis" style="display:none;"></label>
                        <label class="pull-right mark-font" id="olbSumFCXtdNet">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/saleorder/saleorder','tSOTBDisChg');?>
                            <button type="button" class="xCNBTNPrimeryDisChgPlus" onclick="JCNLoadPanelDisChagHD(this)" style="float: right; margin-top: 3px; margin-left: 5px;">+</button>
                        </label>
                        <label class="pull-left" style="margin-left: 5px;" id="olbDisChgHD"></label>
                        <label class="pull-right" id="olbSumFCXtdAmt">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/saleorder/saleorder','tSOTBSumFCXtdNetAfHD');?></label>
                        <label class="pull-right" id="olbSumFCXtdNetAfHD">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                    <li class="list-group-item">
                        <label class="pull-left"><?=language('document/saleorder/saleorder','tSOTBSumFCXtdVat');?></label>
                        <label class="pull-right" id="olbSumFCXtdVat">0.00</label>
                        <div class="clearfix"></div>
                    </li>
                </ul>
            </div>
            <div class="panel-heading">
                <label class="pull-left mark-font"><?=language('document/saleorder/saleorder','tSOTBFCXphGrand');?></label>
                <label class="pull-right mark-font" id="olbCalFCXphGrand">0.00</label>
                <div class="clearfix"></div>
            </div>
        </div>
    </div>
</div>

<!--ลบสินค้าแบบตัวเดียว-->
<div id="odvModalDelDocSingle" class="modal fade" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete')?></label>
            </div>
            <div class="modal-body">
                <span id="ospTextConfirmDelSingle" class="xCNTextModal" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button id="osmTWIConfirmPdtDTTemp" class="btn xCNBTNPrimery xCNBTNPrimery2Btn" type="button"><?php echo language('common/main/main', 'tModalConfirm')?></button>
                <button class="btn xCNBTNDefult xCNBTNDefult2Btn" type="button"  data-dismiss="modal"><?php echo language('common/main/main', 'tModalCancel')?></button>
            </div>
        </div>
    </div>
</div>

<!--ลบสินค้าแบบหลายตัว-->
<div id="odvModalDelDocMultiple" class="modal fade" tabindex="-1" role="dialog">
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

<!--ทำรายการส่วนลด-->
<div id="odvModalDiscount" class="modal fade" tabindex="-1" role="dialog" style="max-width: 1500px; margin: 1.75rem auto; width: 85%;">
    <div class="modal-dialog" style="width: 100%;">
        <div class="modal-content">
                <!--ส่วนหัว-->
                <div class="modal-header">
                    <h5 class="xCNHeardModal modal-title" style="display:inline-block">ส่วนลด/ชาร์จ ท้ายบิล</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>

                <!--รายละเอียด-->
                <div class="modal-body">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="btn-group pull-right" style="margin-bottom: 20px; width: 300px;">
                                <button 
                                    type="button" 
                                    id="obtAddDisChg" 
                                    class="btn xCNBTNPrimery pull-right" 
                                    onclick="JCNvAddDisChgRow()" 
                                    style="width: 100%;"><?=language('document/purchaseinvoice/purchaseinvoice','tPIMDAddEditDisChg') ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <div class="table-responsive" style="min-height: 300px; max-height: 300px; overflow-y: scroll;">
                                <table id="otbDisChgDataDocHDList" class="table">
                                    <thead>
                                        <tr class="xCNCenter">
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIsequence')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIBeforereducing')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIValuereducingcharging')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIAfterReducing')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIType')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPIDiscountcharge')?></th>
                                            <th class="xCNTextBold"><?=language('document/purchaseinvoice/purchaseinvoice','tPITBDelete')?></th>
                                        </tr>    
                                    </thead>
                                    <tbody>
                                        <tr class="otrDisChgHDNotFound"><td class="text-center xCNTextDetail2" colspan='100%'><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                <!--ปุ่มยืนยันหรือยกเลิก-->
                <div class="modal-footer">
                    <button type="button" class="btn xCNBTNDefult" data-dismiss="modal"><?=language('common/main/main','tCancel');?></button>
                    <button onclick="JSxDisChgSave()" type="button" class="btn xCNBTNPrimery"><?=language('common/main/main','tCMNOK');?></button>
                </div>
            </div>
        </div>
    </div>
</div>