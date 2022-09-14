<script>
    $(function () {
        /**
         * validate เพิ่มโซน
         */
        $("#oFmEditZone").validate({
            rules: {
                oetFTZneName: "required"
            },
            messages: {
                oetFTZneName: ""
            },
            errorClass: "alert-validate",
            validClass: "",
            highlight: function (element, errorClass, validClass) {
                $(element).parent('.validate-input').addClass(errorClass).removeClass(validClass);
                $(element).parent().parent('.validate-input').addClass(errorClass).removeClass(validClass);
            },
            unhighlight: function (element, errorClass, validClass) {
                $(element).parent('.validate-input').removeClass(errorClass).addClass(validClass);
                $(element).parent().parent('.validate-input').removeClass(errorClass).addClass(validClass);
            },
            submitHandler: function (form) {
                $('button[type=submit]').attr('disabled', true);
                $('.xCNOverlay').show();
                $.ajax({
                    type: "POST",
                    url: "<?php echo base_url(); ?>EticketEditZoneAjax",
                    data: $("#oFmEditZone").serialize(),
                    cache: false,
                    success: function (msg) {
                        var nDataId = $('.xWBtnSaveActive').data('id');
                        if (nDataId == '1') {
                            JSxCallPage('<?php echo base_url() ?>EticketEditZoneNew/<?php echo $nLocID; ?>/<?= $nZneID ?>/?FNStaSeat=0');
                        } else if (nDataId == '2') {
                            JSxCallPage('<?= base_url() ?>EticketAddZoneNew/<?php echo $nLocID; ?>');
                                                    } else if (nDataId == '3') {
                                                        JSxCallPage('<?php echo base_url() ?>EticketZoneNew/<?php echo $nLocID; ?>');
                                                                                }
                                                                                $('.xCNOverlay').hide();
                                                                            },
                                                                            error: function (data) {
                                                                                console.log(data);
                                                                                $('.xCNOverlay').hide();
                                                                            }
                                                                        });
                                                                        return false;
                                                                    }
                                                                });
                                                                $('[title]').tooltip();
                                                                $('.selection-2').select2();
                                                            });
</script>
        <div class="main-menu">
            <div class="xCNMrgNavMenu">
                <div class="row xCNavRow" style="width:inherit;">
                    <div class="xCNBchVMaster">
                        <div class="col-xs-8 col-md-8">
                            <ol id="oliMenuNav" class="breadcrumb">
                                <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>/EticketBranchNew')"><?= language('ticket/park/park', 'tBranchInformation') ?></li>
<<<<<<< HEAD
                                <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>/<?= $oHeader[0]->FTBchName ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li>
=======
                                <!-- <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>/<?= $oHeader[0]->FTBchName ?>')"><?= language('ticket/zone/zone', 'tManagelocations') ?></li> -->
                                <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li> 
