<style>
    .table > tbody > tr > td {
        vertical-align: middle;
    }
</style>

<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
    <div class="table-responsive">
        <table id="otbCSSPdtTableList" class="table xWPdtTableFont">
            <thead>
                <tr class="xCNCenter">
                    <th nowrap><?=language('document/document/document','tDocNumber')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtCode')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtName')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtBarCode')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtS/N')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtUnit')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtQty')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtSetPrice')?></th>
                    <th nowrap><?=language('document/document/document','tDocPdtDisChgTxt')?></th>
                    <th nowrap><?=language('document/document/document','tDocTotalCash')?></th>
                </tr>
            </thead>
            <tbody>
                <?php 
                    if($aDataDocDTTemp['tCode'] == 1){
                        foreach($aDataDocDTTemp['aItems'] as $nDataTableKey => $aDataVal){
                ?>
                            <tr class="text-center xCNTextDetail2 xWPdtItem" data-seqno="<?=$aDataVal['FNXsdSeqNo']?>" data-pdtcode="<?=$aDataVal['FTPdtCode']?>" data-pdtname="<?=$aDataVal['FTPdtName']?>" data-barcode="<?=$aDataVal['FTXsdBarCode']?>" >  
                                <td nowrap  class="text-center"><?=$aDataVal['FNXsdSeqNo']?></td>
                                <td nowrap  class="text-left"><?=$aDataVal['FTPdtCode']?></td>
                                <td nowrap  class="text-left"><?=$aDataVal['FTPdtName']?></td>
                                <td nowrap  class="text-left"><?=$aDataVal['FTXsdBarCode']?></td>
                                <td nowrap class="text-left xWCSSShwSNList">
                                <?php if( $aDataVal['FTXtdStaPrcStk'] == "3" || $aDataVal['FTXtdStaPrcStk'] == "4" ): ?>
                                    <a href="#" class="xWCSSViewPdtSN" ><u>หมายเลขซีเรียล</u></a> <!-- xWCSSEditPdtSN $aDataVal['FTPdtSerial']-->
                                <?php else: ?>
                                    <?="-"?>
                                <?php endif; ?>
                                </td>
                                <td nowrap  class="text-left"><?=$aDataVal['FTPunName']?></td>
                                <td nowrap  class="text-right"><?=number_format($aDataVal['FCXsdQty'],$nOptDecimalShow)?></td>
                                <td nowrap  class="text-right"><?=number_format($aDataVal['FCXsdSetPrice'],$nOptDecimalShow)?></td>
                                <td nowrap  class="text-left"><?=($aDataVal['FTXsdDisChgTxt'] == "" ? "-" : $aDataVal['FTXsdDisChgTxt'])?></td>
                                <td nowrap  class="text-right"><?=number_format($aDataVal['FCXsdNet'],$nOptDecimalShow)?></td>
                            </tr>
                <?php
                        }
                    }else{ 
                ?>
                    <tr><td class="text-center xCNTextDetail2 xWTWITextNotfoundDataPdtTable" colspan="100%"><?=language('common/main/main','tCMNNotFoundData')?></td></tr>
                <?php } ?>
            </tbody>
        </table>

    </div>
</div>

<!-- ================================================================= View Modal Product S/N ================================================================= -->
<div id="odvCSSModalViewPdtSN" class="modal fade" data-backdrop="static" data-keyboard="false" tabindex="-1" role="dialog" style="z-index: 7000;">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <!-- <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?= language('document/document/document','tDocPdtS/N'); ?></h5>
            </div> -->
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?= language('document/checkstatussale/checkstatussale', 'tDocPdtS/N') ?></label>
            </div>
            <div class="modal-body"></div>
            <div class="modal-footer">
                <button id="obtCSSModalViewPdtSNCancel" type="button" class="btn xCNBTNDefult"><?= language('common/main/main', 'tModalCancel'); ?></button>
            </div>
        </div>
    </div>
</div>
<!-- ============================================================================================================================================================== -->

<script src="<?php echo  base_url('application/modules/common/assets/js/jquery.mask.js')?>"></script>
<script src="<?php echo  base_url('application/modules/common/assets/src/jFormValidate.js')?>"></script>
<script>
    $('.xWCSSViewPdtSN').off('click').on('click',function(){
        // var tPdtCode    = $(this).parents().parents().attr('data-pdtcode');
        var nSeqNo      = $(this).parents().parents().attr('data-seqno');
        JSxCSSCallModalPdtSN(nSeqNo);
    });

    $('#obtCSSModalViewPdtSNCancel').off('click').on('click',function(){
        $('#odvCSSModalViewPdtSN').modal('hide');
        JSxCSSPageProductDataTable();
    });

    function JSxCSSCallModalPdtSN(pnSeqNo){
        // JCNxOpenLoading();
        $.ajax({
            type: "POST",
            url: "docCSSPagePdtSN",
            data: {
                ptTaxDocNo : $('#odvCSSDocNo').text(),
                pnSeqNo    : pnSeqNo
            },
            cache: false,
            timeout: 0,
            success: function(tHTML) {
                $('#odvCSSModalViewPdtSN .modal-body').html(tHTML);
                $('#odvCSSModalViewPdtSN').modal('show');
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

</script>