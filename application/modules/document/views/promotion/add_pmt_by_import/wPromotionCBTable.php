<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped xCNPosImportTabble" id="otbPromotionImportExcelCBTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'tCMNChoose'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'tCMNSequence'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel29'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tPurchaseConditions'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel53'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel55'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel56'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;text-align:center;"><?php echo  language('common/main/main', 'tRemark'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'tCMNActionDelete'); ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalImportPromotionCBDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal xCNPromotionCBConfirmDeltelLabel" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xCNPromotionCBImpConfirm"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult xCNPromotionCBImpCancel"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<?php include('script/jPromotionCBTable.php'); ?>