>>>>>>> 81bf17ac4472cccb47e9b8a7fad9daddc4181c76
                                <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketZoneNew/<?php echo $nLocID; ?>')"><?= language('ticket/zone/zone', 'tZoneInformation') ?></li>
                                <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/zone/zone', 'tEditZone') ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        
        <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="oFmEditZone"> 
            <div class="main-content">
                <div class="panel panel-headline">
                    <div style="padding:20px;">
                        <div class="row">
                            <div class="col-md-8">
                            </div>
                            <div class="col-md-4 text-right">
                                <button type="button" onclick="JSxCallPage('<?php echo base_url() ?>EticketZoneNew/<?php echo $nLocID; ?>')" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
                                <div class="btn-group">
                                    <button class="btn btn-default xWBtnGrpSaveLeft" type="submit"><?= language('ticket/user/user', 'tSave') ?></button>
                                    <button type="button" class="btn btn-default xWBtnGrpSaveRight dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <span class="caret"></span>
                                        <span class="sr-only">Toggle Dropdown</span>
                                    </button>
                                    <ul class="dropdown-menu xWDrpDwnMenuMargLft">
                                        <li class="xWolibtnsave1 xWBtnSaveActive" data-id="1" onclick="JSvChangeBtnSaveAction(1)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndView') ?></a></li>
                                        <li class="xWolibtnsave2" data-id="2" onclick="JSvChangeBtnSaveAction(2)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndNew') ?></a></li>
                                        <li class="xWolibtnsave3" data-id="3" onclick="JSvChangeBtnSaveAction(3)"><a href="#"><?= language('common/main/main', 'tCMNSaveAndBack') ?></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>			
                        <div class="row">
                            <div class="col-md-4 col-sm-4 col-xs-12">
                                <div class="upload-img" id="oImgUpload">
                                    <?php if (isset($oShow[0]->FTImgObj) && !empty($oShow[0]->FTImgObj)): ?>
                                        <a href="javascript:void(0)" id="oDelImgZone"  onclick="JSxZNEDelImg('<?php echo $oShow[0]->FNZneID; ?>', '<?php echo $oShow[0]->FTImgObj; ?>', '<?= language('ticket/center/center', 'Confirm') ?>')" style="border: 0 !important; position: absolute; right: 5px; top: 5px;"><i class="fa fa-times" style="color: red; font-size: 18px;"></i></a>
                                    <?php endif; ?>		
                                    <?php
                                        if(isset($oShow[0]->FTImgObj) && !empty($oShow[0]->FTImgObj)){
                                            $tFullPatch = './application/modules/'.$oShow[0]->FTImgObj;
                                            if (file_exists($tFullPatch)){
                                                $tPatchImg = base_url().'/application/modules/'.$oShow[0]->FTImgObj;
                                            }else{
                                                $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                            }
                                        }else{
                                            $tPatchImg = base_url().'application/modules/common/assets/images/Noimage.png';
                                        }
                                    ?>
                                    <img src="<?= $tPatchImg; ?>" style="width: 100%;" id="oimImgMasterMain" class="xWimageZone">
                                    <span class="btn-file">
                                        <input type="hidden" name="ohdZoneImg" id="oetImgInputMain">
                                    </span>
                                </div>
                                <div class="xCNUplodeImage">
                                    <button type="button" class="btn xCNBTNDefult" onclick="JSvImageCallTempNEW('', '', 'Main','16/8')"><i class="fa fa-camera"></i> <?= language('ticket/park/park', 'tSelectPhoto') ?></button>
                                </div>
                            </div>
                            <div class="col-md-8 col-sm-8 col-xs-12">
                                <input type="hidden" name="oetHDFNZneID" id="oetHDFNZneID" value="<?= $nZneID ?>">								
                                <div class="form-group" data-validate="กรุณาใส่<?= language('ticket/zone/zone', 'tNameZone') ?>">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tNameZone') ?></label>
                                    <input type="text" class="form-control xCNInputWithoutSingleQuote" id="oetFTZneName" name="oetFTZneName" value="<?= $oShow[0]->FTZneName ?>">
                                </div>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/location/location', 'tLevel') ?></label>
                                    <select class="selectpicker form-control" id="ocmFNLevID" name="ocmFNLevID" title="<?= language('ticket/location/location', 'tLevel') ?>">
                                        <?php if (@$oLev[0]->FNLevID == ""): ?>
                                            <!-- <option value="">ไม่พบชั้น</option>--> 
                                        <?php else: ?> 
                                            <option value=""><?= language('ticket/zone/zone', 'tSelectlevel') ?></option>
                                            <?php foreach ($oLev as $key => $tValue) : ?>
                                                <option value="<?= $tValue->FNLevID ?>" <?php
                                                if ($oShow[0]->FNLevID == $tValue->FNLevID) {
                                                    echo 'selected="selected"';
                                                }
                                                ?>><?= $tValue->FTLevName ?></option>
                                                    <?php endforeach; ?>
                                        <?php endif; ?> 
                                    </select>
                                </div>

                                <?php if (@$oShow[0]->FTZneBookingType == '2' || @$oShow[0]->FTZneBookingType == '3') : ?>
                                <?php else : ?>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tZoneRow') ?></label>
                                        <input type="text" class="form-control xCNInputWithoutSingleQuote" <?php
                                            if (@$_GET['FNStaSeat'] == "1") {
                                                echo "disabled";
                                            }
                                            ?> value="<?= $oShow[0]->FNZneRow ?>" id="oetFNZneRow" name="oetFNZneRow">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tSeatsAmount') ?></label>
                                        <input type="number" min="0" class="form-control xCNInputWithoutSingleQuote" <?php
                                            if (@$_GET['FNStaSeat'] == "1") {
                                                echo "disabled";
                                            }
                                            ?> value="<?= $oShow[0]->FNZneCol ?>" id="oetFNZneCol" name="oetFNZneCol">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tRowCountStartingFrom') ?></label>
                                        <input type="number" min="0" class="form-control xCNInputWithoutSingleQuote" <?php
                                            if (@$_GET['FNStaSeat'] == "1") {
                                                echo "disabled";
                                            }
                                            ?> value="<?= $oShow[0]->FNZneRowStart ?>" id="oetFNZneRowStart" name="oetFNZneRowStart">
                                    </div>

                                    <div class="form-group">
                                        <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tSeatingCountStartingFrom') ?></label>
                                        <input type="number" min="0" class="form-control xCNInputWithoutSingleQuote" <?php
                                            if (@$_GET['FNStaSeat'] == "1") {
                                                echo "disabled";
                                            }
                                            ?> value="<?= $oShow[0]->FNZneColStart ?>" id="oetFNZneColStart" name="oetFNZneColStart">
                                    </div>	

                                <?php endif; ?>

                                <div class="form-group">
                                    <label class="xCNLabelFrm"><?= language('ticket/zone/zone', 'tRemarks') ?></label>
                                    <textarea class="form-control" name="otaFTZneRmk"><?= $oShow[0]->FTZneRmk ?></textarea>
                                </div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>      
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
<script>

    $('.selectpicker').selectpicker();

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