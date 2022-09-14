    <div class="row">
        <div class="xCNBCMenu xWHeaderMenu">
            <div class="row">
                <div class="col-md-12">
                    <span onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranch')"><?= language('ticket/park/park', 'tBranchInformation') ?></span> / <span onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocation/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></span> / <?= language('ticket/location/location', 'tLayoutInformation') ?>
                </div>
            </div>
        </div>
        <div class="main-content" style="padding-bottom: 0;">
            <div class="container-fluid">
                <div class="row xWLocation" id="odvModelData">
                    <div class="col-md-3">		
                        <?php
                            if(isset($oHeader[0]->FTImgObj) && !empty($oHeader[0]->FTImgObj)){
                                $tFullPatch = './application/modules/common/assets/system/systemimage/'.$oHeader[0]->FTImgObj;
                                if (file_exists($tFullPatch)){
                                    $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oHeader[0]->FTImgObj;
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            }else{
                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                            }
                        ?>
                        <img class="img-reponsive" style="width: 100%;" src="<?= $tPatchImg; ?>">
                    </div>
                    <div class="col-md-5">
                        <div>
                            <b>
                                <?php if ($oHeader[0]->FTLocName): ?>
                                    <?= $oHeader[0]->FTLocName ?>
                                <?php else: ?>
                                    <?= language('ticket/zone/zone', 'tNoData') ?>
                                <?php endif; ?>
                            </b> 
                            <br>
                            <div class="xWLocation-Detail">
                                <?= language('ticket/zone/zone', 'tLocation') ?>            <?php if (@$oArea[0]->FTPvnName != ""): ?>          
                                    <?php foreach (@$oArea AS $aValue): ?>
                                        <?php echo $aValue->FTDstName . ' - ' . $aValue->FTPvnName; ?>
                                        <br>
                                    <?php endforeach; ?>
                                <?php endif; ?>
                                <br>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-6 col-xs-6 col-sm-6">
                        <div class="xWNameSlider" style="display: none;"><?= $oHeader[0]->FTLocName ?></div>
                    </div>
                    <div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
                        <span id="ospSwitchPanelModel">
                            <i class="fa fa-chevron-up" aria-hidden="true"></i>
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="main-content">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">				
                        <h4>
                            <?= language('ticket/location/location', 'tManageLayout') ?>
                        </h4>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div id="oResult">
            <div class="main-content">
                <div class="container-fluid">
                    <div class="row xWLocation">
                        <div class="col-md-2">
                            <?php
                                if(isset($oLayoutImg[0]->FTImgObj) && !empty($oLayoutImg[0]->FTImgObj)){
                                    $tFullPatch = './application/modules/common/assets/system/systemimage/'.$oHeader[0]->FTImgObj;
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/common/assets/system/systemimage/'.$oHeader[0]->FTImgObj;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            ?>
                            <?php if (@$oLayoutImg[0]->FTImgObj != ""): ?>
                                <a href="javascript:void(0)" id="oDelImgLayout" onclick="JSxLayoutDelImg('<?= $oLayoutImg[0]->FNImgID ?>', '<?= base_url() ?><?= $oLayoutImg[0]->FTImgObj ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 21px; top: 0px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>    
                            <?php endif; ?>	
                            <img class="img-reponsive" style="width: 100%;" src="<?php echo $tPatchImg; ?>" id="oimImgMasterMain">
                        </div>
                        <div class="col-md-4">
                            <b><?= language('ticket/location/location', 'tLayout') ?></b>
                        </div>
                        <div class="col-md-6">
                            <div style="text-align: right">	
                                <?php if ($oAuthen['tAutStaEdit'] == '1'): ?>
                                    <input type="hidden" name="ohdLOTImg" id="oetImgInputMain">                                    
                                    <?php if (@$oLayoutImg[0]->FTImgObj == ""): ?>
                                        <button class="btn btn-default xCNBTNPrimery btn-edited" onclick="JSvImageCallTempNEW('', '', 'Main', '16/9')"><?= language('common/main/main', 'tAdd') ?></button>
                                    <?php else: ?>
                                        <button class="btn btn-default xCNBTNPrimery btn-edited" onclick="JSvImageCallTempNEW('', '', 'Main', '16/9')"><?= language('common/main/main', 'tEdit') ?></button>
                                    <?php endif; ?>
                                    <button class="btn btn-default xCNBTNPrimery btn-saved" style="display: none" onclick="FSxAddImgLayout()"><?= language('common/main/main', 'tSave') ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>	
                </div>	
            </div>	
            <hr>
        </div>   
    </div>
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
<script>
    $(document).on('hidden.bs.modal', '#odlModalTempImgMain', function () {
        if ($('#oetImgInputMain').val() != '') {
            $('.btn-saved').show();
            $('.btn-edited').hide();
        }
    });
    function FSxAddImgLayout() {
        $('.xCNOverlay').show();
        $.ajax({
            type: "POST",
            url: "EticketLayoutAdd/<?php echo $nLocID; ?>",
            data: {
                ohdLOTImg: $('#oetImgInputMain').val()
            },
            cache: false,
            success: function (oData) {
                JSxCallPage('<?= base_url() ?>EticketLayout/<?php echo $nLocID; ?>');
                                $('.obtChoose').hide();                                
                                $('.xCNOverlay').hide();
                            },
                            error: function (data) {
                                console.log(data);
                                $('.obtChoose').hide();
                            }
                        });
                    }
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
                    function JSxLOTDelImg(nImgID, tImgObj, tMsg) {
                        if (confirm(tMsg) == true) {
                            $.ajax({
                                type: "POST",
                                url: "DelImgLoc",
                                data: {
                                    tImgID: nImgID,
                                    tNameImg: tImgObj,
                                },
                                cache: false,
                                success: function (msg) {
                                    JSxCallPage('<?= base_url() ?>EticketLayout/<?php echo $nLocID; ?>');
                                                        $('.xCNOverlay').hide();
                                                    },
                                                    error: function (data) {
                                                        console.log(data);
                                                        $('.xCNOverlay').hide();
                                                    }
                                                });
                                            }
                                            return false;
                                        }
                                        function JSxLayoutDelImg(nImgID, tImgObj, tMsg) {
                                            bootbox.confirm({
                                                title: aLocale['tConfirmDelete'],
                                                message: tMsg,
                                                buttons: {
                                                    cancel: {
                                                        label: '<i class="fa fa-times-circle" aria-hidden="true"></i> ' + aLocale['tBtnClose'],
                                                        className: 'xCNBTNDefult'
                                                    },
                                                    confirm: {
                                                        label: '<i class="fa fa-check-circle" aria-hidden="true"></i> ' + aLocale['tBtnConfirm'],
                                                        className: 'xCNBTNPrimery'
                                                    }
                                                },
                                                callback: function (result) {
                                                    if (result == true) {
                                                        $.ajax({
                                                            type: "POST",
                                                            url: "EticketLayoutDelImg",
                                                            data: {
                                                                tImgID: nImgID,
                                                                tNameImg: tImgObj
                                                            },
                                                            cache: false,
                                                            success: function (msg) {
                                                                JSxCallPage('<?= base_url() ?>EticketLayout/<?php echo $nLocID; ?>');
                                                                $('#oimImgMasterMain').attr("src", "application/modules/common/assets/images/Noimage.png");
                                                                $('#oDelImgLayout').hide();
                                                            },
                                                            error: function (data) {
                                                                console.log(data);
                                                            }
                                                        });
                                                    }
                                                }
                                            });
                                        }
</script>