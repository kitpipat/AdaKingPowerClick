<div class="row">
    <div class="col-md-12">
        <div class="table-responsive">
            <table class="table table-striped xCNPosImportTabble" id="otbPromotionImportExcelPdtGroupTable">
                <thead>
                    <tr>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'tCMNChoose'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;text-align:center;"><?php echo  language('document/promotion/promotion', 'tTBNo'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel28'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel29'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel30'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:20%;text-align:center;"><?php echo language('document/promotion/promotion', 'tLabel31'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:10%;text-align:center;"><?php echo  language('common/main/main', 'tRemark'); ?></th>
                        <th nowrap class="xCNTextBold text-center" style="width:5%;text-align:center;"><?php echo  language('common/main/main', 'tCMNActionDelete'); ?></th>
                    </tr>
                </thead>
            </table>
        </div>
    </div>
</div>

<div class="modal fade" id="odvModalImportPromotionPdtGroupDelete">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header xCNModalHead">
                <label class="xCNTextModalHeard"><?php echo language('common/main/main', 'tModalDelete') ?></label>
            </div>
            <div class="modal-body">
                <span class="xCNTextModal xCNPromotionPdtGroupConfirmDeltelLabel" style="display: inline-block; word-break:break-all"></span>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn xCNBTNPrimery xCNPromotionPdtGroupImpConfirm"><?php echo language('common/main/main', 'tModalConfirm') ?></button>
                <button type="button" class="btn xCNBTNDefult xCNPromotionPdtGroupImpCancel"><?php echo language('common/main/main', 'tModalCancel') ?></button>
            </div>
        </div>
    </div>
</div>

<?php include('script/jPromotionPdtGroupTable.php'); ?>