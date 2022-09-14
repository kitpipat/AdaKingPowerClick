<style>
    .xCNPanelHD{
        border: 1px solid #d7d7d7 !important; 
    }

    .xCNTextStatusBold{
        font-weight: bold !important;
    }
</style>

<div class="panel-body">
    <div class="row" style="margin-top: -35px !important;">
        <!--ส่วนบน-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div class="col-lg-4 text-left"></div>
            <div class="col-lg-8 text-right">
                <label class="xCNLabelFrm"></label>
                <div class="form-group">
                    <button id="obtSMTBack" class="btn btn-primary" type="button" style="font-size:17px !important;background-color: #D4D4D4 !important;color: #000000 !important;border-color: #D4D4D4 !important;"><?= language('common/main/main', 'tBack') ?></button>
                    <?php if( isset($aDataShfHD['aItems']['FTShdStaPrc']) && !empty($aDataShfHD['aItems']['FTShdStaPrc']) && $aDataShfHD['aItems']['FTShdStaPrc'] == '1' ){ ?>
                        <button id="obtSMTExport" class="btn btn-primary" type="button" style="font-size:17px !important;background-color: #D4D4D4 !important;color: #000000 !important;border-color: #D4D4D4 !important;"><?=language('common/main/main', 'ส่งออก') ?></button>
                    <?php } ?>
                    <?php if( isset($aDataShfHD['aItems']['FTShdStaPrc']) && empty($aDataShfHD['aItems']['FTShdStaPrc']) ){ ?>
                        <button id="obtSMTApv" class="btn btn-primary" type="button" style="font-size:17px !important;"><?= language('common/main/main', 'อนุมัติ') ?></button>
                    <?php } ?>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <input type="hidden" id="ohdSMTStaPrc" value="<?=$aDataShfHD['aItems']['FTShdStaPrc']?>">
            <input type="hidden" id="ohdSMTBchCode" value="<?=$aDataShfHD['aItems']['FTBchCode']?>">
            <input type="hidden" id="ohdSMTShfCode" value="<?=$aDataShfHD['aItems']['FTShfCode']?>">
            <div class="xCNPanelHD" >
                <div class="row">
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="xCNPanelHDTitle xCNPanelHeadColor">
                            <span style="color: #FFF; padding: 15px;"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftDT')?></span>
                        </div>
                    </div>
                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                        <div class="xCNPanelHDDetail row" style="padding: 15px;">
                            <div class="col-lg-3">
                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTBchName')?></label><br>
                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTPos')?></label><br>
                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftUsrCode')?></label><br>
                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTShiftCode1')?></label><br>
                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTSign-in')?></label><br>
                                <label class="xCNLabelFrm"><?=language('sale/salemonitor/salemonitor', 'tSMTSign-out')?></label><br>
                                <?php if( $aDataShfHD['aItems']['FTShdStaPrc'] == '1' ){ ?>
                                    <label class="xCNLabelFrm"><?=language('document/document/document', 'tDocApvBy')?></label><br>
                                <?php } ?>
                            </div>
                            <div class="col-lg-9" style="border-left: 1px solid #d7d7d7;">
                                <label class="xCNLabelFrm"><?="(".$aDataShfHD['aItems']['FTBchCode'].") ".$aDataShfHD['aItems']['FTBchName']?></label><br>
                                <label class="xCNLabelFrm"><?="(".$aDataShfHD['aItems']['FTPosCode'].") ".$aDataShfHD['aItems']['FTPosName']?></label><br>
                                <label class="xCNLabelFrm"><?="(".$aDataShfHD['aItems']['FTUsrCode'].") ".$aDataShfHD['aItems']['FTUsrName']?></label><br>
                                <label class="xCNLabelFrm"><?=$aDataShfHD['aItems']['FTShfCode']?></label><br>
                                <label class="xCNLabelFrm"><?=date('d/m/Y H:i:s',strtotime($aDataShfHD['aItems']['FDShdSignIn']))?></label><br>
                                <label class="xCNLabelFrm"><?=date('d/m/Y H:i:s',strtotime($aDataShfHD['aItems']['FDShdSignOut']))?></label><br>
                                <?php if( $aDataShfHD['aItems']['FTShdStaPrc'] == '1' ){ ?>
                                    <label class="xCNLabelFrm"><?="(".$aDataShfHD['aItems']['FTUsrApvCode'].") ".$aDataShfHD['aItems']['FTUsrApvName']?></label><br>
                                <?php } ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!--ส่วนตาราง-->
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="odvSMTPanelRcvApv" style="margin-top: 10px;"></div>
        </div>

    </div>
