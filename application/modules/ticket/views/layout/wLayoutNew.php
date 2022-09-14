    <div class="main-menu">
        <div class="xCNMrgNavMenu">
            <div class="row xCNavRow" style="width:inherit;">
                <div class="xCNBchVMaster">
                    <div class="col-xs-8 col-md-8">
                        <ol id="oliMenuNav" class="breadcrumb">
                            <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')" ><?= language('ticket/park/park', 'tBranchInformation') ?></li>
                            <!-- <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li> -->
                            <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
                            <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/location/location', 'tLayoutInformation') ?></li>
                        </ol>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="main-content" style="padding-bottom: 0;">
        <div class="panel panel-headline">
            <div style="padding:20px;">
                <div class="container-fluid">
                    <div class="row xWLocation" id="odvModelData">
                        <div class="col-md-3">		
                            <?php
                                if(isset($oHeader[0]->FTImgObj) && !empty($oHeader[0]->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$oHeader[0]->FTImgObj;
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$oHeader[0]->FTImgObj;
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
            
                <hr>

                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">				
                            <h4>
                                <?= language('ticket/location/location', 'tManageLayout') ?>
                            </h4>
                        </div>
                    </div>
                </div>
                <hr>

                <div id="oResult">
                    <div class="row xWLocation">
                        <div class="col-md-2">
                            <?php if (isset($oLayoutImg[0]->FTImgObj) && !empty($oLayoutImg[0]->FTImgObj)): ?>
                                <a href="javascript:void(0)" id="oDelImgLayout" onclick="JSxLayoutDelImg('<?= $oLayoutImg[0]->FTImgRefID ?>', '<?= base_url() ?><?= $oLayoutImg[0]->FTImgObj ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 21px; top: 0px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>    
                            <?php endif; ?>	

                            <?php
                                if(isset($oLayoutImg[0]->FTImgObj) && !empty($oLayoutImg[0]->FTImgObj)){
                                    $tFullPatch = './application/modules/'.$oLayoutImg[0]->FTImgObj;
                                    if (file_exists($tFullPatch)){
                                        $tPatchImg = base_url().'/application/modules/'.$oLayoutImg[0]->FTImgObj;
                                    }else{
                                        $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                    }
                                }else{
                                    $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                }
                            ?>	

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
                                        <button class="xCNBTNPrimeryPlus btn-edited" onclick="JSvImageCallTempNEW('', '', 'Main', '16/9')">+</button>
                                    <?php else: ?>
                                        <button class="btn btn-default xCNBTNPrimery btn-edited" onclick="JSvImageCallTempNEW('', '', 'Main', '16/9')"><?= language('common/main/main', 'tEdit') ?></button>
                                    <?php endif; ?>
                                        <button class="btn btn-default xCNBTNPrimery btn-saved" style="display: none" onclick="FSxAddImgLayout()"><?= language('common/main/main', 'tSave') ?></button>
                                <?php endif; ?>
                            </div>
                        </div>
                    </div>	
                    <hr>
                </div> 
            </div>
        </div>
    </div>

<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">

<!-- Load Lang Eticket -->
<?php if ($_SESSION['lang'] == 'en'):?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jEN.js"></script>
<?php else:?>
<script src="<?=base_url()?>application/modules/ticket/assets/src/locales/jTH.js"></script>
<?php endif?>

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
            url: "EticketLayoutAddNew/<?php echo $nLocID; ?>",
            data: {
                ohdLOTImg: $('#oetImgInputMain').val()
            },
            cache: false,
            success: function (oData) {
                JSxCallPage('<?= base_url() ?>EticketLayoutNew/<?php echo $nLocID; ?>');
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
                                    JSxCallPage('<?= base_url() ?>EticketLayoutNew/<?php echo $nLocID; ?>');
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
                                confirm: {
                                    label: aLocale['tBtnClose'],
                                    className: 'xCNBTNDefult'
                                },
                                cancel: {
                                    label: aLocale['tBtnConfirm'],
                                    className: 'xCNBTNPrimery'
                                }

                            },
                            callback: function (result) {
                                if (result == false) {
                                    $.ajax({
                                        type: "POST",
                                        url: "EticketLayoutDelImg",
                                        data: {
                                            tImgID: nImgID,
                                            tNameImg: tImgObj
                                        },
                                        cache: false,
                                        success: function (msg) {
                                            JSxCallPage('<?= base_url() ?>EticketLayoutNew/<?php echo $nLocID; ?>');
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