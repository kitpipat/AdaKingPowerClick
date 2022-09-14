<script>
    JSxZNESeat('<?= $nLocID ?>', '<?= $nLevID ?>', '<?= $nZneID ?>');
</script>
    <div class="row">
        <div class="xCNBCMenu xWHeaderMenu">
            <div class="row">
                <div class="col-md-12">
                    <span onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranch')"><?= language('ticket/park/park', 'tBranchInformation') ?></span> / <span onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocation/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></span> / <span onclick="JSxCallPage('<?php echo base_url(); ?>EticketZone/<?= $nLocID ?>')"><?= language('ticket/zone/zone', 'tZoneInformation') ?></span> / <?= language('ticket/zone/zone', 'tSeatInformation') ?>
                </div>
            </div>
        </div>
        <div class="main-content">
            <div class="container-fluid">				
                <div class="row">
                    <div class="col-md-12">		
                        <div class="row" style="margin-left: -15px; margin-right: -15px;">
                            <div class="col-md-6 col-sm-6 col-xs-6">
                                <h4 style="margin-bottom: 15px;">
                                    <?php echo $oShow[0]->FTZneName; ?> / <?= language('ticket/zone/zone', 'tSeat') ?>
                                </h4>
                            </div>
                            <?php /* if ($oAuthen[0]->FTGadStaAlwW == '1'): ?>
                              <div class="col-md-6 col-sm-6 col-xs-6">
                              <button type="button" class="btn btn-outline-primary pull-right" id="oBtnAddSeat" <?php if (@$oRow[0]->FNLocID == ""){echo ' style="display: none;"';} ?> data-toggle="modal" data-target="#modal-add-seat">+ <?= language('ticket/zone/zone', 'tAddSeat') ?></button>
                              </div>
                              <?php endif; */ ?>
                        </div>		
                    </div>
                </div>
                <div class="xWwrapBox"></div>
            </div>
        </div>
    </div>
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
<input type="hidden" id="ohdSetFNZneRow" value="<?php echo $oShow[0]->FNZneRow; ?>">
<input type="hidden" id="ohdSetFNZneCol" value="<?php echo $oShow[0]->FNZneCol; ?>">
<input type="hidden" id="ohdSetFNZneRowStart" value="<?php echo $oShow[0]->FNZneRowStart; ?>">
<input type="hidden" id="ohdFNZneColStart" value="<?php echo $oShow[0]->FNZneColStart; ?>">
<input type="hidden" id="ohdFNLocIDSet" value="<?php echo $oShow[0]->FNLocID; ?>">
<input type="hidden" id="ohdFNLevIDSet" value="<?php echo $oShow[0]->FNLevID; ?>">
<input type="hidden" id="ohdFNZneIDSet" value="<?php echo $oShow[0]->FNZneID; ?>">

<script type="text/javascript" src="<?php echo base_url() ?>application/modules/ticket/assets/src/zone/jZone.js"></script>
<script>
    $('.xWNameSlider').addClass('xWshow');
    function JSxMODHidden() {
        $('#odvModelData').slideToggle();
        setTimeout(function () {
            if ($('#odvModelData').css('display') == 'block') {

                $('#ospSwitchPanelModel').html('<i class="fa fa-chevron-up" aria-hidden="true"></i>');
            } else if ($('#odvModelData').css('display') == 'none') {

                $('#ospSwitchPanelModel').html('<i class="fa fa-chevron-down" aria-hidden="true"></i>');
            }
        }, 800);
        $('.xWNameSlider').toggleClass('xWshow');
    }
</script>