</div>

<!-- ================================================== Modal Confirm Appove ================================================== --> 
<div id="odvSMTModalAppoveDoc" class="modal fade xCNModalApprove">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="xCNHeardModal modal-title" style="display:inline-block"><?php echo language('common/main/main','tApproveTheDocument'); ?></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p><?php echo language('common/main/main','tMainApproveStatus'); ?></p>
                    <ul>
                        <li><?php echo language('common/main/main','tMainApproveStatus1'); ?></li>
                        <li><?php echo language('common/main/main','tMainApproveStatus2'); ?></li>
                        <li><?php echo language('common/main/main','tMainApproveStatus3'); ?></li>
                        <li><?php echo language('common/main/main','tMainApproveStatus4'); ?></li>
                    </ul>
                <p><?php echo language('common/main/main','tMainApproveStatus5'); ?></p>
                <p><strong><?php echo language('common/main/main','tMainApproveStatus6'); ?></strong></p>
            </div>
            <div class="modal-footer">
                <button onclick="JSxSMTApproveDocument(true)" type="button" class="btn xCNBTNPrimery">
                    <?php echo language('common/main/main', 'tModalConfirm'); ?>
                </button>
                <button type="button" class="btn xCNBTNDefult" data-dismiss="modal">
                    <?php echo language('common/main/main', 'tModalCancel'); ?>
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    JSxSMTShiftRcvDataList();

    //Create By : Napat(Jame) 25/03/2022
    function JSxSMTShiftRcvDataList(){
        $.ajax({
            type: "POST",
            url: "salemonitorShiftRcvDataList",
            data: {
                ptShfCode: $('#ohdSMTShfCode').val(),
                ptBchCode: $('#ohdSMTBchCode').val()
            },
            cache: false,
            timeout: 0,
            success: function(tResultHTML) {
                $('#odvSMTPanelRcvApv').html(tResultHTML);
                JCNxCloseLoading();
            },
            error: function(jqXHR, textStatus, errorThrown) {
                JCNxResponseError(jqXHR, textStatus, errorThrown);
            }
        });
    }

    //Create By : Napat(Jame) 25/03/2022
    $('#obtSMTBack').off('click').on('click',function(){
        JSvSMTSALPageDashBoardMain();
    });

    //Create By : Napat(Jame) 30/03/2022
    $('#obtSMTExport').off('click').on('click',function(){
        let tURL = "salemonitorShiftRcvExport?ptShfCode="+$('#ohdSMTShfCode').val()+"&ptBchCode="+$('#ohdSMTBchCode').val();
        window.open(tURL,'_blank');
    });

    //Create By : Napat(Jame) 31/03/2022
    $('#obtSMTApv').off('click').on('click',function(){
        JSxSMTApproveDocument(false);
    });

    function JSxSMTApproveDocument(pbAction){
        if( pbAction ){
            $("#odvSMTModalAppoveDoc").modal("hide");
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            JCNxOpenLoading();
            var tShfCode = $('#ohdSMTShfCode').val();
            var tBchCode = $('#ohdSMTBchCode').val();
            $.ajax({
                type: "POST",
                url: "salemonitorEventShiftApprove",
                data: {
                    ptShfCode: tShfCode,
                    ptBchCode: tBchCode
                },
                cache: false,
                timeout: 0,
                success: function(oResult){
                    var aReturnData = JSON.parse(oResult);
                    if( aReturnData['tCode'] == '1' ){
                        JSxSMTShiftPageEdit(tBchCode,tShfCode);
                    }else{
                        FSvCMNSetMsgWarningDialog(aReturnData['tDesc']);
                    }
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    JCNxResponseError(jqXHR, textStatus, errorThrown);
                }
            });
        }else{
            $('#odvSMTModalAppoveDoc').modal({backdrop:'static',keyboard:false});
            $("#odvSMTModalAppoveDoc").modal("show");
        }
    }
    
    
</script>