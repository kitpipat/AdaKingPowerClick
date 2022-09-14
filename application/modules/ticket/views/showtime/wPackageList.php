<div class="row">
    <div class="xCNBCMenu xWHeaderMenu">
        <div class="row">
            <div class="col-md-12">
                <span onclick="JSxCallPage('<?php echo base_url(); ?>/EticketEvent')"><?= language('ticket/event/event', 'tEventInformation') ?></span> / <span onclick="JSxCallPage('<?php echo base_url(); ?>/EticketShowTime/<?php echo $nEvnID; ?>')"><?= language('ticket/event/event', 'tManageEvents') ?></span> / รายการแพ็คเกจ
            </div>
        </div>
    </div>
    <div class="row xWLocation" id="odvModelData" style="display: none;">
        <div class="col-md-3">		
            <!-- <?php if ($oEvent[0]->FTImgObj != ""): ?>
                <img class="img-reponsive" src="<?= base_url() ?><?= $oEvent[0]->FTImgObj ?>">
            <?php else : ?>
                <img class="img-reponsive"	src="<?php echo base_url('application/modules/common/assets/images/Noimage.png'); ?>">
            <?php endif ?> -->
            <?php if(isset($oEvent->FTImgObj) && !empty($oEvent->FTImgObj)){
                    $tFullPatch = './application/modules/'.$oEvent->FTImgObj;
                    if (file_exists($tFullPatch)){
                        $tPatchImgEvn = base_url().'/application/modules/'.$oEvent->FTImgObj;
                    }else{
                        $tPatchImgEvn = base_url().'application/modules/common/assets/images/Noimage.png';
                    }
                }else{
                    $tPatchImgEvn = base_url().'application/modules/common/assets/images/Noimage.png';
                }
                ?>
                <img class="img-reponsive" src="<?=$tPatchImgEvn?>" style="width:200px;height:144px;">
        </div>
        <div class="col-md-5">
            <div>
                <b>
                    <?php if (@$oEvent[0]->FTEvnName): ?>
                        <?= $oEvent[0]->FTEvnName ?>
                    <?php else: ?>
                        <?= language('ticket/zone/zone', 'tNoData') ?>
                    <?php endif; ?>
                </b> 
                <br>
                <div class="xWLocation-Detail">
                    <?= $oEvent[0]->FTEvnDesc1 ?><br>
                    <?= date("Y-m-d H:i", strtotime($oEvent[0]->FDEvnStart)) ?> - <?= date("Y-m-d H:i", strtotime($oEvent[0]->FDEvnFinish)) ?><br>           
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-md-6 col-xs-6 col-sm-6">
            <div class="xWNameSlider xWshow"><?= @$oEvent[0]->FTEvnName ?></div>
        </div>
        <div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
            <span id="ospSwitchPanelModel">
                <i class="fa fa-chevron-down" aria-hidden="true"></i>
            </span>
        </div>
    </div>
    <hr>
    <div class="xWwrapBox">	
        <div class="row">
            <div class="col-md-12">
                <h4>
                    <?= language('ticket/event/event', 'tPackageList') ?>
                </h4>
            </div>
        </div>
        <hr style="border-bottom: 1px solid #eee; background-image: none;">
        <div>    	
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th style="width: 50px;"><?= language('ticket/event/event', 'tNo') ?></th>
                        <th><?= language('ticket/event/event', 'tName') ?></th>
                    </tr>
                </thead>
                <tbody>				
                    <?php foreach ($oPackageList AS $key => $oValue): ?>
                        <?php $tNumber = $key + 1; ?>
                        <tr>
                            <td scope="row"><?php echo $tNumber; ?></td>
                            <td>
                                <?php echo $oValue->FTPkgName; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>					
                </tbody>
            </table>
        </div>
    </div>	
</div>
<input type="hidden" value="<?php echo $nEvnID; ?>" id="ohdGetEventId">
<script>
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