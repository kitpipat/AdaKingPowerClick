<script>
    $(function () {
        $("#ofmEditDayoff").validate({
            rules: {
                oetFDLdoDateFrm: "required"
            },
            messages: {
                oetFDLdoDateFrm: ""
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
                    url: "<?php echo base_url(); ?>EticketLocDayOffEditAjax",
                    data: $("#ofmEditDayoff").serialize(),
                    cache: false,
                    success: function (msg) {
                        var nDataId = $('.xWBtnSaveActive').data('id');
                        if (nDataId == '1') {
                            JSxCallPage('<?php echo base_url() ?>EticketLocDayOffEditNew/<?= $nLocID ?>/<?php echo $oEdit[0]->FNLdoID ?>');
                        } else if (nDataId == '2') {
                            JSxCallPage('<?= base_url() ?>EticketLocDayOffAddNew/<?php echo $nLocID; ?>');
                                                    } else if (nDataId == '3') {
                            JSxCallPage('<?php echo base_url() ?>EticketLocDayOffNew/<?php echo $nLocID; ?>');
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

                                    $('#oetFDLdoDateFrm').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                    $('#oetFDLdoDateTo').datetimepicker({
                                        format: 'DD-MM-YYYY HH:mm',
                                        locale: '<?php echo ($this->session->userdata("lang") == "cn" ? "zh-cn" : $this->session->userdata("lang")); ?>'
                                    });
                                });
</script>
        <div class="main-menu">
            <div class="xCNMrgNavMenu">
                <div class="row xCNavRow" style="width:inherit;">
                    <div class="xCNBchVMaster">
                        <div class="col-xs-8 col-md-8">
                            <ol id="oliMenuNav" class="breadcrumb">
                                <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url();?>/EticketBranchNew')"><?= language('ticket/park/park', 'tBranchInformation') ?></li>
                                <!-- <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocationNew/<?= $oHeader[0]->FNPmoID ?>/<?= $oHeader[0]->FTPmoName ?>')"><?= $oHeader[0]->FTPmoName ?></li> -->
                                <li  class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url() ?>EticketEditBranch/<?= $oHeader[0]->FNPmoID ?>')"><?= language('ticket/park/park', 'tEditPark') ?></li>
                                <li id="oliBCHTitle" class="xCNLinkClick" onclick="JSxCallPage('<?php echo base_url(); ?>EticketLocDayOffNew/<?= $nLocID ?>')"><?= language('ticket/location/location', 'tHolidayDeal') ?></li>
                                <li id="oliBCHTitle" class="xCNLinkClick"><?= language('ticket/dayoff/dayoff', 'tEditDayoff') ?></li>
                            </ol>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="main-content">
            <div class="panel panel-headline">
                <div style="padding:20px;">
                    <div class="row xWLocation" id="odvModelData" style="display: none;">
                        <div class="col-md-4">		
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
                            <img class="img-reponsive" src="<?= $tPatchImg; ?>">
                        </div>
                        <div class="col-md-4">
                            <div>
                                <b><?= $oHeader[0]->FTLocName ?></b> 
                                <br>
                                <div class="xWLocation-Detail">
                                    <?= language('ticket/zone/zone', 'tAmountLimit') ?>      <?php echo $oHeader[0]->FNLocLimit; ?> <?= language('ticket/zone/zone', 'tPersons') ?><br>
                                    <?= language('ticket/zone/zone', 'tOpeninghours') ?>      <?php echo $oHeader[0]->FTLocTimeOpening; ?> - <?php echo $oHeader[0]->FTLocTimeClosing; ?><br>      
                                    <?= language('ticket/zone/zone', 'tLocation') ?>            <?php if (@$oArea[0]->FTPvnName != ""): ?>          
                                        <?php foreach (@$oArea AS $aValue): ?>
                                            <?php echo $aValue->FTPvnName . ' - ' . $aValue->FTDstName; ?>
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
                            <div class="xWNameSlider xWshow"><?= $oHeader[0]->FTLocName ?></div>
                        </div>
                        <div class="col-md-6 col-xs-6 col-sm-6 text-right" onclick="JSxMODHidden()">
                            <span id="ospSwitchPanelModel">
                                <i class="fa fa-chevron-down" aria-hidden="true"></i>
                            </span>
                        </div>
                    </div>
                    <hr>    
                    <form action="" method="post" autocorrect="off" autocapitalize="off" autocomplete="off" id="ofmEditDayoff">
                        <div class="container-fluid">
                            <div class="row">
                                <div class="col-md-8">
                                    <h4 style="margin-bottom: 15px;">
                                        <?= language('ticket/dayoff/dayoff', 'tDayoff') ?> / <?= language('ticket/dayoff/dayoff', 'tEditDayoff') ?>
                                    </h4>
                                </div>
                                <div class="col-md-4 text-right">
                                    <button type="button" onclick="JSxCallPage('<?php echo base_url() ?>EticketLocDayOffNew/<?php echo $nLocID; ?>');" class="btn btn-default xCNBTNDefult"><?= language('common/main/main', 'tBack') ?></button>
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
                                <div class="col-md-6 col-sm-6 col-xs-12">
                                    <input type="hidden" name="ohdFNLdoID" id="ohdFNLdoID" value="<?php echo $oEdit[0]->FNLdoID ?>">

                                    <div class="form-group" style="width: 49%; float: left;">
                                        <label class="xCNLabelFrm"><?= language('ticket/dayoff/dayoff', 'tDayoffFrom') ?></label>
                                        <div class="input-group" data-validate="กรุณาใส่<?= language('ticket/dayoff/dayoff', 'tDayoffFrom') ?>">
                                            <input type="text" class="form-control" id="oetFDLdoDateFrm" name="oetFDLdoDateFrm" value="<?php echo ($oEdit[0]->FDLdoDateFrm == "" ? '' : date("d-m-Y H:i", strtotime($oEdit[0]->FDLdoDateFrm))); ?>">
                                            <span class="input-group-btn">
                                                <button id="obtBchFDLdoDateFrm" type="button" class="btn xCNBtnDateTime">
                                                    <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div class="form-group" style="width: 49%; float: left;">
                                        <label class="xCNLabelFrm"><?= language('ticket/dayoff/dayoff', 'tDayoffTo') ?></label>
                                        <div class="input-group" data-validate="กรุณาใส่<?= language('ticket/dayoff/dayoff', 'tDayoffTo') ?>">
                                            <input type="text" class="form-control" id="oetFDLdoDateTo" name="oetFDLdoDateTo" value="<?php echo ($oEdit[0]->FDLdoDateTo == "" ? '' : date("d-m-Y H:i", strtotime($oEdit[0]->FDLdoDateTo))); ?>">
                                            <span class="input-group-btn">
                                                <button id="obtBchFDLdoDateTo" type="button" class="btn xCNBtnDateTime">
                                                    <img src="<?=base_url();?>application/modules/common/assets/images/icons/icons8-Calendar-100.png">
                                                </button>
                                            </span>
                                        </div>
                                    </div>

                                    <div style="clear: both;"></div>
                                    <div class="form-group">
                                        <span class="label-input100"><?= language('ticket/zone/zone', 'tRemarks') ?></span>
                                        <textarea class="form-control" maxlength="100" name="otaFTLdoRmk"><?php echo $oEdit[0]->FTLdoRmk ?></textarea>
                                        <span class="focus-input100"></span>
                                    </div>	
                                </div>
                                <div class="col-md-6 col-sm-6 col-xs-12"></div>
                            </div>
                        </div>
                    </form>   
                </div>
            </div>
        </div>   
<input type="hidden" value="<?php echo $nLocID; ?>" id="ohdGetLocID">
<script>

    $('#obtBchFDLdoDateFrm').click(function(){
		event.preventDefault();
        $('#oetFDLdoDateFrm').datetimepicker('show');
    });

    $('#obtBchFDLdoDateTo').click(function(){
		event.preventDefault();
        $('#oetFDLdoDateTo').datetimepicker('show');
    });

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